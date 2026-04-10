<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\department;
use App\Models\position;
use App\Models\salary;
use App\Models\actions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;


class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = department::orderBy("DepartmentName","ASC")->where("Status","Active")->where("id",'>',1)->get();
        $salary = salary::orderBy("SalaryName","ASC")->where("Status","Active")->where("IsFixed",1)->get();
        if($request->ajax()) {
            return view('hr.setup.position',['department'=>$departments,'salary'=>$salary])->renderSections()['content'];
        }
        else{
            return view('hr.setup.position',['department'=>$departments,'salary'=>$salary]);
        }
    }

    public function positionlistcon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $positionlist=DB::select('SELECT positions.id,positions.PositionName,departments.DepartmentName,salaries.SalaryName,positions.Status FROM positions INNER JOIN departments ON positions.departments_id=departments.id INNER JOIN salaries ON positions.salaries_id=salaries.id WHERE positions.id>1 ORDER BY positions.id DESC');
        if(request()->ajax()) {
            return datatables()->of($positionlist)
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
        $headerid = $request->recId;
        $findid = $request->recId;
        $curdate = Carbon::today()->toDateString();

        $validator = Validator::make($request->all(), [
            'PositionName' => ['required', 'string', 'max:255',Rule::unique('positions')->ignore($findid)],
            'Department' => 'required',
            'Salary' => 'required',
            'status' => 'required|string',
        ]);

        if ($validator->passes()){
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'PositionName' => $request->PositionName,
                    'departments_id' => $request->Department,
                    'salaries_id' => $request->Salary,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = position::where('id', $findid)->first();
                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $position = position::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $position->id,
                    'pagename' => "position",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'rec_id' => $position->id]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function showpositioncon($id){
        $cnt = 0;
        $data = position::join('departments','positions.departments_id','=','departments.id')
        ->join('salaries','positions.salaries_id','=','salaries.id')
        ->where('positions.id', $id)->get(['positions.*','departments.DepartmentName','salaries.SalaryName']);

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"position")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['positionlist' => $data,'activitydata' => $activitydata]);       
    }

    public function deleteposition(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;

        DB::beginTransaction();
        try{
            $findid = $request->delRecId;
            DB::table('positions')->where('id',$findid)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "position",
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
