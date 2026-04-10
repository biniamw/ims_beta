<?php
namespace App\Reports;
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\DateTimeFormat;
use koolreport\KoolReport;


class SettlementRep extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\bootstrap4\Theme;

    function setup () 
    {  
        $id = $this->params["id"];
        $this->src('mysql')  // use any of your preferred connection type in config/database.php
        ->query('SELECT settlementdetails.id,sales.VoucherNumber AS FSNumber,IFNULL(sales.invoiceNo,"") AS InvoiceNumber,DATEDIFF(sales.settlementexpiredate,settlements.DocumentDate) AS RemainingDate,
            settlementdetails.PaymentType,IFNULL(settlementdetails.ChequeNumber,"") AS ChequeNumber,IFNULL(settlementdetails.BankTransferNumber,"") AS BankTransferNumber,banks.BankName,bankdetails.AccountNumber,settlementdetails.SettlementAmount,CASE WHEN settlementdetails.SettlementStatus=0 THEN "Not-Paid" WHEN settlementdetails.SettlementStatus=1 THEN "Partially-Paid" WHEN settlementdetails.SettlementStatus=2 THEN "Fully-Paid" END AS SettStatus,settlementdetails.SettlementStatus,"0" AS GroupFlag,
            @witholdamount:=0,
            @vatamount:=0,
            @outstanding:=0,
            @vatsett:=sales.VatSetle,
            @withsett:=sales.WitholdSetle,
            IF(@withsett=1,@witholdamount:=sales.WitholdAmount,@witholdamount:=0),
            IF(@vatsett=1,@vatamount:=sales.Vat,@vatamount:=0),
            @crssales:=(sales.GrandTotal-@witholdamount-@vatamount) AS CreditSales,
            @settledamount:=(SELECT SUM(settlementdetails.SettlementAmount) FROM settlementdetails INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id WHERE settlementdetails.sales_id=sales.id AND settlements.IsVoid=0 AND settlements.Status=3) AS SettledAmounts,if(@settledamount is null,@crssales,@crssales-@settledamount) AS OustandingBalance,@outstanding:=@crssales-@settledamount,sales.Status,CASE WHEN @settledamount is null OR @settledamount=0 THEN "Not-Settled" WHEN @settledamount>0 AND @outstanding!=0 THEN "Partially-Settled" WHEN @settledamount>0 AND @outstanding=0 THEN "Settled" END AS InvoicePaymentStatus
            FROM settlementdetails INNER JOIN sales ON settlementdetails.sales_id=sales.id INNER JOIN settlements ON settlementdetails.settlements_id=settlements.id INNER JOIN banks ON settlementdetails.banks_id=banks.id INNER JOIN bankdetails ON settlementdetails.bankdetails_id=bankdetails.id WHERE settlementdetails.settlements_id='.$id.' ORDER BY settlementdetails.id ASC')
        ->pipe($this->dataStore('settlementsrc'));
    }
}