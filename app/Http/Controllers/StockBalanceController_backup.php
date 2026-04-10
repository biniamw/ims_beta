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
    public function index(Request $request)
    {
        $settingsval = DB::table('settings')->latest()->first();
        $wsfeature=$settingsval->wholesalefeature;
        if($request->ajax()) {
            return view('inventory.stockbalance',['settingsval'=>$settingsval])->renderSections()['content'];
        }
        else{
            return view('inventory.stockbalance',['settingsval'=>$settingsval]);
        }
    }

    public function showStockBalanceData()
    {
        $activestore=[];
        $nondeletestore=[];
        $assignedstore=[];
        $pendingsalesid=[];
        $assignedpendingsales=[];
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        $getactivestore=DB::select('SELECT id FROM stores WHERE stores.ActiveStatus="Active" UNION SELECT "00" FROM stores');
        foreach($getactivestore as $row){
            $activestore[]=$row->id;
        }

        $getnonactivestore=DB::select('SELECT id FROM stores WHERE stores.IsDeleted=1 UNION SELECT "00" FROM stores');
        foreach($getnonactivestore as $row){
            $nondeletestore[]=$row->id;
        }

        $getassignedstore=DB::select('SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=6 UNION SELECT "00" FROM storeassignments');
        foreach($getassignedstore as $row){
            $assignedstore[]=$row->StoreId;
        }

        $getassignedpendingsales=DB::select('SELECT sales.id FROM sales WHERE sales.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=6) AND sales.Status IN("pending..","Checked") UNION SELECT "00" FROM sales');
        foreach($getassignedpendingsales as $row){
            $assignedpendingsales[]=$row->id;
        }

        $getpendingsales=DB::select('SELECT sales.id FROM sales WHERE sales.Status IN("pending..","Checked") UNION SELECT "00" FROM sales');
        foreach($getpendingsales as $row){
            $pendingsalesid[]=$row->id;
        }

        
        $activestore=implode(',', $activestore);
        $nondeletestore=implode(',', $nondeletestore);
        $assignedstore=implode(',', $assignedstore);
        $pendingsalesid=implode(',', $pendingsalesid);
        $assignedpendingsales=implode(',', $assignedpendingsales);

        $stbalance=DB::select('SELECT regitems.id AS id,regitems.Code AS ItemCode, regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,categories.Name AS Category, uoms.Name AS UOM,regitems.RetailerPrice AS RetailerPrice,regitems.WholesellerPrice AS Wholeseller,regitems.averageCost,regitems.MaxCost,

	    @balancewoper:=(SELECT (SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0))) FROM transactions WHERE transactions.FiscalYear='.$fiscalyr.' AND transactions.StoreId IN('.$activestore.') and transactions.ItemId=regitems.id),
        
        @allbalance:=(SELECT (SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0))) FROM transactions WHERE transactions.FiscalYear='.$fiscalyr.' AND transactions.StoreId IN('.$nondeletestore.') AND transactions.ItemId=regitems.id),
        
	    @totalbalancereg:=(SELECT COALESCE((SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0))),0) FROM transactions WHERE StoreId IN ('.$assignedstore.') AND transactions.ItemId=regitems.id AND transactions.FiscalYear='.$fiscalyr.'),
        
        @pendingbalancereg:=(SELECT IFNULL(SUM(salesitems.Quantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN('.$assignedpendingsales.')),
        
        @totalbalance:=(SELECT COALESCE((SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0))),0) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.FiscalYear='.$fiscalyr.'),       
        
        @pendingbalance:=(SELECT IFNULL(SUM(salesitems.Quantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN('.$pendingsalesid.')),

        (@totalbalancereg)-(@pendingbalancereg) AS AvailableQuantityReg, 

        (@totalbalance)-(@pendingbalance) AS AvailableQuantity,          
           
        IF(@balancewoper<=(regitems.MinimumStock),"0","1") AS MinimumStockFlag,
        IF(@totalbalance<=0,"0","1") AS StockPr,
        IF(@allbalance<=0,"0","1") AS StockAv,
            
        @allbalance AS Balance,regitems.MinimumStock,
            
        @pendingbalance AS PendingQuantity,
            
        (SELECT (SUM(COALESCE(ShipmentQuantity,0))) from transactions where transactions.FiscalYear='.$fiscalyr.' AND transactions.StoreId IN('.$assignedstore.') AND transactions.ItemId=regitems.id) AS ShipmentQnt,
        regitems.MinimumStock,regitems.wholeSellerMinAmount 
            
        FROM transactions inner join regitems on transactions.ItemId=regitems.Id inner join categories on regitems.CategoryId=categories.id inner join uoms on regitems.MeasurementId=uoms.id where transactions.FiscalYear='.$fiscalyr.' 
            
        AND regitems.IsDeleted=1 GROUP BY regitems.Code,regitems.Name,regitems.SKUNumber,categories.Name,uoms.Name,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.id,regitems.MinimumStock HAVING AvailableQuantity>0 OR ShipmentQnt>0 ORDER BY regitems.Name ASC');
        
        return datatables()->of($stbalance)->addIndexColumn()->toJson();
    }

    public function showStockDetailData($id)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $itemIds=$id;
        $detailTable=DB::select('select transactions.ItemId,transactions.StoreId, stores.Name as StoreName,regitems.Code as ItemCode,regitems.Name as ItemName,uoms.Name as UOM,categories.Name as Category,CONCAT(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0))) AS StoreBalance,(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0))) AS StrBalance,COALESCE((SELECT UserId FROM storeassignments WHERE StoreId=transactions.StoreId and storeassignments.UserId='.$userid.' and Type=6),0) AS UserIds,(SELECT IFNULL(SUM(salesitems.Quantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN(SELECT sales.id FROM sales WHERE sales.StoreId=transactions.StoreId AND sales.Status IN("pending..","Checked"))) AS PendingQuantity,(SELECT COALESCE(SUM(transactions.ShipmentQuantity),0) FROM transactions WHERE transactions.IsOnShipment=1 AND transactions.IsVoid=0 AND transactions.StoreId=stores.id AND transactions.ItemId=regitems.id AND transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings)) AS ShipmentQty,(SELECT SUM(COALESCE(dispatchchildren.Quantity,0)) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id LEFT JOIN transferdetails ON dispatchchildren.ReqDetailId=transferdetails.id LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transferdetails.ItemId=transactions.ItemId AND dispatchparents.Status IN("Draft","Pending","Verified","Approved")) AS QtyOnDelivery from transactions INNER JOIN stores on transactions.StoreId=stores.Id INNER JOIN regitems on transactions.ItemId=regitems.Id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id INNER JOIN categories ON regitems.CategoryId=categories.Id where ItemId='.$itemIds.' and transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and ((SELECT COALESCE((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))),0) FROM transactions WHERE StoreId=stores.id AND transactions.ItemId=regitems.id and transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings)))>=0 group by stores.Name,regitems.Code,regitems.Name,uoms.Name,categories.Name,transactions.ItemId,transactions.StoreId order by stores.Name asc');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data){})
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showDeliveredQty($itid,$stid)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $detailTable=DB::select('select transactions.ItemId,transactions.StoreId, stores.Name as StoreName,storesalias.Name as SourceStoreName,regitems.Code as ItemCode,regitems.Name as ItemName,uoms.Name as UOM,categories.Name as Category,transactions.DocumentNumber,transactions.ShipmentQuantity,issues.DocumentNumber AS IssueDoc,issues.DeliveredBy,issues.DeliveredDate,issues.id AS IssuesIds,issues.ReqId AS TransferId from transactions INNER JOIN stores on transactions.StoreId=stores.Id INNER JOIN regitems on transactions.ItemId=regitems.Id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id INNER JOIN categories ON regitems.CategoryId=categories.Id INNER JOIN issues ON transactions.HeaderId=issues.id INNER JOIN stores as storesalias ON issues.SourceStoreId=storesalias.id where transactions.ItemId='.$itid.' AND transactions.StoreId='.$stid.' AND transactions.IsOnShipment=1 AND transactions.IsVoid=0 AND transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and ((SELECT COALESCE((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))),0) FROM transactions WHERE StoreId=stores.id AND transactions.ItemId=regitems.id and transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings)))>=0 order by transactions.id asc');
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
