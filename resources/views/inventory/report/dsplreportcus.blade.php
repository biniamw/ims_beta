@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('DS-PLByCustomer-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">DS Profit & Loss By Customer Report</h3>
                            </div>
                            <div class="card-datatable">
                                <div style="width:100%;">
                                    <form id="profitandlossform">
                                        @csrf
                                        <div style="width:98%; margin-left:1%; margin-top:2%;">
                                            <div class="row">
                                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;color">Fiscal Year</label>
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
                                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="storediv">
                                                    <label strong style="font-size: 14px;color">Point of Sales</label>
                                                    <select class="selectpicker form-control" id="store" name="store[]" multiple="multiple" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Point of Sales ({0})" onchange="storeVal()"></select>
                                                    <span class="text-danger">
                                                        <strong id="store-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;color">Payment Type</label>
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
                                                    <label strong style="font-size: 14px;color">Item Group</label>
                                                    <div>
                                                        <select class="selectpicker form-control" id="itgroup" name="itgroup[]" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Item Group ({0})" onchange="clearitemgrp()">
                                                            <option value='"Local"'>Local</option>
                                                            <option value='"Imported"'>Imported</option>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="itemgrp-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2 itemdiv" id="itemdiv">
                                                    <label strong style="font-size: 14px;color">Customer(s)</label>
                                                    <select class="selectpicker form-control" id="customers" name="customers[]" data-live-search="true" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" onchange="custval()" data-selected-text-format="count" data-count-selected-text="Customers ({0})"></select>
                                                    <span class="text-danger">
                                                        <strong id="customers-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">Profit or Loss</label>
                                                    <div>
                                                        <select class="selectpicker form-control" id="ProfitOrLoss" name="ProfitOrLoss[]" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Profit or Loss ({0})" onchange="profitlossval()">
                                                            <option value="1">Profit</option>
                                                            <option value="0">Loss</option>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="profitloss-error"></strong>
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
                                                        <div style="width: 1%;"></div>
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
                                        <button type="button" class="btn btn-gradient-info btn-sm" style="color: white;display:none;"
                                        onclick="printDiv('printable')" title="Print"><i data-feather='printer'></i></button>
                                    </div>
                                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                        <div style="width: 100%;">
                                            <div class="table-responsive">
                                                <div style="width:98%; margin-left:2%; margin-top:2%;">
                                                    <table id="plreporttable" class="table" style="width: 100%;color:black;">
                                                        <thead>
                                                            <tr style="display: none;" id="compinfotr">
                                                                <th colspan="13">
                                                                    <table id="headertables" class="headerTable" style="border-bottom: 1px solid black; margin-top:-60px;width:100%;"></table>
                                                                </th>
                                                            </tr>
                                                            <tr id="daterangetr" style="display: none;">
                                                                <th colspan="13">
                                                                    <h4><p style="text-align:center; margin:top:-10px;color:#00cfe8;font-family: 'Segoe UI', Verdana, Helvetica, Sans-Serif;"><b>DS Profit & Loss By Customer Report</b></p></h4>
                                                                </th>
                                                            </tr>
                                                            <tr id="titletr" style="display: none;">
                                                                <th colspan="3" style="border: 1px solid black;"><label strong style="font-size: 14px;">Fiscal Year</label></th>
                                                                <th colspan="3" style="border: 1px solid black;"><label id="fiscalyearlbl" strong style="font-size: 14px;"></label></th>
                                                                <th colspan="3" style="border: 1px solid black;"><label strong style="font-size: 14px;">Date Range</label></th>
                                                                <th colspan="4" style="border: 1px solid black;"><label id="daterange" strong style="font-size: 14px;"></label></th>
                                                            </tr>
                                                            <tr class="paymenttr" style="display: none;">
                                                                <th colspan="3" style="border: 1px solid black;"><label strong style="font-size: 14px;">Payment Type</label></th>
                                                                <th colspan="3" style="border: 1px solid black;"><label id="paymenttypelbl" strong style="font-size: 14px;"></label></th>
                                                                <th colspan="3" style="border: 1px solid black;"><label strong style="font-size: 14px;">PullOut Type</label></th>
                                                                <th colspan="4" style="border: 1px solid black;"><label id="potypelbl" strong style="font-size: 14px;"></label></th>
                                                            </tr>
                                                            <tr class="paymenttr" style="display: none;">
                                                                <th colspan="3" style="border: 1px solid black;"><label strong style="font-size: 14px;">Item Group</label></th>
                                                                <th colspan="3" style="border: 1px solid black;"><label id="itemgrouplbl" strong style="font-size: 14px;"></label></th>
                                                                <th colspan="3" style="border: 1px solid black;"><label strong style="font-size: 14px;">Profit or Loss</label></th>
                                                                <th colspan="4" style="border: 1px solid black;"><label id="profitlosslbl" strong style="font-size: 14px;"></label></th>
                                                            </tr>
                                                            <tr class="paymenttr" style="display: none;">
                                                                <th colspan="3" style="border: 1px solid black;"><label strong style="font-size: 14px;">Point of Sales</label></th>
                                                                <th colspan="10" style="border: 1px solid black;"><label id="selectedstorelbl" strong style="font-size: 14px;"></label></th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="13" style="color:black; border-bottom-color: black;background-color:white;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:15%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Item Code</th>
                                                                <th style="width:25%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Item Name</th>
                                                                <th style="width:15%;color:white; border: 0.1px solid white;background-color:#00cfe8;">SKU Number</th>
                                                                <th style="width:15%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Item Group</th>
                                                                <th style="width:0%;color:white; border: 0.1px solid white;background-color:#00cfe8;">UOM</th>
                                                                <th style="width:15%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Payment Type</th>
                                                                <th style="width:15%;color:white; border: 0.1px solid white;background-color:#00cfe8;">PullOut Type</th>
                                                                <th style="width:15%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Point of Sales</th>
                                                                <th style="width:10%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Sold Quantity</th>
                                                                <th style="width:10%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Sales Income</th>
                                                                <th style="width:10%;color:white; border: 0.1px solid white;background-color:#00cfe8;">COGS</th>
                                                                <th style="width:10%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Sales Profit</th>
                                                                <th style="width:10%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Sales Profit Margin</th>
                                                                <th style="width:0%;color:white; border: 0.1px solid white;background-color:#00cfe8;"></th>
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
        itemSection = $('.itemdiv');
    });

    $(document).ready(function() {
        $('#fiscalyears').selectpicker('refresh');
        $('#store').selectpicker('refresh');
        $('#paymenttype').selectpicker('refresh');
        $('#pullouttype').selectpicker('refresh');
        $('#itgroup').selectpicker('refresh');
        $('#customers').selectpicker('refresh');
        $('#ProfitOrLoss').selectpicker('refresh');
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

    $('#store').change(function() {
        $("#customers").empty(); 
        $('#store-error').html("");
        var str=$('#store').val();
        var fy=$('#fiscalyears').val();
        
        var registerForm = $("#profitandlossform");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getDsCusBySelectedStorePl/'+str+'/'+fy,
            type:'DELETE',
            data:formData,
            beforeSend: function () { 
                itemSection.block({
                    message:
                    '<div class="d-flex justify-content-center align-items-center"><div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
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
                itemSection.block({
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
                    var len=data['query'].length;
                    for(var i=0;i<=len;i++)
                    {
                        var cusid=data['query'][i].CustomerId;
                        var cusname=data['query'][i].CustomerName;
                        var code=data['query'][i].Code;
                        var tinnum=data['query'][i].TinNumber;
                        var option = "<option value='"+cusid+"'>"+code+' , '+cusname+' ,   '+tinnum+"</option>";
                        $("#customers").append(option); 
                        $('#customers').selectpicker('refresh');  
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
        var cust=$('#customers').val();
        var pltype = $('#ProfitOrLoss').val(); 
        var potype = $('#pullouttype').val();
        var selectedstore="";
        var selecteditemgrp="";
        var fiscalyearselected="";
        var itemnames="";
        var customersname="";
        var paymenttypevals="";
        var profitlosstype="";
        var pullouttypeval="";
        var pulloutheadertype="";
        if(storeval==''||storeval=='0'||storeval==null||fiscalyears==''||fr==''||tr==''||itgrp == ''||paytype == ''||cust==''||pltype == ''||potype == ''){
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
            if(cust=='')
            {
                $('#customers-error').html('Customer is required');
            }
            if (pltype == '') {
                $('#profitloss-error').html('Profit or loss is required');
            }
            if (potype == '') {
                $('#pullouttype-error').html('PullOut type is required');
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
                fiscalyearselected+=this.text+" , ";
            });
            $("#paymenttype :selected").each(function() {
                paymenttypevals+=this.text+" , ";
            });
            $("#ProfitOrLoss :selected").each(function() {
                profitlosstype+=this.text+" , ";
            });
            $("#pullouttype :selected").each(function() {
                pulloutheadertype+=this.text+" , ";
            });
            $('#daterange').html('<b>'+fr+'</b> to <b>'+tr+'</b>');
            $('#fiscalyearlbl').html('<b>'+fiscalyearselected+'</b>');
            $('#selectedstorelbl').html('<b>'+selectedstore+'</b>');
            $('#itemgrouplbl').html('<b>'+selecteditemgrp+'</b>');
            $('#paymenttypelbl').html('<b>'+paymenttypevals+'</b>');
            $('#profitlosslbl').html('<b>'+profitlosstype+'</b>');
            $('#potypelbl').html('<b>'+pulloutheadertype+'</b>');
            var table = $("#plreporttable").DataTable({
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
                        url: '/dsplreportcustbl/' + fr + '/' + tr + '/' + storeval + '/' + fiscalyears + '/' + itgrp+'/'+paytype+'/'+pltype,
                        type: 'POST',
                        dataType: "json",
                        data:{
                            customersname: $('#customers').val(),
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
                            data: "Code",
                            name: "Code",
                            width:"5%",
                        },
                        {
                            data: "ItemName",
                            name: "ItemName",
                            width:"10%",
                        },
                        {
                            data: "SKUNumber",
                            name: "SKUNumber",
                            width:"10%",
                        },
                        {
                            data: "ItemGroup",
                            name: "ItemGroup",
                            width:"10%",
                        },
                        {
                            data: "UOM",
                            name: "UOM",
                        },
                        {
                            data: "PaymentType",
                            name: "PaymentType",
                            width:"10%",
                        },
                        {
                            data: "POType",
                            name: "POType",
                        },
                        {
                            data: "StoreName",
                            name: "StoreName",
                            width:"10%",
                        },
                        {
                            data: "QuantitySold",
                            name: "QuantitySold",
                            render: $.fn.dataTable.render.number(',','.',0,''),
                            width:"10%",
                        },
                        {
                            data: "Revenue",
                            name: "Revenue",
                            render: $.fn.dataTable.render.number(',','.',2,''),
                            width:"10%",
                        },
                        {
                            data: "COGS",
                            name: "COGS",
                            width:"10%",
                            render: $.fn.dataTable.render.number(',','.',2,''),
                        },
                        {
                            data: "GrossProfit",
                            name: "GrossProfit",
                            width:"10%",
                            render: $.fn.dataTable.render.number(',','.',2,''),
                        },
                        {
                            data: "GrossProfitPer",
                            name: "GrossProfitPer",
                            width:"5%",
                            render: $.fn.dataTable.render.number(',','.',2,'','     %'),
                        },
                        {
                            data: "CustomerName",
                            name: "CustomerName",
                            'visible': false,
                        },
                        
                    ],
                    columnDefs: [
                        {
                            width: '2%', targets: 0 ,
                            targets: [0,1,2,3,4,5,6,7,8,9,10,11,12],
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
                    order: [[7, 'asc'],[6, 'asc'],[5, 'asc'], [13, 'asc']],
                    rowGroup: {
                        startRender: function ( rows, group,level ) {
                            var color = 'style="color:black;font-weight:bold;background:#f2f3f4;"';
                            if(level===0){
                                return $('<tr style="color:black" >')
                                .append('<td colspan="13" style="text-align:center;border: 0.1px solid black; background:#ccc;"><b>Point of Sales : ' + group + '</b></td></tr>')
                            }
                            else if(level==1){
                                return $('<tr style="color:black" >')
                                .append('<td colspan="13" style="text-align:center;border: 0.1px solid black;background:#f2f3f4;"><b>' + group + '  PullOut</b></td></tr>')
                            }
                            else if(level==2){
                                return $('<tr style="color:black" >')
                                .append('<td colspan="13" style="text-align:center;border: 0.1px solid black;background:#f2f3f4;"><b>Payment Type : ' + group + '</b></td></tr>')
                            }
                            else{
                                return $('<tr ' + color + '>')
                                .append('<td colspan="13" style="text-align:left;border:0.1px solid;">Customer : ' + group + '</td></tr>')
                            }                            
                        },
                        endRender: function (rows,group,level) {
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                            i : 0;
                            };
                            var revenueval = rows
                            .data()
                            .pluck('Revenue')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0); 
                            var cogsval = rows
                            .data()
                            .pluck('COGS')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0); 
                            var grossprofitval = rows
                            .data()
                            .pluck('GrossProfit')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0); 
                            var grossprofitperval = rows
                            .data()
                            .pluck('GrossProfitPer')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                            var profitmargin=(parseFloat(grossprofitval)/parseFloat(revenueval))*100;
                            var color = 'style="color:black;font-weight:bold;background:#f2f3f4;"';
                            if(level===0){
                                return $('<tr ' + color + '/>')
                                .append('<td colspan="9" style="text-align:right;border:0.1px solid;">Total of ' + group+ ' </td><td style="border:0.1px solid;">'+numformat(revenueval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(cogsval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(grossprofitval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(profitmargin.toFixed(2))+' %</td>');     
                            } 
                            else if(level==1){
                                return $('<tr ' + color + '/>')
                                .append('<td colspan="9" style="text-align:right;border:0.1px solid;">Total of ' + group+ ' </td><td style="border:0.1px solid;">'+numformat(revenueval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(cogsval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(grossprofitval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(profitmargin.toFixed(2))+' %</td>');     
                            }
                            else if(level==2){
                                return $('<tr ' + color + '/>')
                                .append('<td colspan="9" style="text-align:right;border:0.1px solid;">Total of ' + group+ ' </td><td style="border:0.1px solid;">'+numformat(revenueval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(cogsval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(grossprofitval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(profitmargin.toFixed(2))+' %</td>');     
                            }    
                            else{
                                return $('<tr ' + color + '/>')
                                .append('<td colspan="9" style="text-align:right;border:0.1px solid;">Total of ' + group+ ' </td><td style="border:0.1px solid;">'+numformat(revenueval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(cogsval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(grossprofitval.toFixed(2))+'</td><td style="border:0.1px solid;">'+numformat(profitmargin.toFixed(2))+' %</td>');     
                            }  
                        },  
                        dataSrc: ['StoreName','POType','PaymentType','CustomerName']
                    },
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(),data;
                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };
                        var revenuegt = api
                            .column(9)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        var cogsgt = api
                            .column(10)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        var grossprofitgt = api
                            .column(11)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        var grossprofitgtper = api
                            .column(12)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        var profitmargingt=(parseFloat(grossprofitgt)/parseFloat(revenuegt))*100;
                        var tf='<tr style="color:black;"><td colspan="9" class="text-right" style="color: black; font-weight:bold;border:0.1px solid;background:#f2f3f4;">Grand Total</td>'+
                                '<td style="font-weight:bold; color:black; border:0.1px solid;background:#f2f3f4;">'+numformat(revenuegt.toFixed(2))+'</td>'+
                                '<td style="font-weight:bold; color:black; border:0.1px solid;background:#f2f3f4;">'+numformat(cogsgt.toFixed(2))+'</td>'+
                                '<td style="font-weight:bold; color:black; border:0.1px solid;background:#f2f3f4;">'+numformat(grossprofitgt.toFixed(2))+'</td>'+
                                '<td style="font-weight:bold; color:black; border:0.1px solid;background:#f2f3f4;">'+numformat(profitmargingt.toFixed(2))+' %</td>'+
                                '</tr>';
                        $(table.table().footer()).empty().append(tf);
                    }
                });
                $("#printable").show();  
                $('#exportdiv').show();
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
        $('.paymenttr').show();
        $('#compinfotr').show();

        let tbl = document.getElementById('plreporttable');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        let header = tbl.getElementsByTagName('thead')[0];
        header.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
    
        var divToPrint=document.getElementById("plreporttable");
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

    $("#downloatoexcel").click(function(){
        $("#headertables").empty();
        var datefrom=$('#date').val();
        var dateto=$('#todate').val();
        let tbl = document.getElementById('plreporttable');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
        $("#plreporttable").table2excel({
        name: "Worksheet Name",
        filename: "DSProfit&LossReportbyCustomers "+datefrom+' to '+dateto, //do not include extension
        fileext: ".xls" // file extension
        });
    });

    function clearitemgrp() {
        $('#itemgrp-error').html("");
    }

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

    function itemval() {
        $('#items-error').html("");
    }

    function custval() {
        $('#customers-error').html("");
    }

    function profitlossval(){
        $('#profitloss-error').html('');
    }

    function pullouttypeval(){
        $('#pullouttype-error').html('');
    }
</script>
@endsection