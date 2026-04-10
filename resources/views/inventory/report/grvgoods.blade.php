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
                                <td style="width: 7%;"><b>Phone: </b></td>
                                <td style="width: 43%;" colspan="2">{{$companyphone}},{{$companyoffphone}}</td>
                                <td style="width: 7%;"><b>Website: </b></td>
                                <td style="width: 43%;" colspan="2">{{$companywebsite}}</td>   
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
                    <td colspan="2"><b>Printed on: </b>{{$currentdate}}
                </td>
                </tr>
                <tr>
                    <td><b>Distribution: </b>1<sup>st</sup> Copy Backoffice, 2<sup>nd</sup> Copy Purchased By, 3<sup>rd</sup> Copy Received By</td>
                    <td style="text-align: right;">Page {PAGENO} of {nb}</td>
                </tr>
            </table>
        </div>
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
        <sethtmlpagefooter name="myfooter" value="on"/>
        <table> 
            
            <tr>
                <td colspan="3" class="headers doctitle"><b>Good Receiving Voucher / GRV</b></td>
            </tr>
            <tr>
                <td style="width: 33%;">
                    <table style="width: 100%;" class="bordertables">
                        <tbody>
                            <tr class="headerHeight">
                                <td class="headers bordertables" style="height:20px;" colspan="2"><div style="height:20px;"><b>Supplier Information</b></div></td>
                            </tr>
                            <tr>
                                <td style="width: 25%;" class="bordertables"><b>Category</b></td>
                                <td style="width: 75%;" class="bordertables">{{$customercategory}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Name</b></td>
                                <td class="bordertables">{{$customername}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>TIN</b></td>
                                <td class="bordertables">{{$customertin}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>VAT No.</b></td>
                                <td class="bordertables">{{$customervat}}</td>
                            </tr>
                            <tr>
                                <td class="bordertableswhite" style="color:white;">.</td>
                                <td class="bordertableswhite" style="color:white;">.</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 34%;">
                    <table style="width: 100%;" class="bordertables">
                        <tbody>
                            <tr class="headerHeight">
                                <td class="headers bordertables" style="height:20px;" colspan="2"><div style="height:20px;"><b>Delivery & Receiving Information</b></div></td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Delivery Order No.</b></td>
                                <td class="bordertables">{{$deliveryordno}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Dispatch Station</b></td>
                                <td class="bordertables">{{$dispatchstation}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Received Station</b></td>
                                <td class="bordertables">{{$storename}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Driver Name</b></td>
                                <td class="bordertables">{{$drivername}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Plate No.</b></td>
                                <td class="bordertables">{{$truckplate}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 33%;">
                    <table style="width: 100%" class="bordertables">
                        <tbody>
                            <tr class="headerHeight">
                                <td class="headers bordertables" style="height:20px;" colspan="2"><div style="height:20px;"><b>Purchase Information</b></div></td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Receiving Doc. No.</b></td>
                                <td class="bordertables">{{$docnum}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Reference</b></td>
                                <td class="bordertables">{{$rectype}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Reference No.</b></td>
                                <td class="bordertables">{{$purchaseordnum}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Company Type</b></td>
                                <td class="bordertables">{{$comptype}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Customer</b></td>
                                <td class="bordertables">{{$cusorowner}}</td>
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
                    <th style="width:3%;" class="bordertables">#</th>
                    <th style="width:19%;" class="bordertables">Floor Map</th>
                    <th style="width:20%;" class="bordertables">Item Name</th>
                    <th style="width:19%" class="bordertables">UOM</th>
                    <th style="width:19%" class="bordertables">Quantity</th>
                    <th style="width:20%" class="bordertables">Remark</th>
                </tr>
            </thead>
            <tbody>
            $total_qty=0;
            @foreach ($detailTable as $comm)
            <tr>           
                <td style="text-align: center" class="bordertables">{{++$count}}</td>
                <td style="text-align: center" class="bordertables">{{$comm->floor_map}}</td>
                <td style="text-align: center" class="bordertables">{{$comm->ItemName}}</td>
                <td style="text-align: center" class="bordertables">{{$comm->UOM}}</td>
                <td style="text-align: center" class="bordertables">{{number_format($comm->Quantity,0)}}</td>
                <td style="text-align: center" class="bordertables">{{$comm->Memo}}</td>
            </tr>
            {{$total_qty+=$comm->Quantity}}
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                    <th style="font-size: 14px;" id="totalbag" class="bordertables"> {{number_format($total_qty,0)}} </th>
                    <th style="font-size: 14px;" class="bordertables"></th>
                </tr>
            </tfoot>
        </table>
        <br/>
        <div><b>Remark:</b>  <u>{{$mem}}</u></div>
        <br/>
        <table style="width: 100%">
            <tr>
                <td style="width: 33%">
                    <table style="width: 100%">
                        <tr>
                            <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Prepared By</b></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Name: </b><u>{{$preparedby}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Date: </b><u class="fontprop">{{$transactiondate}}</u></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 34%">
                    <table style="width: 100%">
                        <tr>
                            <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Delivered By</b></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Name: </b><u>{{$deliveredby}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Date: </b><u class="fontprop">{{$transactiondate}}</u></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 33%">
                    <table style="width: 100%">
                        <tr>
                            <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Received By</b></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Name: </b><u>{{$receivedby}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Date: </b><u class="fontprop">{{$receiveddate}}</u></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Verified By</b></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Name: </b><u>{{$checkedby}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Date: </b><u class="fontprop">{{$checkeddate}}</u></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Confirmed By</b></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Name: </b><u>{{$confirmedby}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Date: </b><u class="fontprop">{{$confirmeddate}}</u></td>
                        </tr>
                    </table>
                </td>
                <td></td>
            </tr>
        </table>
    </body>
</html>