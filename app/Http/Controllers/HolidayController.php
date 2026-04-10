<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\actions;
use App\Models\holiday;
use App\Models\overtime;
use App\Models\shiftschedule_timetable;
use App\Http\Controllers\AttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class HolidayController extends Controller
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
        $overtimedata = overtime::orderBy("id","ASC")->where("Status","Active")->get();
        if($request->ajax()) {
            return view('hr.setup.holiday',['overtimedata' => $overtimedata])->renderSections()['content'];
        }
        else{
            return view('hr.setup.holiday',['overtimedata' => $overtimedata]);
        }
    }

    public function holidaylistcon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $holidaylist=DB::select('SELECT * FROM holidays ORDER BY holidays.id DESC');
        if(request()->ajax()) {
            return datatables()->of($holidaylist)
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
        $settings = DB::table('settings')->latest()->first();
        $fiscalyear = $settings->FiscalYear;
        $actions = "";

        $validator = Validator::make($request->all(), [
            'HolidayName' => ['required', 'string', 'max:255',Rule::unique('holidays')->ignore($findid)],
            'HolidayDate' => ['required',Rule::unique('holidays')->ignore($findid)],
            'CalculateOvertime' => 'required',
            'status' => 'required|string',
        ]);

        if ($validator->passes()){
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'HolidayName' => $request->HolidayName,
                    'FiscalYear' => $fiscalyear,
                    'HolidayDate' => $request->HolidayDate,
                    'overtime_id' => $request->CalculateOvertime,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = holiday::where('id', $findid)->first();
                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $holiday = holiday::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                //dd($request->status);
                $allDates = [];
                $getholidayschedule=DB::select('SELECT shiftschedule_timetables.* FROM shiftschedule_timetables LEFT JOIN shiftscheduledetails ON shiftschedule_timetables.shiftscheduledetails_id=shiftscheduledetails.id WHERE shiftscheduledetails.ScheduleOnHoliday=0 AND shiftschedule_timetables.Date="'.$request->HolidayDate.'"');
                foreach($getholidayschedule as $schrow){
                    shiftschedule_timetable::where('shiftschedule_timetables.Date',$request->HolidayDate)
                        ->where('shiftschedule_timetables.Date',$request->HolidayDate)
                        ->where('shiftschedule_timetables.shiftschedules_id',$schrow->shiftschedules_id)
                        ->where('shiftschedule_timetables.shiftscheduledetails_id',$schrow->shiftscheduledetails_id)
                        ->where('shiftschedule_timetables.timetables_id','!=',1)
                        ->update(['isworkday'=> ($request->status == "Inactive" && $schrow->timetables_id != 1) ? 1 : (($request->status == "Active" && $schrow->timetables_id != 1) ? 3 : 2)]);
                }

                $getDates=DB::select('SELECT shiftschedules.employees_id,shiftschedule_timetables.Date FROM shiftschedule_timetables LEFT JOIN shiftscheduledetails ON shiftschedule_timetables.shiftscheduledetails_id=shiftscheduledetails.id LEFT JOIN shiftschedules ON shiftscheduledetails.shiftschedules_id=shiftschedules.id WHERE shiftschedule_timetables.Date="'.$request->HolidayDate.'" ORDER BY shiftschedule_timetables.Date ASC');
                foreach($getDates as $datesrow){
                    $allDates[] = $datesrow->Date;
                }

                $getEmployeeAndDate=DB::select('SELECT attendance_summaries.employees_id,attendance_summaries.Date FROM attendance_summaries WHERE attendance_summaries.IsPayrollMade!=1 ORDER BY id ASC');
                foreach($getEmployeeAndDate as $row){
                    if (in_array($row->Date,$allDates)) {
                        $this->targetService->checkAttendanceStatus($row->employees_id,$row->Date);
                    }
                }

                $actions = $findid == null ? "Created" : "Edited";

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $holiday->id,
                    'pagename' => "holiday",
                    'action' => $actions,
                    'status' => $actions,
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
        else if($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function showholidaycon($id){
        $datefromval = 0;
        $recdata = holiday::findorFail($id);

        $holidaydatas = DB::table('hr_leaves')->where('LeaveFrom','<=',$recdata->HolidayDate)->where('LeaveTo','>=',$recdata->HolidayDate)->get();
        $datefromval = $holidaydatas->count();

        $data = holiday::join('overtimes','holidays.overtime_id','overtimes.id')->where('holidays.id', $id)->get(['holidays.*','overtimes.OvertimeLevelName']);

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"holiday")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['holidaydata' => $data,'datefromval' => $datefromval,'activitydata' => $activitydata]);       
    }

    public function deleteholidaycon(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        
        DB::beginTransaction();
        try{
            $findid = $request->delRecId;
            DB::table('holidays')->where('id',$findid)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "holiday",
                'action' => "Delete",
                'status' => "Delete",
                'reason' => "",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
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
