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

class FSNController extends Controller
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
            return view('inventory.report.fsn',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo])->renderSections()['content'];
        }
        else{
            return view('inventory.report.fsn',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo]);
        }
    }

    public function fsnReportCon(Request $request,$from,$to,$storeval,$fiscalyear)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $selecteditm=$_POST['itemnames'];
        $fsnclasss=$_POST['fsnclass'];
        $items=implode(',', $selecteditm);
        $fsncls=implode(',', $fsnclasss);

        $query = DB::select('SELECT CONCAT(regitems.Name,"  | Category: ",categories.Name,"  | UOM: ",uoms.Name) AS ItemNames,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,uoms.Name AS UOM,categories.Name AS Category,

        @beginning:=(SELECT ROUND(COALESCE(SUM((transactions.StockIn)),0),2) FROM transactions WHERE transactions.TransactionsType IN("Begining") AND transactions.IsPriceVoid=0 AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id) AS BeginningInv,

        @totalsalesout:=(SELECT ROUND(COALESCE(SUM((transactions.StockOut)),0),2)
        FROM transactions INNER JOIN sales ON transactions.HeaderId=sales.id WHERE transactions.TransactionsType="Sales" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id AND sales.fiscalyear='.$fiscalyear.' AND sales.Status="Confirmed") AS COGS,

        @balances:=(SELECT COALESCE(SUM(transactions.StockIn)-SUM((transactions.StockOut)),0) FROM transactions WHERE DATE(transactions.Date)>="'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.FiscalYear='.$fiscalyear.' AND transactions.ItemId=regitems.id AND transactions.StoreId=stores.id) AS CurrentBalance,

        @endinginv:=ROUND(@balances,2) AS EndingInv,
        @averageinv:=ROUND(((@beginning+@endinginv)/2),2) AS AverageInv,
        @turnoverratio:=ROUND(@totalsalesout/@averageinv,2) AS TurnoverRatio,
        CASE 
        WHEN @turnoverratio<1 THEN "Non-Moving" 
        WHEN @turnoverratio>=1 AND @turnoverratio<=3 THEN "Slow-Moving"
        WHEN @turnoverratio>3 THEN "Fast-Moving" 
        END AS FSNClassification

        FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id INNER JOIN stores ON transactions.StoreId=stores.id WHERE DATE(transactions.Date)>="'.$from.'" AND DATE(transactions.Date)<="'.$to.'" AND transactions.StoreId IN('.$storeval.') AND regitems.id IN('.$items.') AND transactions.FiscalYear='.$fiscalyear.' GROUP BY regitems.id,stores.id 
        HAVING TurnoverRatio IS NOT NULL AND COGS>0 AND FSNClassification IN('.$fsncls.') ORDER BY TurnoverRatio DESC');
        return datatables()->of($query)->toJson();
    }

    public function getItemsBySelectedStoreFsn(Request $request,$sid,$fy)
    {
        $query = DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,salesitems.ItemId FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN regitems ON salesitems.ItemId=regitems.id WHERE salesitems.StoreId IN('.$sid.') AND sales.fiscalyear='.$fy.' order by regitems.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function getStoreBySelectedFyearFsn(Request $request,$fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $query = DB::select('SELECT DISTINCT salesitems.StoreId,stores.Name AS StoreName FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN stores ON salesitems.StoreId=stores.id WHERE salesitems.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=14) AND stores.IsDeleted=1 AND stores.id>1 AND sales.fiscalyear='.$fy.' ORDER BY stores.Name ASC');
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
