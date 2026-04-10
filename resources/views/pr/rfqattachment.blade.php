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
        {{-- <tr>
            <td><b>Thank you for your time and consideration. We look forward to recieving your proposals</b></td>
        </tr> --}}
        
        <tr>
            
            <td colspan="2"><b>Printed on: </b>{{$due_date}} </td>
        <td style="text-align: right;">Page {PAGENO} of {nb}</td>
        </tr>
    </table>

</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" value="on" />
<div style="text-align: center" class="doctitle">
    <b>Request For Quotation / RFQ</b>
</div>

        <table style="width: 100%;text-align:right;" cellspacing="0" class="">
            <tbody>
                <tr>
                    <td class="" style="width: 80%"><b>RfQ#</b></td>
                    <td class="" style="widows: 20%;">{{ $rfq->documentumber }}</td>
                </tr>
                <tr>
                    <td class=""><b>Prepare Date</b></td>
                    <td class="">{{ $totalprice->date }}</td>
                </tr>
                <tr>
                    <td class=""><b>Dead Line</b></td>
                    <td class="">{{ $totalprice->requiredate }}</td>
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
        {!! $settingsval->headerdescription !!}
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
            <td width="15%"><b>Price/unit</b></td>
            <td width="15%"><b>Total</b></td>
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
            <td class="blanktotal"></td>
            <td class="blanktotal"></td>
        </tr>
        @endforeach
            <tr>
                <td class="totals" colspan="5" rowspan="5" style="border-left-color: #FFFFFF; border-bottom-color:#FFFFFF; text-align:left"></td>
                <td class="totals"><b>Total</b></td>
                <td class="totals cost"></td>
            </tr>
        <!-- END ITEMS HERE -->
        </tbody>
        </table>
@else
    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="6">
        <thead>
        <tr>
            <<td><b>#</b></td>
            <td><b>Region-Zone-Woreda</b></td>
            <td><b>Process Type</b></td>
            <td><b>Crop Year</b></td>
            <td><b>Grade</b></td>
            <td><b>Feresula</b></td>
            <td><b>Unit Price</b></td>
            <td><b>Total</b></td>
        </tr>
        </thead>
        <tbody>
        <!-- ITEMS HERE -->
        @foreach ($pr as $item)
        <tr>
        <td class="blanktotal">{{ ++$count }}</td>   
        <td class="blanktotal" style="width: 25%;">{{ $item->RZW }}</td>
        <td class="blanktotal" style="width: 15%;">{{ $item->proccesstype }}</td>
        <td class="blanktotal" style="width: 12%;">{{ $item->cropyear }}</td>
        <td class="blanktotal">{{ $item->grade }}</td>
        <td class="blanktotal">{{ number_format($item->feresula,2) }}</td>
        <td class="blanktotal" style="width: 15%;"></td>
        <td class="blanktotal" style="width: 15%;"></td>
        </tr>
        @endforeach
        <tr>
            <td class="totals" colspan="6" rowspan="6" style="border-left-color: #FFFFFF; border-bottom-color:#FFFFFF; text-align:left"><br><br><b><u>Amount in Words:-</u></b>__________________________________________________________________</td>
            <td class="totals"><b>Sub Total</b></td>
            <td class="totals"><b></b></td>
        </tr>
        <tr>
            <td class="totals"><b>Tax 15 % </b></td>
            <td class="totals cost"><b></b></td>
        </tr>
        <tr>
            <td class="totals"><b>Grand Total </b></td>
            <td class="totals cost"><b></b></td>
        </tr>
        <!-- END ITEMS HERE -->
        </tbody>
        </table>
@endif
<table style="width: 100%">
    
    <tr>
        <td>
            {!! $settingsval->footerdescription !!}
        </td>
    </tr>
    @if ($samplerequore==="Required")
        <tr>
            <td>
                <b>* It is mandatory to submit a sample as prescribed</b>
            </td>
        </tr>
    @endif
</table>

<table style="width: 100%">
    <tr>
    
    @if(isset($approveby))
            <td style="width: 50%">
                <table style="width: 100%">
                    <tr>
                        <td class="headers" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>RFQ Recieved By</u></b></div></td>
                    </tr>
                    <tr>
                        <td colspan="2" class=""><b>Name: </b>__________________</td>
                    </tr>
                    <tr>
                        <td colspan="2" class=""><b>Date: </b>____________________</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="bordertablessign"><b>Signature: </b>______________</td>
                    </tr>
                </table>
            </td>
        @endif
        <td style="width: 50%">
                <table style="width: 100%">
                    <tr>
                        <td class="headers" style="height:15px;" colspan="2"><div style="height:15px;"><b><u>Prepared By</u></b></div></td>
                    </tr>
                    <tr>
                        <td colspan="2" class=""><b>Name: </b>__________________</td>
                    </tr>
                    <tr>
                        <td colspan="2" class=""><b>Date: </b>____________________</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="bordertablessign"><b>Signature: </b>______________</td>
                    </tr>
                </table>
            </td>
    </tr>

</table>

<table style="width: 100%;">    
        <tr style="text-align: left;">
                <td>
                    <br><br><b>Thank you for your time and consideration. We look forward to recieving your proposals</b>
                </td>
        </tr>
    </table>
</body>
</html>