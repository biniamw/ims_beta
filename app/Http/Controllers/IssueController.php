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
use App\Models\issue;
use App\Models\transferdetail;
use App\Models\store;
use App\Models\actions;
use App\Notifications\RealTimeNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class IssueController extends Controller
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
        $users=DB::select('select * from users where id>1 order by username asc');
        if($request->ajax()) {
            return view('inventory.issue',['users'=>$users,'fiscalyears'=>$fiscalyears])->renderSections()['content'];
        }
        else{
            return view('inventory.issue',['users'=>$users,'fiscalyears'=>$fiscalyears]);
        } 
    }

    public function showIssueUser($str)
    {
        $iuser=DB::select('SELECT storeassignments.UserId,users.username AS UserName FROM storeassignments INNER JOIN users ON storeassignments.UserId=users.id WHERE storeassignments.StoreId=(SELECT id FROM stores WHERE stores.Name="'.$str.'") AND storeassignments.Type=2 AND users.Status="Active" AND storeassignments.UserId!=1');
        return response()->json(['iuser'=>$iuser]);  
    }

    public function showRequisitionDataIss()
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $req=DB::select('SELECT requisitions.id,requisitions.Type,requisitions.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,requisitions.Date,requisitions.RequestedBy,requisitions.ApprovedBy,requisitions.Status,requisitions.Purpose,requisitions.created_at FROM requisitions INNER JOIN stores as sstores ON requisitions.SourceStoreId=sstores.id INNER JOIN stores as dstores on requisitions.DestinationStoreId=dstores.id WHERE requisitions.Status="Approved" AND requisitions.fiscalyear='.$fiscalyr.' AND requisitions.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=2) ORDER BY requisitions.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn = '<a class="btn btn-icon btn-gradient-info btn-sm DocReqInfoApp" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Show Detail Info"> <i class="fa fa-info"></i></a>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showIssueDataApp()
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $iss=DB::select('SELECT issues.id,issues.Type,issues.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,issues.Date,issues.RequestedBy,issues.ApprovedBy,issues.Status,issues.Purpose,issues.created_at FROM issues INNER JOIN stores as sstores ON issues.SourceStoreId=sstores.id INNER JOIN stores as dstores on issues.DestinationStoreId=dstores.id WHERE issues.Type!="Transfer" AND issues.fiscalyear='.$fiscalyr.' AND issues.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=2) ORDER BY issues.id DESC');
        if(request()->ajax()) {
            return datatables()->of($iss)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                      <a class="dropdown-item DocReqInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="mediumButton" title="Show Detail Info"> 
                          <i class="fa fa-info"></i><span> Info</span>
                      </a>
                      <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/iss/'.$data->id.'" id="printSIV" data-attr="" title="Print Store Issue Voucher Attachment"><i class="fa fa-file"></i><span> Print SIV</span></a>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showIssueDataStiv()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $iss=DB::select('SELECT issues.id,issues.Type,issues.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,issues.Date,issues.RequestedBy,issues.ApprovedBy,issues.Status,issues.Purpose,issues.created_at FROM issues INNER JOIN stores as sstores ON issues.SourceStoreId=sstores.id INNER JOIN stores as dstores on issues.DestinationStoreId=dstores.id WHERE issues.Type="Transfer" AND issues.fiscalyear='.$fiscalyr.' AND issues.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=2) ORDER BY issues.id DESC');
        if(request()->ajax()) {
            return datatables()->of($iss)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                      <a class="dropdown-item DocReqInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="mediumButton" title="Show Detail Info"> 
                          <i class="fa fa-info"></i><span> Info</span>
                      </a>
                      <a class="dropdown-item printTrIssueAttachment" href="javascript:void(0)" data-link="/isstr/'.$data->id.'" id="printSTIV" data-attr="" title="Print Store Transfer Issue Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>
                </div>';
                  return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showTransferIssDataApp()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $req=DB::select('SELECT transfers.id,transfers.Type,transfers.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,transfers.Date,transfers.TransferBy,transfers.ApprovedBy,transfers.Status,transfers.Reason,transfers.created_at FROM transfers INNER JOIN stores as sstores ON transfers.SourceStoreId=sstores.id INNER JOIN stores as dstores on transfers.DestinationStoreId=dstores.id WHERE transfers.Status="Approved" AND transfers.fiscalyear='.$fiscalyr.' AND transfers.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=2) ORDER BY transfers.id DESC');
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

    public function showReqDataConApproving($id)
    {
        $ids=$id;
        $reqHeader=DB::select('SELECT requisitions.id,requisitions.Type,requisitions.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,requisitions.Date,requisitions.RequestedBy,requisitions.ApprovedBy,requisitions.ApprovedDate,requisitions.Status,requisitions.Purpose,requisitions.created_at FROM requisitions INNER JOIN stores as sstores ON requisitions.SourceStoreId=sstores.id INNER JOIN stores as dstores on requisitions.DestinationStoreId=dstores.id where requisitions.id='.$id);
        return response()->json(['reqHeader'=>$reqHeader]);       
    }

    public function showReqDataConIss($id)
    {
        $ids=$id;
        $issHeader=DB::select('SELECT issues.id,issues.Type,issues.DocumentNumber,issues.ReqDocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,issues.Date,issues.PreparedBy,issues.RequestedBy,issues.ApprovedBy,issues.IssuedBy,issues.Status,issues.Purpose,issues.created_at FROM issues INNER JOIN stores as sstores ON issues.SourceStoreId=sstores.id INNER JOIN stores as dstores on issues.DestinationStoreId=dstores.id where issues.id='.$id);
        return response()->json(['issHeader'=>$issHeader]);       
    }

    public function showIssueDetailDataIss($id)
    {
        $detailTable=DB::select('SELECT issuedetails.id,issuedetails.ItemId,issuedetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,issuedetails.Quantity,issuedetails.PartNumber,uoms.Name as UOM,issuedetails.Quantity,issuedetails.Memo,issuedetails.SerialnumIds,regitems.RequireSerialNumber,regitems.RequireExpireDate,COALESCE(CONCAT((SELECT GROUP_CONCAT(BatchNumber," ") FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,issuedetails.SerialnumIds))),"") AS BatchNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT(SerialNumber," ") FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,issuedetails.SerialnumIds))),"") AS SerialNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT(ExpireDate," ") FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,issuedetails.SerialnumIds))),"") AS ExpireDate,COALESCE(CONCAT((SELECT GROUP_CONCAT(ManufactureDate," ") FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,issuedetails.SerialnumIds))),"") AS ManufactureDate,(SELECT COUNT(id) FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,issuedetails.SerialnumIds)) AS InsertedQty FROM issuedetails INNER JOIN regitems ON issuedetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where issuedetails.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showTrIssDataCon($id)
    {
        $ids=$id;
        $trHeader=DB::select('SELECT transfers.id,transfers.Type,transfers.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,transfers.Date,transfers.TransferBy,transfers.Status,transfers.Reason,transfers.created_at,transfers.ApprovedBy,transfers.ApprovedDate,transfers.IssuedBy,transfers.IssuedDate,transfers.RejectedBy,transfers.RejectedDate,transfers.VoidBy,transfers.VoidDate FROM transfers INNER JOIN stores as sstores ON transfers.SourceStoreId=sstores.id INNER JOIN stores as dstores on transfers.DestinationStoreId=dstores.id where transfers.id='.$id);
        return response()->json(['trHeader'=>$trHeader]);       
    }

    public function showTrIssAppDetailData($id)
    {
        $detailTable=DB::select('SELECT transferdetails.id,transferdetails.ItemId,transferdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,transferdetails.Quantity,transferdetails.PartNumber,uoms.Name AS UOM,transferdetails.Quantity,transferdetails.StoreId,transferdetails.Memo,transferdetails.SerialnumIds,regitems.RequireSerialNumber,regitems.RequireExpireDate,COALESCE(CONCAT((SELECT GROUP_CONCAT(BatchNumber," ") FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,transferdetails.SerialnumIds))),"") AS BatchNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT(SerialNumber," ") FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,transferdetails.SerialnumIds))),"") AS SerialNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT(ExpireDate," ") FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,transferdetails.SerialnumIds))),"") AS ExpireDate,COALESCE(CONCAT((SELECT GROUP_CONCAT(ManufactureDate," ") FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,transferdetails.SerialnumIds))),"") AS ManufactureDate,(SELECT COUNT(id) FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,transferdetails.SerialnumIds)) AS InsertedQty FROM transferdetails INNER JOIN regitems ON transferdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where transferdetails.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {  
            $btn="";
            if($data->RequireSerialNumber=='Not-Require' && $data->RequireExpireDate=='Not-Require'){
                $btn="";
            }
            else{
                $btn =  ' <a data-id="'.$data->id.'" data-itemid="'.$data->ItemId.'" data-itemname="'.$data->ItemName.'" data-storeid="'.$data->StoreId.'" data-serids="'.$data->SerialnumIds.'" data-reqed="'.$data->RequireExpireDate.'" data-reqsn="'.$data->RequireSerialNumber.'" class="btn btn-icon btn-gradient-info btn-sm addserialnum" data-toggle="modal" id="mediumButton" style="color: white;" title="Add serial number, batch number or expire date"><i class="fa fa-plus"></i></a>';
            }     
            return $btn;
        })   
        ->rawColumns(['action'])
        ->make(true);
    }

    public function issueRequisition(Request $request)
    {
        $comparestorefy=0;
        $fiscalyears=null;
        $fiscalyrcomp=null;
        $desfiscalyears=null;
        $isstype="Transfer";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;

        $findid=$request->issueId;
        $reqcon = DB::table('requisitions')->where('id', $findid)->latest()->first();
        $storeId=$reqcon->SourceStoreId;
        if($storeId!=null){
            $strdata=store::findorFail($storeId);
            $fiscalyears=$strdata->FiscalYear;
        }

        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $fiscalyrcomp=$settingsval->FiscalYear;

        if($storeId!=null && $fiscalyr==$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $issuepr=$settingsval->IssuePrefix;
            $issuenum=$settingsval->IssueNumber;
            $fiscalyr=$settingsval->FiscalYear;
        }

        if($storeId!=null && $fiscalyr!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $issueprop = DB::table('issues')->where('fiscalyear',$fiscalyears)->where('Type','!=',$isstype)->orderBy('id', 'desc')->first();
            $docdata=$issueprop->DocumentNumber;
            $issuepr = preg_replace('/[^a-zA-Z]/m','',$docdata);
            $numbersfor = preg_replace('/\D/', '', $docdata);
            $numbersfor = substr($numbersfor, 0, 6);
            $issuenum=$numbersfor+1;
            $fiscalyr=$fiscalyears;
        }
       
        $suffixdoc=$fiscalyr-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $issuenum);
        $issuedocnum=$issuepr.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        
        $docnum=$reqcon->DocumentNumber;
        $comm=$reqcon->Common;
        
        $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM requisitiondetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
        foreach($getApprovedQuantity as $row)
        {
            $avaq=$row->ApprovedItems;
        }
       
        $avaqp = (float)$avaq;
        if($avaqp>=1)
        {
            $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.') AS AvailableQuantity FROM requisitiondetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND 
            (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
            return Response::json(['valerror' => "error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
        }
        else
        {
            $currentdatetime=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            
            $syncToIssue=DB::select('INSERT INTO issues(ReqDocumentNumber,ReqId,Type,SourceStoreId,DestinationStoreId,Purpose,RequestedBy,RequestDate,AuthorizedBy,AuthorizedDate,ApprovedBy,ApprovedDate,ReceivedBy,ReceivedDate,CommentedBy,CommentedDate,RejectedBy,RejectedDate,Memo,Common,fiscalyear,DocumentNumber,IssuedBy,IssuedDate,PreparedBy,PreparedDate,Status,Date)SELECT DocumentNumber,id,Type,SourceStoreId,DestinationStoreId,Purpose,RequestedBy,RequestDate,AuthorizedBy,AuthorizedDate,ApprovedBy,ApprovedDate,ReceivedBy,ReceivedDate,CommentedBy,CommentedDate,RejectedBy,RejectedDate,Memo,Common,fiscalyear,"'.$issuedocnum.'","'.$user.'","'.$currentdatetime.'","'.$user.'","'.$currentdatetime.'","Issued","'.$currentdatetime.'" FROM requisitions WHERE requisitions.id='.$findid);

            $issdetail = DB::table('issues')->where('ReqId', $findid)->where('Type','!=','Transfer')->latest()->first();
            $ids=$issdetail->id;
            $types=$issdetail->Type;
            $issuetype="Requisition , ".$types;

            $syncToIssueDetail=DB::select('INSERT INTO issuedetails(HeaderId,ReqHeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,DestStoreId,LocationId,RetailerPrice,Wholeseller,Date,RequireSerialNumber,RequireExpireDate,ConvertedQuantity,ConversionAmount,NewUOMId,DefaultUOMId,ItemType,PartNumber,Memo,Common,TransactionType)SELECT '.$ids.',HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,DestStoreId,LocationId,RetailerPrice,Wholeseller,Date,RequireSerialNumber,RequireExpireDate,ConvertedQuantity,ConversionAmount,NewUOMId,DefaultUOMId,ItemType,PartNumber,Memo,Common,TransactionType FROM requisitiondetails WHERE requisitiondetails.HeaderId='.$findid);

            $issid=$issdetail->id;
            $issdocnums=$issdetail->DocumentNumber;
            $reqdocnum=$issdetail->ReqDocumentNumber;

            $syncToTransactionInData=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,TaxAmountPrice,TotalPrice,StoreId,TransactionType,ItemType,DocumentNumber,TransactionsType,FiscalYear,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,ItemType,"'.$issdocnums.'","Requisition","'.$fiscalyr.'","'.Carbon::now().'" FROM issuedetails WHERE issuedetails.HeaderId='.$issid);
       
            DB::table('requisitions')
            ->where('id',$findid)
            ->update(['IssueDocNumber'=>$issuedocnum,'IssueId'=>$ids,'Status' => "Issued",'IssuedBy'=>$user,'IssuedDate'=>$currentdatetime]);

            if($fiscalyr == $fiscalyrcomp){
                $updn=DB::select('update settings set IssueNumber=IssueNumber+1 where id=1');
            }
            return Response::json(['success' => '1','issueId'=>$ids,'ApprovedQuantity'=>$getApprovedQuantity,'AvailableQuantity'=>$issid]);
        }
    }

    public function issueTransfer(Request $request)
    {
        $comparestorefy=0;
        $fiscalyears=null;
        $fiscalyrcomp=null;
        $desfiscalyears=null;
        $isstype="Transfer";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->issuetrId;
        $reqcon = DB::table('transfers')->where('id', $findid)->latest()->first();
        $storeId=$reqcon->SourceStoreId;
        $desstoreId=$reqcon->DestinationStoreId;
        $allreqitem=0;
        $nonappitem=0;
        $avaqp = 0;
        $strdt=store::findorFail($storeId);
        $qtyflg=$strdt->QtyOnHandFlag ?? 0;
        if($storeId!=null){
            $strdata=store::findorFail($storeId);
            $fiscalyears=$strdata->FiscalYear;
        }

        if($desstoreId!=null){
            $desstrdata=store::findorFail($desstoreId);
            $desfiscalyears=$desstrdata->FiscalYear;
        }

        $issuedbyuser=$request->IssuedByUser;
        $deliveredbyuser=$request->DelivereddByUser;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $fiscalyrcomp=$settingsval->FiscalYear;

        if($storeId!=null && $fiscalyr==$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $issuepr=$settingsval->TransferIssuePrefix;
            $issuenum=$settingsval->TransferIssueNumber;
            $fiscalyr=$settingsval->FiscalYear;
        }

        if($storeId!=null && $fiscalyr!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $issueprop = DB::table('issues')->where('fiscalyear',$fiscalyears)->where('Type',$isstype)->orderBy('id', 'desc')->first();
            $docdata=$issueprop->DocumentNumber;
            $issuepr = preg_replace('/[^a-zA-Z]/m','',$docdata);
            $numbersfor = preg_replace('/\D/', '', $docdata);
            $numbersfor = substr($numbersfor, 0, 5);
            $issuenum=$numbersfor+1;
            $fiscalyr=$fiscalyears;
        }
        
        $suffixdoc=$fiscalyr-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $issuenum);
        $issuedocnum=$issuepr.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        
        $docnum=$reqcon->DocumentNumber;
        $comm=$reqcon->Common;

        if($fiscalyears!=$desfiscalyears){
            $comparestorefy=1;
        }

        $getAllIds=DB::select('SELECT COALESCE(GROUP_CONCAT(transferdetails.SerialnumIds,""),"0") AS AllIds FROM transferdetails WHERE HeaderId='.$findid.'');
        foreach($getAllIds as $row)
        {
            $allids[]=$row->AllIds;
        }
        $serids=implode(",",$allids);

        $getIssuedSerialNum=DB::select('SELECT COUNT(item_id) AS ItemCount FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,"'.$serids.'") AND store_id!='.$storeId.'');
        foreach($getIssuedSerialNum as $row)
        {
            $serialcnt=$row->ItemCount;
        }

        $getSerCount=DB::select('SELECT COUNT(ItemId) AS ItemCount FROM transferdetails INNER JOIN regitems ON transferdetails.ItemId=regitems.id WHERE HeaderId='.$findid.' AND transferdetails.Quantity!=(SELECT COUNT(id) FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,transferdetails.SerialnumIds)) AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require")');
        foreach($getSerCount as $row)
        {
            $availser=$row->ItemCount;
        }

        $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM transferdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
        foreach($getApprovedQuantity as $row)
        {
            $avaq=$row->ApprovedItems;
        }

        $getAllReqItem=DB::select('SELECT COUNT(transferdetails.ItemId) AS AllReqItem FROM transferdetails WHERE transferdetails.HeaderId='.$findid);
        $allreqitem=$getAllReqItem[0]->AllReqItem ?? 0;

        $getNonAppItem=DB::select('SELECT COUNT(transferdetails.ItemId) AS NonApprovedItem FROM transferdetails WHERE transferdetails.ApprovedQuantity=0 AND transferdetails.HeaderId='.$findid);
        $nonappitem=$getNonAppItem[0]->NonApprovedItem ?? 0;

        $serialcntnm = (float)$serialcnt;
        $availsernm = (float)$availser;

        
        if($qtyflg==1){
            $avaqp = 0;
        }
        else if($qtyflg!=1){
            $avaqp = (float)$avaq;
        }

        if($avaqp>=1)
        {
            $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.') AS AvailableQuantity FROM transferdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND 
            (SELECT COALESCE((SELECT SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
            return Response::json(['valerror' =>  "error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
        }
        else if($availsernm>=1)
        {
            $getSerItemLists=DB::select('SELECT regitems.Name AS ItemName FROM transferdetails INNER JOIN regitems ON transferdetails.ItemId=regitems.id WHERE HeaderId='.$findid.' AND transferdetails.Quantity!=(SELECT COUNT(id) FROM serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,transferdetails.SerialnumIds)) AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require")');
            return Response::json(['sererror' =>  "error",'countedserval'=>$availsernm,'countSerItems'=>$getSerItemLists]);
        }
        else if($serialcntnm>=1){
            $getIssuedserialnumlist=DB::select('SELECT CONCAT(COALESCE(regitems.Name,"")," , ",COALESCE(serialandbatchnums.BatchNumber,""),"  , ",COALESCE(serialandbatchnums.SerialNumber,"")," , ",COALESCE(serialandbatchnums.ExpireDate,"")," ",COALESCE(serialandbatchnums.ManufactureDate,"")) AS AllValues FROM serialandbatchnums INNER JOIN regitems ON serialandbatchnums.item_id=regitems.id WHERE FIND_IN_SET(serialandbatchnums.id,"'.$serids.'") AND store_id!='.$storeId.'');
            return Response::json(['serisserror' =>  "error",'countedisserval'=>$serialcntnm,'countisSerItems'=>$getIssuedserialnumlist]);
        }
        else if($comparestorefy>=1){
            return Response::json(['differencefy'=>1]);
        }
        else if($allreqitem == $nonappitem){
            return Response::json(['appdiscrepancy'=>1]);
        }
        else
        {
            $issDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $syncToIssue=DB::select('INSERT INTO issues(ReqDocumentNumber,ReqId,Type,SourceStoreId,DestinationStoreId,Purpose,RequestedBy,RequestDate,AuthorizedBy,AuthorizedDate,ApprovedBy,ApprovedDate,ReceivedBy,ReceivedDate,CommentedBy,CommentedDate,RejectedBy,RejectedDate,Memo,Common,fiscalyear,DocumentNumber,IssuedBy,IssuedDate,PreparedBy,PreparedDate,Status,Date,DeliveredBy,DeliveredDate)SELECT DocumentNumber,id,Type,SourceStoreId,DestinationStoreId,Reason,TransferBy,TransferDate,AuthorizedBy,AuthorizedDate,ApprovedBy,ApprovedDate,ReceivedBy,ReceivedDate,CommentedBy,CommentedDate,RejectedBy,RejectedDate,Memo,Common,fiscalyear,"'.$issuedocnum.'","'.$issuedbyuser.'","'.$issDate.'","'.$user.'","'.$issDate.'","Issued","'.$issDate.'","'.$deliveredbyuser.'","'.$issDate.'" FROM transfers WHERE transfers.id='.$findid);

            $issdetail = DB::table('issues')->where('ReqId',$findid)->where('Type','=','Transfer')->latest()->first();
            $ids=$issdetail->id;
            $issid=$issdetail->id;
            $issdocnums=$issdetail->DocumentNumber;
            $reqdocnum=$issdetail->ReqDocumentNumber;

            $syncToIssueDetail=DB::select('INSERT INTO issuedetails(HeaderId,ReqHeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,DestStoreId,LocationId,RetailerPrice,Wholeseller,Date,RequireSerialNumber,RequireExpireDate,ConvertedQuantity,ConversionAmount,NewUOMId,DefaultUOMId,ItemType,PartNumber,Memo,Common,TransactionType,SerialnumIds)SELECT '.$ids.',HeaderId,ItemId,ApprovedQuantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,DestStoreId,LocationId,RetailerPrice,Wholeseller,Date,RequireSerialNumber,RequireExpireDate,ConvertedQuantity,ConversionAmount,NewUOMId,DefaultUOMId,ItemType,PartNumber,Memo,Common,TransactionType,SerialnumIds FROM transferdetails WHERE transferdetails.ApprovedQuantity>0 AND transferdetails.HeaderId='.$findid);

            $syncToTransactionInData=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,TaxAmountPrice,TotalPrice,StoreId,TransactionType,ItemType,DocumentNumber,TransactionsType,FiscalYear,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,ItemType,"'.$issdocnums.'","Issue","'.$fiscalyr.'","'.Carbon::today()->toDateString().'" FROM issuedetails WHERE issuedetails.HeaderId='.$issid);

            // $syncToTransactionOutData=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,DocumentNumber,TransactionsType,FiscalYear,Date,IsOnShipment,ShipmentQuantity)SELECT HeaderId,ItemId,"NULL",UnitCost,BeforeTaxCost,TaxAmount,TotalCost,DestStoreId,TransactionType,ItemType,"'.$reqdocnum.'","Transfer","'.$fiscalyr.'","'.Carbon::today()->toDateString().'","1",Quantity FROM issuedetails WHERE issuedetails.HeaderId='.$issid);

            $updateIssuedItem=DB::select('UPDATE transferdetails SET transferdetails.IssuedQuantity=transferdetails.ApprovedQuantity WHERE transferdetails.ApprovedQuantity>0 AND transferdetails.HeaderId='.$findid);

            DB::table('transfers')
            ->where('id',$findid)
            ->update(['IssueDocNumber'=>$issdocnums,'IssueId'=>$issid,'Status'=>"Issued",'IssuedBy'=>$user,'IssuedDate'=>$issDate,'DeliveredBy'=>$deliveredbyuser,'DeliveredDate'=>$issDate]);
            
            if($fiscalyr==$fiscalyrcomp){
                $updn=DB::select('update settings set TransferIssueNumber=TransferIssueNumber+1 where id=1');
            }

            $updateSerialNumIssue=DB::select('UPDATE serialandbatchnums SET store_id='.$desstoreId.' WHERE FIND_IN_SET(serialandbatchnums.id,"'.$serids.'")');
            $syncToSerialNumberHistory=DB::select('INSERT INTO serialnumberhistories(serialnumheader_id,transactionheader_id,DocumentNumber,TransactionType,TransactionDate)SELECT id,'.$findid.',"'.$reqdocnum.'","3","'.Carbon::today()->toDateString().'" from serialandbatchnums WHERE FIND_IN_SET(serialandbatchnums.id,"'.$serids.'")');
            $users2 = User::join('storeassignments', 'storeassignments.UserId', '=', 'users.id')
            ->where(['storeassignments.StoreId' => $storeId,'storeassignments.Type'=>3])
            ->get(['users.*']);

            actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"transfer",'action'=>"Issued",'status'=>"Issued",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

            try 
            { 
                $url='/issue';
                Notification::send($users2, new RealTimeNotification($user,$user." Issue Store Requistion",'Issue',$url));
            } 
            catch(\Exception $e)
            {}

            return Response::json(['success' => '1','issueId'=>$ids,'ApprovedQuantity'=>'1','header'=>$findid,'store'=>$storeId,'fiscal'=>$fiscalyr,'val'=>$avaqp,'serids'=>$serids,'date'=>$issDate]);
        }
    }

    public function receiveTransfer(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->receivetrId;
        $transfer="Transfer";
        $issuecn = DB::table('issues')->where('ReqId',$findid)->where('Type',$transfer)->latest()->first();
        $issueid=$issuecn->id;
        $updatetransactions=DB::select('update transactions set StockIn=ShipmentQuantity,IsOnShipment=0,ShipmentQuantity=0 where TransactionsType="'.$transfer.'" AND HeaderId='.$issueid.'');
        DB::table('transfers')
        ->where('id',$findid)
        ->update(['Status'=>"Issued(Received)",'ReceivedBy'=>$user,'ReceivedDate'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A')]);
        return Response::json(['success' => '1']);
    }

    public function showTransferSerialNum($id)
    {
        $ids=$id;
        $trdetail=DB::select('SELECT transferdetails.id,transferdetails.ItemId,transferdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,transferdetails.Quantity,transferdetails.PartNumber,uoms.Name as UOM,transferdetails.Quantity,transferdetails.StoreId,transferdetails.Memo,transferdetails.SerialnumIds,regitems.RequireSerialNumber,regitems.RequireExpireDate FROM transferdetails INNER JOIN regitems ON transferdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where transferdetails.id='.$id);
        return response()->json(['trdetail'=>$trdetail]);       
    }

    public function getIssueSerNum($itemid,$storeid,$sernum)
    {
        $sn="";
        $sernumber=str_replace('"', '', $sernum); 
        $serialNumbers=DB::select('SELECT id,CONCAT("Batch# : ",COALESCE(BatchNumber,"")," Serial# : ",COALESCE(SerialNumber,"")," ExpireDate : ",COALESCE(ExpireDate,"")," Manfc.Date : ",COALESCE(ManufactureDate,"")) AS AllValues FROM serialandbatchnums WHERE serialandbatchnums.item_id='.$itemid.' AND serialandbatchnums.store_id='.$storeid.' AND serialandbatchnums.id NOT IN(COALESCE('.$sernumber.',0)) AND serialandbatchnums.IsConfirmed=1 AND serialandbatchnums.IsSold=0 AND IsIssued=0');
        return response()->json(['serialNumbers'=>$serialNumbers,'s'=>$sernumber,'q'=>$sn]);
    }

    public function getIssueSerNumSl($itemid,$storeid,$sernum)
    {
        $sernumber=str_replace('"', '', $sernum);
        $serialNumbersSl=DB::select('SELECT id,CONCAT("Batch# : ",COALESCE(BatchNumber,"")," Serial# : ",COALESCE(SerialNumber,"")," ExpireDate : ",COALESCE(ExpireDate,"")," Manfc.Date : ",COALESCE(ManufactureDate,"")) AS AllValues FROM serialandbatchnums WHERE serialandbatchnums.item_id='.$itemid.' AND serialandbatchnums.store_id='.$storeid.' AND serialandbatchnums.id IN('.$sernumber.') AND serialandbatchnums.IsConfirmed=1 AND serialandbatchnums.IsSold=0 AND IsIssued=0');
        return response()->json(['serialNumbersSl'=>$serialNumbersSl,'s'=>$sernum,'q'=>$sernumber]);
    }

    public function saveIssueSerialnumber(Request $request)
    {
        $findid=$request->recids;
        $trs=transferdetail::find($findid);
        $validator = Validator::make($request->all(), [
            'SerialNumber'=>"required",
        ]);
        if ($validator->passes()) 
        {
            $ser=$request->SerialNumber;
            $sern=implode(",",$ser);
            $trs->SerialnumIds=$sern;
            $trs->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function issuedataissfy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $req=DB::select('SELECT requisitions.id,requisitions.Type,requisitions.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,requisitions.Date,requisitions.RequestedBy,requisitions.ApprovedBy,requisitions.Status,requisitions.Purpose,requisitions.created_at FROM requisitions INNER JOIN stores as sstores ON requisitions.SourceStoreId=sstores.id INNER JOIN stores as dstores on requisitions.DestinationStoreId=dstores.id WHERE requisitions.Status="Approved" AND requisitions.fiscalyear='.$fy.' AND requisitions.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=2) ORDER BY requisitions.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn = '<a class="btn btn-icon btn-gradient-info btn-sm DocReqInfoApp" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Show Detail Info"> <i class="fa fa-info"></i></a>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function issuedataappfy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $iss=DB::select('SELECT issues.id,issues.Type,issues.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,issues.Date,issues.RequestedBy,issues.ApprovedBy,issues.Status,issues.Purpose,issues.created_at FROM issues INNER JOIN stores as sstores ON issues.SourceStoreId=sstores.id INNER JOIN stores as dstores on issues.DestinationStoreId=dstores.id WHERE issues.Type!="Transfer" AND issues.fiscalyear='.$fy.' AND issues.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=2) ORDER BY issues.id DESC');
        if(request()->ajax()) {
            return datatables()->of($iss)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                      <a class="dropdown-item DocReqInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="mediumButton" title="Show Detail Info"> 
                          <i class="fa fa-info"></i><span> Info</span>
                      </a>
                      <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/iss/'.$data->id.'" id="printSIV" data-attr="" title="Print Store Issue Voucher Attachment">
                          <i class="fa fa-file"></i><span> Print SIV</span>
                      </a>
                </div>';
                  return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function issuedatastivfy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $iss=DB::select('SELECT issues.id,issues.Type,issues.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,issues.Date,issues.RequestedBy,issues.ApprovedBy,issues.Status,issues.Purpose,issues.created_at FROM issues INNER JOIN stores as sstores ON issues.SourceStoreId=sstores.id INNER JOIN stores as dstores on issues.DestinationStoreId=dstores.id WHERE issues.Type="Transfer" AND issues.fiscalyear='.$fy.' AND issues.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=2) ORDER BY issues.id DESC');
        if(request()->ajax()) {
            return datatables()->of($iss)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                      <a class="dropdown-item DocReqInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="mediumButton" title="Show Detail Info"> 
                          <i class="fa fa-info"></i><span> Info</span>
                      </a>
                      <a class="dropdown-item printTrIssueAttachment" href="javascript:void(0)" data-link="/isstr/'.$data->id.'" id="printSTIV" data-attr="" title="Print Store Transfer Issue Voucher Attachment">
                          <i class="fa fa-file"></i><span> Print STIV</span>
                      </a>
                </div>';
                  return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function transferIssDataShowfy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $req=DB::select('SELECT transfers.id,transfers.Type,transfers.DocumentNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,transfers.Date,transfers.TransferBy,transfers.ApprovedBy,transfers.Status,transfers.Reason,transfers.created_at FROM transfers INNER JOIN stores as sstores ON transfers.SourceStoreId=sstores.id INNER JOIN stores as dstores on transfers.DestinationStoreId=dstores.id WHERE transfers.Status="Approved" AND transfers.fiscalyear='.$fy.' AND transfers.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=2) ORDER BY transfers.id DESC');
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
