<!DOCTYPE html>
<html lang="en" data-textdirection="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>    
           body 
           { 
               margin:-35;
               padding:14; 
            }
            h1,h2,h3,h4,h5,h6,p,span,div { 
                font-family: Arial, Helvetica, sans-serif;  
                font-size:14px;
                font-weight: normal;
            }
            th,td { 
                font-family: Arial, Helvetica, sans-serif;  
                font-size:14px;
            }
            
            table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 0px;
                border-spacing: 0;
                border-collapse: collapse;
                background-color: transparent;
                margin-left: 0%;
                table-layout:fixed;
            }
            thead  {
                text-align: left;
                display: table-header-group;
                vertical-align: middle;
            }
            th, td  {
               
                padding: 6px;
            }
           
            .headers
            {
                text-align:center;
            }
            .bordertables
            {
                border: 1px solid black;
            }
            .bordertableswhite
            {
                border: 1px solid white;
                color:white;
            }
            .bordertablessign
            {
                border: 1px solid white;
            }
            .headerHeight
            {
                height: 100px;
            }
            .doctitle
            {
                font-size:1.5rem;
            }
            table thead th { 
                background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;
            }
            .headerTable
            {
                border-bottom: 1px solid black; 
                margin-top:1px;
            }
            .headerTitles
            {
                text-align:center;
                font-size:1.7rem;
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
        <htmlpageheader name="myheader">
            <table>
                <tr>
                    <td colspan="3">
                        <table class="headerTable">
                            <tr>
                                <td colspan="6" class="headerTitles" style="text-align: center;"><b>{{$companyname}}</b></td>
                                {{-- <td rowspan="4" style="width:15%;border:none;"><img src="data:image/png;base64,{{ chunk_split(base64_encode($compInfo->Logo)) }}" width="150" height="150"></td> --}}
                            </tr>
                            <tr>
                                <td><b>TIN No.: </b></td>
                                <td colspan="2">{{$companytin}}</td>
                                <td><b>Address: </b></td>
                                <td colspan="2">{{$companyaddress}}</td>
                                
                            </tr>
                            <tr>
                                <td><b>VAT No.: </b></td>
                                <td colspan="2">{{$companyvat}}</td>
                                <td><b>Email: </b></td>
                                <td colspan="2">{{$companyemail}}</td>
                            </tr>
                            <tr>
                                <td style="width: 10%;"><b>Phone: </b></td>
                                <td style="width: 40%;" colspan="2">{{$companyphone}},{{$companyoffphone}}</td>
                                <td style="width: 10%;"><b>Website: </b></td>
                                <td style="width: 40%;" colspan="2">{{$companywebsite}}</td>   
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </htmlpageheader>
        <htmlpagefooter name="myfooter">
        <div style="border-top: 1px solid #000000; font-size: 9pt;padding-top: 3mm; ">
            <table style="width: 100%">
                <tr>
                    <td><b>Printed on: </b>{{$currentdate}}</td>
                    <td style="text-align: right;">Page {PAGENO} of {nb}</td>
                </tr>
            </table>
        </div>
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
        <sethtmlpagefooter name="myfooter" value="on"/>
        <table>
            <tr>
                <td colspan="3" class="headers doctitle"><b>Inventory Ending Note / IEN</b></td>
            </tr>
            <tr>
                <td colspan="3" style="width: 50%;">
                    <table style="width: 100%;" class="bordertables">
                        <tbody>
                            <tr>
                                <td style="width: 20%;" class="bordertables"><b>IEN Number</b></td>
                                <td style="width: 20%;" class="bordertables"><b>Store/Shop</b></td>
                                <td style="width: 20%;" class="bordertables"><b>Fiscal Year</b></td>
                                <td style="width: 20%;" class="bordertables"><b>Date</b></td>
                                <td style="width: 20%;" class="bordertables"><b>Status</b></td>
                            </tr>
                            <tr>
                                <td class="bordertables">{{$docnum}}</td>
                                <td class="bordertables">{{$storename}}</td>
                                <td class="bordertables">{{$fiscalyear}}</td>
                                <td class="bordertables">{{$date}}</td>
                                <td class="bordertables">{{$status}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <br/>
        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
            <thead>
                <tr>
                    <th style="width: 3%;text-align: center" class="bordertables">#</th>
                    <th style="width: 10%;text-align: center" class="bordertables">Item Code</th>
                    <th style="width: 20%;text-align: center" class="bordertables">Item Name</th>
                    <th style="width: 13%;text-align: center" class="bordertables">SKU No.</th>
                    <th style="width: 5%;text-align: center" class="bordertables">UOM</th>
                    <th style="width: 13%;text-align: center" class="bordertables">Store/Shop Name</th>
                    <th style="width: 8%;text-align: center" class="bordertables">System Count</th>
                    <th style="width: 8%;text-align: center" class="bordertables">Physical Count</th>
                    <th style="width: 7%;text-align: center" class="bordertables">Variance Shortage</th>
                    <th style="width: 8%;text-align: center" class="bordertables">Variance Overage</th>
                </tr>
            </thead>
            @foreach ($detailTable as $item)
            <tr>           
                <td style="text-align: center" class="bordertables">{{++$count}}</td>
                <td style="text-align: center" class="bordertables">{{$item->ItemCode}}</td>
                <td style="text-align: center" class="bordertables">{{$item->ItemName}}</td>
                <td style="text-align: center" class="bordertables">{{$item->SKUNumber}}</td>
                <td style="text-align: center" class="bordertables">{{$item->UOM}}</td>
                <td style="text-align: center" class="bordertables">{{$item->StoreName}}</td>
                <td style="text-align: center" class="bordertables">{{$item->Quantity}}</td>
                <td style="text-align: center" class="bordertables">{{$item->PhysicalCount}}</td>
                <td style="text-align: center" class="bordertables">{{$item->ShortageVariance}}</td>
                <td style="text-align: center" class="bordertables">{{$item->OverageVariance}}</td>
            </tr>
            @endforeach
        </table>
        <br/>
        <table>
            <tr>
                <td colspan="3">
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <table style="width: 100%">
                                    <tr>
                                        <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Counted By</b></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bordertablessign"><b>Name: </b><u>{{$countedby}}</u></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$counteddate}}</u></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="width: 100%">
                                    <tr>
                                        <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Verified By</b></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bordertablessign"><b>Name: </b><u>{{$verifiedby}}</u></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$verifieddate}}</u></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="width: 100%">
                                    <tr>
                                        <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Posted By</b></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bordertablessign"><b>Name: </b><u>{{$postedby}}</u></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$posteddate}}</u></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        {{-- <footer>
            <table>
                <tr>
                    <td style="height:30px;"><div style="height:30px;"><p style="color: white;"><b>.</b>.</p><br><p style="color: white;"><b>.</b>.</p>
                        <br><p style="">{{$systemalladdress}}</p>
                    </div></td>
                </tr>
                <tr>
                    <td style="height:5px; border-bottom: 1px solid black;"><div style="height:5px;"><p><b>Printed on: </b>{{$currentdate}}</p></div></td>
                </tr>
            </table>
        </footer> --}}
    </body>
    <script  type="text/javascript">
        window.onload = function () {
            window.print();
            setTimeout(window.close, 0);
        }
    </script>
</html>
