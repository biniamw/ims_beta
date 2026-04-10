<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\mrc;
use App\Models\blacklist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Response;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counrtys=DB::select('select Name from country order by Name asc');
        $vats=DB::select('select * from vat');
        $witholds=DB::select('select * from withold');
        $customerval=DB::select('select * from customers where customers.id>1 order by Name asc');
        return view('registry.partner',['counrtys'=>$counrtys,'vats'=>$vats,'witholds'=>$witholds,'customerval'=>$customerval]);
    }

    public function showCustomerData()
    {
        $cus=DB::select('select * from customers where id>1 and IsDeleted=1 and CustomerCategory="Partner" order by id desc');
        if(request()->ajax()) {
            return datatables()->of($cus)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $infobtn='';
                $editbtn='';
                $addmrcln='';
                $deleteln='';
                if($data->ActiveStatus=='Active'&&$data->MRCNumber!='')
                {
                    $infobtn='<a class="dropdown-item customerInfo" data-id="'.$data->id.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span> </a>';
                    if($user->can('Partner-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editCustomer" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Customer-MRC'))
                    {
                        $addmrcln=' <a class="dropdown-item" data-id="'.$data->id.'"  data-name="'.$data->Name.'"  data-mrc="'.$data->MRCNumber.'" data-toggle="modal" id="smallButton" data-target="#MRCRegModal" title="Show MRC Under this Customer"><i class="fa fa-plus"></i><span> Add MRC No.</span></a>';
                    }
                    if($user->can('Partner-Delete'))
                    {
                        $deleteln='<a class="dropdown-item" data-id="'.$data->id.'" data-toggle="modal" id="smallButton" data-target="#examplemodal-cusdelete" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Delete</span></a>';
                    }
                }
                if($data->ActiveStatus=='Active'&&$data->MRCNumber=='')
                {
                    $infobtn='<a class="dropdown-item customerInfo" data-id="'.$data->id.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span> </a>';
                    if($user->can('Partner-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editCustomer" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $addmrcln=' ';
                    if($user->can('Partner-Delete'))
                    {
                        $deleteln='<a class="dropdown-item" data-id="'.$data->id.'" data-toggle="modal" id="smallButton" data-target="#examplemodal-cusdelete" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Delete</span></a>';
                    }
                }
                else if($data->ActiveStatus=='Blacklist')
                {
                    $infobtn='<a class="dropdown-item customerInfo" data-id="'.$data->id.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span> </a>';
                    $editbtn='';
                    $addmrcln='';
                    $deleteln='';
                }
                else if($data->ActiveStatus=='Inactive')
                {
                    $infobtn='<a class="dropdown-item customerInfo" data-id="'.$data->id.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span> </a>';
                    if($user->can('Partner-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editCustomer" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $addmrcln='';
                    if($user->can('Partner-Delete'))
                    {
                        $deleteln='<a class="dropdown-item" data-id="'.$data->id.'" data-toggle="modal" id="smallButton" data-target="#examplemodal-cusdelete" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Delete</span></a>';
                    }
                }
                else if($data->ActiveStatus=='Block')
                {
                    $infobtn='<a class="dropdown-item customerInfo" data-id="'.$data->id.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span> </a>';
                    if($user->can('Partner-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editCustomer" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $addmrcln='';
                    $deleteln='';
                }
                $btn='<div class="btn-group dropleft">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                    '.$infobtn.'
                    '.$addmrcln.'
                    '.$editbtn.'
                    '.$deleteln.'
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showMrcData($id)
    {
        $CustomerId=$id;
        $columnName="CustomerId";
        $mrc=mrc::select('id','CustomerId','MRCNumber','ActiveStatus')->where($columnName,'=',$id)->get();
        return datatables()->of($mrc)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                 $btn =  ' <a data-id="'.$data->id.'" data-customerid="'.$data->CustomerId.'" data-mrcnumber="'.$data->MRCNumber.'" data-status="'.$data->ActiveStatus.'" class="btn btn-icon btn-gradient-info btn-sm" data-toggle="modal" id="mediumButton" data-target="#examplemodal-mrcedit" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                 $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#examplemodal-mrcdelete" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                 return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showBlacklistData()
    {
        $cus=DB::select('select * from blacklists order by id desc');
        if(request()->ajax()) {
            return datatables()->of($cus)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editln='';
                if($user->can('Blacklist-Edit'))
                {
                    $editln=' <a class="dropdown-item editBlacklist" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                }
                $btn='<div class="btn-group dropleft">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item blInfo" data-id="'.$data->id.'" data-name="'.$data->Name.'" data-toggle="modal" id="dtinfobtn" title="">
                        <i class="fa fa-info"></i><span> Info</span>  
                    </a>
                    '.$editln.'
                    <a class="dropdown-item" data-id="'.$data->id.'" data-name="'.$data->Name.'" data-toggle="modal" id="smallButton" data-target="#examplemodal-bldelete" data-attr="" title="Delete Record">
                        <i class="fa fa-trash"></i><span> Delete</span>  
                    </a>
                </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

    }

    public function getCustomerCodeCon()
    {
        $settings = DB::table('settings')->latest()->first();
        $ctype=$settings->PartnerCodeType;
        $cprefix=$settings->PartnerCodePrefix;
        $cnumber=$settings->PartnerCodeNumber;
        $numberPadding=sprintf("%06d", $cnumber);
        $cuscode=$cprefix.$numberPadding;
        return response()->json(['cuscode'=>$cuscode,'ctype'=>$ctype]);
    }


    public function showCustomerOnBl($cusname)
    {
        $CustomerName=$cusname;
        $columnName="Name";
        $customer=customer::select('Code','TinNumber','VatNumber')->where($columnName,'=',$cusname)->get();
        return response()->json($customer);
    }

    public function showCustomerInfoData($id)
    {
        $ids=$id;
        $cusHeader=DB::select('select * from customers where customers.id='.$id);
        return response()->json(['cusHeader'=>$cusHeader]);       
    }

    public function showBlInfoData($id)
    {
        $ids=$id;
        $blHeader=DB::select('select * from blacklists where blacklists.id='.$id);
        return response()->json(['blHeader'=>$blHeader]);       
    }

    public function showCusDetailData($id)
    {
        $detailTable=DB::select('SELECT MRCNumber from customers WHERE customers.id='.$id.' UNION SELECT MRCNumber from mrcs WHERE mrcs.CustomerId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showBlDetailData($id)
    {
        $mrccusname = DB::table('customers')->where('Name', $id)->latest()->first();
        $cusid=$mrccusname->id;
        $detailTable=DB::select('SELECT MRCNumber from customers WHERE customers.id='.$cusid.' UNION SELECT MRCNumber from mrcs WHERE mrcs.CustomerId='.$cusid);
        return datatables()->of($detailTable)
        ->addIndexColumn()
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $codeType=$request->codetypeinput;
        $validator = Validator::make($request->all(), [
            'name' => ['required','max:255','min:2','unique:customers,Name'],
            'CustomerId' => ['required','max:255','min:1','unique:customers,Code'],
            'CustomerCategory' => ['required','max:255','min:2'],
            'TinNumber' => ['unique:customers,TinNumber'],
            'PhoneNumber' => ['unique:customers,PhoneNumber'],
            'OfficePhoneNumber' => ['unique:customers,OfficePhone'],
            'EmailAddress' => ['unique:customers,EmailAddress'],
            'Website' => ['unique:customers,Website'],
            'CustomerStatus' => ['required','string','max:255','min:2'],  
        ]);
         if ($validator->passes()) {
          $cus=new customer;
          $cus->Name=trim($request->input('name'));
          $cus->Code=trim($request->input('CustomerId'));
          $cus->CustomerCategory=trim($request->input('CustomerCategory'));
          //$cus->DefaultPrice=trim($request->input('DefaultPayment'));
          $cus->DefaultPrice=trim($request->input('dprice'));
          $cus->TinNumber =trim($request->input('TinNumber'));
          $cus->VatNumber =trim($request->input('VatNumber'));
          $cus->MRCNumber =trim($request->input('MrcNumber'));
          $cus->VatType=trim($request->input('VatDeduct'));
          $cus->Witholding=trim($request->input('WitholdDeduct'));
          $cus->PhoneNumber =trim($request->input('PhoneNumber'));
          $cus->OfficePhone =trim($request->input('OfficePhoneNumber'));
          $cus->EmailAddress =trim($request->input('EmailAddress'));
          $cus->Address=trim($request->input('Address'));
          $cus->Website =trim($request->input('Website'));
          $cus->Country=trim($request->input('Country'));
          $cus->Memo=trim($request->input('Memo'));
          $cus->ActiveStatus=trim($request->input('CustomerStatus'));
          $cus->Reason=trim($request->input('Reason'));
          $cus->IsDeleted=1;
          $cus->save();
          if($codeType==1)
          {
            $updn=DB::select('update settings set PartnerCodeNumber=PartnerCodeNumber+1 where id=1');
          }
          return Response::json(['success' => '1']);
         }
        return Response::json(['errors' => $validator->errors()]);
    }


    public function storeMRC(Request $request)
    {
       $cusid=trim($request->input('customerid'));
        $validator = Validator::make($request->all(), [
            'MrcNumber'=>'required|min:10|max:10|unique:mrcs,MRCNumber|unique:customers,MRCNumber|unique:companymrcs,MRCNumber',
            'status' => ['required','string','max:255','min:2'],
        ]);
         if ($validator->passes()) 
         {
            $mrc=new mrc;
            $mrc->CustomerId=trim($request->input('customerid'));
            $mrc->MRCNumber=trim($request->input('MrcNumber'));
            $mrc->ActiveStatus=trim($request->input('status'));
            $mrc->IsDeleted=1;
            $mrc->save();
            return Response::json(['success' => '1']);
         }
        return Response::json(['errors' => $validator->errors()]);
    }

    public function storeBlacklist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','max:255','min:2','unique:blacklists,Name'],
            'CustomerId' => ['required','max:255','min:1','unique:blacklists,Code'],
            'TinNumber' => ['unique:blacklists,TinNumber'],
            'VatNumber' => ['unique:blacklists,VatNumber'],
            'PhoneNumber' => ['unique:blacklists,PhoneNumber'],
            'OfficePhoneNumber' => ['unique:blacklists,OfficePhone'],
            'EmailAddress' => ['unique:blacklists,EmailAddress'],
            'Website' => ['unique:blacklists,Website'],
        ]);
         if ($validator->passes()) {
          $bl=new blacklist;
          $bl->Name=trim($request->input('name'));
          $bl->Code=trim($request->input('CustomerId'));
          $bl->TinNumber =trim($request->input('TinNumber'));
          $bl->VatNumber =trim($request->input('VatNumber'));
          $bl->PhoneNumber =trim($request->input('PhoneNumber'));
          $bl->OfficePhone =trim($request->input('OfficePhoneNumber'));
          $bl->EmailAddress =trim($request->input('EmailAddress'));
          $bl->Address=trim($request->input('Address'));
          $bl->Website =trim($request->input('Website'));
          $bl->Country=trim($request->input('Country'));
          $bl->Memo=trim($request->input('Memo'));
          $bl->save();
          $cname=$request->name;
          $upcus=DB::select("UPDATE customers SET ActiveStatus='Blacklist' WHERE Name='$cname'");
          return Response::json(['success' => '1']);
         }
        return Response::json(['errors' => $validator->errors()]);
    }

    public function updateCutomer(Request $request)
    {
        $recordId=$request->id;
        $validator = Validator::make($request->all(), [
            'name'=>"required|max:255|min:2|unique:customers,Name,$recordId",
            'CustomerId'=>"required|max:255|min:2|unique:customers,Code,$recordId",
            'CustomerCategory' => ['required','max:255','min:2'],
            'TinNumber'=>"required_if:CustomerCategory,Customer,Customer&Supplier,Supplier|unique:customers,TinNumber,$recordId",
            'VatNumber'=>"unique:customers,VatNumber,$recordId",
            'MrcNumber'=>"required_if:CustomerCategory,Customer&Supplier,Supplier|unique:customers,MRCNumber,$recordId|unique:mrcs,MRCNumber|unique:companymrcs,MRCNumber",
            'PhoneNumber'=>"unique:customers,PhoneNumber,$recordId",
            'OfficePhoneNumber'=>"unique:customers,OfficePhone,$recordId",
            'EmailAddress'=>"unique:customers,EmailAddress,$recordId",
            'Website'=>"unique:customers,Website,$recordId",
            'CustomerStatus' => ['required','string','max:255','min:2'],  
        ]);

        if ($validator->passes()) 
        {
            $cus=customer::FindorFail($recordId);
            $cus->Name=trim($request->input('name'));
            $cus->Code=trim($request->input('CustomerId'));
            $cus->CustomerCategory=trim($request->input('CustomerCategory'));
            //$cus->DefaultPrice=trim($request->input('DefaultPayment'));
            $cus->DefaultPrice=trim($request->input('dprice'));
            $cus->TinNumber =trim($request->input('TinNumber'));
            $cus->VatNumber =trim($request->input('VatNumber'));
            $cus->MRCNumber =trim($request->input('MrcNumber'));
            $cus->VatType=trim($request->input('VatDeduct'));
            $cus->Witholding=trim($request->input('WitholdDeduct'));
            $cus->PhoneNumber =trim($request->input('PhoneNumber'));
            $cus->OfficePhone =trim($request->input('OfficePhoneNumber'));
            $cus->EmailAddress =trim($request->input('EmailAddress'));
            $cus->Address=trim($request->input('Address'));
            $cus->Website =trim($request->input('Website'));
            $cus->Country=trim($request->input('Country'));
            $cus->Memo=trim($request->input('Memo'));
            $cus->ActiveStatus=trim($request->input('CustomerStatus'));
            $cus->Reason=trim($request->input('Reason'));
            $cus->save();
            return Response::json(['success' => '1']);
        }

        return Response::json(['errors' => $validator->errors()]);
    }

    public function updateMRC(Request $request)
    {
        $findid=$request->id;
        $findcusid=$request->CustomerId;
        $mrc=mrc::find($findid);
        $customer=customer::find($findcusid);
        $validator = Validator::make($request->all(), [
        'mrcnumber'=>"required|min:10|max:10|unique:mrcs,MRCNumber,$findid|unique:customers,MRCNumber|unique:companymrcs,MRCNumber",
        'status'=>"required|min:2|max:255",
        ]);
        if ($validator->passes()) 
        {
            $mrc->MRCNumber=trim($request->input('mrcnumber'));
            $mrc->ActiveStatus=trim($request->input('status'));
            $mrc->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function updateBlacklist(Request $request)
    {
        $recordId=$request->id;

        $validator = Validator::make($request->all(), [
            'name'=>"required|max:255|min:2|unique:blacklists,Name,$recordId",
            'CustomerId'=>"required|max:255|min:2|unique:blacklists,Code,$recordId",
            'TinTumber'=>"unique:blacklists,TinNumber,$recordId",
            'VatNumber'=>"unique:blacklists,VatNumber,$recordId",
            'PhoneNumber'=>"unique:blacklists,PhoneNumber,$recordId",
            'OfficePhoneNumber'=>"unique:blacklists,OfficePhone,$recordId",
            'EmailAddress'=>"unique:blacklists,EmailAddress,$recordId",
            'Website'=>"unique:blacklists,Website,$recordId",
        ]);

        if ($validator->passes()) 
        {
          $bl=blacklist::FindorFail($recordId);
          $bl->Name=trim($request->input('name'));
          $bl->Code=trim($request->input('CustomerId'));
          $bl->TinNumber =trim($request->input('TinNumber'));
          $bl->VatNumber =trim($request->input('VatNumber'));
          $bl->PhoneNumber =trim($request->input('PhoneNumber'));
          $bl->OfficePhone =trim($request->input('OfficePhoneNumber'));
          $bl->EmailAddress =trim($request->input('EmailAddress'));
          $bl->Address=trim($request->input('Address'));
          $bl->Website =trim($request->input('Website'));
          $bl->Country=trim($request->input('Country'));
          $bl->Memo=trim($request->input('Memo'));
          $bl->save();
          $cname=$request->name;
          $upcus=DB::select("UPDATE customers SET ActiveStatus='Blacklist' WHERE Name='$cname'");
          return Response::json(['success' => '1']);
        }
        return Response::json(['errors' => $validator->errors()]);
    }

    public function getAllCustomerCon()
    {
        $cus=DB::select('select * from customers where customers.id>1 and customers.CustomerCategory IN("Supplier","Customer&Supplier") order by customers.Name asc');
        return response()->json(['cus'=>$cus]);    
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
        $cust = customer::find($id);
        return response()->json($cust);
    }

    public function editBlacklist($id)
    {
        //
        $blist = blacklist::find($id);
        return response()->json($blist);
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

    public function delete($id)
    {
        $child=DB::select('select * from mrcs where CustomerId='.$id.'');
        $receiving=DB::select('select * from receivings where CustomerId='.$id.'');
        $receivinghold=DB::select('select * from receivingholds where CustomerId='.$id.'');
        $sales=DB::select('select * from sales where CustomerId='.$id.'');
        $saleshold=DB::select('select * from sales_holds where CustomerId='.$id.'');

       if($child==null&&$receiving==null&&$receivinghold==null&& $sales==null&&$saleshold==null)
       {
            $customer = customer::find($id);
            $customer->delete();
            return Response::json(['success' => 'Customer Record Deleted Successfully']);
       }
       return Response::json(['errors' => 'There is some record saved with this customer']);
       
    }

    public function deleteMRC($id)
    {
        $mrc = mrc::find($id);
        $mrcnum=$mrc->MRCNumber;
        $receiving=DB::select('select * from receivings where CustomerMRC='.$mrcnum.'');
        $receivinghold=DB::select('select * from receivingholds where CustomerMRC='.$mrcnum.'');
        if($receiving==null&&$receivinghold==null)
        {
            $mrc->delete();
            return Response::json(['success' => 'MRC Record Deleted success fully']);
        }
        return Response::json(['errors' => 'There is some record saved with this MRC Number']);
    }

    public function deleteBlackList(Request $request, $id)
    {
        $cname=$request->input('name');
        $upcus=DB::select("UPDATE customers SET ActiveStatus='Active' WHERE Name='$cname'");
        $blacklist = blacklist::find($id);
        $blacklist->delete();
        return Response::json(['success' => 'Blacklist Record Deleted success fully',$cname]);
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
