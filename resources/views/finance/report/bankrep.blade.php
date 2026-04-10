@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Bank-Report')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">Bank Report</h3>
                            </div>
                            <div class="card-datatable">
                                <div style="width:100%;">
                                    <div style="width:98%; margin-left:2%; margin-top:2%;">
                                        <div class="row">
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;color">Select Date Range</label>
                                                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;color">Point of Sales</label>
                                                    <div>
                                                        <select class="selectpicker form-control" id="POS" data-live-search="true" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Point of Sales ({0})" onchange="posfn()">
                                                            @foreach ($storeSrc as $storeSrc)
                                                                <option value="{{$storeSrc->StoreId}}">{{$storeSrc->StoreName}}</option>
                                                            @endforeach               
                                                        </select>
                                                    </div>
                                                    <span class="text-danger">
                                                <strong id="pos-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;color">Bank</label>
                                                    <div>
                                                        <select class="selectpicker form-control" id="bank" data-live-search="true" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Banks ({0})" onchange="banksfn()">
                                                            @foreach ($banks as $banks)
                                                                <option value="{{$banks->id}}">{{$banks->BankName}}</option>
                                                            @endforeach               
                                                        </select>
                                                    </div>
                                                    <span class="text-danger">
                                                <strong id="bank-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;color">Payment Mode</label>
                                                    <div>
                                                        <select class="selectpicker form-control" id="paymenttype" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Payment Mode ({0})" onchange="paymenttypefn()">
                                                            <option value='"Cash"'>Cash</option> 
                                                            <option value='"Cheque"'>Cheque</option>
                                                            <option value='"Bank-Transfer"'>Bank-Transfer</option>                 
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
                                               <table id="bankreportbl" class="table" style="width: 100%;color:black;">
                                                    <thead>
                                                        <tr style="display: none;" id="compinfotr">
                                                            <th colspan="8">
                                                                <table id="headertables" class="headerTable" style="border-bottom: 1px solid black; margin-top:-60px;width:100%;"></table>
                                                            </th>
                                                        </tr>
                                                        <tr id="daterangetr" style="display: none;">
                                                            <th colspan="8">
                                                                <h4><p style="text-align:center; margin:top:-10px;color:#00cfe8;font-family: 'Segoe UI', Verdana, Helvetica, Sans-Serif;"><b>Bank Report</b></p></h4>
                                                            </th>
                                                        </tr>
                                                        <tr id="titletr" style="display: none;">
                                                            <th colspan="1" style="border: 1px solid black;"><label strong style="font-size: 14px;">Date Range</label></th>
                                                            <th colspan="2" style="border: 1px solid black;"><label id="daterange" strong style="font-size: 14px;"></label></th>
                                                            <th colspan="1" style="border: 1px solid black;"><label strong style="font-size: 14px;">Payment Mode</label></th>
                                                            <th colspan="4" style="border: 1px solid black;"><label id="paymenttypelbl" strong style="font-size: 14px;"></label></th>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="8" style="color:black; border-bottom-color: black;background-color:white;"></td>
                                                        </tr>
                                                        <tr style="color:white; border: 0.1px solid black;">
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Document #</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Point of Sales</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:15%;">Bank Name</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Payment Mode</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:15%;">Account Number</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:15%;">Transaction Ref. #</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:15%;">Transaction Ref. Date</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:10%;">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot></tfoot>
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
            var pos=$('#POS').val(); 
            var bank=$('#bank').val();
            var pmode=$('#paymenttype').val();
            var posids=""; 
            var bankids="";
            var pmodes="";  
            var selectedptype="";
            if(pos==''|| pos==null ||bank==''||pmode==''){
                if(pos==''|| pos==null){
                    $('#pos-error').html('Point of sales is required');
                    toastrMessage("error", "Please fill all required fields","Error");
                }
                if(bank==''){
                    $('#bank-error').html('Bank is required');
                    toastrMessage("error", "Please fill all required fields","Error");
                }
                if(pmode==''){
                    $('#paymenttype-error').html('Payment mode is required');
                    toastrMessage("error", "Please fill all required fields","Error");
                }
            }
            else
            {   
                $('#pos-error').html('');
                $('#bank-error').html('');
                $('#paymenttype-error').html('');
                $("#paymenttype :selected").each(function() {
                    selectedptype+=this.text+" , ";
                });
                $('#daterange').html('<b>'+fr+'</b> to <b>'+tr+'</b>');
                $('#paymenttypelbl').html('<b>'+selectedptype+'</b>');
                
                var table = $("#bankreportbl").DataTable({
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
                            url: '/bankreplist/'+ fr + '/' + tr,
                            type: 'POST',
                            data:{
                                posids: $('#POS').val(),
                                bankids: $('#bank').val(),
                                pmodes: $('#paymenttype').val(),
                            },
                        },
                        buttons: true,
                        ordering: false,
                        paging: false,
                        columns: [ 
                            {
                                data: "IncomeDocumentNumber",
                                name: "IncomeDocumentNumber",
                                width:"10%",
                            },
                            
                            {
                                data: "POS",
                                name: "POS",
                                width:"10%",
                            },
                            {
                                data: "BankName",
                                name: "BankName",
                                width:"15%",
                            },
                            {
                                data: "PaymentType",
                                name: "PaymentType",
                                width:"10%",
                            },
                            {
                                data: "AccountNumber",
                                name: "AccountNumber",
                                width:"15%",
                            },
                            {
                                data: "SlipNumber",
                                name: "SlipNumber",
                                width:"15%",
                            },
                            {
                                data: "SlipDate",
                                name: "SlipDate",
                                width:"15%",
                            },
                            {
                                data: "Amount",
                                name: "Amount",
                                width:"10%",
                                render: $.fn.dataTable.render.number(',', '.',2, '')
                            },
                        ],
                        columnDefs: [
                            {
                                "width": "100%",
                                targets: [0,1,2,3,4,5,6,7],
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
                        order: [[2, 'asc'],[3, 'asc'],[4, 'asc']],
                        rowGroup: {
                            startRender: function ( rows, group,level ) {
                                var color =  'style="font-weight:bold;background:#f2f3f4;"';
                                    if(level===0){
                                        return $('<tr ' + color + '>')
                                        .append('<td colspan="8" style="text-align:center;border: 0.1px solid black; background:#ccc;"><b>POS : ' + group + ' </b></td></tr>')
                                    }
                                    // else if(level===1){
                                    //     return $('<tr ' + color + '>')
                                    //     .append('<td colspan="8" style="text-align:left;border:0.1px solid;">Bank Name : ' + group + '</td></tr>')
                                    // } 
                                    // else if(level===2){
                                    //     return $('<tr ' + color + '>')
                                    //     .append('<td colspan="8" style="text-align:left;border:0.1px solid;">Account Number : ' + group + '</td></tr>')
                                    // } 
                                           
                            },
                            endRender: function ( rows, group,level ) {
                                var intVal = function ( i ) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '')*1 :
                                        typeof i === 'number' ?
                                                i : 0;
                                };
                                var amounts = rows
                                .data()
                                .pluck('Amount')
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0); 
                                var color = 'style="font-weight:bold;background:#f2f3f4;"';
                                if(level===0){
                                    return $('<tr ' + color + '>')
                                    .append('<td colspan="7" style="text-align:right;border:0.1px solid;">Total of ' + group+ '</td>')
                                    .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(amounts.toFixed(2))+'</td></tr>');
                                }  
                                // else if(level===1){
                                //     return $('<tr ' + color + '>')
                                //     .append('<td colspan="7" style="text-align:right;border:0.1px solid;">Total of : ' + group+ '</td>')
                                //     .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(amounts.toFixed(2))+'</td></tr>');
                                // }
                                // else if(level===2){
                                //     return $('<tr ' + color + '>')
                                //     .append('<td colspan="7" style="text-align:right;border:0.1px solid;">Total of : ' + group+ '</td>')
                                //     .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(amounts.toFixed(2))+'</td></tr>');
                                // }
                                
                            }, 
                            dataSrc: ['POS']
                            //dataSrc: ['POS','BankName','AccountNumber']
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
                
                            amnts = api
                                .column( 7 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            // Update footer

                            // $('#cashbeforetotallbl').html(numformat(totalcash.toFixed(2)));
                            // $('#cashtaxlbl').html(numformat(taxcash.toFixed(2)));
                            // $('#cashtotallbl').html(numformat(grandtotalcash.toFixed(2)));
                            // $('#creditbeforetotallbl').html(numformat(totalcredit.toFixed(2)));
                            // $('#credittaxlbl').html(numformat(taxcredit.toFixed(2)));
                            // $('#credittotallbl').html(numformat(grandtotalcredit.toFixed(2)));
                            // $('#grandtotalbefore').html(numformat(beforetax.toFixed(2)));
                            // $('#grandtotaltax').html(numformat(taxtotal.toFixed(2)));
                            // $('#grandtotaltotalprice').html(numformat(grandtotal.toFixed(2))); 
                            // $('#totalcashdicountlbl').html(numformat(totaldiscountcash.toFixed(2)));
                            // $('#totalcreditdiscountlbl').html(numformat(totaldiscountcredit.toFixed(2)));  
                            // $('#grandtotaldiscountlbl').html(numformat(discounttoal.toFixed(2))); 
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

            let tbl = document.getElementById('bankreportbl');
            let footer = tbl.getElementsByTagName('tfoot')[0];
            footer.style.display = 'table-row-group';
            let header = tbl.getElementsByTagName('thead')[0];
            header.style.display = 'table-row-group';
            tbl.removeChild(footer);
            tbl.appendChild(footer);
    
            var divToPrint=document.getElementById("bankreportbl");
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
            let tbl = document.getElementById('bankreportbl');
            let footer = tbl.getElementsByTagName('tfoot')[0];
            footer.style.display = 'table-row-group';
            tbl.removeChild(footer);
            tbl.appendChild(footer);
            $("#bankreportbl").table2excel({
            name: "Worksheet Name",
            filename: "BankReport", //do not include extension
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
        function posfn(){
            $('#pos-error').html('');
        }
        function banksfn(){
            $('#bank-error').html('');
        }
    </script>
@endsection
