<?php

namespace App\Http\Controllers;
use App\Models\receiving;
use App\Models\receivingdetail;
use App\Models\customer;
use App\Models\store;
use App\Models\companyinfo;
use App\Models\systeminfo;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Invoice;
use Carbon\Carbon;

use PdfReport;
use PDF;
use DB;

class GRVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index($id)
    {
        if(receivingdetail::where('HeaderId',$id)->exists())
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
            $headerInfo=receiving::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $customerid=$headerInfo->CustomerId;
            $paymenttype=$headerInfo->PaymentType;
            $vouchertype=$headerInfo->VoucherType;
            $vouchernumber=$headerInfo->VoucherNumber;
            $invnumber=$headerInfo->InvoiceNumber;
            $mem=$headerInfo->Memo;
            $customermrc=$headerInfo->CustomerMRC;
            $voucherdate=$headerInfo->TransactionDate;
            $purchasedby=$headerInfo->PurchaserName;
            $preparedby=$headerInfo->Username;
            $checkedby=$headerInfo->CheckedBy;
            $checkeddate=$headerInfo->CheckedDate;
            $confirmedby=$headerInfo->ConfirmedBy;
            $confirmeddate=$headerInfo->ConfirmedDate;
            $storeid=$headerInfo->StoreId;
            $source_type=$headerInfo->source_type;
            $status=$headerInfo->Status;
            $transactiondate = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            
            if($status=="Void"){
                $st="Void";
            }
            else if($status!="Void"){
                $st="";
            }
            $customerDetails=customer::find($customerid);
            $customername=$customerDetails->Name;
            $customercategory=$customerDetails->CustomerCategory;
            $customertin=$customerDetails->TinNumber;
            $customervat=$customerDetails->VatNumber; 

            $storedetail=store::find($storeid);
            $storename=$storedetail->Name;

            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT receivingdetails.id,receivingdetails.ItemId,receivingdetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,FORMAT(receivingdetails.Quantity,0) AS Quantity,receivingdetails.UnitCost,receivingdetails.BeforeTaxCost,receivingdetails.TaxAmount,receivingdetails.TotalCost FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id inner join uoms on receivingdetails.NewUOMId=uoms.id where receivingdetails.HeaderId='.$id.' order by receivingdetails.id ASC');
            $count=0;
            $data=[ 'detailTable'=>$detailTable,
                    'docnum'=>$docnum,
                    'source_type'=>$source_type,
                    'customername'=>$customername,
                    'customercategory'=>$customercategory,
                    'customertin'=>$customertin,
                    'customervat'=>$customervat,
                    'customermrc'=>$customermrc,
                    'paymenttype'=>$paymenttype,
                    'vouchertype'=>$vouchertype,
                    'vouchernumber'=>$vouchernumber,
                    'invnumber'=>$invnumber,
                    'transactiondate'=>$transactiondate,
                    'mem'=>$mem,
                    'voucherdate'=>$voucherdate,
                    'storename'=>$storename,
                    'purchasedby'=>$purchasedby,
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
                $html=\View::make('inventory.report.grv')->with($data);
                $html=$html->render();  
                $mpdf->SetTitle('Good Receiving Voucher ('.$docnum.')');
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0; 
                $mpdf->SetAuthor($companyalladdress);
                $mpdf->SetWatermarkText($status);
                $mpdf->watermark_font = 'DejaVuSansCondensed';
                $mpdf->showWatermarkText = true;
                $mpdf->WriteHTML($html);
                $mpdf->Output('Good-Receiving-Note '.$docnum.'.pdf','I');

            //$pdf=PDF::loadView('inventory.report.grv',$data);
            //return $pdf->stream();
        }
    }

    public function grvprd($id)
    {
        if(receivingdetail::where('HeaderId',$id)->exists())
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
            $headerInfo=receiving::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $customerid=$headerInfo->CustomerId;
            $paymenttype=$headerInfo->PaymentType;
            $vouchertype=$headerInfo->VoucherType;
            $vouchernumber=$headerInfo->VoucherNumber;
            $invnumber=$headerInfo->InvoiceNumber;
            $mem=$headerInfo->Memo;
            $customermrc=$headerInfo->CustomerMRC;
            $voucherdate=$headerInfo->TransactionDate;
            $purchasedby=$headerInfo->PurchaserName;
            $deliveredby=$headerInfo->DeliveredBy;
            $preparedby=$headerInfo->Username;
            $checkedby=$headerInfo->CheckedBy;
            $checkeddate=$headerInfo->CheckedDate;
            $confirmedby=$headerInfo->ConfirmedBy;
            $confirmeddate=$headerInfo->ConfirmedDate;
            $storeid=$headerInfo->StoreId;
            $source_type=$headerInfo->source_type;
            $productiono=$headerInfo->productiono;
            $requisitiono=$headerInfo->requisitiono;
            $status=$headerInfo->Status;
            $transactiondate = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            
            if($status=="Void"){
                $st="Void";
            }
            else if($status!="Void"){
                $st="";
            }
            $customerDetails=customer::find($customerid);
            $customername=$customerDetails->Name;
            $customercategory=$customerDetails->CustomerCategory;
            $customertin=$customerDetails->TinNumber;
            $customervat=$customerDetails->VatNumber; 

            $storedetail=store::find($storeid);
            $storename=$storedetail->Name;

            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT receivingdetails.id,receivingdetails.ItemId,receivingdetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,FORMAT(receivingdetails.Quantity,0) AS Quantity,receivingdetails.UnitCost,receivingdetails.BeforeTaxCost,receivingdetails.TaxAmount,receivingdetails.TotalCost FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id inner join uoms on receivingdetails.NewUOMId=uoms.id where receivingdetails.HeaderId='.$id.' order by receivingdetails.id ASC');
            $count=0;
            $data=[ 'detailTable'=>$detailTable,
                    'docnum'=>$docnum,
                    'source_type'=>$source_type,
                    'productiono'=>$productiono,
                    'requisitiono'=>$requisitiono,
                    'customername'=>$customername,
                    'customercategory'=>$customercategory,
                    'customertin'=>$customertin,
                    'customervat'=>$customervat,
                    'customermrc'=>$customermrc,
                    'paymenttype'=>$paymenttype,
                    'vouchertype'=>$vouchertype,
                    'vouchernumber'=>$vouchernumber,
                    'invnumber'=>$invnumber,
                    'transactiondate'=>$transactiondate,
                    'mem'=>$mem,
                    'voucherdate'=>$voucherdate,
                    'storename'=>$storename,
                    'purchasedby'=>$purchasedby,
                    'deliveredby'=>$deliveredby,
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
                $html=\View::make('inventory.report.grv_prd')->with($data);
                $html=$html->render();  
                $mpdf->SetTitle('Good Receiving Voucher ('.$docnum.')');
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0; 
                $mpdf->SetAuthor($companyalladdress);
                $mpdf->SetWatermarkText($st);
                $mpdf->watermark_font = 'DejaVuSansCondensed';
                $mpdf->showWatermarkText = true;
                $mpdf->WriteHTML($html);
                $mpdf->Output('Good-Receiving-Note '.$docnum.'.pdf','I');

            //$pdf=PDF::loadView('inventory.report.grv',$data);
            //return $pdf->stream();
        }
    }

    public function grvComm($id)
    {
        if(receivingdetail::where('HeaderId',$id)->exists())
        {
            $st="";
            $rectype="";
            $comptype="";
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

            $headerInfo = receiving::find($id);
            $docnum = $headerInfo->DocumentNumber;
            $customerid = $headerInfo->CustomerId;
            $paymenttype = $headerInfo->PaymentType;
            $vouchertype = $headerInfo->VoucherType;
            $vouchernumber = $headerInfo->VoucherNumber;
            $invnumber = $headerInfo->InvoiceNumber;
            $mem = $headerInfo->Memo;
            $customermrc = $headerInfo->CustomerMRC;
            $voucherdate = $headerInfo->TransactionDate;
            $purchasedby = $headerInfo->PurchaserName;
            $preparedby = $headerInfo->Username;
            $checkedby = $headerInfo->CheckedBy;
            $checkeddate = $headerInfo->CheckedDate;
            $confirmedby = $headerInfo->ConfirmedBy;
            $confirmeddate = $headerInfo->ConfirmedDate;
            $receivedby = $headerInfo->ReceivedBy;
            $deliveredby = $headerInfo->DeliveredBy;
            $receiveddate = $headerInfo->ReceivedDate;

            $rectype = $headerInfo->Type == 1 ? "Direct" : "PO (Purchase Order)";

            $comptype = $headerInfo->CompanyType == 1 ? "Owner" : "Customer";

            $deliveryordno=$headerInfo->DeliveryOrderNo;
            $dispatchstation=$headerInfo->DispatchStation;
            $drivername=$headerInfo->DriverName;
            $truckplate=$headerInfo->TruckPlateNo;
            $storeid=$headerInfo->StoreId;
            $status=$headerInfo->Status;
            $transactiondate = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            
            $st = $status == "Void" ? "Void" : "";
            
            $customerDetails = customer::find($customerid);
            $customername = $customerDetails->Name;
            $customercategory = $customerDetails->CustomerCategory;
            $customertin = $customerDetails->TinNumber;
            $customervat = $customerDetails->VatNumber; 

            $cusprop = customer::find($headerInfo->CustomerOrOwner);
            $cusorowner = $cusprop->Name;

            $purord = PurchaseOrder::find($headerInfo->PoId);
            $purchaseordnum = $purord->porderno;

            $storedetail = store::find($storeid);
            $storename = $storedetail->Name;

            $currentdate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');

            if($headerInfo->ProductType == "Goods"){
                $detailTable = DB::select('SELECT receivingdetails.id,receivingdetails.ItemId,receivingdetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name AS UOM,FORMAT(receivingdetails.Quantity,0) AS Quantity,locations.Name AS floor_map FROM receivingdetails LEFT JOIN regitems ON receivingdetails.ItemId=regitems.id LEFT JOIN uoms ON receivingdetails.NewUOMId=uoms.id LEFT JOIN locations ON receivingdetails.LocationId=locations.id WHERE receivingdetails.HeaderId='.$id.' ORDER BY receivingdetails.id ASC');
            }
            else if($headerInfo->ProductType == "Commodity"){
                $detailTable = DB::select('SELECT receivingdetails.CommodityType AS CommTypeId,lookups.CommodityType AS CommType,crplookup.CropYear AS CropYearData,grdlookup.Grade AS GradeName,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,uoms.Name AS UomName,receivingdetails.*, IFNULL(receivingdetails.Memo,"") AS Remark,ROUND((receivingdetails.NetKg/1000),2) AS WeightByTon,uoms.Name as UomName,locations.Name AS LocationName,VarianceShortage,VarianceOverage,receivingdetails.NetKg,receivings.PoId FROM receivingdetails INNER JOIN receivings ON receivingdetails.HeaderId=receivings.id LEFT JOIN woredas ON receivingdetails.CommodityId = woredas.id left join zones on woredas.zone_id = zones.id left join regions on zones.Rgn_Id = regions.id inner join uoms on receivingdetails.NewUomId = uoms.id left join locations on receivingdetails.LocationId=locations.id left join lookups on receivingdetails.CommodityType=lookups.CommodityTypeValue left join lookups as crplookup on receivingdetails.CropYear=crplookup.CropYearValue left join lookups as grdlookup on receivingdetails.Grade=grdlookup.GradeValue where receivingdetails.HeaderId = '.$id.' order by receivingdetails.id DESC');
            }

            $count = 0;
            $data=['detailTable'=>$detailTable,
                    'docnum'=>$docnum,
                    'customername'=>$customername,
                    'customercategory'=>$customercategory,
                    'customertin'=>$customertin,
                    'customervat'=>$customervat,
                    'customermrc'=>$customermrc,
                    'paymenttype'=>$paymenttype,
                    'vouchertype'=>$vouchertype,
                    'vouchernumber'=>$vouchernumber,
                    'invnumber'=>$invnumber,
                    'transactiondate'=>$transactiondate,
                    'mem'=>$mem,
                    'voucherdate'=>$voucherdate,
                    'storename'=>$storename,
                    'purchasedby'=>$purchasedby,
                    'preparedby'=>$preparedby,
                    'checkedby'=>$checkedby,
                    'checkeddate'=>$checkeddate,
                    'confirmedby'=>$confirmedby,
                    'confirmeddate'=>$confirmeddate,
                    'receivedby'=>$receivedby,
                    'deliveredby'=>$deliveredby,
                    'receiveddate'=>$receiveddate,
                    'deliveryordno'=>$deliveryordno,
                    'dispatchstation'=>$dispatchstation,
                    'drivername'=>$drivername,
                    'truckplate'=>$truckplate,
                    'rectype'=>$rectype,
                    'comptype'=>$comptype,
                    'cusorowner'=>$cusorowner,
                    'purchaseordnum'=>$purchaseordnum,
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
                    'orientation' => 'L',
                    'margin_left' => 2,
                    'margin_right' => 2,
                    'margin_top' => 37,
                    'margin_bottom' => 25,
                    'margin_header' => 0,
                    'margin_footer' => 1
                ]); 

                $html = $headerInfo->ProductType == "Commodity" ? \View::make('inventory.report.grvcomm')->with($data) : \View::make('inventory.report.grvgoods')->with($data);
                $html=$html->render();  
                $mpdf->SetTitle('Good Receiving Voucher ('.$docnum.')');
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0; 
                $mpdf->SetAuthor($companyalladdress);
                $mpdf->SetWatermarkText($st);
                $mpdf->watermark_font = 'DejaVuSansCondensed';
                $mpdf->showWatermarkText = true;
                $mpdf->WriteHTML($html);
                $mpdf->Output('Good-Receiving-Note '.$docnum.'.pdf','I');

            //$pdf=PDF::loadView('inventory.report.grv',$data);
            //return $pdf->stream();
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
