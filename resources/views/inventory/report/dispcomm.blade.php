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
                margin-top:2px;
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
                                <td colspan="6"></td>
                            </tr>
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
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3" class="headers doctitle"><b>Dispatch Voucher</b></td>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <table style="width: 100%;" class="bordertables">
                        <tbody>
                            <tr>
                                <td style="width: 42%;" class="bordertables"><b>Dispatch Doc. No.</b></td>
                                <td style="width: 58%;" class="bordertables">{{$docnum}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Requisition Doc. No.</b></td>
                                <td class="bordertables">{{$reqdocnum}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Container No.</b></td>
                                <td class="bordertables">{{$containerno}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Seal No.</b></td>
                                <td class="bordertables">{{$sealno}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Date</b></td>
                                <td class="bordertables">{{$dates}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 50%;">
                    <table style="width: 100%;" class="bordertables">
                        <tbody>
                            <tr>
                                <td style="width: 50%;" class="bordertables"><b>Driver/Person Name</b></td>
                                <td style="width: 50%;" class="bordertables">{{$drivername}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Driver/Person Phone No.</b></td>
                                <td style="border-bottom-color: black;" class="bordertables">{{$driverphoneno}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Plate No.</b></td>
                                <td style="border-bottom-color: black;" class="bordertables">{{$plateno}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Request Reason</b></td>
                                <td style="border-bottom-color: black;" class="bordertables">{{$reasonloading}}</td>
                            </tr>
                            <tr>
                                <td class="bordertableswhite" style="color:white;">.</td>
                                <td class="bordertableswhite" style="color:white;">.</td>
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
                    <th style="width:3%;">#</th>
                    <th style="width:11%">Commodity</th>
                    <th style="width:11%">Supplier</th>
                    <th style="width:11%" title="GRN Number">GRN No.</th>
                    <th style="width:11%" title="Production Order Number">Production Order No.</th>
                    <th style="width:11%" title="Production Certificate Number">Production Certificate No.</th>
                    <th style="width:11%" title="Export Certificate Number">Export Certificate No.</th>
                    <th style="width:7%">UOM/ Bag</th>
                    <th style="width:8%">No. of Bag</th>
                    <th style="width:8%">Total KG</th>
                    <th style="width:8%">Net KG</th>
                </tr>
            </thead>
            <tbody>
            $numofbag=0;
            $totalkg=0;
            $netkg=0;
            @foreach ($detailTable as $item)
            <tr>           
                <td style="text-align: center" class="bordertables">{{++$count}}</td>
                <td style="text-align: center" class="bordertables">{{$item->Origin}}</td>
                <td style="text-align: center" class="bordertables">{{$item->SupplierName}}</td>
                <td style="text-align: center" class="bordertables">{{$item->GrnNumber}}</td>
                <td style="text-align: center" class="bordertables">{{$item->ProductionOrderNo}}</td>
                <td style="text-align: center" class="bordertables">{{$item->CertNumber}}</td>
                <td style="text-align: center" class="bordertables">{{$item->ExportCertNumber}}</td>
                <td style="text-align: center" class="bordertables">{{$item->UOM}}</td>
                <td style="text-align: center" class="bordertables">{{number_format($item->NumOfBag,0)}} </td>
                <td style="text-align: center" class="bordertables"> {{number_format($item->TotalKG,2)}}</td>
                <td style="text-align: center" class="bordertables"> {{number_format($item->NetKG,2)}}</td>
            </tr>
            {{$numofbag+=$item->NumOfBag}}
            {{$totalkg+=$item->TotalKG}}
            {{$netkg+=$item->NetKG}}
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="8" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                    <th style="font-size: 14px;" id="totalbag" class="bordertables"> {{number_format($numofbag,0)}} </th>
                    <th style="font-size: 14px;" id="totalgrosskg" class="bordertables"> {{number_format($totalkg,2)}}</th>
                    <th style="font-size: 14px;" id="totalkg" class="bordertables"> {{number_format($netkg,2)}}</th>
                </tr>
            </tfoot>
        </table>
        <br/>
        <div><b>Memo:</b> <u>{{$remark}}</u></div>
        <table style="width: 100%">
            <tr>
                <td colspan="3">
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
                                        <td colspan="2"><b>Date: </b><u>{{$reqdate}}</u></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 33%">
                                <table style="width: 100%">
                                    <tr>
                                        <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Verified By</b></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Name: </b><u>{{$verifiedby}}</u></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Date: </b><u>{{$verifieddate}}</u></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 34%">
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
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
