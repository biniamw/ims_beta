<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\prd_bom;
use App\Models\prd_bomchild;
use App\Models\prd_bomdetail;
use App\Models\actions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class BomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $uomdata=DB::select('select * from uoms where uoms.ActiveStatus="Active"');
        $origin=DB::select('SELECT woredas.id,woredas.Woreda_Name AS Origin,"1" AS CommType FROM woredas WHERE woredas.id=1 UNION SELECT woredas.id,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,"2" AS CommType FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE woredas.id>1');
        if($request->ajax()) {
            return view('production.bom',['uomdata'=>$uomdata,'origin'=>$origin])->renderSections()['content'];
        }
        else{
            return view('production.bom',['uomdata'=>$uomdata,'origin'=>$origin]);
        }
    }

    public function bomlist()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $bomlist=DB::select('SELECT *,CASE WHEN prd_boms.type=1 THEN "Commodity" WHEN prd_boms.type=2 THEN "Product" END AS BomType FROM prd_boms WHERE prd_boms.id>1 ORDER BY prd_boms.id DESC');
        if(request()->ajax()) {
            return datatables()->of($bomlist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $bomedit='';
                $bomdelete='';
                $bomadd='';
                if($user->can('BOM-Edit')){
                    $bomedit='<a class="dropdown-item bomEdit" onclick="bomEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn'.$data->id.'" title="Open BOM edit page">
                        <i class="fa fa-edit"></i><span> Edit</span>  
                    </a>';
                }
                if($user->can('BOM-Delete')){
                    $bomdelete='<a class="dropdown-item bomDelete" onclick="bomDeleteFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn'.$data->id.'" title="Open BOM delete confirmation">
                            <i class="fa fa-trash"></i><span> Delete</span>  
                        </a>';
                }
                if($user->can('BOM-Add') || $user->can('BOM-Edit')){
                    $bomadd='<a class="dropdown-item bomAdd" onclick="bomAddFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn'.$data->id.'" title="Open BOM edit page">
                        <i class="fa fa-plus"></i><span> Add/Edit Child BOM</span>  
                    </a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item bomInfo" onclick="bomInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn'.$data->id.'" title="Open BOM information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$bomedit.'
                        '.$bomadd.'
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
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $settings = DB::table('settings')->latest()->first();
        $documentNumber=$settings->BomPrefix.sprintf("%06d",$settings->BomNumbers);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->recId;
        $findid=$request->recId;
        $curdate=Carbon::today()->toDateString();
        $settings = DB::table('settings')->latest()->first();
        $totalcost=0;
        $commdetaildata=[];
        $idvals=[];
        $actiondata=[];
        $actions="";

        $validator = Validator::make($request->all(), [
            'BomName' => ['required','min:2','max:100',Rule::unique('prd_boms')->where(function ($query){
            })->ignore($findid)],
            'type'=>'required',
            'Description'=>'nullable|min:1|max:150',
            'status'=>'required',
        ]);

        if ($validator->passes()){
            try
            {
                $BasicVal = [
                    'BomName' => $request->BomName,
                    'type' => $request->type,
                    'TotalCost' => $totalcost,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = prd_bom::where('id', $findid)->first();
                $CreatedBy = ['BomNumber' => $documentNumber,'BomChildNumber'=>1];
                $LastUpdatedBy = ['updated_at'=>Carbon::now()];

                $prdbom = prd_bom::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                if($findid==null){
                    $actions="Created";
                    $updn=DB::select('UPDATE settings SET BomNumbers=BomNumbers+1 WHERE id=1');
                }
                else if($findid!=null){
                    $actions="Edited";
                }
                actions::insert(['user_id'=>$userid,'pageid'=>$prdbom->id,'pagename'=>"bomparent",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }

        if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function saveChildBom(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->recChildId;
        $findid=$request->recChildId;
        $parentBomId=$request->parentRecId;
        $curdate=Carbon::today()->toDateString();
        $settings = DB::table('settings')->latest()->first();
        $totalcost=0;
        $commdetaildata=[];
        $idvals=[];
        $actiondata=[];
        $actions="";
        $bomchildnum="";

        $validator = Validator::make($request->all(), [
            'BomChildName'=>'nullable|min:2|max:150',
            'DescriptionChild'=>'nullable|min:1|max:150',
            'statusChild'=>'required',
        ]);

        $rules=array(
            'row.*.Origin' => 'required',
            'row.*.Grade' => 'required',
            'row.*.ProcessType' => 'required',
            'row.*.CropYear' => 'required',
            'row.*.Uom' => 'required',
            'row.*.Quantity' => 'required|gt:0',
            'row.*.UnitPrice' => 'required|gt:0',
            'row.*.TotalPrice' => 'required|gt:0',
        );

        $v2= Validator::make($request->all(), $rules);

        if ($validator->passes() && $v2->passes() && $request->row!=null){
            try
            {
                $bomprop=prd_bom::findOrFail($parentBomId);
                $bomchildnum="BOM-".sprintf("%02d",$bomprop->BomChildNumber);

                foreach ($request->row as $key => $value){
                    $totalcost+=$value['TotalPrice'] ?? 0;
                }

                $BasicVal = [
                    'prd_boms_id' => $parentBomId,
                    'TotalCost' => $totalcost,
                    'Description' => $request->DescriptionChild,
                    'Status' => $request->statusChild,
                ];

                $DbData = prd_bomchild::where('id', $findid)->first();
                $CreatedBy = ['BomChildName'=>$bomchildnum];
                $LastUpdatedBy = ['updated_at'=>Carbon::now()];

                $prdbomch = prd_bomchild::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                foreach ($request->row as $key => $value){
                    $idvals[]=$value['id'];
                }
                prd_bomdetail::where('prd_bomchildren_id',$prdbomch->id)->whereNotIn('id',$idvals)->delete();

                foreach ($request->row as $key => $value){
                    prd_bomdetail::updateOrCreate(['id' => $value['id']],
                    [ 
                        'prd_boms_id' =>(int)$parentBomId,
                        'prd_bomchildren_id' =>(int)$prdbomch->id,
                        'woredas_id' =>(int)$value['Origin'],
                        'Grade'=>(int)$value['Grade'],
                        'ProcessType'=>$value['ProcessType'],
                        'CropYear'=>(int)$value['CropYear'],
                        'uoms_id'=>(int)$value['Uom'],
                        'Quantity'=>(float)$value['Quantity'],
                        'UnitCost'=>(float)$value['UnitPrice'],
                        'TotalCost'=>(float)$value['TotalPrice'],
                        'Remark'=>$value['Remark']
                    ]);
                }

                if($findid==null){
                    $actions="Created";
                    $updn=DB::select('UPDATE prd_boms SET BomChildNumber=BomChildNumber+1 WHERE id='.$parentBomId);
                }
                else if($findid!=null){
                    $actions="Edited";
                }
                actions::insert(['user_id'=>$userid,'pageid'=>$prdbomch->id,'pagename'=>"bomchild",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }

        if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
        if($request->row==null)
        {
            return Response::json(['emptyerror'=>"error"]);
        }
    }

    public function showBom($id){
        $datefromval=0;
        $bomprop=prd_bom::findOrFail($id);
        $bomchildnum="BOM-".sprintf("%02d",$bomprop->BomChildNumber);
        $bomdata=prd_bom::where('prd_boms.id',$id)
        ->get(['prd_boms.*',DB::raw("'$bomchildnum' AS BomChildNumberData"),DB::raw('CASE WHEN prd_boms.type=1 THEN "Commodity" WHEN prd_boms.type=2 THEN "Product" END AS BomType')]);

        $bomdetaildata=prd_bomdetail::where('prd_boms_id',$id)
        ->join('woredas','prd_bomdetails.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('uoms','prd_bomdetails.uoms_id','uoms.id')
        ->orderBy('prd_bomdetails.id','ASC')
        ->get(['prd_bomdetails.*',DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_bomdetails.Remark,"") AS Remark'),'uoms.Name AS UomName']);
        
        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"bomparent")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['bomdata'=>$bomdata,'bomdetaildata'=>$bomdetaildata,'activitydata'=>$activitydata]);       
    }

    public function showChBom($id){
        $datefromval=0;
        $bomdata=prd_bomchild::where('prd_bomchildren.id',$id)->get(['prd_bomchildren.*']);

        $bomparentdata=prd_bom::where('prd_boms.id',$bomdata[0]->prd_boms_id)
        ->get(['prd_boms.*',DB::raw('CASE WHEN prd_boms.type=1 THEN "Commodity" WHEN prd_boms.type=2 THEN "Product" END AS BomType')]);

        $bomdetaildata=prd_bomdetail::where('prd_bomchildren_id',$id)
        ->join('woredas','prd_bomdetails.woredas_id','woredas.id')
        ->join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->join('uoms','prd_bomdetails.uoms_id','uoms.id')
        ->orderBy('prd_bomdetails.id','ASC')
        ->get(['prd_bomdetails.*',DB::raw('CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin'),DB::raw('IFNULL(prd_bomdetails.Remark,"") AS Remark'),'uoms.Name AS UomName']);
        
        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"bomchild")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['bomparentdata'=>$bomparentdata,'bomdata'=>$bomdata,'bomdetaildata'=>$bomdetaildata,'activitydata'=>$activitydata]);       
    }

    public function showBomDetail($id)
    {
        $origindata=DB::select('select prd_bomchildren.BomChildName,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,uoms.Name AS UomName,prd_bomdetails.*, IFNULL(prd_bomdetails.Remark,"") AS Remark, uoms.Name as UomName from prd_bomdetails inner join prd_bomchildren ON prd_bomdetails.prd_bomchildren_id=prd_bomchildren.id inner join woredas on prd_bomdetails.woredas_id = woredas.id inner join zones on woredas.zone_id = zones.id inner join regions on zones.Rgn_Id = regions.id inner join uoms on prd_bomdetails.uoms_id = uoms.id where prd_bomdetails.prd_boms_id = '.$id.' order by prd_bomdetails.id DESC');
        return datatables()->of($origindata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showChBomDetail($id)
    {
        $origindata=DB::select('select CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,uoms.Name AS UomName,prd_bomdetails.*, IFNULL(prd_bomdetails.Remark,"") AS Remark, uoms.Name as UomName from prd_bomdetails inner join woredas on prd_bomdetails.woredas_id = woredas.id inner join zones on woredas.zone_id = zones.id inner join regions on zones.Rgn_Id = regions.id inner join uoms on prd_bomdetails.uoms_id = uoms.id where prd_bomchildren_id = '.$id.' order by prd_bomdetails.id DESC');
        return datatables()->of($origindata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showChildBom($id)
    {
        $bomchildlist=DB::select('select * from prd_bomchildren where prd_bomchildren.prd_boms_id = '.$id.' order by prd_bomchildren.id DESC');
        return datatables()->of($bomchildlist)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {
            $user=Auth()->user();
            $chbomedit='';
            $chbomdelete='';
            if($user->can('BOM-Edit')){
                $chbomedit='<a class="dropdown-item chBomEdit" onclick="chBomEditFn('.$data->id.')" data-id="'.$data->id.'" id="chdteditbtn'.$data->id.'" title="Open BOM edit page">
                    <i class="fa fa-edit"></i><span> Edit</span>  
                </a>';
            }
            if($user->can('BOM-Delete')){
                $chbomdelete='<a class="dropdown-item chBomDelete" onclick="chBomDeleteFn('.$data->id.')" data-id="'.$data->id.'" id="chdtdeletebtn'.$data->id.'" title="Open BOM delete confirmation">
                    <i class="fa fa-trash"></i><span> Delete</span>  
                </a>';
            }
            
            $btn='<div class="btn-group dropleft">
            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
            </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item chBomInfo" onclick="chBomInfoFn('.$data->id.')" data-id="'.$data->id.'" id="chdtinfobtn'.$data->id.'" title="Open BOM information page">
                        <i class="fa fa-info"></i><span> Info</span>  
                    </a>
                    '.$chbomedit.'
                </div>
            </div>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function deleteBom(Request $request){
        try{
            prd_bomdetail::where('prd_boms_id',$request->delRecId)->delete();
            prd_bom::where('id',$request->delRecId)->delete();
            return Response::json(['success' =>1]);
        }
        catch(Exception $e){
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
