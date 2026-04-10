<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sales;
use App\Models\Salesitem;
use App\Models\customer;
use App\Models\Regitem;
use App\Models\companyinfo;
use App\Models\systeminfo;
use Invoice;
use Carbon\Carbon;
use App\Reports\MyReport;
use App\Reports\salesbyCustomer;
use App\Reports\salesbyItem;
use App\Reports\WitholdReport;
use App\Reports\SalesDetailReport;
use Illuminate\Support\Facades\Response;

use App\Reports\ItemReport;
use Illuminate\Support\Facades\Validator;
use PdfReport;
use PDF;
use DB;
use DateTime;
use DateTimeZone;
use Image;

class ReportController extends Controller
{

    public function __contruct () {
        $this->middleware("guest");
    }
    //
    public function index($id)
    {
        if(Salesitem::where('HeaderId',$id)->exists())
   {
    $sale=DB::select('SELECT salesitems.id,salesitems.HeaderId,salesitems.ItemId,regitems.Name AS ItemName,regitems.Code As ItemCode ,salesitems.Quantity,salesitems.UnitPrice,salesitems.Discount,salesitems.BeforeTaxPrice,salesitems.TaxAmount,salesitems.TotalPrice FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id where salesitems.HeaderId='.$id);
    $totalprice=Sales::find($id);
    $customerid=$totalprice->CustomerId;
    $customerDetails=customer::find($customerid);
    $due_date=Carbon::now();
    $compId="1";
    $compInfo=companyinfo::find($compId);
    $count=0;
   $data=['sale'=>$sale,'totalprice'=>$totalprice,'count'=>$count,'customerDetails'=>$customerDetails,'due_date'=>$due_date,'compInfo'=>$compInfo];
   $pdf=PDF::loadView('report.salereport',$data);
   return $pdf->stream();

      }
    }
    
  
 

    public function saleReport()
    {
        $report = new MyReport;
        $report->run();
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status="Confirmed" GROUP BY StoreId,stores.id,stores.Name');
        
    // $report=DB::select('SELECT categories.Name AS Category,regitems.Name,SUM(salesitems.Quantity) AS Quantity,TRUNCATE(SUM(salesitems.BeforeTaxPrice),2) AS SubTotal,TRUNCATE(SUM(salesitems.TaxAmount),2) AS Tax,TRUNCATE(SUM(salesitems.TotalPrice),2) AS TotalPrice FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN sales ON salesitems.HeaderId=sales.id GROUP BY salesitems.ItemId,categories.Name,regitems.Name ORDER BY categories.Name ASC');
        return view('report.report',['report'=>$report,'store'=>$store]);

    //  return view("report.report");
        
    }

    public function salebycustomer()
    {   
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status="Confirmed" GROUP BY StoreId,stores.id,stores.Name');
        $customerSrc=DB::select('SELECT CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber FROM sales INNER JOIN customers ON sales.CustomerId=customers.id WHERE sales.Status="Confirmed" GROUP BY CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber');
        return view('report.salebycustomer',['customerSrc'=>$customerSrc,'store'=>$store]);
    }

    public function salebyitem()
    {
        $itemSrc=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status="Confirmed" GROUP BY StoreId,stores.id,stores.Name');
        return view('report.salesbyItem',['itemSrc'=>$itemSrc,'store'=>$store]);
    }

    public function witholdreportIndex()
    {
        $customerSrc=DB::select('SELECT CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber FROM sales INNER JOIN customers ON sales.CustomerId=customers.id WHERE sales.Status="Confirmed" GROUP BY CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber');
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status="Confirmed" GROUP BY StoreId,stores.id,stores.Name');
        $itemSrc=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        return view('report.witholdView',['customerSrc'=>$customerSrc,'itemSrc'=>$itemSrc,'store'=>$store]);
    }

    public function salesDetailIndex()
    {
       $customerSrc=DB::select('SELECT CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber FROM sales INNER JOIN customers ON sales.CustomerId=customers.id WHERE sales.Status="Confirmed" GROUP BY CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber');
       $store=DB::select('SELECT StoreId,stores.id,stores.Name from sales INNER JOIN stores ON sales.StoreId=stores.id WHERE sales.Status="Confirmed" GROUP BY StoreId,stores.id,stores.Name');
       return view('report.salesdetailview',['customerSrc'=>$customerSrc,'store'=>$store]);    
    }

    public function HtmlToPDF($from,$to,$store,$paymentype,$itemgroup)
    {  
        $compId="1";
        $compInfo=companyinfo::find($compId);
    
            $report = new ItemReport(array(
                'from'=>$from,
                'to'=>$to,
                'store'=>$store,
                'paymentype'=>$paymentype,
                'itemgroup'=>$itemgroup,
            ));
            $report->run(); 
            $paymentypes=str_replace('"', '', $paymentype);
            $itemgroups=str_replace('"', '', $itemgroup);
            $storename=DB::select('SELECT GROUP_CONCAT(name , " ") AS StoreName FROM stores WHERE id in ('.$store.')');
    
            $data = [
            'report'=>$report,
            'compInfo'  => $compInfo,
            'from' => $from,
            'to' => $to,
            'storename'=>$storename,
            'paymentypes'=>$paymentypes,
            'itemgroups'=>$itemgroups,
            
        ];
        $mpdf=new \Mpdf\Mpdf([
            // 'orientation' => 'L',
            'margin_left'=>3,
            'margin_right'=>3,
            'margin_top'=>5,
            'margin_bottom'=>2,
            'margin_header'=>5,
            'margin_footer'=>1,
        ]); 
    
        //return view('report.HtmlToPDF')->with($data);
        $date = Carbon::now('Africa/Addis_Ababa')->format('Y-m-d @ H:i:s');
        $html=\View::make('report.HtmlToPDF')->with($data);
        $html=$html->render();   

        $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td colspan="3" style="border-top:white;border-right:white;border-left:white;"></td>
        </tr>
        <tr>
            <td width="50%" style="border:none;">Generated on : '.$date.'</td>
            <td width="17%" align="center" style="border:none;"></td>
            <td width="33%" style="text-align: right;border:none;">Page {PAGENO} of {nbpg}</td>
        </tr>
       </table>');
        $mpdf->WriteHTML($html);
        $mpdf->Output('GeneralSales.pdf','I');  
    }

    public function SalesDetailCon($from,$to,$store,$paymentype,$customer)
    {  
        $compId="1";
        $compInfo=companyinfo::find($compId);
    
            $report = new SalesDetailReport(array(
                'from'=>$from,
                'to'=>$to,
                'store'=>$store,
                'paymentype'=>$paymentype,
                'customer'=>$customer,
            ));
            $report->run(); 
            $paymentypes=str_replace('"', '', $paymentype);
            $storename=DB::select('SELECT GROUP_CONCAT(name , " ") AS StoreName FROM stores WHERE id in ('.$store.')');
    
            $data = [
            'report'=>$report,
            'compInfo'  => $compInfo,
            'from' => $from,
            'to' => $to,
            'storename'=>$storename,
            'paymentypes'=>$paymentypes,
            
        ];
        $mpdf=new \Mpdf\Mpdf([
            // 'orientation' => 'L',
            'margin_left'=>3,
            'margin_right'=>3,
            'margin_top'=>5,
            'margin_bottom'=>2,
            'margin_header'=>5,
            'margin_footer'=>1,
        ]); 
    
        $date = Carbon::now('Africa/Addis_Ababa')->format('Y-m-d @ H:i:s');
        $html=\View::make('report.salesdetail')->with($data);
        $html=$html->render();   

        $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td colspan="3" style="border-top:white;border-right:white;border-left:white;"></td>
        </tr>
        <tr>
            <td width="50%" style="border:none;">Generated on : '.$date.'</td>
            <td width="17%" align="center" style="border:none;"></td>
            <td width="33%" style="text-align: right;border:none;">Page {PAGENO} of {nbpg}</td>
        </tr>
       </table>');
        $mpdf->WriteHTML($html);
        $mpdf->Output('SalesDetail.pdf','I');  
    }

    public function salesbycustomer($customer,$from,$to,$store,$paymentype,$itemgroup )
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $custid=customer::findOrFail($customer);
        $customerName=$custid->Name;

        $report = new salesbyCustomer(array(
            'customer'=>$customer,
            'from'=>$from,
            'to'=>$to,
            'store'=>$store,
            'paymentype'=>$paymentype,
            'itemgroup'=>$itemgroup,
        ));
        $report->run(); 

        $paymentypes=str_replace('"', '', $paymentype);
        $itemgroups=str_replace('"', '', $itemgroup);

        $storename=DB::select('SELECT GROUP_CONCAT(name , " ") AS StoreName FROM stores WHERE id in ('.$store.')');
    
        $data = [
            'customerName'=>$customerName,
            'report'=>$report,
            'compInfo'  => $compInfo,
            'from' => $from,
            'to' => $to,
            'storename'=>$storename,
            'paymentypes'=>$paymentypes,
            'itemgroups'=>$itemgroups,
        ];

        $mpdf=new \Mpdf\Mpdf([
        // 'orientation' => 'L',
        'margin_left'=>3,
        'margin_right'=>3,
        'margin_top'=>5,
        'margin_bottom'=>2,
        'margin_header'=>5,
        'margin_footer'=>1,
        ]); 
        
        $date = Carbon::now('Africa/Addis_Ababa')->format('Y-m-d @ H:i:s');   
        $html=\View::make('report.salesbycustomerpdf')->with($data);
        $html=$html->render();   
        $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td colspan="3" style="border-top:white;border-right:white;border-left:white;"></td>
        </tr>
        <tr>
            <td width="50%" style="border:none;">Generated on : '.$date.'</td>
            <td width="17%" align="center" style="border:none;"></td>
            <td width="33%" style="text-align: right;border:none;">Page {PAGENO} of {nbpg}</td>
        </tr>
    </table>');

        $mpdf->WriteHTML($html);
        $mpdf->Output('salesbycustomer.pdf','I');
    }

    public function witholdreport($customer,$from,$to,$store,$paymentype,$status)
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $custid=customer::findOrFail($customer);
        $customerName=$custid->Name;

        $report = new WitholdReport(array(
            'customer'=>$customer,
            'from'=>$from,
            'to'=>$to,
            'store'=>$store,
            'paymentype'=>$paymentype,
            'status'=>$status,
        ));
        $report->run(); 

        $paymentypes=str_replace('"', '', $paymentype);
        //$status=str_replace('"', '', $status);
        if($status=="1,0")
        {
            $status="Settled,Not Settled";
        }
        if($status=="0")
        {
            $status="Not Settled";
        }
        if($status=="1")
        {
            $status="Settled";
        }
        $storename=DB::select('SELECT GROUP_CONCAT(name , " ") AS StoreName FROM stores WHERE id in ('.$store.')');
    
        $data = [
            'customerName'=>$customerName,
            'report'=>$report,
            'compInfo'  => $compInfo,
            'from' => $from,
            'to' => $to,
            'storename'=>$storename,
            'paymentypes'=>$paymentypes,
            'status'=>$status,
        ];

        $mpdf=new \Mpdf\Mpdf([
        // 'orientation' => 'L',
        'margin_left'=>3,
        'margin_right'=>3,
        'margin_top'=>5,
        'margin_bottom'=>2,
        'margin_header'=>5,
        'margin_footer'=>1,
        ]); 
        
        $date = Carbon::now('Africa/Addis_Ababa')->format('Y-m-d @ H:i:s');   
        $html=\View::make('report.witholdReport')->with($data);
        $html=$html->render();   
        $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td colspan="3" style="border-top:white;border-right:white;border-left:white;"></td>
        </tr>
        <tr>
            <td width="50%" style="border:none;">Generated on : '.$date.'</td>
            <td width="17%" align="center" style="border:none;"></td>
            <td width="33%" style="text-align: right;border:none;">Page {PAGENO} of {nbpg}</td>
        </tr>
    </table>');

        $mpdf->WriteHTML($html);
        $mpdf->Output('WitholdandVatReport.pdf','I');
    }

    public function salesbyitem($item,$from,$to,$store,$paymentype,$itemgroup )
    {
                        $compId="1";
                        $compInfo=companyinfo::find($compId);
                       $items=Regitem::findOrFail($item);
                        $itemName=$items->Name;

                        $report = new salesbyItem(array(
                            'item'=>$item,
                            'from'=>$from,
                            'to'=>$to,
                            'store'=>$store,
                            'paymentype'=>$paymentype,
                            'itemgroup'=>$itemgroup,
                        ));
                      $report->run(); 


                      $paymentypes=str_replace('"', '', $paymentype);
                      $itemgroups=str_replace('"', '', $itemgroup);
               
               
                     $storename=DB::select('SELECT GROUP_CONCAT(name , " ") AS StoreName FROM stores WHERE id in ('.$store.')');
                  
               
                    $data = [
                       'itemName'=>$itemName,
                       'report'=>$report,
                       'compInfo'  => $compInfo,
                       'from' => $from,
                       'to' => $to,
                       'storename'=>$storename,
                       'paymentypes'=>$paymentypes,
                       'itemgroups'=>$itemgroups,
                   ];

                   $mpdf=new \Mpdf\Mpdf([
                    // 'orientation' => 'L',
                    'margin_left'=>3,
                    'margin_right'=>3,
                    'margin_top'=>5,
                    'margin_bottom'=>2,
                    'margin_header'=>5,
                    'margin_footer'=>1,
                ]); 
            
             // return view('report.salesbycustomerpdf')->with($data);
             
                $date = Carbon::now('Africa/Addis_Ababa')->format('Y-m-d @ H:i:s');   
                $html=\View::make('report.salebyitempdf')->with($data);
                $html=$html->render();   
                $mpdf->SetHTMLFooter('
                <table width="100%">
                <tr>
                <td colspan="3" style="border-top:white;border-right:white;border-left:white;"></td>
                </tr>
                <tr>
                    <td width="50%" style="border:none;">Generated on : '.$date.'</td>
                    <td width="17%" align="center" style="border:none;"></td>
                    <td width="33%" style="text-align: right;border:none;">Page {PAGENO} of {nbpg}</td>
                </tr>
            </table>');
                $mpdf->WriteHTML($html);
                $mpdf->Output('salesbyitem.pdf','I');

    }


}
