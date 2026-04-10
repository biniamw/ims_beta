<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sales;
use App\Models\Salesitem;
use App\Models\customer;
use App\Models\companyinfo;
use App\Models\systeminfo;
use Invoice;
use Carbon\Carbon;
use App\Models\Regitem;
use App\Reports\MyReport;
use App\Reports\ItemReport;
use App\Reports\PurchaseReport;
use App\Reports\PurchaseBySupplier;
use App\Reports\PurchaseByItem;
use App\Reports\PurchaseDetail;
use App\Reports\StoreMovementReport;
use Response;
use PdfReport;
use PDF;
use DB;
use DateTime;
use DateTimeZone;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseList;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function purchaseReport()
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from receivings INNER JOIN stores ON receivings.StoreId=stores.id WHERE receivings.Status="Confirmed" AND receivings.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=13) GROUP BY StoreId,stores.id,stores.Name');
        return view('inventory.report.purchaseui',['store'=>$store,'compInfo'=>$compInfo]);      
    }

    public function purchasebySuppReport()
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $customerSrc=DB::select('SELECT CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.Status="Confirmed" GROUP BY CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber');
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from receivings INNER JOIN stores ON receivings.StoreId=stores.id WHERE receivings.Status="Confirmed" AND receivings.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=13) GROUP BY StoreId,stores.id,stores.Name');
        return view('inventory.report.purchasebysupplierui',['customerSrc'=>$customerSrc,'store'=>$store,'compInfo'=>$compInfo]);   
        //return Excel::download(new PurchaseList, 'users-collection.xlsx');   
    }

    public function purchasebyItemReport()
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $itemSrc=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id GROUP BY regitems.id,regitems.Name,regitems.Code,regitems.SKUNumber ORDER BY regitems.Name ASC');
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from receivings INNER JOIN stores ON receivings.StoreId=stores.id WHERE receivings.Status="Confirmed" AND receivings.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=13) GROUP BY StoreId,stores.id,stores.Name');
        return view('inventory.report.purchasebyitemui',['itemSrc'=>$itemSrc,'store'=>$store,'compInfo'=>$compInfo]);      
    }

    public function detailPurchase()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $customerSrc=DB::select('SELECT CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber FROM receivings INNER JOIN customers ON receivings.CustomerId=customers.id WHERE receivings.Status="Confirmed" GROUP BY CustomerId,customers.id,customers.Name,customers.Code,customers.TinNumber');
        $store=DB::select('SELECT StoreId,stores.id,stores.Name from receivings INNER JOIN stores ON receivings.StoreId=stores.id WHERE receivings.Status="Confirmed" AND receivings.StoreId IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$userid.' AND storeassignments.Type=13) GROUP BY StoreId,stores.id,stores.Name');
        return view('inventory.report.purchasedetailui',['customerSrc'=>$customerSrc,'store'=>$store]);      
    }

    public function PurchaseReportCon($from,$to,$store,$paymentype)
    {  
        $query = DB::select("SELECT categories.Name AS Category,stores.Name as StoreName,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber,receivings.PaymentType,uoms.Name AS UOM,SUM(receivingdetails.Quantity) AS Quantity,receivingdetails.UnitCost,ROUND(SUM(receivingdetails.BeforeTaxCost),2) AS BeforeTaxCost,ROUND(SUM(receivingdetails.TaxAmount),2) AS Tax,ROUND(SUM(receivingdetails.TotalCost),2) AS TotalCost,receivings.Status FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON receivingdetails.NewUOMId=uoms.id INNER JOIN receivings ON receivingdetails.HeaderId=receivings.id INNER JOIN stores ON receivings.StoreId=stores.id where DATE(receivings.TransactionDate)>= '".$from."' AND DATE(receivings.TransactionDate)<='".$to."' AND receivings.StoreId IN($store) AND receivings.PaymentType IN($paymentype) AND receivings.Status='Confirmed' GROUP BY receivingdetails.ItemId,categories.Name,regitems.Name,regitems.Code,regitems.SKUNumber,uoms.Name,receivingdetails.UnitCost,receivings.PaymentType,stores.Name,receivings.Status ORDER BY receivings.PaymentType ASC,categories.Name ASC");
        return datatables()->of($query)->toJson();
    }

    public function PurchaseBySupplier($from,$to,$store,$paymentype)
    {
        $cus=$_POST['customerid']; 
        $customer=implode(',', $cus);
        $query = DB::select("SELECT customers.Name AS Supplier,categories.Name AS Category,stores.Name AS StoreName,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber,receivings.PaymentType,uoms.Name AS UOM,SUM(receivingdetails.Quantity) AS Quantity,receivingdetails.UnitCost,ROUND(SUM(receivingdetails.BeforeTaxCost),2) AS BeforeTaxCost,ROUND(SUM(receivingdetails.TaxAmount),2) AS Tax,ROUND(SUM(receivingdetails.TotalCost),2) AS TotalCost,receivings.Status FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON receivingdetails.NewUOMId=uoms.id INNER JOIN receivings ON receivingdetails.HeaderId=receivings.id INNER JOIN stores ON receivings.StoreId=stores.id INNER JOIN customers ON receivings.CustomerId=customers.id where DATE(receivings.TransactionDate)>= '".$from."' AND DATE(receivings.TransactionDate)<='".$to."' AND receivings.StoreId IN($store) AND receivings.PaymentType IN($paymentype) AND receivings.CustomerId IN($customer) AND receivings.Status='Confirmed' GROUP BY receivingdetails.ItemId,categories.Name,regitems.Name,regitems.Code,regitems.SKUNumber,uoms.Name,receivingdetails.UnitCost,receivings.PaymentType,stores.Name,receivings.Status,customers.Name ORDER BY receivings.PaymentType ASC,customers.Name ASC");
        return datatables()->of($query)->toJson();
    }

    public function PurchasebyItem($from,$to,$store,$paymentype)
    {
        $items=$_POST['itemnames']; 
        $item=implode(',', $items);
        $query = DB::select("SELECT customers.Name AS Supplier,categories.Name AS Category,stores.Name AS StoreName,regitems.Name AS ItemName,regitems.Code AS ItemCode,regitems.SKUNumber,receivings.PaymentType,uoms.Name AS UOM,SUM(receivingdetails.Quantity) AS Quantity,receivingdetails.UnitCost,ROUND(SUM(receivingdetails.BeforeTaxCost),2) AS BeforeTaxCost,ROUND(SUM(receivingdetails.TaxAmount),2) AS Tax,ROUND(SUM(receivingdetails.TotalCost),2) AS TotalCost,receivings.Status FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON receivingdetails.NewUOMId=uoms.id INNER JOIN receivings ON receivingdetails.HeaderId=receivings.id INNER JOIN stores ON receivings.StoreId=stores.id INNER JOIN customers ON receivings.CustomerId=customers.id WHERE DATE(receivings.TransactionDate)>= '".$from."' AND DATE(receivings.TransactionDate)<='".$to."' AND receivings.StoreId IN($store) AND receivings.PaymentType IN($paymentype) AND receivingdetails.ItemId IN($item) AND receivings.Status='Confirmed' GROUP BY receivingdetails.ItemId,categories.Name,regitems.Name,regitems.Code,regitems.SKUNumber,uoms.Name,receivingdetails.UnitCost,receivings.PaymentType,stores.Name,receivings.Status,customers.Name ORDER BY receivings.PaymentType ASC,customers.Name ASC");
        return datatables()->of($query)->toJson();
    }

    public function PurchaseReportContest(){
        return Excel::download(new PurchaseList, 'users-collection.xlsx');
    }

    public function PurchaseDetailCon($from,$to,$store,$paymentype,$customer)
    {  
        $compId="1";
        $compInfo=companyinfo::find($compId);
    
            $report = new PurchaseDetail(array(
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
        $html=\View::make('inventory.report.purchasedetail')->with($data);
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
        $mpdf->Output('PurchaseDetail.pdf','I');  
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
