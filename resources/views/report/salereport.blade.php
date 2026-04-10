<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> ims report</title>
        <style>
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
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
            .panel {
                margin-bottom: 20px;
                background-color: #fff;
                border: 1px solid transparent;
                border-radius: 4px;
                -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
                box-shadow: 0 1px 1px rgba(0,0,0,.05);
            }
            .panel-default {
                border-color: #ddd;
            }
            .panel-body {
                padding: 15px;
            }
            table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 0px;
                border-spacing: 0;
                border-collapse: collapse;
                background-color: transparent;
            }
            thead  {
                text-align: left;
                display: table-header-group;
                vertical-align: middle;
            }
            th, td  {
                border: 1px solid #ddd;
                padding: 6px;
            }
            .well {
                min-height: 20px;
                padding: 19px;
                margin-bottom: 20px;
                background-color: #f5f5f5;
                border: 1px solid #e3e3e3;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            }
        </style>
        {{-- @if() --}}
            <style>
                @page { margin-top: 140px;}
                header {
                    top: -100px;
                    position: fixed;
                }
            </style>
        {{-- @endif --}}
    </head>
    <body>
        <header>
            <div style="position:absolute; left:0pt; width:250pt;">
                <img class="img-rounded" >
            </div>
            <div style="margin-left:300pt;">
                <b>Date: </b> {{$due_date->formatLocalized('%A %d %B %Y') }}<br />
                @if ($due_date)
                    <b>Due date: </b>{{ $due_date->formatLocalized('%A %d %B %Y') }}<br />
                @endif
                @if ($totalprice->VoucherNumber)
                    <b>Invoice #: </b> {{$totalprice->VoucherNumber}}
                @endif
                <br />
            </div>
            <br />
            <h2><b>Invoice Name</b> {{ $totalprice->VoucherNumber ? '#' . $totalprice->VoucherNumber : '' }}</h2>
        </header>
        <main>
            <div style="clear:both; position:relative;">
                <div style="position:absolute; left:0pt; width:250pt;">
                    <h4><b>Business Details:</b></h4>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {{-- {!! $invoice->business_details->count() == 0 ? '<i>No business details</i><br />' : '' !!} --}}
                          <b> Company:</b> {{$compInfo->Name}}<br/>
                           <b>TIN No:</b> {{$compInfo->TIN}}  <br/>
                          <b>Phone No:</b>  {{$compInfo->OfficePhone}}<br/>                          
                         <b> Address:</b>  {{$compInfo->Address}}<br/>
                         <b> Country:</b>  {{$compInfo->Country}}  <br />
                        </div>
                    </div>
                </div>
                <div style="margin-left: 300pt;">
                    <h4><b>Customer Details:</b></h4>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {{-- {!! $invoice->customer_details->count() == 0 ? '<i>No customer details</i><br />' : '' !!} --}}
                          <b>Customer Name:</b> {{$customerDetails->Name }}<br />
                           <b>ID:</b>{{ $customerDetails->Code }}<br />
                           <b>Category:</b> {{ $customerDetails->CustomerCategory}}<br />
                            <b>TIN No:</b>  {{ $customerDetails->TinNumber }}<br />
                                <b>MRC No:</b>   {{ $customerDetails->VatNumber }}
                            {{-- {{ $invoice->customer_details->get('country') }}<br /> --}}
                        </div>
                    </div>
                </div>
            </div>
            <h4><b>Items:</b></h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Before Tax</th>
                        <th>Tax</th>
                        <th>Total</th>
                    </tr>
                </thead>
                
                    @foreach ($sale as $item)
                        <tr>
                           
                            <td>{{++$count}}</td>
                            <td>{{$item->ItemCode}}</td>
                            <td>{{$item->ItemName}}</td>
                            <td>{{$item->Quantity}}</td>
                            <td>{{$item->UnitPrice}}</td>
                            <td>{{$item->BeforeTaxPrice}}</td>
                            <td>{{$item->TaxAmount}}</td>
                            <td>{{$item->TotalPrice}}</td>
                        </tr>
                    @endforeach
               
            </table>
            <div style="clear:both; position:relative;">
                {{-- @if($invoice->notes) --}}
                    <div style="position:absolute; left:0pt; width:250pt;">
                        <h4>Notes:</h4>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <!-- NOTE VALID WITH OUT FISICAL RECIEPT IS ATTACHED -->
                            </div>
                        </div>
                    </div>
                {{-- @endif --}}
                <div style="margin-left: 300pt;">
                    <h4><b>Total:</b></h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><b>Subtotal</b></td>
                                <td><b>{{$totalprice->SubTotal}}</b></td>
                            </tr>
                            {{-- @foreach($invoice->tax_rates as $tax_rate) --}}
                                <tr>
                                    <td>
                                        <b>
                                            Taxes 15 %
                                        </b>
                                    </td>
                                    <td><b>{{$totalprice->Tax}}</b></td>
                                </tr>
                            {{-- @endforeach --}}
                            <tr>
                                <td><b>TOTAL</b></td>
                                <td><b>{{$totalprice->GrandTotal}}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- @if ($invoice->footnote) --}}
                <br /><br />
                <div class="well">
                    {{-- {{ $invoice->footnote }} --}}
                  
                </div>
            {{-- @endif --}}
        </main>

        <!-- Page count -->
        <script type="text/php">
            {{-- if (isset($pdf) && $GLOBALS['with_pagination'] && $PAGE_COUNT > 1) {
                $pageText = "{PAGE_NUM} of {PAGE_COUNT}";
                $pdf->page_text(($pdf->get_width()/2) - (strlen($pageText) / 2), $pdf->get_height()-20, $pageText, $fontMetrics->get_font("DejaVu Sans, Arial, Helvetica, sans-serif", "normal"), 7, array(0,0,0));
            } --}}
        </script>
    </body>
</html>