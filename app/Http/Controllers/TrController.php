<?php

namespace App\Http\Controllers;
use App\Models\transfer;
use App\Models\transferdetail;
use App\Models\issue;
use App\Models\issuedetail;
use App\Models\customer;
use App\Models\store;
use App\Models\companyinfo;
use App\Models\systeminfo;
use Illuminate\Http\Request;
use Invoice;
use Carbon\Carbon;

use PdfReport;
use PDF;
use DB;

class TrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(transferdetail::where('HeaderId',$id)->exists())
        {
            $isstype="Transfer";
            $issueids=0;
            $tracon = DB::table('transfers')->where('id',$id)->latest()->first();
            $sta=$tracon->Status;
            if($sta=="Issued"||$sta=="Issued(Received)"){
                $issuecon = DB::table('issues')->where('ReqId',$id)->where('Type',$isstype)->latest()->first();
                $issueids=$issuecon->id;
            }
            error_reporting(0); 
            $st="";
            $newissuedate="";
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

            $headerInfo=transfer::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $type=$headerInfo->Type;
            $reqdate=$headerInfo->Date;
            $transferby=$headerInfo->TransferBy;
            $reason=$headerInfo->Reason;
            $approvedby=$headerInfo->ApprovedBy;
            $approveddate=$headerInfo->ApprovedDate;
            $issuedby=$headerInfo->IssuedBy;
            $issueddate=$headerInfo->IssuedDate;
            $newissuedate = date("Y-m-d", strtotime($issueddate));
            $preparedby=$headerInfo->PreparedBy;
            $storeid=$headerInfo->SourceStoreId;
            $desstoreid=$headerInfo->DestinationStoreId;

            $deliveredby=$headerInfo->DeliveredBy;
            $delivereddate=$headerInfo->DeliveredDate;

            $verifiedby=$headerInfo->AuthorizedBy;
            $verifieddate=$headerInfo->AuthorizedDate;

            $receivedby=$headerInfo->ReceivedBy;
            $receieveddate=$headerInfo->ReceivedDate;
            $issuedocnum=$headerInfo->IssueDocNumber;
            $status=$headerInfo->Status;
            $st=$headerInfo->Status;

            if($status=="Void(Issued)" || $status=="Void(Pending)" || $status=="Void(Approved)"){
                //$st="Void";
                $newissuedate="";
            }
            else if($status=="Rejected"){
                //$st="Rejected";
                $newissuedate="";
            }
            else if($status=="Issued"||$status=="Issued(Received)"){
               // $st="";
                $newissuedate = date("Y-m-d", strtotime($issueddate));
            }
            else{
                //$st="";
                $newissuedate="";
            }
            $srcstore=store::find($storeid);
            $storename=$srcstore->Name;

            $desstore=store::find($desstoreid);
            $desstorename=$desstore->Name;

            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::today()->toDateString();
            $reqdatetime = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT transferdetails.id,transferdetails.ItemId,transferdetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,FORMAT(transferdetails.Quantity,0) AS Quantity,transferdetails.Memo,transferdetails.UnitCost,transferdetails.BeforeTaxCost,transferdetails.TaxAmount,transferdetails.TotalCost,transferdetails.ApprovedQuantity,transferdetails.IssuedQuantity,transferdetails.ApprovedMemo FROM transferdetails INNER JOIN regitems ON transferdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where transferdetails.HeaderId='.$id);
            $count=0;

            $data=[ 'detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'reqdate'=>$reqdate,
            'reqdatetime'=>$reqdatetime,
            'approveddate'=>$approveddate,
            'issueddate'=>$issueddate,
            'type'=>$type,
            'storename'=>$storename,
            'desstorename'=>$desstorename,
            'approvedby'=>$approvedby,
            'issuedby'=>$issuedby,
            'preparedby'=>$preparedby,
            'transferby'=>$transferby,
            'deliveredby'=>$deliveredby,
            'delivereddate'=>$delivereddate,
            'verifiedby'=>$verifiedby,
            'verifieddate'=>$verifieddate,
            'receivedby'=>$receivedby,
            'receieveddate'=>$receieveddate,
            'issuedocnum'=>$issuedocnum,
            'issueids'=>$issueids,
            'reason'=>$reason,
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

            $html=\View::make('inventory.report.tr')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Store Transfer & Issue ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->SetWatermarkText($st);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Store-Transfer-&-Issue '.$docnum.'.pdf','I');
            // $pdf=PDF::loadView('inventory.report.tr',$data);
            // return $pdf->stream();
        }
    }

    public function transferref($trid)
    {
        //$id=transfer::where('DocumentNumber',$refnum)->first()->id;
        //$id=issue::where('id',$trid)->first()->ReqId;
        $isstype="Transfer";
        $issuecon = DB::table('issues')->where('id',$trid)->where('Type',$isstype)->latest()->first();
        $issueids=$issuecon->id;
        $transferid=$issuecon->ReqId;
        $id=$trid;
        
        if(transferdetail::where('HeaderId',$id)->exists())
        {
            error_reporting(0); 
            $st="";
            $newissuedate="";
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

            $headerInfo=transfer::find($transferid);
            $docnum=$headerInfo->DocumentNumber;
            $type=$headerInfo->Type;
            $reqdate=$headerInfo->Date;
            $transferby=$headerInfo->TransferBy;
            $reason=$headerInfo->Reason;
            $approvedby=$headerInfo->ApprovedBy;
            $approveddate=$headerInfo->ApprovedDate;
            $issuedby=$headerInfo->IssuedBy;
            $issueddate=$headerInfo->IssuedDate;
            $preparedby=$headerInfo->PreparedBy;
            $storeid=$headerInfo->SourceStoreId;
            $desstoreid=$headerInfo->DestinationStoreId;

            $deliveredby=$headerInfo->DeliveredBy;
            $delivereddate=$headerInfo->DeliveredDate;
            $receivedby=$headerInfo->ReceivedBy;
            $receieveddate=$headerInfo->ReceivedDate;
            $issuedocnum=$headerInfo->IssueDocNumber;
            $status=$headerInfo->Status;
            if($status=="Void(Issued)" || $status=="Void(Pending)" || $status=="Void(Approved)"){
                $st="Void";
                $newissuedate="";
            }
            else if($status=="Issued"||$status=="Issued(Received)"){
                $st="";
                $newissuedate = date("Y-m-d", strtotime($issueddate));
            }
            else{
                $st="";
                $newissuedate="";
            }

            $srcstore=store::find($storeid);
            $storename=$srcstore->Name;

            $desstore=store::find($desstoreid);
            $desstorename=$desstore->Name;

            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::today()->toDateString();
            $reqdatetime = Carbon::createFromFormat('Y-m-d H:i:s', $headerInfo->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

            $detailTable=DB::select('SELECT transferdetails.id,transferdetails.ItemId,transferdetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,FORMAT(transferdetails.Quantity,0) AS Quantity,transferdetails.Memo,transferdetails.UnitCost,transferdetails.BeforeTaxCost,transferdetails.TaxAmount,transferdetails.TotalCost FROM transferdetails INNER JOIN regitems ON transferdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where transferdetails.HeaderId='.$transferid);
            $count=0;

            $data=[ 'detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'reqdate'=>$reqdate,
            'reqdatetime'=>$reqdatetime,
            'approveddate'=>$approveddate,
            'issueddate'=>$newissuedate,
            'type'=>$type,
            'storename'=>$storename,
            'desstorename'=>$desstorename,
            'approvedby'=>$approvedby,
            'issuedby'=>$issuedby,
            'preparedby'=>$preparedby,
            'transferby'=>$transferby,
            'deliveredby'=>$deliveredby,
            'delivereddate'=>$delivereddate,
            'receivedby'=>$receivedby,
            'receieveddate'=>$receieveddate,
            'issuedocnum'=>$issuedocnum,
            'issueids'=>$issueids,
            'reason'=>$reason,
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

            $html=\View::make('inventory.report.tr')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Store Transfer Requisition ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->SetWatermarkText($st);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Store-Transfer-Requisition '.$docnum.'.pdf','I');
            //$pdf=PDF::loadView('inventory.report.tr',$data);
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
