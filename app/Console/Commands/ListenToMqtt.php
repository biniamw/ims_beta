<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Bluerhinos\phpMQTT;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\attendance_import_log;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\Examples\Shared\SimpleLogger;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;
use Psr\Log\LogLevel;
use Image;
use App\Models\mqttmessage;
use App\Services\MqttService;
use Response;

class ListenToMqtt extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Listen to the MQTT topic RecPush and log attendance data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $device =1;
            $deviceid=2361925;

            $topic="mqtt/face/".$deviceid;
            $topicrec="mqtt/face/".$deviceid."/Ack";
            $topicreadlog="mqtt/face/".$deviceid."/Rec";

            MqttService::subscribe($topicreadlog, function ($topic, $message) use ($device, $deviceid) {
                $msgdata = json_decode($message, true);
                $attlogdata=[];
                
                $attlogdata[]=['RecordId'=>data_get($msgdata,'info.RecordID'),'empid'=>1,'Name'=>data_get($msgdata,'info.persionName'),'DateTime'=>data_get($msgdata,'info.time'),'deviceid'=>$device,'DeviceCode'=>$deviceid,'similarity1'=>data_get($msgdata,'info.similarity1'),'similarity2'=>data_get($msgdata,'info.similarity2'),'ImportType'=>1,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                attendance_import_log::insert($attlogdata);
            });  

        } catch (\Exception $e) {
            $this->error("Failed to connect to MQTT broker: " . $e->getMessage());
        }
    }
}
