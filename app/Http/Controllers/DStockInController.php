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

class DStockInController extends Controller
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
        $SourceStoreSrc = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=1 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        $itembarcodetype=DB::select('SELECT DISTINCT regitems.BarcodeType FROM regitems');
        $itemSrc=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        $itemSrcAddHold=DB::select('select * from regitems where ActiveStatus="Active" and Type not in ("Service","Consumption") and IsDeleted=1 order by Name asc');
        $purchaser=DB::select('select * from users where IsPurchaser=1 and id>1');
        $itemSrcSales=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        $itemSrcsl=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,transactions.ItemId,(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) AS Balance,transactions.StoreId FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE transactions.FiscalYear='.$fiscalyr.' AND (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=regitems.id)>0 GROUP BY regitems.Name,transactions.StoreId order by regitems.Name ASC');
        $itemSrcpo=DB::select('SELECT DISTINCT regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber,deadstocktransaction.ItemId,(SELECT if((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status="Pending/Removed" and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)<=0,"0",((sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)))-(select COALESCE((sum(Quantity)),0) from deadstocksalesitems inner join deadstocksale on deadstocksalesitems.HeaderId=deadstocksale.id where deadstocksale.Status="Pending/Removed" and deadstocksalesitems.StoreId=deadstocktransaction.StoreId and deadstocksalesitems.ItemId=deadstocktransaction.ItemId)))) AS Balance,deadstocktransaction.StoreId FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id WHERE (SELECT sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=regitems.id)>0 GROUP BY regitems.Name,deadstocktransaction.StoreId  order by regitems.Name ASC');
        $customerSrcSales=DB::select('select * from customers where CustomerCategory!="Supplier" and CustomerCategory!="Foreigner-Supplier" and ActiveStatus="Active" and DefaultPrice!="" and IsDeleted=1 and id>1 order by Name asc');
        $storeSrcSales = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM deadstocktransaction INNER JOIN stores ON deadstocktransaction.StoreId=stores.id WHERE stores.IsDeleted=1 AND stores.id>1 ORDER BY stores.Name ASC');
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
            return view('inventory.dstockin',['customerSrc'=>$customerSrc,'storeSrc'=>$storeSrc,'SourceStoreSrc'=>$SourceStoreSrc,'itemSrc'=>$itemSrc,'itemSrcs'=>$itemSrcs,'itemSrcAddHold'=>$itemSrcAddHold,'purchaser'=>$purchaser,'user'=> $user,'itemSrcSales'=>$itemSrcSales,'customerSrcSales'=>$customerSrcSales,'storeSrcSales'=>$storeSrcSales,'storedestSrcSales'=>$storedestSrcSales,'itembarcodetype'=>$itembarcodetype,'itemSrcsl'=>$itemSrcsl,'itemSrcpo'=>$itemSrcpo,'storelists'=>$storelists,'storelistsval'=>$storelistsval,'fiscalyears'=>$fiscalyears,'fiscalyr'=>$fiscalyr,'curdate'=>$curdate])->renderSections()['content'];
        }
        else{
            return view('inventory.dstockin',['customerSrc'=>$customerSrc,'storeSrc'=>$storeSrc,'SourceStoreSrc'=>$SourceStoreSrc,'itemSrc'=>$itemSrc,'itemSrcs'=>$itemSrcs,'itemSrcAddHold'=>$itemSrcAddHold,'purchaser'=>$purchaser,'user'=> $user,'itemSrcSales'=>$itemSrcSales,'customerSrcSales'=>$customerSrcSales,'storeSrcSales'=>$storeSrcSales,'storedestSrcSales'=>$storedestSrcSales,'itembarcodetype'=>$itembarcodetype,'itemSrcsl'=>$itemSrcsl,'itemSrcpo'=>$itemSrcpo,'storelists'=>$storelists,'storelistsval'=>$storelistsval,'fiscalyears'=>$fiscalyears,'fiscalyr'=>$fiscalyr,'curdate'=>$curdate]);
        }
    }


    public function getDStockInData($fy){
        $dsdata = DB::select('SELECT deadstockrecs.*,CASE WHEN deadstockrecs.Type=1 THEN "Purchase" WHEN deadstockrecs.Type=2 THEN "Transfer" WHEN deadstockrecs.Type=3 THEN "Others" ELSE deadstockrecs.Type END AS rec_type,src_store.Name AS src_store_name,des_store.Name AS des_store_name,customers.Name AS supplier_name FROM deadstockrecs LEFT JOIN customers ON deadstockrecs.CustomerId=customers.id LEFT JOIN stores AS src_store ON deadstockrecs.SourceStore=src_store.id LEFT JOIN stores AS des_store ON deadstockrecs.StoreId=des_store.id WHERE deadstockrecs.FiscalYear='.$fy.' ORDER BY deadstockrecs.id DESC');
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
            'supplier' => 'required_if:Type,1',
            'PaymentType' => 'required_if:Type,1',
            'Station' => 'required_if:Type,1',
            'SourceStore' => 'required_if:Type,2,3|different:DestinationStore',
            'DestinationStore' => 'required_if:Type,2,3|different:SourceStore',
        ]);

        $rules = array(
            'row.*.ItemId' => 'required',
            'row.*.Quantity' => 'required',
        );

        $v2 = Validator::make($request->all(), $rules);

        if($validator->passes() && $v2->passes() && $request->row != null){
            DB::beginTransaction();
            try{
                $storeId = $request->Type == 1 ? $request->Station : $request->DestinationStore;
                $validation = $this->validateItemBalances($request->row, $storeId,$fyear,$findid);

                if (($validation['status'] ?? "") == 456) {
                    return Response::json([
                        'balance_error' => 404,
                        'items' => $validation['negative_items']
                    ]);
                }

                $documentNumber = $settings->DeadStockPrefix.sprintf("%05d",($settings->DeadStockCount ?? 0)+1)."/".($settings->DSFiscalYear-2000)."-".($settings->DSFiscalYear-1999);

                foreach ($request->row as $key => $value){
                    $before_tax += $value['BeforeTaxCost'] ?? 0;
                }

                $tax = round(($before_tax * 0.15),2);
                $total_cost = round(($before_tax + $tax),2);

                $DbData = deadstock::where('id',$findid)->first();

                $BasicVal = [
                    'Type' => $request->Type,
                    'TransactionDate' =>  $request->date,
                    'Memo' =>  $request->Memo,
                    'CustomerId' => $request->Type == 1 ? $request->supplier : 1,
                    'PaymentType' => $request->Type == 1 ? $request->PaymentType : "--",
                    'StoreId' => $storeId,
                    'PurchaserName' =>  $request->Purchaser,
                    'SourceStore' => $request->Type == 1 ? 1 : $request->SourceStore,
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

                $directstock = deadstock::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $UpdateData : $CreateData),
                );

                $statusval = $DbData->Status ?? "";

                DB::table('deadstockdetails')->where('deadstockdetails.HeaderId',$directstock->id)->delete();

                foreach ($request->row as $key => $value){
                    $item_prop = Regitem::where('id', $value['ItemId'])->first();
                    $item_tax = round(($value['BeforeTaxCost'] ?? 0) * (($item_prop->TaxTypeId ?? 0) / 100),2);
                    $total_tax = ($value['BeforeTaxCost'] ?? 0) + $item_tax;
                    $recdt = new deadstockdetail;
                    $recdt->HeaderId = $directstock->id;
                    $recdt->ItemId = $value['ItemId'];
                    $recdt->Quantity = $value['Quantity'];
                    $recdt->UnitCost = $value['UnitCost'];
                    $recdt->BeforeTaxCost = $value['BeforeTaxCost'] ?? 0;
                    $recdt->TaxAmount = $item_tax;
                    $recdt->TotalCost = $total_tax;
                    $recdt->TransactionType = $request->Type == 1 ? "Purchase" : ($request->Type == 2 ? "Transfer" : "Others");
                    $recdt->ItemType = $item_prop->Type;
                    $recdt->StoreId = $request->Type == 1 ? $request->Station : $request->DestinationStore;
                    $recdt->SellingPrice = $value['SellingPrice'];
                    $recdt->DefaultUOMId = $item_prop->MeasurementId;
                    $recdt->NewUOMId = $item_prop->MeasurementId;
                    $recdt->ConvertedQuantity = $value['Quantity'];
                    $recdt->Memo = $value['Memo'];
                    $recdt->save();
                }

                if($statusval == "Received"){
                    $item_prop = Regitem::where('id', $value['ItemId'])->first();
                    $item_tax = round(($value['BeforeTaxCost'] ?? 0) * (($item_prop->TaxTypeId ?? 0) / 100),2);
                    $total_tax = ($value['BeforeTaxCost'] ?? 0) + $item_tax;
                    foreach ($request->row as $key => $value){  
                        $transaction = dstransactions::updateOrCreate([
                            'HeaderId' => $directstock->id,
                            'ItemId' => $value['ItemId'],
                            'TransactionsType' => $request->Type == 1 ? "Purchase" : ($request->Type == 2 ? "Transfer-In" : "Others"),
                        ],[
                            'HeaderId' => $directstock->id,
                            'ItemId' => $value['ItemId'],
                            'StockIn' => $value['Quantity'],
                            'UnitCost' => $value['UnitCost'],
                            'BeforeTaxCost' => $value['BeforeTaxCost'],
                            'TaxAmountCost' => $item_tax,
                            'TotalCost' => $total_tax,
                            'StoreId' => $directstock->StoreId,
                            'IsVoid' => 0,
                            'TransactionType' => "Stock-In",
                            'TransactionsType' => $request->Type == 1 ? "Purchase" : ($request->Type == 2 ? "Transfer-In" : "Others"),
                            'ItemType' => $item_prop->Type,
                            'DocumentNumber' => $directstock->DocumentNumber,
                            'FiscalYear' => $directstock->FiscalYear,
                            'Date' => $directstock->ReceivedDate,
                        ]);
                    }

                    if($request->Type == 2){
                        foreach ($request->row as $key => $value){  
                            $transaction = dstransactions::updateOrCreate([
                                'HeaderId' => $directstock->id,
                                'ItemId' => $value['ItemId'],
                                'TransactionsType' => $request->Type == 1 ? "Purchase" : ($request->Type == 2 ? "Transfer" : "Others"),
                            ],[
                                'HeaderId' => $directstock->id,
                                'ItemId' => $value['ItemId'],
                                'StockOut' => $value['Quantity'],
                                'UnitPrice' => $value['UnitCost'],
                                'BeforeTaxPrice' => $value['BeforeTaxCost'],
                                'TaxAmountPrice' => $item_tax,
                                'TotalPrice' => $total_tax,
                                'StoreId' => $directstock->SourceStore,
                                'IsVoid' => 0,
                                'TransactionType' => "Stock-In",
                                'TransactionsType' => "Transfer-Out",
                                'ItemType' => $item_prop->Type,
                                'DocumentNumber' => $directstock->DocumentNumber,
                                'FiscalYear' => $directstock->FiscalYear,
                                'Date' => $directstock->ReceivedDate,
                            ]);
                        }
                    }

                    //---- UPDATE Void and Undo void if exist----
                    foreach ($request->row as $key => $value){  
                        $item_prop = Regitem::where('id', $value['ItemId'])->first();
                        $item_tax = round(($value['BeforeTaxCost'] ?? 0) * (($item_prop->TaxTypeId ?? 0) / 100),2);
                        $total_tax = ($value['BeforeTaxCost'] ?? 0) + $item_tax;

                        DB::table('deadstocktransaction')
                            ->where('deadstocktransaction.HeaderId',$directstock->id)
                            ->where('deadstocktransaction.ItemId',$value['ItemId'])
                            ->where('deadstocktransaction.TransactionType',"Stock-In")
                            ->where('deadstocktransaction.TransactionsType',"Void")
                            ->update([
                                'StockOut' => $value['Quantity'],
                                'UnitPrice' => $value['UnitCost'],
                                'BeforeTaxPrice' => $value['BeforeTaxCost'],
                                'TaxAmountPrice' => $item_tax,
                                'TotalPrice' => $total_tax
                            ]);

                        DB::table('deadstocktransaction')
                            ->where('deadstocktransaction.HeaderId',$directstock->id)
                            ->where('deadstocktransaction.ItemId',$value['ItemId'])
                            ->where('deadstocktransaction.TransactionType',"Stock-In")
                            ->where('deadstocktransaction.TransactionsType',"Undo-Void")
                            ->update([
                                'StockIn' => $value['Quantity'],
                                'UnitCost' => $value['UnitCost'],
                                'BeforeTaxCost' => $value['BeforeTaxCost'],
                                'TaxAmountCost' => $item_tax,
                                'TotalCost' => $total_tax
                            ]);
                    }

                    $stockinids = deadstock::whereIn('Status', ["Void"])
                        ->pluck('id')
                        ->toArray();

                    $stockinids = !empty($stockinids) ? implode(', ', $stockinids) : '0';

                    DB::select('UPDATE regitems as b1 INNER JOIN deadstockdetails as b2 ON b1.id = b2.ItemId SET b1.DeadStockPrice = (SELECT SellingPrice FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid.' AND deadstockdetails.ItemId=b2.ItemId) AND b2.TransactionsType IN("Purchase") AND b2.IsVoid=0 WHERE b2.HeaderId NOT IN('.$stockinids.')'); 
                    DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcosteditable=IF(((SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id)>b1.dsmaxcost),(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id),b1.dsmaxcosteditable) WHERE b1.id=b2.ItemId AND b2.TransactionsType IN("Purchase") AND b2.IsVoid=0 AND b2.HeaderId NOT IN('.$stockinids.')'); 
                    DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcost=(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id) WHERE b1.id=b2.ItemId AND b2.TransactionsType IN("Purchase") AND b2.HeaderId NOT IN('.$stockinids.')'); 
                }

                if($findid == null){
                    DB::select('UPDATE settings SET DeadStockCount=DeadStockCount+1 WHERE id=1');
                }

                $actions = $findid == null ? "Created" : "Edited";
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $directstock->id,
                    'pagename' => "direct-stockin",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'fiscalyr' => $fyear,'rec_id' => $directstock->id]);

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

    public function calcDSRemBalance(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->DSFiscalYear;
        $record_id = $_POST['baseRecordId'] ?? 0;
        $store_id = $_POST['storeval'] ?? 0;
        $item_id = $_POST['itemid'] ?? 0;

        $item_balance_data = DB::select('SELECT (SUM(COALESCE(StockIn,0)) - SUM(COALESCE(StockOut,0))) AS available_quantity FROM deadstocktransaction WHERE deadstocktransaction.FiscalYear='.$fyear.' AND deadstocktransaction.StoreId='.$store_id.' AND deadstocktransaction.ItemId='.$item_id);
        $other_req_data = DB::select('SELECT SUM(COALESCE(deadstockdetails.Quantity,0)) AS others_req_qty FROM deadstockdetails LEFT JOIN deadstockrecs ON deadstockdetails.HeaderId=deadstockrecs.id WHERE deadstockrecs.id!='.$record_id.' AND deadstockrecs.SourceStore='.$store_id.' AND deadstockdetails.ItemId='.$item_id.' AND deadstockrecs.Type=2 AND deadstockrecs.Status IN("Draft","Pending","Verified")');
        $sales_data = DB::select('SELECT SUM(COALESCE(deadstocksalesitems.Quantity,0)) AS sales_qty FROM deadstocksalesitems LEFT JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id WHERE deadstocksale.StoreId='.$store_id.' AND deadstocksalesitems.ItemId='.$item_id.' AND deadstocksale.Status IN("Draft","Pending","Verified")');

        $main_balance = $item_balance_data[0]->available_quantity ?? 0;
        $others_req_qty = $other_req_data[0]->others_req_qty ?? 0;
        $sales_qty = $sales_data[0]->sales_qty ?? 0;

        $available_qty = $main_balance - $others_req_qty - $sales_qty;

        $available_qty = $available_qty < 0 ? 0 : $available_qty;

        //$avcost = $this->getCurrentAverageCost($item_id);

        return response()->json(['available_qty' => $available_qty]);       
    }

    function countDStockInStatus(){
        $fyear = $_POST['fyear']; 
        $dstockin_status_count = DB::select('SELECT deadstockrecs.Status,FORMAT(COUNT(*),0) AS status_count FROM deadstockrecs WHERE deadstockrecs.FiscalYear='.$fyear.' GROUP BY deadstockrecs.Status UNION SELECT "Total",FORMAT(COUNT(*),0) AS status_count FROM deadstockrecs WHERE deadstockrecs.FiscalYear='.$fyear);
 
        return response()->json(['dstockin_status_count' => $dstockin_status_count]); 
    }

    public function fetchDStockInData(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->DSFiscalYear;
        $recId = $_POST['recId'];
        $recId = !empty($recId) ? $recId : 0;

        $dstockindata = DB::select('SELECT deadstockrecs.*,CASE WHEN deadstockrecs.Type=1 THEN "Purchase" WHEN deadstockrecs.Type=2 THEN "Transfer" WHEN deadstockrecs.Type=3 THEN "Others" ELSE deadstockrecs.Type END AS rec_type,src_store.Name AS src_store_name,des_store.Name AS des_store_name,customers.Name AS supplier_name FROM deadstockrecs LEFT JOIN customers ON deadstockrecs.CustomerId=customers.id LEFT JOIN stores AS src_store ON deadstockrecs.SourceStore=src_store.id LEFT JOIN stores AS des_store ON deadstockrecs.StoreId=des_store.id WHERE deadstockrecs.id='.$recId);

        $detaildata = deadstockdetail::leftJoin('deadstockrecs', 'deadstockdetails.HeaderId', '=', 'deadstockrecs.id')
            ->leftJoin('regitems', 'deadstockdetails.ItemId', '=', 'regitems.id')
            ->leftJoin('uoms', 'deadstockdetails.DefaultUOMId', '=', 'uoms.id')
            ->where('deadstockdetails.HeaderId', $recId)
            ->orderBy('deadstockdetails.id','asc')
            ->get(['deadstockrecs.*','deadstockdetails.*','deadstockdetails.StoreId AS recdetstoreid',
            'deadstockdetails.RequireSerialNumber AS ReSerialNm','deadstockdetails.RequireExpireDate AS ReExpDate','deadstockdetails.SellingPrice','regitems.Name AS ItemName','regitems.Code AS ItemCode','regitems.SKUNumber',
            'uoms.Name AS UOM']);
        
        $activitydata=actions::join('users','actions.user_id','users.id')
            ->where('actions.pagename',"direct-stockin")
            ->where('pageid',$recId)
            ->orderBy('actions.id','DESC')
            ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['dstockindata' => $dstockindata,'detaildata' => $detaildata,'activitydata' => $activitydata]);
    }

    public function getDStockInDetailData($id){
        $detaildata = deadstockdetail::leftJoin('deadstockrecs', 'deadstockdetails.HeaderId', '=', 'deadstockrecs.id')
            ->leftJoin('regitems', 'deadstockdetails.ItemId', '=', 'regitems.id')
            ->leftJoin('uoms', 'deadstockdetails.DefaultUOMId', '=', 'uoms.id')
            ->where('deadstockdetails.HeaderId', $id)
            ->orderBy('deadstockdetails.id','asc')
            ->get(['deadstockrecs.*','deadstockdetails.*','deadstockdetails.StoreId AS recdetstoreid',
            'deadstockdetails.RequireSerialNumber AS ReSerialNm','deadstockdetails.RequireExpireDate AS ReExpDate','deadstockdetails.SellingPrice','regitems.Name AS ItemName','regitems.Code AS ItemCode','regitems.SKUNumber',
            'uoms.Name AS UOM']);
        return datatables()->of($detaildata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function voidDStockInData(Request $request){
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime = Carbon::now();
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->voidDStockInid;
        $recprop = deadstock::find($findid);
        $store_id = $recprop->StoreId;
        $fiscal_yr = $recprop->FiscalYear;
        $doc_num = $recprop->DocumentNumber;
        $src_store = $recprop->SourceStore;
        $stockin_status = $recprop->Status;

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

                    if($stockin_status == "Received"){

                        $validation = $this->validateItemBalances($request->row, $store_id,$fiscal_yr,$findid);

                        if (($validation['status'] ?? "") == 456) {
                            return Response::json([
                                'balance_error' => 404,
                                'items' => $validation['negative_items']
                            ]);
                        }
                        else{

                            if($recprop->Type == 1){
                                $stockinids = deadstock::whereIn('Status', ["Void"])
                                    ->pluck('id')
                                    ->toArray();

                                $stockinids = !empty($stockinids) ? implode(', ', $stockinids) : '0';

                                DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,StoreId,"Stock-In","Void",ItemType,"'.$doc_num.'","'.$fiscal_yr.'","1","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);

                                DB::select('UPDATE regitems as b1 INNER JOIN deadstockdetails as b2 ON b1.id = b2.ItemId SET b1.DeadStockPrice = (SELECT SellingPrice FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid.' AND deadstockdetails.ItemId=b2.ItemId) AND b2.TransactionsType IN("Purchase") AND b2.IsVoid=0 WHERE b2.HeaderId NOT IN('.$stockinids.')'); 
                                DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcosteditable=IF(((SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id)>b1.dsmaxcost),(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id),b1.dsmaxcosteditable) WHERE b1.id=b2.ItemId AND b2.TransactionsType IN("Purchase") AND b2.IsVoid=0 AND b2.HeaderId NOT IN('.$stockinids.')'); 
                                DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcost=(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id) WHERE b1.id=b2.ItemId AND b2.TransactionsType IN("Purchase") AND b2.HeaderId NOT IN('.$stockinids.')'); 
                            }
                            else if($recprop->Type == 2){
                                DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,"'.$src_store.'","Stock-In","Void",ItemType,"'.$doc_num.'","'.$fiscal_yr.'","1","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);

                                DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,RetailerPrice,FiscalYear,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,"Stock-In",ItemType,SellingPrice,'.$fiscal_yr.',"'.$doc_num.'","Void","'.Carbon::today()->toDateString().'" from deadstockdetails where deadstockdetails.HeaderId='.$findid);
                            }
                            else{
                                DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,StoreId,"Stock-In","Void",ItemType,"'.$doc_num.'","'.$fiscal_yr.'","1","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);
                            }
                        }
                    }

                    DB::table('actions')->insert([
                        'user_id' => $userid,
                        'pageid' => $findid,
                        'pagename' => "direct-stockin",
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

    public function undoVoidDStockIn(Request $request){
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime = Carbon::now();
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $dispqnt = 0;
        $compdisp = 0;
        $findid = $request->dstockinid;
        $recprop = deadstock::find($findid);
        $store_id = $recprop->StoreId;
        $fiscal_yr = $recprop->FiscalYear;
        $doc_num = $recprop->DocumentNumber;

        DB::beginTransaction();
        try{
            $recprop->Status = $recprop->StatusOld;
            $recprop->save();

            if($recprop->StatusOld == "Received"){
                if($recprop->Type == 1){
                    $stockinids = deadstock::whereIn('Status', ["Void"])
                        ->pluck('id')
                        ->toArray();

                    $stockinids = !empty($stockinids) ? implode(', ', $stockinids) : '0';

                    DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,StoreId,"Stock-In","Undo-Void",ItemType,"'.$doc_num.'","'.$fiscal_yr.'","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);

                    DB::select('UPDATE regitems as b1 INNER JOIN deadstockdetails as b2 ON b1.id = b2.ItemId SET b1.DeadStockPrice = (SELECT SellingPrice FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid.' AND deadstockdetails.ItemId=b2.ItemId) AND b2.TransactionsType IN("Purchase") AND b2.IsVoid=0 WHERE b2.HeaderId NOT IN('.$stockinids.')'); 
                    DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcosteditable=IF(((SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id)>b1.dsmaxcost),(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id),b1.dsmaxcosteditable) WHERE b1.id=b2.ItemId AND b2.TransactionsType IN("Purchase") AND b2.IsVoid=0 AND b2.HeaderId NOT IN('.$stockinids.')'); 
                    DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcost=(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id) WHERE b1.id=b2.ItemId AND b2.TransactionsType IN("Purchase") AND b2.HeaderId NOT IN('.$stockinids.')'); 
                }
                else if($recprop->Type == 2){
                    DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,SourceStore,"Stock-In","Undo-Void",ItemType,"'.$doc_num.'","'.$fiscal_yr.'","1","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);
                    
                    DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,RetailerPrice,FiscalYear,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,"Stock-In",ItemType,SellingPrice,'.$fiscal_yr.',"'.$doc_num.'","Undo-Void","'.Carbon::today()->toDateString().'" from deadstockdetails where deadstockdetails.HeaderId='.$findid);
                }
                else{
                    DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,RetailerPrice,FiscalYear,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,"Stock-In",ItemType,SellingPrice,'.$fiscal_yr.',"'.$doc_num.'","Undo-Void","'.Carbon::today()->toDateString().'" from deadstockdetails where deadstockdetails.HeaderId='.$findid);
                }
            }
            
            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "direct-stockin",
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

    public function dstockInForwardAction(Request $request){
        $val_status = ["Draft","Pending","Verified","Approved","Issued","Received"];

        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;

            $sett = DB::table('settings')->latest()->first();
            $fiscalyrcomp = $sett->DSFiscalYear;

            $findid = $request->forwardReqId;
            $req = deadstock::find($findid);
            $currentStatus = $req->Status;
            $newStatus = $request->newForwardStatusValue;
            $action = $request->forwardActionValue;
            $req->Status = $newStatus;
            $doc_num = $req->DocumentNumber;
            $fiscal_yr = $req->FiscalYear;
            $src_store = $req->SourceStore;
            $transaction_type = $req->Type == 1 ? "Purchase" : ($req->Type == 2 ? "Transfer" : "Others");

            $stockinids = deadstock::whereIn('Status', ["Void","Void(Received)"])
                ->pluck('id')
                ->toArray();

            $stockinids = !empty($stockinids) ? implode(', ', $stockinids) : '0';

            if($newStatus == "Verified"){
                $req->CheckedBy = $user;
                $req->CheckedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }

            if($newStatus == "Received"){
                if($req->Type == 1){
                    DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,StoreId,"Stock-In","'.$transaction_type.'",ItemType,"'.$doc_num.'","'.$fiscal_yr.'","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);

                    DB::select('UPDATE regitems as b1 INNER JOIN deadstockdetails as b2 ON b1.id = b2.ItemId SET b1.DeadStockPrice = (SELECT SellingPrice FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid.' AND deadstockdetails.ItemId=b2.ItemId) AND b2.TransactionsType IN("Purchase") AND b2.IsVoid=0 WHERE b2.HeaderId NOT IN('.$stockinids.')'); 
                    DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcosteditable=IF(((SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id)>b1.dsmaxcost),(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id),b1.dsmaxcosteditable) WHERE b1.id=b2.ItemId AND b2.TransactionsType IN("Purchase") AND b2.IsVoid=0 AND b2.HeaderId NOT IN('.$stockinids.')'); 
                    DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.dsmaxcost=(SELECT MAX(UnitCost) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b1.id) WHERE b1.id=b2.ItemId AND b2.TransactionsType IN("Purchase") AND b2.HeaderId NOT IN('.$stockinids.')'); 
                }
                else if($req->Type == 2){
                    DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockOut,UnitPrice,BeforeTaxPrice,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,"'.$src_store.'","Stock-In","Transfer-Out",ItemType,"'.$doc_num.'","'.$fiscal_yr.'","0","'.Carbon::now()->toDateString().'" FROM deadstockdetails WHERE deadstockdetails.HeaderId='.$findid);

                    DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,RetailerPrice,FiscalYear,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,"Stock-In",ItemType,SellingPrice,'.$fiscal_yr.',"'.$doc_num.'","Transfer-In","'.Carbon::today()->toDateString().'" from deadstockdetails where deadstockdetails.HeaderId='.$findid);
                }
                else{
                    DB::select('INSERT INTO deadstocktransaction(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,RetailerPrice,FiscalYear,DocumentNumber,TransactionsType,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,"Stock-In",ItemType,SellingPrice,'.$fiscal_yr.',"'.$doc_num.'","'.$transaction_type.'","'.Carbon::today()->toDateString().'" from deadstockdetails where deadstockdetails.HeaderId='.$findid);
                }

                $req->ReceivedBy = $user;
                $req->ReceivedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }

            $req->save();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "direct-stockin",
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

    public function dstockInBackwardAction(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->backwardReqId;
        $action = $request->backwardActionValue;
        $newStatus = $request->newBackwardStatusValue;
        $req = deadstock::find($findid);
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
                    $req->ReceivedBy = "";
                    $req->ReceivedDate = "";
                }
                $req->save();

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "direct-stockin",
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

    function validateItemBalances($items, $storeId,$fyear, $transactionId = null){
        $negativeItems = [];
        $test = [];
        $trn_type = ["Purchase","Sales","Transfer-In","Transfer-Out"];

        $detail_item = DB::table('deadstockdetails')
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
            $purchaseFound = false;

            foreach ($transactions as $transaction) {
                $runningBalance += ($transaction->StockIn ?? 0);
                $runningBalance -= ($transaction->StockOut ?? 0);

                if ($transaction->HeaderId == $transactionId && $transaction->TransactionType == 'Stock-In') {
                    $purchaseFound = true;
                    $voidqty = 0;
                    
                    // Instead of actual stock_in, use the new value for calculation
                    $runningBalance = $runningBalance - ($transaction->StockIn ?? 0) + $modifiedQuantity;  
                }

                if ($purchaseFound && $runningBalance < 0) {
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
