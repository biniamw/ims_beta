<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\actions;
use App\Models\attendance;
use App\Models\attendance_log;
use App\Models\attendance_summary;
use App\Models\employee;
use App\Models\timetable;
use App\Models\device;
use App\Models\mqttmessage;
use App\Models\attendance_import_log;
use App\Models\attendance_overtime;
use App\Models\shift_day_time;
use App\Models\shift_day;
use App\Models\shiftschedule_timetable;
use App\Models\shiftschedule;
use App\Models\shiftscheduledetail;
use App\Models\hr_leave;
use App\Models\hr_leaves_detail;
use App\Models\holiday;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AttendanceImport;
use App\Services\MqttService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\Examples\Shared\SimpleLogger;
use PhpMqtt\Client\Exceptions\MqttClientException;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Artisan;
use PhpMqtt\Client\MqttClient;
use Psr\Log\LogLevel;
use Image;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    protected $attdeviceid;
    protected $expectedcount;
    protected $logfrom;
    protected $logto;
    protected static $preventRecursion = false;

    public function index(Request $request)
    {
        //$this->checkAttendanceStatus(33,"2025-05-01");
        $settings = DB::table('settings')->latest()->first();

        $currentdate = Carbon::today()->format('d-M');
        $currentdatefullformat = Carbon::today()->toDateString();
        $devices = device::orderBy("DeviceName","ASC")->where("Status","Active")->where("id",'>',1)->get();
        $devicesexcel = device::orderBy("DeviceName","ASC")->where("Status","Active")->where("id",'>',1)->get();
        $monthlist = DB::select('SELECT DISTINCT DATE_FORMAT(CURDATE(),"%Y-%m") AS Months,DATE_FORMAT(CURDATE(),"%M-%Y") AS FullMonthFormat UNION SELECT DISTINCT DATE_FORMAT(attendance_summaries.Date,"%Y-%m") AS Months,DATE_FORMAT(attendance_summaries.Date,"%M-%Y") AS FullMonthFormat FROM attendance_summaries ORDER BY Months DESC');
        $branchlist = DB::select('SELECT DISTINCT branches.id,branches.BranchName,DATE_FORMAT(attendance_summaries.Date,"%Y-%m") AS Month FROM attendance_summaries LEFT JOIN employees ON attendance_summaries.employees_id=employees.id LEFT JOIN branches ON employees.branches_id=branches.id ORDER BY branches.BranchName ASC');
        $departmentlist = DB::select('SELECT DISTINCT departments.id,departments.DepartmentName,DATE_FORMAT(attendance_summaries.Date,"%Y-%m") AS Month FROM attendance_summaries LEFT JOIN employees ON attendance_summaries.employees_id=employees.id LEFT JOIN departments ON employees.departments_id=departments.id LEFT JOIN branches ON employees.branches_id=branches.id ORDER BY departments.DepartmentName ASC');
        if($request->ajax()) {
            return view('hr.attendance',['currentdate'=>$currentdate,'currentdatefullformat'=>$currentdatefullformat,
            'monthlist'=>$monthlist,'devices'=>$devices,'devicesexcel'=>$devicesexcel,'branchlist'=>$branchlist,'departmentlist'=>$departmentlist])->renderSections()['content'];
        }
        else{
            return view('hr.attendance',['currentdate'=>$currentdate,'currentdatefullformat'=>$currentdatefullformat,
            'monthlist'=>$monthlist,'devices'=>$devices,'devicesexcel'=>$devicesexcel,'branchlist'=>$branchlist,'departmentlist'=>$departmentlist]);
        }
    }

    public function getAttendanceData(Request $request){
        $month = $request->Month; // Format: YYYY-MM
        $daysInMonth = Carbon::parse($month)->daysInMonth;

        // Fetch attendance records for the selected month
        $attendance = attendance_summary::whereMonth('Date', Carbon::parse($month)->month)
            ->whereYear('Date', Carbon::parse($month)->year)
            ->get()
            ->groupBy('employees_id');
        
        // Fetch all active employees
        $employees = employee::where('Status', 'Active')->get(); 

        // Prepare response data
        $result = [];
        foreach ($employees as $employee) {
            $row = [
                'EmpId' => $employee->id,
                'EmployeeName' => $employee->name,
                'Photo' => $employee->ActualPicture,
            ];

            // Fill in attendance status for each day
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dateKey = Carbon::parse("$month-$day")->format('Y-m-d');
                $status = optional($attendance[$employee->id]->where('Date', $dateKey)->first())->Status ?? '-';
                $row["day_$day"] = $status;
            }

            $result[] = $row;
        }
    }

    public function getAllDays(){
        $user=Auth()->user();
        $month=$_POST['month']; 
        $daysInMonth = Carbon::parse($month)->daysInMonth;
        $year = Carbon::parse($month)->year;
        $currentyear = Carbon::now()->year;
        $dates = [];
        $fulldates = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::parse("$month-$day");
            $dates[] = $date->format('d-M');
            $fulldates[] = $date->format('d-F-Y');
        }

        // Fetch attendance records for the selected month
        $attendance = attendance_summary::whereMonth('Date', Carbon::parse($month)->month)
            ->whereYear('Date', Carbon::parse($month)->year)
            ->get()
            ->groupBy('employees_id');
        
        // Fetch all active employees
        $employees = employee::join('branches','employees.branches_id','=','branches.id')
            ->join('departments','employees.departments_id','=','departments.id')
            ->join('positions','employees.positions_id','=','positions.id')
            ->where('employees.EnableAttendance','Yes')
            ->where('employees.Status', 'Active')
            ->where('employees.id','>',1)
            ->orderBy('employees.name','asc')
            ->get(['employees.*','branches.BranchName','departments.DepartmentName','positions.PositionName']); 

        // Prepare response data
        $result = [];
        $rowindx = 0;
        foreach ($employees as $employee) {
            ++$rowindx;
            $row = [
                'RowNumber' => $rowindx,
                'EmpId' => $employee->id,
                'EmpCode' => $employee->EmployeeID,
                'EmployeeName' => $employee->name,
                'ActualPicture' => $employee->ActualPicture,
                'BiometricPicture' => $employee->BiometricPicture,
                'Branch' => $employee->BranchName,
                'Department' => $employee->DepartmentName,
                'Position' => $employee->PositionName, 
                'branches_id' => $employee->branches_id,
                'departments_id' => $employee->departments_id,
            ];

            // Fill in attendance status for each day
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dateKey = Carbon::parse("$month-$day")->format('Y-m-d');
                $status = isset($attendance[$employee->id]) ? optional($attendance[$employee->id]->where('Date', $dateKey)->first())->Status ?? '' : '';
                $offstatus = isset($attendance[$employee->id]) ? optional($attendance[$employee->id]->where('Date', $dateKey)->first())->OffShiftStatus ?? '' : '';
                $ishalfdayleave = isset($attendance[$employee->id]) ? optional($attendance[$employee->id]->where('Date', $dateKey)->first())->is_leave_half_day ?? '' : '';
                $row["day_$day"] = ($status == 12 || $status == 13 || $status == 15) ? (int)$status.$offstatus : ($status == 11 ? (int)$status.$ishalfdayleave : (int)$status);
            }
            
            $editln='';
            if($user->can('Attendance-Edit'))
            {
                $editln=' <a class="dropdown-item attendanceEdit" href="javascript:void(0)" data-id="'.$employee->id.'" id="attedit'.$employee->id.'" onclick="attendanceEditFn('.$employee->id.')" title="Edit attendance sheet"><i class="fa fa-edit"></i><span>  Manual Add/ Edit</span></a>';
            }
            $btn='<div class="btn-group dropleft" style="text-align:center;padding: 0px 0px 0px 0px;margin-left:-8px;">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item attendanceInfo" href="javascript:void(0)" data-id="'.$employee->id.'" id="attinfo'.$employee->id.'" onclick="attendanceInfo('.$employee->id.')" title="Open attendance information modal">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$editln.'
                    </div>
                </div>';

            $row["Action"] = $btn;

            $result[] = $row;
        }

        return Response::json(['data'=>$result,'days'=>$daysInMonth,'dates'=>$dates,'fulldayformat'=>$fulldates,'year'=>$year,'currentyear'=>$currentyear]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        ini_set('max_execution_time', '30000000');
        ini_set("pcre.backtrack_limit", "500000000");
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $currentime = Carbon::now()->format('H:i');
        $arraycontent=[];
        $dateval=[];
        $datevalelse=[];
        $payrollclosedemployees=[];
        $payrollclosedates=[];
        $getempnames="";
        $actualtimetable=0;
        $timeoptional=0;
        $data=[];
        $attdata=[];

        $arraycontent = explode(" - ",$request->AttendanceDateRange);

        $validator = Validator::make($request->all(), [
            'AttendanceDateRange' => 'required',
            'Time' => 'required|date_format:H:i',
            'PunchType' => 'required',
            'employees' => 'required',
        ]);

        if($validator->passes()){
            try
            {
                $dateval=[];
                $ispayrollclosed=0;
                $payrollclosedcnt=0;
                $daterange = CarbonPeriod::create($arraycontent[0],$arraycontent[1]);
                foreach($daterange as $daterange){
                    foreach($request->input('employees') as $row){
                        $datevalues=$daterange->format('Y-m-d');
                        
                        $att = attendance_summary::where('employees_id',$row)->where('Date',$datevalues)->latest()->first();
                        if(empty($att)){
                            $ispayrollclosed=0;
                        }
                        else if(!empty($att)){
                            $ispayrollclosed=$att->IsPayrollMade;
                        }

                        if($ispayrollclosed==1){
                            $payrollclosedemployees[]=$row;
                            $payrollclosedates[]=$datevalues;
                            $payrollclosedcnt+=1;
                        }
                        else{
                            $alltimetable=[];
                            $timetableid=1;
                            $timetabledata=DB::select('SELECT DISTINCT timetables_id FROM shiftschedule_timetables WHERE shiftschedule_timetables.shiftschedules_id=(SELECT shiftschedules.id FROM shiftschedules WHERE shiftschedules.employees_id='.$row.') AND shiftschedule_timetables.Date="'.$datevalues.'"');
                            
                            foreach($timetabledata as $timetabledata){
                                $alltimetable[]=$timetabledata->timetables_id;
                            }
                            $gettimetableid = timetable::whereIn('id',$alltimetable)->whereBetween(DB::raw("'$request->Time'"),[DB::raw('BeginningIn'),DB::raw('timetables.EndingOut')])->latest()->first();
                            if(empty($gettimetableid)){
                                $timetableid=1;
                            }
                            else if(!empty($gettimetableid)){
                                $timetableid=$gettimetableid->id;
                            }

                            if($timetableid==1){
                                $timetablecnt=0;
                                $timetabledatacnt=DB::select('SELECT COUNT(timetables_id) AS TimetableCount FROM shiftschedule_timetables WHERE shiftschedule_timetables.shiftschedules_id=(SELECT shiftschedules.id FROM shiftschedules WHERE shiftschedules.employees_id='.$row.') AND shiftschedule_timetables.timetables_id!=1 AND shiftschedule_timetables.Date="'.$datevalues.'"');
                                foreach($timetabledatacnt as $timetabledatacnt){
                                    $timetablecnt=$timetabledatacnt->TimetableCount;
                                }

                                if($timetablecnt>=1){
                                    $actualtimetable=0;
                                    $timeoptional=0;
                                }
                                else{
                                    $actualtimetable=0;
                                    $timeoptional=5;
                                }
                            }
                            else if($timetableid!=1){
                                $actualtimetable=0;
                                $timeoptional=0;
                            }
                            
                            $data[]=[
                                'employees_id' => $row,
                                'timetables_id' => $timetableid,
                                'Date' => $datevalues,
                                'Time' => $request->Time,
                                'PunchType' => $request->PunchType,
                                'AttType' => 1,
                                'CreatedBy' => $user,
                                'CreatedDate' => Carbon::now(),
                                'Remark' => $request->Remark,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ];
                        }
                    }
                }

                if($payrollclosedcnt>0){
                    for($i=0;$i<$payrollclosedcnt;$i++){
                        $getempnames=DB::select('SELECT DISTINCT employees.name,"'.$payrollclosedates[$i].'" AS Date FROM employees WHERE employees.id='.$payrollclosedemployees[$i]);
                    }
                    return Response::json(['perror'=>462,'getempnames'=>$getempnames]);
                }
                else if($payrollclosedcnt == 0){
                    
                    $this->syncAttendanceLog($data,1);

                    $daterangeatt = CarbonPeriod::create($arraycontent[0],$arraycontent[1]);
                    foreach($daterangeatt as $daterangeatt){
                        foreach($request->input('employees') as $row){
                            $datevalues=$daterangeatt->format('Y-m-d');
                            $this->checkAttendanceStatus($row,$datevalues);
                        }
                    }

                    return Response::json(['success' =>1]);
                }
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
    }

    public function updateAtt(Request $request)
    {
        ini_set('max_execution_time', '30000000');
        ini_set("pcre.backtrack_limit", "500000000");
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $currentime = Carbon::now()->format('H:i');
        $currentdate = Carbon::today()->toDateString();
        $arraycontent=[];
        $dateval=[];
        $datevalelse=[];
        $payrollclosedemployees=[];
        $payrollclosedates=[];
        $getempnames="";
        $actualtimetable=0;
        $timeoptional=0;
        $dataid=[];
        $alldataid=[];
        $data=[];
        $alldateval=[];
        $allpayrollofdate=[];
        $employeeidval=$request->employeeidval;
        $dateformat=$request->fulldayformatval;

        $rules=array(
            'row.*.EditTime' => 'required',
            'row.*.PunchType' => 'required',
        );
        $v2= Validator::make($request->all(), $rules);

        if ($v2->passes() && $request->row!=null)
        {
            try{
                $month=Carbon::parse($dateformat)->format('Y-m');
                $start = Carbon::parse($month)->startOfMonth();
                $end = Carbon::parse($month)->endOfMonth();

                $daterangepayroll = CarbonPeriod::create($start,$end);
                foreach($daterangepayroll as $daterangepayroll){
                    $attpayrolloffdata = DB::select('SELECT attendance_summaries.IsPayrollMade 
                        FROM attendance_summaries 
                        WHERE attendance_summaries.employees_id = ? 
                        AND DATE(attendance_summaries.Date) = ?', 
                        [$employeeidval, Carbon::parse($daterangepayroll)->format('Y-m-d')]
                    );

                    // Check if any record exists
                    if (!empty($attpayrolloffdata)) {
                        if($attpayrolloffdata[0]->IsPayrollMade != 1){
                            $allpayrollofdate[] = Carbon::parse($daterangepayroll)->format('Y-m-d');
                        }
                    } 
                    else {
                        $allpayrollofdate[] = Carbon::parse($daterangepayroll)->format('Y-m-d');
                    }
                }

                foreach ($request->row as $key => $value)
                {
                    $time=$value['EditTime'];
                    $punchtype=$value['PunchType'];
                    $remark=$value['Remark'];
                    $datevalues=$value['Date'];
                    $attendancetype=$value['AttendanceType'];
                    $alldataid[]=$value['id'];
                    
                    $alltimetable=[];
                    $timetableid=1;
                    $timetabledata=DB::select('SELECT DISTINCT timetables_id FROM shiftschedule_timetables WHERE shiftschedule_timetables.shiftschedules_id=(SELECT shiftschedules.id FROM shiftschedules WHERE shiftschedules.employees_id='.$employeeidval.') AND shiftschedule_timetables.have_priority=1 AND shiftschedule_timetables.Date="'.$datevalues.'"');
                    foreach($timetabledata as $timetabledata){
                        $alltimetable[]=$timetabledata->timetables_id;
                    }
                    $gettimetableid = timetable::whereIn('id',$alltimetable)->whereBetween(DB::raw("'$time'"),[DB::raw('timetables.BeginningIn'),DB::raw('timetables.EndingOut')])->latest()->first();
                    if(empty($gettimetableid)){
                        $timetableid=1;
                    }
                    else if(!empty($gettimetableid)){
                        $timetableid=$gettimetableid->id;
                    }

                    $data[]=[
                        'employees_id' => $employeeidval,
                        'timetables_id' => $timetableid,
                        'Date' => $datevalues,
                        'Time' => $time,
                        'PunchType' => $punchtype,
                        'AttType' => $attendancetype,
                        'LastEditedBy' => $user,
                        'LastEditedDate' => Carbon::now(),
                        'Remark' => $remark,
                        'updated_at' => Carbon::now()
                    ];    
                }

                $fulldates = [];

                $this->syncAttendanceLog($data,2);

                $dates = [];
                $attdata = [];
                $monthdates=null;

                $daterangeatt = CarbonPeriod::create($start,$end);
                foreach($daterangeatt as $daterangeatt){
                    if($daterangeatt->format('Y-m-d') <= $currentdate){
                        if(in_array($daterangeatt->format('Y-m-d'),$allpayrollofdate)){
                            $this->checkAttendanceStatus($employeeidval,$daterangeatt->format('Y-m-d'));
                        }
                    }
                }

                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }

        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }

        if($request->row==null)
        {
            return response()->json(['dynamictblerror'=> $v2->errors()->all()]);
        }
        
    }

    public function syncAttendanceLog($data,$optypeflg) {
        $idsToKeep = [];
        $employeeIdArr = [];
        $timeTableArr = [];
        $dateArr = [];
        $timeArr = [];
        $punchTypeArr = [];
        $attTypeArr = [];

        DB::beginTransaction();

        try {
            if($optypeflg == 2){
                $firstItem = collect($data)->first();
                DB::table('attendance_logs')
                    ->whereRaw("DATE_FORMAT(attendance_logs.Date, '%Y-%m') = ?", [Carbon::parse($firstItem['Date'])->format('Y-m')])
                    ->where('attendance_logs.employees_id', $firstItem['employees_id'])
                    //->where('attendance_logs.AttType', 1)
                    ->delete();
            }

            foreach ($data as $record) {
                // Define unique identifiers (adjust based on your table structure)

                //if($record['AttType'] == 1){
                    DB::table('attendance_logs')->insertOrIgnore($record);
                //}  
            }

            // Commit transaction
            DB::commit();
        }
        catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            throw $e;
        }
    }

    public function updateNonConsLeaveStatus($curdate){
        $attendacesumm = DB::select('SELECT attendance_summaries.id,attendance_summaries.employees_id FROM attendance_summaries WHERE attendance_summaries.Date="'.$curdate.'" AND attendance_summaries.Status=1');
        foreach($attendacesumm as $row){
            $leavedata = DB::select('SELECT * FROM hr_leaves WHERE "'.$curdate.'" BETWEEN hr_leaves.LeaveFrom AND hr_leaves.LeaveTo AND hr_leaves.LeaveDurationType="Non-Consecutive" AND hr_leaves.Status="Approved" AND hr_leaves.requested_for='.$row->employees_id);

            $leave_from = $leavedata[0]->LeaveFrom ?? "";
            $leave_to = $leavedata[0]->LeaveTo ?? "";
            $no_of_days = ceil($leavedata[0]->NumberOfDays ?? 0);

            $attendance_count = DB::select('SELECT COUNT(attendance_summaries.id) AS utilized_leave FROM attendance_summaries WHERE attendance_summaries.Date BETWEEN "'.$leave_from.'" AND "'.$leave_to.'" AND attendance_summaries.employees_id='.$row->employees_id.' AND attendance_summaries.Status=11');
            $utilized_leave = $attendance_count[0]->utilized_leave;

            if($utilized_leave <= $no_of_days && $no_of_days > 0){
                DB::table('attendance_summaries')->where('attendance_summaries.id',$row->id)->update(['Status'=>11]);
            }
        }
    }

    public function updateNonConsLeaveStatusB($empid,$date){
        $attendacesumm = DB::select('SELECT attendance_summaries.id,attendance_summaries.employees_id FROM attendance_summaries WHERE attendance_summaries.Date="'.$date.'" AND attendance_summaries.employees_id='.$empid.' AND attendance_summaries.Status=1');
        foreach($attendacesumm as $row){
            $leavedata = DB::select('SELECT * FROM hr_leaves WHERE "'.$date.'" BETWEEN hr_leaves.LeaveFrom AND hr_leaves.LeaveTo AND hr_leaves.LeaveDurationType="Non-Consecutive" AND hr_leaves.Status="Approved" AND hr_leaves.requested_for='.$row->employees_id);

            $leave_from = $leavedata[0]->LeaveFrom ?? "";
            $leave_to = $leavedata[0]->LeaveTo ?? "";
            $no_of_days = ceil($leavedata[0]->NumberOfDays ?? 0);

            $attendance_count = DB::select('SELECT COUNT(attendance_summaries.id) AS utilized_leave FROM attendance_summaries WHERE attendance_summaries.Date BETWEEN "'.$leave_from.'" AND "'.$leave_to.'" AND attendance_summaries.employees_id='.$row->employees_id.' AND attendance_summaries.Status=11');
            $utilized_leave = $attendance_count[0]->utilized_leave;

            if($utilized_leave <= $no_of_days && $no_of_days > 0){
                DB::table('attendance_summaries')->where('attendance_summaries.id',$row->id)->update(['Status'=>11]);
            }
        }
    }

    public function checkAttendanceStatus($employeeId, $date){

        $statusSummary = null;
        $data = [];

        $this->updateAttendanceLogs($employeeId,$date);

        $this->handleNightShiftPunches($employeeId,$date);

        $timetables = shiftschedule_timetable::join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
            ->join('employees','shiftschedules.employees_id','employees.id')
            ->join('timetables','shiftschedule_timetables.timetables_id','timetables.id')
            ->join('shifts','shiftschedule_timetables.shifts_id','shifts.id')
            ->where('shiftschedules.employees_id', $employeeId)
            ->where(DB::raw('DATE(shiftschedule_timetables.Date)'), $date)
            ->where('shiftschedule_timetables.have_priority',1)
            ->get(['shiftschedule_timetables.*','employees.id AS EmpId']);

        // Fetch all punch records
        $attendances = attendance_log::where('attendance_logs.employees_id', $employeeId)
            ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
            ->where('is_in_range',1)
            ->orderBy('attendance_logs.Time', 'asc')
            ->get();

        // Check if employee is on leave
        $leave = hr_leave::where('hr_leaves.requested_for', $employeeId)
            ->whereBetween(DB::raw("'$date'"), [DB::raw('DATE(hr_leaves.LeaveFrom)'),DB::raw('DATE(hr_leaves.LeaveTo)')])
            ->where('hr_leaves.LeaveDurationType', 'Consecutive')
            ->where('hr_leaves.Status', 'Approved')
            ->exists();  

        $leave_data = hr_leave::where('hr_leaves.requested_for', $employeeId)
                ->whereBetween(DB::raw("'$date'"), [DB::raw('DATE(hr_leaves.LeaveFrom)'),DB::raw('DATE(hr_leaves.LeaveTo)')])
                ->where('hr_leaves.LeaveDurationType', 'Consecutive')
                ->where('hr_leaves.Status', 'Approved')
                ->get();  

        $num_of_days = ceil($leave_data[0]->NumberOfDays ?? 0);
        $from_leave_date = $leave_data[0]->LeaveFrom ?? "";
        $to_leave_date = $leave_data[0]->LeaveTo ?? "";
        $leave_duration = $leave_data[0]->LeaveDurationType ?? "";

        $statuses = [];

        $offftime = [];

        $totalworkinghr = 0;
        $totalbreaktime = 0;
        $totalbeforeot = 0;
        $totalafterot = 0;
        $totalot = 0;
        $totallatechekinhr = 0;
        $totallatechekouthr = 0;
        $totalbeforeondutytime = 0;
        $totalafteroffdutytime = 0;
        $breakDuration = 0;
        $offShiftOvertime = 0;
        $offShiftOvertimeLevelPercent = 0;

        foreach ($timetables as $timetable) {
            
            $shiftscheuledata = shiftscheduledetail::where('id',$timetable->shiftscheduledetails_id)->first();
            $timetabledata = timetable::where('id',$timetable->timetables_id)->first();
            $attendancescount = attendance_log::where('attendance_logs.employees_id', $employeeId)
            ->where('attendance_logs.timetables_id',$timetable->timetables_id)
            ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
            ->where('is_in_range',1)
            ->orderBy('attendance_logs.Time', 'asc')
            ->get();
            
            $requiredPunches = ($timetabledata->PunchingMethod == 4) ? 4 : 2;
            if ($attendancescount->count() < $requiredPunches && $attendancescount->count() > 0) {
                $statuses[] = 8; //'Incomplete Punch';
                //continue;
            }

            $firstPunchRecord = $attendancescount->where('PunchType', 1)->first();
            $firstPunch = $firstPunchRecord ? strtotime($firstPunchRecord->Time) : null;

            // Get last punch where PunchType = 2
            $lastPunchRecord = $attendancescount->where('PunchType', 2)->last();
            $lastPunch = $lastPunchRecord ? strtotime($lastPunchRecord->Time) : null;

            $beginningIn =  $timetabledata->id != 1 ? strtotime($timetabledata->BeginningIn) : $firstPunch;
            $beginningOut =  $timetabledata->id != 1 ? strtotime($timetabledata->BeginningOut) : $lastPunch;
            $endingOut = $timetabledata->id != 1 ? strtotime($timetabledata->EndingOut) : $lastPunch;
            $onDuty = $timetabledata->id != 1 ? strtotime($timetabledata->OnDutyTime) : $firstPunch;
            $offDuty = $timetabledata->id != 1 ? strtotime($timetabledata->OffDutyTime) : $lastPunch;
            $endingIn = $timetabledata->id != 1 ? strtotime($timetabledata->EndingIn) : $lastPunch;
            $overtimeStart = strtotime($timetabledata->OvertimeStart);
            $breakStartTime = strtotime($timetabledata->BreakStartTime);
            $breakEndTime = strtotime($timetabledata->BreakEndTime);
            $breakDurationMinute = $timetabledata->BreakHour ?? 0;

            $isnightshift = $timetabledata->is_night_shift ?? 0;
            $breaktimewt = $timetabledata->BreakTimeAsWorkTime ?? 0;
            $breaktimeot = $timetabledata->BreakTimeAsOvertime ?? 0;

            //flag to catch present
            $isPresent = true;

            // **No Check-In Handling**
            if (!$firstPunch) {
                $statuses[] = $timetabledata->NoCheckInFlag == 1 ? 1 : 4; //1 Absent 4 Late checkIn
                //continue;
            }

            // **No Check-Out Handling**
            if (!$lastPunch) {
                $statuses[] = $timetabledata->NoCheckOutFlag == 1 ? 1 : 6; //'Absent' : 'Early';
                //continue;
            }

            // **Check-In Late for X min → Mark as Absent**
            if ($firstPunch > $onDuty + ($timetabledata->CheckInLateMinute == null ? ($endingIn - $onDuty) : $timetabledata->CheckInLateMinute * 60)) {
                $statuses[] = 1; //'Absent';
                $isPresent = false;
                //continue;
            }

            // **Check-Out Early for X min → Mark as Absent**
            if ($lastPunch < $offDuty - ($timetabledata->CheckOutEarlyMinute == null ? ($offDuty - $beginningOut) : $timetabledata->CheckOutEarlyMinute * 60)) {
                $statuses[] = 1; //'Absent';
                $isPresent = false;
                //continue;
            }            

            // **Late Check-In**
            if (!is_null($firstPunch) && ($firstPunch > $onDuty + ($timetabledata->LateTime * 60))) {
                
                if($firstPunch <= $endingIn){
                    $statuses[] = 4; //'Late-CheckIn';
                    $lateCheckinMinutes = round(($firstPunch - $onDuty) / 60);
                    $totallatechekinhr += $lateCheckinMinutes;
                }
                $isPresent = false;
            }

            if (!is_null($firstPunch) && ($firstPunch < $onDuty)) {
                if ($timetabledata->EarlyCheckInOvertime == 1 && $shiftscheuledata->EffectiveOt == 1) {
                    $statuses[] = 5; //'Early-CheckIn (Overtime)';
                } else {
                    $statuses[] = 5; //'Early-CheckIn';
                }
                $beforeondutytime = round((($onDuty - $firstPunch) / 60),2);
                $totalbeforeondutytime += $beforeondutytime;
            }

            // **Mark Present if no Late, Early, or Absent status is assigned**
            if ($isPresent && !in_array(4, $statuses) && !in_array(6, $statuses)) {
                $statuses[] = 2; //'Present';
            }

            if ($shiftscheuledata->CheckInNotReq == 1 && $shiftscheuledata->CheckOutNotReq == 1) {
                $statuses[] = 2; //'Present'; // No punches required, automatically present
            }

            if ($shiftscheuledata->CheckInNotReq == 1 && !empty($punchTimes)) {
                $statuses[] = 2; //'Present'; // Check-in not required but has check-out
            }

            if ($shiftscheuledata->CheckOutNotReq == 1 && !empty($punchTimes)) {
                $statuses[] = 2; //'Present'; // Check-out not required but has check-in
            }

            // **Off-Shift Detection**
            $countOffShiftTimetable = DB::table('shiftschedule_timetables')
                ->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                ->join('employees','shiftschedules.employees_id','employees.id')
                ->where(DB::raw('DATE(shiftschedule_timetables.Date)'), $date)
                ->where('shiftschedules.employees_id', $employeeId)
                ->where('shiftschedule_timetables.have_priority',1)
                ->where('shiftschedule_timetables.timetables_id',1)
                ->distinct('timetables_id')
                ->count('timetables_id');

            $unassignedPunches = attendance_log::where('attendance_logs.employees_id', $employeeId)
                ->where('attendance_logs.timetables_id',1)
                ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
                ->exists();
            
            $countOffShift = attendance_log::where('attendance_logs.employees_id', $employeeId)
                ->where('attendance_logs.timetables_id',1)
                ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
                ->count();

            $countAllShift = attendance_log::where('attendance_logs.employees_id', $employeeId)
                ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
                ->count();
            
            $checkWorkOnLeave = attendance_log::where('attendance_logs.employees_id', $employeeId)
                ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
                ->exists();

            if ($countOffShiftTimetable > 0 && $countOffShift > 0) {
                $statuses=[];
                $statuses[] = 13; //'Off Shift (Unscheduled Punch)';
            }

            if (!$checkWorkOnLeave) {
                if ($leave) {
                    $statuses=[];
                    $statuses[] = 11; //'On Leave';
                }
            }

            if ($checkWorkOnLeave) {
                if ($leave) {
                    $statuses=[];
                    $statuses[] = 12; //'Works-On-Leave';
                }
            }

            if($timetable->isworkday == 3){
                if(!$checkWorkOnLeave){
                    $statuses=[];
                    $statuses[] = 10; //"Holiday";
                }
                if($checkWorkOnLeave){
                    $statuses=[];
                    $statuses[] = 15; //"Works on Holiday";
                }
            }

            if(!$checkWorkOnLeave && $timetable->isworkday == 2){
                $statuses=[];
                $statuses[] = 9; //"Day Off";
            }

            if(empty($statuses)){
                $statuses[] = 11; //"Absent";
            }

            $offshiftot = 0;
            if($checkWorkOnLeave && $timetable->isworkday == 3 && $shiftscheuledata->EffectiveOt == 1){
                $offshiftot = $lastPunch - $firstPunch;
                $offShiftOvertimeLevelPercent = $holidayData->WorkhourRate;
            }

            $logs = DB::table('attendance_logs')
                ->where('employees_id', $employeeId)
                ->whereDate('Date', $date)
                ->where('is_in_range',1)
                ->where('timetables_id',$timetabledata->id)
                ->orderBy('Time')
                ->get();

            $workingHours = 0;
            $breakMinutes = 0;
            $lastPunchOutTime = null;
            $lastPunchInTime = null;
            $entries = [];

            if($timetabledata->id == 1){
                $punchType = 1;
                
                foreach ($logs as $log) {
                    DB::table('attendance_logs')
                    ->where('id', $log->id)
                    ->update(['PunchType' => $punchType]);

                    if ($punchType == 1) { // Punch-In
                        if ($lastPunchOutTime) {
                            // Calculate Break Time (Time between last Punch-Out and current Punch-In)
                            $breakMinutes += (strtotime($log->Time) - strtotime($lastPunchOutTime)) / 60;
                        }
                        $lastPunchInTime = $log->Time;
                        
                    } elseif ($punchType == 2 && $lastPunchInTime) { // Punch-Out with a valid Punch-In
                        // Calculate Work Hours (Time between last Punch-In and this Punch-Out)
                        
                        $workingHours += (strtotime($log->Time) - strtotime($lastPunchInTime)) / 60;
                        $lastPunchOutTime = $log->Time;
                        $lastPunchInTime = null; // Reset to wait for the next Punch-In
                    }
                    $punchType = $punchType === 1 ? 2 : 1;
                }
            }

            if($timetabledata->PunchingMethod == 2){
                $firstpunchtime = 0;
                foreach ($logs as $log) {
                    $time = strtotime($log->Time);
                    if ($log->PunchType == 1) { // Punch-In
                        $firstpunchtime = $time > ($onDuty + ($timetabledata->LateTime * 60)) ? $time : $onDuty;
                        $lastPunchInTime = $firstpunchtime;
                    } elseif ($log->PunchType == 2 && $lastPunchInTime) { // Punch-Out with a valid Punch-In
                        // Calculate Work Hours (Time between last Punch-In and this Punch-Out)
                        $lastpunchout = $time < ($offDuty - ($timetabledata->LeaveEarlyTime * 60)) ? $time : $offDuty;
                        $workingHours += ($lastpunchout - $lastPunchInTime) / 60;
                        $lastPunchOutTime = $lastpunchout;
                        $lastPunchInTime = null; // Reset to wait for the next Punch-In

                        if($breaktimewt == 0 && $breaktimeot == 0){
                            $workingHours = $workingHours - $breakDurationMinute;
                            $breakMinutes += $breakDurationMinute;
                        }

                        if ($lastpunchout < $offDuty - ($timetabledata->LeaveEarlyTime * 60)) {
                            $statuses[] = 6; //'Early-CheckOut';
                            $earlyCheckoutMinutes = round(($offDuty - $lastPunch) / 60);
                            $totallatechekouthr += $earlyCheckoutMinutes;
                            $isPresent = false;
                        }

                        if ($time > $offDuty) {
                            $afterondutytime = round(($time - $offDuty) / 60);
                            $totalafteroffdutytime += $afterondutytime;
                        }
                    }
                }
            }

            if($timetabledata->PunchingMethod == 4){
                $firstpunchtime = 0;
                $punchinfrombreak = 0;
                $punchouttobreak = 0;
                $punchinfrombreakcalc = 0;
                $earlycheckoutmin = 0;
                $latecheckoutminute = 0;
                $earlycheckoutminlastpuch = 0;
                $breaktimeearlycheckin = 0;
                foreach ($logs as $log) {
                    $time = strtotime($log->Time);
                    if ($time >= $beginningIn && $time <= $endingIn) {
                        $firstpunchtime = $time > ($onDuty + ($timetabledata->LateTime * 60)) ? $time : $onDuty;
                    }
                    elseif ($time >= $endingIn && $time <= $beginningOut) {
                        if($firstpunchtime > 0 && $log->PunchType == 2){
                            if($timetabledata->BreakHourFlag == 0){
                                $punchouttobr = $time < ($breakStartTime - ($timetabledata->LeaveEarlyTimeBreak * 60)) ? $time : $breakStartTime;
                                $workingHours += (($punchouttobr > $breakStartTime ? $breakStartTime : $punchouttobr) - $firstpunchtime) / 60;
                                
                                if ($punchouttobr < $breakStartTime) {
                                    $earlyBreakCheckoutMinutes = round(($breakStartTime - $punchouttobr) / 60);
                                    $totallatechekouthr += $earlyBreakCheckoutMinutes;
                                    $earlycheckoutmin = $totallatechekouthr;
                                    $statuses[] = 6; //'Early-CheckOut';
                                    $isPresent = false;
                                }
                            }
                            if($timetabledata->BreakHourFlag == 1){
                                $workingHours += ($time - $firstpunchtime) / 60;
                            }
                        }
                        if($log->PunchType == 1){
                            if($timetabledata->BreakHourFlag == 0){
                                $punchinfrombreakcalc = $time > $breakEndTime + ($timetabledata->LateTimeBreak * 60) ? $time : $breakEndTime;
                                $punchinfrombreak = $time;
                            }
                            if($timetabledata->BreakHourFlag == 1){
                                $punchinfrombreak = $time;
                            }
                        }
                        if($log->PunchType == 2){
                            if($timetabledata->BreakHourFlag == 0){
                                $punchouttobreak = $time;
                                if ($punchouttobreak > $breakStartTime) {
                                    $afterondutytime = round(($punchouttobreak - $breakStartTime) / 60);
                                    if($breaktimewt == 0 && $breaktimeot == 0){
                                        $totalafteroffdutytime += $afterondutytime;
                                        $latecheckoutminute = $totalafteroffdutytime;
                                    }
                                }
                            }
                            if($timetabledata->BreakHourFlag == 1){
                                $punchouttobreak = $time;
                            }
                        }
                        if($punchinfrombreak > 0 && $punchouttobreak > 0){
                            $breakMinutes += ($punchinfrombreak - $punchouttobreak) / 60;
                            if($timetabledata->BreakHourFlag == 0){
                                if ($punchouttobreak < $breakStartTime - ($timetabledata->LeaveEarlyTimeBreak * 60)) {
                                    $earlyBreakCheckoutMinutes = round(($breakStartTime - $punchouttobreak) / 60);
                                    $totallatechekouthr += $earlyBreakCheckoutMinutes;
                                    $totallatechekouthr = $totallatechekouthr - $earlycheckoutmin;
                                    $earlycheckoutminlastpuch = $totallatechekouthr;
                                    $statuses[] = 6; //'Early-CheckOut';
                                    $isPresent = false;
                                }
                                if ($punchinfrombreak > $breakEndTime + ($timetabledata->LateTimeBreak * 60)) {
                                    $earlyBreakCheckinMinutes = round(($punchinfrombreak - $breakEndTime) / 60);
                                    $totallatechekinhr += $earlyBreakCheckinMinutes;
                                    $statuses[] = 4; //'Late-CheckIn';
                                    $isPresent = false;
                                }
                                if ($punchinfrombreak > $breakStartTime && $punchinfrombreak < $breakEndTime) {
                                    $beforeondutytime = round((($breakEndTime - $punchinfrombreak) / 60),2);
                                    if($breaktimewt == 1){
                                        $workingHours += $beforeondutytime;
                                    }
                                    else if($breaktimewt == 0 && $breaktimeot == 0){
                                        $totalbeforeondutytime += $beforeondutytime;
                                    }
                                }
                                if ($punchouttobreak > $breakStartTime) {
                                    $afterondutytime = round(($punchouttobreak - $breakStartTime) / 60);
                                    if($breaktimewt == 1){
                                        $workingHours += $afterondutytime;
                                    }
                                    else if($breaktimewt == 0 && $breaktimeot == 0){
                                        $totalafteroffdutytime += $afterondutytime;
                                        $totalafteroffdutytime = $totalafteroffdutytime - $latecheckoutminute; //to dedut before half day
                                    }
                                    
                                }
                            }
                            if($timetabledata->BreakHourFlag == 1){
                                if($breakMinutes > $timetabledata->BreakHour){
                                    $earlyBreakCheckinMinutes = $breakMinutes - $timetabledata->BreakHour ?? 0;
                                    $totallatechekinhr += $earlyBreakCheckinMinutes;
                                    $statuses[] = 4; //'Late-CheckIn';
                                    $isPresent = false;
                                }
                                if($breakMinutes < $timetabledata->BreakHour){
                                    $beforeondutytime = round((($timetabledata->BreakHour - $breakMinutes)),2);
                                    if($breaktimewt == 1){
                                        $workingHours += $beforeondutytime;
                                    }
                                    else if($breaktimewt == 0 && $breaktimeot == 0){
                                        $totalbeforeondutytime += $beforeondutytime;
                                        $breaktimeearlycheckin += $beforeondutytime;
                                    }
                                }
                            }
                        }
                    }
                    elseif ($time >= $beginningOut && $time <= $endingOut) {
                        if($punchinfrombreak > 0 && $log->PunchType == 2){
                            $lastpunchout = $time < ($offDuty - ($timetabledata->LeaveEarlyTime * 60)) ? $time : $offDuty;
                            if($timetabledata->BreakHourFlag == 0){
                                $workingHours += ($lastpunchout - $punchinfrombreakcalc) / 60;
                            }
                            
                            if ($lastpunchout < $offDuty - ($timetabledata->LeaveEarlyTime * 60)) {
                                $statuses[] = 6; //'Early-CheckOut';
                                $earlyCheckoutMinutes = round(($offDuty - $lastPunch) / 60);
                                $totallatechekouthr += $earlyCheckoutMinutes;
                                $isPresent = false;
                            }

                            if ($time > $offDuty) {
                                $afterondutytime = round(($time - $offDuty) / 60);
                                $totalafteroffdutytime += $afterondutytime;
                            }

                            if($timetabledata->BreakHourFlag == 1){
                                $workingHours += (($lastpunchout - $punchinfrombreak) / 60) - $breaktimeearlycheckin;
                            }
                        }
                    }
                }
            }

            if(count($logs) === 0){
                $totallatechekouthr = 0;
                $totallatechekinhr = 0;
            }

            $punchCounts = DB::table('attendance_logs')
            ->selectRaw("
                SUM(CASE WHEN PunchType = 1 THEN 1 ELSE 0 END) AS total_punch_in,
                SUM(CASE WHEN PunchType = 2 THEN 1 ELSE 0 END) AS total_punch_out")
            ->where('employees_id', $employeeId)
            ->whereDate('Date', $date)
            ->where('is_in_range',1)
            ->where('timetables_id','>',1)
            ->first();

            $totalPunchIn = $punchCounts->total_punch_in;
            $totalPunchOut = $punchCounts->total_punch_out;

            if ($totalPunchIn != $totalPunchOut) {
                $statuses = [];
                $statuses[] = 8; //'Incomplete Punch';
            } 

            $beforeOvertime = 0;
            $afterOvertime = 0;
            $totalOvertime = 0;

            if($timetable->timetables_id > 1){
                $beforeOvertime = ($timetabledata->EarlyCheckInOvertime == 1 && $shiftscheuledata->EffectiveOt == 1 && $firstPunch < $onDuty && $firstPunch >= $beginningIn) ? ($onDuty - $firstPunch) / 60 : 0;
                
                $afterOvertime = ($lastPunch > $overtimeStart && $shiftscheuledata->EffectiveOt == 1) ? ($lastPunch - $overtimeStart) / 60 : 0;

                $totalOvertime = $beforeOvertime + $afterOvertime;
            }

            $offShiftOvertime += $offshiftot;
            $totalworkinghr += $workingHours;
            $totalbreaktime += $breakMinutes;
            $totalbeforeot += $beforeOvertime;
            $totalafterot += $afterOvertime;
            $totalot += $totalOvertime;

            //$totalworkinghr = ($timetabledata->PunchingMethod == 2 && $timetabledata->id != 1) ? ($totalworkinghr - $timetabledata->BreakHour) : $totalworkinghr;
            //$totalbreaktime = ($timetabledata->PunchingMethod == 2 && $timetabledata->id != 1) ? $timetabledata->BreakHour : $totalbreaktime;
        }

        //Count number of shift assigned
        $countTimetable = DB::table('shiftschedule_timetables')
            ->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
            ->join('employees','shiftschedules.employees_id','employees.id')
            ->where(DB::raw('DATE(shiftschedule_timetables.Date)'), $date)
            ->where('shiftschedules.employees_id', $employeeId)
            ->where('shiftschedule_timetables.have_priority',1)
            ->distinct('timetables_id')
            ->count('timetables_id');

        if ($countTimetable == 1) {
            if (array_intersect([5,7,2], $statuses)) {
                $statusSummary = 2; //Present
            }
            
            if (in_array(4, $statuses)) {
                $statusSummary = 4; //"Late-CheckIn";
            }
            if (in_array(6, $statuses)) {
                $statusSummary = 6; //"Early-CheckOut";
            }
            if (in_array(4, $statuses) && in_array(6, $statuses)) {
                $statusSummary = 14; //"Late-CheckIn & Early-CheckOut";
            }
            
            if (in_array(9, $statuses)) {
                $statusSummary = 9; //"Day Off";
            }
            
            if (in_array(11, $statuses)) {
                $statusSummary = 11; //On-Leave
            }
            if (in_array(10, $statuses)) {
                $statusSummary = 10; //Holiday
            }
            if (in_array(13, $statuses)) {
                $statusSummary = 13; //"Off-Shift";
            }
            if (in_array(15, $statuses)) {
                $statusSummary = 15; //"Works on Holiday";
            }
            if (in_array(12, $statuses)) {
                $statusSummary = 12; //"Works-On-Leave";
            }
            if (in_array(1, $statuses)) {
                $statusSummary = 1; //Absent
            }
            if (in_array(8, $statuses)) {
                $statusSummary = 8; //Incomplete Punch
            }
        }
        if ($countTimetable > 1) {
            
            if (array_intersect([5,7,2], $statuses)) {
                $statusSummary = 2; //"Present";
            }
            if (in_array(4, $statuses)) {
                $statusSummary = 4; //"Late-CheckIn";
            }
            if (in_array(6, $statuses)) {
                $statusSummary = 6; //"Early-CheckOut";
            }
            if (in_array(4, $statuses) && in_array(6, $statuses)) {
                $statusSummary = 14; //"Late-CheckIn & Early-CheckOut";
            }
            if (in_array(9, $statuses)) {
                $statusSummary = 9; //"Day Off";
            }
            
            if (in_array(11, $statuses)) {
                $statusSummary = 11; //On-Leave
            }
            if (in_array(10, $statuses)) {
                $statusSummary = 10; //Holiday
            }
            if (in_array(13, $statuses)) {
                $statusSummary = 13; //"Off-Shift";
            }
            if (in_array(15, $statuses)) {
                $statusSummary = 15; //"Works on Holiday";
            }
            if (in_array(12, $statuses)) {
                $statusSummary = 12; //"Works-On-Leave";
            }
            
            if (in_array(1, $statuses) && !in_array(2, $statuses)) {
                $statusSummary = 1; //Absent
            }
            if (in_array(8, $statuses)) {
                $statusSummary = 8; //Incomplete Punch
            }
            if (in_array(1, $statuses) && in_array(2, $statuses) && !in_array(8, $statuses)) {
                $statusSummary = 3; //"Partial Present";
            }

        }

        $data[]=[
                'employees_id' => $employeeId,
                'Date' => $date,
                'WorkingTimeAmount' => round($totalworkinghr,2),
                'BreakTimeAmount' => round($totalbreaktime,2),
                'BeforeOvertimeAmount' => 0,
                'AfterOvertimeAmount' => 0,
                'TotalOvertimeAmount' => 0,
                'LateCheckInTimeAmount' => round($totallatechekinhr,2),
                'EarlyCheckOutTimeAmount' => round($totallatechekouthr,2),
                'BeforeOnDutyTimeAmount' => round($totalbeforeondutytime,2),
                'AfterOffDutyTimeAmount' => round($totalafteroffdutytime,2),
                'OffShiftOvertime' => 0,
                'OffShiftOvertimeLevelPercent' => 0,
                'Status' => $statusSummary,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

        $this->syncAttendance($data);

        $this->calculateOvertime($employeeId,$date);

        $this->applyLeaveToAttendance($employeeId,$date);

        DB::table('attendance_summaries')
            ->where('employees_id', $employeeId)
            ->where('Date', $date)
            ->update(['TotalOvertimeAmount' => DB::raw('(SELECT COALESCE(SUM(OtDurationMin), 0) FROM attendance_overtimes WHERE attendance_overtimes.employees_id = attendance_summaries.employees_id AND attendance_overtimes.Date = attendance_summaries.Date)'),
                    'WorkingTimeAmount' => DB::raw('GREATEST(WorkingTimeAmount - TotalOvertimeAmount, 0)'),
                    'WorkHourPending' => 0,
                    'BreakHourPending' => 0,
                    'OvertimePending' => 0,
        ]);

        DB::table('attendance_summaries')
            ->where('employees_id', $employeeId)
            ->where('Date', $date)
            ->whereIn('Status', [12,13,15])
            ->where(DB::raw('IFNULL(OffShiftStatus,0)'),'!=',1)
            ->update(['WorkHourPending' => DB::raw('(SELECT att_summ.WorkingTimeAmount FROM attendance_summaries AS att_summ WHERE att_summ.employees_id = attendance_summaries.employees_id AND att_summ.Date = attendance_summaries.Date)'),
                    'BreakHourPending' => DB::raw('(SELECT att_summ.BreakTimeAmount FROM attendance_summaries AS att_summ WHERE att_summ.employees_id = attendance_summaries.employees_id AND att_summ.Date = attendance_summaries.Date)'),
                    'OvertimePending' => DB::raw('(SELECT att_summ.TotalOvertimeAmount FROM attendance_summaries AS att_summ WHERE att_summ.employees_id = attendance_summaries.employees_id AND att_summ.Date = attendance_summaries.Date)'),
                    'WorkingTimeAmount' => 0,
                    'BreakTimeAmount' => 0,
                    'TotalOvertimeAmount' => 0,
        ]);

        DB::table('attendance_summaries')
            ->where('employees_id', $employeeId)
            ->where('Date', $date)
            ->whereIn('Status',[1])
            ->update(['WorkingTimeAmount' => 0,'BreakTimeAmount' => 0,'LateCheckInTimeAmount' => 0,'EarlyCheckOutTimeAmount' => 0,'TotalOvertimeAmount' => 0]);

        
            DB::table('attendance_summaries')
            ->where('employees_id', $employeeId)
            ->where('Date', $date)
            ->whereIn('Status',[2,3])
            ->update(['OffShiftStatus' => 1]);
    }

    public function calculateOvertime($employees_id, $date){

        DB::table('attendance_overtimes')
            ->where('employees_id', $employees_id)
            ->where('Date', $date)
            ->delete();

        // Get shift details
        $shiftDetails = DB::table('shiftscheduledetails')
            ->join('shiftschedules','shiftscheduledetails.shiftschedules_id','shiftschedules.id')
            ->where('shiftschedules.employees_id', $employees_id)
            ->whereRaw('? BETWEEN SUBSTRING_INDEX(shiftscheduledetails.ValidDate, " to ", 1) 
                AND SUBSTRING_INDEX(shiftscheduledetails.ValidDate, " to ", -1)', [$date])
            ->selectRaw("shiftscheduledetails.*")
            ->first();

        if (!$shiftDetails || $shiftDetails->EffectiveOt != 1) {
            return false; // No effective overtime
        }

        // Get settings
        $settings = DB::table('settings')->first();

        // Get day number (1 = Monday, ..., 7 = Sunday)
        $daynum = Carbon::parse($date)->dayOfWeekIso;

        $dayOffOvertimes = [];
        $holidayOvertimes = [];
        $leaveOvertimes = [];

        $holidaydata = holiday::where('holidays.Status', 'Active')->where('holidays.HolidayDate', $date)->get();  
        foreach ($holidaydata as $holidaydata) {
            $holidayOvertimes[] = $holidaydata->HolidayDate;
        }

        if ($settings->overtime_dayoff_id) {
            $dayOffOvertimes[] = $settings->overtime_dayoff_id;
        }
       
        if ($settings->overtime_leave_id) {
            $leaveOvertimes[] = $settings->overtime_leave_id;
        }

        if (!empty($dayOffOvertimes)) {
            $overtimeRecords = [];
            $punchDoff = DB::table('attendance_logs')
                ->where('employees_id', $employees_id)
                ->whereDate('Date', $date)
                ->where('timetables_id',1)
                ->orderBy('Time', 'asc')
                ->get();

            $previousPunch = null;
            $rate = DB::table('overtimes')->where('id', $settings->overtime_dayoff_id)->value('WorkhourRate');

            foreach($punchDoff as $punch){
                if ($previousPunch ) {
                   if ($previousPunch->PunchType == 1 && $punch->PunchType == 2 && $rate > 0) { 
                        $overtimeRecords[] = [
                            'employees_id' => $employees_id,
                            'overtime_id' => $settings->overtime_dayoff_id,
                            'daynum' => $daynum,
                            'date' => $date,
                            'OtStartTime' => $previousPunch->Time,
                            'OtEndTime' => $punch->Time,
                            'OtDurationMin' => (strtotime($punch->Time) - strtotime($previousPunch->Time)) / 60,
                            'Rate' => $rate,
                            'IsPayrollClosed' => 0,
                            'Type' => 4, // Special overtime type
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                $previousPunch = $punch;
            }
            if (!empty($overtimeRecords)) {
                DB::table('attendance_overtimes')->insert($overtimeRecords);
                return true;
            }
        }

        if (!empty($holidayOvertimes)) {
            $overtimeRecords = [];
            $holidayRecords = [];
            
            $punchHoliday = DB::table('attendance_logs')
                ->where('employees_id', $employees_id)
                ->whereDate('Date', $date)
                ->where('is_in_range',1)
                ->orderBy('Time', 'asc')
                ->get();

            $previousPunch = null;
            $holidayOt = DB::table('holidays')->where('HolidayDate', $date)->value('overtime_id');
            $rate = DB::table('overtimes')->where('id', $holidayOt)->value('WorkhourRate');

            foreach($punchHoliday as $punch){
                if ($previousPunch ) {
                   if ($previousPunch->PunchType == 1 && $punch->PunchType == 2 && $rate > 0) { 
                        $overtimeRecords[] = [
                            'employees_id' => $employees_id,
                            'overtime_id' => $holidayOt,
                            'daynum' => $daynum,
                            'date' => $date,
                            'OtStartTime' => $previousPunch->Time,
                            'OtEndTime' => $punch->Time,
                            'OtDurationMin' => (strtotime($punch->Time) - strtotime($previousPunch->Time)) / 60,
                            'Rate' => $rate,
                            'IsPayrollClosed' => 0,
                            'Type' => 5, // Special overtime type
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                $previousPunch = $punch;
            }
            if (!empty($overtimeRecords)) {
                DB::table('attendance_overtimes')->insert($overtimeRecords);
                return true;
            }
        }

        if (!empty($leaveOvertimes)) {
            $overtimeRecords = [];

            // Check if employee is on leave
            $leave = hr_leave::where('hr_leaves.requested_for', $employees_id)
                ->whereBetween(DB::raw("'$date'"), [DB::raw('DATE(hr_leaves.LeaveFrom)'),DB::raw('DATE(hr_leaves.LeaveTo)')])
                ->where('hr_leaves.Status', 'Approved')
                ->exists();  

            $punchLeave = DB::table('attendance_logs')
                ->where('employees_id', $employees_id)
                ->whereDate('Date', $date)
                ->where('is_in_range',1)
                ->orderBy('Time', 'asc')
                ->get();

            $previousPunch = null;
            $rate = DB::table('overtimes')->where('id', $settings->overtime_leave_id)->value('WorkhourRate');

            foreach($punchLeave as $punch){
                if ($previousPunch) {
                   if ($previousPunch->PunchType == 1 && $punch->PunchType == 2 && $leave && $rate > 0) { 
                        $overtimeRecords[] = [
                            'employees_id' => $employees_id,
                            'overtime_id' => $settings->overtime_leave_id,
                            'daynum' => $daynum,
                            'date' => $date,
                            'OtStartTime' => $previousPunch->Time,
                            'OtEndTime' => $punch->Time,
                            'OtDurationMin' => (strtotime($punch->Time) - strtotime($previousPunch->Time)) / 60,
                            'Rate' => $rate,
                            'IsPayrollClosed' => 0,
                            'Type' => 6, // Special overtime type
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                $previousPunch = $punch;
            }

            if (!empty($overtimeRecords)) {
                DB::table('attendance_overtimes')->insert($overtimeRecords);
                return true;
            }
        }

        $timetable = DB::table('shiftschedule_timetables')
            ->join('timetables','shiftschedule_timetables.timetables_id','timetables.id')
            ->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
            ->where('shiftschedules.employees_id', $employees_id)
            ->where('shiftschedule_timetables.Date', $date)
            ->where('shiftschedule_timetables.have_priority',1)
            ->selectRaw("timetables.*")
            ->first();

        if (!$timetable) {
            return false; // No timetable found
        }

        // Get punch times
        $punchIn = DB::table('attendance_logs')
            ->where('employees_id', $employees_id)
            ->whereDate('Date', $date)
            ->where('PunchType',1)
            ->where('is_in_range',1)
            ->orderBy('Time', 'asc')
            ->value('Time');

        
        // Get punch times
        $punchOut = DB::table('attendance_logs')
            ->where('employees_id', $employees_id)
            ->whereDate('Date', $date)
            ->where('PunchType',2)
            ->where('is_in_range',1)
            ->orderBy('Time', 'desc')
            ->value('Time');
        
        if (!$punchIn || !$punchOut) {
            return false; // No valid punch data
        }

        // Get overtime settings
        $overtimeSettings = DB::table('overtimesettings')
            ->where('daynum', $daynum)
            ->get();

        // Check early check-in overtime
        if ($timetable->EarlyCheckInOvertime == 1) {
            $otStart = strtotime($punchIn);
            $otEnd = strtotime($timetable->OnDutyTime) > strtotime($punchOut) ? strtotime($punchOut) : strtotime($timetable->OnDutyTime);

            if ($otStart < $otEnd) {
                $overtimeRecords=[];
                foreach ($overtimeSettings as $setting) {
                    $rate = DB::table('overtimes')->where('id', $setting->overtime_id)->value('WorkhourRate');

                    if (strtotime($setting->StartTime) <= strtotime($timetable->OnDutyTime) && $rate > 0) {   
                        $otstarttime = strtotime($setting->StartTime) <= strtotime($punchIn) ? strtotime($punchIn) : strtotime($setting->StartTime);
                        $otendtime = strtotime($timetable->OnDutyTime) >= strtotime($setting->EndTime) ? strtotime($setting->EndTime) : strtotime($timetable->OnDutyTime);
                        $overtimeRecords[] = [
                            'employees_id' => $employees_id,
                            'overtime_id' => $setting->overtime_id,
                            'daynum' => $daynum,
                            'date' => $date,
                            'OtStartTime' => date('H:i',$otstarttime),
                            'OtEndTime' => date('H:i',$otendtime),
                            'OtDurationMin' => ($otendtime - $otstarttime) / 60,
                            'Rate' => $rate,
                            'IsPayrollClosed' => 0,
                            'Type' => 1, // Before OnDutyTime
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
        }

        // Check overtime after off duty
        if (!empty($timetable->OvertimeStart)) {
            $otStart = strtotime($timetable->OvertimeStart);
            $otEnd = strtotime($punchOut);
            if ($otStart < $otEnd) {
                foreach ($overtimeSettings as $setting) {
                    $rate = DB::table('overtimes')->where('id', $setting->overtime_id)->value('WorkhourRate');
                    if($rate > 0){
                        if (
                            ($otStart >= strtotime($setting->StartTime) && $otStart <= strtotime($setting->EndTime)) ||
                            ($otEnd >= strtotime($setting->StartTime) && $otEnd <= strtotime($setting->EndTime)) ||
                            ($otStart <= strtotime($setting->StartTime) && $otEnd >= strtotime($setting->EndTime))
                        ) {
                            
                            $otstarttime = max($otStart, strtotime($setting->StartTime)); // Pick the later one
                            $otendtime = min($otEnd, strtotime($setting->EndTime));

                            $overtimeRecords[] = [
                                'employees_id' => $employees_id,
                                'overtime_id' => $setting->overtime_id,
                                'daynum' => $daynum,
                                'date' => $date,
                                'OtStartTime' => date('H:i',$otstarttime),
                                'OtEndTime' => date('H:i',$otendtime),
                                'OtDurationMin' => ($otendtime - $otstarttime) / 60,
                                'Rate' => $rate,
                                'IsPayrollClosed' => 0,
                                'Type' => 2, // After OffDutyTime
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                }
            }
        }

        if($timetable->BreakTimeAsOvertime == 1){
            $otDurationMinute = $timetable->BreakHour ?? 0;

            $attsummary = DB::table('attendance_summaries')
                ->where('attendance_summaries.employees_id', $employees_id)
                ->where('attendance_summaries.Date', $date)
                ->selectRaw("attendance_summaries.BreakTimeAmount")
                ->first();

            $actualBreakTime = $attsummary->BreakTimeAmount ?? 0;
            
            if($actualBreakTime < $otDurationMinute){
                $otStart = 0;
                $otEnd = 0;

                foreach ($overtimeSettings as $setting) { 
                    $rate = DB::table('overtimes')->where('id', $setting->overtime_id)->value('WorkhourRate');
                    if($rate > 0){

                        if($timetable->PunchingMethod == 2){
                            $break = $this->getMiddleBreakSlot($timetable->OnDutyTime, $timetable->OffDutyTime, $otDurationMinute);
                            $otStart = strtotime($break["start"]);
                            $otEnd = strtotime($break["end"]);

                            if (
                                ($otStart >= strtotime($setting->StartTime) && $otStart <= strtotime($setting->EndTime)) ||
                                ($otEnd >= strtotime($setting->StartTime) && $otEnd <= strtotime($setting->EndTime)) ||
                                ($otStart <= strtotime($setting->StartTime) && $otEnd >= strtotime($setting->EndTime))
                            ){
                            
                                $otstarttime = max($otStart, strtotime($setting->StartTime)); // Pick the later one
                                $otendtime = min($otEnd, strtotime($setting->EndTime));
                                
                                $overtimeRecords[] = [
                                    'employees_id' => $employees_id,
                                    'overtime_id' => $setting->overtime_id,
                                    'daynum' => $daynum,
                                    'date' => $date,
                                    'OtStartTime' => date('H:i',$otstarttime),
                                    'OtEndTime' => date('H:i',$otendtime),
                                    'OtDurationMin' => ($otendtime - $otstarttime) / 60,
                                    'Rate' => $rate,
                                    'IsPayrollClosed' => 0,
                                    'Type' => 7, // Calculate OT for BreakTime
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                            }
                        }
                        if($timetable->PunchingMethod == 4){
                            // Get punch times
                            $punchOutToBreak = DB::table('attendance_logs')
                                ->where('employees_id', $employees_id)
                                ->whereDate('Date', $date)
                                ->where('PunchType',2)
                                ->where('is_in_range',1)
                                ->whereBetween('Time',[$timetable->EndingIn,$timetable->BeginningOut])
                                ->orderBy('Time', 'asc')
                                ->value('Time');

                            $punchInFromBreak = DB::table('attendance_logs')
                                ->where('employees_id', $employees_id)
                                ->whereDate('Date', $date)
                                ->where('PunchType',1)
                                ->where('is_in_range',1)
                                ->whereBetween('Time',[$timetable->EndingIn,$timetable->BeginningOut])
                                ->orderBy('Time', 'desc')
                                ->value('Time');

                            
                            $breakStart = Carbon::createFromTimeString($timetable->BreakStartTime);
                            $breakEnd = Carbon::createFromTimeString($timetable->BreakEndTime);
                            $actualStart = Carbon::createFromTimeString($punchOutToBreak);
                            $actualEnd = Carbon::createFromTimeString($punchInFromBreak);

                            if ($actualStart->gt($breakStart)) {
                                $otStart = strtotime($breakStart);
                                $otEnd = strtotime($actualStart);

                                if (
                                    ($otStart >= strtotime($setting->StartTime) && $otStart <= strtotime($setting->EndTime)) ||
                                    ($otEnd >= strtotime($setting->StartTime) && $otEnd <= strtotime($setting->EndTime)) ||
                                    ($otStart <= strtotime($setting->StartTime) && $otEnd >= strtotime($setting->EndTime))
                                ){
                                
                                    $otstarttime = max($otStart, strtotime($setting->StartTime)); // Pick the later one
                                    $otendtime = min($otEnd, strtotime($setting->EndTime));
                                    
                                    $overtimeRecords[] = [
                                        'employees_id' => $employees_id,
                                        'overtime_id' => $setting->overtime_id,
                                        'daynum' => $daynum,
                                        'date' => $date,
                                        'OtStartTime' => date('H:i',$otstarttime),
                                        'OtEndTime' => date('H:i',$otendtime),
                                        'OtDurationMin' => ($otendtime - $otstarttime) / 60,
                                        'Rate' => $rate,
                                        'IsPayrollClosed' => 0,
                                        'Type' => 7, // Calculate OT for BreakTime
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ];
                                }
                            }
                            if ($actualEnd->lt($breakEnd)) {
                                $otStart = strtotime($actualEnd);
                                $otEnd = strtotime($breakEnd);

                                if (
                                    ($otStart >= strtotime($setting->StartTime) && $otStart <= strtotime($setting->EndTime)) ||
                                    ($otEnd >= strtotime($setting->StartTime) && $otEnd <= strtotime($setting->EndTime)) ||
                                    ($otStart <= strtotime($setting->StartTime) && $otEnd >= strtotime($setting->EndTime))
                                ){
                                
                                    $otstarttime = max($otStart, strtotime($setting->StartTime)); // Pick the later one
                                    $otendtime = min($otEnd, strtotime($setting->EndTime));
                                    
                                    $overtimeRecords[] = [
                                        'employees_id' => $employees_id,
                                        'overtime_id' => $setting->overtime_id,
                                        'daynum' => $daynum,
                                        'date' => $date,
                                        'OtStartTime' => date('H:i',$otstarttime),
                                        'OtEndTime' => date('H:i',$otendtime),
                                        'OtDurationMin' => ($otendtime - $otstarttime) / 60,
                                        'Rate' => $rate,
                                        'IsPayrollClosed' => 0,
                                        'Type' => 7, // Calculate OT for BreakTime
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ];
                                }
                            }
                            
                        }
                    }
                }
            }
            

            // if($timetable->PunchingMethod == 4){
            //     $attsummary = DB::table('attendance_summaries')
            //         ->where('attendance_summaries.employees_id', $employees_id)
            //         ->where('attendance_summaries.Date', $date)
            //         ->selectRaw("attendance_summaries.BreakTimeAmount")
            //         ->first();

            //     $actualBreakTime = $attsummary->BreakTimeAmount ?? 0;

            //     if($actualBreakTime < $otDurationMinute){
            //         foreach ($overtimeSettings as $setting) { 
            //             $rate = DB::table('overtimes')->where('id', $setting->overtime_id)->value('WorkhourRate');
            //             if($rate > 0){
            //                 if(strtotime($timetable->OnDutyTime) >= strtotime($setting->StartTime) || strtotime($timetable->OffDutyTime) <= strtotime($setting->EndTime)){

            //                 }
            //             }
            //         }
            //     }
            // }
        }

        // Insert multiple records if any found
        if (!empty($overtimeRecords)) {
           DB::table('attendance_overtimes')->insert($overtimeRecords);
        }

        return true;
    }

    function getMiddleBreakSlot(string $startTime, string $endTime, int $gapInMinutes): ?array
    {
        $start = Carbon::createFromTimeString($startTime);
        $end = Carbon::createFromTimeString($endTime);

        $slots = [];
        $current = $start->copy();

        // Generate time slots
        while ($current->addMinutes($gapInMinutes)->lte($end)) {
            $slotStart = $current->copy()->subMinutes($gapInMinutes);
            $slotEnd = $current->copy();

            $slots[] = [
                'start' => $slotStart,
                'end'   => $slotEnd,
            ];
        }

        if (count($slots) === 0) {
            return null; // not enough time for even a single slot
        }

        // Get the middle slot
        $middleIndex = intdiv(count($slots), 2);
        $middleSlot = $slots[$middleIndex];

        return [
            'start' => $middleSlot['start']->format('H:i'),
            'end'   => $middleSlot['end']->format('H:i'),
        ];
    }

    public function applyLeaveToAttendance($employeeId, $date){
        $leave = hr_leave::where('hr_leaves.requested_for', $employeeId)
            ->whereBetween(DB::raw("'$date'"), [DB::raw('DATE(hr_leaves.LeaveFrom)'),DB::raw('DATE(hr_leaves.LeaveTo)')])
            ->where('hr_leaves.Status', 'Approved')
            ->exists();  

        if($leave){
            // DB::table('attendance_summaries')
            //     ->where('employees_id', $employeeId)
            //     ->where('Date', $date)
            //     ->where('Status', 11)
            //     ->update(['is_unpaid_leave' => 0,'is_leave_half_day' => 0]); //to reset the value

            $leavedata = hr_leave::where('hr_leaves.requested_for', $employeeId)
                ->whereBetween(DB::raw("'$date'"), [DB::raw('DATE(hr_leaves.LeaveFrom)'),DB::raw('DATE(hr_leaves.LeaveTo)')])
                ->where('hr_leaves.Status', 'Approved')
                ->latest()
                ->first();  
            
            $leavedetailpaid = hr_leaves_detail::where('hr_leaves_details.hr_leaves_id', $leavedata->id)
                ->where('hr_leaves_details.LeavePaymentType', 'Paid')
                ->select(DB::raw('COALESCE(SUM(hr_leaves_details.NumberOfDays), 0) AS TotalPaid'))
                ->get();  

            $leavedetailunpaid = hr_leaves_detail::where('hr_leaves_details.hr_leaves_id', $leavedata->id)
                ->where('hr_leaves_details.LeavePaymentType', 'Unpaid')
                ->select(DB::raw('COALESCE(SUM(hr_leaves_details.NumberOfDays), 0) AS TotalUnpaid'))
                ->get();  
            
            $getHalfDay = hr_leaves_detail::where('hr_leaves_details.hr_leaves_id', $leavedata->id)
                ->where(DB::raw('MOD(hr_leaves_details.NumberOfDays, 1)'), '0.5')
                ->get();  
            
            $getPaidHalfDay = hr_leaves_detail::where('hr_leaves_details.hr_leaves_id', $leavedata->id)
                ->where(DB::raw('MOD(hr_leaves_details.NumberOfDays, 1)'), '0.5')
                ->where('hr_leaves_details.LeavePaymentType', 'Paid')
                ->get();  

            $getUnpaidHalfDay = hr_leaves_detail::where('hr_leaves_details.hr_leaves_id', $leavedata->id)
                ->where(DB::raw('MOD(hr_leaves_details.NumberOfDays, 1)'), '0.5')
                ->where('hr_leaves_details.LeavePaymentType', 'Unpaid')
                ->get();  

            $totalpaid = $leavedetailpaid[0]->TotalPaid;
            $totalunpaid = $leavedetailunpaid[0]->TotalUnpaid;

            $totalhalfday = $getHalfDay->count();
            $totalpaidhalfday = $getPaidHalfDay->count();
            $totalunpaidhalfday = $getUnpaidHalfDay->count();

            $usedLeaveDays = 0;
            $colldata = [];

            
            if($totalhalfday > 0){
                $period = CarbonPeriod::create($leavedata->LeaveFrom, $leavedata->LeaveTo);
                $saturdays = [];

                foreach ($period as $date) {
                    if ($date->isSaturday()) {
                        $saturdays[] = $date->toDateString(); 
                    }
                }

                $sat_count = count($saturdays);

                if (empty($saturdays) || $sat_count != $totalhalfday) {
                    $incompletepunch = attendance_summary::where('employees_id', $employeeId)
                        ->whereBetween('Date', [$leavedata->LeaveFrom, $leavedata->LeaveTo])
                        ->whereIn('Status', [8])
                        ->get();
                    
                    $halfdaybefore = attendance_summary::where('employees_id', $employeeId)
                        ->whereBetween('Date', [$leavedata->LeaveFrom, $leavedata->LeaveTo])
                        ->whereIn('Status', [11])
                        ->where('is_leave_half_day',1)
                        ->get();
                    
                    $attinc = 0;
                    $attrow = 0;
                    $usedLeaveDayNew = $usedLeaveDays;

                    $halfdaybeforecnt = $halfdaybefore->count();
                    
                    foreach($incompletepunch as $incrow){
                        if($attinc < $totalhalfday && $totalhalfday != $halfdaybeforecnt && !in_array($incrow->Date, $saturdays)){
                            $incrow->is_leave_half_day = 1;
                            $incrow->Status = 11;
                            $incrow->save();
                            $attinc++;
                        }
                    }
                }
                if($sat_count > 0){
                    DB::table('attendance_summaries')
                        ->where('employees_id', $employeeId)
                        ->whereIn('Date', $saturdays)
                        ->update(['is_leave_half_day' => 1,'Status' => 11]);
                }
            }

            // Collect all actual absent/off-work days within the leave range
            $eligibleDays = attendance_summary::where('employees_id', $employeeId)
                ->whereBetween('Date', [$leavedata->LeaveFrom, $leavedata->LeaveTo])
                ->whereIn('Status', [11]) 
                ->get();
            
            foreach ($eligibleDays as $summary) {
                if ($usedLeaveDays < ceil($leavedata->NumberOfDays)) {
                    $summary->is_unpaid_leave = 0;
                    $summary->save();

                    $getUnpaidLeave = attendance_summary::where('employees_id', $employeeId)
                        ->whereBetween('Date', [$leavedata->LeaveFrom, $leavedata->LeaveTo])
                        ->whereIn('Status', [11]) 
                        ->where('is_unpaid_leave',1)
                        //->where('is_leave_half_day',0)
                        ->get();
                   
                    $halfDayData = attendance_summary::where('employees_id', $employeeId)
                                ->whereBetween('Date', [$leavedata->LeaveFrom, $leavedata->LeaveTo])
                                ->whereIn('Status', [11])
                                ->where('is_leave_half_day',1)
                                ->get();

                    $attUnpaidLeave = $getUnpaidLeave->count();
                    $halfDayCount = $halfDayData->count();

                    $isLeaveUnpaid=0;

                    if($summary->is_leave_half_day == 1){
                        $isLeaveUnpaid = $halfDayCount <= $totalunpaidhalfday ? 1 : 0;
                    }
                    if($summary->is_leave_half_day == 0){
                        //if($attUnpaidLeave > 0){
                            $isLeaveUnpaid = $attUnpaidLeave < ceil($totalunpaid) ? 1 : 0;
                        //}
                    }

                    $summary->is_unpaid_leave = $isLeaveUnpaid;
                    $summary->save();
                    $usedLeaveDays++;
                }
            }

            if ($usedLeaveDays < $eligibleDays->count()) {
                $remaining = $eligibleDays->slice($usedLeaveDays);
                foreach ($remaining as $summary) {
                    $summary->Status = 1;
                    $summary->is_unpaid_leave = 0;
                    $summary->save();
                }
            }

        }
    }

    public function syncAttendance($data) {
        
        foreach ($data as $record) {
            // Define unique identifiers (adjust based on your table structure)
            $employeeId = $record['employees_id'];
            $date = $record['Date']; // Assuming date is stored in 'Y-m-d' format

            // Check if the record exists
            $existingRecord = DB::table('attendance_summaries')
                ->where('employees_id', $employeeId)
                ->where('Date', $date)
                ->first();

            if ($existingRecord) {
                // Convert to an array for comparison
                $existingData = (array) $existingRecord;
                unset($existingData['id']); // Remove ID if it's auto-incremented

                // Check if data has changed
                if (array_diff_assoc($record, $existingData)) {
                    // Update only if there is a difference
                    DB::table('attendance_summaries')
                        ->where('employees_id', $employeeId)
                        ->where('Date', $date)
                        ->update($record);
                }
            } else {
                // Insert new record if not exists
                DB::table('attendance_summaries')->insert($record);
            }
        }
    }

    public function importAtt(Request $request){
        ini_set('max_execution_time', '30000000');
        ini_set("pcre.backtrack_limit", "500000000");
        ini_set('memory_limit', '-1');
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $devicetype=null;
        $device=null;
        $impdaterange=[];
        $attlogdata=[];
        $deviceid=null;
        $timeSt=null;

        $validator = Validator::make($request->all(), [
            'DeviceType' => 'required',
            'Devices' => 'required',
        ]);

        if($validator->passes()){
            try{
                $currentdate = Carbon::parse(Carbon::now())->format('Y-m-d');
                $currentime = Carbon::parse(Carbon::now())->format('h:i:s');
                $currentimesht = Carbon::parse(Carbon::now())->format('H:i');

                $currentdateandtime=$currentdate."T".$currentimesht;

                $devicetype=$request->DeviceType;
                $device=$request->Devices;
                $devprop = device::find($device);

                $topic="mqtt/face/".$devprop->DeviceId;
                $topicack="mqtt/face/".$devprop->DeviceId."/Ack";

                $uuid = Str::uuid()->toString();
                
                $mqtt = MQTT::connection();
                $mqt=new mqttmessage;

                $currentdatetime = $currentdate.'T'.Carbon::parse(Carbon::now())->format('H:i:s');

                $msgs='{
                    "operator": "ManualPushRecords",
                    "messageId":"MessageID-ManualPushRecords-'.$uuid.'",
                    "info":
                    {
                        "facesluiceId":"'.$devprop->DeviceId.'",
                        "TimeS":"'.$devprop->ManualSyncLatestTime.'",
                        "TimeE":"'.$currentdatetime.'",                            
                    },
                }';
                          
                $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                    if ($elapsedTime >= 5) {
                        $mqtts->interrupt();
                    }
                });

                $mqtt->subscribe($topicack, function (string $topic, string $message) use($mqtt,$uuid,$userid,$mqt) {
                    $mqt->userid=$userid;
                    $mqt->uuid=$uuid;
                    $mqt->message=$message;
                    $mqt->save();
                }, 2);

                $mqtt->publish($topic,$msgs,0);
                $mqtt->loop(true);

                $mqttmsg = DB::table('mqttmessages')->where('uuid',$uuid)->latest()->first();
                $res=$mqttmsg->message;
                $resl=json_decode($res, true);
                
                $code=data_get($resl,'code');
                $result=data_get($resl,'info.result');
                $recordnum=data_get($resl,'info.RecordNum');
                
                return $this->checkLogRecords($device,$devprop->DeviceId,$recordnum,$devprop->ManualSyncLatestTime,$currentdatetime);
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
    }

    public function checkLogRecords($deviceId,$deviceCode,$logrecord,$from,$to)
    {
        ini_set('max_execution_time', '30000000');
        ini_set("pcre.backtrack_limit", "500000000");
        ini_set('memory_limit', '-1');

        $user=Auth()->user()->username ?? "Automated";
        $userid=Auth()->user()->id ?? 0;
        if($logrecord == 0){
            return Response::json(['success'=>1,'logrecord'=>$logrecord]);
        }
        else if($logrecord > 0){
            while (true) {
                $insertedCount = DB::table('attendance_import_logs')
                ->whereBetween('DateTime', [Carbon::parse($from)->format('Y-m-d H:i:s'),Carbon::parse($to)->format('Y-m-d H:i:s')])
                ->where('DeviceCode',$deviceCode)
                ->where('ImportType',1)
                //->where('created_at','>=',Carbon::parse($to)->format('Y-m-d H:i:s'))
                ->count();

                if ($insertedCount >= $logrecord) {
                    $rowData = [];

                    $insertedRecords = DB::table('attendance_import_logs')
                    ->whereBetween('DateTime', [Carbon::parse($from)->format('Y-m-d H:i:s'),Carbon::parse($to)->format('Y-m-d H:i:s')])
                    ->where('DeviceCode',$deviceCode)
                    ->where('ImportType',1)
                    ->get();

                    foreach($insertedRecords as $row){
                        $alltimetable=[];
                        $timetableid=1;
                        $punchtype=1;
                        
                        $datevalues= Carbon::parse($row->DateTime)->format('Y-m-d');
                        $time=Carbon::parse($row->DateTime)->format('H:i');

                        $employeeid = employee::where('name',$row->Name)->latest()->value('id') ?? 1;
                
                        $timetabledata=DB::select('SELECT DISTINCT timetables_id FROM shiftschedule_timetables WHERE shiftschedule_timetables.shiftschedules_id=(SELECT shiftschedules.id FROM shiftschedules WHERE shiftschedules.employees_id='.$employeeid.') AND shiftschedule_timetables.Date="'.$datevalues.'"');
                        foreach($timetabledata as $timetabledata){
                            $alltimetable[]=$timetabledata->timetables_id;
                        }
                        $gettimetableid = timetable::whereIn('id',$alltimetable)->whereBetween(DB::raw("'$time'"),[DB::raw('timetables.BeginningIn'),DB::raw('timetables.EndingOut')])->latest()->first();
                        if(empty($gettimetableid)){
                            $timetableid=1;
                        }
                        else if(!empty($gettimetableid)){
                            $timetableid=$gettimetableid->id;
                        }

                        if($employeeid > 1){
                            $rowData[] = [
                                'employees_id' => $employeeid,
                                'timetables_id' => $timetableid,
                                'Date' => $datevalues,
                                'Time' => $time,
                                'PunchType' => $punchtype,
                                'AttType' => 2,
                                'LastEditedBy' => $user,
                                'LastEditedDate' => Carbon::now(),
                                'Remark' => "",
                                'updated_at' => Carbon::now()
                            ];    
                        }
                    }

                    attendance_log::insertOrIgnore($rowData);

                    $fromD = Carbon::parse($from)->format('Y-m-d');
                    $toD = Carbon::parse($to)->format('Y-m-d');

                    $employees = DB::table('shiftscheduledetails as sd')
                        ->join('shiftschedules as s', 's.id', '=', 'sd.shiftschedules_id')
                        ->join('employees as e', 'e.id', '=', 's.employees_id')
                        ->where("e.Status","Active")
                        ->whereRaw("
                            STR_TO_DATE(SUBSTRING_INDEX(sd.ValidDate, ' to ', 1), '%Y-%m-%d') <= ?
                            AND STR_TO_DATE(SUBSTRING_INDEX(sd.ValidDate, ' to ', -1), '%Y-%m-%d') >= ?
                        ", [$toD, $fromD])
                        ->select('s.employees_id') // Select columns from both tables
                        ->get();

                    $dates = collect();

                    for ($date = Carbon::parse($fromD)->copy(); $date->lte(Carbon::parse($toD)); $date->addDay()) {
                        $dates->push($date->format('Y-m-d'));
                    }

                    foreach ($employees as $employee) {
                        foreach ($dates as $date) {
                            $this->checkAttendanceStatus($employee->employees_id,$date);
                        }
                    }

                    device::where('id',$deviceId)->update(['ManualSyncLatestTime'=>$to]);

                    return Response::json(['success'=>1,'logrecord'=>$logrecord]);
                    break; 
                }
                sleep(3);
            }
        }
    }

    public function updateAttendanceLogs($employeeId, $date)
    {
        $timescoll=[];

        $logs = DB::table('attendance_logs')
                ->where('employees_id', $employeeId)
                ->where('Date', $date)
                ->get();
        
        foreach ($logs as $log) {  
            $timetabledataid=null;
            $timetableid=1;
            $timetabledata=DB::select('SELECT DISTINCT timetables_id FROM shiftschedule_timetables WHERE shiftschedule_timetables.timetables_id='.$log->timetables_id.' AND shiftschedule_timetables.shiftschedules_id=(SELECT shiftschedules.id FROM shiftschedules WHERE shiftschedules.employees_id='.$employeeId.') AND shiftschedule_timetables.have_priority=1 AND shiftschedule_timetables.timetables_id!=1 AND shiftschedule_timetables.Date="'.$date.'"');
            foreach($timetabledata as $timetabledata){
                $timetabledataid=$timetabledata->timetables_id;
            }
            
            if($timetabledataid == null){
                $timetableid=$log->timetables_id;
            }
            else if($timetabledataid != null){
                $timetableid=$timetabledataid;
            }

            $timetable = DB::table('timetables')->where('id',$timetableid)->first();

            if (!$timetable) continue;

            $time = strtotime($log->Time);
            $update = ['is_in_range' => 0];
            $updateptype = ['PunchType' => 0];
            
            $beginningIn = strtotime($timetable->BeginningIn);
            $endingIn = strtotime($timetable->EndingIn);
            $beginningOut = strtotime($timetable->BeginningOut);
            $endingOut = strtotime($timetable->EndingOut);
            
            if ($timetable->PunchingMethod == 2) {
                if ($time >= $beginningIn && $time <= $endingIn) {
                    $minTime = DB::table('attendance_logs')
                        ->where('timetables_id', $log->timetables_id)
                        ->where('employees_id', $employeeId)
                        ->where('Date', $date)
                        ->whereBetween('Time', [$timetable->BeginningIn, $timetable->EndingIn])
                        ->min('Time');

                    $update['is_in_range'] = ($log->Time == $minTime) ? 1 : 0;
                    $updateptype['PunchType'] = ($log->Time == $minTime) ? 1 : 0;

                } elseif ($time >= $beginningOut && $time <= $endingOut) {
                    $maxTime = DB::table('attendance_logs')
                        ->where('timetables_id', $log->timetables_id)
                        ->where('employees_id', $employeeId)
                        ->where('Date', $date)
                        ->whereBetween('Time', [$timetable->BeginningOut, $timetable->EndingOut])
                        ->max('Time');

                    $update['is_in_range'] = ($log->Time == $maxTime) ? 1 : 0;
                    $updateptype['PunchType'] = ($log->Time == $maxTime) ? 2 : 0;
                }
            } elseif ($timetable->PunchingMethod == 4) {
                $breakHourFlag = $timetable->BreakHourFlag;
                $breakStart = strtotime($timetable->BreakStartTime) - ($timetable->LeaveEarlyTimeBreak * 60);
                $breakEnd = strtotime($timetable->BreakEndTime) + ($timetable->LateTimeBreak * 60);

                $endingincus = Carbon::createFromFormat('H:i', $timetable->EndingIn)->addMinute();
                $beginningoutcus = Carbon::createFromFormat('H:i', $timetable->BeginningOut)->subMinute();
                
                if ($time >= $beginningIn && $time <= $endingIn) {
                    $minTime = DB::table('attendance_logs')
                        ->where('timetables_id', $log->timetables_id)
                        ->where('employees_id', $employeeId)
                        ->where('Date', $date)
                        ->whereBetween('Time', [$timetable->BeginningIn, $timetable->EndingIn])
                        ->min('Time');
                    
                    $update['is_in_range'] = ($log->Time == $minTime) ? 1 : 0;
                    $updateptype['PunchType'] = ($log->Time == $minTime) ? 1 : 0;
                    
                } elseif ($breakHourFlag == 0 && $time >= $endingIn && $time <= $beginningOut) {
                    $minTime = DB::table('attendance_logs')
                        ->where('timetables_id', $log->timetables_id)
                        ->where('employees_id', $employeeId)
                        ->where('Date', $date)
                        ->whereBetween('Time',  [$endingincus->format('H:i'),$beginningoutcus->format('H:i')])
                        ->min('Time');

                    // $maxTime = DB::table('attendance_logs')
                    //     ->where('timetables_id', $log->timetables_id)
                    //     ->where('employees_id', $employeeId)
                    //     ->where('Date', $date)
                    //     ->whereBetween('Time', [$endingincus->format('H:i'),$beginningoutcus->format('H:i')])
                    //     ->max('Time');

                    $maxTime = DB::table('attendance_logs')
                        ->where('timetables_id', $log->timetables_id)
                        ->where('employees_id', $employeeId)
                        ->where('Date', $date)
                        ->whereBetween('Time', [$endingincus->format('H:i'),$beginningoutcus->format('H:i')])
                        ->when($minTime, function ($query, $minTime) {
                            return $query->where('Time', '>', $minTime);
                        })
                       // ->where('Time', '>', $minTime)
                        ->orderBy('Time', 'asc')
                        ->value('Time');

                    $update['is_in_range'] = ($log->Time == $minTime || $log->Time == $maxTime) ? 1 : 0;
                    $updateptype['PunchType'] = ($log->Time == $minTime) ? 2 : (($log->Time == $maxTime) ? 1 : 0);

                } elseif ($breakHourFlag == 1 && $time >= $endingIn && $time <= $beginningOut) {
                    $minTime = DB::table('attendance_logs')
                        ->where('timetables_id', $log->timetables_id)
                        ->where('employees_id', $employeeId)
                        ->where('Date', $date)
                        ->whereBetween('Time', [$timetable->EndingIn, $timetable->BeginningOut])
                        ->min('Time');

                    // $maxTime = DB::table('attendance_logs')
                    //     ->where('timetables_id', $log->timetables_id)
                    //     ->where('employees_id', $employeeId)
                    //     ->where('Date', $date)
                    //     ->whereBetween('Time', [$timetable->EndingIn, $timetable->BeginningOut])
                    //     ->max('Time');

                    $maxTime = DB::table('attendance_logs')
                        ->where('timetables_id', $log->timetables_id)
                        ->where('employees_id', $employeeId)
                        ->where('Date', $date)
                        ->whereBetween('Time', [$timetable->EndingIn, $timetable->BeginningOut])
                        ->when($minTime, function ($query, $minTime) {
                            return $query->where('Time', '>', $minTime);
                        })
                        //->where('Time', '>', $minTime)
                        ->orderBy('Time', 'asc')
                        ->value('Time');
                    
                    $update['is_in_range'] = ($log->Time == $minTime || $log->Time == $maxTime) ? 1 : 0;
                    $updateptype['PunchType'] = ($log->Time == $minTime) ? 2 : (($log->Time == $maxTime) ? 1 : 0);

                } elseif ($time >= $beginningOut && $time <= $endingOut) {
                    $maxTime = DB::table('attendance_logs')
                        ->where('timetables_id', $log->timetables_id)
                        ->where('employees_id', $employeeId)
                        ->where('Date', $date)
                        ->whereBetween('Time', [$timetable->BeginningOut, $timetable->EndingOut])
                        ->max('Time');

                    $update['is_in_range'] = ($log->Time == $maxTime) ? 1 : 0;
                    $updateptype['PunchType'] = ($log->Time == $maxTime) ? 2 : 0;
                }
            }

            DB::table('attendance_logs')->where('id', $log->id)->update($update);
            DB::table('attendance_logs')->where('id', $log->id)->update($updateptype);
        }

        //Change is_in_range to zero if there is duplicate value one

        // DB::table('attendance_logs as al1')
        // ->join('attendance_logs as al2', function ($join) {
        //     $join->on('al1.employees_id', '=', 'al2.employees_id')
        //         ->on('al1.Date', '=', 'al2.Date')
        //         ->on('al1.Time', '=', 'al2.Time')
        //         ->whereRaw('al1.id > al2.id'); // Keep only the first record
        // })
        // ->where('al1.is_in_range', 1)
        // ->where('al1.employees_id', $employeeId)
        // ->where('al1.Date', $date)
        // ->update(['al1.is_in_range' => 0]); // Set duplicates to 0

        $countTimetableOffShift = DB::table('shiftschedule_timetables')
            ->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
            ->join('employees','shiftschedules.employees_id','employees.id')
            ->where(DB::raw('DATE(shiftschedule_timetables.Date)'), $date)
            ->where('shiftschedules.employees_id', $employeeId)
            ->where('shiftschedule_timetables.have_priority',1)
            ->where('shiftschedule_timetables.timetables_id',1)
            ->distinct('timetables_id')
            ->count('timetables_id');

        if($countTimetableOffShift > 0){
            // Assign PunchType alternating between 1 and 2 where is_in_range = 1
            DB::table('attendance_logs')->where('employees_id', $employeeId)->where('Date', $date)->where('timetables_id',1)->update(['is_in_range' => 1]);
        }        
    }

    public function handleNightShiftPunches($employeeId, $date){
        $data = [];

        try {
            if (!self::$preventRecursion) {
                $prevDate = Carbon::parse($date)->subDay()->format('Y-m-d');

                DB::table('attendance_logs')
                    ->where('attendance_logs.Date',$prevDate)
                    ->where('attendance_logs.employees_id',$employeeId)
                    ->where('attendance_logs.PunchType',2)
                    ->where('attendance_logs.AttType', 3)
                    ->delete();

                DB::table('attendance_logs')
                    ->where('attendance_logs.Date',$date)
                    ->where('attendance_logs.employees_id',$employeeId)
                    ->where('attendance_logs.PunchType',1)
                    ->where('attendance_logs.AttType', 3)
                    ->delete();

                $currentTimetables = shiftschedule_timetable::join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                    ->join('timetables','shiftschedule_timetables.timetables_id','timetables.id')
                    ->where('shiftschedules.employees_id', $employeeId)
                    ->where(DB::raw('DATE(shiftschedule_timetables.Date)'), $date)
                    ->where('shiftschedule_timetables.have_priority',1)
                    ->where('timetables.is_night_shift',1)
                    ->orderBy('timetables.OnDutyTime', 'ASC')
                    ->first();

                if (!$currentTimetables) {
                    return false; // Not the second part of a night shift
                }

                $previousTimetables = shiftschedule_timetable::join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                    ->join('timetables','shiftschedule_timetables.timetables_id','timetables.id')
                    ->where('shiftschedules.employees_id', $employeeId)
                    ->where(DB::raw('DATE(shiftschedule_timetables.Date)'), $prevDate)
                    ->where('shiftschedule_timetables.have_priority',1)
                    ->where('timetables.is_night_shift',1)
                    ->orderBy('timetables.OffDutyTime', 'DESC')
                    ->first();

                if (!$previousTimetables) {
                    return false; // No matching first part found
                }

                $offDuty = Carbon::createFromFormat('H:i', $previousTimetables->OffDutyTime);
                $onDuty = Carbon::createFromFormat('H:i', $currentTimetables->OnDutyTime);
                $onDuty->addDay();

                $variance = $offDuty->diffInMinutes($onDuty);

                if ($variance > 10) {
                    return false; // Not Consecutive
                }
                
                // Check if we have PunchIn on first day and PunchOut on second day
                $hasFirstDayPunchIn = attendance_log::where('attendance_logs.employees_id', $employeeId)
                    ->where('attendance_logs.timetables_id',$previousTimetables->timetables_id)
                    ->where(DB::raw('DATE(attendance_logs.Date)'), $prevDate)
                    ->where('is_in_range',1)
                    ->where('PunchType',1)
                    ->exists();

                $hasSecondDayPunchOut = attendance_log::where('attendance_logs.employees_id', $employeeId)
                    ->where('attendance_logs.timetables_id',$currentTimetables->timetables_id)
                    ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
                    ->where('is_in_range',1)
                    ->where('PunchType',2)
                    ->exists();

                if ($hasFirstDayPunchIn && $hasSecondDayPunchOut) {
                    $data[]=[
                        'employees_id' => $employeeId,
                        'timetables_id' => $previousTimetables->timetables_id,
                        'Date' => $prevDate,
                        'Time' => $previousTimetables->OffDutyTime,
                        'PunchType' => 2,
                        'AttType' => 3,
                        'is_in_range' => 1,
                        'LastEditedBy' => "Auto-Generate",
                        'LastEditedDate' => Carbon::now(),
                        'Remark' => "",
                        'updated_at' => Carbon::now()
                    ];    

                    $data[]=[
                        'employees_id' => $employeeId,
                        'timetables_id' => $currentTimetables->timetables_id,
                        'Date' => $date,
                        'Time' => $currentTimetables->OnDutyTime,
                        'PunchType' => 1,
                        'AttType' => 3,
                        'is_in_range' => 1,
                        'LastEditedBy' => "Auto-Generate",
                        'LastEditedDate' => Carbon::now(),
                        'Remark' => "",
                        'updated_at' => Carbon::now()
                    ];   
                    
                    DB::table('attendance_logs')->insertOrIgnore($data);

                    self::$preventRecursion = true;
                    $this->checkAttendanceStatus($employeeId,$prevDate);
                    self::$preventRecursion = false;
                }
            }
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    public function importExcelAtt(Request $request){
        ini_set('max_execution_time', '30000000');
        ini_set("pcre.backtrack_limit", "500000000");
        ini_set('memory_limit', '-1');
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $devicetype=null;
        $device=null;
        $devicecode=null;
        $timeSt=null;
        $timeEn=null;
        $timeStShort=null;
        $timeEnShort=null;
        $recordnum=0;

        $validator = Validator::make($request->all(), [
            'DeviceTypeExcelLog' => 'required',
            'DevicesExcel' => 'required',
            'BrowseFile' => 'mimes:xlsx|required',
        ]);

        if($validator->passes()){
            try{
                $recordnum=$request->totallogrecord;
                $devicetype=$request->DeviceTypeExcelLog;
                $device=$request->DevicesExcel;

                Excel::import(new AttendanceImport,$request->file('BrowseFile')->store('BrowseFile'));

                $devprop = device::find($device);
                $devicecode=$devprop->DeviceId;

                $getmindate = DB::select('SELECT DATE_FORMAT(attendance_import_logs.DateTime,"%Y-%m-%d %H:%i") AS DateTimeShort,attendance_import_logs.DateTime FROM attendance_import_logs WHERE attendance_import_logs.empid=1 AND attendance_import_logs.deviceid=1 AND attendance_import_logs.DeviceCode=1 AND attendance_import_logs.ImportType=2 ORDER BY attendance_import_logs.DateTime ASC LIMIT 1');
                $getmaxdate = DB::select('SELECT DATE_FORMAT(attendance_import_logs.DateTime,"%Y-%m-%d %H:%i") AS DateTimeShort,attendance_import_logs.DateTime FROM attendance_import_logs WHERE attendance_import_logs.empid=1 AND attendance_import_logs.deviceid=1 AND attendance_import_logs.DeviceCode=1 AND attendance_import_logs.ImportType=2 ORDER BY attendance_import_logs.DateTime DESC LIMIT 1');
                $timeSt = $getmindate[0]->DateTime;
                $timeStShort = $getmindate[0]->DateTimeShort;
                $timeEn = $getmaxdate[0]->DateTime;
                $timeEnShort = $getmaxdate[0]->DateTimeShort;

                $updateattlog = DB::select('UPDATE attendance_import_logs SET attendance_import_logs.deviceid='.$device.',attendance_import_logs.DeviceCode='.$devicecode.' WHERE attendance_import_logs.deviceid=1 AND attendance_import_logs.DeviceCode=1 AND attendance_import_logs.ImportType=2');

                $countDeletedRec = DB::select("SELECT COUNT(*) AS count_del FROM attendance_import_logs t1 INNER JOIN attendance_import_logs t2 WHERE t1.id > t2.id AND t1.empid=1 AND t1.DateTime=t2.DateTime AND t1.DeviceCode=t2.DeviceCode AND t1.ImportType=2");
                $countdel = $countDeletedRec[0]->count_del;
                $deleteduplicateimplog=DB::delete('DELETE t1 FROM attendance_import_logs t1 INNER JOIN attendance_import_logs t2 WHERE t1.id > t2.id AND t1.empid =1 AND t1.DateTime=t2.DateTime AND t1.DeviceCode=t2.DeviceCode');
                $updateimplog=DB::select('UPDATE attendance_import_logs SET attendance_import_logs.empid=(SELECT id FROM employees WHERE employees.name=attendance_import_logs.Name) WHERE attendance_import_logs.empid=1');

                $insertattlog=DB::select('INSERT INTO attendance_logs(employees_id,timetables_id,Date,Time,PunchType,AttType,created_at,updated_at) SELECT empid,
                        IFNULL((SELECT timetables.id FROM shiftschedule_timetables INNER JOIN timetables ON shiftschedule_timetables.timetables_id=timetables.id WHERE shiftschedule_timetables.shiftschedules_id=(SELECT shiftschedules.id FROM shiftschedules WHERE shiftschedules.employees_id=attendance_import_logs.empid) AND shiftschedule_timetables.Date=DATE_FORMAT(attendance_import_logs.DateTime,"%Y-%m-%d") AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i") BETWEEN timetables.BeginningIn AND timetables.EndingOut LIMIT 1),1),DATE_FORMAT(attendance_import_logs.DateTime,"%Y-%m-%d"),DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i"),
                        (SELECT 
                        CASE WHEN 
                            (DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")>= IFNULL(TIME_FORMAT(SUBTIME(timetables.BreakEndTime,"00:30:00"),"%H:%i"),"23:59:59") AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")<= timetables.BeginningOut) OR (DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")>=timetables.BeginningIn AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")<=timetables.EndingIn) THEN "1"
                            WHEN
                            (DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")>= timetables.EndingIn AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i") <= IFNULL(TIME_FORMAT(ADDTIME(timetables.BreakStartTime,"00:30:00"),"%H:%i"),"00:00:00")) OR
                            (DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")>=timetables.BeginningOut AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")<=timetables.EndingOut) 
                            THEN "2" ELSE "0" END FROM attendance_logs AS attlog INNER JOIN timetables ON attlog.timetables_id=attlog.timetables_id WHERE timetables.id=(IFNULL((SELECT timetables.id FROM shiftschedule_timetables INNER JOIN timetables ON shiftschedule_timetables.timetables_id=timetables.id WHERE shiftschedule_timetables.shiftschedules_id=(SELECT shiftschedules.id FROM shiftschedules WHERE shiftschedules.employees_id=attendance_import_logs.empid) AND shiftschedule_timetables.Date=DATE_FORMAT(attendance_import_logs.DateTime,"%Y-%m-%d") AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i") BETWEEN timetables.BeginningIn AND timetables.EndingOut LIMIT 1),1)) LIMIT 1),
                        3,"'.Carbon::now().'","'.Carbon::now().'" FROM attendance_import_logs WHERE attendance_import_logs.DateTime>="'.$timeSt.'" AND attendance_import_logs.DateTime<="'.$timeEn.'" AND attendance_import_logs.DeviceCode="'.$devicecode.'"');
                
                $deleteduplicateattlog=DB::select('DELETE t1 FROM attendance_logs t1 INNER JOIN attendance_logs t2 WHERE t1.id > t2.id AND t1.employees_id=t2.employees_id AND t1.Date=t2.Date AND t1.Time=t2.Time AND t1.timetables_id=t2.timetables_id');
                    
                $insertatt=DB::select('INSERT INTO attendances(employees_id,timetables_id,Date,PunchInTime,PunchOutTime,TimeOpt,PunchType,IsActualTimetable,IsPayrollMade,created_at,updated_at) SELECT DISTINCT attendance_logs.employees_id,attendance_logs.timetables_id,Date,"","","",1,0,0,"'.Carbon::now().'","'.Carbon::now().'" FROM attendance_logs WHERE CONCAT(attendance_logs.Date," ",attendance_logs.Time)>="'.$timeStShort.'" AND CONCAT(attendance_logs.Date," ",attendance_logs.Time)<="'.$timeEnShort.'"');
                    
                $deleteattlog=DB::select('DELETE t1 FROM attendances t1 INNER JOIN attendances t2 WHERE t1.id > t2.id AND t1.employees_id=t2.employees_id AND t1.Date=t2.Date AND t1.Time=t2.Time AND t1.timetables_id=t2.timetables_id');

                $totalsynclog=$recordnum-$countdel;
                $this->syncTimetable();
                $this->syncAttendances();

                return Response::json(['success' =>'1','lognum'=>$totalsynclog]);
            }
            catch (\Maatwebsite\Excel\Validators\ValidationException $e){
                $failures = $e->failures();
                $data=[];
                $datarow=[];
                $string="";
                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                    $datarow[]="Row # : ".$failure->row()."<br> Error : ".implode(",",$failure->errors())."<br>";
                    $data[]="";
                }
                return Response::json(['dberrors' =>$datarow]);
            }
        }

        if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function syncTimetable(){
        ini_set('max_execution_time', '300000000');
        ini_set("pcre.backtrack_limit", "500000000");
        ini_set('memory_limit', '-1');

        $deleteduplicateattlog=DB::select('DELETE t1 FROM attendance_logs t1 INNER JOIN attendance_logs t2 WHERE t1.id > t2.id AND t1.employees_id=t2.employees_id AND t1.Date=t2.Date AND t1.Time=t2.Time AND t1.timetables_id=t2.timetables_id');

        $updatepunchin=DB::select('UPDATE attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id INNER JOIN employees ON attendances.employees_id=employees.id INNER JOIN attendances AS att ON att.id=attendances.id SET attendances.PunchInTime=(SELECT MIN(attendance_logs.Time) FROM attendance_logs WHERE attendance_logs.Time BETWEEN timetables.BeginningIn AND timetables.EndingIn AND attendance_logs.employees_id=employees.id AND attendance_logs.Date=attendances.Date AND attendance_logs.timetables_id=timetables.id AND attendance_logs.PunchType=1) WHERE attendances.employees_id=employees.id AND attendances.Date=att.Date AND attendances.timetables_id=timetables.id AND attendances.IsPayrollMade!=1');
        $updatepunchoutlunch=DB::select('UPDATE attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id INNER JOIN employees ON attendances.employees_id=employees.id INNER JOIN attendances AS att ON att.id=attendances.id SET attendances.BreakOutTime=(SELECT MIN(attendance_logs.Time) FROM attendance_logs WHERE attendance_logs.Time BETWEEN timetables.EndingIn AND timetables.BeginningOut AND attendance_logs.employees_id=employees.id AND attendance_logs.Date=attendances.Date AND attendance_logs.timetables_id=timetables.id AND attendance_logs.PunchType=2) WHERE attendances.employees_id=employees.id AND attendances.Date=att.Date AND timetables.PunchingMethod=4 AND attendances.timetables_id=timetables.id AND attendances.IsPayrollMade!=1');
        $updatepunchinfromlunch=DB::select('UPDATE attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id INNER JOIN employees ON attendances.employees_id=employees.id INNER JOIN attendances AS att ON att.id=attendances.id SET attendances.BreakInTime=(SELECT MAX(attendance_logs.Time) FROM attendance_logs WHERE attendance_logs.Time BETWEEN timetables.EndingIn AND timetables.BeginningOut AND attendance_logs.employees_id=employees.id AND attendance_logs.Date=attendances.Date AND attendance_logs.timetables_id=timetables.id AND attendance_logs.PunchType=1) WHERE attendances.employees_id=employees.id AND attendances.Date=att.Date AND timetables.PunchingMethod=4 AND attendances.timetables_id=timetables.id AND attendances.IsPayrollMade!=1');
        $updatepunchout=DB::select('UPDATE attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id INNER JOIN employees ON attendances.employees_id=employees.id INNER JOIN attendances AS att ON att.id=attendances.id SET attendances.PunchOutTime=(SELECT MAX(attendance_logs.Time) FROM attendance_logs WHERE attendance_logs.Time BETWEEN timetables.BeginningOut AND timetables.EndingOut AND attendance_logs.employees_id=employees.id AND attendance_logs.Date=attendances.Date AND attendance_logs.timetables_id=timetables.id AND attendance_logs.PunchType=2) WHERE attendances.employees_id=employees.id AND attendances.Date=att.Date AND attendances.timetables_id=timetables.id AND attendances.IsPayrollMade!=1');

        $updatepunchoutlunchtwotimes=DB::select('UPDATE attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id INNER JOIN employees ON attendances.employees_id=employees.id INNER JOIN attendances AS att ON att.id=attendances.id SET attendances.BreakOutTime=timetables.BreakStartTime WHERE attendances.employees_id=employees.id AND attendances.Date=att.Date AND timetables.PunchingMethod=2 AND attendances.timetables_id=timetables.id AND attendances.IsPayrollMade!=1');
        $updatepunchinlunchtwotimes=DB::select('UPDATE attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id INNER JOIN employees ON attendances.employees_id=employees.id INNER JOIN attendances AS att ON att.id=attendances.id SET attendances.BreakInTime=timetables.BreakEndTime WHERE attendances.employees_id=employees.id AND attendances.Date=att.Date AND timetables.PunchingMethod=2 AND attendances.timetables_id=timetables.id AND attendances.IsPayrollMade!=1');

        $updatepunchinshiftoff=DB::select('UPDATE attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id INNER JOIN employees ON attendances.employees_id=employees.id INNER JOIN attendances AS att ON att.id=attendances.id SET attendances.PunchInTime=(SELECT MIN(attendance_logs.Time) FROM attendance_logs WHERE attendance_logs.employees_id=employees.id AND attendance_logs.Date=attendances.Date AND attendance_logs.timetables_id=timetables.id AND attendance_logs.PunchType=1) WHERE attendances.employees_id=employees.id AND attendances.Date=att.Date AND attendances.IsPayrollMade!=1 AND attendances.timetables_id=timetables.id');
        $updatepunchoutshiftoff=DB::select('UPDATE attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id INNER JOIN employees ON attendances.employees_id=employees.id INNER JOIN attendances AS att ON att.id=attendances.id SET attendances.PunchOutTime=(SELECT MAX(attendance_logs.Time) FROM attendance_logs WHERE attendance_logs.employees_id=employees.id AND attendance_logs.Date=attendances.Date AND attendance_logs.timetables_id=timetables.id AND attendance_logs.PunchType=2) WHERE attendances.employees_id=employees.id AND attendances.Date=att.Date AND attendances.IsPayrollMade!=1 AND attendances.timetables_id=timetables.id');
    }

    public function syncOvertime(){
        $attendanceot=[];
        $weekdaysnumbers=[];
        $currdate = Carbon::today()->toDateString();
        $overtimedata=DB::select('SELECT attendances.employees_id,timetables.OnDutyTime,timetables.OffDutyTime,timetables.OvertimeStart,attendances.Date,attendances.PunchInTime,attendances.PunchOutTime,attendances.LateOvertime FROM attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id WHERE attendances.timetables_id!=1 AND attendances.IsPayrollMade!=1 AND attendances.LateOvertime>0');
        foreach($overtimedata as $row){
            $date = Carbon::parse($row->Date);
            $weekdayNumber = $date->dayOfWeek+1;
            $afterot=$row->LateOvertime;
            $otsetting=DB::select('SELECT * FROM overtimesettings INNER JOIN overtimes ON overtimesettings.overtime_id=overtimes.id WHERE overtimesettings.daynum='.$weekdayNumber.' AND overtimesettings.StartTime <= "'.$row->PunchOutTime.'"');
            foreach($otsetting as $otsetting){
                $startime=null;
                $endtime=null;
                
                if($otsetting->StartTime < $row->OvertimeStart){
                    $startime=$row->OvertimeStart;
                }
                if($otsetting->StartTime >= $row->OvertimeStart){
                    
                    $startime=$otsetting->StartTime;
                }

                if($otsetting->EndTime < $row->PunchOutTime){
                    $endtime=$otsetting->EndTime;
                }
                if($otsetting->EndTime >= $row->PunchOutTime){
                    $endtime=$row->PunchOutTime;
                }

                $startTime = Carbon::parse($currdate." ".$startime.":00");
                $endTime = Carbon::parse($currdate." ".$endtime.":00");
                $difference = $endTime->diffInMinutes($startTime);

                if($difference>0){
                    $attendanceot[]=['employees_id'=>$row->employees_id,'overtime_id'=>$otsetting->overtime_id,'daynum'=>$weekdayNumber,'Date'=>$row->Date,'OtStartTime'=>$startime,'OtEndTime'=>$endtime,'OtDurationMin'=>$difference,'Rate'=>$otsetting->WorkhourRate,'IsPayrollClosed'=>0,'Type'=>2,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                }
            }
        }

        $overtimearlydata=DB::select('SELECT attendances.employees_id,timetables.OnDutyTime,timetables.OffDutyTime,timetables.OvertimeStart,attendances.Date,attendances.PunchInTime,attendances.PunchOutTime,attendances.EarlyOvertime FROM attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id WHERE attendances.timetables_id!=1 AND attendances.IsPayrollMade!=1 AND attendances.EarlyOvertime!=0');
        foreach($overtimearlydata as $row){
            $date = Carbon::parse($row->Date);
            $weekdayNumber = $date->dayOfWeek+1;
            $afterot=$row->EarlyOvertime;
            $otsetting=DB::select('SELECT * FROM overtimesettings INNER JOIN overtimes ON overtimesettings.overtime_id=overtimes.id WHERE overtimesettings.daynum='.$weekdayNumber.' AND overtimesettings.StartTime <= "'.$row->PunchInTime.'"');
            foreach($otsetting as $otsetting){
                $startime=null;
                $endtime=null;
                
                if($otsetting->EndTime < $row->PunchInTime){
                    $startime=$row->EndTime;
                }
                if($otsetting->EndTime >= $row->PunchInTime){
                    
                    $startime=$row->PunchInTime;
                }

                if($otsetting->StartTime < $row->PunchInTime){
                    $endtime=$otsetting->EndTime;
                }
                if($otsetting->StartTime >= $row->PunchInTime){
                    $endtime=$row->PunchInTime;
                }

                $startTime = Carbon::parse($currdate." ".$startime.":00");
                $endTime = Carbon::parse($currdate." ".$endtime.":00");
                $difference = $endTime->diffInMinutes($startTime);

                if($difference>0){
                    $attendanceot[]=['employees_id'=>$row->employees_id,'overtime_id'=>$otsetting->overtime_id,'daynum'=>$weekdayNumber,'Date'=>$row->Date,'OtStartTime'=>$startime,'OtEndTime'=>$endtime,'OtDurationMin'=>$difference,'Rate'=>$otsetting->WorkhourRate,'IsPayrollClosed'=>0,'Type'=>1,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                }
            }

            $overtimedayoff=DB::select('SELECT attendances.employees_id,attendances.Date,attendances.PunchInTime,attendances.PunchOutTime,attendances.EarlyOvertime FROM attendances INNER JOIN timetables ON attendances.timetables_id=timetables.id WHERE attendances.timetables_id=1 AND attendances.IsPayrollMade!=1 AND attendances.TimeOpt IN(5)');
            foreach($overtimedayoff as $row){
                $date = Carbon::parse($row->Date);
                $weekdayNumber = $date->dayOfWeek+1;
        
                $otsetting=DB::select('SELECT overtime_dayoff_id,overtimes.WorkhourRate FROM settings INNER JOIN overtimes ON settings.overtime_dayoff_id=overtimes.id');
                foreach($otsetting as $otsetting){
                    $startTime = Carbon::parse($currdate." ".$row->PunchInTime.":00");
                    $endTime = Carbon::parse($currdate." ".$row->PunchOutTime.":00");
                    $difference = $endTime->diffInMinutes($startTime);
                    if($difference>0){
                        $attendanceot[]=['employees_id'=>$row->employees_id,'overtime_id'=>$otsetting->overtime_dayoff_id,'daynum'=>$weekdayNumber,'Date'=>$row->Date,'OtStartTime'=>$startime,'OtEndTime'=>$endtime,'OtDurationMin'=>$difference,'Rate'=>$otsetting->WorkhourRate,'IsPayrollClosed'=>0,'Type'=>3,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                    }
                }
            }
        }
        attendance_overtime::where('attendance_overtimes.IsPayrollClosed',0)->delete();
        attendance_overtime::insert($attendanceot);
    }

    public function getActivity(){
        $month=$_POST['month']; 
        $daynum=$_POST['daynumber']; 
        $empid=$_POST['employeeid']; 
        $fulldateformat=$month."-".$daynum;
        $fulldateformat = Carbon::parse($fulldateformat)->format('Y-m-d');

        $holidaydata = holiday::where('HolidayDate',$fulldateformat)->first();
        $holidayname = $holidaydata->HolidayName ?? "";

        $datename = \Carbon\Carbon::createFromFormat('Y-m-d', $fulldateformat)->format('d-F-Y');
        $dayname = Carbon::parse($fulldateformat)->format('l');
        $currentdatetimeAA = Carbon::createFromFormat('Y-m-d H:i:s',Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $attendances = attendance_summary::join('lookuprefs','attendance_summaries.Status','lookuprefs.id')
            ->where(DB::raw('DATE(attendance_summaries.Date)'),$fulldateformat)
            ->where('attendance_summaries.employees_id',$empid)
            ->orderBy('attendance_summaries.id','ASC')
            ->get(['attendance_summaries.*','lookuprefs.LookupName AS StatusValue',
                DB::raw('DATE_FORMAT(attendance_summaries.Date,"%d-%M-%Y") AS FullDateFormat'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.WorkingTimeAmount * 60),"%HH %iM") AS FormattedWorkHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.BreakTimeAmount * 60),"%HH %iM") AS FormattedBreakHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.TotalOvertimeAmount * 60),"%HH %iM") AS FormattedOvertimeHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.WorkHourPending * 60),"%HH %iM") AS FormattedWorkHourPen'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.BreakHourPending * 60),"%HH %iM") AS FormattedBreakHourPen'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.OvertimePending * 60),"%HH %iM") AS FormattedOvertimeHourPen'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.LateCheckInTimeAmount * 60),"%HH %iM") AS FormattedLateCheckInTimeAmount'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.EarlyCheckOutTimeAmount * 60),"%HH %iM") AS FormattedEarlyCheckOutTimeAmount'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.BeforeOnDutyTimeAmount * 60),"%HH %iM") AS FormattedBeforeOnDutyTimeAmount'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.AfterOffDutyTimeAmount * 60),"%HH %iM") AS FormattedAfterOffDutyTimeAmount'),
            ]);

        $attendacelog = attendance_log::where(DB::raw('DATE(attendance_logs.Date)'),$fulldateformat)->where('attendance_logs.employees_id',$empid)->orderBy('attendance_logs.Time','ASC')->get(['attendance_logs.*',DB::raw('DATE_FORMAT(STR_TO_DATE(attendance_logs.Time,"%H:%i"),"%h:%i %p") AS TimeFormatted')]);

        $empdata = employee::join('departments','employees.departments_id','departments.id')
            ->join('positions','employees.positions_id','positions.id')
            ->join('branches','employees.branches_id','=','branches.id')
            ->where('employees.Status',"Active")
            ->where('employees.id',$empid)
            ->get(['employees.id','employees.name','employees.departments_id','employees.ActualPicture','departments.DepartmentName','positions.PositionName','employees.BiometricPicture','employees.EmployeeID','branches.BranchName']);
        
        $attendancepunch=DB::select('SELECT attendances.PunchInTime AS PunchTime,"1" AS PunchType FROM attendances WHERE attendances.employees_id='.$empid.' AND attendances.Date="'.$fulldateformat.'" AND attendances.PunchInTime IS NOT NULL OR "" UNION
            SELECT attendances.BreakInTime AS PunchTime,"1" AS PunchType FROM attendances WHERE attendances.employees_id='.$empid.' AND attendances.Date="'.$fulldateformat.'" AND attendances.BreakInTime IS NOT NULL OR "" UNION
            SELECT attendances.BreakOutTime AS PunchTime,"2" AS PunchType FROM attendances WHERE attendances.employees_id='.$empid.' AND attendances.Date="'.$fulldateformat.'" AND attendances.BreakOutTime IS NOT NULL OR "" UNION
            SELECT attendances.PunchOutTime AS PunchTime,"2" AS PunchType FROM attendances WHERE attendances.employees_id='.$empid.' AND attendances.Date="'.$fulldateformat.'" AND attendances.PunchInTime IS NOT NULL OR "" ORDER BY PunchTime ASC');

        $shiftandtimetable=DB::select('SELECT shiftschedule_timetables.timetables_id,IFNULL(shifts.ShiftName,"") AS ShiftNameLabel,CONCAT(timetables.TimetableName,"(",timetables.OnDutyTime,"-",timetables.OffDutyTime,")") AS TimetabelLabel,
            shiftschedule_timetables.shifts_id,shiftschedule_timetables.timetables_id,shiftschedule_timetables.have_priority,CASE WHEN shiftscheduledetails.ScheduleType = 1 THEN "Permanent" ELSE "Temporary" END AS ScheduleTypeLabel
            FROM shiftschedule_timetables 
            LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id=shiftschedules.id
            LEFT JOIN shiftscheduledetails ON shiftschedule_timetables.shiftscheduledetails_id=shiftscheduledetails.id
            LEFT JOIN timetables ON shiftschedule_timetables.timetables_id=timetables.id
            LEFT JOIN shifts ON shiftschedule_timetables.shifts_id=shifts.id
            WHERE shiftscheduledetails.Status!="Void" AND shiftschedules.employees_id='.$empid.' AND shiftschedule_timetables.timetables_id!=1 AND shiftschedule_timetables.Date="'.$fulldateformat.'" ORDER BY timetables.OnDutyTime ASC');
        
        $dailyattendance=DB::select("SELECT 
            st.Date,
            COALESCE(s.ShiftName, '') AS Shift,  
            CASE WHEN tt.id > 1 THEN COALESCE(CONCAT(tt.TimetableName, ' (',tt.OnDutyTime,'-',tt.OffDutyTime,')'), '') ELSE '-' END AS TimetableName,
            IF(al.Time IS NOT NULL, CONCAT(al.Time,' | ',TIME_FORMAT(al.Time, '%h:%i %p')), '') AS Time,
            IF(al.Time IS NOT NULL, CONCAT(
                COALESCE(
                    CASE 
                        WHEN al.PunchType = 1 THEN 'Punch In' 
                        WHEN al.PunchType = 2 THEN 'Punch Out' 
                    END, ''
                ),
                ' (',
                CASE 
                    WHEN al.AttType = 1 THEN 'Manual'
                    WHEN al.AttType = 2 THEN 'Automated'
                    WHEN al.AttType = 3 THEN 'Auto-Generate'
                    ELSE 'Excel-Import'
                END,
                ')'
            ), '') AS Type,
            CASE WHEN asu.WorkingTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.WorkingTimeAmount * 60), '%HH %iM') ELSE '' END AS WorkingHour,
            CASE WHEN asu.WorkHourPending  > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.WorkHourPending * 60), '%HH %iM') ELSE '' END AS WorkingHourPending,
            CASE WHEN asu.BreakTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.BreakTimeAmount * 60), '%HH %iM') ELSE '' END AS BreakHour,
            CASE WHEN asu.BreakHourPending > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.BreakHourPending * 60), '%HH %iM') ELSE '' END AS BreakHourPending,
            CASE WHEN asu.TotalOvertimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.TotalOvertimeAmount * 60), '%HH %iM') ELSE '' END AS Overtime,
            CASE WHEN asu.OvertimePending > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.OvertimePending * 60), '%HH %iM') ELSE '' END AS OvertimePending,
            CASE WHEN asu.BeforeOnDutyTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.BeforeOnDutyTimeAmount * 60), '%HH %iM') ELSE '' END AS EarlyPunchIn,
            CASE WHEN asu.LateCheckInTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.LateCheckInTimeAmount * 60), '%HH %iM') ELSE '' END AS LatePunchIn,
            CASE WHEN asu.AfterOffDutyTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.AfterOffDutyTimeAmount * 60), '%HH %iM') ELSE '' END AS LatePunchOut,
            CASE WHEN asu.EarlyCheckOutTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.EarlyCheckOutTimeAmount * 60), '%HH %iM') ELSE '' END AS EarlyPunchOut,
            CASE WHEN lr.LookupName IS NOT NULL OR lr.LookupName!='' THEN lr.LookupName ELSE '' END AS AttendanceStatus

            FROM
                (SELECT st.*
                    FROM shiftschedule_timetables st
                    CROSS JOIN (
                        SELECT MAX(Date) AS max_date 
                        FROM attendance_summaries
                        WHERE employees_id = '$empid'
                    ) max_summary
                    WHERE st.have_priority = 1
                    AND st.Date <= max_summary.max_date
                ) st

            -- Join shiftschedules to get employee id
            JOIN shiftschedules ss ON ss.id = st.shiftschedules_id

            -- Join timetables for timetable info
            LEFT JOIN timetables tt ON tt.id = st.Timetables_id

            -- Join shifts for shift info
            LEFT JOIN shifts s ON s.id = st.shifts_id

            -- Join attendance_logs to get time for matching date, timetable and employee
            LEFT JOIN attendance_logs al 
                ON al.Date = st.Date
                AND al.Timetables_id = st.Timetables_id
                AND al.employees_id = ss.employees_id
                AND al.is_in_range = 1
                AND al.employees_id = '$empid'

            -- Join attendance_summaries to get WorkingTimeAmount and Status
            LEFT JOIN attendance_summaries asu
                ON asu.Date = st.Date
                AND asu.employees_id = ss.employees_id

            -- Join lookuprefs for Status name
            LEFT JOIN lookuprefs lr ON lr.id = asu.Status

            WHERE ss.employees_id = '$empid'
            AND st.Date = '".$fulldateformat."'
            ORDER BY st.Date ASC, tt.OnDutyTime ASC,al.Time ASC");
        
        
        return response()->json(['attend'=>$attendancepunch,'attworkhr'=>$attendances,'attlog'=>$attendacelog,
            'empdata'=>$empdata,'shiftandtimetbl'=>$shiftandtimetable,'datename'=>$datename,'dayname'=>$dayname,
            'dailyattendance'=>$dailyattendance,'currentdatetimeAA'=>$currentdatetimeAA,'holidayname'=>$holidayname
        ]);
    }

    public function employeelists(){
        $emplist = employee::where('employees.Status',"Active")->where('employees.id','>',1)->orderBy('employees.name','ASC')->get(['employees.id','employees.name','employees.departments_id']);
        return response()->json(['emplist'=>$emplist]);
    }

    public function attInfo(){
        $month=$_POST['month']; 
        $empid=$_POST['empid']; 
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $formatteddate = Carbon::parse($month)->format('F-Y');
        $currentdatetimeAA = Carbon::createFromFormat('Y-m-d H:i:s',Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $dates = [];
        $fulldates = [];
        $daterangeatt = CarbonPeriod::create($start,$end);
        foreach($daterangeatt as $daterangeatt){
            $dates[] = $daterangeatt->format('Y-m-d');
            $fulldates[]=[
                'FullDateFormat' => $daterangeatt->format('d-F-Y'),
                'DayName' => Carbon::parse($daterangeatt->format('Y-m-d'))->format('l'),
                'HolidayName' => $this->getHoliday($daterangeatt->format('Y-m-d'))
            ];
        }
        
        $attendances = attendance_summary::join('lookuprefs','attendance_summaries.Status','lookuprefs.id')
            ->where(DB::raw('DATE_FORMAT(attendance_summaries.Date,"%Y-%m")'),$month)
            ->where('attendance_summaries.employees_id',$empid)
            ->orderBy('attendance_summaries.id','ASC')
            ->get(['attendance_summaries.*','lookuprefs.LookupName AS StatusValue',
                DB::raw('DATE_FORMAT(attendance_summaries.Date,"%d-%M-%Y") AS FullDateFormat'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.WorkingTimeAmount * 60),"%HH %iM") AS FormattedWorkHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.BreakTimeAmount * 60),"%HH %iM") AS FormattedBreakHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.TotalOvertimeAmount * 60),"%HH %iM") AS FormattedOvertimeHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.WorkHourPending * 60),"%HH %iM") AS FormattedWorkHourPen'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.BreakHourPending * 60),"%HH %iM") AS FormattedBreakHourPen'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.OvertimePending * 60),"%HH %iM") AS FormattedOvertimeHourPen'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.LateCheckInTimeAmount * 60),"%HH %iM") AS FormattedLateCheckInTimeAmount'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.EarlyCheckOutTimeAmount * 60),"%HH %iM") AS FormattedEarlyCheckOutTimeAmount'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.BeforeOnDutyTimeAmount * 60),"%HH %iM") AS FormattedBeforeOnDutyTimeAmount'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(attendance_summaries.AfterOffDutyTimeAmount * 60),"%HH %iM") AS FormattedAfterOffDutyTimeAmount'),
            ]);

        $consattendances = attendance_summary::where(DB::raw('DATE_FORMAT(attendance_summaries.Date,"%Y-%m")'),$month)
            ->where('attendance_summaries.employees_id',$empid)
            ->get([DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(COALESCE(attendance_summaries.WorkingTimeAmount,0)) * 60),"%HH %iM") AS TotalFormattedWorkHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(COALESCE(attendance_summaries.BreakTimeAmount,0)) * 60),"%HH %iM") AS TotalFormattedBreakHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(COALESCE(attendance_summaries.TotalOvertimeAmount,0)) * 60),"%HH %iM") AS TotalFormattedOvertimeHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(COALESCE(attendance_summaries.WorkHourPending,0)) * 60),"%HH %iM") AS TotalFormattedWorkHourPen'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(COALESCE(attendance_summaries.BreakHourPending,0)) * 60),"%HH %iM") AS TotalFormattedBreakHourPen'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(COALESCE(attendance_summaries.OvertimePending,0)) * 60),"%HH %iM") AS TotalFormattedOvertimeHourPen'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(COALESCE(attendance_summaries.LateCheckInTimeAmount,0)) * 60),"%HH %iM") AS TotalLateCheckInHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(COALESCE(attendance_summaries.EarlyCheckOutTimeAmount,0)) * 60),"%HH %iM") AS TotalEarlyCheckOutHour'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(COALESCE(attendance_summaries.BeforeOnDutyTimeAmount,0)) * 60),"%HH %iM") AS TotalBeforeOnDutyTimeAmount'),
                DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(COALESCE(attendance_summaries.AfterOffDutyTimeAmount,0)) * 60),"%HH %iM") AS TotalAfterOffDutyTimeAmount'),
            ]);
            
        $attendacelog = attendance_log::where(DB::raw('DATE_FORMAT(attendance_logs.Date,"%Y-%m")'),$month)
            ->where('attendance_logs.employees_id',$empid)
            ->orderBy('attendance_logs.Time','ASC')
            ->get(['attendance_logs.*',DB::raw('DATE_FORMAT(STR_TO_DATE(attendance_logs.Time,"%H:%i"),"%h:%i %p") AS TimeFormatted')]);

        $empdata = employee::join('departments','employees.departments_id','departments.id')
        ->join('positions','employees.positions_id','positions.id')
        ->join('branches','employees.branches_id','=','branches.id')
        ->where('employees.Status',"Active")->where('employees.id',$empid)
        ->get(['employees.id','employees.name','employees.departments_id','employees.ActualPicture','departments.DepartmentName','positions.PositionName','employees.BiometricPicture','employees.EmployeeID','branches.BranchName']);

        $attendanceslog = attendance_log::where(DB::raw('DATE_FORMAT(attendance_logs.Date,"%Y-%m")'),$month)
            ->where('attendance_logs.employees_id',$empid)
            ->orderBy('attendance_logs.Time','ASC')
            ->orderBy('attendance_logs.Date','ASC')
            ->get(['attendance_logs.*',DB::raw('IFNULL(attendance_logs.Remark,"") AS Remark'),
                DB::raw('(SELECT attendance_summaries.IsPayrollMade FROM attendance_summaries WHERE attendance_summaries.employees_id=attendance_logs.employees_id AND attendance_summaries.Date=attendance_logs.Date ORDER BY attendance_summaries.id DESC LIMIT 1) AS IsPayrollMade')
        ]);

        $attendancepunch=DB::select('SELECT attendances.PunchInTime AS PunchTime,"1" AS PunchType,attendances.Date FROM attendances WHERE attendances.employees_id='.$empid.' AND DATE_FORMAT(attendances.Date,"%Y-%m")="'.$month.'" AND attendances.PunchInTime IS NOT NULL AND attendances.PunchInTime!="" UNION
            SELECT attendances.BreakInTime AS PunchTime,"1" AS PunchType,attendances.Date FROM attendances WHERE attendances.employees_id='.$empid.' AND DATE_FORMAT(attendances.Date,"%Y-%m")="'.$month.'" AND attendances.BreakInTime IS NOT NULL AND attendances.BreakInTime!="" AND attendances.BreakInTime!="00:00" UNION
            SELECT attendances.BreakOutTime AS PunchTime,"2" AS PunchType,attendances.Date FROM attendances WHERE attendances.employees_id='.$empid.' AND DATE_FORMAT(attendances.Date,"%Y-%m")="'.$month.'" AND attendances.BreakOutTime IS NOT NULL AND attendances.BreakOutTime!="" AND attendances.BreakOutTime!="00:00" UNION
            SELECT attendances.PunchOutTime AS PunchTime,"2" AS PunchType,attendances.Date FROM attendances WHERE attendances.employees_id='.$empid.' AND DATE_FORMAT(attendances.Date,"%Y-%m")="'.$month.'" AND attendances.PunchOutTime IS NOT NULL AND attendances.PunchOutTime!="" ORDER BY PunchTime ASC');

        $shiftandtimetable=DB::select('SELECT DISTINCT shiftschedule_timetables.Date,shiftschedule_timetables.timetables_id,IFNULL(shifts.ShiftName,"") AS ShiftNameLabel,CONCAT(timetables.TimetableName,"(",timetables.OnDutyTime,"-",timetables.OffDutyTime,")") AS TimetabelLabel,
            shiftschedule_timetables.shifts_id,shiftschedule_timetables.timetables_id,shiftschedule_timetables.have_priority,CASE WHEN shiftscheduledetails.ScheduleType = 1 THEN "Permanent" ELSE "Temporary" END AS ScheduleTypeLabel
            FROM shiftschedule_timetables 
            LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id=shiftschedules.id
            LEFT JOIN shiftscheduledetails ON shiftschedule_timetables.shiftscheduledetails_id=shiftscheduledetails.id
            LEFT JOIN timetables ON shiftschedule_timetables.timetables_id=timetables.id
            LEFT JOIN shifts ON shiftschedule_timetables.shifts_id=shifts.id
            WHERE shiftscheduledetails.Status!="Void" AND shiftschedules.employees_id='.$empid.' AND DATE_FORMAT(shiftschedule_timetables.Date,"%Y-%m")="'.$month.'" ORDER BY timetables.OnDutyTime ASC');

        $monthlyattendance=DB::select("SELECT 
            CONCAT(st.Date,' (',DAYNAME(st.Date),')') AS Date,
            COALESCE(s.ShiftName, '') AS Shift,  
            CASE WHEN tt.id > 1 THEN COALESCE(CONCAT(tt.TimetableName, ' (',tt.OnDutyTime,'-',tt.OffDutyTime,')'), '') ELSE '-' END AS TimetableName,
            IF(al.Time IS NOT NULL, CONCAT(al.Time,' | ',TIME_FORMAT(al.Time, '%h:%i %p')), '') AS Time,
            IF(al.Time IS NOT NULL, CONCAT(
                COALESCE(
                    CASE 
                        WHEN al.PunchType = 1 THEN 'Punch In' 
                        WHEN al.PunchType = 2 THEN 'Punch Out' 
                    END, ''
                ),
                ' (',
                CASE 
                    WHEN al.AttType = 1 THEN 'Manual'
                    WHEN al.AttType = 2 THEN 'Automated'
                    WHEN al.AttType = 3 THEN 'Auto-Generate'
                    ELSE 'Excel-Import'
                END,
                ')'
            ), '') AS Type,
            CASE WHEN asu.WorkingTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.WorkingTimeAmount * 60), '%HH %iM') ELSE '' END AS WorkingHour,
            CASE WHEN asu.WorkHourPending  > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.WorkHourPending * 60), '%HH %iM') ELSE '' END AS WorkingHourPending,
            CASE WHEN asu.BreakTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.BreakTimeAmount * 60), '%HH %iM') ELSE '' END AS BreakHour,
            CASE WHEN asu.BreakHourPending > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.BreakHourPending * 60), '%HH %iM') ELSE '' END AS BreakHourPending,
            CASE WHEN asu.TotalOvertimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.TotalOvertimeAmount * 60), '%HH %iM') ELSE '' END AS Overtime,
            CASE WHEN asu.OvertimePending > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.OvertimePending * 60), '%HH %iM') ELSE '' END AS OvertimePending,
            CASE WHEN asu.BeforeOnDutyTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.BeforeOnDutyTimeAmount * 60), '%HH %iM') ELSE '' END AS EarlyPunchIn,
            CASE WHEN asu.LateCheckInTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.LateCheckInTimeAmount * 60), '%HH %iM') ELSE '' END AS LatePunchIn,
            CASE WHEN asu.AfterOffDutyTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.AfterOffDutyTimeAmount * 60), '%HH %iM') ELSE '' END AS LatePunchOut,
            CASE WHEN asu.EarlyCheckOutTimeAmount > 0 THEN DATE_FORMAT(SEC_TO_TIME(asu.EarlyCheckOutTimeAmount * 60), '%HH %iM') ELSE '' END AS EarlyPunchOut,
            CASE WHEN lr.LookupName IS NOT NULL OR lr.LookupName!='' THEN lr.LookupName ELSE '' END AS AttendanceStatus

        FROM
            (SELECT st.*
                FROM shiftschedule_timetables st
                CROSS JOIN (
                    SELECT MAX(Date) AS max_date 
                    FROM attendance_summaries
                    WHERE employees_id = '$empid'
                ) max_summary
                WHERE st.have_priority = 1
                AND st.Date <= max_summary.max_date
            ) st

        -- Join shiftschedules to get employee id
        JOIN shiftschedules ss ON ss.id = st.shiftschedules_id

        -- Join timetables for timetable info
        LEFT JOIN timetables tt ON tt.id = st.Timetables_id

        -- Join shifts for shift info
        LEFT JOIN shifts s ON s.id = st.shifts_id

        -- Join attendance_logs to get time for matching date, timetable and employee
        LEFT JOIN attendance_logs al 
            ON al.Date = st.Date
            AND al.Timetables_id = st.Timetables_id
            AND al.employees_id = ss.employees_id
            AND al.is_in_range = 1
            AND al.employees_id = '$empid'

        -- Join attendance_summaries to get WorkingTimeAmount and Status
        LEFT JOIN attendance_summaries asu
            ON asu.Date = st.Date
            AND asu.employees_id = ss.employees_id

        -- Join lookuprefs for Status name
        LEFT JOIN lookuprefs lr ON lr.id = asu.Status

        WHERE ss.employees_id = '$empid'
        AND DATE_FORMAT(st.Date, '%Y-%m') = '".$month."'
        ORDER BY st.Date ASC, tt.OnDutyTime ASC, al.Time ASC");
        
        return Response::json(['dates'=>$dates,'formatteddate'=>$formatteddate,'attendanceslog'=>$attendanceslog,'attlog'=>$attendacelog,'attworkhr'=>$attendances,'consattendances'=>$consattendances,'empdata'=>$empdata,'fulldayformat'=>$fulldates,'attend'=>$attendancepunch,'shiftandtimetbl'=>$shiftandtimetable,'monthlyattendance'=>$monthlyattendance,'currentdatetimeAA'=>$currentdatetimeAA]);
    }

    public function getHoliday($fulldateformat){
        $holidaydata = holiday::where('HolidayDate',$fulldateformat)->first();
        $holidayname = $holidaydata->HolidayName ?? "";

        return $holidayname;
    }

    public function getActivityDetail(){
        $recordId=$_POST['recordId']; 
        $attendacelog = attendance_log::where('attendance_logs.id',$recordId)->get(['attendance_logs.*',DB::raw('DATE_FORMAT(STR_TO_DATE(attendance_logs.Time,"%H:%i"),"%h:%i %p") AS TimeFormatted')]);

        return Response::json(['attendacelog'=>$attendacelog]);
    }

    public function getOffShift(){
        $month=$_POST['month']; 
        $empid=$_POST['employeeid']; 

        $empdata = employee::where('employees.Status',"Active")->where('employees.id',$empid)->get(['employees.id','employees.name','employees.departments_id','employees.ActualPicture']);

        $attendances = attendance_summary::join('lookuprefs','attendance_summaries.Status','lookuprefs.id')
            ->where(DB::raw('DATE_FORMAT(attendance_summaries.Date,"%Y-%m")'),$month)
            ->where('attendance_summaries.employees_id',$empid)
            ->whereIn('attendance_summaries.Status',[12,13,15])
            ->orderBy('attendance_summaries.Date','ASC')
            ->get(['attendance_summaries.*',DB::raw('CONCAT(attendance_summaries.Date," (",DATE_FORMAT(attendance_summaries.Date,"%W"),")") AS DateWithName'),'lookuprefs.LookupName AS StatusValue']);
        
        return Response::json(['attendances'=>$attendances,'empdata'=>$empdata]);
    }

    public function offShiftConfirmation(){
        ini_set('max_execution_time', '30000000');
        ini_set("pcre.backtrack_limit", "500000000");
        $selectedrec=$_POST['selectedrec']; 
        $contype=$_POST['contype']; 
        $selectedrec = explode(',', $selectedrec);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $currentime = Carbon::now()->format('H:i');
        $time=[];
        $date=[];
        $employeeid=[];
        $queryResult=[];
        $statusname=null;

        if($contype == 1){
            $statusname = "Approved";
        }
        else if($contype == 2){
            $statusname = "Rejected";
        }
        else{
            $statusname = "Change to Pending";
        }
         
        try{
            attendance_summary::whereIn('id',$selectedrec)->update(['OffShiftStatus'=>$contype]);
            foreach($selectedrec as $selectedrec){
                $attsumm = DB::table('attendance_summaries')
                    ->where('id',$selectedrec)
                    ->selectRaw("attendance_summaries.employees_id,attendance_summaries.Date")
                    ->first();

                $this->checkAttendanceStatus($attsumm->employees_id,$attsumm->Date);

                actions::insert(['user_id'=>$userid,'pageid'=>$selectedrec,'pagename'=>"attendance",'action'=>$statusname,'status'=>$statusname,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            }
            return Response::json(['success' =>1]);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
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
