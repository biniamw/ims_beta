<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\branch;
use App\Models\actions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Response;
use Carbon\Carbon;
use Exception;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return view('registry.branch')->renderSections()['content'];
        }
        else{
            return view('registry.branch');
        }
    }

    public function branchlistcon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $branchlist=DB::select('SELECT * FROM branches ORDER BY id DESC');
        if(request()->ajax()) {
            return datatables()->of($branchlist)
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
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $headerid = $request->branchId;
        $findid = $request->branchId;
        $curdate = Carbon::today()->toDateString();
        
        $validator = Validator::make($request->all(), [
            'BranchName' => ['required', 'string', 'max:255',Rule::unique('branches')->ignore($findid)],
            'BranchLocation' => 'required',
            'PhoneNumber' => ['required',Rule::unique('branches')->ignore($findid)],
            'EmailAddress' => ['nullable','email',Rule::unique('branches')->ignore($findid)],
            'status' => 'required|string',
        ]);

        if ($validator->passes()){
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'BranchName' => $request->BranchName,
                    'BranchLocation' => $request->BranchLocation,
                    'PhoneNumber' => $request->PhoneNumber,
                    'EmailAddress' => $request->EmailAddress,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = branch::where('id', $findid)->first();
                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $branch = branch::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $branch->id,
                    'pagename' => "branch",
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
        else if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function showbranchCon($id){
        $data = branch::where('branches.id', $id)->get(['branches.*']);

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"branch")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['branchlist' => $data,'activitydata' => $activitydata]);       
    }

    public function deleteBranch(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        
        DB::beginTransaction();
        try{
            $findid = $request->branchInfoId;
            DB::table('branches')->where('id',$findid)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "branch",
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
