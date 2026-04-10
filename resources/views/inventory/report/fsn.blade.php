@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('FSNAnalysis-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">FSN <i>(Fast-Moving,Slow-Moving,Non-Moving)</i> Analysis Report</h3>
                            </div>
                            <div class="card-datatable">
                                <div style="width:100%;">
                                    <form id="movemntform" name="mforms">
                                     @csrf
                                        <div style="width:98%; margin-left:1%; margin-top:2%;">
                                            <div class="row">
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
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
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" id="date" name="date"
                                                            class="form-control form-control-sm" placeholder="YYYY-MM-DD"
                                                            onchange="dateVal()" readonly="true" />
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="date-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">To</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" id="todate" name="todate"
                                                            class="form-control flatpickr-basic form-control-sm"
                                                            placeholder="YYYY-MM-DD" onchange="todateVal()" />
                                                    </div>
                                                        <span class="text-danger">
                                                            <strong id="todate-error"></strong>
                                                        </span>
                                                </div>
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="storediv">
                                                    <label strong style="font-size: 14px;color">Store/Shop</label>
                                                    <select class="selectpicker form-control store" id="store" name="store[]" data-live-search="true" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Store/Shop ({0})"></select>
                                                    <span class="text-danger">
                                                        <strong id="store-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2 itemdiv">
                                                    <label strong style="font-size: 14px;color">Item Group</label>
                                                    <select class="selectpicker form-control" id="itemgroup" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Item Group ({0})" onchange="clearitemgrp()">
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="itemgroup-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2 itemdiv" id="itemdiv">
                                                    <label strong style="font-size: 14px;color">Item(s)</label>
                                                    <select class="selectpicker form-control" id="itemsv" name="itemsv[]" data-live-search="true" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" onchange="itemval()" data-selected-text-format="count" data-count-selected-text="Items ({0})"></select>
                                                    <span class="text-danger">
                                                        <strong id="items-error"></strong>
                                                    </span>
                                                    <div style="display:none;">
                                                        <select id="items" name="items[]" data-live-search="true" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Items ({0})"></select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;color">FSN Classification</label>
                                                        <div>
                                                            <select class="selectpicker form-control" id="fsncl" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="FSN Classification ({0})" onchange="clearfsn()">
                                                                <option value='"Fast-Moving"'>Fast-Moving</option> 
                                                                <option value='"Slow-Moving"'>Slow-Moving</option> 
                                                                <option value='"Non-Moving"'>Non-Moving</option>                 
                                                            </select>
                                                        </div>
                                                        <span class="text-danger">
                                                    <strong id="fsncl-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                    <div class="row" style="color:white;">
                                                        .
                                                    </div>
                                                    <div class="row">
                                                        <input type="hidden" placeholder="" class="form-control" name="fromhidden" id="fromhidden" readonly="true" value="" />
                                                        <input type="hidden" placeholder="" class="form-control" name="tohidden" id="tohidden" readonly="true" value="" />
                                                        <button id="reportbutton" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>    View</button>
                                                        <div style="width: 1%;"></div>
                                                        <div class="btn-group dropdown" id="exportdiv" style="display: none;">
                                                            <button type="button" class="btn btn-info dropdown-toggle hide-arrow btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span> Print / Export </span><i class="fa fa-caret-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <button id="printtable" type="button" class="dropdown-item" ><i class="fa fa-print" aria-hidden="true"></i>  Print</button>
                                                                <button id="downloatoexcel" type="button"  class="dropdown-item"><i class="fa fa-file-excel" aria-hidden="true"></i> To Excel</button>
                                                            </div>
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
                                               <table id="fsntable" class="table" style="width: 100%;">
                                                    <thead>
                                                        <tr style="display: none;" class="compinfotr">
                                                            <th colspan="13">
                                                                <table id="headertables" class="headerTable" style="border-bottom: 1px solid black; margin-top:-60px;width:100%;"></table>
                                                            </th>
                                                        </tr>
                                                        <tr style="display: none;" class="compinfotr">
                                                            <td colspan="13">
                                                                <h3><p style="text-align:center; margin:top:-10px;color:#00cfe8;font-family: 'Segoe UI', Verdana, Helvetica, Sans-Serif;"><b>FSN Analysis Report</b></p></h3>
                                                            </td>
                                                        </tr>
                                                        <tr id="daterangetr" style="display: none;">
                                                            <td style="border: 0.1px solid black;"><label strong style="font-size: 14px;">Fiscal Year</label></td>
                                                            <td colspan="4" style="border: 0.1px solid black;"><label id="fiscalyearlbl" strong style="font-size: 14px;"></label></td>
                                                            <td colspan="3" style="border: 0.1px solid black;"><label strong style="font-size: 14px;">Date Range</label></td>
                                                            <td colspan="5" style="border: 0.1px solid black;"><label id="daterange" strong style="font-size: 14px;"></label></td>
                                                          
                                                        </tr>
                                                        <tr id="titletr" style="display: none;">
                                                            <td style="border: 0.1px solid black;"><label strong style="font-size: 14px;">Item Group</label></td>
                                                            <td colspan="4" style="border: 1px solid black;"><label id="itemgrp" strong style="font-size: 14px;"></label></td>
                                                            <td colspan="3" style="border: 0.1px solid black;"><label strong style="font-size: 14px;">FSN Classification</label></td>
                                                            <td colspan="5" style="border: 1px solid black;"><label id="fsnclassification" strong style="font-size: 14px;"></label></td>
                                                        </tr>
                                                        <tr id="paymenttr" style="display: none;">
                                                            <td style="border: 0.1px solid black;"><label strong style="font-size: 14px;">Store/Shop</label></td>
                                                            <td colspan="12" style="border: 1px solid black;"><label id="selectedstorelbl" strong style="font-size: 14px;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;">Item Code</th>
                                                            <th style="width:30%;color:white; border:0.1px solid white;background-color:#00cfe8;">Item Name</th>
                                                            <th style="width:30%;color:white; border:0.1px solid white;background-color:#00cfe8;">SKU Number</th>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;">Category</th>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;">UOM</th>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;">Item Group</th>
                                                            <th style="width:20%;color:white; border:0.1px solid white;background-color:#00cfe8;">Store/Shop Name</th>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;">Beginning Stock</th>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;">Ending Stock</th>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;">Average Stock</th>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;">Sold Quantity</th>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;">Turnover Ratio</th>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;">FSN Classification</th>
                                                            <th style="width:5%;color:white; border:0.1px solid white;background-color:#00cfe8;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
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
    
    $(document).ready( function () 
    {
        $('#fiscalyears').selectpicker('refresh');
        $('#store').selectpicker('refresh');
        $('#itemgroup').selectpicker('refresh');
        $('#itemsv').selectpicker('refresh');
        $('#fsncl').selectpicker('refresh');
        var fy=$('#fiscalyears').val();
        $('#date').val(fy+"-07-08");
        $('#exportdiv').hide();
    });

    $("#downloatoexcel").click(function(){
        $("#headertables").empty();
        var datefrom=$('#date').val();
        var dateto=$('#todate').val();
        let tbl = document.getElementById('fsntable');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
        $("#fsntable").table2excel({
            name: "Worksheet Name",
            filename: "FSNAnalysisReport"+datefrom+' to '+dateto, //do not include extension
            fileext: ".xls" // file extension
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
        $('#paymenttr').show();
        $('.compinfotr').show();

        let tbl = document.getElementById('fsntable');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        let header = tbl.getElementsByTagName('thead')[0];
        header.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
    
        var divToPrint=document.getElementById("fsntable");
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
            
        $('.compinfotr').hide();
        $('#daterangetr').hide();
        $('#titletr').hide();
        $('#paymenttr').hide();
        $("#headertables").empty();
    });

    $(function () {
        cardSection = $('#page-block');
    });

    $(function () {
        storeSection = $('#storediv');
    });

    $(function () {
        itemSection = $('.itemdiv');
    });

    $(document).ready(function () 
    {
        $("#printable").hide();
        var fy=$('#fiscalyears').val();
        $('#date').val(fy+"-07-08");
        $('#todate').val("");
        $("#items").empty(); 
        $("#store").empty(); 
        $('#items').selectpicker('refresh');  
        $('#store').selectpicker('refresh');  
        var registerForm = $("#movemntform");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getStoreBySelectedFyearFsn/'+fy,
            type:'DELETE',
            data:formData,
            success:function(data)
            {
                if(data.query)
                {
                    var seloption = "<option disabled value=''></option>";
                    $("#store").append(seloption); 
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

    $('#store').change(function() {
        $("#items").empty(); 
        $("#itemsv").empty(); 
        $("#itemgroup").empty(); 
        $('#store-error').html("");
        var str=$('#store').val();
        var fy=$('#fiscalyears').val();
        var stores="0";
        if(str.length===0){
            stores="000";
            $("#items").empty(); 
            $('#items').selectpicker('refresh');  
            $("#itemsv").empty(); 
            $('#itemsv').selectpicker('refresh');  
            $("#itemgroup").empty(); 
            $('#itemgroup').selectpicker('refresh'); 
        }
        else{
            stores=str;
            var opt='<option value="Local">Local</option><option value="Imported">Imported</option>';
            $("#itemgroup").append(opt); 
            $('#itemgroup').selectpicker('refresh');  
        }
        var registerForm = $("#movemntform");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getItemsBySelectedStoreFsn/'+stores+'/'+fy,
            type:'DELETE',
            data:formData,
            beforeSend: function () { 
                itemSection.block({
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
                        var itemid=data['query'][i].ItemId;
                        var itemname=data['query'][i].ItemName;
                        var code=data['query'][i].Code;
                        var skunum=data['query'][i].SKUNumber;
                        var igroup=data['query'][i].ItemGroup;
                        var option = "<option title='"+igroup+"' value='"+itemid+"'>"+code+' , '+itemname+','+skunum+"</option>";
                        $("#items").append(option); 
                        $('#items').selectpicker('refresh');  
                    }
                }
            },
        });
    });

    $('#fiscalyears').change(function() {
        $("#printable").hide();
        var fy=$('#fiscalyears').val();
        $('#date').val(fy+"-07-08");
        var nextfy=parseFloat(fy)+1;
        var startdate=fy +"-07-08";
        var enddate=nextfy +"-07-07";
        var sd=new Date(startdate);
        var ed=new Date(enddate);
        $("#todate").flatpickr({
            minDate: sd,
            maxDate: ed,
        });
        $('#todate').val("");
        $("#items").empty(); 
        $("#store").empty(); 
        $('#items').selectpicker('refresh');  
        $('#store').selectpicker('refresh');  
        var registerForm = $("#movemntform");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getStoreBySelectedFyearFsn/'+fy,
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
                    var seloption = "<option disabled value=''></option>";
                    $("#store").append(seloption); 
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

    $('#reportbutton').click(function()
    {    
        var fr=$('#date').val(); 
        var tr=$('#todate').val(); 
        var storeval=$('#store').val(); 
        var fiscalyears=$('#fiscalyears').val(); 
        var items=$('#itemsv').val(); 
        var itemsgrp=$('#itemgroup').val();
        var fsnclassification=$('#fsncl').val(); 
        var selectedstore="";
        var selectedfiscalyear="";
        var selectedfsn="";
        var itemgroupsv="";
        var itemnames="";
        var fsnclass="";
        if(storeval==''||fiscalyears==''||items==''||fr==''||tr==''||itemsgrp==''||fsnclassification==''){
            if(storeval=='')
            {
                $('#store-error').html('Store/Shop is required');
            }
            if(fiscalyears=='')
            {
                $('#fiscalyear-error').html('Fiscal year is required');
            }
            if(items=='')
            {
                $('#items-error').html('Item is required');
            }
            if(fr=='')
            {
                $('#date-error').html('From date is required');
            }
            if(tr==''||tr==null)
            {
                $('#todate-error').html('To date is required');
            }
            if(itemsgrp=='')
            {
                $('#itemgroup-error').html('Item group is required');
            }
            if(fsnclassification=='')
            {
                $('#fsncl-error').html('FSN classification is required');
            }
            toastrMessage("error", "Please fill all required fields","Error");
        }
        else
        {   
            $('#store-error').html('');
            $('#fiscalyear-error').html('');
            $('#items-error').html('');
            $('#trtype-error').html('');
            $('#fsncl-error').html('');
            $(".store :selected").each(function() {
              selectedstore+=this.text+" , ";
            });
            $("#fiscalyears :selected").each(function() {
              selectedfiscalyear+=this.text+"  ";
            });
            $("#itemgroup :selected").each(function() {
              itemgroupsv+=this.text+" , ";
            });
            $("#fsncl :selected").each(function() {
              selectedfsn+=this.text+" , ";
            });
            var registerForm = $("#movemntform");
            var formData = registerForm.serialize();
            $('#daterange').html('<b>'+fr+'</b> to <b>'+tr+'</b>');
            $('#fiscalyearlbl').html('<b>'+selectedfiscalyear+'</b>');
            $('#selectedstorelbl').html('<b>'+selectedstore+'</b>');
            $('#itemgrp').html('<b>'+itemgroupsv+'</b>');
            $('#fsnclassification').html('<b>'+selectedfsn+'</b>');
            var table = $("#fsntable").DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: true,
                fixedHeader: true,
                responsive:true,
                searchHighlight: true,
                contentType: false, 
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
                        dataType: "json",
                        headers: {
                            //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'ContentType':'application/json'
                        },
                        url: '/fsnreport/' + fr + '/' + tr + '/' + storeval + '/' + fiscalyears,
                        type: 'POST',
                        data:{
                            itemnames: $('#itemsv').val(),
                            fsnclass: $('#fsncl').val(),
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
                            data: "ItemCode",
                            name: "ItemCode",
                            width:"7%",
                        },
                        {
                            data: "ItemName",
                            name: "ItemName",
                            width:"28%",
                        },
                         {
                            data: "SKUNumber",
                            name: "SKUNumber",
                            width:"18%",
                        },
                        {
                            data: "Category",
                            name: "Category",
                            width:"10%",
                        },
                         {
                            data: "UOM",
                            name: "UOM",
                            width:"5%",
                        },
                         {
                            data: "ItemGroup",
                            name: "ItemGroup",
                            width:"5%",
                            'visible': false
                        },
                        {
                            data: "StoreName",
                            name: "StoreName",
                            width:"7%",
                        },
                        {
                            data: "BeginningInv",
                            name: "BeginningInv",
                            width:"5%",
                            render: $.fn.dataTable.render.number(',', '.', 2, '')
                        },
                        {
                            data: "EndingInv",
                            name: "EndingInv",
                            width:"5%",
                            render: $.fn.dataTable.render.number(',', '.', 2, '')
                        },
                        {
                            data: "AverageInv",
                            name: "AverageInv",
                            width:"5%",
                            render: $.fn.dataTable.render.number(',', '.', 2, '')
                        },
                        {
                            data: "COGS",
                            name: "COGS",
                            width:"5%",
                            render: $.fn.dataTable.render.number(',', '.', 2, '')
                        },
                        {
                            data: "TurnoverRatio",
                            name: "TurnoverRatio",
                            width:"5%",
                            render: $.fn.dataTable.render.number(',', '.', 2, '')
                        },
                        {
                            data: "FSNClassification",
                            name: "FSNClassification",
                            width:"5%",
                            render: $.fn.dataTable.render.number(',', '.', 2, '')
                        },
                        {
                            data: "ItemNames",
                            name: "ItemNames",
                            width:"0%",
                            'visible': false
                        },
                    ],
                    columnDefs: [
                        {
                           "width": "100%",
                            targets: [0,1,2,3,4,5,6,7,8,9,10,11,12,13],
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
                    rowGroup: {
                        startRender: function ( rows, group ) {
                        var color = 'style="color:black;font-weight:bold;background:#f2f3f4;"';
                        return $('<tr ' + color + '/>').append('<td colspan="13" style="text-align:center;border:0.1px solid;"> ' + group + '</td>');
                    },
                    endRender: function ( rows, group ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };
                        var color = 'style="color:black;font-weight:bold;background:#f2f3f4;"';
                        return $('<tr ' + color + '/>').append('<td colspan="13" style="text-align:center;border:0.1px solid;">---</td>');     
                    }, 
                    dataSrc: 'ItemName'
                },
            });
            $('#exportdiv').show();
            $("#printable").show();
        }
    }); 

    function dateVal()
    {
        $( '#date-error' ).html("");
    }

    function todateVal()
    {
        $( '#todate-error' ).html("");
    } 

    function itemval() {
        $('#items-error').html("");
    }

    function trtypeval() {
        $('#trtype-error').html("");
    }

    function clearfsn() {
        $('#fsncl-error').html("");
    }

    function clearitemgrp() {
        var ig=$("#itemgroup").val();
        $('#itemsv').empty(); 
        if(ig=="Local"){
            var options = $("#items > option").clone();
            $('#itemsv').append(options); 
            $("#itemsv option[title!='"+ig+"']").remove();   
        }
        else if(ig=="Imported"){
            var options = $("#items > option").clone();
            $('#itemsv').append(options); 
            $("#itemsv option[title!='"+ig+"']").remove();   
        }
        else if(ig=="Local,Imported"){
            var options = $("#items > option").clone();
            $('#itemsv').append(options); 
        }
        else{
            $('#itemsv').empty(); 
        }
        $('#itemsv').selectpicker('refresh'); 
        $('#itemgroup-error').html("");
    }

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }


    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }
    </script>
@endsection
  