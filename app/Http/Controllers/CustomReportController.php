<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sales;
use App\Models\Salesitem;
use App\Models\customer;
use App\Models\Regitem;
use App\Models\companyinfo;
use App\Models\systeminfo;
use Invoice;
use Carbon\Carbon;
use App\Reports\MyReport;
use App\Reports\salesbyCustomer;
use App\Reports\salesbyItem;
use App\Reports\WitholdReport;
use App\Reports\SalesDetailReport;
use Illuminate\Support\Facades\Response;

use App\Reports\ItemReport;
use Illuminate\Support\Facades\Validator;
use PdfReport;
use PDF;
use DB;
use DateTime;
use DateTimeZone;
use Image;

class CustomReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from sales INNER JOIN stores ON sales.StoreId=stores.id WHERE stores.type="Shop" AND sales.Status="Confirmed" AND sales.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=12) GROUP BY StoreId,stores.id,stores.Name');
        if($request->ajax()) {
            return view('report.custom',['compInfo'=>$compInfo,'store'=>$store])->renderSections()['content'];
        }
        else{
            return view('report.custom',['compInfo'=>$compInfo,'store'=>$store]);
        }
    }

    public function custdata($from,$to,$store){
        $query = DB::select("SELECT regitems.Code AS ItemID,regitems.Name AS Description,uoms.Name AS uom_name,CONCAT(customers.TinNumber) AS TinNumber,customers.Name AS CustomerName,DATE_FORMAT(sales.CreatedDate,'%m/%d/%Y') AS CreatedDate,salesitems.Quantity,salesitems.UnitPrice,salesitems.BeforeTaxPrice,salesitems.TaxAmount,sales.invoiceNo,CASE WHEN sales.VoucherType='Fiscal-Receipt' THEN CONCAT('FS-',sales.VoucherNumber) WHEN sales.VoucherType='Manual-Receipt' THEN CONCAT(sales.VoucherNumber) END AS VoucherNumber,IFNULL(sales.invoiceNo,'') AS InvoiceNumber,sales.CustomerMRC FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id LEFT JOIN customers ON sales.CustomerId=customers.id LEFT JOIN regitems ON salesitems.ItemId=regitems.id LEFT JOIN uoms on regitems.MeasurementId=uoms.id WHERE sales.Status='Confirmed' AND DATE(sales.CreatedDate)>='".$from."' AND DATE(sales.CreatedDate)<='".$to."' AND sales.StoreId IN(".$store.") ORDER BY sales.CreatedDate ASC");
        return datatables()->of($query)->addIndexColumn()->toJson();
    }

    public function prindex(Request $request)
    {
        //
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from receivings INNER JOIN stores ON receivings.StoreId=stores.id WHERE receivings.Status="Confirmed" AND receivings.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=13) GROUP BY StoreId,stores.id,stores.Name');
        if($request->ajax()) {
            return view('inventory.report.prcustom',['compInfo'=>$compInfo,'store'=>$store])->renderSections()['content'];
        }
        else{
            return view('inventory.report.prcustom',['compInfo'=>$compInfo,'store'=>$store]);
        }
    }

    public function suppdata($from,$to,$store){
        $query = DB::select("SELECT regitems.Code AS ItemID,regitems.Name AS Description,uoms.Name AS uom_name,CONCAT(customers.TinNumber) AS TinNumber,customers.Name AS CustomerName,DATE_FORMAT(receivings.TransactionDate,'%m/%d/%Y') AS TransactionDate,receivingdetails.Quantity,receivingdetails.UnitCost,receivingdetails.BeforeTaxCost,receivingdetails.TaxAmount,receivings.InvoiceNumber,CASE WHEN receivings.VoucherType='Fiscal-Receipt' THEN CONCAT('FS-',receivings.VoucherNumber) WHEN receivings.VoucherType='Manual-Receipt' THEN CONCAT(receivings.VoucherNumber) END AS VoucherNumber,receivings.CustomerMRC FROM receivingdetails LEFT JOIN receivings ON receivingdetails.HeaderId=receivings.id LEFT JOIN customers ON receivings.CustomerId=customers.id LEFT JOIN regitems ON receivingdetails.ItemId=regitems.id LEFT JOIN uoms on regitems.MeasurementId=uoms.id WHERE receivings.Status='Confirmed' AND  DATE(receivings.TransactionDate)>='".$from."' AND DATE(receivings.TransactionDate)<='".$to."' AND receivings.StoreId IN(".$store.") ORDER BY receivings.id ASC");
        return datatables()->of($query)->addIndexColumn()->toJson();
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
