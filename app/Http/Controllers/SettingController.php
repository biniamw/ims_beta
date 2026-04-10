<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\companymrc;
use App\Models\customer;
use App\Models\mrc;
use App\Models\purchaser;
use App\Models\setting;
use App\Models\companyinfo;
use App\Models\overtime;
use App\Models\overtimesetting;
use App\Models\payrollsetting;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\Models\store;
use App\Models\storemrc;
use Response;
use Image;
use Exception;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $setting=DB::table('settings')->latest()->first();
        $otdayoffid=$setting->overtime_dayoff_id;
        $otholidayid=$setting->overtime_holiday_id;
        $companyinfo=DB::table('companyinfos')->latest()->first();
        $counrtys=DB::select('select Name from country order by Name asc');
        $vats=DB::select('select * from vat where Value not in(select VATDeduct from companyinfos)');
        $users=DB::select('select * from users where IsPurchaser=0');
        $purchaser=DB::select('select * from users where IsPurchaser=1');
        $witholds=DB::select('select * from withold where Value not in(select WitholdDeduct from companyinfos)');
        $fiscalyear=DB::select('select * from fiscalyear');
        //$fiscalyearattr=DB::select('select * from fiscalyear where fiscalyear.FiscalYear=2021');
        $fiscalyearattr=DB::table('fiscalyear')->where('FiscalYear',$setting->FiscalYear+1)->first();
        $store= store::join('storemrcs','storemrcs.store_id','stores.id')
        ->where('stores.type','Shop')
        ->distinct()
        ->get(['stores.id','stores.Name']);
        $stores=store::where('id','>',1)->where('type','Shop')->get(['id','Name']);
        $overtimedata = overtime::orderBy("id","ASC")->where("Status","Active")->get();
        $otdayoffdata = overtime::orderBy("id","ASC")->where("id","!=",$otdayoffid)->where("Status","Active")->get();
        $otholidaydata = overtime::orderBy("id","ASC")->where("id","!=",$otholidayid)->where("Status","Active")->get();

        $otdayoffseldata = overtime::orderBy("id","ASC")->where("id",$otdayoffid)->where("Status","Active")->get();
        $otholidayseldata = overtime::orderBy("id","ASC")->where("id",$otholidayid)->where("Status","Active")->get();
        if($request->ajax()) {
            return view('setting.setting',['setting'=>$setting,'companyinfo'=>$companyinfo,'fiscalyear'=>$fiscalyear,'counrtys'=>$counrtys,'vats'=>$vats,'witholds'=>$witholds,'users'=>$users,
            'purchaser'=>$purchaser,'fiscalyearattr'=>$fiscalyearattr,'store'=>$store,'stores'=>$stores,'overtimedata'=>$overtimedata,'otdayoffdata'=>$otdayoffdata,'otholidaydata'=>$otholidaydata,'otdayoffseldata'=>$otdayoffseldata,'otholidayseldata'=>$otholidayseldata])->renderSections()['content'];
        }
        else{
            return view('setting.setting',['setting'=>$setting,'companyinfo'=>$companyinfo,'fiscalyear'=>$fiscalyear,'counrtys'=>$counrtys,'vats'=>$vats,'witholds'=>$witholds,'users'=>$users,
            'purchaser'=>$purchaser,'fiscalyearattr'=>$fiscalyearattr,'store'=>$store,'stores'=>$stores,'overtimedata'=>$overtimedata,'otdayoffdata'=>$otdayoffdata,'otholidaydata'=>$otholidaydata,'otdayoffseldata'=>$otdayoffseldata,'otholidayseldata'=>$otholidayseldata]);
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

    public function getlogo()
    {
        $findid="1";
        $comp=companyinfo::find($findid);
        if($comp->Logo!=null)
        {
            $image = Image::make($comp->Logo);
            $responsebar = Response::make($image->encode('jpeg'));
            $responsebar->header('Content-Type', 'image/jpeg');
            return response()->json(['getCompanyLogos' => '<img class="card-img-top" src="data:image/jpg;base64,'.chunk_split(base64_encode($comp->Logo)).'"  />', 
        ]);
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
        session(['companyName'=>$request->input('name')]);
        $purchaserval=$request->PurchaserName;
        $payrow=$request->payrow;
        $payrolldata=[];
        $image=null;
        $validator = Validator::make($request->all(), [
            'SkuNumber' => ['required','not_in:0'],
            'CustomerCodeNumber' => ['required','not_in:0'],
            'ReceivingNumber' => ['required','not_in:0'],
            'HoldNumber' => ['required','not_in:0'],
            'RequisitionNumber' => ['required','not_in:0'],
            'TransferNumber' => ['required','not_in:0'],
            'IssueNumber' => ['required','not_in:0'],
            'TransferIssueNumber' => ['required','not_in:0'],
            'AdjustmentNumber' => ['required','not_in:0'],
            'BeginingNumber' => ['required','not_in:0'],
            'DeadStockAvoidanceNumber' => ['required','not_in:0'],
            'DeadStockRemNumber' => ['required','not_in:0'],
            'WitholdingMinimumAmount' => ['required'],
            'FiscalYear' => ['required'],
            'ItemCodeNumber' => ['required'],
            'CreditSalesLimitStart' => ['required'],
            'CreditSalesLimitDay' => ['required'],
            'CreditSalesLimitEnd' => ['nullable','required_if:unlimitflag,0','gt:CreditSalesLimitStart'],
            'CreditSalesAdditionPercentage' => ['required'],
            'MinimumPeriod' => ['required'],
            'PurchaseLimit' => ['required'],
            'MinimumPurchaseAmount' => ['required'],
        ]);
        $newval=$request->FiscalYear;
        $oldval=$request->fiscalyeari;
        $newvaln = (float)$newval;
        $oldvaln = (float)$oldval;
        if($request->hasfile('item_image'))
        {
            $image_file = $request->item_image;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            session(["image_file"=>$image]); 
        }
        if(session("image_file"))
        {
            $image=session("image_file");
        }
        if($newvaln<$oldvaln)
        {
            return Response::json(['valerror' =>  "error"]);
        }
        else if($validator->passes())
        {
            $findid="1";
            $sett=setting::find($findid);
            $sett->skunumber=trim($request->input('SkuNumber'));
            $sett->prefix=trim($request->input('SKUPrefix'));
            $sett->CustomerCodePrefix=trim($request->input('CustomerCodePrefix'));
            $sett->CustomerCodeNumber=trim($request->input('CustomerCodeNumber'));
            $sett->CustomerCodeType=trim($request->input('cuscodecheckboxVali'));
            $sett->HoldPrefix=trim($request->input('HoldPrefix'));
            $sett->HoldNumber=trim($request->input('HoldNumber'));
            $sett->GRVPrefix=trim($request->input('ReceivingPrefix'));
            $sett->GRVNumber=trim($request->input('ReceivingNumber'));
            $sett->RequisitionPrefix=trim($request->input('RequisitionPrefix'));
            $sett->RequisitionNumber=trim($request->input('RequisitionNumber'));
            $sett->IssuePrefix=trim($request->input('IssuePrefix'));
            $sett->IssueNumber=trim($request->input('IssueNumber'));
            $sett->TransferIssuePrefix=trim($request->input('TansferIssuePrefix'));
            $sett->TransferIssueNumber=trim($request->input('TransferIssueNumber'));
            $sett->AdjustmentPrefix=trim($request->input('AdjustmentPrefix'));
            $sett->AdjustmentNumber=trim($request->input('AdjustmentNumber'));
            $sett->TransferPrefix=trim($request->input('TransferPrefix'));
            $sett->TransferNumber=trim($request->input('TransferNumber'));
            $sett->BeginingPrefix=trim($request->input('BeginingPrefix'));
            $sett->BeginingNumber=trim($request->input('BeginingNumber'));
            $sett->DeadStockPrefix=trim($request->input('DeadStockAvoidancePrefix'));
            $sett->DeadStockCount=trim($request->input('DeadStockAvoidanceNumber'));
            $sett->DeadStockSalesPrefix=trim($request->input('DeadStockRemovalPrefix'));
            $sett->	DeadStockSalesCount=trim($request->input('DeadStockRemNumber'));
            $sett->WitholdMinimumAmount=trim($request->input('WitholdingMinimumAmount'));
            $sett->SalesWithHold=trim($request->input('SalesWitholdMinAmount'));
            $sett->vatDeduct=trim($request->input('SalesVatDeductMinAmount'));
            $sett->BarcodeRequire=trim($request->input('RequireSku'));
            $sett->ItemCodePrefix=trim($request->input('ItemCodePrefix'));
            $sett->ItemCodeNumber=trim($request->input('ItemCodeNumber'));
            $sett->ItemCodeType=trim($request->input('itemcodeval'));
            $sett->FiscalYear=trim($request->input('FiscalYear'));
            $sett->wholesalefeature=trim($request->input('wholesalefeature'));
            $sett->costType=trim($request->input('costType'));
            $sett->SalesHoldPrefix=trim($request->input('salesHoldPrefix'));
            $sett->SalesHoldNumber=$request->salesHoldNumber;
            $sett->pendingdays=$request->pendingwait;
            $sett->nofsalesonpending=$request->nofsalesonpending;
            $sett->isaleblock=$request->isaleblock;
            $sett->CreditSalesLimitStart=$request->CreditSalesLimitStart;
            $sett->CreditSalesLimitEnd=$request->CreditSalesLimitEnd;
            $sett->CreditSalesLimitFlag=$request->unlimitflag;
            $sett->CreditSalesLimitDay=$request->CreditSalesLimitDay;
            $sett->CreditSalesAdditionPercentage=$request->CreditSalesAdditionPercentage;
            $sett->SettleAllOutstanding=$request->settleoutstanding;
            $sett->MinimumPeriod=$request->MinimumPeriod;
            $sett->PurchaseLimit=$request->PurchaseLimit;
            $sett->MinimumPurchaseAmount=$request->MinimumPurchaseAmount;
            $sett->overtime_dayoff_id=$request->OvertimeLevelDayOff;
            $sett->overtime_holiday_id=$request->OvertimeLevelHoliday;
            $sett->save();

            $comp=companyinfo::find($findid);
            $comp->Name=trim($request->input('name'));
            $comp->TIN =trim($request->input('TinNumber'));
            $comp->VATReg =trim($request->input('VatNumber'));
            $comp->VATDeduct=trim($request->input('VatDeduct'));
            $comp->WitholdDeduct=trim($request->input('WitholdDeduct'));
            $comp->Phone =trim($request->input('PhoneNumber'));
            $comp->OfficePhone =trim($request->input('OfficePhoneNumber'));
            $comp->Email =trim($request->input('EmailAddress'));
            $comp->Address=trim($request->input('Address'));
            $comp->Website =trim($request->input('Website'));
            $comp->Country=trim($request->input('Country'));
            $comp->Logo=$image;
            $comp->save();

            if($purchaserval!=null)
            {
                DB::table('users')
                ->update(['IsPurchaser' =>'0']);
                foreach ($request->PurchaserName as $PurchaserName)
                {
                    DB::table('users')
                    ->where('id', $PurchaserName)
                    ->update(['IsPurchaser' =>'1']);
                }
            }
            if($purchaserval==null)
            {
                DB::table('users')
                ->update(['IsPurchaser' =>'0']);
            }

            payrollsetting::truncate();
            if($payrow!=null){
                foreach ($request->payrow as $key => $value)
                {
                    $payrolldata[]=['MinAmount'=>$value['MinAmount'],'MaxAmount'=>$value['MaxAmount']??0,'TaxRate'=>$value['TaxRate']??0,'Deduction'=>$value['Deduction']??0,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                }
                payrollsetting::insert($payrolldata);
            }

            return Response::json(['success' => '1']);
        }
        return Response::json(['errors' => $validator->errors()]);
    }

    public function showCompMrcData()
    {
        $mrc=DB::select('SELECT * FROM companymrcs WHERE companymrcs.IsDeleted=1');
        return datatables()->of($mrc)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
                $btn =  ' <a data-id="'.$data->id.'" data-mrcnumber="'.$data->MRCNumber.'" data-status="'.$data->ActiveStatus.'" class="btn btn-icon btn-gradient-info btn-sm" data-toggle="modal" id="mediumButton" data-target="#examplemodal-mrcedit" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#examplemodal-mrcdelete" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function storeCompanyMRC(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MrcNumber'=>'required|min:10|max:13|unique:mrcs,MRCNumber|unique:customers,MRCNumber|unique:companymrcs,MRCNumber',
            'status' => ['required','string','max:255','min:2'],
        ]);
         if ($validator->passes()) 
         {
            $companymrc=new companymrc;
            $companymrc->MRCNumber=trim($request->input('MrcNumber'));
            $companymrc->ActiveStatus=trim($request->input('status'));
            $companymrc->IsDeleted=1;
            $companymrc->save();
            return Response::json(['success' => '1']);
         }
        return Response::json(['errors' => $validator->errors()]);
    }

    public function updateCustomerMRC(Request $request)
    {
        $findid=$request->id;
        $findcusid=$request->CustomerId;
        $companymrc=companymrc::find($findid);
        $customer=customer::find($findcusid);
        $validator = Validator::make($request->all(), [
        'mrcnumber'=>"required|min:10|max:13|unique:companymrcs,MRCNumber,$findid|unique:customers,MRCNumber|unique:mrcs,MRCNumber",
        'status'=>"required|min:2|max:255",
        ]);
        if ($validator->passes()) 
        {
            $companymrc->MRCNumber=trim($request->input('mrcnumber'));
            $companymrc->ActiveStatus=trim($request->input('status'));
            $companymrc->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function deleteCompanyMRC($id)
    {
        $getmrcnum=companymrc::find($id);
        $mrcnum=$getmrcnum->MRCNumber;

        $salesmrcs=DB::select('select CustomerMRC from sales where CustomerMRC='.$mrcnum.''); 
        $salesholdmrcs=DB::select('select CustomerMRC from sales_holds where CustomerMRC='.$mrcnum.''); 
        if($salesmrcs==null&& $salesholdmrcs==null)
        {
            $companymrc = companymrc::find($id);
            $companymrc->delete();
            return Response::json(['success' => 'MRC Record Deleted success fully']);
        }
        else
        {
            return Response::json(['errors' => 'You cant delete MRC</br> Some records saved with this MRC']);
        }  
    }


    public function showFiscalYearPeriods(Request $request)
    {
        $query=DB::select('SELECT * FROM fiscalyearperiods WHERE fiscalyearperiods.IsDisplayed=1 ORDER BY fiscalyearperiods.id ASC');
        return datatables()->of($query)->toJson();
    }

    public function changeFiscalYear(Request $request)
    {
        $docchangeflag=$request->resetdocvalfy;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->beginingId;
        $findid=$request->beginingId;
        $valstore=$request->store;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $newfiscalyrs=$fiscalyr+1;
        $bprefix=$settingsval->EndingPrefix;
        $bnumber=$settingsval->EndingNumber;
        $numberPadding=sprintf("%06d", $bnumber);
        $bgNumber=$bprefix.$numberPadding;
        $newfiscalyrhid="";
        $date = Carbon::now()->toDateTimeString();
        $constdate = $newfiscalyrs."-07-07 17:00:00";
        $getPendingQty=DB::select('SELECT COUNT(id) AS ReceivingCount FROM receivings WHERE receivings.Status IN ("Pending","Checked")');
        foreach($getPendingQty as $row)
        {
            $receivingcnt=$row->ReceivingCount;
        }
        $reccnt = (float)$receivingcnt;
        $getTransferQty=DB::select('SELECT COUNT(id) AS TransferSourceCount FROM transfers WHERE transfers.Status IN ("Pending","Approved")');
        foreach($getTransferQty as $row)
        {
            $transfersrccnt=$row->TransferSourceCount;
        }
        $trsrccnt = (float)$transfersrccnt;

        $getTransferDestQty=DB::select('SELECT COUNT(id) AS TransferDestCount FROM transfers WHERE transfers.Status IN ("Pending","Approved")');
        foreach($getTransferDestQty as $row)
        {
            $transferdestcnt=$row->TransferDestCount;
        }
        $trdestcnt = (float)$transferdestcnt;

        $getRequestonQty=DB::select('SELECT COUNT(id) AS RequistionSrcCount FROM requisitions WHERE requisitions.Status IN ("Pending","Approved")');
        foreach($getRequestonQty as $row)
        {
            $requistionsrccnt=$row->RequistionSrcCount;
        }
        $reqsrc = (float)$requistionsrccnt;

        $getSalesCount=DB::select('SELECT COUNT(id) AS SalesCount FROM sales WHERE sales.Status IN ("pending..","Checked")');
        foreach($getSalesCount as $row)
        {
            $salescnt=$row->SalesCount;
        }
        $slcnt = (float)$salescnt;

        $getBeginingCount=DB::select('SELECT COUNT(id) AS BeginingCount FROM beginings WHERE beginings.Status!="Posted"');
        foreach($getBeginingCount as $row)
        {
            $beginingcnt=$row->BeginingCount;
        }
        $bgcnt = (float)$beginingcnt;

        $getRecHoldCount=DB::select('SELECT COUNT(id) AS ReceivingHoldCount FROM receivingholds');
        foreach($getRecHoldCount as $row)
        {
            $receivingholdcnt=$row->ReceivingHoldCount;
        }
        $recholdcnt = (float)$receivingholdcnt;

        $getSalesHoldCount=DB::select('SELECT COUNT(id) AS SalesHoldCount FROM sales_holds');
        foreach($getSalesHoldCount as $row)
        {
            $salesholdcnt=$row->SalesHoldCount;
        }
        $slholdcnt = (float)$salesholdcnt;

        $getnewfiscalyr=DB::select('SELECT * from fiscalyear where fiscalyear.FiscalYear='.$newfiscalyrs);
        foreach($getnewfiscalyr as $row)
        {
            $newfiscalyrhid=$row->id;
        }

        // if($reccnt>=1)
        // {
        //     return Response::json(['recerror' =>  "error"]);  
        // }
        // else if($trsrccnt>=1)
        // {
        //     return Response::json(['trsrcerror' =>  "error"]);  
        // }
        // else if($trdestcnt>=1)
        // {
        //     return Response::json(['trdesterror' =>  "error"]);  
        // }
        // else if($reqsrc>=1)
        // {
        //     return Response::json(['reqerror' =>  "error"]);  
        // }
        // else if($slcnt>=1)
        // {
        //     return Response::json(['saleserror' =>  "error"]);  
        // }
        // else if($bgcnt>=1)
        // {
        //     return Response::json(['beginingerror' =>  "error"]);  
        // }
        // else if($recholdcnt>=1)
        // {
        //     return Response::json(['recholderror' =>  "error"]);  
        // }
        // else if($slholdcnt>=1)
        // {
        //     return Response::json(['salesholderror' =>  "error"]);  
        // }
        // else if($date<$constdate)
        // {
        //     return Response::json(['timeerror' =>  "error"]);  
        // }
        // else
        // {
            DB::table('settings')
            ->where('id', 1)
            ->update(['IsFiscalYearChanged' =>"1",'FiscalYear'=>$fiscalyr+1]);

            DB::table('fiscalyearperiods')
            ->where('header_id',$newfiscalyrhid)
            ->update(['IsDisplayed' =>"1"]);

            DB::table('stores')
            ->update(['IsOnCount' =>"1"]);

            if($docchangeflag==1){
                DB::table('settings')
                ->where('id', 1)
                ->update([
                    'GRVNumber' =>"1",
                    'RequisitionNumber'=>"1",
                    'IssueNumber'=>"1",
                    'AdjustmentNumber'=>"1",
                    'TransferNumber'=>"1",
                    'TransferIssueNumber'=>"1",
                    'HoldNumber'=>"1",
                ]);
            }

            return Response::json(['success' =>  '1']);
      //  }
        
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
        
    }

    public function saveOtSetting(Request $request){
        $daylist=$request->daylst;
        $otsettingdata=[];
        if($daylist!=null){
            try{
                foreach($request->input('daylst') as $row){
                    $otsettingdata[]=['overtime_id'=>$request->OvertimeLevel,'daynum'=>$row,'StartTime'=>$request->StartTime,'EndTime'=>$request->EndTime,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                }
                overtimesetting::insert($otsettingdata);
                return Response::json(['success' => 1]);
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
    }

    public function deleteOtSetting(Request $request){
        $rowid=$request->timeRowId;
        $otdescription=$request->timeNameVal;
        $words = explode(' ', $otdescription);
        $firstWord = $words[0]; 
        $secondWord = $words[1];
        $secondWord = Str::replace('(', '', $secondWord);
        $secondWord = Str::replace(')', '', $secondWord);
        $timesep = explode('-', $secondWord);
        $startTime = $timesep[0]; 
        $endTime = $timesep[1];
        $rowid=(int)$rowid;

        try{
            overtimesetting::where('overtimesettings.daynum',$rowid)->where('overtimesettings.StartTime',$startTime)->where('overtimesettings.EndTime',$endTime)->delete();
            return Response::json(['success' => 1]);
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function overtimeSettingData(){
        $overtimesett = overtimesetting::join('overtimes','overtimesettings.overtime_id','overtimes.id')->get();
        return response()->json(['overtimesett'=>$overtimesett]);
    }

    public function payrollSettingData(){
        $payrollsett = payrollsetting::orderBy('id','ASC')->get();
        return response()->json(['payrollsett'=>$payrollsett]);
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
    
    
    public function getmrcwithstore($id){
        $mrc=storemrc::where('store_id',$id)->get(['mrcNumber']);
        return Response::json(['mrc'=>$mrc]);
    }

    public function updatefsnumber($id){
        $strid=0;
        $store=storemrc::where('id',$id)->get();
        foreach($store as $row){
            $strid=$row->store_id;
        }
        $mainstore=store::where('id',$strid)->get();
        return Response::json(['store'=>$store,'mainstore'=>$mainstore]);
    }

    public function editmanualnumber($id){
        $store=store::where('id',$id)->get();
        return Response::json(['store'=>$store]);
    }

    public function deletefsnumber($id){
        $store=storemrc::where('id',$id)->update(['isincrement'=>0]);
        return Response::json(['success'=>200]);
    }

    public function deletemanulnumber($id){
        $store=store::where('id',$id)->update(['isincrement'=>0]);
        return Response::json(['success'=>200]);
    }

    public function storewithmrcset(){
       // $storemrc= store::with('strmrc')->where('stores.id','>',1)->where('type','Shop')->get(['stores.id','stores.Name']);
        $storemrc= store::join('storemrcs','storemrcs.store_id','stores.id')
                        ->where('stores.type','Shop')
                        ->get(['storemrcs.id','stores.Name','storemrcs.mrcNumber','storemrcs.fsnumber','storemrcs.manualnumber','storemrcs.fiscalcashinvoice','storemrcs.fiscalcreditinvoice','storemrcs.fiscalvoidtype','storemrcs.manualcashinvoice','storemrcs.manualcreditinvoice','storemrcs.isincrement']);
        return datatables()->of($storemrc)->addIndexColumn()->toJson();

       // return $storemrc;
    
    }
    public function manualstore(){
            $store=store::where('id','>',1)->where('type','Shop')
            ->get(['id','Name','manualnumber','manualcashinvoice','manualcreditinvoice','isincrement']);
            return datatables()->of($store)->addIndexColumn()->toJson();
        }
    public function savepos(Request $request){

        $validator = Validator::make($request->all(), [
            'pos' => ['required'],
            'mrc' => ['required'],
            'fsNumber' => ['required'],
            'fiscalCashInvoiceNumber' => ['required'],
            'fiscalCreditInvoiceNumber' => ['required'],
            'editType' => ['required'],
        
        ]);
        if ($validator->passes()) {
            $mrcupadte=storemrc::where('store_id',$request->pos)->where('mrcNumber',$request->mrc)
            ->update(['fsnumber'=>$request->fsNumber,
                    'fiscalcashinvoice'=>$request->fiscalCashInvoiceNumber,
                    'fiscalcreditinvoice'=>$request->fiscalCreditInvoiceNumber,
                    'isincrement'=>$request->editType,
                    
                    
                    ]);
            return Response::json(['succees' => 200]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }
    public function savemanualpos(Request $request){
        $validator = Validator::make($request->all(), [
            'pointOfSale' => ['required'],
           
            'manulCashInvoiceNumber' => ['required'],
            'manulCreditInvoiceNumber' => ['required'],
            'manuleditType' => ['required'],
        ]);
        if ($validator->passes()) {
            $storeupdate=store::where('id',$request->pointOfSale)
            ->update([
                    'manualcashinvoice'=>$request->manulCashInvoiceNumber,
                    'manualcreditinvoice'=>$request->manulCreditInvoiceNumber,
                    'isincrement'=>$request->manuleditType,
                
                    ]);
            return Response::json(['succees' => 200]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }
}
