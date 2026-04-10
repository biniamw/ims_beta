<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\companyinfo;
use App\Models\receivingdetail;

class CommodityReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $fyear;
    protected $fiscalyear;
    protected $companytype;
    protected $station;
    protected $producttype;
    protected $supplier;
    protected $referece;
    protected $receivingnum;
    protected $commoditytype;
    protected $commodityrec;
    protected $grade;
    protected $processtype;
    protected $cropyear;
    protected $statusrec;
    protected $commtype;
    protected $commsource;
    protected $commstatus;
    protected $user;
    protected $currentdate;
    protected $compInfo;


    public function __construct()
    {
        // Initialize the global variables
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        
        $compId="1";
        $this->compInfo=companyinfo::find($compId);

        $this->currentdate=Carbon::today()->toDateString();

        $this->fiscalyear=DB::select('SELECT * FROM fiscalyear WHERE fiscalyear.FiscalYear<='.$fyear.' ORDER BY fiscalyear.FiscalYear DESC');
        
        //-------receiving start---------
        $this->producttype=DB::select('SELECT DISTINCT receivings.ProductType,receivings.StoreId FROM receivings WHERE receivings.Status IN("Confirmed","Void","") ORDER BY receivings.ProductType ASC');
        $this->companytype=DB::select('SELECT lookups.CompanyTypeValue,lookups.CompanyType,receivings.ReceivedDate FROM receivings LEFT JOIN lookups ON receivings.CompanyType=lookups.CommodityTypeValue ORDER BY lookups.CompanyType DESC');
        $this->receivingnum=DB::select('SELECT DISTINCT receivings.id,CONCAT(IFNULL(receivings.CompanyType,""),IFNULL(receivings.StoreId,""),IFNULL(receivings.ProductType,""),IFNULL(receivings.CustomerId,""),IFNULL(receivings.Type,"")) AS DataProp,receivings.DocumentNumber FROM receivings WHERE receivings.Status IN("Confirmed","Void","") ORDER BY receivings.DocumentNumber ASC');
        $this->commoditytype=DB::select('SELECT lookups.CommodityTypeValue,lookups.CommodityType FROM lookups WHERE lookups.CommodityTypeValue<7');
        $this->commodityrec=DB::select('SELECT DISTINCT receivingdetails.HeaderId,woredas.id AS CommodityId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS CommType FROM receivingdetails LEFT JOIN woredas ON receivingdetails.CommodityId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN receivings ON receivingdetails.HeaderId=receivings.id WHERE receivings.Status IN("Confirmed","Void","") ORDER BY woredas.Woreda_Name ASC');
        $this->supplier=DB::select('SELECT DISTINCT receivings.CustomerId,CONCAT(IFNULL(receivings.CompanyType,""),IFNULL(receivings.StoreId,""),IFNULL(receivings.ProductType,"")) AS DataProp,CONCAT(IFNULL(customers.Name,""),"     ,     ",IFNULL(customers.TinNumber,"")) AS SupplierName FROM receivings LEFT JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.Status IN("Confirmed","Void","") ORDER BY customers.Name ASC');
        $this->referece=DB::select('SELECT DISTINCT lookups.ReceivingTypeValue,CONCAT(IFNULL(receivings.CompanyType,""),IFNULL(receivings.StoreId,""),IFNULL(receivings.ProductType,""),IFNULL(receivings.CustomerId,"")) AS DataProp,lookups.ReceivingType FROM receivings LEFT JOIN lookups ON receivings.Type=lookups.ReceivingTypeValue WHERE receivings.Status IN("Confirmed","Void","") ORDER BY lookups.ReceivingType DESC');
        $this->statusrec=DB::select('SELECT DISTINCT receivings.id,receivings.Status AS Status,receivings.Status AS StatusVal FROM receivings WHERE (receivings.ReturnStatus=0 OR receivings.ReturnStatus IS NULL OR receivings.ReturnStatus="") AND receivings.Status IN("Confirmed","Void","") UNION SELECT DISTINCT receivings.id,"Return" AS Status,"Returned" AS StatusVal FROM receivings WHERE receivings.ReturnStatus>0 UNION SELECT DISTINCT receivings.id,"Void" AS Status,"Void(Confirmed)" AS StatusVal FROM receivings WHERE receivings.Status="Void" ORDER BY Status ASC');
        //-------receiving end-----------
        
        $this->grade=DB::select('SELECT CONCAT(IFNULL(receivingdetails.HeaderId,""),IFNULL(receivingdetails.CommodityId,"")) AS DataProp,lookups.GradeValue,lookups.Grade FROM receivingdetails LEFT JOIN lookups ON receivingdetails.Grade=lookups.GradeValue');
        $this->processtype=DB::select('SELECT CONCAT(IFNULL(receivingdetails.HeaderId,""),IFNULL(receivingdetails.CommodityId,""),IFNULL(receivingdetails.Grade,"")) AS DataProp,receivingdetails.ProcessType FROM receivingdetails ORDER BY receivingdetails.ProcessType ASC');
        $this->cropyear=DB::select('SELECT CONCAT(IFNULL(receivingdetails.HeaderId,""),IFNULL(receivingdetails.CommodityId,""),IFNULL(receivingdetails.Grade,""),IFNULL(receivingdetails.ProcessType,"")) AS DataProp,lookups.CropYearValue,lookups.CropYear FROM receivingdetails LEFT JOIN lookups ON receivingdetails.CropYear=lookups.CropYearValue');
    
        $this->commtype=DB::select('SELECT receivings.id,CONCAT(IFNULL(receivings.id,""),IFNULL(receivings.Type,"")) AS DataProp,IFNULL(purchaseorders.commudtytype,"-") AS CommodityType FROM receivings LEFT JOIN purchaseorders ON receivings.PoId=purchaseorders.id ORDER BY purchaseorders.commudtytype ASC');
        $this->commsource=DB::select('SELECT receivings.id,CONCAT(IFNULL(receivings.id,""),IFNULL(receivings.Type,"")) AS DataProp,IFNULL(purchaseorders.commudtysource,"-") AS CommoditySource FROM receivings LEFT JOIN purchaseorders ON receivings.PoId=purchaseorders.id ORDER BY purchaseorders.commudtysource ASC');
        $this->commstatus=DB::select('SELECT receivings.id,CONCAT(IFNULL(receivings.id,""),IFNULL(receivings.Type,"")) AS DataProp,IFNULL(purchaseorders.commudtystatus,"-") AS CommodityStatus FROM receivings LEFT JOIN purchaseorders ON receivings.PoId=purchaseorders.id ORDER BY purchaseorders.commudtystatus ASC');
    }

    private function storeData($acctype)
    {
        //acctype is store assignment
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $station=null;

        if($acctype==14){
            $station=DB::select('SELECT DISTINCT StoreId,stores.Name,receivings.CompanyType FROM receivings LEFT JOIN stores ON receivings.StoreId=stores.id WHERE receivings.Status IN("Confirmed","Void","") AND receivings.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type='.$acctype.')');
        }
        if($acctype==15){
            $acctype=14;//change passed parameter to inventory report, 
            $station=DB::select('SELECT DISTINCT transactions.StoreId,stores.Name AS StoreName,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,"")) AS DataProp FROM transactions LEFT JOIN stores ON transactions.StoreId=stores.id WHERE transactions.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type='.$acctype.') ORDER BY stores.Name ASC');
        }
        
        if($acctype==16){
            $acctype=14;//change passed parameter to inventory report, 
            $station=DB::select('SELECT DISTINCT requisitiondetails.StoreId,stores.Name AS StoreName,CONCAT(IFNULL(requisitions.fiscalyear,""),IFNULL(requisitions.CustomerOrOwner,"")) AS DataProp FROM requisitiondetails LEFT JOIN stores ON requisitiondetails.StoreId=stores.id LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type='.$acctype.') ORDER BY stores.Name ASC');
        }
        
        return $station;
    }

    public function index()
    {
        //
    }

    //--------------Start Receiving Report------------
    public function recrepindex(Request $request)
    {    
        if($request->ajax()) {
            return view('inventory.report.receivingrep',['fiscalyear'=>$this->fiscalyear,'comptype'=>$this->companytype,'store'=>$this->storeData(14),'producttype'=>$this->producttype,'supplier'=>$this->supplier,'referece'=>$this->referece,
            'receivingnum'=>$this->receivingnum,'commodity'=>$this->commodityrec,'grade'=>$this->grade,'processtype'=>$this->processtype,'cropyear'=>$this->cropyear,'status'=>$this->statusrec,'commtype'=>$this->commtype,'commsource'=>$this->commsource,
            'commstatus'=>$this->commstatus,'compInfo'=>$this->compInfo])->renderSections()['content'];
        }
        else{
            return view('inventory.report.receivingrep',['fiscalyear'=>$this->fiscalyear,'comptype'=>$this->companytype,'store'=>$this->storeData(14),'producttype'=>$this->producttype,'supplier'=>$this->supplier,'referece'=>$this->referece,
            'receivingnum'=>$this->receivingnum,'commodity'=>$this->commodityrec,'grade'=>$this->grade,'processtype'=>$this->processtype,'cropyear'=>$this->cropyear,'status'=>$this->statusrec,'commtype'=>$this->commtype,'commsource'=>$this->commsource,
            'commstatus'=>$this->commstatus,'compInfo'=>$this->compInfo]);
        }
    }

    public function receivingReport(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fiscalyear' => 'required',
            'daterange' => 'required',
            'companytype' => 'required',
            'store' => 'required',

            'producttype' => 'required',
            'supplier' => 'required',
            'reference' => 'required',
            'receivingno' => 'required',

            'commodity' => 'required',
            'grade' => 'required',
            'processtype' => 'required',
            'cropyear' => 'required',
            
            'status' => 'required',
            'commoditytype' => 'required',
            'commoditysource' => 'required',
            'commoditystatus' => 'required',
        ]);

        if($validator->passes()){
            return Response::json(['success' =>1]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function receivingDataFetch()
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        
        $fiscalyearpost=$_POST['fiscalyearpost']; 
        $startdatepost=$_POST['startdatepost']; 
        $enddatepost=$_POST['enddatepost']; 

        $companytypepost=$_POST['companytypepost']; 
        //$companytypepost=implode(',', $companytypepost);

        $storepost=$_POST['storepost']; 
        $storepost=implode(',', $storepost);

        $producttypepost=$_POST['producttypepost']; 
        $producttypepost= '"' .implode('","', $producttypepost). '"';

        $supplierpost=$_POST['supplierpost']; 
        $supplierpost=implode(',', $supplierpost);

        $referencepost=$_POST['referencepost']; 
        $referencepost=implode(',', $referencepost);

        $receivingpost=$_POST['receivingpost']; 
        $receivingpost=implode(',', $receivingpost);

        $commoditypost=$_POST['commoditypost']; 
        $commoditypost=implode(',', $commoditypost);

        $gradepost=$_POST['gradepost']; 
        $gradepost=implode(',', $gradepost);

        $processtypepost=$_POST['processtypepost']; 
        $processtypepost='"'.implode('","', $processtypepost). '"';

        $cropyearpost=$_POST['cropyearpost']; 
        $cropyearpost=implode(',', $cropyearpost);

        $receivingstatuspost=$_POST['receivingstatuspost']; 
        $receivingstatuspost='"' .implode('","', $receivingstatuspost). '"';

        $commoditytypepost=$_POST['commoditytypepost']; 
        $commoditytypepost='"' .implode('","', $commoditytypepost). '"';

        $commoditysourcepost=$_POST['commoditysourcepost']; 
        $commoditysourcepost='"' .implode('","', $commoditysourcepost). '"';

        $commoditystatuspost=$_POST['commoditystatuspost']; 
        $commoditystatuspost='"' .implode('","', $commoditystatuspost). '"';

        $query = DB::select("SELECT receivings.id AS recid,receivings.PoId,purchaseinvoices.id AS PIVId,receivings.DocumentNumber,IFNULL(purchaseinvoices.docno,'') AS PurchaseInvoiceNo,CONCAT(IFNULL(customers.Name,''),' (',IFNULL(customers.TinNumber,''),')') AS Supplier,customers.TinNumber AS SupplierTIN,IFNULL(purchaseorders.porderno,'') AS PONumber,receivings.ReceivedDate AS Date,locations.Name AS FloorMap,lookups.CommodityType AS CommType,CONCAT(regions.Rgn_Name,' , ',zones.Zone_Name,' , ',woredas.Woreda_Name) AS Commodity,grdlookup.Grade AS Grade,crplookup.CropYear AS CropYear,receivingdetails.ProcessType,uoms.Name AS UOM,receivingdetails.NumOfBag,receivingdetails.TotalKg,receivingdetails.NetKg,ROUND((receivingdetails.NetKg/1000),2) AS TON,receivingdetails.Feresula,receivingdetails.BagWeight,
        @unitcost:=(SELECT ROUND((purchaseinvoicedetails.price/17),2) FROM purchaseinvoicedetails WHERE purchaseinvoicedetails.grn=receivings.id and purchaseinvoicedetails.reciveid=receivingdetails.id ORDER BY receivingdetails.id DESC LIMIT 1) AS InvoicePrice,
        CASE WHEN @unitcost IS NOT NULL THEN @unitcost ELSE receivingdetails.UnitCost END AS UnitCost,
        CASE WHEN @unitcost IS NOT NULL THEN ROUND((@unitcost*receivingdetails.NetKg),2) ELSE receivingdetails.BeforeTaxCost END AS TotalCost,VarianceShortage,VarianceOverage,IFNULL(receivingdetails.Memo,'') AS Remark,
        CASE WHEN receivings.ReturnStatus=0 THEN receivings.Status ELSE 'Returned' END AS RecStatus,IF(receivings.Type=2,CONCAT(rectypelookup.ReceivingType,'(',purchaseorders.porderno,')'), rectypelookup.ReceivingType) AS ReferenceProp,CONCAT('Receiving No.: ',receivings.DocumentNumber,'    |    Purchase Invoice No.: ',IFNULL(purchaseinvoices.docno,''),'    |    Commodity Type: ',IFNULL(purchaseorders.commudtytype,'-'),'    |    Commodity Source: ',IFNULL(purchaseorders.commudtysource,''),'    |    Commodity Status: ',IFNULL(purchaseorders.commudtystatus,''),'    |    Date: ',receivings.ReceivedDate) AS CommodityProp,complookup.CompanyType,stores.Name AS StoreName

        FROM receivingdetails INNER JOIN receivings ON receivingdetails.HeaderId=receivings.id LEFT JOIN woredas ON receivingdetails.CommodityId = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions ON zones.Rgn_Id = regions.id LEFT JOIN uoms ON receivingdetails.NewUomId = uoms.id LEFT JOIN locations ON receivingdetails.LocationId=locations.id LEFT JOIN lookups ON receivingdetails.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS crplookup ON receivingdetails.CropYear=crplookup.CropYearValue LEFT JOIN lookups AS grdlookup ON receivingdetails.Grade=grdlookup.GradeValue LEFT JOIN customers ON receivings.CustomerId=customers.id LEFT JOIN purchaseorders ON receivings.PoId=purchaseorders.id LEFT JOIN stores ON receivings.StoreId=stores.id
        LEFT JOIN lookups AS complookup ON receivings.CompanyType=complookup.CompanyTypeValue LEFT JOIN lookups AS rectypelookup ON receivings.Type=rectypelookup.ReceivingTypeValue LEFT JOIN purchaseinvoices ON receivingdetails.PurchaseInvoiceId=purchaseinvoices.id
        WHERE receivings.ReceivedDate>='".$startdatepost."' AND receivings.ReceivedDate<='".$enddatepost."' AND receivings.CompanyType IN($companytypepost) AND receivings.StoreId IN($storepost) AND receivings.ProductType IN($producttypepost) AND receivings.CustomerId IN($supplierpost) AND receivings.Type IN($referencepost) AND receivings.id IN($receivingpost) AND receivingdetails.CommodityId IN($commoditypost) AND receivingdetails.Grade IN($gradepost) AND receivingdetails.ProcessType IN($processtypepost) AND receivingdetails.CropYear IN($cropyearpost) AND (CASE WHEN receivings.ReturnStatus=0 THEN receivings.Status ELSE 'Returned' END) IN($receivingstatuspost) AND IFNULL(purchaseorders.commudtytype,'-') IN($commoditytypepost) AND IFNULL(purchaseorders.commudtysource,'-') IN($commoditysourcepost) AND IFNULL(purchaseorders.commudtystatus,'-') IN($commoditystatuspost)

        ORDER BY receivings.CompanyType ASC,customers.Name ASC,purchaseorders.porderno ASC,receivings.DocumentNumber ASC");


        return datatables()->of($query)->addIndexColumn()->toJson();

    }
    //--------------End Receiving Report------------
    
    //--------------Start Stock Balance Report----------

    public function stockbalancerepindex(Request $request)
    {
        $companytype=DB::select('SELECT DISTINCT CASE WHEN transactions.customers_id=1 THEN 1 ELSE 2 END AS CompanyTypeValue,CASE WHEN transactions.customers_id=1 THEN "Owner" ELSE "Customer" END AS CompanyType,CONCAT(IFNULL(DATE(transactions.Date),"")) AS DataProp FROM transactions ORDER BY transactions.customers_id ASC');
        $customername=DB::select('SELECT DISTINCT transactions.customers_id,CONCAT(IFNULL(CASE WHEN customers.id=1 THEN "Owner" ELSE customers.Name END,""),"  ,  ",IFNULL(customers.TinNumber,"")) AS CustomerName,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(CASE WHEN transactions.customers_id=1 THEN 1 ELSE 2 END,"")) AS DataProp FROM transactions LEFT JOIN customers ON transactions.customers_id=customers.id ORDER BY customers.id ASC');
        $producttype=DB::select('SELECT DISTINCT transactions.ItemType AS ProductType,transactions.StoreId,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,"")) AS DataProp FROM transactions ORDER BY transactions.ItemType ASC');
        $transactiontype=DB::select('SELECT DISTINCT transactions.TransactionsType,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,"")) AS DataProp FROM transactions WHERE transactions.StockInComm>0 ORDER BY transactions.TransactionsType ASC');
       $referece=DB::select('SELECT DISTINCT transactions.HeaderId,CONCAT(transactions.DocumentNumber,"		",IFNULL(suppcustomer.Name,""),"		",IFNULL(suppcustomer.TinNumber,""),"		",IFNULL(transactions.ProductionNumber,""),"",IFNULL(transactions.CertNumber,"")) AS ReferenceNo,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.TransactionsType,"")) AS DataProp,CONCAT(IFNULL(transactions.SupplierId,""),IFNULL(transactions.GrnNumber,""),IFNULL(transactions.ProductionNumber,""),IFNULL(transactions.CertNumber,"")) AS DataVal FROM transactions LEFT JOIN receivings ON transactions.HeaderId=receivings.id AND transactions.TransactionsType="Receiving" LEFT JOIN customers ON receivings.CustomerId=customers.id LEFT JOIN customers AS suppcustomer ON transactions.SupplierId=suppcustomer.id WHERE transactions.StockInComm>0 ORDER BY transactions.TransactionsType ASC');

        $commoditytype=DB::select('SELECT DISTINCT transactions.CommodityType,lookups.CommodityType AS CommodityTypeName,CONCAT(IFNULL(transactions.DocumentNumber,""),IFNULL(transactions.CertNumber,"")) AS ReferenceNo,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.TransactionsType,""),CONCAT(IFNULL(transactions.SupplierId,""),IFNULL(transactions.GrnNumber,""),IFNULL(transactions.ProductionNumber,""),IFNULL(transactions.CertNumber,""))) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.CommodityType=lookups.CommodityTypeValue WHERE transactions.StockInComm>0 ORDER BY lookups.CommodityType ASC');
        $commodityrec=DB::select('SELECT DISTINCT transactions.woredaId AS CommodityId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.TransactionsType,""),CONCAT(IFNULL(transactions.SupplierId,""),IFNULL(transactions.GrnNumber,""),IFNULL(transactions.ProductionNumber,""),IFNULL(transactions.CertNumber,"")),IFNULL(transactions.CommodityType,"")) AS DataProp FROM transactions LEFT JOIN woredas ON transactions.woredaId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id WHERE transactions.StockInComm>0 ORDER BY woredas.Woreda_Name ASC');
        
        $grade=DB::select('SELECT DISTINCT lookups.GradeValue,lookups.Grade,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.TransactionsType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.Grade=lookups.GradeValue WHERE transactions.StockInComm>0 ORDER BY lookups.Grade ASC');
        $processtype=DB::select('SELECT DISTINCT transactions.ProcessType,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.TransactionsType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,""),IFNULL(transactions.Grade,"")) AS DataProp FROM transactions WHERE transactions.StockInComm>0 ORDER BY transactions.ProcessType ASC');
        $cropyear=DB::select('SELECT DISTINCT lookups.CropYearValue,lookups.CropYear,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.TransactionsType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,""),IFNULL(transactions.Grade,""),IFNULL(transactions.ProcessType,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.CropYear=lookups.CropYearValue WHERE transactions.StockInComm>0 ORDER BY lookups.CropYear ASC');
    
        if($request->ajax()) {
            return view('inventory.report.stockbalancerep',['fiscalyear'=>$this->fiscalyear,'comptype'=>$companytype,'store'=>$this->storeData(15),'producttype'=>$producttype,'transactiontype'=>$transactiontype,'commoditytype'=>$commoditytype,
            'customerowner'=>$customername,'referece'=>$referece,'commodity'=>$commodityrec,'grade'=>$grade,'processtype'=>$processtype,'cropyear'=>$cropyear,'compInfo'=>$this->compInfo,'currentdate'=>$this->currentdate])->renderSections()['content'];
        }
        else{
            return view('inventory.report.stockbalancerep',['fiscalyear'=>$this->fiscalyear,'comptype'=>$companytype,'store'=>$this->storeData(15),'producttype'=>$producttype,'transactiontype'=>$transactiontype,'commoditytype'=>$commoditytype,
            'customerowner'=>$customername,'referece'=>$referece,'commodity'=>$commodityrec,'grade'=>$grade,'processtype'=>$processtype,'cropyear'=>$cropyear,'compInfo'=>$this->compInfo,'currentdate'=>$this->currentdate]);
        }
    }
    
    public function stockBalanceReport(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fiscalyear' => 'required',
            'daterange' => 'required',
            'companytype' => 'required',
            'CustomerOrOwner' => 'required',
            
            'store' => 'required',
            'producttype' => 'required',
            'transactiontype' => 'required',
            'reference' => 'required',

            'commoditytype' => 'required',
            'commodity' => 'required',
            'grade' => 'required',
            'processtype' => 'required',
            'cropyear' => 'required',
        ]);

        if($validator->passes()){
            return Response::json(['success' =>1]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function stockBalanceDataFetch()
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $numberToRemove=1;
        $rejectVal=[];
        $fiscalyearpost=$_POST['fiscalyearpost']; 
        $startdatepost=$_POST['startdatepost']; 
        $enddatepost=$_POST['enddatepost']; 
        
        $transactiontypes=["Adjustment","Production","Requisition","Receiving","Void"];
        $transactiontypes= '"' .implode('","', $transactiontypes). '"';

        $companytypepost=$_POST['companytypepost']; 
        //$companytypepost=implode(',', $companytypepost);

        $customerorownerpost=$_POST['customerorownerpost']; 
        $customerorownerpost=implode(',', $customerorownerpost);

        $storepost=$_POST['storepost']; 
        $storepost=implode(',', $storepost);

        $producttypepost=$_POST['producttypepost']; 
        $producttypepost= '"' .implode('","', $producttypepost). '"';

        $transactiontypepost=$_POST['transactiontypepost']; 
        $transactiontypepost= '"' .implode('","', $transactiontypepost). '"';

        $referencepost=$_POST['referencepost']; 
        $referencepost='"' .implode('","', $referencepost). '"';

        $commoditytypepost=$_POST['commoditytypepost']; 
        $commoditytypepost=implode(',', $commoditytypepost);

        $commoditypost=$_POST['commoditypost']; 
        array_push($commoditypost, 0);
        
        if (in_array($numberToRemove, $commoditypost)) {
            $rejectVal[]=1;
        } else {
           $rejectVal[]=0;
        }

        $rejectVal=implode(',', $rejectVal);
        $commoditypost = array_values(array_diff($commoditypost, [$numberToRemove]));
        $commoditypost=implode(',', $commoditypost);
        
        $gradepost=$_POST['gradepost']; 
        $gradepost=implode(',', $gradepost);

        $processtypepost=$_POST['processtypepost']; 
        $processtypepost='"'.implode('","', $processtypepost). '"';

        $cropyearpost=$_POST['cropyearpost']; 
        $cropyearpost=implode(',', $cropyearpost);

        $query = DB::select("SELECT locations.Name AS FloorMap,transactions.woredaId,lookups.CommodityType AS CommodityType,
            CONCAT_WS(', ', NULLIF(regions.Rgn_Name, ''), NULLIF(zones.Zone_Name, ''), NULLIF(woredas.Woreda_Name, '')) AS Commodity,grdlookup.Grade AS GradeName,transactions.ProcessType,crplookup.CropYear AS CropYearName,uoms.Name AS UOM,customers.Name AS SupplierName,transactions.GrnNumber,
            CONCAT_WS(', ', NULLIF(transactions.ProductionNumber, ''), NULLIF(transactions.CertNumber, '')) AS ProductionCert,transactions.DocumentNumber,transactions.TransactionsType,
            
            transactions.TransactionsType AS CustomTransactionType,
            CONCAT_WS(', ', NULLIF(transactions.DocumentNumber, ''), NULLIF(transactions.CertNumber, ''))AS ReferenceNo,

            @stockbagout:=(SELECT SUM(COALESCE(trnstockbagout.StockOutNumOfBag,0)) FROM transactions AS trnstockbagout WHERE DATE(trnstockbagout.Date)>='".$startdatepost."' AND DATE(trnstockbagout.Date)<='".$enddatepost."' AND trnstockbagout.CommodityType=transactions.CommodityType AND trnstockbagout.woredaId=transactions.woredaId AND trnstockbagout.Grade=transactions.Grade AND trnstockbagout.ProcessType=transactions.ProcessType AND trnstockbagout.CropYear=transactions.CropYear AND REPLACE(COALESCE(trnstockbagout.ProductionNumber, ''),'-','') = REPLACE(COALESCE(transactions.ProductionNumber, ''),'-','') AND REPLACE(COALESCE(trnstockbagout.CertNumber, ''),'-','') = REPLACE(COALESCE(transactions.CertNumber, ''),'-','') AND REPLACE(COALESCE(trnstockbagout.SupplierId, ''),'-','') = REPLACE(COALESCE(transactions.SupplierId, ''),'-','') AND REPLACE(COALESCE(trnstockbagout.GrnNumber, ''),'-','') = REPLACE(COALESCE(transactions.GrnNumber, ''),'-','') AND trnstockbagout.TransactionsType IN($transactiontypes)) AS StockOutBag,

            @stockkgout:=(SELECT SUM(COALESCE(trnstockkgout.StockOutComm,0)) FROM transactions AS trnstockkgout WHERE DATE(trnstockkgout.Date)>='".$startdatepost."' AND DATE(trnstockkgout.Date)<='".$enddatepost."' AND trnstockkgout.CommodityType=transactions.CommodityType AND trnstockkgout.woredaId=transactions.woredaId AND trnstockkgout.Grade=transactions.Grade AND trnstockkgout.ProcessType=transactions.ProcessType AND trnstockkgout.CropYear=transactions.CropYear AND REPLACE(COALESCE(trnstockkgout.ProductionNumber, ''),'-','') = REPLACE(COALESCE(transactions.ProductionNumber, ''),'-','') AND REPLACE(COALESCE(trnstockkgout.CertNumber, ''),'-','') = REPLACE(COALESCE(transactions.CertNumber, ''),'-','') AND REPLACE(COALESCE(trnstockkgout.SupplierId, ''),'-','') = REPLACE(COALESCE(transactions.SupplierId, ''),'-','') AND REPLACE(COALESCE(trnstockkgout.GrnNumber, ''),'-','') = REPLACE(COALESCE(transactions.GrnNumber, ''),'-','') AND trnstockkgout.TransactionsType IN($transactiontypes)) AS StockOutKG,

            ROUND((COALESCE(transactions.StockInNumOfBag,0) - COALESCE(@stockbagout,0)),2) AS NumOfBag,            
            ROUND((COALESCE(transactions.StockInComm,0) - COALESCE(@stockkgout,0)),2) AS NetKG,         
            TRUNCATE((COALESCE(transactions.StockInComm,0) - COALESCE(@stockkgout,0))/17,5) AS Feresula,            
            ROUND((COALESCE(transactions.StockInComm,0) - COALESCE(@stockkgout,0))/1000,2) AS TON,
            
            CASE WHEN transactions.customers_id=1 THEN 'Owner' ELSE customerowner.Name END AS CustomerOwner, stores.Name AS StoreName,transactions.HeaderId,transactions.customers_id,transactions.ProductionNumber AS PrdNumber,transactions.CertNumber AS CertNo,transactions.Grade,transactions.StoreId,transactions.CommodityType AS CommType,transactions.LocationId,transactions.CropYear,transactions.uomId,
            
            @ratioqnt:=(SELECT ROUND(COALESCE(SUM(prd_order_details.QuantityInKG),0),2) FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id WHERE prd_order_details.woredas_id=transactions.woredaId AND prd_order_details.CommodityType=transactions.CommodityType AND prd_order_details.Grade=transactions.Grade AND prd_order_details.ProcessType=transactions.ProcessType AND prd_order_details.CropYear=transactions.CropYear AND prd_order_details.uoms_id=transactions.uomId AND prd_orders.customers_id=transactions.customers_id AND COALESCE(prd_order_details.SupplierId,'')= COALESCE(transactions.SupplierId, '') AND COALESCE(prd_order_details.GrnNumber,'')= COALESCE(transactions.GrnNumber, '') AND COALESCE(prd_order_details.ProductionNumber,'') = COALESCE(transactions.ProductionNumber, '') AND COALESCE(prd_order_details.CertNumber,'')= COALESCE(transactions.CertNumber, '') AND prd_order_details.LocationId=transactions.LocationId AND prd_orders.Status IN('Pending','Ready','Reviewed','On-Production','Process-Finished','Production-Closed','Verified','Approved')) AS RatioQuantity,
            
            @reqamnt:=(SELECT ROUND(COALESCE(SUM(requisitiondetails.NetKg),0),2) FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.CommodityId=transactions.woredaId AND requisitiondetails.CommodityType=transactions.CommodityType AND requisitiondetails.Grade=transactions.Grade AND requisitiondetails.ProcessType=transactions.ProcessType AND requisitiondetails.CropYear=transactions.CropYear AND requisitiondetails.DefaultUOMId AND requisitions.CustomerOrOwner=transactions.customers_id AND COALESCE(requisitiondetails.SupplierId,'') = COALESCE(transactions.SupplierId, '') AND COALESCE(requisitiondetails.GrnNumber,'')= COALESCE(transactions.GrnNumber, '') AND COALESCE(requisitiondetails.ProductionOrderNo,'')= COALESCE(transactions.ProductionNumber, '') AND COALESCE(requisitiondetails.CertNumber,'') = COALESCE(transactions.CertNumber, '') AND requisitiondetails.LocationId=transactions.LocationId AND requisitions.Status IN('Draft','Pending','Verified','Reviewed','Approved')) AS ReqAmount,
            
            @allocqnt:=ROUND((@ratioqnt+@reqamnt),2) AS AllocatedQty

            FROM transactions 
            LEFT JOIN woredas ON transactions.woredaId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN lookups ON transactions.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookup ON transactions.Grade=grdlookup.GradeValue LEFT JOIN lookups AS crplookup ON transactions.CropYear=crplookup.CropYearValue LEFT JOIN uoms ON transactions.uomId=uoms.id 
            LEFT JOIN customers ON transactions.SupplierId=customers.id LEFT JOIN locations ON transactions.LocationId=locations.id LEFT JOIN customers AS customerowner ON transactions.customers_id=customerowner.id LEFT JOIN stores ON transactions.StoreId=stores.id

            WHERE DATE(transactions.Date)>='".$startdatepost."' AND DATE(transactions.Date)<='".$enddatepost."' AND transactions.customers_id IN($customerorownerpost) AND transactions.StoreId IN($storepost) AND transactions.ItemType IN($producttypepost) AND transactions.TransactionsType IN ($transactiontypepost) AND transactions.CommodityType IN($commoditytypepost) AND transactions.woredaId IN($commoditypost) AND transactions.Grade IN($gradepost) AND transactions.ProcessType IN($processtypepost) AND transactions.CropYear IN($cropyearpost) AND (CONCAT(IFNULL(transactions.SupplierId,''),IFNULL(transactions.GrnNumber,''),IFNULL(transactions.ProductionNumber,''),IFNULL(transactions.CertNumber,''))) IN($referencepost) AND transactions.StockInComm>0

            GROUP BY transactions.id
            HAVING NetKG>0

            UNION

            SELECT locations.Name AS FloorMap,transactions.woredaId,lookups.CommodityType AS CommodityType,
            CONCAT_WS(', ', NULLIF(regions.Rgn_Name, ''), NULLIF(zones.Zone_Name, ''), NULLIF(woredas.Woreda_Name, '')) AS Commodity,
            grdlookup.Grade AS GradeName,transactions.ProcessType,crplookup.CropYear AS CropYearName,uoms.Name AS UOM,'' AS SupplierName,'' AS GrnNumber,'' AS ProductionCert,transactions.DocumentNumber,transactions.TransactionsType,

            'Production' AS CustomTransactionType,
            '' AS ReferenceNo,
			0 AS StockOutBag, 
			0 AS StockOutKG,

            ROUND(SUM(COALESCE(transactions.StockInNumOfBag,0)) - SUM(COALESCE(transactions.StockOutNumOfBag,0)),2) AS NumOfBag,
            ROUND(SUM(COALESCE(transactions.StockInComm,0)) - SUM(COALESCE(transactions.StockOutComm,0)),2) AS NetKG,    
            TRUNCATE((SUM(COALESCE(transactions.StockInComm,0)) - SUM(COALESCE(transactions.StockOutComm,0)))/17,5) AS Feresula,
        	ROUND((SUM(COALESCE(transactions.StockInComm,0)) - SUM(COALESCE(transactions.StockOutComm,0)))/1000,2) AS TON,

            CASE WHEN transactions.customers_id=1 THEN 'Owner' ELSE customerowner.Name END AS CustomerOwner, stores.Name AS StoreName,transactions.HeaderId,transactions.customers_id,transactions.ProductionNumber AS PrdNumber,transactions.CertNumber AS CertNo,transactions.Grade,transactions.StoreId,transactions.CommodityType AS CommType,transactions.LocationId,transactions.CropYear,transactions.uomId,

            @ratioqnt:=(SELECT ROUND(COALESCE(SUM(prd_order_details.QuantityInKG),0),2) FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id WHERE prd_order_details.woredas_id=transactions.woredaId AND prd_order_details.CommodityType=transactions.CommodityType AND prd_order_details.Grade=transactions.Grade AND prd_order_details.ProcessType=transactions.ProcessType AND prd_order_details.CropYear=transactions.CropYear AND prd_order_details.uoms_id=transactions.uomId AND prd_orders.customers_id=transactions.customers_id AND prd_order_details.LocationId=transactions.LocationId AND prd_orders.Status IN('Pending','Ready','Reviewed','On-Production','Process-Finished','Production-Closed','Verified','Approved')) AS RatioQuantity,
            
            @reqamnt:=(SELECT ROUND(COALESCE(SUM(requisitiondetails.NetKg),0),2) FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.CommodityId=transactions.woredaId AND requisitiondetails.CommodityType=transactions.CommodityType AND requisitiondetails.Grade=transactions.Grade AND requisitiondetails.ProcessType=transactions.ProcessType AND requisitiondetails.CropYear=transactions.CropYear AND requisitiondetails.DefaultUOMId AND requisitions.CustomerOrOwner=transactions.customers_id AND requisitiondetails.LocationId=transactions.LocationId AND requisitions.Status IN('Draft','Pending','Verified','Reviewed','Approved')) AS ReqAmount,
            @allocqnt:=ROUND((@ratioqnt+@reqamnt),2) AS AllocatedQty

           FROM transactions 
            LEFT JOIN woredas ON transactions.woredaId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN lookups ON transactions.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookup ON transactions.Grade=grdlookup.GradeValue LEFT JOIN lookups AS crplookup ON transactions.CropYear=crplookup.CropYearValue LEFT JOIN uoms ON transactions.uomId=uoms.id 
            LEFT JOIN customers ON transactions.SupplierId=customers.id LEFT JOIN locations ON transactions.LocationId=locations.id LEFT JOIN customers AS customerowner ON transactions.customers_id=customerowner.id LEFT JOIN stores ON transactions.StoreId=stores.id

            WHERE DATE(transactions.Date)>='".$startdatepost."' AND DATE(transactions.Date)<='".$enddatepost."' AND transactions.customers_id IN($customerorownerpost) AND transactions.StoreId IN($storepost) AND transactions.ItemType IN($producttypepost) AND transactions.CommodityType IN($commoditytypepost) AND transactions.woredaId IN($rejectVal) AND transactions.Grade IN($gradepost) AND transactions.ProcessType IN($processtypepost) AND transactions.CropYear IN($cropyearpost) AND 'Production' IN($transactiontypepost)

            GROUP BY transactions.LocationId,transactions.CommodityType,transactions.woredaId,transactions.Grade,transactions.ProcessType,transactions.CropYear,transactions.uomId,transactions.customers_id HAVING NetKG>0
            
            ORDER BY CustomerOwner DESC,StoreName ASC,CommodityType ASC, CustomTransactionType ASC");
            
        return datatables()->of($query)->addIndexColumn()->toJson();
    }
    
    public function fetchAllocationData()
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $query='';
        $commodityidpost=$_POST['commodityidpost'];
        $storeidpost=$_POST['storeidpost'];
        $locationidpost=$_POST['locationidpost'];
        $commoditytypepost=$_POST['commoditytypepost'];

        $gradepost=$_POST['gradepost'];
        $processtypepost=$_POST['processtypepost'];
        $cropyearpost=$_POST['cropyearpost'];
        $uomidpost=$_POST['uomidpost'];

        $customeridpost=$_POST['customeridpost'];
        $customtrtypepost=$_POST['customtrtypepost'];
        $grnpost=$_POST['grnpost'];
        $prdnumpost=$_POST['prdnumpost'];
        $certnumpost=$_POST['certnumpost'];

        if($commoditytypepost==3){
            $query = DB::select('SELECT requisitions.DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,requisitiondetails.NumOfBag,requisitiondetails.NetKg,ROUND((requisitiondetails.NetKg/1000),2) AS TON,requisitiondetails.Feresula,0 AS Ord,"Requisition" AS RecType,requisitiondetails.id AS RecId FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups ON requisitiondetails.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON requisitiondetails.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON requisitiondetails.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON requisitiondetails.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id LEFT JOIN stores ON requisitiondetails.StoreId=stores.id WHERE requisitiondetails.CommodityId='.$commodityidpost.' AND requisitiondetails.StoreId='.$storeidpost.' AND requisitiondetails.LocationId='.$locationidpost.' AND requisitiondetails.CommodityType='.$commoditytypepost.' AND requisitiondetails.Grade='.$gradepost.' AND requisitiondetails.ProcessType="'.$processtypepost.'" AND requisitiondetails.CropYear='.$cropyearpost.' AND requisitiondetails.DefaultUOMId='.$uomidpost.' AND requisitions.CustomerOrOwner='.$customeridpost.' AND requisitions.Status IN("Draft","Pending","Verified","Reviewed","Approved") 
                UNION
                SELECT prd_orders.ProductionOrderNumber AS DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,ROUND(COALESCE(prd_order_details.Quantity),0) AS NumOfBag,prd_order_details.QuantityInKG AS NetKg,ROUND(COALESCE(prd_order_details.QuantityInKG/1000),0) AS TON,ROUND(COALESCE(prd_order_details.QuantityInKG/17),0) AS Feresula,1 AS Ord,"Production" AS RecType,prd_order_details.id AS RecId FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id LEFT JOIN lookups ON prd_order_details.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON prd_order_details.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON prd_order_details.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON prd_order_details.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON prd_order_details.uoms_id=uoms.id LEFT JOIN stores ON prd_order_details.stores_id=stores.id WHERE prd_order_details.woredas_id='.$commodityidpost.' AND prd_order_details.stores_id='.$storeidpost.' AND prd_order_details.LocationId='.$locationidpost.' AND prd_order_details.CommodityType='.$commoditytypepost.' AND prd_order_details.Grade='.$gradepost.' AND prd_order_details.ProcessType="'.$processtypepost.'" AND prd_order_details.CropYear='.$cropyearpost.' AND prd_order_details.uoms_id='.$uomidpost.' AND prd_orders.customers_id='.$customeridpost.' AND prd_orders.Status IN("Pending","Ready","Reviewed","On-Production","Process-Finished","Verified") ORDER BY Ord ASC');
        }
        else{
            $query = DB::select('SELECT requisitions.DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,requisitiondetails.NumOfBag,requisitiondetails.NetKg,ROUND((requisitiondetails.NetKg/1000),2) AS TON,requisitiondetails.Feresula,0 AS Ord,"Requisition" AS RecType,requisitiondetails.id AS RecId FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups ON requisitiondetails.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON requisitiondetails.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON requisitiondetails.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON requisitiondetails.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id LEFT JOIN stores ON requisitiondetails.StoreId=stores.id WHERE requisitiondetails.CommodityId='.$commodityidpost.' AND requisitiondetails.StoreId='.$storeidpost.' AND requisitiondetails.LocationId='.$locationidpost.' AND requisitiondetails.CommodityType='.$commoditytypepost.' AND requisitiondetails.Grade='.$gradepost.' AND requisitiondetails.ProcessType="'.$processtypepost.'" AND requisitiondetails.CropYear='.$cropyearpost.' AND requisitiondetails.DefaultUOMId='.$uomidpost.' AND requisitiondetails.GrnNumber="'.$grnpost.'" AND requisitiondetails.ProductionOrderNo="'.$prdnumpost.'" AND requisitiondetails.CertNumber="'.$certnumpost.'" AND requisitions.CustomerOrOwner='.$customeridpost.' AND requisitions.Status IN("Draft","Pending","Verified","Reviewed","Approved") 
                UNION
                SELECT prd_orders.ProductionOrderNumber AS DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,ROUND(COALESCE(prd_order_details.Quantity),0) AS NumOfBag,prd_order_details.QuantityInKG AS NetKg,ROUND(COALESCE(prd_order_details.QuantityInKG/1000),0) AS TON,ROUND(COALESCE(prd_order_details.QuantityInKG/17),0) AS Feresula,1 AS Ord,"Production" AS RecType,prd_order_details.id AS RecId FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id LEFT JOIN lookups ON prd_order_details.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON prd_order_details.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON prd_order_details.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON prd_order_details.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON prd_order_details.uoms_id=uoms.id LEFT JOIN stores ON prd_order_details.stores_id=stores.id WHERE prd_order_details.woredas_id='.$commodityidpost.' AND prd_order_details.stores_id='.$storeidpost.' AND prd_order_details.LocationId='.$locationidpost.' AND prd_order_details.CommodityType='.$commoditytypepost.' AND prd_order_details.Grade='.$gradepost.' AND prd_order_details.ProcessType="'.$processtypepost.'" AND prd_order_details.CropYear='.$cropyearpost.' AND prd_order_details.uoms_id='.$uomidpost.' AND prd_orders.customers_id='.$customeridpost.' AND prd_order_details.GrnNumber="'.$grnpost.'" AND prd_order_details.ProductionNumber="'.$prdnumpost.'" AND prd_order_details.CertNumber="'.$certnumpost.'" AND prd_orders.Status IN("Pending","Ready","Reviewed","On-Production","Process-Finished","Verified") ORDER BY Ord ASC');
        }
        return datatables()->of($query)->addIndexColumn()->toJson();
    }

    //--------------End Stock Balance Report------------
    
    //--------------Start Stock Value Report----------
    public function stockvaluerepindex(Request $request)
    {
        $companytype=DB::select('SELECT DISTINCT CASE WHEN transactions.customers_id=1 THEN 1 ELSE 2 END AS CompanyTypeValue,CASE WHEN transactions.customers_id=1 THEN "Owner" ELSE "Customer" END AS CompanyType,CONCAT(IFNULL(DATE(transactions.Date),"")) AS DataProp FROM transactions ORDER BY transactions.customers_id ASC');
        $customername=DB::select('SELECT DISTINCT transactions.customers_id,CONCAT(IFNULL(CASE WHEN customers.id=1 THEN "Owner" ELSE customers.Name END,""),"  ,  ",IFNULL(customers.TinNumber,"")) AS CustomerName,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(CASE WHEN transactions.customers_id=1 THEN 1 ELSE 2 END,"")) AS DataProp FROM transactions LEFT JOIN customers ON transactions.customers_id=customers.id ORDER BY customers.id ASC');
        $producttype=DB::select('SELECT DISTINCT transactions.ItemType AS ProductType,transactions.StoreId,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,"")) AS DataProp FROM transactions ORDER BY transactions.ItemType ASC');
        
        $commoditytype=DB::select('SELECT DISTINCT transactions.CommodityType,lookups.CommodityType AS CommodityTypeName,CONCAT(IFNULL(transactions.DocumentNumber,""),IFNULL(transactions.CertNumber,"")) AS ReferenceNo,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.CommodityType=lookups.CommodityTypeValue WHERE transactions.TransactionsType IN("Receiving","Production") ORDER BY lookups.CommodityType ASC');
        $commodityrec=DB::select('SELECT DISTINCT transactions.woredaId AS CommodityId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,"")) AS DataProp FROM transactions LEFT JOIN woredas ON transactions.woredaId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id WHERE transactions.TransactionsType IN("Receiving","Production","Beginning") ORDER BY woredas.Woreda_Name ASC');
        
        $grade=DB::select('SELECT DISTINCT lookups.GradeValue,lookups.Grade,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.Grade=lookups.GradeValue WHERE transactions.TransactionsType IN("Receiving","Production") ORDER BY lookups.Grade ASC');
        $processtype=DB::select('SELECT DISTINCT transactions.ProcessType,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,""),IFNULL(transactions.Grade,"")) AS DataProp FROM transactions WHERE transactions.TransactionsType IN("Receiving","Production") ORDER BY transactions.ProcessType ASC');
        $cropyear=DB::select('SELECT DISTINCT lookups.CropYearValue,lookups.CropYear,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,""),IFNULL(transactions.Grade,""),IFNULL(transactions.ProcessType,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.CropYear=lookups.CropYearValue WHERE transactions.TransactionsType IN("Receiving","Production") ORDER BY lookups.CropYear ASC');
    
        if($request->ajax()) {
            return view('inventory.report.stockvaluerep',['fiscalyear'=>$this->fiscalyear,'comptype'=>$companytype,'store'=>$this->storeData(15),'producttype'=>$producttype,'commoditytype'=>$commoditytype,
            'customerowner'=>$customername,'commodity'=>$commodityrec,'grade'=>$grade,'processtype'=>$processtype,'cropyear'=>$cropyear,'compInfo'=>$this->compInfo,'currentdate'=>$this->currentdate])->renderSections()['content'];
        }
        else{
            return view('inventory.report.stockvaluerep',['fiscalyear'=>$this->fiscalyear,'comptype'=>$companytype,'store'=>$this->storeData(15),'producttype'=>$producttype,'commoditytype'=>$commoditytype,
            'customerowner'=>$customername,'commodity'=>$commodityrec,'grade'=>$grade,'processtype'=>$processtype,'cropyear'=>$cropyear,'compInfo'=>$this->compInfo,'currentdate'=>$this->currentdate]);
        }
    }

    public function stockValueReport(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fiscalyear' => 'required',
            'daterange' => 'required',
            'companytype' => 'required',
            'CustomerOrOwner' => 'required',
            
            'store' => 'required',
            'producttype' => 'required',

            'commoditytype' => 'required',
            'commodity' => 'required',
            'grade' => 'required',
            'processtype' => 'required',
            'cropyear' => 'required',
        ]);

        if($validator->passes()){
            return Response::json(['success' =>1]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function stockValueDataFetch()
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        $fiscalyearpost=$_POST['fiscalyearpost']; 
        $startdatepost=$_POST['startdatepost']; 
        $enddatepost=$_POST['enddatepost']; 

        //$enddatepost="2025-10-10";

        $companytypepost=$_POST['companytypepost']; 
        //$companytypepost=implode(',', $companytypepost);

        $customerorownerpost=$_POST['customerorownerpost']; 
        //$customerorownerpost=implode(',', $customerorownerpost);

        $storepost=$_POST['storepost']; 
        //$storepost=implode(',', $storepost);

        $producttypepost=$_POST['producttypepost']; 
        //$producttypepost= '"' .implode('","', $producttypepost). '"';
        //$producttypepost=implode(',', $producttypepost);

        $commoditytypepost=$_POST['commoditytypepost']; 
        //$commoditytypepost=implode(',', $commoditytypepost);

        $commoditypost=$_POST['commoditypost']; 
        //$commoditypost=implode(',', $commoditypost);
        
        $gradepost=$_POST['gradepost']; 
        //$gradepost=implode(',', $gradepost);

        $processtypepost=$_POST['processtypepost']; 

        //$processtypepost='"'.implode('","', $processtypepost). '"';
        //$processtypepost=implode(',', $processtypepost);        
        
        $cropyearpost=$_POST['cropyearpost']; 
        //$cropyearpost=implode(',', $cropyearpost);

        $query = DB::table('transactions')
        ->selectRaw("
            stores.Name AS StoreName, locations.Name AS LocationName, lookups.CommodityType AS CommType,
            CONCAT_WS(', ', NULLIF(regions.Rgn_Name, ''), NULLIF(zones.Zone_Name, ''), NULLIF(woredas.Woreda_Name, '')) AS Commodity,
            transactions.ProcessType, crplookups.CropYear AS CropYearName, grdlookups.Grade AS GradeName, uoms.Name AS UomName, 
            transactions.customers_id,locations.Name AS FloorMap,lookups.CommodityType AS CommodityType,
            CASE WHEN transactions.customers_id=1 THEN 'Owner' ELSE customerowner.Name END AS CustomerOwner,
            transactions.woredaId,transactions.StoreId,transactions.LocationId,transactions.Grade,
            transactions.CropYear,transactions.uomId,transactions.CommodityType AS CommTypeId,

            (SELECT ROUND(SUM(COALESCE(tr.StockInNumOfBag,0)) - SUM(COALESCE(tr.StockOutNumOfBag,0)), 2) 
                FROM transactions AS tr 
                WHERE tr.woredaId=transactions.woredaId 
                AND tr.CommodityType=transactions.CommodityType 
                AND tr.Grade=transactions.Grade 
                AND tr.ProcessType=transactions.ProcessType 
                AND tr.CropYear=transactions.CropYear 
                AND tr.StoreId=transactions.StoreId 
                AND tr.LocationId=transactions.LocationId 
                AND tr.uomId=transactions.uomId 
                AND tr.TransactionType!='On-Production' 
                AND tr.customers_id=transactions.customers_id
            ) AS NumOfBag,

            @netkg:=(SELECT ROUND(SUM(COALESCE(tr.StockInComm,0)) - SUM(COALESCE(tr.StockOutComm,0)), 2) 
                FROM transactions AS tr 
                WHERE tr.woredaId=transactions.woredaId 
                AND tr.CommodityType=transactions.CommodityType 
                AND tr.Grade=transactions.Grade 
                AND tr.ProcessType=transactions.ProcessType 
                AND tr.CropYear=transactions.CropYear 
                AND tr.StoreId=transactions.StoreId 
                AND tr.LocationId=transactions.LocationId 
                AND tr.uomId=transactions.uomId 
                AND tr.TransactionType!='On-Production' 
                AND tr.customers_id=transactions.customers_id
            ) AS NetKG,

            ROUND((@netkg / 17), 2) AS Feresula,
            ROUND((@netkg / 1000), 2) AS TON,

            @averagecost:=(SELECT ROUND(SUM(COALESCE(tr.TotalCostComm,0)) / SUM(COALESCE(tr.StockInComm,0)), 2) 
                FROM transactions AS tr 
                WHERE tr.woredaId=transactions.woredaId 
                AND tr.CommodityType=transactions.CommodityType 
                AND tr.Grade=transactions.Grade 
                AND tr.ProcessType=transactions.ProcessType 
                AND tr.CropYear=transactions.CropYear 
                AND tr.StoreId=transactions.StoreId 
                AND tr.LocationId=transactions.LocationId 
                AND tr.uomId=transactions.uomId 
                AND tr.TransactionType!='On-Production' 
                AND tr.customers_id=transactions.customers_id
            ) AS AverageCost,
            ROUND((@averagecost * @netkg), 2) AS TotalValue,
            
            
            @ratioqnt:=(SELECT ROUND(COALESCE(SUM(prd_order_details.QuantityInKG),0),2) FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id WHERE prd_order_details.woredas_id=transactions.woredaId AND prd_order_details.CommodityType=transactions.CommodityType AND prd_order_details.Grade=transactions.Grade AND prd_order_details.ProcessType=transactions.ProcessType AND prd_order_details.CropYear=transactions.CropYear AND prd_order_details.uoms_id=transactions.uomId AND prd_orders.customers_id=transactions.customers_id AND prd_order_details.LocationId=transactions.LocationId AND prd_orders.Status IN('Pending','Ready','Reviewed','On-Production','Process-Finished','Production-Closed','Verified','Approved')) AS RatioQuantity,
            
            @reqamnt:=(SELECT ROUND(COALESCE(SUM(requisitiondetails.NetKg),0),2) FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.CommodityId=transactions.woredaId AND requisitiondetails.CommodityType=transactions.CommodityType AND requisitiondetails.Grade=transactions.Grade AND requisitiondetails.ProcessType=transactions.ProcessType AND requisitiondetails.CropYear=transactions.CropYear AND requisitiondetails.DefaultUOMId AND requisitions.CustomerOrOwner=transactions.customers_id AND requisitiondetails.LocationId=transactions.LocationId AND requisitions.Status IN('Draft','Pending','Verified','Reviewed','Approved')) AS ReqAmount,
            
            @allocqnt:=ROUND((@ratioqnt+@reqamnt),2) AS AllocatedQty")

        ->leftJoin('stores', 'transactions.StoreId', '=', 'stores.id')
        ->leftJoin('woredas', 'transactions.woredaId', '=', 'woredas.id')
        ->leftJoin('zones', 'woredas.zone_id', '=', 'zones.id')
        ->leftJoin('regions', 'zones.Rgn_Id', '=', 'regions.id')
        ->leftJoin('uoms', 'transactions.uomId', '=', 'uoms.id')
        ->leftJoin('customers', 'transactions.customers_id', '=', 'customers.id')
        ->leftJoin('locations', 'transactions.LocationId', '=', 'locations.id')
        ->leftJoin('lookups', 'transactions.CommodityType', '=', 'lookups.CommodityTypeValue')
        ->leftJoin('lookups AS crplookups', 'transactions.CropYear', '=', 'crplookups.CropYearValue')
        ->leftJoin('lookups AS grdlookups', 'transactions.Grade', '=', 'grdlookups.GradeValue')
        ->leftJoin('customers AS customerowner', 'transactions.customers_id', '=', 'customerowner.id')
        ->whereBetween(DB::raw('DATE(transactions.Date)'), [$startdatepost, $enddatepost])
        ->whereIn('transactions.customers_id', $customerorownerpost)
        ->whereIn('transactions.StoreId', $storepost)
        ->whereIn('transactions.ItemType', $producttypepost)
        ->whereIn('transactions.CommodityType', $commoditytypepost)
        ->whereIn('transactions.woredaId', $commoditypost)
        ->whereIn('transactions.Grade', $gradepost)
        ->whereIn('transactions.ProcessType', $processtypepost)
        ->whereIn('transactions.CropYear', $cropyearpost)
        ->groupBy([
            'transactions.woredaId',
            'transactions.LocationId',
            'transactions.CommodityType',
            'transactions.Grade',
            'transactions.ProcessType',
            'transactions.CropYear',
            'transactions.StoreId',
            'transactions.uomId',
            'transactions.customers_id'
        ])
        ->having('NetKG', '>', 0)
        ->orderBy('CustomerOwner', 'ASC')
        ->orderBy('StoreName', 'ASC')
        ->orderBy('CommodityType', 'ASC')
        ->get();

        return datatables()->of($query)->addIndexColumn()->toJson();
    }
    
    
    public function fetchValueAllocData()
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $query='';
        $commodityidpost=$_POST['commodityidpost'];
        $storeidpost=$_POST['storeidpost'];
        $locationidpost=$_POST['locationidpost'];
        $commoditytypepost=$_POST['commoditytypepost'];

        $gradepost=$_POST['gradepost'];
        $processtypepost=$_POST['processtypepost'];
        $cropyearpost=$_POST['cropyearpost'];
        $uomidpost=$_POST['uomidpost'];

        $customeridpost=$_POST['customeridpost'];

        if($commoditytypepost==3){
            $query = DB::select('SELECT requisitions.DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,requisitiondetails.NumOfBag,requisitiondetails.NetKg,ROUND((requisitiondetails.NetKg/1000),2) AS TON,requisitiondetails.Feresula,0 AS Ord,"Requisition" AS RecType,requisitiondetails.id AS RecId FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups ON requisitiondetails.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON requisitiondetails.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON requisitiondetails.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON requisitiondetails.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id LEFT JOIN stores ON requisitiondetails.StoreId=stores.id WHERE requisitiondetails.CommodityId='.$commodityidpost.' AND requisitiondetails.StoreId='.$storeidpost.' AND requisitiondetails.LocationId='.$locationidpost.' AND requisitiondetails.CommodityType='.$commoditytypepost.' AND requisitiondetails.Grade='.$gradepost.' AND requisitiondetails.ProcessType="'.$processtypepost.'" AND requisitiondetails.CropYear='.$cropyearpost.' AND requisitiondetails.DefaultUOMId='.$uomidpost.' AND requisitions.CustomerOrOwner='.$customeridpost.' AND requisitions.Status IN("Draft","Pending","Verified","Reviewed","Approved") 
                UNION
                SELECT prd_orders.ProductionOrderNumber AS DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,ROUND(COALESCE(prd_order_details.Quantity),0) AS NumOfBag,ROUND(COALESCE(prd_order_details.QuantityInKG),0) AS NetKg,ROUND(COALESCE(prd_order_details.QuantityInKG/1000),0) AS TON,ROUND(COALESCE(prd_order_details.QuantityInKG/17),0) AS Feresula,1 AS Ord,"Production" AS RecType,prd_order_details.id AS RecId FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id LEFT JOIN lookups ON prd_order_details.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON prd_order_details.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON prd_order_details.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON prd_order_details.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON prd_order_details.uoms_id=uoms.id LEFT JOIN stores ON prd_order_details.stores_id=stores.id WHERE prd_order_details.woredas_id='.$commodityidpost.' AND prd_order_details.stores_id='.$storeidpost.' AND prd_order_details.LocationId='.$locationidpost.' AND prd_order_details.CommodityType='.$commoditytypepost.' AND prd_order_details.Grade='.$gradepost.' AND prd_order_details.ProcessType="'.$processtypepost.'" AND prd_order_details.CropYear='.$cropyearpost.' AND prd_order_details.uoms_id='.$uomidpost.' AND prd_orders.customers_id='.$customeridpost.' AND prd_orders.Status IN("Pending","Ready","Reviewed","On-Production","Process-Finished","Verified") ORDER BY Ord ASC');
        }
        else{
            $query = DB::select('SELECT requisitions.DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,requisitiondetails.NumOfBag,requisitiondetails.NetKg,ROUND((requisitiondetails.NetKg/1000),2) AS TON,requisitiondetails.Feresula,0 AS Ord,"Requisition" AS RecType,requisitiondetails.id AS RecId FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups ON requisitiondetails.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON requisitiondetails.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON requisitiondetails.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON requisitiondetails.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id LEFT JOIN stores ON requisitiondetails.StoreId=stores.id WHERE requisitiondetails.CommodityId='.$commodityidpost.' AND requisitiondetails.StoreId='.$storeidpost.' AND requisitiondetails.LocationId='.$locationidpost.' AND requisitiondetails.CommodityType='.$commoditytypepost.' AND requisitiondetails.Grade='.$gradepost.' AND requisitiondetails.ProcessType="'.$processtypepost.'" AND requisitiondetails.CropYear='.$cropyearpost.' AND requisitiondetails.DefaultUOMId='.$uomidpost.' AND requisitions.CustomerOrOwner='.$customeridpost.' AND requisitions.Status IN("Draft","Pending","Verified","Reviewed","Approved") 
                UNION
                SELECT prd_orders.ProductionOrderNumber AS DocumentNumber,stores.Name AS StoreName,lookups.CommodityType,grdlookups.Grade,prclookups.ProcessType,crplookups.CropYear,uoms.Name AS UOM,ROUND(COALESCE(prd_order_details.Quantity),0) AS NumOfBag,ROUND(COALESCE(prd_order_details.QuantityInKG),0) AS NetKg,ROUND(COALESCE(prd_order_details.QuantityInKG/1000),0) AS TON,ROUND(COALESCE(prd_order_details.QuantityInKG/17),0) AS Feresula,1 AS Ord,"Production" AS RecType,prd_order_details.id AS RecId FROM prd_order_details LEFT JOIN prd_orders ON prd_order_details.prd_orders_id=prd_orders.id LEFT JOIN lookups ON prd_order_details.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookups ON prd_order_details.Grade=grdlookups.GradeValue LEFT JOIN lookups AS prclookups ON prd_order_details.ProcessType=prclookups.ProcessTypeValue LEFT JOIN lookups AS crplookups ON prd_order_details.CropYear=crplookups.CropYearValue LEFT JOIN uoms ON prd_order_details.uoms_id=uoms.id LEFT JOIN stores ON prd_order_details.stores_id=stores.id WHERE prd_order_details.woredas_id='.$commodityidpost.' AND prd_order_details.stores_id='.$storeidpost.' AND prd_order_details.LocationId='.$locationidpost.' AND prd_order_details.CommodityType='.$commoditytypepost.' AND prd_order_details.Grade='.$gradepost.' AND prd_order_details.ProcessType="'.$processtypepost.'" AND prd_order_details.CropYear='.$cropyearpost.' AND prd_order_details.uoms_id='.$uomidpost.' AND prd_orders.customers_id='.$customeridpost.' AND prd_orders.Status IN("Pending","Ready","Reviewed","On-Production","Process-Finished","Verified") ORDER BY Ord ASC');
        }
        return datatables()->of($query)->addIndexColumn()->toJson();
    }
    //--------------End Stock Value Report------------
    
    //--------------Start Cost History Report---------
    public function stockcosthisotyrepindex(Request $request)
    {
        $companytype=DB::select('SELECT DISTINCT CASE WHEN transactions.customers_id=1 THEN 1 ELSE 2 END AS CompanyTypeValue,CASE WHEN transactions.customers_id=1 THEN "Owner" ELSE "Customer" END AS CompanyType,CONCAT(IFNULL(DATE(transactions.Date),"")) AS DataProp FROM transactions ORDER BY transactions.customers_id ASC');
        $customername=DB::select('SELECT DISTINCT transactions.customers_id,CONCAT(IFNULL(CASE WHEN customers.id=1 THEN "Owner" ELSE customers.Name END,""),"  ,  ",IFNULL(customers.TinNumber,"")) AS CustomerName,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(CASE WHEN transactions.customers_id=1 THEN 1 ELSE 2 END,"")) AS DataProp FROM transactions LEFT JOIN customers ON transactions.customers_id=customers.id ORDER BY customers.id ASC');
        $producttype=DB::select('SELECT DISTINCT transactions.ItemType AS ProductType,transactions.StoreId,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,"")) AS DataProp FROM transactions ORDER BY transactions.ItemType ASC');
        
        $commoditytype=DB::select('SELECT DISTINCT transactions.CommodityType,lookups.CommodityType AS CommodityTypeName,CONCAT(IFNULL(transactions.DocumentNumber,""),IFNULL(transactions.CertNumber,"")) AS ReferenceNo,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.CommodityType=lookups.CommodityTypeValue WHERE transactions.TransactionsType IN("Receiving","Production") ORDER BY lookups.CommodityType ASC');
        $commodityrec=DB::select('SELECT DISTINCT transactions.woredaId AS CommodityId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,"")) AS DataProp FROM transactions LEFT JOIN woredas ON transactions.woredaId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id WHERE transactions.TransactionsType IN("Receiving","Production","Beginning") ORDER BY woredas.Woreda_Name ASC');
        
        $grade=DB::select('SELECT DISTINCT lookups.GradeValue,lookups.Grade,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.Grade=lookups.GradeValue WHERE transactions.TransactionsType IN("Receiving","Production") ORDER BY lookups.Grade ASC');
        $processtype=DB::select('SELECT DISTINCT transactions.ProcessType,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,""),IFNULL(transactions.Grade,"")) AS DataProp FROM transactions WHERE transactions.TransactionsType IN("Receiving","Production") ORDER BY transactions.ProcessType ASC');
        $cropyear=DB::select('SELECT DISTINCT lookups.CropYearValue,lookups.CropYear,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,""),IFNULL(transactions.Grade,""),IFNULL(transactions.ProcessType,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.CropYear=lookups.CropYearValue WHERE transactions.TransactionsType IN("Receiving","Production") ORDER BY lookups.CropYear ASC');
    
        if($request->ajax()) {
            return view('inventory.report.stockcosthistory',['fiscalyear'=>$this->fiscalyear,'comptype'=>$companytype,'store'=>$this->storeData(15),'producttype'=>$producttype,'commoditytype'=>$commoditytype,
            'customerowner'=>$customername,'commodity'=>$commodityrec,'grade'=>$grade,'processtype'=>$processtype,'cropyear'=>$cropyear,'compInfo'=>$this->compInfo,'currentdate'=>$this->currentdate])->renderSections()['content'];
        }
        else{
            return view('inventory.report.stockcosthistory',['fiscalyear'=>$this->fiscalyear,'comptype'=>$companytype,'store'=>$this->storeData(15),'producttype'=>$producttype,'commoditytype'=>$commoditytype,
            'customerowner'=>$customername,'commodity'=>$commodityrec,'grade'=>$grade,'processtype'=>$processtype,'cropyear'=>$cropyear,'compInfo'=>$this->compInfo,'currentdate'=>$this->currentdate]);
        }
    }

    public function stockCostHistoryReport(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fiscalyear' => 'required',
            'daterange' => 'required',
            'companytype' => 'required',
            'CustomerOrOwner' => 'required',
            
            'store' => 'required',
            'producttype' => 'required',

            'commoditytype' => 'required',
            'commodity' => 'required',
            'grade' => 'required',
            'processtype' => 'required',
            'cropyear' => 'required',
        ]);

        if($validator->passes()){
            return Response::json(['success' =>1]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function stockCostHistoryDataFetch(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        $flg=$_POST['flg']; 

        $fiscalyearpost=$_POST['fiscalyearpost']; 
        $startdatepost=$_POST['startdatepost']; 
        $enddatepost=$_POST['enddatepost']; 

        $companytypepost=$_POST['companytypepost']; 

        $customerorownerpost=$_POST['customerorownerpost']; 
        
        $storepost=$_POST['storepost']; 
        
        $producttypepost=$_POST['producttypepost'];
        $producttypepost= '"' .implode('","', $producttypepost). '"';
        
        $commoditytypepost=$_POST['commoditytypepost']; 
        
        $commoditypost=$_POST['commoditypost']; 
        
        $gradepost=$_POST['gradepost']; 
        
        $processtypepost=$_POST['processtypepost'];
    
        $cropyearpost=$_POST['cropyearpost'];   

        if($flg == 1){
            $customerorownerpost=implode(',', $customerorownerpost);
            $storepost=implode(',', $storepost);
            $commoditytypepost=implode(',', $commoditytypepost);
            $commoditypost=implode(',', $commoditypost);
            $gradepost=implode(',', $gradepost);
            $processtypepost='"'.implode('","', $processtypepost). '"';
            $cropyearpost=implode(',', $cropyearpost);
        }
        
        if($flg == 2){
            $processtypepost='"'.$processtypepost.'"';
        }

        $query = DB::select("SELECT stores.Name AS StoreName,locations.Name AS FloorMap,lookups.CommodityType,CONCAT_WS(', ', NULLIF(regions.Rgn_Name, ''), NULLIF(zones.Zone_Name, ''), NULLIF(woredas.Woreda_Name, '')) AS Commodity,grdlookup.Grade AS GradeName,crplookup.CropYear AS CropYearName,transactions.ProcessType,uoms.Name AS UomName,transactions.StockInNumOfBag AS NumOfBag,ROUND((transactions.StockInComm/1000),2) AS TON,transactions.StockInFeresula AS Feresula,transactions.StockInComm AS StockIn,transactions.UnitCostComm AS UnitCost,transactions.TotalCostComm AS TotalCost,

            ROUND((((SUM(COALESCE(transactions.TotalCostComm,0)) OVER(PARTITION BY transactions.CommodityType,transactions.woredaId,transactions.Grade,transactions.ProcessType,transactions.CropYear,transactions.uomId ORDER BY transactions.id ASC)) /
            (SUM(COALESCE(transactions.StockInComm,0)) OVER(PARTITION BY transactions.CommodityType,transactions.woredaId,transactions.Grade,transactions.ProcessType,transactions.CropYear,transactions.uomId ORDER BY transactions.id ASC)))),2)  AS RunningAverageCost,

            transactions.TransactionsType,transactions.DocumentNumber,purchaseorders.porderno AS PONumber,purchaseinvoices.docno AS PINVNumber,DATE(transactions.Date) AS Date,purchaseorders.id AS POrdId,purchaseinvoices.id AS PIVId,transactions.HeaderId,
            CONCAT('Commodity Type: ',lookups.CommodityType,'	|	Commodity: ',CONCAT(regions.Rgn_Name,' , ',zones.Zone_Name,' , ',woredas.Woreda_Name),'	|	Grade: ',grdlookup.Grade,'	|	Crop Year: ',crplookup.CropYear,'	|	Process Type: ',transactions.ProcessType) AS CommodityProperty,
            CASE WHEN transactions.customers_id=1 THEN 'Owner' ELSE customers.Name END AS CustomerOwner,transactions.customers_id
            FROM transactions 

            LEFT JOIN woredas ON transactions.woredaId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN lookups ON transactions.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS grdlookup On transactions.Grade=grdlookup.GradeValue LEFT JOIN lookups AS crplookup ON transactions.CropYear=crplookup.CropYearValue LEFT JOIN uoms ON transactions.uomId=uoms.id LEFT JOIN locations ON transactions.LocationId=locations.id LEFT JOIN receivingdetails ON transactions.HeaderId=receivingdetails.HeaderId AND transactions.TransactionsType='Receiving' LEFT JOIN receivings ON transactions.HeaderId=receivings.id AND transactions.TransactionsType='Receiving' LEFT JOIN purchaseorders ON receivings.PoId=purchaseorders.id LEFT JOIN purchaseinvoices ON receivingdetails.PurchaseInvoiceId=purchaseinvoices.id LEFT JOIN customers ON transactions.customers_id=customers.id
            LEFT JOIN stores ON transactions.StoreId=stores.id WHERE transactions.IsOnShipment=0 AND transactions.IsPriceVoid=0 AND DATE(transactions.Date)>= '".$startdatepost."' AND DATE(transactions.Date)<='".$enddatepost."' AND transactions.StoreId IN($storepost) AND transactions.ItemType IN($producttypepost) AND transactions.CommodityType IN($commoditytypepost) AND transactions.woredaId IN($commoditypost) AND transactions.Grade IN($gradepost) AND transactions.ProcessType IN($processtypepost) AND transactions.CropYear IN($cropyearpost) AND transactions.customers_id IN($customerorownerpost) AND transactions.TransactionType!='On-Production' AND transactions.StockInComm>0 ORDER BY lookups.CommodityType ASC,woredas.Woreda_Name ASC,grdlookup.Grade ASC,crplookup.CropYear ASC,transactions.ProcessType ASC");
        
        return datatables()->of($query)->addIndexColumn()->toJson();
    }
    //--------------End Cost History Report------------
    
    
    //--------------Start Requistion & Issue Report----------
    public function reqissueindex(Request $request)
    {
        $companytype=DB::select('SELECT DISTINCT CASE WHEN requisitions.CustomerOrOwner=1 THEN 1 ELSE 2 END AS CompanyTypeValue,CASE WHEN requisitions.CustomerOrOwner=1 THEN "Owner" ELSE "Customer" END AS CompanyType,CONCAT(IFNULL(DATE(requisitions.Date),"")) AS DataProp FROM requisitions ORDER BY requisitions.CustomerOrOwner ASC');
        $customername=DB::select('SELECT DISTINCT requisitions.CustomerOrOwner AS customers_id,CONCAT(IFNULL(CASE WHEN customers.id=1 THEN "Owner" ELSE customers.Name END,""),"  ,  ",IFNULL(customers.TinNumber,"")) AS CustomerName,CONCAT(IFNULL(requisitions.fiscalyear,""),IFNULL(CASE WHEN requisitions.CustomerOrOwner=1 THEN 1 ELSE 2 END,"")) AS DataProp FROM requisitions LEFT JOIN customers ON requisitions.CustomerOrOwner=customers.id ORDER BY customers.id ASC');
        $producttype=DB::select('SELECT DISTINCT lookups.ProductType,CONCAT(IFNULL(requisitions.fiscalyear,""),IFNULL(requisitions.CustomerOrOwner,""),IFNULL(requisitions.SourceStoreId,"")) AS DataProp FROM requisitions LEFT JOIN lookups ON requisitions.Type=lookups.ProductTypeValue WHERE requisitions.Status IN("Issued") ORDER BY lookups.ProductType ASC');
        $requestreason=DB::select('SELECT DISTINCT requisitions.RequestReason AS ReqReasonVal,lookups.RequestReason,CONCAT(IFNULL(requisitions.fiscalyear,""),IFNULL(requisitions.CustomerOrOwner,""),IFNULL(requisitions.SourceStoreId,""),IFNULL(prdlookup.ProductType,"")) AS DataProp FROM requisitions LEFT JOIN lookups ON requisitions.RequestReason=lookups.RequestReasonValue LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue WHERE requisitions.Status IN("Issued") ORDER BY lookups.RequestReason DESC');
        $transactiontype=DB::select('SELECT DISTINCT CASE WHEN requisitiondetails.SupplierId="" AND requisitiondetails.ProductionOrderNo="" THEN "Production" WHEN requisitiondetails.SupplierId>=1 THEN "Receiving" WHEN requisitiondetails.ProductionOrderNo!="" OR requisitiondetails.ProductionOrderNo IS NOT NULL THEN "Production" END AS TransactionsType,CONCAT(IFNULL(requisitions.fiscalyear,""),IFNULL(requisitions.CustomerOrOwner,""),IFNULL(requisitions.SourceStoreId,""),IFNULL(prdlookup.ProductType,""),IFNULL(requisitions.RequestReason,"")) AS DataProp FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue ORDER BY TransactionsType DESC');
        
        $reqdocnum=DB::select('SELECT DISTINCT requisitions.id,requisitions.DocumentNumber AS ReferenceNo,CONCAT(IFNULL(requisitions.fiscalyear,""),IFNULL(requisitions.CustomerOrOwner,""),IFNULL(requisitions.SourceStoreId,""),IFNULL(prdlookup.ProductType,""),IFNULL(requisitions.RequestReason,""),(CASE WHEN requisitiondetails.SupplierId="" AND requisitiondetails.ProductionOrderNo="" THEN "Production" WHEN requisitiondetails.SupplierId>=1 THEN "Receiving" WHEN requisitiondetails.ProductionOrderNo!="" OR requisitiondetails.ProductionOrderNo IS NOT NULL THEN "Production" END)) AS DataProp FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue WHERE requisitions.Status IN("Issued","Void(Issued)") ORDER BY requisitions.DocumentNumber ASC');
        $referece=DB::select('SELECT DISTINCT CONCAT(IFNULL(customers.Name,"-"),IFNULL(requisitions.BookingNumber,"-"),IFNULL(requisitions.Reference,"-")) AS ReferenceVal,CONCAT(IFNULL(customers.Name,"-"),"	,	",IFNULL(requisitions.BookingNumber,"-"),"	,	",IFNULL(requisitions.Reference,"-")) AS ReferenceNo,CONCAT(IFNULL(requisitions.fiscalyear,""),IFNULL(requisitions.CustomerOrOwner,""),IFNULL(requisitions.SourceStoreId,""),IFNULL(prdlookup.ProductType,""),IFNULL(requisitions.RequestReason,""),(CASE WHEN requisitiondetails.SupplierId="" AND requisitiondetails.ProductionOrderNo="" THEN "Production" WHEN requisitiondetails.SupplierId>=1 THEN "Receiving" WHEN requisitiondetails.ProductionOrderNo!="" OR requisitiondetails.ProductionOrderNo IS NOT NULL THEN "Production" END),requisitions.id) AS DataProp FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue LEFT JOIN customers ON requisitions.CustomerReceiver=customers.id ORDER BY ReferenceNo DESC');
        $grnandprd=DB::select('SELECT DISTINCT CONCAT(IFNULL(customers.Name,""),IFNULL(requisitiondetails.GrnNumber,""),IFNULL(requisitiondetails.ProductionOrderNo,""),IFNULL(requisitiondetails.CertNumber,""),IFNULL(requisitiondetails.ExportCertNumber,"")) AS ReferenceVal,CONCAT(IFNULL(customers.Name,"-"),"	,	",IFNULL(requisitiondetails.GrnNumber,"-"),"	,	",IFNULL(requisitiondetails.ProductionOrderNo,"-"),"	,	",IFNULL(requisitiondetails.CertNumber,"-"),"	,	",IFNULL(requisitiondetails.ExportCertNumber,"-")) AS ReferenceNo,CONCAT(IFNULL(requisitions.fiscalyear,""),IFNULL(requisitions.CustomerOrOwner,""),IFNULL(requisitions.SourceStoreId,""),IFNULL(prdlookup.ProductType,""),IFNULL(requisitions.RequestReason,""),(CASE WHEN requisitiondetails.SupplierId="" AND requisitiondetails.ProductionOrderNo="" THEN "Production" WHEN requisitiondetails.SupplierId>=1 THEN "Receiving" WHEN requisitiondetails.ProductionOrderNo!="" OR requisitiondetails.ProductionOrderNo IS NOT NULL THEN "Production" END),requisitions.id,CONCAT(IFNULL(cusowner.Name,"-"),IFNULL(requisitions.BookingNumber,"-"),IFNULL(requisitions.Reference,"-"))) AS DataProp FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN customers AS cusowner ON requisitions.CustomerReceiver=cusowner.id ORDER BY requisitions.id ASC');

        $commoditytype=DB::select('SELECT DISTINCT requisitiondetails.CommodityType,comtypelookup.CommodityType AS CommodityTypeName ,CONCAT(IFNULL(requisitions.fiscalyear,""),requisitions.id,CONCAT(IFNULL(cussupp.Name,""),IFNULL(requisitiondetails.GrnNumber,""),IFNULL(requisitiondetails.ProductionOrderNo,""),IFNULL(requisitiondetails.CertNumber,""),IFNULL(requisitiondetails.ExportCertNumber,""))) AS DataProp FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue LEFT JOIN customers ON requisitions.CustomerReceiver=customers.id LEFT JOIN customers AS cussupp ON requisitiondetails.SupplierId=cussupp.id LEFT JOIN lookups AS comtypelookup ON requisitiondetails.CommodityType=comtypelookup.CommodityTypeValue ORDER BY CommodityTypeName ASC');

        $commodityrec=DB::select('SELECT DISTINCT requisitiondetails.CommodityId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,CONCAT(IFNULL(requisitions.fiscalyear,""),IFNULL(requisitions.CustomerOrOwner,""),IFNULL(requisitions.SourceStoreId,""),IFNULL(prdlookup.ProductType,""),IFNULL(requisitions.RequestReason,""),(CASE WHEN requisitiondetails.SupplierId="" AND requisitiondetails.ProductionOrderNo="" THEN "Production" WHEN requisitiondetails.SupplierId>=1 THEN "Receiving" WHEN requisitiondetails.ProductionOrderNo!="" OR requisitiondetails.ProductionOrderNo IS NOT NULL THEN "Production" END),requisitions.id,IFNULL(requisitiondetails.CommodityType,"")) AS DataProp FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN woredas ON requisitiondetails.CommodityId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id ORDER BY woredas.Woreda_Name ASC');
        
        $grade=DB::select('SELECT DISTINCT grdlookup.GradeValue,grdlookup.Grade,CONCAT(IFNULL(requisitions.fiscalyear,""),requisitions.id,IFNULL(requisitiondetails.CommodityType,""),IFNULL(requisitiondetails.CommodityId,"")) AS DataProp FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN lookups AS grdlookup ON requisitiondetails.Grade=grdlookup.GradeValue ORDER BY grdlookup.Grade ASC');
       
        $processtype=DB::select('SELECT DISTINCT requisitiondetails.ProcessType,CONCAT(IFNULL(requisitions.fiscalyear,""),requisitions.id,IFNULL(requisitiondetails.CommodityType,""),IFNULL(requisitiondetails.CommodityId,""),IFNULL(requisitiondetails.Grade,"")) AS DataProp FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue ORDER BY requisitiondetails.ProcessType ASC');
        
        $cropyear=DB::select('SELECT DISTINCT crplookup.CropYearValue,crplookup.CropYear,CONCAT(IFNULL(requisitions.fiscalyear,""),requisitions.id,IFNULL(requisitiondetails.CommodityType,""),IFNULL(requisitiondetails.CommodityId,""),IFNULL(requisitiondetails.Grade,""),IFNULL(requisitiondetails.ProcessType,"")) AS DataProp FROM requisitiondetails LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue LEFT JOIN lookups AS crplookup ON requisitiondetails.CropYear=crplookup.CropYearValue ORDER BY crplookup.CropYear ASC');
        $statusdata=DB::select('SELECT DISTINCT requisitions.DispatchStatus AS StatusVal,CASE WHEN requisitions.DispatchStatus="-" OR requisitions.DispatchStatus="" THEN "Not-Dispatched" ELSE requisitions.DispatchStatus END AS Status,requisitions.id AS DataProp FROM requisitions LEFT JOIN lookups AS prdlookup ON requisitions.Type=prdlookup.ProductTypeValue WHERE requisitions.Status IN("Issued","Issued(Void)") UNION SELECT DISTINCT requisitions.Status AS StatusVal,"Void" AS Status,requisitions.id AS DataProp FROM requisitions WHERE requisitions.Status="Issued(Void)" ORDER BY Status ASC');

        
        if($request->ajax()) {
            return view('inventory.report.reqissuerep',['fiscalyear'=>$this->fiscalyear,'comptype'=>$companytype,'customerowner'=>$customername,'store'=>$this->storeData(16),'producttype'=>$producttype,'requestreason'=>$requestreason,'transactiontype'=>$transactiontype,'reqdocnum'=>$reqdocnum,'referece'=>$referece,
            'grnandprd'=>$grnandprd,'commoditytype'=>$commoditytype,'commodity'=>$commodityrec,'grade'=>$grade,'processtype'=>$processtype,'cropyear'=>$cropyear,'statusdata'=>$statusdata,'compInfo'=>$this->compInfo,'currentdate'=>$this->currentdate])->renderSections()['content'];
        }
        else{
            return view('inventory.report.reqissuerep',['fiscalyear'=>$this->fiscalyear,'comptype'=>$companytype,'customerowner'=>$customername,'store'=>$this->storeData(16),'producttype'=>$producttype,'requestreason'=>$requestreason,'transactiontype'=>$transactiontype,'reqdocnum'=>$reqdocnum,'referece'=>$referece,
            'grnandprd'=>$grnandprd,'commoditytype'=>$commoditytype,'commodity'=>$commodityrec,'grade'=>$grade,'processtype'=>$processtype,'cropyear'=>$cropyear,'statusdata'=>$statusdata,'compInfo'=>$this->compInfo,'currentdate'=>$this->currentdate]);
        }
    }
    
    public function requisitionIssueReport(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fiscalyear' => 'required',
            'daterange' => 'required',
            'companytype' => 'required',
            'CustomerOrOwner' => 'required',
            
            'store' => 'required',
            'producttype' => 'required',
            'requestreason' => 'required',
            'transactiontype' => 'required',
            'reqissuenum' => 'required',
            'reference' => 'required',
            'suppgrncert' => 'required',

            'commoditytype' => 'required',
            'commodity' => 'required',
            'grade' => 'required',
            'processtype' => 'required',
            'cropyear' => 'required',
            'status' => 'required',
        ]);

        if($validator->passes()){
            return Response::json(['success' =>1]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }
    
    public function reqIssueDataFetch()
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        $fiscalyearpost=$_POST['fiscalyearpost']; 
        $startdatepost=$_POST['startdatepost']; 
        $enddatepost=$_POST['enddatepost']; 

        $companytypepost=$_POST['companytypepost']; 

        $customerorownerpost=$_POST['customerorownerpost']; 
        $customerorownerpost=implode(',', $customerorownerpost);

        $storepost=$_POST['storepost']; 
        $storepost=implode(',', $storepost);

        $producttypepost=$_POST['producttypepost']; 
        $producttypepost= '"' .implode('","', $producttypepost). '"';

        $requestreasonpost=$_POST['requestreasonpost']; 
        $requestreasonpost=implode(',', $requestreasonpost);

        $transactiontypepost=$_POST['transactiontypepost']; 
        $transactiontypepost= '"' .implode('","', $transactiontypepost). '"';

        $requisitionidpost=$_POST['requisitionidpost']; 
        $requisitionidpost=implode(',', $requisitionidpost);

        $buyerbookingrefpost=$_POST['buyerbookingrefpost']; 
        $buyerbookingrefpost= '"' .implode('","', $buyerbookingrefpost). '"';

        $suppliergrvcertpost=$_POST['suppliergrvcertpost']; 
        $suppliergrvcertpost='"' .implode('","', $suppliergrvcertpost). '"';

        $commoditytypepost=$_POST['commoditytypepost']; 
        $commoditytypepost=implode(',', $commoditytypepost);

        $commoditypost=$_POST['commoditypost']; 
        $commoditypost=implode(',', $commoditypost);
        
        $gradepost=$_POST['gradepost']; 
        $gradepost=implode(',', $gradepost);

        $processtypepost=$_POST['processtypepost']; 
        $processtypepost='"'.implode('","', $processtypepost). '"';

        $cropyearpost=$_POST['cropyearpost']; 
        $cropyearpost=implode(',', $cropyearpost);

        $dispatchvoidpost=$_POST['dispatchvoidpost']; 
        $dispatchvoidpost='"' .implode('","', $dispatchvoidpost). '"';
        
        $query = DB::select("SELECT reqreas.RequestReason,customers.Name AS SupplierName,requisitiondetails.GrnNumber,CONCAT(IFNULL(requisitiondetails.ProductionOrderNo,''),' , ',IFNULL(requisitiondetails.CertNumber,'')) AS ProductionCertNumber,IFNULL(requisitiondetails.ExportCertNumber,'') AS ExportCertNumber,stores.Name AS StoreName,locations.Name AS FloorMap,cmlookups.CommodityType AS CommodityType,CONCAT_WS(', ',NULLIF(regions.Rgn_Name,''),NULLIF(zones.Zone_Name,''),NULLIF(woredas.Woreda_Name,'')) AS Commodity,grlookups.Grade AS GradeName,crlookups.CropYear AS CropYearName,prlookups.ProcessType,uoms.Name AS UOM,requisitiondetails.NumOfBag,requisitiondetails.BagWeight,requisitiondetails.TotalKg,requisitiondetails.NetKg,ROUND((requisitiondetails.NetKg/1000),2) AS TON,requisitiondetails.Feresula,VarianceShortage,VarianceOverage,CASE WHEN requisitions.DispatchStatus='' OR requisitions.DispatchStatus='-' THEN 'Not-Dispatched' ELSE requisitions.DispatchStatus END AS DispatchStatus,IFNULL(requisitiondetails.Memo,'') AS Remark, 

            CASE WHEN requisitions.CustomerOrOwner=1 THEN 'Owner' ELSE cusown.Name END AS CustomerOwner,
            CONCAT('Requisition & Issue No.: ',IFNULL(requisitions.DocumentNumber,''),'	|	Date: ',IFNULL(DATE(requisitions.Date),''),'	|	Remark: ',IFNULL(requisitions.Purpose,'')) AS ReqDocProp,
            CONCAT('Buyer: ',IFNULL(cusrec.Name,''),'	|	Booking No.: ',IFNULL(requisitions.BookingNumber,''),'	|	Reference: ',IFNULL(requisitions.Reference,'')) AS BuyerBookingReference,
            (SELECT id FROM receivings WHERE receivings.DocumentNumber=requisitiondetails.GrnNumber LIMIT 1) AS RecId,
            (SELECT id FROM prd_orders WHERE prd_orders.ProductionOrderNumber=requisitiondetails.ProductionOrderNo LIMIT 1) AS PrdId,
            (SELECT commoditybegdetails.commoditybegs_id FROM commoditybegdetails WHERE commoditybegdetails.ProductionNumber=requisitiondetails.ProductionOrderNo ORDER BY commoditybegdetails.id DESC LIMIT 1) AS BegId,
            requisitions.id AS ReqId

            FROM requisitiondetails 
            LEFT JOIN woredas ON requisitiondetails.CommodityId = woredas.id 
            LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions on zones.Rgn_Id = regions.id 
            LEFT JOIN uoms ON requisitiondetails.DefaultUOMId = uoms.id 
            LEFT JOIN locations ON requisitiondetails.LocationId=locations.id 
            LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id 
            LEFT JOIN lookups AS grlookups ON requisitiondetails.Grade=grlookups.GradeValue 
            LEFT JOIN lookups AS prlookups ON requisitiondetails.ProcessType=prlookups.ProcessTypeValue 
            LEFT JOIN lookups AS crlookups ON requisitiondetails.CropYear=crlookups.CropYearValue 
            LEFT JOIN lookups AS cmlookups ON requisitiondetails.CommodityType=cmlookups.CommodityTypeValue 
            LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id 
            LEFT JOIN lookups AS reqreas ON requisitions.RequestReason=reqreas.RequestReasonValue 
            LEFT JOIN customers AS cusown ON requisitions.CustomerOrOwner=cusown.id 
            LEFT JOIN customers AS cusrec ON requisitions.CustomerReceiver=cusrec.id 
            LEFT JOIN customers AS cussup ON requisitiondetails.SupplierId=cussup.id 
            LEFT JOIN stores ON requisitions.SourceStoreId=stores.id 

            WHERE 
            DATE(requisitions.Date)>='".$startdatepost."' AND DATE(requisitions.Date)<='".$enddatepost."' 
            AND requisitions.CompanyType IN($companytypepost) 
            AND requisitions.CustomerOrOwner IN($customerorownerpost)
            AND requisitions.SourceStoreId IN($storepost)
            AND (CASE WHEN requisitions.Type=1 THEN 'Commodity' ELSE 'Goods' END) IN($producttypepost)
            AND requisitions.RequestReason IN($requestreasonpost)
            AND (CASE WHEN requisitiondetails.SupplierId='' AND requisitiondetails.ProductionOrderNo='' THEN 'Production' WHEN requisitiondetails.SupplierId>=1 THEN 'Receiving' WHEN requisitiondetails.ProductionOrderNo!='' OR requisitiondetails.ProductionOrderNo IS NOT NULL THEN 'Production' END) IN($transactiontypepost)
            AND requisitions.id IN($requisitionidpost)
            AND CONCAT(IFNULL(cusrec.Name,'-'),IFNULL(requisitions.BookingNumber,'-'),IFNULL(requisitions.Reference,'-')) IN($buyerbookingrefpost)
            AND CONCAT(IFNULL(cussup.Name,''),IFNULL(requisitiondetails.GrnNumber,''),IFNULL(requisitiondetails.ProductionOrderNo,''),IFNULL(requisitiondetails.CertNumber,''),IFNULL(requisitiondetails.ExportCertNumber,'')) IN($suppliergrvcertpost)
            AND requisitiondetails.CommodityType IN($commoditytypepost)
            AND requisitiondetails.CommodityId IN($commoditypost)
            AND requisitiondetails.Grade IN($gradepost)
            AND requisitiondetails.ProcessType IN($processtypepost)
            AND requisitiondetails.CropYear IN($cropyearpost)
            AND requisitions.DispatchStatus IN($dispatchvoidpost)

            ORDER BY CustomerOwner ASC,StoreName ASC,CommodityType ASC,ReqDocProp ASC,BuyerBookingReference ASC");

        return datatables()->of($query)->addIndexColumn()->toJson();
    }
    //--------------End Requistion & Issue Report------------

    //--------------Start Commodity Movement Report------------
    public function stockmovementindex(Request $request)
    {
        $companytype=DB::select('SELECT DISTINCT CASE WHEN transactions.customers_id=1 THEN 1 ELSE 2 END AS CompanyTypeValue,CASE WHEN transactions.customers_id=1 THEN "Owner" ELSE "Customer" END AS CompanyType,CONCAT(IFNULL(DATE(transactions.Date),"")) AS DataProp FROM transactions ORDER BY transactions.customers_id ASC');
        $customername=DB::select('SELECT DISTINCT transactions.customers_id,CONCAT_WS(", ",NULLIF(CASE WHEN customers.id=1 THEN "Owner" ELSE customers.Name END,""),NULLIF(customers.TinNumber,"")) AS CustomerName,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(CASE WHEN transactions.customers_id=1 THEN 1 ELSE 2 END,"")) AS DataProp FROM transactions LEFT JOIN customers ON transactions.customers_id=customers.id ORDER BY customers.id ASC');
        $producttype=DB::select('SELECT DISTINCT transactions.ItemType AS ProductType,transactions.StoreId,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,"")) AS DataProp FROM transactions ORDER BY transactions.ItemType ASC');
        
        $commoditytype=DB::select('SELECT DISTINCT transactions.CommodityType,lookups.CommodityType AS CommodityTypeName,CONCAT(IFNULL(transactions.DocumentNumber,""),IFNULL(transactions.CertNumber,"")) AS ReferenceNo,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.CommodityType=lookups.CommodityTypeValue WHERE transactions.TransactionsType IN("Receiving","Production","Beginning") ORDER BY lookups.CommodityType ASC');
        $commodityrec=DB::select('SELECT DISTINCT transactions.woredaId AS CommodityId,CONCAT_WS(", ",NULLIF(regions.Rgn_Name,""),NULLIF(zones.Zone_Name,""),NULLIF(woredas.Woreda_Name,"")) AS Origin,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,"")) AS DataProp FROM transactions LEFT JOIN woredas ON transactions.woredaId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id WHERE transactions.TransactionsType IN("Receiving","Production","Beginning") ORDER BY woredas.Woreda_Name ASC');
        
        $grade=DB::select('SELECT DISTINCT lookups.GradeValue,lookups.Grade,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.Grade=lookups.GradeValue WHERE transactions.TransactionsType IN("Receiving","Production","Beginning") ORDER BY lookups.Grade ASC');
        $processtype=DB::select('SELECT DISTINCT transactions.ProcessType,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,""),IFNULL(transactions.Grade,"")) AS DataProp FROM transactions WHERE transactions.TransactionsType IN("Receiving","Production","Beginning") ORDER BY transactions.ProcessType ASC');
        $cropyear=DB::select('SELECT DISTINCT lookups.CropYearValue,lookups.CropYear,CONCAT(IFNULL(transactions.FiscalYear,""),IFNULL(transactions.customers_id,""),IFNULL(transactions.StoreId,""),IFNULL(transactions.ItemType,""),IFNULL(transactions.CommodityType,""),IFNULL(transactions.woredaId,""),IFNULL(transactions.Grade,""),IFNULL(transactions.ProcessType,"")) AS DataProp FROM transactions LEFT JOIN lookups ON transactions.CropYear=lookups.CropYearValue WHERE transactions.TransactionsType IN("Receiving","Production","Beginning") ORDER BY lookups.CropYear ASC');
    
        if($request->ajax()) {
            return view('inventory.report.stockmovement',['fiscalyear'=>$this->fiscalyear,'comptype'=>$companytype,'store'=>$this->storeData(15),'producttype'=>$producttype,'commoditytype'=>$commoditytype,
            'customerowner'=>$customername,'commodity'=>$commodityrec,'grade'=>$grade,'processtype'=>$processtype,'cropyear'=>$cropyear,'compInfo'=>$this->compInfo,'currentdate'=>$this->currentdate])->renderSections()['content'];
        }
        else{
            return view('inventory.report.stockmovement',['fiscalyear'=>$this->fiscalyear,'comptype'=>$companytype,'store'=>$this->storeData(15),'producttype'=>$producttype,'commoditytype'=>$commoditytype,
            'customerowner'=>$customername,'commodity'=>$commodityrec,'grade'=>$grade,'processtype'=>$processtype,'cropyear'=>$cropyear,'compInfo'=>$this->compInfo,'currentdate'=>$this->currentdate]);
        }
    }
    
    public function stockMovementReport(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fiscalyear' => 'required',
            'daterange' => 'required',
            'companytype' => 'required',
            'CustomerOrOwner' => 'required',
            
            'store' => 'required',
            'producttype' => 'required',

            'commoditytype' => 'required',
            'commodity' => 'required',
            'grade' => 'required',
            'processtype' => 'required',
            'cropyear' => 'required',
        ]);

        if($validator->passes()){
            return Response::json(['success' =>1]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }
    
    public function stockMovementDataFetch(){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");

        $fiscalyearpost=$_POST['fiscalyearpost']; 
        $startdatepost=$_POST['startdatepost']; 
        $enddatepost=$_POST['enddatepost']; 

        $companytypepost=$_POST['companytypepost']; 

        $customerorownerpost=$_POST['customerorownerpost']; 
        $customerorownerpost=implode(',', $customerorownerpost);
        
        $storepost=$_POST['storepost']; 

        
        $producttypepost=$_POST['producttypepost'];
        $producttypepost= '"' .implode('","', $producttypepost). '"';
        
        $commoditytypepost=$_POST['commoditytypepost']; 
        $commoditytypepost=implode(',', $commoditytypepost);
        
        $commoditypost=$_POST['commoditypost']; 
        $commoditypost=implode(',', $commoditypost);
        
        $gradepost=$_POST['gradepost']; 
        $gradepost=implode(',', $gradepost);
        
        $processtypepost=$_POST['processtypepost'];
        $processtypepost='"'.implode('","', $processtypepost). '"';
    
        $cropyearpost=$_POST['cropyearpost'];   
        $cropyearpost=implode(',', $cropyearpost);

        $query = DB::select("SELECT stores.Name AS StoreName,locations.Name AS FloorMap,lookups.CommodityType,CONCAT_WS(', ',NULLIF(regions.Rgn_Name,''),NULLIF(zones.Zone_Name,''),NULLIF(woredas.Woreda_Name,'')) AS Commodity,grdlookup.Grade AS GradeName,crplookup.CropYear AS CropYearName,transactions.ProcessType,uoms.Name AS UOM,

            transactions.StockInComm AS StockInByKG,transactions.StockOutComm AS StockOutByKG,ROUND((SUM(COALESCE(StockInComm,0)-COALESCE(StockOutComm,0))OVER(PARTITION BY transactions.CommodityType,transactions.woredaId,transactions.Grade,transactions.ProcessType,transactions.CropYear,transactions.uomId ORDER BY transactions.id ASC)),2) AS RunningQtyByKG,

            transactions.StockInNumOfBag AS StockInByBag,transactions.StockOutNumOfBag AS StockOutByBag,(SUM(COALESCE(StockInNumOfBag,0)-COALESCE(StockOutNumOfBag,0))OVER(PARTITION BY transactions.CommodityType,transactions.woredaId,transactions.Grade,transactions.ProcessType,transactions.CropYear,transactions.uomId ORDER BY transactions.id ASC)) AS RunningQtyByBag,

            transactions.TransactionsType,transactions.DocumentNumber AS Reference,DATE(transactions.Date) AS Date,
            CASE WHEN transactions.customers_id=1 THEN 'Owner' ELSE cusowner.Name END AS CustomerOwner,
            CONCAT('Commodity Type: ',lookups.CommodityType,'	|	Commodity: ',CONCAT_WS(', ',NULLIF(regions.Rgn_Name,''),NULLIF(zones.Zone_Name,''),NULLIF(woredas.Woreda_Name,'')),'	|	Grade: ',grdlookup.Grade,'	|	Crop Year: ',crplookup.CropYear,'	|	Process Type: ',transactions.ProcessType,'	|	UOM/ Bag: ',uoms.Name) AS CommodityProperty,
            CONCAT(stores.Name,', ',locations.Name,', ',lookups.CommodityType,', ',CONCAT_WS(', ',NULLIF(regions.Rgn_Name,''),NULLIF(zones.Zone_Name,''),NULLIF(woredas.Woreda_Name,'')),', ',grdlookup.Grade,', ',crplookup.CropYear,', ',transactions.ProcessType,', ',uoms.Name) AS AllCommodityProperty,
            transactions.HeaderId
            FROM transactions 

            LEFT JOIN woredas ON transactions.woredaId=woredas.id 
            LEFT JOIN zones ON woredas.zone_id=zones.id 
            LEFT JOIN regions ON zones.Rgn_Id=regions.id 
            LEFT JOIN lookups ON transactions.CommodityType=lookups.CommodityTypeValue 
            LEFT JOIN lookups AS grdlookup ON transactions.Grade=grdlookup.GradeValue 
            LEFT JOIN lookups as crplookup ON transactions.CropYear=crplookup.CropYearValue 
            LEFT JOIN uoms ON transactions.uomId=uoms.id 
            LEFT JOIN customers ON transactions.SupplierId=customers.id
            LEFT JOIN customers AS cusowner ON transactions.customers_id=cusowner.id  
            LEFT JOIN locations ON transactions.LocationId=locations.id 
            LEFT JOIN stores ON transactions.StoreId=stores.id

            WHERE 
            transactions.IsOnShipment=0 
            AND transactions.TransactionType!='On-Production'
            AND DATE(transactions.Date)>='".$startdatepost."' 
            AND DATE(transactions.Date)<='".$enddatepost."' 
            AND transactions.customers_id IN($customerorownerpost)
            AND transactions.StoreId IN($storepost)
            AND transactions.ItemType IN($producttypepost)
            AND transactions.CommodityType IN($commoditytypepost)
            AND transactions.woredaId IN($commoditypost)
            AND transactions.Grade IN($gradepost)
            AND transactions.ProcessType IN($processtypepost)
            AND transactions.CropYear IN($cropyearpost)

            ORDER BY CustomerOwner ASC,woredas.Woreda_Name ASC,transactions.CommodityType ASC,transactions.Grade ASC,transactions.ProcessType ASC,transactions.CropYear ASC,transactions.uomId ASC");
        
        return datatables()->of($query)->addIndexColumn()->toJson();
    }
    //--------------End Commodity Movement Report------------

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
