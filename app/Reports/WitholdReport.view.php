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
            "dataSource"=>$this->dataStore("witholdSrc"),
            "excludedColumns"=>array("SubTotal","Tax","GrandTotal","NetPay"),
            "sorting"=>array(
                "SettlementStatus"=>"desc"
            ),
            "grouping"=>array(
               
                "SettlementStatus"=>array( 
                    "calculate"=>array(
                        "{sumWithold}"=>array("sum","WitholdAmount"),
                        "{sumVat}"=>array("sum","Vat"),
                    ),
                    "top"=>"<td colspan=11 style='text-align:center;font-size:30px;'><b>{SettlementStatus}</b></td>",
                    "bottom"=>"<td colspan=6 style='background:#ccc;text-align:right;'><b>Total {SettlementStatus}</b></td><td style='background:#ccc; text-align:center;'><b>{sumWithold}</b></td><td style='background:#ccc; text-align:center;'><b></b></td><td style='background:#ccc; text-align:center;'><b>{sumVat}</b></td><td style='background:#ccc; text-align:center;'><b></b></td><td style='background:#ccc; text-align:center;'><b></b></td>",
                ),
                "CustomerName"=>array( 
                    "calculate"=>array(
                        "{sumWithold}"=>array("sum","WitholdAmount"),
                        "{sumVat}"=>array("sum","Vat"),
                    ),
                    "top"=>"<td colspan=11 style='text-align:left;'><b>Customer : {CustomerName}</b></td>",
                    "bottom"=>"<td colspan=6 style='background:#ccc;text-align:right;'><b>Total by {CustomerName}</b></td><td style='background:#ccc; text-align:center;'><b>{sumWithold}</b></td><td style='background:#ccc; text-align:center;'><b></b></td><td style='background:#ccc; text-align:center;'><b>{sumVat}</b></td><td style='background:#ccc; text-align:center;'><b></b></td><td style='background:#ccc; text-align:center;'><b></b></td>",
                ),
               
             ),
            "showFooter"=>false,
            "columns"=>array(
                "CustomerCode"=>array(
                    "label"=>"Customer Code",
                    "cssStyle"=>"text-align:center",
                    "footerText"=>"<b>Grand Total</b>",
                ),
                "CustomerName"=>array(
                    "label"=>"Customer Name",
                    "cssStyle"=>"text-align:center",
                ),
                "TIN"=>array(
                    "label"=>"TIN No.",
                    "cssStyle"=>"text-align:center",
                ),
                "PaymentType"=>array(
                    "label"=>"Payment Type",
                    "cssStyle"=>"text-align:center",
                ),
                "StoreName"=>array(
                    "label"=>"Point of Sales",
                    "cssStyle"=>"text-align:center",
                ),
                "VoucherNumber"=>array(
                    "label"=>"Voucher No.",
                    "cssStyle"=>"text-align:center",
                ),
                "WitholdAmount"=>array(
                    "label"=>"Withold Amount",
                    "cssStyle"=>"text-align:center",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "footerText"=>"<b>@value</b>"
                ),
                "witholdNumber"=>array(
                    "label"=>"Withold No.",
                    "cssStyle"=>"text-align:center",
                ),
                "Vat"=>array(
                    "label"=>"Vat Amount",
                    "cssStyle"=>"text-align:center",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "footerText"=>"<b>@value</b>"
                ),
                "vatNumber"=>array(
                    "label"=>"Vat No.",
                    "cssStyle"=>"text-align:center",
                ),
                "CreatedDate"=>array(
                    "label"=>"Date",
                    "cssStyle"=>"text-align:center",
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
                "GrandTotal"=>array(
                    "label"=>"Total Price",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "cssStyle"=>"text-align:center;",
                    "footerText"=>"<b>@value</b>"
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
        ]);
        ?>
        <div style="height:20px;"></div>
      
        <style>
            .darker
            {
                background:#ccc;
            }
            .hider
            {
                display: flex;
  justify-content: center;
  list-style-type: none;
  padding: 0;
  margin: 0;
            }
        </style>
    </body>
</html>
