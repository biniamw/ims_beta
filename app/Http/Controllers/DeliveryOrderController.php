<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Exception;
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

        $delivery_data = [
            'fiscalyr' => $fyear,'curdate' => $currentdate,'station_src' => $station_src,
            'customer_src' => $customer_src,'uses_data' => $uses_data,'ref_type_data' => $ref_type_data,
            'itemSrcs' => $itemSrcs
        ];

        if($request->ajax()) {
            return view('sales.deliveryorder',$delivery_data)->renderSections()['content'];
        }
        else{
            return view('sales.deliveryorder',$delivery_data);
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

            $detail_data = DB::select('SELECT proforma_regitem.id,proforma_regitem.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,proforma_regitem.Quantity,proforma_regitem.issued_qty,proforma_regitem.UnitPrice,proforma_regitem.BeforeTaxPrice FROM proforma_regitem LEFT JOIN regitems ON proforma_regitem.regitem_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE proforma_regitem.proforma_id='.$reference_id.' ORDER BY proforma_regitem.id ASC');
        }
        else if($reference_type == 602){
            $sales_order_data = DB::select('SELECT sales_orders.customer_id,sales_orders.expiredate,users.username,"Goods" AS product_type,sales_orders.store_id,stores.Name AS station FROM sales_orders LEFT JOIN stores ON sales_orders.store_id=stores.id LEFT JOIN users ON sales_orders.user_id=users.id WHERE sales_orders.id='.$reference_id);
            $customer_id = $sales_order_data[0]->customer_id;
            $customer_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.id='.$customer_id);
            $main_data = $sales_order_data;

            $detail_data = DB::select('SELECT sales_order_items.id,sales_order_items.regitem_id AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,sales_order_items.quantity AS Quantity,sales_order_items.issued_qty,sales_order_items.unit_price AS UnitPrice,sales_order_items.total_price FROM sales_order_items LEFT JOIN regitems ON sales_order_items.regitem_id=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE sales_order_items.sales_order_id='.$reference_id.' ORDER BY sales_order_items.id ASC');
        }
        else if($reference_type == 603){
            $sales_invoice_data = DB::select('SELECT sales.CustomerId AS customer_id,sales.PaymentType,sales.Username,"Goods" AS product_type,sales.StoreId AS store_id,stores.Name AS station FROM sales LEFT JOIN stores ON sales.StoreId=stores.id WHERE sales.id='.$reference_id);
            $customer_id = $sales_invoice_data[0]->customer_id;
            $customer_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.id='.$customer_id);
            $main_data = $sales_invoice_data;

            $detail_data = DB::select('SELECT salesitems.id,salesitems.ItemId AS itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.TaxTypeId,uoms.Name AS uom_name,salesitems.Quantity,salesitems.issued_qty,salesitems.UnitPrice,salesitems.BeforeTaxPrice FROM salesitems LEFT JOIN regitems ON salesitems.ItemId=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE salesitems.HeaderId='.$reference_id.' ORDER BY salesitems.id ASC');
        }

        return response()->json(['customer_data' => $customer_data,'main_data' => $main_data,'detail_data' => $detail_data]);
    }

    public function fetchDOItemInfo(Request $request){
        $reference_type = $_POST['reference_type'];
        $reference_id = $_POST['reference_id'];
        $itemid = $_POST['itemid'];

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

        return response()->json(['item_info' => $item_info]);
    }

    public function calcDOBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $record_id = $_POST['baseRecordId'] ?? 0;
        $store_id = $_POST['storeval'] ?? 0;
        $item_id = $_POST['itemid'] ?? 0;

        $item_balance_data = DB::select('SELECT (SUM(COALESCE(StockIn,0)) - SUM(COALESCE(StockOut,0))) AS available_quantity FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.StoreId='.$store_id.' AND transactions.ItemId='.$item_id);
        $other_req_data = DB::select('SELECT SUM(COALESCE(requisitiondetails.Quantity,0)) AS others_req_qty FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.id!='.$record_id.' AND requisitions.SourceStoreId='.$store_id.' AND requisitiondetails.ItemId='.$item_id.' AND requisitions.Status IN("Draft","Pending","Verified","Approved")');
        $sales_data = DB::select('SELECT SUM(COALESCE(salesitems.Quantity,0)) AS sales_qty FROM salesitems LEFT JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.StoreId='.$store_id.' AND salesitems.ItemId='.$item_id.' AND sales.Status IN("pending..","Checked")');
        $transfer_data = DB::select('SELECT SUM(COALESCE(transferdetails.Quantity,0)) AS transfer_qty FROM transferdetails LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transfers.SourceStoreId='.$store_id.' AND transferdetails.ItemId='.$item_id.' AND transfers.Status IN("Draft","Pending","Verified","Reviewed","Approved")');

        $main_balance = $item_balance_data[0]->available_quantity ?? 0;
        $others_req_qty = $other_req_data[0]->others_req_qty ?? 0;
        $sales_qty = $sales_data[0]->sales_qty ?? 0;
        $transfer_qty = $transfer_data[0]->transfer_qty ?? 0;

        $available_qty = $main_balance - $others_req_qty - $sales_qty - $transfer_qty;

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
                    AND t.Status IN ('Draft','Pending','Verified','Reviewed','Approved'))
                ) as available_quantity")
            ])
            ->where('transactions.FiscalYear', $fyear)
            ->where('transactions.StoreId', $store_id)
            ->whereIn('transactions.ItemId', $item_id)
            ->groupBy('transactions.ItemId')
            ->get();

        return response()->json(['result' => $result]);    
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
