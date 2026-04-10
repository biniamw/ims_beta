<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\actions;
use App\Models\adjustment;
use App\Models\adjustmentdetail;
use App\Models\requisition;
use App\Models\requisitiondetail;
use App\Models\prd_order;
use App\Models\prd_order_cert;
use App\Models\prd_order_detail;
use App\Models\prd_order_process;
use App\Models\Regitem;
use App\Models\serialandbatchnum_temp;
use App\Models\serialandbatchnum;
use App\Models\uom;
use App\Models\store;
use App\Models\transaction;
use Response;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Exception;

class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reqpage = 1;
        $rendercon="";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $curdate=Carbon::today()->toDateString();
        $itemSrc=""; 
        $itemSrcEd="";
        $storeSrc=DB::select('SELECT DISTINCT StoreId AS id,StoreId,stores.Name as Name,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=10 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        //$itemSrcs=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        // $itemSrcs=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,
        // @balance:=(SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)) AS Balance,
        // transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND transactions.FiscalYear='.$fyear.' GROUP BY regitems.Name,transactions.StoreId HAVING Balance>0 ORDER BY regitems.Name ASC');
        
        $itemSrcs=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,"1" AS Balance,
        transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" GROUP BY regitems.Name,transactions.StoreId HAVING Balance>0 ORDER BY regitems.Name ASC');

        $itemSrcd=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        $itemSrci=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        $itemSrcied=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        $brand=DB::select('select * from brands where ActiveStatus="Active" and IsDeleted=1');
        $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $fiscalyearslist=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $storelists=DB::select('SELECT * FROM stores');

        $customerdatasrc=DB::select('select * from customers where CustomerCategory IN("Customer","--","Customer&Supplier","Foreigner Buyer","Person") and ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $recustomerdatasrc=DB::select('select * from customers where CustomerCategory IN("Customer","--","Customer&Supplier","Foreigner Buyer","Person") and ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $itemSrcs=DB::select('select * from regitems where ActiveStatus="Active" and Type="Good" and IsDeleted=1 order by Name asc');
        $users=DB::select('select * from users where username!="'.$user.'" and id>1 order by username asc');
        $desStoreSrc=DB::select('SELECT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=7 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        $reqreason=DB::select('SELECT lookups.RequestReasonValue,lookups.RequestReason FROM lookups WHERE lookups.RequestReasonStatus="Active"');
        $commtype=DB::select('SELECT lookups.CommodityTypeValue,lookups.CommodityType FROM lookups WHERE lookups.CommodityTypeStatus="Active"');
        $locationdata=DB::select('SELECT * FROM locations WHERE locations.ActiveStatus="Active"');
        $prdorderdata=DB::select('SELECT DISTINCT transactions.ProductionNumber,CONCAT(IFNULL(transactions.ProductionNumber,"")," , ",IFNULL(transactions.CertNumber,"")) AS ProductionNumberName,transactions.customers_id,(SELECT id FROM prd_orders WHERE prd_orders.ProductionOrderNumber=transactions.ProductionNumber) AS PrdId FROM transactions WHERE transactions.ProductionNumber IS NOT NULL AND transactions.ProductionNumber!=""');
        $prdordercertdata=DB::select('SELECT DISTINCT transactions.CertNumber,transactions.ProductionNumber FROM transactions WHERE transactions.CertNumber!="" OR transactions.CertNumber!=null');
        $prdorderexporigin=DB::select('SELECT DISTINCT transactions.woredaId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS CommType,CONCAT(transactions.CommodityType,transactions.ProductionNumber) AS MergedData FROM transactions LEFT JOIN woredas ON transactions.woredaId=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE transactions.ProductionNumber!="" AND transactions.ProductionNumber IS NOT NULL');
        $rejprdorderexporigin=DB::select('SELECT DISTINCT transactions.woredaId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS MergedData FROM transactions LEFT JOIN woredas ON transactions.woredaId=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE transactions.CommodityType=3');
        $prdSupplierDataSrc=DB::select('SELECT DISTINCT customers.id,customers.Code,customers.Name,customers.TinNumber,transactions.CommodityType,CONCAT(transactions.CommodityType,transactions.customers_id) AS MergedData FROM transactions LEFT JOIN customers ON transactions.SupplierId=customers.id WHERE transactions.SupplierId>0');
        $grndata=DB::select('SELECT DISTINCT transactions.GrnNumber,transactions.SupplierId FROM transactions WHERE transactions.GrnNumber!="" AND transactions.GrnNumber IS NOT NULL');
        $grncommodity=DB::select('SELECT DISTINCT transactions.woredaId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS CommType,transactions.GrnNumber FROM transactions INNER JOIN woredas ON transactions.woredaId=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE transactions.GrnNumber!="" AND transactions.GrnNumber IS NOT NULL');
        $gradedata=DB::select('SELECT DISTINCT transactions.Grade,lookups.Grade AS GradeName,CONCAT(transactions.woredaId,transactions.SupplierId,transactions.GrnNumber) AS MergedData FROM transactions INNER JOIN lookups ON transactions.Grade=lookups.GradeValue WHERE transactions.Grade!="" AND transactions.Grade IS NOT NULL AND transactions.GrnNumber!="" AND transactions.SupplierId>0 UNION SELECT DISTINCT transactions.Grade,lookups.Grade AS GradeName,CONCAT(transactions.woredaId,transactions.ProductionNumber,transactions.CertNumber) AS MergedData FROM transactions INNER JOIN lookups ON transactions.Grade=lookups.GradeValue WHERE transactions.Grade!="" AND transactions.Grade IS NOT NULL AND transactions.ProductionNumber!="" AND transactions.CertNumber!=""');
        $rejgradedata=DB::select('SELECT DISTINCT transactions.Grade,lookups.Grade AS GradeName,transactions.CommodityType AS MergedData FROM transactions LEFT JOIN lookups ON transactions.Grade=lookups.GradeValue WHERE transactions.Grade!="" AND transactions.Grade IS NOT NULL AND transactions.CommodityType=3');
        $processtypedata=DB::select('SELECT DISTINCT transactions.ProcessType,CONCAT(transactions.woredaId,transactions.SupplierId,transactions.GrnNumber) AS MergedData FROM transactions WHERE transactions.ProcessType!="" AND transactions.GrnNumber!="" AND transactions.SupplierId>0 UNION SELECT DISTINCT transactions.ProcessType,CONCAT(transactions.woredaId,transactions.ProductionNumber,transactions.CertNumber) AS MergedData FROM transactions WHERE transactions.ProcessType!="" AND transactions.ProductionNumber!="" AND transactions.CertNumber!=""');
        $rejprocesstypedata=DB::select('SELECT DISTINCT transactions.ProcessType,transactions.CommodityType AS MergedData FROM transactions WHERE transactions.ProcessType!="" AND transactions.CommodityType=3');
        $cropyeardata=DB::select('SELECT DISTINCT transactions.CropYear,lookups.CropYear AS CropYears,CONCAT(transactions.woredaId,transactions.SupplierId,transactions.GrnNumber) AS MergedData FROM transactions INNER JOIN lookups ON transactions.CropYear=lookups.CropYearValue WHERE transactions.CropYear!="" AND transactions.GrnNumber!="" AND transactions.SupplierId>0  UNION SELECT DISTINCT transactions.CropYear,lookups.CropYear AS CropYears,CONCAT(transactions.woredaId,transactions.ProductionNumber,transactions.CertNumber) AS MergedData FROM transactions INNER JOIN lookups ON transactions.CropYear=lookups.CropYearValue WHERE transactions.CropYear!="" AND transactions.ProductionNumber!="" AND transactions.CertNumber!=""');
        $rejcropyeardata=DB::select('SELECT DISTINCT transactions.CropYear,lookups.CropYear AS CropYears,transactions.CommodityType AS MergedData FROM transactions INNER JOIN lookups ON transactions.CropYear=lookups.CropYearValue WHERE transactions.CropYear!="" AND transactions.CommodityType=3');
        $uomdata=DB::select('SELECT DISTINCT transactions.uomId,uoms.Name AS UOM,uoms.bagweight,uoms.uomamount,CONCAT(transactions.woredaId,transactions.SupplierId,transactions.GrnNumber) AS MergedData FROM transactions INNER JOIN uoms ON transactions.uomId=uoms.id WHERE transactions.uomId!="" AND transactions.GrnNumber!="" AND transactions.SupplierId>0 UNION SELECT DISTINCT transactions.uomId,uoms.Name AS UOM,uoms.bagweight,uoms.uomamount,CONCAT(transactions.woredaId,transactions.ProductionNumber,transactions.CertNumber) AS MergedData FROM transactions INNER JOIN uoms ON transactions.uomId=uoms.id WHERE transactions.uomId!="" AND transactions.ProductionNumber!="" AND transactions.CertNumber!=""');
        $rejuomdata=DB::select('SELECT DISTINCT transactions.uomId,uoms.Name AS UOM,uoms.bagweight,uoms.uomamount,transactions.CommodityType AS MergedData FROM transactions LEFT JOIN uoms ON transactions.uomId=uoms.id WHERE transactions.uomId!="" AND transactions.CommodityType=3');
        $prdtypedata=DB::select('SELECT lookups.ProductTypeValue,lookups.ProductType FROM lookups WHERE lookups.ProductTypeStatus="Active"');
        $comptypedata=DB::select('SELECT lookups.CompanyTypeValue,lookups.CompanyType FROM lookups WHERE lookups.CompanyTypeStatus="Active"');
        $requestedCommData=DB::select('SELECT DISTINCT requisitiondetails.HeaderId,requisitiondetails.CommodityId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS CommType FROM requisitiondetails LEFT JOIN woredas ON requisitiondetails.CommodityId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.Type=1');
        $concatDataSrc=DB::select('SELECT DISTINCT requisitiondetails.id AS ReqDetailId,requisitiondetails.HeaderId,requisitiondetails.CommodityId,CONCAT(IFNULL(customers.Name,""),", ",IFNULL(requisitiondetails.GrnNumber,""),", ",IFNULL(requisitiondetails.ProductionOrderNo,""),", ",IFNULL(requisitiondetails.CertNumber,""),", ",IFNULL(requisitiondetails.ExportCertNumber,""),", ",IFNULL(uoms.Name,"")) AS ConcatData,requisitiondetails.DefaultUOMId FROM requisitiondetails LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.Type=1');
        $dispmodedata=DB::select('SELECT lookups.DispatchModeValue,lookups.DispatchModeName FROM lookups WHERE lookups.DispatchModeStatus="Active"');

        if($reqpage==0){
            if($request->ajax()) {
                $rendercon="->renderSections()['content']";
                return view('inventory.adjustment',['storeSrc'=>$storeSrc,'itemSrcs'=>$itemSrcs,'itemSrcd'=>$itemSrcd,'itemSrci'=>$itemSrci,'itemSrcied'=>$itemSrcied,'brand'=>$brand,'user'=>$user,'fiscalyears'=>$fiscalyears,'fiscalyearslist'=>$fiscalyearslist,'storelists'=>$storelists,'curdate'=>$curdate])->renderSections()['content'];
            }
            else{
                $rendercon="";
                return view('inventory.adjustment',['storeSrc'=>$storeSrc,'itemSrcs'=>$itemSrcs,'itemSrcd'=>$itemSrcd,'itemSrci'=>$itemSrci,'itemSrcied'=>$itemSrcied,'brand'=>$brand,'user'=>$user,'fiscalyears'=>$fiscalyears,'fiscalyearslist'=>$fiscalyearslist,'storelists'=>$storelists,'curdate'=>$curdate]);
            }
        }
        else if($reqpage==1){
            if($request->ajax()) {
                return view('inventory.adjustmentproc',['storeSrc'=>$storeSrc,'desStoreSrc'=>$desStoreSrc,'itemSrcs'=>$itemSrcs,'users'=>$users,'user'=>$user,'userid'=>$userid,'itemSrc'=>$itemSrc,
                'itemSrcEd'=>$itemSrcEd,'fiscalyears'=>$fiscalyears,'storelists'=>$storelists,'curdate'=>$curdate,'customerdatasrc'=>$customerdatasrc,'recustomerdatasrc'=>$recustomerdatasrc,'reqreason'=>$reqreason,
                'commtype'=>$commtype,'locationdata'=>$locationdata,'prdorderdata'=>$prdorderdata,'prdordercertdata'=>$prdordercertdata,'prdorderexporigin'=>$prdorderexporigin,'rejprdorderexporigin'=>$rejprdorderexporigin,'prdSupplierDataSrc'=>$prdSupplierDataSrc,
                'grndata'=>$grndata,'grncommodity'=>$grncommodity,'uomdata'=>$uomdata,'rejuomdata'=>$rejuomdata,'gradedata'=>$gradedata,'rejgradedata'=>$rejgradedata,'processtypedata'=>$processtypedata,'rejprocesstypedata'=>$rejprocesstypedata,
                'cropyeardata'=>$cropyeardata,'rejcropyeardata'=>$rejcropyeardata,'prdtypedata'=>$prdtypedata,'comptypedata'=>$comptypedata,'requestedCommData'=>$requestedCommData,'concatDataSrc'=>$concatDataSrc,'dispmodedata'=>$dispmodedata])->renderSections()['content'];
            }
            else{
                return view('inventory.adjustmentproc',['storeSrc'=>$storeSrc,'desStoreSrc'=>$desStoreSrc,'itemSrcs'=>$itemSrcs,'users'=>$users,'user'=>$user,'userid'=>$userid,'itemSrc'=>$itemSrc,
                'itemSrcEd'=>$itemSrcEd,'fiscalyears'=>$fiscalyears,'storelists'=>$storelists,'curdate'=>$curdate,'customerdatasrc'=>$customerdatasrc,'recustomerdatasrc'=>$recustomerdatasrc,'reqreason'=>$reqreason,
                'commtype'=>$commtype,'locationdata'=>$locationdata,'prdorderdata'=>$prdorderdata,'prdordercertdata'=>$prdordercertdata,'prdorderexporigin'=>$prdorderexporigin,'rejprdorderexporigin'=>$rejprdorderexporigin,'prdSupplierDataSrc'=>$prdSupplierDataSrc,
                'grndata'=>$grndata,'grncommodity'=>$grncommodity,'uomdata'=>$uomdata,'rejuomdata'=>$rejuomdata,'gradedata'=>$gradedata,'rejgradedata'=>$rejgradedata,'processtypedata'=>$processtypedata,'rejprocesstypedata'=>$rejprocesstypedata,
                'cropyeardata'=>$cropyeardata,'rejcropyeardata'=>$rejcropyeardata,'prdtypedata'=>$prdtypedata,'comptypedata'=>$comptypedata,'requestedCommData'=>$requestedCommData,'concatDataSrc'=>$concatDataSrc,'dispmodedata'=>$dispmodedata]);
            }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //---------------Start Commodity-----------------------

    public function commadjlist($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $commlists=DB::select('SELECT adjustments.id,adjustments.DocumentNumber,adjustments.Type,prdlookups.ProductType,stores.Name AS StoreName,adjustments.AdjustedDate,adjustments.Status FROM adjustments LEFT JOIN lookups AS prdlookups ON adjustments.product_type=prdlookups.ProductTypeValue LEFT JOIN stores ON adjustments.StoreId=stores.id WHERE adjustments.customers_id=1 AND adjustments.fiscalyear='.$fy.' ORDER BY adjustments.id DESC');
        if(request()->ajax()) {
            return datatables()->of($commlists)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $adjedit='';
                $voidlink='';
                $undovoidlink='';
                $println='<a class="dropdown-item printAdjustmentAttachment" href="javascript:void(0)" id="adjustmentNote'.$data->id.'" data-id="'.$data->id.'" onclick="commAdjAttFn('.$data->id.')" title="Print Adjustment Note"><i class="fa fa-file"></i><span> Print Adjustment Note</span></a>';  
                if($data->Status == "Draft" || $data->Status == "Pending" || $data->Status == "Verified"){
                    if($user->can('Adjustment-Edit'))
                    {
                        $adjedit='<a class="dropdown-item adjEdit" onclick="adjEditFn('.$data->id.')" data-id="'.$data->id.'" id="editadjustment'.$data->id.'" title="Open adjustment edit page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                    }
                    if($user->can('Adjustment-Void'))
                    {
                        $voidlink = '<a class="dropdown-item voidadjustment" onclick="adjVoidFn('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" id="adjvoid'.$data->id.'" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    $println='';
                    $undovoidlink='';
                }
                if($data->Status=='Void' || $data->Status=='Void(Draft)' || $data->Status=='Void(Pending)' || $data->Status=='Void(Verified)'){
                    if($user->can('Adjustment-Void'))
                    {
                        $undovoidlink = '<a class="dropdown-item undovoidadjustment" onclick="adjUndoVoidFn('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" id="adjundovoid'.$data->id.'" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                    }
                    $adjedit='';
                    $voidlink='';
                }
                if($data->Status == "Approved"){
                    $adjedit='';
                    $voidlink='';
                    $undovoidlink='';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item adjInfo" onclick="adjInfoFn('.$data->id.')" data-id="'.$data->id.'" id="adjinfo'.$data->id.'" title="Open adjustment information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$adjedit.'
                        '.$voidlink.'
                        '.$undovoidlink.'
                        '.$println.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function cuscommadjlist($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $commlists=DB::select('SELECT adjustments.id,adjustments.DocumentNumber,adjustments.Type,prdlookups.ProductType,stores.Name AS StoreName,customers.Code,customers.Name AS CustomerName,customers.TinNumber,adjustments.AdjustedDate,adjustments.Status FROM adjustments LEFT JOIN lookups AS prdlookups ON adjustments.product_type=prdlookups.ProductTypeValue LEFT JOIN customers ON adjustments.customers_id=customers.id LEFT JOIN stores ON adjustments.StoreId=stores.id WHERE adjustments.customers_id>1 AND adjustments.fiscalyear='.$fy.' ORDER BY adjustments.id DESC');
        if(request()->ajax()) {
            return datatables()->of($commlists)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $adjedit='';
                $voidlink='';
                $undovoidlink='';
                $println='<a class="dropdown-item printAdjustmentAttachment" href="javascript:void(0)" id="adjustmentNote'.$data->id.'" data-id="'.$data->id.'" onclick="commAdjAttFn('.$data->id.')" title="Print Adjustment Note"><i class="fa fa-file"></i><span> Print Adjustment Note</span></a>';  
                if($data->Status == "Draft" || $data->Status == "Pending" || $data->Status == "Verified"){
                    if($user->can('Adjustment-Edit'))
                    {
                        $adjedit='<a class="dropdown-item adjEdit" onclick="adjEditFn('.$data->id.')" data-id="'.$data->id.'" id="editadjustment'.$data->id.'" title="Open adjustment edit page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                    }
                    if($user->can('Adjustment-Void'))
                    {
                        $voidlink = '<a class="dropdown-item voidadjustment" onclick="adjVoidFn('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" id="adjvoid'.$data->id.'" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    $println='';
                    $undovoidlink='';
                }
                if($data->Status=='Void' || $data->Status=='Void(Draft)' || $data->Status=='Void(Pending)' || $data->Status=='Void(Verified)'){
                    if($user->can('Adjustment-Void'))
                    {
                        $undovoidlink = '<a class="dropdown-item undovoidadjustment" onclick="adjUndoVoidFn('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" id="adjundovoid'.$data->id.'" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                    }
                    $adjedit='';
                    $voidlink='';
                }
                if($data->Status == "Approved"){
                    $adjedit='';
                    $voidlink='';
                    $undovoidlink='';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item adjInfo" onclick="adjInfoFn('.$data->id.')" data-id="'.$data->id.'" id="adjinfo'.$data->id.'" title="Open adjustment information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$adjedit.'
                        '.$voidlink.'
                        '.$undovoidlink.'
                        '.$println.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function storeadj(Request $request){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->adjustmentId;
        $customerid = $request->Customer ?? 0;
        $storeid = $request->sstore ?? 0;
        $companytype = $request->CompanyType ?? 0;
        $curdate = Carbon::today()->toDateString();
        $settings = DB::table('settings')->latest()->first();
        $fiscalyear = $settings->FiscalYear;
        $adjustment_doc_number = null;
        $current_doc_number = null;
        $total_before_tax = 0;
        $total_tax = 0;
        $total_after_tax = 0;

        if($customerid == 1){
            $adjprop = adjustment::where('customers_id',1)->where('fiscalyear',$fiscalyear)->latest()->first();
            $adjustment_doc_number = $settings->adjustment_owner_doc_prefix.sprintf("%06d",($adjprop->last_doc_number ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $current_doc_number = ($adjprop->last_doc_number ?? 0)+1;

            if($findid != null){
                $adj = adjustment::where('id',$findid)->where('fiscalyear',$fiscalyear)->latest()->first();
                if($adj->customers_id > 1){
                    $adjustmentdata = adjustment::where('customers_id',1)->where('fiscalyear',$fiscalyear)->latest()->first();
                    $adjustment_doc_number = $settings->adjustment_owner_doc_prefix.sprintf("%06d",($adjustmentdata->last_doc_number ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $current_doc_number = ($adjustmentdata->last_doc_number ?? 0)+1;
                }
                if($adj->customers_id == 1){
                    $adjustment_doc_number = $adj->DocumentNumber;
                    $current_doc_number = $adj->last_doc_number;
                }
            }
        }
        else if($customerid > 1){
            $adjprop = adjustment::where('customers_id','!=',1)->where('fiscalyear',$fiscalyear)->latest()->first();
            $adjustment_doc_number = $settings->adjustment_customer_doc_prefix.sprintf("%06d",($adjprop->last_doc_number ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $current_doc_number = ($adjprop->last_doc_number ?? 0)+1;

            if($findid != null){
                $adj = adjustment::where('id',$findid)->where('fiscalyear',$fiscalyear)->latest()->first();
                if($adj->customers_id == 1){
                    $adjustmentdata = adjustment::where('customers_id','!=',1)->where('fiscalyear',$fiscalyear)->latest()->first();
                    $adjustment_doc_number = $settings->adjustment_customer_doc_prefix.sprintf("%06d",($adjprop->last_doc_number ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $current_doc_number = ($adjprop->last_doc_number ?? 0)+1;
                }
                if($adj->customers_id > 1){
                    $adjustment_doc_number = $adj->DocumentNumber;
                    $current_doc_number = $adj->last_doc_number;
                }
            }
        }

        $validator = Validator::make($request->all(), [
            'ProductType' => ['required'],
            'CompanyType' => ['required'],
            'AdjustmentType' => ['required'],
            'Customer' => ['required_if:CompanyType,2'],
            'Store' => ['required'],
            'date' => ['required'],
        ]);

        $rules=array(
            'row.*.Reason' => 'required',
            'row.*.FloorMap' => 'required',
            'row.*.CommType' => 'required',
            'row.*.Origin' => 'required',
            'row.*.Grade' => 'required',
            'row.*.ProcessType' => 'required',
            'row.*.CropYear' => 'required',
            'row.*.Uom' => 'required',
            'row.*.NumOfBag' => 'nullable',
            'row.*.TotalKg' => 'required',
            'row.*.NetKg' => 'required|gt:0',
            'row.*.Feresula' => 'nullable',
            'row.*.UnitCost' => 'required_if:CompanyType,1',
            'row.*.TotalCost' => 'required_if:CompanyType,1'
        );
        $v2= Validator::make($request->all(), $rules);

        if($validator->passes() && $v2->passes() && $request->row != null){

            DB::beginTransaction();
            try
            {
                $BasicVal = [
                    'DocumentNumber' => $adjustment_doc_number,
                    'product_type' => $request->ProductType,
                    'company_type' => $request->CompanyType,
                    'Type' => $request->AdjustmentType,
                    'customers_id' => $request->Customer ?? 1,
                    'StoreId' => $request->Store,
                    'AdjustedDate' => $request->date,
                    'Memo' => $request->Purpose,
                    'fiscalyear' => $fiscalyear,
                    'last_doc_number' => $current_doc_number,
                ];

                $DbData = adjustment::where('id', $findid)->first();
                $CreatedBy = ['Status' => "Draft"];
                $LastUpdatedBy = ['updated_at' => Carbon::now()];
            
                $adjdata = adjustment::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                adjustmentdetail::where('adjustmentdetails.HeaderId',$adjdata->id)->delete();
                foreach ($request->row as $key => $value){
                    $adjdetail = new adjustmentdetail;
                    $adjdetail->HeaderId = $adjdata->id;
                    $adjdetail->Reason = $value['Reason'];
                    $adjdetail->LocationId = $value['FloorMap'];
                    $adjdetail->CommodityType = $value['CommType'];
                    $adjdetail->SupplierId = $value['Supplier'] ?? "N/A";
                    $adjdetail->GrnNumber = $value['GrnNumber'] ?? "N/A";
                    $adjdetail->ProductionNumber = $value['ProductionNum'] ?? "N/A";
                    $adjdetail->CertNumber = $value['CertificateNum'] ?? "N/A";
                    $adjdetail->woredas_id = $value['Origin'];
                    $adjdetail->Grade = $value['Grade'];
                    $adjdetail->ProcessType = $value['ProcessType'];
                    $adjdetail->CropYear = $value['CropYear'];
                    $adjdetail->Remark = $value['Remark'];
                    $adjdetail->uoms_id = $value['Uom'];
                    $adjdetail->NumOfBag = $value['NumOfBag'];
                    $adjdetail->BagWeight = $value['TotalBagWeight'];
                    $adjdetail->TotalKg = $value['TotalKg'];
                    $adjdetail->NetKg = $value['NetKg'];
                    $adjdetail->Feresula = $value['Feresula'];
                    $adjdetail->unit_cost_or_price = $value['UnitCost'];
                    $adjdetail->total_cost_or_price = $value['TotalCost'];
                    $adjdetail->VarianceShortage = $value['varianceshortage'];
                    $adjdetail->VarianceOverage = $value['varianceoverage'];
                    $adjdetail->save();

                    $total_before_tax += $value['TotalCost'] ?? 0;
                    $total_tax += round((($value['TotalCost'] ?? 0) * 0.15),2); 
                    $total_after_tax += round(((($value['TotalCost'] ?? 0) * 0.15)  + ($value['TotalCost'] ?? 0)),2); 
                }

                adjustment::where('id',$adjdata->id)->update(['TotalValue' => $total_before_tax]);

                $actions = $findid == null ? "Created" : "Edited";

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$adjdata->id,'pagename'=>"adjustment",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

                DB::commit();
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
        if($request->row == null)
        {
            return Response::json(['emptyerror'=>"error"]);
        }
    }

    public function showAdjData($id)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;

        $adjustmentdata = DB::select('SELECT adjustments.*,customers.Name AS CustomerName,prdlookups.ProductType,complookups.CompanyType,stores.Name AS StoreName,adjustments.AdjustedDate,adjustments.Status FROM adjustments LEFT JOIN lookups AS prdlookups ON adjustments.product_type=prdlookups.ProductTypeValue LEFT JOIN stores ON adjustments.StoreId=stores.id LEFT JOIN lookups AS complookups ON adjustments.company_type=complookups.CompanyTypeValue LEFT JOIN customers ON adjustments.customers_id=customers.id WHERE adjustments.id='.$id);

        $adjustmentdetaildata = DB::select('SELECT adjustments.Type AS AdjustmentType,cmlookups.CommodityType AS CommType,grlookups.Grade AS GradeName,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,adjustmentdetails.CommodityType AS CommTypeId,uoms.Name AS UomName,adjustmentdetails.*,prlookups.ProcessType,crlookups.CropYear AS CropYearData,IFNULL(adjustmentdetails.Memo,"") AS Memo,ROUND((adjustmentdetails.NetKg/1000),2) AS WeightByTon,uoms.Name AS UomName,locations.Name AS LocationName,customers.Name AS SupplierName,customers.Code AS SupplierCode,customers.TinNumber AS SupplierTIN,adjustmentdetails.ProductionNumber,IFNULL(adjustmentdetails.CertNumber,"") AS CertNumber,IFNULL(adjustmentdetails.CertNumber,"") AS CertNumber,VarianceShortage,VarianceOverage,adjustments.customers_id,uoms.uomamount,uoms.bagweight FROM adjustmentdetails LEFT JOIN woredas ON adjustmentdetails.woredas_id = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions on zones.Rgn_Id = regions.id LEFT JOIN uoms ON adjustmentdetails.uoms_id = uoms.id LEFT JOIN locations ON adjustmentdetails.LocationId=locations.id LEFT JOIN customers ON adjustmentdetails.SupplierId=customers.id LEFT JOIN lookups AS grlookups ON adjustmentdetails.Grade=grlookups.GradeValue LEFT JOIN lookups AS prlookups ON adjustmentdetails.ProcessType=prlookups.ProcessTypeValue LEFT JOIN lookups AS crlookups ON adjustmentdetails.CropYear=crlookups.CropYearValue LEFT JOIN lookups AS cmlookups ON adjustmentdetails.CommodityType=cmlookups.CommodityTypeValue LEFT JOIN adjustments ON adjustmentdetails.HeaderId=adjustments.id WHERE adjustmentdetails.HeaderId = '.$id.' ORDER BY adjustmentdetails.id ASC');

        $activitydata = actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"adjustment")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['adjustmentdata'=>$adjustmentdata,'adjustmentdetaildata'=>$adjustmentdetaildata,'activitydata'=>$activitydata]);       
    }

    public function showAdjDetailData($id)
    {
        $adjdata=DB::select('SELECT adjustments.Type AS AdjustmentType,cmlookups.CommodityType AS CommType,grlookups.Grade AS GradeName,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,adjustmentdetails.CommodityType AS CommTypeId,uoms.Name AS UomName,adjustmentdetails.*,prlookups.ProcessType,crlookups.CropYear AS CropYearData,IFNULL(adjustmentdetails.Memo,"") AS Memo,ROUND((adjustmentdetails.NetKg/1000),2) AS WeightByTon,uoms.Name AS UomName,locations.Name AS LocationName,customers.Name AS SupplierName,customers.Code AS SupplierCode,customers.TinNumber AS SupplierTIN,adjustmentdetails.ProductionNumber,IFNULL(adjustmentdetails.CertNumber,"") AS CertNumber,IFNULL(adjustmentdetails.CertNumber,"") AS CertNumber,VarianceShortage,VarianceOverage,adjustments.customers_id,uoms.uomamount,uoms.bagweight FROM adjustmentdetails LEFT JOIN woredas ON adjustmentdetails.woredas_id = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions on zones.Rgn_Id = regions.id LEFT JOIN uoms ON adjustmentdetails.uoms_id = uoms.id LEFT JOIN locations ON adjustmentdetails.LocationId=locations.id LEFT JOIN customers ON adjustmentdetails.SupplierId=customers.id LEFT JOIN lookups AS grlookups ON adjustmentdetails.Grade=grlookups.GradeValue LEFT JOIN lookups AS prlookups ON adjustmentdetails.ProcessType=prlookups.ProcessTypeValue LEFT JOIN lookups AS crlookups ON adjustmentdetails.CropYear=crlookups.CropYearValue LEFT JOIN lookups AS cmlookups ON adjustmentdetails.CommodityType=cmlookups.CommodityTypeValue LEFT JOIN adjustments ON adjustmentdetails.HeaderId=adjustments.id WHERE adjustmentdetails.HeaderId = '.$id.' ORDER BY adjustmentdetails.id DESC');
        return datatables()->of($adjdata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function calcAdjBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $baseRecordId=$_POST['baseRecordId']??0;
        $commtype=$_POST['commtype']; 
        $origin=$_POST['origin']; 
        $grade=$_POST['grade']; 
        $processtype=$_POST['processtype']; 
        $cropyear=$_POST['cropyear']; 
        $storeval=$_POST['storeval']; 
        $uom=$_POST['uom']; 
        $cusOrOwner=$_POST['cusOrOwner']; 
        $supplierid=$_POST['supplierid']; 
        $grnnumber=$_POST['grnnumber']; 
        $prdordernumber=$_POST['prdordernumber']; 
        $certnumber=$_POST['certnumber']; 
        $expcertnumber=$_POST['expcertnumber']; 
        $floormap=$_POST['floormap']; 
        $reqstatus=["Draft","Pending","Verified","Reviewed","Approved"];
        $prdstatus=["Pending","Ready","On-Production","Process-Finished","Verified"];
        $adjstatus=["Draft","Pending","Verified"];
        $uomfactor=0;
        $uombagweight=0;
        $feresula=0;

        $baseRecordId = !empty($baseRecordId) ? $baseRecordId : 0;
        $supplierid = !empty($supplierid) ? $supplierid : 0;
        $grnnumber = !empty($grnnumber) ? $grnnumber : 0;
        $prdordernumber = !empty($prdordernumber) ? $prdordernumber : 0;
        $certnumber = !empty($certnumber) ? $certnumber : 0;
        $expcertnumber = !empty($expcertnumber) ? $expcertnumber : 0;

        $uomprop = uom::where('id',$uom)->first();
        $uomfactor= $uomprop->uomamount ?? 0;
        $uombagweight= $uomprop->bagweight ?? 0;
        $uomname= $uomprop->Name ?? "";

        if($commtype==1){
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.LocationId='.$floormap.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.ItemType="Commodity" AND transactions.uomId='.$uom.' AND transactions.SupplierId='.$supplierid.' AND transactions.GrnNumber="'.$grnnumber.'" AND transactions.TransactionType!="On-Production" AND transactions.customers_id='.$cusOrOwner);
            
            $qtystockoutdata=adjustmentdetail::leftJoin('adjustments','adjustmentdetails.HeaderId','adjustments.id')
                                            ->where('adjustmentdetails.CommodityType',$commtype)
                                            ->where('adjustmentdetails.woredas_id',$origin)
                                            ->where('adjustmentdetails.Grade',$grade)
                                            ->where('adjustmentdetails.ProcessType',$processtype)
                                            ->where('adjustmentdetails.CropYear',$cropyear)
                                            ->where('adjustmentdetails.StoreId',$storeval)
                                            ->where('adjustmentdetails.LocationId',$floormap)
                                            ->where('adjustmentdetails.SupplierId',$supplierid)
                                            ->where('adjustmentdetails.GrnNumber',$grnnumber)
                                            ->where('adjustmentdetails.uoms_id',$uom)
                                            ->where('adjustmentdetails.HeaderId',$baseRecordId)
                                            ->where('adjustments.customers_id',$cusOrOwner)
                                            ->first();

            $qtyothstockoutdata=adjustmentdetail::leftJoin('adjustments','adjustmentdetails.HeaderId','adjustments.id')
                                            ->where('adjustmentdetails.CommodityType',$commtype)
                                            ->where('adjustmentdetails.woredas_id',$origin)
                                            ->where('adjustmentdetails.Grade',$grade)
                                            ->where('adjustmentdetails.ProcessType',$processtype)
                                            ->where('adjustmentdetails.CropYear',$cropyear)
                                            ->where('adjustmentdetails.StoreId',$storeval)
                                            ->where('adjustmentdetails.LocationId',$floormap)
                                            ->where('adjustmentdetails.SupplierId',$supplierid)
                                            ->where('adjustmentdetails.GrnNumber',$grnnumber)
                                            ->where('adjustmentdetails.uoms_id',$uom)
                                            ->where('adjustmentdetails.HeaderId','!=',$baseRecordId)
                                            ->where('adjustments.customers_id',$cusOrOwner)
                                            ->whereIn('adjustments.Status',$adjstatus)
                                            ->select(DB::raw('SUM(COALESCE(adjustmentdetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(adjustmentdetails.NetKg,0)) AS NetKg'))
                                            ->groupBy('adjustmentdetails.CommodityType','adjustmentdetails.woredas_id','adjustmentdetails.Grade','adjustmentdetails.ProcessType','adjustmentdetails.CropYear','adjustmentdetails.StoreId','adjustmentdetails.SupplierId','adjustmentdetails.GrnNumber','adjustmentdetails.uoms_id')
                                            ->get();

            $reqdata=requisitiondetail::leftJoin('requisitions','requisitiondetails.HeaderId','requisitions.id')
                                            ->where('requisitiondetails.CommodityType',$commtype)
                                            ->where('requisitiondetails.CommodityId',$origin)
                                            ->where('requisitiondetails.Grade',$grade)
                                            ->where('requisitiondetails.ProcessType',$processtype)
                                            ->where('requisitiondetails.CropYear',$cropyear)
                                            ->where('requisitiondetails.StoreId',$storeval)
                                            ->where('requisitiondetails.LocationId',$floormap)
                                            ->where('requisitiondetails.SupplierId',$supplierid)
                                            ->where('requisitiondetails.GrnNumber',$grnnumber)
                                            ->where('requisitiondetails.DefaultUOMId',$uom)
                                            ->where('requisitions.CustomerOrOwner',$cusOrOwner)
                                            ->whereIn('requisitions.Status',$reqstatus)
                                            ->select(DB::raw('SUM(COALESCE(requisitiondetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(requisitiondetails.NetKg,0)) AS NetKg'))
                                            ->groupBy('requisitiondetails.CommodityType','requisitiondetails.CommodityId','requisitiondetails.Grade','requisitiondetails.ProcessType','requisitiondetails.CropYear','requisitiondetails.StoreId','requisitiondetails.SupplierId','requisitiondetails.GrnNumber','requisitiondetails.DefaultUOMId')
                                            ->get();
            
            $prdstockoutdata=prd_order_detail::leftJoin('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
                                            ->where('prd_order_details.CommodityType',$commtype)
                                            ->where('prd_order_details.woredas_id',$origin)
                                            ->where('prd_order_details.Grade',$grade)
                                            ->where('prd_order_details.ProcessType',$processtype)
                                            ->where('prd_order_details.CropYear',$cropyear)
                                            ->where('prd_order_details.stores_id',$storeval)
                                            ->where('prd_order_details.LocationId',$floormap)
                                            ->where('prd_order_details.SupplierId',$supplierid)
                                            ->where('prd_order_details.GrnNumber',$grnnumber)
                                            ->where('prd_order_details.uoms_id',$uom)
                                            ->where('prd_orders.customers_id',$cusOrOwner)
                                            ->whereIn('prd_orders.Status',$prdstatus)
                                            ->select(DB::raw('SUM(COALESCE(prd_order_details.QuantityInKG,0)) AS NetKg'),DB::raw('SUM(COALESCE(prd_order_details.Quantity,0)) AS NumOfBag'))
                                            ->groupBy('prd_order_details.CommodityType','prd_order_details.woredas_id','prd_order_details.Grade','prd_order_details.ProcessType','prd_order_details.CropYear','prd_order_details.stores_id','prd_order_details.SupplierId','prd_order_details.GrnNumber','prd_order_details.uoms_id')
                                            ->get();

        }
        else if($commtype==2 || $commtype==4 || $commtype==5 || $commtype==6){
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.LocationId='.$floormap.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.ItemType="Commodity" AND transactions.uomId='.$uom.' AND transactions.ProductionNumber="'.$prdordernumber.'" AND transactions.CertNumber="'.$certnumber.'" AND transactions.TransactionType!="On-Production" AND transactions.customers_id='.$cusOrOwner);
            
            $qtystockoutdata=adjustmentdetail::leftJoin('adjustments','adjustmentdetails.HeaderId','adjustments.id')
                                            ->where('adjustmentdetails.CommodityType',$commtype)
                                            ->where('adjustmentdetails.woredas_id',$origin)
                                            ->where('adjustmentdetails.Grade',$grade)
                                            ->where('adjustmentdetails.ProcessType',$processtype)
                                            ->where('adjustmentdetails.CropYear',$cropyear)
                                            ->where('adjustmentdetails.StoreId',$storeval)
                                            ->where('adjustmentdetails.LocationId',$floormap)
                                            ->where('adjustmentdetails.ProductionNumber',$prdordernumber)
                                            ->where('adjustmentdetails.CertNumber',$certnumber)
                                            ->where('adjustmentdetails.uoms_id',$uom)
                                            ->where('adjustmentdetails.HeaderId',$baseRecordId)
                                            ->where('adjustments.customers_id',$cusOrOwner)
                                            ->first();

            $qtyothstockoutdata=adjustmentdetail::leftJoin('adjustments','adjustmentdetails.HeaderId','adjustments.id')
                                            ->where('adjustmentdetails.CommodityType',$commtype)
                                            ->where('adjustmentdetails.woredas_id',$origin)
                                            ->where('adjustmentdetails.Grade',$grade)
                                            ->where('adjustmentdetails.ProcessType',$processtype)
                                            ->where('adjustmentdetails.CropYear',$cropyear)
                                            ->where('adjustmentdetails.StoreId',$storeval)
                                            ->where('adjustmentdetails.LocationId',$floormap)
                                            ->where('adjustmentdetails.ProductionNumber',$prdordernumber)
                                            ->where('adjustmentdetails.CertNumber',$certnumber)
                                            ->where('adjustmentdetails.uoms_id',$uom)
                                            ->where('adjustmentdetails.HeaderId','!=',$baseRecordId)
                                            ->where('adjustments.customers_id',$cusOrOwner)
                                            ->whereIn('adjustments.Status',$adjstatus)
                                            ->select(DB::raw('SUM(COALESCE(adjustmentdetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(adjustmentdetails.NetKg,0)) AS NetKg'))
                                            ->groupBy('adjustmentdetails.CommodityType','adjustmentdetails.woredas_id','adjustmentdetails.Grade','adjustmentdetails.ProcessType','adjustmentdetails.CropYear','adjustmentdetails.StoreId','adjustmentdetails.ProductionNumber','adjustmentdetails.CertNumber','adjustmentdetails.uoms_id')
                                            ->get();

            $reqdata=requisitiondetail::leftJoin('requisitions','requisitiondetails.HeaderId','requisitions.id')
                                            ->where('requisitiondetails.CommodityType',$commtype)
                                            ->where('requisitiondetails.CommodityId',$origin)
                                            ->where('requisitiondetails.Grade',$grade)
                                            ->where('requisitiondetails.ProcessType',$processtype)
                                            ->where('requisitiondetails.CropYear',$cropyear)
                                            ->where('requisitiondetails.StoreId',$storeval)
                                            ->where('requisitiondetails.LocationId',$floormap)
                                            ->where('requisitiondetails.ProductionOrderNo',$prdordernumber)
                                            ->where('requisitiondetails.CertNumber',$certnumber)
                                            ->where('requisitiondetails.DefaultUOMId',$uom)
                                            ->where('requisitions.CustomerOrOwner',$cusOrOwner)
                                            ->whereIn('requisitions.Status',$reqstatus)
                                            ->select(DB::raw('SUM(COALESCE(requisitiondetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(requisitiondetails.NetKg,0)) AS NetKg'))
                                            ->groupBy('requisitiondetails.CommodityType','requisitiondetails.CommodityId','requisitiondetails.Grade','requisitiondetails.ProcessType','requisitiondetails.CropYear','requisitiondetails.StoreId','requisitiondetails.ProductionOrderNo','requisitiondetails.CertNumber','requisitiondetails.DefaultUOMId')
                                            ->get();

            $prdstockoutdata=prd_order_detail::leftJoin('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
                                            ->where('prd_order_details.CommodityType',$commtype)
                                            ->where('prd_order_details.woredas_id',$origin)
                                            ->where('prd_order_details.Grade',$grade)
                                            ->where('prd_order_details.ProcessType',$processtype)
                                            ->where('prd_order_details.CropYear',$cropyear)
                                            ->where('prd_order_details.stores_id',$storeval)
                                            ->where('prd_order_details.LocationId',$floormap)
                                            ->where('prd_order_details.ProductionNumber',$prdordernumber)
                                            ->where('prd_order_details.CertNumber',$certnumber)
                                            ->where('prd_order_details.uoms_id',$uom)
                                            ->where('prd_orders.customers_id',$cusOrOwner)
                                            ->whereIn('prd_orders.Status',$prdstatus)
                                            ->select(DB::raw('SUM(COALESCE(prd_order_details.QuantityInKG,0)) AS NetKg'),DB::raw('SUM(COALESCE(prd_order_details.Quantity,0)) AS NumOfBag'))
                                            ->groupBy('prd_order_details.CommodityType','prd_order_details.woredas_id','prd_order_details.Grade','prd_order_details.ProcessType','prd_order_details.CropYear','prd_order_details.stores_id','prd_order_details.ProductionNumber','prd_order_details.CertNumber','prd_order_details.uoms_id')
                                            ->get();
        }
        else if($commtype==3){  // this add by new logic
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.LocationId='.$floormap.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.ItemType="Commodity" AND transactions.uomId='.$uom.' AND transactions.TransactionType!="On-Production" AND transactions.customers_id='.$cusOrOwner);
            
            $qtystockoutdata=adjustmentdetail::leftJoin('adjustments','adjustmentdetails.HeaderId','adjustments.id')
                                            ->where('adjustmentdetails.CommodityType',$commtype)
                                            ->where('adjustmentdetails.woredas_id',$origin)
                                            ->where('adjustmentdetails.Grade',$grade)
                                            ->where('adjustmentdetails.ProcessType',$processtype)
                                            ->where('adjustmentdetails.CropYear',$cropyear)
                                            ->where('adjustmentdetails.StoreId',$storeval)
                                            ->where('adjustmentdetails.LocationId',$floormap)
                                            ->where('adjustmentdetails.uoms_id',$uom)
                                            ->where('adjustmentdetails.HeaderId',$baseRecordId)
                                            ->where('adjustments.customers_id',$cusOrOwner)
                                            ->first();

            $qtyothstockoutdata=adjustmentdetail::leftJoin('adjustments','adjustmentdetails.HeaderId','adjustments.id')
                                            ->where('adjustmentdetails.CommodityType',$commtype)
                                            ->where('adjustmentdetails.woredas_id',$origin)
                                            ->where('adjustmentdetails.Grade',$grade)
                                            ->where('adjustmentdetails.ProcessType',$processtype)
                                            ->where('adjustmentdetails.CropYear',$cropyear)
                                            ->where('adjustmentdetails.StoreId',$storeval)
                                            ->where('adjustmentdetails.LocationId',$floormap)
                                            ->where('adjustmentdetails.uoms_id',$uom)
                                            ->where('adjustmentdetails.HeaderId','!=',$baseRecordId)
                                            ->where('adjustments.customers_id',$cusOrOwner)
                                            ->whereIn('adjustments.Status',$adjstatus)
                                            ->select(DB::raw('SUM(COALESCE(adjustmentdetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(adjustmentdetails.NetKg,0)) AS NetKg'))
                                            ->groupBy('adjustmentdetails.CommodityType','adjustmentdetails.woredas_id','adjustmentdetails.Grade','adjustmentdetails.ProcessType','adjustmentdetails.CropYear','adjustmentdetails.StoreId','adjustmentdetails.uoms_id')
                                            ->get();

            $reqdata=requisitiondetail::leftJoin('requisitions','requisitiondetails.HeaderId','requisitions.id')
                                            ->where('requisitiondetails.CommodityType',$commtype)
                                            ->where('requisitiondetails.CommodityId',$origin)
                                            ->where('requisitiondetails.Grade',$grade)
                                            ->where('requisitiondetails.ProcessType',$processtype)
                                            ->where('requisitiondetails.CropYear',$cropyear)
                                            ->where('requisitiondetails.StoreId',$storeval)
                                            ->where('requisitiondetails.LocationId',$floormap)
                                            ->where('requisitiondetails.DefaultUOMId',$uom)
                                            ->where('requisitions.CustomerOrOwner',$cusOrOwner)
                                            ->whereIn('requisitions.Status',$reqstatus)
                                            ->select(DB::raw('SUM(COALESCE(requisitiondetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(requisitiondetails.NetKg,0)) AS NetKg'))
                                            ->groupBy('requisitiondetails.CommodityType','requisitiondetails.CommodityId','requisitiondetails.Grade','requisitiondetails.ProcessType','requisitiondetails.CropYear','requisitiondetails.StoreId','requisitiondetails.DefaultUOMId')
                                            ->get();

            $prdstockoutdata=prd_order_detail::leftJoin('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
                                            ->where('prd_order_details.CommodityType',$commtype)
                                            ->where('prd_order_details.woredas_id',$origin)
                                            ->where('prd_order_details.Grade',$grade)
                                            ->where('prd_order_details.ProcessType',$processtype)
                                            ->where('prd_order_details.CropYear',$cropyear)
                                            ->where('prd_order_details.stores_id',$storeval)
                                            ->where('prd_order_details.LocationId',$floormap)
                                            ->where('prd_order_details.uoms_id',$uom)
                                            ->where('prd_orders.customers_id',$cusOrOwner)
                                            ->whereIn('prd_orders.Status',$prdstatus)
                                            ->select(DB::raw('SUM(COALESCE(prd_order_details.QuantityInKG,0)) AS NetKg'),DB::raw('SUM(COALESCE(prd_order_details.Quantity,0)) AS NumOfBag'))
                                            ->groupBy('prd_order_details.CommodityType','prd_order_details.woredas_id','prd_order_details.Grade','prd_order_details.ProcessType','prd_order_details.CropYear','prd_order_details.stores_id','prd_order_details.ProductionNumber','prd_order_details.CertNumber','prd_order_details.uoms_id')
                                            ->get();
        }

        //$averagecost=DB::select('SELECT ROUND((SUM(COALESCE(transactions.TotalCostComm,0)) / SUM(COALESCE(transactions.StockInComm,0))),2) AS AverageCost FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.TransactionsType IN("Beginning","Receiving","Adjustment","Production","Undo-Abort","Undo-Void") AND transactions.ItemType="Commodity" AND transactions.customers_id='.$cusOrOwner);
        //$avcost=$averagecost[0]->AverageCost ?? 0;

        $avcost = $this->calculateAverageCost($commtype,$origin,$grade,$processtype,$cropyear,$fyear,$cusOrOwner);
        
        $avbalancekg=$qtyonhandata[0]->AvailableBalanceKg ?? 0;
        $avbalancebag=$qtyonhandata[0]->AvailableBalanceBag ?? 0;

        $avothbalancekg=$qtyothstockoutdata[0]->NetKg ?? 0;
        $avothbalancebag=$qtyothstockoutdata[0]->NumOfBag ?? 0;

        $prdbalancekg = ($prdstockoutdata[0]->NetKg ?? 0) + ($reqdata[0]->NetKg ?? 0);
        $prdnumofbag = ($prdstockoutdata[0]->NumOfBag ?? 0) + ($reqdata[0]->NumOfBag ?? 0);

        $avbalanceother=round(($avbalancekg/$uomfactor),2);
        $feresula=round(($avbalancekg/17),2);

        $stockoutkg=$qtystockoutdata->NetKg ?? 0;
        $stockoutbag=$qtystockoutdata->NumOfBag ?? 0;

        $stockoutother=round(($stockoutkg/$uomfactor),2);

        return response()->json(['avbalancekg'=>$avbalancekg,'avbalancebag'=>$avbalancebag,'avothbalancekg'=>$avothbalancekg,'avothbalancebag'=>$avothbalancebag,'prdbalancekg'=>$prdbalancekg,'prdnumofbag'=>$prdnumofbag,'feresula'=>$feresula,'uomname'=>$uomname,'avbalanceother'=>$avbalanceother,'stockoutkg'=>$stockoutkg,'stockoutbag'=>$stockoutbag,'stockoutother'=>$stockoutother,'uomfactor'=>$uomfactor,'bagweight'=>$uombagweight,'avcost'=>$avcost]); 
    }

    public function calculateAverageCost($comm_type,$comm_id,$grade,$process_type,$crop_year,$fiscal_year,$customer_id){
        $item_type = "Commodity";
        $transaction_type = ["Beginning","Receiving","Adjustment","Production","Requisition","Undo-Abort","Undo-Void"];
        $runningQty = 0;
        $runningCost = 0;
        $averageCost = 0;

        $transactions = DB::table('transactions')
        ->where('transactions.CommodityType',$comm_type)
        ->where('transactions.woredaId',$comm_id)
        ->where('transactions.Grade',$grade)
        ->where('transactions.ProcessType',$process_type)
        ->where('transactions.CropYear',$crop_year)
        ->where('transactions.FiscalYear',$fiscal_year)
        ->where('transactions.customers_id',$customer_id)
        ->where('transactions.ItemType',$item_type)
        ->whereIn('transactions.TransactionsType',$transaction_type)
        ->orderBy('id')
        ->get();

        foreach ($transactions as $row) {
            if ($row->StockInComm > 0) {
                $runningQty += $row->StockInComm;
                $runningCost += $row->TotalCostComm;
            }
            else if ($row->StockOutComm > 0) {
                $deductQty = $row->StockOutComm;

                $deductQty = min($deductQty, $runningQty);

                $runningQty -= $deductQty;
                $runningCost -= ($averageCost * $deductQty);
            }
            $averageCost = $runningQty > 0 ? $runningCost / $runningQty : 0;
        }
       
        return round($averageCost, 2);
    }

    public function voidCommAdj(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid = $request->adjvoidid;
        $adjprop = adjustment::find($findid);
        $validator = Validator::make($request->all(), [
            'Reason' =>'required',
        ]);
        if($validator->passes())
        {
            DB::beginTransaction();
            try{
                $oldStatus = $adjprop->Status;
                $adjprop->Status = "Void({$adjprop->Status})";
                $adjprop->StatusOld = $oldStatus;
                $adjprop->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"adjustment",'action'=>"Void",'status'=>"Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Reason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

                DB::commit();
                return Response::json(['success' => 1]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function undoVoidCommAdj(Request $request)
    {
        DB::beginTransaction();
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;
            $findid = $request->undovoidid;
            $adjprop = adjustment::find($findid);
            $adjprop->Status = $adjprop->StatusOld;
            $adjprop->save();

            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"adjustment",'action'=>"Undo Void",'status'=>"Undo Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function adjForwardAction(Request $request)
    {
        $approvedCount = 0;

        DB::beginTransaction();
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;

            $findid=$request->forwardReqId;
            $adjprop = adjustment::find($findid);
            $currentStatus = $adjprop->Status;
            $newStatus=$request->newForwardStatusValue;
            $action=$request->forwardActionValue;

            if($newStatus == "Approved"){
                $adjustment_detail = DB::select('SELECT * FROM adjustmentdetails WHERE adjustmentdetails.HeaderId='.$findid);       
                foreach($adjustment_detail as $row){
                    $trn_data = new transaction;
                    $trn_data->HeaderId = $findid;
                    $trn_data->woredaId = $row->woredas_id;
                    $trn_data->uomId = $row->uoms_id;
                    $trn_data->CommodityType = $row->CommodityType;
                    $trn_data->Grade = $row->Grade;
                    $trn_data->ProcessType = $row->ProcessType;
                    $trn_data->CropYear = $row->CropYear;

                    $trn_data->FiscalYear = $adjprop->fiscalyear;
                    $trn_data->Memo = "";
                    $trn_data->StoreId = $adjprop->StoreId;
                    $trn_data->TransactionType = "Adjustment";
                    $trn_data->TransactionsType = "Adjustment";
                    $trn_data->Date = Carbon::today()->toDateString();
                    $trn_data->LocationId = $row->LocationId;
                    $trn_data->ArrivalDate = Carbon::today()->toDateString();
                    $trn_data->SupplierId = $row->SupplierId;
                    $trn_data->GrnNumber = $row->GrnNumber;
                    $trn_data->CertNumber = $row->CertNumber;
                    $trn_data->ProductionNumber = $row->ProductionNumber;
                    
                    $trn_data->DocumentNumber = $adjprop->DocumentNumber;
                    $trn_data->VarianceShortage = $row->VarianceShortage;
                    $trn_data->VarianceOverage = $row->VarianceOverage;
                    $trn_data->ItemType = "Commodity";

                    if($adjprop->Type == "Increase"){
                        $trn_data->StockInNumOfBag = $row->NumOfBag;
                        $trn_data->StockInComm = $row->NetKg;
                        $trn_data->StockInFeresula = $row->Feresula;
                        $trn_data->BagWeight = $row->BagWeight;
                        $trn_data->TotalKg = $row->TotalKg;
                        $trn_data->UnitCostComm = $row->unit_cost_or_price;
                        $trn_data->TotalCostComm = $row->total_cost_or_price;
                        $trn_data->TaxCostComm = round(($row->total_cost_or_price * 0.15),2); 
                        $trn_data->GrandTotalCostComm = round((($row->total_cost_or_price * 0.15) + $row->total_cost_or_price),2); 
                    }
                    if($adjprop->Type == "Decrease"){
                        $trn_data->StockOutNumOfBag = $row->NumOfBag;
                        $trn_data->StockOutComm = $row->NetKg;
                        $trn_data->StockOutFeresula = $row->Feresula;
                        $trn_data->UnitPriceComm = $row->unit_cost_or_price;
                        $trn_data->TotalPriceComm = $row->total_cost_or_price;
                        $trn_data->TaxPriceComm = round(($row->total_cost_or_price * 0.15),2); 
                        $trn_data->GrandTotalPriceComm = round((($row->total_cost_or_price * 0.15) + $row->total_cost_or_price),2); 
                    }
                    $trn_data->save();
                }
            }

            $adjprop->Status=$newStatus;
            $adjprop->save();

            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"adjustment",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            
            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function adjBackwardAction(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backwardReqId;
        $action=$request->backwardActionValue;
        $newStatus=$request->newBackwardStatusValue;
        $adjprop = adjustment::find($findid);
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();

            try{
                $adjprop->Status=$newStatus;
                $adjprop->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"adjustment",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->CommentOrReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
                DB::commit();
                return Response::json(['success' => '1']);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }  
        }

        if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    //--------------End Commodity--------------------------

    public function showAdjustmentData()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $req=DB::select('SELECT adjustments.id,adjustments.DocumentNumber,adjustments.Type,stores.Name as Store,adjustments.AdjustedDate,fiscalyear.Monthrange as FiscalYear,adjustments.AdjustedBy,adjustments.Reason,adjustments.created_at,adjustments.StatusOld,if(adjustments.Status="Void",concat(adjustments.Status,"(",adjustments.StatusOld,")"),adjustments.Status) AS Status FROM adjustments INNER JOIN stores ON adjustments.StoreId=stores.id INNER JOIN fiscalyear ON adjustments.fiscalyear=fiscalyear.FiscalYear WHERE adjustments.fiscalyear='.$fyear.' AND adjustments.StoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=10) ORDER BY adjustments.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editln='';
                $voidlink='';
                $unvoidvlink='';
                if($data->Status=='Void'||$data->Status=='Void(Pending)'||$data->Status=='Void(Checked)'||$data->Status=='Void(Confirmed)')
                {
                    if($user->can('Adjustment-Void'))
                    {
                        $unvoidvlink= '<a class="dropdown-item undovoidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->StatusOld.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                    }
                    $voidlink='';
                    $editln='';
                }
                else if($data->Status=='Confirmed')
                {
                    if($user->can('Edit-Confirmed-Adjustment-Document'))
                    {
                        $editln=' <a class="dropdown-item editAdjHeader" onclick="editadjustmentdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-store="'.$data->Store.'" data-fyear="'.$data->FiscalYear.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Adjustment-Confirm') && $user->can('Adjustment-Void'))
                    {
                        //$voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                        $voidlink='';
                    } 
                }
                else if($data->Status=='Checked')
                {
                    if($user->can('Adjustment-Check') && $user->can('Adjustment-Edit'))
                    {
                        $editln=' <a class="dropdown-item editAdjHeader" onclick="editadjustmentdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-store="'.$data->Store.'" data-fyear="'.$data->FiscalYear.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    if($user->can('Adjustment-Check') && $user->can('Adjustment-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }   
                }
                else if($data->Status=='Pending')
                {
                    if($user->can('Adjustment-Edit'))
                    {
                        $editln=' <a class="dropdown-item editAdjHeader" onclick="editadjustmentdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-store="'.$data->Store.'" data-fyear="'.$data->FiscalYear.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Adjustment-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }
                }
                else if($data->Status!='Void'||$data->Status!='Void(Pending)'||$data->Status!='Void(Checked)'||$data->Status!='Void(Confirmed)')
                {
                    if($user->can('Adjustment-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }    
                }
                else if($data->Status=='Confirmed')
                {
                    if($user->can('Edit-Confirmed-Adjustment-Document'))
                    {
                        $editln=' <a class="dropdown-item editAdjHeader" onclick="editadjustmentdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-store="'.$data->Store.'" data-fyear="'.$data->FiscalYear.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Adjustment-Confirm') && $user->can('Adjustment-Void'))
                    {
                        //$voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                        $voidlink='';
                    } 
                }
                $btn='<div class="btn-group">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item DocAdjInfo" onclick="DocAdjInfo('.$data->id.')" data-id="'.$data->id.'" data-fy="'.$data->FiscalYear.'" data-toggle="modal" id="mediumButton" title="Show Detail Info"> 
                    <i class="fa fa-info"></i><span> Info</span>
                    </a>
                   '.$editln.'
                   '.$voidlink.'
                   '.$unvoidvlink.'
                    <a class="dropdown-item printAdjAttachment" href="javascript:void(0)" data-link="/adj/'.$data->id.'" id="printAdjV" data-attr="" title="Print Adjustment Voucher Attachment">
                        <i class="fa fa-file"></i><span> Print Adj. Voucher</span>
                    </a>
                    </div>
                 </div>';      
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showAdjDataHeaderCon($id)
    {
        $ids=$id;
        $adjdata = adjustment::find($id);
        $createddateval=$adjdata->created_at;

        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $adjHeader=DB::select('SELECT adjustments.id,adjustments.DocumentNumber,adjustments.Type,stores.Name as Store,fiscalyear.Monthrange as FiscalYear,adjustments.AdjustedBy,adjustments.AdjustedDate,adjustments.Reason,adjustments.Memo,"'.$datetime.'" AS created_at,adjustments.Status,adjustments.StatusOld,adjustments.CheckedBy,adjustments.CheckedDate,adjustments.ConfirmedBy,adjustments.ConfirmedDate,adjustments.ChangetoPendingBy,adjustments.ChangetoPendingDate,adjustments.VoidBy,adjustments.VoidDate,adjustments.VoidReason,adjustments.UndoVoidBy,adjustments.UndoVoidDate,adjustments.EditConfirmedBy,adjustments.EditConfirmedDate,FORMAT(adjustments.TotalValue,2) AS TotalValue FROM adjustments INNER JOIN stores as stores ON adjustments.StoreId=stores.id INNER JOIN fiscalyear ON adjustments.fiscalyear=fiscalyear.FiscalYear where adjustments.id='.$id);
        return response()->json(['adjHeader'=>$adjHeader]);       
    }

    public function store(Request $request)
    {
        $fiscalyears=null;
        $fiscalyrcomp=null;
        $fiscalyrstr=null;
        $hiddenstr=$request->hiddenstr;
        $storeid=$request->Store;
        $editdiffstr=0;
        $aprefix=null;
        $anumber=null;
        if($storeid!=null){
            $strdata=store::findorFail($storeid);
            $fiscalyears=$strdata->FiscalYear;
        }

        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $fiscalyrcomp=$settings->FiscalYear;

        if($storeid!=null && $fyear==$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $aprefix=$settings->AdjustmentPrefix;
            $anumber=$settings->AdjustmentNumber;
            $fyear=$settings->FiscalYear;
        }

        if($storeid!=null && $fyear!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $adjprop = DB::table('adjustments')->where('fiscalyear',$fiscalyears)->orderBy('id', 'desc')->first();
            $docdata=$adjprop->DocumentNumber;
            $aprefix = preg_replace('/[^a-zA-Z]/m','',$docdata);
            $numbersfor = preg_replace('/\D/', '', $docdata);
            $numbersfor = substr($numbersfor, 0, 5);
            $anumber=$numbersfor+1;
            $fyear=$fiscalyears;
        }
        
        $suffixdoc=$fyear-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $anumber);
        $adjNumber=$aprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->adjustmentId;
        $findid=$request->adjustmentId;
        $serids=$request->allserialNumIds;
        $type=$request->Type;
        
        $thisdate = Carbon::today()->toDateString();
        $rectransactiontype="Adjustment";
        $statusvalues=['Adjustment','Undo-Void'];
        $cval="0";
        $upval="0";
        $sern="";
        $comnvals="";
        $adjtype="";
        $unavitems="";
        $upunavitems="";
        $unavailableitems=[];
        $upunavailableitems=[];
        $serialnums=[];
        $insids=[];
        $detailids=[];
        $fiscalyearval="";
        $stockindbval=0;
        $stockoutdbval=0;
        $singleqnt="";
        $singlenonqnt="";
        $tempval=[];
        $tempvalqnt=[];
        $tempcnt=0;
        $tempcntitemid=[];
        $tempnoncnt=0;
        $tempnoncntitemid=[];
        $unavtempitems="";
        $unavnontempitems="";
        $tempvalqc=[];
        $singleqntqc="";
        $unavailableitemsqc=[];
        $cvalqc="0";
        $tempcntqc="0";
        $upunavitemsqc="";
        $unavtempitemsqc="";
        $tempvalqcun=[];
        $singleqntqcun="";
        $unavailableitemsqcun=[];
        $cvalqcun="0";
        $tempcntqcun="0";
        $upunavitemsqcun="";
        $unavtempitemsqcun="";
        $unavtempitemsqc="";
        $tempcntitemidqc=[];
        $tempcntitemidqcun=[];
        if($findid!=null)
        {
            if($hiddenstr!=null){//check the old and new store fiscal year
                $strdatahid=store::findorFail($hiddenstr);
                $fiscalyrstr=$strdatahid->FiscalYear;
                if($fiscalyrstr!=$fiscalyears){
                    $editdiffstr=1;
                }
            } 

            if($request->row==null){
                return Response::json(['emptyerror'=>"error"]);
            }
            else{
                $itemidlists=adjustmentdetail::where('HeaderId',$request->adjustmentId)->get(['ItemId']);
                foreach ($itemidlists as $itemidlists) {
                    $insids[] = $itemidlists->ItemId;
                }
                $recstatus=adjustment::where('id', $request->adjustmentId)->get(['Status','DocumentNumber','ConfirmedDate','fiscalyear','StoreId','Type']);
                foreach ($recstatus as $recstatus) {
                    $statusval = $recstatus->Status;
                    $documentnumbers = $recstatus->DocumentNumber;
                    $confirmdates = $recstatus->ConfirmedDate;
                    $fiscalyearval = $recstatus->fiscalyear;
                    $hiddenstr = $recstatus->StoreId;
                    $adjtype = $recstatus->Type;
                }
                if($statusval=="Confirmed"){
                    $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS adjtemp'.$userid.''));
                    $dropTableqc=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS adjtempqc'.$userid.''));
                    //Create a temp table to store a specific item transactios to check whether item is available or not
                    $creatingtemptables =DB::statement('CREATE TEMPORARY TABLE adjtemp'.$userid.' SELECT transactions.id,transactions.HeaderId,transactions.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,transactions.StoreId,uoms.Name AS UOM,transactions.StockIn,transactions.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY transactions.ItemId,transactions.StoreId ORDER BY transactions.id ASC)) AS AvailableQuantity,transactions.TransactionsType,transactions.FiscalYear FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE transactions.ItemId IN(SELECT adjustmentdetails.ItemId FROM adjustmentdetails WHERE adjustmentdetails.HeaderId='.$request->adjustmentId.') AND transactions.FiscalYear='.$fiscalyearval.'');
                    $creatingtemptablesqc =DB::statement('CREATE TEMPORARY TABLE adjtempqc'.$userid.' SELECT transactions.id,transactions.HeaderId,transactions.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,transactions.StoreId,uoms.Name AS UOM,transactions.StockIn,transactions.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY transactions.ItemId,transactions.StoreId ORDER BY transactions.id ASC)) AS AvailableQuantity,transactions.TransactionsType,transactions.FiscalYear FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE transactions.ItemId IN(SELECT adjustmentdetails.ItemId FROM adjustmentdetails WHERE adjustmentdetails.HeaderId='.$request->adjustmentId.') AND transactions.FiscalYear='.$fiscalyearval.'');
                    foreach ($request->row as $key => $value){
                        $totalavailable="0";
                        $updatevalue="0";
                        $totalresult="0";
                        $totalresval="0";
                        $stinvalint="0";
                        $stoutvalint="0";
                        $itemids=$value['ItemId'];
                        $dynamictblitem[]=$value['ItemId'];
                        $newquantity=$value['StockIn']+ $value['StockOut'];
                        $stinval=$value['StockIn'];
                        $stoutval=$value['StockOut'];
                        $storeids=$value['StoreId'];
                        if($stinval==null){
                            $stinvalint="0";
                        }
                        else if($stinval!=null){
                            $stinvalint=$stinval;
                        }
                        if($stoutval==null){
                            $stoutvalint="0";
                        }
                        else if($stoutval!=null){
                            $stoutvalint=$stoutval;
                        }
                        // $getavailableqnt=DB::select('SELECT COALESCE(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)),0) AS TotalBalance FROM transactions WHERE transactions.ItemId='.$itemids.' AND transactions.StoreId='.$hiddenstr.' AND transactions.FiscalYear='.$fiscalyearval.'');
                        // foreach($getavailableqnt as $row)
                        // {
                        //     $totalavailable=$row->TotalBalance;
                        // }
                        // $getadjustmentdetails=adjustmentdetail::where('HeaderId', $request->adjustmentId)->where('ItemId',$itemids)->get(['StockIn','StockOut']);
                        // foreach ($getadjustmentdetails as $getadjustmentdetails) {
                        //     $stockindbval = $getadjustmentdetails->StockIn;
                        //     $stockoutdbval = $getadjustmentdetails->StockOut;
                        //     $updatevalue=$stockindbval+$stockoutdbval;//both shouldnt have a values 
                        // }
                        // $totalresult=$totalavailable-$updatevalue;
                        // if($hiddenstr!=$storeids){
                        //     $totalresval=$totalresult+0;
                        // }
                        // if($hiddenstr==$storeids){
                        //     $totalresval=$totalresult+$newquantity;
                        // }
                        // $totalresvals=(float)$totalresval;
                        // if($totalresvals<0){
                        //     $unavailableitems[]=$itemids;
                        //     $cval+=1;
                        // }
                        if($hiddenstr!=$request->Store){
                            $stinvalint="0";
                        }
                        if($type=="Quantity"){
                            $updatestockingquantity=DB::select('update adjtemp'.$userid.' set StockOut='.$stoutvalint.',StockIn=0,StoreId='.$request->Store.' where HeaderId='.$request->adjustmentId.' AND TransactionsType="Adjustment" AND ItemId='.$itemids.'');
                            $gettemptable=DB::select('SELECT adjtemp'.$userid.'.id,adjtemp'.$userid.'.HeaderId,adjtemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,adjtemp'.$userid.'.StoreId,uoms.Name AS UOM,adjtemp'.$userid.'.StockIn,adjtemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY adjtemp'.$userid.'.ItemId,adjtemp'.$userid.'.StoreId ORDER BY adjtemp'.$userid.'.id ASC)) AS AvailableQuantity,adjtemp'.$userid.'.TransactionsType FROM adjtemp'.$userid.' INNER JOIN regitems ON adjtemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON adjtemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE adjtemp'.$userid.'.ItemId='.$itemids.' AND adjtemp'.$userid.'.FiscalYear='.$fiscalyearval.' AND adjtemp'.$userid.'.StoreId='.$request->Store.'');
                            foreach($gettemptable as $row)
                            {
                                $tempvalqnt[]=$row->AvailableQuantity;
                                $singleqnt=$row->AvailableQuantity;
                                if($singleqnt<0){
                                    $tempcntitemid[]=$row->ItemId;
                                    $tempcnt+=1;
                                }
                            }
                            if($singleqnt<0){
                                $unavailableitems[]=$itemids;
                                $cval+=1;
                            }
                            if($adjtype=="Quantity&Cost"){//Check if it is Quantity&Cost before 
                                $updatestockingquantityqc=DB::select('update adjtempqc'.$userid.' set StockIn='.$stinvalint.',StockOut=0 where HeaderId='.$request->adjustmentId.' AND TransactionsType="Adjustment" AND ItemId='.$itemids.' AND StoreId='.$hiddenstr.'');
                                $gettemptableqc=DB::select('SELECT adjtempqc'.$userid.'.id,adjtempqc'.$userid.'.HeaderId,adjtempqc'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,adjtempqc'.$userid.'.StoreId,uoms.Name AS UOM,adjtempqc'.$userid.'.StockIn,adjtempqc'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY adjtempqc'.$userid.'.ItemId,adjtempqc'.$userid.'.StoreId ORDER BY adjtempqc'.$userid.'.id ASC)) AS AvailableQuantity,adjtempqc'.$userid.'.TransactionsType FROM adjtempqc'.$userid.' INNER JOIN regitems ON adjtempqc'.$userid.'.ItemId=regitems.id INNER JOIN stores ON adjtempqc'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE adjtempqc'.$userid.'.ItemId='.$itemids.' AND adjtempqc'.$userid.'.FiscalYear='.$fiscalyearval.' AND adjtempqc'.$userid.'.StoreId='.$hiddenstr.'');                                
                                foreach($gettemptableqc as $row)
                                {
                                    $tempvalqc[]=$row->AvailableQuantity;
                                    $singleqntqc=$row->AvailableQuantity;
                                    if($singleqntqc<0){
                                        $tempcntitemidqc[]=$row->ItemId;
                                        $tempcntqc+=1;
                                    }
                                }
                                //dd($tempvalqc);
                                if($singleqntqc<0){
                                    $unavailableitemsqc[]=$itemids;
                                    $cvalqc+=1;
                                }
                            }
                        }
                        else if($type=="Quantity&Cost"){
                            $updatestockingquantity=DB::select('update adjtemp'.$userid.' set StockIn='.$stinvalint.',StockOut=0 where HeaderId='.$request->adjustmentId.' AND TransactionsType="Adjustment" AND ItemId='.$itemids.' AND StoreId='.$hiddenstr.'');
                            $gettemptable=DB::select('SELECT adjtemp'.$userid.'.id,adjtemp'.$userid.'.HeaderId,adjtemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,adjtemp'.$userid.'.StoreId,uoms.Name AS UOM,adjtemp'.$userid.'.StockIn,adjtemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY adjtemp'.$userid.'.ItemId,adjtemp'.$userid.'.StoreId ORDER BY adjtemp'.$userid.'.id ASC)) AS AvailableQuantity,adjtemp'.$userid.'.TransactionsType FROM adjtemp'.$userid.' INNER JOIN regitems ON adjtemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON adjtemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE adjtemp'.$userid.'.ItemId='.$itemids.' AND adjtemp'.$userid.'.FiscalYear='.$fiscalyearval.' AND adjtemp'.$userid.'.StoreId='.$hiddenstr.'');
                            foreach($gettemptable as $row)
                            {
                                $tempval[]=$row->AvailableQuantity;
                                $singleqnt=$row->AvailableQuantity;
                                if($singleqnt<0){
                                    $tempcntitemid[]=$row->ItemId;
                                    $tempcnt+=1;
                                }
                            }
                            if($singleqnt<0){
                                $unavailableitems[]=$itemids;
                                $cval+=1;
                            }
                        }
                    }

                    foreach($insids as $val) {
                        $untotalavailable="0";
                        $unupdatevalue="0";
                        $untotalresult="0";
                        $untotalresval="0";
                        if(!in_array($val,$dynamictblitem)){
                            $ds=implode(',',$dynamictblitem);
                            $inds=implode(',',$insids);
                            // $getavailableqnt=DB::select('SELECT COALESCE(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)),0) AS TotalBalance FROM transactions WHERE transactions.ItemId='.$val.' AND transactions.StoreId='.$hiddenstr.' AND transactions.FiscalYear='.$fiscalyearval.'');
                            // foreach($getavailableqnt as $row)
                            // {
                            //     $untotalavailable=$row->TotalBalance;
                            // }
                            // $getadjustmentdetails=adjustmentdetail::where('HeaderId', $request->adjustmentId)->where('ItemId',$val)->get(['StockIn','StockOut']);
                            // foreach ($getadjustmentdetails as $getadjustmentdetails) {
                            //     $stockindbval=0;
                            //     $stockoutdbval=0;
                            //     $stockindbval = $getadjustmentdetails->StockIn;
                            //     $stockoutdbval = $getadjustmentdetails->StockOut;
                            //     $unupdatevalue=$stockindbval+$stockoutdbval;//either put on of the two values stock in or out,both shouldnt have a values 
                            // }
                            // $untotalresult=$untotalavailable-$unupdatevalue;
                            // $untotalresval=$untotalresult+0;
                            // $untotalresvals=(float)$untotalresval;
                            // if($untotalresvals<0){
                            //     $upunavailableitems[]=$val;
                            //     $upval+=1;
                            // }
                            
                            if($type=="Quantity"){
                                $updatestockingquantity=DB::select('update adjtemp'.$userid.' set StockOut=0,StoreId='.$request->Store.' where HeaderId='.$request->adjustmentId.' AND TransactionsType="Adjustment" AND ItemId='.$itemids.'');
                                $gettemptable=DB::select('SELECT adjtemp'.$userid.'.id,adjtemp'.$userid.'.HeaderId,adjtemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,adjtemp'.$userid.'.StoreId,uoms.Name AS UOM,adjtemp'.$userid.'.StockIn,adjtemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY adjtemp'.$userid.'.ItemId,adjtemp'.$userid.'.StoreId ORDER BY adjtemp'.$userid.'.id ASC)) AS AvailableQuantity,adjtemp'.$userid.'.TransactionsType FROM adjtemp'.$userid.' INNER JOIN regitems ON adjtemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON adjtemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE adjtemp'.$userid.'.ItemId='.$itemids.' AND adjtemp'.$userid.'.FiscalYear='.$fiscalyearval.' AND adjtemp'.$userid.'.StoreId='.$request->Store.'');
                                foreach($gettemptable as $row)
                                {
                                    $tempval[]=$row->AvailableQuantity;
                                    $singlenonqnt=$row->AvailableQuantity;
                                    if($singlenonqnt<0){
                                        $tempnoncntitemid[]=$row->ItemId;
                                        $tempnoncnt+=1;
                                    }
                                }
                                if($singlenonqnt<0){
                                    $upunavailableitems[]=$val;
                                    $upval+=1;
                                }
                                if($adjtype=="Quantity&Cost"){//Check if it is Quantity&Cost before 
                                    $updatestockingquantityqcun=DB::select('update adjtempqc'.$userid.' set StockIn='.$stinvalint.',StockOut=0 where HeaderId='.$request->adjustmentId.' AND TransactionsType="Adjustment" AND ItemId='.$itemids.' AND StoreId='.$hiddenstr.'');
                                    $gettemptableqcun=DB::select('SELECT adjtempqc'.$userid.'.id,adjtempqc'.$userid.'.HeaderId,adjtempqc'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,adjtempqc'.$userid.'.StoreId,uoms.Name AS UOM,adjtempqc'.$userid.'.StockIn,adjtempqc'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY adjtempqc'.$userid.'.ItemId,adjtempqc'.$userid.'.StoreId ORDER BY adjtempqc'.$userid.'.id ASC)) AS AvailableQuantity,adjtempqc'.$userid.'.TransactionsType FROM adjtempqc'.$userid.' INNER JOIN regitems ON adjtempqc'.$userid.'.ItemId=regitems.id INNER JOIN stores ON adjtempqc'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE adjtempqc'.$userid.'.ItemId='.$itemids.' AND adjtempqc'.$userid.'.FiscalYear='.$fiscalyearval.' AND adjtempqc'.$userid.'.StoreId='.$hiddenstr.'');                                
                                    foreach($gettemptableqcun as $row)
                                    {
                                        $tempvalqcun[]=$row->AvailableQuantity;
                                        $singleqntqcun=$row->AvailableQuantity;
                                        if($singleqntqcun<0){
                                            $tempcntitemidqcun[]=$row->ItemId;
                                            $tempcntqcun+=1;
                                        }
                                    }
                                    if($singleqntqcun<0){
                                        $unavailableitemsqcun[]=$itemids;
                                        $cvalqcun+=1;
                                    }
                                }
                            }
                            else if($type=="Quantity&Cost"){
                                $updatestockingquantity=DB::select('update adjtemp'.$userid.' set StockIn=0 where HeaderId='.$request->adjustmentId.' AND TransactionsType="Adjustment" AND ItemId='.$val.' AND StoreId='.$hiddenstr.'');
                                $gettemptable=DB::select('SELECT adjtemp'.$userid.'.id,adjtemp'.$userid.'.HeaderId,adjtemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,adjtemp'.$userid.'.StoreId,uoms.Name AS UOM,adjtemp'.$userid.'.StockIn,adjtemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY adjtemp'.$userid.'.ItemId,adjtemp'.$userid.'.StoreId ORDER BY adjtemp'.$userid.'.id ASC)) AS AvailableQuantity,adjtemp'.$userid.'.TransactionsType FROM adjtemp'.$userid.' INNER JOIN regitems ON adjtemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON adjtemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE adjtemp'.$userid.'.ItemId='.$itemids.' AND adjtemp'.$userid.'.FiscalYear='.$fiscalyearval.' AND adjtemp'.$userid.'.StoreId='.$hiddenstr.'');
                                foreach($gettemptable as $row)
                                {
                                    $tempval[]=$row->AvailableQuantity;
                                    $singlenonqnt=$row->AvailableQuantity;
                                    if($singlenonqnt<0){
                                        $tempnoncntitemid[]=$row->ItemId;
                                        $tempnoncnt+=1;
                                    }
                                }
                                if($singlenonqnt<0){
                                    $upunavailableitems[]=$val;
                                    $upval+=1;
                                }
                            }
                        } 
                    }
                    $unavitems=implode(',',$unavailableitems);
                    $upunavitems=implode(',',$upunavailableitems);
                    $unavtempitems=implode(',',$tempcntitemid);
                    $unavnontempitems=implode(',',$tempnoncntitemid);
                    $upunavitemsqc=implode(',',$unavailableitemsqc);
                    $unavtempitemsqc=implode(',',$tempcntitemidqc);
                    $upunavitemsqcun=implode(',',$unavailableitemsqcun);
                    $unavtempitemsqcun=implode(',',$tempcntitemidqcun);
                }
                $adjsm=adjustment::find($findid);
                $comnvals=$adjsm->Common;
                
                $validator = Validator::make($request->all(), [
                    'Type' => ['required'],
                    'Store' => ['required'],
                    'date' => ['required'],
                    //'Reason' => ['required'],
                ]);

                if($type=="Quantity"){
                    $rules=array(
                        'row.*.ItemId' => 'required',
                        'row.*.StockOutUnitCost' => 'required_if:Type,Quantity',
                        'row.*.StockOut' => 'required_if:Type,Quantity|lte:row.*.AvQuantity',
                        'row.*.Reason' => 'required',
                    );
                }
                
                if($type=="Quantity&Cost"){
                    $rules=array(
                        'row.*.ItemId' => 'required',
                        'row.*.UnitCost' => 'required_if:Type,Quantity&Cost',
                        'row.*.StockIn' => 'required_if:Type,Quantity&Cost',
                        'row.*.Reason' => 'required',
                    );
                }
                $cvals=(float)$cval;
                $upvals=(float)$upval;
                $tempcnts=(float)$tempcnt;
                $tempnoncnts=(float)$tempnoncnt;
                $cvalqcs=(float)$cvalqc;
                $tempcntqcs=(float)$tempcntqc;
                $cvalqcuns=(float)$cvalqcun;
                $tempcntqcuns=(float)$tempcntqcun;
                if($cvals>=1||$upvals>=1){
                    $totalvals=$cvals+$upvals;
                    $selecteditems=null;
                    $removeditemsselected=null;
                    if($unavitems!=null){
                        $selecteditems=$unavitems;
                    }
                    if($unavitems==null){
                        $selecteditems="0";
                    }
                    if($upunavitems!=null){
                        $removeditemsselected=$upunavitems;
                    }
                    if($upunavitems==null){
                        $removeditemsselected="0";
                    }
                    $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                    $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                    return Response::json(['qnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                }
                else if($tempcnts>=1||$tempnoncnts>=1){
                    $totalvals=$tempcnts+$tempnoncnts;
                    $selecteditems=null;
                    $removeditemsselected=null;
                    if($unavtempitems!=null){
                        $selecteditems=$unavtempitems;
                    }
                    if($unavtempitems==null){
                        $selecteditems="0";
                    }
                    if($unavnontempitems!=null){
                        $removeditemsselected=$unavnontempitems;
                    }
                    if($unavnontempitems==null){
                        $removeditemsselected="0";
                    }
                    $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                    $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                    return Response::json(['detqnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                }
                else if($cvalqcs>=1||$tempcntqcs>=1){
                    $totalvals=$cvalqcs+$tempcntqcs;
                    $selecteditems=null;
                    $removeditemsselected=null;
                    if($upunavitemsqc!=null){
                        $selecteditems=$upunavitemsqc;
                    }
                    if($upunavitemsqc==null){
                        $selecteditems="0";
                    }
                    if($unavtempitemsqc!=null){
                        $removeditemsselected=$unavtempitemsqc;
                    }
                    if($unavtempitemsqc==null){
                        $removeditemsselected="0";
                    }
                    $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                    $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                    return Response::json(['qcqnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                }
                else if($cvalqcuns>=1||$tempcntqcuns>=1){
                    $totalvals=$cvalqcuns+$tempcntqcuns;
                    $selecteditems=null;
                    $removeditemsselected=null;
                    if($upunavitemsqcun!=null){
                        $selecteditems=$upunavitemsqcun;
                    }
                    if($upunavitemsqcun==null){
                        $selecteditems="0";
                    }
                    if($unavtempitemsqcun!=null){
                        $removeditemsselected=$unavtempitemsqcun;
                    }
                    if($unavtempitemsqcun==null){
                        $removeditemsselected="0";
                    }
                    $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                    $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                    return Response::json(['qcunqnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                }
                else if($cval==0 && $upval==0 && $tempcnts==0 && $tempnoncnts==0 && $cvalqc==0 && $tempcntqc==0){
                    $v2= Validator::make($request->all(), $rules);
                    if ($validator->passes() && $v2->passes() &&($request->row!=null) && $editdiffstr==0) 
                    {
                        try
                        {
                            $adjustment=adjustment::updateOrCreate(['id' => $request->adjustmentId], [
                                'Type' => trim($request->Type),
                                'StoreId' => trim($request->Store),
                                'fiscalyear' => $fyear,
                                //'Reason' => trim($request->Reason),
                                'Memo' =>  trim($request->Description),
                                'TotalValue' => $request->totalvalues,
                                'EditConfirmedBy' => $user,//last edited by
                                'EditConfirmedDate' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),//last edited date
                            ]);

                            foreach ($request->row as $key => $value) 
                            {
                                $itemname=$value['ItemId'];
                                $stockout=$value['StockOut'];
                                $stockoutunitcost=$value['StockOutUnitCost'];
                                $stockin=$value['StockIn'];
                                $unitcost=$value['UnitCost'];
                                $itemtype=$value['ItemType'];
                                $storeid=$request->Store;
                                $transactiontype=$value['TransactionType'];
                                $reasonsvar=$value['Reason'];
                                $memo=$value['Memo'];
                                $beforetaxvarsto=$value['StockOutBeforeTaxCost'];
                                $taxvarsto=($beforetaxvarsto*15)/100;
                                $totalresultvarsto=$beforetaxvarsto+$taxvarsto;
                                $beforetaxvar=$value['BeforeTaxCost'];
                                $taxvar=($beforetaxvar*15)/100;
                                $totalresultvar=$beforetaxvar+$taxvar;
                                if(in_array($itemname,$insids)){
                                    $updateadjustmentdetails=adjustmentdetail::where('HeaderId',$request->adjustmentId)->where('ItemId',$itemname)->update(['StockIn'=>$stockin,'StockOut'=>$stockout,'UnitCost'=>$unitcost,'StockOutUnitCost'=>$stockoutunitcost,'StockOutBeforeTaxCost'=>$beforetaxvarsto,'StockOutTaxAmount'=>$taxvarsto,'StockOutTotalCost'=>$totalresultvarsto,'BeforeTaxCost'=>$beforetaxvar,'TaxAmount'=>$taxvar,'TotalCost'=>$totalresultvar,'Common'=>$comnvals,'ItemType'=>$itemtype,'StoreId'=>$storeid,'TransactionType'=>$transactiontype,'Reason'=>$reasonsvar,'Memo'=>$memo]);
                                    if($statusval=="Confirmed"){
                                        if($type=="Quantity"){
                                            $updatetransctions=transaction::where('HeaderId',$request->adjustmentId)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->whereIn('TransactionsType',$statusvalues)->update(['StockOut'=>$stockout,'UnitPrice'=>$stockoutunitcost,'BeforeTaxPrice'=>$beforetaxvarsto,'TaxAmountPrice'=>$taxvarsto,'TotalPrice'=>$totalresultvarsto,'StockIn'=>NULL,'UnitCost'=>NULL,'BeforeTaxCost'=>NULL,'TaxAmountCost'=>NULL,'TotalCost'=>NULL,'StoreId'=>$storeid,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                            $updatetransctionsvd=transaction::where('HeaderId',$request->adjustmentId)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->where('TransactionsType',"Void")->update(['StockIn'=>$stockout,'UnitCost'=>$stockoutunitcost,'BeforeTaxCost'=>$beforetaxvarsto,'TaxAmountCost'=>$taxvarsto,'TotalCost'=>$totalresultvarsto,'StockOut'=>NULL,'UnitPrice'=>NULL,'BeforeTaxPrice'=>NULL,'TaxAmountPrice'=>NULL,'TotalPrice'=>NULL,'StoreId'=>$storeid,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                        }
                                        else if($type=="Quantity&Cost"){
                                            $updatetransctions=transaction::where('HeaderId',$request->adjustmentId)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->whereIn('TransactionsType',$statusvalues)->update(['StockIn'=>$stockin,'UnitCost'=>$unitcost,'BeforeTaxCost'=>$beforetaxvar,'TaxAmountCost'=>$taxvar,'TotalCost'=>$totalresultvar,'StockOut'=>NULL,'UnitPrice'=>NULL,'BeforeTaxPrice'=>NULL,'TaxAmountPrice'=>NULL,'TotalPrice'=>NULL,'StoreId'=>$storeid,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                            $updatetransctionsvd=transaction::where('HeaderId',$request->adjustmentId)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->where('TransactionsType',"Void")->update(['StockOut'=>$stockin,'UnitPrice'=>$unitcost,'BeforeTaxPrice'=>$beforetaxvar,'TaxAmountPrice'=>$taxvar,'TotalPrice'=>$totalresultvar,'StockIn'=>NULL,'UnitCost'=>NULL,'BeforeTaxCost'=>NULL,'TaxAmountCost'=>NULL,'TotalCost'=>NULL,'StoreId'=>$storeid,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                        }
                                    }
                                }
                                if(!in_array($itemname,$insids)){
                                    $adjdet=new adjustmentdetail;
                                    $adjdet->HeaderId=$request->adjustmentId;
                                    $adjdet->ItemId=$itemname;
                                    $adjdet->StockIn=$stockin;
                                    $adjdet->StockOut=$stockout;
                                    $adjdet->UnitCost=$unitcost;
                                    $adjdet->StockOutUnitCost=$stockoutunitcost;
                                    $adjdet->StockOutBeforeTaxCost=$beforetaxvarsto;
                                    $adjdet->StockOutTaxAmount=$taxvarsto;
                                    $adjdet->StockOutTotalCost=$totalresultvarsto;
                                    $adjdet->BeforeTaxCost=$beforetaxvar;
                                    $adjdet->TaxAmount=$taxvar;
                                    $adjdet->TotalCost=$totalresultvar;
                                    $adjdet->Common=$comnvals;
                                    $adjdet->ItemType=$itemtype;
                                    $adjdet->StoreId=$storeid;
                                    $adjdet->TransactionType=$transactiontype;
                                    $adjdet->Reason=$reasonsvar;
                                    $adjdet->Memo=$memo;
                                    $adjdet->save();
                                    if($statusval=="Confirmed"){
                                        $tran=new transaction;
                                        $tran->HeaderId=$request->adjustmentId;
                                        $tran->ItemId=$itemname;
                                        $tran->StockOut=$stockout;
                                        $tran->UnitPrice=$unitcost;
                                        $tran->BeforeTaxPrice=$beforetaxvarsto;
                                        $tran->TaxAmountPrice=$taxvarsto;
                                        $tran->TotalPrice=$totalresultvarsto;
                                        $tran->StockIn=$stockin;
                                        $tran->UnitCost=$unitcost;
                                        $tran->BeforeTaxCost=$beforetaxvar;
                                        $tran->TaxAmountCost=$taxvar;
                                        $tran->TotalCost=$totalresultvar;
                                        $tran->StoreId=$storeid;
                                        $tran->IsVoid=0;
                                        $tran->TransactionType="Adjustment";
                                        $tran->TransactionsType="Adjustment";
                                        $tran->ItemType=$itemtype;
                                        $tran->DocumentNumber=$documentnumbers;
                                        $tran->FiscalYear=$fiscalyearval;
                                        $tran->Date=$confirmdates;
                                        $tran->save();
                                    }
                                }
                                $detailids[]=$itemname;
                            }
                            adjustmentdetail::where('HeaderId',$request->adjustmentId)->whereNotIn('ItemId',$detailids)->delete();
                            transaction::where('HeaderId',$request->adjustmentId)->where('TransactionType',$rectransactiontype)->whereNotIn('ItemId',$detailids)->delete();
                            if($statusval=="Confirmed"){
                                $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE adjtemp'.$userid.''));
                            }
                            return Response::json(['success' => '1']);
                        }
                        catch(Exception $e)
                        {
                            return Response::json(['dberrors' =>  $e->getMessage()]);
                        }
                    }
                }
            }
        }

        if($findid==null)
        {
            $validator = Validator::make($request->all(), [
                $adjNumber=>"unique:adjustments,DocumentNumber,$findid",
                'Type' => ['required'],
                'Store' => ['required'],
                'date' => ['required','date'],
                //'Reason' => ['required'],
            ]);
            
            if($request->row==null)
            {
                return Response::json(['rowerrors' => "1"]);
            }
            if($type=="Quantity"){
                $rules=array(
                    'row.*.ItemId' => 'required',
                    'row.*.StockOutUnitCost' => 'required_if:Type,Quantity',
                    'row.*.StockOut' => 'required_if:Type,Quantity|lte:row.*.AvQuantity',
                    'row.*.Reason' => 'required',
                );
                foreach ($request->row as $key => $value) 
                {
                    $serial=$value['serialnumids']; 
                    array_push($serialnums, $serial);
                    $sern=implode(",",$serialnums);
                }
                $getIssuedSerialNum=DB::select('SELECT COUNT(item_id) AS ItemCount FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,"'.$sern.'") AND IsIssued=1');
                foreach($getIssuedSerialNum as $row)
                {
                    $serialcnt=$row->ItemCount;
                }
                $serialcntnm = (float)$serialcnt;
                if($serialcntnm>=1){
                    $getIssuedserialnumlist=DB::select('SELECT CONCAT(COALESCE(regitems.Name,"")," , ",COALESCE(serialandbatchnums.BatchNumber,""),"  , ",COALESCE(serialandbatchnums.SerialNumber,"")," , ",COALESCE(serialandbatchnums.ExpireDate,"")," ",COALESCE(serialandbatchnums.ManufactureDate,"")) AS AllValues FROM serialandbatchnums INNER JOIN regitems ON serialandbatchnums.item_id=regitems.id WHERE FIND_IN_SET(serialandbatchnums.id,"'.$sern.'") AND IsIssued=1');
                    return Response::json(['serisserror' =>  "error",'countedisserval'=>$serialcntnm,'countisSerItems'=>$getIssuedserialnumlist]);
                }
            }
            if($type=="Quantity&Cost"){
                 $rules=array(
                    'row.*.ItemId' => 'required',
                    'row.*.UnitCost' => 'required_if:Type,Quantity&Cost',
                    'row.*.StockIn' => 'required_if:Type,Quantity&Cost',
                    'row.*.Reason' => 'required',
                );
            }
            $v2= Validator::make($request->all(), $rules);
            if ($validator->passes()&& $v2->passes()&&($request->row!=null) && $editdiffstr==0)
            {
                try
                {
                    $adjustment=adjustment::updateOrCreate(['id' => $request->adjustmentId], [
                    'DocumentNumber' => $adjNumber,
                    'Type' => trim($request->Type),
                    'StoreId' => trim($request->Store),
                    'fiscalyear' => $fyear,
                    'AdjustedBy' => $user,
                    'AdjustedDate' => trim($request->date),
                    //'Reason' => trim($request->Reason),
                    'Memo' =>  trim($request->Description),
                    'TotalValue' => $request->totalvalues,
                    'Status' => "Pending",
                    'Common' =>trim($request->commonVal),
                    ]);

                    foreach ($request->row as $key => $value) 
                    {
                        $itemname=$value['ItemId'];
                        $stockout=$value['StockOut'];
                        $stockoutunitcost=$value['StockOutUnitCost'];
                        $stockin=$value['StockIn'];
                        $unitcost=$value['UnitCost'];
                        $common=$request->commonVal;
                        $itemtype=$value['ItemType'];
                        $storeid=$request->Store;
                        $transactiontype=$value['TransactionType'];
                        $memo=$value['Memo'];
                        $reasonsvar=$value['Reason'];
                        $beforetaxvarsto=$value['StockOutBeforeTaxCost'];
                        $taxvarsto=($beforetaxvarsto*15)/100;
                        $totalresultvarsto=$beforetaxvarsto+$taxvarsto;
                        $beforetaxvar=$value['BeforeTaxCost'];
                        $taxvar=($beforetaxvar*15)/100;
                        $totalresultvar=$beforetaxvar+$taxvar;
                        $adjustment->items()->attach($itemname,
                        ['StockIn'=>$stockin,'StockOut'=>$stockout,'UnitCost'=>$unitcost,'StockOutUnitCost'=>$stockoutunitcost,'StockOutBeforeTaxCost'=>$beforetaxvarsto,'StockOutTaxAmount'=>$taxvarsto,'StockOutTotalCost'=>$totalresultvarsto,'BeforeTaxCost'=>$beforetaxvar,'TaxAmount'=>$taxvar,'TotalCost'=>$totalresultvar,'Common'=>$common,'ItemType'=>$itemtype,
                        'StoreId'=>$storeid,'TransactionType'=>$transactiontype,'Memo'=>$memo,'Reason'=>$reasonsvar]);
                    }
                    $comn=$request->commonVal;
                    $adj = DB::table('adjustments')->where('AdjustedBy',$user)->latest()->first();
                    $headerid=$adj->id;

                        
                    $serialnumbercopy=DB::table('serialandbatchnums')->insertUsing(
                    [
                        'header_id', 'item_id','store_id','brand_id','ModelName','ManufactureDate','ExpireDate','SerialNumber','BatchNumber','IsIssued',
                        'IsSold','TransactionType','TransactionDate','Common'
                    ],
                    function ($query)use($comn) {
                            $query
                                ->select(
                                [
                                    'header_id', 'item_id','store_id','brand_id','ModelName','ManufactureDate','ExpireDate','SerialNumber','BatchNumber','IsIssued',
                                    'IsSold','TransactionType','TransactionDate','Common'
                                ])
                                ->from('serialandbatchnum_temps')->where('Common', '=',$comn)->where('TransactionType',4);
                        }
                    );
                    if($type!="Quantity"){
                        $updateSerNum=DB::select('UPDATE serialandbatchnums SET IsConfirmed=1 WHERE Common='.$comn.' AND TransactionType=4');
                        $syncToSerialNumberHistory=DB::select('INSERT INTO serialnumberhistories(serialnumheader_id,transactionheader_id,DocumentNumber,TransactionType,TransactionDate)SELECT id,'.$headerid.',"'.$adjNumber.'","4","'.Carbon::today()->toDateString().'" from serialandbatchnums where Common='.$comn.' AND TransactionType=4');
                    }
                    if($type=="Quantity"){
                        $updateSerNumIss=DB::select('UPDATE serialandbatchnums SET IsIssued=1 WHERE FIND_IN_SET(serialandbatchnums.id,"'.$sern.'") AND TransactionType=4');
                        $syncToSerialNumberHistoryIss=DB::select('INSERT INTO serialnumberhistories(serialnumheader_id,transactionheader_id,DocumentNumber,TransactionType,TransactionDate)SELECT id,'.$headerid.',"'.$adjNumber.'","4","'.Carbon::today()->toDateString().'" from serialandbatchnums where FIND_IN_SET(serialandbatchnums.id,"'.$sern.'") AND TransactionType=4');
                    }
                    if($fyear==$fiscalyrcomp){
                        $updn=DB::select('update settings set AdjustmentNumber=AdjustmentNumber+1 where id=1');
                    }
                    return Response::json(['success' => '1','type'=>$type,'ser'=>$sern]);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
        }       
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }

        if($v2->fails())
        {
            return response()->json(['errorv2'  => $v2->errors()->all()]);
        }

        if($editdiffstr>=1){
            return Response::json(['strdifferrors'=>1]);
        }
    }

    public function showAdjDetailDataApp($id)
    {
        $detailTable=DB::select('SELECT adjustmentdetails.id,adjustmentdetails.ItemId,adjustmentdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,adjustmentdetails.StockIn,adjustmentdetails.UnitCost,adjustmentdetails.StockOut,adjustmentdetails.StockOutUnitCost,adjustmentdetails.Memo,adjustmentdetails.Reason,adjustmentdetails.StockOutBeforeTaxCost,adjustmentdetails.BeforeTaxCost,regitems.RequireSerialNumber,regitems.RequireExpireDate,COALESCE(CONCAT((SELECT GROUP_CONCAT((SELECT BatchNumber FROM serialandbatchnums WHERE serialandbatchnums.id IN(serialnumheader_id) AND serialandbatchnums.item_id=regitems.id)," ") FROM serialnumberhistories WHERE transactionheader_id=adjustmentdetails.HeaderId AND TransactionType=4)),"") AS BatchNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT((SELECT SerialNumber FROM serialandbatchnums WHERE serialandbatchnums.id IN(serialnumheader_id) AND serialandbatchnums.item_id=regitems.id)," ") FROM serialnumberhistories WHERE transactionheader_id=adjustmentdetails.HeaderId AND TransactionType=4)),"") AS SerialNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT((SELECT ExpireDate FROM serialandbatchnums WHERE serialandbatchnums.id IN(serialnumheader_id) AND serialandbatchnums.item_id=regitems.id)," ") FROM serialnumberhistories WHERE transactionheader_id=adjustmentdetails.HeaderId AND TransactionType=4)),"") AS ExpireDate,COALESCE(CONCAT((SELECT GROUP_CONCAT((SELECT ManufactureDate FROM serialandbatchnums WHERE serialandbatchnums.id IN(serialnumheader_id) AND serialandbatchnums.item_id=regitems.id)," ") FROM serialnumberhistories WHERE transactionheader_id=adjustmentdetails.HeaderId AND TransactionType=4)),"") AS ManufactureDate FROM adjustmentdetails INNER JOIN regitems ON adjustmentdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id WHERE adjustmentdetails.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn() 
            ->rawColumns(['action'])
            ->make(true);
    }


    public function syncDynamicTable(Request $request)
    {
        $insids=[];
        $tritem=[];
        $inds=null;
        $fiscalyears=null;
        $storeval=$request->Store;
        if($storeval!=null){
            $strdata=store::findorFail($storeval);
            $fiscalyears=$strdata->FiscalYear;
        }
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        //$fyear=$request->FiscalYears;
        
        if($storeval!=null && $fyear!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $fyear=$fiscalyears;
        }

        if($request->row!=null){
            foreach ($request->row as $key => $value) 
            {
                $insids[]=$value['ItemId'];
            }
            $inds=implode(',',$insids);
            $getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)))) AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fyear.' AND transactions.ItemId IN ('.$inds.') AND transactions.StoreId='.$storeval.' GROUP BY regitems.Name,transactions.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');
            return response()->json(['bal'=>$getallbalnces]);
        }
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

    public function editAdjustmentCon($id)
    {
        $insids=[];
        $adjdata = adjustment::find($id);
        $srcstoreid=$adjdata->StoreId;
        $fyear=$adjdata->fiscalyear;
        $settings = DB::table('settings')->latest()->first();
        $fyearcurr=$settings->FiscalYear;

        $strdata=store::findorFail($srcstoreid);
        $fiscalyears=$strdata->FiscalYear;

        $countitem = DB::table('adjustmentdetails')->where('HeaderId', '=', $id)->get();
        $getCountItem = $countitem->count();
        $itemidlists=adjustmentdetail::where('HeaderId',$id)->orderBy('adjustmentdetails.id','asc')->get(['ItemId']);
        foreach ($itemidlists as $itemidlists) {
            $insids[] = $itemidlists->ItemId;
        }
        $inds=implode(',',$insids);
        $data = adjustmentdetail::join('adjustments', 'adjustmentdetails.HeaderId', '=', 'adjustments.id')
            ->join('regitems', 'adjustmentdetails.ItemId', '=', 'regitems.id')
            ->join('uoms', 'regitems.MeasurementId', '=', 'uoms.id')
            ->where('adjustmentdetails.HeaderId', $id)
            ->orderBy('adjustmentdetails.id','asc')
            ->get(['adjustments.*','adjustmentdetails.*','adjustmentdetails.Common AS recdetcommon','adjustmentdetails.StoreId AS recdetstoreid',
            'adjustmentdetails.RequireSerialNumber AS ReSerialNm','adjustmentdetails.RequireExpireDate AS ReExpDate','regitems.Name AS ItemName','regitems.Code AS ItemCode','regitems.SKUNumber',
            'regitems.PartNumber','uoms.Name AS UomName',DB::raw('IFNULL(adjustmentdetails.Memo,"") AS ReqMemo'),DB::raw('IFNULL(adjustmentdetails.UnitCost,"") AS UnitCosts'),DB::raw('IFNULL(adjustmentdetails.StockOutUnitCost,"") AS StockOutUnitCosts')]);
        
            $getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.averageCost,transactions.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)))) AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fyear.' AND transactions.ItemId IN ('.$inds.') AND transactions.StoreId='.$srcstoreid.' GROUP BY regitems.Name,transactions.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');
        return response()->json(['adjdata'=>$adjdata,'adjdetail'=>$data,'bal'=>$getallbalnces,'fyearcurr'=>$fyearcurr,'fiscalyrstr'=>$fiscalyears]);
    }

    public function getAdjustmentNumber()
    {
        $settings = DB::table('settings')->latest()->first();
        $aprefix=$settings->AdjustmentPrefix;
        $anumber=$settings->AdjustmentNumber;
        $fyear=$settings->FiscalYear;
        $suffixdoc=$fyear-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $anumber);
        $adjNumber=$aprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        $updn=DB::select('update countable set AdjustmentCount=AdjustmentCount+1 where id=1');
        $reqCountNum = DB::table('countable')->latest()->first();
        return response()->json(['adjnum'=>$adjNumber,'AdjustmentCount'=>$reqCountNum->AdjustmentCount]);
    }

    public function getAdjustmentStoreItem(Request $request,$id)
    {
        $settingsval = DB::table('settings')->latest()->first();
        //$fiscalyr=$settingsval->FiscalYear;
        $fiscalyr=$request->FiscalYears;
        $itemtype=$request->Type;
        $getStItem=DB::table('transactions')
        ->join('regitems','regitems.id','=','transactions.ItemId')
        ->select('regitems.id','regitems.Name as ItemName')
        ->where('FiscalYear' ,$fiscalyr)
        ->where('StoreId' ,$id)
        ->groupBy('regitems.Name','regitems.id')
        ->get();
         return response()->json(['sid'=>$getStItem]);
    }

    public function getAdjItemQuantity(Request $request, $id)
    {
        $settingsval = DB::table('settings')->latest()->first();
        //$fiscalyr=$settingsval->FiscalYear;
        //$fiscalyr=$request->FiscalYears;
        $sourcestore=$request->Store;
        $storesdata = store::where('id',$request->Store)->first();
        $fiscalyr= $storesdata->FiscalYear;
        $getSalesQuantity=DB::select('SELECT COALESCE(SUM(salesitems.Quantity),0) AS TotalSalesQuantity FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE salesitems.ItemId='.$id.' AND salesitems.StoreId='.$sourcestore.' AND sales.Status IN ("pending..","Checked")');
        $getQuantity=DB::select('select (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity from transactions where transactions.FiscalYear='.$fiscalyr.' and transactions.StoreId='.$sourcestore.' and transactions.ItemId='.$id.'');
        $iteminfo=DB::select('SELECT regitems.id,regitems.Type,regitems.Code,regitems.Name,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus FROM regitems INNER JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.id='.$id);
        //$getCost=DB::select('SELECT IFNULL((SELECT UnitCost FROM transactions WHERE ItemId='.$id.' AND transactions.FiscalYear='.$fiscalyr.' AND TransactionsType NOT IN("Void","Undo-Void") ORDER BY id DESC LIMIT 1),0) AS UnitCost');
        //$getCost=DB::select('SELECT TRUNCATE(SUM(COALESCE(BeforeTaxCost,0))/SUM(COALESCE(StockIn,0)),2) AS AverageCost FROM transactions WHERE transactions.FiscalYear='.$fiscalyr.' AND transactions.ItemId='.$id.' AND transactions.StoreId='.$sourcestore.' AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Transfer","Requisition")');
        $getCost=DB::select('SELECT regitems.averageCost AS AverageCost FROM regitems WHERE regitems.id='.$id);
        return response()->json(['sid'=>$getQuantity,'itinfo'=>$iteminfo,'lastcost'=>$getCost,'fy'=>$fiscalyr,'salesqnt'=>$getSalesQuantity]);
    }

    public function editSerialNumberConAdj($id)
    {
        $recdata = serialandbatchnum_temp::find($id);
        return response()->json(['recData'=>$recdata]);
    }

    public function addSerialnumberConAdj(Request $request)
    {
        $itemid=$request->seritemid;
        $headerid=$request->serheaderid;
        $storeid=$request->serstoreid;
        $storeqnt=$request->storeQuantity;
        $tableids=$request->tableid;
        $qnt=$request->Quantity;
        $cmn=$request->commonserval;
        $ItemInfo=Regitem::find($itemid);
        $reqSerialNum=$ItemInfo->RequireSerialNumber;
        $reqExpireDate=$ItemInfo->RequireExpireDate;
        $countitem = DB::table('serialandbatchnum_temps')->where('Common', '=', $cmn)->where('item_id', '=', $itemid)->get();
        $getCountItems = $countitem->count();
        $citem = (float)$getCountItems;
        $qitem = (float)$storeqnt;
        $scount = (float)$storeqnt;
        $qcount = (float)$qnt;
        $remvalue=$scount-$citem;
        $validator = Validator::make($request->all(), [
            'brand' => 'required',
            'modelNumber' => 'required',
            'ManufactureDate' => 'nullable|before:today',
            'SerialNumber' => ['nullable',Rule::unique('serialandbatchnum_temps')->where(function ($query) use($cmn) {
                return $query->where('Common', $cmn)
                ->where('TransactionType', 4);
            })],
        ]);

        $validator->sometimes('SerialNumber', 'required|nullable|unique:serialandbatchnums', function($request) {
            return ($request->serialnumreq=='Require');
        });

        $validator->sometimes('BatchNumber', 'required', function($request) {
            return ($request->expirenumreq=='Require-Both'||$request->expirenumreq=='Require-BatchNumber');
        });

        $validator->sometimes('Quantity', 'required|gt:0', function($request) {
            return ($request->expirenumreq=="Require-Both"||$request->serialnumreq=='Require-BatchNumber');
        });

        $validator->sometimes('ExpireDate', 'required|after:today', function($request) {
            return ($request->expirenumreq=="Require-Both"||$request->expirenumreq=="Require-ExpireDate");
        });

        if($citem>=$qitem && $tableids==null)
        {
            return Response::json(['valerror' =>  "error"]);
        }
        
        if($validator->passes())
        {
            try
            {
                if($tableids==null){
                    if($remvalue>=$qcount){
                        for ($i = 1; $i <= $qcount; $i++ ) {
                            $ser=new serialandbatchnum_temp;
                            $ser->item_id=$request->seritemid;
                            $ser->store_id=$request->serstoreid;
                            $ser->brand_id=$request->brand;
                            $ser->ModelName=$request->modelNumber;
                            $ser->ManufactureDate=$request->ManufactureDate;
                            $ser->ExpireDate=$request->ExpireDate;
                            $ser->SerialNumber=$request->SerialNumber;
                            $ser->BatchNumber=$request->BatchNumber;
                            $ser->IsIssued=0;
                            $ser->IsSold=0;
                            $ser->TransactionType=4;
                            $ser->TransactionDate=Carbon::today()->toDateString();
                            $ser->Common=$request->commonserval;
                            $ser->save();
                        }
                    }
                    else if($remvalue<$qcount){
                        return Response::json(['qnterror' =>  "error"]);
                    }  
                }
                else if($tableids!=null){
                    $sernum=serialandbatchnum_temp::updateOrCreate(['id' =>$request->tableid], [
                        'item_id' => $request->seritemid,
                        'store_id' => $request->serstoreid,
                        'brand_id' => $request->brand,
                        'ModelName' => $request->modelNumber,
                        'ManufactureDate' => $request->ManufactureDate,
                        'ExpireDate' => $request->ExpireDate,
                        'SerialNumber' => $request->SerialNumber,
                        'BatchNumber'=> $request->BatchNumber,
                        'IsIssued'=> 0,
                        'IsSold'=> 0,
                        'TransactionType'=>4,
                        'TransactionDate'=>Carbon::today()->toDateString(),
                        'Common' => $request->commonserval,
                    ]);
                }
               
                $countitem = DB::table('serialandbatchnum_temps')->where('Common', '=', $cmn)->where('item_id', '=', $itemid)->get();
                $getCountItem = $countitem->count();
               
                return Response::json(['success' => '1','Totalcount'=>$getCountItem]);   
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }     
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function showRecDataCon($id)
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fyear=$settingsval->FiscalYear;
        $strid=null;
        $adjHeader=DB::select('SELECT adjustments.Status,adjustments.StatusOld,adjustments.fiscalyear,adjustments.StoreId FROM adjustments WHERE adjustments.id='.$id); 
        foreach($adjHeader as $row){
            $strid=$row->StoreId;
        }
        $strdata=store::findorFail($strid);
        $fiscalyearstr=$strdata->FiscalYear;

        return response()->json(['adjHeader'=>$adjHeader,'fyear'=>$fyear,'fyearstr'=>$fiscalyearstr]);
    }

    public function updateChecked(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->checkedid;
        
        $getCheckedVal=DB::select('SELECT COUNT(ItemId) AS ItemCount FROM adjustmentdetails INNER JOIN regitems ON adjustmentdetails.ItemId=regitems.id WHERE HeaderId='.$findid.' AND adjustmentdetails.StockOut!=(SELECT COUNT(ItemId) FROM serialandbatchnums WHERE serialandbatchnums.header_id=adjustmentdetails.HeaderId AND serialandbatchnums.item_id=adjustmentdetails.ItemId) AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require")');
        foreach($getCheckedVal as $row)
        {
            $avaq=$row->ItemCount;
        }
        $avaqp = (float)$avaq;
        if($avaqp>=1){
            $getItemName=DB::select('SELECT regitems.Name AS ItemName FROM adjustmentdetails INNER JOIN regitems ON adjustmentdetails.ItemId=regitems.id WHERE HeaderId='.$findid.' AND adjustmentdetails.StockOut!=(SELECT COUNT(ItemId) FROM serialandbatchnums WHERE serialandbatchnums.header_id=adjustmentdetails.HeaderId AND serialandbatchnums.item_id=adjustmentdetails.ItemId) AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require")');
            return Response::json(['valerror' =>"error",'countedval'=>$avaqp,'countItems'=>$getItemName]);
        }
        else{
            $adj=adjustment::find($findid);
            $adj->CheckedBy= $user;
            $adj->CheckedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            //$adj->CheckedDate=Carbon::today()->toDateString();
            $adj->Status="Checked";
            $adj->save();
            return Response::json(['success' => '1']);
        }   
    }

    public function updateConfimed(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->confirmid;
        $headerid=$request->confirmid;
        $adj=adjustment::find($findid);
        $fiscalyr=$adj->fiscalyear;
        $storeid=$adj->StoreId;
        $settingsval = DB::table('settings')->latest()->first();

        $getAdjItem=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM adjustmentdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$headerid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeid.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.StockOut)<0');
        foreach($getAdjItem as $row)
        {
            $avaq=$row->ApprovedItems;
        }
        $avaqp = (float)$avaq;
        if($avaqp>=1)
        {
            $getItemLists=DB::select('SELECT DISTINCT CONCAT(regitems.Code,"        ,       ",regitems.Name,"       ,       ",SKUNumber) AS ItemName,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeid.' AND transactions.FiscalYear='.$fiscalyr.') AS AvailableQuantity FROM adjustmentdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$headerid.' AND 
            (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeid.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.StockOut)<0');
            return Response::json(['valerror' => "error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
        }
        else{
            $adjustmentDocnumber=$adj->DocumentNumber;
            $trtype="Adjustment";
            $syncToTransaction=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,StockOut,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,UnitPrice,BeforeTaxPrice,TaxAmountPrice,TotalPrice,FiscalYear,TransactionsType,DocumentNumber,Date)SELECT HeaderId,ItemId,StockIn,StockOut,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,ItemType,StockOutUnitCost,StockOutBeforeTaxCost,StockOutTaxAmount,StockOutTotalCost,'.$fiscalyr.',"'.$trtype.'","'.$adjustmentDocnumber.'","'.Carbon::today()->toDateString().'" FROM adjustmentdetails WHERE HeaderId='.$headerid);
            $updateMaxCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.MaxCost = (SELECT ROUND(COALESCE(MAX(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
            $updateAverageCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.averageCost = (SELECT ROUND(COALESCE(SUM(BeforeTaxCost),0)/(COALESCE(SUM(StockIn),0))*1.15,2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
            $updateMinCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.minCost = (SELECT ROUND(COALESCE(MIN(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
            $adj->ConfirmedBy=$user;
            $adj->ConfirmedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            //$adj->ConfirmedDate=Carbon::today()->toDateString();
            $adj->Status="Confirmed";
            $adj->save();
            return Response::json(['success' => '1']);
        }
    }

    public function updatePending(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->pendingid;
        $adj=adjustment::find($findid);
        $adj->ChangeToPendingBy= $user;
        $adj->ChangeToPendingDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        //$adj->ChangeToPendingDate=Carbon::today()->toDateString();
        $adj->Status="Pending";
        $adj->save();
        return Response::json(['success' => '1']);
    }

    public function adjustmentVoid(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $itemidvals="";
        $runqnt="0";
        $totalqnt="0";
        $eachqntval="0";
        $avaq="0";
        $tempcntitemid=[];
        $totalitemid=[];
        $eachqnt=[];
        $findid=$request->voidid;
        $getApprovedQuantity=null;
        $getItemLists=null;
        $settingsval = DB::table('settings')->latest()->first();
        $rec=adjustment::find($findid);
        $fiscalyr=$rec->fiscalyear;
        $fiscalyearval=$rec->fiscalyear;
        $adjtypes=$rec->Type;
        $customerid=$rec->CustomerId;
        $transactiondate=$rec->TransactionDate;
        $storeId=$rec->StoreId;
        if($adjtypes=="Quantity"){
            $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM adjustmentdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.StockOut)<0');
        }
        else if($adjtypes=="Quantity&Cost"){
            $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM adjustmentdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.StockIn)<0');
            
            $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS adjtemp'.$userid.''));
            $creatingtemptables =DB::statement('CREATE TEMPORARY TABLE adjtemp'.$userid.' SELECT transactions.id,transactions.HeaderId,transactions.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,transactions.StoreId,uoms.Name AS UOM,transactions.StockIn,transactions.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY transactions.ItemId,transactions.StoreId ORDER BY transactions.id ASC)) AS AvailableQuantity,transactions.TransactionsType,transactions.FiscalYear FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE transactions.ItemId IN(SELECT adjustmentdetails.ItemId FROM adjustmentdetails WHERE adjustmentdetails.HeaderId='.$findid.') AND transactions.FiscalYear='.$fiscalyearval.'');
            $adjdetails=adjustmentdetail::where('HeaderId',$findid)->get(['ItemId']);
            foreach ($adjdetails as $adjdetails) {
                $itemidvals = $adjdetails->ItemId;
                $updatestockingquantity=DB::select('update adjtemp'.$userid.' set StockIn=0 where HeaderId='.$findid.' AND TransactionsType="Adjustment" AND ItemId='.$itemidvals.'');
                $gettemptable=DB::select('SELECT adjtemp'.$userid.'.id,adjtemp'.$userid.'.HeaderId,adjtemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,adjtemp'.$userid.'.StoreId,uoms.Name AS UOM,adjtemp'.$userid.'.StockIn,adjtemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY adjtemp'.$userid.'.ItemId,adjtemp'.$userid.'.StoreId ORDER BY adjtemp'.$userid.'.id ASC)) AS AvailableQuantity,adjtemp'.$userid.'.TransactionsType FROM adjtemp'.$userid.' INNER JOIN regitems ON adjtemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON adjtemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE adjtemp'.$userid.'.ItemId='.$itemidvals.' AND adjtemp'.$userid.'.FiscalYear='.$fiscalyearval.' AND adjtemp'.$userid.'.StoreId='.$storeId.'');
                foreach($gettemptable as $row){
                    $eachqntval=$row->AvailableQuantity;
                    $eachqnt[]=$row->AvailableQuantity;
                    if($eachqntval<0){
                        $tempcntitemid[]=$row->ItemId;
                        $runqnt+=1;
                    }
                }
                if($eachqntval<0){
                    $totalitemid[]=$itemidvals;
                    $totalqnt+=1;
                }
            }
            $tempididval=implode(',',$tempcntitemid);
            $totalitemidval=implode(',',$totalitemid);
        }
        foreach($getApprovedQuantity as $row)
        {
            $avaq=$row->ApprovedItems;
        }
        $avaqp = (float)$avaq;
        if($runqnt>=1||$totalqnt>=1)
        {
            if($adjtypes=="Quantity"){
                $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.') AS AvailableQuantity FROM adjustmentdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND 
                (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.StockOut)<0');
            }
            else if($adjtypes=="Quantity&Cost"){
                $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.') AS AvailableQuantity FROM adjustmentdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND 
                (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.StockIn)<0');
            }
            return Response::json(['valerror' =>"error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'Reason'=>"required",
            ]);
            if ($validator->passes()) 
            {
                $receivngcon = DB::table('adjustments')->where('id',$findid)->latest()->first();
                $docnum=$receivngcon->DocumentNumber;
                $fyear=$receivngcon->fiscalyear;
                $transactiontype="Adjustment";

                 $updatebeforetax=DB::select('update transactions set transactions.IsPriceVoid=1 where transactions.HeaderId='.$findid.' AND transactions.TransactionType IN("Adjustment") AND transactions.TransactionsType IN("Adjustment","Undo-Void")');

                if($adjtypes=="Quantity"){
                    $syncToTransactionVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,StockOut,"0",BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Void",ItemType,"'.$docnum.'","'.$fyear.'","1","'.Carbon::now()->toDateString().'" FROM adjustmentdetails WHERE adjustmentdetails.HeaderId='.$findid);
                }
                else if($adjtypes=="Quantity&Cost"){
                    $syncToTransactionVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,StockIn,"0",BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Void",ItemType,"'.$docnum.'","'.$fyear.'","1","'.Carbon::now()->toDateString().'" FROM adjustmentdetails WHERE adjustmentdetails.HeaderId='.$findid);
                }
                $updateStatus=DB::select('update adjustments set StatusOld=Status where id='.$findid.'');
                $rec->Status="Void";
                $rec->VoidBy=$user;
                $rec->VoidReason=trim($request->input('Reason'));
                $rec->VoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                //$rec->VoidDate=Carbon::today()->toDateString();
                $rec->save();

                $transactiontype="Adjustment";
                $undotransaction="Undo-Void";

                $updateMaxCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.MaxCost = (SELECT ROUND(COALESCE(MAX(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
                $updateAverageCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.averageCost = (SELECT ROUND(COALESCE(SUM(BeforeTaxCost),0)/(COALESCE(SUM(StockIn),0))*1.15,2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
                $updateMinCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.minCost = (SELECT ROUND(COALESCE(MIN(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
                return Response::json(['success' => '1']);
            }
            else
            {
                return Response::json(['errors' => $validator->errors()]);
            }
        }
    }

    public function adjustmentPenVoid(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->voidid;
        $rec=adjustment::find($findid);
        $validator = Validator::make($request->all(), [
            'Reason'=>"required",
        ]);
        if ($validator->passes()) 
        {
            $updateStatus=DB::select('update adjustments set StatusOld=Status where id='.$findid.'');
            $rec->Status="Void";
            $rec->VoidBy=$user;
            $rec->VoidReason=trim($request->input('Reason'));
            $rec->VoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            //$rec->VoidDate=Carbon::today()->toDateString();
            // $rec->UndoVoidBy="";
            // $rec->UndoVoidDate="";
            $rec->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function undoAdjustmentVoid(Request $request)
    {
        $findid=$request->undovoidid;
        $rec=adjustment::find($findid);
        $adjtypes=$rec->Type;
        $storeId=$rec->StoreId;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $receivingtype="Adjustment";
        $voidtype="Void";
        $trtype="Undo-Void";

        $receivngcon = DB::table('adjustments')->where('id', $findid)->latest()->first();
        $docnum=$receivngcon->DocumentNumber;
        $transactiontype="Adjustment";
        $fyear=$receivngcon->fiscalyear;

        $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM adjustmentdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fyear.'),0)-trs.StockOut)<0');
        foreach($getApprovedQuantity as $row)
        {
            $avaq=$row->ApprovedItems;
        }
        $avaqp = (float)$avaq;
		if($avaqp>=1)
        {
            if($adjtypes=="Quantity"){
                $getItemLists=DB::select('SELECT DISTINCT CONCAT(regitems.Code,"  ,   ",regitems.Name,"   ,   ",SKUNumber) AS ItemName,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fyear.') AS AvailableQuantity FROM adjustmentdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND 
                (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fyear.'),0)-trs.StockOut)<0');
            }
            return Response::json(['valerror' =>"error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
        }
        else{
            if($adjtypes=="Quantity"){
                $syncToTransactionUndoVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,StockOut,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Undo-Void",ItemType,"'.$docnum.'","'.$fyear.'","0","'.Carbon::now()->toDateString().'" FROM adjustmentdetails WHERE adjustmentdetails.HeaderId='.$findid);
            }
            else if($adjtypes=="Quantity&Cost"){
                $syncToTransactionUndoVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Undo-Void",ItemType,"'.$docnum.'","'.$fyear.'","0","'.Carbon::now()->toDateString().'" FROM adjustmentdetails WHERE adjustmentdetails.HeaderId='.$findid);
            }
            $updateStatus=DB::select('update adjustments set Status=StatusOld where id='.$findid.'');
            $rec->StatusOld="-";
            // $rec->VoidBy="-";
            // $rec->VoidReason="-";
            // $rec->VoidDate="-";
            $rec->UndoVoidBy=$user;
            $rec->UndoVoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            //$rec->UndoVoidDate=Carbon::today()->toDateString();
            $rec->save();
            $trtype="Void";
            $undotransaction="Undo-Void";

            $updateMaxCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.MaxCost = (SELECT ROUND(COALESCE(MAX(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
            $updateAverageCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.averageCost = (SELECT ROUND(COALESCE(SUM(BeforeTaxCost),0)/(COALESCE(SUM(StockIn),0))*1.15,2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
            $updateMinCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.minCost = (SELECT ROUND(COALESCE(MIN(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
            return Response::json(['success' => '1']);
        }
    }

    public function undoRecVoid(Request $request)
    {
        $findid=$request->undovoidid;
        $rec=adjustment::find($findid);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;

        $updateStatus=DB::select('update adjustments set Status=StatusOld where id='.$findid.'');
        $rec->StatusOld="-";
        // $rec->VoidBy="-";
        // $rec->VoidReason="-";
        // $rec->VoidDate="-";
        $rec->UndoVoidBy=$user;
        $rec->UndoVoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        //$rec->UndoVoidDate=Carbon::today()->toDateString();
        $rec->save();
        return Response::json(['success' => '1']);
        
    }

    public function showSerialNumbersAdj($cmn,$nid)
    {
        $sernum=DB::select('SELECT serialandbatchnum_temps.id,item_id,store_id,brand_id AS BrandId,brands.Name AS BrandName,ModelName,ManufactureDate,ExpireDate,SerialNumber,BatchNumber,IsIssued,TransactionDate FROM serialandbatchnum_temps INNER JOIN brands ON serialandbatchnum_temps.brand_id=brands.id WHERE Common='.$cmn.' and item_id='.$nid.' ORDER BY id DESC');
        return datatables()->of($sernum)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
                $btn =  ' <a class="btn btn-icon btn-gradient-info btn-sm editSN" data-id="'.$data->id.'" data-mod="'.$data->ModelName.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#sernumDeleteModal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function adjustmentdatafy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $req=DB::select('SELECT adjustments.id,adjustments.DocumentNumber,adjustments.Type,stores.Name as Store,adjustments.AdjustedDate,fiscalyear.Monthrange as FiscalYear,adjustments.AdjustedBy,adjustments.Reason,adjustments.created_at,adjustments.StatusOld,if(adjustments.Status="Void",concat(adjustments.Status,"(",adjustments.StatusOld,")"),adjustments.Status) AS Status FROM adjustments INNER JOIN stores ON adjustments.StoreId=stores.id INNER JOIN fiscalyear ON adjustments.fiscalyear=fiscalyear.FiscalYear WHERE adjustments.fiscalyear='.$fy.' AND adjustments.StoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=10) ORDER BY adjustments.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editln='';
                $voidlink='';
                $unvoidvlink='';
                if($data->Status=='Void'||$data->Status=='Void(Pending)'||$data->Status=='Void(Checked)'||$data->Status=='Void(Confirmed)')
                {
                    if($user->can('Adjustment-Void'))
                    {
                        $unvoidvlink= '<a class="dropdown-item undovoidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->StatusOld.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                    }
                    $voidlink='';
                    $editln='';
                }
                else if($data->Status=='Confirmed')
                {
                    if($user->can('Edit-Confirmed-Adjustment-Document'))
                    {
                        $editln=' <a class="dropdown-item editAdjHeader" onclick="editadjustmentdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-store="'.$data->Store.'" data-fyear="'.$data->FiscalYear.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Adjustment-Confirm') && $user->can('Adjustment-Void'))
                    {
                        //$voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                        $voidlink='';
                    } 
                }
                else if($data->Status=='Checked')
                {
                    if($user->can('Adjustment-Check') && $user->can('Adjustment-Edit'))
                    {
                        $editln=' <a class="dropdown-item editAdjHeader" onclick="editadjustmentdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-store="'.$data->Store.'" data-fyear="'.$data->FiscalYear.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    if($user->can('Adjustment-Check') && $user->can('Adjustment-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }   
                }
                else if($data->Status=='Pending')
                {
                    if($user->can('Adjustment-Edit'))
                    {
                        $editln=' <a class="dropdown-item editAdjHeader" onclick="editadjustmentdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-store="'.$data->Store.'" data-fyear="'.$data->FiscalYear.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Adjustment-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }
                }
                else if($data->Status!='Void'||$data->Status!='Void(Pending)'||$data->Status!='Void(Checked)'||$data->Status!='Void(Confirmed)')
                {
                    if($user->can('Adjustment-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }    
                }
                else if($data->Status=='Confirmed')
                {
                    if($user->can('Edit-Confirmed-Adjustment-Document'))
                    {
                        $editln=' <a class="dropdown-item editAdjHeader" onclick="editadjustmentdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-store="'.$data->Store.'" data-fyear="'.$data->FiscalYear.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Adjustment-Confirm') && $user->can('Adjustment-Void'))
                    {
                        //$voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                        $voidlink='';
                    } 
                }
                $btn='<div class="btn-group">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item DocAdjInfo" onclick="DocAdjInfo('.$data->id.')" data-id="'.$data->id.'" data-fy="'.$data->FiscalYear.'" data-toggle="modal" id="mediumButton" title="Show Detail Info"> 
                    <i class="fa fa-info"></i><span> Info</span>
                    </a>
                   '.$editln.'
                   '.$voidlink.'
                   '.$unvoidvlink.'
                    <a class="dropdown-item printAdjAttachment" href="javascript:void(0)" data-link="/adj/'.$data->id.'" id="printAdjV" data-attr="" title="Print Adjustment Voucher Attachment">
                        <i class="fa fa-file"></i><span> Print Adj. Voucher</span>
                    </a>
                    </div>
                 </div>';      
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
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
