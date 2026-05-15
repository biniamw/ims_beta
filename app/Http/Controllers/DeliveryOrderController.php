<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\customer;
use App\Models\delivery_order;
use App\Models\delivery_order_detail;
use App\Models\Regitem;
use App\Models\conversion;
use App\Models\Sales;
use App\Models\SalesOrder;
use App\Models\Proforma;
use App\Models\ProformaItem;
use App\Models\Salesitem;
use App\Models\SalesOrderItems;
use App\Models\actions;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Exception;
use Response;
use Carbon\Carbon;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $currentdate = Carbon::today()->toDateString();
        $station_src = DB::select('SELECT * FROM stores WHERE stores.id>1 AND stores.ActiveStatus="Active" ORDER BY stores.Name ASC');
        $customer_src = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.CustomerCategory IN("Customer","Customer&Supplier") AND customers.ActiveStatus="Active" AND customers.id>2 ORDER BY customers.Name ASC LIMIT 50');
        $uses_data = DB::select('SELECT * FROM users WHERE id>1 ORDER BY users.username ASC');
        $ref_type_data = DB::select('SELECT * FROM lookuprefs WHERE lookuprefs.Type=200 AND lookuprefs.Status=1 ORDER BY lookuprefs.LookupName ASC'); 
        $itemSrcs = DB::select('SELECT regitems.id,regitems.Type,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items FROM regitems WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND regitems.IsDeleted=1 ORDER BY regitems.Name ASC');
        $fiscalyears = DB::select('SELECT * FROM fiscalyear WHERE fiscalyear.FiscalYear<='.$fyear.' ORDER BY fiscalyear.FiscalYear DESC');

        $delivery_data = [
            'fiscalyr' => $fyear,'curdate' => $currentdate,'station_src' => $station_src,
            'customer_src' => $customer_src,'uses_data' => $uses_data,'ref_type_data' => $ref_type_data,
            'itemSrcs' => $itemSrcs,'fiscalyears' => $fiscalyears
        ];

        if($request->ajax()) {
            return view('sales.deliveryorder',$delivery_data)->renderSections()['content'];
        }
        else{
            return view('sales.deliveryorder',$delivery_data);
        }
    }

    public function showDOData($fiscalyr){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $users = Auth()->user();
        $do_data_list = DB::select('SELECT delivery_orders.*,customers.Name AS customer_name,customers.TinNumber AS TIN, customers.Code AS customer_code,stores.Name AS store_name,lookuprefs.LookupName AS reference_types,COALESCE(sales.VoucherNumber,sales_orders.docno,proformas.DocumentNumber) as reference_no FROM delivery_orders LEFT JOIN customers ON delivery_orders.customers_id=customers.id LEFT JOIN stores ON delivery_orders.station=stores.id LEFT JOIN lookuprefs ON delivery_orders.reference_type=lookuprefs.id LEFT JOIN sales ON delivery_orders.reference_id=sales.id AND delivery_orders.reference_type=603 LEFT JOIN sales_orders ON delivery_orders.reference_id=sales_orders.id AND delivery_orders.reference_type=602 LEFT JOIN proformas ON delivery_orders.reference_id=proformas.id AND delivery_orders.reference_type=601 WHERE delivery_orders.fiscal_year='.$fiscalyr.' ORDER BY delivery_orders.id DESC');
        if(request()->ajax()) {
            return datatables()->of($do_data_list)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function store(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $findid = $request->recordId;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'ReferenceType' => ['required'],
            'Reference' => ['required_if:ReferenceType,601,602,603'],
            'ProductType' => ['required'],
            'station' => ['required'],

            'DeliveryDate' => ['required'],
            'ExpiryDate' => ['required'],
            'OrderedBy' => ['required'],
            'SalesPerson' => ['required'],

            'PaymentType' => ['required_if:ReferenceType,600'],
            'PaymentTerm' => ['required_if:ReferenceType,600'],
            
            'customer' => ['required'],
        ]);

        $rules = array(
            'row.*.ItemId' => 'required',
            'row.*.Quantity' => 'required|gt:0',
            'row.*.UnitPrice' => 'required_if:VisiblePrice,true,1,on,yes',
        );
        $v2 = Validator::make($request->all(), $rules);

        if($validator->passes() && $v2->passes() && $request->row != null){
            DB::beginTransaction();
            try{
                $submitted_ids = [];
                $reference_type = $request->ReferenceType ?? 0;
                $reference_id_val = $request->Reference ?? 0;
                $reference_data = null;
                $do_detail_rec_id = null;
                $total_price = 0;
                $DbData = delivery_order::where('id', $request->recordId)->first();
                $document_number =  $this->generateDocumentNumberFn($fyear, $request->recordId);
                preg_match('/-(\d+)\//', $document_number, $matches); 
                $current_doc_number = intval($matches[1] ?? 0);

                $basic_data = [
                    'reference_type' => $request->ReferenceType,
                    'reference_id' => $request->Reference,
                    'product_type' => $request->ProductType,
                    'station' => $request->station,
                    'delivery_date' => $request->DeliveryDate,
                    'expiry_date' => $request->ExpiryDate,
                    'order_by' => $request->OrderedBy,
                    'sales_person' => $request->SalesPerson,
                    'supporting_doc_no' => $request->DocumentNumber,
                    'payment_type' => $request->PaymentType,
                    'payment_term' => $request->PaymentTerm,
                    'show_pricing' => $request->has('VisiblePrice'),
                    'customers_id' => $request->customer,
                    'delivery_by' => $request->DeliverBy,
                    'phone_no' => $request->PhoneNumber,
                    'id_no' => $request->IdNumber,
                    'plate_no' => $request->PlateNumber,
                    'total_price' => 0,
                    'fiscal_year' => $fyear,
                    'remark' => $request->Remark ?? "",
                ];

                $permanent_data = [
                    'document_number' => $document_number,
                    'current_document_no' => $current_doc_number,
                    'status' => "Draft",
                    'status_old' => "",
                    'prepared_by' => $user,
                    'prepared_date' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'created_at' => Carbon::now()
                ];

                $update_data = [
                    'updated_at' => Carbon::now()
                ];

                $delivery_order = delivery_order::updateOrCreate(
                    ['id' => $request->recordId], 
                    array_merge($basic_data, $DbData ? $update_data : $permanent_data)
                );

                foreach ($request->row as $key => $value){
                    $item_id = $value['ItemId'];
                    $quantity = $value['Quantity'];
                    $total_price += $value['TotalPrice'] ?? 0;

                    $item_prop = Regitem::where('id', $item_id)->first();
                    $default_uom = $item_prop->MeasurementId;
                    $new_uom = $value['uom'] ?? $default_uom;
                    $conversion_factor = 1;
                    $serial_qty = 0;
                    $converted_qty = $quantity;

                    if($default_uom != $new_uom){
                        $conversion_data = conversion::where('FromUomID',$default_uom)->where('ToUomID',$new_uom)->first();
                        $conversion_factor = $conversion_data->Amount;
                        $converted_qty = round(($quantity / $conversion_factor),2);
                    }

                    if($reference_type == 601){
                        $reference_data = ProformaItem::where('proforma_id',$reference_id_val)->where('regitem_id',$item_id)->first();
                    }
                    else if($reference_type == 602){
                        $reference_data = SalesOrderItems::where('sales_order_id',$reference_id_val)->where('regitem_id',$item_id)->first();
                    }
                    else if($reference_type == 603){
                        $reference_data = Salesitem::where('HeaderId',$reference_id_val)->where('ItemId',$item_id)->first();
                    }
                    $do_detail_rec_id = $reference_data->id ?? 0;
    
                    $del_detail_db_data = delivery_order_detail::where('delivery_order_id',$delivery_order->id)->where('regitems_id',$value['ItemId'])->first();
                    $ent_quantity = $del_detail_db_data->entered_quantity ?? 0;

                    if($item_prop->RequireSerialNumber == "Required"){
                        $serial_qty = $del_detail_db_data->entered_serial_qty ?? 0;
                    }
                    else if($item_prop->RequireSerialNumber == "Not-Require"){
                        $serial_qty = $quantity;
                    }

                    $do_detail_permanent_data = [
                        'regitems_id' => $item_id,
                        'quantity' => $quantity,
                        'unit_price' => $value['UnitPrice'] ?? 0,
                        'total_price' => $value['TotalPrice'] ?? 0,
                        'default_uom' => $default_uom,
                        'new_uom' => $new_uom,
                        'converted_quantity' => $converted_qty,
                        'reference_detail_id' => $do_detail_rec_id,
                        'remark' => $value['remark'],
                    ];

                    $do_detail_created_data = [
                        'delivery_order_id' => $delivery_order->id,
                        'is_fully_entered' => 0,
                        'created_at' => Carbon::now()
                    ];

                    $do_detail_edited_data = [
                        'is_fully_entered' => ($quantity == $ent_quantity && $quantity == $serial_qty) ? 1 : 0,
                        'updated_at' => Carbon::now()
                    ];

                    $delivery_order_detail = delivery_order_detail::updateOrCreate([
                        'delivery_order_id' => $delivery_order->id,
                        'regitems_id' => $item_id,
                    ], 
                        array_merge($do_detail_permanent_data, $del_detail_db_data ? $do_detail_edited_data : $do_detail_created_data)
                    );

                    $this->updateIssuedQtyFn($delivery_order->id,$reference_id_val,$reference_type,$do_detail_rec_id);
                }

                DB::table('delivery_orders')->where('delivery_orders.id',$delivery_order->id)->update(['delivery_orders.total_price' => $total_price]);

                $actions = $findid == null ? "Created" : "Edited";

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $delivery_order->id,
                    'pagename' => "delivery_order",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'fiscal_year' => $fyear,'rec_id' => $delivery_order->id]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
        else if($v2->fails()){
            return response()->json(['errorv2' => $v2->errors()->all()]);
        }
        else if($request->row == null){
            return Response::json(['empty_table' => 460]);
        }
    }

    public function fetchReferenceDoc(Request $request){
        $reference_type = $_POST['reference_type'];
        $proforma_invoice_data = "";
        $sales_order_data = "";
        $sales_invoice_data = "";

        if($reference_type == 601){
            $proforma_invoice_data = DB::select('SELECT proformas.id AS proforma_id,customers.id AS customer_id,CONCAT_WS(", ", NULLIF(proformas.DocumentNumber,""),NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS proforma_data FROM proformas LEFT JOIN customers ON proformas.CustomerId=customers.id WHERE proformas.Status="Pass" ORDER BY proformas.id DESC');
        }
        else if($reference_type == 602){
            $sales_order_data = DB::select('SELECT sales_orders.id AS sales_id,customers.id AS customer_id,CONCAT_WS(", ", NULLIF(sales_orders.docno, ""),NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS sales_data FROM sales_orders LEFT JOIN customers ON sales_orders.customer_id=customers.id WHERE sales_orders.status=8 ORDER BY sales_orders.id DESC');
        }
        else if($reference_type == 603){
            $sales_invoice_data = DB::select('SELECT sales.id AS sales_id,customers.id AS customer_id,CONCAT_WS(", ", NULLIF(sales.VoucherNumber, ""), NULLIF(sales.invoiceNo, ""), NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS sales_data FROM sales LEFT JOIN customers ON sales.CustomerId=customers.id WHERE sales.Status="Confirmed" ORDER BY sales.id DESC LIMIT 50');
        }
        return response()->json(['proforma_invoice_data' => $proforma_invoice_data,'sales_order_data' => $sales_order_data,'sales_invoice_data' => $sales_invoice_data]);
    }

    public function fetchReferenceData(Request $request){
        $reference_type = $_POST['reference_type'];
        $reference_id = $_POST['reference_id'];

        $proforma_data = "";
        $sales_order_data = "";
        $sales_invoice_data = "";
        $customer_data = "";
        $main_data = "";
        $detail_data = "";

        if($reference_type == 601){
            $proforma_data = DB::select('SELECT proformas.CustomerId AS customer_id,proformas.expireDate,proformas.Username,"Goods" AS product_type,proformas.store_id,stores.Name AS station FROM proformas LEFT JOIN stores ON proformas.store_id=stores.id WHERE proformas.id='.$reference_id);
            $customer_id = $proforma_data[0]->customer_id;
            $customer_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.id='.$customer_id);
            $main_data = $proforma_data;

            $detail_data = DB::select('SELECT proforma_regitem.id,proforma_regitem.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,uoms.id AS uom,proforma_regitem.Quantity,proforma_regitem.issued_qty,proforma_regitem.UnitPrice,proforma_regitem.BeforeTaxPrice FROM proforma_regitem LEFT JOIN regitems ON proforma_regitem.regitem_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE proforma_regitem.proforma_id='.$reference_id.' ORDER BY proforma_regitem.id ASC');
        }
        else if($reference_type == 602){
            $sales_order_data = DB::select('SELECT sales_orders.customer_id,sales_orders.expiredate,users.username,"Goods" AS product_type,sales_orders.store_id,stores.Name AS station FROM sales_orders LEFT JOIN stores ON sales_orders.store_id=stores.id LEFT JOIN users ON sales_orders.user_id=users.id WHERE sales_orders.id='.$reference_id);
            $customer_id = $sales_order_data[0]->customer_id;
            $customer_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.id='.$customer_id);
            $main_data = $sales_order_data;

            $detail_data = DB::select('SELECT sales_order_items.id,sales_order_items.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,uoms.id AS uom,sales_order_items.quantity AS Quantity,sales_order_items.issued_qty,sales_order_items.unit_price AS UnitPrice,sales_order_items.total_price FROM sales_order_items LEFT JOIN regitems ON sales_order_items.regitem_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE sales_order_items.sales_order_id='.$reference_id.' ORDER BY sales_order_items.id ASC');
        }
        else if($reference_type == 603){
            $sales_invoice_data = DB::select('SELECT sales.CustomerId AS customer_id,sales.PaymentType,sales.Username,"Goods" AS product_type,sales.StoreId AS store_id,stores.Name AS station FROM sales LEFT JOIN stores ON sales.StoreId=stores.id WHERE sales.id='.$reference_id);
            $customer_id = $sales_invoice_data[0]->customer_id;
            $customer_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.id='.$customer_id);
            $main_data = $sales_invoice_data;

            $detail_data = DB::select('SELECT salesitems.id,salesitems.ItemId AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,uoms.id AS uom,salesitems.Quantity,salesitems.issued_qty,salesitems.UnitPrice,salesitems.BeforeTaxPrice FROM salesitems LEFT JOIN regitems ON salesitems.ItemId=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE salesitems.HeaderId='.$reference_id.' ORDER BY salesitems.id ASC');
        }

        return response()->json(['customer_data' => $customer_data,'main_data' => $main_data,'detail_data' => $detail_data]);
    }

    public function fetchDOItemInfo(Request $request){
        $reference_type = $_POST['reference_type'];
        $reference_id = $_POST['reference_id'];
        $itemid = $_POST['itemid'];
        $record_id = $_POST['record_id'];

        $item_info = "";

        if($reference_type == 601){
            $item_info = DB::select('SELECT proforma_regitem.id,proforma_regitem.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,proforma_regitem.Quantity,proforma_regitem.issued_qty,proforma_regitem.UnitPrice,proforma_regitem.BeforeTaxPrice FROM proforma_regitem LEFT JOIN regitems ON proforma_regitem.regitem_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE proforma_regitem.proforma_id='.$reference_id.' AND proforma_regitem.regitem_id='.$itemid);
        }
        else if($reference_type == 602){
            $item_info = DB::select('SELECT sales_order_items.id,sales_order_items.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,sales_order_items.quantity AS Quantity,sales_order_items.issued_qty,sales_order_items.unit_price AS UnitPrice,sales_order_items.total_price FROM sales_order_items LEFT JOIN regitems ON sales_order_items.regitem_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE sales_order_items.sales_order_id='.$reference_id.' AND sales_order_items.regitem_id='.$itemid);
        }
        else if($reference_type == 603){
            $item_info = DB::select('SELECT salesitems.id,salesitems.ItemId AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,salesitems.Quantity,salesitems.issued_qty,salesitems.UnitPrice,salesitems.BeforeTaxPrice FROM salesitems LEFT JOIN regitems ON salesitems.ItemId=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE salesitems.HeaderId='.$reference_id.' AND salesitems.ItemId='.$itemid);
        }
        else{
            $item_info = DB::select('SELECT regitems.*,uoms.id AS uom,uoms.Name AS uom_name FROM regitems LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE regitems.id='.$itemid);
        }

        $current_do_data = DB::select('SELECT delivery_order_details.quantity AS do_qty FROM delivery_order_details LEFT JOIN delivery_orders ON delivery_order_details.delivery_order_id=delivery_orders.id WHERE delivery_orders.id='.$record_id.' AND delivery_order_details.regitems_id='.$itemid.' AND delivery_orders.status IN("Draft","Pending","Verified","Approved")');
        $do_qty = $current_do_data[0]->do_qty ?? 0;

        return response()->json(['item_info' => $item_info,'do_qty' => $do_qty]);
    }

    public function voidDeliveryOrder(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $setting_fyear = $settings->FiscalYear;
        $findid = $request->voidid;
        $do_data = delivery_order::find($findid);
        $fyear = $do_data->fiscal_year;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'Reason' => ['required'],
        ]);

        if($validator->passes()){
            DB::beginTransaction();
            try{
                $do_data->status_old = $do_data->status;
                $do_data->status = "Void";
                $do_data->save();

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "delivery_order",
                    'action' => "Void",
                    'status' => "Void",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "$request->Reason",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'fiscal_year' => $fyear,'rec_id' => $findid]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function undoVoidDeliveryOrder(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $setting_fyear = $settings->FiscalYear;
        $findid = $request->recId;
        $do_data = delivery_order::find($findid);
        $fyear = $do_data->fiscal_year;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;

        DB::beginTransaction();
        try{
            $do_data->status = $do_data->status_old;
            $do_data->save();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "delivery_order",
                'action' => "Undo Void",
                'status' => "Undo Void",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'reason' => "",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::commit();
            return Response::json(['success' => 1,'fiscal_year' => $fyear,'rec_id' => $findid]);
        }
        catch(Exception $e){
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function doForwardAction(Request $request){
        $val_status = ["Draft","Pending","Checked","Confirmed"];

        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;

            $findid = $request->forwardReqId;
            $do_data = delivery_order::find($findid);
            $currentStatus = $do_data->status;
            $newStatus = $request->newForwardStatusValue;
            $action = $request->forwardActionValue;
            $do_data->status = $newStatus;
            $docnum = $do_data->document_number;
            $product_type = $do_data->product_type;
            $fyear = $do_data->fiscal_year;
            $store_id = $do_data->station;

            if($newStatus == "Pending"){

            }
            else if($newStatus == "Verified"){
                $do_data->verified_by = $user;
                $do_data->verified_date = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }
            else if($newStatus == "Approved"){
                $do_data->approved_by = $user;
                $do_data->approved_date = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }

            $do_data->save();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "delivery_order",
                'action' => "$action",
                'status'=> "$action",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::commit();
            return Response::json(['success' => 1,'fiscal_year' => $fyear,'rec_id' => $findid]);
        }
        catch(Exception $e){
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function doBackwardAction(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->backwardReqId;
        $action = $request->backwardActionValue;
        $newStatus = $request->newBackwardStatusValue;
        $do_data = delivery_order::find($findid);
        $fyear = $do_data->fiscal_year;
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) {
            DB::beginTransaction();
            try{
                $do_data->status = $newStatus;
                $do_data->save();

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "delivery_order",
                    'action' => "$action",
                    'status' => "$action",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "$request->CommentOrReason",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                
                DB::commit();
                return Response::json(['success' => 1,'fiscal_year' => $fyear,'rec_id' => $findid]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }  
        }

        if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function getDOData($id){
        $item_info = null;
        $reference_data = null;
        $do_data = DB::select('SELECT delivery_orders.*,customers.Name AS customer_name,customers.TinNumber AS TIN, customers.Code AS customer_code,customers.CustomerCategory,customers.VatNumber,customers.PhoneNumber,customers.OfficePhone,stores.Name AS store_name,lookuprefs.LookupName AS reference_types,COALESCE(sales.VoucherNumber,sales_orders.docno,proformas.DocumentNumber) AS reference_no FROM delivery_orders LEFT JOIN customers ON delivery_orders.customers_id=customers.id LEFT JOIN stores ON delivery_orders.station=stores.id LEFT JOIN lookuprefs ON delivery_orders.reference_type=lookuprefs.id LEFT JOIN sales ON delivery_orders.reference_id=sales.id AND delivery_orders.reference_type=603 LEFT JOIN sales_orders ON delivery_orders.reference_id=sales_orders.id AND delivery_orders.reference_type=602 LEFT JOIN proformas ON delivery_orders.reference_id=proformas.id AND delivery_orders.reference_type=601 WHERE delivery_orders.id='.$id); 
        $is_price_vis = $do_data[0]->show_pricing ?? 0;
        $reference_type = $do_data[0]->reference_type ?? 0;
        $reference_id = $do_data[0]->reference_id ?? 0;

        $detail_data = DB::select('SELECT delivery_order_details.*,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.TaxTypeId,uoms.Name AS UOM,regitems.RequireSerialNumber,regitems.RequireExpireDate,delivery_orders.status,COALESCE(salesitems.Quantity,sales_order_items.quantity,proforma_regitem.Quantity) AS ordered_qty,COALESCE(salesitems.issued_qty,sales_order_items.issued_qty,proforma_regitem.issued_qty) AS issued_qty FROM delivery_order_details LEFT JOIN regitems ON delivery_order_details.regitems_id=regitems.id LEFT JOIN uoms ON delivery_order_details.new_uom=uoms.id LEFT JOIN delivery_orders ON delivery_order_details.delivery_order_id=delivery_orders.id LEFT JOIN salesitems ON delivery_order_details.reference_detail_id=salesitems.id AND delivery_orders.reference_type=603 LEFT JOIN sales_order_items ON delivery_order_details.reference_detail_id=sales_order_items.id AND delivery_orders.reference_type=602 LEFT JOIN proforma_regitem ON delivery_order_details.reference_detail_id=proforma_regitem.id AND delivery_orders.reference_type=601 WHERE delivery_order_details.delivery_order_id='.$id.' ORDER BY delivery_order_details.id ASC');

        if($reference_type == 601){
            $reference_data = DB::select('SELECT proformas.id AS proforma_id,customers.id AS customer_id,CONCAT_WS(", ", NULLIF(proformas.DocumentNumber,""),NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS proforma_data FROM proformas LEFT JOIN customers ON proformas.CustomerId=customers.id WHERE proformas.Status="Pass" ORDER BY proformas.id DESC');
            $item_info = DB::select('SELECT proforma_regitem.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items FROM proforma_regitem LEFT JOIN regitems ON proforma_regitem.regitem_id=regitems.id WHERE proforma_regitem.proforma_id='.$reference_id);
        }
        else if($reference_type == 602){
            $reference_data = DB::select('SELECT sales_orders.id AS sales_id,customers.id AS customer_id,CONCAT_WS(", ", NULLIF(sales_orders.docno, ""),NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS sales_data FROM sales_orders LEFT JOIN customers ON sales_orders.customer_id=customers.id WHERE sales_orders.status=8 ORDER BY sales_orders.id DESC');
            $item_info = DB::select('SELECT sales_order_items.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items FROM sales_order_items LEFT JOIN regitems ON sales_order_items.regitem_id=regitems.id WHERE sales_order_items.sales_order_id='.$reference_id);
        }
        else if($reference_type == 603){
            $reference_data = DB::select('SELECT sales.id AS sales_id,customers.id AS customer_id,CONCAT_WS(", ", NULLIF(sales.VoucherNumber, ""), NULLIF(sales.invoiceNo, ""), NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS sales_data FROM sales LEFT JOIN customers ON sales.CustomerId=customers.id WHERE sales.Status="Confirmed" ORDER BY sales.id DESC LIMIT 50');
            $item_info = DB::select('SELECT salesitems.ItemId AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items FROM salesitems LEFT JOIN regitems ON salesitems.ItemId=regitems.id WHERE salesitems.HeaderId='.$reference_id);
        }

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"delivery_order")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['do_data' => $do_data,'detail_data' => $detail_data,'reference_data' => $reference_data,'item_info' => $item_info,'activitydata' => $activitydata,'is_price_vis' => $is_price_vis,'reference_type' => $reference_type,'rec_id' => $id]);
    }

    public function showDODetailData($id){

        $detailTable = DB::select('SELECT delivery_order_details.*,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,regitems.TaxTypeId,uoms.Name AS UOM,regitems.RequireSerialNumber,regitems.RequireExpireDate,delivery_orders.status FROM delivery_order_details LEFT JOIN regitems ON delivery_order_details.regitems_id=regitems.id LEFT JOIN uoms ON delivery_order_details.new_uom=uoms.id LEFT JOIN delivery_orders ON delivery_order_details.delivery_order_id=delivery_orders.id WHERE delivery_order_details.delivery_order_id='.$id.' ORDER BY delivery_order_details.id ASC'); 
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function calcDOBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $record_id = $_POST['baseRecordId'] ?? 0;
        $store_id = $_POST['storeval'] ?? 0;
        $item_id = $_POST['itemid'] ?? 0;

        $item_balance_data = DB::select('SELECT (SUM(COALESCE(transactions.StockIn,0)) - SUM(COALESCE(transactions.StockOut,0))) AS available_quantity FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.StoreId='.$store_id.' AND transactions.ItemId='.$item_id);
        $other_req_data = DB::select('SELECT SUM(COALESCE(requisitiondetails.Quantity,0)) AS others_req_qty FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.SourceStoreId='.$store_id.' AND requisitiondetails.ItemId='.$item_id.' AND requisitions.Status IN("Draft","Pending","Verified","Approved")');
        $sales_data = DB::select('SELECT SUM(COALESCE(salesitems.Quantity,0)) AS sales_qty FROM salesitems LEFT JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.StoreId='.$store_id.' AND salesitems.ItemId='.$item_id.' AND sales.Status IN("pending..","Checked")');
        $transfer_data = DB::select('SELECT SUM(COALESCE(transferdetails.Quantity,0)) AS transfer_qty FROM transferdetails LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transfers.SourceStoreId='.$store_id.' AND transferdetails.ItemId='.$item_id.' AND transfers.Status IN("Draft","Pending","Verified","Reviewed","Approved")');
        $do_data = DB::select('SELECT SUM(COALESCE(delivery_order_details.quantity,0)) AS do_qty FROM delivery_order_details LEFT JOIN delivery_orders ON delivery_order_details.delivery_order_id=delivery_orders.id WHERE delivery_orders.id!='.$record_id.' AND delivery_order_details.regitems_id='.$item_id.' AND delivery_orders.status IN("Draft","Pending","Verified")');
        
        $main_balance = $item_balance_data[0]->available_quantity ?? 0;
        $others_req_qty = $other_req_data[0]->others_req_qty ?? 0;
        $sales_qty = $sales_data[0]->sales_qty ?? 0;
        $transfer_qty = $transfer_data[0]->transfer_qty ?? 0;
        $do_qty = $do_data[0]->do_qty ?? 0;

        $available_qty = $main_balance - $others_req_qty - $sales_qty - $transfer_qty - $do_qty;

        $available_qty = $available_qty < 0 ? 0 : $available_qty;

        return response()->json(['available_qty' => $available_qty]);       
    }

    public function getDOStoreBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $store_id = $_POST['store_id'] ?? 0;
        $item_id = $_POST['item_id'] ?? 0;

        $result = DB::table('transactions')
            ->select([
                'transactions.ItemId',
                DB::raw("(
                    (SUM(COALESCE(StockIn, 0)) - SUM(COALESCE(StockOut, 0))) - 
                    (SELECT IFNULL(SUM(rd.Quantity), 0) 
                    FROM requisitiondetails rd
                    INNER JOIN requisitions r ON rd.HeaderId = r.id 
                    WHERE r.SourceStoreId = transactions.StoreId 
                    AND rd.ItemId = transactions.ItemId 
                    AND r.fiscalyear = transactions.FiscalYear 
                    AND r.Status IN ('Draft','Pending','Verified','Approved')) -
                    (SELECT IFNULL(SUM(si.Quantity), 0) 
                    FROM salesitems si
                    INNER JOIN sales s ON si.HeaderId = s.id 
                    WHERE s.StoreId = transactions.StoreId 
                    AND si.ItemId = transactions.ItemId 
                    AND s.fiscalyear = transactions.FiscalYear 
                    AND s.Status IN ('pending..','Checked')) -
                    (SELECT IFNULL(SUM(td.Quantity), 0) 
                    FROM transferdetails td
                    INNER JOIN transfers t ON td.HeaderId = t.id 
                    WHERE t.SourceStoreId = transactions.StoreId 
                    AND td.ItemId = transactions.ItemId 
                    AND t.fiscalyear = transactions.FiscalYear 
                    AND t.Status IN ('Draft','Pending','Verified','Reviewed','Approved')) -
                    (SELECT IFNULL(SUM(dt.quantity), 0) 
                    FROM delivery_order_details dt
                    INNER JOIN delivery_orders d ON dt.delivery_order_id = d.id 
                    WHERE d.station = transactions.StoreId 
                    AND dt.regitems_id = transactions.ItemId 
                    AND d.fiscal_year = transactions.FiscalYear 
                    AND d.status IN ('Draft','Pending','Verified'))
                ) as available_quantity")
            ])
            ->where('transactions.FiscalYear', $fyear)
            ->where('transactions.StoreId', $store_id)
            ->whereIn('transactions.ItemId', $item_id)
            ->groupBy('transactions.ItemId')
            ->get();

        return response()->json(['result' => $result]);    
    }

    function updateIssuedQtyFn($rec_id,$ref_id,$ref_type,$ref_det_id){

        if($ref_type == 601){
            $do_data = DB::select('SELECT SUM(COALESCE(delivery_order_details.quantity,0)) AS do_qty FROM delivery_order_details LEFT JOIN delivery_orders ON delivery_order_details.delivery_order_id=delivery_orders.id WHERE delivery_orders.reference_type='.$ref_type.' AND delivery_order_details.reference_detail_id='.$ref_det_id.' AND delivery_orders.status NOT IN("Void")');
            $do_qty = $do_data[0]->do_qty ?? 0;

            DB::table('proforma_regitem')->where('proforma_regitem.id',$ref_det_id)->update(['proforma_regitem.issued_qty' => $do_qty]);
        }
        else if($ref_type == 602){
            $do_data = DB::select('SELECT SUM(COALESCE(delivery_order_details.quantity,0)) AS do_qty FROM delivery_order_details LEFT JOIN delivery_orders ON delivery_order_details.delivery_order_id=delivery_orders.id WHERE delivery_orders.reference_type='.$ref_type.' AND delivery_order_details.reference_detail_id='.$ref_det_id.' AND delivery_orders.status NOT IN("Void")');
            $do_qty = $do_data[0]->do_qty ?? 0;

            DB::table('sales_order_items')->where('sales_order_items.id',$ref_det_id)->update(['sales_order_items.issued_qty' => $do_qty]);
        }
        else if($ref_type == 603){
            $do_data = DB::select('SELECT SUM(COALESCE(delivery_order_details.quantity,0)) AS do_qty FROM delivery_order_details LEFT JOIN delivery_orders ON delivery_order_details.delivery_order_id=delivery_orders.id WHERE delivery_orders.reference_type='.$ref_type.' AND delivery_order_details.reference_detail_id='.$ref_det_id.' AND delivery_orders.status NOT IN("Void")');
            $do_qty = $do_data[0]->do_qty ?? 0;

            DB::table('salesitems')->where('salesitems.id',$ref_det_id)->update(['salesitems.issued_qty' => $do_qty]);
        }
    }

    function generateDocumentNumberFn($fyear, $recId = null){
        $fyear = (int)$fyear;
        $currentShort = substr($fyear, -2);
        $nextShort = substr($fyear + 1, -2);
        $fiscalyear_formatted = $currentShort . '-' . $nextShort;
        $prefix = DB::table('settings')->latest()->first();
        $docPrefix = $prefix->delivery_order_prefix ?? 'DO#';

        if($recId == null){
            $currentNumber = DB::table('delivery_orders')
                ->where('fiscal_year',$fyear)
                ->orderByDesc('current_document_no')
                ->latest()
                ->first();

            $newNumber = (int)($currentNumber->current_document_no ?? 0) + 1;
            return $docPrefix . '-'  . str_pad($newNumber, 6, '0', STR_PAD_LEFT). '/' .$fiscalyear_formatted;
        }

        if($recId != null){
            $rec_data = delivery_order::where('id', $recId)->first();

            $currentNumber = DB::table('delivery_orders')
                ->where('fiscal_year',$fyear)
                ->orderByDesc('current_document_no')
                ->latest()
                ->first();
            
            $newNumber = (int)($currentNumber->current_document_no ?? 0) + 1;
            return $docPrefix . '-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT). '/' .$fiscalyear_formatted;
        }
    }

    function countDOStatus(){
        $fyear = $_POST['fyear'] ?? 0; 
        $delivery_order_status = DB::select('SELECT delivery_orders.status,FORMAT(COUNT(*),0) AS status_count FROM delivery_orders WHERE delivery_orders.fiscal_year='.$fyear.' GROUP BY delivery_orders.status UNION SELECT "Total",FORMAT(COUNT(*),0) AS status_count FROM delivery_orders WHERE delivery_orders.fiscal_year='.$fyear);

        $ready_for_do = DB::select('SELECT (SELECT COUNT(proformas.id) FROM proformas WHERE proformas.Status="Pass") + (SELECT COUNT(sales_orders.id) FROM sales_orders WHERE sales_orders.status=8) + (SELECT COUNT(sales.id) FROM sales WHERE sales.Status="Confirmed") AS ready_do');
     
        $ready_do_cnt = $ready_for_do[0]->ready_do ?? 0;
        $ready_do_cnt = number_format($ready_do_cnt);

        return response()->json(['delivery_order_status' => $delivery_order_status,'ready_do_cnt' => $ready_do_cnt]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
