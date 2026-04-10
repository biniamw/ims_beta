<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\LeaveRequestMail;
use App\Jobs\LeaveRequestJob;
use App\Models\employee;
use App\Models\hr_leavetype;
use App\Models\hr_leave;
use App\Models\User;
use App\Models\hr_employee_leave;
use App\Models\actions;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Storage;
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LeaveManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    protected $targetService;

    public function __construct(AttendanceController $targetService)
    {
        $this->targetService = $targetService;
    }
    
    public function index(Request $request)
    {
        //
        $fullname=Auth()->user()->FullName;
        $userid=Auth()->user()->id;
        $empid=Auth()->user()->empid;
        $gender=Auth()->user()->Gender;
        $currentdate = Carbon::today()->toDateString();
        $user = employee::orderBy("name","ASC")->where("id",'>',0)->where("Status","Active")->get(["name","Gender","id"]);
        //$leavetype = hr_leavetype::orderBy("LeaveType","ASC")->where("Status","Active")->get(["LeaveType","id"]);
        $leavetype=DB::select('SELECT hr_employee_leaves.*,hr_leavetypes.LeaveType,(SELECT users.id FROM users WHERE users.empid=hr_employee_leaves.employees_id) AS userid FROM hr_employee_leaves INNER JOIN hr_leavetypes ON hr_employee_leaves.hr_leavetypes_id=hr_leavetypes.id WHERE hr_leavetypes.Status="Active" AND hr_employee_leaves.IsAllowed="Allowed"');
        $hrleavetype = hr_leavetype::orderBy("LeaveType","ASC")->where("Status","Active")->get();
        $yeardata=DB::select('SELECT DISTINCT CONCAT(hr_leave_transactions.employees_id,hr_leave_transactions.hr_leavetypes_id) AS EmpLeave,hr_leave_transactions.Year FROM hr_leave_transactions ORDER BY hr_leave_transactions.Year ASC');
        $branchfilter = DB::select('SELECT DISTINCT branches.id,branches.BranchName FROM hr_leaves LEFT JOIN employees ON hr_leaves.requested_for=employees.id LEFT JOIN branches ON employees.branches_id=branches.id WHERE branches.id>=1 ORDER BY branches.BranchName ASC');        
        $departmentfilter = DB::select('SELECT DISTINCT departments.id,departments.DepartmentName FROM hr_leaves LEFT JOIN employees ON hr_leaves.requested_for=employees.id LEFT JOIN departments ON employees.departments_id=departments.id WHERE departments.id>1 ORDER BY departments.DepartmentName ASC');  

        if($request->ajax()) {
            return view('hr.leavemgt',['user'=>$user,'leavetype'=>$leavetype,'fullname'=>$fullname,'userid'=>$userid,'empid'=>$empid,'gender'=>$gender,'currentdate'=>$currentdate,'hrleavetype'=>$hrleavetype,'yeardata'=>$yeardata,'branchfilter'=>$branchfilter,'departmentfilter'=>$departmentfilter])->renderSections()['content'];
        }
        else{
            return view('hr.leavemgt',['user'=>$user,'leavetype'=>$leavetype,'fullname'=>$fullname,'userid'=>$userid,'empid'=>$empid,'gender'=>$gender,'currentdate'=>$currentdate,'hrleavetype'=>$hrleavetype,'yeardata'=>$yeardata,'branchfilter'=>$branchfilter,'departmentfilter'=>$departmentfilter]);
        }
    }

    public function leavelistcont()
    {
        $childids=[0];
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $empid=Auth()->user()->empid;
        $users=Auth()->user();
        $childprop = DB::table('employees')->where('employees.employees_id',$empid)->get(['id','employees_id','name']);
        foreach($childprop as $childprop){
            
            $usersprop = DB::table('users')->where('users.empid',$childprop->id)->latest()->first();
            
            $childids[]=$usersprop->id ?? 1;
        }
        $childidvals=implode(',', $childids);
        $allreqfor=$childidvals.",".$userid;
        $leavelists=DB::select('SELECT DISTINCT hr_leaves.id,hr_leaves.LeaveID,hr_leaves.LeaveDurationType,employees.name AS FullName,employees.EmployeeID,branches.BranchName,departments.DepartmentName,positions.PositionName,employees.Gender,employees.ActualPicture,employees.BiometricPicture,(SELECT GROUP_CONCAT(" ",hr_leavetypes.LeaveType) FROM hr_leaves_details LEFT JOIN hr_leavetypes ON hr_leaves_details.hr_leavetypes_id=hr_leavetypes.id WHERE hr_leaves_details.hr_leaves_id=hr_leaves.id) AS LeaveType,hr_leaves.RequestedDate,hr_leaves.Status FROM hr_leaves LEFT JOIN employees ON hr_leaves.requested_for=employees.id LEFT JOIN branches ON employees.branches_id = branches.id LEFT JOIN departments ON employees.departments_id = departments.id LEFT JOIN positions ON employees.positions_id = positions.id ORDER BY hr_leaves.id DESC');
        if(request()->ajax()) {
            return datatables()->of($leavelists)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $leavedit='';
                $voidleave='';
                $undoleave='';
                if($data->Status=='Draft' || $data->Status=='Pending')
                {
                    if($user->can('Leave-Request-Void')){
                        $voidleave='<a class="dropdown-item leavemgtVoidFn" onclick="leavemgtVoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open leave request void confirmation">
                                <i class="fa fa-trash"></i><span> Void</span>  
                            </a>';
                    }
                    $undoleave='';
                    $leavedit=' <a class="dropdown-item leavemgtEditFn" onclick="leavemgtEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open leave request edit page"> <i class="fa fa-edit"></i><span> Edit</span></a>'; 
                }
                else if($data->Status=='Approved')
                {
                    if($user->can('Leave-Request-Approve')){
                        //$leavedit=' <a class="dropdown-item leavemgtEditFn" onclick="leavemgtEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open leave request edit page"> <i class="fa fa-edit"></i><span> Edit</span></a>'; 
                        $leavedit=''; 
                        if($user->can('Leave-Request-Void')){
                            $voidleave='<a class="dropdown-item leavemgtVoidFn" onclick="leavemgtVoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open leave request void confirmation">
                                    <i class="fa fa-trash"></i><span> Void</span>  
                                </a>';
                        }
                    }
                    $undoleave='';
                }
                else if($data->Status=='Verified')
                {
                    if($user->can('Leave-Request-Verify')){
                        if($user->can('Leave-Request-Void')){
                            $voidleave='<a class="dropdown-item leavemgtVoidFn" onclick="leavemgtVoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open leave request void confirmation">
                                    <i class="fa fa-trash"></i><span> Void</span>  
                                </a>';
                        }
                        $leavedit=' <a class="dropdown-item leavemgtEditFn" onclick="leavemgtEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open leave request edit page"> <i class="fa fa-edit"></i><span> Edit</span></a>'; 
                    }
                    $undoleave='';
                }
                else if($data->Status=='Rejected')
                {
                    if($user->can('Leave-Request-Verify')){
                        $leavedit=' <a class="dropdown-item leavemgtEditFn" onclick="leavemgtEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open leave request edit page"> <i class="fa fa-edit"></i><span> Edit</span></a>'; 
                    }
                    $voidleave='';
                    $undoleave='';
                }
                if($data->Status=='Void' || $data->Status=='Void(Draft)' || $data->Status=='Void(Pending)' || $data->Status=='Void(Verified)' || $data->Status=='Void(Approved)')
                {
                    $voidleave='';
                    if($user->can('Leave-Request-Void')){
                        $undoleave='<a class="dropdown-item leavemgtUndoVoidFn" onclick="leavemgtUndoVoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open leave request undo void confirmation">
                                <i class="fa fa-undo"></i><span>Undo Void</span>  
                            </a>';
                    }
                }

                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item leavemgtInfoFn" onclick="leavemgtInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open leave request information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$leavedit.'
                        '.$voidleave.'
                        '.$undoleave.'
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
        $settings = DB::table('settings')->latest()->first();
        $rprefix=$settings->LeavePrefix;
        $rnumber=$settings->LeaveNumber;
        $rnumberPadding=sprintf("%06d", $rnumber);
        $leaveid=$rprefix.$rnumberPadding;
        $supportingdoc=null;
        $totalnumofday = 0;

        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $prepid=Auth()->user()->id;
        $empid=Auth()->user()->empid;

        $childids=[];
        $parenttree=[1];
        $leavereqdetail=[];

        $empname = DB::table('employees')->where('employees.id',$empid)->get(['id','employees_id','name']);
        foreach($empname as $empname){
            $parentid=$empname->employees_id;
            $parid=null;
            $nodename=$empname->name;
            $grandparent=null;
            for($i=1;$i<=100;$i++){
                $parentprop = DB::table('employees')->where('employees.id',$parentid)->get(['id','employees_id','name','IsOnLeave']);
                foreach($parentprop as $parow){
                    $grandparent=$parow->id;
                    if($parow->IsOnLeave==0){
                        $parenttree[]=$parow->id."-".$parow->name;
                    }
                }

                $grandparentprop = DB::table('employees')->where('employees.id',$grandparent)->get(['id','employees_id','name','IsOnLeave']);
                foreach($grandparentprop as $gparow){
                    $parentid=$gparow->employees_id;
                }

                if($parentid==1){
                    $i=100;
                }
            }
        }
        $supervsorid=$parenttree[0];// to get the closest manager


        $headerid=$request->recId;
        $findid=$request->recId;
        $curdate=Carbon::today()->toDateString();

        $validator = Validator::make($request->all(), [
            'RequestFor' => 'required',
            'LeaveDurationType' => 'required',
            'RequestDate' => 'required',
            'LeaveFrom' => 'required',
            'LeaveTo' => 'required',
            'LeaveReason' => 'nullable|string',
            'AddressDuringLeave' => 'nullable|string',
            'Remark' => 'nullable|string',
            'DocumentUpload' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png,gif',
            'EmergencyName' => 'nullable|string',
            'EmergencyPhone' => 'nullable|string',
            'EmergencyEmail' => 'nullable|string',
        ]);

        $rules=array(
            'leaverow.*.LeaveType' => 'required',
            'leaverow.*.Year' => 'required',
            'leaverow.*.LeavePaymentType' => 'required',
            'leaverow.*.NoOfDays' => 'required',
        );

        $v2= Validator::make($request->all(), $rules);

        if ($validator->passes() && $v2->passes() && $request->leaverow != null){

            DB::beginTransaction();
            try
            {
                if ($request->file('DocumentUpload')) {
                    $file = $request->file('DocumentUpload');
                    $supportingdoc = "".time() . 'bimg.' . $request->file('DocumentUpload')->extension();
                    $pathIdentification = public_path() . '/storage/uploads/LeaveSupportingDocument';
                    $pathnameIdentification='/storage/uploads/LeaveSupportingDocument/'.$supportingdoc;
                    $file->move($pathIdentification, $supportingdoc);
                }
                if($request->file('DocumentUpload')==''){
                    $supportingdoc=$request->documentuploadfilelbl;
                }

                foreach ($request->leaverow as $key => $sumval){
                    $totalnumofday += $sumval['NoOfDays'];
                }

                $DbData = hr_leave::where('id', $findid)->first();
                $BasicVal = [
                    'requested_for' => $request->RequestFor,
                    'RequestedDate' => $request->RequestDate,
                    'LeaveDurationType' => $request->LeaveDurationType,
                    'LeaveFrom' => $request->LeaveFrom,
                    'LeaveTo' => $request->LeaveTo,
                    'NumberOfDays' => $totalnumofday,
                    'LeaveReason' => $request->LeaveReason,
                    'AddressDuringLeave' => $request->AddressDuringLeave,
                    'DocumentUpload' => $supportingdoc,
                    'EmergencyName' => $request->EmergencyName,
                    'EmergencyPhone' => $request->EmergencyPhone,
                    'EmergencyEmail' => $request->EmergencyEmail,
                    'Remark' => $request->Remark,
                ];

                $CreatedBy = ['LeaveID' => $leaveid,'Status' =>"Draft"];
                $LastUpdatedBy = ['updated_at' => Carbon::now()];

                $leavereq = hr_leave::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                foreach ($request->leaverow as $key => $value){
                    $existData = DB::table('hr_leave_transactions')
                        ->where('Year',$value['Year'])
                        ->where('hr_leavetypes_id',$value['LeaveType'])
                        ->where('employees_id',$leavereq->requested_for)
                        ->where('HeaderId',$leavereq->id)
                        ->whereIn('RecordType',["Void","Undo-Void"])
                        ->get();
                        
                    
                    $existcount = $existData->count();

                    $detailData = DB::table('hr_leaves_details')
                        ->where('Year',$value['Year'])
                        ->where('hr_leavetypes_id',$value['LeaveType'])
                        ->where('hr_leaves_id',$leavereq->id)
                        ->latest()
                        ->first();

                    $leavereqdetail[] = [
                        'hr_leaves_id' => $leavereq->id,
                        'hr_leavetypes_id' => $value['LeaveType'],
                        'Year' => $value['Year'],
                        'LeavePaymentType' => $value['LeavePaymentType'],
                        'RequireBalance' => $value['RequireBalance'],
                        'NumberOfDays' => $existcount == 0 ? $value['NoOfDays'] : $detailData->NumberOfDays,
                        'Remark' => $value['Remark'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }

                DB::table('hr_leaves_details')
                ->where('hr_leaves_details.hr_leaves_id',$leavereq->id)
                ->delete();

                DB::table('hr_leaves_details')->insert($leavereqdetail);        

                if($findid == null){
                    $actions = "Created";
                    DB::select('UPDATE settings SET LeaveNumber=LeaveNumber+1 WHERE id=1');
                    //$this->dispatch(new LeaveRequestJob($leavereq->id,1));
                }
                if($findid != null){
                    $actions = "Edited";

                    if($leavereq->Status == "Approved"){
                        $leavedatatransaction = [];
                        foreach ($request->leaverow as $key => $value){
                            $existData = DB::table('hr_leave_transactions')
                                ->where('Year',$value['Year'])
                                ->where('hr_leavetypes_id',$value['LeaveType'])
                                ->where('employees_id',$leavereq->requested_for)
                                ->where('HeaderId',$leavereq->id)
                                ->whereIn('RecordType',["Void","Undo-Void"])
                                ->where('ReferenceNumber',$leavereq->LeaveID)
                                ->get();
                            
                            $existcount = $existData->count();

                            $detailData = DB::table('hr_leaves_details')
                                ->join('hr_leaves','hr_leaves_details.hr_leaves_id','hr_leaves.id')
                                ->where('Year',$value['Year'])
                                ->where('hr_leavetypes_id',$value['LeaveType'])
                                ->where('hr_leaves_id',$leavereq->id)
                                ->orderBy('hr_leaves_details.created_at','DESC')
                                ->first();

                            $baseHeaderId = DB::table('hr_leave_transactions')
                                ->where('Year',$value['Year'])
                                ->where('hr_leavetypes_id',$value['LeaveType'])
                                ->where('employees_id',$leavereq->requested_for)
                                ->where('RecordType',"Allocation")
                                ->latest()
                                ->first();

                            if($value['RequireBalance'] == "Yes"){
                                $leavedatatransaction[] = [
                                    'HeaderId' => $findid,
                                    'employees_id' => $leavereq->requested_for,
                                    'hr_leavetypes_id' => $value['LeaveType'],
                                    'Year' => $value['Year'],
                                    'LeaveUsage' => $existcount == 0 ? $value['NoOfDays'] : $detailData->NumberOfDays,
                                    'Remark' => $value['Remark'],
                                    'RecordType' => "Requisition",
                                    'ReferenceNumber' => $leavereq->LeaveID,
                                    'Date' => $existcount == 0 ? Carbon::today()->toDateString() : $detailData->RequestedDate, 
                                    'BaseHeaderId' => !empty($baseHeaderId->HeaderId) ? $baseHeaderId->HeaderId : 0,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ];      
                            }                      
                        }

                        if(!empty($leavedatatransaction)){

                            DB::table('hr_leave_transactions')
                                ->where('hr_leave_transactions.HeaderId',$leavereq->id)
                                ->where('hr_leave_transactions.RecordType',"Requisition")
                                ->delete();

                            DB::table('hr_leave_transactions')->insert($leavedatatransaction);

                            $maxId = DB::table('hr_leave_transactions')->max('id');

                            $records = DB::table('hr_leave_transactions')
                                ->whereIn('RecordType',["Void","Undo-Void"])
                                ->where('hr_leave_transactions.HeaderId',$leavereq->id)
                                ->where('hr_leave_transactions.ReferenceNumber',$leavereq->LeaveID)
                                ->orderBy('created_at','ASC')
                                ->get();

                            foreach ($records as $index => $record) {
                                $newId = $maxId + $index + 1;

                                DB::table('hr_leave_transactions')
                                    ->where('id', $record->id)
                                    ->update(['id' => $newId]);
                            }
                        }
                    }     

                    //$this->dispatch(new LeaveRequestJob($findid,2));
                }

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$leavereq->id,'pagename'=>"leavemgt",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

                DB::commit();
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
        if($v2->fails()){
            return Response::json(['errorsv2'=> $v2->errors()]);
        }
        if($request->leaverow==null){
            return Response::json(['emptyerror'=> 462]);
        }
    }

    public function showleavecon($id){
        $bankcount=0;
        $cnt=0;

        $data = hr_leave::join('employees','hr_leaves.requested_for','=','employees.id')
                        ->join('branches', 'employees.branches_id', '=', 'branches.id')
                        ->join('departments', 'employees.departments_id', '=', 'departments.id')
                        ->join('positions', 'employees.positions_id', '=', 'positions.id')
                        ->join('employementtypes', 'employees.employementtypes_id', '=', 'employementtypes.id')
                        ->where('hr_leaves.id', $id)
                        ->get([
                                'hr_leaves.*','employees.name AS RequestedBy','employees.EmployeeID','employees.ActualPicture','employees.BiometricPicture',
                                'employees.Gender','employees.Status AS EmpStatus','branches.BranchName','departments.DepartmentName','positions.PositionName','employementtypes.EmploymentTypeName'
                            ]);

        $empatt = DB::table('attendance_summaries')->where('attendance_summaries.IsPayrollMade',1)->where('attendance_summaries.employees_id',$data[0]->requested_for)->latest()->first();
        $empdata = DB::table('employees')->where('employees.id',$data[0]->requested_for)->latest()->first();

        $mindate = $empatt != null ? $empatt->Date : $empdata->HiredDate;

        $leavefrom = Carbon::parse($data[0]->LeaveFrom);
        $days = floor($data[0]->NumberOfDays);
        $calculatedDate = $leavefrom;
        $daysCounted = 0;
        
        while ($daysCounted < $days) {
            $calculatedDate = $calculatedDate->addDay();
            
            // Check if this day is a working day (not holiday/day off)
            $isWorkDay = DB::table('shiftschedule_timetables')
                ->whereDate('Date', $calculatedDate)
                ->where('isworkday', 1)
                ->where('have_priority', 1)
                ->exists();
                
            if ($isWorkDay) {
                $daysCounted++;
            }
        }

        $leavetypedata=DB::select('SELECT hr_leaves_details.*,hr_leavetypes.LeaveType,(SELECT COUNT(hr_leave_transactions.id) FROM hr_leave_transactions WHERE hr_leave_transactions.HeaderId=hr_leaves_details.hr_leaves_id AND hr_leave_transactions.hr_leavetypes_id=hr_leaves_details.hr_leavetypes_id AND hr_leave_transactions.Year=hr_leaves_details.Year AND hr_leave_transactions.RecordType IN("Void","Undo-Void")) AS CountTransaction FROM hr_leaves_details LEFT JOIN hr_leavetypes ON hr_leaves_details.hr_leavetypes_id=hr_leavetypes.id WHERE hr_leaves_details.hr_leaves_id='.$id.' ORDER BY hr_leaves_details.id ASC');

        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"leavemgt")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['leavelist'=>$data,'leavetypedata'=>$leavetypedata,'activitydata'=>$activitydata,'mindate'=>$mindate,'end_date' => $calculatedDate->format('Y-m-d')]);       
    }

    public function leaveReqForwardAction(Request $request)
    {
        $approvedCount = 0;

        DB::beginTransaction();
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;

            $findid=$request->forwardReqId;
            $leavereq = hr_leave::find($findid);
            $currentStatus = $leavereq->Status;
            $newStatus=$request->newForwardStatusValue;
            $action=$request->forwardActionValue;

            if($newStatus == "Approved"){
                $leavedata = [];
                $getApprovedLeave=DB::select('SELECT COUNT(DISTINCT trs.hr_leavetypes_id) AS ApprovedLeave FROM hr_leaves_details AS trs INNER JOIN hr_leavetypes ON trs.hr_leavetypes_id=hr_leavetypes.id JOIN hr_leave_transactions AS trn ON (trs.hr_leavetypes_id = trn.hr_leavetypes_id) WHERE trs.hr_leaves_id='.$findid.' AND trs.RequireBalance="Yes" AND (SELECT COALESCE((SELECT SUM(COALESCE(LeaveEarned,0)) - SUM(COALESCE(LeaveUsage,0)) FROM hr_leave_transactions WHERE hr_leave_transactions.hr_leavetypes_id=trs.hr_leavetypes_id AND hr_leave_transactions.Year=trs.Year AND hr_leave_transactions.employees_id='.$leavereq->requested_for.'),0)-trs.NumberOfDays)<0');
                $approvedCount = $getApprovedLeave[0]->ApprovedLeave;

                $startDate = Carbon::parse($leavereq->LeaveFrom);
                $endDate = Carbon::parse($leavereq->LeaveTo);
                $period = CarbonPeriod::create($startDate, $endDate);
                
                if($approvedCount == 0){
                    $leavedetail = DB::table('hr_leaves_details')->where('hr_leaves_details.hr_leaves_id','=',$findid)->where('RequireBalance',"Yes")->get();
                    foreach($leavedetail as $row){
                        $baseHeaderId = DB::table('hr_leave_transactions')
                            ->where('Year',$row->Year)
                            ->where('hr_leavetypes_id',$row->hr_leavetypes_id)
                            ->where('employees_id',$leavereq->requested_for)
                            ->where('RecordType',"Allocation")
                            ->latest()
                            ->first();

                        $leavedata[] = [
                            'HeaderId' => $findid,
                            'employees_id' => $leavereq->requested_for,
                            'hr_leavetypes_id' => $row->hr_leavetypes_id,
                            'Year' => $row->Year,
                            'LeaveUsage' => $row->NumberOfDays,
                            'Remark' => $row->Remark,
                            'RecordType' => "Requisition",
                            'ReferenceNumber' => $leavereq->LeaveID,
                            'Date' => Carbon::today()->toDateString(),
                            'BaseHeaderId' => !empty($baseHeaderId->HeaderId) ? $baseHeaderId->HeaderId : 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }

                    if(!empty($leavedata)){
                        DB::table('hr_leave_transactions')->insertOrIgnore($leavedata);
                    }

                    if($leavereq->LeaveDurationType == "Consecutive"){
                        foreach ($period as $date) {
                            $this->targetService->checkAttendanceStatus($leavereq->requested_for,$date);
                        }
                    }
                    else if($leavereq->LeaveDurationType == "Non-Consecutive"){
                        foreach ($period as $ndate) {
                            $this->targetService->updateNonConsLeaveStatusB($leavereq->requested_for,$ndate);
                        }
                    }
                }
                if($approvedCount > 0){
                    $leavetypes = [];
                    $indx = 0;
                    $getErrorList=DB::select('SELECT hr_leavetypes.LeaveType,trs.Year FROM hr_leaves_details AS trs INNER JOIN hr_leavetypes ON trs.hr_leavetypes_id=hr_leavetypes.id JOIN hr_leave_transactions AS trn ON (trs.hr_leavetypes_id = trn.hr_leavetypes_id) WHERE trs.hr_leaves_id='.$findid.' AND trs.RequireBalance="Yes" AND (SELECT COALESCE((SELECT SUM(COALESCE(LeaveEarned,0)) - SUM(COALESCE(LeaveUsage,0)) FROM hr_leave_transactions WHERE hr_leave_transactions.hr_leavetypes_id=trs.hr_leavetypes_id AND hr_leave_transactions.Year=trs.Year AND hr_leave_transactions.employees_id='.$leavereq->requested_for.'),0)-trs.NumberOfDays)<0');
                    foreach($getErrorList as $row){
                        ++$indx;
                        $leavetypes[] = "{$indx}. <b>{$row->LeaveType}</b>, <b>{$row->Year}</b></br>";
                    }
                    return Response::json(['inserror' => 465,'insList'=>$leavetypes]);
                }
            }

            $leavereq->Status=$newStatus;
            $leavereq->save();

            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"leavemgt",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            
            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function leaveReqBackwardAction(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backwardReqId;
        $action=$request->backwardActionValue;
        $newStatus=$request->newBackwardStatusValue;
        $leavereq=hr_leave::find($findid);
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();

            try{
                if($leavereq->Status == "Approved"){
                    DB::table('hr_leave_transactions')
                    ->where('hr_leave_transactions.HeaderId',$findid)
                    ->where('hr_leave_transactions.RecordType',"Requisition")
                    ->delete();
                }

                $leavereq->Status=$newStatus;
                $leavereq->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"leavemgt",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->CommentOrReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
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

    public function showLeaveType(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        $leaveReqId = isset($_POST['recid']) ? $_POST['recid'] : [0];

        $query=DB::select('SELECT hr_leaves_details.*,hr_leavetypes.LeaveType FROM hr_leaves_details LEFT JOIN hr_leavetypes ON hr_leaves_details.hr_leavetypes_id=hr_leavetypes.id WHERE hr_leaves_details.hr_leaves_id='.$leaveReqId.' ORDER BY hr_leaves_details.id DESC');

        return datatables()->of($query)->addIndexColumn()->toJson();
    }

    public function showEmployeeData($id){
        $empatt = DB::table('attendance_summaries')->where('attendance_summaries.IsPayrollMade',1)->where('attendance_summaries.employees_id',$id)->latest()->first();
        $empdata = DB::table('employees')->where('employees.id',$id)->latest()->first();
        $leavedata = DB::table('hr_leaves')->where('hr_leaves.requested_for',$id)->latest()->first();

        $mindate = $leavedata != null ? $leavedata->LeaveTo : ($empatt != null ? $empatt->Date : $empdata->HiredDate);

        return response()->json(['mindate'=>$mindate]);
    }

    public function calcLeaveBalance(Request $request){
        $recordId= !empty($_POST['recordId']) ? $_POST['recordId'] : 0; 
        $leavetypedata=$_POST['leavetypedata']; 
        $leaveyeardata=$_POST['leaveyeardata']; 
        $employeedata=$_POST['employeedata']; 

        $leavebalancedata=DB::select('SELECT (SUM(COALESCE(hr_leave_transactions.LeaveEarned,0)) - SUM(COALESCE(hr_leave_transactions.LeaveUsage,0))) AS LeaveBalance FROM hr_leave_transactions WHERE hr_leave_transactions.hr_leavetypes_id='.$leavetypedata.' AND hr_leave_transactions.Year="'.$leaveyeardata.'" AND hr_leave_transactions.employees_id='.$employeedata);
        $leavebalancedatapending=DB::select('SELECT SUM(COALESCE(hr_leaves_details.NumberOfDays,0)) AS TotalNumberOfDays FROM hr_leaves_details LEFT JOIN hr_leaves ON hr_leaves_details.hr_leaves_id=hr_leaves.id WHERE hr_leaves_details.hr_leavetypes_id='.$leavetypedata.' AND hr_leaves_details.Year="'.$leaveyeardata.'" AND hr_leaves_details.RequireBalance="Yes" AND hr_leaves.requested_for='.$employeedata.' AND hr_leaves.Status IN("Draft","Pending","Verified")');
        $leavebalancesavedData=DB::select('SELECT SUM(COALESCE(hr_leaves_details.NumberOfDays,0)) AS TotalSavedNumOfDay FROM hr_leaves_details WHERE hr_leaves_details.hr_leavetypes_id='.$leavetypedata.' AND hr_leaves_details.RequireBalance="Yes" AND hr_leaves_details.Year="'.$leaveyeardata.'" AND hr_leaves_details.hr_leaves_id='.$recordId);
        
        $leavebalancetransaction = $leavebalancedata[0]->LeaveBalance ?? 0;
        $leavebalancepending = $leavebalancedatapending[0]->TotalNumberOfDays ?? 0;
        $leavebalancesaved = $leavebalancesavedData[0]->TotalSavedNumOfDay ?? 0;

        $leavebalance = ($leavebalancetransaction - $leavebalancepending) + $leavebalancesaved;
        $leavebalance = $leavebalance <= 0 ? 0 : $leavebalance;

        return response()->json(['leavebalance'=>$leavebalance]);
    }

    public function calcEndDate(Request $request)
    {
        $employeeid = $_POST['employeeid'];
        $leavefrom = Carbon::parse($_POST['leavefrom']);
        $days = ceil($_POST['totalday']);
        $calculatedDate = $leavefrom;
        $daysCounted = 0;

        $scheduledata = DB::table('shiftschedules')->where('shiftschedules.employees_id',$employeeid)->latest()->first();

        if($scheduledata == null){
            return response()->json(['emptyAssign' => 468]);
        }
        else if($scheduledata != null){
            $datevalues = explode(" to ",$scheduledata->Date);

            while ($daysCounted < $days) {
                // Check if this day is a working day (not holiday/day off)
                $isWorkDay = DB::table('shiftschedule_timetables')
                    ->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                    ->whereDate('shiftschedule_timetables.Date', $calculatedDate)
                    ->where('shiftschedule_timetables.isworkday', 1)
                    ->where('shiftschedule_timetables.have_priority', 1)
                    ->where('shiftschedules.employees_id', $employeeid)
                    ->exists();
                    
                if ($isWorkDay) {
                    $daysCounted++;
                }
                else if($calculatedDate->format('Y-m-d') > $datevalues[1]){
                    //if($calculatedDate->format('Y-m-d') > $datevalues[1]){
                        return response()->json(['assignError' => 468,'date' => $datevalues[1]]);
                    //}
                }
                $calculatedDate = $calculatedDate->addDay();
            }
            $originalDate = Carbon::parse($calculatedDate->format('Y-m-d'));
            $end_date = $originalDate->subDays(1)->format('Y-m-d');
        
            return response()->json(['end_date' => $end_date]);
        }
    }

    public function downloadLeaveDoc($ids,$file_name) 
    {
        $file_path = public_path('storage/uploads/LeaveSupportingDocument/'.$file_name);
        return response()->download($file_path);
    }

    public function approveLeaveReq(Request $request)
    {
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;
            $findid=$request->appId;
            $req=hr_leave::find($findid);
            $usr=User::find($req->requested_for);
            $empleave = DB::table('hr_employee_leaves')->where('hr_employee_leaves.employees_id',$usr->empid)->where('hr_employee_leaves.hr_leavetypes_id',$req->hr_leavetypes_id)->latest()->first();
            $req->Status="Approved";
            $req->approved_by=$userid;
            $req->ApprovedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');

            if($empleave->DepOnBalance==1){
                if($req->NumberOfDays > $empleave->LeaveBalance){
                    return Response::json(['errorins'=>462]);
                }
                else if($req->NumberOfDays <= $empleave->LeaveBalance){
                    $req->save();
                    
                    $updateleavebalance=DB::select('UPDATE hr_employee_leaves SET hr_employee_leaves.LeaveBalance=hr_employee_leaves.LeaveBalance-'.$req->NumberOfDays.' WHERE hr_employee_leaves.employees_id='.$usr->empid.' AND hr_employee_leaves.hr_leavetypes_id='.$req->hr_leavetypes_id);
                    //$this->dispatch(new LeaveRequestJob($findid,5));
                    return Response::json(['success' => '1']);
                }
            }
            else if($empleave->DepOnBalance==0){
                $req->save();
                //$this->dispatch(new LeaveRequestJob($findid,5));
                //$updateleavebalance=DB::select('UPDATE hr_employee_leaves SET hr_employee_leaves.LeaveBalance=hr_employee_leaves.LeaveBalance-'.$req->NumberOfDays.' WHERE hr_employee_leaves.employees_id='.$usr->empid.' AND hr_employee_leaves.hr_leavetypes_id='.$req->hr_leavetypes_id);
                return Response::json(['success' => '1']);
            }
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function rejectLeaveReq(Request $request)
    {
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;
            $findid=$request->rejId;
            $req=hr_leave::find($findid);
            $oldstatus=$req->Status;
            $usr=User::find($req->requested_for);
            $empleave = DB::table('hr_employee_leaves')->where('hr_employee_leaves.employees_id',$usr->empid)->where('hr_employee_leaves.hr_leavetypes_id',$req->hr_leavetypes_id)->latest()->first();
            
            $req->Status="Rejected";
            $req->rejected_by= $userid;
            $req->RejectedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $req->save();
            if($empleave->DepOnBalance==1 && $oldstatus=="Approved"){
                $updateleavebalance=DB::select('UPDATE hr_employee_leaves SET hr_employee_leaves.LeaveBalance=hr_employee_leaves.LeaveBalance+ '.$req->NumberOfDays.' WHERE hr_employee_leaves.employees_id='.$usr->empid.' AND hr_employee_leaves.hr_leavetypes_id='.$req->hr_leavetypes_id);
            }
            //$this->dispatch(new LeaveRequestJob($findid,7));
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function commentLeaveReq(Request $request)
    {
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;
            $findid=$request->commentid;
            $req=hr_leave::find($findid);
            $validator = Validator::make($request->all(), [
                'Comment'=>"required",
            ]);
            if ($validator->passes()) 
            {
                $req->Status="Commented";
                $req->commented_by=$userid;
                $req->CommentDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $req->Comment=$request->Comment;
                $req->save();
                //$this->dispatch(new LeaveRequestJob($findid,6));
                return Response::json(['success' => '1']);
            }
            else
            {
                return Response::json(['errors' => $validator->errors()]);
            }
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function voidLeaveReq(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->delidi;
        $leavereq=hr_leave::find($findid);
        $validator = Validator::make($request->all(), [
            'Reason' => 'required',
        ]);
        
        if($validator->passes())
        {
            DB::beginTransaction();
            try{
                $oldStatus = $leavereq->Status;
                $leavereq->Status= "Void({$leavereq->Status})";
                $leavereq->OldStatus=$oldStatus;
                
                if($oldStatus == "Approved"){
                    $leavedata = [];

                    $leavedetail = DB::table('hr_leaves_details')->where('hr_leaves_details.hr_leaves_id','=',$findid)->where('RequireBalance',"Yes")->get();
                    foreach($leavedetail as $row){
                        $baseHeaderId = DB::table('hr_leave_transactions')
                            ->where('Year',$row->Year)
                            ->where('hr_leavetypes_id',$row->hr_leavetypes_id)
                            ->where('employees_id',$leavereq->requested_for)
                            ->where('RecordType',"Allocation")
                            ->latest()
                            ->first();

                        $leavedata[] = [
                            'HeaderId' => $findid,
                            'employees_id' => $leavereq->requested_for,
                            'hr_leavetypes_id' => $row->hr_leavetypes_id,
                            'Year' => $row->Year,
                            'LeaveEarned' => $row->NumberOfDays,
                            'Remark' => $row->Remark,
                            'RecordType' => "Void",
                            'ReferenceNumber' => $leavereq->LeaveID,
                            'Date' => Carbon::today()->toDateString(),
                            'BaseHeaderId' => !empty($baseHeaderId->HeaderId) ? $baseHeaderId->HeaderId : 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }

                    if(!empty($leavedata)){
                        DB::table('hr_leave_transactions')->insertOrIgnore($leavedata);
                    }
                }

                $leavereq->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"leavemgt",'action'=>"Void",'status'=>"Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Reason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                //$this->dispatch(new LeaveRequestJob($findid,3));

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

    public function undoVoidLeaveReq(Request $request)
    {
        DB::beginTransaction();
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;
            $findid=$request->undovoidid;
            $leavereq=hr_leave::find($findid);

            $leavereq->Status=$leavereq->OldStatus;
            
            if($leavereq->OldStatus == "Approved"){
                $leavedata = [];
                $getApprovedLeave=DB::select('SELECT COUNT(DISTINCT trs.hr_leavetypes_id) AS ApprovedLeave FROM hr_leaves_details AS trs INNER JOIN hr_leavetypes ON trs.hr_leavetypes_id=hr_leavetypes.id JOIN hr_leave_transactions AS trn ON (trs.hr_leavetypes_id = trn.hr_leavetypes_id) WHERE trs.hr_leaves_id='.$findid.' AND trs.RequireBalance="Yes" AND (SELECT COALESCE((SELECT SUM(COALESCE(LeaveEarned,0)) - SUM(COALESCE(LeaveUsage,0)) FROM hr_leave_transactions WHERE hr_leave_transactions.hr_leavetypes_id=trs.hr_leavetypes_id AND hr_leave_transactions.Year=trs.Year AND hr_leave_transactions.employees_id='.$leavereq->requested_for.'),0)-trs.NumberOfDays)<0');
                $approvedCount = $getApprovedLeave[0]->ApprovedLeave;
                
                if($approvedCount == 0){
                    $leavedetail = DB::table('hr_leaves_details')->where('hr_leaves_details.hr_leaves_id','=',$findid)->where('RequireBalance',"Yes")->get();
                    foreach($leavedetail as $row){
                        $baseHeaderId = DB::table('hr_leave_transactions')
                            ->where('Year',$row->Year)
                            ->where('hr_leavetypes_id',$row->hr_leavetypes_id)
                            ->where('employees_id',$leavereq->requested_for)
                            ->where('RecordType',"Allocation")
                            ->latest()
                            ->first();

                        $leavedata[] = [
                            'HeaderId' => $findid,
                            'employees_id' => $leavereq->requested_for,
                            'hr_leavetypes_id' => $row->hr_leavetypes_id,
                            'Year' => $row->Year,
                            'LeaveUsage' => $row->NumberOfDays,
                            'Remark' => $row->Remark,
                            'RecordType' => "Undo-Void",
                            'ReferenceNumber' => $leavereq->LeaveID,
                            'Date' => Carbon::today()->toDateString(),
                            'BaseHeaderId' => !empty($baseHeaderId->HeaderId) ? $baseHeaderId->HeaderId : 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }

                    if(!empty($leavedata)){
                        DB::table('hr_leave_transactions')->insert($leavedata);
                    }
                }
                if($approvedCount > 0){
                    $leavetypes = [];
                    $indx = 0;
                    $getErrorList=DB::select('SELECT hr_leavetypes.LeaveType,trs.Year FROM hr_leaves_details AS trs INNER JOIN hr_leavetypes ON trs.hr_leavetypes_id=hr_leavetypes.id JOIN hr_leave_transactions AS trn ON (trs.hr_leavetypes_id = trn.hr_leavetypes_id) WHERE trs.hr_leaves_id='.$findid.' AND trs.RequireBalance="Yes" AND (SELECT COALESCE((SELECT SUM(COALESCE(LeaveEarned,0)) - SUM(COALESCE(LeaveUsage,0)) FROM hr_leave_transactions WHERE hr_leave_transactions.hr_leavetypes_id=trs.hr_leavetypes_id AND hr_leave_transactions.Year=trs.Year AND hr_leave_transactions.employees_id='.$leavereq->requested_for.'),0)-trs.NumberOfDays)<0');
                    foreach($getErrorList as $row){
                        ++$indx;
                        $leavetypes[] = "{$indx}. <b>{$row->LeaveType}</b>, <b>{$row->Year}</b></br>";
                    }
                    return Response::json(['inserror' => 465,'insList'=>$leavetypes]);
                }
            }

            $leavereq->save();

            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"leavemgt",'action'=>"Undo Void",'status'=>"Undo Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            //$this->dispatch(new LeaveRequestJob($findid,4));

            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function getLeaveBalance(Request $request){
        $empid=null;
        $reqfor = $request->RequestFor;
        $leavetype = $request->LeaveType;
        $usersprop = User::where('id', $reqfor)->first();
        $empid=$usersprop->empid;
        $leavedata = DB::table('hr_employee_leaves')->where('hr_employee_leaves.employees_id',$empid)->where('hr_employee_leaves.hr_leavetypes_id',$leavetype)->get();
        return response()->json(['leavedata'=>$leavedata]);
    }

    public function getLeaveDiff(Request $request){
        $holidays = [];
        $fdate = $request->LeaveFrom;
        $tdate = $request->LeaveTo;
        $reqfor = $request->RequestFor;
        $usersprop = User::where('id', $reqfor)->first();
        $emprop = employee::where('id',$usersprop->empid)->first();
        $datetimeone = Carbon::parse($fdate);
        $datetimetwo = Carbon::parse($tdate);

        $settings = DB::table('settings')->latest()->first();
        $fiscalyear=$settings->FiscalYear;
        
        if($emprop->EnableHoliday=="Yes"){
            $holidaydata = DB::table('holidays')->where('holidays.FiscalYear','=',$fiscalyear)->where('holidays.HolidayDate','>=',$fdate)->where('holidays.HolidayDate','<=',$tdate)->where('holidays.Status',"Active")->get(['HolidayDate']);
            foreach($holidaydata as $holidaydata){
                $holidays[]=$holidaydata->HolidayDate;
            }
        }
        

        $interval = $this->get_total_days($fdate, $tdate, $holidays); 
        return response()->json(['days'=>$interval]);
    }

    function get_total_days($start, $end, $holidays = [], $weekends = ['Sat', 'Sun']){
        $start = new \DateTime($start);
        $end   = new \DateTime($end);
        $end->modify('+1 day');

        $total_days = $end->diff($start)->days;
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

        foreach($period as $dt) {
            if (in_array($dt->format('D'),  $weekends) || in_array($dt->format('Y-m-d'), $holidays)){
                $total_days--;
            }
        }
        return $total_days;
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
