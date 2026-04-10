<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

class DsStoreBalanceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $store = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $item = DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $fiscalyear = DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $setting = DB::select('select * from settings');
        $compId = 1;
        $compInfo = companyinfo::find($compId);
        if($request->ajax()) {
            return view('inventory.report.dsbalance',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dsbalance',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo]);
        }
    }

    public function fetchDSBalanceRep(Request $request){
        $validator = Validator::make($request->all(), [
            'fiscalyears'=>'required',
            'FromDate'=>'required',
            'ToDate'=>'required',
            'station'=>'required',
            'items'=>'required',
            'itemGroup'=>'required',
        ]);

        if ($validator->passes()){
            return Response::json(['success' => 1]);
        }
        else if($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function pdfStoreBalances(Request $request,$from,$to,$storeval){
        $item = $_POST['itemnames']; 
        $items = implode(',', $item);
        $query = DB::select("SELECT regitems.id as id,regitems.Code as ItemCode, regitems.Name as ItemName,regitems.SKUNumber AS SKUNumber,regitems.itemGroup AS ItemGroup,regitems.itemGroup AS ItemGroup,categories.Name as Category, uoms.Name as UOM,stores.Name as StoreName,regitems.RetailerPrice as RetailerPrice,regitems.WholesellerPrice as Wholeseller,(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity FROM deadstocktransaction inner join regitems on deadstocktransaction.ItemId=regitems.Id inner join categories on regitems.CategoryId=categories.id inner join uoms on regitems.MeasurementId=uoms.id inner join stores on deadstocktransaction.StoreId=stores.id where DATE(deadstocktransaction.Date)>= '".$from."' AND DATE(deadstocktransaction.Date)<='".$to."' AND deadstocktransaction.StoreId IN($storeval) AND deadstocktransaction.ItemId IN($items) group by regitems.Code,regitems.Name,regitems.SKUNumber,categories.Name,uoms.Name,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.id,stores.Name order by regitems.Name asc");
        return datatables()->of($query)->addIndexColumn()->toJson();
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
