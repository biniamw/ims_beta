<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\hr_leavetype;
use App\Models\actions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return view('hr.setup.leavetype')->renderSections()['content'];
        }
        else{
            return view('hr.setup.leavetype');
        }
    }

    public function leavetypelistcon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $leavetypelist=DB::select('SELECT * FROM hr_leavetypes ORDER BY hr_leavetypes.id DESC');
        if(request()->ajax()) {
            return datatables()->of($leavetypelist)
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
        $headerid = $request->recId;
        $findid = $request->recId;
        $curdate = Carbon::today()->toDateString();

        $validator = Validator::make($request->all(), [
            'LeaveType' => ['required', 'string', 'max:255',Rule::unique('hr_leavetypes')->ignore($findid)],
            'RequiresBalance' => 'required',
            'LeavePaymentType' => 'required',
            'status' => 'required|string',
        ]);

        if ($validator->passes()){

            DB::beginTransaction();
            try{
                $BasicVal = [
                    'LeaveType' => $request->LeaveType,
                    'RequiresBalance' => $request->RequiresBalance,
                    'LeavePaymentType' => $request->LeavePaymentType,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = hr_leavetype::where('id', $findid)->first();
                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $leavetype = hr_leavetype::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $leavetype->id,
                    'pagename' => "leavetype",
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

    public function showleavetypecon($id){
        $recdata = hr_leavetype::findorFail($id);
        $data = hr_leavetype::where('hr_leavetypes.id', $id)->get(['hr_leavetypes.*']);

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"leavetype")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['leavetypedata' => $data,'activitydata' => $activitydata]);       
    }

    public function deleteleavetypecon(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        
        DB::beginTransaction();
        try{
            $findid = $request->delRecId;
            DB::table('hr_leavetypes')->where('id',$findid)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "leavetype",
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
