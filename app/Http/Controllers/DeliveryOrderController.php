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
    public function index(Request $request)
    {
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $currentdate = Carbon::today()->toDateString();
        $station_src = DB::select('SELECT * FROM stores WHERE stores.id>1 AND stores.ActiveStatus="Active" ORDER BY stores.Name ASC');
        $customer_src = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.CustomerCategory IN("Customer","Customer&Supplier") AND customers.ActiveStatus="Active" AND customers.id>2 ORDER BY customers.Name ASC LIMIT 50');
        $uses_data = DB::select('SELECT * FROM users WHERE id>1 ORDER BY users.username ASC');
        $ref_type_data = DB::select('SELECT * FROM lookuprefs WHERE lookuprefs.Type=200 AND lookuprefs.Status=1 ORDER BY lookuprefs.LookupName ASC'); 

        if($request->ajax()) {
            return view('sales.deliveryorder',['fiscalyr' => $fyear,'curdate' => $currentdate,'station_src' => $station_src,'customer_src' => $customer_src,'uses_data' => $uses_data,'ref_type_data' => $ref_type_data])->renderSections()['content'];
        }
        else{
            return view('sales.deliveryorder',['fiscalyr' => $fyear,'curdate' => $currentdate,'station_src' => $station_src,'customer_src' => $customer_src,'uses_data' => $uses_data,'ref_type_data' => $ref_type_data]);
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

        if($reference_type == 601){
            $proforma_data = DB::select('SELECT proformas.CustomerId AS customer_id,proformas.expireDate,proformas.Username FROM proformas WHERE proformas.id='.$reference_id);
            $customer_id = $proforma_data[0]->customer_id;
            $customer_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.id='.$customer_id);
            $main_data = $proforma_data;
        }
        else if($reference_type == 602){
            $sales_order_data = DB::select('SELECT sales_orders.customer_id,sales_orders.expiredate,users.username FROM sales_orders LEFT JOIN users ON sales_orders.user_id=users.id WHERE sales_orders.id='.$reference_id);
            $customer_id = $sales_order_data[0]->customer_id;
            $customer_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.id='.$customer_id);
            $main_data = $sales_order_data;
        }
        else if($reference_type == 603){
            $sales_invoice_data = DB::select('SELECT sales.CustomerId AS customer_id,sales.PaymentType,sales.Username FROM sales WHERE sales.id='.$reference_id);
            $customer_id = $sales_invoice_data[0]->customer_id;
            $customer_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.id='.$customer_id);
            $main_data = $sales_invoice_data;
        }

        return response()->json(['customer_data' => $customer_data,'main_data' => $main_data]);
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
