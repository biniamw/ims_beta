<?php
namespace App\Reports;
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\DateTimeFormat;
use koolreport\KoolReport;
// use koolreport\export\Exportable;
// use koolreport\laravel\Friendship;


class salesbyCustomer extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\bootstrap4\Theme;
    //use \koolreport\cloudexport\Exportable;
    
    //use Friendship, Exportable;
    
    

    function setup () {
        
        //SELECT categories.Name AS Category,regitems.Name,SUM(salesitems.Quantity) AS Quantity,TRUNCATE(SUM(salesitems.BeforeTaxPrice),2) AS SubTotal,TRUNCATE(SUM(salesitems.TaxAmount),2) AS Tax,TRUNCATE(SUM(salesitems.TotalPrice),2) AS TotalPrice FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN sales ON salesitems.HeaderId=sales.id where sales.CreatedDate between "'.$from.'" AND "'.$to.'" AND sales.StoreId IN('.$store.') AND sales.PaymentType IN('.$paymentype.') AND regitems.itemGroup IN('.$itemgroup.') GROUP BY salesitems.ItemId,categories.Name,regitems.Name ORDER BY categories.Name ASC
       $customer=$this->params['customer'];
        $from = $this->params["from"];
        $to = $this->params["to"];
        $store=$this->params["store"];
        $paymentype=$this->params["paymentype"];
        $itemgroup=$this->params["itemgroup"];
        $this->src('mysql')  // use any of your preferred connection type in config/database.php
        ->query('SELECT customers.Name AS CustomerName,stores.Name as StoreName,categories.Name AS Category,regitems.Name,regitems.Code,regitems.SKUNumber,sales.PaymentType,uoms.Name AS UOM,SUM(salesitems.Quantity) AS Quantity,salesitems.UnitPrice,salesitems.DiscountAmount AS Discount,TRUNCATE(SUM(salesitems.BeforeTaxPrice),2) AS SubTotal,TRUNCATE(SUM(salesitems.TaxAmount),2) AS Tax,TRUNCATE(SUM(salesitems.TotalPrice),2) AS TotalPrice,sales.Status FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON salesitems.NewUOMId=uoms.id INNER JOIN sales ON salesitems.HeaderId=sales.id INNER JOIN customers ON sales.CustomerId=customers.id INNER JOIN stores ON sales.StoreId=stores.id  where DATE(sales.CreatedDate)>= "'.$from.'" AND DATE(sales.CreatedDate)<="'.$to.'" AND sales.StoreId IN('.$store.') AND sales.PaymentType IN('.$paymentype.') AND regitems.itemGroup IN('.$itemgroup.') AND sales.CustomerId IN('.$customer.') AND sales.Status="Confirmed" GROUP BY salesitems.ItemId,categories.Name,regitems.Name,regitems.Code,regitems.SKUNumber,uoms.Name,salesitems.UnitPrice,salesitems.DiscountAmount,sales.PaymentType,customers.Name,stores.Name,sales.Status ORDER BY categories.Name ASC')
        ->pipe(new Sort(array(
            "TotalPrice"=>"desc"
        )))
        ->pipe($this->dataStore('sales_by_customer'));

        $this->src('mysql')  // use any of your preferred connection type in config/database.php
        ->query('SELECT TRUNCATE(SUM(sales.WitholdAmount),2) AS Withold,TRUNCATE(SUM(sales.Vat),2) AS Vat,TRUNCATE(SUM(sales.SubTotal),2) AS SubTotal,TRUNCATE(SUM(sales.Tax),2) AS Tax,TRUNCATE(SUM(sales.GrandTotal),2) AS TotalPrice,TRUNCATE(SUM(sales.GrandTotal)-SUM(sales.WitholdAmount)-SUM(sales.Vat),2) AS NetPay FROM sales where DATE(sales.CreatedDate)>= "'.$from.'" AND DATE(sales.CreatedDate)<="'.$to.'" AND sales.StoreId IN('.$store.') AND sales.PaymentType IN('.$paymentype.') AND sales.CustomerId IN('.$customer.') AND sales.Status="Confirmed" AND sales.id in(SELECT headerid FROM salesitems WHERE itemid IN(SELECT id FROM regitems WHERE itemGroup IN('.$itemgroup.')))')
        ->pipe($this->dataStore('datasrc_2'));
    }

}