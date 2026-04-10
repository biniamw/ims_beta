<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\overtime;
use App\Models\salarytype;
use App\Models\employee;
use App\Models\salary;
use App\Models\payrolladdition;
use App\Models\payrolladdetail;
use App\Models\payrolldetail;
use App\Models\attendance;
use App\Models\payroll;
use App\Models\payrollemployee;
use App\Models\payrollsalary;
use App\Models\attendance_summary;
use App\Models\attendance_overtime;
use App\Models\actions;
use App\Models\salarydetail;
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

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $currentdate = Carbon::today()->format('d-M');
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $fiscayearnext=$fyear+1;
        $fromdaterange=$fyear."-07-01";
        $lastdatecurrfy=$fiscayearnext."-07-01";

        $date = Carbon::now();
        $date->setLocale('am');
        $formattedDate = $date->format('j F Y');

        $branchlist = employee::join('branches','employees.branches_id','branches.id')->where('branches.Status',"Active")->where('employees.Status',"Active")->distinct()->orderBy('employees.name','ASC')->get(['branches.BranchName','employees.branches_id']);
        $deplist = employee::join('departments','employees.departments_id','departments.id')->where('departments.Status',"Active")->where('employees.Status',"Active")->where('employees.departments_id','>',1)->distinct()->orderBy('employees.name','ASC')->get(['departments.DepartmentName','employees.departments_id','employees.branches_id','employees.positions_id']);
        $positionlist = employee::join('positions','employees.positions_id','positions.id')->where('positions.Status',"Active")->where('employees.Status',"Active")->distinct()->orderBy('employees.name','ASC')->get(['positions.PositionName','employees.departments_id','employees.positions_id']);
        $emplist = employee::where('employees.Status',"Active")->where('employees.id','>',1)->orderBy('employees.name','ASC')->get(['employees.id','employees.name','employees.departments_id','employees.branches_id','employees.positions_id']);
        $salarytypes = salarytype::where('salarytypes.Status',"Active")->where('salarytypes.id','>',2)->orderBy('salarytypes.SalaryTypeName','ASC')->get();
        
        $fromMonthData=DB::select("SELECT DISTINCT DATE_FORMAT(attendance_summaries.Date, '%Y-%m') AS month_year,DATE_FORMAT(attendance_summaries.Date, '%Y-%M') AS month_yearfullformat FROM attendance_summaries ORDER BY attendance_summaries.Date ASC");

        $toMonthData=DB::select("SELECT DISTINCT DATE_FORMAT(attendance_summaries.Date, '%Y-%m') AS month_year,DATE_FORMAT(attendance_summaries.Date, '%Y-%M') AS month_yearfullformat FROM attendance_summaries ORDER BY attendance_summaries.Date ASC");

        if($request->ajax()) {
            return view('hr.payroll',['deplist'=>$deplist,'emplist'=>$emplist,'branchlist'=>$branchlist,'positionlist'=>$positionlist,'fromMonthData'=>$fromMonthData,'toMonthData'=>$toMonthData,'salarytypes'=>$salarytypes])->renderSections()['content'];
        }
        else{
            return view('hr.payroll',['deplist'=>$deplist,'emplist'=>$emplist,'branchlist'=>$branchlist,'positionlist'=>$positionlist,'fromMonthData'=>$fromMonthData,'toMonthData'=>$toMonthData,'salarytypes'=>$salarytypes]);
        }
    }

    public function getEmployeeTree(){
        $employeetree=DB::select('SELECT employees.branches_id,branches.BranchName,employees.departments_id,departments.DepartmentName,employees.positions_id,positions.PositionName,employees.id AS employees_id,employees.name AS employees_name FROM employees LEFT JOIN branches ON employees.branches_id=branches.id LEFT JOIN departments ON employees.departments_id=departments.id LEFT JOIN positions ON employees.positions_id=positions.id WHERE employees.Status="Active" AND employees.id>1 ORDER BY branches.BranchName ASC,departments.DepartmentName ASC,positions.PositionName ASC,employees.name ASC');
        return response()->json(['employeetree'=>$employeetree]);
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

    public function departmentlist(){
        $branchlist = employee::join('branches','employees.branches_id','branches.id')->where('branches.Status',"Active")->where('employees.Status',"Active")->distinct()->orderBy('employees.name','ASC')->get(['branches.BranchName','employees.branches_id']);
        $deplist = employee::join('departments','employees.departments_id','departments.id')->where('departments.Status',"Active")->where('employees.Status',"Active")->where('employees.departments_id','>',1)->distinct()->orderBy('employees.name','ASC')->get(['departments.DepartmentName','employees.departments_id','employees.branches_id','employees.positions_id']);
        $positionlist = employee::join('positions','employees.positions_id','positions.id')->where('positions.Status',"Active")->where('employees.Status',"Active")->distinct()->orderBy('employees.name','ASC')->get(['positions.PositionName','employees.departments_id','employees.positions_id']);
        $emplist = employee::where('employees.Status',"Active")->where('employees.id','>',1)->orderBy('employees.name','ASC')->get(['employees.id','employees.name','employees.departments_id','employees.branches_id','employees.positions_id']);
        return response()->json(['deplist'=>$deplist,'emplist'=>$emplist,'branchlist'=>$branchlist,'positionlist'=>$positionlist]);
    }

    public function payrollList()
    {
        $childids=[0];
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $empid=Auth()->user()->empid;
        $users=Auth()->user();
        $payrolllist=DB::select('SELECT payrolls.id,payrolls.DocumentNumber,CASE WHEN payrolls.type=1 THEN "Regular" WHEN payrolls.type=2 THEN "Others" END AS Ptype,(SELECT GROUP_CONCAT(DISTINCT " ",branches.BranchName) FROM payrolldetails LEFT JOIN employees ON payrolldetails.employees_id=employees.id LEFT JOIN branches ON employees.branches_id=branches.id WHERE payrolldetails.payrolls_id=payrolls.id) AS Branch,CONCAT(DATE_FORMAT(CONCAT(payrolls.PayRangeFrom,"-01"),"%Y-%M")," to ",DATE_FORMAT(CONCAT(payrolls.PayRangeTo,"-01"),"%Y-%M")) AS PayRange,payrolls.Status FROM payrolls ORDER BY payrolls.id DESC');
        if(request()->ajax()) {
            return datatables()->of($payrolllist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $payedit='';
                $voidpayroll='';
                $undopayroll='';
                $rejectpayroll='';
                $undorejpayroll='';
                if($data->Status=='Draft' || $data->Status=='Pending' || $data->Status=='Verified')
                {
                    if($user->can('Payroll-Void')){
                        $voidpayroll='<a class="dropdown-item payrolladdVoid" onclick="payrolladdVoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open payroll void confirmation">
                                <i class="fa fa-trash"></i><span> Void</span>  
                            </a>';
                    }
                    
                    if($user->can('Payroll-Edit')){
                        $payedit=' <a class="dropdown-item payrolladdedit" onclick="payrollEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open payroll page"> <i class="fa fa-edit"></i><span> Edit</span></a>'; 
                    }
                    $undopayroll='';
                }
                else if($data->Status=='Approved')
                {
                    if($user->can('Payroll-Void')){
                        $voidpayroll='<a class="dropdown-item payrolladdVoid" onclick="payrolladdVoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open payroll void confirmation">
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
                if($data->Status=='Void' || $data->Status=='Void(Draft)' || $data->Status=='Void(Pending)' || $data->Status=='Void(Verified)' || $data->Status=='Void(Approved)')
                {
                    $voidpayroll='';
                    if($user->can('Payroll-Void')){
                        $undopayroll='<a class="dropdown-item payrollundovoid" onclick="payrollundovoidFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open payroll undo void confirmation">
                                <i class="fa fa-undo"></i><span>Undo Void</span>  
                            </a>';
                    }
                }
                
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item payrollAddInfo" onclick="payrollInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open payroll information page">
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

    public function getPayrollColumns()
    {
        $settings = DB::table('settings')->latest()->first();

        $salaryTypes = DB::table('salarytypes')
            ->where('show_on_payroll', 1)
            ->where('Status', "Active")
            ->orderBy('SalaryType','DESC')
            ->get();

        $otherEarningFlag = DB::table('salarytypes')
            ->where('show_on_payroll', 0)
            ->where('SalaryType', "Earnings")
            ->where('Status', "Active")
            ->count();
        
        $otherDeductionFlag = DB::table('salarytypes')
            ->where('show_on_payroll', 0)
            ->where('SalaryType', "Deductions")
            ->where('Status', "Active")
            ->count();

        $nonTaxableData = DB::table('salarytypes')
            ->where('Status', "Active")
            ->get([DB::raw('COALESCE(SUM(salarytypes.NonTaxableAmount), 0) AS TotalNonTaxable')]);
        
        $nonTableEarning = $nonTaxableData[0]->TotalNonTaxable;

        $earnings = [];
        $additionalearnings = [];
        $deductions = [];
        $staticDeduction = [];
        $overtimeColumns = [];
        $hasOvertime = false;
        $hasPension = false;

        foreach ($salaryTypes as $type) {
            $column = [
                'key' => 'salarytype_' . $type->id,
                'label' => $type->SalaryTypeName,
                'type' => $type->SalaryTypeName,
            ];

            if ($type->id == 5) {
                $hasOvertime = true;

                $overtimes = DB::table('overtimes')
                    ->where('Status', 'Active')
                    ->where('WorkhourRate','>', 0)
                    ->get();

                foreach ($overtimes as $ot) {
                    $overtimeColumns[] = [
                        'key' => 'overtime_' . $ot->id,
                        'label' => $ot->OvertimeLevelName.'</br>('.$ot->WorkhourRate .'%)',
                        'parent' => 'Overtime'
                    ];
                }

                // Add Total Overtime column
                $overtimeColumns[] = [
                    'key' => 'total_overtime',
                    'label' => 'Total',
                    'parent' => 'Overtime'
                ];
            } else if ($type->id == 3) {
                $hasPension = true;

                $deductions[] = [
                    'key' => 'pension_4',
                    'label' => $settings->CompPensionPercent."%",
                    'parent' => 'Pension'
                ];
                $deductions[] = [
                    'key' => 'pension_3',
                    'label' => $settings->PensionPercent."%",
                    'parent' => 'Pension'
                ];
                
            } else if ($type->SalaryType == 'Earnings') {
                $earnings[] = $column;
                
            } else if ($type->SalaryType == 'Deductions') {
                $deductions[] = $column;
            }
        }

        if($otherEarningFlag > 0){
            $additionalearnings[] = ['key' => 'OE1', 'label' => 'Other Earning'];
        }
        if($nonTableEarning > 0){
            $additionalearnings[] = ['key' => 'NT1', 'label' => 'Non-Taxable Earning'];
        }
        $additionalearnings[] = ['key' => 'TO1', 'label' => 'Total Earning'];

        $additionalearnings[] = ['key' => 'TA1', 'label' => 'Taxable Earning'];

        if($otherDeductionFlag > 0){
            $deductions[] = ['key' => 'other_deduction_0', 'label' => 'Other Deduction'];
        }
        $deductions[] = ['key' => 'total_deduction_ab', 'label' => 'Total Deduction'];

        return response()->json([
            'firstStaticColumns' => ['#','Employee Name</br>(ID)','Branch','Department','Position', 'Working Day</br> (30 days)','Per hour Salary','Late + Early Minute'],
            'earnings' => $earnings,
            'additionalearnings' => $additionalearnings,
            'overtimes' => $overtimeColumns,
            'deductions' => $deductions,
            'staticDeduction' => $staticDeduction,
            'hasOvertime' => $hasOvertime,
            'hasPension' => $hasPension,
            'lastStaticColumns' => ['Net Pay'],
        ]);
    }

    public function getEmployeeSalaryList(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $day_in_month = 30;
        $net_present_day = 0;
        $detailData = [];
        $taxableEarning = 0;
        $nonTaxableEarning = 0;
        $totalDeduction = 0;
        $payrollEarnings = 0;
        $payrollDeduction = 0;
        $basicSalary = 0;
        $actual_salary = 0;
        $totalOt = 0;
        $empidlist = $_POST['emplist']; 
        $month = $_POST['month'];
        $daysInMonth = Carbon::parse($month . '-01')->daysInMonth;
        $salarytypeot = salarytype::where('id',5)->first();

        $settings = DB::table('settings')->latest()->first();
        $companyPension = 0;
        $pension = 0;
        $workminute = $settings->WorkingMinute;
        $workhour = 0;
        $absent_day = 0;
        $late_early = 0;
        $working_day = 0;
        $employees = employee::whereIn('employees.id',$empidlist)
        ->leftJoin('salaries','employees.salaries_id','salaries.id')
        ->leftJoin('branches','employees.branches_id','=','branches.id')
        ->leftJoin('departments','employees.departments_id','departments.id')
        ->leftJoin('positions','employees.positions_id','positions.id')
        ->where('employees.Status',"Active")
        ->orderBy('employees.name','ASC')
        ->get(['employees.id','employees.name','employees.EmployeeID','employees.salaries_id','branches.BranchName','departments.DepartmentName','positions.PositionName','employees.monthly_work_hour','employees.PensionPercent','employees.CompanyPensionPercent',
            DB::raw('(SELECT COUNT(employees_id) FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status NOT IN(1,9,12,13,15)) AS PresentDay'),
            DB::raw('(SELECT COUNT(employees_id) FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(1)) AS AbsentDay'),
            DB::raw('(SELECT COUNT(employees_id) FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(12,13,15) AND attendance_summaries.OffShiftStatus = 1) AS OffShiftDay'),
            //DB::raw('(SELECT COALESCE(SUM(attendance_summaries.WorkingTimeAmount), 0)/60 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.is_unpaid_leave = 1 AND attendance_summaries.is_leave_half_day = 0) AS FullDayLeave'),
            //DB::raw('(SELECT COALESCE(SUM(attendance_summaries.WorkingTimeAmount), 0)/60 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.is_unpaid_leave = 1 AND attendance_summaries.is_leave_half_day = 1) AS HalfDayLeave'),

            DB::raw('(SELECT COALESCE(SUM(timetables.WorkTime), 0)/60 FROM shiftschedule_timetables LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id = shiftschedules.id LEFT JOIN timetables ON shiftschedule_timetables.timetables_id = timetables.id WHERE shiftschedules.employees_id = employees.id AND DATE_FORMAT(shiftschedule_timetables.Date,"%Y-%m")="'.$month.'" AND shiftschedule_timetables.have_priority=1 AND shiftschedule_timetables.isworkday IN(1,3)) WorkHour'),
            DB::raw('(SELECT COUNT(shiftschedule_timetables.id) FROM shiftschedule_timetables LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id = shiftschedules.id LEFT JOIN timetables ON shiftschedule_timetables.timetables_id = timetables.id WHERE shiftschedules.employees_id = employees.id AND DATE_FORMAT(shiftschedule_timetables.Date,"%Y-%m")="'.$month.'" AND shiftschedule_timetables.have_priority=1 AND shiftschedule_timetables.isworkday=1) WorkingDay'),
            DB::raw('(SELECT COALESCE(SUM(timetables.WorkTime), 0)/60 FROM shiftschedule_timetables LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id = shiftschedules.id LEFT JOIN timetables ON shiftschedule_timetables.timetables_id = timetables.id WHERE shiftschedules.employees_id = employees.id AND DATE_FORMAT(shiftschedule_timetables.Date,"%Y-%m")="'.$month.'" AND shiftschedule_timetables.have_priority=1 AND shiftschedule_timetables.isworkday=1 AND shiftschedule_timetables.Date IN(SELECT attendance_summaries.Date FROM attendance_summaries WHERE attendance_summaries.Status=1)) AbsentHour'),
            DB::raw('(SELECT COALESCE(SUM(attendance_summaries.WorkingTimeAmount), 0)/60 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(2,3,4,5,6,7,8,14)) AS ActualWorkHour'),
            DB::raw('(SELECT COALESCE(SUM(timetables.WorkTime), 0)/60 FROM shiftschedule_timetables LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id = shiftschedules.id LEFT JOIN timetables ON shiftschedule_timetables.timetables_id = timetables.id WHERE shiftschedules.employees_id = employees.id AND DATE_FORMAT(shiftschedule_timetables.Date,"%Y-%m")="'.$month.'" AND shiftschedule_timetables.have_priority=1 AND shiftschedule_timetables.isworkday IN(3)) HolidayWorkHour'),

            DB::raw('(SELECT COALESCE(SUM(timetables.WorkTime), 0)/60 FROM shiftschedule_timetables LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id = shiftschedules.id LEFT JOIN timetables ON shiftschedule_timetables.timetables_id = timetables.id WHERE shiftschedules.employees_id = employees.id AND shiftschedule_timetables.Date IN(SELECT attendance_summaries.Date FROM attendance_summaries WHERE attendance_summaries.Status IN(11) AND attendance_summaries.is_unpaid_leave = 0 AND attendance_summaries.is_leave_half_day = 0 AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'") AND shiftschedule_timetables.have_priority=1) FullLeaveWorkHour'),
            DB::raw('(SELECT COALESCE(SUM(timetables.WorkTime), 0)/60 FROM shiftschedule_timetables LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id = shiftschedules.id LEFT JOIN timetables ON shiftschedule_timetables.timetables_id = timetables.id WHERE shiftschedules.employees_id = employees.id AND shiftschedule_timetables.Date IN(SELECT attendance_summaries.Date FROM attendance_summaries WHERE attendance_summaries.Status IN(11) AND attendance_summaries.is_unpaid_leave = 0 AND attendance_summaries.is_leave_half_day = 1 AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'") AND shiftschedule_timetables.have_priority=1) HalfLeaveWorkHour'),

            DB::raw('(SELECT COUNT(employees_id) FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(1)) AS AbsentDay'),
            DB::raw('(SELECT COUNT(employees_id) FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(8)) AS IncompletePunchCount'),
            DB::raw('(SELECT COALESCE(SUM(attendance_summaries.WorkingTimeAmount), 0)/60 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(8)) AS IncompletePunchHr'),

            DB::raw('(SELECT COUNT(employees_id) FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(11) AND attendance_summaries.is_unpaid_leave = 1 AND attendance_summaries.is_leave_half_day = 0) AS FullDayLeave'),
            DB::raw('(SELECT COUNT(employees_id) FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(11) AND attendance_summaries.is_unpaid_leave = 1 AND attendance_summaries.is_leave_half_day = 1) AS HalfDayLeave'),
            DB::raw('(SELECT COALESCE(SUM(attendance_summaries.LateCheckInTimeAmount), 0)/1 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status NOT IN(1)) AS LateCheckIn'),
            DB::raw('(SELECT COALESCE(SUM(attendance_summaries.EarlyCheckOutTimeAmount), 0)/1 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status NOT IN(1)) AS EarlyCheckOut')
        ]);

        $salaryDetails = DB::table('salarydetails')->get(); // Load all salary details once

        // Group salary details by salaries_id
        $detailsBySalaryId = $salaryDetails->groupBy('salaries_id');

        $result = $employees->map(function ($employee) use (
            $detailsBySalaryId,$daysInMonth,$taxableEarning,$nonTaxableEarning,$totalDeduction,
            $payrollEarnings,$payrollDeduction,$month,$basicSalary,$totalOt,$salarytypeot,
            $companyPension,$pension,$workhour,$actual_salary,$absent_day,$late_early,$day_in_month,
            $net_present_day,$working_day
            ) {
            $details = $detailsBySalaryId[$employee->salaries_id] ?? collect();

            $workhour = $employee->monthly_work_hour;
            $absent_day = $employee->AbsentDay + $employee->FullDayLeave + ($employee->HalfDayLeave / 2);
            $suppose_to_workhr = $employee->WorkHour > $workhour ? 0 : $employee->WorkHour;
            $work_hr_variance = round(($workhour - $suppose_to_workhr),2);
            $pension = $employee->PensionPercent;
            $companyPension = $employee->CompanyPensionPercent;
            $attendance_hr = round(($employee->ActualWorkHour + $employee->HolidayWorkHour  + $employee->FullLeaveWorkHour  + ($employee->HalfLeaveWorkHour/2)),2);
            $actual_work_hour = round(($attendance_hr + $work_hr_variance),2);
            //---calc incomplete
            $total_incomplete = round(($employee->IncompletePunchCount * 8),2);
            $missed_hour = round(($total_incomplete - ($employee->IncompletePunchHr ?? 0)),2);
            $missed_minute = round(($missed_hour * 60),2);
            $late_early = round(($employee->LateCheckIn + $employee->EarlyCheckOut + $missed_minute),2);
            $net_present_day = round(($day_in_month - $absent_day),2);
            $working_day = round(($employee->WorkingDay - $absent_day),2);
            $salaryMap = [];
            $addAndOther = [];
            $otData = [];
            $deductionData = [];
            $staticDeduction = [];
            $netPayData = [];
            $perhrsalary = 0;
            $payrollEarnings = 0;
            $payrollDeduction = 0;
            $deductionData[0] = 0;
            $deductionData['6'] = 0;

            foreach ($details as $d) {
                $salarytypeprop = salarytype::where('id',$d->salarytypes_id)->first();
                if($salarytypeprop->show_on_payroll == 1){
                    
                    if($d->salarytypes_id == 1){
                        //$actual_salary = round(($actual_work_hour * $perhrsalary),2);
                        $actual_salary = round((($d->Amount * $net_present_day) / $day_in_month),2);
                        $perhrsalary = $workhour > 0 ? round(($actual_salary / $workhour),2) : 0;
                        $basicSalary =  $d->Amount;
                        $salaryMap[$d->salarytypes_id] = $actual_salary;
                    }
                    else{
                        $salaryMap[$d->salarytypes_id] = $d->Amount;
                    }
                }
                

                if($salarytypeprop->SalaryType == "Deductions"){
                    if($d->salarytypes_id != 2 && $d->salarytypes_id != 3 && $d->salarytypes_id != 4 && $d->salarytypes_id != 6 && $d->salarytypes_id != 7){
                        $deductionData[$d->salarytypes_id] = $d->Amount;
                        $totalDeduction += $d->Amount;
                        if($salarytypeprop->show_on_payroll == 0){
                            if (isset($deductionData[0])) {
                                $deductionData[0] += $d->Amount ?? 0;
                            } 
                            else {
                                $deductionData[0] = $d->Amount ?? 0;
                            }
                        }
                    }
                }
            }

            $getAdditionOrDeduction=DB::select('SELECT payrolladdetails.salarytypes_id,payrolladdetails.Amount,payrolladditions.type FROM payrolladdetails LEFT JOIN payrolladditions ON payrolladdetails.payrolladditions_id=payrolladditions.id WHERE payrolladdetails.employees_id='.$employee->id.' AND payrolladditions.Status="Approved" AND "'.$month.'" BETWEEN payrolladditions.PayRangeFrom AND payrolladditions.PayRangeTo');
            foreach($getAdditionOrDeduction as $pad){
                $salarytypeprop = salarytype::where('id',$pad->salarytypes_id)->first();
                if($salarytypeprop->show_on_payroll == 1){
                    if($pad->type == 1){
                        $payrollEarnings += $pad->Amount ?? 0;
                        if (isset($salaryMap[$pad->salarytypes_id])) {
                            $salaryMap[$pad->salarytypes_id] += $pad->Amount ?? 0;
                        } 
                        else {
                            $salaryMap[$pad->salarytypes_id] = $pad->Amount ?? 0;
                        }
                    }
                    if($pad->type == 2){
                        $payrollDeduction += $pad->Amount ?? 0;
                        $totalDeduction += $pad->Amount;
                        if (isset($deductionData[$pad->salarytypes_id])) {
                            $deductionData[$pad->salarytypes_id] += $pad->Amount ?? 0;
                        } 
                        else {
                            $deductionData[$pad->salarytypes_id] = $pad->Amount ?? 0;
                        }
                    }
                }

                if($salarytypeprop->show_on_payroll == 0){
                    if($pad->type == 1){
                        $payrollEarnings += $pad->Amount ?? 0;
                        if (isset($addAndOther[$employee->id.'OE1'])) {
                            $addAndOther[$employee->id.'OE1'] += $pad->Amount ?? 0;
                        } 
                        else {
                            $addAndOther[$employee->id.'OE1'] = $pad->Amount ?? 0;
                        }
                    }
                    if($pad->type == 2){
                        $payrollDeduction += $pad->Amount ?? 0;
                        $totalDeduction += $pad->Amount;
                        if (isset($deductionData[0])) {
                            $deductionData[0] += $pad->Amount ?? 0;
                        } 
                        else {
                            $deductionData[0] = $pad->Amount ?? 0;
                        }
                    }
                }
            }
            
            $getOvertimeData=DB::select('SELECT attendance_overtimes.overtime_id,attendance_overtimes.Rate,COALESCE(SUM(attendance_overtimes.OtDurationMin), 0)/60 AS TotalOT FROM attendance_overtimes LEFT JOIN overtimes ON attendance_overtimes.overtime_id=overtimes.id WHERE attendance_overtimes.employees_id='.$employee->id.' AND DATE_FORMAT(attendance_overtimes.Date,"%Y-%m")="'.$month.'" GROUP BY attendance_overtimes.overtime_id');
            foreach ($getOvertimeData as $ot) {
                $perhoursalary = $workhour > 0 ? round(($actual_salary / $workhour),2) : 0;
                $overtime = $ot->TotalOT * $perhoursalary * $ot->Rate;
                $otData[$ot->overtime_id] = $overtime;
                
                $totalOt += $overtime;
            }

            if($salarytypeot->show_on_payroll == 1){
                $otData['total_overtime'] = $totalOt;
            }
            else{
                if (isset($addAndOther[$employee->id.'OE1'])) {
                    $addAndOther[$employee->id.'OE1'] += $totalOt;
                }
                else{ 
                    $addAndOther[$employee->id.'OE1'] = $totalOt;
                }
            }

            foreach ($details as $e) {
                if($e->Type == 1)
                {
                    if ($e->salarytypes_id == 1){
                        $taxableEarning += $actual_salary;
                    }
                    else{
                        $taxableEarning += $e->Amount;
                        $nonTaxableEarning += $e->NonTaxableAmount;
                    }
                    $salarytypeprop = salarytype::where('id',$e->salarytypes_id)->first();
                    if($salarytypeprop->show_on_payroll == 0){
                        if (isset($addAndOther[$employee->id.'OE1'])) {
                            $addAndOther[$employee->id.'OE1'] += $e->Amount ?? 0;
                        } 
                        else {
                            $addAndOther[$employee->id.'OE1'] = $e->Amount ?? 0;
                        }
                    }
                }
                // if($e->Type == 2 && $e->salarytypes_id != 2){}
            }

            $pensionamount = $basicSalary * ($pension / 100);
            $compensionamount = $basicSalary * ($companyPension / 100);

            $totalTaxableEarning = $taxableEarning + $payrollEarnings + $totalOt;

            $payrollsetting = DB::table('payrollsettings')
                ->where('MinAmount', '<=', $totalTaxableEarning)
                ->where(function($query) use ($totalTaxableEarning) {
                    $query->where('MaxAmount', '>=', $totalTaxableEarning)
                        ->orWhereNull('MaxAmount')
                        ->orWhere('MaxAmount','=',0);
                })
                ->first();

            $taxRate = round((($payrollsetting->TaxRate ?? 0) / 100),2);
            $deduction = $payrollsetting->Deduction ?? 0;

            $incomeTax = ($totalTaxableEarning * $taxRate) - $deduction;

            
            $lateabshr = $workhour - $employee->ActualWorkHour > 0 ? round(($workhour - $employee->ActualWorkHour),2) : 0;
            //$lateabshr = round(($employee->LateCheckIn + $employee->EarlyCheckOut + $employee->AbsentHour),2);
            $minute_salary = round(($perhrsalary / 60),2);
            $lateabspenalty = round(($late_early * $minute_salary),2);
            //$unpaidleave = round((($employee->FullDayLeave + $employee->HalfDayLeave) * $perhrsalary),2);
            $unpaidleave = 0;


            $salarytypenalty = salarytype::where('id',6)->first();
            if($salarytypenalty->show_on_payroll == 1){
                $deductionData['6'] += $lateabspenalty;
            }
            if($salarytypenalty->show_on_payroll == 0){
                $deductionData[0] += $lateabspenalty;
            }

            $totalDeductionFig = $incomeTax + $pensionamount + $lateabspenalty + $totalDeduction + $unpaidleave;

            $deductionData['2'] = $incomeTax;
            $deductionData['3'] = $pensionamount;
            $deductionData['4'] = $compensionamount;
            $deductionData['10'] = $unpaidleave;
            $deductionData['ab'] = $totalDeductionFig;

            $netPayResult = ($totalTaxableEarning - $totalDeductionFig) + $nonTaxableEarning;

            $addAndOther[$employee->id.'NT1'] = $nonTaxableEarning;
            $addAndOther[$employee->id.'TO1'] = $taxableEarning + $payrollEarnings + $totalOt + $nonTaxableEarning;
            $addAndOther[$employee->id.'TA1'] = $totalTaxableEarning;
           
            $addAndOther[$employee->id.'DN1'] = $totalDeduction;
            $netPayData[$employee->id.'NP1'] = $netPayResult;

            return [
                'id' => $employee->id,
                'name' => $employee->name,
                'EmployeeID' => $employee->EmployeeID,
                'BranchName' => $employee->BranchName,
                'DepartmentName' => $employee->DepartmentName,
                'PositionName' => $employee->PositionName,
                'PresentDay' => $employee->PresentDay,
                'OffShiftDay' => $employee->OffShiftDay,
                'WorkingDay' => $net_present_day,
                'WorkHour' => $workhour,
                'ActualWorkHour' => $actual_work_hour,
                'absent_hour' => $absent_day,
                'OffShiftHour' => round($employee->OffShiftHour,2),
                'daysInMonth' => $daysInMonth,
                'perHourSalary' => $perhrsalary,
                'lateabsenthr' => $late_early,
                'salaries' => $salaryMap,
                'otData' => $otData,
                'addsalaries' => $addAndOther,
                'deductionData' => $deductionData,
                'staticDeduction' => $staticDeduction,
                'netPayData' => $netPayData,
                'lateabsentpenalty' => $lateabspenalty,
                'unpaidleave' => $unpaidleave
            ];
        });

        return response()->json($result);
    }

    public function getEmployeeSalaryListInfo(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $detailData = [];
        $taxableEarning = 0;
        $nonTaxableEarning = 0;
        $totalDeduction = 0;
        $payrollEarnings = 0;
        $payrollDeduction = 0;
        $basicSalary = 0;
        $totalOt = 0;

        $recId = $_POST['recId'];
        $payroll = payroll::where('payrolls.id', $recId)->first();
        $month = $payroll->PayRangeFrom;
        $daysInMonth = Carbon::parse($month . '-01')->daysInMonth;
        $salarytypeot = salarytype::where('id',5)->first();

        $settings = DB::table('settings')->latest()->first();
        $companyPension = $settings->CompPensionPercent;
        $pension = $settings->PensionPercent;
        $workminute = $settings->WorkingMinute;
        $workhour = round(($settings->WorkingMinute / 60),2);

        $employees = payrolldetail::where('payrolldetails.payrolls_id',$recId)
            ->leftJoin('employees','payrolldetails.employees_id','employees.id')
            ->leftJoin('branches','employees.branches_id','=','branches.id')
            ->leftJoin('departments','employees.departments_id','departments.id')
            ->leftJoin('positions','employees.positions_id','positions.id')
            ->orderBy('employees.name','ASC')
            ->get(['employees.id','employees.name','employees.EmployeeID','employees.salaries_id',
                'branches.BranchName','departments.DepartmentName','positions.PositionName',
                'payrolldetails.working_day AS PresentDay',
                'payrolldetails.suppose_to_work_hr AS WorkHour',
                'payrolldetails.actual_work_hr AS ActualWorkHour',
                'payrolldetails.*','employees.id AS employee_id'
            ]);

        $salaryDetails = DB::table('payrollsalaries')->get(); // Load all salary details once

        // Group salary details by salaries_id
        $detailsBySalaryId = $salaryDetails->groupBy(['employees_id','payrolls_id']);

        $result = $employees->map(function ($employee) use (
            $detailsBySalaryId,$daysInMonth,$taxableEarning,$nonTaxableEarning,$totalDeduction,
            $payrollEarnings,$payrollDeduction,$month,$basicSalary,$totalOt,$salarytypeot,
            $companyPension,$pension,$workhour,$recId
            ) {
            $details = $detailsBySalaryId[$employee->employees_id][$employee->payrolls_id] ?? collect();

            // Map salarytypes_id => amount
            $salaryMap = [];
            $addAndOther = [];
            $otData = [];
           
            $deductionData = [];
            $deductionData['OD1'] = 0;
            $staticDeduction = [];
            $netPayData = [];
            $payrollEarnings = 0;
            $payrollDeduction = 0;
            $pensionamount = 0;
            $compensionamount = 0;
            $incomeTax = 0;
            $lateabspenalty = 0;
            $unpaidleave = 0;
            $total_deduction = 0;
            $addAndOther['OE1'] = 0;
            $xy = [];
            
            $salarytypot = salarytype::where('id',5)->first();
            if($salarytypot->show_on_payroll == 1){
                $otData['total_overtime'] = 0;
                $overtimeprop = overtime::where('id','>',1)->get();
                foreach($overtimeprop as $otprop){
                    $otData[$otprop->id] = 0;
                }
            }

            foreach ($details as $d) {
                if($d->payrolls_id == $recId){
                    $salarytypeprop = salarytype::where('id',$d->salarytypes_id)->first();
                    if($salarytypeprop->SalaryType == "Earnings"){
                        if($salarytypeprop->show_on_payroll == 1){
                            
                            if($d->salarytypes_id == 1){
                                $basicSalary = $d->earning_amount;
                            }
                            if($d->salarytypes_id == 5){
                                $otData[$d->overtimes_id] = $d->earning_amount;
                                $otData['total_overtime'] += $d->earning_amount;
                            }
    
                            if($d->salarytypes_id != 5){
                                $salaryMap[$d->salarytypes_id] = $d->earning_amount;
                            }
                        }
                        if($salarytypeprop->show_on_payroll == 0){
                            if (isset($addAndOther['OE1'])) {
                                $addAndOther['OE1'] += $d->earning_amount ?? 0;
                            } 
                            else {
                                $addAndOther['OE1'] = $d->earning_amount ?? 0;
                            }
                        }
    
                        $taxableEarning += $d->earning_amount ?? 0;
                        $nonTaxableEarning += $d->non_taxable ?? 0;
                    }
    
                    if($salarytypeprop->SalaryType == "Deductions"){
                        
                        if($d->salarytypes_id != 2 && $d->salarytypes_id != 3 && $d->salarytypes_id != 4 && $d->salarytypes_id != 6 && $d->salarytypes_id != 7){
                            //$deductionData[$d->salarytypes_id] = $d->deduction_amount;
                            $totalDeduction += $d->deduction_amount;
                            if($salarytypeprop->show_on_payroll == 1){
                                if (isset($deductionData[$d->salarytypes_id])) {
                                    $deductionData[$d->salarytypes_id] += $d->deduction_amount ?? 0;
                                } 
                                else {
                                   $deductionData[$d->salarytypes_id] = $d->deduction_amount ?? 0;
                                }
                            }
    
                            if($salarytypeprop->show_on_payroll == 0){
                                if (isset($deductionData['OD1'])) {
                                    $deductionData['OD1'] += $d->deduction_amount ?? 0;
                                } 
                                else {
                                    $deductionData['OD1'] = $d->deduction_amount ?? 0;
                                }
                            }
                        }
    
                        if($d->salarytypes_id == 2){
                            $incomeTax = $d->deduction_amount ?? 0;
                        }
                        if($d->salarytypes_id == 3){
                            $pensionamount = $d->deduction_amount ?? 0;
                        }
                        
                        if($d->salarytypes_id == 6){
                            $lateabspenalty += $d->deduction_amount ?? 0;
                        }
                        if($d->salarytypes_id == 10){
                            $unpaidleave += $d->deduction_amount ?? 0;
                        }
    
                        $total_deduction += $d->deduction_amount ?? 0;
                    }
    
                    if($d->salarytypes_id == 4){
                        $compensionamount = $d->deduction_amount ?? 0;
                    }
                }
            }

            $deductionData['2'] = $incomeTax;
            $deductionData['3'] = $compensionamount;
            $deductionData['4'] = $pensionamount;

            $salarytypenalty = salarytype::where('id',6)->first();
            if($salarytypenalty->show_on_payroll == 1){
                $deductionData['6'] = $lateabspenalty;
            }
            if($salarytypenalty->show_on_payroll == 0){
                $deductionData['OD1'] = $lateabspenalty;
            }
            
            if($unpaidleave > 0){
               $deductionData['10'] = $unpaidleave;
            }
            $deductionData['ab'] = $total_deduction;

            $netPayResult = ($taxableEarning - $total_deduction) + $nonTaxableEarning;

            if($nonTaxableEarning <= 0){
                $addAndOther['NT1'] = 0;
            }

            if($nonTaxableEarning > 0){
                $addAndOther['NT1'] = $nonTaxableEarning;
            }
            $addAndOther['TO1'] = $taxableEarning + $nonTaxableEarning;
            $addAndOther['TA1'] = $taxableEarning;
            
            $netPayData['NP1'] = $netPayResult;

            return [
                'id' => $employee->id,
                'employee_id' => $employee->employee_id,
                'name' => $employee->name,
                'EmployeeID' => $employee->EmployeeID,
                'BranchName' => $employee->BranchName,
                'DepartmentName' => $employee->DepartmentName,
                'PositionName' => $employee->PositionName,
                'PresentDay' => $employee->PresentDay,
                'WorkHour' => $workhour,
                'ActualWorkHour' => round($employee->ActualWorkHour,2),
                'daysInMonth' => $daysInMonth,
                'absent_hour' => $employee->absent_day,
                'perHourSalary' => $employee->per_hr_salary,
                'lateabsenthr' => $employee->lateabsent_hr,
                'salaries' => $salaryMap,
                'otData' => $otData,
                'addsalaries' => $addAndOther,
                'deductionData' => $deductionData,
                'staticDeduction' => $staticDeduction,
                'netPayData' => $netPayData
            ];
        });

        return response()->json(['data' => $result]);
    }

    public function getOtDetailData(){
        $empid = $_POST['empid'];
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];
        $perhrsalary = $_POST['perhrsalary'];
        $startdate = Carbon::createFromFormat('F-d-Y',$fromdate)->format('Y-m-d');
        $enddate = Carbon::createFromFormat('F-d-Y',$todate)->format('Y-m-d');

        $payrollot=DB::select('SELECT overtimes.OvertimeLevelName,attendance_overtimes.Rate,"'.$perhrsalary.'" AS per_hour_salary,SUM(COALESCE(attendance_overtimes.OtDurationMin,0))/60 AS OTHour,((SUM(COALESCE(attendance_overtimes.OtDurationMin,0))/60) * attendance_overtimes.Rate * '.$perhrsalary.') AS Amount FROM attendance_overtimes LEFT JOIN overtimes ON attendance_overtimes.overtime_id=overtimes.id WHERE attendance_overtimes.employees_id='.$empid.' AND attendance_overtimes.Date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY attendance_overtimes.overtime_id');
        return Response::json(['payrollot'=>$payrollot]);
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
        $documentNumber=$settings->PayrollPrefix.sprintf("%06d",$settings->PayrollNumber);
        $companyPension = 0;
        $pension = 0;
        $workminute = $settings->WorkingMinute;
        $workhour = 0;
        $types=1;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->recId;
        $findid=$request->recId;
        $payrollid= $request->recId ?? 0;
        $fromMonthRange=$request->FromMonthRange;
        $createdAt=null;
        $detailData=[];
        $emplistId=[];

        $payrollemployeedata=[];
        $payrollsalarydata=[];
        $payrolltaxdata=[];
        $payrollpensiondata=[];
        $payrolltaxabledata=[];
        $employeeid = [];
        $payrolldetail = [];
        $payrollsalaries = [];
        $employeeids = [];
        $empcount = 0;

        $validator = Validator::make($request->all(), [
            'pemployee' => ['required'],
            'ToMonthRange' => ['required'],
            'FromMonthRange' => ['required'],
        ]);

        if($request->input('pemployee') != null && $fromMonthRange != null){
            $pmonth = Carbon::parse($fromMonthRange)->format('Y-m');
            foreach($request->input('pemployee') as $row){
                $payrollempdata=DB::select('SELECT COUNT(payrolldetails.id) AS EmpCount FROM payrolldetails LEFT JOIN payrolls ON payrolldetails.payrolls_id=payrolls.id WHERE payrolldetails.employees_id='.$row.' AND "'.$pmonth.'" BETWEEN payrolls.PayRangeFrom AND payrolls.PayRangeTo AND payrolldetails.payrolls_id!='.$payrollid.'');
                $empcount += $payrollempdata[0]->EmpCount;
                if($payrollempdata[0]->EmpCount > 0){
                    $emplistId[]=$row;
                }
            }
        }

        if ($validator->passes() && $empcount == 0){
            
            DB::beginTransaction();
            $month = Carbon::parse($request->startDateVal)->format('Y-m');
            try{
                $BasicVal = [
                    'type' => $types,
                    'PayRangeFrom' => $request->FromMonthRange,
                    'PayRangeTo' => $request->ToMonthRange,
                    'Remark' => $request->Remark,
                ];
                $DbData = payroll::where('id', $findid)->first();
                $CreatedBy = ['DocumentNumber' => $documentNumber,'Status' => "Draft"];
                $LastUpdatedBy = ['updated_at'=>Carbon::now()];
            
                $payrolldatas = payroll::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                foreach($request->input('pemployee') as $empid){
                    $employeeprop = employee::where('id',$empid)->first();
                    $salarydetail = DB::table('salarydetails')->where('salarydetails.salaries_id',$employeeprop->salaries_id)->get();
                    
                    $employeesattprop = employee::where('employees.id',$empid)
                    ->leftJoin('salaries','employees.salaries_id','salaries.id')
                    ->get(['employees.id','employees.name','employees.EmployeeID','employees.salaries_id','employees.monthly_work_hour','employees.PensionPercent','employees.CompanyPensionPercent',
                        DB::raw('(SELECT COUNT(employees_id) FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(2,3,11) AND attendance_summaries.is_unpaid_leave = 0) AS PresentDay'),
                        DB::raw('(SELECT COALESCE(SUM(attendance_summaries.WorkingTimeAmount), 0)/60 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.is_unpaid_leave = 1 AND attendance_summaries.is_leave_half_day = 0) AS FullDayLeave'),
                        DB::raw('(SELECT COALESCE(SUM(attendance_summaries.WorkingTimeAmount), 0)/60 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.is_unpaid_leave = 1 AND attendance_summaries.is_leave_half_day = 1) AS HalfDayLeave'),
                        DB::raw('(SELECT COALESCE(SUM(timetables.WorkTime), 0)/60 FROM shiftschedule_timetables LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id = shiftschedules.id LEFT JOIN timetables ON shiftschedule_timetables.timetables_id = timetables.id WHERE shiftschedules.employees_id = employees.id AND DATE_FORMAT(shiftschedule_timetables.Date,"%Y-%m")="'.$month.'" AND shiftschedule_timetables.have_priority=1 AND shiftschedule_timetables.isworkday=1) WorkHour'),
                        DB::raw('(SELECT COALESCE(SUM(timetables.WorkTime), 0)/60 FROM shiftschedule_timetables LEFT JOIN shiftschedules ON shiftschedule_timetables.shiftschedules_id = shiftschedules.id LEFT JOIN timetables ON shiftschedule_timetables.timetables_id = timetables.id WHERE shiftschedules.employees_id = employees.id AND DATE_FORMAT(shiftschedule_timetables.Date,"%Y-%m")="'.$month.'" AND shiftschedule_timetables.have_priority=1 AND shiftschedule_timetables.isworkday=1 AND shiftschedule_timetables.Date IN(SELECT attendance_summaries.Date FROM attendance_summaries WHERE attendance_summaries.Status=1)) AbsentHour'),
                        DB::raw('(SELECT COALESCE(SUM(attendance_summaries.WorkingTimeAmount), 0)/60 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(2,3)) AS ActualWorkHour'),
                        
                        DB::raw('(SELECT COUNT(employees_id) FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(11) AND attendance_summaries.is_unpaid_leave = 1 AND attendance_summaries.is_leave_half_day = 0) AS FullDayLeave'),
                        DB::raw('(SELECT COUNT(employees_id) FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status IN(11) AND attendance_summaries.is_unpaid_leave = 1 AND attendance_summaries.is_leave_half_day = 1) AS HalfDayLeave'),
                        
                        DB::raw('(SELECT COALESCE(SUM(attendance_summaries.LateCheckInTimeAmount), 0)/60 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status NOT IN(1)) AS LateCheckIn'),
                        DB::raw('(SELECT COALESCE(SUM(attendance_summaries.EarlyCheckOutTimeAmount), 0)/60 FROM attendance_summaries WHERE attendance_summaries.employees_id=employees.id AND DATE_FORMAT(attendance_summaries.Date,"%Y-%m")="'.$month.'" AND attendance_summaries.Status NOT IN(1)) AS EarlyCheckOut')
                    ]);

                    $fulldayleave = $employeesattprop[0]->FullDayLeave;
                    $halfdayleave = $employeesattprop[0]->HalfDayLeave;
                    $totalleave = $fulldayleave + $halfdayleave;
                    $workhour = $employeesattprop[0]->monthly_work_hour;
                    $pension = $employeesattprop[0]->PensionPercent;
                    $companyPension = $employeesattprop[0]->CompanyPensionPercent;

                    $taxable_earining = 0;
                    $nontaxable_earning = 0;
                    $total_earning = 0;
                    $total_deduction = 0;
                    $basicSalary = 0;
                    $actualsalary = 0;
                    foreach($salarydetail as $row){
                        $salarytypeprop = salarytype::where('id',$row->salarytypes_id)->first();
                        if($salarytypeprop->id == 1){
                            $actualsalary = (float) $request->input('emp_'.$empid.'_salarytype_1');
                            $basicSalary = $row->Amount;
                            $pensionamount = round(($basicSalary * ($pension / 100)),2);
                            $compensionamount = round(($basicSalary * ($companyPension / 100)),2);
                            
                            $payrollsalaries[]=[
                                "payrolls_id" => $payrolldatas->id,
                                "employees_id" => $empid,
                                "salarytypes_id" => $row->salarytypes_id,
                                "overtimes_id" => 0,
                                "earning_amount" => $actualsalary,
                                "non_taxable" => 0,
                                "deduction_amount" => 0,
                                "salarytype_src" => 0,
                                "payrolladditions_id" => 0,
                                "percent" => 0,
                                "tax_deduction" => 0,
                                "created_at" => Carbon::now(),
                                "updated_at" => Carbon::now()
                            ];

                            $payrollsalaries[]=[
                                "payrolls_id" => $payrolldatas->id,
                                "employees_id" => $empid,
                                "salarytypes_id" => 3,
                                "overtimes_id" => 0,
                                "earning_amount" => 0,
                                "non_taxable" => 0,
                                "deduction_amount" => $pensionamount,
                                "salarytype_src" => 0,
                                "payrolladditions_id" => 0,
                                "percent" => $pension,
                                "tax_deduction" => 0,
                                "created_at" => Carbon::now(),
                                "updated_at" => Carbon::now()
                            ];

                            $payrollsalaries[]=[
                                "payrolls_id" => $payrolldatas->id,
                                "employees_id" => $empid,
                                "salarytypes_id" => 4,
                                "overtimes_id" => 0,
                                "earning_amount" => 0,
                                "non_taxable" => 0,
                                "deduction_amount" => $compensionamount,
                                "salarytype_src" => 0,
                                "payrolladditions_id" => 0,
                                "percent" => $companyPension,
                                "tax_deduction" => 0,
                                "created_at" => Carbon::now(),
                                "updated_at" => Carbon::now()
                            ];

                            $taxable_earining += $actualsalary;
                            $total_earning += $actualsalary;
                            $total_deduction += $pensionamount;
                        }

                        if($salarytypeprop->id > 5){
                            if($salarytypeprop->SalaryType == "Earnings"){
                                $payrollsalaries[]=[
                                    "payrolls_id" => $payrolldatas->id,
                                    "employees_id" => $empid,
                                    "salarytypes_id" => $row->salarytypes_id,
                                    "overtimes_id" => 0,
                                    "earning_amount" => $row->Amount,
                                    "non_taxable" => $row->NonTaxableAmount,
                                    "deduction_amount" => 0,
                                    "salarytype_src" => 0,
                                    "payrolladditions_id" => 0,
                                    "percent" => 0,
                                    "tax_deduction" => 0,
                                    "created_at" => Carbon::now(),
                                    "updated_at" => Carbon::now()
                                ];
                                $taxable_earining += $row->Amount;
                                $nontaxable_earning += $row->NonTaxableAmount;
                                $total_earning += ($row->Amount + $row->NonTaxableAmount);
                            }

                            if($salarytypeprop->SalaryType == "Deductions"){
                                $payrollsalaries[]=[
                                    "payrolls_id" => $payrolldatas->id,
                                    "employees_id" => $empid,
                                    "salarytypes_id" => $row->salarytypes_id,
                                    "overtimes_id" => 0,
                                    "earning_amount" => 0,
                                    "non_taxable" => 0,
                                    "deduction_amount" => $row->Amount,
                                    "salarytype_src" => 0,
                                    "payrolladditions_id" => 0,
                                    "percent" => 0,
                                    "tax_deduction" => 0,
                                    "created_at" => Carbon::now(),
                                    "updated_at" => Carbon::now()
                                ];
                                $total_deduction += $row->Amount;
                            }
                        }
                    }

                    $getOvertimeData=DB::select('SELECT attendance_overtimes.overtime_id,attendance_overtimes.Rate,COALESCE(SUM(attendance_overtimes.OtDurationMin), 0)/60 AS TotalOT FROM attendance_overtimes LEFT JOIN overtimes ON attendance_overtimes.overtime_id=overtimes.id WHERE attendance_overtimes.employees_id='.$empid.' AND attendance_overtimes.Date BETWEEN "'.$request->startDateVal.'" AND "'.$request->endDateVal.'" GROUP BY attendance_overtimes.overtime_id');
                    foreach ($getOvertimeData as $ot) {

                        $perhoursalary = $workhour > 0 ? round(($actualsalary / $workhour),2) : 0;
                        $overtime = $ot->TotalOT * $perhoursalary * $ot->Rate;

                        $payrollsalaries[]=[
                            "payrolls_id" => $payrolldatas->id,
                            "employees_id" => $empid,
                            "salarytypes_id" => 5,
                            "overtimes_id" => $ot->overtime_id,
                            "earning_amount" => $overtime,
                            "non_taxable" => 0,
                            "deduction_amount" => $perhoursalary,
                            "salarytype_src" => $ot->TotalOT,
                            "payrolladditions_id" => 0,
                            "percent" => $ot->Rate,
                            "tax_deduction" => 0,
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ];
                        $taxable_earining += $overtime;
                        $total_earning += $overtime;
                    }

                    $getAdditionOrDeduction=DB::select('SELECT payrolladdetails.salarytypes_id,payrolladdetails.Amount,payrolladditions.type,payrolladditions.id AS payrolladd_deduct_id FROM payrolladdetails LEFT JOIN payrolladditions ON payrolladdetails.payrolladditions_id=payrolladditions.id WHERE payrolladdetails.employees_id='.$empid.' AND payrolladditions.Status="Approved" AND "'.$month.'" BETWEEN payrolladditions.PayRangeFrom AND payrolladditions.PayRangeTo');
                    foreach($getAdditionOrDeduction as $pad){
                        $salarytypeprop = salarytype::where('id',$pad->salarytypes_id)->first();
                        if($pad->type == 1){
                            $payrollsalaries[]=[
                                "payrolls_id" => $payrolldatas->id,
                                "employees_id" => $empid,
                                "salarytypes_id" => $pad->salarytypes_id,
                                "overtimes_id" => 0,
                                "earning_amount" => $pad->Amount ?? 0,
                                "non_taxable" => 0,
                                "deduction_amount" => 0,
                                "salarytype_src" => 1,
                                "payrolladditions_id" => $pad->payrolladd_deduct_id,
                                "percent" => 0,
                                "tax_deduction" => 0,
                                "created_at" => Carbon::now(),
                                "updated_at" => Carbon::now()
                            ];
                            $taxable_earining += $pad->Amount ?? 0;
                            $total_earning += $pad->Amount ?? 0;
                        }
                        if($pad->type == 2){
                            $payrollsalaries[]=[
                                "payrolls_id" => $payrolldatas->id,
                                "employees_id" => $empid,
                                "salarytypes_id" => $pad->salarytypes_id,
                                "overtimes_id" => 0,
                                "earning_amount" => 0,
                                "non_taxable" => 0,
                                "deduction_amount" => $pad->Amount ?? 0,
                                "salarytype_src" => 1,
                                "payrolladditions_id" => $pad->payrolladd_deduct_id,
                                "percent" => 0,
                                "tax_deduction" => 0,
                                "created_at" => Carbon::now(),
                                "updated_at" => Carbon::now()
                            ];
                            $total_deduction += $pad->Amount ?? 0;
                        }
                    }

                    $payrollsetting = DB::table('payrollsettings')
                        ->where('MinAmount', '<=', $taxable_earining)
                        ->where(function($query) use ($taxable_earining) {
                            $query->where('MaxAmount', '>=', $taxable_earining)
                                ->orWhereNull('MaxAmount')
                                ->orWhere('MaxAmount','=',0);
                        })
                        ->first();

                    $taxRate = round((($payrollsetting->TaxRate ?? 0) / 100),2);
                    $deduction = $payrollsetting->Deduction ?? 0;

                    $incomeTax = ($taxable_earining * $taxRate) - $deduction;
                    $total_deduction += $incomeTax;

                    $payrollsalaries[]=[
                        "payrolls_id" => $payrolldatas->id,
                        "employees_id" => $empid,
                        "salarytypes_id" => 2,
                        "overtimes_id" => 0,
                        "earning_amount" => 0,
                        "non_taxable" => 0,
                        "deduction_amount" => $incomeTax,
                        "salarytype_src" => 0,
                        "payrolladditions_id" => 0,
                        "percent" => $payrollsetting->TaxRate ?? 0,
                        "tax_deduction" => $payrollsetting->Deduction ?? 0,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now()
                    ];

                    $lateabsent = (float) $request->input('lateabs_emp_' . $empid);
                    $perhrsalary = $workhour > 0 ? round(($actualsalary / $workhour),2) : 0;
                    $minute_salary = round(($perhrsalary / 60),2);
                    $lateabspenalty = round(($lateabsent * $minute_salary),2);
                    $total_deduction += $lateabspenalty;

                    $payrollsalaries[]=[
                        "payrolls_id" => $payrolldatas->id,
                        "employees_id" => $empid,
                        "salarytypes_id" => 6,
                        "overtimes_id" => 0,
                        "earning_amount" => 0,
                        "non_taxable" => 0,
                        "deduction_amount" => $lateabspenalty,
                        "salarytype_src" => 0,
                        "payrolladditions_id" => 0,
                        "percent" => 0,
                        "tax_deduction" => 0,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now()
                    ];

                    // $unpaidleave = round(($totalleave * $perhrsalary),2);
                    // $total_deduction += $unpaidleave;

                    // $payrollsalaries[]=[
                    //     "payrolls_id" => $payrolldatas->id,
                    //     "employees_id" => $empid,
                    //     "salarytypes_id" => 10,
                    //     "overtimes_id" => 0,
                    //     "earning_amount" => 0,
                    //     "non_taxable" => 0,
                    //     "deduction_amount" => $unpaidleave,
                    //     "salarytype_src" => 0,
                    //     "payrolladditions_id" => 0,
                    //     "percent" => 0,
                    //     "tax_deduction" => 0,
                    //     "created_at" => Carbon::now(),
                    //     "updated_at" => Carbon::now()
                    // ];

                    $net_pay = round((($taxable_earining - $total_deduction) + $nontaxable_earning),2);
                    $payrolldetail[]=[
                        "payrolls_id" => $payrolldatas->id,
                        "employees_id" => $empid,
                        "working_day" => (float) $request->input('working_day_emp_' . $empid),
                        "suppose_to_work_hr" => (float) $request->input('supposetoworkhr_emp_' . $empid),
                        "actual_work_hr" => (float) $request->input('actualworkhr_emp_' . $empid),
                        "per_hr_salary" => (float) $request->input('perhrsalary_emp_' . $empid),
                        "basic_salary" => $basicSalary,
                        "lateabsent_hr" => (float) $request->input('lateabs_emp_' . $empid),
                        "actual_salary" => $actualsalary,
                        "absent_day" => (float) $request->input('absent_emp_' . $empid),
                        "total_earning" => $total_earning,
                        "non_taxable_earning" => $nontaxable_earning,
                        "taxable_earning" => $taxable_earining,
                        "total_deduction" => $total_deduction,
                        "net_pay" => $net_pay,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now()
                    ];
                    $employeeids[] = $empid;
                }

                payrollsalary::where('payrollsalaries.payrolls_id',$payrolldatas->id)->delete();
                payrolldetail::where('payrolldetails.payrolls_id',$payrolldatas->id)->delete();

                payrolldetail::insert($payrolldetail);
                payrollsalary::insert($payrollsalaries);
                
                if($findid==null){
                    $updn=DB::select('UPDATE settings SET PayrollNumber=PayrollNumber+1 WHERE id=1');
                }

                $action = $findid == null ? "Created" : "Edited";

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$payrolldatas->id,'pagename'=>"payroll",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                DB::commit();
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }

        if($empcount > 0)
        {
            $emplistId=implode(',', $emplistId);
            $emplists=DB::select('SELECT employees.name,employees.EmployeeID FROM employees WHERE employees.id IN('.$emplistId.')');
            return Response::json(['emperror'=>462,'emplists'=>$emplists]);
        }
        if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function showPayrollData($id){
        $countdata=0;
        $totalbasicsalary=0;
        $totalotherearning=0;
        $totalearnings=0;
        $totaltaxablearnings=0;
        $totalincometax=0;
        $totalpension=0;
        $totalcompension=0;
        $totalotherdeduction=0;
        $totaldeductions=0;
        $totalnetpay=0;

        $currentdatetimeAA = Carbon::createFromFormat('Y-m-d H:i:s',Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $companyinfo = DB::table('companyinfos')->latest()->first();
        $company_name = $companyinfo->Name;
        $recdata=payroll::findorFail($id);
        
        $firstDayOfMonth = Carbon::createFromFormat('Y-m',$recdata->PayRangeFrom)->firstOfMonth();
        $formattedFirstDay = $firstDayOfMonth->format('F-d-Y');

        $endDayOfMonth = Carbon::createFromFormat('Y-m',$recdata->PayRangeTo)->endOfMonth();
        $formattedEndDay = $endDayOfMonth->format('F-d-Y');
        $carbon = Carbon::createFromFormat('Y-m', $recdata->PayRangeFrom);
        $formatted_month = $carbon->format('F-Y'); 

        $data = payroll::where('payrolls.id', $id)
        ->get(['payrolls.*',
            DB::raw('(SELECT GROUP_CONCAT(DISTINCT " ",branches.BranchName) FROM payrolldetails LEFT JOIN employees ON payrolldetails.employees_id=employees.id LEFT JOIN branches ON employees.branches_id=branches.id WHERE payrolldetails.payrolls_id=payrolls.id) AS Branch'),
            DB::raw('CASE WHEN payrolls.type=1 THEN "Regular" WHEN payrolls.type=2 THEN "Others" END AS PType'),
            DB::raw('CONCAT(DATE_FORMAT(CONCAT(payrolls.PayRangeFrom,"-01"),"%Y-%M")," to ",DATE_FORMAT(CONCAT(payrolls.PayRangeTo,"-01"),"%Y-%M")) AS PayRange'),
            DB::raw("'$formattedFirstDay' AS FirstDayofMonth"),DB::raw("'$formattedEndDay' AS LastDayofMonth")
        ]);

        $empdata = payrolldetail::join('employees','payrolldetails.employees_id','employees.id')
        ->where('payrolldetails.payrolls_id', $id)
        ->get(['payrolldetails.*','employees.name AS EmployeeName','employees.EmployeeID']);

        $activitydata=actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"payroll")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['payrolldata'=>$data,'empdata'=>$empdata,'activitydata'=>$activitydata,'company_name'=>$company_name,'formatted_month'=>$formatted_month,'currentdatetimeAA'=>$currentdatetimeAA]);       
    }

    public function payrollForwardAction(Request $request)
    {
        DB::beginTransaction();
        try{
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;

            $findid=$request->forwardReqId;
            $proll=payroll::find($findid);
            $currentStatus = $proll->Status;
            $newStatus=$request->newForwardStatusValue;
            $action=$request->forwardActionValue;
            $month = $proll->PayRangeFrom;
            $proll->Status=$newStatus;
            $proll->save();

            if($newStatus == "Approved"){
                $payrolldata=DB::select('SELECT payrolldetails.employees_id FROM payrolldetails WHERE payrolldetails.payrolls_id='.$findid);
                foreach($payrolldata as $row){
                    attendance_summary::whereIn('attendance_summaries.employees_id',$row->employees_id)
                    ->where(DB::raw('DATE_FORMAT(attendance_summaries.Date,"%Y-%m")'),$month)
                    ->update(['IsPayrollMade' => 1]);

                    attendance_overtime::whereIn('attendance_overtimes.employees_id',$row->employees_id)
                    ->where(DB::raw('DATE_FORMAT(attendance_overtimes.Date,"%Y-%m")'),$month)
                    ->update(['IsPayrollClosed' => 1]);
                }
            }

            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"payroll",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            
            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function payrollBackwardAction(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backwardReqId;
        $action=$request->backwardActionValue;
        $newStatus=$request->newBackwardStatusValue;
        $proll=payroll::find($findid);
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();

            try{
                $proll->Status=$newStatus;
                $proll->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"payroll",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->CommentOrReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
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

    public function voidPayroll(Request $request)
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
            try{
                $payrolldatas = payroll::where('id', $findid)->first();
                $oldstatus=$payrolldatas->Status;

                $pdata=payroll::find($findid);
                $pdata->Status="Void(".$oldstatus.")";
                $pdata->OldStatus=$oldstatus;
                $pdata->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"payroll",'action'=>"Void",'status'=>"Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Reason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

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

    public function undovoidPayroll(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->undovoidid;
        $payrolldatas = payroll::where('id', $findid)->first();
        $status=$payrolldatas->OldStatus;

        DB::beginTransaction();
        try{
            $pdata=payroll::find($findid);
            $pdata->Status=$status;
            $pdata->OldStatus=$status;
            $pdata->save();

            DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"payroll",'action'=>"Undo Void",'status'=>"Undo Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            
            DB::commit();
            return Response::json(['success' => '1']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function rejectPayroll(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->rejectId;
        $payrolldatas = payroll::where('id', $findid)->first();
        $oldstatus=$payrolldatas->Status;

        try{
            $pdata=payroll::find($findid);
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

    public function showEmployeePayroll($id)
    {
        $employeepayrolldata=DB::select('SELECT payrollemployees.*,employees.EmployeeID,employees.name,CONCAT(employees.MobileNumber," , ",employees.phone) AS EmployeePhone FROM payrollemployees INNER JOIN employees ON payrollemployees.employees_id=employees.id WHERE payrollemployees.payrolls_id='.$id.' ORDER BY employees.name ASC');
        return datatables()->of($employeepayrolldata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function payrollDetail(Request $request){
        $companyinfo = DB::table('companyinfos')->latest()->first();
        $settings = DB::table('settings')->latest()->first();
        $workhour = 0;
        $companyPension = 0;
        $pension = 0;
        $company_name = $companyinfo->Name;
        $empid=$_POST['employeeid']; 
        $frompaymonth=$_POST['frompaymonth']; 
        $topaymonth=$_POST['topaymonth']; 
        $recId=$_POST['recId']; 
        $carbon = Carbon::createFromFormat('Y-m', $frompaymonth);
        $daysInMonth = $carbon->daysInMonth;
        $formatted_month = $carbon->format('F-Y'); 
        $payrolldata=[];
        $payrollotdata=[];
        $payrolltaxdata=[];
        $payrollpensiondata=[];
        $payrolltaxabledata=[];
        $basicSalary = 0;
        $totalOt = 0;
        $salarydetdata = "";
        $payrolladditionded = "";
        $payrollsalarydata = "";
        $perhoursalary = "";
        $working_days = 0;
        $amount_in_word = 0;
        $basic_salary = 0;

        $data = employee::leftJoin('branches','employees.branches_id','=','branches.id')
        ->leftJoin('departments','employees.departments_id','=','departments.id')
        ->leftJoin('positions','employees.positions_id','=','positions.id')
        ->leftJoin('employees AS emp','employees.employees_id','=','emp.id')
        ->leftJoin('banks','employees.banks_id','=','banks.id')
        ->where('employees.id',$empid)
        ->orderBy('employees.name','ASC')
        ->get(['employees.*','branches.BranchName','departments.DepartmentName','positions.PositionName','employees.id AS EmpId','banks.BankName','employees.monthly_work_hour']);
        
        $companyPension = $data[0]->CompanyPensionPercent;
        $pension = $data[0]->PensionPercent;

        if($recId == null){
            $salarydetdata = salarydetail::leftJoin('salarytypes','salarydetails.salarytypes_id','salarytypes.id')
            ->where('salarydetails.salaries_id',$data[0]->salaries_id)
            ->orderBy('salarytypes.SalaryType','DESC')
            ->orderBy('salarydetails.id','ASC')
            ->orderBy('salarydetails.Type','DESC')
            ->get(['salarydetails.*','salarydetails.NonTaxableAmount AS NonTaxable','salarytypes.SalaryTypeName','salarytypes.SalaryType','salarytypes.NonTaxableAmount',
                DB::raw('IFNULL(salarytypes.Description,"") AS Descriptions'),
                DB::raw('IFNULL(salarydetails.Remark,"") AS Remark')
            ]);

            foreach($salarydetdata as $sdetail){
                if($sdetail->salarytypes_id == 1){
                    $basicSalary = $sdetail->Amount;
                }
            }

            $workhour = $data[0]->monthly_work_hour;

            $payrolladditionded=DB::select('SELECT payrolladditions.id,payrolladdetails.salarytypes_id,salarytypes.SalaryTypeName,payrolladdetails.Amount,payrolladditions.type,payrolladditions.DocumentNumber FROM payrolladdetails LEFT JOIN payrolladditions ON payrolladdetails.payrolladditions_id=payrolladditions.id LEFT JOIN salarytypes ON payrolladdetails.salarytypes_id=salarytypes.id WHERE payrolladdetails.employees_id='.$empid.' AND payrolladditions.Status="Approved" AND "'.$topaymonth.'" BETWEEN payrolladditions.PayRangeFrom AND payrolladditions.PayRangeTo');
        
            $getOvertimeData=DB::select('SELECT attendance_overtimes.overtime_id,attendance_overtimes.Rate,COALESCE(SUM(attendance_overtimes.OtDurationMin), 0)/60 AS TotalOT FROM attendance_overtimes LEFT JOIN overtimes ON attendance_overtimes.overtime_id=overtimes.id WHERE attendance_overtimes.employees_id='.$empid.' AND DATE_FORMAT(attendance_overtimes.Date,"%Y-%m")="'.$topaymonth.'" GROUP BY attendance_overtimes.overtime_id');
            foreach ($getOvertimeData as $ot) {
                $perhoursalary = $workhour > 0 ? round(($basicSalary / $workhour),2) : 0;
                $overtime = $ot->TotalOT * $perhoursalary * $ot->Rate;
                
                $totalOt += $overtime;
            }
        }

        if($recId != null){
            $querySumType5 = DB::table('payrollsalaries')
                ->leftJoin('salarytypes', 'payrollsalaries.salarytypes_id', '=', 'salarytypes.id')
                ->leftJoin('payrolladditions', 'payrollsalaries.payrolladditions_id', '=', 'payrolladditions.id')
                ->where('payrollsalaries.employees_id', $empid)
                ->where('payrollsalaries.payrolls_id', $recId)
                ->where('payrollsalaries.salarytypes_id', 5)
                ->select(
                    'payrollsalaries.*',
                    DB::raw('SUM(payrollsalaries.earning_amount) as earning_amount'),
                    'payrollsalaries.id as payrollsalaries_id',
                    'salarytypes.SalaryTypeName',
                    'payrolladditions.DocumentNumber'
                )
                ->groupBy('payrollsalaries.salarytypes_id', 'salarytypes.SalaryTypeName');

            $queryOtherTypes = DB::table('payrollsalaries')
                ->leftJoin('salarytypes', 'payrollsalaries.salarytypes_id', '=', 'salarytypes.id')
                ->leftJoin('payrolladditions', 'payrollsalaries.payrolladditions_id', '=', 'payrolladditions.id')
                ->where('payrollsalaries.employees_id', $empid)
                ->where('payrollsalaries.payrolls_id', $recId)
                ->where('payrollsalaries.salarytypes_id', '!=', 5)
                ->select(
                    'payrollsalaries.*',
                    'payrollsalaries.earning_amount',
                    'payrollsalaries.id as payrollsalaries_id',
                    'salarytypes.SalaryTypeName',
                    'payrolladditions.DocumentNumber'
                );
            
            $payrollsalarydata = $queryOtherTypes
                ->unionAll($querySumType5)
                ->orderBy('salarytypes_id', 'ASC')
                ->get();
       
            $payrolldetail = payrolldetail::join('employees','payrolldetails.employees_id','employees.id')
                ->where('payrolldetails.employees_id',$empid)
                ->where('payrolldetails.payrolls_id', $recId)
                ->get(['payrolldetails.per_hr_salary','payrolldetails.working_day','payrolldetails.net_pay','payrolldetails.basic_salary']);
            
            $perhoursalary = $payrolldetail[0]->per_hr_salary;
            $working_days = $payrolldetail[0]->working_day;
            $basic_salary = $payrolldetail[0]->basic_salary;
            $amount_in_word = $this->toCurrencyWords($payrolldetail[0]->net_pay);
        }

        return response()->json(['empdata'=>$data,'payrollsalarydata'=>$payrollsalarydata,'salarydetdata'=>$salarydetdata,'payrolladditionded'=>$payrolladditionded,
                                'otamount'=>$totalOt,'companyPension'=>$companyPension,'pension'=>$pension,'perhoursalary'=>$perhoursalary,'working_days'=>$working_days,
                                'basic_salary'=>$basic_salary,'daysInMonth'=>$daysInMonth,'formatted_month'=>$formatted_month,'company_name'=>$company_name,'amount_in_word'=>$amount_in_word
                            ]);
    }

    public function numberToWords($number)
    {
        $units = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        $teens = [10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
                15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen'];
        $tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
        $thousands = ['', 'thousand', 'million', 'billion'];

        if (!is_numeric($number)) return 'Invalid number';

        $number = (int)$number;

        if ($number === 0) return 'zero';

        $number = str_pad($number, ceil(strlen($number) / 3) * 3, '0', STR_PAD_LEFT);
        $groups = str_split($number, 3);

        $words = [];

        foreach ($groups as $i => $group) {
            $group = (int)$group;
            if ($group === 0) continue;

            $hundreds = intdiv($group, 100);
            $remainder = $group % 100;

            $groupWords = [];

            if ($hundreds > 0) {
                $groupWords[] = $units[$hundreds] . ' hundred';
            }

            if ($remainder >= 10 && $remainder <= 19) {
                $groupWords[] = $teens[$remainder];
            } else {
                $tensPlace = intdiv($remainder, 10);
                $unitsPlace = $remainder % 10;

                if ($tensPlace > 0) {
                    $groupWords[] = $tens[$tensPlace];
                }

                if ($unitsPlace > 0) {
                    $groupWords[] = $units[$unitsPlace];
                }
            }

            $power = count($groups) - $i - 1;
            if ($power > 0) {
                $groupWords[] = $thousands[$power];
            }

            $words[] = implode(' ', $groupWords);
        }

        return implode(' ', $words);
    }

    public function toCurrencyWords($amount)
    {
        $amount = number_format($amount, 2, '.', '');
        list($birr, $cents) = explode('.', $amount);

        $birrWords = $this->numberToWords((int)$birr);
        $centWords = $this->numberToWords((int)$cents);

        $birrText = $birrWords ? ucfirst($birrWords) . ' birr' : '';
        $centText = ((int)$cents > 0) ? " and $centWords cents" : '';

        return $birrText . $centText;
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

    public function calcPayroll(Request $request)
    {
        $fromMonthRange=$request->FromMonthRange;
        $toMonthRange=$request->ToMonthRange;
        $payrolldata=[];
        $totalpayrolldata=[];
        $date = Carbon::createFromDate(Carbon::parse($fromMonthRange)->format('Y'),Carbon::parse($fromMonthRange)->format('m'), 1);
        $numDays = $date->daysInMonth;
        $employees=[];
        $presentedemp=[];
        foreach($request->input('employees') as $row){
            $employees[]=$row;
        }
        $employeesimp=implode(',', $employees);

        $attdata = attendance::join('employees','attendances.employees_id','=','employees.id')
        ->join('branches','employees.branches_id','=','branches.id')
        ->join('departments','employees.departments_id','=','departments.id')
        ->join('positions','employees.positions_id','=','positions.id')
        ->join('employees AS emp','employees.employees_id','=','emp.id')
        ->whereIn('employees.id',$employees)
        ->where(DB::raw('DATE_FORMAT(attendances.Date,"%Y-%m")'),'>=',$fromMonthRange)
        ->where(DB::raw('DATE_FORMAT(attendances.Date,"%Y-%m")'),'<=',$toMonthRange)
        ->get(['employees.*','branches.BranchName','departments.DepartmentName','positions.PositionName','employees.id AS EmpId',
            DB::raw('CONCAT((SELECT COUNT(attendances.TimeOpt) FROM attendances WHERE attendances.employees_id=employees.id)," of ",'.$numDays.') AS WorkDay')
        ]);

        foreach($attdata as $attrow){
            $presentedemp[]=$attrow->employees_id;
        }

        $absentemp = array_diff($employees, $presentedemp);

        $data = employee::join('branches','employees.branches_id','=','branches.id')
        ->join('departments','employees.departments_id','=','departments.id')
        ->join('positions','employees.positions_id','=','positions.id')
        ->join('employees AS emp','employees.employees_id','=','emp.id')
        ->whereIn('employees.id',$absentemp)
        ->orderBy('employees.name','ASC')
        ->get(['employees.*','branches.BranchName','departments.DepartmentName','positions.PositionName','employees.id AS EmpId',
            DB::raw('CONCAT("0 of ",'.$numDays.') AS WorkDay')
        ]);

        $combinedResults = $attdata->union($data);

        $aggrbasicsalary=0;
        $aggrotherearning=0;
        $aggrgrossincome=0;
        $aggrtaxableincome=0;
        $aggrincometax=0;
        $aggrpension=0;
        $aggrcompension=0;
        $aggrotherdeduction=0;
        $aggrtotaldeduction=0;
        $aggrnetpay=0;

        $payrollcalctype=1;
        
        $employeedata=DB::select('SELECT employees.id,employees.name,employees.salaries_id,employees.WorkingMinute,employees.PensionPercent,employees.AllowancePercent FROM employees WHERE employees.Status="Active" AND employees.id IN('.$employeesimp.')');
        foreach($employeedata as $row){
            $workminute=$row->WorkingMinute;
            $allownancePercentage=round(($row->AllowancePercent/100),2);
            $pensionPercent=round(($row->PensionPercent/100),2);
            $comPernsion=11;
            $comPensionPercent=round(($comPernsion/100),2);
            $minimumAllowance=2200;
            $basicSalary=0;
            $allowance=0;
            $taxallowance=0;
            $grossSalary=0;
            $taxableEarning=0;
            $dailySalary=0;
            $hourlySalary=0;
            $totalotamount=0;
            $payrolltaxrate=0;
            $deductionamount=0;
            $pensionAmount=0;
            $payrolltax=0;
            $totaldeduction=0;
            $netpay=0;
            $totalearlyminute=0;
            $totallateminute=0;
            $totalotherearning=0;
            $otherdeduction=0;
            $otherearning=0;
            $netpay=0;
            $totalearlyminute=0;
            $totallateminute=0;
            $totalotherearning=0;
            $payrollpercent=0;
            $otherearnings=0;
            $additionalearnings=0;
            $bonusamountdata=0;

            if($row->salaries_id==1){
                $employeesalary=DB::select('SELECT * FROM hr_employee_salaries WHERE hr_employee_salaries.Status="Active" AND  hr_employee_salaries.employees_id='.$row->id);
                foreach($employeesalary as $emprow){
                    if($emprow->salarytypes_id==1){
                        $basicSalary=$emprow->EarningAmount ?? 0;
                    }
                    else if($emprow->salarytypes_id==6){
                        $allowance+=$emprow->EarningAmount ?? 0;
                    }
                    else{
                        $otherearnings+=$emprow->EarningAmount ?? 0;
                    }
                }
            }
            else if($row->salaries_id!=1){
                $salarydetail=DB::select('SELECT * FROM salarydetails WHERE salarydetails.Status="Active" AND salarydetails.salaries_id='.$row->salaries_id);
                foreach($salarydetail as $emprow){
                    if($emprow->salarytypes_id==1){
                        $basicSalary=$emprow->EarningAmount ?? 0;
                    }
                    else if($emprow->salarytypes_id==6){
                        $allowance+=$emprow->EarningAmount ?? 0;
                    }
                    else{
                        $otherearnings+=$emprow->EarningAmount ?? 0;
                    }
                }
            }

            $payrolladditionsdata=DB::select('SELECT salarytypes.SalaryTypeName,FORMAT(payrolladdetails.Amount,2) AS Amount,payrolladdetails.Amount AS NonFormatAmount FROM payrolladdetails INNER JOIN payrolladditions ON payrolladdetails.payrolladditions_id=payrolladditions.id INNER JOIN salarytypes ON payrolladdetails.salarytypes_id=salarytypes.id WHERE payrolladdetails.employees_id='.$row->id.' AND payrolladditions.Status="Approved" AND "'.$fromMonthRange.'" BETWEEN payrolladditions.PayRangeFrom AND payrolladditions.PayRangeTo AND payrolladditions.type=1');
            foreach($payrolladditionsdata as $addearow){
                $additionalearnings+=$addearow->NonFormatAmount ?? 0;
            }

            $attendanceot=DB::select('SELECT * FROM attendance_overtimes WHERE attendance_overtimes.IsPayrollClosed=0 AND attendance_overtimes.Type=2 AND attendance_overtimes.employees_id='.$row->id);
            foreach($attendanceot as $otrow){
                $hours = round(($otrow->OtDurationMin/60),2); 
                $hourlySalary=round(($basicSalary/$workminute),2);
                $totalotamount+= (($otrow->Rate * $hourlySalary)*$hours);
            }
            if(round(($basicSalary*$allownancePercentage),2) >= $allowance){
                if($allowance >= $minimumAllowance){ 
                    $taxallowance= $allowance-$minimumAllowance;
                }
                else if($allowance < $minimumAllowance){
                    $taxallowance=0;
                }
            }
            else if(round(($basicSalary*$allownancePercentage),2) < $allowance){
                if(round(($basicSalary*$allownancePercentage),2) < $minimumAllowance){
                    $taxallowance= round(($allowance-($basicSalary*$allownancePercentage)),2);
                }
                else if(round(($basicSalary*$allownancePercentage),2) >= $minimumAllowance){
                    $taxallowance= round(($allowance-$minimumAllowance),2);
                }
            }
            $payrolldeductions=DB::select('SELECT salarytypes.SalaryTypeName,payrolladdetails.Amount FROM payrolladdetails INNER JOIN payrolladditions ON payrolladdetails.payrolladditions_id=payrolladditions.id INNER JOIN salarytypes ON payrolladdetails.salarytypes_id=salarytypes.id WHERE payrolladdetails.employees_id='.$row->id.' AND payrolladditions.Status="Approved" AND "'.$fromMonthRange.'" BETWEEN payrolladditions.PayRangeFrom AND payrolladditions.PayRangeTo AND payrolladditions.type=2');
            foreach($payrolldeductions as $paydedrow){
                $otherdeduction+=$paydedrow->Amount ?? 0;
            }

            if($payrollcalctype==1){
                // to calculate regular payroll
                $taxableEarning=round(($basicSalary+$taxallowance+$totalotamount+$otherearnings+$additionalearnings)?? 0,2);
                $grossSalary=round(($basicSalary+$allowance+$totalotamount+$otherearnings+$additionalearnings),2);
            
                $payrolltable=DB::select('SELECT TaxRate,Deduction FROM payrollsettings WHERE "'.$taxableEarning.'" BETWEEN payrollsettings.MinAmount AND IF(payrollsettings.MaxAmount=0,100000000000,payrollsettings.MaxAmount)');
                foreach($payrolltable as $payrow){
                    $payrolltaxrate=round(($payrow->TaxRate/100) ?? 0,2);
                    $deductionamount=$payrow->Deduction ?? 0;
                    $payrollpercent=$payrow->TaxRate ?? 0;
                }

                $lateandealydata=DB::select('SELECT EarlyMinute,LateMinute FROM attendances WHERE attendances.IsPayrollMade=0 AND attendances.timetables_id!=1 AND attendances.TimeOpt=2 AND attendances.employees_id='.$row->id);
                foreach($lateandealydata as $laterow){
                    $totalearlyminute+=$laterow->EarlyMinute ?? 0;
                    $totallateminute+=$laterow->LateMinute ?? 0;
                }

                $payrolltax=round((($taxableEarning*$payrolltaxrate)-$deductionamount),2);
                $pensionAmount=round(($basicSalary*$pensionPercent),2);
                $comPensionAmount=round(($basicSalary*$comPensionPercent),2);
                $totaldeduction=round(($payrolltax+$pensionAmount+$otherdeduction),2);
                $netpay=round(($grossSalary-$totaldeduction),2);
                $totalotherearning=$allowance+$totalotamount+$otherearnings+$additionalearnings;

                if((int)$payrollpercent==0){
                    $taxableEarning=0;
                }
            }

            else if($payrollcalctype==2){
                // to calculate bonus
                $payrollbonusdata=DB::select('SELECT salarytypes.SalaryTypeName,FORMAT(payrolladdetails.Amount,2) AS Amount,payrolladdetails.Amount AS NonFormatAmount FROM payrolladdetails INNER JOIN payrolladditions ON payrolladdetails.payrolladditions_id=payrolladditions.id INNER JOIN salarytypes ON payrolladdetails.salarytypes_id=salarytypes.id WHERE payrolladdetails.employees_id='.$row->id.' AND payrolladdetails.salarytypes_id=8 AND payrolladditions.Status="Approved" AND "'.$fromMonthRange.'" BETWEEN payrolladditions.PayRangeFrom AND payrolladditions.PayRangeTo AND payrolladditions.type=1');
                foreach($payrollbonusdata as $paybonus){
                    $bonusamountdata=$paybonus->NonFormatAmount ?? 0;
                }
                $bonuspermonth=round(($bonusamountdata/12),2);
                $taxableEarning=round(($basicSalary+$bonuspermonth)?? 0,2);
                $grossSalary=round(($basicSalary+$bonusamountdata)?? 0,2);

                $payrolltable=DB::select('SELECT TaxRate,Deduction FROM payrollsettings WHERE "'.$taxableEarning.'" BETWEEN payrollsettings.MinAmount AND IF(payrollsettings.MaxAmount=0,100000000000,payrollsettings.MaxAmount)');
                foreach($payrolltable as $payrow){
                    $bonustaxrate=round(($payrow->TaxRate/100) ?? 0,2);
                    $bonusdeductionrate=$payrow->Deduction ?? 0;
                    $bonustaxpercent=$payrow->TaxRate ?? 0;
                }

                $payrollbasictable=DB::select('SELECT TaxRate,Deduction FROM payrollsettings WHERE "'.$basicSalary.'" BETWEEN payrollsettings.MinAmount AND IF(payrollsettings.MaxAmount=0,100000000000,payrollsettings.MaxAmount)');
                foreach($payrollbasictable as $payrow){
                    $basebonustaxrate=round(($payrow->TaxRate/100) ?? 0,2);
                    $basebonusdeductionrate=$payrow->Deduction ?? 0;
                    $basebonustaxpercent=$payrow->TaxRate ?? 0;
                }

                $bonustax=round((($taxableEarning*$bonustaxrate)-$bonusdeductionrate),2);
                $basebonustax=round((($basicSalary*$basebonustaxrate)-$basebonusdeductionrate),2);

                $payrolltax=round((($bonustax-$basebonustax)*12),2);
                $pensionAmount=0;
                $comPensionAmount=0;
                $totaldeduction=0;
                $netpay=round(($bonusamountdata-$payrolltax),2);
                $totalotherearning=$bonusamountdata;
            }

            $payrolldata[]=["EmployeeIdVal"=>$row->id,"BasicSalary"=>number_format($basicSalary,2),"OtherEarning"=>number_format($totalotherearning,2),"GrossIncome"=>number_format($grossSalary,2),"TaxableIncome"=>number_format($taxableEarning,2),"IncomeTax"=>number_format($payrolltax,2),"Pension"=>number_format($pensionAmount,2),"CompPension"=>number_format($comPensionAmount,2),"OtherDeduction"=>number_format($otherdeduction,2),"TotalDeduction"=>number_format($totaldeduction,2),"NetPay"=>number_format($netpay,2)];
            
            $aggrbasicsalary+=$basicSalary;
            $aggrotherearning+=$totalotherearning;
            $aggrgrossincome+=$grossSalary;
            $aggrtaxableincome+=$taxableEarning;
            $aggrincometax+=$payrolltax;
            $aggrpension+=$pensionAmount;
            $aggrcompension+=$comPensionAmount;
            $aggrotherdeduction+=$otherdeduction;
            $aggrtotaldeduction+=$totaldeduction;
            $aggrnetpay+=$netpay;
        }
        
        $totalpayrolldata[]=["AggBasicSalary"=>number_format($aggrbasicsalary,2),"AggOtherEarning"=>number_format($aggrotherearning,2),"AggGrossIncome"=>number_format($aggrgrossincome,2),"AggTaxableIncome"=>number_format($aggrtaxableincome,2),"AggIncomeTax"=>number_format($aggrincometax,2),"AggPension"=>number_format($aggrpension,2),"AggComPension"=>number_format($aggrcompension,2),"AggOtherDeduction"=>number_format($aggrotherdeduction,2),"AggTotalDeduction"=>number_format($aggrtotaldeduction,2),"AggNetPay"=>number_format($aggrnetpay,2)];

        return response()->json(['payrollcalc'=>$combinedResults,'payrolldata'=>$payrolldata,'totalpayrolldata'=>$totalpayrolldata]);
    }

    public function getPayrollFromMonthRange(Request $request)
    {
        $fromMonRange=$_POST['fromMonRange']; 
        $firstDayOfMonth = Carbon::createFromFormat('Y-m',$fromMonRange)->firstOfMonth();
        $formattedFirstDay = $firstDayOfMonth->format('F-d-Y');
        $endDayOfMonth = Carbon::createFromFormat('Y-m',$fromMonRange)->endOfMonth();
        $formattedEndDay = $endDayOfMonth->format('F-d-Y');
        $formattedEndDayPartialA = $endDayOfMonth->format('Y-F');
        $formattedEndDayPartialB = $endDayOfMonth->format('Y-m');

        $startDate = $firstDayOfMonth->format('Y-m-d');
        $endDate = $endDayOfMonth->format('Y-m-d');

        return response()->json(['fday'=>$formattedFirstDay,'eday'=>$formattedEndDay,'startDate'=>$startDate,'endDate'=>$endDate,'edayname'=>$formattedEndDayPartialA,'edayvalue'=>$formattedEndDayPartialB]);
    }

    public function getPayrollToMonthRange(Request $request)
    {
        $toMonRange=$_POST['toMonRange']; 
        $endDayOfMonth = Carbon::createFromFormat('Y-m',$toMonRange)->endOfMonth();
        $formattedEndDay = $endDayOfMonth->format('F-d-Y');
        return response()->json(['eday'=>$formattedEndDay]);
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
