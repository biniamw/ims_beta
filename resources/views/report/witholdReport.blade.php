
<html lang="en" data-textdirection="ltr">
<head>
  
<title>Sales Deduct Withold & VAT Report</title>
<style>
    table{
        width: 100%;
        border-collapse: collapse; 
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
     }

    table td, table th{  
        border:1px solid black; 
    } 
    table tr, table td{
        padding: 5px;
        /* page-break-inside: avoid; */
    } 
    th {
	background-color: #00cfe8 ;
	color: white;
    text-align: left;
}
th, td {
	border-bottom: 1px solid black;
}

table td img {
    display: inline-block;  
    float: left;
    width: 100%;
    height: 120px;
    table-layout: fixed; 
}
</style>
</head>
<body>
<table id="t1" style="width:100%;border:none;border-collapse:collapse;cellspacing:0;cellpadding:0;">
              <tr style="border:none;">
                 <td colspan="4" style="text-align:center;border:none;font-weight:bold;font-size:30px; color:#00cfe8;">
                 {{$compInfo->Name}}
                </td>
                <td rowspan="4" style="width:15%;border:none;">
                    <img src="data:image/jpeg;base64,{{chunk_split(base64_encode($compInfo->Logo))}}" width="100" height="100"> 
                 
                   <?php
                   ?>
                    
                </td>
             </tr>
             <tr>
                <td style="width:11%;border:none;font-weight:bold;">Tel:</td>
                <td style="border:none;">{{$compInfo->Phone}}</td>
                <td style="width:11%;border:none;font-weight:bold;">Website:</td>
                <td style="border:none;">{{$compInfo->Website}}</td>
            </tr>
            <tr>
                <td style="border:none;font-weight:bold;">Email:</td>
                <td style="border:none;">{{$compInfo->Email}}</td>
                <td style="border:none;font-weight:bold;">Address:</td>
                <td style="border:none;">{{$compInfo->Address}}</td>
            </tr>
            <tr>
                <td style="border:none;font-weight:bold;">TIN No.:</td>
                <td style="border:none;">{{$compInfo->TIN}}</td>
                <td style="border:none;font-weight:bold;">VAT No.:</td>
                <td style="border:none;">{{$compInfo->VATReg}}</td>
            </tr>
            <tr>
                <td colspan="5" style="border-top:white;border-right:white;border-left:white;">
                </td>
            </tr> 
        </table>  
  
        <h3><p style="text-align:center; margin:top:-10px;color:#00cfe8;font-family: 'Segoe UI', Verdana, Helvetica, Sans-Serif;"><b>Sales Deduct Withold & VAT Report</b></p></h3>

        <table id="t2" style="margin-bottom:10px;">
            <tr>
                <td style="width:15%">Date Range</td>
                <td style="font-weight:bold;">{{$from}} to {{$to}}</td>
                <td style="width:18%">Point of Sales</td>
                <td style="font-weight:bold;">@foreach($storename as $storename) {{$storename->StoreName}} @endforeach</td>
            </tr>
            <tr>
                <td style="width:15%">Payment Type</td>
                <td style="font-weight:bold;">{{$paymentypes}}</td>
                <td style="width:18%">Settlement Status</td>
                <td style="font-weight:bold;">{{$status}}</td>
            </tr>
        </table>
        
<?php 
 $report->render(); 
?> 

</body>
</html>


