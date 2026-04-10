<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\customer;
use App\Models\mrc;
use App\Models\Regitem;
use App\Models\receivinghold;
use App\Models\receivingholddetail;
use App\Models\receiving;
use App\Models\receivingdetail;
use App\Models\deadstock;
use App\Models\deadstockdetail;
use App\Models\deadstocksaleitem;
use App\Models\deadstocksale;
use App\Models\dstransactions;
use App\Models\transaction;
use App\Models\store;
use App\Models\uom;
use App\Models\actions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class DSBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->DSFiscalYear;
        $curdate = Carbon::today()->toDateString();

        if($request->ajax()) {
            return view('inventory.dstockbalance')->renderSections()['content'];
        }
        else{
            return view('inventory.dstockbalance');
        }
    }

    public function getDSBalanceData(){
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->DSFiscalYear;

        $results = DB::table('deadstocktransaction as dt')
            ->leftJoin('regitems', 'dt.ItemId', '=', 'regitems.Id')
            ->leftJoin('categories', 'regitems.CategoryId', '=', 'categories.id')
            ->leftJoin('uoms', 'regitems.MeasurementId', '=', 'uoms.id')
            ->select([
                'regitems.id',
                'regitems.Code as ItemCode',
                'regitems.Name as ItemName',
                'regitems.SKUNumber',
                'regitems.Type',
                'categories.Name as Category',
                'uoms.Name as UOM',
                'regitems.dsmaxcost',
                'regitems.dsmaxcosteditable',
                'regitems.DeadStockPrice as SellingPrice',
                DB::raw('COALESCE((
                    SELECT SUM(dsi.Quantity)
                    FROM deadstocksalesitems dsi
                    INNER JOIN deadstocksale ds ON dsi.HeaderId = ds.id
                    WHERE dsi.ItemId = regitems.id 
                    AND ds.Status IN ("Draft", "Pending", "Verified")
                ), 0) as TotalStockOut'),
                DB::raw('COALESCE((
                    SELECT SUM(dd.Quantity)
                    FROM deadstockdetails dd
                    INNER JOIN deadstockrecs dr ON dd.HeaderId = dr.id
                    WHERE dd.ItemId = regitems.id 
                    AND dr.Type = 2 
                    AND dr.Status IN ("Draft", "Pending", "Verified")
                ), 0) as TotalTransfer'),
                DB::raw('(SUM(COALESCE(dt.StockIn, 0)) - SUM(COALESCE(dt.StockOut, 0))) - 
                    COALESCE((
                        SELECT SUM(dsi.Quantity)
                        FROM deadstocksalesitems dsi
                        INNER JOIN deadstocksale ds ON dsi.HeaderId = ds.id
                        WHERE dsi.ItemId = regitems.id 
                        AND ds.Status IN ("Draft", "Pending", "Verified")
                    ), 0) - 
                    COALESCE((
                        SELECT SUM(dd.Quantity)
                        FROM deadstockdetails dd
                        INNER JOIN deadstockrecs dr ON dd.HeaderId = dr.id
                        WHERE dd.ItemId = regitems.id 
                        AND dr.Type = 2 
                        AND dr.Status IN ("Draft", "Pending", "Verified")
                    ), 0) as NetBalance'),
                DB::raw('SUM(COALESCE(dt.StockIn, 0)) - SUM(COALESCE(dt.StockOut, 0)) as TotalBalance')
            ])
            ->where('dt.FiscalYear', $fiscalyr)
            ->groupBy(
                'regitems.id',
                'regitems.Code',
                'regitems.Name',
                'regitems.SKUNumber',
                'regitems.Type',
                'categories.Name',
                'uoms.Name',
                'regitems.dsmaxcost',
                'regitems.dsmaxcosteditable',
                'regitems.DeadStockPrice'
            )
            ->having('TotalBalance', '>', 0)
            ->orderBy('regitems.Name', 'ASC')
            ->get();

        if(request()->ajax()) {
            return datatables()->of($results)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showDStockDetail($id){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->DSFiscalYear;
        
        $results = DB::table('deadstocktransaction as dt')
            ->leftJoin('stores', 'dt.StoreId', '=', 'stores.id')
            ->select([
                'stores.id as store_id',
                'dt.ItemId',
                'stores.Name as StationName',
                DB::raw('(SUM(COALESCE(dt.StockIn, 0)) - SUM(COALESCE(dt.StockOut, 0))) - 
                    COALESCE((
                        SELECT SUM(dsi.Quantity)
                        FROM deadstocksalesitems dsi
                        INNER JOIN deadstocksale ds ON dsi.HeaderId = ds.id
                        WHERE dsi.StoreId = stores.id 
                        AND dsi.ItemId = dt.ItemId
                        AND ds.Status IN ("Draft", "Pending", "Verified")
                    ), 0) - 
                    COALESCE((
                        SELECT SUM(dd.Quantity)
                        FROM deadstockdetails dd
                        INNER JOIN deadstockrecs dr ON dd.HeaderId = dr.id
                        WHERE dr.SourceStore = stores.id 
                        AND dd.ItemId = dt.ItemId
                        AND dr.Type = 2 
                        AND dr.Status IN ("Draft", "Pending", "Verified")
                    ), 0) as NetBalance'),
                DB::raw('COALESCE((
                        SELECT SUM(dsi.Quantity)
                        FROM deadstocksalesitems dsi
                        INNER JOIN deadstocksale ds ON dsi.HeaderId = ds.id
                        WHERE dsi.StoreId = stores.id 
                        AND dsi.ItemId = dt.ItemId
                        AND ds.Status IN ("Draft", "Pending", "Verified")
                    ), 0) + 
                    COALESCE((
                        SELECT SUM(dd.Quantity)
                        FROM deadstockdetails dd
                        INNER JOIN deadstockrecs dr ON dd.HeaderId = dr.id
                        WHERE dr.SourceStore = stores.id
                        AND dd.ItemId = dt.ItemId
                        AND dr.Type = 2 
                        AND dr.Status IN ("Draft", "Pending", "Verified")
                    ), 0) as AllocatedBalance'),
                DB::raw('SUM(COALESCE(dt.StockIn, 0)) - SUM(COALESCE(dt.StockOut, 0)) as TotalBalance')
            ])
            ->where('dt.FiscalYear', $fiscalyr)
            ->where('dt.ItemId', $id)
            ->groupBy('stores.id', 'stores.Name')
            ->having('TotalBalance', '>', 0)
            ->orderBy('stores.Name', 'ASC')
            ->get();

        return datatables()->of($results)
        ->addIndexColumn()
        ->make(true);
    }

    public function showAllocationData(){
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->DSFiscalYear;

        $store_id = $_POST['store_id'] ?? 0;
        $item_id = $_POST['item_id'] ?? 0;

        $statuses = ['Draft', 'Pending', 'Verified'];

        // First query: Stock-IN (Transfers)
        $stockIn = DB::table('deadstockdetails')
            ->select([
                DB::raw('"Stock-IN" as ds_type'),
                DB::raw('CASE WHEN deadstockrecs.Type=1 THEN "Purchase" WHEN deadstockrecs.Type=2 THEN "Transfer" WHEN deadstockrecs.Type=3 THEN "Others" ELSE deadstockrecs.Type END AS rec_type'),
                'stores.Name as src_station',
                'dest_store.Name as destination_station',
                'deadstockrecs.id as rec_id',
                'deadstockrecs.DocumentNumber',
                'deadstockrecs.TransactionDate',
                'deadstockdetails.Quantity',
                'deadstockrecs.Status'
            ])
            ->join('deadstockrecs', function($join) use ($statuses) {
                $join->on('deadstockdetails.HeaderId', '=', 'deadstockrecs.id')
                    ->where('deadstockrecs.Type', '=', 2)
                    ->whereIn('deadstockrecs.Status', $statuses);
            })
            ->leftJoin('stores', 'deadstockrecs.SourceStore', '=', 'stores.id')
            ->leftJoin('stores as dest_store', 'deadstockrecs.StoreId', '=', 'dest_store.id')
            ->where('deadstockrecs.SourceStore', $store_id)
            ->where('deadstockdetails.ItemId', $item_id)
            ->where('deadstockrecs.FiscalYear', $fiscalyr);

        // Second query: Stock-OUT (Sales)
        $stockOut = DB::table('deadstocksalesitems')
            ->select([
                DB::raw('"Stock-OUT" as ds_type'),
                DB::raw('CASE WHEN deadstocksale.Type=1 THEN "Sales" WHEN deadstocksale.Type=2 THEN "Internal" WHEN deadstocksale.Type=3 THEN "Others" ELSE deadstocksale.Type END AS rec_type'),
                'stores.Name as src_station',
                'dest_store.Name as destination_station',
                'deadstocksale.id as rec_id',
                'deadstocksale.DocumentNumber',
                'deadstocksale.TransactionDate',
                'deadstocksalesitems.Quantity',
                'deadstocksale.Status'
            ])
            ->join('deadstocksale', function($join) use ($statuses) {
                $join->on('deadstocksalesitems.HeaderId', '=', 'deadstocksale.id')
                    ->whereIn('deadstocksale.Status', $statuses);
            })
            ->leftJoin('stores', 'deadstocksale.StoreId', '=', 'stores.id')
            ->leftJoin('stores as dest_store', 'deadstocksale.DestinationStore', '=', 'dest_store.id')
            ->where('deadstocksale.StoreId', $store_id)
            ->where('deadstocksalesitems.ItemId', $item_id)
            ->where('deadstocksale.FiscalYear', $fiscalyr);

        // Combine and order
        $results = $stockIn
            ->union($stockOut)
            ->orderBy('ds_type', 'ASC')
            ->get();

        return datatables()->of($results)
            ->addIndexColumn()
            ->make(true);
    }

    public function updateItemPrice(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->itemId;

        $validator = Validator::make($request->all(), [
            'SellingPrice' => 'required',
        ]);

        if ($validator->passes()){
            DB::beginTransaction();
            try{

                DB::table('regitems')->where('id',$findid)->update(['DeadStockPrice' => $request->SellingPrice]);

                $actions = "Edited";
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "dstock-balance",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'rec_id' => $findid]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function showItemData($id){
        $item = DB::select('SELECT regitems.id,regitems.Name,regitems.Code,uoms.Name AS uom_name,categories.Name AS category_name,regitems.MeasurementId,regitems.CategoryId,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.wholeSellerMinAmount,regitems.pmretail,regitems.pmwholesale,regitems.wholeSellerMaxAmount,regitems.MinimumStock,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.path,regitems.imageName,regitems.LowStock,regitems.itemGroup,regitems.Description,regitems.SKUNumber,regitems.oldSKUNumber,regitems.BarcodeType,regitems.oldBarcodeType,regitems.Type,regitems.ActiveStatus,regitems.MaxCost,regitems.minCost,regitems.DeadStockPrice,regitems.averageCost,regitems.dsmaxcost FROM regitems LEFT JOIN categories ON regitems.CategoryId=categories.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE regitems.id='.$id);
        
        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"dstock-balance")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);
        
        return Response::json(['item' => $item,'activitydata' => $activitydata]);
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
