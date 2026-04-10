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

class RankController extends Controller
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
        $store=DB::select('SELECT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=12 AND stores.IsDeleted=1');
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $setting=DB::select('select * from settings');
        $transactionqr=DB::select('select transactions.Date from transactions WHERE transactions.FiscalYear='.$fyear.' ORDER BY transactions.id ASC LIMIT 1');
        foreach($transactionqr as $row){
            $fdate=$row->Date;
        }
        if($request->ajax()) {
            return view('report.itemrank',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate])->renderSections()['content'];
        }
        else{
            return view('report.itemrank',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate]);
        }
    }

    public function indexrcus(Request $request)
    {
        //
        $fdate="";
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=12 AND stores.IsDeleted=1');
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $setting=DB::select('select * from settings');
        $transactionqr=DB::select('select transactions.Date from transactions WHERE transactions.FiscalYear='.$fyear.' ORDER BY transactions.id ASC LIMIT 1');
        foreach($transactionqr as $row){
            $fdate=$row->Date;
        }
        if($request->ajax()) {
            return view('report.cusrank',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate])->renderSections()['content'];
        }
        else{
            return view('report.cusrank',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate]);
        }
    }

    public function itemrankreportcon(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype,$rval,$sval,$nitem)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $query = DB::select('SELECT regitems.id,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,sales.PaymentType,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id as StoreId,
        
        @purchase:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @sold:=(SELECT COALESCE(SUM((salesitems.Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.ItemId=regitems.id AND salesitems.StoreId=stores.id) AS QuantitySold,

        @revenues:=(SELECT COALESCE(ROUND(SUM((salesitems.BeforeTaxPrice)),2),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.ItemId=regitems.id AND salesitems.StoreId=stores.id) AS Revenue,

        @adjustmentplus:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @transferval:=(SELECT COALESCE(
        SUM(transactions.StockIn*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=issues.IssuedDate)),0)
        FROM transactions INNER JOIN issues ON transactions.HeaderId=issues.id WHERE transactions.TransactionsType="Transfer" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @totalsalescost:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) AS TotalTransfer FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=sales.ConfirmedDate)),0)
        FROM transactions INNER JOIN sales ON transactions.HeaderId=sales.id WHERE transactions.TransactionsType="Sales" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id AND sales.fiscalyear='.$fiscalyear.' AND sales.Status="Confirmed" AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND sales.PaymentType IN('.$ptype.')),
       
        @balances:=(SELECT COALESCE(SUM(transactions.StockIn)-SUM((transactions.StockOut)),0) FROM transactions WHERE DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @average:=(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>="'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id),   
        @sold,
        @revenues,
        @endinginv:=@balances*@average,
        @totalstockout:=@totalsalescost,
        @totalstockin:=@purchase+@adjustmentplus+@transferval,
        @begininginv:=(@totalstockout+@endinginv)-@totalstockin,
        @cogs:=(@begininginv+@totalstockin)-@endinginv,
        @grossprofit:=@revenues-@cogs AS GrossProfit
       
        FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE sales.Status="Confirmed" AND regitems.itemGroup IN('.$itgrp.') AND sales.fiscalyear='.$fiscalyear.' and sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.StoreId IN('.$store.') AND sales.PaymentType IN('.$ptype.') GROUP BY regitems.id HAVING Revenue>0 ORDER BY '.$rval.' '.$sval.' LIMIT '.$nitem.'');
        return datatables()->of($query)->addIndexColumn()->toJson();
    }

    public function cusrankreportcon(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype,$rval,$sval,$nitem)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $query = DB::select('SELECT customers.Name AS CustomerName,customers.Code AS CustomerCode,customers.TinNumber,customers.DefaultPrice,COALESCE(ROUND(SUM((salesitems.BeforeTaxPrice)),2),0) AS Revenue,
        (COALESCE(ROUND(SUM((salesitems.BeforeTaxPrice)),2),0)-COALESCE(SUM(salesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=sales.ConfirmedDate)),0)) AS GrossProfit,"" AS QuantitySold 
        FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status="Confirmed" AND regitems.itemGroup IN('.$itgrp.') AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.StoreId IN('.$store.') AND sales.PaymentType IN('.$ptype.') AND customers.id IN(SELECT DISTINCT CustomerId FROM sales WHERE sales.fiscalyear='.$fiscalyear.')
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
