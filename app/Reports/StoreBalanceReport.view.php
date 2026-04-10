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
            "dataSource"=>$this->dataStore("balancesql"),
            "showFooter"=>false,
            "excludedColumns"=>array("SKUNumber"),
            "grouping"=>array(
                "ItemName"=>array( 
                    "calculate"=>array(
                        "{AvQuantity}"=>array("sum","AvailableQuantity"),
                    ),
                    "top"=>"<td colspan=8 style='text-align:center;'><b>Item Name : {ItemName}</b></td>",
                    "bottom"=>"<td colspan=7 style='background:#ccc;text-align:right;'><b>Total of {ItemName}</b></td><td style='background:#ccc; text-align:center;'><b>{AvQuantity}</b></td>",
                    
                ),
                "StoreName"=>array(
                    
                ),
             ), 
            "sorting"=>array(
                "ItemName"=>"asc"
            ),
           
            "columns"=>array(
                "ItemCode"=>array(
                    "label"=>"Item Code",
                    "cssStyle"=>"text-align:center",
                ),
                "ItemName"=>array(
                    "label"=>"Item Name",
                    "cssStyle"=>"width:15%;text-align:center",
                ),
                "SKUNumber"=>array(
                    "label"=>"SKU Number",
                    "cssStyle"=>"text-align:center",
                ),
                "Category"=>array(
                    "label"=>"Category",
                    "cssStyle"=>"text-align:center",
                ),
                "UOM"=>array(
                    "label"=>"UOM",
                    "cssStyle"=>"text-align:center",
                ),
                "StoreName"=>array(
                    "label"=>"Store Name",
                    "cssStyle"=>"text-align:center",
                ),
                "RetailerPrice"=>array(
                    "label"=>"Retailer Price",
                    "cssStyle"=>"text-align:center",
                    "decimals"=>2,
                ),
                "Wholeseller"=>array(
                    "label"=>"Wholeseller",
                    "cssStyle"=>"text-align:center",
                    "decimals"=>2,
                ),
                
                "AvailableQuantity"=>array(
                    "label"=>"Available Quantity",
                    "cssStyle"=>"text-align:center",
                    "decimals"=>2,
                ),
            ),
        ]);
        ?>
    </body>
</html>
