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
                "dataSource"=>$this->dataStore('incbanksrc'),
                "showFooter"=>false,
               
                "columns"=>array(
                    "BankName"=>array(
                        "label"=>"Bank Name",
                        "cssStyle"=>"text-align:center"
                    ),
                    "AccountNumber"=>array(
                        "label"=>"Account Number",
                        "cssStyle"=>"text-align:center"
                    ),
                    "SlipNumber"=>array(
                        "label"=>"Transaction Ref.",
                        "cssStyle"=>"text-align:center"
                    ),
                    "Amount"=>array(
                        "label"=>"Amount",
                        "cssStyle"=>"text-align:center"
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