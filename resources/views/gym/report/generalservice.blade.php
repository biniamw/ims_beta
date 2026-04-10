@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('General-Service-Income')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">General Service Income Report</h3>
                            </div>
                            <div class="card-datatable">
                                <div style="width:100%;">
                                    <div style="width:98%; margin-left:2%; margin-top:2%;">
                                        <div class="row">
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;color">Select Date Range</label>
                                                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;color">Payment Type</label>
                                                    <div>
                                                        <select class="selectpicker form-control" id="paymenttype" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Payment Type ({0})" onchange="paymenttypefn()">
                                                            <option value='"Cash"'>Cash</option> 
                                                            <option value='"Credit"'>Credit</option>                 
                                                        </select>
                                                    </div>
                                                    <span class="text-danger">
                                                <strong id="paymenttype-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <div class="row" style="color: white;">
                                                    .
                                                </div>
                                                <div class="row">
                                                    <button id="reportbutton" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>    View</button>
                                                    <div style="width: 1%;"></div>
                                                    <div class="btn-group dropdown" id="exportdiv" style="display: none;">
                                                        <button type="button" class="btn btn-info dropdown-toggle hide-arrow btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span>Print / Export </span><i class="fa fa-caret-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <button id="printtable" type="button" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i>  Print</button>
                                                            <button id="downloatoexcel" type="button"  class="dropdown-item"><i class="fa fa-file-excel" aria-hidden="true"></i> To Excel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </section>
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-datatable">
                                <div style="width:100%;">
                                     <div class="row" id="printable" style="display:none;">
                                    <div class="col-xl-11 col-md-6 col-sm-12 mb-2">
                                    </div>
                                    <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                        <button type="button" class="btn btn-gradient-info btn-sm" style="color: white;display:none;"
                                        onclick="printDiv('printable')" title="Print"><i data-feather='printer'></i></button>
                                    </div>
                                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                        <div style="width: 100%;">
                                            <div class="table-responsive">
                                               <table id="generalservicetbl" class="table" style="width: 100%;color:black;">
                                                    <thead>
                                                        <tr style="display: none;" id="compinfotr">
                                                            <th colspan="10">
                                                                <table id="headertables" class="headerTable" style="border-bottom: 1px solid black; margin-top:-60px;width:100%;"></table>
                                                            </th>
                                                        </tr>
                                                        <tr id="daterangetr" style="display: none;">
                                                            <th colspan="10">
                                                                <h4><p style="text-align:center; margin:top:-10px;color:#00cfe8;font-family: 'Segoe UI', Verdana, Helvetica, Sans-Serif;"><b>General Service Income Report</b></p></h4>
                                                            </th>
                                                        </tr>
                                                        <tr id="titletr" style="display: none;">
                                                            <th colspan="2" style="border: 1px solid black;"><label strong style="font-size: 14px;">Date Range</label></th>
                                                            <th colspan="3" style="border: 1px solid black;"><label id="daterange" strong style="font-size: 14px;"></label></th>
                                                            <th colspan="2" style="border: 1px solid black;"><label strong style="font-size: 14px;">Payment Type</label></th>
                                                            <th colspan="3" style="border: 1px solid black;"><label id="paymenttypelbl" strong style="font-size: 14px;"></label></th>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="10" style="color:black; border-bottom-color: black;background-color:white;"></td>
                                                        </tr>
                                                        <tr style="color:white; border: 0.1px solid black;">
                                                            
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Period</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Service Name</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Payment Type</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">No. of Group</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Payment Term</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Invoice Type</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Before Tax</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Tax</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Total Price</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Discount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot class="fitreportfooter">
                                                        <tr>
                                                            <td colspan="10"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" class="text-right" style="font-weight:bold;border:0.1px solid;background:#f2f3f4;">Total Cash</td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="cashbeforetotallbl" strong style="font-size: 14px;"></label></td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="cashtaxlbl" strong style="font-size: 14px;"></label></td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="cashtotallbl" strong style="font-size: 14px;"></label></td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="totalcashdicountlbl" strong style="font-size: 14px;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" class="text-right" style="font-weight:bold;border:0.1px solid;background:#f2f3f4;">Total Credit</td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="creditbeforetotallbl" strong style="font-size: 14px;"></label></td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="credittaxlbl" strong style="font-size: 14px;"></label></td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="credittotallbl" strong style="font-size: 14px;"></label></td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="totalcreditdiscountlbl" strong style="font-size: 14px;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" class="text-right" style="font-weight:bold;border:0.1px solid;background:#f2f3f4;">Grand Total</td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="grandtotalbefore" strong style="font-size: 14px;"></label></td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="grandtotaltax" strong style="font-size: 14px;"></label></td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="grandtotaltotalprice" strong style="font-size: 14px;"></label></td>
                                                            <td style="text-align: left; font-weight:bold; border:0.1px solid;background:#f2f3f4;"><label id="grandtotaldiscountlbl" strong style="font-size: 14px;"></label></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>	
                    </div>
                </div>
            </section>
        </div>
    @endcan
{{-- @endsection

@section('scripts') --}}
    <script type="text/javascript">
        
        $(".selectpicker").selectpicker({
            noneSelectedText : 'Nothing selected'
        });
        
        $( document).ready(function() {
            $('#exportdiv').hide();
        });

        var fr='';
        var tr='';
        $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY'));
            var from=start.format('YYYY-MM-DD');
            var to=end.format('YYYY-MM-DD');
            fr=from;
            tr=to; 
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last 3 Month': [moment().subtract(89, 'days'), moment()],
                'Last 6 Month': [moment().subtract(179, 'days'), moment()],
                'Last 12 Month': [moment().subtract(364, 'days'), moment()],
            }
        }, cb);
            cb(start, end);
        });

        $('#reportbutton').click(function()
        {    
            var paymenttype=$('#paymenttype').val(); 
            var selectedptype="";
            if(paymenttype==''){
                $( '#paymenttype-error' ).html('Payment type is required');
                toastrMessage("error", "Please fill all required fields","Error");
            }
            else
            {   
                $('#paymenttype-error').html('');
                $("#paymenttype :selected").each(function() {
                    selectedptype+=this.text+" , ";
                });
                $('#daterange').html('<b>'+fr+'</b> to <b>'+tr+'</b>');
                $('#paymenttypelbl').html('<b>'+selectedptype+'</b>');
                var table = $("#generalservicetbl").DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    paging: false,
                    searching: true,
                    info: true,
                    responsive:true,
                    searchHighlight: true,
                        "order": [
                            [0, "desc"]
                        ],
                        "pagingType": "simple",
                        language: {
                            search: '',
                            searchPlaceholder: "Search here"
                        },
                        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                        ajax: {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '/generalservicedata/'+ fr + '/' + tr + '/' + paymenttype,
                            type: 'POST',
                        },
                        buttons: true,
                        ordering: false,
                        paging: false,
                        columns: [ 
                            {
                                data: "PeriodName",
                                name: "PeriodName",
                                width:"10%",
                            },
                            {
                                data: "ServiceName",
                                name: "ServiceName",
                                width:"10%",
                            },
                            
                            {
                                data: "PaymentType",
                                name: "PaymentType",
                                width:"10%",
                            },
                            {
                                data: "GroupName",
                                name: "GroupName",
                                width:"10%",
                            },
                            {
                                data: "PaymentTermName",
                                name: "PaymentTermName",
                                width:"10%",
                            },
                            {
                                data: "ApplicationType",
                                name: "ApplicationType",
                                width:"10%",
                            },
                            {
                                data: "BeforeTax",
                                name: "BeforeTax",
                                width:"10%",
                                render: $.fn.dataTable.render.number(',', '.',2, '')
                            },
                            {
                                data: "Tax",
                                name: "Tax",
                                width:"10%",
                                render: $.fn.dataTable.render.number(',', '.', 2, '')
                            },
                            {
                                data: "TotalPrice",
                                name: "TotalPrice",
                                width:"10%",
                                render: $.fn.dataTable.render.number(',', '.', 2, '')
                            },
                            {
                                data: "DiscountAmount",
                                name: "DiscountAmount",
                                width:"10%",
                                render: $.fn.dataTable.render.number(',', '.', 2, '')
                            },
                        ],
                        columnDefs: [
                            {
                                "width": "100%",
                                targets: [0,1,2,3,4,5,6,7,8,9],
                                createdCell: function (td, cellData, rowData, row, col){
                                $(td).css('border', '0.1px solid black');
                                $(td).css('color', 'black');
                            }
                        }],
                        fixedHeader: {
                            header: true,
                            headerOffset: $('.header-navbar').outerHeight(),
                            footer: true
                        },
                        order: [[3, 'asc'], [5, 'asc']],
                        rowGroup: {
                            startRender: function ( rows, group,level ) {
                                var color =  'style="font-weight:bold;background:#f2f3f4;"';
                                    if(level===0){
                                        return $('<tr ' + color + '>')
                                        .append('<td colspan="10" style="text-align:center;border: 0.1px solid black; background:#ccc;"><b>Payment Type : ' + group + ' </b></td></tr>')
                                    }
                                    else if(level===1){
                                        return $('<tr ' + color + '>')
                                        .append('<td colspan="10" style="text-align:left;border:0.1px solid;">Payment Term : ' + group + '</td></tr>')
                                    } 
                                    else if(level===2){
                                        return $('<tr ' + color + '>')
                                        .append('<td colspan="10" style="text-align:left;border:0.1px solid;">Service : ' + group + '</td></tr>')
                                    }         
                            },
                            endRender: function ( rows, group,level ) {
                                var intVal = function ( i ) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '')*1 :
                                        typeof i === 'number' ?
                                                i : 0;
                                };
                                var totalbeforetax = rows
                                .data()
                                .pluck('BeforeTax')
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0); 
                                var totaltax = rows
                                .data()
                                .pluck('Tax')
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0); 
                                var totalprices = rows
                                .data()
                                .pluck('TotalPrice')
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0); 
                                var discountamount = rows
                                .data()
                                .pluck('DiscountAmount')
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0); 
                                var color = 'style="font-weight:bold;background:#f2f3f4;"';
                                if(level===0){
                                    return $('<tr ' + color + '/>')
                                    .append('<td colspan="6" style="text-align:right;border:0.1px solid;">Total ' + group+ '</td>') 
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(totalbeforetax.toFixed(2))+'</td>')
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(totaltax.toFixed(2))+'</td>')
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(totalprices.toFixed(2))+'</td>')    
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(discountamount.toFixed(2))+'</td></tr>');
                                }  
                                else if(level===1){
                                    return $('<tr ' + color + '/>')
                                    .append('<td colspan="6" style="text-align:right;border:0.1px solid;">Total of : ' + group+ '</td>') 
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(totalbeforetax.toFixed(2))+'</td>')
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(totaltax.toFixed(2))+'</td>')
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(totalprices.toFixed(2))+'</td>')
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(discountamount.toFixed(2))+'</td></tr>');
                                }
                                else if(level===2){
                                    return $('<tr ' + color + '/>')
                                    .append('<td colspan="6" style="text-align:right;border:0.1px solid;">Total of : ' + group+ '</td>') 
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(totalbeforetax.toFixed(2))+'</td>')
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(totaltax.toFixed(2))+'</td>')
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(totalprices.toFixed(2))+'</td>')
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(discountamount.toFixed(2))+'</td></tr>');
                                }
                            }, 
                            dataSrc: ['PaymentType','PaymentTermName','ServiceName']
                        },
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api();
                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                
                            beforetax = api
                                .column( 6 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            // Update footer
                            //tax total
                            taxtotal = api
                                .column( 7 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            //tax total
                            grandtotal = api
                                .column( 8 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                                
                            discounttoal = api
                                .column( 9 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            // calculate total cash and credit sales

                            
                             var totalcash  = api
                                .cells( function ( index, data, node ) {
                                return api.row( index ).data().PaymentType === 'Cash' ?
                                    true : false;
                                }, 6 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            var totalcredit = api
                                .cells( function ( index, data, node ) {
                                return api.row( index ).data().PaymentType === 'Credit' ?
                                    true : false;
                                }, 6 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            var taxcash = api
                                .cells( function ( index, data, node ) {
                                return api.row( index ).data().PaymentType === 'Cash' ?
                                    true : false;
                                }, 7 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                            
                            var taxcredit = api
                                .cells( function ( index, data, node ) {
                                return api.row( index ).data().PaymentType === 'Credit' ?
                                    true : false;
                                }, 7 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            var grandtotalcash = api
                                .cells( function ( index, data, node ) {
                                return api.row( index ).data().PaymentType === 'Cash' ?
                                    true : false;
                                }, 8 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                           
                            var grandtotalcredit = api
                                .cells( function ( index, data, node ) {
                                return api.row( index ).data().PaymentType === 'Credit' ?
                                    true : false;
                                }, 8 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                            
                            var totaldiscountcash = api
                                .cells( function ( index, data, node ) {
                                return api.row( index ).data().PaymentType === 'Cash' ?
                                    true : false;
                                }, 9 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                           
                            var totaldiscountcredit = api
                                .cells( function ( index, data, node ) {
                                return api.row( index ).data().PaymentType === 'Credit' ?
                                    true : false;
                                }, 9 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            $('#cashbeforetotallbl').html(numformat(totalcash.toFixed(2)));
                            $('#cashtaxlbl').html(numformat(taxcash.toFixed(2)));
                            $('#cashtotallbl').html(numformat(grandtotalcash.toFixed(2)));
                            $('#creditbeforetotallbl').html(numformat(totalcredit.toFixed(2)));
                            $('#credittaxlbl').html(numformat(taxcredit.toFixed(2)));
                            $('#credittotallbl').html(numformat(grandtotalcredit.toFixed(2)));
                            $('#grandtotalbefore').html(numformat(beforetax.toFixed(2)));
                            $('#grandtotaltax').html(numformat(taxtotal.toFixed(2)));
                            $('#grandtotaltotalprice').html(numformat(grandtotal.toFixed(2))); 
                            $('#totalcashdicountlbl').html(numformat(totaldiscountcash.toFixed(2)));
                            $('#totalcreditdiscountlbl').html(numformat(totaldiscountcredit.toFixed(2)));  
                            $('#grandtotaldiscountlbl').html(numformat(discounttoal.toFixed(2))); 
                        }
                    });
                    $('#exportdiv').show();
                    $("#printable").show();   
                    $('.fitreportfooter').show();
            }
        }); 

        $('#printtable').click(function(){
            var tr='<tr>'+
                    '<td colspan="6" class="headerTitles" style="text-align:center;font-size:1.7rem;"><b>{{$compInfo->Name}}</b></td>'+
                    '<td rowspan="4" style="float:right;width:150px;height:120px;"></td>'+
                    '</tr>'+
                    '<tr><td style="width:15%"><b>Tel:</b></td>'+
                    '<td style="width:35%" colspan="2">{{$compInfo->Phone}},{{$compInfo->OfficePhone}}</td>'+
                    '<td style="width:15%"><b>Website:</b></td>'+
                    '<td style="width:35%" colspan="2">{{$compInfo->Website}}</td>'+
                    '</tr>'+
                    '<tr><td><b>Email:</b></td>'+
                    '<td colspan="2">{{$compInfo->Email}}</td>'+
                    '<td><b>Address:</b></td>'+
                    '<td colspan="2">{{$compInfo->Address}}</td>'+
                    '</tr>'+
                    '<tr><td style="width:15%"><b>TIN No.:</b></td>'+
                    '<td colspan="2">{{$compInfo->TIN}}</td>'+
                    '<td><b>VAT No:</b></td>'+
                    '<td colspan="2">{{$compInfo->VATReg}}</td>'+
                    '</tr>';
                    $("#headertables").append(tr);
            $('#daterangetr').show();
            $('#titletr').show();
            $('#compinfotr').show();

            let tbl = document.getElementById('generalservicetbl');
            let footer = tbl.getElementsByTagName('tfoot')[0];
            footer.style.display = 'table-row-group';
            let header = tbl.getElementsByTagName('thead')[0];
            header.style.display = 'table-row-group';
            tbl.removeChild(footer);
            tbl.appendChild(footer);
    
            var divToPrint=document.getElementById("generalservicetbl");
            var htmlToPrint = '' +
                '<style type="text/css">' +
                'table th, table td {' +
                'border:1px solid #000;' +
                'padding:0.5em;' +
                '}' +
                '</style>';
                htmlToPrint += divToPrint.outerHTML;
                newWin= window.open("");
                newWin.document.write(divToPrint.outerHTML);
                newWin.print();
                newWin.close();
                
            $('#compinfotr').hide();
            $('#daterangetr').hide();
            $('#titletr').hide();
            $("#headertables").empty();
        });

        $("#downloatoexcel").click(function(){
            $("#headertables").empty();
            var datefrom=$('#date').val();
            var dateto=$('#todate').val();
            let tbl = document.getElementById('generalservicetbl');
            let footer = tbl.getElementsByTagName('tfoot')[0];
            footer.style.display = 'table-row-group';
            tbl.removeChild(footer);
            tbl.appendChild(footer);
            $("#generalservicetbl").table2excel({
            name: "Worksheet Name",
            filename: "GeneralServiceReport", //do not include extension
            fileext: ".xls" // file extension
            });
        });

        $(function () {
            cardSection = $('#page-block');
        });

        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }   

        function paymenttypefn(){
            $('#paymenttype-error').html('');
        }
    </script>
@endsection
