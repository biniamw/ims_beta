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

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dashboard.dashboard');
    }

    public function getSupplierCnt(Request $request)
    {
        $query = DB::select('SELECT (SELECT COUNT(customers.id) FROM customers WHERE customers.CustomerCategory="Supplier" AND customers.ActiveStatus="Active" AND customers.IsDeleted=1) AS SupplierCount,(SELECT COUNT(customers.id) FROM customers WHERE customers.CustomerCategory="Customer" AND customers.ActiveStatus="Active" AND customers.IsDeleted=1) AS CustomerCount,(SELECT COUNT(customers.id) FROM customers WHERE customers.CustomerCategory="Customer&Supplier" AND customers.ActiveStatus="Active" AND customers.IsDeleted=1) AS CustomerSuppCount,(SELECT COUNT(customers.id) FROM customers WHERE customers.CustomerCategory="Foreigner-Supplier" AND customers.ActiveStatus="Active" AND customers.IsDeleted=1) AS ForeignSupplierCount,(SELECT COUNT(customers.id) FROM customers WHERE customers.CustomerCategory="Person" AND customers.ActiveStatus="Active" AND customers.IsDeleted=1) AS PersonCount,(SELECT COUNT(customers.id) FROM customers WHERE customers.ActiveStatus IN("Inactive","Block") AND customers.IsDeleted=1) AS InactiveCount,(SELECT COUNT(customers.id) FROM customers WHERE customers.ActiveStatus="BlackList" AND customers.IsDeleted=1) AS BlackListCount,(SELECT COUNT(customers.id) FROM customers WHERE customers.DefaultPrice="Wholeseller" AND customers.ActiveStatus="Active" AND customers.IsDeleted=1) AS WhollesellerCount,(SELECT COUNT(customers.id) FROM customers WHERE customers.DefaultPrice="Retailer" AND customers.ActiveStatus="Active" AND customers.IsDeleted=1) AS RetailerCount,(SELECT COUNT(customers.id) FROM customers WHERE customers.CreditLimit<customers.salesamount AND customers.DefaultPrice="Wholeseller") AS ExpireWhollesellerCount FROM customers WHERE customers.IsDeleted=1 GROUP BY customers.CustomerCategory LIMIT 1');
        return response()->json(['query'=>$query]);
    }

    public function getItemCnt(Request $request)
    {
        $query = DB::select('SELECT (SELECT COUNT(regitems.id) FROM regitems WHERE regitems.itemGroup="Local" AND regitems.ActiveStatus="Active") AS LocalCount,(SELECT COUNT(regitems.id) FROM regitems WHERE regitems.itemGroup="Imported" AND regitems.ActiveStatus="Active") AS ImportedCount,(SELECT COUNT(regitems.id) FROM regitems WHERE regitems.ActiveStatus="Inactive") AS InactiveCount  FROM regitems WHERE regitems.IsDeleted=1 GROUP BY regitems.itemGroup LIMIT 1');
        return response()->json(['query'=>$query]);
    }

    public function getUserval(Request $request)
    {
        $query = DB::select('SELECT (SELECT COUNT(users.id) FROM users WHERE users.Gender="Male" AND users.Status="Active") AS MaleUserCount,(SELECT COUNT(users.id) FROM users WHERE users.Gender="Female" AND users.Status="Active") AS FemaleUserCount,(SELECT COUNT(users.id) FROM users WHERE users.Status="Inactive") AS InactiveUserCount  FROM users GROUP BY users.Gender LIMIT 1');
        return response()->json(['query'=>$query]);
    }

    public function getSalesCnt(Request $request)
    {
        $query = DB::select('SELECT COALESCE(TRUNCATE(SUM(sales.SubTotal),2),0) AS SubTotal,stores.Name AS POS,sales.CreatedDate,sales.StoreId,(CURRENT_DATE()-INTERVAL 7 day) AS LastSevenDays,CURRENT_DATE() AS CurrentDate,(SELECT COALESCE(TRUNCATE(SUM(sales.SubTotal),2),0) FROM sales WHERE sales.Status IN("pending..","Checked","Confirmed") AND sales.CreatedDate BETWEEN DATE_SUB(CURDATE(),INTERVAL 7 DAY) AND NOW()) AS LastDaysTotal FROM sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status IN("pending..","Checked","Confirmed") AND sales.CreatedDate BETWEEN DATE_SUB(CURDATE(),INTERVAL 7 DAY) AND NOW() GROUP BY sales.CreatedDate,sales.StoreId ORDER BY stores.Name ASC,sales.CreatedDate ASC');
        return response()->json(['query'=>$query]);
    }

    public function getItemval(Request $request)
    {
        $totalvals=0;
        $query = DB::select("SELECT regitems.id as id,regitems.Code as ItemCode,regitems.Name as ItemName,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,regitems.RetailerPrice as RetailerPrice,regitems.WholesellerPrice as Wholeseller,(SELECT TRUNCATE((SELECT SUM(COALESCE(BeforeTaxCost,0))/SUM(COALESCE(StockIn,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) AND transactions.StoreId IN(SELECT id FROM stores WHERE stores.IsDeleted=1) AND transactions.TransactionsType IN('Begining','Receiving','Undo-Void') AND transactions.IsPriceVoid=0)*(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))),2)) AS InventoryValue FROM transactions inner join regitems on transactions.ItemId=regitems.Id inner join categories on regitems.CategoryId=categories.id inner join uoms on regitems.MeasurementId=uoms.id WHERE transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) AND transactions.StoreId IN(SELECT id FROM stores WHERE stores.IsDeleted=1) AND transactions.ItemId IN(SELECT id FROM regitems WHERE regitems.IsDeleted=1) group by regitems.id ORDER BY InventoryValue DESC LIMIT 10");
        foreach ($query as $row) {
            $totalvals+= $row->InventoryValue;
        }
        return response()->json(['query'=>$query,'totalval'=>$totalvals]);
    }   
    
    public function getTodaysSales(Request $request)
    {
        $query = DB::select('SELECT stores.Name AS POS,COALESCE(TRUNCATE(SUM(sales.SubTotal),2),0) AS SubTotal,(SELECT COALESCE(TRUNCATE(SUM(sales.SubTotal),2),0) FROM sales WHERE sales.CreatedDate="2023-02-10") AS TodaysTotal FROM sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.CreatedDate="2023-02-10" GROUP BY sales.StoreId ORDER BY POS ASC');
        return response()->json(['query'=>$query]);
    }

    public function getSalesTrend(Request $request)
    {
        $query = DB::select('SELECT stores.Name AS POS,(SELECT COUNT(sales.id) FROM sales WHERE sales.StoreId=stores.id AND sales.Status="pending.." AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS PendingCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.StoreId=stores.id AND sales.Status="Checked" AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS CheckedCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.StoreId=stores.id AND sales.Status="Confirmed" AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS ConfirmedCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.StoreId=stores.id AND sales.Status="Void" AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS VoidCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.StoreId=stores.id AND sales.Status="Refund" AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS RefundCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.StoreId=stores.id AND sales.Status IN("Test-Confirmed","Test") AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS TestCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.StoreId=stores.id AND sales.Status IN("Cancel-Confirmed","Cancel") AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS CancelledCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.StoreId=stores.id AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS TotalCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.Status="pending.." AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS PendingTotalCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.Status="Checked" AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS CheckedTotalCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.Status="Confirmed" AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS ConfirmedTotalCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.Status="Void" AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS VoidTotalCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.Status="Refund" AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS RefundTotalCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.Status IN("Test-Confirmed","Test") AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS TestTotalCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.Status IN("Cancel-Confirmed","Cancel") AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS CancelTotalCount FROM sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.fiscalyear=(SELECT settings.FiscalYear FROM settings) GROUP BY sales.StoreId ORDER BY stores.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function getSalesPaymentType(Request $request)
    {
        $query = DB::select('SELECT stores.Name AS POS,(SELECT COUNT(sales.id) FROM sales WHERE sales.PaymentType="Cash" AND sales.StoreId=stores.id AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS CashCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.PaymentType="Credit" AND sales.StoreId=stores.id AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS CreditCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.StoreId=stores.id AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS TotalCount FROM sales INNER JOIN stores ON sales.StoreId=stores.id GROUP BY sales.StoreId ORDER BY stores.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function getSalesVoucherType(Request $request)
    {
        $query = DB::select('SELECT stores.Name AS POS,(SELECT COUNT(sales.id) FROM sales WHERE sales.VoucherType="Fiscal-Receipt" AND sales.StoreId=stores.id AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS FiscalCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.VoucherType="Manual-Receipt" AND sales.StoreId=stores.id AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS ManualCount,(SELECT COUNT(sales.id) FROM sales WHERE sales.StoreId=stores.id AND sales.fiscalyear=(SELECT settings.FiscalYear FROM settings)) AS TotalCount FROM sales INNER JOIN stores ON sales.StoreId=stores.id GROUP BY sales.StoreId ORDER BY stores.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function getprofitmargin(Request $request)
    {
        $totalrevenue=0;
        $totalgrossprofits=0;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $sdate=$fyear."-07-07";
        $query = DB::select('SELECT
            SUM(COALESCE(salesitems.BeforeTaxPrice,0)) AS Revenue,
            SUM(COALESCE(salesitems.Quantity,0)) AS QuantitySold,
            (SUM(COALESCE(salesitems.Quantity,0))*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id)) AS COGS,
            SUM(COALESCE(salesitems.BeforeTaxPrice,0))-SUM(COALESCE(salesitems.Quantity,0)*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id)) AS GrossProfit, 
            ((SUM(COALESCE(salesitems.BeforeTaxPrice,0))-SUM(COALESCE(salesitems.Quantity,0)*(SELECT COALESCE(TRUNCATE(SUM(BeforeTaxCost)/ SUM(StockIn),2),0) FROM transactions WHERE transactions.TransactionsType IN("Begining","Receiving","Undo-Void") AND transactions.IsPriceVoid=0 AND transactions.ItemId=regitems.id))) / SUM(COALESCE(salesitems.BeforeTaxPrice,0))*100) AS GrossProfitPer
            FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id 
            WHERE sales.Status="Confirmed" AND sales.fiscalyear='.$fyear.' and sales.CreatedDate>="'.$sdate.'" AND sales.CreatedDate<=CURRENT_DATE() AND salesitems.StoreId IN(SELECT id FROM stores WHERE stores.IsDeleted=1) AND regitems.itemGroup IN("Local","Imported") AND sales.PaymentType IN("Cash","Credit") AND salesitems.ItemId IN(SELECT id from regitems where regitems.IsDeleted=1) GROUP BY regitems.id,stores.id,categories.Name');
        foreach ($query as $row) {
            $totalrevenue+= $row->Revenue;
            $totalgrossprofits+=$row->GrossProfit;
        }   
        $prmargin=($totalgrossprofits/$totalrevenue)*100;
        return response()->json(['query'=>$query,'totrev'=>$totalrevenue,'totpro'=>$totalgrossprofits,'perc'=>$prmargin]);
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
