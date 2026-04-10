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
use App\Reports\StoreBalanceReport;
use Response;
use PdfReport;
use PDF;
use DB;
use DateTime;
use DateTimeZone;
use Session;

class InventoryValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=14 AND stores.IsDeleted=1 and stores.id>1');
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        $fy=$settings->FiscalYear;
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fy.' order by fiscalyear.FiscalYear DESC');
        $setting=DB::select('select * from settings');
        $compId="1";
        $compInfo=companyinfo::find($compId);
        if($request->ajax()) {
            return view('inventory.report.value',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo])->renderSections()['content'];
        }
        else{
            return view('inventory.report.value',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo]);
        }
    }


    public function valueReport(Request $request,$from,$to,$storeval,$fiscalyear)
    {
        error_reporting(0); 
        ini_set('max_execution_time', '30000000');
        ini_set("pcre.backtrack_limit", "500000000");
        ini_set('max_input_vars', 300000);
        $item=$_POST['itemnames']; 
        $items=implode(',', $item);
        $query = DB::select("SELECT regitems.id as id,regitems.Code as ItemCode, regitems.Name as ItemName,regitems.SKUNumber AS SKUNumber,regitems.itemGroup AS ItemGroup,categories.Name as Category, uoms.Name as UOM,stores.Name as StoreName,regitems.RetailerPrice as RetailerPrice,regitems.WholesellerPrice as Wholeseller,
        (SELECT(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.FiscalYear=($fiscalyear) AND transactions.StoreId=stores.id AND transactions.StoreId IN($storeval)) AS AvailableQuantity,
        @averagecost:=(SELECT ROUND((SUM(COALESCE(BeforeTaxCost,0))/SUM(COALESCE(StockIn,0))),2) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.TransactionsType IN('Begining','Receiving','Undo-Void','Adjustment') AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)<='".$to."' AND transactions.FiscalYear<='".$fiscalyear."' AND transactions.ItemId=regitems.id) AS AverageCost,
        (SELECT ROUND(@averagecost*(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0))),2)) AS InventoryValue,
        (SELECT ROUND(SUM(COALESCE(StockOut,0)),2) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.TransactionsType='Sales' AND transactions.StoreId=stores.id AND transactions.FiscalYear=($fiscalyear) AND transactions.StoreId IN($storeval)) AS SoldGoods,
        (SELECT ROUND((SELECT ROUND(SUM(COALESCE(StockOut,0)),2) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.TransactionsType='Sales' AND transactions.StoreId=stores.id AND transactions.ItemId=regitems.id AND transactions.FiscalYear=($fiscalyear))*@averagecost,2) AND transactions.IsPriceVoid=0) AS COGS FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.Id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id INNER JOIN stores ON transactions.StoreId=stores.id WHERE transactions.FiscalYear=($fiscalyear) AND DATE(transactions.Date)>= '".$from."' AND DATE(transactions.Date)<='".$to."' AND transactions.StoreId IN($storeval) AND transactions.ItemId IN($items) group by regitems.id,stores.Name HAVING AvailableQuantity>0 order by regitems.Name asc");
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
