<?php

namespace App\Console\Commands;

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
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

class SyncMemberHalfday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:memberhalfday';

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

        $now = Carbon::now();
        $meridiam = $now->format('A');
        $dayname = $now->format('l');
        $starttime=null;
        $endtime=null;
        $gender=null;
        $persontype=null;
        $picdata=null;
        $rightthumb="";
        $rightindex="";
        $rightmiddle="";
        $rightring="";
        $rightpicky="";
        $leftthumb="";
        $leftindex="";
        $leftmiddle="";
        $leftring="";
        $leftpicky="";
        $mqtt=null;
        $mqttflag=null;
        $conerror=[];
        $i=0;
        $j=0;
        $topic=null;
        $topicrec=null;
        $batchdata=[];
        $batchval=null;
        $memcnt=0;
        $mlistcount=[];
        $starttime=null;
        $endtime=null;
        $mquuid = Str::uuid()->toString();

       
            try{
                $mqtt = MQTT::connection();

                $devicesdata=DB::select('SELECT DISTINCT appconsolidates.devices_id,devices.* FROM appconsolidates INNER JOIN devices ON appconsolidates.devices_id=devices.id WHERE appconsolidates.Status="Active"');
                foreach($devicesdata as $devdata){
                    $batchdata=[];
                    $batchval=null;
                    $memcnt=0;
                    $mlistcount=[];

                    $memlists=DB::select('SELECT DISTINCT appconsolidates.memberships_id AS MemberIdVal,memberships.Status AS MemberStatus,periods.PeriodName,(SELECT perioddetails.FirstHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfFrom,(SELECT perioddetails.FirstHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfTo,(SELECT perioddetails.SecondHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfFrom,(SELECT perioddetails.SecondHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfTo,appconsolidates.devices_id,devices.*,applications.RegistrationDate,applications.ExpiryDate,memberships.Name,memberships.Gender,memberships.DOB,memberships.TinNumber,memberships.Nationality,memberships.Country,memberships.cities_id,memberships.subcities_id,memberships.Woreda,memberships.Location,memberships.Mobile,memberships.Phone,memberships.Email,memberships.Occupation,memberships.HealthStatus,memberships.Memo,memberships.Picture,memberships.IdentificationId,memberships.ResidanceId,memberships.PassportNo,memberships.LoyalityStatus,memberships.DateOfJoining,memberships.devices_id AS deviceidsval,memberships.PersonUUID,memberships.LeftThumb,memberships.LeftIndex,memberships.LeftMiddle,memberships.LeftRing,memberships.LeftPinky,memberships.RightThumb,memberships.RightIndex,memberships.RightMiddle,memberships.RightRing,memberships.RightPinky FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN devices ON appconsolidates.devices_id=devices.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE appconsolidates.Status="Active" AND memberships.Picture IS NOT NULL AND appconsolidates.devices_id='.$devdata->devices_id.' ORDER BY periods.id DESC');
                    foreach($memlists as $mrow){
                        if($mrow->Gender=="Male"){
                            $gender=0;
                        }
                        if($mrow->Gender=="Female"){
                            $gender=1;
                        }

                        if($mrow->MemberStatus=="Active"){
                            $persontype=0;
                        }
                        if($mrow->MemberStatus!="Active"){
                            $persontype=1;
                        }

                        
                        if($mrow->SecondHalfFrom==null || $mrow->SecondHalfFrom==""){
                            $starttime="23:59:59";
                        }
                        if($mrow->SecondHalfFrom!=null && $mrow->SecondHalfFrom!=""){
                            $starttime=$mrow->SecondHalfFrom.":00";
                        }

                        if($mrow->SecondHalfTo==null || $mrow->SecondHalfTo==""){
                            $endtime="23:59:59";
                        }
                        if($mrow->SecondHalfTo!=null && $mrow->SecondHalfTo!=""){
                            $endtime=$mrow->SecondHalfTo.":59";
                        }
                        

                        $mlistcount[]=$mrow->MemberIdVal;
                        $batchdata[]='{
                            "facesluiceId":"'.$devdata->DeviceId.'",
                            "customId":"'.$mrow->MemberIdVal.'",
                            "tempCardType":2,
                            "personType":"'.$persontype.'",
                            "name":"'.$mrow->Name.'",
                            "gender":"'.$gender.'",
                            "birthday":"'.$mrow->DOB.'",
                            "telnum1":"'.$mrow->Mobile." , ".$mrow->Phone.'",
                            "address":"'.$mrow->Location.'",
                            "RFCardMode":0,
                            "RFIDCard":"'.$mrow->Mobile.'",
                            "PersonUUID":"'.$mrow->PersonUUID.'",
                            "cardValidBegin":"'.$mrow->RegistrationDate." ".$starttime.'",
                            "cardValidEnd":"'.$mrow->ExpiryDate." ".$endtime.'",
                            "picURI":"'.$host."/storage/uploads/MemberPicture/".$mrow->Picture.'" 
                        }';
                    }

                    for($j=1;$j<=100;$j++){
                        $batchval=null;
                        $batchval= array_slice($batchdata,0,50);
                        
                        $topic="mqtt/face/".$devdata->DeviceId;
                        $topicrec="mqtt/face/".$devdata->DeviceId."/Ack";

                        $batchvaldata=implode(',', $batchval);

                        $msgs='{
                            "messageId":"MessageID-AddPersons-'.$mquuid.'",
                            "DataBegin":"BeginFlag",
                            "operator": "AddPersons",
                            "PersonNum":"'.count($batchval).'",
                            "info":
                               ['.$batchvaldata.']
                               "DataEnd":"EndFlag"
                        }';

                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 100) {
                                $mqtts->interrupt();
                            }
                        });

                        $mqtt->publish($topic,$msgs,2);
                        
                        $mqtt->loop(true);
                        
                        if(count($batchdata)<=50){
                            $j=100;
                        }
                        array_splice($batchdata, 0,50);
                    }
                }
                $mqttflag=1;
                $i=10000000000000;
            }
            catch(Exception $e)
            {
                $mqttflag=0;
                
                //return Response::json(['dberrors' =>  $e->getMessage()]);
            }
            $conerror[]=$mqttflag;
        

    }
}
