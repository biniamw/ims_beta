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

class DSProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fdate="";
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.Name as StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1');
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->DSFiscalYear;
        $sd=$fyear."-07-08";
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC'); 
        $ed = Carbon::today()->toDateString();
        $setting=DB::select('select * from settings');
        $transactionqr=DB::select('select deadstocktransaction.Date from deadstocktransaction WHERE deadstocktransaction.FiscalYear='.$fyear.' ORDER BY deadstocktransaction.id ASC LIMIT 1');
        foreach($transactionqr as $row){
            $fdate=$row->Date;
        }
        if($request->ajax()) {
            return view('inventory.report.dsplreport',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dsplreport',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed]);
        }
    }

    public function indexdssum(Request $request)
    {
        $fdate="";
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.Name as StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1');
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->DSFiscalYear;
        $sd=$fyear."-07-08";
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $ed = Carbon::today()->toDateString();
        $setting=DB::select('select * from settings');
        $transactionqr=DB::select('select deadstocktransaction.Date from deadstocktransaction WHERE deadstocktransaction.FiscalYear='.$fyear.' ORDER BY deadstocktransaction.id ASC LIMIT 1');
        foreach($transactionqr as $row){
            $fdate=$row->Date;
        }
        if($request->ajax()) {
            return view('inventory.report.dsplreportsum',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dsplreportsum',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed]);
        }
    }

    public function indexdscus(Request $request)
    {
        $fdate="";
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.Name as StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1');
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->DSFiscalYear;
        $sd=$fyear."-07-08";
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $ed = Carbon::today()->toDateString();
        $setting=DB::select('select * from settings');
        $transactionqr=DB::select('select deadstocktransaction.Date from deadstocktransaction WHERE deadstocktransaction.FiscalYear='.$fyear.' ORDER BY deadstocktransaction.id ASC LIMIT 1');
        foreach($transactionqr as $row){
            $fdate=$row->Date;
        }
        if($request->ajax()) {
            return view('inventory.report.dsplreportcus',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dsplreportcus',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed]);
        }
    }

    public function indexdsitm(Request $request)
    {
        $fdate="";
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.Name as StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1');
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->DSFiscalYear;
        $sd=$fyear."-07-08";
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $ed = Carbon::today()->toDateString();
        $setting=DB::select('select * from settings');
        $transactionqr=DB::select('select deadstocktransaction.Date from deadstocktransaction WHERE deadstocktransaction.FiscalYear='.$fyear.' ORDER BY deadstocktransaction.id ASC LIMIT 1');
        foreach($transactionqr as $row){
            $fdate=$row->Date;
        }
        if($request->ajax()) {
            return view('inventory.report.dsplreportitm',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dsplreportitm',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate,'sd'=>$sd,'ed'=>$ed]);
        }
    }

    public function getDSCusBySelectedStorePl(Request $request,$sid,$fy)
    {
        $query = DB::select('SELECT DISTINCT customers.Name AS CustomerName,customers.Code,customers.TinNumber,deadstocksale.CustomerId FROM deadstocksale INNER JOIN customers ON deadstocksale.CustomerId=customers.id WHERE deadstocksale.StoreId IN('.$sid.') order by customers.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function getDSItemsBySelectedStorePl(Request $request,$sid,$fy)
    {
        $query = DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,deadstocksalesitems.ItemId FROM deadstocksalesitems INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id INNER JOIN sales ON deadstocksalesitems.HeaderId=sales.id WHERE deadstocksalesitems.StoreId IN('.$sid.') order by regitems.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function getdspostore(Request $request,$fy)
    {
        $fdate="";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $transactionqr=DB::select('select deadstocktransaction.Date from deadstocktransaction WHERE deadstocktransaction.FiscalYear='.$fyear.' ORDER BY deadstocktransaction.id ASC LIMIT 1');
        foreach($transactionqr as $row){
            $fdate=$row->Date;
        }
        //$query = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE deadstocktransaction.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=14) AND stores.IsDeleted=1 AND stores.id>1 AND deadstocktransaction.FiscalYear='.$fy.' ORDER BY stores.Name ASC;');
        $query = DB::select('SELECT DISTINCT deadstocksale.StoreId,stores.Name AS StoreName FROM deadstocksale INNER JOIN stores ON deadstocksale.StoreId=stores.id WHERE deadstocksale.Status="Confirmed/Removed" AND stores.id>1 AND stores.IsDeleted=1 ORDER BY stores.Name ASC');
        return response()->json(['query'=>$query,'fdate'=>$fdate]);
    } 

    public function dsplreportcon(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype,$pltype)
    {
        $pval=null;
        $lval=null;
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $pltypeval=str_replace(',', '', $pltype);
        if($pltypeval==10){
            $pval=100000;
            $lval="-10000";
        }
        if($pltypeval==1){
            $pval=100000;
            $lval=0;
        }
        if($pltypeval==0){
            $pval=0;
            $lval="-10000";
        }
        $selectedtype=$_POST['pullouttypeval'];
        $sltype=implode(',', $selectedtype);

        $query = DB::select('SELECT regitems.id AS ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,deadstocksale.PaymentType,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id AS StoreId,deadstocksale.Type AS POType,

        COALESCE(ROUND(SUM((deadstocksalesitems.Quantity)),2),0) AS QuantitySold,COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0) AS Revenue,
        COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0) AS COGS,
                
        COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)-COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0) AS GrossProfit,

        ((COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)-COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0)) / (COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)))*100 AS GrossProfitPer

        FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id INNER JOIN customers ON deadstocksale.CustomerId=customers.id INNER JOIN stores ON deadstocksale.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE deadstocksale.Status="Confirmed/Removed" AND deadstocksale.CreatedDate>="'.$from.'" AND deadstocksale.CreatedDate<="'.$to.'" AND deadstocksalesitems.StoreId IN('.$store.') AND regitems.itemGroup IN('.$itgrp.') AND deadstocksale.PaymentType IN('.$ptype.') AND
        deadstocksale.Type IN('.$sltype.') AND deadstocksalesitems.ItemId IN(SELECT id from regitems where regitems.IsDeleted=1)

        GROUP BY regitems.id,stores.id,categories.Name HAVING GrossProfitPer>'.$lval.' AND GrossProfitPer<'.$pval.' AND Revenue>0 
        ORDER BY stores.Name ASC,deadstocksale.Type ASC,deadstocksale.PaymentType ASC,categories.Name ASC');
        return datatables()->of($query)->toJson();
    }

    public function dsplreportconsum(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype,$pltype)
    {
        $pval=null;
        $lval=null;
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $pltypeval=str_replace(',', '', $pltype);
        if($pltypeval==10){
            $pval=100000;
            $lval="-10000";
        }
        if($pltypeval==1){
            $pval=100000;
            $lval=0;
        }
        if($pltypeval==0){
            $pval=0;
            $lval="-10000";
        }
        $selectedtype=$_POST['pullouttypeval'];
        $sltype=implode(',', $selectedtype);
        $selectedtype=$_POST['pullouttypeval'];
        $sltype=implode(',', $selectedtype);
        $query = DB::select('SELECT regitems.id AS ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,deadstocksale.PaymentType,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id as StoreId,

        COALESCE(ROUND(SUM((deadstocksalesitems.Quantity)),2),0) AS QuantitySold,COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0) AS Revenue,
        COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0) AS COGS,
                
        COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)-COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0) AS GrossProfit,

        ((COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)-COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0)) / (COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)))*100 AS GrossProfitPer

        FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id INNER JOIN customers ON deadstocksale.CustomerId=customers.id INNER JOIN stores ON deadstocksale.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE deadstocksale.Status="Confirmed/Removed" AND deadstocksale.CreatedDate>="'.$from.'" AND deadstocksale.CreatedDate<="'.$to.'" AND deadstocksalesitems.StoreId IN('.$store.') AND regitems.itemGroup IN('.$itgrp.') AND deadstocksale.PaymentType IN('.$ptype.') AND
        deadstocksale.Type IN('.$sltype.') AND deadstocksalesitems.ItemId IN(SELECT id from regitems where regitems.IsDeleted=1)

        GROUP BY regitems.id,stores.id,categories.Name HAVING GrossProfitPer>'.$lval.' AND GrossProfitPer<'.$pval.' AND Revenue>0 
        ORDER BY stores.Name ASC,deadstocksale.PaymentType ASC,categories.Name ASC');
        return datatables()->of($query)->toJson();
    }

    public function dsplreportconcus(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype,$pltype)
    {
        $pval=null;
        $lval=null;
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $pltypeval=str_replace(',', '', $pltype);
        if($pltypeval==10){
            $pval=100000;
            $lval="-10000";
        }
        if($pltypeval==1){
            $pval=100000;
            $lval=0;
        }
        if($pltypeval==0){
            $pval=0;
            $lval="-10000";
        }
        $selectedcustomers=$_POST['customersname'];
        $cusname=implode(',', $selectedcustomers);
        $selectedtype=$_POST['pullouttypeval'];
        $sltype=implode(',', $selectedtype);
        $query = DB::select('SELECT regitems.id AS ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,deadstocksale.PaymentType,CONCAT(customers.Name,"     (",customers.DefaultPrice,")") AS CustomerName,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id as StoreId,deadstocksale.Type AS POType,

        COALESCE(ROUND(SUM((deadstocksalesitems.Quantity)),2),0) AS QuantitySold,COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0) AS Revenue,
        COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0) AS COGS,
                
        COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)-COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0) AS GrossProfit,

        ((COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)-COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0)) / (COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)))*100 AS GrossProfitPer

        FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id INNER JOIN customers ON deadstocksale.CustomerId=customers.id INNER JOIN stores ON deadstocksale.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE deadstocksale.CustomerId IN ('.$cusname.') AND deadstocksale.Status="Confirmed/Removed" AND deadstocksale.CreatedDate>="'.$from.'" AND deadstocksale.CreatedDate<="'.$to.'" AND deadstocksalesitems.StoreId IN('.$store.') AND regitems.itemGroup IN('.$itgrp.') AND deadstocksale.PaymentType IN('.$ptype.') AND
        deadstocksale.Type IN('.$sltype.')

        GROUP BY regitems.id,stores.id,categories.Name HAVING GrossProfitPer>'.$lval.' AND GrossProfitPer<'.$pval.' AND Revenue>0 
        ORDER BY stores.Name ASC,deadstocksale.PaymentType ASC,categories.Name ASC,customers.Name ASC');
        return datatables()->of($query)->toJson();
    }

    public function dsplreportconitm(Request $request,$from,$to,$store,$fiscalyear,$itg,$ptype,$pltype)
    {
        $pval=null;
        $lval=null;
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $pltypeval=str_replace(',', '', $pltype);
        if($pltypeval==10){
            $pval=100000;
            $lval="-10000";
        }
        if($pltypeval==1){
            $pval=100000;
            $lval=0;
        }
        if($pltypeval==0){
            $pval=0;
            $lval="-10000";
        }
        $itgrp="";
        if($itg=="Local,Imported"){
            $itgrp='"Imported"'.','.'"Local"';
        }
        else if("Local"){
            $itgrp='"Local"';
        }
        else if("Imported"){
            $itgrp='"Imported"';
        }
        $selecteditm=$_POST['itemnames'];
        $items=implode(',', $selecteditm);
        $selectedtype=$_POST['pullouttypeval'];
        $sltype=implode(',', $selectedtype);
        $query = DB::select('SELECT regitems.id AS ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,deadstocksale.PaymentType,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id as StoreId,deadstocksale.Type AS POType,

        COALESCE(ROUND(SUM((deadstocksalesitems.Quantity)),2),0) AS QuantitySold,COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0) AS Revenue,
        COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0) AS COGS,
                
        COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)-COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0) AS GrossProfit,

        ((COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)-COALESCE(SUM(deadstocksalesitems.Quantity*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining","HandIn","Adjustment","Undo-Void") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.ItemId=regitems.id AND DATE(deadstocktransaction.Date)<=deadstocksale.ConfirmedDate)),0)) / (COALESCE(ROUND(SUM((deadstocksalesitems.TotalPrice)),2),0)))*100 AS GrossProfitPer

        FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id INNER JOIN customers ON deadstocksale.CustomerId=customers.id INNER JOIN stores ON deadstocksale.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE deadstocksale.Status="Confirmed/Removed" AND deadstocksale.CreatedDate>="'.$from.'" AND deadstocksale.CreatedDate<="'.$to.'" AND deadstocksalesitems.StoreId IN('.$store.') AND regitems.itemGroup IN('.$itgrp.') AND deadstocksale.PaymentType IN('.$ptype.') AND
        deadstocksale.Type IN('.$sltype.') AND deadstocksalesitems.ItemId IN('.$items.')

        GROUP BY regitems.id,stores.id,categories.Name HAVING GrossProfitPer>'.$lval.' AND GrossProfitPer<'.$pval.' AND Revenue>0 
        ORDER BY stores.Name ASC,deadstocksale.PaymentType ASC,categories.Name ASC');
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
