<?php
namespace App\Reports;
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\DateTimeFormat;
use koolreport\KoolReport;
use \koolreport\processes\CalculatedColumn;
use \koolreport\processes\ColumnMeta;


class WitholdReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\bootstrap4\Theme;
   
    function setup () 
    {
        $customer=$this->params['customer'];
        $from = $this->params["from"];
        $to = $this->params["to"];
        $store=$this->params["store"];
        $paymentype=$this->params["paymentype"];
        $status=$this->params["status"];

        $this->src("mysql") // use any of your preferred connection type in config/database.php
        ->query("SELECT sales.id,customers.Code AS CustomerCode,customers.Name AS CustomerName,customers.TinNumber AS TIN,sales.PaymentType,stores.Name as StoreName,sales.VoucherNumber,sales.WitholdAmount,COALESCE(sales.witholdNumber,'-')AS witholdNumber,sales.Vat,COALESCE(sales.vatNumber,'-') AS vatNumber,sales.WitholdSetle,IF(WitholdSetle>0,'Settled','Not Settled') AS SettlementStatus,sales.SubTotal,sales.Tax,sales.GrandTotal,sales.NetPay,sales.CreatedDate,sales.Status FROM sales INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id where DATE(sales.CreatedDate)>= '".$from."' AND DATE(sales.CreatedDate)<='".$to."' AND sales.StoreId IN($store) AND sales.PaymentType IN($paymentype) AND sales.CustomerId IN($customer) AND sales.Status='Confirmed' AND (sales.WitholdAmount>0 OR sales.Vat>0) AND sales.WitholdSetle IN($status) GROUP BY sales.id,sales.PaymentType,customers.Name,stores.Name,sales.witholdNumber,sales.vatNumber,sales.VoucherNumber,sales.witholdNumber,sales.WitholdAmount,sales.Vat,sales.vatNumber,sales.WitholdSetle,sales.SubTotal,sales.Tax,sales.GrandTotal,sales.NetPay,customers.Code,customers.Name,customers.TinNumber,sales.CreatedDate,sales.Status ORDER BY customers.Name ASC") 
        ->pipe($this->dataStore("witholdSrc"));  
    }
}
