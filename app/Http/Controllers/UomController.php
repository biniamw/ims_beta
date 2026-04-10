<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\uom;
use App\Models\actions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Response;
use Carbon\Carbon;

class UomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $uoms=uom::all();
        $uomlist = DB::select('select * from uoms where ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        if($request->ajax()) {
            return view('registry.uom',['uomlist' => $uomlist])->renderSections()['content'];
        }
        else{
            return view('registry.uom',['uomlist' => $uomlist]);
        }
    }

    public function showUOMData()
    {
        $uom=DB::select('SELECT * FROM uoms WHERE uoms.IsDeleted=1 ORDER BY uoms.id DESC');
        if(request()->ajax()) {
            return datatables()->of($uom)
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
        $users = Auth()->user();
        $findid = $request->recordId;
        $validator = Validator::make($request->all(), [
            'Name' => ['required', 'string', 'max:255',Rule::unique('uoms')->ignore($findid)],
            'status' => ['required','string','max:255','min:2'],
        ]);

        if ($validator->passes()) {
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'Name' => $request->Name,
                    'description' => $request->description,
                    'ActiveStatus' => $request->status,
                    'IsDeleted' => 1,
                ];

                $DbData = uom::where('id', $findid)->first();

                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $uoms = uom::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";

                actions::insert([
                    'user_id' => $userid,
                    'pageid' => $uoms->id,
                    'pagename' => "uom",
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
        else{
            return Response::json(['errors' => $validator->errors()]);
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
  
    public function edit($id){
        $uom = uom::findOrFail($id);
        $uomprp = DB::select('SELECT * FROM uoms WHERE uoms.id='.$id);

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"uom")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['uomprp' => $uomprp,'activitydata' => $activitydata]);
    }

    public function getbyid($id)
    {
        $getid=uom::findOrFail($id);
        return Response::json($getid);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $findid=$request->id;
        $uom=uom::find($findid);
        $validator = Validator::make($request->all(), [
            'name'=>"required|min:2|max:255|unique:uoms,Name,$findid",
            'status'=>"required|min:2|max:255",
        ]);
        if ($validator->passes()) 
        {
            $uom->Name=trim($request->input('name'));
            $uom->ActiveStatus=trim($request->input('status'));
            $uom->LastEditedBy=$user;
            $uom->LastEditedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            //$uom->IsDeleted=1;
            $uom->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    
    public function delete($id){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $users = Auth()->user();
        $parent = DB::select('select * from regitems where MeasurementId='.$id.''); 
        $parentconverse = DB::select('select * from conversions where ToUomID='.$id.''); 
        
        if($parent == null && $parentconverse == null){
            DB::beginTransaction();
            try{
                $uom = uom::find($id);
                $uom->delete();

                actions::insert([
                    'user_id' => $userid,
                    'pageid' => $id,
                    'pagename' => "uom",
                    'action' => "Deleted",
                    'status' => "Deleted",
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
        else{
            return Response::json(['errors' => 465]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        $id=$request->id;
        $delete=$request->all();
        $deletuom=uom::findorFail($id);
        $deletuom->delete();
    }
}
