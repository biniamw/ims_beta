<?php
namespace App\Reports;
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\DateTimeFormat;
use koolreport\KoolReport;
// use koolreport\export\Exportable;
// use koolreport\laravel\Friendship;


class MyReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\bootstrap4\Theme;
    
    
    //use Friendship, Exportable;
    
    

    function setup () {
        // Let say, you have "sale_database" is defined in Laravel's database settings.
        // Now you can use that database without any futher setitngs.

        $this->src('mysql')  // use any of your preferred connection type in config/database.php
        ->query("SELECT sales.id,customers.Name,sales.GrandTotal,sales.SubTotal,sales.Tax FROM sales INNER JOIN customers ON sales.CustomerId=customers.id ")
        ->pipe(new Group(array(
            "by"=>"Name",
             "sum"=>"GrandTotal",
            
        )))
        ->pipe(new Sort(array(
            "GrandTotal"=>"desc"
        )))
        
        // ->pipe(new Limit(array(10)))
        ->pipe($this->dataStore('sales_by_customer'));

        $this->src('mysql')  // use any of your preferred connection type in config/database.php
        ->query("SELECT categories.Name AS Category,regitems.Name,SUM(salesitems.Quantity) AS Quantity,TRUNCATE(SUM(salesitems.BeforeTaxPrice),2) AS SubTotal,TRUNCATE(SUM(salesitems.TaxAmount),2) AS Tax,TRUNCATE(SUM(salesitems.TotalPrice),2) AS TotalPrice FROM salesitems INNER JOIN regitems ON salesitems.ItemId=regitems.id INNER JOIN categories ON regitems.CategoryId=categories.id INNER JOIN sales ON salesitems.HeaderId=sales.id GROUP BY salesitems.ItemId,categories.Name,regitems.Name")
        // ->pipe(new Group(array(
        //     "by"=>"Category",
        //     "sum"=>"SubTotal",
        //     "sum"=>"Tax",
        //     "sum"=>"TotalPrice"

        // )))
        ->pipe(new Sort(array(
            "TotalPrice"=>"desc"
        )))
        
        // ->pipe(new Limit(array(10)))
        ->pipe($this->dataStore('sales_by_item'));
    }

}