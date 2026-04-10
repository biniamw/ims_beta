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
                <td colspan="2" class="headers doctitle"><b>Direct Stock-Out Voucher</b></td>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <table style="width: 100%;" class="bordertables">
                        <tbody>
                            <tr>
                                <td style="width: 32%;" class="bordertables"><b>Document No.</b></td>
                                <td style="width: 68%;" class="bordertables">{{$docnum}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Type</b></td>
                                <td class="bordertables">{{$dstype}}</td>
                            </tr>
                            @if($sales->Type == 2)
                            <tr>
                                <td class="bordertables"><b>Reference</b></td>
                                <td class="bordertables">{{$sales->Reference}}</td>
                            </tr>
                            @endif
                            @if($sales->Type == 1 || $sales->Type == 2)
                            <tr>
                                <td class="bordertables"><b>Customer</b></td>
                                <td class="bordertables">{{$cusname}}</td>
                            </tr>
                            @endif
                            @if($sales->Type == 2)
                            <tr>
                                <td class="bordertableswhite" style="color:white;">.</td>
                                <td class="bordertableswhite" style="color:white;">.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
                <td style="width: 50%;">
                    <table style="width: 100%;" class="bordertables">
                        <tbody>
                            @if($sales->Type == 1 || $sales->Type == 2)
                            <tr>
                                <td style="width: 42%;" class="bordertables"><b>Payment Type</b></td>
                                <td style="width: 58%;" class="bordertables">{{$sales->PaymentType}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="bordertables"><b>{{$sales->Type == 2 ? 'Source Station' : 'Station'}}</b></td>
                                <td class="bordertables">{{$storename}}</td>
                            </tr>
                            @if($sales->Type == 2)
                            <tr>
                                <td class="bordertables"><b>Destination Station</b></td>
                                <td class="bordertables">{{$total}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="bordertables"><b>Date</b></td>
                                <td class="bordertables">{{$sales->TransactionDate}}</td>
                            </tr>
                            @if($sales->Type == 2)
                            <tr>
                                <td class="bordertableswhite" style="color:white;">.</td>
                                <td class="bordertableswhite" style="color:white;">.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <br/>
        <table style="width: 100%" class="headers bordertables">
            <thead>
                <tr>
                    <th style="width: 5%;text-align: center" class="bordertables">#</th>
                    <th style="width: 13%;text-align: center" class="bordertables">Item Code</th>
                    <th style="width: 20%;text-align: center" class="bordertables">Item Name</th>
                    <th style="width: 13%;text-align: center" class="bordertables">Barcode No.</th>
                    <th style="width: 10%;text-align: center" class="bordertables">Quantity</th>
                    <th style="width: 13%;text-align: center" class="bordertables">Unit Price</th>
                    <th style="width: 13%;text-align: center" class="bordertables">Total Price</th>
                    <th style="width: 13%;text-align: center" class="bordertables">Remark</th>
                </tr>
            </thead>
            @foreach ($detailTable as $item)
            <tr>
                <td style="text-align: center" class="bordertables">{{++$count}}</td>
                <td style="text-align: center" class="bordertables">{{$item->Code}}</td>
                <td style="text-align: center" class="bordertables">{{$item->ItemName}}</td>
                <td style="text-align: center" class="bordertables">{{$item->SKUNumber}}</td>
                <td style="text-align: center" class="bordertables">{{$item->Quantity}}</td>
                <td style="text-align: center" class="bordertables">{{$item->UnitPrice}}</td>
                <td style="text-align: center" class="bordertables">{{$item->BeforeTaxPrice}}</td>
                <td style="text-align: center" class="bordertables">{{$item->Memo}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6" class="bordertables" style="text-align: right;">Total Price</td>
                <td class="bordertables">{{$subTotal}}</td>
                <td></td>
            </tr>
        </table>
        <br/>
        <div>Remark:  <u>{{$sales->Memo}}</u></div>
        <br/>
            {{-- <tr>
                <td></td>
                <td>
                    <table>
                        <tr>
                            <td style="text-align: right;width:3%;"><b> </b></td>
                            <td style="text-align: right;width:2%;border:1px solid black;"><b>Total Price : {{$subTotal}}</b></td>
                        </tr>
                    </table>
                </td>
            </tr> --}}
                <table style="width: 100%">
                    <tr>
                        <td style="width: 33%;">
                            <table style="width: 100%">
                                <tr>
                                    <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Prepared By</b></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Name: </b><u>{{$sales->CreatedBy}}</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$sales->CreatedDate}}</u></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 34%;">
                            <table style="width: 100%">
                                <tr>
                                    <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Verified By</b></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Name: </b><u>{{$sales->CheckedBy}}</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$sales->CheckedDate}}</u></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 33%;">
                            <table style="width: 100%">
                                <tr>
                                    <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Approved By</b></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Name: </b><u>{{$sales->ApprovedBy}}</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$sales->ApprovedDate}}</u></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </tr>
        </table>
        {{-- <footer>
            <table>
                <tr>
                    <td style="height:30px;"><div style="height:30px;"><p style="color: white;"><b>.</b>.</p><br><p><b>Printed on: </b></p>
                        <br><p style="">{{ $compInfo->Address }}</p>
                    </div></td>
                </tr>
                <tr>
                    <td style="height:5px; border-bottom: 1px solid black;"><div style="height:5px;"><p><b>Distribution: </b>1st Copy Backoffice, 2nd Copy Sales By, 3rd Copy Received By </p></div></td>
                </tr>
            </table>
        </footer> --}}
    </body>
</html>
