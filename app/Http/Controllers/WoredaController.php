<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Woreda;
use App\Models\Region;
use App\Models\Zone;
use App\Models\com_certificate;
use App\Models\woreda_certificate;
use App\Models\prd_order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use DataTables;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class WoredaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $regions = Region::where('status','Active')->where('id','>',0)->orderBy('id', 'DESC')->get();
        $zones = Zone::where('status','Active')->where('id','>',0)->orderBy('id', 'DESC')->get();
        $comcertnum = com_certificate::where('Status','Active')->where('id','>',1)->orderBy('Certification', 'ASC')->get();
        if($request->ajax()) {
            return view('registry.woreda',['regions'=>$regions,'zones'=>$zones,'comcertnum'=>$comcertnum])->renderSections()['content'];
        }
        else{
            return view('registry.woreda',['regions'=>$regions,'zones'=>$zones,'comcertnum'=>$comcertnum]);
        }
    }

    public function woredalist()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $woredalistdata=DB::select('SELECT woredas.*,CASE WHEN woredas.Type=1 THEN "Arrival" WHEN woredas.Type=2 THEN "Export" WHEN woredas.Type=3 THEN "Reject" END AS CommType,zones.Zone_Name,regions.Rgn_Name FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id ORDER BY woredas.id DESC');
        if(request()->ajax()) {
            return datatables()->of($woredalistdata)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $woredaedit='';
                $woredadelete='';
                if($user->can('Woreda-Edit')){
                    $woredaedit=' <a class="dropdown-item woredaEdit" onclick="woredaEditFn('.$data->id.')" data-id="'.$data->id.'" id="dteditbtn" title="Open woreda edit page">
                            <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                }
                if($user->can('Woreda-Delete')){
                    $woredadelete='<a class="dropdown-item woredaDelete" onclick="woredaDeleteFn('.$data->id.')" data-id="'.$data->id.'" id="dtdeletebtn" title="Open woreda delete confirmation">
                            <i class="fa fa-trash"></i><span> Delete</span>  
                        </a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item woredaInfo" onclick="woredaInfoFn('.$data->id.')" data-id="'.$data->id.'" id="dtinfobtn" title="Open woreda information page">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$woredaedit.'
                        '.$woredadelete.'
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
        $certificate=$request->Certification;
        $certificatedata=[];
        $zone=1;
        $curdate=Carbon::today()->toDateString();
        $settings = DB::table('settings')->latest()->first();

        $validator = Validator::make($request->all(), [
            'Type' => 'required',
            'Woreda_Name' => ['required',
                Rule::unique('woredas')->where(function ($query) use($findid,$request){
                    $query->where('zone_id',$request->Zone);
                })->ignore($findid)
            ],
            'Station' => 'required_if:Type,1',
            'Region' => 'required_if:Type,1',
            'Zone' =>'required_if:Type,1',
            'Email' => 'nullable|email',
            'PhoneNumber' => 'nullable|regex:/^\+?[0-9\-]{10,15}$/',
            'Certification' => 'nullable',
            'status' => 'required|string',
        ]);

        if ($validator->passes()){
            try
            {
                if($request->Type==1){
                    $zone=$request->Zone;
                }
                else{
                    $zone=1;
                }
                $BasicVal = [
                    'Type' => $request->Type,
                    'Woreda_Name' => $request->Woreda_Name,
                    'Wh_name' => $request->Station ?? "-",
                    'Symbol' => $request->Symbol,
                    'zone_id' =>$request->Zone ?? "1",
                    'phone' => $request->PhoneNumber,
                    'email' => $request->Email,
                    'description' => $request->Description,
                    'status' => $request->status,
                ];

                
                $DbData = Woreda::where('id', $findid)->first();
                $CreatedBy = ['created_by' => $user];
                $LastUpdatedBy = ['updated_by' => $user];

                $woreda = Woreda::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                if($certificate!=null){
                    foreach($request->input('Certification') as $certs){
                        $certificatedata[]=["woredas_id"=>$woreda->id,"com_certificates_id"=>$certs];
                    }
                }

                if($certificate==null){
                    $certificatedata[]=["woredas_id"=>$woreda->id,"com_certificates_id"=>1];
                }

                woreda_certificate::where('woreda_certificates.woredas_id',$woreda->id)->delete();
                woreda_certificate::insert($certificatedata);
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

    public function showWoreda($id){
        $datefromval=0;
        $recdata=Woreda::findorFail($id);
        $count = prd_order::where('woredas_id',$id)->count();

        $createddate = Carbon::createFromFormat('Y-m-d H:i:s', $recdata->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $updateddate = Carbon::createFromFormat('Y-m-d H:i:s', $recdata->updated_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $data = Woreda::join('zones','woredas.zone_id','zones.id')
        ->join('regions','zones.Rgn_Id','regions.id')
        ->where('woredas.id', $id)->get(['woredas.*','zones.Zone_Name','regions.Rgn_Name','regions.id AS RegionId',DB::raw("'$createddate' AS CreatedDateTime"),DB::raw("'$updateddate' AS UpdatedDateTime")]);

        $woredacer= woreda_certificate::join('com_certificates','woreda_certificates.com_certificates_id','com_certificates.id')
        ->where('woreda_certificates.woredas_id',$id)->get(['woreda_certificates.*','com_certificates.Certification']);

        return response()->json(['woredadata'=>$data,'datefromval'=>$datefromval,'count'=>$count,'woredacer'=>$woredacer]);       
    }

    public function deleteWoreda(Request $request){
        $count = prd_order::where('woredas_id',$request->delRecId)->count();
        if($count==0){
            try{
                woreda_certificate::where('woredas_id',$request->delRecId)->delete();
                Woreda::where('id',$request->delRecId)->delete();
                return Response::json(['success' =>1]);
            }
            catch(Exception $e){
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($count>=1){
            return Response::json(['existerror' =>  465]);
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
