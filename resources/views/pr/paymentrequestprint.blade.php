<html>
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
            font-size:12px;
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
        .fontprop
        {
            font-size: 12px;
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
            margin-top:-10px;
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<htmlpageheader name="myheader">
    <table>
        <tr>
            <td colspan="3">
                <table class="headerTable">
                    <tr>
                        <td colspan="6" class="headerTitles" style="text-align: center;"><b>{{$compInfo->Name}}</b></td>
                    </tr>
                    <tr>
                        <td><b>TIN: </b></td>
                        <td colspan="2">{{$compInfo->TIN}}</td>
                        <td><b>Address: </b></td>
                        <td colspan="2">{{$compInfo->Address}}</td>
                        
                    </tr>
                    <tr>
                        <td><b>VAT No.: </b></td>
                        <td colspan="2">{{$compInfo->VATReg}}</td>
                        <td><b>Email: </b></td>
                        <td colspan="2">{{$compInfo->Email}}</td>
                    </tr>
                    <tr>
                        <td style="width: 7%;"><b>Phone: </b></td>
                        <td style="width: 43%;" colspan="2">{{$compInfo->Phone}},{{$compInfo->OfficePhone}}</td>
                        <td style="width: 7%;"><b>Website: </b></td>
                        <td style="width: 43%;" colspan="2">{{$compInfo->Website}}</td>   
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
            <td colspan="2"><b>Printed on: </b>{{$due_date}}
        </td>
        <td style="text-align: right;">Page {PAGENO} of {nb}</td>
        </tr>
    </table>

</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" value="on" />
        <br>
        <table>
            <tr>
                <td colspan="2" class="headers doctitle"><b>Payment Request(PYR)</b></td>
            </tr>
            <tr>
                <td style="width: 33%;">
                    <table style="width: 100%;" class="">
                        <tbody>
                            <tr class="headerHeight">
                                <td class="bordertables" style="height:20px; text-align: center; vertical-align: middle;" colspan="2">
                                    <div style="height:20px;"><b>Supplier Information</b></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%;" class="bordertables"><b>Category:</b></td>
                                <td style="width: 75%;" class="bordertables">{{ $customer->CustomerCategory }}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Name:</b></td>
                                <td class="bordertables">{{ $customer->Name }}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>TIN:</b></td>
                                <td class="bordertables">{{ $customer->TinNumber }}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>VAT No.:</b></td>
                                <td class="bordertables">{{ $customer->VatNumber }}</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </td>
                <td style="width: 67%;">
                    <table style="width: 100%;" class="">
                        
                            <tr class="headerHeight">
                                <td class="bordertables" style="height:20px; text-align: center; vertical-align: middle;" colspan="4">
                                    <div style="height:20px;"><b>Payment Request Information</b></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Payment Request#:</b></td>
                                <td class="bordertables">{{ $totalprice->docno }}</td>
                                @if ($purchaseordertype=='Commodity')
                                    <td class="bordertables"><b>Commodity Source:</b></td>
                                    <td class="bordertables">{{ $totalprice->commoditysource }}</td>
                                @endif
                                
                            </tr>
                            
                            <tr>
                                <td class="bordertables"><b>Reference:</b></td>
                                <td class="bordertables">
                                    @switch($totalprice->reference)
                                        @case('PO')
                                            Purchase Order
                                            @break
                                    
                                        @default
                                            Direct
                                    @endswitch
                                    
                                </td>
                                @if ($purchaseordertype=='Commodity')
                                    <td class="bordertables"><b>Commodity Type:</b></td>
                                    <td class="bordertables">{{ $totalprice->commoditype }}</td>
                                @endif
                                
                            </tr>
                            
                            <tr>
                                <td class="bordertables"><b>Purchase Order #:</b></td>
                                <td class="bordertables">{{ $podoc }}</td>
                                @if ($purchaseordertype=='Commodity')
                                    <td class="bordertables"><b>Commodoty Status:</b></td>
                                    <td class="bordertables">{{ $totalprice->commoditystatus }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Payment Reference:</b></td>
                                <td class="bordertables"> @switch($totalprice->paymentreference)
                                                            @case('GRV')
                                                                Good Recieving
                                                                @break
                                                            @case('PI')
                                                                Purchase Invoice
                                                            @break;
                                                            @default
                                                                Purchase Order
                                                        @endswitch</td>
                                @if ($purchaseordertype=='Commodity')      
                                    <td class="bordertables"><b>Prepare Date:</b></td>
                                    <td class="bordertables">{{ $totalprice->date }}</td>
                                @endif
                            </tr>
                            @if ($purchaseordertype=='Goods')     
                            <tr>
                                <td class="bordertables"><b>Prepare Date:</b></td>
                                <td class="bordertables">{{ $totalprice->date }}</td>
                            </tr>
                            @endif
                    </table>
                </td>
                
            </tr>
        </table>
        <br/>
        @if ($purchaseordertype=='Goods')
                    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
                            <thead>
                            <tr>
                                <td class="bordertables"><b>#</b></td>
                                <td class="bordertables"><b>Item Code</b></td>
                                <td class="bordertables"><b>Item Name</b></td>
                                <td class="bordertables"><b>Barcode</b></td>
                                <td class="bordertables"><b>UOM</b></td>
                                <td class="bordertables"><b>QTY.</b></td>
                                <td class="bordertables"><b>Unit-Price</b></td>
                                <td class="bordertables"><b>Total</b></td>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- ITEMS HERE -->
                            @php
                                $numofbag=0;
                                $ttprice=0;
                                $tt=0;
                            @endphp
                            @foreach ($comiditylist as $item)
                            <tr>
                                <td style="text-align: center" class="bordertables">{{ ++$count }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->Code }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->Name }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->SKUNumber }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->uomname }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->qty }}</td>
                                <td style="text-align: center" class="bordertables">{{ number_format($item->price,2) }}</td>
                                <td style="text-align: center" class="bordertables">{{ number_format($item->Total,2) }}</td>
                            </tr>
                                {{$numofbag+=$item->qty}}
                                {{$tt+=$item->price}}
                                {{$ttprice+=$item->Total}}
                            @endforeach
                                <tr>
                                    <td style="text-align: right;" colspan="5" class="bordertables">Total</td>
                                    <td class="bordertables"><b>{{ number_format($numofbag,2) }}</b></td>
                                    <td class="bordertables"><b>{{ number_format($tt,2) }}</b></td>
                                    <td class="bordertables"><b>{{ number_format($ttprice,2) }}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="4" rowspan="4">
                                        <table style="width:100%;">
                                                        
                                                        <tr>
                                                            <td colspan="4" style="text-align: center;" class="bordertables"><b>Payment Information</b><br>
                                                                
                                                            </td> 
                                                        </tr>
                                                        <tr>
                                                            <td class="bordertables" colspan="2" style="text-align: center; width:25%;"><label strong style="font-size: 16px;"><b>Payment Request</b></label></td>
                                                            <td  class="bordertables" colspan="2" style="text-align: center; width:25%;"><label strong style="font-size: 16px;"><b>Payment History</b></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Mode</label></td>
                                                            <td class="bordertables" style="text-align: center; width:25%;">{{ $totalprice->paymentmode }}</td>
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Total Amount</label></td>
                                                            <td class="bordertables" style="text-align: center; width:25%;">{{ number_format($totalprice->netpay,2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">To be paid</label></td>
                                                            <td class="bordertables" style="text-align: center; width:25%;"><b><u>{{ number_format($totalprice->Amount,2) }}</u></b></td>
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Paid Amount</label></td>
                                                            <td  class="bordertables" style="text-align: center; width:25%;">{{ number_format($paidamount,2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Status</label></td>
                                                            <td class="bordertables" style="text-align: center; width:25%;">{{ $totalprice->paymentstatus }}</td>
                                                            
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Remaining Amount</label></td>
                                                            <td  class="bordertables" style="text-align: center; width:25%;">{{ number_format($remainamount,2) }}</td>
                                                        </tr> 
                                                        
                                                    </table>
                                    </td>

                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Sub Total</b></td>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables">{{ number_format($totalprice->subtotal,2) }}</td>
                                </tr>
                                @if ($totalprice->istaxable==1)
                                    <tr>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Tax(15%)</b></td>
                                        <td  colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($totalprice->tax,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Grand Total</b></td>
                                        <td  colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($totalprice->grandtotal,2)}}</td>
                                    </tr>
                                @endif
                                @if ($totalprice->withold>0)
                                    <tr>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>withold 2%</b></td>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($totalprice->withold,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Net Pay</b></td>
                                        <td  colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($totalprice->netpay,2)}}</td>
                                    </tr>
                                @endif
                                
                            <!-- END ITEMS HERE -->
                            </tbody>

                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <b>Purpose of Payment:</b> {{ $totalprice->purpose }}
                                    </td>
                                </tr>
                            </table>

        @else
                @switch($totalprice->paymentreference)
                    @case('GRV')
                    @case('PI')
                            <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
                            <thead>
                            <tr>
                                <td class="bordertables"><b>#</b></td>
                                <td class="bordertables"><b>GRV#</b></td>
                                <td class="bordertables"><b>PIV#</b></td>
                                <td class="bordertables"><b>Commodity</b></td>
                                <td class="bordertables"><b>Grade</b></td>
                                <td class="bordertables"><b>Preparation</b></td>
                                <td class="bordertables"><b>Year</b></td>
                                <td class="bordertables"><b>UOM-Bag</b></td>
                                <td class="bordertables"><b>No of Bag</b></td>
                                <td class="bordertables"><b>NET KG</b></td>
                                <td class="bordertables"><b>Feresula</b></td>
                                <td class="bordertables"><b>Unit Price</b></td>
                                <td class="bordertables"><b>Total</b></td>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- ITEMS HERE -->
                            @php
                                $numofbag=0;
                                $totalkg=0;
                                $totalton=0;
                                $totalferesula=0;
                                $ttprice=0;
                                $tt=0;
                                
                            @endphp
                            @foreach ($comiditylist as $item)
                            <tr>
                                <td style="text-align: center" class="bordertables">{{ ++$count }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->DocumentNumber }}</td>  
                                <td style="text-align: center" class="bordertables">{{ $item->pidocno }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->Origin }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->Grade }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->ProcessType }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->CropYear }}</td>
                                <td style="text-align: center" class="bordertables">{{ $item->uomname }}</td>
                                <td style="text-align: center" class="bordertables">{{ number_format($item->NumOfBag,2) }}</td>
                                <td style="text-align: center" class="bordertables">{{ number_format($item->TotalKg,2) }}</td>
                                <td style="text-align: center" class="bordertables">{{ number_format($item->Feresula,2) }}</td>
                                <td style="text-align: center" class="bordertables">{{ number_format($item->Price,2) }}</td>
                                <td style="text-align: center" class="bordertables">{{ number_format($item->TotalPrice,2) }}</td>
                            </tr>
                                {{$numofbag+=$item->NumOfBag}}
                                {{$totalkg+=$item->TotalKg}}
                                {{$totalton+=$item->ton}}
                                {{$totalferesula+=$item->Feresula}}
                                {{$tt+=$item->Price}}
                                {{$ttprice+=$item->TotalPrice}}

                            @endforeach
                                <tr>
                                    <td style="text-align: right;" colspan="8" class="bordertables">Total</td>
                                    <td class="bordertables"><b>{{ number_format($numofbag,2) }}</b></td>
                                    <td class="bordertables"><b>{{ number_format($totalkg,2) }}</b></td>
                                    <td class="bordertables"><b>{{ number_format($totalferesula,2) }}</b></td>
                                    <td class="bordertables"><b>{{ number_format($tt,2) }}</b></td>
                                    <td class="bordertables"><b>{{ number_format($ttprice,2) }}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="9" rowspan="9">
                                        <table style="width:100%;">
                                                        
                                                        <tr>
                                                            <td colspan="4" style="text-align: center;" class="bordertables"><b>Payment Information</b><br>
                                                                
                                                            </td> 
                                                        </tr>
                                                        <tr>
                                                            <td class="bordertables" colspan="2" style="text-align: center; width:25%;"><label strong style="font-size: 16px;"><b>Payment Request</b></label></td>
                                                            <td  class="bordertables" colspan="2" style="text-align: center; width:25%;"><label strong style="font-size: 16px;"><b>Payment History</b></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Mode</label></td>
                                                            <td class="bordertables" style="text-align: center; width:25%;">{{ $totalprice->paymentmode }}</td>
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Total Amount</label></td>
                                                            <td class="bordertables" style="text-align: center; width:25%;">{{ number_format($totalprice->netpay,2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">To be paid</label></td>
                                                            <td class="bordertables" style="text-align: center; width:25%;"><b><u>{{ number_format($totalprice->Amount,2) }}</u></b></td>
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Paid Amount</label></td>
                                                            <td  class="bordertables" style="text-align: center; width:25%;">{{ number_format($paidamount,2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Status</label></td>
                                                            <td class="bordertables" style="text-align: center; width:25%;">{{ $totalprice->paymentstatus }}</td>
                                                            
                                                            <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Remaining Amount</label></td>
                                                            <td  class="bordertables" style="text-align: center; width:25%;">{{ number_format($remainamount,2) }}</td>
                                                        </tr> 
                                                        
                                                    </table>
                                    </td>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Sub Total</b></td>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables">{{ number_format($totalprice->subtotal,2) }}</td>
                                </tr>
                                @if ($totalprice->istaxable==1)
                                    <tr>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Tax(15%)</b></td>
                                        <td  colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($totalprice->tax,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Grand Total</b></td>
                                        <td  colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($totalprice->grandtotal,2)}}</td>
                                    </tr>
                                @endif
                                @if ($totalprice->withold>0)
                                    <tr>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>withold 2%</b></td>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($totalprice->withold,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Net Pay</b></td>
                                        <td  colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($totalprice->netpay,2)}}</td>
                                    </tr>
                                @endif
                                
                            <!-- END ITEMS HERE -->
                            </tbody>

                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <b>Purpose of Payment:</b> {{ $totalprice->purpose }}
                                    </td>
                                </tr>
                            </table>
                    @break

                    @case('PO')
                        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
                            <thead>
                                    <tr>
                                        <td class="bordertables"><b>#</b></td>
                                        <td class="bordertables"><b>Commodity</b></td>
                                        <td class="bordertables"><b>Grade</b></td>
                                        <td class="bordertables"><b>Preparation</b></td>
                                        <td class="bordertables"><b>Year</b></td>
                                        <td class="bordertables"><b>UOM-Bag</b></td>
                                        <td class="bordertables"><b>No of Bag</b></td>
                                        <td class="bordertables"><b>Net KG</b></td>
                                        <td class="bordertables"><b>Feresula</b></td>
                                        <td class="bordertables"><b>Price</b></td>
                                        <td class="bordertables"><b>Total</b></td>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $numofbag=0;
                                        $totalkg=0;
                                        $totalton=0;
                                        $totalferesula=0;
                                        $ttprice=0;
                                        $tt=0;
                                    @endphp
                                    @foreach ($comiditylist as $item)
                                        <tr>
                                            <td style="text-align: center" class="bordertables">{{ ++$count }}</td>   
                                            <td style="text-align: center" class="bordertables">{{ $item->Origin }}</td>
                                            <td style="text-align: center" class="bordertables">{{ $item->Grade }}</td>
                                            <td style="text-align: center" class="bordertables">{{ $item->ProcessType }}</td>
                                            <td style="text-align: center" class="bordertables">{{ $item->CropYear }}</td>
                                            <td style="text-align: center" class="bordertables">{{ $item->uomname }}</td>
                                            <td style="text-align: center" class="bordertables">{{ $item->NumOfBag }}</td>
                                            <td style="text-align: center" class="bordertables">{{ $item->NetKg }}</td>
                                            
                                            <td style="text-align: center" class="bordertables">{{ $item->Feresula }}</td>
                                            <td style="text-align: center" class="bordertables">{{ number_format($item->Price,2) }}</td>
                                            <td style="text-align: center" class="bordertables">{{ number_format($item->TotalPrice,2) }}</td>
                                        </tr>
                                            {{$numofbag+=$item->NumOfBag}}
                                            {{$totalkg+=$item->NetKg}}
                                            
                                            {{$totalferesula+=$item->Feresula}}
                                            {{$tt+=$item->Price}}
                                            {{$ttprice+=$item->TotalPrice}}
                                    @endforeach
                                        <tr>
                                            <td style="text-align: right;" colspan="6" class="bordertables">Total</td>
                                            <td class="bordertables"><b>{{ number_format($numofbag,2) }}</b></td>
                                            <td class="bordertables"><b>{{ number_format($totalkg,2) }}</b></td>
                                            <td class="bordertables"><b>{{ number_format($totalferesula,2) }}</b></td>
                                            <td class="bordertables"><b>{{ number_format($tt,2) }}</b></td>
                                            <td class="bordertables"><b>{{ number_format($ttprice,2) }}</b></td>
                                        </tr>
                                        <tr>    
                                                <td colspan="7" rowspan="7">
                                                    <table style="width:100%;">
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;" class="bordertables"><b>Payment Information</b>
                                                                    <br>
                                                                    
                                                                </td> 
                                                            </tr>
                                                            <tr>
                                                                <td class="bordertables" colspan="2" style="text-align: center; width:25%;"><label strong style="font-size: 16px;"><b>Payment Request</b></label></td>
                                                                <td  class="bordertables" colspan="2" style="text-align: center; width:25%;"><label strong style="font-size: 16px;"><b>Payment History</b></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Mode</label></td>
                                                                <td class="bordertables" style="text-align: center; width:25%;">{{ $totalprice->paymentmode }}</td>
                                                                <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Total Amount</label></td>
                                                                <td class="bordertables" style="text-align: center; width:25%;">{{ number_format($pototalprice->netpay,2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">To be paid</label></td>
                                                                <td class="bordertables" style="text-align: center; width:25%;"><b><u>{{ number_format($totalprice->Amount,2) }}</u></b></td>
                                                                <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Paid Amount</label></td>
                                                                <td  class="bordertables" style="text-align: center; width:25%;">{{ number_format($paidamount,2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                
                                                            </tr>
                                                            <tr>
                                                                <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Status</label></td>
                                                                <td class="bordertables" style="text-align: center; width:25%;">{{ $totalprice->paymentstatus }}</td>
                                                                <td class="bordertables" style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Remaining Amount</label></td>
                                                                <td  class="bordertables" style="text-align: center; width:25%;">{{ number_format($remainamount,2) }}</td>
                                                            </tr> 
                                                            
                                                    </table>
                                                </td>
                                                <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Sub Total</b></td>
                                                <td colspan="2" style="font-size: 14px;" id="" class="bordertables">{{ number_format($pototalprice->subtotal,2) }}</td>
                                        </tr>
                                                    
                                            @if ($pototalprice->istaxable==1)
                                                <tr>
                                                    <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Tax(15%)</b></td>
                                                    <td colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($pototalprice->tax,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Grand Total</b></td>
                                                    <td colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($pototalprice->grandtotal,2)}}</td>
                                                </tr>
                                            @endif
                                            @if ($pototalprice->withold>0)
                                            <tr>
                                                <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>withold 2%</b></td>
                                                <td colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($pototalprice->withold,2)}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-size: 14px;" id="" class="bordertables"><b>Net Pay</b></td>
                                                <td colspan="2" style="font-size: 14px;" id="" class="bordertables">{{number_format($pototalprice->netpay,2)}}</td>
                                            </tr>
                                        @endif
                                </tbody>
                        </table>
                        <table style="width: 100%">
                            <tr>
                                <td>
                                    <b>Purpose of Payment:</b> {{ $totalprice->purpose }}
                                </td>
                            </tr>
                        </table>
                    @break
                
                    @default
                        <table style="width:100%;">
                            <tr>
                                <td style="width: 40%">
                                    <table>
                                            <tr>
                                                <td colspan="2" style="text-align: center;" class="bordertables"><b>Payment Information</b></td> 
                                            </tr>
                                            <tr>
                                                <td class="bordertables"><label strong style="font-size: 16px;">Payment Reference</label></td>
                                                <td class="bordertables"><b>Direct</b></td>
                                            </tr> 
                                            <tr>
                                                <td  class="bordertables">Payment Mode</td>
                                                <td  class="bordertables"><b>Pre Finance</b></td>
                                            </tr>       
                                            <tr>
                                                <td class="bordertables">To be paid</td>
                                                <td class="bordertables"><b>{{ number_format($totalprice->Amount,2) }}</b></td>
                                            </tr>
                                            <tr>
                                                <td class="bordertables">Payment Status</td>
                                                <td class="bordertables"><b>Direct</b></td>
                                            </tr>
                                    </table>
                                </td>
                                <td style="width: 60%;">
                                        
                                        <table style="width: 100%">
                                            <tr>
                                                <td>
                                                    <b>Purpose of Payment:</b> {{ $totalprice->purpose }}
                                                </td>
                                                
                                            </tr>
                                        </table>
                                </td>
                            </tr>
                            
                        </table>
                @endswitch
        @endif
        
    @if ($totalprice->memo!='')
        <table style="width: 100%">
            <tr>
                <td>
                    <b>Memo:</b> {{ $totalprice->memo }}
                </td>
            </tr>
        </table>
    @endif
    
<table style="width: 100%">
    <tr>
        <td style="width: 33%">
            <table style="width: 100%">
                <tr>
                    <td class="" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Prepared By</u></b></div></td>
                </tr>
                
                <tr>
                    <td colspan="2" class=""><b>Name: </b><u>{{ $preparedby }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Date: </b><u>{{ $updated_at }}</u></td>
                </tr>
                
            </table>
        </td>

        <td style="width: 33%">
            <table style="width: 100%">
                <tr>
                    <td class="" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Verify By</u></b></div></td>
                </tr>
                
                <tr>
                    <td colspan="2" class=""><b>Name: </b><u>{{ $verifyby }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Date: </b><u>{{ $updated_at }}</u></td>
                </tr>
            
            </table>
        </td>
        <td style="width: 33%">
            <table style="width: 100%">
                <tr>
                    <td class="" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Reviewed By</u></b></div></td>
                </tr>
                    
                <tr>
                    <td colspan="2" class=""><b>Name: </b><u>{{ $revieweby }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Date: </b><u>{{ $updated_at }}</u></td>
                </tr>
                
            </table>
        </td>
        <td style="width: 33%">
            <table style="width: 100%">
                <tr>
                    <td class="" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Approved By</u></b></div></td>
                </tr>
                
                <tr>
                    <td colspan="2" class=""><b>Name: </b><u>{{ $aproveby }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Date: </b><u>{{ $updated_at }}</u></td>
                </tr>
                
            </table>
        </td>
        
    </tr>
</table>
</body>
</html>