<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\begining;
use App\Models\beginingdetail;
use App\Models\closing;
use App\Models\transaction;
use App\Models\Regitem;
use App\Models\uom;
use App\Models\serialandbatchnum;
use App\Models\Storemrcuser;
use App\Models\Sales;
use App\Models\status;
use App\Models\store;
use App\Models\ApplicationForm;
use App\Models\settlement;
use App\Models\settlementdetail;
use App\Models\bankdetail;
use App\Models\companyinfo;
use App\Models\systeminfo;
use App\Reports\IncomeFollowUpMRC;
use App\Reports\IncomeFollowUpBank;
use App\Models\incomeclosing;
use App\Models\incomeclosingbank;
use App\Models\incomeclosingmrc;

class ClosingController extends Controller
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
        $currentdate=Carbon::today()->toDateString();
        $lastsevendays=Carbon::now()->subDays(7)->toDateString();
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $pershortamnt=$settingsval->PermittedShortageAmount;
        $itemSrcs=DB::select('select * from regitems where ActiveStatus="Active" and Type!="Service" and IsDeleted=1 order by Name asc');
        $storeSrc=DB::select('SELECT DISTINCT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type IN(4,17) AND stores.ActiveStatus="Active" AND stores.type="Shop" AND stores.IsDeleted=1');
        $banks=DB::select('SELECT id,BankName AS Name,Status FROM banks WHERE banks.Status="Active" ORDER BY banks.BankName ASC');
        $accountnumbers=DB::select('SELECT * FROM bankdetails WHERE bankdetails.Status="Active" ORDER BY bankdetails.id ASC'); 
        $mrcdata=DB::select('SELECT DISTINCT sales.StoreId,sales.CustomerMRC FROM sales INNER JOIN storemrcs ON sales.CustomerMRC=storemrcs.mrcNumber WHERE sales.VoucherType="Fiscal-Receipt" AND sales.Status="Confirmed" AND storemrcs.status="Active" UNION SELECT DISTINCT applications.stores_id,applications.Mrc FROM applications INNER JOIN storemrcs ON applications.Mrc=storemrcs.mrcNumber WHERE applications.VoucherType="Fiscal-Receipt" AND applications.Status="Verified" AND storemrcs.status="Active"');
        $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
        if($request->ajax()){
            return view('finance.closing',['storeSrc'=>$storeSrc,'banks'=>$banks,'itemSrcs'=>$itemSrcs,'mrcdata'=>$mrcdata,'accnum'=>$accountnumbers,'fiscalyears'=>$fiscalyears,'user'=> $user,'currentdate'=>$currentdate,'pershortamnt'=>$pershortamnt,'lastsevendays'=>$lastsevendays])->renderSections()['content'];
        }
        else{
            return view('finance.closing',['storeSrc'=>$storeSrc,'banks'=>$banks,'itemSrcs'=>$itemSrcs,'mrcdata'=>$mrcdata,'accnum'=>$accountnumbers,'fiscalyears'=>$fiscalyears,'user'=> $user,'currentdate'=>$currentdate,'pershortamnt'=>$pershortamnt,'lastsevendays'=>$lastsevendays]);
        }
    }

    public function indexrep(Request $request){
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $storeSrc=DB::select('SELECT DISTINCT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type IN(4,17) AND stores.type="Shop" AND stores.IsDeleted=1');
        $banks=DB::select('SELECT id,BankName FROM banks ORDER BY banks.BankName ASC');
        if($request->ajax()){
            return view('finance.report.bankrep',['compInfo'=>$compInfo,'storeSrc'=>$storeSrc,'banks'=>$banks])->renderSections()['content'];
        }
        else{
            return view('finance.report.bankrep',['compInfo'=>$compInfo,'storeSrc'=>$storeSrc,'banks'=>$banks]);
        }
    }    

    public function closinglistCon($fyear){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $settingsval = DB::table('settings')->latest()->first();
        $php =$settingsval->FiscalYear;
        $incomeclosinglist=DB::select('SELECT incomeclosings.id,incomeclosings.IncomeDocumentNumber,stores.Name AS POS,CONCAT(IFNULL(incomeclosings.StartDate,"")," to ",IFNULL(incomeclosings.EndDate,"")) AS DateRange,statuses.StatusName,incomeclosings.Status,incomeclosings.OldStatus FROM incomeclosings INNER JOIN stores ON incomeclosings.stores_id=stores.id INNER JOIN statuses ON incomeclosings.Status=statuses.id WHERE incomeclosings.FiscalYear='.$fyear.' AND incomeclosings.stores_id IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type IN(4,17)) ORDER BY incomeclosings.id DESC');
        if(request()->ajax()) {
            return datatables()->of($incomeclosinglist)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $unvoidvlink='';
                $voidlink='';
                $editln='';
                $println='';
                if($data->Status==4||$data->Status==5||$data->Status==6||$data->Status==7)
                {
                    if($user->can('Income-Follow-Up-Void'))
                    {
                        $unvoidvlink= '<a class="dropdown-item" onclick="undovoidlnbtn('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                    }
                    $voidlink='';
                    $editln='';
                }
                else if($data->Status==3)
                {
                    if($user->can('Income-Follow-Up-Edit-Confirmed-Document'))
                    {
                        $editln='<a class="dropdown-item editIncClosing" onclick="editIncClosing('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Income-Follow-Up-Confirm') && $user->can('Income-Follow-Up-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidClosing" onclick="voidClosing('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }
                }
                else if($data->Status==2)
                {
                    if($user->can('Income-Follow-Up-Verify') && $user->can('Income-Follow-Up-Edit'))
                    {
                        $editln='<a class="dropdown-item editIncClosing" onclick="editIncClosing('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    
                    if($user->can('Income-Follow-Up-Verify') && $user->can('Income-Follow-Up-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidClosing" onclick="voidClosing('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    } 
                }
                else if($data->Status==1)
                {
                    if($user->can('Income-Follow-Up-Edit'))
                    {
                        $editln='<a class="dropdown-item editIncClosing" onclick="editIncClosing('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Income-Follow-Up-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidClosing" onclick="voidClosing('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }            
                }
                
                $println='<a class="dropdown-item printIncomeAtt" href="javascript:void(0)" data-link="/incatt/'.$data->id.'" id="printincome" data-attr="" title="Print Income Follow-Up Note"><i class="fa fa-file"></i><span> Print Income Follow-Up Note</span></a>';
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item infoClosing" onclick="infoClosing('.$data->id.')" data-id="'.$data->id.'" data-toggle="modal" id="dtinfobtn" title="">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$editln.'
                        '.$voidlink.'
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
   
    public function showMrcListCon($storeid){
        $userid=Auth()->user()->id;
        $data = bankdetail::join('storemrcs', 'storemrcs.id', '=', 'storemrc_user.storemrc_id')
        ->where('storemrc_user.user_id',$userid)
        ->where('storemrcs.store_id',$storeid)
        ->get(['storemrcs.id','storemrcs.mrcNumber']);
        return Response::json(['mrc'=>$data]);
    }


    public function store(Request $request)
    {
        $settings = DB::table('settings')->latest()->first();
        $rprefix=$settings->IncomePrefix;
        $rnumber=$settings->IncomeNumber;
        $fyear=$settings->FiscalYear;
        $suffixdoc=$fyear-2000;
        $suffixdocs=$suffixdoc+1;
        $rnumberPadding=sprintf("%05d", $rnumber);
        $incomeNumber=$rprefix.$rnumberPadding."/".$suffixdoc."-".$suffixdocs;;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->closingId;
        $findid=$request->closingId;

        $poshidden=$request->poshiddenval;
        $starthidden=$request->startdatehiddenval;
        $endhidden=$request->enddatehiddenval;
        $zdocfile=null;
        $documentnames=null;
        $file=null;
        $fn=null;
        $name=null;
        $documentnames=null;
        $pathIdentification=null;
        $pathnameIdentification=null;
        $statusval=null;
        $missingday=0;
		$alldays=[];
        $zdateval=[];
        $mrcnum=[];
        $eachdays=[];

        $slipnumfile=null;
        $documentnamesSl=null;
        $fileSl=null;
        $fnSl=null;
        $nameSl=null;
        $documentnamesSl=null;
        $pathIdentificationSl=null;
        $pathnameIdentificationSl=null;
        $totalcashdepedit=$request->depositedcashinp;
        $startdatecmp=$request->StartDateComp;
        $startdate=$request->StartDate;
        $enddate=$request->EndDate;
        $nextstartdate = Carbon::parse($enddate)->addDays(1)->toDateString();
        $pos=$request->PointOfSales;
        $totalzamount=$request->totalcashzamountinp;
        $shortageamount=$request->ShortageAmount;
        $permittedamount=$request->minimumShortageVar;
        $totalnetinc=$request->netcashrecinp+$request->OverageAmount-$request->ShortageAmount;
        $totalcashreceived=$totalzamount+$totalnetinc;
        
        $fiscaltotalcash=$request->cashfiscaltotalval;
        $fiscaltotalcredit=$request->creditfiscaltotalval;

        $fiscaltotalcashinput=$request->totalcashzamountinp;
        $fiscaltotalcreditinput=$request->totalcreditzamountinp;

        $countposdata=$request->countposval;

        $bankval=0;
        $bankerrorflag=0;
        $descrpancyflag=0;
        $fiscalcashdesrpancyflag=0;
        $fiscalcreditdesrpancyflag=0;
        $permittedminamount=0;
        $v3=null;

        if($findid!=null){
            $incd=incomeclosing::find($findid);
            $statusval=$incd->Status;

            $validator = Validator::make($request->all(), [
                'PointOfSales' => ['required'],
                'StartDate' => ['required'],
                'EndDate' => ['required'],
                'OtherIncome' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'CreditFiscalOtherIncome' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'CashManualOtherIncome' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'CreditManualOtherIncome' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'ShortageAmount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'OverageAmount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            ]);

            $rules=array(
                'row.*.MrcNumber' => 'required',
                'row.*.ZNumber' => 'required_if:row.*.BusinessDay,1',
                'row.*.ZDate' => 'required',
                'row.*.CashAmount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'row.*.CreditAmount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'row.*.TotalAmount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'row.*.BusinessDay' => 'required',
            );
            $v2= Validator::make($request->all(), $rules);

            if($totalcashreceived>0){
                if($request->rowb!=null){
                    $bankerrorflag=0;
                }
                else if($request->rowb==null){
                    $bankerrorflag=1;
                }
                $bankrules=array(
                    'rowb.*.PaymentType' => 'required',
                    'rowb.*.Bank' => 'required',
                    'rowb.*.AccountNumber' => 'required',
                    'rowb.*.SlipNumber' => 'required',
                    'rowb.*.SlipDate' => 'required',
                    'rowb.*.DepositedAmount' => 'required|gt:0|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                );
                $v3= Validator::make($request->all(), $bankrules);
            }
            if($totalcashreceived==0){
                $v3 = Validator::make($request->all(), [
                    'PointOfSales' => ['required'],//to bypass if bank row is empty
                ]);
            }
            if($statusval==3 && $request->row!=null){
                if($totalcashdepedit!=$totalnetinc){
                    $descrpancyflag=1;
                }

                if($fiscaltotalcash!=$fiscaltotalcashinput){
                    $fiscalcashdesrpancyflag=1;
                }
                if($shortageamount>$permittedamount){
                    $permittedminamount=1;
                }
                if($fiscaltotalcredit!=$fiscaltotalcreditinput){
                    $fiscalcreditdesrpancyflag=1;
                }
                

                foreach ($request->row as $key => $value){
                    $zdateval[]=$value['ZDate'];
                    $mrcnum[]=$value['MrcNumber'];
                }

                $getmrcval=DB::select('SELECT storemrcs.store_id,storemrcs.mrcNumber FROM storemrcs WHERE storemrcs.store_id='.$pos.' AND storemrcs.status="Active"');
                foreach($getmrcval as $mrcrow){
                    $period = CarbonPeriod::create($startdate,$enddate);
                    foreach($period as $row){
                        $eachday=$row->format('Y-m-d');
                        $eachdays[]=$row->format('Y-m-d');
                        $mrcs=$mrcrow->mrcNumber;
                       
                        if(!in_array($eachday,$zdateval) || !in_array($mrcs,$mrcnum)){
                            $missingday+=1;
                            $alldays[]=$mrcrow->mrcNumber."          ,          ".$row->format('Y-m-d')."<br>";
                        }
                    }
                }
            }

            if($validator->passes() && $v2->passes() && $v3->passes() && $startdate==$startdatecmp && $request->row!=null && $bankerrorflag==0 && $missingday==0 && $descrpancyflag==0 && $fiscalcashdesrpancyflag==0 && $fiscalcreditdesrpancyflag==0 && $permittedminamount==0)
            {
                try
                {
                    if ($request->file('ZRecDoc')) {
                        $file = $request->file('ZRecDoc');
                        $fn = $file->getClientOriginalName();
                        $name = explode('.', $fn)[0]; // Filename 'filename'
                        $documentnames = preg_replace('/\s+/', '-', $name);
                        $zdocfile = time() . '.' . $request->file('ZRecDoc')->extension();
                        $pathIdentification = public_path() . '/storage/uploads/ZDocumentUploads';
                        $pathnameIdentification='/storage/uploads/ZDocumentUploads/'.$zdocfile;
                        $file->move($pathIdentification, $zdocfile);
                    }
                    if($request->file('ZRecDoc')==''){
                        $zdocfile=$request->znumberval;
                        $documentnames=$request->zreceiptfilename;
                    }

                    if ($request->file('BankSlip')) {
                        $fileSl = $request->file('BankSlip');
                        $fnSl = $fileSl->getClientOriginalName();
                        $nameSl = explode('.', $fnSl)[0]; // Filename 'filename'
                        $documentnamesSl = preg_replace('/\s+/', '-', $nameSl);
                        $slipnumfile = time() . '.' . $request->file('BankSlip')->extension();
                        $pathIdentificationSl = public_path() . '/storage/uploads/BankSlipUploads';
                        $pathnameIdentificationSl='/storage/uploads/BankSlipUploads/'.$slipnumfile;
                        $fileSl->move($pathIdentificationSl, $slipnumfile);
                    }
                    if($request->file('BankSlip')==''){
                        $slipnumfile=$request->bankslipval;
                        $documentnamesSl=$request->slipreceiptfilename;
                    }

                    $incomecl=incomeclosing::updateOrCreate(['id' => $request->closingId], [
                        'stores_id' => $request->PointOfSales,
                        'StartDate' => $request->StartDate,
                        'EndDate' =>$request->EndDate,
                        'TotalCashDeposited' => $request->depositedcashinp,
                        'TotalCash' => $request->totalcashi,
                        'WitholdAmount' => $request->witholdcashinp,
                        'VatAmount' => $request->vatcashinp,
                        'FisCashIncome' => $request->FiscalCashIncHidden,
                        'FisCreditIncome' => $request->FiscalCreditIncHidden,
                        'ManCashIncome' => $request->ManualCashIncHidden,
                        'ManCreditIncome' => $request->ManualCreditIncHidden,
                        'CreditSettIncome' => $request->settledincomeval,
                        'OtherIncome' => $request->OtherIncome,
                        'CreditFiscalOtherIncome' => $request->CreditFiscalOtherIncome,
                        'CashManualOtherIncome' => $request->CashManualOtherIncome,
                        'CreditManualOtherIncome' => $request->CreditManualOtherIncome,
                        'NetCashReceived' => $request->netcashrecinp,
                        'TotalZAmount' => $request->totalzamountinp,
                        'ShortageAmount' => $request->ShortageAmount,
                        'OverageAmount' => $request->OverageAmount,
                        'LastEditedBy' => $user,
                        'LastEditedDate' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                        'Memo' => $request->Memo,
                        'ZDocumentName'=>$documentnames,
                        'ZDocumentPath'=>$zdocfile,
                        'SlipDocumentName'=>$documentnamesSl,
                        'SlipDocumentPath'=>$slipnumfile,
                    ]);

                    $incomecl->incmrc()->detach();
                    foreach ($request->row as $key => $value)
                    {
                        $commdata=0;
                        $mrcnumber=$value['MrcNumber'];
                        $znumber=$value['ZNumber'];
                        $zdate=$value['ZDate'];
                        $cashamount=$value['CashAmount'];
                        $creditamount=$value['CreditAmount'];
                        $totalamount=$value['TotalAmount'];
                        $businessday=$value['BusinessDay'];
                        $incomecl->incmrc()->attach($commdata,['MrcNumber'=>$mrcnumber,'ZNumber'=>$znumber,'ZDate'=>$zdate,'CashAmount'=>$cashamount,'CreditAmount'=>$creditamount,'TotalAmount'=>$totalamount,'BusinessDay'=>$businessday]);
                    }

                    $incomecl->incbank()->detach();
                    if($request->rowb!=null){
                        foreach ($request->rowb as $keyb => $bvalue)
                        {
                            $bankid=$bvalue['Bank'];
                            $accountnumber=$bvalue['AccountNumber'];
                            $slipnumber=strtoupper($bvalue['SlipNumber']);
                            $pmodesval=$bvalue['PaymentType'];
                            $depositamount=$bvalue['DepositedAmount'];
                            $remark=$bvalue['Remark'];
                            $slipdate=$bvalue['SlipDate'];
                            $incomecl->incbank()->attach($bankid,['PaymentType'=>$pmodesval,'bankdetails_id'=>$accountnumber,'SlipNumber'=>$slipnumber,'Amount'=>$depositamount,'Remark'=>$remark,'SlipDate'=>$slipdate]);
                        }
                    }
                    $updsalesoff=DB::select('UPDATE sales SET sales.IsPaymentFollowUpClosed=0 WHERE sales.StoreId='.$poshidden.' AND sales.CreatedDate>="'.$starthidden.'" AND sales.CreatedDate<="'.$endhidden.'"');
                    $updateappoff=DB::select('UPDATE applications SET applications.IsPaymentFollowUpClosed=0 WHERE applications.stores_id='.$poshidden.' AND  applications.InvoiceDate>="'.$starthidden.'" AND applications.InvoiceDate<="'.$endhidden.'"');
                    $updatesettoff=DB::select('UPDATE settlements SET settlements.IsPaymentFollowUpClosed=0 WHERE settlements.stores_id='.$poshidden.' AND settlements.DocumentDate>="'.$starthidden.'" AND settlements.DocumentDate<="'.$endhidden.'"');
                    $updsales=DB::select('UPDATE sales SET sales.IsPaymentFollowUpClosed=1 WHERE sales.StoreId='.$pos.' AND sales.CreatedDate>="'.$startdate.'" AND sales.CreatedDate<="'.$enddate.'"');
                    $updateapp=DB::select('UPDATE applications SET applications.IsPaymentFollowUpClosed=1 WHERE applications.stores_id='.$pos.' AND  applications.InvoiceDate>="'.$startdate.'" AND applications.InvoiceDate<="'.$enddate.'"');
                    $updatesett=DB::select('UPDATE settlements SET settlements.IsPaymentFollowUpClosed=1 WHERE settlements.stores_id='.$pos.' AND settlements.DocumentDate>="'.$startdate.'" AND settlements.DocumentDate<="'.$enddate.'"');
                    
                    if($countposdata==0){
                        $updnoff=DB::select('UPDATE stores SET stores.IncomeClosingDate="'.$starthidden.'" WHERE id='.$poshidden.'');
                        $updn=DB::select('UPDATE stores SET stores.IncomeClosingDate="'.$nextstartdate.'" WHERE id='.$pos.'');
                    }
                    return Response::json(['success' =>1]);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }  
            
            if($validator->fails())
            {
                return Response::json(['errors'=> $validator->errors()]);
            }
            if($v2->fails())
            {
                return Response::json(['errorv2'=>  $v2->errors()->all()]);
            }
            if($v3->fails())
            {
                return Response::json(['errorv3'=>  $v3->errors()->all()]);
            }
            if($startdate!=$startdatecmp){
                return Response::json(['datediff'=>"error"]);
            }
            if($request->row==null){
                return Response::json(['emptyrow'=>"error"]);
            }
            if($bankerrorflag>=1){
                return Response::json(['emptybankrow'=>"error"]);
            }
            if($missingday>=1){
                return Response::json(['missingdays'=>$alldays]);
            }
            if($fiscalcashdesrpancyflag>=1){
                return Response::json(['descasherror'=>"error"]);
            }
            if($permittedminamount>=1){
                return Response::json(['peramounterror'=>"error"]);
            }
            if($fiscalcreditdesrpancyflag>=1){
                return Response::json(['descrediterror'=>"error"]);
            }
            if($descrpancyflag>=1){
                return Response::json(['descrerror'=>"error"]);
            }
        }

        if($findid==null){
            $validator = Validator::make($request->all(), [
                'PointOfSales' => ['required'],
                'StartDate' => ['required'],
                'EndDate' => ['required'],
                'OtherIncome' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'CreditFiscalOtherIncome' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'CashManualOtherIncome' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'CreditManualOtherIncome' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'ShortageAmount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'OverageAmount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            ]);

            $rules=array(
                'row.*.MrcNumber' => 'required',
                'row.*.ZNumber' => 'required_if:row.*.BusinessDay,1',
                'row.*.ZDate' => 'required',
                'row.*.CashAmount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'row.*.CreditAmount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'row.*.TotalAmount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'row.*.BusinessDay' => 'required',
            );
            $v2= Validator::make($request->all(), $rules);

            if($totalcashreceived>0){
                if($request->rowb!=null){
                    $bankerrorflag=0;
                }
                else if($request->rowb==null){
                    $bankerrorflag=1;
                }
                $bankrules=array(
                    'rowb.*.PaymentType' => 'required',
                    'rowb.*.Bank' => 'required',
                    'rowb.*.AccountNumber' => 'required',
                    'rowb.*.SlipNumber' => 'required',
                    'rowb.*.SlipDate' => 'required',
                    'rowb.*.DepositedAmount' => 'required|gt:0|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                );
                $v3= Validator::make($request->all(), $bankrules);
            }
            else if($totalcashreceived==0){
                $v3 = Validator::make($request->all(), [
                    'PointOfSales' => ['required'],//to bypass if bank row is empty
                ]);
            }

            if($validator->passes() && $v2->passes() && $v3->passes() && $startdate==$startdatecmp && $request->row!=null && $bankerrorflag==0)
            {
                try
                {
                    if ($request->file('ZRecDoc')) {
                        $file = $request->file('ZRecDoc');
                        $fn = $file->getClientOriginalName();
                        $name = explode('.', $fn)[0]; // Filename 'filename'
                        $documentnames = preg_replace('/\s+/', '-', $name);
                        $zdocfile = time() . '.' . $request->file('ZRecDoc')->extension();
                        $pathIdentification = public_path() . '/storage/uploads/ZDocumentUploads';
                        $pathnameIdentification='/storage/uploads/ZDocumentUploads/'.$zdocfile;
                        $file->move($pathIdentification, $zdocfile);
                    }
                    if($request->file('ZRecDoc')==''){
                        $zdocfile=$request->znumberval;
                    }

                    if ($request->file('BankSlip')) {
                        $fileSl = $request->file('BankSlip');
                        $fnSl = $fileSl->getClientOriginalName();
                        $nameSl = explode('.', $fnSl)[0]; // Filename 'filename'
                        $documentnamesSl = preg_replace('/\s+/', '-', $nameSl);
                        $slipnumfile = time() . '.' . $request->file('BankSlip')->extension();
                        $pathIdentificationSl = public_path() . '/storage/uploads/BankSlipUploads';
                        $pathnameIdentificationSl='/storage/uploads/BankSlipUploads/'.$slipnumfile;
                        $fileSl->move($pathIdentificationSl, $slipnumfile);
                    }
                    if($request->file('BankSlip')==''){
                        $slipnumfile=$request->bankslipval;
                    }

                    $incomecl=incomeclosing::updateOrCreate(['id' => $request->closingId], [
                        'IncomeDocumentNumber' => $incomeNumber,
                        'stores_id' => $request->PointOfSales,
                        'StartDate' => $request->StartDate,
                        'EndDate' =>$request->EndDate,
                        'TotalCashDeposited' => $request->depositedcashinp,
                        'TotalCash' => $request->totalcashi,
                        'WitholdAmount' => $request->witholdcashinp,
                        'VatAmount' => $request->vatcashinp,
                        'FisCashIncome' => $request->FiscalCashIncHidden,
                        'FisCreditIncome' => $request->FiscalCreditIncHidden,
                        'ManCashIncome' => $request->ManualCashIncHidden,
                        'ManCreditIncome' => $request->ManualCreditIncHidden,
                        'CreditSettIncome' => $request->settledincomeval,
                        'OtherIncome' => $request->OtherIncome,
                        'CreditFiscalOtherIncome' => $request->CreditFiscalOtherIncome,
                        'CashManualOtherIncome' => $request->CashManualOtherIncome,
                        'CreditManualOtherIncome' => $request->CreditManualOtherIncome,
                        'NetCashReceived' => $request->netcashrecinp,
                        'TotalZAmount' => $request->totalzamountinp,
                        'ShortageAmount' => $request->ShortageAmount,
                        'OverageAmount' => $request->OverageAmount,
                        'PreparedBy' => $user,
                        'PreparedDate' => Carbon::today()->toDateString(),
                        'IsVoid'=> 0,
                        'Memo' => $request->Memo,
                        'ZDocumentName'=>$documentnames,
                        'ZDocumentPath'=>$zdocfile,
                        'SlipDocumentName'=>$documentnamesSl,
                        'SlipDocumentPath'=>$slipnumfile,
                        'FiscalYear' => $fyear,
                        'Status' =>1,
                    ]);

                    foreach ($request->row as $key => $value)
                    {
                        $commdata=0;
                        $mrcnumber=$value['MrcNumber'];
                        $znumber=$value['ZNumber'];
                        $zdate=$value['ZDate'];
                        $cashamount=$value['CashAmount'];
                        $creditamount=$value['CreditAmount'];
                        $totalamount=$value['TotalAmount'];
                        $businessday=$value['BusinessDay'];
                        $incomecl->incmrc()->attach($commdata,['MrcNumber'=>$mrcnumber,'ZNumber'=>$znumber,'ZDate'=>$zdate,'CashAmount'=>$cashamount,'CreditAmount'=>$creditamount,'TotalAmount'=>$totalamount,'BusinessDay'=>$businessday]);
                    }

                    if($request->rowb!=null){
                        foreach ($request->rowb as $keyb => $bvalue)
                        {
                            $bankid=$bvalue['Bank'];
                            $accountnumber=$bvalue['AccountNumber'];
                            $slipnumber=strtoupper($bvalue['SlipNumber']);
                            $pmodesval=$bvalue['PaymentType'];
                            $depositamount=$bvalue['DepositedAmount'];
                            $remark=$bvalue['Remark'];
                            $slipdate=$bvalue['SlipDate'];
                            $incomecl->incbank()->attach($bankid,['PaymentType'=>$pmodesval,'bankdetails_id'=>$accountnumber,'SlipNumber'=>$slipnumber,'Amount'=>$depositamount,'Remark'=>$remark,'SlipDate'=>$slipdate]);
                        }
                    }
                    $updsales=DB::select('UPDATE sales SET sales.IsPaymentFollowUpClosed=1 WHERE sales.StoreId='.$pos.' AND sales.CreatedDate>="'.$startdate.'" AND sales.CreatedDate<="'.$enddate.'"');
                    $updateapp=DB::select('UPDATE applications SET applications.IsPaymentFollowUpClosed=1 WHERE applications.stores_id='.$pos.' AND  applications.InvoiceDate>="'.$startdate.'" AND applications.InvoiceDate<="'.$enddate.'"');
                    $updatesett=DB::select('UPDATE settlements SET settlements.IsPaymentFollowUpClosed=1 WHERE settlements.stores_id='.$pos.' AND settlements.DocumentDate>="'.$startdate.'" AND settlements.DocumentDate<="'.$enddate.'"');
                    $updpos=DB::select('UPDATE stores SET stores.IncomeClosingDate="'.$nextstartdate.'" WHERE id='.$pos.'');
                    $updn=DB::select('UPDATE settings SET IncomeNumber=IncomeNumber+1 WHERE id=1');
                    return Response::json(['success' =>1]);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }

            if($validator->fails())
            {
                return Response::json(['errors'=> $validator->errors()]);
            }
            if($v2->fails())
            {
                return Response::json(['errorv2'=>  $v2->errors()->all()]);
            }
            if($v3->fails())
            {
                return Response::json(['errorv3'=>  $v3->errors()->all()]);
            }
            if($startdate!=$startdatecmp){
                return Response::json(['datediff'=>"error"]);
            }
            if($request->row==null){
                return Response::json(['emptyrow'=>"error"]);
            }
            if($bankerrorflag>=1){
                return Response::json(['emptybankrow'=>"error"]);
            }
        }
    }

    public function showclosingdata(Request $request,$id){
        $zuploadcnt=1;//change this to zero to make require 
        $slipuploadcnt=1;//change this to zero to make require 
        $voidcnt=0;
        $undovoidcnt=0;
        $storeids=null;
        $startdate=null;
        $enddate=null;
        $alldays=[];
        $missingday=0;
        $totalcashdep=0;
        $netcashrec=0;
        $totalcash=0;
        $totalcredit=0;
        $shortageamnt=0;
        $overageamnt=0;
        $countinc=0;
        $statusval=[4,5,6,7];

        $currentdate=Carbon::today()->toDateString();

        $incform = incomeclosing::find($id);
        $createddateval=$incform->created_at;
        $storeids=$incform->stores_id;
        $startdate=$incform->StartDate;
        $enddate=$incform->EndDate;
        $totalcashdep=$incform->TotalCashDeposited;
        $netcashrec=$incform->NetCashReceived;
        $shortageamnt=$incform->ShortageAmount;
        $overageamnt=$incform->OverageAmount;

        $fiscinc=$incform->FisCashIncome;
        $otherinc=$incform->OtherIncome;
        $totalfiscalinc=$fiscinc+$otherinc;

        $fiscrinc=$incform->FisCreditIncome;
        $othercrinc=$incform->CreditFiscalOtherIncome;
        $totalfiscalcrinc=$fiscrinc+$othercrinc;

        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $data = incomeclosing::join('stores', 'incomeclosings.stores_id', '=', 'stores.id')
        ->join('statuses', 'incomeclosings.Status', '=', 'statuses.id')
        ->where('incomeclosings.id', $id)
        ->get(['incomeclosings.*','stores.Name AS POS','statuses.StatusName',DB::raw("'$datetime' AS CreatedDateTime")]);

        $mrcdata = incomeclosingmrc::where('incomeclosingmrcs.incomeclosings_id', $id)
        ->get(['incomeclosingmrcs.*']);

        foreach($mrcdata as $row){
            $totalcash+=$row->CashAmount;
            $totalcredit+=$row->CreditAmount;
        }

        $bankdata = incomeclosingbank::join('banks', 'incomeclosingbanks.banks_id', '=', 'banks.id')
        ->join('bankdetails', 'incomeclosingbanks.bankdetails_id', '=', 'bankdetails.id')
        ->where('incomeclosingbanks.incomeclosings_id', $id)
        ->get(['incomeclosingbanks.*',DB::raw('IFNULL(incomeclosingbanks.Remark,"") AS Remarks'),'banks.BankName','bankdetails.AccountNumber','bankdetails.ContactNumber','bankdetails.Branch']);

        $bankcnt = $bankdata->count();

        $closinginc = DB::table('incomeclosings')
        ->where('incomeclosings.stores_id',$storeids)
        ->where('incomeclosings.id','>',$id)
        ->whereNotIn('incomeclosings.Status',$statusval)
        ->get();

        $countinc=$closinginc->count();

        if($bankcnt>=1){
            $getslipupload = DB::table('incomeclosings')
            ->select('incomeclosings.id')
            ->where('incomeclosings.id',$id)
            ->whereNotNull('incomeclosings.SlipDocumentPath')
            ->get();

            //$slipuploadcnt = $getslipupload->count();
        }

        else if($bankcnt==0){
           // $slipuploadcnt=1;
        }


        $getzupload = DB::table('incomeclosings')
        ->select('incomeclosings.id')
        ->where('incomeclosings.id',$id)
        ->whereNotNull('incomeclosings.ZDocumentPath')
        ->get();

        

        $checkincomeclosing = DB::table('incomeclosings')
        ->select('incomeclosings.id')
        ->where('incomeclosings.id','>',$id)
        ->where('incomeclosings.stores_id','=',$storeids)
        ->where('incomeclosings.IsVoid',0)
        ->get();

        $checkincomevoidclosing = DB::table('incomeclosings')
        ->select('incomeclosings.id')
        ->where('incomeclosings.id','<',$id)
        ->where('incomeclosings.stores_id','=',$storeids)
        ->where('incomeclosings.IsVoid',1)
        ->get();

        $getmrcval=DB::select('SELECT storemrcs.store_id,storemrcs.mrcNumber FROM storemrcs WHERE storemrcs.store_id='.$storeids.' AND storemrcs.status="Active"');
        foreach($getmrcval as $mrcrow){
            $period = CarbonPeriod::create($startdate,$enddate);
            foreach($period as $row){
                $eachday=$row->format('Y-m-d');
                $mrcs=$mrcrow->mrcNumber;

                $getmrcanddate = DB::table('incomeclosingmrcs')
                ->select('incomeclosingmrcs.id')
                ->where('incomeclosingmrcs.incomeclosings_id',$id)
                ->where('incomeclosingmrcs.ZDate',$eachday)
                ->where('incomeclosingmrcs.MrcNumber','=',$mrcs)
                ->get();

                $missingcnt = $getmrcanddate->count();
                if($missingcnt==0){
                    $missingday+=1;
                    $alldays[]=$mrcrow->mrcNumber."          ,          ".$row->format('Y-m-d')."<br>";
                }
            }
        }
        
        $voidcnt = $checkincomeclosing->count();
        $undovoidcnt = $checkincomevoidclosing->count();

        return response()->json(['incdata'=>$data,'mrcdata'=>$mrcdata,'bankdata'=>$bankdata,'zuploadcnt'=>$zuploadcnt,'slipuploadcnt'=>$slipuploadcnt,'voidcnt'=>$voidcnt,'undovoidcnt'=>$undovoidcnt,'missingday'=>$missingday,
        'allday'=>$alldays,'currdate'=>$currentdate,'totalcashdep'=>$totalcashdep,'netcashrec'=>$netcashrec,'tcash'=>$totalcash,'tcredit'=>$totalcredit,'countinc'=>$countinc,
        'totalcashrec'=>$totalfiscalinc,'totalcreditrec'=>$totalfiscalcrinc,'shortageamnt'=>$shortageamnt,'overageamnt'=>$overageamnt
        ]); 
    }

    public function verfyinc(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->checkedid;
        $incd=incomeclosing::find($findid);
        $incd->VerifiedBy= $user;
        $incd->VerifiedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $incd->Status=2;
        $incd->save();
        return Response::json(['success' => '1']);  
    }

    public function pendinginc(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->pendingid;
        $incd=incomeclosing::find($findid);
        $incd->ChangeToPendingBy= $user;
        $incd->ChangeToPendingDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $incd->Status=1;
        $incd->save();
        return Response::json(['success' => '1']);  
    }

    public function confirminc(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->confirmid;
        $incd=incomeclosing::find($findid);
        $incd->ConfirmedBy= $user;
        $incd->ConfirmedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $incd->Status=3;
        $incd->save();
        return Response::json(['success' => '1']);  
    }

    public function voidincfollowup(Request $request)
    {
        $statusval=null;
        $stval=null;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->voididn;
        $incd=incomeclosing::find($findid);
        $stval=$incd->Status;
        $pos=$incd->stores_id;
        $startdate=$incd->StartDate;
        $enddate=$incd->EndDate;
        $nextstartdate = Carbon::parse($enddate)->addDays(1)->toDateString();
        $validator = Validator::make($request->all(), [
            'Reason'=>"required",
        ]);
        if ($validator->passes()) 
        {
            if($stval==1){
               $statusval= 5;
            }
            else if($stval==2){
               $statusval= 6;
            }
            else if($stval==3){
               $statusval= 7;
            }
            
            $incd->Status=$statusval;
            $incd->OldStatus=$stval;
            $incd->IsVoid="1";
            $incd->VoidBy=$user;
            $incd->VoidReason=trim($request->input('Reason'));
            $incd->VoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $incd->save();

            $updsales=DB::select('UPDATE sales SET sales.IsPaymentFollowUpClosed=0 WHERE sales.StoreId='.$pos.' AND sales.CreatedDate>="'.$startdate.'" AND sales.CreatedDate<="'.$enddate.'"');
            $updateapp=DB::select('UPDATE applications SET applications.IsPaymentFollowUpClosed=0 WHERE applications.stores_id='.$pos.' AND  applications.InvoiceDate>="'.$startdate.'" AND applications.InvoiceDate<="'.$enddate.'"');
            $updatesett=DB::select('UPDATE settlements SET settlements.IsPaymentFollowUpClosed=0 WHERE settlements.stores_id='.$pos.' AND settlements.DocumentDate>="'.$startdate.'" AND settlements.DocumentDate<="'.$enddate.'"');
            $updpos=DB::select('UPDATE stores SET stores.IncomeClosingDate="'.$startdate.'" WHERE id='.$pos.'');
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function undovoidfollowup(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $totalout=0;
        $totalsett=0;
        $totalrem=0;
        $findid=$request->undovoidid;
        $incd=incomeclosing::find($findid);
        $stval=$incd->Status;
        $pos=$incd->stores_id;
        $startdate=$incd->StartDate;
        $enddate=$incd->EndDate;
        $nextstartdate = Carbon::parse($enddate)->addDays(1)->toDateString();

        $updateStatus=DB::select('UPDATE incomeclosings SET incomeclosings.Status=incomeclosings.OldStatus WHERE incomeclosings.id='.$findid.'');
        $incd->OldStatus="";
        $incd->IsVoid="0";
        $incd->UndoVoidBy=$user;
        $incd->UndoVoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $incd->save();

        $updsales=DB::select('UPDATE sales SET sales.IsPaymentFollowUpClosed=1 WHERE sales.StoreId='.$pos.' AND sales.CreatedDate>="'.$startdate.'" AND sales.CreatedDate<="'.$enddate.'"');
        $updateapp=DB::select('UPDATE applications SET applications.IsPaymentFollowUpClosed=1 WHERE applications.stores_id='.$pos.' AND  applications.InvoiceDate>="'.$startdate.'" AND applications.InvoiceDate<="'.$enddate.'"');
        $updatesett=DB::select('UPDATE settlements SET settlements.IsPaymentFollowUpClosed=1 WHERE settlements.stores_id='.$pos.' AND settlements.DocumentDate>="'.$startdate.'" AND settlements.DocumentDate<="'.$enddate.'"');
        $updpos=DB::select('UPDATE stores SET stores.IncomeClosingDate="'.$nextstartdate.'" WHERE id='.$pos.'');
        return Response::json(['success' => '1']);
        
    }

    public function showAllPrices($mrc,$pid){
        $userid=Auth()->user()->id;
        $vt="Fiscal-Receipt";
        $mnvt="Manual-Receipt";
        $capt="Cash";
        $crpt="Credit";
        $id=100;
        $pricingsett = DB::table('sales')
        ->select(DB::raw('ROUND(SUM(GrandTotal),2) as GrandTotal'))
        ->where('CustomerMRC', '=', $mrc)
        ->where('VoucherType', '=', $vt)
        ->where('PaymentType', '=',$capt)
        ->where('id', '>',$id)
        ->get();

        $pricingcredit = DB::table('sales')
        ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CreditGrandTotal'))
        ->where('CustomerMRC', '=', $mrc)
        ->where('VoucherType', '=', $vt)
        ->where('PaymentType', '=',$crpt)
        ->where('id', '>',$id)
        ->get();

        $pricingcashmanual = DB::table('sales')
        ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CashGrandTotalManual'))
        ->where('VoucherType', '=', $mnvt)
        ->where('PaymentType', '=',$capt)
        ->where('StoreId', '=',$pid)
        ->where('id', '>',$id)
        ->get();

        $pricingcreditmanual = DB::table('sales')
        ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CreditGrandTotalManual'))
        ->where('VoucherType', '=', $mnvt)
        ->where('PaymentType', '=',$crpt)
        ->where('StoreId', '=',$pid)
        ->where('id', '>',$id)
        ->get();

        foreach($pricingsett as $pricecash){
            $prcash=$pricecash->GrandTotal;
        }
        foreach($pricingcredit as $prcredit){
            $prcredit=$prcredit->CreditGrandTotal;
        }
        foreach($pricingcashmanual as $mncash){
            $mancash=$mncash->CashGrandTotalManual;
        }
        foreach($pricingcreditmanual as $mncredit){
            $mancredit=$mncredit->CreditGrandTotalManual;
        }
        
        return Response::json(['cash'=>$prcash,'credit'=>$prcredit,'mancash'=>$mancash,'mancredit'=>$mancredit]);
    }

    public function getrevenuescon(Request $request){
        $userid=Auth()->user()->id;
        
        $vt="Fiscal-Receipt";
        $mnvt="Manual-Receipt";
        $capt="Cash";
        $crpt="Credit";
        $posid=$_POST['posidval']; 
        $mindate=$_POST['mindate']; 
        $maxdate=$_POST['maxdate']; 
        $optypes=$_POST['optype'];
        $status="Confirmed";
        $appstatus="Verified";
        $closingids=$request->closingId;
        $id=100;
        if($optypes==1){
            $pricingsett = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as GrandTotal'))
            ->where('VoucherType', '=', $vt)
            ->where('PaymentType', '=',$capt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->where('IsPaymentFollowUpClosed',0)
            ->get();

            $pricingcredit = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CreditGrandTotal'))
            ->where('VoucherType', '=', $vt)
            ->where('PaymentType', '=',$crpt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->where('IsPaymentFollowUpClosed',0)
            ->get();

            $pricingcashmanual = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CashGrandTotalManual'))
            ->where('VoucherType', '=', $mnvt)
            ->where('PaymentType', '=',$capt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->where('IsPaymentFollowUpClosed',0)
            ->get();

            $pricingcreditmanual = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CreditGrandTotalManual'))
            ->where('VoucherType', '=', $mnvt)
            ->where('PaymentType', '=',$crpt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->where('IsPaymentFollowUpClosed',0)
            ->get();

            //
            $witholddata = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(WitholdAmount),2) as WitholdAmount'))
            ->where('PaymentType', '=',$capt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->where('IsPaymentFollowUpClosed',0)
            ->where('WitholdSetle',1)
            ->get();

            $vatdata = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(Vat),2) as VatAmount'))
            ->where('PaymentType', '=',$capt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->where('IsPaymentFollowUpClosed',0)
            ->get();

            //

            $pricingsettapp = DB::table('applications')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as GrandTotal'))
            ->where('VoucherType', '=', $vt)
            ->where('PaymentType', '=',$capt)
            ->where('stores_id', '=',$posid)
            ->where('InvoiceDate', '>=',$mindate)
            ->where('InvoiceDate', '<=',$maxdate)
            ->where('Status','=',$appstatus)
            ->where('IsPaymentFollowUpClosed',0)
            ->get();

            $pricingcreditapp = DB::table('applications')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CreditGrandTotal'))
            ->where('VoucherType', '=', $vt)
            ->where('PaymentType', '=',$crpt)
            ->where('stores_id', '=',$posid)
            ->where('InvoiceDate', '>=',$mindate)
            ->where('InvoiceDate', '<=',$maxdate)
            ->where('Status','=',$appstatus)
            ->where('IsPaymentFollowUpClosed',0)
            ->get();

            $pricingcashmanualapp = DB::table('applications')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CashGrandTotalManual'))
            ->where('VoucherType', '=', $mnvt)
            ->where('PaymentType', '=',$capt)
            ->where('stores_id', '=',$posid)
            ->where('InvoiceDate', '>=',$mindate)
            ->where('InvoiceDate', '<=',$maxdate)
            ->where('Status','=',$appstatus)
            ->where('IsPaymentFollowUpClosed',0)
            ->get();

            $pricingcreditmanualapp = DB::table('applications')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CreditGrandTotalManual'))
            ->where('VoucherType', '=', $mnvt)
            ->where('PaymentType', '=',$crpt)
            ->where('stores_id', '=',$posid)
            ->where('InvoiceDate', '>=',$mindate)
            ->where('InvoiceDate', '<=',$maxdate)
            ->where('Status','=',$appstatus)
            ->where('IsPaymentFollowUpClosed',0)
            ->get();

            //

            $settlementdata = DB::table('settlementdetails')
            ->join('settlements','settlements.id','=','settlementdetails.settlements_id')
            ->select(DB::raw('ROUND(SUM(settlementdetails.GrandTotal),2) AS SettledAmount'))
            ->where('settlements.stores_id', '=',$posid)
            ->where('settlements.DocumentDate', '>=',$mindate)
            ->where('settlements.DocumentDate', '<=',$maxdate)
            ->where('settlements.Status',3)
            ->where('settlements.IsPaymentFollowUpClosed',0)
            ->get();

            $settlementwithold = DB::table('settlementdetails')
            ->join('settlements','settlements.id','=','settlementdetails.settlements_id')
            ->select(DB::raw('ROUND(SUM(settlementdetails.WitholdAmount),2) as WitholdAmount'))
            ->where('settlements.stores_id', '=',$posid)
            ->where('settlements.DocumentDate', '>=',$mindate)
            ->where('settlements.DocumentDate', '<=',$maxdate)
            ->where('settlements.Status',3)
            ->where('settlements.IsPaymentFollowUpClosed',0)
            ->where('settlementdetails.WitholdSetle',1)
            ->get();

            $settlementvat = DB::table('settlementdetails')
            ->join('settlements','settlements.id','=','settlementdetails.settlements_id')
            ->select(DB::raw('ROUND(SUM(settlementdetails.Vat),2) as VatAmount'))
            ->where('settlements.stores_id', '=',$posid)
            ->where('settlements.DocumentDate', '>=',$mindate)
            ->where('settlements.DocumentDate', '<=',$maxdate)
            ->where('settlements.Status',3)
            ->where('settlements.IsPaymentFollowUpClosed',0)
            ->where('settlementdetails.VatSetle',1)
            ->get();

        }
        else if($optypes==2){
            $pricingsett = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as GrandTotal'))
            ->where('VoucherType', '=', $vt)
            ->where('PaymentType', '=',$capt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->get();

            $pricingcredit = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CreditGrandTotal'))
            ->where('VoucherType', '=', $vt)
            ->where('PaymentType', '=',$crpt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->get();

            $pricingcashmanual = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CashGrandTotalManual'))
            ->where('VoucherType', '=', $mnvt)
            ->where('PaymentType', '=',$capt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->get();

            $pricingcreditmanual = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CreditGrandTotalManual'))
            ->where('VoucherType', '=', $mnvt)
            ->where('PaymentType', '=',$crpt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)

            ->get();

            //
            $witholddata = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(WitholdAmount),2) as WitholdAmount'))
            ->where('PaymentType', '=',$capt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->where('WitholdSetle',1)
            ->get();

            $vatdata = DB::table('sales')
            ->select(DB::raw('ROUND(SUM(Vat),2) as VatAmount'))
            ->where('PaymentType', '=',$capt)
            ->where('StoreId', '=',$posid)
            ->where('CreatedDate', '>=',$mindate)
            ->where('CreatedDate', '<=',$maxdate)
            ->where('Status','=',$status)
            ->get();

            //

            $pricingsettapp = DB::table('applications')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as GrandTotal'))
            ->where('VoucherType', '=', $vt)
            ->where('PaymentType', '=',$capt)
            ->where('stores_id', '=',$posid)
            ->where('InvoiceDate', '>=',$mindate)
            ->where('InvoiceDate', '<=',$maxdate)
            ->where('Status','=',$appstatus)
            ->get();

            $pricingcreditapp = DB::table('applications')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CreditGrandTotal'))
            ->where('VoucherType', '=', $vt)
            ->where('PaymentType', '=',$crpt)
            ->where('stores_id', '=',$posid)
            ->where('InvoiceDate', '>=',$mindate)
            ->where('InvoiceDate', '<=',$maxdate)
            ->where('Status','=',$appstatus)
            ->get();

            $pricingcashmanualapp = DB::table('applications')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CashGrandTotalManual'))
            ->where('VoucherType', '=', $mnvt)
            ->where('PaymentType', '=',$capt)
            ->where('stores_id', '=',$posid)
            ->where('InvoiceDate', '>=',$mindate)
            ->where('InvoiceDate', '<=',$maxdate)
            ->where('Status','=',$appstatus)
            ->get();

            $pricingcreditmanualapp = DB::table('applications')
            ->select(DB::raw('ROUND(SUM(GrandTotal),2) as CreditGrandTotalManual'))
            ->where('VoucherType', '=', $mnvt)
            ->where('PaymentType', '=',$crpt)
            ->where('stores_id', '=',$posid)
            ->where('InvoiceDate', '>=',$mindate)
            ->where('InvoiceDate', '<=',$maxdate)
            ->where('Status','=',$appstatus)
            ->get();

            //

            $settlementdata = DB::table('settlementdetails')
            ->join('settlements','settlements.id','=','settlementdetails.settlements_id')
            ->select(DB::raw('ROUND(SUM(settlementdetails.GrandTotal),2) AS SettledAmount'))
            ->where('settlements.stores_id', '=',$posid)
            ->where('settlements.DocumentDate', '>=',$mindate)
            ->where('settlements.DocumentDate', '<=',$maxdate)
            ->where('settlements.Status',3)
            ->where('settlements.IsPaymentFollowUpClosed',1)
            ->get();

            $settlementwithold = DB::table('settlementdetails')
            ->join('settlements','settlements.id','=','settlementdetails.settlements_id')
            ->select(DB::raw('ROUND(SUM(settlementdetails.WitholdAmount),2) as WitholdAmount'))
            ->where('settlements.stores_id', '=',$posid)
            ->where('settlements.DocumentDate', '>=',$mindate)
            ->where('settlements.DocumentDate', '<=',$maxdate)
            ->where('settlements.Status',3)
            ->where('settlements.IsPaymentFollowUpClosed',1)
            ->where('settlementdetails.WitholdSetle',1)
            ->get();

            $settlementvat = DB::table('settlementdetails')
            ->join('settlements','settlements.id','=','settlementdetails.settlements_id')
            ->select(DB::raw('ROUND(SUM(settlementdetails.Vat),2) as VatAmount'))
            ->where('settlements.stores_id', '=',$posid)
            ->where('settlements.DocumentDate', '>=',$mindate)
            ->where('settlements.DocumentDate', '<=',$maxdate)
            ->where('settlements.Status',3)
            ->where('settlements.IsPaymentFollowUpClosed',1)
            ->where('settlementdetails.VatSetle',1)
            ->get();
        }


        foreach($pricingsett as $pricecash){
            $prcash=$pricecash->GrandTotal;
        }
        foreach($pricingcredit as $prcredit){
            $prcreditsl=$prcredit->CreditGrandTotal;
        }
        foreach($pricingcashmanual as $mncash){
            $mancash=$mncash->CashGrandTotalManual;
        }
        foreach($pricingcreditmanual as $mncredit){
            $mancredit=$mncredit->CreditGrandTotalManual;
        }
        foreach($witholddata as $withdata){
            $withamount=$withdata->WitholdAmount;
        }
        foreach($vatdata as $vdata){
            $vatamount=$vdata->VatAmount;
        }

        foreach($settlementwithold as $withdata){
            $settwithamount=$withdata->WitholdAmount ??0;
        }
        foreach($settlementvat as $vdata){
            $settvatamount=$vdata->VatAmount ??0;
        }

        foreach($pricingsettapp as $pricecash){
            $prcashapp=$pricecash->GrandTotal;
        }
        foreach($pricingcreditapp as $prcredit){
            $prcreditapp=$prcredit->CreditGrandTotal;
        }
        foreach($pricingcashmanualapp as $mncash){
            $mancashapp=$mncash->CashGrandTotalManual;
        }
        foreach($pricingcreditmanualapp as $mncredit){
            $mancreditapp=$mncredit->CreditGrandTotalManual;
        }
        foreach($settlementdata as $settdata){
            $setteledamnt=$settdata->SettledAmount;
        }
        
        return Response::json(['cash'=>$prcash,'credit'=>$prcreditsl,'mancash'=>$mancash,'mancredit'=>$mancredit,'vatamount'=>$vatamount,'withamount'=>$withamount,
        'cashapp'=>$prcashapp,'creditapp'=>$prcreditapp,'mancashapp'=>$mancashapp,'mancreditapp'=>$mancreditapp,
        'settamnt'=>$setteledamnt,'settwithamount'=>$settwithamount,'settvatamount'=>$settvatamount
        ]);
    }

    public function getposdatacon(Request $request){
        $createddate=null;
        $countinc=0;
        $posid=$_POST['posid']; 
        $closingids=$_POST['closingidval']; 
        $poshidd=$_POST['poshidd']; 
        $status="Confirmed";
        $appstatus="Verified";
        $statusval=[4,5,6,7];
        $currentdate=Carbon::today()->toDateString();

        $storeval = DB::table('stores')
        ->where('stores.id',$posid)
        ->get();
        foreach($storeval as $row){
            $createddate=$row->IncomeClosingDate;
        }
        $date = Carbon::parse($createddate)->addDays(1)->toDateString();

        $closinginc = DB::table('incomeclosings')
        ->where('incomeclosings.stores_id',$poshidd)
        ->where('incomeclosings.id','>',$closingids)
        ->whereNotIn('incomeclosings.Status',$statusval)
        ->get();

        $countinc=$closinginc->count();

        // $getsalesdate=Sales::where('sales.StoreId', $posid)
        // ->where('sales.IsPaymentFollowUpClosed',0)
        // ->where('sales.Status','=',$status)
        // ->orderBy('sales.id','desc')
        // ->skip(0)
        // ->take(1)
        // ->get();

        // foreach($getsalesdate as $salesrow){
        //     $currentdate=$salesrow->CreatedDate;
        // }

        // if($createddate==null){
        //     $getappdate=ApplicationForm::where('applications.stores_id', $posid)
        //     ->where('applications.IsPaymentFollowUpClosed',0)
        //     ->where('applications.Status','=',$appstatus)
        //     ->orderBy('applications.id','asc')
        //     ->skip(0)
        //     ->take(1)
        //     ->get();
        //     foreach($getappdate as $approw){
        //         $createddate=$approw->InvoiceDate;
        //     }
        //     if($createddate==null){
        //         $getsettlementdate=settlementdetail::join('settlements','settlements.id','=','settlementdetails.settlements_id')
        //         ->where('settlements.stores_id', $posid)
        //         ->where('settlements.IsPaymentFollowUpClosed',0)
        //         ->where('settlements.Status',3)
        //         ->orderBy('settlements.id','asc')
        //         ->skip(0)
        //         ->take(1)
        //         ->get();
        //         foreach($getsettlementdate as $settrow){
        //             $createddate=$settrow->DocumentDate;
        //         }
        //     }
        // }

        // if(empty($createddate)) {
        //     $createddate=Carbon::today()->toDateString();
        // }
        return Response::json(['createddate'=>$createddate,'currentdate'=>$currentdate,'countinc'=>$countinc]);
    }

    public function bankdetinfo(Request $request){
        $bankids=$_POST['bankid']; 
        $accnums=$_POST['accnum']; 
        $data = bankdetail::where('bankdetails.banks_id',$bankids)
        ->where('bankdetails.id',$accnums)
        ->get();
        return response()->json(['bankdet'=>$data]);       
    }

    public function showfiscash($posid,$stdate,$endate)
    {
        $detailTable=DB::select('SELECT customers.Name,customers.TinNumber AS TIN,stores.Name AS POS,sales.CustomerMRC AS MRC,sales.VoucherNumber,sales.invoiceNo,sales.CreatedDate,sales.GrandTotal,"Sales" AS Outlets FROM sales INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN customers ON sales.CustomerId=customers.id WHERE sales.PaymentType="Cash" AND sales.VoucherType="Fiscal-Receipt" AND sales.CreatedDate>="'.$stdate.'" AND sales.CreatedDate<="'.$endate.'" AND sales.Status="Confirmed" AND sales.StoreId='.$posid.'
        UNION
        SELECT (SELECT GROUP_CONCAT(memberships.Name," ") FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id=applications.id) AS Name,(SELECT GROUP_CONCAT(memberships.TinNumber," ") FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id=applications.id) AS TIN,stores.Name,applications.Mrc,applications.VoucherNumber,applications.InvoiceNumber,applications.InvoiceDate,applications.GrandTotal,"Fitness" FROM applications INNER JOIN stores ON applications.stores_id=stores.id WHERE applications.PaymentType="Cash" AND applications.VoucherType="Fiscal-Receipt" AND applications.InvoiceDate>="'.$stdate.'" AND applications.InvoiceDate<="'.$endate.'" AND applications.Status="Verified" AND applications.stores_id='.$posid.'');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->make(true);
    }

    public function showfiscredit($posid,$stdate,$endate)
    {
        $detailTable=DB::select('SELECT customers.Name,customers.TinNumber AS TIN,stores.Name AS POS,sales.CustomerMRC AS MRC,sales.VoucherNumber,sales.invoiceNo,sales.CreatedDate,sales.GrandTotal,"Sales" AS Outlets FROM sales INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN customers ON sales.CustomerId=customers.id WHERE sales.PaymentType="Credit" AND sales.VoucherType="Fiscal-Receipt" AND sales.CreatedDate>="'.$stdate.'" AND sales.CreatedDate<="'.$endate.'" AND sales.Status="Confirmed" AND sales.StoreId='.$posid.'
        UNION
        SELECT (SELECT GROUP_CONCAT(memberships.Name," ") FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id=applications.id) AS Name,(SELECT GROUP_CONCAT(memberships.TinNumber," ") FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id=applications.id) AS TIN,stores.Name,applications.Mrc,applications.VoucherNumber,applications.InvoiceNumber,applications.InvoiceDate,applications.GrandTotal,"Fitness" FROM applications INNER JOIN stores ON applications.stores_id=stores.id WHERE applications.PaymentType="Credit" AND applications.VoucherType="Fiscal-Receipt" AND applications.InvoiceDate>="'.$stdate.'" AND applications.InvoiceDate<="'.$endate.'" AND applications.Status="Verified" AND applications.stores_id='.$posid.'');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->make(true);
    }

    public function showcashmanual($posid,$stdate,$endate)
    {
        $detailTable=DB::select('SELECT customers.Name,customers.TinNumber AS TIN,stores.Name AS POS,sales.VoucherNumber,sales.CreatedDate,sales.GrandTotal,"Sales" AS Outlets FROM sales INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN customers ON sales.CustomerId=customers.id WHERE sales.PaymentType="Cash" AND sales.VoucherType="Manual-Receipt" AND sales.CreatedDate>="'.$stdate.'" AND sales.CreatedDate<="'.$endate.'" AND sales.Status="Confirmed" AND sales.StoreId='.$posid.'
        UNION
        SELECT (SELECT GROUP_CONCAT(memberships.Name," ") FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id=applications.id) AS Name,(SELECT GROUP_CONCAT(memberships.TinNumber," ") FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id=applications.id) AS TIN,stores.Name,applications.VoucherNumber,applications.InvoiceDate,applications.GrandTotal,"Fitness" FROM applications INNER JOIN stores ON applications.stores_id=stores.id WHERE applications.PaymentType="Cash" AND applications.VoucherType="Manual-Receipt" AND applications.InvoiceDate>="'.$stdate.'" AND applications.InvoiceDate<="'.$endate.'" AND applications.Status="Verified" AND applications.stores_id='.$posid.'');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->make(true);
    }

    public function showcreditmanual($posid,$stdate,$endate)
    {
        $detailTable=DB::select('SELECT customers.Name,customers.TinNumber AS TIN,stores.Name AS POS,sales.VoucherNumber,sales.CreatedDate,sales.GrandTotal,"Sales" AS Outlets FROM sales INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN customers ON sales.CustomerId=customers.id WHERE sales.PaymentType="Credit" AND sales.VoucherType="Manual-Receipt" AND sales.CreatedDate>="'.$stdate.'" AND sales.CreatedDate<="'.$endate.'" AND sales.Status="Confirmed" AND sales.StoreId='.$posid.'
        UNION
        SELECT (SELECT GROUP_CONCAT(memberships.Name," ") FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id=applications.id) AS Name,(SELECT GROUP_CONCAT(memberships.TinNumber," ") FROM appmembers INNER JOIN memberships ON appmembers.memberships_id=memberships.id WHERE appmembers.applications_id=applications.id) AS TIN,stores.Name,applications.VoucherNumber,applications.InvoiceDate,applications.GrandTotal,"Fitness" FROM applications INNER JOIN stores ON applications.stores_id=stores.id WHERE applications.PaymentType="Credit" AND applications.VoucherType="Manual-Receipt" AND applications.InvoiceDate>="'.$stdate.'" AND applications.InvoiceDate<="'.$endate.'" AND applications.Status="Verified" AND applications.stores_id='.$posid.'');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->make(true);
    }

    public function showsettincdata($posid,$stdate,$endate)
    {
        $detailTable=DB::select('SELECT DISTINCT customers.Name,customers.TinNumber AS TIN,stores.Name AS POS,settlements.CrvNumber,settlements.DocumentDate,settlements.SettlementAmount AS GrandTotal FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id INNER JOIN stores ON settlements.stores_id=stores.id INNER JOIN customers ON settlements.customers_id=customers.id WHERE settlements.DocumentDate>="'.$stdate.'" AND settlements.DocumentDate<="'.$endate.'" AND settlements.stores_id='.$posid.' AND settlements.Status=3');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->make(true);
    }

    public function mrcdetaildata($id)
    {
        $detailTable=DB::select('SELECT *,CASE WHEN incomeclosingmrcs.BusinessDay=1 THEN "Usual" WHEN incomeclosingmrcs.BusinessDay=2 THEN "Unusual" END AS BusinessDays FROM incomeclosingmrcs WHERE incomeclosingmrcs.incomeclosings_id='.$id.' ORDER BY incomeclosingmrcs.id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn() 
        ->rawColumns(['action'])
        ->make(true);
    }

    public function bankdetaildata($id)
    {
        $detailTable=DB::select('SELECT banks.BankName,bankdetails.AccountNumber,incomeclosingbanks.SlipNumber,incomeclosingbanks.Amount,incomeclosingbanks.SlipDate,incomeclosingbanks.PaymentType,IFNULL(incomeclosingbanks.Remark,"") AS Remarks FROM incomeclosingbanks INNER JOIN banks ON incomeclosingbanks.banks_id=banks.id INNER JOIN bankdetails ON incomeclosingbanks.bankdetails_id=bankdetails.id WHERE incomeclosingbanks.incomeclosings_id='.$id.' ORDER BY incomeclosingbanks.id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn() 
        ->rawColumns(['action'])
        ->make(true);
    }

    public function ZnumVal(Request $request){
        $contn=0;
        $closingids=$_POST['closingids']; 
        $znumbers=$_POST['znumbers']; 
        $mrcnum=$_POST['mrcnum']; 
        if($closingids==0){
            $getznumval=DB::select('SELECT COUNT(incomeclosingmrcs.ZNumber) AS ZNumberCount FROM incomeclosingmrcs INNER JOIN incomeclosings ON incomeclosingmrcs.incomeclosings_id=incomeclosings.id WHERE incomeclosingmrcs.ZNumber='.$znumbers.' AND incomeclosingmrcs.MrcNumber="'.$mrcnum.'" AND incomeclosings.IsVoid=0');
            foreach($getznumval as $row)
            {
                $contn=$row->ZNumberCount;
            }
        }
        else if($closingids>0){
            $getznumval=DB::select('SELECT COUNT(incomeclosingmrcs.ZNumber) AS ZNumberCount FROM incomeclosingmrcs INNER JOIN incomeclosings ON incomeclosingmrcs.incomeclosings_id=incomeclosings.id WHERE incomeclosingmrcs.ZNumber='.$znumbers.' AND incomeclosingmrcs.MrcNumber="'.$mrcnum.'" AND incomeclosingmrcs.incomeclosings_id!='.$closingids.' AND incomeclosings.IsVoid=0');
            foreach($getznumval as $row)
            {
                $contn=$row->ZNumberCount;
            }
        } 
        return response()->json(['contn'=>$contn]);       
    }

    public function SlipNumVal(Request $request){
        $contn=0;
        $closingids=$_POST['closingids']; 
        $bankids=$_POST['bankids']; 
        $accnum=$_POST['accnum']; 
        $slipnum=$_POST['slipnum']; 
        $pmodes=$_POST['pmodes']; 
        if($closingids==0){
            $getznumval=DB::select('SELECT COUNT(incomeclosingbanks.SlipNumber) AS SlipNumberCount FROM incomeclosingbanks INNER JOIN incomeclosings ON incomeclosingbanks.incomeclosings_id=incomeclosings.id WHERE incomeclosingbanks.banks_id='.$bankids.' AND incomeclosingbanks.SlipNumber="'.$slipnum.'" AND incomeclosingbanks.PaymentType="'.$pmodes.'" AND incomeclosings.IsVoid=0');
            foreach($getznumval as $row)
            {
                $contn=$row->SlipNumberCount;
            }
        }
        else if($closingids>0){
            $getznumval=DB::select('SELECT COUNT(incomeclosingbanks.SlipNumber) AS SlipNumberCount FROM incomeclosingbanks INNER JOIN incomeclosings ON incomeclosingbanks.incomeclosings_id=incomeclosings.id WHERE incomeclosingbanks.banks_id='.$bankids.' AND incomeclosingbanks.SlipNumber="'.$slipnum.'" AND incomeclosingbanks.PaymentType="'.$pmodes.'" AND incomeclosingbanks.incomeclosings_id!='.$closingids.' AND incomeclosings.IsVoid=0');
            foreach($getznumval as $row)
            {
                $contn=$row->SlipNumberCount;
            }
        } 
        return response()->json(['contn'=>$contn]);       
    }

    public function downloadzdoc($ids,$file_name) 
    {
        $file_path = public_path('storage/uploads/ZDocumentUploads/'.$file_name);
        return response()->download($file_path);
    }

    public function downloadsldoc($ids,$file_name) 
    {
        $file_path = public_path('storage/uploads/BankSlipUploads/'.$file_name);
        return response()->download($file_path);
    }

    public function IncomeAttachment($id)
    {
        if(incomeclosingbank::where('incomeclosings_id',$id)->exists() || incomeclosingmrc::where('incomeclosings_id',$id)->exists())
        {
            $st="";
            error_reporting(0); 
            //---Start Header Info---
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
            $companyLogo=$compInfo->Logo;
            $systemalladdress=$sysInfo->AllAddress;
            //---End Footer Info----- 

            $headerInfo=incomeclosing::find($id);
            $incdoc=$headerInfo->IncomeDocumentNumber;
            $startdate=$headerInfo->StartDate;
            $enddate=$headerInfo->EndDate;
            $totalcashdep=$headerInfo->TotalCashDeposited;
            $totalcash=$headerInfo->TotalCash;
            $witholds=$headerInfo->WitholdAmount;
            $vats=$headerInfo->VatAmount;
            $netcashrec=$headerInfo->NetCashReceived;
            $mem=$headerInfo->Memo;
            $preparedby=$headerInfo->PreparedBy;
            $checkedby=$headerInfo->VerifiedBy;
            $checkeddate=$headerInfo->VerifiedDate;
            $confirmedby=$headerInfo->ConfirmedBy;
            $confirmeddate=$headerInfo->ConfirmedDate;
            $storeid=$headerInfo->stores_id;
            $settamount=$headerInfo->SettlementAmount;
            $status=$headerInfo->Status;
            $transactiondate = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            $statusInfo=status::find($status);
            $statusval=$statusInfo->StatusName;
            if($status==4||$status==5||$status==6||$status==7){
                $st=$statusval;
            }
            else if($status==1||$status==2||$status==3){
                $st="";
            }

            $storedetail=store::find($storeid);
            $storename=$storedetail->Name;

            $currentdate=Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
           
            $count=0;
            $bcount=0;
            $detailTable=DB::select('SELECT *,CASE WHEN incomeclosingmrcs.BusinessDay=1 THEN "Usual" WHEN incomeclosingmrcs.BusinessDay=2 THEN "Unusual" END AS BusinessDays,FORMAT(incomeclosingmrcs.CashAmount,2) AS CashAmounts,FORMAT(incomeclosingmrcs.CreditAmount,2) AS CreditAmounts,FORMAT(incomeclosingmrcs.TotalAmount,2) AS TotalAmounts FROM incomeclosingmrcs WHERE incomeclosingmrcs.incomeclosings_id='.$id.' ORDER BY incomeclosingmrcs.id ASC');
            $bankdata=DB::select('SELECT banks.BankName,bankdetails.AccountNumber,incomeclosingbanks.SlipNumber,incomeclosingbanks.SlipDate,incomeclosingbanks.Amount,FORMAT(incomeclosingbanks.Amount,2) AS Amounts,incomeclosingbanks.PaymentType,IFNULL(incomeclosingbanks.Remark,"") AS Remarks FROM incomeclosingbanks INNER JOIN banks ON incomeclosingbanks.banks_id=banks.id INNER JOIN bankdetails ON incomeclosingbanks.bankdetails_id=bankdetails.id WHERE incomeclosingbanks.incomeclosings_id='.$id.' ORDER BY incomeclosingbanks.id ASC');
            $data=[ 'bankdata'=>$bankdata,'detailTable'=>$detailTable,
                    'transactiondate'=>$transactiondate,
                    'mem'=>$mem,
                    'incdoc'=>$incdoc,
                    'startdate'=>$startdate,
                    'enddate'=>$enddate,
                    'storename'=>$storename,
                    'totalcashdep'=>number_format($totalcashdep,2),
                    'totalcash'=>number_format($totalcash,2),
                    'witholds'=>number_format($witholds,2),
                    'vats'=>number_format($vats,2),
                    'netcashrec'=>number_format($netcashrec,2),
                    'preparedby'=>$preparedby,
                    'checkedby'=>$checkedby,
                    'checkeddate'=>$checkeddate,
                    'confirmedby'=>$confirmedby,
                    'confirmeddate'=>$confirmeddate,
                    'count'=>$count,
                    'bcount'=>$bcount,
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
                $html=\View::make('finance.report.incfollowup')->with($data);
                //$html=\View::make('report.HtmlToPDF')->with($data);
                $html=$html->render();  
                $mpdf->SetTitle('Income Follow-Up Note');
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0; 
                $mpdf->SetAuthor($companyalladdress);
                $mpdf->SetWatermarkText($st);
                $mpdf->watermark_font = 'DejaVuSansCondensed';
                $mpdf->showWatermarkText = true;
                $mpdf->WriteHTML($html);
                $mpdf->Output('Income Follow-Up Note.pdf','I');

            //$pdf=PDF::loadView('inventory.report.grv',$data);
            //return $pdf->stream();
        }
    }


    //Bank report data
    public function bankreplist($from,$to)
    {
        $posids=$_POST['posids']; 
        $posid=implode(',', $posids);

        $bankids=$_POST['bankids']; 
        $bankid=implode(',', $bankids);

        $pmodes=$_POST['pmodes']; 
        $pmode=implode(',', $pmodes);

        $query = DB::select('SELECT incomeclosings.IncomeDocumentNumber,incomeclosingbanks.PaymentType,stores.Name AS POS,banks.BankName,bankdetails.AccountNumber,incomeclosingbanks.SlipNumber,incomeclosingbanks.SlipDate,incomeclosingbanks.Amount FROM incomeclosingbanks INNER JOIN incomeclosings ON incomeclosingbanks.incomeclosings_id=incomeclosings.id INNER JOIN bankdetails ON incomeclosingbanks.bankdetails_id=bankdetails.id INNER JOIN banks ON incomeclosingbanks.banks_id=banks.id INNER JOIN stores ON incomeclosings.stores_id=stores.id WHERE incomeclosings.Status=3 AND incomeclosingbanks.SlipDate>="'.$from.'" AND incomeclosingbanks.SlipDate<="'.$to.'" AND incomeclosings.stores_id IN('.$posid.') AND incomeclosingbanks.PaymentType IN('.$pmode.') AND incomeclosingbanks.banks_id IN('.$bankid.') GROUP BY incomeclosingbanks.incomeclosings_id,incomeclosingbanks.banks_id,incomeclosingbanks.bankdetails_id,incomeclosingbanks.SlipNumber,incomeclosingbanks.PaymentType');
        return datatables()->of($query)->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

   
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
