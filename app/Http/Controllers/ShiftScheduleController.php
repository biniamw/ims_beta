<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\Models\actions;
use App\Models\attendance;
use App\Models\attendance_log;
use App\Models\shift;
use App\Models\shiftdetail;
use App\Models\timetable;
use App\Models\shift_day_time;
use App\Models\shift_day;
use App\Models\department;
use App\Models\employee;
use App\Models\shiftschedule;
use App\Models\holiday;
use App\Models\shiftscheduledetail;
use App\Models\shiftschedule_timetable;
use App\Http\Controllers\AttendanceController;
use App\Services\HRServices;
use Carbon\CarbonPeriod;
use Response;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Exception;

class ShiftScheduleController extends Controller
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
        $currentdate = Carbon::today()->toDateString();
        $shift = shift::orderBy("ShiftName","ASC")->where("Status","Active")->where("ShiftFlag",1)->get(["ShiftName","id"]);
        $timetblist = timetable::where('timetables.Status',"Active")->where('timetables.id','>',1)->orderBy('timetables.OnDutyTime','ASC')->get(['timetables.*',DB::raw('CONCAT(TimetableName," (", OnDutyTime,"-",OffDutyTime,")") AS NameWithTime')]);
        $emplist = employee::where('EnableAttendance','Yes')->where('employees.Status',"Active")->where('employees.id','>',1)->orderBy('employees.name','ASC')->get(['employees.id','employees.name','employees.departments_id','employees.branches_id','employees.positions_id']);
        $branchfilter = DB::select('SELECT DISTINCT branches.id,branches.BranchName FROM shiftschedules LEFT JOIN employees ON shiftschedules.employees_id=employees.id LEFT JOIN branches ON employees.branches_id=branches.id ORDER BY branches.BranchName ASC');        
        $departmentfilter = DB::select('SELECT DISTINCT departments.id,departments.DepartmentName FROM shiftschedules LEFT JOIN employees ON shiftschedules.employees_id=employees.id LEFT JOIN departments ON employees.departments_id=departments.id WHERE departments.id>1 ORDER BY departments.DepartmentName ASC');  
        if($request->ajax()) {
            return view('hr.shiftsch',['timetblist'=>$timetblist,'shift'=>$shift,'emplist'=>$emplist,'currentdate'=>$currentdate,'branchfilter'=>$branchfilter,'departmentfilter'=>$departmentfilter])->renderSections()['content'];
        }
        else{
            return view('hr.shiftsch',['timetblist'=>$timetblist,'shift'=>$shift,'emplist'=>$emplist,'currentdate'=>$currentdate,'branchfilter'=>$branchfilter,'departmentfilter'=>$departmentfilter]);
        }
    }

    public function singletimetable($id){
        $singletimetbl = timetable::where('timetables.id',$id)->get(['timetables.*',DB::raw('IFNULL(timetables.BreakStartTime,"") AS BreakStartTimes'),DB::raw('IFNULL(timetables.BreakEndTime,"") AS BreakEndTimes'),DB::raw('IFNULL(timetables.BreakHour,"0") AS BreakHours')]);
        return response()->json(['singletimetbl'=>$singletimetbl]);
    }

    public function employeeshiftlist()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();

        $employelists=DB::select("SELECT 
            shiftschedules.id,
            employees.EmployeeID,
            employees.name,
            branches.BranchName,
            departments.DepartmentName,
            positions.PositionName,
            salaries.SalaryName,
            emp.name AS LineManager,
            employementtypes.EmploymentTypeName,
            employees.Gender,
            employees.Status,
            employees.ActualPicture,
            employees.BiometricPicture,
            CASE 
                WHEN shiftschedules.ShiftFlag = 1 THEN 'Group' 
                WHEN shiftschedules.ShiftFlag = 2 THEN 'Individual' 
                ELSE '' 
            END AS AssignmentType,
            IFNULL((
                SELECT GROUP_CONCAT(shifts.ShiftName ORDER BY shifts.ShiftName ASC SEPARATOR ', ')
                FROM shifts 
                WHERE shifts.id IN (
                    SELECT DISTINCT shiftschedule_timetables.shifts_id 
                    FROM shiftschedule_timetables 
                    LEFT JOIN shiftscheduledetails ON shiftschedule_timetables.shiftscheduledetails_id = shiftscheduledetails.id 
                    WHERE shiftschedule_timetables.shiftschedules_id = shiftschedules.id 
                    AND shiftscheduledetails.Status = 'Active'
                )
            ), '-') AS Shifts
            FROM shiftschedules
            LEFT JOIN employees ON shiftschedules.employees_id = employees.id
            LEFT JOIN branches ON employees.branches_id = branches.id
            LEFT JOIN departments ON employees.departments_id = departments.id
            LEFT JOIN positions ON employees.positions_id = positions.id
            LEFT JOIN salaries ON employees.salaries_id = salaries.id
            LEFT JOIN employees AS emp ON employees.employees_id = emp.id
            LEFT JOIN employementtypes ON employees.employementtypes_id = employementtypes.id
            ORDER BY employees.name ASC");

        if(request()->ajax()) {
            return datatables()->of($employelists)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn='<a class="shiftsch" href="javascript:void(0)" onclick="shiftschFn('.$data->id.')" data-id="'.$data->id.'" title="Show Shift Schedule Info"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function departmentlist(){
        $deplist = employee::join('departments','employees.departments_id','departments.id')->where('departments.Status',"Active")->where('employees.Status',"Active")->where('employees.departments_id','>',1)->distinct()->orderBy('employees.name','ASC')->get(['departments.DepartmentName','employees.departments_id']);
        $emplist = employee::where('employees.Status',"Active")->orderBy('employees.name','ASC')->get(['employees.id','employees.name','employees.departments_id']);
        return response()->json(['deplist'=>$deplist,'emplist'=>$emplist]);
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
        ini_set('max_execution_time', '30000000');
        ini_set("pcre.backtrack_limit", "500000000");
        $attController = new AttendanceController();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $manage=$request->manageshift;
        $headerid=$request->recId;
        $findid=$request->recId;
        $checkflag=$request->checkFlag;
        $selectedshift=$request->ShiftName;
        $employeeval=$request->employees;
        $scheduleType=$request->ScheduleType;

        if($selectedshift==null){
            $selectedshift=0;
        }
        else if($selectedshift!=null){
            $selectedshift=implode(',', $selectedshift);
        }

        if($employeeval==null){
            $employeeval=0;
        }
        else if($employeeval!=null){
            $employeeval=implode(',', $employeeval);
        }
        
        $curdate=Carbon::today()->toDateString();
        $datas=[];
        $holidaysdate=[];
        $shschedule=[];
        $selectedshiftandtime=[];
        $offdutytime=[];
        $overlappedcount=0;
        $datesterrorflag=0;
        $datesterrordata=[];
        $overlappeda=[];
        $overlappedb=[];
        $shiftdataval=[];
        $absentdata=[];
        $firstdate=null;
        $lastdate=null;
        $daterangeval=null;

        $dateDay = \Carbon\Carbon::now();//use your date to get month and year
        $year = $dateDay->year;
        $month = $dateDay->month;
        $days = $dateDay->daysInMonth;
        $mondays=[];
        $tuesday=[];
        $shiftdays=[];
        $shiftdaysingle=[];
        $arraycheck=[];
        $payrollflagdata=[];
        $payrollmadeemp=[];
        $payrollmadedates=[];
        $payrollmadeattids=[];
        $alldates=[];
        $alldatesdel=[];
        $payrollclosedflag=0;
        $existcount=0;
        $checkMondayFlag = 0;
        $empoverlappedid=[];
        $shiftoverlappedid=[];
        $overlappeddata=[];
        $holidaysdate=[];
        $assignmentType=$request->AssignmentType;
        $shiftdetailId=$request->shiftScheduleDetail;
        
        $arraycontent = explode(" - ",$request->datetimes);

        if($employeeval!=null && $selectedshift!=null && $shiftdetailId==null){
            $validrange = CarbonPeriod::create($arraycontent[0],$arraycontent[1]);
            foreach($request->input('employees') as $emid){
                foreach($request->input('ShiftName') as $shid){
                    foreach($validrange as $validrangedata){
                        $exists = DB::table('shiftschedule_timetables')
                            ->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                            ->join('shiftscheduledetails','shiftschedule_timetables.shiftscheduledetails_id','shiftscheduledetails.id')
                            ->join('shifts','shiftschedule_timetables.shifts_id','shifts.id')
                            ->join('employees','shiftschedules.employees_id','employees.id')
                            ->where('shiftschedule_timetables.Date','=',Carbon::parse($validrangedata)->format('Y-m-d'))
                            ->where('shiftschedules.employees_id', '=',$emid)
                            ->where('shiftscheduledetails.ScheduleType',$scheduleType)
                            ->get(['employees.name AS EmployeeName','shifts.ShiftName','shiftschedule_timetables.Date']);

                        if ($exists->isNotEmpty()) {
                            $existcount+=1;
                            $empoverlappedid[]=$emid;
                            $shiftoverlappedid[]=$shid;
                            $overlappeddata[]=$exists[0]->EmployeeName.", ".$exists[0]->ShiftName.", ".$exists[0]->Date."</br>";
                        } 
                    }
                }
            }
        }

        $getalltimetable=DB::select('SELECT timetables.OnDutyTime,timetables.OffDutyTime,timetables.BeginningIn,timetables.EndingOut,shift_day_times.* FROM shift_day_times INNER JOIN timetables ON shift_day_times.timetables_id=timetables.id WHERE shift_day_times.shifts_id IN('.$selectedshift.') AND timetables.Status="Active"');
        foreach($getalltimetable as $tablerow)
        {
            $selectedshiftandtime[]=((object)['daynum'=>$tablerow->daynum,'shifts_id'=>$tablerow->shifts_id,'OnDutyTime'=>$tablerow->OnDutyTime,'OffDutyTime'=>$tablerow->OffDutyTime,'BeginningIn'=>$tablerow->BeginningIn,'EndingOut'=>$tablerow->EndingOut]);
        }

        $getoverlapped=DB::select('SELECT timetables.OnDutyTime,timetables.OffDutyTime,timetables.BeginningIn,timetables.EndingOut,shift_day_times.* FROM shift_day_times INNER JOIN timetables ON shift_day_times.timetables_id=timetables.id WHERE shift_day_times.shifts_id IN('.$selectedshift.') AND timetables.Status="Active"');
        foreach($getoverlapped as $overlaprow)
        {
            foreach($selectedshiftandtime as $choverlaprow)
            {
                if($choverlaprow->shifts_id != $overlaprow->shifts_id && $choverlaprow->daynum == $overlaprow->daynum)
                {
                    if($choverlaprow->BeginningIn > $overlaprow->BeginningIn && $choverlaprow->BeginningIn > $overlaprow->EndingOut){
                        $overlappedcount+=0;
                    }
                    if($choverlaprow->EndingOut < $overlaprow->BeginningIn && $choverlaprow->EndingOut < $overlaprow->EndingOut){
                        $overlappedcount+=0;
                    }
                    else if($choverlaprow->BeginningIn > $overlaprow->BeginningIn && $choverlaprow->BeginningIn < $overlaprow->EndingOut){
                        $overlappedcount+=1;
                        $overlappeda[]=$choverlaprow->shifts_id;
                        $overlappedb[]=$overlaprow->shifts_id;
                    }
                    else if($choverlaprow->EndingOut > $overlaprow->BeginningIn && $choverlaprow->EndingOut < $overlaprow->EndingOut){
                        $overlappedcount+=1;
                        $overlappeda[]=$choverlaprow->shifts_id;
                        $overlappedb[]=$overlaprow->shifts_id;
                    }
                }
            }
        } 

        if($employeeval!=null){
            foreach($request->input('employees') as $employeeid){
                $attendanceid=null;
                $alldates=[];
                $alldatesdel=[];
                $validrange = CarbonPeriod::create($arraycontent[0],$arraycontent[1]);
                foreach($validrange as $validrangedata){
                    $datevalue=Carbon::parse($validrangedata)->format('Y-m-d');
                    $alldatesdel[]=Carbon::parse($validrangedata)->format('Y-m-d');
                    $countpayrollatt = DB::table('attendances')->where('employees_id',$employeeid)->where('Date',$datevalue)->where('IsPayrollMade',1)->get();
                    $attcnt = $countpayrollatt->count();

                    if($attcnt>0){
                        $payrollmadeemp[]=$employeeid;
                        $payrollmadedates[]='"'.$datevalue.'"';
                        $alldates[]=$datevalue;
                        $payrollmadeattids[]=$attendanceid;
                        $payrollclosedflag+=1;
                    }
                }
            }
        }

        if($selectedshift!=null){
            foreach($request->input('ShiftName') as $shiftval){
                $shiftdt=shift::findorFail($shiftval);
                if($shiftdt->CycleUnit==3 && $arraycontent[0]!=null){
                    if (Carbon::parse($arraycontent[0])->isMonday()===false) {
                        $datesterrorflag+=1;
                        $datesterrordata[]=$shiftval;
                    }
                }
            }
        }

        if($request->datetimes==null){
            $daterangeval="";
        }
        if($request->datetimes!=null){
            $daterangeval=$arraycontent[0]." to ".$arraycontent[1];
        }

        
        $holidays=holiday::get(['HolidayDate']);
        foreach ($holidays as $holidays) {
            $holidaysdate[] = $holidays->HolidayDate;
        }

        if($request->CycleUnit == 3){
            if(Carbon::parse($arraycontent[0])->format('l') == "Monday"){
                $checkMondayFlag = 0;
            }
            else{
                $checkMondayFlag = 1;
            }
        }

        $validator = Validator::make($request->all(), [
            'ShiftName' => 'required_if:manageshift,1',
            'datetimes' => 'required',
            'employees' => 'required',
        ]);

        if ($validator->passes() && $overlappedcount==0 && $datesterrorflag==0 && $payrollclosedflag==0 && $existcount==0 && $checkMondayFlag==0){
            
            DB::beginTransaction();

            try
            {
                $selectedOptions = $request->input('ShiftName', []);
                $firstShiftOption = !empty($selectedOptions) ? (int)$selectedOptions[0] : null; // Get first selected
                
                // Get all dates in range (optimized)
                $startDate = Carbon::parse($arraycontent[0]);
                $endDate = Carbon::parse($arraycontent[1]);
                $datesInRange = [];
                while ($startDate <= $endDate) {
                    $datesInRange[] = $startDate->format('Y-m-d');
                    $startDate->addDay();
                }

                foreach($request->input('ShiftName') as $shid){
                    $shiftData = DB::table('shift_day_times')
                        ->join('shifts', 'shift_day_times.shifts_id', '=', 'shifts.id')
                        ->where('shift_day_times.shifts_id', $shid)
                        ->orderBy('shift_day_times.daynum')
                        ->get();

                    // Group timetable data by daynum
                    $timetableData = DB::table('shift_day_times')
                        ->where('shifts_id', $shid)
                        ->get()
                        ->groupBy('daynum');

                    $cycleParams = $this->calculateCycleParameters($shiftData, $arraycontent[0], $arraycontent[1]); 
                }

                // Check payroll statuses in bulk
                $payrollStatuses = DB::table('attendance_summaries')
                    ->whereIn('employees_id', $request->input('employees'))
                    ->whereIn('Date', $datesInRange)
                    ->where('IsPayrollMade', 1)
                    ->get()
                    ->groupBy(['employees_id', 'Date']);

                foreach($request->input('employees') as $row){

                    $payrollDates = $payrollStatuses[$row] ?? [];
                    $payrollmadeemp = [];
                    $payrollmadedates = [];
                    $alldates = [];
                    $payrollmadeattids = [];
                    $payrollclosedflag = 0;

                    foreach ($datesInRange as $datevalue) {
                        if (isset($payrollDates[$datevalue])) {
                            $payrollmadeemp[] = $row;
                            $payrollmadedates[] = '"' . $datevalue . '"';
                            $alldates[] = $datevalue;
                            $payrollmadeattids[] = null;
                            $payrollclosedflag++;
                        }
                    }

                    $BasicValShc = [
                        'employees_id' => $row,
                        'Date' => $daterangeval,
                        'CheckInNotReq' => $request->input('checkinnotreq',0),
                        'CheckOutNotReq' =>$request->input('checkoutnotreq',0),
                        'ScheduleOnHoliday' =>$request->input('scheduledholiday',0),
                        'EffectiveOt' =>$request->input('effectiveot',0),
                    ];

                    $DbDataShc = shiftschedule::where('employees_id', $row)->first();
                    $CreatedBySch = ['CreatedBy' => $user];
                    $LastUpdatedBySch = ['LastEditedBy' => $user];

                    $shiftsch=shiftschedule::updateOrCreate(['employees_id'=>$row],
                        array_merge($BasicValShc, $DbDataShc ? $LastUpdatedBySch : $CreatedBySch),
                    );

                    $BasicShcDet = [
                        'shiftschedules_id' => $shiftsch->id,
                        'shifts_id' => $firstShiftOption,
                        'ValidDate' => $daterangeval,
                        'CheckInNotReq' => $request->input('checkinnotreq',0),
                        'CheckOutNotReq' =>$request->input('checkoutnotreq',0),
                        'ScheduleOnHoliday' =>$request->input('scheduledholiday',0),
                        'EffectiveOt' =>$request->input('effectiveot',0),
                        'ShiftFlag' => $assignmentType,
                        'ScheduleType' => $scheduleType,
                        'Status' => ($curdate >= $arraycontent[0] && $curdate <= $arraycontent[1]) ? "Active" : (($curdate > $arraycontent[1]) ? "Expired" : "To-be-Active"),
                    ];

                    $DbDataShcDet = shiftscheduledetail::where('id', $shiftdetailId)->first();
                    $CreatedDateSchDet = ['created_at' => Carbon::now()];
                    $LastUpdatedDateSch = ['updated_at' => Carbon::now()];

                    $shiftschdet=shiftscheduledetail::updateOrCreate(['id'=>$shiftdetailId],
                        array_merge($BasicShcDet, $DbDataShcDet ? $LastUpdatedDateSch : $CreatedDateSchDet),
                    );

                    // Generate schedule data in bulk
                    $shschedule = $this->generateScheduleData(
                        $employeeid,
                        $datesInRange,
                        $shiftData,
                        $timetableData,
                        $holidaysdate,
                        $shiftsch->id,
                        $shiftschdet->id,
                        $assignmentType,
                        $arraycontent,
                        $cycleParams
                    ); 

                    // Bulk update priority
                    shiftschedule_timetable::join('shiftschedules', 'shiftschedule_timetables.shiftschedules_id', 'shiftschedules.id')
                        ->join('shiftscheduledetails', 'shiftschedule_timetables.shiftscheduledetails_id', 'shiftscheduledetails.id')
                        ->where('shiftschedules.employees_id', $row)
                        ->whereBetween('shiftschedule_timetables.Date', [$arraycontent[0], $arraycontent[1]])
                        ->update(['shiftschedule_timetables.have_priority' => 0]);

                    $this->syncShiftSchedules($shschedule);

                    // Update shift schedule dates
                    $this->updateShiftScheduleDates($shiftsch->id);

                    // Update attendance records
                    $this->updateAttendanceRecords($employeeid, $shiftschdet->id);

                    // Log action
                    $actions = $shiftdetailId ? "Edited" : "Created";
                    actions::insert([
                        'user_id' => $userid,
                        'pageid' => $shiftschdet->id,
                        'pagename' => "shiftschdet",
                        'action' => $actions,
                        'status' => $actions,
                        'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                        'reason' => "",
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }

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
        if($overlappedcount>0){
            $overlapshiftida=implode(',', $overlappeda);
            $overlapshiftidb=implode(',', $overlappedb);
            $getoverlappeda=DB::select('SELECT shifts.ShiftName FROM shifts WHERE shifts.id IN('.$overlapshiftida.')');
            $getoverlappedb=DB::select('SELECT shifts.ShiftName FROM shifts WHERE shifts.id IN('.$overlapshiftidb.')');
            return Response::json(['overlappederror'=>462,'getoverlappeda'=>$getoverlappeda,'getoverlappedb'=>$getoverlappedb]);
        }
        if($datesterrorflag>0){
            $datesterrordata=implode(',', $datesterrordata);
            $getshiftname=DB::select('SELECT shifts.ShiftName FROM shifts WHERE shifts.id IN('.$datesterrordata.')');
            return Response::json(['datesterror'=>462,'getshiftname'=>$getshiftname]);
        }
        if($payrollclosedflag>0){
            $payrollmadeempimp=implode(',', $payrollmadeemp);
            $payrollmadedatesimp=implode(',', $payrollmadedates);
            $payrollmadeattidsimp=implode(',', $payrollmadeattids);
            $getpayrollmadename=DB::select('SELECT DISTINCT employees.name,attendances.Date FROM attendances INNER JOIN employees ON attendances.employees_id=employees.id WHERE attendances.employees_id IN('.$payrollmadeempimp.') AND attendances.Date IN('.$payrollmadedatesimp.') ORDER BY name ASC, attendances.Date ASC');
            return Response::json(['payrollmadeerror'=>462,'payrollmadename'=>$getpayrollmadename]);
        }
        if($existcount>0){
            return Response::json(['existanceerr'=>462,'existancename'=>$overlappeddata]);
        }
        if($checkMondayFlag==1){
            return Response::json(['mondayflagerr'=>462]);
        }
    }

    public function saveIndShift(Request $request)
    {
        ini_set('max_execution_time', '30000000');
        ini_set("pcre.backtrack_limit", "500000000");
        $data = $request->all();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->recId;
        $findid=$request->recId;
        $checkflag=$request->checkFlag;
        $curdate=Carbon::today()->toDateString();
        $checkerrorflag=0;
        $shiftDetails = [];
        $defaultday=1;
        $employeeval=$request->EmployeeName;
        $assignmentType=$request->AssignmentType;
        $scheduleType=$request->ScheduleType;
        $shiftreqid=$request->ShiftId;
        $shiftdetailId=$request->shiftScheduleDetail;

        $existcount=0;
        $empoverlappedid=[];
        $shiftoverlappedid=[];
        $overlappeddata=[];
        $checkMondayFlag = 0;
        $arrayData = [];
        $shiftdayarr = [];
        $shiftdaytimearr = [];
        $selectedopt = (int)$request->selectedLength;
        $holidaysdate=[];

        $holidays=holiday::get(['HolidayDate']);
        foreach ($holidays as $holidays) {
            $holidaysdate[] = $holidays->HolidayDate;
        }

        $validator = Validator::make($data, [

            'CycleNumber' => 'required',
            'CycleUnit' => 'required',
            'status' => 'required|string',
            'EmployeeName' => 'required',
            'dateRange' => 'required',
            'ScheduleType' => 'required',
        ]);

        if($checkflag!=1){
            $checkerrorflag=1;
        }

        $arraycontentdate = explode(" - ",$request->dateRange);
        if($employeeval!=null && $request->dateRange!=null && $shiftdetailId==null){
            
            $validrange = CarbonPeriod::create($arraycontentdate[0],$arraycontentdate[1]);
            foreach($request->input('EmployeeName') as $emid){
                foreach($validrange as $validrangedata){
                    $exists = DB::table('shiftschedule_timetables')
                        ->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                        ->join('shiftscheduledetails','shiftschedule_timetables.shiftscheduledetails_id','shiftscheduledetails.id')
                        ->join('shifts','shiftschedule_timetables.shifts_id','shifts.id')
                        ->join('employees','shiftschedules.employees_id','employees.id')
                        ->where('shiftschedule_timetables.Date','=',Carbon::parse($validrangedata)->format('Y-m-d'))
                        ->where('shiftschedules.employees_id', '=',$emid)
                        ->where('shiftscheduledetails.ScheduleType',$scheduleType)
                        ->get(['employees.name AS EmployeeName','shifts.ShiftName','shiftschedule_timetables.Date']);

                    if ($exists->isNotEmpty()) {
                        $existcount+=1;
                        $overlappeddata[]=$exists[0]->EmployeeName.", ".$exists[0]->ShiftName.", ".$exists[0]->Date."</br>";
                    } 
                }
            }
        }

        if($request->CycleUnit == 3){
            if(Carbon::parse($arraycontentdate[0])->format('l') == "Monday"){
                $checkMondayFlag = 0;
            }
            else{
                $checkMondayFlag = 1;
            }
        }
      
        if ($validator->passes() && $checkerrorflag==0 && $selectedopt > 0 && $existcount==0 && $checkMondayFlag==0){
            
            DB::beginTransaction();
            
            try
            {
                $arraycontent = explode(" - ",$request->dateRange);
                if($request->dateRange==null){
                    $daterangeval="";
                }
                if($request->dateRange!=null){
                    $daterangeval=$arraycontent[0]." to ".$arraycontent[1];
                }

                $BasicVal = [
                    'ShiftName' => "",
                    'CycleNumber' => $request->CycleNumber,
                    'CycleUnit' => $request->CycleUnit,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                    'ShiftFlag' => 2,
                ];

                $DbData = shift::where('id', $shiftreqid)->first();
                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $shift = shift::updateOrCreate(['id' => $shiftreqid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                foreach ($request->row as $key => $value){
                    $shiftdayarr[] = [
                        'shifts_id'=>$shift->id,
                        'daynum'=>$value['vals'],
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now(),
                    ];

                    $selectedValues = $request->input('timetables'.$value['vals']) ?? [1];
                    
                    foreach($selectedValues as $timetbl){
                        $shiftdaytimearr[] = [
                            'shifts_id' => $shift->id,
                            'timetables_id' => $timetbl,
                            'daynum' => $value['vals'],
                            'created_at'=>Carbon::now(),
                            'updated_at'=>Carbon::now(),
                        ];
                    }
                }

                $this->syncShiftDays($shiftdayarr);
                $this->syncShiftDayTimes($shiftdaytimearr);

                // Get all dates in range (optimized)
                $startDate = Carbon::parse($arraycontent[0]);
                $endDate = Carbon::parse($arraycontent[1]);
                $datesInRange = [];
                while ($startDate <= $endDate) {
                    $datesInRange[] = $startDate->format('Y-m-d');
                    $startDate->addDay();
                }

                // Preload shift data
                $shiftData = DB::table('shift_day_times')
                    ->join('shifts', 'shift_day_times.shifts_id', '=', 'shifts.id')
                    ->where('shift_day_times.shifts_id', $shift->id)
                    ->orderBy('shift_day_times.daynum')
                    ->get();

                // Group timetable data by daynum
                $timetableData = DB::table('shift_day_times')
                    ->where('shifts_id', $shift->id)
                    ->get()
                    ->groupBy('daynum');

                // Calculate cycle parameters once
                $cycleParams = $this->calculateCycleParameters($shiftData, $arraycontent[0], $arraycontent[1]);   

                // Check payroll statuses in bulk
                $payrollStatuses = DB::table('attendance_summaries')
                    ->whereIn('employees_id', $request->input('EmployeeName'))
                    ->whereIn('Date', $datesInRange)
                    ->where('IsPayrollMade', 1)
                    ->get()
                    ->groupBy(['employees_id', 'Date']);

                // Process each employee
                foreach ($request->input('EmployeeName') as $employeeid) {
                    $payrollDates = $payrollStatuses[$employeeid] ?? [];
                    $payrollmadeemp = [];
                    $payrollmadedates = [];
                    $alldates = [];
                    $payrollmadeattids = [];
                    $payrollclosedflag = 0;

                    foreach ($datesInRange as $datevalue) {
                        if (isset($payrollDates[$datevalue])) {
                            $payrollmadeemp[] = $employeeid;
                            $payrollmadedates[] = '"' . $datevalue . '"';
                            $alldates[] = $datevalue;
                            $payrollmadeattids[] = null;
                            $payrollclosedflag++;
                        }
                    }

                    $BasicValShc = [
                        'employees_id' => $employeeid,
                        'Date' => $daterangeval,
                        'CheckInNotReq' => $request->input('checkinnotreq',0),
                        'CheckOutNotReq' =>$request->input('checkoutnotreq',0),
                        'ScheduleOnHoliday' =>$request->input('scheduledholiday',0),
                        'EffectiveOt' =>$request->input('effectiveot',0),
                        'ShiftFlag' => $assignmentType,
                    ];

                    $DbDataShc = shiftschedule::where('employees_id', $employeeid)->first();
                    $CreatedBySch = ['CreatedBy' => $user];
                    $LastUpdatedBySch = ['LastEditedBy' => $user];

                    $shiftsch=shiftschedule::updateOrCreate(['employees_id'=>$employeeid],
                        array_merge($BasicValShc, $DbDataShc ? $LastUpdatedBySch : $CreatedBySch),
                    );

                    $BasicShcDet = [
                        'shiftschedules_id' => $shiftsch->id,
                        'shifts_id' => $shift->id,
                        'ValidDate' => $daterangeval,
                        'CheckInNotReq' => $request->input('indcheckinnotreq',0),
                        'CheckOutNotReq' =>$request->input('indcheckoutnotreq',0),
                        'ScheduleOnHoliday' =>$request->input('indscheduledholiday',0),
                        'EffectiveOt' =>$request->input('indeffectiveot',0),
                        'ShiftFlag' => $assignmentType,
                        'ScheduleType' => $scheduleType,
                        'Status' => ($curdate >= $arraycontent[0] && $curdate <= $arraycontent[1]) ? "Active" : (($curdate > $arraycontent[1]) ? "Expired" : "To-be-Active"),
                    ];

                    $DbDataShcDet = shiftscheduledetail::where('id', $shiftdetailId)->first();
                    $CreatedDateSchDet = ['created_at' => Carbon::now()];
                    $LastUpdatedDateSch = ['updated_at' => Carbon::now()];

                    $shiftschdet=shiftscheduledetail::updateOrCreate(['id'=>$shiftdetailId],
                        array_merge($BasicShcDet, $DbDataShcDet ? $LastUpdatedDateSch : $CreatedDateSchDet),
                    );

                    // Generate schedule data in bulk
                    $shschedule = $this->generateScheduleData(
                        $employeeid,
                        $datesInRange,
                        $shiftData,
                        $timetableData,
                        $holidaysdate,
                        $shiftsch->id,
                        $shiftschdet->id,
                        $assignmentType,
                        $arraycontent,
                        $cycleParams
                    );

                    // Bulk update priority
                    shiftschedule_timetable::join('shiftschedules', 'shiftschedule_timetables.shiftschedules_id', 'shiftschedules.id')
                        ->join('shiftscheduledetails', 'shiftschedule_timetables.shiftscheduledetails_id', 'shiftscheduledetails.id')
                        ->where('shiftschedules.employees_id', $shiftsch->employees_id)
                        ->whereBetween('shiftschedule_timetables.Date', [$arraycontent[0], $arraycontent[1]])
                        ->update(['shiftschedule_timetables.have_priority' => 0]);

                    $this->syncShiftSchedules($shschedule);

                    // Update shift schedule dates
                    $this->updateShiftScheduleDates($shiftsch->id);

                    // Update attendance records
                    $this->updateAttendanceRecords($employeeid, $shiftschdet->id);

                    // Log action
                    $actions = $shiftdetailId ? "Edited" : "Created";
                    actions::insert([
                        'user_id' => $userid,
                        'pageid' => $shiftschdet->id,
                        'pagename' => "shiftschdet",
                        'action' => $actions,
                        'status' => $actions,
                        'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                        'reason' => "",
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }

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
        if($checkerrorflag>0)
        {
            return Response::json(['checkerr'=> 462]);
        }
        if($selectedopt == 0){
            return Response::json(['blanktable'=> 462]);
        }
        if($existcount>0){
            return Response::json(['existanceerr'=>462,'existancename'=>$overlappeddata]);
        }
        if($checkMondayFlag==1){
            return Response::json(['mondayflagerr'=>462]);
        }
    }

    protected function calculateCycleParameters($shiftData, $startDate, $endDate)
    {
        $cycleamount = 1;
        $diff = Carbon::parse($endDate)->diffInDays(Carbon::parse($startDate)) + 1;

        foreach ($shiftData as $shiftdata) {
            if ($shiftdata->CycleUnit == 1) $cycleamount = 1;
            if ($shiftdata->CycleUnit == 2) $cycleamount = 31;
            if ($shiftdata->CycleUnit == 3) $cycleamount = 7;

            $totalcycle = $diff / ($cycleamount * $shiftdata->CycleNumber);
            $totalcy = $cycleamount * $shiftdata->CycleNumber;
            $totalcyclenum = $shiftdata->CycleNumber;
            $totalcycleunit = $shiftdata->CycleUnit;
        }

        return [
            'cycleamount' => $cycleamount,
            'diff' => $diff,
            'totalcycle' => $totalcycle,
            'totalcy' => $totalcy,
            'totalcyclenum' => $totalcyclenum,
            'totalcycleunit' => $totalcycleunit,
            'hloop' => $diff / $totalcyclenum,
            'maxloopval' => ($cycleamount < $diff) ? $diff / $totalcyclenum : $diff,
            'ival' => ($totalcycle < 1) ? 1 : 0
        ];
    }

    protected function generateScheduleData($employeeid, $datesInRange, $shiftData, $timetableData, $holidaysdate, $shiftscheduleId, $shiftscheduledetailId, $assignmentType, $dateRange, $cycleParams)
    {
        $shschedule = [];
        $valindx = 0;

        $shiftscheduledetail = shiftscheduledetail::where('id', $shiftscheduledetailId)->first();

        for ($i = $cycleParams['ival']; $i < round($cycleParams['totalcycle']) + 1; $i++) {
            $loopflg = 0;
            for ($j = 0; $j < round($cycleParams['totalcy']); $j++) {
                ++$loopflg;
                
                if (!isset($timetableData[$loopflg])) continue;

                foreach ($timetableData[$loopflg] as $timetbldata) {
                    $date = Carbon::parse($dateRange[0])->addDays($valindx);
                    $dateStr = $date->format('Y-m-d');

                    if ($dateStr >= $dateRange[0] && $dateStr <= $dateRange[1]) {
                        $isHoliday = in_array($dateStr, $holidaysdate);
                        $isworkday = ($isHoliday && (int)$shiftscheduledetail->ScheduleOnHoliday == 0 && $timetbldata->timetables_id != 1) 
                            ? 3 
                            : ($timetbldata->timetables_id != 1 ? 1 : 2);

                        $shschedule[] = [
                            'shiftschedules_id' => $shiftscheduleId,
                            'shiftscheduledetails_id' => $shiftscheduledetailId,
                            'shifts_id' => $timetbldata->shifts_id,
                            'timetables_id' => $timetbldata->timetables_id,
                            'isworkday' => $isworkday,
                            'have_priority' => 1,
                            'Date' => $dateStr,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
                $valindx++;
            }
        }

        return $shschedule;
    }

    protected function updateShiftScheduleDates($shiftscheduleId)
    {
        shiftschedule::where('id', $shiftscheduleId)
        ->update([
            'Date' => DB::raw("(SELECT CONCAT(MIN(Date), ' to ', MAX(Date)) FROM shiftschedule_timetables WHERE shiftschedules_id = $shiftscheduleId)"),
            'ShiftFlag' => DB::raw("COALESCE((SELECT ShiftFlag FROM shiftscheduledetails WHERE shiftschedules_id = $shiftscheduleId AND Status = 'Active' LIMIT 1), '')")
        ]);
    }

    protected function updateAttendanceRecords($employeeid, $shiftscheduledetailId)
    {
        // Get all dates for this schedule
        $allDates = DB::table('shiftschedule_timetables')
            ->where('shiftscheduledetails_id', $shiftscheduledetailId)
            ->orderBy('Date', 'ASC')
            ->pluck('Date')
            ->toArray();

        // Get attendance records that need updating
        $attendanceRecords = DB::table('attendance_summaries')
            ->where('employees_id', $employeeid)
            ->whereIn('Date', $allDates)
            ->where('IsPayrollMade', '!=', 1)
            ->get();

        // Process in batches
        foreach ($attendanceRecords as $record) {
            $timetableids = DB::table('shiftschedule_timetables')
                ->where('shiftschedules_id', function($query) use ($employeeid) {
                    $query->select('id')
                        ->from('shiftschedules')
                        ->where('employees_id', $employeeid);
                })
                ->where('have_priority', 1)
                ->where('Date', $record->Date)
                ->pluck('timetables_id')
                ->toArray();
            
            if (empty($timetableids)) {
                $timetableids = [0]; // Or [1], depending on what fallback you want
            }

            $attendancedata=DB::select('SELECT * FROM attendance_logs WHERE attendance_logs.employees_id='.$employeeid.' AND attendance_logs.Date="'.$record->Date.'"');
            foreach($attendancedata as $attdata){
                // Update attendance logs in bulk
                DB::table('attendance_logs')
                    ->where('employees_id', $employeeid)
                    ->where('Date', $record->Date)
                    ->update([
                        'timetables_id' => DB::raw("COALESCE(
                            (SELECT id FROM timetables 
                            WHERE id IN (".implode(',', $timetableids).") 
                            AND '$attdata->Time' BETWEEN BeginningIn AND EndingOut 
                            ORDER BY id DESC LIMIT 1), 1)")
                    ]);
            }

            $this->targetService->checkAttendanceStatus($employeeid, $record->Date);
        }
    }

    public function syncScheduleTimetable($shschedule,$employeeid)
    {
        if (empty($shschedule)) {
            return;
        }

        $holidaysdate=[];

        $holidays=holiday::get(['HolidayDate']);
        foreach ($holidays as $holidays) {
            $holidaysdate[] = $holidays->HolidayDate;
        }

        // Extract from the first record
        $shiftschedules_id = $shschedule[0]['shiftschedules_id'];
        $shiftscheduledetails_id = $shschedule[0]['shiftscheduledetails_id'];
        $shiftId = $shschedule[0]['shifts_id'];
        $timetableId = $shschedule[0]['timetables_id'];
        $date = $shschedule[0]['Date'];

        $shiftdetailprop = shiftscheduledetail::where('id', $shiftscheduledetails_id)->get(); 

        

        // Fetch existing records from the database for comparison
        $existingRecords = DB::table('shiftschedule_timetables')
            ->where('shiftschedules_id', $shiftschedules_id)
            ->where('shiftscheduledetails_id', $shiftscheduledetails_id)
            ->where('shifts_id', $shiftId)
            ->where('timetables_id', $timetableId)
            ->where('Date', $date)
            ->get(['shiftschedules_id','shiftscheduledetails_id','shifts_id','timetables_id','Date'])
            ->map(fn($item) => (array) $item);

        // Convert to collections for easy processing
        $newRecords = collect($shschedule);
        $existingRecords = collect($existingRecords);

        // Insert or Update Records
        foreach ($newRecords as $record) {
            DB::table('shiftschedule_timetables')->updateOrInsert(
                [
                    'shiftschedules_id' => $record['shiftschedules_id'],
                    'shiftscheduledetails_id' => $record['shiftscheduledetails_id'],
                    'shifts_id' => $record['shifts_id'],
                    'timetables_id' => $record['timetables_id'],
                    'isworkday' => ($record['timetables_id'] == 1) ? 2 : (in_array($record['Date'], $holidaysdate) && (int)$shiftdetailprop[0]->ScheduleOnHoliday == 0 ? 3 : 1),
                    'Date' => $record['Date'],
                ],
                $record // If exists, update it
            );
        }

        // Identify records to delete (Records in DB but not in $shschedule)
        $datesToKeep = $newRecords->pluck('Date');
        $recordsToDelete = $existingRecords->whereNotIn('Date', $datesToKeep)->pluck('Date');

        if ($recordsToDelete->isNotEmpty()) {
            DB::table('shiftschedule_timetables')
                ->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                ->where('shiftschedules_id', $shiftschedules_id)
                ->where('shiftscheduledetails_id', $shiftscheduledetails_id)
                ->where('shiftschedules.employees_id',$employeeid)
                ->whereIn('Date', $recordsToDelete)
                ->delete();
        }

        $getminmax=shiftschedule_timetable::join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')->where('shiftschedules.employees_id',$employeeid)->get([DB::raw('MIN(shiftschedule_timetables.Date) AS MinDate'),DB::raw('MAX(shiftschedule_timetables.Date) AS MaxDate')])->first();
        shiftschedule::where('shiftschedules.id',$shiftschedules_id)->update(['shiftschedules.Date'=>$getminmax->MinDate." to ".$getminmax->MaxDate]);
    }

    public function syncShiftSchedules($shiftsData)
    {
        if (empty($shiftsData)) {
            return;
        }

        // Start a transaction to ensure atomic operations
        //DB::beginTransaction();
        
        try {
            $firstItem = collect($shiftsData)->first();
            DB::table('shiftschedule_timetables')
                ->where('shiftschedule_timetables.shiftscheduledetails_id',$firstItem['shiftscheduledetails_id'])
                ->delete();

            collect($shiftsData)->chunk(500)->each(function ($chunk) {
                shiftschedule_timetable::insert($chunk->toArray());
            });
                
            // Process each item in the incoming data
            // foreach ($shiftsData as $shift) {
                
            //     // Check if this record already exists in the database
            //     $existingRecord = DB::table('shiftschedule_timetables')
            //         ->where('shiftschedules_id', $shift['shiftschedules_id'])
            //         ->where('shiftscheduledetails_id', $shift['shiftscheduledetails_id'])
            //         ->where('shifts_id', $shift['shifts_id'])
            //         ->where('timetables_id', $shift['timetables_id'])
            //         ->where('isworkday', $shift['isworkday'])
            //         ->where('Date', $shift['Date'])
            //         ->first();

            //     if ($existingRecord) {
            //         // If record exists and data has changed, update it
            //         if ($existingRecord != (object) $shift) {
            //             DB::table('shiftschedule_timetables')
            //                 ->where('shiftschedules_id', $shift['shiftschedules_id'])
            //                 ->where('shiftscheduledetails_id', $shift['shiftscheduledetails_id'])
            //                 ->where('shifts_id', $shift['shifts_id'])
            //                 ->where('Date', $shift['Date'])
            //                 ->update($shift);
            //         }
            //     } else {
            //         // If record doesn't exist, insert new
            //         DB::table('shiftschedule_timetables')->insert($shift);
            //     }
            // }

            // Commit transaction
            //DB::commit();
        } catch (\Exception $e) {
            // Rollback transaction on error
            //DB::rollBack();
            throw $e;
        }
    }

    public function syncShiftDays($shiftDays)
    {
        if (empty($shiftDays)) {
            return;
        }

        // Extract shifts_id from first record (Assuming all records have the same shifts_id)
        $shifts_id = $shiftDays[0]['shifts_id'];

        // Fetch existing records from the database for comparison
        $existingRecords = DB::table('shift_days')
            ->where('shifts_id', $shifts_id)
            ->get(['shifts_id', 'daynum'])
            ->map(fn($item) => (array) $item);

        // Convert to collections for easy processing
        $newRecords = collect($shiftDays);
        $existingRecords = collect($existingRecords);

        // Insert or Update Records
        foreach ($newRecords as $record) {
            DB::table('shift_days')->updateOrInsert(
                [
                    'shifts_id' => $record['shifts_id'],
                    'daynum' => $record['daynum'],
                ],
                $record // If exists, update it
            );
        }

        // Identify records to delete (Records in DB but not in $shiftDays)
        $daynumsToKeep = $newRecords->pluck('daynum');
        $recordsToDelete = $existingRecords->whereNotIn('daynum', $daynumsToKeep)->pluck('daynum');

        if ($recordsToDelete->isNotEmpty()) {
            DB::table('shift_days')
                ->where('shifts_id', $shifts_id)
                ->whereIn('daynum', $recordsToDelete)
                ->delete();
        }
    }

    public function syncShiftDayTimes($shiftDayTimes)
    {
        if (empty($shiftDayTimes)) {
            return;
        }

        $idNotDeleted=[];

        // Extract shifts_id from the first record (Assuming all records have the same shifts_id)
        $shifts_id = $shiftDayTimes[0]['shifts_id'];

        // Fetch existing records from the database for comparison
        $existingRecords = DB::table('shift_day_times')
            ->where('shifts_id', $shifts_id)
            ->get(['shifts_id', 'timetables_id', 'daynum'])
            ->map(fn($item) => (array) $item);

        // Convert to collections for easy processing
        $newRecords = collect($shiftDayTimes);
        $existingRecords = collect($existingRecords);

        // Insert or Update Records
        foreach ($newRecords as $record) {
            DB::table('shift_day_times')->updateOrInsert(
                [
                    'shifts_id' => $record['shifts_id'],
                    'timetables_id' => $record['timetables_id'],
                    'daynum' => $record['daynum'],
                ],
                $record // If exists, update it
            );

            $idsNotToDelete = DB::table('shift_day_times')
                ->where('shifts_id', $record['shifts_id'])
                ->where('timetables_id' , $record['timetables_id'])
                ->where('daynum' , $record['daynum'])
                ->first(); // Pluck the IDs (replace 'id' with the actual column name)

            $idNotDeleted[]=$idsNotToDelete->id;
        }

        if (!empty($idNotDeleted)) {
            DB::table('shift_day_times')
                ->where('shifts_id', $shifts_id)
                ->whereNotIn('id', $idNotDeleted)
                ->delete();
        }
    }

    public function showshiftschcon($id){
        $datefromval=0;
        $shiftids=[];
        
        $recdata=shiftschedule::findorFail($id);

        $createddate = Carbon::createFromFormat('Y-m-d H:i:s', $recdata->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $updateddate = Carbon::createFromFormat('Y-m-d H:i:s', $recdata->updated_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $data = shiftschedule::where('shiftschedules.id',$id)
        ->join('employees','shiftschedules.employees_id','employees.id')
        ->join('branches', 'employees.branches_id', '=', 'branches.id')
        ->join('departments', 'employees.departments_id', '=', 'departments.id')
        ->join('positions', 'employees.positions_id', '=', 'positions.id')
        ->join('salaries', 'employees.salaries_id', '=', 'salaries.id')
        ->join('employees as emp', 'employees.employees_id', '=', 'emp.id')
        ->join('employementtypes', 'employees.employementtypes_id', '=', 'employementtypes.id')
        ->get(['employees.*','shiftschedules.*','branches.BranchName','departments.DepartmentName','positions.PositionName','employementtypes.EmploymentTypeName',
            DB::raw("'$createddate' AS CreatedDateTime"),
            DB::raw("'$updateddate' AS UpdatedDateTime"),
            DB::raw("CASE WHEN shiftschedules.ShiftFlag=1 THEN 'Group' WHEN shiftschedules.ShiftFlag=2 THEN 'Individual' END AS AssignmentType"),
            DB::raw("CASE WHEN shiftschedules.CheckInNotReq=0 THEN 'No' WHEN shiftschedules.CheckInNotReq=1 THEN 'Yes' END AS CheckInReq"),
            DB::raw("CASE WHEN shiftschedules.CheckOutNotReq=0 THEN 'No' WHEN shiftschedules.CheckOutNotReq=1 THEN 'Yes' END AS CheckOutReq"),
            DB::raw("CASE WHEN shiftschedules.ScheduleOnHoliday=0 THEN 'No' WHEN shiftschedules.ScheduleOnHoliday=1 THEN 'Yes' END AS SchOnHoliday"),
            DB::raw("CASE WHEN shiftschedules.EffectiveOt=0 THEN 'No' WHEN shiftschedules.EffectiveOt=1 THEN 'Yes' END AS EffOt")
        ]);

        $shiftdata = shiftschedule_timetable::where('shiftschedule_timetables.shiftschedules_id',$id)
        ->join('shifts','shiftschedule_timetables.shifts_id','shifts.id')
        ->distinct()
        ->get(['shifts.*']);
        foreach($shiftdata as $row){
            $shiftids[]=$row->id;
        }
        
        $shiftcount = DB::table('shiftschedule_timetables')->whereIn('shifts_id',$shiftids)->get();
        $cnt = $shiftcount->count();

        $shiftdaytime=shift_day_time::join('timetables','shift_day_times.timetables_id','timetables.id')->whereIn('shift_day_times.shifts_id',$shiftids)
        ->orderBy('shift_day_times.id','ASC')
        ->get(['timetables.*','shift_day_times.shifts_id','shift_day_times.timetables_id','shift_day_times.daynum',DB::raw('IFNULL(timetables.BreakStartTime,"") AS BreakStartTime'),DB::raw('IFNULL(timetables.BreakEndTime,"") AS BreakEndTime'),DB::raw('IFNULL(timetables.BreakHour,"0") AS BreakHour')]);

        $timetabledatedata = shiftschedule_timetable::where('shiftschedule_timetables.shiftschedules_id',$id)
        ->distinct()
        ->orderBy('shiftschedule_timetables.Date','ASC')
        ->get(['shiftschedule_timetables.Date',DB::raw('DAYNAME(shiftschedule_timetables.Date) AS DayName')]);

        $timetabledata = shiftschedule_timetable::where('shiftschedule_timetables.shiftschedules_id',$id)
        ->join('shifts','shiftschedule_timetables.shifts_id','shifts.id')
        ->join('timetables','shiftschedule_timetables.timetables_id','timetables.id')
        ->get(['shifts.ShiftName','timetables.*','shiftschedule_timetables.Date','shiftschedule_timetables.isworkday',DB::raw('IFNULL(timetables.BreakStartTime,"") AS BreakStartTime'),DB::raw('IFNULL(timetables.BreakEndTime,"") AS BreakEndTime'),DB::raw('IFNULL(timetables.BreakHour,"0") AS BreakHour')]);

        return response()->json(['shiftschdata'=>$data,'shiftcnt'=>$cnt,'shiftdata'=>$shiftdata,'shiftdaytime'=>$shiftdaytime,'timetabledatedata'=>$timetabledatedata,'timetabledata'=>$timetabledata]);       
    }

    public function showShiftScheduleDetail(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        $shiftDetId=$_POST['shiftDetId']; 

        $query = DB::select("SELECT shiftscheduledetails.id,IFNULL((SELECT GROUP_CONCAT(DISTINCT shifts.ShiftName) FROM shiftschedule_timetables LEFT JOIN shifts ON shiftschedule_timetables.shifts_id=shifts.id WHERE shiftschedule_timetables.shiftscheduledetails_id = shiftscheduledetails.id),'-') AS ShiftName,CASE WHEN shiftscheduledetails.ShiftFlag=1 THEN 'Group Assignment' WHEN shiftscheduledetails.ShiftFlag=2 THEN 'Individual Assignment' END AS AssignmentType,shiftscheduledetails.ValidDate,CASE WHEN shiftscheduledetails.CheckInNotReq=1 THEN 'Yes' ELSE 'No' END AS CheckInRequire,CASE WHEN shiftscheduledetails.CheckOutNotReq=1 THEN 'Yes' ELSE 'No' END AS CheckOutRequire,CASE WHEN shiftscheduledetails.ScheduleOnHoliday=1 THEN 'Yes' ELSE 'No' END AS ScheduleOnHoliday,CASE WHEN shiftscheduledetails.EffectiveOt=1 THEN 'Yes' ELSE 'No' END AS AllowOt,CASE WHEN shiftscheduledetails.ScheduleType = 1 THEN 'Permanent' ELSE 'Temporary' END AS ScheduleTypeLabel,shiftscheduledetails.ScheduleType,shiftscheduledetails.Status,shiftscheduledetails.OldStatus,(SELECT COUNT(*) FROM attendance_summaries WHERE attendance_summaries.IsPayrollMade=1 AND attendance_summaries.Date>=SUBSTRING_INDEX(shiftscheduledetails.ValidDate, ' to ', 1) AND attendance_summaries.Date<=SUBSTRING_INDEX(shiftscheduledetails.ValidDate, ' to ', -1)) AS PayrollFlag FROM shiftscheduledetails LEFT JOIN shiftschedules ON shiftscheduledetails.shiftschedules_id=shiftschedules.id WHERE shiftscheduledetails.shiftschedules_id=".$shiftDetId." ORDER BY shiftscheduledetails.id DESC");
        if(request()->ajax()) {
            return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $shiftschedit='';
                $shiftschvoid='';
                $shiftschundovoid='';
                if($user->can('Shift-Schedule-Edit') && $data->PayrollFlag == 0){
                    $shiftschedit='<a class="dropdown-item editshiftsch" href="javascript:void(0)" onclick="editShiftSchFn('.$data->id.')" data-id="editShiftSch'.$data->id.'" id="editShiftSch'.$data->id.'" title="Edit Record"><i class="fa fa-edit"></i><span> Edit</span></a>';
                }
                if($user->can('Shift-Schedule-Void') && $data->PayrollFlag == 0 && $data->ScheduleType == 2 && $data->Status != "Void"){
                    $shiftschvoid='<a class="dropdown-item voidshiftsch" href="javascript:void(0)" onclick="voidShiftSchFn('.$data->id.')" data-id="voidShiftSch'.$data->id.'" id="voidShiftSch'.$data->id.'" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                }
                if($user->can('Shift-Schedule-Void') && $data->PayrollFlag == 0 && $data->ScheduleType == 2 && $data->Status == "Void"){
                    $shiftschundovoid='<a class="dropdown-item undovoidshiftsch" href="javascript:void(0)" onclick="undovoidShiftSchFn('.$data->id.')" data-id="undovoidShiftSch'.$data->id.'" id="undovoidShiftSch'.$data->id.'" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item shiftInfo" onclick="scheduleDetInfoFn('.$data->id.')" data-id="'.$data->id.'" id="shiftscheduledetail'.$data->id.'" title="Open information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$shiftschedit.'
                        '.$shiftschvoid.'
                        '.$shiftschundovoid.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function voidSchedule(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->voidschid;
        $schprop=shiftscheduledetail::find($findid);
        $validator = Validator::make($request->all(), [
            'Reason'=>"required",
        ]);
        if ($validator->passes()) 
        {
            try{
                $shiftschdata=shiftschedule::find($schprop->shiftschedules_id);
                $arraycontentdate = explode(" to ",$schprop->ValidDate);

                shiftschedule_timetable::join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                        ->join('shiftscheduledetails','shiftschedule_timetables.shiftscheduledetails_id','shiftscheduledetails.id')
                        ->where('shiftschedule_timetables.shiftscheduledetails_id',$findid)
                        ->where('shiftschedules.employees_id',$shiftschdata->employees_id)
                        ->whereBetween('shiftschedule_timetables.Date', [$arraycontentdate[0],$arraycontentdate[1]])
                        ->update(['shiftschedule_timetables.have_priority' => 0]);
                    
                shiftschedule_timetable::join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                        ->join('shiftscheduledetails','shiftschedule_timetables.shiftscheduledetails_id','shiftscheduledetails.id')
                        ->where('shiftscheduledetails.ScheduleType',1)
                        ->where('shiftschedules.employees_id',$shiftschdata->employees_id)
                        ->whereBetween('shiftschedule_timetables.Date', [$arraycontentdate[0],$arraycontentdate[1]])
                        ->update(['shiftschedule_timetables.have_priority' => 1]);

                $period = CarbonPeriod::create($arraycontentdate[0],$arraycontentdate[1]);
                foreach($period as $date){
                    $this->targetService->checkAttendanceStatus($shiftschdata->employees_id,$date->toDateString());
                }

                $updateStatus=DB::select('UPDATE shiftscheduledetails SET OldStatus=Status WHERE id='.$findid);
                $schprop->Status="Void";
                $schprop->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"shiftschdet",'action'=>"Void",'status'=>"Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Reason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }   
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function undoVoidSchedule(Request $request)
    {
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;
            $findid=$request->undovoidid;
            
            $schprop=shiftscheduledetail::find($findid);
            $shiftschdata=shiftschedule::find($schprop->shiftschedules_id);
            $arraycontentdate = explode(" to ",$schprop->ValidDate);

            shiftschedule_timetable::join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                    ->join('shiftscheduledetails','shiftschedule_timetables.shiftscheduledetails_id','shiftscheduledetails.id')
                    ->where('shiftschedules.employees_id',$shiftschdata->employees_id)
                    ->whereBetween('shiftschedule_timetables.Date', [$arraycontentdate[0],$arraycontentdate[1]])
                    ->update(['shiftschedule_timetables.have_priority' => 0]);

            shiftschedule_timetable::join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                    ->join('shiftscheduledetails','shiftschedule_timetables.shiftscheduledetails_id','shiftscheduledetails.id')
                    ->where('shiftschedule_timetables.shiftscheduledetails_id',$findid)
                    ->where('shiftschedules.employees_id',$shiftschdata->employees_id)
                    ->whereBetween('shiftschedule_timetables.Date', [$arraycontentdate[0],$arraycontentdate[1]])
                    ->update(['shiftschedule_timetables.have_priority' => 1]);
                    
            $period = CarbonPeriod::create($arraycontentdate[0],$arraycontentdate[1]);
            foreach($period as $date){
                $this->targetService->checkAttendanceStatus($shiftschdata->employees_id,$date->toDateString());
            }

            $oldstatus=$schprop->OldStatus;
            $schprop->Status=$schprop->OldStatus;
            $schprop->save();
            actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"shiftschdet",'action'=>"Undo-Void",'status'=>"Undo-Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function getScheduleDetail(Request $request){
        $schdetailid=$_POST['schdetailid']; 
        $currentdate=Carbon::today()->toDateString();
        $shiftids=[];
        $shiftDetails = shiftscheduledetail::select([
            'shifts.CycleNumber','shifts.CycleUnit','shifts.Description AS ShiftDescription',
            'shiftscheduledetails.*','shiftschedules.employees_id','employees.departments_id','employees.name',
            DB::raw("IFNULL((SELECT GROUP_CONCAT(DISTINCT shifts.ShiftName) 
                    FROM shiftschedule_timetables 
                    LEFT JOIN shifts ON shiftschedule_timetables.shifts_id = shifts.id 
                    WHERE shiftschedule_timetables.shiftscheduledetails_id = shiftscheduledetails.id),'-') AS ShiftName"),
            DB::raw("CASE 
                        WHEN shiftscheduledetails.ShiftFlag = 1 THEN 'Group Assignment' 
                        WHEN shiftscheduledetails.ShiftFlag = 2 THEN 'Individual Assignment' 
                    END AS AssignmentType"),
            'shiftscheduledetails.ValidDate',
            DB::raw("CASE WHEN shiftscheduledetails.ScheduleType = 1 THEN 'Permanent' ELSE 'Temporary' END AS ScheduleTypeLabel"),
            DB::raw("CASE WHEN shiftscheduledetails.CheckInNotReq = 1 THEN 'Yes' ELSE 'No' END AS CheckInRequire"),
            DB::raw("CASE WHEN shiftscheduledetails.CheckOutNotReq = 1 THEN 'Yes' ELSE 'No' END AS CheckOutRequire"),
            DB::raw("CASE WHEN shiftscheduledetails.ScheduleOnHoliday = 1 THEN 'Yes' ELSE 'No' END AS ScheduleOnHolidayText"),
            DB::raw("CASE WHEN shiftscheduledetails.EffectiveOt = 1 THEN 'Yes' ELSE 'No' END AS AllowOt"),
        ])
        ->leftJoin('shiftschedules', 'shiftscheduledetails.shiftschedules_id', '=', 'shiftschedules.id')
        ->leftJoin('employees', 'shiftschedules.employees_id', '=', 'employees.id')
        ->leftJoin('shifts', 'shiftscheduledetails.shifts_id', '=', 'shifts.id')
        ->where('shiftscheduledetails.id', $schdetailid)
        ->orderByDesc('shiftscheduledetails.id')
        ->get();

        $timetabledata=timetable::get([DB::raw("CONCAT(timetables.TimetableName,' (',timetables.OnDutyTime,'-',timetables.OffDutyTime,')') AS TimetableName"),"timetables.TimetableColor"]);

        $shiftdata = shiftschedule_timetable::where('shiftschedule_timetables.shiftscheduledetails_id',$schdetailid)
        ->join('shifts','shiftschedule_timetables.shifts_id','shifts.id')
        ->distinct()
        ->get(['shifts.*']);
        foreach($shiftdata as $row){
            $shiftids[]=$row->id;
        }

        $shiftdaytime=shift_day_time::join('timetables','shift_day_times.timetables_id','timetables.id')->whereIn('shift_day_times.shifts_id',$shiftids)
        ->orderBy('shift_day_times.id','ASC')
        ->get(['timetables.*','shift_day_times.shifts_id','shift_day_times.timetables_id','shift_day_times.daynum',DB::raw('IFNULL(timetables.BreakStartTime,"") AS BreakStartTime'),DB::raw('IFNULL(timetables.BreakEndTime,"") AS BreakEndTime'),DB::raw('IFNULL(timetables.BreakHour,"0") AS BreakHour')]);

        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"shiftschdet")
        ->where('pageid',$schdetailid)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        $daterange = explode(" to ",$shiftDetails[0]->ValidDate);

        $monthsList = $this->getMonthsBetweenDates($daterange[0], $daterange[1]);

        return response()->json(['shiftDetails'=>$shiftDetails,'activitydata'=>$activitydata,'timetabledata'=>$timetabledata,'shiftdata'=>$shiftdata,'shiftdaytime'=>$shiftdaytime,'currentdate'=>$currentdate,'monthlist'=>$monthsList->toArray()]);       
    }

    public function getMonthsBetweenDates($startDate, $endDate)
    {
        $months = collect();
        $current = Carbon::parse($startDate)->startOfMonth();
        $end = Carbon::parse($endDate)->startOfMonth();

        while ($current <= $end) {
            $months->push([
                'full' => $current->format('F-Y'),   
                'numeric' => $current->format('Y-m') 
            ]);
            $current->addMonth();
        }
        return $months;
    }

    public function showTimetableData(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        $selectedmonth = isset($_POST['selectedmonth']) ? $_POST['selectedmonth'] : [0];
        
        $employeeid=$_POST['employeeid']; 
        $startdate=$_POST['startdate']; 
        $enddate=$_POST['enddate']; 
        $shiftdetailid=$_POST['shiftdetailid']; 

        $query = DB::table('shiftschedule_timetables')
        ->select(
            DB::raw("CONCAT(shiftschedule_timetables.Date,' (',DAYNAME(shiftschedule_timetables.Date),')') AS Date"),
            DB::raw("
                CASE 
                    WHEN shiftschedule_timetables.timetables_id > 1 THEN
                        (SELECT REPLACE(GROUP_CONCAT(CONCAT(timetables.TimetableName, ' (', timetables.OnDutyTime, '-', timetables.OffDutyTime, ')') ORDER BY timetables.OnDutyTime ASC), ',', ' ') 
                        FROM shiftschedule_timetables AS shifttimetbl 
                        LEFT JOIN timetables ON shifttimetbl.timetables_id = timetables.id 
                        WHERE shifttimetbl.Date = shiftschedule_timetables.Date 
                        AND shifttimetbl.shiftscheduledetails_id = shiftschedule_timetables.shiftscheduledetails_id 
                        AND timetables.id > 1
                        ) 
                    ELSE '' 
                END AS SelectedTimetable")
        )
        ->leftJoin('shiftschedules', 'shiftschedule_timetables.shiftschedules_id', '=', 'shiftschedules.id')
        ->where('shiftschedules.employees_id', '=', $employeeid)
        ->where('shiftschedule_timetables.Date', '>=', $startdate)
        ->where('shiftschedule_timetables.Date', '<=', $enddate)
        ->where('shiftschedule_timetables.shiftscheduledetails_id', '=', $shiftdetailid)
        ->whereIn(DB::raw("DATE_FORMAT(shiftschedule_timetables.Date, '%Y-%m')"), $selectedmonth)
        // ->whereNotExists(function ($subquery) {
        //     $subquery->select(DB::raw(1))
        //         ->from('shiftschedule_timetables as t2')
        //         ->whereRaw('t2.Date = shiftschedule_timetables.Date')
        //         ->whereRaw('t2.timetables_id > 1')
        //         ->whereRaw('shiftschedule_timetables.timetables_id = 1');
        // })
        ->distinct()
        ->orderBy('shiftschedule_timetables.Date', 'asc')
        ->get();

        return datatables()->of($query)->addIndexColumn()->toJson();
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
