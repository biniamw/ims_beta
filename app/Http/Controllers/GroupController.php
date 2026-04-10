<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\groupmember;
use App\Models\actions;
use Response;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Exception;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return view('registry.group')->renderSections()['content'];
        }
        else{
            return view('registry.group');
        }
    }

    public function groupListCon()
    {
        $groups=DB::select('SELECT * FROM groupmembers ORDER BY groupmembers.id DESC');
        if(request()->ajax()) {
            return datatables()->of($groups)
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
        $findid = $request->groupId;

        $validator = Validator::make($request->all(), [
            'GroupName' => ['required',Rule::unique('groupmembers')->where(function ($query){
                })->ignore($findid)
            ],
            'GroupSize' => ['required'],
            'Description' => ['nullable'],
            'status' => ['required'],
        ]);

        if($validator->passes()){
            DB::beginTransaction();

            try{
                $BasicVal = [
                    'GroupName' => $request->GroupName, 
                    'GroupSize' => $request->GroupSize,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = groupmember::where('id', $findid)->first();

                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $groupmem = groupmember::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $groupmem->id,
                    'pagename' => "group",
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

    public function showgroup($id){
        $groupcnt=0;
        $data = groupmember::where('groupmembers.id', $id)->get();
        $checkgroupcnt = DB::select('SELECT COUNT(servicedetails.groupmembers_id) AS ServiceCount FROM servicedetails WHERE servicedetails.groupmembers_id='.$id);   
        $groupcnt = $checkgroupcnt[0]->ServiceCount ?? 0;

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"group")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['grouplist' => $data,'groupcnt' => $groupcnt,'activitydata' => $activitydata]);
    }

    public function deletegroup(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->groupInfoId;
        $groupcnt = 0;
        $checkgroupcnt = DB::select('SELECT COUNT(servicedetails.groupmembers_id) AS ServiceCount FROM servicedetails WHERE servicedetails.groupmembers_id='.$findid);   
        $groupcnt = $checkgroupcnt[0]->ServiceCount ?? 0;
        DB::beginTransaction();
        try{
            if($groupcnt >= 1){
                return Response::json(['errors' => 465]);
            }
            else if($groupcnt == 0){
                DB::table('groupmembers')->where('id',$findid)->delete();

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "group",
                    'action' => "Delete",
                    'status' => "Delete",
                    'reason' => "$request->DSReason",
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
