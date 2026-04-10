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

class ProfitLossController extends Controller
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
            return view('report.plreport',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate])->renderSections()['content'];
        }
        else{
            return view('report.plreport',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate]);
        }
    }

    public function indexsum(Request $request)
    {
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
            return view('report.plreportsum',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate])->renderSections()['content'];
        }
        else{
            return view('report.plreportsum',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate]);
        }
    }

    public function indexitm(Request $request)
    {
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
            return view('report.plreportitm',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate])->renderSections()['content'];
        }
        else{
            return view('report.plreportitm',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate]);
        }
    }

    public function indexcus(Request $request)
    {
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
            return view('report.plreportcus',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate])->renderSections()['content'];
        }
        else{
            return view('report.plreportcus',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo,'fdate'=>$fdate]);
        }
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

    public function getItemsBySelectedStorePl(Request $request,$sid,$fy)
    {
        $query = DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,salesitems.ItemId FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE salesitems.StoreId IN('.$sid.') AND sales.fiscalyear='.$fy.' order by regitems.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function getCusBySelectedStorePl(Request $request,$sid,$fy)
    {
        $query = DB::select('SELECT DISTINCT customers.Name AS CustomerName,customers.Code,customers.TinNumber,sales.CustomerId FROM sales INNER JOIN customers ON sales.CustomerId=customers.id WHERE sales.StoreId IN('.$sid.') AND sales.fiscalyear='.$fy.' order by customers.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function getSalesStore(Request $request,$fy)
    {
        $fdate="";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $transactionqr=DB::select('select transactions.Date from transactions WHERE transactions.FiscalYear='.$fyear.' ORDER BY transactions.id ASC LIMIT 1');
        foreach($transactionqr as $row){
            $fdate=$row->Date;
        }
        //$query = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM transactions INNER JOIN stores ON transactions.StoreId=stores.id WHERE transactions.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=14) AND stores.IsDeleted=1 AND stores.id>1 AND transactions.FiscalYear='.$fy.' ORDER BY stores.Name ASC;');
        $query = DB::select('SELECT DISTINCT sales.StoreId,stores.Name AS StoreName FROM sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fy.' AND sales.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=12) AND stores.id>1 AND stores.IsDeleted=1 ORDER BY stores.Name ASC');
        return response()->json(['query'=>$query,'fdate'=>$fdate]);
    } 

    public function plreportcon(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype,$pltype)
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
        $query = DB::select('SELECT regitems.id AS ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,sales.PaymentType,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id AS StoreId,
   
        @purchase:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @sold:=(SELECT COALESCE(SUM((salesitems.Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.ItemId=regitems.id AND salesitems.StoreId=stores.id),

        @revenue:=(SELECT COALESCE(ROUND(SUM((salesitems.BeforeTaxPrice)),2),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND DATE(sales.CreatedDate)>="'.$from.'" AND DATE(sales.CreatedDate)<="'.$to.'" AND salesitems.ItemId=regitems.id AND salesitems.StoreId=stores.id),

        @adjustmentplus:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @adjustmentminus:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @transferval:=(SELECT COALESCE(
        SUM(transactions.StockIn*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=issues.IssuedDate)),0)
        FROM transactions INNER JOIN issues ON transactions.HeaderId=issues.id WHERE transactions.TransactionsType="Transfer" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @totalsalescost:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=sales.ConfirmedDate)),0)
        FROM transactions INNER JOIN sales ON transactions.HeaderId=sales.id WHERE transactions.TransactionsType="Sales" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id AND sales.fiscalyear='.$fiscalyear.' AND sales.Status="Confirmed" AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND sales.PaymentType IN('.$ptype.')),

        @totalissues:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=issues.IssuedDate)),0)
        FROM transactions INNER JOIN issues ON transactions.HeaderId=issues.id WHERE transactions.TransactionsType="Issue" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @totalreq:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=issues.IssuedDate)),0)
        FROM transactions INNER JOIN issues ON transactions.HeaderId=issues.id WHERE transactions.TransactionsType="Requisition" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),
        
        @balances:=(SELECT COALESCE(SUM(transactions.StockIn)-SUM((transactions.StockOut)),0) FROM transactions WHERE DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @average:=(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)<="'.$to.'" AND transactions.ItemId=regitems.id),
        
        @revenue AS Revenue,
        @sold AS QuantitySold,

        @endinginv:=@balances*@average,
        @totalissues,

        @transferval,
        @adjustmentplus,
        @average,
        @sold,
        @balances,
        @totalstockout:=@totalsalescost,
        @totalstockin:=@purchase+@adjustmentplus+@transferval,
        @begininginv:=(@totalstockout+@endinginv)-@totalstockin,
        @cogs:=(@begininginv+@totalstockin)-@endinginv,
        @grossprofit:=@revenue-@cogs,
        @grossprofitper:=(@grossprofit/@revenue)*100,
        @cogs AS COGS,
        @grossprofit AS GrossProfit,
        @grossprofitper AS GrossProfitPer,
        @averageinv:=(@begininginv+@endinginv)/2,
        @turnoverratio:=@cogs/@averageinv AS TurnoverRatio

        FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND DATE(sales.CreatedDate)>="'.$from.'" AND DATE(sales.CreatedDate)<="'.$to.'" AND salesitems.StoreId IN('.$store.') AND regitems.itemGroup IN('.$itgrp.') AND sales.PaymentType IN('.$ptype.') AND
        salesitems.ItemId IN(SELECT id from regitems where regitems.IsDeleted=1)

        GROUP BY regitems.id,stores.id,categories.Name HAVING GrossProfitPer>'.$lval.' AND GrossProfitPer<'.$pval.' AND Revenue>0 
        ORDER BY stores.Name ASC,sales.PaymentType ASC,categories.Name ASC');
        return datatables()->of($query)->toJson();
    }

    public function plreportconsum(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype,$pltype)
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

        $query = DB::select('SELECT regitems.id AS ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,sales.PaymentType,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id as StoreId,

        @purchase:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @sold:=(SELECT COALESCE(SUM((salesitems.Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.ItemId=regitems.id AND salesitems.StoreId=stores.id),

        @revenue:=(SELECT COALESCE(ROUND(SUM((salesitems.BeforeTaxPrice)),2),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.ItemId=regitems.id AND salesitems.StoreId=stores.id),

        @adjustmentplus:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @adjustmentminus:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @transferval:=(SELECT COALESCE(
        SUM(transactions.StockIn*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=issues.IssuedDate)),0)
        FROM transactions INNER JOIN issues ON transactions.HeaderId=issues.id WHERE transactions.TransactionsType="Transfer" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @totalsalescost:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) AS TotalTransfer FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=sales.ConfirmedDate)),0)
        FROM transactions INNER JOIN sales ON transactions.HeaderId=sales.id WHERE transactions.TransactionsType="Sales" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id AND sales.fiscalyear='.$fiscalyear.' AND sales.Status="Confirmed" AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND sales.PaymentType IN('.$ptype.')),

        @totalissues:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=issues.IssuedDate)),0)
        FROM transactions INNER JOIN issues ON transactions.HeaderId=issues.id WHERE transactions.TransactionsType="Issue" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @totalreq:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=issues.IssuedDate)),0)
        FROM transactions INNER JOIN issues ON transactions.HeaderId=issues.id WHERE transactions.TransactionsType="Requisition" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),
        
        @balances:=(SELECT COALESCE(SUM(transactions.StockIn)-SUM((transactions.StockOut)),0) FROM transactions WHERE DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @average:=(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)<="'.$to.'" AND transactions.ItemId=regitems.id),

        @revenue AS Revenue,
        @sold AS QuantitySold,

        @endinginv:=@balances*@average,
        @totalissues,

        @transferval,
        @adjustmentplus,
        @average,
        @sold,
        @balances,
        @totalstockout:=@totalsalescost,
        @totalstockin:=@purchase+@adjustmentplus+@transferval,
        @begininginv:=(@totalstockout+@endinginv)-@totalstockin,
        @cogs:=(@begininginv+@totalstockin)-@endinginv,
        @grossprofit:=@revenue-@cogs,
        @grossprofitper:=(@grossprofit/@revenue)*100,
        @cogs AS COGS,
        @grossprofit AS GrossProfit,
        @grossprofitper AS GrossProfitPer,
        @averageinv:=(@begininginv+@endinginv)/2,
        @turnoverratio:=@cogs/@averageinv AS TurnoverRatio

        FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE sales.Status="Confirmed" and sales.fiscalyear='.$fiscalyear.' and sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.StoreId IN('.$store.') AND regitems.itemGroup IN('.$itgrp.') AND sales.PaymentType IN('.$ptype.') AND
        salesitems.ItemId IN(SELECT id from regitems where regitems.IsDeleted=1)

        GROUP BY regitems.id,stores.id,categories.Name HAVING GrossProfitPer>'.$lval.' AND GrossProfitPer<'.$pval.' AND Revenue>0 
        ORDER BY stores.Name ASC,sales.PaymentType ASC,categories.Name ASC');

        return datatables()->of($query)->toJson();
    }

    public function plreportconitm(Request $request,$from,$to,$store,$fiscalyear,$itg,$ptype,$pltype)
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

        $query = DB::select('SELECT regitems.id AS ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,sales.PaymentType,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id as StoreId,

        @purchase:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @sold:=(SELECT COALESCE(SUM((salesitems.Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.ItemId=regitems.id AND salesitems.StoreId=stores.id),

        @revenue:=(SELECT COALESCE(ROUND(SUM((salesitems.BeforeTaxPrice)),2),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.ItemId=regitems.id AND salesitems.StoreId=stores.id),

        @adjustmentplus:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @adjustmentminus:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @transferval:=(SELECT COALESCE(
        SUM(transactions.StockIn*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=issues.IssuedDate)),0)
        FROM transactions INNER JOIN issues ON transactions.HeaderId=issues.id WHERE transactions.TransactionsType="Transfer" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @totalsalescost:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=sales.ConfirmedDate)),0)
        FROM transactions INNER JOIN sales ON transactions.HeaderId=sales.id WHERE transactions.TransactionsType="Sales" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id AND sales.fiscalyear='.$fiscalyear.' AND sales.Status="Confirmed" AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND sales.PaymentType IN('.$ptype.')),

        @totalissues:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=issues.IssuedDate)),0)
        FROM transactions INNER JOIN issues ON transactions.HeaderId=issues.id WHERE transactions.TransactionsType="Issue" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @totalreq:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=issues.IssuedDate)),0)
        FROM transactions INNER JOIN issues ON transactions.HeaderId=issues.id WHERE transactions.TransactionsType="Requisition" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),
        
        @balances:=(SELECT COALESCE(SUM(transactions.StockIn)-SUM((transactions.StockOut)),0) FROM transactions WHERE DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @average:=(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)<="'.$to.'" AND transactions.ItemId=regitems.id),
        
        @revenue AS Revenue,
        @sold AS QuantitySold,

        @endinginv:=@balances*@average,
        @totalissues,

        @transferval,
        @adjustmentplus,
        @average,
        @sold,
        @balances,
        @totalstockout:=@totalsalescost,
        @totalstockin:=@purchase+@adjustmentplus+@transferval,
        @begininginv:=(@totalstockout+@endinginv)-@totalstockin,
        @cogs:=(@begininginv+@totalstockin)-@endinginv,
        @grossprofit:=@revenue-@cogs,
        @grossprofitper:=(@grossprofit/@revenue)*100,
        @cogs AS COGS,
        @grossprofit AS GrossProfit,
        @grossprofitper AS GrossProfitPer,
        @averageinv:=(@begininginv+@endinginv)/2

        FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE sales.Status="Confirmed" and sales.fiscalyear='.$fiscalyear.' and sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.StoreId IN('.$store.') AND regitems.itemGroup IN('.$itgrp.') AND sales.PaymentType IN('.$ptype.') AND
        salesitems.ItemId IN('.$items.')

        GROUP BY regitems.id,stores.id,categories.Name HAVING GrossProfitPer>'.$lval.' AND GrossProfitPer<'.$pval.' AND Revenue>0 
        ORDER BY stores.Name ASC,sales.PaymentType ASC,categories.Name ASC');
        return datatables()->of($query)->toJson();
    }

    public function plreportconcus(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype,$pltype)
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

        $query = DB::select('SELECT regitems.id AS ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,sales.PaymentType,CONCAT(customers.Name,"     (",customers.DefaultPrice,")") AS CustomerName,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id as StoreId,

        @purchase:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @sold:=(SELECT COALESCE(SUM((salesitems.Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.ItemId=regitems.id AND salesitems.StoreId=stores.id AND sales.CustomerId=customers.id),

        @revenue:=(SELECT COALESCE(ROUND(SUM((salesitems.BeforeTaxPrice)),2),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.ItemId=regitems.id AND salesitems.StoreId=stores.id AND sales.CustomerId=customers.id),

        @adjustmentplus:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @adjustmentminus:=(SELECT COALESCE(SUM((transactions.BeforeTaxCost)),0) FROM transactions WHERE transactions.TransactionsType IN("Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @totalsalescost:=(SELECT COALESCE(
        SUM(transactions.StockOut*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) AS TotalTransfer FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id AND DATE(transactions.Date)<=sales.ConfirmedDate)),0)
        FROM transactions INNER JOIN sales ON transactions.HeaderId=sales.id WHERE transactions.TransactionsType="Sales" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id AND sales.fiscalyear='.$fiscalyear.' AND sales.Status="Confirmed" AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND sales.PaymentType IN('.$ptype.') AND sales.CustomerId=customers.id),
        
        @balances:=(SELECT COALESCE(SUM(transactions.StockIn)-SUM((transactions.StockOut)),0) FROM transactions WHERE DATE(transactions.Date)>= "'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id),

        @average:=(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)<="'.$to.'" AND transactions.ItemId=regitems.id),
        
        @revenue AS Revenue,
        @sold AS QuantitySold,

        @endinginv:=@balances*@average,
        @totalissues,

        @transferval,
        @adjustmentplus,
        @average,
        @sold,
        @balances,
        @totalstockout:=@totalsalescost,
        @totalstockin:=@purchase+@adjustmentplus+@transferval,
        @begininginv:=(@totalstockout+@endinginv)-@totalstockin,
        @cogs:=(@begininginv+@totalstockin)-@endinginv,
        @grossprofit:=@revenue-@totalsalescost,
        @grossprofitper:=(@grossprofit/@revenue)*100,
        @totalsalescost AS COGS,
        @grossprofit AS GrossProfit,
        @grossprofitper AS GrossProfitPer,
        @averageinv:=(@begininginv+@endinginv)/2

        FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE sales.CustomerId IN ('.$cusname.') AND sales.Status="Confirmed" AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.StoreId IN('.$store.') AND regitems.itemGroup IN('.$itgrp.') AND sales.PaymentType IN('.$ptype.') AND
        salesitems.ItemId IN(SELECT id from regitems where regitems.IsDeleted=1) AND sales.CustomerId=customers.id

        GROUP BY regitems.id,stores.id,categories.Name,customers.id HAVING GrossProfitPer>'.$lval.' AND GrossProfitPer<'.$pval.' AND Revenue>0 
        ORDER BY stores.Name ASC,sales.PaymentType ASC,categories.Name ASC');
        return datatables()->of($query)->toJson();
    }

    public function plreportconsumch(Request $request,$from,$to,$store,$fiscalyear,$itgrp,$ptype){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $query = DB::select('SELECT transactions.ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,sales.PaymentType,categories.Name AS CategoryName,uoms.Name AS UOM,stores.id as StoreId,(SELECT COALESCE(TRUNCATE(SUM(salesitems.BeforeTaxPrice),2),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id where transactions.StoreId=salesitems.StoreId AND transactions.ItemId=salesitems.ItemId AND sales.Status="Confirmed" and sales.fiscalyear='.$fiscalyear.' and sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND sales.PaymentType IN('.$ptype.') AND salesitems.StoreId IN('.$store.')) AS Revenue,      

            ((SELECT COALESCE(SUM(salesitems.Quantity),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id where transactions.StoreId=salesitems.StoreId AND transactions.ItemId=salesitems.ItemId AND sales.Status="Confirmed" and sales.fiscalyear='.$fiscalyear.' and sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.StoreId IN('.$store.') AND sales.PaymentType IN('.$ptype.'))*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id)) AS COGS,
            
            (((SELECT COALESCE(TRUNCATE(SUM(salesitems.BeforeTaxPrice),2),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id where transactions.StoreId=salesitems.StoreId AND transactions.ItemId=salesitems.ItemId AND sales.Status="Confirmed" and sales.fiscalyear='.$fiscalyear.' and sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND sales.PaymentType IN('.$ptype.') AND salesitems.StoreId IN('.$store.')))-(((SELECT COALESCE(SUM(salesitems.Quantity),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id where transactions.StoreId=salesitems.StoreId AND transactions.ItemId=salesitems.ItemId AND sales.Status="Confirmed" and sales.fiscalyear='.$fiscalyear.' and sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.StoreId IN('.$store.') AND sales.PaymentType IN('.$ptype.'))*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id)))) AS GrossProfit,
            
            ((((((SELECT COALESCE(TRUNCATE(SUM(salesitems.BeforeTaxPrice),2),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id where transactions.StoreId=salesitems.StoreId AND transactions.ItemId=salesitems.ItemId AND sales.Status="Confirmed" and sales.fiscalyear='.$fiscalyear.' and sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.StoreId IN('.$store.')))-(((SELECT COALESCE(SUM(salesitems.Quantity),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id where transactions.StoreId=salesitems.StoreId AND transactions.ItemId=salesitems.ItemId AND sales.Status="Confirmed" and sales.fiscalyear='.$fiscalyear.' and sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.StoreId IN('.$store.') AND sales.PaymentType IN('.$ptype.'))*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id))))) /((SELECT TRUNCATE(SUM(salesitems.BeforeTaxPrice),2) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN regitems ON salesitems.ItemId=regitems.id WHERE sales.Status="Confirmed" AND transactions.StoreId=salesitems.StoreId AND transactions.ItemId=salesitems.ItemId AND regitems.itemGroup IN('.$itgrp.') AND sales.fiscalyear='.$fiscalyear.' AND sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND sales.PaymentType IN('.$ptype.') AND salesitems.StoreId IN('.$store.'))))*100) AS GrossProfitPer
            
            FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN sales ON transactions.HeaderId=sales.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id WHERE transactions.ItemId IN(SELECT id from regitems where regitems.IsDeleted=1) AND transactions.StoreId IN('.$store.') AND transactions.FiscalYear='.$fiscalyear.' AND regitems.itemGroup IN('.$itgrp.')
            AND sales.PaymentType IN ('.$ptype.') AND (SELECT COALESCE(SUM(salesitems.BeforeTaxPrice),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id where transactions.StoreId=salesitems.StoreId AND transactions.ItemId=salesitems.ItemId AND sales.Status="Confirmed" and sales.fiscalyear='.$fiscalyear.' and sales.CreatedDate>="'.$from.'" AND sales.CreatedDate<="'.$to.'" AND salesitems.StoreId IN('.$store.') AND sales.PaymentType IN('.$ptype.'))>0 GROUP BY regitems.id,stores.id,categories.Name,stores.Name ORDER BY stores.Name ASC,sales.PaymentType ASC,categories.Name ASC');
        return response()->json(['sid'=>$query]);
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
