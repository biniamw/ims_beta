<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\Models\actions;
use App\Models\holiday;
use App\Models\shift;
use App\Models\shiftdetail;
use App\Models\timetable;
use App\Models\shift_day_time;
use App\Models\shift_day;
use App\Models\shiftschedule_timetable;
use App\Models\shiftscheduledetail;
use App\Models\shiftschedule;
use App\Models\employee;
use App\Models\attendance_log;
use App\Models\attendance;
use App\Models\attendance_summary;
use App\Models\hr_leave;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ShiftScheduleController;
use Response;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Exception;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $targetService;
    protected $shiftSchedule;

    public function __construct(AttendanceController $targetService,ShiftScheduleController $shiftSchedule)
    {
        $this->targetService = $targetService;
        $this->shiftSchedule = $shiftSchedule;
    }

    public function index(Request $request)
    {
        $currentdate = Carbon::today()->toDateString();
        //$timetblist = timetable::where('timetables.Status',"Active")->where('timetables.id','>',1)->orderBy('timetables.TimetableName','ASC')->get();
        $timetblist = timetable::where('timetables.Status',"Active")->where('timetables.id','>',1)->orderBy('timetables.OnDutyTime','ASC')->get(['timetables.*',DB::raw('CONCAT(TimetableName," (", OnDutyTime,"-",OffDutyTime,")") AS NameWithTime')]);
        if($request->ajax()) {
            return view('hr.setup.shift',['timetblist'=>$timetblist])->renderSections()['content'];
        }
        else{
            return view('hr.setup.shift',['timetblist'=>$timetblist]);
        }
    }

    public function shiftlistcon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $shiftlist=DB::select('SELECT shifts.*,CASE WHEN shifts.CycleUnit=1 THEN "Day" WHEN shifts.CycleUnit=2 THEN "Month" WHEN shifts.CycleUnit=3 THEN "Week" END AS CycleUnitName FROM shifts WHERE shifts.ShiftFlag=1 ORDER BY shifts.id DESC');
        if(request()->ajax()) {
            return datatables()->of($shiftlist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $shiftedit='';
                $shiftdelete='';
                if($user->can('Shift-Edit')){
                    $shiftedit=' <a class="dropdown-item shiftEdit" onclick="shiftEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open shift edit page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                }
                if($user->can('Shift-Delete')){
                    $shiftdelete='<a class="dropdown-item shiftDelete" onclick="shiftDeleteFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open shift delete confirmation">
                            <i class="fa fa-trash"></i><span> Delete</span>  
                        </a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item shiftInfo" onclick="shiftInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open shift information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$shiftedit.'
                        '.$shiftdelete.'
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
        $shiftdayarr = [];
        $shiftdaytimearr = [];
        $actions=null;

        $numofvals=(int)$request->selectedLength;

        $validator = Validator::make($data, [
            'ShiftName' => ['required', 'string', 'max:255',Rule::unique('shifts')->ignore($findid)],
            //'BegininngDate' => 'required',
            'CycleNumber' => 'required',
            'CycleUnit' => 'required',
            'status' => 'required|string',
        ]);

        if($checkflag!=1){
            $checkerrorflag=1;
        }
      
        if ($validator->passes() && $checkerrorflag==0 && $numofvals>0){
            DB::beginTransaction();
            try
            {
                $BasicVal = [
                    'ShiftName' => $request->ShiftName,
                    'BegininngDate' => $request->BegininngDate,
                    'CycleNumber' => $request->CycleNumber,
                    'CycleUnit' => $request->CycleUnit,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = shift::where('id', $findid)->first();
                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $shift = shift::updateOrCreate(['id' => $findid],
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

                if($findid==null){
                    $actions="Created";
                }
                else if($findid!=null){
                    $holidaysdate = [];
                    $shschedule=[];
                    $holidays=holiday::where('Status',"Active")->get(['HolidayDate']);
                    foreach ($holidays as $holidays) {
                        $holidaysdate[] = $holidays->HolidayDate;
                    }

                    $allDates = [];
                    $getDates=DB::select('SELECT shiftschedules.employees_id,shiftschedule_timetables.Date FROM shiftschedule_timetables LEFT JOIN shiftscheduledetails ON shiftschedule_timetables.shiftscheduledetails_id=shiftscheduledetails.id LEFT JOIN shiftschedules ON shiftscheduledetails.shiftschedules_id=shiftschedules.id WHERE shiftschedule_timetables.shifts_id='.$findid.' ORDER BY shiftschedule_timetables.Date ASC');
                    foreach($getDates as $datesrow){
                        $allDates[] = $datesrow->Date;
                    }
                    

                    $getEmployeeAndDate=DB::select('SELECT shiftschedule_timetables.Date,shiftschedules.employees_id FROM shiftschedule_timetables LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id=shiftschedules.id WHERE shiftschedule_timetables.shifts_id='.$findid);
                    foreach($getEmployeeAndDate as $row){
                        $PayrollDate = [];
                        $getPayrollDate=DB::select('SELECT attendance_summaries.employees_id,attendance_summaries.Date FROM attendance_summaries WHERE attendance_summaries.employees_id='.$row->employees_id.' AND attendance_summaries.IsPayrollMade=1 ORDER BY id ASC');
                        foreach ($getPayrollDate as $nopayrollrow) {
                            $PayrollDate[] = $nopayrollrow->Date;
                        }
                        
                        $shiftscheduleDateData = shiftscheduledetail::join('shiftschedules','shiftscheduledetails.shiftschedules_id','shiftschedules.id')
                                            ->where('shiftschedules.employees_id',$row->employees_id)
                                            ->whereBetween(DB::raw("'$row->Date'"),[DB::raw('SUBSTRING_INDEX(shiftscheduledetails.ValidDate, " to ", 1)'),DB::raw('SUBSTRING_INDEX(shiftscheduledetails.ValidDate, " to ", -1)')])
                                            ->select(DB::raw('SUBSTRING_INDEX(shiftscheduledetails.ValidDate, " to ", 1) AS FirstDate'),DB::raw('SUBSTRING_INDEX(shiftscheduledetails.ValidDate, " to ", -1) AS SecondDate'))
                                            ->orderBy('shiftscheduledetails.id','desc')
                                            ->first();

                        $diff = Carbon::parse($shiftscheduleDateData->SecondDate)->diffInDays($shiftscheduleDateData->FirstDate)+1;
                        $countCycle = DB::table('shift_day_times')
                            ->where('shifts_id', $findid)
                            ->count();

                        $getshiftnumber=DB::select("SELECT ((DATEDIFF(DATE('".$row->Date."'), '".$shiftscheduleDateData->FirstDate."') % ".$countCycle.") + 1) AS daynum");

                        $getTimetabledata=DB::select('SELECT DISTINCT shifts.CycleNumber,shifts.CycleUnit,shift_day_times.shifts_id,shift_day_times.timetables_id,shift_day_times.daynum FROM shift_day_times INNER JOIN shifts ON shift_day_times.shifts_id=shifts.id WHERE shift_day_times.shifts_id='.$findid.' AND shift_day_times.daynum='.$getshiftnumber[0]->daynum.'');
                        foreach($getTimetabledata as $timetbldata){
                            $shiftsceduledetail = shiftscheduledetail::join('shiftschedules','shiftscheduledetails.shiftschedules_id','shiftschedules.id')
                                ->where('shiftschedules.employees_id',$row->employees_id)
                                ->whereBetween(DB::raw("'$row->Date'"),[DB::raw('SUBSTRING_INDEX(shiftscheduledetails.ValidDate, " to ", 1)'),DB::raw('SUBSTRING_INDEX(shiftscheduledetails.ValidDate, " to ", -1)')])
                                ->select('shiftscheduledetails.shiftschedules_id','shiftscheduledetails.id AS ShiftScheduleDetailId','shiftscheduledetails.ScheduleOnHoliday')
                                ->orderBy('shiftscheduledetails.id','desc')
                                ->first();
                            
                            $existingShiftTimetbl = shiftschedule_timetable::join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                                ->where('shiftschedules_id',$shiftsceduledetail->shiftschedules_id)
                                ->where('shiftscheduledetails_id',$shiftsceduledetail->ShiftScheduleDetailId)
                                ->where('shiftschedule_timetables.shifts_id',$timetbldata->shifts_id)
                                ->where('shiftschedule_timetables.Date',$row->Date)
                                ->where('employees_id',$row->employees_id)
                                ->orderBy('shiftschedule_timetables.id','desc')
                                ->first();

                            $shschedule[] = 
                            [ 
                                'shiftschedules_id'=>$shiftsceduledetail->shiftschedules_id,
                                'shiftscheduledetails_id'=>$shiftsceduledetail->ShiftScheduleDetailId,
                                'shifts_id'=>$timetbldata->shifts_id,
                                'timetables_id'=> in_array($row->Date, $PayrollDate) ? $existingShiftTimetbl->timetables_id : $timetbldata->timetables_id ?? 1,
                                'isworkday' => in_array($row->Date, $PayrollDate) ? $existingShiftTimetbl->isworkday : ($timetbldata->timetables_id == 1 ? 2 : 1),
                                'Date'=>$row->Date,
                                'created_at'=>Carbon::now(),
                                'updated_at'=>Carbon::now(),
                            ];                               
                        }
                    }

                    DB::table('shiftschedule_timetables')
                    ->where('shiftschedule_timetables.shifts_id',$findid)
                    ->delete();

                    $this->shiftSchedule->syncShiftSchedules($shschedule);

                    $getEmployeeAndDateAtt=DB::select('SELECT attendance_summaries.employees_id,attendance_summaries.Date FROM attendance_summaries WHERE attendance_summaries.IsPayrollMade!=1 ORDER BY id ASC');
                    foreach($getEmployeeAndDateAtt as $row){
                        if (in_array($row->Date,$allDates)) {
                            $timetableids = [];
                            $timetabledata=DB::select('SELECT DISTINCT timetables_id FROM shiftschedule_timetables WHERE shiftschedule_timetables.shifts_id='.$findid.' AND shiftschedule_timetables.shiftschedules_id=(SELECT shiftschedules.id FROM shiftschedules WHERE shiftschedules.employees_id='.$row->employees_id.') AND shiftschedule_timetables.Date="'.$row->Date.'"');
                            foreach($timetabledata as $tblrow){
                                $timetableids[]=$tblrow->timetables_id;
                            }
                            $attendancedata=DB::select('SELECT * FROM attendance_logs WHERE attendance_logs.employees_id='.$row->employees_id.' AND attendance_logs.Date="'.$row->Date.'"');
                            foreach($attendancedata as $attdata){
                                $timetableid=1;
                                $gettimetableid = timetable::whereIn('id',$timetableids)->whereBetween(DB::raw("'$attdata->Time'"),[DB::raw('timetables.BeginningIn'),DB::raw('timetables.EndingOut')])->latest()->first();
                                if(empty($gettimetableid)){
                                    $timetableid=1;
                                }
                                else if(!empty($gettimetableid)){
                                    $timetableid=$gettimetableid->id;
                                }

                                attendance_log::where('attendance_logs.employees_id',$row->employees_id)
                                                    ->where('attendance_logs.Date',$row->Date)
                                                    ->where('attendance_logs.Time',$attdata->Time)
                                                    ->update(['attendance_logs.timetables_id' => $timetableid]);                                
                            }
                            $this->targetService->checkAttendanceStatus($row->employees_id,$row->Date);
                        }
                    }
                    $actions="Edited";
                }

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $shift->id,
                    'pagename' => "shifts",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                DB::commit();
                return Response::json(['success' => 1,'rec_id' => $shift->id]);
            }
            catch(Exception $e){
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
        if($numofvals==0)
        {
            return Response::json(['blanktable'=> 462]);
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

    public function timetablelistscon(){
        $timetbl = timetable::where('timetables.Status',"Active")->get(['timetables.*',DB::raw('IFNULL(timetables.BreakStartTime,"") AS BreakStartTimes'),DB::raw('IFNULL(timetables.BreakEndTime,"") AS BreakEndTimes'),DB::raw('IFNULL(timetables.BreakHour,"0") AS BreakHours')]);
        return response()->json(['timetbl'=>$timetbl]);
    }

    public function timetablealllistscon(){
        $timetbl = timetable::get();
        return response()->json(['timetbl'=>$timetbl]);
    }

    public function showshift($id){
        $periodcnt = 0;
        $cnt = 0;
        $sldata = shift::findorFail($id);

        $data = shift::where('shifts.id',$id)->get(['shifts.*',DB::raw('CASE WHEN CycleUnit=1 THEN "Day" WHEN CycleUnit=2 THEN "Month" WHEN CycleUnit=3 THEN "Week" END AS CycleUnits')]);

        $shiftdays = shift_day::where('shift_days.shifts_id',$id)->orderBy('shift_days.id','ASC')->get();
        
        $shiftdaytime = shift_day_time::join('timetables','shift_day_times.timetables_id','timetables.id')->where('shift_day_times.shifts_id',$id)
        ->orderBy('shift_day_times.id','ASC')
        ->get(['timetables.*','shift_day_times.shifts_id','shift_day_times.timetables_id','shift_day_times.daynum',DB::raw('IFNULL(timetables.BreakStartTime,"") AS BreakStartTime'),DB::raw('IFNULL(timetables.BreakEndTime,"") AS BreakEndTime'),DB::raw('IFNULL(timetables.BreakHour,"0") AS BreakHour')]);

        $shiftcount = DB::table('shiftschedule_timetables')->where('shifts_id',$id)->get();
        $cnt = $shiftcount->count();

        $timetabledata = timetable::get([DB::raw("CONCAT(timetables.TimetableName,' (',timetables.OnDutyTime,'-',timetables.OffDutyTime,')') AS TimetableName"),"timetables.TimetableColor"]);

        $activitydata = actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"shifts")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['shiftdata'=>$data,'shiftcnt'=>$cnt,'shiftdays'=>$shiftdays,'activitydata'=>$activitydata,'timetabledata'=>$timetabledata,'shiftdaytime'=>$shiftdaytime]); 
    }

    public function shiftdetlist($id)
    {
        $detailTable=DB::select('SELECT * FROM shiftdetails WHERE shiftdetails.shifts_id='.$id.' ORDER BY id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->make(true);
    }

    public function showShiftData(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        $shiftId = isset($_POST['recid']) ? $_POST['recid'] : [0];

        $query = DB::table('shift_day_times as sdt')
            ->selectRaw("
                sdt.daynum,
                CASE 
                    WHEN s.CycleUnit IN (1, 2) THEN CONCAT('Day-', sdt.daynum)
                    WHEN s.CycleUnit = 3 THEN 
                        CASE ((sdt.daynum - 1) % 7) + 1
                            WHEN 1 THEN 'Monday'
                            WHEN 2 THEN 'Tuesday'
                            WHEN 3 THEN 'Wednesday'
                            WHEN 4 THEN 'Thursday'
                            WHEN 5 THEN 'Friday'
                            WHEN 6 THEN 'Saturday'
                            WHEN 7 THEN 'Sunday'
                            ELSE 'Unknown'
                        END
                    ELSE 'Invalid CycleUnit'
                END AS Dates,
                CASE 
                    WHEN sdt.timetables_id > 1 THEN (
                        SELECT REPLACE(
                            GROUP_CONCAT(
                                CONCAT(timetables.TimetableName, ' (', timetables.OnDutyTime, '-', timetables.OffDutyTime, ')') 
                                ORDER BY timetables.OnDutyTime ASC
                            ), ',', ' '
                        )
                        FROM shift_day_times AS shifttimetbl
                        LEFT JOIN timetables ON shifttimetbl.timetables_id = timetables.id 
                        WHERE shifttimetbl.daynum = sdt.daynum 
                        AND shifttimetbl.shifts_id = sdt.shifts_id 
                        AND timetables.id > 1
                    )
                    ELSE '' 
                END AS SelectedTimetable")
            ->leftJoin('shifts as s', 'sdt.shifts_id', '=', 's.id')
            ->where('sdt.shifts_id', $shiftId)
            ->distinct()
            ->orderBy('s.id')
            ->orderByRaw('(sdt.daynum % 1), sdt.daynum')
            ->get();


        return datatables()->of($query)->addIndexColumn()->toJson();
    }

    public function deleteshift(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        DB::beginTransaction();
        try{
            $findid = $request->delId;
            DB::table('shift_day_times')->where('shifts_id',$findid)->delete();
            DB::table('shift_days')->where('shifts_id',$findid)->delete();
            DB::table('shifts')->where('id',$findid)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "shifts",
                'action' => "delete",
                'status' => "delete",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'reason' => "",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::commit();
            return Response::json(['success' => 1]);
        }
        catch(Exception $e){
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
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
