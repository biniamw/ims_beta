<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\adjustment;
use App\Models\adjustmentdetail;
use App\Models\prd_order;
use App\Models\prd_order_cert;
use App\Models\prd_order_detail;
use App\Models\prd_order_process;
use App\Models\prd_duration;
use App\Models\prd_biproduct;
use App\Models\prd_output;
use App\Models\transaction;
use App\Models\receiving;
use App\Models\requisition;
use App\Models\requisitiondetail;
use App\Models\dispatchparent;
use App\Models\dispatchchild;
use App\Models\store;
use App\Models\lookup;
use App\Models\uom;
use App\Models\actions;
use Yajra\Datatables\Datatables;
use Exception;
use Carbon\Carbon;

class StoreRequisition extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $reqpage = 0;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->FiscalYear;
        $curdate = Carbon::today()->toDateString();
        $itemSrc = "";
        $itemSrcEd = "";
        $storeSrc = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM storeassignments LEFT JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=7 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        $desStoreSrc = DB::select('SELECT StoreId,stores.Name AS StoreName FROM storeassignments LEFT JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=7 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        //$itemSrcs = DB::select('SELECT regitems.id,regitems.Name FROM regitems WHERE regitems.ActiveStatus="Active" AND regitems.Type="Goods" AND regitems.IsDeleted=1 ORDER BY regitems.Name ASC');
        $users = DB::select('SELECT * FROM users WHERE username!="'.$user.'" AND id>1 ORDER BY username ASC');
        //$itemSrc=DB::select('SELECT DISTINCT ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND transactions.FiscalYear='.$fiscalyr.' AND StoreId IN(Select StoreId from storeassignments where UserId='.$userid.' AND storeassignments.Type=1)');
        //$itemSrc=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)))) AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId))>0 AND regitems.ActiveStatus="Active" AND transactions.FiscalYear='.$fiscalyr.' GROUP BY regitems.Name,transactions.StoreId  order by regitems.Name ASC');
        $itemSrc = DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,"1" AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" GROUP BY regitems.Name,transactions.StoreId HAVING Balance>0 ORDER BY regitems.Name ASC');
        $itemSrcEd = DB::select('SELECT DISTINCT ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND transactions.FiscalYear='.$fiscalyr.' AND StoreId IN(Select StoreId from storeassignments where UserId='.$userid.' AND storeassignments.Type=1)');
        $fiscalyears = DB::select('SELECT * FROM fiscalyear WHERE fiscalyear.FiscalYear<='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
        $storelists = DB::select('SELECT * FROM stores WHERE ActiveStatus="Active" AND id>1');
        $reqreasonReg = DB::select('SELECT lookups.RequestReasonValue,lookups.RequestReason FROM lookups WHERE lookups.RequestReasonValue>9 AND lookups.RequestReasonStatus="Active" ORDER BY lookups.RequestReason ASC');

        $itemSrcs = DB::table('transactions')
            ->select(
                'regitems.id AS ItemId',
                'regitems.Name AS ItemName',
                'regitems.Code',
                'regitems.SKUNumber',
                'transactions.StoreId',
                DB::raw('COALESCE(SUM(transactions.StockIn), 0) - COALESCE(SUM(transactions.StockOut), 0) AS Balance')
            )
            ->leftJoin('regitems', 'transactions.ItemId', '=', 'regitems.id')
            ->where('transactions.FiscalYear', $fiscalyr)
            ->groupBy('regitems.id', 'transactions.StoreId')
            ->orderBy('regitems.Name')
            ->get();
    
        if($reqpage == 0){
            if($request->ajax()) {
                return view('inventory.requisition',['storeSrc'=>$storeSrc,'desStoreSrc'=>$desStoreSrc,'itemSrcs'=>$itemSrcs,
                'users'=>$users,'user'=>$user,'userid'=>$userid,'itemSrc'=>$itemSrc,'itemSrcEd'=>$itemSrcEd,'fiscalyears'=>$fiscalyears,
                'storelists'=>$storelists,'curdate'=>$curdate,'fiscalyr'=>$fiscalyr,'reqreasonReg'=>$reqreasonReg])->renderSections()['content'];
            }
            else{
                return view('inventory.requisition',['storeSrc'=>$storeSrc,'desStoreSrc'=>$desStoreSrc,'itemSrcs'=>$itemSrcs,
                'users'=>$users,'user'=>$user,'userid'=>$userid,'itemSrc'=>$itemSrc,'itemSrcEd'=>$itemSrcEd,'fiscalyears'=>$fiscalyears,
                'storelists'=>$storelists,'curdate'=>$curdate,'fiscalyr'=>$fiscalyr,'reqreasonReg'=>$reqreasonReg]);
            }
        }
        else if($reqpage == 1){
            $reqreason = DB::select('SELECT lookups.RequestReasonValue,lookups.RequestReason FROM lookups WHERE lookups.RequestReasonStatus="Active"');
            $customerdatasrc = DB::select('SELECT * FROM customers WHERE CustomerCategory IN("Customer","--","Customer&Supplier","Foreigner Buyer","Person") and ActiveStatus="Active" and IsDeleted=1 order by Name asc');
            $recustomerdatasrc = DB::select('select * from customers where CustomerCategory IN("Customer","--","Customer&Supplier","Foreigner Buyer","Person") and ActiveStatus="Active" and IsDeleted=1 order by Name asc');
            $commtype = DB::select('SELECT lookups.CommodityTypeValue,lookups.CommodityType FROM lookups WHERE lookups.CommodityTypeStatus="Active"');
            $locationdata = DB::select('SELECT * FROM locations WHERE locations.ActiveStatus="Active"');
            $prdorderdata = DB::select('SELECT DISTINCT transactions.ProductionNumber,CONCAT(IFNULL(transactions.ProductionNumber,"")," , ",IFNULL(transactions.CertNumber,"")) AS ProductionNumberName,transactions.customers_id,(SELECT id FROM prd_orders WHERE prd_orders.ProductionOrderNumber=transactions.ProductionNumber) AS PrdId FROM transactions WHERE transactions.ProductionNumber IS NOT NULL AND transactions.ProductionNumber!=""');
            $prdordercertdata = DB::select('SELECT DISTINCT transactions.CertNumber,transactions.ProductionNumber FROM transactions WHERE transactions.CertNumber!="" OR transactions.CertNumber!=null');
            $prdorderexporigin = DB::select('SELECT DISTINCT transactions.woredaId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS CommType,CONCAT(transactions.CommodityType,transactions.ProductionNumber) AS MergedData FROM transactions LEFT JOIN woredas ON transactions.woredaId=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE transactions.ProductionNumber!="" AND transactions.ProductionNumber IS NOT NULL');
            $rejprdorderexporigin = DB::select('SELECT DISTINCT transactions.woredaId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS MergedData FROM transactions LEFT JOIN woredas ON transactions.woredaId=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE transactions.CommodityType=3');
            $prdSupplierDataSrc = DB::select('SELECT DISTINCT customers.id,customers.Code,customers.Name,customers.TinNumber,transactions.CommodityType,CONCAT(transactions.CommodityType,transactions.customers_id) AS MergedData FROM transactions LEFT JOIN customers ON transactions.SupplierId=customers.id WHERE transactions.SupplierId>0');
            $grndata = DB::select('SELECT DISTINCT transactions.GrnNumber,transactions.SupplierId FROM transactions WHERE transactions.GrnNumber!="" AND transactions.GrnNumber IS NOT NULL');
            $grncommodity = DB::select('SELECT DISTINCT transactions.woredaId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS CommType,transactions.GrnNumber FROM transactions INNER JOIN woredas ON transactions.woredaId=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE transactions.GrnNumber!="" AND transactions.GrnNumber IS NOT NULL');
            $gradedata = DB::select('SELECT DISTINCT transactions.Grade,lookups.Grade AS GradeName,CONCAT(transactions.woredaId,transactions.SupplierId,transactions.GrnNumber) AS MergedData FROM transactions INNER JOIN lookups ON transactions.Grade=lookups.GradeValue WHERE transactions.Grade!="" AND transactions.Grade IS NOT NULL AND transactions.GrnNumber!="" AND transactions.SupplierId>0 UNION SELECT DISTINCT transactions.Grade,lookups.Grade AS GradeName,CONCAT(transactions.woredaId,transactions.ProductionNumber,transactions.CertNumber) AS MergedData FROM transactions INNER JOIN lookups ON transactions.Grade=lookups.GradeValue WHERE transactions.Grade!="" AND transactions.Grade IS NOT NULL AND transactions.ProductionNumber!="" AND transactions.CertNumber!=""');
            $rejgradedata = DB::select('SELECT DISTINCT transactions.Grade,lookups.Grade AS GradeName,transactions.CommodityType AS MergedData FROM transactions LEFT JOIN lookups ON transactions.Grade=lookups.GradeValue WHERE transactions.Grade!="" AND transactions.Grade IS NOT NULL AND transactions.CommodityType=3');
            $processtypedata = DB::select('SELECT DISTINCT transactions.ProcessType,CONCAT(transactions.woredaId,transactions.SupplierId,transactions.GrnNumber) AS MergedData FROM transactions WHERE transactions.ProcessType!="" AND transactions.GrnNumber!="" AND transactions.SupplierId>0 UNION SELECT DISTINCT transactions.ProcessType,CONCAT(transactions.woredaId,transactions.ProductionNumber,transactions.CertNumber) AS MergedData FROM transactions WHERE transactions.ProcessType!="" AND transactions.ProductionNumber!="" AND transactions.CertNumber!=""');
            $rejprocesstypedata = DB::select('SELECT DISTINCT transactions.ProcessType,transactions.CommodityType AS MergedData FROM transactions WHERE transactions.ProcessType!="" AND transactions.CommodityType=3');
            $cropyeardata = DB::select('SELECT DISTINCT transactions.CropYear,lookups.CropYear AS CropYears,CONCAT(transactions.woredaId,transactions.SupplierId,transactions.GrnNumber) AS MergedData FROM transactions INNER JOIN lookups ON transactions.CropYear=lookups.CropYearValue WHERE transactions.CropYear!="" AND transactions.GrnNumber!="" AND transactions.SupplierId>0  UNION SELECT DISTINCT transactions.CropYear,lookups.CropYear AS CropYears,CONCAT(transactions.woredaId,transactions.ProductionNumber,transactions.CertNumber) AS MergedData FROM transactions INNER JOIN lookups ON transactions.CropYear=lookups.CropYearValue WHERE transactions.CropYear!="" AND transactions.ProductionNumber!="" AND transactions.CertNumber!=""');
            $rejcropyeardata = DB::select('SELECT DISTINCT transactions.CropYear,lookups.CropYear AS CropYears,transactions.CommodityType AS MergedData FROM transactions INNER JOIN lookups ON transactions.CropYear=lookups.CropYearValue WHERE transactions.CropYear!="" AND transactions.CommodityType=3');
            $uomdata = DB::select('SELECT DISTINCT transactions.uomId,uoms.Name AS UOM,uoms.bagweight,uoms.uomamount,CONCAT(transactions.woredaId,transactions.SupplierId,transactions.GrnNumber) AS MergedData FROM transactions INNER JOIN uoms ON transactions.uomId=uoms.id WHERE transactions.uomId!="" AND transactions.GrnNumber!="" AND transactions.SupplierId>0 UNION SELECT DISTINCT transactions.uomId,uoms.Name AS UOM,uoms.bagweight,uoms.uomamount,CONCAT(transactions.woredaId,transactions.ProductionNumber,transactions.CertNumber) AS MergedData FROM transactions INNER JOIN uoms ON transactions.uomId=uoms.id WHERE transactions.uomId!="" AND transactions.ProductionNumber!="" AND transactions.CertNumber!=""');
            $rejuomdata = DB::select('SELECT DISTINCT transactions.uomId,uoms.Name AS UOM,uoms.bagweight,uoms.uomamount,transactions.CommodityType AS MergedData FROM transactions LEFT JOIN uoms ON transactions.uomId=uoms.id WHERE transactions.uomId!="" AND transactions.CommodityType=3');
            $prdtypedata = DB::select('SELECT lookups.ProductTypeValue,lookups.ProductType FROM lookups WHERE lookups.ProductTypeStatus="Active"');
            $comptypedata = DB::select('SELECT lookups.CompanyTypeValue,lookups.CompanyType FROM lookups WHERE lookups.CompanyTypeStatus="Active"');
            $requestedCommData = DB::select('SELECT DISTINCT requisitiondetails.HeaderId,requisitiondetails.CommodityId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS CommType FROM requisitiondetails LEFT JOIN woredas ON requisitiondetails.CommodityId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.Type=1');
            $concatDataSrc = DB::select('SELECT DISTINCT requisitiondetails.id AS ReqDetailId,requisitiondetails.HeaderId,requisitiondetails.CommodityId,CONCAT(IFNULL(customers.Name,""),", ",IFNULL(requisitiondetails.GrnNumber,""),", ",IFNULL(requisitiondetails.ProductionOrderNo,""),", ",IFNULL(requisitiondetails.CertNumber,""),", ",IFNULL(requisitiondetails.ExportCertNumber,""),", ",IFNULL(uoms.Name,"")) AS ConcatData,requisitiondetails.DefaultUOMId FROM requisitiondetails LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.Type=1');
            $dispmodedata = DB::select('SELECT lookups.DispatchModeValue,lookups.DispatchModeName FROM lookups WHERE lookups.DispatchModeStatus="Active"');
            $prd_order_data = DB::select('SELECT prd_orders.id,prd_orders.ProductionOrderNumber,prd_orders.customers_id FROM prd_orders WHERE prd_orders.Status NOT IN("Void") ORDER BY prd_orders.ProductionOrderNumber ASC');

            if($request->ajax()) {
                return view('inventory.requisitionproc',['storeSrc'=>$storeSrc,'desStoreSrc'=>$desStoreSrc,'itemSrcs'=>$itemSrcs,'users'=>$users,'user'=>$user,'userid'=>$userid,'itemSrc'=>$itemSrc,
                'itemSrcEd'=>$itemSrcEd,'fiscalyears'=>$fiscalyears,'storelists'=>$storelists,'curdate'=>$curdate,'customerdatasrc'=>$customerdatasrc,'recustomerdatasrc'=>$recustomerdatasrc,'reqreason'=>$reqreason,
                'commtype'=>$commtype,'locationdata'=>$locationdata,'prdorderdata'=>$prdorderdata,'prdordercertdata'=>$prdordercertdata,'prdorderexporigin'=>$prdorderexporigin,'rejprdorderexporigin'=>$rejprdorderexporigin,'prdSupplierDataSrc'=>$prdSupplierDataSrc,
                'grndata'=>$grndata,'grncommodity'=>$grncommodity,'uomdata'=>$uomdata,'rejuomdata'=>$rejuomdata,'gradedata'=>$gradedata,'rejgradedata'=>$rejgradedata,'processtypedata'=>$processtypedata,'rejprocesstypedata'=>$rejprocesstypedata,
                'cropyeardata'=>$cropyeardata,'rejcropyeardata'=>$rejcropyeardata,'prdtypedata'=>$prdtypedata,'comptypedata'=>$comptypedata,'requestedCommData'=>$requestedCommData,'concatDataSrc'=>$concatDataSrc,'dispmodedata'=>$dispmodedata,'prd_order_data'=>$prd_order_data])->renderSections()['content'];
            }
            else{
                return view('inventory.requisitionproc',['storeSrc'=>$storeSrc,'desStoreSrc'=>$desStoreSrc,'itemSrcs'=>$itemSrcs,'users'=>$users,'user'=>$user,'userid'=>$userid,'itemSrc'=>$itemSrc,
                'itemSrcEd'=>$itemSrcEd,'fiscalyears'=>$fiscalyears,'storelists'=>$storelists,'curdate'=>$curdate,'customerdatasrc'=>$customerdatasrc,'recustomerdatasrc'=>$recustomerdatasrc,'reqreason'=>$reqreason,
                'commtype'=>$commtype,'locationdata'=>$locationdata,'prdorderdata'=>$prdorderdata,'prdordercertdata'=>$prdordercertdata,'prdorderexporigin'=>$prdorderexporigin,'rejprdorderexporigin'=>$rejprdorderexporigin,'prdSupplierDataSrc'=>$prdSupplierDataSrc,
                'grndata'=>$grndata,'grncommodity'=>$grncommodity,'uomdata'=>$uomdata,'rejuomdata'=>$rejuomdata,'gradedata'=>$gradedata,'rejgradedata'=>$rejgradedata,'processtypedata'=>$processtypedata,'rejprocesstypedata'=>$rejprocesstypedata,
                'cropyeardata'=>$cropyeardata,'rejcropyeardata'=>$rejcropyeardata,'prdtypedata'=>$prdtypedata,'comptypedata'=>$comptypedata,'requestedCommData'=>$requestedCommData,'concatDataSrc'=>$concatDataSrc,'dispmodedata'=>$dispmodedata,'prd_order_data'=>$prd_order_data]);
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

    public function showRequisitionData($comptype,$fiscalyr)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $req=DB::select('SELECT requisitions.id,requisitions.Type,requisitions.Reference,prdlookups.ProductType,reqlookups.RequestReason,requisitions.DocumentNumber,customers.Code,customers.Name AS CustomerName,customers.TinNumber,sstores.Name AS SourceStore,dstores.Name AS DestinationStore,requisitions.Date,requisitions.RequestedBy,requisitions.Status,requisitions.Purpose,requisitions.created_at,requisitions.OldStatus,requisitions.IssueDocNumber,requisitions.IssueId,requisitions.DispatchStatus,buyerscus.Name AS Buyer FROM requisitions INNER JOIN stores AS sstores ON requisitions.SourceStoreId=sstores.id INNER JOIN stores AS dstores ON requisitions.DestinationStoreId=dstores.id LEFT JOIN customers AS buyerscus ON requisitions.CustomerReceiver=buyerscus.id LEFT JOIN lookups AS prdlookups ON requisitions.Type=prdlookups.ProductTypeValue LEFT JOIN lookups AS reqlookups ON requisitions.RequestReason=reqlookups.RequestReasonValue LEFT JOIN customers ON requisitions.CustomerOrOwner=customers.id WHERE requisitions.CompanyType='.$comptype.' AND requisitions.fiscalyear='.$fiscalyr.' AND requisitions.SourceStoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type IN(2,3,7)) ORDER BY requisitions.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editln='';
                $deleteln='';
                $println='';
                $sivln='';
                $unvoidvlink='';
                $managedispatchlink='';
                if($data->Status=='Issued')
                {
                    $editln='';
                    if($user->can('Void-Requisition-After-Issue'))
                    {
                      //  $deleteln='  <a class="dropdown-item deleteRequisitionRecord" onclick="voidreqdata('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    if($user->can('Manage-Dispatch-Information'))
                    {
                        $managedispatchlink='  <a class="dropdown-item managedispatch" onclick="manageDispatchFn('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="managedispatch'.$data->id.'" data-original-title="Manage"><i class="fa fa-plus"></i><span> Add/Edit Dispatch Information</span></a>';
                    }
                    $println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    //$sivln=' <a class="dropdown-item printSIVAttachment" href="javascript:void(0)" data-link="/iss/'.$data->IssueId.'" id="printSIV" data-attr="" title="Print Store Issue Voucher Attachment"><i class="fa fa-file"></i><span> Print SIV</span></a>';
                    $unvoidvlink='';
                }
                else if($data->Status=='Pending' || $data->Status=='Draft')
                {
                    if($user->can('Requisition-Edit'))
                    {
                        $editln='  <a class="dropdown-item editRequisitionRecord" onclick="editreqdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Requisition-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" onclick="voidreqdata('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                    $managedispatchlink='';
                }
                else if($data->Status=='Approved')
                {
                    $editln='';
                    if($user->can('Requisition-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" onclick="voidreqdata('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    $managedispatchlink='';
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Verified' || $data->Status=='Reviewed')
                {
                    if($user->can('Requisition-Edit'))
                    {
                        $editln='  <a class="dropdown-item editRequisitionRecord" onclick="editreqdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    if($user->can('Requisition-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" onclick="voidreqdata('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                    $managedispatchlink='';
                }
                else if($data->Status=='Corrected')
                {
                    if($user->can('Requisition-Edit'))
                    {
                        $editln='  <a class="dropdown-item editRequisitionRecord" onclick="editreqdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    $deleteln='';
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                    $managedispatchlink='';
                } 
                else if($data->Status=='Rejected')
                {
                    $editln='';
                    $deleteln='';
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                    $managedispatchlink='';
                }
                if($data->Status=='Void' || $data->Status=='Void(Draft)' || $data->Status=='Void(Pending)' || $data->Status=='Void(Reviewed)' || $data->Status=='Void(Approved)' || $data->Status=='Void(Issued)')
                {
                    $editln='';
                    $deleteln='';
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV'.$data->id.'" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    if($data->Status=='Void' || $data->Status=='Void(Draft)' || $data->Status=='Void(Pending)' || $data->Status=='Void(Reviewed)' || $data->Status=='Void(Pending)'){
                        if($user->can('Requisition-Void'))
                        {
                            $unvoidvlink= '<a class="dropdown-item undovoidln" onclick="undovoidreqdata('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                        }
                    }
                    if($data->Status=='Void(Issued)'){
                        if($user->can('Void-Requisition-After-Issue'))
                        {
                            $unvoidvlink= '<a class="dropdown-item undovoidln" onclick="undovoidreqdata('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                        }
                    } 
                    $managedispatchlink='';
                }
                $btn='<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item DocReqInfo" onclick="DocReqInfo('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title="">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$editln.'
                        '.$managedispatchlink.'
                        '.$deleteln.' 
                        '.$unvoidvlink.' 
                        '.$println.' 
                        '.$sivln.' 
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function reqdata($fiscalyr)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        //$fiscalyr=$settingsval->FiscalYear;
        $req=DB::select('SELECT requisitions.id,requisitions.Type,requisitions.Reference,requisitions.SourceStoreId,requisitions.DocumentNumber,sstores.Name AS SourceStore,dstores.Name AS DestinationStore,requisitions.Date,requisitions.RequestedBy,requisitions.Status,requisitions.Purpose,requisitions.created_at,requisitions.OldStatus,requisitions.IssueDocNumber,requisitions.IssueId,requisitions.DispatchStatus,lookups.RequestReason AS req_reason FROM requisitions LEFT JOIN stores AS sstores ON requisitions.SourceStoreId=sstores.id LEFT JOIN stores AS dstores ON requisitions.DestinationStoreId=dstores.id LEFT JOIN lookups ON requisitions.RequestReason=lookups.RequestReasonValue WHERE requisitions.fiscalyear='.$fiscalyr.' AND requisitions.SourceStoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type IN(2,3,7)) ORDER BY requisitions.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editln='';
                $deleteln='';
                $println='';
                $sivln='';
                $unvoidvlink='';
                $managedispatchlink='';

                if($data->Status=='Issued')
                {
                    $editln='';
                    if($user->can('Void-Requisition-After-Issue'))
                    {
                      //  $deleteln='  <a class="dropdown-item deleteRequisitionRecord" onclick="voidreqdata('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    if($user->can('Manage-Dispatch-Information'))
                    {
                        $managedispatchlink='  <a class="dropdown-item managedispatch" onclick="manageDispatchFn('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="managedispatch'.$data->id.'" data-original-title="Manage"><i class="fa fa-plus"></i><span> Add/Edit Dispatch Information</span></a>';
                    }
                    $println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    //$sivln=' <a class="dropdown-item printSIVAttachment" href="javascript:void(0)" data-link="/iss/'.$data->IssueId.'" id="printSIV" data-attr="" title="Print Store Issue Voucher Attachment"><i class="fa fa-file"></i><span> Print SIV</span></a>';
                    $unvoidvlink='';
                }
                else if($data->Status=='Pending' || $data->Status=='Draft')
                {
                    if($user->can('Requisition-Edit'))
                    {
                        $editln='  <a class="dropdown-item editRequisitionRecord" onclick="editreqdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Requisition-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" onclick="voidreqdata('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                    $managedispatchlink='';
                }
                else if($data->Status=='Approved')
                {
                    $editln='';
                    if($user->can('Requisition-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" onclick="voidreqdata('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    $managedispatchlink='';
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Verified' || $data->Status=='Reviewed')
                {
                    if($user->can('Requisition-Edit'))
                    {
                        $editln='  <a class="dropdown-item editRequisitionRecord" onclick="editreqdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    if($user->can('Requisition-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" onclick="voidreqdata('.$data->id.')" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                    $managedispatchlink='';
                }
                else if($data->Status=='Corrected')
                {
                    if($user->can('Requisition-Edit'))
                    {
                        $editln='  <a class="dropdown-item editRequisitionRecord" onclick="editreqdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    $deleteln='';
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                    $managedispatchlink='';
                } 
                else if($data->Status=='Rejected')
                {
                    $editln='';
                    $deleteln='';
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                    $managedispatchlink='';
                }
                if($data->Status=='Void' || $data->Status=='Void(Draft)' || $data->Status=='Void(Pending)' || $data->Status=='Void(Reviewed)' || $data->Status=='Void(Approved)' || $data->Status=='Void(Issued)')
                {
                    $editln='';
                    $deleteln='';
                    //$println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" data-id="'.$data->id.'" id="printSRV'.$data->id.'" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRIV</span></a>';
                    $sivln='';
                    if($data->Status=='Void' || $data->Status=='Void(Draft)' || $data->Status=='Void(Pending)' || $data->Status=='Void(Reviewed)' || $data->Status=='Void(Pending)'){
                        if($user->can('Requisition-Void'))
                        {
                            $unvoidvlink= '<a class="dropdown-item undovoidln" onclick="undovoidreqdata('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                        }
                    }
                    if($data->Status=='Void(Issued)'){
                        if($user->can('Void-Requisition-After-Issue'))
                        {
                            $unvoidvlink= '<a class="dropdown-item undovoidln" onclick="undovoidreqdata('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                        }
                    } 
                    $managedispatchlink='';
                }
                $btn='<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item DocReqInfo" onclick="DocReqInfo('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title="">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$editln.'
                        '.$managedispatchlink.'
                        '.$deleteln.' 
                        '.$unvoidvlink.' 
                        '.$println.' 
                        '.$sivln.' 
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getstoreItem(Request $request,$id)
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $itemtype=$request->Type;
        $getStItem=DB::table('transactions')
        ->join('regitems','regitems.id','=','transactions.ItemId')
        ->select('regitems.id','regitems.Name as ItemName','regitems.Code as Code','regitems.SKUNumber as SKUNumber')
        ->where('FiscalYear' ,$fiscalyr)
        ->where('ItemType' ,$itemtype)
        ->where('StoreId' ,$id)
        ->groupBy('regitems.Name','regitems.id','regitems.Code','regitems.SKUNumber')
        ->get();
         return response()->json(['sid'=>$getStItem]);
    }

    public function getItemQuantity(Request $request, $id)
    {
        $fiscalyears=null;
        $sourcestore=$request->SourceStore;
        if($sourcestore!=null){
            $strdata=store::findorFail($sourcestore);
            $fiscalyears=$strdata->FiscalYear;
        }

        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        if($sourcestore!=null && $fiscalyr!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $fiscalyr=$fiscalyears;
        }
        
        $getQuantity=DB::select('SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity from transactions where transactions.FiscalYear='.$fiscalyr.' and transactions.StoreId='.$sourcestore.' and transactions.ItemId='.$id.'');
        $getSalesQuantity=DB::select('SELECT COALESCE(SUM(salesitems.Quantity),0) AS TotalSalesQuantity FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE salesitems.ItemId='.$id.' AND salesitems.StoreId='.$sourcestore.' AND sales.Status IN ("pending..","Checked")');
        $getTrnQuantity=DB::select('SELECT COALESCE(SUM(transferdetails.Quantity),0) AS TotalTrnQuantity FROM transferdetails INNER JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transferdetails.ItemId='.$id.' AND transferdetails.StoreId='.$sourcestore.' AND transfers.Status IN ("Pending","Approved")');
        $getReqQuantity=DB::select('SELECT COALESCE(SUM(requisitiondetails.Quantity),0) AS TotalReqQuantity FROM requisitiondetails INNER JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.ItemId='.$id.' AND requisitiondetails.StoreId='.$sourcestore.' AND requisitions.Status IN ("Pending","Approved")');
        $iteminfo=DB::select('SELECT regitems.id,regitems.Type,regitems.Code,regitems.Name,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus FROM regitems INNER JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.id='.$id);
        $getMaxCost=DB::select('SELECT MAX(UnitCost) AS UnitCost FROM transactions WHERE ItemId='.$id.' AND TransactionsType NOT IN ("Void","Undo-Void")');
        return response()->json(['sid'=>$getQuantity,'itinfo'=>$iteminfo,'getCost'=>$getMaxCost,'salesqnt'=>$getSalesQuantity,'trnqnt'=>$getTrnQuantity,'reqqnt'=>$getReqQuantity]);
    }

    public function fetchitembalance(Request $request){
        $location_id = $_POST['location_id']; 
        $item_id = $_POST['item_id']; 
        $store_id = $_POST['store_id']; 
        $customer_id = $_POST['customer_id'] ?? 1; 
        $record_id = $_POST['record_id'] ?? 0; 

        $settingsval = DB::table('settings')->latest()->first();
        $fiscal_year = $settingsval->FiscalYear;
        
        $item_balance_data = DB::select('SELECT (SUM(COALESCE(StockIn,0)) - SUM(COALESCE(StockOut,0))) AS available_quantity FROM transactions WHERE transactions.FiscalYear='.$fiscal_year.' AND transactions.StoreId='.$store_id.' AND transactions.ItemId='.$item_id.' AND transactions.LocationId='.$location_id.' AND transactions.customers_id='.$customer_id.' AND transactions.ItemType="Goods"');
        $other_item_data = DB::select('SELECT SUM(COALESCE(requisitiondetails.Quantity,0)) AS others_qty FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.id!='.$record_id.' AND requisitions.Type=2 AND requisitions.CustomerOrOwner='.$customer_id.' AND requisitions.SourceStoreId='.$store_id.' AND requisitiondetails.ItemId='.$item_id.' AND requisitiondetails.LocationId='.$location_id.' AND requisitions.Status IN("Draft","Pending","Verified","Reviewed","Approved")');
        $available_qty = $item_balance_data[0]->available_quantity - $other_item_data[0]->others_qty;

        $itemdata = DB::table('regitems')
            ->leftJoin('uoms', 'regitems.MeasurementId', '=', 'uoms.id')
            ->where('regitems.id',$item_id)
            ->get(['regitems.id','regitems.MeasurementId','uoms.Name AS uom_name']);
  
        $avcost = $this->getCurrentAverageCost($item_id);

        return response()->json(['itemdata' => $itemdata,'available_qty' => $available_qty,'avcost' => $avcost]);       
    }

    public function calcReqStBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $record_id = $_POST['baseRecordId'] ?? 0;
        $store_id = $_POST['storeval'] ?? 0;
        $item_id = $_POST['itemid'] ?? 0;

        $item_balance_data = DB::select('SELECT (SUM(COALESCE(StockIn,0)) - SUM(COALESCE(StockOut,0))) AS available_quantity FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.StoreId='.$store_id.' AND transactions.ItemId='.$item_id);
        $other_req_data = DB::select('SELECT SUM(COALESCE(requisitiondetails.Quantity,0)) AS others_req_qty FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.id!='.$record_id.' AND requisitions.SourceStoreId='.$store_id.' AND requisitiondetails.ItemId='.$item_id.' AND requisitions.Status IN("Draft","Pending","Verified","Approved")');
        $sales_data = DB::select('SELECT SUM(COALESCE(salesitems.Quantity,0)) AS sales_qty FROM salesitems LEFT JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.StoreId='.$store_id.' AND salesitems.ItemId='.$item_id.' AND sales.Status IN("pending..","Checked")');
        $transfer_data = DB::select('SELECT SUM(COALESCE(transferdetails.Quantity,0)) AS transfer_qty FROM transferdetails LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transfers.SourceStoreId='.$store_id.' AND transferdetails.ItemId='.$item_id.' AND transfers.Status IN("Draft","Pending","Verified","Reviewed","Approved")');

        $main_balance = $item_balance_data[0]->available_quantity ?? 0;
        $others_req_qty = $other_req_data[0]->others_req_qty ?? 0;
        $sales_qty = $sales_data[0]->sales_qty ?? 0;
        $transfer_qty = $transfer_data[0]->transfer_qty ?? 0;

        $available_qty = $main_balance - $others_req_qty - $sales_qty - $transfer_qty;

        $available_qty = $available_qty < 0 ? 0 : $available_qty;

        $itemdata = DB::table('regitems')
            ->leftJoin('uoms', 'regitems.MeasurementId', '=', 'uoms.id')
            ->where('regitems.id',$item_id)
            ->get(['regitems.id','regitems.MeasurementId','uoms.Name AS uom_name']);

        $avcost = $this->getCurrentAverageCost($item_id);

        return response()->json(['itemdata' => $itemdata,'available_qty' => $available_qty,'avcost' => $avcost]);       
    }

    public function getCurrentAverageCost($itemId)
    {
        $rows = DB::table('transactions')
            ->where('ItemId', $itemId)
            ->where('customers_id', 1)
            ->orderBy('id')
            ->get(['StockIn', 'StockOut', 'UnitCost']);

        $currentQty  = 0;
        $currentAvg  = 0;
        $totalInCost = 0;

        foreach ($rows as $r) {
            if ($r->StockIn > 0) {
                // Purchase → recalc weighted avg
                $totalInCost = ($currentQty * $currentAvg) + ($r->StockIn * $r->UnitCost);
                $currentQty  += $r->StockIn;
                $currentAvg  = $totalInCost / $currentQty;
            }

            if ($r->StockOut > 0 && $currentQty > 0) {
                // Sale/Requisition → reduce qty, avg stays the same
                $currentQty -= $r->StockOut;

                if ($currentQty <= 0) {
                    $currentQty = 0;
                    $currentAvg = 0; // reset if stock is depleted
                }
            }
        }

        return round($currentAvg, 2);
    }


    public function getItemEditQuantity(Request $request, $id)
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $sourcestore=$request->SourceStore;
        $getQuantity=DB::select('select (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity from transactions where transactions.FiscalYear='.$fiscalyr.' and transactions.StoreId='.$sourcestore.' and transactions.ItemId='.$id.'');
        $iteminfo=DB::select('SELECT regitems.id,regitems.Type,regitems.Code,regitems.Name,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus FROM regitems INNER JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.id='.$id);
        $getMaxCost=DB::select('SELECT MAX(UnitCost) AS UnitCost FROM transactions WHERE ItemId='.$id.' AND TransactionsType NOT IN ("Void","Undo-Void")');
        return response()->json(['sid'=>$getQuantity,'itinfo'=>$iteminfo,'getCost'=>$getMaxCost]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getRequisitionNumber()
    {
        $settings = DB::table('settings')->latest()->first();
        $hprefix=$settings->RequisitionPrefix;
        $hnumber=$settings->RequisitionNumber;
        $fyear=$settings->FiscalYear;
        $suffixdoc=$fyear-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $hnumber);
        $reqNumber=$hprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        $updn=DB::select('UPDATE countable SET RequisitionCount=RequisitionCount+1 WHERE id=1');
        $reqCountNum = DB::table('countable')->latest()->first();
        return response()->json(['reqnum'=>$reqNumber,'RequisitionCount'=>$reqCountNum->RequisitionCount]);
    }

    public function store(Request $request)
    {
        $storeid = $request->SourceStore;
        $hiddenstr = $request->hiddenstoreval;
        $fiscalyears = null;
        $fiscalyrcomp = null;
        $hnumber = null;
        $reqNumber = null;
        $hprefix = null;
        $editdiffstr = 0;
        if($storeid != null){
            $strdata = store::findorFail($storeid);
            $fiscalyears = $strdata->FiscalYear;
        }
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $fiscalyrcomp = $settings->FiscalYear;

        if($storeid != null && $fyear == $fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $hprefix = $settings->RequisitionPrefix;
            $hnumber = $settings->RequisitionNumber;
            $fyear = $settings->FiscalYear;
        }

        if($storeid != null && $fyear != $fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $requistionprop = DB::table('requisitions')->where('fiscalyear',$fiscalyears)->latest()->first();
            $docdata = $requistionprop->DocumentNumber;
            $hprefix = preg_replace('/[^a-zA-Z]/m','',$docdata);
            $numbersfor = preg_replace('/\D/', '', $docdata);
            $numbersfor = substr($numbersfor, 0, 5);
            $hnumber = $numbersfor+1;
            $fyear = $fiscalyears;
        }
        $suffixdoc = $fyear-2000;
        $suffixdocs = $suffixdoc+1;
        $numberPadding = sprintf("%05d", $hnumber);
        $reqNumber = $hprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $headerid = $request->requistionId;
        $findid = $request->requistionId;
        
        $desstoreid = $request->DestinationStore;
        $insids = [];
        $detailids = [];

        $validator = Validator::make($request->all(), [
            'SourceStore' => ['required'],
            'RequestReason' => ['required'],
            'RequestedBy' => ['required'],
            'date' => ['required','before:now'],
        ]);

        $rules = array(
            'row.*.ItemId' => 'required',
            'row.*.Quantity' => 'required|numeric|min:1|lte:row.*.AvQuantity|not_in:0'
        );

        $v2= Validator::make($request->all(), $rules);
        if ($validator->passes() && $v2->passes() && $request->row != null)
        {
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'SourceStoreId' => $request->SourceStore,
                    'DestinationStoreId' => 1,
                    'RequestReason' => $request->RequestReason,
                    'RequestedBy' => $request->RequestedBy,
                    'RequestDate' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'Date' => $request->date,
                    'Purpose' => $request->Purpose,
                    'fiscalyear' => $fyear,
                ];

                $DbData = requisition::where('id', $findid)->first();

                $CreatedBy = [
                    'Type' => 3,
                    'DocumentNumber' => $reqNumber,
                    'Status' => "Draft",
                    'PreparedBy' => $user,
                    'PreparedDate' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'Department' => "-",
                    'AuthorizedBy' => "-",
                    'AuthorizedDate' => "",
                    'ApprovedBy' => "-",
                    'ApprovedDate' => "",
                    'ReceivedBy' => "-",
                    'ReceivedDate' => "",
                    'CommentedBy' => "-",
                    'CommentedDate' => "",
                    'RejectedBy' => "-",
                    'RejectedDate' => "",
                ];

                $LastUpdatedBy = [
                    'updated_at' => Carbon::now(),
                ];

                $req = requisition::updateOrCreate(
                    ['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $req->items()->detach();

                foreach ($request->row as $key => $value) {
                    
                    $req->items()->attach($value['ItemId'],[
                        'Quantity' => $value['Quantity'],
                        'UnitCost' => $value['UnitCost'],
                        // 'BeforeTaxCost' => $beforetaxvar,
                        // 'TaxAmount' => $taxvar,
                        // 'TotalCost' => $totalresultvar,
                        'TransactionType' => "Requisition",
                        'ItemType' => "Goods",
                        'StoreId' => $request->SourceStore,
                        'DestStoreId' => 1, 
                        'Memo' => $value['Memo']
                    ]);
                }

                if($findid == null && $fyear == $fiscalyrcomp){
                    DB::select('UPDATE settings SET RequisitionNumber=RequisitionNumber+1 WHERE id=1');
                }

                $actions = $findid == null ? "Created" : "Edited";

                actions::insert([
                    'user_id' => $userid,
                    'pageid' => $req->id,
                    'pagename' => "requisition",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
   
                DB::commit();
                return Response::json(['success' => 1, 'rec_id' => $req->id, 'fiscalyr' => $fyear]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
    
        if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
        if($request->row == null){
            return response()->json(['emptyerror' => 465]);
        }
        if($v2->fails()){
            return response()->json(['errorv2' => $v2->errors()->all()]);
        }
        if($editdiffstr >= 1){
            return Response::json(['strdifferrors' => 465]);
        }
    }

    public function storeComm(Request $request){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime = Carbon::now();
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $headerid = $request->requistionId;
        $findid = $request->requistionId;
        $recprop = requisition::find($findid);
        $statusval = $recprop->Status ?? "None";
        $companytype = $request->CompanyType;
        $product_type = $request->ProductType;
        $PoDocumentNumber = null;
        $RecDocumentNumber = null;
        $additionalDoc = null;
        $customerid = 1;
        $currentdocnum = null;
        $actions = null;
        $prdIds = [];
        $detids = [];
        $req_detail_data = [];
        $commstflag = 0;
        $poreceiveflag = 0;
        $suppcnt = 0;
        $grnnumcnt = 0;
        $prdnumcnt = 0;
        $cernumcnt = 0;

        if($companytype==1){
            $recpropdata = requisition::where('CompanyType',1)->where('fiscalyear',$fyear)->latest()->first();
            $RecDocumentNumber=$settings->CommReqOwnerPrefix.sprintf("%05d",($recpropdata->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum=($recpropdata->CurrentDocumentNumber ?? 0)+1;

            if($findid!=null){
                $recprop = requisition::where('id',$findid)->where('fiscalyear',$fyear)->latest()->first();
                if($recprop->CompanyType==2){
                    $recpropedit = requisition::where('CompanyType',1)->where('fiscalyear',$fyear)->latest()->first();
                    $RecDocumentNumber=$settings->CommReqOwnerPrefix.sprintf("%05d",($recpropedit->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum=($recpropedit->CurrentDocumentNumber ?? 0)+1;
                }
                if($recprop->CompanyType==1){
                    $RecDocumentNumber=$recprop->DocumentNumber;
                    $currentdocnum=$recprop->CurrentDocumentNumber;
                }
            }
        }

        else if($companytype==2){
            $recpropdata = requisition::where('CompanyType',2)->where('fiscalyear',$fyear)->latest()->first();
            $RecDocumentNumber=$settings->CommReqCustomerPrefix.sprintf("%05d",($recpropdata->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum=($recpropdata->CurrentDocumentNumber ?? 0)+1;

            if($findid!=null){
                $recprop = requisition::where('id',$findid)->where('fiscalyear',$fyear)->latest()->first();
                if($recprop->CompanyType==1){
                    $recpropedit = requisition::where('CompanyType',2)->where('fiscalyear',$fyear)->latest()->first();
                    $RecDocumentNumber=$settings->CommReqOwnerPrefix.sprintf("%05d",($recpropedit->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum=($recpropedit->CurrentDocumentNumber ?? 0)+1;
                }
                if($recprop->CompanyType==2){
                    $RecDocumentNumber=$recprop->DocumentNumber;
                    $currentdocnum=$recprop->CurrentDocumentNumber;
                }
            }
        }

        $validator = Validator::make($request->all(),[
            'ProductType' => 'required',
            'CompanyType' => 'required',
            'RequestReason' => 'required_if:ProductType,1',
            'Customer' => 'required_if:CompanyType,2',
            //'BookingNumber' => 'required_if:RequestReason,3',
            //'Reference' => 'required_if:RequestReason,3',
            'LabratoryLocation' => 'required_if:RequestReason,5',
            'productionId' => ['required_if:RequestReason,10', 'max:255',Rule::unique('requisitions')->ignore($findid)],
            'SourceStore' => 'required',
            'RequestedBy' => 'required',
            'date' => 'required',  
        ]);

        $validator->sometimes('CustomerReceiver', 'required', function ($input) {
            return $input->CompanyType == 1 && $input->RequestReason == 3;
        });

        if($product_type == 1){
            $rules=array(
                'row.*.FloorMap' => 'required',
                'row.*.CommType' => 'required',
                'row.*.Origin' => 'required',
                'row.*.Grade' => 'required',
                'row.*.ProcessType' => 'required',
                'row.*.CropYear' => 'required',
                'row.*.Uom' => 'required',
                'row.*.NumOfBag' => 'required',
                'row.*.TotalBagWeight' => 'required',
                'row.*.TotalKg' => 'required',
            );
        }
        else if($product_type == 2){
            $rules=array(
                'row.*.location' => 'required',
                'row.*.ItemId' => 'required',
                'row.*.Quantity' => 'required',
            );
        }
        $v2 = Validator::make($request->all(), $rules);

        if($request->row != null && $product_type == 1){
            foreach ($request->row as $key => $value){
                $suppid = $value['Supplier'] ?? "N/A";
                $grnnum = $value['GrnNumber'] ?? "N/A";
                $cernum = $value['CertificateNum'] ?? "N/A";
                $prdnum = $value['ProductionNum'] ?? "N/A";
                if($suppid == 0 && $value['CommType'] == 1){
                    $suppcnt += 1;
                }
                if($grnnum == "" && $value['CommType'] == 1){
                    $grnnumcnt += 1;
                }
                if($cernum == "" && ($value['CommType'] == 2 || $value['CommType'] == 4 || $value['CommType'] == 5 || $value['CommType'] == 6)){
                    $cernumcnt += 1;
                }
                if($prdnum == "" && ($value['CommType'] == 2 || $value['CommType'] == 4 || $value['CommType'] == 5 || $value['CommType'] == 6)){
                    $prdnumcnt += 1;
                }
            }
        }

        if($validator->passes() && $v2->passes() && $request->row != null && $suppcnt == 0 && $grnnumcnt == 0 && $prdnumcnt==0 && $cernumcnt==0){
            DB::beginTransaction();
            try{
                $DbData = requisition::where('id',$findid)->first();
                $BasicVal = [
                    'DocumentNumber' => $RecDocumentNumber,
                    'Type' =>  $request->ProductType,
                    'CompanyType' =>  $request->CompanyType,
                    'RequestReason' =>  $request->RequestReason,
                    'CustomerOrOwner' =>  $request->Customer,
                    'CustomerReceiver' =>  $request->CustomerReceiver,
                    'BookingNumber' =>  $request->BookingNumber,
                    'Reference' =>  $request->Reference,
                    'LabStation' =>  $request->LabratoryLocation,
                    'SourceStoreId' =>  $request->SourceStore,
                    'productionId' =>  $request->productionId,
                    'RequestedBy' =>  $request->RequestedBy,
                    'PreparedBy' => $user,
                    'PreparedDate' => Carbon::now(),
                    'Date' =>  $request->date,
                    'Purpose' =>  $request->Purpose,
                    'fiscalyear' => $fyear,
                    'CurrentDocumentNumber' => $currentdocnum,
                    'DispatchStatus' => "-",
                    'DestinationStoreId' => 1,
                ];

                $CreateData = ['Status' => "Draft"];
                $UpdateData = ['updated_at' => Carbon::now()];

                $recpropdb = requisition::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $UpdateData : $CreateData),
                );
  
                $companytype=(int) $request->CompanyType;
                switch ($companytype) {
                    case 1:
                        $customer=1;
                        break;
                
                    default:
                        $customer=$request->Customer;
                        break;
                }
                     
                if($product_type == 1){
                    foreach ($request->row as $key => $value){
                        $prdIds[]=$value['id'];
                    }
                    requisitiondetail::where('requisitiondetails.HeaderId',$recpropdb->id)->delete();

                    foreach ($request->row as $key => $value){
                        $averagecost=DB::select('SELECT ROUND((SUM(COALESCE(transactions.TotalCostComm,0)) / SUM(COALESCE(transactions.StockInComm,0))),2) AS AverageCost FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$value["CommType"].' AND transactions.woredaId='.$value["Origin"].' AND transactions.Grade='.$value["Grade"].' AND transactions.ProcessType="'.$value["ProcessType"].'" AND transactions.CropYear='.$value["CropYear"].' AND transactions.TransactionsType IN("Beginning","Receiving","Adjustment","Production","Undo-Abort","Undo-Void") AND transactions.ItemType="Commodity" AND transactions.customers_id='.$customer);
                            
                        //this is commented by red for the purpose of owner doesnt save data 

                        $unitcost = !empty($averagecost[0]->AverageCost) ? $averagecost[0]->AverageCost : 0;
                        $netkg = !empty($value['NetKg']) ? $value['NetKg'] : 0;

                        $totalcost=round(($netkg * $unitcost),2);
                        $grandtotalcost=round((($netkg * $unitcost)*1.15),2);
                        $tax=round(($grandtotalcost-$totalcost),2);

                        requisitiondetail::updateOrCreate(['id' => $value['id']],
                        [ 
                            'HeaderId' => (int)$recpropdb->id,
                            'LocationId' => $value['FloorMap'],
                            'SupplierId' => $value['Supplier'] ?? "N/A",
                            'GrnNumber' => $value['GrnNumber'] ?? "N/A",
                            'ProductionOrderNo' => $value['ProductionNum'] ?? "N/A",
                            'CertNumber' => $value['CertificateNum'] ?? "N/A",
                            'ExportCertNumber' => $value['ExpCertificateNum'] ?? "N/A",
                            'StoreId' => (int)$request->SourceStore,
                            'CommodityId' => (int)$value['Origin'],
                            'CommodityType' => (int)$value['CommType'],
                            'Grade' => $value['Grade'],
                            'ProcessType' => $value['ProcessType'],
                            'CropYear' => $value['CropYear'],
                            'NewUOMId' => $value['Uom'],
                            'DefaultUOMId' => $value['Uom'],
                            'NumOfBag' => $value['NumOfBag'],
                            'BagWeight' => $value['TotalBagWeight'],
                            'TotalKg' => $value['TotalKg'],
                            'NetKg' => $value['NetKg'],
                            'Feresula' => $value['Feresula'],
                            'UnitCost' => $unitcost,
                            'BeforeTaxCost' => $totalcost,
                            'TaxAmount' => $tax,
                            'TotalCost' => $grandtotalcost,
                            'VarianceShortage' => (float)$value['varianceshortage'],
                            'VarianceOverage' => (float)$value['varianceoverage'],
                            'TransactionType' => "Requisition",
                            'Memo' => $value['Remark'],
                        ]); 
                    }
                }
                else if($product_type == 2){
                    foreach ($request->row as $key => $value){
                        $unit_cost = $this->getCurrentAverageCost($value['ItemId']);
                        $total_cost = round(($unit_cost * $value['Quantity']),2);
                        $grand_total = round((($unit_cost * $value['Quantity'])*1.15),2);
                        $tax = round(($grand_total - $total_cost),2);

                        $req_detail_data[]=[
                            'HeaderId' => $recpropdb->id,
                            'ItemId' => $value['ItemId'],
                            'Quantity' => $value['Quantity'],
                            'UnitCost' => $unit_cost,
                            'BeforeTaxCost' => $total_cost,
                            'TaxAmount' => $tax,
                            'TotalCost' => $grand_total,
                            'StoreId' => $request->SourceStore,
                            'NewUOMId' => $value['UOM'],
                            'DefaultUOMId' => $value['UOM'],
                            'LocationId' => $value['location'],
                            'CommodityId' => 1,
                            'CommodityType' => 1,
                            'Memo' => $value['Memo'],
                            'TransactionType' => "Requisition",
                            'ItemType' => "Goods",
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                    }
                    requisitiondetail::where('requisitiondetails.HeaderId',$recpropdb->id)->delete();
                    requisitiondetail::insert($req_detail_data);
                }

                if($findid == null){
                    $actions = "Created";
                }
                else if($findid != null){
                    $actions = "Edited";
                }

                actions::insert(['user_id'=>$userid,'pageid'=>$recpropdb->id,'pagename'=>"requisition",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
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
            return Response::json(['errors' => $validator->errors()]);
        }
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all(),'product_type' => $product_type]);
        }
        if($request->row==null)
        {
            return Response::json(['emptyerror'=> 462]);
        }
        if($suppcnt>0)
        {
            return response()->json(['suppcnt'=> 460]);
        }
        if($grnnumcnt>0)
        {
            return response()->json(['grnnumcnt'=> 461]);
        }
        if($cernumcnt>0)
        {
            return response()->json(['cernumcnt'=> 462]);
        }
        if($prdnumcnt>0)
        {
            return response()->json(['prdnumcnt'=> 462]);
        }
    }

    public function saveDispatchData(Request $request){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $recid=$request->dispatchRecId;
        $recprop=requisition::find($recid);
        $statusval=$recprop->Status ?? "None";
        $companytype=$recprop->CompanyType;
        $findid=$request->dispatchCurrRecId;

        $RecDocumentNumber=null;
        $currentdocnum=null;
        $disIds=[];
        $actions=null;

        $dispatchqty=0;
        $reqqty=0;

        if($companytype==1){
            $recpropdata = dispatchparent::leftJoin('requisitions','dispatchparents.ReqId','requisitions.id')->where('requisitions.CompanyType',1)->latest('dispatchparents.created_at')->first(['dispatchparents.*']);
            $RecDocumentNumber=$settings->DispDocOwnerPrefix.sprintf("%05d",($recpropdata->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum=($recpropdata->CurrentDocumentNumber ?? 0)+1;

            if($findid!=null){
                $recprop = dispatchparent::where('id',$findid)->latest()->first();
                if($recprop->CompanyType==2){
                    $recpropedit = dispatchparent::leftJoin('requisitions','dispatchparents.ReqId','requisitions.id')->where('requisitions.CompanyType',1)->latest('dispatchparents.created_at')->first();
                    $RecDocumentNumber=$settings->DispDocOwnerPrefix.sprintf("%05d",($recpropedit->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum=($recpropedit->CurrentDocumentNumber ?? 0)+1;
                }
                if($recprop->CompanyType==1){
                    $RecDocumentNumber=$recprop->DispatchDocNo;
                    $currentdocnum=$recprop->CurrentDocumentNumber;
                }
            }
        }
        else if($companytype==2){
            $recpropdata = dispatchparent::leftJoin('requisitions','dispatchparents.ReqId','requisitions.id')->where('requisitions.CompanyType',2)->latest('dispatchparents.created_at')->first();
            $RecDocumentNumber=$settings->DispDocCustomerPrefix.sprintf("%05d",($recpropdata->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum=($recpropdata->CurrentDocumentNumber ?? 0)+1;

            if($findid!=null){
                $recprop = dispatchparent::where('id',$findid)->latest()->first();
                if($recprop->CompanyType==1){
                    $recpropedit = dispatchparent::leftJoin('requisitions','dispatchparents.ReqId','requisitions.id')->where('requisitions.CompanyType',2)->latest('dispatchparents.created_at')->first();
                    $RecDocumentNumber=$settings->DispDocOwnerPrefix.sprintf("%05d",($recpropedit->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum=($recpropedit->CurrentDocumentNumber ?? 0)+1;
                }
                if($recprop->CompanyType==2){
                    $RecDocumentNumber=$recprop->DispatchDocNo;
                    $currentdocnum=$recprop->CurrentDocumentNumber;
                }
            }            
        }

        $validator = Validator::make($request->all(),[
            'DispatchMode' => 'required',
            'DriverName' => 'required_if:DispatchMode,1',
            'DriverLicenseNo' => ['required_if:DispatchMode,1',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('DriverLicenseNo','!=',"")->whereNotIn('Status',["Void","Void(Draft)","Void(Pending)","Void(Verified)","Void(Approved)"]);
            })->ignore($findid)],

            'DriverPhoneNo' => ['required_if:DispatchMode,1',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('DriverPhoneNo','!=',"")->whereNotIn('Status',["Void","Void(Draft)","Void(Pending)","Void(Verified)","Void(Approved)"]);
            })->ignore($findid)],

            'PlateNumber' => ['required_if:DispatchMode,1',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('PlateNumber','!=',"");
            })->ignore($findid)],

            'ContainerNumber' => ['nullable',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('ContainerNumber','!=',"");
            })->ignore($findid)],

            'SealNumber' => ['nullable',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('SealNumber','!=',"");
            })->ignore($findid)],

            'PersonName' => 'required_if:DispatchMode,2',
            'PersonPhoneNo' => ['required_if:DispatchMode,2',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('PersonPhoneNo','!=',"");
            })->ignore($findid)],
        ]);

        $rules=array(
            'disprow.*.dispOrigin' => 'required',
            'disprow.*.concatData' => 'required',
            'disprow.*.NumOfBagVal' => 'required',
            'disprow.*.TotalKgVal' => 'required',
            'disprow.*.NetKgVal' => 'required',
        );

        $v2= Validator::make($request->all(), $rules);

        if($validator->passes() && $v2->passes() && $request->disprow!=null){
            try{

                $DbData = dispatchparent::where('id',$findid)->first();
                $BasicVal = [
                    'ReqId' => $recid,
                    'DispatchDocNo' => $RecDocumentNumber,
                    'DispatchMode' =>  $request->DispatchMode,
                    'DriverName' =>  $request->DriverName,
                    'DriverLicenseNo' =>  $request->DriverLicenseNo,
                    'DriverPhoneNo' =>  $request->DriverPhoneNo,
                    'PlateNumber' =>  $request->PlateNumber,
                    'ContainerNumber' =>  $request->ContainerNumber,
                    'SealNumber' =>  $request->SealNumber,
                    'PersonName' =>  $request->PersonName,
                    'PersonPhoneNo' =>  $request->PersonPhoneNo,
                    'Remark' =>  $request->Remark,
                    'CurrentDocumentNumber' => $currentdocnum,
                    'PreparedBy' => $user,
                    'PreparedDate' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                ];

                $CreateData = ['Status'=>"Pending",'Date'=>Carbon::today()->toDateString()];
                $UpdateData = ['updated_at'=>Carbon::now()];

                $recpropdb = dispatchparent::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $UpdateData : $CreateData),
                );

                foreach ($request->disprow as $key => $value){
                    $disIds[]=$value['dispId'];
                }
                dispatchchild::where('dispatchchildren.dispatchparents_id',$recpropdb->id)->whereNotIn('id',$disIds)->delete();

                foreach ($request->disprow as $key => $value){
                    dispatchchild::updateOrCreate(['id' => $value['dispId']],
                    [ 
                        'ReqDetailId' =>$value['concatData'],
                        'dispatchparents_id'=>(int)$recpropdb->id,
                        'NumOfBag'=>$value['NumOfBagVal'],
                        'TotalKG'=>$value['TotalKgVal'],
                        'NetKG'=>$value['NetKgVal'],
                        'Remark'=>$value['RemRemark'],
                    ]); 
                }
                
                if($findid==null){
                    $actions="Created (Dispatch)";
                }
                else if($findid!=null){
                    $actions="Edited (Dispatch)";
                }

                actions::insert(['user_id'=>$userid,'pageid'=>$recid,'pagename'=>"requisition",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' =>1]);
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
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
        if($request->disprow==null)
        {
            return Response::json(['emptyerror'=> 462]);
        }
    }

    private function updateDispatchStatus($recid)
    {
        $dispatchqty=0;
        $reqqty=0;

        $reqdata=requisition::findorFail($recid);

        $getdispatchdata=DB::select('SELECT COALESCE(SUM(dispatchchildren.NumOfBag),0) AS NumOfBag,COALESCE(SUM(dispatchchildren.TotalKG),0) AS TotalKG,COALESCE(SUM(dispatchchildren.NetKG),0) AS NetKG FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.Status IN("Approved") AND dispatchparents.ReqId='.$recid);
        $dispatchqty=$getdispatchdata[0]->NetKG ?? 0;    

        $getreqdata=DB::select('SELECT COALESCE(SUM(requisitiondetails.NumOfBag),0) AS NumOfBag,COALESCE(SUM(requisitiondetails.TotalKG),0) AS TotalKG,COALESCE(SUM(requisitiondetails.NetKG),0) AS NetKG FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$recid);
        $reqqty=$getreqdata[0]->NetKG ?? 0;  

        if($dispatchqty == 0){
            requisition::where('requisitions.id',$recid)->update(['DispatchStatus'=>"-"]);
        }  
        else if($dispatchqty == $reqqty){
            requisition::where('requisitions.id',$recid)->update(['DispatchStatus'=>"Fully-Dispatched"]);
        }  
        else if($dispatchqty != $reqqty){
            requisition::where('requisitions.id',$recid)->update(['DispatchStatus'=>"Partially-Dispatched"]);
        }  

        if($reqdata->RequestReason==9){
            $this->updateReturnStatus($recid);
        }
    }

    private function updateDispatchQuantity($recid)
    { 
        $requpdatedata=DB::select('SELECT requisitiondetails.id FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$recid.' ORDER BY requisitiondetails.id ASC');
        foreach ($requpdatedata as $row) {
           requisitiondetail::where('requisitiondetails.id',$row->id)->update(['requisitiondetails.DispNumOfBag'=>DB::raw('(SELECT ROUND(SUM(COALESCE(dispatchchildren.NumOfBag,0)),2) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.Status IN("Approved") AND dispatchchildren.ReqDetailId=requisitiondetails.id)')]);
           requisitiondetail::where('requisitiondetails.id',$row->id)->update(['requisitiondetails.DispNetKg'=>DB::raw('(SELECT ROUND(SUM(COALESCE(dispatchchildren.NetKG,0)),2) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.Status IN("Approved") AND dispatchchildren.ReqDetailId=requisitiondetails.id)')]);
           requisitiondetail::where('requisitiondetails.id',$row->id)->update(['requisitiondetails.DispFeresula'=>DB::raw('(SELECT ROUND(SUM(COALESCE(dispatchchildren.NetKG,0))/17,2) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.Status IN("Approved") AND dispatchchildren.ReqDetailId=requisitiondetails.id)')]);
        }
    }

    private function updateReturnStatus($recid){
        $totalPurchased=0;
        $totalReturned=0;

        $getRequisitionData=DB::select('SELECT requisitions.DocumentNumber,requisitiondetails.* FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$recid);
        foreach ($getRequisitionData as $row) {
            $getReturneData=DB::select('SELECT SUM(COALESCE(requisitiondetails.NetKg,0)) AS NetKg FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.RequestReason=9 AND requisitions.DispatchStatus IN("Partially-Dispatched","Fully-Dispatched") AND requisitiondetails.GrnNumber="'.$row->GrnNumber.'" AND requisitiondetails.CommodityType='.$row->CommodityType.' AND requisitiondetails.CommodityId='.$row->CommodityId.' AND requisitiondetails.Grade='.$row->Grade.' AND requisitiondetails.ProcessType="'.$row->ProcessType.'" AND requisitiondetails.CropYear='.$row->CropYear.' AND requisitiondetails.DefaultUOMId='.$row->DefaultUOMId);
            $totalReturned=$getReturneData[0]->NetKg ?? 0; 

            $getPurchasedData=DB::select('SELECT SUM(COALESCE(receivingdetails.NetKg,0)) AS RecNetKg FROM receivingdetails LEFT JOIN receivings ON receivingdetails.HeaderId=receivings.id WHERE receivings.DocumentNumber="'.$row->GrnNumber.'" AND receivingdetails.CommodityType='.$row->CommodityType.' AND receivingdetails.CommodityId='.$row->CommodityId.' AND receivingdetails.Grade='.$row->Grade.' AND receivingdetails.ProcessType="'.$row->ProcessType.'" AND receivingdetails.CropYear='.$row->CropYear.' AND receivingdetails.DefaultUOMId='.$row->DefaultUOMId);
            $totalPurchased=$getPurchasedData[0]->RecNetKg ?? 0; 

            if($totalReturned == 0){
                receiving::where('receivings.DocumentNumber',$row->GrnNumber)->update(['ReturnStatus'=>0]);
            }  
            else if($totalPurchased != $totalReturned){
                receiving::where('receivings.DocumentNumber',$row->GrnNumber)->update(['ReturnStatus'=>1]);
            }  
            else if($totalPurchased == $totalReturned){
                receiving::where('receivings.DocumentNumber',$row->GrnNumber)->update(['ReturnStatus'=>2]);
            } 
        }
    }

    function countRequisitionStatus(){
        $fyear = $_POST['fyear']; 
        $requisition_status_count = DB::select('SELECT requisitions.Status,FORMAT(COUNT(*),0) AS status_count FROM requisitions WHERE requisitions.fiscalyear='.$fyear.' GROUP BY requisitions.Status UNION SELECT "Total",FORMAT(COUNT(*),0) AS status_count FROM requisitions WHERE requisitions.fiscalyear='.$fyear);
 
        return response()->json(['requisition_status_count' => $requisition_status_count]); 
    }

    public function syncDynamicTable(Request $request)
    {
        $insids=[];
        $tritem=[];
        $inds=null;
        $fiscalyears=null;
        $storeval=$request->SourceStore;
        if($storeval!=null){
            $strdata=store::findorFail($storeval);
            $fiscalyears=$strdata->FiscalYear;
        }
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;

        if($storeval!=null && $fyear!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $fyear=$fiscalyears;
        }
        
        if($request->row!=null){
            foreach ($request->row as $key => $value) 
            {
                $insids[]=$value['ItemId'];
            }
            $inds=implode(',',$insids);
            $getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(SELECT COALESCE((SUM(Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(SELECT COALESCE((sum(Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status IN("pending..","Checked") AND salesitems.StoreId=transactions.StoreId AND salesitems.ItemId=transactions.ItemId)))) AS Balance,(SELECT COALESCE((sum(Quantity)),0) FROM requisitiondetails INNER JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.Status IN("Pending","Approved") AND requisitions.SourceStoreId=transactions.StoreId AND requisitiondetails.ItemId=transactions.ItemId) AS ReqBalance,(SELECT COALESCE((sum(Quantity)),0) FROM transferdetails INNER JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transfers.Status IN("Pending","Approved") AND transfers.SourceStoreId=transactions.StoreId AND transferdetails.ItemId=transactions.ItemId) AS TrnBalance,(SELECT COALESCE((sum(Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status IN("pending..","Checked") AND salesitems.StoreId=transactions.StoreId AND salesitems.ItemId=transactions.ItemId) AS SalesBalance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fyear.' AND transactions.ItemId IN ('.$inds.') AND transactions.StoreId='.$storeval.' GROUP BY regitems.Name,transactions.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');
            return response()->json(['bal'=>$getallbalnces]);
        }
    }

    public function storeNewReqItem(Request $request)
    {
        $headerid=$request->receIds;
        $storeid=$request->receivingstoreid;
        $desstoreid=$request->desstId;
        $findid=$request->requisitionsid;
        $valId=$request->editVal;
      
        if($findid==null)
        {
            $validator = Validator::make($request->all(), [
                'itemNames' =>'required',
                'Quantity' =>"required|numeric|gt:0|not_in:0'",
            ]);
        }
        if($findid!=null)
        {
            $validator = Validator::make($request->all(), [
                'itemNames' =>'required',
                'Quantity' =>"required|numeric|gt:0|not_in:0'",
            ]);
        }

        if($validator->passes())
        {
            try
            {
                $req=requisitiondetail::updateOrCreate(['id' => $request->requisitionsid], [
                'HeaderId' => trim($request->receIds),
                'ItemId' => trim($request->itemNames),
                'Quantity' => trim($request->Quantity),
                'UnitCost' => trim($request->reqEditMaxCost),
                'PartNumber' =>trim($request->PartNumber),
                'Memo' =>trim($request->reqmemo),
                'StoreId' => trim($request->receivingstoreid),
                'DestStoreId' => "1",
                'TransactionType' =>"Requisition",
                'ItemType' =>"Consumption",
                ]);

                $reqrec = DB::table('requisitions')->where('id', $headerid)->latest()->first();
                $comm=$reqrec->Common;
                 
                DB::table('requisitiondetails')
                ->where('HeaderId', $headerid)
                ->update(['Common' => $comm]);
         
                $countitem = DB::table('requisitiondetails')->where('HeaderId', '=', $headerid)->get();
                $getCountItem = $countitem->count();

                DB::table('requisitiondetails')
                ->where('HeaderId', $headerid)
                ->update(['BeforeTaxCost' =>(DB::raw('requisitiondetails.Quantity * requisitiondetails.UnitCost')),'TaxAmount'=>(DB::raw('(requisitiondetails.BeforeTaxCost * 15)/100')),'TotalCost' =>(DB::raw('requisitiondetails.BeforeTaxCost + requisitiondetails.TaxAmount'))]);

                return Response::json(['success' =>  '1','Totalcount'=>$getCountItem]);
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

    public function editRequisition($id)
    {
        $insids=[];
        $fiscalyears=null;
        $srcstores=null;
        $desstores=null;
        $recdata = requisition::find($id);
        $srcstoreid = $recdata->SourceStoreId;
        $desstoreid = $recdata->DestinationStoreId;

        $reqheader = DB::table('requisitions')->where('id', $id)->get();

        if($srcstoreid!=null){
            $strdata=store::findorFail($srcstoreid);
            $fiscalyears=$strdata->FiscalYear;
            $srcstores=$strdata->Name;
            $desstr=store::findorFail($desstoreid);
            $desstores=$desstr->Name;
        }
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;

        if($srcstoreid!=null && $fyear!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $fyear=$fiscalyears;
        }

        $countitem = DB::table('requisitiondetails')->where('HeaderId', '=', $id)->get();
        $getCountItem = $countitem->count();
        $itemidlists=requisitiondetail::where('HeaderId',$id)->orderBy('requisitiondetails.id','asc')->get(['ItemId']);
        foreach ($itemidlists as $itemidlists) {
            $insids[] = $itemidlists->ItemId;
        }
        $inds=implode(',',$insids);
        
        $data = requisitiondetail::leftJoin('requisitions', 'requisitiondetails.HeaderId', '=', 'requisitions.id')
            ->leftJoin('regitems', 'requisitiondetails.ItemId', '=', 'regitems.id')
            ->leftJoin('uoms', 'regitems.MeasurementId', '=', 'uoms.id')
            ->where('requisitiondetails.HeaderId', $id)
            ->orderBy('requisitiondetails.id','asc')
            ->get(['requisitions.*','requisitiondetails.*','requisitiondetails.Common AS recdetcommon','requisitiondetails.StoreId AS recdetstoreid',
            'requisitiondetails.RequireSerialNumber AS ReSerialNm','requisitiondetails.RequireExpireDate AS ReExpDate','regitems.Name AS ItemName','regitems.Code AS ItemCode','regitems.SKUNumber',
            'regitems.PartNumber','uoms.Name AS UomName',DB::raw('IFNULL(regitems.SKUNumber,"") AS SKUNumber'),DB::raw('IFNULL(requisitiondetails.Memo,"") AS ReqMemo')]);
        
        $getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)))) AS Balance,(SELECT COALESCE((sum(Quantity)),0) FROM requisitiondetails INNER JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.Status IN("Pending","Approved") AND requisitions.SourceStoreId=transactions.StoreId AND requisitiondetails.ItemId=transactions.ItemId) AS ReqBalance,(SELECT COALESCE((sum(Quantity)),0) FROM transferdetails INNER JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transfers.Status IN("Pending","Approved") AND transfers.SourceStoreId=transactions.StoreId AND transferdetails.ItemId=transactions.ItemId) AS TrnBalance,(SELECT COALESCE((sum(Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status IN("pending..","Checked") AND salesitems.StoreId=transactions.StoreId AND salesitems.ItemId=transactions.ItemId) AS SalesBalance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fyear.' AND transactions.ItemId IN ('.$inds.') AND transactions.StoreId='.$srcstoreid.' GROUP BY regitems.Name,transactions.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');
        
        return response()->json(['reqheader'=>$reqheader,'recData'=>$recdata,'count'=>$getCountItem,'reqdetail'=>$data,'bal'=>$getallbalnces,'fyear'=>$fyear,'fyearstr'=>$fiscalyears,'srcstores'=>$srcstores,'desstores'=>$desstores]);
    }

    public function showRequisitionDetailData($id)
    {
        $detailTable=DB::select('SELECT requisitiondetails.id,requisitiondetails.ItemId,requisitiondetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS Code,requisitiondetails.PartNumber,uoms.Name as UOM,requisitiondetails.Quantity,requisitiondetails.Memo FROM requisitiondetails INNER JOIN regitems ON requisitiondetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where requisitiondetails.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            $btn = '<a data-id="'.$data->id.'" data-hid="'.$data->HeaderId.'" data-iid="'.$data->ItemId.'" data-itemname="'.$data->ItemName.'" data-code="'.$data->Code.'" data-uom="'.$data->UOM.'" data-memo="'.$data->Memo.'" class="btn btn-icon btn-gradient-info btn-sm editRecDatas" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            $btn = $btn.' <a data-id="'.$data->id.'" data-hid="'.$data->HeaderId.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm deleteReqDatas" data-attr="" data-target="#reqremovemodal" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function editRequisitionItem($id)
    {
        $recdataId = requisitiondetail::find($id);
        return response()->json(['recDataId'=>$recdataId]);
    }

    public function undorequistion(Request $request)
    {
        $findid = $request->undovoidid;
        $req = requisition::find($findid);
        $statusval = $req->Status;
        $oldstatusval = $req->OldStatus;
        $storeId = $req->SourceStoreId;
        $fiscalyr = $req->fiscalyear;
        $fiscalyearval = $req->fiscalyear;
        $docnum = $req->IssueDocNumber; 
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $reqtype = "Transfer";
        $itemidvals = "";
        $itemqnt = 0;
        $runqnt = 0;
        $totalqnt = 0;
        $eachqntval = 0;
        $avaq = 0;
        $tempcntitemid = [];
        $totalitemid = [];
        $eachqnt = [];
        $tempididval = "";
        $totalitemidval = "";
        
        DB::beginTransaction();
        try{
            if($oldstatusval == "Issued")
            {
                // $issuecon = DB::table('issues')->where('ReqId',$findid)->where('Type','!=',$reqtype)->latest()->first();
                // $issid=$issuecon->id;

                $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS reqtemp'.$userid.''));
                $creatingtemptables =DB::statement('CREATE TEMPORARY TABLE reqtemp'.$userid.' SELECT transactions.id,transactions.HeaderId,transactions.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,transactions.StoreId,uoms.Name AS UOM,transactions.StockIn,transactions.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY transactions.ItemId,transactions.StoreId ORDER BY transactions.id ASC)) AS AvailableQuantity,transactions.TransactionsType,transactions.FiscalYear FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE transactions.ItemId IN(SELECT requisitiondetails.ItemId FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$findid.') AND transactions.FiscalYear='.$fiscalyearval.'');
                $modifytemptable=DB::statement('ALTER TABLE reqtemp'.$userid.' MODIFY id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
                $recdetails=requisitiondetail::where('HeaderId',$findid)->get(['ItemId','Quantity']);
                foreach ($recdetails as $recdetails) {
                    $itemidvals = $recdetails->ItemId;
                    $itemqnt = $recdetails->Quantity;
                    $updatestockingquantity=DB::select('INSERT INTO reqtemp'.$userid.' (HeaderId,ItemId,StockOut,StoreId,TransactionsType,FiscalYear) VALUES ('.$findid.','.$itemidvals.','.$itemqnt.','.$storeId.',"Requisition",'.$fiscalyearval.')');
                    //$updatestockingquantity=DB::select('update reqtemp'.$userid.' set StockOut='.$itemqnt.' where HeaderId='.$findid.' AND TransactionsType="Requisition" AND ItemId='.$itemidvals.'');
                    $gettemptable=DB::select('SELECT reqtemp'.$userid.'.id,reqtemp'.$userid.'.HeaderId,reqtemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,reqtemp'.$userid.'.StoreId,uoms.Name AS UOM,reqtemp'.$userid.'.StockIn,reqtemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY reqtemp'.$userid.'.ItemId,reqtemp'.$userid.'.StoreId ORDER BY reqtemp'.$userid.'.id ASC)) AS AvailableQuantity,reqtemp'.$userid.'.TransactionsType FROM reqtemp'.$userid.' INNER JOIN regitems ON reqtemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON reqtemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE reqtemp'.$userid.'.ItemId='.$itemidvals.' AND reqtemp'.$userid.'.FiscalYear='.$fiscalyearval.' AND reqtemp'.$userid.'.StoreId='.$storeId.'');
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
                $totaluniqueval = count(array_unique(array_merge($tempcntitemid,$totalitemid)));

                if($runqnt>=1 || $totalqnt>=1)
                {
                    $allitems=$tempididval.",".$totalitemidval;
                    $getItemLists=DB::select('SELECT DISTINCT regitems.Name,regitems.id AS ApprovedItems,regitems.id AS AvailableItems FROM regitems WHERE regitems.id IN('.$allitems.')');
                    return Response::json(['valerror'=>"error",'countedval'=>$totaluniqueval,'countItems'=>$getItemLists]);
                }
                else
                {
                    $syncToTransactionundoVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,Date) SELECT "'.$findid.'",ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Undo-Void","Goods","'.$docnum.'","'.$fiscalyr.'","'.Carbon::now()->toDateString().'" FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$findid);
                    //$updateTransactios=DB::select('update transactions set IsVoid=0 where HeaderId='.$issid.' AND TransactionType="Requisition" AND TransactionsType="Requisition"');
                }
            }
            $updateStatus=DB::select('UPDATE requisitions SET Status=OldStatus,UndoVoidBy="'.$user.'",UndoVoidDate="'.Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A').'",OldStatus="" WHERE id='.$findid.'');
            
            actions::insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "requisition",
                'action' => "Undo Void",
                'status' => "Undo Void",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'reason' => "",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::commit();
            return Response::json(['success' => 1, 'reqId' => $findid, 'fiscalyr' => $fiscalyearval]);    
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function reqUndoVoidComm(Request $request)
    {
        $findid=$request->undovoidid;
        $req=requisition::find($findid);
        $statusval=$req->Status;
        $oldstatusval=$req->OldStatus;
        $storeId=$req->SourceStoreId;
        $fiscalyr=$req->fiscalyear;
        $fiscalyearval=$req->fiscalyear;
        $docnum=$req->IssueDocNumber; 
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $reqtype="Transfer";
        $itemidvals="";
        $itemqnt="0";
        $runqnt="0";
        $totalqnt="0";
        $eachqntval="0";
        $avaq="0";
        $tempcntitemid=[];
        $totalitemid=[];
        $eachqnt=[];
        $tempididval="";
        $totalitemidval="";
        // if($oldstatusval=="Issued")
        // {
        //     $issuecon = DB::table('issues')->where('ReqId',$findid)->where('Type','!=',$reqtype)->latest()->first();
        //     $issid=$issuecon->id;

        //     $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS reqtemp'.$userid.''));
        //     $creatingtemptables =DB::statement('CREATE TEMPORARY TABLE reqtemp'.$userid.' SELECT transactions.id,transactions.HeaderId,transactions.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,transactions.StoreId,uoms.Name AS UOM,transactions.StockIn,transactions.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY transactions.ItemId,transactions.StoreId ORDER BY transactions.id ASC)) AS AvailableQuantity,transactions.TransactionsType,transactions.FiscalYear FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE transactions.ItemId IN(SELECT requisitiondetails.ItemId FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$findid.') AND transactions.FiscalYear='.$fiscalyearval.'');
        //     $modifytemptable=DB::statement('ALTER TABLE reqtemp'.$userid.' MODIFY id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
        //     $recdetails=requisitiondetail::where('HeaderId',$findid)->get(['ItemId','Quantity']);
        //     foreach ($recdetails as $recdetails) {
        //         $itemidvals = $recdetails->ItemId;
        //         $itemqnt = $recdetails->Quantity;
        //         $updatestockingquantity=DB::select('INSERT INTO reqtemp'.$userid.' (HeaderId,ItemId,StockOut,StoreId,TransactionsType,FiscalYear) VALUES ('.$findid.','.$itemidvals.','.$itemqnt.','.$storeId.',"Requisition",'.$fiscalyearval.')');
        //         //$updatestockingquantity=DB::select('update reqtemp'.$userid.' set StockOut='.$itemqnt.' where HeaderId='.$findid.' AND TransactionsType="Requisition" AND ItemId='.$itemidvals.'');
        //         $gettemptable=DB::select('SELECT reqtemp'.$userid.'.id,reqtemp'.$userid.'.HeaderId,reqtemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,reqtemp'.$userid.'.StoreId,uoms.Name AS UOM,reqtemp'.$userid.'.StockIn,reqtemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY reqtemp'.$userid.'.ItemId,reqtemp'.$userid.'.StoreId ORDER BY reqtemp'.$userid.'.id ASC)) AS AvailableQuantity,reqtemp'.$userid.'.TransactionsType FROM reqtemp'.$userid.' INNER JOIN regitems ON reqtemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON reqtemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE reqtemp'.$userid.'.ItemId='.$itemidvals.' AND reqtemp'.$userid.'.FiscalYear='.$fiscalyearval.' AND reqtemp'.$userid.'.StoreId='.$storeId.'');
        //         foreach($gettemptable as $row){
        //             $eachqntval=$row->AvailableQuantity;
        //             $eachqnt[]=$row->AvailableQuantity;
        //             if($eachqntval<0){
        //                 $tempcntitemid[]=$row->ItemId;
        //                 $runqnt+=1;
        //             }
        //         }
        //         if($eachqntval<0){
        //             $totalitemid[]=$itemidvals;
        //             $totalqnt+=1;
        //         }
        //     }
        //     $tempididval=implode(',',$tempcntitemid);
        //     $totalitemidval=implode(',',$totalitemid);
        //     $totaluniqueval = count(array_unique(array_merge($tempcntitemid,$totalitemid)));

        //     if($runqnt>=1||$totalqnt>=1)
        //     {
        //         $allitems=$tempididval.",".$totalitemidval;
        //         $getItemLists=DB::select('SELECT DISTINCT regitems.Name,regitems.id AS ApprovedItems,regitems.id AS AvailableItems FROM regitems WHERE regitems.id IN('.$allitems.')');
        //         return Response::json(['valerror'=>"error",'countedval'=>$totaluniqueval,'countItems'=>$getItemLists]);
        //     }
        //     else
        //     {
        //         $syncToTransactionundoVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,Date) SELECT "'.$issid.'",ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Undo-Void","Goods","'.$docnum.'","'.$fiscalyr.'","'.Carbon::now()->toDateString().'" FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$findid);
        //         $updateTransactios=DB::select('update transactions set IsVoid=0 where HeaderId='.$issid.' AND TransactionType="Requisition" AND TransactionsType="Requisition"');
        //     }
        // }
        $updateStatus=DB::select('UPDATE requisitions SET requisitions.Status=OldStatus,UndoVoidBy="'.$user.'",UndoVoidDate="'.Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A').'",OldStatus="" where id='.$findid.'');
        actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Undo Void",'status'=>"Undo Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
        return Response::json(['success' => '1']);    
    }

    public function deleteRequisitionItem(Request $request, $id)
    {
        $headerid=$request->reqremoveheaderid;
        $reqItem = requisitiondetail::find($id);
        $reqItem->delete();
        $countitem = DB::table('requisitiondetails')->where('HeaderId', '=', $headerid)->get();
        $getCountItem = $countitem->count();
        return Response::json(['success' => 'Item Removed','Totalcount'=>$getCountItem]);
    }

    public function deleteRequisitionData(Request $request, $id)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $reqtype="Transfer";
        $req=requisition::find($id);
        $statusval=$req->Status;
        $storeId=$req->SourceStoreId;
        $fiscalyr=$req->fiscalyear;
        $docnum=$req->IssueDocNumber;    
        $validator = Validator::make($request->all(), [
            'Reason' => 'required',
        ]);

        if($validator->passes())
        {
            DB::beginTransaction();
            try{
                if($statusval == "Issued")
                {
                    // $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type','!=',$reqtype)->latest()->first();
                    // $issid=$issuecon->id;
                    $syncToTransactionVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT "'.$id.'",ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Void","Goods","'.$docnum.'","'.$fiscalyr.'","0","'.Carbon::now()->toDateString().'" FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$id);
                    //$updateTransactios=DB::select('UPDATE transactions SET IsVoid=1 WHERE HeaderId='.$issid.' AND TransactionType="Requisition" AND TransactionsType="Requisition"');
                }

                $updateStatus=DB::select('UPDATE requisitions SET OldStatus=Status WHERE id='.$id.'');
                $updateStatussec=DB::select('UPDATE requisitions SET Status=CONCAT("Void(",OldStatus,")"),VoidReason="'.$request->Reason.'",VoidBy="'.$user.'",VoidDate="'.Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A').'" where id='.$id.'');
                
                actions::insert([
                    'user_id' => $userid,
                    'pageid' => $id,
                    'pagename' => "requisition",
                    'action' => "Void",
                    'status' => "Void",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "$request->Reason",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'reqId' => $id,'fiscalyr' => $fiscalyr]);
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

    public function showReqDataCon($id)
    {
        $deststore="";
        $sourcestore="";
        $countval="";
        $issueval="";
        $approveval="";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $ids=$id;
        $reqprop = requisition::find($id);
        $createddateval = $reqprop->created_at;
        $product_type = $reqprop->Type;
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $reqHeader=DB::select('SELECT requisitions.id,requisitions.CompanyType AS CompType,requisitions.RequestReason AS ReqReason,requisitions.CustomerOrOwner AS CusId,requisitions.CustomerReceiver AS CusRec,requisitions.LabStation AS LabSt,IFNULL(prd_orders.ProductionOrderNumber,"") AS production_num,lookups.CompanyType,prdlookups.ProductType,reaslookups.RequestReason,requisitions.Reference,customers.Name AS CustomerName,customerrec.Name AS CustomerReceiverName,labstation.Name AS LabStation,requisitions.BookingNumber,requisitions.SourceStoreId,requisitions.Type,requisitions.DocumentNumber,requisitions.IssueDocNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,requisitions.Date,requisitions.RequestedBy,requisitions.Status,requisitions.Purpose,requisitions.Memo,requisitions.fiscalyear,requisitions.DriverName,requisitions.TruckPlateNo,requisitions.DriverPhoneNo,requisitions.DriverLicenseNo,requisitions.ContainerNo,requisitions.DispatchStatus FROM requisitions INNER JOIN stores as sstores ON requisitions.SourceStoreId=sstores.id INNER JOIN stores as dstores on requisitions.DestinationStoreId=dstores.id LEFT JOIN lookups ON requisitions.CompanyType=lookups.CommodityTypeValue LEFT JOIN lookups AS prdlookups ON requisitions.Type=prdlookups.ProductTypeValue LEFT JOIN lookups AS reaslookups ON requisitions.RequestReason=reaslookups.RequestReasonValue LEFT JOIN customers ON requisitions.CustomerOrOwner=customers.id LEFT JOIN customers AS customerrec ON requisitions.CustomerReceiver=customerrec.id LEFT JOIN stores AS labstation ON requisitions.LabStation=labstation.id LEFT JOIN prd_orders ON requisitions.productionId=prd_orders.id WHERE requisitions.id='.$id);
        foreach($reqHeader as $row)
        {
            $sourcestore=$row->SourceStoreId;
        }
        $getIssuedata=DB::select('SELECT COUNT(storeassignments.UserId) AS IssueFlag FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.StoreId='.$sourcestore.' AND storeassignments.Type=2');
        foreach($getIssuedata as $row)
        {
            $issueval=$row->IssueFlag;
        }
        $getApprovedata=DB::select('SELECT COUNT(storeassignments.UserId) AS ApproveFlag FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.StoreId='.$sourcestore.' AND storeassignments.Type=3');
        foreach($getApprovedata as $row)
        {
            $approveval=$row->ApproveFlag;
        }

        $strdata=store::findorFail($sourcestore);
        $fiscalyearstr=$strdata->FiscalYear;

        $reqDetail=DB::select('SELECT regitems.Name AS item_name,cmlookups.CommodityType AS CommType,grlookups.Grade AS GradeName,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,requisitiondetails.CommodityType AS CommTypeId,uoms.Name AS UomName,requisitiondetails.*,prlookups.ProcessType,crlookups.CropYear AS CropYearData,IFNULL(requisitiondetails.Memo,"") AS Memo,ROUND((requisitiondetails.NetKg/1000),2) AS WeightByTon,uoms.Name AS UomName,locations.Name AS LocationName,customers.Name AS SupplierName,customers.Code AS SupplierCode,customers.TinNumber AS SupplierTIN,requisitiondetails.ProductionOrderNo,IFNULL(requisitiondetails.CertNumber,"") AS CertNumber,IFNULL(requisitiondetails.ExportCertNumber,"") AS ExportCertNumber,VarianceShortage,VarianceOverage,requisitions.RequestReason,requisitions.CustomerOrOwner,uoms.uomamount,uoms.bagweight FROM requisitiondetails LEFT JOIN woredas ON requisitiondetails.CommodityId = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions on zones.Rgn_Id = regions.id LEFT JOIN uoms ON requisitiondetails.DefaultUOMId = uoms.id LEFT JOIN locations ON requisitiondetails.LocationId=locations.id LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN lookups AS grlookups ON requisitiondetails.Grade=grlookups.GradeValue LEFT JOIN lookups AS prlookups ON requisitiondetails.ProcessType=prlookups.ProcessTypeValue LEFT JOIN lookups AS crlookups ON requisitiondetails.CropYear=crlookups.CropYearValue LEFT JOIN lookups AS cmlookups ON requisitiondetails.CommodityType=cmlookups.CommodityTypeValue LEFT JOIN regitems ON requisitiondetails.ItemId=regitems.id LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.HeaderId='.$id.' ORDER BY requisitiondetails.id ASC');

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"requisition")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['reqHeader'=>$reqHeader,'reqDetail'=>$reqDetail,'fyear'=>$fyear,'issuecnt'=>$issueval,'approvecnt'=>$approveval,'fyearstr'=>$fiscalyearstr,'activitydata'=>$activitydata,'product_type' => $product_type]);       
    }

    public function requisitionForwardAction(Request $request)
    {
        $val_status = ["Draft","Pending","Verified","Approved","Issued","Received"];

        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;

            $sett = DB::table('settings')->latest()->first();
            $fiscalyrcomp = $sett->FiscalYear;

            $findid = $request->forwardReqId;
            $req = requisition::find($findid);
            $currentStatus = $req->Status;
            $newStatus = $request->newForwardStatusValue;
            $action = $request->forwardActionValue;
            $req->Status = $newStatus;
            $docnum = $req->DocumentNumber;
            $product_type = $req->ProductType;
            $fiscalyr = $req->fiscalyear;
            $storeid = $req->SourceStoreId;
            
            if($newStatus == "Verified"){
                $req->AuthorizedBy = $user;
                $req->AuthorizedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }

            if($newStatus == "Approved"){
                $req->ApprovedBy = $user;
                $req->ApprovedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }

            if($newStatus == "Issued"){
                $getApprovedQuantity = DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS approved_qty FROM requisitiondetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((SELECT SUM(COALESCE(StockIn,0)) - SUM(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeid.' AND transactions.FiscalYear='.$fiscalyr.'),0) - trs.Quantity) < 0');
                $avaq = $getApprovedQuantity[0]->approved_qty;

                if($avaq > 0){
                    $getitemlist = DB::select('SELECT regitems.Name AS approved_item FROM requisitiondetails AS trs LEFT JOIN regitems ON trs.ItemId=regitems.id LEFT JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((SELECT SUM(COALESCE(StockIn,0)) - SUM(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeid.' AND transactions.FiscalYear='.$fiscalyr.'),0) - trs.Quantity) < 0');
                    return Response::json(['valerror' => 465,'getitemlist' => $getitemlist]);
                }

                if($avaq == 0){
                    DB::select('INSERT INTO transactions(HeaderId,ItemId,uomId,StockOut,UnitPrice,BeforeTaxPrice,TaxAmountPrice,TotalPrice,ItemType,FiscalYear,StoreId,TransactionType,TransactionsType,Date,customers_id,LocationId,ArrivalDate,DocumentNumber,Memo) SELECT '.$findid.',ItemId,NewUOMId,Quantity,UnitCost,BeforeTaxCost,ROUND((BeforeTaxCost*(15/100)),2),ROUND(((BeforeTaxCost*(15/100)) + BeforeTaxCost),2),"Goods",'.$fiscalyr.','.$storeid.',"Requisition","Requisition","'.Carbon::now().'","1",LocationId,"'.Carbon::now().'","'.$docnum.'",Memo FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$findid);
                }

                $req->IssuedBy = $user;
                $req->IssuedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');

                $req->ReceivedBy = "";
                $req->ReceivedDate = "";

                // if($fiscalyr == $fiscalyrcomp){
                //     DB::select('UPDATE settings SET IssueNumber=IssueNumber+1 WHERE id=1');
                // }
            }

            if($newStatus == "Received"){
                $req->ReceivedBy = $user;
                $req->ReceivedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }

            $req->save();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "requisition",
                'action' => "$action",
                'status' => "$action",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            DB::commit();
            return Response::json(['success' => 1, 'rec_id' => $findid, 'fiscalyr' => $fiscalyr]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function requisitionBackwardAction(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->backwardReqId;
        $action = $request->backwardActionValue;
        $newStatus = $request->newBackwardStatusValue;
        $req = requisition::find($findid);
        $fiscalyr = $req->fiscalyear;
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();
            try{
                $req->Status = $newStatus;

                if($newStatus == "Issued"){
                    $req->ReceivedBy = "";
                    $req->ReceivedDate = "";
                }
                $req->save();

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "requisition",
                    'action' => "$action",
                    'status' => "$action",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "$request->CommentOrReason",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                
                DB::commit();
                return Response::json(['success' => 1, 'rec_id' =>  $findid, 'fiscalyr' => $fiscalyr]);
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

    public function pendingReqStatus(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->pendingid;
        $rec=requisition::find($findid);
        $rec->ChangeToPendingBy= $user;
        $rec->ChangeToPendingDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $rec->Status="Pending";
        $rec->save();
        actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Change to Pending",'status'=>"Change to Pending",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
        return Response::json(['success' => '1']);
    }

    public function backToVerifyReq(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtoverifyid;
        $recprop=requisition::find($findid);

        $validator = Validator::make($request->all(),[
            'BackToVerifyComment' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status=="Reviewed"){
                try{
                    $recprop->Status="Verified";
                    $recprop->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Back to Verify",'status'=>"Back to Verify",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToDraftComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function backToReviewReq(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtoreviewid;
        $recprop=requisition::find($findid);

        $validator = Validator::make($request->all(),[
            'BackToReviewComment' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status=="Approved"){
                try{
                    $recprop->Status="Reviewed";
                    $recprop->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Back to Review",'status'=>"Back to Review",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToReviewComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function backToDraftReq(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->draftid;
        $recprop=requisition::find($findid);

        $validator = Validator::make($request->all(),[
            'BackToDraftComment' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status=="Pending"){
                try{
                    $recprop->Status="Draft";
                    $recprop->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Back to Draft",'status'=>"Back to Draft",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToDraftComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function verifyCommReq(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $bookingcnt=0;
        $findid=$request->verifyId;
        $req=requisition::find($findid);
        if($req->Status=="Pending"){
            try{
                $req->Status="Verified";
                $req->AuthorizedBy=$user;
                $req->AuthorizedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $req->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Verified",'status'=>"Verified",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else{
            return Response::json(['statuserror' =>462]);
        }
    }

    public function approveCommReq(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $bookingcnt=0;
        $referencecnt=0;
        $cusreqcnt=0;
        $findid=$request->appId;
        $req=requisition::find($findid);

        if($req->RequestReason==3 && $req->CompanyType==1 && ($req->Reference==null || $req->Reference=="" || $req->Reference==NULL)){
            $referencecnt=1;
        }
        if($req->RequestReason==3 && $req->CompanyType==1 && ($req->BookingNumber==null || $req->BookingNumber=="" || $req->BookingNumber==NULL)){
            $bookingcnt=1;
        }
        if($req->RequestReason==3 && $req->CompanyType==1 && ($req->CustomerReceiver==null || $req->CustomerReceiver=="" || $req->CustomerReceiver==NULL || $req->CustomerReceiver==1)){
            $cusreqcnt=1; 
        }

        if($referencecnt==0 && $bookingcnt==0 && $cusreqcnt==0){
            $req->Status="Approved";
            $req->ApprovedBy=$user;
            $req->ApprovedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $req->save();
            actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Approved",'status'=>"Approved",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            return Response::json(['success' => '1']);
        }
        else if($referencecnt==1){
            return Response::json(['referenceerr' =>461]);
        }
        else if($bookingcnt==1){
            return Response::json(['bookingerr' =>462]);
        }
        else if($cusreqcnt==1){
            return Response::json(['cusreqerr' =>463]);
        }
    }

    public function reqBackToPending(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtopendingid;
        $recprop=requisition::find($findid);

        $validator = Validator::make($request->all(),[
            'BackToPendingComment' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status=="Verified"){
                try{
                    $recprop->Status="Pending";
                    $recprop->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Back to Pending",'status'=>"Back to Pending",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToPendingComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function reqRejectComm(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->rejId;
        $req=requisition::find($findid);
        $req->Status="Rejected";
        $req->RejectedBy= $user;
        $req->RejectedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $req->save();
        actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Rejected",'status'=>"Rejected",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
        return Response::json(['success' => '1']);
    }

    public function reqVoidComm(Request $request, $id)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $reqtype="Transfer";
        $req=requisition::find($id);
        $statusval=$req->Status;
        $storeId=$req->SourceStoreId;
        $fiscalyr=$req->fiscalyear;
        $docnum=$req->IssueDocNumber;    
        $validator = Validator::make($request->all(), [
            'Reason' =>'required',
        ]);
        if($validator->passes())
        {
            // if($statusval=="Issued")
            // {
            //     $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type','!=',$reqtype)->latest()->first();
            //     $issid=$issuecon->id;
            //     $syncToTransactionVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT "'.$issid.'",ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Void","Goods","'.$docnum.'","'.$fiscalyr.'","0","'.Carbon::now()->toDateString().'" FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$id);
            //     $updateTransactios=DB::select('update transactions set IsVoid=1 where HeaderId='.$issid.' AND TransactionType="Requisition" AND TransactionsType="Requisition"');
            // }
            $updateStatus=DB::select('UPDATE requisitions SET OldStatus=requisitions.Status WHERE id='.$id.'');
            $updateStatussec=DB::select('UPDATE requisitions SET requisitions.Status=CONCAT("Void(",OldStatus,")"),VoidReason="'.$request->Reason.'",VoidBy="'.$user.'",VoidDate="'.Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A').'" where id='.$id.'');
            actions::insert(['user_id'=>$userid,'pageid'=>$id,'pagename'=>"requisition",'action'=>"Void",'status'=>"Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Reason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            return Response::json(['success' => '1']);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }
    
    public function reqChangeToReview(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->reviewid;
        $req=requisition::find($findid);

        if($req->Status=="Verified"){
            try{
                $req->Status="Reviewed";
                $req->ReviewedBy= $user;
                $req->ReviewedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $req->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Reviewed",'status'=>"Reviewed",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else{
            return Response::json(['statuserror' =>462]);
        }
    }

    public function calcReqBalance(Request $request){
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
            $qtystockoutdata=requisitiondetail::leftJoin('requisitions','requisitiondetails.HeaderId','requisitions.id')
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
                                            ->where('requisitiondetails.HeaderId',$baseRecordId)
                                            ->where('requisitions.CustomerOrOwner',$cusOrOwner)
                                            ->first();

            $qtyothstockoutdata=requisitiondetail::leftJoin('requisitions','requisitiondetails.HeaderId','requisitions.id')
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
                                            ->where('requisitiondetails.HeaderId','!=',$baseRecordId)
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

            $adjdata=adjustmentdetail::leftJoin('adjustments','adjustmentdetails.HeaderId','adjustments.id')
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
                                            ->where('adjustments.customers_id',$cusOrOwner)
                                            ->whereIn('adjustments.Status',$adjstatus)
                                            ->select(DB::raw('SUM(COALESCE(adjustmentdetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(adjustmentdetails.NetKg,0)) AS NetKg'))
                                            ->groupBy('adjustmentdetails.CommodityType','adjustmentdetails.woredas_id','adjustmentdetails.Grade','adjustmentdetails.ProcessType','adjustmentdetails.CropYear','adjustmentdetails.StoreId','adjustmentdetails.SupplierId','adjustmentdetails.GrnNumber','adjustmentdetails.uoms_id')
                                            ->get();

        }
        else if($commtype==2 || $commtype==4 || $commtype==5 || $commtype==6){
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.LocationId='.$floormap.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.ItemType="Commodity" AND transactions.uomId='.$uom.' AND transactions.ProductionNumber="'.$prdordernumber.'" AND transactions.CertNumber="'.$certnumber.'" AND transactions.TransactionType!="On-Production" AND transactions.customers_id='.$cusOrOwner);
            $qtystockoutdata=requisitiondetail::leftJoin('requisitions','requisitiondetails.HeaderId','requisitions.id')
                                            ->where('requisitiondetails.CommodityType',$commtype)
                                            ->where('requisitiondetails.CommodityId',$origin)
                                            ->where('requisitiondetails.Grade',$grade)
                                            ->where('requisitiondetails.ProcessType',$processtype)
                                            ->where('requisitiondetails.CropYear',$cropyear)
                                            ->where('requisitiondetails.StoreId',$storeval)
                                            ->where('requisitiondetails.LocationId',$floormap)
                                            ->where('requisitiondetails.ProductionOrderNo',$prdordernumber)
                                            ->where('requisitiondetails.CertNumber',$certnumber)
                                            ->where('requisitiondetails.ExportCertNumber',$expcertnumber)
                                            ->where('requisitiondetails.DefaultUOMId',$uom)
                                            ->where('requisitiondetails.HeaderId',$baseRecordId)
                                            ->where('requisitions.CustomerOrOwner',$cusOrOwner)
                                            ->first();

            $qtyothstockoutdata=requisitiondetail::leftJoin('requisitions','requisitiondetails.HeaderId','requisitions.id')
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
                                            ->where('requisitiondetails.HeaderId','!=',$baseRecordId)
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

            $adjdata=adjustmentdetail::leftJoin('adjustments','adjustmentdetails.HeaderId','adjustments.id')
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
                                            ->where('adjustments.customers_id',$cusOrOwner)
                                            ->whereIn('adjustments.Status',$adjstatus)
                                            ->select(DB::raw('SUM(COALESCE(adjustmentdetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(adjustmentdetails.NetKg,0)) AS NetKg'))
                                            ->groupBy('adjustmentdetails.CommodityType','adjustmentdetails.woredas_id','adjustmentdetails.Grade','adjustmentdetails.ProcessType','adjustmentdetails.CropYear','adjustmentdetails.StoreId','adjustmentdetails.ProductionNumber','adjustmentdetails.CertNumber','adjustmentdetails.uoms_id')
                                            ->get();
        }
        else if($commtype==3){  // this add by new logic
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.LocationId='.$floormap.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.ItemType="Commodity" AND transactions.uomId='.$uom.' AND transactions.TransactionType!="On-Production" AND transactions.customers_id='.$cusOrOwner);
            $qtystockoutdata=requisitiondetail::leftJoin('requisitions','requisitiondetails.HeaderId','requisitions.id')
                                            ->where('requisitiondetails.CommodityType',$commtype)
                                            ->where('requisitiondetails.CommodityId',$origin)
                                            ->where('requisitiondetails.Grade',$grade)
                                            ->where('requisitiondetails.ProcessType',$processtype)
                                            ->where('requisitiondetails.CropYear',$cropyear)
                                            ->where('requisitiondetails.StoreId',$storeval)
                                            ->where('requisitiondetails.LocationId',$floormap)
                                            ->where('requisitiondetails.DefaultUOMId',$uom)
                                            ->where('requisitiondetails.HeaderId',$baseRecordId)
                                            ->where('requisitions.CustomerOrOwner',$cusOrOwner)
                                            ->first();

            $qtyothstockoutdata=requisitiondetail::leftJoin('requisitions','requisitiondetails.HeaderId','requisitions.id')
                                            ->where('requisitiondetails.CommodityType',$commtype)
                                            ->where('requisitiondetails.CommodityId',$origin)
                                            ->where('requisitiondetails.Grade',$grade)
                                            ->where('requisitiondetails.ProcessType',$processtype)
                                            ->where('requisitiondetails.CropYear',$cropyear)
                                            ->where('requisitiondetails.StoreId',$storeval)
                                            ->where('requisitiondetails.LocationId',$floormap)
                                            ->where('requisitiondetails.DefaultUOMId',$uom)
                                            ->where('requisitions.CustomerOrOwner',$cusOrOwner)
                                            ->where('requisitiondetails.HeaderId','!=',$baseRecordId)
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
            
            $adjdata=adjustmentdetail::leftJoin('adjustments','adjustmentdetails.HeaderId','adjustments.id')
                                            ->where('adjustmentdetails.CommodityType',$commtype)
                                            ->where('adjustmentdetails.woredas_id',$origin)
                                            ->where('adjustmentdetails.Grade',$grade)
                                            ->where('adjustmentdetails.ProcessType',$processtype)
                                            ->where('adjustmentdetails.CropYear',$cropyear)
                                            ->where('adjustmentdetails.StoreId',$storeval)
                                            ->where('adjustmentdetails.LocationId',$floormap)
                                            ->where('adjustmentdetails.uoms_id',$uom)
                                            ->where('adjustments.customers_id',$cusOrOwner)
                                            ->whereIn('adjustments.Status',$adjstatus)
                                            ->select(DB::raw('SUM(COALESCE(adjustmentdetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(adjustmentdetails.NetKg,0)) AS NetKg'))
                                            ->groupBy('adjustmentdetails.CommodityType','adjustmentdetails.woredas_id','adjustmentdetails.Grade','adjustmentdetails.ProcessType','adjustmentdetails.CropYear','adjustmentdetails.StoreId','adjustmentdetails.uoms_id')
                                            ->get();
        }
        
        //$averagecost=DB::select('SELECT ROUND((SUM(COALESCE(transactions.TotalCostComm,0)) / SUM(COALESCE(transactions.StockInComm,0))),2) AS AverageCost FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.TransactionsType IN("Beginning","Receiving","Adjustment","Production","Undo-Abort","Undo-Void") AND transactions.ItemType="Commodity" AND transactions.customers_id='.$cusOrOwner);
        //$avcost=$averagecost[0]->AverageCost ?? 0;

        $avcost = $this->calculateAverageCost($commtype,$origin,$grade,$processtype,$cropyear,$fyear,$cusOrOwner);
        
        $avbalancekg=$qtyonhandata[0]->AvailableBalanceKg ?? 0;
        $avbalancebag=$qtyonhandata[0]->AvailableBalanceBag ?? 0;

        $avothbalancekg=$qtyothstockoutdata[0]->NetKg ?? 0;
        $avothbalancebag=$qtyothstockoutdata[0]->NumOfBag ?? 0;

        //$prdbalancekg=$prdstockoutdata[0]->NetKg ?? 0;
        //$prdnumofbag=$prdstockoutdata[0]->NumOfBag ?? 0;

        $prdbalancekg = ($prdstockoutdata[0]->NetKg ?? 0) + ($adjdata[0]->NetKg ?? 0);
        $prdnumofbag = ($prdstockoutdata[0]->NumOfBag ?? 0) + ($adjdata[0]->NumOfBag ?? 0);

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

    public function fetchDispatchInfo(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $recId=$_POST['recId'];
        $recId = !empty($recId) ? $recId : 0;

        $requistiondata=DB::select('SELECT * FROM requisitions WHERE requisitions.id='.$recId);

        $reqdetaildata=DB::select('SELECT * FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$recId);
        
        return response()->json(['requistiondata'=>$requistiondata,'reqdetaildata'=>$reqdetaildata]);
    }

    public function fetchDispatchData(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $recId=$_POST['recId'];
        $recId = !empty($recId) ? $recId : 0;

        $disparentdata=DB::select('SELECT lookups.DispatchModeName,requisitions.DocumentNumber,dispatchparents.* FROM dispatchparents LEFT JOIN lookups ON dispatchparents.DispatchMode=lookups.DispatchModeValue LEFT JOIN requisitions ON dispatchparents.ReqId=requisitions.id WHERE dispatchparents.id='.$recId);

        $dispchilddata=DB::select('SELECT dispatchchildren.*,requisitiondetails.CommodityId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,CONCAT(IFNULL(customers.Name,""),", ",IFNULL(requisitiondetails.GrnNumber,""),", ",IFNULL(requisitiondetails.ProductionOrderNo,""),", ",IFNULL(requisitiondetails.CertNumber,""),", ",IFNULL(requisitiondetails.ExportCertNumber,""),", ",IFNULL(uoms.Name,"")) AS ConcatData,uoms.bagweight,uoms.uomamount,IFNULL(dispatchchildren.Remark,"") AS Remark FROM dispatchchildren LEFT JOIN requisitiondetails ON dispatchchildren.ReqDetailId=requisitiondetails.id LEFT JOIN woredas ON requisitiondetails.CommodityId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id WHERE dispatchchildren.dispatchparents_id='.$recId);        
        
        return response()->json(['disparentdata'=>$disparentdata,'dispchilddata'=>$dispchilddata]);
    }

    public function calcRemAmnt(Request $request){
        $origin=$_POST['origin'];
        $concatdata=$_POST['concatdata'];
        $reqid=$_POST['reqid'];
        $dispchid=$_POST['dispchid'];
        $currRowId=$_POST['currRowId'];

        $reqnumofbag=0;
        $reqtotalkg=0;
        $reqnetkg=0;

        $insnumofbag=0;
        $instotalkg=0;
        $insnetkg=0;

        $remnumofbag=0;
        $remtotalkg=0;
        $remnetkg=0;

        $origin = !empty($origin) ? $origin : 0;
        $concatdata = !empty($concatdata) ? $concatdata : 0;
        $reqid = !empty($reqid) ? $reqid : 0;
        $dispchid = !empty($dispchid) ? $dispchid : 0;
        $currRowId = !empty($currRowId) ? $currRowId : 0;

        $reqdetaildata=DB::select('SELECT requisitiondetails.*,uoms.uomamount,uoms.bagweight FROM requisitiondetails LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id WHERE requisitiondetails.id='.$concatdata);
        $reqnumofbag=$reqdetaildata[0]->NumOfBag ?? 0;
        $reqtotalkg=$reqdetaildata[0]->TotalKg ?? 0;
        $reqnetkg=$reqdetaildata[0]->NetKg ?? 0;

        $dispdetsum=DB::select('SELECT ROUND(SUM(COALESCE(dispatchchildren.NumOfBag,0)),2) AS NumOfBag,ROUND(SUM(COALESCE(dispatchchildren.TotalKG,0)),2) AS TotalKG,ROUND(SUM(COALESCE(dispatchchildren.NetKG,0)),2) AS NetKG FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.Status!="Void" AND dispatchchildren.id!='.$currRowId.' AND dispatchchildren.ReqDetailId='.$concatdata);
        $insnumofbag=$dispdetsum[0]->NumOfBag ?? 0;
        $instotalkg=$dispdetsum[0]->TotalKG ?? 0;
        $insnetkg=$dispdetsum[0]->NetKG ?? 0;
        
        $remnumofbag=round(($reqnumofbag-$insnumofbag),2);
        $remtotalkg=round(($reqtotalkg-$instotalkg),2);
        $remnetkg=round(($reqnetkg-$insnetkg),2);

        return response()->json(['reqdetaildata'=>$reqdetaildata,'remnumofbag'=>$remnumofbag,'remtotalkg'=>$remtotalkg,'remnetkg'=>$remnetkg]);
    }

    public function issueRequisitionComm(Request $request)
    {
        $comparestorefy = 0;
        $fiscalyears = null;
        $fiscalyrcomp = null;
        $desfiscalyears = null;
        $isstype = "Transfer";
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $issuepr = "";
        $avaq = 0;

        $findid = $request->issueId;
        $reqcon = DB::table('requisitions')->where('id', $findid)->latest()->first();
        $storeId = $reqcon->SourceStoreId;
        if($storeId != null){
            $strdata=store::findorFail($storeId);
            $fiscalyears=$strdata->FiscalYear;
        }

        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $fiscalyrcomp=$settingsval->FiscalYear;

        if($storeId!=null && $fiscalyr==$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $issuepr=$settingsval->IssuePrefix;
            $issuenum=$settingsval->IssueNumber;
            $fiscalyr=$settingsval->FiscalYear;
        }

        if($storeId!=null && $fiscalyr!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $issueprop = DB::table('issues')->where('fiscalyear',$fiscalyears)->where('Type','!=',$isstype)->orderBy('id', 'desc')->first();
            $issuenum = "";
            $fiscalyr = $fiscalyears;
        }
       
        $suffixdoc = $fiscalyr-2000;
        $suffixdocs = $suffixdoc+1;
        $numberPadding = sprintf("%05d", $issuenum);
        $issuedocnum = $issuepr.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        
        $docnum = $reqcon->DocumentNumber;
        $comm = $reqcon->Common;
        $product_type = $reqcon->Type;
        $customer_id = $reqcon->CustomerOrOwner;

        if($product_type == 1){
            $getApprovedQuantity = DB::select('SELECT COUNT(DISTINCT trs.CommodityId,trs.CommodityType,trs.Grade,trs.ProcessType,trs.CropYear,trs.DefaultUOMId,trs.LocationId) AS approved_qty FROM requisitiondetails AS trs LEFT JOIN requisitions ON trs.HeaderId=requisitions.id LEFT JOIN woredas ON trs.CommodityId=woredas.id WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((SELECT SUM(COALESCE(StockInComm,0))-SUM(COALESCE(StockOutComm,0)) FROM transactions WHERE transactions.woredaId=trs.CommodityId AND transactions.CommodityType=trs.CommodityType AND transactions.Grade=trs.Grade AND transactions.ProcessType=trs.ProcessType AND transactions.CropYear=trs.CropYear AND transactions.StoreId=trs.StoreId AND transactions.LocationId=trs.LocationId AND transactions.uomId=trs.DefaultUOMId AND transactions.customers_id=requisitions.CustomerOrOwner AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.NetKg)<0');
            $avaq = $getApprovedQuantity[0]->approved_qty;
        }
        else if($product_type == 2){
            $getApprovedQuantity = DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS approved_qty FROM requisitiondetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((SELECT SUM(COALESCE(StockIn,0)) - SUM(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.LocationId=trs.LocationId AND transactions.StoreId='.$storeId.' AND transactions.customers_id='.$customer_id.' AND transactions.FiscalYear='.$fiscalyr.'),0) - trs.Quantity) < 0');
            $avaq = $getApprovedQuantity[0]->approved_qty;
        }
        
        $avaqp = (float)$avaq;

        if($avaqp >= 1)
        {
            if($product_type == 1){
                $getcommlist = DB::select('SELECT CONCAT(IFNULL(regions.Rgn_Name,""),",	",IFNULL(zones.Zone_Name,""),",	",IFNULL(woredas.Woreda_Name,""),",	",IFNULL(commlookup.CommodityType,""),",	",IFNULL(grdlookup.Grade,""),",	",IFNULL(crplookup.CropYear,""),",	",IFNULL(trs.ProcessType,""),",	",IFNULL(uoms.Name,""),",	",IFNULL(locations.Name,"")) AS Origin FROM requisitiondetails AS trs LEFT JOIN requisitions ON trs.HeaderId=requisitions.id LEFT JOIN woredas ON trs.CommodityId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN lookups AS grdlookup ON trs.Grade=grdlookup.GradeValue LEFT JOIN lookups AS commlookup ON trs.CommodityType=commlookup.CommodityTypeValue LEFT JOIN lookups AS crplookup ON trs.CropYear=crplookup.CropYearValue LEFT JOIN uoms ON trs.DefaultUOMId=uoms.id LEFT JOIN locations ON trs.LocationId=locations.id WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((SELECT SUM(COALESCE(StockInComm,0))-SUM(COALESCE(StockOutComm,0)) FROM transactions WHERE transactions.woredaId=trs.CommodityId AND transactions.CommodityType=trs.CommodityType AND transactions.Grade=trs.Grade AND transactions.ProcessType=trs.ProcessType AND transactions.CropYear=trs.CropYear AND transactions.StoreId=trs.StoreId AND transactions.LocationId=trs.LocationId AND transactions.uomId=trs.DefaultUOMId AND transactions.customers_id=requisitions.CustomerOrOwner AND transactions.FiscalYear='.$fiscalyr.'),0) - trs.NetKg) < 0');
                return Response::json(['valerror' => "error",'countedval' => $avaqp,'getcommlist' => $getcommlist,'product_type' => $product_type]);
            }
            else if($product_type == 2){
                $getgoodslist = DB::select('SELECT regitems.Name AS approved_item FROM requisitiondetails AS trs LEFT JOIN regitems ON trs.ItemId=regitems.id LEFT JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((SELECT SUM(COALESCE(StockIn,0)) - SUM(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.LocationId=trs.LocationId AND transactions.StoreId='.$storeId.' AND transactions.customers_id='.$customer_id.' AND transactions.FiscalYear='.$fiscalyr.'),0) - trs.Quantity) < 0');
                return Response::json(['valerror' => "error",'countedval' => $avaqp,'getgoodslist' => $getgoodslist,'product_type' => $product_type]);
            }
        }
        else
        {
            DB::beginTransaction();

            try{
                $currentdatetime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                
                if($product_type == 1){
                    $syncTransaction = DB::select('INSERT INTO transactions(HeaderId,woredaId,uomId,CommodityType,Grade,ProcessType,CropYear,StockOutComm,StockOutNumOfBag,StockOutFeresula,UnitPriceComm,TotalPriceComm,TaxPriceComm,GrandTotalPriceComm,ItemType,FiscalYear,Memo,StoreId,TransactionType,TransactionsType,Date,customers_id,LocationId,ArrivalDate,SupplierId,GrnNumber,CertNumber,ProductionNumber,DocumentNumber,VarianceShortage,VarianceOverage,BagWeight,created_at,updated_at) SELECT '.$findid.',CommodityId,DefaultUOMId,CommodityType,Grade,ProcessType,CropYear,NetKg,NumOfBag,Feresula,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,"Commodity",'.$reqcon->fiscalyear.',Memo,'.$storeId.',"Requisition","Requisition","'.Carbon::now().'",'.$reqcon->CustomerOrOwner.',LocationId,"'.Carbon::now().'",SupplierId,GrnNumber,CertNumber,ProductionOrderNo,"'.$reqcon->DocumentNumber.'",VarianceShortage,VarianceOverage,BagWeight,"'.Carbon::now().'","'.Carbon::now().'" FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$findid);
                }
                else if($product_type == 2){
                    $syncTransaction = DB::select('INSERT INTO transactions(HeaderId,ItemId,uomId,StockOut,UnitPrice,BeforeTaxPrice,TaxAmountPrice,TotalPrice,ItemType,FiscalYear,StoreId,TransactionType,TransactionsType,Date,customers_id,LocationId,ArrivalDate,DocumentNumber,Memo) SELECT '.$findid.',ItemId,NewUOMId,Quantity,UnitCost,BeforeTaxCost,ROUND((BeforeTaxCost*(15/100)),2),ROUND(((BeforeTaxCost*(15/100)) + BeforeTaxCost),2),"Goods",'.$reqcon->fiscalyear.','.$storeId.',"Requisition","Requisition","'.Carbon::now().'",'.$customer_id.',LocationId,"'.Carbon::now().'","'.$docnum.'",Memo FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$findid);
                }
                DB::table('requisitions')
                    ->where('id',$findid)
                    ->update(['IssueDocNumber'=>$reqcon->DocumentNumber,'Status' => "Issued",'IssuedBy'=>$user,'IssuedDate'=>$currentdatetime]);

                if($fiscalyr == $fiscalyrcomp){
                    $updn=DB::select('update settings set IssueNumber=IssueNumber+1 where id=1');
                }
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"requisition",'action'=>"Issued",'status'=>"Issued",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
                DB::commit();
                return Response::json(['success' => '1','recdata'=>$findid]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
    }

    public function voidDispatchData(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->voiddispid;
        $recprop=dispatchparent::find($findid);

        $validator = Validator::make($request->all(),[
            'DispatchReason' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status!="Void"){
                try{
                    $recprop->OldStatus=$recprop->Status;
                    $recprop->Status="Void(".$recprop->OldStatus.")";
                    $recprop->save();
                    $this->updateDispatchStatus($recprop->ReqId);
                    $this->updateDispatchQuantity($recprop->ReqId);
                    actions::insert(['user_id'=>$userid,'pageid'=>$recprop->ReqId,'pagename'=>"requisition",'action'=>"Void (Dispatch)",'status'=>"Void (Dispatch)",'reason'=>"$request->DispatchReason",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function undoVoidDispatchData(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->dispundovoidid;
        $recprop=dispatchparent::find($findid);

        $dispdetsum=DB::select('SELECT ROUND(SUM(COALESCE(dispatchchildren.NumOfBag,0)),2) AS NumOfBag,ROUND(SUM(COALESCE(dispatchchildren.TotalKG,0)),2) AS TotalKG,ROUND(SUM(COALESCE(dispatchchildren.NetKG,0)),2) AS NetKG FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.ReqId='.$recprop->ReqId);
        $insnumofbag=$dispdetsum[0]->NumOfBag ?? 0;
        $instotalkg=$dispdetsum[0]->TotalKG ?? 0;
        $insnetkg=$dispdetsum[0]->NetKG ?? 0;

        $reqdetaildata=DB::select('SELECT ROUND(SUM(COALESCE(requisitiondetails.NumOfBag,0)),2) AS NumOfBag,ROUND(SUM(COALESCE(requisitiondetails.TotalKG,0)),2) AS TotalKG,ROUND(SUM(COALESCE(requisitiondetails.NetKG,0)),2) AS NetKG FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$recprop->ReqId);
        $reqnumofbag=$reqdetaildata[0]->NumOfBag ?? 0;
        $reqtotalkg=$reqdetaildata[0]->TotalKG ?? 0;
        $reqnetkg=$reqdetaildata[0]->NetKG ?? 0;

        $insnumofbag = !empty($insnumofbag) ? $insnumofbag : 0;
        $instotalkg = !empty($instotalkg) ? $instotalkg : 0;
        $insnetkg = !empty($insnetkg) ? $insnetkg : 0;

        $reqnumofbag = !empty($reqnumofbag) ? $reqnumofbag : 0;
        $reqtotalkg = !empty($reqtotalkg) ? $reqtotalkg : 0;
        $reqnetkg = !empty($reqnetkg) ? $reqnetkg : 0;

        if($instotalkg>$reqtotalkg){
            return Response::json(['discerror'=>462]);
        }
        else{
            try{
                $recprop->Status=$recprop->OldStatus;
                $recprop->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$recprop->ReqId,'pagename'=>"requisition",'action'=>"Undo Void (Dispatch)",'status'=>"Undo Void (Dispatch)",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                $this->updateDispatchStatus($recprop->ReqId);
                $this->updateDispatchQuantity($recprop->ReqId);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
    }

    public function verifyDispatch(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->dispverifiedid;
        $recprop=dispatchparent::find($findid);
        if($recprop->Status=="Pending"){
            try{
                $recprop->Status="Verified";
                $recprop->OldStatus="Verified";
                $recprop->VerifiedBy = $user;
                $recprop->VerifiedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $recprop->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$recprop->ReqId,'pagename'=>"requisition",'action'=>"Verified (Dispatch)",'status'=>"Verified (Dispatch)",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else{
            return Response::json(['statuserror' =>462]);
        }
    }

    public function BacktoPendingDispatch(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtopendingidval;
        $recprop=dispatchparent::find($findid);

        $validator = Validator::make($request->all(),[
            'BackToPendingReason' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status=="Verified"){
                try{
                    $recprop->Status="Pending";
                    $recprop->OldStatus="Pending";
                    $recprop->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$recprop->ReqId,'pagename'=>"requisition",'action'=>"Back to Pending (Dispatch)",'status'=>"Back to Pending (Dispatch)",'reason'=>"$request->BackToPendingReason",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function approveDispatch(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->dispapproveid;
        $recprop=dispatchparent::find($findid);
        
        if($recprop->Status=="Verified"){
            try{
                $recprop->Status="Approved";
                $recprop->OldStatus="Approved";
                $recprop->ApprovedBy = $user;
                $recprop->ApprovedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $recprop->save();
                $this->updateDispatchStatus($recprop->ReqId);
                $this->updateDispatchQuantity($recprop->ReqId);
                actions::insert(['user_id'=>$userid,'pageid'=>$recprop->ReqId,'pagename'=>"requisition",'action'=>"Approved (Dispatch)",'status'=>"Approved (Dispatch)",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else{
            return Response::json(['statuserror' =>462]);
        }
    }

    public function showCommData($id)
    {
        $commdata=DB::select('SELECT regitems.Name AS item_name,cmlookups.CommodityType AS CommType,grlookups.Grade AS GradeName,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,requisitiondetails.CommodityType AS CommTypeId,uoms.Name AS UomName,requisitiondetails.*,prlookups.ProcessType,crlookups.CropYear AS CropYearData,IFNULL(requisitiondetails.Memo,"") AS Memo,ROUND((requisitiondetails.NetKg/1000),2) AS WeightByTon,uoms.Name AS UomName,locations.Name AS LocationName,customers.Name AS SupplierName,customers.Code AS SupplierCode,customers.TinNumber AS SupplierTIN,requisitiondetails.ProductionOrderNo,IFNULL(requisitiondetails.CertNumber,"") AS CertNumber,IFNULL(requisitiondetails.ExportCertNumber,"") AS ExportCertNumber,VarianceShortage,VarianceOverage,requisitions.RequestReason,requisitions.CustomerOrOwner,uoms.uomamount,uoms.bagweight FROM requisitiondetails LEFT JOIN woredas ON requisitiondetails.CommodityId = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions on zones.Rgn_Id = regions.id LEFT JOIN uoms ON requisitiondetails.DefaultUOMId = uoms.id LEFT JOIN locations ON requisitiondetails.LocationId=locations.id LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN lookups AS grlookups ON requisitiondetails.Grade=grlookups.GradeValue LEFT JOIN lookups AS prlookups ON requisitiondetails.ProcessType=prlookups.ProcessTypeValue LEFT JOIN lookups AS crlookups ON requisitiondetails.CropYear=crlookups.CropYearValue LEFT JOIN lookups AS cmlookups ON requisitiondetails.CommodityType=cmlookups.CommodityTypeValue LEFT JOIN regitems ON requisitiondetails.ItemId=regitems.id LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.HeaderId='.$id.' ORDER BY requisitiondetails.id ASC');
        return datatables()->of($commdata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showDispatchData($id)
    {
        $dispdata=DB::select('SELECT lookups.DispatchModeName,dispatchparents.*,requisitions.Status AS ReqStatus FROM dispatchparents LEFT JOIN lookups ON dispatchparents.DispatchMode=lookups.DispatchModeValue LEFT JOIN requisitions ON dispatchparents.ReqId=requisitions.id WHERE dispatchparents.ReqId='.$id.' ORDER BY dispatchparents.id DESC');
        return datatables()->of($dispdata)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {
            $user=Auth()->user();
            $dispedit='';
            $dispvoid='';
            $dispundovoid='';
            $disprintln='';
            if($data->Status=='Pending' || $data->Status=='Verified'){
                if($user->can('Manage-Dispatch-Information')){
                    $dispedit='<a class="dropdown-item editDispatch" data-id="'.$data->id.'" id="editDispatch'.$data->id.'" onclick="editDispatchFn('.$data->id.')" title="Edit dispatch record">
                        <i class="fa fa-edit"></i><span> Edit</span>  
                    </a>';
                }
                if($user->can('Void-Dispatch')){
                    $dispvoid='<a class="dropdown-item voidDispatch" data-id="'.$data->id.'" id="voidDispatch'.$data->id.'" onclick="voidDispatchFn('.$data->id.')" title="Void dispatch record">
                        <i class="fa fa-trash"></i><span> Void</span>  
                    </a>';
                }
                $dispundovoid='';
                $disprintln='';
            }
            else if($data->Status=='Approved'){
                if($user->can('Void-Dispatch')){
                    $dispvoid='<a class="dropdown-item voidDispatch" data-id="'.$data->id.'" id="voidDispatch'.$data->id.'" onclick="voidDispatchFn('.$data->id.')" title="Void dispatch record">
                        <i class="fa fa-trash"></i><span> Void</span>  
                    </a>';
                }
                $dispedit='';
                $dispundovoid='';
                $disprintln=' <a class="dropdown-item printDispatchAttachment" href="javascript:void(0)" data-link="/dispatt/'.$data->id.'" data-id="'.$data->id.'" id="printDispatch'.$data->id.'" title="Print Dispatch Voucher"><i class="fa fa-file"></i><span> Print Dispatch Voucher</span></a>';
            }
            else if($data->Status=='Void' || $data->Status=='Void(Pending)' || $data->Status=='Void(Verified)' || $data->Status=='Void(Approved)'){
                if($user->can('Void-Dispatch')){
                    $dispundovoid='<a class="dropdown-item undoVoidDispatch" onclick="undoVoidDispatchFn('.$data->id.')" data-id="'.$data->id.'" id="undoVoidDispatch'.$data->id.'" title="Open dispatch undo void confirmation window">
                        <i class="fa fa-undo"></i><span> Undo Void</span>  
                    </a>';
                }
                $dispedit='';
                $dispvoid='';
                $disprintln='';
            }

            $btn='<div class="btn-group dropleft">
            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item infoDispatch" data-id="'.$data->id.'" id="infoDispatch'.$data->id.'" onclick="infoDispatchFn('.$data->id.',1)" title="Open dispatch information window">
                    <i class="fa fa-info"></i><span> Info</span>  
                </a>
                '.$dispedit.'
                '.$dispvoid.'
                '.$dispundovoid.'
                '.$disprintln.'
            </div>
            </div>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showInfoDispatchData($id)
    {
        $dispdata=DB::select('SELECT lookups.DispatchModeName,dispatchparents.* FROM dispatchparents LEFT JOIN lookups ON dispatchparents.DispatchMode=lookups.DispatchModeValue WHERE dispatchparents.ReqId='.$id.' ORDER BY dispatchparents.id DESC');
        return datatables()->of($dispdata)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {
            $user=Auth()->user();
            $disprintln='';
            if($data->Status=='Approved'){
                $disprintln=' <a class="dropdown-item printDispatchAttachment" href="javascript:void(0)" data-link="/dispatt/'.$data->id.'" data-id="'.$data->id.'" id="printDispatch'.$data->id.'" title="Print Dispatch Voucher"><i class="fa fa-file"></i><span> Print Dispatch Voucher</span></a>';
            }
            $btn='<div class="btn-group dropleft">
            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item infoDispatch" data-id="'.$data->id.'" id="infoDispatch'.$data->id.'" onclick="infoDispatchFn('.$data->id.',2)" title="Open dispatch information window">
                    <i class="fa fa-info"></i><span> Info</span>  
                </a>
                '.$disprintln.'
            </div>
            </div>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showDispatchDetailData($id)
    {
        $commdetaildata=DB::select('SELECT dispatchchildren.*,requisitiondetails.CommodityId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,IFNULL(customers.Name,"") AS SupplierName,IFNULL(requisitiondetails.GrnNumber,"") AS GrnNumber,IFNULL(requisitiondetails.ProductionOrderNo,"") AS ProductionOrderNo,IFNULL(requisitiondetails.CertNumber,"") AS CertNumber,IFNULL(requisitiondetails.ExportCertNumber,"") AS ExportCertNumber,IFNULL(uoms.Name,"") AS UOM,CONCAT(IFNULL(customers.Name,""),", ",IFNULL(requisitiondetails.GrnNumber,""),", ",IFNULL(requisitiondetails.ProductionOrderNo,""),", ",IFNULL(requisitiondetails.CertNumber,""),", ",IFNULL(requisitiondetails.ExportCertNumber,""),", ",IFNULL(uoms.Name,"")) AS ConcatData,uoms.bagweight,uoms.uomamount,IFNULL(dispatchchildren.Remark,"") AS Remark FROM dispatchchildren LEFT JOIN requisitiondetails ON dispatchchildren.ReqDetailId=requisitiondetails.id LEFT JOIN woredas ON requisitiondetails.CommodityId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id WHERE dispatchchildren.dispatchparents_id='.$id.' ORDER BY dispatchchildren.id DESC');        
        return datatables()->of($commdetaildata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showReqDetailData($id)
    {
        $detailTable=DB::select('SELECT requisitiondetails.id,requisitiondetails.ItemId,requisitiondetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,requisitiondetails.Quantity,requisitiondetails.PartNumber,uoms.Name as UOM,requisitiondetails.Quantity,requisitiondetails.Memo FROM requisitiondetails INNER JOIN regitems ON requisitiondetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where requisitiondetails.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function requisitiondatafy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $req=DB::select('SELECT requisitions.id,requisitions.Type,requisitions.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,requisitions.Date,requisitions.RequestedBy,requisitions.Status,requisitions.Purpose,requisitions.created_at,requisitions.OldStatus,requisitions.IssueDocNumber,requisitions.IssueId FROM requisitions INNER JOIN stores as sstores ON requisitions.SourceStoreId=sstores.id INNER JOIN stores as dstores on requisitions.DestinationStoreId=dstores.id WHERE requisitions.fiscalyear='.$fy.' AND requisitions.SourceStoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type IN(2,3,7)) ORDER BY requisitions.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editln='';
                $deleteln='';
                $println='';
                $sivln='';
                $unvoidvlink='';
                if($data->Status=='Issued')
                {
                    $editln='';
                    if($user->can('Void-Requisition-After-Issue'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    $println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRV</span></a>';
                    $sivln=' <a class="dropdown-item printSIVAttachment" href="javascript:void(0)" data-link="/iss/'.$data->IssueId.'" id="printSIV" data-attr="" title="Print Store Issue Voucher Attachment"><i class="fa fa-file"></i><span> Print SIV</span></a>';
                    $unvoidvlink='';
                }
                else if($data->Status=='Pending')
                {
                    if($user->can('Requisition-Edit'))
                    {
                        $editln='  <a class="dropdown-item editRequisitionRecord" onclick="editreqdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Requisition-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    $println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Approved')
                {
                    $editln='';
                    if($user->can('Requisition-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    $println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Commented')
                {
                    if($user->can('Requisition-Edit'))
                    {
                        $editln='  <a class="dropdown-item editRequisitionRecord" onclick="editreqdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    $deleteln='';
                    $println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Corrected')
                {
                    if($user->can('Requisition-Edit'))
                    {
                        $editln='  <a class="dropdown-item editRequisitionRecord" onclick="editreqdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    $deleteln='';
                    $println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                } 
                else if($data->Status=='Rejected')
                {
                    $editln='';
                    $deleteln='';
                    $println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                if($data->Status=='Void'||$data->Status=='Void(Pending)'||$data->Status=='Void(Approved)'||$data->Status=='Void(Issued)')
                {
                    $editln='';
                    $deleteln='';
                    $println=' <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/'.$data->id.'" id="printSRV" data-attr="" title="Print Store Requisition Voucher Attachment"><i class="fa fa-file"></i><span> Print SRV</span></a>';
                    $sivln='';
                    if($data->Status=='Void'||$data->Status=='Void(Pending)'||$data->Status=='Void(Approved)'){
                        if($user->can('Requisition-Void'))
                        {
                            $unvoidvlink= '<a class="dropdown-item undovoidln" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                        }
                    }
                    if($data->Status=='Void(Issued)'){
                        if($user->can('Void-Requisition-After-Issue'))
                        {
                            $unvoidvlink= '<a class="dropdown-item undovoidln" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                        }
                    } 
                }
                $btn='<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item DocReqInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title="">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$editln.'
                        '.$deleteln.' 
                        '.$unvoidvlink.' 
                        '.$println.' 
                        '.$sivln.' 
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
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
