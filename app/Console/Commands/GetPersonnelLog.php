<?php

namespace App\Console\Commands;

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use App\Models\attendance;
use App\Models\attendance_log;
use App\Models\attendance_import_log;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\Examples\Shared\SimpleLogger;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\MqttClient;
use Psr\Log\LogLevel;
use Image;
use App\Models\mqttmessage;
use Response;

class GetPersonnelLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'personnelLog:cron';

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
        $host = request()->getSchemeAndHttpHost(); 
        $gender=null;
        $persontype=null;
        ini_set('max_execution_time', '300000000');
        ini_set("pcre.backtrack_limit", "500000000");
        ini_set('memory_limit', '-1');
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $totalval=0;
        $conerror=[];
        $mqttflag=0;

        $now = Carbon::now();
        $meridiam = $now->format('A');
        $dayname = $now->format('l');

        $mquuid = Str::uuid()->toString();
        $currtime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');
        $curdate=Carbon::today()->toDateString();
        $starttime=null;
        $endtime=null;
        $fullstdatetime=null;
        $fullendatetime=null;
        $attlogdata=[];
        $deviceid=null;
        $device=null;
        $timeSt=null;
        $timeEn=null;
        $timeStAtt=null;
        $timeEnAtt=null;

        for($i=1;$i<=10000000000000;$i++){
            try{
                $mqtt = MQTT::connection();
                $mqt=new mqttmessage;

                $devicesdata=DB::select('SELECT devices.* FROM devices WHERE devices.Status="Active" AND devices.devicetype IN(2,3)');
                foreach($devicesdata as $devdata){
                    $topic="mqtt/face/".$devdata->DeviceId;
                    $topicrec="mqtt/face/".$devdata->DeviceId."/Ack";
                    $topicreadlog="mqtt/face/".$devdata->DeviceId."/Rec";

                    $deviceid=$devdata->DeviceId;
                    $device=$devdata->id;
                    
                    $uuid = Str::uuid()->toString();
                    $mqttuuid = Str::uuid()->toString();
                    $currentdate = Carbon::parse(Carbon::now())->format('Y-m-d');
                    $currentime = Carbon::parse(Carbon::now())->format('h:i:s');
                    $replaystime=$currentdate."T".$currentime;

                    if($currtime<13){
                        $fullstdatetime=$currentdate."T00:00:00";
                        $fullendatetime=$currentdate."T12:00:00";
                        $timeSt=$currentdate." 00:00:00";
                        $timeEn=$currentdate." 12:00:00";
                        $timeStAtt=$currentdate." 00:00";
                        $timeEnAtt=$currentdate." 12:00";

                    }
                    else if($currtime>=13){
                        $fullstdatetime=$currentdate."T12:00:00";
                        $fullendatetime=$currentdate."T23:59:59";
                        $timeSt=$currentdate." 12:00:00";
                        $timeEn=$currentdate." 23:59:59";
                        $timeStAtt=$currentdate." 12:00";
                        $timeEnAtt=$currentdate." 23:59";
                    }

                    $replaystimemsg='{
                        "operator": "UpMQTTconfig",
                        "messageId":"MessageID-UpMQTTconfig-'.$mqttuuid.'",
                        "info":
                        {
                            "facesluiceId":"'.$devdata->DeviceId.'",
                            "BeginTime":"'.$replaystime.'"                                
                        },
                    }';

                    $msgs='{
                        "operator": "ManualPushRecords",
                        "messageId":"MessageID-ManualPushRecords-'.$uuid.'",
                        "info":
                        {
                            "facesluiceId":"'.$devdata->DeviceId.'",
                            "TimeS":"'.$fullstdatetime.'",
                            "TimeE":"'.$fullendatetime.'",                             
                        },
                    }';

                    $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                        if ($elapsedTime >= 60) {
                            $mqtts->interrupt();
                        }
                    });

                    $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$uuid,$mqt) {
                        $mqt->userid=1;
                        $mqt->uuid=$uuid;
                        $mqt->message=$message;
                        $mqt->save();
                    }, 2);

                    $mqtt->publish($topic,$replaystimemsg,2);
                    $mqtt->publish($topic,$msgs,2);
                    $mqtt->loop(true);

                    $mqttmsg = DB::table('mqttmessages')->where('uuid',$uuid)->latest()->first();
                    $res=$mqttmsg->message;
                    $resl=json_decode($res, true);
                    
                    $code=data_get($resl,'code');
                    $result=data_get($resl,'info.result');
                    $recordnum=data_get($resl,'info.RecordNum');

                    if($code==200 && $result=="ok" && $recordnum>0){
                    
                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 21600) {
                                $mqtts->interrupt();
                            }
                        });

                        $mqtt->subscribe($topicreadlog, function (string $topic, string $messagelog) use($mqtt,$deviceid,$device,$attlogdata) {

                            $msgdata=json_decode($messagelog, true);
                            $attlogdata=[];
                            $attlogdata[]=['RecordId'=>data_get($msgdata,'info.RecordID'),'empid'=>1,'Name'=>data_get($msgdata,'info.persionName'),'DateTime'=>data_get($msgdata,'info.time'),'deviceid'=>$device,'DeviceCode'=>$deviceid,'similarity1'=>data_get($msgdata,'info.similarity1'),'similarity2'=>data_get($msgdata,'info.similarity2'),'ImportType'=>1,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                            attendance_import_log::insert($attlogdata);

                            \Log::info("\n\n**********************\n**********************\n**********************\n".data_get($msgdata,'operator')."  =>  ".data_get($msgdata,'info.persionName')."  =>  ".data_get($msgdata,'info.RecordID')."\n");

                        }, 2);

                        //$mqtt->publish($topic,$msgs,2);
                        $mqtt->loop(true);
 
                        $deleteduplicateimplog=DB::select('DELETE t1 FROM attendance_import_logs t1 INNER JOIN attendance_import_logs t2 WHERE t1.id > t2.id AND t1.empid =1 AND t1.DateTime=t2.DateTime AND t1.DeviceCode=t2.DeviceCode');
                        $updateimplog=DB::select('UPDATE attendance_import_logs SET attendance_import_logs.empid=(SELECT id FROM employees WHERE employees.name=attendance_import_logs.Name) WHERE attendance_import_logs.empid=1');
                        $inserttoattlog=DB::select('INSERT INTO attendance_logs(employees_id,timetables_id,Date,Time,PunchType,AttType,created_at,updated_at) SELECT empid,
                            IFNULL((SELECT timetables.id FROM shiftschedule_timetables INNER JOIN timetables ON shiftschedule_timetables.timetables_id=timetables.id WHERE shiftschedule_timetables.shiftschedules_id=(SELECT shiftschedules.id FROM shiftschedules WHERE shiftschedules.employees_id=attendance_import_logs.empid) AND shiftschedule_timetables.Date=DATE_FORMAT(attendance_import_logs.DateTime,"%Y-%m-%d") AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i") BETWEEN timetables.BeginningIn AND timetables.EndingOut LIMIT 1),1),DATE_FORMAT(attendance_import_logs.DateTime,"%Y-%m-%d"),DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i"),
                            (SELECT 
                            CASE WHEN 
                                (DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")>= IFNULL(TIME_FORMAT(SUBTIME(timetables.BreakEndTime,"00:30:00"),"%H:%i"),"23:59:59") AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")<= timetables.BeginningOut) OR (DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")>=timetables.BeginningIn AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")<=timetables.EndingIn) THEN "1"
                                WHEN
                                (DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")>= timetables.EndingIn AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i") <= IFNULL(TIME_FORMAT(ADDTIME(timetables.BreakStartTime,"00:30:00"),"%H:%i"),"00:00:00")) OR
                                (DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")>=timetables.BeginningOut AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i")<=timetables.EndingOut) 
                                THEN "2" ELSE "0" END FROM attendance_logs AS attlog INNER JOIN timetables ON attlog.timetables_id=attlog.timetables_id WHERE timetables.id=(IFNULL((SELECT timetables.id FROM shiftschedule_timetables INNER JOIN timetables ON shiftschedule_timetables.timetables_id=timetables.id WHERE shiftschedule_timetables.shiftschedules_id=(SELECT shiftschedules.id FROM shiftschedules WHERE shiftschedules.employees_id=attendance_import_logs.empid) AND shiftschedule_timetables.Date=DATE_FORMAT(attendance_import_logs.DateTime,"%Y-%m-%d") AND DATE_FORMAT(attendance_import_logs.DateTime,"%H:%i") BETWEEN timetables.BeginningIn AND timetables.EndingOut LIMIT 1),1)) LIMIT 1),
                            2,"'.Carbon::now().'","'.Carbon::now().'" FROM attendance_import_logs WHERE attendance_import_logs.DateTime>="'.$timeSt.'" AND attendance_import_logs.DateTime<="'.$timeEn.'" AND attendance_import_logs.DeviceCode="'.$deviceid.'"');

                        $deleteduplicateattlog=DB::select('DELETE t1 FROM attendance_logs t1 INNER JOIN attendance_logs t2 WHERE t1.id > t2.id AND t1.employees_id=t2.employees_id AND t1.Date=t2.Date AND t1.Time=t2.Time AND t1.timetables_id=t2.timetables_id');
                        
                        $inserttoattlog=DB::select('INSERT INTO attendances(employees_id,timetables_id,Date,PunchInTime,PunchOutTime,TimeOpt,PunchType,IsActualTimetable,IsPayrollMade,created_at,updated_at) SELECT DISTINCT attendance_logs.employees_id,attendance_logs.timetables_id,Date,"","","",1,0,0,"'.Carbon::now().'","'.Carbon::now().'" FROM attendance_logs WHERE CONCAT(attendance_logs.Date," ",attendance_logs.Time)>="'.$timeStAtt.'" AND CONCAT(attendance_logs.Date," ",attendance_logs.Time)<="'.$timeEnAtt.'"');
                        
                        $deleteattlog=DB::select('DELETE t1 FROM attendances t1 INNER JOIN attendances t2 WHERE t1.id > t2.id AND t1.employees_id=t2.employees_id AND t1.Date=t2.Date AND t1.Time=t2.Time AND t1.timetables_id=t2.timetables_id');

                        app('App\Http\Controllers\AttendanceController')->syncTimetable();
                        app('App\Http\Controllers\AttendanceController')->syncAttendances();

                    }
                }

                $mqttflag=1;
                $i=10000000000000;
            }
            catch(Exception $e)
            {
                $mqttflag=0;
            }
            $conerror[]=$mqttflag;
        }

    }
}
