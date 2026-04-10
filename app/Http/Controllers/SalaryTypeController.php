<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\salary;
use App\Models\salarytype;
use App\Models\actions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class SalaryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return view('hr.setup.salarytype')->renderSections()['content'];
        }
        else{
            return view('hr.setup.salarytype');
        }
    }

    public function salarytypelistcon()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $salarytypelist=DB::select('SELECT * FROM salarytypes ORDER BY salarytypes.id DESC');
        if(request()->ajax()) {
            return datatables()->of($salarytypelist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $salarytypeedit='';
                $salarytypedelete='';
                if($user->can('Salary-Component-Edit')){
                    $salarytypeedit=' <a class="dropdown-item salarytypeEdit" onclick="salarytypeEdityFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open salary type edit page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                }
                if($user->can('Salary-Component-Delete')){
                    $salarytypedelete='<a class="dropdown-item salarytypeDelete" onclick="salarytypeDeleteFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open salary type delete confirmation">
                            <i class="fa fa-trash"></i><span> Delete</span>  
                        </a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item salarytypeInfo" onclick="salarytypeInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open salary type information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$salarytypeedit.'
                        '.$salarytypedelete.'
                    </div>
                </div>';
                return $btn;
            })
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

        $validator = Validator::make($request->all(), [
            'SalaryTypeName' => ['required', 'string', 'max:255',Rule::unique('salarytypes')->ignore($findid)],
            'SalaryType' => 'required',
            'NonTaxableAmount' => 'required_if:SalaryType,Earnings',
            'status' => 'required',
        ]);

        if ($validator->passes()){
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'SalaryTypeName' => $request->SalaryTypeName,
                    'SalaryType' => $request->SalaryType,
                    'NonTaxableAmount' => $request->NonTaxableAmount ?? 0,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = salarytype::where('id', $findid)->first();
                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $salarytype = salarytype::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";
                actions::insert(['user_id'=>$userid,'pageid'=>$salarytype->id,'pagename'=>"salarytype",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

                DB::commit();
                return Response::json(['success' =>1]);
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

    public function showsalarytypecon($id){

        $recdata=salarytype::findorFail($id);

        $data = salarytype::where('salarytypes.id', $id)->get(['salarytypes.*']);

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"salarytype")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['salarytypedata' => $data,'activitydata' => $activitydata]);       
    }

    public function deletesalarytypecon(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        
        DB::beginTransaction();
        try{
            $findid = $request->delRecId;
            DB::table('salarytypes')->where('id',$findid)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "salarytype",
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
