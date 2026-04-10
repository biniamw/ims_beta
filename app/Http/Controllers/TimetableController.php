<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\actions;
use App\Models\timetable;
use App\Http\Controllers\AttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class TimetableController extends Controller
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
        if($request->ajax()) {
            return view('hr.setup.timetable')->renderSections()['content'];
        }
        else{
            return view('hr.setup.timetable');
        }
    }

    public function timetablelistcon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $timetablelist=DB::select('SELECT *,CASE WHEN timetables.PunchingMethod=2 THEN "2X" WHEN timetables.PunchingMethod=4 THEN "4X" END AS PunchingMethods FROM timetables WHERE timetables.id>1 ORDER BY timetables.id DESC');
        if(request()->ajax()) {
            return datatables()->of($timetablelist)
            ->addIndexColumn()
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
    public function store(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $headerid = $request->recId;
        $findid = $request->recId;
        $curdate = Carbon::today()->toDateString();
        $breaktime = "";
        $actions = "";
        $overlappedData = [];
        $overlapcounter = 0;
         
        $validator = Validator::make($request->all(), [
            'TimetableName' => ['required', 'string', 'max:255',Rule::unique('timetables')->ignore($findid)],
            'PunchingMethod' => 'required',
            'BreakTimeAsWorkTime' => 'required',
            'BreakTimeAsOvertime' => 'required',
            'EarlyCheckInOvertime' => 'required',
            'OnDutyTime' => ['required','date_format:H:i','gte:BeginningIn',
                Rule::unique('timetables')->where(function ($query) use($findid,$request) {
                    $query->where('OnDutyTime',$request->OnDutyTime)->where('OffDutyTime',$request->OffDutyTime)->where('PunchingMethod',$request->PunchingMethod)->where('BreakHourFlag',$request->BreakHourType);
                })->ignore($findid)
            ],
            'OffDutyTime' => ['required','date_format:H:i','lte:EndingOut',
                Rule::unique('timetables')->where(function ($query) use($findid,$request){
                    $query->where('OnDutyTime',$request->OnDutyTime)->where('OffDutyTime',$request->OffDutyTime)->where('PunchingMethod',$request->PunchingMethod)->where('BreakHourFlag',$request->BreakHourType);
                })->ignore($findid)
            ],
            'LateTime' => 'required|gte:0',
            'LeaveEarlyTime' => 'required|gte:0',
            'BeginningIn' => 'required|date_format:H:i|lte:OnDutyTime',
            'EndingIn' => 'required|date_format:H:i|lte:BeginningOut|gte:BeginningIn',
            'BeginningOut' => 'required|date_format:H:i|lte:OffDutyTime|gte:EndingIn',
            'EndingOut' => 'required|date_format:H:i|gte:OffDutyTime',
            'OvertimeStart' => 'nullable|date_format:H:i|gte:OffDutyTime',
            'BreakHourType' => 'required_if:PunchingMethod,4',
            'BreakStartTime' => 'required_if:BreakHourType,Fixed',
            'BreakEndTime' => 'required_if:BreakHourType,Fixed',
            'LateTimeBreak' => 'required_if:BreakHourType,Fixed',
            'LeaveEarlyTimeBreak' => 'required_if:BreakHourType,Fixed',
            'BreakHour' => 'required',
            'WorkingHour' => 'required',
            'CheckInLateMinute' => 'nullable',
            'CheckOutEarlyMinute' => 'nullable',
            'NoCheckInMark' => 'required',
            'NoCheckInMinute' => 'required_if:NoCheckInMark,2',
            'NoCheckOutMark' => 'required',
            'NoCheckOutMinute' => 'required_if:NoCheckOutMark,3',
            'status' => 'required',
        ]);

        if ($findid != null && $request->BeginningIn != null && $request->EndingOut != null){
            $getshiftscheduledata=DB::select('SELECT DISTINCT shift_day_times.shifts_id,shifts.ShiftFlag,shifts.ShiftName FROM shift_day_times LEFT JOIN shifts ON shift_day_times.shifts_id=shifts.id WHERE shift_day_times.timetables_id='.$findid.' ORDER BY shift_day_times.id ASC');
            foreach($getshiftscheduledata as $row){
                $overlaps = DB::table('shift_day_times as a')
                    ->join('timetables as ta', 'a.timetables_id', '=', 'ta.id')
                    ->where('a.shifts_id', $row->shifts_id)
                    ->where('a.timetables_id', '!=', $findid)
                    ->whereIn('a.daynum', function ($sub) use ($row, $findid) {
                        $sub->select('daynum')
                            ->from('shift_day_times')
                            ->where('shifts_id', $row->shifts_id)
                            ->where('timetables_id', $findid);
                    })
                    ->where(function ($query) use ($request) {
                        $query->where('ta.BeginningIn', '<', $request->EndingOut)
                            ->where('ta.EndingOut', '>', $request->BeginningIn);
                    })
                    ->select('a.shifts_id','ta.TimetableName')
                    ->distinct()
                    ->get();

                foreach ($overlaps as $item) {
                    ++$overlapcounter;
                    if($row->ShiftFlag == 1){
                        $overlappedData[]= "<b>{$overlapcounter}.</b> Shift Name: <b>{$row->ShiftName}</b> Timetable: <b>{$item->TimetableName}</b><br>";
                    }
                    if($row->ShiftFlag == 2){
                        $shifttimetbl = DB::table('shiftschedule_timetables')
                        ->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
                        ->join('shiftscheduledetails','shiftschedule_timetables.shiftscheduledetails_id','shiftscheduledetails.id')
                        ->join('employees','shiftschedules.employees_id','employees.id')
                        ->where('shiftschedule_timetables.shifts_id',$item->shifts_id)
                        ->selectRaw("employees.name,shiftscheduledetails.ValidDate")
                        ->first();
                         
                        $overlappedData[]= "<b>{$overlapcounter}.</b> Employee Name: <b>{$shifttimetbl->name}</b> Valid Range: <b>{$shifttimetbl->ValidDate}</b> Timetable: <b>{$item->TimetableName}</b><br>";
                    }
                }
            }
        }

        if ($validator->passes() && $overlapcounter == 0){
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'TimetableName' => $request->TimetableName,
                    'PunchingMethod' => $request->PunchingMethod,
                    'BreakTimeAsWorkTime' => $request->BreakTimeAsWorkTime,
                    'BreakTimeAsOvertime' => $request->BreakTimeAsOvertime,
                    'EarlyCheckInOvertime' => $request->EarlyCheckInOvertime,
                    'OnDutyTime' => $request->OnDutyTime,
                    'OffDutyTime' => $request->OffDutyTime,
                    'WorkTime' => $request->WorkingHour,
                    'LateTime' => $request->LateTime,
                    'LeaveEarlyTime' => $request->LeaveEarlyTime,
                    'BeginningIn' => $request->BeginningIn,
                    'EndingIn' => $request->EndingIn,
                    'BeginningOut' => $request->BeginningOut,
                    'EndingOut' => $request->EndingOut,
                    'is_night_shift' => $request->has('isnightshift') ? 1 : 0,
                    'OvertimeStart' => $request->OvertimeStart,
                    'BreakHourFlag' => $request->BreakHourType,
                    'BreakStartTime' => $request->BreakStartTime,
                    'BreakEndTime' => $request->BreakEndTime,
                    'BreakHour' =>$request->BreakHour,
                    'LateTimeBreak' => $request->LateTimeBreak,
                    'LeaveEarlyTimeBreak' => $request->LeaveEarlyTimeBreak,
                    'CheckInLateMinute' => $request->CheckInLateMinute,
                    'CheckOutEarlyMinute' => $request->CheckOutEarlyMinute,
                    'NoCheckInFlag' => $request->NoCheckInMark,
                    'NoCheckInMinute' => $request->NoCheckInMinute,
                    'NoCheckOutFlag' => $request->NoCheckOutMark,
                    'NoCheckOutMinute' => $request->NoCheckOutMinute,
                    'TimetableColor' => $request->TimetableColor,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = timetable::where('id', $findid)->first();
                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $ttable = timetable::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                if($findid == null){
                    $actions = "Created";
                }
                else if($findid != null){
                    $allDates = [];
                    $getDates=DB::select('SELECT shiftschedules.employees_id,shiftschedule_timetables.Date FROM shiftschedule_timetables LEFT JOIN shiftscheduledetails ON shiftschedule_timetables.shiftscheduledetails_id=shiftscheduledetails.id LEFT JOIN shiftschedules ON shiftscheduledetails.shiftschedules_id=shiftschedules.id WHERE shiftschedule_timetables.timetables_id='.$findid.' ORDER BY shiftschedule_timetables.Date ASC');
                    foreach($getDates as $datesrow){
                        $allDates[] = $datesrow->Date;
                    }

                    $getEmployeeAndDate=DB::select('SELECT attendance_summaries.employees_id,attendance_summaries.Date FROM attendance_summaries WHERE attendance_summaries.IsPayrollMade!=1 ORDER BY id ASC');
                    foreach($getEmployeeAndDate as $row){
                        if (in_array($row->Date,$allDates)) {
                            $this->targetService->checkAttendanceStatus($row->employees_id,$row->Date);
                        }
                    }
                    $actions = "Edited";
                }

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $ttable->id,
                    'pagename' => "timetable",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'rec_id' => $ttable->id]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
        else if($overlapcounter > 0){
            $overlappedData = str_replace(',', '', $overlappedData);
            return Response::json(['overlapcnt' => $overlapcounter,'overlapdata' => $overlappedData]);
        }
    }

    public function showtimetablecon($id){
        $cnt=0;
        $attcnt=0;
        $shiftcnt=0;
        $timetbl=timetable::findorFail($id);
        $createddate = Carbon::createFromFormat('Y-m-d H:i:s', $timetbl->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        
        $updateddate = Carbon::createFromFormat('Y-m-d H:i:s', $timetbl->updated_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');


        $data = timetable::where('timetables.id', $id)
        ->get(['timetables.*',DB::raw('CASE WHEN timetables.PunchingMethod=2 THEN "2X" WHEN timetables.PunchingMethod=4 THEN "4X" END AS PunchingMethods'),
        DB::raw('CASE WHEN timetables.NoCheckInFlag=1 THEN "Absent" WHEN timetables.NoCheckInFlag=2 THEN "Late" END AS NoCheckInFlags'),
        DB::raw('CASE WHEN timetables.NoCheckOutFlag=1 THEN "Absent" WHEN timetables.NoCheckOutFlag=3 THEN "Early" END AS NoCheckOutFlags'),
        DB::raw('CASE WHEN timetables.BreakHourFlag=0 THEN "Fixed" WHEN timetables.BreakHourFlag=1 THEN "Flexible" END AS BreakHourType'),
        DB::raw("'$createddate' AS CreatedDateTime"),DB::raw("'$updateddate' AS UpdatedDateTime")]);
    
        $timetablecnt = DB::table('shiftschedule_timetables')->where('timetables_id',$id)->get();
        $cnt = $timetablecnt->count();

        $attimetable = DB::table('attendance_logs')->where('timetables_id',$id)->get();
        $attcnt = $attimetable->count();

        $shiftdata = DB::table('shift_day_times')->where('timetables_id',$id)->get();
        $shiftcnt = $shiftdata->count();

        $activitydata=actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"timetable")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['timetablelist'=>$data,'cnt'=>$cnt,'attcnt'=>$attcnt,'shiftcnt'=>$shiftcnt,'activitydata'=>$activitydata]);
    }

    public function deletetimetablecon(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $users = Auth()->user();

        DB::beginTransaction();
        try{
            $findid = $request->delRecId;
            DB::table('timetables')->where('id',$findid)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "timetable",
                'action' => "Delete",
                'status' => "Delete",
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
