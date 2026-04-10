<html>
<head>
<style>
body {font-family: sans-serif;
	font-size: 10pt;
}
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #000000;
}
td { vertical-align: top; }
.items td {
	border-left: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
table thead td { 
    background-color: #EEEEEE;
	text-align: center;
	border: 0.1mm solid #000000;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #000000;
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}
.items td.cost {
	text-align: "." center;
    border: 1px solid black;
}

.headerTable
{
    border-bottom: 1px solid black;
    margin-top:-30px;
}
.headerTitles
{
    text-align:center;
    font-size:1.7rem;
}
.doctitle
{
    font-size:1.5rem;
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
                    <td rowspan="4"></td>
                </tr>
                <tr>
                    <td style="width: 10%;"><b>TIN No. </b></td>
                    <td style="width: 40%;" colspan="2">{{$compInfo->TIN}}</td>
                    <td style="width: 12%;"><b>Address: </b></td>
                    <td style="width: 38%;" colspan="2">{{$compInfo->Address}} </td>
                </tr>
                <tr>
                    <td><b>VAT No: </b></td>
                    <td colspan="2">{{$compInfo->VATReg}} </td>
                    <td><b>Email: </b></td>
                    <td colspan="2"> {{$compInfo->Email}}</td>
                </tr>
                <tr>
                    <td><b>Phone:</b></td>
                    <td colspan="2">{{$compInfo->Phone}},{{$compInfo->OfficePhone}}</td>
                    <td><b>Website. </b></td>
                    <td colspan="2">{{$compInfo->Website}}</td>
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
<div style="text-align: center" class="doctitle"><br>
    <b><u>Purchase Order / PO</u></b>
</div>

        <table style="width: 100%;text-align:right;" cellspacing="0" class="">
            <tbody>
                <tr>
                    <td class="" style="width: 80%"><b>Purchase Order#:</b></td>
                    <td class="" style="width: 20%">{{ $totalprice->porderno }}</td>
                </tr>
                <tr>
                    <td class=""><b>Order Date:</b></td>
                    <td class="">{{ $totalprice->orderdate }}</td>
                </tr>
                <tr>
                    <td class=""><b>Delivery Date:</b></td>
                    <td class="">{{$totalprice->deliverydate }}</td>
                </tr>
            </tbody>
        </table>

<div style="text-align: left" class="doctitle">
    @if ($customername==-1)
        <b>To</b>___________________________________________________________________
    @else
        <b>To</b>  <u>{{ $customername }}</u>
    @endif
    
</div>
<table style="width: 100%">
    <tr>
        <td>
        {!! $settingsval->poheaderdescription !!}
        </td>
    </tr>
</table>
<br/>
    @if ($purchaseordertype=="Goods")
        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            <thead>
            <tr>
                <td><b>#</b></td>
                <td><b>Item Code</b></td>
                <td><b>Item Name</b></td>
                <td><b>Barcode</b></td>
                <td><b>UOM</b></td>
                <td><b>QTY.</b></td>
                <td><b>Unit Price</b></td>
                <td><b>Total</b></td>
            </tr>
            </thead>
            <tbody>
                @php
                    $numofbag=0;
                    $ttprice=0;
                    $tt=0;
                @endphp
            <!-- ITEMS HERE -->
            @foreach ($comiditylist as $item)
            <tr>
                <td class="blanktotal">{{ ++$count }}</td>   
                <td class="blanktotal">{{ $item->Code }}</td>
                <td class="blanktotal">{{ $item->Name }}</td>
                <td class="blanktotal">{{ $item->SKUNumber }}</td>
                <td class="blanktotal">{{ $item->uomname }}</td>
                <td class="blanktotal">{{ $item->qty }}</td>
                <td class="blanktotal">{{ number_format($item->price,2) }}</td>
                <td class="blanktotal">{{ number_format($item->Total,2) }}</td>
            </tr>
                {{$numofbag+=$item->qty}}
                {{$tt+=$item->price}}
                {{$ttprice+=$item->Total}}
            @endforeach
            <tr>
                <td style="text-align: right;" colspan="5" class="blanktotal">Total</td>
                <td class="blanktotal"><b>{{ number_format($numofbag,2) }}</b></td>
                <td class="blanktotal"><b>{{ number_format($tt,2) }}</b></td>
                <td class="blanktotal"><b>{{ number_format($ttprice,2) }}</b></td>
            </tr>
                <tr>
                    <td class="totals" colspan="5" rowspan="5" style="border-left-color: #FFFFFF; border-bottom-color:#FFFFFF; text-align:left"><br><b><u>Amount in words:</u></b> {{ $amountinword }}</td>
                    <td colspan="2" class="totals"><b>Sub Total</b></td>
                    <td colspan="2" class="totals cost">{{ number_format($totalprice->subtotal,2) }}</td>
                </tr>
                @if ($totalprice->istaxable==1)
                    <tr>
                        <td colspan="2" class="totals"><b>Tax</b></td>
                        <td colspan="2" class="totals cost">{{number_format($totalprice->tax,2)}}</td>
                    </tr>
                <tr>
                    <td colspan="2" class="totals"><b>Grand Total</b></td>
                    <td colspan="2" class="totals cost">{{number_format($totalprice->grandtotal,2)}}</td>
                </tr>
                @endif
                @if ($totalprice->withold>0)
                    <tr>
                    <td colspan="2" class="totals"><b>withold 2%</b></td>
                    <td colspan="2" class="totals cost">{{number_format($totalprice->withold,2)}}</td>
                </tr>
                <tr>
                    <td colspan="2" class="totals"><b>Net Pay</b></td>
                    <td colspan="2" class="totals cost">{{number_format($totalprice->netpay,2)}}</td>
                </tr>
                @endif
                
            <!-- END ITEMS HERE -->
            </tbody>
        </table>
    @else
        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            <thead>
            <tr>
                <td><b>#</b></td>
                <td><b>Commodity</b></td>
                <td><b>Grade</b></td>
                <td><b>Preparation</b></td>
                <td><b>Crop Year</b></td>
                <td><b>UOM-Bag</b></td>
                <td><b>No of Bag</b></td>
                <td><b>Net Kg</b></td>
                <td><b>TON</b></td>
                <td><b>Feresula</b></td>
                <td><b>Unit Price</b></td>
                <td><b>Total</b></td>
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
            <!-- ITEMS HERE -->
            @foreach ($comiditylist as $item)
            <tr>
                <td class="blanktotal">{{ ++$count }}</td>   
                <td class="blanktotal">{{ $item->origin }}</td>
                <td class="blanktotal">{{ $item->grade }}</td>
                <td class="blanktotal">{{ $item->proccesstype }}</td>
                <td class="blanktotal">{{ $item->cropyear }}</td>
                <td class="blanktotal">{{ $item->uomname }}</td>
                <td class="blanktotal">{{ $item->qty }}</td>
                <td class="blanktotal">{{ $item->netkg }}</td>
                <td class="blanktotal">{{ $item->ton }}</td>
                <td class="blanktotal">{{ $item->feresula }}</td>
                <td class="blanktotal">{{ number_format($item->price,2) }}</td>
                <td class="blanktotal">{{ number_format($item->Total,2) }}</td>
            </tr>
                {{$numofbag+=$item->qty}}
                {{$totalkg+=$item->netkg}}
                {{$totalton+=$item->ton}}
                {{$totalferesula+=$item->feresula}}
                {{$tt+=$item->price}}
                {{$ttprice+=$item->Total}}
            @endforeach
            <tr>
                <td style="text-align: right;" colspan="6" class="blanktotal">Total</td>
                <td class="blanktotal"><b>{{ number_format($numofbag,2) }}</b></td>
                <td class="blanktotal"><b>{{ number_format($totalkg,2) }}</b></td>
                <td class="blanktotal"><b>{{ number_format($totalton,2) }}</b></td>
                <td class="blanktotal"><b>{{ number_format($totalferesula,2) }}</b></td>
                <td class="blanktotal"><b>{{ number_format($tt,2) }}</b></td>
                <td class="blanktotal"><b>{{ number_format($ttprice,2) }}</b></td>
            </tr>
                <tr>
                    <td class="totals" colspan="8" rowspan="8" style="border-left-color: #FFFFFF; border-bottom-color:#FFFFFF; text-align:left"><br><b><u>Amount in words:</u></b> {{ $amountinword }}</td>
                    <td colspan="2" class="totals"><b>Sub Total</b></td>
                    <td colspan="2" class="totals cost">{{ number_format($totalprice->subtotal,2) }}</td>
                </tr>
                @if ($totalprice->istaxable==1)
                    <tr>
                        <td colspan="2" class="totals"><b>Tax</b></td>
                        <td colspan="2" class="totals cost">{{number_format($totalprice->tax,2)}}</td>
                    </tr>
                <tr>
                    <td colspan="2" class="totals"><b>Grand Total</b></td>
                    <td colspan="2" class="totals cost">{{number_format($totalprice->grandtotal,2)}}</td>
                </tr>
                @endif
                @if ($totalprice->withold>0)
                    <tr>
                    <td colspan="2" class="totals"><b>withold 2%</b></td>
                    <td colspan="2" class="totals cost">{{number_format($totalprice->withold,2)}}</td>
                </tr>
                <tr>
                    <td colspan="2" class="totals"><b>Net Pay</b></td>
                    <td colspan="2" class="totals cost">{{number_format($totalprice->netpay,2)}}</td>
                </tr>
                @endif
                
            <!-- END ITEMS HERE -->
            </tbody>
        </table>
    @endif
    

<table style="width: 100%">
    <tr>
        <td>
            {!! $settingsval->pofooterdescription !!}
        </td>
    </tr>
</table>
<table style="width: 100%">
    <tr>
        <td style="width: 33%">
            <table style="width: 100%">
                <tr>
                    <td class="" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Approved By</u></b></div></td>
                </tr>
                
                <tr>
                    <td colspan="2" class=""><b>Name: </b><u>{{ $username }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Date: </b><u>{{ $updated_at }}</u></td>
                </tr>
                
            </table>
        </td>
        
            <td style="width: 33%">
            <table style="width: 100%">
                <tr>
                    <td class="headers" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Recieved By</u></b></div></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Name: </b>________________________________</td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Date: </b>_________________________________</td>
                </tr>
                <tr>
                    <td colspan="2" class="bordertablessign"><b>Signature: </b>___________________________I agree to supply in accordance with the specified order</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>