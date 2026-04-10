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
use App\Models\employe;
use App\Models\Country;
use App\Models\City;
use App\Models\Subcity;
use App\Models\department;
use App\Models\employeedetail;
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

class EmployeController extends Controller
{
    public function index(Request $request)
    {
        $currentdate = Carbon::today()->toDateString();
        $country = Country::where("name","Ethiopia")->get(["name", "id"]);
        $countrynat = Country::get(["name", "id"]);
        $city = City::get(["city_name", "id"]);
        $subcity=Subcity::orderBy("subcity_name","ASC")->get(["city_id","subcity_name", "id"]);
        $departments = department::orderBy("DepartmentName","ASC")->where("Status","Active")->get(["DepartmentName", "id"]);
        $devices = device::where("Status","Active")->whereIn("devicetype",[1])->get(["id", "DeviceName"]);
        $services = service::orderBy("ServiceName","ASC")->where("Status","Active")->get(["ServiceName", "id"]);
        if($request->ajax()) {
            return view('registry.employe',['country'=>$country,'countrynat'=>$countrynat,'city'=>$city,'subcity'=>$subcity,'department'=>$departments,'service'=>$services,'currentdate'=>$currentdate,'devices'=>$devices])->renderSections()['content'];
        }
        else{
            return view('registry.employe',['country'=>$country,'countrynat'=>$countrynat,'city'=>$city,'subcity'=>$subcity,'department'=>$departments,'service'=>$services,'currentdate'=>$currentdate,'devices'=>$devices]);
        }
    }

    public function employeeListCon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $memberlist=DB::select('SELECT *,CONCAT(IFNULL(Mobile,"")," ,  ",IFNULL(Phone,"")) AS MobilePhone,employes.Status AS EmployeeStatus,departments.DepartmentName,employes.id AS eid FROM employes INNER JOIN departments ON employes.departments_id=departments.id ORDER BY employes.id DESC');
        if(request()->ajax()) {
            return datatables()->of($memberlist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $employeedit='';
                $employedelete='';
                if($user->can('Trainer-Edit')){
                    $employeedit=' <a class="dropdown-item employeeEdit" onclick="employeeEdit('.$data->eid.')" data-id="'.$data->eid.'" id="dteditbtn" title="Open employee update page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                }
                if($user->can('Trainer-Delete')){
                    $employedelete='<a class="dropdown-item employeeDelete" onclick="employeeDelete('.$data->eid.')" data-id="'.$data->eid.'" id="dtdeletebtn" title="Open employee delete confirmation">
                            <i class="fa fa-trash"></i><span> Delete</span>  
                        </a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item employeeInfo" onclick="employeeInfo('.$data->eid.')" data-id="'.$data->eid.'" id="dtinfobtn" title="Open employee information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$employeedit.'
                        '.$employedelete.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function store(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $rprefix=$settings->EmployeePrefix;
        $rnumber=$settings->EmployeeNumber;
        $defpic=$settings->defaultpic;
        $rnumberPadding=sprintf("%06d", $rnumber);
        $employeeid=$rprefix.$rnumberPadding;
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

        if($findid!=null){
            
            $validator = Validator::make($request->all(), [
                'Name' => ['required',Rule::unique('employes')->where(function ($query){
                    })->ignore($findid)
                ],
                'TinNumber' => ['nullable','regex:/^(\d{10}|\d{13})$/',Rule::unique('employes')->where(function ($query){
                    })->ignore($findid)
                ],
                'type' => 'required',
                'country' => 'required',
                'city' => 'required',
                'subcity' => 'required',
                'Woreda'=>'required',
                'gender'=>'required',
                'Dob'=>'required|before:-15 years',
                'nationality'=>'required',
                'skill'=>'required_if:type,3',
                'Mobile' => ['regex:/^([0-9\s\-\+\(\)]*)$/','digits_between:10,12','nullable',Rule::unique('employes')->where(function ($query){
                    })->ignore($findid)
                ],
                'Phone' => ['regex:/^([0-9\s\-\+\(\)]*)$/','digits_between:10,12','nullable',Rule::unique('employes')->where(function ($query){
                    })->ignore($findid)
                ],
                'Email' => ['email','nullable',Rule::unique('employes')->where(function ($query){
                    })->ignore($findid)
                ],
                'License'=> 'mimes:pdf,jpg,jpeg,png|nullable',
            ]);
            if ($validator->passes()) {
                try{
                    $mquuid = Str::uuid()->toString();
                    $mqt=new mqttmessage;
                    $mqtt = MQTT::connection();

                    if ($request->file('Identification')) {
                        $file = $request->file('Identification');
                        $idName = time() . '.' . $request->file('Identification')->extension();
                        $pathIdentification = public_path() . '/storage/uploads/EmployeeIdentification';
                        $pathnameIdentification='/storage/uploads/EmployeeIdentification/'.$idName;
                        $file->move($pathIdentification, $idName);
                    }
                    if($request->file('Identification')==''){
                        $idName=$request->Identificationupdate;
                    }
                    
                    if ($request->file('Picture')) {
                        $file = $request->file('Picture');
                        $picidName = time() . '.' . $request->file('Picture')->extension();
                        $pathIdentificationpic = public_path() . '/storage/uploads/EmployeePicture';
                        $pathnameIdentificationpic='/storage/uploads/EmployeePicture/'.$picidName;
                        $file->move($pathIdentificationpic, $picidName);
                    }

                    if($capimg!=null){
                        $img = $request->captureimages;
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];

                        $image_base64 = base64_decode($image_parts[1]);
                        $picidName = uniqid() . '.jpeg';
                        $pathIdentificationpic = public_path() .'/storage/uploads/EmployeePicture/'.$picidName;
                        $pathnameIdentificationpic='/storage/uploads/EmployeePicture/'.$picidName;
                        file_put_contents($pathIdentificationpic,$image_base64);
                    }
                    if($faceids!=null){
                        $img = $faceids;
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
                        
                        $image_base64 = base64_decode($image_parts[1]);
                        
                        $picidName = uniqid() . '.jpg';
                        $pathIdentificationpic = public_path() .'/storage/uploads/EmployeePicture/'.$picidName;
                        $pathnameIdentificationpic='/storage/uploads/EmployeePicture/'.$picidName;
                        Image::make($image_base64)->resize(140, 140)->save($pathIdentificationpic);
                       // file_put_contents($pathIdentificationpic,$image_base64);
                    }
                    if($request->file('Picture')=='' && $capimg==null && $faceids==null){
                        $picidName=$request->Pictureupdate;
                    }
                    $empl=employe::updateOrCreate(['id' =>$request->memberId], [
                        'Name'=> ($request->Name),
                        'departments_id'=> ($request->type),
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

                    if($request->type==3){
                        $empl->empdet()->detach();
                        foreach ($request->skill as $skillset)
                        {
                            $skills=$skillset;
                            $empl->empdet()->attach($skills);
                        }
                    }

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
                                $pathIdentificationpic = public_path().'/storage/uploads/EmployeePicture/'.$picidName;
                                $imagepath = public_path().'/storage/uploads/EmployeePicture/'.$picidName;
                                $picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                            }
                            if($picidName==null){
                                //$pathIdentificationpic = public_path().'/storage/uploads/MemberPicture/defaultfaceid.jpg';
                                $picdata=$defpic;
                            }
                        }
                        if($request->file('Picture')!='' || $capimg!=null || $faceids!=null){
                            $pathIdentificationpic = public_path().'/storage/uploads/EmployeePicture/'.$picidName;
                            $imagepath = public_path().'/storage/uploads/EmployeePicture/'.$picidName;
                            $picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                        }

                        $fullip=null;
                        $memid=null;
                        $gender=null;
                        $persontype=null;

                        $memid="E".$request->memberId;
                     
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
                                "PersonUUID":"'.$personuuids.'",
                                "pic":"'.$picdata.'", 
                            },
                        }';

                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 8) {
                                $mqtts->interrupt();
                            }
                        });

                        $mqtt->publish($topic,$msgs,2);
                        $mqtt->loop(true);

                        $getexitdevice=DB::select('SELECT * FROM devices WHERE devices.Status="Active" AND devices.devicetype IN(2,3)');
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
                                    "personType":"'.$persontype.'",
                                    "name":"'.$request->Name.'",
                                    "gender":"'.$gender.'",
                                    "birthday":"'.$request->Dob.'",
                                    "telnum1":"'.$request->Mobile." , ".$request->Phone.'",
                                    "address":"'.$request->Location.'",
                                    "PersonUUID":"'.$personuuids.'",
                                    "pic":"'.$picdata.'",                                      
                                },
                            }';
                            $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                if ($elapsedTime >= 8) {
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
                                    "facesluiceId":"'.$devrow->DeviceId.'",
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
                                if ($elapsedTime >= 8) {
                                    $mqtts->interrupt();
                                }
                            });
                            
                            $mqtt->publish($topic,$fpmsgs,2);
                            $mqtt->loop(true);
                        }
                    }
                    $mqtt->disconnect();
                    return Response::json(['success' =>1]);
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
        
        if($findid==null){
            $validator = Validator::make($request->all(), [
                'Name' => ['required','unique:employes'],
                'TinNumber' => ['nullable','regex:/^(\d{10}|\d{13})$/','unique:employes'],
                'country' => 'required',
                'type' => 'required',
                'city' => 'required',
                'subcity' => 'required',
                'Woreda'=>'required',
                'gender'=>'required',
                'Dob'=>'required|before:-15 years',
                'nationality'=>'required',
                'skill'=>'required_if:type,3',
                'Mobile'=> 'regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:10,12|nullable|unique:employes',
                'Phone'=> 'required_without:Mobile|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:10,12|nullable|unique:employes',
                'Email'=> 'email|nullable|unique:employes',
                'Identification'=> 'mimes:pdf,jpg,jpeg,png|nullable',
                'Picture'=> 'mimes:jpg,jpeg,png|nullable',
            ]);
            if ($validator->passes()) {
                try
                {
                    $mquuid = Str::uuid()->toString();
                    $mqt=new mqttmessage;
                    $mqtt = MQTT::connection();

                    if ($request->file('Identification')) {
                        $file = $request->file('Identification');
                        $idName = time() . '.' . $request->file('Identification')->extension();
                        $pathIdentification = public_path() . '/storage/uploads/EmployeeIdentification';
                        $pathnameIdentification='/storage/uploads/EmployeeIdentification/'.$idName;
                        $file->move($pathIdentification, $idName);
                    }
                    if($request->file('Identification')==''){
                        $idName=$request->Identificationupdate;
                    }

                    if ($request->file('Picture')) {
                        $file = $request->file('Picture');
                        $picidName = time() . '.' . $request->file('Picture')->extension();
                        $pathIdentificationpic = public_path() . '/storage/uploads/EmployeePicture';
                        $pathnameIdentificationpic='/storage/uploads/EmployeePicture/'.$picidName;
                        $file->move($pathIdentificationpic, $picidName);
                    }

                    if($capimg!=null){
                        $img = $request->captureimages;
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];

                        $image_base64 = base64_decode($image_parts[1]);
                        $picidName = uniqid() . '.jpeg';
                        $pathIdentificationpic = public_path() .'/storage/uploads/EmployeePicture/'.$picidName;
                        $pathnameIdentificationpic='/storage/uploads/EmployeePicture/'.$picidName;
                        file_put_contents($pathIdentificationpic,$image_base64);
                    }

                    if($request->file('Picture')=='' && $capimg==null){
                        $picidName=$request->Pictureupdate;
                    }
                   
                    $empl=employe::updateOrCreate(['id' =>$request->memberId], [
                        'EmployeeId' => $employeeid,
                        'departments_id'=> $request->type,
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
                        'CreatedBy' => $user,
                        'CreatedDate' =>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
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
                        'RightPinky'=> $request->RightRingVal,
                    ]);

                    if($request->type==3){
                        foreach ($request->skill as $skillset)
                        {
                            $skills=$skillset;
                            $empl->empdet()->attach($skills);
                        }
                    }

                    if($enrolldev>1){
                        if($request->file('Picture')=='' && $capimg==null){
                            $picdata=$defpic;
                        }
                        if($request->file('Picture')!='' || $capimg!=null){
                            $imagepath = public_path().'/storage/uploads/MemberPicture/'.$picidName;
                            $picdata = "data:image/jpeg;base64,".base64_encode(file_get_contents($imagepath));
                        }
                        $fullip=null;
                        $memid=null;
                        $gender=null;
                        $persontype=null;

                        $mem=employe::where('EmployeeId','=',$employeeid)->firstOrFail();
                        $memid="E".$mem->id;
                        $dev=device::findorFail($enrolldev);
                        $devid=$dev->DeviceId;
                        $devip=$dev->IpAddress;
                        $devport=$dev->Port;
                        $devuname=$dev->Username;
                        $devpass=$dev->Password;
                        $topic="mqtt/face/".$devid;
                        $topicrec="mqtt/face/".$devid."/Ack";

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
                            if ($elapsedTime >= 8) {
                                $mqtts->interrupt();
                            }
                        });

                        $mqtt->publish($topic,$msgs,2);
                        $mqtt->loop(true);
                    }
                    $mqtt->disconnect();
                    $updn=DB::select('UPDATE settings SET EmployeeNumber=EmployeeNumber+1 WHERE id=1');
                    return Response::json(['success' =>1]);
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
    }

    public function getEmpFaceid(Request $request)
    {
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $memid="E".$request->memberId;
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
                $mqt=new mqttmessage;
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
                    if ($elapsedTime >= 30) {
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

    public function getEmpFingerprint(Request $request)
    {
       
        $settings = DB::table('settings')->latest()->first();
        $memid="E".$request->memberId;
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
                    if ($elapsedTime >= 8) {
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

    public function deleteEmp(Request $request){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->memberDelId;
        $findid=$request->memberDelId;
        employeedetail::where('employes_id',$request->memberDelId)->delete();
        employe::where('id',$request->memberDelId)->delete();
        return Response::json(['success' =>1]);
    }

    public function showempCon($id){
        $employeecnt=0;
        $employeecntconf=0;
        $emprop=employe::findorFail($id);
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $emprop->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $data = employe::join('cities', 'employes.cities_id', '=', 'cities.id')
        ->join('subcities', 'employes.subcities_id', '=', 'subcities.id')
        ->join('departments', 'employes.departments_id', '=', 'departments.id')
        ->join('devices', 'employes.devices_id', '=', 'devices.id')
        ->where('employes.id',$id)
        ->get(['employes.*','subcities.subcity_name','cities.city_name','departments.DepartmentName','devices.DeviceName',DB::raw('IFNULL(employes.Phone,"") AS PhoneNo'),DB::raw('IFNULL(employes.Mobile,"") AS MobileNo'),
        DB::raw("'$datetime' AS CreatedTime")]);

        $empdetail=employeedetail::join('services','employeedetails.services_id','=','services.id')
        ->where('employeedetails.employes_id',$id)
        ->get(['employeedetails.*','services.ServiceName']);

        $checkemployeecnt=DB::select('SELECT COUNT(apptrainers.employes_id) AS EmployeeCount FROM apptrainers WHERE apptrainers.employes_id='.$id);   
        foreach($checkemployeecnt as $row){
            $employeecnt=$row->EmployeeCount;
        }
        
        $checkemployeecntconf=DB::select('SELECT COUNT(apptrainers.employes_id) AS EmployeeCount FROM apptrainers INNER JOIN applications ON apptrainers.applications_id=applications.id WHERE applications.Status="Verified" AND apptrainers.employes_id='.$id);   
        foreach($checkemployeecntconf as $row){
            $employeecntconf=$row->EmployeeCount;
        } 

        return response()->json(['memlist'=>$data,'employeedt'=>$empdetail,'employeecnt'=>$employeecnt,'employeecntcon'=>$employeecntconf]);
    }

    public function downloademp($ids,$file_name) 
    {
        $file_path = public_path('storage/uploads/EmployeeIdentification/'.$file_name);
        return response()->download($file_path);
    }

}
