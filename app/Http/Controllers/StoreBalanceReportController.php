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

class StoreBalanceReportController extends Controller
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
        $fyear=$settings->FiscalYear;
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $setting=DB::select('select * from settings');
        $compId="1";
        $compInfo=companyinfo::find($compId);
        if($request->ajax()) {
            return view('inventory.report.balanceui',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo])->renderSections()['content'];
        }
        else{
            return view('inventory.report.balanceui',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo]);
        }
    }

    public function pdfStoreBalances(Request $request,$from,$to,$storeval,$fiscalyear)
    {
        $selecteditm=$_POST['itemnames'];
        $items=implode(',', $selecteditm);
        $query = DB::select("SELECT regitems.id as id,regitems.Code as ItemCode, regitems.Name as ItemName,regitems.SKUNumber AS SKUNumber,regitems.itemGroup AS ItemGroup,categories.Name as Category, uoms.Name as UOM,stores.Name as StoreName,regitems.RetailerPrice as RetailerPrice,regitems.WholesellerPrice as Wholeseller,(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity FROM transactions inner join regitems on transactions.ItemId=regitems.Id inner join categories on regitems.CategoryId=categories.id inner join uoms on regitems.MeasurementId=uoms.id inner join stores on transactions.StoreId=stores.id where transactions.FiscalYear=($fiscalyear) AND DATE(transactions.Date)>= '".$from."' AND DATE(transactions.Date)<='".$to."' AND transactions.StoreId IN($storeval) AND transactions.ItemId IN($items) group by regitems.Code,regitems.Name,regitems.SKUNumber,categories.Name,uoms.Name,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.id,stores.Name order by regitems.Name asc");
        return datatables()->of($query)->toJson();
    }

    public function getItemsBySelectedStore(Request $request,$sid,$fy)
    {
        $query = DB::select('SELECT DISTINCT regitems.Name AS ItemName,IFNULL(regitems.Code,"") AS Code,IFNULL(regitems.SKUNumber,"") AS SKUNumber,regitems.itemGroup AS ItemGroup,transactions.ItemId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.StoreId IN('.$sid.') AND transactions.FiscalYear='.$fy.' order by regitems.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function getStoreBySelectedFyear(Request $request,$fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $query = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM transactions INNER JOIN stores ON transactions.StoreId=stores.id WHERE transactions.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=14) AND stores.IsDeleted=1 AND stores.id>1 AND transactions.FiscalYear='.$fy.' ORDER BY stores.Name ASC;');
        return response()->json(['query'=>$query]);
    }

    public function pdfStoreBalance(Request $request)
    {
        $compId="1";
        $user=Auth()->user()->username;
        $compInfo=companyinfo::find($compId);
        $from=$request->date;
        $to=$request->todate;
        $fiscalyear=$request->fiscalyears;
        $storevals=$request->store;
        $items=$request->items;
        $trtype=$request->trtype;
        Session::put('fromsession', $from);
        Session::put('tosession', $to);
        Session::put('fiscalyearsession', $fiscalyear);
        Session::put('storesession', $storevals);
        Session::put('itemssession', $items);
        return Response::json(['success' => '1']);
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
