<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\groupmember;
use App\Models\paymentterm;
use App\Models\service;
use App\Models\servicedetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class ServiceController extends Controller
{
    //
    public function index(Request $request)
    {
        $category=DB::select('SELECT * FROM categories WHERE ActiveStatus="Active" AND IsDeleted=1 ORDER BY categories.Name ASC');
        $groups=DB::select('SELECT * FROM groupmembers WHERE groupmembers.Status="Active" ORDER BY groupmembers.GroupName ASC');
        $paymentterm=DB::select('SELECT * FROM paymentterms WHERE paymentterms.Status="Active" ORDER BY paymentterms.PaymentTermName ASC');
        $periodopt=DB::select('SELECT * FROM periods WHERE periods.Status="Active" ORDER BY periods.PeriodName ASC');
        if($request->ajax()) {
            return view('registry.service',['category'=>$category,'group'=>$groups,'pterms'=>$paymentterm,'periodopt'=>$periodopt])->renderSections()['content'];
        }
        else{
            return view('registry.service',['category'=>$category,'group'=>$groups,'pterms'=>$paymentterm,'periodopt'=>$periodopt]);
        }
    }

    public function serviceListCon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $servicelist=DB::select('SELECT services.id,services.ServiceName,categories.Name AS CategoryName,services.Status FROM services INNER JOIN categories ON services.categories_id=categories.id ORDER BY services.id DESC');
        if(request()->ajax()) {
            return datatables()->of($servicelist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $serviceedit='';
                $servicedelete='';
                if($user->can('Service-Edit')){
                    $serviceedit=' <a class="dropdown-item serviceEdit" onclick="editservicefn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open service update page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                }
                if($user->can('Service-Delete')){
                    $servicedelete='<a class="dropdown-item serviceDelete" onclick="deleteservicefn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open service delete confirmation">
                            <i class="fa fa-trash"></i><span> Delete</span>  
                        </a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item serviceInfo" data-id="'.$data->id.'" id="dtinfobtn" title="Open service information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$serviceedit.'
                        '.$servicedelete.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function store(Request $request){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->serviceId;
        $findid=$request->serviceId;
        $curdate=Carbon::today()->toDateString();
        if($findid!=null){
            $validator = Validator::make($request->all(), [
                'ServiceName' => ['required',Rule::unique('services')->where(function ($query){
                    })->ignore($findid)
                ],
                'Category' => ['required'],
                'Description' => ['nullable'],
                'status' => ['required'],
            ]);

            $rules=array(
                'row.*.periods_id' => 'required',
                'row.*.groupmembers_id' => 'required',
                'row.*.paymentterms_id' => 'required',
                'row.*.NewMemberPrice' => 'required|gte:row.*.MemberPrice',
                'row.*.MemberPrice' => 'required|lte:row.*.NewMemberPrice',
                'row.*.Status' => 'required',
            );
            $v2= Validator::make($request->all(), $rules);

            if ($validator->passes() && $v2->passes() && $request->row!=null){
                try
                {
                    $services=service::updateOrCreate(['id' => $request->serviceId], [
                        'ServiceName' => $request->ServiceName,
                        'categories_id' => $request->Category,
                        'Description' => $request->Description,
                        'LastEditedBy' => $user,
                        'LastEditedDate' =>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                        'Status' => $request->status,
                    ]);
                    $services->groups()->detach();
                    foreach ($request->row as $key => $value)
                    {
                        $headeridsval=$request->serviceId;
                        $periodvl=$value['periods_id'];
                        $groupid=$value['groupmembers_id'];
                        $paymentterm=$value['paymentterms_id'];
                        $newmember=$value['NewMemberPrice'];
                        $existingmember=$value['MemberPrice'];
                        $discounts=$value['Discount'];
                        $newmemdiscounts=$value['NewMemDiscount'];
                        $existrainer=$value['ExistingTrainerFee'];
                        $newtrainer=$value['NewTrainerFee'];
                        $descriptions=$value['Description'];
                        $status=$value['Status'];
                        $services->groups()->attach($groupid,
                        ['paymentterms_id'=>$paymentterm,'periods_id'=>$periodvl,'MemberPrice'=>$existingmember,'NewMemberPrice'=>$newmember,'NewTrainerFee'=>$newtrainer,'ExistingTrainerFee'=>$existrainer,'Discount'=>$discounts,'NewMemDiscount'=>$newmemdiscounts,'Description'=>$descriptions,'Status'=>$status]);
                    }
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
            if($request->row==null){
                return Response::json(['emptyerror'=>"error"]);
            }
        }

        if($findid==null){
            $validator = Validator::make($request->all(), [
                'ServiceName' => ['required','unique:services'],
                'Category' => ['required'],
                'Description' => ['nullable'],
                'status' => ['required'],
            ]);

            $rules=array(
                'row.*.periods_id' => 'required',
                'row.*.groupmembers_id' => 'required',
                'row.*.paymentterms_id' => 'required',
                'row.*.NewMemberPrice' => 'required|gte:row.*.MemberPrice',
                'row.*.MemberPrice' => 'required|lte:row.*.NewMemberPrice',
                'row.*.Status' => 'required',
            );
            $v2= Validator::make($request->all(), $rules);

            if ($validator->passes() && $v2->passes() && $request->row!=null){
                try
                {
                    $services=service::updateOrCreate(['id' => $request->serviceId], [
                        'ServiceName' => $request->ServiceName,
                        'categories_id' => $request->Category,
                        'Description' => $request->Description,
                        'CreatedBy' => $user,
                        'CreatedDate' =>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                        'Status' => $request->status,
                    ]);
                    foreach ($request->row as $key => $value)
                    {
                        $headeridsval=$request->serviceId;
                        $periodvl=$value['periods_id'];
                        $groupid=$value['groupmembers_id'];
                        $paymentterm=$value['paymentterms_id'];
                        $newmember=$value['NewMemberPrice'];
                        $existingmember=$value['MemberPrice'];
                        $newmemdiscounts=$value['NewMemDiscount'];
                        $discounts=$value['Discount'];
                        $existrainer=$value['ExistingTrainerFee'];
                        $newtrainer=$value['NewTrainerFee'];
                        $descriptions=$value['Description'];
                        $status=$value['Status'];
                        $services->groups()->attach($groupid,
                        ['paymentterms_id'=>$paymentterm,'periods_id'=>$periodvl,'MemberPrice'=>$existingmember,'NewMemberPrice'=>$newmember,'NewTrainerFee'=>$newtrainer,'ExistingTrainerFee'=>$existrainer,'Discount'=>$discounts,'NewMemDiscount'=>$newmemdiscounts,'Description'=>$descriptions,'Status'=>$status]);
                    }
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
            if($request->row==null){
                return Response::json(['emptyerror'=>"error"]);
            }
        }
    }

    public function deleteSer(Request $request){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->serviceDelId;
        $findid=$request->serviceDelId;
        servicedetail::where('services_id',$request->serviceDelId)->delete();
        service::where('id',$request->serviceDelId)->delete();
        return Response::json(['success' =>1]);
    }

    public function showserviceCon($id){
        $servicecount=0;
        $data = service::join('categories', 'services.categories_id', '=', 'categories.id')
        ->where('services.id', $id)
        ->get(['services.id','services.ServiceName','categories.Name AS CategoryName','services.Description','services.CreatedBy','services.CreatedDate','services.LastEditedBy','services.LastEditedDate','services.Status','services.categories_id']);

        $detdata = servicedetail::join('groupmembers', 'servicedetails.groupmembers_id', '=', 'groupmembers.id')
        ->join('paymentterms', 'servicedetails.paymentterms_id', '=', 'paymentterms.id')
        ->join('periods', 'servicedetails.periods_id', '=', 'periods.id')
        ->where('servicedetails.services_id',$id)
        ->get(['servicedetails.*','groupmembers.GroupName','paymentterms.PaymentTermName','periods.PeriodName',DB::raw('IFNULL(servicedetails.ExistingTrainerFee,"") AS ExistingTrainerFees'),DB::raw('IFNULL(servicedetails.NewTrainerFee,"") AS NewTrainerFees'),DB::raw('IFNULL(servicedetails.Discount,"") AS Discounts'),DB::raw('IFNULL(servicedetails.Description,"") AS Remark'),
            DB::raw('(SELECT COUNT(applications.id) FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.groupmembers_id=groupmembers.id AND applications.paymentterms_id=paymentterms.id AND appconsolidates.periods_id=periods.id) AS TransactionFlag')
        ]);

        $checkservicecnt=DB::select('SELECT COUNT(appconsolidates.services_id) AS ServiceCount FROM appconsolidates WHERE appconsolidates.services_id='.$id);   
        foreach($checkservicecnt as $row){
            $servicecount=$row->ServiceCount;
        }     

        return response()->json(['servlist'=>$data,'detdata'=>$detdata,'servicecountval'=>$servicecount]);       
    }

    public function servicelistinfoCon($id)
    {
        $detailTable=DB::select('SELECT servicedetails.id,periods.PeriodName,groupmembers.GroupName,paymentterms.PaymentTermName,servicedetails.NewMemberPrice,servicedetails.MemberPrice,servicedetails.NewMemDiscount,IFNULL(servicedetails.Discount,"") AS Discount,IFNULL(servicedetails.NewTrainerFee,"") AS NewTrainerFees,IFNULL(servicedetails.ExistingTrainerFee,"") AS ExistingTrainerFees,servicedetails.Description,servicedetails.Status FROM servicedetails INNER JOIN groupmembers ON servicedetails.groupmembers_id=groupmembers.id INNER JOIN paymentterms ON servicedetails.paymentterms_id=paymentterms.id INNER JOIN periods ON servicedetails.periods_id=periods.id WHERE servicedetails.services_id='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->make(true);
    }
}
