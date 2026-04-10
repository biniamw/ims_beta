<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\device;
use App\Models\mqttmessage;
use App\Models\actions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Response;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\Examples\Shared\SimpleLogger;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\MqttClient;
use Psr\Log\LogLevel;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $currentdate=Carbon::today()->toDateString();
        $branchs=DB::select('SELECT id,BranchName FROM branches WHERE branches.Status="Active" ORDER BY branches.BranchName ASC');
        if($request->ajax()) {
            return view('registry.device',['branchs'=>$branchs])->renderSections()['content'];
        }
        else{
            return view('registry.device',['branchs'=>$branchs]);
        }
    }

    public function deviceListCon()
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $users = Auth()->user();
        $devicelist = DB::select('SELECT branches.BranchName,devices.* FROM devices LEFT JOIN branches ON devices.branches_id=branches.id WHERE devices.id>1 ORDER BY devices.id DESC');
        if(request()->ajax()) {
            return datatables()->of($devicelist)
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
    public function store(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $fullip = null;
        $headerid = $request->devicesid;
        $findid = $request->devicesid;
        $curdate = Carbon::today()->toDateString();

        $validator = Validator::make($request->all(), [
            'Branch' => ['required'],
            'DeviceId' => [
                'required',
                Rule::unique('devices', 'DeviceId')->ignore($findid),
            ],
            'DeviceName' => [
                'required',
                Rule::unique('devices', 'DeviceName')->ignore($findid),
            ],
            'IPAddress' => [
                'nullable',
                Rule::unique('devices', 'IPAddress')->ignore($findid),
            ],
            'Port' => ['nullable','numeric'],
            'TimeZone' => ['required'],
            'SyncMode' => ['required'],
            'RegistrationDevice' => ['required'],
            'AttendanceDevice' => ['required'],
            'UserName' => ['required'],
            'Password' => ['required'],
            'status' => ['required'],
        ]);

        if ($validator->passes()) {
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'branches_id'=> $request->Branch,
                    'DeviceId'=>  $request->DeviceId,
                    'DeviceName'=>  $request->DeviceName,
                    'IpAddress'=>  $request->IPAddress,
                    'Port'=>  $request->Port,
                    'TimeZone'=>  $request->TimeZone,
                    'SyncMode'=>  $request->SyncMode,
                    'RegistrationDevice'=>  $request->RegistrationDevice,
                    'AttendanceDevice'=>  $request->AttendanceDevice,
                    'Username'=>  $request->UserName,
                    'Password'=> $request->Password,
                    'Description'=>  $request->Description,
                    'Status'=>  $request->status,
                ];

                $DbData = device::where('id', $findid)->first();

                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $devicereg = device::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";
                actions::insert([
                    'user_id' => $userid,
                    'pageid' => $devicereg->id,
                    'pagename' => "device",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1, 'rec_id' => $devicereg->id]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else{
            return Response::json(['errors'=> $validator->errors()]);
        }
        
    }

    public function testconn(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->devicesid;
        $fullip=null;
        $deviceid=$request->DeviceId;
        $ipadd=$request->IPAddress;
        $port=$request->Port;
        $username=$request->UserName;
        $password=$request->Password;
        $topic="mqtt/face/".$deviceid;
        $topicrec="mqtt/face/".$deviceid."/Ack";
        if($port!=null){
            $fullip=$ipadd.":".$port;
        }
        if($port==null){
            $fullip=$ipadd;
        }

        $validator = Validator::make($request->all(), [
            'DeviceId' => ['required',Rule::unique('devices')->where(function ($query){
                })->ignore($findid)
            ],
            'IPAddress' => "required|unique:devices,IpAddress,$findid",
            'UserName' => ['required'],
            'Password' => ['required'],
        ]);
        if($validator->passes()){
            try
            {
                // $apiurlval="http://".$fullip."/action/SetUserPwd";
                // return Http::withBasicAuth($username,$password)
                // ->withHeaders(["Content-Type"=>"application/x-www-form-urlencoded; charset=UTF-8"])
                // ->post($apiurlval,[
                //     'operator'=>"SetUserPwd",
                //     'info'=>[
                //         "DeviceID"=>$deviceid,
                //         "User"=> "admin",
                //         "Pwd"=>"admin"
                //     ]
                // ]);


                $userid=Auth()->user()->id;
                $mquuid = Str::uuid()->toString();
                $mqt=new mqttmessage;
                $mqtt = MQTT::connection();


                $msgs='{
                    "operator": "GetTPTconfig",
                    "messageId":"ID:TestConnection-'.$mquuid.'",
                    "info":
                    {
                        "facesluiceId":"2361921",
                        "TemperatureMode":0,
                        "ShowAbnormalTemp":1,
                    },
                }';
               

                $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                    if ($elapsedTime >= 60) {
                        $mqtts->interrupt();
                    }
                });

                $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                    $mqt->userid=$userid;
                    $mqt->uuid=$mquuid;
                    $mqt->message=$message;
                    $mqt->save();
                }, 2);

                $mqtt->publish($topic,  $msgs, 2);
                
                $mqtt->loop(true);
                $mqttmsg = DB::table('mqttmessages')->where('userid',$userid)->where('uuid',$mquuid)->latest()->first();
                $res=$mqttmsg->message;
                $response=json_decode($res, true);
                return Response::json(['success' => $response]);
                $mqtt->disconnect();
            }
            catch(Exception $e)
            {
                return Response::json(['connerror' =>  $e->getMessage()]);
            }
        }
        else if($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function testconninfo(Request $request)
    {
        $fullip=null;
        $deviceid=$request->devicesidinfo;
        $ipadd=$request->ipaddressinfo;
        $port=$request->portinfo;
        $username=$request->usernameinfo;
        $password=$request->passwordinfo;
        $topic="mqtt/face/".$deviceid;
        $topicrec="mqtt/face/".$deviceid."/Ack";
        $topicreceivealldata="mqtt/face/".$deviceid."/Rec";
        if($port!=null){
            $fullip=$ipadd.":".$port;
        }
        if($port==null){
            $fullip=$ipadd;
        }
        
        try
        {
            // $apiurlval="http://".$fullip."/action/SearchPerson";
            // $response=Http::withBasicAuth($username,$password)
            // ->withHeaders(["Content-Type"=>"application/x-www-form-urlencoded; charset=UTF-8"])
            // ->post($apiurlval,[
            //     'operator'=>"SearchPerson",
            //     'info'=>[
            //         "DeviceID"=>$deviceid,
            //         "SearchType"=> 0,
            //         "SearchID"=>1234567,
            //         "Picture"=>0,
            //     ]
            // ]);
           
            
            $userid=Auth()->user()->id;
            $mquuid = Str::uuid()->toString();
            $mqt=new mqttmessage;
            $mqtt = MQTT::connection();
            $publishTime = now();
           
            $msgs='{
                "operator": "GetTPTconfig",
                "messageId":"ID:TestConnection-'.$mquuid.'",
                "info":
                {
                    "facesluiceId":"'.$deviceid.'",
                    "TemperatureMode":0,
                    "ShowAbnormalTemp":1,
                },
            }';     

            $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) use ($publishTime) {
                if ($elapsedTime >= 4) {
                    $mqtts->interrupt();
                }
            });

            $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                $mqt->userid=$userid;
                $mqt->uuid=$mquuid;
                $mqt->message=$message;
                $mqt->save();
            }, 2);

            $mqtt->publish($topic,$msgs,2);
           
            $mqtt->loop(true);
            $mqttmsg = DB::table('mqttmessages')->where('userid',$userid)->where('uuid',$mquuid)->latest()->first();
            $res=$mqttmsg->message;
            $response=json_decode($res, true);
            return Response::json(['success' => $response]);
            $mqtt->disconnect();
        }
        catch(Exception $e)
        {
            return Response::json(['connerror' =>  $e->getMessage()]);
        }
    }

    public function opendoorinfo(Request $request)
    {
        $fullip=null;
        $deviceid=$request->devicesidinfo;
        $ipadd=$request->ipaddressinfo;
        $port=$request->portinfo;
        $username=$request->usernameinfo;
        $password=$request->passwordinfo;
        $topic="mqtt/face/".$deviceid;
        $topicrec="mqtt/face/".$deviceid."/Ack";
        if($port!=null){
            $fullip=$ipadd.":".$port;
        }
        if($port==null){
            $fullip=$ipadd;
        }
        
        try
        {
            // $apiurlval="http://".$fullip."/action/SearchPerson";
            // $response=Http::withBasicAuth($username,$password)
            // ->withHeaders(["Content-Type"=>"application/x-www-form-urlencoded; charset=UTF-8"])
            // ->post($apiurlval,[
            //     'operator'=>"SearchPerson",
            //     'info'=>[
            //         "DeviceID"=>$deviceid,
            //         "SearchType"=> 0,
            //         "SearchID"=>1234567,
            //         "Picture"=>0,
            //     ]
            // ]);
           
            $userid=Auth()->user()->id;
            $mquuid = Str::uuid()->toString();
            $mqt=new mqttmessage;
            $mqtt = MQTT::connection();

            $msgs='{
                "operator": "Unlock",
                "messageId":"ID:OpenDoor-'.$mquuid.'",
                "info":
                {
                    "facesluiceId":"'.$deviceid.'",
                    "openDoor":1,
                    "Showinfo": "Please Pass"
                },
            }';     

            $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                if ($elapsedTime >= 2) {
                    $mqtts->interrupt();
                }
            });

            $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                $mqt->userid=$userid;
                $mqt->uuid=$mquuid;
                $mqt->message=$message;
                $mqt->save();
            }, 2);

            $mqtt->publish($topic,$msgs,2);
            
            $mqtt->loop(true);
            $mqttmsg = DB::table('mqttmessages')->where('userid',$userid)->where('uuid',$mquuid)->latest()->first();
            $res=$mqttmsg->message;
            $response=json_decode($res, true);
            return Response::json(['success' => $response]);
            $mqtt->disconnect();
        }
        catch(Exception $e)
        {
            return Response::json(['connerror' =>  $e->getMessage()]);
        }
    }

    public function restartdeviceinfo(Request $request)
    {
        $fullip=null;
        $deviceid=$request->devicesidinfo;
        $ipadd=$request->ipaddressinfo;
        $port=$request->portinfo;
        $username=$request->usernameinfo;
        $password=$request->passwordinfo;
        $topic="mqtt/face/".$deviceid;
        $topicrec="mqtt/face/".$deviceid."/Ack";
        if($port!=null){
            $fullip=$ipadd.":".$port;
        }
        if($port==null){
            $fullip=$ipadd;
        }
        
        try
        {
            // $apiurlval="http://".$fullip."/action/SearchPerson";
            // $response=Http::withBasicAuth($username,$password)
            // ->withHeaders(["Content-Type"=>"application/x-www-form-urlencoded; charset=UTF-8"])
            // ->post($apiurlval,[
            //     'operator'=>"SearchPerson",
            //     'info'=>[
            //         "DeviceID"=>$deviceid,
            //         "SearchType"=> 0,
            //         "SearchID"=>1234567,
            //         "Picture"=>0,
            //     ]
            // ]);
           
            $userid=Auth()->user()->id;
            $mquuid = Str::uuid()->toString();
            $mqt=new mqttmessage;
            $mqtt = MQTT::connection();

            $msgs='{
                "operator": "RebootDevice",
                "messageId":"ID:RebootDevice-'.$mquuid.'",
                "info":
                {
                    "facesluiceId":"'.$deviceid.'",
                },
            }';     

            $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                if ($elapsedTime >= 2) {
                    $mqtts->interrupt();
                }
            });

            $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                $mqt->userid=$userid;
                $mqt->uuid=$mquuid;
                $mqt->message=$message;
                $mqt->save();
            }, 2);

            $mqtt->publish($topic,$msgs,2);
            
            $mqtt->loop(true);
            $mqttmsg = DB::table('mqttmessages')->where('userid',$userid)->where('uuid',$mquuid)->latest()->first();
            $res=$mqttmsg->message;
            $response=json_decode($res, true);
            return Response::json(['success' => $response]);
            $mqtt->disconnect();
        }
        catch(Exception $e)
        {
            return Response::json(['connerror' =>  $e->getMessage()]);
        }
    }

    public function showdeviceCon($id){
        $device_cnt = 0;
        $data = device::leftJoin('branches', 'devices.branches_id', '=', 'branches.id')
            ->where('devices.id', $id)
            ->get(['branches.BranchName','devices.*']);   

        $wellness_data = DB::select('SELECT COUNT(devices_id) AS device_cnt FROM appconsolidates WHERE appconsolidates.devices_id='.$id);   
        $employee_data = DB::select('SELECT COUNT(devices_id) AS device_cnt FROM employees WHERE employees.devices_id='.$id);   
        $device_cnt = ($wellness_data[0]->device_cnt ?? 0) + ($employee_data[0]->device_cnt ?? 0);
        
        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"device")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['devicelist' => $data,'device_cnt' => $device_cnt,'activitydata' => $activitydata]);       
    }

    public function deletedeviceCon(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->devicedelId;
        DB::beginTransaction();
        try{
            DB::table('devices')->where('id',$findid)->delete();
            $actions = "Delete";
            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "device",
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
