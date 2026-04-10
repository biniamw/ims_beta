<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\customer;
use App\Models\prd_bomchild;
use App\Models\store;
use App\Models\prd_bomdetail;
use App\Models\User;
use App\Models\uom;
use App\Models\prd_order;
use App\Models\prd_order_cert;
use App\Models\prd_order_detail;
use App\Models\prd_order_process;
use App\Models\prd_duration;
use App\Models\prd_biproduct;
use App\Models\prd_output;
use App\Models\com_certificate;
use App\Models\woreda_certificate;
use App\Models\actions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductionCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $expnum;
    public $rejnum;

    public function __construct()
    {
        $this->expnum = 998;
        $this->rejnum = 999;
    }

    public function index(Request $request)
    {
        $currentdate=Carbon::today()->toDateString();
        $customersdata=DB::select('SELECT DISTINCT customers.id,customers.Code,customers.Name,customers.TinNumber FROM transactions INNER JOIN customers ON transactions.customers_id=customers.id WHERE customers.ActiveStatus="Active" AND customers.id>1');
        $productiondata=DB::select('SELECT DISTINCT prd_orders.id,prd_orders.ProductionOrderNumber,customers.Code,customers.Name,customers.TinNumber FROM prd_orders INNER JOIN customers ON prd_orders.customers_id=customers.id');
        $arrivaldatedata=DB::select('SELECT DISTINCT transactions.ArrivalDate,transactions.woredaId FROM transactions WHERE transactions.ArrivalDate IS NOT NULL AND transactions.ArrivalDate!="" AND transactions.ItemType="Commodity" ORDER BY transactions.ArrivalDate ASC');
        if($request->ajax()) {
            return view('production.prdcost',['currentdate'=>$currentdate,'customersdata'=>$customersdata,'productiondata'=>$productiondata,'arrivaldatedata'=>$arrivaldatedata])->renderSections()['content'];
        }
        else{
            return view('production.prdcost',['currentdate'=>$currentdate,'customersdata'=>$customersdata,'productiondata'=>$productiondata,'arrivaldatedata'=>$arrivaldatedata]);
        }
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

    public function showPrdCommodity(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $prdId=$_POST['prdId']; 
        $prdId = !empty($prdId) ? $prdId : 0;

        $prdorderdetails=prd_order_detail::join('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
        ->join('woredas','prd_order_details.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('uoms','prd_order_details.uoms_id','uoms.id')
        ->join('stores','prd_order_details.stores_id','stores.id')
        ->where('prd_order_details.prd_orders_id',$prdId)
        ->orderBy('prd_order_details.id','ASC')
        ->get(['prd_orders.OrderDate','prd_orders.ProductionStartDate','prd_orders.ProductionEndDate','prd_order_details.*','prd_order_details.id AS PrdDetailId',
            DB::raw('CASE WHEN prd_order_details.CommodityType=1 THEN "Arrival" WHEN prd_order_details.CommodityType=2 THEN "Export" WHEN prd_order_details.CommodityType=3 THEN "Reject" END AS CommodityTypeName'),
            DB::raw('CASE WHEN prd_order_details.Grade=100 THEN "UG (Under Grade)" WHEN prd_order_details.Grade=101 THEN "NG (No Grade)" WHEN prd_order_details.Grade=102 THEN "Peaberry Coffee" ELSE prd_order_details.Grade END AS GradeName'),
            DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_order_details.Remark,"") AS Remark'),DB::raw('IFNULL(prd_order_details.Symbol,"") AS Symbol'),'uoms.Name AS UomName','uoms.uomamount','uoms.bagweight','stores.Name AS StoreName',
            DB::raw('(SELECT COALESCE(SUM(prd_order_processes.QuantityByKg),0) FROM prd_order_processes WHERE prd_order_processes.prd_order_details_id=prd_order_details.id) AS TotalQuantityByKg')
        ]);
        $prdorderid=$prdorderdetails[0]->prd_orders_id ?? 0;
        $expnm=$this->expnum;
        $rejnm=$this->rejnum;

        $prdexporder=prd_order::join('woredas','prd_orders.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->leftJoin('stores','prd_orders.PrdWarehouse','=','stores.id')
        ->where('prd_orders.id',$prdorderid)
        ->orderBy('prd_orders.id','ASC')
        ->get(['prd_orders.*',DB::raw('CONCAT('.$expnm.',prd_orders.id) AS PrdDetailId'),DB::raw('"Export" AS CommodityTypeName'),DB::raw('"2" AS CommodityType'),
            DB::raw('CASE WHEN prd_orders.Grade=100 THEN "UG (Under Grade)" WHEN prd_orders.Grade=101 THEN "NG (No Grade)" WHEN prd_orders.Grade=102 THEN "Peaberry Coffee" ELSE prd_orders.Grade END AS GradeName'),
            DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_orders.Remark,"") AS Remark'),DB::raw('IFNULL(prd_orders.Symbol,"") AS Symbol'),'stores.Name AS StoreName'
        ]);

        $commname=$prdexporder[0]->Origin ?? "";
        $gradename=$prdexporder[0]->GradeName ?? "";
        $processtypename=$prdexporder[0]->ProcessType ?? "";
        $sievesize=$prdexporder[0]->SieveSize ?? "";
        $expweight=$prdexporder[0]->ExportWeightbyKg ?? 0;
        $rejweight=$prdexporder[0]->RejectWeightbyKg ?? 0;
        $wasweight=$prdexporder[0]->WastageWeightbyKg ?? 0;
        $totalton=round(($expweight + $rejweight + $wasweight)/1000,2);

        $prdrejorder=prd_order::join('woredas','prd_orders.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->leftJoin('stores','prd_orders.PrdWarehouse','=','stores.id')
        ->where('prd_orders.id',$prdorderid)
        ->orderBy('prd_orders.id','ASC')
        ->get(['prd_orders.*',DB::raw('CONCAT('.$rejnm.',prd_orders.id) AS PrdDetailId'),DB::raw('"Reject" AS CommodityTypeName'),DB::raw('"3" AS CommodityType'),
            DB::raw('CASE WHEN prd_orders.Grade=100 THEN "UG (Under Grade)" WHEN prd_orders.Grade=101 THEN "NG (No Grade)" WHEN prd_orders.Grade=102 THEN "Peaberry Coffee" ELSE prd_orders.Grade END AS GradeName'),
            DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_orders.Remark,"") AS Remark'),DB::raw('IFNULL(prd_orders.Symbol,"") AS Symbol'),'stores.Name AS StoreName'
        ]);

        return response()->json(['prdorderdetails'=>$prdorderdetails,'prdexporder'=>$prdexporder,'prdrejorder'=>$prdrejorder,
            'commname'=>$commname,'gradename'=>$gradename,'processtypename'=>$processtypename,'sievesize'=>$sievesize,'totalton'=>$totalton
        ]);
    }

    public function getPrdCostCommData(Request $request){
        $recordid=$_POST['recordid']; 
        $prdorderdetails=prd_order_detail::join('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
        ->join('woredas','prd_order_details.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('uoms','prd_order_details.uoms_id','uoms.id')
        ->join('stores','prd_order_details.stores_id','stores.id')
        ->where('prd_order_details.id',$recordid)
        ->orderBy('prd_order_details.id','ASC')
        ->get(['prd_orders.OrderDate','prd_orders.ProductionStartDate','prd_orders.ProductionEndDate','prd_order_details.*','prd_order_details.id AS PrdDetailId',
            DB::raw('CASE WHEN prd_order_details.CommodityType=1 THEN "Arrival" WHEN prd_order_details.CommodityType=2 THEN "Export" WHEN prd_order_details.CommodityType=3 THEN "Reject" END AS CommodityTypeName'),
            DB::raw('CASE WHEN prd_order_details.Grade=100 THEN "UG (Under Grade)" WHEN prd_order_details.Grade=101 THEN "NG (No Grade)" WHEN prd_order_details.Grade=102 THEN "Peaberry Coffee" ELSE prd_order_details.Grade END AS GradeName'),
            DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_order_details.Remark,"") AS Remark'),DB::raw('IFNULL(prd_order_details.Symbol,"") AS Symbol'),
            'uoms.Name AS UomName','uoms.uomamount','uoms.bagweight','stores.Name AS StoreName'
        ]);
        $prdorderid=$prdorderdetails[0]->prd_orders_id ?? 0;

        return response()->json(['prdorderdetails'=>$prdorderdetails]);
    }

    public function getPrdExpCostCommData(Request $request){
        $recordid=$_POST['recordid']; 
        $x=3;
        $recid = $this->removeFirstXDigits($recordid, $x);
        $expnm=$this->expnum;
        $rejnm=$this->rejnum;
        $prdexporder=prd_order::join('woredas','prd_orders.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->leftJoin('stores','prd_orders.PrdWarehouse','=','stores.id')
        ->where('prd_orders.id',$recid)
        ->orderBy('prd_orders.id','ASC')
        ->get(['prd_orders.*',DB::raw('CONCAT('.$expnm.',prd_orders.id) AS PrdDetailId'),DB::raw('"Export" AS CommodityTypeName'),DB::raw('"2" AS CommodityType'),
            DB::raw('CASE WHEN prd_orders.Grade=100 THEN "UG (Under Grade)" WHEN prd_orders.Grade=101 THEN "NG (No Grade)" WHEN prd_orders.Grade=102 THEN "Peaberry Coffee" ELSE prd_orders.Grade END AS GradeName'),
            DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_orders.Remark,"") AS Remark'),DB::raw('IFNULL(prd_orders.Symbol,"") AS Symbol'),'stores.Name AS StoreName'
        ]);

        $prdrejorder=prd_order::join('woredas','prd_orders.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->leftJoin('stores','prd_orders.PrdWarehouse','=','stores.id')
        ->where('prd_orders.id',$recid)
        ->orderBy('prd_orders.id','ASC')
        ->get(['prd_orders.*',DB::raw('CONCAT('.$rejnm.',prd_orders.id) AS PrdDetailId'),DB::raw('"Reject" AS CommodityTypeName'),DB::raw('"3" AS CommodityType'),
            DB::raw('CASE WHEN prd_orders.Grade=100 THEN "UG (Under Grade)" WHEN prd_orders.Grade=101 THEN "NG (No Grade)" WHEN prd_orders.Grade=102 THEN "Peaberry Coffee" ELSE prd_orders.Grade END AS GradeName'),
            DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_orders.Remark,"") AS Remark'),DB::raw('IFNULL(prd_orders.Symbol,"") AS Symbol'),'stores.Name AS StoreName'
        ]);

        return response()->json(['prdexporder'=>$prdexporder,'prdrejorder'=>$prdrejorder]);
    }

    public function getCommtDateDiff(Request $request){
        $arrivaldate=$_POST['arrivaldate']; 
        $lastdates=$_POST['lastdates']; 
        $commtype=$_POST['commtype']; 

        $prdamount=0;
        $arrdate=Carbon::parse($arrivaldate);
        $lasdate=Carbon::parse($lastdates);
        $diffInDays=$arrdate->diffInDays($lasdate);

        $storageamount=DB::select('SELECT prd_storage_fees.* FROM prd_storage_fees WHERE '.$diffInDays.' BETWEEN prd_storage_fees.MinDateAmount AND prd_storage_fees.MaxDateAmount AND prd_storage_fees.CommType='.$commtype);      
        $prdamount=$storageamount[0]->Amount ?? 0;

        return response()->json(['diffInDays'=>$diffInDays,'prdamount'=>$prdamount]);
    }

    function removeFirstXDigits($number,$x) {
        $numberStr = (string) $number;
        $result = substr($numberStr,$x);
        return $result;
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
