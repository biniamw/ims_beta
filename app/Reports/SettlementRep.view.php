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
        <!-- <div class="text-center">
          <h1>Sales By Customer</h1>
          <p class="lead">This report shows sales by customer</p>
        
     
    </div>  -->

        <?php
           Table::create(array(
                "dataSource"=>$this->dataStore('settlementsrc'),
                "showFooter"=>false,
                "grouping"=>array(
                    "GroupFlag"=>array( 
                        "calculate"=>array(
                            "{settamount}"=>array("sum","SettlementAmount")
                        ),
                        "bottom"=>"<td colspan=7 style='text-align:right;'><b>Grand Total</b></td><td style='text-align:center;'><b>{settamount}</b></td>",
                    ),
                    "SettStatus"=>array(),
                    "InvoicePaymentStatus"=>array(),
                    "InvoiceNumber"=>array(),
                    "FSNumber"=>array( 
                        "calculate"=>array(
                            "{settamount}"=>array("sum","SettlementAmount")
                        ),
                        "top"=>"<td colspan=8 style='text-align:center;'>Doc/ FS #:      <b>{FSNumber} |</b> Invoice/ Ref #:       <b>{InvoiceNumber} |</b> Invoice Payment Status:        <b>{InvoicePaymentStatus}</b></td>",
                        "bottom"=>"<td colspan=7 style='text-align:right;'><b>Total of : {FSNumber}</b></td><td style='text-align:center;'><b>{settamount}</b></td>",
                    ),
                ),
     
                "columns"=>array(
                    "FSNumber"=>array(
                        "label"=>"Doc/ FS #",
                        "cssStyle"=>"text-align:center"
                    ),
                    "InvoiceNumber"=>array(
                        "label"=>"Invoice/ Ref #",
                        "cssStyle"=>"text-align:center"
                    ),
                    "RemainingDate"=>array(
                        "label"=>"Remaining Day",
                        "cssStyle"=>"text-align:center"
                    ),
                    "PaymentType"=>array(
                        "label"=>"Payment Type",
                        "cssStyle"=>"text-align:center"
                    ),
                    "BankName"=>array(
                        "label"=>"Bank Name",
                        "cssStyle"=>"text-align:center"
                    ),
                    "AccountNumber"=>array(
                        "label"=>"Account #",
                        "cssStyle"=>"text-align:center"
                    ),
                    "BankTransferNumber"=>array(
                        "label"=>"Transaction Ref. #",
                        "cssStyle"=>"text-align:center",
                        "decimals"=>2,
                    ),
                    "SettlementAmount"=>array(
                        "label"=>"Settled Amount",
                        "footer"=>"sum",
                        "decimals"=>2,
                        "cssStyle"=>"text-align:center",
                        "footerText"=>"<b>@value</b>" 
                    ),
                ),
                "cssClass"=>array(
                    "table"=>"table table-hover table-bordered table-striped",
                    "tf"=>"darker", 
                ),
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