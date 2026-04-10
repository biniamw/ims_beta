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

class DSFSNController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.Name as StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1');
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        //$fyear=$settings->FiscalYear;
        $fyear=2021;
        $fiscalyear=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $setting=DB::select('select * from settings');
        $compId="1";
        $compInfo=companyinfo::find($compId);
        if($request->ajax()) {
            return view('inventory.report.dsfsn',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dsfsn',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo]);
        }
    }

    public function dsgetItemsBySelectedStoreFsn(Request $request,$sid,$fy)
    {
        $query = DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,deadstocksalesitems.ItemId FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id WHERE deadstocksalesitems.StoreId IN('.$sid.') order by regitems.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function dsgetStoreBySelectedFyearFsn(Request $request,$fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $query = DB::select('SELECT DISTINCT deadstocksalesitems.StoreId,stores.Name AS StoreName FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN stores ON deadstocksalesitems.StoreId=stores.id WHERE stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function dsfsnReportCon(Request $request,$from,$to,$storeval,$fiscalyear)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $selecteditm=$_POST['itemnames'];
        $fsnclasss=$_POST['fsnclass'];
        $items=implode(',', $selecteditm);
        $fsncls=implode(',', $fsnclasss);
        $selectedtype=$_POST['pullouttypeval'];
        $sltype=implode(',', $selectedtype);
        $query = DB::select('SELECT CONCAT(regitems.Name,"  | Category: ",categories.Name,"  | UOM: ",uoms.Name) AS ItemNames,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber,regitems.itemGroup AS ItemGroup,stores.Name AS StoreName,uoms.Name AS UOM,categories.Name AS Category,

        @beginning:=(SELECT ROUND(COALESCE(SUM((deadstocktransaction.StockIn)),0),2) FROM deadstocktransaction WHERE deadstocktransaction.TransactionsType IN("Begining") AND deadstocktransaction.IsPriceVoid=0 AND deadstocktransaction.FiscalYear='.$fiscalyear.' AND deadstocktransaction.ItemId=regitems.id AND deadstocktransaction.StoreId=stores.id) AS BeginningInv,

        @totaldeadstocksaleout:=(SELECT ROUND(COALESCE(SUM((deadstocktransaction.StockOut)),0),2)
        FROM deadstocktransaction INNER JOIN deadstocksale ON deadstocktransaction.HeaderId=deadstocksale.id WHERE deadstocktransaction.TransactionsType="PullOut" AND deadstocktransaction.FiscalYear='.$fiscalyear.' AND deadstocktransaction.ItemId=regitems.id AND deadstocktransaction.StoreId=stores.id AND deadstocksale.Status="Confirmed/Removed" AND deadstocksale.Type IN('.$sltype.')) AS COGS,

        @balances:=(SELECT COALESCE(SUM(deadstocktransaction.StockIn)-SUM((deadstocktransaction.StockOut)),0) FROM deadstocktransaction WHERE DATE(deadstocktransaction.Date)>="'.$from.'" AND DATE(deadstocktransaction.Date)<="'.$to.'" AND deadstocktransaction.FiscalYear='.$fiscalyear.' AND deadstocktransaction.ItemId=regitems.id AND deadstocktransaction.StoreId=stores.id) AS CurrentBalance,

        @endinginv:=ROUND(@balances,2) AS EndingInv,
        @averageinv:=ROUND(((@beginning+@endinginv)/2),2) AS AverageInv,
        @turnoverratio:=ROUND(@totaldeadstocksaleout/@averageinv,2) AS TurnoverRatio,
        CASE 
        WHEN @turnoverratio<1 THEN "Non-Moving" 
        WHEN @turnoverratio>=1 AND @turnoverratio<=3 THEN "Slow-Moving"
        WHEN @turnoverratio>3 THEN "Fast-Moving" 
        END AS FSNClassification

        FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON regitems.MeasurementId=uoms.id INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE DATE(deadstocktransaction.Date)>="'.$from.'" AND DATE(deadstocktransaction.Date)<="'.$to.'" AND deadstocktransaction.StoreId IN('.$storeval.') AND regitems.id IN('.$items.') AND deadstocktransaction.FiscalYear='.$fiscalyear.' GROUP BY regitems.id,stores.id 
        HAVING TurnoverRatio IS NOT NULL AND COGS>0 AND FSNClassification IN('.$fsncls.') ORDER BY TurnoverRatio DESC');
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
