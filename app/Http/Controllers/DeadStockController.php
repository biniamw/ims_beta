<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\customer;
use App\Models\mrc;
use App\Models\Regitem;
use App\Models\receivinghold;
use App\Models\receivingholddetail;
use App\Models\receiving;
use App\Models\receivingdetail;
use App\Models\deadstock;
use App\Models\deadstockdetail;
use App\Models\deadstocksaleitem;
use App\Models\deadstocksale;
use App\Models\dstransactions;
use App\Models\transaction;
use App\Models\store;
use App\Models\uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class DeadStockController extends Controller
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
        $customerSrc=DB::select('select * from customers where CustomerCategory!="Customer" and CustomerCategory!="Person" and ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $storeSrc=DB::select('SELECT stores.id as StoreId,stores.Name as StoreName FROM stores WHERE stores.ActiveStatus="Active" AND stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $SourceStoreSrc = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $itembarcodetype=DB::select('SELECT DISTINCT regitems.BarcodeType FROM regitems');
        $itemSrc=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        //$itemSrc=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)))) AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId))>0 AND regitems.ActiveStatus="Active" AND transactions.FiscalYear='.$fiscalyr.' GROUP BY regitems.Name,transactions.StoreId  order by regitems.Name ASC');
        $itemSrcs=DB::select('select * from regitems where ActiveStatus="Active" and Type not in ("Service","Consumption") and IsDeleted=1 order by Name asc');
        $itemSrcAddHold=DB::select('select * from regitems where ActiveStatus="Active" and Type not in ("Service","Consumption") and IsDeleted=1 order by Name asc');
        $purchaser=DB::select('select * from users where IsPurchaser=1 and id>1');
        $itemSrcSales=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        $itemSrcsl=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fiscalyr.' AND (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id)>0 GROUP BY regitems.Name,transactions.StoreId order by regitems.Name ASC');
        $itemSrcpo=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,deadstocktransaction.ItemId,(SELECT if((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status="Pending/Removed" and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status="Pending/Removed" and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)))) AS Balance,deadstocktransaction.StoreId FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id WHERE (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=regitems.id)>0 GROUP BY regitems.Name,deadstocktransaction.StoreId  order by regitems.Name ASC');
        $customerSrcSales=DB::select('select * from customers where CustomerCategory!="Supplier" and CustomerCategory!="Foreigner-Supplier" and ActiveStatus="Active" and DefaultPrice!="" and IsDeleted=1 and id>1 order by Name asc');
        //$storeSrcSales=DB::select('SELECT stores.id as StoreId,stores.Name as StoreName FROM stores WHERE stores.ActiveStatus="Active" AND stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $storeSrcSales = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $storedestSrcSales=DB::select('SELECT stores.id as StoreId,stores.Name as StoreName FROM stores WHERE stores.ActiveStatus="Active" AND stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $storelists=DB::select('SELECT * FROM stores');
        $storelistsval=DB::select('SELECT * FROM stores');
        if($request->ajax()) {
            return view('inventory.deadstock',['customerSrc'=>$customerSrc,'storeSrc'=>$storeSrc,'SourceStoreSrc'=>$SourceStoreSrc,'itemSrc'=>$itemSrc,'itemSrcs'=>$itemSrcs,'itemSrcAddHold'=>$itemSrcAddHold,'purchaser'=>$purchaser,'user'=> $user,'itemSrcSales'=>$itemSrcSales,'customerSrcSales'=>$customerSrcSales,'storeSrcSales'=>$storeSrcSales,'storedestSrcSales'=>$storedestSrcSales,'itembarcodetype'=>$itembarcodetype,'itemSrcsl'=>$itemSrcsl,'itemSrcpo'=>$itemSrcpo,'storelists'=>$storelists,'storelistsval'=>$storelistsval])->renderSections()['content'];
        }
        else{
            return view('inventory.deadstock',['customerSrc'=>$customerSrc,'storeSrc'=>$storeSrc,'SourceStoreSrc'=>$SourceStoreSrc,'itemSrc'=>$itemSrc,'itemSrcs'=>$itemSrcs,'itemSrcAddHold'=>$itemSrcAddHold,'purchaser'=>$purchaser,'user'=> $user,'itemSrcSales'=>$itemSrcSales,'customerSrcSales'=>$customerSrcSales,'storeSrcSales'=>$storeSrcSales,'storedestSrcSales'=>$storedestSrcSales,'itembarcodetype'=>$itembarcodetype,'itemSrcsl'=>$itemSrcsl,'itemSrcpo'=>$itemSrcpo,'storelists'=>$storelists,'storelistsval'=>$storelistsval]);
        }
    }

    public function showDeadStockRecevingData()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $rechide='';
        if($users->can('Receiving-Hide'))
        {
            $rechide='1';
        }  
        else
        {
            $rechide='0';
        }
        $accepted=DB::select('SELECT deadstockrecs.id,deadstockrecs.Type,deadstockrecs.DocumentNumber,customers.CustomerCategory,CONCAT(str.Name) AS Source,customers.Name AS CustomerName,customers.TinNumber as TIN,deadstockrecs.PaymentType,deadstockrecs.VoucherType,deadstockrecs.VoucherNumber,deadstockrecs.CustomerMRC,stores.Name as StoreName,deadstockrecs.PurchaserName,deadstockrecs.IsVoid,deadstockrecs.VoidReason,deadstockrecs.VoidedBy,deadstockrecs.VoidedDate,deadstockrecs.TransactionDate,deadstockrecs.Status,deadstockrecs.StatusOld,deadstockrecs.WitholdPercent,deadstockrecs.WitholdAmount,deadstockrecs.SubTotal,deadstockrecs.Tax,deadstockrecs.GrandTotal,deadstockrecs.Username,deadstockrecs.ReceivedBy,deadstockrecs.DeliveredBy,deadstockrecs.Memo,deadstockrecs.IsHide,deadstockrecs.created_at FROM deadstockrecs INNER JOIN stores ON deadstockrecs.StoreId=stores.id INNER JOIN stores AS str ON deadstockrecs.SourceStore=str.id INNER JOIN customers on deadstockrecs.CustomerId=customers.id');
        if(request()->ajax()) {
            return datatables()->of($accepted)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $unvoidvlink='';
                $voidlink='';
                $editln='';
                $println='';
                $hideln='';
                $showln='';
                if($data->Status=='Void')
                {
                    if($user->can('HandIn-Void'))
                    {
                        $unvoidvlink= '<a class="dropdown-item" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->StatusOld.'" data-toggle="modal" id="dtundovoidbtn" data-target="#undovoidmodal" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                    }
                    $voidlink='';
                    $editln='';
                    $println='';
                }
                if($data->Status=='Pending/Defective')
                {
                    if($user->can('HandIn-Edit'))
                    {
                        $editln='<a class="dropdown-item editHandinRecord" onclick="edithandindata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('HandIn-Void'))
                    {
                        $voidlink='<a class="dropdown-item" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-type="'.$data->Type.'" data-toggle="modal" id="dtvoidbtn" data-target="#voidreasonmodal" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }
                    $println='';
                }
                if($data->Status=='Confirmed/Defective')
                {
                    if($user->can('Confirmed-HandIn-Edit'))
                    {
                        $editln='<a class="dropdown-item editHandinRecord" onclick="edithandindata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('HandIn-Void'))
                    {
                        $voidlink='<a class="dropdown-item" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-type="'.$data->Type.'" data-toggle="modal" id="dtvoidbtn" data-target="#voidreasonmodal" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }
                    $println='';
                }
                $btn='<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item DocDsRecInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title="">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$editln.'
                        '.$voidlink.'
                        '.$unvoidvlink.'
                        '.$showln.'
                        '.$hideln.'
                        '.$println.'
                        <a class="dropdown-item dshiatt" href="javascript:void(0)" data-link="/dshi/'.$data->id.'"  data-id="'.$data->id.'" data-status="'.$data->Status.'" data-original-title="Edit" title="See attachment">
                        <i class="fa fa-file"></i><span> Print Doc</span></a>   
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getDeadStockNumber()
    {
        $settings = DB::table('settings')->latest()->first();
        $hprefix=$settings->DeadStockPrefix;
        $hnumber=$settings->DeadStockCount;
        $fiscalyr=$settings->FiscalYear;
        $suffixdoc=$fiscalyr-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $hnumber);
        $dnumber=$hprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        $updn=DB::select('update countable set DeadStockCount=DeadStockCount+1 where id=1');
        $deadstockholdcnt = DB::table('countable')->latest()->first();
        $companyInfo = DB::table('companyinfos')->latest()->first();
        $witholdPer=$companyInfo->WitholdDeduct;
        return response()->json(['dnumber'=>$dnumber,'recnum'=>$dnumber,'DeadStockCount'=>$deadstockholdcnt->DeadStockCount]);
    }
    
    public function getSalesDeadStockNumber()
    {
        $settings = DB::table('settings')->latest()->first();
        $hprefix=$settings->DeadStockSalesPrefix;
        $hnumber=$settings->DeadStockSalesCount;
        $fiscalyr=$settings->FiscalYear;
        $suffixdoc=$fiscalyr-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $hnumber);
        $dnumber=$hprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        $updn=DB::select('update countable set DeadStockCount=DeadStockCount+1 where id=1');
        $deadstockholdcnt = DB::table('countable')->latest()->first();
        return response()->json(['dnumber'=>$dnumber,'recnum'=>$dnumber,'DeadStockCount'=>$deadstockholdcnt->DeadStockCount]);
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
        ini_set('max_execution_time', 12000000) ; // time in seconds
        $settings = DB::table('settings')->latest()->first();
        $hprefix=$settings->DeadStockPrefix;
        $hnumber=$settings->DeadStockCount;
        $fiscalyr=$settings->FiscalYear;
        $suffixdoc=$fiscalyr-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $hnumber);
        $dnumber=$hprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->receivingId;
        $findid=$request->receivingId;
        $customerid=$request->supplier;
        $cusid="1";
        $types=$request->Type;
        $hiddenstr=$request->hiddenstoreval;
        $hiddensrcstr=$request->hiddenstorevalsrc;
        $fiscalr="Fiscal-Receipt";
        $rectransactiontype="HandIn";
        $thisdate = Carbon::today()->toDateString();
        $cval="0";
        $upval="0";
        $statusval=null;
        $headeridsval=null;
        $insids=[];
        $dynamictblitem=[];
        $detailids=[];
        $unavailableitems=[];
        $upunavailableitems=[];
        $statusvalues=['HandIn','Undo-Void'];
        $unavitems="";
        $getItemLists="";
        $getremovedItemLists="";
        $documentnumbers="";
        $confirmdates="";
        $fiscalyearval="";
        $singleqnt="";
        $singlenonqnt="";
        $tempval=[];
        $tempvalnonex=[];
        $tt=[];
        $totaltempvals=[];
        $tempcnt=0;
        $tempcntitemid=[];
        $tempnoncnt=0;
        $tempnoncntitemid=[];
        $unavtempitems="";
        $unavnontempitems="";
        $dstypes="";
        $unavailableitemsmn=[];
        $cvalmn="0";
        $tempcntitemidmn=[];
        $tempcntmn="0";
        $unavitemsmn="";
        $unavtempitemsmn="";
        $upunavailableitemsmn=[];
        $upvalmn="0";
        $tempnoncntitemidmn=[];
        $tempnoncntmn="0";
        $unavnontempitemsmn="";
        $upunavitemsmn="";
        $totalresultsofst="0";
        $singleqntvalsa="0";
        $singleqntvalsb="0";
        $singleqntvalsc="0";
        $singleqntvalsd="0";
        
        if($types=="External")
        {
            if($findid!=null)
            {
                if($request->row==null){
                    return Response::json(['emptyerror'=>"error"]);
                }
                else{
                    $itemidlists=deadstockdetail::where('HeaderId', $request->receivingId)->get(['ItemId']);
                    foreach ($itemidlists as $itemidlists) {
                        $insids[] = $itemidlists->ItemId;
                    }
                    $recstatus=deadstock::where('id', $request->receivingId)->get(['Status','DocumentNumber','ConfirmedDate','Type']);
                    foreach ($recstatus as $recstatus) {
                        $statusval = $recstatus->Status;
                        $documentnumbers = $recstatus->DocumentNumber;
                        $confirmdates = $recstatus->ConfirmedDate;
                        $fiscalyearval = "0";
                        $dstypes= $recstatus->Type;
                    }
                    if($statusval=="Confirmed/Defective"){
                        $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS dshitemp'.$userid.''));
                        $creatingtemptables=DB::statement('CREATE TEMPORARY TABLE dshitemp'.$userid.' SELECT deadstocktransaction.id,deadstocktransaction.HeaderId,deadstocktransaction.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,deadstocktransaction.StoreId,uoms.Name AS UOM,deadstocktransaction.StockIn,deadstocktransaction.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY deadstocktransaction.ItemId,deadstocktransaction.StoreId ORDER BY deadstocktransaction.id ASC)) AS AvailableQuantity,deadstocktransaction.TransactionsType,deadstocktransaction.FiscalYear FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id INNER JOIN stores ON deadstocktransaction.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE deadstocktransaction.ItemId IN(SELECT deadstockdetails.ItemId FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$request->receivingId.')');
                        foreach ($request->row as $key => $value){
                            $totalavailable="0";
                            $updatevalue="0";
                            $totalresult="0";
                            $totalresval="0";
                            $newquantity="0";
                            $itemids=$value['ItemId'];
                            $dynamictblitem[]=$value['ItemId'];
                            $dynamicqnt=$value['Quantity'];
                            $storeids=$value['StoreId'];
                            if($dynamicqnt==null){
                                $newquantity="0";
                            }
                            else if($dynamicqnt!=null){
                                $newquantity=$dynamicqnt;
                            }

                            if($hiddenstr!=$request->stores){
                                $newquantity="0";//check whether the new store and old(DB) store is different
                            }
                            $updatestockingquantity=DB::select('update dshitemp'.$userid.' set StockIn='.$newquantity.' where HeaderId='.$request->receivingId.' AND TransactionsType="HandIn" AND ItemId='.$itemids.' AND dshitemp'.$userid.'.StoreId='.$hiddenstr.'');
                            $gettemptable=DB::select('SELECT dshitemp'.$userid.'.id,dshitemp'.$userid.'.HeaderId,dshitemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,dshitemp'.$userid.'.StoreId,uoms.Name AS UOM,dshitemp'.$userid.'.StockIn,dshitemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY dshitemp'.$userid.'.ItemId,dshitemp'.$userid.'.StoreId ORDER BY dshitemp'.$userid.'.id ASC)) AS AvailableQuantity,dshitemp'.$userid.'.TransactionsType FROM dshitemp'.$userid.' INNER JOIN regitems ON dshitemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON dshitemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE dshitemp'.$userid.'.ItemId='.$itemids.' AND dshitemp'.$userid.'.StoreId='.$hiddenstr.'');
                            foreach($gettemptable as $row)
                            {
                                $tempval[]=$row->AvailableQuantity;
                                $singleqntvalsc=$row->AvailableQuantity;
                                if($singleqntvalsc<0){
                                    $tempcntitemid[]=$row->ItemId;
                                    $tempcnt+=1;
                                }
                            }
                            if($singleqntvalsc<0){
                                $unavailableitems[]=$itemids;
                                $cval+=1;
                            }
                        }

                        foreach($insids as $val) {
                            $untotalavailable="0";
                            $unupdatevalue="0";
                            $untotalresult="0";
                            $untotalresval="0";
                            if(!in_array($val,$dynamictblitem)){
                                $ds=implode(',',$dynamictblitem);
                                $inds=implode(',',$insids);
                                $updatestockingquantity=DB::select('update dshitemp'.$userid.' set StockIn=0 where HeaderId='.$request->receivingId.' AND TransactionsType="HandIn" AND ItemId='.$val.' AND dshitemp'.$userid.'.StoreId='.$hiddenstr.'');
                                $gettemptable=DB::select('SELECT dshitemp'.$userid.'.id,dshitemp'.$userid.'.HeaderId,dshitemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,dshitemp'.$userid.'.StoreId,uoms.Name AS UOM,dshitemp'.$userid.'.StockIn,dshitemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY dshitemp'.$userid.'.ItemId,dshitemp'.$userid.'.StoreId ORDER BY dshitemp'.$userid.'.id ASC)) AS AvailableQuantity,dshitemp'.$userid.'.TransactionsType FROM dshitemp'.$userid.' INNER JOIN regitems ON dshitemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON dshitemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE dshitemp'.$userid.'.ItemId='.$val.' AND dshitemp'.$userid.'.StoreId='.$hiddenstr.'');
                                foreach($gettemptable as $row)
                                {
                                    $singleqntvalsd=$row->AvailableQuantity;
                                    if($singleqntvalsd<0){
                                        $tempnoncntitemid[]=$row->ItemId;
                                        $tempnoncnt+=1;
                                    }
                                } 
                                if($singleqntvalsd<0){
                                    $upunavailableitems[]=$val;
                                    $upval+=1;
                                }
                            } 
                        }
                        $unavitems=implode(',',$unavailableitems);
                        $upunavitems=implode(',',$upunavailableitems);
                        $unavtempitems=implode(',',$tempcntitemid);
                        $unavnontempitems=implode(',',$tempnoncntitemid);
                    }

                    $validator = Validator::make($request->all(), [
                        'supplier' => ['required'],
                        'PaymentType' => ['required'],
                        'date' => ['required','before:now'],
                        'stores' => ['required'],
                        'Purchaser' => ['required'],
                        //'Memo' => ['required'],
                    ]);
                    $rules=array(
                        'row.*.ItemId' => 'required',
                        'row.*.Quantity' => 'required|gt:0',
                        'row.*.UnitCost' => 'required|gt:0',
                        'row.*.BeforeTaxCost' => 'required|gt:0',
                        'row.*.SellingPrice' => 'required|gt:row.*.UnitCost',
                    );
                    $cvals=(float)$cval;
                    $upvals=(float)$upval;
                    $tempcnts=(float)$tempcnt;
                    $tempnoncnts=(float)$tempnoncnt;
                    if($cvals>=1||$upvals>=1){
                        $totalvals=$cvals+$upvals;
                        $selecteditems=null;
                        $removeditemsselected=null;
                        if($unavitems!=null){
                            $selecteditems=$unavitems;
                        }
                        if($unavitems==null){
                            $selecteditems="0";
                        }
                        if($upunavitems!=null){
                            $removeditemsselected=$upunavitems;
                        }
                        if($upunavitems==null){
                            $removeditemsselected="0";
                        }
                        $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                        $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                        return Response::json(['qnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                    }
                    else if($tempcnts>=1||$tempnoncnts>=1){
                        $totalvals=$tempcnts+$tempnoncnts;
                        $selecteditems=null;
                        $removeditemsselected=null;
                        if($unavtempitems!=null){
                            $selecteditems=$unavtempitems;
                        }
                        if($unavtempitems==null){
                            $selecteditems="0";
                        }
                        if($unavnontempitems!=null){
                            $removeditemsselected=$unavnontempitems;
                        }
                        if($unavnontempitems==null){
                            $removeditemsselected="0";
                        }
                        $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                        $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                        return Response::json(['detqnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                    }
                    else if($cval==0 && $upval==0 && $tempcnts==0 && $tempnoncnts==0){
                        $v2= Validator::make($request->all(), $rules);
                        if ($validator->passes()&& $v2->passes()&&($request->row!=null))
                        {
                            try
                            {
                                $storeid=$request->stores;
                                $receiving=deadstock::updateOrCreate(['id' => $request->receivingId], [
                                    'Type' =>trim($request->Type),
                                    'CustomerId' =>$request->supplier,
                                    'PaymentType' => trim($request->PaymentType),
                                    'SourceStore' =>"1",
                                    'StoreId' => trim($request->stores),
                                    'PurchaserName' => trim($request->Purchaser),
                                    'Memo' => trim($request->Memo),
                                    'TransactionDate' => trim($request->date),
                                    'VoidedDate' => "",
                                    'SubTotal' => trim($request->subtotali),
                                    'Tax' => 0,
                                    'GrandTotal' => 0,
                                ]);       
                                foreach ($request->row as $key => $value) 
                                {
                                    $itemname=$value['ItemId'];
                                    $quantity=$value['Quantity'];
                                    $unitprice=$value['UnitCost'];
                                    $totalprice=$value['BeforeTaxCost'];
                                    $storeid=$request->stores;
                                    $convertedquantity=$value['ConvertedQuantity'];
                                    $conversionamount=$value['ConversionAmount'];
                                    $newuomid=$value['NewUOMId'];
                                    $defaultuomid=$value['DefaultUOMId'];
                                    $common=$value['Common'];
                                    $transactiontype=$value['TransactionType'];
                                    $itemtype=$value['ItemType'];
                                    $sellingprice=$value['SellingPrice'];

                                    if(in_array($itemname,$insids)){
                                        $updaterecitems=deadstockdetail::where('HeaderId',$request->receivingId)->where('ItemId',$itemname)->update(['Quantity'=>$quantity,'UnitCost'=>$unitprice,'BeforeTaxCost'=>$totalprice,'StoreId'=>$storeid,'ConvertedQuantity'=>$convertedquantity,'ConversionAmount'=>$conversionamount,'NewUOMId'=>$newuomid,'DefaultUOMId'=>$defaultuomid,'Common'=>$common,'TransactionType'=>$transactiontype,'SellingPrice'=>$sellingprice,'ItemType'=>$itemtype]);
                                        if($statusval=="Confirmed/Defective"){
                                            $updatetransctions=dstransactions::where('HeaderId',$request->receivingId)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->whereIn('TransactionsType',$statusvalues)->update(['StockIn'=>$quantity,'UnitCost'=>$unitprice,'BeforeTaxCost'=>$totalprice,'TaxAmountCost'=>0,'TotalCost'=>0,'StoreId'=>$storeid,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                            $updatetransctionsvd=dstransactions::where('HeaderId',$request->receivingId)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->where('TransactionsType',"Void")->update(['StockOut'=>$quantity,'UnitCost'=>$unitprice,'BeforeTaxCost'=>$totalprice,'TaxAmountCost'=>0,'TotalCost'=>0,'StoreId'=>$storeid,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                        }
                                    }
                                    if(!in_array($itemname,$insids)){
                                        $recdt=new deadstockdetail;
                                        $recdt->HeaderId=$request->receivingId;
                                        $recdt->ItemId=$itemname;
                                        $recdt->Quantity=$quantity;
                                        $recdt->UnitCost=$unitprice;
                                        $recdt->BeforeTaxCost=$totalprice;
                                        $recdt->TaxAmount=0;
                                        $recdt->TotalCost=0;
                                        $recdt->Common=$common;
                                        $recdt->TransactionType="HandIn";
                                        $recdt->ItemType=$itemtype;
                                        $recdt->StoreId=$storeid;
                                        $recdt->SellingPrice=$sellingprice;
                                        $recdt->DefaultUOMId=$defaultuomid;
                                        $recdt->NewUOMId=$newuomid;
                                        $recdt->ConversionAmount=$conversionamount;
                                        $recdt->ConvertedQuantity=$convertedquantity;
                                        $recdt->save();

                                        if($statusval=="Confirmed/Defective"){
                                            $tran=new dstransactions;
                                            $tran->HeaderId=$request->receivingId;
                                            $tran->ItemId=$itemname;
                                            $tran->StockIn=$quantity;
                                            $tran->UnitCost=$unitprice;
                                            $tran->BeforeTaxCost=$totalprice;
                                            $tran->TaxAmountCost=0;
                                            $tran->TotalCost=0;
                                            $tran->StoreId=$storeid;
                                            $tran->IsVoid=0;
                                            $tran->TransactionType="HandIn";
                                            $tran->TransactionsType="HandIn";
                                            $tran->ItemType=$itemtype;
                                            $tran->DocumentNumber=$documentnumbers;
                                            $tran->FiscalYear=$fiscalyearval;
                                            $tran->Date=$confirmdates;
                                            $tran->save();
                                        }
                                    }
                                    $detailids[]=$itemname;
                                }
                                deadstockdetail::where('HeaderId',$request->receivingId)->whereNotIn('ItemId',$detailids)->delete();
                                dstransactions::where('HeaderId',$request->receivingId)->where('TransactionType',$rectransactiontype)->whereNotIn('ItemId',$detailids)->delete();
                                if($statusval=="Confirmed/Defective"){
                                    if($dstypes=="Internal" && $types=="External"){
                                        $trantype="HandIn";
                                        transaction::where('HeaderId',$request->receivingId)->where('TransactionType',$trantype)->delete();
                                    }
                                    $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE dshitemp'.$userid.''));
                                }
                                $updateSellingPrice=DB::select('UPDATE regitems as b1 INNER JOIN deadstockdetails as b2 ON b1.id = b2.ItemId SET b1.DeadStockPrice = (SELECT SellingPrice FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$request->receivingId.' AND deadstockdetails.ItemId=b2.ItemId) WHERE b2.HeaderId='.$request->receivingId);
                                return Response::json(['success' => '1']);
                            }
                            catch(Exception $e)
                            {
                                return Response::json(['dberrors' =>  $e->getMessage()]);
                            }
                        }
                    }
                }
            }

            if($findid==null)
            {
                $cusid=$request->supplier;
                $validator = Validator::make($request->all(), [
                    $dnumber=>"unique:deadstockrecs,DocumentNumber,$findid",
                    'PaymentType' => ['required'],
                    'date' => ['required','before:now'],
                    'stores' => ['required'],
                    'Purchaser' => ['required'],
                    //'Memo' => ['required'],
                ]);

                $rules=array(
                    'row.*.ItemId' => 'required',
                    'row.*.Quantity' => 'required|gt:0',
                    'row.*.UnitCost' => 'required|gt:0',
                    'row.*.BeforeTaxCost' => 'required|gt:0',
                    'row.*.SellingPrice' => 'required|gt:row.*.UnitCost',
                );
                $v2= Validator::make($request->all(), $rules);
                if ($validator->passes()&& $v2->passes()&&($request->row!=null))
                {
                    try
                    {
                        $storeid=$request->stores;
                        $receiving=deadstock::updateOrCreate(['id' => $request->receivingId], [
                            'Type' =>trim($request->Type),
                            'DocumentNumber' => $dnumber,
                            'CustomerId' =>$request->supplier,
                            'PaymentType' => trim($request->PaymentType),
                            'SourceStore' =>"1",
                            'StoreId' => trim($request->stores),
                            'PurchaserName' => trim($request->Purchaser),
                            'IsVoid' => 0,
                            'VoidReason' => "",
                            'VoidedBy' => "",
                            'VoidedDate' => "",
                            'TransactionDate' => trim($request->date),
                            'Status' => "Pending/Defective",
                            'StatusOld' => "-",
                            'SubTotal' => trim($request->subtotali),
                            'Tax' => 0,
                            'GrandTotal' => 0,
                            'Username' => $user,
                            'ReceivedBy' => "",
                            'DeliveredBy' => "-=",
                            'Common' =>  trim($request->commonVal),
                            'Memo' => trim($request->Memo),
                        ]);
                        foreach ($request->row as $key => $value) 
                        {
                            $itemname=$value['ItemId'];
                            $quantity=$value['Quantity'];
                            $unitprice=$value['UnitCost'];
                            $totalprice=$value['BeforeTaxCost'];
                            $storeid=$value['StoreId'];
                            $convertedquantity=$value['ConvertedQuantity'];
                            $conversionamount=$value['ConversionAmount'];
                            $newuomid=$value['NewUOMId'];
                            $defaultuomid=$value['DefaultUOMId'];
                            $common=$value['Common'];
                            $transactiontype=$value['TransactionType'];
                            $itemtype=$value['ItemType'];
                            $sellingprice=$value['SellingPrice'];
                            $receiving->items()->attach($itemname,
                            ['Quantity'=>$quantity,'UnitCost'=>$unitprice,'BeforeTaxCost'=>$totalprice,'StoreId'=>$request->stores,'ConvertedQuantity'=>$convertedquantity,
                            'ConversionAmount'=>$conversionamount,'NewUOMId'=>$newuomid,'DefaultUOMId'=>$defaultuomid,'Common'=>$common,'TransactionType'=>$transactiontype,
                            'SellingPrice'=>$sellingprice,'ItemType'=>$itemtype]);
                        }
                        $comn=$request->commonVal;
                        $receiving = DB::table('deadstockrecs')->where('Username', $user)->latest()->first();
                        $headerid=$receiving->id;
                        $deadstockDocnumber=$receiving->DocumentNumber;

                        $settingsval = DB::table('settings')->latest()->first();
                        $fiscalyr=$settingsval->FiscalYear;

                        //$updatetrtype=DB::select('update deadstockdetails set TransactionType="HandIn"');
                        if($request->receivingId==null)
                        {
                            $updn=DB::select('update settings set DeadStockCount=DeadStockCount+1 where id=1');
                        }

                       // $updStore=DB::select('update deadstockdetails set StoreId='.$request->stores.' where HeaderId='.$headerid.'');
                        
                        $updateSellingPrice=DB::select('UPDATE regitems as b1 INNER JOIN deadstockdetails as b2 ON b1.id = b2.ItemId SET b1.DeadStockPrice = (SELECT SellingPrice FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$headerid.' AND deadstockdetails.ItemId=b2.ItemId) WHERE b2.HeaderId='.$headerid);
                        return Response::json(['success' => "1",'receivingId'=>$cusid]);
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
                return response()->json(['errorv2'  => $v2->errors()->all()]);
            }
        }

        else if($types=="Internal")
        {
            if($findid!=null)
            {
                if($request->row==null){
                    return Response::json(['emptyerror'=>"error"]);
                }
                else{
                    $itemidlists=deadstockdetail::where('HeaderId', $request->receivingId)->get(['ItemId']);
                    foreach ($itemidlists as $itemidlists) {
                        $insids[] = $itemidlists->ItemId;
                    }
                    $recstatus=deadstock::where('id', $request->receivingId)->get(['Status','DocumentNumber','ConfirmedDate','Type']);
                    foreach ($recstatus as $recstatus) {
                        $statusval = $recstatus->Status;
                        $documentnumbers = $recstatus->DocumentNumber;
                        $confirmdates = $recstatus->ConfirmedDate;
                        $fiscalyearval="0";
                        $dstypes= $recstatus->Type;
                    }
                    if($statusval=="Confirmed/Defective"){
                        $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS dshitemp'.$userid.''));
                        $creatingtemptables=DB::statement('CREATE TEMPORARY TABLE dshitemp'.$userid.' SELECT deadstocktransaction.id,deadstocktransaction.HeaderId,deadstocktransaction.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,deadstocktransaction.StoreId,uoms.Name AS UOM,deadstocktransaction.StockIn,deadstocktransaction.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY deadstocktransaction.ItemId,deadstocktransaction.StoreId ORDER BY deadstocktransaction.id ASC)) AS AvailableQuantity,deadstocktransaction.TransactionsType,deadstocktransaction.FiscalYear FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id INNER JOIN stores ON deadstocktransaction.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE deadstocktransaction.ItemId IN(SELECT deadstockdetails.ItemId FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$request->receivingId.')');
                        foreach ($request->row as $key => $value){
                            $totalavailable="0";
                            $updatevalue="0";
                            $totalresult="0";
                            $totalresval="0";
                            $newquantity="0";
                            $itemids=$value['ItemId'];
                            $dynamictblitem[]=$value['ItemId'];
                            $dynamicqnt=$value['Quantity'];
                            $storeids=$value['StoreId'];
                            if($dynamicqnt==null){
                                $newquantity="0";
                            }
                            else if($dynamicqnt!=null){
                                $newquantity=$dynamicqnt;
                            }
                            // $getavailableqnt=DB::select('SELECT COALESCE(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)),0) AS TotalBalance FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemids.' AND deadstocktransaction.StoreId='.$hiddensrcstr.'');
                            // foreach($getavailableqnt as $row)
                            // {
                            //     $totalavailable=$row->TotalBalance;
                            // }
                            // $getrecevingdetail=deadstockdetail::where('HeaderId', $request->receivingId)->where('ItemId',$itemids)->get(['Quantity']);
                            // foreach ($getrecevingdetail as $getrecevingdetail) {
                            //     $updatevalue = $getrecevingdetail->Quantity;
                            // }
                            // $totalresult=$totalavailable-$updatevalue;
                            // if($hiddenstr!=$storeids){
                            //     $totalresval=$totalresult+0;
                            // }
                            // if($hiddenstr==$storeids){
                            //     $totalresval=$totalresult+$newquantity;
                            // }
                            // $totalresvals=(float)$totalresval;
                            // if($totalresvals<0){
                            //     $unavailableitems[]=$itemids;
                            //     $cval+=1;
                            // } 
                            $updatestockingquantity=DB::select('update dshitemp'.$userid.' set dshitemp'.$userid.'.StockIn='.$newquantity.' where dshitemp'.$userid.'.HeaderId='.$request->receivingId.' AND dshitemp'.$userid.'.TransactionsType="HandIn" AND dshitemp'.$userid.'.ItemId='.$itemids.' AND dshitemp'.$userid.'.StoreId='.$hiddenstr.'');
                            $gettemptable=DB::select('SELECT dshitemp'.$userid.'.id,dshitemp'.$userid.'.HeaderId,dshitemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,dshitemp'.$userid.'.StoreId,uoms.Name AS UOM,dshitemp'.$userid.'.StockIn,dshitemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY dshitemp'.$userid.'.ItemId,dshitemp'.$userid.'.StoreId ORDER BY dshitemp'.$userid.'.id ASC)) AS AvailableQuantity,dshitemp'.$userid.'.TransactionsType FROM dshitemp'.$userid.' INNER JOIN regitems ON dshitemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON dshitemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE dshitemp'.$userid.'.ItemId='.$itemids.' AND dshitemp'.$userid.'.StoreId='.$hiddenstr.'');
                            foreach($gettemptable as $row)
                            {
                                $totaltempvals[]=$row->AvailableQuantity;
                                $singleqntvalsb=$row->AvailableQuantity;
                                if($singleqntvalsb<0){
                                    $tempcntitemid[]=$row->ItemId;
                                    $tempcnt+=1;
                                }
                            }
                            //dd($totaltempvals);
                            if($singleqntvalsb<0){
                                $unavailableitems[]=$itemids;
                                $cval+=1;
                            }
                        }

                        foreach($insids as $val) {
                            $untotalavailable="0";
                            $unupdatevalue="0";
                            $untotalresult="0";
                            $untotalresval="0";
                            if(!in_array($val,$dynamictblitem)){
                                $ds=implode(',',$dynamictblitem);
                                $inds=implode(',',$insids);
                                // $getavailableqnt=DB::select('SELECT COALESCE(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)),0) AS TotalBalance FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$val.' AND deadstocktransaction.StoreId='.$hiddenstr.'');
                                // foreach($getavailableqnt as $row)
                                // {
                                //     $untotalavailable=$row->TotalBalance;
                                // }
                                // $getrecevingdetail=deadstockdetail::where('HeaderId', $request->receivingId)->where('ItemId',$val)->get(['Quantity']);
                                // foreach ($getrecevingdetail as $getrecevingdetail) {
                                //     $unupdatevalue = $getrecevingdetail->Quantity;
                                // }
                                // $untotalresult=$untotalavailable-$unupdatevalue;
                                // $untotalresval=$untotalresult+0;
                                // $untotalresvals=(float)$untotalresval;
                                // if($untotalresvals<0){
                                //     $upunavailableitems[]=$val;
                                //     $upval+=1;
                                // }
                                $updatestockingquantity=DB::select('update dshitemp'.$userid.' set StockIn=0 where HeaderId='.$request->receivingId.' AND TransactionsType="HandIn" AND ItemId='.$itemids.'');
                                $gettemptable=DB::select('SELECT dshitemp'.$userid.'.id,dshitemp'.$userid.'.HeaderId,dshitemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,dshitemp'.$userid.'.StoreId,uoms.Name AS UOM,dshitemp'.$userid.'.StockIn,dshitemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY dshitemp'.$userid.'.ItemId,dshitemp'.$userid.'.StoreId ORDER BY dshitemp'.$userid.'.id ASC)) AS AvailableQuantity,dshitemp'.$userid.'.TransactionsType FROM dshitemp'.$userid.' INNER JOIN regitems ON dshitemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON dshitemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE dshitemp'.$userid.'.ItemId='.$itemids.' AND dshitemp'.$userid.'.FiscalYear='.$fiscalyr.'');
                                foreach($gettemptable as $row)
                                {
                                    $tempval[]=$row->AvailableQuantity;
                                    $singleqntvalsa=$row->AvailableQuantity;
                                    if($singleqntvalsa<0){
                                        $tempnoncntitemid[]=$row->ItemId;
                                        $tempnoncnt+=1;
                                    }
                                }
                                if($singleqntvalsa<0){
                                    $upunavailableitems[]=$val;
                                    $upval+=1;
                                } 
                            } 
                        }

                        $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS rectemp'.$userid.''));
                        //Create a temp table to store a specific item transactios to check whether item is available or not
                        $creatingtemptables =DB::statement('CREATE TEMPORARY TABLE rectemp'.$userid.' SELECT transactions.id,transactions.HeaderId,transactions.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,transactions.StoreId,uoms.Name AS UOM,transactions.StockIn,transactions.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY transactions.ItemId,transactions.StoreId ORDER BY transactions.id ASC)) AS AvailableQuantity,(COALESCE(transactions.StockIn,0)-COALESCE(transactions.StockOut,0)) AS TotalQuantity,transactions.TransactionsType,transactions.FiscalYear FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE transactions.ItemId IN(SELECT deadstockdetails.ItemId FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$request->receivingId.') AND transactions.FiscalYear='.$fiscalyr.'');
                        foreach ($request->row as $key => $value){
                            $totalavailable="0";
                            $updatevalue="0";
                            $totalresult="0";
                            $totalresval="0";
                            $newquantity="0";
                            $itemids=$value['ItemId'];
                            $dynamictblitem[]=$value['ItemId'];
                            $dynamicqnt=$value['Quantity'];
                            $storeids=$request->SourceStore;
                            if($dynamicqnt==null){
                                $newquantity="0";
                            }
                            else if($dynamicqnt!=null){
                                $newquantity=$dynamicqnt;
                            }
                            // $getavailableqnt=DB::select('SELECT COALESCE(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)),0) AS TotalBalance FROM transactions WHERE transactions.ItemId='.$itemids.' AND transactions.StoreId='.$hiddensrcstr.' AND transactions.FiscalYear='.$fiscalyr.'');
                            // foreach($getavailableqnt as $row)
                            // {
                            //     $totalavailable=$row->TotalBalance;
                            // }
                            // $getrecevingdetail=deadstockdetail::where('HeaderId', $request->receivingId)->where('ItemId',$itemids)->get(['Quantity']);
                            // foreach ($getrecevingdetail as $getrecevingdetail) {
                            //     $updatevalue = $getrecevingdetail->Quantity;
                            // }
                            // $totalresult=$totalavailable-$updatevalue;
                            // if($hiddensrcstr!=$storeids){
                            //     $totalresval=$totalresult+0;
                            // }
                            // if($hiddensrcstr==$storeids){
                            //     $totalresval=$totalresult+$newquantity;
                            // }
                            // $totalresvals=(float)$totalresval;
                            // if($totalresvals<0){
                            //     $unavailableitemsmn[]=$itemids;
                            //    // $cvalmn+=1;
                            // } 
                           
                            $updatestockingquantity=DB::select('update rectemp'.$userid.' set StockOut='.$newquantity.',StoreId='.$request->SourceStore.' where HeaderId='.$request->receivingId.' AND TransactionsType="HandIn" AND ItemId='.$itemids.'');
                            $gettemptable=DB::select('SELECT rectemp'.$userid.'.id,rectemp'.$userid.'.HeaderId,rectemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,rectemp'.$userid.'.StoreId,uoms.Name AS UOM,rectemp'.$userid.'.StockIn,rectemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY rectemp'.$userid.'.ItemId,rectemp'.$userid.'.StoreId ORDER BY rectemp'.$userid.'.id ASC)) AS AvailableQuantity,(COALESCE(rectemp'.$userid.'.StockIn,0)-COALESCE(rectemp'.$userid.'.StockOut,0)) AS TotalQuantity,rectemp'.$userid.'.TransactionsType FROM rectemp'.$userid.' INNER JOIN regitems ON rectemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON rectemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE rectemp'.$userid.'.ItemId='.$itemids.' AND rectemp'.$userid.'.FiscalYear='.$fiscalyr.' AND rectemp'.$userid.'.StoreId='.$request->SourceStore.'');
                             //$gettemptable=DB::select('SELECT rectemp'.$userid.'.id,rectemp'.$userid.'.HeaderId,rectemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,rectemp'.$userid.'.StoreId,uoms.Name AS UOM,rectemp'.$userid.'.StockIn,rectemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY rectemp'.$userid.'.ItemId,rectemp'.$userid.'.StoreId ORDER BY rectemp'.$userid.'.id ASC)) AS AvailableQuantity,(COALESCE(rectemp'.$userid.'.StockIn,0)-COALESCE(rectemp'.$userid.'.StockOut,0)) AS TotalQuantity,rectemp'.$userid.'.TransactionsType FROM rectemp'.$userid.' INNER JOIN regitems ON rectemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON rectemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id');
                            foreach($gettemptable as $row)
                            {
                                $eachrunningqnt[]=$row->AvailableQuantity;
                                $singleqnt=$row->AvailableQuantity;
                                $totalresultsofst+=$row->TotalQuantity;
                                if($singleqnt<0){//check each running quantity whether it is negative or not
                                    $tempcntitemidmn[]=$row->ItemId;
                                    $tempcntmn+=1;
                                }
                            }
                            if($singleqnt<0){//check final quantity whether it is negative or not
                                $unavailableitemsmn[]=$itemids;
                                $cvalmn+=1;
                            } 
                        }

                        foreach($insids as $val) {
                            $untotalavailable="0";
                            $unupdatevalue="0";
                            $untotalresult="0";
                            $untotalresval="0";
                            if(!in_array($val,$dynamictblitem)){
                                $ds=implode(',',$dynamictblitem);
                                $inds=implode(',',$insids);
                                // $getavailableqnt=DB::select('SELECT COALESCE(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)),0) AS TotalBalance FROM transactions WHERE transactions.ItemId='.$val.' AND transactions.StoreId='.$hiddenstr.' AND transactions.FiscalYear='.$fiscalyr.'');
                                // foreach($getavailableqnt as $row)
                                // {
                                //     $untotalavailable=$row->TotalBalance;
                                // }
                                // $getrecevingdetail=deadstockdetail::where('HeaderId', $request->receivingId)->where('ItemId',$val)->get(['Quantity']);
                                // foreach ($getrecevingdetail as $getrecevingdetail) {
                                //     $unupdatevalue = $getrecevingdetail->Quantity;
                                // }
                                // $untotalresult=$untotalavailable-$unupdatevalue;
                                // $untotalresval=$untotalresult+0;
                                // $untotalresvals=(float)$untotalresval;
                                // if($untotalresvals<0){
                                //     $upunavailableitemsmn[]=$val;
                                //     $upvalmn+=1;
                                // }
                                $updatestockingquantity=DB::select('update rectemp'.$userid.' set StockOut=0,StoreId='.$request->SourceStore.' where HeaderId='.$request->receivingId.' AND TransactionsType="HandIn" AND ItemId='.$itemids.'');
                                $gettemptable=DB::select('SELECT rectemp'.$userid.'.id,rectemp'.$userid.'.HeaderId,rectemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,rectemp'.$userid.'.StoreId,uoms.Name AS UOM,rectemp'.$userid.'.StockIn,rectemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY rectemp'.$userid.'.ItemId,rectemp'.$userid.'.StoreId ORDER BY rectemp'.$userid.'.id ASC)) AS AvailableQuantity,rectemp'.$userid.'.TransactionsType FROM rectemp'.$userid.' INNER JOIN regitems ON rectemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON rectemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE rectemp'.$userid.'.ItemId='.$itemids.' AND rectemp'.$userid.'.FiscalYear='.$fiscalyr.'');
                                foreach($gettemptable as $row)
                                {
                                    $tempval[]=$row->AvailableQuantity;
                                    $singlenonqnt=$row->AvailableQuantity;
                                    if($singlenonqnt<0){
                                        $tempnoncntitemidmn[]=$row->ItemId;
                                        $tempnoncntmn+=1;
                                    }
                                } 
                                if($singlenonqnt<0){
                                    $upunavailableitemsmn[]=$val;
                                    $upvalmn+=1;
                                }
                            } 
                        }

                        $unavitems=implode(',',$unavailableitems);
                        $upunavitems=implode(',',$upunavailableitems);
                        $unavtempitems=implode(',',$tempcntitemid);
                        $unavnontempitems=implode(',',$tempnoncntitemid);

                        $unavitemsmn=implode(',',$unavailableitemsmn);
                        $unavtempitemsmn=implode(',',$tempcntitemidmn);
                        $upunavitemsmn=implode(',',$upunavailableitemsmn);
                        $unavnontempitemsmn=implode(',',$tempnoncntitemidmn);
                    }
                    $validator = Validator::make($request->all(), [
                        'date' => ['required','before:now'],
                        'SourceStore' => ['required'],
                        'stores' => ['required'],
                        //'Memo' => ['required'],
                    ]);
                    $rules=array(
                        'row.*.ItemId' => 'required',
                        'row.*.Quantity' => 'required|gt:0',
                        'row.*.UnitCost' => 'required|gt:0',
                        'row.*.BeforeTaxCost' => 'required|gt:0',
                        'row.*.SellingPrice' => 'required|gt:row.*.UnitCost',
                    );
                    $cvals=(float)$cval;
                    $upvals=(float)$upval;
                    $tempcnts=(float)$tempcnt;
                    $tempnoncnts=(float)$tempnoncnt;

                    $cvalmns=(float)$cvalmn;
                    $upvalmns=(float)$upvalmn;
                    $tempcntmns=(float)$tempcntmn;
                    $tempnoncntmns=(float)$tempnoncntmn;
                    if($cvals>=1||$upvals>=1){
                        $totalvals=$cvals+$upvals;
                        $selecteditems=null;
                        $removeditemsselected=null;
                        if($unavitems!=null){
                            $selecteditems=$unavitems;
                        }
                        if($unavitems==null){
                            $selecteditems="0";
                        }
                        if($upunavitems!=null){
                            $removeditemsselected=$upunavitems;
                        }
                        if($upunavitems==null){
                            $removeditemsselected="0";
                        }
                        $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                        $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                        return Response::json(['qnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                    }
                    else if($tempcnts>=1||$tempnoncnts>=1){
                        $totalvals=$tempcnts+$tempnoncnts;
                        $selecteditems=null;
                        $removeditemsselected=null;
                        if($unavtempitems!=null){
                            $selecteditems=$unavtempitems;
                        }
                        if($unavtempitems==null){
                            $selecteditems="0";
                        }
                        if($unavnontempitems!=null){
                            $removeditemsselected=$unavnontempitems;
                        }
                        if($unavnontempitems==null){
                            $removeditemsselected="0";
                        }
                        $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                        $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                        return Response::json(['detqnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                    }
                    else if($cvalmns>=1||$upvalmns>=1){
                        $totalvals=$cvalmns+$upvalmns;
                        $selecteditems=null;
                        $removeditemsselected=null;
                        if($unavitemsmn!=null){
                            $selecteditems=$unavitemsmn;
                        }
                        if($unavitemsmn==null){
                            $selecteditems="0";
                        }
                        if($upunavitemsmn!=null){
                            $removeditemsselected=$upunavitemsmn;
                        }
                        if($upunavitemsmn==null){
                            $removeditemsselected="0";
                        }
                        $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                        $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                        return Response::json(['qnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                    }
                    else if($tempcntmns>=1||$tempnoncntmns>=1){
                        $totalvals=$tempcntmns+$tempnoncntmns;
                        $selecteditems=null;
                        $removeditemsselected=null;
                        if($unavtempitemsmn!=null){
                            $selecteditems=$unavtempitemsmn;
                        }
                        if($unavtempitemsmn==null){
                            $selecteditems="0";
                        }
                        if($unavnontempitemsmn!=null){
                            $removeditemsselected=$unavnontempitemsmn;
                        }
                        if($unavnontempitemsmn==null){
                            $removeditemsselected="0";
                        }
                        $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                        $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                        return Response::json(['detqnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                    }
                    else if($cval==0 && $upval==0 && $tempcnts==0 && $tempnoncnts==0 && $cvalmns==0 && $upvalmns==0 && $tempcntmns==0 && $tempnoncntmns==0){
                        $v2= Validator::make($request->all(), $rules);
                        if ($validator->passes() && $v2->passes()&&($request->row!=null))
                        {
                            try
                            {
                                $storeid=$request->store;
                                $receiving=deadstock::updateOrCreate(['id' => $request->receivingId], [
                                    'Type' =>trim($request->Type),
                                    'CustomerId' =>"1",
                                    'SourceStore' =>$request->SourceStore,
                                    'PaymentType' => "",
                                    'StoreId' => $request->stores,
                                    'PurchaserName' => "",
                                    'Memo' => trim($request->Memo),
                                    'VoidedDate' => "",
                                    'TransactionDate' => trim($request->date),
                                    'SubTotal' => trim($request->subtotali),
                                    'Tax' => 0,
                                    'GrandTotal' => 0,
                                ]);    
                                foreach ($request->row as $key => $value) 
                                {
                                    $itemname=$value['ItemId'];
                                    $quantity=$value['Quantity'];
                                    $unitprice=$value['UnitCost'];
                                    $totalprice=$value['BeforeTaxCost'];
                                    $storeid=$request->stores;
                                    $convertedquantity=$value['ConvertedQuantity'];
                                    $conversionamount=$value['ConversionAmount'];
                                    $newuomid=$value['NewUOMId'];
                                    $defaultuomid=$value['DefaultUOMId'];
                                    $common=$value['Common'];
                                    $transactiontype=$value['TransactionType'];
                                    $itemtype=$value['ItemType'];
                                    $sellingprice=$value['SellingPrice'];

                                    if(in_array($itemname,$insids)){
                                        $updaterecitems=deadstockdetail::where('HeaderId',$request->receivingId)->where('ItemId',$itemname)->update(['Quantity'=>$quantity,'UnitCost'=>$unitprice,'BeforeTaxCost'=>$totalprice,'StoreId'=>$storeid,'ConvertedQuantity'=>$convertedquantity,'ConversionAmount'=>$conversionamount,'NewUOMId'=>$newuomid,'DefaultUOMId'=>$defaultuomid,'Common'=>$common,'TransactionType'=>$transactiontype,'SellingPrice'=>$sellingprice,'ItemType'=>$itemtype]);
                                        if($statusval=="Confirmed/Defective"){
                                            $updatetransctions=dstransactions::where('HeaderId',$request->receivingId)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->whereIn('TransactionsType',$statusvalues)->update(['StockIn'=>$quantity,'UnitCost'=>$unitprice,'BeforeTaxCost'=>$totalprice,'TaxAmountCost'=>0,'TotalCost'=>0,'StoreId'=>$storeid,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                            $updatetransctionsvd=dstransactions::where('HeaderId',$request->receivingId)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->where('TransactionsType',"Void")->update(['StockOut'=>$quantity,'UnitCost'=>$unitprice,'BeforeTaxCost'=>$totalprice,'TaxAmountCost'=>0,'TotalCost'=>0,'StoreId'=>$storeid,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);

                                            if($dstypes=="Internal" && $types=="Internal"){
                                                $updatetransctionsmn=transaction::where('HeaderId',$request->receivingId)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->whereIn('TransactionsType',$statusvalues)->update(['StockOut'=>$quantity,'UnitPrice'=>$unitprice,'BeforeTaxPrice'=>$totalprice,'StoreId'=>$request->SourceStore,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                                $updatetransctionsvdmn=transaction::where('HeaderId',$request->receivingId)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->where('TransactionsType',"Void")->update(['StockIn'=>$quantity,'UnitCost'=>$unitprice,'BeforeTaxCost'=>$totalprice,'StoreId'=>$request->SourceStore,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                            }
                                            else if($dstypes=="External" && $types=="Internal"){
                                                $tranmn=new transaction;
                                                $tranmn->HeaderId=$request->receivingId;
                                                $tranmn->ItemId=$itemname;
                                                $tranmn->StockOut=$quantity;
                                                $tranmn->UnitPrice=$unitprice;
                                                $tranmn->BeforeTaxPrice=$totalprice;
                                                $tranmn->StoreId=$request->SourceStore;
                                                $tranmn->IsVoid=0;
                                                $tranmn->TransactionType="HandIn";
                                                $tranmn->TransactionsType="HandIn";
                                                $tranmn->ItemType=$itemtype;
                                                $tranmn->DocumentNumber=$documentnumbers;
                                                $tranmn->Date=$confirmdates;
                                                $tranmn->FiscalYear=$fiscalyr;
                                                $tranmn->save();
                                            }
                                        }
                                    }
                                    if(!in_array($itemname,$insids)){
                                        $recdt=new deadstockdetail;
                                        $recdt->HeaderId=$request->receivingId;
                                        $recdt->ItemId=$itemname;
                                        $recdt->Quantity=$quantity;
                                        $recdt->UnitCost=$unitprice;
                                        $recdt->BeforeTaxCost=$totalprice;
                                        $recdt->TaxAmount=0;
                                        $recdt->TotalCost=0;
                                        $recdt->Common=$common;
                                        $recdt->TransactionType="HandIn";
                                        $recdt->ItemType=$itemtype;
                                        $recdt->StoreId=$storeid;
                                        $recdt->SellingPrice=$sellingprice;
                                        $recdt->DefaultUOMId=$defaultuomid;
                                        $recdt->NewUOMId=$newuomid;
                                        $recdt->ConversionAmount=$conversionamount;
                                        $recdt->ConvertedQuantity=$convertedquantity;
                                        $recdt->save();
                                        if($statusval=="Confirmed/Defective"){
                                            $tran=new dstransactions;
                                            $tran->HeaderId=$request->receivingId;
                                            $tran->ItemId=$itemname;
                                            $tran->StockIn=$quantity;
                                            $tran->UnitCost=$unitprice;
                                            $tran->BeforeTaxCost=$totalprice;
                                            $tran->TaxAmountCost=0;
                                            $tran->TotalCost=0;
                                            $tran->StoreId=$storeid;
                                            $tran->IsVoid=0;
                                            $tran->TransactionType="HandIn";
                                            $tran->TransactionsType="HandIn";
                                            $tran->ItemType=$itemtype;
                                            $tran->DocumentNumber=$documentnumbers;
                                            $tran->FiscalYear=$fiscalyearval;
                                            $tran->Date=$confirmdates;
                                            $tran->save();

                                            $tranmn=new transaction;
                                            $tranmn->HeaderId=$request->receivingId;
                                            $tranmn->ItemId=$itemname;
                                            $tranmn->StockOut=$quantity;
                                            $tranmn->UnitPrice=$unitprice;
                                            $tranmn->BeforeTaxPrice=$totalprice;
                                            $tranmn->StoreId=$storeid;
                                            $tranmn->IsVoid=0;
                                            $tranmn->TransactionType="HandIn";
                                            $tranmn->TransactionsType="HandIn";
                                            $tranmn->ItemType=$itemtype;
                                            $tranmn->DocumentNumber=$documentnumbers;
                                            $tranmn->Date=$confirmdates;
                                            $tranmn->FiscalYear=$fiscalyr;
                                            $tranmn->save();
                                        }
                                    }
                                    $detailids[]=$itemname;
                                }
                                deadstockdetail::where('HeaderId',$request->receivingId)->whereNotIn('ItemId',$detailids)->delete();
                                dstransactions::where('HeaderId',$request->receivingId)->where('TransactionType',$rectransactiontype)->whereNotIn('ItemId',$detailids)->delete();         
                                transaction::where('HeaderId',$request->receivingId)->where('TransactionType',$rectransactiontype)->whereNotIn('ItemId',$detailids)->delete();
                                $updateSellingPrice=DB::select('UPDATE regitems as b1 INNER JOIN deadstockdetails as b2 ON b1.id = b2.ItemId SET b1.DeadStockPrice = (SELECT SellingPrice FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$request->receivingId.' AND deadstockdetails.ItemId=b2.ItemId) WHERE b2.HeaderId='.$request->receivingId);
                                if($statusval=="Confirmed/Defective"){
                                    $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE rectemp'.$userid.''));
                                }
                                return Response::json(['success' => '1']);
                            }
                            catch(Exception $e)
                            {
                                return Response::json(['dberrors' =>  $e->getMessage()]);
                            }
                        }
                    }
                }
            }

            if($findid==null)
            {
                $cusid=$request->supplier;
                $validator = Validator::make($request->all(), [
                    $dnumber=>"unique:deadstockrecs,DocumentNumber,$findid",
                    'date' => ['required','before:now'],
                    'SourceStore' => ['required'],
                    'stores' => ['required'],
                    //'Memo' => ['required'],
                ]);
                $rules=array(
                    'row.*.ItemId' => 'required',
                    'row.*.Quantity' => 'required|gt:0',
                    'row.*.UnitCost' => 'required|gt:0',
                    'row.*.BeforeTaxCost' => 'required|gt:0',
                    'row.*.SellingPrice' => 'required|gt:row.*.UnitCost',
                );
                $v2= Validator::make($request->all(), $rules);
                if ($validator->passes()&& $v2->passes()&&($request->row!=null))
                {
                    try
                    {
                        $storeid=$request->store;
                        $receiving=deadstock::updateOrCreate(['id' => $request->receivingId], [
                            'Type' =>$request->Type,
                            'CustomerId' =>"1",
                            'DocumentNumber' => $dnumber,
                            'SourceStore' =>$request->SourceStore,
                            'PaymentType' => "",
                            'StoreId' => $request->stores,
                            'PurchaserName' => "",
                            'IsVoid' => 0,
                            'VoidReason' => "-",
                            'VoidedBy' => "-",
                            'VoidedDate' => "",
                            'TransactionDate' => trim($request->date),
                            'Status' => "Pending/Defective",
                            'StatusOld' => "-",
                            'SubTotal' => trim($request->subtotali),
                            'Tax' => 0,
                            'GrandTotal' => 0,
                            'Username' => $user,
                            'ReceivedBy' => "-",
                            'DeliveredBy' => "-",
                            'Common' =>  trim($request->commonVal),
                            'Memo' => trim($request->Memo),
                        ]);

                        foreach ($request->row as $key => $value) 
                        {
                            $itemname=$value['ItemId'];
                            $quantity=$value['Quantity'];
                            $unitprice=$value['UnitCost'];
                            $totalprice=$value['BeforeTaxCost'];
                            $storeid=$request->store;
                            $convertedquantity=$value['ConvertedQuantity'];
                            $conversionamount=$value['ConversionAmount'];
                            $newuomid=$value['NewUOMId'];
                            $defaultuomid=$value['DefaultUOMId'];
                            $common=$value['Common'];
                            $transactiontype=$value['TransactionType'];
                            $itemtype=$value['ItemType'];
                            $sellingprice=$value['SellingPrice'];
                            $receiving->items()->attach($itemname,
                            ['Quantity'=>$quantity,'UnitCost'=>$unitprice,'BeforeTaxCost'=>$totalprice,'StoreId'=>$storeid,'ConvertedQuantity'=>$convertedquantity,
                            'ConversionAmount'=>$conversionamount,'NewUOMId'=>$newuomid,'DefaultUOMId'=>$defaultuomid,'Common'=>$common,'TransactionType'=>$transactiontype,
                            'SellingPrice'=>$sellingprice,'ItemType'=>$itemtype]);
                        }
                        $comn=$request->commonVal;
                        $receiving = DB::table('deadstockrecs')->where('Username', $user)->latest()->first();
                        $headerid=$receiving->id;
                        $deadstockDocnumber=$receiving->DocumentNumber;

                        $settingsval = DB::table('settings')->latest()->first();
                        $fiscalyr=$settingsval->FiscalYear;
                       
                        if($request->receivingId==null)
                        {
                            $updn=DB::select('update settings set DeadStockCount=DeadStockCount+1 where id=1');
                        }
                        $updateSellingPrice=DB::select('UPDATE regitems as b1 INNER JOIN deadstockdetails as b2 ON b1.id = b2.ItemId SET b1.DeadStockPrice = (SELECT SellingPrice FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$headerid.' AND deadstockdetails.ItemId=b2.ItemId) WHERE b2.HeaderId='.$headerid);
                       
                        return Response::json(['success' => "1"]);
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
                return response()->json([
                    'errorv2'  => $v2->errors()->all()
                ]);
            }
        }
        
    }

    public function updateHandInConfimed(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $type=$request->confirmtype;
        $findid=$request->confirmid;
        $receiving=deadstock::find($findid);
        $headerid=$receiving->id;
        $deadstockDocnumber=$receiving->DocumentNumber;
        $srcStore=$receiving->SourceStore;   
        $destinationstr=$receiving->StoreId;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        if($type=="External")
        {   
            $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                ['HeaderId', 'ItemId', 'StockIn','UnitCost','BeforeTaxCost','TaxAmountCost','TotalCost','StoreId','TransactionType','ItemType','RetailerPrice'
                ],
                function ($query)use($headerid) {
                    $query
                        ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','TransactionType','ItemType','SellingPrice']) // ..., columnN
                        ->from('deadstockdetails')->where('HeaderId', '=',$headerid);
                }
            );

                $trtype="HandIn";
                DB::table('deadstocktransaction')
                ->where('HeaderId', $headerid)
                ->where('TransactionType', $trtype)
                ->update(['FiscalYear'=>$fiscalyr,'DocumentNumber'=>$deadstockDocnumber,'TransactionsType'=>$trtype,'Date'=>Carbon::today()->toDateString()]);

                $receiving->ConfirmedBy=$user;
                $receiving->ConfirmedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                //$receiving->ConfirmedDate=Carbon::today()->toDateString();
                $receiving->Status="Confirmed/Defective";
                $receiving->save();
                $updateSellingPrice=DB::select('UPDATE regitems as b1 INNER JOIN deadstockdetails as b2 ON b1.id = b2.ItemId SET b1.DeadStockPrice = (SELECT SellingPrice FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$headerid.' AND deadstockdetails.ItemId=b2.ItemId) WHERE b2.HeaderId='.$headerid);
                $updateMaxcostedt=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcosteditable=IF(((SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id)>b1.dsmaxcost),(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id),b1.dsmaxcosteditable) WHERE b1.id=b2.ItemId AND b2.HeaderId='.$headerid);
                $updateMaxcost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcost=(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id) WHERE b1.id=b2.ItemId AND b2.HeaderId='.$headerid); 
                return Response::json(['success' => '1']);
        }
        else if($type=="Internal")
        {
            $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM deadstockdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$headerid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$srcStore.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
            foreach($getApprovedQuantity as $row)
            {
                    $avaq=$row->ApprovedItems;
            }

            $avaqp = (float)$avaq;
            if($avaqp>=1)
            {
                $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$srcStore.' AND transactions.FiscalYear='.$fiscalyr.') AS AvailableQuantity FROM deadstockdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$headerid.' AND 
                (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$srcStore.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
                return Response::json(['valerror' =>  "error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
            }
            else{
                // $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                //     ['HeaderId', 'ItemId', 'StockIn','UnitCost','BeforeTaxCost','TaxAmountCost','TotalCost','StoreId','TransactionType','ItemType','RetailerPrice'
                //     ],
                //     function ($query)use($headerid,$destinationstr) {
                //         $query
                //             ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost',$destinationstr,'TransactionType','ItemType','SellingPrice']) // ..., columnN
                //             ->from('deadstockdetails')->where('HeaderId', '=',$headerid);
                //     }
                // );
                $trtype="HandIn";
                $trisstype="HandIn";
                $transactiondata=DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,RetailerPrice,FiscalYear,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,'.$destinationstr.',TransactionType,ItemType,SellingPrice,'.$fiscalyr.',"'.$deadstockDocnumber.'","'.$trtype.'","'.Carbon::today()->toDateString().'" from deadstockdetails where deadstockdetails.HeaderId='.$headerid);
                $dstransactiondatas=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,RetailerPrice,FiscalYear,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,'.$srcStore.',TransactionType,ItemType,SellingPrice,'.$fiscalyr.',"'.$deadstockDocnumber.'","'.$trisstype.'","'.Carbon::today()->toDateString().'" from deadstockdetails where deadstockdetails.HeaderId='.$headerid);
                
                // $dstransactiondata=DB::table('transactions')->insertUsing(
                //     ['HeaderId', 'ItemId', 'StockOut','UnitPrice','BeforeTaxPrice','TaxAmountCost','TotalCost','TransactionType','ItemType','RetailerPrice'
                //     ],
                //     function ($query)use($headerid) {
                //         $query
                //             ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','TransactionType','ItemType','SellingPrice']) // ..., columnN
                //             ->from('deadstockdetails')->where('HeaderId', '=',$headerid);
                //     }
                // );


                    // DB::table('deadstocktransaction')
                    // ->where('HeaderId', $headerid)
                    // ->where('TransactionType', $trtype)
                    // ->update(['FiscalYear'=>$fiscalyr,'DocumentNumber'=>$deadstockDocnumber,'TransactionsType'=>$trtype,'Date'=>Carbon::today()->toDateString()]);

                    // DB::table('transactions')
                    // ->where('HeaderId', $headerid)
                    // ->where('TransactionType', $trtype)
                    // ->whereNull('StockIn')
                    // ->update(['StoreId'=>$srcStore,'FiscalYear'=>$fiscalyr,'DocumentNumber' => $deadstockDocnumber,'TransactionsType'=>$trisstype,'Date'=>Carbon::today()->toDateString()]);

                    $receiving->ConfirmedBy=$user;
                    $receiving->ConfirmedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                    //$receiving->ConfirmedDate=Carbon::today()->toDateString();
                    $receiving->Status="Confirmed/Defective";
                    $receiving->save();
                    $updateSellingPrice=DB::select('UPDATE regitems as b1 INNER JOIN deadstockdetails as b2 ON b1.id = b2.ItemId SET b1.DeadStockPrice = (SELECT SellingPrice FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$headerid.' AND deadstockdetails.ItemId=b2.ItemId) WHERE b2.HeaderId='.$headerid);
                    $updateMaxcostedt=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcosteditable=IF(((SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id)>b1.dsmaxcost),(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id),b1.dsmaxcosteditable) WHERE b1.id=b2.ItemId AND b2.HeaderId='.$headerid);
                    $updateMaxcost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcost=(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id) WHERE b1.id=b2.ItemId AND b2.HeaderId='.$headerid); 
                    return Response::json(['success' => '1']);
            }
        }
        
    }

    public function syncDynamicTable(Request $request)
    {
        $insids=[];
        $tritem=[];
        $inds=null;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $storeval=$request->SourceStore;
        if($request->row!=null){
            foreach ($request->row as $key => $value) 
            {
                $insids[]=$value['ItemId'];
            }
            $inds=implode(',',$insids);
            $getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)))) AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fyear.' AND transactions.ItemId IN ('.$inds.') AND transactions.StoreId='.$storeval.' GROUP BY regitems.Name,transactions.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');
            return response()->json(['bal'=>$getallbalnces]);
        }
    }

    public function syncDynamicTablepo(Request $request)
    {
        $insids=[];
        $tritem=[];
        $inds=null;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $storeval=$request->store;
        if($request->row!=null){
            foreach ($request->row as $key => $value) 
            {
                $insids[]=$value['ItemId'];
            }
            $inds=implode(',',$insids);
            $getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,deadstocktransaction.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status IN ("Pending/Removed") and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status IN("Pending/Removed") and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)))) AS Balance,deadstocktransaction.StoreId FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id WHERE deadstocktransaction.ItemId IN ('.$inds.') AND deadstocktransaction.StoreId='.$storeval.' GROUP BY regitems.Name,deadstocktransaction.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');
            return response()->json(['bal'=>$getallbalnces]);
        }
    }

    public function editDeadStock($id)
    {
        $insids=[];
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $countitem = DB::table('deadstockdetails')->where('HeaderId', '=', $id)
            ->get();
        $getCountItem = $countitem->count();
        $recdata = deadstock::find($id);
        $srcstoreid=$recdata->SourceStore;
        $itemidlists=deadstockdetail::where('HeaderId',$id)->orderBy('deadstockdetails.id','asc')->get(['ItemId']);
        foreach ($itemidlists as $itemidlists) {
            $insids[] = $itemidlists->ItemId;
        }
        $inds=implode(',',$insids);
        $data = deadstockdetail::join('deadstockrecs', 'deadstockdetails.HeaderId', '=', 'deadstockrecs.id')
            ->join('regitems', 'deadstockdetails.ItemId', '=', 'regitems.id')
            ->join('uoms', 'deadstockdetails.DefaultUOMId', '=', 'uoms.id')
            ->where('deadstockdetails.HeaderId', $id)
            ->orderBy('deadstockdetails.id','asc')
            ->get(['deadstockrecs.*','deadstockdetails.*','deadstockdetails.Common AS recdetcommon','deadstockdetails.StoreId AS recdetstoreid',
            'deadstockdetails.RequireSerialNumber AS ReSerialNm','deadstockdetails.RequireExpireDate AS ReExpDate','deadstockdetails.SellingPrice','regitems.Name AS ItemName','regitems.Code AS ItemCode','regitems.SKUNumber',
            'uoms.Name AS UomName']);
        //$getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,deadstocktransaction.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status IN ("pending..","Checked") and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status IN("pending..","Checked") and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)))) AS Balance,deadstocktransaction.StoreId FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id WHERE deadstocktransaction.ItemId IN ('.$inds.') AND deadstocktransaction.StoreId='.$srcstoreid.' GROUP BY regitems.Name,deadstocktransaction.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');
        $getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN ("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from salesitems inner join sales on salesitems.HeaderId=sales.id where sales.Status IN("pending..","Checked") and salesitems.StoreId=transactions.StoreId and salesitems.ItemId=transactions.ItemId)))) AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fyear.' AND transactions.ItemId IN ('.$inds.') AND transactions.StoreId='.$srcstoreid.' GROUP BY regitems.Name,transactions.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');
        return response()->json(['recData'=>$recdata,'count'=>$getCountItem,'receivingdt'=>$data,'bal'=>$getallbalnces]);
    }

    public function showDeadStockDetailData($id)
    {
        $HeaderId=$id;
        $columnName="HeaderId";
        $detailTable=DB::select('SELECT deadstockdetails.id,deadstockdetails.ItemId,deadstockdetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS Code,regitems.SKUNumber,uoms.Name AS UOM,deadstockdetails.Quantity,deadstockdetails.UnitCost,deadstockdetails.BeforeTaxCost,deadstockdetails.TaxAmount,deadstockdetails.TotalCost,deadstockdetails.SellingPrice FROM deadstockdetails INNER JOIN regitems ON deadstockdetails.ItemId=regitems.id INNER JOIN uoms ON deadstockdetails.NewUOMId=uoms.id where deadstockdetails.HeaderId='.$HeaderId);
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                 $btn =  ' <a data-id="'.$data->id.'" data-HeaderId="'.$data->HeaderId.'" data-uom="'.$data->UOM.'" class="btn btn-icon btn-gradient-info btn-sm editRecDatas" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                 $btn = $btn.' <a data-id="'.$data->id.'" data-hid="'.$data->HeaderId.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#receivingremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                 return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function editDeadStockItem($id)
    {
        $recdataId = deadstockdetail::find($id);
        return response()->json(['recDataId'=>$recdataId]);
    }

    public function getAllDeadStockUoms(Request $request,$id)
    {
        $regitem = DB::table('regitems')->where('id', $id)->latest()->first();
        $uomid=$regitem->MeasurementId;
        $retailerp=$regitem->DeadStockPrice;
        $wholeseller=$regitem->WholesellerPrice;
        $taxper=$regitem->TaxTypeId;
        $itemtype=$regitem->Type;
        $cnv=uom::find($uomid);
        $defuom=$cnv->Name;
        $conv=DB::select('SELECT t.id,t.FromUomID,w1.Name AS FromUnitName,t.ToUomID,w2.Name AS ToUnitName,t.Amount,t.ActiveStatus FROM conversions AS t JOIN uoms AS w1 on w1.id=t.FromUomID JOIN uoms AS w2 on w2.id=t.ToUomID WHERE t.FromUomID='.$uomid.' AND t.ActiveStatus="Active"');
        $getCost=DB::select('SELECT UnitCost FROM deadstocktransaction WHERE ItemId='.$id.' AND StockIn!="" ORDER BY id DESC LIMIT 1');
        if($getCost==null)
        {
            $getLastCost="";
        }
        foreach($getCost as $row)
        {
            if($row!=null)
            {
                $getLastCost=$row->UnitCost;
            }
            if($row==null)
            {
                $getLastCost="";
            }
            if($row=="")
            {
                $getLastCost="";
            }
        }
        return response()->json(['sid'=>$conv,'defuom'=>$defuom,'defuomid'=>$uomid,'lastCost'=>$getLastCost,'retailer'=>$retailerp,'taxpr'=>$taxper,'itemtype'=>$itemtype]);
    }

    public function getDeadStockItemQuantity(Request $request, $id)
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;        
        $sourcestore=$request->SourceStore;
        $getSalesQuantity=DB::select('SELECT COALESCE(SUM(salesitems.Quantity),0) AS TotalSalesQuantity FROM salesitems INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE salesitems.ItemId='.$id.' AND salesitems.StoreId='.$sourcestore.' AND sales.Status IN ("pending..","Checked")');
        $getQuantity=DB::select('select (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity from transactions where transactions.StoreId='.$sourcestore.' and transactions.FiscalYear='.$fiscalyr.' and transactions.ItemId='.$id.'');
        return response()->json(['sid'=>$getQuantity,'sourcestore'=>$sourcestore,'salesqnt'=>$getSalesQuantity]);
    }

    public function getDeadStockConversionAmount(Request $request,$id,$nid)
    {
        $conversion = DB::table('conversions')->where('FromUomID', $id)->where('ToUomID', $nid)->latest()->first();
        $amnt=$conversion->Amount;
        return response()->json(['sid'=>$amnt]);
    }

    public function storeNewDeadStockItems(Request $request)
    {
        $headerid=$request->recevingedit;
        $storeid=$request->receivingstoreid;
        $dstoreid=$request->destreceivingstoreid;
        $ss=$request->receivingidinput;
        $findid=$request->recevingedit;
        $valId=$request->editVal;
        $hids=$request->receIds;
        $itemid=$request->addHoldItem;
        $itemidold=$request->itemidold;
        $quantity=$request->quantityhold;
        $unitcost=$request->unitcosthold;
        $totalcost=$request->beforetaxhold;
        $dsType=deadstock::find($hids);
        $type=$dsType->Type;
        $docnum=$dsType->DocumentNumber;

        if($type=="External")
        {
            $stockin=DB::select('SELECT sum(COALESCE(StockIn,0)) AS StockIn FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.TransactionType!="Begining" AND deadstocktransaction.StoreId='.$dstoreid);
            $stockout=DB::select('SELECT sum(COALESCE(StockOut,0)) AS StockOut FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.StoreId='.$dstoreid);
    
            foreach($stockin as $row)
            {
                    $stockin=$row->StockIn;
            }
            foreach($stockout as $row)
            {
                    $stockout=$row->StockOut;
            }
            $stockin = (float)$stockin;
            $stockout = (float)$stockout;
            $result=($stockin+$quantity)-($stockout);
    
            if($result<0)
            {
                return Response::json(['valerror' =>  "error",'countedval'=>$result]);
            }
            else
            {
                if($findid==null)
                {
                    $validator = Validator::make($request->all(), [
                        'addHoldItem' => ['required',
                        Rule::unique('deadstockdetails', 'ItemId')->where(function ($query) use ($hids) {
                            return $query->where('HeaderId', $hids);
                        })
                        ],
                        'quantityhold' =>"required|numeric|min:1|gt:0",
                        'unitcosthold' =>"required|numeric|min:1|gt:0",
                        'SellingPrice' =>"required|numeric|min:1|gt:unitcosthold",
                    ]);
                }
                if($findid!=null)
                {
                    $validator = Validator::make($request->all(), [
                        'addHoldItem' =>'required',
                        'quantityhold' =>"required|numeric|min:1|gt:0",
                        'unitcosthold' =>"required|numeric|min:1|gt:0",
                        'SellingPrice' =>"required|numeric|min:1|gt:unitcosthold",
                    ]);
                }
    
                if($validator->passes())
                {
                    try
                    {
                        $hold=deadstockdetail::updateOrCreate(['id' => $request->recevingedit], [
                        'HeaderId' => trim($request->receIds),
                        'ItemId' => trim($request->addHoldItem),
                        'Quantity' => trim($request->quantityhold),
                        'SellingPrice' => trim($request->SellingPrice),
                        'UnitCost' =>trim($request->unitcosthold),
                        'BeforeTaxCost' =>trim($request->beforetaxhold),
                        'StoreId' => trim($request->destreceivingstoreid),
                        'ConvertedQuantity' => trim($request->convertedqi),
                        'ConversionAmount' => trim($request->convertedamnti),
                        'NewUOMId' => trim($request->newuomi),
                        'DefaultUOMId' => trim($request->defaultuomi),
                        'ItemType' => trim($request->itemtypei),
                        'TransactionType' =>"HandIn",
                        'TransactionsType' =>"HandIn"
                        ]);
                            $countitem = DB::table('deadstockdetails')->where('HeaderId', '=', $hids)->get();
                            $getCountItem = $countitem->count();
                            
                            $pricing = DB::table('deadstockdetails')
                            ->select(DB::raw('SUM(BeforeTaxCost) as BeforeTaxCost,SUM(TaxAmount) as TaxAmount,SUM(TotalCost) as TotalCost'))
                            ->where('HeaderId', '=', $hids)
                            ->get();
            
                            $updprice=DB::select('update deadstockrecs set SubTotal=(SELECT SUM(BeforeTaxCost) FROM deadstockdetails WHERE HeaderId='.$hids.') where id='.$hids.'');
                            
                            $transactiontype="HandIn";
                            if($findid!=null)
                            {
                                DB::table('deadstocktransaction')
                                ->where('HeaderId',$hids)
                                ->where('StoreId',$dstoreid)
                                ->where('ItemId',$itemidold)
                                ->where('TransactionType',$transactiontype)
                                ->where('TransactionsType',$transactiontype)
                                ->update(['ItemId'=>$itemid,'StockIn'=>$request->quantityhold,'UnitCost'=>$unitcost,'BeforeTaxCost'=>$totalcost]);
                                
                                $updatetransactionCost=DB::select('UPDATE deadstocktransaction SET UnitCost='.$unitcost.',BeforeTaxCost=deadstocktransaction.StockIn * deadstocktransaction.UnitCost WHERE ItemId='.$itemid.' AND TransactionType="'.$transactiontype.'" AND TransactionsType="'.$transactiontype.'" AND StockIn IS NOT NULL');
                            }
                            if($findid==null)
                            {
                                $receiving = DB::table('deadstockdetails')->where('HeaderId', $hids)->latest()->first();
                                $recid=$receiving->id;
            
                                $receivingheader = DB::table('deadstockrecs')->where('id', $hids)->latest()->first();
                                $deadstockDocnumber=$receivingheader->DocumentNumber;
    
                                $settingsval = DB::table('settings')->latest()->first();
                                $fiscalyr=$settingsval->FiscalYear;
                                $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                                    ['HeaderId', 'ItemId', 'StockIn','UnitCost','BeforeTaxCost','TaxAmountCost','TotalCost','StoreId','TransactionType','ItemType','RetailerPrice'
                                    ],
                                    function ($query)use($recid) {
                                        $query
                                            ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','TransactionType','ItemType','SellingPrice']) // ..., columnN
                                            ->from('deadstockdetails')->where('id', '=',$recid);
                                    }
                                );
            
                                    $trtype="HandIn";
                                    DB::table('deadstocktransaction')
                                    ->where('HeaderId', $hids)
                                    ->where('TransactionType', $trtype)
                                    ->update(['FiscalYear'=>$fiscalyr,'DocumentNumber'=>$deadstockDocnumber,'TransactionsType'=>$trtype,'Date'=>Carbon::today()->toDateString()]);
                            }
                        return Response::json(['success' =>  '1','PricingVal'=>$pricing,'Totalcount'=>$getCountItem,'HeaderId'=>$hids,'StoreId'=>$dstoreid,'ItemId'=>$itemid,'TransactionType'=>$transactiontype]);
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
        }

        else if($type=="Internal")
        {
            $stockin=DB::select('SELECT sum(COALESCE(StockIn,0)) AS StockIn FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.TransactionType!="Begining" AND deadstocktransaction.StoreId='.$storeid);
            $stockout=DB::select('SELECT sum(COALESCE(StockOut,0)) AS StockOut FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.StoreId='.$storeid);
    
            foreach($stockin as $row)
            {
                    $stockin=$row->StockIn;
            }
            foreach($stockout as $row)
            {
                    $stockout=$row->StockOut;
            }
            $stockin = (float)$stockin;
            $stockout = (float)$stockout;
            $result=($stockin+$quantity)-($stockout);
    
            if($result<0)
            {
                return Response::json(['valerror' =>  "error",'countedval'=>$result]);
            }
            else
            {
                if($findid==null)
                {
                    $validator = Validator::make($request->all(), [
                        'addHoldItem' => ['required',
                        Rule::unique('deadstockdetails', 'ItemId')->where(function ($query) use ($hids) {
                            return $query->where('HeaderId', $hids);
                        })
                        ],
                        'quantityhold' =>"required|numeric|min:1|gt:0",
                        'unitcosthold' =>"required|numeric|min:1|gt:0",
                        'SellingPrice' =>"required|numeric|min:1|gt:unitcosthold",
                    ]);
                }
                if($findid!=null)
                {
                    $validator = Validator::make($request->all(), [
                        'addHoldItem' =>'required',
                        'quantityhold' =>"required|numeric|min:1|gt:0",
                        'unitcosthold' =>"required|numeric|min:1|gt:0",
                        'SellingPrice' =>"required|numeric|min:1|gt:unitcosthold",
                    ]);
                }
    
                if($validator->passes())
                {
                    try
                    {
                        $hold=deadstockdetail::updateOrCreate(['id' => $request->recevingedit], [
                        'HeaderId' => trim($request->receIds),
                        'ItemId' => trim($request->addHoldItem),
                        'Quantity' => trim($request->quantityhold),
                        'SellingPrice' => trim($request->SellingPrice),
                        'UnitCost' =>trim($request->unitcosthold),
                        'BeforeTaxCost' =>trim($request->beforetaxhold),
                        'StoreId' => trim($request->destreceivingstoreid),
                        'ConvertedQuantity' => trim($request->convertedqi),
                        'ConversionAmount' => trim($request->convertedamnti),
                        'NewUOMId' => trim($request->newuomi),
                        'DefaultUOMId' => trim($request->defaultuomi),
                        'ItemType' => trim($request->itemtypei),
                        'TransactionType' =>"HandIn",
                        'TransactionsType' =>"HandIn"
                        ]);
                            $countitem = DB::table('deadstockdetails')->where('HeaderId', '=', $hids)->get();
                            $getCountItem = $countitem->count();
                            
                            $pricing = DB::table('deadstockdetails')
                            ->select(DB::raw('SUM(BeforeTaxCost) as BeforeTaxCost,SUM(TaxAmount) as TaxAmount,SUM(TotalCost) as TotalCost'))
                            ->where('HeaderId', '=', $hids)
                            ->get();
            
                            $updprice=DB::select('update deadstockrecs set SubTotal=(SELECT SUM(BeforeTaxCost) FROM deadstockdetails WHERE HeaderId='.$hids.') where id='.$hids.'');
                            
                            $transactiontype="HandIn";
                            $transactionissue="HandIn";
                            if($findid!=null)
                            {
                                DB::table('deadstocktransaction')
                                ->where('DocumentNumber',$docnum)
                                ->where('StoreId',$dstoreid)
                                ->where('ItemId',$itemid)
                                ->where('TransactionType',$transactiontype)
                                ->where('TransactionsType',$transactiontype)
                                ->update(['StockIn'=>$quantity,'UnitCost'=>$unitcost,'BeforeTaxCost'=>$totalcost]);
                                
                                DB::table('transactions')
                                ->where('DocumentNumber',$docnum)
                                ->where('StoreId',$storeid)
                                ->where('ItemId',$itemid)
                                ->where('TransactionType',$transactiontype)
                                ->where('TransactionsType',$transactionissue)
                                ->update(['StockOut'=>$quantity,'UnitPrice'=>$unitcost,'BeforeTaxPrice'=>$totalcost]);

                                $updatetransactionCost=DB::select('UPDATE deadstocktransaction SET UnitCost='.$unitcost.',BeforeTaxCost=deadstocktransaction.StockIn * deadstocktransaction.UnitCost WHERE ItemId='.$itemid.' AND TransactionType="'.$transactiontype.'" AND TransactionsType="'.$transactiontype.'" AND StockIn IS NOT NULL');
                                $updateMaintransactionCost=DB::select('UPDATE transactions SET UnitPrice='.$unitcost.',BeforeTaxPrice=transactions.StockIn * transactions.UnitPrice WHERE ItemId='.$itemid.' AND TransactionType="'.$transactiontype.'" AND TransactionsType="'.$transactiontype.'" AND StockIn IS NOT NULL');
                            }
                            if($findid==null)
                            {
                                $receiving = DB::table('deadstockdetails')->where('HeaderId', $hids)->latest()->first();
                                $recid=$receiving->id;
            
                                $receivingheader = DB::table('deadstockrecs')->where('id', $hids)->latest()->first();
                                $deadstockDocnumber=$receivingheader->DocumentNumber;
    
                                $settingsval = DB::table('settings')->latest()->first();
                                $fiscalyr=$settingsval->FiscalYear;
                                $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                                    ['HeaderId', 'ItemId', 'StockIn','UnitCost','BeforeTaxCost','TaxAmountCost','TotalCost','StoreId','TransactionType','TransactionsType','ItemType','RetailerPrice'
                                    ],
                                    function ($query)use($recid) {
                                        $query
                                            ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','TransactionType','TransactionsType','ItemType','SellingPrice']) // ..., columnN
                                            ->from('deadstockdetails')->where('id', '=',$recid);
                                    }
                                );
            
                                $dstransactiondata=DB::table('transactions')->insertUsing(
                                    ['HeaderId', 'ItemId', 'StockOut','UnitPrice','BeforeTaxPrice','TaxAmountCost','TotalCost','StoreId','TransactionType','ItemType','RetailerPrice'
                                    ],
                                    function ($query)use($recid) {
                                        $query
                                            ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','TransactionType','ItemType','SellingPrice']) // ..., columnN
                                            ->from('deadstockdetails')->where('id', '=',$recid);
                                    }
                                );

                                $trtype="HandIn";
                                $trisstype="HandIn";

                                DB::table('deadstocktransaction')
                                ->where('HeaderId', $hids)
                                ->where('TransactionType', $trtype)
                                ->update(['FiscalYear'=>$fiscalyr,'DocumentNumber'=>$deadstockDocnumber,'TransactionsType'=>$trtype,'Date'=>Carbon::today()->toDateString()]);

                                DB::table('transactions')
                                ->where('HeaderId', $hids)
                                ->where('TransactionType', $trtype)
                                ->whereNull('StockIn')
                                ->update(['FiscalYear'=>$fiscalyr,'DocumentNumber' => $deadstockDocnumber,'TransactionsType'=>$trisstype,'Date'=>Carbon::today()->toDateString()]);
                            }
                        return Response::json(['success' =>  '1','headerid'=>$hids,'doc'=>$docnum,'StoreId'=>$dstoreid,'ItemId'=>$itemid,'TransactionType'=>$transactiontype,'TransactionsType'=>$transactionissue]);
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
        }
    }


    public function storeNewDeadStockItemsPen(Request $request)
    {
        $headerid=$request->recevingedit;
        $storeid=$request->receivingstoreid;
        $dstoreid=$request->destreceivingstoreid;
        $ss=$request->receivingidinput;
        $findid=$request->recevingedit;
        $valId=$request->editVal;
        $hids=$request->receIds;
        $itemid=$request->addHoldItem;
        $itemidold=$request->itemidold;
        $quantity=$request->quantityhold;
        $unitcost=$request->unitcosthold;
        $totalcost=$request->beforetaxhold;
        $dsType=deadstock::find($hids);
        $type=$dsType->Type;
        $docnum=$dsType->DocumentNumber;

        if($type=="External")
        {
            $stockin=DB::select('SELECT sum(COALESCE(StockIn,0)) AS StockIn FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.TransactionType!="Begining" AND deadstocktransaction.StoreId='.$dstoreid);
            $stockout=DB::select('SELECT sum(COALESCE(StockOut,0)) AS StockOut FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.StoreId='.$dstoreid);
    
            foreach($stockin as $row)
            {
                    $stockin=$row->StockIn;
            }
            foreach($stockout as $row)
            {
                    $stockout=$row->StockOut;
            }
            $stockin = (float)$stockin;
            $stockout = (float)$stockout;
            $result=($stockin+$quantity)-($stockout);
    
            if($result<0 && $findid!=null)
            {
                return Response::json(['valerror' =>  "error",'countedval'=>$result]);
            }
            else
            {
                if($findid==null)
                {
                    $validator = Validator::make($request->all(), [
                        'addHoldItem' => ['required',
                        Rule::unique('deadstockdetails', 'ItemId')->where(function ($query) use ($hids) {
                            return $query->where('HeaderId', $hids);
                        })
                        ],
                        'quantityhold' =>"required|numeric|min:1|gt:0",
                        'unitcosthold' =>"required|numeric|min:1|gt:0",
                        'SellingPrice' =>"required|numeric|min:1|gt:unitcosthold",
                    ]);
                }
                if($findid!=null)
                {
                    $validator = Validator::make($request->all(), [
                        'addHoldItem' =>'required',
                        'quantityhold' =>"required|numeric|min:1|gt:0",
                        'unitcosthold' =>"required|numeric|min:1|gt:0",
                        'SellingPrice' =>"required|numeric|min:1|gt:unitcosthold",
                    ]);
                }
    
                if($validator->passes())
                {
                    try
                    {
                        $hold=deadstockdetail::updateOrCreate(['id' => $request->recevingedit], [
                        'HeaderId' => trim($request->receIds),
                        'ItemId' => trim($request->addHoldItem),
                        'Quantity' => trim($request->quantityhold),
                        'SellingPrice' => trim($request->SellingPrice),
                        'UnitCost' =>trim($request->unitcosthold),
                        'BeforeTaxCost' =>trim($request->beforetaxhold),
                        'StoreId' => trim($request->destreceivingstoreid),
                        'ConvertedQuantity' => trim($request->convertedqi),
                        'ConversionAmount' => trim($request->convertedamnti),
                        'NewUOMId' => trim($request->newuomi),
                        'DefaultUOMId' => trim($request->defaultuomi),
                        'ItemType' => trim($request->itemtypei),
                        'TransactionType' =>"HandIn",
                        'TransactionsType' =>"HandIn"
                        ]);
                            $countitem = DB::table('deadstockdetails')->where('HeaderId', '=', $hids)->get();
                            $getCountItem = $countitem->count();
                            
                            $pricing = DB::table('deadstockdetails')
                            ->select(DB::raw('SUM(BeforeTaxCost) as BeforeTaxCost,SUM(TaxAmount) as TaxAmount,SUM(TotalCost) as TotalCost'))
                            ->where('HeaderId', '=', $hids)
                            ->get();
            
                            $updprice=DB::select('update deadstockrecs set SubTotal=(SELECT SUM(BeforeTaxCost) FROM deadstockdetails WHERE HeaderId='.$hids.') where id='.$hids.'');
                            
                        return Response::json(['success' =>  '1','PricingVal'=>$pricing,'Totalcount'=>$getCountItem,'HeaderId'=>$hids,'StoreId'=>$dstoreid,'ItemId'=>$itemid]);
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
        }

        else if($type=="Internal")
        {
            $stockin=DB::select('SELECT sum(COALESCE(StockIn,0)) AS StockIn FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.TransactionType!="Begining" AND deadstocktransaction.StoreId='.$storeid);
            $stockout=DB::select('SELECT sum(COALESCE(StockOut,0)) AS StockOut FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.StoreId='.$storeid);
    
            foreach($stockin as $row)
            {
                    $stockin=$row->StockIn;
            }
            foreach($stockout as $row)
            {
                    $stockout=$row->StockOut;
            }
            $stockin = (float)$stockin;
            $stockout = (float)$stockout;
            $result=($stockin+$quantity)-($stockout);
    
            if($result<0)
            {
                return Response::json(['valerror' =>  "error",'countedval'=>$result]);
            }
            else
            {
                if($findid==null)
                {
                    $validator = Validator::make($request->all(), [
                        'addHoldItem' => ['required',
                        Rule::unique('deadstockdetails', 'ItemId')->where(function ($query) use ($hids) {
                            return $query->where('HeaderId', $hids);
                        })
                        ],
                        'quantityhold' =>"required|numeric|min:1|gt:0",
                        'unitcosthold' =>"required|numeric|min:1|gt:0",
                        'SellingPrice' =>"required|numeric|min:1|gt:unitcosthold",
                    ]);
                }
                if($findid!=null)
                {
                    $validator = Validator::make($request->all(), [
                        'addHoldItem' =>'required',
                        'quantityhold' =>"required|numeric|min:1|gt:0",
                        'unitcosthold' =>"required|numeric|min:1|gt:0",
                        'SellingPrice' =>"required|numeric|min:1|gt:unitcosthold",
                    ]);
                }
    
                if($validator->passes())
                {
                    try
                    {
                        $hold=deadstockdetail::updateOrCreate(['id' => $request->recevingedit], [
                        'HeaderId' => trim($request->receIds),
                        'ItemId' => trim($request->addHoldItem),
                        'Quantity' => trim($request->quantityhold),
                        'SellingPrice' => trim($request->SellingPrice),
                        'UnitCost' =>trim($request->unitcosthold),
                        'BeforeTaxCost' =>trim($request->beforetaxhold),
                        'StoreId' => trim($request->destreceivingstoreid),
                        'ConvertedQuantity' => trim($request->convertedqi),
                        'ConversionAmount' => trim($request->convertedamnti),
                        'NewUOMId' => trim($request->newuomi),
                        'DefaultUOMId' => trim($request->defaultuomi),
                        'ItemType' => trim($request->itemtypei),
                        'TransactionType' =>"HandIn",
                        'TransactionsType' =>"HandIn"
                        ]);
                            $countitem = DB::table('deadstockdetails')->where('HeaderId', '=', $hids)->get();
                            $getCountItem = $countitem->count();
                            
                            $pricing = DB::table('deadstockdetails')
                            ->select(DB::raw('SUM(BeforeTaxCost) as BeforeTaxCost,SUM(TaxAmount) as TaxAmount,SUM(TotalCost) as TotalCost'))
                            ->where('HeaderId', '=', $hids)
                            ->get();
            
                            $updprice=DB::select('update deadstockrecs set SubTotal=(SELECT SUM(BeforeTaxCost) FROM deadstockdetails WHERE HeaderId='.$hids.') where id='.$hids.'');
                            
                            $transactiontype="HandIn";
                            $transactionissue="HandIn";
                            return Response::json(['success' =>  '1','PricingVal'=>$pricing,'Totalcount'=>$getCountItem,'headerid'=>$hids,'doc'=>$docnum,'StoreId'=>$dstoreid,'ItemId'=>$itemid,'TransactionType'=>$transactiontype,'TransactionsType'=>$transactionissue]);
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
        }
    }

    public function deleteDeadStockItem(Request $request, $id)
    {
        $headerid=$request->receivingremoveheaderid;
        $headerTable = deadstock::find($headerid);
        $type=$headerTable->Type;
        $st=$request->subtotali;
        $recevingItem = deadstockdetail::find($id);
    
        $itemid=$recevingItem->ItemId;
        $storeid=$recevingItem->StoreId;
        $quantity=$recevingItem->Quantity;

        //$getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM deadstockdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId ='.$itemid.') WHERE trs.HeaderId='.$headerid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trs.ItemId AND deadstocktransaction.StoreId='.$storeid.'),0)-'.$quantity.')<0');
        $stockin=DB::select('SELECT sum(COALESCE(StockIn,0)) AS StockIn FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.StoreId='.$storeid);
        $stockout=DB::select('SELECT sum(COALESCE(StockOut,0)) AS StockOut FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.StoreId='.$storeid);

        foreach($stockin as $row)
        {
                $stockin=$row->StockIn;
        }
        foreach($stockout as $row)
        {
                $stockout=$row->StockOut;
        }
        $stockin = (float)$stockin;
        $stockout = (float)$stockout;
        $result=($stockin-$stockout)-($quantity);
        if($result<0)
        {
            return Response::json(['valerror' =>  "error",'countedval'=>$result]);
        }
        else
        {
            $rec = deadstockdetail::find($id);
            $rec->delete();
            $countitem = DB::table('deadstockdetails')->where('HeaderId', '=', $headerid)->get();
            $getCountItem = $countitem->count();

            $pricing = DB::table('deadstockdetails')
            ->select(DB::raw('SUM(BeforeTaxCost) as BeforeTaxCost,SUM(TaxAmount) as TaxAmount,SUM(TotalCost) as TotalCost'))
            ->where('HeaderId', '=', $headerid)
            ->get();
            $updprice=DB::select('update deadstockrecs set SubTotal=(SELECT SUM(BeforeTaxCost) FROM deadstockdetails WHERE HeaderId='.$headerid.'),
            Tax=(SELECT SUM(TaxAmount) FROM deadstockdetails WHERE HeaderId='.$headerid.'),
            GrandTotal=(SELECT SUM(TotalCost) FROM deadstockdetails WHERE HeaderId='.$headerid.')
            where id='.$headerid.'');

            $transactiontype="HandIn";
            $bgcon = DB::table('deadstockrecs')->where('id', $headerid)->latest()->first();
            $docnum=$bgcon->DocumentNumber;
            
            $removeTransaction=DB::select('DELETE FROM deadstocktransaction WHERE TransactionType="'.$transactiontype.'" AND TransactionsType="'.$transactiontype.'" AND HeaderId='.$headerid.' AND ItemId='.$itemid.' AND DocumentNumber="'.$docnum.'"');
            if($type=="Internal")
            {
                $removeTransaction=DB::select('DELETE FROM transactions WHERE TransactionType="'.$transactiontype.'" AND TransactionsType="'.$transactiontype.'" AND HeaderId='.$headerid.' AND ItemId='.$itemid.' AND DocumentNumber="'.$docnum.'"');
            }
            return Response::json(['success' => 'Item Removed','Totalcount'=>$getCountItem,'PricingVal'=>$pricing]);
        }
    }

    public function deleteDeadStockItemPen(Request $request, $id)
    {
        $headerid=$request->receivingremoveheaderid;
        $headerTable = deadstock::find($headerid);
        $type=$headerTable->Type;
        $st=$request->subtotali;
        $recevingItem = deadstockdetail::find($id);
    
        $itemid=$recevingItem->ItemId;
        $storeid=$recevingItem->StoreId;
        $quantity=$recevingItem->Quantity;


            $rec = deadstockdetail::find($id);
            $rec->delete();
            $countitem = DB::table('deadstockdetails')->where('HeaderId', '=', $headerid)->get();
            $getCountItem = $countitem->count();

            $pricing = DB::table('deadstockdetails')
            ->select(DB::raw('SUM(BeforeTaxCost) as BeforeTaxCost,SUM(TaxAmount) as TaxAmount,SUM(TotalCost) as TotalCost'))
            ->where('HeaderId', '=', $headerid)
            ->get();
            $updprice=DB::select('update deadstockrecs set SubTotal=(SELECT SUM(BeforeTaxCost) FROM deadstockdetails WHERE HeaderId='.$headerid.'),
            Tax=(SELECT SUM(TaxAmount) FROM deadstockdetails WHERE HeaderId='.$headerid.'),
            GrandTotal=(SELECT SUM(TotalCost) FROM deadstockdetails WHERE HeaderId='.$headerid.')
            where id='.$headerid.'');

            return Response::json(['success' => 'Item Removed','Totalcount'=>$getCountItem,'PricingVal'=>$pricing]);
       
    }

    public function showDeadStockDataCon($id)
    {
        $ids=$id;
        $columnName="id";
        $dsrec = deadstock::find($id);
        $createddateval=$dsrec->created_at;

        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $holdHeader=DB::select('SELECT deadstockrecs.id,deadstockrecs.Type,deadstockrecs.DocumentNumber,customers.CustomerCategory,concat(str.Name) as Sources,customers.Name AS CustomerName,deadstockrecs.PaymentType,deadstockrecs.VoucherType,deadstockrecs.VoucherNumber,deadstockrecs.CustomerMRC,stores.Name as StoreName,deadstockrecs.PurchaserName,deadstockrecs.IsVoid,deadstockrecs.VoidReason,deadstockrecs.VoidedBy,deadstockrecs.VoidedDate,deadstockrecs.TransactionDate,deadstockrecs.Status,deadstockrecs.StatusOld,deadstockrecs.WitholdPercent,deadstockrecs.WitholdAmount,deadstockrecs.SubTotal,deadstockrecs.Tax,deadstockrecs.GrandTotal,deadstockrecs.NetPay,deadstockrecs.Username,deadstockrecs.ReceivedBy,deadstockrecs.DeliveredBy,deadstockrecs.CheckedBy,deadstockrecs.CheckedDate,deadstockrecs.ConfirmedBy,deadstockrecs.ConfirmedDate,deadstockrecs.ChangeToPendingBy,deadstockrecs.ChangeToPendingDate,deadstockrecs.Memo,"'.$datetime.'" AS created_at,deadstockrecs.SourceStore FROM deadstockrecs INNER JOIN stores ON deadstockrecs.StoreId=stores.id INNER JOIN stores AS str ON deadstockrecs.SourceStore=str.id INNER JOIN customers on deadstockrecs.CustomerId=customers.id WHERE deadstockrecs.id='.$id);
        $countitem = DB::table('deadstockdetails')->where('HeaderId', '=', $id)
        ->get();
        $getCountItem = $countitem->count();
        $rechold = receiving::find($id);
        return response()->json(['holdHeader'=>$holdHeader,'count'=>$getCountItem]);       
    }
    
    public function showDeadStockDetailDataCon($id)
    {
        $HeaderId=$id;
        $columnName="HeaderId";
        $detailTable=DB::select('SELECT deadstockdetails.id,deadstockdetails.ItemId,deadstockdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,uoms.Name AS UOM,deadstockdetails.Quantity,deadstockdetails.UnitCost,deadstockdetails.BeforeTaxCost,deadstockdetails.TaxAmount,deadstockdetails.TotalCost FROM deadstockdetails INNER JOIN regitems ON deadstockdetails.ItemId=regitems.id INNER JOIN uoms ON deadstockdetails.NewUOMId=uoms.id where deadstockdetails.HeaderId='.$HeaderId.' order by deadstockdetails.id asc');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            $btn =  ' <a data-id="'.$data->ItemId.'" class="btn btn-icon btn-gradient-info btn-sm showItemInfos" data-toggle="modal" id="mediumButton" data-target="#examplemodal-locedit" style="color: white;" title="Show Item Info"><i class="fa fa-info"></i></a>';
            $btn =  $btn.' <a data-id="'.$data->id.'" data-HeaderId="'.$data->HeaderId.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            $btn = $btn.' <a data-id="'.$data->id.'" data-hid="'.$data->HeaderId.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }



    public function receivingDeadStockVoid(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->voidid;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $rec=deadstock::find($findid);
        $storeId=$rec->StoreId;
        $docnum=$rec->DocumentNumber;
        $type=$request->vtype;

        if($type=="External")
        {
            $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM deadstockdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trs.ItemId AND deadstocktransaction.StoreId='.$storeId.'),0)-trs.Quantity)<0');

            foreach($getApprovedQuantity as $row)
            {
                $avaq=$row->ApprovedItems;
            }

            $avaqp = (float)$avaq;
            if($avaqp>=1)
            {
                $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trn.ItemId AND deadstocktransaction.StoreId='.$storeId.') AS AvailableQuantity FROM deadstockdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND 
                (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trn.ItemId AND deadstocktransaction.StoreId='.$storeId.'),0)-trs.Quantity)<0');
                return Response::json(['valerror' =>  "error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
            }
            else
            {
                $validator = Validator::make($request->all(), [
                    'Reason'=>"required",
                ]);
                if ($validator->passes()) 
                {
                    $transactiontype="HandIn";
                    $updateStatus=DB::select('update deadstockrecs set StatusOld=Status where id='.$findid.'');
                    $rec->Status="Void";
                    $rec->IsVoid="1";
                    $rec->VoidedBy=$user;
                    $rec->VoidReason=trim($request->input('Reason'));
                    $rec->VoidedDate=Carbon::today()->toDateString();
                    $rec->save();
                    $transactiontype="HandIn";
                    $undotransaction="Undo-Void";
                    $rectype="HandIn";
                    $syncToTransactionVoidDs=DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,StoreId,TransactionType,"Void",ItemType,"'.$docnum.'","'.$fiscalyr.'","1","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);
                    //$removeTransaction=DB::select('DELETE FROM deadstocktransaction WHERE TransactionType="'.$rectype.'" AND TransactionsType="'.$rectype.'" AND HeaderId='.$findid);
                    return Response::json(['success'=>'1']);
                }
                else
                {
                    return Response::json(['errors' => $validator->errors()]);
                }
            }
        }

        if($type=="Internal")
        {
            $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM deadstockdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trs.ItemId AND deadstocktransaction.StoreId='.$storeId.'),0)-trs.Quantity)<0');
            foreach($getApprovedQuantity as $row)
            {
                $avaq=$row->ApprovedItems;
            }
            $avaqp = (float)$avaq;
            if($avaqp>=1)
            {
                $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trn.ItemId AND deadstocktransaction.StoreId='.$storeId.') AS AvailableQuantity FROM deadstockdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND 
                (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trn.ItemId AND deadstocktransaction.StoreId='.$storeId.'),0)-trs.Quantity)<0');
                return Response::json(['valerror' =>  "error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
            }
            else
            {
                $validator = Validator::make($request->all(), [
                    'Reason'=>"required",
                ]);
                if ($validator->passes()) 
                {
                    $transactiontype="HandIn";
                    DB::table('deadstocktransaction')
                    ->where('HeaderId', $findid)
                    ->where('TransactionType',$transactiontype)
                    ->where('TransactionsType',$transactiontype)
                    ->update(['UnitCost' => "0"]);

                    $updateStatus=DB::select('update deadstockrecs set StatusOld=Status where id='.$findid.'');
                    $rec->Status="Void";
                    $rec->IsVoid="1";
                    $rec->VoidedBy=$user;
                    $rec->VoidReason=trim($request->input('Reason'));
                    $rec->VoidedDate=Carbon::today()->toDateString();
                    $rec->save();
                    $transactiontype="HandIn";
                    $undotransaction="Undo-Void";
                    $rectype="HandIn";

                    //$removeTransaction=DB::select('DELETE FROM deadstocktransaction WHERE TransactionType="'.$rectype.'" AND HeaderId='.$findid);
                    
                    $syncToTransactionVoidDs=DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,StoreId,TransactionType,"Void",ItemType,"'.$docnum.'","'.$fiscalyr.'","1","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);
                    $syncToTransactionVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,StoreId,TransactionType,"Void",ItemType,"'.$docnum.'","'.$fiscalyr.'","1","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);
                    //$removeMainTransaction=DB::select('DELETE FROM transactions WHERE TransactionType="'.$rectype.'" AND HeaderId='.$findid);
                    return Response::json(['success' => '1']);
                }
                else
                {
                    return Response::json(['errors' => $validator->errors()]);
                }
            }
        }
          
    }

    public function receivingDeadStockVoidPen(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->voidid;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $rec=deadstock::find($findid);
        $storeId=$rec->StoreId;
        $type=$request->vtype;

        if($type=="External")
        {
            $validator = Validator::make($request->all(), [
                'Reason'=>"required",
            ]);
            if ($validator->passes()) 
            {
                $updateStatus=DB::select('update deadstockrecs set StatusOld=Status where id='.$findid.'');
                $rec->Status="Void";
                $rec->IsVoid="1";
                $rec->VoidedBy=$user;
                $rec->VoidReason=trim($request->input('Reason'));
                $rec->VoidedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                //$rec->VoidedDate=Carbon::today()->toDateString();
                $rec->save();
                $transactiontype="HandIn";
                $undotransaction="Undo-Void";
                $rectype="HandIn";

                //$removeTransaction=DB::select('DELETE FROM deadstocktransaction WHERE TransactionType="'.$rectype.'" AND TransactionsType="'.$rectype.'" AND HeaderId='.$findid);
                return Response::json(['success' => '1']);
            }
            else
            {
                return Response::json(['errors' => $validator->errors()]);
            }    
        }

        if($type=="Internal")
        {
            $validator = Validator::make($request->all(), [
                'Reason'=>"required",
            ]);
            if ($validator->passes()) 
            {
                $updateStatus=DB::select('update deadstockrecs set StatusOld=Status where id='.$findid.'');
                $rec->Status="Void";
                $rec->IsVoid="1";
                $rec->VoidedBy=$user;
                $rec->VoidReason=trim($request->input('Reason'));
                $rec->VoidedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                //$rec->VoidedDate=Carbon::today()->toDateString();
                $rec->save();
                $transactiontype="HandIn";
                $undotransaction="Undo-Void";
                $rectype="HandIn";

                //$removeTransaction=DB::select('DELETE FROM deadstocktransaction WHERE TransactionType="'.$rectype.'" AND HeaderId='.$findid);

                //$removeMainTransaction=DB::select('DELETE FROM transactions WHERE TransactionType="'.$rectype.'" AND HeaderId='.$findid);
                return Response::json(['success' => '1']);
            }
            else
            {
                return Response::json(['errors' => $validator->errors()]);
            }
        }  
    }

    public function showDeadStockRecCon($id)
    {
        $ids=$id;
        $columnName="id";
        $holdHeader=DB::select('SELECT deadstockrecs.id,deadstockrecs.Type,deadstockrecs.DocumentNumber,customers.CustomerCategory,customers.Name as CustomerName,deadstockrecs.PaymentType,deadstockrecs.VoucherType,deadstockrecs.VoucherNumber,deadstockrecs.CustomerMRC,stores.Name as StoreName,deadstockrecs.PurchaserName,deadstockrecs.IsVoid,deadstockrecs.VoidReason,deadstockrecs.VoidedBy,deadstockrecs.VoidedDate,deadstockrecs.TransactionDate,deadstockrecs.Status,deadstockrecs.StatusOld,deadstockrecs.WitholdPercent,deadstockrecs.WitholdAmount,deadstockrecs.SubTotal,deadstockrecs.Tax,deadstockrecs.GrandTotal,deadstockrecs.NetPay,deadstockrecs.Username,deadstockrecs.ReceivedBy,deadstockrecs.DeliveredBy,deadstockrecs.CheckedBy,deadstockrecs.CheckedDate,deadstockrecs.ConfirmedBy,deadstockrecs.ConfirmedDate,deadstockrecs.ChangeToPendingBy,deadstockrecs.ChangeToPendingDate,deadstockrecs.Memo,deadstockrecs.created_at FROM deadstockrecs INNER JOIN stores ON deadstockrecs.StoreId=stores.id INNER JOIN customers on deadstockrecs.CustomerId=customers.id WHERE deadstockrecs.id='.$id);
        
        $countitem = DB::table('deadstockdetails')->where('HeaderId', '=', $id)->get();
        $getCountItem = $countitem->count();
        $rechold = deadstock::find($id);
        return response()->json(['holdHeader'=>$holdHeader,'count'=>$getCountItem]);       
    }

    public function undoDeadStockVoidCon(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->undovoidid;
        $rec=deadstock::find($findid);
        $type=$rec->Type;
        $storeId=$rec->SourceStore;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $receivngcon = DB::table('deadstockrecs')->where('id', $findid)->latest()->first();
        $docnum=$receivngcon->DocumentNumber;
        if($type=="External")
        {
            // $receivingtype="HandIn";
            // $voidtype="Void";
            // $trtype="Undo-Void";
            // DB::table('deadstockdetails')
            // ->where('HeaderId', $findid)
            // ->update(['TransactionsType'=>$receivingtype]);

            // $transactiondata=DB::table('deadstocktransaction')->insertUsing(
            //     ['HeaderId', 'ItemId', 'StockIn','UnitCost','BeforeTaxCost','TaxAmountCost','TotalCost','StoreId','TransactionType','TransactionsType','ItemType'],
            //     function ($query)use($findid) {
            //         $query
            //             ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','TransactionType','TransactionsType','ItemType']) // ..., columnN
            //             ->from('deadstockdetails')->where('HeaderId', '=',$findid);
            //     }
            // );

            $receivngcon = DB::table('deadstockrecs')->where('id', $findid)->latest()->first();
            $docnum=$receivngcon->DocumentNumber;
            $syncToTransactionVoidDs=DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,StoreId,TransactionType,"Undo-Void",ItemType,"'.$docnum.'","'.$fiscalyr.'","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);
            // $receivngcon = DB::table('deadstockrecs')->where('id', $findid)->latest()->first();
            // $docnum=$receivngcon->DocumentNumber;
            // $transactiontype="HandIn";

            // DB::table('deadstocktransaction')
            // ->where('HeaderId', $findid)
            // ->where('TransactionType',$transactiontype)
            // ->update(['DocumentNumber' => $docnum,'FiscalYear'=>$fiscalyr,'Date'=>Carbon::today()->toDateString()]);
        
            $updateStatus=DB::select('update deadstockrecs set Status=StatusOld where id='.$findid.'');
            $rec->StatusOld="";
            $rec->IsVoid="0";
            $rec->ChangeToPendingBy=$user;
            $rec->ChangeToPendingDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            //$rec->ChangeToPendingDate=Carbon::today()->toDateString();
            $rec->save();
            $trtype="Void";
            $undotransaction="Undo-Void";
            return Response::json(['success' => '1']);
        }
        else if($type=="Internal")
        {
            $receivingtype="HandIn";
            $voidtype="Void";
            $trtype="Undo-Void";
            DB::table('deadstockdetails')
            ->where('HeaderId', $findid)
            ->update(['TransactionsType'=>$receivingtype]);

            $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM deadstockdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trs.ItemId AND deadstocktransaction.StoreId='.$storeId.'),0)-trs.Quantity)<0');
            foreach($getApprovedQuantity as $row)
            {
                $avaq=$row->ApprovedItems;
            }
            $avaqp = (float)$avaq;
            if($avaqp>=1)
            {
                $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trn.ItemId AND deadstocktransaction.StoreId='.$storeId.') AS AvailableQuantity FROM deadstockdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND 
                (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trn.ItemId AND deadstocktransaction.StoreId='.$storeId.'),0)-trs.Quantity)<0');
                return Response::json(['valerror' =>  "error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
            }
            else{
                $transactiontype="HandIn";
                $transactiondata=DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,RetailerPrice,FiscalYear,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,ItemType,SellingPrice,'.$fiscalyr.',"'.$docnum.'","Undo-Void","'.Carbon::today()->toDateString().'" from deadstockdetails where deadstockdetails.HeaderId='.$findid);
                $dstransactiondatas=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,RetailerPrice,FiscalYear,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,ItemType,SellingPrice,'.$fiscalyr.',"'.$docnum.'","Undo-Void","'.Carbon::today()->toDateString().'" from deadstockdetails where deadstockdetails.HeaderId='.$findid);

                // $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                //     ['HeaderId', 'ItemId', 'StockIn','UnitCost','BeforeTaxCost','TaxAmountCost','TotalCost','StoreId','TransactionType','TransactionsType','ItemType'
                //     ],
                //     function ($query)use($findid) {
                //         $query
                //             ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','TransactionType','TransactionsType','ItemType']) // ..., columnN
                //             ->from('deadstockdetails')->where('HeaderId', '=',$findid);
                //     }
                // );

                // $dstransactiondata=DB::table('transactions')->insertUsing(
                //     ['HeaderId', 'ItemId', 'StockOut','UnitPrice','BeforeTaxPrice','TaxAmountCost','TotalCost','StoreId','TransactionType','ItemType','RetailerPrice'],
                //     function ($query)use($findid) {
                //         $query
                //             ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','TransactionType','ItemType','SellingPrice']) // ..., columnN
                //             ->from('deadstockdetails')->where('HeaderId', '=',$findid);
                //     }
                // );

                // $transactiontype="HandIn";

              

                // DB::table('deadstocktransaction')
                // ->where('HeaderId', $findid)
                // ->where('TransactionType',$transactiontype)
                // ->update(['DocumentNumber' => $docnum,'FiscalYear'=>$fiscalyr,'Date'=>Carbon::today()->toDateString()]);
            
                // DB::table('transactions')
                // ->where('HeaderId', $findid)
                // ->where('TransactionType', $transactiontype)
                // ->whereNull('StockIn')
                // ->update(['FiscalYear'=>$fiscalyr,'DocumentNumber' => $docnum,'TransactionsType'=>$transactiontype,'Date'=>Carbon::today()->toDateString()]);

                $updateStatus=DB::select('UPDATE deadstockrecs SET Status=StatusOld WHERE id='.$findid.'');
                $rec->StatusOld="-";
                $rec->IsVoid="0";
                $rec->ChangeToPendingBy=$user;
                $rec->ChangeToPendingDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                //$rec->ChangeToPendingDate=Carbon::today()->toDateString();
                $rec->save();
                $trtype="Void";
                $undotransaction="Undo-Void";
                return Response::json(['success' => '1']);
            }
            
        }
    }

    public function undoDeadStockVoidPen(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->undovoidid;
        $updateStatus=DB::select('update deadstockrecs set Status=StatusOld where id='.$findid.'');
        $rec=deadstock::find($findid);
        $rec->StatusOld="";
        $rec->IsVoid="0";
        $rec->ChangeToPendingBy = $user;
        $rec->ChangeToPendingDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $rec->save();
        $trtype = "Void";
        $undotransaction = "Undo-Void";
        return Response::json(['success' => '1']);
    }

    public function showDeadStockBalanceData()
    {
        $stbalance=DB::select('SELECT regitems.id as id,regitems.Code as ItemCode, regitems.Name as ItemName,regitems.SKUNumber AS SKUNumber,categories.Name as Category, uoms.Name as UOM,regitems.dsmaxcost,regitems.dsmaxcosteditable,regitems.DeadStockPrice as SellingPrice,IF(((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(SELECT IFNULL(SUM(deadstocksalesitems.Quantity),0) FROM deadstocksalesitems WHERE deadstocksalesitems.ItemId=regitems.id AND deadstocksalesitems.HeaderId IN(SELECT id FROM deadstocksale WHERE deadstocksale.Status="Pending/Removed")))<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(SELECT IFNULL(SUM(deadstocksalesitems.Quantity),0) FROM deadstocksalesitems WHERE deadstocksalesitems.ItemId=regitems.id AND deadstocksalesitems.HeaderId IN(SELECT id FROM deadstocksale WHERE deadstocksale.Status="Pending/Removed")))) as AvailableQuantity,(SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=regitems.id) AS AllBalance FROM deadstocktransaction inner join regitems on deadstocktransaction.ItemId=regitems.Id inner join categories on regitems.CategoryId=categories.id inner join uoms on regitems.MeasurementId=uoms.id WHERE (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=regitems.id)>0 group by regitems.Code,regitems.Name,regitems.SKUNumber,categories.Name,uoms.Name,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.id,regitems.DeadStockPrice order by regitems.Name asc');
        if(request()->ajax()) {
            return datatables()->of($stbalance)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editln='';
                if($user->can('StockBalance-EditPrice'))
                {
                    $editln='<a class="dropdown-item" data-id="'.$data->id.'" data-code="'.$data->ItemCode.'" data-name="'.$data->ItemName.'" data-sku="'.$data->SKUNumber.'" data-category="'.$data->Category.'" data-uom="'.$data->UOM.'" data-totalq="'.$data->AvailableQuantity.'" data-sellingp="'.$data->SellingPrice.'" data-maxcosts="'.$data->dsmaxcost.'" data-maxcostsedt="'.$data->dsmaxcosteditable.'" data-toggle="modal" id="mediumButton" data-target="#sellingPr" title="Edit Selling Price"><i class="fa fa-edit"></i><span> Edit Selling Price</span></a>';
                }
                $btn='<div class="btn-group">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" data-id="'.$data->id.'" data-code="'.$data->ItemCode.'" data-name="'.$data->ItemName.'" data-sku="'.$data->SKUNumber.'" data-category="'.$data->Category.'" data-uom="'.$data->UOM.'" data-totalq="'.$data->AvailableQuantity.'" data-sellingp="'.$data->SellingPrice.'" data-maxcosts="'.$data->dsmaxcost.'" data-maxcostsedt="'.$data->dsmaxcosteditable.'" data-toggle="modal" id="mediumButton" data-target="#stockInfoModal" title="Show Detail Info">
                        <i class="fa fa-info"></i><span> Info</span>  
                    </a>
                    '.$editln.'
                </div>
            </div>';    
            return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showDeadStockDetailDataInfo($id){
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->FiscalYear;
        $itemIds = $id;
        $detailTable = DB::select('SELECT deadstocktransaction.ItemId,deadstocktransaction.StoreId, stores.Name as StoreName,regitems.Code as ItemCode,regitems.Name as ItemName,uoms.Name as UOM,categories.Name as Category,(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as StoreBalance,(SELECT IFNULL(SUM(deadstocksalesitems.Quantity),0) FROM deadstocksalesitems WHERE deadstocksalesitems.ItemId='.$itemIds.' AND deadstocksalesitems.StoreId=stores.id AND deadstocksalesitems.HeaderId IN(SELECT id FROM deadstocksale WHERE deadstocksale.Status="Pending/Removed")) AS PendingQuantity from deadstocktransaction INNER JOIN stores on deadstocktransaction.StoreId=stores.Id INNER JOIN regitems on deadstocktransaction.ItemId='.$itemIds.' INNER JOIN uoms ON regitems.MeasurementId=uoms.Id INNER JOIN categories ON regitems.CategoryId=categories.Id where ItemId=regitems.id AND (SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=regitems.id AND deadstocktransaction.StoreId=stores.id)>0 group by stores.Name,regitems.Code,regitems.Name,uoms.Name,categories.Name,deadstocktransaction.ItemId,deadstocktransaction.StoreId order by stores.Name ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showDeadStockItemCon($itemId){
        $Regitem = DB::select('SELECT regitems.id,regitems.Type,regitems.Code,regitems.Name,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.DeadStockPrice,regitems.ActiveStatus FROM regitems LEFT JOIN categories on regitems.CategoryId=categories.id LEFT JOIN uoms on regitems.MeasurementId=uoms.id where regitems.id='.$itemId);
        return response()->json(['item_data' => $Regitem]);
    }

    public function updateSellingPrice(Request $request){
        $findid = $request->spitemid;
        $itm = Regitem::find($findid);
        $validator = Validator::make($request->all(), [
            'SellingPrice' => "nullable|gt:Cost,maxcosthid",
        ]);

        if ($validator->passes()) {
            $itm->DeadStockPrice = $request->input('SellingPrice');
            $itm->dsmaxcosteditable = $request->input('Cost');
            $itm->save();
            return Response::json(['success' => 1]);
        }
        else{
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function deadstocksale()
    {
        $customerSrc=DB::select('select * from customers where ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $store=DB::select('select * from stores where ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $itemSrcs=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
    
        return view('inventory.deadstocksale',['customerSrc'=>$customerSrc,'store'=>$store,'itemSrcs'=>$itemSrcs]);
    }
    
    public function deadstocksalelist(){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $salehol = DB::select('SELECT deadstocksale.id,deadstocksale.DocumentNumber,deadstocksale.Type,customers.CustomerCategory,CONCAT(strn.Name) AS Name,customers.Name AS CustomerName,customers.TinNumber,customers.VatType,customers.Witholding,deadstocksale.PaymentType,deadstocksale.VoucherType,deadstocksale.VoucherNumber,deadstocksale.CustomerMRC,deadstocksale.SubTotal,stores.Name as StoreName,strn.Name AS DestinationStore,deadstocksale.CreatedDate,deadstocksale.Status FROM deadstocksale INNER JOIN customers ON deadstocksale.CustomerId=customers.id INNER JOIN stores ON deadstocksale.StoreId=stores.id INNER JOIN stores AS strn ON deadstocksale.DestinationStore=strn.id');
        return datatables()->of($salehol)
        ->addIndexColumn()
        ->addColumn('action', function($data){    
            $user = Auth()->user(); 
            $unvoidvlink = '';
            $voidlink = '';
            $refundlink = '';
            $editlink = '';
            $vatlink = '';
            $witholdlink = '';
            $settingsval = DB::table('settings')->latest()->first();
            $fiscalyr = $settingsval->FiscalYear;
            $saleswithold = $settingsval->SalesWithHold;
            $vatdeduct = $settingsval->vatDeduct;
            
            if($data->Status == 'Void'){
                if($user->can('PullOut-Void'))
                {
                    $unvoidvlink= '<a class="dropdown-item saleunVoid" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="smallButton"  data-attr="" title="Delete Record">
                    <i class="fa fa-undo"></i><span> Undo Void</span>  
                    </a>';
                }
                $voidlink='';
                $editlink='';
            }

            if($data->Status == 'Pending/Removed'){
                if($user->can('PullOut-Edit')){
                    $editlink='<a class="dropdown-item saleeditProduct" onclick="editpullout('.$data->id.')" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'"  data-original-title="Edit" title="Edit Record"><i class="fa fa-edit"></i><span> Edit</span></a>';
                }
                if($user->can('PullOut-Void')){
                    $voidlink=' <a class="dropdown-item saleVoid" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="smallButton"  data-attr="" title="Delete Record">
                        <i class="fa fa-trash"></i><span> Void</span>  
                    </a>'; 
                }
                $unvoidvlink=''; 
            }

            if($data->Status == 'Confirmed/Removed'){
                if($user->can('Confirmed-PullOut-Edit'))
                {
                    $editlink='<a class="dropdown-item saleeditProduct" onclick="editpullout('.$data->id.')" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'"  data-original-title="Edit" title="Edit Record"><i class="fa fa-edit"></i><span> Edit</span></a>';
                } 
                if($user->can('PullOut-Void'))
                {
                    $voidlink=' <a class="dropdown-item saleVoid" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="smallButton"  data-attr="" title="Delete Record">
                    <i class="fa fa-trash"></i><span> Void</span>  
                    </a>'; 
                }
                $unvoidvlink=''; 
            }

            $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item saleinfoProductItemDs" onclick="saleinfoProductItemDs('.$data->id.')" data-id="'.$data->id.'" data-toggle="modal" id="smallButton" data-target="#MRCRegModal" title="show Hold Sales Info">
                        <i class="fa fa-info"></i><span> Info</span>  
                    </a>
                    
                    '.$editlink.'
                    '.$voidlink.'
                    '.$unvoidvlink.'
                    '.$refundlink.'
                    '.$vatlink.'
                     
                    <a class="dropdown-item dspoatt" href="javascript:void(0)" data-link="/dspo/'.$data->id.'"  data-id="'.$data->id.'" data-status="'.$data->Status.'" data-original-title="Edit" title="See attachment">
                    <i class="fa fa-file"></i><span> Print Doc</span></a>   
                </div>
            </div>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function deadshowSale($id){
        $insids=[];
        $sales=deadstocksale::FindorFail($id);
        $custid=$sales->CustomerId;
        $store=$sales->StoreId;
        $dstore=$sales->DestinationStore;
        $subTotal=$sales->SubTotal;
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $sales->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $Storeval=store::FindorFail($store);
        $storeName=$Storeval->Name;
        $DStoreval=store::FindorFail($dstore);
        $dsstoreName=$DStoreval->Name;
        $cust=customer::FindorFail($custid);
        $custname=$cust->Name;
        $custcode=$cust->Code;
        $custTinNumber=$cust->TinNumber;
        $custcategory=$cust->CustomerCategory;
        $total=$custname.$dsstoreName;
        $countitem = DB::table('deadstocksalesitems')->where('HeaderId', '=', $id)
            ->get();
        $getCountItem = $countitem->count();
        $itemidlists=deadstocksaleitem::where('HeaderId',$id)->orderBy('deadstocksalesitems.id','asc')->get(['ItemId']);
        foreach ($itemidlists as $itemidlists) {
            $insids[] = $itemidlists->ItemId;
        }
        $inds=implode(',',$insids);
        $data = deadstocksaleitem::join('deadstocksale', 'deadstocksalesitems.HeaderId', '=', 'deadstocksale.id')
            ->join('regitems', 'deadstocksalesitems.ItemId', '=', 'regitems.id')
            ->join('uoms', 'deadstocksalesitems.DefaultUOMId', '=', 'uoms.id')
            ->where('deadstocksalesitems.HeaderId', $id)
            ->orderBy('deadstocksalesitems.id','asc')
            ->get(['deadstocksale.*','deadstocksalesitems.*','deadstocksalesitems.Common AS recdetcommon','deadstocksalesitems.StoreId AS recdetstoreid',
            'deadstocksalesitems.RequireSerialNumber AS ReSerialNm','deadstocksalesitems.RequireExpireDate AS ReExpDate','regitems.Name AS ItemName','regitems.Code AS ItemCode','regitems.SKUNumber',
            'uoms.Name AS UomName']);

        $getallbalnces=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,deadstocktransaction.ItemId,(SELECT IF((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status IN ("Pending/Removed") and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status IN("Pending/Removed") and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)))) AS Balance,deadstocktransaction.StoreId FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id WHERE deadstocktransaction.ItemId IN ('.$inds.') AND deadstocktransaction.StoreId='.$store.' GROUP BY regitems.Name,deadstocktransaction.StoreId ORDER BY FIELD(regitems.id,'.$inds.')');

        return response()->json([
            'sales'=>$sales,
            'cname'=>$custname,
            'custcode'=>$custcode,
            'custTinNumber'=>$custTinNumber,
            'ccat'=>$custcategory,
            'countItem'=>$getCountItem,
            'storeName'=>$storeName,
            'dsstoreName'=>$dsstoreName,
            'total'=>$total,
            'receivingdt'=>$data,
            'bal'=>$getallbalnces,
            'curdate'=>$datetime,
        ]);
    }

    public function deadsalechildsalelist($id)
    {
        $salechild=DB::select('SELECT deadstocksalesitems.id,deadstocksale.Type,deadstocksalesitems.HeaderId,deadstocksalesitems.Dprice,regitems.Code,regitems.SKUNumber,deadstocksalesitems.ItemId,regitems.Name AS ItemName, uoms.Name AS UOM,deadstocksalesitems.Quantity,deadstocksalesitems.Dprice,deadstocksalesitems.UnitPrice,deadstocksalesitems.Discount,deadstocksalesitems.BeforeTaxPrice,deadstocksalesitems.TaxAmount,deadstocksalesitems.TotalPrice FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id INNER JOIN uoms ON deadstocksalesitems.NewUOMId=uoms.id where deadstocksalesitems.HeaderId='.$id);
        return datatables()->of($salechild)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {      
            $btn='';
            $btn =  $btn.' <a data-id="'.$data->id.'" data-uom="'.$data->UOM.'"  class="btn btn-icon btn-gradient-info btn-sm saleeditItem" data-toggle="modal" id="mediumButton"  style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            $btn = $btn.' <a data-id="'.$data->id.'"  data-hid="'.$data->HeaderId.'" class="btn btn-icon btn-gradient-danger btn-sm saledeleteItem"  data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';  
            return $btn;    
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    
    public function showItemInfodead($itemId,$storeId)
    {
        $ItemId=$itemId;
        $columnName="id";
        $Regitem=DB::select('SELECT regitems.id,regitems.MeasurementId,regitems.Type,regitems.Code,regitems.Name,regitems.DeadStockPrice,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.Maxcost,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus,regitems.wholeSellerMinAmount,regitems.dsmaxcost,regitems.dsmaxcosteditable FROM regitems INNER JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.id='.$itemId);
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        $getQuantity=DB::select('select (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity from deadstocktransaction where deadstocktransaction.StoreId='.$storeId.' and deadstocktransaction.ItemId='.$itemId.'');
        $getPenQuantity=DB::select('select COALESCE((sum(Quantity)),0) as PendingQuantity from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status="Pending/Removed" and deadstocksalesitems.StoreId='.$storeId.' and deadstocksalesitems.ItemId='.$itemId.'');
        return response()->json(['Regitem'=>$Regitem,'getQuantity'=>$getQuantity,'getPenQuantity'=>$getPenQuantity]);
    }

    public function saleUOMSdead($itemId)
    {
        $regitems = DB::table('regitems')->where('id', $itemId)->latest()->first();
        $uomid=$regitems->MeasurementId;
        $cnv=uom::find($uomid);
        $defuom=$cnv->Name;
        $conv=DB::select('SELECT t.id,t.FromUomID,w1.Name AS FromUnitName,t.ToUomID,w2.Name AS ToUnitName,t.Amount,t.ActiveStatus FROM conversions AS t JOIN uoms AS w1 on w1.id=t.FromUomID JOIN uoms AS w2 on w2.id=t.ToUomID WHERE t.FromUomID='.$uomid.' AND t.ActiveStatus="Active"');
        
        return response()->json(['sid'=>$conv,'defuom'=>$defuom,'uomid'=>$uomid]);
    }
    
    public function deadstocksavesale(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $hprefix=$settings->DeadStockSalesPrefix;
        $hnumber=$settings->DeadStockSalesCount;
        $fiscalyr=$settings->FiscalYear;
        $suffixdoc=$fiscalyr-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $hnumber);
        $dnumber=$hprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        $user=Auth()->user()->username;
        $type=$request->SalesType;
        $destStore=$request->DestinationStore;
        $ref=$request->VoucherNumber;
        $cus=$request->customer;
        $hiddenstr=null;
        $rectransactiontype="PullOut";
        $thisdate = Carbon::today()->toDateString();
        $cval="0";
        $upval="0";
        $statusval=null;
        $headeridsval=null;
        $insids=[];
        $dynamictblitem=[];
        $detailids=[];
        $unavailableitems=[];
        $upunavailableitems=[];
        $statusvalues=['PullOut','Undo-Void'];
        $unavitems="";
        $getItemLists="";
        $getremovedItemLists="";
        $documentnumbers="";
        $confirmdates="";
        $fiscalyearval="";
        $singleqnt="";
        $singlenonqnt="";
        $tempval=[];
        $tempvalnew=[];
        $tempcnt=0;
        $tempcntitemid=[];
        $tempnoncnt=0;
        $tempnoncntitemid=[];
        $unavtempitems="";
        $unavnontempitems="";
        $dstypes="";
        $unavailableitemsmn=[];
        $cvalmn="0";
        $tempcntitemidmn=[];
        $tempcntmn="0";
        $unavitemsmn="";
        $unavtempitemsmn="";
        $upunavailableitemsmn=[];
        $upvalmn="0";
        $tempnoncntitemidmn=[];
        $tempnoncntmn="0";
        $unavnontempitemsmn="";
        $upunavitemsmn="";
        if($request->DestinationStore==null)
        {
            $destionstore='1';
        }
        if($request->DestinationStore!=null)
        {
            $destionstore=$request->DestinationStore;
        }
        if($type=="Internal"||$type=="Disposal")
        {
            $paymenttypes=$request->paymentType;
        }
        if($type=="External")
        {
            $paymenttypes=$request->paymentType;
        }
        if($cus==null)
        {
            $customers='1';
        }
        if($cus!=null)
        {
            $customers=$request->customer;
        }
        
        if($type=="External")
        {
            $rules=array(
                'row.*.ItemId' => 'required',
                'row.*.uom' => 'required',
                'row.*.Quantity' => 'required|gt:0',
                'row.*.UnitPrice' => 'required|gt:0',
                'row.*.TotalPrice' => 'required|gt:0',
            );
        }

        else if($type=="Internal"||$type=="Disposal")
        {
            $rules=array(
                'row.*.ItemId' => 'required',
                'row.*.uom' => 'required',
                'row.*.Quantity' => 'required|gt:0',
                'row.*.TotalPrice' => 'required|gt:0',
            );
        }  
    
            $v2= Validator::make($request->all(), $rules);
            if($request->salesidval!=null)
            {
                if($request->row==null){
                    return Response::json(['emptyerror'=>"error"]);
                }
                else{
                    $itemidlists=deadstocksaleitem::where('HeaderId', $request->salesidval)->get(['ItemId']);
                    foreach ($itemidlists as $itemidlists) {
                        $insids[] = $itemidlists->ItemId;
                    }
                    $recstatus=deadstocksale::where('id', $request->salesidval)->get(['Status','DocumentNumber','ConfirmedDate','Type','StoreId']);
                    foreach ($recstatus as $recstatus) {
                        $statusval = $recstatus->Status;
                        $documentnumbers = $recstatus->DocumentNumber;
                        $confirmdates = $recstatus->ConfirmedDate;
                        $fiscalyearval = "0";
                        $dstypes= $recstatus->Type;
                        $hiddenstr= $recstatus->StoreId;
                    }
                    if($statusval=="Confirmed/Removed"){
                        $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS dspotemp'.$userid.''));
                        $creatingtemptables=DB::statement('CREATE TEMPORARY TABLE dspotemp'.$userid.' SELECT deadstocktransaction.id,deadstocktransaction.HeaderId,deadstocktransaction.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,deadstocktransaction.StoreId,uoms.Name AS UOM,deadstocktransaction.StockIn,deadstocktransaction.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY deadstocktransaction.ItemId,deadstocktransaction.StoreId ORDER BY deadstocktransaction.id ASC)) AS AvailableQuantity,deadstocktransaction.TransactionsType,deadstocktransaction.FiscalYear FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id INNER JOIN stores ON deadstocktransaction.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE deadstocktransaction.ItemId IN(SELECT deadstocksalesitems.ItemId FROM deadstocksalesitems WHERE deadstocksalesitems.HeaderId='.$request->salesidval.')');
                        foreach ($request->row as $key => $value){
                            $totalavailable="0";
                            $updatevalue="0";
                            $totalresult="0";
                            $totalresval="0";
                            $newquantity="0";
                            $itemids=$value['ItemId'];
                            $dynamictblitem[]=$value['ItemId'];
                            $dynamicqnt=$value['Quantity'];
                            $storeids=$value['StoreId'];
                            if($dynamicqnt==null){
                                $newquantity="0";
                            }
                            else if($dynamicqnt!=null){
                                $newquantity=$dynamicqnt;
                            }
                            // $getavailableqnt=DB::select('SELECT COALESCE(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)),0) AS TotalBalance FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemids.' AND deadstocktransaction.StoreId='.$hiddenstr.'');
                            // foreach($getavailableqnt as $row)
                            // {
                            //     $totalavailable=$row->TotalBalance;
                            // }
                            // $getrecevingdetail=deadstocksaleitem::where('HeaderId', $request->salesidval)->where('ItemId',$itemids)->get(['Quantity']);
                            // foreach ($getrecevingdetail as $getrecevingdetail) {
                            //     $updatevalue = $getrecevingdetail->Quantity;
                            // }
                            // $totalresult=$totalavailable-$updatevalue;
                            // if($hiddenstr!=$request->store){
                            //     $newquantity="0";//check whether the new store and old(DB) store is different
                            // }
                            // if($hiddenstr==$storeids){
                            //     $totalresval=$totalresult+$newquantity;
                            // }
                            // $totalresvals=(float)$totalresval;
                            // if($totalresvals<0){
                            //     $unavailableitems[]=$itemids;
                            //     $cval+=1;
                            // } 
                            
                            $updatestockingquantity=DB::select('update dspotemp'.$userid.' set StockOut='.$newquantity.',StoreId='.$request->store.' where HeaderId='.$request->salesidval.' AND TransactionsType="PullOut" AND ItemId='.$itemids.'');
                            $gettemptable=DB::select('SELECT dspotemp'.$userid.'.id,dspotemp'.$userid.'.HeaderId,dspotemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,dspotemp'.$userid.'.StoreId,uoms.Name AS UOM,dspotemp'.$userid.'.StockIn,dspotemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY dspotemp'.$userid.'.ItemId,dspotemp'.$userid.'.StoreId ORDER BY dspotemp'.$userid.'.id ASC)) AS AvailableQuantity,dspotemp'.$userid.'.TransactionsType FROM dspotemp'.$userid.' INNER JOIN regitems ON dspotemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON dspotemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE dspotemp'.$userid.'.ItemId='.$itemids.' AND dspotemp'.$userid.'.StoreId='.$request->store.'');
                            foreach($gettemptable as $row)
                            {
                                $tempvalnew[]=$row->AvailableQuantity;
                                $singleqnt=$row->AvailableQuantity;
                                if($singleqnt<0){
                                    $tempcntitemid[]=$row->ItemId;
                                    $tempcnt+=1;
                                } 
                            }
                            if($singleqnt<0){
                                $unavailableitems[]=$itemids;
                                $cval+=1;
                            } 
                        }

                        // foreach($insids as $val) {
                        //     $untotalavailable="0";
                        //     $unupdatevalue="0";
                        //     $untotalresult="0";
                        //     $untotalresval="0";
                        //     if(!in_array($val,$dynamictblitem)){
                        //         $ds=implode(',',$dynamictblitem);
                        //         $inds=implode(',',$insids);
                        //         $getavailableqnt=DB::select('SELECT COALESCE(SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)),0) AS TotalBalance FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$val.' AND deadstocktransaction.StoreId='.$hiddenstr.'');
                        //         foreach($getavailableqnt as $row)
                        //         {
                        //             $untotalavailable=$row->TotalBalance;
                        //         }
                        //         $getrecevingdetail=deadstocksaleitem::where('HeaderId', $request->salesidval)->where('ItemId',$val)->get(['Quantity']);
                        //         foreach ($getrecevingdetail as $getrecevingdetail) {
                        //             $unupdatevalue = $getrecevingdetail->Quantity;
                        //         }
                        //         $untotalresult=$untotalavailable-$unupdatevalue;
                        //         $untotalresval=$untotalresult+0;
                        //         $untotalresvals=(float)$untotalresval;
                        //         if($untotalresvals<0){
                        //             $upunavailableitems[]=$val;
                        //             $upval+=1;
                        //         }
                        //         $updatestockingquantity=DB::select('update dspotemp'.$userid.' set StockOut=0 where HeaderId='.$request->salesidval.' AND TransactionsType="PullOut" AND ItemId='.$itemids.'');
                        //         $gettemptable=DB::select('SELECT dspotemp'.$userid.'.id,dspotemp'.$userid.'.HeaderId,dspotemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,dspotemp'.$userid.'.StoreId,uoms.Name AS UOM,dspotemp'.$userid.'.StockIn,dspotemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY dspotemp'.$userid.'.ItemId,dspotemp'.$userid.'.StoreId ORDER BY dspotemp'.$userid.'.id ASC)) AS AvailableQuantity,dspotemp'.$userid.'.TransactionsType FROM dspotemp'.$userid.' INNER JOIN regitems ON dspotemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON dspotemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE dspotemp'.$userid.'.ItemId='.$itemids.'');
                        //         foreach($gettemptable as $row)
                        //         {
                        //             $tempval[]=$row->AvailableQuantity;
                        //             $singlenonqnt=$row->AvailableQuantity;
                        //             if($singlenonqnt<0){
                        //                 $tempnoncntitemid[]=$row->ItemId;
                        //                 $tempnoncnt+=1;
                        //             }
                        //         } 
                        //     } 
                        // }
                        $unavitems=implode(',',$unavailableitems);
                        //$upunavitems=implode(',',$upunavailableitems);
                        $unavtempitems=implode(',',$tempcntitemid);
                        //$unavnontempitems=implode(',',$tempnoncntitemid);
                    }
                    $validator = Validator::make($request->all(), [
                        'customer' => ['required_if:SalesType,External'],
                        'paymentType' => ['required_if:SalesType,External'],
                        //'ReferenceNumber' => ['required_if:SalesType,Internal'],
                        'DestinationStore' => ['required_if:SalesType,Internal'],
                        'date' => ['required','before:now'],
                        //'Memo' => ['required'],
                        'VoucherNumber' => ['nullable',Rule::unique('deadstocksale')->where(function ($query) use($customers,$ref) {
                            return $query->where('VoucherNumber', $ref)
                                ->where('CustomerId', $customers);
                            })->ignore($request->salesidval)],
                        ]);

                    $cvals=(float)$cval;
                    $upvals=(float)$upval;
                    $tempcnts=(float)$tempcnt;
                    $tempnoncnts=(float)$tempnoncnt;
                    if($cvals>=1||$upvals>=1){
                        $totalvals=$cvals+$upvals;
                        $selecteditems=null;
                        $removeditemsselected=null;
                        if($unavitems!=null){
                            $selecteditems=$unavitems;
                        }
                        if($unavitems==null){
                            $selecteditems="0";
                        }
                        if($upunavitems!=null){
                            $removeditemsselected=$upunavitems;
                        }
                        if($upunavitems==null){
                            $removeditemsselected="0";
                        }
                        $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                        $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                        return Response::json(['qnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                    }
                    else if($tempcnts>=1||$tempnoncnts>=1){
                        $totalvals=$tempcnts+$tempnoncnts;
                        $selecteditems=null;
                        $removeditemsselected=null;
                        if($unavtempitems!=null){
                            $selecteditems=$unavtempitems;
                        }
                        if($unavtempitems==null){
                            $selecteditems="0";
                        }
                        if($unavnontempitems!=null){
                            $removeditemsselected=$unavnontempitems;
                        }
                        if($unavnontempitems==null){
                            $removeditemsselected="0";
                        }
                        $getItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS ItemName FROM regitems WHERE regitems.id IN('.$selecteditems.')');
                        $getremovedItemLists=DB::select('SELECT CONCAT(regitems.Code,"	,	",regitems.Name,"	,	",regitems.SKUNumber) AS RemovedItemName FROM regitems WHERE regitems.id IN('.$removeditemsselected.')');
                        return Response::json(['detqnterror'=>"error",'countedval'=>$totalvals,'countItems'=>$getItemLists,'countremitems'=>$getremovedItemLists]);
                    }
                    else if($cval==0 && $upval==0 && $tempcnts==0 && $tempnoncnts==0){
                        if($validator->passes()&& $v2->passes() && ($request->row!=null))
                        {
                            try
                            {
                                $deadstocksale=deadstocksale::updateOrCreate(['id'=>$request->salesidval], [
                                    'Type' => trim($request->SalesType),
                                    'CustomerId' => trim($customers),
                                    'PaymentType' => trim($paymenttypes),
                                    'VoucherNumber' => trim($request->VoucherNumber),
                                    'CreatedDate' => trim($request->date),
                                    'StoreId' => trim($request->store),
                                    'DestinationStore' => trim($destionstore),
                                    'Common'=> trim($request->salecounti),
                                    'Memo'=> trim($request->Memo),  
                                    'SubTotal'=> trim($request->subtotali),
                                    'Username'=>$user,
                                ]);
                                foreach ($request->row as $key => $value) 
                                {
                                    $itemname=$value['ItemId'];
                                    $quantity=$value['Quantity'];
                                    $unitprice=$value['UnitPrice'];
                                    $totalprice=$value['TotalPrice'];
                                    $storeid=$request->store;
                                    $convertedquantity=$value['ConvertedQuantity'];
                                    $conversionamount=$value['ConversionAmount'];
                                    $newuomid=$value['NewUOMId'];
                                    $defaultuomid=$value['DefaultUOMId'];
                                    $common=$value['Common'];
                                    $transactiontype=$value['TransactionType'];
                                    $itemtype=$value['ItemType'];

                                    if(in_array($itemname,$insids)){
                                        $updaterecitems=deadstocksaleitem::where('HeaderId',$request->salesidval)->where('ItemId',$itemname)->update( ['Quantity'=>$quantity,'UnitPrice'=>$unitprice,'TotalPrice'=>$totalprice,'StoreId'=>$storeid,'ConvertedQuantity'=>$convertedquantity,'ConversionAmount'=>$conversionamount,'NewUOMId'=>$newuomid,'DefaultUOMId'=>$defaultuomid,'Common'=>$common,'TransactionType'=>$transactiontype,'ItemType'=>$itemtype]);
                                        if($statusval=="Confirmed/Removed"){
                                            $updatetransctions=dstransactions::where('HeaderId',$request->salesidval)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->whereIn('TransactionsType',$statusvalues)->update(['StockOut'=>$quantity,'UnitPrice'=>$unitprice,'TotalPrice'=>$totalprice,'StoreId'=>$storeid,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                            $updatetransctionsvd=dstransactions::where('HeaderId',$request->salesidval)->where('ItemId',$itemname)->where('TransactionType',$rectransactiontype)->where('TransactionsType',"Void")->update(['StockIn'=>$quantity,'UnitCost'=>$unitprice,'TotalCost'=>$totalprice,'StoreId'=>$storeid,'ItemType'=>$itemtype,'DocumentNumber'=>$documentnumbers,'Date'=>$confirmdates]);
                                        }
                                    }
                                    if(!in_array($itemname,$insids)){
                                        $recdt=new deadstocksaleitem;
                                        $recdt->HeaderId=$request->salesidval;
                                        $recdt->ItemId=$itemname;
                                        $recdt->Quantity=$quantity;
                                        $recdt->UnitPrice=$unitprice;
                                        $recdt->TotalPrice=$totalprice;
                                        $recdt->Common=$common;
                                        $recdt->TransactionType="PullOut";
                                        $recdt->ItemType=$itemtype;
                                        $recdt->StoreId=$storeid;
                                        $recdt->DefaultUOMId=$defaultuomid;
                                        $recdt->NewUOMId=$newuomid;
                                        $recdt->ConversionAmount=$conversionamount;
                                        $recdt->ConvertedQuantity=$convertedquantity;
                                        $recdt->save();
                                        if($statusval=="Confirmed/Removed"){
                                            $tran=new dstransactions;
                                            $tran->HeaderId=$request->salesidval;
                                            $tran->ItemId=$itemname;
                                            $tran->StockOut=$quantity;
                                            $tran->UnitPrice=$unitprice;
                                            $tran->TotalPrice=$totalprice;
                                            $tran->StoreId=$storeid;
                                            $tran->IsVoid=0;
                                            $tran->TransactionType="PullOut";
                                            $tran->TransactionsType="PullOut";
                                            $tran->ItemType=$itemtype;
                                            $tran->DocumentNumber=$documentnumbers;
                                            $tran->Date=$confirmdates;
                                            $tran->save();
                                        }
                                    }
                                    $detailids[]=$itemname;
                                }
                                // $comn=$request->salecounti;
                                // if($comn!=null)
                                // {
                                //     $saleshead = DB::table('deadstocksale')->where('Common',$comn)->latest()->first();
                                //     $headerid=$saleshead->id;
                                //     $storeId=$saleshead->StoreId;                            
                                //     $updn=DB::select('update deadstocksalesitems set HeaderId='.$headerid.',StoreId='.$storeId.' where Common='.$comn.'');                        
                                // }
                                deadstocksaleitem::where('HeaderId',$request->salesidval)->whereNotIn('ItemId',$detailids)->delete();
                                dstransactions::where('HeaderId',$request->salesidval)->where('TransactionType',$rectransactiontype)->whereNotIn('ItemId',$detailids)->delete();
                                if($statusval=="Confirmed/Removed"){
                                    $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE dspotemp'.$userid.''));
                                }
                                return Response::json(['success' => '1','ref'=> $ref]);
                            }
                            catch(Exception $e)
                            {
                                return Response::json(['dberrors' =>  $e->getMessage()]);
                            }
                        }
                    }
                }
            }
            if($request->salesidval==null)
            {
                $validator = Validator::make($request->all(), [
                    $dnumber => ['unique:deadstocksale,DocumentNumber'],
                    'customer' => ['required_if:SalesType,External'],
                    'paymentType' => ['required_if:SalesType,External'],
                    //'ReferenceNumber' => ['required_if:SalesType,Internal'],
                    'DestinationStore' => ['required_if:SalesType,Internal'],
                    'date' => ['required','before:now'],
                    'store' => ['required'],
                    //'Memo' => ['required'],
                    'VoucherNumber' => ['nullable',Rule::unique('deadstocksale')->where(function ($query) use($customers,$ref) {
                        return $query->where('VoucherNumber', $ref)
                            ->where('CustomerId', $customers);
                        })]
                ]);
                
                if($validator->passes() && $v2->passes()) 
                {
                    try
                    {
                        $deadstocksale=deadstocksale::updateOrCreate(['id' =>$request->salesidval], [
                            'DocumentNumber' => $dnumber,
                            'Type' => trim($request->SalesType),
                            'CustomerId' => trim($customers),
                            'PaymentType' => trim($paymenttypes),
                            'VoucherNumber' => trim($request->VoucherNumber),
                            'CreatedDate' => trim($request->date),
                            'StoreId' => trim($request->store),
                            'DestinationStore' => trim($destionstore),
                            'Common'=> trim($request->commonVal),
                            'Memo'=> trim($request->Memo),
                            'SubTotal'=> trim($request->subtotali),
                            'Status'=>'Pending/Removed', 
                            'Username'=>$user,
                        ]);
                        foreach ($request->row as $key => $value) 
                        {
                            $itemname=$value['ItemId'];
                            $quantity=$value['Quantity'];
                            $unitprice=$value['UnitPrice'];
                            $totalprice=$value['TotalPrice'];
                            $storeid=$request->store;
                            $convertedquantity=$value['ConvertedQuantity'];
                            $conversionamount=$value['ConversionAmount'];
                            $newuomid=$value['NewUOMId'];
                            $defaultuomid=$value['DefaultUOMId'];
                            $common=$value['Common'];
                            $transactiontype=$value['TransactionType'];
                            $itemtype=$value['ItemType'];
                            $deadstocksale->items()->attach($itemname,
                            ['Quantity'=>$quantity,'UnitPrice'=>$unitprice,'TotalPrice'=>$totalprice,'StoreId'=>$storeid,'ConvertedQuantity'=>$convertedquantity,
                            'ConversionAmount'=>$conversionamount,'NewUOMId'=>$newuomid,'DefaultUOMId'=>$defaultuomid,'Common'=>$common,'TransactionType'=>$transactiontype,
                            'ItemType'=>$itemtype]);
                        }
                        $comn=$request->commonVal;
                            // if($comn!=null)
                            // {
                            //     $saleshead = DB::table('deadstocksale')->where('Username',$user)->latest()->first();
                            //     $headerid=$saleshead->id;
                            //     $storeId=$saleshead->StoreId;   
    
                            //     $updn=DB::select('update deadstocksalesitems set StoreId='.$storeId.' where HeaderId='.$headerid.'');                        
                            // }
                        $updn=DB::select('update settings set DeadStockSalesCount=DeadStockSalesCount+1 where id=1');
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
                return response()->json(['errorv2'  => $v2->errors()->all()]);
            }  
    }
    
    public function getConversionAmount($id,$nid)
    {
        $conversion = DB::table('conversions')->where('FromUomID', $id)->where('ToUomID', $nid)->latest()->first();
        $amnt=$conversion->Amount;
        return response()->json(['sid'=>$amnt]);
    }

    public function deadshowItemInfo($itemId,$storeId)
    {
        $ItemId=$itemId;
        $columnName="id";
        $Regitem=DB::select('SELECT regitems.id,regitems.MeasurementId,regitems.Type,regitems.Code,regitems.Name,regitems.DeadStockPrice,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.Maxcost,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus,regitems.wholeSellerMinAmount FROM regitems INNER JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.id='.$itemId);
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $getQuantity=DB::select('select COALESCE((sum(StockIn)),0)-COALESCE((sum(StockOut)),0) as AvailableQuantity from deadstocktransaction where deadstocktransaction.StoreId='.$storeId.' and deadstocktransaction.ItemId='.$itemId.'');
        $getPenQuantity=DB::select('select COALESCE((sum(Quantity)),0) as PendingQuantity from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status="Pending/Removed" and deadstocksalesitems.StoreId='.$storeId.' and deadstocksalesitems.ItemId='.$itemId.'');
        return response()->json(['Regitem'=>$Regitem,'getQuantity'=>$getQuantity,'getPenQuantity'=>$getPenQuantity]);
    }
    
    public function deadsavesaleitem(Request $request)
    {
        $user=Auth()->user()->username;
        $headerid=$request->HeaderId;
        $item=$request->ItemName;
        $findid=$request->itemid;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $storeid=$request->storeId;
        $transactiontype="Sales";
        $validator = Validator::make($request->all(), [
            'ItemName' => ['required',],
            'Quantity' =>"required|numeric|min:1|gt:0",
                'UnitPrice' =>"required|numeric|gt:0",
            ]);

            if($validator->passes())
            {
                try
                {
                $data=deadstocksaleitem::updateOrCreate(['id' => $request->itemid], [
                    'HeaderId'=>trim($request->HeaderId),
                    'ItemId' => trim($request->ItemName),
                    'Quantity' => trim($request->Quantity),
                    'UnitPrice' =>trim($request->UnitPrice),
                    'TotalPrice' => trim($request->TotalPrice),
                    'TransactionType'=>'PullOut',
                    'ItemType'=>'Goods',   
                    'ConvertedQuantity' => trim($request->convertedqi),
                    'ConversionAmount' => trim($request->convertedamnti),
                    'NewUOMId' => trim($request->newuomi),
                    'DefaultUOMId' => trim($request->defaultuomi),
                    'StoreId' => trim($request->storeId),
                    'Common'=>trim($request->commonId), 
                    ]);

                    if($findid==null)
                    {
                    $receiving = DB::table('deadstocksalesitems')->where('HeaderId', $headerid)->latest()->first();
                    $recid=$receiving->id;
                    $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                    ['HeaderId', 'ItemId', 'StockOut','UnitPrice','TotalPrice','StoreId','TransactionType','ItemType' ],
                    function ($query)use($recid) {
                    $query
                    ->select(['HeaderId', 'ItemId', 'Quantity','UnitPrice','TotalPrice','StoreId','TransactionType','ItemType']) // ..., columnN
                    ->from('deadstocksalesitems')->where('id', '=',$recid);
                    }
                    );
                    $updatetrans=DB::table('deadstocktransaction')
                    ->where('HeaderId', $headerid)
                    ->update(['FiscalYear'=>$fiscalyr,'Date'=>Carbon::now()]);
                }

                if($findid!=null)
                {
                    DB::table('deadstocktransaction')
                    ->where('HeaderId',$headerid)
                    ->where('StoreId',$storeid)
                    ->where('ItemId',$item)
                    ->where('TransactionType',$transactiontype)
                    ->update(['StockOut'=>$request->Quantity,'UnitPrice'=>$request->UnitPrice,'TotalPrice'=>$request->TotalPrice]);
                }
                    $pricing = DB::table('deadstocksalesitems')
                    ->select(DB::raw('TRUNCATE(SUM(TotalPrice),2) as TotalPrice'))
                    ->where('HeaderId', '=', $headerid)
                    ->get();

                    $updprice=DB::select('update deadstocksale set SubTotal=(SELECT TRUNCATE(SUM(TotalPrice),2) FROM deadstocksalesitems WHERE HeaderId='.$headerid.')
                    where id='.$headerid.'');
                    $countitem = DB::table('deadstocksalesitems')->where('HeaderId', '=', $headerid)->get();
                    $getCountItem = $countitem->count();
                    return Response::json(['success' => 'Sale item saved','Totalcount'=>$getCountItem,'PricingVal'=>$pricing]);
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
    
    public function deadsavesaleitempen(Request $request)
    {
        $user=Auth()->user()->username;
        $headerid=$request->HeaderId;
        $item=$request->ItemName;
        $findid=$request->itemid;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $storeid=$request->storeId;
        $transactiontype="PullOut";
        $validator = Validator::make($request->all(), [
            'ItemName' => ['required',],
            'Quantity' =>"required|numeric|min:1|gt:0",
            'UnitPrice' =>"required|numeric|gt:0",
            ]);

            if($validator->passes())
            {
                try
                {
                    $data=deadstocksaleitem::updateOrCreate(['id' => $request->itemid], [
                    'HeaderId'=>trim($request->HeaderId),
                    'ItemId' => trim($request->ItemName),
                    'Quantity' => trim($request->Quantity),
                    'UnitPrice' =>trim($request->UnitPrice),
                    'TotalPrice' => trim($request->TotalPrice),
                    'TransactionType'=>'PullOut',
                    'ItemType'=>'Goods',   
                    'ConvertedQuantity' => trim($request->convertedqi),
                    'ConversionAmount' => trim($request->convertedamnti),
                    'NewUOMId' => trim($request->newuomi),
                    'DefaultUOMId' => trim($request->defaultuomi),
                    'StoreId' => trim($request->storeId),
                    'Common'=>trim($request->commonId), 
                    ]);
                    $pricing = DB::table('deadstocksalesitems')
                    ->select(DB::raw('TRUNCATE(SUM(TotalPrice),2) as TotalPrice'))
                    ->where('HeaderId', '=', $headerid)
                    ->get();

                    $updprice=DB::select('update deadstocksale set SubTotal=(SELECT TRUNCATE(SUM(TotalPrice),2) FROM deadstocksalesitems WHERE HeaderId='.$headerid.') where id='.$headerid);
                    $countitem = DB::table('deadstocksalesitems')->where('HeaderId', '=', $headerid)->get();
                    $getCountItem = $countitem->count();
                    return Response::json(['success' => 'Sale item saved','Totalcount'=>$getCountItem,'PricingVal'=>$pricing,'totalprice'=>$headerid]);
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

         public function deadshowsaleItem($id)
        {
            //$salholdite=salesitem::FindorFail($id);
            $salholdite = DB::table('deadstocksalesitems')->where('id', $id)->first();
            
            return response()->json([
                'saleholditem'=>$salholdite,
               
            ]);
    
        }
    
        public function deadsaleholddelete(Request $request,$id)
        {
            $transactiontype="PullOut";
            $headerid=$request->hid;
            $item=deadstocksaleitem::FindOrFail($id);
            $itemid=$item->ItemId;
       
           $delete=DB::table('deadstocksalesitems')->where('id', $id)->delete();
           $removeTransaction=DB::table('deadstocktransaction')->where('TransactionType', $transactiontype)
          ->where('ItemId', $itemid)
          ->where('HeaderId', $headerid)
          ->delete();
    
    
          $pricing = DB::table('deadstocksalesitems')
          ->select(DB::raw('TRUNCATE(SUM(TotalPrice),2) as TotalPrice'))
          ->where('HeaderId', '=', $headerid)
          ->get();
    
                      $updprice=DB::select('update deadstocksale set SubTotal=(SELECT TRUNCATE(SUM(TotalPrice),2) FROM deadstocksalesitems WHERE HeaderId='.$headerid.') where id='.$headerid);
    
                        $countitem = DB::table('deadstocksalesitems')->where('HeaderId', '=', $headerid)->get();
                        $getCountItem = $countitem->count();
                
        
    
           
                        return Response::json(['success' => 'Sale item removed','Totalcount'=>$getCountItem,'PricingVal'=>$pricing]);
    
        }



        public function deadcheckedsale(Request $request,$id)
        {
            $varchecked=$request->checkedst;
            $currentstatus=$request->currentstatus;
            $VoucherNumber=$request->undoVoucherNumber;
            $getoldstat=deadstocksale::FindOrFail($id);           
            $oldStatus=$getoldstat->StatusOld;
            $status=$getoldstat->Status;
            $storeID=$getoldstat->StoreId;
            $deadstockDocnumber=$getoldstat->DocumentNumber;
            $settingsval = DB::table('settings')->latest()->first();
            $fiscalyr=$settingsval->FiscalYear;
            $Items = DB::table('deadstocksalesitems')->where('HeaderId', '=', $id)->get();

            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;

            $transactiontype='PullOut';
            $transactionVoid='Void';
                if($varchecked=='Void')
                {
                    $validator = Validator::make($request->all(), [
                        'PulloutReason'=>"required",
                    ]);
                    if ($validator->passes()) 
                    {
                        
                        if($status=="Confirmed/Removed"){
                            $transactiondata=DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,StoreId,TransactionType,ItemType,RetailerPrice,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitPrice,TotalPrice,'.$storeID.',"'.$transactiontype.'",ItemType,UnitPrice,"'.$deadstockDocnumber.'","Void","'.Carbon::today()->toDateString().'" from deadstocksalesitems where deadstocksalesitems.HeaderId='.$id);
                            // $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                            // ['HeaderId', 'ItemId', 'StockOut','UnitPrice','TotalPrice','StoreId','TransactionType','ItemType'],
                            // function ($query)use($id) {
                            // $query
                            //     ->select(['HeaderId', 'ItemId', 'Quantity','UnitPrice','TotalPrice','StoreId','TransactionType','ItemType']) // ..., columnN
                            //     ->from('deadstocksalesitems')->where('HeaderId', '=',$id);
                            //     }
                            //     );
                            //     $updatetrans=DB::table('deadstocktransaction')
                            //     ->where('HeaderId', $id)
                            //     ->update(['FiscalYear'=>$fiscalyr,'Date'=>Carbon::today()->toDateString()]);
                        }
                        // foreach($Items as $items)
                        // {
                        //     $itemid=$items->ItemId;
                        //     $removeTransaction=DB::table('deadstocktransaction')
                        //     ->where('HeaderId', $id)
                        //     ->where('TransactionType', $transactiontype)
                        //     ->where('TransactionsType', $transactiontype)
                        //     ->delete();
                        // }
                        $today=Carbon::today()->toDateString();
                        $updatestatus= DB::table('deadstocksale')->where('id', $id) ->update(['Status' => $varchecked,'StatusOld'=>$status,'VoidReason'=>$request->PulloutReason,'VoidedBy'=>$user,'VoidDate'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A')]);                  
                        return Response::json(['success' => '1']);
                    }    
                    else
                    {
                        return Response::json(['errors' => $validator->errors()]);
                    }
                }
             

            else if($varchecked=='unVoid')
            {
                $transactiontype='PullOut';
                $transactionVoid='Undo-Void';

                $validator = Validator::make($request->all(), [
                    'undoVoucherNumber' => ['required'],
                ]);
                
                if ($transactiontype=="PullOut")
                {
                    try
                    {
                        if($oldStatus=="Confirmed/Removed")
                        {
                            $transactiondata=DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockOut,UnitPrice,TotalPrice,StoreId,TransactionType,ItemType,RetailerPrice,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitPrice,TotalPrice,'.$storeID.',"'.$transactiontype.'",ItemType,UnitPrice,"'.$deadstockDocnumber.'","Undo-Void","'.Carbon::today()->toDateString().'" from deadstocksalesitems where deadstocksalesitems.HeaderId='.$id);
                            // $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                            // ['HeaderId', 'ItemId', 'StockOut','UnitPrice','TotalPrice','StoreId','TransactionType','ItemType'],
                            // function ($query)use($id) {
                            // $query
                            //     ->select(['HeaderId', 'ItemId', 'Quantity','UnitPrice','TotalPrice','StoreId','TransactionType','ItemType']) // ..., columnN
                            //     ->from('deadstocksalesitems')->where('HeaderId', '=',$id);
                            //     }
                            //     );
                            //     $updatetrans=DB::table('deadstocktransaction')
                            //     ->where('HeaderId', $id)
                            //     ->update(['FiscalYear'=>$fiscalyr,'Date'=>Carbon::today()->toDateString()]);
                        }
                        $today=Carbon::today()->toDateString();
                        $updatestatus= DB::table('deadstocksale')->where('id', $id) ->update(['Status' => $oldStatus,'unVoidBy'=>$user,'unVoidDate'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A')]);                
                        return Response::json(['success' => 'Undo confirmed']);
                    }
                    catch(Exception $e)
                        {
                            return Response::json(['dberrors' =>  $e->getMessage()]);
                        }

                   
                }
                else
                {
                    return Response::json(['errors' => $validator->errors()]); 
                }

             }


        }


        public function confirmPullOut(Request $request)
        {
            $id=$request->confirmrecid;
            $getoldstat=deadstocksale::find($id);
            $oldStatus=$getoldstat->OldStatus;
            $storeID=$getoldstat->StoreId;
            $type=$getoldstat->Type;
            $docnum=$getoldstat->DocumentNumber;
            $settingsval = DB::table('settings')->latest()->first();
            $fiscalyr=$settingsval->FiscalYear;
            $user=Auth()->user()->username;
            $userid=Auth()->user()->id;

            $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM deadstocksalesitems AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$id.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trs.ItemId AND deadstocktransaction.StoreId='.$storeID.'),0)-trs.Quantity)<0');
            foreach($getApprovedQuantity as $row)
            {
                    $avaq=$row->ApprovedItems;
            }
            $avaqp = (float)$avaq;
            if($avaqp>=1)
            {
                $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trn.ItemId AND deadstocktransaction.StoreId='.$storeID.') AS AvailableQuantity FROM deadstocksalesitems AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$id.' AND 
                (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trn.ItemId AND deadstocktransaction.StoreId='.$storeID.'),0)-trs.Quantity)<0');
                return Response::json(['valerror' =>  "error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);
            }
            else
            {
                if($type=="Internal")
                {
                    $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                    ['HeaderId', 'ItemId', 'StockOut','UnitPrice','TotalPrice','StoreId','TransactionType','TransactionsType','ItemType'],
                        function ($query)use($id) {
                        $query
                            ->select(['HeaderId', 'ItemId', 'Quantity','UnitPrice','TotalPrice','StoreId','TransactionType','TransactionType','ItemType']) // ..., columnN
                            ->from('deadstocksalesitems')->where('HeaderId', '=',$id);
                        }
                    );
                    $updatetrans=DB::table('deadstocktransaction')
                    ->where('HeaderId', $id)
                    ->update(['DocumentNumber'=>$docnum,'FiscalYear'=>$fiscalyr,'Date'=>Carbon::today()->toDateString()]);

                    $updatestatus= DB::table('deadstocksale')
                    ->where('id', $id) ->update(['Status' => 'Confirmed/Removed','ConfirmedBy'=>$user,'ConfirmedDate'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A')]);
                    return Response::json(['success' => '1']);
                }
               
                else
                {
                    $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                    ['HeaderId', 'ItemId', 'StockOut','UnitPrice','TotalPrice','StoreId','TransactionType','TransactionsType','ItemType' ],
                        function ($query)use($id) {
                        $query
                        ->select(['HeaderId', 'ItemId', 'Quantity','UnitPrice','TotalPrice','StoreId','TransactionType','TransactionType','ItemType']) // ..., columnN
                            ->from('deadstocksalesitems')->where('HeaderId', '=',$id);
                        }
                    );
                    $updatetrans=DB::table('deadstocktransaction')
                    ->where('HeaderId', $id)
                    ->update(['DocumentNumber'=>$docnum,'FiscalYear'=>$fiscalyr,'Date'=>Carbon::today()->toDateString()]);

                    $updatestatus= DB::table('deadstocksale')
                    ->where('id', $id) ->update(['Status' => 'Confirmed/Removed','ConfirmedBy'=>$user,'ConfirmedDate'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A')]);
                    return Response::json(['success' => '1']);
                }
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

    public function getItemsByDsStore(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $query = DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,deadstocktransaction.ItemId,(SELECT if((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status="Pending/Removed" and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status="Pending/Removed" and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)))) AS Balance,deadstocktransaction.StoreId FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id WHERE deadstocktransaction.StoreId IN(Select StoreId from storeassignments where UserId='.$userid.') AND (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE StoreId IN(Select StoreId from storeassignments where UserId='.$userid.') AND deadstocktransaction.ItemId=regitems.id)>0 GROUP BY regitems.Name,deadstocktransaction.StoreId  order by regitems.Name ASC');
        return response()->json(['query'=>$query]);
    }

    public function getItemsByStore(Request $request,$sid)
    {
        $query = DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) AS Balance FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.StoreId IN('.$sid.') AND (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE StoreId='.$sid.' AND transactions.ItemId=regitems.id)>0 GROUP BY regitems.Name order by regitems.Name ASC');
        return response()->json(['query'=>$query]);
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
