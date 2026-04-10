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
            "dataSource"=>$this->dataStore('purchasebyitem'),
            "showFooter"=>false,
            "grouping"=>array(
                "Status"=>array( 
                    "calculate"=>array(
                        "{sumAmount}"=>array("sum","BeforeTaxCost"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalCost")
                    ),
                    "bottom"=>"<td colspan=7 style='background:#ccc;text-align:right;'><b>Grand Total</b></td><td style='background:#ccc; text-align:center;'><b>{sumAmount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtax}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtotalprice}</b></td>",
                ),
                "PaymentType"=>array( 
                    "calculate"=>array(
                        "{sumAmount}"=>array("sum","BeforeTaxCost"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalCost")
                    ),
                    "top"=>"<td colspan=10 style='text-align:center;font-size:30px;'><b>{PaymentType} Purchase</b></td>",
                    "bottom"=>"<td colspan=7 style='background:#ccc;text-align:right;'><b>Total of {PaymentType} Purchase</b></td><td style='background:#ccc; text-align:center;'><b>{sumAmount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtax}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtotalprice}</b></td>",
                ),
                "Supplier"=>array( 
                    "calculate"=>array(
                        "{sumAmount}"=>array("sum","BeforeTaxCost"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalCost")
                    ),
                    "top"=>"<b style='text-align:center;'>Supplier : {Supplier}</b>",
                    "bottom"=>"<td colspan=7 style='background:#ccc;text-align:right;'><b>Total of {Supplier}</b></td><td style='background:#ccc; text-align:center;'><b>{sumAmount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtax}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtotalprice}</b></td>",
                ),
                "Name"=>array(),
            ),

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
                "PaymentType"=>array(
                    "label"=>"Payment Type",
                    "cssStyle"=>"text-align:center"
                ),
                "UOM"=>array(
                    "label"=>"UOM",
                    "cssStyle"=>"text-align:center"
                ),
                "StoreName"=>array(
                    "label"=>"Store",
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
                "BeforeTaxCost"=>array(
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
                    "cssStyle"=>"text-align:center",
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
       
     
    </style>
    

    </body>


</html>