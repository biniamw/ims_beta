<!DOCTYPE html>
<html lang="en" data-textdirection="ltr">
    <head>
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
            .headerHeight
            {
                height: 100px;
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
                                <td><b>TIN: </b></td>
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
                                <td style="width: 40%;" colspan="2">{{$companyphone}}, {{$companyoffphone}}</td>
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
                <td colspan="2" class="headers doctitle"><b>Stock Requisition Voucher</b></td>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <table style="width: 100%;" class="bordertables">
                        <tbody>
                            <tr>
                                <td style="width: 36%;" class="bordertables"><b>Document No.</b></td>
                                <td style="width: 64%;" class="bordertables">{{$docnum}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Station</b></td>
                                <td class="bordertables">{{$storename}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 50%;">
                    <table style="width: 100%;" class="bordertables">
                        <tbody>
                            <tr>
                                <td style="width: 36%;" class="bordertables"><b>Request Reason</b></td>
                                <td style="width: 64%;" class="bordertables">{{$reqreason}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Date</b></td>
                                <td style="border-bottom-color: black;" class="bordertables">{{$formdate}}</td>
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
                    <th style="width: 5%;" class="bordertables">#</th>
                    <th style="width: 15%;" class="bordertables">Item Code</th>
                    <th style="width: 25%;" class="bordertables">Item Name</th>
                    <th style="width: 20%;" class="bordertables">Barcode No.</th>
                    <th style="width: 10%;" class="bordertables">UOM</th>
                    <th style="width: 10%;" class="bordertables">Quantity</th>
                    <th style="width: 15%;" class="bordertables">Remark</th>
                </tr>
            </thead>
            @foreach ($detailTable as $item)
            <tr>           
                <td style="text-align: center" class="bordertables">{{++$count}}</td>
                <td style="text-align: center" class="bordertables">{{$item->ItemCode}}</td>
                <td style="text-align: center" class="bordertables">{{$item->ItemName}}</td>
                <td style="text-align: center" class="bordertables">{{$item->SKUNumber}}</td>
                <td style="text-align: center" class="bordertables">{{$item->UOM}}</td>
                <td style="text-align: center" class="bordertables">{{$item->Quantity}}</td>
                <td style="text-align: center" class="bordertables">{{$item->Memo}}</td>
            </tr>
            @endforeach
        </table>
        <br/>
        <div><b>Remark:</b> <u>{{$purpose}}</u></div>
        <table style="width: 100%;">
            <tr>
                <td colspan="3">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 25%">
                                <table style="width: 100%">
                                    <tr>
                                        <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Requested By</b></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Name: </b><u>{{$requestedby}}</u></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Date: </b><u>{{$reqdate}}</u></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 25%">
                                <table style="width: 100%">
                                    <tr>
                                        <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Approved By</b></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Name: </b><u>{{$approvedby}}</u></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Date: </b><u>{{$approveddate}}</u></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 25%">
                                <table style="width: 100%">
                                    <tr>
                                        <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Issued By</b></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Name: </b><u>{{$issuedby}}</u></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Date: </b><u>{{$issueddate}}</u></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 25%">
                                <table style="width: 100%">
                                    <tr>
                                        <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Received By</b></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Name: </b><u>{{$receivedby}}</u></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Date: </b><u>{{$received_date}}</u></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
