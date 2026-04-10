<?php
namespace App\Reports;
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\DateTimeFormat;
use koolreport\KoolReport;


class PurchaseReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\bootstrap4\Theme;

    function setup () 
    {  
        $from = $this->params["from"];
        $to = $this->params["to"];
        $store=$this->params["store"];
        $paymentype=$this->params["paymentype"];
        $this->src('mysql')  // use any of your preferred connection type in config/database.php
        ->query('SELECT categories.Name AS Category,stores.Name as StoreName,regitems.Name,regitems.Code,regitems.SKUNumber,receivings.PaymentType,uoms.Name AS UOM,SUM(receivingdetails.Quantity) AS Quantity,receivingdetails.UnitCost,TRUNCATE(SUM(receivingdetails.BeforeTaxCost),2) AS BeforeTaxCost,TRUNCATE(SUM(receivingdetails.TaxAmount),2) AS Tax,TRUNCATE(SUM(receivingdetails.TotalCost),2) AS TotalCost,receivings.Status FROM receivingdetails INNER JOIN regitems ON receivingdetails.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN uoms ON receivingdetails.NewUOMId=uoms.id INNER JOIN receivings ON receivingdetails.HeaderId=receivings.id INNER JOIN stores ON receivings.StoreId=stores.id where DATE(receivings.TransactionDate)>= "'.$from.'" AND DATE(receivings.TransactionDate)<="'.$to.'" AND receivings.StoreId IN('.$store.') AND receivings.PaymentType IN('.$paymentype.') AND receivings.Status="Confirmed" GROUP BY receivingdetails.ItemId,categories.Name,regitems.Name,regitems.Code,regitems.SKUNumber,uoms.Name,receivingdetails.UnitCost,receivings.PaymentType,stores.Name,receivings.Status ORDER BY categories.Name ASC')
        ->pipe(new Sort(array(
            "TotalPrice"=>"desc"
        )))
        ->pipe($this->dataStore('generalPurchase'));
    }
}