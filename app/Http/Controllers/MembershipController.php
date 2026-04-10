<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\groupmember;
use App\Models\paymentterm;
use App\Models\service;
use App\Models\servicedetail;
use App\Models\membership;
use App\Models\Country;
use App\Models\City;
use App\Models\Subcity;
use App\Models\companyinfo;
use App\Models\device;
use App\Models\mqttmessage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Storage;
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\Examples\Shared\SimpleLogger;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\MqttClient;
use Psr\Log\LogLevel;
use Image;

class MembershipController extends Controller
{
    //
    
    public function index(Request $request)
    {     
        $gender=null;
        $persontype=null;
        ini_set('max_execution_time', '300000000');
        ini_set("pcre.backtrack_limit", "500000000");
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

        // try{
        //     $mqtt = MQTT::connection();
        //     $mqt=new mqttmessage;

        //     $devicesdata=DB::select('SELECT * FROM devices WHERE devices.devicetype IN(1,2,3) AND devices.Status="Active"');
        //     foreach($devicesdata as $devdata){
        //         $mquuid = Str::uuid()->toString();
                        
        //         $topic="mqtt/face/".$devdata->DeviceId;
        //         $topicrec="mqtt/face/".$devdata->DeviceId."/Rec";

        //         $i=0;

        //         for($i=0;$i<2;$i++){

        //             $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
        //                 if ($elapsedTime >= 8) {
        //                     $mqtts->interrupt();
        //                 }
        //             });
        //             $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$mquuid,$mqt){
        //                 //dd($message);
        //                 $mqt->userid=1;
        //                 $mqt->uuid=$mquuid;
        //                 $mqt->message=$message;
        //                 $mqt->save();
        //             }, 2);

                   

        //             $msglog='{
        //                 "messageId":"MessageID-PushAck",
        //                 "operator": "PushAck",
        //                 "info":
        //                 {
        //                     "facesluiceId":"'.$devdata->DeviceId.'",
        //                     "PushAckType":2,
        //                     "SnapOrRecordID":0                
        //                 },
        //             }';
                    
        //             $mqtt->publish($topic,$msglog,2);
        //             $mqtt->loop(true);

        //              $mqttmsg = DB::table('mqttmessages')->where('uuid',$mquuid)->latest()->first();
        //             $res=$mqttmsg->message;
        //             $resl=json_decode($res, true);
                    
        //             $recid=$resl['info'];
                    
        //              $msgs='{
        //                 "messageId":"MessageID-PushAck",
        //                 "operator": "PushAck",
        //                 "info":
        //                 {
        //                     "facesluiceId":"'.$devdata->DeviceId.'",
        //                     "PushAckType":2,
        //                     "SnapOrRecordID":"'.$recid['RecordID'].'"                
        //                 },
        //             }';
                    
        //             $mqtt->publish($topic,$msgs,2);
        //             $mqtt->loop(true);

        //         }
        //     }
        // }
        // catch(Exception $e)
        // {
        //     return Response::json(['dberrors' =>  $e->getMessage()]);
        // }



        $country = Country::where("name","Ethiopia")->get(["name", "id"]);
        $countrynat = Country::get(["name", "id"]);
        $city = City::get(["city_name", "id"]);
        $subcity=Subcity::orderBy("subcity_name","ASC")->get(["city_id","subcity_name", "id"]);
        $devices = device::where("Status","Active")->where("devicetype",1)->get(["id", "DeviceName"]);
        $loyaltystatusfilter = DB::select('SELECT DISTINCT memberships.LoyalityStatus FROM memberships ORDER BY memberships.LoyalityStatus ASC');
        if($request->ajax()) {
            return view('registry.membership',['country'=>$country,'countrynat'=>$countrynat,'city'=>$city,'subcity'=>$subcity,'devices'=>$devices,'loyaltystatusfilter'=>$loyaltystatusfilter])->renderSections()['content'];
        }
        else{
            return view('registry.membership',['country'=>$country,'countrynat'=>$countrynat,'city'=>$city,'subcity'=>$subcity,'devices'=>$devices,'loyaltystatusfilter'=>$loyaltystatusfilter]);
        }
    }

    public function memberListCon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $memberlist=DB::select('SELECT *,CONCAT_WS(",   ",IFNULL(Mobile,""),IFNULL(Phone,"")) AS MobilePhone,loyaltystatuses.LoyalityStatus AS loyalty_status FROM memberships LEFT JOIN loyaltystatuses ON memberships.loyaltystatuses_id=loyaltystatuses.id ORDER BY memberships.id DESC');
        if(request()->ajax()) {
            return datatables()->of($memberlist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $membershipedit='';
                $membershipdelete='';
                if($user->can('Client-Edit')){
                    $membershipedit=' <a class="dropdown-item memberEdit" onclick="memberEdit('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open client update page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                }
                if($user->can('Client-Delete')){
                    $membershipdelete='<a class="dropdown-item memberDelete" onclick="memberDelete('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open client delete confirmation">
                            <i class="fa fa-trash"></i><span> Delete</span>  
                        </a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item memberInfo" onclick="memberInfo('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open client information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$membershipedit.'
                        '.$membershipdelete.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function store(Request $request){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $rprefix=$settings->MemberPrefix;
        $rnumber=$settings->MemberNumber;
        $rnumberPadding=sprintf("%06d", $rnumber);
        $memberids=$rprefix.$rnumberPadding;
        $defpic=$settings->defaultpic;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->memberId;
        $findid=$request->memberId;
        $capimg=$request->captureimages;
        $enrolldev=$request->EnrollDevice;
        $uuid = Str::uuid()->toString();
        $curdate=Carbon::today()->toDateString();
        $personuuids=$request->personuuid;
        $faceids=$request->faceidencoded;
        $name=null;
        $pathnameLicense=null;
        $pathIdentification=null;
        $pathnameIdentification=null;
        $pathIdentificationpic=null;
        $pathnameIdentificationpic=null;
        $pathLicense=null;
        $idName=null;
        $picidName=null;
        $memcnt=0;
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
        $now = Carbon::now();
        $meridiam = $now->format('A');
        $dayname = $now->format('l');
        $starttime=null;
        $endtime=null;
        $starttimefirsthalf=null;
        $endtimefirsthalf=null;
        $starttimesecondhalf=null;
        $endtimesecondhalf=null;
        $mquuid = Str::uuid()->toString();
        $currtime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');
        

        if($findid != null){
            $validator = Validator::make($request->all(), [
                'Name' => ['required',Rule::unique('memberships')->where(function ($query){
                    })->ignore($findid)
                ],
                'TinNumber' => ['nullable','regex:/^(\d{10}|\d{13})$/',Rule::unique('memberships')->where(function ($query){
                    })->ignore($findid)
                ],
                //'country' => 'required',
                //'city' => 'required',
                //'subcity' => 'required',
                //'Woreda'=>'required',
                'gender'=>'required',
                //'Dob'=>'required',
                'nationality'=>'required',
                'Occupation'=>'required',
                //'HealthStatus'=>'required',
                'Mobile' => ['regex:/^([0-9\s\-\+\(\)]*)$/','required','digits_between:10,12',Rule::unique('memberships')->where(function ($query){
                    })->ignore($findid)
                ],
                'Phone' => ['regex:/^([0-9\s\-\+\(\)]*)$/','nullable','digits_between:10,12',Rule::unique('memberships')->where(function ($query){
                    })->ignore($findid)
                ],
                'Email' => ['email','nullable',Rule::unique('memberships')->where(function ($query){
                    })->ignore($findid)
                ],
                'License'=> 'mimes:pdf,jpg,jpeg,png|nullable',
            ]);
            if ($validator->passes()) {
                DB::beginTransaction();
                try{
                    $mquuid = Str::uuid()->toString();
                    $mqt=new mqttmessage;
                    $mqtt = MQTT::connection();
                   
                    if ($request->file('Identification')) {
                        $file = $request->file('Identification');
                        $idName = time() . '.' . $request->file('Identification')->extension();
                        $pathIdentification = public_path() . '/storage/uploads/Identification';
                        $pathnameIdentification='/storage/uploads/Identification/'.$idName;
                        $file->move($pathIdentification, $idName);
                    }
                    if($request->file('Identification')==''){
                        $idName=$request->Identificationupdate;
                    }
                    
                    if ($request->file('Picture')) {
                        $file = $request->file('Picture');
                        $picidName = time() . '.' . $request->file('Picture')->extension();
                        $pathIdentificationpic = public_path() . '/storage/uploads/MemberPicture';
                        $pathnameIdentificationpic='/storage/uploads/MemberPicture/'.$picidName;
                        $file->move($pathIdentificationpic, $picidName);
                    }

                    if($capimg!=null){
                        $img = $request->captureimages;
                        
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];

                        $image_base64 = base64_decode($image_parts[1]);
                        $picidName = uniqid() . '.png';
                        $pathIdentificationpic = public_path() .'/storage/uploads/MemberPicture/'.$picidName;
                        $pathnameIdentificationpic='/storage/uploads/MemberPicture/'.$picidName;
                        file_put_contents($pathIdentificationpic,$image_base64);
                    }
                    if($faceids!=null){
                        $img = $faceids;
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
                        
                        $image_base64 = base64_decode($image_parts[1]);
                        
                        $picidName = uniqid() . '.jpg';
                        $pathIdentificationpic = public_path() .'/storage/uploads/MemberPicture/'.$picidName;
                        $pathnameIdentificationpic='/storage/uploads/MemberPicture/'.$picidName;
                        Image::make($image_base64)->resize(140, 140)->save($pathIdentificationpic);

                    }
                    if($request->file('Picture')=='' && $capimg==null && $faceids==null){
                        $picidName=$request->Pictureupdate;
                    }
                    $members=membership::updateOrCreate(['id'=>$request->memberId], [
                        'Name'=> ($request->Name),
                        'TinNumber'=> ($request->TinNumber),
                        'Country'=> ($request->country),
                        'Nationality'=> ($request->nationality),
                        'cities_id'=> ($request->city),
                        'subcities_id'=> ($request->subcity),
                        'Woreda'=> ($request->Woreda),
                        'Location'=> ($request->Location),
                        'Mobile'=> ($request->Mobile),
                        'Phone'=> ($request->Phone),
                        'Email'=> ($request->Email),
                        'ResidanceId'=> ($request->ResidenceId),
                        'PassportNo'=> ($request->PassportNumber),
                        'DOB'=> ($request->Dob),
                        'Occupation'=> ($request->Occupation),
                        'HealthStatus'=> ($request->HealthStatus),
                        'Memo'=> ($request->Memo),
                        'Gender'=> ($request->gender),
                        'devices_id'=> ($request->EnrollDevice),
                        'IdentificationId'=>$idName,
                        'Picture'=>$picidName,
                        'Status'=> ($request->Status),
                        'LastEditedBy' => $user,
                        'LastEditedDate' =>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                        'EmergencyName'=> ($request->contactName),
                        'EmergencyMobile'=> ($request->contactMobileNumber),
                        'EmergencyLocation'=> ($request->contactLocation),
                        'LeftThumb'=> $request->LeftThumbVal,
                        'LeftIndex'=> $request->LeftIndexVal,
                        'LeftMiddle'=> $request->LeftMiddelVal,
                        'LeftRing'=> $request->LeftRingVal,
                        'LeftPinky'=> $request->LeftPickyVal,
                        'RightThumb'=> $request->RightThumbVal,
                        'RightIndex'=> $request->RightIndexVal,
                        'RightMiddle'=> $request->RightMiddleVal,
                        'RightRing'=> $request->RightRingVal,
                        'RightPinky'=> $request->RightPickyVal,
                    ]);

                    if($request->LeftThumbVal==null || $request->LeftThumbVal==""){
                        $leftthumb="";
                    }
                    if($request->LeftThumbVal!=null && $request->LeftThumbVal!=""){
                        $leftthumb=$request->LeftThumbVal;
                    }

                    if($request->LeftIndexVal==null || $request->LeftIndexVal==""){
                        $leftindex="";
                    }
                    if($request->LeftIndexVal!=null && $request->LeftIndexVal!=""){
                        $leftindex=$request->LeftIndexVal;
                    }

                    if($request->LeftMiddelVal==null || $request->LeftMiddelVal==""){
                        $leftmiddle="";
                    }
                    if($request->LeftMiddelVal!=null && $request->LeftMiddelVal!=""){
                        $leftmiddle=$request->LeftMiddelVal;
                    }

                    if($request->LeftRingVal==null || $request->LeftRingVal==""){
                        $leftring="";
                    }
                    if($request->LeftRingVal!=null && $request->LeftRingVal!=""){
                        $leftring=$request->LeftRingVal;
                    }

                    if($request->LeftPickyVal==null || $request->LeftPickyVal==""){
                        $leftpicky="";
                    }
                    if($request->LeftPickyVal!=null && $request->LeftPickyVal!=""){
                        $leftpicky=$request->LeftPickyVal;
                    }

                    if($request->RightThumbVal==null || $request->RightThumbVal==""){
                        $rightthumb="";
                    }
                    if($request->RightThumbVal!=null && $request->RightThumbVal!=""){
                        $rightthumb=$request->RightThumbVal;
                    }

                    if($request->RightIndexVal==null || $request->RightIndexVal==""){
                        $rightindex="";
                    }
                    if($request->RightIndexVal!=null && $request->RightIndexVal!=""){
                        $rightindex=$request->RightIndexVal;
                    }

                    if($request->RightMiddleVal==null || $request->RightMiddleVal==""){
                        $rightmiddle="";
                    }
                    if($request->RightMiddleVal!=null && $request->RightMiddleVal!=""){
                        $rightmiddle=$request->RightMiddleVal;
                    }

                    if($request->RightRingVal==null || $request->RightRingVal==""){
                        $rightring="";
                    }
                    if($request->RightRingVal!=null && $request->RightRingVal!=""){
                        $rightring=$request->RightRingVal;
                    }

                    if($request->RightPickyVal==null || $request->RightPickyVal==""){
                        $rightpicky="";
                    }
                    if($request->RightPickyVal!=null && $request->RightPickyVal!=""){
                        $rightpicky=$request->RightPickyVal;
                    }


                    if($enrolldev>1){
                        
                        if($request->file('Picture')=='' && $capimg==null && $faceids==null){
                            if($picidName!=null){
                                $pathIdentificationpic = public_path().'/storage/uploads/MemberPicture/'.$picidName;
                                $imagepath = public_path().'/storage/uploads/MemberPicture/'.$picidName;
                                $picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                            }
                            if($picidName==null){
                                //$pathIdentificationpic = public_path().'/storage/uploads/MemberPicture/defaultfaceid.jpg';
                                $picdata=$defpic;
                            }
                        }
                        if($request->file('Picture')!='' || $capimg!=null || $faceids!=null){
                            $pathIdentificationpic = public_path().'/storage/uploads/MemberPicture/'.$picidName;
                            $imagepath = public_path().'/storage/uploads/MemberPicture/'.$picidName;
                            $picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                        }
                        
                        $fullip=null;
                        $memid=null;
                        $gender=null;
                        $persontype=null;

                        $memid=$request->memberId;
                     
                        $dev=device::findorFail($enrolldev);
                        $devid=$dev->DeviceId;
                        $devip=$dev->IpAddress;
                        $devport=$dev->Port;
                        $devuname=$dev->Username;
                        $devpass=$dev->Password;

                        if($request->gender=="Male"){
                            $gender=0;
                        }
                        if($request->gender=="Female"){
                            $gender=1;
                        }

                        if($request->Status=="Active"){
                            $persontype=0;
                        }
                        if($request->Status!="Active"){
                            $persontype=1;
                        }
                        $curdate=Carbon::today()->toDateString();

                        $topic="mqtt/face/".$dev->DeviceId;
                        $topicrec="mqtt/face/".$dev->DeviceId."/Ack";

                        $msgs='{
                            "operator": "EditPerson",
                            "messageId":"MessageID-EditPerson-'.$uuid.'",
                            "info":
                            {
                                "facesluiceId":"'.$dev->DeviceId.'",
                                "customId":"'.$memid.'",
                                "personType":"'.$persontype.'",
                                "name":"'.$request->Name.'",
                                "gender":"'.$gender.'",
                                "birthday":"'.$request->Dob.'",
                                "telnum1":"'.$request->Mobile." , ".$request->Phone.'",
                                "address":"'.$request->Location.'",
                                "PersonUUID":"'.$uuid.'",
                                "pic":"'.$picdata.'", 
                            },
                        }';

                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 4) {
                                $mqtts->interrupt();
                            }
                        });

                        $mqtt->publish($topic,$msgs,2);
                        $mqtt->loop(true);

                        $getmemberandDevice=DB::select('SELECT COUNT(DISTINCT appconsolidates.devices_id) AS MemberCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status IN("Pending","Verified") AND appconsolidates.memberships_id='.$findid);
                        foreach($getmemberandDevice as $row)
                        {
                            $memcnt=$row->MemberCount;
                        }
                        
                        if($memcnt>0)
                        {

                            $finddeviceinfo=DB::select('SELECT DISTINCT appconsolidates.devices_id,devices.*,@regdate:=applications.RegistrationDate AS RegistrationDate,periods.PeriodName,@enddate:=applications.ExpiryDate AS ExpiryDate,@status:=applications.Status AS Status,@firsthalffrom:=(SELECT perioddetails.FirstHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfFrom,@firsthalfto:=(SELECT perioddetails.FirstHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfTo,@secondhalffrom:=(SELECT perioddetails.SecondHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfFrom,@secondhalfto:=(SELECT perioddetails.SecondHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfTo FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN devices ON appconsolidates.devices_id=devices.id INNER JOIN periods ON appconsolidates.periods_id=periods.id WHERE applications.Status IN("Pending","Verified") AND appconsolidates.memberships_id='.$findid.' ORDER BY periods.id DESC');
                            foreach ($finddeviceinfo as $row) {
                                $topic="mqtt/face/".$row->DeviceId;
                                $topicrec="mqtt/face/".$row->DeviceId."/Ack";

                                //start assign variables each period values 
                                if($row->FirstHalfFrom==null || $row->FirstHalfFrom==""){
                                    $starttimefirsthalf="11:59:59";
                                }
                                if($row->FirstHalfFrom!=null && $row->FirstHalfFrom!=""){
                                    $starttimefirsthalf=$row->FirstHalfFrom.":00";
                                }

                                if($row->FirstHalfTo==null || $row->FirstHalfTo==""){
                                    $endtimefirsthalf="11:59:58";
                                }
                                if($row->FirstHalfTo!=null && $row->FirstHalfTo!=""){
                                    $endtimefirsthalf=$row->FirstHalfTo.":59";
                                }

                                if($row->SecondHalfFrom==null || $row->SecondHalfFrom==""){
                                    $starttimesecondhalf="23:59:59";
                                }
                                if($row->SecondHalfFrom!=null && $row->SecondHalfFrom!=""){
                                    $starttimesecondhalf=$row->SecondHalfFrom.":00";
                                }

                                if($row->SecondHalfTo==null || $row->SecondHalfTo==""){
                                    $endtimesecondhalf="23:59:59";
                                }
                                if($row->SecondHalfTo!=null && $row->SecondHalfTo!=""){
                                    $endtimesecondhalf=$row->SecondHalfTo.":59";
                                }                        
                                //end assign variables each period values 

                                if($currtime<11){
                                    if($endtimefirsthalf=="11:59:59" && $starttimesecondhalf=="12:00:00"){
                                        $endtime=$endtimesecondhalf;
                                    }
                                    if($endtimefirsthalf!="11:59:59" || $starttimesecondhalf!="12:00:00"){
                                        $endtime=$endtimefirsthalf;
                                    }

                                    if($row->FirstHalfFrom==null || $row->FirstHalfFrom==""){
                                        $starttime="11:59:59";
                                    }
                                    if($row->FirstHalfFrom!=null && $row->FirstHalfFrom!=""){
                                        $starttime=$row->FirstHalfFrom.":00";
                                    }

                                    // if($row->FirstHalfTo==null || $row->FirstHalfTo==""){
                                    //     $endtime="11:59:59";
                                    // }
                                    // if($row->FirstHalfTo!=null && $row->FirstHalfTo!=""){
                                    //     $endtime=$row->FirstHalfTo.":59";
                                    // }
                                }
                                if($currtime>=11){
                                    if($starttimefirsthalf!="11:59:59" && $starttimesecondhalf=="12:00:00"){
                                        $starttime=$starttimefirsthalf;
                                    }
                                    if($starttimefirsthalf=="11:59:59"){
                                        $starttime=$starttimesecondhalf;
                                    }

                                    // if($row->SecondHalfFrom==null || $row->SecondHalfFrom==""){
                                    //     $starttime="23:59:59";
                                    // }
                                    // if($row->SecondHalfFrom!=null && $row->SecondHalfFrom!=""){
                                    //     $starttime=$row->SecondHalfFrom.":00";
                                    // }

                                    if($row->SecondHalfTo==null || $row->SecondHalfTo==""){
                                        $endtime="23:59:59";
                                    }
                                    if($row->SecondHalfTo!=null && $row->SecondHalfTo!=""){
                                        $endtime=$row->SecondHalfTo.":59";
                                    }
                                }


                                if($row->Status=="Pending"){

                                    $msgs='{
                                        "operator": "EditPerson",
                                        "messageId":"MessageID-EditPerson-'.$uuid.'",
                                        "info":
                                        {
                                            "facesluiceId":"'.$row->DeviceId.'",
                                            "customId":"'.$memid.'",
                                            "tempCardType":2,
                                            "personType":"'.$persontype.'",
                                            "name":"'.$request->Name.'",
                                            "gender":"'.$gender.'",
                                            "birthday":"'.$request->Dob.'",
                                            "telnum1":"'.$request->Mobile." , ".$request->Phone.'",
                                            "address":"'.$request->Location.'",
                                            "PersonUUID":"'.$uuid.'",
                                            "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                            "cardValidEnd":"'.$row->RegistrationDate." ".$endtime.'",
                                            "pic":"'.$picdata.'",                                    
                                        },
                                    }';

                                    $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                        if ($elapsedTime >= 2) {
                                            $mqtts->interrupt();
                                        }
                                    });

                                    $mqtt->publish($topic,$msgs,2);
                                    $mqtt->loop(true);

                                    $fpmquuid = Str::uuid()->toString();
                                    $fpmsgs='{
                                        "operator": "SetFingerprints",
                                        "messageId":"MessageID-SetFingerprints-'.$mquuid.'",
                                        "info":
                                        {
                                            "facesluiceId":"'.$row->DeviceId.'",
                                            "IdType":2,
                                            "PersonUUID":"'.$memid.'",
                                            "LeftThumb": "'.$leftthumb.'",
                                            "LeftIndex": "'.$leftindex.'",
                                            "LeftMiddle": "'.$leftmiddle.'",
                                            "LeftRing": "'.$leftring.'",
                                            "LeftPinky": "'.$leftpicky.'",
                                            "RightThumb": "'.$rightthumb.'",
                                            "RightIndex": "'.$rightindex.'",
                                            "RightMiddle": "'.$rightmiddle.'",
                                            "RightRing": "'.$rightring.'",
                                            "RightPinky": "'.$rightpicky.'",
                                        },
                                    }';

                                    $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                        if ($elapsedTime >= 4) {
                                            $mqtts->interrupt();
                                        }
                                    });

                                    $mqtt->publish($topic,$fpmsgs,2);
                                    $mqtt->loop(true);

                                    $getexitdevice=DB::select('SELECT * FROM devices WHERE devices.Status="Active" AND devices.devicetype=3');
                                    foreach($getexitdevice as $devrow)
                                    {
                                        $topic="mqtt/face/".$devrow->DeviceId;
                                        $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                                        
                                        $msgs='{
                                            "operator": "EditPerson",
                                            "messageId":"MessageID-EditPerson-'.$mquuid.'",
                                            "info":
                                            {
                                                "facesluiceId":"'.$devrow->DeviceId.'",
                                                "customId":"'.$memid.'",
                                                "tempCardType":2,
                                                "personType":"'.$persontype.'",
                                                "name":"'.$request->Name.'",
                                                "gender":"'.$gender.'",
                                                "birthday":"'.$request->Dob.'",
                                                "telnum1":"'.$request->Mobile." , ".$request->Phone.'",
                                                "address":"'.$request->Location.'",
                                                "PersonUUID":"'.$uuid.'",
                                                "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                                "cardValidEnd":"'.$row->RegistrationDate." ".$endtime.'",
                                                "pic":"'.$picdata.'",                                      
                                            },
                                        }';

                                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                            if ($elapsedTime >= 4) {
                                                $mqtts->interrupt();
                                            }
                                        });

                                        $mqtt->publish($topic,$msgs,2);
                                        $mqtt->loop(true);

                                        $fpmquuid = Str::uuid()->toString();
                                        $fpmsgs='{
                                            "operator": "SetFingerprints",
                                            "messageId":"MessageID-SetFingerprints-'.$mquuid.'",
                                            "info":
                                            {
                                                "facesluiceId":"'.$row->DeviceId.'",
                                                "IdType":2,
                                                "PersonUUID":"'.$memid.'",
                                                "LeftThumb": "'.$leftthumb.'",
                                                "LeftIndex": "'.$leftindex.'",
                                                "LeftMiddle": "'.$leftmiddle.'",
                                                "LeftRing": "'.$leftring.'",
                                                "LeftPinky": "'.$leftpicky.'",
                                                "RightThumb": "'.$rightthumb.'",
                                                "RightIndex": "'.$rightindex.'",
                                                "RightMiddle": "'.$rightmiddle.'",
                                                "RightRing": "'.$rightring.'",
                                                "RightPinky": "'.$rightpicky.'",
                                            },
                                        }';

                                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                            if ($elapsedTime >= 4) {
                                                $mqtts->interrupt();
                                            }
                                        });
                                        $mqtt->publish($topic,$fpmsgs,2);
                                        $mqtt->loop(true);
                                    }
                                }
                                if($row->Status=="Verified"){
                                    $msgs='{
                                        "operator": "EditPerson",
                                        "messageId":"MessageID-EditPerson-'.$uuid.'",
                                        "info":
                                        {
                                            "facesluiceId":"'.$row->DeviceId.'",
                                            "customId":"'.$memid.'",
                                            "tempCardType":2,
                                            "personType":"'.$persontype.'",
                                            "name":"'.$request->Name.'",
                                            "gender":"'.$gender.'",
                                            "birthday":"'.$request->Dob.'",
                                            "telnum1":"'.$request->Mobile." , ".$request->Phone.'",
                                            "address":"'.$request->Location.'",
                                            "PersonUUID":"'.$uuid.'",
                                            "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                            "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                                            "pic":"'.$picdata.'",                                    
                                        },
                                    }';

                                    $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                        if ($elapsedTime >= 4) {
                                            $mqtts->interrupt();
                                        }
                                    });

                                    $mqtt->publish($topic,$msgs,2);
                                    $mqtt->loop(true);

                                    $fpmquuid = Str::uuid()->toString();
                                    $fpmsgs='{
                                        "operator": "SetFingerprints",
                                        "messageId":"MessageID-SetFingerprints-'.$mquuid.'",
                                        "info":
                                        {
                                            "facesluiceId":"'.$devid.'",
                                            "IdType":2,
                                            "PersonUUID":"'.$memid.'",
                                            "LeftThumb": "'.$leftthumb.'",
                                            "LeftIndex": "'.$leftindex.'",
                                            "LeftMiddle": "'.$leftmiddle.'",
                                            "LeftRing": "'.$leftring.'",
                                            "LeftPinky": "'.$leftpicky.'",
                                            "RightThumb": "'.$rightthumb.'",
                                            "RightIndex": "'.$rightindex.'",
                                            "RightMiddle": "'.$rightmiddle.'",
                                            "RightRing": "'.$rightring.'",
                                            "RightPinky": "'.$rightpicky.'",
                                        },
                                    }';

                                    $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                        if ($elapsedTime >= 4) {
                                            $mqtts->interrupt();
                                        }
                                    });

                                    $mqtt->publish($topic,$fpmsgs,2);
                                    $mqtt->loop(true);

                                    $getexitdevice=DB::select('SELECT * FROM devices WHERE devices.Status="Active" AND devices.devicetype=3');
                                    foreach($getexitdevice as $devrow)
                                    {
                                        $topic="mqtt/face/".$devrow->DeviceId;
                                        $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                                        
                                        $msgs='{
                                            "operator": "EditPerson",
                                            "messageId":"MessageID-EditPerson-'.$mquuid.'",
                                            "info":
                                            {
                                                "facesluiceId":"'.$devrow->DeviceId.'",
                                                "customId":"'.$memid.'",
                                                "tempCardType":2,
                                                "personType":"'.$persontype.'",
                                                "name":"'.$request->Name.'",
                                                "gender":"'.$gender.'",
                                                "birthday":"'.$request->Dob.'",
                                                "telnum1":"'.$request->Mobile." , ".$request->Phone.'",
                                                "address":"'.$request->Location.'",
                                                "PersonUUID":"'.$uuid.'",
                                                "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                                "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                                                "pic":"'.$picdata.'",                                      
                                            },
                                        }';

                                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                            if ($elapsedTime >= 4) {
                                                $mqtts->interrupt();
                                            }
                                        });

                                        $mqtt->publish($topic,$msgs,2);
                                        $mqtt->loop(true);

                                        $fpmquuid = Str::uuid()->toString();
                                        $fpmsgs='{
                                            "operator": "SetFingerprints",
                                            "messageId":"MessageID-SetFingerprints-'.$mquuid.'",
                                            "info":
                                            {
                                                "facesluiceId":"'.$row->DeviceId.'",
                                                "IdType":2,
                                                "PersonUUID":"'.$memid.'",
                                                "LeftThumb": "'.$leftthumb.'",
                                                "LeftIndex": "'.$leftindex.'",
                                                "LeftMiddle": "'.$leftmiddle.'",
                                                "LeftRing": "'.$leftring.'",
                                                "LeftPinky": "'.$leftpicky.'",
                                                "RightThumb": "'.$rightthumb.'",
                                                "RightIndex": "'.$rightindex.'",
                                                "RightMiddle": "'.$rightmiddle.'",
                                                "RightRing": "'.$rightring.'",
                                                "RightPinky": "'.$rightpicky.'",
                                            },
                                        }';

                                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                            if ($elapsedTime >= 4) {
                                                $mqtts->interrupt();
                                            }
                                        });
                                        $mqtt->publish($topic,$fpmsgs,2);
                                        $mqtt->loop(true);
                                    }
                                }
                            }
                        }
                        //$deviceprop=device::where('Status',"Active")->get();

                        //$mqtt->disconnect();
                    }

                    DB::commit();
                    return Response::json(['success' =>1]);
                    $mqtt->disconnect();
                }
                catch(Exception $e)
                {
                    DB::rollBack();
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            if ($validator->fails())
            {
                return Response::json(['errors'=> $validator->errors()]);
            }
        }
        
        if($findid == null){
            $validator = Validator::make($request->all(), [
                'Name' => ['required','unique:memberships'],
                'TinNumber' => ['nullable','regex:/^(\d{10}|\d{13})$/','unique:memberships'],
                //'country' => 'required',
                //'city' => 'required',
                'subcity' => 'required',
                //'Woreda'=>'required',
                'gender'=>'required',
                //'Dob'=>'required',
                'nationality'=>'required',
                'Occupation'=>'required',
                //'HealthStatus'=>'required',
                'Mobile' => ['regex:/^([0-9\s\-\+\(\)]*)$/','required','digits_between:10,12',Rule::unique('memberships')->where(function ($query){
                    })->ignore($findid)
                ],
                'Phone'=> 'required_without:Mobile|regex:/^([0-9\s\-\+\(\)]*)$/|nullable|digits_between:10,12|unique:memberships',
                'Email'=> 'email|nullable|unique:memberships',
                'Identification'=> 'mimes:pdf,jpg,jpeg,png|nullable',
                'Picture'=> 'mimes:jpg,jpeg,png|nullable',
            ]);
            if ($validator->passes()) {
                DB::beginTransaction();
                try
                {
                    $mquuid = Str::uuid()->toString();
                    $mqt = new mqttmessage;
                    $mqtt = MQTT::connection();

                    if ($request->file('Identification')) {
                        $file = $request->file('Identification');
                        $idName = time() . '.' . $request->file('Identification')->extension();
                        $pathIdentification = public_path() . '/storage/uploads/Identification';
                        $pathnameIdentification='/storage/uploads/Identification/'.$idName;
                        $file->move($pathIdentification, $idName);
                    }
                    if($request->file('Identification')==''){
                        $idName=$request->Identificationupdate;
                    }

                    if ($request->file('Picture')) {
                        $file = $request->file('Picture');
                        $picidName = time() . '.' . $request->file('Picture')->extension();
                        $pathIdentificationpic = public_path() . '/storage/uploads/MemberPicture';
                        $pathnameIdentificationpic='/storage/uploads/MemberPicture/'.$picidName;
                        $file->move($pathIdentificationpic, $picidName);
                    }

                    if($capimg!=null){
                        $img = $request->captureimages;
                       
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];

                        $image_base64 = base64_decode($image_parts[1]);
                        $picidName = uniqid() . '.jpeg';
                        $pathIdentificationpic = public_path() .'/storage/uploads/MemberPicture/'.$picidName;
                        $pathnameIdentificationpic='/storage/uploads/MemberPicture/'.$picidName;
                        file_put_contents($pathIdentificationpic,$image_base64);
                    }

                    if($request->file('Picture') == '' && $capimg == null){
                        $picidName = $request->Pictureupdate;
                    }

                    $members=membership::updateOrCreate(['id' =>$request->memberId], [
                        'MemberId' => $memberids,
                        'Name' => ($request->Name),
                        'TinNumber' => ($request->TinNumber),
                        'Country' => ($request->country),
                        'Nationality' => ($request->nationality),
                        'cities_id' => ($request->city),
                        'subcities_id' => ($request->subcity),
                        'Woreda' => ($request->Woreda),
                        'Location' => ($request->Location),
                        'Mobile' => ($request->Mobile),
                        'Phone' => ($request->Phone),
                        'Email' => ($request->Email),
                        'ResidanceId' => ($request->ResidenceId),
                        'PassportNo' => ($request->PassportNumber),
                        'DOB' => ($request->Dob),
                        'Occupation' => ($request->Occupation),
                        'HealthStatus' => ($request->HealthStatus),
                        'Memo' => ($request->Memo),
                        'Gender' => ($request->gender),
                        'devices_id' => ($request->EnrollDevice),
                        'PersonUUID' => $uuid,
                        'IdentificationId' => $idName,
                        'Picture' => $picidName,
                        'Status' => ($request->Status),
                        'LoyalityStatus'=> "Bronze",
                        'loyaltystatuses_id' => 1,
                        'CreatedBy' => $user,
                        'CreatedDate' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                        'EmergencyName' => ($request->contactName),
                        'EmergencyMobile' => ($request->contactMobileNumber),
                        'EmergencyLocation' => ($request->contactLocation),
                        'LeftThumb' => $request->LeftThumbVal,
                        'LeftIndex' => $request->LeftIndexVal,
                        'LeftMiddle' => $request->LeftMiddelVal,
                        'LeftRing' => $request->LeftRingVal,
                        'LeftPinky' => $request->LeftPickyVal,
                        'RightThumb' => $request->RightThumbVal,
                        'RightIndex' => $request->RightIndexVal,
                        'RightMiddle' => $request->RightMiddleVal,
                        'RightRing' => $request->RightRingVal,
                        'RightPinky' => $request->RightRingVal,
                    ]);

                    if($enrolldev > 1){
                        if($request->file('Picture') == '' && $capimg == null){
                            $picdata = $defpic;
                        }
                        if($request->file('Picture') !='' || $capimg != null){
                            $imagepath = public_path().'/storage/uploads/MemberPicture/'.$picidName;
                            $picdata = "data:image/jpeg;base64,".base64_encode(file_get_contents($imagepath));
                        }
                        $fullip = null;
                        $memid = null;
                        $gender = null;
                        $persontype = null;
                        $mem = membership::where('MemberId','=',$memberids)->firstOrFail();
                        $memid = $mem->id;
                        $dev = device::findorFail($enrolldev);
                        $devid = $dev->DeviceId;
                        $devip = $dev->IpAddress;
                        $devport = $dev->Port;
                        $devuname = $dev->Username;
                        $devpass = $dev->Password;
                        $topic = "mqtt/face/".$devid;
                        $topicrec = "mqtt/face/".$devid."/Ack";

                        if($request->gender=="Male"){
                            $gender=0;
                        }
                        if($request->gender=="Female"){
                            $gender=1;
                        }
                        
                        if($request->Status=="Active"){
                            $persontype=0;
                        }
                        if($request->Status!="Active"){
                            $persontype=1;
                        }

                        $msgs='{
                            "operator": "AddPerson",
                            "messageId":"MessageID-AddPerson-'.$uuid.'",
                            "info":
                            {
                                "facesluiceId":"'.$devid.'",
                                "PersonType":"'.$persontype.'",
                                "name":"'.$request->Name.'",
                                "gender":"'.$gender.'",
                                "birthday":"'.$request->Dob.'",
                                "telnum1":"'.$request->Mobile." , ".$request->Phone.'",
                                "address":"'.$request->Location.'",
                                "customId":"'.$memid.'",
                                "PersonUUID":"'.$uuid.'",
                                "pic":"'.$picdata.'",
                            },
                        }';

                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 4) {
                                $mqtts->interrupt();
                            }
                        });
                        $mqtt->publish($topic,$msgs,2);
                
                        $mqtt->loop(true);
                        $mqtt->disconnect();
                        
                    }
                    $updn=DB::select('UPDATE settings SET MemberNumber=MemberNumber+1 WHERE id=1');
                    
                    DB::commit();
                    return Response::json(['success' =>1]);
                }
                catch(Exception $e)
                {
                    DB::rollBack();
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            if ($validator->fails())
            {
                return Response::json(['errors'=> $validator->errors()]);
            }
        }
    }

    public function getFaceid(Request $request)
    {
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $memid=$request->memberId;
        $deviceid=$request->EnrollDevice;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $dev=device::findorFail($deviceid);
        $devid=$dev->DeviceId;
        $devip=$dev->IpAddress;
        $devport=$dev->Port;
        $devuname=$dev->Username;
        $devpass=$dev->Password;
        $topic="mqtt/face/".$devid;
        $topicrec="mqtt/face/".$devid."/Ack";
        $picchange=0;
       
        $validator = Validator::make($request->all(), [
            'EnrollDevice'=>'required',
        ]);

        if ($validator->passes()) {
            try{
                $mquuid = Str::uuid()->toString();
                $mqt = new mqttmessage;
                $mqtt = MQTT::connection();

                $msgs='{
                    "operator": "SearchPerson",
                    "messageId":"MessageID-SearchPerson-'.$mquuid.'",
                    "info":
                    {
                        "facesluiceId":"'.$devid.'",
                        "SearchType":0,
                        "customId":"'.$memid.'",
                        "Picture":1,
                    },
                }';

                $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                    if ($elapsedTime >= 5) {
                        $mqtts->interrupt();
                    }
                });

                $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                    $mqt->userid=$userid;
                    $mqt->uuid=$mquuid;
                    $mqt->message=$message;
                    $mqt->save();
                }, 1);

                $mqtt->publish($topic,$msgs,1); 
                $mqtt->loop(true);
                $mqttmsg = DB::table('mqttmessages')->where('userid',$userid)->where('uuid',$mquuid)->latest()->first();
                $res=$mqttmsg->message;
                $resl=json_decode($res, true);
                $pict=$resl['pic'];
                $piclen = strlen($pict);
                $defpiclen = strlen($defpic);

                if($pict===$defpic){
                    $picchange=0;
                }
                if($pict!==$defpic){
                    $picchange=1;
                }
                
                return Response::json(['success' => $resl,'picflag'=>$picchange,'pic'=>$piclen,'dpic'=>$defpiclen]);
                $mqtt->disconnect();

            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function getFingerprint(Request $request)
    {  
        $settings = DB::table('settings')->latest()->first();
        $memid=$request->memberId;
        $deviceid=$request->EnrollDevice;
        $peruuid=$request->personuuid;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $dev=device::findorFail($deviceid);
        $devid=$dev->DeviceId;
        $devip=$dev->IpAddress;
        $devport=$dev->Port;
        $devuname=$dev->Username;
        $devpass=$dev->Password;
        $topic="mqtt/face/".$devid;
        $topicrec="mqtt/face/".$devid."/Ack";
       
        $validator = Validator::make($request->all(), [
            'EnrollDevice'=>'required',
        ]);

        if ($validator->passes()) {
            try{
                $mquuid = Str::uuid()->toString();
                $mqt=new mqttmessage;
                $mqtt = MQTT::connection();
                
                $msgsbio='{
                    "operator": "GetFingerprints",
                    "messageId":"MessageID-GetFingerprints-'.$mquuid.'",
                    "info":
                    {
                        "facesluiceId":"'.$devid.'",
                        "IdType":2,
                        "PersonUUID":"'.$memid.'",
                    },
                }';

                $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                    if ($elapsedTime >= 5) {
                        $mqtts->interrupt();
                    }
                });

                $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                    $mqt->userid=$userid;
                    $mqt->uuid=$mquuid;
                    $mqt->message=$message;
                    $mqt->save();
                }, 2);

                $mqtt->publish($topic,$msgsbio,2);
                $mqtt->loop(true);
                $mqttmsg = DB::table('mqttmessages')->where('userid',$userid)->where('uuid',$mquuid)->latest()->first();
                $res=$mqttmsg->message;
                $resl =json_decode(Str::replace(',}}', '}}',$res),true);
                return Response::json(['success' =>  $resl]);
                $mqtt->disconnect();

            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function deleteMem(Request $request){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->memberDelId;
        $findid=$request->memberDelId;
        membership::where('id',$request->memberDelId)->delete();
        return Response::json(['success' =>1]);
    }

    public function showmemberCon($id){
        $membercountval=0;
        $membercountconfval=0;
        $picidName=null;
        $picdata =null;
        $memberprop=membership::findorFail($id);
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $memberprop->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $data = membership::join('cities', 'memberships.cities_id', '=', 'cities.id')
        ->join('subcities', 'memberships.subcities_id', '=', 'subcities.id')
        ->join('devices', 'memberships.devices_id', '=', 'devices.id')
        ->where('memberships.id',$id)
        ->get(['memberships.*','subcities.subcity_name','cities.city_name','devices.DeviceName',DB::raw('IFNULL(memberships.Phone,"") AS PhoneNo'),DB::raw('IFNULL(memberships.Mobile,"") AS MobileNo'),DB::raw("'$datetime' AS CreatedTime")]);
        foreach($data as $row){
            $picidName=$row->Picture;
        }

        $checkmembercnt=DB::select('SELECT COUNT(appconsolidates.memberships_id) AS MemberCount FROM appconsolidates WHERE appconsolidates.memberships_id='.$id);   
        foreach($checkmembercnt as $row){
            $membercountval=$row->MemberCount;
        } 
        $checkmemberconfcnt=DB::select('SELECT COUNT(appconsolidates.memberships_id) AS MemberCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status="Verified" AND appconsolidates.memberships_id='.$id);   
        foreach($checkmemberconfcnt as $conrow){
            $membercountconfval=$conrow->MemberCount;
        }

        if($picidName!=null){
            $imagepath = public_path().'/storage/uploads/MemberPicture/'.$picidName;
            $picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
        }
        

        return response()->json(['memlist'=>$data,'membercount'=>$membercountval,'membercountcon'=>$membercountconfval,'picdata'=>$picdata]);
    }

    public function download($ids,$file_name) 
    {
        $file_path = public_path('storage/uploads/Identification/'.$file_name);
        return response()->download($file_path);
    }
}
