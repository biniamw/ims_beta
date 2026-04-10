<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\stockbalance;

class StockBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settingsval = DB::table('settings')->latest()->first();
        $wsfeature = $settingsval->wholesalefeature;
        return view('inventory.stockbalance',['settingsval' => $settingsval]);
    }

        public function showStockBalanceData()
    {
        $user = Auth()->user();
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->FiscalYear;

        // Get store IDs in single queries without UNION "00" (consider if this is really needed)
        $activestore = DB::table('stores')
            ->where('ActiveStatus', 'Active')
            ->pluck('id')
            ->toArray();

        $nondeletestore = DB::table('stores')
            ->where('IsDeleted', 1)
            ->pluck('id')
            ->toArray();

        $assignedstore = DB::table('storeassignments')
            ->where('UserId', $user->id)
            ->where('Type', 6)
            ->pluck('StoreId')
            ->toArray();

        // Get pending sales IDs
        $assignedpendingsales = DB::table('sales')
            ->whereIn('StoreId', function($query) use ($user) {
                $query->select('StoreId')
                    ->from('storeassignments')
                    ->where('UserId', $user->id)
                    ->where('Type', 6);
            })
            ->whereIn('Status', ['pending..', 'Checked'])
            ->pluck('id')
            ->toArray();

        $pendingsales = DB::table('sales')
            ->whereIn('Status', ['pending..', 'Checked'])
            ->pluck('id')
            ->toArray();

        $pendingrequisition = DB::table('requisitions')
            ->whereIn('Status', ['Draft','Pending','Approved'])
            ->pluck('id')
            ->toArray();

        $pendingtransfer = DB::table('transfers')
            ->whereIn('Status', ['Draft','Pending','Verified','Approved'])
            ->pluck('id')
            ->toArray();

        // Convert arrays to comma-separated strings (only if needed for raw query)
        $activestoreStr = implode(',', array_merge($activestore, ['00']));
        $nondeletestoreStr = implode(',', array_merge($nondeletestore, ['00']));
        $assignedstoreStr = implode(',', array_merge($assignedstore, ['00']));
        $pendingsalesStr = implode(',', array_merge($pendingsales, ['00']));
        $assignedpendingsalesStr = implode(',', array_merge($assignedpendingsales, ['00']));

        $pendingReq = implode(',', array_merge($pendingrequisition, ['00']));
        $pendingTrn = implode(',', array_merge($pendingtransfer, ['00']));

        // Main query - rewritten using Laravel query builder where possible

        $transactionSummaries = DB::table('transactions')
        ->select([
            'ItemId',
            DB::raw("SUM(COALESCE(StockIn, 0)) - SUM(COALESCE(StockOut, 0)) as net_balance"),
            DB::raw("SUM(COALESCE(ShipmentQuantity, 0)) as total_shipment"),
            DB::raw("SUM(CASE WHEN StoreId IN ({$activestoreStr}) THEN COALESCE(StockIn, 0) - COALESCE(StockOut, 0) ELSE 0 END) as active_store_balance"),
            DB::raw("SUM(CASE WHEN StoreId IN ({$nondeletestoreStr}) THEN COALESCE(StockIn, 0) - COALESCE(StockOut, 0) ELSE 0 END) as non_delete_store_balance"),
            DB::raw("SUM(CASE WHEN StoreId IN ({$assignedstoreStr}) THEN COALESCE(StockIn, 0) - COALESCE(StockOut, 0) ELSE 0 END) as assigned_store_balance"),
            DB::raw("SUM(CASE WHEN StoreId IN ({$assignedstoreStr}) THEN COALESCE(ShipmentQuantity, 0) ELSE 0 END) as assigned_store_shipment")
        ])
        ->where('FiscalYear', $fiscalyr)
        ->groupBy('ItemId');

        // Get sales summaries in one go
        $salesSummaries = DB::table('salesitems')
        ->select([
            'ItemId',
            DB::raw("SUM(CASE WHEN HeaderId IN ({$pendingsalesStr}) THEN Quantity ELSE 0 END) as pending_quantity"),
            DB::raw("SUM(CASE WHEN HeaderId IN ({$assignedpendingsalesStr}) THEN Quantity ELSE 0 END) as assigned_pending_quantity")
        ])
        ->groupBy('ItemId');

        $requisitionSummaries = DB::table('requisitiondetails')
        ->select([
            'ItemId',
            DB::raw("SUM(CASE WHEN HeaderId IN ({$pendingReq}) THEN Quantity ELSE 0 END) as pending_quantity"),
        ])
        ->groupBy('ItemId');

        $transferSummaries = DB::table('transferdetails')
        ->select([
            'ItemId',
            DB::raw("SUM(CASE WHEN HeaderId IN ({$pendingTrn}) THEN Quantity ELSE 0 END) as pending_quantity"),
        ])
        ->groupBy('ItemId');

        // Main query with optimized joins
        $stbalance = DB::table('regitems')
        ->select([
            'regitems.id AS id',
            'regitems.Type',
            'regitems.Code AS ItemCode',
            'regitems.Name AS ItemName',
            'regitems.SKUNumber AS SKUNumber',
            'categories.Name AS Category',
            'uoms.Name AS UOM',
            'regitems.RetailerPrice AS RetailerPrice',
            'regitems.WholesellerPrice AS Wholeseller',
            'regitems.averageCost',
            'regitems.MaxCost',
            'regitems.MinimumStock',
            'regitems.wholeSellerMinAmount',
            DB::raw("COALESCE(ts.active_store_balance, 0) AS balancewoper"),
            DB::raw("COALESCE(ts.non_delete_store_balance, 0) AS allbalance"),
            DB::raw("COALESCE(ts.assigned_store_balance, 0) AS totalbalancereg"),
            DB::raw("COALESCE(ss.assigned_pending_quantity, 0) AS pendingbalancereg"),
            DB::raw("COALESCE(ts.net_balance, 0) AS totalbalance"),
            DB::raw("COALESCE(ss.pending_quantity, 0) AS pendingbalance"),
            DB::raw("COALESCE(rs.pending_quantity, 0) AS req_pendingbalance"),
            DB::raw("COALESCE(tn.pending_quantity, 0) AS trn_pendingbalance"),
            DB::raw("COALESCE(ts.assigned_store_shipment, 0) AS ShipmentQnt")
        ])
        ->leftJoin('categories', 'regitems.CategoryId', '=', 'categories.id')
        ->leftJoin('uoms', 'regitems.MeasurementId', '=', 'uoms.id')
        ->leftJoinSub($transactionSummaries, 'ts', function ($join) {
            $join->on('regitems.id', '=', 'ts.ItemId');
        })
        ->leftJoinSub($salesSummaries, 'ss', function ($join) {
            $join->on('regitems.id', '=', 'ss.ItemId');
        })
        ->leftJoinSub($requisitionSummaries, 'rs', function ($join) {
            $join->on('regitems.id', '=', 'rs.ItemId');
        })
        ->leftJoinSub($transferSummaries, 'tn', function ($join) {
            $join->on('regitems.id', '=', 'tn.ItemId');
        })
        ->where('regitems.IsDeleted', 1)
        ->havingRaw('(totalbalance - pendingbalance) > 0 OR ShipmentQnt > 0');

        return datatables()->of($stbalance)
           ->addIndexColumn()
            ->addColumn('AvailableQuantityReg', function ($row) {
                return $row->totalbalancereg - $row->pendingbalancereg;
            })
            ->addColumn('AvailableQuantity', function ($row) {
                return $row->totalbalance - $row->pendingbalance;
            })
            ->addColumn('MinimumStockFlag', function ($row) {
                return ($row->balancewoper <= $row->MinimumStock) ? '0' : '1';
            })
            ->addColumn('StockPr', function ($row) {
                return ($row->totalbalance <= 0) ? '0' : '1';
            })
            ->addColumn('StockAv', function ($row) {
                return ($row->allbalance <= 0) ? '0' : '1';
            })
            ->addColumn('Balance', function ($row) {
                return $row->allbalance;
            })
            ->addColumn('PendingQuantity', function ($row) {
                return $row->pendingbalance;
            })
            ->make(true);

        //return datatables()->of($stbalance)->addIndexColumn()->toJson();
    }

    public function showStockDetailData($id)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->FiscalYear;
        $detailTable = DB::select('select transactions.ItemId,transactions.StoreId, stores.Name as StoreName,regitems.Code as ItemCode,regitems.Name as ItemName,uoms.Name as UOM,categories.Name as Category,CONCAT(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0))) AS StoreBalance,(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0))) AS StrBalance,COALESCE((SELECT DISTINCT UserId FROM storeassignments WHERE StoreId=transactions.StoreId and storeassignments.UserId='.$userid.' and Type=6),0) AS UserIds,(SELECT IFNULL(SUM(salesitems.Quantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN(SELECT sales.id FROM sales WHERE sales.StoreId=transactions.StoreId AND sales.Status IN("pending..","Checked"))) AS PendingQuantity,(SELECT COALESCE(SUM(transactions.ShipmentQuantity),0) FROM transactions WHERE transactions.IsOnShipment=1 AND transactions.IsVoid=0 AND transactions.StoreId=stores.id AND transactions.ItemId=regitems.id AND transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings)) AS QtyOnDelivery from transactions LEFT JOIN stores on transactions.StoreId=stores.Id LEFT JOIN regitems on transactions.ItemId=regitems.Id LEFT JOIN uoms ON regitems.MeasurementId=uoms.Id LEFT JOIN categories ON regitems.CategoryId=categories.Id where ItemId='.$id.' and transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and ((SELECT COALESCE((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))),0) FROM transactions WHERE StoreId=stores.id AND transactions.ItemId=regitems.id and transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings)))>=0 group by stores.Name,regitems.Code,regitems.Name,uoms.Name,categories.Name,transactions.ItemId,transactions.StoreId order by stores.Name asc');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data){})
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showDeliveredQty($itid,$stid)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->FiscalYear;
        $detailTable = DB::select('select transactions.ItemId,transactions.StoreId, stores.Name as StoreName,storesalias.Name as SourceStoreName,regitems.Code as ItemCode,regitems.Name as ItemName,uoms.Name as UOM,categories.Name as Category,transactions.DocumentNumber,transactions.ShipmentQuantity,issues.DocumentNumber AS IssueDoc,issues.DeliveredBy,issues.DeliveredDate,issues.id AS IssuesIds,issues.ReqId AS TransferId from transactions LEFT JOIN stores on transactions.StoreId=stores.Id LEFT JOIN regitems on transactions.ItemId=regitems.Id LEFT JOIN uoms ON regitems.MeasurementId=uoms.Id LEFT JOIN categories ON regitems.CategoryId=categories.Id LEFT JOIN issues ON transactions.HeaderId=issues.id LEFT JOIN stores as storesalias ON issues.SourceStoreId=storesalias.id where transactions.ItemId='.$itid.' AND transactions.StoreId='.$stid.' AND transactions.IsOnShipment=1 AND transactions.IsVoid=0 AND transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and ((SELECT COALESCE((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))),0) FROM transactions WHERE StoreId=stores.id AND transactions.ItemId=regitems.id and transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings)))>=0 order by transactions.id asc');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data){})
        ->rawColumns(['action'])
        ->make(true);
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
