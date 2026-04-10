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

<style>
    
</style>

    </head>
    <body>
      
        <?php
           Table::create(array(
            "dataSource"=>$this->dataStore('purchasedetailsrc'),
            "excludedColumns"=>array("Code"),
            "grouping"=>array(
                "Status"=>array( 
                    "calculate"=>array(
                        "{sumSubTotal}"=>array("sum","SubTotal"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalCost"),
                    ),
                    "bottom"=>"<td colspan=4 style='background:#F8F8FF;text-align:right;'><b>Grand Total</b></td><td style='background:#F8F8FF;text-align:center;'>{sumSubTotal}</td><td style='background:#F8F8FF;text-align:center;'>{sumtax}</td><td style='background:#F8F8FF;text-align:center;'>{sumtotalprice}</td>",
                ),
                "PaymentType"=>array( 
                    "calculate"=>array(
                        "{sumSubTotal}"=>array("sum","SubTotal"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalCost"),
                    ),
                    "top"=>"<td colspan=7 style='text-align:center;font-size:20px;'><b>{PaymentType} Purchase</b></td>",
                    "bottom"=>"<td colspan=4 style='background:#F8F8FF;text-align:right;'><b>Total {PaymentType} Purchase</b></td><td style='background:#F8F8FF;text-align:center;'>{sumSubTotal}</td><td style='background:#F8F8FF;text-align:center;'>{sumtax}</td><td style='background:#F8F8FF;text-align:center;'>{sumtotalprice}</td>",
                ),
                "CustomerName"=>array(),
                "VoucherNumber"=>array(),
                "CustomerInfo"=>array( 
                    "calculate"=>array(
                        "{sumSubTotal}"=>array("sum","SubTotal"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalCost"),
                    ),
                    "top"=>"<p style='text-align:center;'>{CustomerInfo}</p>",
                    "bottom"=>"<td colspan=4 style='background:#F8F8FF;text-align:right;'><b>Total of {CustomerName} ({VoucherNumber})</b></td><td style='background:#F8F8FF;text-align:center;'>{sumSubTotal}</td><td style='background:#F8F8FF;text-align:center;'>{sumtax}</td><td style='background:#F8F8FF;text-align:center;'>{sumtotalprice}</td>",
                ),
                "Name"=>array(),
            ),
            "showFooter"=>false,      
            "columns"=>array(
                "Code"=>array(
                    "label"=>"Item Code",
                    "cssStyle"=>"text-align:center",
                     "footerText"=>"<b>Grand Total</b>",
                ),
                "Name"=>array(
                    "label"=>"Item Name",
                    "cssStyle"=>"text-align:center"
                ),
                "UOM"=>array(
                    "label"=>"UOM",
                    "cssStyle"=>"text-align:center"
                ),
                "Quantity"=>array(
                    "label"=>"Quantity",
                    "cssStyle"=>"text-align:center"
                ),
                "UnitCost"=>array(
                    "label"=>"Unit Cost",
                    "cssStyle"=>"text-align:center",
                    "decimals"=>2,
                ),
                "SubTotal"=>array(
                    "label"=>"Sub Total",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "cssStyle"=>"text-align:center",
                    "footerText"=>"<b>@value</b>"
                ),
                "Tax"=>array(
                    "label"=>"Tax",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "cssStyle"=>"text-align:center",
                    "footerText"=>"<b>@value</b>",
                ),
                "TotalCost"=>array(
                    "label"=>"Total Cost",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "cssStyle"=>"text-align:center;",
                    "footerText"=>"<b>@value</b>"
                ),
            ),
            "cssClass"=>array(
                "table"=>"table table-hover table-bordered table-striped",
                "tf"=>"darker", 
            ),
            "removeDuplicate"=>array("Name")
            ));
        ?>
       
      <style>
        .darker
        {
            background:#ccc;
        }
        .cssItem
        {
            background-color:#fdffe8;
        }
    </style>
    </body>


</html>