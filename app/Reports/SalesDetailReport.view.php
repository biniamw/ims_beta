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
            "dataSource"=>$this->dataStore('sales_by_item'),
            "excludedColumns"=>array("WitholdAmount","VAT","NetPay"),
            "grouping"=>array(
                "Status"=>array( 
                    "calculate"=>array(
                        "{sumDiscount}"=>array("sum","Discount"),
                        "{sumSubTotal}"=>array("sum","SubTotal"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalPrice"),
                        "{withAvg}"=>array("sum","WitholdAmount"),
                        "{withVAT}"=>array("sum","VAT"),
                        "{withNetPay}"=>array("sum","NetPay"),
                    ),
                    "bottom"=>"<td colspan=6 style='background:#F8F8FF;text-align:right;'><b>Grand Total</b></td><td colspan=2 style='background:#F8F8FF;text-align:right;'><span>Discount : <br>Sub Total : <br>Tax : <br>Total Price : <br>Withold : <br>VAT : <br>Net Pay : </span></td><td colspan=2 style='background:#F8F8FF;text-align:left;'><span><b>{sumDiscount}<br>{sumSubTotal}<br>{sumtax}<br>{sumtotalprice}<br>{withAvg}<br>{withVAT}<br>{withNetPay}</b><br></span></td>",
                ),
                "PaymentType"=>array( 
                    "calculate"=>array(
                        "{sumDiscount}"=>array("sum","Discount"),
                        "{sumSubTotal}"=>array("sum","SubTotal"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalPrice"),
                        "{withAvg}"=>array("sum","WitholdAmount"),
                        "{withVAT}"=>array("sum","VAT"),
                        "{withNetPay}"=>array("sum","NetPay"),
                    ),
                    "top"=>"<td colspan=10 style='text-align:center;font-size:30px;'><b>{PaymentType} Sales</b></td>",
                    //"bottom"=>"<td colspan=6 style='background:#ccc;text-align:right;'><b>Total {PaymentType} Sales</b></td><td style='background:#ccc; text-align:center;'><b>{sumDiscount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumSubTotal}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtax}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtotalprice}</b></td>",
                    "bottom"=>"<td colspan=6 style='background:#F5F5F5;text-align:right;'><b>Total {PaymentType} Sales</b></td><td colspan=2 style='background:#F5F5F5;text-align:right;'><span>Discount : <br>Sub Total : <br>Tax : <br>Total Price : <br>Withold : <br>VAT : <br>Net Pay : </span></td><td colspan=2 style='background:#F5F5F5;text-align:left;'><span><b>{sumDiscount}<br>{sumSubTotal}<br>{sumtax}<br>{sumtotalprice}<br>{withAvg}<br>{withVAT}<br>{withNetPay}</b><br></span></td>",
                ),
                "CustomerName"=>array(),
                "VoucherNumber"=>array(),
                "CustomerInfo"=>array( 
                    "calculate"=>array(
                        "{sumDiscount}"=>array("sum","Discount"),
                        "{sumAmount}"=>array("sum","SubTotal"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalPrice"),
                        "{withAvg}"=>array("sum","WitholdAmount"),
                        "{withVAT}"=>array("sum","VAT"),
                        "{withNetPay}"=>array("sum","NetPay","decimals"=>2),
                    ),
                    "top"=>"<p style='text-align:center;'>{CustomerInfo}</p>",
                    //"bottom"=>"<td colspan=6 style='background:#ccc;text-align:right;'><b>Total of {CustomerName} ({VoucherNumber})</b></td><td style='background:#ccc; text-align:center;'><b>{sumDiscount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumAmount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtax}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtotalprice}<br>{withAvg}</b></td>",
                    "bottom"=>"<td colspan=6 style='text-align:right;'><b>Total of {CustomerName} ({VoucherNumber})</b></td><td colspan=2 style='text-align:right;'><span>Discount : <br>Sub Total : <br>Tax : <br>Total Price : <br>Withold : <br>VAT : <br>Net Pay : </span></td><td colspan=2 style='text-align:left;'><span><b>{sumDiscount}<br>{sumAmount}<br>{sumtax}<br>{sumtotalprice}<br>{withAvg}<br>{withVAT}<br>{withNetPay}</b><br></span></td>",
                ),
                "Name"=>array(),
            ),
        
            "sorting"=>array(
                "SubTotal"=>"asc"
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
                "DefaultPrice"=>array(
                    "label"=>"Default Price",
                    "cssStyle"=>"text-align:center",
                    "decimals"=>2,
                ),
                "UnitPrice"=>array(
                    "label"=>"Price",
                    "cssStyle"=>"text-align:center",
                    "decimals"=>2,
                ),
                "Discount"=>array(
                    "label"=>"Discount",
                    "footer"=>"sum",
                    "decimals"=>2,
                    "cssStyle"=>"text-align:center",
                    "footerText"=>"<b>@value</b>" 
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
                    "label"=>"Tax 15%",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "cssStyle"=>"text-align:center",
                    "footerText"=>"<b>@value</b>",
                ),
                "TotalPrice"=>array(
                    "label"=>"Total Price",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "cssStyle"=>"text-align:center;",
                    "footerText"=>"<b>@value</b>"
                ),
                "WitholdAmount"=>array(
                    "label"=>"Withold",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "cssStyle"=>"text-align:center;color:white;",
                    "footerText"=>"<b style='color:black;'>@value</b>"
                ),
                "VAT"=>array(
                    "label"=>"VAT",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "cssStyle"=>"text-align:center;color:white;",
                    "footerText"=>"<b style='color:black;'>@value</b>"
                ),
                "NetPay"=>array(
                    "label"=>"Net Pay",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "cssStyle"=>"text-align:center;color:white;",
                    "footerText"=>"<b style='color:black;'>@value</b>"
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