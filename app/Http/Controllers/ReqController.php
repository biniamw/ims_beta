<?php

namespace App\Http\Controllers;
use App\Models\requisition;
use App\Models\requisitiondetail;
use App\Models\customer;
use App\Models\store;
use App\Models\companyinfo;
use App\Models\systeminfo;
use App\Models\issue;
use App\Models\issuedetail;
use App\Models\dispatchparent;
use App\Models\dispatchchild;
use App\Models\lookup;
use Illuminate\Http\Request;
use Invoice;
use Carbon\Carbon;

use PdfReport;
use PDF;
use DB;


class ReqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(requisitiondetail::where('HeaderId',$id)->exists())
        {
            $isstype="Transfer";
            $issueids="";
            error_reporting(0); 
            //---Start Header Info---
            $st="";
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
            $companyLogo=$compInfo->Logo;
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
            $systemalladdress=$sysInfo->AllAddress;
            //---End Footer Info----- 

            $headerInfo=requisition::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $type=$headerInfo->Type;
            $reqdate=$headerInfo->Date;
            $requestedby=$headerInfo->RequestedBy;
            $purpose=$headerInfo->Purpose;
            $approvedby=$headerInfo->ApprovedBy;
            $approveddate=$headerInfo->ApprovedDate;
            $issuedby=$headerInfo->IssuedBy;
            $issueddate=$headerInfo->IssuedDate;
            $storeid=$headerInfo->SourceStoreId;
            $desstoreid=$headerInfo->DestinationStoreId;
            $issuedocnum=$headerInfo->IssueDocNumber;

            $receivedby=$headerInfo->ReceivedBy;
            $received_date=$headerInfo->ReceivedDate;

            $lookupreq=lookup::find($headerInfo->RequestReason);
            $reqreason=$lookupreq->RequestReason;

            $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

            $status=$headerInfo->Status;
            if($status=="Void(Issued)" || $status=="Void(Pending)" || $status=="Void(Approved)"){
                $st="Void";
            }
            else if($status=="Rejected"){
                $st="Rejected";
            }
            else if($status=="Issued"){
                $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type','!=',$isstype)->latest()->first();
                $issueids=$issuecon->id;
                $st="";
            }
            else{
                $st="";
            }
            $srcstore=store::find($storeid);
            $storename=$srcstore->Name;

            $desstore=store::find($desstoreid);
            $desstorename=$desstore->Name;

            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT requisitiondetails.id,requisitiondetails.ItemId,requisitiondetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,FORMAT(requisitiondetails.Quantity,2) AS Quantity,requisitiondetails.Memo,requisitiondetails.UnitCost,requisitiondetails.BeforeTaxCost,requisitiondetails.TaxAmount,requisitiondetails.TotalCost FROM requisitiondetails INNER JOIN regitems ON requisitiondetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where requisitiondetails.HeaderId='.$id);
            $count=0;

            $data=['detailTable' => $detailTable,
            'docnum' => $docnum,
            'approveddate' => $approveddate,
            'issueddate' => $issueddate,
            'formdate' => $reqdate,
            'reqdate' => $datetime,
            'type' => $type,
            'storename' => $storename,
            'desstorename' => $desstorename,
            'approvedby' => $approvedby,
            'issuedby' => $issuedby,
            'requestedby' => $requestedby,
            'issuedocnum' => $issuedocnum,
            'issueids' => $issueids,
            'reqreason' => $reqreason,
            'purpose' => $purpose,
            'receivedby' => $receivedby,
            'received_date' => $received_date,
            'count' => $count,
            'currentdate' => $currentdate,
            'companyname' => $companyname,
            'companytin' => $companytin,
            'companyvat' => $companyvat,
            'companyphone' => $companyphone,
            'companyoffphone' => $companyoffphone,
            'companyemail' => $companyemail,
            'companyaddress' => $companyaddress,
            'companywebsite' => $companywebsite,
            'companycountry' => $companycountry,
            'companyalladdress' => $companyalladdress,
            'companyLogo' => $companyLogo,
            'systemname' => $systemname,
            'systemtin' => $systemtin,
            'systemvat' => $systemvat,
            'systemphone' => $systemphone,
            'systemoffphone' => $systemoffphone,
            'systememail' => $systememail,
            'systemaddress' => $systemaddress,
            'systemwebsite' => $systemwebsite,
            'systemcountry' => $systemcountry,
            'systemalladdress' => $systemalladdress,
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

            $html=\View::make('inventory.report.req')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Store Requisition ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->SetWatermarkText($status);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Store-Requisition '.$docnum.'.pdf','I');

            // $pdf=PDF::loadView('inventory.report.req',$data);
            // return $pdf->stream();
        }
    }

    public function reqcomm($id)
    {
        if(requisitiondetail::where('HeaderId',$id)->exists())
        {
            $isstype="Transfer";
            $issueids="";
            error_reporting(0); 
            //---Start Header Info---
            $st="";
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
            $companyLogo=$compInfo->Logo;
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
            $systemalladdress=$sysInfo->AllAddress;
            //---End Footer Info----- 

            $headerInfo=requisition::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $type=$headerInfo->Type;
            $dateval=$headerInfo->Date;
            $preparedby=$headerInfo->PreparedBy;
            $requestedby=$headerInfo->RequestedBy;
            $purpose=$headerInfo->Purpose;
            $approvedby=$headerInfo->ApprovedBy;
            $approveddate=$headerInfo->ApprovedDate;
            $issuedby=$headerInfo->IssuedBy;
            $issueddate=$headerInfo->IssuedDate;
            $storeid=$headerInfo->SourceStoreId;
            $desstoreid=$headerInfo->DestinationStoreId;
            $issuedocnum=$headerInfo->IssueDocNumber;
            $referenceno=$headerInfo->Reference;
            $bookingno=$headerInfo->BookingNumber;

            $verifiedby=$headerInfo->AuthorizedBy;
            $verifieddate=$headerInfo->AuthorizedDate;

            $reviewedby=$headerInfo->ReviewedBy;
            $revieweddate=$headerInfo->ReviewedDate;

            $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

            $prepareddate = $headerInfo->PreparedDate;
            
            $status=$headerInfo->Status;
            if($status=="Void(Issued)" || $status=="Void(Pending)" || $status=="Void(Approved)"){
                $st="Void";
            }
            else if($status=="Rejected"){
                $st="Rejected";
            }
            else if($status=="Issued"){
                $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type','!=',$isstype)->latest()->first();
                $issueids=$issuecon->id;
                $st="";
            }
            else{
                $st="";
            }
            $srcstore=store::find($storeid);
            $storename=$srcstore->Name;

            $labst=store::find($headerInfo->LabStation);
            $labstation=$labst->Name;

            $cusown=customer::find($headerInfo->CustomerOrOwner);
            $cusowname=$cusown->Name;

            $cusprop=customer::find($headerInfo->CustomerReceiver);
            $cusrecname=$cusprop->Name;

            $lookuprop=lookup::find($headerInfo->CompanyType);
            $comptypename=$lookuprop->CompanyType;

            $lookupreq=lookup::find($headerInfo->RequestReason);
            $reqreason=$lookupreq->RequestReason;

            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT cmlookups.CommodityType AS CommType,grlookups.Grade AS GradeName,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,uoms.Name AS UomName,requisitiondetails.*,prlookups.ProcessType,crlookups.CropYear, IFNULL(requisitiondetails.Memo,"") AS Memo,ROUND((requisitiondetails.NetKg/1000),2) AS WeightByTon,uoms.Name AS UomName,locations.Name AS LocationName,customers.Name AS SupplierName,requisitiondetails.ProductionOrderNo,VarianceShortage,VarianceOverage FROM requisitiondetails LEFT JOIN woredas ON requisitiondetails.CommodityId = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions on zones.Rgn_Id = regions.id LEFT JOIN uoms ON requisitiondetails.DefaultUOMId = uoms.id LEFT JOIN locations ON requisitiondetails.LocationId=locations.id LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN lookups AS grlookups ON requisitiondetails.Grade=grlookups.GradeValue LEFT JOIN lookups AS prlookups ON requisitiondetails.ProcessType=prlookups.ProcessTypeValue LEFT JOIN lookups AS crlookups ON requisitiondetails.CropYear=crlookups.CropYearValue LEFT JOIN lookups AS cmlookups ON woredas.Type=cmlookups.CommodityTypeValue WHERE requisitiondetails.HeaderId ='.$id.' ORDER BY requisitiondetails.id DESC');
            $count=0;

            $data=['detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'approveddate'=>$approveddate,
            'issueddate'=>$issueddate,
            'dateval'=>$dateval,
            'reqdate'=>$datetime,
            'type'=>$type,
            'storename'=>$storename,
            'labstation'=>$labstation,
            'cusowname'=>$cusowname,
            'cusrecname'=>$cusrecname,
            'comptypename'=>$comptypename,
            'reqreason'=>$reqreason,
            'approvedby'=>$approvedby,
            'issuedby'=>$issuedby,
            'preparedby'=>$preparedby,
            'prepareddate'=>$prepareddate,
            'requestedby'=>$requestedby,
            'referenceno'=>$referenceno,
            'bookingno'=>$bookingno,
            'issuedocnum'=>$issuedocnum,
            'issueids'=>$issueids,
            'verifiedby'=>$verifiedby,
            'verifieddate'=>$verifieddate,
            'reviewedby'=>$reviewedby,
            'revieweddate'=>$revieweddate,
            'purpose'=>$purpose,
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

            $html=\View::make('inventory.report.reqcomm')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Store Requisition ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->SetWatermarkText($status);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Store-Requisition '.$docnum.'.pdf','I');

            // $pdf=PDF::loadView('inventory.report.req',$data);
            // return $pdf->stream();
        }
    }


    public function dispcomm($id)
    {
        if(dispatchchild::where('dispatchparents_id',$id)->exists())
        {
            $isstype="Transfer";
            $issueids="";
            error_reporting(0); 
            //---Start Header Info---
            $st="";
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
            $companyLogo=$compInfo->Logo;
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
            $systemalladdress=$sysInfo->AllAddress;
            //---End Footer Info----- 

            $headerInfo=dispatchparent::find($id);
            $docnum=$headerInfo->DispatchDocNo;
            $reqdate=$headerInfo->Date;
            $requestedby=$headerInfo->RequestedBy;
            $preparedby=$headerInfo->PreparedBy;
            $prepareddate=$headerInfo->PreparedDate;
            $approvedby=$headerInfo->ApprovedBy;
            $approveddate=$headerInfo->ApprovedDate;
            $verifiedby=$headerInfo->VerifiedBy;
            $verifieddate=$headerInfo->VerifiedDate;
            $storeid=$headerInfo->DriverName;
            $drivername=$headerInfo->DriverName.$headerInfo->PersonName;
            $driverlicenseno=$headerInfo->DriverLicenseNo;
            $driverphoneno=$headerInfo->DriverPhoneNo.$headerInfo->PersonPhoneNo;
            $plateno=$headerInfo->PlateNumber;
            $containerno=$headerInfo->ContainerNumber;
            $sealno=$headerInfo->SealNumber;
            $remark=$headerInfo->Remark;

            $reqProp=requisition::find($headerInfo->ReqId);
            $reqdocnum=$reqProp->DocumentNumber;

           // dd($reqProp->RequestReason);
            $lookupProp = lookup::where('RequestReasonValue',$reqProp->RequestReason)->first();
            $reasonloading=$lookupProp->RequestReason;

            $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

            $status=$headerInfo->Status;
            if($status=="Void(Issued)" || $status=="Void(Pending)" || $status=="Void(Approved)"){
                $st="Void";
            }
            else if($status=="Rejected"){
                $st="Rejected";
            }
            else if($status=="Issued"){
                $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type','!=',$isstype)->latest()->first();
                $issueids=$issuecon->id;
                $st="";
            }
            else{
                $st="";
            }


            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT dispatchchildren.*,requisitiondetails.CommodityId,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,IFNULL(customers.Name,"") AS SupplierName,IFNULL(requisitiondetails.GrnNumber,"") AS GrnNumber,IFNULL(requisitiondetails.ProductionOrderNo,"") AS ProductionOrderNo,IFNULL(requisitiondetails.CertNumber,"") AS CertNumber,IFNULL(requisitiondetails.ExportCertNumber,"") AS ExportCertNumber,IFNULL(uoms.Name,"") AS UOM,CONCAT(IFNULL(customers.Name,""),", ",IFNULL(requisitiondetails.GrnNumber,""),", ",IFNULL(requisitiondetails.ProductionOrderNo,""),", ",IFNULL(requisitiondetails.CertNumber,""),", ",IFNULL(requisitiondetails.ExportCertNumber,""),", ",IFNULL(uoms.Name,"")) AS ConcatData,uoms.bagweight,uoms.uomamount,IFNULL(dispatchchildren.Remark,"") AS Remark FROM dispatchchildren LEFT JOIN requisitiondetails ON dispatchchildren.ReqDetailId=requisitiondetails.id LEFT JOIN woredas ON requisitiondetails.CommodityId=woredas.id LEFT JOIN zones ON woredas.zone_id=zones.id LEFT JOIN regions ON zones.Rgn_Id=regions.id LEFT JOIN customers ON requisitiondetails.SupplierId=customers.id LEFT JOIN uoms ON requisitiondetails.DefaultUOMId=uoms.id WHERE dispatchchildren.dispatchparents_id='.$id.' ORDER BY dispatchchildren.id DESC');
            $count=0;

            $data=['detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'reqdocnum'=>$reqdocnum,
            'dates'=>$reqdate,
            'reqdate'=>$datetime,
            'reasonloading'=>$reasonloading,

            'approvedby'=>$approvedby,
            'approveddate'=>$approveddate,
            'verifiedby'=>$verifiedby,
            'verifieddate'=>$verifieddate,
            'preparedby'=>$preparedby,
            'prepareddate'=>$prepareddate,

            'drivername'=>$drivername,
            'plateno'=>$plateno,
            'driverphoneno'=>$driverphoneno,
            'containerno'=>$containerno,
            'sealno'=>$sealno,

            'remark'=>$remark,
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

            $html=\View::make('inventory.report.dispcomm')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Dispatch Note ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->SetWatermarkText($status);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Dispatch-Note '.$docnum.'.pdf','I');

            // $pdf=PDF::loadView('inventory.report.req',$data);
            // return $pdf->stream();
        }
    }

    public function reqref($trid)
    {
        $id=issue::where('id',$trid)->first()->ReqId;
        if(requisitiondetail::where('HeaderId',$id)->exists())
        {
            error_reporting(0); 
            $isstype="Transfer";
            $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type','!=',$isstype)->latest()->first();
            $issueids=$issuecon->id;
            $st="";
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
            $companyLogo=$compInfo->Logo;
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
            $systemalladdress=$sysInfo->AllAddress;
            //---End Footer Info----- 

            $headerInfo=requisition::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $type=$headerInfo->Type;
            $reqdate=$headerInfo->Date;
            $requestedby=$headerInfo->RequestedBy;
            $purpose=$headerInfo->Purpose;
            $approvedby=$headerInfo->ApprovedBy;
            $approveddate=$headerInfo->ApprovedDate;
            $issuedby=$headerInfo->IssuedBy;
            $issueddate=$headerInfo->IssuedDate;
            $storeid=$headerInfo->SourceStoreId;
            $desstoreid=$headerInfo->DestinationStoreId;
            $issuedocnum=$headerInfo->IssueDocNumber;
            $status=$headerInfo->Status;

            $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

            if($status=="Void(Issued)" || $status=="Void(Pending)" || $status=="Void(Approved)"){
                $st="Void";
            }
            else if($status=="Rejected"){
                $st="Rejected";
            }
            else if($status=="Issued"){
                $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type','!=',$isstype)->latest()->first();
                $issueids=$issuecon->id;
                $st="";
            }
            else{
                $st="";
            }

            $status=$headerInfo->Status;
            $srcstore=store::find($storeid);
            $storename=$srcstore->Name;

            $desstore=store::find($desstoreid);
            $desstorename=$desstore->Name;

            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT requisitiondetails.id,requisitiondetails.ItemId,requisitiondetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,FORMAT(requisitiondetails.Quantity,0) AS Quantity,requisitiondetails.Memo,requisitiondetails.UnitCost,requisitiondetails.BeforeTaxCost,requisitiondetails.TaxAmount,requisitiondetails.TotalCost FROM requisitiondetails INNER JOIN regitems ON requisitiondetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where requisitiondetails.HeaderId='.$id);
            $count=0;

            $data=[ 'detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'approveddate'=>$approveddate,
            'issueddate'=>$issueddate,
            'reqdate'=>$datetime,
            'type'=>$type,
            'storename'=>$storename,
            'desstorename'=>$desstorename,
            'approvedby'=>$approvedby,
            'issuedby'=>$issuedby,
            'requestedby'=>$requestedby,
            'issueids'=>$issueids,
            'issuedocnum'=>$issuedocnum,
            'purpose'=>$purpose,
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

            $html=\View::make('inventory.report.req')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Store Requisition ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->SetWatermarkText($st);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Store-Requisition '.$docnum.'.pdf','I');
            //$pdf=PDF::loadView('inventory.report.req',$data);
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
