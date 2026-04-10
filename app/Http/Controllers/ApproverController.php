<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Exception;
use Carbon\Carbon;
use App\Models\transaction;
use App\Models\requisition;
use App\Models\requisitiondetail;
use App\Models\transfer;
use App\Models\transferdetail;
use App\Models\store;
use App\Notifications\RealTimeNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class ApproverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
        if($request->ajax()) {
            return view('inventory.approver',['fiscalyears'=>$fiscalyears])->renderSections()['content'];
        }
        else{
            return view('inventory.approver',['fiscalyears'=>$fiscalyears]);
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

    public function showRequisitionDataApp()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $req=DB::select('SELECT requisitions.id,requisitions.Type,requisitions.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,requisitions.Date,requisitions.RequestedBy,requisitions.Status,requisitions.Purpose,requisitions.created_at FROM requisitions INNER JOIN stores as sstores ON requisitions.SourceStoreId=sstores.id INNER JOIN stores as dstores on requisitions.DestinationStoreId=dstores.id WHERE requisitions.fiscalyear='.$fiscalyr.' AND requisitions.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=3) ORDER BY requisitions.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn = '<a class="btn btn-icon btn-gradient-info btn-sm DocReqInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Show Detail Info"> <i class="fa fa-info"></i></a>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showTransferDataApp()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $req=DB::select('SELECT transfers.id,transfers.Type,transfers.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,transfers.Date,transfers.TransferBy,transfers.Status,transfers.Reason,transfers.created_at FROM transfers INNER JOIN stores as sstores ON transfers.SourceStoreId=sstores.id INNER JOIN stores as dstores on transfers.DestinationStoreId=dstores.id WHERE transfers.fiscalyear='.$fiscalyr.' AND transfers.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=3) ORDER BY transfers.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn = '<a class="btn btn-icon btn-gradient-info btn-sm DocTrInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Show Detail Info"> <i class="fa fa-info"></i></a>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showReqDataConApp($id)
    {
        $ids=$id;
        $reqHeader=DB::select('SELECT requisitions.id,requisitions.Type,requisitions.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,requisitions.Date,requisitions.PreparedBy,requisitions.RequestedBy,requisitions.Status,requisitions.Purpose,requisitions.created_at,requisitions.ApprovedBy,requisitions.ApprovedDate,requisitions.IssuedBy,requisitions.IssuedDate,requisitions.RejectedBy,requisitions.RejectedDate,requisitions.VoidBy,requisitions.VoidDate,requisitions.CommentedBy,requisitions.CommentedDate,requisitions.Memo FROM requisitions INNER JOIN stores as sstores ON requisitions.SourceStoreId=sstores.id INNER JOIN stores as dstores on requisitions.DestinationStoreId=dstores.id where requisitions.id='.$id);
        return response()->json(['reqHeader'=>$reqHeader]);       
    }

    public function showTrDataConApp($id)
    {
        $ids=$id;
        $trHeader=DB::select('SELECT transfers.id,transfers.Type,transfers.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,transfers.Date,transfers.TransferBy,transfers.Status,transfers.Reason,transfers.created_at,transfers.ApprovedBy,transfers.ApprovedDate,transfers.IssuedBy,transfers.IssuedDate,transfers.RejectedBy,transfers.RejectedDate,transfers.VoidBy,transfers.VoidDate,transfers.CommentedBy,transfers.CommentedDate,transfers.Memo FROM transfers INNER JOIN stores as sstores ON transfers.SourceStoreId=sstores.id INNER JOIN stores as dstores on transfers.DestinationStoreId=dstores.id where transfers.id='.$id);
        return response()->json(['trHeader'=>$trHeader]);       
    }

    public function showReqDetailDataApp($id)
    {
        $detailTable=DB::select('SELECT requisitiondetails.id,requisitiondetails.ItemId,requisitiondetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,requisitiondetails.Quantity,requisitiondetails.PartNumber,uoms.Name as UOM,requisitiondetails.Quantity,requisitiondetails.Memo FROM requisitiondetails INNER JOIN regitems ON requisitiondetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where requisitiondetails.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
           
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showTrAppDetailData($id)
    {
        $detailTable=DB::select('SELECT transferdetails.id,transferdetails.ItemId,transferdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,transferdetails.Quantity,transferdetails.PartNumber,uoms.Name as UOM,transferdetails.Quantity,transferdetails.Memo FROM transferdetails INNER JOIN regitems ON transferdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where transferdetails.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
           
            ->rawColumns(['action'])
            ->make(true);
    }

    public function approveCommReq(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->appId;
        $req=requisition::find($findid);
        $req->Status="Approved";
        $req->ApprovedBy=$user;
        $req->ApprovedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $req->save();
        return Response::json(['success' => '1']);
    }

    public function approveTransfer(Request $request)
    {
        $comparestorefy=0;
        $fiscalyears=null;
        $desfiscalyears=null;
        $fiscalyrcomp=null;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->apptrId;
        $tra=transfer::find($findid);
        $storeid=$tra->	SourceStoreId;
        $desstoreid=$tra->DestinationStoreId;

        if($storeid!=null){
            $strdata=store::findorFail($storeid);
            $fiscalyears=$strdata->FiscalYear;
        }

        if($desstoreid!=null){
            $desstrdata=store::findorFail($desstoreid);
            $desfiscalyears=$desstrdata->FiscalYear;
        }

        if($fiscalyears!=$desfiscalyears){
            $comparestorefy=1;
        }

        if($comparestorefy>=1){
            return Response::json(['differencefy'=>1]);
        }
        
        else if($comparestorefy==0){
            $tra->Status="Approved";
            $tra->ApprovedBy= $user;
            //$tra->ApprovedDate=Carbon::today()->toDateString();
            $tra->ApprovedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $tra->save();
            $reqby=$tra->TransferBy;
            
            $userstable = DB::table('users')->where('username', $reqby)->latest()->first();
            $userids=$userstable->id;

            $usersIssue = User::join('storeassignments', 'storeassignments.UserId', '=', 'users.id')
            ->where(['storeassignments.StoreId' => $storeid,'storeassignments.Type'=>2])
            ->get(['users.*']);

            $user2=User::find($userids);
            // try 
            // { 
            //     Notification::send($user2, new RealTimeNotification($user." Approved Your Requistion",'Approved'));
            //     Notification::send($usersIssue, new RealTimeNotification($user." Approved ".$reqby." Requistion",'Issue'));
            // } 
            // catch(\Exception $e)
            // {}
            
            return Response::json(['success' => '1']);
        }
    }
    public function commentRequisition(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->commentid;
        $req=requisition::find($findid);
        $validator = Validator::make($request->all(), [
            'Comment'=>"required",
        ]);
        if ($validator->passes()) 
        {
            $req->Status="Commented";
            $req->CommentedBy=$user;
            //$req->CommentedDate=Carbon::today()->toDateString();
            $req->CommentedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $req->Memo=trim($request->input('Comment'));
            $req->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function commentTransfer(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->commenttrid;
        $tra=transfer::find($findid);
        $validator = Validator::make($request->all(), [
            'Comment'=>"required",
        ]);
        if ($validator->passes()) 
        {
            $tra->Status="Commented";
            $tra->CommentedBy=$user;
            //$tra->CommentedDate=Carbon::today()->toDateString();
            $tra->CommentedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $tra->Memo=trim($request->input('Comment'));
            $tra->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function rejectRequisition(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->rejId;
        $req=requisition::find($findid);
        $req->Status="Rejected";
        $req->RejectedBy= $user;
        //$req->RejectedDate=Carbon::today()->toDateString();
        $req->RejectedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $req->save();
        return Response::json(['success' => '1']);
    }

    public function rejectTransfer(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->rejtrId;
        $tra=transfer::find($findid);
        $tra->Status="Rejected";
        $tra->RejectedBy=$user;
        //$tra->RejectedDate=Carbon::today()->toDateString();
        $tra->RejectedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $tra->save();
        return Response::json(['success' => '1']);
    }

    public function requisitiondataappfy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $req=DB::select('SELECT requisitions.id,requisitions.Type,requisitions.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,requisitions.Date,requisitions.RequestedBy,requisitions.Status,requisitions.Purpose,requisitions.created_at FROM requisitions INNER JOIN stores as sstores ON requisitions.SourceStoreId=sstores.id INNER JOIN stores as dstores on requisitions.DestinationStoreId=dstores.id WHERE requisitions.fiscalyear='.$fy.' AND requisitions.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=3) ORDER BY requisitions.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn = '<a class="btn btn-icon btn-gradient-info btn-sm DocReqInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Show Detail Info"> <i class="fa fa-info"></i></a>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function transferDataShowfy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $req=DB::select('SELECT transfers.id,transfers.Type,transfers.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,transfers.Date,transfers.TransferBy,transfers.Status,transfers.Reason,transfers.created_at FROM transfers INNER JOIN stores as sstores ON transfers.SourceStoreId=sstores.id INNER JOIN stores as dstores on transfers.DestinationStoreId=dstores.id WHERE transfers.fiscalyear='.$fy.' AND transfers.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=3) ORDER BY transfers.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn = '<a class="btn btn-icon btn-gradient-info btn-sm DocTrInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Show Detail Info"> <i class="fa fa-info"></i></a>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
