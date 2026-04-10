@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('DS-CustomerRank-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">DS Sales Rank By Customer Report</h3>
                            </div>
                            <div class="card-datatable">
                                <div style="width:100%;">
                                    <form id="profitandlossform">
                                        @csrf
                                        <div style="width:98%; margin-left:1%; margin-top:2%;">
                                            <div class="row">
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">Fiscal Year</label>
                                                    <select class="selectpicker form-control" id="fiscalyears" name="fiscalyears" data-live-search="true" data-style="btn btn-outline-secondary waves-effect">
                                                        @foreach ($fiscalyear as $fiscalyear)
                                                            <option value="{{ $fiscalyear->FiscalYear }}">{{ $fiscalyear->Monthrange }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="fiscalyear-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">From</label>
                                                    <div>
                                                        <input type="text" id="date" name="date" class="form-control flatpickr-basic date" placeholder="YYYY-MM-DD" onchange="dateVal()" value="{{$fdate}}"/>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="date-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">To</label>
                                                    <div>
                                                        <input type="text" id="todate" name="todate" class="form-control flatpickr-basic todate" placeholder="YYYY-MM-DD" onchange="todateVal()"/>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="todate-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="storediv">
                                                    <label strong style="font-size: 14px;">Point of Sales</label>
                                                    <select class="selectpicker form-control" id="store" name="store[]" multiple="multiple" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Point of Sales ({0})" onchange="storeVal()"></select>
                                                    <span class="text-danger">
                                                        <strong id="store-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">Payment Type</label>
                                                        <div>
                                                            <select class="selectpicker form-control" id="paymenttype" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Payment Type ({0})" onchange="clearptype()">
                                                                <option value='"--"'>--</option> 
                                                                <option value='"Cash"'>Cash</option> 
                                                                <option value='"Credit"'>Credit</option>                 
                                                            </select>
                                                        </div>
                                                        <span class="text-danger">
                                                    <strong id="paymenttype-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">PullOut Type</label>
                                                    <div>
                                                        <select class="selectpicker form-control" id="pullouttype" name="pullouttype[]" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="PullOut Type ({0})" onchange="pullouttypeval()">
                                                            <option value='"External"'>External</option>
                                                            <option value='"Internal"'>Internal</option>
                                                            <option value='"Disposal"'>Disposal</option>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="pullouttype-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">Item Group</label>
                                                    <div>
                                                        <select class="selectpicker form-control" id="itgroup" name="itgroup[]" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Item Group ({0})" onchange="itemgroup()">
                                                            <option value='"Local"'>Local</option>
                                                            <option value='"Imported"'>Imported</option>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="itemgrp-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">Rank By</label>
                                                    <div>
                                                        <select class="selectpicker form-control" id="RankBy" name="RankBy" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Rank By ({0})" onchange="rankbyval()">
                                                            <option value=""></option>
                                                            <option style="display: none;" value="QuantitySold">By Quantity</option>
                                                            <option value="Revenue">By Sales Income</option>
                                                            <option value="GrossProfit">By Sales Profit</option>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="rankby-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">Sort By</label>
                                                    <div>
                                                        <select class="selectpicker form-control" id="SortBy" name="SortBy" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Sort By ({0})" onchange="sortbyval()">
                                                            <option value=""></option>
                                                            <option value="ASC">Ascending</option>
                                                            <option value="DESC">Descending</option>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="sortby-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">No. of Customers</label>
                                                    <div>
                                                        <input type="number" placeholder="# of customers" class="form-control" name="NumberOfCustomers" id="NumberOfCustomers" onkeypress="return ValidateOnlyNum(event);" onkeyup="numofcus()" ondrop="return false;" onpaste="return false;" />
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="numofcus-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <div class="row" style="color:white;">
                                                        .
                                                    </div>
                                                    <div class="row">
                                                        <input type="hidden" placeholder="" class="form-control" name="fromhidden" id="fromhidden" readonly="true" value="" />
                                                        <input type="hidden" placeholder="" class="form-control" name="tohidden" id="tohidden" readonly="true" value="" />
                                                        <input type="hidden" placeholder="" class="form-control" name="sdval" id="sdval" readonly="true" value="{{$sd}}" />
                                                        <input type="hidden" placeholder="" class="form-control" name="edval" id="edval" readonly="true" value="{{$ed}}" />
                                                        <button id="reportbutton" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>    View</button>
                                                        <div style="width: 0.5%;"></div>
                                                        <div class="btn-group dropdown" id="exportdiv" style="display: none;">
                                                            <button type="button" class="btn btn-info dropdown-toggle hide-arrow btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span>Print/Export</span><i class="fa fa-caret-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <button id="printtable" type="button" class="dropdown-item" ><i class="fa fa-print" aria-hidden="true"></i>  Print</button>
                                                                <button id="downloatoexcel" type="button"  class="dropdown-item"><i class="fa fa-file-excel" aria-hidden="true"></i> To Excel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
                                        <button type="button" class="btn btn-gradient-info btn-sm" style="color: white;display:none;" onclick="printDiv('printable')" title="Print"><i data-feather='printer'></i></button>
                                    </div>
                                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                        <div style="width: 100%;">
                                            <div class="table-responsive">
                                                <div style="width:98%; margin-left:2%; margin-top:2%;">
                                                    <table id="cusrankdatatbl" class="table" style="width: 100%;color:black;">
                                                        <thead>
                                                            <tr style="display: none;" id="compinfotr">
                                                                <th colspan="8">
                                                                    <table id="headertables" class="headerTable" style="border-bottom: 1px solid black; margin-top:-60px;width:100%;"></table>
                                                                </th>
                                                            </tr>
                                                            <tr id="daterangetr" style="display: none;">
                                                                <th colspan="8">
                                                                    <h4><p style="text-align:center; margin:top:-10px;color:#00cfe8;font-family: 'Segoe UI', Verdana, Helvetica, Sans-Serif;"><b>Sales Rank By Customer Report</b></p></h4>
                                                                </th>
                                                            </tr>
                                                            <tr id="titletr" style="display: none;">
                                                                <th colspan="1" style="border: 1px solid black;"><label strong style="font-size: 14px;">Fiscal Year</label></th>
                                                                <th colspan="2" style="border: 1px solid black;"><label id="fiscalyearlbl" strong style="font-size: 14px;"></label></th>
                                                                <th colspan="1" style="border: 1px solid black;"><label strong style="font-size: 14px;">Date Range</label></th>
                                                                <th colspan="4" style="border: 1px solid black;"><label id="daterange" strong style="font-size: 14px;"></label></th>
                                                            </tr>
                                                            <tr class="paymenttr" style="display: none;">
                                                                <th colspan="1" style="border: 1px solid black;"><label strong style="font-size: 14px;">Payment Type</label></th>
                                                                <th colspan="2" style="border: 1px solid black;"><label id="paymenttypelbl" strong style="font-size: 14px;"></label></th>
                                                                <th colspan="1" style="border: 1px solid black;"><label strong style="font-size: 14px;">PullOut Type</label></th>
                                                                <th colspan="4" style="border: 1px solid black;"><label id="potypelbl" strong style="font-size: 14px;"></label></th>
                                                            </tr>
                                                            <tr class="paymenttr" style="display: none;">
                                                                <th colspan="1" style="border: 1px solid black;"><label strong style="font-size: 14px;">Item Group</label></th>
                                                                <th colspan="2" style="border: 1px solid black;"><label id="itemgrouplbl" strong style="font-size: 14px;"></label></th>
                                                                <th colspan="1" style="border: 1px solid black;"><label strong style="font-size: 14px;">Rank By</label></th>
                                                                <th colspan="4" style="border: 1px solid black;"><label id="selectedrankbylbl" strong style="font-size: 14px;"></label></th>
                                                            </tr>
                                                            <tr class="paymenttr" style="display: none;">
                                                                <th colspan="1" style="border: 1px solid black;"><label strong style="font-size: 14px;">Sort By</label></th>
                                                                <th colspan="2" style="border: 1px solid black;"><label id="selectedsortedbylbl" strong style="font-size: 14px;"></label></th>
                                                                <th colspan="1" style="border: 1px solid black;"><label strong style="font-size: 14px;">Point of Sales</label></th>
                                                                <th colspan="4" style="border: 1px solid black;text-align:left;"><label id="selectedstorelbl" strong style="font-size: 14px;"></label></th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="8" style="color:black; border-bottom-color: black;background-color:white;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:15%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Customer Code</th>
                                                                <th style="width:25%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Customer Name</th>
                                                                <th style="width:15%;color:white; border: 0.1px solid white;background-color:#00cfe8;">TIN Number</th>
                                                                <th style="width:15%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Default Price</th>
                                                                <th style="width:10%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Sales Income</th>
                                                                <th style="width:10%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Sales Profit</th>
                                                                <th style="width:10%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Rank</th>
                                                                <th style="width:10%;color:white; border: 0.1px solid white;background-color:#00cfe8;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot><tr></tr></tfoot>
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

<script type="text/javascript">

    $(function () {
        cardSection = $('#page-block');
    });

    $(function () {
        storeSection = $('#storediv');
    });

    $(function () {
        itemSection = $('#itemdiv');
    });

    $(document).ready(function() {
        $('#fiscalyears').selectpicker('refresh');
        $('#store').selectpicker('refresh');
        $('#paymenttype').selectpicker('refresh');
        $('#pullouttype').selectpicker('refresh');
        $('#itgroup').selectpicker('refresh');
        $('#RankBy').selectpicker('refresh');
        $('#SortBy').selectpicker('refresh');
        var fy = $('#fiscalyears').val();
        var nextfy=parseFloat(fy)+1;
        var startdate=$('#sdval').val();
        var enddate=$('#edval').val();
        $('#fromhidden').val(fy + "-07-08");
        $('#exportdiv').hide();
        $("#date").flatpickr({
            maxDate: enddate,
            minDate: startdate,
        });
        $("#todate").flatpickr({
            maxDate: enddate,
            minDate: startdate,
        });
    });

    $(document).ready(function() {
        $('#itgroup').val(null).trigger('change');
        $("#printable").hide();
        var fy=$('#fiscalyears').val();
        $('#date').val(fy+"-07-08");
        $('#todate').val("");
        $("#items").empty(); 
        $("#store").empty(); 
        $('#store').selectpicker('refresh');  
        var registerForm = $("#profitandlossform");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getdspostore/'+fy,
            type:'DELETE',
            data:formData,
            success:function(data)
            {
                if(data.query)
                {
                    // var seloption = "<option disabled value='0'></option>";
                    // $("#store").append(seloption); 
                    var len=data['query'].length;
                    for(var i=0;i<=len;i++)
                    {
                        var storeid=data['query'][i].StoreId;
                        var storename=data['query'][i].StoreName;
                        var option = "<option value='"+storeid+"'>"+storename+"</option>";
                        $("#store").append(option); 
                        $('#store').selectpicker('refresh');  
                    }
                }    
            },
        });
    });

    $('#reportbutton').click(function() {
        var fr = $('#date').val();
        var tr = $('#todate').val();
        var storeval = $('#store').val();
        var fiscalyears = $('#fiscalyears').val();
        var itgrp = $('#itgroup').val();
        var paytype = $('#paymenttype').val();
        var rankbyval = $('#RankBy').val();
        var sortbyval = $('#SortBy').val();
        var numofcusval = $('#NumberOfCustomers').val();
        var potype = $('#pullouttype').val();
        var selectedstore="";
        var selecteditemgrp="";
        var fiscalyearselected="";
        var itemnames="";
        var paymenttypevals="";
        var rankbytotal="";
        var sortbytotal="";
        var pullouttypeval="";
        var pulloutheadertype="";
        if(storeval==''||storeval=='0'||storeval==null||fiscalyears==''||fr==''||tr==''||itgrp == ''||paytype == ''||rankbyval == ''||sortbyval == ''||numofcusval == ''||numofcusval == '0'||potype == ''){
            if(storeval==''||storeval=='0'||storeval==null)
            {
                $('#store-error').html('Point of sales is required');
            }
            if(fiscalyears=='')
            {
                $('#fiscalyear-error').html('Fiscal year is required');
            }
            if(fr=='')
            {
                $('#date-error').html('From date is required');
            }
            if(tr==''||tr==null)
            {
                $('#todate-error').html('To date is required');
            }
            if (itgrp == '') {
                $('#itemgrp-error').html('Item group is required');
            } 
            if (paytype == '') {
                $('#paymenttype-error').html('Payment type is required');
            } 
            if (rankbyval == '') {
                $('#rankby-error').html('Rank by is required');
            }
            if (sortbyval == '') {
                $('#sortby-error').html('Sort by is required');
            }
            if (potype == '') {
                $('#pullouttype-error').html('PullOut type is required');
            }
            if (numofcusval == '') {
                $('#numofcus-error').html('Number of customer is required');
            }
            if (numofcusval == '0') {
                $('#numofcus-error').html('Number of customer cannot be zero');
            }
            toastrMessage("error", "Please fill all required fields","Error");
        }
        else{
            $('#store-error').html("");
            $('#fiscalyear-error').html("");
            $('#itemgrp-error').html("");
            $('#date-error').html("");
            $('#todate-error').html("");
            var registerForm = $("#profitandlossform");
            var formData = registerForm.serialize();
            $("#store :selected").each(function() {
                selectedstore+=this.text+" , ";
            });
            $("#itgroup :selected").each(function() {
                selecteditemgrp+=this.text+" , ";
            });
            $("#fiscalyears :selected").each(function() {
                fiscalyearselected+=this.text+"  ";
            });
            $("#paymenttype :selected").each(function() {
                paymenttypevals+=this.text+" , ";
            });
            $("#RankBy :selected").each(function() {
                rankbytotal+=this.text+"  ";
            });
            $("#SortBy :selected").each(function() {
                sortbytotal+=this.text+"  ";
            });
            $("#pullouttype :selected").each(function() {
                pulloutheadertype+=this.text+" , ";
            });
            $('#daterange').html('<b>'+fr+'</b> to <b>'+tr+'</b>');
            $('#fiscalyearlbl').html('<b>'+fiscalyearselected+'</b>');
            $('#selectedstorelbl').html('<b>'+selectedstore+'</b>');
            $('#itemgrouplbl').html('<b>'+selecteditemgrp+'</b>');
            $('#paymenttypelbl').html('<b>'+paymenttypevals+'</b>');
            $('#selectedrankbylbl').html('<b>'+rankbytotal+'</b>');
            $('#selectedsortedbylbl').html('<b>'+sortbytotal+'</b>');
            $('#potypelbl').html('<b>'+pulloutheadertype+'</b>');
            var table = $("#cusrankdatatbl").DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: true,
                fixedHeader: true,
                searchHighlight: true,
                responsive:true,
                    "pagingType": "simple",
                    language: {
                        search: '',
                        searchPlaceholder: "Search here"
                    },
                    // scrollY:'55vh',
                    // scrollX: true,
                    // scrollCollapse: true,
                    "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/dscusranktbl/' + fr + '/' + tr + '/' + storeval + '/' + fiscalyears + '/' + itgrp+'/'+paytype+'/'+rankbyval+'/'+sortbyval+'/'+numofcusval,
                        type: 'POST',
                        dataType: "json",
                        data:{
                            pullouttypeval: $('#pullouttype').val(),
                        },
                        beforeSend: function () { 
                            cardSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                                css: {
                                backgroundColor: 'transparent',
                                color: '#fff',
                                border: '0'
                                },
                                overlayCSS: {
                                opacity: 0.5
                                }
                            });
                        },
                        complete: function () { 
                            cardSection.block({
                                message:
                                    '',
                                    timeout: 1,
                                    css: {
                                    backgroundColor: '',
                                    color: '',
                                    border: ''
                                    }, 
                            });     
                        },
                    },
                    buttons: true,
                    ordering: false,
                    paging: false,
                    columns: [{
                            data: "CustomerCode",
                            name: "CustomerCode",
                            width:"14%",
                        },
                        {
                            data: "CustomerName",
                            name: "CustomerName",
                            width:"15%",
                        },
                        {
                            data: "TinNumber",
                            name: "TinNumber",
                            width:"10%",
                        },
                        {
                            data: "DefaultPrice",
                            name: "DefaultPrice",
                            width:"14%",
                        },
                        {
                            data: "Revenue",
                            name: "Revenue",
                            render:function(data,type,row,meta){
                                var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                                switch(rankbyval){
                                    case 'Revenue':
                                        return "<b>"+numberendering(data)+"</b>";
                                        break;
                                    default:
                                        return numberendering(data);
                                }
                            },
                            width:"12%",
                        },
                        {
                            data: "GrossProfit",
                            name: "GrossProfit",
                            render:function(data,type,row,meta){
                                var numformats = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                                switch(rankbyval){
                                    case 'GrossProfit':
                                        return "<b>"+numformats(data)+"</b>";
                                        break;
                                    default:
                                        return numformats(data);
                                }
                            },
                            width:"15%",
                        },
                        { data:'DT_RowIndex',width:"5%",},
                        {
                            data: "QuantitySold",
                            name: "QuantitySold",
                            width:"14%",
                            'visible': false,
                        },
                    ],
                    columnDefs: [
                        {
                            width: '2%', targets: 0 ,
                            targets: [0,1,2,3,4,5,6],
                            createdCell: function (td, cellData, rowData, row, col){
                                $(td).css('border','0.1px solid black');
                                $(td).css('color','black');
                            }
                        },
                    ],
                });
                $("#printable").show();  
                $('#exportdiv').show();
            }
        });

    $('#fiscalyears').change(function() {
        var fy=$('#fiscalyears').val();
        var nextfy=parseFloat(fy)+1;
        var startdate=fy +"-07-08";
        var enddate=nextfy +"-07-07";
        var sd=new Date(startdate);
        var ed=new Date(enddate);

        $("#date").flatpickr({
            minDate: sd,
            maxDate: ed,
        });

        $("#todate").flatpickr({
            minDate: sd,
            maxDate: ed,
        });
        $("#store").empty(); 
        $('#items').selectpicker('refresh');  
        $('#store').selectpicker('refresh');  
        var registerForm = $("#profitandlossform");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getdspostore/'+fy,
            type:'DELETE',
            data:formData,
            beforeSend: function () { 
            storeSection.block({
                    message:
                    '<div class="d-flex justify-content-center align-items-center"><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                    css: {
                    backgroundColor: 'transparent',
                    color: '#fff',
                    border: '0'
                    },
                    overlayCSS: {
                    opacity: 0.5
                    }
                });
            },
            
            success:function(data)
            {
                storeSection.block({
                    message:
                        '',
                        timeout: 1,
                        css: {
                        backgroundColor: '',
                        color: '',
                        border: ''
                        }, 
                }); 

                if(data.query)
                {
                    // var seloption = "<option disabled value=''></option>";
                    // $("#store").append(seloption); 
                    var len=data['query'].length;
                    for(var i=0;i<=len;i++)
                    {
                        var storeid=data['query'][i].StoreId;
                        var storename=data['query'][i].StoreName;
                        var option = "<option value='"+storeid+"'>"+storename+"</option>";
                        $("#store").append(option); 
                        $('#store').selectpicker('refresh');  
                    }
                }   
            },
        });

        $('#date').val(startdate);
        $('#todate').val("");
    });

    $("#downloatoexcel").click(function(){
        $("#headertables").empty();
        var datefrom=$('#date').val();
        var dateto=$('#todate').val();
        let tbl = document.getElementById('cusrankdatatbl');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
        $("#cusrankdatatbl").table2excel({
            name: "Worksheet Name",
            filename: "DSCustomerRankReport "+datefrom+' to '+dateto, //do not include extension
            fileext: ".xls" //// file extension
        });
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
            $('.paymenttr').show();
            $('#compinfotr').show();

        let tbl = document.getElementById('cusrankdatatbl');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        let header = tbl.getElementsByTagName('thead')[0];
        header.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
    
        var divToPrint=document.getElementById("cusrankdatatbl");
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
        $('.paymenttr').hide();
        $("#headertables").empty();
    });

  
    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }

    function dateVal() {
        $('#date-error').html("");
    }

    function todateVal() {
        $('#todate-error').html("");
    }

    function storeVal() {
        $('#store-error').html("");
    }

    function itemgroup() {
        $('#itemgrp-error').html("");
    }

    function clearptype(){
        $('#paymenttype-error').html('');
    }

    function profitlossval(){
        $('#profitloss-error').html('');
    }

    function rankbyval(){
        $('#rankby-error').html('');
    }

    function sortbyval(){
        $('#sortby-error').html('');
    }

    function numofcus(){
        $('#numofcus-error').html('');
    }

    function pullouttypeval(){
        $('#pullouttype-error').html('');
    }
</script>
@endsection