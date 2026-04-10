<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\brand;
use App\Models\models;
use App\Models\actions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Response;
use Carbon\Carbon;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return view('registry.brand')->renderSections()['content'];
        }
        else{
            return view('registry.brand');
        }
    }

    public function showBrandData()
    {
        $brand=DB::select('SELECT * FROM brands WHERE brands.IsDeleted=1 ORDER BY brands.id DESC');
        if(request()->ajax()) {
            return datatables()->of($brand)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showModelData($id)
    {
        $models=models::select('id','BrandId','Name','description','ActiveStatus')->where('BrandId',$id)->get();
        return datatables()->of($models)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                 $btn =  ' <a data-id="'.$data->id.'" data-brandid="'.$data->BrandId.'" data-name="'.$data->Name.'" data-status="'.$data->ActiveStatus.'" class="btn btn-icon btn-gradient-info btn-sm" data-toggle="modal" id="mediumButton" data-target="#examplemodal-modeledit" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                 $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#examplemodal-modeldelete" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                 return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
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
        $users = Auth()->user();
        $findid = $request->recordId;
        $modeldata = [];
        $validator = Validator::make($request->all(), [
            'Name' => ['required','max:255','min:2',Rule::unique('brands')->ignore($findid)],
            'status' => ['required','string','max:255','min:2'],
        ]);

        $rules = array(
            //'row.*.ModelName' => 'required|distinct',
            'row.*.ModelName' => [
                'required',
                'distinct',
                Rule::unique('models', 'Name')->ignore($findid,'BrandId')
            ],
            'row.*.Status' => 'required',
        );

        $v2 = Validator::make($request->all(), $rules);

        if ($validator->passes() && $v2->passes() && $request->row != null) {
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'Name' => $request->Name,
                    'description' => $request->description,
                    'ActiveStatus' => $request->status,
                    'IsDeleted' => 1,
                ];

                $DbData = brand::where('id', $findid)->first();

                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $brand = brand::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                foreach ($request->row as $key => $value){
                    $modeldata[]=[
                        "BrandId" => $brand->id,
                        "Name" => $value['ModelName'],
                        "description" => $value['Description'],
                        "ActiveStatus" => $value['Status'],
                        "IsDeleted" => 1,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now()
                    ];
                }

                DB::table('models')->where('models.BrandId',$brand->id)->delete();

                DB::table('models')->insert($modeldata);

                $actions = $findid == null ? "Created" : "Edited";
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $brand->id,
                    'pagename' => "brand",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1, 'rec_id' => $brand->id]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }            
        }
        else if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
        else if($v2->fails()){
            return response()->json(['errorv2' => $v2->errors()->all()]);
        }
        else if($request->row == null){
            return Response::json(['emptyerror' => 462]);
        }
    }

    public function storeModel(Request $request)
    {
       $brid=trim($request->input('brandid'));
        $validator = Validator::make($request->all(), [
            'name'=>'required|min:2|max:255|unique:models,Name',
            'status' => ['required','string','max:255','min:2'],
        ]);
         if ($validator->passes()) 
         {
            $models=new models;
            $models->BrandId=trim($request->input('brandid'));
            $models->Name=trim($request->input('name'));
            $models->ActiveStatus=trim($request->input('status'));
            $models->IsDeleted=1;
            $models->save();
            return Response::json(['success' => '1']);
         }
        return Response::json(['errors' => $validator->errors()]);
    }

    public function getbrandmodel($id){
        $brandinfo = DB::select('SELECT * FROM brands WHERE brands.id='.$id);

        $modeldata = DB::select('SELECT * FROM models WHERE models.BrandId='.$id.' ORDER BY id ASC');

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"brand")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return Response::json(['brandinfo' => $brandinfo,'modeldata' => $modeldata,'activitydata' => $activitydata]);
    }

    public function mrcinfodata($id)
    {
        $detailTable=DB::select('SELECT * FROM models WHERE models.BrandId='.$id.' ORDER BY id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                //  $btn = ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                //  return $btn;
            })
           // ->rawColumns(['action'])
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

    public function update(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $findid=$request->id;
        $brand=brand::find($findid);
        $validator = Validator::make($request->all(), [
        'name'=>"required|min:2|max:255|unique:brands,Name,$findid",
        'status'=>"required|min:2|max:255",
        ]);
        if ($validator->passes()) 
        {
            $brand->Name=trim($request->input('name'));
            $brand->ActiveStatus=trim($request->input('status'));
            $brand->LastEditedBy=$user;
            $brand->LastEditedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $brand->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function updateModel(Request $request)
    {
        $findid=$request->id;
        $models=models::find($findid);
        $validator = Validator::make($request->all(), [
        'name'=>"required|min:2|max:255|unique:models,Name,$findid",
        'status'=>"required|min:2|max:255",
        ]);
        if ($validator->passes()) 
        {
            $models->Name=trim($request->input('name'));
            $models->ActiveStatus=trim($request->input('status'));
            $models->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function getbyid($id)
    {
        $getid=store::findOrFail($id);
        return Response::json($getid);
    }

    // public function delete($id)
    // {

    //     $parent=DB::select('select * from models where BrandId='.$id.'');
        
    //    if($parent==null){
    //     $brand = brand::find($id);
    //     $brand->delete();
    //     return Response::json(['success' => 'Brand Record Deleted success fully']);
    //    }
 
    //    return Response::json(['errors' => 'There Is Model Under This Brand']);


       
    // }

    public function delete($id){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $users = Auth()->user();

        DB::beginTransaction();
        try{
            DB::table('models')->where('models.BrandId',$id)->delete();
            DB::table('brands')->where('id',$id)->delete();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $id,
                'pagename' => "brand",
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
