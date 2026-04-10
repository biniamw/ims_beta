<?php

namespace App\Http\Controllers;
use App\Models\adjustment;
use App\Models\adjustmentdetail;
use App\Models\customer;
use App\Models\store;
use App\Models\companyinfo;
use App\Models\systeminfo;
use App\Models\deadstocksale;
use App\Models\deadstocksaleitem;
use App\Models\deadstock;
use App\Models\deadstockdetail;
use Illuminate\Http\Request;
use Invoice;
use Carbon\Carbon;

use PdfReport;
use PDF;
use DB;


class DsReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($id)
    {
        if(deadstocksaleitem::where('HeaderId',$id)->exists())
        {
            $st="";
            //---Start Header Info---
            error_reporting(0); 
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

            $sales=deadstocksale::FindorFail($id);
            $docnum=$sales->DocumentNumber;
            //$reqdate=$sales->CreatedDate;
            $paymenttype=$sales->PaymentType;
            $custid=$sales->CustomerId;
            $store=$sales->StoreId;
            $dstore=$sales->DestinationStore;
            $subTotal=$sales->SubTotal;
            $delby=$sales->DeliveredBy;
            $Storeval=store::FindorFail($store);
            $storeName=$Storeval->Name;
            $DStoreval=store::FindorFail($dstore);
            $dsstoreName=$DStoreval->Name;
            $cust=customer::FindorFail($custid);
            $custname=$cust->Name;
            $custcode=$cust->Code;
            $custTinNumber=$cust->TinNumber;
            $custcategory=$cust->CustomerCategory;
            $total=$dsstoreName;
            $status=$sales->Status;
            $dstype = $sales->Type == 1 ? "Sales" : ($sales->Type == 2 ? "Internal" : "Others");
            $reqdate = Carbon::createFromFormat('Y-m-d H:i:s', $sales->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            if($status=="Void"){
                $st="Void";
            }
            else if($status!="Void"){
                $st="";
            }

            $srcstore=store::find($store);
            $storename=$srcstore->Name;

            //$getfiscalyear = DB::table('fiscalyear')->where('FiscalYear', '=', $fiscalyr)->first()->Monthrange;
           
            //$currentdate=Carbon::now()->isoFormat('YYYY Do MM HH:MM A');

            $currentdate =Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable=DB::select('SELECT deadstocksalesitems.id,deadstocksale.Type,deadstocksalesitems.HeaderId,deadstocksalesitems.Dprice,regitems.Code,regitems.SKUNumber,deadstocksalesitems.ItemId,regitems.Name AS ItemName, uoms.Name AS UOM,FORMAT(deadstocksalesitems.Quantity,2) AS Quantity,FORMAT(deadstocksalesitems.Dprice,2) AS Dprice,FORMAT(deadstocksalesitems.UnitPrice,2) AS UnitPrice,FORMAT(deadstocksalesitems.Discount,2) AS Discount,FORMAT(deadstocksalesitems.BeforeTaxPrice,2) AS BeforeTaxPrice,FORMAT(deadstocksalesitems.TaxAmount,2) AS TaxAmount,FORMAT(deadstocksalesitems.TotalPrice,2) AS TotalPrice,deadstocksalesitems.Memo FROM deadstocksalesitems INNER JOIN deadstocksale ON deadstocksalesitems.HeaderId=deadstocksale.id INNER JOIN regitems ON deadstocksalesitems.ItemId=regitems.id INNER JOIN uoms ON deadstocksalesitems.NewUOMId=uoms.id where deadstocksalesitems.HeaderId='.$id);
            $count=0;
            $data=['detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'reqdate'=>$reqdate,
            'paymenttype'=>$paymenttype,
            'storename'=>$storename,
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
            'compInfo'=>$compInfo,
            'subTotal'=>number_format($subTotal,2),
            'sales'=>$sales,
            'cust'=>$cust,
            'dsstoreName'=>$dsstoreName,
            'total'=>$total,
            'cusname'=>$custname,
            'delby'=>$delby,
            'dstype' => $dstype
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
            $html=\View::make('inventory.report.dspo')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Direct-Stock-Out ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->SetWatermarkText($status);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Direct-Stock-Out '.$docnum.'.pdf','I');
            // $pdf=PDF::loadView('inventory.report.dspo',$data);
            // return $pdf->stream();
        }
    }

    public function indexhi($id)
    {
        //if(deadstockdetail::where('HeaderId',$id)->exists())
       // {
            $st="";
            //---Start Header Info---
            error_reporting(0); 
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

            $sales=deadstock::find($id);
            $docnum=$sales->DocumentNumber;
            //$reqdate=$sales->CreatedDate;
            $paymenttype=$sales->PaymentType;
            $custid=$sales->CustomerId;
            $store=$sales->SourceStore;
            $dstore=$sales->StoreId;
            $subTotal=$sales->SubTotal;
            $delby=$sales->PurchaserName;
            $vouchernum=$sales->VoucherNumber;
            $Storeval=store::FindorFail($store);
            $storeName=$Storeval->Name;
            $DStoreval=store::FindorFail($dstore);
            $dsstoreName=$DStoreval->Name;
            $cust=customer::FindorFail($custid);
            $custname=$cust->Name;
            $custcode=$cust->Code;
            $custTinNumber=$cust->TinNumber;
            $custcategory=$cust->CustomerCategory;
            $total=$storeName;
            $status=$sales->Status;
            $memo=$sales->Memo;
            $dstype = $sales->Type == 1 ? "Purchase" : ($sales->Type == 2 ? "Transfer" : "Others");
            $reqdate = Carbon::createFromFormat('Y-m-d H:i:s', $sales->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            if($status=="Void"){
                $st="Void";
            }
            else if($status!="Void"){
                $st="";
            }

            $srcstore=store::find($store);
            $storename=$srcstore->Name;
           
            $currentdate = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $detailTable = DB::select('SELECT deadstockdetails.id,deadstockdetails.ItemId,deadstockdetails.HeaderId,regitems.Code AS Code,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,uoms.Name AS UOM,deadstockdetails.Memo,FORMAT(deadstockdetails.Quantity,2) AS Quantity,FORMAT(deadstockdetails.UnitCost,2) AS UnitCost,FORMAT(deadstockdetails.BeforeTaxCost,2) AS BeforeTaxCost,FORMAT(deadstockdetails.TaxAmount,2) AS TaxAmount,FORMAT(deadstockdetails.TotalCost,2) AS TotalCost FROM deadstockdetails LEFT JOIN regitems ON deadstockdetails.ItemId=regitems.id LEFT JOIN uoms ON deadstockdetails.NewUOMId=uoms.id where deadstockdetails.HeaderId='.$id);
            $count=0;
            $data=['detailTable'=>$detailTable,
            'docnum'=>$docnum,
            'reqdate'=>$reqdate,
            'paymenttype'=>$paymenttype,
            'storename'=>$storename,
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
            'compInfo'=>$compInfo,
            'subTotal'=>number_format($subTotal,2),
            'sales'=>$sales,
            'cust'=>$cust,
            'dsstoreName'=>$dsstoreName,
            'total'=>$total,
            'cusname'=>$custname,
            'delby'=>$delby,
            'memo' => $memo,
            'dstype' => $dstype,
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
            $html=\View::make('inventory.report.dshi')->with($data);
            $html=$html->render();  
            $mpdf->SetTitle('Direct-Stock-In ('.$docnum.')');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0; 
            $mpdf->SetAuthor($companyalladdress);
            $mpdf->SetWatermarkText($status);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Direct-Stock-In '.$docnum.'.pdf','I');
            // $pdf=PDF::loadView('inventory.report.dshi',$data);
            // return $pdf->stream();
        //}
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
