<?php

namespace App\Http\Controllers;
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

class IssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(issuedetail::where('HeaderId',$id)->exists())
        {
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

            $headerInfo=issue::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $reqdocnum=$headerInfo->ReqDocumentNumber;
            $type=$headerInfo->Type;
            $reqdate=$headerInfo->Date;
            $requestedby=$headerInfo->RequestedBy;
            $requesteddate=$headerInfo->RequestDate;
            $reason=$headerInfo->Reason;
            $approvedby=$headerInfo->ApprovedBy;
            $approveddate=$headerInfo->ApprovedDate;
            $issuedby=$headerInfo->IssuedBy;
            $issueddate=$headerInfo->IssuedDate;
            $storeid=$headerInfo->SourceStoreId;
            $desstoreid=$headerInfo->DestinationStoreId;
            $trid=$headerInfo->ReqId;

            $srcstore=store::find($storeid);
            $storename=$srcstore->Name;

            $desstore=store::find($desstoreid);
            $desstorename=$desstore->Name;

            $currentdate =Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT issuedetails.id,issuedetails.ItemId,issuedetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,issuedetails.Quantity,issuedetails.Memo,issuedetails.UnitCost,issuedetails.BeforeTaxCost,issuedetails.TaxAmount,issuedetails.TotalCost FROM issuedetails INNER JOIN regitems ON issuedetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id where issuedetails.HeaderId='.$id);
            $count=0;

            $data=[ 'detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'reqdocnum'=>$reqdocnum,
            'reqdate'=>$reqdate,
            'type'=>$type,
            'storename'=>$storename,
            'desstorename'=>$desstorename,
            'approvedby'=>$approvedby,
            'requestedby'=>$requestedby,
            'issuedby'=>$issuedby,
            'requesteddate'=>$requesteddate,
            'approveddate'=>$approveddate,
            'issueddate'=>$issueddate,
            'trid'=>$trid,
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
            $html=\View::make('inventory.report.iss')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Store Issue Voucher ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Store-Issue-Voucher '.$docnum.'.pdf','I');
            // $pdf=PDF::loadView('inventory.report.iss',$data);
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
