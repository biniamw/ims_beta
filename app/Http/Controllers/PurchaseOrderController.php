<?php

namespace App\Http\Controllers;
use App\Models\{PurchaseOrder,receiving,Purchasevaulation,Pesuplliers,Purchasevaulationdetail,purchaseOrderDetails,actions,uom,setting,Regitem,customer,store,supplierlog,companyinfo,User,rfq};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Response;
use DataTables;
class PurchaseOrderController extends Controller
{
    public function index(){
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
        
        $pe=Purchasevaulation::join('rfqs','rfqs.id','=','purchasevaulations.rfq')
                ->leftjoin('pesuplliers','purchasevaulations.id','pesuplliers.purchasevaulation_id')
                ->leftjoin('customers','pesuplliers.customers_id','customers.id')
                ->where('purchasevaulations.status',11)
                ->orderBy('purchasevaulations.id','DESC')
                ->get(['rfqs.documentumber as rfqno','customers.Name','customers.TinNumber','purchasevaulations.documentumber','purchasevaulations.id']);
        
        $rfq=rfq::where([['status',3],['evrequire','Required']])->get(['id','documentumber']);
        $item=Regitem::where('id','>',1)->orderby('Code','asc')->get();
        $uom=uom::orderby('id','desc')->get();
        $woreda=DB::select('SELECT regions.Rgn_Name,zones.Zone_Name,woredas.Woreda_Name,woredas.id FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id Where woredas.Type=1');
        
        $data=['Supplier','Customer&Supplier','Person'];
        $customer=customer::whereIn('CustomerCategory',$data)->get(['id','Code','Name','TinNumber','PhoneNumber']);
        $stores=store::where('id','>',1)->orderby('Name','asc')->get();
        $currentdate = Carbon::today()->toDateString();
        $cropyear=DB::select('SELECT lookups.CropYear FROM lookups WHERE lookups.CropYearStatus="Active" ORDER BY lookups.CropYearValue  DESC');
        $grade=DB::select('SELECT lookups.GradeValue,lookups.Grade FROM lookups WHERE lookups.GradeStatus="Active" ORDER BY lookups.Grade  ASC');
        $proccesstype=DB::select('SELECT lookups.ProcessType,lookups.ProcessTypeValue FROM lookups WHERE lookups.ProcessTypeStatus="Active" ORDER BY lookups.ProcessType  ASC');
        return view('pr.purchaseorder',[
            'fiscalyears'=>$fiscalyears,
            'pe'=>$pe,
            'rfq'=>$rfq,
            'item'=>$item,
            'uom'=>$uom,
            'woreda'=>$woreda,
            'customer'=>$customer,
            'stores'=>$stores,
            'todayDate'=>$currentdate,
            'cropyear'=>$cropyear,
            'grade'=>$grade,
            'proccesstype'=>$proccesstype,
        ]);
    }

    function goodsuom($itemid){

        $regitems = DB::table('regitems')->where('id', $itemid)->latest()->first();
        $uomid=$regitems->MeasurementId;
        $cnv=uom::find($uomid);
        $defuom=$cnv->Name;
        $conv=DB::select('SELECT t.id,t.FromUomID,w1.Name AS FromUnitName,t.ToUomID,w2.Name AS ToUnitName,t.Amount,t.ActiveStatus FROM conversions AS t JOIN uoms AS w1 on w1.id=t.FromUomID JOIN uoms AS w2 on w2.id=t.ToUomID WHERE t.FromUomID='.$uomid.' AND t.ActiveStatus="Active"');
            return response()->json([
                'sid'=>$conv,
                'defuom'=>$defuom,
                'uomid'=>$uomid
            ]);

    }
    public function purchaseordereport(){
        $settingsval = DB::table('settings')->latest()->first();
                            $fiscalyr=$settingsval->FiscalYear;
                            $data=['Supplier','Customer&Supplier','Person'];
                            $customer=customer::whereIn('CustomerCategory',$data)->get();
                            $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
                            $cropyear=DB::select('SELECT lookups.CropYear FROM lookups WHERE lookups.CropYearStatus="Active" ORDER BY lookups.CropYearValue  DESC');
                            $grade=DB::select('SELECT lookups.GradeValue,lookups.Grade FROM lookups WHERE lookups.GradeStatus="Active" ORDER BY lookups.Grade  ASC');
                            $proccesstype=DB::select('SELECT lookups.ProcessType,lookups.ProcessTypeValue FROM lookups WHERE lookups.ProcessTypeStatus="Active" ORDER BY lookups.ProcessType  ASC');
                            $woreda=DB::select('SELECT regions.Rgn_Name,zones.Zone_Name,woredas.Woreda_Name,woredas.Wh_name,woredas.id FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id Where woredas.Type=1');
                            $customerSrc=DB::select('SELECT CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber FROM sales INNER JOIN customers ON sales.CustomerId=customers.id WHERE sales.Status="Confirmed" GROUP BY CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber');
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
                            $companyLogo=$compInfo->companyLogo;
                            $companyalladdress=$compInfo->AllAddress;
                            return view('pr.purchaseordereport',[
                                            'fiscalyears'=>$fiscalyears,
                                            'customer'=>$customer,
                                            'proccesstype'=>$proccesstype,
                                            'grade'=>$grade,
                                            'cropyear'=>$cropyear,
                                            'woreda'=>$woreda,
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
                                        ]);
    }

    public function purchaseorderfiltersupplier($from,$to){

                                    $suppliers = PurchaseOrder::join('customers', 'purchaseorders.customers_id','customers.id')
                                    ->whereBetween('purchaseorders.orderdate', [$from, $to])
                                    ->where([['customers.id','>' ,1],['purchaseorders.status',3]])
                                    ->distinct()
                                    ->get([
                                        'customers.id as customer_id',
                                        'customers.Name as customer_name',
                                        'customers.Code as customer_code',
                                        'customers.TinNumber as tin_number',
                                    ]);

            return response()->json([
                    'success' => true, 
                    'message' => 'yes',
                    'supplier' => $suppliers,
                ]);
    }


    public function getgoodstorebalance($itemId, $storeId){
    // Fetch item details
    $itemDetails = DB::table('regitems')
        ->join('categories', 'regitems.CategoryId', '=', 'categories.id')
        ->join('uoms', 'regitems.MeasurementId', '=', 'uoms.id')
        ->select(
            'regitems.id',
            'regitems.MeasurementId',
            'regitems.Type',
            'regitems.Code',
            'regitems.Name',
            'uoms.Name as UOM',
            'categories.Name as Category',
            'regitems.RetailerPrice',
            'regitems.minCost',
            'regitems.Maxcost',
            'regitems.averageCost',
            'regitems.WholesellerPrice',
            'regitems.TaxTypeId',
            'regitems.RequireSerialNumber',
            'regitems.RequireExpireDate',
            'regitems.PartNumber',
            'regitems.Description',
            'regitems.SKUNumber',
            'regitems.BarcodeType',
            'regitems.ActiveStatus',
            'regitems.wholeSellerMinAmount',
            'regitems.MinimumStock',
            'regitems.itemGroup'
        )
        ->where('regitems.id', $itemId)
        ->first();

    if (!$itemDetails) {
        return response()->json(['error' => 'Item not found'], 404);
    }

    // Fetch fiscal year from settings
    $fiscalYear = DB::table('settings')->latest()->value('FiscalYear');

    // Fetch available quantity in the specified store
    $availableQuantity = DB::table('transactions')
        ->where('FiscalYear', $fiscalYear)
        ->where('StoreId', $storeId)
        ->where('ItemId', $itemId)
        ->selectRaw('SUM(COALESCE(StockIn, 0) - COALESCE(StockOut, 0)) as AvailableQuantity')
        ->value('AvailableQuantity') ?? 0;

    // Fetch checked and pending quantities
    $checkedPendingQuantity = DB::table('salesitems')
        ->join('sales', 'salesitems.HeaderId', '=', 'sales.id')
        ->where('sales.Status', 'pending..')
        ->orWhere('sales.Status', 'Checked')
        ->where('sales.fiscalyear', $fiscalYear)
        ->where('salesitems.ItemId', $itemId)
        ->selectRaw('COALESCE(SUM(salesitems.Quantity), 0) as CheckedQuantity')
        ->value('CheckedQuantity') ?? 0;

    // Fetch pending quantity in the specified store
    $pendingQuantityInStore = DB::table('salesitems')
        ->join('sales', 'salesitems.HeaderId', '=', 'sales.id')
        ->whereIn('sales.Status', ['pending..', 'Checked'])
        ->where('sales.fiscalyear', $fiscalYear)
        ->where('salesitems.StoreId', $storeId)
        ->where('salesitems.ItemId', $itemId)
        ->selectRaw('COALESCE(SUM(salesitems.Quantity), 0) as pendinquantityinstore')
        ->value('pendinquantityinstore') ?? 0;

    // Fetch all available quantities across all active stores
    $allAvailableQuantity = DB::table('transactions')
        ->where('FiscalYear', $fiscalYear)
        ->whereIn('StoreId', function ($query) {
            $query->select('id')
                ->from('stores')
                ->where('ActiveStatus', 'Active');
        })
        ->where('ItemId', $itemId)
        ->selectRaw('SUM(COALESCE(StockIn, 0) - COALESCE(StockOut, 0)) as AllAvailableQuantity')
        ->value('AllAvailableQuantity') ?? 0;

    // Return the response as JSON
    return response()->json([
        'success' => 200, 
        'Regitem' => $itemDetails,
        'getQuantity' => $availableQuantity,
        'getAllQuantity' => $allAvailableQuantity,
        'getCheckedPending' => $checkedPendingQuantity,
        'pendinquantityinstore' => $pendingQuantityInStore,
    ]);
}

            
            public function purchaseordergetcommodtyperpo(Request $request){
            $purchaseorder='';
            $poaray=[];
            $pyrarray=[];
            $supplierarray=[];
            $options = $request->input('options');
            $supplier=$request->input('supplier');

            if (is_array($supplier)) {
                foreach ($supplier as $supplier) {
                    $supplierarray[]=$supplier;
                }
            }
            $supplierarray=array_map('intval', $supplierarray);
            if (is_array($options)) {
                foreach ($options as $options) {
                    $poaray[]=$options;
                }
            }
            $poaray=array_map('intval', $poaray);
            
            $py=PurchaseOrder::whereIn('purchasevaulation_id', $poaray)
                ->whereIn('customers_id', $supplierarray)->get(['id']);
            
            $count=PurchaseOrder::whereIn('purchasevaulation_id',$poaray)->count();
            foreach ($py as $key => $value) {
                $pyrarray[]=$value->id;
            }
            
            $data=purchaseOrderDetails::join('woredas','purchaseordersdetails.itemid','woredas.id')
                    ->join('zones','woredas.zone_id','zones.id')
                    ->join('regions','zones.Rgn_Id','regions.id')
                    ->join('uoms','purchaseordersdetails.uom','uoms.id')
                    ->orderby('purchaseordersdetails.id','ASC')
                    ->whereIn('purchaseordersdetails.purchaseorder_id',$pyrarray)
                    ->distinct()
                    ->get([ DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS origin'),
                            'purchaseordersdetails.itemid as supplyworeda',
                            ]);
                            
            return response()->json([
                        'success' => true, 
                        'count' => $count,
                        'data' => $data,
                    ]);
        }

            public function purchaseordereportdispaly(Request $request){
                        $validator = Validator::make($request->all(), [
                        'fiscalYear' => ['required'],
                        'from' => ['required'],
                        'to' => ['required'],
                        'supplier' => ['required'],
                        'purchaseorder' => ['required'],
                        'commodity' => ['required'],
                        'preparation' => ['required'],
                        'cropyear' => ['required'],
                        'grade' => ['required'],
                        'status' => ['required'], 
                        'taxable' => ['required'],
                    ]);
        if ($validator->passes()) {
                    $supplierarray=[];
                    $poarray=[];
                    $pyrarray=[];
                    $commodityarray=[];
                    $preparationarray=[];
                    $cropyeararray=[];
                    $gradearray=[];
                    $statusarray=[];
                    $taxablearray=[];
                    $from=$request->input('from');
                    $to =$request->input('to');
                    $supplier=$request->input('supplier');
                    $taxable=$request->input('taxable');
                        foreach($taxable as $key){
                            $taxablearray[]=$key;
                        }
                        foreach($supplier as $key){
                            $supplierarray[]=$key;
                        }
                        $purchaseorder=$request->input('purchaseorder');
                        foreach($purchaseorder as $key){
                            $poarray[]=$key;
                        }
                        $status=$request->input('status');
                        foreach($status as $key){
                            $statusarray[]=$key;
                        }    
                        $taxablearray=array_map('intval', $taxablearray);
                        $statusarray=array_map('intval', $statusarray);
                        $supplierarray=array_map('intval', $supplierarray);
                        $supplierlist =  implode(',', $supplierarray);
                        $poarray=array_map('intval', $poarray);
                        $polist =  implode(',', $poarray);

                    $data = PurchaseOrder::select(
                            DB::raw("CONCAT('Purchase Order#:', purchaseorders.porderno, ', Date:', purchaseorders.orderdate) AS DocumentNo"),
                            DB::raw("CONCAT(customers.Name, ' ', customers.TinNumber) AS SupplierName"),
                            DB::raw("CONCAT(regions.Rgn_Name, ' ', zones.Zone_Name, ' ', woredas.Woreda_Name) AS Commodity"),
                            'purchasevaulations.documentumber as PE',
                            'purchasevaulations.id as peid',
                            'purchaseorders.type',
                            'purchaseordersdetails.grade',
                            'purchaseordersdetails.cropyear',
                            'purchaseordersdetails.proccesstype',
                            'uoms.Name AS UOM',
                            'purchaseordersdetails.qty AS NoOfBag',
                            'purchaseordersdetails.bagweight',
                            'purchaseordersdetails.totalkg',
                            'purchaseordersdetails.netkg',
                            'purchaseordersdetails.ton',
                            'purchaseordersdetails.feresula',
                            'purchaseordersdetails.price',
                            'purchaseordersdetails.total',
                            'purchaseorders.istaxable',
                            'purchaseorders.id as poid',
                            'purchaseorders.status', )
                            ->leftJoin('purchasevaulations', 'purchaseorders.purchasevaulation_id', '=', 'purchasevaulations.id')
                            ->leftJoin('purchaseordersdetails', 'purchaseorders.id', '=', 'purchaseordersdetails.purchaseorder_id')
                            ->leftJoin('customers', 'purchaseorders.customers_id', '=', 'customers.id')
                            ->leftJoin('woredas', 'purchaseordersdetails.itemid', '=', 'woredas.id')
                            ->leftJoin('zones', 'woredas.zone_id', '=', 'zones.id')
                            ->leftJoin('regions', 'zones.Rgn_Id', '=', 'regions.id')
                            ->leftJoin('uoms', 'purchaseordersdetails.uom', '=', 'uoms.id')
                            ->whereBetween('purchaseorders.orderdate', [$from, $to])
                            ->whereIn('purchaseorders.status', $statusarray)
                            ->whereIn('purchaseorders.istaxable', $taxablearray)
                            ->whereIn('purchaseorders.customers_id', $supplierarray)
                            ->whereIn('purchaseorders.purchasevaulation_id', $poarray)
                            ->orderBy('purchaseorders.id', 'desc') // Order by purchase order ID
                            ->get();
                        
                                return datatables()->of($data)->addIndexColumn()->toJson();
                    }

                else if($validator->fails()){
                                    return response()->json([
                                        'success' => false,
                                        'message' => 'Validation failed',
                                        'errors' => $validator->errors(),
                                    ],422);
                    }
                    else{
                            
                        return Response::json(['errorv2' => $v2->errors()->all()]);
                            }
                    
            }
            public function purchaseordergetporeference(Request $request){
                    $options = $request->input('options'); // Retrieve the array of selected values
                    $from=$request->input('from');
                    $to=$request->input('to');
                    $supplier=[];
                    $referarray=[];
                    if (is_array($options)) {
                        foreach ($options as $options) {
                            $supplier[]=$options;
                        }
                    }
                    $supplier=array_map('intval', $supplier);
                    
                    $purchaseOrders = PurchaseOrder::leftJoin('purchasevaulations', 'purchaseorders.purchasevaulation_id', 'purchasevaulations.id')
                                    ->whereIn('purchaseorders.customers_id', $supplier)
                                    
                                    ->whereBetween('purchaseorders.orderdate', [$from, $to])
                                    ->where([['purchasevaulations.id', '>', 1],['purchaseorders.status', 3]])
                                    
                                    ->select('purchasevaulations.id', 'purchasevaulations.documentumber')
                                    ->distinct()
                                    ->get();

                    return response()->json([
                            'success' => true, 
                            'supplier' => $supplier,
                            'from' => $from,
                            'to' => $to,
                            'purchaseorder' => $purchaseOrders,
                        ]);
            }

    public function purchaseordelist(){
            $budget=setting::where('id',1)->first()->budget;
            $update=PurchaseOrder::where([['subtotal','>',$budget],['status',2],['isreviewed',0]])->update(['oldstatus'=>DB::raw('status'),'status'=>6]);
        $po=PurchaseOrder::join('purchasevaulations','purchaseorders.purchasevaulation_id','purchasevaulations.id')
                        ->join('customers','purchaseorders.customers_id','customers.id')
                        ->orderby('purchaseorders.id','Desc')
                        ->get(['purchaseorders.porderno','purchaseorders.purchaseordertype','purchaseorders.type','purchaseorders.orderdate','purchaseorders.deliverydate','customers.TinNumber as TIN','customers.Name as supllier',
                        'purchasevaulations.documentumber','purchasevaulations.id as peid','purchaseorders.date','purchaseorders.status','purchaseorders.id','purchaseorders.netpay'
                    ]);
        return datatables()->of($po)->addIndexColumn()->toJson();
    }
    public function pocheckreview(){
            $budget=setting::where('id',1)->first()->budget;
            $update=PurchaseOrder::where([['subtotal','>',$budget],['status',2],['isreviewed',0]])->update(['oldstatus'=>DB::raw('status'),'status'=>6]);
            $reviewporder=PurchaseOrder::whereIn('status',[6,7])->where('subtotal','>',$budget)->count();
            return Response::json(['success' =>200,
            'reviewporder'=>$reviewporder,
            'budget'=>$budget,
        ]);
    }

    function poreviewlist(){
            $budget=setting::where('id',1)->first()->budget;
            $reviewsales=PurchaseOrder::whereIn('purchaseorders.status',[6,7])->where('subtotal','>',$budget)->count();
                    return Response::json(['success' =>200,
                    'reviewsales'=>$reviewsales,
                ]);
    }

    public function poreviewlisting(){
        $po=PurchaseOrder::join('purchasevaulations','purchaseorders.purchasevaulation_id','purchasevaulations.id')
        ->join('customers','purchaseorders.customers_id','customers.id')
        ->whereIn('purchaseorders.status',[6,7])
        ->orderby('purchaseorders.id','Desc')
        ->get(['purchaseorders.porderno','purchaseorders.type','purchaseorders.orderdate','purchaseorders.deliverydate','customers.TinNumber as TIN','customers.Name as supllier',
        'purchasevaulations.documentumber','purchasevaulations.id as peid','purchaseorders.date','purchaseorders.status','purchaseorders.id','purchaseorders.isreviewed'
        ]);
        return datatables()->of($po)->addIndexColumn()->toJson();
    }

    public function poundoprpermit($checkid){
        try {
            $currentTime = now();
            $user=Auth()->user()->FullName;
            $checkid=explode(",",$checkid);
            $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            $reviewby=' Undo Reviewed by '.$user.' on '.$day;
            $update=PurchaseOrder::whereIn('id',$checkid)->update(['isreviewed'=>0,'status'=>6]);
            
            return Response::json(['success' => 200,
                                ]);
        } catch (\Throwable $th) {
            return Response::json(['error' => $e->getMessage() ,
                                ]);
        }
    }
    public function poprpermit($checkid){
            try {
            $currentTime =now();
            $user=Auth()->user()->FullName;
            $checkid=explode(",",$checkid);
            $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            $reviewby=' Reviewed by '.$user.' on '.$day;
            $update=PurchaseOrder::whereIn('id',$checkid)->update(['isreviewed'=>1,'status'=>7]);
                
            return Response::json(['success' => 200,
                                    ]);
        } catch (Throwable $e) {
            return Response::json(['error' => $e->getMessage() ,
                                    ]);
        }
    }
    public function getpassedpev($pe){
        $type=Purchasevaulation::where('id',$pe)->first()->type;
        $pev=Purchasevaulation::where('id',$pe)->get();
        
        $supplier=Purchasevaulation::join('pesuplliers','purchasevaulations.id','=','pesuplliers.purchasevaulation_id')
                ->join('customers','pesuplliers.customers_id','=','customers.id')
                ->join('purchasevaulationdetails','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                ->where([['pesuplliers.purchasevaulation_id',$pe],['purchasevaulationdetails.evstatus','Approved']])
                ->distinct()
                ->get(['customers.id as customerid','pesuplliers.id as psid',
                DB::raw('CONCAT(customers.Name,",",customers.Code,",",customers.TinNumber) as Name'),
                'pesuplliers.Code as suppliercode','pesuplliers.phone','pesuplliers.recievedate']);

        $comiditylist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
            ->join('zones','woredas.zone_id','zones.id')
            ->join('regions','zones.Rgn_Id','regions.id')
            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
            ->join('customers','pesuplliers.customers_id','customers.id')
            ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
            ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
            ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
            ->join('woredas as evalworeda','purchasevaulationdetails.evrequesteditemid','evalworeda.id')
            ->join('zones as evalzones','evalworeda.zone_id','evalzones.id')
            ->join('regions as evalregions','evalzones.Rgn_Id','evalregions.id')
            ->orderby('purchasevaulationdetails.evrequesteditemid','ASC')
            ->orderby('purchasevaulationdetails.rank','ASC')
            ->where('purchasevaulationdetails.purchasevaulation_id',$pe)

            ->get([ DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                    DB::raw('CONCAT(evalregions.Rgn_Name," ",evalzones.Zone_Name," ",evalworeda.Woreda_Name ) AS supplyorigin'),
                    DB::raw('CONCAT(customers.Name," ",customers.TinNumber) as customername'),
                    'pesuplliers.id as supplierid',
                    'regions.Rgn_Name','zones.Zone_Name','reqworeda.Woreda_Name AS requestworedname','woredas.Woreda_Name as woredname',
                    'woredas.id as woredaid','purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype',
                    'purchasevaulationdetails.sampleamount','purchasevaulationdetails.evmoisture','purchasevaulationdetails.screensieve',
                    'purchasevaulationdetails.evcupvalue','purchasevaulationdetails.evscore','purchasevaulationdetails.remark','purchasevaulationdetails.description',
                    'purchasevaulationdetails.evstatus','purchasevaulationdetails.evstatus as qualityapproval','purchasevaulationdetails.fevstatus','purchasevaulationdetails.bagamount',
                    'purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','pesuplliers.recievedate',
                    'purchasevaulationdetails.customerprice','purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice',
                    'purchasevaulationdetails.rank','purchasevaulationdetails.dense_rank','purchasevaulationdetails.row_number'
                    ]);
            

        return Response::json([
                'success' =>200,
                'type'=>$type,
                'pev'=>$pev,
                'supplier'=>$supplier,
                'comiditylist'=>$comiditylist,
                
        ]);
    }

    public function getpordersupplier($pe,$supplierid){
        $pesupplierid=Pesuplliers::where([['purchasevaulation_id',$pe],['customers_id',$supplierid]])->first()->id;
        $type=Purchasevaulation::where('id',$pe)->first()->type;
        return Response::json([
                'success' =>200,
                'type'=>$type,
                'pesupplierid'=>$pesupplierid,
        ]);
    }
    public function getpordersupplierdatas($pe){
        $comiditylist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
            ->join('zones','woredas.zone_id','zones.id')
            ->join('regions','zones.Rgn_Id','regions.id')
            ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
            ->join('customers','pesuplliers.customers_id','customers.id')
            ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
            ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
            ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
            ->join('woredas as evalworeda','purchasevaulationdetails.evrequesteditemid','evalworeda.id')
            ->join('zones as evalzones','evalworeda.zone_id','evalzones.id')
            ->join('regions as evalregions','evalzones.Rgn_Id','evalregions.id')
            ->orderby('purchasevaulationdetails.evrequesteditemid','ASC')
            ->orderby('purchasevaulationdetails.rank','ASC')
            ->where('purchasevaulationdetails.purchasevaulation_id',$pe)

            ->get([ DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                    DB::raw('CONCAT(evalregions.Rgn_Name," ",evalzones.Zone_Name," ",evalworeda.Woreda_Name," ",purchasevaulationdetails.cropyear," ",purchasevaulationdetails.proccesstype) AS supplyorigin'),
                    DB::raw('CONCAT(customers.Name," ",customers.TinNumber) as customername'),
                    'pesuplliers.id as supplierid',
                    'regions.Rgn_Name','zones.Zone_Name','reqworeda.Woreda_Name AS requestworedname','woredas.Woreda_Name as woredname',
                    'purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype','purchasevaulationdetails.sampleamount',
                    'purchasevaulationdetails.evmoisture','purchasevaulationdetails.screensieve','purchasevaulationdetails.evcupvalue',
                    'purchasevaulationdetails.evscore','purchasevaulationdetails.remark','purchasevaulationdetails.description',
                    'purchasevaulationdetails.evstatus','purchasevaulationdetails.evstatus as qualityapproval','purchasevaulationdetails.fevstatus','purchasevaulationdetails.bagamount',
                    'purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','pesuplliers.recievedate',
                    'purchasevaulationdetails.customerprice','purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice',
                    'purchasevaulationdetails.rank','purchasevaulationdetails.dense_rank','purchasevaulationdetails.row_number'
                    ]);
        //return datatables()->of($comiditylist)->addIndexColumn()->toJson();

        return Response::json([
                'success' =>200,
                'comiditylist'=>$comiditylist,
            
        ]);

    }
    public function directgoodlist($id){
                $comiditylist=purchaseOrderDetails::join('regitems','purchaseordersdetails.itemid','regitems.id')
                    ->join('uoms','purchaseordersdetails.uom','uoms.id')
                    ->orderby('purchaseordersdetails.itemid','ASC')
                    ->where('purchaseordersdetails.purchaseorder_id',$id)
                    ->get([ DB::raw('CONCAT(regitems.Code," ", regitems.Name," ",regitems.SKUNumber) AS item'),
                            'regitems.Code','regitems.Name','regitems.SKUNumber','purchaseordersdetails.itemid as goodid','purchaseordersdetails.id as pdetailid',
                            'purchaseordersdetails.uom','purchaseordersdetails.qty','purchaseordersdetails.price', 'purchaseordersdetails.Total',
                            'uoms.Name as uomname','uoms.id as uomid','uoms.uomamount'
                            ]);
                        return datatables()->of($comiditylist)->addIndexColumn()->toJson();
    }

    public function directcommoditylist($id){
                $comiditylist=purchaseOrderDetails::join('woredas','purchaseordersdetails.itemid','woredas.id')
                    ->join('zones','woredas.zone_id','zones.id')
                    ->join('regions','zones.Rgn_Id','regions.id')
                    ->join('uoms','purchaseordersdetails.uom','uoms.id')
                    ->orderby('purchaseordersdetails.itemid','ASC')
                    ->where('purchaseordersdetails.purchaseorder_id',$id)
                    ->get([ DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS origin'),
                            'purchaseordersdetails.itemid as supplyworeda','purchaseordersdetails.id as pdetailid',
                            'purchaseordersdetails.cropyear','purchaseordersdetails.proccesstype','purchaseordersdetails.uom','purchaseordersdetails.qty',
                            'purchaseordersdetails.qty','purchaseordersdetails.totalKg','purchaseordersdetails.feresula','purchaseordersdetails.price',
                            'purchaseordersdetails.Total','purchaseordersdetails.status','purchaseordersdetails.id','purchaseordersdetails.rank',
                            'purchaseordersdetails.grade','purchaseordersdetails.ton','purchaseordersdetails.netkg','purchaseordersdetails.bagweight',
                            'uoms.Name as uomname','uoms.id as uomid','uoms.uomamount'
                            ]);
                        return datatables()->of($comiditylist)->addIndexColumn()->toJson();
    }
    public function poinfo($id){
            $storename='';
            $supplier='';
            $peid=PurchaseOrder::where('id',$id)->first()->purchasevaulation_id;
            $type=Purchasevaulation::where('id',$peid)->first()->type;
            $pedocno=Purchasevaulation::where('id',$peid)->first()->documentumber;
            $po=PurchaseOrder::where('id',$id)->get();
            $storeid=PurchaseOrder::where('id',$id)->first()->store;
            $potype=PurchaseOrder::where('id',$id)->first()->type;
            $customerid=PurchaseOrder::where('id',$id)->first()->customers_id;
            $customer=customer::where('id',$customerid)->get(['Code','Name','TinNumber']);
            $created_at=PurchaseOrder::where('id',$id)->first()->created_at;
            $createdAtInAddisAbaba = Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            switch ($potype) {
                case 'Direct':
                case 'PE':
                    $exist=store::where('id',$storeid)->exists();
                    switch ($exist) {
                        case true:
                            $storename=store::where('id',$storeid)->first()->Name;
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                    
                    break;
                
                default:
                $supplier=Purchasevaulation::join('pesuplliers','purchasevaulations.id','=','pesuplliers.purchasevaulation_id')
                    ->join('customers','pesuplliers.customers_id','=','customers.id')
                    ->orderby('pesuplliers.row_number','ASC')
                    ->where('pesuplliers.purchasevaulation_id',$peid)
                    ->get(['pesuplliers.id','pesuplliers.purchasevaulation_id as peid','pesuplliers.docno','pesuplliers.customers_id as customerid',
                                    'customers.Name','customers.Code','customers.TinNumber','pesuplliers.phone','pesuplliers.recievedate','pesuplliers.status',
                                    'pesuplliers.orderdate','pesuplliers.deliverydate'
                                ]);
                    break;
            }

            $actions=actions::join('users','actions.user_id','=','users.id')
                ->where([['pageid',$id],['actions.pagename','po']])
                ->orderBy('actions.id','DESC')
                ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);

            return Response::json([
                'success' =>200,
                'pedocno'=>$pedocno,
                'createdAtInAddisAbaba'=>$createdAtInAddisAbaba,
                'po'=>$po,
                'supplier'=>$supplier,
                'storename'=>$storename,
                'type'=>$type,
                'peid'=>$peid,
                'customer'=>$customer,
                'actions'=>$actions,

        ]);
    }

    public function poedit($id){
            $peid=PurchaseOrder::where('id',$id)->first()->purchasevaulation_id;
            $type=PurchaseOrder::where('id',$id)->first()->type;
            $type=PurchaseOrder::where('id',$id)->first()->type;
            $pedocno=Purchasevaulation::where('id',$peid)->first()->documentumber;
            $po=PurchaseOrder::where('id',$id)->get();
            
            switch ($type) {
                case 'Direct':
                case 'PE':   
                    $commoditylist=$this->getdirectorderlists($id);
                    break;
                
                default:
                    $commoditylist=0;
                    break;
            }
        
            return Response::json([
                'success' =>200,
                'pedocno'=>$pedocno,
                'peid'=>$peid,
                'po'=>$po,
                'type'=>$type,
                'peid'=>$peid,
                'commoditylist'=>$commoditylist,
        ]);
    }
    public function getdirectorderlists($id){
        $type=PurchaseOrder::where('id',$id)->first()->purchaseordertype;
            switch ($type) {
                case 'Goods':
                    $comiditylist=purchaseOrderDetails::join('regitems','purchaseordersdetails.itemid','regitems.id')
                    ->join('uoms','purchaseordersdetails.uom','uoms.id')
                    ->orderby('purchaseordersdetails.itemid','ASC')
                    ->where('purchaseordersdetails.purchaseorder_id',$id)
                    ->get([ DB::raw('CONCAT(regitems.Code," ", regitems.Name," ",regitems.SKUNumber) AS item'),
                            'regitems.id as itemid','regitems.Code','regitems.Name','regitems.SKUNumber','purchaseordersdetails.itemid as goodid','purchaseordersdetails.id as pdetailid',
                            'purchaseordersdetails.uom','purchaseordersdetails.qty','purchaseordersdetails.price', 'purchaseordersdetails.Total',
                            'uoms.Name as uomname','uoms.id as uomid','uoms.uomamount'
                            ]);
                    break;
                
                default:

                        $comiditylist=purchaseOrderDetails::join('woredas','purchaseordersdetails.itemid','woredas.id')
                        ->join('zones','woredas.zone_id','zones.id')
                        ->join('regions','zones.Rgn_Id','regions.id')
                        ->join('uoms','purchaseordersdetails.uom','uoms.id')
                        ->orderby('purchaseordersdetails.itemid','ASC')
                        ->where('purchaseordersdetails.purchaseorder_id',$id)
                        ->get([ DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS origin'),
                                'purchaseordersdetails.itemid as supplyworeda','purchaseordersdetails.cropyear','purchaseordersdetails.proccesstype','purchaseordersdetails.uom',
                                'purchaseordersdetails.qty','purchaseordersdetails.qty','purchaseordersdetails.totalKg','purchaseordersdetails.feresula','purchaseordersdetails.price',
                                'purchaseordersdetails.Total','purchaseordersdetails.status','purchaseordersdetails.id','purchaseordersdetails.rank',
                                'uoms.Name as uomname','uoms.id as uomid','uoms.uomamount','uoms.bagweight as uombagweight','purchaseordersdetails.grade','purchaseordersdetails.bagweight','purchaseordersdetails.ton','purchaseordersdetails.netkg'
                                ]);
                    break;
            }
                            return $comiditylist;
    }
    public function showsupplierpo($id){
    $supplier=Purchasevaulation::join('pesuplliers','purchasevaulations.id','=','pesuplliers.purchasevaulation_id')
                ->join('customers','pesuplliers.customers_id','=','customers.id')
                ->orderby('pesuplliers.row_number','ASC')
                ->where('pesuplliers.purchasevaulation_id',$id)
                ->get(['pesuplliers.id','pesuplliers.purchasevaulation_id as peid','pesuplliers.docno','pesuplliers.customers_id as customerid',
                'customers.Name','customers.Code','customers.TinNumber','pesuplliers.phone','pesuplliers.recievedate','pesuplliers.status','pesuplliers.orderdate','pesuplliers.deliverydate']);
        return datatables()->of($supplier)->addIndexColumn()->toJson();
}

    public function getwineditems($headerid,$id){
                    $rank='';
                    $peid=Pesuplliers::where('id',$id)->first()->purchasevaulation_id;
                    $docno=Pesuplliers::where('id',$id)->first()->docno;
                    $supplinfo=Pesuplliers::where('id',$id)->get();
                    $headerexist=purchaseOrderDetails::where('purchaseorder_id',$headerid)->exists();
                    //$headerexist=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['pesupllier_id',$id]])->exists();
                    $rank=Pesuplliers::where('id',$id)->first()->row_number;
                    
                    switch ($headerexist) {
                        case true:
                            $comiditylist=$this->commodityfromorders($headerid,$id,$peid);
                           // $rank=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['pesupllier_id',$id]])->latest()->first()->rank;
                            $from='orders';
                            break;
                            //$rank=1;
                        default:
                            $comiditylist=$this->commodityfromevualation($id,$peid);
                            $from='evaluation';
                            //$rank=0;
                            break;
                    }
                        $actions=actions::join('users','actions.user_id','=','users.id')
                                ->where([['pageid',1],['actions.pagename',$id]])
                                ->orderBy('actions.id','DESC')
                                ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
                                
                return Response::json([
                'success' =>200,
                'rank' =>$rank,
                'headerexist' =>$headerexist,
                'from' =>$from,
                'supplinfo' =>$supplinfo,
                'actions' =>$actions,
                'comiditylist' =>$comiditylist,
        ]);
    }
    public function checkfordupplication($headerid,$itemid,$supplierid){
        $exist=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['itemid',$itemid],['status','Confirm'],['pesupllier_id','!=',$supplierid]])->exists();

        return Response::json([
            'success' =>200,
            'exist' =>$exist,
        ]);
    }
    public function addorderdata($headerid,$id){
        $item=[];
        $noteinitem=[];
        $rankarray=[];
        $cancelexist='';
        $cancelcount='';
        $exist='';
        $cancelitem='';
        $confirmitem='';
        $confirmwitheader='';
        $count='';
        $rk='';
        $headeritem='';
        $headeritemarray=[];
        $prevoiusrankitemexist=-1;
        $prevoiusrank=-1;
        $logic=0;
        $pevid=Pesuplliers::where('id',$id)->first()->purchasevaulation_id;
        $type=Purchasevaulation::where('id',$pevid)->first()->type;
        $headerexist=purchaseOrderDetails::where('purchaseorder_id',$headerid)->exists();
        switch ($headerexist) {
            case false:
                    $rank=1;
                    $logic=1;
                    $comiditylist=$this->wininitemsbyfirstrank($id,$pevid,$rank);
                break;
                
            default:
                    $logic=2;
                    $exist=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['pesupllier_id',$id]])->exists();
                    $confirmitem=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Confirm'],['pesupllier_id', '!=', $id]])->distinct('itemid')->get(['itemid']);
                    $confirmwitheader=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Confirm'],['pesupllier_id', $id]])->distinct('itemid')->get(['itemid']);
                    //$cancelitem=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Cancel'],['pesupllier_id', '!=', $id]])->distinct('itemid')->get(['itemid']);
                        foreach($confirmitem as $st){
                            $noteinitem[]=$st->itemid;
                        }
                        $count=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Cancel'],['pesupllier_id','!=',$id]] )->distinct('rank')->count('rank');
                    switch ($exist) {
                        case true:
                            $logic=3;
                            $headeritem=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['pesupllier_id', $id]])->distinct('itemid')->get(['itemid']);

                            $cancelitem=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Cancel'],['pesupllier_id', '!=', $id]])->distinct('itemid')->get(['itemid']);
                            $confirmitem=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Confirm']])->distinct('itemid')->get(['itemid']);
                            foreach($confirmitem as $st){
                                    $headeritemarray[]=$st->itemid;
                                }
                            foreach($cancelitem as $st){
                                    $item[]=$st->itemid;
                                }
                            $rank=Pesuplliers::where('id',$id)->first()->row_number;
                                    $prevoiusrank=$rank-1;
                                        if((int)$prevoiusrank>0){
                                            // find cancel item
                                            $logic=4;
                                            $cancelitem=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Cancel'],['rank',$prevoiusrank]])->distinct('itemid')->get(['itemid']);
                                            $item=[];
                                            foreach($cancelitem as $st){
                                                $item[]=$st->itemid;
                                            }
                                            $itemwithissupplier=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['pesupllier_id', $id]])->distinct('itemid')->get(['itemid']);
                                            $headeritemarray=[];
                                            foreach($itemwithissupplier as $st){
                                                $headeritemarray[]=$st->itemid;
                                            }
                                            
                                        } else{
                                            $logic=5;
                                        }

                                        // $prevoiusrankitemexist=purchaseOrderDetails::whereNotIn('itemid',$item)->whereIn('itemid',$item)->where([['purchaseorder_id',$headerid],['status','Cancel'],['rank',$prevoiusrank],['pesupllier_id', '!=', $id]])->exists();
                                        // switch ($prevoiusrankitemexist) {
                                        //     case false:
                                        //         $logic=5;
                                        //         $item=[];
                                        //         break;
                                            
                                        //     default:
                                        //         $logic=6;
                                        //         break;
                                        // }
                            //$rank=$count+1;
                        break;
                        default:
                            $logic=6;
                            $cancelexist=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Cancel']])->exists();
                            $cancelcount=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Cancel']] )->distinct('rank')->count('rank');
                            switch ($cancelexist) {
                                case true:
                                    $logic=7;
                                    $cancelitem=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Cancel'],['pesupllier_id', '!=', $id]])->distinct('itemid')->get(['itemid']);
                                    $confirmitem=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['status','Confirm'],['pesupllier_id', '!=', $id]])->distinct('itemid')->get(['itemid']);
                                    foreach($cancelitem as $st){
                                        $item[]=$st->itemid;
                                        }
                                        foreach($confirmitem as $st){
                                                $headeritemarray[]=$st->itemid;
                                            }
                                    
                                    $rank=Pesuplliers::where('id',$id)->first()->row_number;
                                        $prevoiusrank=$rank-1;
                                        $prevoiusrankitemexist=purchaseOrderDetails::whereIn('itemid',$item)->where([['purchaseorder_id',$headerid],['status','Cancel'],['rank',$prevoiusrank],['pesupllier_id', '!=', $id]])->exists();
                                        switch ($prevoiusrankitemexist) {
                                            case false:
                                                $logic=8;
                                                $item=[];
                                                break;
                                            
                                            default:
                                                $logic=9;
                                                break;
                                        }
                                    
                                    break;
                                    
                                default:
                                    $logic=10;
                                    $rank=1;
                                    break;
                            }

                        break;
                    }
                    $comiditylist=$this->wininitemsbyrank($id,$pevid,$rank,$headeritemarray,$item);
                break;
        }
        
        return Response::json([
            'success' =>200,
            'logic' =>$logic,
            'type' =>$type,
            'id' =>$id,
            'type' =>$type,
            'pevid' =>$pevid,
            'headerexist' =>$headerexist,
            'exist' =>$exist,
            'cancelexist' =>$cancelexist,
            'cancelitem' =>$cancelitem,
            'headeritem' =>$headeritem,
            'item' =>$item,
            'headeritemarray' =>$headeritemarray,
            'rankarray' =>$rankarray,
            'confirmitem' =>$confirmitem,
            'noteinitem' =>$noteinitem,
            'count' =>$count,
            'cancelcount' =>$cancelcount,
            'rank' =>$rank,
            'prevoiusrank' =>$prevoiusrank,
            'prevoiusrankitemexist' =>$prevoiusrankitemexist,
            'comiditylist' =>$comiditylist,
        ]);

    }
    public function wininitemsbyrank($id,$peid,$rank,$noteinitem,$item){
            $comiditylist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
                    ->join('zones','woredas.zone_id','zones.id')
                    ->join('regions','zones.Rgn_Id','regions.id')
                    ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                    ->join('customers','pesuplliers.customers_id','customers.id')
                    ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
                    ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
                    ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
                    ->join('woredas as evalworeda','purchasevaulationdetails.evrequesteditemid','evalworeda.id')
                    ->join('zones as evalzones','evalworeda.zone_id','evalzones.id')
                    ->join('regions as evalregions','evalzones.Rgn_Id','evalregions.id')
                    ->orderby('purchasevaulationdetails.evrequesteditemid','ASC')
                    ->where([['purchasevaulationdetails.purchasevaulation_id',$peid],['purchasevaulationdetails.pesupllier_id',$id],['purchasevaulationdetails.row_number',$rank]])
                    ->whereNotIn('purchasevaulationdetails.evrequesteditemid',$noteinitem)
                    ->whereIn('purchasevaulationdetails.evrequesteditemid',$item)
                    ->get([ DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                            DB::raw('CONCAT(evalregions.Rgn_Name," ",evalzones.Zone_Name," ",evalworeda.Woreda_Name) AS supplyorigin'),
                            'purchasevaulationdetails.evrequesteditemid as supplyworeda',
                            DB::raw('CONCAT(customers.code," ", customers.Name) as customername'),
                            'regions.Rgn_Name','zones.Zone_Name','reqworeda.Woreda_Name AS requestworedname','woredas.Woreda_Name as woredname',
                            'purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype','purchasevaulationdetails.sampleamount',
                            'purchasevaulationdetails.evmoisture','purchasevaulationdetails.screensieve','purchasevaulationdetails.evcupvalue',
                            'purchasevaulationdetails.evscore','purchasevaulationdetails.remark','purchasevaulationdetails.description',
                            'purchasevaulationdetails.evstatus','purchasevaulationdetails.evstatus as qualityapproval','purchasevaulationdetails.fevstatus','purchasevaulationdetails.bagamount',
                            'purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','pesuplliers.recievedate',
                            'purchasevaulationdetails.customerprice','purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice','purchasevaulationdetails.row_number as rank'
                            ]);

                            return $comiditylist;
    }

    public function wininitemsbyfirstrank($id,$peid,$rank){
            $comiditylist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
                    ->join('zones','woredas.zone_id','zones.id')
                    ->join('regions','zones.Rgn_Id','regions.id')
                    ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                    ->join('customers','pesuplliers.customers_id','customers.id')
                    ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
                    ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
                    ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
                    ->join('woredas as evalworeda','purchasevaulationdetails.evrequesteditemid','evalworeda.id')
                    ->join('zones as evalzones','evalworeda.zone_id','evalzones.id')
                    ->join('regions as evalregions','evalzones.Rgn_Id','evalregions.id')
                    ->orderby('purchasevaulationdetails.evrequesteditemid','ASC')
                    ->where([['purchasevaulationdetails.purchasevaulation_id',$peid],['purchasevaulationdetails.pesupllier_id',$id],['purchasevaulationdetails.row_number',$rank]])
                    ->get([ DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                            DB::raw('CONCAT(evalregions.Rgn_Name," ",evalzones.Zone_Name," ",evalworeda.Woreda_Name) AS supplyorigin'),
                            'purchasevaulationdetails.evrequesteditemid as supplyworeda',
                            DB::raw('CONCAT(customers.code," ", customers.Name) as customername'),
                            'regions.Rgn_Name','zones.Zone_Name','reqworeda.Woreda_Name AS requestworedname','woredas.Woreda_Name as woredname',
                            'purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype','purchasevaulationdetails.sampleamount',
                            'purchasevaulationdetails.evmoisture','purchasevaulationdetails.screensieve','purchasevaulationdetails.evcupvalue',
                            'purchasevaulationdetails.evscore','purchasevaulationdetails.remark','purchasevaulationdetails.description',
                            'purchasevaulationdetails.evstatus','purchasevaulationdetails.evstatus as qualityapproval','purchasevaulationdetails.fevstatus','purchasevaulationdetails.bagamount',
                            'purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','pesuplliers.recievedate',
                            'purchasevaulationdetails.customerprice','purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice','purchasevaulationdetails.rank'
                            ]);

                            return $comiditylist;
    }
    public function infogetwineditems($headerid,$id){
                    $supplinfo=Pesuplliers::where('id',$id)->get();
                    $peid=Pesuplliers::where('id',$id)->first()->purchasevaulation_id;
                    $docno=Pesuplliers::where('id',$id)->first()->docno;
                    $customer=Pesuplliers::where('id',$id)->first()->customers_id;
                    $type=Purchasevaulation::where('id',$peid)->first()->type;
                    $orderinfo=PurchaseOrder::where('purchasevaulation_id',$peid)->get();
                    $pedocno=Purchasevaulation::where('id',$peid)->first()->documentumber;
                    $customer=customer::where('id',$customer)->get(['Code','Name','TinNumber']);
                    $headerexist=purchaseOrderDetails::where([['purchaseorder_id',$headerid],['pesupllier_id',$id]])->exists();
                    $storeid=Pesuplliers::where('id',$id)->first()->store;
                    switch ($storeid) {
                        case 0:
                            $storename='';
                            break;
                        
                        default:
                            $storename=store::where('id',$storeid)->first()->Name;
                            break;
                    }
                    
                    switch ($headerexist) {
                        case true:
                            $from='evaluation';
                            $comiditylist=$this->commodityfromevualation($id,$peid);
                            break;
                        
                        default:
                            $from='orders';
                            $comiditylist=$this->commodityfromorders($headerid,$id,$peid);
                            break;
                    }
                    
                        $actions=actions::join('users','actions.user_id','=','users.id')
                                ->where([['pageid',$headerid],['actions.pagename',$id]])
                                ->orderBy('actions.id','DESC')
                                ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
                                
                return Response::json([
                'success' =>200,
                'pedocno' =>$pedocno,
                'storename' =>$storename,
                'headerexist' =>$headerexist,
                'from' =>$from,
                'type' =>$type,
                'customer' =>$customer,
                'orderinfo' =>$orderinfo,
                'supplinfo' =>$supplinfo,
                'actions' =>$actions,
                'comiditylist' =>$comiditylist,
        ]);
    }
        
    public function commodityfromevualation($id,$peid){
        $comiditylist=Purchasevaulationdetail::join('woredas','purchasevaulationdetails.woreda_id','woredas.id')
                    ->join('zones','woredas.zone_id','zones.id')
                    ->join('regions','zones.Rgn_Id','regions.id')
                    ->join('pesuplliers','purchasevaulationdetails.pesupllier_id','pesuplliers.id')
                    ->join('customers','pesuplliers.customers_id','customers.id')
                    ->join('woredas as reqworeda','purchasevaulationdetails.requesteditemid','reqworeda.id')
                    ->join('zones as reqzones','reqworeda.zone_id','reqzones.id')
                    ->join('regions as reqregions','reqzones.Rgn_Id','reqregions.id')
                    ->join('woredas as evalworeda','purchasevaulationdetails.evrequesteditemid','evalworeda.id')
                    ->join('zones as evalzones','evalworeda.zone_id','evalzones.id')
                    ->join('regions as evalregions','evalzones.Rgn_Id','evalregions.id')

                    ->orderby('purchasevaulationdetails.evrequesteditemid','ASC')
                    ->where([['purchasevaulationdetails.purchasevaulation_id',$peid],['purchasevaulationdetails.pesupllier_id',$id],['purchasevaulationdetails.row_number',1]])
                    ->get([ DB::raw('CONCAT(reqregions.Rgn_Name," ", reqzones.Zone_Name," ",reqworeda.Woreda_Name) AS requestedorigin'),
                            DB::raw('CONCAT(evalregions.Rgn_Name," ",evalzones.Zone_Name," ",evalworeda.Woreda_Name) AS supplyorigin'),
                            'purchasevaulationdetails.evrequesteditemid as supplyworeda',
                            DB::raw('CONCAT(customers.code," ", customers.Name) as customername'),
                            'regions.Rgn_Name','zones.Zone_Name','reqworeda.Woreda_Name AS requestworedname','woredas.Woreda_Name as woredname',
                            'purchasevaulationdetails.cropyear','purchasevaulationdetails.proccesstype','purchasevaulationdetails.sampleamount',
                            'purchasevaulationdetails.evmoisture','purchasevaulationdetails.screensieve','purchasevaulationdetails.evcupvalue',
                            'purchasevaulationdetails.evscore','purchasevaulationdetails.remark','purchasevaulationdetails.description',
                            'purchasevaulationdetails.evstatus','purchasevaulationdetails.evstatus as qualityapproval','purchasevaulationdetails.fevstatus','purchasevaulationdetails.bagamount',
                            'purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','purchasevaulationdetails.qualitygrade','pesuplliers.recievedate',
                            'purchasevaulationdetails.customerprice','purchasevaulationdetails.proposedprice','purchasevaulationdetails.finalprice','purchasevaulationdetails.rank',
                            'purchasevaulationdetails.qualitygrade as grade',

                            ]);

                            return $comiditylist;
    }
    public function commodityfromorders($headerid,$id,$peid){
        $comiditylist=purchaseOrderDetails::join('woredas','purchaseordersdetails.itemid','woredas.id')
                    ->join('zones','woredas.zone_id','zones.id')
                    ->join('regions','zones.Rgn_Id','regions.id')
                    ->join('pesuplliers','purchaseordersdetails.pesupllier_id','pesuplliers.id')
                    ->join('customers','pesuplliers.customers_id','customers.id')
                    ->join('uoms','purchaseordersdetails.uom','uoms.id')
                    ->orderby('purchaseordersdetails.itemid','ASC')
                    ->where([['purchaseordersdetails.purchaseorder_id',$headerid],['purchaseordersdetails.pesupllier_id',$id]])
                    ->get([ DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS origin'),
                            'purchaseordersdetails.itemid as supplyworeda',
                            DB::raw('CONCAT(customers.code," ", customers.Name) as customername'),
                            'purchaseordersdetails.cropyear','purchaseordersdetails.proccesstype','purchaseordersdetails.uom','purchaseordersdetails.qty',
                            'purchaseordersdetails.qty','purchaseordersdetails.totalKg','purchaseordersdetails.feresula','purchaseordersdetails.price',
                            'purchaseordersdetails.Total','purchaseordersdetails.status','purchaseordersdetails.id','purchaseordersdetails.rank',
                            'uoms.Name as uomname','uoms.id as uomid','uoms.uomamount','purchaseordersdetails.ton','purchaseordersdetails.grade'
                            ]);
        return $comiditylist;
    }
    public function suppliercommodity($headerid,$id){

        $comiditylist=purchaseOrderDetails::join('woredas','purchaseordersdetails.itemid','woredas.id')
                    ->join('zones','woredas.zone_id','zones.id')
                    ->join('regions','zones.Rgn_Id','regions.id')
                    ->join('pesuplliers','purchaseordersdetails.pesupllier_id','pesuplliers.id')
                    ->join('customers','pesuplliers.customers_id','customers.id')
                    ->join('uoms','purchaseordersdetails.uom','uoms.id')
                    ->orderby('purchaseordersdetails.itemid','ASC')
                    ->where([['purchaseordersdetails.purchaseorder_id',$headerid],['purchaseordersdetails.pesupllier_id',$id]])
                    ->get([ DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS origin'),
                            'purchaseordersdetails.itemid as supplyworeda',
                            DB::raw('CONCAT(customers.code," ", customers.Name) as customername'),
                            'purchaseordersdetails.cropyear','purchaseordersdetails.proccesstype','purchaseordersdetails.uom','purchaseordersdetails.qty',
                            'purchaseordersdetails.qty','purchaseordersdetails.totalKg','purchaseordersdetails.feresula','purchaseordersdetails.price',
                            'purchaseordersdetails.Total','purchaseordersdetails.status','purchaseordersdetails.id','uoms.Name as uomname','uoms.id as uomid'
                            ]);

        return datatables()->of($comiditylist)->addIndexColumn()->toJson();
    }

    public function getsuplleritems($headerid,$id){

    }
    public function listallpologs($id){
        $data=supplierlog::where('pesupllier_id',$id)->orderby('id','Desc')->get(['docno']);
        return datatables()->of($data)->addIndexColumn()->toJson();

    }
    public function posuppliersave(Request $request){
        $validator = Validator::make($request->all(), [
            'preparedate' => ['required'],
            'orderdate' => ['required'],
            'deliverydate' => ['required'],
            'warehouse' => ['required'],
            'paymenterm' => ['required'],
        ]);
        switch ($request->type) {
                case 'Goods':
                    $rules2=array(
                        'row.*.ItemId' => 'required',
                        'row.*.sampleamount' => 'required|gt:0',
                        );
                    break;
                default:
                    $rules2=array(
                            'fevrow.*.qauntity' => 'required',
                        );
                    break;
            }
            $v2= Validator::make($request->all(), $rules2);
            if($validator->passes() && $v2->passes()) {
                        $itemdata=[];
                        $peaction=new actions();
                        $docno=Pesuplliers::where('id',$request->posupplierid)->first()->docno;
                        $status=Pesuplliers::where('id',$request->posupplierid)->first()->status;
                        switch ($status) {
                            case 0:
                                $stati=1;
                                break;
                            
                            default:
                                $stati=$status;
                                break;
                        }
                        $update=Pesuplliers::where('id',$request->posupplierid)
                                                ->update(['subtotal'=>$request->subtotali,'tax'=>$request->taxi,'grandtotal'=>$request->grandtotali,
                                                    'withold'=>$request->witholdingAmntin,'netpay'=>$request->netpayin,'istaxable'=>$request->istaxable,
                                                    'orderdate'=>$request->orderdate,'deliverydate'=>$request->deliverydate,'store'=>$request->warehouse,
                                                    'preparedate'=>$request->preparedate,'status'=>$stati,'paymenterm'=>$request->paymenterm,
                                                ]);
                                                
                    foreach ($request->fevrow as $key => $value){
                            $pe=purchaseOrderDetails::updateOrCreate(['id' =>(int)$value['pdetid']], [
                                'purchaseorder_id'=>$request->poid,
                                'itemid'=>(int)$value['evItemId'],
                                'pesupllier_id'=>$request->posupplierid,
                                'cropyear' =>(int)$value['evcropyear'],
                                'proccesstype'=>$value['evproccesstype'],
                                'uom'=>$value['uom'],
                                'qty'=>$value['qauntity'],
                                'totalkg'=>$value['quantitykg'],
                                'feresula'=>$value['feresula'],
                                'price'=>$value['finalprice'],
                                'Total'=>$value['Total'],
                                'status'=>$value['continue'],
                                'rank'=>$value['rank'],
                                'reason'=>$value['reason'],
                                'ton'=>$value['ton'],
                                'grade'=>$value['grade'],
                        ]);
                    }
                        switch ($request->iswhere) {
                            case 'orders':
                                $lateststatus=Pesuplliers::where('id',$request->posupplierid)->first()->status;
                                $action='Order Edited';
                                switch ($lateststatus) {
                                    case 1:
                                        $stat='Draft';
                                        break;
                                    case 2:
                                        $stat='Pending';
                                    break;
                                    case 3:
                                        $stat='Verify';
                                    break;
                                    case 4:
                                        $stat='Approve';
                                    break;
                                    default:
                                        $stat='--';
                                        break;
                                }
                                break;
                            
                            default:
                                $action='Order Created';
                                $stat='Draft';
                                break;
                        }
                        $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                        $po=PurchaseOrder::find($request->poid);
                        $peaction->action=$action;
                        $peaction->status=$stat;
                        $peaction->pagename=$request->posupplierid;
                        $peaction->user_id=Auth()->user()->id;
                        $peaction->time=$day;
                        $po->actions()->save($peaction);
                        $sumation=Pesuplliers::where('id',$request->posupplierid)->get(['subtotal','tax','grandtotal','withold','withold','istaxable']);
                        $noiftems=purchaseOrderDetails::where([['purchaseorder_id',$request->poid],['pesupllier_id',$request->posupplierid]])->count();

                        $actions=actions::join('users','actions.user_id','=','users.id')
                        ->where([['pageid',$request->poid],['actions.pagename',$request->posupplierid]])
                        ->orderBy('actions.id','DESC')
                        ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
                        return Response::json(['success' => 200,
                                                'id'=>$request->posupplierid,
                                                'stat'=>$stati,
                                                'noiftems'=>$noiftems,
                                                'sumation'=>$sumation,
                                                'actions'=>$actions,
                                                
                                        ]);
            }
            if($validator->fails()){
                return Response::json(['errors' => $validator->errors()]);
            }
            if($v2->fails()){
                return Response::json(['errorv2' => $v2->errors()->all()]);
            }

    }


public function podirectaction($id,$status){
    $action='';
    $stat='';
    $pno=PurchaseOrder::where('id',$id)->first()->porderno;
    $poaction=new actions();
    switch ($status) {
        case 1:
                PurchaseOrder::where('id',$id)->update(['status'=>1]);
                $action='Changed To Pending';
                $stat='Pending';
                $message='successfully changed to pending';
            break;
        case 2:
                $budget=setting::where('id',1)->first()->budget;
                $subtotal=PurchaseOrder::where('id',$id)->first()->subtotal;
                $isreviewed=PurchaseOrder::where('id',$id)->first()->isreviewed;
                $oldstatus=PurchaseOrder::where('id',$id)->first()->status;
                switch ($isreviewed) {
                    case 0:
                        $action='Verified';
                        $stat='Verify';
                        if($subtotal>$budget){
                            PurchaseOrder::where('id',$id)->update(['status'=>6,'oldstatus'=>$oldstatus]);
                            
                        } else{
                            PurchaseOrder::where('id',$id)->update(['status'=>2]);
                            
                        }
                        break;
                    
                    default:
                            PurchaseOrder::where('id',$id)->update(['status'=>2]);
                                $action='Verified';
                                $stat='Verify';
                        break;
                }
                $message='successfully changed to verify';
            break;
            case 3:
                PurchaseOrder::where('id',$id)->update(['status'=>3]);
                $action='Approved';
                $stat='Approve';
                $message='successfully changed to Approve';
            break;
            case 4:
                $oldstatus=PurchaseOrder::where('id',$id)->first()->oldstatus;
                PurchaseOrder::where('id',$id)->update(['status'=>$oldstatus]);
                $action='Undo Void';
                $stat='Undo Void';
                $message='successfully undo void';
            break;
            case 5:
                $oldstatus=PurchaseOrder::where('id',$id)->first()->oldstatus;
                PurchaseOrder::where('id',$id)->update(['status'=>$oldstatus]);
                $action='Undo Reject';
                $stat='Undo Reject';
                $message='successfully undo reject';
            break;
            case 6:
                $oldstatus=PurchaseOrder::where('id',$id)->first()->oldstatus;
                PurchaseOrder::where('id',$id)->update(['status'=>7,'isreviewed'=>1]);
                $action='Reviewed';
                $stat='Reviewed';
                $message='successfully Reviewed';
            break;
                case 7:
                $oldstatus=PurchaseOrder::where('id',$id)->first()->oldstatus;
                PurchaseOrder::where('id',$id)->update(['status'=>6]);
                $action='Undo Review';
                $stat='Undo Review';
                $message='successfully reviewed';
            break;
        default:
            # code...
            break;
    }
            $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            $po=PurchaseOrder::find($id);
            $poaction->action=$action;
            $poaction->status=$stat;
            $poaction->pagename='po';
            $poaction->user_id=Auth()->user()->id;
            $poaction->time=$day;
            $po->actions()->save($poaction);
            $laststatus=PurchaseOrder::where('id',$id)->first()->status;
    $actions=actions::join('users','actions.user_id','=','users.id')
                                ->where([['pageid',$id],['actions.pagename','po']])
                                ->orderBy('actions.id','DESC')
                                ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
    return Response::json([ 
                                'success' => 200,
                                'message'=>$message,
                                'pno'=>$pno,
                                'status'=>$laststatus,
                                'actions'=>$actions,
                            ]);

}
public function supplieraction($headerid,$id,$status){
    $peid=Pesuplliers::where('id',$id)->first()->purchasevaulation_id;
    $poid= PurchaseOrder::where('purchasevaulation_id',$peid)->first()->id;
    $action='';
    $stat='';
    $poaction=new actions();
    switch ($status) {
            case 2:
                $update=Pesuplliers::where('id',$id)->update(['status'=>2]);
                $message='Successfully changed';
                $action='Changed To pending';
                $stat='Pending';
                break;
            case 3:
                $update=Pesuplliers::where('id',$id)->update(['status'=>3]);
                $message='Successfully changed';
                $action='changed To Verify';
                $stat='Verify';
            break;
            case 4:
                $porderno= PurchaseOrder::where('purchasevaulation_id',$peid)->first()->porderno;
                $randomno=$this->generateUniqueFourDigitNumber();
                $docn=$porderno.'/'.$randomno;
                $update=Pesuplliers::where('id',$id)->update(['status'=>4,'docno'=>$docn]);
                $message='Successfully changed';
                $action='Changed To Approve';
                $stat='Approve';
                $docno=Pesuplliers::where('id',$id)->first()->docno;
                $istaxable=Pesuplliers::where('id',$id)->first()->istaxable;
                $subtotal=Pesuplliers::where('id',$id)->first()->subtotal;
                $tax=Pesuplliers::where('id',$id)->first()->tax;
                $withold=Pesuplliers::where('id',$id)->first()->withold;
                $netpay=Pesuplliers::where('id',$id)->first()->netpay;
                    supplierlog::Create([
                        'pesupllier_id'=>$id,
                        'docno'=>$docno,
                        'istaxable'=>$istaxable,
                        'subtotal'=>$subtotal,
                        'tax'=>$tax,
                        'withold'=>$withold,
                        'netpay'=>$netpay,
                    ]);
            break;
                case 5:
                    $oldstatus=Pesuplliers::where('id',$id)->first()->oldstatus;
                    Pesuplliers::where('id',$id)->update(['status'=>$oldstatus]);
                    $message='Successfully changed';
                    $action='Undo Void';
                    switch ($oldstatus) {
                        case 0:
                            $stat='Draft';
                        break;
                        case 1:
                            $stat='Pending';
                        break;
                        case 2:
                            $stat='Verify';
                        break;
                        case 3:
                            $stat='Approve';
                        break;
                        default:
                            $stat='--';
                            break;
                    }
                break;
            case 7:
                $update=Pesuplliers::where('id',$id)->update(['status'=>1,'docno'=>'']);
                $message='Successfully changed';
                $action='Back to Draft';
                $stat='Draft';
                break;
                case 8:
                $update=Pesuplliers::where('id',$id)->update(['status'=>2]);
                $message='Successfully changed';
                $action='Back to Pending';
                $stat='Pending';
                break;
                case 9:
                $update=Pesuplliers::where('id',$id)->update(['status'=>3]);
                $message='Successfully changed';
                $action='Back to Verify';
                $stat='Verify';
                break;
            default:
                
                break;
        }
                $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                $po=PurchaseOrder::find($poid);
                $poaction->action=$action;
                $poaction->status=$stat;
                $poaction->pagename=$id;
                $poaction->user_id=Auth()->user()->id;
                $poaction->time=$day;
                $po->actions()->save($poaction);
                $laststatus=Pesuplliers::where('id',$id)->first()->status;
                $actions=actions::join('users','actions.user_id','=','users.id')
                                ->where([['pageid',$headerid],['actions.pagename',$id]])
                                ->orderBy('actions.id','DESC')
                                ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
        return Response::json([
                                'success' => 200,
                                'message'=>$message,
                                'status'=>$laststatus,
                                'actions'=>$actions,
                            ]);
    }

    public function posavedraftdata(Request $request){
        $isvalid=0;
        $type=$request->reference;
        $validator = Validator::make($request->all(), [
            'reference' => ['required'],
            'supplier' => ['required'],
            'purchaseordertype' => ['required'],
            'purchasevaulation_id' => ['required_if:reference,PE','nullable',Rule::unique('purchaseorders')->where(function ($query) use($type) {
                                        return $query->where('type', $type);
                                    })->ignore($request->porderid)],
                'directorderdate' => ['required'],
                'directdeliverydate' => ['required'],
                'directwarehouse' => ['required'],
                'directpaymenterm' => ['required'],
        ]);

            $validator->sometimes(['commoditytype', 'coffeesource', 'coffestatus'], 'required', function ($input) {
                    return $input->purchaseordertype === 'Commodity';
            });
            switch ($request->purchaseordertype) {
                case 'Goods':
                    $rules2=array(
                            'row.*.itemid' => 'required',
                            'row.*.uom' => 'required',
                            'row.*.qauntity' => 'required',
                            'row.*.unitprice' => 'required',
                            );
                    break;
                
                default:
                    $rules2=array(
                        'fevrow.*.evItemId' => 'required',
                        'fevrow.*.evcropyear' => 'required',
                        'fevrow.*.coffeproccesstype' => 'required',
                        'fevrow.*.uom' => 'required',
                        'fevrow.*.qauntity' => 'required',
                        'fevrow.*.finalprice' => 'required',
                        );
                    break;
            }
        
        $v2= Validator::make($request->all(), $rules2);
        switch ($request->reference) {
            case 'Direct':
            case 'PE':    
                //$pev=1;
                if (empty($request->purchasevaulation_id)) {
                    $pev=1;
                }  else{
                        $pev=$request->purchasevaulation_id;
                } 
            
                $supplier=$request->supplier;
                $subtotal=$request->directsubtotali;
                $tax=$request->directtaxi;
                $grandtotal=$request->directgrandtotali;
                $withold=$request->directwitholdingAmntin;
                $netpay=$request->directnetpayin;
            if($validator->passes() && $v2->passes() ){
                $isvalid=1;
            } else{
                if($validator->fails()){
                    return Response::json(['errors' => $validator->errors()]);
                }
                if($v2->fails()){
                        return Response::json(['errorv2' => $v2->errors()->all()]);
                    }
            }
                break;
            
            default:
                
                    $pev=$request->purchasevaulation_id;
                    $supplier=1;
                    $subtotal=0;
                    $tax=0;
                    $grandtotal=0;
                    $withold=0;
                    $netpay=0;
                    if($validator->passes()){
                    $isvalid=1;
                    } else{
                        return Response::json(['errors' => $validator->errors()]);
                    }
                break;
        }
        if($isvalid==1){
            $settingsval = DB::table('settings')->latest()->first();
            $fiscalyr=$settingsval->FiscalYear;
            $peaction=new actions();
            $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            if($request->documentnumber==null){
                        $year=$fiscalyr-2000;
                        $addyear=$year+1;
                        $docPrefix=$settingsval->poprefix;
                        $docNum=$settingsval->pono;
                        $numberPadding=sprintf("%06d", $docNum);
                        $docNumber=$docPrefix.$numberPadding;
                        $docNumber=$docNumber.'/'.$year.'-'.$addyear;
                        $inc=$settingsval->pono+1;
                        $settingUpdate=setting::where('id',1)->update(['pono'=>$inc]);
                    } else{
                        $docNumber=$request->documentnumber;
                    }
            $po=PurchaseOrder::updateOrCreate(['id' =>$request->porderid], [
                'purchaseordertype'=>$request->purchaseordertype,
                'purchasevaulation_id'=>$pev,
                'customers_id'=>$supplier,
                'type'=>$request->reference,
                'porderno'=>$docNumber,
                'orderdate'=>$request->directorderdate,
                'deliverydate'=>$request->directdeliverydate,
                'store'=>$request->directwarehouse,
                'paymenterm'=>$request->directpaymenterm,
                'istaxable'=>$request->directistaxable,
                'subtotal'=>$subtotal,
                'tax'=>$tax,
                'grandtotal'=>$grandtotal,
                'withold'=>$withold,
                'netpay'=>$netpay,
                'commudtytype'=>$request->commoditytype,
                'commudtysource'=>$request->coffeesource,
                'commudtystatus'=>$request->coffestatus,
                'memo'=>$request->memo,
            ]);
            if (empty($request->porderid)) {
                        $action='Created';
                        $stat='Draft';
                        $poid=PurchaseOrder::latest()->first()->id;
                    } else {
                        $status=PurchaseOrder::where('id',$request->porderid)->first()->status;
                        switch ($status) {
                            case 0:
                                $action='Edited';
                                $stat='Draft';
                                break;
                                case 1:
                                $action='Edited';
                                $stat='Pending';
                                break;
                            default:
                                $action='Edited';
                                $stat='Verify';
                                break;
                        }
                        
                        $poid=$request->porderid;
                    }
            switch ($request->purchaseordertype) {
                case 'Goods':
                    $itemdata=[];
                    foreach ($request->row as $key => $value){
                                $itemdata[(int)$value['itemid']] = 
                                [   
                                    'uom' =>(int)$value['uom'],
                                    'qty' =>(int)$value['qauntity'],
                                    'price'=>(float)$value['unitprice'],
                                    'Total'=>(float)$value['total'],
                                ];
                            }
                    $po->items()->sync($itemdata);
                    break;
                
                default:
                        switch ($request->reference) {
                            case 'Direct':
                            case 'PE':    
                                    if (!empty($request->porderid)) {
                                        $cerids=[];
                                        foreach ($request->fevrow as $key => $value){
                                            $cerids[]=(int)$value['pdetid'];
                                        }
                                        purchaseOrderDetails::where('purchaseorder_id',$request->porderid)->whereNotIn('id',$cerids)->delete();
                                    }
                                foreach ($request->fevrow as $key => $value){
                                        $pedetials=purchaseOrderDetails::updateOrCreate(['id' =>(int)$value['pdetid']], [
                                            'purchaseorder_id'=>$poid,
                                            'itemid'=>(int)$value['evItemId'],
                                            'cropyear' =>(int)$value['evcropyear'],
                                            'proccesstype'=>$value['coffeproccesstype'],
                                            'uom'=>$value['uom'],
                                            'qty'=>$value['qauntity'],
                                            
                                            'bagweight'=>$value['bagweight'],
                                            'netkg'=>$value['netkg'],
                                            'totalkg'=>$value['totalkg'],
                                            'feresula'=>$value['feresula'],
                                            'price'=>$value['finalprice'],
                                            'Total'=>$value['Total'],
                                            'grade'=>$value['directgrade'],
                                            'ton'=>$value['ton'],
                                            
                                    ]);
                                }
                                break;
                            
                            default:
                                
                                break;
                        }

                    break;
            }
            
                    $peaction->action=$action;
                    $peaction->status=$stat;
                    $peaction->pagename='po';
                    $peaction->user_id=Auth()->user()->id;
                    $peaction->time=$day;
                    $po->actions()->save($peaction);

            return Response::json(['success' => 200]);
        }
        
    }

    public function generateUniqueFourDigitNumber(){
        $number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Generate random 4-digit number
        $existingNumber = Pesuplliers::where('docno', $number)->exists(); // Check if the number already exists in your database
        if ($existingNumber) {
            // If the number already exists, recursively call the function again to generate a new one
            return generateUniqueFourDigitNumber();
        }
        // If the number is unique, return it
        return $number;
}
public function suppliierdirectpoattachemnt($headerid,$id){
        $porderno=PurchaseOrder::where('id',$headerid)->first()->porderno;
        $purchaseordertype=PurchaseOrder::where('id',$headerid)->first()->purchaseordertype;
        $customercode=Pesuplliers::where('id',$id)->first()->customers_id;
        $customername=customer::where('id',$customercode)->first()->Name;
        $settingsval = DB::table('settings')->latest()->first();
        $totalprice=Pesuplliers::find($id);
        switch ($purchaseordertype) {
            case 'Goods':
                
                break;
            
            default:
                    $comiditylist=purchaseOrderDetails::join('woredas','purchaseordersdetails.itemid','woredas.id')
                        ->join('zones','woredas.zone_id','zones.id')
                        ->join('regions','zones.Rgn_Id','regions.id')
                        ->join('uoms','purchaseordersdetails.uom','uoms.id')
                        ->orderby('purchaseordersdetails.itemid','ASC')
                        ->where([['purchaseordersdetails.purchaseorder_id',$headerid],['purchaseordersdetails.pesupllier_id',$id],['purchaseordersdetails.status','Confirm']])
                        ->get([ DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS origin'),
                                'purchaseordersdetails.itemid as supplyworeda',
                                'purchaseordersdetails.cropyear','purchaseordersdetails.proccesstype','purchaseordersdetails.uom','purchaseordersdetails.qty',
                                'purchaseordersdetails.qty','purchaseordersdetails.totalKg','purchaseordersdetails.feresula','purchaseordersdetails.price',
                                'purchaseordersdetails.Total','purchaseordersdetails.ton','purchaseordersdetails.status','purchaseordersdetails.id',
                                'purchaseordersdetails.rank','uoms.Name as uomname'
                                ]);
                        
                break;
        }
        
        $due_date=Carbon::now();
        $count=0;
        $compInfo=companyinfo::find(1);
        $watermark='Purchase Order';
        $updated_at = Carbon::createFromFormat('Y-m-d H:i:s', $totalprice->updated_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $userid=actions::where([['pageid',$headerid],['pagename','po'],['action','Approved']])->latest()->first()->user_id;
        $username=User::where('id',$userid)->first()->FullName;
        $data=[
                'totalprice'=>$totalprice,
                'purchaseordertype'=>$purchaseordertype,
                'count'=>$count,
                'due_date'=>$due_date,
                'compInfo'=>$compInfo,
                'customername'=>$customername,
                'settingsval'=>$settingsval,
                'comiditylist'=>$comiditylist,
                'updated_at'=>$updated_at,
                'username'=>$username,
                'porderno'=>$porderno,
                //'amountinword'=>$amountinword,
            ];
                $mpdf=new \Mpdf\Mpdf([
                    'margin_left' => 10,
                    'margin_right' => 10,
                    'margin_top' => 32,
                    'margin_bottom' => 25,
                    'margin_header' => 10,
                    'margin_footer' => 1,
                    'orientation'=>'P',
                ]);
            $date = Carbon::now('Africa/Addis_Ababa')->format('Y-m-d @ H:i:s');
            $html=\View::make('pr.supplierpoattachment')->with($data);
            $html=$html->render();
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("PO Attachment");
            $mpdf->SetAuthor("Designed By RAK Computer Technology");
            $mpdf->SetWatermarkText($watermark);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('rfqattachment.pdf','I');


}
public function directpoattachemnt($id){
        $customercode=PurchaseOrder::where('id',$id)->first()->customers_id;
        $purchaseordertype=PurchaseOrder::where('id',$id)->first()->purchaseordertype;
        $customername=customer::where('id',$customercode)->first()->Name;
        $settingsval = DB::table('settings')->latest()->first();
        $totalprice=PurchaseOrder::find($id);
        switch ($purchaseordertype) {
            case 'Goods':
                    $comiditylist=purchaseOrderDetails::join('regitems','purchaseordersdetails.itemid','regitems.id')
                    ->join('uoms','purchaseordersdetails.uom','uoms.id')
                    ->orderby('purchaseordersdetails.itemid','ASC')
                    ->where('purchaseordersdetails.purchaseorder_id',$id)
                    ->get([ DB::raw('CONCAT(regitems.Code," ", regitems.Name," ",regitems.SKUNumber) AS item'),
                            'regitems.id as itemid','regitems.Code','regitems.Name','regitems.SKUNumber','purchaseordersdetails.itemid as goodid','purchaseordersdetails.id as pdetailid',
                            'purchaseordersdetails.uom','purchaseordersdetails.qty','purchaseordersdetails.price', 'purchaseordersdetails.Total',
                            'uoms.Name as uomname','uoms.id as uomid','uoms.uomamount'
                            ]);
                break;
            
            default:
                $comiditylist=purchaseOrderDetails::join('woredas','purchaseordersdetails.itemid','woredas.id')
                    ->join('zones','woredas.zone_id','zones.id')
                    ->join('regions','zones.Rgn_Id','regions.id')
                    ->join('uoms','purchaseordersdetails.uom','uoms.id')
                    ->orderby('purchaseordersdetails.itemid','ASC')
                    ->where('purchaseordersdetails.purchaseorder_id',$id)
                    ->get([ DB::raw('CONCAT(regions.Rgn_Name," ", zones.Zone_Name," ",woredas.Woreda_Name) AS origin'),
                            'purchaseordersdetails.itemid as supplyworeda',
                            'purchaseordersdetails.cropyear','purchaseordersdetails.proccesstype','purchaseordersdetails.grade','purchaseordersdetails.uom','purchaseordersdetails.qty',
                            'purchaseordersdetails.qty','purchaseordersdetails.totalKg','purchaseordersdetails.netkg','purchaseordersdetails.feresula','purchaseordersdetails.price',
                            'purchaseordersdetails.Total','purchaseordersdetails.status','purchaseordersdetails.id','purchaseordersdetails.rank',
                            'purchaseordersdetails.ton','uoms.Name as uomname'
                            ]);
                break;
        }
        
        $due_date=Carbon::now();
        $count=0;
        $compInfo=companyinfo::find(1);
        $watermark='Purchase Order';
        $updated_at = Carbon::createFromFormat('Y-m-d H:i:s', $totalprice->updated_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $userid=actions::where([['pageid',$id],['pagename','po'],['action','Approved']])->latest()->first()->user_id;
        $username=User::where('id',$userid)->first()->FullName;
        $amountinword=$this->convert_number_to_words($totalprice->subtotal);
        $data=[
                'totalprice'=>$totalprice,
                'purchaseordertype'=>$purchaseordertype,
                'count'=>$count,
                'due_date'=>$due_date,
                'compInfo'=>$compInfo,
                'customername'=>$customername,
                'settingsval'=>$settingsval,
                'comiditylist'=>$comiditylist,
                'updated_at'=>$updated_at,
                'username'=>$username,
                'amountinword'=>$amountinword,
            ];
                $mpdf=new \Mpdf\Mpdf([
                    'margin_left' => 10,
                    'margin_right' => 10,
                    'margin_top' => 32,
                    'margin_bottom' => 25,
                    'margin_header' => 10,
                    'margin_footer' => 1,
                    'orientation'=>'P',
                ]);
            $date = Carbon::now('Africa/Addis_Ababa')->format('Y-m-d @ H:i:s');
            $html=\View::make('pr.directpoattachment')->with($data);
            $html=$html->render();
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("PO Attachment");
            $mpdf->SetAuthor("Designed By RAK Computer Technology");
            $mpdf->SetWatermarkText($watermark);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('rfqattachment.pdf','I');
            
}
    public static function convert_number_to_words($number) {
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );
        if (!is_numeric($number)) {
            return false;
        }
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }
        if ($number < 0) {
            return $negative . Self::convert_number_to_words(abs($number));
        }
        $string = $fraction = null;
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . Self::convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = Self::convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= Self::convert_number_to_words($remainder);
                }
                break;
        }
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        return $string;
    }
    
    public function povoid(Request $request){
            $validator = Validator::make($request->all(), [
                'Reason' => ['required'],
            ]);
            if ($validator->passes()){
                $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                $userby=Auth()->user()->FullName;
                $voidby=$userby.' on '.$day;
                $oldstatus=PurchaseOrder::where('id',$request->povoidid)->first()->status;
                $pevaction=new actions();
                
                switch ($request->voidtype) {
                    case 'Void':
                            $ac='Void';
                            $prstatus='Void';
                            $status=4;
                        break;
                    case 'Pending':
                            $ac='Back To pending';
                            $prstatus='Pending';
                            $status=1;
                        break; 
                        
                        case 'Draft':
                            $ac='Back To Draft';
                            $prstatus='Draft';
                            $status=0;
                        break; 
                    default:
                            $ac='Rejected';
                            $prstatus='Rejected';
                            $status=5;
                        break;
                }
                
                try {
                    $pev=PurchaseOrder::find($request->povoidid);
                    $recivexist=receiving::where('PoId',$request->povoidid)->exists();
                    switch ($recivexist) {
                        case true:
                                return Response::json([
                                        'success' => 300,
                                    ]);
                            break;
                        default:
                            $pr=PurchaseOrder::updateOrCreate(['id' =>$request->povoidid], [
                                    'status' =>  $status,
                                    'oldstatus' =>$oldstatus,
                                    'isreviewed'=>0
                                ]);
                                $pevaction->action=$ac;
                                $pevaction->status=$prstatus;
                                $pevaction->user_id=Auth()->user()->id;
                                $pevaction->pagename='po';
                                $pevaction->time=$day;
                                $pevaction->reason=$request->Reason;
                                $pev->actions()->save($pevaction);
                                $actions=actions::join('users','actions.user_id','=','users.id')
                                    ->where([['pageid',$request->povoidid],['actions.pagename','po']])
                                    ->orderBy('actions.id','DESC')
                                    ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
                                return Response::json([
                                    'success' => 200,
                                    'actions' => $actions,
                                ]);
                            break;
                    }
                    
                } catch (\Throwable $th) {
                    return Response::json(['dberrors' =>  $th->getMessage()]);
                }
            }
            if($validator->fails()){
                return Response::json(['errors' => $validator->errors()]);
            }
    }

    public function supplierpovoid(Request $request){
            $validator = Validator::make($request->all(), [
                'Reason' => ['required'],
            ]);
            if ($validator->passes()){
                $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                $userby=Auth()->user()->FullName;
                $voidby=$userby.' on '.$day;
                $oldstatus=Pesuplliers::where('id',$request->supplierdetailsid)->first()->status;
                $pevaction=new actions();
                
                switch ($request->suppliervoidtype) {
                    case 'Void':
                        $ac='Void';
                        $prstatus='Void';
                        $status=5;
                        break;
                    case 'Draft':
                        $ac='Back to Draft';
                        $prstatus='Draft';
                        $status=0;
                        break;
                        
                        case 'Pending':
                        $ac='Back To Pending';
                        $prstatus='Pending';
                        $status=1;
                        break;

                    default:
                        $ac='Rejected';
                        $prstatus='Rejected';
                        $status=6;
                        break;
                }
                
                try {
                    
                    $pev=PurchaseOrder::find($request->supplierpovoidid);
                    $pr=Pesuplliers::updateOrCreate(['id' =>$request->supplierdetailsid], [
                        'status' =>  $status,
                        'oldstatus' =>$oldstatus,
                    ]);
                    $pevaction->action=$ac;
                    $pevaction->status=$prstatus;
                    $pevaction->user_id=Auth()->user()->id;
                    $pevaction->pagename=$request->supplierdetailsid;
                    $pevaction->time=$day;
                    $pevaction->reason=$request->Reason;
                    $pev->actions()->save($pevaction);
                    $actions=actions::join('users','actions.user_id','=','users.id')
                        ->where([['pageid',$request->supplierpovoidid],['actions.pagename',$request->supplierdetailsid]])
                        ->orderBy('actions.id','DESC')
                        ->get(['users.FullName as user','actions.action','actions.status','actions.time','actions.reason']);
                    return Response::json([
                        'success' => 200,
                        'status'=>$status,
                        'req'=>$request->suppliervoidtype,
                        'actions' => $actions,
                    ]);
                } catch (\Throwable $th) {
                    return Response::json(['dberrors' =>  $th->getMessage()]);
                }
            }
            if($validator->fails()){
                return Response::json(['errors' => $validator->errors()]);
            }
    }

}
