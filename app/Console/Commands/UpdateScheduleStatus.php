<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
use Image;

class UpdateScheduleStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:schedule_status';

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
        try{
            $curdate=Carbon::today()->toDateString();

            $scheduledata=DB::select('SELECT shiftscheduledetails.id,shiftscheduledetails.ValidDate,shiftscheduledetails.shiftschedules_id FROM shiftscheduledetails WHERE shiftscheduledetails.Status IN("Active","To-Be-Active")');
            foreach($scheduledata as $row){
                $arraycontent = explode(" to ",$row->ValidDate);
                shiftscheduledetail::where('shiftscheduledetails.id',$row->id)->update(['shiftscheduledetails.Status'=>($curdate >= $arraycontent[0] && $curdate <= $arraycontent[1]) ? "Active" : (($curdate > $arraycontent[1]) ? "Expired" : "To-be-Active")]);
                
                shiftschedule::where('id', $row->shiftschedules_id)
                    ->update([
                        'Date' => DB::raw("(SELECT CONCAT(MIN(Date), ' to ', MAX(Date)) FROM shiftschedule_timetables WHERE shiftschedules_id = $row->shiftschedules_id)"),
                        'ShiftFlag' => DB::raw("COALESCE((SELECT ShiftFlag FROM shiftscheduledetails WHERE shiftschedules_id = $row->shiftschedules_id AND Status = 'Active' LIMIT 1), '')")
                    ]);
            }
        }
        catch(Exception $e)
        {       
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }
}
