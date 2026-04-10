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
            "dataSource"=>$this->dataStore('salesbyitem'),
            "grouping"=>array(
                "Status"=>array( 
                    "calculate"=>array(
                        "{sumDiscount}"=>array("sum","Discount"),
                        "{sumAmount}"=>array("sum","SubTotal"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalPrice")
                    ),
                    "bottom"=>"<td colspan=6 style='background:#ccc;text-align:right;'><b>Grand Total</b></td><td style='background:#ccc; text-align:center;'><b>{sumDiscount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumAmount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtax}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtotalprice}</b></td>",
                ),
                "PaymentType"=>array( 
                    "calculate"=>array(
                        "{sumDiscount}"=>array("sum","Discount"),
                        "{sumAmount}"=>array("sum","SubTotal"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalPrice")
                    ),
                    "top"=>"<td colspan=10 style='text-align:center;font-size:30px;'><b>{PaymentType} Sales</b></td>",
                    "bottom"=>"<td colspan=6 style='background:#ccc;text-align:right;'><b>Total of {PaymentType} Sales</b></td><td style='background:#ccc; text-align:center;'><b>{sumDiscount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumAmount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtax}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtotalprice}</b></td>",
                ),
                "CustomerName"=>array( 
                    "calculate"=>array(
                        "{sumDiscount}"=>array("sum","Discount"),
                        "{sumAmount}"=>array("sum","SubTotal"),
                        "{sumtax}"=>array("sum","Tax"),
                        "{sumtotalprice}"=>array("sum","TotalPrice")
                    ),
                    "top"=>"<td colspan=10 style='text-align:left;'><b>Customer : {CustomerName}</b></td>",
                    "bottom"=>"<td colspan=6 style='background:#ccc;text-align:right;'><b>Total of {CustomerName}</b></td><td style='background:#ccc; text-align:center;'><b>{sumDiscount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumAmount}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtax}</b></td><td style='background:#ccc; text-align:center;'><b>{sumtotalprice}</b></td>",
                    
                ),
                "Name"=>array(
                    
                ),
             ),  

        
             "sorting"=>array(
                "SubTotal"=>"asc"
             ),
            "showFooter"=>false,
           
            "columns"=>array(
                
                "Name"=>array(
                    "label"=>"Item Name",
                    "cssStyle"=>"text-align:left",
                    "footerText"=>"<b>Grand Total</b>",

                ),
                "PaymentType"=>array(
                    "label"=>"Payment Type",
                    "cssStyle"=>"text-align:left",
                ),
                "StoreName"=>array(
                    "label"=>"Point of Sale",
                    "cssStyle"=>"text-align:center",
                ),
                "UOM"=>array(
                    "label"=>"UOM",
                    "cssStyle"=>"text-align:center"
                ),
                "Quantity"=>array(
                    "label"=>"Quantity",
                    "cssStyle"=>"text-align:center"
                ),
                "UnitPrice"=>array(
                    "label"=>"Price",
                    "cssStyle"=>"text-align:center", 
                    "decimals"=>2,
                   
                ),
                "Discount"=>array(
                    "label"=>"Discount",
                    "decimals"=>2,
                    "footer"=>"sum",
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
    
    <script>
   
   
   </script>
    </body>


</html>