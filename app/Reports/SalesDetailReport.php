<?php
namespace App\Reports;
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\DateTimeFormat;
use koolreport\KoolReport;


class SalesDetailReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\bootstrap4\Theme;

    function setup () 
    {   
        $from = $this->params["from"];
        $to = $this->params["to"];
        $store=$this->params["store"];
        $paymentype=$this->params["paymentype"];
        $customer=$this->params["customer"];
        $this->src('mysql')  // use any of your preferred connection type in config/database.php
        ->query('SELECT CONCAT("Customer Info : <b>",customers.Code,"   |   ",customers.Name,"  |   ",customers.TinNumber,"</b><br> Payment Type : <b>",sales.PaymentType,"</b><br> Voucher Number : <b>",sales.VoucherNumber,"</b><br> Point of Sales : <b>",stores.Name,"</b>","<br> Withold Status : <b>",CASE WHEN sales.WitholdSetle="1" THEN "Settled" WHEN sales.WitholdSetle="0" THEN "Not Settled" WHEN sales.WitholdSetle="" THEN "-" END,"</b>","<br> Withold Number : <b>",CASE WHEN sales.witholdNumber IS NULL THEN "-" END,"</b>","<br> VAT Number : <b>",CASE WHEN sales.vatNumber IS NULL THEN "-" END,"</b>") AS CustomerInfo,customers.Name AS CustomerName,categories.Name AS Category,stores.Name as StoreName,regitems.Name,regitems.Code,regitems.SKUNumber,sales.PaymentType,uoms.Name AS UOM,sales.WitholdSetle,sales.VoucherNumber,salesitems.Quantity,COALESCE(salesitems.Dprice,"-") AS DefaultPrice,((sales.WitholdAmount)/(SELECT COUNT(ItemId) FROM salesitems WHERE salesitems.HeaderId=sales.id)) AS WitholdAmount,((sales.Vat)/(SELECT COUNT(ItemId) FROM salesitems WHERE salesitems.HeaderId=sales.id)) AS VAT,(((sales.GrandTotal)-(sales.WitholdAmount)-(sales.Vat))/(SELECT COUNT(ItemId) FROM salesitems WHERE salesitems.HeaderId=sales.id)) AS NetPay,salesitems.UnitPrice,salesitems.DiscountAmount AS Discount,TRUNCATE(SUM(salesitems.BeforeTaxPrice),2) AS SubTotal,TRUNCATE(SUM(salesitems.TaxAmount),2) AS Tax,TRUNCATE(SUM(salesitems.TotalPrice),2) AS TotalPrice,sales.Status FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON salesitems.NewUOMId=uoms.id INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN stores ON sales.StoreId=stores.id INNER JOIN customers ON sales.CustomerId=customers.id where sales.CreatedDate between "'.$from.'" AND "'.$to.'" AND sales.StoreId IN('.$store.') AND sales.PaymentType IN('.$paymentype.') AND sales.CustomerId IN('.$customer.') AND sales.Status="Confirmed" GROUP BY salesitems.ItemId,categories.Name,regitems.Name,regitems.Code,regitems.SKUNumber,uoms.Name,salesitems.UnitPrice,salesitems.DiscountAmount,sales.PaymentType,stores.Name,sales.VoucherNumber,salesitems.Quantity,customers.Code,customers.Name,customers.TinNumber,sales.WitholdSetle,salesitems.Dprice,sales.WitholdAmount,sales.Vat,sales.NetPay,sales.id,sales.GrandTotal,sales.Status,sales.witholdNumber,sales.vatNumber ORDER BY categories.Name ASC')
        ->pipe(new Sort(array(
            "TotalPrice"=>"desc"
        )))
        ->pipe($this->dataStore('sales_by_item'));
    }
}