<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\adjustment;
use App\Models\adjustmentdetail;
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
use App\Models\requisition;
use App\Models\requisitiondetail;
use App\Models\transaction;
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

class ProductionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $overagepercent;
    public $shortagepercent;

    public $disoveragepercent;
    public $disshortagepercent;

    public function __construct(){
        $this->overagepercent=10;
        $this->shortagepercent=0;

        $this->disoveragepercent=10;
        $this->disshortagepercent=0;
    }

    public function index(Request $request)
    { 
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $currentdate=Carbon::today()->toDateString();
        $customercategory=["Customer","Customer&Supplier"];

        $customerdata = customer::orderBy("Name","ASC")->where("ActiveStatus","Active")->whereIn("CustomerCategory",$customercategory)->get();
        
        $bomdata = prd_bomchild::join('prd_boms','prd_bomchildren.prd_boms_id','prd_boms.id')->where('prd_bomchildren.Status',"Active")->where('prd_boms.Status',"Active")->get(['prd_bomchildren.id','prd_boms.BomNumber','prd_boms.BomName','prd_bomchildren.BomChildName']);
        //$origin=DB::select('SELECT woredas.id,CONCAT(zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE woredas.id>1');
        $origin = DB::select('SELECT woredas.Type,woredas.id,CONCAT_WS(", ", NULLIF(regions.Rgn_Name, ""), NULLIF(zones.Zone_Name, ""), NULLIF(woredas.Woreda_Name, "")) AS Origin,woredas.Type AS CommType FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE woredas.status="Active"');
        $storedata = store::where("id",'>',1)->where("ActiveStatus","Active")->orderBy("Name","ASC")->get();
        $storedatadytbl = DB::select('SELECT DISTINCT transactions.StoreId,stores.Name FROM transactions INNER JOIN stores ON transactions.StoreId=stores.id WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND stores.ActiveStatus="Active"');
        $uomdata = uom::orderBy("Name","ASC")->where("ActiveStatus","Active")->get();
        //$origindatasrc=DB::select('SELECT woredas.id,woredas.Woreda_Name AS Origin,"1" AS CommType FROM woredas WHERE woredas.id=1 UNION SELECT woredas.id,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,"2" AS CommType FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE woredas.id>1');
        $origindatasrc = DB::select('SELECT woredas.id,CONCAT_WS(", ", NULLIF(regions.Rgn_Name, ""), NULLIF(zones.Zone_Name, ""), NULLIF(woredas.Woreda_Name, "")) AS Origin,woredas.Type AS CommType FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE woredas.status="Active"');
        $users = User::where("id",'>',1)->where("Status","Active")->orderBy("FullName","ASC")->get();
        $fiscalyears = DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $prdstoredata = store::where("id",'>',1)->where("ActiveStatus","Active")->orderBy("Name","ASC")->get();
        $locationdatasrc = DB::select('SELECT * FROM locations WHERE locations.ActiveStatus="Active" ORDER BY locations.Name ASC');
        $prdDetailDataSrc = DB::select('SELECT DISTINCT prd_order_details.prd_orders_id,prd_order_details.CommodityType AS CommTypeId,lookups.CommodityType AS CommodityTypeName FROM prd_order_details LEFT JOIN lookups ON prd_order_details.CommodityType=lookups.CommodityTypeValue');
        $prdCommodityDataSrc = DB::select('SELECT DISTINCT prd_order_details.prd_orders_id,prd_order_details.woredas_id,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Region FROM prd_order_details INNER JOIN woredas ON prd_order_details.woredas_id=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id');
        $prdGradeDataSrc = DB::select('SELECT DISTINCT prd_order_details.prd_orders_id,prd_order_details.woredas_id,prd_order_details.Grade,grdlookup.Grade AS GradeName FROM prd_order_details LEFT JOIN lookups AS grdlookup ON prd_order_details.CommodityType=grdlookup.GradeValue');
        $prdProcessTypeDataSrc = DB::select('SELECT DISTINCT prd_order_details.prd_orders_id,prd_order_details.woredas_id,prd_order_details.ProcessType FROM prd_order_details');
        $prdCropYearDataSrc = DB::select('SELECT DISTINCT prd_order_details.prd_orders_id,prd_order_details.woredas_id,prd_order_details.CropYear FROM prd_order_details');
        $prdStoreDataSrc = DB::select('SELECT DISTINCT prd_order_details.prd_orders_id,prd_order_details.woredas_id,prd_order_details.stores_id,stores.Name AS StoreName FROM prd_order_details INNER JOIN stores ON prd_order_details.stores_id=stores.id');
        $prepCoffeeTypeDataSrc = DB::select('SELECT prd_orders.id,woredas.id AS WId,CONCAT(zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM prd_orders INNER JOIN woredas on prd_orders.woredas_id=woredas.id INNER JOIN zones on woredas.zone_id=zones.id');
        $prdUomDataSrc = uom::orderBy("Name","ASC")->where("ActiveStatus","Active")->get();
        $prdOrderDataSrc = DB::select('SELECT * FROM prd_order_certs');
        $prdSupplierDataSrc = DB::select('SELECT DISTINCT customers.id,customers.Code,customers.Name,customers.TinNumber,CONCAT(transactions.woredaId,transactions.Grade,transactions.ProcessType,transactions.CropYear,transactions.customers_id) AS MergedData FROM transactions LEFT JOIN customers ON transactions.SupplierId=customers.id WHERE transactions.SupplierId>0');
        $prdGrnNumberDataSrc = DB::select('SELECT DISTINCT transactions.GrnNumber,CONCAT(transactions.woredaId,transactions.Grade,transactions.ProcessType,transactions.CropYear,transactions.customers_id,transactions.SupplierId) AS MergedData FROM transactions LEFT JOIN customers ON transactions.SupplierId=customers.id WHERE transactions.SupplierId>0');
        $prdProductionDataSrc = DB::select('SELECT DISTINCT transactions.ProductionNumber,CONCAT(transactions.woredaId,transactions.Grade,transactions.ProcessType,transactions.CropYear,transactions.customers_id,transactions.CommodityType) AS MergedData FROM transactions WHERE transactions.CertNumber!="" OR transactions.ProductionNumber!=null');
        $prdCertNumberDataSrc = DB::select('SELECT DISTINCT transactions.CertNumber,CONCAT(transactions.woredaId,transactions.Grade,transactions.ProcessType,transactions.CropYear,transactions.customers_id,transactions.CommodityType,transactions.ProductionNumber) AS MergedData FROM transactions WHERE transactions.CertNumber!="" OR transactions.CertNumber!=null');
        $expdefaltuomDataSrc = uom::orderBy("Name","ASC")->where("ActiveStatus","Active")->get();
        $prdbiproduct = prd_biproduct::orderBy("BiProductName","ASC")->where("Status","Active")->get();
        $floormapdatasrc = DB::select('SELECT * FROM locations WHERE locations.ActiveStatus="Active" ORDER BY locations.Name ASC');
        $exporttypedata = DB::select('SELECT lookups.CommodityTypeValue,lookups.CommodityType,lookups.CommodityTypeStatus FROM lookups WHERE lookups.CommodityTypeValue IN (2,4,5,6) AND lookups.CommodityTypeStatus="Active"');

        $commtypedata=DB::select('SELECT lookups.CommodityTypeValue,lookups.CommodityType FROM lookups WHERE lookups.CommodityTypeStatus="Active"');
        $cropyeardata=DB::select('SELECT lookups.CropYearValue,lookups.CropYear FROM lookups WHERE lookups.CropYearStatus="Active"');
        $prctypedata=DB::select('SELECT lookups.ProcessTypeValue,lookups.ProcessType FROM lookups WHERE lookups.ProcessTypeStatus="Active"');
        $gradedata=DB::select('SELECT lookups.GradeValue,lookups.Grade FROM lookups WHERE lookups.GradeStatus="Active"');
        $commsrcdata=DB::select('SELECT lookups.CommoditySourceValue,lookups.CommoditySource FROM lookups WHERE lookups.CommoditySourceStatus="Active"');
        $productTypedata=DB::select('SELECT lookups.ProductTypeValue,lookups.ProductType FROM lookups WHERE lookups.ProductTypeStatus="Active"');
        $current_cropyear=DB::select('SELECT YEAR(CURDATE()) - IF(MONTH(CURDATE()) > 9 OR (MONTH(CURDATE()) = 9 AND DAY(CURDATE()) >= 11), 7, 8) AS crop_year UNION SELECT YEAR(CURDATE()) - IF(MONTH(CURDATE()) > 9 OR (MONTH(CURDATE()) = 9 AND DAY(CURDATE()) >= 11), 8, 9)');

        if($request->ajax()) {
            return view('production.prdorder',["cusdatasrc"=>$customerdata,'bomdata'=>$bomdata,'origin'=>$origin,'currentdate'=>$currentdate,'storedata'=>$storedata,'storedatadytbl'=>$storedatadytbl,'uomdata'=>$uomdata,'origindatasrc'=>$origindatasrc,'users'=>$users,'fiscalyears'=>$fiscalyears,'prdstoredata'=>$prdstoredata,'locationdatasrc'=>$locationdatasrc,'prdDetailDataSrc'=>$prdDetailDataSrc,
            'prdCommodityDataSrc'=>$prdCommodityDataSrc,'prdGradeDataSrc'=>$prdGradeDataSrc,'prdProcessTypeDataSrc'=>$prdProcessTypeDataSrc,'prdCropYearDataSrc'=>$prdCropYearDataSrc,'prdStoreDataSrc'=>$prdStoreDataSrc,'prdUomDataSrc'=>$prdUomDataSrc,'prepCoffeeTypeDataSrc'=>$prepCoffeeTypeDataSrc,'prdOrderDataSrc'=>$prdOrderDataSrc,'expdefaltuomDataSrc'=>$expdefaltuomDataSrc,'prdbiproduct'=>$prdbiproduct,
            'prdSupplierDataSrc'=>$prdSupplierDataSrc,'prdGrnNumberDataSrc'=>$prdGrnNumberDataSrc,'prdProductionDataSrc'=>$prdProductionDataSrc,'prdCertNumberDataSrc'=>$prdCertNumberDataSrc,'floormapdatasrc'=>$floormapdatasrc,'exporttypedata'=>$exporttypedata,'commtypedata'=>$commtypedata,'cropyeardata'=>$cropyeardata,'prctypedata'=>$prctypedata,'gradedata'=>$gradedata,'commsrcdata'=>$commsrcdata,'productTypedata'=>$productTypedata,
            'current_cropyear'=>$current_cropyear])->renderSections()['content'];
        }
        else{
            return view('production.prdorder',["cusdatasrc"=>$customerdata,'bomdata'=>$bomdata,'origin'=>$origin,'currentdate'=>$currentdate,'storedata'=>$storedata,'storedatadytbl'=>$storedatadytbl,'uomdata'=>$uomdata,'origindatasrc'=>$origindatasrc,'users'=>$users,'fiscalyears'=>$fiscalyears,'prdstoredata'=>$prdstoredata,'locationdatasrc'=>$locationdatasrc,'prdDetailDataSrc'=>$prdDetailDataSrc,
            'prdCommodityDataSrc'=>$prdCommodityDataSrc,'prdGradeDataSrc'=>$prdGradeDataSrc,'prdProcessTypeDataSrc'=>$prdProcessTypeDataSrc,'prdCropYearDataSrc'=>$prdCropYearDataSrc,'prdStoreDataSrc'=>$prdStoreDataSrc,'prdUomDataSrc'=>$prdUomDataSrc,'prepCoffeeTypeDataSrc'=>$prepCoffeeTypeDataSrc,'prdOrderDataSrc'=>$prdOrderDataSrc,'expdefaltuomDataSrc'=>$expdefaltuomDataSrc,'prdbiproduct'=>$prdbiproduct,
            'prdSupplierDataSrc'=>$prdSupplierDataSrc,'prdGrnNumberDataSrc'=>$prdGrnNumberDataSrc,'prdProductionDataSrc'=>$prdProductionDataSrc,'prdCertNumberDataSrc'=>$prdCertNumberDataSrc,'floormapdatasrc'=>$floormapdatasrc,'exporttypedata'=>$exporttypedata,'commtypedata'=>$commtypedata,'cropyeardata'=>$cropyeardata,'prctypedata'=>$prctypedata,'gradedata'=>$gradedata,'commsrcdata'=>$commsrcdata,'productTypedata'=>$productTypedata,
            'current_cropyear'=>$current_cropyear]);
        }
    }

    public function prdorderlist(Request $request)
    {
        $fyear = $_POST['fiscal_year']; 
        $comp_type = $_POST['type']; 
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $prdorderdatalist=DB::select('SELECT prd_orders.*,lookups.CompanyType AS CompanyTypes,prdlookups.ProductionType AS ProductionTypeName,customers.Name AS CustomerName,customers.TinNumber,prd_bomchildren.BomChildName FROM prd_orders INNER JOIN customers ON prd_orders.customers_id=customers.id INNER JOIN prd_bomchildren ON prd_orders.prd_bomchildren_id=prd_bomchildren.id LEFT JOIN lookups ON prd_orders.CompanyType=lookups.CompanyTypeValue LEFT JOIN lookups AS prdlookups ON prd_orders.ProductionType=prdlookups.ProductionTypeValue WHERE prd_orders.CompanyType='.$comp_type.' AND prd_orders.FiscalYear='.$fyear.' ORDER BY prd_orders.id DESC');
        if(request()->ajax()) {
            return datatables()->of($prdorderdatalist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $prdedit='';
                $prdvoid='';
                $prdcompvoid='';
                $prdundovoid='';
                $prdcompundovoid='';
                $prdabort='';
                $prdundoabort='';
                $prdratio='';
                if($data->Status=='Void'||$data->Status=='Void(Pending)'||$data->Status=='Void(Draft)' || $data->Status=='Void(Ready)'){
                    if($user->can('Production-Order-Void')){
                        $prdundovoid='<a class="dropdown-item prdOrderUndoVoid" onclick="prdOrderUndoVoidFn('.$data->id.')" data-id="'.$data->id.'" id="undovoidbtn'.$data->id.'" title="Open production order undo void confirmation">
                                <i class="fa fa-undo"></i><span> Undo Void</span>  
                            </a>';
                    }
                    $prdedit='';
                    $prdvoid='';
                    $prdabort='';
                    $prdundoabort='';
                    $prdratio='';
                    $prdcompvoid='';
                    $prdcompundovoid='';
                }
                else if($data->Status=='Void(Completed)' || $data->Status=='Void(Process-Finished)'){
                    if($user->can('Production-Order-Void')){
                        $prdcompundovoid='<a class="dropdown-item prdCompOrderUndoVoid" onclick="prdCompOrderUndoVoidFn('.$data->id.')" data-id="'.$data->id.'" id="undocompvoidbtn'.$data->id.'" title="Open production order undo void confirmation">
                                <i class="fa fa-undo"></i><span> Undo Void</span>  
                            </a>';
                    }
                    $prdedit='';
                    $prdvoid='';
                    $prdabort='';
                    $prdundoabort='';
                    $prdratio='';
                    $prdcompvoid='';
                    $prdundovoid='';
                }
                else if($data->Status=='On-Production'){
                    if($user->can('Production-Order-Edit')){
                        $prdedit='<a class="dropdown-item prdOrderEdit" onclick="prdOrderEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn'.$data->id.'" title="Open production order edit page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                    }
                    if($user->can('Production-Order-Abort')){
                        $prdabort='<a class="dropdown-item prdOrderAbort" onclick="prdOrderAbortFn('.$data->id.')" data-id="'.$data->id.'" id="voidbtn'.$data->id.'" title="Open production order abort confirmation">
                                <i class="fa-solid fa-ban"></i><span> Abort</span>  
                            </a>';
                    }
                    if($user->can('Production-Order-ManageRatio')){
                        $prdratio='<a class="dropdown-item prdRatio" onclick="prdRatioFn('.$data->id.')" data-id="'.$data->id.'" id="ratdteditbtn'.$data->id.'" title="Open production ratio page">
                            <i class="fa fa-plus"></i><span> Add/Edit Ratio</span>  
                        </a>';
                    }
                    $prdvoid='';
                    $prdcompvoid='';
                    $prdundovoid='';
                    $prdcompundovoid='';
                }
                else if($data->Status=='Pending'){
                    if($user->can('Production-Order-Edit')){
                        $prdedit='<a class="dropdown-item prdOrderEdit" onclick="prdOrderEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn'.$data->id.'" title="Open production order edit page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                    }
                    if($user->can('Production-Order-Void')){
                        $prdvoid='<a class="dropdown-item prdOrderVoid" onclick="prdOrderVoidFn('.$data->id.')" data-id="'.$data->id.'" id="voidbtn'.$data->id.'" title="Open production order void confirmation">
                                <i class="fa fa-trash"></i><span> Void</span>  
                            </a>';
                    }
                    if($user->can('Production-Order-ManageRatio')){
                        $prdratio='<a class="dropdown-item prdRatio" onclick="prdRatioFn('.$data->id.')" data-id="'.$data->id.'" id="ratdteditbtn'.$data->id.'" title="Open production ratio page">
                            <i class="fa fa-plus"></i><span> Add/Edit Ratio</span>  
                        </a>';
                    }
                    $prdabort='';
                    $prdcompvoid='';
                    $prdundovoid='';
                    $prdcompundovoid='';
                }
                else if($data->Status=='Aborted'){
                    if($user->can('Production-Order-Abort')){
                        $prdundoabort='<a class="dropdown-item prdOrderUndoAbort" onclick="prdOrderUndoAbortFn('.$data->id.')" data-id="'.$data->id.'" id="undovoidbtn'.$data->id.'" title="Open production order undo abort confirmation">
                                <i class="fa fa-undo"></i><span> Undo Abort</span>  
                            </a>';
                    }
                    $prdedit='';
                    $prdvoid='';
                    $prdabort='';
                    $prdundovoid='';
                    $prdratio='';
                    $prdcompvoid='';
                    $prdcompundovoid='';
                }
                else if($data->Status=='Process-Finished'){ 
                    if($user->can('Production-Order-Void')){
                        $prdcompvoid='<a class="dropdown-item prdCompVoid" onclick="prdCompVoidFn('.$data->id.')" data-id="'.$data->id.'" id="compvoidbtn'.$data->id.'" title="Open production order void confirmation">
                            <i class="fa fa-trash"></i><span> Void</span>  
                        </a>';
                    }
                    $prdedit='';
                    $prdvoid='';
                    $prdabort='';
                    $prdundovoid='';
                    $prdundoabort='';
                    $prdratio='';
                    $prdcompundovoid='';
                }
                else if($data->Status=='Completed'){
                    if($user->can('Production-Order-Void')){
                        $prdcompvoid='<a class="dropdown-item prdCompVoid" onclick="prdCompVoidFn('.$data->id.')" data-id="'.$data->id.'" id="compvoidbtn'.$data->id.'" title="Open production order void confirmation">
                            <i class="fa fa-trash"></i><span> Void</span>  
                        </a>';
                    }
                    $prdedit='';
                    $prdvoid='';
                    $prdabort='';
                    $prdundovoid='';
                    $prdratio='';
                    $prdcompundovoid='';
                }
                else{
                    $prdedit='';
                    $prdvoid='';
                    $prdratio='';
                    $prdundovoid='';
                    $prdabort='';
                    $prdundoabort='';
                    $prdcompvoid='';
                    $prdcompundovoid='';
                }
                
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item prdOrderInfo" onclick="prdOrderInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn'.$data->id.'" title="Open production order information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$prdedit.'
                        '.$prdratio.'
                        '.$prdvoid.'
                        '.$prdundovoid.'
                        '.$prdabort.'
                        '.$prdundoabort.'
                        '.$prdcompvoid.'
                        '.$prdcompundovoid.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
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
    
    public function store(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->recId;
        $findid=$request->recId;
        $prdorderst=prd_order::find($findid);
        $statusval=$prdorderst->Status ?? "None";
        $companytype=$request->CompanyType;
        $PoDocumentNumber=null;
        $additionalDoc=null;
        $customerid=1;
        $currentdocnum=null;
        $actions=null;
        $cerids=[];
        $detids=[];
        $commstflag=0;
        
        if($companytype==1){
            $prdorder = prd_order::where('CompanyType',1)->where('FiscalYear',$fyear)->latest()->first();
            $PoDocumentNumber=$settings->PrdOwnerPrefix.sprintf("%03d",($prdorder->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum=($prdorder->CurrentDocumentNumber ?? 0)+1;

            if($findid!=null){
                $prdorderdata = prd_order::where('id',$findid)->where('FiscalYear',$fyear)->latest()->first();
                if($prdorderdata->CompanyType==2){
                    $prdorderedt = prd_order::where('CompanyType',1)->where('FiscalYear',$fyear)->latest()->first();
                    $PoDocumentNumber=$settings->PrdOwnerPrefix.sprintf("%03d",($prdorderedt->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum=($prdorderedt->CurrentDocumentNumber ?? 0)+1;
                }
                if($prdorderdata->CompanyType==1){
                    $PoDocumentNumber=$prdorderdata->ProductionOrderNumber;
                    $currentdocnum=$prdorderdata->CurrentDocumentNumber;
                }
            }
        }
        else if($companytype==2){
            $prdorder = prd_order::where('CompanyType',2)->where('FiscalYear',$fyear)->latest()->first();
            $PoDocumentNumber=$settings->PrdCustomerPrefix.sprintf("%03d",($prdorder->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum=($prdorder->CurrentDocumentNumber ?? 0)+1;

            if($findid!=null){
                $prdorderdata = prd_order::where('id',$findid)->where('FiscalYear',$fyear)->latest()->first();
                if($prdorderdata->CompanyType==1){
                    $prdorderedt = prd_order::where('CompanyType',2)->where('FiscalYear',$fyear)->latest()->first();
                    $PoDocumentNumber=$settings->PrdOwnerPrefix.sprintf("%03d",($prdorderedt->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum=($prdorderedt->CurrentDocumentNumber ?? 0)+1;
                }
                if($prdorderdata->CompanyType==2){
                    $PoDocumentNumber=$prdorderdata->ProductionOrderNumber;
                    $currentdocnum=$prdorderdata->CurrentDocumentNumber;
                }
            }
        }
       
        $validator = Validator::make($request->all(),[
            'CompanyType' => 'required',
            'Customer' => 'required_if:CompanyType,2',
            //'CustomerRepresentativeName' => 'required_if:CompanyType,2',
            //'CustomerRepresentativePhoneNumber' => 'required_if:CompanyType,2',
            'ProductionType' => 'required',
            'ProductionOutputType' => 'required',
            'BillOfMaterial' => 'required',
            'ExpectedFinalAmount' => 'nullable|numeric|min:0',
            'Commodity' => 'required',
            'Grade' => 'required',
            'ProcessType' => 'required',
            'crop_year' => 'required',
            'OrderDate' => 'required',
            'Deadline' => 'required',
            'ContractNumber' => ['nullable',Rule::unique('prd_orders')->where(function ($query){
                })->ignore($findid)
            ],
            'Moisture' => 'nullable|numeric|min:0',
            'WaterActivity' => 'nullable|numeric|min:0',
            'DefectCount' => 'nullable|numeric|min:0',
            'FrontSideBagLabel' => 'nullable|string|max:65535',
            'BackSideBagLabel' => 'nullable|string|max:65535',
            'AdditionalInstruction' => 'nullable|string|max:65535',
            'AssignedPersonnel' => 'required',
            'AdditionalFile'=> 'nullable|mimes:pdf,jpg,jpeg,png',
            'Remark' => 'nullable|string|max:65535',
        ]);

        $cerules=array(
            'cerrow.*.CertNumber' => 'required',
            'cerrow.*.CerUom' => 'required',
            'cerrow.*.NumofBag' => 'required',
            'cerrow.*.GrainPro' => 'required',
        );

        $rules=array(
            'row.*.CommType' => 'required',
            'row.*.Origin' => 'required',
            'row.*.Grade' => 'required',
            'row.*.ProcessType' => 'required',
            'row.*.CropYear' => 'required',
            'row.*.store' => 'required',
            'row.*.Uom' => 'required',
            'row.*.Quantity' => 'required|gt:0',
        );

        $v1= Validator::make($request->all(), $cerules);
        $v2= Validator::make($request->all(), $rules);

        
        if($request->row == null && ($statusval=="None" || $statusval=="Draft" || $statusval=="Pending")){
            $commstflag=0;
        }
        if($request->row == null && $statusval=="Ready"){
            $commstflag=1;
        }

        if($validator->passes() && $v1->passes() && $v2->passes() && $commstflag==0){
            try
            {
                if ($request->file('AdditionalFile')) {
                    $file = $request->file('AdditionalFile');
                    $additionalDoc = "Prd".time().".".$request->file('AdditionalFile')->extension();
                    $pathIdentification = public_path() . '/storage/uploads/ProductionOrderDocument';
                    $pathnameIdentification='/storage/uploads/ProductionOrderDocument/'.$additionalDoc;
                    $file->move($pathIdentification, $additionalDoc);
                }
                if($request->file('AdditionalFile')==''){
                    $additionalDoc=$request->additionalfilelbl;
                }

                if($request->CompanyType==1){
                    $customerid=1;
                }
                if($request->CompanyType==2){
                    $customerid=$request->Customer;
                }

                $DbData = prd_order::where('id',$findid)->first();
                $BasicVal = [
                    'ProductionOrderNumber' => $PoDocumentNumber,
                    'CompanyType' => $request->CompanyType,
                    'customers_id' => $customerid,
                    'RepName' => $request->CustomerRepresentativeName,
                    'RepPhone' => $request->CustomerRepresentativePhoneNumber,
                    'ProductionType' => $request->ProductionType,
                    'OutputType' => $request->ProductionOutputType,
                    'prd_bomchildren_id' =>1,
                    'ExpectedAmount' => $request->ExpectedFinalAmount,
                    'woredas_id' => $request->Commodity,
                    'CropYear' => $request->crop_year,
                    'Grade' => $request->Grade,
                    'ProcessType' => $request->ProcessType,
                    'Symbol' => Str::upper($request->Symbol),
                    'OrderDate' => $request->OrderDate,
                    'Deadline' => $request->Deadline,
                    'GrainPro' => $request->GrainPro,
                    'ContractNumber' => $request->ContractNumber,
                    'SieveSize' => $request->ScreenSize,
                    'CGrade' => $request->CGrade,
                    'ThickCoffee' => $request->ThickCoffee,
                    'Moisture' => $request->Moisture,
                    'WaterActivity' => $request->WaterActivity,
                    'DefectCount' => $request->DefectCount,
                    'FrontSideBagLabel' => $request->FrontSideBagLabel,
                    'BackSideBagLabel' => $request->BackSideBagLabel,
                    'AdditionalInstruction' => $request->AdditionalInstruction,
                    'users_id' => $request->AssignedPersonnel,
                    'AdditionalFile' => $additionalDoc,
                    'Remark' => $request->Remark,
                    'FiscalYear' => $fyear,
                    'CurrentDocumentNumber' => $currentdocnum,
                ];

                $CreateData = ['Status'=>"Draft"];
                $UpdateData = ['updated_at'=>Carbon::now()];

                $prdorderdb = prd_order::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $UpdateData : $CreateData),
                );

                if($request->cerrow!=null){
                    foreach ($request->cerrow as $key => $cvalue){
                        $cerids[]=$cvalue['cid'];
                    }
                    prd_order_cert::where('prd_order_certs.prd_orders_id',$prdorderdb->id)->whereNotIn('id',$cerids)->delete();
                    foreach ($request->cerrow as $key => $cvalue){
                        prd_order_cert::updateOrCreate(['id' => $cvalue['cid']],
                        [
                            'prd_orders_id'=>$prdorderdb->id,
                            'CertificateNumber'=>$cvalue['CertNumber'],
                            'uoms_id'=>$cvalue['CerUom'],
                            'NumofBag'=>$cvalue['NumofBag'],
                            'GrainPro'=>$cvalue['GrainPro'],
                        ]);
                    }
                }

                

                if($findid!=null && $request->cerrow==null){
                    prd_order_cert::where('prd_order_certs.prd_orders_id',$findid)->delete();
                }
                
                if($findid==null){
                    $actions="Created";
                }
                else if($findid!=null){
                    $actions="Edited";
                }
                actions::insert(['user_id'=>$userid,'pageid'=>$prdorderdb->id,'pagename'=>"prdorder",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }

        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
        if($v1->fails())
        {
            return response()->json(['errorv1'=> $v1->errors()->all()]);
        }
        if($request->cerrow==null)
        {
            return Response::json(['ceremptyerror'=> 462]);
        }
        if($commstflag==1)
        {
            return Response::json(['comemptyerror'=> 462]);
        }
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
    }

    public function saveRatio(Request $request){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $suppcnt=0;
        $grnnumcnt=0;
        $prdnumcnt=0;
        $cernumcnt=0;
        $detids=[];
        $customerid=$request->ratioCustomerId;
        $recordid=$request->ratioRecId;
        $optType=$request->ratioOperationtypes;
        $actions="";

        $validator = Validator::make($request->all(),[
            'ScreenSize' => 'nullable',
            'CGrade' => 'nullable',
            'ThickCoffee' => 'nullable',
            'Moisture' => 'nullable',
            'WaterActivity' => 'nullable',
            'DefectCount' => 'nullable',
            'FrontSideBagLabel' => 'nullable',
            'BackSideBagLabel' => 'nullable',
            'AdditionalInstruction' => 'nullable',
        ]);

        $rules=array(
            'row.*.CommType' => 'required',
            'row.*.Origin' => 'required',
            'row.*.Grade' => 'required',
            'row.*.ProcessType' => 'required',
            'row.*.CropYear' => 'required',
            'row.*.store' => 'required',
            'row.*.floormapratio' => 'required',
            'row.*.Uom' => 'required',
            'row.*.Quantity' => 'required|gt:0',
        );

        $v2= Validator::make($request->all(), $rules);

        if($request->row!=null){
            foreach ($request->row as $key => $value){
                $suppid=$value['Supplier']??0;
                $grnnum=$value['GrnNumber']??"";
                $cernum=$value['CertificateNum']??"";
                $prdnum=$value['ProductionNum']??"";
                if($suppid==0 && $request->customers_id==1 && ($value['CommType']==1)){
                    $suppcnt+=1;
                }
                if($grnnum=="" && $request->customers_id==1 && ($value['CommType']==1)){
                    $grnnumcnt+=1;
                }
                if($cernum=="" && $request->customers_id==1 && ($value['CommType']==2 || $value['CommType']==3 || $value['CommType']==4 || $value['CommType']==5 || $value['CommType']==6)){
                    $cernumcnt+=1;
                }
                if($prdnum=="" && $request->customers_id==1 && ($value['CommType']==2 || $value['CommType']==3 || $value['CommType']==4 || $value['CommType']==5 || $value['CommType']==6)){
                    $prdnumcnt+=1;
                }
            }
        }
        if($validator->passes() && $v2->passes() && $request->row!=null && $suppcnt==0 && $grnnumcnt==0 && $prdnumcnt==0 && $cernumcnt==0){
            try
            {
                prd_order::where('prd_orders.id',$recordid)->update([
                    'SieveSize' => $request->ScreenSize,
                    'CGrade' => $request->CGrade,
                    'ThickCoffee' => $request->ThickCoffee,
                    'Moisture' => $request->Moisture,
                    'WaterActivity' => $request->WaterActivity,
                    'DefectCount' => $request->DefectCount,
                    // 'FrontSideBagLabel' => $request->FrontSideBagLabel,
                    // 'BackSideBagLabel' => $request->BackSideBagLabel,
                    // 'AdditionalInstruction' => $request->AdditionalInstruction
                ]);

                foreach ($request->row as $key => $value){
                    $detids[]=$value['id'];
                }
                prd_order_detail::where('prd_order_details.prd_orders_id',$recordid)->whereNotIn('id',$detids)->delete();
                foreach ($request->row as $key => $value){
                    prd_order_detail::updateOrCreate(['id' => $value['id']],
                    [ 
                        'prd_orders_id' => $recordid,
                        'CommodityType' => $value['CommType'],
                        'woredas_id' => (int)$value['Origin'],
                        'Grade' => (int)$value['Grade'],
                        'ProcessType' => $value['ProcessType'],
                        'CropYear' => (int)$value['CropYear'],
                        'Symbol' => Str::upper($value['Symbols']),
                        'SupplierId' => $value['Supplier'] ?? "N/A",
                        'GrnNumber' => $value['GrnNumber'] ?? "N/A",
                        'ProductionNumber' => $value['ProductionNum'] ?? "N/A",
                        'CertNumber' => $value['CertificateNum'] ?? "N/A",
                        'stores_id' => (int)$value['store'],
                        'LocationId' => (int)$value['floormapratio'],
                        'uoms_id' => (int)$value['Uom'],
                        'Quantity' => (float)$value['Quantity'],
                        'QuantityInKG' => (float)$value['QtyConverted'],
                        'UnitCost' => (float)$value['UnitPrice'] ?? 0,
                        'TotalCost' => (float)$value['TotalPrice'] ?? 0,
                        'RatioVarianceShortage' => (float)$value['varianceshortage'] ?? 0,
                        'RatioVarianceOverage' => (float)$value['varianceoverage'] ?? 0,
                        'UomFactor' => (float)$value['uomfactor'],
                        'Remark' => $value['Remark']
                    ]);
                }

                if($optType==1){
                    $actions="Ratio-Created";
                }
                else if($optType==2){
                    $actions="Ratio-Edited";
                }
                actions::insert(['user_id'=>$userid,'pageid'=>$recordid,'pagename'=>"prdorder",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
        if($request->row==null)
        {
            return Response::json(['emptyerror'=> 462]);
        }
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all()]);
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

    public function showPrdOrder($id){
        $datefromval=0;
        $totalrationqnt=0;

        $totalcost=0;
        $totalqnt=0;
        $unitcost=0;
        $prdorders=prd_order::join('customers','prd_orders.customers_id','customers.id')
        ->join('prd_bomchildren','prd_orders.prd_bomchildren_id','prd_bomchildren.id')
        ->join('woredas','prd_orders.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('users','prd_orders.users_id','users.id')
        ->leftJoin('stores','prd_orders.PrdWarehouse','stores.id')
        ->leftJoin('lookups AS croplookup','prd_orders.CropYear','croplookup.CropYearValue')
        ->leftJoin('lookups AS grdlookup','prd_orders.Grade','grdlookup.GradeValue')
        ->leftJoin('lookups AS prdlookup','prd_orders.ProductionType','prdlookup.ProductionTypeValue')
        ->leftJoin('lookups AS otplookup','prd_orders.OutputType','otplookup.ProductTypeValue')
        ->leftJoin('lookups AS cmplookup','prd_orders.CompanyType','cmplookup.CompanyTypeValue')
        ->where('prd_orders.id',$id)
        ->get(['prd_orders.*','prd_orders.OutputType AS PrdOutputType',
            'cmplookup.CompanyType AS CompanyTypes','otplookup.ProductType AS OutputType','grdlookup.Grade AS Grades','croplookup.CropYear AS CropYearName','prdlookup.ProductionType AS ProductionTypeName',
            DB::raw('CONCAT(zones.Zone_Name," , ",woredas.Woreda_Name) AS Commodities'),
            DB::raw('CASE WHEN GrainPro=0 THEN "No" WHEN GrainPro=1 THEN "Yes" END AS GrainPros'),  
            DB::raw('IFNULL(prd_orders.ExportRemark,"") AS ExportRemark'),DB::raw('IFNULL(prd_orders.RejectRemark,"") AS RejectRemark'),DB::raw('IFNULL(prd_orders.WastageRemark,"") AS WastageRemark'),
            'customers.Name AS CustomerName','customers.TinNumber','customers.Code AS CustomerCode','customers.PhoneNumber','customers.OfficePhone','customers.EmailAddress','prd_bomchildren.BomChildName','users.FullName',
            'stores.Name AS ProductionStore','prd_orders.VarianceShortage AS VarianceShortagePr','prd_orders.VarianceOverage AS VarianceOveragePr'
        ]);

        $prdcerorder=prd_order_cert::join('uoms','prd_order_certs.uoms_id','uoms.id')
        ->where('prd_order_certs.prd_orders_id',$id)
        ->get(['prd_order_certs.*','uoms.Name AS UomName',DB::raw('CASE WHEN GrainPro=2 THEN "No" WHEN GrainPro=1 THEN "Yes" END AS GrainPros'),
            DB::raw('(SELECT COUNT(prd_outputs.id) FROM prd_outputs WHERE prd_outputs.CertificationId=prd_order_certs.id) AS TotalCerCount')
        ]);

        $woredacer= woreda_certificate::join('com_certificates','woreda_certificates.com_certificates_id','com_certificates.id')
        ->where('woreda_certificates.woredas_id',$prdorders[0]->woredas_id)->get(['com_certificates.Certification']);

        $prdorderdetails=prd_order_detail::join('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
        ->join('woredas','prd_order_details.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('uoms','prd_order_details.uoms_id','uoms.id')
        ->join('stores','prd_order_details.stores_id','stores.id')
        ->leftJoin('locations','prd_order_details.LocationId','locations.id')
        ->leftJoin('customers','prd_order_details.SupplierId','customers.id')
        ->leftJoin('lookups','prd_order_details.CommodityType','lookups.CommodityTypeValue')
        ->leftJoin('lookups AS croplookup','prd_order_details.CropYear','croplookup.CropYearValue')
        ->leftJoin('lookups AS grdlookup','prd_order_details.Grade','grdlookup.GradeValue')
        ->where('prd_order_details.prd_orders_id',$id)
        ->orderBy('prd_order_details.id','ASC')
        ->get(['prd_orders.OrderDate','prd_orders.ProductionStartDate','prd_order_details.*','prd_order_details.id AS PrdDetailId',
            'lookups.CommodityType AS CommodityTypeName','croplookup.CropYear AS CropYearName','grdlookup.Grade AS GradeName',
            'prd_order_details.SupplierId','customers.Code','customers.Name AS SupplierName','customers.TinNumber','prd_order_details.Quantity','prd_order_details.QuantityInKG','prd_order_details.UnitCost','prd_order_details.TotalCost',
            DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_order_details.Remark,"") AS PrdDetailRemark'),DB::raw('IFNULL(prd_order_details.Symbol,"") AS Symbol'),
            'uoms.Name AS UomName','uoms.uomamount','uoms.bagweight','stores.Name AS StoreName','locations.Name AS LocationName',
            DB::raw('(SELECT COALESCE(SUM(prd_order_processes.QuantityByKg),0) FROM prd_order_processes WHERE prd_order_processes.prd_order_details_id=prd_order_details.id) AS TotalQuantityByKg')
        ]);

        $prdoutputs=prd_output::leftJoin('locations','prd_outputs.LocationId','locations.id')
        ->leftJoin('prd_order_certs','prd_outputs.CertificationId','=','prd_order_certs.id')
        ->leftJoin('uoms','prd_outputs.FullUomId','=','uoms.id')
        ->leftJoin('prd_biproducts','prd_outputs.BiProductId','=','prd_biproducts.id')
        ->leftJoin('lookups','prd_outputs.CleanProductType','=','lookups.CommodityTypeValue')
        ->leftJoin('prd_orders','prd_outputs.prd_orders_id','=','prd_orders.id')
        ->where('prd_outputs.prd_orders_id',$id)
        ->orderBy('prd_outputs.OutputType','ASC')
        ->orderBy('prd_outputs.id','ASC')
        ->distinct()
        ->get(['prd_outputs.*','prd_orders.ProductionType','prd_biproducts.BiProductName','lookups.CommodityType','prd_order_certs.CertificateNumber','locations.Name AS LocationName','locations.StoreId',
        'uoms.Name AS UomName','uoms.uomamount','uoms.bagweight',DB::raw('IFNULL(prd_outputs.Inspection,"") AS InspectionData')]);

        $prdprocessdata=prd_order_process::join('prd_order_details','prd_order_processes.prd_order_details_id','prd_order_details.id')
        ->join('locations','prd_order_processes.LocationId','locations.id')
        ->join('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
        ->join('woredas','prd_order_details.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('uoms','prd_order_details.uoms_id','uoms.id')
        ->join('uoms AS uomprocess','prd_order_processes.uoms_id','uomprocess.id')
        ->join('stores','prd_order_details.stores_id','stores.id')
        ->leftJoin('lookups','prd_order_details.CommodityType','lookups.CommodityTypeValue')
        ->leftJoin('lookups AS grdlookup','prd_order_details.Grade','grdlookup.GradeValue')
        ->where('prd_order_details.prd_orders_id',$id)
        ->orderBy('prd_order_details.id','ASC')
        ->get(['prd_orders.OrderDate','prd_orders.ProductionStartDate','prd_order_processes.*','prd_order_processes.Date AS ProcDate','locations.Name AS LocationName','prd_order_details.*','prd_order_details.id AS PrdDetailId',
            'lookups.CommodityType AS CommodityTypeName','grdlookup.Grade AS GradeName',
            DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_order_details.Remark,"") AS Remark'),DB::raw('IFNULL(prd_order_details.Symbol,"") AS Symbol'),
            'prd_order_details.CommodityType AS CommDetType','prd_order_details.woredas_id AS CommDetRegion','prd_order_details.Grade AS CommDetGrade','prd_order_details.ProcessType AS CommDetProcessType','prd_order_details.CropYear AS CommDetCropYear','prd_order_details.stores_id AS CommDetStoreId',
            'uoms.Name AS UomName','uoms.uomamount','uoms.bagweight','stores.Name AS StoreName',DB::raw('IFNULL(prd_order_processes.Remark,"")  AS ProcRemark'),'prd_order_processes.id AS ProcId',
            'uomprocess.Name AS ProcUomName','uomprocess.uomamount AS ProcUomAmount','uomprocess.bagweight AS ProcBagWeight','prd_order_processes.uoms_id AS ProcUomId',
            DB::raw('CASE WHEN prd_order_processes.VarianceShortage=0 THEN "" ELSE prd_order_processes.VarianceShortage END AS VarianceShortage'),
            DB::raw('CASE WHEN prd_order_processes.VarianceOverage=0 THEN "" ELSE prd_order_processes.VarianceOverage END AS VarianceOverage')
        ]);

        $getratioqnt=DB::select('SELECT COALESCE(SUM(prd_order_processes.QuantityByKg),0) AS TotalQuantityByKg FROM prd_order_processes WHERE prd_order_processes.prd_orders_id='.$id);
        $totalrationqnt=$getratioqnt[0]->TotalQuantityByKg ?? 0;

        $getcost=DB::select('SELECT COALESCE(SUM(prd_order_details.TotalCost),0) AS TotalCost,COALESCE(SUM(prd_order_details.QuantityInKG),0) AS QuantityInKG FROM prd_order_details WHERE prd_order_details.prd_orders_id='.$id);
        $totalcost=$getcost[0]->TotalCost ?? 0;
        $totalqnt=$getcost[0]->QuantityInKG ?? 0;
        if($totalcost>0 && $totalqnt>0){
            $unitcost=round(($totalcost/$totalqnt),2);
        }
        
        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"prdorder")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);
        
        return response()->json(['prdorders'=>$prdorders,'prdcerorder'=>$prdcerorder,'woredacer'=>$woredacer,'prdorderdetails'=>$prdorderdetails,'prdoutputs'=>$prdoutputs,'prdprocessdata'=>$prdprocessdata,'totalrationqnt'=>$totalrationqnt,'activitydata'=>$activitydata,'unitcost'=>$unitcost]);       
    }

    public function showPrdOrderDetail($id)
    {
        $prdorderdetaildata=prd_order_detail::join('woredas','prd_order_details.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('uoms','prd_order_details.uoms_id','uoms.id')
        ->join('stores','prd_order_details.stores_id','stores.id')
        ->leftJoin('locations','prd_order_details.LocationId','locations.id')
        ->leftJoin('customers','prd_order_details.SupplierId','customers.id')
        ->leftJoin('lookups','prd_order_details.CommodityType','lookups.CommodityTypeValue')
        ->leftJoin('lookups AS croplookup','prd_order_details.CropYear','croplookup.CropYearValue')
        ->leftJoin('lookups AS grdlookup','prd_order_details.Grade','grdlookup.GradeValue')
        ->where('prd_order_details.prd_orders_id',$id)
        ->orderBy('prd_order_details.id','ASC')
        ->get(['prd_order_details.*','lookups.CommodityType AS CommType','croplookup.CropYear','grdlookup.Grade',DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),
            DB::raw('IFNULL(prd_order_details.Remark,"") AS Remark'),DB::raw('IFNULL(prd_order_details.Symbol,"") AS Symbol'),'uoms.Name AS UomName','stores.Name AS StoreName','locations.Name AS LocationName',
            'customers.Name AS SupplierName',DB::raw('IFNULL(prd_order_details.GrnNumber,"") AS GrnNumber'),DB::raw('IFNULL(prd_order_details.CertNumber,"") AS CertNumber')
        ]);

        return datatables()->of($prdorderdetaildata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
    
    public function showPrdProcess($id)
    {
        $prdprocessdetaildata=prd_order_process::join('prd_order_details','prd_order_processes.prd_order_details_id','prd_order_details.id')
        ->join('locations','prd_order_processes.LocationId','locations.id')
        ->join('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
        ->join('woredas','prd_order_details.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('uoms','prd_order_details.uoms_id','uoms.id')
        ->join('uoms AS uomprocess','prd_order_processes.uoms_id','uomprocess.id')
        ->join('stores','prd_order_details.stores_id','stores.id')
        ->leftJoin('lookups','prd_order_details.CommodityType','lookups.CommodityTypeValue')
        ->leftJoin('lookups AS croplookup','prd_order_details.CropYear','croplookup.CropYearValue')
        ->leftJoin('lookups AS grdlookup','prd_order_details.Grade','grdlookup.GradeValue')
        ->where('prd_order_processes.prd_orders_id',$id)
        ->orderBy('prd_order_processes.prd_order_details_id','ASC')
        ->get(['prd_orders.OrderDate','prd_orders.ProductionStartDate','prd_order_processes.*','prd_order_processes.Date AS ProcDate','locations.Name AS LocationName','prd_order_details.*','prd_order_details.id AS PrdDetailId',
            DB::raw('CONCAT("Type: ",lookups.CommodityType,"   |   Commodity: ",regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name,"   |   Grade:",grdlookup.Grade,"   |   Process Type:",prd_order_details.ProcessType,"  |   Crop Year:",
            croplookup.CropYear,"  |   Symbol:",prd_order_details.Symbol,"  |   Store:",stores.Name,"  |   Quantity:",prd_order_details.Quantity," ",uoms.Name," | ",prd_order_details.QuantityInKG," KG","      |      Remark: ",IFNULL(prd_order_details.Remark,"")) AS AllRatioData'),
            'lookups.CommodityType AS CommodityTypeName','grdlookup.Grade AS GradeName',
            DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_order_details.Remark,"") AS Remark'),DB::raw('IFNULL(prd_order_details.Symbol,"") AS Symbol'),
            'uoms.Name AS UomName','uoms.uomamount','uoms.bagweight','stores.Name AS StoreName',DB::raw('IFNULL(prd_order_processes.Remark,"")  AS ProcRemark'),'prd_order_processes.id AS ProcId',
            'uomprocess.Name AS ProcUomName','uomprocess.uomamount AS ProcUomAmount','uomprocess.bagweight AS ProcBagWeight','prd_order_processes.uoms_id AS ProcUomId','prd_order_details.VarianceShortage','prd_order_details.VarianceOverage',
            'prd_order_processes.VarianceShortage AS VarianceShortageProc','prd_order_processes.VarianceOverage AS VarianceOverageProc'
        ]);

        return datatables()->of($prdprocessdetaildata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function show($id)
    {
        //
    }

    public function showPoBom($id){
        $bomdetaildata=prd_bomdetail::where('prd_bomchildren_id',$id)
        ->join('woredas','prd_bomdetails.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('uoms','prd_bomdetails.uoms_id','uoms.id')
        ->orderBy('prd_bomdetails.id','ASC')
        ->get(['prd_bomdetails.*',DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_bomdetails.Remark,"") AS Remark'),'uoms.Name AS UomName','uoms.uomamount']);
    
        return response()->json(['bomdetaildata'=>$bomdetaildata]);
    }

    public function calcComBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $baseRecordId=$_POST['baseRecordId']??0;
        $commtype=$_POST['commtype']; 
        $origin=$_POST['origin']; 
        $grade=$_POST['grade']; 
        $processtype=$_POST['processtype']; 
        $cropyear=$_POST['cropyear']; 
        $storeval=$_POST['storeval']; 
        $floormap=$_POST['floormap']; 
        $uom=$_POST['uom']; 
        $cusOrOwner=$_POST['cusOrOwner']; 
        $supplierid=$_POST['supplierid']; 
        $grnnumber=$_POST['grnnumber']; 
        $prdordernumber=$_POST['prdordernumber']; 
        $certnumber=$_POST['certnumber']; 
        $statusval=["Pending","Ready","On-Production","Process-Finished","Verified"];
        $reqstatus=["Draft","Pending","Approved","Reviewed","Verified"];
        $adjstatus=["Draft","Pending","Verified"];
        $uomfactor=0;
        $uombagweight=0;

        $baseRecordId = !empty($baseRecordId) ? $baseRecordId : 0;
        $supplierid = !empty($supplierid) ? $supplierid : 0;
        $grnnumber = !empty($grnnumber) ? $grnnumber : 0;
        $prdordernumber = !empty($prdordernumber) ? $prdordernumber : 0;
        $certnumber = !empty($certnumber) ? $certnumber : 0;

        $uomprop = uom::where('id',$uom)->first();
        $uomfactor= $uomprop->uomamount;
        $uombagweight= $uomprop->bagweight;
        $uomname= $uomprop->Name;

        if($commtype==1){
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.LocationId='.$floormap.' AND transactions.ItemType="Commodity" AND transactions.uomId='.$uom.' AND transactions.SupplierId='.$supplierid.' AND transactions.GrnNumber="'.$grnnumber.'" AND transactions.TransactionType!="On-Production" AND transactions.customers_id='.$cusOrOwner);
            $qtystockoutdata=prd_order_detail::where('prd_order_details.CommodityType',$commtype)
                                               ->where('prd_order_details.woredas_id',$origin)
                                               ->where('prd_order_details.Grade',$grade)
                                               ->where('prd_order_details.ProcessType',$processtype)
                                               ->where('prd_order_details.CropYear',$cropyear)
                                               ->where('prd_order_details.stores_id',$storeval)
                                               ->where('prd_order_details.LocationId',$floormap)
                                               ->where('prd_order_details.SupplierId',$supplierid)
                                               ->where('prd_order_details.GrnNumber',$grnnumber)
                                               ->where('prd_order_details.uoms_id',$uom)
                                               ->where('prd_order_details.prd_orders_id',$baseRecordId)
                                               ->first();

            $qtystockoutdataoth=prd_order_detail::leftJoin('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
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
                                               ->where('prd_order_details.prd_orders_id','!=',$baseRecordId)
                                               ->whereIn('prd_orders.Status',$statusval)
                                               ->select(DB::raw('SUM(COALESCE(prd_order_details.QuantityInKG,0)) AS NetKg'),DB::raw('SUM(COALESCE(prd_order_details.Quantity,0)) AS NumOfBag'))
                                               ->groupBy('prd_order_details.CommodityType','prd_order_details.woredas_id','prd_order_details.Grade','prd_order_details.ProcessType','prd_order_details.CropYear','prd_order_details.stores_id','prd_order_details.SupplierId','prd_order_details.GrnNumber','prd_order_details.uoms_id')
                                               ->get();
        
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
                                                ->where('requisitions.CustomerOrOwner',$cusOrOwner)
                                                ->whereIn('requisitions.Status',$reqstatus)
                                                ->select(DB::raw('SUM(COALESCE(requisitiondetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(requisitiondetails.NetKg,0)) AS NetKg'))
                                                ->groupBy('requisitiondetails.CommodityType','requisitiondetails.CommodityId','requisitiondetails.Grade','requisitiondetails.ProcessType','requisitiondetails.CropYear','requisitiondetails.StoreId','requisitiondetails.SupplierId','requisitiondetails.GrnNumber','requisitiondetails.DefaultUOMId')
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
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.LocationId='.$floormap.' AND transactions.ItemType="Commodity" AND transactions.uomId='.$uom.' AND transactions.ProductionNumber="'.$prdordernumber.'" AND transactions.CertNumber="'.$certnumber.'" AND transactions.TransactionType!="On-Production" AND transactions.customers_id='.$cusOrOwner);
            $qtystockoutdata=prd_order_detail::where('prd_order_details.CommodityType',$commtype)
                                               ->where('prd_order_details.woredas_id',$origin)
                                               ->where('prd_order_details.Grade',$grade)
                                               ->where('prd_order_details.ProcessType',$processtype)
                                               ->where('prd_order_details.CropYear',$cropyear)
                                               ->where('prd_order_details.stores_id',$storeval)
                                               ->where('prd_order_details.LocationId',$floormap)
                                               ->where('prd_order_details.ProductionNumber',$prdordernumber)
                                               ->where('prd_order_details.CertNumber',$certnumber)
                                               ->where('prd_order_details.uoms_id',$uom)
                                               ->where('prd_order_details.prd_orders_id',$baseRecordId)
                                               ->first();

            $qtystockoutdataoth=prd_order_detail::leftJoin('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
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
                                               ->where('prd_order_details.prd_orders_id','!=',$baseRecordId)
                                               ->where('prd_orders.customers_id',$cusOrOwner)
                                               ->whereIn('prd_orders.Status',$statusval)
                                               ->select(DB::raw('SUM(COALESCE(prd_order_details.QuantityInKG,0)) AS NetKg'),DB::raw('SUM(COALESCE(prd_order_details.Quantity,0)) AS NumOfBag'))
                                               ->groupBy('prd_order_details.CommodityType','prd_order_details.woredas_id','prd_order_details.Grade','prd_order_details.ProcessType','prd_order_details.CropYear','prd_order_details.stores_id','prd_order_details.ProductionNumber','prd_order_details.CertNumber','prd_order_details.uoms_id')
                                               ->get();

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
                                                ->where('requisitions.CustomerOrOwner',$cusOrOwner)
                                                ->whereIn('requisitions.Status',$reqstatus)
                                                ->select(DB::raw('SUM(COALESCE(requisitiondetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(requisitiondetails.NetKg,0)) AS NetKg'))
                                                ->groupBy('requisitiondetails.CommodityType','requisitiondetails.CommodityId','requisitiondetails.Grade','requisitiondetails.ProcessType','requisitiondetails.CropYear','requisitiondetails.StoreId','requisitiondetails.ProductionOrderNo','requisitiondetails.CertNumber','requisitiondetails.DefaultUOMId')
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

        else if($commtype==3){
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.LocationId='.$floormap.' AND transactions.ItemType="Commodity" AND transactions.uomId='.$uom.' AND transactions.TransactionType!="On-Production" AND transactions.customers_id='.$cusOrOwner);
            $qtystockoutdata=prd_order_detail::where('prd_order_details.CommodityType',$commtype)
                                               ->where('prd_order_details.woredas_id',$origin)
                                               ->where('prd_order_details.Grade',$grade)
                                               ->where('prd_order_details.ProcessType',$processtype)
                                               ->where('prd_order_details.CropYear',$cropyear)
                                               ->where('prd_order_details.stores_id',$storeval)
                                               ->where('prd_order_details.LocationId',$floormap)
                                               ->where('prd_order_details.uoms_id',$uom)
                                               ->where('prd_order_details.prd_orders_id',$baseRecordId)
                                               ->first();

            $qtystockoutdataoth=prd_order_detail::leftJoin('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
                                               ->where('prd_order_details.CommodityType',$commtype)
                                               ->where('prd_order_details.woredas_id',$origin)
                                               ->where('prd_order_details.Grade',$grade)
                                               ->where('prd_order_details.ProcessType',$processtype)
                                               ->where('prd_order_details.CropYear',$cropyear)
                                               ->where('prd_order_details.stores_id',$storeval)
                                               ->where('prd_order_details.LocationId',$floormap)
                                               ->where('prd_order_details.uoms_id',$uom)
                                               ->where('prd_orders.customers_id',$cusOrOwner)
                                               ->where('prd_order_details.prd_orders_id','!=',$baseRecordId)
                                               ->whereIn('prd_orders.Status',$statusval)
                                               ->select(DB::raw('SUM(COALESCE(prd_order_details.QuantityInKG,0)) AS NetKg'),DB::raw('SUM(COALESCE(prd_order_details.Quantity,0)) AS NumOfBag'))
                                               ->groupBy('prd_order_details.CommodityType','prd_order_details.woredas_id','prd_order_details.Grade','prd_order_details.ProcessType','prd_order_details.CropYear','prd_order_details.stores_id','prd_order_details.ProductionNumber','prd_order_details.CertNumber','prd_order_details.uoms_id')
                                               ->get();

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
                                            ->whereIn('requisitions.Status',$reqstatus)
                                            ->select(DB::raw('SUM(COALESCE(requisitiondetails.NumOfBag,0)) AS NumOfBag'),DB::raw('SUM(COALESCE(requisitiondetails.NetKg,0)) AS NetKg'))
                                            ->groupBy('requisitiondetails.CommodityType','requisitiondetails.CommodityId','requisitiondetails.Grade','requisitiondetails.ProcessType','requisitiondetails.CropYear','requisitiondetails.StoreId','requisitiondetails.DefaultUOMId')
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

        //$averagecost=DB::select('SELECT ROUND((SUM(COALESCE(transactions.TotalCostComm,0)) / SUM(COALESCE(transactions.StockInComm,0))),2) AS AverageCost FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.TransactionsType IN("Beginning","Receiving","Production","Undo-Abort","Undo-Void") AND transactions.customers_id='.$cusOrOwner);
        //$avcost=$averagecost[0]->AverageCost ?? 0;

        $avcost = $this->calculateAverageCost($commtype,$origin,$grade,$processtype,$cropyear,$fyear,$cusOrOwner);
        
        $avbalancekg=$qtyonhandata[0]->AvailableBalanceKg ?? 0;
        $avbalancebag=$qtyonhandata[0]->AvailableBalanceBag ?? 0;
        $avbalanceother=round(($avbalancekg/$uomfactor),2);

        $stockoutkg=$qtystockoutdata->PrdWeightByKg ?? 0;
        $stockoutbag=$qtystockoutdata->PrdNumofBag ?? 0;

        //$avothbalancekg=$qtyothstockoutdata[0]->NetKg ?? 0;
        //$avothbalancebag=$qtyothstockoutdata[0]->NumOfBag ?? 0;

        $avothbalancekg = ($qtyothstockoutdata[0]->NetKg ?? 0) + ($adjdata[0]->NetKg ?? 0);
        $avothbalancebag = ($qtyothstockoutdata[0]->NumOfBag ?? 0) + ($adjdata[0]->NumOfBag ?? 0);

        $penstockoutkg = !empty($qtystockoutdataoth[0]->NetKg) ? $qtystockoutdataoth[0]->NetKg : 0;
        $penstockoutbag = !empty($qtystockoutdataoth[0]->NumOfBag) ? $qtystockoutdataoth[0]->NumOfBag : 0;

        $stockoutother=round(($stockoutkg/$uomfactor),2);

        return response()->json(['avbalancekg'=>$avbalancekg,'avbalancebag'=>$avbalancebag,'uomname'=>$uomname,'avbalanceother'=>$avbalanceother,
        'stockoutkg'=>$stockoutkg,'stockoutbag'=>$stockoutbag,'penstockoutkg'=>$penstockoutkg,'penstockoutbag'=>$penstockoutbag,'stockoutother'=>$stockoutother,
        'avothbalancekg'=>$avothbalancekg,'avothbalancebag'=>$avothbalancebag,'uomfactor'=>$uomfactor,'bagweight'=>$uombagweight,'avcost'=>$avcost]); 
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

    public function calcPrepComBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $baseRecordId=$_POST['baseRecordId']??0;
        $commtype=$_POST['commtype'];  
        $origin=$_POST['origin']; 
        $grade=$_POST['grade']; 
        $processtype=$_POST['processtype']; 
        $cropyear=$_POST['cropyear']; 
        $storeval=$_POST['storeval']; 
        $floormap=$_POST['floormap']; 
        $uom=$_POST['uom']; 

        $supplierid=$_POST['supplierid']; 
        $grnnumber=$_POST['grnnumber']; 
        $prdordernumber=$_POST['prdordernumber']; 
        $certnumber=$_POST['certnumber']; 

        $uomfactor=0;
        $uombagweight=0;
        $customerid=0;

        $baseRecordId = !empty($baseRecordId) ? $baseRecordId : 0;

        $prdorder=prd_order::find($baseRecordId);
        $customerid=$prdorder->customers_id;

        $uomprop = uom::where('id',$uom)->first();
        $uomfactor= $uomprop->uomamount;
        $uombagweight= $uomprop->bagweight;

        if($commtype==1){
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.LocationId='.$floormap.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.uomId='.$uom.' AND transactions.SupplierId='.$supplierid.' AND transactions.GrnNumber="'.$grnnumber.'" AND transactions.customers_id='.$customerid);
            $qtystockoutdata=DB::select('SELECT ROUND(SUM(COALESCE(transactions.StockOutNumOfBag,0)),2) AS StockOutBag,ROUND(SUM(COALESCE(transactions.StockOutComm,0)),2) AS StockOutKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.SupplierId='.$supplierid.' AND transactions.GrnNumber="'.$grnnumber.'" AND transactions.uomId='.$uom.' AND transactions.HeaderId='.$baseRecordId);
        }
        else if($commtype==2 || $commtype==4 || $commtype==5 || $commtype==6){
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.LocationId='.$floormap.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.ItemType="Commodity" AND transactions.uomId='.$uom.' AND transactions.ProductionNumber="'.$prdordernumber.'" AND transactions.CertNumber="'.$certnumber.'" AND transactions.customers_id='.$customerid);
            $qtystockoutdata=DB::select('SELECT ROUND(SUM(COALESCE(transactions.StockOutNumOfBag,0)),2) AS StockOutBag,ROUND(SUM(COALESCE(transactions.StockOutComm,0)),2) AS StockOutKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.CertNumber="'.$certnumber.'" AND transactions.uomId='.$uom.' AND transactions.ProductionNumber="'.$prdordernumber.'" AND transactions.HeaderId='.$baseRecordId);
        }
        else if($commtype==3){
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.LocationId='.$floormap.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.ItemType="Commodity" AND transactions.uomId='.$uom.' AND transactions.customers_id='.$customerid);
            $qtystockoutdata=DB::select('SELECT ROUND(SUM(COALESCE(transactions.StockOutNumOfBag,0)),2) AS StockOutBag,ROUND(SUM(COALESCE(transactions.StockOutComm,0)),2) AS StockOutKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$fyear.' AND transactions.CommodityType='.$commtype.' AND transactions.woredaId='.$origin.' AND transactions.Grade='.$grade.' AND transactions.ProcessType="'.$processtype.'" AND transactions.CropYear='.$cropyear.' AND transactions.StoreId='.$storeval.' AND transactions.uomId='.$uom.' AND transactions.HeaderId='.$baseRecordId);
        }

        $avbalancekg=$qtyonhandata[0]->AvailableBalanceKg ?? 0;
        $avbalancebag=$qtyonhandata[0]->AvailableBalanceBag ?? 0;
        $avbalanceother=round(($avbalancekg/$uomfactor),2);

        $stockoutkg=$qtystockoutdata[0]->StockOutKg ?? 0;
        $stockoutbag=$qtystockoutdata[0]->StockOutBag ?? 0;
        $stockoutother=round(($stockoutkg/$uomfactor),2);

        return response()->json(['avbalancekg'=>$avbalancekg,'avbalancebag'=>$avbalancebag,'avbalanceother'=>$avbalanceother,'stockoutkg'=>$stockoutkg,'stockoutbag'=>$stockoutbag,'stockoutother'=>$stockoutother,'uomfactor'=>$uomfactor,'uomid'=>$uom,'bagweight'=>$uombagweight]); 
    }

    public function getCommodityData(Request $request){
        $recordid=$_POST['recordid']; 
        $prdorderdetails=prd_order_detail::join('prd_orders','prd_order_details.prd_orders_id','prd_orders.id')
        ->join('woredas','prd_order_details.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('uoms','prd_order_details.uoms_id','uoms.id')
        ->join('stores','prd_order_details.stores_id','stores.id')
        ->leftJoin('lookups','prd_order_details.CommodityType','lookups.CommodityTypeValue')
        ->leftJoin('lookups AS croplookup','prd_order_details.CropYear','croplookup.CropYearValue')
        ->leftJoin('lookups AS grdlookup','prd_order_details.Grade','grdlookup.GradeValue')
        ->where('prd_order_details.id',$recordid)
        ->orderBy('prd_order_details.id','ASC')
        ->get(['prd_orders.OrderDate','prd_orders.ProductionStartDate','prd_order_details.*','prd_order_details.id AS PrdDetailId',
        'lookups.CommodityType AS CommodityTypeName','croplookup.CropYear AS CropYearName','grdlookup.Grade AS GradeName',
        DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_order_details.Remark,"") AS Remark'),DB::raw('IFNULL(prd_order_details.Symbol,"") AS Symbol'),
        'uoms.Name AS UomName','uoms.uomamount','uoms.bagweight','stores.Name AS StoreName']);

        return response()->json(['prdorderdetails'=>$prdorderdetails]);
    }

    public function prdChangeToPending(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->pendingid;
        $prdorder=prd_order::find($findid);

        if($prdorder->Status=="Draft"){
            try{
                $prdorder->Status="Pending";
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Change to Pending",'status'=>"Change to Pending",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function prdBackToPending(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtopendingid;
        $prdorder=prd_order::find($findid);

        if($prdorder->Status=="Ready"){
            try{
                $prdorder->Status="Pending";
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Back to Pending",'status'=>"Back to Pending",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToPendingComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function prdBackToReady(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->revcommentid;
        $prdorder=prd_order::find($findid);
        $statusval=$prdorder->Status;

        $validator = Validator::make($request->all(),[
            'BackToReadyComment' => 'required',
        ]);

        if($validator->passes()){
            if($prdorder->Status=="Reviewed"){
                try{
                    $prdorder->Status="Ready";
                    $prdorder->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Back to Ready",'status'=>"Back to Ready",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToReadyComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function verifyProduction(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->verifyid;
        $prdorder=prd_order::find($findid);

        if($prdorder->Status=="Production-Closed"){
            try{
                $prdorder->Status="Verified";
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Verified",'status'=>"Verified",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function approveProduction(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->approveid;
        $prdorder=prd_order::find($findid);

        if($prdorder->Status=="Verified"){
            try{
                $prdorder->Status="Approved";
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Approved",'status'=>"Approved",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function prdBackToVerify(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtoverifyid;
        $prdorder=prd_order::find($findid);
        $statusval=$prdorder->Status;

        $validator = Validator::make($request->all(),[
            'BackToVerifyComment' => 'required',
        ]);

        if($validator->passes()){
            if($prdorder->Status=="Approved"){
                try{
                    $prdorder->Status="Verified";
                    $prdorder->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Back to Verify",'status'=>"Back to Verify",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToVerifyComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function prdBackToDraft(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->commentid;
        $prdorder=prd_order::find($findid);

        $validator = Validator::make($request->all(),[
            'Comment' => 'required',
        ]);

        if($validator->passes()){
            if($prdorder->Status=="Pending"){
                try{
                    $prdorder->Status="Draft";
                    $prdorder->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Back to Draft",'status'=>"Back to Draft",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Comment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function completeProductions(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $transactiondata=[];
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->completeid;
        $prdorder=prd_order::find($findid);
        if($prdorder->Status=="Approved"){
            try
            {
                $prdfullexp=DB::select('SELECT prd_orders.ProductionOrderNumber,prd_orders.customers_id,prd_orders.CropYear AS CropYearVal,prd_orders.PrdWarehouse,prd_orders.ProcessType,prd_orders.Grade,prd_orders.woredas_id,prd_outputs.NetKg,prd_outputs.BagWeight,prd_outputs.Feresula,prd_outputs.VarianceShortage,prd_outputs.VarianceOverage,prd_outputs.CleanProductType,prd_outputs.FullUomId,prd_outputs.FullNumofBag,prd_outputs.FullWeightbyKg,prd_outputs.OutputType,prd_order_certs.CertificateNumber,prd_outputs.LocationId,prd_outputs.UnitCost,prd_outputs.TotalCost,prd_outputs.TaxCost,prd_outputs.GrandTotalCost FROM prd_outputs INNER JOIN prd_orders ON prd_outputs.prd_orders_id=prd_orders.id LEFT JOIN prd_order_certs ON prd_outputs.CertificationId=prd_order_certs.id WHERE IFNULL(prd_outputs.FullUomId,0)>0 AND IFNULL(prd_outputs.FullNumofBag,0)>0 AND IFNULL(prd_outputs.FullWeightbyKg,0)>0 AND prd_outputs.OutputType=1 AND prd_outputs.prd_orders_id='.$findid);
                foreach($prdfullexp as $prdfullexp){
                   
                    $unitcost = !empty($prdfullexp->UnitCost) ? $prdfullexp->UnitCost : 0;
                    $totalcost=round(($prdfullexp->FullWeightbyKg * $unitcost),2);
                    $grandtotalcost=round((($prdfullexp->FullWeightbyKg * $unitcost)*1.15),2);
                    $tax=$grandtotalcost-$totalcost;

                    $transactiondata[]=[
                        'HeaderId' => $findid,
                        'woredaId' => $prdfullexp->woredas_id,
                        'uomId' => $prdfullexp->FullUomId,
                        'LocationId' => $prdfullexp->LocationId,
                        'CommodityType' =>$prdfullexp->CleanProductType,
                        'Grade' =>  $prdfullexp->Grade,
                        'ProcessType' => $prdfullexp->ProcessType,
                        'CropYear' => $prdfullexp->CropYearVal,
                        'TotalKg' => $prdfullexp->FullWeightbyKg,
                        'BagWeight' => $prdfullexp->BagWeight,
                        'StockInComm' => $prdfullexp->NetKg,
                        'StockInFeresula' => $prdfullexp->Feresula,
                        'StockInNumOfBag' => $prdfullexp->FullNumofBag,
                        'VarianceShortage' => $prdfullexp->VarianceShortage,
                        'VarianceOverage' => $prdfullexp->VarianceOverage,
                        'UnitCostComm' => $unitcost,
                        'TaxCostComm' => $tax,
                        'TotalCostComm' => $totalcost,
                        'GrandTotalCostComm' => $grandtotalcost,
                        'ItemType' => "Commodity",
                        'FiscalYear' => $fyear,
                        'StoreId' => $prdfullexp->PrdWarehouse,
                        'SourceStore' => $prdfullexp->PrdWarehouse,
                        'SupplierId' =>"N/A",
                        'GrnNumber' => "N/A",
                        'ProductionNumber' => $prdfullexp->ProductionOrderNumber,
                        'CertNumber' => $prdfullexp->CertificateNumber??0,
                        'TransactionType' => 'Production',
                        'TransactionsType' => 'Production',
                        'Date' => Carbon::now(),
                        'DocumentNumber' => $prdfullexp->ProductionOrderNumber,
                        'customers_id' => $prdfullexp->customers_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }

                $prdfullrej=DB::select('SELECT prd_orders.ProductionOrderNumber,prd_orders.customers_id,prd_orders.CropYear AS CropYearVal,prd_orders.PrdWarehouse,prd_orders.ProcessType,prd_orders.Grade,prd_orders.woredas_id,prd_outputs.NetKg,prd_outputs.BagWeight,prd_outputs.Feresula,prd_outputs.VarianceShortage,prd_outputs.VarianceOverage,prd_outputs.CleanProductType,prd_outputs.FullUomId,prd_outputs.FullNumofBag,prd_outputs.FullWeightbyKg,prd_outputs.OutputType,prd_outputs.CertificationId,prd_outputs.LocationId,prd_outputs.UnitCost,prd_outputs.TotalCost,prd_outputs.TaxCost,prd_outputs.GrandTotalCost FROM prd_outputs INNER JOIN prd_orders ON prd_outputs.prd_orders_id=prd_orders.id LEFT JOIN prd_order_certs ON prd_outputs.CertificationId=prd_order_certs.id WHERE IFNULL(prd_outputs.FullUomId,0)>0 AND IFNULL(prd_outputs.FullNumofBag,0)>0 AND IFNULL(prd_outputs.FullWeightbyKg,0)>0 AND prd_outputs.OutputType=2 AND prd_outputs.prd_orders_id='.$findid);
                foreach($prdfullrej as $prdfullrej){
            
                    $unitcost = !empty($prdfullrej->UnitCost) ? $prdfullrej->UnitCost : 0;
                    $totalcost=round(($prdfullrej->FullWeightbyKg * $unitcost),2);
                    $grandtotalcost=round((($prdfullrej->FullWeightbyKg * $unitcost)*1.15),2);
                    $tax=$grandtotalcost-$totalcost;

                    $transactiondata[]=[
                        'HeaderId' => $findid,
                        'woredaId' => 1,
                        'uomId' => $prdfullrej->FullUomId,
                        'LocationId' => $prdfullrej->LocationId,
                        'CommodityType' =>3,
                        'Grade' =>  101,
                        'ProcessType' => $prdfullrej->ProcessType,
                        'CropYear' => 0,
                        'TotalKg' => $prdfullrej->FullWeightbyKg,
                        'BagWeight' => $prdfullrej->BagWeight,
                        'StockInComm' => $prdfullrej->NetKg,
                        'StockInFeresula' => $prdfullrej->Feresula,
                        'StockInNumOfBag' => $prdfullrej->FullNumofBag,
                        'VarianceShortage' => $prdfullrej->VarianceShortage,
                        'VarianceOverage' => $prdfullrej->VarianceOverage,
                        'UnitCostComm' => $unitcost,
                        'TaxCostComm' => $tax,
                        'TotalCostComm' => $totalcost,
                        'GrandTotalCostComm' => $grandtotalcost,
                        'ItemType' => "Commodity",
                        'FiscalYear' => $fyear,
                        'StoreId' => $prdfullrej->PrdWarehouse,
                        'SourceStore' => $prdfullrej->PrdWarehouse,
                        'SupplierId' => "N/A",
                        'GrnNumber' => "N/A",
                        'ProductionNumber' => $prdfullrej->ProductionOrderNumber,
                        'CertNumber' => $prdfullrej->CertificationId??0,
                        'TransactionType' => 'Production',
                        'TransactionsType' => 'Production',
                        'Date' => Carbon::now(),
                        'DocumentNumber' => $prdfullrej->ProductionOrderNumber,
                        'customers_id' => $prdfullrej->customers_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }

                $prdwastage=DB::select('SELECT prd_orders.ProductionOrderNumber,prd_orders.customers_id,prd_orders.PrdWarehouse,prd_orders.ProcessType,prd_orders.Grade,prd_orders.woredas_id,prd_outputs.NetKg,prd_outputs.BagWeight,prd_outputs.Feresula,prd_outputs.VarianceShortage,prd_outputs.VarianceOverage,prd_outputs.CleanProductType,prd_outputs.FullUomId,prd_outputs.FullNumofBag,prd_outputs.FullWeightbyKg,prd_outputs.OutputType,prd_outputs.CertificationId,prd_outputs.LocationId,prd_outputs.UnitCost,prd_outputs.TotalCost,prd_outputs.TaxCost,prd_outputs.GrandTotalCost FROM prd_outputs INNER JOIN prd_orders ON prd_outputs.prd_orders_id=prd_orders.id LEFT JOIN prd_order_certs ON prd_outputs.CertificationId=prd_order_certs.id WHERE IFNULL(prd_outputs.FullWeightbyKg,0)>0 AND prd_outputs.OutputType=3 AND prd_outputs.BiProductId=3 AND prd_outputs.prd_orders_id='.$findid);
                foreach($prdwastage as $prdwastage){

                    $unitcost = !empty($prdwastage->UnitCost) ? $prdwastage->UnitCost : 0;
                    $totalcost=round(($prdwastage->FullWeightbyKg * $unitcost),2);
                    $grandtotalcost=round((($prdwastage->FullWeightbyKg * $unitcost)*1.15),2);
                    $tax=$grandtotalcost-$totalcost;
                    
                    $transactiondata[]=[
                        'HeaderId' => $findid,
                        'woredaId' => 2,
                        'uomId' => $prdwastage->FullUomId,
                        'LocationId' => $prdwastage->LocationId,
                        'CommodityType' =>7,
                        'Grade' => 101,
                        'ProcessType' => $prdwastage->ProcessType,
                        'CropYear' =>0,
                        'TotalKg' => $prdwastage->FullWeightbyKg,
                        'BagWeight' => $prdwastage->BagWeight,
                        'StockInComm' => $prdwastage->NetKg,
                        'StockInFeresula' =>  $prdwastage->Feresula,
                        'StockInNumOfBag' => $prdwastage->FullNumofBag,
                        'VarianceShortage' => $prdwastage->VarianceShortage,
                        'VarianceOverage' => $prdwastage->VarianceOverage,
                        'UnitCostComm' => $unitcost,
                        'TaxCostComm' => $tax,
                        'TotalCostComm' => $totalcost,
                        'GrandTotalCostComm' => $grandtotalcost,
                        'ItemType' => "Commodity",
                        'FiscalYear' => $fyear,
                        'StoreId' => $prdwastage->PrdWarehouse,
                        'SourceStore' => $prdwastage->PrdWarehouse,
                        'SupplierId' =>"N/A",
                        'GrnNumber' => "N/A",
                        'ProductionNumber' => $prdwastage->ProductionOrderNumber,
                        'CertNumber' => $prdwastage->CertificationId??0,
                        'TransactionType' => 'Production',
                        'TransactionsType' => 'Production',
                        'Date' => Carbon::now(),
                        'DocumentNumber' => $prdwastage->ProductionOrderNumber,
                        'customers_id'=>$prdwastage->customers_id,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now()
                    ];
                }

                transaction::where('transactions.HeaderId',$findid)
                ->whereIn('transactions.TransactionType',["Production","On-Production"])
                ->update(['ShipmentQuantity'=>0,'ShipmentQuantityFeresula'=>0,'ShipmentQuantityNumofBag'=>0,'TransactionType'=>"Production"]);

                transaction::insert($transactiondata);
                transaction::where('transactions.HeaderId',$findid)->whereIn('transactions.TransactionType',["Production","On-Production"])->where('transactions.IsOnShipment',1)->delete();

                $prdorder->Status="Completed";
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Completed",'status'=>"Completed",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function prdChangeToReady(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->readyid;
        $prdorder=prd_order::find($findid);
        $expectedamount=($prdorder->ExpectedAmount??0)*(int)1000;

        $actualdata=0;
        $inserteddata=0;
        $shortageamount=0;
        $overageamount=0;
        $shortageerrorflag=0;
        $overageerrorflag=0;
        $shortageval=[];

        $varianceshortagecount=0;
        $varianceoveragecount=0;

        $varianceshortagecomm=[];
        $varianceoveragecomm=[];
        $ratiototalnetkg=0;
        
        $countprdorder = prd_order_detail::where('prd_orders_id',$findid)->count();
        $getproductiondata=DB::select('SELECT COALESCE(SUM(prd_order_details.QuantityInKG),0) AS TotalKG FROM prd_order_details WHERE prd_order_details.prd_orders_id='.$findid);
        foreach($getproductiondata as $prdrow){
            $ratiototalnetkg+= (float)$prdrow->TotalKG??0;
            $shortageamount=((float)$prdrow->TotalKG??0)*((int) 1 - ((float)$this->disshortagepercent / (int)100));
            $overageamount=((float)$prdrow->TotalKG??0)*((int) 1 + ((float)$this->disoveragepercent / (int)100));
        }

        if((float)$expectedamount < (float)$shortageamount){
            $shortageerrorflag+=1;
        }
        if((float)$expectedamount > (float)$overageamount){
            $overageerrorflag+=1;
        }

        if($prdorder->Status=="Pending" && $countprdorder>0 && $expectedamount>0 && $ratiototalnetkg>=$expectedamount){
            try{
                $prdorder->Status="Ready";
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Change to Ready",'status'=>"Change to Ready",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($expectedamount==0){
            return Response::json(['prdexperror' =>459]);
        }
        else if($countprdorder==0){
            return Response::json(['prdordererror' =>462]);
        }
        else if($ratiototalnetkg < $expectedamount){
            return Response::json(['ratiodisc' =>461]);
        }
        else{
            return Response::json(['statuserror' =>463]);
        }
    }

    public function prdChangeToReview(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->reviewid;
        $prdorder=prd_order::find($findid);

        if($prdorder->Status=="Ready"){
            try{
                $prdorder->Status="Reviewed";
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Reviewed",'status'=>"Reviewed",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function prdOrderVoid(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->voidid;
        $prdorder=prd_order::find($findid);
        $statusval=$prdorder->Status;

        $validator = Validator::make($request->all(),[
            'Reason' => 'required',
        ]);

        if($validator->passes()){
            if($prdorder->Status=="Draft" || $prdorder->Status=="Pending" || $prdorder->Status=="Ready"){
                try{
                    $prdorder->Status="Void(".$statusval.")";
                    $prdorder->OldStatus=$statusval;
                    $prdorder->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Void",'status'=>"Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Reason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function prdCompleteOrderVoid(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $transactiondata=[];
        $transactionrejdata=[];
        $stockdata=[];
        $fullexportcnt=0;
        $expcommodityid=[];
        $partialexportcnt=0;
        $partialcommodityid=[];

        $fullrejectcnt=0;
        $fullrejcommodityid=[];
        $partialrejectcnt=0;
        $partialrejcommodityid=[];
        $findid=$request->voidcompid;
        $prdorder=prd_order::find($findid);
        $statusval=$prdorder->Status;
        $documentnum=$prdorder->Status;

        $validator = Validator::make($request->all(),[
            'VoidReason' => 'required',
        ]);

        if($prdorder->Status=="Completed"){
            //------------Start checking stock balance for the export commodity-----------------
            $prdfullexp=DB::select('SELECT prd_orders.ProductionOrderNumber,prd_orders.customers_id,prd_orders.PrdWarehouse,prd_orders.ProcessType,prd_orders.Grade,prd_orders.woredas_id,prd_outputs.FullUomId,prd_outputs.FullNumofBag,prd_outputs.FullWeightbyKg,prd_outputs.OutputType,prd_order_certs.CertificateNumber,prd_outputs.LocationId FROM prd_outputs INNER JOIN prd_orders ON prd_outputs.prd_orders_id=prd_orders.id LEFT JOIN prd_order_certs ON prd_outputs.CertificationId=prd_order_certs.id WHERE IFNULL(prd_outputs.FullUomId,0)>0 AND IFNULL(prd_outputs.FullNumofBag,0)>0 AND IFNULL(prd_outputs.FullWeightbyKg,0)>0 AND prd_outputs.OutputType=1 AND prd_outputs.prd_orders_id='.$findid);
            foreach($prdfullexp as $prdfullexp){
                $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$prdorder->FiscalYear.' AND transactions.CommodityType=2 AND transactions.woredaId='.$prdfullexp->woredas_id.' AND transactions.Grade='.$prdfullexp->Grade.' AND transactions.ProcessType="'.$prdfullexp->ProcessType.'" AND transactions.StoreId='.$prdfullexp->PrdWarehouse.' AND transactions.LocationId='.$prdfullexp->LocationId.' AND transactions.TransactionsType IN("Beginning","Production","Undo-Abort","Undo-Void") AND transactions.ItemType="Commodity" AND transactions.uomId='.$prdfullexp->FullUomId.' AND transactions.customers_id='.$prdfullexp->customers_id);
                $avbalancekg=$qtyonhandata[0]->AvailableBalanceKg ?? 0;
                $avbalancebag=$qtyonhandata[0]->AvailableBalanceBag ?? 0;

                if($avbalancekg<$prdfullexp->FullWeightbyKg || $avbalancebag<$prdfullexp->FullNumofBag){
                    $fullexportcnt+=1;
                    $expcommodityid[]=$prdfullexp->woredas_id;
                }
            }

            $prdparexp=DB::select('SELECT prd_orders.ProductionOrderNumber,prd_orders.customers_id,prd_orders.PrdWarehouse,prd_orders.ProcessType,prd_orders.Grade,prd_orders.woredas_id,prd_outputs.PartialUomId,prd_outputs.PartialNumofBag,prd_outputs.PartialWeightbyKg,prd_outputs.OutputType,prd_order_certs.CertificateNumber,prd_outputs.LocationId FROM prd_outputs INNER JOIN prd_orders ON prd_outputs.prd_orders_id=prd_orders.id LEFT JOIN prd_order_certs ON prd_outputs.CertificationId=prd_order_certs.id WHERE IFNULL(prd_outputs.PartialUomId,0)>0 AND IFNULL(prd_outputs.PartialNumofBag,0)>0 AND IFNULL(prd_outputs.PartialWeightbyKg,0)>0 AND prd_outputs.OutputType=1 AND prd_outputs.prd_orders_id='.$findid);
            foreach($prdparexp as $prdparexp){
                $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$prdorder->FiscalYear.' AND transactions.CommodityType=2 AND transactions.woredaId='.$prdparexp->woredas_id.' AND transactions.Grade='.$prdparexp->Grade.' AND transactions.ProcessType="'.$prdparexp->ProcessType.'" AND transactions.StoreId='.$prdparexp->PrdWarehouse.' AND transactions.LocationId='.$prdparexp->LocationId.' AND transactions.TransactionsType IN("Beginning","Production","Undo-Abort","Undo-Void") AND transactions.ItemType="Commodity" AND transactions.uomId='.$prdparexp->PartialUomId.' AND transactions.customers_id='.$prdparexp->customers_id);
                $avbalancekg=$qtyonhandata[0]->AvailableBalanceKg ?? 0;
                $avbalancebag=$qtyonhandata[0]->AvailableBalanceBag ?? 0;

                if($avbalancekg<$prdparexp->PartialWeightbyKg || $avbalancebag<$prdparexp->PartialNumofBag){
                    $partialexportcnt+=1;
                    $partialcommodityid[]=$prdparexp->woredas_id;
                }
            }

            $prdfullrej=DB::select('SELECT prd_orders.ProductionOrderNumber,prd_orders.customers_id,prd_orders.PrdWarehouse,prd_orders.ProcessType,prd_orders.Grade,prd_orders.woredas_id,prd_outputs.FullUomId,prd_outputs.FullNumofBag,prd_outputs.FullWeightbyKg,prd_outputs.OutputType,prd_order_certs.CertificateNumber,prd_outputs.LocationId FROM prd_outputs INNER JOIN prd_orders ON prd_outputs.prd_orders_id=prd_orders.id LEFT JOIN prd_order_certs ON prd_outputs.CertificationId=prd_order_certs.id WHERE IFNULL(prd_outputs.FullUomId,0)>0 AND IFNULL(prd_outputs.FullNumofBag,0)>0 AND IFNULL(prd_outputs.FullWeightbyKg,0)>0 AND prd_outputs.OutputType=2 AND prd_outputs.prd_orders_id='.$findid);
            foreach($prdfullrej as $prdfullrej){
                $qtyonhanrejdata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$prdorder->FiscalYear.' AND transactions.CommodityType=3 AND transactions.woredaId=1 AND transactions.Grade=101 AND transactions.ProcessType="'.$prdfullrej->ProcessType.'" AND transactions.StoreId='.$prdfullrej->PrdWarehouse.' AND transactions.LocationId='.$prdfullrej->LocationId.' AND transactions.TransactionsType IN("Beginning","Production","Undo-Abort","Undo-Void") AND transactions.ItemType="Commodity" AND transactions.uomId='.$prdfullrej->FullUomId.' AND transactions.customers_id='.$prdfullrej->customers_id);
                $avbalancekg=$qtyonhanrejdata[0]->AvailableBalanceKg ?? 0;
                $avbalancebag=$qtyonhanrejdata[0]->AvailableBalanceBag ?? 0;

                if($avbalancekg<$prdfullrej->FullWeightbyKg || $avbalancebag<$prdfullrej->FullNumofBag){
                    $fullrejectcnt+=1;
                    $fullrejcommodityid[]=$prdfullrej->woredas_id;
                }
            }

            $prdparrej=DB::select('SELECT prd_orders.ProductionOrderNumber,prd_orders.customers_id,prd_orders.PrdWarehouse,prd_orders.ProcessType,prd_orders.Grade,prd_orders.woredas_id,prd_outputs.PartialUomId,prd_outputs.PartialNumofBag,prd_outputs.PartialWeightbyKg,prd_outputs.OutputType,prd_order_certs.CertificateNumber,prd_outputs.LocationId FROM prd_outputs INNER JOIN prd_orders ON prd_outputs.prd_orders_id=prd_orders.id LEFT JOIN prd_order_certs ON prd_outputs.CertificationId=prd_order_certs.id WHERE IFNULL(prd_outputs.PartialUomId,0)>0 AND IFNULL(prd_outputs.PartialNumofBag,0)>0 AND IFNULL(prd_outputs.PartialWeightbyKg,0)>0 AND prd_outputs.OutputType=2 AND prd_outputs.prd_orders_id='.$findid);
            foreach($prdparrej as $prdparrej){
                $qtyonhanrejdata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$prdorder->FiscalYear.' AND transactions.CommodityType=3 AND transactions.woredaId=1 AND transactions.Grade=101 AND transactions.ProcessType="'.$prdparrej->ProcessType.'" AND transactions.StoreId='.$prdparrej->PrdWarehouse.' AND transactions.LocationId='.$prdparrej->LocationId.' AND transactions.TransactionsType IN("Beginning","Production","Undo-Abort","Undo-Void") AND transactions.ItemType="Commodity" AND transactions.uomId='.$prdparrej->FullUomId.' AND transactions.customers_id='.$prdparrej->customers_id);
                $avbalancekg=$qtyonhanrejdata[0]->AvailableBalanceKg ?? 0;
                $avbalancebag=$qtyonhanrejdata[0]->AvailableBalanceBag ?? 0;

                if($avbalancekg<$prdparrej->PartialWeightbyKg || $avbalancebag<$prdparrej->PartialNumofBag){
                    $partialrejectcnt+=1;
                    $partialrejcommodityid[]=$prdparrej->woredas_id;
                }
            }
            //------------End checking stock balance for the export commodity-----------------
        }

        if($validator->passes() && $fullexportcnt==0 && $partialexportcnt==0 && $fullrejectcnt==0 && $partialrejectcnt==0){
            if($prdorder->Status=="Completed" || $prdorder->Status=="Process-Finished" || $prdorder->Status=="Production-Closed" || $prdorder->Status=="Verified"){
                try{
                    if($prdorder->Status=="Completed"){
                        $tranData= DB::select('SELECT * FROM transactions WHERE transactions.TransactionsType="Production" AND IFNULL(transactions.StockInNumOfBag,0)>0 AND IFNULL(transactions.StockInComm,0)>0 AND IFNULL(transactions.StockInFeresula,0)>0 AND transactions.HeaderId='.$findid);
                        foreach($tranData as $trdata){
                            $origin="";
                            $grade="";
                            $cropyear="";
                            if($trdata->CommodityType==1 || $trdata->CommodityType==2){
                                $origin=$trdata->woredaId;
                                $grade= $trdata->Grade;
                                $cropyear=$trdata->CropYear;
                            }
                            else{
                                $origin=1;
                                $grade=101;
                                $cropyear=0;
                            }
                            $transactiondata[]=[
                                'HeaderId' => $findid,
                                'woredaId' => $origin,
                                'uomId' => $trdata->uomId,
                                'LocationId' => $trdata->LocationId,
                                'CommodityType' => $trdata->CommodityType,
                                'Grade' => $grade,
                                'ProcessType' => $trdata->ProcessType,
                                'CropYear' => $cropyear,
                                'StockInComm' => 0,
                                'StockInFeresula' => 0,
                                'StockInNumOfBag' => 0,
                                'UnitCostComm' => 0,
                                'TaxCostComm' => 0,
                                'TotalCostComm' => 0,
                                'GrandTotalCostComm' => 0,
                                'StockOutComm' => $trdata->StockInComm,
                                'StockOutFeresula' => $trdata->StockInFeresula,
                                'StockOutNumOfBag' => $trdata->StockInNumOfBag,
                                'UnitPriceComm' => $trdata->UnitCostComm,
                                'TaxPriceComm' => $trdata->TaxCostComm,
                                'TotalPriceComm' => $trdata->TotalCostComm,
                                'GrandTotalPriceComm' => $trdata->GrandTotalCostComm,
                                'ItemType' => "Commodity",
                                'FiscalYear' =>$trdata->FiscalYear,
                                'StoreId' => $trdata->StoreId,
                                'SourceStore' => $trdata->StoreId,
                                'SupplierId' => $trdata->SupplierId,
                                'GrnNumber' => $trdata->GrnNumber,
                                'ProductionNumber' => $trdata->ProductionNumber,
                                'CertNumber' => $trdata->CertNumber,
                                'TransactionType' => 'Production',
                                'TransactionsType' => 'Void',
                                'Date' => Carbon::now(),
                                'DocumentNumber' => $trdata->ProductionNumber,
                                'customers_id'=>$trdata->customers_id,
                                'created_at'=>Carbon::now(),
                                'updated_at'=>Carbon::now()
                            ];
                        }
                    }

                    $tranExpData=DB::select('SELECT * FROM transactions WHERE transactions.TransactionsType="Production" AND IFNULL(transactions.StockOutNumOfBag,0)>0 AND IFNULL(transactions.StockOutComm,0)>0 AND IFNULL(transactions.StockOutFeresula,0)>0 AND transactions.HeaderId='.$findid);
                    foreach($tranExpData as $trexpdata){
                        $origin="";
                        $grade="";
                        $cropyear="";
                        if($trexpdata->CommodityType==1 || $trexpdata->CommodityType==2){
                            $origin=$trexpdata->woredaId;
                            $grade= $trexpdata->Grade;
                            $cropyear=$trexpdata->CropYear;
                        }
                        else{
                            $origin=1;
                            $grade=101;
                            $cropyear=0;
                        }
                        $transactiondata[]=[
                            'HeaderId' => $findid,
                            'woredaId' => $origin,
                            'uomId' => $trexpdata->uomId,
                            'LocationId' => $trexpdata->LocationId,
                            'CommodityType' => $trexpdata->CommodityType,
                            'Grade' => $grade,
                            'ProcessType' => $trexpdata->ProcessType,
                            'CropYear' => $cropyear,
                            'StockInComm' => $trexpdata->StockOutComm,
                            'StockInFeresula' => $trexpdata->StockOutFeresula,
                            'StockInNumOfBag' => $trexpdata->StockOutNumOfBag,
                            'UnitCostComm' => $trexpdata->UnitPriceComm,
                            'TaxCostComm' => $trexpdata->TaxPriceComm,
                            'TotalCostComm' => $trexpdata->TotalPriceComm,
                            'GrandTotalCostComm' => $trexpdata->GrandTotalPriceComm,
                            'StockOutComm' => 0,
                            'StockOutFeresula' => 0,
                            'StockOutNumOfBag' => 0,
                            'UnitPriceComm' =>0,
                            'TaxPriceComm' => 0,
                            'TotalPriceComm' =>0,
                            'GrandTotalPriceComm' => 0,
                            'ItemType' => "Commodity",
                            'FiscalYear' =>$trexpdata->FiscalYear,
                            'StoreId' => $trexpdata->StoreId,
                            'SourceStore' => $trexpdata->StoreId,
                            'SupplierId' => $trexpdata->SupplierId,
                            'GrnNumber' => $trexpdata->GrnNumber,
                            'ProductionNumber' => $trexpdata->ProductionNumber,
                            'CertNumber' => $trexpdata->CertNumber,
                            'TransactionType' => 'Production',
                            'TransactionsType' => 'Void',
                            'Date' => Carbon::now(),
                            'DocumentNumber' => $trexpdata->DocumentNumber,
                            'customers_id'=>$trexpdata->customers_id,
                            'created_at'=>Carbon::now(),
                            'updated_at'=>Carbon::now()
                        ];
                    }

                    transaction::where('transactions.HeaderId',$findid)
                    ->where('transactions.TransactionType',"Production")
                    ->update(['IsVoid'=>1,'IsPriceVoid'=>1]);

                    transaction::insert($transactiondata);

                    if($prdorder->Status=="Process-Finished" || $prdorder->Status=="Production-Closed" || $prdorder->Status=="Verified"){
                        transaction::where('transactions.HeaderId',$findid)->where('transactions.TransactionType',"Production")->where('transactions.IsOnShipment',1)->delete();
                    }

                    $prdorder->Status="Void(".$statusval.")";
                    $prdorder->OldStatus=$statusval;
                    $prdorder->save();

                    
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Void",'status'=>"Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->VoidReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        else if ($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
        else if($fullexportcnt>0){
            $expcommodityid=implode(',', $expcommodityid);
            $origin=DB::select('SELECT CONCAT(zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id WHERE woredas.id IN('.$expcommodityid.')');
            return Response::json(['fullexperr' => 461,'origindata' => $origin]);
        }
        else if($partialexportcnt>0){
            $partialcommodityid=implode(',', $partialcommodityid);
            $origin=DB::select('SELECT CONCAT(zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id WHERE woredas.id IN('.$partialcommodityid.')');
            return Response::json(['parexperr' => 462,'origindata' => $origin]);
        }
        else if($fullrejectcnt>0){
            $fullrejcommodityid=implode(',', $fullrejcommodityid);
            $origin=DB::select('SELECT CONCAT(zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id WHERE woredas.id IN('.$fullrejcommodityid.')');
            return Response::json(['fullrejerr' => 463,'origindata' => $origin]);
        }
        else if($partialrejectcnt>0){
            $partialrejcommodityid=implode(',', $partialrejcommodityid);
            $origin=DB::select('SELECT CONCAT(zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id WHERE woredas.id IN('.$partialrejcommodityid.')');
            return Response::json(['parrejerr' => 464,'origindata' => $origin]);
        }
    }

    public function compPrdOrderUndoVoid(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $commcnt=0;
        $commid=[];
        $stockdata=[];
        $transactiondata=[];
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->undocompvoidid;
        $prdorder=prd_order::find($findid);
        $oldstatusval=$prdorder->OldStatus;
        $productionstr=$prdorder->PrdWarehouse;

        //------------Start checking stock balance for the export commodity---------------
        $commProp=DB::select('SELECT prd_order_details.woredas_id,woredas.Type AS CommType,prd_order_details.Grade,prd_order_details.ProcessType,prd_order_details.stores_id,COALESCE(SUM(prd_order_processes.QuantityByUom),0) AS NumberofBag,COALESCE(SUM(prd_order_processes.QuantityByKg),0) AS WeightbyKG,prd_order_processes.* FROM prd_order_processes INNER JOIN prd_order_details ON prd_order_processes.prd_order_details_id=prd_order_details.id INNER JOIN woredas ON prd_order_details.woredas_id=woredas.id WHERE prd_order_processes.prd_orders_id='.$findid.' GROUP BY prd_order_details.woredas_id,prd_order_details.Grade,prd_order_details.ProcessType,prd_order_processes.LocationId,prd_order_processes.uoms_id');
        foreach($commProp as $commProp){
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$prdorder->FiscalYear.' AND transactions.CommodityType='.$commProp->CommType.' AND transactions.woredaId='.$commProp->woredas_id.' AND transactions.Grade='.$commProp->Grade.' AND transactions.ProcessType="'.$commProp->ProcessType.'" AND transactions.StoreId='.$commProp->stores_id.' AND transactions.LocationId='.$commProp->LocationId.' AND transactions.uomId='.$commProp->uoms_id.' AND transactions.customers_id='.$prdorder->customers_id);
            $avbalancekg=$qtyonhandata[0]->AvailableBalanceKg ?? 0;
            $avbalancebag=$qtyonhandata[0]->AvailableBalanceBag ?? 0;

            if($avbalancekg<$commProp->WeightbyKG || $avbalancebag<$commProp->NumberofBag){
                $commcnt+=1;
                $commid[]=$commProp->woredas_id;
            }
        }
        //------------End checking stock balance for the export commodity-----------------

        if( ($prdorder->Status=="Void(Completed)" || $prdorder->Status=="Void(Process-Finished)" || $prdorder->Status=="Void(Production-Closed)" || $prdorder->Status=="Void(Verified)") && $commcnt==0){
            try{
                $tranData=DB::select('SELECT * FROM transactions WHERE transactions.TransactionsType="Production" AND IFNULL(transactions.StockInNumOfBag,0)>0 AND IFNULL(transactions.StockInComm,0)>0 AND IFNULL(transactions.StockInFeresula,0)>0 AND transactions.HeaderId='.$findid);
                foreach($tranData as $trdata){
                    $origin="";
                    $grade="";
                    $cropyear="";
                    if($trdata->CommodityType==1 || $trdata->CommodityType==2){
                        $origin=$trdata->woredaId;
                        $grade= $trdata->Grade;
                        $cropyear=$trdata->CropYear;
                    }
                    else{
                        $origin=1;
                        $grade=101;
                        $cropyear=0;
                    }
                    $transactiondata[]=[
                        'HeaderId' => $findid,
                        'woredaId' => $origin,
                        'uomId' => $trdata->uomId,
                        'LocationId' => $trdata->LocationId,
                        'CommodityType' => $trdata->CommodityType,
                        'Grade' => $grade,
                        'ProcessType' => $trdata->ProcessType,
                        'CropYear' => $cropyear,
                        'StockInComm' => $trdata->StockInComm,
                        'StockInFeresula' =>$trdata->StockInFeresula,
                        'StockInNumOfBag' => $trdata->StockInNumOfBag,
                        'UnitCostComm' => $trdata->UnitCostComm,
                        'TaxCostComm' => $trdata->TaxCostComm,
                        'TotalCostComm' => $trdata->TotalCostComm,
                        'GrandTotalCostComm' => $trdata->GrandTotalCostComm,
                        'StockOutComm' => 0,
                        'StockOutFeresula' => 0,
                        'StockOutNumOfBag' => 0,
                        'UnitPriceComm' => 0,
                        'TaxPriceComm' => 0,
                        'TotalPriceComm' => 0,
                        'GrandTotalPriceComm' => 0,
                        'ShipmentQuantity' => 0,
                        'ShipmentQuantityFeresula' => 0,
                        'ShipmentQuantityNumofBag' => 0,
                        'ItemType' => "Commodity",
                        'FiscalYear' =>$trdata->FiscalYear,
                        'StoreId' => $trdata->StoreId,
                        'SourceStore' => $trdata->StoreId,
                        'SupplierId' => $trdata->SupplierId,
                        'GrnNumber' => $trdata->GrnNumber,
                        'ProductionNumber' => $trdata->ProductionNumber,
                        'CertNumber' => $trdata->CertNumber,
                        'TransactionType' => 'Production',
                        'TransactionsType' => 'Undo-Void',
                        'Date' => Carbon::now(),
                        'DocumentNumber' => $trdata->ProductionNumber,
                        'customers_id'=>$trdata->customers_id,
                        'IsOnShipment' => 0,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now()
                    ];
                }

                $tranExpData=DB::select('SELECT * FROM transactions WHERE transactions.TransactionsType="Production" AND IFNULL(transactions.StockOutNumOfBag,0)>0 AND IFNULL(transactions.StockOutComm,0)>0 AND IFNULL(transactions.StockOutFeresula,0)>0 AND transactions.HeaderId='.$findid);
                foreach($tranExpData as $trexpdata){
                    $origin="";
                    $grade="";
                    $cropyear="";
                    if($trexpdata->CommodityType==1 || $trexpdata->CommodityType==2){
                        $origin=$trexpdata->woredaId;
                        $grade= $trexpdata->Grade;
                        $cropyear=$trexpdata->CropYear;
                    }
                    else{
                        $origin=1;
                        $grade=101;
                        $cropyear=0;
                    }
                    $transactiondata[]=[
                        'HeaderId' => $findid,
                        'woredaId' => $origin,
                        'uomId' => $trexpdata->uomId,
                        'LocationId' => $trexpdata->LocationId,
                        'CommodityType' => $trexpdata->CommodityType,
                        'Grade' => $grade,
                        'ProcessType' => $trexpdata->ProcessType,
                        'CropYear' => $cropyear,
                        'StockInComm' => 0,
                        'StockInFeresula' => 0,
                        'StockInNumOfBag' => 0,
                        'UnitCostComm' => 0,
                        'TaxCostComm' => 0,
                        'TotalCostComm' => 0,
                        'GrandTotalCostComm' => 0,
                        'StockOutComm' => $trexpdata->StockOutComm,
                        'StockOutFeresula' => $trexpdata->StockOutFeresula,
                        'StockOutNumOfBag' => $trexpdata->StockOutNumOfBag,
                        'UnitPriceComm' => $trexpdata->UnitPriceComm,
                        'TaxPriceComm' => $trexpdata->TaxPriceComm,
                        'TotalPriceComm' => $trexpdata->TotalPriceComm,
                        'GrandTotalPriceComm' => $trexpdata->GrandTotalPriceComm,
                        'ShipmentQuantity' => 0,
                        'ShipmentQuantityFeresula' => 0,
                        'ShipmentQuantityNumofBag' => 0,
                        'ItemType' => "Commodity",
                        'FiscalYear' =>$trexpdata->FiscalYear,
                        'StoreId' => $trexpdata->StoreId,
                        'SourceStore' => $trexpdata->StoreId,
                        'SupplierId' => $trexpdata->SupplierId,
                        'GrnNumber' => $trexpdata->GrnNumber,
                        'ProductionNumber' => $trexpdata->ProductionNumber,
                        'CertNumber' => $trexpdata->CertNumber,
                        'TransactionType' => 'Production',
                        'TransactionsType' => 'Undo-Void',
                        'Date' => Carbon::now(),
                        'DocumentNumber' => $trexpdata->DocumentNumber,
                        'customers_id'=>$trexpdata->customers_id,
                        'IsOnShipment' => 0,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now()
                    ];
                }

                if($prdorder->Status=="Void(Process-Finished)" || $prdorder->Status=="Void(Production-Closed)" || $prdorder->Status=="Void(Verified)"){
                    $tranExpData=DB::select('SELECT * FROM transactions WHERE transactions.TransactionsType="Production" AND IFNULL(transactions.StockOutNumOfBag,0)>0 AND IFNULL(transactions.StockOutComm,0)>0 AND IFNULL(transactions.StockOutFeresula,0)>0 AND transactions.HeaderId='.$findid);
                    foreach($tranExpData as $trexpdata){
                        $origin="";
                        $grade="";
                        $cropyear="";
                        if($trexpdata->CommodityType==1 || $trexpdata->CommodityType==2){
                            $origin=$trexpdata->woredaId;
                            $grade= $trexpdata->Grade;
                            $cropyear=$trexpdata->CropYear;
                        }
                        else{
                            $origin=1;
                            $grade=101;
                            $cropyear=0;
                        }
                        $transactiondata[]=[
                            'HeaderId' => $findid,
                            'woredaId' => $origin,
                            'uomId' => $trexpdata->uomId,
                            'LocationId' => $trexpdata->LocationId,
                            'CommodityType' => $trexpdata->CommodityType,
                            'Grade' => $grade,
                            'ProcessType' => $trexpdata->ProcessType,
                            'CropYear' => $cropyear,
                            'StockInComm' => 0,
                            'StockInFeresula' => 0,
                            'StockInNumOfBag' => 0,
                            'UnitCostComm' => 0,
                            'TaxCostComm' => 0,
                            'TotalCostComm' => 0,
                            'GrandTotalCostComm' => 0,
                            'StockOutComm' => 0,
                            'StockOutFeresula' => 0,
                            'StockOutNumOfBag' => 0,
                            'UnitPriceComm' => 0,
                            'TaxPriceComm' => 0,
                            'TotalPriceComm' => 0,
                            'GrandTotalPriceComm' => 0,
                            'ShipmentQuantity' => $trexpdata->StockOutComm,
                            'ShipmentQuantityFeresula' => $trexpdata->StockOutFeresula,
                            'ShipmentQuantityNumofBag' => $trexpdata->StockOutNumOfBag,
                            'ItemType' => "Commodity",
                            'FiscalYear' =>$trexpdata->FiscalYear,
                            'StoreId' => $productionstr,
                            'SourceStore' => $trexpdata->StoreId,
                            'SupplierId' => $trexpdata->SupplierId,
                            'GrnNumber' => $trexpdata->GrnNumber,
                            'ProductionNumber' => $trexpdata->ProductionNumber,
                            'CertNumber' => $trexpdata->CertNumber,
                            'TransactionType' => 'Production',
                            'TransactionsType' => 'Production',
                            'Date' => Carbon::now(),
                            'DocumentNumber' => $trexpdata->DocumentNumber,
                            'customers_id'=>$trexpdata->customers_id,
                            'IsOnShipment' => 1,
                            'created_at'=>Carbon::now(),
                            'updated_at'=>Carbon::now()
                        ];
                    }
                }

                transaction::insert($transactiondata);

                $prdorder->Status=$oldstatusval;
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Undo Void",'status'=>"Undo Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($commcnt>0)
        {
            $commid=implode(',', $commid);
            $origin=DB::select('SELECT CONCAT(zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id WHERE woredas.id IN('.$commid.')');
            return Response::json(['commerror'=>461,'origindata'=>$origin]);
        }
        else{
            return Response::json(['statuserror' =>462]);
        }
    }

    public function prdOrderUndoVoid(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->undovoidid;
        $prdorder=prd_order::find($findid);
        $oldstatusval=$prdorder->OldStatus;

        if($prdorder->Status=="Void" || $prdorder->Status=="Void(Draft)" || $prdorder->Status=="Void(Pending)" || $prdorder->Status=="Void(Ready)"){
            try{
                $prdorder->Status=$oldstatusval;
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Undo Void",'status'=>"Undo Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($countprdorder==0)
        {
            return Response::json(['prdordererror' =>462]);
        }
        else{
            return Response::json(['statuserror' =>462]);
        }
    }

    public function saveProduction(Request $request){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $transactiondata=[];
        $kgdata=[];
        $currenttime=Carbon::now();
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->productionId;
        $findid=$request->recId;
        $prdStatus=$request->prdStatusVal;
        $actions=null;
        $acstatus=null;
        $cerids=[];
        $detids=[];
        $adjdata=[];
        $commstflag=0;

        $validator = Validator::make($request->all(),[
            'ProductionStore' => 'required',
        ]);

        $rules=array(
            'preprow.*.prepDate' => 'required',
            'preprow.*.prepFloorMap' => 'required',
            'preprow.*.prepUom' => 'required',
            'preprow.*.prepQtyOnHand' => 'required|gt:0',
            'preprow.*.prepQuantity' => 'required|lte:preprow.*.prepQtyOnHand|gt:0',
            'preprow.*.prepQuantityInKg' => 'required|gt:0',
        );
        $v2= Validator::make($request->all(), $rules);

        if($validator->passes() && $v2->passes() && $request->preprow!=null){
            foreach ($request->preprow as $key => $value){
                $detids[]=$value['prepid'];
            }

            prd_order_process::where('prd_order_processes.prd_orders_id',$headerid)->whereNotIn('id',$detids)->delete();
            DB::table('transactions')->where('HeaderId',$headerid)->where('TransactionType',"On-Production")->delete();
            prd_order_detail::where('prd_order_details.prd_orders_id',$headerid)->update(['MoisturePercent'=>0,'PrdWeightByKg'=>0,'PrdNumofBag'=>0,'PrdBagByKg'=>0,'PrdAdjustment'=>0,'PrdNetWeight'=>0]);

            foreach ($request->preprow as $key => $value){
                prd_order_process::updateOrCreate(['id' => $value['prepid']],
                [ 
                    'prd_orders_id'=>$headerid,
                    'prd_order_details_id'=>$value['commRecId'],
                    'Date'=>$value['prepDate'],
                    'LocationId'=>$value['prepFloorMap'],
                    'uoms_id'=>(int)$value['prepUom'],
                    'QuantityByUom'=>(float)$value['prepQuantity'],
                    'QuantityByKg'=>(float)$value['prepQuantityInKg'],
                    'VarianceShortage'=>(float)$value['varianceshortage'],
                    'VarianceOverage'=>(float)$value['varianceoverage'],
                    'Remark'=>$value['prepRemark']
                ]);

                foreach ($request->comtotrow as $keycomm => $valuecomm){
                    $currentidval=$valuecomm['CurrentDetailIdVal'];
                    if($currentidval == $value['commRecId']){
                        prd_order_detail::where('prd_order_details.id',$value['commRecId'])->update(['MoisturePercent'=>$valuecomm['MoisturePercent'],'PrdWeightByKg'=>$valuecomm['WeightKG'],'PrdNumofBag'=>$valuecomm['NoOfBag'],'PrdBagByKg'=>$valuecomm['BagWeight'],'PrdAdjustment'=>$valuecomm['Adjustment'],'PrdNetWeight'=>$valuecomm['NetWeight'],'VarianceShortage'=>$valuecomm['totvarshortageinp'],'VarianceOverage'=>$valuecomm['totvaroverageinp']]);
                    }
                }
                
                $prdorder=prd_order::find($headerid);
                $prdorderdetail=prd_order_detail::find($value['commRecId']);

                $transactiondata[]=[
                    'HeaderId' => $headerid,
                    'woredaId' => $prdorderdetail->woredas_id,
                    'uomId' => $prdorderdetail->uoms_id,
                    'LocationId' => $value['prepFloorMap'],
                    'CommodityType' => $prdorderdetail->CommodityType,
                    'Grade' =>  $prdorderdetail->Grade,
                    'ProcessType' => $prdorderdetail->ProcessType,
                    'CropYear' => $prdorderdetail->CropYear,
                    'StockInComm' => 0,
                    'StockInFeresula' => 0,
                    'StockInNumOfBag' => 0,
                    'UnitCostComm' => 0,
                    'TaxCostComm' => 0,
                    'TotalCostComm' => 0,
                    'GrandTotalCostComm' => 0,
                    'StockOutComm' => $value['prepQuantityInKg'],
                    'StockOutFeresula' => round(($value['prepQuantityInKg']/17),2),
                    'StockOutNumOfBag' => $value['prepQuantity'],
                    'UnitPriceComm' => $prdorderdetail->UnitCost,
                    'TaxPriceComm' => round((($prdorderdetail->UnitCost * $value['prepQuantityInKg'])*1.15)-($prdorderdetail->UnitCost * $value['prepQuantityInKg']),2),
                    'TotalPriceComm' => round(($prdorderdetail->UnitCost * $value['prepQuantityInKg']),2),
                    'GrandTotalPriceComm' => round((($prdorderdetail->UnitCost * $value['prepQuantityInKg'])*1.15),2),
                    'ShipmentQuantity' => 0,
                    'ShipmentQuantityFeresula' => 0,
                    'ShipmentQuantityNumofBag' => 0,
                    'ItemType' => "Commodity",
                    'FiscalYear' => $fyear,
                    'StoreId' => $prdorderdetail->stores_id,
                    'SourceStore' => $prdorderdetail->stores_id,
                    'SupplierId' => $prdorderdetail->SupplierId,
                    'GrnNumber' => $prdorderdetail->GrnNumber,
                    'ProductionNumber' => $prdorderdetail->ProductionNumber,
                    'CertNumber' => $prdorderdetail->CertNumber,
                    'TransactionType' => 'On-Production',
                    'TransactionsType' => 'Production',
                    'IsOnShipment' => 0,
                    'Date' => Carbon::now(),
                    'DocumentNumber' => $prdorder->ProductionOrderNumber,
                    'customers_id'=>$prdorder->customers_id,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now()
                ];

                $transactiondata[]=[
                    'HeaderId' => $headerid,
                    'woredaId' => $prdorderdetail->woredas_id,
                    'uomId' => $prdorderdetail->uoms_id,
                    'LocationId' => $value['prepFloorMap'],
                    'CommodityType' => $prdorderdetail->CommodityType,
                    'Grade' =>  $prdorderdetail->Grade,
                    'ProcessType' => $prdorderdetail->ProcessType,
                    'CropYear' => $prdorderdetail->CropYear,
                    'StockInComm' => 0,
                    'StockInFeresula' => 0,
                    'StockInNumOfBag' => 0,
                    'UnitCostComm' => 0,
                    'TaxCostComm' => 0,
                    'TotalCostComm' => 0,
                    'GrandTotalCostComm' => 0,
                    'StockOutComm' => 0,
                    'StockOutFeresula' => 0,
                    'StockOutNumOfBag' => 0,
                    'UnitPriceComm' => 0,
                    'TaxPriceComm' => 0,
                    'TotalPriceComm' => 0,
                    'GrandTotalPriceComm' => 0,
                    'ShipmentQuantity' => $value['prepQuantityInKg'],
                    'ShipmentQuantityFeresula' => round(($value['prepQuantityInKg']/17),2),
                    'ShipmentQuantityNumofBag' => $value['prepQuantity'],
                    'ItemType' => "Commodity",
                    'FiscalYear' => $fyear,
                    'StoreId' => $request->ProductionStore,
                    'SourceStore' => $prdorderdetail->stores_id,
                    'SupplierId' => $prdorderdetail->SupplierId,
                    'GrnNumber' => $prdorderdetail->GrnNumber,
                    'ProductionNumber' => $prdorderdetail->ProductionNumber,
                    'CertNumber' => $prdorderdetail->CertNumber,
                    'TransactionType' => 'On-Production',
                    'TransactionsType' => 'Production',
                    'IsOnShipment' => 1,
                    'Date' => Carbon::now(),
                    'DocumentNumber' => $prdorder->ProductionOrderNumber,
                    'customers_id'=>$prdorder->customers_id,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now()
                ];

                $kgdata[]=$value['prepQuantityInKg'];
            }


            transaction::insert($transactiondata);

            prd_order::where('prd_orders.id',$headerid)->update(['prd_orders.PrdWarehouse'=>$request->ProductionStore,'prd_orders.Status'=>"On-Production",'prd_orders.PrdStatus'=>"On-Production",
            'MoisturePercent'=>$request->MoisturePercentTotal,'PrdWeightByKg'=>$request->WeightinKGVal,'PrdNumofBag'=>$request->NoOfBagVal ,'PrdBagByKg'=>$request->BagWeightVal,
            'PrdAdjustment'=>$request->AdjustmentVal,'PrdNetWeight'=>$request->NetWeightVal,'VarianceShortage'=>$request->gTotalVarianceShortage,'VarianceOverage'=>$request->gTotalVarianceOverage]);     

            if((int)$prdStatus == 1){
                $actions="Started/Created";
                $acstatus="Production Process Started";
            }
            else if((int)$prdStatus == 2){
                $actions="Edited";
                $acstatus="Production Process Edited";
            }

            actions::insert(['user_id'=>$userid,'pageid'=>$headerid,'pagename'=>"prdorder",'action'=>$acstatus,'status'=>$acstatus,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            return Response::json(['success' =>1]);
        }

        if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
        if($request->preprow==null)
        {
            return response()->json(['emptyrow'=>462]);
        }
    }

    public function prdOrderAbort(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->abortid;
        $prdorder=prd_order::find($findid);
        $statusval=$prdorder->Status;
        $prdorderdoc=$prdorder->ProductionOrderNumber;
        //$statusval=$prdorder->Status;

        $validator = Validator::make($request->all(),[
            'AbortReason' => 'required',
        ]);

        if($validator->passes()){
            if($prdorder->Status=="On-Production"){
                try{
                    $tranData=DB::select('SELECT * FROM transactions WHERE transactions.TransactionsType="Production" AND IFNULL(transactions.StockOutNumOfBag,0)>0 AND IFNULL(transactions.StockOutComm,0)>0 AND IFNULL(transactions.StockOutFeresula,0)>0 AND transactions.HeaderId='.$findid);
                    foreach($tranData as $trdata){
                        $origin="";
                        $grade="";
                        $cropyear="";
                        if($trdata->CommodityType==1 || $trdata->CommodityType==2){
                            $origin=$trdata->woredaId;
                            $grade= $trdata->Grade;
                            $cropyear=$trdata->CropYear;
                        }
                        else{
                            $origin=1;
                            $grade=101;
                            $cropyear=0;
                        }
                        $transactiondata[]=[
                            'HeaderId' => $findid,
                            'woredaId' => $origin,
                            'uomId' => $trdata->uomId,
                            'LocationId' => $trdata->LocationId,
                            'CommodityType' => $trdata->CommodityType,
                            'Grade' => $grade,
                            'ProcessType' => $trdata->ProcessType,
                            'CropYear' => $cropyear,
                            'StockInComm' => $trdata->StockOutComm,
                            'StockInFeresula' => $trdata->StockOutFeresula,
                            'StockInNumOfBag' => $trdata->StockOutNumOfBag,
                            'UnitCostComm' => $trdata->UnitPriceComm,
                            'TaxCostComm' => $trdata->TaxPriceComm,
                            'TotalCostComm' => $trdata->TotalPriceComm,
                            'GrandTotalCostComm' => $trdata->GrandTotalPriceComm,
                            'ItemType' => "Commodity",
                            'FiscalYear' =>$trdata->FiscalYear,
                            'StoreId' => $trdata->StoreId,
                            'SourceStore' => $trdata->StoreId,
                            'SupplierId' => $trdata->SupplierId,
                            'GrnNumber' => $trdata->GrnNumber,
                            'ProductionNumber' => $trdata->ProductionNumber,
                            'CertNumber' => $trdata->CertNumber,
                            'TransactionType' => 'Production',
                            'TransactionsType' => 'Abort',
                            'Date' => Carbon::now(),
                            'DocumentNumber' => $trdata->ProductionNumber,
                            'customers_id'=>$trdata->customers_id,
                            'created_at'=>Carbon::now(),
                            'updated_at'=>Carbon::now()
                        ];
                    }

                    transaction::where('transactions.HeaderId',$findid)
                    ->where('transactions.TransactionType',"Production")
                    ->update(['IsVoid'=>1,'IsPriceVoid'=>1]);

                    transaction::insert($transactiondata);
                    transaction::where('transactions.HeaderId',$findid)->where('transactions.TransactionType',"Production")->where('transactions.IsOnShipment',1)->delete();

                    $prdorder->Status="Aborted";
                    $prdorder->OldStatus=$statusval;
                    $prdorder->save();

                    // DB::table('transactions')->where('HeaderId',$findid)->where('IsOnShipment',1)->where('TransactionType',"Production")->delete();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Aborted",'status'=>"Aborted",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->AbortReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function prdOrderUndoAbort(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $commcnt=0;
        $commid=[];
        $stockdata=[];
        $transactiondata=[];
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->undoabortid;
        $prdorder=prd_order::find($findid);
        $oldstatusval=$prdorder->OldStatus;
        $prdorderdoc=$prdorder->ProductionOrderNumber;
        $prdstoreid=$prdorder->PrdWarehouse;

        //------------Start checking stock balance for the export commodity---------------
        $commProp=DB::select('SELECT prd_order_details.woredas_id,woredas.Type AS CommType,prd_order_details.Grade,prd_order_details.ProcessType,prd_order_details.stores_id,COALESCE(SUM(prd_order_processes.QuantityByUom),0) AS NumberofBag,COALESCE(SUM(prd_order_processes.QuantityByKg),0) AS WeightbyKG,prd_order_processes.* FROM prd_order_processes INNER JOIN prd_order_details ON prd_order_processes.prd_order_details_id=prd_order_details.id INNER JOIN woredas ON prd_order_details.woredas_id=woredas.id WHERE prd_order_processes.prd_orders_id='.$findid.' GROUP BY prd_order_details.woredas_id,prd_order_details.Grade,prd_order_details.ProcessType,prd_order_processes.LocationId,prd_order_processes.uoms_id');
        foreach($commProp as $commProp){
            $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockInNumOfBag,0))-SUM(COALESCE(transactions.StockOutNumOfBag,0))),2) AS AvailableBalanceBag,ROUND((SUM(COALESCE(transactions.StockInComm,0))-SUM(COALESCE(transactions.StockOutComm,0))),2) AS AvailableBalanceKg FROM transactions WHERE transactions.ItemType="Commodity" AND transactions.FiscalYear='.$prdorder->FiscalYear.' AND transactions.CommodityType='.$commProp->CommType.' AND transactions.woredaId='.$commProp->woredas_id.' AND transactions.Grade='.$commProp->Grade.' AND transactions.ProcessType="'.$commProp->ProcessType.'" AND transactions.StoreId='.$commProp->stores_id.' AND transactions.LocationId='.$commProp->LocationId.' AND transactions.uomId='.$commProp->uoms_id.' AND transactions.customers_id='.$prdorder->customers_id);
            $avbalancekg=$qtyonhandata[0]->AvailableBalanceKg ?? 0;
            $avbalancebag=$qtyonhandata[0]->AvailableBalanceBag ?? 0;

            if($avbalancekg<$commProp->WeightbyKG || $avbalancebag<$commProp->NumberofBag){
                $commcnt+=1;
                $commid[]=$commProp->woredas_id;
            }
            $stockdata[]=$avbalancekg." = ".$commProp->WeightbyKG." = ".$avbalancebag." = ".$commProp->NumberofBag;
        }
        //------------End checking stock balance for the export commodity-----------------

        if($prdorder->Status=="Aborted" && $commcnt==0){
            try{
                $getRatioData=DB::select('SELECT prd_order_details.*,prd_order_processes.QuantityByUom,prd_order_processes.QuantityByKg AS PrdQuantityKg,prd_order_processes.LocationId,uoms.uomamount FROM prd_order_processes INNER JOIN prd_order_details ON prd_order_processes.prd_order_details_id=prd_order_details.id INNER JOIN uoms ON prd_order_processes.uoms_id=uoms.id WHERE prd_order_processes.prd_orders_id='.$findid);
                foreach($getRatioData as $ratiorow){
                    $origin="";
                    $grade="";
                    $cropyear="";
                    if($ratiorow->CommodityType==1 || $ratiorow->CommodityType==2){
                        $origin=$ratiorow->woredas_id;
                        $grade= $ratiorow->Grade;
                        $cropyear=$ratiorow->CropYear;
                    }
                    else{
                        $origin=1;
                        $grade=101;
                        $cropyear=0;
                    }

                    $totalprice=round(($ratiorow->PrdQuantityKg * $ratiorow->UnitCost),2);
                    $grandtotal=round(($totalprice*1.15),2);
                    $tax=round(($grandtotal-$totalprice),2);

                    $transactiondata[]=[
                        'HeaderId' => $findid,
                        'woredaId' => $origin,
                        'uomId' => $ratiorow->uoms_id,
                        'CommodityType' => $ratiorow->CommodityType,
                        'Grade' => $grade,
                        'ProcessType' => $ratiorow->ProcessType,
                        'CropYear' => $cropyear,
                        'StockOutComm' => $ratiorow->PrdQuantityKg,
                        'StockOutFeresula' => round(($ratiorow->PrdQuantityKg/17),2),
                        'StockOutNumOfBag' => $ratiorow->QuantityByUom,
                        'UnitPriceComm' => $ratiorow->UnitCost,
                        'TaxPriceComm' => $tax,
                        'TotalPriceComm' => $totalprice,
                        'GrandTotalPriceComm' => $grandtotal,
                        'ShipmentQuantity' => 0,
                        'ShipmentQuantityFeresula' => 0,
                        'ShipmentQuantityNumofBag' => 0,
                        'ItemType' => "Commodity",
                        'FiscalYear' => $fyear,
                        'StoreId' => $ratiorow->stores_id,
                        'SourceStore' => $ratiorow->stores_id,
                        'LocationId' => $ratiorow->LocationId,
                        'SupplierId' => $ratiorow->SupplierId,
                        'GrnNumber' => $ratiorow->GrnNumber,
                        'ProductionNumber' => $ratiorow->ProductionNumber,
                        'CertNumber' => $ratiorow->CertNumber,
                        'TransactionType' => 'Production',
                        'TransactionsType' => 'Undo-Abort',
                        'IsOnShipment' => 0,
                        'Date' => Carbon::now(),
                        'DocumentNumber' => $prdorder->ProductionOrderNumber,
                        'customers_id'=> $prdorder->customers_id,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now()
                    ];

                    $transactiondata[]=[
                        'HeaderId' => $findid,
                        'woredaId' => $origin,
                        'uomId' => $ratiorow->uoms_id,
                        'CommodityType' => $ratiorow->CommodityType,
                        'Grade' => $grade,
                        'ProcessType' => $ratiorow->ProcessType,
                        'CropYear' => $cropyear,
                        'StockOutComm' => 0,
                        'StockOutFeresula' => 0,
                        'StockOutNumOfBag' => 0,
                        'UnitPriceComm' => 0,
                        'TaxPriceComm' => 0,
                        'TotalPriceComm' => 0,
                        'GrandTotalPriceComm' => 0,
                        'ShipmentQuantity' => $ratiorow->PrdQuantityKg,
                        'ShipmentQuantityFeresula' => round(($ratiorow->PrdQuantityKg/17),2),
                        'ShipmentQuantityNumofBag' => $ratiorow->QuantityByUom,
                        'ItemType' => "Commodity",
                        'FiscalYear' => $fyear,
                        'StoreId' => $prdorder->PrdWarehouse,
                        'SourceStore' => $ratiorow->stores_id,
                        'LocationId' => $ratiorow->LocationId,
                        'SupplierId' => $ratiorow->SupplierId,
                        'GrnNumber' => $ratiorow->GrnNumber,
                        'ProductionNumber' => $ratiorow->ProductionNumber,
                        'CertNumber' => $ratiorow->CertNumber,
                        'TransactionType' => 'On-Production',
                        'TransactionsType' => 'Production',
                        'IsOnShipment' => 1,
                        'Date' => Carbon::now(),
                        'DocumentNumber' => $prdorder->ProductionOrderNumber,
                        'customers_id'=> $prdorder->customers_id,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now()
                    ];
                }
                transaction::insert($transactiondata);

                $prdorder->Status=$oldstatusval;
                $prdorder->save();

                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Undo Abort",'status'=>"Undo Abort",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($commcnt>0){
            $commid=implode(',', $commid);
            $origin=DB::select('SELECT CONCAT(zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id WHERE woredas.id IN('.$commid.')');
            return Response::json(['commerror'=>461,'origindata'=>$origin]);
        }
        else if($countprdorder==0){
            return Response::json(['prdordererror' =>462]);
        }
        else{
            return Response::json(['statuserror' =>462]);
        }
    }

    public function prdStartProcess(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $curdate=Carbon::today()->toDateString();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->startprdprcid;
        $prdorder=prd_order::find($findid);
        $oldstatusval=$prdorder->OldStatus;
        try{
            prd_duration::insert([
                'prd_orders_id' => $findid,
                'StartTime' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'StartedBy' => $userid,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            prd_order::where('prd_orders.id',$findid)->update(['CurrentWorkStatus'=>"Started"]);
            prd_order::where('prd_orders.id',$findid)->whereNull('ProductionStartDate')->update(['ProductionStartDate'=>$curdate]);

            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function prdPauseProcess(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->pauseprdprcid;
        $prdorder=prd_order::find($findid);
        $oldstatusval=$prdorder->OldStatus;
        try{
            prd_duration::where('prd_durations.prd_orders_id',$findid)->whereNull('EndTime')->orWhere('EndTime','')->update(['EndTime'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'PausedBy'=>$userid,'updated_at'=>Carbon::now(),'Duration'=>DB::raw('ROUND((TIMESTAMPDIFF(SECOND,prd_durations.created_at,"'.Carbon::now().'")/60),2)')]);
            prd_order::where('prd_orders.id',$findid)->update(['CurrentWorkStatus'=>"Paused"]);
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function prdCompleteProcess(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $curdate=Carbon::today()->toDateString();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->completeprdprcid;
        $prdorder=prd_order::find($findid);
        $oldstatusval=$prdorder->OldStatus;
        $statusval=$prdorder->Status;
        $totaldurationcnt=0;
        $totaldurationval=0;

        $actualdata=0;
        $inserteddata=0;
        $shortageamount=0;
        $overageamount=0;
        $shortageval=[];
        $totalratioamount=0;
        $totalprocessamount=0;

        $varianceshortagecount=0;
        $varianceoveragecount=0;

        $varianceshortagecomm=[];
        $varianceoveragecomm=[];

        $netratioamount=0;
        $netprdweightamount=0;
        
        $getproductiondata=DB::select('SELECT * FROM prd_order_details WHERE prd_order_details.prd_orders_id='.$findid);
        foreach($getproductiondata as $prdrow){
            $totalratioamount+=(float)$prdrow->QuantityInKG??0;
            $shortageamount=((float)$prdrow->PrdWeightByKg??0)*((int) 1 - ((float)$this->shortagepercent / (int)100));
            $overageamount=((float)$prdrow->PrdWeightByKg??0)*((int) 1 + ((float)$this->overagepercent / (int)100));
            
            if((float)$prdrow->PrdWeightByKg < (float)$shortageamount){
                $varianceshortagecount+=1;
                $varianceshortagecomm[]=$prdrow->woredas_id;
            }
            if((float)$prdrow->PrdWeightByKg > (float)$overageamount){
                $varianceoveragecount+=1;
                $varianceoveragecomm[]=$prdrow->woredas_id;
            }
        }

        $getprocessdata=DB::select('SELECT prd_order_processes.QuantityByKg FROM prd_order_processes WHERE prd_order_processes.prd_orders_id='.$findid);
        foreach($getprocessdata as $prcrow){
            $totalprocessamount+=(float)$prcrow->QuantityByKg??0;
        }


        $netratioamount=round($totalratioamount,2);
        $netprdweightamount=round($totalprocessamount,2);

        $totaldurationcount=DB::select('SELECT COUNT(prd_durations.id) AS PrdCount FROM prd_durations WHERE (prd_durations.PausedBy IS NULL OR prd_durations.PausedBy="") AND prd_durations.prd_orders_id='.$findid);
        $totaldurationcnt=$totaldurationcount[0]->PrdCount ?? 0;

        $totaldurationdata=DB::select('SELECT COUNT(prd_durations.id) AS PrdCountVal FROM prd_durations WHERE prd_durations.prd_orders_id='.$findid);
        $totaldurationval=$totaldurationdata[0]->PrdCountVal ?? 0;

        if($prdorder->Status=="On-Production" && $totaldurationcnt==0 && $totaldurationval>0 && $varianceshortagecount==0 && $varianceoveragecount==0 && $netratioamount==$netprdweightamount){
            try{
                $prdorder->Status="Process-Finished";
                $prdorder->OldStatus=$statusval;
                $prdorder->ProductionEndDate=$curdate;
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Process-Finished",'status'=>"Process-Finished",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($prdorder->Status!="On-Production"){
            return Response::json(['statuserror'=>462]);
        }
        else if($totaldurationcnt>=1){
            return Response::json(['durationerror'=>462]);
        }
        else if($totaldurationval==0){
            return Response::json(['durationemptyerror'=>463]);
        }
        else if($netratioamount!=$netprdweightamount){
            return Response::json(['discrerror'=>464]);
        }
        else if($varianceshortagecount>0){
            $shorg=implode(',', $varianceshortagecomm);
            $originshortage=DB::select('SELECT woredas.id,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE woredas.id IN('.$shorg.')');
            return Response::json(['shortagerr'=>464,'originshortage'=>$originshortage]);
        }
        else if($varianceoveragecount>0){
            $ovorg=implode(',', $varianceoveragecomm);
            $originoverage=DB::select('SELECT woredas.id,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE woredas.id IN('.$ovorg.')');
            return Response::json(['overagerr'=>465,'originoverage'=>$originoverage]);
        }
    }

    public function prdBackToProduction(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtoproductionid;
        $prdorder=prd_order::find($findid);
        $statusval=$prdorder->Status;

        $validator = Validator::make($request->all(),[
            'BackToProductionReason' => 'required',
        ]);

        if($validator->passes()){
            if($prdorder->Status=="Process-Finished"){
                try{
                    $prdorder->Status="On-Production";
                    $prdorder->OldStatus=$statusval;
                    $prdorder->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Back to Production",'status'=>"Back to Production",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToProductionReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function prdBackToCloseProduction(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtoclproductionid;
        $prdorder=prd_order::find($findid);
        $statusval=$prdorder->Status;

        $validator = Validator::make($request->all(),[
            'BackToCloseProductionReason' => 'required',
        ]);

        if($validator->passes()){
            if($prdorder->Status=="Production-Closed"){
                try{
                    $prdorder->Status="Process-Finished";
                    $prdorder->OldStatus=$statusval;
                    $prdorder->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Back to Production",'status'=>"Back to Production",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToCloseProductionReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function prdBackToProductionVer(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtoproductionverid;
        $prdorder=prd_order::find($findid);
        $statusval=$prdorder->Status;

        $validator = Validator::make($request->all(),[
            'BackToProductionsReason' => 'required',
        ]);

        if($validator->passes()){
            if($prdorder->Status=="Verified"){
                try{
                    $prdorder->Status="Production-Closed";
                    $prdorder->OldStatus=$statusval;
                    $prdorder->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Back to Production",'status'=>"Back to Production",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToProductionsReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function submitExport(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->prdoutputid;
        $prdorder=prd_order::find($findid);
        $prdinput=$prdorder->PrdWeightByKg;
        $percentage=0;
        $percent=100;
        $arrdata=[];
        $detids=[];
        $totalbagnum=0;
        $totalweightkg=0;
        $certnumerdata=DB::select('SELECT id FROM prd_order_certs WHERE prd_order_certs.prd_orders_id='.$findid);
        foreach($certnumerdata as $cerRow){
            $arrdata[]=$cerRow->id;
        }
        $arrdata = implode(',', $arrdata);

        $rules=array(
            'exprow.*.expfloormap' => 'required',
            'exprow.*.expcertnum' => 'required',
            'exprow.*.expcoffeetype' => 'required',
            'exprow.*.exprefuom' => 'required',
            'exprow.*.exprefbagnum' => 'required',
            'exprow.*.bagweight' => 'required',
            'exprow.*.exptotalkg' => 'required',
            'exprow.*.expnetkg' => 'required',
            //'exprow.*.exprefkg' => ['required_if:exprow.*.expcertnum,'.$arrdata],
        );
        $v2= Validator::make($request->all(), $rules);

        if($v2->passes()){
            if($prdorder->Status=="Process-Finished"){
                try{
                    
                    if($request->exprow==null){
                        prd_output::where('prd_outputs.prd_orders_id',$findid)->where('prd_outputs.OutputType',1)->delete();
                    }
                    else if($request->exprow!=null){  
                        foreach ($request->exprow as $key => $value){
                            $detids[]=$value['expid'];
                        }

                        $averagecost=DB::select('SELECT ROUND((SUM(COALESCE(prd_order_processes.QuantityByKg,0))),2) AS TotalNetKg FROM prd_order_processes WHERE prd_order_processes.prd_orders_id='.$findid);
                        $unitcost = !empty($averagecost[0]->AverageCost) ? $averagecost[0]->AverageCost : 0;

                        prd_output::where('prd_outputs.prd_orders_id',$findid)->where('prd_outputs.OutputType',1)->whereNotIn('prd_outputs.id',$detids)->delete();

                        foreach ($request->exprow as $key => $value){
                            $unitcost = !empty($value['expunitcost']) ? $value['expunitcost'] : 0;
                            $netkg = !empty($value['expnetkg']) ? $value['expnetkg'] : 0;

                            $totalcost=round(($netkg * $unitcost),2);
                            $grandtotalcost=round((($netkg * $unitcost)*1.15),2);
                            $tax=round(($grandtotalcost-$totalcost),2);

                            $percentage=round((($netkg * $percent) / $prdinput),2);

                            prd_output::updateOrCreate(['id' => $value['expid']],
                            [ 
                                'prd_orders_id'=>$findid,
                                'OutputType'=>1,
                                'LocationId'=>$value['expfloormap']??"",
                                'CleanProductType'=>$value['expcoffeetype']??"",
                                'CertificationId'=>$value['expcertnum']??"",
                                'FullUomId'=>$value['exprefuom']??"",
                                'FullNumofBag'=>$value['exprefbagnum']??"",
                                'BagWeight'=>$value['bagweight']??"",
                                'FullWeightbyKg'=>$value['exptotalkg']??"",
                                'NetKg'=>$value['expnetkg']??"",
                                'Percentage'=>$percentage,
                                'Feresula'=>$value['expferesula']??"",
                                'VarianceShortage'=>$value['expshortage']??"",
                                'VarianceOverage'=>$value['expoverage']??"",
                                'UnitCost'=>$unitcost,
                                'TotalCost'=>$totalcost,
                                'TaxCost'=>$tax,
                                'GrandTotalCost'=>$grandtotalcost,
                                'Inspection'=>$value['expinspection']
                            ]);

                            $totalbagnum+=$value['exprefbagnum'];
                            $totalweightkg+=$value['expnetkg'];
                        }
                    }

                    $prdorder->ExportNumofBag=round($totalbagnum,2);
                    $prdorder->ExportWeightbyKg=round($totalweightkg,2);
                    $prdorder->ExportRemark=$request->ExportRemark;
                    $prdorder->PrdStatus="Clean/Refined-Submitted";
                    $prdorder->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Clean/Refined-Submitted",'status'=>"Clean/Refined-Submitted",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        // if($request->exprow==null){
        //     return response()->json(['emptyerror'=>465]);
        // }
        if ($v2->fails()){
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
    }

    public function submitReject(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->prdoutputid;
        $prdorder=prd_order::find($findid);
        $prdinput=$prdorder->PrdWeightByKg;
        $percentage=0;
        $percent=100;
        $arrdata=[];
        $detids=[];
        $totalbagnum=0;
        $totalweightkg=0;
        $certnumerdata=DB::select('SELECT id FROM uoms');
        foreach($certnumerdata as $cerRow){
            $arrdata[]=$cerRow->id;
        }
        $arrdata = implode(',', $arrdata);

        $rules=array(
            'rejrow.*.rejfloormap' => 'required',
            'rejrow.*.rejcoffeetype' => 'required',
            'rejrow.*.rejcertnum' => 'required',
            'rejrow.*.rejrefuom' => 'required',
            'rejrow.*.rejrefbagnum' => 'required',
            'rejrow.*.rejbagweight' => 'required',
            'rejrow.*.rejtotalkg' => 'required',
            'rejrow.*.rejnetkg' => 'required',

            //'rejrow.*.rejblankkg' =>['required_if:rejrow.*.rejblankuom,'.$arrdata],
        );
        $v2= Validator::make($request->all(), $rules);

        if($v2->passes()){
            if($prdorder->Status=="Process-Finished"){
                try{
                    
                    if($request->rejrow==null){
                        prd_output::where('prd_outputs.prd_orders_id',$findid)->where('prd_outputs.OutputType',2)->delete();
                    }
                    
                    else if($request->rejrow!=null){

                        foreach ($request->rejrow as $key => $value){
                            $detids[]=$value['rejid'];
                        }

                        prd_output::where('prd_outputs.prd_orders_id',$findid)->where('prd_outputs.OutputType',2)->whereNotIn('prd_outputs.id',$detids)->delete();

                        foreach ($request->rejrow as $key => $value){
                            $unitcost = !empty($value['rejunitcost']) ? $value['rejunitcost'] : 0;
                            $netkg = !empty($value['rejnetkg']) ? $value['rejnetkg'] : 0;

                            $totalcost=round(($netkg * $unitcost),2);
                            $grandtotalcost=round((($netkg * $unitcost)*1.15),2);
                            $tax=round(($grandtotalcost-$totalcost),2);

                            $percentage=round((($netkg * $percent) / $prdinput),2);

                            prd_output::updateOrCreate(['id' => $value['rejid']],
                            [ 
                                'prd_orders_id'=>$findid,
                                'OutputType'=>2,
                                'LocationId'=>$value['rejfloormap']??"",
                                'BiProductId'=>$value['rejcoffeetype']??"",
                                'CertificationId'=>$value['rejcertnum']??"",
                                'FullUomId'=>$value['rejrefuom']??"",
                                'FullNumofBag'=>$value['rejrefbagnum']??"",
                                'BagWeight'=>$value['rejbagweight']??"",
                                'FullWeightbyKg'=>$value['rejtotalkg']??"",
                                'NetKg'=>$value['rejnetkg']??"",
                                'Percentage'=>$percentage,
                                'Feresula'=>$value['rejferesula']??"",
                                'VarianceShortage'=>$value['rejshortage']??"",
                                'VarianceOverage'=>$value['rejoverage']??"",
                                'UnitCost'=>$unitcost,
                                'TotalCost'=>$totalcost,
                                'TaxCost'=>$tax,
                                'GrandTotalCost'=>$grandtotalcost,
                                'Inspection'=>$value['rejinspection'],
                            ]);

                            $totalbagnum+=$value['rejrefbagnum'];
                            $totalweightkg+=$value['rejnetkg'];
                        }
                    }
                    $prdorder->RejectNumofBag=round($totalbagnum,2);
                    $prdorder->RejectWeightbyKg=round($totalweightkg,2);
                    $prdorder->RejectRemark=$request->RejectRemark;
                    $prdorder->PrdStatus="Reject-Submitted";
                    $prdorder->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Reject-Submitted",'status'=>"Reject-Submitted",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        
        // if($request->rejrow==null){
        //     return response()->json(['emptyerror'=>465]);
        // }
        if ($v2->fails()){
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }

    }

    public function submitWastage(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->prdoutputid;
        $prdorder=prd_order::find($findid);
        $prdinput=$prdorder->PrdWeightByKg;
        $percentage=0;
        $percent=100;
        $arrdata=[];
        $detids=[];
        $totalbagnum=0;
        $totalweightkg=0;
        $totalstbbagnum=0;
        $totalstbweightkg=0;
        $certnumerdata=DB::select('SELECT id FROM uoms');
        foreach($certnumerdata as $cerRow){
            $arrdata[]=$cerRow->id;
        }
        $arrdata = implode(',', $arrdata);

        $rules=array(
            'wesrow.*.wescoffeetype' => 'required',
            'wesrow.*.wesfloormap' => 'required',
            'wesrow.*.wescertnum' => 'required',
            'wesrow.*.wesrefuom' => 'required',
            'wesrow.*.wesrefbagnum' => 'required',
            'wesrow.*.wesbagweight' => 'required',
            'wesrow.*.westotalkg' => 'required',
            'wesrow.*.wesnetkg' => 'required',

        );
        $v2= Validator::make($request->all(), $rules);

        if($v2->passes()){
            if($prdorder->Status=="Process-Finished"){
                try{
                   
                    if($request->wesrow==null){
                        prd_output::where('prd_outputs.prd_orders_id',$findid)->where('prd_outputs.OutputType',3)->delete();
                    }

                    else if($request->wesrow!=null){
                        foreach ($request->wesrow as $key => $value){
                            $detids[]=$value['wesid'];
                        }

                        prd_output::where('prd_outputs.prd_orders_id',$findid)->where('prd_outputs.OutputType',3)->whereNotIn('prd_outputs.id',$detids)->delete();
                        
                        foreach ($request->wesrow as $key => $value){
                            $unitcost = !empty($value['wasunitcost']) ? $value['wasunitcost'] : 0;
                            $netkg = !empty($value['wesnetkg']) ? $value['wesnetkg'] : 0;

                            $totalcost=round(($netkg * $unitcost),2);
                            $grandtotalcost=round((($netkg * $unitcost)*1.15),2);
                            $tax=round(($grandtotalcost-$totalcost),2);

                            $percentage=round((($netkg * $percent) / $prdinput),2);

                            prd_output::updateOrCreate(['id' => $value['wesid']],
                            [ 
                                'prd_orders_id'=>$findid,
                                'OutputType'=>3,
                                'BiProductId'=>$value['wescoffeetype']??"",
                                'LocationId'=>$value['wesfloormap']??"",
                                'CertificationId'=>$value['wescertnum']??"",
                                'FullUomId'=>$value['wesrefuom']??"",
                                'FullNumofBag'=>$value['wesrefbagnum']??"",
                                'BagWeight'=>$value['wesbagweight']??"",
                                'FullWeightbyKg'=>$value['westotalkg']??"",
                                'NetKg'=>$value['wesnetkg']??"",
                                'Percentage'=>$percentage,
                                'Feresula'=>$value['wesferesula']??"",
                                'VarianceShortage'=>$value['wesshortage']??"",
                                'VarianceOverage'=>$value['wesoverage']??"",
                                'UnitCost'=>$unitcost,
                                'TotalCost'=>$totalcost,
                                'TaxCost'=>$tax,
                                'GrandTotalCost'=>$grandtotalcost,
                                'Inspection'=>$value['wesinspection'],
                            ]);

                            if($value['wescoffeetype'] == 3){
                                $totalstbbagnum+=$value['wesrefbagnum'];
                                $totalstbweightkg+=$value['wesnetkg'];
                            }
                            if($value['wescoffeetype'] != 3){
                                $totalbagnum+=$value['wesrefbagnum'];
                                $totalweightkg+=$value['wesnetkg'];
                            }
                        }
                    }
                    $prdorder->StubbleNumofBag=round($totalstbbagnum,2);
                    $prdorder->StubbleWeightbyKg=round($totalstbweightkg,2);
                    $prdorder->WastageNumofBag=round($totalbagnum,2);
                    $prdorder->WastageWeightbyKg=round($totalweightkg,2);
                    $prdorder->WastageRemark=$request->WestageRemark;
                    $prdorder->PrdStatus="Wastage-Submitted";
                    $prdorder->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Wastage-Submitted",'status'=>"Wastage-Submitted",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror'=>462]);
            }
        }
        if ($v2->fails()){
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
    }

    public function prdCompleteOutput(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $curdate=Carbon::today()->toDateString();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->completeprdid;
        $prdorder=prd_order::find($findid);
        $oldstatusval=$prdorder->OldStatus;
        $statusval=$prdorder->Status;
        $totalexport=0;
        $totalreject=0;
        $totalwastage=0;
        $totalprdprocess=0;
        $totaloutput=0;
        $others=1000;

        $totalexportdata=DB::select('SELECT COUNT(prd_outputs.id) AS ExportCount FROM prd_outputs WHERE prd_outputs.OutputType=1 AND prd_outputs.prd_orders_id='.$findid);
        $totalexport=$totalexportdata[0]->ExportCount ?? 0;

        $totalrejectdata=DB::select('SELECT COUNT(prd_outputs.id) AS RejectCount FROM prd_outputs WHERE prd_outputs.OutputType=2 AND prd_outputs.prd_orders_id='.$findid);
        $totalreject=$totalrejectdata[0]->RejectCount ?? 0;

        $totalwastagedata=DB::select('SELECT COUNT(prd_outputs.id) AS WastageCount FROM prd_outputs WHERE prd_outputs.OutputType=3 AND prd_outputs.prd_orders_id='.$findid);
        $totalwastage=$totalwastagedata[0]->WastageCount ?? 0;

        $totalprdprocess=round(($prdorder->ExportWeightbyKg??0)+($prdorder->RejectWeightbyKg??0)+($prdorder->WastageWeightbyKg??0)+($prdorder->StubbleWeightbyKg??0),2);
        $totaloutput=round(($prdorder->PrdWeightByKg??0),2);

        if($prdorder->Status=="Process-Finished" && $totalprdprocess >= $totaloutput){
            try{
                $prdorder->Status="Production-Closed";
                $prdorder->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"prdorder",'action'=>"Production-Closed",'status'=>"Production-Closed",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($prdorder->Status!="Process-Finished"){
            return Response::json(['statuserror'=>462]);
        }
        else if($totaloutput<$totalprdprocess){
            return Response::json(['prderror'=>466]);
        }
    }

    public function showPrdDuration($id)
    {
        $prdprocessduration=prd_duration::where('prd_durations.prd_orders_id',$id)
        ->orderBy('prd_durations.id','ASC')
        ->get(['prd_durations.*',DB::raw('ROUND(prd_durations.Duration/60,2) AS DurationHour')]);

        return datatables()->of($prdprocessduration)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showExportData($id)
    {
        $prdexportdata=prd_output::leftJoin('prd_order_certs','prd_outputs.CertificationId','=','prd_order_certs.id')
        ->leftJoin('uoms AS fulluom','prd_outputs.FullUomId','=','fulluom.id')
        ->leftJoin('uoms AS paruom','prd_outputs.PartialUomId','=','paruom.id')
        ->leftJoin('locations','prd_outputs.LocationId','=','locations.id')
        ->leftJoin('lookups','prd_outputs.CleanProductType','=','lookups.CommodityTypeValue')
        ->where('prd_outputs.prd_orders_id',$id)
        ->where('prd_outputs.OutputType',1)
        ->orderBy('prd_outputs.id','ASC')
        ->get(['prd_outputs.*','locations.Name AS LocationName','lookups.CommodityType','prd_order_certs.CertificateNumber','fulluom.Name AS FullUomName','paruom.Name AS PartialUomName',DB::raw('IFNULL(prd_outputs.Inspection,"") AS InspectionData')]);

        return datatables()->of($prdexportdata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showRejectData($id)
    {
        $prdrejectdata=prd_output::leftJoin('prd_biproducts','prd_outputs.BiProductId','=','prd_biproducts.id')
        ->leftJoin('prd_order_certs','prd_outputs.CertificationId','=','prd_order_certs.id')
        ->leftJoin('uoms AS fulluom','prd_outputs.FullUomId','=','fulluom.id')
        ->leftJoin('uoms AS paruom','prd_outputs.PartialUomId','=','paruom.id')
        ->leftJoin('locations','prd_outputs.LocationId','=','locations.id')
        ->leftJoin('lookups','prd_outputs.CleanProductType','=','lookups.CommodityTypeValue')
        ->where('prd_outputs.prd_orders_id',$id)
        ->where('prd_outputs.OutputType',2)
        ->orderBy('prd_outputs.id','ASC')
        ->distinct()
        ->get(['prd_outputs.*','prd_biproducts.BiProductName',DB::raw('"Reject" AS Types'),'prd_order_certs.CertificateNumber','locations.Name AS LocationName','lookups.CommodityType','fulluom.Name AS FullUomName','paruom.Name AS PartialUomName',DB::raw('IFNULL(prd_outputs.Inspection,"") AS InspectionData')]);

        return datatables()->of($prdrejectdata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showWastageData($id)
    {
        $prdwastagedata=prd_output::leftJoin('prd_biproducts','prd_outputs.BiProductId','=','prd_biproducts.id')
        ->leftJoin('prd_order_certs','prd_outputs.CertificationId','=','prd_order_certs.id')
        ->leftJoin('uoms AS fulluom','prd_outputs.FullUomId','=','fulluom.id')
        ->leftJoin('uoms AS paruom','prd_outputs.PartialUomId','=','paruom.id')
        ->leftJoin('locations','prd_outputs.LocationId','=','locations.id')
        ->leftJoin('lookups','prd_outputs.CleanProductType','=','lookups.CommodityTypeValue')
        ->where('prd_outputs.prd_orders_id',$id)
        ->where('prd_outputs.OutputType',3)
        ->orderBy('prd_outputs.id','ASC')
        ->distinct()
        ->get(['prd_outputs.*','locations.Name AS LocationName','lookups.CommodityType','prd_order_certs.CertificateNumber','prd_biproducts.BiProductName','fulluom.Name AS FullUomName','paruom.Name AS PartialUomName',DB::raw('IFNULL(prd_outputs.Inspection,"") AS InspectionData')]);

        return datatables()->of($prdwastagedata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function downloadPrOrder($ids,$file_name) 
    {
        $file_path = public_path('storage/uploads/ProductionOrderDocument/'.$file_name);
        return response()->download($file_path);
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
