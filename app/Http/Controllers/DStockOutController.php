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
use App\Models\actions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class DStockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->DSFiscalYear;
        $curdate = Carbon::today()->toDateString();
        $fiscalyears = DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
        $customerSrc = DB::select('SELECT * from customers where CustomerCategory!="Customer" and CustomerCategory!="Person" and ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $storeSrc=DB::select('SELECT stores.id AS StoreId,stores.Name as StoreName FROM stores WHERE stores.ActiveStatus="Active" AND stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $SourceStoreSrc = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM deadstocktransaction LEFT JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $itembarcodetype=DB::select('SELECT DISTINCT regitems.BarcodeType FROM regitems');
        $itemSrc=DB::select('SELECT * FROM regitems WHERE ActiveStatus="Active" AND Type!="Service" AND IsDeleted=1 ORDER BY Name ASC');
        $itemSrcAddHold=DB::select('select * from regitems where ActiveStatus="Active" and Type not in ("Service","Consumption") and IsDeleted=1 order by Name asc');
        $purchaser=DB::select('select * from users where IsPurchaser=1 and id>1');
        $itemSrcSales=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        $itemSrcsl=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fiscalyr.' AND (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id)>0 GROUP BY regitems.Name,transactions.StoreId order by regitems.Name ASC');
        $itemSrcpo=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,deadstocktransaction.ItemId,(SELECT if((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status="Pending/Removed" and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status="Pending/Removed" and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)))) AS Balance,deadstocktransaction.StoreId FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id WHERE (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=regitems.id)>0 GROUP BY regitems.Name,deadstocktransaction.StoreId  order by regitems.Name ASC');
        $customerSrcSales=DB::select('SELECT * FROM customers WHERE CustomerCategory NOT IN("Supplier","Foreigner-Supplier") AND ActiveStatus="Active" AND DefaultPrice!="" AND IsDeleted=1 ORDER BY id ASC');
        $storeSrcSales = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM deadstocktransaction LEFT JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $storedestSrcSales=DB::select('SELECT stores.id as StoreId,stores.Name as StoreName FROM stores WHERE stores.ActiveStatus="Active" AND stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
        $storelists=DB::select('SELECT * FROM stores');
        $storelistsval=DB::select('SELECT * FROM stores');

        $itemSrcs = DB::table('deadstocktransaction')
            ->select(
                'regitems.id AS ItemId',
                'regitems.Name AS ItemName',
                'regitems.Code',
                'regitems.SKUNumber',
                'deadstocktransaction.StoreId',
                DB::raw('COALESCE(SUM(deadstocktransaction.StockIn), 0) - COALESCE(SUM(deadstocktransaction.StockOut), 0) AS Balance')
            )
            ->leftJoin('regitems', 'deadstocktransaction.ItemId', '=', 'regitems.id')
            ->where('deadstocktransaction.FiscalYear', $fiscalyr)
            ->groupBy('regitems.id', 'deadstocktransaction.StoreId')
            ->orderBy('regitems.Name')
            ->get();

        if($request->ajax()) {
            return view('inventory.dstockout',['customerSrc'=>$customerSrc,'storeSrc'=>$storeSrc,'SourceStoreSrc'=>$SourceStoreSrc,'itemSrc'=>$itemSrc,'itemSrcs'=>$itemSrcs,'itemSrcAddHold'=>$itemSrcAddHold,'purchaser'=>$purchaser,'user'=> $user,'itemSrcSales'=>$itemSrcSales,'customerSrcSales'=>$customerSrcSales,'storeSrcSales'=>$storeSrcSales,'storedestSrcSales'=>$storedestSrcSales,'itembarcodetype'=>$itembarcodetype,'itemSrcsl'=>$itemSrcsl,'itemSrcpo'=>$itemSrcpo,'storelists'=>$storelists,'storelistsval'=>$storelistsval,'fiscalyears'=>$fiscalyears,'fiscalyr'=>$fiscalyr,'curdate'=>$curdate])->renderSections()['content'];
        }
        else{
            return view('inventory.dstockout',['customerSrc'=>$customerSrc,'storeSrc'=>$storeSrc,'SourceStoreSrc'=>$SourceStoreSrc,'itemSrc'=>$itemSrc,'itemSrcs'=>$itemSrcs,'itemSrcAddHold'=>$itemSrcAddHold,'purchaser'=>$purchaser,'user'=> $user,'itemSrcSales'=>$itemSrcSales,'customerSrcSales'=>$customerSrcSales,'storeSrcSales'=>$storeSrcSales,'storedestSrcSales'=>$storedestSrcSales,'itembarcodetype'=>$itembarcodetype,'itemSrcsl'=>$itemSrcsl,'itemSrcpo'=>$itemSrcpo,'storelists'=>$storelists,'storelistsval'=>$storelistsval,'fiscalyears'=>$fiscalyears,'fiscalyr'=>$fiscalyr,'curdate'=>$curdate]);
        }
    }

    public function getDStockOutData($fy){
        $dsdata = DB::select('SELECT deadstocksale.*,CASE WHEN deadstocksale.Type=1 THEN "Sales" WHEN deadstocksale.Type=2 THEN "Internal" WHEN deadstocksale.Type=3 THEN "Others" ELSE deadstocksale.Type END AS rec_type,src_store.Name AS src_store_name,des_store.Name AS des_store_name,customers.Name AS customer_name FROM deadstocksale LEFT JOIN customers ON deadstocksale.CustomerId=customers.id LEFT JOIN stores AS src_store ON deadstocksale.StoreId=src_store.id LEFT JOIN stores AS des_store ON deadstocksale.DestinationStore=des_store.id WHERE deadstocksale.FiscalYear='.$fy.' ORDER BY deadstocksale.id DESC');
        if(request()->ajax()) {
            return datatables()->of($dsdata)
            ->addIndexColumn()
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
    public function store(Request $request){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime = Carbon::now();
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->DSFiscalYear;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->recordId;
        $before_tax = 0;
        $tax = 0;
        $total_cost = 0;

        $validator = Validator::make($request->all(),[
            'Type' => 'required',
            'date' => 'required',
            'customer' => 'required_if:Type,1',
            'PaymentType' => 'required_if:Type,1',
            'Station' => 'required_if:Type,1',

            'internal_customer' => 'required_if:Type,2',
            'InternalPaymentType' => 'required_if:Type,2',
            'reference' => 'nullable',
            'SourceStore' => 'required_if:Type,2',
            'DestinationStore' => 'required_if:Type,2',

            'OtherStore' => 'required_if:Type,3'
        ]);

        $rules = array(
            'row.*.ItemId' => 'required',
            'row.*.Quantity' => 'required',
        );

        $v2 = Validator::make($request->all(), $rules);

        if($validator->passes() && $v2->passes() && $request->row != null){
            DB::beginTransaction();
            try{
                $storeId = $request->Type == 1 ? $request->Station : ($request->Type == 2 ? $request->SourceStore : $request->OtherStore);
                $validation = $this->validateItemBalances($request->row, $storeId,$fyear,$findid);

                if (($validation['status'] ?? "") == 456) {
                    return Response::json([
                        'balance_error' => 404,
                        'items' => $validation['negative_items']
                    ]);
                }

                $documentNumber = $settings->DeadStockSalesPrefix.sprintf("%05d",($settings->DeadStockSalesCount ?? 0)+1)."/".($settings->DSFiscalYear-2000)."-".($settings->DSFiscalYear-1999);

                foreach ($request->row as $key => $value){
                    $before_tax += $value['TotalPrice'] ?? 0;
                }

                $tax = round(($before_tax * 0.15),2);
                $total_cost = round(($before_tax + $tax),2);

                $DbData = deadstocksale::where('id',$findid)->first();

                $BasicVal = [
                    'Type' => $request->Type,
                    'TransactionDate' =>  $request->date,
                    'Memo' =>  $request->Memo,
                    'CustomerId' => $request->Type == 1 ? $request->customer : ($request->Type == 2 ? $request->internal_customer : 1),
                    'PaymentType' => $request->Type == 1 ? $request->PaymentType : ($request->Type == 2 ? $request->InternalPaymentType : "--"),
                    'DestinationStore' => $request->Type == 2 ? $request->DestinationStore : 1,
                    'StoreId' => $request->Type == 1 ? $request->Station : ($request->Type == 2 ? $request->SourceStore : $request->OtherStore),
                    'Reference' =>  $request->reference,
                    'SubTotal' => $before_tax,
                    'Tax' => $tax,
                    'GrandTotal' => $total_cost,
                    'FiscalYear' => $fyear,
                ];

                $CreateData = ['DocumentNumber' => $documentNumber,
                                'Status' => "Draft",
                                'Username' => $user,
                                'CreatedBy' => $user,
                                'CreatedDate' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                                'CheckedBy' => "",
                                'CheckedDate' => "",
                                'ConfirmedBy' => "",
                                'ConfirmedDate' => "",
                                'ChangeToPendingBy' => "",
                                'ChangeToPendingDate' => "",
                                'created_at' => Carbon::now()
                            ];

                $UpdateData = ['updated_at' => Carbon::now()];

                $directstockout = deadstocksale::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $UpdateData : $CreateData),
                );

                $statusval = $DbData->Status ?? "";

                DB::table('deadstocksalesitems')->where('deadstocksalesitems.HeaderId',$directstockout->id)->delete();

                foreach ($request->row as $key => $value){
                    $item_prop = Regitem::where('id', $value['ItemId'])->first();
                    $item_tax = round(($value['TotalPrice'] ?? 0) * (($item_prop->TaxTypeId ?? 0) / 100),2);
                    $total_tax = ($value['TotalPrice'] ?? 0) + $item_tax;
                    $recdt = new deadstocksaleitem;
                    $recdt->HeaderId = $directstockout->id;
                    $recdt->ItemId = $value['ItemId'];
                    $recdt->Quantity = $value['Quantity'];
                    $recdt->UnitPrice = $value['UnitPrice'];
                    $recdt->BeforeTaxPrice = $value['TotalPrice'] ?? 0;
                    $recdt->TaxAmount = $item_tax;
                    $recdt->TotalPrice = $total_tax;
                    $recdt->TransactionType = $request->Type == 1 ? "Sales" : ($request->Type == 2 ? "Internal" : "Others");
                    $recdt->ItemType = $item_prop->Type;
                    $recdt->StoreId = $request->Type == 1 ? $request->Station : ($request->Type == 2 ? $request->SourceStore : $request->OtherStore);
                    $recdt->DefaultUOMId = $item_prop->MeasurementId;
                    $recdt->NewUOMId = $item_prop->MeasurementId;
                    $recdt->ConvertedQuantity = $value['Quantity'];
                    $recdt->Memo = $value['Memo'];
                    $recdt->save();
                }

                if($statusval == "Approved"){
                    $item_prop = Regitem::where('id', $value['ItemId'])->first();
                    $item_tax = round(($value['TotalPrice'] ?? 0) * (($item_prop->TaxTypeId ?? 0) / 100),2);
                    $total_tax = ($value['TotalPrice'] ?? 0) + $item_tax;
                    foreach ($request->row as $key => $value){  
                        $transaction = dstransactions::updateOrCreate([
                            'HeaderId' => $directstockout->id,
                            'ItemId' => $value['ItemId'],
                            'TransactionsType' => $request->Type == 1 ? "Sales" : ($request->Type == 2 ? "Internal" : "Others"),
                        ],[
                            'HeaderId' => $directstockout->id,
                            'ItemId' => $value['ItemId'],
                            'StockOut' => $value['Quantity'],
                            'UnitPrice' => $value['UnitPrice'],
                            'BeforeTaxPrice' => $value['TotalPrice'],
                            'TaxAmountPrice' => $item_tax,
                            'TotalPrice' => $total_tax,
                            'StoreId' => $directstockout->StoreId,
                            'IsVoid' => 0,
                            'TransactionType' => $request->Type == 1 ? "Sales" : ($request->Type == 2 ? "Internal" : "Others"),
                            'TransactionsType' => $request->Type == 1 ? "Sales" : ($request->Type == 2 ? "Internal" : "Others"),
                            'ItemType' => $item_prop->Type,
                            'DocumentNumber' => $directstockout->DocumentNumber,
                            'FiscalYear' => $directstockout->FiscalYear,
                            'Date' => $directstockout->ApprovedDate,
                        ]);
                    }
                }

                if($findid == null){
                    DB::select('UPDATE settings SET DeadStockSalesCount=DeadStockSalesCount+1 WHERE id=1');
                }

                $actions = $findid == null ? "Created" : "Edited";
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $directstockout->id,
                    'pagename' => "direct-stockout",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'fiscalyr' => $fyear,'rec_id' => $directstockout->id]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }

        if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
        if($v2->fails()){
            return response()->json(['errorv2'=> $v2->errors()->all()]);
        }
        if($request->row == null){
            return Response::json(['emptyerror'=> 462]);
        }
    }

    function countDStockOutStatus(){
        $fyear = $_POST['fyear']; 
        $dstockout_status_count = DB::select('SELECT deadstocksale.Status,FORMAT(COUNT(*),0) AS status_count FROM deadstocksale WHERE deadstocksale.FiscalYear='.$fyear.' GROUP BY deadstocksale.Status UNION SELECT "Total",FORMAT(COUNT(*),0) AS status_count FROM deadstocksale WHERE deadstocksale.FiscalYear='.$fyear);
 
        return response()->json(['dstockout_status_count' => $dstockout_status_count]); 
    }

    public function fetchDStockOutData(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->DSFiscalYear;
        $recId = $_POST['recId'];
        $recId = !empty($recId) ? $recId : 0;

        $dstockoutdata = DB::select('SELECT deadstocksale.*,CASE WHEN deadstocksale.Type=1 THEN "Sales" WHEN deadstocksale.Type=2 THEN "Internal" WHEN deadstocksale.Type=3 THEN "Others" ELSE deadstocksale.Type END AS rec_type,src_store.Name AS src_store_name,des_store.Name AS des_store_name,customers.Name AS customer_name FROM deadstocksale LEFT JOIN customers ON deadstocksale.CustomerId=customers.id LEFT JOIN stores AS src_store ON deadstocksale.StoreId=src_store.id LEFT JOIN stores AS des_store ON deadstocksale.DestinationStore=des_store.id WHERE deadstocksale.id='.$recId);

        $detaildata = deadstocksaleitem::leftJoin('deadstockrecs', 'deadstocksalesitems.HeaderId', '=', 'deadstockrecs.id')
            ->leftJoin('regitems', 'deadstocksalesitems.ItemId', '=', 'regitems.id')
            ->leftJoin('uoms', 'deadstocksalesitems.DefaultUOMId', '=', 'uoms.id')
            ->where('deadstocksalesitems.HeaderId', $recId)
            ->orderBy('deadstocksalesitems.id','asc')
            ->get(['deadstockrecs.*','deadstocksalesitems.*','deadstocksalesitems.StoreId AS recdetstoreid',
            'deadstocksalesitems.RequireSerialNumber AS ReSerialNm','deadstocksalesitems.RequireExpireDate AS ReExpDate','regitems.Name AS ItemName','regitems.Code AS ItemCode','regitems.SKUNumber',
            'uoms.Name AS UOM']);
        
        $activitydata = actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"direct-stockout")
            ->where('pageid',$recId)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['dstockoutdata' => $dstockoutdata,'detaildata' => $detaildata,'activitydata' => $activitydata]);
    }

    public function getDStockOutDetailData($id){
        $detaildata = deadstocksaleitem::leftJoin('deadstockrecs', 'deadstocksalesitems.HeaderId', '=', 'deadstockrecs.id')
            ->leftJoin('regitems', 'deadstocksalesitems.ItemId', '=', 'regitems.id')
            ->leftJoin('uoms', 'deadstocksalesitems.DefaultUOMId', '=', 'uoms.id')
            ->where('deadstocksalesitems.HeaderId', $id)
            ->orderBy('deadstocksalesitems.id','asc')
            ->get(['deadstockrecs.*','deadstocksalesitems.*','deadstocksalesitems.StoreId AS recdetstoreid',
            'deadstocksalesitems.RequireSerialNumber AS ReSerialNm','deadstocksalesitems.RequireExpireDate AS ReExpDate','regitems.Name AS ItemName','regitems.Code AS ItemCode','regitems.SKUNumber',
            'uoms.Name AS UOM']);

        return datatables()->of($detaildata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function voidDStockOutData(Request $request){
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime = Carbon::now();
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->voidDStockOutid;
        $recprop = deadstocksale::find($findid);
        $store_id = $recprop->StoreId;
        $fiscal_yr = $recprop->FiscalYear;
        $doc_num = $recprop->DocumentNumber;
        $src_store = $recprop->StoreId;
        $stockout_status = $recprop->Status;

        $validator = Validator::make($request->all(),[
            'DSReason' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status != "Void"){
                DB::beginTransaction();
                try{
                    $recprop->StatusOld = $recprop->Status;
                    $recprop->Status = "Void(".$recprop->StatusOld.")";
                    $recprop->save();

                    if($stockout_status == "Approved"){ 
                        DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,FiscalYear,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitPrice,BeforeTaxPrice,TaxAmount,TotalPrice,StoreId,"Stock-Out",ItemType,'.$fiscal_yr.',"'.$doc_num.'","Void","'.Carbon::today()->toDateString().'" FROM deadstocksalesitems WHERE deadstocksalesitems.HeaderId='.$findid);
                    }

                    DB::table('actions')->insert([
                        'user_id' => $userid,
                        'pageid' => $findid,
                        'pagename' => "direct-stockout",
                        'action' => "Void",
                        'status' => "Void",
                        'reason' => "$request->DSReason",
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

    public function undoVoidDStockOut(Request $request){
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime = Carbon::now();
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $dispqnt = 0;
        $compdisp = 0;
        $findid = $request->dstockoutid;
        $recprop = deadstocksale::find($findid);
        $store_id = $recprop->StoreId;
        $fiscal_yr = $recprop->FiscalYear;
        $doc_num = $recprop->DocumentNumber;

        DB::beginTransaction();
        try{
            $recprop->Status = $recprop->StatusOld;
            $recprop->save();

            if($recprop->StatusOld == "Approved"){
                $validation = $this->validateSalesItems($store_id,$fiscal_yr,$findid);

                if (($validation['status'] ?? "") == 456) {
                    return Response::json([
                        'balance_error' => 404,
                        'items' => $validation['negative_items']
                    ]);
                }
                else{
                    DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,Quantity,UnitPrice,BeforeTaxPrice,"'.$store_id.'","Stock-Out","Undo-Void",ItemType,"'.$doc_num.'","'.$fiscal_yr.'","0","'.Carbon::now()->toDateString().'" FROM deadstocksalesitems WHERE deadstocksalesitems.HeaderId='.$findid);
                }
            }

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "direct-stockout",
                'action' => "Undo Void",
                'status' => "Undo Void",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            DB::commit();

            return Response::json(['success' => 1, 'rec_id' => $findid, 'fyear' => $recprop->FiscalYear]);
        }
        catch(Exception $e){
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function dstockOutForwardAction(Request $request){
        $val_status = ["Draft","Pending","Verified","Approved","Issued","Received"];

        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;

            $sett = DB::table('settings')->latest()->first();
            $fiscalyrcomp = $sett->DSFiscalYear;

            $findid = $request->forwardReqId;
            $req = deadstocksale::find($findid);
            $currentStatus = $req->Status;
            $newStatus = $request->newForwardStatusValue;
            $action = $request->forwardActionValue;
            $req->Status = $newStatus;
            $doc_num = $req->DocumentNumber;
            $fiscal_yr = $req->FiscalYear;
            $src_store = $req->StoreId;
            $transaction_type = $req->Type == 1 ? "Sales" : ($req->Type == 2 ? "Internal" : "Others");

            $stockinids = deadstocksale::whereIn('Status', ["Void","Void(Received)"])
                ->pluck('id')
                ->toArray();

            $stockinids = !empty($stockinids) ? implode(', ', $stockinids) : '0';

            if($newStatus == "Verified"){
                $req->CheckedBy = $user;
                $req->CheckedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }

            if($newStatus == "Approved"){
                $validation = $this->validateSalesItems($src_store,$fiscal_yr,$findid);

                if (($validation['status'] ?? "") == 456) {
                    return Response::json([
                        'balance_error' => 404,
                        'items' => $validation['negative_items']
                    ]);
                }
                else{
                    DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,Quantity,UnitPrice,BeforeTaxPrice,"'.$src_store.'","Stock-Out","'.$transaction_type.'",ItemType,"'.$doc_num.'","'.$fiscal_yr.'","0","'.Carbon::now()->toDateString().'" FROM deadstocksalesitems WHERE deadstocksalesitems.HeaderId='.$findid);

                    $req->ApprovedBy = $user;
                    $req->ApprovedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                }
            }
            $req->save();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "direct-stockout",
                'action' => "$action",
                'status' => "$action",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            DB::commit();
            return Response::json(['success' => 1, 'rec_id' => $findid, 'fiscalyr' => $fiscal_yr]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function dstockOutBackwardAction(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->backwardReqId;
        $action = $request->backwardActionValue;
        $newStatus = $request->newBackwardStatusValue;
        $req = deadstocksale::find($findid);
        $fiscalyr = $req->FiscalYear;
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();
            try{
                $req->Status = $newStatus;

                if($newStatus == "Pending"){
                    $req->CheckedBy = "";
                    $req->CheckedDate = "";
                }

                if($newStatus == "Verified"){
                    $req->ApprovedBy = "";
                    $req->ApprovedDate = "";
                }
                $req->save();

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "direct-stockout",
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

    public function calcDStockOutRemBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->DSFiscalYear;
        $record_id = $_POST['baseRecordId'] ?? 0;
        $store_id = $_POST['storeval'] ?? 0;
        $item_id = $_POST['itemid'] ?? 0;

        $item_balance_data = DB::select('SELECT (SUM(COALESCE(StockIn,0)) - SUM(COALESCE(StockOut,0))) AS available_quantity FROM deadstocktransaction WHERE deadstocktransaction.FiscalYear='.$fyear.' AND deadstocktransaction.StoreId='.$store_id.' AND deadstocktransaction.ItemId='.$item_id);
        $total_stockin_data = DB::select('SELECT SUM(COALESCE(deadstockdetails.Quantity,0)) AS total_stockin FROM deadstockdetails LEFT JOIN deadstockrecs ON deadstockdetails.HeaderId=deadstockrecs.id WHERE deadstockrecs.SourceStore='.$store_id.' AND deadstockdetails.ItemId='.$item_id.' AND deadstockrecs.Type=2 AND deadstockrecs.Status IN("Draft","Pending","Verified")');
        $others_sales_data = DB::select('SELECT SUM(COALESCE(deadstocksalesitems.Quantity,0)) AS others_sales_qty FROM deadstocksalesitems LEFT JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id WHERE deadstocksale.id!='.$record_id.' AND deadstocksale.StoreId='.$store_id.' AND deadstocksalesitems.ItemId='.$item_id.' AND deadstocksale.Status IN("Draft","Pending","Verified")');
        $current_sales_data = DB::select('SELECT SUM(COALESCE(deadstocksalesitems.Quantity,0)) AS current_item_qty FROM deadstocksalesitems LEFT JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id WHERE deadstocksale.id='.$record_id.' AND deadstocksale.StoreId='.$store_id.' AND deadstocksalesitems.ItemId='.$item_id);

        $main_balance = $item_balance_data[0]->available_quantity ?? 0;
        $total_stockin = $total_stockin_data[0]->total_stockin ?? 0;
        $others_sales_qty = $others_sales_data[0]->others_sales_qty ?? 0;
        $current_sales_qty = $current_sales_data[0]->current_item_qty ?? 0;

        $available_qty = $main_balance - $total_stockin - $others_sales_qty;

        $available_qty = $available_qty < 0 ? 0 : $available_qty;

        return response()->json(['available_qty' => $available_qty]);       
    }

    function validateItemBalances($items, $storeId,$fyear, $transactionId = null){
        $negativeItems = [];
        $trn_type = ["Purchase","Sales","Transfer-In","Transfer-Out"];

        $detail_item = DB::table('deadstocksalesitems')
                ->where('HeaderId', $transactionId)
                ->get();
        
        foreach ($detail_item as $item) {
            $itemId = $item->ItemId;
            $modifiedQuantity = 0;
            $original_stock = $item->Quantity ?? 0;

            foreach ($items ?? [] as $key => $d_item) {
                if ($d_item['ItemId'] == $item->ItemId) {
                    $modifiedQuantity = $d_item['Quantity'];
                }
            }

            $transactions = DB::table('deadstocktransaction')
                ->where('ItemId', $itemId)
                ->where('StoreId', $storeId)
                ->where('FiscalYear', $fyear)
                ->whereIn('TransactionsType',$trn_type)
                ->orderBy('id')
                ->get();

            $runningBalance = 0;
            $salesFound = false;

            foreach ($transactions as $transaction) {
                $runningBalance += ($transaction->StockIn ?? 0);
                $runningBalance -= ($transaction->StockOut ?? 0);

                if ($transaction->HeaderId == $transactionId && $transaction->TransactionType == 'Stock-Out') {
                    $salesFound = true;
                    $voidqty = 0;
                    
                    // Instead of actual stock_in, use the new value for calculation
                    $runningBalance = $runningBalance - ($transaction->StockOut ?? 0) + $modifiedQuantity;  
                }

                if ($salesFound && $runningBalance < 0) {
                    $itemName = DB::table('regitems')
                        ->where('id', $itemId)
                        ->distinct()
                        ->value('Name');

                    $negativeItems[] = [
                        'id' => $itemId,
                        'name' => $itemName,
                        'running_balance' => $runningBalance
                    ];
                }
            }
        }

        if (!empty($negativeItems)) {
            return [
                'status' => 456,
                'negative_items' => $negativeItems
            ];
        }
    }

    function validateSalesItems($storeId,$fyear, $transactionId = null){
        $negativeItems = [];
        $trn_type = ["Purchase","Sales","Transfer-In","Transfer-Out"];

        $detail_item = DB::table('deadstocksalesitems')
                ->where('HeaderId', $transactionId)
                ->get();

        foreach ($detail_item as $item) {
            $itemId = $item->ItemId;
            $soldQty = $item->Quantity ?? 0;

            $availableQty = DB::table('deadstocktransaction')
                ->where('ItemId', $itemId)
                ->where('StoreId', $storeId)
                ->where('FiscalYear', $fyear)
                ->selectRaw('COALESCE(SUM(StockIn), 0) - COALESCE(SUM(StockOut), 0) as balance')
                ->value('balance') ?? 0;

            if ($availableQty < $soldQty) {
                $itemName = DB::table('regitems')
                    ->where('id', $itemId)
                    ->distinct()
                    ->value('Name');

                $negativeItems[] = [
                    'id' => $itemId,
                    'name' => $itemName,
                    'balance' => $availableQty
                ];
            }
        }

        if (!empty($negativeItems)) {
            return [
                'status' => 456,
                'negative_items' => $negativeItems
            ];
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
