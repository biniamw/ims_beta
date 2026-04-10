<?php

namespace App\Http\Controllers;


use Response;
use Exception;
use App\Models\User;
use App\Models\store;
use App\Models\location;
use App\Models\storemrc;
use App\Models\companymrc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
//Global $StoreId;


class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companymrc=companymrc::get(['id','MRCNumber']);
        if($request->ajax()) {
            return view('registry.store',['companymrc'=>$companymrc])->renderSections()['content'];
        }
        else{
            return view('registry.store',['companymrc'=>$companymrc]);
        }
    }

    public function showStoreData()
    {
        $store=DB::select('SELECT *,CASE WHEN IsAllowedCreditSales="Allow" THEN "Allowed" WHEN IsAllowedCreditSales="Not-Allow" THEN "Not-Allowed" WHEN IsAllowedCreditSales!="Allow" AND IsAllowedCreditSales!="Not-Allow" THEN "" END AS IsAllowedCreditSale,(SELECT GROUP_CONCAT(storemrcs.mrcNumber," ") FROM storemrcs WHERE storemrcs.store_id=stores.id) AS MRCNumbers FROM stores WHERE stores.id>1 AND stores.IsDeleted=1 ORDER BY stores.id ASC');
        if(request()->ajax()) {
            return datatables()->of($store)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editbtn='';
                $deleteln='';
                $addLocationLink='';
                $addmrcLink='';
                if($data->ActiveStatus=='Inactive')
                {
                    if($user->can('Store-Edit'))
                    {
                        $editbtn=' <a class="dropdown-item editstore" data-id="'.$data->id.'" data-name="'.$data->Name.'" data-place="'.$data->Place.'" data-status="'.$data->ActiveStatus.'" data-toggle="modal" id="smallButton" data-attr="" title="Edit Record"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Store-Delete'))
                    {
                        $deleteln='<a class="dropdown-item " data-id="'.$data->id.'" data-status="" data-toggle="modal" id="smallButton" data-target="#examplemodal-delete" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Delete</span></a> ';
                    }
                    $addLocationLink='';
                }
                else if($data->ActiveStatus=='Active')
                {
                    if($user->can('Store-Edit'))
                    {
                        $editbtn=' <a class="dropdown-item editstore" data-id="'.$data->id.'" data-name="'.$data->Name.'" data-place="'.$data->Place.'" data-status="'.$data->ActiveStatus.'" data-toggle="modal" id="smallButton" data-attr="" title="Edit Record"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Store-Delete'))
                    {
                        $deleteln='<a class="dropdown-item " data-id="'.$data->id.'" data-status="" data-toggle="modal" id="smallButton" data-target="#examplemodal-delete" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Delete</span></a> ';
                    }
                    if($user->can('Store-Location'))
                    {
                        $addLocationLink='<a class="dropdown-item " data-id="'.$data->id.'" data-name="'.$data->Name.'"  data-toggle="modal" id="smallButton" data-target="#locationForm" title="Show Locations Under this Store"><i class="fa fa-plus"></i><span> Add/Edit Location</span></a>';
                    }
                    if($data->type=="Shop"){
                        $addmrcLink='<a class="dropdown-item " data-id="'.$data->id.'" data-name="'.$data->Name.'"  data-toggle="modal" id="smallButton" data-target="#mrcmodalform" title="Show MRC Under this Store"><i class="fa fa-plus"></i><span> Add/Edit MRC</span></a>';
                    }
                }

                $btn='<div class="btn-group dropleft">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item storeInfo" data-id="'.$data->id.'" id="storeinfo" title="Open store information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$addmrcLink.'
                        '.$addLocationLink.'
                        '.$editbtn.'
                        '.$deleteln.'
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


    public function showLocationdata($id)
    {

        // $bottle= tbl_bottle::select(
        //     'name',
        //     'type',
        //     'location'
        // )->where('name','=', $keyWord)->

        $StoreId=$id;
        $columnName="StoreId";
       $locations=location::select('id','StoreId','Name','ActiveStatus')->where($columnName,'=',$id)->get();
      return datatables()->of($locations)

    ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn =  ' <a data-id="'.$data->id.'" data-storeid="'.$data->StoreId.'" data-name="'.$data->Name.'" data-status="'.$data->ActiveStatus.'" class="btn btn-icon btn-gradient-info btn-sm " data-toggle="modal" id="mediumButton" data-target="#examplemodal-locedit" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#examplemodal-locdelete" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
          //  return view('registry.store');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mrcstore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mrcNumber' => 'required|min:10|max:10|unique:storemrcs,mrcNumber,'.$request->mrcid,
            'cashPrefix' => ['required'],
            'creditPrefix' => ['required'],
            'fiscalVoidType' => ['required'],
            'status' => ['required','string','max:255','min:2'],
        ]);
        if($validator->passes()){
            $mrcstore=storemrc::updateOrCreate(['id' =>$request->mrcid], [
                'store_id' =>$request->mrcstoreid,
                'mrcNumber' =>strtoupper($request->mrcNumber),
                'cashPrefix'=>$request->cashPrefix,
                'creditPrefix'=>$request->creditPrefix,
                'fiscalvoidtype'=>$request->fiscalVoidType,
                'status'=>$request->status,
                ]);
            return Response::json(['success' => 1]);
        }
        if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function store(Request $request)
    {
        $createdbyval="";
        $createddateval="";
        $lastmodifiedbyval="";
        $lastmodifieddateval="";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $curdate=Carbon::today()->toDateString();
        if($request->storeid==null){
            $createdbyval=$user;
            $createddateval=$curdate;
            $lastmodifiedbyval="";
            $lastmodifieddateval="";
        }
        else if($request->storeid!=null){
            $createdbyval=$request->usernamehidden;
            $createddateval=$request->createddatehidden;
            $lastmodifiedbyval=$user;
            $lastmodifieddateval=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2|unique:stores,Name,'.$request->storeid,
            'status' => ['required','string','max:255','min:2'],
            'type'=>'required',
            'IsAllowedCreditSales' => ['nullable','required_if:type,Shop']
        ]);

        $rules2=array
        (
            'mrcrow.*.mrcNumber' => 'required|min:10|max:10|regex:/^[a-zA-Z0-9\s]+$/',
            'mrcrow.*.status' => 'required',
        );

        $v2=Validator::make($request->all(), $rules2);
        if ($validator->passes() && $v2->passes()) {
            $store=store::updateOrCreate(['id' =>$request->storeid], [
                'type' => trim($request->type),
                'Name' => trim($request->name),
                'Place' =>trim($request->address),
                'ActiveStatus'=>$request->status,
                'IsAllowedCreditSales'=>$request->IsAllowedCreditSales,
                'CreatedBy'=>$createdbyval,
                'CreatedDate'=>$createddateval,
                'LastEditedBy'=>$lastmodifiedbyval,
                'LastEditedDate'=>$lastmodifieddateval,
                'IsPurchaseStore'=>0,
                'IsDeleted'=>1,
            ]);  
            return Response::json(['success' => '1']);
        }
        if($v2->fails()){
            return Response::json(['errorv2'  => $v2->errors()->all()]);
        }
        if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
    }


    public function storeLocation(Request $request)
    {

       $stid=trim($request->input('storeid'));
       $findid=location::find($stid);
       //echo "sdid=".$stid;
        $validator = Validator::make($request->all(),
         [
            //'storeid'=>'required',
           //'name' => ['required','max:255','min:2','unique:locations,Name'],
           //'name'=>'required|min:2|max:255|unique:locations,Name,except,StoreId',

            'name' => ['required','min:2',Rule::unique('locations','Name')->where(function($query) use ($request) {
                  $query->where('StoreId',$request['storeid'] );
              })
            ],


            'status' => ['required','string','max:255','min:2'],
        ]);




         if ($validator->passes())
         {
            $location=new location;
            $location->StoreId=trim($request->input('storeid'));
            $location->Name=trim($request->input('name'));
            $location->ActiveStatus=trim($request->input('status'));
            $location->IsDeleted=1;
            $location->save();
            return Response::json(['success' => '1']);
         }
        return Response::json(['errors' => $validator->errors()]);
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
        $store=store::findOrFail($id);
        //return view ('registry.catedit')->with('cat',$store);
    }

    public function getbyid($id)
    {
        $getid=store::findOrFail($id);
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
        $findid=$request->id;
        $store=store::find($findid);
        $validator = Validator::make($request->all(), [
        'name'=>"required|min:2|max:255|unique:stores,Name,$findid",
        'place' => "required|max:255|min:2",
        'status'=>"required|min:2|max:255",
        ]);
        if ($validator->passes())
        {
            $store->Name=trim($request->input('name'));
            $store->Place=trim($request->input('place'));
            $store->ActiveStatus=trim($request->input('status'));
            $store->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function updateLoc(Request $request)
    {
        $findid=$request->id;
        $location=location::find($findid);
        $validator = Validator::make($request->all(), [
        'name'=>"required|min:2|max:255|unique:locations,Name,$findid",
        'status'=>"required|min:2|max:255",
        ]);
        if ($validator->passes())
        {
            $location->Name=trim($request->input('name'));
            $location->ActiveStatus=trim($request->input('status'));
            $location->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
      $parent=DB::select('select * from locations where StoreId='.$id.'');
        if($parent==null)
        {
        try
        {
            $store = store::find($id);
            $store->delete();
            return Response::json(['success' => 'Store Record Deleted success fully']);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
        }
    return Response::json(['errors' => 'This can not delete']);

    }
    public function savestoremrc(){
        $str=store::find(2);
        $strmrc = new storemrc;
        $strmrc->mrcNumber="gh12588445";
        $str->strmrc()->save($strmrc);
        return Response::json(['success' => 'ok']);
    }
    public function getmrc(){
        //$companymrc=companymrc::get(['id','MRCNumber']);
        $companymrc= companymrc::doesntHave('stores')->get(['id','MRCNumber']);
        return Response::json(['companymrc' => $companymrc]);
    }

    public function storewithmrc(){
        $storemrc= store::with('strmrc')->get();
        return Response::json(['storemrc' => $storemrc]);
    }

    public function storemrc(){
        $userid=Auth()->user()->id;
        $user = User::find(13)->companymrcs()->get(['companymrcs.id','companymrcs.MRCNumber']);
        return Response::json(['companymrc' => $user]);
    }

    public function getstore($id){
        $store=store::FindorFail($id);
        $createddateval=$store->created_at;

        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $storeinfo=DB::select('SELECT *,"'.$datetime.'" AS CreatedDateTime FROM stores WHERE stores.id='.$id);
        $mrc=store::find($id)->companymrc()->select('companymrcs.id','companymrcs.MRCNumber')->get()->makeHidden('pivot');
        return Response::json(['store' => $store,'mrc' => $mrc,'storeinfo'=>$storeinfo]);
    }

    public function getmrcedit($id){
        $mrcedit=storemrc::FindorFail($id);
        return Response::json(['mrcedit' => $mrcedit]);
    }

    public function mrcdelete($id){
        try{
            $delete=storemrc::where('id',$id)->delete();
            if($delete){

                return Response::json(['deleted'=>"Success fully deleted MRC"]);
            }
            else{

                return Response::json(['error'=>"You can not delete this MRC"]);
            }

        } catch(\Exception $e){

            return Response::json(['dberrors' => $e->getMessage()]);
        }
    }

    public function mrcinfodata($id)
    {
        $detailTable=DB::select('SELECT * FROM storemrcs WHERE storemrcs.store_id='.$id.' ORDER BY id ASC');
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

    public function getdifferentmrc($id){
        $differentmrc= companymrc::doesntHave('stores')->get();
        return Response::json(['differentmrc' => $differentmrc]);
    }
    
    public function getassignedmrc($id){
       // $mrc=store::with('companymrc')->get();
        //$mrc=store::find($id)->companymrc;
        $mrc=store::find($id)->strmrc;
        return datatables()->of($mrc)->addIndexColumn()->toJson();
        //return Response::json(['mrc' => $mrc]);
    }

    public function deleteLoc($id)
    {
        $location = location::find($id);
        $location->delete();
        return Response::json(['success' => 'Location Record Deleted success fully']);
    }

    public function destroy($id)
    {
        $id=$request->id;
        $delete=$request->all();
        $deletestore=store::findorFail($id);
        $deletestore->delete();
        return redirect('store')->with('success','Data Deleted Success fully');
    }
}
