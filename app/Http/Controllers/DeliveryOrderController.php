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
use App\Models\transaction;
use App\Models\documents;
use App\Models\batches;
use App\Models\batch_inventory;
use App\Models\serial_number;
use App\Models\batch_serial_transaction;
use App\Models\batch_inventories_issue;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Exception;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
        $doc_type_data = DB::select('SELECT * FROM lookuprefs WHERE lookuprefs.Type=102 AND lookuprefs.Status=1 ORDER BY lookuprefs.id ASC'); 
        

        $delivery_data = [
            'fiscalyr' => $fyear,'curdate' => $currentdate,'station_src' => $station_src,
            'customer_src' => $customer_src,'uses_data' => $uses_data,'ref_type_data' => $ref_type_data,
            'itemSrcs' => $itemSrcs,'fiscalyears' => $fiscalyears,'doc_type_data' => $doc_type_data
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
        $actual_item_ids = [];
        $standard_item_ids = [];
        $is_valid_actual_std = true;
        $is_actual_std_similar = true;

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
            'row.*.Quantity' => 'nullable',
            'row.*.UnitPrice' => 'required_if:VisiblePrice,true,1,on,yes',
        );

        $stdrules = array(
            'stdrow.*.std_ItemId' => 'required',
            'stdrow.*.quantity_pcs' => 'nullable',
            'stdrow.*.std_unitprice' => 'required_if:VisiblePrice,true,1,on,yes',
        );

        $v2 = Validator::make($request->all(), $rules);
        $v3 = Validator::make($request->all(), $stdrules);

        if($request->row != null){
            foreach ($request->row as $key => $value){
                $item_id = $value['ItemId'];
                if($item_id != null){
                    $actual_item_ids[] = $item_id;
                }
            }
        }
        if($request->stdrow != null){
            foreach ($request->stdrow as $key => $value){
                $item_id = $value['std_ItemId'];
                if($item_id != null){
                    $standard_item_ids[] = $item_id;
                }
            }
        }

        if(count($actual_item_ids) > 0 && count($standard_item_ids) > 0 && (count($actual_item_ids) !== count($standard_item_ids))) {
            $is_valid_actual_std = false;
        }
        if(count($actual_item_ids) > 0 && count($standard_item_ids) > 0 && (count($actual_item_ids) == count($standard_item_ids))) {
            $actual_values = array_values($actual_item_ids);
            $std_values = array_values($standard_item_ids);
            if($actual_values === $std_values){
                $is_actual_std_similar = true;
            }
            else{
                $is_actual_std_similar = false;
            }
        }

        if($validator->passes() && $v2->passes() && $v3->passes() && ($request->row != null || $request->stdrow != null) && $is_valid_actual_std && $is_actual_std_similar){
            DB::beginTransaction();
            try{
                $submitted_ids = [];
                $submitted_items = [];
                $reference_type = $request->ReferenceType ?? 0;
                $reference_id_val = $request->Reference ?? 0;
                $reference_data = null;
                $do_detail_rec_id = null;
                $total_price = 0;
                $std_total_price = 0;

                $validation = $this->validateItemBalances($request->row,$request->station,$fyear,$findid);
                if (($validation['status'] ?? "") == 456) {
                    return Response::json([
                        'balance_error' => 404,
                        'items' => $validation['negative_items']
                    ]);
                }

                $DbData = delivery_order::where('id', $findid)->first();

                if($findid != null && $DbData->reference_id != 600){
                    $this->resetDOQtyFn($findid,$DbData->reference_id,$DbData->reference_type);
                    $this->updateReferenceFn($findid,$DbData->reference_id,$DbData->reference_type);
                }

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

                if($request->row != null){
                    foreach ($request->row as $key => $value){
                        $item_id = $value['ItemId'];
                        $quantity = $value['Quantity'] ?? 0;
                        $total_price += $value['TotalPrice'] ?? 0;

                        $item_prop = Regitem::where('id', $item_id)->first();
                        $default_uom = $item_prop->MeasurementId;
                        $new_uom = $value['uom'] ?? $default_uom;
                        $conversion_factor = 1;
                        $serial_qty = 0;
                        $converted_qty = $quantity;

                        if($default_uom != $new_uom){
                            $conversion_data = conversion::where('FromUomID',$default_uom)->where('ToUomID',$new_uom)->first();
                            $conversion_factor = $conversion_data->Amount ?? 1;
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

                        $submitted_ids[] = $delivery_order_detail->id;

                        $this->updateIssuedQtyFn($delivery_order->id,$reference_id_val,$reference_type,$do_detail_rec_id);
                    }
                }

                if($request->stdrow != null){
                    $submitted_ids = [];
                    foreach ($request->stdrow as $key => $value){
                        $item_id = $value['std_ItemId'];
                        $quantity = $value['quantity_pcs'] ?? 0;
                        $std_total_price += $value['std_totalprice'] ?? 0;

                        $item_prop = Regitem::where('id', $item_id)->first();
                        $default_uom = $item_prop->MeasurementId;

                        $std_del_detail_db_data = delivery_order_detail::where('delivery_order_id',$delivery_order->id)->where('regitems_id',$item_id)->first();

                        $std_do_detail_permanent_data = [
                            'regitems_id' => $item_id,
                            'default_uom' => $default_uom,
                            'factor' => $value['factor'] ?? 0,
                            'quantity_pcs' => $quantity,
                            'standard_kg' => $value['std_kg'] ?? 0,
                            'price_per_kg' => $value['std_unitprice'] ?? 0,
                            'std_total_price' => $value['std_totalprice'] ?? 0,
                            'std_remark' => $value['std_remark'],
                        ];

                        $std_do_detail_created_data = [
                            'delivery_order_id' => $delivery_order->id,
                            'created_at' => Carbon::now()
                        ];

                        $std_do_detail_edited_data = [
                            'updated_at' => Carbon::now()
                        ];

                        $delivery_order_detail = delivery_order_detail::updateOrCreate([
                            'delivery_order_id' => $delivery_order->id,
                            'regitems_id' => $item_id,
                        ], 
                            array_merge($std_do_detail_permanent_data, $std_del_detail_db_data ? $std_do_detail_edited_data : $std_do_detail_created_data)
                        );

                        $submitted_ids[] = $delivery_order_detail->id;
                    }
                }

                DB::table('delivery_orders')
                ->where('delivery_orders.id',$delivery_order->id)
                ->update(['delivery_orders.total_price' => $total_price,'delivery_orders.std_total_price' => $std_total_price]);

                DB::table('delivery_order_details')
                    ->where('delivery_order_id', $delivery_order->id)
                    ->whereNotIn('id', $submitted_ids)
                    ->delete();

                if($delivery_order->status == "Approved"){
                    foreach ($request->row as $key => $value){  
                        $transaction = transaction::updateOrCreate([
                            'HeaderId' => $delivery_order->id,
                            'ItemId' => $value['ItemId'],
                            'TransactionType' => "Delivery-Order",
                            'TransactionsType' => "Delivery-Order",
                        ],[
                            'HeaderId' => $delivery_order->id,
                            'ItemId' => $value['ItemId'],
                            'StockOut' => $value['Quantity'],
                            'UnitPrice' => $value['UnitPrice'] ?? 0,
                            'BeforeTaxPrice' => $value['TotalPrice'] ?? 0,
                            'StoreId' => $delivery_order->station,
                            'IsVoid' => 0,
                            'TransactionType' => "Delivery-Order",
                            'TransactionsType' => "Delivery-Order",
                            'ItemType' => $delivery_order->product_type,
                            'DocumentNumber' => $delivery_order->document_number,
                            'FiscalYear' => $delivery_order->fiscal_year,
                            'Date' => $delivery_order->approved_date,
                        ]);

                        DB::table('delivery_order_details')
                            ->where('delivery_order_details.delivery_order_id',$delivery_order->id)
                            ->where('delivery_order_details.regitems_id',$value['ItemId'])
                            ->where('delivery_order_details.TransactionsType',"Void")
                            ->update([
                                'delivery_orders.StockIn' => $value['Quantity'],
                                'delivery_orders.UnitCost' => $value['UnitPrice'] ?? 0,
                                'delivery_orders.BeforeTaxCost' => $value['TotalPrice'] ?? 0
                            ]);

                        DB::table('delivery_order_details')
                            ->where('delivery_order_details.delivery_order_id',$delivery_order->id)
                            ->where('delivery_order_details.regitems_id',$value['ItemId'])
                            ->where('delivery_order_details.TransactionsType',"Undo-Void")
                            ->update([
                                'delivery_orders.StockOut' => $value['Quantity'],
                                'delivery_orders.UnitPrice' => $value['UnitPrice'] ?? 0,
                                'delivery_orders.BeforeTaxPrice' => $value['TotalPrice'] ?? 0
                            ]);

                        $submitted_items[] = $value['ItemId'];
                    }

                    DB::table('transactions')
                        ->where('HeaderId',$delivery_order->id)
                        ->where('TransactionType', "Delivery-Order")
                        ->whereNotIn('ItemId', $submitted_items)
                        ->delete();
                }

                if($delivery_order->reference_type != 600){
                    $this->updateReferenceFn($delivery_order->id,$delivery_order->reference_id,$delivery_order->reference_type);
                }

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
        else if($v2->fails() || $v3->fails()){
            return response()->json(['errorv2' => $v2->errors()->all(),'errorv3' => $v3->errors()->all()]);
        }
        else if($request->row == null && $request->stdrow == null){
            return Response::json(['empty_table' => 460]);
        }
        else if(!$is_valid_actual_std){
            return Response::json(['actual_std_variance' => 465]);
        }
        else if(!$is_actual_std_similar){
            return Response::json(['actual_std_similarity' => 466]);
        }
    }

    public function fetchReferenceDoc(Request $request){
        $reference_type = $_POST['reference_type'];
        $proforma_invoice_data = "";
        $sales_order_data = "";
        $sales_invoice_data = "";

        if($reference_type == 601){
            $proforma_invoice_data = DB::select('SELECT proformas.id AS proforma_id,customers.id AS customer_id,CONCAT_WS(", ", NULLIF(proformas.DocumentNumber,""),NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS proforma_data FROM proformas LEFT JOIN customers ON proformas.CustomerId=customers.id WHERE proformas.Status="Pass" AND proformas.is_do_completed!=1 ORDER BY proformas.id DESC');
        }
        else if($reference_type == 602){
            $sales_order_data = DB::select('SELECT sales_orders.id AS sales_id,customers.id AS customer_id,CONCAT_WS(", ", NULLIF(sales_orders.docno, ""),NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS sales_data FROM sales_orders LEFT JOIN customers ON sales_orders.customer_id=customers.id WHERE sales_orders.status=8 AND sales_orders.is_do_completed!=1 ORDER BY sales_orders.id DESC');
        }
        else if($reference_type == 603){
            $sales_invoice_data = DB::select('SELECT sales.id AS sales_id,customers.id AS customer_id,CONCAT_WS(", ", NULLIF(sales.VoucherNumber, ""), NULLIF(sales.invoiceNo, ""), NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS sales_data FROM sales LEFT JOIN customers ON sales.CustomerId=customers.id WHERE sales.Status="Confirmed" AND sales.is_do_completed!=1 ORDER BY sales.id DESC LIMIT 50');
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

            $detail_data = DB::select('SELECT proforma_regitem.id,proforma_regitem.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,uoms.id AS uom,regitems.standard_factor,proforma_regitem.Quantity,proforma_regitem.issued_qty,proforma_regitem.UnitPrice,proforma_regitem.BeforeTaxPrice FROM proforma_regitem LEFT JOIN regitems ON proforma_regitem.regitem_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE proforma_regitem.proforma_id='.$reference_id.' ORDER BY proforma_regitem.id ASC');
        }
        else if($reference_type == 602){
            $sales_order_data = DB::select('SELECT sales_orders.customer_id,sales_orders.expiredate,users.username,"Goods" AS product_type,sales_orders.store_id,stores.Name AS station FROM sales_orders LEFT JOIN stores ON sales_orders.store_id=stores.id LEFT JOIN users ON sales_orders.user_id=users.id WHERE sales_orders.id='.$reference_id);
            $customer_id = $sales_order_data[0]->customer_id;
            $customer_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.id='.$customer_id);
            $main_data = $sales_order_data;

            $detail_data = DB::select('SELECT sales_order_items.id,sales_order_items.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,uoms.id AS uom,regitems.standard_factor,sales_order_items.quantity AS Quantity,sales_order_items.issued_qty,sales_order_items.unit_price AS UnitPrice,sales_order_items.total_price FROM sales_order_items LEFT JOIN regitems ON sales_order_items.regitem_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE sales_order_items.sales_order_id='.$reference_id.' ORDER BY sales_order_items.id ASC');
        }
        else if($reference_type == 603){
            $sales_invoice_data = DB::select('SELECT sales.CustomerId AS customer_id,sales.PaymentType,sales.Username,"Goods" AS product_type,sales.StoreId AS store_id,stores.Name AS station FROM sales LEFT JOIN stores ON sales.StoreId=stores.id WHERE sales.id='.$reference_id);
            $customer_id = $sales_invoice_data[0]->customer_id;
            $customer_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.id='.$customer_id);
            $main_data = $sales_invoice_data;

            $detail_data = DB::select('SELECT salesitems.id,salesitems.ItemId AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,uoms.id AS uom,regitems.standard_factor,salesitems.Quantity,salesitems.issued_qty,salesitems.UnitPrice,salesitems.BeforeTaxPrice FROM salesitems LEFT JOIN regitems ON salesitems.ItemId=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE salesitems.HeaderId='.$reference_id.' ORDER BY salesitems.id ASC');
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
            $item_info = DB::select('SELECT proforma_regitem.id,proforma_regitem.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,regitems.standard_factor,proforma_regitem.Quantity,proforma_regitem.issued_qty,proforma_regitem.UnitPrice,proforma_regitem.BeforeTaxPrice FROM proforma_regitem LEFT JOIN regitems ON proforma_regitem.regitem_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE proforma_regitem.proforma_id='.$reference_id.' AND proforma_regitem.regitem_id='.$itemid);
        }
        else if($reference_type == 602){
            $item_info = DB::select('SELECT sales_order_items.id,sales_order_items.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,regitems.standard_factor,sales_order_items.quantity AS Quantity,sales_order_items.issued_qty,sales_order_items.unit_price AS UnitPrice,sales_order_items.total_price FROM sales_order_items LEFT JOIN regitems ON sales_order_items.regitem_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE sales_order_items.sales_order_id='.$reference_id.' AND sales_order_items.regitem_id='.$itemid);
        }
        else if($reference_type == 603){
            $item_info = DB::select('SELECT salesitems.id,salesitems.ItemId AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,regitems.standard_factor,salesitems.Quantity,salesitems.issued_qty,salesitems.UnitPrice,salesitems.BeforeTaxPrice FROM salesitems LEFT JOIN regitems ON salesitems.ItemId=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE salesitems.HeaderId='.$reference_id.' AND salesitems.ItemId='.$itemid);
        }
        else{
            $item_info = DB::select('SELECT regitems.*,uoms.id AS uom,uoms.Name AS uom_name,regitems.standard_factor FROM regitems LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE regitems.id='.$itemid);
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
        $status_old = $do_data->status_old;
        $status_current = $do_data->status;
        $docnum = $do_data->document_number;
        $product_type = $do_data->product_type;
        $store_id = $do_data->station;
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

                if($status_current == "Approved"){
                    DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT delivery_order_id,regitems_id,quantity,unit_price,total_price,"'.$store_id.'","Delivery-Order","Void","'.$product_type.'","'.$docnum.'","'.$fyear.'","0","'.Carbon::now()->toDateString().'" FROM delivery_order_details WHERE delivery_order_details.delivery_order_id='.$findid);
                }
                $do_data->save();

                $this->resetDOQtyFn($findid,$do_data->reference_id,$do_data->reference_type);
                $this->updateReferenceFn($findid,$do_data->reference_id,$do_data->reference_type);

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
        $status_old = $do_data->status_old;
        $status_current = $do_data->status;
        $docnum = $do_data->document_number;
        $product_type = $do_data->product_type;
        $store_id = $do_data->station;
        $ref_type = $do_data->reference_type;
        $ref_id = $do_data->reference_id;
        $is_rec_created_after = 0;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;

        DB::beginTransaction();
        try{

            if($ref_type == 601){
                $proforma_data = Proforma::find($ref_id);
                $is_rec_created_after = $proforma_data->is_do_completed;
            }
            else if($ref_type == 602){
                $so_data = SalesOrder::find($ref_id);
                $is_rec_created_after = $so_data->is_do_completed;
            }
            else if($ref_type == 603){
                $si_data = Sales::find($ref_id);
                $is_rec_created_after = $si_data->is_do_completed;
            }

            if($is_rec_created_after == 1){
                return Response::json(['create_error' => 465]);
            }
            else{
                $do_data->status = $do_data->status_old;
                $do_data->save();

                if($status_old == "Approved"){
                    $validation = $this->validateDOItems($store_id,$fyear,$findid);

                    if(($validation['status'] ?? "") == 456){
                        return Response::json([
                            'balance_error' => 404,
                            'items' => $validation['negative_items']
                        ]);
                    }
                    else{
                        DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT delivery_order_id,regitems_id,quantity,unit_price,total_price,"'.$store_id.'","Delivery-Order","Undo-Void","'.$product_type.'","'.$docnum.'","'.$fyear.'","0","'.Carbon::now()->toDateString().'" FROM delivery_order_details WHERE delivery_order_details.delivery_order_id='.$findid);
                    }
                }

                if($ref_type != 600){
                    $do_detial_data = DB::select('SELECT * FROM delivery_order_details WHERE delivery_order_details.delivery_order_id='.$findid);
                    foreach($do_detial_data as $det_data){
                        $this->updateIssuedQtyFn($findid,$ref_id,$ref_type,$det_data->reference_detail_id);
                    }
                    $this->updateReferenceFn($findid,$ref_id,$ref_type);
                }
                

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
            else if($newStatus == "Verified" || $newStatus == "Approved"){
                $get_do_item = DB::select('SELECT regitems.Name AS item_name FROM delivery_order_details LEFT JOIN regitems ON delivery_order_details.regitems_id=regitems.id WHERE (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require") AND delivery_order_details.is_fully_entered=0 AND delivery_order_details.delivery_order_id='.$findid);
                $total_item = count($get_do_item);

                // if($total_item > 0){
                //     return Response::json(['item_variances' => $get_do_item]);
                // }

                if($newStatus == "Verified"){
                    $do_data->verified_by = $user;
                    $do_data->verified_date = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                }
                if($newStatus == "Approved"){

                    $validation = $this->validateDOItems($store_id,$fyear,$findid);

                    if(($validation['status'] ?? "") == 456){
                        return Response::json([
                            'balance_error' => 404,
                            'items' => $validation['negative_items']
                        ]);
                    }
                    else{

                        DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT delivery_order_id,regitems_id,quantity,unit_price,total_price,"'.$store_id.'","Delivery-Order","Delivery-Order","'.$product_type.'","'.$docnum.'","'.$fyear.'","0","'.Carbon::now()->toDateString().'" FROM delivery_order_details WHERE delivery_order_details.delivery_order_id='.$findid);

                        $do_data->approved_by = $user;
                        $do_data->approved_date = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                    }
                }
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

        $detail_data = DB::select('SELECT delivery_order_details.*,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.TaxTypeId,uoms.Name AS UOM,regitems.RequireSerialNumber,regitems.RequireExpireDate,delivery_orders.status,COALESCE(salesitems.Quantity,sales_order_items.quantity,proforma_regitem.Quantity) AS ordered_qty,COALESCE(salesitems.issued_qty,sales_order_items.issued_qty,proforma_regitem.issued_qty) AS issued_qty FROM delivery_order_details LEFT JOIN regitems ON delivery_order_details.regitems_id=regitems.id LEFT JOIN uoms ON delivery_order_details.default_uom=uoms.id LEFT JOIN delivery_orders ON delivery_order_details.delivery_order_id=delivery_orders.id LEFT JOIN salesitems ON delivery_order_details.reference_detail_id=salesitems.id AND delivery_orders.reference_type=603 LEFT JOIN sales_order_items ON delivery_order_details.reference_detail_id=sales_order_items.id AND delivery_orders.reference_type=602 LEFT JOIN proforma_regitem ON delivery_order_details.reference_detail_id=proforma_regitem.id AND delivery_orders.reference_type=601 WHERE delivery_order_details.delivery_order_id='.$id.' ORDER BY delivery_order_details.id ASC');

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
        $detailTable = DB::select('SELECT delivery_order_details.*,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,regitems.TaxTypeId,uoms.Name AS UOM,delivery_orders.station,regitems.RequireSerialNumber,regitems.RequireExpireDate,delivery_orders.status,11 AS trn_type,delivery_order_details.is_fully_entered,delivery_order_details.entered_qty,delivery_orders.status,
        (SELECT GROUP_CONCAT(" ",country.Name,IFNULL(brands.manufacturer,"")," ",IFNULL(batches.batch_number,"")," ",IFNULL(brands.Name,"")," ",IFNULL(models.Name,"")," ",IFNULL(batches.expiry_date,"")," ",IFNULL(batches.manufacturing_date,"")," ",batch_inventories_issues.sold_issued_qty) FROM batch_inventories_issues LEFT JOIN batches ON batch_inventories_issues.batches_id=batches.id LEFT JOIN regitems ON batches.item_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id LEFT JOIN brands ON batches.brand_id=brands.id LEFT JOIN models ON batches.model_id=models.id LEFT JOIN country ON brands.countries_id=country.id WHERE batch_inventories_issues.regitems_id=delivery_order_details.regitems_id AND batch_inventories_issues.source_id=delivery_order_details.delivery_order_id AND batch_inventories_issues.source_type="delivery_order") AS batch_numers,
        (SELECT GROUP_CONCAT(" ",serial_number) AS serial_number FROM serial_numbers LEFT JOIN batches ON serial_numbers.batches_id=batches.id LEFT JOIN brands ON batches.brand_id=brands.id LEFT JOIN models ON batches.model_id=models.id WHERE serial_numbers.is_sold_issued=1 AND serial_numbers.batches_id IN(SELECT batch_inventories_issues.batches_id FROM batch_inventories_issues WHERE batch_inventories_issues.source_id=delivery_order_details.delivery_order_id AND batch_inventories_issues.source_type="delivery_order")) AS serial_numbers
        FROM delivery_order_details LEFT JOIN regitems ON delivery_order_details.regitems_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id LEFT JOIN delivery_orders ON delivery_order_details.delivery_order_id=delivery_orders.id WHERE delivery_order_details.delivery_order_id='.$id.' ORDER BY delivery_order_details.id ASC'); 
        
        
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getItemBactchDataIssue(Request $request){
        $headerId = $_POST['headerId']; 
        $itemId = $_POST['itemId'];

        $batch_data = DB::select('SELECT batches.*,IFNULL(batches.expiry_date,"") AS expiry_date,IFNULL(batches.manufacturing_date,"") AS manufacturing_date,batch_inventories_issues.sold_issued_qty,CONCAT_WS(", ",CASE WHEN country.Name="--" THEN NULL ELSE country.Name END,NULLIF(brands.manufacturer,""),NULLIF(brands.Name,"")) AS brand_name,IFNULL(models.Name,"") AS model_name,regitems.RequireSerialNumber,regitems.RequireExpireDate FROM batch_inventories_issues LEFT JOIN batches ON batch_inventories_issues.batches_id=batches.id LEFT JOIN regitems ON batches.item_id=regitems.id LEFT JOIN brands ON batches.brand_id=brands.id LEFT JOIN models ON batches.model_id=models.id LEFT JOIN country ON brands.countries_id=country.id WHERE batch_inventories_issues.source_id='.$headerId.' AND batch_inventories_issues.regitems_id='.$itemId.' AND batch_inventories_issues.source_type="delivery_order" ORDER BY batch_inventories_issues.id ASC');
        return response()->json(['batch_data' => $batch_data]);
    }

    public function getItemSerialDataIssue(Request $request){
        $batchId = $_POST['batchId'];
        $source_id = $_POST['source_id'];
        $source_type = "delivery_order";

        $serial_data = DB::select('SELECT IFNULL(GROUP_CONCAT(" ",serial_number),"") AS serial_number,COUNT(id) AS count_serial FROM serial_numbers WHERE serial_numbers.batches_id='.$batchId.' AND serial_numbers.sold_issue_id='.$source_id.' AND serial_numbers.source_type="'.$source_type.'" AND serial_numbers.is_sold_issued=1 ORDER BY serial_numbers.id ASC');
        return response()->json(['serial_data' => $serial_data]);
    }

    public function fetchDODoc(){
        $do_id = $_POST['do_id'];
        $document_data = DB::select('SELECT lookuprefs.LookupName AS doc_type,documents.* FROM documents LEFT JOIN lookuprefs ON documents.document_type=lookuprefs.id WHERE documents.record_id='.$do_id.' AND documents.record_type="delivery_order" ORDER BY documents.id ASC');
    
        return response()->json(['document_data' => $document_data]);
    }

    public function uploadDODocument(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->uploadRecordDocId;
        $rec = delivery_order::find($findid);
        $document_upload_data = [];

        $rules = array(
            'docrow.*.document_type' => 'required',
            'docrow.*.doc_upload_hidden' => 'required',
            'docrow.*.doc_status' => 'required',
        );
        $v2 = Validator::make($request->all(), $rules);

        if($v2->passes() && $request->docrow != null){
            DB::beginTransaction();
            try{
                foreach ($request->docrow as $key => $value){
                    $doc = $value['doc_upload'] ?? "";
                    if($doc != null) {
                        $doc_file = $value['doc_upload'];
                        $actual_name = $doc_file->getClientOriginalName();
                        $documentations = $this->randNumber().$findid.'_'.'doc.' . $value['doc_upload']->extension();
                        $docPathIdentification = public_path() . '/storage/uploads/DeliveryOrder/SupportingDocument';
                        $docpathnameIdentification = '/storage/uploads/DeliveryOrder/SupportingDocument/'.$documentations;
                        $doc_file->move($docPathIdentification, $documentations);
                    }
                    if($doc == null) {
                        $documentations = $value['documents'];
                        $actual_name = $value['doc_actual_name'];
                    }
                    $document_upload_data[] = [
                        "record_id" => $findid,
                        "record_type" => "delivery_order",
                        "document_type" => $value['document_type'],
                        "date" => $value['upload_date'],
                        "doc_name" => $documentations,
                        "actual_file_name" => $actual_name,
                        "remark" => $value['doc_remark'],
                        "status" => $value['doc_status'],
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now()
                    ];
                }

                DB::table('documents')->where('record_id',$findid)->where('record_type',"delivery_order")->delete();
                DB::table('documents')->insert($document_upload_data);

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "delivery_order",
                    'action' => "Document-Uploaded",
                    'status' => "Document-Uploaded",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'rec_id' => $findid]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($v2->fails()){
            return response()->json(['errorv2' => $v2->errors()->all()]);
        }
        else if($request->docrow == null){
            return response()->json(['emptyerror' => "error"]);
        }
    }

    public function showDODocument($id){
        $document_data = DB::select('SELECT lookuprefs.LookupName AS doc_type,documents.* FROM documents LEFT JOIN lookuprefs ON documents.document_type=lookuprefs.id WHERE documents.record_id='.$id.' AND documents.record_type="delivery_order" ORDER BY documents.id ASC');
        return datatables()->of($document_data)
        ->addIndexColumn()
        ->make(true);
    } 

    public function calcDOBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $record_id = $_POST['baseRecordId'] ?? 0;
        $store_id = $_POST['storeval'] ?? 0;
        $item_id = $_POST['itemid'] ?? 0;

        $item_prop = Regitem::leftJoin('uoms','regitems.MeasurementId','uoms.id')->where('regitems.id', $item_id)->get(['uoms.Name AS uom_name']);
        $uom_name = $item_prop[0]->uom_name;

        $item_balance_data = DB::select('SELECT (SUM(COALESCE(transactions.StockIn,0)) - SUM(COALESCE(transactions.StockOut,0))) AS available_quantity FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.StoreId='.$store_id.' AND transactions.ItemId='.$item_id);
        $other_req_data = DB::select('SELECT SUM(COALESCE(requisitiondetails.Quantity,0)) AS others_req_qty FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.SourceStoreId='.$store_id.' AND requisitiondetails.ItemId='.$item_id.' AND requisitions.Status IN("Draft","Pending","Verified","Approved")');
        $sales_data = DB::select('SELECT SUM(COALESCE(salesitems.Quantity,0)) AS sales_qty FROM salesitems LEFT JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.StoreId='.$store_id.' AND salesitems.ItemId='.$item_id.' AND sales.Status IN("pending..","Checked")');
        $transfer_data = DB::select('SELECT SUM(COALESCE(transferdetails.Quantity,0)) AS transfer_qty FROM transferdetails LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transfers.SourceStoreId='.$store_id.' AND transferdetails.ItemId='.$item_id.' AND transfers.Status IN("Draft","Pending","Verified","Reviewed","Approved")');
        $do_data = DB::select('SELECT SUM(COALESCE(delivery_order_details.quantity,0)) AS do_qty FROM delivery_order_details LEFT JOIN delivery_orders ON delivery_order_details.delivery_order_id=delivery_orders.id WHERE delivery_orders.id!='.$record_id.' AND delivery_orders.station='.$store_id.' AND delivery_order_details.regitems_id='.$item_id.' AND delivery_orders.status IN("Draft","Pending","Verified")');
        
        $main_balance = $item_balance_data[0]->available_quantity ?? 0;
        $others_req_qty = $other_req_data[0]->others_req_qty ?? 0;
        $sales_qty = $sales_data[0]->sales_qty ?? 0;
        $transfer_qty = $transfer_data[0]->transfer_qty ?? 0;
        $do_qty = $do_data[0]->do_qty ?? 0;

        $available_qty = $main_balance - $others_req_qty - $sales_qty - $transfer_qty - $do_qty;

        $available_qty = $available_qty < 0 ? 0 : $available_qty;

        return response()->json(['available_qty' => $available_qty,'uom_name' => $uom_name]);       
    }

    public function getDOStoreBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $store_id = $_POST['store_id'] ?? 0;
        $item_id = $_POST['item_id'] ?? 0;
        $record_id = $_POST['record_id'] ?? 0;

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
                    AND d.id != ".$record_id." 
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

    function resetDOQtyFn($rec_id,$ref_id,$ref_type){
        if($ref_type == 601){
            $proforma_data = DB::select('SELECT * FROM proforma_regitem WHERE proforma_regitem.proforma_id='.$ref_id.' ORDER BY proforma_regitem.id ASC');
            foreach($proforma_data as $pr_data){
                DB::table('proforma_regitem')
                ->where('proforma_regitem.id',$pr_data->id)
                ->update([
                    'proforma_regitem.issued_qty' => 
                    DB::raw('proforma_regitem.issued_qty - (SELECT delivery_order_details.quantity FROM delivery_order_details WHERE delivery_order_details.delivery_order_id='.$rec_id.' AND delivery_order_details.reference_detail_id='.$pr_data->id.')')
                ]);
            }
        }
        else if($ref_type == 602){
            $sales_order_data = DB::select('SELECT * FROM sales_order_items WHERE sales_order_items.sales_order_id='.$ref_id.' ORDER BY sales_order_items.id ASC');
            foreach($sales_order_data as $so_data){
                DB::table('sales_order_items')
                ->where('sales_order_items.id',$so_data->id)
                ->update([
                    'sales_order_items.issued_qty' => 
                    DB::raw('sales_order_items.issued_qty - (SELECT delivery_order_details.quantity FROM delivery_order_details WHERE delivery_order_details.delivery_order_id='.$rec_id.' AND delivery_order_details.reference_detail_id='.$so_data->id.')')
                ]);
            }
        }
        else if($ref_type == 603){
            $sales_invoice_data = DB::select('SELECT * FROM salesitems WHERE salesitems.HeaderId='.$ref_id.' ORDER BY salesitems.id ASC');
            foreach($sales_invoice_data as $si_data){
                DB::table('salesitems')
                ->where('salesitems.id',$si_data->id)
                ->update([
                    'salesitems.issued_qty' => 
                    DB::raw('salesitems.issued_qty - (SELECT delivery_order_details.quantity FROM delivery_order_details WHERE delivery_order_details.delivery_order_id='.$rec_id.' AND delivery_order_details.reference_detail_id='.$si_data->id.')')
                ]);
            }
        }
    }

    function updateReferenceFn($rec_id,$ref_id,$ref_type){
        $flag = 0;
        if($ref_type == 601){
            $proforma_data = DB::select('SELECT SUM(COALESCE(proforma_regitem.Quantity,0)) AS proforma_qty,SUM(COALESCE(proforma_regitem.issued_qty,0)) AS issued_qty FROM proforma_regitem WHERE proforma_regitem.proforma_id='.$ref_id);
            $proforma_qty = $proforma_data[0]->proforma_qty ?? 0;
            $issued_qty = $proforma_data[0]->issued_qty ?? 0;
            
            if($proforma_qty == $issued_qty){
                $flag = 1;
            }
            else{
                $flag = 0;
            }

            DB::table('proformas')
            ->where('proformas.id',$ref_id)
            ->update(['proformas.is_do_completed' => $flag]);
        }
        else if($ref_type == 602){
            $sales_order_data = DB::select('SELECT SUM(COALESCE(sales_order_items.quantity,0)) AS so_qty,SUM(COALESCE(sales_order_items.issued_qty,0)) AS issued_qty FROM sales_order_items WHERE sales_order_items.sales_order_id='.$ref_id);
            $so_qty = $sales_order_data[0]->so_qty ?? 0;
            $issued_qty = $sales_order_data[0]->issued_qty ?? 0;

            if($so_qty == $issued_qty){
                $flag = 1;
            }
            else{
                $flag = 0;
            }

            DB::table('sales_orders')
            ->where('sales_orders.id',$ref_id)
            ->update(['sales_orders.is_do_completed' => $flag]);
        }
        else if($ref_type == 603){
            $sales_invoice_data = DB::select('SELECT SUM(COALESCE(salesitems.Quantity,0)) AS si_qty,SUM(COALESCE(salesitems.issued_qty,0)) AS issued_qty FROM salesitems WHERE salesitems.HeaderId='.$ref_id);
            $si_qty = $sales_invoice_data[0]->si_qty ?? 0;
            $issued_qty = $sales_invoice_data[0]->issued_qty ?? 0;

            if($si_qty == $issued_qty){
                $flag = 1;
            }
            else{
                $flag = 0;
            }

            DB::table('sales')
            ->where('sales.id',$ref_id)
            ->update(['sales.is_do_completed' => $flag]);
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

    function validateDOItems($storeId,$fyear,$transactionId = null){
        $negativeItems = [];
        $trn_type = ["Begining","Beginning","Receiving","Issue","Sales","Transfer","Requisition","Adjustment","Delivery-Order"];

        $detail_item = DB::table('transactions')
                ->where('HeaderId', $transactionId)
                ->get();

        foreach ($detail_item as $item) {
            $itemId = $item->ItemId;
            $soldQty = $item->Quantity ?? 0;

            $availableQty = DB::table('transactions')
                ->where('ItemId', $itemId)
                ->where('StoreId', $storeId)
                ->where('FiscalYear', $fyear)
                ->selectRaw('COALESCE(SUM(StockIn), 0) - COALESCE(SUM(StockOut), 0) as balance')
                ->value('balance') ?? 0;

            if ($availableQty < $soldQty) {
                $itemName = DB::table('regitems')
                    ->where('id', $itemId)
                    ->distinct()
                    ->value('Name');

                $negativeItems[] = [
                    'id' => $itemId,
                    'name' => $itemName,
                    'balance' => $availableQty
                ];
            }
        }

        if (!empty($negativeItems)) {
            return [
                'status' => 456,
                'negative_items' => $negativeItems
            ];
        }
    }

    function validateItemBalances($items,$storeId,$fyear,$transactionId = null){
        $negativeItems = [];
        $trn_type = ["Begining","Beginning","Receiving","Issue","Sales","Transfer","Requisition","Adjustment","Delivery-Order"];

        $detail_item = DB::table('delivery_order_details')
                ->where('delivery_order_id', $transactionId)
                ->get();

        foreach ($detail_item as $item) {
            $itemId = $item->regitems_id;
            $modifiedQuantity = 0;
            $original_stock = $item->quantity ?? 0;

            foreach ($items ?? [] as $key => $d_item) {
                if ($d_item['ItemId'] == $item->regitems_id) {
                    $modifiedQuantity = $d_item['Quantity'];
                }
            }

            $transactions = DB::table('transactions')
                ->where('ItemId', $itemId)
                ->where('StoreId', $storeId)
                ->where('FiscalYear', $fyear)
                ->whereIn('TransactionsType',$trn_type)
                ->orderBy('id')
                ->get();

            $runningBalance = 0;
            $doFound = false;

            foreach ($transactions as $transaction) {
                $runningBalance += ($transaction->StockIn ?? 0);
                $runningBalance -= ($transaction->StockOut ?? 0);

                if ($transaction->HeaderId == $transactionId && $transaction->TransactionType == 'Delivery-Order') {
                    $doFound = true;
                    $voidqty = 0;
                    
                    // Instead of actual stock_in, use the new value for calculation
                    $runningBalance = $runningBalance - ($transaction->StockOut ?? 0) + $modifiedQuantity;  
                }

                if ($doFound && $runningBalance < 0) {
                    $itemName = DB::table('regitems')
                        ->where('id', $itemId)
                        ->distinct()
                        ->value('Name');

                    $negativeItems[] = [
                        'id' => $itemId,
                        'headerid' => $transactionId,
                        'name' => $itemName,
                        'running_balance' => $runningBalance
                    ];
                }
            }
        }

        if (!empty($negativeItems)) {
            return [
                'status' => 456,
                'negative_items' => $negativeItems
            ];
        }
    }

    public function getBatchAndSerialIssued(Request $request){
        $source_id = $_POST['source_id']; 
        $itemId = $_POST['itemId']; 
        $src_type = $_POST['source_type'];
        $batch_ids = [0];
        $received_batch_ids = [0];

        if($src_type == 11){
            $source_type = "delivery_order";
        }

        $batch_data = DB::select('SELECT batches.*,batches.id AS batch_id,batch_inventories_issues.id AS batch_issue_id,batch_inventories_issues.sold_issued_qty,regitems.Name AS item_name,CONCAT_WS(", ",CASE WHEN country.Name="--" THEN NULL ELSE country.Name END,NULLIF(brands.manufacturer,""),NULLIF(brands.Name,"")) AS brand_name,IFNULL(models.Name,"") AS model_name,CONCAT_WS(", ",CASE WHEN country.Name="--" THEN NULL ELSE country.Name END,NULLIF(brands.manufacturer,""),NULLIF(brands.Name,""),NULLIF(batches.batch_number,""),NULLIF(batches.expiry_date,"")) AS item_instance FROM batch_inventories_issues LEFT JOIN batches ON batch_inventories_issues.batches_id=batches.id LEFT JOIN regitems ON batches.item_id=regitems.id LEFT JOIN brands ON batches.brand_id=brands.id LEFT JOIN models ON batches.model_id=models.id LEFT JOIN country ON brands.countries_id=country.id WHERE batch_inventories_issues.source_id='.$source_id.' AND batches.item_id='.$itemId.' AND batch_inventories_issues.source_type="'.$source_type.'"'); 
        foreach($batch_data as $batch_row){
            $batch_ids[] = $batch_row->id;
        }
        $batch_ids = implode(',', $batch_ids);

        $rec_batch_data = DB::select('SELECT id FROM batches WHERE batches.item_id='.$itemId.' AND batches.status!="Sold/Issued"');
        foreach($rec_batch_data as $rec_batch){
            $received_batch_ids[] = $rec_batch->id;
        }
        $received_batch_ids = implode(',', $received_batch_ids);

        $serial_data = DB::select('SELECT serial_numbers.* FROM serial_numbers WHERE serial_numbers.batches_id IN('.$received_batch_ids.') AND serial_numbers.sold_issue_id IN('.$source_id.') AND serial_numbers.source_type="'.$source_type.'" AND serial_numbers.is_sold_issued=1');
        $item_instance = DB::select('SELECT CONCAT_WS(", ",CASE WHEN country.Name="--" THEN NULL ELSE country.Name END,NULLIF(brands.manufacturer,""),NULLIF(brands.Name,""),NULLIF(batches.batch_number,""),NULLIF(batches.expiry_date,"")) AS item_instance,batches.*,(COALESCE(receivings.StoreId)) AS store_id FROM batches LEFT JOIN brands ON batches.brand_id=brands.id LEFT JOIN country ON brands.countries_id=country.id LEFT JOIN receivings ON batches.source_type="receiving" AND batches.source_id=receivings.id WHERE batches.id IN('.$received_batch_ids.') AND receivings.Status="Confirmed" ORDER BY batches.expiry_date ASC');
        $serial_number_data = DB::select('SELECT * FROM serial_numbers WHERE serial_numbers.batches_id IN('.$received_batch_ids.') AND serial_numbers.is_sold_issued=0 ORDER BY serial_numbers.id ASC');

        return response()->json(['batch_data' => $batch_data,'serial_data' => $serial_data,'item_instance' => $item_instance,'serial_number_data' => $serial_number_data]);
    }

    public function getBatchQuantity(Request $request){
        $batch_id = $_POST['instance_id'];

        $batch_in_data = DB::select('SELECT SUM(COALESCE(batch_inventories.received_qty,0)) AS received_qty FROM batch_inventories WHERE batch_inventories.batches_id='.$batch_id);
        $batch_out_data = DB::select('SELECT SUM(COALESCE(batch_inventories_issues.sold_issued_qty,0)) AS sold_issued_qty FROM batch_inventories_issues WHERE batch_inventories_issues.batches_id='.$batch_id);

        $received_qty = $batch_in_data[0]->received_qty ?? 0;
        $sold_qty = $batch_out_data[0]->sold_issued_qty ?? 0;

        $available_qty = $received_qty - $sold_qty;

        $available_qty >= 0 ? $available_qty : 0;

        return response()->json(['available_qty' => $available_qty]);
    }

    public function issueBatchAndSerial(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $is_serial_req = $request->IsSerialNumberRequired;
        $issued_qty = $request->bs_item_qty;
        $transaction_type = $request->bsTransactionType;
        $header_id = $request->bsHeaderId;
        $item_id = $request->bs_item_id;
        $optype = $request->bs_operation_type;
        $variance_ids = [];
        $batch_row_no = 0;
        $inserted_qty = 0;
        $source_data = null;
        $status = null;
        $source_type = null;
        $batch_number_list = [];
        $duplicate_batch_number_row = [];
        $serial_number_list = [];
        $duplicate_serial_number_row = [];
        $item_data = Regitem::find($item_id);
        $store_id = null;
        $reference_number = null;

        $batchRules = array(
            'batch_row.*.Instance' => 'required',
            'batch_row.*.bactchQuantity' => 'required',
        );
        $batchValidation = Validator::make($request->all(), $batchRules);

        $serialRules = array(
            'serial_row.*.serialNumber' => 'required_if:IsSerialNumberRequired,Yes',
        );
        $serialValidation = Validator::make($request->all(), $serialRules);

        if($transaction_type == 11){
            $source_data = delivery_order::find($header_id);
            $status = $source_data->status;
            $store_id = $source_data->station;
            $reference_number = $source_data->document_number;
            $source_type = "delivery_order";
        }

        if($request->batch_row != null){
            foreach ($request->batch_row as $batch_key => $batch_value){
                $batch_qty = $batch_value['bactchQuantity'] ?? 0;
                $batch_row_id = $batch_value['batch_index_col'] ?? 0;
                $batch_number = trim($batch_value['Instance'] ?? "");
                ++$batch_row_no;

                $inserted_qty += (float)$batch_qty;
                $serial_qty = 0;
                
                if($request->serial_row != null){
                    foreach ($request->serial_row as $serial_key => $serial_value){
                        $parent_row_id = $serial_value['parent_row_id'] ?? 0;
                        $serial_row_id = $serial_value['serial_index_col'] ?? 0;
                        $serial_no = trim($serial_value['serialNumber'] ?? "");
                        if($batch_row_id == $parent_row_id && $serial_no != null){
                            ++$serial_qty;
                        }  
                    }
                }

                if($batch_qty != $serial_qty && $item_data->RequireSerialNumber == "Required" && ($status == "Verified" || $status == "Approved")){
                    $variance_ids[] = $batch_row_no;
                }
            }
        }

        if(
            $batchValidation->passes() &&
            $serialValidation->passes() &&
            $request->batch_row != null && 
            empty($variance_ids) &&
            ($issued_qty == $inserted_qty || $status == "Draft" || $status == "Pending")
        ){
            DB::beginTransaction();
            try{
                $submitted_ids = [];
                $submitted_ser_ids = [];
                $serial_number_count = 0;
                $db_issued_qty = 0;
                $is_fully_inserted = 0;


                $batchRowCollection = collect($request->batch_row);
                
                $batchRowCollection->chunk(100)->each(function($chunkedBatchRows) use ($request, $item_id, $header_id, $source_type,$store_id,$reference_number,$status, &$submitted_ids, &$serial_number_count, &$submitted_ser_ids) {
                    foreach ($chunkedBatchRows as $batch_key => $batch_value) {

                        DB::table('serial_numbers')
                            ->where('sold_issue_id',$header_id)
                            ->where('source_type',$source_type)
                            ->where('batches_id',$batch_value['Instance'])
                            ->update([
                                'is_sold_issued' => 0,
                                'sold_issue_id' => 0,
                                'source_type' => ""
                            ]);

                        $batch_row_id = $batch_value['batch_index_col'] ?? 0;

                        $uuid = $batch_value['batch_uuid'] != null ? $batch_value['batch_uuid'] : Str::uuid()->toString();
                        $batch_inv_id = $batch_value['batch_db_id'] != null ? $batch_value['batch_db_id'] : NULL;
                        
                        $common_data = [
                            'batches_id' => $batch_value['Instance'],
                            'sold_issued_qty' => $batch_value['bactchQuantity'],
                            'regitems_id' => $item_id,
                        ];

                        $db_data = batch_inventories_issue::where('id',$batch_inv_id)->first();

                        $permanent_data = [
                            'source_id' => $header_id,
                            'source_type' => $source_type,
                            'status' => "Sold/Issued",
                            'created_at' => Carbon::now()
                        ];

                        $edited_data = ['updated_at' => Carbon::now()];

                        $batch_parent = batch_inventories_issue::updateOrCreate([
                            'id' => $batch_inv_id
                        ],
                            array_merge($common_data, $db_data ? $edited_data : $permanent_data)
                        );

                        
                        if($status == "Approved"){
                            batch_serial_transaction::updateOrCreate([
                                'batches_id' => $batch_parent->batches_id,
                                'is_batch_or_serial' => "batch",
                                'transaction_type' => $source_type
                            ],[
                                'batches_id' => $batch_parent->batches_id,
                                'stores_id' => $store_id,
                                'reference_id' => $header_id,
                                'reference_number' => $reference_number,
                                'transaction_type' => $source_type,
                                'transaction_date' => Carbon::today()->toDateString(),
                                'is_batch_or_serial' => "batch",
                                'out_quantity' => $batch_value['bactchQuantity']
                            ]);
                        }

                        if($request->serial_row != null){        
                            foreach ($request->serial_row as $serial_key => $serial_value){
                                $parent_row_id = $serial_value['parent_row_id'] ?? 0;

                                if($batch_row_id == $parent_row_id){

                                    DB::table('serial_numbers')
                                    ->where('batches_id',$batch_value['Instance'])
                                    ->where('id',$serial_value['serialNumber'])
                                    ->update([
                                        'is_sold_issued' => 1,
                                        'sold_issue_id' => $header_id,
                                        'source_type' => $source_type
                                    ]);

                                    if($status == "Approved"){
                                        batch_serial_transaction::updateOrCreate([
                                            'batches_id' => $batch_parent->batches_id,
                                            'is_batch_or_serial' => "serial",
                                            'transaction_type' => $source_type
                                        ],[
                                            'batches_id' => $batch_parent->batches_id,
                                            'serial_number_id' => $serial_value['serialNumber'],
                                            'stores_id' => $store_id,
                                            'reference_id' => $header_id,
                                            'reference_number' => $reference_number,
                                            'transaction_type' => $source_type,
                                            'transaction_date' => Carbon::today()->toDateString(),
                                            'is_batch_or_serial' => "serial",
                                            'out_quantity' => 1
                                        ]);
                                    }

                                    $submitted_ser_ids[] = $serial_value['serialNumber'];
                                    $serial_number_count++;
                                }
                            }
                        }
                        $submitted_ids[] = $batch_parent->batches_id;
                    }
                });

                $serial_number_ids = [];
                $serial_number_data = DB::select('SELECT serial_numbers.id FROM serial_numbers LEFT JOIN batches ON serial_numbers.batches_id=batches.id LEFT JOIN regitems ON batches.item_id=regitems.id WHERE serial_numbers.sold_issue_id='.$header_id.' AND batches.item_id='.$item_id.' AND serial_numbers.source_type="'.$source_type.'"');
                foreach($serial_number_data as $ser_row){
                    $serial_number_ids[] = $ser_row->id;
                }
                $to_be_removed = array_diff($serial_number_ids, $submitted_ser_ids);

                DB::table('batch_inventories_issues')
                    ->leftJoin('batches','batch_inventories_issues.batches_id','batches.id')
                    ->where('batch_inventories_issues.source_id', $header_id)
                    ->where('batches.item_id', $item_id)
                    ->where('batch_inventories_issues.source_type', $source_type)
                    ->whereNotIn('batch_inventories_issues.batches_id', $submitted_ids)
                    ->delete();
                
                DB::table('batch_serial_transactions')
                    ->leftJoin('batches','batch_serial_transactions.batches_id','batches.id')
                    ->where('batches.source_id', $header_id)
                    ->where('batches.item_id', $item_id)
                    ->where('batches.source_type', $source_type)
                    ->whereNotIn('batch_serial_transactions.batches_id', $submitted_ids)
                    ->delete();

                DB::table('batch_serial_transactions')
                    ->leftJoin('batches','batch_serial_transactions.batches_id','batches.id')
                    ->where('batch_serial_transactions.transaction_type', $source_type)
                    ->where('batch_serial_transactions.reference_id', $header_id)
                    ->whereIn('batch_serial_transactions.serial_number_id', $to_be_removed)
                    ->where('batch_serial_transactions.is_batch_or_serial',"serial")
                    ->delete();

                if($transaction_type == 11){
                    $do_detail_data = delivery_order_detail::where('delivery_order_id',$header_id)->where('regitems_id',$item_id)->first();
                    $db_issued_qty = $do_detail_data->quantity;
                }

                if($item_data->RequireSerialNumber == "Required"){   
                    if($db_issued_qty == $inserted_qty && $db_issued_qty == $serial_number_count){
                        $is_fully_inserted = 1;
                    }
                    else{
                        $is_fully_inserted = 0;
                    }
                }
                else if($item_data->RequireSerialNumber == "Not-Require"){
                    if($db_issued_qty == $inserted_qty){
                        $is_fully_inserted = 1;
                    }
                    else{
                        $is_fully_inserted = 0;
                    }
                }

                if($transaction_type == 11){
                    DB::table('delivery_order_details')
                    ->where('delivery_order_id',$header_id)
                    ->where('regitems_id',$item_id)
                    ->update(['delivery_order_details.is_fully_entered' => $is_fully_inserted,'delivery_order_details.entered_qty' => $inserted_qty,'entered_serial_qty' => $serial_number_count]);
                }

                if($optype == 1){
                    $actions = "Batch and/or Serial Numbers Created for [{$item_data->Name}] item";
                    $log_status = "Created";
                }
                else{
                    $actions = "Batch and/or Serial Numbers Edited for [{$item_data->Name}] item";
                    $log_status = "Edited";
                }

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $header_id,
                    'pagename' => $source_type,
                    'action' => $actions,
                    'status' => $log_status,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'header_id' => $header_id,'trn_type' => $transaction_type]);
            }
            
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' => $e->getMessage()]);
            }
        }
        else if($batchValidation->fails()){
            return response()->json(['errorbatch' => $batchValidation->errors()->all()]);
        }
        else if($serialValidation->fails()){
            return response()->json(['errorserial'=> $serialValidation->errors()->all()]);
        }
        else if($request->batch_row == null){
            return response()->json(['empty_batch' => 462]);
        }
        else if(!empty($variance_ids)){
            return response()->json(['variances' => $variance_ids]);
        }
        else if ($issued_qty != $inserted_qty && ($status == "Verified" || $status == "Approved")){
            return response()->json(['batch_variances' => 472]);
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

    public function randNumber(): int{
        return random_int(100000, 999999);
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
