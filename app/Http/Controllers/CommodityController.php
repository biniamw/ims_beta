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
use App\Models\commoditybeg;
use App\Models\commoditybegdetail;
use App\Models\actions;
use App\Models\companyinfo;
use App\Models\systeminfo;
use App\Models\store;
use App\Models\fiscalyear;
use App\Models\commodity_ending;
use App\Models\commodity_ending_detail;
use App\Models\transaction;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $currentdate=Carbon::today()->toDateString();
        $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $storedata=DB::select('SELECT stores.id,stores.Name FROM stores WHERE stores.type="Store" AND stores.ActiveStatus="Active" AND stores.id>1');
        $customers=DB::select('SELECT customers.id,customers.Code,customers.Name,customers.TinNumber,customers.PhoneNumber FROM customers WHERE customers.ActiveStatus="Active" AND customers.CustomerCategory IN("Customer","Customer&Supplier")');
        $locationdata=DB::select('SELECT * FROM locations WHERE locations.ActiveStatus="Active"');
        $uomdata=DB::select('select * from uoms where uoms.ActiveStatus="Active"');
        $supplierdata=DB::select('SELECT * FROM customers WHERE customers.CustomerCategory IN("Supplier","Customer$Supplier") AND customers.ActiveStatus="Active"');
        $origin=DB::select('SELECT woredas.id,CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Origin,woredas.Type AS CommType FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE woredas.status="Active"');
        $prdtypedata=DB::select('SELECT lookups.ProductTypeValue,lookups.ProductType FROM lookups WHERE lookups.ProductTypeStatus="Active"');
        $items=DB::select('SELECT regitems.id,regitems.Name FROM regitems WHERE regitems.ActiveStatus="Active" ORDER BY regitems.Name ASC');
        if($request->ajax()) {
            return view('inventory.commoditybeg',['storedata'=>$storedata,'customers'=>$customers,'locationdata'=>$locationdata,
            'uomdata'=>$uomdata,'origin'=>$origin,'fiscalyears'=>$fiscalyears,'currentdate'=>$currentdate,'supplierdata'=>$supplierdata,
            'prdtypedata'=>$prdtypedata,'items'=>$items])->renderSections()['content'];
        }
        else{
            return view('inventory.commoditybeg',['storedata'=>$storedata,'customers'=>$customers,'locationdata'=>$locationdata,
            'uomdata'=>$uomdata,'origin'=>$origin,'fiscalyears'=>$fiscalyears,'currentdate'=>$currentdate,'supplierdata'=>$supplierdata,
            'prdtypedata'=>$prdtypedata,'items'=>$items]);
        }
    }

    public function commbeglist($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $commlists=DB::select('SELECT commoditybegs.id,commoditybegs.DocumentNumber,commoditybegs.EndingDocumentNumber,lookups.ProductType,stores.Name AS StoreName,fiscalyear.Monthrange,DATE_FORMAT(commoditybegs.created_at,"%Y-%m-%d") AS Date,commoditybegs.Status,customers.Name AS CustomerName,customers.Code AS CustomerCode,customers.TinNumber,customers.PhoneNumber,customers.OfficePhone FROM commoditybegs INNER JOIN stores ON commoditybegs.stores_id=stores.id INNER JOIN customers ON commoditybegs.customers_id=customers.id INNER JOIN fiscalyear ON commoditybegs.FiscalYear=fiscalyear.FiscalYear LEFT JOIN lookups ON commoditybegs.product_type=lookups.ProductTypeValue WHERE commoditybegs.FiscalYear='.$fy.' AND commoditybegs.customers_id=1 ORDER BY commoditybegs.id DESC');
        if(request()->ajax()) {
            return datatables()->of($commlists)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $commedit='';
                $endinglink='';
                $println='<a class="dropdown-item printCommBegAttachment" href="javascript:void(0)" id="beginningNote'.$data->id.'" onclick="commBegAttFn('.$data->id.')" title="Print Beginning Note"><i class="fa fa-file"></i><span> Print Beginning Note</span></a>';  
                if($user->can('Commodity-Beginning-Edit') && $data->Status!="Posted"){
                    $commedit='<a class="dropdown-item commEdit" onclick="commEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open commodity beginning edit page">
                        <i class="fa fa-edit"></i><span> Edit</span>  
                    </a>';
                    $endinglink='';
                    $println='';
                }
                if($data->Status == "Posted"){
                    if($user->can('Ending-Count')){
                        $endinglink='<a class="dropdown-item commEnding" onclick="commEndingFn('.$data->id.')" data-id="'.$data->id.'" id="ending'.$data->id.'" title="Open commodity ending form">
                            <i class="fa fa-edit"></i><span> Ending Form</span>  
                        </a>';
                    }
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item commInfo" onclick="commInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open commodity beginning information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$commedit.'
                        '.$endinglink.'
                        '.$println.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function cuscommbeglist($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $commlists=DB::select('SELECT commoditybegs.id,commoditybegs.DocumentNumber,commoditybegs.EndingDocumentNumber,lookups.ProductType,stores.Name AS StoreName,fiscalyear.Monthrange,DATE_FORMAT(commoditybegs.created_at,"%Y-%m-%d") AS Date,commoditybegs.Status,customers.Name AS CustomerName,customers.Code AS CustomerCode,customers.TinNumber,customers.PhoneNumber,customers.OfficePhone FROM commoditybegs INNER JOIN stores ON commoditybegs.stores_id=stores.id INNER JOIN customers ON commoditybegs.customers_id=customers.id INNER JOIN fiscalyear ON commoditybegs.FiscalYear=fiscalyear.FiscalYear LEFT JOIN lookups ON commoditybegs.product_type=lookups.ProductTypeValue WHERE commoditybegs.FiscalYear='.$fy.' AND commoditybegs.customers_id>1 ORDER BY commoditybegs.id DESC');
        if(request()->ajax()) {
            return datatables()->of($commlists)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $commedit='';
                $endinglink='';
                $println='<a class="dropdown-item printCommBegAttachment" href="javascript:void(0)" id="beginningNote'.$data->id.'" onclick="commBegAttFn('.$data->id.')" title="Print Beginning Note"><i class="fa fa-file"></i><span> Print Beginning Note</span></a>';  
                if($user->can('Commodity-Beginning-Edit') && $data->Status!="Posted"){
                    $commedit='<a class="dropdown-item commEdit" onclick="commEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open commodity beginning edit page">
                        <i class="fa fa-edit"></i><span> Edit</span>  
                    </a>';
                    $println='';
                    $endinglink='';
                }
                if($data->Status == "Posted"){
                    if($user->can('Ending-Count')){
                        $endinglink='<a class="dropdown-item commEnding" onclick="commEndingFn('.$data->id.')" data-id="'.$data->id.'" id="ending'.$data->id.'" title="Open commodity ending form">
                            <i class="fa fa-edit"></i><span> Ending Form</span>  
                        </a>';
                    }
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item commInfo" onclick="commInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open commodity beginning information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$commedit.'
                        '.$endinglink.'
                        '.$println.'
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
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->recId;
        $findid=$request->recId;
        $customerid=$request->customers_id ?? 0;
        $storeid=$request->stores_id ?? 0;
        $companytype=$request->CompanyType ?? 0;
        $curdate=Carbon::today()->toDateString();
        $settings = DB::table('settings')->latest()->first();
        $totalprice=0;
        $tax=0;
        $grandtotal=0;
        $taxpercent=15;
        $commdetaildata=[];
        $idvals=[];
        $actiondata=[];
        $documentNumber=$settings->CommodityBeginningPrefix.sprintf("%06d",$settings->CommodityBeginningNumber)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
        $fiscalyear=$settings->FiscalYear;
        $currentdocnum=null;
        $CommBegDocumentNumber=null;
        $suppcnt=0;
        $grnnumcnt=0;
        $cernumcnt=0;
        $prdnumcnt=0;
        $arrdata=[];

        if($customerid == 1){
            $commbeg = commoditybeg::where('customers_id',1)->where('FiscalYear',$fiscalyear)->latest()->first();
            $CommBegDocumentNumber=$settings->CommodityBeginningPrefix.sprintf("%06d",($commbeg->LastDocNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum=($commbeg->LastDocNumber ?? 0)+1;

            if($findid!=null){
                $commbegin = commoditybeg::where('id',$findid)->where('FiscalYear',$fiscalyear)->latest()->first();
                if($commbegin->customers_id>1){
                    $commbegdata = commoditybeg::where('customers_id',1)->where('FiscalYear',$fiscalyear)->latest()->first();
                    $CommBegDocumentNumber=$settings->CommodityBeginningPrefix.sprintf("%06d",($commbegdata->LastDocNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum=($commbegdata->LastDocNumber ?? 0)+1;
                }
                if($commbegin->customers_id==1){
                    $CommBegDocumentNumber=$commbegin->DocumentNumber;
                    $currentdocnum=$commbegin->LastDocNumber;
                }
            }
        }
        else if($customerid > 1){
            $commbeg = commoditybeg::where('customers_id','!=',1)->where('FiscalYear',$fiscalyear)->latest()->first();
            $CommBegDocumentNumber=$settings->CommodityCusBeginningPrefix.sprintf("%06d",($commbeg->LastDocNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum=($commbeg->LastDocNumber ?? 0)+1;

            if($findid!=null){
                $commbegin = commoditybeg::where('id',$findid)->where('FiscalYear',$fiscalyear)->latest()->first();
                if($commbegin->customers_id==1){
                    $commbegdata = commoditybeg::where('customers_id','!=',1)->where('FiscalYear',$fiscalyear)->latest()->first();
                    $CommBegDocumentNumber=$settings->CommodityCusBeginningPrefix.sprintf("%06d",($commbegdata->LastDocNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum=($commbegdata->LastDocNumber ?? 0)+1;
                }
                if($commbegin->customers_id>1){
                    $CommBegDocumentNumber=$commbegin->DocumentNumber;
                    $currentdocnum=$commbegin->LastDocNumber;
                }
            }
        }

        $validator = Validator::make($request->all(), [
            'ProductType' => ['required'],
            'stores_id' => ['required',Rule::unique('commoditybegs')->where(function ($query) use($fiscalyear,$findid,$customerid) {
                return $query->where([['FiscalYear',$fiscalyear],['customers_id',$customerid]]);
            })->ignore($findid)],

            'customers_id' => ['required',Rule::unique('commoditybegs')->where(function ($query) use($fiscalyear,$findid,$storeid) {
                return $query->where([['FiscalYear',$fiscalyear],['stores_id',$storeid]]);
            })->ignore($findid)],
        ]);

        $rules=array(
            'row.*.FloorMap' => 'required',
            'row.*.CommType' => 'required',
            'row.*.Origin' => 'required',
            'row.*.Grade' => 'required',
            'row.*.ProcessType' => 'required',
            'row.*.CropYear' => 'required',
            'row.*.Uom' => 'required',
            'row.*.Balance' => 'required|gt:0',
            'row.*.Feresula' => 'nullable',
            'row.*.UnitPrice' => 'nullable',
            'row.*.TotalPrice' => 'nullable'
        );
        $v2= Validator::make($request->all(), $rules);

        if($request->row!=null){
            foreach ($request->row as $key => $value){
                $suppid=$value['Supplier']??0;
                $grnnum=$value['GrnNumber']??"";
                $cernum=$value['CertificateNum']??"";
                $prdnum=$value['ProductionNum']??"";
                if($suppid==0 && $request->customers_id==1 && ($value['CommType']==1 || $value['CommType']==4)){
                    $suppcnt+=1;
                }
                if($grnnum=="" && $request->customers_id==1 && ($value['CommType']==1 || $value['CommType']==4)){
                    $grnnumcnt+=1;
                }
                if($cernum=="" && $request->customers_id==1 && ($value['CommType']==2 || $value['CommType']==3 || $value['CommType']==5 || $value['CommType']==6)){
                    $cernumcnt+=1;
                }
                if($prdnum=="" && $request->customers_id==1 && ($value['CommType']==2 || $value['CommType']==3 || $value['CommType']==5 || $value['CommType']==6)){
                    $prdnumcnt+=1;
                }
            }
        }

        if ($validator->passes() && $v2->passes() && $request->row!=null && $suppcnt==0 && $grnnumcnt==0 && $cernumcnt==0 && $prdnumcnt==0){
            try
            {
                foreach ($request->row as $key => $value){
                    $totalprice+=$value['TotalPrice'] ?? 0;
                }
                $tax=round((($totalprice*$taxpercent)/100),2);
                $grandtotal=round(($totalprice+$tax),2);

                $BasicVal = [
                    'product_type' => $request->ProductType,
                    'DocumentNumber' => $CommBegDocumentNumber,
                    'stores_id' => $request->stores_id,
                    'customers_id' => $request->customers_id,
                    'FiscalYear' => $fiscalyear,
                    'TotalPrice' => $totalprice,
                    'Tax' => $tax,
                    'GrandTotal' => $grandtotal,
                    'Remark' => $request->Remark,
                    'LastDocNumber' => $currentdocnum,
                ];

                $DbData = commoditybeg::where('id', $findid)->first();
                $CreatedBy = ['Status'=>"Counting"];
                $LastUpdatedBy = ['updated_at'=>Carbon::now()];
            
                $commbeg = commoditybeg::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                foreach ($request->row as $key => $value){
                    $idvals[]=$value['id'];
                }
                commoditybegdetail::where('commoditybegs_id',$commbeg->id)->whereNotIn('id',$idvals)->delete();

                foreach ($request->row as $key => $value){
                    commoditybegdetail::updateOrCreate(['id' => $value['id']],
                    [ 
                        'commoditybegs_id' =>(int)$commbeg->id,
                        'customers_id' =>(int)$request->customers_id,
                        'stores_id' =>(int)$request->stores_id,
                        'SupplierId'=>$value['Supplier']??"",
                        'GrnNumber'=>$value['GrnNumber'],
                        'CertNumber'=>$value['CertificateNum'],
                        'ProductionNumber'=>$value['ProductionNum'],
                        'LocationId'=>$value['FloorMap'],
                        'ArrivalDate'=>$value['arrdate'],
                        'woredas_id' =>(int)$value['Origin'],
                        'CommodityType' =>(int)$value['CommType'],
                        'Grade'=>(int)$value['Grade'],
                        'ProcessType'=>$value['ProcessType'],
                        'CropYear'=>(int)$value['CropYear'],
                        'uoms_id'=>(int)$value['Uom'],
                        'NumOfBag'=>(float)$value['BalanceByUom'],
                        'Balance'=>(float)$value['Balance'],
                        'Feresula'=>(float)$value['Feresula'],
                        'UnitPrice'=>(float)$value['UnitPrice'],
                        'TotalPrice'=>(float)$value['TotalPrice'],
                        'VarianceShortage'=>(float)$value['varianceshortage'],
                        'VarianceOverage'=>(float)$value['varianceoverage'],
                        'BagWeight'=>(float)$value['TotalBagWeight'],
                        'TotalKg'=>(float)$value['TotalKg'],
                        'Remark'=>$value['Remark']
                    ]);
                }
                if($findid==null){
                    $updn=DB::select('UPDATE settings SET CommodityBeginningNumber=CommodityBeginningNumber+1 WHERE id=1');
                    $actions="Created / ".$commbeg->Status;
                }
                else if($findid!=null){
                    $actions="Edited / ".$commbeg->Status;
                }
                actions::insert(['user_id'=>$userid,'pageid'=>$commbeg->id,'pagename'=>"combeg",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
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
        if($request->row==null)
        {
            return Response::json(['emptyerror'=>"error"]);
        }
    }

    public function showCommBeg($id){
        $datefromval=0;
        $commbegdata = commoditybeg::leftJoin('stores','commoditybegs.stores_id','stores.id')
        ->leftJoin('customers','commoditybegs.customers_id','customers.id')
        ->leftJoin('fiscalyear','commoditybegs.FiscalYear','fiscalyear.FiscalYear')
        ->leftJoin('lookups','commoditybegs.product_type','lookups.ProductTypeValue')
        ->where('commoditybegs.id',$id)
        ->get(['commoditybegs.id','commoditybegs.*','lookups.ProductType','stores.Name AS StoreName','customers.Name AS CustomerName','customers.Code AS CustomerCode',
        'customers.TinNumber','customers.PhoneNumber','customers.OfficePhone','customers.EmailAddress','fiscalyear.Monthrange',DB::raw('DATE_FORMAT(commoditybegs.created_at,"%Y-%m-%d") AS Date')]);

        $product_type = $commbegdata[0]->product_type;

        $commbegdetaildata = commoditybegdetail::leftJoin('woredas','commoditybegdetails.woredas_id','woredas.id')
        ->leftJoin('zones','woredas.zone_id','zones.id')
        ->leftJoin('regions','zones.Rgn_Id','regions.id')
        ->leftJoin('uoms','commoditybegdetails.uoms_id','uoms.id')
        ->leftJoin('locations','commoditybegdetails.LocationId','locations.id')
        ->leftJoin('customers','commoditybegdetails.SupplierId','customers.id')
        ->leftJoin('regitems','commoditybegdetails.item_id','regitems.id')
        ->where('commoditybegs_id',$id)
        ->orderBy('commoditybegdetails.id','ASC')
        ->get(['commoditybegdetails.*','regitems.Name AS item_name',DB::raw('CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Origin'),
            DB::raw('IFNULL(commoditybegdetails.Remark,"") AS Remark'),'uoms.Name AS UomName','locations.Name AS LocationName',
            'uoms.uomamount','uoms.bagweight','customers.Name AS SupplierName','customers.Code AS SupplierCode','customers.TinNumber AS SupplierTIN',
            'commoditybegdetails.VarianceShortage','commoditybegdetails.VarianceOverage',
            DB::raw('CASE WHEN commoditybegdetails.UnitPrice=0 THEN "" ELSE commoditybegdetails.UnitPrice END AS UnitPrice'),
            DB::raw('CASE WHEN commoditybegdetails.TotalPrice=0 THEN "" ELSE commoditybegdetails.TotalPrice END AS TotalPrice'),
            DB::raw('CASE WHEN commoditybegdetails.CropYear=0 THEN "NCY (No Crop Year)" ELSE commoditybegdetails.CropYear END AS CropYearData'),
            DB::raw('CASE WHEN commoditybegdetails.Grade=100 THEN "UG (Under Grade)" WHEN commoditybegdetails.Grade=101 THEN "NG (No Grade)" WHEN commoditybegdetails.Grade=102 THEN "Peaberry Coffee" ELSE commoditybegdetails.Grade END AS GradeName'),
            DB::raw('IFNULL(commoditybegdetails.GrnNumber,"") AS GrnNumber'),
            DB::raw('IFNULL(commoditybegdetails.CertNumber,"") AS CertNumber'),
            DB::raw('IFNULL(commoditybegdetails.ProductionNumber,"") AS ProductionNumber')
        ]);
        
        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"combeg")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['commbegdata'=>$commbegdata,'commbegdetaildata'=>$commbegdetaildata,'activitydata'=>$activitydata,'product_type'=>$product_type]);       
    }

    public function doneCommCount(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $qntcnt=0;
        $ucostqnt=0;
        $findid=$request->doneid;
        $bg=commoditybeg::find($findid);

        $quantityqnt=DB::select('SELECT COUNT(commoditybegdetails.id) AS NumOfBagCount FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id WHERE (commoditybegdetails.NumOfBag=0 OR commoditybegdetails.NumOfBag IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
        $unitcostqnt=DB::select('SELECT COUNT(commoditybegdetails.id) AS UnitCostCount FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id WHERE (commoditybegdetails.UnitPrice=0 OR commoditybegdetails.UnitPrice IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
        //$qntcnt=$quantityqnt[0]->NumOfBagCount ?? 0;
        //$ucostqnt=$unitcostqnt[0]->UnitCostCount ?? 0;
        if($bg->Status == "Counting" && $qntcnt==0 && $ucostqnt==0)
        {
            $bg=commoditybeg::find($findid);
            $bg->Status="Finish-Counting";
            $bg->save();
            actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"combeg",'action'=>"Finish-Counting",'status'=>"Finish-Counting",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            return Response::json(['success' => '1']);
        }
        else if($bg->Status!="Counting"){
            return Response::json(['valerror' =>  "error"]);
        }
        else if($qntcnt>0){
            $qnterrorlist=DB::select('SELECT CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Commodity FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id INNER JOIN woredas ON commoditybegdetails.woredas_id=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE (commoditybegdetails.NumOfBag=0 OR commoditybegdetails.NumOfBag IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
            return Response::json(['qnterror' =>461,'qnterrorlist'=>$qnterrorlist]);
        }
        else if($ucostqnt>0){
            $costerrorlist=DB::select('SELECT CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Commodity FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id INNER JOIN woredas ON commoditybegdetails.woredas_id=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE (commoditybegdetails.UnitPrice=0 OR commoditybegdetails.UnitPrice IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
            return Response::json(['costerror' =>462,'costerrorlist'=>$costerrorlist]);
        }
    }

    public function commentCommCount(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->commentid;
        $bg=commoditybeg::find($findid);
        $validator = Validator::make($request->all(), [
            'Comment'=>"required",
        ]);
        if ($validator->passes())
        { 
            $bg->Status="Counting";
            $bg->save();
            actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"combeg",'action'=>"Change to Counting",'status'=>"Change to Counting",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>$request->input('Comment'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function verifyCommCount(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $qntcnt=0;
        $ucostqnt=0;
        $findid=$request->verifyid;
        $bg=commoditybeg::find($findid);

        $quantityqnt=DB::select('SELECT COUNT(commoditybegdetails.id) AS NumOfBagCount FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id WHERE (commoditybegdetails.NumOfBag=0 OR commoditybegdetails.NumOfBag IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
        $unitcostqnt=DB::select('SELECT COUNT(commoditybegdetails.id) AS UnitCostCount FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id WHERE (commoditybegdetails.UnitPrice=0 OR commoditybegdetails.UnitPrice IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
        //$qntcnt=$quantityqnt[0]->NumOfBagCount ?? 0;
        //$ucostqnt=$unitcostqnt[0]->UnitCostCount ?? 0;

        if($bg->Status == "Finish-Counting" && $qntcnt==0 && $ucostqnt==0)
        {
            $bg=commoditybeg::find($findid);
            $bg->Status="Verified";
            $bg->save();
            actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"combeg",'action'=>"Verified",'status'=>"Verified",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);    
            return Response::json(['success' => '1']);
        }
        else if($bg->Status!="Finish-Counting"){
            return Response::json(['valerror' =>  "error"]);
        }
        else if($qntcnt>0){
            $qnterrorlist=DB::select('SELECT CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Commodity FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id INNER JOIN woredas ON commoditybegdetails.woredas_id=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE (commoditybegdetails.NumOfBag=0 OR commoditybegdetails.NumOfBag IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
            return Response::json(['qnterror' =>461,'qnterrorlist'=>$qnterrorlist]);
        }
        else if($ucostqnt>0){
            $costerrorlist=DB::select('SELECT CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Commodity FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id INNER JOIN woredas ON commoditybegdetails.woredas_id=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE (commoditybegdetails.UnitPrice=0 OR commoditybegdetails.UnitPrice IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
            return Response::json(['costerror' =>462,'costerrorlist'=>$costerrorlist]);
        }
    }

    public function postCommCount(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $qntcnt = 0;
        $ucostqnt = 0;
        $findid=$request->postid;
        $bg=commoditybeg::find($findid);
        $strid=$bg->stores_id;
        $fiscalyear=$bg->FiscalYear;
        $docnum=$bg->DocumentNumber;

        if($bg->product_type == 1){
            $quantityqnt = DB::select('SELECT COUNT(commoditybegdetails.id) AS NumOfBagCount FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id WHERE (commoditybegdetails.NumOfBag=0 OR commoditybegdetails.NumOfBag IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
            $unitcostqnt = DB::select('SELECT COUNT(commoditybegdetails.id) AS UnitCostCount FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id WHERE (commoditybegdetails.UnitPrice=0 OR commoditybegdetails.UnitPrice IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
            $qntcnt = $quantityqnt[0]->NumOfBagCount ?? 0;
            $ucostqnt = $unitcostqnt[0]->UnitCostCount ?? 0;
        }
        if($bg->product_type == 2){
            $unitcostqnt = DB::select('SELECT COUNT(commoditybegdetails.id) AS UnitCostCount FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id WHERE (commoditybegdetails.UnitPrice=0 OR commoditybegdetails.UnitPrice IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
            $ucostqnt = $unitcostqnt[0]->UnitCostCount ?? 0;
        }

        if($bg->Status == "Verified" && $qntcnt == 0 && $ucostqnt == 0)
        {
            $bg=commoditybeg::find($findid);
            $bg->Status="Posted";
            
            if($bg->product_type == 1){
                $insertToTransaction = DB::select('INSERT INTO transactions(HeaderId,woredaId,uomId,CommodityType,Grade,ProcessType,CropYear,StockInComm,StockInFeresula,UnitCostComm,TotalCostComm,TaxCostComm,GrandTotalCostComm,ItemType,FiscalYear,Memo,StoreId,TransactionType,TransactionsType,Date,customers_id,LocationId,ArrivalDate,SupplierId,GrnNumber,CertNumber,ProductionNumber,StockInNumOfBag,DocumentNumber,VarianceShortage,VarianceOverage,BagWeight,TotalKg) SELECT '.$findid.',woredas_id,uoms_id,CommodityType,Grade,ProcessType,CropYear,Balance,Feresula,UnitPrice,TotalPrice,ROUND((TotalPrice*(15/100)),2),ROUND(((TotalPrice*(15/100)) + TotalPrice),2),"Commodity",'.$fiscalyear.',Remark,'.$strid.',"Beginning","Beginning","'.Carbon::now().'",customers_id,LocationId,ArrivalDate,SupplierId,GrnNumber,CertNumber,ProductionNumber,NumOfBag,"'.$docnum.'",VarianceShortage,VarianceOverage,BagWeight,TotalKg FROM commoditybegdetails WHERE commoditybegdetails.commoditybegs_id='.$findid);
            }
            if($bg->product_type == 2){
                $insertToTransaction = DB::select('INSERT INTO transactions(HeaderId,ItemId,uomId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,ItemType,FiscalYear,StoreId,TransactionType,TransactionsType,Date,customers_id,LocationId,ArrivalDate,DocumentNumber,Memo) SELECT '.$findid.',item_id,uoms_id,quantity,UnitPrice,TotalPrice,ROUND((TotalPrice*(15/100)),2),ROUND(((TotalPrice*(15/100)) +TotalPrice),2),"Goods",'.$fiscalyear.','.$strid.',"Beginning","Beginning","'.Carbon::now().'",customers_id,LocationId,"'.Carbon::now().'","'.$docnum.'",Remark FROM commoditybegdetails WHERE commoditybegdetails.commoditybegs_id='.$findid);
            }

            $bg->save();

            actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"combeg",'action'=>"Posted",'status'=>"Posted",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);    
            return Response::json(['success' => '1']);
        }
        else if($bg->Status != "Verified"){
            return Response::json(['valerror' =>  "error"]);
        }
        else if($qntcnt > 0){
            $qnterrorlist = DB::select('SELECT CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Commodity FROM commoditybegdetails INNER JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id INNER JOIN woredas ON commoditybegdetails.woredas_id=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE (commoditybegdetails.NumOfBag=0 OR commoditybegdetails.NumOfBag IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
            return Response::json(['qnterror' => 461,'qnterrorlist' => $qnterrorlist]);
        }
        else if($ucostqnt > 0){
            $costerrorlist = DB::select('SELECT CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Commodity,regitems.Name AS Item_Name FROM commoditybegdetails LEFT JOIN commoditybegs ON commoditybegdetails.commoditybegs_id=commoditybegs.id LEFT JOIN woredas ON commoditybegdetails.woredas_id=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN regitems ON commoditybegdetails.item_id=regitems.id WHERE (commoditybegdetails.UnitPrice=0 OR commoditybegdetails.UnitPrice IS NULL) AND commoditybegs.customers_id=1 AND commoditybegdetails.commoditybegs_id='.$findid);
            return Response::json(['costerror' => 462,'costerrorlist' => $costerrorlist,'type' => $bg->product_type]);
        }
    }

    public function commBegNote($id)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        if(commoditybeg::where('commoditybegs.id',$id)->exists())
        {
            $st="";
            error_reporting(0); 
            //---Start Header Info---
            $compId="1";
            $compInfo=companyinfo::find($compId);
            $companyname=$compInfo->Name;
            $companytin=$compInfo->TIN;
            $companyvat=$compInfo->VATReg;
            $companyphone=$compInfo->Phone;
            $companyoffphone=$compInfo->OfficePhone;
            $companyemail=$compInfo->Email;
            $companyaddress=$compInfo->Address;
            $companywebsite=$compInfo->Website;
            $companycountry=$compInfo->Country;
            $companyalladdress=$compInfo->AllAddress;
            //---End Header Info-----
             
            //---Start Footer Info---
            $sysId="1";
            $sysInfo=systeminfo::find($sysId);
            $systemname=$sysInfo->Name;
            $systemtin=$sysInfo->TIN;
            $systemvat=$sysInfo->VATReg;
            $systemphone=$sysInfo->Phone;
            $systemoffphone=$sysInfo->OfficePhone;
            $systememail=$sysInfo->Email;
            $systemaddress=$sysInfo->Address;
            $systemwebsite=$sysInfo->Website;
            $systemcountry=$sysInfo->Country;
            $companyLogo=$compInfo->Logo;
            $systemalladdress=$sysInfo->AllAddress;
            //---End Footer Info----- 

            $headerInfo=commoditybeg::find($id);
            $docnumber=$headerInfo->DocumentNumber;
            $enddocnumber=$headerInfo->EndingDocumentNumber;
            $storeid=$headerInfo->stores_id;
            $settamount=$headerInfo->SettlementAmount;
            $status=$headerInfo->Status;
            $mem=$headerInfo->Remark;
            $totalprice=$headerInfo->TotalPrice;
            $transactiondate = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            
            $storedetail=store::find($storeid);
            $storename=$storedetail->Name;

            $fyear = fiscalyear::where('FiscalYear',$headerInfo->FiscalYear)->firstOrFail();
            $monthrange=$fyear->Monthrange;

            $countedprop = actions::join('users','actions.user_id','users.id')->where('pageid',$id)->where('pagename',"combeg")->where('action',"Finish-Counting")->latest('actions.id')->first();
            $donetime=$countedprop->time;
            $donefullname=$countedprop->FullName;

            $verprop = actions::join('users','actions.user_id','users.id')->where('pageid',$id)->where('pagename',"combeg")->where('action',"Verified")->latest('actions.id')->first();
            $vertime=$verprop->time;
            $verfullname=$verprop->FullName;

            $postedprop = actions::join('users','actions.user_id','users.id')->where('pageid',$id)->where('pagename',"combeg")->where('action',"Posted")->latest('actions.id')->first();
            $postime=$postedprop->time;
            $posfullname=$postedprop->FullName;

            $currentdate=Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
           
            $count=0;
            $bcount=0;
            //$detailTable=DB::select('select CASE WHEN commoditybegdetails.CommodityType=1 THEN "Arrival" WHEN commoditybegdetails.CommodityType=2 THEN "Export" WHEN commoditybegdetails.CommodityType=3 THEN "Reject" END AS CommType,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,uoms.Name AS UomName,commoditybegdetails.*,FORMAT(commoditybegdetails.Balance,2) AS Balance,FORMAT(commoditybegdetails.Feresula,2) AS Feresula,FORMAT(commoditybegdetails.UnitPrice,2) AS UnitPrice,FORMAT(commoditybegdetails.TotalPrice,2) AS TotalPrice,IFNULL(commoditybegdetails.Remark,"") AS Remark, uoms.Name as UomName from commoditybegdetails inner join woredas on commoditybegdetails.woredas_id = woredas.id inner join zones on woredas.zone_id = zones.id inner join regions on zones.Rgn_Id = regions.id inner join uoms on commoditybegdetails.uoms_id = uoms.id where commoditybegdetails.commoditybegs_id = '.$id.' order by commoditybegdetails.id DESC');
            $detailTable=DB::select('SELECT commlookup.CommodityType AS CommType,crplookup.CropYear AS CropYearData,grdlookups.Grade AS GradeName,CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Origin,uoms.Name AS UomName,commoditybegdetails.*, IFNULL(commoditybegdetails.Remark,"") AS Remark,ROUND((commoditybegdetails.Balance/1000),2) AS WeightByTon,uoms.Name as UomName,locations.Name AS LocationName,customers.Name AS SupplierName,ProductionNumber,VarianceShortage,VarianceOverage from commoditybegdetails LEFT JOIN woredas ON commoditybegdetails.woredas_id = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions ON zones.Rgn_Id = regions.id inner join uoms ON commoditybegdetails.uoms_id = uoms.id LEFT JOIN locations ON commoditybegdetails.LocationId=locations.id LEFT JOIN customers ON commoditybegdetails.SupplierId=customers.id LEFT JOIN lookups AS commlookup ON commoditybegdetails.CommodityType=commlookup.CommodityTypeValue LEFT JOIN lookups AS crplookup ON commoditybegdetails.CropYear=crplookup.CropYearValue LEFT JOIN lookups AS grdlookups ON commoditybegdetails.Grade=grdlookups.GradeValue WHERE commoditybegs_id = '.$id.' ORDER BY commoditybegdetails.id DESC');

            $data=['detailTable'=>$detailTable,
                    'transactiondate'=>$transactiondate,
                    'count'=>$count,
                    'mem'=>$mem,
                    'docnumber'=>$docnumber,
                    'enddocnumber'=>$enddocnumber,
                    'storename'=>$storename,
                    'status'=>$status,
                    'monthrange'=>$monthrange,
                    'totalprice'=> number_format($totalprice,2),
                    'currentdate'=>$currentdate,

                    'donetime'=>$donetime,
                    'donefullname'=>$donefullname,
                    'vertime'=>$vertime,
                    'verfullname'=>$verfullname,
                    'postime'=>$postime,
                    'posfullname'=>$posfullname,

                    'companyname'=>$companyname,
                    'companytin'=>$companytin,
                    'companyvat'=>$companyvat,
                    'companyphone'=>$companyphone,
                    'companyoffphone'=>$companyoffphone,
                    'companyemail'=>$companyemail,
                    'companyaddress'=>$companyaddress,
                    'companywebsite'=>$companywebsite,
                    'companycountry'=>$companycountry,
                    'companyalladdress'=>$companyalladdress,
                    'companyLogo'=>$companyLogo,
                    'systemname'=>$systemname,
                    'systemtin'=>$systemtin,
                    'systemvat'=>$systemvat,
                    'systemphone'=>$systemphone,
                    'systemoffphone'=>$systemoffphone,
                    'systememail'=>$systememail,
                    'systemaddress'=>$systemaddress,
                    'systemwebsite'=>$systemwebsite,
                    'systemcountry'=>$systemcountry,
                    'systemalladdress'=>$systemalladdress,
                ];

                $mpdf=new \Mpdf\Mpdf([
                    //'orientation' => 'L',
                    'margin_left' => 2,
                    'margin_right' => 2,
                    'margin_top' => 37,
                    'margin_bottom' => 25,
                    'margin_header' => 0,
                    'margin_footer' => 1
                ]); 
                $html=\View::make('inventory.report.commbegnote')->with($data);
                $html=$html->render();  
                $mpdf->SetTitle('Commodity Beginning Note');
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0; 
                $mpdf->SetAuthor($companyalladdress);
                $mpdf->SetWatermarkText($st);
                $mpdf->watermark_font = 'DejaVuSansCondensed';
                $mpdf->showWatermarkText = true;
                $mpdf->WriteHTML($html);
                $mpdf->Output('Commodity Beginning Note.pdf','I');
        }
    }

    public function showOriginData($id)
    {
        $origindata=DB::select('SELECT commlookup.CommodityType AS CommType,crplookup.CropYear AS CropYearData,grdlookups.Grade AS GradeName,CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Origin,regitems.Name AS item_name,uoms.Name AS UomName,commoditybegdetails.*, IFNULL(commoditybegdetails.Remark,"") AS Remark,ROUND((commoditybegdetails.Balance/1000),2) AS WeightByTon,uoms.Name as UomName,locations.Name AS LocationName,customers.Name AS SupplierName,ProductionNumber,VarianceShortage,VarianceOverage from commoditybegdetails LEFT JOIN woredas ON commoditybegdetails.woredas_id = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions ON zones.Rgn_Id = regions.id inner join uoms ON commoditybegdetails.uoms_id = uoms.id LEFT JOIN locations ON commoditybegdetails.LocationId=locations.id LEFT JOIN customers ON commoditybegdetails.SupplierId=customers.id LEFT JOIN lookups AS commlookup ON commoditybegdetails.CommodityType=commlookup.CommodityTypeValue LEFT JOIN lookups AS crplookup ON commoditybegdetails.CropYear=crplookup.CropYearValue LEFT JOIN lookups AS grdlookups ON commoditybegdetails.Grade=grdlookups.GradeValue LEFT JOIN regitems ON commoditybegdetails.item_id=regitems.id WHERE commoditybegs_id = '.$id.' ORDER BY commoditybegdetails.id DESC');
        return datatables()->of($origindata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    //--------------Start Ending-----------------
    public function fetchEndingBalance(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        
        $beg_id = $_POST['beg_id']; 

        $beg = commoditybeg::find($beg_id);

        $comm_ending = DB::table('commodity_endings')
                    ->where('commoditybegs_id',$beg_id)
                    ->first();
                
        $findid = $comm_ending->id ?? null;

        $BasicVal = [
            'commoditybegs_id' => $beg_id,
            'stores_id' => $beg->stores_id,
            'customers_id' => $beg->customers_id,
            'fiscal_year' => $beg->FiscalYear,
        ];

        $DbData = commodity_ending::where('id', $findid)->first();
        $CreatedBy = ['status'=>"Draft",'document_number' => "0",'last_doc_number' => "0"];
        $LastUpdatedBy = ['updated_at'=>Carbon::now()];
    
        $commend = commodity_ending::updateOrCreate(['id' => $findid],
            array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
        );

        if($beg->product_type == 1){
            $syncToEnding1=DB::select('INSERT IGNORE INTO commodity_ending_details(
                            commodity_endings_id, supplier_id, grn_number, cert_number, production_number, 
                            stores_id, location_id, woredas_id, commodity_type, grade, process_type, crop_year, 
                            uoms_id, no_of_bag, bag_weight, total_kg, net_kg, feresula, unit_cost, total_cost,remark)
            
                            SELECT DISTINCT '.$commend->id.',SupplierId,GrnNumber,CertNumber,ProductionNumber,
                            StoreId,LocationId,woredaId,CommodityType,Grade,ProcessType,CropYear,
                            uomId,
                            ROUND(SUM(COALESCE(StockInNumOfBag,0)) - SUM(COALESCE(StockOutNumOfBag,0)), 2),
                            ROUND((SUM(COALESCE(StockInNumOfBag,0)) - SUM(COALESCE(StockOutNumOfBag,0))) * uoms.bagweight, 2),
                            ROUND(SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0)), 2) + ROUND((SUM(COALESCE(StockInNumOfBag,0)) - SUM(COALESCE(StockOutNumOfBag,0))) * uoms.bagweight, 2),
                            ROUND(SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0)), 2) AS net_kg,
                            ROUND((SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0))) / 17, 2),
                            ROUND((SUM(COALESCE(TotalCostComm,0)) / SUM(COALESCE(StockInComm,0))),2),
                            ROUND((SUM(COALESCE(TotalCostComm,0)) / SUM(COALESCE(StockInComm,0))),2) * ROUND(SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0)), 2),
                            ""
                            FROM transactions 
                            LEFT JOIN uoms ON transactions.uomId = uoms.id
                            WHERE transactions.FiscalYear='.$beg->FiscalYear.' 
                            AND transactions.customers_id='.$beg->customers_id.' 
                            AND transactions.StoreId='.$beg->stores_id.'
                            AND transactions.ItemType="Commodity"    
                            AND transactions.SupplierId > 0
                            AND transactions.GrnNumber NOT IN("","-","--")
                            AND transactions.woredaId > 2

                            GROUP BY 
                            woredaId,SupplierId,GrnNumber,LocationId,
                            CommodityType,Grade,ProcessType,CropYear,StoreId,uomId,customers_id
                            HAVING net_kg > 0');
            
            $syncToEnding2=DB::select('INSERT IGNORE INTO commodity_ending_details(
                            commodity_endings_id, supplier_id, grn_number, cert_number, production_number, 
                            stores_id, location_id, woredas_id, commodity_type, grade, process_type, crop_year, 
                            uoms_id, no_of_bag, bag_weight, total_kg, net_kg, feresula, unit_cost, total_cost,remark)
            
                            SELECT DISTINCT '.$commend->id.',SupplierId,GrnNumber,CertNumber,ProductionNumber,
                            StoreId,LocationId,woredaId,CommodityType,Grade,ProcessType,CropYear,
                            uomId,
                            ROUND(SUM(COALESCE(StockInNumOfBag,0)) - SUM(COALESCE(StockOutNumOfBag,0)), 2),
                            ROUND((SUM(COALESCE(StockInNumOfBag,0)) - SUM(COALESCE(StockOutNumOfBag,0))) * uoms.bagweight, 2),
                            ROUND(SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0)), 2) + ROUND((SUM(COALESCE(StockInNumOfBag,0)) - SUM(COALESCE(StockOutNumOfBag,0))) * uoms.bagweight, 2),
                            ROUND(SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0)), 2) AS net_kg,
                            ROUND((SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0))) / 17, 2),
                            ROUND((SUM(COALESCE(TotalCostComm,0)) / SUM(COALESCE(StockInComm,0))),2),
                            ROUND((SUM(COALESCE(TotalCostComm,0)) / SUM(COALESCE(StockInComm,0))),2) * ROUND(SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0)), 2),
                            ""
                            FROM transactions 
                            LEFT JOIN uoms ON transactions.uomId = uoms.id
                            WHERE transactions.FiscalYear='.$beg->FiscalYear.' 
                            AND transactions.customers_id='.$beg->customers_id.' 
                            AND transactions.StoreId='.$beg->stores_id.'
                            AND transactions.ItemType="Commodity"    
                            AND transactions.ProductionNumber NOT IN("","-","--")
                            AND transactions.CertNumber NOT IN("","-","--")
                            AND transactions.woredaId > 2

                            GROUP BY 
                            woredaId,ProductionNumber,CertNumber,LocationId,
                            CommodityType,Grade,ProcessType,CropYear,StoreId,uomId,customers_id
                            HAVING net_kg > 0');

            $syncToEnding3=DB::select('INSERT IGNORE INTO commodity_ending_details(
                            commodity_endings_id, supplier_id, grn_number, cert_number, production_number, 
                            stores_id, location_id, woredas_id, commodity_type, grade, process_type, crop_year, 
                            uoms_id, no_of_bag, bag_weight, total_kg, net_kg, feresula, unit_cost, total_cost,remark)
            
                            SELECT DISTINCT '.$commend->id.',"","","","",
                            StoreId,LocationId,woredaId,CommodityType,Grade,ProcessType,CropYear,
                            uomId,
                            ROUND(SUM(COALESCE(StockInNumOfBag,0)) - SUM(COALESCE(StockOutNumOfBag,0)), 2),
                            ROUND((SUM(COALESCE(StockInNumOfBag,0)) - SUM(COALESCE(StockOutNumOfBag,0))) * uoms.bagweight, 2),
                            ROUND(SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0)), 2) + ROUND((SUM(COALESCE(StockInNumOfBag,0)) - SUM(COALESCE(StockOutNumOfBag,0))) * uoms.bagweight, 2),
                            ROUND(SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0)), 2) AS net_kgs,
                            ROUND((SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0))) / 17, 2),
                            ROUND((SUM(COALESCE(TotalCostComm,0)) / SUM(COALESCE(StockInComm,0))),2),
                            ROUND((SUM(COALESCE(TotalCostComm,0)) / SUM(COALESCE(StockInComm,0))),2) * ROUND(SUM(COALESCE(StockInComm,0)) - SUM(COALESCE(StockOutComm,0)), 2),
                            ""
                            FROM transactions 
                            LEFT JOIN uoms ON transactions.uomId = uoms.id
                            WHERE transactions.FiscalYear='.$beg->FiscalYear.' 
                            AND transactions.customers_id='.$beg->customers_id.' 
                            AND transactions.StoreId='.$beg->stores_id.'
                            AND transactions.ItemType="Commodity"    
                            AND transactions.woredaId = 1
                            GROUP BY 
                            woredaId,LocationId,
                            CommodityType,Grade,ProcessType,CropYear,StoreId,uomId,customers_id
                            HAVING net_kgs > 0');

            $balance1 = DB::table('commodity_ending_details as ced')
                ->leftJoin('woredas as w', 'ced.woredas_id', '=', 'w.id')
                ->leftJoin('zones as z', 'w.zone_id', '=', 'z.id')
                ->leftJoin('regions as r', 'z.Rgn_Id', '=', 'r.id')
                ->leftJoin('lookups as ct', 'ced.commodity_type', '=', 'ct.CommodityTypeValue')
                ->leftJoin('lookups as g', 'ced.grade', '=', 'g.GradeValue')
                ->leftJoin('lookups as crop', 'ced.crop_year', '=', 'crop.CropYearValue')
                ->leftJoin('uoms as u', 'ced.uoms_id', '=', 'u.id')
                ->leftJoin('customers as c', 'ced.supplier_id', '=', 'c.id')
                ->leftJoin('locations as l', 'ced.location_id', '=', 'l.id')
                ->leftJoin('stores as s', 'ced.stores_id', '=', 's.id')
                ->select([
                    'ced.id as detail_id',
                    'l.Name as FloorMap',
                    'ced.woredas_id',
                    'ct.CommodityType',
                    DB::raw('IFNULL(c.Name, "") as Supplier'),
                    DB::raw('IFNULL(ced.grn_number, "") as GrnNumber'),
                    DB::raw('IFNULL(ced.production_number, "") as ProductionNumber'),
                    DB::raw('IFNULL(ced.cert_number, "") as CertNumber'),
                    DB::raw("CONCAT_WS(', ', NULLIF(r.Rgn_Name, ''), NULLIF(z.Zone_Name, ''), NULLIF(w.Woreda_Name, '')) as Commodity"),
                    'g.Grade',
                    'ced.process_type as ProcessType',
                    'crop.CropYear',
                    's.Name as StoreName',
                    'u.Name as UomName',
                    'u.bagweight as bagweight',
                    'u.uomamount as uomamount',
                    'ced.no_of_bag',
                    'ced.bag_weight',
                    'ced.total_kg',
                    'ced.net_kg',
                    'ced.feresula',
                    'ced.unit_cost',
                    'ced.total_cost',
                    'ced.disc_shortage_kg',
                    'ced.disc_overage_kg',
                    'ced.disc_shortage_bag',
                    'ced.disc_overage_bag',
                    DB::raw("
                        (
                            SELECT ROUND(SUM(COALESCE(t.StockInComm, 0)) - SUM(COALESCE(t.StockOutComm, 0)), 2)
                            FROM transactions t
                            WHERE 
                                t.woredaId = ced.woredas_id AND
                                t.SupplierId = ced.supplier_id AND
                                t.GrnNumber = ced.grn_number AND
                                t.ProductionNumber = ced.production_number AND
                                t.CertNumber = ced.cert_number AND
                                t.LocationId = ced.location_id AND
                                t.CommodityType = ced.commodity_type AND
                                t.Grade = ced.grade AND
                                t.ProcessType = ced.process_type AND
                                t.CropYear = ced.crop_year AND
                                t.StoreId = ced.stores_id AND
                                t.uomId = ced.uoms_id 
                        ) as available_net_kg
                    "),
                    DB::raw("
                        (
                            SELECT ROUND(SUM(COALESCE(t.StockInNumOfBag, 0)) - SUM(COALESCE(t.StockOutNumOfBag, 0)), 2)
                            FROM transactions t
                            WHERE 
                                t.woredaId = ced.woredas_id AND
                                t.SupplierId = ced.supplier_id AND
                                t.GrnNumber = ced.grn_number AND
                                t.ProductionNumber = ced.production_number AND
                                t.CertNumber = ced.cert_number AND
                                t.LocationId = ced.location_id AND
                                t.CommodityType = ced.commodity_type AND
                                t.Grade = ced.grade AND
                                t.ProcessType = ced.process_type AND
                                t.CropYear = ced.crop_year AND
                                t.StoreId = ced.stores_id AND
                                t.uomId = ced.uoms_id 
                        ) as available_bag
                    ")
                ])
                ->where('ced.commodity_endings_id', $commend->id)
                ->where('ced.woredas_id','>',2);

            $balance2 = DB::table('commodity_ending_details as ced')
                ->leftJoin('woredas as w', 'ced.woredas_id', '=', 'w.id')
                ->leftJoin('zones as z', 'w.zone_id', '=', 'z.id')
                ->leftJoin('regions as r', 'z.Rgn_Id', '=', 'r.id')
                ->leftJoin('lookups as ct', 'ced.commodity_type', '=', 'ct.CommodityTypeValue')
                ->leftJoin('lookups as g', 'ced.grade', '=', 'g.GradeValue')
                ->leftJoin('lookups as crop', 'ced.crop_year', '=', 'crop.CropYearValue')
                ->leftJoin('uoms as u', 'ced.uoms_id', '=', 'u.id')
                ->leftJoin('customers as c', 'ced.supplier_id', '=', 'c.id')
                ->leftJoin('locations as l', 'ced.location_id', '=', 'l.id')
                ->leftJoin('stores as s', 'ced.stores_id', '=', 's.id')
                ->select([
                    'ced.id as detail_id',
                    'l.Name as FloorMap',
                    'ced.woredas_id',
                    'ct.CommodityType',
                    DB::raw('"" as Supplier'),
                    DB::raw('"" as GrnNumber'),
                    DB::raw('"" as ProductionNumber'),
                    DB::raw('"" as CertNumber'),
                    DB::raw("CONCAT_WS(', ', NULLIF(r.Rgn_Name, ''), NULLIF(z.Zone_Name, ''), NULLIF(w.Woreda_Name, '')) as Commodity"),
                    'g.Grade',
                    'ced.process_type as ProcessType',
                    'crop.CropYear',
                    's.Name as StoreName',
                    'u.Name as UomName',
                    'u.bagweight as bagweight',
                    'u.uomamount as uomamount',
                    'ced.no_of_bag',
                    'ced.bag_weight',
                    'ced.total_kg',
                    'ced.net_kg',
                    'ced.feresula',
                    'ced.unit_cost',
                    'ced.total_cost',
                    'ced.disc_shortage_kg',
                    'ced.disc_overage_kg',
                    'ced.disc_shortage_bag',
                    'ced.disc_overage_bag',
                    DB::raw("
                        (
                            SELECT ROUND(SUM(COALESCE(t.StockInComm, 0)) - SUM(COALESCE(t.StockOutComm, 0)), 2)
                            FROM transactions t
                            WHERE 
                                t.woredaId = ced.woredas_id AND
                                t.CommodityType = ced.commodity_type AND
                                t.Grade = ced.grade AND
                                t.ProcessType = ced.process_type AND
                                t.CropYear = ced.crop_year AND
                                t.StoreId = ced.stores_id AND
                                t.LocationId = ced.location_id AND
                                t.uomId = ced.uoms_id AND
                                t.customers_id = ".$beg->customers_id."
                        ) as available_net_kg
                    "),
                    DB::raw("
                        (
                            SELECT ROUND(SUM(COALESCE(t.StockInNumOfBag, 0)) - SUM(COALESCE(t.StockOutNumOfBag, 0)), 2)
                            FROM transactions t
                            WHERE 
                                t.woredaId = ced.woredas_id AND
                                t.CommodityType = ced.commodity_type AND
                                t.Grade = ced.grade AND
                                t.ProcessType = ced.process_type AND
                                t.CropYear = ced.crop_year AND
                                t.StoreId = ced.stores_id AND
                                t.LocationId = ced.location_id AND
                                t.uomId = ced.uoms_id AND
                                t.customers_id = ".$beg->customers_id."
                        ) as available_bag
                    ")
                ])
                ->where('ced.commodity_endings_id', $commend->id)
                ->where('ced.woredas_id','=',1);

                $balance = $balance1->union($balance2)->get();

            return Response::json(['balance' => $balance, 'type' => $beg->product_type]);
        }

        if($beg->product_type == 2){
            $syncToEnding1 = DB::select('INSERT IGNORE INTO commodity_ending_details(
                    commodity_endings_id, supplier_id, grn_number, cert_number, production_number, 
                    stores_id, location_id, woredas_id, commodity_type, grade, process_type, crop_year, 
                    uoms_id, no_of_bag, bag_weight, total_kg, net_kg, feresula,item_id,quantity,unit_cost, 
                    total_cost,remark,created_at,updated_at)
    
                    SELECT DISTINCT '.$commend->id.',"0","0","0","0",
                    StoreId,LocationId,"0","0","0","0","0",
                    uomId,
                    "0","0","0","0","0",
                    ItemId,
                    SUM(COALESCE(transactions.StockIn,0)) - SUM(COALESCE(transactions.StockOut,0)) AS qty,
                    ROUND((SUM(COALESCE(TotalCost,0)) / SUM(COALESCE(StockIn,0))),2),
                    ROUND((SUM(COALESCE(transactions.TotalCost,0)) / SUM(COALESCE(transactions.StockIn,0))),2) * ROUND(SUM(COALESCE(transactions.StockIn,0)) - SUM(COALESCE(transactions.StockOut,0)), 2),
                    "","'.Carbon::now().'","'.Carbon::now().'"

                    FROM transactions 
                    LEFT JOIN uoms ON transactions.uomId = uoms.id
                    WHERE transactions.FiscalYear='.$beg->FiscalYear.' 
                    AND transactions.customers_id='.$beg->customers_id.' 
                    AND transactions.StoreId='.$beg->stores_id.'
                    AND transactions.ItemType="Goods"    

                    GROUP BY transactions.ItemId,transactions.LocationId
                    HAVING qty > 0');

            $balance = DB::select('SELECT locations.Name AS location_name,regitems.Name AS item_name,uoms.Name AS uom_name,(SELECT ROUND((SUM(COALESCE(TotalCost,0)) / SUM(COALESCE(StockIn,0))),2) FROM transactions WHERE transactions.ItemId=commodity_ending_details.item_id) AS average_cost,(SELECT SUM(COALESCE(transactions.StockIn,0)) - SUM(COALESCE(transactions.StockOut,0)) FROM transactions WHERE transactions.ItemId=commodity_ending_details.item_id) AS system_count,commodity_ending_details.quantity,commodity_ending_details.variance_shortage,commodity_ending_details.variance_overage,commodity_ending_details.id AS record_id FROM commodity_ending_details LEFT JOIN locations ON commodity_ending_details.location_id=locations.id LEFT JOIN regitems ON commodity_ending_details.item_id=regitems.id LEFT JOIN uoms ON commodity_ending_details.uoms_id=uoms.id WHERE commodity_ending_details.commodity_endings_id='.$commend->id);

            return Response::json(['balance' => $balance, 'type' => $beg->product_type]);
        }
    }

    public function saveCommEnding(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $doc_num = null;
        $currentdocnum = null;
        $cus_id = $request->customer_owner_id;
        $beg_id = $request->beginning_id;

        $beg_data = commoditybeg::find($beg_id);
        $prdtype = $beg_data->product_type;

        if($prdtype == 1){
            $rules = array(
                'endrow.*.num_of_bag' => 'required',
                'endrow.*.total_kg' => 'required',
            );
        }
        else if($prdtype == 2){
            $rules = array(
                'goodsrow.*.PhysicalCount' => 'required'
            );
        }
        
        $v2= Validator::make($request->all(), $rules);

        if($v2->passes()){

            DB::beginTransaction();
            try
            {
                $beg = commoditybeg::find($beg_id);
                
                $comm_ending = DB::table('commodity_endings')
                            ->where('commoditybegs_id',$beg_id)
                            ->first();
                        
                $findid = $comm_ending->id ?? null;
                $comm_end = commodity_ending::find($findid);
                $doc_number = $comm_end->document_number ?? 0;

                if($cus_id == 1){
                    $maxDocNumber  = commodity_ending::where('customers_id',1)->max('last_doc_number');
                    $doc_num = $settings->ending_owner_doc_prefix.sprintf("%06d",$maxDocNumber +1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum = $maxDocNumber + 1;
                }
                else{
                    $maxDocNumber = commodity_ending::where('customers_id','!=',1)->max('last_doc_number');
                    $doc_num = $settings->ending_customer_doc_prefix.sprintf("%06d",$maxDocNumber+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum = $maxDocNumber + 1;
                }

                if($doc_number == "0"){

                    DB::table('commodity_endings')
                    ->where('id',$findid)
                    ->update(['document_number'=>$doc_num,'last_doc_number'=>$currentdocnum]);
                }

                $comm_end_upd = commodity_ending::find($findid);
                $doc_num_upd = $comm_end_upd->document_number ?? 0;

                DB::table('commoditybegs')
                ->where('id',$beg_id)
                ->update(['EndingDocumentNumber' => "{$doc_num_upd} ({$comm_end_upd->status})"]);
                
                if($prdtype == 1){
                    foreach ($request->endrow as $key => $value){
                        commodity_ending_detail::updateOrCreate(['id' => $value['detail_id']],
                        [ 
                            'no_of_bag' => $value['num_of_bag'],
                            'bag_weight' => $value['bag_weight'],
                            'total_kg' => $value['total_kg'],
                            'net_kg' => $value['net_kg'],
                            'feresula' => round(($value['net_kg'] / 17),2),
                            'unit_cost' => $value['unit_cost'],
                            'total_cost' => $value['total_cost'],
                            'disc_shortage_bag' => $value['disc_shortage_bag'],
                            'disc_overage_bag' => $value['disc_overage_bag'],
                            'disc_shortage_kg' => $value['disc_shortage_kg'],
                            'disc_overage_kg' => $value['disc_overage_kg']
                        ]);
                    }
                }
                else if($prdtype == 2){
                    foreach ($request->goodsrow as $goodskey => $goodsvalue){
                        commodity_ending_detail::updateOrCreate(['id' => $goodsvalue['record_id']],
                        [ 
                            'quantity' => $goodsvalue['PhysicalCount'],
                            'variance_shortage' => $goodsvalue['VarianceShortage'],
                            'variance_overage' => $goodsvalue['VarianceOverage'],
                            'unit_cost' => $goodsvalue['AverageCost'],
                            'total_cost' => round(($goodsvalue['AverageCost'] * $goodsvalue['PhysicalCount']),2)
                        ]);
                    }
                }

                $actions = $doc_number == "0" ? "Created" : "Edited";

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"commend",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            
                DB::commit();
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($v2->fails())
        {
            return response()->json(['errorv2' => $v2->errors()->all(),'type' => $prdtype]);
        }
    }

    public function showCommEnd($id){
        $datefromval=0;

        $comm_ending = DB::table('commodity_endings')
                    ->where('commoditybegs_id',$id)
                    ->first();
                
        $findid = $comm_ending->id ?? null;
        $beg = commoditybeg::find($comm_ending->commoditybegs_id);

        $commenddata=commodity_ending::join('stores','commodity_endings.stores_id','stores.id')
        ->join('commoditybegs','commodity_endings.commoditybegs_id','commoditybegs.id')
        ->join('customers','commodity_endings.customers_id','customers.id')
        ->join('fiscalyear','commodity_endings.fiscal_year','fiscalyear.FiscalYear')
        ->where('commodity_endings.id',$findid)
        ->get(['commodity_endings.id as eid','commodity_endings.*','commoditybegs.DocumentNumber','stores.Name AS StoreName','customers.Name AS CustomerName','customers.Code AS CustomerCode',
        'customers.TinNumber','customers.PhoneNumber','customers.OfficePhone','customers.EmailAddress','fiscalyear.Monthrange',DB::raw('DATE_FORMAT(commodity_endings.created_at,"%Y-%m-%d") AS Date')]);

        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"commend")
        ->where('pageid',$findid)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['commenddata'=>$commenddata,'activitydata'=>$activitydata,'type'=>$beg->product_type]);       
    }

    public function showCommEnding(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        
        $beg_id = $_POST['beg_id']; 
        $beg = commoditybeg::find($beg_id);
        $product_type = $beg->product_type;

        $comm_ending = DB::table('commodity_endings')
                    ->where('commoditybegs_id',$beg_id)
                    ->first();
                
        $findid = $comm_ending->id ?? null;

        if($product_type == 1){
            $query1 = DB::table('commodity_ending_details as ced')
                ->leftJoin('woredas as w', 'ced.woredas_id', '=', 'w.id')
                ->leftJoin('zones as z', 'w.zone_id', '=', 'z.id')
                ->leftJoin('regions as r', 'z.Rgn_Id', '=', 'r.id')
                ->leftJoin('lookups as ct', 'ced.commodity_type', '=', 'ct.CommodityTypeValue')
                ->leftJoin('lookups as g', 'ced.grade', '=', 'g.GradeValue')
                ->leftJoin('lookups as crop', 'ced.crop_year', '=', 'crop.CropYearValue')
                ->leftJoin('uoms as u', 'ced.uoms_id', '=', 'u.id')
                ->leftJoin('customers as c', 'ced.supplier_id', '=', 'c.id')
                ->leftJoin('locations as l', 'ced.location_id', '=', 'l.id')
                ->leftJoin('stores as s', 'ced.stores_id', '=', 's.id')
                ->select([
                    'ced.id as detail_id',
                    'l.Name as FloorMap',
                    'ced.woredas_id',
                    'ct.CommodityType',
                    DB::raw('IFNULL(c.Name, "") as Supplier'),
                    DB::raw('IFNULL(ced.grn_number, "") as GrnNumber'),
                    DB::raw('IFNULL(ced.production_number, "") as ProductionNumber'),
                    DB::raw('IFNULL(ced.cert_number, "") as CertNumber'),
                    DB::raw("CONCAT_WS(', ', NULLIF(r.Rgn_Name, ''), NULLIF(z.Zone_Name, ''), NULLIF(w.Woreda_Name, '')) as Commodity"),
                    'g.Grade',
                    'ced.process_type as ProcessType',
                    'crop.CropYear',
                    's.Name as StoreName',
                    'u.Name as UomName',
                    'u.bagweight as bagweight',
                    'u.uomamount as uomamount',
                    'ced.no_of_bag',
                    'ced.bag_weight',
                    'ced.total_kg',
                    'ced.net_kg',
                    'ced.feresula',
                    'ced.unit_cost',
                    'ced.total_cost',
                    'ced.disc_shortage_kg',
                    'ced.disc_overage_kg',
                    'ced.disc_shortage_bag',
                    'ced.disc_overage_bag',
                    'ced.variance_shortage',
                    'ced.variance_overage',
                    DB::raw("
                        (
                            SELECT ROUND(SUM(COALESCE(t.StockInComm, 0)) - SUM(COALESCE(t.StockOutComm, 0)), 2)
                            FROM transactions t
                            WHERE 
                                t.woredaId = ced.woredas_id AND
                                t.SupplierId = ced.supplier_id AND
                                t.GrnNumber = ced.grn_number AND
                                t.ProductionNumber = ced.production_number AND
                                t.CertNumber = ced.cert_number AND
                                t.LocationId = ced.location_id AND
                                t.CommodityType = ced.commodity_type AND
                                t.Grade = ced.grade AND
                                t.ProcessType = ced.process_type AND
                                t.CropYear = ced.crop_year AND
                                t.StoreId = ced.stores_id AND
                                t.uomId = ced.uoms_id AND
                                t.customers_id = ".$beg->customers_id."
                        ) as available_net_kg
                    "),
                    DB::raw("
                        (
                            SELECT ROUND(SUM(COALESCE(t.StockInNumOfBag, 0)) - SUM(COALESCE(t.StockOutNumOfBag, 0)), 2)
                            FROM transactions t
                            WHERE 
                                t.woredaId = ced.woredas_id AND
                                t.SupplierId = ced.supplier_id AND
                                t.GrnNumber = ced.grn_number AND
                                t.ProductionNumber = ced.production_number AND
                                t.CertNumber = ced.cert_number AND
                                t.LocationId = ced.location_id AND
                                t.CommodityType = ced.commodity_type AND
                                t.Grade = ced.grade AND
                                t.ProcessType = ced.process_type AND
                                t.CropYear = ced.crop_year AND
                                t.StoreId = ced.stores_id AND
                                t.uomId = ced.uoms_id AND
                                t.customers_id = ".$beg->customers_id."
                        ) as available_bag
                    "),
                    DB::raw("
                        (
                            SELECT ROUND(SUM(COALESCE(t.StockInNumOfBag, 0)) - SUM(COALESCE(t.StockOutNumOfBag, 0)), 2)
                            FROM transactions t
                            WHERE 
                                t.woredaId = ced.woredas_id AND
                                t.SupplierId = ced.supplier_id AND
                                t.GrnNumber = ced.grn_number AND
                                t.ProductionNumber = ced.production_number AND
                                t.CertNumber = ced.cert_number AND
                                t.LocationId = ced.location_id AND
                                t.CommodityType = ced.commodity_type AND
                                t.Grade = ced.grade AND
                                t.ProcessType = ced.process_type AND
                                t.CropYear = ced.crop_year AND
                                t.StoreId = ced.stores_id AND
                                t.uomId = ced.uoms_id AND
                                t.customers_id = ".$beg->customers_id."
                        ) * u.bagweight  as available_bagweight
                    ")
                ])
                ->where('ced.commodity_endings_id', $findid)
                ->where('ced.woredas_id','>',2);

            $query2 = DB::table('commodity_ending_details as ced')
                ->leftJoin('woredas as w', 'ced.woredas_id', '=', 'w.id')
                ->leftJoin('zones as z', 'w.zone_id', '=', 'z.id')
                ->leftJoin('regions as r', 'z.Rgn_Id', '=', 'r.id')
                ->leftJoin('lookups as ct', 'ced.commodity_type', '=', 'ct.CommodityTypeValue')
                ->leftJoin('lookups as g', 'ced.grade', '=', 'g.GradeValue')
                ->leftJoin('lookups as crop', 'ced.crop_year', '=', 'crop.CropYearValue')
                ->leftJoin('uoms as u', 'ced.uoms_id', '=', 'u.id')
                ->leftJoin('customers as c', 'ced.supplier_id', '=', 'c.id')
                ->leftJoin('locations as l', 'ced.location_id', '=', 'l.id')
                ->leftJoin('stores as s', 'ced.stores_id', '=', 's.id')
                ->select([
                    'ced.id as detail_id',
                    'l.Name as FloorMap',
                    'ced.woredas_id',
                    'ct.CommodityType',
                    DB::raw('IFNULL(c.Name, "") as Supplier'),
                    DB::raw('IFNULL(ced.grn_number, "") as GrnNumber'),
                    DB::raw('IFNULL(ced.production_number, "") as ProductionNumber'),
                    DB::raw('IFNULL(ced.cert_number, "") as CertNumber'),
                    DB::raw("CONCAT_WS(', ', NULLIF(r.Rgn_Name, ''), NULLIF(z.Zone_Name, ''), NULLIF(w.Woreda_Name, '')) as Commodity"),
                    'g.Grade',
                    'ced.process_type as ProcessType',
                    'crop.CropYear',
                    's.Name as StoreName',
                    'u.Name as UomName',
                    'u.bagweight as bagweight',
                    'u.uomamount as uomamount',
                    'ced.no_of_bag',
                    'ced.bag_weight',
                    'ced.total_kg',
                    'ced.net_kg',
                    'ced.feresula',
                    'ced.unit_cost',
                    'ced.total_cost',
                    'ced.disc_shortage_kg',
                    'ced.disc_overage_kg',
                    'ced.disc_shortage_bag',
                    'ced.disc_overage_bag',
                    'ced.variance_shortage',
                    'ced.variance_overage',
                    DB::raw("
                        (
                            SELECT ROUND(SUM(COALESCE(t.StockInComm, 0)) - SUM(COALESCE(t.StockOutComm, 0)), 2)
                            FROM transactions t
                            WHERE 
                                t.woredaId = ced.woredas_id AND
                                t.LocationId = ced.location_id AND
                                t.CommodityType = ced.commodity_type AND
                                t.Grade = ced.grade AND
                                t.ProcessType = ced.process_type AND
                                t.CropYear = ced.crop_year AND
                                t.StoreId = ced.stores_id AND
                                t.uomId = ced.uoms_id AND
                                t.customers_id = ".$beg->customers_id."
                        ) as available_net_kg
                    "),
                    DB::raw("
                        (
                            SELECT ROUND(SUM(COALESCE(t.StockInNumOfBag, 0)) - SUM(COALESCE(t.StockOutNumOfBag, 0)), 2)
                            FROM transactions t
                            WHERE 
                                t.woredaId = ced.woredas_id AND
                                t.LocationId = ced.location_id AND
                                t.CommodityType = ced.commodity_type AND
                                t.Grade = ced.grade AND
                                t.ProcessType = ced.process_type AND
                                t.CropYear = ced.crop_year AND
                                t.StoreId = ced.stores_id AND
                                t.uomId = ced.uoms_id AND
                                t.customers_id = ".$beg->customers_id."
                        ) as available_bag
                    "),
                    DB::raw("
                        (
                            SELECT ROUND(SUM(COALESCE(t.StockInNumOfBag, 0)) - SUM(COALESCE(t.StockOutNumOfBag, 0)), 2)
                            FROM transactions t
                            WHERE 
                                t.woredaId = ced.woredas_id AND
                                t.LocationId = ced.location_id AND
                                t.CommodityType = ced.commodity_type AND
                                t.Grade = ced.grade AND
                                t.ProcessType = ced.process_type AND
                                t.CropYear = ced.crop_year AND
                                t.StoreId = ced.stores_id AND
                                t.uomId = ced.uoms_id AND
                                t.customers_id = ".$beg->customers_id."
                        ) * u.bagweight  as available_bagweight
                    ")
                ])
                ->where('ced.commodity_endings_id', $findid)
                ->where('ced.woredas_id','=',1);

                $query = $query1->union($query2)->get();

            return datatables()->of($query)->addIndexColumn()->toJson();
        }
        
        if($product_type == 2){
            $query = DB::select('SELECT locations.Name AS location_name,regitems.Name AS item_name,uoms.Name AS uom_name,(SELECT ROUND((SUM(COALESCE(TotalCost,0)) / SUM(COALESCE(StockIn,0))),2) FROM transactions WHERE transactions.ItemId=commodity_ending_details.item_id) AS average_cost,(SELECT SUM(COALESCE(transactions.StockIn,0)) - SUM(COALESCE(transactions.StockOut,0)) FROM transactions WHERE transactions.ItemId=commodity_ending_details.item_id) AS system_count,commodity_ending_details.quantity,commodity_ending_details.unit_cost,commodity_ending_details.total_cost,commodity_ending_details.variance_shortage,commodity_ending_details.variance_overage,commodity_ending_details.id AS record_id FROM commodity_ending_details LEFT JOIN locations ON commodity_ending_details.location_id=locations.id LEFT JOIN regitems ON commodity_ending_details.item_id=regitems.id LEFT JOIN uoms ON commodity_ending_details.uoms_id=uoms.id WHERE commodity_ending_details.commodity_endings_id='.$findid);
            return datatables()->of($query)->addIndexColumn()->toJson();
        }
    }

    public function endingForwardAction(Request $request)
    {
        DB::beginTransaction();
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;
            $currentdocnum = null;
            $doc_num = null;
            $total_cost = 0;
            $tax = 0;
            $after_tax = 0;
            $settings = DB::table('settings')->latest()->first();
            $findid = $request->forwardReqId;
            $comm_end = commodity_ending::find($findid);
            $currentStatus = $comm_end->status;
            $newStatus = $request->newForwardStatusValue;
            $action = $request->forwardActionValue;
            $comm_end->status = $newStatus;
            
            $comm_beg = commoditybeg::find($comm_end->commoditybegs_id);
            $comm_beg->EndingDocumentNumber = "{$comm_end->document_number} ({$newStatus})";
            
            if($newStatus == "Approved"){
                $comm_beg->EndingDocumentNumber = $comm_end->document_number;

                $fiscalyr = $settings->FiscalYear;
                $fyear = $fiscalyr-1;
                $fiscalyrchanged = $settings->IsFiscalYearChanged;

                $receiving_count = DB::table('receivings')
                                    ->whereIn('Status', ["Draft","Pending","Verified","Checked"])
                                    ->where('StoreId',$comm_end->stores_id)
                                    ->where('CustomerOrOwner',$comm_end->customers_id)
                                    ->count();

                $requisition_count = DB::table('requisitions')
                                    ->whereIn('Status', ["Draft","Pending","Verified","Reviewed","Approved"])
                                    ->where('SourceStoreId',$comm_end->stores_id)
                                    ->where('CustomerOrOwner',$comm_end->customers_id)
                                    ->count();

                $production_count = DB::table('prd_orders')
                                    ->whereIn('Status', ["Pending","Ready","On-Production","Process-Finished","Verified"])
                                    ->where('customers_id',$comm_end->customers_id)
                                    ->count();

                $discrepancy_sum = DB::table('commodity_ending_details')
                                ->leftJoin('commodity_endings','commodity_ending_details.commodity_endings_id','commodity_endings.id')
                                ->where('commodity_endings.customers_id',$comm_end->customers_id)
                                ->where('commodity_ending_details.commodity_endings_id',$findid)
                                ->selectRaw('
                                    SUM(COALESCE(disc_shortage_kg, 0)) as disc_shortage_kg,
                                    SUM(COALESCE(disc_overage_kg, 0)) as disc_overage_kg,
                                    SUM(COALESCE(disc_shortage_bag, 0)) as disc_shortage_bag,
                                    SUM(COALESCE(disc_overage_bag, 0)) as disc_overage_bag
                                ')
                                ->first();

                $unit_cost_count = DB::table('commodity_ending_details')
                                ->leftJoin('commodity_endings','commodity_ending_details.commodity_endings_id','commodity_endings.id')
                                ->where('commodity_endings.customers_id',1)
                                ->where('commodity_ending_details.commodity_endings_id',$findid)
                                ->where(function($query) {
                                    $query->whereNull('unit_cost')
                                        ->orWhere('unit_cost', 0);
                                })
                                ->count();

                if($receiving_count > 0){
                    return Response::json(['receiving_error' =>  "error"]);
                }
                else if($requisition_count > 0){
                    return Response::json(['requisition_error' =>  "error"]);
                }
                else if($production_count > 0){
                    return Response::json(['production_error' =>  "error"]);
                }
                else if(
                    $discrepancy_sum->disc_shortage_kg > 0 || $discrepancy_sum->disc_overage_kg > 0 || 
                    $discrepancy_sum->disc_shortage_bag > 0 || $discrepancy_sum->disc_overage_bag > 0
                ){
                    $discrepancy_error_list = DB::table('commodity_ending_details as ced')
                            ->leftJoin('woredas as w', 'ced.woredas_id', '=', 'w.id')
                            ->leftJoin('zones as z', 'w.zone_id', '=', 'z.id')
                            ->leftJoin('regions as r', 'z.Rgn_Id', '=', 'r.id')
                            ->leftJoin('lookups as ct', 'ced.commodity_type', '=', 'ct.CommodityTypeValue')
                            ->leftJoin('lookups as g', 'ced.grade', '=', 'g.GradeValue')
                            ->leftJoin('lookups as crop', 'ced.crop_year', '=', 'crop.CropYearValue')
                            ->leftJoin('uoms as u', 'ced.uoms_id', '=', 'u.id')
                            ->leftJoin('customers as c', 'ced.supplier_id', '=', 'c.id')
                            ->leftJoin('locations as l', 'ced.location_id', '=', 'l.id')
                            ->select([
                                'l.Name as FloorMap',
                                'ct.CommodityType',
                                DB::raw('IFNULL(c.Name, "") as Supplier'),
                                DB::raw('IFNULL(ced.grn_number, "") as GrnNumber'),
                                DB::raw('IFNULL(ced.production_number, "") as ProductionNumber'),
                                DB::raw('IFNULL(ced.cert_number, "") as CertNumber'),
                                DB::raw("CONCAT_WS(', ', NULLIF(r.Rgn_Name, ''), NULLIF(z.Zone_Name, ''), NULLIF(w.Woreda_Name, '')) as Commodity"),
                                'g.Grade',
                                'ced.process_type as ProcessType',
                                'crop.CropYear'
                            ])
                            ->where('ced.disc_shortage_kg','>',0)
                            ->orWhere('ced.disc_overage_kg','>',0)
                            ->orWhere('ced.disc_shortage_bag','>',0)
                            ->orWhere('ced.disc_overage_bag','>',0)
                            ->distinct()
                            ->get();

                    return Response::json(['discrepancy_error' =>  "error", 'discrepancy_error_list' => $discrepancy_error_list]);
                }
                else if($unit_cost_count > 0){
                    $unit_cost_error_list = DB::table('commodity_ending_details as ced')
                            ->leftJoin('woredas as w', 'ced.woredas_id', '=', 'w.id')
                            ->leftJoin('zones as z', 'w.zone_id', '=', 'z.id')
                            ->leftJoin('regions as r', 'z.Rgn_Id', '=', 'r.id')
                            ->leftJoin('lookups as ct', 'ced.commodity_type', '=', 'ct.CommodityTypeValue')
                            ->leftJoin('lookups as g', 'ced.grade', '=', 'g.GradeValue')
                            ->leftJoin('lookups as crop', 'ced.crop_year', '=', 'crop.CropYearValue')
                            ->leftJoin('uoms as u', 'ced.uoms_id', '=', 'u.id')
                            ->leftJoin('customers as c', 'ced.supplier_id', '=', 'c.id')
                            ->leftJoin('locations as l', 'ced.location_id', '=', 'l.id')
                            ->select([
                                'l.Name as FloorMap',
                                'ct.CommodityType',
                                DB::raw('IFNULL(c.Name, "") as Supplier'),
                                DB::raw('IFNULL(ced.grn_number, "") as GrnNumber'),
                                DB::raw('IFNULL(ced.production_number, "") as ProductionNumber'),
                                DB::raw('IFNULL(ced.cert_number, "") as CertNumber'),
                                DB::raw("CONCAT_WS(', ', NULLIF(r.Rgn_Name, ''), NULLIF(z.Zone_Name, ''), NULLIF(w.Woreda_Name, '')) as Commodity"),
                                'g.Grade',
                                'ced.process_type as ProcessType',
                                'crop.CropYear'
                            ])
                            ->whereNull('unit_cost')
                            ->orWhere('ced.unit_cost','=',0)
                            ->distinct()
                            ->get();

                    return Response::json(['unit_cost_error' =>  "error", 'unit_cost_error_list' => $unit_cost_error_list]);
                }
                else if($fiscalyrchanged == 0){
                    return Response::json(['fiscalyear_error' =>  "error"]);
                }
                else{
                    if($comm_end->customers_id == 1){
                        $maxDocNumber  = commoditybeg::where('customers_id',1)->where('FiscalYear',$settings->FiscalYear)->max('LastDocNumber');
                        $doc_num = $settings->CommodityBeginningPrefix.sprintf("%06d",$maxDocNumber +1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                        $currentdocnum = $maxDocNumber + 1;
                    }
                    else if($comm_end->customers_id != 1){
                        $maxDocNumber = commoditybeg::where('customers_id','!=',1)->where('FiscalYear',$settings->FiscalYear)->max('LastDocNumber');
                        $doc_num = $settings->CommodityCusBeginningPrefix.sprintf("%06d",$maxDocNumber+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                        $currentdocnum = $maxDocNumber + 1;
                    }

                    $comm_beg_id = null;

                    $comm_beg_data = commoditybeg::updateOrCreate(['id' => $comm_beg_id],
                    [ 
                        'DocumentNumber' => $doc_num,
                        'stores_id'=> $comm_end->stores_id,
                        'customers_id' => $comm_end->customers_id,
                        'FiscalYear' => $settings->FiscalYear,
                        'Status' => "Posted",
                        'LastDocNumber' => $currentdocnum,
                    ]);

                    $ending_detail = DB::select('SELECT * FROM commodity_ending_details WHERE commodity_ending_details.commodity_endings_id='.$findid);       
                    foreach($ending_detail as $row){
                        $comm_bg_detail = new commoditybegdetail;
                        $comm_bg_detail->commoditybegs_id = $comm_beg_data->id;
                        $comm_bg_detail->customers_id = $comm_end->customers_id;
                        $comm_bg_detail->stores_id = $comm_end->stores_id;
                        $comm_bg_detail->SupplierId = $row->supplier_id;
                        $comm_bg_detail->GrnNumber = $row->grn_number;
                        $comm_bg_detail->CertNumber = $row->cert_number;
                        $comm_bg_detail->ProductionNumber = $row->production_number;
                        $comm_bg_detail->LocationId = $row->location_id;
                        $comm_bg_detail->woredas_id = $row->woredas_id;
                        $comm_bg_detail->CommodityType = $row->commodity_type;
                        $comm_bg_detail->Grade = $row->grade;
                        $comm_bg_detail->ProcessType = $row->process_type;
                        $comm_bg_detail->CropYear = $row->crop_year;
                        $comm_bg_detail->uoms_id = $row->uoms_id;
                        $comm_bg_detail->NumOfBag = $row->no_of_bag;
                        $comm_bg_detail->Balance = $row->net_kg;
                        $comm_bg_detail->Feresula = $row->feresula;
                        $comm_bg_detail->UnitPrice = $row->unit_cost;
                        $comm_bg_detail->TotalPrice = $row->total_cost;
                        $comm_bg_detail->VarianceShortage = $row->variance_shortage;
                        $comm_bg_detail->VarianceOverage = $row->variance_overage;
                        $comm_bg_detail->BagWeight = $row->bag_weight;
                        $comm_bg_detail->TotalKg = $row->total_kg;
                        $comm_bg_detail->save();

                        $trn_data = new transaction;
                        $trn_data->HeaderId = $comm_beg_data->id;
                        $trn_data->woredaId = $row->woredas_id;
                        $trn_data->uomId = $row->uoms_id;
                        $trn_data->CommodityType = $row->commodity_type;
                        $trn_data->Grade = $row->grade;
                        $trn_data->ProcessType = $row->process_type;
                        $trn_data->CropYear = $row->crop_year;
                        $trn_data->StockInComm = $row->net_kg;
                        $trn_data->StockInFeresula = $row->feresula;
                        $trn_data->UnitCostComm = $row->unit_cost;
                        $trn_data->TotalCostComm = $row->total_cost;
                        $trn_data->TaxCostComm = round(($row->total_cost * 0.15),2); 
                        $trn_data->GrandTotalCostComm = round((($row->total_cost * 0.15) + $row->total_cost),2); 
                        $trn_data->ItemType = "Commodity";
                        $trn_data->FiscalYear = $settings->FiscalYear;
                        $trn_data->Memo = "";
                        $trn_data->StoreId = $comm_end->stores_id;
                        $trn_data->TransactionType = "Beginning";
                        $trn_data->TransactionsType = "Beginning";
                        $trn_data->Date = Carbon::today()->toDateString();
                        $trn_data->LocationId = $row->location_id;
                        $trn_data->ArrivalDate = Carbon::today()->toDateString();
                        $trn_data->SupplierId = $row->supplier_id;
                        $trn_data->GrnNumber = $row->grn_number;
                        $trn_data->CertNumber = $row->cert_number;
                        $trn_data->ProductionNumber = $row->production_number;
                        $trn_data->StockInNumOfBag = $row->no_of_bag;
                        $trn_data->DocumentNumber = $doc_num;
                        $trn_data->VarianceShortage = $row->variance_shortage;
                        $trn_data->VarianceOverage = $row->variance_overage;
                        $trn_data->BagWeight = $row->bag_weight;
                        $trn_data->TotalKg = $row->total_kg;
                        $trn_data->save();

                        $total_cost += $row->total_cost;
                        $tax += round(($row->total_cost * 0.15),2); 
                        $after_tax += round((($row->total_cost * 0.15) + $row->total_cost),2); 
                    }     
                    
                    commoditybeg::where('id',$comm_beg_data->id)
                                ->update(['TotalPrice' => $total_cost, 'Tax' => $tax, 'GrandTotal' => $after_tax]);
            
                    DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$comm_beg_data->id,'pagename'=>"combeg",'action'=>"Posted",'status'=>"Posted",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);    
                }
            }

            $comm_end->save();
            $comm_beg->save();

            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"commend",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            
            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function endingBackwardAction(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid = $request->backwardReqId;
        $action = $request->backwardActionValue;
        $newStatus = $request->newBackwardStatusValue;
        $comm_end = commodity_ending::find($findid);
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();
            try{
                $comm_end->status = $newStatus;

                $comm_beg = commoditybeg::find($comm_end->commoditybegs_id);
                $comm_beg->EndingDocumentNumber = "{$comm_end->document_number} ({$newStatus})";

                $comm_end->save();
                $comm_beg->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"commend",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->CommentOrReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
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
    //---------------End Ending------------------

    //---------------Start Goods------------------

    public function fetchitemprop(Request $request){
        $item_id = $_POST['item_id']; 
        $itemdata = DB::table('regitems')
            ->leftJoin('uoms', 'regitems.MeasurementId', '=', 'uoms.id')
            ->where('regitems.id',$item_id)
            ->get(['regitems.id','regitems.MeasurementId','uoms.Name AS uom_name']);
 
        return response()->json(['itemdata'=>$itemdata]);       
    }

    public function saveGoodsBeg(Request $request){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->recId;
        $findid=$request->recId;
        $customerid=$request->customers_id ?? 0;
        $storeid = $request->stores_id ?? 0;
        $companytype = $request->CompanyType ?? 0;
        $product_type = $request->ProductType ?? 0;
        $curdate=Carbon::today()->toDateString();
        $settings = DB::table('settings')->latest()->first();
        $totalprice = 0;
        $tax = 0;
        $grandtotal = 0;
        $taxpercent = 15;
        $commdetaildata = [];
        $idvals = [];
        $actiondata = [];
        $documentNumber=$settings->CommodityBeginningPrefix.sprintf("%06d",$settings->CommodityBeginningNumber)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
        $fiscalyear=$settings->FiscalYear;
        $currentdocnum = null;
        $CommBegDocumentNumber = null;
        $suppcnt = 0;
        $grnnumcnt = 0;
        $cernumcnt = 0;
        $prdnumcnt = 0;
        $arrdata = [];
        $detail_goods_data = [];

        if($customerid==1){
            $commbeg = commoditybeg::where('customers_id',1)->latest()->first();
            $CommBegDocumentNumber=$settings->CommodityBeginningPrefix.sprintf("%06d",($commbeg->LastDocNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum=($commbeg->LastDocNumber ?? 0)+1;

            if($findid!=null){
                $commbegin = commoditybeg::where('id',$findid)->latest()->first();
                if($commbegin->customers_id>1){
                    $commbegdata = commoditybeg::where('customers_id',1)->latest()->first();
                    $CommBegDocumentNumber=$settings->CommodityBeginningPrefix.sprintf("%06d",($commbegdata->LastDocNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum=($commbegdata->LastDocNumber ?? 0)+1;
                }
                if($commbegin->customers_id==1){
                    $CommBegDocumentNumber=$commbegin->DocumentNumber;
                    $currentdocnum=$commbegin->LastDocNumber;
                }
            }
        }
        else if($customerid>1){
            $commbeg = commoditybeg::where('customers_id','!=',1)->latest()->first();
            $CommBegDocumentNumber=$settings->CommodityCusBeginningPrefix.sprintf("%06d",($commbeg->LastDocNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum=($commbeg->LastDocNumber ?? 0)+1;

            if($findid!=null){
                $commbegin = commoditybeg::where('id',$findid)->latest()->first();
                if($commbegin->customers_id==1){
                    $commbegdata = commoditybeg::where('customers_id','!=',1)->latest()->first();
                    $CommBegDocumentNumber=$settings->CommodityCusBeginningPrefix.sprintf("%06d",($commbegdata->LastDocNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum=($commbegdata->LastDocNumber ?? 0)+1;
                }
                if($commbegin->customers_id>1){
                    $CommBegDocumentNumber=$commbegin->DocumentNumber;
                    $currentdocnum=$commbegin->LastDocNumber;
                }
            }
        }

        $validator = Validator::make($request->all(), [
            'ProductType' => ['required'],
            'stores_id' => ['required',Rule::unique('commoditybegs')->where(function ($query) use($fiscalyear,$findid,$customerid,$product_type) {
                return $query->where([['FiscalYear',$fiscalyear],['customers_id',$customerid],['product_type',$product_type]]);
            })->ignore($findid)],

            'customers_id' => ['required',Rule::unique('commoditybegs')->where(function ($query) use($fiscalyear,$findid,$storeid,$product_type) {
                return $query->where([['FiscalYear',$fiscalyear],['stores_id',$storeid],['product_type',$product_type]]);
            })->ignore($findid)],

        ]);

        $rules = array(
            'goodsrow.*.FloorMapGoods' => 'required',
            'goodsrow.*.ItemGoods' => 'required',
            'goodsrow.*.QuantityGoods' => 'required',
            'goodsrow.*.UnitCostGoods' => 'nullable',
        );

        $v2= Validator::make($request->all(), $rules);

        if ($validator->passes() && $v2->passes() && $request->goodsrow != null){
            DB::beginTransaction();
            try
            {
                foreach ($request->goodsrow as $key => $value){
                    $totalprice += $value['TotalCostGoods'] ?? 0;
                }
                $tax = round((($totalprice*$taxpercent)/100),2);
                $grandtotal = round(($totalprice+$tax),2);

                $BasicVal = [
                    'product_type' => $request->ProductType,
                    'DocumentNumber' => $CommBegDocumentNumber,
                    'stores_id' => $request->stores_id,
                    'customers_id' => $request->customers_id,
                    'FiscalYear' => $fiscalyear,
                    'TotalPrice' => $totalprice,
                    'Tax' => $tax,
                    'GrandTotal' => $grandtotal,
                    'Remark' => $request->Remark,
                    'LastDocNumber' => $currentdocnum,
                ];

                $DbData = commoditybeg::where('id', $findid)->first();
                $CreatedBy = ['Status'=>"Counting"];
                $LastUpdatedBy = ['updated_at'=>Carbon::now()];
            
                $commbeg = commoditybeg::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                commoditybegdetail::where('commoditybegs_id',$commbeg->id)->delete();

                foreach ($request->goodsrow as $key => $value){
                    $detail_goods_data[] = [
                        'commoditybegs_id' => $commbeg->id,
                        'customers_id' => $request->customers_id,
                        'stores_id' => $request->stores_id,
                        'woredas_id' => 1,
                        'LocationId' => $value['FloorMapGoods'],
                        'item_id' => $value['ItemGoods'],
                        'uoms_id' => $value['uom_id'],
                        'quantity' => $value['QuantityGoods'],
                        'UnitPrice' => $value['UnitCostGoods'],
                        'TotalPrice' => $value['TotalCostGoods'],
                        'ArrivalDate' => Carbon::today()->toDateString(),
                        'Remark' => $value['remarkgoods'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }

                if(!empty($detail_goods_data)){
                    DB::table('commoditybegdetails')->insert($detail_goods_data);
                }

                $actions = $findid == null ? "Created" : "Edited";

                actions::insert(['user_id'=>$userid,'pageid'=>$commbeg->id,'pagename'=>"combeg",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

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
        if($request->goodsrow == null)
        {
            return Response::json(['emptyerror'=>"error"]);
        }
    }

    //---------------End Goods---------------------

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
