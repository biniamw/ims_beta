<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sales;
use App\Models\Salesitem;
use App\Models\customer;
use App\Models\companyinfo;
use App\Models\systeminfo;
use Invoice;
use Carbon\Carbon;
use App\Models\Regitem;
use App\Reports\MyReport;
use App\Reports\ItemReport;
use App\Reports\PurchaseReport;
use App\Reports\PurchaseBySupplier;
use App\Reports\PurchaseByItem;
use App\Reports\PurchaseDetail;
use App\Reports\StoreMovementReport;
use Response;
use PdfReport;
use PDF;
use DB;
use DateTime;
use DateTimeZone;
use Session;

class DsPoHiReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function dspoReport(Request $request)
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $companyname=$compInfo->Name;
        $companytin=$compInfo->TIN;
        $companyvat=$compInfo->VATReg;
        $companyphone=$compInfo->Phone;
        $companyoffphone=$compInfo->OfficePhone;
        $companyemail=$compInfo->Email;
        $companyaddress=$compInfo->Address;
        $companywebsite=$compInfo->Website;
        $companycountry=$compInfo->Country;
        $companyLogo=$compInfo->Logo;
        $companyalladdress=$compInfo->AllAddress;
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from deadstocksale INNER JOIN stores ON deadstocksale.StoreId=stores.id WHERE deadstocksale.Status="Confirmed/Removed" GROUP BY StoreId,stores.id,stores.Name');
        
        if($request->ajax()) {
            return view('inventory.report.dsgenpo',['store'=>$store,'companyname'=>$companyname,
            'companytin'=>$companytin,
            'companyvat'=>$companyvat,
            'companyphone'=>$companyphone,
            'companyoffphone'=>$companyoffphone,
            'companyemail'=>$companyemail,
            'companyaddress'=>$companyaddress,
            'companywebsite'=>$companywebsite,
            'companycountry'=>$companycountry,
            'companyalladdress'=>$companyalladdress,
            'companyLogo'=>$companyLogo,'compInfo'=>$compInfo])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dsgenpo',['store'=>$store,'companyname'=>$companyname,
            'companytin'=>$companytin,
            'companyvat'=>$companyvat,
            'companyphone'=>$companyphone,
            'companyoffphone'=>$companyoffphone,
            'companyemail'=>$companyemail,
            'companyaddress'=>$companyaddress,
            'companywebsite'=>$companywebsite,
            'companycountry'=>$companycountry,
            'companyalladdress'=>$companyalladdress,
            'companyLogo'=>$companyLogo,'compInfo'=>$compInfo]); 
        }     
    }

    public function DSPOReportCon($from,$to,$store,$paymentype,$group,$potype)
    {  
        $ptypes=$paymentype.','."''".','.'NULL';
        $query = DB::select("SELECT categories.Name AS Category,stores.Name as StoreName,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber,deadstocksale.PaymentType,uoms.Name AS UOM,SUM(deadstocksalesitems.Quantity) AS Quantity,deadstocksalesitems.UnitPrice,COALESCE(ROUND(SUM((deadstocksalesitems.BeforeTaxPrice)),2),0) AS BeforeTaxPrice,COALESCE(ROUND(SUM((deadstocksalesitems.TaxAmount)),2),0) AS Tax,COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0) AS TotalPrice,deadstocksale.Status,deadstocksale.Type FROM deadstocksalesitems INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON deadstocksalesitems.NewUOMId=uoms.id INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN stores ON deadstocksale.StoreId=stores.id where DATE(deadstocksale.CreatedDate)>= '".$from."' AND DATE(deadstocksale.CreatedDate)<='".$to."' AND deadstocksale.StoreId IN($store) AND deadstocksale.PaymentType IN($ptypes) AND regitems.itemGroup IN($group) AND deadstocksale.Status='Confirmed/Removed' AND deadstocksale.Type IN($potype) GROUP BY deadstocksalesitems.ItemId,categories.Name,regitems.Name,regitems.Code,regitems.SKUNumber,uoms.Name,deadstocksalesitems.UnitPrice,deadstocksale.PaymentType,stores.Name,deadstocksale.Status ORDER BY deadstocksale.Type ASC,deadstocksale.PaymentType ASC,categories.Name ASC");
        return datatables()->of($query)->toJson();
    }

    public function dshiReport(Request $request)
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $companyname=$compInfo->Name;
        $companytin=$compInfo->TIN;
        $companyvat=$compInfo->VATReg;
        $companyphone=$compInfo->Phone;
        $companyoffphone=$compInfo->OfficePhone;
        $companyemail=$compInfo->Email;
        $companyaddress=$compInfo->Address;
        $companywebsite=$compInfo->Website;
        $companycountry=$compInfo->Country;
        $companyLogo=$compInfo->Logo;
        $companyalladdress=$compInfo->AllAddress;
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from deadstocksale INNER JOIN stores ON deadstocksale.StoreId=stores.id WHERE deadstocksale.Status="Confirmed/Removed" GROUP BY StoreId,stores.id,stores.Name');
        if($request->ajax()) {
            return view('inventory.report.dsgenhi',['store'=>$store,'companyname'=>$companyname,
            'companytin'=>$companytin,
            'companyvat'=>$companyvat,
            'companyphone'=>$companyphone,
            'companyoffphone'=>$companyoffphone,
            'companyemail'=>$companyemail,
            'companyaddress'=>$companyaddress,
            'companywebsite'=>$companywebsite,
            'companycountry'=>$companycountry,
            'companyalladdress'=>$companyalladdress,
            'companyLogo'=>$companyLogo,'compInfo'=>$compInfo])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dsgenhi',['store'=>$store,'companyname'=>$companyname,
            'companytin'=>$companytin,
            'companyvat'=>$companyvat,
            'companyphone'=>$companyphone,
            'companyoffphone'=>$companyoffphone,
            'companyemail'=>$companyemail,
            'companyaddress'=>$companyaddress,
            'companywebsite'=>$companywebsite,
            'companycountry'=>$companycountry,
            'companyalladdress'=>$companyalladdress,
            'companyLogo'=>$companyLogo,'compInfo'=>$compInfo]);  
        }  
    }

    public function DSHIReportCon($from,$to,$store,$paymentype,$hitype)
    {  
        $ptypes=$paymentype.','."''".','.'NULL';
        $query = DB::select("SELECT categories.Name AS Category,stores.Name as StoreName,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber,deadstockrecs.PaymentType,uoms.Name AS UOM,SUM(deadstockdetails.Quantity) AS Quantity,deadstockdetails.UnitCost,TRUNCATE(SUM(deadstockdetails.BeforeTaxCost),2) AS BeforeTaxCost,TRUNCATE(SUM(deadstockdetails.TaxAmount),2) AS Tax,TRUNCATE(SUM(deadstockdetails.TotalCost),2) AS TotalCost,deadstockrecs.Status,deadstockrecs.Type FROM deadstockdetails INNER JOIN regitems ON deadstockdetails.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON deadstockdetails.NewUOMId=uoms.id INNER JOIN deadstockrecs ON deadstockdetails.HeaderId=deadstockrecs.id INNER JOIN stores ON deadstockrecs.StoreId=stores.id where DATE(deadstockrecs.TransactionDate)>= '".$from."' AND DATE(deadstockrecs.TransactionDate)<='".$to."' AND deadstockrecs.StoreId IN($store) AND deadstockrecs.PaymentType IN ($ptypes) AND deadstockrecs.Type IN($hitype) AND deadstockrecs.Status='Confirmed/Defective' GROUP BY deadstockdetails.ItemId,categories.Name,regitems.Name,regitems.Code,regitems.SKUNumber,uoms.Name,deadstockdetails.UnitCost,deadstockrecs.PaymentType,stores.Name,deadstockrecs.Status ORDER BY deadstockrecs.Type ASC,deadstockrecs.PaymentType ASC,categories.Name ASC");
        return datatables()->of($query)->toJson();
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
