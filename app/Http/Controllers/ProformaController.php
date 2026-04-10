<?php

namespace App\Http\Controllers;


use App\Models\uom;
use App\Models\store;
use App\Models\setting;
use App\Models\customer;
use App\Models\Proforma;
use App\Models\ProformaItem;
use App\Models\Regitem;
use Illuminate\Http\Request;
use App\Models\storeassignment;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProformaController extends Controller
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
        $storeSrc=DB::select('SELECT StoreId,stores.Name as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=5 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        $itemSrc=DB::select('SELECT DISTINCT ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND FiscalYear='.$fiscalyr.' AND StoreId IN(Select StoreId from storeassignments where UserId ='.$userid.' AND storeassignments.Type=4 )');
        $itemSrcs=DB::select('SELECT DISTINCT ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND FiscalYear='.$fiscalyr.' AND StoreId IN(Select StoreId from storeassignments where UserId ='.$userid.' AND storeassignments.Type=4 )');
        $itemSrcss=DB::select('SELECT DISTINCT ItemId,regitems.Name AS ItemName,regitems.Code,regitems.SKUNumber FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND FiscalYear='.$fiscalyr.' AND StoreId IN(Select StoreId from storeassignments where UserId ='.$userid.' AND storeassignments.Type=4 )');
        $mrc=DB::select('SELECT MRCId,companymrcs.MRCNumber as MRCNumber FROM mrcassignments INNER JOIN companymrcs ON mrcassignments.MRCId=companymrcs.id WHERE mrcassignments.UserId="'.$userid.'" AND mrcassignments.Type=1 AND companymrcs.ActiveStatus="Active" AND companymrcs.IsDeleted=1');
        $users=DB::select('select * from users where id>1');
        return view('sales.proforma',['customerSrc'=>$customerSrc,'storeSrc'=>$storeSrc,'itemSrc'=>$itemSrc,'itemSrcs'=>$itemSrcs,'itemSrcss'=>$itemSrcss,'mrc'=>$mrc,'customerSrcr'=>$customerSrcr,'customerSrcw'=>$customerSrcw,'users'=>$users]);

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

    public function proformachildlist($id)
    {
       $proformalist=ProformaItem::join('regitems','regitems.id','=','proforma_regitem.regitem_id')
                                   ->join('uoms','uoms.id','=','proforma_regitem.NewUOMId')
                                   ->where('proforma_regitem.proforma_id','=',$id)     
                                   ->get(['regitems.*','proforma_regitem.*','proforma_regitem.id as proformaid','uoms.Name as UOMName']);  
        if(request()->ajax()) {
        return datatables()->of($proformalist)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {
            $user=Auth()->user();
            $btn='';
            $btn =  $btn.' <a data-id="'.$data->proformaid.'" data-uom=""  class="btn btn-icon btn-gradient-info btn-sm proformaedititem" data-toggle="modal" onclick="proformaitemedit('.$data->proformaid.')" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            $btn = $btn.' <a data-id="'.$data->proformaid.'"  data-hid="" class="btn btn-icon btn-gradient-danger btn-sm proformadeleteitem"  onclick="deleteConfirmation('.$data->proformaid.')" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';  
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }   
    }

    public function proformainfolist($id)
    {
       $proformalist=ProformaItem::join('regitems','regitems.id','=','proforma_regitem.regitem_id')
                                   ->join('uoms','uoms.id','=','proforma_regitem.NewUOMId')
                                   ->where('proforma_regitem.proforma_id','=',$id)     
                                   ->get(['regitems.*','proforma_regitem.*','proforma_regitem.id as proformaid','uoms.Name as UOMName']);  
        if(request()->ajax()) {
        return datatables()->of($proformalist)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {
            $user=Auth()->user();
            $btn='';
            $btn =  $btn.' <a data-code="'.$data->Code.'" data-iname="'.$data->Name.'" class="btn btn-icon btn-icon rounded-circle btn-info btn-sm waves-effect waves-float waves-light docDescInfo" data-toggle="modal" style="color: white;" title="Show Item Description"><i class="fa fa-info"></i></a>'; 
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }   
    }

    public function proformalist()
    {
        $ste=[];
        $user=Auth()->user();
        $userid=Auth()->user()->id;
        $storeid=storeassignment::where('UserId',$userid)->where('Type',5)->get(['StoreId']);
        foreach($storeid as $store){
            $ste[]=$store->StoreId;
        }
        $proforma = Proforma::join('customers', 'customers.id', '=', 'proformas.CustomerId')
        ->join('stores', 'stores.id', '=', 'proformas.store_id')
        ->whereIn('proformas.store_id',$ste)   
        ->get(['customers.*', 'proformas.*','stores.Name AS StoreName','proformas.id as proformaid','proformas.Status AS proformaStatus']);

        if(request()->ajax()) {
            return datatables()->of($proforma)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
              
                $proformaeditlink='';
                $proformavoidlink='';
                $proformaunvoidlink='';

               
                if($data->proformaStatus!='Void'){
                    $proformaeditlink='<a class="dropdown-item proformaedit" data-id="'.$data->proformaid.'" data-toggle="modal" title="Edit">
                    <i class="fa fa-edit"></i><span> Edit</span>
                    </a>';
                    $proformavoidlink='<a class="dropdown-item proformavoid" data-id="'.$data->proformaid.'" title="Void">
                    <i class="fa fa-trash"></i><span> Void</span>  
                    </a>';
                }
               
                if($data->proformaStatus=='Void'){
                    $proformavoidlink='<a class="dropdown-item proformaunvoid" data-id="'.$data->proformaid.'" title="Unvoid">
                    <i class="fa fa-trash"></i><span>Undo-Void </span>  
                    </a>';
                }

                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item DocPrInfo" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title="">
                        <i class="fa fa-info"></i><span> Info</span>  
                    </a>
                    '.$proformaeditlink.'
                    '.$proformavoidlink.'
                    
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
        $proformaHeader=null;
        $settingsval = DB::table('settings')->latest()->first();
        $inc=$settingsval->proformaNumber+1;
        $user=Auth()->user()->username;
        if($request->documentNumber==null){
            $docPrefix=$settingsval->proformaPrefix;
            $docNum=$settingsval->proformaNumber;
            $numberPadding=sprintf("%06d", $docNum);
            $docNumber=$docPrefix.$numberPadding;
        }
        if($request->documentNumber!=null){
            $docNumber=$request->documentNumber;
        }

        $validator = Validator::make($request->all(), [
            'customer' => 'required|numeric',
            'contactPersonName' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'ContactPersonPhone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:15|min:10',
            'orderBy' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'store' => 'numeric',
            'rfqNumber' =>'required|regex:/^[a-zA-Z0-9]+$/',
            'date' => 'required|before:now',
        ]);
        if ($validator->passes()){
                $proforma=Proforma::updateOrCreate(['id' =>$request->proformaid], [
                'CustomerId' => $request->customer,
                'DocumentNumber' =>$docNumber,
                'ContactPerson'=>$request->contactPersonName,
                'ContactPersonPhone'=>$request->ContactPersonPhone,
                'store_id'=>$request->store,
                'RfQNumber'=>$request->rfqNumber,
                'OrderBy'=>$request->orderBy,
                'CreatedDate'=>$request->date,
                'Memo'=>$request->memo,
                'WitholdAmount' =>$request->witholdingAmntin,
                'NetPay' => $request->netpayin,
                'Vat' => $request->vatAmntin,
                'Username'=>$user,
                'Status' =>'pending..',
               ]);
                if($request->proformaid==null){
                   foreach ($request->row as $key => $value){
                    $itemname=$value['ItemId'];
                    $quantity=$value['Quantity'];
                    $store=$value['StoreId'];
                    $UnitPrice=$value['UnitPrice'];
                    $BeforeTaxPrice=$value['BeforeTaxPrice'];
                    $TaxAmount=$value['TaxAmount'];
                    $TotalPrice=$value['TotalPrice'];
                    $ConvertedQuantity=$value['ConvertedQuantity'];
                    $ConversionAmount=$value['ConversionAmount'];
                    $NewUOMId=$value['NewUOMId'];
                    $DefaultUOMId=$value['DefaultUOMId'];
                    $RetailerPrice=$value['retailprice'];
                    $Wholeseller=$value['wholesaleprice'];
                    $ItemType=$value['ItemType'];
                    $Memo=$value['Memo'];
                    $proforma->items()->attach($itemname,
                    ['Quantity'=>$quantity,'store_id'=>$store,'UnitPrice'=>$UnitPrice,'BeforeTaxPrice'=>$BeforeTaxPrice,'TaxAmount'=>$TaxAmount,
                    'TotalPrice'=>$TotalPrice,'ConvertedQuantity'=>$ConvertedQuantity,'ConversionAmount'=>$ConversionAmount,'NewUOMId'=>$NewUOMId,
                    'DefaultUOMId'=>$DefaultUOMId,'ItemType'=>$ItemType,'RetailerPrice'=>$RetailerPrice,'Wholeseller'=>$Wholeseller,'Memo'=>$Memo]);
               }
               $settingUpdate=setting::where('id',1)->update(['proformaNumber'=>$inc]);
               $proformaLatest=Proforma::latest()->first();
               $proformaHeader=$proformaLatest->id;
               $updprice=DB::select('update proformas set SubTotal=(SELECT TRUNCATE(SUM(BeforeTaxPrice),2) FROM proforma_regitem WHERE proforma_id='.$proformaHeader.') where id='.$proformaHeader.'');
               $pricewithtax=DB::table('proformas')->where('id', $proformaHeader)->update(['Tax'=>(DB::raw('TRUNCATE((proformas.SubTotal * 15)/100,2)')),'GrandTotal' =>(DB::raw('ROUND(proformas.SubTotal + proformas.Tax,2)'))]);
            }
            if($request->proformaid!=null){
                $proformaHeader=$request->proformaid;
            }

                  return Response::json(['success' => '1','proformaHeader'=>$proformaHeader]);
        }
            if($validator->fails()){
                return Response::json(['errors' => $validator->errors()]);
            }
        
    }

    public function proformasaveitem(Request $request){
        $user=Auth()->user()->username;
        $regitemid=$request->regitem_id;
        $proformaid=$request->HeaderId;
        $headerid=$request->HeaderId;
        $validator = Validator::make($request->all(), [
             'regitem_id' => ['required',Rule::unique('proforma_regitem')->where(function ($query) use($regitemid,$proformaid) {
                       return $query->where('regitem_id', $regitemid)
                       ->where('proforma_id', $proformaid); 
                       })->ignore($request->itemid)],
            'Quantity' =>"required|numeric|min:1|gt:0",
            'UnitPrice' =>"required|numeric|gt:0",
         ]);
         if($validator->passes()){
            $proformaItem=ProformaItem::updateOrCreate(['id' => $request->itemid], [
                'proforma_id'=>trim($request->HeaderId),
                'regitem_id' => trim($request->regitem_id),
                'Quantity' => trim($request->Quantity),
                'UnitPrice' =>trim($request->UnitPrice),
                'BeforeTaxPrice' =>$request->BeforeTaxPrice,
                'TaxAmount' =>$request->TaxAmount,
                'TotalPrice' =>$request->TotalPrice,
                'TransactionType'=>'Sales',
                'ItemType'=>'Goods',   
                'ConvertedQuantity' => trim($request->convertedqi),
                'ConversionAmount' => trim($request->convertedamnti),
                'NewUOMId' => trim($request->newuomi),
                'DefaultUOMId' => trim($request->defaultuomi),
                'store_id' => trim($request->storeId),
                
            ]);
                $pricing = DB::table('proforma_regitem')
                ->select(DB::raw('TRUNCATE(SUM(BeforeTaxPrice),2) as BeforeTaxPrice,TRUNCATE(SUM(TaxAmount),2) as TaxAmount,TRUNCATE(SUM(TotalPrice),2) as TotalPrice'))
                ->where('proforma_id', '=', $headerid)
                ->get();

                $updprice=DB::select('update proformas set SubTotal=(SELECT TRUNCATE(SUM(BeforeTaxPrice),2) FROM proforma_regitem WHERE proforma_id='.$headerid.') where id='.$headerid.'');

                DB::table('proformas')
                ->where('id', $headerid)
                ->update(['Tax'=>(DB::raw('TRUNCATE((proformas.SubTotal * 15)/100,2)')),'GrandTotal' =>(DB::raw('ROUND(proformas.SubTotal + proformas.Tax,2)'))]);


                  $countitem=ProformaItem::where('proforma_id',$request->HeaderId)->count();
                  return Response::json(['success' => 'Sale item saved',"countitem"=>$countitem,'pricing'=>$pricing]);
         }
         if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
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
     $proformaitem=ProformaItem::FindorFail($id);
     $newoumid=$proformaitem->NewUOMId;
     $uomname=uom::where('id',$newoumid)->first()->Name;
     
     return Response::json(['proformaitem' => $proformaitem,'uomname'=>$uomname]);
    }

    function proformavoid($id){
        $proformavoid=Proforma::where('id',$id)->update(['Status'=>"Void"]);
        if($proformavoid){
            return Response::json(['success' => 'Proforma successfully Voided']);
        } 
    }

    function proformaunvoid($id){
        $proformaunvoid=Proforma::where('id',$id)->update(['Status'=>"pending.."]);
        if($proformaunvoid){
            return Response::json(['success' => 'Proforma successfully undo void']);
        } 
    }
    function getproformainfo($id){
        $proformainfo = Proforma::join('customers', 'customers.id', '=', 'proformas.CustomerId')
                                ->join('stores', 'stores.id', '=', 'proformas.store_id')
                                ->where('proformas.id','=',$id)   
                                ->get(['customers.*', 'proformas.*','stores.Name AS StoreName','proformas.id as proformaid','proformas.Status AS proformaStatus']);
         return Response::json(['success' => 1,
                                "proformainfo"=>$proformainfo]);

    }

    function getItemMemo($id,$itemcode){
       
        $itemid=Regitem::where('Code',$itemcode)->first()->id;
        $proformalist = ProformaItem::where('proforma_regitem.proforma_id','=',$id) 
                        ->where('proforma_regitem.regitem_id','=',$itemid) 
                        ->get(['proforma_regitem.*']);
         return Response::json(['success' => 200,
                                "proformalist"=>$proformalist,'xx'=>$itemid]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proforma=Proforma::FindorFail($id);
        $custid=$proforma->CustomerId;
        $store=$proforma->store_id;
        $subTotal=$proforma->SubTotal;
        $GrandTotal=$proforma->GrandTotal;
        $Tax=$proforma->Tax;
        $NetPay=$proforma->NetPay;
        $WitholdAmount=$proforma->WitholdAmount;
        $Vat=$proforma->Vat;
        $createdDate=$proforma->created_at;
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
        $getCountItem=ProformaItem::where('proforma_id','=',$id)->count();
        $settings = DB::table('settings')->latest()->first();
        $SalesWithHold=$settings->SalesWithHold;
        $ServiceWithHold=$settings->ServiceWithHold;
        $vatDeduct=$settings->vatDeduct;
        return response()->json([
            'proforma'=>$proforma,
            'vatDeduct'=>$vatDeduct,
            'SalesWithHold'=>$SalesWithHold,
            'ServiceWithHold'=>$ServiceWithHold,
            'storeName'=>$storeName,
            'createdate'=>$createdate,
            'getCountItem'=>$getCountItem,
            'custwithold'=>$custwithold,
            'custvat'=>$custvat,
            
        ]);

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
       
        $getheader=ProformaItem::where('id',$id)->first()->proforma_id;
        $headerid=$getheader;
        $countitem=ProformaItem::where('proforma_id',$getheader)->count();
       if($countitem>1){
        $delete=ProformaItem::where('id',$id)->delete();
        $pricing = DB::table('proforma_regitem')
        ->select(DB::raw('TRUNCATE(SUM(BeforeTaxPrice),2) as BeforeTaxPrice,TRUNCATE(SUM(TaxAmount),2) as TaxAmount,TRUNCATE(SUM(TotalPrice),2) as TotalPrice'))
        ->where('proforma_id', '=', $headerid)
        ->get();

        $updprice=DB::select('update proformas set SubTotal=(SELECT TRUNCATE(SUM(BeforeTaxPrice),2) FROM proforma_regitem WHERE proforma_id='.$headerid.') where id='.$headerid.'');

        DB::table('proformas')
        ->where('id', $headerid)
        ->update(['Tax'=>(DB::raw('TRUNCATE((proformas.SubTotal * 15)/100,2)')),'GrandTotal' =>(DB::raw('ROUND(proformas.SubTotal + proformas.Tax,2)'))]);

        $countitemreturn=ProformaItem::where('proforma_id',$getheader)->count();
        return response()->json([
            'success'=>"Successfully deleted Item",
            'getheader'=>$getheader,
            'countitem'=>$countitemreturn,
            'pricing'=>$pricing,   
         ]);
       }
       else{
        $countitemreturn=ProformaItem::where('proforma_id',$getheader)->count();
        return response()->json([
            'error'=>"You can not delete all items",
            'getheader'=>$getheader,
            'countitem'=>$countitemreturn,
              
        ]);
       }
        
       
    }
}
