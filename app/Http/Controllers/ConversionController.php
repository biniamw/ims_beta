<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\conversion;
use App\Models\uom;
use App\Models\actions;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Response;
use Carbon\Carbon;

class ConversionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function allpro()
     {

           // $all=Product::with('category')->get();

                // return DB::table('uoms')
                
                // ->leftjoin('conversions','conversions.FromUomID','uoms.id')
                 
                // ->select('uoms.Name','conversions.Amount')
                // ->get();
           // return view('p',compact('all'));
        //   return uom::select('oums.name')
        //         ->leftJoin('oums', 'oums.id', '=', 'conversions.FromUomID')
        //         ->leftJoin('oums', 'oums.id', '=', 'conversions.ToUomID')
        //         ->get();
       $query=DB::select('SELECT t.id,w1.Name AS fromunit,w2.Name as tounit,t.Amount,t.ActiveStatus FROM conversions AS t JOIN uoms AS w1 on w1.id=t.FromUomID JOIN uoms AS w2 on w2.id=t.ToUomID');
       // $query=DB::select('SELECT w1.Name AS fromunit,w2.Name as tounit,t.Amount FROM conversions AS t JOIN uoms AS w1 on w1.id=t.FromUomID JOIN uoms AS w2 on w2.id=t.ToUomID');
        return $query;
    }
    public function index()
    {
       return view('registry.uom');
    }

    public function showConversionData()
    {
        $conv=DB::select('SELECT t.id,w1.Name AS fromunit,w2.Name as tounit,t.Amount,t.ActiveStatus FROM conversions AS t JOIN uoms AS w1 on w1.id=t.FromUomID JOIN uoms AS w2 on w2.id=t.ToUomID');
        if(request()->ajax()) {
            return datatables()->of($conv)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $conversioneditlink='';
                $conversiondeletelink='';

                if($user->can('Conversion-edit'))
                {
                    $conversioneditlink=' <a class="dropdown-item editConversion" data-id="'.$data->id.'" data-from="'.$data->fromunit.'" data-to="'.$data->tounit.'" data-amount="'.$data->Amount.'"  data-status="'.$data->ActiveStatus.'" data-toggle="modal" id="smallButton" title="Edit">
                        <i class="fa fa-edit"></i><span> Edit</span>  
                    </a>';
                }

                if($user->can('Conversion-delete'))
                {
                    $conversiondeletelink='<a class="dropdown-item deleteItem" data-id="'.$data->id.'" data-status="" data-toggle="modal" id="smallButton" data-target="#examplemodalConversiondelete" data-attr="" title="Delete Record">
                        <i class="fa fa-trash"></i><span> Delete</span>  
                    </a>';
                }

                $btn='<div class="btn-group">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item conversionInfo" data-id="'.$data->id.'" id="catinfo" title="Open conversion information page">
                        <i class="fa fa-info"></i><span> Info</span>  
                    </a>
                   '.$conversioneditlink.'
                   '.$conversiondeletelink.'    
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
    public function getCoversionuom()
    {
        $res=uom::where(['IsDeleted'=>1,'ActiveStatus'=>'Active'])->get();
        return Response::json(['getuoms'=>$res]);
    }

    public function getConversionVal($id)
    {
        $getConv = conversion::findorFail($id);
        $convprp = DB::select('SELECT t.id,w1.Name AS fromunit,w2.Name AS tounit,t.Amount,t.ActiveStatus,t.description,t.FromUomID,t.ToUomID FROM conversions AS t JOIN uoms AS w1 on w1.id=t.FromUomID JOIN uoms AS w2 on w2.id=t.ToUomID WHERE t.id='.$id);
        
        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"conversion")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return Response::json(['getConv' => $getConv,'convprp' => $convprp, 'activitydata' => $activitydata]);
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
        $findid = $request->convRecordId;
        $validator = Validator::make($request->all(), [
            'from' => [
                'required',
                Rule::unique('conversions','FromUomID')->where(function ($query) use ($request,$findid) {
                    return $query->where('ToUomID', $request->to);
                })->ignore($findid)
            ],
            'to' => "required|different:from",
            'amount' => "required",
            'cstatus' => "required",
        ]);

        if($validator->passes()){
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'FromUomID' => $request->from,
                    'ToUomID' => $request->to,
                    'Amount' => $request->amount,
                    'description' => $request->convDescription,
                    'ActiveStatus' => $request->cstatus,
                    'IsDeleted' => 1,
                ];

                $DbData = conversion::where('id', $findid)->first();

                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $conv = conversion::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";

                actions::insert([
                    'user_id' => $userid,
                    'pageid' => $conv->id,
                    'pagename' => "conversion",
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

        $validator = Validator::make($request->all(), [
    
            'from'=>"required|integer",
             'to'=>"required|integer|different:from",
            //'to'=>"required|integer",
            'amount'=>"required|",
            'cstatus'=>"required|",
        ]);

        if ($validator->passes()) {

            $findid=trim($request->uid);
            $convert=conversion::findorFail($findid);
            $convert->FromUomID=trim($request->input('from'));
            $convert->ToUomID=trim($request->input('to'));
            $convert->Amount=trim($request->input('amount'));
            $convert->ActiveStatus=trim($request->input('cstatus'));
            $convert->LastEditedBy=$user;
            $convert->LastEditedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $convert->save();
            return Response::json(['success' => '1']);
        }
        return Response::json(['errors' => $validator->errors()]);
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

    public function delete($id)
    {
        $convId = conversion::findorFail($id);
        if($convId != null)
        {
            DB::beginTransaction();
            try{
                $convId->delete();
                
                DB::commit();
                return Response::json(['success' => 1]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
    }
}
