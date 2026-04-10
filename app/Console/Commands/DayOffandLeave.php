<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\attendance;
use App\Models\attendance_log;
use App\Models\employee;
use App\Models\timetable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;

class DayOffandLeave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dayoffleave:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('max_execution_time', '300000000');
        ini_set("pcre.backtrack_limit", "500000000");
        ini_set('memory_limit', '-1');
        $timetable=null;
        $employeeid=null;
        $date=null;
        $dayoffattdata=[];
        $leaveattdata=[];
        $absentattdata=[];
        $currentdate = Carbon::today()->toDateString();
        $currentime = Carbon::now()->format('H:i');
        $currenthour=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');
        $prevday=Carbon::parse($currentdate)->subDays(1)->format('Y-m-d');;
        
        $dayoffdata=DB::select('SELECT DISTINCT shiftschedule_timetables.timetables_id,shiftschedules.employees_id,shiftschedule_timetables.Date FROM shiftschedule_timetables INNER JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id=shiftschedules.id WHERE shiftschedule_timetables.Date="'.$currentdate.'" AND shiftschedule_timetables.isworkday=2');
        foreach($dayoffdata as $dayoffdata){
            $dayoffattdata[]=['employees_id'=>$dayoffdata->employees_id,'timetables_id'=>$dayoffdata->timetables_id,'Date'=>$dayoffdata->Date,'PunchInTime'=>"",'PunchOutTime'=>"",'TimeOpt'=>12,'PunchType'=>1,'IsActualTimetable'=>1,'IsPayrollMade'=>0,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
        }
        attendance::insert($dayoffattdata);

        $leavedata=DB::select('SELECT requested_for FROM hr_leaves WHERE "'.$currentdate.'" BETWEEN hr_leaves.LeaveFrom AND hr_leaves.LeaveTo AND hr_leaves.Status="Approved"');
        foreach($leavedata as $leavedata){
            $usersprop = DB::table('users')->where('users.id',$leavedata->requested_for)->get();
            $employeeids = $usersprop[0]->empid;

            $leaveattdata[]=['employees_id'=>$employeeids,'timetables_id'=>1,'Date'=>$currentdate,'PunchInTime'=>"",'PunchOutTime'=>"",'TimeOpt'=>11,'PunchType'=>1,'IsActualTimetable'=>1,'IsPayrollMade'=>0,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
        }
        attendance::insert($leaveattdata);

        $absentdata=DB::select('SELECT DISTINCT shiftschedules.employees_id FROM shiftschedule_timetables INNER JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id=shiftschedules.id INNER JOIN employees ON shiftschedules.employees_id=employees.id WHERE shiftschedule_timetables.Date="'.$prevday.'" AND shiftschedule_timetables.isworkday=1 AND employees.IsOnLeave=0 AND shiftschedule_timetables.timetables_id!=1');
        foreach($absentdata as $absentdata){
            $shifttimetable = DB::table('shiftschedule_timetables')->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')->where('shiftschedules.employees_id',$absentdata->employees_id)->where('shiftschedule_timetables.Date',$prevday)->where('shiftschedule_timetables.isworkday',1)->where('shiftschedule_timetables.timetables_id','!=',1)->get();
            $schecnt = $shifttimetable->count();

            $attendancedata = DB::table('attendances')->where('attendances.employees_id',$absentdata->employees_id)->where('attendances.Date',$prevday)->where('attendances.timetables_id','!=',1)->get();
            $attcnt = $attendancedata->count();

            if($schecnt>0 && $attcnt==0){
                $absentattdata[]=['employees_id'=>$absentdata->employees_id,'timetables_id'=>1,'Date'=>$prevday,'PunchInTime'=>"",'PunchOutTime'=>"",'TimeOpt'=>10,'PunchType'=>1,'IsActualTimetable'=>1,'IsPayrollMade'=>0,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
            }
        }
        attendance::insert($absentattdata);
        
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::statement('SET @row_number = 0');
            DB::update('UPDATE shiftschedule_timetables SET id = (@row_number := @row_number + 1)');
            DB::statement('ALTER TABLE shiftschedule_timetables AUTO_INCREMENT = 1');

            DB::statement('SET @attlog_row = 0');
            DB::update('UPDATE attendance_logs SET id = (@attlog_row := @attlog_row + 1)');
            DB::statement('ALTER TABLE attendance_logs AUTO_INCREMENT = 1');

            DB::statement('SET @att_row = 0');
            DB::update('UPDATE attendances SET id = (@att_row := @att_row + 1)');
            DB::statement('ALTER TABLE attendances AUTO_INCREMENT = 1');

            DB::commit();
        
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        } finally {
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
