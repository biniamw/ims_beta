<?php

namespace App\Http\Controllers;
use App\Models\adjustment;
use App\Models\adjustmentdetail;
use App\Models\customer;
use App\Models\store;
use App\Models\companyinfo;
use App\Models\systeminfo;
use App\Models\dispatchparent;
use App\Models\dispatchchild;
use App\Models\lookup;
use App\Models\action;
use App\Models\User;
use Illuminate\Http\Request;
use Invoice;
use Carbon\Carbon;

use PdfReport;
use PDF;
use DB;

class AdjController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(adjustmentdetail::where('HeaderId',$id)->exists())
        {
            $st="";
            $totaladj="";
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

            $headerInfo=adjustment::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $type=$headerInfo->Type;
            $reqdate=$headerInfo->AdjustedDate;
            $adjustedby=$headerInfo->AdjustedBy;
            $checkedby=$headerInfo->CheckedBy;
            $checkeddate=$headerInfo->CheckedDate;
            $confirmby=$headerInfo->ConfirmedBy;
            $confirmdate=$headerInfo->ConfirmedDate;
            $reason=$headerInfo->Reason;
            $memo=$headerInfo->Memo;
            $approvedby=$headerInfo->ApprovedBy;
            $storeid=$headerInfo->StoreId;
            $fiscalyr=$headerInfo->fiscalyear;
            $status=$headerInfo->Status;
            $adjtotalval=$headerInfo->TotalValue;
            $createddateval=$headerInfo->created_at;

            $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

            if($status=="Void"){
                $st="Void";
            }
            else if($status!="Void"){
                $st="";
            }

            $srcstore=store::find($storeid);
            $storename=$srcstore->Name;

            $getfiscalyear = DB::table('fiscalyear')->where('FiscalYear', '=', $fiscalyr)->first()->Monthrange;
           
            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT adjustmentdetails.id,adjustmentdetails.ItemId,adjustmentdetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,adjustmentdetails.Reason,FORMAT(adjustmentdetails.StockIn,0) AS StockIn,FORMAT(adjustmentdetails.StockOut,0) AS StockOut,adjustmentdetails.Memo,FORMAT(adjustmentdetails.UnitCost,2) AS UnitCost,adjustmentdetails.BeforeTaxCost,adjustmentdetails.TaxAmount,adjustmentdetails.TotalCost,FORMAT(adjustmentdetails.StockOutUnitCost,2) AS StockOutUnitCost,FORMAT(adjustmentdetails.StockOutBeforeTaxCost,2) AS StockOutBeforeTaxCost,FORMAT(adjustmentdetails.BeforeTaxCost,2) AS BeforeTaxCost FROM adjustmentdetails INNER JOIN regitems ON adjustmentdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where adjustmentdetails.HeaderId='.$id);
            $getformattedval=DB::select('SELECT FORMAT(adjustments.TotalValue,2) AS TotalValue FROM adjustments WHERE adjustments.id='.$id);
            foreach($getformattedval as $row){
                $totaladj=$row->TotalValue;
            }
            $count=0;
            $data=['detailTable'=>$detailTable,
            'totalvals'=>$totaladj,
            'docnum'=>$docnum,
            'reqdate'=>$datetime,
            'type'=>$type,
            'storename'=>$storename,
            'approvedby'=>$approvedby,
            'adjustedby'=>$adjustedby,
            'checkedby'=>$checkedby,
            'confirmby'=>$confirmby,
            'confirmdate'=>$confirmdate,
            'checkeddate'=>$checkeddate,
            'monthrange'=>$getfiscalyear,
            'reason'=>$reason,
            'memo'=>$memo,
            'count'=>$count,
            'adjtotalval'=>$adjtotalval,
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
            if($type=="Quantity")
            {
                $html=\View::make('inventory.report.adj')->with($data);
                $html=$html->render();  
                $mpdf->SetTitle('Adjustment Voucher ('.$docnum.')');
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0; 
                $mpdf->SetAuthor($companyalladdress);
                $mpdf->SetWatermarkText($st);
                $mpdf->watermark_font = 'DejaVuSansCondensed';
                $mpdf->showWatermarkText = true;
                $mpdf->WriteHTML($html);
                $mpdf->Output('Adjustment-Voucher '.$docnum.'.pdf','I');
                // $pdf=PDF::loadView('inventory.report.adj',$data);
                // return $pdf->stream();
            }
            else if($type=="Quantity&Cost")
            {
                $html=\View::make('inventory.report.adjqc')->with($data);
                $html=$html->render();  
                $mpdf->SetTitle('Adjustment Voucher ('.$docnum.')');
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0; 
                $mpdf->SetAuthor($companyalladdress);
                $mpdf->SetWatermarkText($st);
                $mpdf->watermark_font = 'DejaVuSansCondensed';
                $mpdf->showWatermarkText = true;
                $mpdf->WriteHTML($html);
                $mpdf->Output('Adjustment-Voucher '.$docnum.'.pdf','I');
                // $pdf=PDF::loadView('inventory.report.adjqc',$data);
                // return $pdf->stream();
            }
           
        }
    }

    public function adjcomm($id)
    {
        if(adjustmentdetail::where('HeaderId',$id)->exists())
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

            $headerInfo=adjustment::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $type=$headerInfo->Type;
            $dateval=$headerInfo->AdjustedDate;
            $requestedby=$headerInfo->RequestedBy;
            $memo=$headerInfo->Memo;
            $issuedby=$headerInfo->IssuedBy;
            $issueddate=$headerInfo->IssuedDate;
            $storeid=$headerInfo->SourceStoreId;
            $desstoreid=$headerInfo->DestinationStoreId;
            $issuedocnum=$headerInfo->IssueDocNumber;
            $referenceno=$headerInfo->Reference;
            $bookingno=$headerInfo->BookingNumber;

            $reviewedby=$headerInfo->ReviewedBy;
            $revieweddate=$headerInfo->ReviewedDate;

            $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            
            $status=$headerInfo->Status;
            if($status=="Void(Draft)" || $status=="Void(Pending)" || $status=="Void(Approved)"){
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
            $srcstore=store::find($headerInfo->StoreId);
            $storename=$srcstore->Name;

            $labst=store::find($headerInfo->LabStation);
            $labstation=$labst->Name;

            $cusown=customer::find($headerInfo->customers_id);
            $cusowname=$cusown->Name;

            $cusprop=customer::find($headerInfo->customers_id);
            $cusrecname=$cusprop->Name;

            $lookuprop=lookup::find($headerInfo->company_type);
            $comptypename=$lookuprop->CompanyType;

            $createdaction = DB::table('actions')
                            ->where('pagename',"adjustment")
                            ->where('action',"Created")
                            ->where('pageid',$id)
                            ->latest()
                            ->first();

            $cruser=User::find($createdaction->user_id);
            $preparedby=$cruser->username;
            $prepareddate=$createdaction->time;

            $verifiedaction = DB::table('actions')
                            ->where('pagename',"adjustment")
                            ->where('action',"Verified")
                            ->where('pageid',$id)
                            ->latest()
                            ->first();
            
            $vruser=User::find($verifiedaction->user_id);
            $verifiedby=$vruser->username;
            $verifieddate=$verifiedaction->time;

            $approvedaction = DB::table('actions')
                            ->where('pagename',"adjustment")
                            ->where('action',"Approved")
                            ->where('pageid',$id)
                            ->latest()
                            ->first();

            $apruser=User::find($approvedaction->user_id);
            $approvedby=$apruser->username;
            $approveddate=$approvedaction->time;


            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT adjustments.Type AS AdjustmentType,cmlookups.CommodityType AS CommType,grlookups.Grade AS GradeName,CONCAT(regions.Rgn_Name," , ",zones.Zone_Name," , ",woredas.Woreda_Name) AS Origin,adjustmentdetails.CommodityType AS CommTypeId,uoms.Name AS UomName,adjustmentdetails.*,prlookups.ProcessType,crlookups.CropYear AS CropYearData,IFNULL(adjustmentdetails.Memo,"") AS Memo,ROUND((adjustmentdetails.NetKg/1000),2) AS WeightByTon,uoms.Name AS UomName,locations.Name AS LocationName,customers.Name AS SupplierName,customers.Code AS SupplierCode,customers.TinNumber AS SupplierTIN,adjustmentdetails.ProductionNumber,IFNULL(adjustmentdetails.CertNumber,"") AS CertNumber,IFNULL(adjustmentdetails.CertNumber,"") AS CertNumber,VarianceShortage,VarianceOverage,adjustments.customers_id,uoms.uomamount,uoms.bagweight FROM adjustmentdetails LEFT JOIN woredas ON adjustmentdetails.woredas_id = woredas.id LEFT JOIN zones ON woredas.zone_id = zones.id LEFT JOIN regions on zones.Rgn_Id = regions.id LEFT JOIN uoms ON adjustmentdetails.uoms_id = uoms.id LEFT JOIN locations ON adjustmentdetails.LocationId=locations.id LEFT JOIN customers ON adjustmentdetails.SupplierId=customers.id LEFT JOIN lookups AS grlookups ON adjustmentdetails.Grade=grlookups.GradeValue LEFT JOIN lookups AS prlookups ON adjustmentdetails.ProcessType=prlookups.ProcessTypeValue LEFT JOIN lookups AS crlookups ON adjustmentdetails.CropYear=crlookups.CropYearValue LEFT JOIN lookups AS cmlookups ON adjustmentdetails.CommodityType=cmlookups.CommodityTypeValue LEFT JOIN adjustments ON adjustmentdetails.HeaderId=adjustments.id WHERE adjustmentdetails.HeaderId = '.$id.' ORDER BY adjustmentdetails.id DESC');
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
            'memo'=>$memo,
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

            $html=\View::make('inventory.report.adjcomm')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Store Adjustment ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->SetWatermarkText($status);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Store-Adjustment '.$docnum.'.pdf','I');

            // $pdf=PDF::loadView('inventory.report.req',$data);
            // return $pdf->stream();
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
