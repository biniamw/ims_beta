<?php
namespace App\Http\Controllers;
use App\Models\{purchaseRequest,department,User,Regitem,Commudity,purchaseDetails,setting,uom,store,companyinfo,
                praction,purchaseContract,customer,purchaseContractSupplier,purchaseContractDetails,actions};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;

class PurchaseContractController extends Controller
{
    public function index(){
            $currentdate = Carbon::today()->toDateString();
            $settingsval = DB::table('settings')->latest()->first();
            $fiscalyr=$settingsval->FiscalYear;
            $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
            $woreda=DB::select('SELECT regions.Rgn_Name,zones.Zone_Name,woredas.Woreda_Name,woredas.Wh_name,woredas.id FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id');
            $data=['Supplier','Customer&Supplier','Person'];
            $customer=customer::whereIn('CustomerCategory',$data)->get();
            $uom=uom::where('id','>',1)->orderby('id','desc')->get();
            return view('pr.purchasecontract',[
                                                'fiscalyears'=>$fiscalyears,
                                                'todayDate'=>$currentdate,
                                                'woreda'=>$woreda,
                                                'customer'=>$customer,
                                                'uom'=>$uom,
                                            ]);
    }

    function contractlist(){
        // $currentDate = Carbon::now();
        $currentdate = Carbon::today()->toDateString();
        purchaseContract::whereIn('status',[3,4])->where('endate', '<', $currentdate) ->update(['status' => 5]);
        $pc = purchaseContract::join('customers','purchasecontracts.customer_id','customers.id')
                                    ->orderby('purchasecontracts.id','Desc')
                                    ->get(['purchasecontracts.id','customers.Name as customername','customers.TinNumber as tin','purchasecontracts.reciever',
                                    'purchasecontracts.ecxno','purchasecontracts.ddano','purchasecontracts.docno','purchasecontracts.signedate','purchasecontracts.endate','purchasecontracts.status',
                                    'purchasecontracts.date','purchasecontracts.type','purchasecontracts.contractype'
                            ]);
        return datatables()->of($pc)->addIndexColumn()->toJson();
    }
    
    public function pcinfo($id){
                    $pc = purchaseContract::join('customers','purchasecontracts.customer_id','customers.id')
                            ->where('purchasecontracts.id',$id)
                            ->get(['purchasecontracts.id','customers.Name as customername','purchasecontracts.ecxno',
                            'purchasecontracts.ddano','purchasecontracts.signedate','purchasecontracts.endate','purchasecontracts.docno',
                            'purchasecontracts.path','purchasecontracts.date','purchasecontracts.status','purchasecontracts.type',
                            'purchasecontracts.contractype','purchasecontracts.subtotal','purchasecontracts.tax',
                            'purchasecontracts.grandtotal','purchasecontracts.withold','purchasecontracts.netpay','purchasecontracts.istaxable' 
                        ]);
                $actions=actions::join('users','actions.user_id','=','users.id')
                                ->where([['pageid',$id],['actions.pagename','purchasecontract']])
                                ->orderBy('actions.id','DESC')
                                ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);

        return Response::json(['success' => 200,
                                'pc' => $pc,
                                'actions' => $actions,
                                ]);
    }

    public function infogetsupllers($headerid,$id){

                $currentdate = Carbon::today()->toDateString();
                $signdate=purchaseContractSupplier::where('id',$id)->first()->signedate;
                $endate=purchaseContractSupplier::where('id',$id)->first()->endate;
                $signdate = Carbon::parse($signdate);
                $endate = Carbon::parse($endate);
                $currentdate = Carbon::parse($currentdate);
                if ($currentdate->between($signdate, $endate)) {
                        $update=purchaseContractSupplier::where('id',$id)->update(['isexpired'=>'Active']);
                } else {
                    $update=purchaseContractSupplier::where('id',$id)->update(['isexpired'=>'Expired']);
                }
                $supplinfo=purchaseContractSupplier::where('id',$id)->get();
                $headerexist=purchaseContractDetails::where([['purchasecontract_id',$headerid],['pcontractsupplier_id',$id]])->exists();
                $actions=actions::join('users','actions.user_id','=','users.id')
                                ->where([['pageid',$headerid],['actions.pagename','purchasecontract'.$id]])
                                ->orderBy('actions.id','DESC')
                                ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
        return Response::json([
                'success' =>200,
                'headerexist' =>$headerexist,
                'supplinfo' =>$supplinfo,
                'actions' =>$actions,
        ]);
    }
    public function suppliercontractcommodity($headerid){

                $comiditylist=purchaseContractDetails::join('woredas','pcdetails.itemid','woredas.id')
                            ->leftJoin('zones','woredas.zone_id','zones.id')
                            ->leftJoin('regions','zones.Rgn_Id','regions.id')
                            ->leftJoin('uoms','pcdetails.uom','uoms.id')
                            ->leftJoin('customers','pcdetails.supplier','customers.id')
                            ->orderby('pcdetails.itemid','ASC')
                            ->where('pcdetails.purchasecontract_id',$headerid)
                            ->get([ DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS origin'),
                                    'pcdetails.itemid as woreda','pcdetails.grade','pcdetails.proccesstype','pcdetails.ton',
                                    'pcdetails.kg','pcdetails.feresula','pcdetails.percentage','pcdetails.signedate','pcdetails.endate',
                                    'pcdetails.ectalocation','pcdetails.recievestation','pcdetails.price','pcdetails.total',
                                        'uoms.id as uimid','uoms.Name as uomname','uoms.uomamount as amount','pcdetails.cropyear',
                                        'pcdetails.nofbag','pcdetails.id','customers.Name as suplier'
                                    ]);
                return datatables()->of($comiditylist)->addIndexColumn()->toJson();
        }

        public function getsuplleritems($headerid){
                    $pc=purchaseContract::where('id',$headerid)->get();
                    $comiditylist=purchaseContractDetails::join('woredas','pcdetails.itemid','woredas.id')
                                ->join('zones','woredas.zone_id','zones.id')
                                ->join('regions','zones.Rgn_Id','regions.id')
                                ->join('uoms','pcdetails.uom','uoms.id')
                                ->join('customers','pcdetails.supplier','customers.id')
                                ->join('pcontractsuppliers','pcdetails.pcontractsupplier_id','pcontractsuppliers.id')
                                ->orderby('pcdetails.itemid','ASC')
                                ->where('pcdetails.purchasecontract_id',$headerid)
                                ->get([ DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS origin'),
                                        'pcdetails.itemid as woreda','pcdetails.grade','pcdetails.proccesstype','pcdetails.ton',
                                        'pcdetails.kg','pcdetails.feresula','pcdetails.percentage','pcdetails.signedate','pcdetails.endate',
                                        'pcdetails.ectalocation','pcdetails.recievestation','pcdetails.price','pcdetails.total',
                                        'uoms.id as uimid','uoms.Name as uomname','uoms.uomamount as amount','pcdetails.cropyear',
                                        'pcdetails.nofbag','pcdetails.id','customers.id as cusid','customers.Name as cname'
                                        ]);
                                        
                return Response::json(['success' => 200,
                                        'pc'=>$pc,
                                        'comiditylist'=>$comiditylist,
                                    ]);
    }
    public function downloadcontract($ids) 
    {
        $file_name=$pc=purchaseContract::where('id',$ids)->first()->path;
        if (empty($file_name)) {

                return Response::json(['success' => 201,
                                    
                                    ]);
            } else{
                $file_path = public_path($file_name);
                $fileContent = file_get_contents($file_path);
                return response($fileContent, 200)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="example.pdf"');
            }
        
    }

    public function pcvoid(Request $request){
            $validator = Validator::make($request->all(), [
                'Reason' => ['required'],
            ]);
            if ($validator->passes()){
                $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                $userby=Auth()->user()->FullName;
                $voidby=$userby.' on '.$day;
                $oldstatus=purchaseContract::where('id',$request->purchasevoidid)->first()->status;
                
                $poaction=new actions();
                switch ($request->voidtype) {
                    case 'Void':
                        $ac='Void';
                        $prstatus='Void';
                        $status=6;
                        break;
                    case 'Draft':
                        $ac='Back To Draft';
                        $prstatus='Draft';
                        $status=0;
                    break;  
                    case 'Pending':
                        $ac='Back To Pending';
                        $prstatus='Pending';
                        $status=1;
                        
                    break;
                    case 'Verify':
                        $ac='Back To Verify';
                        $prstatus='Verify';
                        $status=2;
                        
                        break;
                    default:
                        $ac='Rejected';
                        $prstatus='Rejected';
                        $status=7;
                        break;
                }
                
                try {
                    $pr=purchaseContract::updateOrCreate(['id' =>$request->purchasevoidid], [
                        'status' =>  $status,
                        'oldstatus' =>$oldstatus,
                    ]);

                    $po=purchaseContract::find($request->purchasevoidid);
                    $poaction->action=$ac;
                    $poaction->status=$prstatus;
                    $poaction->pagename='purchasecontract';
                    $poaction->user_id=Auth()->user()->id;
                    $poaction->time=$day;
                    $po->actions()->save($poaction);
                return Response::json(['success' => 200]);
                } catch (\Throwable $th) {
                    return Response::json(['dberrors' =>  $th->getMessage()]);
                }
            }
            if($validator->fails()){
                return Response::json(['errors' => $validator->errors()]);
            }
    }

    public function pcsupplieraction($id,$status){
    $action='';
    $stat='';
    $docno=purchaseContract::where('id',$id)->first()->docno;
    $poaction=new actions();
    switch ($status) {
            case 1:
                $update=purchaseContract::where('id',$id)->update(['status'=>1]);
                $message='Successfully changed';
                $action='Changed To pending';
                $stat='Pending';
            break;

            case 2:
                $name=purchaseContract::where('id',$id)->first()->name;
                if(!empty($name)) {
                        $update=purchaseContract::where('id',$id)->update(['status'=>2]);
                        $message='Successfully changed';
                        $action='Verified';
                        $stat='Verify';
                }
                else
                {
                    return Response::json([
                                'success' => 201,
                                'message'=>'Please Attach the Contract document',
                            ]);
                }
                
                break;
            case 3:
                $update=purchaseContract::where('id',$id)->update(['status'=>3]);
                $message='Successfully changed';
                $action='Approved';
                $stat='Approve';
                $currentdate = Carbon::today()->toDateString();
                $signdate=purchaseContract::where('id',$id)->first()->signedate;
                $endate=purchaseContract::where('id',$id)->first()->endate;
                $signdate = Carbon::parse($signdate);
                $endate = Carbon::parse($endate);
                $currentdate = Carbon::parse($currentdate);
                if ($currentdate->between($signdate, $endate)) {
                        $update=purchaseContract::where('id',$id)->update(['status'=>4]);
                } else {
                    $update=purchaseContract::where('id',$id)->update(['status'=>5]);
                }
            break;
                
                case 4:
                    $oldstatus=purchaseContract::where('id',$id)->first()->oldstatus;
                    purchaseContract::where('id',$id)->update(['status'=>$oldstatus]);
                    $message='Successfully changed';
                    $action='Undo Void';
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
                        case 3:
                            $stat='Approved';
                        break;
                        default:
                            $stat='--';
                            break;
                    }
                break;
            case 7:
                    $update=purchaseContract::where('id',$id)->update(['status'=>1,'docno'=>'']);
                    $oldstatus=purchaseContract::where('id',$id)->first()->oldstatus;
                    purchaseContract::where('id',$id)->update(['status'=>$oldstatus]);
                    $message='Successfully changed';
                    $action='Undo Reject';
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
                        case 3:
                            $stat='Approved';
                        break;
                        case 4:
                            $stat='Active';
                        break;
                        case 5:
                            $stat='Expire';
                        break;
                        default:
                            $stat='--';
                            break;
                    }
                break;
                case 8:
                $update=Pesuplliers::where('id',$id)->update(['status'=>2]);
                $message='Successfully changed';
                $action='Back to Pending';
                $stat='Pending';
                break;
                case 9:
                $update=Pesuplliers::where('id',$id)->update(['status'=>3]);
                $message='Successfully changed';
                $action='Back to Verify';
                $stat='Verify';
                break;
            default:
                
                break;
        }
                $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                $po=purchaseContract::find($id);
                $poaction=new actions();
                $poaction->action=$action;
                $poaction->status=$stat;
                $poaction->pagename='purchasecontract';
                $poaction->user_id=Auth()->user()->id;
                $poaction->time=$day;
                $po->actions()->save($poaction);
                $laststatus=purchaseContract::where('id',$id)->first()->status;
                $actions=actions::join('users','actions.user_id','=','users.id')
                                ->where([['pageid',$id],['actions.pagename','purchasecontract']])
                                ->orderBy('actions.id','DESC')
                                ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
        return Response::json([
                                'success' => 200,
                                'message'=>$message,
                                'status'=>$laststatus,
                                'actions'=>$actions,
                                'docno'=>$docno,
                            ]);
    }

    public function pcsavesupplier(Request $request){

        $validator = Validator::make($request->all(), [
                'date' => ['required','before:now'],
                'ecta' => ['required'],
                'dara' => ['required'],
                'signdate' => ['required'],
                'enddate' => ['required'],
            ]);
            $rules=array(
                        'row.*.ItemId' => 'required',
                        'row.*.grade' => 'required',
                        'row.*.ton' => 'required',
                        'row.*.percentage' => 'required',
                        'row.*.revievestation' => 'required',
                );
                $v2= Validator::make($request->all(), $rules);
                if ($validator->passes() && $v2->passes() && ($request->row!=null)) {
                        
                        $pc=purchaseContractSupplier::updateOrCreate(['id' =>$request->pcsupplierid], [
                            'purchasecontract_id'=>$request->pcid,
                            'date'=>$request->date,
                            'ecxno'=>$request->ecta,
                            'ddano'=>$request->dara,
                            'signedate'=>$request->signdate,
                            'endate'=>$request->enddate,
                        ]);
                        if (!empty($request->pcsupplierid)) {
                                $action='Edited';
                                $stat='Edited';
                                $poid=$request->pcsupplierid;
                                $poid=purchaseContractSupplier::latest()->first()->id;
                                    $cerids=[];
                                    foreach ($request->row as $key => $value){
                                        $cerids[]=(int)$value['pcid'];
                                    }
                                    purchaseContractDetails::where([['purchasecontract_id',$request->pcid],['pcontractsupplier_id',$request->pcsupplierid]])->whereNotIn('id',$cerids)->delete();
                                } else{
                                    
                                    $action='Created';
                                    $stat='Created';
                                    $poid=purchaseContractSupplier::latest()->first()->id;
                                }
                        foreach ($request->row as $key => $value){
                            $pedetials=purchaseContractDetails::updateOrCreate(['id' =>(int)$value['pcid']], [
                                'purchasecontract_id'=>$request->pcid,
                                'pcontractsupplier_id'=>$poid,
                                'itemid'=>(int)$value['ItemId'],
                                'grade' =>$value['grade'],
                                'proccesstype'=>$value['proccesstype'],
                                'ton'=>$value['ton'],
                                'kg'=>$value['kg'],
                                'feresula'=>$value['feresula'],
                                'percentage'=>$value['percentage'],
                                'recievestation'=>$value['revievestation'],
                                'ectalocation'=>$value['ectalocation'],
                        ]);
                    }
                        return Response::json([
                                                'success' => 200,
                                                'headerid'=>$request->pcid,
                                                'supllier'=>$poid,
                                                    ]);
                }
                else if($validator->fails()){
                        return Response::json(['errors' => $validator->errors()]);
                    }
                    else{
                            return Response::json(['errorv2' => $v2->errors()->all()]);
                    }
                    
    }
    public function uploadPDFViaAjax(Request $request){
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);
        if ($request->file('pdf')->isValid()) {
            $originalname=$request->file('pdf')->getClientOriginalName();
            $fileName = time() . '_' . $request->file('pdf')->getClientOriginalName();
            $filePath = $request->file('pdf')->storeAs('uploads', $fileName, 'public');

            $pdf = $request->file('pdf');
            $pdf->move(public_path('uploads'),$fileName);

            $update=purchaseContract::where('id',$request->recordIds)->update(['name'=>$originalname,'path'=>$filePath]);

            return response()->json([
                                    'message' =>'Contract uploaded successfully!',
                                    'name' =>$originalname,
                                    'id' =>$request->recordIds,
                                    'path' =>$filePath,
                    ]);
        }

        return response()->json(['message' => 'Failed to upload PDF'], 500);
    }

    public function store(Request $request){
        $ddano=$request->ddano;
        $ecxno=$request->ecxno;
        $validator = Validator::make($request->all(), [
            'contractseller' => ['required'],
            'date' => ['required'],
            'ecxno' => ['required_if:contractype,2','nullable','nullable',Rule::unique('purchasecontracts')->where(function ($query) use($ecxno) {
                    return $query->where('ecxno', $ecxno);
                })->ignore($request->pcontractid)],
            'ddano' => ['required_if:contractype,2','nullable',Rule::unique('purchasecontracts')->where(function ($query) use($ddano) {
                return $query->where('ddano', $ddano);
            })->ignore($request->pcontractid)],
            'signdate' => ['required'],
            'enddate' => ['required_if:contractype,2'],
            'type' => ['required'],
            'contractype' => ['required'],
            'pdf'=>'mimes:pdf,jpeg,png,jpg,gif|max:2048',
        ]);
            $rules=array(
                        'row.*.ItemId' => 'required',
                        'row.*.grade' => 'required',
                        'row.*.ton' => 'required',
                        'row.*.percentage' => 'required',
                        'row.*.proccesstype' => 'required',
                        'row.*.ectalocation' => 'required',
                );
                $v2= Validator::make($request->all(), $rules);

            if ($validator->passes() && $v2->passes()) {
                    if (!empty($request->pcontractid)) {
                        $docno=purchaseContract::where('id',$request->pcontractid)->first()->docno;
                    }else{
                            $latestPost = purchaseContract::latest()->first();
                            if ($latestPost) {
                                // Latest post exists
                                    $docno=purchaseContract::latest()->first()->docno;
                                    $docno=(int)$docno+1;
                                    $docno=sprintf("%06d", $docno);
                            } else {
                                    // No posts found
                                    $docno=1;
                                    $docno=sprintf("%06d", $docno);
                            }
                        
                    }

                    if ($request->hasFile('pdf')) {
                        $originalname=$request->file('pdf')->getClientOriginalName();
                        $fileName = time() . '_' . $request->file('pdf')->getClientOriginalName();
                        $filePath = $request->file('pdf')->storeAs('uploads', $fileName, 'public');
                        $pdf = $request->file('pdf');
                        $pdf->move(public_path('uploads'),$fileName);
                    }
                    else{
                        if (!empty($request->pcontractid)) {
                            $originalname=$request->filaname;
                            $filePath=$request->filepath;
                        }else{
                            $originalname='';
                            $filePath='';
                        }
                        
                    }

                    switch ($request->contractype) {
                        case '1':
                                $subtotal=$request->directsubtotali;
                                $tax=$request->directtaxi;
                                $grandtotal=$request->directgrandtotali;
                                $withold=$request->directwitholdingAmntin;
                                $netpay=$request->directnetpayin;
                            break;
                        
                        default:
                                $subtotal=0;
                                $tax=0;
                                $grandtotal=0;
                                $withold=0;
                                $netpay=0;
                            break;
                    }

                    $pc=purchaseContract::updateOrCreate(['id' =>$request->pcontractid], [
                            'customer_id'=>$request->contractseller,
                            'docno'=>$docno,
                            'contractype'=>$request->contractype,
                            'ddano'=>$request->ddano,
                            'ecxno'=>$request->ecxno,
                            'signedate'=>$request->signdate,
                            'endate'=>$request->enddate,
                            'date'=>$request->date,
                            'type'=>$request->type,
                            'name'=>$originalname,
                            'path'=>$filePath,
                            'istaxable'=>$request->directistaxable,
                            'subtotal'=>$subtotal,
                            'tax'=>$tax,
                            'grandtotal'=>$grandtotal,
                            'withold'=>$withold,
                            'netpay'=>$netpay,
                        ]);
                        
                        if (!empty($request->pcontractid)) {
                                $action='Edited';
                                $stat='Edited';

                                $poid=$request->pcontractid;
                                    $cerids=[];
                                    switch ($request->contractype) {
                                        case '2':
                                            foreach ($request->row as $key => $value){
                                                    $cerids[]=(int)$value['pcid'];
                                                }
                                            break;
                                        
                                        default:
                                            foreach ($request->fevrow as $key => $value){
                                                    $cerids[]=(int)$value['pdetid'];
                                                }
                                            break;
                                    }
                                    
                                    purchaseContractDetails::where('purchasecontract_id',$request->pcontractid)->whereNotIn('id',$cerids)->delete();
                                } else{
                                    $action='Created';
                                    $stat='Created';
                                    $poid=purchaseContract::latest()->first()->id;
                                }
                                switch ($request->contractype) {
                                    case '2':
                                        foreach ($request->row as $key => $value){
                                            $pedetials=purchaseContractDetails::updateOrCreate(['id' =>(int)$value['pcid']], [
                                                'purchasecontract_id'=>$poid,
                                                'pcontractsupplier_id'=>1,
                                                'itemid'=>(int)$value['ItemId'],
                                                'grade' =>$value['grade'],
                                                'proccesstype'=>$value['proccesstype'],
                                                'ton'=>$value['ton'],  
                                                'kg'=>$value['kg'],
                                                'feresula'=>$value['feresula'],
                                                'percentage'=>$value['percentage'],
                                                'recievestation'=>$value['revievestation'],
                                                'ectalocation'=>$value['ectalocation'],
                                        ]);
                                    }
                                        break;
                                    
                                    default:
                                        foreach ($request->fevrow as $key => $value){
                                                $pedetials=purchaseContractDetails::updateOrCreate(['id' =>(int)$value['pdetid']], [
                                                    'purchasecontract_id'=>$poid,
                                                    'pcontractsupplier_id'=>1,
                                                    'itemid'=>(int)$value['evItemId'],
                                                    'cropyear'=>$value['evcropyear'],
                                                    'grade' =>$value['directgrade'],
                                                    'proccesstype'=>$value['coffeproccesstype'],
                                                    'uom'=>$value['uom'],
                                                    'nofbag'=>$value['qauntity'],
                                                    'ton'=>$value['ton'],  
                                                    'kg'=>$value['quantitykg'],
                                                    'feresula'=>$value['feresula'],
                                                    'price'=>$value['finalprice'],
                                                    'total'=>$value['Total'],
                                                    'supplier'=>$value['supplierwarehouse'],
                                            ]);
                                        }
                                        break;
                                }
                        
                    $po=purchaseContract::find($poid);
                    $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                    $userby=Auth()->user()->FullName;
                    $voidby=$userby.' on '.$day;
                    $poaction=new actions();
                    $poaction->action=$action;
                    $poaction->status=$stat;
                    $poaction->pagename='purchasecontract';
                    $poaction->user_id=Auth()->user()->id;
                    $poaction->time=$day;
                    $po->actions()->save($poaction);
                    $laststatus=purchaseContract::where('id',$poid)->first()->status;
                    return Response::json(['success' => 200]);
            }
            else if($validator->fails()){
                    return Response::json(['errors' => $validator->errors()]);
                }
                else{
                            return Response::json(['errorv2' => $v2->errors()->all()]);
                    }

    }

}
