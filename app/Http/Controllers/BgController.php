<?php

namespace App\Http\Controllers;
use App\Models\begining;
use App\Models\beginingdetail;
use App\Models\DsBegining;
use App\Models\dsbeginingdetail;
use App\Models\customer;
use App\Models\store;
use App\Models\companyinfo;
use App\Models\systeminfo;
use App\Models\closingdetail;
use App\Models\closing;
use App\Models\fiscalyear;
use Illuminate\Http\Request;
use Invoice;
use Carbon\Carbon;

use PdfReport;
use PDF;
use DB;

class BgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(beginingdetail::where('HeaderId',$id)->exists())
        {
            error_reporting(0); 
            ini_set('max_execution_time', '30000');
            ini_set("pcre.backtrack_limit", "500000000");
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

            $headerInfo=begining::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $begnum=$headerInfo->EndingDocumentNo;
            $date=$headerInfo->Date;
            $fiscalyear=$headerInfo->FiscalYear;
            $countedby=$headerInfo->CountedBy;
            $counteddate=$headerInfo->CountedDate;
            $verifiedby=$headerInfo->VerifiedBy;
            $verifieddate=$headerInfo->VerifiedDate;
            $postedby=$headerInfo->PostedBy;
            $posteddate=$headerInfo->PostedDate;
            $status=$headerInfo->Status;
            $storeid=$headerInfo->StoreId;

            $srcstore=store::find($storeid);
            $storename=$srcstore->Name;
            $fiscalyearattr=fiscalyear::where('FiscalYear',$fiscalyear)->first();
            $fiscalyr=$fiscalyearattr->Monthrange;
            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::today()->toDateString();
            $detailTable=DB::select('SELECT beginingdetails.id,beginingdetails.ItemId,beginingdetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,stores.Name as StoreName,FORMAT(beginingdetails.Quantity,2) AS Quantity,beginingdetails.Memo,FORMAT(beginingdetails.UnitCost,2) AS UnitCost,FORMAT(beginingdetails.BeforeTaxCost,2) AS BeforeTaxCost,FORMAT(beginingdetails.TaxAmount,2) AS TaxAmount,FORMAT(beginingdetails.TotalCost,2) AS TotalCost FROM beginingdetails INNER JOIN regitems ON beginingdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id INNER JOIN stores ON beginingdetails.StoreId=stores.id where beginingdetails.HeaderId='.$id.' ORDER BY ItemName ASC');
            $count=0;

            $data=[ 'detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'begnum'=>$begnum,
            'date'=>$date,
            'fiscalyear'=>$fiscalyr,
            'countedby'=>$countedby,
            'counteddate'=>$counteddate,
            'verifiedby'=>$verifiedby,
            'verifieddate'=>$verifieddate,
            'postedby'=>$postedby,
            'posteddate'=>$posteddate,
            'storename'=>$storename,
            'status'=>$status,
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
            $html=\View::make('inventory.report.bg')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Begininng Note ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Begininng-Note '.$docnum.'.pdf','I');
            //$pdf=PDF::loadView('inventory.report.bg',$data);
            //return $pdf->stream();
            
        }
        //return view('inventory.report.bg',$data);
    }

    public function indexen($id)
    {
        if(closingdetail::where('header_id',$id)->exists())
        {
            //---Start Header Info---
            error_reporting(0); 
            ini_set('max_execution_time', '30000');
            ini_set("pcre.backtrack_limit", "500000000");
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

            $headerInfo=closing::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $begnum=$headerInfo->beginningnumber;
            $date=$headerInfo->Date;
            $fiscalyear=$headerInfo->FiscalYear;
            $countedby=$headerInfo->CountedBy;
            $counteddate=$headerInfo->CountedDate;
            $verifiedby=$headerInfo->VerifiedBy;
            $verifieddate=$headerInfo->VerifiedDate;
            $postedby=$headerInfo->PostedBy;
            $posteddate=$headerInfo->PostedDate;
            $status=$headerInfo->Status;
            $storeid=$headerInfo->store_id;

            $srcstore=store::find($storeid);
            $storename=$srcstore->Name;
            $fiscalyearattr=fiscalyear::where('FiscalYear',$fiscalyear)->first();
            $fiscalyr=$fiscalyearattr->Monthrange;
            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::today()->toDateString();
            $detailTable=DB::select('SELECT closingdetails.id,closingdetails.item_id,closingdetails.header_id,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,stores.Name as StoreName,FORMAT(closingdetails.Quantity,0) AS Quantity,closingdetails.Memo,"" AS UnitCost,FORMAT(closingdetails.PhysicalCount,0) AS PhysicalCount,FORMAT(closingdetails.ShortageVariance,0) AS ShortageVariance,FORMAT(closingdetails.OverageVariance,0) AS OverageVariance,FORMAT(closingdetails.BeforeTaxCost,2) AS BeforeTaxCost,FORMAT(closingdetails.TaxAmount,2) AS TaxAmount,FORMAT(closingdetails.TotalCost,2) AS TotalCost FROM closingdetails INNER JOIN regitems ON closingdetails.item_id=regitems.id inner join uoms on regitems.MeasurementId=uoms.id INNER JOIN stores ON closingdetails.store_id=stores.id where closingdetails.header_id='.$id.' ORDER BY ItemName ASC');
            $count=0;

            $data=['detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'begnum'=>$begnum,
            'date'=>$date,
            'fiscalyear'=>$fiscalyr,
            'countedby'=>$countedby,
            'counteddate'=>$counteddate,
            'verifiedby'=>$verifiedby,
            'verifieddate'=>$verifieddate,
            'postedby'=>$postedby,
            'posteddate'=>$posteddate,
            'storename'=>$storename,
            'status'=>$status,
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
            $html=\View::make('inventory.report.en')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Ending Note ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Ending-Note '.$docnum.'.pdf','I');
            //$pdf=PDF::loadView('inventory.report.bg',$data);
            //return $pdf->stream();
            
        }
        //return view('inventory.report.en',$data);
    }

    public function indexds($id)
    {
        if(dsbeginingdetail::where('HeaderId',$id)->exists())
        {
            //---Start Header Info---
            error_reporting(0); 
            ini_set('max_execution_time', '30000');
            ini_set("pcre.backtrack_limit", "500000000");
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

            $headerInfo=DsBegining::find($id);
            $docnum=$headerInfo->DocumentNumber;
            $date=$headerInfo->Date;
            $fiscalyear=$headerInfo->FiscalYear;
            $countedby=$headerInfo->CountedBy;
            $counteddate=$headerInfo->CountedDate;
            $verifiedby=$headerInfo->VerifiedBy;
            $verifieddate=$headerInfo->VerifiedDate;
            $postedby=$headerInfo->PostedBy;
            $posteddate=$headerInfo->PostedDate;
            $status=$headerInfo->Status;
            $storeid=$headerInfo->StoreId;

            $srcstore=store::find($storeid);
            $storename=$srcstore->Name;
            $fiscalyearattr=fiscalyear::where('FiscalYear',$fiscalyear)->first();
            $fiscalyr=$fiscalyearattr->Monthrange;
            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');
            $currentdate =Carbon::today()->toDateString();
            $detailTable=DB::select('SELECT dsbeginingdetails.id,dsbeginingdetails.ItemId,dsbeginingdetails.HeaderId,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber AS SKUNumber,uoms.Name as UOM,stores.Name as StoreName,FORMAT(dsbeginingdetails.Quantity,2) AS Quantity,dsbeginingdetails.Memo,FORMAT(dsbeginingdetails.UnitCost,2) AS UnitCost,FORMAT(dsbeginingdetails.BeforeTaxCost,2) AS BeforeTaxCost,FORMAT(dsbeginingdetails.TaxAmount,2) AS TaxAmount,FORMAT(dsbeginingdetails.TotalCost,2) AS TotalCost FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id inner join uoms on regitems.MeasurementId=uoms.id INNER JOIN stores ON dsbeginingdetails.StoreId=stores.id where dsbeginingdetails.HeaderId='.$id.' ORDER BY ItemName ASC');
            $count=0;

            $data=[ 'detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'date'=>$date,
            'fiscalyear'=>$fiscalyr,
            'countedby'=>$countedby,
            'counteddate'=>$counteddate,
            'verifiedby'=>$verifiedby,
            'verifieddate'=>$verifieddate,
            'postedby'=>$postedby,
            'posteddate'=>$posteddate,
            'storename'=>$storename,
            'status'=>$status,
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
            //$pdf=PDF::loadView('inventory.report.bg',$data);
            //return $pdf->stream();
            $mpdf=new \Mpdf\Mpdf([
                //'orientation' => 'L',
                'margin_left' => 2,
                'margin_right' => 2,
                'margin_top' => 37,
                'margin_bottom' => 25,
                'margin_header' => 0,
                'margin_footer' => 1
            ]); 
            $html=\View::make('inventory.report.bg')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('DS Begininng Note ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->WriteHTML($html);
            $mpdf->Output('DS-Begininng-Note '.$docnum.'.pdf','I');
        }
        //return view('inventory.report.bg',$data);
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
