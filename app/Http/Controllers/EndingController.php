<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\customer;
use App\Models\mrc;
use App\Models\Regitem;
use App\Models\receivinghold;
use App\Models\receivingholddetail;
use App\Models\receiving;
use App\Models\receivingdetail;
use App\Models\serialandbatchnum_temp;
use App\Models\serialandbatchnum;
use App\Models\uom;
use App\Models\closing;
use App\Models\closingdetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EndingController extends Controller
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
        $fyear=$settings->FiscalYear;
        $brand=DB::select('select * from brands where ActiveStatus="Active" and IsDeleted=1');
        $edbrand=DB::select('select * from brands where ActiveStatus="Active" and IsDeleted=1');
        $storeSrc=DB::select('SELECT DISTINCT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=11 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');
        
        if($request->ajax()) {
            return view('inventory.ending',['storeSrc'=>$storeSrc,'brand'=>$brand,'fiscalyears'=>$fiscalyears])->renderSections()['content'];
        }
        else{
            return view('inventory.ending',['storeSrc'=>$storeSrc,'brand'=>$brand,'fiscalyears'=>$fiscalyears]);
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

    public function showEndingData()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $req=DB::select('SELECT closings.id,closings.DocumentNumber,stores.Name as Store,closings.FiscalYear,fiscalyear.Monthrange AS FiscalYearRange,DATE(closings.Date) AS Date,closings.Username,closings.beginningnumber,closings.Status FROM closings INNER JOIN stores ON closings.store_id=stores.id INNER JOIN fiscalyear ON closings.FiscalYear=fiscalyear.FiscalYear WHERE closings.FiscalYear='.$fyear.' AND closings.store_id IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=11) ORDER BY closings.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $infobtn='';
                $editbtn='';
                $startcountbtn='';
                $resumecount='';
                $countnoteln='';
                $begnoteln='';
                $adjustln='';
                if($data->Status=='Ready')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn=' <a class="dropdown-item startCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Start Counting</span>  </a>';
                    $infobtn='';
                    $resumecount='';
                    $countnoteln='';
                    $begnoteln='';
                    $adjustln='';
                }
                else if($data->Status=='Counting')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span></a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/en/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Done')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span>  </a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/en/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Verified')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn=' <a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span></a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/en/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Posted')
                {
                    $editbtn='';
                    $startcountbtn='';
                    $infobtn=' <a class="dropdown-item infoCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span>  </a>';
                    $resumecount='';
                    if($user->can('Begining-Adjust'))
                    {
                        $adjustln='  <a class="dropdown-item adjustmentBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Adjust</span></a>';
                    }
                    $begnoteln=' <a class="dropdown-item printBgAttachment" href="javascript:void(0)" data-link="/enp/'.$data->id.'" id="printbgatt" data-attr="" title="Print Begining Attachment"><i class="fa fa-file"></i><span> Print Attachment</span></a>';
                    $countnoteln=' ';
                  
                }
                $btn='<div class="btn-group dropleft">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        '.$infobtn.'
                        '.$startcountbtn.'
                        '.$resumecount.' 
                        '.$begnoteln.'  
                        '.$countnoteln.'   
                    </div>
                </div>';    
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
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->beginingId;
        $findid=$request->beginingId;
        $valstore=$request->store;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        $bprefix=$settingsval->EndingPrefix;
        $bnumber=$settingsval->EndingNumber;
        $numberPadding=sprintf("%06d", $bnumber);
        $bgNumber=$bprefix.$numberPadding;
        
        $documentnum="";
        if($valstore!=null){
            $getbeginningnum=DB::select('SELECT * FROM beginings WHERE beginings.StoreId='.$valstore.' ORDER BY beginings.id DESC LIMIT 1');
            foreach($getbeginningnum as $row)
            {
                $documentnum=$row->DocumentNumber;
            }

            $getPendingQty=DB::select('SELECT COUNT(id) AS ReceivingCount FROM receivings WHERE receivings.Status IN ("Pending","Checked") AND receivings.StoreId='.$valstore);
            foreach($getPendingQty as $row)
            {
                $receivingcnt=$row->ReceivingCount;
            }
            $reccnt = (float)$receivingcnt;
            $getTransferQty=DB::select('SELECT COUNT(id) AS TransferSourceCount FROM transfers WHERE transfers.Status IN ("Pending","Approved") AND transfers.SourceStoreId='.$valstore);
            foreach($getTransferQty as $row)
            {
                $transfersrccnt=$row->TransferSourceCount;
            }
            $trsrccnt = (float)$transfersrccnt;

            $getTransferDestQty=DB::select('SELECT COUNT(id) AS TransferDestCount FROM transfers WHERE transfers.Status IN ("Pending","Approved") AND transfers.DestinationStoreId='.$valstore);
            foreach($getTransferDestQty as $row)
            {
                $transferdestcnt=$row->TransferDestCount;
            }
            $trdestcnt = (float)$transferdestcnt;

            $getRequestonQty=DB::select('SELECT COUNT(id) AS RequistionSrcCount FROM requisitions WHERE requisitions.Status IN ("Pending","Approved") AND requisitions.SourceStoreId='.$valstore);
            foreach($getRequestonQty as $row)
            {
                $requistionsrccnt=$row->RequistionSrcCount;
            }
            $reqsrc = (float)$requistionsrccnt;

            $getSalesCount=DB::select('SELECT COUNT(id) AS SalesCount FROM sales WHERE sales.Status IN ("pending..","Checked") AND sales.StoreId='.$valstore);
            foreach($getSalesCount as $row)
            {
                $salescnt=$row->SalesCount;
            }
            $slcnt = (float)$salescnt;

            $getBeginingCount=DB::select('SELECT COUNT(id) AS BeginingCount FROM beginings WHERE beginings.Status!="Posted" AND beginings.StoreId='.$valstore);
            foreach($getBeginingCount as $row)
            {
                $beginingcnt=$row->BeginingCount;
            }
            $bgcnt = (float)$beginingcnt;

            $getRecHoldCount=DB::select('SELECT COUNT(id) AS ReceivingHoldCount FROM receivingholds WHERE receivingholds.StoreId='.$valstore);
            foreach($getRecHoldCount as $row)
            {
                $receivingholdcnt=$row->ReceivingHoldCount;
            }
            $recholdcnt = (float)$receivingholdcnt;

            $getSalesHoldCount=DB::select('SELECT COUNT(id) AS SalesHoldCount FROM sales_holds WHERE sales_holds.StoreId='.$valstore);
            foreach($getSalesHoldCount as $row)
            {
                $salesholdcnt=$row->SalesHoldCount;
            }
            $slholdcnt = (float)$salesholdcnt;

            $getBeginingData=DB::select('SELECT COUNT(id) AS BeginingCount FROM beginings WHERE beginings.StoreId='.$valstore.' AND beginings.Status!="Posted"');
            foreach($getBeginingData as $row)
            {
                $beginingcnt=$row->BeginingCount;
            }
            $beginingcnts = (float)$beginingcnt;

            $checkduplicate=DB::select('SELECT COUNT(id) AS CountId FROM closings WHERE closings.store_id='.$valstore.' AND closings.FiscalYear='.$fiscalyr);
            foreach($checkduplicate as $row)
            {
                $countid=$row->CountId;
            }
            $countids = (float)$countid;

            // if($reccnt>=1)
            // {
            //     return Response::json(['recerror' =>  "error"]);  
            // }
            // if($trsrccnt>=1)
            // {
            //     return Response::json(['trsrcerror' =>  "error"]);  
            // }
            // if($trdestcnt>=1)
            // {
            //     return Response::json(['trdesterror' =>  "error"]);  
            // }
            // if($reqsrc>=1)
            // {
            //     return Response::json(['reqerror' =>  "error"]);  
            // }
            // if($slcnt>=1)
            // {
            //     return Response::json(['saleserror' =>  "error"]);  
            // }
            if($countids>=1)
            {
                return Response::json(['duplicateerror' =>  "error"]);  
            }
            if($bgcnt>=1)
            {
                return Response::json(['beginingerror' =>  "error"]);  
            }
            // if($recholdcnt>=1)
            // {
            //     return Response::json(['recholderror' =>  "error"]);  
            // }
            // if($slholdcnt>=1)
            // {
            //     return Response::json(['salesholderror' =>  "error"]);  
            // }
        }
        if($findid!=null)
        {
            $validator = Validator::make($request->all(), [
                'store' => ['required'],
            ]);
            

            if ($validator->passes()) 
            {
                try
                {
                    $begining=closing::updateOrCreate(['id' => $request->beginingId], [
                        'store_id' => trim($request->store),
                    ]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
        }

        if($findid==null)
        {
            $validator = Validator::make($request->all(), [
                $bgNumber=>"unique:beginings,DocumentNumber,$findid",
                'store' => ['required'],        
            ]);

            if ($validator->passes())
            {
                try
                {
                    $begining=closing::updateOrCreate(['id' => $request->beginingId], [
                    'DocumentNumber' => $bgNumber,
                    'store_id' => $request->store,
                    'FiscalYear' => $fiscalyr,
                    'Username' => $user,
                    'Status' => "Ready",
                    'CalendarType' => "",
                    'Memo' => "-",
                    'Common' =>$request->commonVal,
                    'beginningnumber'=>$documentnum,
                    'Date'=>Carbon::now(),
                    ]);

                    //$updatestr=DB::select('update stores set IsOnCount=1 WHERE stores.id='.$valstore);
                    if($request->beginingId==null)
                    {
                        $updn=DB::select('update settings set EndingNumber=EndingNumber+1 where id=1');
                    }
                    return Response::json(['success' => '1']);
                }
                
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            $headerid=$request->beginingId;
            $strids=$request->store;
        }   
        
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }

        if($v2->fails())
        {
            return response()->json(['errorv2'  => $v2->errors()->all()]);
        }
    }

    public function editEnding($id)
    {
        $closing = closing::find($id);
        return response()->json(['closing'=>$closing]);
    }

    public function showEndingHeader($id)
    {
        $ids=$id;
        $pricing = DB::table('closingdetails')
            ->select(DB::raw('ROUND(SUM(BeforeTaxCost),2) as TotalCost'))
            ->where('header_id', '=', $id)
            ->get();
        $bgHeader=DB::select('SELECT closings.id,closings.store_id,closings.DocumentNumber,stores.Name AS Store,closings.Date,closings.FiscalYear,fiscalyear.Monthrange AS FiscalYearRange,closings.CountedBy,closings.CountedDate,closings.VerifiedBy,closings.VerifiedDate,closings.PostedBy,closings.PostedDate,closings.Status,closings.Memo FROM closings INNER JOIN stores as stores ON closings.store_id=stores.id INNER JOIN fiscalyear ON closings.FiscalYear=fiscalyear.FiscalYear where closings.id='.$id);
        return response()->json(['bgHeader'=>$bgHeader,'pricing'=>$pricing]);       
    }

    public function startEndingCountingCon(Request $request)
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $findid=$request->countid;
        $strid=$request->storeidi;
        $transactiontype="Begining";
        $syncToEnding=DB::select('INSERT INTO closingdetails(header_id,item_id,store_id,TransactionType,Date,Quantity,PhysicalCount,UnitCost)SELECT DISTINCT '.$findid.',ItemId,'.$strid.',"'.$transactiontype.'",'.Carbon::today()->toDateString().',(SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId='.$strid.' AND transactions.FiscalYear='.$fiscalyr.'),0)),(SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId='.$strid.' AND transactions.FiscalYear='.$fiscalyr.'),0)),(SELECT ROUND(SUM(COALESCE(BeforeTaxCost,0))/SUM(COALESCE(StockIn,0)),2) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.TransactionsType IN("Begining","Receiving","Adjustment")) from transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.StoreId='.$strid.' AND transactions.FiscalYear='.$fiscalyr.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId='.$strid.' AND transactions.FiscalYear='.$fiscalyr.'),0))!=0');
        
        DB::table('closingdetails')
            ->where('store_id',$strid)
            ->where('header_id',$findid)
            ->update(['Date'=>Carbon::today()->toDateString()]);

        $bg=closing::find($findid);
        $bg->Status="Counting";
        $bg->save();
        return Response::json(['success' => '1','date'=>Carbon::today()->toDateString()]);
    }
    
    public function syncBgEndItems(Request $request)
    {
        $begId=$request->recbgId;
        $begStoreId=$request->recbgStrId;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $getSyncCount=DB::select('SELECT COUNT(transactions.ItemId) AS Count FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.ItemId NOT IN (SELECT item_id FROM closingdetails WHERE closingdetails.store_id='.$begStoreId.' AND closingdetails.header_id='.$begId.') AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId='.$begStoreId.' AND transactions.FiscalYear='.$fiscalyr.'),0))!=0 AND transactions.StoreId='.$begStoreId);
        //$syncToBeginingDetail=DB::select('INSERT INTO closingdetails(header_id,item_id,store_id,TransactionType,Date,Quantity,UnitCost)SELECT '.$begId.',Id,Type,'.$begStoreId.',"Begining" from regitems where NOT EXISTS(SELECT ItemId FROM beginingdetails WHERE (regitems.Id=beginingdetails.ItemId AND beginingdetails.StoreId='.$begStoreId.' AND beginingdetails.HeaderId='.$begId.')) AND IsDeleted=1 AND Type!="Service"');
        $syncToEnding=DB::select('INSERT INTO closingdetails(header_id,item_id,store_id,TransactionType,Date,Quantity,UnitCost)SELECT DISTINCT '.$begId.',ItemId,'.$begStoreId.',"Begining",'.Carbon::today()->toDateString().',(SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId='.$begStoreId.' AND transactions.FiscalYear='.$fiscalyr.'),0)),(SELECT ROUND(SUM(COALESCE(BeforeTaxCost,0))/SUM(COALESCE(stockin,0)),2) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.TransactionsType IN("Begining","Receiving","Adjustment")) from transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.StoreId='.$begStoreId.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId='.$begStoreId.' AND transactions.FiscalYear='.$fiscalyr.'),0))!=0 AND transactions.FiscalYear='.$fiscalyr.' AND NOT EXISTS(SELECT item_id FROM closingdetails WHERE (transactions.ItemId=closingdetails.item_id AND closingdetails.store_id='.$begStoreId.' AND closingdetails.header_id='.$begId.'))');
        return Response::json(['success' => $begId,'syncCount'=>$getSyncCount]);
    }

    public function showEndingDetailData($id)
    {
        $cls=closing::find($id);
        $strid=$cls->store_id;
        $fiscalyr="";
        $settingsval = DB::table('settings')->latest()->first();
        $fyear=$settingsval->FiscalYear;
        $fychanged=$settingsval->IsFiscalYearChanged;
        if($fychanged==0){
            $fiscalyr=$fyear;
        }
        else if($fychanged==1){
            $fiscalyr=$fyear-1;
        }
        $detailTable=DB::select('SELECT closingdetails.id,closingdetails.item_id,closingdetails.header_id,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,closingdetails.Quantity AS AvailableQuantity,closingdetails.UnitCost AS AverageCost,closingdetails.PhysicalCount,closingdetails.ShortageVariance,closingdetails.OverageVariance,closingdetails.PartNumber,categories.Name as Category,uoms.Name as UOM,stores.Name as StoreName,(SELECT ROUND(regitems.WholesellerPrice/1.15,2)) AS MinSalePrice,closingdetails.Quantity,closingdetails.UnitCost,closingdetails.Memo,closingdetails.SerialNumberFlag,regitems.RequireSerialNumber,regitems.RequireExpireDate,(SELECT COALESCE((SELECT SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=closingdetails.item_id AND transactions.StoreId='.$strid.' AND transactions.FiscalYear='.$fiscalyr.'),0)) AS AllQuantity FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id inner join stores on closingdetails.store_id=stores.id inner join uoms on regitems.MeasurementId=uoms.id inner join categories on regitems.CategoryId=categories.id where regitems.IsDeleted=1 AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId='.$strid.' AND transactions.FiscalYear='.$fiscalyr.'),0))>0 AND closingdetails.header_id='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {
            $btn="";
            if($data->RequireSerialNumber=='Not-Require' && $data->RequireExpireDate=='Not-Require'){
                $btn="";
            }
            else{
                $btn =  ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm addSerialNumber" data-toggle="modal" id="mediumButton" style="color: white;" title="Add Serial Numbers"><i class="fa fa-plus"></i></a>';
            }     
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function startResumeEndingCountingCon($id)
    {
        $ids=$id;
        $cls=closing::find($id);
        $strid=$cls->store_id;
        $fyear=$cls->FiscalYear;
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s',$cls->Date)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $syncToEnding=DB::select('INSERT INTO closingdetails(header_id,item_id,store_id,TransactionType,Date,Quantity,PhysicalCount,UnitCost)SELECT DISTINCT '.$id.',ItemId,'.$strid.',"Begining","'.Carbon::now()->toDateString().'",(SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId='.$strid.' AND transactions.FiscalYear='.$fyear.'),0)),(SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId='.$strid.' AND transactions.FiscalYear='.$fyear.'),0)),(SELECT ROUND(SUM(COALESCE(BeforeTaxCost,0))/SUM(COALESCE(StockIn,0)),2) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.TransactionsType IN("Begining","Receiving","Adjustment")) FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.StoreId='.$strid.' AND transactions.FiscalYear='.$fyear.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId='.$strid.' AND transactions.FiscalYear='.$fyear.'),0))!=0 AND ItemId NOT IN (SELECT DISTINCT closingdetails.item_id FROM closingdetails WHERE closingdetails.header_id='.$id.')');
        
        $pricing = DB::table('closingdetails')
            ->select(DB::raw('ROUND(SUM(BeforeTaxCost),2) as TotalCost'))
            ->where('header_id', '=', $id)
            ->get();
        $bgHeader=DB::select('SELECT closings.id,closings.store_id,closings.DocumentNumber,stores.Name as Store,closings.beginningnumber,"'.$datetime.'" AS Date,fiscalyear.Monthrange AS FiscalYearRange,closings.CountedBy,closings.CountedDate,closings.VerifiedBy,closings.VerifiedDate,closings.PostedBy,closings.PostedDate,closings.Status,closings.Memo FROM closings INNER JOIN stores as stores ON closings.store_id=stores.id INNER JOIN fiscalyear ON closings.FiscalYear=fiscalyear.FiscalYear where closings.id='.$id);
        return response()->json(['bgHeader'=>$bgHeader,'pricing'=>$pricing]);       
    }

    public function unitcostEndingUpdate($id,$data)
    {
        try
        {
            if($data!=-1)
            {
                $bgdetail=closingdetail::findorFail($id);
                $bgdetail->UnitCost=$data;
                $bgdetail->save();
                return Response::json(['success' =>'12']);
            }

            if($data=='-1')
            {
                $varuc=null;
                $bgdetail=closingdetail::findorFail($id);
                $bgdetail->UnitCost=null;
                $bgdetail->save();
                return Response::json(['success' =>'null']);
            }
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }        
    }

    public function quantityEndingUpdate($id,$data)
    {
        try
        {
            $begin=closingdetail::find($id);
            $qnts=$begin->PhysicalCount;
            $avqnts=$begin->Quantity;
            $qn = (float)$data;
            $aqn = (float)$avqnts;
            $varience=$qn-$aqn;

            if($qnts!=$data && $data!=-1)
            {
                $bgdetail=closingdetail::findorFail($id);
                $bgdetail->PhysicalCount=$data;
                $bgdetail->SerialNumberFlag=0;
                if($varience<0){
                    $bgdetail->ShortageVariance=($varience)*(-1);
                    $bgdetail->OverageVariance=null;
                }
                else if($varience>0){
                    $bgdetail->OverageVariance=$varience;
                    $bgdetail->ShortageVariance=null;
                }
                else if($varience==0){
                    $bgdetail->OverageVariance=null;
                    $bgdetail->ShortageVariance=null;
                }
                $bgdetail->save();
                return Response::json(['success' => '1','available'=>$aqn,'counted'=>$qn,'variances'=>$varience]);
            }
            if($qnts==$data && $data!=-1)
            {
                $bgdetail=closingdetail::findorFail($id);
                $bgdetail->PhysicalCount=$data;
                if($varience<0){
                    $bgdetail->ShortageVariance=($varience)*(-1);
                    $bgdetail->OverageVariance=null;
                }
                else if($varience>0){
                    $bgdetail->OverageVariance=$varience;
                    $bgdetail->ShortageVariance=null;
                }
                else if($varience==0){
                    $bgdetail->OverageVariance=null;
                    $bgdetail->ShortageVariance=null;
                }
                $bgdetail->save();
                return Response::json(['success' => '1','available'=>$aqn,'counted'=>$qn,'varianced'=>$varience]);
            }
            if($data=='-1')
            {
                $bgdetail=closingdetail::findorFail($id);
                $bgdetail->PhysicalCount=null;
                if($varience<0){
                    $bgdetail->ShortageVariance=($varience)*(-1);
                    $bgdetail->OverageVariance=null;
                }
                else if($varience>0){
                    $bgdetail->OverageVariance=$varience;
                    $bgdetail->ShortageVariance=null;
                }
                else if($varience==0){
                    $bgdetail->OverageVariance=null;
                    $bgdetail->ShortageVariance=null;
                }
                $bgdetail->save();
                return Response::json(['success' => '1','available'=>$aqn,'counted'=>$qn,'variance'=>$varience]);
            }
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }   
    }

    public function showSerialNumberConEnding($id)
    {
        $recdataId = closingdetail::find($id);
        $itemid=$recdataId->item_id;
        $storeid=$recdataId->store_id;
        $itemProp = Regitem::find($itemid);
        $itemname=$itemProp->Name;
        $reqsn=$itemProp->RequireSerialNumber;
        $reqed=$itemProp->RequireExpireDate;
        $countedVal=DB::select('SELECT COUNT(item_id) AS ItemCount FROM serialandbatchnums WHERE item_id='.$itemid.' AND store_id='.$storeid);
        foreach($countedVal as $row)
        {
            $cnt=$row->ItemCount;
        }
        $cnts = (float)$cnt;
        return response()->json(['recDataId'=>$recdataId,'itemname'=>$itemname,'reqsn'=>$reqsn,'reqed'=>$reqed,'cnts'=>$cnts,'id'=>$id]);
    }

    public function showSerialNumbersEnding($sid,$nid)
    {
        $sernum=DB::select('SELECT serialandbatchnums.id,header_id,item_id,store_id,brand_id AS BrandId,brands.Name AS BrandName,ModelName,ManufactureDate,ExpireDate,SerialNumber,BatchNumber,IsIssued,TransactionDate FROM serialandbatchnums INNER JOIN brands ON serialandbatchnums.brand_id=brands.id WHERE store_id='.$sid.' and item_id='.$nid.' ORDER BY id DESC');
        return datatables()->of($sernum)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
                $btn =  ' <a class="btn btn-icon btn-gradient-info btn-sm editSN" data-id="'.$data->id.'" data-mod="'.$data->ModelName.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#sernumDeleteModal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function addSerialnumberConEnding(Request $request)
    {
        $itemid=$request->seritemid;
        $headerid=$request->serheaderid;
        $storeid=$request->serstoreid;
        $storeqnt=$request->storeQuantity;
        $tableids=$request->tableid;
        $qnt=$request->Quantity;
        $ItemInfo=Regitem::find($itemid);
        $reqSerialNum=$ItemInfo->RequireSerialNumber;
        $reqExpireDate=$ItemInfo->RequireExpireDate;
        $countitem = DB::table('serialandbatchnums')->where('store_id', '=', $storeid)->where('item_id', '=', $itemid)->get();
        $getCountItems = $countitem->count();
        $citem = (float)$getCountItems;
        $qitem = (float)$storeqnt;
        $scount = (float)$storeqnt;
        $qcount = (float)$qnt;
        $remvalue=$scount-$citem;
        $validator = Validator::make($request->all(), [
            'brand' => 'required',
            'modelNumber' => 'required',
            'ManufactureDate' => 'nullable|before:today',
        ]);
        $validator->sometimes('SerialNumber','required|nullable|unique:serialandbatchnums,SerialNumber,'.$tableids, function($request) {
            return ($request->serialnumreq=='Require');
        });

        $validator->sometimes('BatchNumber', 'required', function($request) {
            return ($request->expirenumreq=='Require-Both'||$request->expirenumreq=='Require-BatchNumber');
        });

        $validator->sometimes('Quantity', 'required|gt:0', function($request) {
            return ($request->expirenumreq=="Require-Both"||$request->serialnumreq=='Require-BatchNumber');
        });

        $validator->sometimes('ExpireDate', 'required|after:today', function($request) {
            return ($request->expirenumreq=="Require-Both"||$request->expirenumreq=="Require-ExpireDate");
        });

        if($citem>=$qitem && $tableids==null)
        {
            return Response::json(['valerror' =>  "error"]);
        }
        if($validator->passes())
        {
            try
            {
                if($tableids==null){
                    if($remvalue>=$qcount){
                        for ($i = 1; $i <= $qcount; $i++ ) {
                            $ser=new serialandbatchnum;
                            $ser->header_id=$request->serheaderid;
                            $ser->item_id=$request->seritemid;
                            $ser->store_id=$request->serstoreid;
                            $ser->brand_id=$request->brand;
                            $ser->ModelName=$request->modelNumber;
                            $ser->ManufactureDate=$request->ManufactureDate;
                            $ser->ExpireDate=$request->ExpireDate;
                            $ser->SerialNumber=$request->SerialNumber;
                            $ser->BatchNumber=$request->BatchNumber;
                            $ser->IsIssued=0;
                            $ser->IsSold=0;
                            $ser->TransactionType=1;
                            $ser->TransactionDate=Carbon::today()->toDateString();
                            $ser->save();
                        }
                    }
                    else if($remvalue<$qcount){
                        return Response::json(['qnterror' =>  "error"]);
                    }
                    
                }
                else if($tableids!=null){
                    $sernum=serialandbatchnum::updateOrCreate(['id' =>$request->tableid], [
                        'header_id' => $request->serheaderid,
                        'item_id' => $request->seritemid,
                        'store_id' => $request->serstoreid,
                        'brand_id' => $request->brand,
                        'ModelName' => $request->modelNumber,
                        'ManufactureDate' => $request->ManufactureDate,
                        'ExpireDate' => $request->ExpireDate,
                        'SerialNumber' => $request->SerialNumber,
                        'BatchNumber'=> $request->BatchNumber,
                        'IsIssued'=> 0,
                        'IsSold'=> 0,
                        'TransactionType'=>1,
                        'TransactionDate'=>Carbon::today()->toDateString(),
                    ]);
                }
                $countitem = DB::table('serialandbatchnums')->where('store_id', '=', $storeid)->where('item_id', '=', $itemid)->get();
                $getCountItem = $countitem->count();
                $getSerialNum=DB::select('SELECT GROUP_CONCAT(SerialNumber ," ") AS SerialNumber FROM serialandbatchnums WHERE header_id='.$headerid.' AND item_id='.$itemid);
                foreach ($getSerialNum as $row) 
                {
                    $ser=$row->SerialNumber;
                }
                DB::table('closingdetails')
                ->where('header_id', $headerid)
                ->where('item_id', $itemid)
                ->update(['SerialNumbers' => $ser]);
                if($qitem==$getCountItem)
                {
                    DB::table('closingdetails')
                    ->where('header_id', $headerid)
                    ->where('item_id', $itemid)
                    ->update(['SerialNumberFlag' =>1]);
                }
                return Response::json(['success' => '1','Totalcount'=>$getCountItem,'TotalQ'=>$qitem,'ser'=>$ser,'brand'=>$request->brand]);   
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

    public function countEndDone(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->doneid;
        $closingdet=closing::find($findid);
        $strid=$closingdet->store_id;
       
        $fiscalyr="";
        $settingsval = DB::table('settings')->latest()->first();
        $fyear=$settingsval->FiscalYear;
        $fychanged=$settingsval->IsFiscalYearChanged;
        if($fychanged==0){
            $fiscalyr=$fyear;
        }
        else if($fychanged==1){
            $fiscalyr=$fyear-1;
        }

        $getDescr=DB::select('SELECT COUNT(closingdetails.item_id) AS ItemCounts FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id INNER JOIN stores on closingdetails.store_id=stores.id INNER JOIN uoms on regitems.MeasurementId=uoms.id INNER JOIN categories on regitems.CategoryId=categories.id WHERE (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId=closingdetails.store_id AND transactions.FiscalYear="'.$fiscalyr.'"),0))!=COALESCE(closingdetails.PhysicalCount,0) AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId=closingdetails.store_id AND transactions.FiscalYear="'.$fiscalyr.'"),0))>0 AND regitems.IsDeleted=1 AND closingdetails.header_id='.$findid.' AND closingdetails.store_id='.$strid);
        foreach($getDescr as $row)
        {
            $countdesc=$row->ItemCounts;
        }
        $getCountedQuantity=DB::select('SELECT COUNT(item_id) AS ItemCount FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id WHERE closingdetails.store_id='.$strid.' AND closingdetails.PhysicalCount!=(select count(item_id) from serialandbatchnums WHERE serialandbatchnums.item_id=regitems.id AND serialandbatchnums.store_id='.$strid.') AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require") AND closingdetails.header_id='.$findid);
        foreach($getCountedQuantity as $row)
        {
            $countval=$row->ItemCount;
        }
        $countvals = (float)$countval;
        $countdsc = (float)$countdesc;
        if($countdsc>=1){
            $getalldecripancy=DB::select('SELECT CONCAT(regitems.Code," , ",regitems.Name," , ",regitems.SKUNumber) AS ItemName FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id inner join stores on closingdetails.store_id=stores.id INNER JOIN uoms on regitems.MeasurementId=uoms.id INNER JOIN categories on regitems.CategoryId=categories.id WHERE (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId=closingdetails.store_id AND transactions.FiscalYear="'.$fiscalyr.'"),0))!=COALESCE(closingdetails.PhysicalCount,0) AND regitems.IsDeleted=1 AND closingdetails.header_id='.$findid.' AND closingdetails.store_id='.$strid);
            return Response::json(['descerror' =>  "error",'countdescItems'=>$getalldecripancy,'countedescval'=>$countdsc]);
        }
        else if($countvals>=1)
        {
            $getUnfinishedItemName=DB::select('SELECT CONCAT(regitems.Code," , ",regitems.Name," , ",regitems.SKUNumber) AS ItemName FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id WHERE closingdetails.store_id='.$strid.' AND closingdetails.PhysicalCount!=(select count(item_id) from serialandbatchnums WHERE serialandbatchnums.item_id=regitems.id AND serialandbatchnums.store_id='.$strid.') AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require") AND closingdetails.header_id='.$findid);
            return Response::json(['valerror' =>  "error",'countItems'=>$getUnfinishedItemName,'countedval'=>$countvals]);
        }
        else{
            $bg=closing::find($findid);
            $bg->Status="Done";
            $bg->CountedBy= $user;
            $bg->CountedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $bg->save();
        }
        return Response::json(['success' => '1']);
    }

    public function countEndVerify(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->verifyid;
        $closingdet=closing::find($findid);
        $strid=$closingdet->store_id;
        
        $fiscalyr="";
        $settingsval = DB::table('settings')->latest()->first();
        $fyear=$settingsval->FiscalYear;
        $fychanged=$settingsval->IsFiscalYearChanged;
        if($fychanged==0){
            $fiscalyr=$fyear;
        }
        else if($fychanged==1){
            $fiscalyr=$fyear-1;
        }

        $getDescr=DB::select('SELECT COUNT(closingdetails.item_id) AS ItemCounts FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id inner join stores on closingdetails.store_id=stores.id INNER JOIN uoms on regitems.MeasurementId=uoms.id INNER JOIN categories on regitems.CategoryId=categories.id WHERE (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId=closingdetails.store_id AND transactions.FiscalYear="'.$fiscalyr.'"),0))!=COALESCE(closingdetails.PhysicalCount,0) AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId=closingdetails.store_id AND transactions.FiscalYear="'.$fiscalyr.'"),0))>0 AND regitems.IsDeleted=1 AND closingdetails.header_id='.$findid.' AND closingdetails.store_id='.$strid);
        foreach($getDescr as $row)
        {
            $countdesc=$row->ItemCounts;
        }
        $getCountedQuantity=DB::select('SELECT COUNT(item_id) AS ItemCount FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id WHERE closingdetails.store_id='.$strid.' AND closingdetails.PhysicalCount!=(select count(item_id) from serialandbatchnums WHERE serialandbatchnums.item_id=regitems.id AND serialandbatchnums.store_id='.$strid.') AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require") AND closingdetails.header_id='.$findid);
        foreach($getCountedQuantity as $row)
        {
            $countval=$row->ItemCount;
        } 
        $countvals = (float)$countval;
        $countdsc = (float)$countdesc;
       
        if($countdsc>=1){
            $getalldecripancy=DB::select('SELECT CONCAT(regitems.Code," , ",regitems.Name," , ",regitems.SKUNumber) AS ItemName FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id inner join stores on closingdetails.store_id=stores.id INNER JOIN uoms on regitems.MeasurementId=uoms.id INNER JOIN categories on regitems.CategoryId=categories.id WHERE (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId=closingdetails.store_id AND transactions.FiscalYear="'.$fiscalyr.'"),0))!=COALESCE(closingdetails.PhysicalCount,0) AND regitems.IsDeleted=1 AND closingdetails.header_id='.$findid.' AND closingdetails.store_id='.$strid);
            return Response::json(['descerror' =>  "error",'countdescItems'=>$getalldecripancy,'countedescval'=>$countdsc]);
        }
        else if($countvals>=1)
        {
            $getUnfinishedItemName=DB::select('SELECT CONCAT(regitems.Code," , ",regitems.Name," , ",regitems.SKUNumber) AS ItemName FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id WHERE closingdetails.store_id='.$strid.' AND closingdetails.PhysicalCount!=(select count(item_id) from serialandbatchnums WHERE serialandbatchnums.item_id=regitems.id AND serialandbatchnums.store_id='.$strid.') AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require") AND closingdetails.header_id='.$findid);
            return Response::json(['valerror' =>  "error",'countItems'=>$getUnfinishedItemName,'countedval'=>$countvals]);
        }
        else
        {
            $bg=closing::find($findid);
            $bg->Status="Verified";
            $bg->VerifiedBy= $user;
            $bg->VerifiedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $bg->save();
        }
        return Response::json(['success' => '1']);
    }

    public function countEndPost(Request $request)
    {
        $fyear="";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->postid;
        $rec=closing::find($findid);
        $strid=$rec->store_id;
        $documentnum=$rec->DocumentNumber;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $fyear=$fiscalyr-1;
        $fiscalyrchanged=$settingsval->IsFiscalYearChanged;

        $bprefix=$settingsval->BeginingPrefix;
        $bnumber=$settingsval->BeginingNumber;
        $numberPadding=sprintf("%06d", $bnumber);
        $bgNumber=$bprefix.$numberPadding;

        $getPendingQty=DB::select('SELECT COUNT(id) AS ReceivingCount FROM receivings WHERE receivings.StoreId='.$strid.' AND receivings.Status IN ("Pending","Checked")');
        foreach($getPendingQty as $row)
        {
            $receivingcnt=$row->ReceivingCount;
        }
        $reccnt = (float)$receivingcnt;

        $getTransferQty=DB::select('SELECT COUNT(id) AS TransferSourceCount FROM transfers WHERE transfers.SourceStoreId='.$strid.' AND transfers.Status IN ("Pending","Approved","Issued")');
        foreach($getTransferQty as $row)
        {
            $transfersrccnt=$row->TransferSourceCount;
        }
        $trsrccnt = (float)$transfersrccnt;

        $getTransferDestQty=DB::select('SELECT COUNT(id) AS TransferDestCount FROM transfers WHERE transfers.DestinationStoreId='.$strid.' AND  transfers.Status IN ("Pending","Approved","Issued")');
        foreach($getTransferDestQty as $row)
        {
            $transferdestcnt=$row->TransferDestCount;
        }
        $trdestcnt = (float)$transferdestcnt;

        $getRequestonQty=DB::select('SELECT COUNT(id) AS RequistionSrcCount FROM requisitions WHERE requisitions.SourceStoreId='.$strid.' AND requisitions.Status IN ("Pending","Approved")');
        foreach($getRequestonQty as $row)
        {
            $requistionsrccnt=$row->RequistionSrcCount;
        }
        $reqsrc = (float)$requistionsrccnt;

        $getAdjustmentQty=DB::select('SELECT COUNT(id) AS AdjustmentCount FROM adjustments WHERE adjustments.StoreId='.$strid.' AND adjustments.Status IN ("Pending","Checked")');
        foreach($getAdjustmentQty as $row)
        {
            $adjustmentcnt=$row->AdjustmentCount;
        }
        $adjcnts = (float)$adjustmentcnt;

        $getSalesCount=DB::select('SELECT COUNT(id) AS SalesCount FROM sales WHERE sales.StoreId='.$strid.' AND sales.Status IN ("pending..","Checked")');
        foreach($getSalesCount as $row)
        {
            $salescnt=$row->SalesCount;
        }
        $slcnt = (float)$salescnt;

        $getRecHoldCount=DB::select('SELECT COUNT(id) AS ReceivingHoldCount FROM receivingholds WHERE receivingholds.StoreId='.$strid);
        foreach($getRecHoldCount as $row)
        {
            $receivingholdcnt=$row->ReceivingHoldCount;
        }
        $recholdcnt = (float)$receivingholdcnt;

        $getSalesHoldCount=DB::select('SELECT COUNT(id) AS SalesHoldCount FROM sales_holds WHERE sales_holds.StoreId='.$strid);
        foreach($getSalesHoldCount as $row)
        {
            $salesholdcnt=$row->SalesHoldCount;
        }
        $slholdcnt = (float)$salesholdcnt;

        $getDescr=DB::select('SELECT COUNT(closingdetails.item_id) AS ItemCounts FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id inner join stores on closingdetails.store_id=stores.id INNER JOIN uoms on regitems.MeasurementId=uoms.id INNER JOIN categories on regitems.CategoryId=categories.id WHERE (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId=closingdetails.store_id AND transactions.FiscalYear="'.$fyear.'"),0))!=COALESCE(closingdetails.PhysicalCount,0) AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId=closingdetails.store_id AND transactions.FiscalYear="'.$fiscalyr.'"),0))>0 AND regitems.IsDeleted=1 AND closingdetails.header_id='.$findid.' AND closingdetails.store_id='.$strid);
        foreach($getDescr as $row)
        {
            $countdesc=$row->ItemCounts;
        }
        $getCountedQuantity=DB::select('SELECT COUNT(item_id) AS ItemCount FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id WHERE closingdetails.store_id='.$strid.' AND closingdetails.PhysicalCount!=(select count(item_id) from serialandbatchnums WHERE serialandbatchnums.item_id=regitems.id AND serialandbatchnums.store_id='.$strid.') AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require") AND closingdetails.header_id='.$findid);
        foreach($getCountedQuantity as $row)
        {
            $countval=$row->ItemCount;
        } 
       
        $countvals = (float)$countval;
        $countdsc = (float)$countdesc;
        if($fiscalyrchanged==0)
        {
            return Response::json(['fyerror' =>  "error"]);
        }
        else if($reccnt>=1)
        {
            return Response::json(['recerror' =>  "error"]);  
        }
        else if($trsrccnt>=1)
        {
            return Response::json(['trsrcerror' =>  "error"]);  
        }
        else if($trdestcnt>=1)
        {
            return Response::json(['trdesterror' =>  "error"]);  
        }
        else if($reqsrc>=1)
        {
            return Response::json(['reqerror' =>  "error"]);  
        }
        else if($adjcnts>=1)
        {
            return Response::json(['adjerror' =>  "error"]);  
        }
        else if($slcnt>=1)
        {
            return Response::json(['saleserror' =>  "error"]);  
        }
        else if($recholdcnt>=1)
        {
            return Response::json(['recholderror' =>  "error"]);  
        }
        else if($slholdcnt>=1)
        {
            return Response::json(['salesholderror' =>  "error"]);  
        }

        else if($countdsc>=1)
        {
            $getalldecripancy=DB::select('SELECT CONCAT(regitems.Code," , ",regitems.Name," , ",regitems.SKUNumber) AS ItemName FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id inner join stores on closingdetails.store_id=stores.id INNER JOIN uoms on regitems.MeasurementId=uoms.id INNER JOIN categories on regitems.CategoryId=categories.id WHERE (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id AND transactions.StoreId=closingdetails.store_id AND transactions.FiscalYear="'.$fyear.'"),0))!=COALESCE(closingdetails.PhysicalCount,0) AND regitems.IsDeleted=1 AND closingdetails.header_id='.$findid.' AND closingdetails.store_id='.$strid);
            return Response::json(['descerror' =>  "error",'countdescItems'=>$getalldecripancy,'countedescval'=>$countdsc]);
        }
        else if($countvals>=1)
        {
            $getUnfinishedItemName=DB::select('SELECT CONCAT(regitems.Code," , ",regitems.Name," , ",regitems.SKUNumber) AS ItemName FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id WHERE closingdetails.store_id='.$strid.' AND closingdetails.PhysicalCount!=(select count(item_id) from serialandbatchnums WHERE serialandbatchnums.item_id=regitems.id AND serialandbatchnums.store_id='.$strid.') AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require") AND closingdetails.header_id='.$findid);
            return Response::json(['valerror' =>  "error",'countItems'=>$getUnfinishedItemName,'countedval'=>$countvals]);
        }
       
        else
        {
            DB::table('closingdetails')
            ->where('header_id', $findid)
            ->update(['BeforeTaxCost' =>(DB::raw('(closingdetails.Quantity * closingdetails.UnitCost)')),'TaxAmount'=>(DB::raw('(closingdetails.BeforeTaxCost * 15)/100')),'TotalCost' =>(DB::raw('closingdetails.BeforeTaxCost + closingdetails.TaxAmount'))]);
            
            $updateRound=DB::select('UPDATE closingdetails SET closingdetails.BeforeTaxCost=ROUND((closingdetails.BeforeTaxCost),2),closingdetails.TaxAmount=ROUND((closingdetails.TaxAmount),2),closingdetails.TotalCost=ROUND((closingdetails.TotalCost),2)');
            
            $toBegining=DB::select('INSERT INTO beginings(DocumentNumber,StoreId,FiscalYear,Username,Status,CalendarType,Memo,Common,CountedBy,CountedDate,VerifiedBy,VerifiedDate,PostedBy,PostedDate,AdjustedBy,AdjustedDate,Date)SELECT "'.$bgNumber.'",store_id,FiscalYear+1,Username,"Posted",CalendarType,Memo,Common,CountedBy,CountedDate,VerifiedBy,VerifiedDate,"'.$user.'",PostedDate,AdjustedBy,AdjustedDate,Date FROM closings WHERE closings.id='.$findid);

            $toBeginingDetail=DB::select('INSERT INTO beginingdetails(HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,DestStoreId,LocationId,RetailerPrice,Wholeseller,Date,RequireSerialNumber,RequireExpireDate,ConvertedQuantity,ConversionAmount,NewUOMId,DefaultUOMId,ItemType,PartNumber,Memo,Common,TransactionType,SerialNumbers,SerialNumberFlag)SELECT (select id from beginings where beginings.StoreId='.$strid.' order by beginings.id desc LIMIT 1),item_id,PhysicalCount,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,store_id,deststore_id,location_id,RetailerPrice,Wholeseller,Date,RequireSerialNumber,RequireExpireDate,ConvertedQuantity,ConversionAmount,newuom_id,defaultuom_id,ItemType,PartNumber,Memo,Common,TransactionType,SerialNumbers,SerialNumberFlag FROM closingdetails WHERE closingdetails.PhysicalCount!=0 AND closingdetails.header_id='.$findid);

            $toTransaction=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,DocumentNumber,FiscalYear,TransactionsType,Date)SELECT (select id from beginings where beginings.StoreId='.$strid.' order by beginings.id desc LIMIT 1),item_id,PhysicalCount,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,store_id,TransactionType,ItemType,(select DocumentNumber from beginings where beginings.StoreId='.$strid.' order by beginings.id desc LIMIT 1),"'.$fiscalyr.'",TransactionType,"'.Carbon::today()->toDateString().'" FROM closingdetails WHERE closingdetails.PhysicalCount!=0 AND closingdetails.header_id='.$findid);

            DB::table('beginings')
            ->where('StoreId', $strid)
            ->where('FiscalYear', $fyear)
            ->update(['EndingDocumentNo'=>$documentnum]);

            DB::table('stores')
            ->where('id', $strid)
            ->update(['IsOnCount'=>"0",'FiscalYear'=>$fiscalyr]);
            
            $rec->Status="Posted";
            $rec->PostedBy= $user;
            $rec->PostedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $rec->save();
            $trtype="Void";
            $undotransaction="Undo-Void";
            $updateMaxCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.MaxCost = (SELECT ROUND(COALESCE(MAX(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId)');
            $updateAverageCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.averageCost = (SELECT ROUND(COALESCE(SUM(BeforeTaxCost),0)/(COALESCE(SUM(StockIn),0))*1.15,2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment"))');
            $updateMinCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.minCost = (SELECT ROUND(COALESCE(MIN(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId)');
            $updn=DB::select('UPDATE settings SET BeginingNumber=BeginingNumber+1 WHERE id=1');   
            return Response::json(['success' =>'1']);
        }
    }

    public function countEndComment(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->commentid;
        $bg=closing::find($findid);
        $validator = Validator::make($request->all(), [
            'Comment'=>"required",
        ]);
        if ($validator->passes())
        { 
            $bg->Memo=$request->input('Comment');
            $bg->Status="Counting";
            $bg->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function showEndHeader($id)
    {
        $ids=$id;
        $pricing = DB::table('closingdetails')
            ->select(DB::raw('ROUND(SUM(BeforeTaxCost),2) as TotalCost'))
            ->where('header_id', '=', $id)
            ->where('PhysicalCount', '!=', 0)
            ->get();

        $endrec = closing::find($id);
        $createddateval=$endrec->created_at;

        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $bgHeader=DB::select('SELECT closings.id,closings.store_id,closings.DocumentNumber,stores.Name as Store,closings.beginningnumber,fiscalyear.Monthrange AS FiscalYearRange,"'.$datetime.'" AS Date,closings.FiscalYear,closings.CountedBy,closings.CountedDate,closings.VerifiedBy,closings.VerifiedDate,closings.PostedBy,closings.PostedDate,closings.Status,closings.Memo FROM closings INNER JOIN stores as stores ON closings.store_id=stores.id INNER JOIN fiscalyear ON closings.FiscalYear=fiscalyear.FiscalYear where closings.id='.$id);
        return response()->json(['bgHeader'=>$bgHeader,'pricing'=>$pricing]);       
    }

    public function showEndingDetailPostedData($id)
    {
        $detailTable=DB::select('SELECT closingdetails.id,closingdetails.item_id,closingdetails.header_id,regitems.Code AS ItemCode,regitems.Name AS ItemName,COALESCE(CONCAT((SELECT GROUP_CONCAT(BatchNumber," ") FROM serialandbatchnums WHERE header_id=closingdetails.header_id AND item_id=regitems.id AND serialandbatchnums.TransactionType=1)),"") AS BatchNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT(SerialNumber," ") FROM serialandbatchnums WHERE header_id=closingdetails.header_id AND item_id=regitems.id AND serialandbatchnums.TransactionType=1)),"") AS SerialNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT(ExpireDate," ") FROM serialandbatchnums WHERE header_id=closingdetails.header_id AND item_id=regitems.id AND serialandbatchnums.TransactionType=1)),"") AS ExpireDate,COALESCE(CONCAT((SELECT GROUP_CONCAT(ManufactureDate," ") FROM serialandbatchnums WHERE header_id=closingdetails.header_id AND item_id=regitems.id AND serialandbatchnums.TransactionType=1)),"") AS ManufactureDate,regitems.SKUNumber AS SKUNumber,regitems.RequireSerialNumber,regitems.RequireExpireDate,closingdetails.PhysicalCount,closingdetails.PartNumber,categories.Name as Category,uoms.Name as UOM,stores.Name as StoreName,closingdetails.Quantity,closingdetails.UnitCost,closingdetails.BeforeTaxCost,closingdetails.TotalCost,closingdetails.Memo FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id inner join stores on closingdetails.store_id=stores.id inner join uoms on regitems.MeasurementId=uoms.id inner join categories on regitems.CategoryId=categories.id where closingdetails.header_id='.$id.' and closingdetails.PhysicalCount!=0 and closingdetails.UnitCost!=0');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showEndingDataFy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $req=DB::select('SELECT closings.id,closings.DocumentNumber,stores.Name as Store,closings.FiscalYear,fiscalyear.Monthrange AS FiscalYearRange,DATE(closings.Date) AS Date,closings.Username,closings.beginningnumber,closings.Status FROM closings INNER JOIN stores ON closings.store_id=stores.id INNER JOIN fiscalyear ON closings.FiscalYear=fiscalyear.FiscalYear WHERE closings.FiscalYear='.$fy.' AND closings.store_id IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=11) ORDER BY closings.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $infobtn='';
                $editbtn='';
                $startcountbtn='';
                $resumecount='';
                $countnoteln='';
                $begnoteln='';
                $adjustln='';
                if($data->Status=='Ready')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn=' <a class="dropdown-item startCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Start Counting</span>  </a>';
                    $infobtn='';
                    $resumecount='';
                    $countnoteln='';
                    $begnoteln='';
                    $adjustln='';
                }
                else if($data->Status=='Counting')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span></a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/en/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Done')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span>  </a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/en/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Verified')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn=' <a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span></a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/en/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Posted')
                {
                    $editbtn='';
                    $startcountbtn='';
                    $infobtn=' <a class="dropdown-item infoCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span>  </a>';
                    $resumecount='';
                    if($user->can('Begining-Adjust'))
                    {
                        $adjustln='  <a class="dropdown-item adjustmentBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Adjust</span></a>';
                    }
                    $begnoteln=' <a class="dropdown-item printBgAttachment" href="javascript:void(0)" data-link="/enp/'.$data->id.'" id="printbgatt" data-attr="" title="Print Begining Attachment"><i class="fa fa-file"></i><span> Print Attachment</span></a>';
                    $countnoteln=' ';
                  
                }
                $btn='<div class="btn-group dropleft">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        '.$infobtn.'
                        '.$startcountbtn.'
                        '.$resumecount.' 
                        '.$begnoteln.'  
                        '.$countnoteln.'   
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
