<?php
namespace App\Reports;
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\DateTimeFormat;
use koolreport\KoolReport;
use \koolreport\processes\CalculatedColumn;
use \koolreport\processes\ColumnMeta;


class StoreBalanceReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\bootstrap4\Theme;
   
    function setup () 
    {
        $from = $this->params["from"];
        $to = $this->params["to"];
        $storeval=$this->params["storeval"];
        $items=$this->params["items"];
        $fiscalyear=$this->params["fiscalyear"];
        
        $this->src("mysql") // use any of your preferred connection type in config/database.php
        ->query("SELECT regitems.id as id,regitems.Code as ItemCode, regitems.Name as ItemName,regitems.SKUNumber AS SKUNumber,categories.Name as Category, uoms.Name as UOM,stores.Name as StoreName,regitems.RetailerPrice as RetailerPrice,regitems.WholesellerPrice as Wholeseller,(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity FROM transactions inner join regitems on transactions.ItemId=regitems.Id inner join categories on regitems.CategoryId=categories.id inner join uoms on regitems.MeasurementId=uoms.id inner join stores on transactions.StoreId=stores.id where transactions.FiscalYear=($fiscalyear) AND DATE(transactions.Date)>= '".$from."' AND DATE(transactions.Date)<='".$to."' AND transactions.StoreId IN($storeval) AND transactions.ItemId IN($items) group by regitems.Code,regitems.Name,regitems.SKUNumber,categories.Name,uoms.Name,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.id,stores.Name order by regitems.Name asc") 
        ->pipe($this->dataStore("balancesql"));  
    }
}
