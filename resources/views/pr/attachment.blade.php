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
<div style="text-align: center" class="doctitle">
    <b>Purchase Request / PR</b>
</div>
<table width="100%">
    <tr>
    <td style="width: 50%;">
        <table style="width: 100%;" cellspacing="0" class="items">
            <tbody>
                <tr>
                    <td class="blanktotal" colspan="2" style="text-align: center;"><b>Purchase Request Information</b></td>
                </tr>
                <tr>
                    <td class="blanktotal"><b>PR#</b></td>
                    <td class="blanktotal">{{ $totalprice->docnumber }}</td>
                </tr>
                <tr>
                    <td class="blanktotal"><b>Product Type</b></td>
                    <td class="blanktotal">{{ $totalprice->type }}</td>
                </tr>
                <tr>
                    <td class="blanktotal"><b>Prepare Date</b></td>
                    <td class="blanktotal">{{ $totalprice->date }}</td>
                </tr>
                <tr>
                    <td class="blanktotal"><b>Require Date</b></td>
                    <td class="blanktotal">{{ $totalprice->requiredate }}</td>
                </tr>
                
                <tr>
                    <td class="blanktotal"><b>Priority</b></td>
                    @switch($totalprice->priority)
                        @case(1)
                                <td class="blanktotal">High</td>
                            @break
                        @case(2)
                            <td class="blanktotal">Meduim</td>
                            @break
                            @case(3)
                            <td class="blanktotal">Low</td>
                            @break
                        @default
                            <td class="blanktotal">--</td>
                    @endswitch
                    
                </tr>
                
            </tbody>
        </table>
    </td>
    <td style="width: 50%;" >
        <table style="width: 100%;" cellspacing="0" class="items">
            <tbody>
                <tr>
                    <td class="blanktotal" colspan="2" style="text-align: center;"><b>Commodity Information</b></td>
                </tr>
                
                <tr>
                    <td class="blanktotal"><b>Requst Station</b></td>
                    <td class="blanktotal">{{$storename}}</td>
                </tr>
                @if ($totalprice->type=="Commodity")
                    <tr>
                        <td class="blanktotal"><b>Commodity Type</b></td>
                        <td class="blanktotal">{{ $totalprice->commudtytype }}</td>
                    </tr>
                    <tr>
                        <td class="blanktotal"><b>Commodity Source</b></td>
                        <td class="blanktotal">{{ $totalprice->coffeesource }}</td>
                    </tr>
                    <tr>
                        <td class="blanktotal"><b>Commodity Status</b></td>
                        <td class="blanktotal">{{ $totalprice->coffestat }}</td>
                    </tr>
                    
                @endif
                
            </tbody>
        </table>
    </td>
</tr>
</table>
<br/>
@if ($totalprice->type=="Goods")
    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
        <thead>
        <tr>
            <td width="5%"><b>#</b></td>
            <td width="15%"><b>Code</b></td>
            <td width="30%"><b>Name</b></td>
            <td width="10%"><b>SKU#.</b></td>
            <td width="10%"><b>QTY</b></td>
            <td width="15%"><b>EST. Price</b></td>
            <td width="15%"><b>Total Price</b></td>
        </tr>
        </thead>
        <tbody>
        <!-- ITEMS HERE -->
        @foreach ($pr as $item)
        <tr>
            <td class="blanktotal">{{ ++$count }}</td>   
            <td class="blanktotal">{{ $item->Code }}</td>
            <td class="blanktotal">{{ $item->Name }}</td>
            <td class="blanktotal">{{ $item->SKUNumber }}</td>
            <td class="blanktotal">{{ $item->qty }}</td>
            <td class="blanktotal">{{ number_format($item->price,2) }}</td>
            <td class="blanktotal">{{ number_format($item->totalprice,2) }}</td>
        </tr>
        @endforeach
            <tr>
                <td class="totals" colspan="5" rowspan="5" style="border-left-color: #FFFFFF; border-bottom-color:#FFFFFF; text-align:left"></td>
                <td class="totals"><b>Sub Total</b></td>
                <td class="totals cost"><b>{{number_format($totalprice->totalprice,2)}}</b></td>
            </tr>
            <tr>
                    <td class="totals"><b>Tax 15 % </b></td>
                    <td class="totals cost"><b>{{number_format($totalprice->tax,2)}}</b></td>
            </tr>
            <tr>
                    <td class="totals"><b>Contingency {{ $percent }} % </b></td>
                    <td class="totals cost"><b>{{number_format($totalprice->contingency,2)}}</b></td>
            </tr>
            <tr>
                <td class="totals"><b>Grand Total</b></td>
                <td class="totals cost"><b>{{number_format($totalprice->totalewithcontingency,2)}}</b></td>
            </tr>
            @if ($totalprice->withold>0)
                <tr>
                    <td class="totals"><b>withold 2%</b></td>
                    <td class="totals cost"><b>{{number_format($totalprice->withold,2)}}</b></td>
                </tr>
                <tr>
                    <td class="totals"><b>Net pay </b></td>
                    <td class="totals cost"><b>{{number_format($totalprice->net,2)}}</b></td>
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
            <td><b>Region-Zone-Woreda</b></td>
            <td><b>Process Type</b></td>
            <td><b>Crop Year</b></td>
            <td><b>Grade</b></td>
            <td><b>Feresula</b></td>
            <td><b>Est. Price</b></td>
            <td><b>Total</b></td>
        </tr>
        </thead>
        <tbody>
        <!-- ITEMS HERE -->
        @foreach ($pr as $item)
        <tr>
        <td class="blanktotal">{{ ++$count }}</td>   
        <td class="blanktotal">{{ $item->RZW }}</td>
        <td class="blanktotal">{{ $item->proccesstype }}</td>
        <td class="blanktotal">{{ $item->cropyear }}</td>
        <td class="blanktotal">{{ $item->grade }}</td>
        <td class="blanktotal">{{ number_format($item->feresula,2) }}</td>
        <td class="blanktotal">{{ number_format($item->price,2) }}</td>
        <td class="blanktotal">{{ number_format($item->totalprice,2) }}</td>
        </tr>
        @endforeach
        <tr>
            <td class="totals" colspan="4" style=" border-bottom-color:#FFFFFF; text-align:left"></td>
            <td class="totals"><b>Total</b></td>
            <td class="totals cost"><b>{{number_format($totalfersula,2)}} </b></td>
            <td class="totals cost"><b></b></td>
            <td class="totals cost"><b></b></td>
        </tr>
        <tr>
            <td class="totals" colspan="6" rowspan="6" style="border-left-color: #FFFFFF; border-bottom-color:#FFFFFF; text-align:left"><br><b><u>Amount in words</u>:-</b> {{ $amountinword }}</td>
            <td class="totals"><b>Sub Total</b></td>
            <td class="totals cost"><b>{{number_format($totalprice->totalprice,2)}}</b></td>
        </tr>
    @if ($totalprice->istaxable==1)
        <tr>
            <td class="totals"><b>Tax 15 % </b></td>
            <td class="totals cost"><b>{{number_format($totalprice->tax,2)}}</b></td>
        </tr>
    @endif
        
        <tr>
            <td class="totals"><b>Grand Total</b></td>
            <td class="totals cost"><b>{{number_format($totalprice->totalewithcontingency,2)}}</b></td>
        </tr>
            @if ($totalprice->withold>0)
                <tr>
                    <td class="totals"><b>withold 2%</b></td>
                    <td class="totals cost"><b>{{number_format($totalprice->withold,2)}}</b></td>
                </tr>
                <tr>
                    <td class="totals"><b>Net pay </b></td>
                    <td class="totals cost"><b>{{number_format($totalprice->net,2)}}</b></td>
                </tr>
                <tr>
                    <td class="totals"><b>Contingency {{ $percent }} % </b></td>
                    <td class="totals cost"><b>{{number_format($totalprice->contingency,2)}}</b></td>
                </tr>
            @endif
        <!-- END ITEMS HERE -->
        </tbody>
        </table>
@endif
<table style="width: 100%">

    <tr>
        <td colspan="3" style="width:100%;">
            @if( $totalprice->memo!='')
            <b>Note</b><br/>
            {{ $totalprice->memo }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="width: 33%">
            <table style="width: 100%">
                <tr>
                    <td class="" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Prepared By</u></b></div></td>
                </tr>
                
                <tr>
                    <td colspan="2" class=""><b>Name: </b><u>{{ $preparedby->user }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Date: </b><u>{{ $preparedby->time }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class="bordertablessign"><b>Signature: </b>__________________</td>
                </tr>
            </table>
        </td>
        @if(isset($verifyby->user))
            <td style="width: 33%">
            <table style="width: 100%">
                <tr>
                    <td class="headers" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Verify By</u></b></div></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Name: </b><u>{{ $verifyby->user }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Date: </b><u>{{ $verifyby->time }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Signature: </b>____________________</td>
                </tr>
            </table>
        </td>
        @endif
        @if(isset($reviewby->user))
            <td style="width: 33%">
            <table style="width: 100%">
                <tr>
                    <td class="" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Reviewed By</u></b></div></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Name: </b><u>{{ $reviewby->user }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Date: </b><u>{{ $reviewby->time }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class="bordertablessign"><b>Signature: </b>____________________</td>
                </tr>
            </table>
        </td>
        @endif
        @if(isset($approveby->user))
        <td style="width: 33%">
            <table style="width: 100%">
                <tr>
                    <td class="headers" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Approve By</u></b></div></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Name: </b><u>{{ $approveby->user }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Date: </b><u>{{ $approveby->time }}</u></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b>Signature: </b>____________________</td>
                </tr>
            </table>
        </td>
        @endif
</table>
</body>
</html>