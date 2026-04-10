<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\department;
use App\Models\actions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Response;
use Carbon\Carbon;
use Exception;

class DepartmentController extends Controller
{
    //
    public function index(Request $request)
    {
        $departments = department::orderBy("DepartmentName","ASC")->where("Status","Active")->get(["DepartmentName", "id"]);
        if($request->ajax()) {
            return view('registry.department',['department'=>$departments])->renderSections()['content'];
        }
        else{
            return view('registry.department',['department'=>$departments]);
        }
    }

    public function departmentlistcon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $departmentlist=DB::select('SELECT departments.id,departments.DepartmentName,dep.DepartmentName AS ParentDepartmentName,departments.Status FROM departments INNER JOIN departments AS dep ON departments.departments_id=dep.id WHERE departments.id>1 ORDER BY departments.id DESC');
        if(request()->ajax()) {
            return datatables()->of($departmentlist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $departmentedit='';
                $departmentdelete='';
                if($user->can('Department-Edit')){
                    $departmentedit=' <a class="dropdown-item branchEdit" onclick="departmentEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open department edit page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                }
                if($user->can('Department-Delete')){
                    $departmentdelete='<a class="dropdown-item branchDelete" onclick="departmentDeleteFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open department delete confirmation">
                            <i class="fa fa-trash"></i><span> Delete</span>  
                        </a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item branchInfo" onclick="departmentInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open department information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$departmentedit.'
                        '.$departmentdelete.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }


    public function store(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->departmentId;
        $pardepid = $request->ParentDepartment;
        $parentdeperrflag = 0;

        $validator = Validator::make($request->all(), [
            'DepartmentName' => ['required', 'string', 'max:255',Rule::unique('departments')->ignore($findid)],
            'ParentDepartment' => 'required',
            'status' => 'required|string',
        ]);

        if($findid == $pardepid && $findid != null){
            $parentdeperrflag = 1;
        }

        if ($validator->passes() && $parentdeperrflag == 0){
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'departments_id' => $request->ParentDepartment,
                    'DepartmentName' => $request->DepartmentName,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = department::where('id', $findid)->first();
                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $department = department::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $department->id,
                    'pagename' => "department",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'rec_id' => $department->id]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($parentdeperrflag == 1){
            return Response::json(['errflag' => 462]);
        }
        else if($validator->fails()){
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function showDepartmentHier(){
       $data = department::where('id','>',1)->get();
       $parentdata = department::where('Status',"Active")->where('id','>',1)->get();
       return response()->json(['deplist' => $data,'all_department' => $parentdata]);  
    }

    public function getlastdepartment()
    {
        $depname=$_POST['depmame']; 
        $getlastdepartmens=DB::select('SELECT departments.id,departments.DepartmentName FROM departments WHERE departments.DepartmentName="'.$depname.'" ORDER BY departments.id DESC LIMIT 1');
        return response()->json(['getlastdep'=>$getlastdepartmens]);
    }

    public function showdepartmentCon($id){
        $data = department::join('departments AS dep','departments.departments_id','=','dep.id')
        ->where('departments.id', $id)->get(['departments.id','departments.departments_id','departments.DepartmentName','departments.Description','departments.CreatedBy','departments.LastEditedBy','departments.Status','dep.DepartmentName AS ParentDepartment']);

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"department")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['departmentlist' => $data,'activitydata' => $activitydata]);       
    }

    public function deletedepartment(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        
        DB::beginTransaction();
        try{
            $findid = $request->departmentInfoId;
            DB::table('departments')->where('id',$findid)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "department",
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
}
