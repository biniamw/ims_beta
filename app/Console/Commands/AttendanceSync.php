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
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\Examples\Shared\SimpleLogger;
use PhpMqtt\Client\Exceptions\MqttClientException;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AttendanceController;
use PhpMqtt\Client\MqttClient;
use Psr\Log\LogLevel;
use Image;


class AttendanceSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $attendanceController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->attendanceController = new AttendanceController();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $mqtt = MQTT::connection();
            $mqt=new mqttmessage;

            $devicesdata=DB::select('SELECT devices.* FROM devices WHERE devices.Status="Active" AND devices.devicetype IN(4)');
            foreach($devicesdata as $devprop){
                $currentdate = Carbon::parse(Carbon::now())->format('Y-m-d');
                $currentime = Carbon::parse(Carbon::now())->format('h:i:s');
                $currentimesht = Carbon::parse(Carbon::now())->format('H:i');

                $currentdateandtime=$currentdate."T".$currentimesht;

                $topic="mqtt/face/".$devprop->DeviceId;
                $topicack="mqtt/face/".$devprop->DeviceId."/Ack";

                $uuid = Str::uuid()->toString();

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

                $mqtt->subscribe($topicack, function (string $topic, string $message) use($mqtt,$uuid,$mqt) {
                    $mqt->userid=1;
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

                if($recordnum > 0){
                    
                    $results = $this->attendanceController->checkLogRecords($devprop->id,$devprop->DeviceId,$recordnum,$devprop->ManualSyncLatestTime,$currentdatetime);
                    \Log::info($results);
                }
            }
        }
        catch(Exception $e)
        {       
            //return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }
}
