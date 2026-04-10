<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\appconsolidate;
use App\Models\ApplicationForm;
use App\Models\appmember;
use App\Models\appservice;
use App\Models\apptrainers;
use App\Models\memberpaymenthistory;
use App\Models\membership;
use App\Models\paymenthistorygym;
use App\Models\paymentterm;
use App\Models\period;
use App\Models\perioddetail;
use App\Models\service;
use App\Models\servicedetail;
use App\Models\servicepaymenthistory;
use App\Models\companyinfo;
use Invoice;
use Carbon\Carbon;
use PdfReport;
use PDF;
use DB;
use DateTime;
use DateTimeZone;
use Session;
use Maatwebsite\Excel\Facades\Excel;

class FitnessReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function generalServiceReport(Request $request)
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        if($request->ajax()) {
            return view('gym.report.generalservice',['compInfo'=>$compInfo])->renderSections()['content'];
        } 
        else{
            return view('gym.report.generalservice',['compInfo'=>$compInfo]); 
        }
    }

    public function serviceByServiceReport(Request $request)
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $invtype=DB::select('SELECT DISTINCT applications.ApplicationType FROM applications WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY applications.ApplicationType ASC');
        $servicelist=DB::select('SELECT DISTINCT services.id,services.ServiceName FROM appconsolidates INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY services.ServiceName ASC');
        $periodlist=DB::select('SELECT DISTINCT periods.id,periods.PeriodName FROM appconsolidates INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY periods.PeriodName ASC');
        $grouplist=DB::select('SELECT DISTINCT groupmembers.id,groupmembers.GroupName FROM appconsolidates INNER JOIN servicedetails ON appconsolidates.services_id=servicedetails.services_id INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN groupmembers ON servicedetails.groupmembers_id=groupmembers.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY groupmembers.GroupName ASC');
        $ptermlist=DB::select('SELECT DISTINCT paymentterms.id,paymentterms.PaymentTermName FROM appconsolidates INNER JOIN servicedetails ON appconsolidates.services_id=servicedetails.services_id INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN paymentterms ON servicedetails.paymentterms_id=paymentterms.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY paymentterms.PaymentTermName ASC');
        if($request->ajax()) {
            return view('gym.report.servicebyservice',['compInfo'=>$compInfo,'invtype'=>$invtype,'servicelist'=>$servicelist,'periodlist'=>$periodlist,'grouplist'=>$grouplist,'ptermlist'=>$ptermlist])->renderSections()['content'];
        } 
        else{
            return view('gym.report.servicebyservice',['compInfo'=>$compInfo,'invtype'=>$invtype,'servicelist'=>$servicelist,'periodlist'=>$periodlist,'grouplist'=>$grouplist,'ptermlist'=>$ptermlist]); 
        }
    }

    public function serviceByClientReport(Request $request)
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $invtype=DB::select('SELECT DISTINCT applications.ApplicationType FROM applications WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY applications.ApplicationType ASC');
        $memlist=DB::select('SELECT DISTINCT memberships.id,memberships.Name,memberships.MemberId,memberships.Phone,memberships.Mobile FROM appconsolidates INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY memberships.Name ASC');
        $periodlist=DB::select('SELECT DISTINCT periods.id,periods.PeriodName FROM appconsolidates INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY periods.PeriodName ASC');
        $grouplist=DB::select('SELECT DISTINCT groupmembers.id,groupmembers.GroupName FROM appconsolidates INNER JOIN servicedetails ON appconsolidates.services_id=servicedetails.services_id INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN groupmembers ON servicedetails.groupmembers_id=groupmembers.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY groupmembers.GroupName ASC');
        $ptermlist=DB::select('SELECT DISTINCT paymentterms.id,paymentterms.PaymentTermName FROM appconsolidates INNER JOIN servicedetails ON appconsolidates.services_id=servicedetails.services_id INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN paymentterms ON servicedetails.paymentterms_id=paymentterms.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY paymentterms.PaymentTermName ASC');

        if($request->ajax()) {
            return view('gym.report.servicebyclient',['compInfo'=>$compInfo,'invtype'=>$invtype,'memlist'=>$memlist,'periodlist'=>$periodlist,'grouplist'=>$grouplist,'ptermlist'=>$ptermlist])->renderSections()['content'];
        } 
        else{
            return view('gym.report.servicebyclient',['compInfo'=>$compInfo,'invtype'=>$invtype,'memlist'=>$memlist,'periodlist'=>$periodlist,'grouplist'=>$grouplist,'ptermlist'=>$ptermlist]); 
        }
    }

    public function invoiceDetailReport(Request $request)
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $invtype=DB::select('SELECT DISTINCT applications.ApplicationType FROM applications WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY applications.ApplicationType ASC');
        $servicelist=DB::select('SELECT DISTINCT services.id,services.ServiceName FROM appconsolidates INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY services.ServiceName ASC');
        $periodlist=DB::select('SELECT DISTINCT periods.id,periods.PeriodName FROM appconsolidates INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY periods.PeriodName ASC');
        $grouplist=DB::select('SELECT DISTINCT groupmembers.id,groupmembers.GroupName FROM appconsolidates INNER JOIN servicedetails ON appconsolidates.services_id=servicedetails.services_id INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN groupmembers ON servicedetails.groupmembers_id=groupmembers.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY groupmembers.GroupName ASC');
        $ptermlist=DB::select('SELECT DISTINCT paymentterms.id,paymentterms.PaymentTermName FROM appconsolidates INNER JOIN servicedetails ON appconsolidates.services_id=servicedetails.services_id INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN paymentterms ON servicedetails.paymentterms_id=paymentterms.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY paymentterms.PaymentTermName ASC');
        $invnumberlist=DB::select('SELECT DISTINCT applications.VoucherNumber,applications.InvoiceNumber FROM applications WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY applications.VoucherNumber ASC');

        if($request->ajax()) {
            return view('gym.report.invoicedetail',['compInfo'=>$compInfo,'invtype'=>$invtype,'servicelist'=>$servicelist,'periodlist'=>$periodlist,'grouplist'=>$grouplist,'ptermlist'=>$ptermlist,'invnumberlist'=>$invnumberlist])->renderSections()['content'];
        } 
        else{
            return view('gym.report.invoicedetail',['compInfo'=>$compInfo,'invtype'=>$invtype,'servicelist'=>$servicelist,'periodlist'=>$periodlist,'grouplist'=>$grouplist,'ptermlist'=>$ptermlist,'invnumberlist'=>$invnumberlist]); 
        }
    }

    public function serviceStatusReport(Request $request)
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $invtype=DB::select('SELECT DISTINCT applications.ApplicationType FROM applications WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY applications.ApplicationType ASC');
        $servicelist=DB::select('SELECT DISTINCT services.id,services.ServiceName FROM appconsolidates INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY services.ServiceName ASC');
        $periodlist=DB::select('SELECT DISTINCT periods.id,periods.PeriodName FROM appconsolidates INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY periods.PeriodName ASC');
        $grouplist=DB::select('SELECT DISTINCT groupmembers.id,groupmembers.GroupName FROM appconsolidates INNER JOIN servicedetails ON appconsolidates.services_id=servicedetails.services_id INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN groupmembers ON servicedetails.groupmembers_id=groupmembers.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY groupmembers.GroupName ASC');
        $ptermlist=DB::select('SELECT DISTINCT paymentterms.id,paymentterms.PaymentTermName FROM appconsolidates INNER JOIN servicedetails ON appconsolidates.services_id=servicedetails.services_id INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN paymentterms ON servicedetails.paymentterms_id=paymentterms.id WHERE applications.Status NOT IN("Pending","Void","Refund") ORDER BY paymentterms.PaymentTermName ASC');
        $statuslists=DB::select('SELECT DISTINCT appconsolidates.Status FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id WHERE applications.Status NOT IN("Pending","Void","Refund") AND appconsolidates.Status IN("Active","Frozen","Expired") ORDER BY appconsolidates.Status ASC');

        if($request->ajax()) {
            return view('gym.report.servicestatus',['compInfo'=>$compInfo,'invtype'=>$invtype,'servicelist'=>$servicelist,'periodlist'=>$periodlist,'grouplist'=>$grouplist,'ptermlist'=>$ptermlist,'statuslists'=>$statuslists])->renderSections()['content'];
        } 
        else{
            return view('gym.report.servicestatus',['compInfo'=>$compInfo,'invtype'=>$invtype,'servicelist'=>$servicelist,'periodlist'=>$periodlist,'grouplist'=>$grouplist,'ptermlist'=>$ptermlist,'statuslists'=>$statuslists]); 
        }
    }

    public function generalServiceData($from,$to,$paymentype)
    {
        $query = DB::select('SELECT periods.PeriodName,services.ServiceName,groupmembers.GroupName,applications.PaymentType,paymentterms.PaymentTermName,
            CONCAT(applications.ApplicationType," (",CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(COUNT(DISTINCT(SELECT appservices.applications_id FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(COUNT(DISTINCT(SELECT apptrainers.applications_id FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)),2) 
            END," times)") AS ApplicationType,
            
            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.BeforeTotal FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.BeforeTotal FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS BeforeTax,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
           	ROUND(SUM((SELECT appservices.Tax FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.Tax FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS Tax,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.TotalAmount FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.TotalAmount FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS TotalPrice,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.DiscountServiceAmount FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.DiscountServiceAmount FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS DiscountAmount
            FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN groupmembers ON applications.groupmembers_id=groupmembers.id INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id WHERE applications.InvoiceDate>="'.$from.'" AND applications.InvoiceDate<="'.$to.'" AND applications.PaymentType IN('.$paymentype.') AND applications.Status="Verified" GROUP BY groupmembers.GroupName,paymentterms.PaymentTermName,services.ServiceName,applications.ApplicationType ORDER BY applications.PaymentType ASC,paymentterms.PaymentTermName ASC,services.ServiceName ASC');
        return datatables()->of($query)->toJson();
    }

    public function servicebyServiceData($from,$to,$paymentype,$invtype)
    {
        $servlist=$_POST['servicelist']; 
        $services=implode(',', $servlist);

        $prdlist=$_POST['periodlists']; 
        $periods=implode(',', $prdlist);

        $grplist=$_POST['grouplist']; 
        $groups=implode(',', $grplist);

        $paylist=$_POST['paymenttermlist']; 
        $paymentl=implode(',', $paylist);

        $query = DB::select('SELECT applications.ApplicationType,services.ServiceName,periods.PeriodName,groupmembers.GroupName,applications.PaymentType,paymentterms.PaymentTermName,CONCAT(IFNULL(memberships.Name,"")," , ",IFNULL(memberships.LoyalityStatus," . ")) AS MemberInfo,
            CONCAT(IFNULL(applications.RegistrationDate,"")," to ",IFNULL(applications.ExpiryDate,"")) AS ActiveRange,CONCAT(IFNULL(applications.VoucherNumber,"")," , ",IFNULL(applications.InvoiceNumber,"")) AS InvFsNum,applications.InvoiceDate,       
            
            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.BeforeTotal FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.BeforeTotal FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS BeforeTax,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
           	ROUND(SUM((SELECT appservices.Tax FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.Tax FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS Tax,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.TotalAmount FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.TotalAmount FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS TotalPrice,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.DiscountServiceAmount FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.DiscountServiceAmount FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS DiscountAmount
            FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN groupmembers ON applications.groupmembers_id=groupmembers.id INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE applications.InvoiceDate>="'.$from.'" AND applications.InvoiceDate<="'.$to.'" AND applications.PaymentType IN('.$paymentype.') AND applications.ApplicationType IN('.$invtype.') AND appconsolidates.services_id IN('.$services.') AND appconsolidates.periods_id IN('.$periods.') AND applications.groupmembers_id IN('.$groups.') AND applications.paymentterms_id IN('.$paymentl.') AND applications.Status="Verified" GROUP BY groupmembers.GroupName,paymentterms.PaymentTermName,services.ServiceName,applications.ApplicationType,memberships.Name,appconsolidates.applications_id ORDER BY applications.PaymentType ASC,services.ServiceName ASC,memberships.Name ASC,applications.id DESC');
        return datatables()->of($query)->toJson();
    }

    public function servicebyClientData($from,$to,$paymentype,$invtype)
    {
        $clientlist=$_POST['clientlist']; 
        $clients=implode(',', $clientlist);

        $prdlist=$_POST['periodlists']; 
        $periods=implode(',', $prdlist);

        $grplist=$_POST['grouplist']; 
        $groups=implode(',', $grplist);

        $paylist=$_POST['paymenttermlist']; 
        $paymentl=implode(',', $paylist);

        $query = DB::select('SELECT applications.ApplicationType,services.ServiceName,periods.PeriodName,groupmembers.GroupName,applications.PaymentType,paymentterms.PaymentTermName,CONCAT(IFNULL(memberships.Name,"")," , ",IFNULL(memberships.LoyalityStatus," . ")) AS MemberInfo,
            CONCAT(IFNULL(applications.RegistrationDate,"")," to ",IFNULL(applications.ExpiryDate,"")) AS ActiveRange,CONCAT(IFNULL(applications.VoucherNumber,"")," , ",IFNULL(applications.InvoiceNumber,"")) AS InvFsNum,applications.InvoiceDate,       
            
            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.BeforeTotal FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.BeforeTotal FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS BeforeTax,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
           	ROUND(SUM((SELECT appservices.Tax FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.Tax FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS Tax,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.TotalAmount FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.TotalAmount FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS TotalPrice,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.DiscountServiceAmount FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.DiscountServiceAmount FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS DiscountAmount
            FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN groupmembers ON applications.groupmembers_id=groupmembers.id INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE applications.InvoiceDate>="'.$from.'" AND applications.InvoiceDate<="'.$to.'" AND applications.PaymentType IN('.$paymentype.') AND applications.ApplicationType IN('.$invtype.') AND appconsolidates.memberships_id IN('.$clients.') AND appconsolidates.periods_id IN('.$periods.') AND applications.groupmembers_id IN('.$groups.') AND applications.paymentterms_id IN('.$paymentl.') AND applications.Status="Verified" GROUP BY groupmembers.GroupName,paymentterms.PaymentTermName,services.ServiceName,applications.ApplicationType,memberships.Name,appconsolidates.applications_id ORDER BY applications.PaymentType ASC,services.ServiceName ASC,memberships.Name ASC,applications.id DESC');
        return datatables()->of($query)->toJson();
    }

    public function incomebyInvoiceData($from,$to,$paymentype,$invtype)
    {
        $servlist=$_POST['servicelist']; 
        $services=implode(',', $servlist);

        $prdlist=$_POST['periodlists']; 
        $periods=implode(',', $prdlist);

        $grplist=$_POST['grouplist']; 
        $groups=implode(',', $grplist);

        $paylist=$_POST['paymenttermlist']; 
        $paymentl=implode(',', $paylist);

        $fsnumlist=$_POST['fsinvoicelist']; 
        $fsnum=implode(',', $fsnumlist);

        $query = DB::select('SELECT applications.ApplicationType,applications.Type,groupmembers.GroupName,paymentterms.PaymentTermName,applications.RegistrationDate,applications.ExpiryDate,services.ServiceName,periods.PeriodName,applications.PaymentType,memberships.Name AS MemberInfo,CONCAT("FS/ Doc # : ",IFNULL(applications.VoucherNumber,""),"	,	Invoice/ Ref # :  ",IFNULL(applications.InvoiceNumber,"")," | , Invoice Date : ",IFNULL(applications.InvoiceDate,"")," .") AS InvoiceInfo,
            (SELECT appmembers.LoyalityStatus FROM appmembers WHERE appmembers.applications_id=applications.id AND appmembers.memberships_id=memberships.id) AS LoyaltyStatus,
            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.BeforeTotal FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.BeforeTotal FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS BeforeTax,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
           	ROUND(SUM((SELECT appservices.Tax FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.Tax FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS Tax,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.TotalAmount FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.TotalAmount FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS TotalPrice,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.DiscountServiceAmount FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.DiscountServiceAmount FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS DiscountAmount,

            CASE WHEN applications.ApplicationType!="Trainer-Fee" THEN 
            ROUND(SUM((SELECT appservices.DiscountServicePercent FROM appservices WHERE appservices.applications_id=applications.id AND appservices.services_id=services.id AND appservices.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2)
            WHEN applications.ApplicationType="Trainer-Fee" THEN 
            ROUND(SUM((SELECT apptrainers.DiscountServicePercent FROM apptrainers WHERE apptrainers.applications_id=applications.id AND apptrainers.services_id=services.id AND apptrainers.periods_id=periods.id AND applications.groupmembers_id=groupmembers.id)/groupmembers.GroupSize),2) 
            END AS DiscountPercent

            FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN groupmembers ON applications.groupmembers_id=groupmembers.id INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id WHERE applications.InvoiceDate>="'.$from.'" AND applications.InvoiceDate<="'.$to.'" AND applications.PaymentType IN('.$paymentype.') AND applications.ApplicationType IN('.$invtype.') AND appconsolidates.services_id IN('.$services.') AND appconsolidates.periods_id IN('.$periods.') AND applications.groupmembers_id IN('.$groups.') AND applications.paymentterms_id IN('.$paymentl.') AND applications.VoucherNumber IN('.$fsnum.') AND applications.Status="Verified" GROUP BY appconsolidates.id ORDER BY applications.PaymentType ASC,applications.VoucherNumber ASC');
        return datatables()->of($query)->toJson();
    }

    public function serviceStatusData($from,$to,$serstatus,$invtype)
    {
        $curdate=Carbon::today()->toDateString();
        $datetorep=null;

        $servlist=$_POST['servicelist']; 
        $services=implode(',', $servlist);

        $prdlist=$_POST['periodlists']; 
        $periods=implode(',', $prdlist);

        $grplist=$_POST['grouplist']; 
        $groups=implode(',', $grplist);

        $paylist=$_POST['paymenttermlist']; 
        $paymentl=implode(',', $paylist);

        if($to<$curdate){
            $datetorep=$to;
        }
        if($to>=$curdate){
            $dateto = Carbon::parse($to);
            $datetorep=$dateto->addYears(10)->format('Y-m-d');
        }

        $query = DB::select('SELECT applications.ApplicationType,CONCAT(IFNULL(applications.VoucherNumber,"")," , ",IFNULL(applications.InvoiceNumber,"")) AS FsInvNumber,groupmembers.GroupName,memberships.Name,CONCAT(IFNULL(memberships.Mobile,"")," , ",IFNULL(memberships.Phone,"")) AS MemberPhone,services.ServiceName,periods.PeriodName,paymentterms.PaymentTermName,appconsolidates.RegistrationDate,appconsolidates.ExpiryDate,appconsolidates.Status,memberships.LoyalityStatus FROM appconsolidates INNER JOIN applications ON appconsolidates.applications_id=applications.id INNER JOIN memberships ON appconsolidates.memberships_id=memberships.id INNER JOIN services ON appconsolidates.services_id=services.id INNER JOIN periods ON appconsolidates.periods_id=periods.id INNER JOIN paymentterms ON applications.paymentterms_id=paymentterms.id INNER JOIN groupmembers ON applications.groupmembers_id=groupmembers.id WHERE appconsolidates.ExpiryDate>="'.$from.'" AND appconsolidates.ExpiryDate<="'.$datetorep.'" AND appconsolidates.Status IN('.$serstatus.') AND appconsolidates.periods_id IN('.$periods.') AND appconsolidates.services_id IN('.$services.') AND applications.groupmembers_id IN('.$groups.') AND applications.paymentterms_id IN('.$paymentl.') AND applications.Status="Verified" ORDER BY appconsolidates.Status ASC,services.ServiceName ASC,memberships.Name ASC');
        return datatables()->of($query)->toJson();
    }

    public function index()
    {
        //
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
