<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\Models\period;
use App\Models\perioddetail;
use App\Models\actions;
use Response;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Exception;


class PeriodController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            return view('registry.period')->renderSections()['content'];
        }
        else{
            return view('registry.period');
        }
    }

    public function periodlist()
    {
        $periods=DB::select('SELECT * FROM periods ORDER BY periods.id DESC');
        if(request()->ajax()) {
            return datatables()->of($periods)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $periodeditln='';
                $perioddeleteln='';

                if($user->can('Period-Edit')){
                    $periodeditln='<a class="dropdown-item editperiod" onclick="editperioddata('.$data->id.')" data-id="'.$data->id.'" title="Edit">
                        <i class="fa fa-edit"></i><span> Edit</span>  
                    </a>';
                }
                if($user->can('Period-Delete')){
                    $perioddeleteln='<a class="dropdown-item deleteperiod" data-id="'.$data->id.'" title="Delete">
                        <i class="fa fa-trash"></i><span> Delete</span>  
                    </a>';
                }

                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item periodInfo" data-id="'.$data->id.'" id="paymentinfo" title="Open period information page">
                        <i class="fa fa-info"></i><span> Info</span>  
                    </a>
                    '.$periodeditln.'
                    '.$perioddeleteln.'
                </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function store(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $headerid = $request->periodId;
        $findid = $request->periodId;
        $activecount = 0;
        $checkfirst = 0;
        $checksecond = 0;
        $curdate = Carbon::today()->toDateString();

        foreach ($request->row as $key => $value) {
            $dayidbeg = $value['vals'];
            $daynamebeg = $value['Days'];
            $firstfrombeg = $value['FirstHalfFrom'];
            $firsttobeg = $value['FirstHalfTo'];
            $secondfrombeg = $value['SecondHalfFrom'];
            $secondtobeg = $value['SecondHalfTo'];
            $remarksbeg = $value['Remark'];
            $statusbeg = $value['Statusval'];
            if($statusbeg == "Active"){
                if($firstfrombeg == null && $secondfrombeg == null){
                    $activecount += 1;
                }
                if($firstfrombeg != null || $secondfrombeg != null){
                    if($firstfrombeg != null && $firsttobeg == null){
                        $checkfirst += 1;
                    }
                    if($secondfrombeg != null && $secondtobeg == null){
                        $checksecond += 1;
                    }
                }
            }
        }

        $validator = Validator::make($request->all(), [
            'PeriodName' => ['required',Rule::unique('periods')->ignore($findid)],
            'status' => ['required'],
        ]);

        $rules = array(
            'row.*.FirstHalfFrom' => 'before:row.*.FirstHalfTo|nullable|date_format:H:i',
            'row.*.FirstHalfTo' => 'after:row.*.FirstHalfFrom|nullable|date_format:H:i',
            'row.*.SecondHalfFrom' => 'before:row.*.SecondHalfTo|nullable|date_format:H:i',
            'row.*.SecondHalfTo' => 'after:row.*.SecondHalfFrom|nullable|date_format:H:i',
            'row.*.Statusval' => 'required'
        );

        $v2 = Validator::make($request->all(), $rules);

        if ($validator->passes() && $v2->passes() && $request->row != null && $activecount == 0 && $checkfirst == 0 && $checksecond == 0){
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'PeriodName' => $request->PeriodName,
                    'Description' => $request->Description,
                    'Status' => $request->status,
                ];

                $DbData = period::where('id', $findid)->first();

                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $periods = period::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                foreach ($request->row as $key => $value){

                    $perioddetail = perioddetail::updateOrCreate([
                        'periods_id' => $periods->id,
                        'days_id' => $value['vals']
                    ],[
                        'periods_id' => $periods->id,
                        'days_id' => $value['vals'],
                        'Days' => $value['Days'],
                        'FirstHalfFrom' => $value['FirstHalfFrom'],
                        'FirstHalfTo' => $value['FirstHalfTo'],
                        'SecondHalfFrom' => $value['SecondHalfFrom'],
                        'SecondHalfTo' => $value['SecondHalfTo'],
                        'Remark' => $value['Remark'],
                        'Status' => $value['Statusval']
                    ]);
                }

                $actions = $findid == null ? "Created" : "Edited";
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $periods->id,
                    'pagename' => "period",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'rec_id' => $periods->id]);
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
            return Response::json(['emptyerror' => "error"]);
        }
        else if($activecount >= 1 || $checkfirst >= 1 || $checksecond >= 1){
            return Response::json(['activeerror' => "error"]);
        }
    }

    public function showperiod($id){
        $periodcnt = 0;
        $data = period::where('periods.id', $id)->get();

        $detdata = perioddetail::where('perioddetails.periods_id',$id)
        ->orderBy('perioddetails.days_id','asc')
        ->get(['perioddetails.id','perioddetails.periods_id','perioddetails.days_id','perioddetails.Days','perioddetails.Status',
            DB::raw('IFNULL(perioddetails.FirstHalfFrom,"") AS FirstHalfFrom'),DB::raw('IFNULL(perioddetails.FirstHalfTo,"") AS FirstHalfTo'),
            DB::raw('IFNULL(perioddetails.SecondHalfFrom,"") AS SecondHalfFrom'),DB::raw('IFNULL(perioddetails.SecondHalfTo,"") AS SecondHalfTo'),
            DB::raw('IFNULL(perioddetails.Remark,"") AS Remark')
        ]);

        $service_data = DB::select('SELECT COUNT(servicedetails.periods_id) AS ServiceCount FROM servicedetails WHERE servicedetails.periods_id='.$id);   
        $periodcnt = $service_data[0]->ServiceCount ?? 0;

        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"period")
            ->where('pageid',$id)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['periodlist' => $data,'detdata' => $detdata,'periodcnt' => $periodcnt,'activitydata' => $activitydata]);
    }

    public function deleteperiod(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->periodDelId;
        $periodcnt = 0;
        $checkgroupcnt = DB::select('SELECT COUNT(servicedetails.periods_id) AS ServiceCount FROM servicedetails WHERE servicedetails.periods_id='.$findid);   
        $periodcnt = $checkgroupcnt[0]->ServiceCount ?? 0;
        DB::beginTransaction();
        try{
            if($periodcnt >= 1){
                return Response::json(['errors' => 462]);
            }
            else if($periodcnt == 0){
                DB::table('perioddetails')->where('perioddetails.periods_id',$findid)->delete();
                DB::table('periods')->where('id',$findid)->delete();

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "period",
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
        }
        catch(Exception $e){
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function perioddetaillist($id)
    {
        $detailTable = DB::select('SELECT * FROM perioddetails WHERE perioddetails.periods_id='.$id.' ORDER BY perioddetails.days_id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->make(true);
    }

}
