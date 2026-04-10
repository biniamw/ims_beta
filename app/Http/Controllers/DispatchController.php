<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\prd_order;
use App\Models\prd_order_cert;
use App\Models\prd_order_detail;
use App\Models\prd_order_process;
use App\Models\prd_duration;
use App\Models\prd_biproduct;
use App\Models\prd_output;
use App\Models\transaction;
use App\Models\requisition;
use App\Models\requisitiondetail;
use App\Models\transfer;
use App\Models\transferdetail;
use App\Models\dispatchparent;
use App\Models\dispatchchild;
use App\Models\store;
use App\Models\lookup;
use App\Models\uom;
use App\Models\actions;
use App\Models\companyinfo;
use App\Models\systeminfo;
use App\Models\Salesitem;
use App\Models\Sales;
use Yajra\Datatables\Datatables;
use Exception;
use Carbon\Carbon;

class DispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $currentdate = Carbon::today()->toDateString();
        $fiscalyears = DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        $dispmodedata = DB::select('SELECT lookups.DispatchModeValue,lookups.DispatchModeName FROM lookups WHERE lookups.DispatchModeStatus="Active"');
        $transferdocnum = DB::select("SELECT * FROM ((SELECT transfers.id, transfers.DocumentNumber, 2 AS type FROM transfers WHERE transfers.Status IN ('Issued','Issued(Received)','Issued(Partially-Received)','Issued(Fully-Received)') AND transfers.DispatchStatus != 'Fully-Dispatched' ORDER BY transfers.DocumentNumber DESC LIMIT 100) UNION ALL (SELECT requisitions.id, requisitions.DocumentNumber, 3 AS type FROM requisitions WHERE requisitions.Status IN ('Issued','Issued(Received)','Issued(Partially-Received)','Issued(Fully-Received)') ORDER BY requisitions.DocumentNumber DESC LIMIT 100) UNION ALL (SELECT sales.id, CONCAT_WS(', ', IFNULL(sales.VoucherNumber,''), IFNULL(sales.invoiceNo,'')) AS DocumentNumber, 1 AS type FROM sales WHERE sales.Status = 'Confirmed' AND sales.dispatch_status != 'Fully-Dispatched' ORDER BY DocumentNumber DESC LIMIT 100)) AS combined ORDER BY DocumentNumber DESC");
        //$transferdocnum = DB::select('SELECT transfers.id,transfers.DocumentNumber,2 AS type FROM transfers WHERE transfers.Status IN("Issued","Issued(Received)","Issued(Partially-Received)","Issued(Fully-Received)") UNION SELECT requisitions.id,requisitions.DocumentNumber,3 AS type FROM requisitions WHERE requisitions.Status IN("Issued","Issued(Received)","Issued(Partially-Received)","Issued(Fully-Received)") UNION SELECT sales.id,CONCAT_WS(", ",IFNULL(sales.VoucherNumber,""),IFNULL(sales.invoiceNo,"")) AS DocumentNumber,1 AS type FROM sales WHERE sales.Status IN("Confirmed") ORDER BY DocumentNumber DESC');
        $transferitem = DB::select('SELECT transferdetails.id,transferdetails.HeaderId,transferdetails.ItemId,CONCAT(IFNULL(regitems.Code,""),"	,	",IFNULL(regitems.Name,""),"	,	",IFNULL(regitems.SKUNumber,"")) AS ItemName FROM transferdetails LEFT JOIN regitems ON transferdetails.ItemId=regitems.id WHERE transferdetails.Quantity != IFNULL(transferdetails.DispatchQuantity, 0) ORDER BY transferdetails.id DESC');
        $salesitem = DB::select('SELECT salesitems.id,salesitems.HeaderId,salesitems.ItemId,CONCAT(IFNULL(regitems.Code,""),", ",IFNULL(regitems.Name,""),", ",IFNULL(regitems.SKUNumber,"")) AS ItemName FROM salesitems LEFT JOIN regitems ON salesitems.ItemId=regitems.id WHERE salesitems.Quantity != IFNULL(salesitems.dispatched_qty, 0) ORDER BY salesitems.id DESC');

        if($request->ajax()) {
            return view('logistic.dispatch',['fiscalyears' => $fiscalyears,'dispmodedata' => $dispmodedata,'transferdocnum' => $transferdocnum,
            'transferitem' => $transferitem,'salesitem' => $salesitem,'curdate' => $currentdate,'fiscalyr' => $fyear])->renderSections()['content'];
        }
        else{
            return view('logistic.dispatch',['fiscalyears' => $fiscalyears,'dispmodedata' => $dispmodedata,'transferdocnum' => $transferdocnum,
            'transferitem' => $transferitem,'salesitem' => $salesitem,'curdate' => $currentdate,'fiscalyr' => $fyear]);
        }
    }

    public function getDispatchData($fy)
    {
        $dispdata = DB::table('dispatchparents')
        ->select(
            'lookups.DispatchModeName',
            DB::raw('CONCAT(IFNULL(dispatchparents.DriverName,""),IFNULL(dispatchparents.PersonName,"")) AS DriverOrPersonName'),
            DB::raw('CONCAT(IFNULL(REPLACE(dispatchparents.DriverPhoneNo,"-",""),""),IFNULL(REPLACE(dispatchparents.PersonPhoneNo,"-",""),"")) AS DriverOrPersonPhone'),
            'dispatchparents.*',
            'requisitions.Status AS ReqStatus',
            DB::raw('CASE 
                        WHEN dispatchparents.Type = 1 THEN "Sales"
                        WHEN dispatchparents.Type = 2 THEN "Transfer"
                    END AS DispatchType'),
            'dispatchparents.Type'
        )
        ->leftJoin('lookups', 'dispatchparents.DispatchMode', '=', 'lookups.DispatchModeValue')
        ->leftJoin('requisitions', 'dispatchparents.ReqId', '=', 'requisitions.id')
        ->where('dispatchparents.FiscalYear', $fy)
        ->orderByDesc('dispatchparents.id')
        ->get();

        return datatables()->of($dispdata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function store(Request $request){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime = Carbon::now();
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        
        $findid = $request->recordId;

        $RecDocumentNumber = null;
        $currentdocnum = null;
        $disIds = [];
        $actions = null;

        $dispatchqty = 0;
        $reqqty = 0;

        $recpropdata = dispatchparent::latest()->first(['dispatchparents.CurrentDocumentNumber']);
        $RecDocumentNumber = $settings->DispDocOwnerPrefix.sprintf("%05d",($recpropdata->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
        $currentdocnum = ($recpropdata->CurrentDocumentNumber ?? 0)+1;

        $validator = Validator::make($request->all(),[
            'DispatchMode' => 'required',
            'DispatchType' => 'required',
            'DriverName' => 'required_if:DispatchMode,1',
            'date' => 'required',
            'DriverLicenseNo' => ['required_if:DispatchMode,1',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('DriverLicenseNo','!=',"");
            })->ignore($findid)],

            'DriverPhoneNo' => ['required_if:DispatchMode,1',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('DriverPhoneNo','!=',"");
            })->ignore($findid)],

            'PlateNumber' => ['required_if:DispatchMode,1',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('PlateNumber','!=',"");
            })->ignore($findid)],

            'ContainerNumber' => ['nullable',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('ContainerNumber','!=',"");
            })->ignore($findid)],

            'SealNumber' => ['nullable',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('SealNumber','!=',"");
            })->ignore($findid)],

            'PersonName' => 'required_if:DispatchMode,2',
            
            'PersonPhoneNo' => ['required_if:DispatchMode,2',Rule::unique('dispatchparents')->where(function ($query) use($request) {
                return $query->where('ReqId',$request->dispatchRecId)->where('PersonPhoneNo','!=',"");
            })->ignore($findid)],
        ]);

        $rules = array(
            'row.*.DocumentNum' => 'required',
            'row.*.ItemName' => 'required',
            'row.*.Quantity' => 'required',
        );

        $v2 = Validator::make($request->all(), $rules);

        if($validator->passes() && $v2->passes() && $request->row != null){
            DB::beginTransaction();
            try{
                $DbData = dispatchparent::where('id',$findid)->first();
                $BasicVal = [
                    'Type' => $request->DispatchType,
                    'DispatchMode' =>  $request->DispatchMode,
                    'Date' =>  $request->date,
                    'DriverName' =>  $request->DriverName,
                    'DriverLicenseNo' =>  $request->DriverLicenseNo,
                    'DriverPhoneNo' =>  $request->DriverPhoneNo,
                    'PlateNumber' => strtoupper($request->PlateNumber),
                    'ContainerNumber' =>  $request->ContainerNumber,
                    'SealNumber' =>  $request->SealNumber,
                    'PersonName' =>  $request->PersonName,
                    'PersonPhoneNo' =>  $request->PersonPhoneNo,
                    'Remark' =>  $request->Remark,
                    'FiscalYear' => $fyear,
                ];

                $CreateData = ['DispatchDocNo' => $RecDocumentNumber,
                                'CurrentDocumentNumber' => $currentdocnum,
                                'Status' => "Draft",
                                'Date' => Carbon::today()->toDateString(),
                                'PreparedBy' => $user,
                                'PreparedDate' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                                'VerifiedBy' => "",
                                'VerifiedDate' => "",
                                'ApprovedBy' => "",
                                'ApprovedDate' => "",
                                'ReceivedBy' => "",
                                'ReceivedDate' => "",
                            ];

                $UpdateData = ['updated_at' => Carbon::now()];

                $recpropdb = dispatchparent::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $UpdateData : $CreateData),
                );

                foreach ($request->row as $key => $value){
                    $disIds[]=$value['id'];
                }

                dispatchchild::where('dispatchchildren.dispatchparents_id',$recpropdb->id)->whereNotIn('id',$disIds)->delete();

                foreach ($request->row as $key => $value){
                    dispatchchild::updateOrCreate(['id' => $value['id']],
                    [ 
                        'ReqDetailId' => $value['ItemName'],
                        'dispatchparents_id' => (int)$recpropdb->id,
                        'Quantity' => $value['Quantity'],
                        'Remark' => $value['remark'],
                    ]); 
                }

                $actions = $findid == null ? "Created" : "Edited";

                if($request->DispatchType == 1){
                    $this->updateSalesDispatchStatus($recpropdb->id);
                    $this->updateSalesDispatchQuantity($recpropdb->id);
                }
                else if($request->DispatchType == 2){
                    $this->updateTrnDispatchStatus($recpropdb->id);
                    $this->updateTrnDispatchQuantity($recpropdb->id);
                }
                
                actions::insert(['user_id' => $userid,
                                'pageid' => $recpropdb->id,
                                'pagename' => "dispatch",
                                'action' => $actions,
                                'status' => $actions,
                                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                                'reason' => "",
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                
                DB::commit();
                return Response::json(['success' => 1, 'rec_id' => $recpropdb->id, 'fyear' => $fyear]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }

        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
        if($request->disprow==null)
        {
            return Response::json(['emptyerror'=> 462]);
        }
    }

    public function calcRemTransfer(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;

        $issuedqty=0;
        $uomname=null;
        $dispatchedqty=0;
        $dispatchcurrqty=0;
        $remqty=0;
        $status=["Draft","Pending","Verified","Approved"];
        $baseRecordId=$_POST['baseRecordId']; 
        $trnDetailId=$_POST['trnDetailId']; 

        $baseRecordId = !empty($baseRecordId) ? $baseRecordId : 0;
        $trnDetailId = !empty($trnDetailId) ? $trnDetailId : 0;

        $transferdata=transferdetail::leftJoin('regitems','transferdetails.ItemId','regitems.id')
                    ->leftJoin('uoms','regitems.MeasurementId','uoms.id')
                    ->where('transferdetails.id',$trnDetailId)
                    ->get(['transferdetails.IssuedQuantity','uoms.Name AS UOM']);

        $dispatchdata=dispatchchild::join('dispatchparents','dispatchchildren.dispatchparents_id','dispatchparents.id')
                    ->where('dispatchchildren.ReqDetailId',$trnDetailId)
                    ->whereIn('dispatchparents.Status',$status)
                    ->get([DB::raw('SUM(COALESCE(dispatchchildren.Quantity,0)) AS Quantity')]);

        $dispatchcurrentdata=dispatchchild::join('dispatchparents','dispatchchildren.dispatchparents_id','dispatchparents.id')
                    ->where('dispatchchildren.ReqDetailId',$trnDetailId)
                    ->where('dispatchchildren.dispatchparents_id',$baseRecordId)
                    ->whereIn('dispatchparents.Status',$status)
                    ->get([DB::raw('SUM(COALESCE(dispatchchildren.Quantity,0)) AS Quantity')]);

        
        $issuedqty=$transferdata[0]->IssuedQuantity;
        $uomname=$transferdata[0]->UOM;
        $dispatchedqty=$dispatchdata[0]->Quantity;
        $dispatchcurrqty=$dispatchcurrentdata[0]->Quantity;
        $remqty=round((((float)$issuedqty-(float)$dispatchedqty) + (float)$dispatchcurrqty),2);

        return response()->json(['issuedqty'=>$issuedqty,'uomname'=>$uomname,'remqty'=>$remqty]);
    }

    public function calcRemSales(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;

        $issuedqty = 0;
        $uomname = null;
        $dispatchedqty = 0;
        $dispatchcurrqty = 0;
        $remqty = 0;
        $status = ["Draft","Pending","Verified","Approved"];
        $baseRecordId = $_POST['baseRecordId']; 
        $salesDetailId = $_POST['salesDetailId']; 

        $baseRecordId = !empty($baseRecordId) ? $baseRecordId : 0;
        $salesDetailId = !empty($salesDetailId) ? $salesDetailId : 0;

        $salesdata = Salesitem::leftJoin('regitems','salesitems.ItemId','regitems.id')
                    ->leftJoin('uoms','regitems.MeasurementId','uoms.id')
                    ->where('salesitems.id',$salesDetailId)
                    ->get(['salesitems.Quantity','uoms.Name AS UOM']);

        $dispatchdata = dispatchchild::join('dispatchparents','dispatchchildren.dispatchparents_id','dispatchparents.id')
                    ->where('dispatchchildren.ReqDetailId',$salesDetailId)
                    ->whereIn('dispatchparents.Status',$status)
                    ->get([DB::raw('SUM(COALESCE(dispatchchildren.Quantity,0)) AS Quantity')]);

        $dispatchcurrentdata = dispatchchild::join('dispatchparents','dispatchchildren.dispatchparents_id','dispatchparents.id')
                    ->where('dispatchchildren.ReqDetailId',$salesDetailId)
                    ->where('dispatchchildren.dispatchparents_id',$baseRecordId)
                    ->whereIn('dispatchparents.Status',$status)
                    ->get([DB::raw('SUM(COALESCE(dispatchchildren.Quantity,0)) AS Quantity')]);

        
        $issuedqty = $salesdata[0]->Quantity;
        $uomname = $salesdata[0]->UOM;
        $dispatchedqty = $dispatchdata[0]->Quantity;
        $dispatchcurrqty = $dispatchcurrentdata[0]->Quantity;
        $remqty=round((((float)$issuedqty-(float)$dispatchedqty) + (float)$dispatchcurrqty),2);

        return response()->json(['issuedqty'=>$issuedqty,'uomname'=>$uomname,'remqty'=>$remqty]);
    }

    public function fetchTransferDispData(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $recId=$_POST['recId'];
        $recId = !empty($recId) ? $recId : 0;

        $disparentdata=DB::select('SELECT lookups.DispatchModeName,requisitions.DocumentNumber,dispatchparents.*,CASE WHEN dispatchparents.Type=1 THEN "Sales" WHEN dispatchparents.Type=2 THEN "Transfer" END AS DispatchType FROM dispatchparents LEFT JOIN lookups ON dispatchparents.DispatchMode=lookups.DispatchModeValue LEFT JOIN requisitions ON dispatchparents.ReqId=requisitions.id WHERE dispatchparents.id='.$recId);

        $dispchilddata=DB::select('SELECT dispatchchildren.*,CASE WHEN dispatchparents.Type=1 THEN CONCAT(IFNULL(sales.VoucherNumber,""),", ",IFNULL(sales.invoiceNo,"")) WHEN dispatchparents.Type=2 THEN transfers.DocumentNumber ELSE "" END AS DocumentNumber,CASE WHEN dispatchparents.Type=1 THEN sales.id WHEN dispatchparents.Type=2 THEN transfers.id END AS TrId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber,uoms.Name AS UOM,CASE WHEN dispatchparents.Type=1 THEN salesitems.Quantity WHEN dispatchparents.Type=2 THEN transferdetails.IssuedQuantity END AS SoldIssued,dispatchchildren.Quantity AS DispatchedQnt,IFNULL(dispatchchildren.Remark,"") AS Remark,dispatchparents.Type FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id LEFT JOIN transferdetails ON dispatchchildren.ReqDetailId=transferdetails.id LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id LEFT JOIN salesitems ON dispatchchildren.ReqDetailId=salesitems.id LEFT JOIN sales ON salesitems.HeaderId=sales.id LEFT JOIN regitems ON ((dispatchparents.Type = 1 AND regitems.id = salesitems.ItemId) OR (dispatchparents.Type = 2 AND regitems.id = transferdetails.ItemId)) LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE dispatchchildren.dispatchparents_id='.$recId);        
        
        $activitydata=actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"dispatch")
            ->where('pageid',$recId)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['disparentdata'=>$disparentdata,'dispchilddata'=>$dispchilddata,'activitydata'=>$activitydata]);
    }

    public function showDisData($id,$dtype){
        
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;

        if($dtype == 1){
            $header_data = DB::select('SELECT sales.*,stores.Name AS pos FROM sales LEFT JOIN stores ON sales.StoreId=stores.id WHERE sales.id='.$id);
        }
        else if($dtype == 2){
            $header_data = DB::select('SELECT transfers.id,transfers.Type,transfers.DocumentNumber,sstores.Name AS SourceStore,dstores.Name AS DestinationStore,sstores.QtyOnHandFlag,sstores.CheckQtyOnHand,transfers.DestinationStoreId,transfers.SourceStoreId,transfers.Date,transfers.TransferBy,transfers.PreparedBy,transfers.Status,transfers.Reason,transfers.Memo,transfers.ApprovedBy,transfers.ApprovedDate,transfers.IssuedBy,transfers.IssuedDate,transfers.RejectedBy,transfers.RejectedDate,transfers.VoidBy,transfers.VoidDate,transfers.CommentedBy,transfers.CommentedDate,transfers.VoidReason,transfers.DeliveredBy,transfers.DeliveredDate,transfers.ReceivedBy,transfers.ReceivedDate,transfers.IssueDocNumber,transfers.UndoVoidBy,transfers.UndoVoidDate,transfers.fiscalyear,transfers.DispatchStatus FROM transfers LEFT JOIN stores AS sstores ON transfers.SourceStoreId=sstores.id LEFT JOIN stores AS dstores ON transfers.DestinationStoreId=dstores.id WHERE transfers.id='.$id);
        }
        return response()->json(['header_data' => $header_data]);       
    }

    public function showSalesDetailData($id)
    {
        $detailTable=DB::select('SELECT salesitems.id,salesitems.ItemId,salesitems.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,salesitems.Quantity,salesitems.dispatched_qty,uoms.Name as UOM,salesitems.Memo FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE salesitems.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function verifyTransferDispatch(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->dispverifiedid;
        $recprop=dispatchparent::find($findid);
        if($recprop->Status=="Pending"){
            try{
                $recprop->Status="Verified";
                $recprop->OldStatus="Verified";
                $recprop->VerifiedBy = $user;
                $recprop->VerifiedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $recprop->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"dispatch",'action'=>"Verified",'status'=>"Verified",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function BacktoTrnPendingDispatch(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtopendingidval;
        $recprop=dispatchparent::find($findid);

        $validator = Validator::make($request->all(),[
            'BackToPendingReason' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status=="Verified"){
                try{
                    $recprop->Status="Pending";
                    $recprop->OldStatus="Pending";
                    $recprop->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"dispatch",'action'=>"Back to Pending",'status'=>"Back to Pending",'reason'=>"$request->BackToPendingReason",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function approveTransferDispatch(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->dispapproveid;
        $recprop=dispatchparent::find($findid);
        
        if($recprop->Status == "Verified"){
            DB::beginTransaction();
            try{
                $recprop->Status = "Approved";
                $recprop->OldStatus = "Approved";
                $recprop->ApprovedBy = $user;
                $recprop->ApprovedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                $recprop->save();

                if($recprop->Type == 1){
                    $this->updateSalesDispatchStatus($recprop->id);
                    $this->updateSalesDispatchQuantity($recprop->id);
                }
                else if($recprop->Type == 2){
                    $this->updateTrnDispatchStatus($recprop->id);
                    $this->updateTrnDispatchQuantity($recprop->id);
                }
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"dispatch",'action'=>"Approved",'status'=>"Approved",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                DB::commit();
                return Response::json(['success' => '1']);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else{
            return Response::json(['statuserror' => 462]);
        }
    }

    public function receiveTransferDispatch(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $findid=$request->dispreceiveid;
        $recprop=dispatchparent::find($findid);
        
        if($recprop->Status=="Approved"){
            try{
                $recprop->Status="Received";
                $recprop->OldStatus="Received";
                $recprop->ReceivedBy = $user;
                $recprop->ReceivedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                
                $syncToTransactionData=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,DocumentNumber,TransactionsType,FiscalYear,Date,created_at,updated_at)SELECT transfers.id,transferdetails.ItemId,dispatchchildren.Quantity,transferdetails.UnitCost,ROUND((dispatchchildren.Quantity*transferdetails.UnitCost),2),ROUND(((dispatchchildren.Quantity*transferdetails.UnitCost) * 0.15),2),ROUND((dispatchchildren.Quantity*transferdetails.UnitCost)*1.15,2),transfers.DestinationStoreId,"Transfer",transferdetails.ItemType,transfers.DocumentNumber,"Transfer",transfers.fiscalyear,"'.Carbon::today()->toDateString().'","'.Carbon::now().'","'.Carbon::now().'" FROM dispatchchildren LEFT JOIN transferdetails ON dispatchchildren.ReqDetailId=transferdetails.id LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE dispatchparents.id='.$findid);
                
                $recprop->save();
                $this->updateReceivedQuantity($recprop->id);
                $this->updateTransferStatus($recprop->id);
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"dispatch",'action'=>"Received",'status'=>"Received",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function dispatchForwardAction(Request $request)
    {
        $val_status = ["Draft","Pending","Verified","Approved","Issued","Received"];

        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;

            $sett = DB::table('settings')->latest()->first();
            $fiscalyrcomp = $sett->FiscalYear;

            $findid = $request->forwardReqId;
            $req = dispatchparent::find($findid);
            $currentStatus = $req->Status;
            $newStatus = $request->newForwardStatusValue;
            $action = $request->forwardActionValue;
            $req->Status = $newStatus;
            $docnum = $req->DispatchDocNo;
            $fiscalyr = $req->FiscalYear;

            if($newStatus == "Verified"){
                $req->VerifiedBy = $user;
                $req->VerifiedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }

            if($newStatus == "Approved"){
                $req->ApprovedBy = $user;
                $req->ApprovedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }

            if($newStatus == "Received"){
                $req->ReceivedBy = $user;
                $req->ReceivedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }
            $req->save();

            if($newStatus == "Approved"){
                if($req->Type == 1){
                    $this->updateSalesDispatchStatus($req->id);
                    $this->updateSalesDispatchQuantity($req->id);
                }
                else if($req->Type == 2){
                    $this->updateTrnDispatchStatus($req->id);
                    $this->updateTrnDispatchQuantity($req->id);
                }
            }

            if($newStatus == "Received"){
                $syncToTransactionData=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,DocumentNumber,TransactionsType,FiscalYear,Date,created_at,updated_at)SELECT transfers.id,transferdetails.ItemId,dispatchchildren.Quantity,transferdetails.UnitCost,ROUND((dispatchchildren.Quantity*transferdetails.UnitCost),2),ROUND(((dispatchchildren.Quantity*transferdetails.UnitCost) * 0.15),2),ROUND((dispatchchildren.Quantity*transferdetails.UnitCost)*1.15,2),transfers.DestinationStoreId,"Transfer",transferdetails.ItemType,transfers.DocumentNumber,"Transfer",transfers.fiscalyear,"'.Carbon::today()->toDateString().'","'.Carbon::now().'","'.Carbon::now().'" FROM dispatchchildren LEFT JOIN transferdetails ON dispatchchildren.ReqDetailId=transferdetails.id LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE dispatchparents.id='.$findid);
                
                $this->updateReceivedQuantity($req->id);
                $this->updateTransferStatus($req->id);
            }

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "dispatch",
                'action' => "$action",
                'status' => "$action",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            DB::commit();
            return Response::json(['success' => 1, 'rec_id' => $findid, 'fiscalyr' => $fiscalyr]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function dispatchBackwardAction(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->backwardReqId;
        $action = $request->backwardActionValue;
        $newStatus = $request->newBackwardStatusValue;
        $req = dispatchparent::find($findid);
        $fiscalyr = $req->fiscalyear;
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();
            try{
                $req->Status = $newStatus;

                if($newStatus == "Pending"){
                    $req->VerifiedBy = "";
                    $req->VerifiedDate = "";
                }

                if($newStatus == "Verified"){
                    $req->ApprovedBy = "";
                    $req->ApprovedDate = "";
                }

                if($newStatus == "Approved"){
                    $req->ReceivedBy = "";
                    $req->ReceivedDate = "";
                }
                $req->save();

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "dispatch",
                    'action' => "$action",
                    'status' => "$action",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "$request->CommentOrReason",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                
                DB::commit();
                return Response::json(['success' => 1, 'rec_id' =>  $findid, 'fiscalyr' => $fiscalyr]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }  
        }

        if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function voidTrnDispatchData(Request $request){
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime = Carbon::now();
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->voiddispid;
        $recprop = dispatchparent::find($findid);

        $validator = Validator::make($request->all(),[
            'DispatchReason' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status != "Void"){
                DB::beginTransaction();
                try{
                    $recprop->OldStatus = $recprop->Status;
                    $recprop->Status = "Void(".$recprop->OldStatus.")";
                    $recprop->save();
                    if($recprop->Type == 1){
                        $this->updateSalesDispatchStatus($recprop->id);
                        $this->updateSalesDispatchQuantity($recprop->id);
                    }
                    else if($recprop->Type == 2){
                        $this->updateTrnDispatchStatus($recprop->id);
                        $this->updateTrnDispatchQuantity($recprop->id);
                    }
                    
                    actions::insert([
                        'user_id' => $userid,
                        'pageid' => $findid,
                        'pagename' => "dispatch",
                        'action' => "Void",
                        'status' => "Void",
                        'reason' => "$request->DispatchReason",
                        'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    DB::commit();
                    return Response::json(['success' => 1, 'rec_id' => $findid, 'fyear' => $recprop->FiscalYear]);
                }
                catch(Exception $e)
                {
                    DB::rollBack();
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' => 462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function undoVoidTrnDispatchData(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime = Carbon::now();
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $dispqnt = 0;
        $compdisp = 0;
        $findid = $request->dispid;
        $recprop = dispatchparent::find($findid);
        $trid = $recprop->ReqId;

        $reqdetaildata = DB::select('SELECT COUNT(*) AS CompletedDispatch FROM transferdetails WHERE transferdetails.IssuedQuantity=transferdetails.DispatchQuantity AND transferdetails.id IN(SELECT dispatchchildren.ReqDetailId FROM dispatchchildren WHERE dispatchchildren.dispatchparents_id='.$findid.')');
        $compdisp = $reqdetaildata[0]->CompletedDispatch ?? 0;

        $dispqnt = !empty($dispqnt) ? $dispqnt : 0;
        
        $compdisp = !empty($compdisp) ? $compdisp : 0;

        if($compdisp > 0){
            return Response::json(['discerror' => 462]);
        }
        else{
            DB::beginTransaction();
            try{
                $recprop->Status = $recprop->OldStatus;
                $recprop->save();
                if($recprop->Type == 1){
                    $this->updateSalesDispatchStatus($recprop->id);
                    $this->updateSalesDispatchQuantity($recprop->id);
                }
                else if($recprop->Type == 2){
                    $this->updateTrnDispatchStatus($recprop->id);
                    $this->updateTrnDispatchQuantity($recprop->id);
                }

                actions::insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "dispatch",
                    'action' => "Undo Void",
                    'status' => "Undo Void",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                DB::commit();
                return Response::json(['success' => 1, 'rec_id' => $findid, 'fyear' => $recprop->FiscalYear]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
    }

    public function pendingTransferDispatch(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->pendingid;
        $recprop=dispatchparent::find($findid);
        
        if($recprop->Status=="Draft"){
            try{
                $recprop->Status="Pending";
                $recprop->OldStatus="Pending";
                $recprop->save();
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"dispatch",'action'=>"Change to Pending",'status'=>"Change to Pending",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function backToDraftTrnDispatch(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->commentid;
        $disp=dispatchparent::find($findid);

        $validator = Validator::make($request->all(),[
            'Comment' => 'required',
        ]);

        if($validator->passes()){
            if($disp->Status=="Pending"){
                try{
                    $disp->Status="Draft";
                    $disp->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"dispatch",'action'=>"Back to Draft",'status'=>"Back to Draft",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Comment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
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

    public function getDispatchDetailData($id)
    {
        $dispatchdetaildata=DB::select('SELECT dispatchchildren.*,CASE WHEN dispatchparents.Type=1 THEN CONCAT(IFNULL(sales.VoucherNumber,""),", ",IFNULL(sales.invoiceNo,"")) WHEN dispatchparents.Type=2 THEN transfers.DocumentNumber ELSE "" END AS DocumentNumber,CASE WHEN dispatchparents.Type=1 THEN sales.id WHEN dispatchparents.Type=2 THEN transfers.id END AS TrId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber,uoms.Name AS UOM,CASE WHEN dispatchparents.Type=1 THEN salesitems.Quantity WHEN dispatchparents.Type=2 THEN transferdetails.IssuedQuantity END AS SoldIssued,dispatchchildren.Quantity AS DispatchedQnt,IFNULL(dispatchchildren.Remark,"") AS Remark FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id LEFT JOIN transferdetails ON dispatchchildren.ReqDetailId=transferdetails.id LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id LEFT JOIN salesitems ON dispatchchildren.ReqDetailId=salesitems.id LEFT JOIN sales ON salesitems.HeaderId=sales.id LEFT JOIN regitems ON ((dispatchparents.Type = 1 AND regitems.id = salesitems.ItemId) OR (dispatchparents.Type = 2 AND regitems.id = transferdetails.ItemId)) LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE dispatchchildren.dispatchparents_id='.$id.' ORDER BY dispatchchildren.id DESC');        
        return datatables()->of($dispatchdetaildata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    private function updateTrnDispatchStatus($recid){
        $totalTrnQty=0;
        $totalDispQty=0;
        $getTransferData=DB::select('SELECT DISTINCT transfers.id FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id LEFT JOIN transferdetails ON dispatchchildren.ReqDetailId=transferdetails.id LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE dispatchparents.id='.$recid);
        foreach ($getTransferData as $row) {
            $gettrandata=DB::select('SELECT SUM(COALESCE(transferdetails.IssuedQuantity,0)) AS IssuedQuantity FROM transferdetails WHERE transferdetails.HeaderId='.$row->id);
            $totalTrnQty=$gettrandata[0]->IssuedQuantity ?? 0;  

            $getdispatchdata=DB::select('SELECT SUM(COALESCE(dispatchchildren.Quantity,0)) AS Quantity FROM dispatchchildren LEFT JOIN transferdetails ON dispatchchildren.ReqDetailId=transferdetails.id LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.Status IN("Approved") AND transferdetails.HeaderId='.$row->id);
            $totalDispQty=$getdispatchdata[0]->Quantity ?? 0;  

            if($totalDispQty == 0){
                transfer::where('transfers.id',$row->id)->update(['DispatchStatus'=>"-"]);
            }  
            else if($totalDispQty == $totalTrnQty){
                transfer::where('transfers.id',$row->id)->update(['DispatchStatus'=>"Fully-Dispatched"]);
            }  
            else if($totalDispQty != $totalTrnQty){
                transfer::where('transfers.id',$row->id)->update(['DispatchStatus'=>"Partially-Dispatched"]);
            }              
        }
    }

    private function updateSalesDispatchStatus($recid)
    {
        $totalTrnQty=0;
        $totalDispQty=0;
        $getTransferData=DB::select('SELECT DISTINCT sales.id FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id LEFT JOIN salesitems ON dispatchchildren.ReqDetailId=salesitems.id LEFT JOIN sales ON salesitems.HeaderId=sales.id WHERE dispatchparents.id='.$recid);
        foreach ($getTransferData as $row) {
            $gettrandata=DB::select('SELECT SUM(COALESCE(salesitems.Quantity,0)) AS SoldQuantity FROM salesitems WHERE salesitems.HeaderId='.$row->id);
            $totalTrnQty=$gettrandata[0]->SoldQuantity ?? 0;  

            $getdispatchdata=DB::select('SELECT SUM(COALESCE(dispatchchildren.Quantity,0)) AS Quantity FROM dispatchchildren LEFT JOIN salesitems ON dispatchchildren.ReqDetailId=salesitems.id LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.Status IN("Approved") AND salesitems.HeaderId='.$row->id);
            $totalDispQty=$getdispatchdata[0]->Quantity ?? 0;  

            if($totalDispQty == 0){
                Sales::where('sales.id',$row->id)->update(['dispatch_status'=>"-"]);
            }  
            else if($totalDispQty == $totalTrnQty){
                Sales::where('sales.id',$row->id)->update(['dispatch_status'=>"Fully-Dispatched"]);
            }  
            else if($totalDispQty != $totalTrnQty){
                Sales::where('sales.id',$row->id)->update(['dispatch_status'=>"Partially-Dispatched"]);
            }              
        }
    }

    private function updateTrnDispatchQuantity($recid)
    {        
        $requpdatedata=DB::select('SELECT dispatchchildren.ReqDetailId FROM dispatchchildren WHERE dispatchchildren.dispatchparents_id='.$recid);
        foreach ($requpdatedata as $row) {
           transferdetail::where('transferdetails.id',$row->ReqDetailId)->update(['transferdetails.DispatchQuantity'=>DB::raw('(SELECT ROUND(SUM(COALESCE(dispatchchildren.Quantity,0)),2) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.Status IN("Approved") AND dispatchchildren.ReqDetailId=transferdetails.id)')]);
        }
    }

    private function updateSalesDispatchQuantity($recid){        
        $requpdatedata=DB::select('SELECT dispatchchildren.ReqDetailId FROM dispatchchildren WHERE dispatchchildren.dispatchparents_id='.$recid);
        foreach ($requpdatedata as $row) {
           Salesitem::where('salesitems.id',$row->ReqDetailId)->update(['salesitems.dispatched_qty'=>DB::raw('(SELECT ROUND(SUM(COALESCE(dispatchchildren.Quantity,0)),2) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.Status IN("Approved") AND dispatchchildren.ReqDetailId=salesitems.id)')]);
        }
    }

    private function updateTransferStatus($recid){
        $totalIssuedQty = 0;
        $totalRecQty = 0;
        $getTransferData = DB::select('SELECT DISTINCT transfers.id FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id LEFT JOIN transferdetails ON dispatchchildren.ReqDetailId=transferdetails.id LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id WHERE dispatchparents.id='.$recid);
        foreach ($getTransferData as $row) {
            $gettrandata = DB::select('SELECT SUM(COALESCE(transferdetails.IssuedQuantity,0)) AS IssuedQuantity,SUM(COALESCE(transferdetails.ReceivedQuantity,0)) AS ReceivedQuantity FROM transferdetails WHERE transferdetails.HeaderId='.$row->id);
            $totalIssuedQty = $gettrandata[0]->IssuedQuantity ?? 0; 
            $totalRecQty = $gettrandata[0]->ReceivedQuantity ?? 0; 

            if($totalRecQty == 0){
                transfer::where('transfers.id',$row->id)->update(['Status'=>"Issued"]);
            }  
            else if($totalRecQty == $totalIssuedQty){
                transfer::where('transfers.id',$row->id)->update(['Status'=>"Issued(Fully-Received)"]);
            }  
            else if($totalRecQty != $totalIssuedQty){
                transfer::where('transfers.id',$row->id)->update(['Status'=>"Issued(Partially-Received)"]);
            }  
        }
    }

    function countDispatchStatus(){
        $fyear = $_POST['fyear']; 
        $dispatch_status_count = DB::select('SELECT dispatchparents.Status,FORMAT(COUNT(*),0) AS status_count FROM dispatchparents WHERE dispatchparents.FiscalYear='.$fyear.' GROUP BY dispatchparents.Status UNION SELECT "Total",FORMAT(COUNT(*),0) AS status_count FROM dispatchparents WHERE dispatchparents.FiscalYear='.$fyear);
 
        return response()->json(['dispatch_status_count' => $dispatch_status_count]); 
    }

    private function updateReceivedQuantity($recid)
    {        
        $requpdatedata=DB::select('SELECT dispatchchildren.ReqDetailId FROM dispatchchildren WHERE dispatchchildren.dispatchparents_id='.$recid);
        foreach ($requpdatedata as $row) {
           transferdetail::where('transferdetails.id',$row->ReqDetailId)->update(['transferdetails.ReceivedQuantity'=>DB::raw('(SELECT ROUND(SUM(COALESCE(dispatchchildren.Quantity,0)),2) FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id WHERE dispatchparents.Status IN("Received") AND dispatchchildren.ReqDetailId=transferdetails.id)')]);
        }
    }

    public function disptr($id)
    {
        if(dispatchchild::where('dispatchparents_id',$id)->exists())
        {
            $isstype="Transfer";
            $issueids="";
            error_reporting(0); 
            //---Start Header Info---
            $st="";
            $compId="1";
            $compInfo=companyinfo::find($compId);
            $companyname=$compInfo->Name;
            $companytin=$compInfo->TIN;
            $companyvat=$compInfo->VATReg;
            $companyphone=$compInfo->Phone;
            $companyoffphone=$compInfo->OfficePhone;
            $companyemail=$compInfo->Email;
            $companyaddress=$compInfo->Address;
            $companywebsite=$compInfo->Website;
            $companycountry=$compInfo->Country;
            $companyLogo=$compInfo->Logo;
            $companyalladdress=$compInfo->AllAddress;
            //---End Header Info----- 

            //---Start Footer Info---
            $sysId="1";
            $sysInfo=systeminfo::find($sysId);
            $systemname=$sysInfo->Name;
            $systemtin=$sysInfo->TIN;
            $systemvat=$sysInfo->VATReg;
            $systemphone=$sysInfo->Phone;
            $systemoffphone=$sysInfo->OfficePhone;
            $systememail=$sysInfo->Email;
            $systemaddress=$sysInfo->Address;
            $systemwebsite=$sysInfo->Website;
            $systemcountry=$sysInfo->Country;
            $systemalladdress=$sysInfo->AllAddress;
            //---End Footer Info----- 

            $headerInfo=dispatchparent::find($id);
            $docnum=$headerInfo->DispatchDocNo;
            $reqdate=$headerInfo->Date;
            $requestedby=$headerInfo->RequestedBy;
            $preparedby=$headerInfo->PreparedBy;
            $prepareddate=$headerInfo->PreparedDate;
            $approvedby=$headerInfo->ApprovedBy;
            $approveddate=$headerInfo->ApprovedDate;
            $verifiedby=$headerInfo->VerifiedBy;
            $verifieddate=$headerInfo->VerifiedDate;
            $storeid=$headerInfo->DriverName;
            $drivername=$headerInfo->DriverName.$headerInfo->PersonName;
            $driverlicenseno=$headerInfo->DriverLicenseNo;
            $driverphoneno=$headerInfo->DriverPhoneNo.$headerInfo->PersonPhoneNo;
            $plateno=$headerInfo->PlateNumber;
            $containerno=$headerInfo->ContainerNumber;
            $sealno=$headerInfo->SealNumber;
            $receivedby=$headerInfo->ReceivedBy;
            $receiveddate=$headerInfo->ReceivedDate;
            $remark=$headerInfo->Remark;
            $dispatch_type = $headerInfo->Type == 1 ? "Sales" : "Transfer";

            $reqProp=requisition::find($headerInfo->ReqId);
            $reqdocnum=$reqProp->DocumentNumber;

            $lookupProp = lookup::where('RequestReasonValue',$reqProp->RequestReason)->first();
            $reasonloading=$lookupProp->RequestReason;

            $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

            $status=$headerInfo->Status;
            if($status=="Void(Issued)" || $status=="Void(Pending)" || $status=="Void(Approved)"){
                $st="Void";
            }
            else if($status=="Rejected"){
                $st="Rejected";
            }
            else if($status=="Issued"){
                $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type','!=',$isstype)->latest()->first();
                $issueids=$issuecon->id;
                $st="";
            }
            else{
                $st="";
            }

            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT dispatchchildren.*,CASE WHEN dispatchparents.Type=1 THEN CONCAT(IFNULL(sales.VoucherNumber,""),", ",IFNULL(sales.invoiceNo,"")) WHEN dispatchparents.Type=2 THEN transfers.DocumentNumber ELSE "" END AS DocumentNumber,CASE WHEN dispatchparents.Type=1 THEN sales.id WHEN dispatchparents.Type=2 THEN transfers.id END AS TrId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber,uoms.Name AS UOM,CASE WHEN dispatchparents.Type=1 THEN salesitems.Quantity WHEN dispatchparents.Type=2 THEN transferdetails.IssuedQuantity END AS SoldIssued,dispatchchildren.Quantity AS DispatchedQnt,IFNULL(dispatchchildren.Remark,"") AS Remark FROM dispatchchildren LEFT JOIN dispatchparents ON dispatchchildren.dispatchparents_id=dispatchparents.id LEFT JOIN transferdetails ON dispatchchildren.ReqDetailId=transferdetails.id LEFT JOIN transfers ON transferdetails.HeaderId=transfers.id LEFT JOIN salesitems ON dispatchchildren.ReqDetailId=salesitems.id LEFT JOIN sales ON salesitems.HeaderId=sales.id LEFT JOIN regitems ON ((dispatchparents.Type = 1 AND regitems.id = salesitems.ItemId) OR (dispatchparents.Type = 2 AND regitems.id = transferdetails.ItemId)) LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE dispatchchildren.dispatchparents_id='.$id.' ORDER BY dispatchchildren.id DESC');        
            $count=0;

            $data=['detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'reqdocnum'=>$reqdocnum,
            'dates'=>$reqdate,
            'reqdate'=>$datetime,
            'reasonloading'=>$reasonloading,

            'approvedby'=>$approvedby,
            'approveddate'=>$approveddate,
            'verifiedby'=>$verifiedby,
            'verifieddate'=>$verifieddate,
            'preparedby'=>$preparedby,
            'prepareddate'=>$prepareddate,
            'receivedby'=>$receivedby,
            'receiveddate'=>$receiveddate,

            'drivername'=>$drivername,
            'plateno'=>$plateno,
            'driverphoneno'=>$driverphoneno,
            'containerno'=>$containerno,
            'sealno'=>$sealno,
            'dispatch_type'=>$dispatch_type,

            'remark'=>$remark,
            'count'=>$count,
            'currentdate'=>$currentdate,
            'companyname'=>$companyname,
            'companytin'=>$companytin,
            'companyvat'=>$companyvat,
            'companyphone'=>$companyphone,
            'companyoffphone'=>$companyoffphone,
            'companyemail'=>$companyemail,
            'companyaddress'=>$companyaddress,
            'companywebsite'=>$companywebsite,
            'companycountry'=>$companycountry,
            'companyalladdress'=>$companyalladdress,
            'companyLogo'=>$companyLogo,
            'systemname'=>$systemname,
            'systemtin'=>$systemtin,
            'systemvat'=>$systemvat,
            'systemphone'=>$systemphone,
            'systemoffphone'=>$systemoffphone,
            'systememail'=>$systememail,
            'systemaddress'=>$systemaddress,
            'systemwebsite'=>$systemwebsite,
            'systemcountry'=>$systemcountry,
            'systemalladdress'=>$systemalladdress,
        ];
            $mpdf=new \Mpdf\Mpdf([
                //'orientation' => 'L',
                'margin_left' => 2,
                'margin_right' => 2,
                'margin_top' => 37,
                'margin_bottom' => 25,
                'margin_header' => 0,
                'margin_footer' => 1
            ]); 

            $html=\View::make('inventory.report.disptr')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Dispatch Note ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->SetWatermarkText($status);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Dispatch-Note '.$docnum.'.pdf','I');

            // $pdf=PDF::loadView('inventory.report.req',$data);
            // return $pdf->stream();
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
