<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use App\Models\bank;
use App\Models\bankdetail;
use App\Models\actions;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        if($request->ajax()) {
            return view('registry.bank')->renderSections()['content'];
        }
        else{
            return view('registry.bank');
        }
    }

    public function banklistcon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $banklist=DB::select('SELECT * FROM banks ORDER BY id DESC');
        if(request()->ajax()) {
            return datatables()->of($banklist)
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
    
    public function store(Request $request){
        $detflag = 0;
        $v2 = null;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $headerid = $request->bankId;
        $findid = $request->bankId;
        $curdate = Carbon::today()->toDateString();
        $accnumbers = [];
        $allaccnum = [];

        if($findid != null){
            $banklists=bankdetail::where('banks_id', $request->bankId)->get(['AccountNumber']);
            foreach ($banklists as $row) {
                $accnumbers[] = $row->AccountNumber;
            }
        }

        $validator = Validator::make($request->all(), [
            'BankName' => ['required',Rule::unique('banks')->where(function ($query){
                })->ignore($findid)
            ],
            'Description' => ['nullable'],
            'status' => ['required'],
        ]);

        $rules = array(
            'row.*.AccountNumber' => 'required',
            'row.*.OpeningBalance' => 'required',
            'row.*.Status' => 'required',
        );
        $v2 = Validator::make($request->all(), $rules);

        if($validator->passes() && $v2->passes() && $request->row != null){
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'BankName' => $request->BankName,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = bank::where('id', $findid)->first();

                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $bankdata = bank::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                foreach ($request->row as $key => $value){
                    $commdata = 0;
                    $accnum = $value['AccountNumber'];
                    $openbl = $value['OpeningBalance'];
                    $contnum = $value['ContactNumber'];
                    $branch = $value['Branch'];
                    $description = $value['Description'];
                    $status = $value['Status'];
                    if(in_array($accnum,$accnumbers)){
                        DB::table('bankdetails')->where('banks_id',$bankdata->id)
                        ->where('AccountNumber',$accnum)
                        ->update(['OpeningBalance' => $openbl,
                            'ContactNumber' => $contnum,
                            'Branch' => $branch,
                            'description' => $description,
                            'Status' => $status
                        ]);
                    }
                    if(!in_array($accnum,$accnumbers)){
                        $bankdet = new bankdetail;
                        $bankdet->banks_id = $bankdata->id;
                        $bankdet->AccountNumber = $accnum;
                        $bankdet->OpeningBalance = $openbl;
                        $bankdet->ContactNumber = $contnum;
                        $bankdet->Branch = $branch;
                        $bankdet->description = $description;
                        $bankdet->Status = $status;
                        $bankdet->save();
                    }
                    $allaccnum[]=$accnum;
                }
                DB::table('bankdetails')->where('banks_id',$bankdata->id)->whereNotIn('AccountNumber',$allaccnum)->delete();
                
                $actions = $findid == null ? "Created" : "Edited";
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $bankdata->id,
                    'pagename' => "bank",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1, 'rec_id' => $bankdata->id]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }

        else if($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
        else if($v2->fails()){
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
        else if($request->row == null){
            return response()->json(['emptyerror'=>"error"]);
        }
    }

    public function getAccountNumber(Request $request){
        $accnt=0;
        $bankid=$_POST['bankidval']; 
        $accnum=$_POST['accnumber']; 
        if($bankid==0){
            $getaccnumber=DB::select('SELECT COUNT(bankdetails.AccountNumber) AS AccountCount FROM bankdetails WHERE bankdetails.AccountNumber='.$accnum.'');
            foreach($getaccnumber as $row)
            {
                $accnt=$row->AccountCount;
            }
        }
        else if($bankid>0){
            $getaccnumber=DB::select('SELECT COUNT(bankdetails.AccountNumber) AS AccountCount FROM bankdetails WHERE bankdetails.AccountNumber='.$accnum.' AND bankdetails.banks_id!='.$bankid.'');
            foreach($getaccnumber as $row)
            {
                $accnt=$row->AccountCount;
            }
        } 
        return response()->json(['accnumcnt'=>$accnt]);       
    }

    public function getContactNumber(Request $request){
        $contn=0;
        $bankid=$_POST['bankidval']; 
        $contnum=$_POST['contactnum']; 
        if($bankid==0){
            $getaccnumber=DB::select('SELECT COUNT(bankdetails.ContactNumber) AS ContactNumCount FROM bankdetails WHERE bankdetails.ContactNumber='.$contnum.'');
            foreach($getaccnumber as $row)
            {
                $contn=$row->ContactNumCount;
            }
        }
        else if($bankid>0){
            $getaccnumber=DB::select('SELECT COUNT(bankdetails.ContactNumber) AS ContactNumCount FROM bankdetails WHERE bankdetails.ContactNumber='.$contnum.' AND bankdetails.banks_id!='.$bankid.'');
            foreach($getaccnumber as $row)
            {
                $contn=$row->ContactNumCount;
            }
        } 
        return response()->json(['contn'=>$contn]);       
    }

    public function showbankCon($id){
        $bank_cnt = 0;
        $data = bank::where('banks.id', $id)->get(['banks.*']);

        $detdata = bankdetail::where('bankdetails.banks_id',$id)->get(['bankdetails.*',
            DB::raw('(SELECT COUNT(incomeclosingbanks.id) FROM incomeclosingbanks WHERE incomeclosingbanks.bankdetails_id=bankdetails.id) AS income_cnt'),
            DB::raw('(SELECT COUNT(settlementdetails.id) FROM settlementdetails WHERE settlementdetails.bankdetails_id=bankdetails.id) AS settlement_cnt')
        ]);
        $employee_data = DB::select('SELECT COUNT(banks_id) AS bank_cnt FROM employees WHERE employees.banks_id='.$id);   
        $bank_cnt = ($detdata[0]->income_cnt ?? 0) + ($detdata[0]->settlement_cnt ?? 0) + ($employee_data[0]->bank_cnt ?? 0);

        $activitydata = actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"bank")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['banklist' => $data,'detdata' => $detdata,'bank_cnt' => $bank_cnt,'activitydata' => $activitydata]);       
    }

    public function deleteBank(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->bankdelId;
        DB::beginTransaction();
        try{
            DB::table('bankdetails')->where('bankdetails.banks_id',$findid)->delete();
            DB::table('banks')->where('id',$findid)->delete();
            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "bank",
                'action' => "Delete",
                'status' => "Delete",
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

    public function banklistinfoCon($id)
    {
        $detailTable=DB::select('SELECT * FROM bankdetails WHERE bankdetails.banks_id='.$id.' ORDER BY bankdetails.id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->make(true);
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
