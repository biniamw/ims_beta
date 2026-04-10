@extends('layout.app1')

@section('title')
@endsection
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }

    table td {
        border: 1px solid black;
    }

    table tr,
    table td {
        padding: 5px;
        /* page-break-inside: avoid; */
    }

    th {
        background-color: #00cfe8;
        color: white;
        text-align: left;
        border: 1px solid black;
        font-size: 14.3px;
    }

    th,
    td {
        border-bottom: 1px solid black;
    }

    table td img {
        display: inline-block;
        float: left;
        width: 100%;
        height: 120px;
        table-layout: fixed;
    }

</style>
@section('content')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Item Movement Report</h3>
                            <button type="button" class="btn btn-gradient-info btn-sm" style="color: white;"
                                onclick="printDiv('printable')" title="Print"><i data-feather='printer'></i></button>
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div class="table-responsive" id="printable">
                                    <table id="t1"
                                        style="width:100%;border:none;border-collapse:collapse;cellspacing:0;cellpadding:0;">
                                        <tr style="border:none;">
                                            <td colspan="4"
                                                style="text-align:center;border:none;font-weight:bold;font-size:30px; color:#00cfe8;">
                                                {{ $compInfo->Name }}
                                            </td>
                                            <td rowspan="4" style="width:15%;border:none;">
                                                <img src="data:image/png;base64,{{ chunk_split(base64_encode($compInfo->Logo)) }}"
                                                    width="150" height="150">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:11%;border:none;font-weight:bold;">Tel:</td>
                                            <td style="border:none;width:30%;">{{ $compInfo->Phone }}</td>
                                            <td style="width:11%;border:none;font-weight:bold;">Website:</td>
                                            <td style="border:none;width:30%;">{{ $compInfo->Website }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:none;font-weight:bold;">Email:</td>
                                            <td style="border:none;">{{ $compInfo->Email }}</td>
                                            <td style="border:none;font-weight:bold;">Address:</td>
                                            <td style="border:none;">{{ $compInfo->Address }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:none;font-weight:bold;">TIN No.:</td>
                                            <td style="border:none;">{{ $compInfo->TIN }}</td>
                                            <td style="border:none;font-weight:bold;">VAT No.:</td>
                                            <td style="border:none;">{{ $compInfo->VATReg }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="border-top:white;border-right:white;border-left:white;">
                                            </td>
                                        </tr>
                                    </table>
                                    <h3>
                                        <p
                                            style="text-align:center; margin:top:-10px;color:#00cfe8;font-family: 'Segoe UI', Verdana, Helvetica, Sans-Serif;">
                                            <b>Item Detail Movement Report</b>
                                        </p>
                                    </h3>
                                    <table id="t2" style="margin-bottom:10px;">
                                        <tr>
                                            <td style="width:15%">Date Range</td>
                                            <td style="font-weight:bold;width:30%;">{{ $from }} to
                                                {{ $to }}</td>
                                            <td style="width:20%">Store</td>
                                            <td style="font-weight:bold;width:35%;">
                                                @foreach ($storename as $storename)
                                                    {{ $storename->StoreName }}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%">Fiscal Year</td>
                                            <td style="font-weight:bold;">{{ $fiscalyear }}</td>
                                            <td style="width:20%">Transaction Type</td>
                                            <td style="font-weight:bold;">{{ $trname }}</td>
                                        </tr>
                                    </table>
                                    <div id="repid">
                                        <?php
                                        $report->render();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }


        $("#exportExcel").click(function(e) {
            window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#repid')
                .html())); // content is the id of the DIV element  
            e.preventDefault();
        });
    </script>
@endsection
