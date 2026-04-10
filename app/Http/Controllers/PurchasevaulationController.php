<?php

namespace App\Http\Controllers;
use App\Models\{Purchasevaulation,rfq,purchaseRequest,department,User,Regitem,Commudity,purchaseDetails,setting,uom,store,companyinfo,actions,customer,Purchasevaulationdetail,Pesuplliers,Peinitiations};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Response;
use DataTables;
class PurchasevaulationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userid=Auth()->user()->id;
        $user=User::where('id','>',1)->orderby('FullName','asc')->get();
        $uom=uom::orderby('Name','asc')->get();
        $commudity=Commudity::orderByDesc('Name')->get();
        $percent=setting::where('id',1)->first()->contingency;
        $item=Regitem::where('id','>',1)->orderby('Code','asc')->get();
        $woreda=DB::select('SELECT regions.Rgn_Name,zones.Zone_Name,woredas.Woreda_Name,woredas.id FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id Where woredas.Type=1');
        $department=department::where('id','>',1)->orderby('DepartmentName','asc')->get();
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
        $stores=store::where('id','>',1)->orderby('Name','asc')->get();
        $currentdate = Carbon::today()->toDateString();
        $data=['Supplier','Customer&Supplier'];
        $customer=customer::whereIn('CustomerCategory',$data)->get();
        $cropyear=DB::select('SELECT lookups.CropYear FROM lookups WHERE lookups.CropYearStatus="Active" ORDER BY lookups.CropYearValue  DESC');
        return view('pr.purchasevaulation',['user'=>$user,
                                        'uom'=>$uom,
                                        'department'=>$department,
                                        'commudity'=>$commudity,
                                        'woreda'=>$woreda,
                                        'item'=>$item,
                                        'percent'=>$percent,
                                        'fiscalyears'=>$fiscalyears,
                                        'stores'=>$stores,
                                        'todayDate'=>$currentdate,
                                        'customer'=>$customer,
                                        'cropyear'=>$cropyear,
                                    ]);
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
    public function pevualationlist($type,$fiscalyear)
    {
        switch ($type) {
            case 'pe':
                $pevualation=Purchasevaulation::join('rfqs','rfqs.id','=','purchasevaulations.rfq')
                ->leftjoin('pesuplliers','purchasevaulations.id','pesuplliers.purchasevaulation_id')
                ->leftjoin('customers','pesuplliers.customers_id','customers.id')
                ->where('purchasevaulations.fiscalyear',$fiscalyear)
                ->orderBy('purchasevaulations.id','DESC')
                ->get(['rfqs.documentumber as rfqno','customers.Name','customers.TinNumber','purchasevaulations.id','purchasevaulations.Code','purchasevaulations.petype','purchasevaulations.documentumber','purchasevaulations.type','purchasevaulations.date','purchasevaulations.requiredate','purchasevaulations.status']);
                break;
            case 'te':
                $pevualation=Purchasevaulation::join('rfqs','rfqs.id','=','purchasevaulations.rfq')
                ->whereIn('purchasevaulations.status',[1,2,3])
                ->where('purchasevaulations.fiscalyear',$fiscalyear)
                ->orderBy('purchasevaulations.id','DESC')
                ->get(['rfqs.documentumber as rfqno','purchasevaulations.id','purchasevaulations.petype','purchasevaulations.documentumber','purchasevaulations.type','purchasevaulations.date','purchasevaulations.requiredate','purchasevaulations.status']);
                break;
            default:
                $pevualation=Purchasevaulation::join('rfqs','rfqs.id','=','purchasevaulations.rfq')
                ->whereIn('purchasevaulations.status',[3,8,9])
                ->where('purchasevaulations.fiscalyear',$fiscalyear)
                ->orderBy('purchasevaulations.id','DESC')
                ->get(['rfqs.documentumber as rfqno','purchasevaulations.id','purchasevaulations.petype','purchasevaulations.documentumber','purchasevaulations.type','purchasevaulations.date','purchasevaulations.requiredate','purchasevaulations.status']);
                break;
        }

        return datatables()->of($pevualation)->addIndexColumn()->toJson();
        $user = auth()->user();
        //     $st=[];
        // if ($user->hasAllPermissions(['PE-View', 'TE-View','FE-View'])) {
        //         $st=[0,1,2,3,4,5,6,7,8,9,10,11];
        // }
        // else if ($user->hasAllPermissions(['PE-View', 'TE-View'])) {
        //     $st=[0,1,2,3,4];
        // }
        // else if ($user->hasAllPermissions(['PE-View', 'FE-View'])) {
        //         $st=[0,1,5,8,9,10,11];
        // }
        // else if ($user->hasAllPermissions(['PE-View',])) {
        //     $st=[0,1];
        // }
        // else if ($user->hasAllPermissions(['TE-View',])) {
        //     $st=[2,3,4];
        // }
        // else if ($user->hasAllPermissions(['FE-View',])) {
        //         $st=[8,9,10,11];
        // }
        // else {
        //     // The user does not have both permissions
        //     abort(403, 'Unauthorized action.');
        // }

        //     $pevualation=Purchasevaulation::join('rfqs','rfqs.id','=','purchasevaulations.rfq')
        //         ->whereIn('purchasevaulations.status',$st)
        //         ->where('purchasevaulations.fiscalyear',$fiscalyear)
        //         ->orderBy('purchasevaulations.id','DESC')
        //         ->get(['rfqs.documentumber as rfqno','purchasevaulations.id','purchasevaulations.petype','purchasevaulations.documentumber','purchasevaulations.type','purchasevaulations.date','purchasevaulations.requiredate','purchasevaulations.status']);
                
        //     return datatables()->of($pevualation)->addIndexColumn()->toJson();
    }

    public function peinfo($id){
        $type=Purchasevaulation::where('id',$id)->first()->type;
        $rfqid=Purchasevaulation::where('id',$id)->first()->rfq;
        $created_at=Purchasevaulation::where('id',$id)->first()->created_at;
        $storeid=Purchasevaulation::where('id',$id)->first()->store_id;
        switch ($storeid) {
            case 0:
                $storename='';
                break;
            
            default:
                $storename=store::where('id',$storeid)->first()->Name;
                break;
        }
        $createdAtInAddisAbaba = Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $rfq=rfq::where('id',$rfqid)->first()->documentumber;
        $actions=actions::join('users','actions.user_id','=','users.id')
                ->where([['pageid',$id],['actions.pagename','pe']])
                ->orderBy('actions.id','DESC')
                ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
                $supplier=Purchasevaulation::join('pesuplliers','purchasevaulations.id','=','pesuplliers.purchasevaulation_id')
                    ->join('customers','pesuplliers.customers_id','=','customers.id')
                    ->orderby('pesuplliers.row_number','ASC')
                    ->where('pesuplliers.purchasevaulation_id',$id)
                    ->get(['pesuplliers.id','pesuplliers.purchasevaulation_id as peid','pesuplliers.docno','pesuplliers.customers_id as customerid',
                                    'customers.Name','customers.Code','customers.TinNumber','pesuplliers.phone','pesuplliers.recievedate','pesuplliers.status',
                                    'pesuplliers.orderdate','pesuplliers.deliverydate','pesuplliers.code as pecode'
                                ]);
        switch ($type) {
            case 'Goods':
                $pr=Purchasevaulation::with('items:id,Name','users:FullName','departments:DepartmentName')->withCount('items as totalitems')->where('id',$id)->get();
                break;
            
            default:
                $pr=Purchasevaulation::with('commuidities:id,Name','users:FullName','departments:DepartmentName')->withCount('commuidities as totalitems')->where('id',$id)->get();

                break;
        }

        return Response::json([
                                'success' =>200,
                                'createdAtInAddisAbaba'=>$createdAtInAddisAbaba,
                                'storename'=>$storename,
                                'pr'=>$pr,
                                'supplier'=>$supplier,
                                'actions'=>$actions,
                                'rfq'=>$rfq,
                            ]);
    }
public function showsupplierforpe($id){
    $supplier=Purchasevaulation::join('pesuplliers','purchasevaulations.id','=','pesuplliers.purchasevaulation_id')
                ->join('customers','pesuplliers.customers_id','=','customers.id')
                ->where('pesuplliers.purchasevaulation_id',$id)
                ->get(['pesuplliers.id','customers.Name','customers.Code','customers.TinNumber','pesuplliers.phone','pesuplliers.recievedate']);
        return datatables()->of($supplier)->addIndexColumn()->toJson();
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function supliersave(Request $request){
        switch ($request->purchaseevaultiontype) {
            case 'Goods':
                $rules2=array(
                        'row.*.ItemId' => 'required',
                        'row.*.sampleamount' => 'required|gt:0',
                        );
                break;
            default:
                $rules2=array(
                            'row.*.ItemId' => 'required',
                            'row.*.cropyear' => 'required',
                            'row.*.proccesstype' => 'required',
                            'row.*.sampleamount' => 'required',
                        );
                break;
        }
        $v1= Validator::make($request->all(), $rules2);
        if($v1->passes()){
            switch ($request->purchaseevaultiontype) {
                case 'Goods':
                    
                    break;
                
                default:
                    $evualtiondetail=new Purchasevaulationdetail();
                    $supplier=Pesuplliers::find($request->purchasesupplierid);
                foreach ($request->row as $key => $value){
                        $evualtiondetail->purchasevaulation_id=$request->purchaseevaultionid;
                        $evualtiondetail->woreda_id=(int)$value['ItemId'];
                        $evualtiondetail->cropyear=(int)$value['cropyear'];
                        $evualtiondetail->proccesstype=$value['proccesstype'];
                        $evualtiondetail->sampleamount=(int)$value['sampleamount'];
                        $evualtiondetail->remark=$value['remark'];
                        $supplier->pedetailsavedata()->save($evualtiondetail);
                    }
                    break;
            }
            return Response::json(['success' => 200]);
        }
        if($v1->fails()){
                return Response::json(['errorv2' => $v1->errors()->all()]);
            }
    }
    
    public function store(Request $request)
    {
        $type=$request->type;
        $idup=$request->purchaseid;
        $validator = Validator::make($request->all(), [
            'reference' => ['required'],
            'type' => ['required'],
            'date' => ['required','before:now'],
            'commoditytype' => ['required_if:reference,Direct'],
            'coffeesource' => ['required_if:reference,Direct'],
            'coffestatus' => ['required_if:reference,Direct'],
            'requestStation' => ['required_if:reference,Direct'],
            'priority' => ['required_if:reference,Direct'],
            'samplerequire' => ['required_if:reference,Direct'],
            'rfq' => ['required_if:reference,RFQ','nullable',Rule::unique('purchasevaulations')->where(function ($query) use($type) {
                                        return $query->where('type', $type);
                                    })->ignore($idup)],
        ]);
        $rules=array(
                    'supplierow.*.supplier' => 'required',
                    'supplierow.*.phonenumber' => 'required',
                    'supplierow.*.recievedate' => 'required',
                );
            switch ($request->type) {
                case 'Goods':
                    $rules2=array(
                        'row.*.ItemId' => 'required',
                        );
                    break;
                default:
                    $rules2=array(
                                'row.*.ItemId' => 'required',
                                'row.*.cropyear' => 'required',
                                'row.*.proccesstype' => 'required',
                            );

                    break;
            }
            $v2= Validator::make($request->all(), $rules);
            $v3= Validator::make($request->all(), $rules2);
            if ($validator->passes() && $v2->passes() && $v3->passes() && ($request->row!=null)) {
                try {
                    $itemdata=[];
                    $customerdata=[];
                    $lasteditedby='';
                    $preparedby='';
                    $settingsval = DB::table('settings')->latest()->first();
                    $inc=$settingsval->purchaseno+1;
                    $fiscalyr=$settingsval->FiscalYear;
                    $peaction=new actions();
                    $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                    $userby=Auth()->user()->FullName;
                    if($request->documentnumber==null){
                        $year=$fiscalyr-2000;
                        $addyear=$year+1;
                        $docPrefix=$settingsval->peprefix;
                        $docNum=$settingsval->peno;
                        $numberPadding=sprintf("%06d", $docNum);
                        $docNumber=$docPrefix.$numberPadding;
                        $docNumber=$docNumber.'/'.$year.'-'.$addyear;
                        $inc=$settingsval->peno+1;
                        $settingUpdate=setting::where('id',1)->update(['peno'=>$inc]);
                    } else{
                        $docNumber=$request->documentnumber;
                    }
                    if($request->purchaseid!=null){
                        $lasteditedby=$userby.' on '.$day;
                        $preparedby=Purchasevaulation::where('id',$request->purchaseid)->first()->preparedby;
                    } else{
                        $preparedby=$userby.' on '.$day;
                    }
                    if($request->rfq==null){
                        $rfq=2;
                    } else{
                        $rfq=$request->rfq;
                    }
                    $pe=Purchasevaulation::updateOrCreate(['id' =>$request->purchaseid], [
                            'petype' => $request->reference,
                            'type' => $request->type,
                            'rfq' => $rfq,
                            'date' =>$request->date,
                            'documentumber' => $docNumber,
                            'fiscalyear' => $fiscalyr,
                            'requiredate' => $request->requiredate,
                            'commudtytype' => $request->commoditytype,
                            'coffeesource' => $request->coffeesource,
                            'coffestat' => $request->coffestatus,
                            'store_id' => $request->requestStation,
                            'priority' => $request->priority,
                            'samplerequire' => $request->samplerequire,
                            'memo' => $request->memo,
                        ]);
                        if ($request->purchaseid!=null) {
                        $purchaseid=$request->purchaseid;
                        $status=Purchasevaulation::where('id',$request->purchaseid)->first()->status;
                        switch ($status) {
                            case 0:
                                $action='Edited';
                                $stat='Draft';
                                break;
                            case 1:
                                $stat='Pending';
                                $action='Edited';
                                break;
                                case 2:
                                $stat='Verify';
                                $action='Edited';
                                break;
                            default:
                                $stat='--';
                                $action='--';
                                break;
                        }
                        $peaction->action=$action;
                        $peaction->status=$stat;
                        $peaction->pagename='pe';
                        $peaction->user_id=Auth()->user()->id;
                        $peaction->time=$day;
                        $pe->actions()->save($peaction);
                    } else{
                        $purchaseid = DB::table('purchasevaulations')->latest()->first()->id;
                        $peaction->action='Created';
                        $peaction->status='Draft';
                        $peaction->pagename='pe';
                        $peaction->user_id=Auth()->user()->id;
                        $peaction->time=$day;
                        $pe->actions()->save($peaction);
                    }
                    
                    switch ($request->reference) {
                            case 'Direct':
                                switch ($request->type) {
                                    case 'Goods':
                                        foreach ($request->row as $key => $value){
                                            $itemdata[(int)$value['ItemId']] = 
                                            [ 
                                                'description'=>$value['description'],
                                                'remark'=>$value['remark'],
                                            ];
                                        }
                                        $pe->Peinitiationsitems()->sync($itemdata);
                                    break;
                                    default:
                                            foreach ($request->row as $key => $value){
                                            $itemdata[(int)$value['ItemId']] = 
                                            [ 
                                                'cropyear' =>(int)$value['cropyear'],
                                                'proccesstype'=>$value['proccesstype'],
                                                'remark'=>$value['remark'],
                                            ];
                                        }
                                        $pe->Peinitiationsworedas()->sync($itemdata);
                                    break;
                                }
                            break;
                        default:
                            switch ($request->type) {
                                case 'Goods':
                                    foreach ($request->supplierow as $pkey => $pvalue){
                                                $supplier=new Pesuplliers();
                                                $phonenumber=$pvalue['phonenumber']===null? '': $pvalue['phonenumber'];
                                                $randomno=$this->generateUniqueFourDigitNumber();
                                                $supplier->customers_id=$pvalue['supplier'];
                                                $supplier->code=$randomno;
                                                $supplier->phone=$phonenumber;
                                                $supplier->recievedate=$pvalue['recievedate'];
                                                $pe->suppliers()->save($supplier);
                                            }
                                            foreach ($request->row as $key => $value){
                                                $psid=Pesuplliers::where([['purchasevaulation_id',$purchaseid],['customers_id',(int)$value['supp']]])->first()->id;
                                                $supplier=Pesuplliers::find($psid);
                                                $evualtiondetail=new Purchasevaulationdetail();
                                                $evualtiondetail->purchasevaulation_id=$purchaseid;
                                                $evualtiondetail->regitem_id=(int)$value['ItemId'];
                                                $evualtiondetail->requesteditemid=(int)$value['requestedItemId'];
                                                $evualtiondetail->sampleamount=(int)$value['sampleamount'];
                                                $evualtiondetail->remark=$value['remark'];
                                                $evualtiondetail->description=$value['description'];
                                                $supplier->pedetailsavedata()->save($evualtiondetail);
                                        }
                                    break;
                                default:
                                        foreach ($request->supplierow as $pkey => $pvalue){
                                                $supplier=new Pesuplliers();
                                                $phonenumber=$pvalue['phonenumber']===null? '': $pvalue['phonenumber'];
                                                $randomno=$this->generateUniqueFourDigitNumber();
                                                $supplier->customers_id=$pvalue['supplier'];
                                                $supplier->code=$randomno;
                                                $supplier->phone=$phonenumber;
                                                $supplier->recievedate=$pvalue['recievedate'];
                                                $pe->suppliers()->save($supplier);
                                            }
                                            foreach ($request->row as $key => $value){
                                                $psid=Pesuplliers::where([['purchasevaulation_id',$purchaseid],['customers_id',(int)$value['supp']]])->first()->id;
                                                $supplier=Pesuplliers::find($psid);
                                                $evualtiondetail=new Purchasevaulationdetail();
                                                $evualtiondetail->purchasevaulation_id=$purchaseid;
                                                $evualtiondetail->requesteditemid=(int)$value['requestedItemId'];
                                                $evualtiondetail->woreda_id=(int)$value['ItemId'];
                                                $evualtiondetail->cropyear=(int)$value['cropyear'];
                                                $evualtiondetail->proccesstype=$value['proccesstype'];
                                                $evualtiondetail->sampleamount=(int)$value['sampleamount'];
                                                $evualtiondetail->remark=$value['remark'];
                                                $evualtiondetail->description=$value['description'];
                                                $supplier->pedetailsavedata()->save($evualtiondetail);
                                        }
                                    break;
                            }
                            break;
                    }
                    //$pe->purchasevualationsupplier()->sync($customerdata);
                    return Response::json(['success' => 200]);
                } catch (\Throwable $th) {
                    return Response::json(['dberrors' =>  $th->getMessage()]);
                }
            }
            if($validator->fails()){
                return Response::json(['errors' => $validator->errors()]);
            }
            if($v2->fails()){
                return Response::json(['errorv2' => $v2->errors()->all()]);
            }
            if($v3->fails()){
                            return Response::json(['errorv3' => $v3->errors()->all()]);
                        }
            
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference' => ['required'],
            'type' => ['required'],
            'date' => ['required','before:now'],
        ]);
        switch ($request->type) {
                case 'Goods':
                    $rules2=array(
                        'row.*.ItemId' => 'required',
                        'row.*.sampleamount' => 'required|gt:0',
                        );
                    break;
                default:
                        switch ($request->editflag) {
                            case 'Editpe':
                                    $rules2=array(
                                    'row.*.ItemId' => 'required',
                                    'row.*.cropyear' => 'required',
                                    'row.*.proccesstype' => 'required',
                                    'row.*.sampleamount' => 'required_if:samplerequire,Required',
                                );
                                break;
                            
                            default:
                                $rules2=array(
                                    'row.*.ItemId' => 'required',
                                    'row.*.cropyear' => 'required',
                                    'row.*.proccesstype' => 'required',
                                );
                                break;
                        }
                        
                    break;
            }
            $v3= Validator::make($request->all(), $rules2);
            if ($validator->passes() && $v3->passes() && ($request->row!=null)) {
                        if($request->rfq==null){
                                $rfq=2;
                            } else{
                                $rfq=$request->rfq;
                            }
                            $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                            $userby=Auth()->user()->FullName;
                            $peaction=new actions();
                            $pe=Purchasevaulation::updateOrCreate(['id' =>$request->purchaseid], [
                                'petype' => $request->reference,
                                'type' => $request->type,
                                'rfq' => $rfq,
                                'date' =>$request->date,
                                'commudtytype' => $request->commoditytype,
                                'coffeesource' => $request->coffeesource,
                                'coffestat' => $request->coffestatus,
                                'store_id' => $request->requestStation,
                                'priority' => $request->priority,
                                'samplerequire' => $request->samplerequire,
                                'memo' => $request->memo,
                            ]);
                        $status=Purchasevaulation::where('id',$request->purchaseid)->first()->status;
                        switch ($status) {
                            case 0:
                                $action ='Edited';
                                $stat='Draft';
                                break;
                            case 1:
                                $action ='Edited';
                                $stat='Pending';
                                break;
                                case 2:
                                $action ='Edited';
                                $stat='Verify';
                                break;
                            default:
                                $stat='--';
                                break;
                        }
                        $peaction->action=$action;
                        $peaction->status=$stat;
                        $peaction->pagename='pe';
                        $peaction->user_id=Auth()->user()->id;
                        $peaction->time=$day;
                        $pe->actions()->save($peaction);
                        switch ($request->editflag) {
                        case 'initation':
                                switch ($request->type) {
                                    case 'Goods':
                                            foreach ($request->row as $key => $value){
                                                $itemdata[(int)$value['ItemId']] = 
                                                [ 
                                                    'sampleamount'=>(float)$value['sampleamount'],
                                                    'description'=>$value['description'],
                                                    'remark'=>$value['remark'],
                                                ];
                                            }
                                        $pe->Peinitiationsitems()->sync($itemdata);
                                        break;
                                    
                                    default:
                                        foreach ($request->row as $key => $value){
                                        $itemdata[(int)$value['ItemId']] = 
                                        [ 
                                            'cropyear' =>(int)$value['cropyear'],
                                            
                                            'proccesstype'=>$value['proccesstype'],
                                            
                                            'remark'=>$value['remark'],
                                        ];
                                    }
                                    $pe->Peinitiationsworedas()->sync($itemdata);
                                        break;
                                }
                            break;
                            
                        default:
                                switch ($request->type) {
                                    case 'Goods':
                                        foreach ($request->row as $key => $value){
                                                    $exist=Pesuplliers::where([['purchasevaulation_id',$request->purchaseid],['customers_id',(int)$value['supp']]])->exists();
                                                    switch ($exist) {
                                                        case true:
                                                            $psid=Pesuplliers::where([['purchasevaulation_id',$request->purchaseid],['customers_id',(int)$value['supp']]])->first()->id;
                                                            $supplier=Pesuplliers::find($psid);
                                                            $supplier->pedetailsavedata()->delete();
                                                            break;
                                                        
                                                        default:
                                                            
                                                            break;
                                                    }
                                                    
                                            }
                                            $sp=Pesuplliers::where('purchasevaulation_id',$request->purchaseid)->delete();
                                            foreach ($request->supplierow as $pkey => $pvalue){
                                                    $supplier=new Pesuplliers();
                                                    $phonenumber=$pvalue['phonenumber']===null? '': $pvalue['phonenumber'];
                                                    $randomno=$this->generateUniqueFourDigitNumber();
                                                    $supplier->customers_id=$pvalue['supplier'];
                                                    $supplier->code=$randomno;
                                                    $supplier->phone=$phonenumber;
                                                    $supplier->recievedate=$pvalue['recievedate'];
                                                    $supplier->isevualted=1;
                                                    $pe->suppliers()->save($supplier);

                                                }
                                                foreach ($request->row as $key => $value){
                                                    $psid=Pesuplliers::where([['purchasevaulation_id',$request->purchaseid],['customers_id',(int)$value['supp']]])->first()->id;
                                                    $supplier=Pesuplliers::find($psid);
                                                    $evualtiondetail=new Purchasevaulationdetail();
                                                    $evualtiondetail->purchasevaulation_id=$request->purchaseid;
                                                    $evualtiondetail->regitem_id=(int)$value['ItemId'];
                                                    $evualtiondetail->requesteditemid=(int)$value['requestedItemId'];
                                                    $evualtiondetail->sampleamount=(int)$value['sampleamount'];
                                                    $evualtiondetail->remark=$value['remark'];
                                                    $evualtiondetail->description=$value['description'];
                                                    $supplier->pedetailsavedata()->save($evualtiondetail);
                                            }
                                        break;
                                    default:
                                            foreach ($request->row as $key => $value){
                                                    $exist=Pesuplliers::where([['purchasevaulation_id',$request->purchaseid],['customers_id',(int)$value['supp']]])->exists();
                                                    switch ($exist) {
                                                        case true:
                                                            $psid=Pesuplliers::where([['purchasevaulation_id',$request->purchaseid],['customers_id',(int)$value['supp']]])->first()->id;
                                                            $supplier=Pesuplliers::find($psid);
                                                            $supplier->pedetailsavedata()->delete();
                                                            break;
                                                        
                                                        default:
                                                            
                                                            break;
                                                    }
                                            }
                                            $sp=Pesuplliers::where('purchasevaulation_id',$request->purchaseid)->delete();
                                            foreach ($request->supplierow as $pkey => $pvalue){
                                                    $supplier=new Pesuplliers();
                                                    $phonenumber=$pvalue['phonenumber']===null? '': $pvalue['phonenumber'];
                                                    $randomno=$this->generateUniqueFourDigitNumber();
                                                    $supplier->customers_id=$pvalue['supplier'];
                                                    $supplier->code=$randomno;
                                                    $supplier->phone=$phonenumber;
                                                    $supplier->recievedate=$pvalue['recievedate'];
                                                    $supplier->isevualted=1;
                                                    $pe->suppliers()->save($supplier);
                                                    
                                                    Purchasevaulation::where('id',$request->purchaseid)->update(['Code'=>$randomno]);
                                                }
                                                foreach ($request->row as $key => $value){
                                                    $psid=Pesuplliers::where([['purchasevaulation_id',$request->purchaseid],['customers_id',(int)$value['supp']]])->first()->id;
                                                    $supplier=Pesuplliers::find($psid);
                                                    $evualtiondetail=new Purchasevaulationdetail();
                                                    $evualtiondetail->purchasevaulation_id=$request->purchaseid;
                                                    $evualtiondetail->woreda_id=(int)$value['ItemId'];
                                                    $evualtiondetail->requesteditemid=(int)$value['requestedItemId'];
                                                    $evualtiondetail->cropyear=(int)$value['cropyear'];
                                                    $evualtiondetail->proccesstype=$value['proccesstype'];
                                                    $evualtiondetail->sampleamount=(int)$value['sampleamount'];
                                                    $evualtiondetail->remark=$value['remark'];
                                                    $supplier->pedetailsavedata()->save($evualtiondetail);
                                            }
                                        break;
                                }
                            break;
                    }
                    
                    return Response::json(['success' => 200]);
            }
            if($validator->fails()){
                return Response::json(['errors' => $validator->errors()]);
            }
            if($v3->fails()){
                            return Response::json(['errorv3' => $v3->errors()->all()]);
                        }
    }
    public function technicalevsave(Request $request){
        switch ($request->evtype) {
                case 'Goods':
                    $rules2=array(
                        'evrow.*.ItemId' => 'required',
                        'evrow.*.status' => 'required',
                        );
                    break;
                default:
                    $rules2=array(
                            'evrow.*.ItemId' => 'required',
                            'evrow.*.cropyear' => 'required',
                            'evrow.*.proccesstype' => 'required',
                        );
                    break;
            }
            $v2= Validator::make($request->all(), $rules2);
                if($v2->passes()){
                    $peaction=new actions();
                    $evualtiondetail= Purchasevaulation::find($request->evpurchaseid);
                    switch ($request->evtype) {
                        case 'Goods':
                            foreach ($request->evrow as $key => $value){
                        $psid=Pesuplliers::where([['purchasevaulation_id',$request->evpurchaseid],['customers_id',(int)$value['supp']]])->first()->id;
                        $evualtiondetail->evaulations()->where('pesupllier_id',$psid)
                                        ->update(['evrequesteditemid'=>(int)$value['ItemId'],'evstatus'=>$value['status'],'remark'=>$value['remark'],'description'=>$value['description']]);
                            }
                            break;
                        
                        default:
                        foreach ($request->evrow as $key => $value){
                        $psid=Pesuplliers::where([['purchasevaulation_id',$request->evpurchaseid],['customers_id',(int)$value['evsupp']]])->first()->id;
                                $status=$value['status']===null? '': $value['status'];
                                $cupvalue=$value['cupvalue']===null? '': $value['cupvalue'];
                                $score=$value['score']===null? '': $value['score'];
                                $screensieve=$value['screensieve']===null? '': $value['screensieve'];
                                $moisture=$value['moisture']===null? '': $value['moisture'];
                                $qualitygrade=$value['coffegrade']===null? '': $value['coffegrade'];
                                $rowvalue=$value['rowvalue']===null? '': $value['rowvalue'];
                                $evualtiondetail->evaulations()->where('id',(int)$value['pevid'])
                                ->update(['evrequesteditemid'=>(int)$value['ItemId'],'evcropyear'=>(int)$value['cropyear'],
                                            'evproccesstype'=>$value['proccesstype'],'evmoisture'=>$moisture,'evcupvalue'=>$cupvalue,
                                            'rowvalue'=>$rowvalue,'evscore'=>$score,'screensieve'=>$screensieve,'qualitygrade'=>$qualitygrade,
                                            'evstatus'=>$status,'tecremark'=>$value['remark']
                                            ]);
                            }
                            break;
                    }
                        $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                        $peaction->action='TE Inserted';
                        $peaction->status='Edited';
                        $peaction->pagename='pe';
                        $peaction->user_id=Auth()->user()->id;
                        $peaction->time=$day;
                        $evualtiondetail->actions()->save($peaction);
                }
                if($v2->fails()){
                return Response::json(['errorv2' => $v2->errors()->all()]);
            }
            return Response::json(['success' => 200]);
    }
    public function financialsave(Request $request){
        switch ($request->financailevtype) {
                case 'Goods':
                    $rules2=array(
                        'evrow.*.ItemId' => 'required',
                        'evrow.*.evstatus' => 'required',
                        );
                    break;
                default:
                    $rules2=array(
                            'fevrow.*.qualityapproval' => 'required',
                        );
                    break;
            }
                $v2= Validator::make($request->all(), $rules2);
                if($v2->passes()){
                    $peaction=new actions();
                    $evualtiondetail= Purchasevaulation::find($request->financailevpurchaseid);
                            foreach ($request->fevrow as $key => $value){
                                $psid=Pesuplliers::where([['purchasevaulation_id',$request->financailevpurchaseid],['customers_id',(int)$value['evsupp']]])->first()->id;
                                    $bagamount = $value['bagamount'] ?? null;
                                    $bagamount = ($bagamount === null || $bagamount === '') ? 'EMPTY' : $bagamount;
                                    $customerprice=$value['customerprice']===null? '': $value['customerprice'];
                                    $proposedprice=$value['proposedprice']===null? '': $value['proposedprice'];
                                    $finalprice=$value['finalprice']===null? '': $value['finalprice'];
                                    $remark=$value['remark']===null? '': $value['remark'];
                                    $isagreed=$value['isagreed']===null? 0: $value['isagreed'];
                                    $pevid=(int)$value['pevid'];
                                    switch ($bagamount) {
                                        case 'EMPTY':
                                            $bagamount=1;
                                            break;
                                        
                                        default:
                                            $bagamount= $bagamount;
                                            break;
                                    }
                                    $evualtiondetail->evaulations()->where('id',$pevid)
                                            ->update(['bagamount'=>$bagamount,'customerprice'=>$customerprice,'proposedprice'=>$proposedprice,
                                            'finalprice'=>$finalprice,'isagreed'=>$isagreed,'fevremark'=>$remark]);
                        }
                        $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                        $peaction->action='FE Inserted';
                        $peaction->status='Edited';
                        $peaction->pagename='pe';
                        $peaction->user_id=Auth()->user()->id;
                        $peaction->time=$day;
                        $evualtiondetail->actions()->save($peaction);
                        return Response::json(['success' => 200]);
                }
                if($v2->fails()){
                return Response::json(['errorv2' => $v2->errors()->all()]);
            }
        
    }
    public function generateUniqueFourDigitNumber(){
        $number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Generate random 4-digit number
        $existingNumber = Pesuplliers::where('code', $number)->exists(); // Check if the number already exists in your database
        
        if ($existingNumber) {
            // If the number already exists, recursively call the function again to generate a new one
            return generateUniqueFourDigitNumber();
        }

        // If the number is unique, return it
        return $number;
}
    public function getrfq($type){
        $ste=[];
        $selectrfq=Purchasevaulation::where('rfq','!=',2)->get(['rfq']);
            foreach($selectrfq as $st){
            $ste[]=$st->rfq;
        }
        $rfq=rfq::join('purequests','purequests.id','rfqs.purequest_id')
        ->whereNotIn('rfqs.id',$ste)
        ->where([['purequests.type',$type],['rfqs.status',8]])->get(['rfqs.id','rfqs.documentumber as rfq','purequests.docnumber as prequest','purequests.type']);

        return Response::json(['rfq' => $rfq,
                                'selectrfq' => $selectrfq,
                                'ste' => $ste
    
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchasevaulation  $purchasevaulation
     * @return \Illuminate\Http\Response
     */
    public function show(Purchasevaulation $purchasevaulation)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchasevaulation  $purchasevaulation
     * @return \Illuminate\Http\Response
     */
    public function addrequesteditems($rfq,$reference,$type){
            $purchaseid=rfq::where('id',$rfq)->first()->purequest_id;
                switch ($type) {
                    case 'Goods':
                            $productlist=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
                                ->where('purequest_id',$purchaseid)->get(['regitems.id',DB::raw('CONCAT(regitems.Code," ",regitems.Name) as col1'),'regitems.SKUNumber as col2','purdetails.qty as col3']);
                        break;
                    
                    default:
                        $productlist=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
                                    ->join('zones','woredas.zone_id','=','zones.id')
                                    ->join('regions','zones.Rgn_Id','=','regions.id')
                                    ->join('purequests','purdetails.purequest_id','purequests.id')
                                    ->leftJoin('lookups as croplookups','purdetails.cropyear','croplookups.CropYearValue')
                                    ->where('purequest_id',$purchaseid)->get([DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as col1'),'purdetails.proccesstype as col3','croplookups.CropYear as col2']);
                        break;
                }
        return datatables()->of($productlist)->addIndexColumn()->toJson();
    }


    public function peinfocomoditylist($id){
        $status=Purchasevaulation::where('id',$id)->first()->status;

        switch ($status) {
            case 0:
                $comiditylist=$this->listofcommodity($id);
            break;
            case 1:
                    $comiditylist=$this->listofcommodity($id);
            break;
            case 8:
                $comiditylist=$this->peinfocomoditylistwithoutranked($id);
                break;
            case 9:
                $comiditylist=$this->peinfocomoditylistwithranked($id);
                break;
            case 10:
                $comiditylist=$this->peinfocomoditylistwithranked($id);
            break;
            default:
                $comiditylist=$this->peinfocomoditylistwithoutranked($id);
                break;
        }
        
        return datatables()->of($comiditylist)->addIndexColumn()->toJson();
    }
    public function getpebysupplier($headerid,$id){
            $comiditylist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
            ->join('zones','woredas.zone_id','zones.id')
            ->join('regions','zones.Rgn_Id','regions.id')
            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
            ->join('customers','pesuplliers.customers_id','customers.id')
            ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
            ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
            ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
            ->leftJoin('lookups as croplookups','purchasevaulationdetails.cropyear','croplookups.CropYearValue')
            ->orderBy('purchasevaulationdetails.pesupllier_id','ASC')
            ->where([['purchasevaulationdetails.purchasevaulation_id',$headerid],['purchasevaulationdetails.pesupllier_id',$id]])
            ->get([DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                    DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) AS supplyorigin'),
                    DB::raw('CONCAT(pesuplliers.code," ", customers.Name," ",pesuplliers.recievedate) as customername'),
                    'regions.Rgn_Name','zones.Zone_Name','reqworeda.Woreda_Name AS requestworedname','woredas.Woreda_Name as woredname',
                    'purchasevaulationdetails.proccesstype','purchasevaulationdetails.sampleamount',
                    'purchasevaulationdetails.evmoisture','purchasevaulationdetails.screensieve','purchasevaulationdetails.evcupvalue',
                    'purchasevaulationdetails.rowvalue','purchasevaulationdetails.bagamount','purchasevaulationdetails.evscore','purchasevaulationdetails.remark',
                    'purchasevaulationdetails.tecremark','purchasevaulationdetails.fevremark','purchasevaulationdetails.description','purchasevaulationdetails.evstatus',
                    'purchasevaulationdetails.evstatus as qualityapproval','purchasevaulationdetails.fevstatus','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.grade',
                    'purchasevaulationdetails.qualitygrade','purchasevaulationdetails.customerprice','purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice',
                    'purchasevaulationdetails.rank','croplookups.CropYear as cropyear'
                    ]);
                    
                    return datatables()->of($comiditylist)->addIndexColumn()->toJson();
    }
    public function peattachemnt($headerid,$id){

            $settingsval = DB::table('settings')->latest()->first();
            
        $comiditylist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
            ->join('zones','woredas.zone_id','zones.id')
            ->join('regions','zones.Rgn_Id','regions.id')
            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
            ->join('customers','pesuplliers.customers_id','customers.id')
            ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
            ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
            ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
            ->orderBy('purchasevaulationdetails.pesupllier_id','ASC')
            ->where([['purchasevaulationdetails.purchasevaulation_id',$headerid],['purchasevaulationdetails.pesupllier_id',$id]])
            ->get([DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                    DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) AS supplyorigin'),
                    DB::raw('CONCAT(pesuplliers.code," ", customers.Name," ",pesuplliers.recievedate) as customername'),
                    'regions.Rgn_Name','zones.Zone_Name','reqworeda.Woreda_Name AS requestworedname','woredas.Woreda_Name as woredname',
                    'purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype','purchasevaulationdetails.sampleamount',
                    'purchasevaulationdetails.evmoisture','purchasevaulationdetails.screensieve','purchasevaulationdetails.evcupvalue',
                    'purchasevaulationdetails.rowvalue','purchasevaulationdetails.evscore','purchasevaulationdetails.remark',
                    'purchasevaulationdetails.description','purchasevaulationdetails.evstatus','purchasevaulationdetails.evstatus as qualityapproval',
                    'purchasevaulationdetails.fevstatus','purchasevaulationdetails.bagamount','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.grade','purchasevaulationdetails.qualitygrade',
                    'purchasevaulationdetails.customerprice','purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice','purchasevaulationdetails.rank'
                    ]);
                    
                    $count=0;
                    $compInfo=companyinfo::find(1);
                    $watermark='Purchase Evaluation';
                    $data=[
                        'comiditylist'=>$comiditylist,
                        'totalprice'=>$totalprice,
                        'count'=>$count,
                        'due_date'=>$due_date,
                        'compInfo'=>$compInfo,
                        'storename'=>$storename,
                        'percent'=>$percent,
                        'preparedby'=>$preparedby,
                        'verifyby'=>$verifyby,
                        'aothorizeby'=>$aothorizeby,
                        'reviewby'=>$reviewby,
                        'approveby'=>$approveby,
                        'amountinword'=>$amountinword,
                        'totalkg'=>$totalkg,
                        'totalton'=>$totalton,
                        'totalfersula'=>$totalfersula,
                
            ];
                $mpdf=new \Mpdf\Mpdf([
                    'margin_left' => 10,
                    'margin_right' => 10,
                    'margin_top' => 32,
                    'margin_bottom' => 25,
                    'margin_header' => 10,
                    'margin_footer' => 1
                ]);
            $date = Carbon::now('Africa/Addis_Ababa')->format('Y-m-d @ H:i:s');
            $html=\View::make('pr.evaluationattachement')->with($data);
            $html=$html->render();
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("Pr Attachment");
            $mpdf->SetAuthor("Designed By RAK Computer Technology");
            $mpdf->SetWatermarkText($watermark);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Prattachment.pdf','I');



    }
    public function listofcommodity($id){
        $comiditylist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
            ->join('zones','woredas.zone_id','zones.id')
            ->join('regions','zones.Rgn_Id','regions.id')
            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
            ->join('customers','pesuplliers.customers_id','customers.id')
            ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
            ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
            ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
            ->orderBy('purchasevaulationdetails.pesupllier_id','ASC')
            ->where('purchasevaulationdetails.purchasevaulation_id',$id)
            ->get([DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                    DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) AS supplyorigin'),
                    DB::raw('CONCAT(pesuplliers.code," ", customers.Name," ",pesuplliers.recievedate) as customername'),
                    'regions.Rgn_Name','zones.Zone_Name','reqworeda.Woreda_Name AS requestworedname','woredas.Woreda_Name as woredname',
                    'purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype','purchasevaulationdetails.sampleamount',
                    'purchasevaulationdetails.evmoisture','purchasevaulationdetails.screensieve','purchasevaulationdetails.evcupvalue',
                    'purchasevaulationdetails.evscore','purchasevaulationdetails.remark','purchasevaulationdetails.description',
                    'purchasevaulationdetails.evstatus','purchasevaulationdetails.evstatus as qualityapproval','purchasevaulationdetails.fevstatus','purchasevaulationdetails.bagamount',
                    'purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade',
                    'purchasevaulationdetails.customerprice','purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice','purchasevaulationdetails.finalprice as rank'
                    ]);
            return $comiditylist;
    }
    public function peinfocomoditylistwithoutranked($id){
            $status=Purchasevaulation::where('id',$id)->first()->status;
            switch ($status) {
                case 8:
                    $condition=['Approved'];
                    break;
                
                default:
                    $condition=[' ','Approved','Not approved'];
                    break;
            }
            $comiditylist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
            ->join('zones','woredas.zone_id','zones.id')
            ->join('regions','zones.Rgn_Id','regions.id')
            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
            ->join('customers','pesuplliers.customers_id','customers.id')
            ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
            ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
            ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
            ->join('woredas as evalworeda','purchasevaulationdetails.evrequesteditemid','evalworeda.id')
            ->join('zones as evalzones','evalworeda.zone_id','evalzones.id')
            ->join('regions as evalregions','evalzones.Rgn_Id','evalregions.id')

            ->orderBy('purchasevaulationdetails.pesupllier_id','ASC')
            ->where('purchasevaulationdetails.purchasevaulation_id',$id)
            ->whereIn('purchasevaulationdetails.evstatus',$condition)
            ->get([ DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                    DB::raw('CONCAT(evalregions.Rgn_Name," ",evalzones.Zone_Name," ",evalworeda.Woreda_Name) AS supplyorigin'),
                    'pesuplliers.code as customername',
                    'regions.Rgn_Name','zones.Zone_Name','reqworeda.Woreda_Name AS requestworedname','woredas.Woreda_Name as woredname',
                    'purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype','purchasevaulationdetails.sampleamount',
                    'purchasevaulationdetails.evmoisture','purchasevaulationdetails.screensieve','purchasevaulationdetails.evcupvalue',
                    'purchasevaulationdetails.evscore','purchasevaulationdetails.remark','purchasevaulationdetails.description',
                    'purchasevaulationdetails.evstatus','purchasevaulationdetails.evstatus as qualityapproval','purchasevaulationdetails.fevstatus','purchasevaulationdetails.bagamount',
                    'purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade',
                    'purchasevaulationdetails.customerprice','purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice','purchasevaulationdetails.finalprice as rank'
                    ]);
            return $comiditylist;
    }
    public function peinfocomoditylistwithranked($id){
        $comiditylist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
            ->join('zones','woredas.zone_id','zones.id')
            ->join('regions','zones.Rgn_Id','regions.id')
            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
            ->join('customers','pesuplliers.customers_id','customers.id')
            ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
            ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
            ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
            ->join('woredas as evalworeda','purchasevaulationdetails.evrequesteditemid','evalworeda.id')
            ->join('zones as evalzones','evalworeda.zone_id','evalzones.id')
            ->join('regions as evalregions','evalzones.Rgn_Id','evalregions.id')
            ->orderby('purchasevaulationdetails.rank','ASC')
            ->where([['purchasevaulationdetails.purchasevaulation_id',$id],['purchasevaulationdetails.evstatus','Approved']])
            ->get([ DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                    DB::raw('CONCAT(evalregions.Rgn_Name," ",evalzones.Zone_Name," ",evalworeda.Woreda_Name) AS supplyorigin'),
                    DB::raw('CONCAT(pesuplliers.code," ", customers.Name," ",pesuplliers.recievedate) as customername'),
                    'regions.Rgn_Name','zones.Zone_Name','reqworeda.Woreda_Name AS requestworedname','woredas.Woreda_Name as woredname',
                    'purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype','purchasevaulationdetails.sampleamount',
                    'purchasevaulationdetails.evmoisture','purchasevaulationdetails.screensieve','purchasevaulationdetails.evcupvalue',
                    'purchasevaulationdetails.evscore','purchasevaulationdetails.remark','purchasevaulationdetails.description',
                    'purchasevaulationdetails.evstatus','purchasevaulationdetails.evstatus as qualityapproval','purchasevaulationdetails.fevstatus','purchasevaulationdetails.bagamount',
                    'purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade',
                    'purchasevaulationdetails.customerprice','purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice',
                    'purchasevaulationdetails.rank','purchasevaulationdetails.dense_rank','purchasevaulationdetails.dense_rank',
                    ]);
            return $comiditylist;
    }
    public function peinfoitemlist($id){
        $itemlist=Purchasevaulationdetail::join('regitems','regitems.id','=','purchasevaulationdetails.regitem_id')
                ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                ->join('customers','pesuplliers.customers_id','customers.id')
                ->orderby('customers.Name','DESC')
                ->where('purchasevaulationdetails.purchasevaulation_id',$id)->get(['regitems.Code','regitems.Name','regitems.SKUNumber','purchasevaulationdetails.sampleamount','purchasevaulationdetails.remark','purchasevaulationdetails.description',DB::raw('CONCAT(pesuplliers.code," ", customers.Name) AS customername')]);
        return datatables()->of($itemlist)->addIndexColumn()->toJson();
    }
    public function getinitiationdata($id,$type){
            switch ($type) {
                    case 'Goods':
                        $productlist=Peinitiations::join('regitems','regitems.id','=','peinitiations.regitem_id')
                                ->where('purchasevaulation_id',$id)->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber','peinitiations.sampleamount','peinitiations.description','peinitiations.remark']);
                        break;
                    default:
                        $productlist=Peinitiations::join('woredas','woredas.id','peinitiations.woreda_id')
                                                    ->join('zones','woredas.zone_id','zones.id')
                                                    ->join('regions','zones.Rgn_Id','regions.id')
                                                    ->join('purchasevaulations','peinitiations.purchasevaulation_id','purchasevaulations.id')
                                                    ->where('purchasevaulation_id',$id)->get(['woredas.id',DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as supplyorigin'),'peinitiations.sampleamount','peinitiations.proccesstype','peinitiations.cropyear','peinitiations.description','peinitiations.remark']);
                        break;
                }
        return Response::json([
                'success' =>200,
                'productlist'=>$productlist
        ]);
    }
    public function getinitationcommodity($id){
        
            $productlist=Peinitiations::join('woredas','woredas.id','peinitiations.woreda_id')
                        ->join('zones','woredas.zone_id','zones.id')
                        ->join('regions','zones.Rgn_Id','regions.id')
                        ->join('purchasevaulations','peinitiations.purchasevaulation_id','purchasevaulations.id')
                        ->where('purchasevaulation_id',$id)->get(['woredas.id',DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as supplyorigin'),'peinitiations.sampleamount','peinitiations.proccesstype','peinitiations.cropyear','peinitiations.description','peinitiations.remark']);
        return datatables()->of($productlist)->addIndexColumn()->toJson();
                    }
    public function getprequestdata($id){
        $purchaseid=rfq::where('id',$id)->first()->purequest_id;
        $purchase=purchaseRequest::where('id',$purchaseid)->get();
        $type=purchaseRequest::where('id',$purchaseid)->first()->type;
        $supplierlist=DB::table('customer_rfq')->join('rfqs','customer_rfq.rfq_id','rfqs.id')
                                ->join('customers','customer_rfq.customer_id','customers.id')
                                ->where([['customer_rfq.rfq_id',$id],['customer_rfq.status','1']])
                                ->get(['customers.id','customers.Name','customers.Code','customers.TinNumber','customers.PhoneNumber']);
        $id=$purchaseid;
        switch ($type) {
            case 'Goods':
                $pr=purchaseRequest::withCount('items as totalitems')->where('id',$id)->get();
                $productlist=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
                    ->where('purequest_id',$id)->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber','purdetails.qty','purdetails.price','purdetails.remark']);
                $productinitation=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
                                ->where('purequest_id',$purchaseid)->get(['regitems.id',DB::raw('CONCAT(regitems.Code," ",regitems.Name," ",SKUNumber) as item'),'regitems.id']);
                break;
            default:
                    $pr=purchaseRequest::withCount('commuidities as totalitems')->where('id',$id)->get();
                    $productlist=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
                                                ->join('zones','woredas.zone_id','=','zones.id')
                                                ->join('regions','zones.Rgn_Id','=','regions.id')
                                                ->where('purdetails.purequest_id',$id)->get([DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS requestedorigin'),
                                                        'woredas.id','woredas.Woreda_Name as Name','purdetails.source','purdetails.certificate',
                                                        'purdetails.status','purdetails.grade','purdetails.proccesstype','purdetails.oum',
                                                        'purdetails.netwieght','purdetails.packageunit','purdetails.nofpackages','purdetails.packagingcontent',
                                                        'purdetails.grosswieght','purdetails.feresula', 'purdetails.totalprice','purdetails.price','purdetails.remark'
                                                    ]);
            $productinitation=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
                                            ->join('zones','woredas.zone_id','=','zones.id')
                                            ->join('regions','zones.Rgn_Id','=','regions.id')

                                            ->join('purequests','purdetails.purequest_id','purequests.id')
                                            ->where('purequest_id',$purchaseid)->get([DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as RZW'),'woredas.id']);
                                            
            break;
        }
        
        return Response::json([
                                'success' => 200,
                                'purchaseid' =>$purchaseid,
                                'purchase' =>$pr,
                                'productlist'=>$productlist,
                                'supplierlist'=>$supplierlist,
                                'productinitation'=>$productinitation,
                            ]);
    }
    public function peinitationedit($id){
        $pr=Purchasevaulation::where('id',$id)->get();
        $type=Purchasevaulation::where('id',$id)->first()->type;
        $pedatail=Purchasevaulationdetail::where('purchasevaulation_id',$id)->exists();
        switch ($type) {
                    case 'Goods':
                        $productlist=Peinitiations::join('regitems','regitems.id','=','peinitiations.regitem_id')
                                ->where('purchasevaulation_id',$id)->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber','peinitiations.sampleamount','peinitiations.description','peinitiations.remark']);
                        break;
                    default:
                        $productlist=Peinitiations::join('woredas','woredas.id','peinitiations.woreda_id')
                                                    ->join('zones','woredas.zone_id','zones.id')
                                                    ->join('regions','zones.Rgn_Id','regions.id')
                                                    ->join('purchasevaulations','peinitiations.purchasevaulation_id','purchasevaulations.id')
                                                    ->where('purchasevaulation_id',$id)->get(['woredas.id',DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as supplyorigin'),'peinitiations.sampleamount','peinitiations.proccesstype','peinitiations.cropyear','peinitiations.description','peinitiations.remark']);
                        break;
                }
        return Response::json([
                'success' =>200,
                'pr'=>$pr,
                'productlist'=>$productlist,
                'pedatail'=>$pedatail
        ]);
    }
    public function tecevualatedit($id){
        $type=Purchasevaulation::where('id',$id)->first()->type;
        $rfq=Purchasevaulation::where('id',$id)->first()->rfq;
        $pr=Purchasevaulation::where('id',$id)->get();
        $purchaseid=rfq::where('id',$rfq)->first()->purequest_id;
        switch ($type) {
            case 'Goods':
                $productlist=Purchasevaulationdetail::join('regitems','regitems.id','=','purchasevaulationdetails.regitem_id')
                            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                            ->join('customers','pesuplliers.customers_id','customers.id')
                            ->where('purchasevaulationdetails.purchasevaulation_id',$id)
                            ->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber','pesuplliers.id as peid','pesuplliers.customers_id','purchasevaulationdetails.sampleamount','purchasevaulationdetails.remark','purchasevaulationdetails.description']);
                            $requesteproductlist=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
                                    ->where('purequest_id',$id)->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber','purdetails.qty','purdetails.price','purdetails.remark']);
                break;
            
            default:
                $productlist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
                            ->join('zones','woredas.zone_id','=','zones.id')
                            ->join('regions','zones.Rgn_Id','=','regions.id')
                            ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
                            ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
                            ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
                            ->join('woredas as evalworeda','purchasevaulationdetails.evrequesteditemid','evalworeda.id')
                            ->join('zones as evalzones','evalworeda.zone_id','evalzones.id')
                            ->join('regions as evalregions','evalzones.Rgn_Id','evalregions.id')
                            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                            ->join('customers','pesuplliers.customers_id','customers.id')
                            
                            ->where([['purchasevaulationdetails.purchasevaulation_id',$id],['purchasevaulationdetails.evstatus','Approved']])->get([
                            'purchasevaulationdetails.id as pevid',
                            DB::raw('CONCAT(evalregions.Rgn_Name," ",evalzones.Zone_Name," ",evalworeda.Woreda_Name) AS RZW'),
                            'evalworeda.id as woredaid',
                            DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                            'reqworeda.id as requestedid','purchasevaulationdetails.evcropyear as evaulationcropyear','purchasevaulationdetails.evproccesstype as evaulationproccesstype',
                            'pesuplliers.customers_id','purchasevaulationdetails.sampleamount','purchasevaulationdetails.evmoisture',
                            'purchasevaulationdetails.evcupvalue','purchasevaulationdetails.screensieve','purchasevaulationdetails.bagamount',
                            'purchasevaulationdetails.evscore','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.customerprice',
                            'purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice','purchasevaulationdetails.evstatus',
                            'purchasevaulationdetails.fevstatus','purchasevaulationdetails.price','purchasevaulationdetails.fevremark',
                            'purchasevaulationdetails.isagreed','purchasevaulationdetails.description'
                            ]);

                            $requesteproductlist=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
                                ->join('zones','woredas.zone_id','=','zones.id')
                                ->join('regions','zones.Rgn_Id','=','regions.id')
                                ->where('purdetails.purequest_id',$purchaseid)->get(['woredas.id','regions.Rgn_Name','zones.Zone_Name','woredas.Woreda_Name as Name']);
                break;
        }
        $supplier=Purchasevaulation::join('pesuplliers','purchasevaulations.id','=','pesuplliers.purchasevaulation_id')
                ->join('customers','pesuplliers.customers_id','=','customers.id')
                ->join('purchasevaulationdetails','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                ->where([['pesuplliers.purchasevaulation_id',$id],['purchasevaulationdetails.evstatus','Approved']])
                ->distinct()
                ->get(['customers.id as customerid','pesuplliers.id as psid','customers.Name','customers.Code','customers.TinNumber','pesuplliers.Code as suppliercode','pesuplliers.phone','pesuplliers.recievedate']);
        return Response::json([
                                'success' =>200,
                                'pr'=>$pr,
                                'rfq'=>$rfq,
                                'supplier'=>$supplier,
                                'productlist'=>$productlist,
                                'requesteproductlist'=>$requesteproductlist,
                            ]);
    }
    public function evualatedit($id){
        $type=Purchasevaulation::where('id',$id)->first()->type;
        $reference=Purchasevaulation::where('id',$id)->first()->type;
        $rfq=Purchasevaulation::where('id',$id)->first()->rfq;
        $pr=Purchasevaulation::where('id',$id)->get();
        $purchaseid=rfq::where('id',$rfq)->first()->purequest_id;
        switch ($type) {
            case 'Goods':
                $productlist=Purchasevaulationdetail::join('regitems','purchasevaulationdetails.regitem_id','regitems.id')
                            ->join('regitems as requsteditems','purchasevaulationdetails.requesteditemid','requsteditems.id')  
                            ->join('regitems as evaluatedrequsteditems','purchasevaulationdetails.evrequesteditemid','evaluatedrequsteditems.id')  
                            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                            ->join('customers','pesuplliers.customers_id','customers.id')
                            ->where('purchasevaulationdetails.purchasevaulation_id',$id)
                            ->get(['requsteditems.id as requestid',
                                    DB::raw('CONCAT(requsteditems.Code," ",requsteditems.Name," ",requsteditems.SKUNumber) AS requestitem'),
                                    DB::raw('IF(purchasevaulationdetails.evrequesteditemid=1,regitems.id,evaluatedrequsteditems.id) as supllierid '),
                                    DB::raw('IF(purchasevaulationdetails.evrequesteditemid=1,CONCAT(regitems.Code," ",regitems.Name," ",regitems.SKUNumber),CONCAT(evaluatedrequsteditems.Code," ",evaluatedrequsteditems.Name," ",evaluatedrequsteditems.SKUNumber)) AS supplyitem'),
                                    'regitems.Code','regitems.Name','regitems.SKUNumber','pesuplliers.customers_id','purchasevaulationdetails.evstatus',
                                    'purchasevaulationdetails.sampleamount','purchasevaulationdetails.tecremark','purchasevaulationdetails.description'
                                ]);
                            
                            $requesteproductlist=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
                                    ->where('purequest_id',$purchaseid)->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber','purdetails.qty','purdetails.price','purdetails.remark']);
                break;
                                
            default:
                $productlist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
                            ->join('zones','woredas.zone_id','zones.id')
                            ->join('regions','zones.Rgn_Id','regions.id')
                            ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
                            ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
                            ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
                            ->join('woredas as evalworeda','purchasevaulationdetails.evrequesteditemid','evalworeda.id')
                            ->join('zones as evalzones','evalworeda.zone_id','evalzones.id')
                            ->join('regions as evalregions','evalzones.Rgn_Id','evalregions.id')
                            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                            ->join('customers','pesuplliers.customers_id','customers.id')
                            ->orderBy('purchasevaulationdetails.pesupllier_id','ASC')
                            ->where('purchasevaulationdetails.purchasevaulation_id',$id)->get(['purchasevaulationdetails.id',
                            DB::raw('CONCAT(evalregions.Rgn_Name," ",evalzones.Zone_Name," ",evalworeda.Woreda_Name) AS RZW'),
                            'evalworeda.id as woredaid',
                            DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                            'reqworeda.id as requestedid',
                            DB::raw('IF(purchasevaulationdetails.evrequesteditemid=1,purchasevaulationdetails.cropyear,purchasevaulationdetails.evcropyear) AS evaulationcropyear'),
                            DB::raw('IF(purchasevaulationdetails.evrequesteditemid=1,purchasevaulationdetails.proccesstype,purchasevaulationdetails.evproccesstype) AS evaulationproccesstype'),
                            'pesuplliers.customers_id','purchasevaulationdetails.sampleamount','purchasevaulationdetails.evmoisture','purchasevaulationdetails.qualitygrade as grade',
                            'purchasevaulationdetails.evcupvalue','purchasevaulationdetails.screensieve','purchasevaulationdetails.evscore','purchasevaulationdetails.evstatus',
                            'purchasevaulationdetails.tecremark','purchasevaulationdetails.description','purchasevaulationdetails.rowvalue'
                            ]);
                            $requesteproductlist=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
                                ->join('zones','woredas.zone_id','=','zones.id')
                                ->join('regions','zones.Rgn_Id','=','regions.id')
                                ->where('purdetails.purequest_id',$purchaseid)->get(['woredas.id','regions.Rgn_Name','zones.Zone_Name','woredas.Woreda_Name as Name']);
                break;
        }
        $supplier=Purchasevaulation::join('pesuplliers','purchasevaulations.id','=','pesuplliers.purchasevaulation_id')
                ->join('customers','pesuplliers.customers_id','=','customers.id')
                ->orderBy('pesuplliers.id','ASC')
                ->where('pesuplliers.purchasevaulation_id',$id)
                ->get(['customers.id as customerid','pesuplliers.id as psid','customers.Name','customers.Code','customers.TinNumber','pesuplliers.Code as suppliercode','pesuplliers.phone','pesuplliers.recievedate']);
                return Response::json([
                                'success' =>200,
                                'id' =>$id,
                                'pr'=>$pr,
                                'rfq'=>$rfq,
                                'supplier'=>$supplier,
                                'productlist'=>$productlist,
                                'requesteproductlist'=>$requesteproductlist,
                            ]);
    }
        public function requesteditems($id,$reference,$type){
        switch ($reference) {
            case 'Direct':
                switch ($type) {
                    case 'Goods':
                        $productlist=Peinitiations::join('regitems','regitems.id','=','peinitiations.regitem_id')
                                ->where('purchasevaulation_id',$id)->get(['regitems.id',DB::raw('CONCAT(regitems.Code," ",regitems.Name) as col1'),'regitems.SKUNumber as col2','peinitiations.sampleamount as col3']);
                        break;
                    default:
                        $productlist=Peinitiations::join('woredas','woredas.id','peinitiations.woreda_id')
                                                    ->join('zones','woredas.zone_id','zones.id')
                                                    ->join('regions','zones.Rgn_Id','regions.id')
                                                    ->join('purchasevaulations','peinitiations.purchasevaulation_id','purchasevaulations.id')
                                                    ->leftJoin('lookups as croplookups','peinitiations.cropyear','croplookups.CropYearValue')
                                                    ->where('purchasevaulation_id',$id)->get([DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as col1'),'peinitiations.proccesstype as col3','peinitiations.cropyear as col2','croplookups.CropYear as col2']);
                        break;
                }
            break;
            default:
                    $rfqid=Purchasevaulation::where('id',$id)->first()->rfq;
                    $purchaseid=rfq::where('id',$rfqid)->first()->purequest_id;
                    $purchase=purchaseRequest::where('id',$purchaseid)->get();
                    $id=$purchaseid;
                    switch ($type) {
                        case 'Goods':
                            $pr=purchaseRequest::withCount('items as totalitems')->where('id',$id)->get();
                            $productlist=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
                                ->where('purequest_id',$id)->get(['regitems.id',DB::raw('CONCAT(regitems.Code," ",regitems.Name) as col1'),'regitems.SKUNumber as col2','purdetails.qty as col3']);
                            break;
                        default:
                                $pr=purchaseRequest::withCount('commuidities as totalitems')->where('id',$id)->get();
                                $productlist=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
                                                            ->join('zones','woredas.zone_id','=','zones.id')
                                                            ->join('regions','zones.Rgn_Id','=','regions.id')
                                                            ->join('purequests','purdetails.purequest_id','purequests.id')
                                                            ->where('purequest_id',$id)->get([DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as col1'),'purdetails.proccesstype as col3','croplookups.CropYear as col2']);
                        break;
                    }
                break;
        }
        
        return datatables()->of($productlist)->addIndexColumn()->toJson();
}

    public function edit($id){
        $productinitation='';
        $reference=Purchasevaulation::where('id',$id)->first()->petype;
        $type=Purchasevaulation::where('id',$id)->first()->type;
        $rfqid=Purchasevaulation::where('id',$id)->first()->rfq;
        
        $pr=Purchasevaulation::where('id',$id)->get();
        $purchaseid=rfq::where('id',$rfqid)->first()->purequest_id;
        $rfq=rfq::join('purequests','purequests.id','rfqs.purequest_id')
        ->where([['purequests.type',$type],['rfqs.id',$rfqid]])->get(['rfqs.id','rfqs.documentumber as rfq','purequests.docnumber as prequest','purequests.type']);
        switch ($reference) {
            case 'Direct':
                        switch ($type) {
                            case 'Goods':
                                        $productinitation=Peinitiations::join('regitems','regitems.id','=','peinitiations.regitem_id')
                                ->where('purchasevaulation_id',$id)->get(['regitems.id',DB::raw('CONCAT(regitems.Code," ",regitems.Name," ",regitems.SKUNumber) as item'),'regitems.id']);
                                break;
                            
                            default:
                                $productinitation=Peinitiations::join('woredas','woredas.id','peinitiations.woreda_id')
                                                    ->join('zones','woredas.zone_id','zones.id')
                                                    ->join('regions','zones.Rgn_Id','regions.id')
                                                    ->join('purchasevaulations','peinitiations.purchasevaulation_id','purchasevaulations.id')
                                                    ->where('purchasevaulation_id',$id)->get([DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as RZW'),'woredas.id']);
                                break;
                        }
                break;
            
            default:
                switch ($type) {
                    case 'Goods':
                        $productinitation=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
                                ->where('purequest_id',$purchaseid)->get(['regitems.id',DB::raw('CONCAT(regitems.Code," ",regitems.Name," ",SKUNumber) as item'),'regitems.id']);
                        break;
                    
                    default:
                            $productinitation=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
                                                            ->join('zones','woredas.zone_id','=','zones.id')
                                                            ->join('regions','zones.Rgn_Id','=','regions.id')
                                                            ->join('purequests','purdetails.purequest_id','purequests.id')
                                                            ->where('purequest_id',$purchaseid)->get([DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as RZW'),'woredas.id']);
                        break;
                }
                break;
        }
        switch ($type) {
            case 'Goods':
                $productlist=Purchasevaulationdetail::join('regitems','regitems.id','=','purchasevaulationdetails.regitem_id')
                                                    ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                                                    ->join('customers','pesuplliers.customers_id','customers.id')
                                                    ->where('purchasevaulationdetails.purchasevaulation_id',$id)
                                                    ->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber','pesuplliers.id as peid','pesuplliers.customers_id','purchasevaulationdetails.sampleamount','purchasevaulationdetails.remark','purchasevaulationdetails.description']);
                                                    $requesteproductlist=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
                                                            ->where('purequest_id',$purchaseid)->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber','purdetails.qty','purdetails.price','purdetails.remark']);
                                                    break;
            default:
                $productlist=Purchasevaulationdetail::join('woredas','woredas.id','=','purchasevaulationdetails.woreda_id')
                        ->join('zones','woredas.zone_id','=','zones.id')
                        ->join('regions','zones.Rgn_Id','=','regions.id')
                        ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                        ->join('customers','pesuplliers.customers_id','customers.id')
                        ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
                        ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
                        ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
                        ->where('purchasevaulationdetails.purchasevaulation_id',$id)->get([
                            DB::raw('CONCAT(reqregions.Rgn_Name," ",reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                            DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS supplyorigin'),
                            'regions.Rgn_Name','zones.Zone_Name','pesuplliers.id as peid','pesuplliers.customers_id','reqworeda.id as requestedid',
                            'woredas.id','woredas.Woreda_Name as Name','purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype',
                            'purchasevaulationdetails.sampleamount','purchasevaulationdetails.remark','purchasevaulationdetails.description','purchasevaulationdetails.id as cid'
                            ]);
                        $requesteproductlist=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
                                                ->join('zones','woredas.zone_id','=','zones.id')
                                                ->join('regions','zones.Rgn_Id','=','regions.id')
                                                ->where('purdetails.purequest_id',$purchaseid)->get(['woredas.id','regions.Rgn_Name','zones.Zone_Name',
                                                        'woredas.Woreda_Name as Name']);
                        break;
        }
            $supplier=Purchasevaulation::join('pesuplliers','purchasevaulations.id','=','pesuplliers.purchasevaulation_id')
                ->join('customers','pesuplliers.customers_id','=','customers.id')
                ->where('pesuplliers.purchasevaulation_id',$id)
                ->orderby('pesuplliers.id','ASC')
                ->get(['customers.id as customerid','pesuplliers.id as psid','customers.Name','customers.Code','customers.TinNumber','pesuplliers.phone','pesuplliers.recievedate']);

            $rfqsupplier=DB::table('customer_rfq')->join('rfqs','customer_rfq.rfq_id','rfqs.id')
                                ->join('customers','customer_rfq.customer_id','customers.id')
                                ->where('customer_rfq.rfq_id',$rfqid)
                                ->get(['customers.id','customers.Name','customers.Code','customers.TinNumber','customers.PhoneNumber']);

        return Response::json([
                                'success' =>200,
                                'pr'=>$pr,
                                'rfq'=>$rfq,
                                'productlist'=>$productlist,
                                'requesteproductlist'=>$requesteproductlist,
                                'supplier'=>$supplier,
                                'rfqsupplier'=>$rfqsupplier,
                                'productinitation'=>$productinitation,
                            ]);
    }
    
    public function specificsupplieredit($peid,$supllierid){
        $type=Purchasevaulation::where('id',$peid)->first()->type;
        switch ($type) {
        case 'Goods':
                $productlist=Purchasevaulationdetail::join('regitems','regitems.id','=','purchasevaulationdetails.regitem_id')
                    ->where([['purchasevaulation_id',$peid],['pesupllier_id',$supllierid]])->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber','purchasevaulationdetails.sampleamount','purchasevaulationdetails.remark']);
                break;
            default:
                    $productlist=Purchasevaulationdetail::join('woredas','woredas.id','=','purchasevaulationdetails.woreda_id')
                                ->where([['purchasevaulation_id',$peid],['pesupllier_id',$supllierid]])->get(['woredas.id','woredas.Woreda_Name as Name','purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype','purchasevaulationdetails.remark','purchasevaulationdetails.sampleamount']);
            break;
        }
        return Response::json([
                                'success' =>200,
                                'productlist'=>$productlist,
                                'type'=>$type,
                            ]);
    }
    public function pevualationseaction($id,$status){
        $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $userby=Auth()->user()->FullName;
        $actionby=$userby.' on '.$day;
        $ac='';
        $stat='';
        $pe=Purchasevaulation::find($id);
        $reference=Purchasevaulation::where('id',$id)->first()->petype;
        $doc=Purchasevaulation::where('id',$id)->first()->documentumber;
        $peaction=new actions();
        switch ($status) {
            case 0:
                    $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>0]);
                    $ac='Back to pending';
                    $stat='Pending';
                    $message='Successfully backed to pending';
                    $status=0;
                break;
            case 1:
                    $exist=Pesuplliers::where('purchasevaulation_id',$id)->exists();
                    switch ($exist) {
                        case true:
                            $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>1]);
                                $ac='Change To Pending';
                                $stat='Pending';
                                $message='Successfully change to pending';
                                $status=1;
                            break;
                        
                        default:
                            return Response::json(['success' => 202,]);
                            break;
                    }
                break;
                case 2:
                    $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>2]);
                    $ac='Verified';
                    $stat='Verify';
                    $message='Successfully verified';
                    $status=2;
                break;
                case 3:
                    $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>3]);
                    $type=Purchasevaulation::where('id',$id)->first()->type;
                    switch ($type) {
                        case 'Goods':
                            $update=Purchasevaulationdetail::where('purchasevaulation_id',$id)->update(['evrequesteditemid'=>DB::raw('regitem_id'),'isevaualated'=>1]);
                            break;
                        default:
                            $update=Purchasevaulationdetail::where('purchasevaulation_id',$id)->update(['evrequesteditemid'=>DB::raw('woreda_id'),'evcropyear'=>DB::raw('cropyear'),'evproccesstype'=>DB::raw('proccesstype'),'isevaualated'=>1]);
                            break;
                    }
                    $ac='Changed To TE';
                    $stat='Changed To TE';
                    $message='Successfully authorized';
                    $status=3;
                break;
                case 4:
                    $ac='Finished TE';
                    $stat='Finished TE';
                    $message='Successfully TE Evaluated';
                    $status=4;
                    $countstatus=$count = Purchasevaulationdetail::where(function($query) {
                                    $query->whereNull('evstatus')
                                        ->orwhere('evstatus','');
                                        })->where('purchasevaulation_id', $id)->count();
                                switch ($countstatus) {
                                    case 0:
                                            $count = Purchasevaulationdetail::where(function($query) {
                                            $query->where('evstatus','')
                                                ->orwhere('evmoisture','')
                                                ->orwhere('screensieve','')
                                                ->orwhere('qualitygrade','');
                                                })
                                                        ->where([['purchasevaulation_id', $id],['evstatus','Approved']])
                                                        ->count();
                                                switch ($count) {
                                                    case 0:
                                                        $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>4]);
                                                        break;
                                                    default:
                                                        return Response::json([
                                                            'success' => 201,
                                                            'count'=>$count,
                                                        ]);
                                                        break;
                                                }
                                        break;
                                    
                                    default:
                                        return Response::json([
                                            'success' => 204,
                                            'count'=>$count,
                                        ]);
                                        

                                        break;
                                }

                    
                break;
                case 5: 
                    $oldstatus=Purchasevaulation::where('id',$id)->first()->oldstatus;
                    $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>$oldstatus]);
                    $ac='Undo Reject';
                    $message='Successfully undo void';
                    $status=$oldstatus;
                    switch ($oldstatus) {
                        case 0:
                            $stat='Draft';
                        break;
                        case 1:
                            $stat='Pending';
                        break;
                        case 2:
                            $stat='Verify';
                        break;
                        default:
                            $stat='--';
                            break;
                    }
                break;
                case 8:
                    $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>8]);
                    $ac='Change To FE';
                    $stat='Change To FE';
                    $message='Successfully changed financial evaluating';
                    $status=8;
                break;
                case 9:
                    $count = Purchasevaulationdetail::where(function($query) {
                                    $query->where('bagamount','')
                                        ->orwhere('proposedprice','')
                                        ->orwhere('customerprice','')
                                        ->orwhere('finalprice','');
                                })
                                ->where([['purchasevaulation_id', $id],['evstatus','Approved']]) // Additional condition
                                ->count();
                                
                        switch ($count) {
                            case 0:
                                $ac='Finished FE';
                                $stat='Finished FE';
                                $message='Successfully finiesh financail evualation';
                                $status=9;

                                $rankedProducts = DB::table('purchasevaulationdetails')
                                ->where('purchasevaulation_id',$id)
                                ->select('id', 'evrequesteditemid', 'finalprice',
                                    DB::raw('RANK() OVER (PARTITION BY evrequesteditemid ORDER BY finalprice ASC) as rank'),
                                    DB::raw('DENSE_RANK() OVER (PARTITION BY evrequesteditemid ORDER BY finalprice ASC) as dense_rank'),
                                    DB::raw('ROW_NUMBER() OVER (PARTITION BY evrequesteditemid ORDER BY finalprice ASC) as row_number'))
                                ->get();
                                
                                foreach ($rankedProducts as $product) {

                                    DB::table('purchasevaulationdetails')
                                        ->where('id', $product->id)
                                        ->update([
                                            'rank' => $product->rank,
                                            'dense_rank' => $product->dense_rank,
                                            'row_number' => $product->row_number
                                        ]);
                                    }
                                $pesupplier=Purchasevaulationdetail::where('purchasevaulation_id',$id)->groupBy('pesupllier_id')->get(['id','pesupllier_id','rank','dense_rank','row_number']);
                                $a=[];
                                foreach ($pesupplier as $key => $value) {
                                    $a[]=$value->pesupllier_id;
                                    Pesuplliers::where('id',$value->pesupllier_id)->update(['rank'=>$value->rank,'dense_rank'=>$value->dense_rank,'row_number'=>$value->row_number]);
                                }
                                
                                $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>9]);
                                break;
                            
                            default:
                                
                                return Response::json([
                                    'success' => 201,
                                    'count'=>$count,
                                ]);
                                break;
                        }
                    break;
            case 10:
                $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>10]);
                $ac='Confirmed';
                $stat='Confirm';
                $message='Successfully Confirmed';
                $status=10;
            break;
            case 11:
                $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>11]);
                $ac='Approved';
                $stat='Approve';
                $message='Successfully Approved';
                $status=11;
            break;
            case 12: 
                $oldstatus=Purchasevaulation::where('id',$id)->first()->oldstatus;
                $rfqupdate=Purchasevaulation::where('id',$id)->update(['status'=>$oldstatus]);
                $ac='Undo void';
                $message='Successfully undo void';
                $status=$oldstatus;
                switch ($oldstatus) {
                    case 0:
                        $stat='Draft';
                    break;
                    case 1:
                        $stat='Pending';
                    break;
                    case 2:
                        $stat='Verify';
                    break;
                    
                    default:
                        $stat='--';
                        break;
                }
            break;
            default:
                $message=-1;
                $status=-1;
                break;
        }
        $peaction->action=$ac;
        $peaction->status=$stat;
        $peaction->pagename='pe';
        $peaction->user_id=Auth()->user()->id;
        $peaction->time=$day;
        $pe->actions()->save($peaction);
        $actions=actions::join('users','actions.user_id','=','users.id')
                ->where([['pageid',$id],['actions.pagename','pe']])
                ->orderBy('actions.id','DESC')
                ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
        return Response::json([
                                'success' => 200,
                                'message'=>$message,
                                'doc'=>$doc,
                                'status'=>$status,
                                'reference'=>$reference,
                                'actions'=>$actions,
                            ]);
        }
        public function purchasevaliotionvoid(Request $request){
            $validator = Validator::make($request->all(), [
                'Reason' => ['required'],
            ]);
            if ($validator->passes()){
                $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                $userby=Auth()->user()->FullName;
                $voidby=$userby.' on '.$day;
                $oldstatus=Purchasevaulation::where('id',$request->purchasevoidid)->first()->status;
                $pevaction=new actions();
                switch ($request->voidtype) {
                    case 'TEFAIL':
                        $ac='TE Failed';
                        $prstatus='TE Failed';
                        $status=12;
                    break;
                    case 'FEFAIL':
                        $ac='FE Failed';
                        $prstatus='FE Failed';
                        $status=13;
                    break;
                    case 'Void':
                        $ac='Void';
                        $prstatus='Void';
                        $status=5;
                        break;
                    case 'pending':
                            $ac='Back to pending';
                            $prstatus='Pending';
                            $status=1;
                    break;
                    case 'Verify':
                        $ac='Back To Verify';
                        $prstatus='Verify';
                        $status=2;
                    break;
                    case 'TE':
                        $ac='Back To TE';
                        $prstatus='Back To TE';
                        $status=3;
                        //$update=Purchasevaulationdetail::where('purchasevaulation_id',$request->purchasevoidid)->update(['evmoisture'=>'','evcupvalue'=>'','screensieve'=>'','evstatus'=>'','evscore'=>'']);
                    break;
                    case 'FE':
                        $ac='Back To FE';
                        $prstatus='Back To FE';
                        $status=8;
                        //$update=Purchasevaulationdetail::where('purchasevaulation_id',$request->purchasevoidid)->update(['customerprice'=>'','proposedprice'=>'','finalprice'=>'']);
                    break;
                        case 'Draft':
                        $ac='Back To Draft';
                        $prstatus='Draft';
                        $status=0;
                        break;
                    default:
                        $ac='Rejected';
                        $prstatus='Rejected';
                        $status=7;
                        break;
                }
                $pev=Purchasevaulation::find($request->purchasevoidid);
                try {
                    $pr=Purchasevaulation::updateOrCreate(['id' =>$request->purchasevoidid], [
                        'status' =>  $status,
                        'oldstatus' =>$oldstatus,
                        'voidby' => $voidby,
                    ]);
                    $pevaction->action=$ac;
                    $pevaction->status=$prstatus;
                    $pevaction->user_id=Auth()->user()->id;
                    $pevaction->pagename='pe';
                    $pevaction->time=$day;
                    $pevaction->reason=$request->Reason;
                    $pev->actions()->save($pevaction);
                    $actions=actions::join('users','actions.user_id','=','users.id')
                        ->where([['pageid',$request->rfqvoidid],['actions.pagename','pe']])
                        ->orderBy('actions.id','DESC')
                        ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
                    return Response::json([
                        'success' => 200,
                        'actions' => $actions,
                    ]);
                } catch (\Throwable $th) {
                    return Response::json(['dberrors' =>  $th->getMessage()]);
                }
            }
            if($validator->fails()){
                return Response::json(['errors' => $validator->errors()]);
            }
    }

    public function getallsuppliers(){
        $data=['Supplier','Customer&Supplier','Person'];
        $supllier=customer::whereIn('CustomerCategory',$data)->get(['id','Code','Name','TinNumber','PhoneNumber']);
        return Response::json([
                        'success' => 200,
                        'supllier' => $supllier,
                    ]);
    }

    public function getallproducts($type){
        $item=Regitem::where('id','>',1)->orderby('Code','asc')->get();
        $woreda=DB::select('SELECT regions.Rgn_Name,zones.Zone_Name,woredas.Woreda_Name,woredas.id FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id');
        switch ($type) {
            case 'Goods':
                $product=Regitem::where('id','>',1)->orderby('Code','asc')->get();
                break;
            default:
                $product=DB::select('SELECT regions.Rgn_Name,zones.Zone_Name,woredas.Woreda_Name,woredas.id FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id');
                break;
        }
        return Response::json([
                        'success' => 200,
                        'product' => $product,
                    ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchasevaulation  $purchasevaulation
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchasevaulation  $purchasevaulation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchasevaulation $purchasevaulation)
    {
        //
    }
}
