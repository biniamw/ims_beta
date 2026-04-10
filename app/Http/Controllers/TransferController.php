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
use App\Models\transfer;
use App\Models\transferdetail;
use App\Models\requisition;
use App\Models\requisitiondetail;
use App\Models\Sales;
use App\Models\Salesitem;
use App\Models\store;
use App\Models\actions;
use App\Notifications\RealTimeNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class TransferController extends Controller
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
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $curdate=Carbon::today()->toDateString();     
        $storeSrc=DB::select('SELECT DISTINCT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=8 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        $desStoreSrc=DB::select('SELECT DISTINCT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=9 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        $itemSrcs=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        $users=DB::select('select * from users where username!="'.$user.'" and id>1 order by username asc');
        $deliverusers=DB::select('select * from users where id>1 AND Status="Active" order by username asc');
        //$itemSrc=DB::select('SELECT DISTINCT ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND transactions.FiscalYear='.$fiscalyr.' AND StoreId IN(Select StoreId from storeassignments where UserId='.$userid.' AND storeassignments.Type=2)');
        //$itemSrc=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)))) AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId))>0 AND regitems.ActiveStatus="Active" AND transactions.FiscalYear='.$fiscalyr.' GROUP BY regitems.Name,transactions.StoreId  order by regitems.Name ASC');
        
        // $itemSrc=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,
        // @balance:=(SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)) AS Balance,
        // transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" GROUP BY regitems.Name,transactions.StoreId HAVING Balance>0 ORDER BY regitems.Name ASC');

        $itemSrc=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,regitems.id AS ItemId FROM regitems WHERE regitems.ActiveStatus="Active" ORDER BY regitems.Name ASC');

        $itemSrcEd=DB::select('SELECT DISTINCT ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND transactions.FiscalYear='.$fiscalyr.' AND StoreId IN(Select StoreId from storeassignments where UserId='.$userid.' AND storeassignments.Type=2)');
        $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
        $storelists=DB::select('SELECT * FROM stores');
        
        if($request->ajax()) {
            return view('inventory.transfer',['storeSrc'=>$storeSrc,'desStoreSrc'=>$desStoreSrc,'itemSrcs'=>$itemSrcs,'users'=>$users,'user'=>$user,'userid'=>$userid,'itemSrc'=>$itemSrc,'itemSrcEd'=>$itemSrcEd,'fiscalyears'=>$fiscalyears,'deliverusers'=>$deliverusers,'storelists'=>$storelists,'curdate'=>$curdate])->renderSections()['content'];
        }
        else{
            return view('inventory.transfer',['storeSrc'=>$storeSrc,'desStoreSrc'=>$desStoreSrc,'itemSrcs'=>$itemSrcs,'users'=>$users,'user'=>$user,'userid'=>$userid,'itemSrc'=>$itemSrc,'itemSrcEd'=>$itemSrcEd,'fiscalyears'=>$fiscalyears,'deliverusers'=>$deliverusers,'storelists'=>$storelists,'curdate'=>$curdate]);
        }
        
    }

    public function showTransferData()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        //$fiscalyr=$settingsval->FiscalYear;
        $fiscalyr=$_POST['fy']; 
        $req=DB::select('SELECT transfers.id,transfers.Type,transfers.DocumentNumber,transfers.IssueDocNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,transfers.Date,transfers.TransferBy,transfers.Status,transfers.DispatchStatus,transfers.Reason,transfers.created_at,transfers.OldStatus,transfers.IssueId,transfers.PreparedBy FROM transfers INNER JOIN stores as sstores ON transfers.SourceStoreId=sstores.id INNER JOIN stores as dstores on transfers.DestinationStoreId=dstores.id WHERE (transfers.DestinationStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type IN(9,15)) OR transfers.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type IN(2,3,8))) AND transfers.fiscalyear='.$fiscalyr.' ORDER BY transfers.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editln='';
                $deleteln='';
                $println='';
                $sivln='';
                $unvoidvlink='';
                if($data->Status=='Issued')
                {
                    $editln='';
                    // if($user->can('Void-Transfer-After-Issue'))
                    // {
                    //     $deleteln='<a class="dropdown-item deleteRequisitionRecord" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    // } 
                    $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV'.$data->id.'" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                    $sivln=' <a class="dropdown-item printTrIssueAttachment" href="javascript:void(0)" data-link="/isstr/'.$data->IssueId.'" id="printSTIV" data-attr="" title="Print Store Transfer Issue Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                    $unvoidvlink='';
                }
                else if($data->Status=='Issued(Received)' || $data->Status=='Issued(Fully-Received)' || $data->Status=='Issued(Partially-Received)')
                {
                    $editln='';
                    $deleteln='';
                    $unvoidvlink='';
                    $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV'.$data->id.'" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                    $sivln=' <a class="dropdown-item printTrIssueAttachment" href="javascript:void(0)" data-link="/isstr/'.$data->IssueId.'" id="printSTIV" data-attr="" title="Print Store Transfer Issue Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                }
                else if($data->Status=='Pending' || $data->Status=='Draft')
                {
                    if($user->can('Transfer-Edit'))
                    {
                        $editln='  <a class="dropdown-item editTransferRecord" onclick="edittransferdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Transfer-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    } 
                    //$println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV'.$data->id.'" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Approved' || $data->Status=='Verified')
                {
                    $editln='';
                    if($user->can('Transfer-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    //$println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV'.$data->id.'" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Commented')
                {
                    if($user->can('Transfer-Edit'))
                    {
                        $editln='  <a class="dropdown-item editTransferRecord" onclick="edittransferdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $deleteln='';
                    //$println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV'.$data->id.'" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Corrected')
                {
                    if($user->can('Transfer-Edit'))
                    {
                        $editln='  <a class="dropdown-item editTransferRecord" onclick="edittransferdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $deleteln='';
                    //$println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV'.$data->id.'" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Rejected')
                {
                    $editln='';
                    $deleteln='';
                    $println='';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Void(Draft)' || $data->Status=='Void(Pending)' || $data->Status=='Void(Approved)' || $data->Status=='Void(Verified)')
                {
                    $editln='';
                    $deleteln='';
                    
                    // if($data->Status=='Void(Pending)' || $data->Status=='Void(Approved)'){
                    if($user->can('Transfer-Void'))
                    {
                        $unvoidvlink= '<a class="dropdown-item undovoidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                    }
                    //     $sivln='';
                    //     $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV'.$data->id.'" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                    // }
                    // if($data->Status=='Void(Issued)'){
                    //     if($user->can('Void-Transfer-After-Issue'))
                    //     {
                    //         $unvoidvlink= '<a class="dropdown-item undovoidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                    //     }   
                    // }
                    $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV'.$data->id.'" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                }
                $btn='<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item DocTraInfo" onclick="DocTraInfo('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" id="dtinfobtn'.$data->id.'" title="Show stock transfer information">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$editln.'
                        '.$deleteln.' 
                        '.$unvoidvlink.' 
                        '.$println.' 
                        
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getTransferNumber()
    {
        $settings = DB::table('settings')->latest()->first();
        $tprefix=$settings->TransferPrefix;
        $tnumber=$settings->TransferNumber;
        $fyear=$settings->FiscalYear;
        $suffixdoc=$fyear-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $tnumber);
        $trNumber=$tprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        $updn=DB::select('update countable set TransferCount=TransferCount+1 where id=1');
        $trCountNum = DB::table('countable')->latest()->first();
        return response()->json(['reqnum'=>$trNumber,'TransferCount'=>$trCountNum->TransferCount]);
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
        $comparestorefy=0;
        $fiscalyears=null;
        $desfiscalyears=null;
        $fiscalyrcomp=null;
        $fiscalyrstr=null;
        $tnumber=null;
        $trNumber=null;
        $tprefix=null;
        $storeid=$request->SourceStore;
        $desstoreid=$request->DestinationStore;
        $hiddenstr=$request->hiddenstoreval;
        $editdiffstr=0;
        if($storeid!=null){
            $strdata=store::findorFail($storeid);
            $fiscalyears=$strdata->FiscalYear;
        }

        if($desstoreid!=null){
            $desstrdata=store::findorFail($desstoreid);
            $desfiscalyears=$desstrdata->FiscalYear;
        }

        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $fiscalyrcomp=$settings->FiscalYear;

        if($storeid!=null && $fyear==$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $tprefix=$settings->TransferPrefix;
            $tnumber=$settings->TransferNumber;
            $fyear=$settings->FiscalYear;
        }

        if($storeid!=null && $fyear!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $transferprop = DB::table('transfers')->where('fiscalyear',$fiscalyears)->orderBy('id', 'desc')->first();
            $docdata=$transferprop->DocumentNumber;
            $tprefix = preg_replace('/[^a-zA-Z]/m','',$docdata);
            $numbersfor = preg_replace('/\D/', '', $docdata);
            $numbersfor = substr($numbersfor, 0, 5);
            $tnumber=$numbersfor+1;
            $fyear=$fiscalyears;
        }

        if($fiscalyears!=$desfiscalyears){
            $comparestorefy=1;
        }

        $suffixdoc=$fyear-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $tnumber);
        $trNumber=$tprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;

        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->transferId;
        $findid=$request->transferId;
        
        $insids=[];
        $detailids=[];

        if($findid!=null)
        {
            if($hiddenstr!=null){//check the old and new store fiscal year
                $strdatahid=store::findorFail($hiddenstr);
                $fiscalyrstr=$strdatahid->FiscalYear;
                if($fiscalyrstr!=$fiscalyears){
                    $editdiffstr=1;
                }
            } 

            if($request->row==null){
                return Response::json(['emptyerror'=>"error"]);
            }

            else{
                $itemidlists=transferdetail::where('HeaderId', $request->transferId)->get(['ItemId']);
                foreach ($itemidlists as $itemidlists) {
                    $insids[] = $itemidlists->ItemId;
                }
                $validator = Validator::make($request->all(), [
                    'SourceStore' => ['required'],
                    'DestinationStore' => ['required','different:SourceStore'],
                    //'Reason' => ['required'],
                    //'RequestedBy' => ['required'],
                    'date' => ['required','date'],
                ]);
                $rules=array(
                    'row.*.ItemId' => 'required',
                    'row.*.Quantity' => 'required|numeric|min:1',
                );
                $v2= Validator::make($request->all(), $rules);
                if ($validator->passes() && $v2->passes() && ($request->row!=null) && $comparestorefy==0 && $editdiffstr==0) 
                {
                    try
                    {
                        $transfer=transfer::updateOrCreate(['id' => $request->transferId], [
                            'SourceStoreId' => $request->SourceStore,
                            'DestinationStoreId' => $request->DestinationStore,
                            'TransferBy' => $request->RequestedBy,
                            'TransferDate' => Carbon::today()->toDateString(),
                            'Reason' => $request->Reason,
                            'PreparedBy' =>  $user,
                            'PreparedDate' => Carbon::today()->toDateString(),
                            'fiscalyear' => $fyear,
                        ]);

                        foreach ($request->row as $key => $value) 
                        {
                            $itemname=$value['ItemId'];
                            $quantity=$value['Quantity'];
                            $unitcost=$value['UnitCost'];
                            $common=$value['Common'];
                            $transactiontype=$value['TransactionType'];
                            $itemtype=$value['ItemType'];
                            $storeid=$request->SourceStore;
                            $desstoreid=$request->DestinationStore;
                            $memo=$value['Memo'];
                            $beforetaxvar=$quantity*$unitcost;
                            $taxvar=($beforetaxvar*15)/100;
                            $totalresultvar=$beforetaxvar+$taxvar;
                            if(in_array($itemname,$insids)){
                                $updatetransferdetail=transferdetail::where('HeaderId',$request->transferId)->where('ItemId',$itemname)->update(['Quantity'=>$quantity,'UnitCost'=>$unitcost,'BeforeTaxCost'=>$beforetaxvar,'TaxAmount'=>$taxvar,'TotalCost'=>$totalresultvar,'Common'=>$common,'TransactionType'=>$transactiontype,'ItemType'=>$itemtype,'StoreId'=>$storeid,'DestStoreId'=>$desstoreid,'Memo'=>$memo]);
                            }
                            if(!in_array($itemname,$insids)){
                                $trdet=new transferdetail;
                                $trdet->HeaderId=$request->transferId;
                                $trdet->ItemId=$itemname;
                                $trdet->Quantity=$quantity;
                                $trdet->UnitCost=$unitcost;
                                $trdet->BeforeTaxCost=$beforetaxvar;
                                $trdet->TaxAmount=$taxvar;
                                $trdet->TotalCost=$totalresultvar;
                                $trdet->ItemType=$itemtype;
                                $trdet->Common=$common;
                                $trdet->TransactionType=$transactiontype;
                                $trdet->StoreId=$storeid;
                                $trdet->DestStoreId=$desstoreid;
                                $trdet->Memo=$memo;
                                $trdet->save();
                            }
                            $detailids[]=$itemname;
                        }
                        transferdetail::where('HeaderId',$request->transferId)->whereNotIn('ItemId',$detailids)->delete();
                        // $updStore=DB::select('update transferdetails set StoreId='.$storeid.',DestStoreId='.$desstoreid.' where HeaderId='.$headerid.'');
                        // DB::table('transferdetails')
                        // ->where('HeaderId', $headerid)
                        // ->update(['BeforeTaxCost' =>(DB::raw('transferdetails.Quantity * transferdetails.UnitCost')),'TaxAmount'=>(DB::raw('(transferdetails.BeforeTaxCost * 15)/100')),'TotalCost' =>(DB::raw('transferdetails.BeforeTaxCost + transferdetails.TaxAmount'))]);
                        actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"transfer",'action'=>"Edited",'status'=>"Edited",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                        return Response::json(['success' => '1']);
                    }
                    catch(Exception $e)
                    {
                        return Response::json(['dberrors' =>  $e->getMessage()]);
                    }
                }
            }
        }

        if($findid==null)
        {
            $cusid=$request->supplier;
            $validator = Validator::make($request->all(), [
                $trNumber=>"unique:transfers,DocumentNumber,$findid",
                'SourceStore' => ['required'],
                'DestinationStore' => ['required','different:SourceStore'],
                //'Reason' => ['required'],
                //'RequestedBy' => ['required'],
                'date' => ['required','after:yesterday','before:tomorrow'],
            ]);

            $rules=array(
                'row.*.ItemId' => 'required',
                'row.*.Quantity' => 'required|numeric|min:1',
            );
            $v2= Validator::make($request->all(), $rules);
            if ($validator->passes() && $v2->passes() && ($request->row!=null) && $comparestorefy==0 && $editdiffstr==0)
            {
                try
                {
                    $itemtype=$request->Type;
                    $transfer=transfer::updateOrCreate(['id' => $request->transferId], [
                        'DocumentNumber' => $trNumber,
                        'SourceStoreId' => $request->SourceStore,
                        'DestinationStoreId' => $request->DestinationStore,
                        'Date' => $request->date,
                        'Reason' => $request->Reason,
                        'Department' => "-",
                        'TransferBy' => $request->RequestedBy,
                        'TransferDate' =>Carbon::today()->toDateString(),
                        'AuthorizedBy' => "",
                        'AuthorizedDate' => "",
                        'ApprovedBy' => "",
                        'ApprovedDate' => "",
                        'ReceivedBy' => "",
                        'ReceivedDate' => "",
                        'CommentedBy' => "",
                        'CommentedDate' => "",
                        'IssuedBy' => "",
                        'IssuedDate' => "",
                        'PreparedBy' =>  $user,
                        'PreparedDate' => Carbon::today()->toDateString(),
                        'RejectedBy' => "",
                        'RejectedDate' => "",
                        'Memo' => "",
                        'Status' =>"Draft",
                        'DispatchStatus' =>"-",
                        'Common' =>$request->commonVal,
                        'fiscalyear' => $fyear,
                    ]);
                    foreach ($request->row as $key => $value) 
                    {
                        $itemname=$value['ItemId'];
                        $quantity=$value['Quantity'];
                        $unitcost=$value['UnitCost'];
                        $common=$value['Common'];
                        $transactiontype=$value['TransactionType'];
                        $itemtype=$value['ItemType'];
                        $storeid=$request->SourceStore;
                        $desstoreid=$request->DestinationStore;
                        $memo=$value['Memo'];
                        $beforetaxvar=$quantity*$unitcost;
                        $taxvar=($beforetaxvar*15)/100;
                        $totalresultvar=$beforetaxvar+$taxvar;
                        $transfer->items()->attach($itemname,['Quantity'=>$quantity,'UnitCost'=>$unitcost,'BeforeTaxCost'=>$beforetaxvar,'TaxAmount'=>$taxvar,'TotalCost'=>$totalresultvar,'Common'=>$common,'TransactionType'=>$transactiontype,'ItemType'=>$itemtype,'StoreId'=>$storeid,'DestStoreId'=>$desstoreid,'Memo'=>$memo]);
                    }
                    // $comn=$request->commonVal;
                    // $transfer = DB::table('transfers')->where('PreparedBy', $user)->latest()->first();
                    // $headerid=$transfer->id;
                   
                    if($request->transferId==null && $fyear==$fiscalyrcomp)
                    {
                        $updn=DB::select('update settings set TransferNumber=TransferNumber+1 where id=1');
                    }
                    $transactiontype="Transfer";
                                      
                    $users2 = User::join('storeassignments', 'storeassignments.UserId', '=', 'users.id')
                    ->where(['storeassignments.StoreId' => $storeid,'storeassignments.Type'=>3])
                    ->get(['users.*']);
            
                    try 
                    { 
                        Notification::send($users2, new RealTimeNotification($user,"Send Store Requistion",'Transfer'));
                    } 
                    catch(\Exception $e)
                    {}

                    actions::insert(['user_id'=>$userid,'pageid'=>$transfer->id,'pagename'=>"transfer",'action'=>"Created",'status'=>"Created",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
        }     
      
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }

        if($v2->fails())
        {
            return response()->json([ 'errorv2'  => $v2->errors()->all()]);
        }

        if($comparestorefy>=1){
            return Response::json(['differencefy'=>1]);
        }

        if($editdiffstr>=1){
            return Response::json(['strdifferrors'=>1]);
        }
    }

    public function approveTransfer(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $trnid=$request->recAppId;
        $rules=array(
            'rowapp.*.AppQuantity' => 'required|numeric',
        );
        $v2= Validator::make($request->all(), $rules);

        if ($v2->passes()) 
        {
            try{
                foreach ($request->rowapp as $key => $value) 
                {
                    transferdetail::updateOrCreate(['id' => $value['recordid']],
                    [
                        'ApprovedQuantity'=>$value['AppQuantity'],
                        'ApprovedMemo'=>$value['AppRemark'],
                    ]);
                }
                transfer::where('id',$trnid)->update(['ApprovedBy'=>$user,'ApprovedDate'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'Status'=>"Approved"]);
                actions::insert(['user_id'=>$userid,'pageid'=>$trnid,'pagename'=>"transfer",'action'=>"Approved",'status'=>"Approved",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($v2->fails())
        {
            return response()->json([ 'errorv2'  => $v2->errors()->all()]);
        }
    }

    public function pendingTransfer(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->pendingtrId;
        $trn=transfer::find($findid);
        $trn->ChangeToPendingBy= $user;
        $trn->ChangeToPendingDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $trn->Status="Pending";
        $trn->save();
        actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"transfer",'action'=>"Change to Pending",'status'=>"Change to Pending",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
        return Response::json(['success' => '1']);
    }

    public function backToDraftTrn(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->draftid;
        $recprop=transfer::find($findid);

        $validator = Validator::make($request->all(),[
            'BackToDraftComment' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status=="Pending"){
                try{
                    $recprop->Status="Draft";
                    $recprop->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"transfer",'action'=>"Back to Draft",'status'=>"Back to Draft",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToDraftComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function verifyTransfer(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $bookingcnt=0;
        $findid=$request->verifyId;
        $trn=transfer::find($findid);
        if($trn->Status=="Pending"){
            try{
                $trn->Status="Verified";
                $trn->AuthorizedBy=$user;
                $trn->AuthorizedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $trn->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"transfer",'action'=>"Verified",'status'=>"Verified",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else{
            return Response::json(['statuserror' =>462]);
        }
    }

    public function trnBackToPending(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtopendingid;
        $trn=transfer::find($findid);

        $validator = Validator::make($request->all(),[
            'BackToPendingComment' => 'required',
        ]);

        if($validator->passes()){
            if($trn->Status=="Verified"){
                try{
                    $trn->Status="Pending";
                    $trn->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"transfer",'action'=>"Back to Pending",'status'=>"Back to Pending",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToPendingComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function backToVerifyTrn(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtoverifyid;
        $trn=transfer::find($findid);

        $validator = Validator::make($request->all(),[
            'BackToVerifyComment' => 'required',
        ]);

        if($validator->passes()){
            if($trn->Status=="Approved"){
                try{
                    $trn->Status="Verified";
                    $trn->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"transfer",'action'=>"Back to Verify",'status'=>"Back to Verify",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToVerifyComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function syncDynamicTable(Request $request)
    {
        $insids=[];
        $tritem=[];
        $inds=null;
        $fiscalyears=null;
        $qtyonhandflg=0;
        $checkqtyonhand=0;
        $getallbalnces="";
        $storeval=$request->SourceStore;
        if($storeval!=null){
            $strdata=store::findorFail($storeval);
            $fiscalyears=$strdata->FiscalYear;
            $qtyonhandflg=$strdata->QtyOnHandFlag;
            $checkqtyonhand=$strdata->CheckQtyOnHand;
        }

        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        
        if($storeval!=null && $fyear!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $fyear=$fiscalyears;
        }

        if($request->row!=null){
            foreach ($request->row as $key => $value) 
            {
                $insids[]=$value['ItemId'];
            }
            $inds=implode(',',$insids);
            $getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)))) AS Balance,(SELECT COALESCE((sum(Quantity)),0) FROM requisitiondetails INNER JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.Status IN("Pending","Approved") AND requisitions.SourceStoreId=transactions.StoreId AND requisitiondetails.ItemId=transactions.ItemId) AS ReqBalance,(SELECT COALESCE((sum(Quantity)),0) FROM transferdetails INNER JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transfers.Status IN("Pending","Approved") AND transfers.SourceStoreId=transactions.StoreId AND transferdetails.ItemId=transactions.ItemId) AS TrnBalance,(SELECT COALESCE((sum(Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status IN("pending..","Checked") AND salesitems.StoreId=transactions.StoreId AND salesitems.ItemId=transactions.ItemId) AS SalesBalance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fyear.' AND transactions.ItemId IN ('.$inds.') AND transactions.StoreId='.$storeval.' GROUP BY regitems.Name,transactions.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');
        }
        return response()->json(['qtyonhandflg'=>$qtyonhandflg,'checkqtyonhand'=>$checkqtyonhand,'bal'=>$getallbalnces]);
    }
    
    public function showTrDataCon($id){
        $deststore="";
        $sourcestore="";
        $countval="";
        $issueval="";
        $approveval="";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $ids=$id;

        $trareq = transfer::find($id);
        $createddateval=$trareq->created_at;
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');


        $trHeader=DB::select('SELECT transfers.id,transfers.Type,transfers.DocumentNumber,sstores.Name AS SourceStore,dstores.Name AS DestinationStore,sstores.QtyOnHandFlag,sstores.CheckQtyOnHand,transfers.DestinationStoreId,transfers.SourceStoreId,transfers.Date,transfers.TransferBy,transfers.PreparedBy,transfers.Status,transfers.Reason,transfers.Memo,"'.$datetime.'" AS created_at,transfers.ApprovedBy,transfers.ApprovedDate,transfers.IssuedBy,transfers.IssuedDate,transfers.RejectedBy,transfers.RejectedDate,transfers.VoidBy,transfers.VoidDate,transfers.CommentedBy,transfers.CommentedDate,transfers.VoidReason,transfers.DeliveredBy,transfers.DeliveredDate,transfers.ReceivedBy,transfers.ReceivedDate,transfers.IssueDocNumber,transfers.UndoVoidBy,transfers.UndoVoidDate,transfers.fiscalyear,transfers.DispatchStatus FROM transfers LEFT JOIN stores AS sstores ON transfers.SourceStoreId=sstores.id LEFT JOIN stores AS dstores ON transfers.DestinationStoreId=dstores.id WHERE transfers.id='.$id);
        foreach($trHeader as $row)
        {
            $deststore=$row->DestinationStoreId;
            $sourcestore=$row->SourceStoreId;
        }
        $getreceivedata=DB::select('SELECT COUNT(storeassignments.UserId) AS ReceiveFlag FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.StoreId='.$deststore.' AND storeassignments.Type=15');
        foreach($getreceivedata as $row)
        {
            $countval=$row->ReceiveFlag;
        }
        $getIssuedata=DB::select('SELECT COUNT(storeassignments.UserId) AS IssueFlag FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.StoreId='.$sourcestore.' AND storeassignments.Type=2');
        foreach($getIssuedata as $row)
        {
            $issueval=$row->IssueFlag;
        }
        $getApprovedata=DB::select('SELECT COUNT(storeassignments.UserId) AS ApproveFlag FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.StoreId='.$sourcestore.' AND storeassignments.Type=3');
        foreach($getApprovedata as $row)
        {
            $approveval=$row->ApproveFlag;
        }
        
        $strdata=store::findorFail($sourcestore);
        $fiscalyearstr=$strdata->FiscalYear;

        $desstrdata=store::findorFail($deststore);
        $desfiscalyearstr=$desstrdata->FiscalYear;

        $data = transferdetail::join('transfers', 'transferdetails.HeaderId', '=', 'transfers.id')
            ->join('regitems', 'transferdetails.ItemId', '=', 'regitems.id')
            ->join('uoms', 'regitems.MeasurementId', '=', 'uoms.id')
            ->where('transferdetails.HeaderId', $id)
            ->orderBy('transferdetails.id','asc')
            ->get(['transfers.*','transferdetails.*','transferdetails.id AS RecordId','transferdetails.Common AS recdetcommon','transferdetails.StoreId AS recdetstoreid',
            'transferdetails.RequireSerialNumber AS ReSerialNm','transferdetails.RequireExpireDate AS ReExpDate','regitems.Name AS ItemName','regitems.Code AS ItemCode','regitems.SKUNumber',
            'regitems.PartNumber','uoms.Name AS UomName',DB::raw('IFNULL(transferdetails.Memo,"") AS ReqMemo'),DB::raw('IFNULL(transferdetails.ApprovedMemo,"") AS ApprovedMemo')] );

        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"transfer")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['trHeader'=>$trHeader,'trDetail'=>$data,'fyear'=>$fyear,'countval'=>$countval,'issuecnt'=>$issueval,'approvecnt'=>$approveval,'fyearstr'=>$fiscalyearstr,'desfyearstr'=>$desfiscalyearstr,'activitydata'=>$activitydata]);       
    }

    public function calcTrnBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $status=["Draft","Pending","Verified","Approved"];
        $salesStatus=["pending..","Checked"];
        $itemid=$_POST['itemid']; 
        $storeid=$_POST['storeid']; 
        $headerid=$_POST['headerid']; 

        $itemid = !empty($itemid) ? $itemid : 0;
        $storeid = !empty($storeid) ? $storeid : 0;
        $headerid = !empty($headerid) ? $headerid : 0;

        $currtransferqnt=0;
        $othertransferqnt=0;
        $requisitionqnt=0;
        $salesqnt=0;
        $transactionqnt=0;
        $quantity=0;

        $strdata=store::findorFail($storeid);
        $fyear=$strdata->FiscalYear;

        $currTransfer=transferdetail::where('transferdetails.HeaderId',$headerid)
            ->where('transferdetails.ItemId',$itemid)
            ->get(['transferdetails.Quantity']);

        $otherTransfer=transferdetail::leftJoin('transfers','transferdetails.HeaderId','transfers.id')
            ->where('transferdetails.HeaderId','!=',$headerid)
            ->where('transferdetails.ItemId',$itemid)
            ->where('transferdetails.StoreId',$storeid)
            ->whereIn('transfers.Status',$status)
            ->get([DB::raw('SUM(COALESCE(transferdetails.Quantity,0)) AS Quantity')]);

        $requisitiondata=requisitiondetail::leftJoin('requisitions','requisitiondetails.HeaderId','requisitions.id')
            ->where('requisitiondetails.ItemId',$itemid)
            ->where('requisitiondetails.StoreId',$storeid)
            ->whereIn('requisitions.Status',$status)
            ->get([DB::raw('SUM(COALESCE(requisitiondetails.Quantity,0)) AS Quantity')]);

        $salesdata=Salesitem::leftJoin('sales','salesitems.HeaderId','sales.id')
            ->where('salesitems.ItemId',$itemid)
            ->where('salesitems.StoreId',$storeid)
            ->whereIn('sales.Status',$salesStatus)
            ->get([DB::raw('SUM(COALESCE(salesitems.Quantity,0)) AS Quantity')]);

        $qtyonhandata=DB::select('SELECT ROUND((SUM(COALESCE(transactions.StockIn,0))-SUM(COALESCE(transactions.StockOut,0))),2) AS AvailableBalance FROM transactions WHERE transactions.FiscalYear='.$fyear.' AND transactions.ItemId='.$itemid.' AND transactions.StoreId='.$storeid);

        // $currtransferqnt=$currTransfer[0]->Quantity ?? 0;
        // $othertransferqnt=$otherTransfer[0]->Quantity ?? 0;
        // $requisitionqnt=$requisitiondata[0]->Quantity ?? 0;
        // $salesqnt=$salesdata[0]->Quantity ?? 0;
        // $transactionqnt=$qtyonhandata[0]->AvailableBalance ?? 0;

        $currtransferqnt = !empty($currTransfer[0]->Quantity) ? $currTransfer[0]->Quantity : 0;
        $othertransferqnt = !empty($otherTransfer[0]->Quantity) ? $otherTransfer[0]->Quantity : 0;
        $requisitionqnt = !empty($requisitiondata[0]->Quantity) ? $requisitiondata[0]->Quantity : 0;
        $salesqnt = !empty($salesdata[0]->Quantity) ? $salesdata[0]->Quantity : 0;
        $transactionqnt = !empty($qtyonhandata[0]->AvailableBalance) ? $qtyonhandata[0]->AvailableBalance : 0;

        $quantity=(($transactionqnt - $othertransferqnt - $requisitionqnt - $salesqnt) + 0);        
        
        return response()->json(['qntonhand'=>$quantity]);
    }

    public function showTrDetailData($id)
    {
        $detailTable=DB::select('SELECT transferdetails.id,transferdetails.ItemId,transferdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,transferdetails.Quantity,transferdetails.ApprovedQuantity,transferdetails.IssuedQuantity,transferdetails.PartNumber,uoms.Name as UOM,transferdetails.Quantity,transferdetails.DispatchQuantity,transferdetails.Memo,transferdetails.ApprovedMemo FROM transferdetails INNER JOIN regitems ON transferdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where transferdetails.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function editTransferCon($id)
    {
        $insids=[];
        $fiscalyears=null;
        $qtyonhandflg=0;
        $checkqtyonhand=0;
        $trdata = transfer::find($id);
        $srcstoreid=$trdata->SourceStoreId;
        if($srcstoreid!=null){
            $strdata=store::findorFail($srcstoreid);
            $fiscalyears=$strdata->FiscalYear;
            $qtyonhandflg=$strdata->QtyOnHandFlag;
            $checkqtyonhand=$strdata->CheckQtyOnHand;
        }
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;

        if($srcstoreid!=null && $fyear!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $fyear=$fiscalyears;
        }

        $fyear=2022;

        $countitem = DB::table('transferdetails')->where('HeaderId', '=', $id)->get();
        $getCountItem = $countitem->count();
        $itemidlists=transferdetail::where('HeaderId',$id)->orderBy('transferdetails.id','asc')->get(['ItemId']);
        foreach ($itemidlists as $itemidlists) {
            $insids[] = $itemidlists->ItemId;
        }
        $inds=implode(',',$insids);
        $countitem = DB::table('transferdetails')->where('HeaderId', '=', $id)
            ->get();
        $getCountItem = $countitem->count();
        
        $data = transferdetail::join('transfers', 'transferdetails.HeaderId', '=', 'transfers.id')
            ->join('regitems', 'transferdetails.ItemId', '=', 'regitems.id')
            ->join('uoms', 'regitems.MeasurementId', '=', 'uoms.id')
            ->where('transferdetails.HeaderId', $id)
            ->orderBy('transferdetails.id','asc')
            ->get(['transfers.*','transferdetails.*','transferdetails.Common AS recdetcommon','transferdetails.StoreId AS recdetstoreid',
            'transferdetails.RequireSerialNumber AS ReSerialNm','transferdetails.RequireExpireDate AS ReExpDate','regitems.Name AS ItemName','regitems.Code AS ItemCode','regitems.SKUNumber',
            'regitems.PartNumber','uoms.Name AS UomName',DB::raw('IFNULL(transferdetails.Memo,"") AS ReqMemo')]);
        
            $getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(SELECT IF((SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)))-(select COALESCE((SUM(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)))-(select COALESCE((SUM(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)))) AS Balance,(SELECT COALESCE((SUM(Quantity)),0) FROM requisitiondetails INNER JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitions.Status IN("Pending","Approved") AND requisitions.SourceStoreId=transactions.StoreId AND requisitiondetails.ItemId=transactions.ItemId) AS ReqBalance,(SELECT COALESCE((SUM(Quantity)),0) FROM transferdetails INNER JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transfers.Status IN("Pending","Approved") AND transfers.SourceStoreId=transactions.StoreId AND transferdetails.ItemId=transactions.ItemId) AS TrnBalance,(SELECT COALESCE((SUM(Quantity)),0) FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status IN("pending..","Checked") AND salesitems.StoreId=transactions.StoreId AND salesitems.ItemId=transactions.ItemId) AS SalesBalance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fyear.' AND transactions.ItemId IN ('.$inds.') AND transactions.StoreId='.$srcstoreid.' GROUP BY regitems.Name,transactions.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');
        return response()->json(['trdata'=>$trdata,'count'=>$getCountItem,'reqdetail'=>$data,'bal'=>$getallbalnces,'qtyonhandflg'=>$qtyonhandflg,'checkqtyonhand'=>$checkqtyonhand]);
    }

    public function editTransferConStatus($id)
    {
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $trstatusdata = transfer::find($id);
        $strid=$trstatusdata->SourceStoreId;
        $desstrid=$trstatusdata->DestinationStoreId;

        $strdata=store::findorFail($strid);
        $fiscalyearstr=$strdata->FiscalYear;
        $srcstores=$strdata->Name;

        $desstrdata=store::findorFail($desstrid);
        $desfiscalyearstr=$desstrdata->FiscalYear;
        $desstores=$desstrdata->Name;

        return response()->json(['trstatusdata'=>$trstatusdata,'fyear'=>$fyear,'fyearstr'=>$fiscalyearstr,'desfyearstr'=>$desfiscalyearstr,'srcstores'=>$srcstores,'desstores'=>$desstores]);
    }

    public function showTransferDetailData($id)
    {
        $detailTable=DB::select('SELECT transferdetails.id,transferdetails.ItemId,transferdetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS Code,regitems.SKUNumber AS SKU,transferdetails.PartNumber,uoms.Name as UOM,transferdetails.Quantity,transferdetails.Memo FROM transferdetails INNER JOIN regitems ON transferdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where transferdetails.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            $btn = '<a data-id="'.$data->id.'" data-hid="'.$data->HeaderId.'" data-iid="'.$data->ItemId.'" data-itemname="'.$data->ItemName.'" data-code="'.$data->Code.'" data-uom="'.$data->UOM.'" data-memo="'.$data->Memo.'" class="btn btn-icon btn-gradient-info btn-sm editTransferDatas" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            $btn = $btn.' <a data-id="'.$data->id.'" data-hid="'.$data->HeaderId.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm deleteReqDatas" data-attr="" data-target="#reqremovemodal" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getTransferStoreItemCon(Request $request,$id)
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $itemtype=$request->Type;
        $getStItem=DB::table('transactions')
        ->join('regitems','regitems.id','=','transactions.ItemId')
        ->select('regitems.id','regitems.Name as ItemName','regitems.Code as Code','regitems.SKUNumber as SKUNumber')
        ->where('FiscalYear' ,$fiscalyr)
        ->where('StoreId' ,$id)
        ->groupBy('regitems.Name','regitems.id','regitems.Code','regitems.SKUNumber')
        ->get();
         return response()->json(['sid'=>$getStItem]);
    }

    public function getstoreItemCon(Request $request,$id)
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $itemtype=$request->Type;
        $getStItem=DB::table('transactions')
        ->join('regitems','regitems.id','=','transactions.ItemId')
        ->select('regitems.id','regitems.Name as ItemName','regitems.Code as Code','regitems.SKUNumber as SKUNumber')
        ->where('FiscalYear' ,$fiscalyr)
        ->where('StoreId' ,$id)
        ->groupBy('regitems.Name','regitems.id','regitems.Code','regitems.SKUNumber')
        ->get();
         return response()->json(['sid'=>$getStItem]);
    }

    public function storeNewTrItem(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->receIds;
        $storeid=$request->receivingstoreid;
        $desstoreid=$request->desstId;
        $findid=$request->transfereditid;
        $valId=$request->editVal;
      
        if($findid==null)
        {
            $validator = Validator::make($request->all(), [
                'itemNames' =>'required',
                'Quantity' =>"required|numeric|min:1|not_in:0'",
            ]);
        }
        
        if($findid!=null)
        {
            $validator = Validator::make($request->all(), [
                'itemNames' =>'required',
                'Quantity' =>"required|numeric|min:1|not_in:0'",
            ]);
        }

        if($validator->passes())
        {
            try
            {
                $req=transferdetail::updateOrCreate(['id' => $request->transfereditid], [
                    'HeaderId' => trim($request->receIds),
                    'ItemId' => trim($request->itemNames),
                    'Quantity' => trim($request->Quantity),
                    'UnitCost' => $request->trEditMaxCost,
                    'Memo' =>trim($request->reqmemo),
                    'StoreId' => trim($request->receivingstoreid),
                    'DestStoreId' => trim($request->desstId),
                    'TransactionType' =>"Transfer"
                ]);

                $reqrec = DB::table('transfers')->where('id', $headerid)->latest()->first();
                $comm=$reqrec->Common;
                 
                DB::table('transferdetails')
                ->where('HeaderId', $headerid)
                ->update(['Common' => $comm]);

                DB::table('transfers')
                ->where('id', $headerid)
                ->update(['PreparedBy' => $user,'PreparedDate'=>Carbon::today()->toDateString()]);

                $countitem = DB::table('transferdetails')->where('HeaderId', '=', $headerid)->get();
                $getCountItem = $countitem->count();
                DB::table('transferdetails')
                ->where('HeaderId', $headerid)
                ->update(['BeforeTaxCost' =>(DB::raw('transferdetails.Quantity * transferdetails.UnitCost')),'TaxAmount'=>(DB::raw('(transferdetails.BeforeTaxCost * 15)/100')),'TotalCost' =>(DB::raw('transferdetails.BeforeTaxCost + transferdetails.TaxAmount'))]);
                return Response::json(['success' =>  '1','Totalcount'=>$request->trEditMaxCost]);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function editTransferItem($id)
    {
        $transferDataId = transferdetail::find($id);
        return response()->json(['transferDataId'=>$transferDataId]);
    }

    public function getTrItemEditQuantity(Request $request)
    {
        $id=$_POST['itemid']; 
        $sourcestore=$_POST['storeidvar']; 
        $destinationstore=$_POST['desstoreidvar']; 
        $fiscalyears=null;
        //$sourcestore=$request->SourceStore;
        if($sourcestore!=null){
            $strdata=store::findorFail($sourcestore);
            $fiscalyears=$strdata->FiscalYear;
        }
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        if($sourcestore!=null && $fiscalyr!=$fiscalyears){ //check whether this shop is posted transaction to the new fiscal year
            $fiscalyr=$fiscalyears;
        }
        
        
        $getQuantity=DB::select('SELECT (SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0))) AS AvailableQuantity FROM transactions WHERE transactions.FiscalYear='.$fiscalyr.' and transactions.StoreId='.$sourcestore.' and transactions.ItemId='.$id.'');
        $getSalesQuantity=DB::select('SELECT COALESCE(SUM(salesitems.Quantity),0) AS TotalSalesQuantity FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE salesitems.ItemId='.$id.' AND salesitems.StoreId='.$sourcestore.' AND sales.Status IN ("pending..","Checked")');
        $getTransferQuantity=DB::select('SELECT COALESCE(SUM(transferdetails.Quantity),0) AS TotalTrnQuantity FROM transferdetails INNER JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE transferdetails.ItemId='.$id.' AND transferdetails.StoreId='.$sourcestore.' AND transfers.Status IN ("Pending","Approved")');
        $getRequisitionQuantity=DB::select('SELECT COALESCE(SUM(requisitiondetails.Quantity),0) AS TotalReqQuantity FROM requisitiondetails INNER JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.ItemId='.$id.' AND requisitiondetails.StoreId='.$sourcestore.' AND requisitions.Status IN ("Pending","Approved")');
        $iteminfo=DB::select('SELECT regitems.id,regitems.Type,regitems.Code,regitems.Name,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus FROM regitems INNER JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.id='.$id);
        $getMaxCost=DB::select('SELECT MAX(UnitCost) AS UnitCost FROM transactions WHERE ItemId='.$id.' AND TransactionsType NOT IN ("Void","Undo-Void")');
        
        $avqnt=$getQuantity[0]->AvailableQuantity ?? 0;
        $salesqnt=$getSalesQuantity[0]->TotalSalesQuantity ?? 0;
        $trnqnt=$getTransferQuantity[0]->TotalTrnQuantity ?? 0;
        $reqqnt=$getRequisitionQuantity[0]->TotalReqQuantity ?? 0;
        $unitcost=$getMaxCost[0]->UnitCost ?? 0;
        
        
        
        
        return response()->json(['sid'=>$getQuantity,'avqnt'=>$avqnt,'itinfo'=>$iteminfo,'getCost'=>$unitcost,'salesqnt'=>$salesqnt,'trnqnt'=>$trnqnt,'reqqnt'=>$reqqnt]);
    }

    public function deleteTransferItem(Request $request, $id)
    {
        $headerid=$request->reqremoveheaderid;
        $reqItem = transferdetail::find($id);
        $reqItem->delete();

        $countitem = DB::table('transferdetails')->where('HeaderId', '=', $headerid)->get();
        $getCountItem = $countitem->count();

        return Response::json(['success' => 'Item Removed','Totalcount'=>$getCountItem]);
    }

    public function deleteTransferData(Request $request, $id)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $reqtype="Transfer";
        $tran=transfer::find($id);
        $statusval=$tran->Status;
        $storeId=$tran->SourceStoreId;
        $fiscalyr=$tran->fiscalyear;
        $docnum=$tran->IssueDocNumber;    
        $validator = Validator::make($request->all(), [
            'Reason' =>'required',
        ]);
        if($validator->passes())
        {
            if($statusval=="Issued")
            {
                $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type',$reqtype)->latest()->first();
                $issid=$issuecon->id;
                $syncToTransactionVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT "'.$issid.'",ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Void",ItemType,"'.$docnum.'","'.$fiscalyr.'","0","'.Carbon::now()->toDateString().'" FROM transferdetails WHERE transferdetails.HeaderId='.$id);
                $updateTransactios=DB::select('update transactions set IsVoid=1 where HeaderId='.$issid.' AND TransactionType="Transfer" AND TransactionsType="Transfer"');
                // $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type',$reqtype)->latest()->first();
                // $issid=$issuecon->id;
                // $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM transferdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$id.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
                // foreach($getApprovedQuantity as $row)
                // {
                //     $avaq=$row->ApprovedItems;
                // }
                // $avaqp = (float)$avaq;
                // if($avaqp>=1)
                // {
                //     $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.') AS AvailableQuantity FROM transferdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$id.' AND 
                //     (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
                //     return Response::json(['valerror'=>"error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
                // }
                // else
                // {
                //     $syncToTransactionVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,ConvertedQuantity,"0",BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Void",ItemType,"'.$docnum.'","'.$fyear.'","1","'.Carbon::now()->toDateString().'" FROM receivingdetails WHERE receivingdetails.HeaderId='.$findid);
                // }
            }
            $updateStatus=DB::select('update transfers set OldStatus=Status where id='.$id.'');
            $updateStatussec=DB::select('update transfers set Status=CONCAT("Void(",OldStatus,")"),VoidReason="'.$request->Reason.'",VoidBy="'.$user.'",VoidDate="'.Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A').'" where id='.$id.'');
            // DB::table('transfers')
            // ->where('id', $id)
            // ->update(['Status'=>"Void",'VoidReason'=> $request->Reason,'VoidBy'=>$user,'VoidDate'=>Carbon::now()->toDateString()]);
            return Response::json(['success' => 'Transfer Voided']);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function undotransfer(Request $request)
    {
        $findid=$request->undovoidid;
        $tran=transfer::find($findid);
        $statusval=$tran->Status;
        $oldstatusval=$tran->OldStatus;
        $storeId=$tran->SourceStoreId;
        $fiscalyr=$tran->fiscalyear;
        $fiscalyearval=$tran->fiscalyear;
        $docnum=$tran->IssueDocNumber; 
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $reqtype="Transfer";
        $itemidvals="";
        $itemqnt="0";
        $runqnt="0";
        $totalqnt="0";
        $eachqntval="0";
        $avaq="0";
        $tempcntitemid=[];
        $totalitemid=[];
        $eachqnt=[];
        $tempididval="";
        $totalitemidval="";
        if($oldstatusval=="Issued")
        {
            $issuecon = DB::table('issues')->where('ReqId',$findid)->where('Type',$reqtype)->latest()->first();
            $issid=$issuecon->id;

            $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS tratemp'.$userid.''));
            $creatingtemptables=DB::statement('CREATE TEMPORARY TABLE tratemp'.$userid.' SELECT transactions.id,transactions.HeaderId,transactions.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,transactions.StoreId,uoms.Name AS UOM,transactions.StockIn,transactions.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY transactions.ItemId,transactions.StoreId ORDER BY transactions.id ASC)) AS AvailableQuantity,transactions.TransactionsType,transactions.FiscalYear FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE transactions.ItemId IN(SELECT transferdetails.ItemId FROM transferdetails WHERE transferdetails.HeaderId='.$findid.') AND transactions.FiscalYear='.$fiscalyearval.'');
            $modifytemptable=DB::statement('ALTER TABLE tratemp'.$userid.' MODIFY id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
            $recdetails=transferdetail::where('HeaderId',$findid)->get(['ItemId','Quantity']);
            foreach ($recdetails as $recdetails) {
                $itemidvals = $recdetails->ItemId;
                $itemqnt = $recdetails->Quantity;
                $updatestockingquantity=DB::select('INSERT INTO tratemp'.$userid.' (HeaderId,ItemId,StockOut,StoreId,TransactionsType,FiscalYear) VALUES ('.$findid.','.$itemidvals.','.$itemqnt.','.$storeId.',"Transfer",'.$fiscalyearval.')');
                $gettemptable=DB::select('SELECT tratemp'.$userid.'.id,tratemp'.$userid.'.HeaderId,tratemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,tratemp'.$userid.'.StoreId,uoms.Name AS UOM,tratemp'.$userid.'.StockIn,tratemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY tratemp'.$userid.'.ItemId,tratemp'.$userid.'.StoreId ORDER BY tratemp'.$userid.'.id ASC)) AS AvailableQuantity,tratemp'.$userid.'.TransactionsType FROM tratemp'.$userid.' INNER JOIN regitems ON tratemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON tratemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE tratemp'.$userid.'.ItemId='.$itemidvals.' AND tratemp'.$userid.'.FiscalYear='.$fiscalyearval.' AND tratemp'.$userid.'.StoreId='.$storeId.'');
                foreach($gettemptable as $row){
                    $eachqntval=$row->AvailableQuantity;
                    $eachqnt[]=$row->AvailableQuantity;
                    if($eachqntval<0){
                        $tempcntitemid[]=$row->ItemId;
                        $runqnt+=1;
                    }
                }
                if($eachqntval<0){
                    $totalitemid[]=$itemidvals;
                    $totalqnt+=1;
                }
            }
            $tempididval=implode(',',$tempcntitemid);
            $totalitemidval=implode(',',$totalitemid);
            $totaluniqueval = count(array_unique(array_merge($tempcntitemid,$totalitemid)));
          
            if($runqnt>=1||$totalqnt>=1)
            {
                $allitems=$tempididval.",".$totalitemidval;
                $getItemLists=DB::select('SELECT DISTINCT regitems.Name,regitems.id AS ApprovedItems,regitems.id AS AvailableItems FROM regitems WHERE regitems.id IN('.$allitems.')');
                return Response::json(['valerror'=>"error",'countedval'=>$totaluniqueval,'countItems'=>$getItemLists]);
            }
            else
            {
                $syncToTransactionundoVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,Date) SELECT "'.$issid.'",ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Undo-Void",ItemType,"'.$docnum.'","'.$fiscalyr.'","'.Carbon::now()->toDateString().'" FROM transferdetails WHERE transferdetails.HeaderId='.$findid);
                $updateTransactios=DB::select('update transactions set IsVoid=0 where HeaderId='.$issid.' AND TransactionType="Transfer" AND TransactionsType="Transfer"');
            }
        }
        $updateStatus=DB::select('update transfers set Status=OldStatus,UndoVoidBy="'.$user.'",UndoVoidDate="'.Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A').'",OldStatus="" where id='.$findid.'');
        return Response::json(['success' => '1']);    
    }

    public function showTransferDataFy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $req=DB::select('SELECT transfers.id,transfers.Type,transfers.DocumentNumber,transfers.IssueDocNumber,sstores.Name as SourceStore,dstores.Name as DestinationStore,transfers.Date,transfers.TransferBy,transfers.Status,transfers.Reason,transfers.created_at,transfers.OldStatus,transfers.IssueId,transfers.PreparedBy FROM transfers INNER JOIN stores as sstores ON transfers.SourceStoreId=sstores.id INNER JOIN stores as dstores on transfers.DestinationStoreId=dstores.id WHERE (transfers.DestinationStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type IN(9,15)) OR transfers.SourceStoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type IN(2,3,8))) AND transfers.fiscalyear in('.$fy.') ORDER BY transfers.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editln='';
                $deleteln='';
                $println='';
                $sivln='';
                $unvoidvlink='';
                if($data->Status=='Issued')
                {
                    $editln='';
                    if($user->can('Void-Transfer-After-Issue'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    } 
                    $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STRV</span></a>';
                    $sivln=' <a class="dropdown-item printTrIssueAttachment" href="javascript:void(0)" data-link="/isstr/'.$data->IssueId.'" id="printSTIV" data-attr="" title="Print Store Transfer Issue Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                    $unvoidvlink='';
                }
                if($data->Status=='Issued(Received)')
                {
                    $editln='';
                    $deleteln='';
                    $unvoidvlink='';
                    $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STRV</span></a>';
                    $sivln=' <a class="dropdown-item printTrIssueAttachment" href="javascript:void(0)" data-link="/isstr/'.$data->IssueId.'" id="printSTIV" data-attr="" title="Print Store Transfer Issue Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                }
                else if($data->Status=='Pending')
                {
                    if($user->can('Transfer-Edit'))
                    {
                        $editln='  <a class="dropdown-item editTransferRecord" onclick="edittransferdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Transfer-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                       
                    } 
                    $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STRV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Approved')
                {
                    $editln='';
                    if($user->can('Transfer-Void'))
                    {
                        $deleteln='  <a class="dropdown-item deleteRequisitionRecord" href="javascript:void(0)" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Void</span></a>';
                    }
                    $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STRV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Commented')
                {
                    if($user->can('Transfer-Edit'))
                    {
                        $editln='  <a class="dropdown-item editTransferRecord" onclick="edittransferdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $deleteln='';
                    $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STRV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Corrected')
                {
                    if($user->can('Transfer-Edit'))
                    {
                        $editln='  <a class="dropdown-item editTransferRecord" onclick="edittransferdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->SourceStore.'" data-dst="'.$data->DestinationStore.'" data-typ="'.$data->Type.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $deleteln='';
                    $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STRV</span></a>';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Rejected')
                {
                    $editln='';
                    $deleteln='';
                    $println='';
                    $sivln='';
                    $unvoidvlink='';
                }
                else if($data->Status=='Void' || $data->Status=='Void(Pending)' || $data->Status=='Void(Issued)' || $data->Status=='Void(Approved)')
                {
                    $editln='';
                    $deleteln='';
                    
                    if($data->Status=='Void(Pending)' || $data->Status=='Void(Approved)'){
                        if($user->can('Transfer-Void'))
                        {
                            $unvoidvlink= '<a class="dropdown-item undovoidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                        }
                        $sivln='';
                        $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STRV</span></a>';
                    }
                    if($data->Status=='Void(Issued)'){
                        if($user->can('Void-Transfer-After-Issue'))
                        {
                            $unvoidvlink= '<a class="dropdown-item undovoidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                        }
                        $println=' <a class="dropdown-item printTraAttachment" href="javascript:void(0)" data-link="/tr/'.$data->id.'" id="printSTV" data-attr="" title="Print Store Transfer Voucher Attachment"><i class="fa fa-file"></i><span> Print STRV</span></a>';
                        $sivln=' <a class="dropdown-item printTrIssueAttachment" href="javascript:void(0)" data-link="/isstr/'.$data->IssueId.'" id="printSTIV" data-attr="" title="Print Store Transfer Issue Voucher Attachment"><i class="fa fa-file"></i><span> Print STIV</span></a>';
                    }
                }
                $btn='<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item DocTraInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title="">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$editln.'
                        '.$deleteln.' 
                        '.$unvoidvlink.' 
                        '.$println.' 
                        '.$sivln.'
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
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
