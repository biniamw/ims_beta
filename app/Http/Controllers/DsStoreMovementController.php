<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use App\Reports\StoreMovementReport;
use Response;
use PdfReport;
use PDF;
use DateTime;
use DateTimeZone;
use Session;


class DsStoreMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __contruct () {
        $this->middleware("guest");
    }


    public function index(Request $request)
    {
        $compId = 1;
        $compInfo = companyinfo::find($compId);
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $store = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $item = DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $fiscalyear = DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $setting = DB::select('select * from settings');
        if($request->ajax()) {
            return view('inventory.report.dsmovement',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo])->renderSections()['content'];
        }
        else{
            return view('inventory.report.dsmovement',['store'=>$store,'item'=>$item,'fiscalyear'=>$fiscalyear,'setting'=>$setting,'compInfo'=>$compInfo]);
        }
    }

    public function fetchDSMovementRep(Request $request){
        $validator = Validator::make($request->all(), [
            'fiscalyears'=>'required',
            'FromDate'=>'required',
            'ToDate'=>'required',
            'station'=>'required',
            'items'=>'required',
            'MovementType'=>'required',
        ]);

        if ($validator->passes()){
            return Response::json(['success' => 1]);
        }
        else if($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function pdfFiless(Request $request,$from,$to,$store,$fiscalyear,$trtype){
        $compId = 1;
        $user = Auth()->user()->username;
        $compInfo = companyinfo::find($compId);
        $storeval = str_replace('"', '', $store);
        $item = $_POST['itemnames']; 
        $items = implode(',', $item);
        $fp = "";
        $sp = "";
        if($trtype == 1){
            $fp = 0;
            $sp = 2;
        }
        else if($trtype == 2){
            $fp = 1;
            $sp = 1000;
        }
        else if($trtype == "2,1"){
            $fp = 0;
            $sp = 1000;
        }

        $query = DB::select("SELECT deadstocktransaction.id,deadstocktransaction.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,uoms.Name AS UOM,deadstocktransaction.StockIn,deadstocktransaction.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY deadstocktransaction.ItemId,deadstocktransaction.StoreId ORDER BY deadstocktransaction.id ASC)) AS AvailableQuantity,(COALESCE(deadstocktransaction.StockIn,0)-COALESCE(deadstocktransaction.StockOut,0)) AS TotalQuantity,deadstocktransaction.TransactionsType,deadstocktransaction.DocumentNumber,DATE(deadstocktransaction.Date) AS Date FROM deadstocktransaction LEFT JOIN regitems ON deadstocktransaction.ItemId=regitems.id LEFT JOIN stores ON deadstocktransaction.StoreId=stores.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE deadstocktransaction.ItemId IN($items) AND deadstocktransaction.StoreId IN($storeval) AND deadstocktransaction.FiscalYear=($fiscalyear) AND DATE(deadstocktransaction.Date)>='".$from."' AND DATE(deadstocktransaction.Date)<='".$to."' AND (SELECT COUNT(ItemId) FROM deadstocktransaction WHERE deadstocktransaction.StoreId IN($storeval) AND deadstocktransaction.FiscalYear=($fiscalyear) AND deadstocktransaction.ItemId=regitems.id)>".$fp." AND (SELECT COUNT(ItemId) FROM deadstocktransaction WHERE deadstocktransaction.StoreId IN($storeval) AND deadstocktransaction.FiscalYear=($fiscalyear) AND deadstocktransaction.ItemId=regitems.id)<".$sp." ORDER BY regitems.Name ASC,deadstocktransaction.id ASC");
        return datatables()->of($query)->addIndexColumn()->toJson();
    }

    public function getDsItemsBySelectedStore(Request $request,$sid,$fyear){
        $query = DB::select('SELECT DISTINCT regitems.Name AS ItemName,IFNULL(regitems.Code,"") AS Code,IFNULL(regitems.SKUNumber,"") AS SKUNumber,regitems.itemGroup AS ItemGroup,deadstocktransaction.ItemId FROM deadstocktransaction LEFT JOIN regitems ON deadstocktransaction.ItemId=regitems.id WHERE deadstocktransaction.FiscalYear='.$fyear.' AND deadstocktransaction.StoreId IN('.$sid.') ORDER BY regitems.Name ASC');
        $item_group = DB::select('SELECT DISTINCT regitems.itemGroup FROM deadstocktransaction LEFT JOIN regitems ON deadstocktransaction.ItemId=regitems.id WHERE deadstocktransaction.FiscalYear='.$fyear.' AND deadstocktransaction.StoreId IN('.$sid.') ORDER BY regitems.itemGroup ASC');
        return response()->json(['query' => $query,'item_group' => $item_group]);
    }

    public function getDSStoreBySelectedFyear(Request $request,$fy){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $query = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM deadstocktransaction LEFT JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE deadstocktransaction.FiscalYear='.$fy.' ORDER BY stores.Name ASC');
        return response()->json(['query' => $query]);
    }


    public function pdfFiles(Request $request)
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
        Session::put('trtypesession', $trtype);
        return Response::json(['success' => '1']);
    }
    
    public function pdfFile($from,$to,$storeval,$items,$fiscalyear)
    {    

        $compId="1";
        $user=Auth()->user()->username;
        $compInfo=companyinfo::find($compId);

        $report = new StoreMovementReport(array(
            'from'=>$from,
            'to'=>$to,
            'storeval'=>$storeval,
            'items'=>$items,
            'fiscalyear'=>$fiscalyear,
            
        ));
        $report->run(); 

       $storename=DB::select('SELECT GROUP_CONCAT(name , " ") AS StoreName FROM stores WHERE id in ('.$storeval.')');

        $data = [
            'report'=>$report,
            'compInfo'  => $compInfo,
            'from' => $from,
            'to' => $to,
            'storename'=>$storename,
            'fiscalyear'=>$fiscalyear,
        ];

        $mpdf=new \Mpdf\Mpdf([
            //'orientation' => 'L',
            'margin_left'=>3,
            'margin_right'=>3,
            'margin_top'=>5,
            'margin_bottom'=>2,
            'margin_header'=>5,
            'margin_footer'=>1,
        ]); 

  //return view('inventory.report.movement')->with($data);
 
    $date = new DateTime("now", new DateTimeZone('Africa/Addis_Ababa'));
    $date=$date->format('Y-m-d H:i:s');

    $user=Auth()->user()->username;
    $userid=Auth()->user()->id;
    $html=\View::make('inventory.report.movement')->with($data);
    $html=$html->render();  
    $mpdf->SetTitle('My Title');
    $mpdf->SetAuthor('My Name');
    //$mpdf->SetFooter('Generated @:'.$date.'       Page:{PAGENO}');
    $mpdf->SetHTMLFooter('
                <table width="100%">
                <tr>
                <td colspan="3" style="border-top:white;border-right:white;border-left:white;"></td>
                </tr>
                <tr>
                    <td width="50%" style="border:none;">Generated @ : '.$date.'</td>
                    <td width="17%" align="center" style="border:none;"></td>
                    <td width="33%" style="text-align: right;border:none;">Page {PAGENO} of {nbpg}</td>
                </tr>
            </table>');
    $mpdf->WriteHTML($html);
    $mpdf->Output('StoreMovement.pdf','I');

    

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
