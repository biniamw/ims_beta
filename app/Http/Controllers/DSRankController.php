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
use App\Reports\MyReport;
use App\Reports\ItemReport;
use App\Reports\StoreMovementReport;
use Response;
use PdfReport;
use PDF;
use DB;
use DateTime;
use DateTimeZone;
use Session;

class DSRankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $fdate="";
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.Name as StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1');
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        //$fyear=$settings->FiscalYear;
        $fyear=2021;
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $sd="2021-07-08";
        $ed = Carbon::today()->toDateString();
        $setting=DB::select('select * from settings');
        $transactionqr=DB::select('select deadstocktransaction.Date from deadstocktransaction WHERE deadstocktransaction.FiscalYear='.$fyear.' ORDER BY deadstocktransaction.id ASC LIMIT 1');
        foreach($transactionqr as $row){
            $fdate=$row->Date;
        }
        if($request->ajax()) {
            return view('inventory.report.dsitemrank',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dsitemrank',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed]);
        }
    }

    public function indexdscusrank(Request $request)
    {
        //
        $fdate="";
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.Name as StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1');
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        //$fyear=$settings->FiscalYear;
        $fyear=2021;
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $sd="2021-07-08";
        $ed = Carbon::today()->toDateString();
        $setting=DB::select('select * from settings');
        $transactionqr=DB::select('select deadstocktransaction.Date from deadstocktransaction WHERE deadstocktransaction.FiscalYear='.$fyear.' ORDER BY deadstocktransaction.id ASC LIMIT 1');
        foreach($transactionqr as $row){
            $fdate=$row->Date;
        }
        if($request->ajax()) {
            return view('inventory.report.dscusrank',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dscusrank',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed]);
        }
    }

    public function dsitemrankreportcon(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype,$rval,$sval,$nitem)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $selectedtype=$_POST['pullouttypeval'];
        $sltype=implode(',', $selectedtype);
        $query = DB::select('SELECT regitems.id,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,deadstocksale.PaymentType,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id as StoreId,
        
        @purchase:=(SELECT COALESCE(SUM((deadstocktransaction.BeforeTaxCost)),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("HandIn","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND DATE(deadstocktransaction.Date)>= "'.$from.'" AND DATE(deadstocktransaction.Date)<="'.$to.'" AND deadstocktransaction.FiscalYear='.$fiscalyear.' AND deadstocktransaction.ItemId=regitems.id AND deadstocktransaction.StoreId=stores.id),

        @sold:=(SELECT COALESCE(SUM((deadstocksalesitems.Quantity)),0) FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id WHERE deadstocksale.Status="Confirmed/Removed" AND deadstocksale.CreatedDate>="'.$from.'" AND deadstocksale.CreatedDate<="'.$to.'" AND deadstocksalesitems.ItemId=regitems.id AND deadstocksalesitems.StoreId=stores.id) AS QuantitySold,

        @revenues:=(SELECT COALESCE(SUM((deadstocksalesitems.TotalPrice)),0) FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id WHERE deadstocksale.Status="Confirmed/Removed" AND deadstocksale.CreatedDate>="'.$from.'" AND deadstocksale.CreatedDate<="'.$to.'" AND deadstocksale.Type IN('.$sltype.') AND deadstocksalesitems.ItemId=regitems.id AND deadstocksalesitems.StoreId=stores.id) AS Revenue,

        @adjustmentplus:=(SELECT COALESCE(SUM((deadstocktransaction.BeforeTaxCost)),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND DATE(deadstocktransaction.Date)>= "'.$from.'" AND DATE(deadstocktransaction.Date)<="'.$to.'" AND deadstocktransaction.FiscalYear='.$fiscalyear.' AND deadstocktransaction.ItemId=regitems.id AND deadstocktransaction.StoreId=stores.id),

        @transferval:=(SELECT COALESCE(
        SUM(deadstocktransaction.StockIn*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=issues.IssuedDate)),0)
        FROM deadstocktransaction INNER JOIN issues ON deadstocktransaction.HeaderId=issues.id WHERE deadstocktransaction.TransactionsType="Transfer" AND deadstocktransaction.FiscalYear='.$fiscalyear.' AND deadstocktransaction.ItemId=regitems.id AND deadstocktransaction.StoreId=stores.id),

        @totaldeadstocksalecost:=(SELECT COALESCE(
        SUM(deadstocktransaction.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0)
        FROM deadstocktransaction INNER JOIN deadstocksale ON deadstocktransaction.HeaderId=deadstocksale.id WHERE deadstocktransaction.TransactionsType="PullOut" AND deadstocktransaction.FiscalYear='.$fiscalyear.' AND deadstocktransaction.ItemId=regitems.id AND deadstocktransaction.StoreId=stores.id AND deadstocksale.Status="Confirmed/Removed" AND deadstocksale.CreatedDate>="'.$from.'" AND deadstocksale.CreatedDate<="'.$to.'" AND deadstocksale.PaymentType IN('.$ptype.') AND deadstocksale.Type IN('.$sltype.')),
       
        @balances:=(SELECT COALESCE(SUM(deadstocktransaction.StockIn)-SUM((deadstocktransaction.StockOut)),0) FROM deadstocktransaction WHERE DATE(deadstocktransaction.Date)>= "'.$from.'" AND DATE(deadstocktransaction.Date)<="'.$to.'" AND deadstocktransaction.FiscalYear='.$fiscalyear.' AND deadstocktransaction.ItemId=regitems.id AND deadstocktransaction.StoreId=stores.id),

        @average:=(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND DATE(deadstocktransaction.Date)>="'.$from.'" AND DATE(deadstocktransaction.Date)<="'.$to.'" AND deadstocktransaction.FiscalYear='.$fiscalyear.' AND deadstocktransaction.ItemId=regitems.id),   
        @sold,
        @revenues,
        @endinginv:=@balances*@average,
        @totalstockout:=@totaldeadstocksalecost,
        @totalstockin:=@purchase+@adjustmentplus+@transferval,
        @begininginv:=(@totalstockout+@endinginv)-@totalstockin,
        @cogs:=(@begininginv+@totalstockin)-@endinginv,
        @grossprofit:=@revenues-@cogs AS GrossProfit
       
        FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id INNER JOIN customers ON deadstocksale.CustomerId=customers.id INNER JOIN stores ON deadstocksale.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE deadstocksale.Status="Confirmed/Removed" AND regitems.itemGroup IN('.$itgrp.') AND deadstocksale.CreatedDate>="'.$from.'" AND deadstocksale.CreatedDate<="'.$to.'" AND deadstocksalesitems.StoreId IN('.$store.') AND deadstocksale.PaymentType IN('.$ptype.') AND deadstocksale.Type IN('.$sltype.')
        GROUP BY regitems.id HAVING Revenue>0 ORDER BY '.$rval.' '.$sval.' LIMIT '.$nitem.'');
        return datatables()->of($query)->addIndexColumn()->toJson();
    }

    public function dscusrankreportcon(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype,$rval,$sval,$nitem)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $selectedtype=$_POST['pullouttypeval'];
        $sltype=implode(',', $selectedtype);
        $query = DB::select('SELECT customers.Name AS CustomerName,customers.Code AS CustomerCode,customers.TinNumber,customers.DefaultPrice,COALESCE(SUM((deadstocksalesitems.TotalPrice)),0) AS Revenue,
        (COALESCE(SUM((deadstocksalesitems.TotalPrice)),0)-COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0)) AS GrossProfit,"" AS QuantitySold 
        FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id INNER JOIN customers ON deadstocksale.CustomerId=customers.id INNER JOIN stores ON deadstocksale.StoreId=stores.id WHERE deadstocksale.Status="Confirmed/Removed" AND regitems.itemGroup IN('.$itgrp.') AND deadstocksale.CreatedDate>="'.$from.'" AND deadstocksale.CreatedDate<="'.$to.'" AND deadstocksalesitems.StoreId IN('.$store.') AND deadstocksale.PaymentType IN('.$ptype.') AND deadstocksale.Type IN('.$sltype.') AND customers.id IN(SELECT DISTINCT CustomerId FROM deadstocksale)
        GROUP BY customers.id HAVING Revenue>0 ORDER BY '.$rval.' '.$sval.' LIMIT '.$nitem.'');
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
