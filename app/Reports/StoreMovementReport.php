<?php
namespace App\Reports;
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\DateTimeFormat;
use koolreport\KoolReport;
use \koolreport\processes\CalculatedColumn;
use \koolreport\processes\ColumnMeta;


class StoreMovementReport extends \koolreport\KoolReport
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
        $trtype=$this->params["trtype"];
        $fp="";
        $sp="";
        if($trtype=="1")
        {
            $fp="0";
            $sp="2";
        }
        else if($trtype=="2")
        {
            $fp="2";
            $sp="100000000000000";
        }
        else if($trtype=="1,2")
        {
            $fp="0";
            $sp="100000000000000";
        
        }
        $this->src("mysql") // use any of your preferred connection type in config/database.php
        ->query("SELECT transactions.id,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,uoms.Name AS UOM,transactions.StockIn,transactions.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY transactions.ItemId,transactions.StoreId ORDER BY transactions.id ASC)) AS AvailableQuantity,(COALESCE(transactions.StockIn,0)-COALESCE(transactions.StockOut,0)) AS TotalQuantity,transactions.TransactionsType,transactions.DocumentNumber,DATE(transactions.Date) AS Date FROM transactions INNER JOIN regitems ON transactions.ItemId=regitems.id INNER JOIN stores ON transactions.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE transactions.ItemId IN($items) AND transactions.StoreId IN($storeval) AND transactions.FiscalYear=($fiscalyear) AND DATE(transactions.Date)>= '".$from."' AND DATE(transactions.Date)<='".$to."' AND (SELECT COUNT(ItemId) FROM transactions WHERE transactions.StoreId=$storeval AND transactions.ItemId=regitems.id)>=$fp AND (SELECT COUNT(ItemId) FROM transactions WHERE transactions.StoreId=$storeval AND transactions.ItemId=regitems.id)<$sp ORDER BY transactions.id ASC") 
        ->pipe($this->dataStore("movementsql"));  
    }
}
