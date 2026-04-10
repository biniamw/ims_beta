<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Mail\NotifyVerification;
use App\Jobs\SendEmail;
use App\Models\Category;
use App\Models\groupmember;
use App\Models\paymentterm;
use App\Models\period;
use App\Models\service;
use App\Models\servicedetail;
use App\Models\membership;
use App\Models\ApplicationForm;
use App\Models\appmember;
use App\Models\appservice;
use App\Models\appconsolidate;
use App\Models\apptrainers;
use App\Models\store;
use App\Models\storemrc;
use App\Models\device;
use App\Models\mqttmessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Mail;
use Queue;
use Illuminate\Support\Facades\Http;
//use Salman\Mqtt\MqttClass\Mqtt;
use Illuminate\Support\Str;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\Examples\Shared\SimpleLogger;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\MqttClient;
use Psr\Log\LogLevel;
use Image;

class ApplicationFormController extends Controller
{
    //
    public function index(Request $request){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $curdate=Carbon::today()->toDateString();
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        //DB::table('applications')->where('ExpiryDate','<=',$curdate)->update(['Status'=>"Expired"]);
        //DB::table('appconsolidates')->where('ExpiryDate','<=',$curdate)->update(['Status'=>"Expired"]);
        $groupmem = groupmember::where("Status","Active")->orderBy("GroupName","ASC")->get();
        $paymenttr = paymentterm::where("Status","Active")->orderBy("PaymentTermName","ASC")->get();
        //$periodpr = period::where("Status","Active")->orderBy("PeriodName","ASC")->get();
        //$servicepr = service::where("Status","Active")->orderBy("ServiceName","ASC")->get();
        $servicepr=DB::select('SELECT DISTINCT services.ServiceName,services.id,servicedetails.groupmembers_id,servicedetails.paymentterms_id FROM servicedetails INNER JOIN services ON servicedetails.services_id=services.id WHERE services.Status="Active" ORDER BY services.ServiceName ASC');
        $periodpr=DB::select('SELECT periods.PeriodName,periods.id,servicedetails.groupmembers_id,servicedetails.paymentterms_id,servicedetails.services_id FROM servicedetails INNER JOIN periods ON servicedetails.periods_id=periods.id WHERE periods.Status="Active" ORDER BY periods.PeriodName ASC');
        $servicedetpr = servicedetail::where("Status","Active")->get();
        $membershipval = membership::where("Status","Active")->orderBy('Name', 'ASC')->get();
        $deviceval = device::where("Status","Active")->where("id",">",1)->where("devicetype",2)->get();
        //$shop = store::where("ActiveStatus","Active")->where("type","Shop")->get();
        $shop=DB::select('SELECT StoreId AS id,stores.Name FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=17 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        $mrclist = storemrc::where("Status","Active")->get();
        $appidsrc = DB::select('SELECT applications.id,CONCAT(IFNULL(applications.VoucherNumber,""),"    ,   ",IFNULL(applications.InvoiceNumber,"")) AS FSNum,(SELECT GROUP_CONCAT(DISTINCT IFNULL(memberships.Name,""),"  ",IFNULL(memberships.Mobile,""),"	",IFNULL(memberships.Phone,"")) FROM memberships WHERE memberships.id IN(SELECT appconsolidates.memberships_id FROM appconsolidates WHERE appconsolidates.applications_id=applications.id)) AS MemberInfo, (SELECT GROUP_CONCAT(DISTINCT (services.ServiceName)) FROM services WHERE services.id IN(SELECT appconsolidates.services_id FROM appconsolidates WHERE appconsolidates.applications_id=applications.id)) AS ServiceInfo FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status IN("Pending","Verified","Frozen","Expired") AND applications.ApplicationType!="Trainer-Fee" AND applications.paymentterms_id!=5 GROUP BY applications.id ORDER BY applications.id DESC');
        $membershipinfos = DB::select('SELECT DISTINCT appconsolidates.applications_id,appconsolidates.memberships_id,CONCAT(IFNULL(memberships.Name,""),", ",IFNULL(memberships.Mobile,""),", ",IFNULL(memberships.Phone,"")) AS MemberInfo FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE appconsolidates.Status IN("Pending","Active","To-Be-Active") ORDER BY memberships.Name ASC');
        $serviceinfos = DB::select('SELECT appconsolidates.id AS AppConsId,appconsolidates.applications_id,appconsolidates.memberships_id,appconsolidates.services_id,services.ServiceName FROM appconsolidates INNER JOIN services ON appconsolidates.services_id=services.id WHERE services.Status="Active" AND appconsolidates.Status IN("Pending","Active","To-Be-Active") ORDER BY services.ServiceName ASC');
        $trainerinfos = DB::select('SELECT employeedetails.services_id,employeedetails.employes_id,employes.Name AS TrainerName FROM employeedetails INNER JOIN employes ON employeedetails.employes_id=employes.id WHERE employes.Status="Active" ORDER BY employes.Name ASC');
        $fiscalyears = DB::select('SELECT * FROM fiscalyear WHERE fiscalyear.FiscalYear BETWEEN "2022" AND '.$fyear.' ORDER BY fiscalyear.FiscalYear DESC');
        $servicestatus = DB::select('SELECT DISTINCT appconsolidates.Status FROM appconsolidates ORDER BY appconsolidates.Status ASC');
        if($request->ajax()) {
            return view('gym.application',['groupmem'=>$groupmem,'paymenttr'=>$paymenttr,'periodpr'=>$periodpr,'servicepr'=>$servicepr,'servicedetpr'=>$servicedetpr,'membershipval'=>$membershipval,'shop'=>$shop,'mrclist'=>$mrclist,
            'appidsrc'=>$appidsrc,'user'=> $user,'membershipinfos'=>$membershipinfos,'serviceinfos'=>$serviceinfos,'trainerinfos'=>$trainerinfos,'cdate'=>$curdate,'deviceval'=>$deviceval,'fiscalyears'=>$fiscalyears,'servicestatus'=>$servicestatus])->renderSections()['content'];
        }
        else{
            return view('gym.application',['groupmem'=>$groupmem,'paymenttr'=>$paymenttr,'periodpr'=>$periodpr,'servicepr'=>$servicepr,'servicedetpr'=>$servicedetpr,'membershipval'=>$membershipval,'shop'=>$shop,'mrclist'=>$mrclist,
            'appidsrc'=>$appidsrc,'user'=> $user,'membershipinfos'=>$membershipinfos,'serviceinfos'=>$serviceinfos,'trainerinfos'=>$trainerinfos,'cdate'=>$curdate,'deviceval'=>$deviceval,'fiscalyears'=>$fiscalyears,'servicestatus'=>$servicestatus]);
        }
    }

    public function applicationListCon(Request $request)
    {
        $fiscal_year = $_POST['fiscal_year']; 
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        //$applist=DB::select('SELECT applications.id,applications.ApplicationNumber,applications.Type,applications.Status,applications.VoucherType,applications.paymentterms_id,paymentterms.PaymentTermName,groupmembers.GroupName,applications.VoucherNumber,applications.InvoiceNumber,applications.InvoiceDate,applications.ApplicationType,stores.Name AS POS,CASE WHEN applications.Status="Void" THEN CONCAT(applications.Status,"(",applications.OldStatus,")") WHEN applications.Status="Refund" THEN CONCAT(applications.Status,"(",applications.OldStatus,")") WHEN applications.Status!="Void" AND applications.Status!="Refund" THEN applications.Status END AS StatusVal,(SELECT GROUP_CONCAT(DISTINCT memberships.Name,"	") FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE appconsolidates.applications_id=applications.id) AS Members,(SELECT GROUP_CONCAT(IFNULL(memberships.Mobile,""),",",IFNULL(memberships.Phone,"")," ") FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE appconsolidates.applications_id=applications.id) AS Phone,(SELECT GROUP_CONCAT(DISTINCT services.ServiceName," ") FROM appconsolidates INNER JOIN services ON appconsolidates.services_id=services.id WHERE appconsolidates.applications_id=applications.id) AS Services FROM applications INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id INNER JOIN groupmembers ON applications.groupmembers_id=groupmembers.id INNER JOIN stores ON applications.stores_id=stores.id WHERE applications.FiscalYear='.$fiscal_year.' ORDER BY applications.id DESC');
        $applist = DB::select('SELECT 
            a.id,
            a.ApplicationNumber,
            a.Type,
            a.Status,
            a.VoucherType,
            a.paymentterms_id,
            pt.PaymentTermName,
            gm.GroupName,
            a.VoucherNumber,
            a.InvoiceNumber,
            a.InvoiceDate,
            a.ApplicationType,
            s.Name AS POS,
            CASE 
                WHEN a.Status = "Void" OR a.Status = "Refund" 
                THEN CONCAT(a.Status, "(", a.OldStatus, ")")
                ELSE a.Status 
            END AS StatusVal,

            GROUP_CONCAT(DISTINCT m.Name SEPARATOR "	") AS Members,
            GROUP_CONCAT(DISTINCT CONCAT_WS(",", IFNULL(m.Mobile, ""), IFNULL(m.Phone, ""))) AS Phone,
            GROUP_CONCAT(DISTINCT sv.ServiceName SEPARATOR " ") AS Services

        FROM 
            applications a
        INNER JOIN paymentterms pt ON a.paymentterms_id = pt.id
        INNER JOIN groupmembers gm ON a.groupmembers_id = gm.id
        INNER JOIN stores s ON a.stores_id = s.id

        LEFT JOIN appconsolidates ac ON ac.applications_id = a.id
        LEFT JOIN memberships m ON m.id = ac.memberships_id
        LEFT JOIN services sv ON sv.id = ac.services_id

        WHERE 
            a.FiscalYear = '.$fiscal_year.'
        GROUP BY 
            a.id
        ORDER BY 
            a.id DESC');
        if(request()->ajax()) {
            return datatables()->of($applist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $appedit='';
                $apprenew='';
                $appvoid='';
                $appundovoid='';
                $apprefund='';
                $appundorefund='';
                if($data->Status=="Void")
                {
                    if($user->can('Invoice-Void'))
                    {
                        $appundovoid='<a class="dropdown-item appUndoVoid" onclick="appUndoVoid('.$data->id.')" data-id="'.$data->id.'" id="undovoidbtnln" title="Open invoice undo void confirmation"><i class="fa fa-undo"></i> Undo Void</span></a>';
                    }
                    $appvoid='';
                    $appedit='';
                    $apprefund='';
                    $appundorefund='';
                }
                if($data->Status=="Refund")
                {
                    if($user->can('Invoice-Refund'))
                    {
                        $appundorefund='<a class="dropdown-item appUndoRefund" onclick="appUndoRefund('.$data->id.')" data-id="'.$data->id.'" id="undovoidbtnln" title="Open invoice undo refund confirmation"><i class="fa fa-undo"></i> Undo Refund</span></a>';
                    }
                    $appvoid='';
                    $appundovoid='';
                    $appedit='';
                    $apprefund='';
                }
                if($data->Status=="Pending")
                {
                    if($user->can('Invoice-Edit'))
                    {
                        $appedit=' <a class="dropdown-item appEdit" onclick="appeditdata('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open invoice update page"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Invoice-Void'))
                    {
                        $appvoid='<a class="dropdown-item appVoid" onclick="appVoid('.$data->id.')" data-id="'.$data->id.'" id="voidbtnln" title="Open invoice void confirmation"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    if($user->can('Invoice-Refund'))
                    {
                        $apprefund='<a class="dropdown-item appRefund" onclick="appRefund('.$data->id.')" data-id="'.$data->id.'" id="refundbtnln" title="Open invoice refund confirmation"><i class="fa fa-arrow-left" aria-hidden="true"></i><span> Refund</span></a>';
                    }
                    $appundovoid='';
                    $appundorefund='';
                }
                if($data->Status=="Verified")
                {
                    if($user->can('Invoice-Edit') && $user->can('Invoice-Verify'))
                    {
                        $appedit=' <a class="dropdown-item appEdit" onclick="appeditdata('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open invoice update page"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Invoice-Void') && $user->can('Invoice-Verify'))
                    {
                        $appvoid='<a class="dropdown-item appVoid" onclick="appVoid('.$data->id.')" data-id="'.$data->id.'" id="voidbtnln" title="Open invoice void confirmation"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    if($user->can('Invoice-Refund') && $user->can('Invoice-Verify'))
                    {
                        $apprefund='<a class="dropdown-item appRefund" onclick="appRefund('.$data->id.')" data-id="'.$data->id.'" id="refundbtnln" title="Open invoice refund confirmation"><i class="fa fa-arrow-left" aria-hidden="true"></i><span> Refund</span></a>';
                    }
                    
                    $appundovoid='';
                    $appundorefund='';
                }
                if($data->Status=="Frozen")
                {
                    if($user->can('Invoice-Edit') && $user->can('Invoice-Verify'))
                    {
                        $appedit=' <a class="dropdown-item appEdit" onclick="appeditdata('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open invoice update page"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    
                    if($user->can('Invoice-Void') && $user->can('Invoice-Verify'))
                    {
                        $appvoid='<a class="dropdown-item appVoid" onclick="appVoid('.$data->id.')" data-id="'.$data->id.'" id="voidbtnln" title="Open invoice void confirmation"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    if($user->can('Invoice-Refund') && $user->can('Invoice-Verify'))
                    {
                        $apprefund='<a class="dropdown-item appRefund" onclick="appRefund('.$data->id.')" data-id="'.$data->id.'" id="refundbtnln" title="Open invoice refund confirmation"><i class="fa fa-arrow-left" aria-hidden="true"></i><span> Refund</span></a>';
                    }
                    $appundovoid='';
                    $appundorefund='';
                }
                if($data->Status=="Expired")
                {
                    $appvoid='';
                    $appundovoid='';
                    $appedit='';
                    $apprefund='';
                    $appundorefund='';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item appInfo" onclick="appInfo('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open invoice information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$appedit.'
                        '.$appvoid.'
                        '.$appundovoid.'
                        '.$apprefund.'
                        '.$appundorefund.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function memberListCon(Request $request)
    {
        if($_POST['service_status'] == 0){
            $service_status = "NULL";
        }
        else{
            $service_status = $_POST['service_status']; 
            $service_status= '"' .implode('","', $service_status). '"';
        }

        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $applist=DB::select('SELECT DISTINCT memberships.id,memberships.MemberId,memberships.Picture,memberships.Gender,memberships.DOB,memberships.Name,CONCAT(IFNULL(memberships.Mobile,""),",  ",IFNULL(memberships.Phone,"")) AS MobilePhone,memberships.Status,memberships.LoyalityStatus,
        @pendingcount:=(SELECT COUNT(appconsolidates.id) FROM appconsolidates WHERE appconsolidates.memberships_id=memberships.id AND appconsolidates.Status="Pending"),
        @expiredcount:=(SELECT COUNT(appconsolidates.id) FROM appconsolidates WHERE appconsolidates.memberships_id=memberships.id AND appconsolidates.Status="Expired"),
        @frozencount:=(SELECT COUNT(appconsolidates.id) FROM appconsolidates WHERE appconsolidates.memberships_id=memberships.id AND appconsolidates.Status="Frozen"),
        @voidcount:=(SELECT COUNT(appconsolidates.id) FROM appconsolidates WHERE appconsolidates.memberships_id=memberships.id AND appconsolidates.Status="Void"),
        @totalcount:=(SELECT COUNT(appconsolidates.id) FROM appconsolidates WHERE appconsolidates.memberships_id=memberships.id),
        @activecount:=(SELECT COUNT(appconsolidates.id) FROM appconsolidates WHERE appconsolidates.memberships_id=memberships.id AND appconsolidates.Status="Active"),
        CASE WHEN @activecount>=1 THEN "Active" WHEN @activecount=0 AND @pendingcount>=1 THEN "Pending" WHEN @activecount=0 AND @frozencount>=1 THEN "Frozen" WHEN @activecount=0 AND @expiredcount>=1 THEN "Expired" WHEN @activecount=0 AND @voidcount>=1 THEN "Void" END AS ServiceStatus
        FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id HAVING ServiceStatus IN ('.$service_status.') ORDER BY memberships.Name ASC');
        if(request()->ajax()) {
            return datatables()->of($applist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $appfreezeunfreeze='';
                if($user->can('Service-Freeze-UnFreeze'))
                {
                    $appfreezeunfreeze='<a class="dropdown-item appfreeze" onclick="appfreeze('.$data->id.')" data-id="'.$data->id.'" id="freezebtn" title="Open member freeze unfreeze confirmation"><i class="fa fa-moon"></i> Freeze / Un-Freeze</span></a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item appMemberInfo" onclick="appMemberInfo('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open membership information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$appfreezeunfreeze.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function saveFreezeUnFreeze(Request $request){
        ini_set('max_execution_time', '300000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $curdate=Carbon::today()->toDateString();
        $freezeby=null;
        $freezedate=null;
        $unfreezeby=null;
        $unfreezedate=null;
        $freezeextday=null;
        $remdays=null;
        $valcdate=null;
        $freezedateval=null;
        $dateamount=0;
        $dateamountcnt=0;
        $memarr=[];
        $servarr=[];
        $perarr=[];
        $getallms=0;
        $getselms=0;
        $appid=0;
        $memidarr=[];
        $memberids=null;
        $deviceids=[];
		$memcounts=null;
        $activecnt=0;
        $frozencnt=0;

        $now = Carbon::now();
        $meridiam = $now->format('A');
        $dayname = $now->format('l');

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

        $freezerr=array(
            'rowtr.*.FreezeFor' => 'required_if:rowtr.*.StatusFlag,1',
        );
        $v2= Validator::make($request->all(), $freezerr);

        foreach ($request->rowtr as $key => $value)
        {
            $appid=$value['applicationIdVar'];
            $oldstatus=$value['HiddenStatus'];
            $freezeday=$value['FreezeFor'];
            $memid=$value['membershipid'];
            $servid=$value['serviceid'];
            $perid=$value['periodid'];
            $freezedateval = Carbon::parse($freezedate);
            $valcdate= Carbon::parse($curdate);
            $memberids=$value['membershipid'];
            if($oldstatus=="Frozen"){
                $dateamount = $freezedateval->diffInDays($valcdate);
                if($freezeday!=null){
                    if($freezeday<$dateamount){
                        $dateamountcnt+=1;
                        $memarr[]=$memid;
                        $servarr[]=$servid;
                        $perarr[]=$perid;
                        
                    }
                }
            }
            $getallms+=1;
            
        }


        if($v2->passes() && $dateamountcnt==0)
        {
            try
            {
               
                $mquuid = Str::uuid()->toString();
                $mqt=new mqttmessage;
                $mqtt = MQTT::connection();

                foreach ($request->rowtr as $key => $value)
                {
                    $statusflag=$value['StatusFlag'];
                    if($statusflag==1){
                        $frozenid=$value['frozenId'];
                        $regdate=$value['regDate'];
                        $expdate=$value['expDate'];
                        $statusval=$value['Status'];
                        $freezeday=$value['FreezeFor'];
                        $freezestatus=$value['Status'];
                        $oldstatus=$value['HiddenStatus'];
                        $remdate=$value['remainingDate'];
                        $freezeby=$value['freezeby'];
                        $freezedate=$value['freezedate'];
                        $unfreezeby=$value['unfreezeby'];
                        $unfreezedate=$value['unfreezedate'];
                        $mainregdt=$value['mainregDate'];
                        $mainexdt=$value['mainexpDate'];
                        $toDate = Carbon::parse($mainexdt);
                        $fromDate = Carbon::parse($curdate);
                        $rdate = Carbon::parse($regdate);
                        $edate = Carbon::parse($expdate);
                        
                        if($oldstatus=="Active"){
                            $freezeby=$user;
                            $freezedate=Carbon::today()->toDateString();
                            $remdays = $toDate->diffInDays($fromDate);  
                            $activedt=$rdate->addDay($freezeday);
                            $activedtfr=Carbon::parse($activedt)->format("Y-m-d");
                            $activeregdate=$fromDate->addDay($freezeday);
                            $activergdate = Carbon::parse($activeregdate);
                            $activeexpdate=$activergdate->addDay($remdays);
                            $acexpdate=Carbon::parse($activeexpdate)->format("Y-m-d"); 
                        }

                        if($oldstatus=="Frozen"){
                            $unfreezeby=$user;
                            $unfreezedate=Carbon::today()->toDateString();
                            $fromDate = Carbon::parse($freezedate);
                            $remdays = $remdate;
                            $rdate = Carbon::parse($mainregdt);
                            $edate = Carbon::parse($mainexdt);
                            $activedt=$rdate->addDay($freezeday);
                            $activedtfr=Carbon::parse($activedt)->format("Y-m-d");
                            $activeregdate=$fromDate->addDay($freezeday);
                            $activergdate = Carbon::parse($activeregdate);
                            $activeexpdate=$activergdate->addDay($remdays);
                            $acexpdate=Carbon::parse($activeexpdate)->format("Y-m-d"); 
                            if($freezestatus=="Active"){
                                $activedtfr=Carbon::today()->toDateString();
                                $activestdate = Carbon::parse($activedtfr);
                                $enddateval=$activestdate->addDay($remdate);
                                $acexpdate=Carbon::parse($enddateval)->format("Y-m-d"); 
                            }
                        }

                        if($freezeday==null){
                            $freezeextday=0;
                        }
                        else if($freezeday!=null){
                            $freezeextday=$freezeday;
                        }
                        
                        //$activeregdate=$fromDate->addDay($freezeday);
                        //$activergdate = Carbon::parse($activeregdate);
                        //$activeexpdate=$activergdate->addDay($remdays);
                        $acregdate=Carbon::parse($activergdate)->format("Y-m-d");
                        //$acexpdate=Carbon::parse($activeexpdate)->format("Y-m-d"); 
                        $updatefrstatus=appconsolidate::where('appconsolidates.id',$frozenid)->update(['RegistrationDate'=>$activedtfr,'ExpiryDate'=>$acexpdate,'FreezeRegistrationDate'=>$mainregdt,'FreezeExpiryDate'=>$mainexdt,'FreezedBy'=>$freezeby,'FreezedDate'=>$freezedate,'UnFreezedBy'=>$unfreezeby,'UnFreezedDate'=>$unfreezedate,'ExtendDay'=>$freezeextday,'RemainingDay'=>$remdays,'Status'=>$freezestatus]); 
                        if($freezestatus=="Frozen"){
                            $getselms+=1;
                            
                        }
                    }  
                }

                
                $getactivecount=DB::select('SELECT COUNT(appconsolidates.memberships_id) AS ActiveCount FROM appconsolidates WHERE appconsolidates.Status="Active" AND appconsolidates.memberships_id='.$memberids);
                foreach($getactivecount as $rowc)
                {
                    $activecnt=$rowc->ActiveCount;
                }

                $getfrozencount=DB::select('SELECT COUNT(appconsolidates.memberships_id) AS FrozenCount FROM appconsolidates WHERE appconsolidates.Status="Frozen" AND appconsolidates.memberships_id='.$memberids);
                foreach($getfrozencount as $rowc)
                {
                    $frozencnt=$rowc->FrozenCount;
                }

                $getdevices=DB::select('SELECT DISTINCT appservices.devices_id FROM appservices WHERE appservices.applications_id='.$appid);
                foreach($getdevices as $devrow){
                    $deviceids[] = $devrow->devices_id;
                }
                $devids=implode(',', $deviceids);

               

                if($activecnt==0){
                    $getalldevice=DB::select('SELECT DISTINCT * FROM devices WHERE devices.Status="Active" AND devices.id IN ('.$devids.') UNION SELECT DISTINCT * FROM devices WHERE devices.Status="Active" AND devices.devicetype IN (3)');
                    foreach($getalldevice as $devrow)
                    {
                        $topic="mqtt/face/".$devrow->DeviceId;
                        $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                        
                        $msgs='{
                            "messageId":"MessageID-DeletePerson-'.$mquuid.'",
                            "DataBegin":"BeginFlag",
                            "operator": "DeletePersons",
                            "PersonNum":1,
                            "info":
                            {
                                "facesluiceId":"'.$devrow->DeviceId.'",
                                "customId":"['.$memberids.']",                             
                            },
                            "DataEnd":"EndFlag"
                        }';
                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 8) {
                                $mqtts->interrupt();
                            }
                        });
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$mquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
                        $mqtt->publish($topic,$msgs,2);
                        $mqtt->loop(true);
                    }
                    $mqtt->disconnect();
                }
                if($frozencnt==0){
                    $getallclients=DB::select('SELECT appconsolidates.memberships_id AS MemberIdVal,memberships.*,memberships.Status AS MemberStatus,periods.PeriodName,(SELECT perioddetails.FirstHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfFrom,(SELECT perioddetails.FirstHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfTo,(SELECT perioddetails.SecondHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfFrom,(SELECT perioddetails.SecondHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfTo,appconsolidates.devices_id,devices.*,applications.RegistrationDate,applications.ExpiryDate,applications.Status FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN devices ON appconsolidates.devices_id=devices.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE appconsolidates.memberships_id='.$memberids);
                    foreach($getallclients as $row)
                    {
                        if($row->LeftThumb==null || $row->LeftThumb==""){
                            $leftthumb="";
                        }
                        if($row->LeftThumb!=null && $row->LeftThumb!=""){
                            $leftthumb=$row->LeftThumb;
                        }

                        if($row->LeftIndex==null || $row->LeftIndex==""){
                            $leftindex="";
                        }
                        if($row->LeftIndex!=null && $row->LeftIndex!=""){
                            $leftindex=$row->LeftIndex;
                        }

                        if($row->LeftMiddle==null || $row->LeftMiddle==""){
                            $leftmiddle="";
                        }
                        if($row->LeftMiddle!=null && $row->LeftMiddle!=""){
                            $leftmiddle=$row->LeftMiddle;
                        }

                        if($row->LeftRing==null || $row->LeftRing==""){
                            $leftring="";
                        }
                        if($row->LeftRing!=null && $row->LeftRing!=""){
                            $leftring=$row->LeftRing;
                        }

                        if($row->LeftPinky==null || $row->LeftPinky==""){
                            $leftpicky="";
                        }
                        if($row->LeftPinky!=null && $row->LeftPinky!=""){
                            $leftpicky=$row->LeftPinky;
                        }

                        if($row->RightThumb==null || $row->RightThumb==""){
                            $rightthumb="";
                        }
                        if($row->RightThumb!=null && $row->RightThumb!=""){
                            $rightthumb=$row->RightThumb;
                        }

                        if($row->RightIndex==null || $row->RightIndex==""){
                            $rightindex="";
                        }
                        if($row->RightIndex!=null && $row->RightIndex!=""){
                            $rightindex=$row->RightIndex;
                        }

                        if($row->RightMiddle==null || $row->RightMiddle==""){
                            $rightmiddle="";
                        }
                        if($row->RightMiddle!=null && $row->RightMiddle!=""){
                            $rightmiddle=$row->RightMiddle;
                        }

                        if($row->RightRing==null || $row->RightRing==""){
                            $rightring="";
                        }
                        if($row->RightRing!=null && $row->RightRing!=""){
                            $rightring=$row->RightRing;
                        }

                        if($row->RightPinky==null || $row->RightPinky==""){
                            $rightpicky="";
                        }
                        if($row->RightPinky!=null && $row->RightPinky!=""){
                            $rightpicky=$row->RightPinky;
                        }

                        if($meridiam=="AM"){
                            if($row->FirstHalfFrom==null || $row->FirstHalfFrom==""){
                                $starttime="11:59:59";
                            }
                            if($row->FirstHalfFrom!=null && $row->FirstHalfFrom!=""){
                                $starttime=$row->FirstHalfFrom.":00";
                            }

                            if($row->FirstHalfTo==null || $row->FirstHalfTo==""){
                                $endtime="11:59:59";
                            }
                            if($row->FirstHalfTo!=null && $row->FirstHalfTo!=""){
                                $endtime=$row->FirstHalfTo.":59";
                            }
                        }
                        if($meridiam=="PM"){
                            if($row->SecondHalfFrom==null || $row->SecondHalfFrom==""){
                                $starttime="23:59:59";
                            }
                            if($row->SecondHalfFrom!=null && $row->SecondHalfFrom!=""){
                                $starttime=$row->SecondHalfFrom.":00";
                            }

                            if($row->SecondHalfTo==null || $row->SecondHalfTo==""){
                                $endtime="23:59:59";
                            }
                            if($row->SecondHalfTo!=null && $row->SecondHalfTo!=""){
                                $endtime=$row->SecondHalfTo.":59";
                            }
                        }

                        if($row->Gender=="Male"){
                            $gender=0;
                        }
                        if($row->Gender=="Female"){
                            $gender=1;
                        }

                        if($row->MemberStatus=="Active"){
                            $persontype=0;
                        }
                        if($row->MemberStatus!="Active"){
                            $persontype=1;
                        }

                        if($row->Picture!=null){
                            $imagepath = public_path().'/storage/uploads/MemberPicture/'.$row->Picture;
                            $picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                        }
                        if($row->Picture==null){
                            $picdata=$defpic;
                        }

                        $topic="mqtt/face/".$row->DeviceId;
                        $topicrec="mqtt/face/".$row->DeviceId."/Ack";

                        $msgs='{
                            "operator": "EditPerson",
                            "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                            "info":
                            {
                                "facesluiceId":"'.$row->DeviceId.'",
                                "customId":"'.$row->MemberIdVal.'",
                                "tempCardType":1,
                                "personType":"'.$persontype.'",
                                "name":"'.$row->Name.'",
                                "gender":"'.$gender.'",
                                "birthday":"'.$row->DOB.'",
                                "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                                "address":"'.$row->Location.'",
                                "PersonUUID":"'.$row->PersonUUID.'",
                                "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                                "pic":"'.$picdata.'",                                    
                            },
                        }';
                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 8) {
                                $mqtts->interrupt();
                            }
                        });
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$mquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
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
                                "PersonUUID":"'.$row->MemberIdVal.'",
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
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$fpmquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
                        $mqtt->publish($topic,$fpmsgs,2);
                        $mqtt->loop(true);

                        // $resmsgs='{
                        //     "operator": "RebootDevice",
                        //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                        //     "info":
                        //     {
                        //         "facesluiceId":"'.$devid.'",
                        //     },
                        // }';     
                        // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                        //     if ($elapsedTime >= 8) {
                        //         $mqtts->interrupt();
                        //     }
                        // });
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$mquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
                        // $mqtt->publish($topic,$resmsgs,2);
                        // $mqtt->loop(true);

                        $getexitdevice=DB::select('SELECT * FROM devices WHERE devices.Status="Active" AND devices.devicetype=3');
                        foreach($getexitdevice as $devrow)
                        {
                            $topic="mqtt/face/".$devrow->DeviceId;
                            $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                            
                            $msgs='{
                                "operator": "EditPerson",
                                "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                                "info":
                                {
                                    "facesluiceId":"'.$devrow->DeviceId.'",
                                    "customId":"'.$row->MemberIdVal.'",
                                    "tempCardType":1,
                                    "personType":"'.$persontype.'",
                                    "name":"'.$row->Name.'",
                                    "gender":"'.$gender.'",
                                    "birthday":"'.$row->DOB.'",
                                    "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                                    "address":"'.$row->Location.'",
                                    "PersonUUID":"'.$row->PersonUUID.'",
                                    "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                    "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                                    "pic":"'.$picdata.'",                                    
                                },
                            }';
                            $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                if ($elapsedTime >= 8) {
                                    $mqtts->interrupt();
                                }
                            });
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$mquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
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
                                    "PersonUUID":"'.$row->MemberIdVal.'",
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
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$fpmquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
                            $mqtt->publish($topic,$fpmsgs,2);
                            $mqtt->loop(true);

                            // $resmsgs='{
                            //     "operator": "RebootDevice",
                            //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                            //     "info":
                            //     {
                            //         "facesluiceId":"'.$devid.'",
                            //     },
                            // }';     
                            // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            //     if ($elapsedTime >= 8) {
                            //         $mqtts->interrupt();
                            //     }
                            // });
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$mquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
                            // $mqtt->publish($topic,$resmsgs,2);
                            // $mqtt->loop(true);

                        }
                    }
                    $mqtt->disconnect();
                }

                // if($getallms==$getselms){
                //     $updatefrozen=DB::select('UPDATE applications SET applications.Status="Frozen" WHERE applications.id='.$appid);
                // }
                // else if($getallms!=$getselms){
                //     $updateactive=DB::select('UPDATE applications SET applications.Status="Active" WHERE applications.id='.$appid);
                // }
                return Response::json(['success' =>1]);  
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }

        if($dateamountcnt>=1){
            $mid=implode(',', $memarr);
            $sid=implode(',', $servarr);
            $pid=implode(',', $perarr);
            $getfrozenmem=DB::select('SELECT memberships.Name,services.ServiceName,periods.PeriodName FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN periods ON appconsolidates.periods_id=periods.id WHERE appconsolidates.memberships_id IN('.$mid.') AND appconsolidates.services_id IN('.$sid.') AND appconsolidates.periods_id IN('.$pid.') AND appconsolidates.Status="Frozen"');
            return Response::json(['frozenerr'=>"error",'frozenmem'=>$getfrozenmem]);
        }
        
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
    }

    public function store(Request $request){

        $host = request()->getSchemeAndHttpHost(); 
        ini_set('max_execution_time', '300000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $rprefix=$settings->ApplicationPrefix;
        $rnumber=$settings->ApplicationNumber;
        $fyear=$settings->FiscalYear;
        $rnumberPadding=sprintf("%06d", $rnumber);
        $applicationNumbers=$rprefix.$rnumberPadding;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid = $request->applicationId;
        $findid = $request->applicationId;
        $groupval = $request->GroupAmountVal;
        $paymentval = $request->PaymentTermAmountVal;
        $applicationidvar = $request->ApplicationsId;
        $applicationtypevar = $request->ApplicationType;
        $applicationtypehidden = $request->hiddenAppType;
        $mrcnum=$request->mrc;
        $expirydate=$request->ExpiryDate;
        $curentdate=Carbon::today()->toDateString();
        $type="";
        $appidvar="";
        $paymenthistoryid="";
        $regmember=0;
        $paymentid=null;
        $updatestatus=null;
        $memarr=[];
        $servarr=[];
        $delmemberid=[];
        $delserviceid=[];
        $delserviconid=[];
        $delmemberconid=[];
        $listofmem=[];
        $listofserv=[];
        $listofperiod=[];
        $membercnt=0;
        $membertotalcnt=0;
        $frmembercnt=0;
        $frmembertotalcnt=0;
        $frlistofmem=[];
        $frlistofserv=[];
        $frlistofperiod=[];
        $exmembercnt=0;
        $exmembertotalcnt=0;
        $exlistofmem=[];
        $exlistofserv=[];
        $exlistofperiod=[];
        $oldmembers=[];
        $rennewmembers=[];
        $errvval="";
        $errtval="";
        $emptytblerr=0;
        $emptyserverr=0;
        $emptytrainerr=0;
        $oldapptype="";
        $servlisttrarr=[];
        $delservicontrid=[];
        $applicationdocfile=null;
        $documentnames=null;
        $memidv=null;
        $serviceid=null;
        
        $serarr=[];
        $memidarr=[];
        $deviceids=[];
        $renewmembercnt=0;
        $renewcount=0;
        $notfound=0;
        $numofmem=0;
        $renewflag=0;
        $memimp=null;
        $serimp=null;
        $memcounts=null;

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
        $starttime=null;
        $endtime=null;
        $starttimefirsthalf=null;
        $endtimefirsthalf=null;
        $starttimesecondhalf=null;
        $endtimesecondhalf=null;
        $mquuid = Str::uuid()->toString();
        $currtime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');
        
        if($groupval==1){
            $type="Individual";
        }
        else if($groupval>1){
            $type="Group";
        }

        if($applicationidvar==null){
            $appidvar=0;
        }
        else if($applicationidvar!=null){
            $appidvar=$request->ApplicationsId;
        }

        if($findid!=null){
            $validator = Validator::make($request->all(), [
                'ApplicationType' => ['required'],
                'ApplicationsId' => ['required_if:ApplicationType,Renew'],
                'Group' => ['required'],
                'PaymentTerm' => ['required'],
                'Pos' => ['required'],
                'VoucherType' => ['required'],
                'PaymentType' => ['required'],
                'VoucherNumber' => ['required',Rule::unique('applications')->where(function ($query) use($mrcnum){
                        return $query->where('Mrc',$mrcnum)
                        ->where('IsVoid',0);
                    })->ignore($findid)
                ],
                'InvoiceNumber' => ['nullable',Rule::unique('applications')->where(function ($query) use($mrcnum){
                        return $query->where('Mrc',$mrcnum)
                        ->where('IsVoid',0);
                    })->ignore($findid)
                ],
                'mrc' => ['required_if:VoucherType,Fiscal-Receipt'],
                'RegistationDate' => ['required'],
                'ExpiryDate' => ['required','after:now'],
                'date' => ['required','before:now'],
            ]);

            $rules=array(
                'rowm.*.member_id' => 'required',
            );

            $servicerules=array(
                'row.*.service_id' => 'required|numeric',
                'row.*.period_id' => 'required|numeric',
                'row.*.BeforeTax' => 'required|numeric',
                'row.*.Tax' => 'required|numeric',
                'row.*.GrandTotal' => 'required|numeric',
                'row.*.AccessControl' => 'required',
            );

            $trainerrule=array(
                'rowTrn.*.member_id' => 'required',
                'rowTrn.*.employes_id' => 'required',
                'rowTrn.*.service_id' => 'required',
                'rowTrn.*.BeforeTax' => 'required|numeric',
                'rowTrn.*.Tax' => 'required|numeric',
                'rowTrn.*.GrandTotal' => 'required|numeric',
            );

            $v2= Validator::make($request->all(), $rules);
            $v3= Validator::make($request->all(), $servicerules);
            $v4= Validator::make($request->all(), $trainerrule);

            if($request->rowm!=null && $request->row!=null){
                foreach ($request->rowm as $memkey => $memvalue){
                    if (empty($memvalue['member_id'])) {
                        $memidv=null;
                        $memarr[]=null;
                    }
                    else if(!empty($memvalue['member_id'])){
                        $memidv=$memvalue['member_id'];
                        $memarr[]=$memvalue['member_id'];
                    }
                    foreach ($request->row as $key => $value){
                        if (empty($value['service_id'])) {
                            $serviceid=null;
                            $serarr[]=null;
                        }
                        else if(!empty($value['service_id'])){
                            $serviceid=$value['service_id'];
                            $serarr[]=$value['service_id'];
                        }
                        if (empty($value['period_id'])) {
                            $periodid=null;
                        }
                        else if(!empty($value['period_id'])){
                            $periodid=$value['period_id'];
                        }
                        if($periodid!=null && $serviceid!=null && $memidv!=null && $request->RegistationDate!=null){
                            $getmemberval=DB::select('SELECT COUNT(appconsolidates.id) AS MemberCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.ApplicationType="'.$applicationtypevar.'" AND appconsolidates.memberships_id='.$memidv.' AND appconsolidates.services_id='.$serviceid.' AND appconsolidates.periods_id='.$periodid.' AND appconsolidates.applications_id!='.$findid.' AND appconsolidates.type=0 AND appconsolidates.ExpiryDate>"'.$request->RegistationDate.'" AND appconsolidates.Status IN("Pending","Active")');
                            foreach ($getmemberval as $getmemberval) {
                                $membercnt = $getmemberval->MemberCount;
                                if($membercnt>=1){
                                    $membertotalcnt+=1;
                                    $listofmem[]=$memidv;
                                    $listofserv[]=$serviceid;
                                    $listofperiod[]=$periodid;
                                }
                            }
                            if($applicationtypehidden=="Renew"){
                                $getextendedmember=DB::select('SELECT COUNT(appconsolidates.id) AS MemberExtendedCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.memberships_id='.$memidv.' AND appconsolidates.services_id='.$serviceid.' AND appconsolidates.periods_id='.$periodid.' AND applications.RenewParentId='.$appidvar.' AND applications.id!='.$findid.' AND appconsolidates.type=0 AND applications.Status IN("Pending","Active")');
                                foreach ($getextendedmember as $getextendedmember) {
                                    $exmembercnt = $getextendedmember->MemberExtendedCount;
                                    if($exmembercnt>=1){
                                        $exmembertotalcnt+=1;
                                        $exlistofmem[]=$memidv;
                                        $exlistofserv[]=$serviceid;
                                        $exlistofperiod[]=$periodid;
                                    }
                                }
                            }

                            $getfrozenmember=DB::select('SELECT COUNT(appconsolidates.id) AS MemberFrozenCount FROM appconsolidates WHERE appconsolidates.memberships_id='.$memidv.' AND appconsolidates.services_id='.$serviceid.' AND appconsolidates.periods_id='.$periodid.' AND appconsolidates.type=0 AND appconsolidates.Status IN("Frozen")');
                            foreach ($getfrozenmember as $getfrozenmember) {
                                $frmembercnt = $getfrozenmember->MemberFrozenCount;
                                if($frmembercnt>=1){
                                    $frmembertotalcnt+=1;
                                    $frlistofmem[]=$memidv;
                                    $frlistofserv[]=$serviceid;
                                    $frlistofperiod[]=$periodid;
                                }
                            }
                        }
                    }
                    $regmember+=1;
                }

                $memimp=implode(',', $memarr);
                $serimp=implode(',', $serarr);
                if($memimp!=null && $serimp!=null){
                    if($applicationtypevar=="New"){
                        $getmembersinformation=DB::select('SELECT COUNT(DISTINCT applications.id) AS MemberCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.memberships_id IN('.$memimp.') AND applications.Status NOT IN("Void","Refund") AND appconsolidates.applications_id!='.$findid.' AND appconsolidates.services_id IN('.$serimp.')');
                        foreach ($getmembersinformation as $memrow) {
                            $renewmembercnt=$memrow->MemberCount;
                        }
                    }

                    if($applicationtypevar=="Renew"){
                        $getrenewedmember=DB::select('SELECT COUNT(DISTINCT applications.id) AS RenewMemberCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.memberships_id IN('.$memimp.') AND applications.Status NOT IN("Void","Refund") AND appconsolidates.services_id IN('.$serimp.') AND applications.id!='.$findid.' AND applications.paymentterms_id!=5 AND appconsolidates.applications_id<'.$appidvar);
                        foreach ($getrenewedmember as $renmem) {
                            $renewcount=$renmem->RenewMemberCount;
                        }
                    }
                }
            }

            $servlisttrarr=[]; 
            $servlisttr=apptrainers::where('applications_id',$request->applicationId)->get(['services_id']);
            //$servlisttr=DB::select('SELECT apptrainers.services_id FROM apptrainers WHERE apptrainers.applications_id='.$request->applicationId);
            foreach ($servlisttr as $row) {
                $servlisttrarr[] = $row->services_id;
            }

            $memarr=[];
            $memlists=appmember::where('applications_id',$request->applicationId)->get(['memberships_id']);
            //$memrowlist=DB::select('SELECT appmembers.memberships_id FROM appmembers WHERE appmembers.applications_id='.$request->applicationId);
            foreach ($memlists as $memrowlist) {
                $memarr[] = $memrowlist->memberships_id;
            }
            
            $servarr=[];
            $servlist=appservice::where('applications_id',$request->applicationId)->get(['services_id']);
            //$servlist=DB::select('SELECT appservices.services_id FROM appservices WHERE appservices.applications_id='.$request->applicationId);
            foreach ($servlist as $servlist) {
                $servarr[] = $servlist->services_id;
            }

            $applicationmain=ApplicationForm::where('id',$request->applicationId)->get(['Status','ApplicationType']);
            foreach ($applicationmain as $applicationmain) {
                $updatestatus = $applicationmain->Status;
                $oldapptype=$applicationmain->ApplicationType;
            }

            $getmemebers=DB::select('SELECT appmembers.memberships_id FROM appmembers WHERE appmembers.applications_id='.$request->applicationId);
            foreach($getmemebers as $memrow){
                $memidarr[] = $memrow->memberships_id;
            }
            $getmembercnt=DB::select('SELECT COUNT(appmembers.memberships_id) AS MemberCount FROM appmembers WHERE appmembers.applications_id='.$request->applicationId);
            foreach($getmembercnt as $cntrow){
                $memcounts = $cntrow->MemberCount;
            }

            $getdevices=DB::select('SELECT DISTINCT appservices.devices_id FROM appservices WHERE appservices.applications_id='.$request->applicationId);
            foreach($getdevices as $devrow){
                $deviceids[] = $devrow->devices_id;
            }

            if($applicationtypevar=="New"||$applicationtypevar=="Renew"){
                if($request->rowm==null){
                    $emptytblerr=1;
                }
                if($request->row==null){
                    $emptyserverr=1;
                }
            }

            if($applicationtypevar=="Trainer-Fee"){
                if($request->rowTrn==null){
                    $emptytrainerr=1;
                }
                $regmember=0;
                $groupval=0;
            }

            if($validator->passes() && $v2->passes() && $v3->passes() && $v4->passes() && $expirydate>=$curentdate && $regmember==$groupval && $membertotalcnt==0 && $exmembertotalcnt==0 && $emptytblerr==0 && $emptyserverr==0 && $emptytrainerr==0 && $renewmembercnt<=1 && $renewcount==0){
                try
                {
                    $mquuid = Str::uuid()->toString();
                    $mqt=new mqttmessage;
                    $mqtt = MQTT::connection();

                    if ($request->file('ApplicationDocument')) {
                        $file = $request->file('ApplicationDocument');
                        $fn = $file->getClientOriginalName();
                        $name = explode('.', $fn)[0]; // Filename 'filename'
                        $documentnames = preg_replace('/\s+/', '-', $name);
                        $applicationdocfile = time() . '.' . $request->file('ApplicationDocument')->extension();
                        $pathIdentification = public_path() . '/storage/uploads/ApplicationDocuments';
                        $pathnameIdentification='/storage/uploads/ApplicationDocuments/'.$applicationdocfile;
                        $file->move($pathIdentification, $applicationdocfile);
                    }
                    if($request->file('ApplicationDocument')==''){
                        $applicationdocfile=$request->applicationdocumentupdate;
                    }
                    $applicationhd=ApplicationForm::updateOrCreate(['id' => $request->applicationId], [
                        'ApplicationType' => $request->ApplicationType,
                        'RenewParentId' => $appidvar,
                        'groupmembers_id' => $request->Group,
                        'paymentterms_id' => $request->PaymentTerm,
                        'stores_id' => $request->Pos,
                        'Type' => $type,
                        'RegistrationDate' =>$request->RegistationDate,
                        'ExpiryDate' => $request->ExpiryDate,
                        'VoucherType' => $request->VoucherType,
                        'Mrc' => $request->mrc,
                        'PaymentType' => $request->PaymentType,
                        'VoucherNumber' => $request->VoucherNumber,
                        'InvoiceNumber' => $request->InvoiceNumber,
                        'InvoiceDate' => $request->date,
                        'SubTotal' => $request->subtotali,
                        'TotalTax' => $request->taxi,
                        'GrandTotal' => $request->grandtotali,
                        'DiscountPercent' => $request->discountper,
                        'DiscountAmount' => $request->discounti,
                        'LastEditedBy' => $user,
                        'LastEditedDate' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                        'Memo' => $request->Memo,
                        'DocumentUploadPath'=>$applicationdocfile,
                        'DocumentOriginalName'=>$documentnames,
                    ]);

                    if($oldapptype=="Trainer-Fee" && ($applicationtypevar=="New"||$applicationtypevar=="Renew")){
                        $applicationhd->consolidate()->detach();
                        $applicationhd->trainer()->detach();
                        foreach ($request->rowm as $key => $value)
                        {
                            $headeridsval=$request->applicationId;
                            $memberid=$value['member_id'];
                            $memcnt=$value['MemberCount'];
                            $applicationhd->memb()->attach($memberid,
                            ['IsMemberBefore'=>$memcnt,'Status'=>"Pending"]);
                        }

                        foreach ($request->row as $key => $value)
                        {
                            $headerids=$request->applicationId;
                            $serviceid=$value['service_id'];
                            $periodid=$value['period_id'];
                            $beforetax=$value['BeforeTax'];
                            $tax=$value['Tax'];
                            $grandtotal=$value['GrandTotal'];
                            $discountper=$value['Discount'];
                            $discountamount=$value['DiscountAmount'];
                            $deviceid=$value['AccessControl'];
                            $applicationhd->serv()->attach($serviceid,
                            ['periods_id'=>$periodid,'BeforeTotal'=>$beforetax,'Tax'=>$tax,'TotalAmount'=>$grandtotal,'DiscountServicePercent'=>$discountper,'DiscountServiceAmount'=>$discountamount,'devices_id'=>$deviceid]);
                        }

                        foreach ($request->rowm as $memkey => $memvalue){
                            $memberidvals=$memvalue['member_id'];
                            foreach ($request->row as $key => $value)
                            {
                                $headerids=$request->applicationId;
                                $serviceidcons=$value['service_id'];
                                $periodidcons=$value['period_id'];
                                $regdatecons=$request->RegistationDate;
                                $expirydatecons=$request->ExpiryDate;
                                $statusvalcons="Pending";
                                $deviceid=$value['AccessControl'];
                                $applicationhd->consolidate()->attach($memberidvals,
                                ['services_id'=>$serviceidcons,'periods_id'=>$periodidcons,'RegistrationDate'=>$regdatecons,'ExpiryDate'=>$expirydatecons,'Status'=>$statusvalcons,'devices_id'=>$deviceid]);
                            }
                        }
                    }

                    if(($oldapptype == "New" || $oldapptype == "Renew") && $applicationtypevar == "Trainer-Fee"){
                        $applicationhd->consolidate()->detach();
                        $applicationhd->serv()->detach();
                        $applicationhd->memb()->detach();
                        foreach ($request->rowTrn as $keytr => $trvalue)
                        {
                            $headerids=$request->applicationId;
                            $employeid=$trvalue['employes_id'];
                            $memberidvals=$trvalue['member_id'];
                            $serviceid=$trvalue['service_id'];
                            $periodid=$trvalue['period_id'];
                            $beforetax=$trvalue['BeforeTax'];
                            $tax=$trvalue['Tax'];
                            $grandtotal=$trvalue['GrandTotal'];
                            $discountper=$trvalue['Discount'];
                            $discountamount=$trvalue['DiscountAmount'];
                            $regdatecons=$request->RegistationDate;
                            $expirydatecons=$request->ExpiryDate;
                            $statusvalcons="Pending";
                            $applicationhd->trainer()->attach($employeid,
                            ['services_id'=>$serviceid,'memberships_id'=>$memberidvals,'periods_id'=>$periodid,'BeforeTotal'=>$beforetax,'Tax'=>$tax,'TotalAmount'=>$grandtotal,'DiscountServicePercent'=>$discountper,'DiscountServiceAmount'=>$discountamount]);

                            $applicationhd->consolidate()->attach($memberidvals,
                            ['services_id'=>$serviceid,'periods_id'=>$periodid,'RegistrationDate'=>$regdatecons,'ExpiryDate'=>$expirydatecons,'type'=>1,'Status'=>$statusvalcons,'devices_id'=>1]);
                        }
                    }

                    if(($oldapptype == "New" || $oldapptype == "Renew") && ($applicationtypevar == "New" || $applicationtypevar == "Renew")){
                       

                        foreach ($request->rowm as $key => $value)
                        {
                            $headeridsval = $request->applicationId;
                            $loyaltystatus = "";
                            $memberid = $value['member_id'];
                            $memcnt = $value['MemberCount'];
                            $loyaltyst = $value['LoyalityStatus'];
                            $staydays = $value['StayDay'];
                            $staydayrenews = $value['StayDayRenew'];
                            $memprop = membership::where('id',$memberid)->first();
                            $initialdt = $memprop->InitialStayDay;
                            $initialdt = !empty($initialdt) ? $initialdt : 0;

                            if($applicationtypevar == "New"){
                                $totalstayday = $staydays + $paymentval + $initialdt;
                                $updateloyalty = DB::select('UPDATE memberships SET memberships.LoyalityStatus = (SELECT loyaltystatuses.LoyalityStatus FROM loyaltystatuses WHERE '.$totalstayday.' BETWEEN loyaltystatuses.MinDay AND loyaltystatuses.MaxDay ORDER BY id DESC LIMIT 1) WHERE memberships.id='.$memberid);
                                
                                $getloyalstatus = DB::select('SELECT loyaltystatuses.LoyalityStatus FROM loyaltystatuses WHERE '.$totalstayday.' BETWEEN loyaltystatuses.MinDay AND loyaltystatuses.MaxDay ORDER BY id DESC LIMIT 1');
                                foreach($getloyalstatus as $row)
                                {
                                    $loyaltystatus=$row->LoyalityStatus;
                                }
                            }

                            else if($applicationtypevar == "Renew"){
                                $totalstayday = $staydayrenews + $paymentval + $initialdt;
                                $updateloyalty = DB::select('UPDATE memberships SET memberships.LoyalityStatus=(SELECT loyaltystatuses.LoyalityStatus FROM loyaltystatuses WHERE '.$totalstayday.' BETWEEN loyaltystatuses.MinDay AND loyaltystatuses.MaxDay ORDER BY id DESC LIMIT 1) WHERE memberships.id='.$memberid);
                                
                                $getloyalstatus = DB::select('SELECT loyaltystatuses.LoyalityStatus FROM loyaltystatuses WHERE '.$totalstayday.' BETWEEN loyaltystatuses.MinDay AND loyaltystatuses.MaxDay ORDER BY id DESC LIMIT 1');
                                foreach($getloyalstatus as $row)
                                {
                                    $loyaltystatus = $row->LoyalityStatus;
                                }
                            }
                            
                            if(in_array($memberid,$memarr)){
                                $updateappmember=appmember::where('applications_id',$request->applicationId)->where('memberships_id',$memberid)->update(['IsMemberBefore'=>$memcnt,'LoyalityStatus'=>$loyaltystatus,'OldLoyalityStatus'=>$loyaltyst]);
                            }

                            if(!in_array($memberid,$memarr)){
                                $mem = new appmember;
                                $mem->applications_id = $request->applicationId;
                                $mem->memberships_id = $memberid;
                                $mem->IsMemberBefore = $memcnt;
                                $mem->Status = $updatestatus;
                                $mem->LoyalityStatus = $loyaltystatus;
                                $mem->OldLoyalityStatus = $loyaltyst;
                                $mem->save();
                            }
                            
                            $delmemberid[]=$memberid;
                        }
                       

                        foreach ($request->row as $key => $value)
                        {
                            $headerids=$request->applicationId;
                            $serviceid=$value['service_id'];
                            $periodid=$value['period_id'];
                            $beforetax=$value['BeforeTax'];
                            $tax=$value['Tax'];
                            $grandtotal=$value['GrandTotal'];
                            $discountper=$value['Discount'];
                            $discountamount=$value['DiscountAmount'];
                            $deviceid=$value['AccessControl'];
                            if(in_array($serviceid,$servarr)){
                                $updateservice=appservice::where('applications_id',$request->applicationId)->where('services_id',$serviceid)->update(['periods_id'=>$periodid,'BeforeTotal'=>$beforetax,'Tax'=>$tax,'TotalAmount'=>$grandtotal,'DiscountServicePercent'=>$discountper,'DiscountServiceAmount'=>$discountamount,'devices_id'=>$deviceid]);
                            }
                            if(!in_array($serviceid,$servarr)){
                                $serv=new appservice;
                                $serv->applications_id=$request->applicationId;
                                $serv->services_id=$serviceid;
                                $serv->periods_id=$periodid;
                                $serv->BeforeTotal=$beforetax;
                                $serv->Tax=$tax;
                                $serv->TotalAmount=$grandtotal;
                                $serv->DiscountServicePercent=$discountper;
                                $serv->DiscountServiceAmount=$discountamount;
                                $serv->devices_id=$deviceid;
                                $serv->save();
                            }
                            $delserviceid[]=$serviceid;
                        }

                        foreach ($request->rowm as $memkey => $memvalue){
                            $memberidvals=$memvalue['member_id'];
                            foreach ($request->row as $key => $value)
                            {
                                $headerids=$request->applicationId;
                                $serviceidcons=$value['service_id'];
                                $periodidcons=$value['period_id'];
                                $regdatecons=$request->RegistationDate;
                                $expirydatecons=$request->ExpiryDate;
                                $statusvalcons="Pending";
                                $deviceid=$value['AccessControl'];
                                if(in_array($memberidvals,$memarr)){
                                    $updateappmembers=appconsolidate::where('applications_id',$request->applicationId)->where('memberships_id',$memberidvals)->update(['RegistrationDate'=>$regdatecons,'ExpiryDate'=>$expirydatecons,'Status'=>$updatestatus]);
                                }
                                if(in_array($serviceidcons,$servarr)){
                                    $updateappservice=appconsolidate::where('applications_id',$request->applicationId)->where('services_id',$serviceidcons)->update(['RegistrationDate'=>$regdatecons,'ExpiryDate'=>$expirydatecons,'Status'=>$updatestatus]);
                                }
                                if(!in_array($memberidvals,$memarr)){
                                    $appcon=new appconsolidate;
                                    $appcon->applications_id=$request->applicationId;
                                    $appcon->memberships_id=$memberidvals;
                                    $appcon->services_id=$serviceidcons;
                                    $appcon->periods_id=$periodidcons;
                                    $appcon->RegistrationDate=$regdatecons;
                                    $appcon->ExpiryDate=$expirydatecons;
                                    $appcon->Status=$updatestatus;
                                    $appcon->devices_id=$deviceid;
                                    $appcon->save();
                                }
                                if(!in_array($serviceidcons,$servarr)){
                                    $appconserv=new appconsolidate;
                                    $appconserv->applications_id=$request->applicationId;
                                    $appconserv->memberships_id=$memberidvals;
                                    $appconserv->services_id=$serviceidcons;
                                    $appconserv->periods_id=$periodidcons;
                                    $appconserv->RegistrationDate=$regdatecons;
                                    $appconserv->ExpiryDate=$expirydatecons;
                                    $appconserv->Status=$updatestatus;
                                    $appcon->devices_id=$deviceid;
                                    $appconserv->save();
                                }
                                $delserviconid[]=$serviceidcons;
                            }
                            $delmemberconid[]=$memberidvals;
                        }
                        $memidvals=implode(',', $delmemberid);
                        $updateloyaltymem=DB::select('UPDATE appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id SET memberships.LoyalityStatus=appmembers.OldLoyalityStatus WHERE memberships.id NOT IN('.$memidvals.') AND appmembers.applications_id='.$request->applicationId);
                        appmember::where('applications_id',$request->applicationId)->whereNotIn('memberships_id',$delmemberid)->delete();
                        appservice::where('applications_id',$request->applicationId)->whereNotIn('services_id',$delserviceid)->delete();
                        appconsolidate::where('applications_id',$request->applicationId)->whereNotIn('memberships_id',$delmemberconid)->delete();
                        appconsolidate::where('applications_id',$request->applicationId)->whereNotIn('services_id',$delserviconid)->delete();
                    }

                    if($oldapptype=="Trainer-Fee" && $applicationtypevar=="Trainer-Fee"){
                        foreach ($request->rowTrn as $keytr => $trvalue)
                        {
                            $headerids=$request->applicationId;
                            $employeid=$trvalue['employes_id'];
                            $memberidvals=$trvalue['member_id'];
                            $serviceid=$trvalue['service_id'];
                            $periodid=$trvalue['period_id'];
                            $beforetax=$trvalue['BeforeTax'];
                            $tax=$trvalue['Tax'];
                            $grandtotal=$trvalue['GrandTotal'];
                            $discountper=$trvalue['Discount'];
                            $discountamount=$trvalue['DiscountAmount'];
                            $regdatecons=$request->RegistationDate;
                            $expirydatecons=$request->ExpiryDate;
                            if(in_array($serviceid,$servlisttrarr)){
                                $updatesrvlist=apptrainers::where('applications_id',$request->applicationId)->where('services_id',$serviceid)->update(['employes_id'=>$employeid,'memberships_id'=>$memberidvals,'periods_id'=>$periodid,'BeforeTotal'=>$beforetax,'Tax'=>$tax,'TotalAmount'=>$grandtotal,'DiscountServicePercent'=>$discountper,'DiscountServiceAmount'=>$discountamount]);
                                $updateconslist=appconsolidate::where('applications_id',$request->applicationId)->where('services_id',$serviceid)->update(['memberships_id'=>$memberidvals,'periods_id'=>$periodid,'RegistrationDate'=>$regdatecons,'ExpiryDate'=>$expirydatecons,'type'=>1,'Status'=>$updatestatus,'devices_id'=>1]);
                            }
                            if(!in_array($serviceid,$servlisttrarr)){
                                $apptrn=new apptrainers;
                                $apptrn->applications_id=$request->applicationId;
                                $apptrn->memberships_id=$memberidvals;
                                $apptrn->services_id=$serviceid;
                                $apptrn->periods_id=$periodid;
                                $apptrn->employes_id=$employeid;
                                $apptrn->BeforeTotal=$beforetax;
                                $apptrn->Tax=$tax;
                                $apptrn->TotalAmount=$grandtotal;
                                $apptrn->DiscountServicePercent=$discountper;
                                $apptrn->DiscountServiceAmount=$discountamount;
                                $apptrn->devices_id=1;
                                $apptrn->save();

                                $appcons=new appconsolidate;
                                $appcons->applications_id=$request->applicationId;
                                $appcons->memberships_id=$memberidvals;
                                $appcons->services_id=$serviceid;
                                $appcons->periods_id=$periodid;
                                $appcons->RegistrationDate=$regdatecons;
                                $appcons->ExpiryDate=$expirydatecons;
                                $appcons->Status=$updatestatus;
                                $appcons->devices_id=1;
                                $appcons->save();
                            }
                            $delservicontrid[]=$serviceid;
                        }
                        apptrainers::where('applications_id',$request->applicationId)->whereNotIn('services_id',$delservicontrid)->delete();
                        appconsolidate::where('applications_id',$request->applicationId)->whereNotIn('services_id',$delservicontrid)->delete();
                    }

                   

                    if($updatestatus=="Verified"){
                        
                        $devids=implode(',', $deviceids);
                        $delmembers=implode(',', $memidarr);
                        
                        $getalldevice=DB::select('SELECT DISTINCT * FROM devices WHERE devices.Status="Active" AND devices.id IN ('.$devids.') UNION SELECT DISTINCT * FROM devices WHERE devices.Status="Active" AND devices.devicetype IN (3)');
                        foreach($getalldevice as $devrow)
                        {
                            $topic="mqtt/face/".$devrow->DeviceId;
                            $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                            
                            $msgs='{
                                "messageId":"MessageID-DeletePerson-'.$mquuid.'",
                                "DataBegin":"BeginFlag",
                                "operator": "DeletePersons",
                                "PersonNum":"'.$memcounts.'",
                                "info":
                                {
                                    "facesluiceId":"'.$devrow->DeviceId.'",
                                    "customId":"['.$delmembers.']",                             
                                },
                                "DataEnd":"EndFlag"
                            }';
                            $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                if ($elapsedTime >= 8) {
                                    $mqtts->interrupt();
                                }
                            });
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$mquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
                            $mqtt->publish($topic,$msgs,2);
                            $mqtt->loop(true);
                        }

                        $getallclients=DB::select('SELECT appconsolidates.memberships_id AS MemberIdVal,memberships.*,memberships.Status AS MemberStatus,periods.PeriodName,(SELECT perioddetails.FirstHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfFrom,(SELECT perioddetails.FirstHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfTo,(SELECT perioddetails.SecondHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfFrom,(SELECT perioddetails.SecondHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfTo,appconsolidates.devices_id,devices.*,applications.RegistrationDate,applications.ExpiryDate,applications.Status FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN devices ON appconsolidates.devices_id=devices.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE applications.Status IN("Verified") AND appconsolidates.applications_id='.$request->applicationId);
                        foreach($getallclients as $row)
                        {
                            if($row->LeftThumb==null || $row->LeftThumb==""){
                                $leftthumb="";
                            }
                            if($row->LeftThumb!=null && $row->LeftThumb!=""){
                                $leftthumb=$row->LeftThumb;
                            }

                            if($row->LeftIndex==null || $row->LeftIndex==""){
                                $leftindex="";
                            }
                            if($row->LeftIndex!=null && $row->LeftIndex!=""){
                                $leftindex=$row->LeftIndex;
                            }

                            if($row->LeftMiddle==null || $row->LeftMiddle==""){
                                $leftmiddle="";
                            }
                            if($row->LeftMiddle!=null && $row->LeftMiddle!=""){
                                $leftmiddle=$row->LeftMiddle;
                            }

                            if($row->LeftRing==null || $row->LeftRing==""){
                                $leftring="";
                            }
                            if($row->LeftRing!=null && $row->LeftRing!=""){
                                $leftring=$row->LeftRing;
                            }

                            if($row->LeftPinky==null || $row->LeftPinky==""){
                                $leftpicky="";
                            }
                            if($row->LeftPinky!=null && $row->LeftPinky!=""){
                                $leftpicky=$row->LeftPinky;
                            }

                            if($row->RightThumb==null || $row->RightThumb==""){
                                $rightthumb="";
                            }
                            if($row->RightThumb!=null && $row->RightThumb!=""){
                                $rightthumb=$row->RightThumb;
                            }

                            if($row->RightIndex==null || $row->RightIndex==""){
                                $rightindex="";
                            }
                            if($row->RightIndex!=null && $row->RightIndex!=""){
                                $rightindex=$row->RightIndex;
                            }

                            if($row->RightMiddle==null || $row->RightMiddle==""){
                                $rightmiddle="";
                            }
                            if($row->RightMiddle!=null && $row->RightMiddle!=""){
                                $rightmiddle=$row->RightMiddle;
                            }

                            if($row->RightRing==null || $row->RightRing==""){
                                $rightring="";
                            }
                            if($row->RightRing!=null && $row->RightRing!=""){
                                $rightring=$row->RightRing;
                            }

                            if($row->RightPinky==null || $row->RightPinky==""){
                                $rightpicky="";
                            }
                            if($row->RightPinky!=null && $row->RightPinky!=""){
                                $rightpicky=$row->RightPinky;
                            }

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

                            // if($meridiam=="AM"){
                            //     if($row->FirstHalfFrom==null || $row->FirstHalfFrom==""){
                            //         $starttime="11:59:59";
                            //     }
                            //     if($row->FirstHalfFrom!=null && $row->FirstHalfFrom!=""){
                            //         $starttime=$row->FirstHalfFrom.":00";
                            //     }

                            //     if($row->FirstHalfTo==null || $row->FirstHalfTo==""){
                            //         $endtime="11:59:59";
                            //     }
                            //     if($row->FirstHalfTo!=null && $row->FirstHalfTo!=""){
                            //         $endtime=$row->FirstHalfTo.":59";
                            //     }
                            // }
                            // if($meridiam=="PM"){
                            //     if($row->SecondHalfFrom==null || $row->SecondHalfFrom==""){
                            //         $starttime="23:59:59";
                            //     }
                            //     if($row->SecondHalfFrom!=null && $row->SecondHalfFrom!=""){
                            //         $starttime=$row->SecondHalfFrom.":00";
                            //     }

                            //     if($row->SecondHalfTo==null || $row->SecondHalfTo==""){
                            //         $endtime="23:59:59";
                            //     }
                            //     if($row->SecondHalfTo!=null && $row->SecondHalfTo!=""){
                            //         $endtime=$row->SecondHalfTo.":59";
                            //     }
                            // }

                            if($row->Gender=="Male"){
                                $gender=0;
                                if($row->Picture==null){
                                    $picdata="dummymale.jpg";
                                }
                            }
                            if($row->Gender=="Female"){
                                $gender=1;
                                if($row->Picture==null){
                                    $picdata="dummyfemale.jpg";
                                }
                            }

                            if($row->MemberStatus=="Active"){
                                $persontype=0;
                            }
                            if($row->MemberStatus!="Active"){
                                $persontype=1;
                            }

                            if($row->Picture!=null){
                                $imagepath = public_path().'/storage/uploads/MemberPicture/'.$row->Picture;
                                //$picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                                $picdata=$row->Picture;
                            }

                            // if($row->Picture==null){
                            //     $picdata=$defpic;
                            // }

                            $topic="mqtt/face/".$row->DeviceId;
                            $topicrec="mqtt/face/".$row->DeviceId."/Ack";

                            $msgs='{
                                "operator": "EditPerson",
                                "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                                "info":
                                {
                                    "facesluiceId":"'.$row->DeviceId.'",
                                    "customId":"'.$row->MemberIdVal.'",
                                    "tempCardType":2,
                                    "personType":"'.$persontype.'",
                                    "name":"'.$row->Name.'",
                                    "gender":"'.$gender.'",
                                    "birthday":"'.$row->DOB.'",
                                    "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                                    "address":"'.$row->Location.'",
                                    "PersonUUID":"'.$row->PersonUUID.'",
                                    "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                    "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                                    "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                            
                                },
                            }';
                            $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                if ($elapsedTime >= 8) {
                                    $mqtts->interrupt();
                                }
                            });
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$mquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
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
                                    "PersonUUID":"'.$row->MemberIdVal.'",
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
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$fpmquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
                            $mqtt->publish($topic,$fpmsgs,2);
                            $mqtt->loop(true);

                            // $resmsgs='{
                            //     "operator": "RebootDevice",
                            //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                            //     "info":
                            //     {
                            //         "facesluiceId":"'.$devid.'",
                            //     },
                            // }';     
                            // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            //     if ($elapsedTime >= 8) {
                            //         $mqtts->interrupt();
                            //     }
                            // });
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$mquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
                            // $mqtt->publish($topic,$resmsgs,2);
                            // $mqtt->loop(true);

                            $getexitdevice=DB::select('SELECT * FROM devices WHERE devices.Status="Active" AND devices.devicetype=3');
                            foreach($getexitdevice as $devrow)
                            {
                                $topic="mqtt/face/".$devrow->DeviceId;
                                $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                                
                                $msgs='{
                                    "operator": "EditPerson",
                                    "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                                    "info":
                                    {
                                        "facesluiceId":"'.$devrow->DeviceId.'",
                                        "customId":"'.$row->MemberIdVal.'",
                                        "tempCardType":2,
                                        "personType":"'.$persontype.'",
                                        "name":"'.$row->Name.'",
                                        "gender":"'.$gender.'",
                                        "birthday":"'.$row->DOB.'",
                                        "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                                        "address":"'.$row->Location.'",
                                        "PersonUUID":"'.$row->PersonUUID.'",
                                        "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                        "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                                        "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                             
                                    },
                                }';
                                $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                    if ($elapsedTime >= 8) {
                                        $mqtts->interrupt();
                                    }
                                });
                                // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                                //     $mqt->userid=$userid;
                                //     $mqt->uuid=$mquuid;
                                //     $mqt->message=$message;
                                //     $mqt->save();
                                // }, 2);
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
                                        "PersonUUID":"'.$row->MemberIdVal.'",
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
                                // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                                //     $mqt->userid=$userid;
                                //     $mqt->uuid=$fpmquuid;
                                //     $mqt->message=$message;
                                //     $mqt->save();
                                // }, 2);
                                $mqtt->publish($topic,$fpmsgs,2);
                                $mqtt->loop(true);

                                // $resmsgs='{
                                //     "operator": "RebootDevice",
                                //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                                //     "info":
                                //     {
                                //         "facesluiceId":"'.$devid.'",
                                //     },
                                // }';     
                                // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                //     if ($elapsedTime >= 8) {
                                //         $mqtts->interrupt();
                                //     }
                                // });
                                // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                                //     $mqt->userid=$userid;
                                //     $mqt->uuid=$mquuid;
                                //     $mqt->message=$message;
                                //     $mqt->save();
                                // }, 2);
                                // $mqtt->publish($topic,$resmsgs,2);
                                // $mqtt->loop(true);

                            }
                        }
                        $mqtt->disconnect();
                    }
                    return Response::json(['success' =>1]);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }

            if($validator->fails())
            {
                return Response::json(['errors'=> $validator->errors()]);
            }
            if($v2->fails())
            {
                return response()->json(['errorv2'=> $v2->errors()->all()]);
            }
            if($v3->fails())
            {
                return response()->json(['errorv3'=> $v3->errors()->all()]);
            }
            if($v4->fails())
            {
                return response()->json(['errorv4'=> $v4->errors()->all()]);
            }
            if($emptytblerr>=1){
                return Response::json(['emptymemerror'=>"error"]);
            }
            if($emptyserverr>=1){
                return Response::json(['emptyerror'=>"error"]);
            }
            if($emptytrainerr>=1){
                return Response::json(['emptytrerror'=>"error"]);
            }
            if($renewmembercnt>=2){
                return Response::json(['renewmemerr'=>"error"]);
            }
            if($renewcount>=1){
                $getrenewedmember=DB::select('SELECT CONCAT(IFNULL(memberships.MemberId,"")," ",IFNULL(memberships.Name,"")) AS MemberName FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE appconsolidates.memberships_id IN('.$memimp.') AND applications.Status NOT IN("Void","Refund") AND appconsolidates.services_id IN('.$serimp.') AND applications.paymentterms_id!=5 AND appconsolidates.applications_id>'.$appidvar);
                return Response::json(['renewcount'=>"error",'memberlists'=>$getrenewedmember]);
            }
            if($expirydate<=$curentdate){
                return Response::json(['expirydateerror'=>"error"]);
            }
            if($regmember!=$groupval && ($applicationtypevar=="New"||$applicationtypevar=="Renew")){
                return Response::json(['memerror'=>"error"]);
            }
            if($membertotalcnt>=1){
                $mem=implode(',', $listofmem);
                $serv=implode(',', $listofserv);
                $prd=implode(',', $listofperiod);
                $getduplicatemember=DB::select('SELECT DISTINCT CONCAT(memberships.Name,"  ,  ",services.ServiceName,"  ,  ",periods.PeriodName) AS MemberService FROM appservices INNER JOIN applications ON appservices.applications_id=applications.id INNER JOIN appmembers ON appmembers.applications_id=applications.id INNER JOIN memberships ON appmembers.memberships_id=memberships.id INNER JOIN services ON appservices.services_id=services.id INNER JOIN periods ON appservices.periods_id=periods.id WHERE appmembers.memberships_id IN('.$mem.') AND appservices.services_id IN('.$serv.') AND appservices.periods_id IN('.$prd.') AND applications.Status IN("Pending","Active")');
                return Response::json(['duperror'=>"error",'duperrorname'=>$getduplicatemember]);
            }
            if($frmembertotalcnt>=1){
                $frmem=implode(',', $frlistofmem);
                $frserv=implode(',', $frlistofserv);
                $frprd=implode(',', $frlistofperiod);
                $getfrozenservices=DB::select('SELECT memberships.Name,services.ServiceName,periods.PeriodName FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN periods ON appconsolidates.periods_id=periods.id WHERE appconsolidates.memberships_id IN('.$frmem.') AND appconsolidates.services_id IN('.$frserv.') AND appconsolidates.periods_id IN('.$frprd.') AND appconsolidates.Status="Frozen"');
                return Response::json(['frerror'=>"error",'frerrorname'=>$getfrozenservices]);
            }
            if($exmembertotalcnt>=1){
                $exmem=implode(',', $exlistofmem);
                $exserv=implode(',', $exlistofserv);
                $exprd=implode(',', $exlistofperiod);
                $getextendedmember=DB::select('SELECT memberships.Name,services.ServiceName,periods.PeriodName FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.memberships_id IN('.$exmem.') AND appconsolidates.services_id IN('.$exserv.') AND appconsolidates.periods_id IN('.$exprd.') AND applications.RenewParentId='.$appidvar.' AND applications.Status IN("Pending","Active")');
                return Response::json(['exerror'=>"error",'exerrorname'=>$getextendedmember]);
            }
        }

        if($findid==null){

            $validator = Validator::make($request->all(), [
                'ApplicationType' => ['required'],
                'ApplicationsId' => ['required_if:ApplicationType,Renew'],
                'Group' => ['required'],
                'PaymentTerm' => ['required'],
                'Pos' => ['required'],
                'VoucherType' => ['required'],
                'PaymentType' => ['required'],
                'VoucherNumber' => ['required',Rule::unique('applications')->where(function ($query) use($mrcnum){
                        return $query->where('Mrc', $mrcnum)
                        ->where('IsVoid',0);
                    })->ignore($findid)
                ],
                'InvoiceNumber' => ['nullable',Rule::unique('applications')->where(function ($query) use($mrcnum){
                        return $query->where('Mrc', $mrcnum)
                        ->where('IsVoid',0);
                    })->ignore($findid)
                ],
                'mrc' => ['required_if:VoucherType,Fiscal-Receipt'],
                'RegistationDate' => ['required'],
                'ExpiryDate' => ['required','after:now'],
                'date' => ['required','before:now'],
            ]);

            $rules=array(
                'rowm.*.member_id' => 'required',
            );

            $servicerules=array(
                'row.*.service_id' => 'required|numeric',
                'row.*.period_id' => 'required|numeric',
                'row.*.BeforeTax' => 'required|numeric',
                'row.*.Tax' => 'required|numeric',
                'row.*.GrandTotal' => 'required|numeric',
                'row.*.AccessControl' => 'required',
            );

            $trainerrule=array(
                'rowTrn.*.member_id' => 'required',
                'rowTrn.*.employes_id' => 'required',
                'rowTrn.*.service_id' => 'required',
                'rowTrn.*.BeforeTax' => 'required|numeric',
                'rowTrn.*.Tax' => 'required|numeric',
                'rowTrn.*.GrandTotal' => 'required|numeric',
            );

            $v2= Validator::make($request->all(), $rules);
            $v3= Validator::make($request->all(), $servicerules);
            $v4= Validator::make($request->all(), $trainerrule);

            if($request->rowm!=null && $request->row!=null){
                foreach ($request->rowm as $memkey => $memvalue){
                    if (empty($memvalue['member_id'])) {
                        $memidv=null;
                        $memarr[]=null;
                    }
                    else if(!empty($memvalue['member_id'])){
                        $memidv=$memvalue['member_id'];
                        $memarr[]=$memvalue['member_id'];
                    }
                    foreach ($request->row as $key => $value){
                        if (empty($value['service_id'])) {
                            $serviceid=null;
                            $serarr[]=null;
                        }
                        else if(!empty($value['service_id'])){
                            $serviceid=$value['service_id'];
                            $serarr[]=$value['service_id'];
                        }
                        if (empty($value['period_id'])) {
                            $periodid=null;
                        }
                        else if(!empty($value['period_id'])){
                            $periodid=$value['period_id'];
                        }
                        if($periodid!=null && $serviceid!=null && $memidv!=null && $request->RegistationDate!=null){
                            $getmemberval=DB::select('SELECT COUNT(appconsolidates.id) AS MemberCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.ApplicationType!="Trainer-Fee" AND appconsolidates.memberships_id='.$memidv.' AND appconsolidates.services_id='.$serviceid.' AND appconsolidates.periods_id='.$periodid.' AND appconsolidates.ExpiryDate>"'.$request->RegistationDate.'" AND appconsolidates.Status IN("Pending","Active")');
                            foreach ($getmemberval as $getmemberval) {
                                $membercnt = $getmemberval->MemberCount;
                                if($membercnt>=1){
                                    $membertotalcnt+=1;
                                    $listofmem[]=$memidv;
                                    $listofserv[]=$serviceid;
                                    $listofperiod[]=$periodid;
                                }
                            }
                                
                            if($applicationtypehidden=="Renew"){
                                $getextendedmember=DB::select('SELECT COUNT(appconsolidates.id) AS MemberExtendedCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.memberships_id='.$memidv.' AND appconsolidates.services_id='.$serviceid.' AND appconsolidates.periods_id='.$periodid.' AND applications.RenewParentId='.$appidvar.' AND appconsolidates.type=0 AND applications.Status IN("Pending","Active")');
                                foreach ($getextendedmember as $getextendedmember) {
                                    $exmembercnt = $getextendedmember->MemberExtendedCount;
                                    if($exmembercnt>=1){
                                        $exmembertotalcnt+=1;
                                        $exlistofmem[]=$memidv;
                                        $exlistofserv[]=$serviceid;
                                        $exlistofperiod[]=$periodid;
                                    }
                                }

                                $appmembersdata=DB::select('SELECT DISTINCT appconsolidates.memberships_id FROM appconsolidates WHERE appconsolidates.applications_id='.$appidvar);
                                foreach ($appmembersdata as $rows) {
                                    $oldmembers[] = $rows->memberships_id;
                                }

                                foreach ($request->rowm as $key => $value)
                                {
                                    $memberid=$value['member_id'];
                                    if(!in_array($memberid,$oldmembers)){
                                        $notfound+=1;
                                        $rennewmembers[]=$memberid;
                                    }
                                    $numofmem+=1;
                                }
                                if($notfound==$numofmem){
                                    $renewflag=1;
                                }
                            }

                            $getfrozenmember=DB::select('SELECT COUNT(appconsolidates.id) AS MemberFrozenCount FROM appconsolidates WHERE appconsolidates.memberships_id='.$memidv.' AND appconsolidates.services_id='.$serviceid.' AND appconsolidates.periods_id='.$periodid.' AND appconsolidates.Status IN("Frozen")');
                            foreach ($getfrozenmember as $getfrozenmember) {
                                $frmembercnt = $getfrozenmember->MemberFrozenCount;
                                if($frmembercnt>=1){
                                    $frmembertotalcnt+=1;
                                    $frlistofmem[]=$memidv;
                                    $frlistofserv[]=$serviceid;
                                    $frlistofperiod[]=$periodid;
                                }
                            }
                        }
                    }
                    $regmember+=1;
                }

                $memimp=implode(',', $memarr);
                $serimp=implode(',', $serarr);
                if($memimp!=null && $serimp!=null){
                    if($applicationtypevar=="New"){
                        $getmembersinformation=DB::select('SELECT COUNT(DISTINCT applications.id) AS MemberCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.memberships_id IN('.$memimp.') AND applications.Status NOT IN("Void","Refund") AND appconsolidates.services_id IN('.$serimp.') AND appconsolidates.applications_id!='.$appidvar);
                        foreach ($getmembersinformation as $memrow) {
                            $renewmembercnt=$memrow->MemberCount;
                        }
                    }

                    if($applicationtypevar=="Renew"){
                        $getrenewedmember=DB::select('SELECT COUNT(DISTINCT applications.id) AS RenewMemberCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.memberships_id IN('.$memimp.') AND applications.Status NOT IN("Void","Refund") AND appconsolidates.services_id IN('.$serimp.') AND applications.paymentterms_id!=5 AND appconsolidates.applications_id>'.$appidvar);
                        foreach ($getrenewedmember as $renmem) {
                            $renewcount=$renmem->RenewMemberCount;
                        }
                    }
                }
            }

            if($applicationtypevar=="New"||$applicationtypevar=="Renew"){
                if($request->rowm==null){
                    $emptytblerr=1;
                }
                if($request->row==null){
                    $emptyserverr=1;
                }
            }

            if($applicationtypevar=="Trainer-Fee"){
                if($request->rowTrn==null){
                    $emptytrainerr=1;
                }
                $regmember=0;
                $groupval=0;
            }

            if($validator->passes() && $v2->passes() && $v3->passes() && $v4->passes() && $expirydate>=$curentdate && $regmember==$groupval && $membertotalcnt==0 && $frmembertotalcnt==0 && $exmembertotalcnt==0 && $emptytblerr==0 && $notfound==0 && $renewmembercnt<=1 && $renewcount==0){
                try
                {
                    if ($request->file('ApplicationDocument')) {
                        $file = $request->file('ApplicationDocument');
                        $fn = $file->getClientOriginalName();
                        $name = explode('.', $fn)[0]; // Filename 'filename'
                        $documentnames = preg_replace('/\s+/', '-', $name);
                        $applicationdocfile = time() . '.' . $request->file('ApplicationDocument')->extension();
                        $pathIdentification = public_path() . '/storage/uploads/ApplicationDocuments';
                        $pathnameIdentification='/storage/uploads/ApplicationDocuments/'.$applicationdocfile;
                        $file->move($pathIdentification, $applicationdocfile);
                    }
                    if($request->file('ApplicationDocument')==''){
                        $applicationdocfile=$request->applicationdocumentupdate;
                    }
                    
                    $applicationhd=ApplicationForm::updateOrCreate(['id' => $request->applicationId], [
                        'ApplicationType' => $request->ApplicationType,
                        'RenewParentId' => $appidvar,
                        'ApplicationNumber' => $applicationNumbers,
                        'groupmembers_id' => $request->Group,
                        'paymentterms_id' => $request->PaymentTerm,
                        'stores_id' => $request->Pos,
                        'Type' => $type,
                        'RegistrationDate' =>$request->RegistationDate,
                        'ExpiryDate' => $request->ExpiryDate,
                        'VoucherType' => $request->VoucherType,
                        'Mrc' => $request->mrc,
                        'PaymentType' => $request->PaymentType,
                        'VoucherNumber' => $request->VoucherNumber,
                        'InvoiceNumber' => $request->InvoiceNumber,
                        'InvoiceDate' => $request->date,
                        'SubTotal' => $request->subtotali,
                        'TotalTax' => $request->taxi,
                        'GrandTotal' => $request->grandtotali,
                        'DiscountPercent' => $request->discountper,
                        'DiscountAmount' => $request->discounti,
                        'PreparedBy' => $user,
                        'PreparedDate' => Carbon::today()->toDateString(),
                        'IsVoid'=> 0,
                        'Memo' => $request->Memo,
                        'DocumentUploadPath'=>$applicationdocfile,
                        'DocumentOriginalName'=>$documentnames,
                        'FiscalYear' => $fyear,
                        'Status' =>"Pending",
                    ]);

                    if($applicationtypevar == "New" || $applicationtypevar == "Renew"){
                        foreach ($request->rowm as $key => $value)
                        {
                            $loyaltystatus="";
                            $headeridsval=$request->applicationId;
                            $memberid=$value['member_id'];
                            $memcnt=$value['MemberCount'];
                            $loyaltyst=$value['LoyalityStatus'];
                            $staydays=$value['StayDay'];
                            $staydayrenews=$value['StayDayRenew'];
                            $memprop = membership::where('id',$memberid)->first();
                            $initialdt=$memprop->InitialStayDay;
                            $initialdt = !empty($initialdt) ? $initialdt : 0;

                            if($applicationtypevar=="New"){
                                $totalstayday=$staydays+$paymentval+$initialdt;
                                $updateloyalty=DB::select('UPDATE memberships SET memberships.LoyalityStatus=(SELECT loyaltystatuses.LoyalityStatus FROM loyaltystatuses WHERE '.$totalstayday.' BETWEEN loyaltystatuses.MinDay AND loyaltystatuses.MaxDay ORDER BY id DESC LIMIT 1) WHERE memberships.id='.$memberid);
                                
                                $getloyalstatus=DB::select('SELECT loyaltystatuses.LoyalityStatus FROM loyaltystatuses WHERE '.$totalstayday.' BETWEEN loyaltystatuses.MinDay AND loyaltystatuses.MaxDay ORDER BY id DESC LIMIT 1');
                                foreach($getloyalstatus as $row)
                                {
                                    $loyaltystatus=$row->LoyalityStatus;
                                }
                            }

                            else if($applicationtypevar=="Renew"){
                                $totalstayday=$staydayrenews+$paymentval+$initialdt;
                                $updateloyalty=DB::select('UPDATE memberships SET memberships.LoyalityStatus=(SELECT loyaltystatuses.LoyalityStatus FROM loyaltystatuses WHERE '.$totalstayday.' BETWEEN loyaltystatuses.MinDay AND loyaltystatuses.MaxDay ORDER BY id DESC LIMIT 1) WHERE memberships.id='.$memberid);
                                
                                $getloyalstatus=DB::select('SELECT loyaltystatuses.LoyalityStatus FROM loyaltystatuses WHERE '.$totalstayday.' BETWEEN loyaltystatuses.MinDay AND loyaltystatuses.MaxDay ORDER BY id DESC LIMIT 1');
                                foreach($getloyalstatus as $row)
                                {
                                    $loyaltystatus=$row->LoyalityStatus;
                                }
                            }
                            
                            $applicationhd->memb()->attach($memberid,['IsMemberBefore'=>$memcnt,'Status'=>"Pending",'LoyalityStatus'=>$loyaltystatus,'OldLoyalityStatus'=>$loyaltyst]);
                        }

                        foreach ($request->row as $key => $value)
                        {
                            $headerids=$request->applicationId;
                            $serviceid=$value['service_id'];
                            $periodid=$value['period_id'];
                            $beforetax=$value['BeforeTax'];
                            $tax=$value['Tax'];
                            $grandtotal=$value['GrandTotal'];
                            $discountper=$value['Discount'];
                            $discountamount=$value['DiscountAmount'];
                            $deviceid=$value['AccessControl'];
                            $applicationhd->serv()->attach($serviceid,
                            ['periods_id'=>$periodid,'BeforeTotal'=>$beforetax,'Tax'=>$tax,'TotalAmount'=>$grandtotal,'DiscountServicePercent'=>$discountper,'DiscountServiceAmount'=>$discountamount,'devices_id'=>$deviceid]);
                        }

                        foreach ($request->rowm as $memkey => $memvalue){
                            $memberidvals=$memvalue['member_id'];
                            foreach ($request->row as $key => $value)
                            {
                                $headerids=$request->applicationId;
                                $serviceidcons=$value['service_id'];
                                $periodidcons=$value['period_id'];
                                $regdatecons=$request->RegistationDate;
                                $expirydatecons=$request->ExpiryDate;
                                $statusvalcons="Pending";
                                $deviceid=$value['AccessControl'];
                                $applicationhd->consolidate()->attach($memberidvals,
                                ['services_id'=>$serviceidcons,'periods_id'=>$periodidcons,'RegistrationDate'=>$regdatecons,'ExpiryDate'=>$expirydatecons,'Status'=>$statusvalcons,'devices_id'=>$deviceid]);
                            }
                        }
                    }

                    else if($applicationtypevar=="Trainer-Fee"){
                        foreach ($request->rowTrn as $keytr => $trvalue)
                        {
                            $headerids=$request->applicationId;
                            $employeid=$trvalue['employes_id'];
                            $memberidvals=$trvalue['member_id'];
                            $serviceid=$trvalue['service_id'];
                            $periodid=$trvalue['period_id'];
                            $beforetax=$trvalue['BeforeTax'];
                            $tax=$trvalue['Tax'];
                            $grandtotal=$trvalue['GrandTotal'];
                            $discountper=$trvalue['Discount'];
                            $discountamount=$trvalue['DiscountAmount'];
                            $regdatecons=$request->RegistationDate;
                            $expirydatecons=$request->ExpiryDate;
                            $statusvalcons="Pending";
                            $applicationhd->trainer()->attach($employeid,
                            ['services_id'=>$serviceid,'memberships_id'=>$memberidvals,'periods_id'=>$periodid,'BeforeTotal'=>$beforetax,'Tax'=>$tax,'TotalAmount'=>$grandtotal,'DiscountServicePercent'=>$discountper,'DiscountServiceAmount'=>$discountamount]);

                            $applicationhd->consolidate()->attach($memberidvals,
                            ['services_id'=>$serviceid,'periods_id'=>$periodid,'RegistrationDate'=>$regdatecons,'ExpiryDate'=>$expirydatecons,'type'=>1,'Status'=>$statusvalcons,'devices_id'=>1]);
                        }
                    }
                    $updn=DB::select('UPDATE settings SET ApplicationNumber=ApplicationNumber+1 WHERE id=1');

                    
                    //Queue::push(new SendEmail());

                    // $usersattr=DB::select('SELECT users.FullName,users.username,users.email FROM users INNER JOIN model_has_roles ON users.id=model_has_roles.model_id WHERE (users.email is not null AND users.email <>"") AND users.id>0 AND model_has_roles.role_id IN(SELECT role_has_permissions.role_id FROM role_has_permissions WHERE role_has_permissions.permission_id=(SELECT permissions.id FROM permissions WHERE permissions.name="Invoice-Verify"))');
                    // foreach($usersattr as $row){
                    //     $usersfullname=$row->FullName;
                    //     $usersusername=$row->username;
                    //     $usersemail=$row->email;
                    //     Queue::push(new SendEmail($usersfullname,$usersusername,$usersemail));
                    //    // Mail::to($row->email)->send(new NotifyVerification($usersfullname,$usersusername,$usersemail));
                    // }
                   // SendEmail::dispatch()->onQueue('fast');
                    dispatch(new SendEmail());
                    return Response::json(['success' =>1]);
                    
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }

            if($validator->fails())
            {
                return Response::json(['errors'=> $validator->errors()]);
            }
            if($v2->fails())
            {
                return response()->json(['errorv2'=> $v2->errors()->all()]);
            }
            if($v3->fails())
            {
                return response()->json(['errorv3'=> $v3->errors()->all()]);
            }
            if($v4->fails())
            {
                return response()->json(['errorv4'=> $v4->errors()->all()]);
            }
            if($emptytblerr>=1){
                return Response::json(['emptymemerror'=>"error"]);
            }
            if($emptyserverr>=1){
                return Response::json(['emptyerror'=>"error"]);
            }
            if($emptytrainerr>=1){
                return Response::json(['emptytrerror'=>"error"]);
            }
            if($expirydate<=$curentdate){
                return Response::json(['expirydateerror'=>"error"]);
            }
            if($renewmembercnt>=2){
                return Response::json(['renewmemerr'=>"error"]);
            }
            if($renewcount>=1){
                $getrenewedmember=DB::select('SELECT DISTINCT CONCAT(IFNULL(memberships.MemberId,"")," ",IFNULL(memberships.Name,"")) AS MemberName FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE appconsolidates.memberships_id IN('.$memimp.') AND applications.Status NOT IN("Void","Refund") AND appconsolidates.services_id IN('.$serimp.') AND applications.paymentterms_id!=5 AND appconsolidates.applications_id>'.$appidvar);
                return Response::json(['renewcount'=>"error",'memberlists'=>$getrenewedmember]);
            }
            if($notfound>=1){
                $memidvals=implode(',',$rennewmembers);
                $newmemberlist=DB::select('SELECT CONCAT(IFNULL(memberships.MemberId,"")," ",IFNULL(memberships.Name,"")) AS MemInfo FROM memberships WHERE memberships.id IN('.$memidvals.')');
                return Response::json(['renewflagerr'=>"error",'newmemberlist'=>$newmemberlist]);
            }
            if($regmember!=$groupval && ($applicationtypevar=="New"||$applicationtypevar=="Renew")){
                return Response::json(['memerror'=>"error"]);
            }
            if($membertotalcnt>=1){
                $mem=implode(',', $listofmem);
                $serv=implode(',', $listofserv);
                $prd=implode(',', $listofperiod);
                $getduplicatemember=DB::select('SELECT DISTINCT CONCAT(memberships.Name,"  ,  ",services.ServiceName,"  ,  ",periods.PeriodName) AS MemberService FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN periods ON appconsolidates.periods_id=periods.id WHERE appconsolidates.memberships_id IN('.$mem.') AND appconsolidates.services_id IN('.$serv.') AND appconsolidates.periods_id IN('.$prd.') AND appconsolidates.Status IN("Pending","Active")');
                return Response::json(['duperror'=>"error",'duperrorname'=>$getduplicatemember]);
            }
            
            if($frmembertotalcnt>=1){
                $frmem=implode(',', $frlistofmem);
                $frserv=implode(',', $frlistofserv);
                $frprd=implode(',', $frlistofperiod);
                $getfrozenservices=DB::select('SELECT memberships.Name,services.ServiceName,periods.PeriodName FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN periods ON appconsolidates.periods_id=periods.id WHERE appconsolidates.memberships_id IN('.$frmem.') AND appconsolidates.services_id IN('.$frserv.') AND appconsolidates.periods_id IN('.$frprd.') AND appconsolidates.Status="Frozen"');
                return Response::json(['frerror'=>"error",'frerrorname'=>$getfrozenservices]);
            }

            if($exmembertotalcnt>=1){
                $exmem=implode(',', $exlistofmem);
                $exserv=implode(',', $exlistofserv);
                $exprd=implode(',', $exlistofperiod);
                $getextendedmember=DB::select('SELECT memberships.Name,services.ServiceName,periods.PeriodName FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.memberships_id IN('.$exmem.') AND appconsolidates.services_id IN('.$exserv.') AND appconsolidates.periods_id IN('.$exprd.') AND applications.RenewParentId='.$appidvar.' AND applications.Status IN("Pending","Active")');
                return Response::json(['exerror'=>"error",'exerrorname'=>$getextendedmember]);
            }
        }
    }

    public function showappeditCon(Request $request,$id){
        
        $regdate=null;
        $expiredate=null;
        $datediff=null;
        $currentdate=Carbon::today()->toDateString();
        $statusfl=null;
        $expirydates=0;
        $grpid=null;
        $grpsize=0;
        $pterms=null;
        $meminfo=null;
        $baseappid=null;
        $serviceinfo=null;
        $baseapplicationid=null;
        $applicationtypeval="";
        $baseapplicationcount=0;
        $applicationbasecnt=0;
        $statusloyalty=0;
        $fsnumbers=null;
        $memberinfo=null;
        $memserviceinfo=null;

        $appform = ApplicationForm::find($id);
        $createddateval=$appform->created_at;

        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $data = ApplicationForm::join('groupmembers', 'applications.groupmembers_id', '=', 'groupmembers.id')
        ->join('paymentterms', 'applications.paymentterms_id', '=', 'paymentterms.id')
        ->join('stores', 'applications.stores_id', '=', 'stores.id')
        ->where('applications.id', $id)
        ->get(['applications.id','applications.groupmembers_id','applications.paymentterms_id','applications.stores_id','groupmembers.GroupName','paymentterms.PaymentTermName','paymentterms.PaymentTermAmount','stores.Name AS POS','stores.IsAllowedCreditSales','groupmembers.GroupSize',DB::raw("'$datetime' AS CreatedDateTime"),'applications.*']);

        $memdata = appmember::join('memberships','appmembers.memberships_id','=','memberships.id')
        ->where('appmembers.applications_id',$id)
        ->get(['appmembers.*','memberships.Name',DB::raw('IFNULL(memberships.Mobile,"") AS Mobile'),DB::raw('IFNULL(memberships.Phone,"") AS Phone'),'memberships.Picture','memberships.MemberId','appmembers.LoyalityStatus','memberships.LoyalityStatus AS LoyalityStatusMem',
            DB::raw('(SELECT COALESCE(SUM(paymentterms.PaymentTermAmount),0) FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id WHERE appconsolidates.memberships_id=memberships.id AND appconsolidates.applications_id<'.$id.' AND applications.Status NOT IN("Archived","Void","Refund") AND applications.ApplicationType!="Trainer-Fee") AS StayDay'),
            DB::raw('(SELECT COALESCE(SUM(paymentterms.PaymentTermAmount),0) FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id WHERE appconsolidates.memberships_id=memberships.id AND applications.Status NOT IN("Archived","Void","Refund") AND applications.ApplicationType!="Trainer-Fee") AS StayDayRenew'),
            DB::raw('(SELECT COUNT(DISTINCT appconsolidates.memberships_id) FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.applications_id>'.$id.' AND appconsolidates.memberships_id=appmembers.memberships_id AND applications.Status NOT IN("Archived","Void","Refund")) AS MemberActivity'),
            DB::raw('(SELECT loyaltystatuses.Discount FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=memberships.LoyalityStatus) AS MemberDiscount')
        ]);

        $servdata = appservice::join('services','appservices.services_id','=','services.id')
        ->join('periods','appservices.periods_id','=','periods.id')
        ->join('applications','appservices.applications_id','=','applications.id')
        ->join('devices','appservices.devices_id','=','devices.id')
        ->where('appservices.applications_id',$id)
        ->get(['appservices.*','services.ServiceName','periods.PeriodName','applications.groupmembers_id AS GroupId','applications.paymentterms_id AS PaymentTerms','applications.groupmembers_id','applications.paymentterms_id','devices.DeviceName','devices.id AS deviceid']);

        $traindata = apptrainers::join('services','apptrainers.services_id','=','services.id')
        ->join('periods','apptrainers.periods_id','=','periods.id')
        ->join('memberships','apptrainers.memberships_id','=','memberships.id')
        ->join('employes','apptrainers.employes_id','=','employes.id')
        ->join('applications','apptrainers.applications_id','=','applications.id')
        ->where('apptrainers.applications_id',$id)
        ->get(['apptrainers.*','services.ServiceName','periods.PeriodName','applications.groupmembers_id AS GroupId','applications.paymentterms_id AS PaymentTerms','applications.groupmembers_id','applications.paymentterms_id','memberships.MemberId','memberships.Name AS MemberName','memberships.Mobile','memberships.Phone','memberships.Picture','employes.Name AS TrainerName']);
 
        $appidsrc=DB::select('SELECT applications.id,applications.ApplicationNumber,(SELECT GROUP_CONCAT(DISTINCT (memberships.Name),"  ",(memberships.Mobile),"	",(memberships.Phone)) FROM memberships WHERE memberships.id IN(SELECT appconsolidates.memberships_id FROM appconsolidates WHERE appconsolidates.applications_id=applications.id)) AS MemberInfo,(SELECT GROUP_CONCAT(DISTINCT (services.ServiceName)) FROM services WHERE services.id IN(SELECT appconsolidates.services_id FROM appconsolidates WHERE appconsolidates.applications_id=applications.id)) AS ServiceInfo FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.id='.$id.' GROUP BY applications.id ORDER BY applications.ApplicationNumber ASC');
        foreach($appidsrc as $rw){
            $meminfo=$rw->MemberInfo;
            $serviceinfo=$rw->ServiceInfo;
        }

        foreach ($data as $row) {
            $regdate = $row->RegistrationDate;
            $expiredate = $row->ExpiryDate;
            $grpid= $row->groupmembers_id;
            $pterms= $row->paymentterms_id;
            $baseappid= $row->RenewParentId;
            $applicationtypeval=$row->ApplicationType;
        }

        $getbaseinvinfo=DB::select('SELECT applications.id,CONCAT(IFNULL(applications.VoucherNumber,""),"    ,   ",IFNULL(applications.InvoiceNumber,"")) AS FSNum,(SELECT GROUP_CONCAT(DISTINCT IFNULL(memberships.Name,""),"  ",IFNULL(memberships.Mobile,""),"	",IFNULL(memberships.Phone,"")) FROM memberships WHERE memberships.id IN(SELECT appconsolidates.memberships_id FROM appconsolidates WHERE appconsolidates.applications_id=applications.id)) AS MemberInfo, (SELECT GROUP_CONCAT(DISTINCT (services.ServiceName)) FROM services WHERE services.id IN(SELECT appconsolidates.services_id FROM appconsolidates WHERE appconsolidates.applications_id=applications.id)) AS ServiceInfo FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status IN("Pending","Verified","Frozen","Expired") AND appconsolidates.applications_id='.$baseappid.' AND applications.ApplicationType!="Trainer-Fee" AND applications.paymentterms_id!=5 GROUP BY applications.id ORDER BY applications.id ASC');
        foreach($getbaseinvinfo as $rws){
            $fsnumbers=$rws->FSNum;
            $memberinfo=$rws->MemberInfo;
            $memserviceinfo=$rws->ServiceInfo;
        }

        $getbaseid=DB::select('SELECT applications.ApplicationNumber,applications.VoucherNumber,applications.InvoiceNumber FROM applications WHERE applications.id='.$baseappid);
        foreach ($getbaseid as $getbaseid) {
            $baseapplicationid=$getbaseid->VoucherNumber."  ,   ".$getbaseid->InvoiceNumber;
        }

        $getBaseApplication=DB::select('SELECT COUNT(applications.id) AS AppCount FROM applications WHERE applications.IsVoid=0 AND applications.RenewParentId='.$id);
        foreach ($getBaseApplication as $row) {
            $applicationbasecnt=$row->AppCount;
        }

        $getstatusloyalty=DB::select('SELECT COUNT(DISTINCT appconsolidates.memberships_id) AS MemberCount FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.applications_id>'.$id.' AND  memberships.id IN(SELECT appconsolidates.memberships_id FROM appconsolidates WHERE appconsolidates.applications_id='.$id.') AND applications.Status NOT IN("Archived","Void","Refund")');
        foreach ($getstatusloyalty as $row) {
            $statusloyalty=$row->MemberCount;
        }

        $groupamountval=DB::select('SELECT * FROM groupmembers WHERE groupmembers.id='.$grpid);
        foreach ($groupamountval as $row) {
            $grpsize = $row->GroupSize;
        }
        
        if($currentdate<=$expiredate){
            $statusfl=0;
        }
        else if($currentdate>$expiredate){
            $statusfl=1;
        }
        $rd = Carbon::parse($regdate);
        $ed = Carbon::parse($expiredate);
        $daysval = $rd->diffInDays($ed);
        $newregdate=$ed->addDay();
        $regdateval=$ed->addDay(1);
        $month=$daysval/30;
        if($month<1){
            $fdate=$daysval-1;
            $expirydates=$newregdate->addDay($fdate);
        }
        else{
            $expirydates=$newregdate->addMonth($month)->subDay(1);
        }
        $exdate=Carbon::parse($expirydates)->format("Y-m-d");
        $rgdate=Carbon::parse($newregdate)->format("Y-m-d");
        $rdate=Carbon::parse($expiredate)->format("Y-m-d");

        return response()->json(['appdata'=>$data,'memdata'=>$memdata,'servdata'=>$servdata,'traindata'=>$traindata,'stflag'=>$statusfl,'regdate'=>$rdate,'expdate'=>$exdate,'meminfo'=>$meminfo,'baseappidval'=>$baseapplicationid,'newexpdate'=>$expiredate,'apptypeval'=>$applicationtypeval,'appcnt'=>$applicationbasecnt,'serviceinfo'=>$serviceinfo,'membercnt'=>$statusloyalty,'grpsizeval'=>$grpsize,'fsnumbers'=>$fsnumbers,'memberinfo'=>$memberinfo,'memserviceinfo'=>$memserviceinfo]);       
    }

    public function showfreezeinfo($id){
        $statusval=['Active','Frozen'];
        $apptypes=['New','Renew'];
        $pterm=5;
        $memberidval="";
        $membername="";
        $memberphone="";
        $lstatus="";
        $data = appconsolidate::join('applications', 'appconsolidates.applications_id', '=', 'applications.id')
        ->join('memberships', 'appconsolidates.memberships_id', '=', 'memberships.id')
        ->join('services', 'appconsolidates.services_id', '=', 'services.id')
        ->join('periods', 'appconsolidates.periods_id', '=', 'periods.id')
        ->where('appconsolidates.memberships_id', $id)
        ->whereIn('appconsolidates.Status', $statusval)
        ->whereIn('applications.ApplicationType', $apptypes)
        ->where('applications.paymentterms_id','!=',$pterm)
        ->get(['applications.id AS appidval','applications.VoucherNumber','applications.InvoiceNumber','applications.RegistrationDate AS MainRegDate','applications.ExpiryDate AS MainExpDate','appconsolidates.id AS appConsId','applications.ApplicationNumber','memberships.Name AS MemberName','memberships.MemberId','memberships.Mobile','memberships.Phone','memberships.LoyalityStatus','services.ServiceName','periods.PeriodName','appconsolidates.Status AS AppStatus',DB::raw('CASE WHEN appconsolidates.ExtendDay=0 THEN "" WHEN appconsolidates.ExtendDay=null THEN "" WHEN appconsolidates.ExtendDay>0 THEN appconsolidates.ExtendDay END AS ExtendDays'),'appconsolidates.Status AS ConsStatus','appconsolidates.*']);

        $numofserv=$data->count();

        $memberdatasrc=DB::select('SELECT memberships.MemberId,memberships.Name,memberships.MemberId,memberships.Mobile,memberships.Phone,memberships.LoyalityStatus FROM memberships WHERE memberships.id='.$id);        
        
        foreach($memberdatasrc as $row){
            $memberidval=$row->MemberId;
            $membername=$row->Name;
            $memberphone=$row->Mobile.",    ".$row->Phone;
            $lstatus=$row->LoyalityStatus;
        }
        return response()->json(['freezedata'=>$data,'memid'=>$memberidval,'memname'=>$membername,'memphn'=>$memberphone,'numofserv'=>$numofserv,'lstatus'=>$lstatus]);       
    }

    public function getExtendpaymentlist(Request $request){
        $srv=$_POST['servicepr']; 
        $gr=$_POST['grp']; 
        $pt=$_POST['pterm']; 
        $prd=$_POST['periodpr'];
        $newmem=0;
        $newmemdis=0;
        $exsmem=0;
        $exsmemdis=0;
        $grpsize=0;
        $data = servicedetail::join('periods', 'servicedetails.periods_id', '=', 'periods.id')
        ->where('servicedetails.services_id',$srv)
        ->where('servicedetails.groupmembers_id',$gr)
        ->where('servicedetails.paymentterms_id',$pt)
        ->where('servicedetails.periods_id',$prd)
        ->where('servicedetails.Status',"Active")
        ->distinct()
        ->get(['servicedetails.id','servicedetails.NewMemberPrice','servicedetails.NewMemDiscount','servicedetails.MemberPrice','servicedetails.Discount']);

        foreach($data as $row){
            $newmem=$row->NewMemberPrice;
            $newmemdis=$row->NewMemDiscount;
            $exsmem=$row->MemberPrice;
            $exsmemdis=$row->Discount;
        }

        $groupamountval=DB::select('SELECT * FROM groupmembers WHERE groupmembers.id='.$gr);
        foreach ($groupamountval as $row) {
            $grpsize = $row->GroupSize;
        }

        return response()->json(['plist'=>$data,'newmem'=>$newmem,'newmemdis'=>$newmemdis,'exsmem'=>$exsmem,'exsmemdis'=>$exsmemdis,'grpsize'=>$grpsize]);
    }

    public function getPaymentListTrn(Request $request){
        $srv=$_POST['servicepr']; 
        $gr=$_POST['grp']; 
        $pt=$_POST['pterm']; 
        $prd=$_POST['periodpr'];
        $totalmem=$_POST['numoftotalmem']; 
        $numofmem=$_POST['numofmem'];  
        $newmem=0;
        $newmemdis=0;
        $exsmem=0;
        $exsmemdis=0;
        $grpid=0;
        $grpmemid=0;
        $newmemprice=0;
        $exismemprice=0;
        $snewmemprice=0;
        $sexismemprice=0;
    }

    public function getPaymentList(Request $request){
        $srv=$_POST['servicepr']; 
        $gr=$_POST['grp']; 
        $pt=$_POST['pterm']; 
        $prd=$_POST['periodpr'];
        $totalmem=$_POST['numoftotalmem']; 
        $numofmem=$_POST['numofmem'];  
        $newmem=0;
        $newmemdis=0;
        $exsmem=0;
        $exsmemdis=0;
        $grpid=0;
        $grpmemid=0;
        $newmemprice=0;
        $exismemprice=0;
        $snewmemprice=0;
        $sexismemprice=0;
        $newmem=$totalmem-$numofmem;

        $getgroupval=DB::select('SELECT groupmembers.id FROM groupmembers WHERE groupmembers.Status="Active" AND groupmembers.GroupSize='.$newmem.' ORDER BY groupmembers.id DESC LIMIT 1');
        foreach ($getgroupval as $row) {
            $grpid = $row->id;
        }
        $getmemgroupval=DB::select('SELECT groupmembers.id FROM groupmembers WHERE groupmembers.Status="Active" AND groupmembers.GroupSize='.$numofmem.' ORDER BY groupmembers.id DESC LIMIT 1');
        foreach ($getmemgroupval as $row) {
            $grpmemid = $row->id;
        }

        $extdata = servicedetail::join('periods', 'servicedetails.periods_id', '=', 'periods.id')
        ->where('servicedetails.services_id',$srv)
        ->where('servicedetails.groupmembers_id',$gr)
        ->where('servicedetails.paymentterms_id',$pt)
        ->where('servicedetails.periods_id',$prd)
        ->where('servicedetails.Status',"Active")
        ->distinct()
        ->get(['servicedetails.id','servicedetails.NewMemberPrice','servicedetails.NewMemDiscount','servicedetails.MemberPrice','servicedetails.Discount']);

        foreach($extdata as $row){
            $newmem=$row->NewMemberPrice;
            $newmemdis=$row->NewMemDiscount;
            $exsmem=$row->MemberPrice;
            $exsmemdis=$row->Discount;
        }

        $data = servicedetail::join('periods', 'servicedetails.periods_id', '=', 'periods.id')
        ->where('servicedetails.services_id',$srv)
        ->where('servicedetails.groupmembers_id',$grpmemid)
        ->where('servicedetails.paymentterms_id',$pt)
        ->where('servicedetails.periods_id',$prd)
        ->where('servicedetails.Status',"Active")
        ->distinct()
        ->get(['servicedetails.id','servicedetails.NewMemberPrice','servicedetails.NewMemDiscount','servicedetails.MemberPrice','servicedetails.Discount']);

        $singledata = servicedetail::join('periods', 'servicedetails.periods_id', '=', 'periods.id')
        ->where('servicedetails.services_id',$srv)
        ->where('servicedetails.groupmembers_id',$grpid)
        ->where('servicedetails.paymentterms_id',$pt)
        ->where('servicedetails.periods_id',$prd)
        ->where('servicedetails.Status',"Active")
        ->distinct()
        ->get(['servicedetails.id','servicedetails.NewMemberPrice','servicedetails.NewMemDiscount','servicedetails.MemberPrice','servicedetails.Discount']);

        foreach ($data as $row) {
            $newmemprice=$row->NewMemberPrice;
            $exismemprice=$row->MemberPrice;
        }
        foreach ($singledata as $row) {
            $snewmemprice=$row->NewMemberPrice;
            $sexismemprice=$row->MemberPrice;
        }

        if($newmemprice==$exismemprice && $snewmemprice==$sexismemprice){
            $data = servicedetail::join('periods', 'servicedetails.periods_id', '=', 'periods.id')
            ->where('servicedetails.services_id',$srv)
            ->where('servicedetails.groupmembers_id',$gr)
            ->where('servicedetails.paymentterms_id',$pt)
            ->where('servicedetails.periods_id',$prd)
            ->where('servicedetails.Status',"Active")
            ->distinct()
            ->get(['servicedetails.id','servicedetails.NewMemberPrice','servicedetails.NewMemDiscount','servicedetails.MemberPrice','servicedetails.Discount']);

            $singledata = servicedetail::join('periods', 'servicedetails.periods_id', '=', 'periods.id')
            ->where('servicedetails.services_id',$srv)
            ->where('servicedetails.groupmembers_id',0)
            ->where('servicedetails.paymentterms_id',$pt)
            ->where('servicedetails.periods_id',$prd)
            ->where('servicedetails.Status',"Active")
            ->distinct()
            ->get(['servicedetails.id','servicedetails.NewMemberPrice','servicedetails.NewMemDiscount','servicedetails.MemberPrice','servicedetails.Discount']);
           
        }
        return response()->json(['plist'=>$data,'singledata'=>$singledata,'newmem'=>$newmem,'newmemdis'=>$newmemdis,'exsmem'=>$exsmem,'exsmemdis'=>$exsmemdis]);       
    }

    public function showEachMember($id)
    {
        $detailTable=DB::select('SELECT memberships.MemberId,memberships.Name AS MemberName,CONCAT(memberships.Mobile,", ",memberships.Phone) AS MobilePhone,CONCAT(appconsolidates.RegistrationDate," to ",appconsolidates.ExpiryDate) AS ActiveRange,services.ServiceName,periods.PeriodName,appconsolidates.*,CASE WHEN ExtendDay=0 THEN "" WHEN ExtendDay>=1 THEN appconsolidates.ExtendDay END AS FreezeDayVal FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN periods ON appconsolidates.periods_id=periods.id WHERE appconsolidates.applications_id='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                //  $btn = ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                //  return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showDetailService($id)
    {
        $detailTable=DB::select('SELECT appconsolidates.id,appconsolidates.applications_id,applications.ApplicationNumber,applications.ApplicationType,applications.Type,stores.Name AS POS,applications.VoucherNumber,IFNULL(applications.InvoiceNumber,"") AS InvoiceNumber,applications.InvoiceDate,CONCAT(appconsolidates.RegistrationDate," to ",appconsolidates.ExpiryDate) AS ActiveRange,applications.SubTotal,applications.TotalTax,applications.GrandTotal,applications.DiscountAmount, services.ServiceName,appconsolidates.Status FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN stores ON applications.stores_id=stores.id WHERE appconsolidates.memberships_id='.$id.' ORDER BY appconsolidates.id DESC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                //  $btn = ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                //  return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showMemberPrice($id)
    {
        $detailTable=DB::select('SELECT applications.ApplicationType,applications.Type,paymentterms.PaymentTermName,groupmembers.GroupName,applications.RegistrationDate,applications.ExpiryDate,memberships.Name AS MemberName,CONCAT(IFNULL(memberships.Phone,""),", ",IFNULL(memberships.Mobile,"")) AS MobilePhone,appmembers.LoyalityStatus,services.ServiceName,periods.PeriodName,appservices.BeforeTotal,appservices.Tax,appservices.TotalAmount,appservices.DiscountServicePercent,appservices.DiscountServiceAmount,devices.DeviceName,CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
           (SELECT appconsolidates.Status FROM appconsolidates WHERE appconsolidates.applications_id=applications.id AND appconsolidates.services_id=appservices.services_id AND appconsolidates.memberships_id=appmembers.memberships_id)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
           (SELECT appconsolidates.Status FROM appconsolidates INNER JOIN apptrainers ON appconsolidates.applications_id=apptrainers.applications_id WHERE appconsolidates.applications_id=applications.id AND appconsolidates.services_id=apptrainers.services_id AND appconsolidates.memberships_id=apptrainers.memberships_id)       
           END AS ServiceStatus FROM appservices INNER JOIN applications ON appservices.applications_id=applications.id INNER JOIN appmembers ON appmembers.applications_id=applications.id INNER JOIN memberships ON appmembers.memberships_id=memberships.id INNER JOIN services ON appservices.services_id=services.id INNER JOIN periods ON appservices.periods_id=periods.id INNER JOIN groupmembers ON applications.groupmembers_id=groupmembers.id INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id INNER JOIN devices ON appservices.devices_id=devices.id WHERE applications.id='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                //  $btn = ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                //  return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showMemberPriceTr($id)
    {
        $detailTable=DB::select('SELECT apptrainers.id,memberships.MemberId,memberships.Name,CONCAT(IFNULL(memberships.Mobile,""),", ",IFNULL(memberships.Phone,"")) AS Phone,services.ServiceName,periods.PeriodName,CONCAT(applications.RegistrationDate," to ",applications.ExpiryDate) AS ActiveRange,employes.Name AS TrainerName,apptrainers.BeforeTotal,apptrainers.Tax,apptrainers.TotalAmount,apptrainers.DiscountServicePercent,apptrainers.DiscountServiceAmount FROM apptrainers INNER JOIN applications ON apptrainers.applications_id=applications.id INNER JOIN memberships ON apptrainers.memberships_id=memberships.id INNER JOIN services ON apptrainers.services_id=services.id INNER JOIN periods ON apptrainers.periods_id=periods.id INNER JOIN employes ON apptrainers.employes_id=employes.id WHERE apptrainers.applications_id='.$id.' ORDER BY apptrainers.id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            //  $btn = ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
            //  return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getGroupAttr(Request $request){
        $gr=$_POST['grp']; 
        $data = groupmember::where('groupmembers.id',$gr)
        ->where('groupmembers.Status','=',"Active")
        ->distinct()
        ->get(['groupmembers.*']);
        return response()->json(['glist'=>$data]);       
    }

    public function getPaymenntTermAttr(Request $request){
        $pt=$_POST['pterm']; 
        $expdate=$_POST['expiredatehidden'];
        $cdate=Carbon::today()->toDateString();
        $currentdate = Carbon::parse($cdate);
        $pterms=0;
        $data = paymentterm::where('paymentterms.id',$pt)
        ->where('paymentterms.Status','=',"Active")
        ->distinct()
        ->get(['paymentterms.*']);
        foreach ($data as $row) {
            $pterms = $row->PaymentTermAmount;
        }
        $remdays = $currentdate->diffInDays($expdate);  
        return response()->json(['ptlist'=>$data,'pterms'=>$pterms,'remainingday'=>$remdays,'paymenttermval'=>$pterms]);       
    }

    public function showVoidInfo($id){
        $memcnts=0;
        $uploadval=1;
        $renewval=0;
        $invtype=null;
        $renewidval=null;
        $checkvoidval = DB::table('applications')
        ->select('applications.id')
        ->where('applications.RenewParentId',$id)
        ->where('applications.IsVoid',0)
        ->get();

        $data = DB::table('applications')
        ->select('applications.Status','applications.ApplicationType','applications.RenewParentId')
        ->where('applications.id',$id)
        ->where('applications.IsVoid',0)
        ->get();

        $getuploadval = DB::table('applications')
        ->select('applications.id')
        ->where('applications.id',$id)
        ->whereNotNull('applications.DocumentUploadPath')
        ->get();

        $getmembercount=DB::select('SELECT COUNT(appmembers.id) AS MemCount FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.memberships_id IN(SELECT DISTINCT appconsolidates.memberships_id FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Void","Refund") AND appconsolidates.applications_id='.$id.') AND applications.Status NOT IN("Void","Refund") AND appmembers.applications_id>'.$id);
        foreach($getmembercount as $memrow)
        {
            $memcnts=$memrow->MemCount;
        }

        foreach($data as $renrow)
        {
            $invtype=$renrow->ApplicationType;
            $renewidval=$renrow->RenewParentId;
        }
        if($invtype=="Renew"){
            $getrenewval=DB::select('SELECT applications.Status FROM applications WHERE applications.id='.$renewidval);
            foreach($getrenewval as $renewrow)
            {
                $statusval=$renewrow->Status;
                if($statusval=="Pending"){
                    $renewval=1;
                }
            }
        }

        // $getmembercount=DB::select('SELECT COUNT(appmembers.id) AS MemCount FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id='.$id.' AND (SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(memberships.LoyalityStatus))!=((SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(appmembers.LoyalityStatus))-1)');
        // foreach($getmembercount as $row)
        // {
        //     $memcnts=$row->MemCount;
        // }

        $getvoidcount = $checkvoidval->count();
        //$uploadval = $getuploadval->count();

        return response()->json(['appdataval'=>$data,'count'=>$getvoidcount,'upcnt'=>$uploadval,'memcnts'=>$memcnts,'renewcnt'=>$renewval]);
    }

    public function voidApplication(Request $request)
    {
        ini_set('max_execution_time', '300000');
        ini_set("pcre.backtrack_limit", "500000000");
        $statusval="Void";
        $stval=null;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $memloystatus=0;
        $memloystatus=0;
        $memcount=0;
        $memidarr=[];
        $deviceids=[];
		$memcounts=null;
        $findid=$request->voididn;
        $sett=ApplicationForm::find($findid);
        $stval=$sett->Status;

        $getmembercount=DB::select('SELECT COUNT(appmembers.id) AS MemCount FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.memberships_id IN(SELECT DISTINCT appconsolidates.memberships_id FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Void","Refund") AND appconsolidates.applications_id='.$findid.') AND applications.Status NOT IN("Void","Refund") AND appmembers.applications_id>'.$findid);
        foreach($getmembercount as $memrow)
        {
            $memcount=$memrow->MemCount;
        }

        $validator = Validator::make($request->all(), [
            'Reason'=>"required",
        ]);
        if ($validator->passes() && $memcount==0) 
        {
            try{
                $mquuid = Str::uuid()->toString();
                $mqt=new mqttmessage;
                $mqtt = MQTT::connection();

               
                if($stval=="Verified" || $stval=="Pending"){
                    $getmemebers=DB::select('SELECT appmembers.memberships_id FROM appmembers WHERE appmembers.applications_id='.$findid);
                    foreach($getmemebers as $memrow){
                        $getmembercnt=DB::select('SELECT COUNT(appmembers.memberships_id) AS MemberCount FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id WHERE applications.Status="Verified" AND appmembers.memberships_id='.$memrow->memberships_id.' AND appmembers.applications_id!='.$findid);
                        foreach($getmembercnt as $cntrow){
                            $mcnt = $cntrow->MemberCount;
                            if($mcnt==0){
                                $memidarr[] = $memrow->memberships_id;
                                $memcounts+=1;
                            }
                        }
                    }
                   
                    $getdevices=DB::select('SELECT DISTINCT appservices.devices_id FROM appservices WHERE appservices.applications_id='.$findid);
                    foreach($getdevices as $devrow){
                        $deviceids[] = $devrow->devices_id;
                    }

                    $devids=implode(',', $deviceids);
                    $delmembers=implode(',', $memidarr);

                    $getalldevice=DB::select('SELECT DISTINCT * FROM devices WHERE devices.Status="Active" AND devices.id IN ('.$devids.') UNION SELECT DISTINCT * FROM devices WHERE devices.Status="Active" AND devices.devicetype IN (3)');
                    foreach($getalldevice as $devrow)
                    {
                        $topic="mqtt/face/".$devrow->DeviceId;
                        $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";

                        $getmemberid=DB::select('SELECT DISTINCT memberships_id FROM appconsolidates WHERE appconsolidates.devices_id='.$devrow->id.' AND appconsolidates.applications_id='.$findid);
                        foreach($getmemberid as $membrow){
                            $fpmquuid = Str::uuid()->toString();
                            $fpmsgs='{
                                "operator": "SetFingerprints",
                                "messageId":"MessageID-SetFingerprints-'.$fpmquuid.'",
                                "info":
                                {
                                    "facesluiceId":"'.$devrow->DeviceId.'",
                                    "IdType":2,
                                    "PersonUUID":"'.$membrow->memberships_id.'",
                                    "LeftThumb":"",
                                    "LeftIndex":"",
                                    "LeftMiddle":"",
                                    "LeftRing": "",
                                    "LeftPinky": "",
                                    "RightThumb": "",
                                    "RightIndex": "",
                                    "RightMiddle":"",
                                    "RightRing": "",
                                    "RightPinky": "",
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
                        
                        $msgs='{
                            "messageId":"MessageID-DeletePerson-'.$mquuid.'",
                            "DataBegin":"BeginFlag",
                            "operator": "DeletePersons",
                            "PersonNum":"'.$memcounts.'",
                            "info":
                            {
                                "facesluiceId":"'.$devrow->DeviceId.'",
                                "customId":"['.$delmembers.']",                             
                            },
                            "DataEnd":"EndFlag"
                        }';
                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 10) {
                                $mqtts->interrupt();
                            }
                        });
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$mquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
                        $mqtt->publish($topic,$msgs,2);
                        $mqtt->loop(true);
                    }
                    $mqtt->disconnect();
                }
            
                $sett->Status=$statusval;
                $sett->OldStatus=$stval;
                $sett->IsVoid="1";
                $vnumber=$sett->VoucherNumber;
                $inumber=$sett->InvoiceNumber;
                $sett->VoucherNumber=$vnumber."(void".$findid.")";
                $sett->InvoiceNumber=$inumber."(void".$findid.")";
                $sett->VoidBy=$user;
                $sett->VoidReason=trim($request->input('Reason'));
                $sett->VoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                //$sett->VoidDate=Carbon::today()->toDateString();
                $sett->save();
                $updateoldstatus=DB::select('UPDATE appconsolidates SET appconsolidates.OldStatus=appconsolidates.Status WHERE appconsolidates.applications_id='.$findid);
                $updatestatus=DB::select('UPDATE appconsolidates SET appconsolidates.Status="'.$statusval.'" WHERE appconsolidates.applications_id='.$findid);
                $updateloyaltymem=DB::select('UPDATE appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id SET memberships.LoyalityStatus=appmembers.OldLoyalityStatus WHERE memberships.id IN(SELECT DISTINCT appconsolidates.memberships_id FROM appconsolidates WHERE appconsolidates.applications_id='.$findid.') AND appmembers.applications_id='.$findid);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
        else if($memcount>=1){
            $getmemList=DB::select('SELECT appmembers.memberships_id,memberships.Name FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id='.$findid.' AND (SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(memberships.LoyalityStatus))!=((SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(appmembers.LoyalityStatus))-1)');
            return Response::json(['memcnt'=>"error",'countMembers'=>$getmemList]);
        }
    }

    public function refundApplication(Request $request)
    {
        ini_set('max_execution_time', '300000');
        ini_set("pcre.backtrack_limit", "500000000");
        $statusval="Refund";
        $stval=null;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $memloystatus=0;
        $memloystatus=0;
        $memcount=0;
        $memidarr=[];
        $deviceids=[];
		$memcounts=null;
        $findid=$request->refundidn;
        $sett=ApplicationForm::find($findid);
        $stval=$sett->Status;

        $getloyaltystaus=DB::select('SELECT COUNT(appmembers.id) AS MemberCount FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id>'.$findid.' AND (SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(memberships.LoyalityStatus))!=((SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(appmembers.LoyalityStatus))-1)');
        foreach($getloyaltystaus as $row)
        {
            $memcount=$row->MemberCount;
        }

        $validator = Validator::make($request->all(), [
            'RefundReason'=>"required",
        ]);
        if ($validator->passes() && $memcount==0) 
        {
            try{
                if($stval=="Verified"||$stval=="Pending"){
                    $getmemebers=DB::select('SELECT appmembers.memberships_id FROM appmembers WHERE appmembers.applications_id='.$findid);
                    foreach($getmemebers as $memrow){
                        $getmembercnt=DB::select('SELECT COUNT(appmembers.memberships_id) AS MemberCount FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id WHERE applications.Status="Verified" AND appmembers.memberships_id='.$memrow->memberships_id.' AND appmembers.applications_id!='.$findid);
                        foreach($getmembercnt as $cntrow){
                            $mcnt = $cntrow->MemberCount;
                            if($mcnt==0){
                                $memidarr[] = $memrow->memberships_id;
                                $memcounts+=1;
                            }
                        }
                    }
                   
                    $getdevices=DB::select('SELECT DISTINCT appservices.devices_id FROM appservices WHERE appservices.applications_id='.$findid);
                    foreach($getdevices as $devrow){
                        $deviceids[] = $devrow->devices_id;
                    }

                    $devids=implode(',', $deviceids);
                    $delmembers=implode(',', $memidarr);

                    $mquuid = Str::uuid()->toString();
                    $mqt=new mqttmessage;
                    $mqtt = MQTT::connection();

                    $getalldevice=DB::select('SELECT DISTINCT * FROM devices WHERE devices.Status="Active" AND devices.id IN ('.$devids.') UNION SELECT DISTINCT * FROM devices WHERE devices.Status="Active" AND devices.devicetype IN (3)');
                    foreach($getalldevice as $devrow)
                    {
                        $topic="mqtt/face/".$devrow->DeviceId;
                        $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";

                        $getmemberid=DB::select('SELECT DISTINCT memberships_id FROM appconsolidates WHERE appconsolidates.devices_id='.$devrow->id.' AND appconsolidates.applications_id='.$findid);
                        foreach($getmemberid as $membrow){
                            $fpmquuid = Str::uuid()->toString();
                            $fpmsgs='{
                                "operator": "SetFingerprints",
                                "messageId":"MessageID-SetFingerprints-'.$fpmquuid.'",
                                "info":
                                {
                                    "facesluiceId":"'.$devrow->DeviceId.'",
                                    "IdType":2,
                                    "PersonUUID":"'.$membrow->memberships_id.'",
                                    "LeftThumb":"",
                                    "LeftIndex":"",
                                    "LeftMiddle":"",
                                    "LeftRing": "",
                                    "LeftPinky": "",
                                    "RightThumb": "",
                                    "RightIndex": "",
                                    "RightMiddle":"",
                                    "RightRing": "",
                                    "RightPinky": "",
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
                        
                        $msgs='{
                            "messageId":"MessageID-DeletePerson-'.$mquuid.'",
                            "DataBegin":"BeginFlag",
                            "operator": "DeletePersons",
                            "PersonNum":"'.$memcounts.'",
                            "info":
                            {
                                "facesluiceId":"'.$devrow->DeviceId.'",
                                "customId":"['.$delmembers.']",                             
                            },
                            "DataEnd":"EndFlag"
                        }';
                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 10) {
                                $mqtts->interrupt();
                            }
                        });
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$mquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
                        $mqtt->publish($topic,$msgs,2);
                        $mqtt->loop(true);
                        
                    }
                    $mqtt->disconnect();
                }

                $sett->Status=$statusval;
                $sett->OldStatus=$stval;
                $sett->IsVoid="1";
                $sett->RefundBy=$user;
                $sett->RefundReason=trim($request->input('RefundReason'));
                $sett->RefundDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $sett->save();
                $updateoldstatus=DB::select('UPDATE appconsolidates SET appconsolidates.OldStatus=appconsolidates.Status WHERE appconsolidates.applications_id='.$findid);
                $updatestatus=DB::select('UPDATE appconsolidates SET appconsolidates.Status="'.$statusval.'" WHERE appconsolidates.applications_id='.$findid);
                $updateloyaltymem=DB::select('UPDATE appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id SET memberships.LoyalityStatus=appmembers.OldLoyalityStatus WHERE memberships.id IN(SELECT DISTINCT appconsolidates.memberships_id FROM appconsolidates WHERE appconsolidates.applications_id='.$findid.') AND appmembers.applications_id='.$findid);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
        else if($memcount>=1){
            $getmemList=DB::select('SELECT appmembers.memberships_id,memberships.Name FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id='.$findid.' AND (SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(memberships.LoyalityStatus))!=((SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(appmembers.LoyalityStatus))-1)');
            return Response::json(['memcnt'=>"error",'countMembers'=>$getmemList]);
        }
    }

    public function showundoVoidInfo($id){
        $memcnts=0;
        $grpinvolve=0;
        $renewid=null;
        $renewstatus="";
        $servicearr=[];
        $memberarr=[];
        $renewmembercnt=0;
        $checkundovoidval = DB::table('applications')
        ->select('applications.RenewParentId')
        ->where('applications.id',$id)
        ->get();

        foreach ($checkundovoidval as $row) {
            $renewid = $row->RenewParentId;
        }

        $appconsolidateval = DB::table('appconsolidates')
        ->select('appconsolidates.*')
        ->where('appconsolidates.applications_id',$id)
        ->distinct()
        ->get();

        foreach ($appconsolidateval as $approw){
            $servicearr[]=$approw->services_id;
            $memberarr[]=$approw->memberships_id;
        }
        $servarr=implode(',', $servicearr);
        $memarr=implode(',', $memberarr);

        $data = DB::table('applications')
        ->select('applications.Status')
        ->where('applications.id',$renewid)
        ->get();

        $getgroupinv=DB::select('SELECT COUNT(appmembers.memberships_id) AS MemberGroupCount FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id WHERE applications.Status IN("Pending","Verified","Frozen","Expired") AND applications.Type IN("Group") AND appmembers.memberships_id IN(SELECT appmembers.memberships_id FROM appmembers WHERE appmembers.applications_id='.$id.')');
        foreach ($getgroupinv as $row) {
            $grpinvolve = $row->MemberGroupCount;
        }
    
        $getmembercount=DB::select('SELECT COUNT(appmembers.id) AS MemCount FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id>'.$id.' AND (SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(memberships.LoyalityStatus))!=((SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(appmembers.LoyalityStatus))-1)');
        foreach($getmembercount as $memrow)
        {
            $memcnts=$memrow->MemCount;
        }
        $getvoidcount = $checkundovoidval->count();

        $getmembersinformation=DB::select('SELECT COUNT(DISTINCT appconsolidates.id) AS MemberCount FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.memberships_id IN ('.$memarr.') AND applications.ApplicationType="New" AND applications.Status NOT IN("Void","Refund") AND appconsolidates.services_id IN('.$servarr.') AND appconsolidates.applications_id!='.$id);
        foreach ($getmembersinformation as $memrow) {
            $renewmembercnt=$memrow->MemberCount;
        }

        return response()->json(['appundodata'=>$data,'count'=>$getvoidcount,'memcnts'=>$memcnts,'grpinv'=>$grpinvolve,'renewmemerr'=>$renewmembercnt]);
    }

    public function updateAppVerified(Request $request)
    {
        $host = request()->getSchemeAndHttpHost(); 
        ini_set('max_execution_time', '300000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->checkedid;
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
        $starttime=null;
        $endtime=null;
        $starttimefirsthalf=null;
        $endtimefirsthalf=null;
        $starttimesecondhalf=null;
        $endtimesecondhalf=null;
        $mquuid = Str::uuid()->toString();
        $currtime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');
        
        try{
            $mquuid = Str::uuid()->toString();
            $mqt=new mqttmessage;
            $mqtt = MQTT::connection();
            

            $getallclients=DB::select('SELECT appconsolidates.memberships_id AS MemberIdVal,memberships.*,memberships.Status AS MemberStatus,periods.PeriodName,(SELECT perioddetails.FirstHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfFrom,(SELECT perioddetails.FirstHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfTo,(SELECT perioddetails.SecondHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfFrom,(SELECT perioddetails.SecondHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfTo,appconsolidates.devices_id,devices.*,applications.RegistrationDate,applications.ExpiryDate,applications.Status FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN devices ON appconsolidates.devices_id=devices.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE applications.Status IN("Pending") AND appconsolidates.applications_id='.$findid);
            foreach($getallclients as $row)
            {
                if($row->LeftThumb==null || $row->LeftThumb==""){
                    $leftthumb="";
                }
                if($row->LeftThumb!=null && $row->LeftThumb!=""){
                    $leftthumb=$row->LeftThumb;
                }

                if($row->LeftIndex==null || $row->LeftIndex==""){
                    $leftindex="";
                }
                if($row->LeftIndex!=null && $row->LeftIndex!=""){
                    $leftindex=$row->LeftIndex;
                }

                if($row->LeftMiddle==null || $row->LeftMiddle==""){
                    $leftmiddle="";
                }
                if($row->LeftMiddle!=null && $row->LeftMiddle!=""){
                    $leftmiddle=$row->LeftMiddle;
                }

                if($row->LeftRing==null || $row->LeftRing==""){
                    $leftring="";
                }
                if($row->LeftRing!=null && $row->LeftRing!=""){
                    $leftring=$row->LeftRing;
                }

                if($row->LeftPinky==null || $row->LeftPinky==""){
                    $leftpicky="";
                }
                if($row->LeftPinky!=null && $row->LeftPinky!=""){
                    $leftpicky=$row->LeftPinky;
                }

                if($row->RightThumb==null || $row->RightThumb==""){
                    $rightthumb="";
                }
                if($row->RightThumb!=null && $row->RightThumb!=""){
                    $rightthumb=$row->RightThumb;
                }

                if($row->RightIndex==null || $row->RightIndex==""){
                    $rightindex="";
                }
                if($row->RightIndex!=null && $row->RightIndex!=""){
                    $rightindex=$row->RightIndex;
                }

                if($row->RightMiddle==null || $row->RightMiddle==""){
                    $rightmiddle="";
                }
                if($row->RightMiddle!=null && $row->RightMiddle!=""){
                    $rightmiddle=$row->RightMiddle;
                }

                if($row->RightRing==null || $row->RightRing==""){
                    $rightring="";
                }
                if($row->RightRing!=null && $row->RightRing!=""){
                    $rightring=$row->RightRing;
                }

                if($row->RightPinky==null || $row->RightPinky==""){
                    $rightpicky="";
                }
                if($row->RightPinky!=null && $row->RightPinky!=""){
                    $rightpicky=$row->RightPinky;
                }

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
                // if($meridiam=="AM"){
                //     if($row->FirstHalfFrom==null || $row->FirstHalfFrom==""){
                //         $starttime="11:59:59";
                //     }
                //     if($row->FirstHalfFrom!=null && $row->FirstHalfFrom!=""){
                //         $starttime=$row->FirstHalfFrom.":00";
                //     }

                //     if($row->FirstHalfTo==null || $row->FirstHalfTo==""){
                //         $endtime="11:59:59";
                //     }
                //     if($row->FirstHalfTo!=null && $row->FirstHalfTo!=""){
                //         $endtime=$row->FirstHalfTo.":59";
                //     }
                // }
                // if($meridiam=="PM"){
                //     if($row->SecondHalfFrom==null || $row->SecondHalfFrom==""){
                //         $starttime="23:59:59";
                //     }
                //     if($row->SecondHalfFrom!=null && $row->SecondHalfFrom!=""){
                //         $starttime=$row->SecondHalfFrom.":00";
                //     }

                //     if($row->SecondHalfTo==null || $row->SecondHalfTo==""){
                //         $endtime="23:59:59";
                //     }
                //     if($row->SecondHalfTo!=null && $row->SecondHalfTo!=""){
                //         $endtime=$row->SecondHalfTo.":59";
                //     }
                // }

                if($row->Gender=="Male"){
                    $gender=0;
                    if($row->Picture==null){
                        $picdata="dummymale.jpg";
                    }
                }
                if($row->Gender=="Female"){
                    $gender=1;
                    if($row->Picture==null){
                        $picdata="dummyfemale.jpg";
                    }
                }

                if($row->MemberStatus=="Active"){
                    $persontype=0;
                }
                if($row->MemberStatus!="Active"){
                    $persontype=1;
                }

                if($row->Picture!=null){
                    $imagepath = public_path().'/storage/uploads/MemberPicture/'.$row->Picture;
                    //$picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                    $picdata=$row->Picture;
                }
                // if($row->Picture==null){
                //     $picdata=$defpic;
                // }

                $topic="mqtt/face/".$row->DeviceId;
                $topicrec="mqtt/face/".$row->DeviceId."/Ack";

                $msgs='{
                    "operator": "EditPerson",
                    "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                    "info":
                    {
                        "facesluiceId":"'.$row->DeviceId.'",
                        "customId":"'.$row->MemberIdVal.'",
                        "tempCardType":2,
                        "personType":"'.$persontype.'",
                        "name":"'.$row->Name.'",
                        "gender":"'.$gender.'",
                        "birthday":"'.$row->DOB.'",
                        "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                        "address":"'.$row->Location.'",
                        "PersonUUID":"'.$row->PersonUUID.'",
                        "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                        "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                        "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                                    
                    },
                }';
                $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                    if ($elapsedTime >= 8) {
                        $mqtts->interrupt();
                    }
                });
                // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                //     $mqt->userid=$userid;
                //     $mqt->uuid=$mquuid;
                //     $mqt->message=$message;
                //     $mqt->save();
                // }, 2);
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
                        "PersonUUID":"'.$row->MemberIdVal.'",
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
                // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                //     $mqt->userid=$userid;
                //     $mqt->uuid=$fpmquuid;
                //     $mqt->message=$message;
                //     $mqt->save();
                // }, 2);
                $mqtt->publish($topic,$fpmsgs,2);
                $mqtt->loop(true);

                // $resmsgs='{
                //     "operator": "RebootDevice",
                //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                //     "info":
                //     {
                //         "facesluiceId":"'.$devid.'",
                //     },
                // }';     
                // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                //     if ($elapsedTime >= 10) {
                //         $mqtts->interrupt();
                //     }
                // });
                // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                //     $mqt->userid=$userid;
                //     $mqt->uuid=$mquuid;
                //     $mqt->message=$message;
                //     $mqt->save();
                // }, 2);
                // $mqtt->publish($topic,$resmsgs,2);
                // $mqtt->loop(true);

                $getexitdevice=DB::select('SELECT * FROM devices WHERE devices.Status="Active" AND devices.devicetype=3');
                foreach($getexitdevice as $devrow)
                {
                    $topic="mqtt/face/".$devrow->DeviceId;
                    $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                    
                    $msgs='{
                        "operator": "EditPerson",
                        "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                        "info":
                        {
                            "facesluiceId":"'.$devrow->DeviceId.'",
                            "customId":"'.$row->MemberIdVal.'",
                            "tempCardType":2,
                            "personType":"'.$persontype.'",
                            "name":"'.$row->Name.'",
                            "gender":"'.$gender.'",
                            "birthday":"'.$row->DOB.'",
                            "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                            "address":"'.$row->Location.'",
                            "PersonUUID":"'.$row->PersonUUID.'",
                            "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                            "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                            "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                           
                        },
                    }';
                    $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                        if ($elapsedTime >= 8) {
                            $mqtts->interrupt();
                        }
                    });
                    // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                    //     $mqt->userid=$userid;
                    //     $mqt->uuid=$mquuid;
                    //     $mqt->message=$message;
                    //     $mqt->save();
                    // }, 2);
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
                            "PersonUUID":"'.$row->MemberIdVal.'",
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
                    // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                    //     $mqt->userid=$userid;
                    //     $mqt->uuid=$fpmquuid;
                    //     $mqt->message=$message;
                    //     $mqt->save();
                    // }, 2);
                    $mqtt->publish($topic,$fpmsgs,2);
                    $mqtt->loop(true);

                    // $resmsgs='{
                    //     "operator": "RebootDevice",
                    //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                    //     "info":
                    //     {
                    //         "facesluiceId":"'.$devid.'",
                    //     },
                    // }';     
                    // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                    //     if ($elapsedTime >= 8) {
                    //         $mqtts->interrupt();
                    //     }
                    // });
                    // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                    //     $mqt->userid=$userid;
                    //     $mqt->uuid=$mquuid;
                    //     $mqt->message=$message;
                    //     $mqt->save();
                    // }, 2);
                    // $mqtt->publish($topic,$resmsgs,2);
                    // $mqtt->loop(true);

                }
            }
            $mqtt->disconnect();
            $curdate=Carbon::today()->toDateString();
            $sett=ApplicationForm::find($findid);
            $sett->VerifiedBy= $user;
            $sett->VerifiedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $sett->Status="Verified";
            $sett->save();
            $updatestatus=DB::select('UPDATE appconsolidates SET appconsolidates.Status="Active" WHERE appconsolidates.RegistrationDate<="'.$curdate.'" AND appconsolidates.applications_id='.$findid);
            $updatetobeactivestatus=DB::select('UPDATE appconsolidates SET appconsolidates.Status="To-Be-Active" WHERE appconsolidates.RegistrationDate>"'.$curdate.'" AND appconsolidates.applications_id='.$findid);
            return Response::json(['success' => '1']);  
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function sendToDevice(Request $request)
    {
        $host = request()->getSchemeAndHttpHost(); 
        ini_set('max_execution_time', '300000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->sendappid;
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
        $starttime=null;
        $endtime=null;
        $starttimefirsthalf=null;
        $endtimefirsthalf=null;
        $starttimesecondhalf=null;
        $endtimesecondhalf=null;
        $mquuid = Str::uuid()->toString();
        $currtime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');

        try{
            $mquuid = Str::uuid()->toString();
            $mqt=new mqttmessage;
            $mqtt = MQTT::connection();

            $getallclients=DB::select('SELECT appconsolidates.memberships_id AS MemberIdVal,memberships.*,memberships.Status AS MemberStatus,periods.PeriodName,(SELECT perioddetails.FirstHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfFrom,(SELECT perioddetails.FirstHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfTo,(SELECT perioddetails.SecondHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfFrom,(SELECT perioddetails.SecondHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfTo,appconsolidates.devices_id,devices.*,applications.RegistrationDate,applications.ExpiryDate,applications.Status FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN devices ON appconsolidates.devices_id=devices.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE applications.Status IN("Pending") AND appconsolidates.applications_id='.$findid);
            foreach($getallclients as $row)
            {
                if($row->LeftThumb==null || $row->LeftThumb==""){
                    $leftthumb="";
                }
                if($row->LeftThumb!=null && $row->LeftThumb!=""){
                    $leftthumb=$row->LeftThumb;
                }

                if($row->LeftIndex==null || $row->LeftIndex==""){
                    $leftindex="";
                }
                if($row->LeftIndex!=null && $row->LeftIndex!=""){
                    $leftindex=$row->LeftIndex;
                }

                if($row->LeftMiddle==null || $row->LeftMiddle==""){
                    $leftmiddle="";
                }
                if($row->LeftMiddle!=null && $row->LeftMiddle!=""){
                    $leftmiddle=$row->LeftMiddle;
                }

                if($row->LeftRing==null || $row->LeftRing==""){
                    $leftring="";
                }
                if($row->LeftRing!=null && $row->LeftRing!=""){
                    $leftring=$row->LeftRing;
                }

                if($row->LeftPinky==null || $row->LeftPinky==""){
                    $leftpicky="";
                }
                if($row->LeftPinky!=null && $row->LeftPinky!=""){
                    $leftpicky=$row->LeftPinky;
                }

                if($row->RightThumb==null || $row->RightThumb==""){
                    $rightthumb="";
                }
                if($row->RightThumb!=null && $row->RightThumb!=""){
                    $rightthumb=$row->RightThumb;
                }

                if($row->RightIndex==null || $row->RightIndex==""){
                    $rightindex="";
                }
                if($row->RightIndex!=null && $row->RightIndex!=""){
                    $rightindex=$row->RightIndex;
                }

                if($row->RightMiddle==null || $row->RightMiddle==""){
                    $rightmiddle="";
                }
                if($row->RightMiddle!=null && $row->RightMiddle!=""){
                    $rightmiddle=$row->RightMiddle;
                }

                if($row->RightRing==null || $row->RightRing==""){
                    $rightring="";
                }
                if($row->RightRing!=null && $row->RightRing!=""){
                    $rightring=$row->RightRing;
                }

                if($row->RightPinky==null || $row->RightPinky==""){
                    $rightpicky="";
                }
                if($row->RightPinky!=null && $row->RightPinky!=""){
                    $rightpicky=$row->RightPinky;
                }

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

                // if($meridiam=="AM"){
                //     if($row->FirstHalfFrom==null || $row->FirstHalfFrom==""){
                //         $starttime="11:59:59";
                //     }
                //     if($row->FirstHalfFrom!=null && $row->FirstHalfFrom!=""){
                //         $starttime=$row->FirstHalfFrom.":00";
                //     }

                //     if($row->FirstHalfTo==null || $row->FirstHalfTo==""){
                //         $endtime="11:59:59";
                //     }
                //     if($row->FirstHalfTo!=null && $row->FirstHalfTo!=""){
                //         $endtime=$row->FirstHalfTo.":59";
                //     }
                // }
                // if($meridiam=="PM"){
                //     if($row->SecondHalfFrom==null || $row->SecondHalfFrom==""){
                //         $starttime="23:59:59";
                //     }
                //     if($row->SecondHalfFrom!=null && $row->SecondHalfFrom!=""){
                //         $starttime=$row->SecondHalfFrom.":00";
                //     }

                //     if($row->SecondHalfTo==null || $row->SecondHalfTo==""){
                //         $endtime="23:59:59";
                //     }
                //     if($row->SecondHalfTo!=null && $row->SecondHalfTo!=""){
                //         $endtime=$row->SecondHalfTo.":59";
                //     }
                // }

                if($row->Gender=="Male"){
                    $gender=0;
                    if($row->Picture==null){
                        $picdata="dummymale.jpg";
                    }
                }
                if($row->Gender=="Female"){
                    $gender=1;
                    if($row->Picture==null){
                        $picdata="dummyfemale.jpg";
                    }
                }

                if($row->MemberStatus=="Active"){
                    $persontype=0;
                }
                if($row->MemberStatus!="Active"){
                    $persontype=1;
                }

                if($row->Picture!=null){
                    $imagepath = public_path().'/storage/uploads/MemberPicture/'.$row->Picture;
                    //$picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                    $picdata=$row->Picture;
                }
                // if($row->Picture==null){
                //     $picdata=$defpic;
                // }

                $topic="mqtt/face/".$row->DeviceId;
                $topicrec="mqtt/face/".$row->DeviceId."/Ack";

                $msgs='{
                    "operator": "EditPerson",
                    "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                    "info":
                    {
                        "facesluiceId":"'.$row->DeviceId.'",
                        "customId":"'.$row->MemberIdVal.'",
                        "tempCardType":2,
                        "personType":"'.$persontype.'",
                        "name":"'.$row->Name.'",
                        "gender":"'.$gender.'",
                        "birthday":"'.$row->DOB.'",
                        "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                        "address":"'.$row->Location.'",
                        "PersonUUID":"'.$row->PersonUUID.'",
                        "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                        "cardValidEnd":"'.$row->RegistrationDate." ".$endtime.'",
                        "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                                 
                    },
                }';
                $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                    if ($elapsedTime >= 8) {
                        $mqtts->interrupt();
                    }
                });
                // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                //     $mqt->userid=$userid;
                //     $mqt->uuid=$mquuid;
                //     $mqt->message=$message;
                //     $mqt->save();
                // }, 2);
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
                        "PersonUUID":"'.$row->MemberIdVal.'",
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
                // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                //     $mqt->userid=$userid;
                //     $mqt->uuid=$fpmquuid;
                //     $mqt->message=$message;
                //     $mqt->save();
                // }, 2);
                $mqtt->publish($topic,$fpmsgs,2);
                $mqtt->loop(true);

                // $resmsgs='{
                //     "operator": "RebootDevice",
                //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                //     "info":
                //     {
                //         "facesluiceId":"'.$devid.'",
                //     },
                // }';     
                // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                //     if ($elapsedTime >= 10) {
                //         $mqtts->interrupt();
                //     }
                // });
                // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                //     $mqt->userid=$userid;
                //     $mqt->uuid=$mquuid;
                //     $mqt->message=$message;
                //     $mqt->save();
                // }, 2);
                // $mqtt->publish($topic,$resmsgs,2);
                // $mqtt->loop(true);

                $getexitdevice=DB::select('SELECT * FROM devices WHERE devices.Status="Active" AND devices.devicetype=3');
                foreach($getexitdevice as $devrow)
                {
                    $topic="mqtt/face/".$devrow->DeviceId;
                    $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                    
                    $msgs='{
                        "operator": "EditPerson",
                        "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                        "info":
                        {
                            "facesluiceId":"'.$devrow->DeviceId.'",
                            "customId":"'.$row->MemberIdVal.'",
                            "tempCardType":2,
                            "personType":"'.$persontype.'",
                            "name":"'.$row->Name.'",
                            "gender":"'.$gender.'",
                            "birthday":"'.$row->DOB.'",
                            "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                            "address":"'.$row->Location.'",
                            "PersonUUID":"'.$row->PersonUUID.'",
                            "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                            "cardValidEnd":"'.$row->RegistrationDate." ".$endtime.'",
                            "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                                 
                        },
                    }';
                    $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                        if ($elapsedTime >= 8) {
                            $mqtts->interrupt();
                        }
                    });
                    // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                    //     $mqt->userid=$userid;
                    //     $mqt->uuid=$mquuid;
                    //     $mqt->message=$message;
                    //     $mqt->save();
                    // }, 2);
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
                            "PersonUUID":"'.$row->MemberIdVal.'",
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
                    // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                    //     $mqt->userid=$userid;
                    //     $mqt->uuid=$fpmquuid;
                    //     $mqt->message=$message;
                    //     $mqt->save();
                    // }, 2);
                    $mqtt->publish($topic,$fpmsgs,2);
                    $mqtt->loop(true);

                    // $resmsgs='{
                    //     "operator": "RebootDevice",
                    //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                    //     "info":
                    //     {
                    //         "facesluiceId":"'.$devid.'",
                    //     },
                    // }';     
                    // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                    //     if ($elapsedTime >= 8) {
                    //         $mqtts->interrupt();
                    //     }
                    // });
                    // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                    //     $mqt->userid=$userid;
                    //     $mqt->uuid=$mquuid;
                    //     $mqt->message=$message;
                    //     $mqt->save();
                    // }, 2);
                    // $mqtt->publish($topic,$resmsgs,2);
                    // $mqtt->loop(true);

                }
            }
            $mqtt->disconnect();
            $updatesendflag=DB::select('UPDATE applications SET applications.sendflag=1 WHERE applications.id='.$findid);
            return Response::json(['success' =>1]);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function syncToDevice(Request $request)
    {
        $host = request()->getSchemeAndHttpHost(); 
        ini_set('max_execution_time', '300000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->sendappid;
        $memberids=$request->syncmemid;
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
        $starttime=null;
        $endtime=null;
        $starttimefirsthalf=null;
        $endtimefirsthalf=null;
        $starttimesecondhalf=null;
        $endtimesecondhalf=null;
        $mquuid = Str::uuid()->toString();
        $currtime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');
        $membercount=0;

        try{
            $mquuid = Str::uuid()->toString();
            $mqt=new mqttmessage;
            $mqtt = MQTT::connection();

            $getallclients=DB::select('SELECT appconsolidates.memberships_id AS MemberIdVal,memberships.*,memberships.Status AS MemberStatus,periods.PeriodName,(SELECT perioddetails.FirstHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfFrom,(SELECT perioddetails.FirstHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfTo,(SELECT perioddetails.SecondHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfFrom,(SELECT perioddetails.SecondHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfTo,appconsolidates.devices_id,devices.*,appconsolidates.RegistrationDate,appconsolidates.ExpiryDate,applications.Status FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN devices ON appconsolidates.devices_id=devices.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE appconsolidates.Status IN("Active") AND appconsolidates.memberships_id='.$memberids);
            foreach($getallclients as $row)
            {
                if($row->LeftThumb==null || $row->LeftThumb==""){
                    $leftthumb="";
                }
                if($row->LeftThumb!=null && $row->LeftThumb!=""){
                    $leftthumb=$row->LeftThumb;
                }

                if($row->LeftIndex==null || $row->LeftIndex==""){
                    $leftindex="";
                }
                if($row->LeftIndex!=null && $row->LeftIndex!=""){
                    $leftindex=$row->LeftIndex;
                }

                if($row->LeftMiddle==null || $row->LeftMiddle==""){
                    $leftmiddle="";
                }
                if($row->LeftMiddle!=null && $row->LeftMiddle!=""){
                    $leftmiddle=$row->LeftMiddle;
                }

                if($row->LeftRing==null || $row->LeftRing==""){
                    $leftring="";
                }
                if($row->LeftRing!=null && $row->LeftRing!=""){
                    $leftring=$row->LeftRing;
                }

                if($row->LeftPinky==null || $row->LeftPinky==""){
                    $leftpicky="";
                }
                if($row->LeftPinky!=null && $row->LeftPinky!=""){
                    $leftpicky=$row->LeftPinky;
                }

                if($row->RightThumb==null || $row->RightThumb==""){
                    $rightthumb="";
                }
                if($row->RightThumb!=null && $row->RightThumb!=""){
                    $rightthumb=$row->RightThumb;
                }

                if($row->RightIndex==null || $row->RightIndex==""){
                    $rightindex="";
                }
                if($row->RightIndex!=null && $row->RightIndex!=""){
                    $rightindex=$row->RightIndex;
                }

                if($row->RightMiddle==null || $row->RightMiddle==""){
                    $rightmiddle="";
                }
                if($row->RightMiddle!=null && $row->RightMiddle!=""){
                    $rightmiddle=$row->RightMiddle;
                }

                if($row->RightRing==null || $row->RightRing==""){
                    $rightring="";
                }
                if($row->RightRing!=null && $row->RightRing!=""){
                    $rightring=$row->RightRing;
                }

                if($row->RightPinky==null || $row->RightPinky==""){
                    $rightpicky="";
                }
                if($row->RightPinky!=null && $row->RightPinky!=""){
                    $rightpicky=$row->RightPinky;
                }

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
                }
                if($currtime>=11){
                    if($starttimefirsthalf!="11:59:59" && $starttimesecondhalf=="12:00:00"){
                        $starttime=$starttimefirsthalf;
                    }
                    if($starttimefirsthalf=="11:59:59"){
                        $starttime=$starttimesecondhalf;
                    }

                    if($row->SecondHalfTo==null || $row->SecondHalfTo==""){
                        $endtime="23:59:59";
                    }
                    if($row->SecondHalfTo!=null && $row->SecondHalfTo!=""){
                        $endtime=$row->SecondHalfTo.":59";
                    }
                }

                if($row->Gender=="Male"){
                    $gender=0;
                    if($row->Picture==null){
                        $picdata="dummymale.jpg";
                    }
                }
                if($row->Gender=="Female"){
                    $gender=1;
                    if($row->Picture==null){
                        $picdata="dummyfemale.jpg";
                    }
                }

                if($row->MemberStatus=="Active"){
                    $persontype=0;
                }
                if($row->MemberStatus!="Active"){
                    $persontype=1;
                }

                if($row->Picture!=null){
                    $imagepath = public_path().'/storage/uploads/MemberPicture/'.$row->Picture;
                    //$picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                    $picdata=$row->Picture;
                }
                // if($row->Picture==null){
                //     $picdata=$defpic;
                // }

                $topic="mqtt/face/".$row->DeviceId;
                $topicrec="mqtt/face/".$row->DeviceId."/Ack";

                $msgs='{
                    "operator": "EditPerson",
                    "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                    "info":
                    {
                        "facesluiceId":"'.$row->DeviceId.'",
                        "customId":"'.$row->MemberIdVal.'",
                        "tempCardType":2,
                        "personType":"'.$persontype.'",
                        "name":"'.$row->Name.'",
                        "gender":"'.$gender.'",
                        "birthday":"'.$row->DOB.'",
                        "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                        "address":"'.$row->Location.'",
                        "PersonUUID":"'.$row->PersonUUID.'",
                        "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                        "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                        "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                                 
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
                        "facesluiceId":"'.$row->DeviceId.'",
                        "IdType":2,
                        "PersonUUID":"'.$row->MemberIdVal.'",
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

                $getexitdevice=DB::select('SELECT * FROM devices WHERE devices.Status="Active" AND devices.devicetype=3');
                foreach($getexitdevice as $devrow)
                {
                    $topic="mqtt/face/".$devrow->DeviceId;
                    $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                    
                    $msgs='{
                        "operator": "EditPerson",
                        "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                        "info":
                        {
                            "facesluiceId":"'.$devrow->DeviceId.'",
                            "customId":"'.$row->MemberIdVal.'",
                            "tempCardType":2,
                            "personType":"'.$persontype.'",
                            "name":"'.$row->Name.'",
                            "gender":"'.$gender.'",
                            "birthday":"'.$row->DOB.'",
                            "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                            "address":"'.$row->Location.'",
                            "PersonUUID":"'.$row->PersonUUID.'",
                            "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                            "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                            "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                                 
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
                            "facesluiceId":"'.$row->DeviceId.'",
                            "IdType":2,
                            "PersonUUID":"'.$row->MemberIdVal.'",
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
                $membercount+=1;;
            }
            $mqtt->disconnect();
            return Response::json(['success' =>1,'memcnt'=>$membercount]);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function undoVoidAppliaction(Request $request)
    {
        $host = request()->getSchemeAndHttpHost(); 
        ini_set('max_execution_time', '300000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $totalout=0;
        $totalsett=0;
        $totalrem=0;
        $icount=0;
        $currmemloystatus=0;
        $memloystatus=0;
        $memloystatus=0;
        $memcount=0;
        $grpinvolve=0;
        $findid=$request->undovoidid;
        $sett=ApplicationForm::find($findid);
        $vnumber=$sett->VoucherNumber;//get voucher number
        $inumber=$sett->InvoiceNumber;//get voucher number
        $oldstatus=$sett->OldStatus;//get old status
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $newvouchernumber=str_replace("(void".$findid.")","",$vnumber);
        $newinvoicenumber=str_replace("(void".$findid.")","",$inumber);

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
        $starttime=null;
        $endtime=null;
        $starttimefirsthalf=null;
        $endtimefirsthalf=null;
        $starttimesecondhalf=null;
        $endtimesecondhalf=null;
        $mquuid = Str::uuid()->toString();
        $currtime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');
       
        $getCountedVouchernum=DB::select('select count(id) as VoucherCount from applications where applications.VoucherNumber="'.$newvouchernumber.'"');
        foreach($getCountedVouchernum as $row)
        {
            $vcount=$row->VoucherCount;
        }

        $getCountedInvoiceNumber=DB::select('select count(id) as InvoiceCount from applications where applications.InvoiceNumber="'.$newinvoicenumber.'"');
        foreach($getCountedInvoiceNumber as $row)
        {
            $icount=$row->InvoiceCount;
        }

        $getloyaltystaus=DB::select('SELECT COUNT(appmembers.id) AS MemberCount FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id='.$findid.' AND (SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(memberships.LoyalityStatus))!=((SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(appmembers.LoyalityStatus))-1)');
        foreach($getloyaltystaus as $row)
        {
            $memcount=$row->MemberCount;
        }

        $getgroupinv=DB::select('SELECT COUNT(appmembers.memberships_id) AS MemberGroupCount FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id WHERE applications.Status IN("Pending","Verified","Frozen","Expired") AND applications.Type IN("Group") AND appmembers.memberships_id IN(SELECT appmembers.memberships_id FROM appmembers WHERE appmembers.applications_id='.$findid.')');
        foreach ($getgroupinv as $row) {
            $grpinvolve = $row->MemberGroupCount;
        }

        $vcounts = (float)$vcount;
        $icounts = (float)$icount;
        if($vcounts>=1){
            return Response::json(['undoerror'=>"error"]);
        }
        else if($icounts>=1){
            return Response::json(['undoinverror'=>"error"]);
        }
        // else if($memcount>=1){
        //     $getmemList=DB::select('SELECT appmembers.memberships_id,memberships.Name FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id='.$findid.' AND (SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(memberships.LoyalityStatus))!=((SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(appmembers.LoyalityStatus))-1)');
        //     return Response::json(['memcnt'=>"error",'countMembers'=>$getmemList]);
        // }
        // else if($grpinvolve>=1){
        //     $getgrpmember=DB::select('SELECT memberships.Name FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE applications.Status IN("Pending","Verified","Frozen","Expired") AND applications.Type IN("Group") AND appmembers.memberships_id IN(SELECT appmembers.memberships_id FROM appmembers WHERE appmembers.applications_id='.$findid.')');
        //     return Response::json(['grpinv'=>"error",'grpMembers'=>$getgrpmember]);
        // }
        else{
            try{
                if($oldstatus=="Verified"||$oldstatus=="Pending"){
                    $mquuid = Str::uuid()->toString();
                    $mqt=new mqttmessage;
                    $mqtt = MQTT::connection();

                    $getallclients=DB::select('SELECT appconsolidates.memberships_id AS MemberIdVal,memberships.*,memberships.Status AS MemberStatus,periods.PeriodName,(SELECT perioddetails.FirstHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfFrom,(SELECT perioddetails.FirstHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfTo,(SELECT perioddetails.SecondHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfFrom,(SELECT perioddetails.SecondHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfTo,appconsolidates.devices_id,devices.*,applications.RegistrationDate,applications.ExpiryDate,applications.Status FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN devices ON appconsolidates.devices_id=devices.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE appconsolidates.applications_id='.$findid);
                    foreach($getallclients as $row)
                    {
                        if($row->LeftThumb==null || $row->LeftThumb==""){
                            $leftthumb="";
                        }
                        if($row->LeftThumb!=null && $row->LeftThumb!=""){
                            $leftthumb=$row->LeftThumb;
                        }

                        if($row->LeftIndex==null || $row->LeftIndex==""){
                            $leftindex="";
                        }
                        if($row->LeftIndex!=null && $row->LeftIndex!=""){
                            $leftindex=$row->LeftIndex;
                        }

                        if($row->LeftMiddle==null || $row->LeftMiddle==""){
                            $leftmiddle="";
                        }
                        if($row->LeftMiddle!=null && $row->LeftMiddle!=""){
                            $leftmiddle=$row->LeftMiddle;
                        }

                        if($row->LeftRing==null || $row->LeftRing==""){
                            $leftring="";
                        }
                        if($row->LeftRing!=null && $row->LeftRing!=""){
                            $leftring=$row->LeftRing;
                        }

                        if($row->LeftPinky==null || $row->LeftPinky==""){
                            $leftpicky="";
                        }
                        if($row->LeftPinky!=null && $row->LeftPinky!=""){
                            $leftpicky=$row->LeftPinky;
                        }

                        if($row->RightThumb==null || $row->RightThumb==""){
                            $rightthumb="";
                        }
                        if($row->RightThumb!=null && $row->RightThumb!=""){
                            $rightthumb=$row->RightThumb;
                        }

                        if($row->RightIndex==null || $row->RightIndex==""){
                            $rightindex="";
                        }
                        if($row->RightIndex!=null && $row->RightIndex!=""){
                            $rightindex=$row->RightIndex;
                        }

                        if($row->RightMiddle==null || $row->RightMiddle==""){
                            $rightmiddle="";
                        }
                        if($row->RightMiddle!=null && $row->RightMiddle!=""){
                            $rightmiddle=$row->RightMiddle;
                        }

                        if($row->RightRing==null || $row->RightRing==""){
                            $rightring="";
                        }
                        if($row->RightRing!=null && $row->RightRing!=""){
                            $rightring=$row->RightRing;
                        }

                        if($row->RightPinky==null || $row->RightPinky==""){
                            $rightpicky="";
                        }
                        if($row->RightPinky!=null && $row->RightPinky!=""){
                            $rightpicky=$row->RightPinky;
                        }

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

                        // if($meridiam=="AM"){
                        //     if($row->FirstHalfFrom==null || $row->FirstHalfFrom==""){
                        //         $starttime="11:59:59";
                        //     }
                        //     if($row->FirstHalfFrom!=null && $row->FirstHalfFrom!=""){
                        //         $starttime=$row->FirstHalfFrom.":00";
                        //     }

                        //     if($row->FirstHalfTo==null || $row->FirstHalfTo==""){
                        //         $endtime="11:59:59";
                        //     }
                        //     if($row->FirstHalfTo!=null && $row->FirstHalfTo!=""){
                        //         $endtime=$row->FirstHalfTo.":59";
                        //     }
                        // }
                        // if($meridiam=="PM"){
                        //     if($row->SecondHalfFrom==null || $row->SecondHalfFrom==""){
                        //         $starttime="23:59:59";
                        //     }
                        //     if($row->SecondHalfFrom!=null && $row->SecondHalfFrom!=""){
                        //         $starttime=$row->SecondHalfFrom.":00";
                        //     }

                        //     if($row->SecondHalfTo==null || $row->SecondHalfTo==""){
                        //         $endtime="23:59:59";
                        //     }
                        //     if($row->SecondHalfTo!=null && $row->SecondHalfTo!=""){
                        //         $endtime=$row->SecondHalfTo.":59";
                        //     }
                        // }

                        if($row->Gender=="Male"){
                            $gender=0;
                            if($row->Picture==null){
                                $picdata="dummymale.jpg";
                            }
                        }
                        if($row->Gender=="Female"){
                            $gender=1;
                            if($row->Picture==null){
                                $picdata="dummyfemale.jpg";
                            }
                        }

                        if($row->MemberStatus=="Active"){
                            $persontype=0;
                        }
                        if($row->MemberStatus!="Active"){
                            $persontype=1;
                        }

                        if($row->Picture!=null){
                            $imagepath = public_path().'/storage/uploads/MemberPicture/'.$row->Picture;
                            //$picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                            $picdata=$row->Picture;
                        }
                        // if($row->Picture==null){
                        //     $picdata=$defpic;
                        // }

                        $topic="mqtt/face/".$row->DeviceId;
                        $topicrec="mqtt/face/".$row->DeviceId."/Ack";

                        $msgs='{
                            "operator": "EditPerson",
                            "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                            "info":
                            {
                                "facesluiceId":"'.$row->DeviceId.'",
                                "customId":"'.$row->MemberIdVal.'",
                                "tempCardType":2,
                                "personType":"'.$persontype.'",
                                "name":"'.$row->Name.'",
                                "gender":"'.$gender.'",
                                "birthday":"'.$row->DOB.'",
                                "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                                "address":"'.$row->Location.'",
                                "PersonUUID":"'.$row->PersonUUID.'",
                                "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                                "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                                
                            },
                        }';
                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 8) {
                                $mqtts->interrupt();
                            }
                        });
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$mquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
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
                                "PersonUUID":"'.$row->MemberIdVal.'",
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
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$fpmquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
                        $mqtt->publish($topic,$fpmsgs,2);
                        $mqtt->loop(true);

                        // $resmsgs='{
                        //     "operator": "RebootDevice",
                        //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                        //     "info":
                        //     {
                        //         "facesluiceId":"'.$devid.'",
                        //     },
                        // }';     
                        // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                        //     if ($elapsedTime >= 8) {
                        //         $mqtts->interrupt();
                        //     }
                        // });
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$mquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
                        // $mqtt->publish($topic,$resmsgs,2);
                        // $mqtt->loop(true);

                        $getexitdevice=DB::select('SELECT * FROM devices WHERE devices.Status="Active" AND devices.devicetype=3');
                        foreach($getexitdevice as $devrow)
                        {
                            $topic="mqtt/face/".$devrow->DeviceId;
                            $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                            
                            $msgs='{
                                "operator": "EditPerson",
                                "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                                "info":
                                {
                                    "facesluiceId":"'.$devrow->DeviceId.'",
                                    "customId":"'.$row->MemberIdVal.'",
                                    "tempCardType":2,
                                    "personType":"'.$persontype.'",
                                    "name":"'.$row->Name.'",
                                    "gender":"'.$gender.'",
                                    "birthday":"'.$row->DOB.'",
                                    "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                                    "address":"'.$row->Location.'",
                                    "PersonUUID":"'.$row->PersonUUID.'",
                                    "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                    "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                                    "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                                
                                },
                            }';
                            $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                if ($elapsedTime >= 8) {
                                    $mqtts->interrupt();
                                }
                            });
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$mquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
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
                                    "PersonUUID":"'.$row->MemberIdVal.'",
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
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$fpmquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
                            $mqtt->publish($topic,$fpmsgs,2);
                            $mqtt->loop(true);

                            // $resmsgs='{
                            //     "operator": "RebootDevice",
                            //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                            //     "info":
                            //     {
                            //         "facesluiceId":"'.$devid.'",
                            //     },
                            // }';     
                            // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            //     if ($elapsedTime >= 8) {
                            //         $mqtts->interrupt();
                            //     }
                            // });
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$mquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
                            // $mqtt->publish($topic,$resmsgs,2);
                            // $mqtt->loop(true);

                        }
                    }
                    $mqtt->disconnect();
                }
            
                $updateStatus=DB::select('UPDATE applications SET applications.Status=applications.OldStatus,applications.VoucherNumber=REPLACE(VoucherNumber,concat("(void",'.$findid.',")"),""),applications.InvoiceNumber=REPLACE(InvoiceNumber,concat("(void",'.$findid.',")"),"") WHERE id='.$findid.'');
                $sett->OldStatus="";
                $sett->IsVoid="0";
                $sett->UndoVoidBy=$user;
                $sett->UndoVoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                //$sett->UndoVoidDate=Carbon::today()->toDateString();
                $sett->save();
                $updatetonewstatus=DB::select('UPDATE appconsolidates SET appconsolidates.Status=appconsolidates.OldStatus WHERE appconsolidates.applications_id='.$findid);
                $updateloyaltymem=DB::select('UPDATE appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id SET memberships.LoyalityStatus=appmembers.LoyalityStatus WHERE memberships.id IN(SELECT DISTINCT appconsolidates.memberships_id FROM appconsolidates WHERE appconsolidates.applications_id='.$findid.') AND appmembers.applications_id='.$findid);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
    }

    public function undoRefundAppliaction(Request $request)
    {
        $host = request()->getSchemeAndHttpHost();
        ini_set('max_execution_time', '300000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $totalout=0;
        $totalsett=0;
        $totalrem=0;
        $icount=0;
        $currmemloystatus=0;
        $memloystatus=0;
        $memloystatus=0;
        $memcount=0;
        $grpinvolve=0;
        $findid=$request->undorefundid;
        $sett=ApplicationForm::find($findid);
        $oldstatus=$sett->OldStatus;//get old status
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;

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
        $starttime=null;
        $endtime=null;
        $starttimefirsthalf=null;
        $endtimefirsthalf=null;
        $starttimesecondhalf=null;
        $endtimesecondhalf=null;
        $mquuid = Str::uuid()->toString();
        $currtime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');

        $getloyaltystaus=DB::select('SELECT COUNT(appmembers.id) AS MemberCount FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id>'.$findid.' AND (SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(memberships.LoyalityStatus))!=((SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(appmembers.LoyalityStatus))-1)');
        foreach($getloyaltystaus as $row)
        {
            $memcount=$row->MemberCount;
        }

        $getgroupinv=DB::select('SELECT COUNT(appmembers.memberships_id) AS MemberGroupCount FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id WHERE applications.Status IN("Pending","Verified","Frozen","Expired") AND applications.Type IN("Group") AND appmembers.memberships_id IN(SELECT appmembers.memberships_id FROM appmembers WHERE appmembers.applications_id='.$findid.')');
        foreach ($getgroupinv as $row) {
            $grpinvolve = $row->MemberGroupCount;
        }

        if($memcount>=1){
            $getmemList=DB::select('SELECT appmembers.memberships_id,memberships.Name FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id='.$findid.' AND (SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(memberships.LoyalityStatus))!=((SELECT id FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=(appmembers.LoyalityStatus))-1)');
            return Response::json(['memcnt'=>"error",'countMembers'=>$getmemList]);
        }
        else if($grpinvolve>=1){
            $getgrpmember=DB::select('SELECT memberships.Name FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE applications.Status IN("Pending","Verified","Frozen","Expired") AND applications.Type IN("Group") AND appmembers.memberships_id IN(SELECT appmembers.memberships_id FROM appmembers WHERE appmembers.applications_id='.$findid.')');
            return Response::json(['grpinv'=>"error",'grpMembers'=>$getgrpmember]);
        }
        else{
            try{
                if($oldstatus=="Verified"||$oldstatus=="Pending"){
                    $mquuid = Str::uuid()->toString();
                    $mqt=new mqttmessage;
                    $mqtt = MQTT::connection();

                    $getallclients=DB::select('SELECT appconsolidates.memberships_id AS MemberIdVal,memberships.*,memberships.Status AS MemberStatus,periods.PeriodName,(SELECT perioddetails.FirstHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfFrom,(SELECT perioddetails.FirstHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS FirstHalfTo,(SELECT perioddetails.SecondHalfFrom FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfFrom,(SELECT perioddetails.SecondHalfTo FROM perioddetails WHERE perioddetails.periods_id=appconsolidates.periods_id AND perioddetails.Days="'.$dayname.'" AND perioddetails.Status="Active") AS SecondHalfTo,appconsolidates.devices_id,devices.*,applications.RegistrationDate,applications.ExpiryDate,applications.Status FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN devices ON appconsolidates.devices_id=devices.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE appconsolidates.applications_id='.$findid);
                    foreach($getallclients as $row)
                    {
                        if($row->LeftThumb==null || $row->LeftThumb==""){
                            $leftthumb="";
                        }
                        if($row->LeftThumb!=null && $row->LeftThumb!=""){
                            $leftthumb=$row->LeftThumb;
                        }

                        if($row->LeftIndex==null || $row->LeftIndex==""){
                            $leftindex="";
                        }
                        if($row->LeftIndex!=null && $row->LeftIndex!=""){
                            $leftindex=$row->LeftIndex;
                        }

                        if($row->LeftMiddle==null || $row->LeftMiddle==""){
                            $leftmiddle="";
                        }
                        if($row->LeftMiddle!=null && $row->LeftMiddle!=""){
                            $leftmiddle=$row->LeftMiddle;
                        }

                        if($row->LeftRing==null || $row->LeftRing==""){
                            $leftring="";
                        }
                        if($row->LeftRing!=null && $row->LeftRing!=""){
                            $leftring=$row->LeftRing;
                        }

                        if($row->LeftPinky==null || $row->LeftPinky==""){
                            $leftpicky="";
                        }
                        if($row->LeftPinky!=null && $row->LeftPinky!=""){
                            $leftpicky=$row->LeftPinky;
                        }

                        if($row->RightThumb==null || $row->RightThumb==""){
                            $rightthumb="";
                        }
                        if($row->RightThumb!=null && $row->RightThumb!=""){
                            $rightthumb=$row->RightThumb;
                        }

                        if($row->RightIndex==null || $row->RightIndex==""){
                            $rightindex="";
                        }
                        if($row->RightIndex!=null && $row->RightIndex!=""){
                            $rightindex=$row->RightIndex;
                        }

                        if($row->RightMiddle==null || $row->RightMiddle==""){
                            $rightmiddle="";
                        }
                        if($row->RightMiddle!=null && $row->RightMiddle!=""){
                            $rightmiddle=$row->RightMiddle;
                        }

                        if($row->RightRing==null || $row->RightRing==""){
                            $rightring="";
                        }
                        if($row->RightRing!=null && $row->RightRing!=""){
                            $rightring=$row->RightRing;
                        }

                        if($row->RightPinky==null || $row->RightPinky==""){
                            $rightpicky="";
                        }
                        if($row->RightPinky!=null && $row->RightPinky!=""){
                            $rightpicky=$row->RightPinky;
                        }

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

                        // if($meridiam=="AM"){
                        //     if($row->FirstHalfFrom==null || $row->FirstHalfFrom==""){
                        //         $starttime="11:59:59";
                        //     }
                        //     if($row->FirstHalfFrom!=null && $row->FirstHalfFrom!=""){
                        //         $starttime=$row->FirstHalfFrom.":00";
                        //     }

                        //     if($row->FirstHalfTo==null || $row->FirstHalfTo==""){
                        //         $endtime="11:59:59";
                        //     }
                        //     if($row->FirstHalfTo!=null && $row->FirstHalfTo!=""){
                        //         $endtime=$row->FirstHalfTo.":59";
                        //     }
                        // }
                        // if($meridiam=="PM"){
                        //     if($row->SecondHalfFrom==null || $row->SecondHalfFrom==""){
                        //         $starttime="23:59:59";
                        //     }
                        //     if($row->SecondHalfFrom!=null && $row->SecondHalfFrom!=""){
                        //         $starttime=$row->SecondHalfFrom.":00";
                        //     }

                        //     if($row->SecondHalfTo==null || $row->SecondHalfTo==""){
                        //         $endtime="23:59:59";
                        //     }
                        //     if($row->SecondHalfTo!=null && $row->SecondHalfTo!=""){
                        //         $endtime=$row->SecondHalfTo.":59";
                        //     }
                        // }

                        if($row->Gender=="Male"){
                            $gender=0;
                            if($row->Picture==null){
                                $picdata="dummymale.jpg";
                            }
                        }
                        if($row->Gender=="Female"){
                            $gender=1;
                            if($row->Picture==null){
                                $picdata="dummyfemale.jpg";
                            }
                        }

                        if($row->MemberStatus=="Active"){
                            $persontype=0;
                        }
                        if($row->MemberStatus!="Active"){
                            $persontype=1;
                        }

                        if($row->Picture!=null){
                            $imagepath = public_path().'/storage/uploads/MemberPicture/'.$row->Picture;
                            // $picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                            $picdata=$row->Picture;
                        }
                        // if($row->Picture==null){
                        //     $picdata=$defpic;
                        // }

                        $topic="mqtt/face/".$row->DeviceId;
                        $topicrec="mqtt/face/".$row->DeviceId."/Ack";

                        $msgs='{
                            "operator": "EditPerson",
                            "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                            "info":
                            {
                                "facesluiceId":"'.$row->DeviceId.'",
                                "customId":"'.$row->MemberIdVal.'",
                                "tempCardType":2,
                                "personType":"'.$persontype.'",
                                "name":"'.$row->Name.'",
                                "gender":"'.$gender.'",
                                "birthday":"'.$row->DOB.'",
                                "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                                "address":"'.$row->Location.'",
                                "PersonUUID":"'.$row->PersonUUID.'",
                                "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                                "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                                  
                            },
                        }';
                        $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            if ($elapsedTime >= 8) {
                                $mqtts->interrupt();
                            }
                        });
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$mquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
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
                                "PersonUUID":"'.$row->MemberIdVal.'",
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

                        // $resmsgs='{
                        //     "operator": "RebootDevice",
                        //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                        //     "info":
                        //     {
                        //         "facesluiceId":"'.$devid.'",
                        //     },
                        // }';     
                        // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                        //     if ($elapsedTime >= 8) {
                        //         $mqtts->interrupt();
                        //     }
                        // });
                        // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                        //     $mqt->userid=$userid;
                        //     $mqt->uuid=$mquuid;
                        //     $mqt->message=$message;
                        //     $mqt->save();
                        // }, 2);
                        // $mqtt->publish($topic,$resmsgs,2);
                        // $mqtt->loop(true);

                        $getexitdevice=DB::select('SELECT * FROM devices WHERE devices.Status="Active" AND devices.devicetype=3');
                        foreach($getexitdevice as $devrow)
                        {
                            $topic="mqtt/face/".$devrow->DeviceId;
                            $topicrec="mqtt/face/".$devrow->DeviceId."/Ack";
                            
                            $msgs='{
                                "operator": "EditPerson",
                                "messageId":"MessageID-EditPerson-'.$row->PersonUUID.'",
                                "info":
                                {
                                    "facesluiceId":"'.$devrow->DeviceId.'",
                                    "customId":"'.$row->MemberIdVal.'",
                                    "tempCardType":2,
                                    "personType":"'.$persontype.'",
                                    "name":"'.$row->Name.'",
                                    "gender":"'.$gender.'",
                                    "birthday":"'.$row->DOB.'",
                                    "telnum1":"'.$row->Mobile." , ".$row->Phone.'",
                                    "address":"'.$row->Location.'",
                                    "PersonUUID":"'.$row->PersonUUID.'",
                                    "cardValidBegin":"'.$row->RegistrationDate." ".$starttime.'",
                                    "cardValidEnd":"'.$row->ExpiryDate." ".$endtime.'",
                                    "picURI":"'.$host."/storage/uploads/MemberPicture/".$picdata.'"                                  
                                },
                            }';
                            $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                                if ($elapsedTime >= 8) {
                                    $mqtts->interrupt();
                                }
                            });
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$mquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
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
                                    "PersonUUID":"'.$row->MemberIdVal.'",
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
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$fpmquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
                            $mqtt->publish($topic,$fpmsgs,2);
                            $mqtt->loop(true);

                            // $resmsgs='{
                            //     "operator": "RebootDevice",
                            //     "messageId":"ID:RebootDevice-'.$mquuid.'",
                            //     "info":
                            //     {
                            //         "facesluiceId":"'.$devid.'",
                            //     },
                            // }';     
                            // $mqtt->registerLoopEventHandler(function (MqttClient $mqtts, float $elapsedTime) {
                            //     if ($elapsedTime >= 8) {
                            //         $mqtts->interrupt();
                            //     }
                            // });
                            // $mqtt->subscribe($topicrec, function (string $topic, string $message) use($mqtt,$userid,$mquuid,$mqt) {
                            //     $mqt->userid=$userid;
                            //     $mqt->uuid=$mquuid;
                            //     $mqt->message=$message;
                            //     $mqt->save();
                            // }, 2);
                            // $mqtt->publish($topic,$resmsgs,2);
                            // $mqtt->loop(true);

                        }
                    }
                    $mqtt->disconnect();
                }

                $updateStatus=DB::select('UPDATE applications SET applications.Status=applications.OldStatus WHERE id='.$findid.'');
                $sett->OldStatus="";
                $sett->IsVoid="0";
                $sett->UndoRefundBy=$user;
                $sett->UndoRefundDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $sett->save();
                $updatetonewstatus=DB::select('UPDATE appconsolidates SET appconsolidates.Status=appconsolidates.OldStatus WHERE appconsolidates.applications_id='.$findid);
                $updateloyaltymem=DB::select('UPDATE appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id SET memberships.LoyalityStatus=appmembers.LoyalityStatus WHERE memberships.id IN(SELECT DISTINCT appconsolidates.memberships_id FROM appconsolidates WHERE appconsolidates.applications_id='.$findid.') AND appmembers.applications_id='.$findid);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
    }

    public function syncClients(Request $request){
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
        $starttimefirsthalf=null;
        $endtimefirsthalf=null;
        $starttimesecondhalf=null;
        $endtimesecondhalf=null;
        $mquuid = Str::uuid()->toString();
        $currtime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');

        for($i=1;$i<=10000000000000;$i++){
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

                        //start assign variables each period values 
                        if($mrow->FirstHalfFrom==null || $mrow->FirstHalfFrom==""){
                            $starttimefirsthalf="11:59:59";
                        }
                        if($mrow->FirstHalfFrom!=null && $mrow->FirstHalfFrom!=""){
                            $starttimefirsthalf=$mrow->FirstHalfFrom.":00";
                        }

                        if($mrow->FirstHalfTo==null || $mrow->FirstHalfTo==""){
                            $endtimefirsthalf="11:59:58";
                        }
                        if($mrow->FirstHalfTo!=null && $mrow->FirstHalfTo!=""){
                            $endtimefirsthalf=$mrow->FirstHalfTo.":59";
                        }

                        if($mrow->SecondHalfFrom==null || $mrow->SecondHalfFrom==""){
                            $starttimesecondhalf="23:59:59";
                        }
                        if($mrow->SecondHalfFrom!=null && $mrow->SecondHalfFrom!=""){
                            $starttimesecondhalf=$mrow->SecondHalfFrom.":00";
                        }

                        if($mrow->SecondHalfTo==null || $mrow->SecondHalfTo==""){
                            $endtimesecondhalf="23:59:59";
                        }
                        if($mrow->SecondHalfTo!=null && $mrow->SecondHalfTo!=""){
                            $endtimesecondhalf=$mrow->SecondHalfTo.":59";
                        }                        
                        //end assign variables each period values 

                        if($currtime<11){
                            if($endtimefirsthalf=="11:59:59" && $starttimesecondhalf=="12:00:00"){
                                $endtime=$endtimesecondhalf;
                            }
                            if($endtimefirsthalf!="11:59:59" || $starttimesecondhalf!="12:00:00"){
                                $endtime=$endtimefirsthalf;
                            }

                            if($mrow->FirstHalfFrom==null || $mrow->FirstHalfFrom==""){
                                $starttime="11:59:59";
                            }
                            if($mrow->FirstHalfFrom!=null && $mrow->FirstHalfFrom!=""){
                                $starttime=$mrow->FirstHalfFrom.":00";
                            }

                            // if($mrow->FirstHalfTo==null || $mrow->FirstHalfTo==""){
                            //     $endtime="11:59:59";
                            // }
                            // if($mrow->FirstHalfTo!=null && $mrow->FirstHalfTo!=""){
                            //     $endtime=$mrow->FirstHalfTo.":59";
                            // }
                        }
                        if($currtime>=11){
                            if($starttimefirsthalf!="11:59:59" && $starttimesecondhalf=="12:00:00"){
                                $starttime=$starttimefirsthalf;
                            }
                            if($starttimefirsthalf=="11:59:59"){
                                $starttime=$starttimesecondhalf;
                            }

                            // if($mrow->SecondHalfFrom==null || $mrow->SecondHalfFrom==""){
                            //     $starttime="23:59:59";
                            // }
                            // if($mrow->SecondHalfFrom!=null && $mrow->SecondHalfFrom!=""){
                            //     $starttime=$mrow->SecondHalfFrom.":00";
                            // }

                            if($mrow->SecondHalfTo==null || $mrow->SecondHalfTo==""){
                                $endtime="23:59:59";
                            }
                            if($mrow->SecondHalfTo!=null && $mrow->SecondHalfTo!=""){
                                $endtime=$mrow->SecondHalfTo.":59";
                            }
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
                            "messageId":"MessageID-EditPersons-'.$mquuid.'",
                            "DataBegin":"BeginFlag",
                            "operator": "EditPersons",
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

    public function getServicePeriodTrn(Request $request){
        $appid=$_POST['applicationId']; 
        $servid=$_POST['servicepr']; 
        $memid=$_POST['memberid'];
        $grps=$_POST['grp'];
        $pterms=$_POST['pterm'];
        $periodid=0;
        $membercntval=0;

        $data = appconsolidate::where('appconsolidates.applications_id',$appid)
        ->where('appconsolidates.memberships_id',$memid)
        ->where('appconsolidates.services_id',$servid)
        ->distinct()
        ->get(['appconsolidates.*']);
        foreach ($data as $row) {
            $periodid = $row->periods_id;
        }

        $getmembercount=DB::select('SELECT COUNT(appconsolidates.memberships_id) AS MemberCnt FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE appconsolidates.applications_id<'.$appid.' AND appconsolidates.memberships_id='.$memid.' AND applications.Status IN("Active","Pending","Expired","Frozen")');
        foreach ($getmembercount as $row) {
            $membercntval = $row->MemberCnt;
        }
        
        if($membercntval==0){
            $servdata = servicedetail::where('servicedetails.services_id',$servid)
            ->where('servicedetails.groupmembers_id',$grps)
            ->where('servicedetails.paymentterms_id',$pterms)
            ->where('servicedetails.periods_id',$periodid)
            ->distinct()
            ->get(['servicedetails.NewTrainerFee AS TrainerFee']);
        }
        if($membercntval>=1){
            $servdata = servicedetail::where('servicedetails.services_id',$servid)
            ->where('servicedetails.groupmembers_id',$grps)
            ->where('servicedetails.paymentterms_id',$pterms)
            ->where('servicedetails.periods_id',$periodid)
            ->distinct()
            ->get(['servicedetails.ExistingTrainerFee AS TrainerFee']);
        }
        return response()->json(['applist'=>$servdata,'periodid'=>$periodid]);
    }

    public function getMemberList(Request $request){
        $mid=$_POST['memId']; 
        $appid=$_POST['appid']; 
        $membercnt=0;
        $memcnt=0;
        $staydate=0;
        $grpinvolve=0;
        $findid=$request->applicationId;

        $data = membership::where('memberships.id',$mid)
        ->where('memberships.Status','=',"Active")
        ->distinct()
        ->get(['memberships.*',
            DB::raw('(SELECT loyaltystatuses.Discount FROM loyaltystatuses WHERE loyaltystatuses.LoyalityStatus=memberships.LoyalityStatus) AS MemberDiscount')
        ]);

        $getgroupinv=DB::select('SELECT COUNT(appmembers.memberships_id) AS MemberGroupCount FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id WHERE applications.Status IN("Pending","Verified","Frozen","Expired") AND applications.id!='.$appid.' AND appmembers.memberships_id='.$mid);
        foreach ($getgroupinv as $row) {
            $grpinvolve = $row->MemberGroupCount;
        }

        $getMemberCount=DB::select('SELECT COUNT(appmembers.memberships_id) AS MemberCount FROM appmembers INNER JOIN applications ON appmembers.applications_id=applications.id WHERE applications.Status IN("Pending","Verified","Frozen","Expired") AND appmembers.memberships_id='.$mid);
        foreach ($getMemberCount as $row) {
            $membercnt = $row->MemberCount;
        }
        if($membercnt>=1){
            $memcnt=1;
        }
        else if($membercnt==0){
            $memcnt=0;
        }
        if($findid==null){
            $getstaydate=DB::select('SELECT COALESCE(SUM(paymentterms.PaymentTermAmount),0) AS TotalStayDay FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id WHERE appconsolidates.memberships_id='.$mid.' AND applications.Status NOT IN("Archived","Void","Refund") AND applications.ApplicationType!="Trainer-Fee"');
            foreach ($getstaydate as $rowt) {
                $staydate = $rowt->TotalStayDay;
            }
        }
        else if($findid!=null){
            $getstaydate=DB::select('SELECT COALESCE(SUM(paymentterms.PaymentTermAmount),0) AS TotalStayDay FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id WHERE appconsolidates.memberships_id='.$mid.' AND applications.Status NOT IN("Archived","Void","Refund") AND applications.ApplicationType!="Trainer-Fee" AND appconsolidates.memberships_id!='.$findid);
            foreach ($getstaydate as $rowt) {
                $staydate = $rowt->TotalStayDay;
            }
        }

        return response()->json(['mtlist'=>$data,'memcnt'=>$memcnt,'stdate'=>$staydate,'grpinv'=>$grpinvolve]);       
    }

    public function getMrcList(Request $request){
        $posids=$_POST['posid']; 
        $data = storemrc::where('storemrcs.store_id',$posids)
        ->where('storemrcs.status','=',"Active")
        ->distinct()
        ->get(['storemrcs.store_id','storemrcs.mrcNumber']);
        return response()->json(['mrclist'=>$data]);       
    }

    public function getPaymentTypeInfo(Request $request){
        $posids=$_POST['posid']; 
        $data = store::where('stores.id',$posids)
        ->distinct()
        ->get(['stores.*']);
        return response()->json(['posprop'=>$data]);       
    }

    public function getlatestapp()
    {
        $renfsnum=$_POST['renfsnum']; 
        $getlastrec=DB::select('SELECT applications.id,CONCAT(applications.VoucherNumber,"    ,   ",applications.InvoiceNumber) AS FSNum,(SELECT GROUP_CONCAT(DISTINCT IFNULL(memberships.Name,""),"  ",IFNULL(memberships.Mobile,""),"	",IFNULL(memberships.Phone,"")) FROM memberships WHERE memberships.id IN(SELECT appconsolidates.memberships_id FROM appconsolidates WHERE appconsolidates.applications_id=applications.id)) AS MemberInfo, (SELECT GROUP_CONCAT(DISTINCT (services.ServiceName)) FROM services WHERE services.id IN(SELECT appconsolidates.services_id FROM appconsolidates WHERE appconsolidates.applications_id=applications.id)) AS ServiceInfo FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status IN("Pending","Verified","Frozen","Expired") AND applications.ApplicationType!="Trainer-Fee" AND applications.paymentterms_id!=5 AND applications.VoucherNumber='.$renfsnum.' GROUP BY applications.id ORDER BY applications.id DESC LIMIT 1');
        return response()->json(['getlastrec'=>$getlastrec]);
    }

    public function regDateCon(Request $request){
        $month=0;
        $expirydate=0;
        $expiredatehidden="";
        $typevals="";
        $rdate=$_POST['regdate']; 
        $daysval=$_POST['days']; 
        $expiredatehidden=$_POST['expiredatehidden']; 
        $typevals=$_POST['typeval']; 
        $month=$daysval/30;
        if($month<1){
            $fdate=$daysval-1;
            $dt = Carbon::parse($rdate);
            $expirydate=$dt->addDay($fdate);
        }
        else{
            $dt = Carbon::parse($rdate);
            $expirydate=$dt->addMonth($month)->subDay(1);
        }

        $exdate=Carbon::parse($expirydate)->format("Y-m-d");
        return response()->json(['expiredate'=>$exdate]);       
    }

    public function downloadapp($ids,$file_name) 
    {
        $file_path = public_path('storage/uploads/ApplicationDocuments/'.$file_name);
        return response()->download($file_path);
    }
}
