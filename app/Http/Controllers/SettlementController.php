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
use App\Models\uom;
use App\Models\settlement;
use App\Models\settlementdetail;
use App\Models\Sales;
use App\Models\status;
use App\Models\store;
use App\Models\companyinfo;
use App\Models\systeminfo;
use App\Reports\SettlementRep;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class SettlementController extends Controller
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
        $users=Auth()->user();
        $currentdate=Carbon::today()->toDateString();
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $storeSrc=DB::select('SELECT DISTINCT stores.id AS StoreId,stores.Name AS StoreName FROM sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.PaymentType="Credit" AND sales.StoreId IN( SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=4) AND stores.ActiveStatus="Active" AND stores.IsDeleted=1 ORDER BY stores.Name ASC');
        $bank=DB::select('select * from banks order by BankName asc');
        $bankedt=DB::select('select * from banks order by BankName asc');
        $accountnumbers=DB::select('SELECT * FROM bankdetails WHERE bankdetails.Status="Active" ORDER BY bankdetails.id ASC');
        $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear>='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
        if($request->ajax()) {
            return view('finance.settlement',['bank'=>$bank,'bankedt'=>$bankedt,'storeSrc'=>$storeSrc,'user'=> $user,'fiscalyears'=>$fiscalyears,'accnum'=>$accountnumbers])->renderSections()['content'];
        }
        else{
            return view('finance.settlement',['bank'=>$bank,'bankedt'=>$bankedt,'storeSrc'=>$storeSrc,'user'=> $user,'fiscalyears'=>$fiscalyears,'accnum'=>$accountnumbers]);
        }
    }

    public function settlementListCon($fyear)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $saleslists=DB::select('SELECT sales.id AS SalesId,sales.StoreId,sales.CustomerId,customers.Code,customers.CustomerCategory,customers.Name,customers.TinNumber,customers.DefaultPrice,customers.VatType,customers.Witholding,sales.PaymentType,'.$fiscalyr.' AS FiscalYears,
        
        @currnetfy:=(SELECT 
        CASE WHEN sales.WitholdSetle=1 AND sales.VatSetle=1 THEN
        COALESCE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount)-SUM(sales.Vat),0) 
        WHEN sales.WitholdSetle=1 AND (sales.VatSetle=0 OR sales.VatSetle IS NULL) THEN COALESCE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount),0) WHEN sales.VatSetle=1 AND (sales.WitholdSetle=0 OR sales.WitholdSetle IS NULL) THEN
        COALESCE(SUM(sales.GrandTotal)-SUM(sales.Vat),0) WHEN (sales.VatSetle=0 OR sales.VatSetle IS NULL) AND (sales.WitholdSetle=0 OR sales.WitholdSetle IS NULL) THEN COALESCE(SUM(sales.GrandTotal),0) END
        FROM sales WHERE sales.CustomerId=customers.id AND sales.fiscalyear='.$fyear.' AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=4)) AS NetPay,
        
        @otherfy:=(SELECT 
        CASE WHEN sales.WitholdSetle=1 AND sales.VatSetle=1 THEN
        COALESCE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount)-SUM(sales.Vat),0) 
        WHEN sales.WitholdSetle=1 AND (sales.VatSetle=0 OR sales.VatSetle IS NULL) THEN COALESCE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount),0) WHEN sales.VatSetle=1 AND (sales.WitholdSetle=0 OR sales.WitholdSetle IS NULL) THEN
        COALESCE(SUM(sales.GrandTotal)-SUM(sales.Vat),0) WHEN (sales.VatSetle=0 OR sales.VatSetle IS NULL) AND (sales.WitholdSetle=0 OR sales.WitholdSetle IS NULL) THEN COALESCE(SUM(sales.GrandTotal),0) END
        FROM sales WHERE sales.CustomerId=customers.id AND sales.fiscalyear<'.$fyear.' AND sales.setlmentstatus!=3 AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=4)) AS NetPayFy,

        @creditsales:=@currnetfy AS TotalNetPay,

        @settledamount:=(SELECT COALESCE(SUM(settlementdetails.SettlementAmount),0) FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlements.customers_id=customers.id AND settlements.IsVoid=0 AND settlements.fiscalyear='.$fyear.' AND settlements.Status=3) AS SettledAmounts,IF(@settledamount is null,@creditsales,(@otherfy+@currnetfy)-@settledamount) AS OustandingBalance  
        FROM sales INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=4) GROUP BY customers.Name,sales.CustomerId,customers.CustomerCategory,customers.TinNumber,customers.VatType,customers.Witholding,sales.PaymentType HAVING OustandingBalance>0 OR SettledAmounts>0 OR TotalNetPay>0 ORDER BY customers.Name ASC');
        
        if(request()->ajax()) {
            return datatables()->of($saleslists)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $settInfo='';
                $settOpt='';

                $btn='<a class="settlementBtn" href="javascript:void(0)" onclick="settlementBtn('.$data->CustomerId.','.$data->StoreId.')" data-id="'.$data->CustomerId.'" data-sid="'.$data->StoreId.'" title="Show customers detail credit transaction with their settlement"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';   
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function salesSettlementListCon($fyear)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $settingsval = DB::table('settings')->latest()->first();
        $php =$settingsval->FiscalYear;
        $saleslists=DB::select('SELECT settlements.id,customers.Name AS CustomerName,customers.Code,customers.TinNumber AS TIN,stores.Name AS POS,settlements.CrvNumber,GROUP_CONCAT(DISTINCT(sales.VoucherNumber)," ") AS FSNumber,GROUP_CONCAT(DISTINCT(sales.invoiceNo)," ") AS InvoiceNumber,settlements.DocumentDate AS CRVDate,statuses.StatusName AS StatusVal,settlements.Status,settlements.OldStatus FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id INNER JOIN sales ON settlementdetails.sales_id=sales.id INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN statuses ON settlements.Status=statuses.id WHERE settlements.fiscalyear='.$fyear.' AND settlements.stores_id IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=4) GROUP BY settlementdetails.settlements_id ORDER BY settlements.id DESC');
        if(request()->ajax()) {
            return datatables()->of($saleslists)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $settInfo='';
                $settOpt='';
                $unvoidvlink='';
                $voidlink='';
                $witholdln='';
                $editln='';
                $println='';
                if($data->Status==4||$data->Status==5||$data->Status==6||$data->Status==7)
                {
                    if($user->can('Sales-Settlement-Void'))
                    {
                        $unvoidvlink= '<a class="dropdown-item undovoidlnbtn" onclick="undovoidlnbtn('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->OldStatus.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                    }
                    $voidlink='';
                    $editln='';
                    $witholdln='';
                }
                else if($data->Status==3)
                {
                    if($user->can('Sales-Settlement-Edit-Confirmed-Document'))
                    {
                        $editln='<a class="dropdown-item editSalesSettlement" onclick="editsettlementdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Sales-Settlement-Confirm') && $user->can('Sales-Settlement-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }
                }
                else if($data->Status==2)
                {
                    if($user->can('Sales-Settlement-Verify') && $user->can('Sales-Settlement-Edit'))
                    {
                        $editln='<a class="dropdown-item editSalesSettlement" onclick="editsettlementdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    
                    if($user->can('Sales-Settlement-Verify') && $user->can('Sales-Settlement-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    } 
                }
                else if($data->Status==1)
                {
                    if($user->can('Sales-Settlement-Edit'))
                    {
                        $editln='<a class="dropdown-item editSalesSettlement" onclick="editsettlementdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Sales-Settlement-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }            
                }
                
                $println='<a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/settatt/'.$data->id.'" id="printsettnote" data-attr="" title="Print Settlement Note"><i class="fa fa-file"></i><span> Print Settlement Note</span></a>';
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item settlementInfo" onclick="settlementInfo('.$data->id.')" data-id="'.$data->id.'" data-toggle="modal" id="dtinfobtn" title="">
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

    public function totalcreditsales($fyear){
        $status="Confirmed";
        $paymentType="Credit";
        $settstatus=3;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $selectedstore=[];
        $getselectedstore = DB::table('storeassignments')
        ->where('storeassignments.UserId',$userid)
        ->where('storeassignments.Type',4)
        ->get(['StoreId']);
        foreach($getselectedstore as $nrow){
            $selectedstore[]=$nrow->StoreId;
        }

        $pricing = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(GrandTotal),2),0) AS GrandTotal'))
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->where('sales.fiscalyear','=',$fyear)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->get();
        
        $withsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(WitholdAmount),2),0) AS WitholdAmount'))
        ->where('sales.WitholdSetle',1)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->where('sales.fiscalyear','=',$fyear)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->get();

        $vatsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(Vat),2),0) AS VatAmount'))
        ->where('sales.VatSetle',1)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->where('sales.fiscalyear','=',$fyear)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->get();

        $pricingfy = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(GrandTotal),2),0) AS GrandTotal'))
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->where('sales.setlmentstatus','!=',$settstatus)
        ->where('sales.fiscalyear','<',$fyear)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->get();
        
        $withsettfy = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(WitholdAmount),2),0) AS WitholdAmount'))
        ->where('sales.WitholdSetle',1)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->where('sales.setlmentstatus','!=',$settstatus)
        ->where('sales.fiscalyear','<',$fyear)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->get();

        $vatsettfy = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(Vat),2),0) AS VatAmount'))
        ->where('sales.VatSetle',1)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->where('sales.setlmentstatus','!=',$settstatus)
        ->where('sales.fiscalyear','<',$fyear)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->get();

        $settpricing = DB::table('settlements')
        ->select(DB::raw('COALESCE(ROUND(SUM(SettlementAmount),2),0) AS SettlementAmount'))
        ->where('IsVoid',0)
        ->where('Status',3)
        ->where('settlements.fiscalyear','=',$fyear)
        ->whereIn('settlements.stores_id',$selectedstore)
        ->get();
        return response()->json(['pricing'=>$pricing,'settpricing'=>$settpricing,'withsett'=>$withsett,'vatsett'=>$vatsett,'pricingfy'=>$pricingfy,'withsettfy'=>$withsettfy,'vatsettfy'=>$vatsettfy]);
    }

    public function totalcreditpurchase(){
        $status="Confirmed";
        $paymentType="Credit";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $selectedrecstore=[];
        $getselectedrecstore = DB::table('storeassignments')
        ->where('storeassignments.UserId',$userid)
        ->where('storeassignments.Type',1)
        ->get(['StoreId']);
        foreach($getselectedrecstore as $nrow){
            $selectedrecstore[]=$nrow->StoreId;
        }
        $pricing = DB::table('receivings')
        ->select(DB::raw('COALESCE(ROUND(SUM(GrandTotal),2),0) AS GrandTotal'))
        ->where('receivings.PaymentType','=',$paymentType)
        ->where('receivings.Status','=',$status)
        ->whereIn('receivings.StoreId',$selectedrecstore)
        ->get();
        
        $withsett = DB::table('receivings')
        ->select(DB::raw('COALESCE(ROUND(SUM(WitholdAmount),2),0) AS WitholdAmount'))
        ->where('receivings.IsWitholdSettle',1)
        ->where('receivings.PaymentType','=',$paymentType)
        ->where('receivings.Status','=',$status)
        ->whereIn('receivings.StoreId',$selectedrecstore)
        ->get();

        $settpricing = DB::table('settlements')
        ->select(DB::raw('COALESCE(ROUND(SUM(SettlementAmount),2),0) AS SettlementAmount'))
        ->where('IsVoid','=',"0")
        ->get();
        return response()->json(['pricing'=>$pricing,'settpricing'=>$settpricing,'withsett'=>$withsett]);
    }

    public function showcreditsalesett($fyear){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $crSales=DB::select('SELECT stores.Name,
	    @totalcrsalesbef:=(SELECT COALESCE(SUM(sales.GrandTotal),0) FROM sales WHERE sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear<'.$fyear.')-        
        (SELECT COALESCE(SUM(sales.WitholdAmount),0) FROM sales WHERE sales.WitholdSetle=1 AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear<'.$fyear.')-
        (SELECT COALESCE(SUM(sales.Vat),0) FROM sales WHERE sales.VatSetle=1 AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear<'.$fyear.') AS BeforeFiscalYear,
        @creditsales:=(SELECT COALESCE(SUM(sales.GrandTotal),0) FROM sales WHERE sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear='.$fyear.')-                          
        (SELECT COALESCE(SUM(sales.WitholdAmount),0) FROM sales WHERE sales.WitholdSetle=1 AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear='.$fyear.')-
        (SELECT COALESCE(SUM(sales.Vat),0) FROM sales WHERE sales.VatSetle=1 AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear='.$fyear.') AS NetPay,
        @settledamount:=(SELECT COALESCE(SUM(settlementdetails.SettlementAmount),0) FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlements.stores_id=stores.id AND settlements.IsVoid=0 AND settlements.Status=3 AND settlements.fiscalyear='.$fyear.') AS SettledAmounts,
        @outstandingamount:=(@totalcrsalesbef+@creditsales)-@settledamount AS OutstandingBalance
        FROM sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=4) GROUP BY sales.StoreId ORDER BY stores.Name ASC'); 
        return response()->json(['crsales'=>$crSales]);
    }

    public function showcreditsalecussett($cusid,$fyear){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();

        $cusinfo=DB::select('SELECT customers.CreditSalesLimitEnd,customers.CreditSalesLimitFlag FROM customers WHERE customers.id='.$cusid); 

        $crSales=DB::select('SELECT stores.Name,
	    @totalcrsalesbef:=(SELECT COALESCE(SUM(sales.GrandTotal),0) FROM sales WHERE sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear<'.$fyear.' AND sales.CustomerId='.$cusid.')-        
        (SELECT COALESCE(SUM(sales.WitholdAmount),0) FROM sales WHERE sales.WitholdSetle=1 AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear<'.$fyear.' AND sales.CustomerId='.$cusid.')-
        (SELECT COALESCE(SUM(sales.Vat),0) FROM sales WHERE sales.VatSetle=1 AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear<'.$fyear.' AND sales.CustomerId='.$cusid.') AS BeforeFiscalYear,
        @creditsales:=(SELECT COALESCE(SUM(sales.GrandTotal),0) FROM sales WHERE sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear='.$fyear.' AND sales.CustomerId='.$cusid.')-                          
        (SELECT COALESCE(SUM(sales.WitholdAmount),0) FROM sales WHERE sales.WitholdSetle=1 AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear='.$fyear.' AND sales.CustomerId='.$cusid.')-
        (SELECT COALESCE(SUM(sales.Vat),0) FROM sales WHERE sales.VatSetle=1 AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId=stores.id AND sales.fiscalyear='.$fyear.' AND sales.CustomerId='.$cusid.') AS NetPay,
        @settledamount:=(SELECT COALESCE(SUM(settlementdetails.SettlementAmount),0) FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlements.stores_id=stores.id AND settlements.IsVoid=0 AND settlements.Status=3 AND settlements.fiscalyear='.$fyear.' AND settlements.customers_id='.$cusid.') AS SettledAmounts,
        @outstandingamount:=(@totalcrsalesbef+@creditsales)-@settledamount AS OutstandingBalance
        FROM sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.CustomerId='.$cusid.' AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=4) GROUP BY sales.StoreId ORDER BY stores.Name ASC'); 
        return response()->json(['crsales'=>$crSales,'cusinfo'=>$cusinfo]);
    }

    public function showCreditSalesCon($cusid,$sid,$fyear)
    {
        $status="Confirmed";
        $paymentType="Credit";
        $settstatus=3;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $selectedstore=[];
        $selectedrecstore=[];
        $fymonthrange="";

        $crSales=DB::select('SELECT sales.id,sales.CustomerId,customers.Code,customers.CustomerCategory,customers.Name,customers.TinNumber,customers.OfficePhone,customers.PhoneNumber,customers.VatNumber,customers.VatType,customers.Witholding,customers.*,sales.PaymentType,sales.VoucherType,sales.VoucherNumber,sales.CustomerMRC,sales.Vat,sales.WitholdAmount,sales.SubTotal,stores.Name as StoreName,sales.CreatedDate,sales.Status,fiscalyear.Monthrange FROM sales INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN fiscalyear ON sales.fiscalyear=fiscalyear.FiscalYear WHERE sales.CustomerId='.$cusid); 

        $getselectedstore = DB::table('storeassignments')
        ->where('storeassignments.UserId',$userid)
        ->where('storeassignments.Type',4)
        ->get(['StoreId']);
        foreach($getselectedstore as $nrow){
            $selectedstore[]=$nrow->StoreId;
        }

        $getfiscalyear = DB::table('fiscalyear')
        ->where('fiscalyear.FiscalYear',$fyear)
        ->get(['Monthrange']);
        foreach($getfiscalyear as $frow){
            $fymonthrange=$frow->Monthrange;
        }

        $getselectedrecstore = DB::table('storeassignments')
        ->where('storeassignments.UserId',$userid)
        ->where('storeassignments.Type',1)
        ->get(['StoreId']);
        foreach($getselectedrecstore as $nrow){
            $selectedrecstore[]=$nrow->StoreId;
        }

        $pricing = DB::table('sales')
        ->join('customers','customers.id','=','sales.CustomerId')
        ->select(DB::raw('COALESCE(ROUND(SUM(GrandTotal),2),0) AS GrandTotal'))
        ->where('sales.CustomerId','=',$cusid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->where('sales.fiscalyear','=',$fyear)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->whereIn('sales.StoreId',$selectedstore)
        ->get();

        $withsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(WitholdAmount),2),0) AS WitholdAmount'))
        ->where('sales.WitholdSetle',1)
        ->where('sales.CustomerId','=',$cusid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->where('sales.fiscalyear','=',$fyear)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->whereIn('sales.StoreId',$selectedstore)
        ->get();

        $vatsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(Vat),2),0) AS VatAmount'))
        ->where('sales.VatSetle',1)
        ->where('sales.CustomerId','=',$cusid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->where('sales.fiscalyear','=',$fyear)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->whereIn('sales.StoreId',$selectedstore)
        ->get();

        $settpricing = DB::table('settlementdetails')
        ->join('sales', 'settlementdetails.sales_id', '=', 'sales.id')
        ->join('settlements', 'settlementdetails.settlements_id', '=', 'settlements.id')
        ->select(DB::raw('COALESCE(ROUND(SUM(settlementdetails.SettlementAmount),2),0) AS SettlementAmount'))
        ->where('settlements.customers_id','=',$cusid)
        ->where('settlements.IsVoid','=',"0")
        ->where('settlements.Status',3)
        ->where('settlements.fiscalyear','=',$fyear)
        ->whereIn('settlements.stores_id',$selectedstore)
        ->get();

        $recpricing = DB::table('receivings')
        ->select(DB::raw('COALESCE(ROUND(SUM(GrandTotal),2),0) AS GrandTotal'))
        ->where('receivings.PaymentType','=',$paymentType)
        ->where('receivings.CustomerId','=',$cusid)
        ->where('receivings.Status','=',$status)
        ->get();
        
        $recwithsett = DB::table('receivings')
        ->select(DB::raw('COALESCE(ROUND(SUM(WitholdAmount),2),0) AS WitholdAmount'))
        ->where('receivings.IsWitholdSettle',1)
        ->where('receivings.CustomerId','=',$cusid)
        ->where('receivings.PaymentType','=',$paymentType)
        ->where('receivings.Status','=',$status)
        ->get();

        $data =  DB::table('settlementdetails')
        ->join('settlements', 'settlementdetails.settlements_id', '=', 'settlements.id')
        ->join('sales', 'settlementdetails.sales_id', '=', 'sales.id')
        ->join('customers', 'sales.CustomerId', '=', 'customers.id')
        ->join('stores', 'sales.StoreId', '=', 'stores.id')
        ->where('sales.CustomerId', $cusid)
        ->where('settlements.fiscalyear','=',$fyear)
        ->orderBy('sales.CreatedDate','asc')
        ->get(['settlements.*','sales.*','customers.Name AS CustomerName','stores.Name AS POS']);

        $pricingfy = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(GrandTotal),2),0) AS GrandTotal'))
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->where('sales.setlmentstatus','!=',$settstatus)
        ->where('sales.CustomerId', $cusid)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->where('sales.fiscalyear','<',$fyear)
        ->get();
        
        $withsettfy = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(WitholdAmount),2),0) AS WitholdAmount'))
        ->where('sales.WitholdSetle',1)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->where('sales.setlmentstatus','!=',$settstatus)
        ->where('sales.CustomerId', $cusid)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->where('sales.fiscalyear','<',$fyear)
        ->get();

        $vatsettfy = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(Vat),2),0) AS VatAmount'))
        ->where('sales.VatSetle',1)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->where('sales.setlmentstatus','!=',$settstatus)
        ->where('sales.CustomerId', $cusid)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->where('sales.fiscalyear','<',$fyear)
        ->get();

        return response()->json(['crSales'=>$crSales,'pricing'=>$pricing,'settpricing'=>$settpricing,'withsett'=>$withsett,'vatsett'=>$vatsett,'recpricing'=>$recpricing,'recwithsett'=>$recwithsett,'setdata'=>$data,'pricingfy'=>$pricingfy,'withsettfy'=>$withsettfy,'vatsettfy'=>$vatsettfy,'fymonthrange'=>$fymonthrange]);       
    }

    public function showdocinfos($pos,$cus){
        $status="Confirmed";
        $paymentType="Credit";
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $selectedstore=[];
        $selectedrecstore=[];

        $getselectedstore = DB::table('storeassignments')
        ->where('storeassignments.UserId',$userid)
        ->where('storeassignments.Type',4)
        ->get(['StoreId']);
        foreach($getselectedstore as $nrow){
            $selectedstore[]=$nrow->StoreId;
        }

        $pricing = DB::table('sales')
        ->join('customers','customers.id','=','sales.CustomerId')
        ->select(DB::raw('COALESCE(ROUND(SUM(GrandTotal),2),0) AS GrandTotal'))
        ->where('sales.CustomerId','=',$cus)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->get();

        $withsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(WitholdAmount),2),0) AS WitholdAmount'))
        ->where('sales.WitholdSetle',1)
        ->where('sales.CustomerId','=',$cus)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->get();

        $vatsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(Vat),2),0) AS VatAmount'))
        ->where('sales.VatSetle',1)
        ->where('sales.CustomerId','=',$cus)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->get();

        $settpricing = DB::table('settlementdetails')
        ->join('sales', 'settlementdetails.sales_id', '=', 'sales.id')
        ->join('settlements', 'settlementdetails.settlements_id', '=', 'settlements.id')
        ->select(DB::raw('COALESCE(ROUND(SUM(settlementdetails.SettlementAmount),2),0) AS SettlementAmount'))
        ->where('settlements.customers_id','=',$cus)
        ->where('settlements.IsVoid','=',"0")
        ->whereIn('settlements.stores_id',$selectedstore)
        ->get();

        $cusinformations = DB::table('customers')
        ->select('customers.*')
        ->where('customers.id','=',$cus)
        ->get();

        $posinformations = DB::table('stores')
        ->select('stores.*')
        ->where('stores.id','=',$pos)
        ->get();
        return response()->json(['cuslist'=>$cusinformations,'poslist'=>$posinformations,'pricing'=>$pricing,'settpricing'=>$settpricing,'withsett'=>$withsett,'vatsett'=>$vatsett]); 
    }

    public function getCreditCustomers($id){
        $paymentType="Credit";
        $status="Confirmed";
        $settstatus=2;
        $data = Sales::join('customers', 'sales.CustomerId', '=', 'customers.id')
        ->where('sales.StoreId', $id)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->where('sales.setlmentstatus','!=',$settstatus)
        ->orderBy('customers.Name','asc')
        ->distinct()
        ->get(['customers.id AS CustomerId','customers.Name AS CustomerName','customers.Code AS CustomerCode','customers.TinNumber AS CustomerTIN']);
        return response()->json(['cuslist'=>$data]);       
    }

    public function showsettlementrec($id){
        $paymentType="Credit";
        $status="Confirmed";

        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();

        $sett=settlement::find($id);
        $storeids=$sett->stores_id;
        $customerid=$sett->customers_id;
        $createddateval=$sett->created_at;

        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $selectedstore=[];
        $selectedrecstore=[];

        $getselectedstore = DB::table('storeassignments')
        ->where('storeassignments.UserId',$userid)
        ->where('storeassignments.Type',4)
        ->get(['StoreId']);
        foreach($getselectedstore as $nrow){
            $selectedstore[]=$nrow->StoreId;
        }

        $checkingsales = DB::table('settlements')
        ->select('settlements.id')
        ->where('settlements.id','>',$id)
        ->where('settlements.stores_id','=',$storeids)
        ->where('settlements.customers_id','=',$customerid)
        ->where('settlements.IsVoid',0)
        ->get();

        $checkingvoidsales = DB::table('settlements')
        ->select('settlements.id')
        ->where('settlements.id','<',$id)
        ->where('settlements.stores_id','=',$storeids)
        ->where('settlements.customers_id','=',$customerid)
        ->where('settlements.IsVoid',1)
        ->get();

        $pricing = DB::table('sales')
        ->join('customers','customers.id','=','sales.CustomerId')
        ->select(DB::raw('COALESCE(ROUND(SUM(GrandTotal),2),0) AS GrandTotal'))
        ->where('sales.CustomerId','=',$customerid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->get();

        $withsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(WitholdAmount),2),0) AS WitholdAmount'))
        ->where('sales.WitholdSetle',1)
        ->where('sales.CustomerId','=',$customerid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->get();

        $vatsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(Vat),2),0) AS VatAmount'))
        ->where('sales.VatSetle',1)
        ->where('sales.CustomerId','=',$customerid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.StoreId',$selectedstore)
        ->get();

        $settpricing = DB::table('settlementdetails')
        ->join('sales', 'settlementdetails.sales_id', '=', 'sales.id')
        ->join('settlements', 'settlementdetails.settlements_id', '=', 'settlements.id')
        ->select(DB::raw('COALESCE(ROUND(SUM(settlementdetails.SettlementAmount),2),0) AS SettlementAmount'))
        ->where('settlements.customers_id','=',$customerid)
        ->where('settlements.IsVoid','=',"0")
        ->whereIn('settlements.stores_id',$selectedstore)
        ->get();

        $getcountsales = $checkingsales->count();
        $getvoidcountsales = $checkingvoidsales->count();

        $data = settlement::join('customers', 'settlements.customers_id', '=', 'customers.id')
        ->join('stores', 'settlements.stores_id', '=', 'stores.id')
        ->join('statuses', 'settlements.Status', '=', 'statuses.id')
        ->where('settlements.id', $id)
        ->get(['customers.id AS CustomerId','customers.Name AS CustomerName','customers.Code AS CustomerCode','customers.TinNumber AS CustomerTIN','customers.OfficePhone','customers.PhoneNumber','customers.VatNumber AS VAT','customers.*','stores.Name AS POS','statuses.StatusName',DB::raw("'$datetime' AS CreatedDateTime"),'settlements.*']);
        
        return response()->json(['settlist'=>$data,'count'=>$getcountsales,'vcount'=>$getvoidcountsales,'pricing'=>$pricing,'settpricing'=>$settpricing,'withsett'=>$withsett,'vatsett'=>$vatsett]);       
    }

    public function showSettlementInfoCon($salesid,$settid)
    {
        $status="Confirmed";
        $paymentType="Credit";
        $storeId=null;
        $customerIds=null;
        $createddates=null;
        $expdate=null;
        $settstatus=["0","1"];
       
        $pricing = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(GrandTotal),2),0) AS GrandTotal'),'GrandTotal AS GTotal','SubTotal','Tax','Vat','WitholdAmount','WitholdSetle','VatSetle',DB::raw('DATEDIFF(settlementexpiredate,CURDATE()) AS RemainingDate'))
        ->where('sales.id','=',$salesid)
        ->get();
        
        $withsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(WitholdAmount),2),0) AS WitholdAmount'))
        ->where('sales.id','=',$salesid)
        ->where('sales.WitholdSetle',1)
        ->get();

        $vatsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(Vat),2),0) AS VatAmount'))
        ->where('sales.id','=',$salesid)
        ->where('sales.VatSetle',1)
        ->get();

        $settpricing = DB::table('settlementdetails')
        ->join('settlements', 'settlementdetails.settlements_id', '=', 'settlements.id')
        ->select(DB::raw('COALESCE(ROUND(SUM(settlementdetails.SettlementAmount),2),0) AS SettlementAmount'))
        ->where('settlements.IsVoid','=',"0")
        ->where('settlementdetails.sales_id','=',$salesid)
        ->where('settlementdetails.settlements_id','!=',$settid)
        ->get();

        $crSales=DB::select('SELECT sales.StoreId,sales.CustomerId,sales.CreatedDate,sales.settlementexpiredate FROM sales WHERE sales.id='.$salesid); 
        foreach($crSales as $row){
            $storeId=$row->StoreId;
            $customerIds=$row->CustomerId;
            $createddates=$row->CreatedDate;
            $expdate=$row->settlementexpiredate;
        }
        $checkingsales = DB::table('sales')
        ->select('sales.setlmentstatus')
        ->where('sales.id','<',$salesid)
        ->whereIn('sales.setlmentstatus',$settstatus)
        ->where('sales.StoreId','=',$storeId)
        ->where('sales.CustomerId','=',$customerIds)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->get();

        $getcountsales = $checkingsales->count();

        return response()->json(['pricing'=>$pricing,'settpricing'=>$settpricing,'withsett'=>$withsett,'vatsett'=>$vatsett,'countsales'=>$getcountsales,'createddates'=>$createddates,'expdate'=>$expdate]);
    }

    public function getSalesDocNumber(Request $request, $id,$cusid){
        $settdate=$request->date;
        $settlementidval=$request->settlementId;
        $paymentType="Credit";
        $status="Confirmed";
        $settstatus=["0","1"];
        $ststatus=["1","2"];
        $allsalesids=[];
        $createddateval="";
        $maxdatesel="";
        $firstsales=0;

        if($settdate==null){
            $settdate=Carbon::today()->toDateString();
        }
        if($settlementidval==null){
            $settlementidval=0;
            $checkingsales = DB::table('settlements')
            ->select('settlements.id')
            ->where('settlements.stores_id','=',$id)
            ->where('settlements.customers_id','=',$cusid)
            ->where('settlements.IsVoid',0)
            ->get();
            $getcountsales = $checkingsales->count();

            if($getcountsales==0){
                $getsalesdate=Sales::where('sales.StoreId', $id)
                ->where('sales.CustomerId', $cusid)
                ->where('sales.PaymentType','=',$paymentType)
                ->where('sales.Status','=',$status)
                ->orderBy('sales.CreatedDate','asc')
                ->skip(0)
                ->take(1)
                ->get();
            }
            
            if($getcountsales>0){
                $getsalesdate=settlement::where('settlements.stores_id', $id)
                ->where('settlements.customers_id', $cusid)
                ->where('settlements.IsVoid',0)
                ->orderBy('settlements.DocumentDate','desc')
                ->skip(0)
                ->take(1)
                ->get(['settlements.DocumentDate AS CreatedDate']);
            }
            $maxdatesel=Carbon::today()->toDateString();
        }
        if($settlementidval!=null){
            $checkingsales = DB::table('settlements')
            ->select('settlements.id')
            ->where('settlements.stores_id','=',$id)
            ->where('settlements.customers_id','=',$cusid)
            ->where('settlements.id','<',$settlementidval)
            ->where('settlements.IsVoid',0)
            ->get();

            $checkingnextsett = DB::table('settlements')
            ->select('settlements.id')
            ->where('settlements.stores_id','=',$id)
            ->where('settlements.customers_id','=',$cusid)
            ->where('settlements.id','>',$settlementidval)
            ->where('settlements.IsVoid',0)
            ->get();

            $getcountsales = $checkingsales->count();
            $getsettcount = $checkingnextsett->count();

            if($getcountsales==0){
                $getsalesdate=Sales::where('sales.StoreId', $id)
                ->where('sales.CustomerId', $cusid)
                ->where('sales.PaymentType','=',$paymentType)
                ->where('sales.Status','=',$status)
                ->orderBy('sales.CreatedDate','asc')
                ->skip(0)
                ->take(1)
                ->get();
            }
            if($getcountsales>0){
                $getsalesdate=settlement::where('settlements.stores_id', $id)
                ->where('settlements.customers_id', $cusid)
                ->where('settlements.id','!=',$settlementidval)
                ->where('settlements.IsVoid',0)
                ->orderBy('settlements.DocumentDate','desc')
                ->skip(0)
                ->take(1)
                ->get(['settlements.DocumentDate AS CreatedDate']);
            }
            if($getsettcount==0){
                $maxdatesel=Carbon::today()->toDateString();
            }
            if($getsettcount>0){
                $getmaxsettlment=settlement::where('settlements.stores_id', $id)
                ->where('settlements.customers_id', $cusid)
                ->where('settlements.id','>',$settlementidval)
                ->where('settlements.IsVoid',0)
                ->orderBy('settlements.DocumentDate','asc')
                ->skip(0)
                ->take(1)
                ->get(['settlements.DocumentDate AS CreatedDate']);
                foreach ($getmaxsettlment as $rows) {
                    $maxdatesel=$rows->CreatedDate;
                }
            }

            $getfirstsales=settlementdetail::where('settlementdetails.settlements_id', $settlementidval)
            ->orderBy('settlementdetails.id','asc')
            ->skip(0)
            ->take(1)
            ->get(['settlementdetails.sales_id']);
            foreach ($getfirstsales as $rows) {
                $firstsales=$rows->sales_id;
            }
           
        }
        $salesids=Sales::where('sales.StoreId', $id)
        ->where('sales.CustomerId', $cusid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->where('sales.CreatedDate','<=',$settdate)
        ->whereIn('sales.setlmentstatus',$settstatus)
        ->get(['sales.id']);
        foreach ($salesids as $row) {
            $allsalesids[] = $row->id;
        }

        $pricing = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(GrandTotal),2),0) AS GrandTotal'))
        ->where('sales.StoreId', $id)
        ->where('sales.CustomerId', $cusid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.setlmentstatus',$settstatus)
        ->get();
        
        $withsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(WitholdAmount),2),0) AS WitholdAmount'))
        ->where('sales.StoreId', $id)
        ->where('sales.CustomerId', $cusid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.setlmentstatus',$settstatus)
        ->where('sales.WitholdSetle',1)
        ->get();

        $vatsett = DB::table('sales')
        ->select(DB::raw('COALESCE(ROUND(SUM(Vat),2),0) AS VatAmount'))
        ->where('sales.StoreId', $id)
        ->where('sales.CustomerId', $cusid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.setlmentstatus',$settstatus)
        ->where('sales.VatSetle',1)
        ->get();

        $settpricing = DB::table('settlementdetails')
        ->join('settlements', 'settlementdetails.settlements_id', '=', 'settlements.id')
        ->select(DB::raw('COALESCE(ROUND(SUM(settlementdetails.SettlementAmount),2),0) AS SettlementAmount'))
        ->where('settlements.IsVoid','=',"0")
        ->whereIn('settlementdetails.sales_id',$allsalesids)
        ->get();

        $settlementdetailval = DB::table('settlementdetails')
        ->join('settlements', 'settlementdetails.settlements_id', '=', 'settlements.id')
        ->select('settlementdetails.sales_id','settlementdetails.PaymentType','settlementdetails.BankName','settlementdetails.ChequeNumber','settlementdetails.BankTransferNumber')
        ->where('settlements.IsVoid','=',"0")
        ->get();

        $customerdata = DB::table('customers')
        ->select('customers.*')
        ->where('customers.id',$cusid)
        ->get();

        $data = Sales::join('customers', 'sales.CustomerId', '=', 'customers.id')
        ->where('sales.StoreId', $id)
        ->where('sales.CustomerId', $cusid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->whereIn('sales.setlmentstatus',$settstatus)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->orderBy('sales.CreatedDate','asc')
        ->distinct()
        ->get(['sales.id AS SalesId','sales.VoucherNumber',DB::raw('IFNULL(sales.invoiceNo,"") AS invoiceNo'),'customers.*']);
        
        $sleditdata = Sales::join('customers', 'sales.CustomerId', '=', 'customers.id')
        ->where('sales.StoreId', $id)
        ->where('sales.CustomerId', $cusid)
        ->where('sales.PaymentType','=',$paymentType)
        ->where('sales.Status','=',$status)
        ->where('sales.id','>=',$firstsales)
        ->where('sales.CreatedDate','>=',"2024-02-01")
        ->orderBy('sales.CreatedDate','asc')
        ->distinct()
        ->get(['sales.id AS SalesId','sales.VoucherNumber',DB::raw('IFNULL(sales.invoiceNo,"") AS invoiceNo'),'customers.*']);

        return response()->json(['saleslist'=>$data,'saleslisted'=>$sleditdata,'cusdata'=>$customerdata,'crdate'=>$getsalesdate,'pricing'=>$pricing,'settpricing'=>$settpricing,'withsett'=>$withsett,'vatsett'=>$vatsett,'settdetails'=>$settlementdetailval,'maxdatesel'=>$maxdatesel]);       
    }

    public function showDetailCreditSalesCon($id)
    {
        $HeaderId=$id;
        $columnName="HeaderId";
        $detailTable=DB::select('SELECT sales.id,customers.Code,customers.CustomerCategory,customers.Name,customers.TinNumber,customers.VatType,customers.Witholding,sales.PaymentType,sales.VoucherType,sales.VoucherNumber,sales.CustomerMRC,sales.Vat,sales.WitholdAmount,sales.GrandTotal AS SubTotal,stores.Name as StoreName,sales.CreatedDate,sales.Status FROM sales INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status="Confirmed" AND sales.PaymentType="Credit" AND sales.CustomerId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                $btn='<div class="btn-group dropleft">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item settlementSalesBtn" data-id="'.$data->id.'" data-toggle="modal" id="dtinfobtn" title="">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showSettledListCon($id)
    {
        $HeaderId=$id;
        $columnName="HeaderId";
        $detailTable=DB::select('SELECT * FROM settlement WHERE settlement.CustomerId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                $user=Auth()->user();
                $settedit='';
                $settvoid='';
                if($data->IsVoid=='0')
                {
                    if($user->can('Settlement-Edit'))
                    {
                        $settedit='<a class="dropdown-item settlementEditBtn" data-id="'.$data->id.'" data-toggle="modal" id="smallButton" data-target="#examplemodal-edit" title="Edit">
                        <i class="fa fa-edit"></i><span> Edit</span>  
                        </a>';
                    }
                    if($user->can('Settlement-Void'))
                    {
                        $settvoid='<a class="dropdown-item settlementVoidBtn" data-id="'.$data->id.'" data-status="" data-toggle="modal" id="smallButton" data-attr="" title="Void Record">
                        <i class="fa fa-trash"></i><span> Void</span>  
                        </a>';
                    }
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item settlementSingleBtn" data-id="'.$data->id.'" data-toggle="modal" id="dtinfobtn" title="">
                        <i class="fa fa-info"></i><span> Info</span>  
                    </a>
                    '.$settedit.'
                    '.$settvoid.'
                    
                </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showDetailTransactionCon($id)
    {
        $HeaderId=$id;
        $columnName="HeaderId";
        $detailTable=DB::select('SELECT sales.id,CAST(sales.PaymentType AS NCHAR) AS PaymentType,sales.VoucherType,sales.VoucherNumber,stores.Name AS Shop,sales.CustomerMRC,"" AS CrvNumber,"" AS BankName,"" AS ChequeNumber,CAST(sales.CreatedDate AS DATE) AS TrDate,TRUNCATE(sales.GrandTotal,2) AS Subtotal,"" AS SettlementAmount,"Sales" AS Type,"2" AS IsVoid FROM sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.CustomerId='.$id.' UNION ALL
        SELECT settlement.id,CAST(settlement.PaymentType AS NCHAR) AS PaymentType,"" AS VoucherType,"" AS VoucherNumber,"" AS Shop,"" AS CustomerMRC,settlement.CrvNumber,settlement.BankName,settlement.ChequeNumber,CAST(settlement.TransactionDate AS DATE) AS TrDate,"" AS Subtotal,TRUNCATE(settlement.SettlementAmount,2),"Settlement" AS Type,settlement.IsVoid AS IsVoid FROM settlement WHERE settlement.CustomerId='.$id.' ORDER BY TrDate ASC,id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                //  $btn = ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                //  return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showDocinformations($pos,$cus)
    {
        $detailTable=DB::select('SELECT sales.id,stores.Name AS POS,sales.VoucherNumber,sales.invoiceNo,sales.CreatedDate,sales.settlementexpiredate,DATEDIFF(sales.settlementexpiredate,CURDATE()) AS RemainingDate,(SELECT GROUP_CONCAT(DISTINCT(IFNULL(settlements.CrvNumber,""))," ") FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.sales_id=sales.id AND settlements.IsVoid=0) AS CRVNumbers,
        @witholdamount:=0,
        @vatamount:=0,
        @vatsett:=sales.VatSetle,
        @withsett:=sales.WitholdSetle,
        IF(@withsett=1,@witholdamount:=sales.WitholdAmount,@witholdamount:=0),
        IF(@vatsett=1,@vatamount:=sales.Vat,@vatamount:=0),
        @crssales:=(sales.GrandTotal-@witholdamount-@vatamount) AS CreditSales,
        @settledamount:=(SELECT SUM(settlementdetails.SettlementAmount) FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.sales_id=sales.id AND settlements.IsVoid=0) AS SettledAmounts,if(@settledamount is null,@crssales,@crssales-@settledamount) AS OustandingBalance,sales.Status,CASE WHEN sales.setlmentstatus=0 THEN "Not-Paid" WHEN sales.setlmentstatus=1 THEN "Partially-Paid" WHEN sales.setlmentstatus=2 THEN "Fully-Paid" END AS PaymentStatus,sales.setlmentstatus FROM sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status IN("pending..","Checked","Confirmed") AND sales.PaymentType="Credit" AND sales.CustomerId='.$cus.' AND sales.StoreId='.$pos.' ORDER BY sales.CreatedDate ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            //  $btn = ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
            //  return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showdetailtransactions($id)
    {
        $detailTable=DB::select('SELECT settlementdetails.id,
		@witholdamount:=0,
        @vatamount:=0,
        @outstanding:=0,
        @vatsett:=sales.VatSetle,
        @withsett:=sales.WitholdSetle,
        IF(@withsett=1,@witholdamount:=sales.WitholdAmount,@witholdamount:=0),
        IF(@vatsett=1,@vatamount:=sales.Vat,@vatamount:=0),
        @crssales:=(sales.GrandTotal-@witholdamount-@vatamount) AS CreditSales,
        @previoussettled:=(SELECT COALESCE(ROUND(SUM(settlementdetails.SettlementAmount),2),0) AS SettlementAmount FROM settlementdetails INNER JOIN settlements AS sett ON settlementdetails.settlements_id=sett.id WHERE settlementdetails.sales_id=sales.id AND settlementdetails.settlements_id<settlements.id AND sett.Status=3),
        @currentsettled:=(SELECT COALESCE(ROUND(SUM(settlementdetails.SettlementAmount),2),0) AS SettlementAmount FROM settlementdetails INNER JOIN settlements AS sett ON settlementdetails.settlements_id=sett.id WHERE settlementdetails.sales_id=sales.id AND settlementdetails.settlements_id=settlements.id AND sett.Status=3),
        @outstandingbalance:=@crssales-@previoussettled-@currentsettled AS OutstandingBalance,
        CONCAT("Doc/ FS #:	",sales.VoucherNumber,"	            |       	Invoice/ Ref #:	 ",IFNULL(sales.invoiceNo,""),"	            bl           	Credit Sales:		",FORMAT(@crssales,2),"		|		Previous Settled Amount:	",FORMAT(@previoussettled,2),"		|		Current Settled Amount:		",FORMAT(@currentsettled,2),"		|		Outstanding Amount:		",FORMAT(@outstandingbalance,2),"	            bl           	Sales Doc. Date:		",sales.CreatedDate,"	            |           	Invoice Payment Status:		",CASE WHEN @crssales=@outstandingbalance THEN "Not-Settled" WHEN @crssales!=@outstandingbalance AND @outstandingbalance>0 THEN "Partially-Settled" WHEN @outstandingbalance=0 THEN "Settled." END) AS TotalGroup,sales.VoucherNumber AS FSNumber,sales.invoiceNo AS InvoiceNumber,DATEDIFF(sales.settlementexpiredate,settlements.DocumentDate) AS RemainingDate,settlementdetails.PaymentType,banks.BankName,bankdetails.AccountNumber,settlementdetails.Remark,settlementdetails.ChequeNumber,settlementdetails.BankTransferNumber,settlementdetails.SettlementAmount,CASE WHEN settlementdetails.SettlementStatus=0 THEN "Not-Paid" WHEN settlementdetails.SettlementStatus=1 THEN "Partially-Paid" WHEN settlementdetails.SettlementStatus=2 THEN "Fully-Paid" END AS SettStatus,settlementdetails.SettlementStatus,sales.fiscalyear,sales.CreatedDate FROM settlementdetails INNER JOIN sales ON settlementdetails.sales_id=sales.id INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id INNER JOIN banks ON settlementdetails.banks_id=banks.id INNER JOIN bankdetails ON settlementdetails.bankdetails_id=bankdetails.id WHERE settlementdetails.settlements_id='.$id.' ORDER BY settlementdetails.id ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            //  $btn = ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
            //  return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }


    public function showcustomersettlement($id)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();

        $detailTable=DB::select('SELECT sales.id,stores.Name AS POS,sales.VoucherNumber,sales.invoiceNo,sales.CreatedDate,sales.StoreId,sales.settlementexpiredate,fiscalyear.Monthrange,DATEDIFF(sales.settlementexpiredate,CURDATE()) AS RemainingDate,(SELECT IFNULL(GROUP_CONCAT(DISTINCT(settlements.CrvNumber)," "),"") FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.sales_id=sales.id AND settlements.IsVoid=0 AND settlements.Status=3) AS CRVNumbers,
        @witholdamount:=0,
        @vatamount:=0,
        @outstanding:=0,
        @vatsett:=sales.VatSetle,
        @withsett:=sales.WitholdSetle,
        IF(@withsett=1,@witholdamount:=sales.WitholdAmount,@witholdamount:=0),
        IF(@vatsett=1,@vatamount:=sales.Vat,@vatamount:=0),
        @crssales:=(sales.GrandTotal-@witholdamount-@vatamount) AS CreditSales,
        @settledamount:=(SELECT SUM(settlementdetails.SettlementAmount) FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.sales_id=sales.id AND settlements.IsVoid=0 AND settlements.Status=3) AS SettledAmounts,if(@settledamount is null,@crssales,@crssales-@settledamount) AS OustandingBalance,@outstanding:=@crssales-@settledamount,sales.Status,CASE WHEN @settledamount is null OR @settledamount=0 THEN "Not-Paid" WHEN @settledamount>0 AND @outstanding!=0 THEN "Partially-Paid" WHEN @settledamount>0 AND @outstanding=0 THEN "Fully-Paid" END AS PaymentStatus,sales.setlmentstatus,@crssales-@settledamount FROM sales INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN fiscalyear ON sales.fiscalyear=fiscalyear.FiscalYear WHERE sales.PaymentType="Credit" AND sales.CustomerId='.$id.' AND sales.CreatedDate>="2024-02-01" AND sales.Status="Confirmed" ORDER BY POS ASC,sales.CreatedDate ASC');

        // $detailTable=DB::select('SELECT sales.id,stores.Name AS POS,sales.VoucherNumber,sales.fiscalyear,fiscalyear.Monthrange,sales.invoiceNo,sales.CreatedDate,sales.settlementexpiredate,DATEDIFF(sales.settlementexpiredate,CURDATE()) AS RemainingDate,settlements.CrvNumber,settlements.DocumentDate,
        // @witholdamount:=0,
        // @vatamount:=0,
        // @outstanding:=0,
        // @vatsett:=sales.VatSetle,
        // @withsett:=sales.WitholdSetle,
        // IF(@withsett=1,@witholdamount:=sales.WitholdAmount,@witholdamount:=0),
        // IF(@vatsett=1,@vatamount:=sales.Vat,@vatamount:=0),
        // @crssales:=(sales.GrandTotal-@witholdamount-@vatamount) AS CreditSales,
        // @settledamounttotal:=(SELECT SUM(settlementdetails.SettlementAmount) FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlements.IsVoid=0 AND settlements.Status=3 AND settlements.customers_id=customers.id AND settlementdetails.sales_id=sales.id) AS SettledAmountTotal,
        // @settledamount:=(SELECT SUM(settlementdetails.SettlementAmount) FROM settlementdetails WHERE settlements.IsVoid=0 AND settlementdetails.settlements_id=settlements.id AND settlements.Status=3 AND settlements.customers_id=customers.id AND settlementdetails.sales_id=sales.id) AS SettledAmounts,
        // IF(@settledamount IS NULL,@crssales,@crssales-@settledamounttotal) AS OustandingBalance,@outstanding:=@crssales-@settledamounttotal,@outst:=@crssales-@settledamount,sales.Status,CASE WHEN @settledamount IS NULL OR @settledamount=0 THEN "Not-Paid" WHEN @settledamount>0 AND @outst>0 THEN "Partially-Paid" WHEN @settledamount>0 AND @outst=0 THEN "Fully-Paid" END AS PaymentStatus,sales.setlmentstatus,@crssales-@settledamount,
        // CONCAT("div Doc/ FS # : ",IFNULL(sales.VoucherNumber,""),"	|  Invoice/ Ref # : ",IFNULL(sales.invoiceNo,""),"	divend divs | 	Sales Doc Date : ",sales.CreatedDate,"	| 	Due Date : ",IFNULL(sales.settlementexpiredate,"")," bl  Credit Sales : ",FORMAT(@crssales,2)," |	Settled Amount  :  ",FORMAT(@settledamounttotal,2),"	|	Outstanding Amount  :  ",FORMAT(@outstanding,2)," bl   Payment Status : ",CASE WHEN sales.setlmentstatus=0 THEN "Not-Paid" WHEN sales.setlmentstatus=1 THEN "Partially-Paid" WHEN sales.setlmentstatus=2 THEN "Fully-Paid" END," divsend") AS SalesProp
        // FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id INNER JOIN sales ON settlementdetails.sales_id=sales.id INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN customers ON settlements.customers_id=customers.id INNER JOIN fiscalyear ON sales.fiscalyear=fiscalyear.Monthrange WHERE sales.PaymentType="Credit" AND sales.CustomerId='.$id.' AND sales.Status="Confirmed" AND settlements.IsVoid=0 AND settlements.Status=3 ORDER BY POS ASC,sales.CreatedDate ASC');

        // $detailTable=DB::select('SELECT sales.id,stores.Name AS POS,sales.VoucherNumber,sales.fiscalyear,fiscalyear.Monthrange,sales.invoiceNo,sales.CreatedDate,sales.settlementexpiredate,DATEDIFF(sales.settlementexpiredate,CURDATE()) AS RemainingDate,(SELECT GROUP_CONCAT(DISTINCT(settlements.CrvNumber)," ") FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.sales_id=sales.id AND settlements.IsVoid=0 AND settlements.Status=3) AS CRVNumbers,
        // @witholdamount:=0,
        // @vatamount:=0,
        // @outstanding:=0,
        // @vatsett:=sales.VatSetle,
        // @withsett:=sales.WitholdSetle,
        // IF(@withsett=1,@witholdamount:=sales.WitholdAmount,@witholdamount:=0),
        // IF(@vatsett=1,@vatamount:=sales.Vat,@vatamount:=0),
        // @crssales:=(sales.GrandTotal-@witholdamount-@vatamount) AS CreditSales,
        // @settledamount:=(SELECT SUM(settlementdetails.SettlementAmount) FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.sales_id=sales.id AND settlements.IsVoid=0 AND settlements.Status=3) AS SettledAmounts,if(@settledamount is null,@crssales,@crssales-@settledamount) AS OustandingBalance,@outstanding:=@crssales-@settledamount,sales.Status,CASE WHEN @settledamount is null OR @settledamount=0 THEN "Not-Paid" WHEN @settledamount>0 AND @outstanding!=0 THEN "Partially-Paid" WHEN @settledamount>0 AND @outstanding=0 THEN "Fully-Paid" END AS PaymentStatus,sales.setlmentstatus,@crssales-@settledamount FROM sales INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN fiscalyear ON sales.fiscalyear=fiscalyear.Monthrange WHERE sales.PaymentType="Credit" AND sales.CustomerId='.$id.' AND sales.Status="Confirmed" ORDER BY POS ASC,sales.CreatedDate ASC');


        // $detailTable=DB::select('SELECT stores.Name AS POS,sales.CreatedDate AS CrDate,@creditsales:=(SELECT 
        // CASE WHEN sales.WitholdSetle=1 AND sales.VatSetle=1 THEN
        // COALESCE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount)-SUM(sales.Vat),0) 
        // WHEN sales.WitholdSetle=1 AND (sales.VatSetle=0 OR sales.VatSetle IS NULL) THEN COALESCE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount),0) WHEN sales.VatSetle=1 AND (sales.WitholdSetle=0 OR sales.WitholdSetle IS NULL) THEN
        // COALESCE(SUM(sales.GrandTotal)-SUM(sales.Vat),0) WHEN (sales.VatSetle=0 OR sales.VatSetle IS NULL) AND (sales.WitholdSetle=0 OR sales.WitholdSetle IS NULL) THEN COALESCE(SUM(sales.GrandTotal),0) END
        // FROM sales WHERE sales.CustomerId=customers.id AND sales.id=settlementdetails.sales_id AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=4)) AS NetPay,settlementdetails.SettlementAmount AS SettledAmounts,settlementdetails.sales_id,sales.VoucherNumber,settlements.CrvNumber,sales.invoiceNo,settlementdetails.PaymentType,settlementdetails.BankName,settlementdetails.ChequeNumber,settlementdetails.BankTransferNumber,settlements.SettledBy,settlements.DocumentDate,CASE WHEN settlementdetails.SettlementStatus=0 THEN "Not-Paid" WHEN settlementdetails.SettlementStatus=1 THEN "Partially-Paid" WHEN settlementdetails.SettlementStatus=2 THEN "Fully-Paid" END AS PaymentStatus,"Settlement",DATEDIFF(settlementexpiredate,settlements.DocumentDate) AS RemainingDate,sales.setlmentstatus,settlements.IsVoid,IF(settlements.IsVoid=0,"0",settlementdetails.SettlementAmount) AS VoidVal FROM settlementdetails INNER JOIN sales ON settlementdetails.sales_id=sales.id INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id INNER JOIN customers ON settlements.customers_id=customers.id INNER JOIN stores ON settlements.stores_id=stores.id WHERE settlements.customers_id='.$id.' AND settlements.Status=3 AND sales.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=4)
        // ORDER BY POS ASC,CrDate ASC');

        // $detailTable=DB::select('SELECT stores.Name AS POS,sales.CreatedDate AS CrDate,@creditsales:=(SELECT 
        // CASE WHEN sales.WitholdSetle=1 AND sales.VatSetle=1 THEN
        // COALESCE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount)-SUM(sales.Vat),0) 
        // WHEN sales.WitholdSetle=1 AND (sales.VatSetle=0 OR sales.VatSetle IS NULL) THEN COALESCE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount),0) WHEN sales.VatSetle=1 AND (sales.WitholdSetle=0 OR sales.WitholdSetle IS NULL) THEN
        // COALESCE(SUM(sales.GrandTotal)-SUM(sales.Vat),0) WHEN (sales.VatSetle=0 OR sales.VatSetle IS NULL) AND (sales.WitholdSetle=0 OR sales.WitholdSetle IS NULL) THEN COALESCE(SUM(sales.GrandTotal),0) END
        // FROM sales WHERE sales.CustomerId=customers.id AND sales.id=settlementdetails.sales_id AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=4)) AS NetPay,settlementdetails.SettlementAmount AS SettledAmounts,settlementdetails.sales_id,sales.VoucherNumber,settlements.CrvNumber,sales.invoiceNo,settlementdetails.PaymentType,settlementdetails.BankName,settlementdetails.ChequeNumber,settlementdetails.BankTransferNumber,settlements.SettledBy,settlements.DocumentDate,CASE WHEN settlementdetails.SettlementStatus=0 THEN "Not-Paid" WHEN settlementdetails.SettlementStatus=1 THEN "Partially-Paid" WHEN settlementdetails.SettlementStatus=2 THEN "Fully-Paid" END AS PaymentStatus,"Settlement",DATEDIFF(settlementexpiredate,settlements.DocumentDate) AS RemainingDate,sales.setlmentstatus,settlements.IsVoid,IF(settlements.IsVoid=0,"0",settlementdetails.SettlementAmount) AS VoidVal FROM settlementdetails INNER JOIN sales ON settlementdetails.sales_id=sales.id INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id INNER JOIN customers ON settlements.customers_id=customers.id INNER JOIN stores ON settlements.stores_id=stores.id WHERE settlements.customers_id='.$id.' AND settlements.Status=3 AND sales.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=4)
        // UNION
        // SELECT  stores.Name AS POS,sl.CreatedDate AS CrDate,@creditsales:=(SELECT 
        // CASE WHEN sales.WitholdSetle=1 AND sales.VatSetle=1 THEN
        // COALESCE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount)-SUM(sales.Vat),0) 
        // WHEN sales.WitholdSetle=1 AND (sales.VatSetle=0 OR sales.VatSetle IS NULL) THEN COALESCE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount),0) WHEN sales.VatSetle=1 AND (sales.WitholdSetle=0 OR sales.WitholdSetle IS NULL) THEN
        // COALESCE(SUM(sales.GrandTotal)-SUM(sales.Vat),0) WHEN (sales.VatSetle=0 OR sales.VatSetle IS NULL) AND (sales.WitholdSetle=0 OR sales.WitholdSetle IS NULL) THEN COALESCE(SUM(sales.GrandTotal),0) END
        // FROM sales WHERE sales.CustomerId=customers.id AND sales.PaymentType="Credit" AND sales.Status="Confirmed" AND sales.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=4) AND sales.id NOT IN(SELECT settlementdetails.sales_id FROM settlementdetails) AND sales.id=sl.id) AS NetPay,"0",
        // sl.id,sl.VoucherNumber,sl.invoiceNo,"","","","","","","",CASE WHEN sl.setlmentstatus=0 THEN "Not-Paid" WHEN sl.setlmentstatus=1 THEN "Partially-Paid" WHEN sl.setlmentstatus=2 THEN "Fully-Paid" END AS PaymentStatus,"Sales",DATEDIFF(sl.settlementexpiredate,CURDATE()) AS RemainingDate,sl.setlmentstatus,"","0" FROM sales sl INNER JOIN customers ON sl.CustomerId=customers.id INNER JOIN stores ON sl.StoreId=stores.id WHERE sl.CustomerId='.$id.' AND sl.id NOT IN(SELECT settlementdetails.sales_id FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlements.Status=3) AND sl.PaymentType="Credit" AND sl.Status="Confirmed" AND sl.StoreId IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=4) ORDER BY POS ASC,CrDate ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                //  $btn = ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                //  return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showsalesinfo($vnum,$stid)
    {
        $salesinfo = DB::table('sales')
            ->join('stores','stores.id','=','sales.StoreId')
            ->join('fiscalyear','fiscalyear.FiscalYear','=','sales.fiscalyear')
            ->select('sales.VoucherNumber',DB::raw('IFNULL(sales.invoiceNo,"") AS invoiceNo'),'sales.CreatedDate','sales.settlementexpiredate','stores.Name AS POS','fiscalyear.Monthrange',
            DB::raw('CASE WHEN sales.setlmentstatus=0 THEN "Not-Settled" WHEN sales.setlmentstatus=1 THEN "Partially-Settled" WHEN sales.setlmentstatus=2 THEN "Settled" END AS PaymentStatus'),'sales.setlmentstatus',
            DB::raw('@witholdamount:=0,@vatamount:=0,@vatsett:=sales.VatSetle,@withsett:=sales.WitholdSetle,IF(@withsett=1,@witholdamount:=sales.WitholdAmount,@witholdamount:=0),IF(@vatsett=1,@vatamount:=sales.Vat,@vatamount:=0)'),
            DB::raw('(sales.GrandTotal-@witholdamount-@vatamount) AS CreditSales'))
            ->where('VoucherNumber','=',$vnum)
            ->where('StoreId','=',$stid)
            ->get();
        return Response::json(['salesinfo'=>$salesinfo]);
    }

    public function showcrvdetaildata($vnum,$stid)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();

        $detailTable=DB::select('SELECT settlements.CrvNumber,settlements.DocumentDate,
        @witholdamount:=0,
        @vatamount:=0,
        @outstanding:=0,
        @vatsett:=sales.VatSetle,
        @withsett:=sales.WitholdSetle,
        IF(@withsett=1,@witholdamount:=sales.WitholdAmount,@witholdamount:=0),
        IF(@vatsett=1,@vatamount:=sales.Vat,@vatamount:=0),
        @crssales:=(sales.GrandTotal-@witholdamount-@vatamount) AS CreditSales,
        @settledamounttotal:=(SELECT COALESCE(SUM(settlementdetails.SettlementAmount),0) FROM settlementdetails WHERE settlements.IsVoid=0 AND settlements.Status=3 AND settlementdetails.sales_id=sales.id AND settlementdetails.settlements_id=settlements.id) AS SettledAmountTotal,
        settlementdetails.*,CASE WHEN settlementdetails.SettlementStatus=0 THEN "Not-Paid" WHEN settlementdetails.SettlementStatus=1 THEN "Partially-Paid" WHEN settlementdetails.SettlementStatus=2 THEN "Fully-Paid" END AS SettlementPaymentStatus,CONCAT("bl CRV # : 	",settlements.CrvNumber,"	|	CRV Date :	",settlements.DocumentDate,"	|	CRV Payment Status :	",CASE WHEN @settledamounttotal=0 THEN "Not-Paid" WHEN @settledamounttotal>0 AND @crssales!=@settledamounttotal THEN "Partially-Paid" WHEN @crssales=@settledamounttotal THEN " Fully-Paid" END," ble bln Total of : ",settlements.CrvNumber," blne") AS CRVInfo FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id INNER JOIN sales ON settlementdetails.sales_id=sales.id WHERE settlements.Status IN(3) AND sales.VoucherNumber="'.$vnum.'" AND sales.StoreId='.$stid.' ORDER BY settlementdetails.id ASC');

        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            //  $btn = ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
            //  return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function settleSalesCon(Request $request)
    {
        $customerId=$request->customerId;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'PaymentType' =>"required",
            'CrvNumber' => ['required','unique:settlement'],
            'date' => ['required','before:now'],
            'SettlementAmount' =>"required",
            'bank' =>"required_if:PaymentType,Cheque",
            'ChequeNumber' => ['nullable','sometimes','required_if:PaymentType,Cheque','unique:settlement'],
        ]);
        if($validator->passes())
        {
            $sett=new settlement;
            $sett->CustomerId=trim($request->input('customerId'));
            $sett->PaymentType=trim($request->input('PaymentType'));
            $sett->CrvNumber=trim($request->input('CrvNumber'));
            $sett->SettlementAmount=trim($request->input('SettlementAmount'));
            $sett->TransactionDate=trim($request->input('date'));
            $sett->ChequeNumber=trim($request->input('ChequeNumber'));
            $sett->BankName=trim($request->input('bank'));
            $sett->Memo=trim($request->input('Memo'));
            $sett->SettledBy=$user;
            $sett->save();

            $crSales=DB::select('SELECT sales.id,customers.Code,customers.CustomerCategory,customers.Name,customers.TinNumber,customers.VatType,customers.Witholding,sales.PaymentType,sales.VoucherType,sales.VoucherNumber,sales.CustomerMRC,sales.Vat,sales.WitholdAmount,sales.SubTotal,stores.Name as StoreName,sales.CreatedDate,sales.Status FROM sales INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.CustomerId='.$customerId); 
            $status="Confirmed";
            $paymentType="Credit";
            $pricing = DB::table('sales')
            ->join('customers','customers.id','=','sales.CustomerId')
            ->select(DB::raw('COALESCE(TRUNCATE(SUM(GrandTotal),2),0) AS SubTotal'))
            ->where('sales.CustomerId','=',$customerId)
            ->where('sales.PaymentType','=',$paymentType)
            ->where('sales.Status','=',$status)
            ->get();
    
            $settpricing = DB::table('settlement')
            ->select(DB::raw('COALESCE(TRUNCATE(SUM(SettlementAmount),2),0) AS SettlementAmount'))
            ->where('CustomerId','=',$customerId)
            ->where('IsVoid','=',"0")
            ->get();

            return Response::json(['success' => '1','crSales'=>$crSales,'pricing'=>$pricing,'settpricing'=>$settpricing]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function settleSalesupdCon(Request $request)
    {
        $customerId=$request->customeredId;
        $findid=$request->settId;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'PaymentType' =>"required",
            'CrvNumber'=>"required|unique:settlement,CrvNumber,$findid",
            'date' => ['required','before:now'],
            'SettlementAmount' =>"required",
            'bank' =>"required_if:PaymentType,Cheque",
            'ChequeNumber' => ['nullable','sometimes','required_if:PaymentType,Cheque','unique:settlement'],
        ]);
        if($validator->passes())
        {
            $sett=settlement::find($findid);
            $sett->PaymentType=trim($request->input('PaymentType'));
            $sett->CrvNumber=trim($request->input('CrvNumber'));
            $sett->SettlementAmount=trim($request->input('SettlementAmount'));
            $sett->TransactionDate=trim($request->input('date'));
            $sett->ChequeNumber=trim($request->input('ChequeNumber'));
            $sett->BankName=trim($request->input('bank'));
            $sett->Memo=trim($request->input('Memo'));
            $sett->save();

            $crSales=DB::select('SELECT sales.id,customers.Code,customers.CustomerCategory,customers.Name,customers.TinNumber,customers.VatType,customers.Witholding,sales.PaymentType,sales.VoucherType,sales.VoucherNumber,sales.CustomerMRC,sales.Vat,sales.WitholdAmount,sales.SubTotal,stores.Name as StoreName,sales.CreatedDate,sales.Status FROM sales INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.CustomerId='.$customerId); 
            $status="Confirmed";
            $paymentType="Credit";
            $pricing = DB::table('sales')
            ->join('customers','customers.id','=','sales.CustomerId')
            ->select(DB::raw('COALESCE(TRUNCATE(SUM(GrandTotal),2),0) AS SubTotal'))
            ->where('sales.CustomerId','=',$customerId)
            ->where('sales.PaymentType','=',$paymentType)
            ->where('sales.Status','=',$status)
            ->get();
    
            $settpricing = DB::table('settlement')
            ->select(DB::raw('COALESCE(TRUNCATE(SUM(SettlementAmount),2),0) AS SettlementAmount'))
            ->where('CustomerId','=',$customerId)
            ->where('IsVoid','=',"0")
            ->get();

            return Response::json(['success' => '1','crSales'=>$crSales,'pricing'=>$pricing,'settpricing'=>$settpricing]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function voidSettlementCon(Request $request)
    {
        $findid=$request->voidid;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $getSettinfo=DB::select('select * from settlement where settlement.id='.$findid);
        foreach($getSettinfo as $row)
        {
            $crvnum=$row->CrvNumber;
            $chqnum=$row->ChequeNumber;
            $customerId=$row->CustomerId;
            $ptype=$row->PaymentType;
        }
        if($ptype=="Cheque")
        {
            $chqnumupd=$chqnum."(Void".$findid.")";
        }
        else if($ptype=="Cash")
        {
            $chqnumupd="";
        }
        $crvnumupd=$crvnum."(Void".$findid.")";
        $validator = Validator::make($request->all(), [
            'Reason' =>"required",
        ]);
        if($validator->passes())
        {
            $sett=settlement::find($findid);
            $sett->VoidReason=trim($request->input('Reason'));
            $sett->VoidBy=$user;
            $sett->VoidDate=Carbon::today()->toDateString();
            $sett->IsVoid=1;
            $sett->CrvNumber=$crvnumupd;
            $sett->ChequeNumber=$chqnumupd;
            $sett->save();

            $crSales=DB::select('SELECT sales.id,customers.Code,customers.CustomerCategory,customers.Name,customers.TinNumber,customers.VatType,customers.Witholding,sales.PaymentType,sales.VoucherType,sales.VoucherNumber,sales.CustomerMRC,sales.Vat,sales.WitholdAmount,sales.SubTotal,stores.Name as StoreName,sales.CreatedDate,sales.Status FROM sales INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.CustomerId='.$customerId); 
            $status="Confirmed";
            $paymentType="Credit";
            $pricing = DB::table('sales')
            ->join('customers','customers.id','=','sales.CustomerId')
            ->select(DB::raw('COALESCE(TRUNCATE(SUM(GrandTotal),2),0) AS SubTotal'))
            ->where('sales.CustomerId','=',$customerId)
            ->where('sales.PaymentType','=',$paymentType)
            ->where('sales.Status','=',$status)
            ->get();
    
            $settpricing = DB::table('settlement')
            ->select(DB::raw('COALESCE(TRUNCATE(SUM(SettlementAmount),2),0) AS SettlementAmount'))
            ->where('CustomerId','=',$customerId)
            ->where('IsVoid','=',"0")
            ->get();

            return Response::json(['success' => '1','crSales'=>$crSales,'pricing'=>$pricing,'settpricing'=>$settpricing]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function editSettlements($id)
    {
        $countitem = DB::table('settlementdetails')->where('settlements_id', '=', $id)
            ->get();
        $getCountItem = $countitem->count();
        $recdata = settlement::find($id);
        $customerid=$recdata->customers_id;
        $statusid=$recdata->Status;
        $storeids=$recdata->stores_id;

        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        $cusdata=customer::find($customerid);
        $custmercategory=$cusdata->CustomerCategory;

        $stvals=status::find($statusid);
        $statusnameval=$stvals->StatusName;

        $checkingsales = DB::table('settlements')
        ->select('settlements.id')
        ->where('settlements.id','>',$id)
        ->where('settlements.stores_id','=',$storeids)
        ->where('settlements.customers_id','=',$customerid)
        ->where('settlements.IsVoid',0)
        ->get();
        $getcountsales = $checkingsales->count();

        $cusname=$cusdata->Name;
        $custin=$cusdata->TinNumber;
        $cuscode=$cusdata->Code;

        $data = settlementdetail::join('settlements', 'settlementdetails.settlements_id', '=', 'settlements.id')
            ->join('sales','settlementdetails.sales_id', '=', 'sales.id')
            ->join('banks','settlementdetails.banks_id', '=', 'banks.id')
            ->join('bankdetails','settlementdetails.bankdetails_id', '=', 'bankdetails.id')
            ->where('settlementdetails.settlements_id', $id)
            ->orderBy('settlementdetails.id','asc')
            ->get(['settlements.*','settlementdetails.*','banks.BankName AS BankNames','bankdetails.AccountNumber','settlementdetails.id AS SettlementDetId','settlementdetails.SubTotal AS STotal','settlementdetails.Tax AS Taxes','settlementdetails.GrandTotal AS GTotal','settlementdetails.WitholdAmount AS WAmount','settlementdetails.Vat AS VAmount','settlementdetails.WitholdSetle AS WSettle','settlementdetails.VatSetle AS VSettle','sales.CreatedDate','sales.id AS SalesId','sales.settlementexpiredate AS SettExpireDate',DB::raw('IFNULL(settlementdetails.Remark,"") AS RemarkData'),DB::raw('IFNULL(sales.VoucherNumber,"") AS VoucherNum'),DB::raw('IFNULL(sales.invoiceNo,"") AS InvNum'),DB::raw('DATEDIFF(sales.settlementexpiredate,settlements.DocumentDate) AS RemainingDate'),
                DB::raw('(select COALESCE(ROUND(SUM(settlementdetails.SettlementAmount),2),0) AS SettlementAmount from settlementdetails inner join settlements on settlementdetails.settlements_id = settlements.id where settlements.IsVoid=0 and settlementdetails.sales_id=sales.id and settlementdetails.settlements_id != '.$id.') AS SettledBalance')
            ]);
        return response()->json(['recData'=>$recdata,'count'=>$getCountItem,'settedit'=>$data,'cuscatdata'=>$custmercategory,'fiscalyr'=>$fiscalyr,'cusname'=>$cusname,'custin'=>$custin,'cuscode'=>$cuscode,'statusnameval'=>$statusnameval,'settcnt'=>$getcountsales]);
    }

    public function getSettlementCon($id)
    {
        $sett=DB::select('select * from settlement where settlement.id='.$id);
        return response()->json(['sett'=>$sett]);       
    }

    public function getSettlementSalesCon($id)
    {
        $salesinfo=DB::select('SELECT sales.id,customers.CustomerCategory,customers.Name,customers.Code,customers.TinNumber,customers.VatNumber,customers.VatType,customers.Witholding,sales.PaymentType,sales.VoucherType,sales.VoucherNumber,sales.CustomerMRC,sales.Vat,sales.WitholdAmount,sales.SubTotal,sales.Tax,sales.GrandTotal,sales.WitholdAmount,sales.Vat,sales.NetPay,stores.Name as StoreName,sales.VoidReason,sales.VoidedBy,sales.VoidedDate,sales.TransactionDate,sales.WitholdAmount,sales.witholdNumber,sales.Username,sales.CheckedBy,sales.CheckedDate,sales.ConfirmedBy,sales.ConfirmedDate,sales.ChangeToPendingBy,sales.ChangeToPendingDate,sales.CreatedDate,sales.RefundBy,sales.RefundDate,sales.UnvoidBy,sales.UnVoidDate,sales.vatNumber,sales.CreatedDate,DATE(sales.created_at) AS CrDate,sales.Status FROM sales INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.id='.$id); 
        return response()->json(['salesinfo'=>$salesinfo]);       
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
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->settlementId;
        $findid=$request->settlementId;
        $salesdate=$request->CreditSalesDate;
        $maxdatev=$request->MaxDate;
        $customerid=$request->Customer;
        $pos=$request->PointOfSales;
        $currentDate=Carbon::today()->toDateString();
        $isdupcheque=0;
        $isdupslipnum=0;
        $chequevalscnt=0;
        $slipvalscnt=0;
        $settdetids=[];
        if($request->row!=null){
            foreach ($request->row as $key => $value){
                $chequecnts=0;
                $slipcnt=0;
                $isdupcheque+=$value['IsDuplicatedChequnum'];
                $isdupslipnum+=$value['IsDuplicateslipnum'];
                $chequenum=$value['ChequeNumber'];
                $slipnumv=$value['BankTransferNumber'];
                $banknamesv=$value['BankName'];
                $paymenttypesv=$value['PaymentType'];
                if($findid!=null)
                {
                    $chequesettlements=DB::select('SELECT COUNT(settlementdetails.ChequeNumber) AS ChequeCount FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.ChequeNumber="'.$chequenum.'" AND settlementdetails.BankName="'.$banknamesv.'" AND settlementdetails.PaymentType="Cheque" AND settlementdetails.settlements_id!='.$findid.' AND settlements.IsVoid=0');
                    $slipnumbers=DB::select('SELECT COUNT(settlementdetails.BankTransferNumber) AS BankTransferCont FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.BankTransferNumber="'.$slipnumv.'" AND settlementdetails.BankName="'.$banknamesv.'" AND settlementdetails.PaymentType="Bank-Transfer" AND settlementdetails.settlements_id!='.$findid.' AND settlements.IsVoid=0');
                }
                if($findid==null)
                {
                    $chequesettlements=DB::select('SELECT COUNT(settlementdetails.ChequeNumber) AS ChequeCount FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.ChequeNumber="'.$chequenum.'" AND settlementdetails.BankName="'.$banknamesv.'" AND settlementdetails.PaymentType="Cheque" AND settlements.IsVoid=0');
                    $slipnumbers=DB::select('SELECT COUNT(settlementdetails.BankTransferNumber) AS BankTransferCont FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.BankTransferNumber="'.$slipnumv.'" AND settlementdetails.BankName="'.$banknamesv.'" AND settlementdetails.PaymentType="Bank-Transfer" AND settlements.IsVoid=0');
                }
                
                foreach ($chequesettlements as $row) {
                    $chequecnts = $row->ChequeCount;
                }
                foreach ($slipnumbers as $row) {
                    $slipcnt = $row->BankTransferCont;
                }

                if($chequecnts>=1){
                    $chequevalscnt+=1;
                }
                if($slipcnt>=1){
                    $slipvalscnt+=1;
                }
            }
        }

        if($findid!=null)
        {
            $settlementdetiallist=settlementdetail::where('settlements_id', $request->settlementId)->get(['id']);
            foreach ($settlementdetiallist as $row) {
                $settdetids[] = $row->id;
            }
            $validator = Validator::make($request->all(), [
                'PointOfSales' => ['required'],
                'Customer' => ['required'],
                'CrvNumber' => ['required',Rule::unique('settlements')->where(function ($query) use($customerid,$pos){
                    return $query->where('IsVoid',0);
                    })->ignore($findid)
                ],
                'date' => 'required|before_or_equal:'.$maxdatev.'|after_or_equal:'.$salesdate.'',
                'Memo' => 'nullable',
            ]);
            $rules=array(
                'row.*.sales_id' => 'required',
                'row.*.RemainingAmount' => 'required',
                'row.*.PaymentType' => 'required',
                'row.*.SettlementAmount' => 'required|lte:row.*.RemainingAmount',
                'row.*.BankName' => 'required',
                'row.*.BankTransferNumber' => 'required',
            );
            $v2= Validator::make($request->all(), $rules);
            if ($validator->passes() && $v2->passes() && $request->row!=null && $isdupcheque==0 && $isdupslipnum==0 && $chequevalscnt==0 && $slipvalscnt==0){
                try
                {
                    $settlement=settlement::updateOrCreate(['id' => $request->settlementId], [
                        'stores_id' => $request->PointOfSales,
                        'customers_id' => $request->Customer,
                        'CrvNumber' => $request->CrvNumber,
                        'DocumentDate' => $request->date,
                        'OutstandingAmount' => $request->totaloutstandingi,
                        'SettlementAmount' => $request->custotalsettledi,
                        'UnSettlementAmount' => $request->custotalunpaidi,
                        'LastEditedBy' =>$user,
                        'LastEditedDate' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                        'Memo' => $request->Memo,
                    ]);
                    $settlistsv=settlementdetail::where('settlements_id', $request->settlementId)->get(['id','SettlementStatus','sales_id']);
                    foreach ($settlistsv as $row) {
                        $vatamountval=0;
                        $witholdamountval=0;
                        $netpayamounts=0;
                        $settlementresults=0;
                        $settlementdetids = $row->id;
                        $salesidsval = $row->sales_id;
                        $setstatus = $row->SettlementStatus;
                        if($setstatus==2){
                            $updatefullysettleds=Sales::where('id',$salesidsval)->update(['setlmentstatus'=>0]);
                        }
                        if($setstatus==1){
                            $updatefullysettleds=Sales::where('id',$salesidsval)->update(['setlmentstatus'=>1]);
                        }
                    }
                    foreach ($request->row as $key => $value){
                        $salesids=$value['sales_id'];
                        $remainingamount=$value['RemainingAmount'];
                        $paymenttype=$value['PaymentType'];
                        $bankname=$value['BankName'];
                        $chequenumber=$value['ChequeNumber'];
                        $slipnumber=$value['BankTransferNumber'];
                        $settledamount=$value['SettlementAmount'];
                        $settlementstatus=$value['SettlementStatus'];
                        $subtotal=$value['SubTotal'];
                        $tax=$value['Tax'];
                        $grandtotal=$value['GrandTotal'];
                        $witholdamount=$value['WitholdAmount'];
                        $vat=$value['Vat'];
                        $witholdsettle=$value['WitholdSetle'];
                        $vatsettle=$value['VatSetle'];
                        $bankid=$value['BankName'];
                        $accnum=$value['AccountNumber'];
                        $remark=$value['Remark'];
                        $settlement->sales()->attach($salesids,
                        ['RemainingAmount'=>$remainingamount,'PaymentType'=>$paymenttype,'banks_id'=>$bankid,'bankdetails_id'=>$accnum,'BankName'=>$bankname,'ChequeNumber'=>$chequenumber,'BankTransferNumber'=>$slipnumber,
                        'SubTotal'=>$subtotal,'Tax'=>$tax,'GrandTotal'=>$grandtotal,'WitholdAmount'=>$witholdamount,'Vat'=>$vat,'WitholdSetle'=>$witholdsettle,'VatSetle'=>$vatsettle,'Remark'=>$remark,
                        'SettlementStatus'=>$settlementstatus,'SettlementAmount'=>$settledamount]);
                        if($remainingamount==$settledamount){
                            $updatefullysettled=Sales::where('id',$salesids)->update(['setlmentstatus'=>2]);
                        }
                        if($remainingamount!=$settledamount){
                            $updatefullysettled=Sales::where('id',$salesids)->update(['setlmentstatus'=>1]);
                        }
                    }
                    settlementdetail::where('settlements_id',$request->settlementId)->whereIn('id',$settdetids)->delete();
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
                return response()->json(['errorv2'=> $v2->errors()->all()]);
            }
            if($request->row==null){
                return Response::json(['emptyerror'=>"error"]);
            }
            if($isdupcheque>=1 || $isdupslipnum>=1){
                return Response::json(['duplicateerr'=>"error"]);
            }
            if($chequevalscnt>=1 || $slipvalscnt>=1){
                return Response::json(['dbduplicateerr'=>"error"]);
            }
        }
        
        if($findid==null)
        {
            $validator = Validator::make($request->all(), [
                'PointOfSales' => ['required'],
                'Customer' => ['required'],
                'CrvNumber' => ['required',Rule::unique('settlements')->where(function ($query) use($customerid,$pos){
                    return $query->where('IsVoid',0);
                    }),
                ],
                'date' => 'required|before_or_equal:'.$maxdatev.'|after_or_equal:'.$salesdate.'',
                'Memo' => 'nullable',
            ]);

            $rules=array(
                'row.*.sales_id' => 'required',
                'row.*.RemainingAmount' => 'required',
                'row.*.PaymentType' => 'required',
                'row.*.SettlementAmount' => 'required|lte:row.*.RemainingAmount',
                'row.*.BankName' => 'required',
                'row.*.BankTransferNumber' => 'required',
            );
            $v2= Validator::make($request->all(), $rules);

            if ($validator->passes() && $v2->passes() && $request->row!=null && $isdupcheque==0 && $isdupslipnum==0 && $chequevalscnt==0 && $slipvalscnt==0){
                try
                {
                    $settlement=settlement::updateOrCreate(['id' => $request->settlementId], [
                        'stores_id' => $request->PointOfSales,
                        'customers_id' => $request->Customer,
                        'CrvNumber' => $request->CrvNumber,
                        'DocumentDate' => $request->date,
                        'OutstandingAmount' => $request->totaloutstandingi,
                        'SettlementAmount' => $request->custotalsettledi,
                        'UnSettlementAmount' => $request->custotalunpaidi,
                        'SettledBy' =>$user,
                        'SettledDate' => $currentDate,
                        'fiscalyear' => $fyear,
                        'Status' => 1,
                        'IsVoid' => 0,
                        'Memo' => $request->Memo,
                    ]);

                    foreach ($request->row as $key => $value){
                        $salesids=$value['sales_id'];
                        $remainingamount=$value['RemainingAmount'];
                        $paymenttype=$value['PaymentType'];
                        $bankname=$value['BankName'];
                        $chequenumber=$value['ChequeNumber'];
                        $slipnumber=$value['BankTransferNumber'];
                        $settledamount=$value['SettlementAmount'];
                        $settlementstatus=$value['SettlementStatus'];
                        $subtotal=$value['SubTotal'];
                        $tax=$value['Tax'];
                        $grandtotal=$value['GrandTotal'];
                        $witholdamount=$value['WitholdAmount'];
                        $vat=$value['Vat'];
                        $witholdsettle=$value['WitholdSetle'];
                        $vatsettle=$value['VatSetle'];
                        $bankid=$value['BankName'];
                        $accnum=$value['AccountNumber'];
                        $remark=$value['Remark'];
                        $settlement->sales()->attach($salesids,
                        ['RemainingAmount'=>$remainingamount,'PaymentType'=>$paymenttype,'banks_id'=>$bankid,'bankdetails_id'=>$accnum,'BankName'=>$bankname,'ChequeNumber'=>$chequenumber,'BankTransferNumber'=>$slipnumber,
                        'SubTotal'=>$subtotal,'Tax'=>$tax,'GrandTotal'=>$grandtotal,'WitholdAmount'=>$witholdamount,'Vat'=>$vat,'WitholdSetle'=>$witholdsettle,'VatSetle'=>$vatsettle,'Remark'=>$remark,
                        'SettlementStatus'=>$settlementstatus,'SettlementAmount'=>$settledamount]);
                        if($remainingamount==$settledamount){
                            $updatefullysettled=Sales::where('id',$salesids)->update(['setlmentstatus'=>2]);
                        }
                        if($remainingamount!=$settledamount){
                            $updatefullysettled=Sales::where('id',$salesids)->update(['setlmentstatus'=>1]);
                        }
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
                return response()->json(['errorv2'=> $v2->errors()->all()]);
            }
            if($request->row==null){
                return Response::json(['emptyerror'=>"error"]);
            }
            if($isdupcheque>=1 || $isdupslipnum>=1){
                return Response::json(['duplicateerr'=>"error"]);
            }
            if($chequevalscnt>=1 || $slipvalscnt>=1){
                return Response::json(['dbduplicateerr'=>"error"]);
            }
        }
    }

    public function updateVerified(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->checkedid;
        $sett=settlement::find($findid);
        $sett->VerifiedBy= $user;
        $sett->VerifiedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $sett->Status=2;
        $sett->save();
        return Response::json(['success' => '1']);  
    }

    public function updateSettPending(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->pendingid;
        $sett=settlement::find($findid);
        $sett->ChangeToPendingBy= $user;
        $sett->ChangeToPendingDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $sett->Status=1;
        $sett->save();
        return Response::json(['success' => '1']);  
    }

    public function updateSettConfirmed(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->confirmid;
        $sett=settlement::find($findid);
        $sett->ConfirmedBy= $user;
        $sett->ConfirmedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $sett->Status=3;
        $sett->save();
        return Response::json(['success' => '1']);  
    }

    public function settlementVoid(Request $request)
    {
        $statusval=null;
        $stval=null;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->voididn;
        $sett=settlement::find($findid);
        $stval=$sett->Status;
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
            $settlistsv=settlementdetail::where('settlements_id', $request->voididn)->get(['id','SettlementStatus','sales_id']);
            foreach ($settlistsv as $row) {
                $cntsales=0;
                $vatamountval=0;
                $witholdamountval=0;
                $netpayamounts=0;
                $settlementresults=0;
                $settlementdetids = $row->id;
                $salesidsval = $row->sales_id;
                $getsalescount=DB::select('SELECT COUNT(settlementdetails.id) AS CountSales FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.sales_id='.$salesidsval.' AND settlements.IsVoid=0');
                foreach($getsalescount as $rows){
                    $cntsales=$rows->CountSales;
                }
                $setstatus = $row->SettlementStatus;
                if($setstatus==2){
                    $updatefullysettleds=Sales::where('id',$salesidsval)->update(['setlmentstatus'=>0]);
                }
                if($setstatus==1){
                    if($cntsales==1){
                        $updatefullysettleds=Sales::where('id',$salesidsval)->update(['setlmentstatus'=>0]);
                    }
                    if($cntsales>1){
                        $updatefullysettleds=Sales::where('id',$salesidsval)->update(['setlmentstatus'=>1]);
                    }
                }
            }
            $sett->Status=$statusval;
            $sett->OldStatus=$stval;
            $sett->IsVoid="1";
            $vnumber=$sett->CrvNumber;
            $sett->CrvNumber=$vnumber."(void".$findid.")";
            $sett->VoidBy=$user;
            $sett->VoidReason=trim($request->input('Reason'));
            $sett->VoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $sett->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function undoSettlement(Request $request)
    {
        $totalout=0;
        $totalsett=0;
        $totalrem=0;
        $findid=$request->undovoidid;
        $sett=settlement::find($findid);
        $vnumber=$sett->CrvNumber;//get voucher number
        $pos=$sett->stores_id;
        $custid=$sett->customers_id;
        $settledamountst=$sett->SettlementAmount;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $newvouchernumber=str_replace("(void".$findid.")","",$vnumber);
        $detailTable=DB::select('SELECT
        @witholdamount:=0,
        @vatamount:=0,
        @vatsett:=sales.VatSetle,
        @withsett:=sales.WitholdSetle,
        IF(@withsett=1,@witholdamount:=sales.WitholdAmount,@witholdamount:=0),
        IF(@vatsett=1,@vatamount:=sales.Vat,@vatamount:=0),
        @crssales:=(sales.GrandTotal-@witholdamount-@vatamount) AS CreditSales,
        @settledamount:=(SELECT SUM(settlementdetails.SettlementAmount) FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.sales_id=sales.id AND settlements.IsVoid=0) AS SettledAmounts,@crssales-@settledamount AS OustandingBalance FROM sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status="Confirmed" AND sales.PaymentType="Credit" AND sales.CustomerId='.$custid.' AND sales.StoreId='.$pos.' ORDER BY sales.id ASC');
        foreach($detailTable as $rowval)
        {
            $totalout+=$rowval->CreditSales;
            $totalsett+=$rowval->SettledAmounts;
        }
        $totalrem=$totalout-$totalsett;
        $getCountedVouchernum=DB::select('select count(id) as VoucherCount from settlements where settlements.customers_id='.$custid.' AND settlements.CrvNumber="'.$newvouchernumber.'"');
        foreach($getCountedVouchernum as $row)
        {
            $vcount=$row->VoucherCount;
        }
        $vcounts = (float)$vcount;
        if($vcounts>=1){
            return Response::json(['undoerror'=>"error"]);
        }
        else if($settledamountst>$totalrem){
            return Response::json(['balancerror'=>"error"]);
        }
        else{
            $settlistsv=settlementdetail::where('settlements_id', $request->undovoidid)->get(['id','SettlementStatus','sales_id','RemainingAmount','SettlementAmount']);
            foreach ($settlistsv as $row) {
                $cntsales=0;
                $remamount=0;
                $setamount=0;
                $vatamountval=0;
                $witholdamountval=0;
                $netpayamounts=0;
                $settlementresults=0;
                $settlementdetids = $row->id;
                $salesidsval = $row->sales_id;
                $remamount = $row->RemainingAmount;
                $setamount = $row->SettlementAmount;
                $setstatus = $row->SettlementStatus;
                if($remamount==$setamount){
                    $updatefullysettleds=Sales::where('id',$salesidsval)->update(['setlmentstatus'=>2]);
                }
                if($remamount!=$setamount){
                    $updatefullysettleds=Sales::where('id',$salesidsval)->update(['setlmentstatus'=>1]);
                    
                }
            }
            $updateStatus=DB::select('update settlements set Status=OldStatus,CrvNumber=REPLACE(CrvNumber,concat("(void",'.$findid.',")"),"") where id='.$findid.'');
            $sett->OldStatus="";
            $sett->IsVoid="0";
            $sett->UndoVoidBy=$user;
            $sett->UndoVoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $sett->save();
            return Response::json(['success' => '1']);
        }
    }

    public function slipnumVal(Request $request){
        $contn=0;
        $settid=$_POST['settlementid']; 
        $bankid=$_POST['bankid']; 
        $slipnum=$_POST['slipnum'];
        $invnum=$_POST['invnum']; 
        $paymode=$_POST['paymode']; 
        if($settid==0){
            $getslipnum=DB::select('SELECT COUNT(settlementdetails.BankTransferNumber) AS SlipCount FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.BankTransferNumber="'.$slipnum.'" AND settlementdetails.banks_id='.$bankid.' AND settlementdetails.PaymentType="'.$paymode.'" AND settlements.IsVoid=0');
            foreach($getslipnum as $row)
            {
                $contn=$row->SlipCount;
            }
        }
        else if($settid>0){
            $getslipnum=DB::select('SELECT COUNT(settlementdetails.BankTransferNumber) AS SlipCount FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.BankTransferNumber="'.$slipnum.'" AND settlementdetails.banks_id='.$bankid.' AND settlementdetails.PaymentType="'.$paymode.'" AND settlementdetails.settlements_id!='.$settid.' AND settlements.IsVoid=0');
            foreach($getslipnum as $row)
            {
                $contn=$row->SlipCount;
            }
        } 
        return response()->json(['contn'=>$contn]);       
    }


    public function Settlementattachment($id)
    {
        if(settlementdetail::where('settlements_id',$id)->exists())
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

            $headerInfo=settlement::find($id);
            $customerid=$headerInfo->customers_id;
            $vouchernumber=$headerInfo->CrvNumber;
            $mem=$headerInfo->Memo;
            $voucherdate=$headerInfo->DocumentDate;
            $preparedby=$headerInfo->SettledBy;
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
            $customerDetails=customer::find($customerid);
            $customername=$customerDetails->Name;
            $customercategory=$customerDetails->CustomerCategory;
            $customertin=$customerDetails->TinNumber;
            $customervat=$customerDetails->VatNumber; 

            $storedetail=store::find($storeid);
            $storename=$storedetail->Name;

            $currentdate=Carbon::createFromFormat('Y-m-d H:i:s',Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            $report = new SettlementRep(array(
                'id'=>$id
            ));
            $report->run(); 
            //$detailTable=DB::select('SELECT settlementdetails.id,sales.VoucherNumber AS FSNumber,sales.invoiceNo AS InvoiceNumber,DATEDIFF(sales.settlementexpiredate,settlements.DocumentDate) AS RemainingDate,settlementdetails.PaymentType,settlementdetails.BankName,settlementdetails.ChequeNumber,settlementdetails.BankTransferNumber,FORMAT(settlementdetails.SettlementAmount,2) AS SettlementAmount,CASE WHEN settlementdetails.SettlementStatus=0 THEN "Not-Paid" WHEN settlementdetails.SettlementStatus=1 THEN "Partially-Paid" WHEN settlementdetails.SettlementStatus=2 THEN "Fully-Paid" END AS SettStatus,settlementdetails.SettlementStatus FROM settlementdetails INNER JOIN sales ON settlementdetails.sales_id=sales.id INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.settlements_id='.$id.' ORDER BY settlementdetails.id ASC');
            $count=0;
            $data=[ 'report'=>$report,
                    'customername'=>$customername,
                    'customercategory'=>$customercategory,
                    'customertin'=>$customertin,
                    'customervat'=>$customervat,
                    'customermrc'=>$customermrc,
                    'vouchernumber'=>$vouchernumber,
                    'transactiondate'=>$transactiondate,
                    'settledamount'=>number_format($settamount),
                    'mem'=>$mem,
                    'voucherdate'=>$voucherdate,
                    'storename'=>$storename,
                    'preparedby'=>$preparedby,
                    'checkedby'=>$checkedby,
                    'checkeddate'=>$checkeddate,
                    'confirmedby'=>$confirmedby,
                    'confirmeddate'=>$confirmeddate,
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
                $html=\View::make('report.slsettlement')->with($data);
                //$html=\View::make('report.HtmlToPDF')->with($data);
                $html=$html->render();  
                $mpdf->SetTitle('Sales Settlement Note ('.$vouchernumber.')');
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0; 
                $mpdf->SetAuthor($companyalladdress);
                $mpdf->SetWatermarkText($st);
                $mpdf->watermark_font = 'DejaVuSansCondensed';
                $mpdf->showWatermarkText = true;
                $mpdf->WriteHTML($html);
                $mpdf->Output('Sales-Settlement-Note '.$vouchernumber.'.pdf','I');

            //$pdf=PDF::loadView('inventory.report.grv',$data);
            //return $pdf->stream();
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
