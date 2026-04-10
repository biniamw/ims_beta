<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\salary;
use App\Models\employee;
use App\Models\salarydetail;
use App\Models\actions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $earningsalary=DB::select('SELECT * FROM salarytypes WHERE salarytypes.SalaryType="Earnings" AND salarytypes.Status="Active"');
        $deductionsalary=DB::select('SELECT * FROM salarytypes WHERE salarytypes.SalaryType="Deductions" AND salarytypes.Status="Active"');
        if($request->ajax()) {
            return view('hr.setup.salary',['earningsalary'=>$earningsalary,'deductionsalary'=>$deductionsalary])->renderSections()['content'];
        }
        else{
            return view('hr.setup.salary',['earningsalary'=>$earningsalary,'deductionsalary'=>$deductionsalary]);
        }
    }

    public function salarylistcon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $salarylist=DB::select('SELECT * FROM salaries WHERE id>1 AND IsFixed=1 ORDER BY id DESC');
        if(request()->ajax()) {
            return datatables()->of($salarylist)
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
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->recId;
        $findid=$request->recId;
        $curdate=Carbon::today()->toDateString();
        $totalearning=0;
        $totaldeduction=0;
        $netsalary=0;
        $netsalaryerrorflag=0;
        $companypension = 4;

        $validator = Validator::make($request->all(), [
            'SalaryName' => ['required','string', 'max:255',Rule::unique('salaries')->ignore($findid)],
            'status' => 'required|string',
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

        // foreach ($request->row as $key => $value){
        //     $totalearning+=(float)$value['EarningAmount'];
        //     $totaldeduction+=(float)$value['DeductionAmount'];
        // }
        // $netsalary=(float)$totalearning-(float)$totaldeduction;

        // if($netsalary<=0){
        //     $netsalaryerrorflag=1;
        // }

        $v2= Validator::make($request->all(), $earrules);

        $v3= Validator::make($request->all(), $dedrules);

        if ($validator->passes() && $v2->passes() && $v3->passes()){

            DB::beginTransaction();
            try{
                $BasicVal = [
                    'SalaryName' => $request->SalaryName,
                    'TotalEarnings' => $request->summtotalearningInp,
                    'TaxableEarning' => $request->summtaxableearningInp,
                    'NonTaxableEarning' => $request->summnontaxableearningInp,
                    'TotalDeductions' => $request->summtotaldeductionInp,
                    'NetSalary' => $request->summnetpayInp,
                    'CompanyPension' => $request->summcompanypensionInp,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                    'IsFixed' => 1,
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
                        'NonTaxableAmount'=> $value['NonTaxable'],
                        'TotalAmount'=> $value['TotalEarning'],
                        'TaxPercent'=> 0,
                        'Deduction'=> 0,
                        'Type'=> 1,
                        'Remark'=>$value['Remark'],
                    ];
                }

                foreach ($request->drow as $key => $dvalue){
                    $salarytypedata[(int)$dvalue['SalaryTypeDed']] = 
                    [ 
                        'Amount' => $dvalue['DedAmount'],
                        'NonTaxableAmount'=> 0,
                        'TotalAmount'=> $dvalue['DedAmount'],
                        'TaxPercent'=> $dvalue['TaxPercent'],
                        'Deduction'=> $dvalue['Deduction'],
                        'Type'=> 2,
                        'Remark'=>$dvalue['Remark'],
                    ];
                }

                $salarytypedata[$companypension] = 
                [ 
                    'Amount' => $request->summcompanypensionInp,
                    'NonTaxableAmount'=> 0,
                    'TotalAmount'=> $request->summcompanypensionInp,
                    'TaxPercent'=> 0,
                    'Deduction'=> 0,
                    'Type'=> 3,
                    'Remark'=> "",
                ];

                $salary->salarytype()->sync($salarytypedata);

                // employee::where('salaries_id',$findid)->update(['BasicSalary'=>$request->BasicSalary,'NetSalary'=>$request->NetSalary,
                // 'MedicalAllowance'=>$request->MedicalAllowance,'HomeRentAllowance'=>$request->HomeRentAllowance,'TransportAllowance'=>$request->TransportAllowance,
                // 'Bonus'=>$request->Bonus,'OtherEarning'=>$request->OtherEarning,'Tax'=>$request->Tax,'ProvidentFund'=>$request->ProvidentFund,'OtherDeduction'=>$request->OtherDeduction]);

                $actions = $findid == null ? "Created" : "Edited";
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $salary->id,
                    'pagename' => "salary",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'rec_id' => $salary->id]);
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

    public function showsalarycon($id){

        $data = salary::where('salaries.id', $id)->get(['salaries.*']);
        
        $salarydetdata = salarydetail::join('salarytypes','salarydetails.salarytypes_id','salarytypes.id')
        ->where('salarydetails.salaries_id',$id)->orderBy('salarytypes.SalaryType','DESC')
        ->orderBy('salarydetails.id','ASC')
        ->orderBy('salarydetails.Type','DESC')
        ->get(['salarydetails.*','salarydetails.NonTaxableAmount AS NonTaxable','salarytypes.SalaryTypeName','salarytypes.SalaryType','salarytypes.NonTaxableAmount',
                DB::raw('IFNULL(salarytypes.Description,"") AS Descriptions'),
                DB::raw('IFNULL(salarydetails.Remark,"") AS Remark')
            ]);
        
        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"salary")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['salarylist'=>$data,'salarydetdata'=>$salarydetdata,'activitydata'=>$activitydata]);       
    }


    public function deletesalary(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->delRecId;
        DB::beginTransaction();
        try{
            DB::table('salarydetails')->where('salaries_id',$findid)->delete();
            DB::table('salaries')->where('id',$findid)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "salary",
                'action' => "delete",
                'status' => "delete",
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

    public function salarytypelistcon(){
        $salarylists=DB::select('SELECT *,IFNULL(salarytypes.Description,"") AS Descriptions FROM salarytypes WHERE salarytypes.Status="Active" ORDER BY salarytypes.SalaryType DESC,salarytypes.id ASC');
        return response()->json(['salarylists'=>$salarylists]);
    }

    public function showSalaryDetails($id)
    {
        $typeflag = $_POST['typeflag']; 
        $detailTable=DB::select('SELECT salarydetails.*,salarytypes.SalaryTypeName,salarytypes.SalaryType,IFNULL(salarytypes.Description,"") AS Descriptions,IFNULL(salarydetails.Remark,"") AS Remarks FROM salarydetails LEFT JOIN salarytypes on salarydetails.salarytypes_id = salarytypes.id WHERE salarydetails.salaries_id='.$id.' AND salarydetails.Type = '.$typeflag.' ORDER BY salarytypes.SalaryType DESC,salarytypes.id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn() 
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getTaxRange(Request $request){
        $taxrangelist=DB::select('SELECT * FROM payrollsettings ORDER BY payrollsettings.id ASC');
        return response()->json(['taxrangelist'=>$taxrangelist]);
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
