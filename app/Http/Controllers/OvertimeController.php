<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\actions;
use App\Models\overtime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return view('hr.setup.overtime')->renderSections()['content'];
        }
        else{
            return view('hr.setup.overtime');
        }
    }

    public function overtimeList()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $overtimelist=DB::select('SELECT * FROM overtimes WHERE id>1 ORDER BY overtimes.id DESC');
        if(request()->ajax()) {
            return datatables()->of($overtimelist)
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
        $action="";

        $colors =  [
                "#007bff", "#28a745", "#ffc107", "#dc3545", "#6f42c1",
                "#56CCF2", "#F4A261", "#E76F51", "#2A9D8F", "#8E44AD",
                "#00c6ff", "#0072ff", "#ff758c", "#ff7eb3", "#00b09b",
                "#96c93d", "#8e2de2", "#4a00e0", "#b0bec5", "#ff5733",
                "#17a2b8", "#ff6b81", "#20c997", "#ff9f43", "#6c757d"
            ];

        $validator = Validator::make($request->all(), [
            'OvertimeLevelName' => ['required', 'string', 'max:255',Rule::unique('overtimes')->ignore($findid)],
            'WorkHourRate' => 'required',
            'status' => 'required|string',
        ]);

        if ($validator->passes()){
            DB::beginTransaction();
            try{
                $randomColor = Arr::random($colors);

                $BasicVal = [
                    'OvertimeLevelName' => $request->OvertimeLevelName,
                    'WorkhourRate' => $request->WorkHourRate,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = overtime::where('id', $findid)->first();
                $CreatedBy = ['CreatedBy' => $user,'Color' => $randomColor];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $otime = overtime::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $otime->id,
                    'pagename' => "ot",
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

    public function showOvertimeCon($id){
        $countdata = 0;
        $recdata = overtime::findorFail($id);

        $overtimecount = DB::table('holidays')->where('overtime_id','=',$id)->get();
        $countdata = $overtimecount->count();

        $data = overtime::where('overtimes.id', $id)->get(['overtimes.*']);

        $activitydata = actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"ot")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['overtimesdata' => $data,'countdata' => $countdata,'activitydata' => $activitydata]);       
    }

    public function deleteotlevelcon(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        
        DB::beginTransaction();
        try{
            $findid = $request->delRecId;
            DB::table('overtimes')->where('id',$findid)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "ot",
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
