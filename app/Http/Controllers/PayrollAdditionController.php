<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\overtime;
use App\Models\salarytype;
use App\Models\employee;
use App\Models\payrolladdition;
use App\Models\payrolladdetail;
use App\Models\actions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Jenssegers\Date\Date;

class PayrollAdditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentdate = Carbon::today()->format('d-M');
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $fiscayearnext=$fyear+1;
        $fromdaterange=$fyear."-07-01";
        $lastdatecurrfy=$fiscayearnext."-07-01";

        // Assuming $date is the date you want to convert
        //$date = Carbon::parse('2024-05-01');
        
        $date = Carbon::now();
        $date->setLocale('am');
        $formattedDate = $date->format('j F Y');

        $branchlist = employee::join('branches','employees.branches_id','branches.id')->where('branches.Status',"Active")->where('employees.Status',"Active")->distinct()->orderBy('employees.name','ASC')->get(['branches.BranchName','employees.branches_id']);
        $deplist = employee::join('departments','employees.departments_id','departments.id')->where('departments.Status',"Active")->where('employees.Status',"Active")->where('employees.departments_id','>',1)->distinct()->orderBy('employees.name','ASC')->get(['departments.DepartmentName','employees.departments_id','employees.branches_id','employees.positions_id']);
        $positionlist = employee::join('positions','employees.positions_id','positions.id')->where('positions.Status',"Active")->where('employees.Status',"Active")->distinct()->orderBy('employees.name','ASC')->get(['positions.PositionName','employees.departments_id','employees.positions_id']);
        $emplist = employee::where('employees.Status',"Active")->where('employees.id','>',1)->orderBy('employees.name','ASC')->get(['employees.id','employees.name','employees.departments_id','employees.branches_id','employees.positions_id']);
        $salarytypes = salarytype::where('salarytypes.Status',"Active")->where('salarytypes.id','>',2)->orderBy('salarytypes.SalaryTypeName','ASC')->get();
        
        $fromMonthData=DB::select("SELECT DISTINCT DATE_FORMAT(date_sequence, '%Y-%m') AS month_year,DATE_FORMAT(date_sequence, '%Y-%M') AS month_yearfullformat
            FROM (
                SELECT ADDDATE('$fromdaterange', INTERVAL (t4*10000 + t3*1000 + t2*100 + t1*10 + t0) MONTH) AS date_sequence
                FROM
                    (SELECT 0 AS t0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                    SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS tens,
                    (SELECT 0 AS t1 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                    SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS ones,
                    (SELECT 0 AS t2 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                    SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS hundreds,
                    (SELECT 0 AS t3 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) AS thousands,
                    (SELECT 0 AS t4 UNION ALL SELECT 1) AS ten_thousands
            ) AS date_sequence_table
            WHERE date_sequence BETWEEN '$fromdaterange' AND '$lastdatecurrfy'
            ORDER BY date_sequence");

        $toMonthData=DB::select("SELECT DISTINCT DATE_FORMAT(date_sequence, '%Y-%m') AS month_year,DATE_FORMAT(date_sequence, '%Y-%M') AS month_yearfullformat
            FROM (
                SELECT ADDDATE('$fromdaterange', INTERVAL (t4*10000 + t3*1000 + t2*100 + t1*10 + t0) MONTH) AS date_sequence
                FROM
                    (SELECT 0 AS t0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                    SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS tens,
                    (SELECT 0 AS t1 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                    SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS ones,
                    (SELECT 0 AS t2 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                    SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS hundreds,
                    (SELECT 0 AS t3 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) AS thousands,
                    (SELECT 0 AS t4 UNION ALL SELECT 1) AS ten_thousands
            ) AS date_sequence_table
            WHERE date_sequence BETWEEN '$fromdaterange' AND '$lastdatecurrfy'
            ORDER BY date_sequence");

        $branchfilter = DB::select('SELECT DISTINCT branches.id,branches.BranchName FROM payrolladditions LEFT JOIN branches ON payrolladditions.branches_id=branches.id ORDER BY branches.BranchName ASC');        

        if($request->ajax()) {
            return view('hr.payrolladd',['deplist'=>$deplist,'emplist'=>$emplist,'branchlist'=>$branchlist,'positionlist'=>$positionlist,'fromMonthData'=>$fromMonthData,'toMonthData'=>$toMonthData,'salarytypes'=>$salarytypes,'branchfilter'=>$branchfilter])->renderSections()['content'];
        }
        else{
            return view('hr.payrolladd',['deplist'=>$deplist,'emplist'=>$emplist,'branchlist'=>$branchlist,'positionlist'=>$positionlist,'fromMonthData'=>$fromMonthData,'toMonthData'=>$toMonthData,'salarytypes'=>$salarytypes,'branchfilter'=>$branchfilter]);
        }
    }


    public function payrolladdlist()
    {
        $childids=[0];
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $empid=Auth()->user()->empid;
        $users=Auth()->user();
        $payrolladdlists=DB::select('SELECT payrolladditions.id,payrolladditions.DocumentNumber,CASE WHEN payrolladditions.type=1 THEN "Addition" WHEN payrolladditions.type=2 THEN "Deduction" END AS Ptype,CONCAT(DATE_FORMAT(CONCAT(payrolladditions.PayRangeFrom,"-01"),"%Y-%M")," to ",DATE_FORMAT(CONCAT(payrolladditions.PayRangeTo,"-01"),"%Y-%M")) AS PayRange,branches.BranchName,payrolladditions.Status FROM payrolladditions INNER JOIN branches ON payrolladditions.branches_id=branches.id ORDER BY payrolladditions.id DESC');
        if(request()->ajax()) {
            return datatables()->of($payrolladdlists)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $payedit='';
                $voidpayroll='';
                $undopayroll='';
                $rejectpayroll='';
                $undorejpayroll='';
                if($data->Status=='Draft' || $data->Status=='Pending')
                {
                    if($user->can('Payroll-Addition-Deduction-Void')){
                        $voidpayroll='<a class="dropdown-item payrolladdVoid" onclick="payrolladdVoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open payroll addition/deduction void confirmation">
                            <i class="fa fa-trash"></i><span> Void</span>  
                        </a>';
                    }
                    
                    if($user->can('Payroll-Addition-Deduction-Edit')){
                        $payedit=' <a class="dropdown-item payrolladdedit" onclick="payrolladdeditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open payroll addition/deduction page"> <i class="fa fa-edit"></i><span> Edit</span></a>'; 
                    }
                    $undopayroll='';
                }
                else if($data->Status=='Verified')
                {
                    if($user->can('Leave-Request-Verify')){
                        if($user->can('Leave-Request-Void')){
                            $voidpayroll='<a class="dropdown-item payrolladdVoid" onclick="payrolladdVoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open payroll addition/deduction void confirmation">
                                <i class="fa fa-trash"></i><span> Void</span>  
                            </a>';
                        }
                        if($user->can('Payroll-Addition-Deduction-Edit')){
                            $payedit=' <a class="dropdown-item payrolladdedit" onclick="payrolladdeditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open payroll addition/deduction page"> <i class="fa fa-edit"></i><span> Edit</span></a>'; 
                        }
                    }
                    $undopayroll='';
                }
                else if($data->Status=='Approved')
                {
                    if($user->can('Payroll-Addition-Deduction-Void')){
                        $voidpayroll='<a class="dropdown-item payrolladdVoid" onclick="payrolladdVoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open payroll addition/deduction void confirmation">
                                <i class="fa fa-trash"></i><span> Void</span>  
                            </a>';
                    }
                    
                    $undopayroll='';
                }
                
                else if($data->Status=='Rejected')
                {
                    $payedit='';
                    $voidpayroll='';
                    $undopayroll='';
                    $rejectpayroll='';
                }
                if($data->Status=='Void'||$data->Status=='Void(Pending)'||$data->Status=='Void(Approved)')
                {
                    $voidpayroll='';
                    if($user->can('Payroll-Addition-Deduction-Void')){
                        $undopayroll='<a class="dropdown-item payrollundovoid" onclick="payrollundovoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open payroll addition/deduction undo void confirmation">
                                <i class="fa fa-undo"></i><span>Undo Void</span>  
                            </a>';
                    }
                }
                
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item payrollAddInfo" onclick="payrollAddDedInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open payroll addition/deduction information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$payedit.'
                        '.$voidpayroll.'
                        '.$undopayroll.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }


    public function paydepartmentlist(){
        $branchlist = employee::join('branches','employees.branches_id','branches.id')->where('branches.Status',"Active")->where('employees.Status',"Active")->distinct()->orderBy('employees.name','ASC')->get(['branches.BranchName','employees.branches_id']);
        $deplist = employee::join('departments','employees.departments_id','departments.id')->where('departments.Status',"Active")->where('employees.Status',"Active")->where('employees.departments_id','>',1)->distinct()->orderBy('employees.name','ASC')->get(['departments.DepartmentName','employees.departments_id','employees.branches_id','employees.positions_id']);
        $positionlist = employee::join('positions','employees.positions_id','positions.id')->where('positions.Status',"Active")->where('employees.Status',"Active")->distinct()->orderBy('employees.name','ASC')->get(['positions.PositionName','employees.departments_id','employees.positions_id']);
        $emplist = employee::where('employees.Status',"Active")->orderBy('employees.name','ASC')->get(['employees.id','employees.name','employees.departments_id','employees.branches_id','employees.positions_id']);
        return response()->json(['deplist'=>$deplist,'emplist'=>$emplist,'branchlist'=>$branchlist,'positionlist'=>$positionlist]);
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
        $settings = DB::table('settings')->latest()->first();
        $documentNumber=$settings->PayrollAddPrefix.sprintf("%06d",$settings->PayrollAddNumber);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->recId;
        $findid=$request->recId;
        $createdAt=null;
        $detailData=[];

        $validator = Validator::make($request->all(), [
            'Type' => ['required'],
            'Branch' => ['required'],
            'Department' => ['required'],
            'Position' => ['required'],
            'Employee' => ['required'],
            'ToMonthRange' => ['required'],
            'FromMonthRange' => ['required'],
        ]);

        $rules=array(
            'row.*.SalaryComponent' => 'required',
            'row.*.amount' => 'required',
        );
        $v2= Validator::make($request->all(), $rules);

        if ($validator->passes() && $v2->passes() && $request->row!=null){

            DB::beginTransaction();
            try
            {
                $BasicVal = [
                    'type' => $request->Type,
                    'branches_id' => $request->Branch,
                    'departments_id' => $request->Department,
                    'positions_id' => $request->Position,
                    'PayRangeFrom' => $request->FromMonthRange,
                    'PayRangeTo' => $request->ToMonthRange,
                    'Remark' => $request->Remark,
                ];
                $DbData = payrolladdition::where('id', $findid)->first();
                $CreatedBy = ['DocumentNumber' => $documentNumber,'Status' => "Draft"];
                $LastUpdatedBy = ['LastEditedBy' => $user,'LastEditedDate'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A')];
            
                $payrolladd = payrolladdition::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                foreach($request->input('Employee') as $row){
                    foreach ($request->row as $key => $value)
                    {
                        $detailData[]=['payrolladditions_id'=>$payrolladd->id,'employees_id'=>$row,'salarytypes_id'=>$value['SalaryComponent'],'Amount'=>$value['amount'],'Remark'=>$value['Description'],'created_at'=>$payrolladd->created_at,'updated_at'=>Carbon::now()];
                    }
                }
                payrolladdetail::where('payrolladdetails.payrolladditions_id',$payrolladd->id)->delete();
                payrolladdetail::insert($detailData);
                if($findid==null){
                    $updn=DB::select('UPDATE settings SET PayrollAddNumber=PayrollAddNumber+1 WHERE id=1');
                }

                $actions = $findid == null ? "Created" : "Edited";

                actions::insert(['user_id'=>$userid,'pageid'=>$payrolladd->id,'pagename'=>"payrolladd",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
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
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
        if($request->row==null)
        {
            return Response::json(['emptyerror'=>"error"]);
        }
    }

    public function payrollAddDedForwardAction(Request $request)
    {
        DB::beginTransaction();
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;

            $findid = $request->forwardReqId;
            $payrolladd = payrolladdition::find($findid);
            $currentStatus = $payrolladd->Status;
            $newStatus = $request->newForwardStatusValue;
            $action = $request->forwardActionValue;

            $payrolladd->Status = $newStatus;
            $payrolladd->save();

            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"payrolladd",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            
            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function payrollAddDedBackwardAction(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backwardReqId;
        $action=$request->backwardActionValue;
        $newStatus=$request->newBackwardStatusValue;
        $payrolladd = payrolladdition::find($findid);
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();

            try{
                $payrolladd->Status = $newStatus;
                $payrolladd->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"payrolladd",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->CommentOrReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
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

    public function approvePayrollAddDed(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->appId;
        $payrolldatas = payrolladdition::where('id', $findid)->first();
        $oldstatus=$payrolldatas->Status;

        try{
            $pdata=payrolladdition::find($findid);
            $pdata->Status="Approved";
            $pdata->OldStatus=$oldstatus;
            $pdata->ApprovedBy= $user;
            $pdata->ApprovedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $pdata->save();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function voidPayrollAddDed(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->voidId;
        $findid=$request->voidId;

        $validator = Validator::make($request->all(), [
            'Reason' => ['required'],
        ]);

        if ($validator->passes()){
            DB::beginTransaction();
            try
            {
                $payrolldatas = payrolladdition::where('id', $findid)->first();
                $oldstatus=$payrolldatas->Status;

                $pdata=payrolladdition::find($findid);
                $pdata->Status="Void(".$oldstatus.")";
                $pdata->OldStatus=$oldstatus;
                $pdata->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"payrolladd",'action'=>"Void",'status'=>"Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Reason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

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
    }

    public function undovoidPayrollAddDed(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->undovoidid;
        $payrolldatas = payrolladdition::where('id', $findid)->first();
        $status=$payrolldatas->OldStatus;

        DB::beginTransaction();
        try{
            $pdata=payrolladdition::find($findid);
            $pdata->Status=$status;
            $pdata->OldStatus=$status;
            $pdata->save();

            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"payrolladd",'action'=>"Undo-Void",'status'=>"Undo-Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Reason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function rejectPayrollAddDed(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->rejectId;
        $payrolldatas = payrolladdition::where('id', $findid)->first();
        $oldstatus=$payrolldatas->Status;

        try{
            $pdata=payrolladdition::find($findid);
            $pdata->Status="Rejected";
            $pdata->OldStatus=$oldstatus;
            $pdata->RejectBy= $user;
            $pdata->RejectDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $pdata->save();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function showPayrollAddCon($id){
        $countdata=0;
        $totalsalaryamount=0;
        $recdata=payrolladdition::findorFail($id);

        $createddate = Carbon::createFromFormat('Y-m-d H:i:s', $recdata->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $updateddate = Carbon::createFromFormat('Y-m-d H:i:s', $recdata->updated_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $firstDayOfMonth = Carbon::createFromFormat('Y-m',$recdata->PayRangeFrom)->firstOfMonth();
        $formattedFirstDay = $firstDayOfMonth->format('F-d-Y');

        $endDayOfMonth = Carbon::createFromFormat('Y-m',$recdata->PayRangeTo)->endOfMonth();
        $formattedEndDay = $endDayOfMonth->format('F-d-Y');

        $data = payrolladdition::join('branches','payrolladditions.branches_id','branches.id')
        ->join('departments','payrolladditions.departments_id','departments.id')
        ->join('positions','payrolladditions.positions_id','positions.id')
        ->where('payrolladditions.id', $id)
        ->get(['payrolladditions.*','branches.BranchName','departments.DepartmentName','positions.PositionName'
        ,DB::raw('CASE WHEN payrolladditions.type=1 THEN "Addition" WHEN payrolladditions.type=2 THEN "Deduction" END AS PType')
        ,DB::raw('CONCAT(DATE_FORMAT(CONCAT(payrolladditions.PayRangeFrom,"-01"),"%Y-%M")," to ",DATE_FORMAT(CONCAT(payrolladditions.PayRangeTo,"-01"),"%Y-%M")) AS PayRange')
        ,DB::raw("'$formattedFirstDay' AS FirstDayofMonth"),DB::raw("'$formattedEndDay' AS LastDayofMonth")]);

        $empdata = payrolladdetail::join('employees','payrolladdetails.employees_id','employees.id')
        ->where('payrolladdetails.payrolladditions_id', $id)
        ->distinct()
        ->get(['payrolladdetails.employees_id','employees.name']);

        $saldata = payrolladdetail::join('salarytypes','payrolladdetails.salarytypes_id','salarytypes.id')
        ->join('payrolladditions','payrolladdetails.payrolladditions_id','payrolladditions.id')
        ->where('payrolladdetails.payrolladditions_id', $id)
        ->distinct()
        ->get(['payrolladditions.type','payrolladdetails.salarytypes_id','salarytypes.SalaryTypeName','payrolladdetails.Amount',DB::raw('IFNULL(payrolladdetails.Remark,"") AS PdetailRemark')]);

        $totalamount = payrolladdetail::where('payrolladdetails.payrolladditions_id', $id)
        ->distinct()
        ->get(['payrolladdetails.Amount']);
        foreach($totalamount as $rowamount){
            $totalsalaryamount+=$rowamount->Amount;
        }

        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"payrolladd")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);


        return response()->json(['payrolladd'=>$data,'empdata'=>$empdata,'saldata'=>$saldata,'activitydata'=>$activitydata,'totalsalaryamount'=> number_format($totalsalaryamount,2)]);       
    }

    public function showEmployeeListData($id)
    {
        $detailTable=DB::select('SELECT DISTINCT employees.EmployeeID,employees.name,CONCAT(employees.MobileNumber," , ",employees.phone) AS EmployeePhone FROM payrolladdetails INNER JOIN employees ON payrolladdetails.employees_id=employees.id WHERE payrolladdetails.payrolladditions_id='.$id.' ORDER BY employees.name ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showSalaryCompListData($id)
    {
        $detailTable=DB::select('SELECT DISTINCT salarytypes.SalaryTypeName,FORMAT(payrolladdetails.Amount,2) AS Amount,IFNULL(payrolladdetails.Remark,"") AS PdetailRemark FROM payrolladdetails INNER JOIN salarytypes ON payrolladdetails.salarytypes_id=salarytypes.id WHERE payrolladdetails.payrolladditions_id='.$id.' ORDER BY payrolladdetails.id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }


    public function getFromMonthRange(Request $request)
    {
        $fromMonRange=$_POST['fromMonRange']; 
        $firstDayOfMonth = Carbon::createFromFormat('Y-m',$fromMonRange)->firstOfMonth();
        $formattedFirstDay = $firstDayOfMonth->format('F-d-Y');
        return response()->json(['fday'=>$formattedFirstDay]);
    }

    public function getToMonthRange(Request $request)
    {
        $toMonRange=$_POST['toMonRange']; 
        $endDayOfMonth = Carbon::createFromFormat('Y-m',$toMonRange)->endOfMonth();
        $formattedEndDay = $endDayOfMonth->format('F-d-Y');
        return response()->json(['eday'=>$formattedEndDay]);
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
