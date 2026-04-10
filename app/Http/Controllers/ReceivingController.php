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
use App\Models\serialandbatchnum_temp;
use App\Models\serialandbatchnum;
use App\Models\transaction;
use App\Models\uom;
use App\Models\conversion;
use App\Models\store;
use App\Models\PurchaseOrder;
use App\Models\purchaseOrderDetails;
use App\Models\Purchasevaulation;
use App\Models\rfq;
use App\Models\purchaseRequest;
use App\Models\actions;
use App\Models\documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;

class ReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $users = Auth()->user();
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr = $settingsval->FiscalYear;
        $recpage = $settingsval->ReceivingMode;
        $isPoAmntAuth = 0;
        $receiving_mode = 0;
        $curdate = Carbon::today()->toDateString();
        $setting = DB::table('settings')->latest()->first();
        $customerSrc = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.CustomerCategory NOT IN("Customer","Person") AND customers.ActiveStatus="Active" AND customers.IsDeleted=1 ORDER BY customers.Name ASC');
        $storeSrc = DB::select('SELECT DISTINCT StoreId,stores.Name AS StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=1 AND stores.ActiveStatus="Active" AND stores.IsDeleted=1');

        $purchaser = DB::select('SELECT * FROM users WHERE users.id>1 AND users.IsPurchaser=1 ORDER BY users.username ASC');
        $fiscalyears = DB::select('SELECT * FROM fiscalyear WHERE fiscalyear.FiscalYear<='.$fiscalyr.' ORDER BY fiscalyear.FiscalYear DESC');
        
        if($recpage == 0){
            $brand = DB::select('SELECT * FROM brands WHERE brands.ActiveStatus="Active" AND brands.IsDeleted=1');
            $itemSrcs = DB::select('SELECT regitems.id,regitems.Type,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items FROM regitems WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND regitems.IsDeleted=1 ORDER BY regitems.Name ASC');
            $storefilter = DB::select('SELECT DISTINCT StoreId AS store_id,stores.Name AS store_name FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=1 AND stores.IsDeleted=1');
            $ref_type_data = DB::select('SELECT * FROM lookuprefs WHERE lookuprefs.Type=100 AND lookuprefs.Status=1 ORDER BY lookuprefs.LookupName ASC'); 
            $doc_type_data = DB::select('SELECT * FROM lookuprefs WHERE lookuprefs.Type=101 AND lookuprefs.Status=1 ORDER BY lookuprefs.id ASC'); 
            $vats = DB::select('SELECT * FROM vat');
            $witholds = DB::select('SELECT * FROM withold');
            $uses_data = DB::select('SELECT * FROM users WHERE id>1 ORDER BY users.username ASC');
            $proc_data = DB::select('SELECT "po" AS type,purchaseorders.id AS rec_id,purchaseorders.customers_id AS supplier_id,CONCAT_WS(", ",NULLIF(purchaseorders.porderno, ""), NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS proc_data FROM purchaseorders LEFT JOIN customers ON purchaseorders.customers_id=customers.id WHERE purchaseorders.purchaseordertype="Goods" AND purchaseorders.status=3 AND purchaseorders.isfullyreceived IN(0,2,3) UNION SELECT "pi" AS type,purchaseinvoices.id AS rec_id,supplier AS supplier_id,CONCAT_WS(", ",NULLIF(purchaseinvoices.docno, ""), NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS proc_data FROM purchaseinvoices LEFT JOIN customers ON purchaseinvoices.supplier=customers.id WHERE purchaseinvoices.status=3 ORDER BY rec_id ASC');

            $receiving_data = [
                'setting' => $setting,'customerSrc' => $customerSrc,'storeSrc' => $storeSrc,'itemSrcs' => $itemSrcs,
                'purchaser' => $purchaser,'user' => $user,'brand' => $brand,'fiscalyears' => $fiscalyears,
                'curdate' => $curdate,'vats' => $vats,'witholds' => $witholds,'fiscalyr' => $fiscalyr,'storefilter' => $storefilter,
                'doc_type_data' => $doc_type_data,'ref_type_data' => $ref_type_data,'receiving_mode' => $receiving_mode,'uses_data' => $uses_data,
                'proc_data' => $proc_data
            ];

            if($request->ajax()){
                return view('inventory.receiving',$receiving_data)->renderSections()['content'];
            }
            else{
                return view('inventory.receiving',$receiving_data);
            }
        }
        else if($recpage == 1){
            $origin = DB::select('SELECT woredas.id,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS CommType FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id WHERE woredas.status="Active"');
            $poCommDataSrc = DB::select('SELECT purchaseordersdetails.id AS DetailId,purchaseordersdetails.purchaseorder_id,CONCAT(purchaseordersdetails.cropyear,"-",purchaseordersdetails.proccesstype,"-",purchaseordersdetails.uom) AS PurDetailProp,woredas.id AS CommId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,woredas.Type AS CommType FROM purchaseordersdetails LEFT JOIN woredas ON purchaseordersdetails.itemid=woredas.id INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id ORDER BY woredas.Woreda_Name ASC');
            $poGoodsDataSrc = DB::select('SELECT DISTINCT purchaseordersdetails.purchaseorder_id,regitems.id,regitems.Name FROM purchaseordersdetails INNER JOIN regitems ON purchaseordersdetails.itemid=regitems.id ORDER BY regitems.Name ASC');
            $commtypedata = DB::select('SELECT lookups.CommodityTypeValue,lookups.CommodityType FROM lookups WHERE lookups.CommodityTypeStatus="Active"');
            $cropyeardata = DB::select('SELECT lookups.CropYearValue,lookups.CropYear FROM lookups WHERE lookups.CropYearStatus="Active"');
            $prctypedata = DB::select('SELECT lookups.ProcessTypeValue,lookups.ProcessType FROM lookups WHERE lookups.ProcessTypeStatus="Active"');
            $gradedata = DB::select('SELECT lookups.GradeValue,lookups.Grade FROM lookups WHERE lookups.GradeStatus="Active"');
            $commsrcdata = DB::select('SELECT lookups.CommoditySourceValue,lookups.CommoditySource FROM lookups WHERE lookups.CommoditySourceStatus="Active"');
            $productTypedata = DB::select('SELECT lookups.ProductTypeValue,lookups.ProductType FROM lookups WHERE lookups.ProductTypeStatus="Active"');
            $receivingTypedata = DB::select('SELECT lookups.ReceivingTypeValue,lookups.ReceivingType FROM lookups WHERE lookups.ReceivingTypeStatus="Active"');
            $uomdata = DB::select('SELECT * FROM uoms WHERE uoms.ActiveStatus="Active"');
            $locationdata = DB::select('SELECT * FROM locations WHERE locations.ActiveStatus="Active"');
            $customerdatasrc = DB::select('SELECT * FROM customers WHERE CustomerCategory IN("Customer","Customer&Supplier") AND customers.ActiveStatus="Active" AND customers.IsDeleted=1 ORDER BY customers.Name ASC');

            if($users->can('Receiving-Adjust-PO-Amount')){
                $isPoAmntAuth = 1;
            }  
            else{
                $isPoAmntAuth = 0;
            }

            if($request->ajax()) {
                return view('inventory.receivingproc',['setting'=>$setting,'customerSrc'=>$customerSrc,'storeSrc'=>$storeSrc,'itemSrc'=>$itemSrc,'itemSrcs'=>$itemSrcs,'itemSrcAddHold'=>$itemSrcAddHold,
                'purchaser'=>$purchaser,'user'=> $user,'brand'=>$brand,'fiscalyears'=>$fiscalyears,'itemSrced'=>$itemSrced,'itemSrcedho'=>$itemSrcedho,'curdate'=>$curdate,'counrtys'=>$counrtys,'vats'=>$vats,
                'witholds'=>$witholds,'customerdatasrc'=>$customerdatasrc,'locationdata'=>$locationdata,'uomdata'=>$uomdata,'origin'=>$origin,'poCommDataSrc'=>$poCommDataSrc,'poGoodsDataSrc'=>$poGoodsDataSrc,
                'isPoAmntAuth'=>$isPoAmntAuth,'commtypedata'=>$commtypedata,'cropyeardata'=>$cropyeardata,'prctypedata'=>$prctypedata,'gradedata'=>$gradedata,'commsrcdata'=>$commsrcdata,'productTypedata'=>$productTypedata,
                'receivingTypedata'=>$receivingTypedata])->renderSections()['content'];
            }
            else{
                return view('inventory.receivingproc',['setting'=>$setting,'customerSrc'=>$customerSrc,'storeSrc'=>$storeSrc,'itemSrc'=>$itemSrc,'itemSrcs'=>$itemSrcs,'itemSrcAddHold'=>$itemSrcAddHold,
                'purchaser'=>$purchaser,'user'=> $user,'brand'=>$brand,'fiscalyears'=>$fiscalyears,'itemSrced'=>$itemSrced,'itemSrcedho'=>$itemSrcedho,'curdate'=>$curdate,'counrtys'=>$counrtys,'vats'=>$vats,
                'witholds'=>$witholds,'customerdatasrc'=>$customerdatasrc,'locationdata'=>$locationdata,'uomdata'=>$uomdata,'origin'=>$origin,'poCommDataSrc'=>$poCommDataSrc,'poGoodsDataSrc'=>$poGoodsDataSrc,
                'isPoAmntAuth'=>$isPoAmntAuth,'commtypedata'=>$commtypedata,'cropyeardata'=>$cropyeardata,'prctypedata'=>$prctypedata,'gradedata'=>$gradedata,'commsrcdata'=>$commsrcdata,'productTypedata'=>$productTypedata,
                'receivingTypedata'=>$receivingTypedata]);
            }
        }
    }

    //---------------------Start Receiving with Procurement---------------------------
    public function saveProcReceiving(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->receivingId;
        $findid=$request->receivingId;
        $recprop=receiving::find($findid);
        $statusval = $recprop->Status ?? "None";
        $companytype = $request->CompanyType;
        $prtype = $request->ProductType;
        $product_type = $request->ProductType == "Commodity" ? 1 : 2;
        $PoDocumentNumber=null;
        $RecDocumentNumber=null;
        $fileNameDoc=null;
        $customerid=1;
        $currentdocnum=null;
        $actions =null;
        $rules = null;
        $prdIds=[];
        $detids=[];
        $rec_detail_data=[];
        $commstflag=0;
        $poreceiveflag=0;
        $poid = $request->PONumber;
        $purid=$recprop->PoId ?? 0;
        $poid = !empty($poid) ? $poid : 0;
        $purid = !empty($purid) ? $purid : 0;
        

        if($companytype == 1){
            $recpropdata = receiving::where('CompanyType',1)->where('fiscalyear',$fyear)->latest()->first();
            $RecDocumentNumber = $settings->ProcReceivingOwnerPrefix.sprintf("%05d",($recpropdata->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum = ($recpropdata->CurrentDocumentNumber ?? 0)+1;

            if($findid != null){
                $recprop = receiving::where('id',$findid)->where('fiscalyear',$fyear)->latest()->first();
                if($recprop->CompanyType == 2){
                    $recpropedit = receiving::where('CompanyType',1)->where('fiscalyear',$fyear)->latest()->first();
                    $RecDocumentNumber = $settings->ProcReceivingOwnerPrefix.sprintf("%05d",($recpropedit->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum = ($recpropedit->CurrentDocumentNumber ?? 0)+1;
                }
                if($recprop->CompanyType == 1){
                    $RecDocumentNumber = $recprop->DocumentNumber;
                    $currentdocnum = $recprop->CurrentDocumentNumber;
                }
            }
        }
        else if($companytype == 2){
            $recpropdata = receiving::where('CompanyType',2)->where('fiscalyear',$fyear)->latest()->first();
            $RecDocumentNumber = $settings->ProcReceivingCustomerPrefix.sprintf("%05d",($recpropdata->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
            $currentdocnum = ($recpropdata->CurrentDocumentNumber ?? 0)+1;

            if($findid != null){
                $recprop = receiving::where('id',$findid)->where('fiscalyear',$fyear)->latest()->first();
                if($recprop->CompanyType == 1){
                    $recpropedit = receiving::where('CompanyType',2)->where('fiscalyear',$fyear)->latest()->first();
                    $RecDocumentNumber = $settings->ProcReceivingOwnerPrefix.sprintf("%05d",($recpropedit->CurrentDocumentNumber ?? 0)+1)."/".($settings->FiscalYear-2000)."-".($settings->FiscalYear-1999);
                    $currentdocnum = ($recpropedit->CurrentDocumentNumber ?? 0)+1;
                }
                if($recprop->CompanyType == 2){
                    $RecDocumentNumber = $recprop->DocumentNumber;
                    $currentdocnum = $recprop->CurrentDocumentNumber;
                }
            }
        }

        $validator = Validator::make($request->all(),[
            'ReceivingType' => 'required',
            'ProductType' => 'required',
            'supplier' => 'required',
            'PONumber' => 'required_if:ReceivingType,2',
            'CommoditySource' => 'required_if:ProductType,Commodity',
            'CommodityType' => 'required_if:ProductType,Commodity',
            'CompanyType' => 'required',
            'Customer' => 'required_if:CompanyType,2',
            'DeliveryOrderNo' => ['required',Rule::unique('receivings')->where(function ($query) use($request) {
                return $query->where('CustomerId',$request->supplier);
            })->ignore($findid)],
            'DispatchStation' => 'required',
            'store' => 'required',
            'ReceivedBy' => 'required',
            'DriverName' => 'required',
            'PlateNumber' => 'required',
            'DriverPhoneNumber' => 'nullable',
            'DeliveredBy' => 'required',
            'ReceivedDate' => 'required',
        ]);

        if($product_type == 1){
            $rules = array(
                'row.*.FloorMap' => 'required',
                'row.*.Origin' => 'required',
                'row.*.Grade' => 'required',
                'row.*.ProcessType' => 'required',
                'row.*.CropYear' => 'required',
                'row.*.Uom' => 'required',
                'row.*.NumOfBag' => 'required|gt:0',
                'row.*.TotalBagWeight' => 'required|gt:0',
                'row.*.TotalKg' => 'required|gt:0',
            );
        }

        else if($product_type == 2){
            $rules = array(
                'row.*.location' => 'required',
                'row.*.ItemId' => 'required',
                'row.*.Quantity' => 'required',
            );
        }

        $v2 = Validator::make($request->all(), $rules);

        if($validator->passes() && $v2->passes() && $request->row != null){
            DB::beginTransaction();
            try
            {
                if ($request->file('DocumentUpload')) {
                    $file = $request->file('DocumentUpload');
                    $fileNameDoc = "GRV".time().".".$request->file('DocumentUpload')->extension();
                    $pathIdentification = public_path() . '/storage/uploads/GoodReceivingDocument';
                    $pathnameIdentification='/storage/uploads/GoodReceivingDocument/'.$fileNameDoc;
                    $file->move($pathIdentification, $fileNameDoc);
                }
                if($request->file('DocumentUpload') == ''){
                    $fileNameDoc=$request->additionalfilelbl;
                }

                $DbData = receiving::where('id',$findid)->first();
                $BasicVal = [
                    'DocumentNumber' => $RecDocumentNumber,
                    'Type' => $request->ReceivingType,
                    'PoId' => $request->PONumber ?? 0,
                    'ProductType' => $request->ProductType,
                    'CustomerId' => $request->supplier,
                    'CommoditySource' => $request->CommoditySource,
                    'CommodityType' => $request->CommodityType,
                    'CompanyType' => $request->CompanyType,
                    'CustomerOrOwner' => $request->Customer,
                    'DeliveryOrderNo' => $request->DeliveryOrderNo,
                    'DispatchStation' => $request->DispatchStation,
                    'StoreId' => $request->store,
                    'ReceivedBy' => $request->ReceivedBy,
                    'DriverName' => $request->DriverName,
                    'TruckPlateNo' => $request->PlateNumber,
                    'DriverPhoneNo' => $request->DriverPhoneNumber,
                    'DeliveredBy' => $request->DeliveredBy,
                    'ReceivedDate' => $request->ReceivedDate,
                    'FileName' => $fileNameDoc,
                    'Memo' => $request->Remark,
                    'fiscalyear' => $fyear,
                    'CurrentDocumentNumber' => $currentdocnum,
                    'IsFromProcurement' => 1,
                ];

                $CreateData = ['Status' => "Draft",'InvoiceStatus' => 0,'Username' => $user];
                $UpdateData = ['updated_at' => Carbon::now()];

                $recpropdb = receiving::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $UpdateData : $CreateData),
                );

                if($product_type == 1){

                    foreach ($request->row as $key => $value){
                        $prdIds[]=$value['id'];
                    }

                    receivingdetail::where('receivingdetails.HeaderId',$recpropdb->id)->whereNotIn('id',$prdIds)->delete();

                    purchaseOrderDetails::where('purchaseorder_id',$purid)->update(['receivedqty'=>0]);//to reset child table data

                    foreach ($request->row as $key => $value){
                        $unitcost=$value['reUnitCost'];
                        $netkg=$value['NetKg'];
                        $beforetaxvar=round(($netkg*$unitcost),2);
                        $taxvar=round((($beforetaxvar*15)/100),2);
                        $totalcost=round(($beforetaxvar+$taxvar),2);

                        receivingdetail::updateOrCreate(['id' => $value['id']],
                        [ 
                            'HeaderId' =>(int)$recpropdb->id,
                            'LocationId'=>$value['FloorMap'],
                            'StoreId' =>(int)$request->store,
                            'PoDetId' =>$value['podetid']??0,
                            'CommodityType' =>$value['CommType'],
                            'CommodityId' =>(int)$value['Origin'],
                            'ItemType' => $request->ProductType,
                            'Grade' =>$value['Grade'],
                            'ProcessType' =>$value['ProcessType'],
                            'CropYear' =>$value['CropYear'],
                            'NewUOMId' =>$value['Uom'],
                            'DefaultUOMId' =>$value['Uom'],
                            'NumOfBag' =>$value['NumOfBag'],
                            'BagWeight' =>$value['TotalBagWeight'],
                            'TotalKg' =>$value['TotalKg'],
                            'NetKg' =>$value['NetKg'],
                            'Feresula' =>$value['Feresula'],
                            'UnitCost' => $unitcost,
                            'BeforeTaxCost' => $beforetaxvar,
                            'TaxAmount' => $taxvar,
                            'TotalCost' => $totalcost,
                            'VarianceShortage'=>(float)$value['varianceshortage'],
                            'VarianceOverage'=>(float)$value['varianceoverage'],
                            'TransactionType'=>"Receiving",
                            'TransactionsType'=>"Receiving",
                            'Memo'=>$value['Remark'],
                        ]);
                        
                        if($companytype == 1){
                            purchaseOrderDetails::where('purchaseordersdetails.id',$value['podetid']??0)
                                            // ->where('itemid',$value['Origin'])
                                            // ->where('cropyear',$value['CropYear'])
                                            // ->where('proccesstype',$value['ProcessType'])
                                            // ->where('uom',$value['Uom'])
                                            ->update(['receivedqty'=> DB::raw('(SELECT COALESCE(SUM(receivingdetails.NumOfBag),0) AS NumOfBag FROM receivingdetails LEFT JOIN receivings ON receivingdetails.HeaderId=receivings.id WHERE receivings.Status IN("Draft","Pending","Verified","Confirmed") AND receivingdetails.PoDetId='.$value['podetid'].' AND receivings.PoId='.$poid.')')]);
                        }
                    }

                    if($companytype == 1){
                        $purcountdata=DB::select('SELECT COUNT(purchaseordersdetails.id) AS CommCount FROM purchaseordersdetails WHERE purchaseordersdetails.purchaseorder_id='.$poid);
                        $commcount=$purcountdata[0]->CommCount;
        
                        $purdetailqty=DB::select('SELECT purchaseordersdetails.qty,purchaseordersdetails.receivedqty FROM purchaseordersdetails WHERE purchaseordersdetails.purchaseorder_id='.$poid);                                
                        foreach($purdetailqty as $row){
                            if($row->receivedqty >= $row->qty){
                                $poreceiveflag+=1;
                            }
                        }
        
                        PurchaseOrder::where('purchaseorders.id',$purid)->update(['purchaseorders.isfullyreceived'=>0]);//to reset old record
                        PurchaseOrder::where('purchaseorders.id',$poid)->update(['purchaseorders.isfullyreceived'=>0]);
                        if($commcount == $poreceiveflag){
                            PurchaseOrder::where('purchaseorders.id',$poid)->update(['purchaseorders.isfullyreceived'=>1]);
                        }
                    }

                    receiving::where('CompanyType',1)->update(['CustomerOrOwner' => 1]);
                }
                else if($product_type == 2){
                    foreach ($request->row as $key => $value){
                        $rec_detail_data[]=[
                            'HeaderId' => $recpropdb->id,
                            'ItemId' => $value['ItemId'],
                            'Quantity' => $value['Quantity'],
                            'StoreId' => $request->store,
                            'NewUOMId' => $value['uom'],
                            'DefaultUOMId' => $value['uom'],
                            'LocationId' => $value['location'],
                            'CommodityId' => 1,
                            'CommodityType' => 1,
                            'Memo' => $value['Memo'],
                            'TransactionType' => "Receiving",
                            'RequireSerialNumber' => "Not-Require",
                            'RequireExpireDate' => "Not-Require",
                            'ConvertedQuantity' => $value['Quantity'],
                            'ItemType' => "Goods",
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                    }

                    receivingdetail::where('receivingdetails.HeaderId',$recpropdb->id)->delete();
                    receivingdetail::insert($rec_detail_data);

                    // foreach ($request->row as $key => $value){
                    //     if($companytype == 1){
                    //         purchaseOrderDetails::where('purchaseordersdetails.itemid',$value['ItemId']??0)
                    //                         ->update(['receivedqty'=> DB::raw('(SELECT COALESCE(SUM(receivingdetails.NumOfBag),0) AS NumOfBag FROM receivingdetails LEFT JOIN receivings ON receivingdetails.HeaderId=receivings.id WHERE receivings.Status IN("Draft","Pending","Verified","Confirmed") AND receivingdetails.PoDetId='.$value['podetid'].' AND receivings.PoId='.$poid.')')]);
                    //     }
                    // }
                }
                
                if($findid == null){
                    $actions = "Created";
                }
                else if($findid != null){
                    $actions = "Edited";
                }

                actions::insert(['user_id'=>$userid,'pageid'=>$recpropdb->id,'pagename'=>"receiving",'action'=>$actions,'status'=>$actions,'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                DB::commit();
                
                return Response::json(['success' =>1]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
        if($v2->fails())
        {
            return response()->json(['errorv2'=> $v2->errors()->all(),'product_type' => $product_type]);
        }
        if($request->row == null)
        {
            return Response::json(['emptyerror'=> 462]);
        }
    }

    public function getPoData(Request $request){
        $ponumber = $_POST['ponumber']; 
        $commsrc = null;
        $prtype = null;
        $data = PurchaseOrder::where('purchaseorders.id',$ponumber)
                ->leftJoin('customers','purchaseorders.customers_id','customers.id')
                ->get(['purchaseorders.*','customers.Name','customers.TinNumber','customers.PhoneNumber','customers.OfficePhone']);
        
        if($data[0]->type == "Direct"){
            $commsrc = $data[0]->commudtysource;
            $prtype = $data[0]->purchaseordertype;
        }
        else if($data[0]->type != "Direct"){
            $evdata = Purchasevaulation::where('purchasevaulations.id',$data[0]->purchasevaulation_id)->get(['purchasevaulations.rfq']);

            $rfqdata = rfq::where('rfqs.id',$evdata[0]->rfq)->get(['rfqs.purequest_id']);

            $reqdata = purchaseRequest::where('purequests.id',$rfqdata[0]->purequest_id)->get(['purequests.*']);
            $commsrc = "Vertical";
            $prtype = $reqdata->type;
        }

        $purdetaildata = purchaseOrderDetails::join('purchaseorders','purchaseordersdetails.purchaseorder_id','purchaseorders.id')
                        ->leftJoin('lookups as grdlookup','purchaseordersdetails.grade','grdlookup.GradeValue')
                        ->where('purchaseordersdetails.purchaseorder_id',$ponumber)
                        ->get(['purchaseordersdetails.*','purchaseordersdetails.id AS PoDetId','grdlookup.Grade AS GradeName']);

        $goods_purdetaildata = purchaseOrderDetails::join('purchaseorders','purchaseordersdetails.purchaseorder_id','purchaseorders.id')
                        ->leftJoin('regitems','purchaseordersdetails.itemid','regitems.id')
                        ->leftJoin('uoms','regitems.MeasurementId','uoms.id')
                        ->where('purchaseordersdetails.purchaseorder_id',$ponumber)
                        ->get(['purchaseordersdetails.*','purchaseordersdetails.id AS PoDetId','regitems.Name AS item_name','uoms.Name AS uom_name','regitems.MeasurementId AS uom_id']);
        
        $po_items = DB::select('SELECT regitems.id,regitems.Name AS item_name FROM purchaseordersdetails LEFT JOIN regitems ON purchaseordersdetails.itemid=regitems.id WHERE purchaseordersdetails.purchaseorder_id='.$ponumber);

        return response()->json(['polist'=>$data,'commsrc'=>$commsrc,'prtype'=>$prtype,'purdetaildata'=>$purdetaildata,'goods_purdetaildata'=>$goods_purdetaildata,'po_items'=>$po_items]);       
    }

    public function getPoNumberList(Request $request){
        $podatasrc=DB::select('SELECT purchaseorders.id,purchaseorders.customers_id,porderno,customers.Name,customers.TinNumber FROM purchaseorders INNER JOIN customers ON purchaseorders.customers_id=customers.id WHERE purchaseorders.Status=3 AND purchaseorders.isfullyreceived IN(0,2,3)');
        return response()->json(['podatasrc'=>$podatasrc]);
    }

    public function calcReqAmount(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $status = ["Draft","Pending","Verified","Received","Confirmed"];
        $poId = $_POST['poId']; 
        $recId = $_POST['recId']; 

        $purchase_order = PurchaseOrder::where('purchaseorders.id',$poId)->get();
        $product_type = $purchase_order[0]->purchaseordertype;
        
        if($product_type == "Commodity"){
            
            $commodity = $_POST['commodity']; 
            $grade = $_POST['grade']; 
            $prtype = $_POST['prtype']; 
            $cropyear = $_POST['cropyear']; 
            $uomval = $_POST['uomval']; 
            $poDetId = $_POST['poDetId']; 
            
            $commodity = !empty($commodity) ? $commodity : 0;
            $grade = !empty($grade) ? $grade : 0;
            $prtype = !empty($prtype) ? $prtype : 0;
            $cropyear = !empty($cropyear) ? $cropyear : 0;
            $uomval = !empty($uomval) ? $uomval : 0;
            $poId = !empty($poId) ? $poId : 0;
            $poDetId = !empty($poDetId) ? $poDetId : 0;
            $recId = !empty($recId) ? $recId : 0;

            $purdetaildata=purchaseOrderDetails::leftJoin('purchaseorders','purchaseordersdetails.purchaseorder_id','purchaseorders.id')
                        ->where('purchaseordersdetails.id',$poDetId)
                        //   ->where('purchaseordersdetails.itemid',$commodity)
                        //   ->where('purchaseordersdetails.proccesstype',$prtype)
                        //   ->where('purchaseordersdetails.grade',$grade)
                        //   ->where('purchaseordersdetails.cropyear',$cropyear)
                        //   ->where('purchaseordersdetails.uom',$uomval)
                        ->get(['purchaseordersdetails.*']);

            $recdetaildata=receivingdetail::join('receivings','receivingdetails.HeaderId','receivings.id')
                        ->where('receivings.PoId',$poId)
                        ->where('receivingdetails.HeaderId',$recId)
                        ->where('receivingdetails.CommodityId',$commodity)
                        ->where('receivingdetails.PoDetId',$poDetId)
                        // ->where('receivingdetails.ProcessType',$prtype)
                        // ->where('receivingdetails.CropYear',$cropyear)
                        // ->where('receivingdetails.DefaultUOMId',$uomval)
                        ->whereIn('receivings.Status',$status)
                        ->get(['receivingdetails.*',DB::raw('COALESCE(SUM(receivingdetails.NumOfBag),0) AS NumOfBag'),DB::raw('COALESCE(SUM(receivingdetails.NetKg),0) AS NetKg'),
                        DB::raw('COALESCE(SUM(receivingdetails.TotalKg),0) AS TotalKg'),DB::raw('COALESCE(SUM(receivingdetails.Feresula),0) AS Feresula')]);

            $othersdetaildata=receivingdetail::join('receivings','receivingdetails.HeaderId','receivings.id')
                        ->where('receivings.PoId',$poId)
                        ->where('receivingdetails.HeaderId','!=',$recId)
                        ->where('receivingdetails.CommodityId',$commodity)
                        ->where('receivingdetails.PoDetId',$poDetId)
                        // ->where('receivingdetails.ProcessType',$prtype)
                        // ->where('receivingdetails.CropYear',$cropyear)
                        // ->where('receivingdetails.DefaultUOMId',$uomval)
                        ->whereIn('receivings.Status',$status)
                        ->get(['receivingdetails.*',DB::raw('COALESCE(SUM(receivingdetails.NumOfBag),0) AS NumOfBag'),DB::raw('COALESCE(SUM(receivingdetails.NetKg),0) AS NetKg'),
                        DB::raw('COALESCE(SUM(receivingdetails.TotalKg),0) AS TotalKg'),DB::raw('COALESCE(SUM(receivingdetails.Feresula),0) AS Feresula')]);

            return response()->json(['purdetaildata' => $purdetaildata,'recdetaildata' => $recdetaildata,'othersdetaildata' => $othersdetaildata,'product_type' => 1]);  
        }
        if($product_type == "Goods"){
            $item_id = $_POST['item_id']; 

            $purdetaildata = purchaseOrderDetails::leftJoin('purchaseorders','purchaseordersdetails.purchaseorder_id','purchaseorders.id')
                        ->where('purchaseordersdetails.purchaseorder_id',$poId)
                        ->where('purchaseordersdetails.itemid',$item_id)
                        ->get(['purchaseordersdetails.*']);

            $recdetaildata = receivingdetail::join('receivings','receivingdetails.HeaderId','receivings.id')
                        ->where('receivings.PoId',$poId)
                        ->where('receivingdetails.HeaderId',$recId)
                        ->where('receivingdetails.ItemId',$item_id)
                        ->whereIn('receivings.Status',$status)
                        ->get(['receivingdetails.*',DB::raw('COALESCE(SUM(receivingdetails.Quantity),0) AS Quantity')]);

            $othersdetaildata = receivingdetail::join('receivings','receivingdetails.HeaderId','receivings.id')
                        ->where('receivings.PoId',$poId)
                        ->where('receivingdetails.HeaderId','!=',$recId)
                        ->where('receivingdetails.ItemId',$item_id)
                        ->whereIn('receivings.Status',$status)
                        ->get(['receivingdetails.*',DB::raw('COALESCE(SUM(receivingdetails.Quantity),0) AS Quantity')]);

            return response()->json(['purdetaildata' => $purdetaildata,'recdetaildata' => $recdetaildata,'othersdetaildata' => $othersdetaildata,'product_type' => 2]);  
        }
    }

    public function recBackToDraft(Request $request)
    {
        ini_set('max_execution_time','30000');
        ini_set("pcre.backtrack_limit","500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->commentid;
        $recprop=receiving::find($findid);

        $validator = Validator::make($request->all(),[
            'Comment' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status=="Pending"){
                try{
                    $recprop->Status="Draft";
                    $recprop->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"receiving",'action'=>"Back to Draft",'status'=>"Back to Draft",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->Comment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function recBackToPending(Request $request)
    {
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $currenttime=Carbon::now();
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->backtopendingid;
        $recprop=receiving::find($findid);

        $validator = Validator::make($request->all(),[
            'BackToPendingComment' => 'required',
        ]);

        if($validator->passes()){
            if($recprop->Status=="Verified"){
                try{
                    $recprop->Status="Pending";
                    $recprop->save();
                    actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"receiving",'action'=>"Back to Pending",'status'=>"Back to Pending",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->BackToPendingComment",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else{
                return Response::json(['statuserror' =>462]);
            }
        }
        if ($validator->fails())
        {
            return Response::json(['errors'=> $validator->errors()]);
        }
    }

    public function showRecCommodity($id){
        $origindata=DB::select('SELECT receivingdetails.CommodityType AS CommTypeId,lookups.CommodityType AS CommType,crplookup.CropYear AS CropYearData,grdlookup.Grade AS GradeName,CONCAT_WS(", ", NULLIF(regions.Rgn_Name, ""), NULLIF(zones.Zone_Name, ""), NULLIF(woredas.Woreda_Name, "")) AS Origin,regitems.Name AS item_name,uoms.Name AS UomName,receivingdetails.*, IFNULL(receivingdetails.Memo,"") AS Remark,ROUND((receivingdetails.NetKg/1000),2) AS WeightByTon,uoms.Name as UomName,locations.Name AS LocationName,VarianceShortage,VarianceOverage,receivingdetails.NetKg,receivings.PoId FROM receivingdetails LEFT JOIN receivings ON receivingdetails.HeaderId=receivings.id LEFT JOIN woredas ON receivingdetails.CommodityId = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions ON zones.Rgn_Id = regions.id LEFT JOIN uoms ON receivingdetails.NewUomId = uoms.id LEFT JOIN locations ON receivingdetails.LocationId=locations.id LEFT JOIN lookups ON receivingdetails.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS crplookup ON receivingdetails.CropYear=crplookup.CropYearValue LEFT JOIN lookups AS grdlookup ON receivingdetails.Grade=grdlookup.GradeValue LEFT JOIN regitems ON receivingdetails.ItemId=regitems.id WHERE receivingdetails.HeaderId = '.$id.' ORDER BY receivingdetails.id DESC');
        return datatables()->of($origindata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showReturnedCommodity($id){
        $receivedata = receiving::where('receivings.id',$id)->get(['receivings.DocumentNumber']);

        $commdata=DB::select('SELECT cmlookups.CommodityType AS CommType,grlookups.Grade AS GradeName,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,requisitiondetails.CommodityType AS CommTypeId,uoms.Name AS UomName,requisitiondetails.*,prlookups.ProcessType,crlookups.CropYear AS CropYearData,IFNULL(requisitiondetails.Memo,"") AS Memo,ROUND((requisitiondetails.NetKg/1000),2) AS WeightByTon,uoms.Name AS UomName,locations.Name AS LocationName,customers.Name AS SupplierName,customers.Code AS SupplierCode,customers.TinNumber AS SupplierTIN,requisitiondetails.ProductionOrderNo,IFNULL(requisitiondetails.CertNumber,"") AS CertNumber,IFNULL(requisitiondetails.ExportCertNumber,"") AS ExportCertNumber,VarianceShortage,VarianceOverage,requisitions.RequestReason,requisitions.CustomerOrOwner,uoms.uomamount,uoms.bagweight,requisitions.DocumentNumber FROM requisitiondetails LEFT JOIN woredas ON requisitiondetails.CommodityId = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions on zones.Rgn_Id = regions.id LEFT JOIN uoms ON requisitiondetails.DefaultUOMId = uoms.id LEFT JOIN locations ON requisitiondetails.LocationId=locations.id LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN lookups AS grlookups ON requisitiondetails.Grade=grlookups.GradeValue LEFT JOIN lookups AS prlookups ON requisitiondetails.ProcessType=prlookups.ProcessTypeValue LEFT JOIN lookups AS crlookups ON requisitiondetails.CropYear=crlookups.CropYearValue LEFT JOIN lookups AS cmlookups ON requisitiondetails.CommodityType=cmlookups.CommodityTypeValue LEFT JOIN requisitions ON requisitiondetails.HeaderId=requisitions.id WHERE requisitiondetails.GrnNumber="'.$receivedata[0]->DocumentNumber.'" AND requisitions.DispatchStatus IN("Partially-Dispatched","Fully-Dispatched") AND requisitions.RequestReason=9 ORDER BY requisitiondetails.id ASC');
        return datatables()->of($commdata)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function downloadGrvDoc($ids,$file_name) {
        $file_path = public_path('storage/uploads/GoodReceivingDocument/'.$file_name);
        return response()->download($file_path);
    }
    //---------------------End Receiving with Procurement---------------------------

    public function showRecevingData($prtype,$fiscalyr){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $users = Auth()->user();
        $settingsval = DB::table('settings')->latest()->first();
        $recpage = $settingsval->ReceivingMode;
        $rechide = '';
        if($users->can('Receiving-Hide')){
            $rechide = 1;
        }  
        else{
            $rechide = 0;
        }
        
        if($recpage == 0){
            $srctype = $prtype == 1 ? "Purchase" : "Production";
            $receiving = DB::select('SELECT
                lookuprefs.LookupName AS reference_type,
                complookups.CompanyType AS CompanyTypes,
                purchaseorders.porderno AS reference,
                customers.CustomerCategory,
                customers.Name AS CustomerName,
                customers.TinNumber AS TIN,
                cus.Name AS CusorOwner,
                stores.Name AS StoreName,
                stores.IsOnCount,
                IF(
                    receivings.Status = "Void",
                    CONCAT(
                        receivings.Status,
                        "(",
                        receivings.StatusOld,
                        ")"
                    ),
                    CASE WHEN receivings.ReturnStatus = 0 THEN receivings.Status ELSE CONCAT(receivings.Status, "(Returned)")
                END
            ) AS
            STATUS
                ,
                receivings.*
            FROM
                receivings
            LEFT JOIN stores ON receivings.StoreId = stores.id
            LEFT JOIN customers ON receivings.CustomerId = customers.id
            LEFT JOIN customers AS cus ON receivings.CustomerOrOwner = cus.id
            LEFT JOIN purchaseorders ON receivings.PoId = purchaseorders.id
            LEFT JOIN lookuprefs ON receivings.Type = lookuprefs.id
            LEFT JOIN lookups AS complookups
            ON receivings.CompanyType = complookups.CompanyTypeValue
            WHERE
                receivings.fiscalyear = "'.$fiscalyr.'" AND receivings.source_type = "'.$srctype.'" AND receivings.IsFromProcurement = 0 AND receivings.StoreId IN(
                SELECT
                    storeassignments.StoreId
                FROM
                    storeassignments
                WHERE
                    storeassignments.UserId = "'.$userid.'" AND storeassignments.Type = 1
            )');
        }
        if($recpage == 1){
            $receiving = DB::select('SELECT receivings.id,receivings.Type,lookups.ReceivingType AS Reference,complookups.CompanyType AS CompanyTypes,receivings.DocumentNumber,purchaseorders.porderno,customers.CustomerCategory,customers.Name AS CustomerName,customers.TinNumber AS TIN,receivings.PaymentType,receivings.VoucherStatus,receivings.VoucherType,receivings.VoucherNumber,receivings.CustomerMRC,receivings.CustomerMRC,cus.Name AS CusorOwner,stores.Name AS StoreName,receivings.PurchaserName,receivings.ProductType,receivings.InvoiceStatus,receivings.IsVoid,receivings.VoidReason,receivings.VoidedBy,receivings.VoidedDate,receivings.TransactionDate,if(receivings.Status="Void",CONCAT(receivings.Status,"(",receivings.StatusOld,")"),CASE WHEN receivings.ReturnStatus=0 THEN receivings.Status ELSE CONCAT(receivings.Status,"(Returned)") END) AS Status,receivings.StatusOld,receivings.WitholdPercent,receivings.WitholdAmount,receivings.SubTotal,receivings.Tax,receivings.GrandTotal,receivings.Username,receivings.ReceivedBy,receivings.DeliveredBy,receivings.Memo,receivings.IsHide,receivings.InvoiceNumber,receivings.created_at,stores.IsOnCount,receivings.IsFromProcurement,receivings.ReceivedDate,receivings.StoreId FROM receivings INNER JOIN stores ON receivings.StoreId=stores.id INNER JOIN customers on receivings.CustomerId=customers.id LEFT JOIN customers AS cus ON receivings.CustomerOrOwner=cus.id LEFT JOIN purchaseorders ON receivings.PoId=purchaseorders.id LEFT JOIN lookups ON receivings.Type=lookups.ReceivingTypeValue LEFT JOIN lookups AS complookups ON receivings.CompanyType=complookups.CompanyTypeValue WHERE receivings.fiscalyear="'.$fiscalyr.'" AND receivings.CompanyType='.$prtype.' AND receivings.IsFromProcurement=1 AND receivings.StoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=1)');
        }
        if(request()->ajax()) {
            return datatables()->of($receiving)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $unvoidvlink='';
                $voidlink='';
                $witholdln='';
                $editln='';
                $println='';
                $hideln='';
                $showln='';

                if($data->Status=='Void'||$data->Status=='Void(Draft)'||$data->Status=='Void(Pending)'||$data->Status=='Void(Checked)'||$data->Status=='Void(Confirmed)')
                {
                    if($user->can('Receiving-Void'))
                    {
                        $unvoidvlink= '<a class="dropdown-item undovoidlnbtn" onclick="undovoidlnbtn('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-ostatus="'.$data->StatusOld.'" data-toggle="modal" id="dtundovoidbtn" data-attr="" title="Undo Void Record"><i class="fa fa-undo"></i><span> Undo Void</span></a>';
                    }
                    if($user->can('Receiving-Hide') && $data->IsFromProcurement==0)
                    {
                        if($data->IsHide=='1')
                        {
                            $showln='<a class="dropdown-item showModal" onclick="showModal('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Show"><i class="fa fa-eye"></i><span> Show</span></a>';
                            $hideln='';
                        }
                        if($data->IsHide=='0')
                        {
                            $showln='';
                            $hideln='<a class="dropdown-item hideModal" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Hide"><i class="fa fa-eye-slash"></i><span> Hide</span></a>';
                        }
                    } 
                    $voidlink='';
                    $editln='';
                    $witholdln='';
                }
                else if($data->Status=='Confirmed' || $data->Status=='Received')
                {
                    if($user->can('Edit-Confirmed-Document') && $data->IsFromProcurement==0)
                    {
                        $editln='<a class="dropdown-item editReceivingRecord" onclick="editrecdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Receiving-Confirm') && $user->can('Receiving-Void') && $data->IsFromProcurement==0)
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" onclick="voidlnbtn('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    } 
                    if($user->can('Receiving-Hide') && $data->IsFromProcurement==0)
                    {
                        if($data->IsHide=='1')
                        {
                            $showln='<a class="dropdown-item showModal" onclick="showModal('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Show"><i class="fa fa-eye"></i><span> Show</span></a>';
                            $hideln='';
                        }
                        if($data->IsHide=='0')
                        {
                            $showln='';
                            $hideln='<a class="dropdown-item hideModal" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Hide"><i class="fa fa-eye-slash"></i><span> Hide</span></a>';
                        }
                    }   

                    if($data->IsFromProcurement==0){
                        $println='<a class="dropdown-item printRecAttachment" href="javascript:void(0)" data-link="/grv/'.$data->id.'" id="printGrv'.$data->id.'" data-attr="" title="Print GRV Attachment"><i class="fa fa-file"></i><span> Print GRV</span></a>';  
                    }
                    else if($data->IsFromProcurement==1){
                        $println='<a class="dropdown-item printCommRecAttachment" href="javascript:void(0)" data-link="/grvComm/'.$data->id.'" id="printCommGrv'.$data->id.'" data-attr="" title="Print GRV Attachment"><i class="fa fa-file"></i><span> Print GRV</span></a>';  
                    }
                }
                else if($data->Status=='Verified')
                {
                    if($user->can('Receiving-Check') && $user->can('Receiving-Edit'))
                    {
                        $editln='<a class="dropdown-item editReceivingRecord" onclick="editrecdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    } 
                    if($user->can('Receiving-Check') && $user->can('Receiving-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" onclick="voidlnbtn('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }
                    if($user->can('Receiving-Hide') && $data->IsFromProcurement==0)
                    {
                        if($data->IsHide=='1')
                        {
                            $showln='<a class="dropdown-item showModal" onclick="showModal('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Show"><i class="fa fa-eye"></i><span> Show</span></a>';
                            $hideln='';
                        }
                        if($data->IsHide=='0')
                        {
                            $showln='';
                            $hideln='<a class="dropdown-item hideModal" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Hide"><i class="fa fa-eye-slash"></i><span> Hide</span></a>';
                        }
                    }    
                    // if($user->can('Withold-Settle'))
                    // {
                    //     $witholdln='<a class="dropdown-item SettleWihold" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="settlewith" data-original-title="Hide"><i class="fa fa-plus"></i><span> Settle Withold</span></a>'; 
                    // }
                }
                else if($data->Status=='Draft')
                {
                    if($user->can('Receiving-Edit'))
                    {
                        $editln='<a class="dropdown-item editReceivingRecord" onclick="editrecdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Receiving-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" onclick="voidlnbtn('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }
                    if($user->can('Receiving-Hide') && $data->IsFromProcurement==0)
                    {
                        if($data->IsHide=='1')
                        {
                            $showln='<a class="dropdown-item showModal" onclick="showModal('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Show"><i class="fa fa-eye"></i><span> Show</span></a>';
                            $hideln='';
                        }
                        if($data->IsHide=='0')
                        {
                            $showln='';
                            $hideln='<a class="dropdown-item hideModal" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Hide"><i class="fa fa-eye-slash"></i><span> Hide</span></a>';
                        }
                    }
                }
                else if($data->Status=='Pending')
                {
                    if($user->can('Receiving-Edit'))
                    {
                        $editln='<a class="dropdown-item editReceivingRecord" onclick="editrecdata('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    if($user->can('Receiving-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" onclick="voidlnbtn('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }
                    if($user->can('Receiving-Hide') && $data->IsFromProcurement==0)
                    {
                        if($data->IsHide=='1')
                        {
                            $showln='<a class="dropdown-item showModal" onclick="showModal('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Show"><i class="fa fa-eye"></i><span> Show</span></a>';
                            $hideln='';
                        }
                        if($data->IsHide=='0')
                        {
                            $showln='';
                            $hideln='<a class="dropdown-item hideModal" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Hide"><i class="fa fa-eye-slash"></i><span> Hide</span></a>';
                        }
                    }
                }
                else if($data->Status!='Void'||$data->Status!='Void(Pending)'||$data->Status!='Void(Checked)'||$data->Status!='Void(Confirmed)')
                {
                    if($user->can('Receiving-Void'))
                    {
                        $voidlink='<a class="dropdown-item voidlnbtn" onclick="voidlnbtn('.$data->id.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtvoidbtn" data-attr="" title="Void Record"><i class="fa fa-trash"></i><span> Void</span></a>'; 
                        $unvoidvlink='';
                    }    
                    if($user->can('Receiving-Hide') && $data->IsFromProcurement==0)
                    {
                        if($data->IsHide=='1')
                        {
                            $showln='<a class="dropdown-item showModal" onclick="showModal('.$data->id.')" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Show"><i class="fa fa-eye"></i><span> Show</span></a>';
                            $hideln='';
                        }
                        if($data->IsHide=='0')
                        {
                            $showln='';
                            $hideln='<a class="dropdown-item hideModal" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="dteditbtn" data-original-title="Hide"><i class="fa fa-eye-slash"></i><span> Hide</span></a>';
                        }
                    }     
                    // if($user->can('Withold-Settle'))
                    // {
                    //     $witholdln='<a class="dropdown-item SettleWihold" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-voucher="'.$data->VoucherType.'" id="settlewith" data-original-title="Hide"><i class="fa fa-plus"></i><span> Settle Withold</span></a>'; 
                    // }
                }
                $btn='<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item DocRecInfo" onclick="DocRecInfo('.$data->id.','.$data->VoucherStatus.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title="">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$editln.'
                        '.$witholdln.'
                        '.$voidlink.'
                        '.$unvoidvlink.'
                        '.$showln.'
                        '.$hideln.'
                        '.$println.'
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showHoldData($fiscalyr)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        //$settingsval = DB::table('settings')->latest()->first();
        //$fiscalyr=$settingsval->FiscalYear;
        $holds=DB::select('SELECT receivingholds.id,receivingholds.Type,receivingholds.DocumentNumber,customers.CustomerCategory,customers.Name as CustomerName,customers.TinNumber as TIN,receivingholds.PaymentType,receivingholds.VoucherStatus,receivingholds.VoucherType,receivingholds.VoucherNumber,receivingholds.CustomerMRC,receivingholds.CustomerMRC,stores.Name as StoreName,receivingholds.PurchaserName,receivingholds.IsVoid,receivingholds.VoidReason,receivingholds.VoidedBy,receivingholds.VoidedDate,receivingholds.TransactionDate,receivingholds.Status,receivingholds.WitholdPercent,receivingholds.WitholdAmount,receivingholds.SubTotal,receivingholds.Tax,receivingholds.GrandTotal,receivingholds.Username,receivingholds.Memo,receivingholds.InvoiceNumber,receivingholds.created_at,StoreId FROM receivingholds INNER JOIN stores ON receivingholds.StoreId=stores.id INNER JOIN customers on receivingholds.CustomerId=customers.id WHERE receivingholds.fiscalyear='.$fiscalyr.' AND receivingholds.StoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=1) ORDER BY receivingholds.id DESC');
        if(request()->ajax()) {
            return datatables()->of($holds)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $editln='';
                $delete='';
                if($user->can('Hold-Edit'))
                {
                    $editln=' <a class="dropdown-item editHoldRecord" onclick="editholddata('.$data->id.')" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                }
                if($user->can('Hold-Delete'))
                {
                    $delete='<a class="dropdown-item" data-id="'.$data->id.'" data-toggle="modal" id="smallButton" data-target="#holddataremoved" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Delete</span></a>';
                }   
                $btn='<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item DocInfo" onclick="DocInfo('.$data->id.','.$data->VoucherStatus.')" data-id="'.$data->id.'" data-status="'.$data->Status.'" data-toggle="modal" id="smallButton" title="">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        '.$editln.'
                        '.$delete.'
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function showReceivingData()
    {
        $holds=DB::select('SELECT receivingholds.id,receivingholds.Type,receivingholds.DocumentNumber,customers.CustomerCategory,customers.Name as CustomerName,receivingholds.PaymentType,receivingholds.VoucherStatus,receivingholds.VoucherType,receivingholds.VoucherNumber,receivingholds.CustomerMRC,stores.Name as StoreName,receivingholds.PurchaserName,receivingholds.IsVoid,receivingholds.VoidReason,receivingholds.VoidedBy,receivingholds.VoidedDate,receivingholds.TransactionDate,receivingholds.Status,receivingholds.WitholdPercent,receivingholds.WitholdAmount,receivingholds.SubTotal,receivingholds.Tax,receivingholds.GrandTotal,receivingholds.Username,receivingholds.Memo,receivingholds.created_at FROM `receivingholds` INNER JOIN stores ON receivingholds.StoreId=stores.id INNER JOIN customers on receivingholds.CustomerId=customers.id ORDER BY receivingholds.id DESC');
        if(request()->ajax()) {
            return datatables()->of($holds)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn='<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item DocInfo" onclick="DocInfo('.$data->id.','.$data->VoucherStatus.')" data-id="'.$data->id.'" data-toggle="modal" id="smallButton" title="">
                            <i class="fa fa-info"></i><span> Info</span>  
                        </a>
                        <a class="dropdown-item editHoldRecord" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-original-title="Edit">
                            <i class="fa fa-edit"></i><span> Edit</span>
                        </a>
                        <a class="dropdown-item" data-id="'.$data->id.'" data-toggle="modal" id="smallButton" data-target="#holddataremoved" data-attr="" title="Delete Record">
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getHoldNumberData(){
        $settings = DB::table('settings')->latest()->first();
        $hprefix=$settings->HoldPrefix;
        $hnumber=$settings->HoldNumber;
        $rprefix=$settings->GRVPrefix;
        $rnumber=$settings->GRVNumber;
        $witholdAmnt=$settings->WitholdMinimumAmount;
        $fyear=$settings->FiscalYear;
        $suffixdoc=$fyear-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $hnumber);
        $holdNumber=$hprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;

        $rnumberPadding=sprintf("%05d", $rnumber);
        $receivingNumber=$rprefix.$rnumberPadding."/".$suffixdoc."-".$suffixdocs;

        $updn=DB::select('update countable set ReceivingHoldCount=ReceivingHoldCount+1 where id=1');
        $receivingholdcnt = DB::table('countable')->latest()->first();
        $companyInfo = DB::table('companyinfos')->latest()->first();
        $witholdPer=$companyInfo->WitholdDeduct;
        return response()->json(['holdnum'=>$holdNumber,'recnum'=>$receivingNumber,'ReceivingHoldCount'=>$receivingholdcnt->ReceivingHoldCount,'witholdAmnt'=>$witholdAmnt,'witholdPer'=>$witholdPer]);
    }

    public function getWitholdNumberData(){
        $settings = DB::table('settings')->latest()->first();
        $witholdAmnt = $settings->WitholdMinimumAmount;
        $companyInfo = DB::table('companyinfos')->latest()->first();
        $witholdPer = $companyInfo->WitholdDeduct;
        return response()->json(['witholdAmnt' => $witholdAmnt,'witholdPer' => $witholdPer]);
    }

    public function getNewHoldNumberData(){
        $settings = DB::table('settings')->latest()->first();
        $hprefix=$settings->HoldPrefix;
        $hnumber=$settings->HoldNumber;
        $rprefix=$settings->GRVPrefix;
        $rnumber=$settings->GRVNumber;
        $fyear=$settings->FiscalYear;
        $suffixdoc=$fyear-2000;
        $suffixdocs=$suffixdoc+1;
        $numberPadding=sprintf("%05d", $hnumber);
        $holdNumber=$hprefix.$numberPadding."/".$suffixdoc."-".$suffixdocs;
        $rnumberPadding=sprintf("%05d", $rnumber);
        $receivingNumber=$rprefix.$rnumberPadding."/".$suffixdoc."-".$suffixdocs;
        return response()->json(['holdnum'=>$holdNumber,'recnum'=>$receivingNumber]);
    }

    public function showSupplierInfoCon($suppId){
        $customer = customer::select('Name','CustomerCategory','TinNumber','VatNumber')->where('id','=',$suppId)->get();
        return response()->json(['customer' => $customer]);
    }

    public function showItemInfoCon($itemId){
        $Regitem = DB::select('SELECT regitems.id,regitems.Type,regitems.Code,regitems.Name,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus FROM regitems LEFT JOIN categories on regitems.CategoryId=categories.id LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE regitems.id='.$itemId);
        return response()->json(['item' => $Regitem]);
    }

    public function showHoldDataCon($id){
        $ids=$id;
        $columnName="id";
        $rechold = receivinghold::find($id);
        $createddateval=$rechold->created_at;

        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $holdHeader=DB::select('SELECT receivingholds.id,receivingholds.Type,receivingholds.DocumentNumber,customers.CustomerCategory,customers.Name as CustomerName,receivingholds.PaymentType,CASE WHEN receivingholds.VoucherStatus=1 THEN "With" WHEN receivingholds.VoucherStatus=2 THEN "WithOut" END AS VoucherStatusName,receivingholds.VoucherType,receivingholds.VoucherNumber,receivingholds.CustomerMRC,stores.Name as StoreName,receivingholds.PurchaserName,receivingholds.IsVoid,receivingholds.VoidReason,receivingholds.VoidedBy,receivingholds.VoidedDate,receivingholds.TransactionDate,receivingholds.Status,receivingholds.WitholdPercent,receivingholds.WitholdAmount,receivingholds.SubTotal,receivingholds.Tax,receivingholds.GrandTotal,receivingholds.NetPay,receivingholds.Username,receivingholds.InvoiceNumber,receivingholds.Memo,"'.$datetime.'" AS created_at FROM receivingholds INNER JOIN stores ON receivingholds.StoreId=stores.id INNER JOIN customers on receivingholds.CustomerId=customers.id WHERE receivingholds.id='.$id);
        $countitem = DB::table('receivingholddetails')->where('HeaderId', '=', $id)
        ->get();
        $getCountItem = $countitem->count();
        
        return response()->json(['holdHeader'=>$holdHeader,'count'=>$getCountItem]);       
    }

    public function showRecDataCon($id){
        $settings = DB::table('settings')->latest()->first();
        $fyear = $settings->FiscalYear;
        $ids = $id;
        $columnName = "id";
        $person = "Person";
        $foreign = "Foreigner-Supplier";
        $rechold = receiving::find($id);
        $createddateval = $rechold->created_at;
        $product_type = $rechold->ProductType == "Commodity" ? 1 : 2;
        $can_change_srctype = true;

        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $holdHeader = DB::select('SELECT lookuprefs.LookupName AS reference_type,complookups.CompanyType AS CompanyTypeLbl,purchaseorders.porderno,customers.Code,customers.CustomerCategory,customers.Name AS CustomerName,customers.TinNumber AS TinNumber,customers.VatNumber AS VatNumber,CONCAT_WS(", ",NULLIF(customers.PhoneNumber,""),NULLIF(customers.OfficePhone,"")) AS phone_number,stores.Name AS StoreName,cusdata.Name CustomerOrOwner,CASE WHEN receivings.VoucherStatus=1 THEN "With" WHEN receivings.VoucherStatus=2 THEN "WithOut" END AS VoucherStatusName,receivings.* FROM receivings LEFT JOIN stores ON receivings.StoreId=stores.id LEFT JOIN customers on receivings.CustomerId=customers.id LEFT JOIN customers AS cusdata ON receivings.CustomerOrOwner=cusdata.id LEFT JOIN purchaseorders ON receivings.PoId=purchaseorders.id LEFT JOIN lookups AS complookups ON receivings.CompanyType=complookups.CompanyTypeValue LEFT JOIN lookuprefs ON receivings.Type=lookuprefs.id WHERE receivings.id='.$id); 
        //$holdHeader = DB::select('SELECT receivings.id,lookups.ReceivingType AS RecType,complookups.CompanyType AS CompanyTypeLbl,receivings.CompanyType,purchaseorders.porderno,receivings.ProductType,receivings.CommoditySource,receivings.CommodityType,receivings.DocumentNumber,receivings.CustomerId,customers.CustomerCategory,customers.Name as CustomerName,customers.TinNumber as TinNumber,customers.VatNumber as VatNumber,receivings.PaymentType,receivings.VoucherStatus,CASE WHEN receivings.VoucherStatus=1 THEN "With" WHEN receivings.VoucherStatus=2 THEN "WithOut" END AS VoucherStatusName,receivings.VoucherType,receivings.VoucherNumber,receivings.CustomerMRC,stores.Name AS StoreName,cusdata.Name CustomerOrOwner,receivings.PurchaserName,receivings.DeliveryOrderNo,receivings.DispatchStation,receivings.DriverName,receivings.TruckPlateNo,receivings.DriverPhoneNo,receivings.ReceivedDate,receivings.ReceivedBy,receivings.DeliveredBy,receivings.Memo,receivings.IsVoid,receivings.VoidReason,receivings.VoidedBy,receivings.VoidedDate,receivings.TransactionDate,receivings.Status,receivings.StatusOld,receivings.WitholdPercent,receivings.InvoiceNumber,receivings.WitholdAmount,receivings.InvoiceStatus,receivings.FileName,TRUNCATE(receivings.SubTotal,2) AS SubTotal,TRUNCATE(receivings.Tax,2) AS Tax,TRUNCATE(receivings.GrandTotal,2) AS GrandTotal,TRUNCATE(receivings.NetPay,2) AS NetPay,receivings.Username,receivings.ReceivedBy,receivings.DeliveredBy,receivings.CheckedBy,receivings.CheckedDate,receivings.ConfirmedBy,receivings.ConfirmedDate,receivings.ChangeToPendingBy,receivings.ChangeToPendingDate,receivings.WitholdSettledBy,receivings.WitholdSettleDate,receivings.Memo,"'.$datetime.'" AS created_at,receivings.WitholdReceipt,receivings.IsWitholdSettle,receivings.UndoVoidBy,receivings.UndoVoidDate,receivings.EditConfirmedBy,receivings.EditConfirmedDate,receivings.fiscalyear,receivings.ReturnStatus,receivings.source_type,receivings.productiono,receivings.requisitiono,receivings.IsFromProcurement,receivings.IsHide,receivings.IsSeparatelySettled,receivings.withhold_receipt_date FROM receivings INNER JOIN stores ON receivings.StoreId=stores.id INNER JOIN customers on receivings.CustomerId=customers.id LEFT JOIN customers AS cusdata ON receivings.CustomerOrOwner=cusdata.id LEFT JOIN purchaseorders ON receivings.PoId=purchaseorders.id LEFT JOIN lookups ON receivings.Type=lookups.ReceivingTypeValue LEFT JOIN lookups AS complookups ON receivings.CompanyType=complookups.CompanyTypeValue WHERE receivings.id='.$id); 
        
        $countitem = DB::table('receivingdetails')->where('HeaderId', '=', $id)->get();

        $getCountItem = $countitem->count();
        $cusId=$rechold->CustomerId;
        $trDate=$rechold->TransactionDate;
        $strid=$rechold->StoreId;
        $status="Void";

        $document_latest = DB::table('receivings')->where('source_type', '=', $rechold->source_type)->latest()->first();
        $last_doc_num = $document_latest->CurrentDocumentNumber;
        $current_doc_num = $rechold->CurrentDocumentNumber;

        $can_change_srctype = $last_doc_num == $current_doc_num ? true : false;

        $strdata=store::findorFail($strid);
        $fiscalyearstr=$strdata->FiscalYear;

        $pricing = DB::table('receivings')
        ->join('customers','customers.id','=','receivings.CustomerId')
        ->select(DB::raw('TRUNCATE(SUM(SubTotal),2) as SubTotal'))
        ->where('TransactionDate', '=', $trDate)
        ->where('CustomerId', '=', $cusId)
        ->where('customers.CustomerCategory', '!=',$person)
        ->where('customers.CustomerCategory', '!=',$foreign)
        ->where('receivings.Status', '!=',$status)
        ->get();

        $pricingsett = DB::table('receivings')
        ->join('customers','customers.id','=','receivings.CustomerId')
        ->select(DB::raw('TRUNCATE(SUM(SubTotal),2) as SubTotal'))
        ->where('TransactionDate', '=', $trDate)
        ->where('CustomerId', '=', $cusId)
        ->where('customers.CustomerCategory', '!=',$person)
        ->where('customers.CustomerCategory', '!=',$foreign)
        ->where('receivings.Status', '!=',$status)
        ->where('receivings.IsSeparatelySettled', '=',0)
        ->get();

        $allValues = DB::table('receivings')
        ->join('customers','customers.id','=','receivings.CustomerId')
        ->select(DB::raw('TRUNCATE(SUM(SubTotal),2) as SubTotal'))
        ->where('TransactionDate', '=', $trDate)
        ->where('CustomerId', '=', $cusId)
        ->where('customers.CustomerCategory', '!=',$person)
        ->where('customers.CustomerCategory', '!=',$foreign)
        ->where('receivings.Status', '!=',$status)
        //->whereIn('receivings.id',$selectedids)
        ->get();
        
        $diffValues = DB::table('receivings')
        ->join('customers','customers.id','=','receivings.CustomerId')
        ->select(DB::raw('TRUNCATE(SUM(SubTotal),2) as SubTotal'))
        ->where('TransactionDate', '=', $trDate)
        ->where('CustomerId', '=', $cusId)
        ->where('customers.CustomerCategory', '!=',$person)
        ->where('customers.CustomerCategory', '!=',$foreign)
        ->where('receivings.Status', '!=',$status)
        //->whereNotIn('receivings.id',$selectedids)
        ->get();

        $countRec = DB::table('receivings')
        ->where('CustomerId', '=', $cusId)
        ->where('TransactionDate', '=', $trDate)
        ->where('receivings.Status', '!=',$status)
        ->get();
        
        $getcountRec = $countRec->count();

        $getids=DB::select('SELECT GROUP_CONCAT(id) AS id FROM receivings WHERE CustomerId='.$cusId.' AND TransactionDate="'.$trDate.'"');

        $activitydata=actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"receiving")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['holdHeader'=>$holdHeader,'count'=>$getCountItem,'pricing'=>$pricing,'getcountRec'=>$getcountRec,'pricingsett'=>$pricingsett,'getids'=>$getids,'allValues'=>$allValues,'diffValues'=>$diffValues,'fyear'=>$fyear,'fyearstr'=>$fiscalyearstr,'activitydata'=>$activitydata,'product_type' => $product_type,'can_change_srctype' => $can_change_srctype]);       
    }

    public function showRecDataConSett($id,$sids)
    {
        $ids=$id;
        $selectedids=$sids;
        $selectedid = is_array($selectedids) ? $selectedids : [$selectedids];
        $columnName="id";
        $person="Person";
        $foreign="Foreigner-Supplier";
        $settle="Settled";
        $holdHeader=DB::select('SELECT receivings.id,receivings.Type,receivings.DocumentNumber,receivings.CustomerId,customers.CustomerCategory,customers.Name as CustomerName,receivings.PaymentType,receivings.VoucherType,receivings.VoucherNumber,receivings.CustomerMRC,stores.Name as StoreName,receivings.PurchaserName,receivings.IsVoid,receivings.VoidReason,receivings.VoidedBy,receivings.VoidedDate,receivings.TransactionDate,receivings.Status,receivings.StatusOld,receivings.WitholdPercent,receivings.WitholdAmount,receivings.InvoiceNumber,TRUNCATE(receivings.SubTotal,2) AS SubTotal,TRUNCATE(receivings.Tax,2) AS Tax,TRUNCATE(receivings.GrandTotal,2) AS GrandTotal,TRUNCATE(receivings.NetPay,2) AS NetPay,receivings.Username,receivings.ReceivedBy,receivings.DeliveredBy,receivings.CheckedBy,receivings.CheckedDate,receivings.ConfirmedBy,receivings.ConfirmedDate,receivings.ChangeToPendingBy,receivings.ChangeToPendingDate,receivings.WitholdSettledBy,receivings.WitholdSettleDate,receivings.Memo,DATE(receivings.created_at) AS created_at,receivings.WitholdReceipt,receivings.IsWitholdSettle FROM receivings INNER JOIN stores ON receivings.StoreId=stores.id INNER JOIN customers on receivings.CustomerId=customers.id WHERE receivings.id='.$id); 
        $countitem = DB::table('receivingdetails')->where('HeaderId', '=', $id)
        ->get();
        $getCountItem = $countitem->count();
        $rechold = receiving::find($id);
        $cusId=$rechold->CustomerId;
        $trDate=$rechold->TransactionDate;
        $status="Void";
        $pricing = DB::table('receivings')
        ->join('customers','customers.id','=','receivings.CustomerId')
        ->select(DB::raw('TRUNCATE(SUM(SubTotal),2) as SubTotal'))
        ->where('TransactionDate', '=', $trDate)
        ->where('CustomerId', '=', $cusId)
        ->where('customers.CustomerCategory', '!=',$person)
        ->where('customers.CustomerCategory', '!=',$foreign)
        ->where('receivings.Status', '!=',$status)
        ->get();

        $pricingsett = DB::table('receivings')
        ->join('customers','customers.id','=','receivings.CustomerId')
        ->select(DB::raw('TRUNCATE(SUM(SubTotal),2) as SubTotal'))
        ->where('TransactionDate', '=', $trDate)
        ->where('CustomerId', '=', $cusId)
        ->where('customers.CustomerCategory', '!=',$person)
        ->where('customers.CustomerCategory', '!=',$foreign)
        ->where('receivings.Status', '!=',$status)
        ->get();

       

        $countRec = DB::table('receivings')
        ->where('CustomerId', '=', $cusId)
        ->where('TransactionDate', '=', $trDate)
        ->where('receivings.Status', '!=',$status)
        ->get();
        $getcountRec = $countRec->count();

        $countSettRec = DB::table('receivings')
        ->where('CustomerId', '=', $cusId)
        ->where('TransactionDate', '=', $trDate)
        ->where('receivings.Status', '!=',$status)
        ->where('receivings.IsWitholdSettle', '=', $settle)
        ->get();
        $getcountSettRec = $countSettRec->count();

        $countUnSettRec = DB::table('receivings')
        ->where('CustomerId', '=', $cusId)
        ->where('TransactionDate', '=', $trDate)
        ->where('receivings.Status', '!=',$status)
        ->where('receivings.IsWitholdSettle', '!=', $settle)
        ->get();
        $getcountUnSettRec = $countUnSettRec->count();

        if($getcountRec==$getcountSettRec)
        {
            $allVal=DB::select('SELECT COALESCE(TRUNCATE(SUM(receivings.SubTotal),2),0) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id IN('.$sids.') AND receivings.Status!="'.$status.'"'); 
            $diffVal=DB::select('SELECT COALESCE(TRUNCATE(SUM(receivings.SubTotal),2),0) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id NOT IN('.$sids.') AND receivings.Status!="'.$status.'"'); 
        }
        if($getcountRec==$getcountUnSettRec)
        {
            $allVal=DB::select('SELECT COALESCE(TRUNCATE(SUM(receivings.SubTotal),2),0) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id IN('.$sids.') AND receivings.Status!="'.$status.'"'); 
            $diffVal=DB::select('SELECT COALESCE(TRUNCATE(SUM(receivings.SubTotal),2),0) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id NOT IN('.$sids.') AND receivings.Status!="'.$status.'"'); 
        }
        if(($getcountRec!=$getcountUnSettRec)&&($getcountRec!=$getcountSettRec))
        {
            $allVal=DB::select('SELECT COALESCE(TRUNCATE(SUM(receivings.SubTotal),2),0) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id IN('.$sids.') AND receivings.IsWitholdSettle!="'.$settle.'" AND receivings.Status!="'.$status.'"'); 
            $diffVal=DB::select('SELECT COALESCE(TRUNCATE(SUM(receivings.SubTotal),2),0) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id NOT IN('.$sids.') AND receivings.IsWitholdSettle!="'.$settle.'" AND receivings.Status!="'.$status.'"'); 
        }
        if($getcountRec!=$getcountSettRec)
        {
            $allVal=DB::select('SELECT COALESCE(TRUNCATE(SUM(receivings.SubTotal),2),0) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id IN('.$sids.') AND receivings.Status!="'.$status.'"'); 
            $diffVal=DB::select('SELECT COALESCE(TRUNCATE(SUM(receivings.SubTotal),2),0) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id NOT IN('.$sids.') AND receivings.Status!="'.$status.'"'); 
        }
        $getids=DB::select('SELECT GROUP_CONCAT(id) AS id FROM receivings WHERE CustomerId='.$cusId.' AND TransactionDate="'.$trDate.'"');

        return response()->json(['holdHeader'=>$holdHeader,'count'=>$getCountItem,'pricing'=>$pricing,'getcountRec'=>$getcountRec,'pricingsett'=>$pricingsett,'getids'=>$getids,'selectedids'=>$sids,'allVal'=>$allVal,'diffVal'=>$diffVal,'getcountRec'=>$getcountRec,'getcountSettRec'=>$getcountSettRec,'getcountUnSettRec'=>$getcountUnSettRec]);       
    }

    public function showRecDataConUnSett($id,$sids)
    {
        $ids=$id;
        $selectedids=$sids;
        $selectedid = is_array($selectedids) ? $selectedids : [$selectedids];
        $columnName="id";
        $person="Person";
        $foreign="Foreigner-Supplier";
        $settle="Settled";
        $holdHeader=DB::select('SELECT receivings.id,receivings.Type,receivings.DocumentNumber,receivings.CustomerId,customers.CustomerCategory,customers.Name as CustomerName,receivings.PaymentType,receivings.VoucherType,receivings.VoucherNumber,receivings.CustomerMRC,stores.Name as StoreName,receivings.PurchaserName,receivings.IsVoid,receivings.VoidReason,receivings.VoidedBy,receivings.VoidedDate,receivings.TransactionDate,receivings.Status,receivings.StatusOld,receivings.WitholdPercent,receivings.WitholdAmount,receivings.InvoiceNumber,TRUNCATE(receivings.SubTotal,2) AS SubTotal,TRUNCATE(receivings.Tax,2) AS Tax,TRUNCATE(receivings.GrandTotal,2) AS GrandTotal,TRUNCATE(receivings.NetPay,2) AS NetPay,receivings.Username,receivings.ReceivedBy,receivings.DeliveredBy,receivings.CheckedBy,receivings.CheckedDate,receivings.ConfirmedBy,receivings.ConfirmedDate,receivings.ChangeToPendingBy,receivings.ChangeToPendingDate,receivings.WitholdSettledBy,receivings.WitholdSettleDate,receivings.Memo,DATE(receivings.created_at) AS created_at,receivings.WitholdReceipt,receivings.IsWitholdSettle FROM receivings INNER JOIN stores ON receivings.StoreId=stores.id INNER JOIN customers on receivings.CustomerId=customers.id WHERE receivings.id='.$id); 
        $countitem = DB::table('receivingdetails')->where('HeaderId', '=', $id)
        ->get();
        $getCountItem = $countitem->count();
        $rechold = receiving::find($id);
        $cusId=$rechold->CustomerId;
        $trDate=$rechold->TransactionDate;
        $withReceipt=$rechold->WitholdReceipt;
        $status="Void";
        $pricing = DB::table('receivings')
        ->join('customers','customers.id','=','receivings.CustomerId')
        ->select(DB::raw('TRUNCATE(SUM(SubTotal),2) as SubTotal'))
        ->where('TransactionDate', '=', $trDate)
        ->where('CustomerId', '=', $cusId)
        ->where('customers.CustomerCategory', '!=',$person)
        ->where('customers.CustomerCategory', '!=',$foreign)
        ->where('receivings.Status', '!=',$status)
        ->get();

        $pricingsett = DB::table('receivings')
        ->join('customers','customers.id','=','receivings.CustomerId')
        ->select(DB::raw('TRUNCATE(SUM(SubTotal),2) as SubTotal'))
        ->where('TransactionDate', '=', $trDate)
        ->where('CustomerId', '=', $cusId)
        ->where('customers.CustomerCategory', '!=',$person)
        ->where('customers.CustomerCategory', '!=',$foreign)
        ->where('receivings.Status', '!=',$status)
        ->get();

        $allVal=DB::select('SELECT TRUNCATE(SUM(receivings.SubTotal),2) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id IN('.$sids.') AND receivings.IsWitholdSettle="'.$settle.'" AND receivings.Status!="'.$status.'"'); 
        $diffVal=DB::select('SELECT COALESCE(TRUNCATE(SUM(receivings.SubTotal),2),0) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id NOT IN('.$sids.') AND receivings.IsWitholdSettle="'.$settle.'" AND receivings.Status!="'.$status.'"'); 
        $diffValReceipt=DB::select('SELECT COALESCE(TRUNCATE(SUM(receivings.SubTotal),2),0) AS SubTotal FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND (customers.CustomerCategory!="'.$person.'" OR customers.CustomerCategory!="'.$foreign.'") AND receivings.id NOT IN('.$sids.') AND receivings.IsWitholdSettle="'.$settle.'" AND receivings.WitholdReceipt IN(SELECT WitholdReceipt FROM receivings WHERE receivings.id IN('.$sids.')) AND receivings.Status!="'.$status.'"'); 

        $countRec = DB::table('receivings')
        ->where('CustomerId', '=', $cusId)
        ->where('TransactionDate', '=', $trDate)
        ->where('receivings.Status', '!=',$status)
        ->get();

        $getcountRec = $countRec->count();
        $getids=DB::select('SELECT GROUP_CONCAT(id) AS id FROM receivings WHERE CustomerId='.$cusId.' AND TransactionDate="'.$trDate.'"');

        return response()->json(['holdHeader'=>$holdHeader,'count'=>$getCountItem,'pricing'=>$pricing,'getcountRec'=>$getcountRec,'pricingsett'=>$pricingsett,'getids'=>$getids,'selectedids'=>$sids,'allVal'=>$allVal,'diffVal'=>$diffVal,'diffValReceipt'=>$diffValReceipt,'with'=>$withReceipt]);       
    }

    public function showRecDataConSep($id)
    {
        $ids=$id;
        $columnName="id";
        $person="Person";
        $foreign="Foreigner-Supplier";
        $zeroflag="0";
        $oneflag="1";
        $holdHeader=DB::select('SELECT receivings.id,receivings.Type,receivings.DocumentNumber,receivings.CustomerId,customers.CustomerCategory,customers.Name as CustomerName,receivings.PaymentType,receivings.VoucherType,receivings.VoucherNumber,receivings.CustomerMRC,stores.Name as StoreName,receivings.PurchaserName,receivings.IsVoid,receivings.VoidReason,receivings.VoidedBy,receivings.VoidedDate,receivings.TransactionDate,receivings.Status,receivings.StatusOld,receivings.WitholdPercent,receivings.WitholdAmount,TRUNCATE(receivings.SubTotal,2) AS SubTotal,TRUNCATE(receivings.Tax,2) AS Tax,TRUNCATE(receivings.GrandTotal,2) AS GrandTotal,TRUNCATE(receivings.NetPay,2) AS NetPay,receivings.Username,receivings.ReceivedBy,receivings.DeliveredBy,receivings.CheckedBy,receivings.CheckedDate,receivings.ConfirmedBy,receivings.ConfirmedDate,receivings.ChangeToPendingBy,receivings.ChangeToPendingDate,receivings.WitholdSettledBy,receivings.WitholdSettleDate,receivings.Memo,DATE(receivings.created_at) AS created_at,receivings.WitholdReceipt,receivings.IsWitholdSettle FROM receivings INNER JOIN stores ON receivings.StoreId=stores.id INNER JOIN customers on receivings.CustomerId=customers.id WHERE receivings.id='.$id); 
        $countitem = DB::table('receivingdetails')->where('HeaderId', '=', $id)
        ->get();
        $getCountItem = $countitem->count();
        $rechold = receiving::find($id);
        $cusId=$rechold->CustomerId;
        $trDate=$rechold->TransactionDate;
        $status="Void";
        $pricing = DB::table('receivings')
        ->join('customers','customers.id','=','receivings.CustomerId')
        ->select(DB::raw('TRUNCATE(SUM(SubTotal),2) as SubTotal'))
        ->where('TransactionDate', '=', $trDate)
        ->where('CustomerId', '=', $cusId)
        ->where('customers.CustomerCategory', '!=',$person)
        ->where('customers.CustomerCategory', '!=',$foreign)
        ->where('receivings.Status', '!=',$status)
        ->where('receivings.id', '!=',$id)
        ->get();

        $pricingsingle = DB::table('receivings')
        ->join('customers','customers.id','=','receivings.CustomerId')
        ->select(DB::raw('TRUNCATE(SUM(SubTotal),2) as SubTotal'))
        ->where('receivings.id', '=',$id)
        ->get();

        $countRec = DB::table('receivings')
        ->where('CustomerId', '=', $cusId)
        ->where('TransactionDate', '=', $trDate)
        ->where('receivings.Status', '!=',$status)
        ->get();
        $getcountRec = $countRec->count();
        return response()->json(['holdHeader'=>$holdHeader,'count'=>$getCountItem,'pricing'=>$pricing,'pricingsingle'=>$pricingsingle,'getcountRec'=>$getcountRec]);       
    }

    public function showMRCSCon($suppId)
    {
        $mrc = DB::select('SELECT MRCNumber FROM customers WHERE customers.id='.$suppId.' UNION SELECT MRCNumber FROM mrcs WHERE CustomerId='.$suppId.' AND ActiveStatus="Active" AND IsDeleted=1');
        return response()->json(['mrc'=>$mrc]);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request){
        $settings = DB::table('settings')->latest()->first();
        $findid = $request->receivingId;
        $thisdate = Carbon::today()->toDateString();
        $nws = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $hiddenstr = $request->hiddenstoreval;
        $strid = $request->store;
        $datevalfy = $request->date;
        $fiscalyears = null;
        $fiscalyrcomp = null;
        $fiscalyrstr = null;
        $rnumber = null;
        $receivingNumber = null;
        $rprefix = null;
        $dateerrorval = 0;
        $fiscalrecdaterror = 0;
        $editdiffstr = 0;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $headerid = $request->receivingId;
        $vnumber = $request->VoucherNumber;
        $inumber = $request->InvoiceNumber;
        $vtype = $request->voucherType;
        $customerid = $request->supplier;
        $mrcnum = $request->MrcNumber;
        $fiscalr = "Fiscal-Receipt";
        $fyear = $settings->FiscalYear;
        if($strid != null){
            $strdata = store::findorFail($strid);
            $fiscalyears = $strdata->FiscalYear;
        }
        
        $validator = Validator::make($request->all(), [
            'SourceType' => ['required'],
            'ReferenceType' => ['required_if:SourceType,Purchase'],
            'Reference' => ['required_if:ReferenceType,501,502'],
            'ProductType' => ['required_if:SourceType,Purchase'],
            'supplier' => ['required_if:SourceType,Purchase'],
            'DocumentNumber' => ['nullable',Rule::unique('receivings')->where(function ($query) use($request) {
                return $query->where('CustomerId',$request->supplier);
            })->ignore($findid)],

            'VoucherStatus' => ['required_if:ReferenceType,503'],
            'PaymentType' => ['required_if:ReferenceType,503'],
            'date' => ['required_if:ReferenceType,503','nullable','before:now'],
            'voucherType' => ['required_if:VoucherStatus,true,1,on,yes'],
            'VoucherNumber' => ['required_if:VoucherStatus,true,1,on,yes',Rule::unique('receivings')->where(function ($query) use($vnumber,$customerid,$mrcnum) {
                    return $query->where('VoucherNumber', $vnumber)
                    ->where('CustomerMRC', $mrcnum)
                    ->where('CustomerId', $customerid)
                    ->whereNotNull('VoucherNumber');
                })->ignore($findid)
            ],
            'InvoiceNumber' => ['nullable',Rule::unique('receivings')->where(function ($query) use($inumber,$customerid,$mrcnum) {
                    return $query->where('InvoiceNumber', $inumber)
                    ->where('CustomerMRC', $mrcnum)
                    ->where('CustomerId', $customerid)
                    ->whereNotNull('InvoiceNumber');
                })->ignore($findid)
            ],
            'MrcNumber' => ['required_if:voucherType,Fiscal-Receipt'],
            'store' => ['required'],
            'ReceivedBy' => ['required'],
            'ReceivedDate' => ['required'],

            'productionNumber' => ['required_if:SourceType,Production'],
        ]);

        $rules = array(
            'row.*.ItemId' => 'required',
            'row.*.Quantity' => 'required|gt:0',
            'row.*.UnitCost' => 'required_if:ReferenceType,503|required_if:VisibleCost,true,1,on,yes',
        );

        $v2 = Validator::make($request->all(), $rules);

        if($validator->passes() && $v2->passes() && $request->row != null){
            DB::beginTransaction();
            try{
                $validation = $this->validateInventoryItemBalances($request->row,$request->store,$fyear,$findid);
                if (($validation['status'] ?? "") == 456) {
                    return Response::json([
                        'balance_error' => 404,
                        'items' => $validation['negative_items']
                    ]);
                }
                
                $DbData = receiving::where('id', $request->receivingId)->first();
                $document_number =  $this->generateDocumentNumberFn($request->SourceType, $fyear, $request->receivingId);
                preg_match('/-(\d+)\//', $document_number, $matches); //extract number from doc
                $current_doc_number = intval($matches[1] ?? 0);

                $BasicVal = [
                    'DocumentNumber' => $document_number,
                    'Type' => $request->SourceType == "Purchase" ? $request->ReferenceType : 500,
                    'source_type' => $request->SourceType,
                    'PoId' => $request->Reference,
                    'ProductType' => $request->ProductType,
                    'CustomerId' => $request->SourceType == "Purchase" ? $request->supplier : 1,
                    'DeliveryOrderNo' => $request->DocumentNumber,
                    'is_cost_shown' => $request->has('VisibleCost') == true ? 1 : 0,

                    'VoucherStatus' => $request->has('VoucherStatus') == true ? 1 : 2,
                    'PaymentType' => $request->PaymentType,
                    'TransactionDate' => $request->SourceType == "Purchase" ? $request->date : $request->ProductionDate,
                    'VoucherType' => $request->voucherType,
                    'VoucherNumber' => $request->VoucherNumber,
                    'InvoiceNumber' => $request->InvoiceNumber,
                    'CustomerMRC' => $request->MrcNumber,

                    'StoreId' => $request->store,
                    'ReceivedBy' => $request->ReceivedBy,
                    'ReceivedDate' => $request->ReceivedDate,
                    'DeliveredBy' => $request->SourceType == "Purchase" ? $request->DeliveredBy : $request->ProductionDeliveredBy,
                    'TruckPlateNo' => strtoupper($request->PlateNumber),
                    'Memo' => $request->Memo,

                    'WitholdPercent' => $request->witholdPercenti,
                    'WitholdAmount' => $request->witholdingAmntin,
                    'SubTotal' => $request->subtotali,
                    'Tax' => $request->taxi,
                    'GrandTotal' => $request->grandtotali,
                    'NetPay' => $request->netpayin,
                    
                    'IsHide' => $request->has('hideGRVCBX') == true ? 1 : 0,
                    'CurrentDocumentNumber' => $current_doc_number,

                    'productiono' => $request->productionNumber,
                    'requisitiono' => $request->requisitionNumber,
                ];

                $CreatedBy = [
                    'IsVoid' => 0,
                    'VoidReason' => "",
                    'VoidedBy' => "",
                    'VoidedDate' => "",
                    'Status' => "Draft",
                    'StatusOld' => "",
                    'fiscalyear' => $fyear,
                    'Username' => $user,
                    'CompanyType' => 1,
                    'created_at' => Carbon::now()
                ];

                $LastUpdatedBy = [
                    'updated_at' => Carbon::now()
                ];

                $receiving = receiving::updateOrCreate(
                    ['id' => $request->receivingId], 
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy)
                );


                $receiving->items()->detach();

                foreach ($request->row as $key => $value){
                    $item_prop = Regitem::where('id', $value['ItemId'])->first();
                    $default_uom = $item_prop->MeasurementId;
                    $new_uom = $value['uom'] ?? $default_uom;
                    $conversion_factor = 1;
                    $converted_qty = $value['Quantity'];
                    if($default_uom != $new_uom){
                        $conversion_data = conversion::where('FromUomID',$default_uom)->where('ToUomID',$new_uom)->first();
                        $conversion_factor = $conversion_data->Amount;
                        $converted_qty = round(($value['Quantity'] / $conversion_factor),2);
                    }

                    $proc_detail_data = purchaseOrderDetails::where('purchaseorder_id',$request->Reference ?? 0)->where('itemid',$value['ItemId'])->first();
                    $proc_detail_rec_id = $proc_detail_data->id ?? 0;

                    $itemname = $value['ItemId'];
                    $quantity = $value['Quantity'];
                    $unitcost = $value['UnitCost'] ?? 0;
                    $beforetaxcost = $value['BeforeTaxCost'] ?? 0;
                    $taxamount = $value['TaxAmount'] ?? 0;
                    $totalcost = $value['TotalCost'] ?? 0;
                    $reqserialnum = $value['RequireSerialNumber'];
                    $reqexpiredate = $value['RequireExpireDate'];
                    $receiving->items()->attach($itemname,
                    [
                        'Quantity' => $quantity,'UnitCost' => $unitcost,'BeforeTaxCost' => $beforetaxcost,
                        'TaxAmount' => $taxamount,'TotalCost' => $totalcost,'TransactionType' => "Receiving",
                        'ItemType' => $request->ProductType, 'StoreId' => $request->store,'DefaultUOMId' => $default_uom,
                        'NewUOMId' => $new_uom,'ConversionAmount' => $conversion_factor,'ConvertedQuantity' => $converted_qty,
                        'RequireSerialNumber' => $reqserialnum,'RequireExpireDate' => $reqexpiredate,'PoDetId' => $proc_detail_rec_id
                    ]);

                    if($request->ReferenceType == 501){
                        DB::table('purchaseordersdetails')
                            ->where('purchaseordersdetails.purchaseorder_id',$request->Reference)
                            ->where('purchaseordersdetails.itemid',$itemname)
                            ->update([
                                'purchaseordersdetails.receivedqty' => DB::raw('(SELECT COALESCE(SUM(receivingdetails.Quantity),0) AS Quantity FROM receivingdetails LEFT JOIN receivings ON receivingdetails.HeaderId=receivings.id WHERE receivings.Status IN("Draft","Pending","Verified","Confirmed") AND receivingdetails.ItemId='.$itemname.' AND receivings.PoId='.$request->Reference.')')
                            ]);
                    }
                }

                if($receiving->Status == "Confirmed"){
                    foreach ($request->row as $key => $value){  
                        $transaction = transactions::updateOrCreate([
                            'HeaderId' => $request->receivingId,
                            'ItemId' => $value['ItemId'],
                            'TransactionsType' => "Receiving",
                        ],[
                            'HeaderId' => $request->receivingId,
                            'ItemId' => $value['ItemId'],
                            'StockIn' => $value['Quantity'],
                            'UnitCost' => $value['UnitCost'] ?? 0,
                            'BeforeTaxCost' => $value['BeforeTaxCost'] ?? 0,
                            'TaxAmountCost' => $value['TaxAmount'] ?? 0,
                            'TotalCost' => $value['TotalCost'] ?? 0,
                            'StoreId' => $receiving->StoreId,
                            'IsVoid' => 0,
                            'TransactionType' => "Receiving",
                            'TransactionsType' => "Receiving",
                            'ItemType' => $request->ProductType,
                            'DocumentNumber' => $receiving->DocumentNumber,
                            'FiscalYear' => $receiving->fiscalyear,
                            'Date' => $receiving->ConfirmedDate,
                        ]);
                    }
                }

                if($request->ReferenceType == 501){
                    $poid = $request->Reference;
                    $commcount = 0;
                    $poreceiveflag = 0;
                    $purcountdata = DB::select('SELECT COUNT(purchaseordersdetails.id) AS CommCount FROM purchaseordersdetails WHERE purchaseordersdetails.purchaseorder_id='.$poid);
                    $commcount = $purcountdata[0]->CommCount;
    
                    $purdetailqty = DB::select('SELECT purchaseordersdetails.qty,purchaseordersdetails.receivedqty FROM purchaseordersdetails WHERE purchaseordersdetails.purchaseorder_id='.$poid);                                
                    foreach($purdetailqty as $row){
                        if($row->receivedqty >= $row->qty){
                            $poreceiveflag+=1;
                        }
                    }
    
                    PurchaseOrder::where('purchaseorders.id',$poid)->update(['purchaseorders.isfullyreceived'=>0]);//to reset old record
                    PurchaseOrder::where('purchaseorders.id',$poid)->update(['purchaseorders.isfullyreceived'=>0]);
                    if($commcount == $poreceiveflag){
                        PurchaseOrder::where('purchaseorders.id',$poid)->update(['purchaseorders.isfullyreceived'=>1]);
                    }
                }

                $actions = $findid == null ? "Created" : "Edited";

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $receiving->id,
                    'pagename' => "receiving",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => $fiscalr,'fiscalyr' => $fyear,'receivingId' => $receiving->id]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }    

        else if($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);
        }
        else if($v2->fails()){
            return response()->json(['errorv2' => $v2->errors()->all()]);
        }
        else if($request->row == null){
            return Response::json(['empty_table' => 460]);
        }
    }

    public function saveHoldReceiving(Request $request)
    {
        $settings = DB::table('settings')->latest()->first();
        $rprefix=$settings->GRVPrefix;
        $rnumber=$settings->GRVNumber;
        $witholdAmnt=$settings->WitholdMinimumAmount;
        $fyear=$settings->FiscalYear;
        $suffixdoc=$fyear-2000;
        $suffixdocs=$suffixdoc+1;
        $rnumberPadding=sprintf("%05d", $rnumber);
        $receivingNumber=$rprefix.$rnumberPadding."/".$suffixdoc."-".$suffixdocs;

        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->tid;
        $headeridinput=$request->tid;
        $holdheaderid=$request->tid;
        $findid=$request->tid;
        $vnumber=$request->VoucherNumber;
        $customerid=$request->supplier;
        $mrcnum=$request->MrcNumber;
        $cusid=$request->supplier;
        $validator = Validator::make($request->all(), [
            $receivingNumber=>"unique:receivings,DocumentNumber,$findid",
            'supplier' => ['required'],
            'PaymentType' => ['required'],
            'VoucherStatus' => ['required'],
            'voucherType' => ['required_if:VoucherStatus,1'],
            'VoucherNumber' => ['required_if:VoucherStatus,1'],
            'MrcNumber' => ['required_if:voucherType,Fiscal-Receipt'],
            'date' => ['required','before:now'],
            'store' => ['required'],
            'Purchaser' => ['required'],
        ]);

            if ($validator->passes())
            {
                try
                {
                    $storeid=$request->store;
                    $rec=new receiving;
                    $rec->Type="Direct";
                    $rec->DocumentNumber=$receivingNumber;
                    $rec->CustomerId=trim($request->input('supplier'));
                    $rec->PaymentType=trim($request->input('PaymentType'));
                    $rec->VoucherStatus=trim($request->input('VoucherStatus'));
                    $rec->VoucherType=trim($request->input('voucherType'));
                    $rec->VoucherNumber=trim($request->input('VoucherNumber'));
                    $rec->CustomerMRC=trim($request->input('MrcNumber'));
                    $rec->StoreId=trim($request->input('store'));
                    $rec->PurchaserName=trim($request->input('Purchaser'));
                    $rec->IsVoid=0;
                    $rec->VoidReason="-";
                    $rec->VoidedBy="-";
                    $rec->VoidedDate="0000-00-00";
                    $rec->TransactionDate=trim($request->input('date'));
                    $rec->Status="Pending";
                    $rec->StatusOld="-";
                    $rec->WitholdPercent=trim($request->input('witholdPercenti'));
                    $rec->WitholdAmount=trim($request->input('witholdingAmntin'));
                    $rec->SubTotal=trim($request->input('subtotali'));
                    $rec->Tax=trim($request->input('taxi'));
                    $rec->GrandTotal=trim($request->input('grandtotali'));
                    $rec->NetPay=trim($request->input('netpayin'));
                    $rec->Username= $user;
                    $rec->ReceivedBy="-";
                    $rec->DeliveredBy="-";
                    $rec->Common=trim($request->input('commonVal'));
                    $rec->Memo="-";
                    $rec->fiscalyear=$fyear;
                    $rec->save();

                    $comn=$request->commonVal;
                    $receiving = DB::table('receivings')->where('Common', $comn)->latest()->first();
                    $headerid=$receiving->id;
  
                    $syncToReceivingDetail=DB::select('INSERT INTO receivingdetails(ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,LocationId,RetailerPrice,Wholeseller,Date,RequireSerialNumber,RequireExpireDate,ConvertedQuantity,ConversionAmount,NewUOMId,DefaultUOMId,IsVoid,Memo,TransactionType,TransactionsType,ItemType,HeaderId,Common)SELECT ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,LocationId,RetailerPrice,Wholeseller,Date,RequireSerialNumber,RequireExpireDate,ConvertedQuantity,ConversionAmount,NewUOMId,DefaultUOMId,IsVoid,Memo,TransactionType,TransactionsType,ItemType,'.$headerid.','.$comn.' FROM receivingholddetails WHERE receivingholddetails.HeaderId='.$holdheaderid);
                   
                    $updn=DB::select('update settings set GRVNumber=GRVNumber+1 where id=1');
                    $updStore=DB::select('update receivingdetails set StoreId='.$storeid.' where HeaderId='.$headerid.'');
                    $deleteHoldData=DB::select('DELETE FROM receivingholddetails WHERE HeaderId='.$holdheaderid);
                    $holdData = receivinghold::find($holdheaderid);
                    $holdData->delete();
                    return Response::json(['success' => '1','receivingId'=>$headerid]);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
        //}      
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function storeNewRecItem(Request $request)
    {
        $headerid=$request->recevingedit;
        $storeid=$request->receivingstoreid;
        $ss=$request->receivingidinput;
        $findid=$request->recevingedit;
        $valId=$request->editVal;
        $hids=$request->receIds;

        if($findid==null)
        {
            $validator = Validator::make($request->all(), [
                'addHoldItem' => ['required',
                Rule::unique('receivingdetails', 'ItemId')->where(function ($query) use ($hids) {
                    return $query->where('HeaderId', $hids);
                })
                ],
                'quantityhold' =>"required|numeric|min:1|not_in:0'",
                'unitcosthold' =>"required",
            ]);

           
        }
        if($findid!=null)
        {
            $validator = Validator::make($request->all(), [
                'addHoldItem' =>'required',
                'quantityhold' =>"required|numeric|min:1|gt:0",
                'unitcosthold' =>"required|numeric|min:1|gt:0",
            ]);

        }

        if($validator->passes())
        {
            try
            {
                $hold=receivingdetail::updateOrCreate(['id' => $request->recevingedit], [
                'HeaderId' => trim($request->receIds),
                'ItemId' => trim($request->addHoldItem),
                'Quantity' => trim($request->quantityhold),
                'UnitCost' =>trim($request->unitcosthold),
                'BeforeTaxCost' =>trim($request->beforetaxhold),
                'TaxAmount' => trim($request->taxamounthold),
                'TotalCost' => trim($request->totalcosthold),
                'StoreId' => trim($request->receivingstoreid),
                'ConvertedQuantity' => trim($request->convertedqi),
                'ConversionAmount' => trim($request->convertedamnti),
                'NewUOMId' => trim($request->newuomi),
                'DefaultUOMId' => trim($request->defaultuomi),
                'ItemType' => trim($request->itemtypei),
                'TransactionType' =>"Receiving"
                  ]);
                    $countitem = DB::table('receivingdetails')->where('HeaderId', '=', $hids)->get();
                    $getCountItem = $countitem->count();
                    
                    $pricing = DB::table('receivingdetails')
                    ->select(DB::raw('SUM(BeforeTaxCost) as BeforeTaxCost,SUM(TaxAmount) as TaxAmount,SUM(TotalCost) as TotalCost'))
                    ->where('HeaderId', '=', $hids)
                    ->get();
    
                    $updprice=DB::select('update receivings set SubTotal=(SELECT SUM(BeforeTaxCost) FROM receivingdetails WHERE HeaderId='.$hids.'),
                    Tax=(SELECT SUM(TaxAmount) FROM receivingdetails WHERE HeaderId='.$hids.'),
                    GrandTotal=(SELECT SUM(TotalCost) FROM receivingdetails WHERE HeaderId='.$hids.')
                    where id='.$hids.'');
    
                return Response::json(['success' =>  '1','Totalcount'=>$getCountItem,'PricingVal'=>$pricing]);
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

    public function SettleWitholdCon(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $receiving_id = $request->currRecId;
        $rec_data = receiving::find($receiving_id);
        $customerid = $request->WitholdCustomerId;
        $transactiondate = $request->witholdTransactionDate;
        $receiptnumber = $request->ReceiptNumber;
        $ids = $request->input('settleSeparateCbx', []); 
        $ids = implode(', ', $ids);
        $recId = $request->recSettIds;
        $withold_flag = $request->witholdRecFlag;
        $settleName = "Settled";
      
        if($receiptnumber != null)
        {
            $getRecProperty = DB::select('SELECT COUNT(id) AS CountId FROM receivings WHERE WitholdReceipt='.$receiptnumber.' AND receivings.id NOT IN('.$ids.')');
            $cid = $getRecProperty[0]->CountId;
            if($cid >= 1)
            {
                return Response::json(['recerror' => "error"]);
            }
        }

        $validator = Validator::make($request->all(), [
            'ReceiptNumber' =>'required|numeric',
            'ReceiptDate' => "required",
        ]);

        if($validator->passes())
        {
            DB::beginTransaction();
            try{

                DB::select('UPDATE receivings SET WitholdReceipt='.$receiptnumber.',withhold_receipt_date="'.$request->ReceiptDate.'",IsWitholdSettle="'.$settleName.'",IsSeparatelySettled=1 WHERE id IN('.$ids.')');

                $commonData = [
                    'user_id' => $userid,
                    'pagename' => "receiving",
                    'action' => "Withholding Settled",
                    'status' => "Withholding Settled",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];

                $recordsToInsert = [];

                foreach ($request->input('settleSeparateCbx', []) as $sett_ids) {
                    $recordsToInsert[] = array_merge([
                        'pageid' => $sett_ids
                    ],$commonData);
                }

                DB::table('actions')->insert($recordsToInsert);

                DB::commit();
                return Response::json(['success' => 1, 'recId' => $receiving_id, 'vStatus' => $rec_data->VoucherStatus, 'cus_id' => $rec_data->CustomerId, 'trn_date' => $rec_data->TransactionDate]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function unsettledControl(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $receiving_id = $request->currRecId;
        $rec_data = receiving::find($receiving_id);
        $ids = $request->input('settleSeparateCbx', []); 
        $ids = implode(', ', $ids);
        $customerid = $request->UnWitholdCustomerId;
        $transactiondate = $request->UnwitholdTransactionDate;
        $receiptnumber = $request->ReceiptNumber;
        $recId = $request->singleUnSettledId;
        $currentDate = Carbon::today()->toDateString();
        $notSettled = "Not-Settled";
        $settleName = "Settled";

        DB::beginTransaction();
        try{
            
            DB::select('UPDATE receivings SET WitholdReceipt=NULL,IsWitholdSettle="'.$notSettled.'",withhold_receipt_date="",IsSeparatelySettled=0 WHERE id IN('.$ids.')');

            $commonData = [
                'user_id' => $userid,
                'pagename' => "receiving",
                'action' => "Withholding Unsettled",
                'status' => "Withholding Unsettled",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'reason' => "",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $recordsToInsert = [];

            foreach ($request->input('settleSeparateCbx', []) as $sett_ids) {
                $recordsToInsert[] = array_merge([
                    'pageid' => $sett_ids
                ],$commonData);
            }

            DB::table('actions')->insert($recordsToInsert);

            DB::commit();
            return Response::json(['success' => 1, 'recId' => $receiving_id, 'vStatus' => $rec_data->VoucherStatus, 'cus_id' => $rec_data->CustomerId, 'trn_date' => $rec_data->TransactionDate]);
        }
        catch(Exception $e){
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function SettleWitholdConSep(Request $request){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $receiptnumber=$request->ReceiptNumbers;
        $ids=$request->separatesettid;
        $settleName="Settled";
      
        $currentDate=Carbon::today()->toDateString();
        
        if($receiptnumber!=null)
        {
            $getRecProperty=DB::select('SELECT COUNT(id) AS CountId FROM receivings WHERE WitholdReceipt='.$receiptnumber.' AND id!='.$ids.'');
            foreach($getRecProperty as $row)
            {
                $cnt=$row->CountId;
                if($cnt>=1)
                {
                    return Response::json(['recerror' =>  "error",'cnt'=>$cnt]);
                }
            }  
        }

        $validator = Validator::make($request->all(), [
            'ReceiptNumbers' =>'required|numeric',
        ]);

        if($validator->passes())
        {
            try
            {
                $updateReceipt=DB::select('update receivings set WitholdReceipt='.$receiptnumber.',IsWitholdSettle="'.$settleName.'",WitholdSettledBy="'.$user.'",WitholdSettleDate="'.$currentDate.'",IsSeparatelySettled=1 where id='.$ids.'');
                return Response::json(['success' =>  '1']);
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

    public function fetchReceivingRefDoc(Request $request){
        $reference_type = $_POST['reference_type'];
        $direct_data = "";
        $purchase_order_data = "";
        $purchase_invoice_data = "";
        $unorder_data = "";

        if($reference_type == 501){
            $purchase_order_data = DB::select('SELECT purchaseorders.id AS po_id,purchaseorders.customers_id AS supplier_id,CONCAT_WS(", ",NULLIF(purchaseorders.porderno, ""), NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS po_data FROM purchaseorders LEFT JOIN customers ON purchaseorders.customers_id=customers.id WHERE purchaseorders.purchaseordertype="Goods" AND purchaseorders.status=3 AND purchaseorders.isfullyreceived IN(0,2,3) ORDER BY purchaseorders.id ASC');
        }
        else if($reference_type == 502){
            $purchase_invoice_data = DB::select('SELECT purchaseinvoices.id AS pi_id,supplier AS supplier_id,CONCAT_WS(", ",NULLIF(purchaseinvoices.docno, ""), NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS pi_data FROM purchaseinvoices LEFT JOIN customers ON purchaseinvoices.supplier=customers.id WHERE purchaseinvoices.status=3 ORDER BY purchaseinvoices.id ASC');
        }
        return response()->json(['purchase_order_data' => $purchase_order_data,'purchase_invoice_data' => $purchase_invoice_data]);
    }

    public function fetchReceivingRefData(Request $request){
        $reference_type = $_POST['reference_type'];
        $reference_id = $_POST['reference_id'];

        $purchase_order_data = "";
        $purchase_invoice_data = "";
        $purchase_detail_data = "";
        $supplier_data = "";

        if($reference_type == 501){
            $purchase_order_data = DB::select('SELECT purchaseorders.id,purchaseorders.customers_id AS supplier_id,purchaseorders.purchaseordertype,purchaseorders.deliverydate,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS supplier FROM purchaseorders LEFT JOIN customers ON purchaseorders.customers_id=customers.id WHERE purchaseorders.id='.$reference_id);
            $purchase_detail_data = DB::select('SELECT purchaseordersdetails.id,purchaseordersdetails.purchaseorder_id,purchaseordersdetails.itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,purchaseordersdetails.uom,uoms.Name AS uom_name,regitems.RequireSerialNumber,regitems.RequireExpireDate,purchaseordersdetails.qty,purchaseordersdetails.receivedqty FROM purchaseordersdetails LEFT JOIN regitems ON purchaseordersdetails.itemid=regitems.id LEFT JOIN uoms ON purchaseordersdetails.uom=uoms.id WHERE purchaseordersdetails.purchaseorder_id='.$reference_id.' ORDER BY purchaseordersdetails.id ASC');
        }
        else if($reference_type == 502){
            $purchase_invoice_data = DB::select('SELECT purchaseinvoices.id,purchaseinvoices.supplier AS supplier_id,purchaseinvoices.productype,purchaseinvoices.invoicedate,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS supplier FROM purchaseinvoices LEFT JOIN customers ON purchaseinvoices.supplier=customers.id WHERE purchaseinvoices.id='.$reference_id);
        }

        return response()->json([
            'purchase_order_data' => $purchase_order_data,
            'purchase_invoice_data' => $purchase_invoice_data,
            'purchase_detail_data' => $purchase_detail_data
        ]);
    }

    public function fetchItemInfo(Request $request){
        $reference_type = $_POST['reference_type'];
        $reference_id = $_POST['reference_id'];
        $itemid = $_POST['itemid'];

        $item_info = "";

        if($reference_type == 501){
            $item_info = DB::select('SELECT purchaseordersdetails.id,purchaseordersdetails.purchaseorder_id,purchaseordersdetails.itemid,CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS items,purchaseordersdetails.uom,uoms.Name AS uom_name,regitems.*,purchaseordersdetails.qty,purchaseordersdetails.receivedqty FROM purchaseordersdetails LEFT JOIN regitems ON purchaseordersdetails.itemid=regitems.id LEFT JOIN uoms ON purchaseordersdetails.uom=uoms.id WHERE purchaseordersdetails.purchaseorder_id='.$reference_id.' AND purchaseordersdetails.itemid='.$itemid);
        }
        else if($reference_type == 502){

        }
        else{
            $item_info = DB::select('SELECT regitems.*,uoms.id AS uom,uoms.Name AS uom_name FROM regitems LEFT JOIN uoms ON regitems.MeasurementId=uoms.id WHERE regitems.id='.$itemid);
        }

        return response()->json(['item_info' => $item_info]);
    }

    public function getAllUoms(Request $request,$id){
        ini_set('max_execution_time', '30000');
        ini_set("pcre.backtrack_limit", "500000000");
        $regitem = DB::table('regitems')->where('id', $id)->latest()->first();
        $uomid = $regitem->MeasurementId;
        $retailerp = $regitem->RetailerPrice;
        $wholeseller = $regitem->WholesellerPrice;
        $taxper = $regitem->TaxTypeId;
        $itemtype = $regitem->Type;
        $cnv = uom::find($uomid);
        $defuom = $cnv->Name;
        $conv = DB::select('SELECT t.id,t.FromUomID,w1.Name AS FromUnitName,t.ToUomID,w2.Name AS ToUnitName,t.Amount,t.ActiveStatus FROM conversions AS t JOIN uoms AS w1 on w1.id=t.FromUomID JOIN uoms AS w2 on w2.id=t.ToUomID WHERE t.FromUomID='.$uomid.' AND t.ActiveStatus="Active"');
        $getCost = DB::select('SELECT UnitCost FROM transactions WHERE ItemId='.$id.' AND TransactionsType NOT IN("Void","Undo-Void")ORDER BY id DESC LIMIT 1');
        if($getCost == null){
            $getLastCost = 0;
        }
        foreach($getCost as $row){
            if($row != null)
            {
                $getLastCost = $row->UnitCost;
            }
            if($row == null)
            {
                $getLastCost = 0;
            }
            if($row == "")
            {
                $getLastCost = 0;
            }
        }
        
        return response()->json(['sid'=>$conv,'defuom'=>$defuom,'defuomid'=>$uomid,'lastCost'=>$getLastCost,'retailer'=>$retailerp,'wholeseller'=>$wholeseller,'taxpr'=>$taxper,'itemtype'=>$itemtype]);
    }
    
    public function getConversionAmount(Request $request,$id,$nid){
        $conversion = DB::table('conversions')->where('FromUomID', $id)->where('ToUomID', $nid)->latest()->first();
        $amnt=$conversion->Amount;
        return response()->json(['sid'=>$amnt]);
    }

    public function showReceivingDetailData($id)
    {
        $HeaderId=$id;
        $columnName="HeaderId";
        $detailTable=DB::select('SELECT receivingdetails.id,receivingdetails.ItemId,receivingdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKU,regitems.RequireSerialNumber,regitems.RequireExpireDate,uoms.Name AS UOM,receivingdetails.Quantity,receivingdetails.UnitCost,receivingdetails.BeforeTaxCost,receivingdetails.TaxAmount,receivingdetails.TotalCost,receivingdetails.StoreId,(SELECT COUNT(item_id) FROM serialandbatchnums WHERE item_id=receivingdetails.ItemId AND header_id=receivingdetails.HeaderId) AS ItemCount FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id INNER JOIN uoms ON receivingdetails.NewUOMId=uoms.id where receivingdetails.HeaderId='.$HeaderId);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            $addserbtn="";
            $btn =  ' <a data-id="'.$data->id.'" data-HeaderId="'.$data->HeaderId.'" data-uom="'.$data->UOM.'" class="btn btn-icon btn-gradient-info btn-sm editRecDatas" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            $btn = $btn.' <a data-id="'.$data->id.'" data-hid="'.$data->HeaderId.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#receivingremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
            if($data->RequireSerialNumber=='Not-Require' && $data->RequireExpireDate=='Not-Require'){
                $addserbtn="";
            }
            else{
                $addserbtn = ' <a data-id="'.$data->id.'" data-HeaderId="'.$data->HeaderId.'" data-headerid="'.$data->HeaderId.'" data-uom="'.$data->UOM.'" data-reqsn="'.$data->RequireSerialNumber.'" data-reqed="'.$data->RequireExpireDate.'" data-itemid="'.$data->ItemId.'" data-storeid="'.$data->StoreId.'" data-itemcnt="'.$data->ItemCount.'" data-qnt="'.$data->Quantity.'" data-itmname="'.$data->ItemName.'" class="btn btn-icon btn-gradient-info btn-sm addSerialnumbes" data-toggle="modal" id="mediumButton" style="color: white;" title="Add serial number, batch number or expire date"><i class="fa fa-plus"></i></a>';
            }     
            
            return $btn.$addserbtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showHoldDetailData($id)
    {
        $HeaderId=$id;
        $columnName="HeaderId";
        $detailTable=DB::select('SELECT receivingholddetails.id,receivingholddetails.ItemId,receivingholddetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,uoms.Name AS UOM,regitems.SKUNumber AS SKUNumber,uoms.Name AS UOM,receivingholddetails.Quantity,receivingholddetails.UnitCost,receivingholddetails.BeforeTaxCost,receivingholddetails.TaxAmount,receivingholddetails.TotalCost FROM receivingholddetails INNER JOIN regitems ON receivingholddetails.ItemId=regitems.id INNER JOIN uoms ON receivingholddetails.NewUOMId=uoms.id where receivingholddetails.HeaderId='.$HeaderId);
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                $btn = ' <a data-id="'.$data->id.'" data-HeaderId="'.$data->HeaderId.'" data-uom="'.$data->UOM.'" class="btn btn-icon btn-gradient-info btn-sm editHoldItem" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                $btn = $btn.' <a data-id="'.$data->id.'" data-hid="'.$data->HeaderId.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#holdremovemodal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showRecDetailData($id){
        $HeaderId=$id;
        $columnName="HeaderId";
        $detailTable=DB::select('SELECT receivingdetails.id,receivingdetails.ItemId,receivingdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,regitems.TaxTypeId,uoms.Name AS UOM,receivingdetails.Quantity,receivingdetails.UnitCost,receivingdetails.BeforeTaxCost,receivingdetails.TaxAmount,receivingdetails.TotalCost,COALESCE(CONCAT((SELECT GROUP_CONCAT(BatchNumber," ") FROM serialandbatchnums WHERE header_id=receivingdetails.HeaderId AND item_id=regitems.id AND serialandbatchnums.TransactionType=2)),"") AS BatchNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT(SerialNumber," ") FROM serialandbatchnums WHERE header_id=receivingdetails.HeaderId AND item_id=regitems.id AND serialandbatchnums.TransactionType=2)),"") AS SerialNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT(ExpireDate," ") FROM serialandbatchnums WHERE header_id=receivingdetails.HeaderId AND item_id=regitems.id AND serialandbatchnums.TransactionType=2)),"") AS ExpireDate,COALESCE(CONCAT((SELECT GROUP_CONCAT(ManufactureDate," ") FROM serialandbatchnums WHERE header_id=receivingdetails.HeaderId AND item_id=regitems.id AND serialandbatchnums.TransactionType=2)),"") AS ManufactureDate,regitems.RequireSerialNumber,regitems.RequireExpireDate FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id INNER JOIN uoms ON receivingdetails.NewUOMId=uoms.id where receivingdetails.HeaderId='.$HeaderId.' order by receivingdetails.id asc');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showWitholdingDataTable($cusId,$trDate){
        $detailTable=DB::select('SELECT receivings.id,receivings.Type,receivings.DocumentNumber,receivings.VoucherNumber,receivings.SubTotal,receivings.WitholdReceipt,receivings.IsSeparatelySettled,receivings.withhold_receipt_date FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND receivings.Status NOT IN("Void") AND customers.CustomerCategory NOT IN("Foreigner-Supplier","Person")');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            $btn =  '<input type="checkbox" data-id="'.$data->id.'" class="btn btn-icon btn-xl settleSeparateCbx">';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showWitholdingDataTableSep($cusId,$trDate){
        $detailTable=DB::select('SELECT receivings.id,receivings.Type,receivings.DocumentNumber,receivings.VoucherNumber,receivings.SubTotal,receivings.WitholdReceipt,receivings.IsSeparatelySettled FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND receivings.Status NOT IN("Void") AND customers.CustomerCategory NOT IN("Foreigner-Supplier","Person") AND receivings.IsSeparatelySettled=0');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            $btn =  '<a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-warning btn-sm settleSeparate" onclick="settleSeparate('.$data->id.')" data-toggle="modal" id="mediumButton" style="color: white;" title="Add / Edit WitholdReceipt"><i class="fa fa-plus"></i></a>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showWitholdingDataTableSepSelected($cusId,$trDate,$ids){
        $detailTable=DB::select('SELECT receivings.id,receivings.Type,receivings.DocumentNumber,receivings.VoucherNumber,receivings.SubTotal,receivings.WitholdReceipt,receivings.IsSeparatelySettled FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.TransactionDate="'.$trDate.'" AND receivings.CustomerId='.$cusId.' AND receivings.Status NOT IN("Void") AND customers.CustomerCategory NOT IN("Foreigner-Supplier","Person") AND receivings.id IN('.$ids.')');
        return datatables()->of($detailTable)
        ->addIndexColumn()
            ->addColumn('action', function($data)
            {     
                 $btn =  '<a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-warning btn-sm settleSeparate" onclick="settleSeparate('.$data->id.')" data-toggle="modal" id="mediumButton" style="color: white;" title="Add / Edit WitholdReceipt"><i class="fa fa-plus"></i></a>';
                  return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    function generateDocumentNumberFn($type, $fyear, $recId = null){
        $fyear = (int)$fyear;
        $currentShort = substr($fyear, -2);
        $nextShort = substr($fyear + 1, -2);
        $fiscalyear_formatted = $currentShort . '-' . $nextShort;

        if($recId == null){
            $currentNumber = DB::table('receivings')
                            ->where('fiscalyear',$fyear)
                            ->where('source_type',$type)
                            ->orderByDesc('CurrentDocumentNumber')
                            ->latest()
                            ->first();

            $newNumber = (int)($currentNumber->CurrentDocumentNumber ?? 0) + 1;
            return $this->getDocTypeFn($type) . '-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT). '/' .$fiscalyear_formatted;
        }

        if($recId != null){
            $rec_data = receiving::where('id', $recId)->first();

            if($rec_data->source_type == $type){
                return $rec_data->DocumentNumber;
            }
            else{
                $currentNumber = DB::table('receivings')
                            ->where('fiscalyear',$fyear)
                            ->where('source_type',$type)
                            ->orderByDesc('CurrentDocumentNumber')
                            ->latest()
                            ->first();
                
                $newNumber = (int)($currentNumber->CurrentDocumentNumber ?? 0) + 1;
                return $this->getDocTypeFn($type) . '-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT). '/' .$fiscalyear_formatted;
            } 
        }
    }

    function getDocTypeFn($type){
        // Get prefixes from settings
        $prefix = DB::table('settings')->latest()->first();
        
        if (in_array(strtolower($type), ['purchase', 'pur'])){
            $docPrefix = $prefix->GRVPrefix ?? 'GRN-PUR';
        } 
        else if (in_array(strtolower($type), ['production', 'prd'])){
            $docPrefix = $prefix->production_grv_prefix ?? 'GRN-PRD';
        }
        else{
            throw new \InvalidArgumentException('Invalid document type. Use "purchase" or "production".');
        }

        return $docPrefix;
    }

    function validateInventoryItemBalances($items, $storeId,$fyear, $transactionId = null){
        $negativeItems = [];
        $test = [];
        $trn_type = ["Begining","Beginning","Receiving","Issue","Sales","Transfer","Requisition","Adjustment"];

        $detail_item = DB::table('transactions')
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

            $transactions = DB::table('transactions')
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

                if ($transaction->HeaderId == $transactionId && $transaction->TransactionType == 'Receiving') {
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

    public function editHold($id){
        $countitem = DB::table('receivingholddetails')->where('HeaderId', '=', $id)
            ->get();
        $getCountItem = $countitem->count();
        $rechold = receivinghold::find($id);

        $data = receivingholddetail::join('receivingholds', 'receivingholddetails.HeaderId', '=', 'receivingholds.id')
            ->join('regitems', 'receivingholddetails.ItemId', '=', 'regitems.id')
            ->join('uoms', 'receivingholddetails.DefaultUOMId', '=', 'uoms.id')
            ->where('receivingholddetails.HeaderId', $id)
            ->orderBy('receivingholddetails.id','asc')
            ->get(['receivingholds.*','receivingholddetails.*','receivingholddetails.Common AS recdetcommon','receivingholddetails.StoreId AS recdetstoreid',
            'receivingholddetails.RequireSerialNumber AS ReSerialNm','receivingholddetails.RequireExpireDate AS ReExpDate','regitems.Name AS ItemName','regitems.Code AS ItemCode',DB::raw('IFNULL(regitems.SKUNumber,"") AS SKUNumber'),
            'uoms.Name AS UomName','regitems.TaxTypeId']);

        return response()->json(['recHold'=>$rechold,'count'=>$getCountItem,'receivingdt'=>$data]);
    }

    public function editReceiving($id){
        $countitem = DB::table('receivingdetails')->where('HeaderId', '=', $id)->get();
        $getCountItem = $countitem->count();

        $recdata = receiving::leftJoin('customers','receivings.CustomerId','customers.id')
        ->leftJoin('purchaseorders','receivings.PoId','purchaseorders.id')
        ->leftJoin('lookuprefs','receivings.Type','lookuprefs.id')
        ->where('receivings.id',$id)
        ->get(['receivings.*','lookuprefs.LookupName AS reference_type','purchaseorders.porderno','purchaseorders.deliverydate',DB::raw('IFNULL(receivings.Memo,"") AS Memo'),
                'customers.Name','customers.TinNumber','customers.PhoneNumber','customers.OfficePhone',
                DB::raw('CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS supplier_name')
            ]);

        $customerid = $recdata[0]->CustomerId;
        $strid = $recdata[0]->StoreId;
        $status = $recdata[0]->Status;
        $recfiscalyr = $recdata[0]->fiscalyear;
        $rectype = $recdata[0]->Type;
        $product_type = $recdata[0]->ProductType == "Commodity" ? 1 : 2;

        $strdata=store::findorFail($strid);
        $fiscalyears=$strdata->FiscalYear;

        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        $cusdata=customer::find($customerid);
        $custmercategory=$cusdata->CustomerCategory;

        $data = receivingdetail::leftJoin('receivings', 'receivingdetails.HeaderId', '=', 'receivings.id')
            ->leftJoin('regitems','receivingdetails.ItemId', '=', 'regitems.id')
            ->leftJoin('uoms','receivingdetails.NewUOMId', '=', 'uoms.id')
            ->leftJoin('purchaseordersdetails','receivingdetails.PoDetId', '=', 'purchaseordersdetails.id')
            ->where('receivingdetails.HeaderId', $id)
            ->orderBy('receivingdetails.id','asc')
            ->get(['receivings.*','receivingdetails.*','receivingdetails.Common AS recdetcommon','receivingdetails.StoreId AS recdetstoreid',
                'receivingdetails.RequireSerialNumber AS ReSerialNm','receivingdetails.RequireExpireDate AS ReExpDate','regitems.Name AS ItemName','regitems.Code AS ItemCode',DB::raw('IFNULL(regitems.SKUNumber,"") AS SKUNumber'),
                'uoms.Name AS UomName','regitems.TaxTypeId',DB::raw('CONCAT_WS(", ", NULLIF(regitems.Code, ""), NULLIF(regitems.Name, ""), NULLIF(regitems.SKUNumber, "")) AS item_name'),'purchaseordersdetails.qty AS ordered_qty',
                'purchaseordersdetails.receivedqty AS received_qty'
            ]);

        $origindata=DB::select('SELECT receivingdetails.CommodityType AS CommTypeId,lookups.CommodityType AS CommType,crplookup.CropYear AS CropYearData,grdlookup.Grade AS GradeName,CONCAT_WS(", ", NULLIF(regions.Rgn_Name, ""), NULLIF(zones.Zone_Name, ""), NULLIF(woredas.Woreda_Name, "")) AS Origin,regitems.Name AS item_name,uoms.Name AS UomName,receivingdetails.*, IFNULL(receivingdetails.Memo,"") AS Remark,ROUND((receivingdetails.NetKg/1000),2) AS WeightByTon,uoms.Name as UomName,locations.Name AS LocationName,VarianceShortage,VarianceOverage,receivingdetails.NetKg,receivings.PoId FROM receivingdetails LEFT JOIN receivings ON receivingdetails.HeaderId=receivings.id LEFT JOIN woredas ON receivingdetails.CommodityId = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions ON zones.Rgn_Id = regions.id LEFT JOIN uoms ON receivingdetails.NewUomId = uoms.id LEFT JOIN locations ON receivingdetails.LocationId=locations.id LEFT JOIN lookups ON receivingdetails.CommodityType=lookups.CommodityTypeValue LEFT JOIN lookups AS crplookup ON receivingdetails.CropYear=crplookup.CropYearValue LEFT JOIN lookups AS grdlookup ON receivingdetails.Grade=grdlookup.GradeValue LEFT JOIN regitems ON receivingdetails.ItemId=regitems.id WHERE receivingdetails.HeaderId = '.$id.' ORDER BY receivingdetails.id ASC');

        return response()->json(['recData'=>$recdata,'origindata'=>$origindata,'count'=>$getCountItem,'receivingdt'=>$data,'cuscatdata'=>$custmercategory,'fiscalyr'=>$fiscalyr,'fiscalyrval'=>$fiscalyears,'fiscalyear'=>$recfiscalyr,'status'=>$status,'rectype'=>$rectype,'product_type'=>$product_type]);
    }

    public function editHoldItem($id){
        $recholdId = receivingholddetail::find($id);
        return response()->json(['recHoldId'=>$recholdId]);
    }

    public function editReceivingItem($id){
        $recdataId = receivingdetail::find($id);
        return response()->json(['recDataId'=>$recdataId]);
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

    public function deleteHoldData($id)
    {
        $deleteHoldData=DB::select('DELETE FROM receivingholddetails WHERE HeaderId='.$id);
        $holdData = receivinghold::find($id);
        $holdData->delete();
        return Response::json(['success' => 'Hold Data Removed']);
    }

    public function deleteHoldItem(Request $request, $id)
    {
        $headerid=$request->holdremoveheaderid;
        $st=$request->subtotali;
        $holdItem = receivingholddetail::find($id);
        $holdItem->delete();

        $countitem = DB::table('receivingholddetails')->where('HeaderId', '=', $headerid)->get();
        $getCountItem = $countitem->count();

        $pricing = DB::table('receivingholddetails')
        ->select(DB::raw('SUM(BeforeTaxCost) as BeforeTaxCost,SUM(TaxAmount) as TaxAmount,SUM(TotalCost) as TotalCost'))
        ->where('HeaderId', '=', $headerid)
        ->get();
        $updprice=DB::select('update receivingholds set SubTotal=(SELECT SUM(BeforeTaxCost) FROM receivingholddetails WHERE HeaderId='.$headerid.'),
        Tax=(SELECT SUM(TaxAmount) FROM receivingholddetails WHERE HeaderId='.$headerid.'),
        GrandTotal=(SELECT SUM(TotalCost) FROM receivingholddetails WHERE HeaderId='.$headerid.')
        where id='.$headerid.'');

        return Response::json(['success' => 'Item Removed','Totalcount'=>$getCountItem,'PricingVal'=>$pricing]);
    }

    public function deleteReceivingItem(Request $request, $id)
    {
        $headerid=$request->receivingremoveheaderid;
        $st=$request->subtotali;
        $recevingItem = receivingdetail::find($id);
        $recevingItem->delete();

        $countitem = DB::table('receivingdetails')->where('HeaderId', '=', $headerid)->get();
        $getCountItem = $countitem->count();

        $pricing = DB::table('receivingdetails')
        ->select(DB::raw('SUM(BeforeTaxCost) as BeforeTaxCost,SUM(TaxAmount) as TaxAmount,SUM(TotalCost) as TotalCost'))
        ->where('HeaderId', '=', $headerid)
        ->get();
        $updprice=DB::select('update receivings set SubTotal=(SELECT SUM(BeforeTaxCost) FROM receivingdetails WHERE HeaderId='.$headerid.'),
        Tax=(SELECT SUM(TaxAmount) FROM receivingdetails WHERE HeaderId='.$headerid.'),
        GrandTotal=(SELECT SUM(TotalCost) FROM receivingdetails WHERE HeaderId='.$headerid.')
        where id='.$headerid.'');
        return Response::json(['success' => 'Item Removed','Totalcount'=>$getCountItem,'PricingVal'=>$pricing]);
    }

    public function updateChecked(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->checkedid;
        
        $getCheckedVal=DB::select('SELECT COUNT(ItemId) AS ItemCount FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id WHERE HeaderId='.$findid.' AND receivingdetails.Quantity!=(SELECT COUNT(ItemId) FROM serialandbatchnums WHERE serialandbatchnums.header_id=receivingdetails.HeaderId AND serialandbatchnums.item_id=receivingdetails.ItemId) AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require")');
        foreach($getCheckedVal as $row)
        {
            $avaq=$row->ItemCount;
        }
        $avaqp = (float)$avaq;
        if($avaqp>=1){
            $getItemName=DB::select('SELECT regitems.Name AS ItemName FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id WHERE HeaderId='.$findid.' AND receivingdetails.Quantity!=(SELECT COUNT(ItemId) FROM serialandbatchnums WHERE serialandbatchnums.header_id=receivingdetails.HeaderId AND serialandbatchnums.item_id=receivingdetails.ItemId) AND (regitems.RequireSerialNumber!="Not-Require" OR regitems.RequireExpireDate!="Not-Require")');
            return Response::json(['valerror' =>"error",'countedval'=>$avaqp,'countItems'=>$getItemName]);
        }
        else{
            $rec=receiving::find($findid);
            $rec->CheckedBy= $user;
            $rec->CheckedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $rec->Status="Verified";
            $rec->save();
            actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"receiving",'action'=>"Verified",'status'=>"Verified",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            return Response::json(['success' => '1']);
        }   
    }

    public function updatePending(Request $request){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->pendingid;
        $rec=receiving::find($findid);
        $rec->ChangeToPendingBy= $user;
        $rec->ChangeToPendingDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        //$rec->ChangeToPendingDate=Carbon::today()->toDateString();
        $rec->Status="Pending";
        $rec->save();
        actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"receiving",'action'=>"Change to Pending",'status'=>"Change to Pending",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
        return Response::json(['success' => '1']);
    }

    public function updateHide(Request $request){
        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;
            $findid = $request->recordIds;
            $rec = receiving::find($findid);
            $rec->IsHide = 1;
            $rec->save();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "receiving",
                'action' => "Hide-Record",
                'status' => "Hide-Record",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            DB::commit();
            return Response::json(['success' => 1, 'fiscalyr' => $rec->fiscalyear,'vstatus' => $rec->VoucherStatus]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function updateShow(Request $request){
        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;
            $findid = $request->recordIds;
            $rec = receiving::find($findid);
            $rec->IsHide = 0;
            $rec->save();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "receiving",
                'action' => "Show-Record",
                'status' => "Show-Record",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'created_at' => Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            
            DB::commit();
            return Response::json(['success' => 1, 'fiscalyr' => $rec->fiscalyear,'vstatus' => $rec->VoucherStatus]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function updateConfimed(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->confirmid;
        $rec = receiving::find($findid);
        $fiscalyr = $rec->fiscalyear;
        $settingsval = DB::table('settings')->latest()->first();
        $docnum = $rec->DocumentNumber;
        $product_type = $rec->ProductType;

        if($product_type == "Goods"){
            $syncToTransactions = DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,DocumentNumber,TransactionsType,FiscalYear,Date)SELECT HeaderId,ItemId,ConvertedQuantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,ItemType,"'.$docnum.'","Receiving","'.$fiscalyr.'","'.Carbon::now()->toDateString().'" FROM receivingdetails WHERE receivingdetails.HeaderId='.$findid);
        }
        else if($product_type == "Commodity"){
            $insertToTransaction = DB::select('INSERT INTO transactions(HeaderId,woredaId,uomId,CommodityType,Grade,ProcessType,CropYear,StockInComm,StockInFeresula,ItemType,FiscalYear,Memo,StoreId,TransactionType,TransactionsType,Date,customers_id,LocationId,ArrivalDate,SupplierId,GrnNumber,CertNumber,ProductionNumber,StockInNumOfBag,DocumentNumber,VarianceShortage,VarianceOverage,BagWeight,TotalKg,UnitCostComm,TotalCostComm,TaxCostComm,GrandTotalCostComm) SELECT '.$findid.',CommodityId,DefaultUOMId,woredas.Type,Grade,ProcessType,CropYear,NetKg,ROUND((NetKg/17),2),ItemType,'.$fiscalyr.',Memo,'.$rec->StoreId.',"Receiving","Receiving","'.Carbon::now().'",'.$rec->CustomerOrOwner.',LocationId,"'.$rec->ReceivedDate.'",'.$rec->CustomerId.',"'.$rec->DocumentNumber.'","N/A","N/A",NumOfBag,"'.$rec->DocumentNumber.'",VarianceShortage,VarianceOverage,BagWeight,TotalKg,UnitCost,BeforeTaxCost,TaxAmount,TotalCost FROM receivingdetails LEFT JOIN woredas ON receivingdetails.CommodityId=woredas.id WHERE receivingdetails.HeaderId='.$findid);
        }

        $trtype = "Void";
        $undotransaction = "Undo-Void";
        $rec->ConfirmedBy = $user;
        $rec->ConfirmedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
        $rec->Status = "Confirmed";
        $rec->save();

        actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"receiving",'action'=>"Confirmed",'status'=>"Confirmed",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);

        return Response::json(['success' => '1']);
    }

    public function receivingForwardAction(Request $request){
        $val_status = ["Draft","Pending","Checked","Confirmed"];

        DB::beginTransaction();
        try{
            $user = Auth()->user()->username;
            $userid = Auth()->user()->id;

            $findid = $request->forwardReqId;
            $rec = receiving::find($findid);
            $currentStatus = $rec->Status;
            $newStatus = $request->newForwardStatusValue;
            $action = $request->forwardActionValue;
            $rec->Status = $newStatus;
            $docnum = $rec->DocumentNumber;
            $product_type = $rec->ProductType;
            $fiscalyr = $rec->fiscalyear;
            
            if($newStatus == "Checked"){
                $rec->CheckedBy = $user;
                $rec->CheckedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            }

            if($newStatus == "Confirmed"){
                $rec->ConfirmedBy = $user;
                $rec->ConfirmedDate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                if($product_type == "Goods"){
                    $syncToTransactions = DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,ItemType,DocumentNumber,TransactionsType,FiscalYear,Date)SELECT HeaderId,ItemId,Quantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,ItemType,"'.$docnum.'","Receiving","'.$fiscalyr.'","'.Carbon::now()->toDateString().'" FROM receivingdetails WHERE receivingdetails.HeaderId='.$findid);
                }
                else if($product_type == "Commodity"){
                    $insertToTransaction = DB::select('INSERT INTO transactions(HeaderId,woredaId,uomId,CommodityType,Grade,ProcessType,CropYear,StockInComm,StockInFeresula,ItemType,FiscalYear,Memo,StoreId,TransactionType,TransactionsType,Date,customers_id,LocationId,ArrivalDate,SupplierId,GrnNumber,CertNumber,ProductionNumber,StockInNumOfBag,DocumentNumber,VarianceShortage,VarianceOverage,BagWeight,TotalKg,UnitCostComm,TotalCostComm,TaxCostComm,GrandTotalCostComm) SELECT '.$findid.',CommodityId,DefaultUOMId,woredas.Type,Grade,ProcessType,CropYear,NetKg,ROUND((NetKg/17),2),ItemType,'.$fiscalyr.',Memo,'.$rec->StoreId.',"Receiving","Receiving","'.Carbon::now().'",'.$rec->CustomerOrOwner.',LocationId,"'.$rec->ReceivedDate.'",'.$rec->CustomerId.',"'.$rec->DocumentNumber.'","N/A","N/A",NumOfBag,"'.$rec->DocumentNumber.'",VarianceShortage,VarianceOverage,BagWeight,TotalKg,UnitCost,BeforeTaxCost,TaxAmount,TotalCost FROM receivingdetails LEFT JOIN woredas ON receivingdetails.CommodityId=woredas.id WHERE receivingdetails.HeaderId='.$findid);
                }
            }
            $rec->save();

            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $findid,
                'pagename' => "receiving",
                'action' => "$action",
                'status'=>"$action",
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            DB::commit();
            return Response::json(['success' => 1, 'fiscalyr' => $rec->fiscalyear,'vstatus' => $rec->VoucherStatus]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }

    public function receivingBackwardAction(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->backwardReqId;
        $action = $request->backwardActionValue;
        $newStatus = $request->newBackwardStatusValue;
        $rec = receiving::find($findid);
        $validator = Validator::make($request->all(), [
            'CommentOrReason'=>"required",
        ]);

        if($validator->passes()) 
        {
            DB::beginTransaction();
            try{
                $rec->Status = $newStatus;
                $rec->save();

                DB::table('actions')->insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"receiving",'action'=>"$action",'status'=>"$action",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"$request->CommentOrReason",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                
                DB::commit();
                return Response::json(['success' => 1, 'fiscalyr' => $rec->fiscalyear,'vstatus' => $rec->VoucherStatus]);
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

    public function receivingVoid(Request $request){
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $itemidvals="";
        $runqnt="0";
        $totalqnt="0";
        $eachqntval="0";
        $avaq="0";
        $tempcntitemid=[];
        $totalitemid=[];
        $eachqnt=[];
        $findid=$request->voidid;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $rec=receiving::find($findid);
        $customerid=$rec->CustomerId;
        $transactiondate=$rec->TransactionDate;
        $storeId=$rec->StoreId;
        $fiscalyearval=$rec->fiscalyear;
        // $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM receivingdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN transactions AS trn ON (trs.ItemId = trn.ItemId) WHERE trs.HeaderId='.$findid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM transactions WHERE transactions.ItemId=trs.ItemId AND transactions.StoreId='.$storeId.' AND transactions.FiscalYear='.$fiscalyr.'),0)-trs.Quantity)<0');
        // foreach($getApprovedQuantity as $row)
        // {
        //     $avaq=$row->ApprovedItems;
        // }
        $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS rectemp'.$userid.''));
        $creatingtemptables =DB::statement('CREATE TEMPORARY TABLE rectemp'.$userid.' SELECT transactions.id,transactions.HeaderId,transactions.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,transactions.StoreId,uoms.Name AS UOM,transactions.StockIn,transactions.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY transactions.ItemId,transactions.StoreId ORDER BY transactions.id ASC)) AS AvailableQuantity,transactions.TransactionsType,transactions.FiscalYear FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE transactions.ItemId IN(SELECT receivingdetails.ItemId FROM receivingdetails WHERE receivingdetails.HeaderId='.$findid.') AND transactions.FiscalYear='.$fiscalyearval.'');
        $modifytemptable=DB::statement('ALTER TABLE rectemp'.$userid.' MODIFY id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
        $recdetails=receivingdetail::where('HeaderId',$findid)->get(['ItemId','Quantity']);
        foreach ($recdetails as $recdetails) {
            $itemidvals = $recdetails->ItemId;
            $itemqnt = $recdetails->Quantity;
            $updatestockingquantity=DB::select('INSERT INTO rectemp'.$userid.' (HeaderId,ItemId,StockOut,StoreId,TransactionsType,FiscalYear) VALUES ('.$findid.','.$itemidvals.','.$itemqnt.','.$storeId.',"Receiving",'.$fiscalyearval.')');
            $gettemptable=DB::select('SELECT rectemp'.$userid.'.id,rectemp'.$userid.'.HeaderId,rectemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,rectemp'.$userid.'.StoreId,uoms.Name AS UOM,rectemp'.$userid.'.StockIn,rectemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY rectemp'.$userid.'.ItemId,rectemp'.$userid.'.StoreId ORDER BY rectemp'.$userid.'.id ASC)) AS AvailableQuantity,rectemp'.$userid.'.TransactionsType FROM rectemp'.$userid.' INNER JOIN regitems ON rectemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON rectemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE rectemp'.$userid.'.ItemId='.$itemidvals.' AND rectemp'.$userid.'.FiscalYear='.$fiscalyearval.' AND rectemp'.$userid.'.StoreId='.$storeId.'');
            foreach($gettemptable as $row){
                $eachqntval=$row->AvailableQuantity;
                $eachqnt[]=$row->AvailableQuantity;
                if($eachqntval<0){
                    $tempcntitemid[]=$row->ItemId;
                    $runqnt+=1;//increment on each loop if items quantity gets negative.
                }
            }
            if($eachqntval<0){
                $totalitemid[]=$itemidvals;
                $totalqnt+=1;//increment the last item quantity gets negative.
            }
        }
        $tempididval=implode(',',$tempcntitemid);
        $totalitemidval=implode(',',$totalitemid);
        $totaluniqueval = count(array_unique(array_merge($tempcntitemid,$totalitemid)));
        
        if($runqnt >= 1 || $totalqnt >= 1)
        {
            $allitems=$tempididval.",".$totalitemidval;
            $getItemLists=DB::select('SELECT DISTINCT regitems.Name,regitems.id AS ApprovedItems,regitems.id AS AvailableItems FROM regitems WHERE regitems.id IN('.$allitems.')');
            return Response::json(['valerror'=>"error",'countedval'=>$totaluniqueval,'countItems'=>$getItemLists]);
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'Reason'=>"required",
            ]);
            if ($validator->passes()) 
            {
                $receivngcon = DB::table('receivings')->where('id',$findid)->latest()->first();
                $docnum=$receivngcon->DocumentNumber;
                $fyear=$receivngcon->fiscalyear;
                $transactiontype="Receiving";

                $updatebeforetax=DB::select('update transactions set transactions.IsPriceVoid=1 where transactions.HeaderId='.$findid.' AND transactions.TransactionType IN("Receiving") AND transactions.TransactionsType IN("Receiving","Undo-Void")');

                $syncToTransactionVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,ConvertedQuantity,"0",BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Void",ItemType,"'.$docnum.'","'.$fyear.'","1","'.Carbon::now()->toDateString().'" FROM receivingdetails WHERE receivingdetails.HeaderId='.$findid);

                $updateStatus=DB::select('update receivings set StatusOld=Status where id='.$findid.'');
                $rec->Status="Void";
                $rec->IsVoid="1";
                $vnumber=$rec->VoucherNumber;//get voucher number
                $rec->VoucherNumber=$vnumber."(void".$findid.")";
                $rec->VoidedBy=$user;
                $rec->VoidReason=trim($request->input('Reason'));
                $rec->VoidedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                //$rec->VoidedDate=Carbon::today()->toDateString();
                // $rec->UndoVoidBy="";
                // $rec->UndoVoidDate="";
                $rec->save();

                $updateWithold=DB::select('update receivings set IsWitholdSettle="Not-Settled",WitholdReceipt=null,WitholdSettledBy=null,WitholdSettleDate=null,IsSeparatelySettled=0 where receivings.CustomerId='.$customerid.' AND receivings.TransactionDate="'.$transactiondate.'"');

                $transactiontype="Receiving";
                $undotransaction="Undo-Void";

                $updateMaxCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.MaxCost = (SELECT ROUND(COALESCE(MAX(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
                $updateAverageCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.averageCost = (SELECT ROUND(COALESCE(SUM(BeforeTaxCost),0)/(COALESCE(SUM(StockIn),0))*1.15,2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
                $updateMinCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.minCost = (SELECT ROUND(COALESCE(MIN(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
                
                return Response::json(['success' => '1','customer'=>$customerid,'transactiondate'=>$transactiondate,'fiscalyr' => $rec->fiscalyear,'vstatus' => $rec->VoucherStatus]);
            }
            else
            {
                return Response::json(['errors' => $validator->errors()]);
            }
        }
    }

    public function receivingRecVoid(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->voidid;
        $rec = receiving::find($findid);
        $customerid = $rec->CustomerId;
        $transactiondate = $rec->TransactionDate;
        $docnum = $rec->DocumentNumber;
        $fyear = $rec->fiscalyear;
        $store_id = $rec->StoreId;
        $rec_status = $rec->Status;
        $poid = $rec->PoId;
        $poid = !empty($poid) ? $poid : 0;
        $validator = Validator::make($request->all(), [
            'Reason'=>"required",
        ]);

        if ($validator->passes()) {
            DB::beginTransaction();
            try{
                $validation = $this->validateInventoryItemBalances($request->row,$store_id,$fyear,$findid);
                if (($validation['status'] ?? "") == 456) {
                    return Response::json([
                        'balance_error' => 404,
                        'items' => $validation['negative_items']
                    ]);
                }

                DB::select('UPDATE receivings SET receivings.StatusOld = receivings.Status WHERE receivings.id='.$findid);
                $rec->Status = "Void";
                $rec->IsVoid = 1;
                $vnumber = $rec->VoucherNumber;
                $rec->VoucherNumber = $vnumber."(void".$findid.")";
                $rec->VoidedBy = $user;
                $rec->VoidReason = $request->Reason;
                $rec->VoidedDate = Carbon::today()->toDateString();
                $rec->save();

                if($rec_status == "Confirmed"){
                    DB::select('INSERT INTO transactions(HeaderId,ItemId,StockOut,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,ConvertedQuantity,"0",BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Void",ItemType,"'.$docnum.'","'.$fyear.'","1","'.Carbon::now()->toDateString().'" FROM receivingdetails WHERE receivingdetails.HeaderId='.$findid);
                }

                if($rec->Type == 501){
                    $receiving_detail = DB::select('SELECT * FROM receivingdetails WHERE receivingdetails.HeaderId='.$findid.' ORDER BY receivingdetails.id');
                    foreach($receiving_detail as $rec_det){
                        DB::table('purchaseordersdetails')
                            ->where('purchaseordersdetails.purchaseorder_id',$poid)
                            ->where('purchaseordersdetails.itemid',$rec_det->ItemId)
                            ->update([
                                'purchaseordersdetails.receivedqty' => DB::raw('(SELECT COALESCE(SUM(receivingdetails.Quantity),0) AS Quantity FROM receivingdetails LEFT JOIN receivings ON receivingdetails.HeaderId=receivings.id WHERE receivings.Status IN("Draft","Pending","Verified","Confirmed") AND receivingdetails.HeaderId!='.$findid.' AND receivingdetails.ItemId='.$rec_det->ItemId.' AND receivings.PoId='.$poid.')')
                            ]);
                    }

                    $poprop = PurchaseOrder::find($poid);

                    if($poprop->isfullyreceived == 0){
                        PurchaseOrder::where('purchaseorders.id',$poid)->update(['purchaseorders.isfullyreceived'=>2]);
                    }
                    else if($poprop->isfullyreceived == 1){
                        PurchaseOrder::where('purchaseorders.id',$poid)->update(['purchaseorders.isfullyreceived'=>3]);
                    }
                }

                DB::select('UPDATE receivings SET IsWitholdSettle="Not-Settled",WitholdReceipt=null,WitholdSettledBy=null,WitholdSettleDate=null,IsSeparatelySettled=0,withhold_receipt_date="" WHERE receivings.CustomerId='.$customerid.' AND receivings.TransactionDate="'.$transactiondate.'"');

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "receiving",
                    'action' => "Void",
                    'status' => "Void",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "$request->Reason",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                
                DB::commit();
                return Response::json(['success' => 1, 'receivingId' => $findid, 'fiscalyr' => $rec->fiscalyear,'vstatus' => $rec->VoucherStatus]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else{
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function undoReceivingVoid(Request $request){
        $findid=$request->recordIds;
        $rec=receiving::find($findid);
        $vnumber=$rec->VoucherNumber;//get voucher number
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $vtype=$rec->VoucherType;
        $custid=$rec->CustomerId;
        $custmrc=$rec->CustomerMRC;
        $newvouchernumber=str_replace("(void".$findid.")","",$vnumber);

        $getCountedVouchernum=DB::select('select count(id) as VoucherCount from receivings where receivings.VoucherType="'.$vtype.'" and receivings.VoucherNumber="'.$newvouchernumber.'" and receivings.CustomerId='.$custid.' and receivings.CustomerMRC="'.$custmrc.'"');
        foreach($getCountedVouchernum as $row)
        {
            $vcount=$row->VoucherCount;
        }
        $vcounts = (float)$vcount;
        if($vcounts>=1){
            return Response::json(['undoerror' =>  "error"]);
        }
        else{
            DB::beginTransaction();
            try{
                $receivingtype="Receiving";
                $voidtype="Void";
                $trtype="Undo-Void";
                DB::table('receivingdetails')
                ->where('HeaderId', $findid)
                ->update(['TransactionsType'=>$receivingtype]);

                $receivngcon = DB::table('receivings')->where('id', $findid)->latest()->first();
                $docnum=$receivngcon->DocumentNumber;
                $transactiontype="Receiving";
                $fyear=$receivngcon->fiscalyear;

                $syncToTransactionUndoVoid=DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,ConvertedQuantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Undo-Void",ItemType,"'.$docnum.'","'.$fyear.'","0","'.Carbon::now()->toDateString().'" FROM receivingdetails WHERE receivingdetails.HeaderId='.$findid);
                $updateStatus=DB::select('update receivings set Status=StatusOld,VoucherNumber=REPLACE(VoucherNumber,concat("(void",'.$findid.',")"),"") where id='.$findid.'');
                $rec->StatusOld="-";
                $rec->IsVoid="0";
                $vnumber=$rec->VoucherNumber;//get voucher number 
                $rec->VoucherNumber=$vnumber;
                // $rec->VoidedBy="-";
                // $rec->VoidReason="-";
                // $rec->VoidedDate="-";
                $rec->UndoVoidBy=$user;
                $rec->UndoVoidDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
                //$rec->UndoVoidDate=Carbon::today()->toDateString();
                $rec->save();
                $trtype="Void";
                $undotransaction="Undo-Void";

                $updateMaxCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.MaxCost = (SELECT ROUND(COALESCE(MAX(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
                $updateAverageCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.averageCost = (SELECT ROUND(COALESCE(SUM(BeforeTaxCost),0)/(COALESCE(SUM(StockIn),0))*1.15,2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
                $updateMinCost=DB::select('UPDATE regitems as b1 INNER JOIN transactions as b2 ON b1.id = b2.ItemId SET b1.minCost = (SELECT ROUND(COALESCE(MIN(UnitCost*1.15),0),2) FROM transactions WHERE transactions.ItemId=b2.ItemId AND transactions.TransactionsType IN("Begining","Receiving","Adjustment","Undo-Void") AND transactions.IsPriceVoid=0)');
                
                actions::insert(['user_id'=>$userid,'pageid'=>$findid,'pagename'=>"receiving",'action'=>"Undo Void",'status'=>"Undo Void",'time'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),'reason'=>"",'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                DB::commit();
                return Response::json(['success' => 1, 'fiscalyr' => $rec->fiscalyear, 'vstatus' => $rec->VoucherStatus]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }   
    }

    public function undoRecVoid(Request $request){
        $findid = $request->recordIds;
        $rec = receiving::find($findid);
        $vnumber = $rec->VoucherNumber;
        $receiving_old_status = $rec->StatusOld;
        $docnum = $rec->DocumentNumber;
        $transactiontype = "Receiving";
        $fyear = $rec->fiscalyear;
        $vtype = $rec->VoucherType;
        $custid = $rec->CustomerId;
        $custmrc = $rec->CustomerMRC;
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $pocnt = 0;
        $newvouchernumber = str_replace("(void".$findid.")","",$vnumber);

        $poid = $rec->PoId;
        $poid = !empty($poid) ? $poid : 0;
        $poprop = PurchaseOrder::find($poid);

        $getpocount = DB::select('SELECT COUNT(id) AS PoCount FROM receivings WHERE receivings.PoId='.$poid.' AND receivings.Status IN("Draft","Pending","Verified","Received","Confirmed") AND receivings.id>'.$findid);
        $pocnt = $getpocount[0]->PoCount;

        $getCountedVouchernum = DB::select('SELECT count(id) AS VoucherCount FROM receivings WHERE receivings.VoucherType="'.$vtype.'" AND receivings.VoucherNumber="'.$newvouchernumber.'" AND receivings.CustomerId='.$custid.' AND receivings.CustomerMRC="'.$custmrc.'"');
        $vcount = $getCountedVouchernum[0]->VoucherCount;
        $vcounts = (float)$vcount;

        if($vcounts >= 1){
            return Response::json(['undoerror' =>  "error"]);
        }
        else if($pocnt > 0){
            return Response::json(['pocnterror' => 465]);
        }
        else{
            DB::beginTransaction();
            try{
                DB::select('UPDATE receivings SET receivings.Status=receivings.StatusOld,VoucherNumber=REPLACE(VoucherNumber,concat("(void",'.$findid.',")"),"") WHERE id='.$findid);
                $rec->IsVoid = 0;
                $rec->UndoVoidBy = $user;
                $rec->UndoVoidDate = Carbon::today()->toDateString();
                $rec->save();

                if($rec->Type == 501){
                    $receiving_detail = DB::select('SELECT receivingdetails.id,receivingdetails.ItemId FROM receivingdetails WHERE receivingdetails.HeaderId='.$findid.' ORDER BY receivingdetails.id');
                    foreach($receiving_detail as $rec_det){
                        DB::table('purchaseordersdetails')
                            ->where('purchaseordersdetails.purchaseorder_id',$poid)
                            ->where('purchaseordersdetails.itemid',$rec_det->ItemId)
                            ->update(['purchaseordersdetails.receivedqty' => 
                                    DB::raw('(SELECT COALESCE(SUM(receivingdetails.Quantity),0) AS Quantity FROM receivingdetails LEFT JOIN receivings ON receivingdetails.HeaderId=receivings.id WHERE receivings.Status IN("Draft","Pending","Verified","Confirmed") AND receivingdetails.ItemId='.$rec_det->ItemId.' AND receivings.PoId='.$poid.')')
                                ]);
                    }

                    if($poprop->isfullyreceived == 2){
                        PurchaseOrder::where('purchaseorders.id',$poid)->update(['purchaseorders.isfullyreceived'=>0]);
                    }
                    else if($poprop->isfullyreceived == 3){
                        PurchaseOrder::where('purchaseorders.id',$poid)->update(['purchaseorders.isfullyreceived'=>1]);
                    }
                }

                if($receiving_old_status == "Confirmed"){
                    DB::select('INSERT INTO transactions(HeaderId,ItemId,StockIn,UnitCost,BeforeTaxCost,TaxAmountCost,TotalCost,StoreId,TransactionType,TransactionsType,ItemType,DocumentNumber,FiscalYear,IsVoid,Date)SELECT HeaderId,ItemId,ConvertedQuantity,UnitCost,BeforeTaxCost,TaxAmount,TotalCost,StoreId,TransactionType,"Undo-Void",ItemType,"'.$docnum.'","'.$fyear.'","0","'.Carbon::now()->toDateString().'" FROM receivingdetails WHERE receivingdetails.HeaderId='.$findid);
                }
                
                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "receiving",
                    'action' => "Undo Void",
                    'status' => "Undo Void",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                
                DB::commit();
                return Response::json(['success' => 1,'vnumber' => $vnumber, 'fiscalyr' => $rec->fiscalyear, 'vstatus' => $rec->VoucherStatus]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
    }

    public function showModelsConRec($id){
        $model=DB::select('SELECT models.Name FROM models WHERE models.BrandId='.$id.' AND models.ActiveStatus="Active" AND models.IsDeleted=1');
        return response()->json(['model'=>$model]);  
    }

    public function showSerialNumbersRec($cmn,$nid)
    {
        $sernum=DB::select('SELECT serialandbatchnum_temps.id,item_id,store_id,brand_id AS BrandId,brands.Name AS BrandName,ModelName,ManufactureDate,ExpireDate,SerialNumber,BatchNumber,IsIssued,TransactionDate FROM serialandbatchnum_temps INNER JOIN brands ON serialandbatchnum_temps.brand_id=brands.id WHERE Common='.$cmn.' and item_id='.$nid.' ORDER BY id DESC');
        return datatables()->of($sernum)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            $btn =  ' <a class="btn btn-icon btn-gradient-info btn-sm editSN" onclick="editSN('.$data->id.')" data-id="'.$data->id.'" data-mod="'.$data->ModelName.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#sernumDeleteModal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showSerialNumbersRecStatic($hid,$nid)
    {
        $sernum=DB::select('SELECT serialandbatchnums.id,item_id,store_id,brand_id AS BrandId,brands.Name AS BrandName,ModelName,ManufactureDate,ExpireDate,SerialNumber,BatchNumber,IsIssued,TransactionDate FROM serialandbatchnums INNER JOIN brands ON serialandbatchnums.brand_id=brands.id WHERE header_id='.$hid.' and item_id='.$nid.' ORDER BY id DESC');
        return datatables()->of($sernum)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
            $btn =  ' <a class="btn btn-icon btn-gradient-info btn-sm editSNSt" onclick="editSNSt('.$data->id.')" data-id="'.$data->id.'" data-mod="'.$data->ModelName.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
            $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#sernumDeleteModalSt" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function addSerialnumberConRec(Request $request)
    {
        $itemid=$request->seritemid;
        $headerid=$request->serheaderid;
        $storeid=$request->serstoreid;
        $storeqnt=$request->storeQuantity;
        $tableids=$request->tableid;
        $qnt=$request->Quantity;
        $cmn=$request->commonserval;
        $ItemInfo=Regitem::find($itemid);
        $reqSerialNum=$ItemInfo->RequireSerialNumber;
        $reqExpireDate=$ItemInfo->RequireExpireDate;
        $countitem = DB::table('serialandbatchnum_temps')->where('Common', '=', $cmn)->where('item_id', '=', $itemid)->get();
        $getCountItems = $countitem->count();
        $citem = (float)$getCountItems;
        $qitem = (float)$storeqnt;
        $scount = (float)$storeqnt;
        $qcount = (float)$qnt;
        $remvalue=$scount-$citem;
        $validator = Validator::make($request->all(), [
            'brand' => 'required',
            'modelNumber' => 'required',
            'ManufactureDate' => 'nullable|before:today',
            'SerialNumber' => ['nullable',Rule::unique('serialandbatchnum_temps')->where(function ($query) use($cmn) {
                return $query->where('Common', $cmn)
                ->where('TransactionType', 2);
            })],
        ]);

        $validator->sometimes('SerialNumber', 'required|nullable|unique:serialandbatchnums', function($request) {
            return ($request->serialnumreq=='Require');
        });

        $validator->sometimes('BatchNumber', 'required', function($request) {
            return ($request->expirenumreq=='Require-Both'||$request->expirenumreq=='Require-BatchNumber');
        });

        $validator->sometimes('Quantity', 'required|gt:0', function($request) {
            return ($request->expirenumreq=="Require-Both"||$request->serialnumreq=='Require-BatchNumber');
        });

        $validator->sometimes('ExpireDate', 'required|after:today', function($request) {
            return ($request->expirenumreq=="Require-Both"||$request->expirenumreq=="Require-ExpireDate");
        });

        if($citem>=$qitem && $tableids==null)
        {
            return Response::json(['valerror' =>  "error"]);
        }
        if($validator->passes())
        {
            try
            {
                if($tableids==null){
                    if($remvalue>=$qcount){
                        for ($i = 1; $i <= $qcount; $i++ ) {
                            $ser=new serialandbatchnum_temp;
                            $ser->item_id=$request->seritemid;
                            $ser->store_id=$request->serstoreid;
                            $ser->brand_id=$request->brand;
                            $ser->ModelName=$request->modelNumber;
                            $ser->ManufactureDate=$request->ManufactureDate;
                            $ser->ExpireDate=$request->ExpireDate;
                            $ser->SerialNumber=$request->SerialNumber;
                            $ser->BatchNumber=$request->BatchNumber;
                            $ser->IsIssued=0;
                            $ser->IsSold=0;
                            $ser->TransactionType=2;
                            $ser->TransactionDate=Carbon::today()->toDateString();
                            $ser->Common=$request->commonserval;
                            $ser->save();
                        }
                    }
                    else if($remvalue<$qcount){
                        return Response::json(['qnterror' =>  "error"]);
                    }  
                }
                else if($tableids!=null){
                    $sernum=serialandbatchnum_temp::updateOrCreate(['id' =>$request->tableid], [
                        'item_id' => $request->seritemid,
                        'store_id' => $request->serstoreid,
                        'brand_id' => $request->brand,
                        'ModelName' => $request->modelNumber,
                        'ManufactureDate' => $request->ManufactureDate,
                        'ExpireDate' => $request->ExpireDate,
                        'SerialNumber' => $request->SerialNumber,
                        'BatchNumber'=> $request->BatchNumber,
                        'IsIssued'=> 0,
                        'IsSold'=> 0,
                        'TransactionType'=>2,
                        'TransactionDate'=>Carbon::today()->toDateString(),
                        'Common' => $request->commonserval,
                    ]);
                }
                $countitem = DB::table('serialandbatchnum_temps')->where('Common', '=', $cmn)->where('item_id', '=', $itemid)->get();
                $getCountItem = $countitem->count();
               
                return Response::json(['success' => '1','Totalcount'=>$getCountItem]);   
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

    public function addSerialnumberConRecStatic(Request $request){
        $itemid=$request->seritemid;
        $headerid=$request->serheaderid;
        $storeid=$request->serstoreid;
        $storeqnt=$request->storeQuantity;
        $tableids=$request->tableid;
        $qnt=$request->Quantity;
        $cmn=$request->commonserval;
        $ItemInfo=Regitem::find($itemid);
        $reqSerialNum=$ItemInfo->RequireSerialNumber;
        $reqExpireDate=$ItemInfo->RequireExpireDate;
        $countitem = DB::table('serialandbatchnums')->where('header_id', '=', $headerid)->where('item_id', '=', $itemid)->where('TransactionType',2)->get();
        $getCountItems = $countitem->count();
        $citem = (float)$getCountItems;
        $qitem = (float)$storeqnt;
        $scount = (float)$storeqnt;
        $qcount = (float)$qnt;
        $remvalue=$scount-$citem;
        $validator = Validator::make($request->all(), [
            'brand' => 'required',
            'modelNumber' => 'required',
            'ManufactureDate' => 'nullable|before:today',
        ]);
        $validator->sometimes('SerialNumber', 'required|nullable|unique:serialandbatchnums,SerialNumber,'.$tableids, function($request) {
            return ($request->serialnumreq=='Require');
        });

        $validator->sometimes('BatchNumber', 'required', function($request) {
            return ($request->expirenumreq=='Require-Both'||$request->expirenumreq=='Require-BatchNumber');
        });

        $validator->sometimes('Quantity', 'required|gt:0', function($request) {
            return ($request->expirenumreq=="Require-Both"||$request->serialnumreq=='Require-BatchNumber');
        });

        $validator->sometimes('ExpireDate', 'required|after:today', function($request) {
            return ($request->expirenumreq=="Require-Both"||$request->expirenumreq=="Require-ExpireDate");
        });

        if($citem>=$qitem && $tableids==null)
        {
            return Response::json(['valerror' =>  "error"]);
        }
        if($validator->passes())
        {
            try
            {
                if($tableids==null){
                    if($remvalue>=$qcount){
                        for ($i = 1; $i <= $qcount; $i++ ) {
                            $ser=new serialandbatchnum;
                            $ser->header_id=$request->serheaderid;
                            $ser->item_id=$request->seritemid;
                            $ser->store_id=$request->serstoreid;
                            $ser->brand_id=$request->brand;
                            $ser->ModelName=$request->modelNumber;
                            $ser->ManufactureDate=$request->ManufactureDate;
                            $ser->ExpireDate=$request->ExpireDate;
                            $ser->SerialNumber=$request->SerialNumber;
                            $ser->BatchNumber=$request->BatchNumber;
                            $ser->IsIssued=0;
                            $ser->IsSold=0;
                            $ser->TransactionType=2;
                            $ser->IsConfirmed=0;
                            $ser->TransactionDate=Carbon::today()->toDateString();
                            $ser->save();
                        }
                    }
                    else if($remvalue<$qcount){
                        return Response::json(['qnterror' =>  "error"]);
                    }  
                }
                else if($tableids!=null){
                    $sernum=serialandbatchnum::updateOrCreate(['id' =>$request->tableid], [
                        'header_id' => $request->serheaderid,
                        'item_id' => $request->seritemid,
                        'store_id' => $request->serstoreid,
                        'brand_id' => $request->brand,
                        'ModelName' => $request->modelNumber,
                        'ManufactureDate' => $request->ManufactureDate,
                        'ExpireDate' => $request->ExpireDate,
                        'SerialNumber' => $request->SerialNumber,
                        'BatchNumber'=> $request->BatchNumber,
                        'IsIssued'=> 0,
                        'IsSold'=> 0,
                        'TransactionType'=>2,
                        'TransactionDate'=>Carbon::today()->toDateString(),
                    ]);
                }
                $countitem = DB::table('serialandbatchnums')->where('header_id', '=', $headerid)->where('item_id', '=', $itemid)->where('TransactionType',2)->get();
                $getCountItem = $countitem->count();
               
                return Response::json(['success' => '1','Totalcount'=>$getCountItem]);   
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

    public function editSerialNumberConRec($id)
    {
        $recdata = serialandbatchnum_temp::find($id);
        return response()->json(['recData'=>$recdata]);
    }

    public function editSerialNumberConRecStatic($id)
    {
        $recdata = serialandbatchnum::find($id);
        return response()->json(['recData'=>$recdata]);
    }

    public function deleteSerialNumRec($id)
    {
        $sernum = serialandbatchnum_temp::find($id);
        $cmn=$sernum->Common;
        $itemid=$sernum->item_id;
        $sernum->delete();
        $countitem = DB::table('serialandbatchnum_temps')->where('Common', '=', $cmn)->where('item_id', '=', $itemid)->get();
        $getCountItem = $countitem->count();
        return Response::json(['success' => '1','Totalcount'=>$getCountItem]);
    }

    public function deleteSerialNumRecStatic($id)
    {
        $sernum = serialandbatchnum::find($id);
        $hid=$sernum->header_id;
        $itemid=$sernum->item_id;
        $sernum->delete();
        $countitem = DB::table('serialandbatchnums')->where('header_id', '=', $hid)->where('item_id', '=', $itemid)->where('TransactionType',2)->get();
        $getCountItem = $countitem->count();
        return Response::json(['success' => '1','Totalcount'=>$getCountItem]);
    }

    public function uploadDocument(Request $request){
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $findid = $request->uploadReceivingDoc;
        $rec = receiving::find($findid);
        $document_upload_data = [];

        $rules = array(
            'docrow.*.document_type' => 'required',
            'docrow.*.doc_upload_hidden' => 'required',
            'docrow.*.doc_status' => 'required',
        );
        $v2 = Validator::make($request->all(), $rules);

        if($v2->passes() && $request->docrow != null){
            DB::beginTransaction();
            try{
                foreach ($request->docrow as $key => $value){
                    $doc = $value['doc_upload'] ?? "";
                    if($doc != null) {
                        $doc_file = $value['doc_upload'];
                        $actual_name = $doc_file->getClientOriginalName();
                        $documentations = $this->randNumber().$findid.'_'.'doc.' . $value['doc_upload']->extension();
                        $docPathIdentification = public_path() . '/storage/uploads/Receiving/SupportingDocument';
                        $docpathnameIdentification = '/storage/uploads/Receiving/SupportingDocument/'.$documentations;
                        $doc_file->move($docPathIdentification, $documentations);
                    }
                    if($doc == null) {
                        $documentations = $value['documents'];
                        $actual_name = $value['doc_actual_name'];
                    }
                    $document_upload_data[] = [
                        "record_id" => $findid,
                        "record_type" => "receiving",
                        "document_type" => $value['document_type'],
                        "date" => $value['upload_date'],
                        "doc_name" => $documentations,
                        "actual_file_name" => $actual_name,
                        "remark" => $value['doc_remark'],
                        "status" => $value['doc_status'],
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now()
                    ];
                }

                DB::table('documents')->where('record_id',$findid)->where('record_type',"receiving")->delete();
                DB::table('documents')->insert($document_upload_data);

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $findid,
                    'pagename' => "receiving",
                    'action' => "Document-Uploaded",
                    'status' => "Document-Uploaded",
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1,'rec_id' => $findid,'vstatus' => $rec->VoucherStatus]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else if($v2->fails()){
            return response()->json(['errorv2' => $v2->errors()->all()]);
        }
        else if($request->docrow == null){
            return response()->json(['emptyerror' => "error"]);
        }
    }

    public function fetchReceivingDoc(){
        $receiving_id = $_POST['receiving_id'];
        $document_data = DB::select('SELECT lookuprefs.LookupName AS doc_type,documents.* FROM documents LEFT JOIN lookuprefs ON documents.document_type=lookuprefs.id WHERE documents.record_id='.$receiving_id.' AND documents.record_type="receiving" ORDER BY documents.id ASC');
    
        return response()->json(['document_data' => $document_data]);
    }

    public function showDocumentData($id){
        $document_data = DB::select('SELECT lookuprefs.LookupName AS doc_type,documents.* FROM documents LEFT JOIN lookuprefs ON documents.document_type=lookuprefs.id WHERE documents.record_id='.$id.' AND documents.record_type="receiving" ORDER BY documents.id ASC');
        return datatables()->of($document_data)
        ->addIndexColumn()
        ->make(true);
    }
    
    function countReceivingStatus(){
        $fyear = $_POST['fyear']; 
        $purchase_receiving_status = DB::select('SELECT receivings.Status,FORMAT(COUNT(*),0) AS status_count FROM receivings WHERE receivings.IsFromProcurement=0 AND receivings.source_type="Purchase" AND receivings.fiscalyear='.$fyear.' GROUP BY receivings.Status UNION SELECT "Total",FORMAT(COUNT(*),0) AS status_count FROM receivings WHERE receivings.IsFromProcurement=0 AND receivings.source_type="Purchase" AND receivings.fiscalyear='.$fyear);

        $production_receiving_status = DB::select('SELECT receivings.Status,FORMAT(COUNT(*),0) AS status_count FROM receivings WHERE receivings.IsFromProcurement=0 AND receivings.source_type="Production" AND receivings.fiscalyear='.$fyear.' GROUP BY receivings.Status UNION SELECT "Total",FORMAT(COUNT(*),0) AS status_count FROM receivings WHERE receivings.IsFromProcurement=0 AND receivings.source_type="Production" AND receivings.fiscalyear='.$fyear);

        $ready_for_receiving = DB::select('SELECT (SELECT COUNT(purchaseorders.id) AS rec_count FROM purchaseorders LEFT JOIN customers ON purchaseorders.customers_id=customers.id WHERE purchaseorders.purchaseordertype="Goods" AND purchaseorders.status=3 AND purchaseorders.isfullyreceived IN(0,2,3)) + (SELECT COUNT(purchaseinvoices.id) AS rec_count FROM purchaseinvoices LEFT JOIN customers ON purchaseinvoices.supplier=customers.id WHERE purchaseinvoices.status=3) AS ready_receiving');
     
        $ready_rec_cnt = $ready_for_receiving[0]->ready_receiving ?? 0;
        $ready_rec_cnt = number_format($ready_rec_cnt);

        return response()->json(['purchase_receiving_status' => $purchase_receiving_status,'production_receiving_status' => $production_receiving_status,'ready_rec_cnt' => $ready_rec_cnt]); 
    }

    public function randNumber(): int{
        return random_int(100000, 999999);
    }
}
