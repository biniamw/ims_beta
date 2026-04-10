<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\google\GeoChart;
use \koolreport\widgets\google\PieChart;
use \koolreport\inputs\DateRangePicker;
use \koolreport\widgets\google\DonutChart;
use \koolreport\widgets\google\LineChart;

?>
<html>
    <head>
    <title></title>
    </head>
    <body>
        <?php
        Table::create([ 
            "dataSource"=>$this->dataStore("movementsql"),
            "showFooter"=>false,
            "excludedColumns"=>array("SKUNumber"),
            "sorting"=>array(
                "id"=>"asc"
            ),
            "grouping"=>array(
                "ItemName"=>array( 
                    "calculate"=>array(
                        "{total}"=>array("sum","TotalQuantity"),
                    ),
                    "top"=>"<td style='text-align:left;background-color:#DCDCDC;' colspan=11><b style='text-align:left;margin-left:500px;'>Item Name :   {ItemName}</b></td>",
                    "bottom"=>"<td style='text-align:right;background-color:#F5F5F5;height:10%;' colspan=11><b style='text-align:right;'>Total Of {ItemName}  :   {total}</b></td>",
                ),
                "StoreName"=>array(
                    "top"=>"<td style='text-align:left;background-color:#F5F5F5;' colspan=11><b style='text-align:left;margin-left:500px;'>Store Name :   {StoreName}</b></td>", 
                ),
            ),
            "columns"=>array(
                "ItemCode"=>array(
                    "label"=>"Item Code",
                    "cssStyle"=>"text-align:center;",
                ),
                "ItemName"=>array(
                    "label"=>"Item Name",
                    "cssStyle"=>"width:15%;text-align:center",
                ),
                "SKUNumber"=>array(
                    "label"=>"SKU Number",
                    "cssStyle"=>"text-align:center",
                ),
                "StoreName"=>array(
                    "label"=>"Store Name",
                    "cssStyle"=>"text-align:center",
                ),
                "UOM"=>array(
                    "label"=>"UOM",
                    "cssStyle"=>"text-align:center",
                ),
                "StockIn"=>array(
                    "label"=>"Stock In",
                    "cssStyle"=>"text-align:center",
                ),
                "StockOut"=>array(
                    "label"=>"Stock Out",
                    "cssStyle"=>"text-align:center",
                ),
                
                "AvailableQuantity"=>array(
                    "label"=>"Running Quantity",
                    "cssStyle"=>"text-align:center",
                ),
                
                "TransactionsType"=>array(
                    "label"=>"Transaction Type",
                    "cssStyle"=>"text-align:center",
                ),
                "DocumentNumber"=>array(
                      "formatValue"=>function($DocumentNumber,$TransactionsType)
				            {
				                return "<a target='_parent' href='{{ route('sales') }}'>$DocumentNumber</a>";
				            },
                    "label"=>"Reference",
                    "cssStyle"=>"text-align:center",
                ),
                "Date"=>array(
                    "label"=>"Date",
                    "cssStyle"=>"text-align:center",
                ),
            ),
        ]);
        ?>
    </body>
</html>
