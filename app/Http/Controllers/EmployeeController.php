<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\branch;
use App\Models\department;
use App\Models\position;
use App\Models\salary;
use App\Models\employee;
use App\Models\employementtype;
use App\Models\membership;
use App\Models\employe;
use App\Models\Country;
use App\Models\City;
use App\Models\Subcity;
use App\Models\shift;
use App\Models\device;
use App\Models\bank;
use App\Models\User;
use App\Models\mqttmessage;
use App\Models\hr_leavetype;
use App\Models\hr_employee_leave;
use App\Models\salarydetail;
use App\Models\hr_employee_salary;
use App\Models\emp_leavealloc;
use App\Models\hr_leave_transaction;
use App\Models\actions;
use App\Models\storeassignment;
use App\Models\employee_document;
use App\Models\employee_skill_set;
use App\Models\employee_salary;
use App\Models\companyinfo;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\model_has_role;
use Spatie\Permission\Models\Permission;
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
use Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $compId = 1;
        $currentdate = Carbon::today()->toDateString();
        $countrynat = Country::get(["name", "id"]);
        $country = Country::where("name","Ethiopia")->get(["name", "id"]);
        $city = City::get(["city_name", "id"]);
        $subcity = Subcity::orderBy("subcity_name","ASC")->get(["city_id","subcity_name", "id"]);
        $branch = branch::orderBy("BranchName","ASC")->where("Status","Active")->get(["BranchName","id"]);
        $department = department::orderBy("DepartmentName","ASC")->where("Status","Active")->where("id",">",1)->get(["DepartmentName","id"]);
        $position = position::orderBy("PositionName","ASC")->where("Status","Active")->get(["PositionName","departments_id","id"]);
        $salary = salary::orderBy("SalaryName","ASC")->where("Status","Active")->where("IsFixed",1)->get(["SalaryName","id"]);
        $shift = shift::orderBy("ShiftName","ASC")->where("Status","Active")->get(["ShiftName","id"]);
        $employee = employee::orderBy("name","ASC")->where("Status","Active")->get(["name","id"]);
        $employment = employementtype::orderBy("EmploymentTypeName","ASC")->where("Status","Active")->get(["EmploymentTypeName","id"]);
        $devices = device::where("Status","Active")->whereIn("devicetype",[4])->where("id",">",1)->get(["id", "DeviceName"]);
        $banks = bank::where("Status","Active")->orderBy("BankName","ASC")->get(["id", "BankName"]);
        //$roles = Role::where('id','>',1)->where('role_type',1)->pluck('name','name')->all();
        $hrleavetype = hr_leavetype::orderBy("LeaveType","ASC")->where("Status","Active")->where("RequiresBalance","Yes")->get(["id","LeaveType","LeavePaymentType"]);
        $earningsalary = DB::select('SELECT * FROM salarytypes WHERE salarytypes.SalaryType="Earnings" AND salarytypes.Status="Active"');
        $deductionsalary = DB::select('SELECT * FROM salarytypes WHERE salarytypes.SalaryType="Deductions" AND salarytypes.Status="Active"');
        $branchfilter = DB::select('SELECT DISTINCT branches.id,branches.BranchName FROM employees LEFT JOIN branches ON employees.branches_id=branches.id ORDER BY branches.BranchName ASC');        
        $departmentfilter = DB::select('SELECT DISTINCT departments.id,departments.DepartmentName FROM employees LEFT JOIN departments ON employees.departments_id=departments.id WHERE departments.id>1 ORDER BY departments.DepartmentName ASC');  
        $roles = Role::where('id','>',$uid = $userid == 1 ? 0 : 1)->pluck('name','name')->all();
        $skill_set = DB::select('SELECT * FROM skills WHERE skills.status="Active" ORDER BY skills.name ASC');
        $level = DB::select('SELECT * FROM lookuprefs WHERE lookuprefs.Status=1 AND lookuprefs.type=4 ORDER BY lookuprefs.LookupName ASC');
        $doc_type = DB::select('SELECT * FROM lookuprefs WHERE lookuprefs.Status=1 AND lookuprefs.type=5 ORDER BY lookuprefs.LookupName ASC');
        $titles = DB::select('SELECT * FROM lookuprefs WHERE lookuprefs.Status=1 AND lookuprefs.type=6 ORDER BY lookuprefs.LookupName ASC');
        $blood_type = DB::select('SELECT * FROM lookuprefs WHERE lookuprefs.Status=1 AND lookuprefs.type=7 ORDER BY lookuprefs.LookupName ASC');
        $compInfo = companyinfo::find($compId);
        if($request->ajax()) {
            return view('hr.setup.employee',['branch'=>$branch,'department'=>$department,'position'=>$position,'salary'=>$salary,'shift'=>$shift,
            'employee'=>$employee,'employment'=>$employment,'countrynat'=>$countrynat,'country'=>$country,'city'=>$city,'subcity'=>$subcity,
            'devices'=>$devices,'banks'=>$banks,'roles'=>$roles,'currentdate'=>$currentdate,'hrleavetype'=>$hrleavetype,'earningsalary'=>$earningsalary,
            'deductionsalary'=>$deductionsalary,'branchfilter'=>$branchfilter,'departmentfilter'=>$departmentfilter,'skill_set'=>$skill_set,
            'level'=>$level,'doc_type'=>$doc_type,'titles'=>$titles,'blood_type'=>$blood_type,'compInfo'=>$compInfo])->renderSections()['content'];
        }
        else{
            return view('hr.setup.employee',['branch'=>$branch,'department'=>$department,'position'=>$position,'salary'=>$salary,'shift'=>$shift,
            'employee'=>$employee,'employment'=>$employment,'countrynat'=>$countrynat,'country'=>$country,'city'=>$city,'subcity'=>$subcity,
            'devices'=>$devices,'banks'=>$banks,'roles'=>$roles,'currentdate'=>$currentdate,'hrleavetype'=>$hrleavetype,'earningsalary'=>$earningsalary,
            'deductionsalary'=>$deductionsalary,'branchfilter'=>$branchfilter,'departmentfilter'=>$departmentfilter,'skill_set'=>$skill_set,
            'level'=>$level,'doc_type'=>$doc_type,'titles'=>$titles,'blood_type'=>$blood_type,'compInfo'=>$compInfo]);
        }
    }


    public function employeelist()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $employelists = DB::select('SELECT employees.id,employees.EmployeeID,employees.name,branches.BranchName,departments.DepartmentName,positions.PositionName,salaries.SalaryName,emp.name AS LineManager,employementtypes.EmploymentTypeName,employees.Gender,employees.Status,employees.ActualPicture,employees.BiometricPicture,REPLACE(employees.MobileNumber,"-","") AS MobileNumber,REPLACE(employees.OfficePhoneNumber,"-","") AS OfficePhoneNumber,lookuprefs.LookupName AS emp_title FROM employees LEFT JOIN branches ON employees.branches_id=branches.id LEFT JOIN departments ON employees.departments_id=departments.id LEFT JOIN positions ON employees.positions_id=positions.id LEFT JOIN salaries ON employees.salaries_id=salaries.id LEFT JOIN employees AS emp ON employees.employees_id=emp.id LEFT JOIN employementtypes ON employees.employementtypes_id=employementtypes.id LEFT JOIN lookuprefs ON employees.title=lookuprefs.id WHERE employees.id>1 ORDER BY employees.id DESC');
        if(request()->ajax()) {
            return datatables()->of($employelists)
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
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $module_setting = DB::table('settings')->value('hr_setting'); 
        $modules = json_decode($module_setting, true);
        $hr_module_flag = $modules['hr']['enabled'];
        $wellness_module_flag = $modules['wellness']['enabled'];
        $medical_module_flag = $modules['medical']['enabled'];
        $rprefix = $settings->HrEmployeePrefix;
        $rnumber = $settings->HrEmployeeNumber;
        $rnumberPadding = sprintf("%06d", $rnumber);
        $employeeid = $rprefix.$rnumberPadding;
        $defpic = $settings->defaultpic;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $headerid = $request->recId;
        $findid = $request->recId;
        $supervisorid = 1;
        $parentManagerErrFlag = 0;
        $curdate = Carbon::today()->toDateString();
        $bankid = null;
        $actualPhoto = null;
        $bioPhotos = null;
        $picidName = null;
        $assign_pages = [
            'NA','receiving', 'issue','appr','pos','proforma','stbal','req','trnsrc','trndes','adj',
            'beg','posrep','purchaserep','invreport','trnrec','NA2','fitpos','wellrep','medrep'
        ];
        $store_assignment_data = [];

        $document_upload_data = [];
        $skill_set_data = [];

        $rightthumb = "";
        $rightindex = "";
        $rightmiddle = "";
        $rightring = "";
        $rightpicky = "";
        $leftthumb = "";
        $leftindex = "";
        $leftmiddle = "";
        $leftring = "";
        $leftpicky = "";
        $enrolldev = $request->EnrollDevice;
        $faceids = $request->faceidencoded;
        $uuid = Str::uuid()->toString();
        $userstatus = "";
        $empid = null;
        $accstatus = null;
        $leavetypesdata = [];
        $mquuid = Str::uuid()->toString();
        $currtime = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');
        $basic_validation = [];
        $hr_validation = [];
        $hr_doc_validation = [];
        $hr_cont_validation = [];
        $wellness_validation = [];
        $medical_validation = [];

        $basic_validation = [
            'title' => 'required',
            'FirstName'  => ['required','min:2','max:100','regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'MiddleName'  => ['required','min:2','max:100','regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'LastName'  => ['nullable','min:1','max:100','regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'name' => ['required',Rule::unique('employees')->where(function ($query){
                })->ignore($findid)
            ],
            'gender'=>'required',
            'Dob'=>'nullable|before:-15 years',
            'Branch' => 'required',
            'Department' => 'required',
            'Position' => 'required',
            'status'=>'required',

            'MobileNumber' => ['required','regex:/^\+251-[97]\d{2}-\d{2}-\d{2}-\d{2}$/','different:OfficePhoneNumber',Rule::unique('employees')->where(function ($query){
                })->ignore($findid)
            ],
            'OfficePhoneNumber' => ['nullable','regex:/^\+251-[97]\d{2}-\d{2}-\d{2}-\d{2}$/','different:MobileNumber',Rule::unique('employees')->where(function ($query){
                })->ignore($findid)
            ],
            'Email' => ['nullable','email:rfc,dns',Rule::unique('employees')->where(function ($query){
                })->ignore($findid)
            ],
            'country' => 'required',
            'city' => 'required',
            'subcity' => 'required',
            'Woreda'=>'required',
            'EmergencyPhone' => ['nullable','regex:/^\+251-[97]\d{2}-\d{2}-\d{2}-\d{2}$/','different:MobileNumber,OfficePhoneNumber'],
            'AccessStatus'=>'required',
            'roleid'=>'required_if:AccessStatus,Enable',
        ];

        if($hr_module_flag == true){
            $supervisorid = $request->SupervisorOrImmedaiteManager;
            $hr_validation = [
                //------HR start----
                'SupervisorOrImmedaiteManager'=>'required',
                'EmploymentType'=>'required',
                'HiredDate'=>'required',
                
                'Tin' => ['nullable','regex:/^(\d{10}|\d{13})$/',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'nationality'=>'required',
                'MartialStatus'=>'nullable',
                'BloodType'=>'nullable',

                'PassportNumber' => ['nullable',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'ResidanceIdNumber' => ['nullable',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'NationalIdNumber' => ['nullable',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'DrivingLicenseNumber' => ['nullable',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'Postcode' => ['nullable',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'imageUpload'=> 'mimes:jpg,jpeg,png|nullable',

                'EnableAttendance'=>'required',
                'EnableHoliday'=>'required',

                'GuarantorName'=>'required',
                'GuarantorPhone' => ['required','regex:/^\+251-[97]\d{2}-\d{2}-\d{2}-\d{2}$/','different:MobileNumber,OfficePhoneNumber'],
                'guarantorFile'=> 'nullable|mimes:pdf,jpg,jpeg,png',
                'GuarantorFileName'=>'nullable',

                'PIN' => ['nullable',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'CardNumber' => ['nullable',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'EnrollDevice'=>'required',
                'bioImageUpload'=> 'nullable|mimes:jpg,jpeg,png',

                'monthly_work_hour'=>'required|gt:0',
                'PaymentType'=>'required',
                'PaymentPeriod'=>'required',
                'Bank'=>'required_if:PaymentType,Bank-Transfer',
                'BankAccountNumber' => ['required_if:PaymentType,Bank-Transfer','nullable',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'ProvidentFundAccount' => ['required_if:PaymentType,Bank-Transfer','nullable',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'PensionNumber' => ['nullable',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                'Tin' => ['nullable','string', 'regex:/^.{8}$|^.{10}$/',Rule::unique('employees')->where(function ($query){
                    })->ignore($findid)
                ],
                //------HR end----
            ];

            $hr_doc_validation = [
                'docrow' => 'required|array|min:1',
                'docrow.*.document_type' => 'required',
                'docrow.*.upload_date' => 'required',
                'docrow.*.doc_upload_hidden' => 'required',
            ];

            $hr_cont_validation = [
                'controw' => 'required_if:EmploymentType,2|array|min:1',
                'controw.*.sign_date' => 'required',
                'controw.*.expire_date' => 'required',
                'controw.*.contract_hidden' => 'required',
            ];
        }

        if($wellness_module_flag == true){
            $wellness_validation = [
                'wellrow' => 'nullable|array|min:1',
                'wellrow.*.well_skill' => 'required',
                'wellrow.*.well_level' => 'required',
            ];
        }

        if($medical_module_flag == true){
            $medical_validation = [
                'medrow' => 'nullable|array|min:1',
                'medrow.*.med_skill' => 'required',
                'medrow.*.med_level' => 'required',
            ];
        }

        $rules = array_merge($basic_validation, 
                                $hr_validation, 
                                $hr_doc_validation, 
                                $hr_cont_validation, 
                                $wellness_validation,
                                $medical_validation);

        $validator = Validator::make($request->all(), $rules);
        
        if($findid == $supervisorid){
            $parentManagerErrFlag = 1;
        }

        if ($validator->passes() && $parentManagerErrFlag == 0) {

            DB::beginTransaction();

            try{
                if($request->file('imageUpload')) {
                    $file = $request->file('imageUpload');
                    $actualPhoto = "".time() . 'bimg.' . $request->file('imageUpload')->extension();
                    $pathIdentification = public_path() . '/storage/uploads/HrEmployee';
                    $pathnameIdentification='/storage/uploads/HrEmployee/'.$actualPhoto;
                    $file->move($pathIdentification, $actualPhoto);
                }
                if($request->file('imageUpload') == ''){
                    $actualPhoto = $request->actualPhoto;
                }

                if($faceids != null){
                    $img = $faceids;
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    
                    $image_base64 = base64_decode($image_parts[1]);
                    
                    $bioPhotos = uniqid() . '.jpg';
                    $pathIdentificationpic = public_path() .'/storage/uploads/BioEmployee/'.$bioPhotos;
                    $pathnameIdentificationpic = '/storage/uploads/BioEmployee/'.$bioPhotos;
                    Image::make($image_base64)->resize(140, 140)->save($pathIdentificationpic);
                }
                if($request->file('bioImageUpload') == '' && $faceids == null){
                    $bioPhotos = $request->bioPhoto;
                }

                if ($request->file('guarantorFile')) {
                    $file = $request->file('guarantorFile');
                    $guarantordoc = time() . 'sdoc.' . $request->file('guarantorFile')->extension();
                    $pathIdentification = public_path() . '/storage/uploads/EmployeeDocumets/GuarantorDocument';
                    $pathnameIdentification = '/storage/uploads/EmployeeDocumets/GuarantorDocument/'.$guarantordoc;
                    $file->move($pathIdentification, $guarantordoc);
                }
                if($request->file('guarantorFile') == ''){
                    $guarantordoc = $request->GuarantorFileName;
                }

                $DbData = employee::where('id', $findid)->first();
                if($findid != null){
                    $employeeid = $DbData->EmployeeID;
                }

                $BasicVal = [
                    'title' => $request->title,
                    'name' => $request->name,
                    'EmployeeID' => $employeeid,
                    'FirstName' => $request->FirstName,
                    'MiddleName' => $request->MiddleName,
                    'LastName' => $request->LastName,
                    'Gender' => $request->gender,
                    'Dob' => $request->Dob,
                    'branches_id' => $request->Branch,
                    'departments_id' => $request->Department,
                    'positions_id' => $request->Position,
                    'Status' => $request->status,
                    'ActualPicture' => $actualPhoto,

                    'MobileNumber' => $request->MobileNumber,
                    'OfficePhoneNumber' => $request->OfficePhoneNumber,
                    'Email' => $request->Email,
                    'Country' => $request->country,
                    'cities_id' => $request->city,
                    'subcities_id' => $request->subcity,
                    'Woreda' => $request->Woreda,
                    'kebele' => $request->Kebele,
                    'house_no' => $request->HouseNumber,
                    'Address' => $request->Address,

                    'Nationality' => $request->nationality,
                    'PassportNumber' => $request->PassportNumber,
                    'ResidanceIdNumber' => $request->ResidanceIdNumber,
                    'NationalIdNumber' => $request->NationalIdNumber,
                    'DrivingLicenseNumber' => $request->DrivingLicenseNumber,
                    'Postcode' => $request->Postcode,
                    'MartialStatus' => $request->MartialStatus,
                    'blood_type' => $request->BloodType,
                    'GeneralMemo' => $request->Description,
                    'EmergencyName' => $request->EmergencyName,
                    'EmergencyPhone' => $request->EmergencyPhone,
                    'EmergencyAddress' => $request->EmergencyAddress,

                    'employees_id' => $request->SupervisorOrImmedaiteManager,
                    'employementtypes_id' => $request->EmploymentType,
                    'HiredDate' => $request->HiredDate,
                    
                    'EnableAttendance' => $request->EnableAttendance,
                    'EnableHoliday' => $request->EnableHoliday,
                    
                    'GuarantorName' => $request->GuarantorName,
                    'GuarantorPhone' => $request->GuarantorPhone,
                    'GuarantorAddress' => $request->GuarantorAddress,
                    'GuarantorDocument' => $guarantordoc,
                    
                    'PIN' => $request->PIN,
                    'CardNumber' => $request->CardNumber,
                    'devices_id' => $request->EnrollDevice,
                    'BiometricPicture' => $bioPhotos,
                    'LeftThumb' => $request->LeftThumbVal,
                    'LeftIndex' => $request->LeftIndexVal,
                    'LeftMiddle' => $request->LeftMiddelVal,
                    'LeftRing' => $request->LeftRingVal,
                    'LeftPinky' => $request->LeftPickyVal,
                    'RightThumb' => $request->RightThumbVal,
                    'RightIndex' => $request->RightIndexVal,
                    'RightMiddle' => $request->RightMiddleVal,
                    'RightRing' => $request->RightRingVal,
                    'RightPinky' => $request->RightPickyVal, 

                    'AccessStatus' => $request->AccessStatus,
                    'AccessRole' => $request->AccessRole,

                    'monthly_work_hour'=>$request->monthly_work_hour,
                    'PaymentType'=>$request->PaymentType,
                    'PaymentPeriond'=> $request->PaymentPeriod,
                    'banks_id'=> $request->Bank == null ? 1 : $request->Bank,
                    'BankAccountNumber'=>$request->BankAccountNumber,
                    'ProvidentFundAccount'=>$request->ProvidentFundAccount,
                    'PensionNumber'=>$request->PensionNumber,
                    'Tin' => $request->Tin,
                    'PensionPercent' => 7,
                    'CompanyPensionPercent' => 11,
                    'PersonUUID' => $uuid,
                ];
                
                $CreatedBy = ['CreatedBy' => $user,'salaries_id'=>1,'banks_id'=>1];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $employees = employee::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                User::where('empid',$findid)->update(['Status' => "Inactive"]); // Reset user status

                if ($request->AccessStatus == "Enable"){

                    $emp = employee::where('EmployeeID','=',$employeeid)->firstOrFail();
                    $empid = $emp->id;
                    $firstn = ucwords($request->FirstName);
                    $middlen = ucwords($request->MiddleName).ucwords($request->LastName);
                    $middlename = $middlen[0];
                    $username = $firstn.$middlename;
                    $countname = DB::table('users')->where('users.username','=',$username)->get();
                    $getcountnme = $countname->count();
                    
                    if($getcountnme > 0){
                        $midnamecnt = strlen($middlen);
                        for($i = 1;$i <= $midnamecnt;$i++){
                            $k = $i+1;
                            $middlename = substr($middlen,0,$k);
                            $username = $firstn.$middlename;
                            $countname = DB::table('users')->where('users.username','=',$username)->get();
                            $getcountnme = $countname->count();
                            if($getcountnme == 0){
                                $i = $midnamecnt+1;
                            }
                        }
                    }

                    $user_db_data = User::where('empid', $findid)->first();

                    $basic_user_data = [
                        'FullName' => $request->name,
                        'email' => $request->Email,
                        'phone' => $request->MobileNumber,
                        'AlternatePhone' => $request->OfficePhoneNumber,
                        'Address' => $request->Address,
                        'Nationality' =>$request->nationality,
                        'Gender' => $request->gender,
                        'Status' => $userstatus = $request->AccessStatus == "Enable" && $request->status == "Active" ? "Active" : "Inactive",
                        'usertype' => "",
                        'IsPurchaser' => $request->boolean('select-all-pur') ? 1 : 0,
                        'accstatus' => 1,
                        'empid' => $empid,
                    ];

                    $create_user_data = [
                        'username' => $username,
                        'password' => Hash::make("123456"),
                        'ChangePass' => 0,
                    ];

                    $update_user_data = [
                        'updated_at' => Carbon::now()
                    ];

                    $user = User::updateOrCreate(['empid' => $findid],
                        array_merge($basic_user_data, $user_db_data ? $update_user_data : $create_user_data),
                    );

                    $user->syncRoles($request->input('roleid',[]));

                    $assigned_user_id = $user->id;

                    foreach ($assign_pages as $index => $p_name) {
                        foreach($request->input($p_name,[]) as $str_id){
                            $store_assignment_data[] = [
                                "UserId" => $assigned_user_id,
                                "StoreId" => $str_id,
                                "Type" => $index,
                                "created_at" => Carbon::now(),
                                "updated_at" => Carbon::now()
                            ];
                        }
                    }
                    
                    storeassignment::where('storeassignments.UserId',$assigned_user_id)->delete();
                    storeassignment::insert($store_assignment_data);
                }

                if($request->docrow != null){
                    foreach ($request->docrow as $key => $value){
                        $doc = $value['doc_upload'] ?? "";
                        if($doc != null) {
                            $doc_file = $value['doc_upload'];
                            $actual_name = $doc_file->getClientOriginalName();
                            $documentations = $this->randNumber().$employees->id.'_'.'doc.' . $value['doc_upload']->extension();
                            $docPathIdentification = public_path() . '/storage/uploads/EmployeeDocumets/ResumeAndOther';
                            $docpathnameIdentification = '/storage/uploads/EmployeeDocumets/ResumeAndOther/'.$documentations;
                            $doc_file->move($docPathIdentification, $documentations);
                        }
                        if($doc == null) {
                            $documentations = $value['documents'];
                            $actual_name = $value['doc_actual_name'];
                        }
                        $document_upload_data[] = [
                            "employees_id" => $employees->id,
                            "type" => $value['document_type'],
                            "doc_date" => $value['upload_date'],
                            "sign_date" => "",
                            "expire_date" => "",
                            "duration" => 0,
                            "doc_name" => $documentations,
                            "actual_file_name" => $actual_name,
                            "remark" => $value['doc_remark'],
                            "upload_type" => 1,
                            "description" => "Documentation",
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ];
                    }
                }

                if($request->controw != null){
                    foreach ($request->controw as $key => $contval){
                        $con = $contval['cont_document'] ?? "";
                        if($con != null) {
                            $con_file = $contval['cont_document'];
                            $cont_actual_name = $con_file->getClientOriginalName();
                            $cont_documentation = $this->randNumber().'_'.$employees->id. 'cont.' . $contval['cont_document']->extension();
                            $cont_pathIdentification = public_path() . '/storage/uploads/EmployeeDocumets/Contracts';
                            $cont_pathnameIdentification = '/storage/uploads/EmployeeDocumets/Contracts/'.$cont_documentation;
                            $con_file->move($cont_pathIdentification, $cont_documentation);
                        }
                        if($con == null) {
                            $cont_documentation = $contval['contracts'];
                            $cont_actual_name = $contval['con_actual_name'];
                        }
                        $document_upload_data[] = [
                            "employees_id" => $employees->id,
                            "type" => 0,
                            "doc_date" => "",
                            "sign_date" => $contval['sign_date'],
                            "expire_date" => $contval['expire_date'],
                            "duration" => $contval['cont_duration'],
                            "doc_name" => $cont_documentation,
                            "actual_file_name" => $cont_actual_name,
                            "remark" => $contval['cont_remark'],
                            "upload_type" => 2,
                            "description" => "Contracts",
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ];
                    }
                }

                if($request->wellrow != null){
                    foreach ($request->wellrow as $key => $wellval){
                        $skill_set_data[] = [
                            "employees_id" => $employees->id,
                            "skills_id" => $wellval['well_skill'],
                            "level_id" => $wellval['well_level'],
                            "remark" => $wellval['well_remark'],
                            "type" => 1,
                            "description" => "Wellness-Skill",
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ];
                    }
                }

                if($request->medrow != null){
                    foreach ($request->medrow as $key => $medval){
                        $skill_set_data[] = [
                            "employees_id" => $employees->id,
                            "skills_id" => $medval['med_skill'],
                            "level_id" => $medval['med_level'],
                            "remark" => $medval['med_remark'],
                            "type" => 2,
                            "description" => "Medical-Skill",
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ];
                    }
                }


                employee_document::where('employee_documents.employees_id',$employees->id)->delete();
                employee_document::insert($document_upload_data);

                employee_skill_set::where('employee_skill_sets.employees_id',$employees->id)->delete();
                employee_skill_set::insert($skill_set_data);

                if($request->LeftThumbVal == null || $request->LeftThumbVal == ""){
                    $leftthumb = "";
                }
                if($request->LeftThumbVal != null && $request->LeftThumbVal != ""){
                    $leftthumb = $request->LeftThumbVal;
                }

                if($request->LeftIndexVal == null || $request->LeftIndexVal == ""){
                    $leftindex = "";
                }
                if($request->LeftIndexVal != null && $request->LeftIndexVal != ""){
                    $leftindex = $request->LeftIndexVal;
                }

                if($request->LeftMiddelVal == null || $request->LeftMiddelVal == ""){
                    $leftmiddle = "";
                }
                if($request->LeftMiddelVal != null && $request->LeftMiddelVal != ""){
                    $leftmiddle = $request->LeftMiddelVal;
                }

                if($request->LeftRingVal == null || $request->LeftRingVal == ""){
                    $leftring = "";
                }
                if($request->LeftRingVal != null && $request->LeftRingVal != ""){
                    $leftring = $request->LeftRingVal;
                }

                if($request->LeftPickyVal == null || $request->LeftPickyVal == ""){
                    $leftpicky = "";
                }
                if($request->LeftPickyVal != null && $request->LeftPickyVal != ""){
                    $leftpicky = $request->LeftPickyVal;
                }

                if($request->RightThumbVal == null || $request->RightThumbVal == ""){
                    $rightthumb = "";
                }
                if($request->RightThumbVal != null && $request->RightThumbVal != ""){
                    $rightthumb = $request->RightThumbVal;
                }

                if($request->RightIndexVal == null || $request->RightIndexVal == ""){
                    $rightindex = "";
                }
                if($request->RightIndexVal != null && $request->RightIndexVal != ""){
                    $rightindex = $request->RightIndexVal;
                }

                if($request->RightMiddleVal == null || $request->RightMiddleVal == ""){
                    $rightmiddle = "";
                }
                if($request->RightMiddleVal != null && $request->RightMiddleVal != ""){
                    $rightmiddle = $request->RightMiddleVal;
                }

                if($request->RightRingVal == null || $request->RightRingVal == ""){
                    $rightring = "";
                }
                if($request->RightRingVal != null && $request->RightRingVal != ""){
                    $rightring = $request->RightRingVal;
                }

                if($request->RightPickyVal == null || $request->RightPickyVal == ""){
                    $rightpicky = "";
                }
                if($request->RightPickyVal != null && $request->RightPickyVal != ""){
                    $rightpicky = $request->RightPickyVal;
                }

                if($enrolldev > 1){
                    $mquuid = Str::uuid()->toString();
                    $mqt = new mqttmessage;
                    $mqtt = MQTT::connection();

                    if($request->file('bioPhoto') == ''){
                        if($bioPhotos != null){
                            $pathIdentificationpic = public_path().'/storage/uploads/BioEmployee/'.$bioPhotos;
                            $imagepath = public_path().'/storage/uploads/BioEmployee/'.$bioPhotos;
                            $picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                        }
                        if($bioPhotos == null){
                            $picdata = $defpic;
                        }
                    }
                    if($request->file('bioPhoto') != ''){
                        $pathIdentificationpic = public_path().'/storage/uploads/BioEmployee/'.$bioPhotos;
                        $imagepath = public_path().'/storage/uploads/BioEmployee/'.$bioPhotos;
                        $picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
                    }

                    $fullip = null;
                    $memid = null;
                    $gender = null;
                    $persontype = null;

                    $memid = $employees->id;
                    
                    $dev = device::findorFail($enrolldev);
                    $devid = $dev->DeviceId;
                    $devip = $dev->IpAddress;
                    $devport = $dev->Port;
                    $devuname = $dev->Username;
                    $devpass = $dev->Password;

                    if($request->gender == "Male"){
                        $gender = 0;
                    }
                    if($request->gender == "Female"){
                        $gender = 1;
                    }

                    if($request->Status == "Active"){
                        $persontype = 1;
                    }
                    if($request->Status != "Active"){
                        $persontype = 0;
                    }
                    $curdate = Carbon::today()->toDateString();

                    $topic = "mqtt/face/".$dev->DeviceId;
                    $topicrec = "mqtt/face/".$dev->DeviceId."/Ack";

                    $msgs='{
                        "operator": "EditPerson",
                        "messageId":"MessageID-EditPerson-'.$uuid.'",
                        "info":
                        {
                            "facesluiceId":"'.$dev->DeviceId.'",
                            "customId":"'.$memid.'",
                            "personType":"'.$persontype.'",
                            "name":"'.$request->name.'",
                            "gender":"'.$gender.'",
                            "birthday":"'.$request->Dob.'",
                            "telnum1":"'.$request->MobileNumber." , ".$request->OfficePhoneNumber.'",
                            "address":"'.$request->Location.'",
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

                if($findid == null){
                    $updn = DB::select('UPDATE settings SET HrEmployeeNumber=HrEmployeeNumber+1 WHERE id=1');
                }

                $actions = $findid == null ? "Created" : "Edited";
                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$employees->id,'pagename'=>"employee",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

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
            return Response::json(['errors' => $validator->errors()]);
        }

        if($parentManagerErrFlag == 1){
            return Response::json(['errflag' => 462]);
        }
    }

    public function randNumber(): int{
        return random_int(100000, 999999);
    }

    public function getRoleData(){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $roles = Role::where('id','>',$uid = $userid == 1 ? 0 : 1)->where('status',"Active")->orderBy('name','ASC')->get();
        $shopdata = DB::select('SELECT * FROM stores WHERE stores.type="Shop" AND stores.ActiveStatus="Active" ORDER BY stores.Name ASC');
        $storedata = DB::select('SELECT * FROM stores WHERE stores.type="Store" AND stores.ActiveStatus="Active" ORDER BY stores.Name ASC');
        return response()->json(['roles' => $roles,'shopdata' => $shopdata,'storedata' => $storedata]);
    }

    public function getHrSetting(){
        $settings = DB::table('settings')->value('hr_setting'); 
        return response()->json(['settings' => json_decode($settings, true)]);
    }

    public function showemployeecon($id){
        $bankcount=0;
        $cnt=0;
        $bankname = null;
        $userid = null;
        $roleid = null;
        $rolename = null;
        $picidName = null;
        $picdata = null;
        $uname = "";
        $recdata = employee::findorFail($id);
        $salaryid = $recdata->salaries_id;
        $negflag = $recdata->UpdateSalaryFlag;
        $picidName = $recdata->BiometricPicture;
        $createddate = Carbon::createFromFormat('Y-m-d H:i:s', $recdata->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $updateddate = Carbon::createFromFormat('Y-m-d H:i:s', $recdata->updated_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $data = employee::leftJoin('branches','employees.branches_id','=','branches.id')
        ->leftJoin('departments','employees.departments_id','=','departments.id')
        ->leftJoin('positions','employees.positions_id','=','positions.id')
        ->leftJoin('salaries','employees.salaries_id','=','salaries.id')
        ->leftJoin('employementtypes','employees.employementtypes_id','=','employementtypes.id')
        ->leftJoin('cities', 'employees.cities_id', '=', 'cities.id')
        ->leftJoin('subcities', 'employees.subcities_id', '=', 'subcities.id')
        ->leftJoin('devices', 'employees.devices_id', '=', 'devices.id')
        ->leftJoin('banks', 'employees.banks_id', '=', 'banks.id')
        ->leftJoin('employees AS emp','employees.employees_id','=','emp.id')
        ->leftJoin('lookuprefs AS titleref','employees.title','=','titleref.id')
        ->leftJoin('lookuprefs AS bloodtype','employees.blood_type','=','bloodtype.id')
        ->where('employees.id', $id)
        ->get(['employees.*','branches.BranchName','departments.DepartmentName','emp.name AS Supervisor',
        'employementtypes.EmploymentTypeName','positions.PositionName','salaries.SalaryName',
        'salaries.TaxableEarning','salaries.NonTaxableEarning','salaries.TotalEarnings','salaries.TotalDeductions','salaries.CompanyPension',
        'salaries.NetSalary','cities.city_name','subcities.subcity_name','devices.DeviceName','banks.BankName',
        'titleref.LookupName AS emp_title','bloodtype.LookupName AS bloodtype',
        DB::raw('CASE WHEN employees.UpdateSalaryFlag=0 THEN "No" WHEN employees.UpdateSalaryFlag=1 THEN "Yes" END AS SalaryTypeFlag'),
        DB::raw("'$createddate' AS CreatedDateTime"),DB::raw("'$updateddate' AS UpdatedDateTime")]);

        if($data[0]->AccessStatus == "Enable"){
            $usr = User::where('empid', $id)->first();
            $uname = $usr->username;
        }

        $leavedata = hr_employee_leave::join('hr_leavetypes','hr_employee_leaves.hr_leavetypes_id','=','hr_leavetypes.id')
        ->where('hr_employee_leaves.employees_id', $id)
        ->get(['hr_employee_leaves.*','hr_leavetypes.LeaveType','hr_leavetypes.Description','hr_leavetypes.Status',DB::raw('IFNULL(hr_employee_leaves.Remark,"") AS Remark'),DB::raw('IFNULL(hr_employee_leaves.LeaveBalance,"") AS LeaveBalance')]);

        $salarydetdata = salarydetail::join('salarytypes','salarydetails.salarytypes_id','salarytypes.id')
        ->where('salarydetails.salaries_id',$salaryid)
        ->orderBy('salarytypes.SalaryType','DESC')
        ->orderBy('salarytypes.id','ASC')
        ->get(['salarydetails.*','salarytypes.SalaryTypeName','salarytypes.SalaryType',
            DB::raw('IFNULL(salarytypes.Description,"") AS Descriptions'),
            DB::raw('IFNULL(salarydetails.Remark,"") AS Remark')
        ]);

        $salarynegdata = hr_employee_salary::join('salarytypes','hr_employee_salaries.salarytypes_id','=','salarytypes.id')
        ->where('hr_employee_salaries.employees_id', $id)->orderBy('salarytypes.SalaryType','DESC')->orderBy('salarytypes.id','ASC')
        ->get(['hr_employee_salaries.*','salarytypes.SalaryTypeName','salarytypes.SalaryType',
        DB::raw('IFNULL(salarytypes.Description,"") AS Descriptions'),DB::raw('IFNULL(hr_employee_salaries.Remark,"") AS Remarks')]);

        $documentation = DB::select('SELECT lookuprefs.LookupName AS doc_type,employee_documents.* FROM employee_documents LEFT JOIN lookuprefs ON employee_documents.type=lookuprefs.id WHERE employee_documents.employees_id='.$id.' ORDER BY employee_documents.upload_type ASC');
        $count_contract = DB::select('SELECT COUNT(*) AS total FROM employee_documents WHERE employee_documents.employees_id='.$id.' AND employee_documents.upload_type=2')[0]->total;

        $skill_set = DB::select('SELECT skills.name AS skill_name,lookuprefs.LookupName AS level,employee_skill_sets.* FROM employee_skill_sets LEFT JOIN skills ON employee_skill_sets.skills_id=skills.id LEFT JOIN lookuprefs ON employee_skill_sets.level_id=lookuprefs.id WHERE employee_skill_sets.employees_id='.$id.' ORDER BY employee_skill_sets.type ASC');

        $activitydata = actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"employee")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        if($picidName != null){
            $imagepath = public_path().'/storage/uploads/BioEmployee/'.$picidName;
            $picdata = "data:image/jpeg;base64,".base64_encode((file_get_contents($imagepath)));
        }

        $start = Carbon::parse($data[0]->HiredDate ?? "");
        $hiredDateYear = Carbon::parse($data[0]->HiredDate ?? "")->format('Y');
        $now = Carbon::now();
        $currentyear = Carbon::parse($now)->format('Y');
        $options = [];

        $ordinal = [
            'First', 'Second', 'Third', 'Fourth', 'Fifth',
            'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth',
            'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth',
            'Sixteenth', 'Seventeenth', 'Eighteenth', 'Nineteenth', 'Twentieth',
            'Twenty-First', 'Twenty-Second', 'Twenty-Third', 'Twenty-Fourth', 'Twenty-Fifth',
            'Twenty-Sixth', 'Twenty-Seventh', 'Twenty-Eighth', 'Twenty-Ninth', 'Thirtieth',
            'Thirty-First', 'Thirty-Second', 'Thirty-Third', 'Thirty-Fourth', 'Thirty-Fifth',
            'Thirty-Sixth', 'Thirty-Seventh', 'Thirty-Eighth', 'Thirty-Ninth', 'Fortieth'
        ];
        $i = 0;

        while ($start->copy()->addYear() <= $now->copy()->addYear()) {
            if($hiredDateYear < $currentyear){
                $yearFrom = $start->year;
                $yearTo = $start->copy()->addYear()->year;
            }
            else if($currentyear == $hiredDateYear){
                $yearFrom = $start->year - 1;
                $yearTo = $yearFrom + 1;
            }

            $ethiopianYear = $yearFrom - 7;

            $value = "{$yearFrom}-{$yearTo}({$ethiopianYear})";
            $label = "{$yearFrom}-{$yearTo}({$ethiopianYear})";

            // $value = substr($yearFrom, -2) . '-' . substr($yearTo, -2);
            // $label = "{$yearFrom}-{$yearTo} (" . ($ordinal[$i] ?? ($i + 1).'th') . " Year)";

            if($yearTo <= $currentyear){
                $options[] = [
                    'value' => $value,
                    'label' => $label,
                ];
            }
            $start->addYear();
            $i++;
        }

        $can_edit_common = auth()->user()->can('Employee-Edit-CommonAndAdress-Tab') ? 1 : 0;
        $can_edit_general = auth()->user()->can('Employee-Edit-General-Tab') ? 1 : 0;
        $can_edit_hr = auth()->user()->can('Employee-Edit-HR-Tab') ? 1 : 0;
        $can_edit_well_skill = auth()->user()->can('Employee-Edit-WellnessSkill-Tab') ? 1 : 0;
        $can_edit_med_skill = auth()->user()->can('Employee-Edit-MedicalSkill-Tab') ? 1 : 0;
        
        return response()->json(['employeedata' => $data,
                                'leavedata' => $leavedata,
                                'salarydetdata' => $salarydetdata,
                                'salarynegdata' => $salarynegdata,
                                'salaryid' => $salaryid,
                                'usenegsalary' => $negflag,
                                'activitydata' => $activitydata,
                                'picdata' => $picdata,
                                'years' => $options,
                                'documentation' => $documentation,
                                'count_contract' => $count_contract,
                                'skill_set' => $skill_set,
                                'uname' => $uname,
                                'can_edit_common' => $can_edit_common,
                                'can_edit_general' => $can_edit_general,
                                'can_edit_hr' => $can_edit_hr,
                                'can_edit_well_skill' => $can_edit_well_skill,
                                'can_edit_med_skill' => $can_edit_med_skill,
                            ]);       
    }

    public function getEmployeeDocuments()
    {
        $e_id = $_POST['e_id']; 
        $type = $_POST['type']; 
        $doclist = DB::select('SELECT lookuprefs.LookupName AS doc_type,employee_documents.* FROM employee_documents LEFT JOIN lookuprefs ON employee_documents.type=lookuprefs.id WHERE employee_documents.employees_id='.$e_id.' AND employee_documents.upload_type='.$type.' ORDER BY employee_documents.id ASC');
        return datatables()->of($doclist)
        ->addIndexColumn() 
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getLeaveHistory()
    {
        $e_id = $_POST['e_id']; 
        $leavehislist = DB::select('SELECT hr_leave_transactions.*,hr_leavetypes.LeaveType,(SUM(COALESCE(hr_leave_transactions.LeaveEarned,0)-COALESCE(hr_leave_transactions.LeaveUsage,0))OVER(PARTITION BY hr_leave_transactions.Year,hr_leave_transactions.employees_id ORDER BY hr_leave_transactions.id ASC)) AS running_remaining,(COALESCE(hr_leave_transactions.LeaveEarned,0)-COALESCE(hr_leave_transactions.LeaveUsage,0)) AS total_balance FROM hr_leave_transactions LEFT JOIN hr_leavetypes ON hr_leave_transactions.hr_leavetypes_id=hr_leavetypes.id WHERE hr_leave_transactions.employees_id='.$e_id.' ORDER BY hr_leave_transactions.id ASC,hr_leave_transactions.Year ASC');
        return datatables()->of($leavehislist)
        ->addIndexColumn() 
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getEmployeeSkillSet()
    {
        $e_id = $_POST['e_id']; 
        $type = $_POST['type']; 
        $skillset = DB::select('SELECT skills.name AS skill_name,lookuprefs.LookupName AS level,employee_skill_sets.* FROM employee_skill_sets LEFT JOIN skills ON employee_skill_sets.skills_id=skills.id LEFT JOIN lookuprefs ON employee_skill_sets.level_id=lookuprefs.id WHERE employee_skill_sets.employees_id='.$e_id.' AND employee_skill_sets.type='.$type.' ORDER BY skills.name ASC');
        return datatables()->of($skillset)
        ->addIndexColumn() 
        ->rawColumns(['action'])
        ->make(true);
    }

    public function openEmployeeDoc($ids,$doc_name,$type) 
    {
        $file_path = $type == 1 ? public_path('storage/uploads/EmployeeDocumets/ResumeAndOther/'.$doc_name) : public_path('storage/uploads/EmployeeDocumets/Contracts/'.$doc_name);
        return response()->download($file_path);
    }
    
    public function getSelectedRoleAndAssign($e_id){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;

        $user_prop = DB::table('users')->where('users.empid','=',$e_id)->get();
        $user_id = $user_prop[0]->id ?? 0;
        $is_purchaser = $user_prop[0]->IsPurchaser ?? 0;

        $selected_role = DB::table('model_has_roles')->leftJoin('roles','model_has_roles.role_id','roles.id')->where('model_id',$user_id)->get(['model_has_roles.*','roles.name AS role_name']); 
        $assign_data = DB::select('SELECT stores.Name AS store_name,storeassignments.* FROM storeassignments LEFT JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$user_id);

        return response()->json(['selected_role' => $selected_role,'assign_data' => $assign_data,'is_purchaser' => $is_purchaser]);
    }

    public function getEmployeeFingerprint(Request $request)
    {
        $settings = DB::table('settings')->latest()->first();
        $memid=$request->recId;
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

    public function getEmployeeFaceid(Request $request)
    {
        $settings = DB::table('settings')->latest()->first();
        $defpic=$settings->defaultpic;
        $memid=$request->recId;
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
                    if ($elapsedTime >= 10) {
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

    public function deleteEmployee(Request $request){
        try{
            employee::where('id',$request->info_employee_id)->delete();
            return Response::json(['success' => 1]);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function leavetypecon(){
        $leavetypelist=DB::select('SELECT * FROM hr_leavetypes WHERE hr_leavetypes.Status="Active" ORDER BY hr_leavetypes.LeaveType ASC');
        return response()->json(['leavetypedata'=>$leavetypelist]);
    }

    public function showemployeelist(){
       $data = employee::join('positions','employees.positions_id','=','positions.id')->where('employees.Status',"Active")->where('employees.id','>',1)->get(['employees.*','positions.PositionName',DB::raw('IFNULL(employees.OfficePhoneNumber,"") AS OfficePhone')]);
       return response()->json(['list'=>$data]);  
    }

    public function getlatestEmp()
    {
        $fname=$_POST['fname']; 
        $getlatestempname=DB::select('SELECT employees.id,employees.name FROM employees WHERE employees.name="'.$fname.'" ORDER BY employees.id DESC LIMIT 1');
        return response()->json(['getlastemp'=>$getlatestempname]);
    }

    public function getSalaries(Request $request){
        $salaryid= $request->Salary;
        $data = DB::table('salaries')
        ->select('salaries.*')
        ->where('salaries.id',$salaryid)
        ->get();

        $salarydetdata = salarydetail::join('salarytypes','salarydetails.salarytypes_id','salarytypes.id')->where('salarydetails.salaries_id',$salaryid)->orderBy('salarytypes.SalaryType','DESC')->orderBy('salarytypes.id','ASC')->get(['salarydetails.*','salarytypes.SalaryTypeName','salarytypes.SalaryType',
        DB::raw('IFNULL(salarytypes.Description,"") AS Descriptions'),DB::raw('IFNULL(salarydetails.Remark,"") AS Remarks')]);

        return response()->json(['salarylist'=>$data,'salarylistdetail'=>$salarydetdata]);
    }

    public function getDayDiff(Request $request){
        $fdate = $request->SignDate;
        $tdate = $request->RenewDate;
        $datetimeone = Carbon::parse($fdate);
        $datetimetwo = Carbon::parse($tdate);
        $interval = $datetimeone->diffInDays($datetimetwo);
        return response()->json(['days'=>$interval]);
    }

    public function showFixedSalary($id)
    {
        $detailTable=DB::select('select salarydetails.*, salarytypes.SalaryTypeName, salarytypes.SalaryType, IFNULL(salarytypes.Description,"") AS Descriptions, IFNULL(salarydetails.Remark,"") AS Remarks from salarydetails inner join salarytypes on salarydetails.salarytypes_id = salarytypes.id where salarydetails.salaries_id = '.$id.' order by salarytypes.SalaryType desc, salarytypes.id asc');
        return datatables()->of($detailTable)
        ->addIndexColumn() 
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showNegSalary($id)
    {
        $detailTable=DB::select('select hr_employee_salaries.*, salarytypes.SalaryTypeName, salarytypes.SalaryType, IFNULL(salarytypes.Description,"") AS Descriptions, IFNULL(hr_employee_salaries.Remark,"") AS Remarks from hr_employee_salaries inner join salarytypes on hr_employee_salaries.salarytypes_id = salarytypes.id where hr_employee_salaries.employees_id = '.$id.' order by salarytypes.SalaryType desc, salarytypes.id asc');
        return datatables()->of($detailTable)
        ->addIndexColumn() 
        ->rawColumns(['action'])
        ->make(true);
    }

    //--------------------Start Leave Allocation------------------------------------

    public function showEmployeeLeaveAlloc(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        $empid = $_POST['empid']; 

        $query = DB::select("SELECT emp_leaveallocs.*,CASE WHEN Status = 'Void' THEN CONCAT(Status, '(', OldStatus, ')') ELSE Status END AS DisplayStatus,(SELECT COUNT(hr_leave_transactions.id) FROM hr_leave_transactions WHERE hr_leave_transactions.RecordType NOT IN('Allocation','Void','Undo-Void') AND hr_leave_transactions.BaseHeaderId=emp_leaveallocs.id) AS RecordCount FROM emp_leaveallocs WHERE emp_leaveallocs.employees_id='$empid' ORDER BY emp_leaveallocs.id DESC");
        if(request()->ajax()) {
            return datatables()->of($query)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function saveLeaveAllocation(Request $request){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $findid = $request->allocRecId ?? 0;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $errors = [];
        $rowids = [];

        $rules=array(
            'leaverow.*.LeaveType' => 'required',
            'leaverow.*.Year' => 'required',
            'leaverow.*.LeaveBalance' => 'required',
        );

        $v2= Validator::make($request->all(), $rules);

        if($request->leaverow != null){
            foreach ($request->leaverow as $key => $leave){
                $leavetype = $leave['LeaveType'] ?? 0;
                $leaveyear = $leave['Year'] ?? 0;
                if($leavetype != 0 && $leaveyear != 0){
                    if (in_array($leave['LeaveType'], [1])) {
                        $exists = hr_employee_leave::join('hr_leavetypes','hr_employee_leaves.hr_leavetypes_id','hr_leavetypes.id')
                            ->join('emp_leaveallocs','hr_employee_leaves.emp_leaveallocs_id','emp_leaveallocs.id')
                            ->where('hr_employee_leaves.employees_id',$request->allocEmployeeId)
                            ->where('hr_employee_leaves.hr_leavetypes_id', $leave['LeaveType'])
                            ->where('hr_employee_leaves.Year', $leave['Year'])
                            ->whereNotIn('emp_leaveallocs.Status',["Void"])
                            ->where('hr_employee_leaves.emp_leaveallocs_id','!=',$findid)
                            ->exists();
                        
                        if ($exists) {
                            $errors[] = "Leave Type: <b>Anual Leave</b>, Year: <b>{$leave['Year']}</b></br>";
                        }
                    }
                }
            }

            $empallocation = emp_leavealloc::where('id',$findid)->latest()->first();

            $empstatus = $empallocation->Status ?? "";

            if($empstatus == "Approved"){

                foreach ($request->leaverow as $leaveTypeId => $updates) {
                    $currentEarned = 0;
                    $currentUsed = 0;

                    $totalearned = DB::table('hr_leave_transactions')
                        ->selectRaw("
                            SUM(CASE WHEN RecordType IN ('Allocation','Undo-Void') THEN LeaveEarned ELSE 0 END) AS total_earned
                        ")
                        ->where('employees_id', $request->allocEmployeeId)
                        ->where('hr_leavetypes_id', $updates['LeaveType'])
                        ->where('Year', $updates['Year'])
                        ->where('HeaderId','!=',$findid)
                        ->get();

                    $totalusage = DB::table('hr_leave_transactions')
                        ->selectRaw("
                            SUM(CASE WHEN RecordType IN ('Void','Requisition') THEN LeaveUsage ELSE 0 END) AS total_used
                        ")
                        ->where('employees_id', $request->allocEmployeeId)
                        ->where('hr_leavetypes_id', $updates['LeaveType'])
                        ->where('Year', $updates['Year'])
                        ->get();

                    $currentEarned = $totalearned[0]->total_earned ?? 0;
                    $currentUsed = $totalusage[0]->total_used ?? 0;

                    $currentEarned += $updates['LeaveBalance'] ?? 0;

                    if (($currentEarned - $currentUsed) < 0) {
                        $rowids[]=$updates['vals'];
                    }
                }
            }
        }

        if($v2->passes() && $request->leaverow != null && empty($errors) && empty($rowids)){
            DB::beginTransaction();

            try{
                $empnum=0;
                $leavedata = [];
                $empdata = employee::where('id',$request->allocEmployeeId)->first();
                
                if(preg_match('/\d+(\.\d+)?/', $empdata->EmployeeID, $matches)){
                    $empnum =  (int)$matches[0];
                }
                else{
                    $empnum = 0;
                }

                $empallocdata = emp_leavealloc::where('Type',"Manual")->where('employees_id',$request->allocEmployeeId)->latest()->first();
                $AlocDocumentNumber=$settings->LeaveAllocManualPrefix.str_pad($empnum,3,'0',STR_PAD_LEFT)."-".sprintf("%03d",($empallocdata->AllocationNo ?? 0)+1);
                $currentnum = ($empallocdata->AllocationNo ?? 0)+1;

                $BasicVal = [
                    'employees_id' => $request->allocEmployeeId,
                ];

                $DbData = emp_leavealloc::where('id', $findid)->first();
                $CreatedData = ['LeaveAllocationNo' => $AlocDocumentNumber,'Type' => "Manual",'Date' => Carbon::today()->toDateString(),'AllocationNo'=>$currentnum,'Status' => "Draft",'created_at' => Carbon::now()];
                $UpdatedData = ['updated_at' => Carbon::now()];

                $empalloc = emp_leavealloc::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $UpdatedData : $CreatedData),
                );

                foreach ($request->leaverow as $key => $value){
                    $leavedata[] = [
                        'emp_leaveallocs_id' => $empalloc->id,
                        'employees_id' => $request->allocEmployeeId,
                        'hr_leavetypes_id' => $value['LeaveType'],
                        'Year' => $value['Year'],
                        'LeaveBalance' => $value['LeaveBalance'],
                        'Remark' => $value['Remark'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }

                DB::table('hr_employee_leaves')
                ->where('hr_employee_leaves.emp_leaveallocs_id',$empalloc->id)
                ->delete();

                DB::table('hr_employee_leaves')->insert($leavedata);
                 
                if($empalloc->Status == "Approved"){
                    $idsToKeep=[];

                    foreach ($request->leaverow as $ky => $kyvalue) {
                        
                        $hrtrdata = hr_leave_transaction::where('HeaderId',$findid)
                        ->where('employees_id',$request->allocEmployeeId)
                        ->where('hr_leavetypes_id',$kyvalue['LeaveType'])
                        ->where('Year', $kyvalue['Year'])
                        ->where('RecordType',"Allocation")
                        ->latest()
                        ->first();

                        $hrtransaction = hr_leave_transaction::updateOrCreate(['id' => $hrtrdata->id],[
                            'hr_leavetypes_id' => $kyvalue['LeaveType'],
                            'Year' => $kyvalue['Year'],
                            'LeaveEarned' => $kyvalue['LeaveBalance'],
                            'Remark' => $kyvalue['Remark'],
                        ]);

                        $idsToKeep[] = $hrtransaction->id;
                    }

                    DB::table('hr_leave_transactions')
                    ->where('hr_leave_transactions.HeaderId',$findid)
                    ->where('hr_leave_transactions.RecordType',"Allocation")
                    ->whereNotIn('hr_leave_transactions.id',$idsToKeep)
                    ->delete();
                }

                $actions = $findid == null ? "Created" : "Edited";
                actions::insert(['user_id'=>$userid,'pageid'=>$empalloc->id,'pagename'=>"leavealloc",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

                DB::commit();
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($v2->fails()){
            return Response::json(['errorsv2'=> $v2->errors()]);
        }
        if($request->leaverow==null){
            return Response::json(['emptyerror'=> 462]);
        }
        if (!empty($errors)) {
            return Response::json(['duplicaterr'=> 463,'errors'=>$errors]);
        }
        if (!empty($rowids)) {
            return Response::json(['negerror'=> 464,'rowids'=>$rowids]);
        }
    }

    public function showleavealloc($id){
        $data = emp_leavealloc::where('id',$id)->get(['emp_leaveallocs.*',
            DB::raw('(SELECT COUNT(hr_leave_transactions.id) FROM hr_leave_transactions WHERE hr_leave_transactions.RecordType NOT IN("Allocation","Void","Undo-Void") AND hr_leave_transactions.BaseHeaderId='.$id.') AS RecordCount')    
        ]);

        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"leavealloc")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        $leavetypedata=DB::select('select hr_employee_leaves.*, hr_leavetypes.LeaveType,IFNULL(hr_employee_leaves.Remark,"") AS Remark, IFNULL(hr_employee_leaves.LeaveBalance,"") AS LeaveBalance,(SELECT COUNT(hr_leave_transactions.id) FROM hr_leave_transactions WHERE hr_leave_transactions.RecordType NOT IN("Allocation","Void","Undo-Void") AND hr_leave_transactions.BaseHeaderId=hr_employee_leaves.emp_leaveallocs_id AND hr_leave_transactions.employees_id=hr_employee_leaves.employees_id AND hr_leave_transactions.hr_leavetypes_id=hr_employee_leaves.hr_leavetypes_id AND hr_leave_transactions.Year=hr_employee_leaves.Year) AS RecordCount from hr_employee_leaves inner join hr_leavetypes on hr_employee_leaves.hr_leavetypes_id = hr_leavetypes.id where hr_employee_leaves.emp_leaveallocs_id='.$id.' ORDER BY hr_employee_leaves.id ASC');

        return response()->json(['allocdata'=>$data,'leavetypedata'=>$leavetypedata,'activitydata'=>$activitydata]); 
    }

    public function showEmpLeaveAlloc($id)
    {
        $detailTable=DB::select('select hr_employee_leaves.*, hr_leavetypes.LeaveType,hr_leavetypes.LeavePaymentType,IFNULL(hr_employee_leaves.Remark,"") AS Remark, IFNULL(hr_employee_leaves.LeaveBalance,"") AS LeaveBalance from hr_employee_leaves inner join hr_leavetypes on hr_employee_leaves.hr_leavetypes_id = hr_leavetypes.id where hr_employee_leaves.emp_leaveallocs_id='.$id.' ORDER BY hr_employee_leaves.id DESC');
        return datatables()->of($detailTable)
        ->addIndexColumn() 
        ->rawColumns(['action'])
        ->make(true);
    }

    public function voidLeaveAllocation(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->voidid;
        $leavedata=[];
        $reqCount = 0;

        $empalloc=emp_leavealloc::find($findid);
        $validator = Validator::make($request->all(), [
            'Reason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();

            try{
                $leavedetail = DB::table('hr_employee_leaves')->where('hr_employee_leaves.emp_leaveallocs_id','=',$findid)->get();
                foreach($leavedetail as $chrow){
                    $reqExistData = DB::table('hr_leaves_details')
                        ->join('hr_leaves','hr_leaves_details.hr_leaves_id','hr_leaves.id')
                        ->where('hr_leaves_details.hr_leavetypes_id',$chrow->hr_leavetypes_id)
                        ->where('hr_leaves_details.Year',$chrow->Year)
                        ->whereIn('hr_leaves.Status',["Draft","Pending","Verified","Approved"])
                        ->get();
                    
                    if($reqExistData->count() > 0){
                        $reqCount += 1;
                    }
                }
                
                $existData = DB::table('hr_leave_transactions')
                    ->where('BaseHeaderId',$findid)
                    ->whereIn('RecordType',["Requisition"])
                    ->get();

                $existcount = $existData->count() + $reqCount;

                if($existcount == 0){
                    if($empalloc->Status == "Approved"){
                        foreach($leavedetail as $row){
                            $leavedata[] = [
                                'HeaderId' => $findid,
                                'employees_id' => $empalloc->employees_id,
                                'hr_leavetypes_id' => $row->hr_leavetypes_id,
                                'Year' => $row->Year,
                                'LeaveUsage' => $row->LeaveBalance,
                                'Remark' => $row->Remark,
                                'RecordType' => "Void",
                                'ReferenceNumber' => $empalloc->LeaveAllocationNo,
                                'Date' => Carbon::today()->toDateString(),
                                'BaseHeaderId' => $findid,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }
                        DB::table('hr_leave_transactions')->insertOrIgnore($leavedata);
                    }
                }
                else if($existcount > 0){
                    return Response::json(['voidError' => 465]);
                }
                
                $updateStatus=DB::select('UPDATE emp_leaveallocs SET emp_leaveallocs.OldStatus=emp_leaveallocs.Status WHERE id='.$findid);
                $empalloc->Status="Void";
                $empalloc->save();
                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"leavealloc",'action'=>"Void",'status'=>"Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Reason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
                DB::commit();
                return Response::json(['success' => '1']);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }  
        }

        if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function undoVoidLeaveAlloc(Request $request)
    {
        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;
            $findid = $request->allocDetRecId;
            $leavedata=[];
            $errors = [];

            $empalloc=emp_leavealloc::find($findid);

            if($empalloc->Status == "Void"){
                
                $leavedetail = DB::table('hr_employee_leaves')->where('hr_employee_leaves.emp_leaveallocs_id','=',$findid)->get();
                foreach($leavedetail as $row){

                    if (in_array($row->hr_leavetypes_id, [1])) {
                        $exists = hr_employee_leave::join('hr_leavetypes','hr_employee_leaves.hr_leavetypes_id','hr_leavetypes.id')
                            ->join('emp_leaveallocs','hr_employee_leaves.emp_leaveallocs_id','emp_leaveallocs.id')
                            ->where('hr_employee_leaves.employees_id',$empalloc->employees_id)
                            ->where('hr_employee_leaves.hr_leavetypes_id', $row->hr_leavetypes_id)
                            ->where('hr_employee_leaves.Year',$row->Year)
                            ->whereNotIn('emp_leaveallocs.Status',["Void"])
                            ->where('hr_employee_leaves.emp_leaveallocs_id','!=',$findid)
                            ->exists();

                        if ($exists) {
                            $errors[] = "Leave Type: <b>Anual Leave</b>, Year: <b>{$row->Year}</b></br>";
                        }
                    }

                    $leavedata[] = [
                        'HeaderId' => $findid,
                        'employees_id' => $empalloc->employees_id,
                        'hr_leavetypes_id' => $row->hr_leavetypes_id,
                        'Year' => $row->Year,
                        'LeaveEarned' => $row->LeaveBalance,
                        'Remark' => $row->Remark,
                        'RecordType' => "Undo-Void",
                        'ReferenceNumber' => $empalloc->LeaveAllocationNo,
                        'Date' => Carbon::today()->toDateString(),
                        'BaseHeaderId' => $findid,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }

                if(empty($errors)){
                    if($empalloc->OldStatus == "Approved"){
                        DB::table('hr_leave_transactions')->insert($leavedata);
                    }
                }
                else if(!empty($errors)){
                    return Response::json(['duplicaterr' => 468, 'errors'=>$errors]);
                }
            }

            $oldstatus=$empalloc->OldStatus;
            $empalloc->Status=$empalloc->OldStatus;
            $empalloc->save();
            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"leavealloc",'action'=>"Undo-Void",'status'=>"Undo-Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            
            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function leaveAllocForwardAction(Request $request)
    {
        $val_status = ["Draft","Pending","Verified","Approved"];
        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;

            $findid = $request->la_forwardReqId;
            $empalloc = emp_leavealloc::find($findid);
            $currentStatus = $empalloc->Status;
            $newStatus = $request->la_newForwardStatusValue;
            $action = $request->la_forwardActionValue;
            $empalloc->Status = $newStatus;
            $empalloc->save();

            if($newStatus == "Approved"){
                $leavedetail = DB::table('hr_employee_leaves')->where('hr_employee_leaves.emp_leaveallocs_id','=',$findid)->get();
                foreach($leavedetail as $row){
                    $leavedata[] = [
                        'HeaderId' => $findid,
                        'employees_id' => $empalloc->employees_id,
                        'hr_leavetypes_id' => $row->hr_leavetypes_id,
                        'Year' => $row->Year,
                        'LeaveEarned' => $row->LeaveBalance,
                        'Remark' => $row->Remark,
                        'RecordType' => "Allocation",
                        'ReferenceNumber' => $empalloc->LeaveAllocationNo,
                        'Date' => Carbon::today()->toDateString(),
                        'BaseHeaderId' => $findid,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            
                DB::table('hr_leave_transactions')->insertOrIgnore($leavedata);
            }

            DB::table('actions')->insert(['user_id' => $userid,'pageid' => $findid,'pagename' => "leavealloc",'action' => "$action",'status'=>"$action",'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at' => Carbon::now(),'updated_at'=>Carbon::now()]);
            
            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function leaveAllocBackwardAction(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->la_backwardReqId;
        $action = $request->la_backwardActionValue;
        $newStatus = $request->la_newBackwardStatusValue;
        $empalloc = emp_leavealloc::find($findid);
        $validator = Validator::make($request->all(), [
            'la_CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();
            try{
                $empalloc->Status = $newStatus;
                $empalloc->save();

                DB::table('actions')->insert(['user_id' => $userid,'pageid' => $findid,'pagename' => "leavealloc",'action' => "$action",'status' => "$action",'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason' => "$request->la_CommentOrReason",'created_at' => Carbon::now(),'updated_at' => Carbon::now()]);
                
                DB::commit();
                return Response::json(['success' => 1]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }  
        }

        if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
    }
    //--------------------End Leave Allocation--------------------------------------

    //--------------------Start Payroll Setting------------------------------------
    public function saveEmpSalary(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $employeeid = $request->sal_employee_id;
        $findid = $request->payrollSalaryId;
        $emp_sal_id = $request->salaryInpId;
        $curdate = Carbon::today()->toDateString();
        $settings = DB::table('settings')->latest()->first();
        $isNegotiable = $request->UseCustomizedSalary;
        $salary_file_name = "";
        $actual_name = "";
        $totalearning = 0;
        $totaldeduction = 0;
        $netsalary = 0;
        $netsalaryerrorflag = 0;
        $companypension = 4;
        $salaryid = null;
        $current_doc_num = 0;
        $emp_num = 0;

        $validator = Validator::make($request->all(), [
            'UseCustomizedSalary' => 'required',
            'Salary' => 'required_if:UseCustomizedSalary,0',
            'letter_date' => 'required',
            'salary_letter_file' => 'nullable',
            'salary_remark' => 'nullable',
        ]);

        $earrules=array(
            'erow.*.SalaryType' => 'required',
            'erow.*.Taxable' => 'required',
            'erow.*.NonTaxable' => 'required',
        );

        $dedrules=array(
            'drow.*.SalaryTypeDed' => 'required',
            'drow.*.DedAmount' => 'required',
        );

        $v2 = Validator::make($request->all(), $earrules);

        $v3 = Validator::make($request->all(), $dedrules);

        if ($validator->passes() && $v2->passes() && $v3->passes()){

            DB::beginTransaction();
            try
            {
                if($isNegotiable == 1){

                    $BasicVal = [
                        'SalaryName' => "",
                        'TotalEarnings' => $request->summtotalearningInp,
                        'TaxableEarning' => $request->summtaxableearningInp,
                        'NonTaxableEarning' => $request->summnontaxableearningInp,
                        'TotalDeductions' => $request->summtotaldeductionInp,
                        'NetSalary' => $request->summnetpayInp,
                        'CompanyPension' => $request->summcompanypensionInp,
                        'Description' => "",
                        'Status' => "Active",
                        'IsFixed' => 0,
                    ];
                    
                    $DbData = salary::where('id', $findid)->first();
                    $CreatedBy = ['CreatedBy' => $user];
                    $LastUpdatedBy = ['LastEditedBy' => $user];

                    $salary = salary::updateOrCreate(['id' => $findid],
                        array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                    );

                    foreach ($request->erow as $key => $value){
                        $salarytypedata[(int)$value['SalaryType']] = 
                        [ 
                            'Amount' => $value['Taxable'],
                            'NonTaxableAmount' => $value['NonTaxable'],
                            'TotalAmount' => $value['TotalEarning'],
                            'TaxPercent' => 0,
                            'Deduction' => 0,
                            'Type' => 1,
                            'Remark' => $value['Remark'],
                        ];
                    }

                    foreach ($request->drow as $key => $dvalue){
                        $salarytypedata[(int)$dvalue['SalaryTypeDed']] = 
                        [ 
                            'Amount' => $dvalue['DedAmount'],
                            'NonTaxableAmount' => 0,
                            'TotalAmount' => $dvalue['DedAmount'],
                            'TaxPercent' => $dvalue['TaxPercent'],
                            'Deduction' => $dvalue['Deduction'],
                            'Type' => 2,
                            'Remark' => $dvalue['Remark'],
                        ];
                    }

                    $salarytypedata[$companypension] = 
                    [ 
                        'Amount' => $request->summcompanypensionInp,
                        'NonTaxableAmount' => 0,
                        'TotalAmount' => $request->summcompanypensionInp,
                        'TaxPercent' => 0,
                        'Deduction' => 0,
                        'Type' => 3,
                        'Remark' => "",
                    ];

                    $salary->salarytype()->sync($salarytypedata);
                    $salaryid = $salary->id;
                }

                $emp_data = employee::where('id',$employeeid)->first();
                if(preg_match('/\d+(\.\d+)?/', $emp_data->EmployeeID, $matches)){
                    $emp_num =  (int)$matches[0];
                }
                else{
                    $emp_num = 0;
                }

                if ($request->file('salary_letter_file')) {
                    $file = $request->file('salary_letter_file') ?? "";
                    $actual_name = $file->getClientOriginalName();
                    $salary_file_name = time(). $request->file('salary_letter_file')->extension();
                    $pathIdentification = public_path() . '/storage/uploads/EmployeeDocumets/Salary';
                    $pathnameIdentification = '/storage/uploads/EmployeeDocumets/Salary/'.$salary_file_name;
                    $file->move($pathIdentification, $salary_file_name);
                }
                if($request->file('salary_letter_file') == ''){
                    $salary_file_name = $request->salary_letter_filename;
                    $actual_name = $request->salary_letter_actual_fn;
                }

                $emp_salary_prop = employee_salary::where('employees_id',$employeeid)->latest()->first();
                $salary_doc_num = $settings->salary_prefix.str_pad($emp_num,3,'0',STR_PAD_LEFT)."-".sprintf("%03d",($emp_salary_prop->inc_value ?? 0)+1);
                //$salary_doc_num = $settings->salary_prefix.sprintf("%05d",($emp_salary_prop->inc_value ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                $current_doc_num = ($emp_salary_prop->inc_value ?? 0) + 1;

                $salary_db_data = employee_salary::where('id', $emp_sal_id)->first();
                $salary_basic = [
                    'employees_id' => $employeeid,
                    'is_negotiable' => $isNegotiable,
                    'salaries_id' => $isNegotiable == 1 ? $salaryid : $request->Salary,
                    'doc_name' => $salary_file_name == NULL ? "" : $salary_file_name,
                    'actual_file_name' => $actual_name,
                    'date' => $request->letter_date,
                    'remark' => $request->salary_remark,
                ];
                $created_data = ['doc_number' => $salary_doc_num,'status' => "Draft",'inc_value' => $current_doc_num,'created_at' => Carbon::now()];
                $updated_data = ['updated_at' => Carbon::now()];

                $emp_salary = employee_salary::updateOrCreate(['id' => $emp_sal_id],
                    array_merge($salary_basic, $salary_db_data ? $updated_data : $created_data),
                );


                $actions = $emp_sal_id == null ? "Created" : "Edited";
                actions::insert(['user_id' => $userid,'pageid' => $emp_salary->id,'pagename' => "salary-sett",'action' => $actions,'status' => $actions,'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason' => "",'created_at' => Carbon::now(),'updated_at' => Carbon::now()]);

                DB::commit();
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
        if($v2->fails() || $v3->fails())
        {
            return Response::json(['errorsv2'=> $v2->errors(),'errorsv3'=> $v3->errors()]);
        }
    }

    public function showPayrollData(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        $emp_id = $_POST['empid']; 

        $query = DB::select("SELECT CASE WHEN employee_salaries.is_negotiable=1 THEN 'YES' ELSE 'NO' END AS is_neg,salaries.SalaryName AS salary,employee_salaries.*,CASE WHEN employee_salaries.status = 'Void' THEN CONCAT(employee_salaries.status, '(', employee_salaries.old_status, ')') ELSE employee_salaries.status END AS display_status FROM employee_salaries LEFT JOIN salaries ON employee_salaries.salaries_id=salaries.id WHERE employee_salaries.employees_id=".$emp_id." ORDER BY employee_salaries.id DESC");
        if(request()->ajax()) {
            return datatables()->of($query)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showSalaryData($id){
        $data = employee_salary::leftJoin('employees','employee_salaries.employees_id','employees.id')
        ->leftJoin('salaries','employee_salaries.salaries_id','salaries.id')
        ->where('employee_salaries.id',$id)
        ->get(['employee_salaries.*','employees.PensionPercent','employees.CompanyPensionPercent','salaries.SalaryName AS salary_name',
            'salaries.*',DB::raw('CASE WHEN employee_salaries.is_negotiable=0 THEN "NO" ELSE "YES" END AS is_neg')
        ]);

        $activitydata = actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"salary-sett")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['saldata' => $data,'activitydata' => $activitydata]); 
    }

    public function salaryForwardAction(Request $request)
    {
        $val_status = ["Draft","Pending","Verified","Approved"];
        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;

            $findid = $request->forwardReqId;
            $empsalary = employee_salary::find($findid);
            $currentStatus = $empsalary->Status;
            $newStatus = $request->newForwardStatusValue;
            $action = $request->forwardActionValue;
            $empsalary->Status = $newStatus;
            $empsalary->save();

            if($newStatus == "Approved"){
                $locat_time_format = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $current_time = Carbon::now();
                DB::table('employees')
                    ->where('id', $empsalary->employees_id)
                    ->update(['salaries_id' => $empsalary->salaries_id,'UpdateSalaryFlag' => $empsalary->is_negotiable]);

                DB::table('actions')->insertUsing(
                    ['user_id', 'pageid', 'pagename', 'action', 'status','time','created_at','updated_at'],
                    DB::table('employee_salaries')
                        ->select(DB::raw($userid),'employee_salaries.id',DB::raw('"salary-sett"'),DB::raw('"Closed"'), DB::raw('"Closed"'), DB::raw("'$locat_time_format'"),DB::raw("'$current_time'"),DB::raw("'$current_time'"))
                        ->where('employee_salaries.employees_id', $empsalary->employees_id)
                        ->whereNotIn('status',["Void","Approved","Closed"])
                        ->where('id','!=',$findid)
                    );

                DB::table('employee_salaries')
                    ->where('employees_id', $empsalary->employees_id)
                    ->whereIn('status',$val_status)
                    ->where('id','!=',$findid)
                    ->update(['status' => "Closed"]);
            }

            DB::table('actions')->insert(['user_id' => $userid,'pageid' => $findid,'pagename' => "salary-sett",'action' => "$action",'status'=>"$action",'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at' => Carbon::now(),'updated_at'=>Carbon::now()]);
            
            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function salaryBackwardAction(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->backwardReqId;
        $action = $request->backwardActionValue;
        $newStatus = $request->newBackwardStatusValue;
        $empsalary = employee_salary::find($findid);
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();
            try{
                $empsalary->Status = $newStatus;
                $empsalary->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"salary-sett",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->CommentOrReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
                DB::commit();
                return Response::json(['success' => '1']);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }  
        }

        if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function voidSalary(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $headerid = $request->salVoidId;
        $findid = $request->salVoidId;

        $validator = Validator::make($request->all(), [
            'SalaryVoidReason' => ['required'],
        ]);

        if ($validator->passes()){
            DB::beginTransaction();
            try
            {
                $empsalary = employee_salary::where('id', $findid)->first();
                $oldstatus = $empsalary->status;

                $sdata = employee_salary::find($findid);
                $sdata->status = "Void(".$oldstatus.")";
                $sdata->old_status = $oldstatus;
                $sdata->save();

                if($oldstatus == "Approved"){
                    DB::table('employees')
                    ->where('id', $sdata->employees_id)
                    ->update(['salaries_id' => 1]);
                }

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"salary-sett",'action'=>"Void",'status'=>"Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->SalaryVoidReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

                DB::commit();
                return Response::json(['success' => 1]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function undoVoidSalary(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->infoRecId;
        $empdata = employee_salary::where('id', $findid)->first();
        $status = $empdata->old_status;
        $val_status = ["Approved","Closed"];

        DB::beginTransaction();
        try{

            $sdata = employee_salary::find($findid);
            $sdata->status = $status;
            $sdata->old_status = "";
            
            if($status == "Approved"){
                $getlatestcnt = employee_salary::where('id','>',$findid)->whereIn('status',$val_status)->where('employees_id', $sdata->employees_id)->count();
                if($getlatestcnt > 0){
                    return Response::json(['voidoverlaperr' => 462, 'oldstatus' => $status]);
                }
                DB::table('employees')
                    ->where('id', $sdata->employees_id)
                    ->update(['salaries_id' => $sdata->salaries_id,'UpdateSalaryFlag' => $sdata->is_negotiable]);
            }

            $sdata->save();
            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"salary-sett",'action'=>"Undo-Void",'status'=>"Undo-Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Reason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

            DB::commit();
            return Response::json(['success' => 1]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }
    //--------------------End Payroll Setting------------------------------------

    public function resetEmpPass(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;
            $findid = $request->info_employee_id;
            $usr = User::where('empid', $findid)->first();
            $usr->password = Hash::make("123456");
            $usr->changePass= 0;
            $usr->save();

            DB::table('actions')->insert(['user_id' => $userid,'pageid' => $findid,'pagename' => "employee",'action' => "Password Reset",'status' => "Password Reset",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

            DB::commit();
            return Response::json(['success' => 1]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    //-------------Start count status-------------------

    public function countEmployeeStatus(){
        $empstatus = DB::select('SELECT employees.Status,FORMAT(COUNT(*),0) AS status_count FROM employees WHERE employees.id>1 GROUP BY employees.Status UNION SELECT "Total",FORMAT(COUNT(*),0) AS status_count FROM employees WHERE employees.id>1');
        return response()->json(['empstatus' => $empstatus]); 
    }

    function countEmpLeaveAndSalary(){
        $emp_id = $_POST['empid']; 
        $leavestatus = DB::select('SELECT emp_leaveallocs.Status,FORMAT(COUNT(*),0) AS status_count FROM emp_leaveallocs WHERE emp_leaveallocs.employees_id='.$emp_id.' GROUP BY emp_leaveallocs.Status UNION SELECT "Total",FORMAT(COUNT(*),0) AS status_count FROM emp_leaveallocs WHERE emp_leaveallocs.employees_id='.$emp_id);
        $salarystatus = DB::select('SELECT employee_salaries.Status,FORMAT(COUNT(*),0) AS status_count FROM employee_salaries WHERE employee_salaries.employees_id='.$emp_id.' GROUP BY employee_salaries.Status UNION SELECT "Total",FORMAT(COUNT(*),0) AS status_count FROM employee_salaries WHERE employee_salaries.employees_id='.$emp_id);
        
        return response()->json(['leavestatus' => $leavestatus,'salarystatus' => $salarystatus]); 
    }

    //-------------End count status-------------------

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
