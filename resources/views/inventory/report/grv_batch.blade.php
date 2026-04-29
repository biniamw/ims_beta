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
            .doctitle
            {
                font-size:1.5rem;
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
        <div style="border-top: 1px solid #000000; font-size: 9pt;padding-top: 3mm;">
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
                <td colspan="3" class="headers doctitle"><b>Good Receiving Voucher / GRV (Batch & Serial No.)</b></td>
            </tr>
            <tr>
                <td>
                    <div><b>Source Type:</b>  <u>{{$source_type}}</u></div>
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
                @if($type == 503)
                <td style="width: 40%;">
                    <table style="width: 100%;" class="bordertables">
                        <tbody>
                            <tr class="headerHeight">
                                <td class="headers bordertables" style="height:20px;" colspan="2"><div style="height:20px;"><b>Purchase Information</b></div></td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Payment Type</b></td>
                                <td class="bordertables">{{$paymenttype}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Invoice Type</b></td>
                                <td class="bordertables">{{$vouchertype}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>MRC No.</b></td>
                                <td class="bordertables">{{$customermrc}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Doc/ FS No.</b></td>
                                <td class="bordertables">{{$vouchernumber}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Invoice/ Ref No.</b></td>
                                <td class="bordertables">{{$invnumber}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                @endif
                <td>
                    <table style="width: 100%" class="bordertables">
                        <tbody>
                            <tr class="headerHeight">
                                <td class="headers bordertables" style="height:20px;" colspan="2"><div style="height:20px;"><b>General Information</b></div></td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Reference Type</b></td>
                                <td class="bordertables">{{$reference}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>GRV No.</b></td>
                                <td class="bordertables">{{$docnum}}</td>
                            </tr>
                            @if($type != 503)
                            <tr>
                                <td class="bordertables"><b>Reference No.</b></td>
                                <td class="bordertables">{{$po_number}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="bordertables"><b>Station</b></td>
                                <td class="bordertables">{{$storename}}</td>
                            </tr>
                            <tr>
                                <td style="width: 42%;" class="bordertables"><b>Date</b></td>
                                <td style="width: 58%;" class="bordertables">{{$voucherdate}}</td>
                            </tr>
                            <tr>
                                <td class="bordertableswhite" style="color:white;">.</td>
                                <td class="bordertableswhite" style="color:white;">.</td>
                            </tr>
                            @if($type == 503)
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
        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
            <thead>
                <tr>
                    <th style="width: 3%;" class="bordertables">#</th>
                    <th style="width: 10%;" class="bordertables">Item Code</th>
                    <th style="width: 13%;" class="bordertables">Item Name</th>
                    <th style="width: 10%;" class="bordertables">Barcode No.</th>
                    <th style="width: 6%;" class="bordertables">UOM</th>
                    <th style="width: 8%;" class="bordertables">Quantity</th>
                    <th style="width: 13%;" class="bordertables">Batch No.</th>
                    <th style="width: 12%;" class="bordertables">Expiry Date</th>
                    <th style="width: 11%;" class="bordertables">Received Qty.</th>
                    <th style="width: 14%;" class="bordertables">Serial No.</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $previousItem = null;
                    $itemCount = 0;
                    $currentItemRows = [];
                    $currentIndex = 0;
                    $totalRecords = count($detailTable);
                    $row_no = 0;
                @endphp

                @while($currentIndex < $totalRecords)
                    @php
                        $currentItem = $detailTable[$currentIndex]->ItemCode;
                        
                        // Calculate rowspan for current employee
                        $itemCount = 1;
                        $itemRows = [];
                        $nextIndex = $currentIndex;
                        while($nextIndex < $totalRecords && $detailTable[$nextIndex]->ItemCode === $currentItem) {
                            $itemRows[] = $detailTable[$nextIndex];
                            $itemCount++;
                            $nextIndex++;
                        }
                        $batchGroups = [];
                        foreach($itemRows as $row) {
                            $batch = $row->batch_number;
                            if(!isset($batchGroups[$batch])) {
                                $batchGroups[$batch] = [];
                            }
                            $batchGroups[$batch][] = $row;
                        }
                        $totalItemRows = count($itemRows);
                        $isFirstRow = true;
                        
                    @endphp

                    @foreach($batchGroups as $batchNumber => $batchRows)
                        @foreach($batchRows as $rowIndex => $row)
                            <tr>
                                {{-- Item details - merged across ALL item rows --}}
                                @if($isFirstRow && $rowIndex === 0)
                                    <td style="text-align: center" class="bordertables" rowspan="{{ $totalItemRows }}">{{ ++$row_no }}</td>
                                    <td style="text-align: center" class="bordertables" rowspan="{{ $totalItemRows }}">
                                        {{ $row->ItemCode }}
                                    </td>
                                    <td style="text-align: center" class="bordertables" rowspan="{{ $totalItemRows }}">
                                        {{ $row->ItemName }}
                                    </td>
                                    <td style="text-align: center" class="bordertables" rowspan="{{ $totalItemRows }}">
                                        {{ $row->SKUNumber }}
                                    </td>
                                    <td style="text-align: center" class="bordertables" rowspan="{{ $totalItemRows }}">
                                        {{ $row->UOM }}
                                    </td>
                                    <td style="text-align: center" class="bordertables" rowspan="{{ $totalItemRows }}">
                                        {{ $row->Quantity }}
                                    </td>
                                    @php $isFirstRow = false; @endphp
                                @endif
                                
                                {{-- Batch Number - merged across same batch --}}
                                @if($rowIndex === 0)
                                    <td style="text-align: center" class="bordertables" rowspan="{{ count($batchRows) }}">
                                        {{ $batchNumber }}
                                    </td>
                                    <td style="text-align: center" class="bordertables" rowspan="{{ count($batchRows) }}">
                                        {{ $row->expiry_date}}
                                    </td>
                                    <td style="text-align: center" class="bordertables" rowspan="{{ count($batchRows) }}">
                                        {{ $row->received_qty}}
                                    </td>
                                    <td style="text-align: center" class="bordertables" rowspan="{{ count($batchRows) }}">
                                        {{ $row->serial_number }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                    @php $currentIndex = $nextIndex; @endphp 
                @endwhile 
                
            </tbody>
        </table>
        <br/>
        <div>Remark:  <u>{{$mem}}</u></div>
        <br/>
        <table style="width: 100%">
            <tr>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Prepared By</b></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Name: </b><u>{{$preparedby}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$transactiondate}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Signature: </b>____________________</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Purchased By</b></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Name: </b><u>{{$purchasedby}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Date: </b>____________________</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Signature: </b>____________________</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Delivered By</b></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Name: </b>_______________________</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Date: </b>____________________</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Signature: </b>____________________</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Checked By</b></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Name: </b><u>{{$checkedby}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$checkeddate}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Signature: </b>____________________</td>
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
                            <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$confirmeddate}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Signature: </b>____________________</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Received By</b></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Name: </b>_______________________</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Date: </b>_______________________</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bordertablessign"><b>Signature: </b>____________________</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
