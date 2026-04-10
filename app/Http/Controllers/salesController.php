<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use Illuminate\Support\Facades\Validator;
use  App\Models\Testm;
use  App\Models\SalesHold;
use  App\Models\Sales;
use  App\Models\Salesitem;
use App\Models\uom;
use App\Models\store;
use App\Models\User;
use App\Notifications\TaskComplete;
use App\Notifications\TestNotificatio;
use App\Models\salesHoldDetails;
use App\Notifications\RealTimeNotification;
use Illuminate\Validation\Rule;
Use Exception;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;


//use DB;
use Illuminate\Support\Facades\DB;
//use Illuminate\Http\Response;
 use Response;
use Carbon\Carbon;
use Session;
class salesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        session()->put('Wholeseller','Wholeseller');
        session()->put('Retailer','Retailer');

       $rt=session()->get('Retailer');
       $ws=session()->get('Wholeseller');

        $customerSrc=DB::select('select * from customers where CustomerCategory!="Supplier" and CustomerCategory!="Foreigner-Supplier"  and ActiveStatus="Active" and DefaultPrice!="" and IsDeleted=1 and id>=2 and DefaultPrice IN("'.$rt.'","'.$ws.'") order by Name asc');
        $customerSrcr=DB::select('select * from customers where CustomerCategory!="Supplier" and CustomerCategory!="Foreigner-Supplier"  and ActiveStatus="Active" and DefaultPrice!="" and IsDeleted=1 and id>=2 and DefaultPrice IN("Retailer") order by Name asc');
        $customerSrcw=DB::select('select * from customers where CustomerCategory!="Supplier" and CustomerCategory!="Foreigner-Supplier"  and ActiveStatus="Active" and DefaultPrice!="" and IsDeleted=1 and id>=2 and DefaultPrice IN("Wholeseller") order by Name asc');
       // $storeSrc=DB::select('select * from stores where ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $storeSrc=DB::select('SELECT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=4 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1 AND stores.IsOnCount=0');
       // $itemSrc=DB::select('select * from regitems where ActiveStatus="Active" and Type="Goods" and IsDeleted=1 order by Name asc');
        //$itemSrcs=DB::select('select * from regitems where ActiveStatus="Active" and Type="Goods" and IsDeleted=1 order by Name asc');
       // $itemSrcss=DB::select('select * from regitems where ActiveStatus="Active" and Type="Goods" and IsDeleted=1 order by Name asc');
        //$mrc=DB::select('select * from companymrcs where ActiveStatus="Active" and IsDeleted=1');
      
        $itemSrc=DB::select('SELECT DISTINCT ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND FiscalYear='.$fiscalyr.' AND StoreId IN(Select StoreId from storeassignments where UserId ='.$userid.' AND storeassignments.Type=4 )');
        $itemSrcs=DB::select('SELECT DISTINCT ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND FiscalYear='.$fiscalyr.' AND StoreId IN(Select StoreId from storeassignments where UserId ='.$userid.' AND storeassignments.Type=4 )');
        $itemSrcss=DB::select('SELECT DISTINCT ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND FiscalYear='.$fiscalyr.' AND StoreId IN(Select StoreId from storeassignments where UserId ='.$userid.' AND storeassignments.Type=4 )');

        $mrc=DB::select('SELECT MRCId,companymrcs.MRCNumber as MRCNumber FROM mrcassignments INNER JOIN companymrcs ON mrcassignments.MRCId=companymrcs.id WHERE mrcassignments.UserId="'.$userid.'" AND mrcassignments.Type=1 AND companymrcs.ActiveStatus="Active" AND companymrcs.IsDeleted=1');
        

        return view('sales.sales',['customerSrc'=>$customerSrc,'storeSrc'=>$storeSrc,'itemSrc'=>$itemSrc,'itemSrcs'=>$itemSrcs,'itemSrcss'=>$itemSrcss,'mrc'=>$mrc,'customerSrcr'=>$customerSrcr,'customerSrcw'=>$customerSrcw]);
    }

 public function salelist()
 {
   
    $user=Auth()->user()->username;
    $userid=Auth()->user()->id;
    

    $salehol=DB::select('SELECT sales.id,customers.CustomerCategory,customers.Name,customers.TinNumber,customers.VatType,customers.Witholding,sales.PaymentType,sales.VoucherType,sales.VoucherNumber,sales.CustomerMRC,sales.Vat,sales.WitholdAmount,sales.SubTotal,stores.Name as StoreName,sales.CreatedDate,sales.Status FROM sales INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.StoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=4)');
    return datatables()->of($salehol)
    ->addIndexColumn()
    ->addColumn('action', function($data)
    {    
        $user=Auth()->user(); 
        $unvoidvlink='';
        $voidlink='';
        $refundlink='';
        $editlink='';
        $vatlink='';
        $witholdlink='';
        $settingsval = DB::table('settings')->latest()->first();
         $fiscalyr=$settingsval->FiscalYear;
         $saleswithold=$settingsval->SalesWithHold;
         $vatdeduct=$settingsval->vatDeduct;

        if($data->SubTotal>=$saleswithold||$data->SubTotal>=$vatdeduct)
        {
            
            if($user->can('Settle-Vat')||$user->can('Settle-Withold'))
            {
                $vatlink='<a class="dropdown-item addvat" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-status="'.$data->Status.'" data-original-title="Edit" title="Add Vat">
                <i class="fa fa-plus"></i><span> Add/Edit Reciept</span>
                </a>';
            }
        }
        if($data->WitholdAmount!=null&&$data->WitholdAmount!=0)
        {
            if($user->can('Settle-Withold')){
            $witholdlink='<a class="dropdown-item addWithold" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-status="'.$data->Status.'" data-original-title="Edit" title="Add Vat">
            <i class="fa fa-plus"></i><span> Add/Edit Withold</span>
        </a>' ;
            }
        }

        if($data->Status=='Void')
       {
        if($user->can('Sales-Void')){
       $unvoidvlink= '<a class="dropdown-item saleunVoid" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="smallButton"  data-attr="" title="Delete Record">
        <i class="fa fa-undo"></i><span> Undo Void</span>  
        </a>';
        $voidlink='';
        $vatlink='';
        
        }
       

       }
        if($data->Status!='Void')
       {
        if($user->can('Sales-Void')){
        $voidlink=' <a class="dropdown-item saleVoid" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="smallButton"  data-attr="" title="Delete Record">
        <i class="fa fa-trash"></i><span> Void</span>  
       </a>'; 
       $unvoidvlink='';
        }

       }
       if($data->Status!='Refund')
       {
        if($user->can('Sales-Refund'))
        {
       $refundlink=' <a class="dropdown-item saleRefund" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-status="'.$data->Status.'" data-original-title="Edit" title="Edit Record">
       <i class="fa fa-undo"></i><span>Refund</span>
        </a>';
        }

        }
        if($data->Status=='pending..')
        { 
            if($user->can('sales-edit')){
            $editlink='<a class="dropdown-item saleeditProduct" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-status="'.$data->Status.'" data-original-title="Edit" title="Edit Record">
            <i class="fa fa-edit"></i><span> Edit</span>
           </a>';
            }
            $vatlink;
            $witholdlink;
       
        }
        if($data->Status=='Checked')
        {
            $refundlink='';
            $voidlink='';
            if($user->can('sale-check')&&$user->can('sales-edit')){
                $editlink='<a class="dropdown-item saleeditProduct" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-status="'.$data->Status.'" data-original-title="Edit" title="Edit Record">
                <i class="fa fa-edit"></i><span> Edit</span>
            </a>';
              
            }
            if($user->can('sale-check')&&$user->can('Sales-Void'))
            {
            
                $voidlink=' <a class="dropdown-item saleVoid" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="smallButton"  data-attr="" title="Delete Record">
                <i class="fa fa-trash"></i><span> Void</span>  
            </a>'; 
            }
            $vatlink;
            $witholdlink;


        }
        if($data->Status=='Confirmed')
        {
            $voidlink='';   
            $refundlink='';
            if($user->can('sale-confirm')&&$user->can('Sales-Void')){
            $voidlink=' <a class="dropdown-item saleVoid" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="smallButton"  data-attr="" title="Delete Record">
            <i class="fa fa-trash"></i><span> Void</span>  
        </a>'; 
            }
            if($user->can('sale-confirm')&&$user->can('Sales-Refund')){

        $refundlink=' <a class="dropdown-item saleRefund" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-status="'.$data->Status.'" data-original-title="Edit" title="Edit Record">
        <i class="fa fa-undo"></i><span>Refund</span>
         </a>';
            }
            $vatlink;
            $witholdlink;
        }

         if($data->Status=='Refund')
        {
            $voidlink='';
            $vatlink='';
        }
        if($data->Status=='Void')
        {
            $refundlink='';
        }
        

        

        $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item saleinfoProductItem" data-id="'.$data->id.'" data-toggle="modal" id="smallButton" data-target="#MRCRegModal" title="show Hold Sales Info">
                        <i class="fa fa-info"></i><span> Info.</span>  
                    </a>
                   
                   '.$editlink.'
                  
                   '.$voidlink.'
                    '.$unvoidvlink.'
                    '.$refundlink.'
                    '.$vatlink.'
                    
                    <a class="dropdown-item enVoice" href="javascript:void(0)" data-link="/salereport/'.$data->id.'"  data-id="'.$data->id.'" data-status="'.$data->Status.'" data-original-title="Edit" title="Edit Record">
                    <i class="fa fa-file"></i><span> Attachment</span>
                </a>
                   
                    
                </div>
            </div>';
        return $btn;
    })->rawColumns(['action'])
      ->make(true);

 }

    public function salesholdlist()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $salehol=DB::select('SELECT sales_holds.id,customers.CustomerCategory,customers.Name, customers.TinNumber, sales_holds.PaymentType,sales_holds.VoucherType,sales_holds.VoucherNumber,sales_holds.CustomerMRC,stores.Name as StoreName,sales_holds.VoidedDate FROM sales_holds INNER JOIN customers ON sales_holds.CustomerId=customers.id INNER JOIN stores ON sales_holds.StoreId=stores.id WHERE sales_holds.StoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=4)');
        return datatables()->of($salehol)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {   
            $user=Auth()->user(); 

            if($user->can('sale-HoldEdit')){
              $holdeditlink='<a class="dropdown-item editProduct" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-original-title="Edit" title="Edit Record">
              <i class="fa fa-edit"></i><span> Edit</span>
          </a>';
            }
            if($user->can('sale-holdDelete')){
              $holddeletelink='<a class="dropdown-item deleteProduct" data-id="'.$data->id.'" data-toggle="modal" id="smallButton"  data-attr="" title="Delete Record">
              <i class="fa fa-trash"></i><span>Delete</span>  
          </a>';
            }
            //  $btn =  ' <a data-id="'.$data->id.'" data-customerid="" data-mrcnumber="" data-status="" class="btn btn-icon btn-gradient-info btn-sm" data-toggle="modal" id="mediumButton" data-target="#examplemodal-mrcedit" style="color: white;" title="Edit Record">Edit</a>';
            //  $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#examplemodal-mrcdelete" data-attr="" style="color: white;" title="Delete Record">Delete</a>';
            $btn='<div class="btn-group dropleft">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item infoProductItem" data-id="'.$data->id.'" data-toggle="modal" id="smallButton" data-target="#MRCRegModal" title="show Hold Sales Info">
                            <i class="fa fa-info"></i><span> Info.</span>  
                        </a>
                        '.$holdeditlink.'
                        '.$holddeletelink.'
                        
                    </div>
                </div>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
        
    }
    public function salechildsalelist($id)
    {

        $salechild=DB::select('SELECT salesitems.id,salesitems.HeaderId,salesitems.Dprice,regitems.Code,regitems.SKUNumber,salesitems.ItemId,regitems.Name AS ItemName, uoms.Name AS UOM,salesitems.Quantity,salesitems.Dprice,salesitems.UnitPrice,salesitems.Discount,salesitems.BeforeTaxPrice,salesitems.TaxAmount,salesitems.TotalPrice FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN uoms ON salesitems.NewUOMId=uoms.id where salesitems.HeaderId='.$id);
        return datatables()->of($salechild)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            
           // $btn =  ' <a data-id="'.$data->ItemId.'"  class="btn btn-icon btn-gradient-info btn-sm infoItem" data-toggle="modal" id="mediumButton" data-target="#examplemodal-locedit" style="color: white;" title="Edit Record"><i class="fa fa-info"></i></a>';
           $btn='';
           $btn =  $btn.' <a data-id="'.$data->id.'" data-uom="'.$data->UOM.'"  class="btn btn-icon btn-gradient-info btn-sm saleeditItem" data-toggle="modal" id="mediumButton"  style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
           $btn = $btn.' <a data-id="'.$data->id.'"  data-hid="'.$data->HeaderId.'" class="btn btn-icon btn-gradient-danger btn-sm saledeleteItem"  data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';  
           return $btn;    
        })
        ->rawColumns(['action'])
        ->make(true);

    }

    public function saleinfodholdlist($id)
    {
 $saleholchild=DB::select('SELECT salesholddetails.id,salesholddetails.HeaderId,salesholddetails.ItemId,salesholddetails.Dprice,regitems.Code,regitems.SKUNumber,regitems.Name AS ItemName,salesholddetails.Quantity,salesholddetails.UnitPrice,salesholddetails.Discount,salesholddetails.BeforeTaxPrice,salesholddetails.TaxAmount,salesholddetails.TotalPrice FROM salesholddetails INNER JOIN regitems ON salesholddetails.ItemId=regitems.id where salesholddetails.HeaderId='.$id);
        return datatables()->of($saleholchild)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            
            $btn =  ' <a data-id="'.$data->ItemId.'"  class="btn btn-icon btn-gradient-info btn-sm infoItem" data-toggle="modal" id="mediumButton" data-target="#examplemodal-locedit" style="color: white;" title="Edit Record"><i class="fa fa-info"></i></a>';
            $btn =  $btn.' <a data-id="'.$data->id.'"  class="btn btn-icon btn-gradient-info btn-sm editItem" data-toggle="modal" id="mediumButton"  style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            $btn = $btn.' <a data-id="'.$data->id.'"   class="btn btn-icon btn-gradient-danger btn-sm deleteItem"  data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
           
            return $btn;

            
        })
        ->rawColumns(['action'])
        ->make(true);

    }
    public function salesholdchildlist($id)
    {
        $saleholchild=DB::select('SELECT salesholddetails.id,salesholddetails.Dprice,salesholddetails.HeaderId,salesholddetails.ItemId,regitems.Name AS ItemName,salesholddetails.Quantity,salesholddetails.UnitPrice,salesholddetails.Discount,salesholddetails.BeforeTaxPrice,salesholddetails.TaxAmount,salesholddetails.TotalPrice FROM salesholddetails INNER JOIN regitems ON salesholddetails.ItemId=regitems.id where salesholddetails.HeaderId='.$id);
        return datatables()->of($saleholchild)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            
           // $btn =  ' <a data-id="'.$data->ItemId.'"  class="btn btn-icon btn-gradient-info btn-sm infoItem" data-toggle="modal" id="mediumButton" data-target="#examplemodal-locedit" style="color: white;" title="Edit Record"><i class="fa fa-info"></i></a>';
            $btn='';
            $btn =  $btn.' <a data-id="'.$data->id.'"  class="btn btn-icon btn-gradient-info btn-sm editItem" data-toggle="modal" id="mediumButton"  style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            $btn = $btn.' <a data-id="'.$data->id.'"  data-hid="'.$data->HeaderId.'"  class="btn btn-icon btn-gradient-danger btn-sm deleteItem"  data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
           
            return $btn;

            
        })
        ->rawColumns(['action'])
        ->make(true);
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
    public function refundsale(Request $request,$id)
    {
        $varchecked=$request->refundtatus;
        $currentstatus=$request->refundcurrentstatus; 
        $getoldstat=Sales::find($id);
        $oldStatus=$getoldstat->OldStatus;
        $VoucherNumber=$getoldstat->VoucherNumber;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'Reason' => ['required'], 
        ]);
        if ($validator->passes()) 
        {
            if($varchecked=='Refund')
        {
            $transactiontype='Sales';
            $transactionVoid='Refund';

            if($currentstatus=='Confirmed')
            {
                
                $transactiondata=DB::table('transactions')->insertUsing(
                    ['HeaderId', 'ItemId', 'StockIn','UnitPrice','BeforeTaxPrice','TaxAmountPrice','TotalPrice','StoreId','TransactionType','ItemType'
                    ],
                    function ($query)use($id) {
                        $query
                            ->select(['HeaderId', 'ItemId', 'ConvertedQuantity','UnitPrice','BeforeTaxPrice','TaxAmount','TotalPrice','StoreId','TransactionType','ItemType']) // ..., columnN
                            ->from('salesitems')->where('HeaderId', '=',$id);
                    }
                );
                

            }
            $today=Carbon::today()->toDateString();
            $updatestatus= DB::table('sales')
            ->where('id', $id) ->update(['Status' => $varchecked,'RefundBy'=>$user,'RefundDate'=>$today]);


            $updatetrans=DB::table('transactions')
            ->where('HeaderId', $id)
            ->where('TransactionType', 'Sales')
            ->update(['FiscalYear'=>$fiscalyr,'TransactionsType'=>"Refund"]);

            $updatetrans=DB::table('transactions')
            ->where('HeaderId', $id)
            ->where('TransactionType', 'Sales')
            ->where('TransactionsType', 'Refund')
            ->update(['Date'=>Carbon::now(),'DocumentNumber'=>$VoucherNumber]);
            return Response::json(['success' =>'Refunded Success Fully='.$id]);

        }

        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }   
        
    }
    public function kool()
    {
        return view('report.koolreport');
    }
    public function checkStatus(Request $request,$id)
    {
        $varchecked=$request->checkedst;
        $currentstatus=$request->currentstatus;
        $VoucherNumber=$request->undoVoucherNumber;
        //get old status from database
        $getoldstat=Sales::find($id);
        $oldStatus=$getoldstat->OldStatus;
        $storeID=$getoldstat->StoreId;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;

        if($varchecked=='Checked')
        {
          $updatestatus= DB::table('sales')
            ->where('id', $id) ->update(['Status' => $varchecked,'CheckedBy'=>$user,'CheckedDate'=>Carbon::today()->toDateString()]);

                
        }

       else if($varchecked=='pending..')
        {

          $updatestatus= DB::table('sales')
            ->where('id', $id) ->update(['Status' => $varchecked,'ChangeToPendingBy'=>$user,'ChangeToPendingDate'=>Carbon::today()->toDateString()]);

            return Response::json(['success' => 'Ok pending']);
                
        }

        else if($varchecked=='Confirmed')
        {
            $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM salesitems AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$id.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeID.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
           

            foreach($getApprovedQuantity as $row)
            {
                    $avaq=$row->ApprovedItems;
            }
            $avaqp = (float)$avaq;
                if($avaqp>=1)
                {

                $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeID.' AND transactions.FiscalYear='.$fiscalyr.') AS AvailableQuantity FROM salesitems AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$id.' AND 
            (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeID.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
            return Response::json(['valerror' =>  "error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);

            }
            else
            {
                $transactiontype='Sales';
        
                $transactiondata=DB::table('transactions')->insertUsing(
                    ['HeaderId', 'ItemId', 'StockOut','UnitPrice','BeforeTaxPrice','TaxAmountPrice','TotalPrice','StoreId','TransactionType','ItemType'
                    ],
                    function ($query)use($id) {
                        $query
                            ->select(['HeaderId', 'ItemId', 'ConvertedQuantity','UnitPrice','BeforeTaxPrice','TaxAmount','TotalPrice','StoreId','TransactionType','ItemType']) // ..., columnN
                            ->from('salesitems')->where('HeaderId', '=',$id);
                    }
                );
    
                $sales = DB::table('sales')->where('id', $id)->latest()->first();
                $vunum=$sales->VoucherNumber;
    
               
    
                $updatetrans=DB::table('transactions')
                ->where('HeaderId', $id)
                ->where('TransactionType',$transactiontype)
                ->update(['DocumentNumber' => $vunum,'FiscalYear'=>$fiscalyr,'TransactionsType'=>$transactiontype,'Date'=>Carbon::now()]);
    
    
    
              $updatestatus= DB::table('sales')
                ->where('id', $id) ->update(['Status' => $varchecked,'ConfirmedBy'=>$user,'ConfirmedDate'=>Carbon::today()->toDateString()]);
                return Response::json(['success' => 'Ok confirmed','avaq'=>$avaq]);
            }

                 
        }

        else if($varchecked=='Void')
        {
            $transactiontype='Sales';
            $transactionVoid='Void';
            if($currentstatus=='Confirmed')
            {
                $transactiondata=DB::table('transactions')->insertUsing(
                    ['HeaderId', 'ItemId', 'StockIn','UnitPrice','BeforeTaxPrice','TaxAmountPrice','TotalPrice','StoreId','TransactionType','ItemType'
                    ],
                    function ($query)use($id) {
                        $query
                            ->select(['HeaderId', 'ItemId', 'ConvertedQuantity','UnitPrice','BeforeTaxPrice','TaxAmount','TotalPrice','StoreId','TransactionType','ItemType']) // ..., columnN
                            ->from('salesitems')->where('HeaderId', '=',$id);
                    }
                );

            }
            $today=Carbon::today()->toDateString();
            $updateStatusold=DB::select('update sales set OldStatus=Status,VoidedBy="'.$user.'",VoidedDate="'.$today.'",VoucherNumber=concat(VoucherNumber,"(void'.$id.')")  where id='.$id.'');
            $sales = DB::table('sales')->where('id', $id)->latest()->first();
            $vunum=$sales->VoucherNumber;

            $settingsval = DB::table('settings')->latest()->first();
            $fiscalyr=$settingsval->FiscalYear;

            $updatetrans=DB::table('transactions')
            ->where('HeaderId', $id)
            ->where('TransactionType',$transactiontype)
            ->update(['DocumentNumber' => $vunum,'FiscalYear'=>$fiscalyr,'TransactionsType'=>$transactionVoid,'Date'=>Carbon::now()]);

            
            $updatestatus= DB::table('sales')
            ->where('id', $id) ->update(['Status' => $varchecked]);

            return Response::json(['success' => 'Void confirmed']);

        }

        else if($varchecked=='unVoid')
        {

            $transactiontype='Sales';
            $transactionVoid='Undo-Void';

            $validator = Validator::make($request->all(), [
                'undoVoucherNumber' => ['required'],

                
            ]);
            if ($validator->passes())
            {
                try{
                    $today=Carbon::today()->toDateString();
                    $updateStatusold=DB::select('update sales set Status=OldStatus,UnvoidBy="'.$user.'",UnVoidDate="'.$today.'",VoucherNumber='.$VoucherNumber.' where id='.$id.'');
                    if($oldStatus=='Confirmed')
                    {
                        $transactiondata=DB::table('transactions')->insertUsing(
                            ['HeaderId', 'ItemId', 'StockOut','UnitPrice','BeforeTaxPrice','TaxAmountPrice','TotalPrice','StoreId','TransactionType','ItemType'
                            ],
                            function ($query)use($id) {
                                $query
                                    ->select(['HeaderId', 'ItemId', 'ConvertedQuantity','UnitPrice','BeforeTaxPrice','TaxAmount','TotalPrice','StoreId','TransactionType','ItemType']) // ..., columnN
                                    ->from('salesitems')->where('HeaderId', '=',$id);
                            }
                        );
                    }
        
                   
                    $sales = DB::table('sales')->where('id', $id)->latest()->first();
                    $vunum=$sales->VoucherNumber;
                    $settingsval = DB::table('settings')->latest()->first();
                    $fiscalyr=$settingsval->FiscalYear;
                    $updatetrans=DB::table('transactions')
                    ->where('HeaderId', $id)
                    ->where('TransactionType',$transactiontype)
                    ->update(['DocumentNumber' => $vunum,'FiscalYear'=>$fiscalyr,'TransactionsType'=>$transactionVoid,'Date'=>Carbon::now()]);
                   
                    return Response::json(['success' => 'un Void confirmed']);
        
                    }
                    catch(Exception $e)
                        {
                            return Response::json(['dberrors' =>  $e->getMessage()]);
                        }

            } else
            {
                return Response::json(['errors' => $validator->errors()]); 
            }


            
            
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
        //
        $user=Auth()->user()->username;
        $customerid=$request->customer;
        $vnumber=$request->voucherNumber;
        $mrcnum=$request->CustomerMRC;
        $vtype='Fiscal-Receipt';
        $paymentype=$request->paymentType;
        $CustomerId='';


       // echo "ecustom=".$customerid;
       $idup=$request->id;
        if($idup!=null)
        {
            if($request->Wholesellercustomer)
            {
                $validator = Validator::make($request->all(), [
                    'Wholesellercustomer' => ['required'],
                    'paymentType' => ['required'],
                    'voucherType' => ['required'],
                 
                    'voucherNumber' => ['required',Rule::unique('sales')->where(function ($query) use($vnumber,$customerid,$mrcnum,$vtype) {
                        return $query->where('VoucherNumber', $vnumber)
                        ->where('CustomerMRC', $mrcnum); 
                    })->ignore($idup)],
                    'date' => ['required','before:now'],
                    'store' => ['required'],
               
                ]);
            }
            if($request->Retailcustomer)
            {

                $validator = Validator::make($request->all(), [
                    'Retailcustomer' => ['required'],
                    'paymentType' => ['required'],
                    'voucherType' => ['required'],
                    'voucherNumber' => ['required',Rule::unique('sales')->where(function ($query) use($vnumber,$customerid,$mrcnum,$vtype) {
                        return $query->where('VoucherNumber', $vnumber)
                        ->where('CustomerMRC', $mrcnum);
                    })->ignore($idup)],
                    'date' => ['required','before:now'],
                    'store' => ['required'],
               
                ]);
            }
           
            if ($validator->passes()) {
                   
                try{
                    $wholesalecustomer=$request->Wholesellercustomer;
                    $retailcustomer=$request->Retailcustomer;
                    if($retailcustomer!='')
                    {
                        $CustomerId=$retailcustomer;
                    }
                    if($wholesalecustomer!='')
                    {
                        $CustomerId=$wholesalecustomer;
                    }
                      
                        $sale=Sales::updateOrCreate(['id' =>$request->id], [
                       'CustomerId' => trim($CustomerId),
                       'PaymentType' => trim($request->paymentType),
                       'VoucherNumber' =>trim($request->voucherNumber),
                       'CustomerMRC'=>trim($request->CustomerMRC),
                       'VoucherType' => trim($request->voucherType),
                       'CreatedDate' => trim($request->date),
                       'StoreId' => trim($request->store),
                    //    'SubTotal' => trim($request->subtotali),
                    //    'Tax' => trim($request->taxi),
                    //    'GrandTotal' => trim($request->grandtotali),
                       'WitholdAmount' => trim($request->witholdingAmntin),
                       'NetPay' => $request->netpayin,
                       'Vat' => trim($request->vatAmntin),
                       'Common'=> trim($request->salecounti),
                      // 'Status' =>'pending..',
                       'Username'=>$user,
                       'WitholdSetle'=> trim($request->hidewitholdi),
                       'VatSetle'=> trim($request->hidevati),
      
                        ]);
                                  
                     $comn=$request->salecounti;
                   if($comn!=null){
                    $saleshead = DB::table('sales')->latest()->first();
                    $headerid=$request->id;

                     $updn=DB::select('update salesitems set HeaderId='.$headerid.'	where Common='.$comn.'');
                    //  $updprice=DB::select('update sales set SubTotal=(SELECT SUM(BeforeTaxPrice) FROM salesitems WHERE HeaderId='.$headerid.'),
                    //  Tax=(SELECT SUM(TaxAmount) FROM salesitems WHERE HeaderId='.$headerid.'),
                    //  GrandTotal=(SELECT SUM(TotalPrice) FROM salesitems WHERE HeaderId='.$headerid.'),
                    //  DiscountAmount=(SELECT SUM(DiscountAmount) FROM salesitems WHERE HeaderId='.$headerid.'),
                    //  DiscountPercent=(SELECT SUM(Discount) FROM salesitems WHERE HeaderId='.$headerid.')
                    //  where id='.$headerid.'');
                    // $updprice=DB::select('update sales set SubTotal=(SELECT TRUNCATE(SUM(BeforeTaxPrice),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                    // Tax=(SELECT TRUNCATE(SUM(TaxAmount),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                    // GrandTotal=(SELECT TRUNCATE(SUM(TotalPrice),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                    // DiscountAmount=(SELECT TRUNCATE(SUM(DiscountAmount),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                    // DiscountPercent=(SELECT SUM(Discount) FROM salesitems WHERE HeaderId='.$headerid.')
                    // where id='.$headerid.'');

                    $updprice=DB::select('update sales set SubTotal=(SELECT TRUNCATE(SUM(BeforeTaxPrice),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                    DiscountAmount=(SELECT TRUNCATE(SUM(DiscountAmount),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                    DiscountPercent=(SELECT SUM(Discount) FROM salesitems WHERE HeaderId='.$headerid.')
                    where id='.$headerid.'');
    
                        DB::table('sales')
                        ->where('id', $headerid)
                        ->update(['Tax'=>(DB::raw('TRUNCATE((sales.SubTotal * 15)/100,2)')),'GrandTotal' =>(DB::raw('ROUND(sales.SubTotal + sales.Tax,2)'))]);
    
    
                     
                    }
                                  return Response::json(['success' => '1']);
                }
                catch(Exception $e)
              {
                 return Response::json(['dberrors' =>  $e->getMessage()]);
              }
                            }
        }

        if($idup==null)
        {
            $validator = Validator::make($request->all(), [
                 'customer' => ['required'],
                 'paymentType' => ['required'],
                 'voucherType' => ['required'],
               //  'voucherNumber' =>"required",
                 'voucherNumber' => ['required',Rule::unique('sales')->where(function ($query) use($vnumber,$customerid,$mrcnum,$paymentype) {
                    return $query->where('VoucherNumber', $vnumber)
                    ->where('CustomerMRC', $mrcnum);
                  //  ->where('CustomerId', $customerid);
                   
                    
                })],
                 'date' => ['required','before:now'],
                 'store' => ['required'],
            
            ]);
            $rules=array(

                'row.*.ItemId' => 'required',
               // 'row.*.Type' => 'required',
                'row.*.Quantity' => 'required|gt:0',
                'row.*.UnitPrice' => 'required|gt:0',
                'row.*.BeforeTaxPrice' => 'required|gt:0',
                'row.*.TaxAmount' => 'required|gt:0',
                'row.*.TotalPrice' => 'required|gt:0',
            );
    
            $v2= Validator::make($request->all(), $rules);


            if ($validator->passes() && $v2->passes() && ($request->row!=null)) {

              try{

                $sale=Sales::updateOrCreate(['id' =>$request->id], [
                    'CustomerId' => trim($request->customer),
                    'PaymentType' => trim($request->paymentType),
                    'VoucherNumber' =>trim($request->voucherNumber),
                    'CustomerMRC'=>trim($request->CustomerMRC),
                    'VoucherType' => trim($request->voucherType),
                    'CreatedDate' => trim($request->date),
                    'StoreId' => trim($request->store),
                    // 'SubTotal' => trim($request->subtotali),
                    // 'Tax' => trim($request->taxi),
                    // 'GrandTotal' => trim($request->grandtotali),
                    'WitholdAmount' => trim($request->witholdingAmntin),
                    'NetPay' => $request->netpayin,
                    //'Np' => $request->netpayin,
                    'Vat' => trim($request->vatAmntin),
                    'Common'=> trim($request->salecounti),
                    'Status' =>'pending..',
                    'Username'=>$user,
                    // 'WitholdSetle'=> trim($request->hidewitholdi),
                    // 'VatSetle'=> trim($request->hidevati),
                    'WitholdSetle'=>'0',
                    'VatSetle'=> '0',
                    ]);
                       
                    foreach ($request->row as $key => $value) {
                            Salesitem::create($value);
                        }
                          
                          
                $comn=$request->salecounti;
               if($comn!=null){
                $saleshead = DB::table('sales')->where('Common',$comn)->latest()->first();
                $headerid=$saleshead->id;
                
                 $updn=DB::select('update salesitems set HeaderId='.$headerid.'	where Common='.$comn.'');


                $updprice=DB::select('update sales set SubTotal=(SELECT TRUNCATE(SUM(BeforeTaxPrice),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                DiscountAmount=(SELECT TRUNCATE(SUM(DiscountAmount),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                DiscountPercent=(SELECT SUM(Discount) FROM salesitems WHERE HeaderId='.$headerid.')
                where id='.$headerid.'');

                    DB::table('sales')
                    ->where('id', $headerid)
                    ->update(['Tax'=>(DB::raw('TRUNCATE((sales.SubTotal * 15)/100,2)')),'GrandTotal' =>(DB::raw('ROUND(sales.SubTotal + sales.Tax,2)'))]);

               }
        
                  $userdata=auth()->user();
                  $admins = User::whereHas('roles', function ($query) {
                  $query->where('role_id', 2);
                   })->get();

                
                  
                 
                //    $notifyuser = User::whereHas('storeassignments', function ($query) {
                //     $query->where('user_id', 17);
                //      })->whereHas('storeassignments',function($query)
                //      {
                //         $query->where('store_id', 2);
                //      })->whereHas('storeassignments',function($query)
                //     {
                //         $query->where('Type', 4);
                //     })->get();
               
                $users2 = User::join('storeassignments', 'storeassignments.UserId', '=', 'users.id')
               ->where(['storeassignments.StoreId' => 5])
               ->get(['users.*']);

                // $notifyuser='SELECT user_id from storeassignments WHERE store_id=5 and type=2';
                    $username=auth()->user()->username;

                   //Notification::send($notifyuser, new TaskComplete($username,'needs Approval'));
                  // Notification::send($notifyuser, new RealTimeNotification('needs Approval'));

                   try { 
                    Notification::send($users2, new RealTimeNotification($username,'This is sample notifcation that can manage it for users'));
                     } catch(\Exception $e){
        
                     }

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
            return response()->json([
                'errorv2'  => $v2->errors()->all()
               ]);
        }

        
    }

    // public function notifi()
    // {
    //     $admins = User::whereHas('storeassignments', function ($query) {
    //         $query->where('user_id', 3);
    //          })->whereHas('storeassignments',function($query)
    //          {
    //             $query->where('store_id', 2);
    //          })->whereHas('storeassignments',function($query)
    //         {
    //             $query->where('Type', 4);
    //         })->get();

    //        // $cc=[{'id'=>auth()->user()->unreadnotifications->count()}];
    //         $nc=auth()->user()->unreadnotifications->count();
    //         $data="You have new Request"; 
    //         $cc = array
    //         (
    //             array('id'=>$nc, 'data'=>$data), 
    //             // array('id'=>$nc, 'data'=>$data), 
                
    //         );
            
    //          echo json_encode($cc);

    // }

    public function holdStore(Request $request)
    {

        $user=Auth()->user()->username;
        $customerid=$request->customer;
        $CustomerId=$request->customer;
        $id=$request->id;
        $validator = Validator::make($request->all(), [
            'customer' => ['required'],
            'store' => ['required'],     
        ]);
        if($request->Retailcustomer)
        {
            $validator = Validator::make($request->all(), [
                'Retailcustomer' => ['required'],
                'store' => ['required'],     
            ]);
        }
        if($request->Wholesellercustomer)
        {
            $validator = Validator::make($request->all(), [
                'Wholesellercustomer' => ['required'],
                'store' => ['required'],     
            ]);
        }
       

       
        $rules=array(

            'row.*.ItemId' => 'required',
            'row.*.Quantity' => 'required|gt:0',
            'row.*.UnitPrice' => 'required|gt:0',
            'row.*.BeforeTaxPrice' => 'required|gt:0',
            'row.*.TaxAmount' => 'required|gt:0',
            'row.*.TotalPrice' => 'required|gt:0',
            
        );

        $v2= Validator::make($request->all(), $rules);
        
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


        if ($validator->passes() || $v2->passes()) {

            try{

                $wholesalecustomer=$request->Wholesellercustomer;
                    $retailcustomer=$request->Retailcustomer;
                    if($retailcustomer!='')
                    {
                        $CustomerId=$retailcustomer;
                    }
                    if($wholesalecustomer!='')
                    {
                        $CustomerId=$wholesalecustomer;
                    }

                $saleshold=new SalesHold;
                $hold=SalesHold::updateOrCreate(['id' => $request->id], [
                'CustomerId' => trim($CustomerId),
                'PaymentType' => trim($request->paymentType),
                'VoucherNumber' =>trim($request->voucherNumber),
                'VoucherType' => trim($request->voucherType),
                'CustomerMRC'=>trim($request->CustomerMRC),
                'VoidedDate' => trim($request->date),
                'StoreId' => trim($request->store),
                'SubTotal' => trim($request->subtotali),
                'Tax' => trim($request->taxi),
                'GrandTotal' => trim($request->grandtotali),
                'WitholdAmount' => trim($request->witholdingAmntin),
                'NetPay' => $request->netpayin,
                'Vat' => trim($request->vatAmntin),
                'Common'=> trim($request->salecounti),
                'Username'=>$user,
               // 'DiscountAmount'=>$request->discountamountli,
               // 'DiscountPercent'=>$request->discountpercenti,

              ]);

                if($v2->passes() && ($request->row!=null) )
                {
              foreach ($request->row as $key => $value) {
                salesHoldDetails::create($value);
              }
              }
            $comn=$request->salecounti;
           if($comn!=null&&$id==null){
            $saleshead = DB::table('sales_holds')->latest()->first();
            $headerid=$saleshead->id;
            $updn=DB::select('update salesholddetails set HeaderId='.$headerid.' where Common='.$comn.'');

            $updprice=DB::select('update sales_holds set DiscountPercent=(SELECT SUM(Discount) FROM salesholddetails WHERE HeaderId='.$headerid.'),
            DiscountAmount=(SELECT TRUNCATE(SUM(DiscountAmount),2) FROM salesholddetails WHERE HeaderId='.$headerid.')
            where id='.$headerid);

           }
           if($comn!=null&&$id!=null){
            $saleshead = DB::table('sales_holds')->latest()->first();
            $headerid=$id;
            $updn=DB::select('update salesholddetails set HeaderId='.$headerid.' where Common='.$comn.'');

            $updprice=DB::select('update sales_holds set DiscountPercent=(SELECT SUM(Discount) FROM salesholddetails WHERE HeaderId='.$headerid.'),
            DiscountAmount=(SELECT TRUNCATE(SUM(DiscountAmount),2) FROM salesholddetails WHERE HeaderId='.$headerid.')
            where id='.$headerid);


           }


            return Response::json(['success' => '1']);

            }
            catch(Exception $e)
            {
               return Response::json(['dberrors' =>  $e->getMessage()]);
            }
            
            
        }

        
    }

    public function savesaleitem(Request $request)
    {
        $user=Auth()->user()->username;

        $headerid=$request->HeaderId;
        $item=$request->ItemName;
        $validator = Validator::make($request->all(), [
           'ItemName' => ['required',],
           'Quantity' =>"required|numeric|min:1|gt:0",
           'UnitPrice' =>"required|numeric|gt:0",
        ]);

        if($validator->passes())
        {
            try{

                $hold=Salesitem::updateOrCreate(['id' => $request->itemid], [
                    'HeaderId'=>trim($request->HeaderId),
                    'ItemId' => trim($request->ItemName),
                    'Quantity' => trim($request->Quantity),
                    'UnitPrice' =>trim($request->UnitPrice),
                    'Discount' => $request->Discounts,
                    'BeforeTaxPrice' => trim($request->BeforeTaxPrice),
                    'TaxAmount' => trim($request->TaxAmount),
                    'TotalPrice' => trim($request->TotalPrice),
                    'TransactionType'=>'Sales',
                    'ItemType'=>'Goods',   
                    'ConvertedQuantity' => trim($request->convertedqi),
                    'ConversionAmount' => trim($request->convertedamnti),
                    'NewUOMId' => trim($request->newuomi),
                    'DefaultUOMId' => trim($request->defaultuomi),
                    'StoreId' => trim($request->storeId),
                    'Common'=>trim($request->commonId),
                    'DiscountAmount'=>$request->discountiamount,
                    'Dprice'=>$request->defPrice,

                    
                    //'Username'=>$user,

                  ]);
    
                  $pricing = DB::table('salesitems')
                  ->select(DB::raw('TRUNCATE(SUM(BeforeTaxPrice),2) as BeforeTaxPrice,TRUNCATE(SUM(TaxAmount),2) as TaxAmount,TRUNCATE(SUM(TotalPrice),2) as TotalPrice,TRUNCATE(SUM(DiscountAmount),2) as DiscountAmount ,SUM(Discount) as DiscountPercent'))
                  ->where('HeaderId', '=', $headerid)
                  ->get();
                
            
                   $updprice=DB::select('update sales set SubTotal=(SELECT TRUNCATE(SUM(BeforeTaxPrice),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                    DiscountAmount=(SELECT TRUNCATE(SUM(DiscountAmount),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                    DiscountPercent=(SELECT SUM(Discount) FROM salesitems WHERE HeaderId='.$headerid.')
                    where id='.$headerid.'');
    
                        DB::table('sales')
                        ->where('id', $headerid)
                        ->update(['Tax'=>(DB::raw('TRUNCATE((sales.SubTotal * 15)/100,2)')),'GrandTotal' =>(DB::raw('ROUND(sales.SubTotal + sales.Tax,2)'))]);
                       
                       
                 
                 
                        $countitem = DB::table('salesitems')->where('HeaderId', '=', $headerid)->get();
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

    public function saveholditem(Request $request)
    {
        $user=Auth()->user()->username;

        $headerid=$request->HeaderId;
        $validator = Validator::make($request->all(), [
           
           // 'ItemName' =>"required|unique:salesholddetails,ItemId,$headerid",
           'ItemName' => ['required'],
            'Quantity' =>"required|numeric|min:1|not_in:0'",
            'UnitPrice' =>"required|numeric|min:1|not_in:0'",
           /// 'Discounts' =>"required|numeric",
            //'Type' =>"required|in:rp,ws",
        ]);

        if($validator->passes())
        {

            try{

                $hold=salesHoldDetails::updateOrCreate(['id' => $request->itemid], [
                    'HeaderId'=>$request->HeaderId,
                    'ItemId' => $request->ItemName,
                    'Quantity' => $request->Quantity,
                    'UnitPrice' =>$request->UnitPrice,
                    'Discount' => $request->Discounts,
                    'BeforeTaxPrice' => $request->BeforeTaxPrice,
                    'TaxAmount' => $request->TaxAmount,
                    'TotalPrice' => $request->TotalPrice,
                    'TransactionType'=>'Sales',
                    'ItemType'=>'Goods', 
                    'ConvertedQuantity' => $request->convertedqi,
                    'ConversionAmount' => $request->convertedamnti,
                    'NewUOMId' => $request->newuomi,
                    'DefaultUOMId' => $request->defaultuomi,
                    'StoreId' => $request->storeId,
                    'Common'=>$request->commonId,
                    'DiscountAmount'=>$request->discountiamount,
                    'Dprice'=>$request->defPrice,
                   // 'Username'=>$user,
                  ]);
    
                  $pricing = DB::table('salesholddetails')
            ->select(DB::raw('TRUNCATE(SUM(BeforeTaxPrice),2) as BeforeTaxPrice,TRUNCATE(SUM(TaxAmount),2) as TaxAmount,TRUNCATE(SUM(TotalPrice),2) as TotalPrice,TRUNCATE(SUM(DiscountAmount),2) as DiscountAmount,SUM(Discount) as DiscountPercent'))
            ->where('HeaderId', '=', $headerid)
            ->get();
            $updprice=DB::select('update sales_holds set SubTotal=(SELECT TRUNCATE(SUM(BeforeTaxPrice),2) FROM salesholddetails WHERE HeaderId='.$headerid.'),
            Tax=(SELECT TRUNCATE(SUM(TaxAmount),2) FROM salesholddetails WHERE HeaderId='.$headerid.'),
            GrandTotal=(SELECT TRUNCATE(SUM(TotalPrice),2) FROM salesholddetails WHERE HeaderId='.$headerid.'),
            DiscountAmount=(SELECT TRUNCATE(SUM(DiscountAmount),2) FROM salesholddetails WHERE HeaderId='.$headerid.'),
            DiscountPercent=(SELECT SUM(Discount) FROM salesholddetails WHERE HeaderId='.$headerid.')
            where id='.$headerid.'');

                    // $updprice=DB::select('update sales_holds set SubTotal=(SELECT TRUNCATE(SUM(BeforeTaxPrice),2) FROM salesholddetails WHERE HeaderId='.$headerid.'),
                    // DiscountAmount=(SELECT TRUNCATE(SUM(DiscountAmount),2) FROM salesholddetails WHERE HeaderId='.$headerid.'),
                    // DiscountPercent=(SELECT SUM(Discount) FROM salesholddetails WHERE HeaderId='.$headerid.')
                    // where id='.$headerid.'');

                    // DB::table('sales_holds')
                    // ->where('id', $headerid)
                    // ->update(['Tax'=>(DB::raw('TRUNCATE((sales_holds.SubTotal * 15)/100,2)')),'GrandTotal' =>(DB::raw('ROUND(sales_holds.SubTotal + sales_holds.Tax,2)'))]);



    
            $countitem = DB::table('salesholddetails')->where('HeaderId', '=', $headerid)->get();
            $getCountItem = $countitem->count();
    
            return Response::json(['success' => 'Item Saved','Totalcount'=>$getCountItem,'PricingVal'=>$pricing]);
               // return Response::json(['success' => '1']);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateVatNumber(Request $request)
    {
        $customerid=$request->customerid;
        $vatnumber=$request->vatNumber;
        $witholdNumber=$request->witholdNumber;
        $idup=$request->recieptid;
        $validator = Validator::make($request->all(), [
             //'Recieptnumber' =>"required|unique:sales,vatNumber,$request->recieptid",
            //  'Recieptnumber'=>"nullable|numeric", 
           
            'vatNumber' => ['nullable','regex:/^[0-9\.-]+$/',Rule::unique('sales')->where(function ($query) use($vatnumber,$customerid) {
                return $query->where('vatNumber', $vatnumber)
                ->where('CustomerId', $customerid); 
            })->ignore($idup)],

            'witholdNumber' => ['nullable','regex:/^[0-9\.-]+$/',Rule::unique('sales')->where(function ($query) use($witholdNumber,$customerid) {
                return $query->where('witholdNumber', $witholdNumber)
                ->where('CustomerId', $customerid); 
            })->ignore($idup)],
            
             //'witholdRecieptNumber'=>"nullable|numeric",  
         ]);

         if($validator->passes())
         {
            $id=$request->recieptid;
            $vatNumber=$request->vatNumber;
            $witholdNumber=$request->witholdNumber;
            $vatAmount=$request->vatAmountvalue;
            $witholdAmount=$request->witholdAmountvalue;
            $netpayAmount=$request->netpayvlaue;

            if($vatNumber==null)
            {
              $vatsetle='0';  
            }
            if($vatNumber!=null){
                $vatsetle='1';
            }
            if($witholdNumber==null)
            {
              $witholdsetle='0';  
            }
            if($witholdNumber!=null)
            {
              $witholdsetle='1';  
            }
            try
            {
                $updatestatus= DB::table('sales')
                ->where('id', $id) ->update(['vatNumber' => $vatNumber,'VatSetle'=>$vatsetle,'witholdNumber' => $witholdNumber,'WitholdSetle'=>$witholdsetle,'NetPay'=>$netpayAmount,'vat'=>$vatAmount,'WitholdAmount'=>$witholdAmount]);
               
                return Response::json(['success' => 'Success Fully Updated Vat Number']);
    
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
    public function updateWitholdNumber(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            //'witholdRecieptNumber' =>"required|unique:sales,witholdNumber,$request->witholdRecieptNumberid",
            'witholdRecieptNumber'=>'nullable|numeric', 
        ]);

        if($validator->passes())
        {
            $id=$request->witholdRecieptNumberid;
            $witholdAmount=$request->witholdRecieptNumber;

            if($witholdAmount==null)
            {
              $witholdsetle='1';  
            }
            else{
                $witholdsetle='0';
            }
            try
            {
                $updatestatus= DB::table('sales')
                ->where('id', $id) ->update(['witholdNumber' => $witholdAmount,'WitholdSetle'=>$witholdsetle]);
               return Response::json(['success' => 'Success Fully Updated Withold Number']);
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
    public function showVat($id)
    {
        $saledata=Sales::FindorFail($id);
        $customerid=$saledata->CustomerId;
        $custid=customer::FindorFail($customerid);
        $cvat=$custid->VatType;
        $cwithold=$custid->Witholding;
        return response()->json([
            'saledata'=>$saledata,
            'cvat'=>$cvat,
            'cwithold'=>$cwithold,
        ]);

    }
    public function show($id)
    {
        
        $salhold=SalesHold::FindorFail($id);
        $custid=$salhold->CustomerId;
        $store=$salhold->StoreId;
        $Storeval=store::FindorFail($store);
        $storeName=$Storeval->Name;
        $cust=customer::FindorFail($custid);
        $custname=$cust->Name;
        $custcategory=$cust->CustomerCategory;
        $defualPrice=$cust->DefaultPrice;


        $countitem = DB::table('salesholddetails')->where('HeaderId', '=', $id)
            ->get();
        $getCountItem = $countitem->count();

    $settings = DB::table('settings')->latest()->first();
   $SalesWithHold=$settings->SalesWithHold;
   $ServiceWithHold=$settings->ServiceWithHold;
   $vatDeduct=$settings->vatDeduct;

        return response()->json([
            'salehold'=>$salhold,
            'cname'=>$custname,
            'ccat'=>$custcategory,
            'countitem'=>$getCountItem,
            'SalesWithHold'=>$SalesWithHold,
            'ServiceWithHold'=>$ServiceWithHold,
            'vatDeduct'=>$vatDeduct,
            'storeName'=>$storeName,
            'defualPrice'=>$defualPrice,
           
        ]);
    }
    public function showSale($id)
    {
        $sales=Sales::FindorFail($id);
        $custid=$sales->CustomerId;
        $store=$sales->StoreId;
        $subTotal=$sales->SubTotal;
        $GrandTotal=$sales->GrandTotal;
        $Tax=$sales->Tax;
        $NetPay=$sales->NetPay;
        $WitholdAmount=$sales->WitholdAmount;
        $Vat=$sales->Vat;
        $createdDate=$sales->created_at;
        $createdate=$createdDate->format('Y-m-d');
        $Storeval=store::FindorFail($store);
        $storeName=$Storeval->Name;
        $cust=customer::FindorFail($custid);
        $custname=$cust->Name;
        $custcode=$cust->Code;
        $custTinNumber=$cust->TinNumber;
        $custcategory=$cust->CustomerCategory;
        $defualPrice=$cust->DefaultPrice;
        $custvat=$cust->VatType;
        $custwithold=$cust->Witholding;
       
       

        // session()->put('Retailer',$defualPrice);
        // session()->put('Wholeseller',$defualPrice);

        $countitem = DB::table('salesitems')->where('HeaderId', '=', $id)
            ->get();
        $getCountItem = $countitem->count();

    $settings = DB::table('settings')->latest()->first();
   $SalesWithHold=$settings->SalesWithHold;
   $ServiceWithHold=$settings->ServiceWithHold;
   $vatDeduct=$settings->vatDeduct;

   if($subTotal>=$vatDeduct||$subTotal>=$SalesWithHold)
   {
    $newNetPay=0;
    $newVat=($subTotal*$custvat)/100;
    $newVat=round($newVat,2);
    $newWitholdAmount=($subTotal*$custwithold)/100;
    $newWitholdAmount=round($newWitholdAmount, 2);
    $deduction=$newVat+$newWitholdAmount;
    $deduction=floor(($deduction*100))/100;
    $newNetPay=$GrandTotal-$deduction;
    $newNetPay=round($newNetPay, 2);
    if($GrandTotal==$newNetPay)
    {
        $newNetPay=0;
    }

    $updatesales=DB::table('sales')
    ->where('id', $id)
    ->update(['Netpay'=>$newNetPay,'Vat'=>$newVat,'WitholdAmount'=>$newWitholdAmount,'Tax'=>(DB::raw('TRUNCATE((sales.SubTotal * 15)/100,2)')),'GrandTotal' =>(DB::raw('ROUND(sales.SubTotal + sales.Tax,2)'))]);
   }


   $DiscountPercent = DB::table('salesitems')
            ->select(DB::raw('TRUNCATE(SUM(Discount),2) as DiscountPercent'))
            ->where('HeaderId', '=', $id)
            ->get();
        
         $sale=Sales::FindorFail($id);
        return response()->json([
            'sale'=>$sale,
            'cname'=>$custname,
            'custcode'=>$custcode,
            'custTinNumber'=>$custTinNumber,
            'ccat'=>$custcategory,
            'countItem'=>$getCountItem,
            'SalesWithHold'=>$SalesWithHold,
            'ServiceWithHold'=>$ServiceWithHold,
            'vatDeduct'=>$vatDeduct,
            'storeName'=>$storeName,
            'defualPrice'=>$defualPrice,
            'custvat'=>$custvat,
            'custwithold'=>$custwithold,
            'createdate'=>$createdate,
            //'DiscountPercent'=>$DiscountPercent,
        ]);
    }
    public function showSaleItem($id)
    {
        //$salholdite=salesitem::FindorFail($id);
        $salholdite = DB::table('salesitems')->where('id', $id)->first();
        
        return response()->json([
            'saleholditem'=>$salholdite,
           
        ]);

    }
    public function showholdItem($id)
    {
        $salholdite=salesHoldDetails::FindorFail($id);
        
        return response()->json([
            'saleholditem'=>$salholdite,
           
        ]);

    }
public function showcustomerhold($id)
{
    $salhold=SalesHold::FindorFail($id);
    $custid=$salhold->CustomerId;
    $custhold=customer::FindorFail($custid);
    $custid=$custhold->id;
     $custname=$custhold->Name;

     return ['custid'=>$custid,'custname'=>$custname];


}
public function getCountHold()
{
   //$settings = DB::table('countable')->latest()->first();
    

   $updn=DB::select('update countable set 	salescount=	salescount+1 where id=1');
   $salescounts = DB::table('countable')->latest()->first();
   $settings = DB::table('settings')->latest()->first();
   $SalesWithHold=$settings->SalesWithHold;
   $ServiceWithHold=$settings->ServiceWithHold;
   $vatDeduct=$settings->vatDeduct;
   return response()->json(['salecount'=>$salescounts->salescount,'SalesWithHold'=>$SalesWithHold,'ServiceWithHold'=>$ServiceWithHold,'vatDeduct'=>$vatDeduct]);
}
    // public function showcustomer($id)
    // {
    //     $cust=customer::FindorFail($id);

    //     return response()->json($cust);

    // }

    public function showcustomer($id)
    {
        $cust=customer::FindorFail($id);
        $DefaultPrice=$cust->DefaultPrice;
        $CreditLimit =(float)$cust->CreditLimit;
        $CreditLimitPeriod=$cust->CreditLimitPeriod;
        $colors=null;
        $dprice=null;
        if($DefaultPrice=="Wholeseller") 
        {
            $getTotalSumLimitDay=DB::select('SELECT COALESCE(SUM(sales.SubTotal),0) AS TotalSales FROM sales WHERE sales.CreatedDate>=(CURRENT_DATE()-INTERVAL '.$CreditLimitPeriod.' day) AND sales.CustomerId='.$id.'');
            foreach($getTotalSumLimitDay as $row)
            {
                    $sum=$row->TotalSales;
            }   
            $totalsum = (float)$sum;
            if($totalsum<$CreditLimit)   
            {
                $dprice="Retailer";
                $colors="red";
            } 
            else
            {
                $dprice="Wholeseller";
                $colors="yellow";
            }     
        }
        else
        {
            $dprice=$DefaultPrice;
            $colors="yellow";
        }
        return response()->json(['cust'=>$cust,'dprice'=>$dprice,'colors'=>$colors]);

    }

    public function getConversionAmount($id,$nid)
    {
        $conversion = DB::table('conversions')->where('FromUomID', $id)->where('ToUomID', $nid)->latest()->first();
        $amnt=$conversion->Amount;
        return response()->json(['sid'=>$amnt]);
    }

    public function getAllUoms($itemId)
    {

        $regitems = DB::table('regitems')->where('id', $itemId)->latest()->first();
        $uomid=$regitems->MeasurementId;
        $cnv=uom::find($uomid);
        $defuom=$cnv->Name;
        $conv=DB::select('SELECT t.id,t.FromUomID,w1.Name AS FromUnitName,t.ToUomID,w2.Name AS ToUnitName,t.Amount,t.ActiveStatus FROM conversions AS t JOIN uoms AS w1 on w1.id=t.FromUomID JOIN uoms AS w2 on w2.id=t.ToUomID WHERE t.FromUomID='.$uomid.' AND t.ActiveStatus="Active"');
        
        return response()->json(['sid'=>$conv,'defuom'=>$defuom,'uomid'=>$uomid]);
    }
    // public function showItemInfoCon($itemId,$storeId)
    // {
    //     $ItemId=$itemId;
    //     $columnName="id";
    //     $Regitem=DB::select('SELECT regitems.id,regitems.MeasurementId,regitems.Type,regitems.Code,regitems.Name,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.Maxcost,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus,regitems.wholeSellerMinAmount FROM regitems INNER JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.id='.$itemId);
    //     $settingsval = DB::table('settings')->latest()->first();
    //     $fiscalyr=$settingsval->FiscalYear;
    //     $getQuantity=DB::select('select (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity from transactions where transactions.FiscalYear='.$fiscalyr.' and transactions.StoreId='.$storeId.' and transactions.ItemId='.$itemId.'');

    //     return response()->json(['Regitem'=>$Regitem,'getQuantity'=>$getQuantity]);
    // }

    public function showItemInfoCon($itemId,$storeId)
    {
        $ItemId=$itemId;
        $columnName="id";
        $Regitem=DB::select('SELECT regitems.id,regitems.MeasurementId,regitems.Type,regitems.Code,regitems.Name,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.Maxcost,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus,regitems.wholeSellerMinAmount,regitems.MinimumStock FROM regitems INNER JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.id='.$itemId);
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        $getQuantity=DB::select('SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity from transactions where transactions.FiscalYear='.$fiscalyr.' and transactions.StoreId='.$storeId.' and transactions.ItemId='.$itemId.'');
        $getCheckedPending=DB::select('SELECT COALESCE(SUM(salesitems.ConvertedQuantity),0) AS CheckedQuantity FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN sales ON salesitems.HeaderId=sales.id WHERE sales.Status IN("pending..","Checked") AND salesitems.ItemId='.$itemId.'');
        $getAllQuantity=DB::select('SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AllAvailableQuantity from transactions where transactions.FiscalYear='.$fiscalyr.' and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId='.$itemId.'');

        return response()->json(['Regitem'=>$Regitem,'getQuantity'=>$getQuantity,'getAllQuantity'=>$getAllQuantity,'getCheckedPending'=>$getCheckedPending]);
    }
    
    public function saveholdcopy(Request $request)
    {
        $customerid=$request->customer;
        $vnumber=$request->voucherNumber;
        $idup=$request->id;
        $id=$request->id;
        $storeID=$request->store;
        $commonid=SalesHold::FindorFail($idup);
        $commonVal=$commonid->Common;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $validator = Validator::make($request->all(), [
       // 'customer' => ['required'],
         'paymentType' => ['required'],
         'voucherType' => ['required'],
        'voucherNumber' => ['required'],
        'date' => ['required','before:now'],
        'store' => ['required'],
    
    ]);

    $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM salesholddetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$id.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeID.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
           

    foreach($getApprovedQuantity as $row)
    {
            $avaq=$row->ApprovedItems;
    }
    $avaqp = (float)$avaq;
        if($avaqp>=1)
        {

            $getItemLists=DB::select('SELECT DISTINCT regitems.Name,trs.ItemId AS ApprovedItems,trn.ItemId AS AvailableItems,(select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeID.' AND transactions.FiscalYear='.$fiscalyr.') AS AvailableQuantity FROM salesholddetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$id.' AND 
        (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trn.ItemId AND transactions.StoreId='.$storeID.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
        return Response::json(['valerror' =>  "error",'countedval'=>$avaqp,'countItems'=>$getItemLists]);

        }

        else
        {    
            if ($validator->passes())
            {

                try
                {
                    $wholesalecustomer=$request->Wholesellercustomer;
                    $retailcustomer=$request->Retailcustomer;
                    if($retailcustomer!='')
                    {
                        $CustomerId=$retailcustomer;
                    }
                    if($wholesalecustomer!='')
                    {
                        $CustomerId=$wholesalecustomer;
                    }
                        $sale=Sales::Create([
                        'CustomerId' => trim($CustomerId),
                        'PaymentType' => trim($request->paymentType),
                        'VoucherNumber' =>trim($request->voucherNumber),
                        'VoucherType' => trim($request->voucherType),
                        'CreatedDate' => trim($request->date),
                        'CustomerMRC'=>trim($request->CustomerMRC),
                        'StoreId' => trim($request->store),
                        'SubTotal' => trim($request->subtotali),
                        'Tax' => trim($request->taxi),
                        'GrandTotal' => trim($request->grandtotali),
                        'WitholdAmount' => trim($request->witholdingAmntin),
                        'NetPay' => $request->netpayin,
                        'Vat' => trim($request->vatAmntin),
                       // 'DiscountAmount'=>$request->discountamountli,
                        'Common'=>$request->salecounti,

                        'Status' =>'pending..',
                        ]);
            
                        
            
                        $copy=DB::table('salesitems')->insertUsing(
                        ['ItemId', 'Quantity','Dprice','UnitPrice','Discount','BeforeTaxPrice',
                        'TaxAmount','TotalPrice','StoreId','LocationId','RetailerPrice',
                        'Wholeseller','Date','RequireSerialNumber','RequireExpireDate',
                        'ConvertedQuantity','ConversionAmount','NewUOMId','DefaultUOMId',
                        'IsVoid','Memo','Common','ItemType','TransactionType','DiscountAmount'], // ..., columnN
                        function ($query) use($idup) {
                            $query
                                ->select(['ItemId', 'Quantity','Dprice','UnitPrice','Discount','BeforeTaxPrice',
                                'TaxAmount','TotalPrice','StoreId','LocationId','RetailerPrice',
                                'Wholeseller','Date','RequireSerialNumber','RequireExpireDate',
                                'ConvertedQuantity','ConversionAmount','NewUOMId','DefaultUOMId',
                                'IsVoid','Memo','Common','ItemType','TransactionType','DiscountAmount']) // ..., columnN
                                ->from('salesholddetails')->where('HeaderId', '=',$idup);
                                // optional: you could even add some conditions:
                                // ->where('some_column', '=', 'somevalue')
                                // ->whereNotNull('someColumn')
                        }
                    );
                        
                        // $comn=$request->salecounti;
                        // if($comn!=null){

                        $saleshead = DB::table('sales')->where('Common',$commonVal)->latest()->first();

                        $headerid=$saleshead->id;
                        $updn=DB::select('update salesitems set HeaderId='.$headerid.'	where Common='.$commonVal.'');
                        //     
                        $updprice=DB::select('update sales set DiscountPercent=(SELECT SUM(Discount) FROM salesitems WHERE HeaderId='.$headerid.'),
                        DiscountAmount=(SELECT SUM(DiscountAmount) FROM salesitems WHERE HeaderId='.$headerid.')
                        where id='.$headerid); 
                                                    
                        $deletesolditem=DB::select('DELETE FROM salesholddetails WHERE HeaderId='.$idup);
                        $deletesold=DB::select('DELETE FROM sales_holds WHERE id='.$idup);
            
                     return Response::json(['copySuccess' =>  'yes']);
                        //}

                }catch(Exception $e)
                {
                    return Response::json(['copydberrors' =>  $e->getMessage()]);
                }
                
            } 
            if($validator->fails())
            {
                return Response::json(['errors' => $validator->errors()]);
            }
        }
    
    }
    public function testdata(Request $request )
    {

        $rules = [];

        $result=$request->input('names');


        foreach($result as $key => $value) {
            $rules["names.{$key}"] = 'required';
        }


        $validator = Validator::make($request->all(), $rules);


        if ($validator->passes()) {


            foreach($result as $key => $value) {
                Testm::create(['Name'=>$value]);
            }


            return response()->json(['success'=>'done ']);
        }


        return response()->json(['error'=>$validator->errors()->all()]);
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
    public function saleitemdelete(Request $request,$id)
    {
        $headerid=$request->hid;
        // $deletes=Salesitem::FindorFail($id);
        // $deletes->delete();
        $delete=DB::table('salesitems')->where('id', $id)->delete();

        // $pricing = DB::table('salesitems')
        // ->select(DB::raw('SUM(BeforeTaxPrice) as BeforeTaxPrice,SUM(TaxAmount) as TaxAmount,SUM(TotalPrice) as TotalPrice,SUM(DiscountAmount) as DiscountAmount,SUM(Discount) as DiscountPercent'))
        // ->where('HeaderId', '=', $headerid)
        // ->get();
        $pricing = DB::table('salesitems')
                  ->select(DB::raw('TRUNCATE(SUM(BeforeTaxPrice),2) as BeforeTaxPrice,TRUNCATE(SUM(TaxAmount),2) as TaxAmount,TRUNCATE(SUM(TotalPrice),2) as TotalPrice,TRUNCATE(SUM(DiscountAmount),2) as DiscountAmount ,SUM(Discount) as DiscountPercent'))
                  ->where('HeaderId', '=', $headerid)
                  ->get();

        

                 $updprice=DB::select('update sales set SubTotal=(SELECT TRUNCATE(SUM(BeforeTaxPrice),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                    DiscountAmount=(SELECT TRUNCATE(SUM(DiscountAmount),2) FROM salesitems WHERE HeaderId='.$headerid.'),
                    DiscountPercent=(SELECT SUM(Discount) FROM salesitems WHERE HeaderId='.$headerid.')
                    where id='.$headerid.'');
    
                        DB::table('sales')
                        ->where('id', $headerid)
                        ->update(['Tax'=>(DB::raw('TRUNCATE((sales.SubTotal * 15)/100,2)')),'GrandTotal' =>(DB::raw('ROUND(sales.SubTotal + sales.Tax,2)'))]);
    
      


        $countitem = DB::table('salesitems')->where('HeaderId', '=', $headerid)->get();
        $getCountItem = $countitem->count();

      
     // return Response::json(['success' => '1']);
     return Response::json(['success' => 'Sale item removed','Totalcount'=>$getCountItem,'PricingVal'=>$pricing]);

    }

    public function saleholditemdelete(Request $request,$id)
    {
        $headerid=$request->hid;
        $deletes=salesHoldDetails::FindorFail($id);
        $deletes->delete();

        $pricing = DB::table('salesholddetails')
        ->select(DB::raw('SUM(BeforeTaxPrice) as BeforeTaxPrice,SUM(TaxAmount) as TaxAmount,SUM(TotalPrice) as TotalPrice,SUM(DiscountAmount) as DiscountAmount,SUM(Discount) as DiscountPercent'))
        ->where('HeaderId', '=', $headerid)
        ->get();
        $updprice=DB::select('update sales_holds set SubTotal=(SELECT SUM(BeforeTaxPrice) FROM salesholddetails WHERE HeaderId='.$headerid.'),
        Tax=(SELECT SUM(TaxAmount) FROM salesholddetails WHERE HeaderId='.$headerid.'),
        GrandTotal=(SELECT SUM(TotalPrice) FROM salesholddetails WHERE HeaderId='.$headerid.'),
        DiscountAmount=(SELECT SUM(DiscountAmount) FROM salesholddetails WHERE HeaderId='.$headerid.'),
        DiscountPercent=(SELECT SUM(Discount) FROM salesholddetails WHERE HeaderId='.$headerid.')
        where id='.$headerid.'');

        $countitem = DB::table('salesholddetails')->where('HeaderId', '=', $headerid)->get();
        $getCountItem = $countitem->count();

       // return Response::json(['success' => 'Item Record Deleted success fully']);
       return Response::json(['success' => 'Item Removed','Totalcount'=>$getCountItem,'PricingVal'=>$pricing]);
    }

    public function saleholddelete($id)
    {
    $deletesolditem=DB::select('DELETE FROM salesholddetails WHERE HeaderId='.$id);
    $delete=SalesHold::FindorFail($id);
    $delete->delete();
    
    

    return Response::json(['success' => 'Hold Record Deleted success fully']);

    }
}
