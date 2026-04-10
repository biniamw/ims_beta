<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\paymentterm;
use App\Models\actions;
use Response;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Exception;

class PaymenttermController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            return view('registry.paymentterm')->renderSections()['content'];
        }
        else{
            return view('registry.paymentterm');
        }
    }

    public function paymenttermList()
    {
        $paymentterm = DB::select('SELECT * FROM paymentterms ORDER BY paymentterms.id DESC');
        if(request()->ajax()) {
            return datatables()->of($paymentterm)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function store(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->paymenttermId;
        $validator = Validator::make($request->all(), [
            'PaymentTerm' => ['required',Rule::unique('paymentterms','PaymentTermName')->where(function ($query){
                })->ignore($findid)
            ],
            'PaymentTermSize' => ['required'],
            'Description' => ['nullable'],
            'status' => ['required'],
        ]);

        if ($validator->passes()){
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'PaymentTermName' => $request->PaymentTerm,
                    'PaymentTermAmount' => $request->PaymentTermSize,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = paymentterm::where('id', $findid)->first();

                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $paymentterm = paymentterm::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $paymentterm->id,
                    'pagename' => "payment-term",
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
        else if($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function showpaymentterm($id){
        $paymenttermcnt = 0;
        $data = paymentterm::where('paymentterms.id', $id)->get();
        $checkgroupcnt = DB::select('SELECT COUNT(servicedetails.paymentterms_id) AS ServiceCount FROM servicedetails WHERE servicedetails.paymentterms_id='.$id);   
        $paymenttermcnt = $checkgroupcnt[0]->ServiceCount ?? 0;

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"payment-term")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);
        
        return response()->json(['paymenttermlist' => $data,'paymenttermcnt' => $paymenttermcnt,'activitydata' => $activitydata]);
    }

    public function deletepayment(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->paymentTermInfoId;
        $paymenttermcnt = 0;
        $checkgroupcnt = DB::select('SELECT COUNT(servicedetails.paymentterms_id) AS ServiceCount FROM servicedetails WHERE servicedetails.paymentterms_id='.$findid);   
        $paymenttermcnt = $checkgroupcnt[0]->ServiceCount ?? 0;
        DB::beginTransaction();
        try{
            if($paymenttermcnt > 0){
                return Response::json(['errors' => 465]);
            }
            else if($paymenttermcnt == 0){
                DB::table('paymentterms')->where('id',$findid)->delete();

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "payment-term",
                    'action' => "Delete",
                    'status' => "Delete",
                    'reason' => "",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1]);
            }
        }
        catch(Exception $e){
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }
}
