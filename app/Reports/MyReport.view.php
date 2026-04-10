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
    <title>My Report</title> 
    </head>
    <body>
        <div class="text-center">
          <h1>Sales By Customer</h1>
          <p class="lead">This report shows sales by customer</p>
        
        <?php
      ColumnChart::create(array(
        "dataStore"=>$this->dataStore('sales_by_customer'),  
        "columns"=>array(
            "Name"=>array(
           "label"=>"Name"
            ),
            "GrandTotal"=>array(
                "type"=>"number",
                "label"=>"Grand Total",
                "prefix"=>"$",
                "decimals"=>2,
                
            )
        ),
        "width"=>"100%",
    ));
    ?>
    </div> 
    <?php
          Table::create(array(
              "dataStore"=>$this->dataStore('sales_by_customer'),
              "showFooter"=>true,
              "columns"=>array(
                  "Name"=>array(
                 "label"=>"Name"
                  ),
                  "SubTotal"=>array(
                    "type"=>"number",
                    "label"=>"Sub Total",
                    "prefix"=>"$",
                    "footer"=>"sum",
                    "decimals"=>2,
                    "cssStyle"=>"text-align:right",
                    "footerText"=>"<b>Sub Total:</b> @value"
                  ),
                  "Tax"=>array(
                    "type"=>"number",
                    "label"=>"Tax",
                    "prefix"=>"$",
                    "footer"=>"sum",
                    "decimals"=>2,
                    "cssStyle"=>"text-align:right",
                    "footerText"=>"<b>Total(15%):</b> @value"
                  ),
                  "GrandTotal"=>array(
                      "type"=>"number",
                      "label"=>"Grand Total",
                      "prefix"=>"$",
                      "footer"=>"sum",
                      "decimals"=>2,
                      "cssStyle"=>"text-align:right",
                      "footerText"=>"<b>Grand Total:</b> @value"
                  )
              ),
           

              "cssClass"=>array(
                  "table"=>"table table-bordered table-striped"
              )
          ));
          ?>

    <p class="lead">Sales by Item</p>
    <?php
      DonutChart::create(array(
        "dataStore"=>$this->dataStore('sales_by_item'),  
        "columns"=>array(
            "Category"=>array(
           "label"=>"Category"
            ),
            "SubTotal"=>array(
                "type"=>"number",
                "label"=>"SubTotal",
                "prefix"=>"$",
                "decimals"=>2,
            ),
            "Tax"=>array(
                "type"=>"number",
                "label"=>"Tax",
                "prefix"=>"$",
                "decimals"=>2,
            ),
            "TotalPrice"=>array(
                "type"=>"number",
                "label"=>"TotalPrice",
                "prefix"=>"$",
                "decimals"=>2,
               )
        ),
        "width"=>"100%",
    ));
    ?>

          

<?php
           Table::create(array(
            "dataSource"=>$this->dataStore('sales_by_item'),
            "grouping"=>array(
                "Category"=>array(
                    "calculate"=>array(
                        "{sumAmount}"=>array("sum","SubTotal"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalPrice")
                    ),
                    "top"=>"<b> {Category}</b>",
                    "bottom"=>"<td><b>Total of {Category}</b></td><td></td><td><b>{sumAmount}</b></td><td><b>{sumtax}</b></td><td><b>{sumtotalprice}</b></td>",
                ),
            ),
            "sorting"=>array(
                "SubTotal"=>"asc"
            ),
            "showFooter"=>true,
            "columns"=>array(
                "Name"=>array(
                    "label"=>"Item Name",
                    "footerText"=>"<b>Grand Totals</b>"
                ),
                "Quantity"=>array(
                    "label"=>"Quantity",
    
                ),

                "SubTotal"=>array(
                    "label"=>"SubTotal",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "footerText"=>"<b>@value</b>"
                ),
                "Tax"=>array(
                    "label"=>"Tax",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "footerText"=>"<b>@value</b>"
                ),
                
                "TotalPrice"=>array(
                    "label"=>"TotalPrice",
                    "prefix"=>"",
                    "decimals"=>2,
                    "footer"=>"sum",
                    "footerText"=>"<b>@value</b>"
                ),
            ),
            "cssClass"=>array(
                "table"=>"table table-hover table-bordered",
                "tf"=>"darker"
            )
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