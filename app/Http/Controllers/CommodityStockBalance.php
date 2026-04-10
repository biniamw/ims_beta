<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CommodityStockBalance extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return view('inventory.comstockbalance')->renderSections()['content'];
        }
        else{
            return view('inventory.comstockbalance');
        }
    }

    public function comStockBalanceData()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $combalancedata=DB::select('SELECT woredaId AS wid,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,"KG" AS UomName,

            @ratioqnt:=(SELECT ROUND(COALESCE(SUM(prd_order_details.QuantityInKG),0),2) FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id WHERE prd_order_details.woredas_id=transactions.woredaId AND prd_orders.customers_id=1 AND prd_orders.Status IN("Pending","Ready","Reviewed","On-Production","Process-Finished","Production-Closed","Verified","Approved")) AS RatioQuantity,

            @reqamnt:=(SELECT ROUND(COALESCE(SUM(requisitiondetails.NetKg),0),2) FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.CommodityId=transactions.woredaId AND requisitions.CustomerOrOwner=1 AND requisitions.Status IN("Draft","Pending","Verified","Reviewed","Approved")) AS ReqAmount,

            @penbalance:=ROUND((@reqamnt+@ratioqnt),2) AS PendingBalance,

            @strbalance:=(SELECT ROUND(SUM(COALESCE(tr.StockInComm,0))-SUM(COALESCE(tr.StockOutComm,0)), 2) FROM transactions AS tr WHERE tr.woredaId=transactions.woredaId AND tr.TransactionType!="On-Production" AND tr.customers_id=transactions.customers_id) AS StoreBalance,

            @availableqnt:=ROUND((@strbalance-@penbalance),2) AS AvailableBalance,

            ROUND(SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0)), 2) AS AvailableAllBalance,
            transactions.customers_id FROM transactions LEFT JOIN woredas ON transactions.woredaId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN uoms ON transactions.uomId=uoms.id WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.customers_id=1 GROUP BY transactions.woredaId HAVING AvailableAllBalance>0 ORDER BY woredas.Woreda_Name ASC
        ');
        if(request()->ajax()) {
            return datatables()->of($combalancedata)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn='<a class="commbalance" href="javascript:void(0)" onclick="comBalanceFn('.$data->wid.','.$data->customers_id.')" data-id="commbalance'.$data->wid.'" title="Show Commodity detail inforamtion"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function cusComStockBalanceData()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $combalancedata=DB::select('SELECT woredaId AS wid,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,"KG" AS UomName,transactions.customers_id,customers.Code AS CustomerCode,customers.Name AS CustomerName,customers.TinNumber,
            @ratioqnt:=(SELECT ROUND(COALESCE(SUM(prd_order_details.QuantityInKG),0),2) FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id WHERE prd_order_details.woredas_id=transactions.woredaId AND prd_orders.customers_id=transactions.customers_id AND prd_orders.Status IN("Pending","Ready","Reviewed","On-Production","Process-Finished","Production-Closed","Verified","Approved")) AS RatioQuantity,

            @reqamnt:=(SELECT ROUND(COALESCE(SUM(requisitiondetails.NetKg),0),2) FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.CommodityId=transactions.woredaId AND requisitions.CustomerOrOwner=transactions.customers_id AND requisitions.Status IN("Draft","Pending","Verified","Reviewed","Approved")) AS ReqAmount,

            @penbalance:=ROUND((@reqamnt+@ratioqnt),2) AS PendingBalance,

            @strbalance:=(SELECT ROUND(SUM(COALESCE(tr.StockInComm,0))-SUM(COALESCE(tr.StockOutComm,0)), 2) FROM transactions AS tr WHERE tr.woredaId=transactions.woredaId AND tr.TransactionType!="On-Production" AND tr.customers_id=transactions.customers_id) AS StoreBalance,

            @availableqnt:=ROUND((@strbalance-@penbalance),2) AS AvailableBalance,

            ROUND(SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0)), 2) AS AvailableAllBalance,
            transactions.customers_id FROM transactions LEFT JOIN woredas ON transactions.woredaId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN uoms ON transactions.uomId=uoms.id LEFT JOIN customers ON transactions.customers_id=customers.id WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.customers_id>1 GROUP BY transactions.woredaId,transactions.customers_id HAVING AvailableAllBalance>0 ORDER BY customers.Name ASC
        ');
        if(request()->ajax()) {
            return datatables()->of($combalancedata)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn='<a class="commbalance" href="javascript:void(0)" onclick="comBalanceFn('.$data->wid.','.$data->customers_id.')" data-id="commbalance'.$data->wid.'" title="Show Commodity detail inforamtion"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }


    public function showComStockBalance($wid,$cid)
    {
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;

        $orgdata=DB::select('SELECT woredas.id,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE woredas.id='.$wid);
        $customerdata=DB::select('SELECT customers.Code AS CustomerCode,customers.Name AS CustomerName,customers.TinNumber,customers.PhoneNumber,customers.OfficePhone,customers.EmailAddress FROM customers WHERE customers.id='.$cid);

        return response()->json(['orgdata'=>$orgdata,'customerdata'=>$customerdata]);       
    }

    public function showComStockBalanceDetail($wid,$cusid)
    {
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;

        $comstbalancedata=DB::select('SELECT transactions.woredaId,transactions.StoreId,transactions.LocationId,transactions.CommodityType,transactions.Grade AS GradeVal,transactions.CropYear AS CropYearVal,transactions.uomId,stores.Name AS StoreName,transactions.customers_id,transactions.ProcessType,transactions.CropYear,uoms.Name AS UomName,customers.Name,locations.Name AS LocationName,lookups.CommodityType AS CommType,crplookups.CropYear,grdlookups.Grade,

            @ratioBag:=(SELECT ROUND(COALESCE(SUM(prd_order_details.Quantity),0),2) FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id WHERE prd_order_details.woredas_id=transactions.woredaId AND prd_order_details.CommodityType=transactions.CommodityType AND prd_order_details.Grade=transactions.Grade AND prd_order_details.ProcessType=transactions.ProcessType AND prd_order_details.CropYear=transactions.CropYear AND prd_orders.customers_id=transactions.customers_id AND prd_order_details.stores_id=transactions.StoreId AND prd_order_details.LocationId=transactions.LocationId AND prd_order_details.uoms_id=transactions.uomId AND prd_orders.Status IN("Draft","Pending","Reviewed","Ready","On-Production","Process-Finished","Production-Closed","Verified","Approved")) AS RatioBag,

            @ratiokg:=(SELECT ROUND(COALESCE(SUM(prd_order_details.QuantityInKG),0),2)FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id WHERE prd_order_details.woredas_id=transactions.woredaId AND prd_order_details.CommodityType=transactions.CommodityType AND prd_order_details.Grade=transactions.Grade AND prd_order_details.ProcessType=transactions.ProcessType AND prd_order_details.CropYear=transactions.CropYear AND prd_orders.customers_id=transactions.customers_id AND prd_order_details.stores_id=transactions.StoreId AND prd_order_details.LocationId=transactions.LocationId AND prd_order_details.uoms_id=transactions.uomId AND prd_orders.Status IN("Draft","Pending","Reviewed","Ready","On-Production","Process-Finished","Production-Closed","Verified","Approved")) AS RatioKG,

            @reqBag:=(SELECT ROUND(COALESCE(SUM(requisitiondetails.NumOfBag),0),2) FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.CommodityId=transactions.woredaId AND requisitiondetails.CommodityType=transactions.CommodityType AND requisitiondetails.Grade=transactions.Grade AND requisitiondetails.ProcessType=transactions.ProcessType AND requisitiondetails.CropYear=transactions.CropYear AND requisitions.CustomerOrOwner=transactions.customers_id AND requisitiondetails.StoreId=transactions.StoreId AND requisitiondetails.LocationId=transactions.LocationId AND requisitiondetails.DefaultUOMId=transactions.uomId AND requisitions.Status IN("Draft","Pending","Verified","Reviewed","Approved")) AS ReqBag,

            @reqKg:=(SELECT ROUND(COALESCE(SUM(requisitiondetails.NetKg),0),2) FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.CommodityId=transactions.woredaId AND requisitiondetails.CommodityType=transactions.CommodityType AND requisitiondetails.Grade=transactions.Grade AND requisitiondetails.ProcessType=transactions.ProcessType AND requisitiondetails.CropYear=transactions.CropYear AND requisitions.CustomerOrOwner=transactions.customers_id AND requisitiondetails.StoreId=transactions.StoreId AND requisitiondetails.LocationId=transactions.LocationId AND requisitiondetails.DefaultUOMId=transactions.uomId AND requisitions.Status IN("Draft","Pending","Verified","Reviewed","Approved")) AS ReqKG,

            @availablebag:=(SELECT ROUND(SUM(COALESCE(tr.StockInNumOfBag,0))-SUM(COALESCE(tr.StockOutNumOfBag,0)), 2) FROM transactions AS tr WHERE tr.woredaId=transactions.woredaId AND tr.CommodityType=transactions.CommodityType AND tr.Grade=transactions.Grade AND tr.ProcessType=transactions.ProcessType AND tr.CropYear=transactions.CropYear AND tr.StoreId=transactions.StoreId AND tr.LocationId=transactions.LocationId AND tr.uomId=transactions.uomId AND tr.TransactionType!="On-Production" AND tr.customers_id=transactions.customers_id) AS AvByBag,

            @availablekg:=(SELECT ROUND(SUM(COALESCE(tr.StockInComm,0))-SUM(COALESCE(tr.StockOutComm,0)), 2) FROM transactions AS tr WHERE tr.woredaId=transactions.woredaId AND tr.CommodityType=transactions.CommodityType AND tr.Grade=transactions.Grade AND tr.ProcessType=transactions.ProcessType AND tr.CropYear=transactions.CropYear AND tr.StoreId=transactions.StoreId AND tr.LocationId=transactions.LocationId AND tr.uomId=transactions.uomId AND tr.TransactionType!="On-Production" AND tr.customers_id=transactions.customers_id) AS AvBalance,

            @pendingdispatch:=(SELECT ROUND(COALESCE(SUM(requisitiondetails.NetKg),0) - COALESCE(SUM(requisitiondetails.DispNetKg),0),2) FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.CommodityId=transactions.woredaId AND requisitiondetails.CommodityType=transactions.CommodityType AND requisitiondetails.Grade=transactions.Grade AND requisitiondetails.ProcessType=transactions.ProcessType AND requisitiondetails.CropYear=transactions.CropYear AND requisitions.CustomerOrOwner=transactions.customers_id AND requisitiondetails.StoreId=transactions.StoreId AND requisitiondetails.LocationId=transactions.LocationId AND requisitiondetails.DefaultUOMId=transactions.uomId AND requisitions.Status IN("Issued")) AS PendingDispatch,

            @avbag:=ROUND((@availablebag-@reqBag-@ratioBag),2) AS AvailableByBag,
            @avbalance:=ROUND((@availablekg-@reqKg-@ratiokg),2) AS AvailableBalance,
            ROUND((@avbalance/17),2) AS AvailableByFeresula,
            ROUND((@avbalance/1000),2) AS AvailableByTon,
            ROUND((@ratiokg+@reqKg),2) AS PendingQuantity 

            FROM transactions INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN woredas ON transactions.woredaId=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id INNER JOIN uoms ON transactions.uomId=uoms.id INNER JOIN customers ON transactions.customers_id=customers.id LEFT JOIN locations ON transactions.LocationId=locations.id LEFT JOIN lookups ON transactions.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS crplookups ON transactions.CropYear=crplookups.CropYearValue LEFT JOIN lookups AS grdlookups ON transactions.Grade=grdlookups.GradeValue WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.woredaId='.$wid.' AND transactions.customers_id='.$cusid.' GROUP BY transactions.LocationId,transactions.CommodityType,transactions.Grade,transactions.ProcessType,transactions.CropYear,transactions.StoreId,transactions.uomId,transactions.customers_id HAVING AvailableBalance>0 OR PendingQuantity>0 OR PendingDispatch>0 ORDER BY stores.Name ASC,locations.Name ASC,CommType ASC,transactions.IsOnShipment ASC
        ');
        return datatables()->of($comstbalancedata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showProductionQnt($comm,$str,$flrmap,$commtype,$grade,$prctype,$crpyr,$uomid,$cusid)
    {
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;

        $comstbalancedata=DB::select('SELECT requisitions.DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,requisitiondetails.NumOfBag,requisitiondetails.NetKg,ROUND((requisitiondetails.NetKg/1000),2) AS TON,requisitiondetails.Feresula,0 AS Ord,"Requisition" AS RecType,requisitiondetails.id AS RecId FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups ON requisitiondetails.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON requisitiondetails.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON requisitiondetails.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON requisitiondetails.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id LEFT JOIN stores ON requisitiondetails.StoreId=stores.id WHERE requisitiondetails.CommodityId='.$comm.' AND requisitiondetails.StoreId='.$str.' AND requisitiondetails.LocationId='.$flrmap.' AND requisitiondetails.CommodityType='.$commtype.' AND requisitiondetails.Grade='.$grade.' AND requisitiondetails.ProcessType="'.$prctype.'" AND requisitiondetails.CropYear='.$crpyr.' AND requisitiondetails.DefaultUOMId='.$uomid.' AND requisitions.CustomerOrOwner='.$cusid.' AND requisitions.Status IN("Draft","Pending","Verified","Reviewed","Approved")
            UNION
            SELECT prd_orders.ProductionOrderNumber AS DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,ROUND(COALESCE(prd_order_details.Quantity),0) AS NumOfBag,prd_order_details.QuantityInKG AS NetKg,ROUND((COALESCE(prd_order_details.QuantityInKG,0)/1000),2) AS TON,ROUND((COALESCE(prd_order_details.QuantityInKG,0)/17),2) AS Feresula,1 AS Ord,"Production" AS RecType,prd_order_details.id AS RecId FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id LEFT JOIN lookups ON prd_order_details.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON prd_order_details.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON prd_order_details.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON prd_order_details.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON prd_order_details.uoms_id=uoms.id LEFT JOIN stores ON prd_order_details.stores_id=stores.id WHERE prd_order_details.woredas_id='.$comm.' AND prd_order_details.stores_id='.$str.' AND prd_order_details.LocationId='.$flrmap.' AND prd_order_details.CommodityType='.$commtype.' AND prd_order_details.Grade='.$grade.' AND prd_order_details.ProcessType="'.$prctype.'" AND prd_order_details.CropYear='.$crpyr.' AND prd_order_details.uoms_id='.$uomid.' AND prd_orders.customers_id='.$cusid.' AND prd_orders.Status IN("Pending","Ready","Reviewed","On-Production","Process-Finished","Verified") ORDER BY Ord ASC         
        ');
        return datatables()->of($comstbalancedata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
    
    public function showDispatchData($comm,$str,$flrmap,$commtype,$grade,$prctype,$crpyr,$uomid,$cusid)
    {
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;

        $commdispatchdata=DB::select('SELECT requisitions.DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,requisitiondetails.NumOfBag,requisitiondetails.NetKg,ROUND((requisitiondetails.NetKg/1000),2) AS TON,requisitiondetails.Feresula,
        
        @dispnumofbag:=(SELECT (COALESCE(SUM(dispatchchildren.NumOfBag),0)) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchchildren.ReqDetailId=requisitiondetails.id AND dispatchparents.Status IN("Pending","Verified","Approved")) AS DispatchNumOfBag,

        @dispnetkg:=(SELECT (COALESCE(SUM(dispatchchildren.NetKG),0)) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchchildren.ReqDetailId=requisitiondetails.id AND dispatchparents.Status IN("Pending","Verified","Approved")) AS DispatchNetKG,

        @dispton:=(SELECT (COALESCE(SUM(dispatchchildren.NetKG),0)/1000) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchchildren.ReqDetailId=requisitiondetails.id AND dispatchparents.Status IN("Pending","Verified","Approved")) AS DispatchTON,

        @dispfer:=(SELECT (COALESCE(SUM(dispatchchildren.NetKG),0)/17) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchchildren.ReqDetailId=requisitiondetails.id AND dispatchparents.Status IN("Pending","Verified","Approved")) AS DispatchFeresula,

        requisitiondetails.NumOfBag-@dispnumofbag AS RemNumOfBag,
        ROUND((requisitiondetails.NetKg-@dispnetkg),2) AS RemNetKG,
        ROUND(((requisitiondetails.NetKg/1000)-@dispton),2) AS RemTON,
        ROUND(((requisitiondetails.NetKg/17)-@dispfer),2) AS RemFeresula
        
        FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups ON requisitiondetails.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON requisitiondetails.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON requisitiondetails.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON requisitiondetails.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id LEFT JOIN stores ON requisitiondetails.StoreId=stores.id WHERE requisitiondetails.CommodityId='.$comm.' AND requisitiondetails.StoreId='.$str.' AND requisitiondetails.LocationId='.$flrmap.' AND requisitiondetails.CommodityType='.$commtype.' AND requisitiondetails.Grade='.$grade.' AND requisitiondetails.ProcessType="'.$prctype.'" AND requisitiondetails.CropYear='.$crpyr.' AND requisitiondetails.DefaultUOMId='.$uomid.' AND requisitions.CustomerOrOwner='.$cusid.' AND requisitions.Status IN("Issued") GROUP BY requisitiondetails.CommodityId,requisitiondetails.LocationId,requisitiondetails.CommodityType,requisitiondetails.Grade,requisitiondetails.ProcessType,requisitiondetails.CropYear,requisitiondetails.StoreId,requisitiondetails.DefaultUOMId');
        return datatables()->of($commdispatchdata)
        ->addIndexColumn()
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
