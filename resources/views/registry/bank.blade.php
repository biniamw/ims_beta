@extends('layout.app1')

@section('title')
@endsection

@section('content')
    @can('Bank-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Banks</h3>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshBankDataFn()"><i class="fas fa-sync-alt"></i></button>
                                        @if (auth()->user()->can('Bank-Add'))
                                        <button type="button" class="btn btn-gradient-info btn-sm addbanks header-prop" id="addbanks"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                        @endcan 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable fit-content">
                            <div style="width:99%; margin-left:0.5%;" id="main-datatable" style="display: none">
                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width:3%;">#</th>
                                            <th style="width:50%;">Bank Name</th>
                                            <th style="width:43%;">Status</th>
                                            <th style="width:4%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table table-sm"></tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
    @endcan

    <!--Start Information Modal -->
    <div class="modal fade text-left fit-content" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Bank Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title bank_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                            <div class="d-flex align-items-center header-tab">
                                                <span class="text-uppercase font-weight-bold mr-50 toggle-text-label tab-text">Collapse</span>
                                                <div class="collapse-icon">
                                                    <i class="fas text-secondary fa-minus-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse show infoscl shadow pl-1 pr-1">
                                            <div class="row mb-1">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 mb-1">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Bank Name</label></td>
                                                                    <td><label class="info_lbl" id="banknamelbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Description</label></td>
                                                                    <td><label class="info_lbl" id="descriptionlbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Status</label></td>
                                                                    <td><label class="info_lbl" id="statuslbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 infoAccDiv table-responsive scroll scrdiv" id="acc_div">
                                    <table id="bankdetailtbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width: 3%">#</th>
                                                <th style="width: 17%">Account Number</th>
                                                <th style="width: 15%">Opening Balance</th>
                                                <th style="width: 15%">Contact Number</th>
                                                <th style="width: 20%">Branch</th>
                                                <th style="width: 20%">Description</th>
                                                <th style="width: 10%">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:left">
                                    <div class="btn-group dropup">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn form_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-up fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="bank_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="bankdelId" id="bankdelId" readonly="true">
                                    <button id="closebuttonk" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Information Modal -->

    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="banktitlelbl">Add Bank</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Bank Name<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" placeholder="Bank Name" class="form-control reg_form" name="BankName" id="BankName" onkeyup="bankNameFn()"/>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="name-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Description</label>
                                <textarea type="text" placeholder="Write Description here..." class="form-control reg_form" rows="1" name="Description" id="Description" onkeyup="descriptionfn()"></textarea>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="description-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Status<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control" name="status" id="status" onchange="statusFn()">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="status-error"></strong>
                                </span>
                            </div>
                        </div>
                        <hr class="my-30">
                        <div class="row" id="dynamicDiv">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                    <table id="dynamicTable" class="mb-0 rtable form_dynamic_table fit-content" style="width:100%;min-width: 900px;">  
                                        <thead>
                                            <tr>
                                                <th class="form_lbl" style="width:3%;">#</th>
                                                <th class="form_lbl" style="width:15%;" title="Account Number">Account No.<b style="color:red;">*</b></th>
                                                <th class="form_lbl" style="width:15%;">Opening Balance<b style="color:red;">*</b></th>
                                                <th class="form_lbl" style="width:15%;" title="Contact number of the branch">Contact No.</th>
                                                <th class="form_lbl" style="width:19%;">Branch</th>
                                                <th class="form_lbl" style="width:20%;">Description</th>
                                                <th class="form_lbl" style="width:10%;">Status<b style="color:red;">*</b></th>
                                                <th class="form_lbl" style="width:3%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" style="text-align: left !important;border: none;">
                                                    <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control reg_form" name="bankId" id="bankId" readonly="true" value=""/>     
                        <input type="hidden" class="form-control reg_form" name="operationtypes" id="operationtypes" readonly="true"/>
                        @can('Bank-Add')
                        <button id="savebutton" type="button" class="btn btn-info form_btn">Save</button>
                        @endcan
                        <button id="closebutton" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layout.universal-component')
@endsection

@section('scripts')
    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var globalIndex = -1;
        $(function () {
            cardSection = $('#page-block');
        });

        var j = 0;
        var i = 0;
        var m = 0;

        $(document).ready( function () {
            $("#main-datatable").hide();
            var ctable = $('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 0, "desc" ]],
                "lengthMenu": [25,50,100,250,500],
                "pagingType": "simple",
                language: { 
                    search: '', 
                    searchPlaceholder: "Search here"
                },
                scrollY:'100%',
                scrollX: true,
                scrollCollapse: true,
                deferRender: true,
                dom: "<'row'<'col-sm-3 col-md-2 col-4 pr-0 mr-0'f><'col-sm-4 col-md-2 col-4 mt-1 pr-0 mr-0'><'col-sm-4 col-md-2 col-4 mt-1'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/banklist',
                    type: 'DELETE',
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
                        setFocus('#laravel-datatable-crud');
                    },
                },
                columns: [
                    { data: 'id', name: 'id', 'visible': false },
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'BankName', name: 'BankName',width:"50%"},
                    { data: 'Status', name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Active"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Inactive"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                        },
                        width:"43%"
                    },
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="bankInfo" href="javascript:void(0)" onclick="bankInfoFn(${row.id})" data-id="bank_id${row.id}" id="bank_id${row.id}" title="Open bank information page"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:"4%"
                    }
                ],
                
                drawCallback: function(settings) {
                    this.api().columns().every(function() {
                        var column = this;
                        var header = $(column.header()).text().trim();
                        
                        $(column.nodes()).each(function() {
                            $(this).attr('data-title', header);
                        });
                    });

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
                    $("#main-datatable").show();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
        });

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            globalIndex = $(this).index();
        });

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[globalIndex]).addClass('selected');
        }

        $("#addbanks").click(function() {
            resetBankFn();
            $("#inlineForm").modal('show');
        });

        function resetBankFn(){
            j = 0;
            $('.reg_form').val("");
            $('#status').val("Active").select2({
                minimumResultsForSearch: -1
            });
            $('#operationtypes').val(1);
            $('#dynamicTable > tbody').empty();
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $('.errordatalabel').html('');
            $("#banktitlelbl").html("Add Bank");
        }

        $("#adds").click(function() {
            ++i;
            ++m;
            ++j;
            var lastrowcount = $('#dynamicTable > tbody > tr:last').find('td').eq(1).find('input').val();
            var account_num = $(`#AccountNumber${lastrowcount}`).val();

            if(account_num !== undefined && account_num == ""){
                $(`#AccountNumber${lastrowcount}`).css('background-color',errorcolor);
                toastrMessage('error',"Please insert valid data on highlighted field","Error");
            }
            else{
                $("#dynamicTable > tbody").append(`<tr id="rowind${m}">
                    <td style="font-weight:bold;width:3%;text-align:center;">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:15%;"><input type="number" name="row[${m}][AccountNumber]" placeholder="Write account number here..." id="AccountNumber${m}" class="AccountNumber form-control numeral-mask" onkeyup="accvalfn(this)" onblur="checkAccountNumFn(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:15%;"><input type="number" name="row[${m}][OpeningBalance]" placeholder="Write opening balace here..." id="OpeningBalance${m}" class="OpeningBalance form-control numeral-mask" onkeyup="openbalfn(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:15%;"><input type="number" name="row[${m}][ContactNumber]" placeholder="Write contact number here..." id="ContactNumber${m}" class="ContactNumber form-control numeral-mask" onkeyup="contnumfn(this)" onblur="checkContactNumFn(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:19%;"><input type="text" name="row[${m}][Branch]" id="Branch${m}" class="Branch form-control" placeholder="Write branch here..." onkeyup="branchvalfn(this)" /></td>
                    <td style="width:20%;"><input type="text" name="row[${m}][Description]" placeholder="Write description here..." id="Description${m}" class="Description form-control" onkeyup="dynamicDescriptionFn(this)"/></td>
                    <td style="width:10%;"><select id="Status${m}" class="select2 form-control Status" name="row[${m}][Status]" onchange="statusvalfn(this)"></select></td>
                    <td style="width:3%;text-align:center;"><button type="button" id="removebtn${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                </tr>`);

                var statusopt = '<option value="Active">Active</option><option value="Inactive">Inactive</option>';
                $(`#Status${m}`).append(statusopt).select2
                ({
                    placeholder: "Select status here",
                    dropdownParent: $('#dynamicDiv'),
                    minimumResultsForSearch: -1
                });
                renumberRows();
            }
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            renumberRows();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody > tr').each(function(index,el) {
                $(this).children('td').first().text(index+=1);
                $('#numberofItemsLbl').html(index);
                ind = index;
            });
            if (ind == 0) {
               $('.totalrownumber').hide();
            } else {
               $('.totalrownumber').hide();
            }
        }
        
        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/saveBank',
                type: 'POST',
                data: formData,
                beforeSend: function() {
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
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Saving...');
                        $('#savebutton').prop("disabled", true);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebutton').text('Updating...');
                        $('#savebutton').prop("disabled", true);
                    }
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

                success: function(data) {
                    if (data.errors) {
                        if (data.errors.BankName) {
                            $('#name-error').html(data.errors.BankName[0]);
                        }
                        if (data.errors.Description) {
                            $('#description-error').html(data.errors.Description[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                        }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Check your inputs","Error"); 
                    }
                    else if (data.errorv2) {
                        $('#dynamicTable > tbody > tr').each(function (index) {
                            let k = $(this).find('.vals').val();
                            var accnumber = $(`#AccountNumber${k}`).val();
                            var branch = $(`#Branch${k}`).val();
                            var openbla = $(`#OpeningBalance${k}`).val();
                            var contnumb = $(`#ContactNumber${k}`).val();
                            var status = $(`#Status${k}`).val();
                            
                            if(($(`#AccountNumber${k}`).val())!=undefined){
                                if(accnumber == "" || accnumber == null){
                                    $(`#AccountNumber${k}`).css("background", errorcolor);
                                }
                            }
                            if(($(`#OpeningBalance${k}`).val())!=undefined){
                                if(openbla == "" || openbla == null){
                                    $(`#OpeningBalance${k}`).css("background", errorcolor);
                                }
                            }
                            if(($(`#Status${k}`).val())!=undefined){
                                if(status == "" || status == null){
                                    $(`#select2-Status${k}-container`).parent().css('background-color',errorcolor);
                                }
                            }
                        });
                        
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please fill all highlighted required fields","Error");
                    }
                    else if (data.dberrors){
                        if(parseInt(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseInt(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.emptyerror){
                        if(parseFloat(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"You should add atleast one account number","Error");
                    } 
                    else if(data.success){
                        if(parseFloat(optype) == 2){
                            createBankInfoFn(data.rec_id);
                        }
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        function bankEditFn(recordId) { 
            resetBankFn();
            $("#operationtypes").val(2);
            $("#bankId").val(recordId);
            $.ajax({
                type: "get",
                url: "{{url('showbanks')}}"+'/'+recordId,
                dataType: "json",
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
                success: function (data) {
                    $.each(data.banklist, function(key, value) {
                        $('#BankName').val(value.BankName);
                        $("#Description").val(value.Description);
                        $('#status').val(value.Status).select2({minimumResultsForSearch: -1});
                    });

                    $.each(data.detdata, function(key, value) {
                        ++i;
                        ++m;
                        ++j;
                        $("#dynamicTable > tbody").append(`<tr id="rowind${m}">
                            <td style="font-weight:bold;width:3%;text-align:center;">${j}</td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td style="width:15%;"><input type="number" name="row[${m}][AccountNumber]" placeholder="Write account number here..." id="AccountNumber${m}" class="AccountNumber form-control numeral-mask" value="${value.AccountNumber}" onkeyup="accvalfn(this)" onblur="checkAccountNumFn(this)" onkeypress="return ValidateNum(event);"/></td>
                            <td style="width:15%;"><input type="number" name="row[${m}][OpeningBalance]" placeholder="Write opening balace here..." id="OpeningBalance${m}" class="OpeningBalance form-control numeral-mask" value="${value.OpeningBalance}" onkeyup="openbalfn(this)" onkeypress="return ValidateNum(event);"/></td>
                            <td style="width:15%;"><input type="number" name="row[${m}][ContactNumber]" placeholder="Write contact number here..." id="ContactNumber${m}" class="ContactNumber form-control numeral-mask" value="${value.ContactNumber}" onkeyup="contnumfn(this)" onblur="checkContactNumFn(this)" onkeypress="return ValidateNum(event);"/></td>
                            <td style="width:19%;"><input type="text" name="row[${m}][Branch]" id="Branch${m}" class="Branch form-control" placeholder="Write branch here..." onkeyup="branchvalfn(this)" value="${value.Branch}" /></td>
                            <td style="width:20%;"><input type="text" name="row[${m}][Description]" placeholder="Write description here..." id="Description${m}" class="Description form-control" value="${value.description != null ? value.description : ""}" onkeyup="dynamicDescriptionFn(this)"/></td>
                            <td style="width:10%;"><select id="Status${m}" class="select2 form-control Status" name="row[${m}][Status]" onchange="statusvalfn(this)"></select></td>
                            <td style="width:3%;text-align:center;"><button type="button" id="removebtn${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                        </tr>`);  

                        var statusdefopt = `<option selected value="${value.Status}">${value.Status}</option>`;
                        
                        if(parseFloat(value.TransactionFlag) > 0){
                            $(`#removebtn${m}`).hide();
                        }
                        else if(parseFloat(value.TransactionFlag) == 0){
                            $(`#removebtn${m}`).show();
                        }

                        var statusopt = '<option value="Active">Active</option><option value="Inactive">Inactive</option>';
                        $(`#Status${m}`).append(statusopt);
                        $(`#Status${m} option[value="${value.Status}"]`).remove(); 
                        $(`#Status${m}`).append(statusdefopt).select2({minimumResultsForSearch: -1});
                        $(`#select2-Status${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    });
                }
            });
            $("#banktitlelbl").html("Edit Bank");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show'); 
        }

        function bankInfoFn(recordId){
            createBankInfoFn(recordId);
            $("#informationmodal").modal('show');
        }

        function createBankInfoFn(recordId){ 
            var action_log = "";
            var lidata = "";
            var action_links = "";
            $(".infoAccDiv").hide();
            $.ajax({
                type: "get",
                url: "{{url('showbanks')}}"+'/'+recordId,
                dataType: "json",
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
                    fetchBankDetailInfoFn(recordId);   
                },
                success: function (data) {
                    $.each(data.banklist, function(key, value) {
                        $("#banknamelbl").html(value.BankName);
                        $("#descriptionlbl").html(value.Description);
                        $("#statuslbl").html(value.Status == "Active" ? 
                            `<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:12px;'>${value.Status}</span>` :
                            `<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:12px;'>${value.Status}</span>`
                        );
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes = "";
                        if(value.action == "Edited"){
                            classes = "warning";
                        }
                        else if(value.action == "Created"){
                            classes = "success";
                        }
                        else{
                            classes = "secondary";
                        }
                        lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $("#universal-action-log-canvas").empty().append(lidata);

                    action_links = `
                        <li>
                            <a class="dropdown-item viewBankAction" onclick="viewBankFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Bank-Edit")
                        <li>
                            <a class="dropdown-item bankEdit" onclick="bankEditFn(${recordId})" data-id="editlinkbtn${recordId}" id="editlinkbtn${recordId}" title="Open bank edit form">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Bank-Delete")
                        <li>
                            <a class="dropdown-item bankDelete" onclick="bankDeleteFn(${recordId})" data-id="deletelinkbtn${recordId}" id="deletelinkbtn${recordId}" title="Open bank delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan`;

                    $("#bank_action_ul").empty().append(action_links);
                }
            });
            $(".infoscl").collapse('show'); 
        }

        function viewBankFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function fetchBankDetailInfoFn(recordId){
            $(".infoAccDiv").hide();
            $('#bankdetailtbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                info: false,
                paging: false,
                autoWidth: false,
                "order": [[ 0, "asc" ]],
                "lengthMenu": [25,50,100,250,500],
                "pagingType": "simple",
                language: { 
                    search: '', 
                    searchPlaceholder: "Search here"
                },
                deferRender: true,
                dom: "<'row'<'col-sm-6 col-md-6 col-6 pr-0 mr-0'f><'col-sm-4 col-md-2 col-4 mt-1 pr-0 mr-0'><'col-sm-4 col-md-2 col-4 mt-1'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/banklistinfo/'+recordId,
                    type: 'DELETE',
                    dataType: "json",
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    { data:'DT_RowIndex',width:"3%"},
                    {
                        data: 'AccountNumber',
                        name: 'AccountNumber',
                        width:"17%"
                    },
                    {
                        data: 'OpeningBalance',
                        name: 'OpeningBalance',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"15%"
                    },
                    {
                        data: 'ContactNumber',
                        name: 'ContactNumber',
                        width:"15%"
                    },
                    {
                        data: 'Branch',
                        name: 'Branch',
                        width:"20%"
                    },
                    {
                        data: 'description',
                        name: 'description',
                        width:"20%"
                    },
                    {
                        data: 'Status',name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Active"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Inactive"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                        },
                        width:"10%"
                    },
                ],
                drawCallback: function(settings) {
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
                    $('#acc_div').show();
                },
            });
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.bank_header_info');
            const collapseId = collapse.attr('id');
            const trigger = $(`[data-target="#${collapseId}"], [data-bs-target="#${collapseId}"]`);

            const isOpening = e.type === 'show';

            $('.toggle-text-label').html(isOpening ? 'Collapse' : 'Expand');
            $('.collapse-icon').html(isOpening ? '<i class="fas text-secondary fa-minus-circle"></i>' : '<i class="fas text-secondary fa-plus-circle"></i>');

            if (isOpening) {
                const originalHeader = `<i class="far fa-info-circle"></i> Bank Information`;
                infoTarget.html(originalHeader);
            } 
            else {
                // Section is COLLAPSING: Show the data summary
                const bank_name = container.find('#banknamelbl').text().trim();
                const bank_status = container.find('#statuslbl').text().trim();
                const summaryBank = `
                    Bank Name: <b>${bank_name}</b>,
                    Status: <b style="color: ${bank_status == "Active" ? "#28c76f" : "#ea5455"}">${bank_status}</b>`;

                infoTarget.html(summaryBank);
            }
        });

        function bankDeleteFn(recordId) { 
            var bank_cnt = 0;
            $("#bankdelId").val(recordId);
            $.ajax({
                type: "get",
                url: "{{url('showbanks')}}"+'/'+recordId,
                dataType: "json",
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
                success: function (data) {
                    bank_cnt = data.bank_cnt;

                    if(parseInt(bank_cnt) > 0){
                        toastrMessage('error',"This record cannot be deleted because it is currently linked to other entries.","Error");
                    }
                    else if(parseInt(bank_cnt) == 0){
                        Swal.fire({
                            title: warning_title,
                            text: delete_record_text1,
                            icon: warning_icon,
                            showCloseButton: true,
                            showCancelButton: true,      
                            allowOutsideClick: false,
                            confirmButtonText: 'Delete',
                            cancelButtonText: 'Close',
                            customClass: {
                                confirmButton: 'btn btn-info',
                                cancelButton: 'btn btn-danger'
                            }
                        }).then(function (result) {
                            if (result.value) {
                                deleteBankFn(recordId);
                            }
                            else if (result.dismiss === Swal.DismissReason.cancel) {}
                        });
                    }
                }
            });
        }

        function deleteBankFn(recordId){
            var delform = $("#InformationForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deletebank',
                type: 'POST',
                data: formData,
                beforeSend: function() {
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
                success: function(data) {
                    if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                        $("#informationmodal").modal('hide');
                    }
                }
            });
        }

        function checkAccountNumFn(ele){
            var bankids=$('#bankId').val()||0;
            var optype=$('#operationtypes').val();
            var cid=$(ele).closest('tr').find('.vals').val();
            var accnum=$(ele).closest('tr').find('.AccountNumber').val();
            var bankidval="";
            var accnumber="";
            var arr = [];
            var found = 0;
            $('.AccountNumber').each(function() 
            { 
                var name=$(this).val();
                if(arr.includes(name)){
                    found++;
                }
                else{
                    arr.push(name);
                }
            });
            $.ajax({
                url: '/accNumberVal',
                type: 'POST',
                data:{
                    bankidval:bankids,
                    accnumber:accnum,
                },
                success: function(data) {  
                    if(parseFloat(data.accnumcnt)>0){
                        $('#AccountNumber'+cid).val("");
                        $('#AccountNumber'+cid).css("background", errorcolor);
                        toastrMessage('error',"Account number has already been taken","Error");
                    }
                    else if(parseFloat(found)>0){
                        $('#AccountNumber'+cid).val("");
                        $('#AccountNumber'+cid).css("background", errorcolor);
                        toastrMessage('error',"Account number has already been taken","Error");
                    }
                }
            });
        }

        function checkContactNumFn(ele){
            var bankids=$('#bankId').val()||0;
            var optype=$('#operationtypes').val();
            var cid=$(ele).closest('tr').find('.vals').val();
            var contnum=$(ele).closest('tr').find('.ContactNumber').val();
            var bankidval="";
            var contactnum="";
            var arr = [];
            var found = 0;
            $('.ContactNumber').each(function() 
            { 
                var name=$(this).val();
                if(arr.includes(name)){
                    found++;
                }
                else{
                    arr.push(name);
                }
            });
            $.ajax({
                url: '/conNumVal',
                type: 'POST',
                data:{
                    bankidval:bankids,
                    contactnum:contnum,
                },
                success: function(data) {  
                    if(parseFloat(data.contn)>0){
                        $('#ContactNumber'+cid).val("");
                        $('#ContactNumber'+cid).css("background", errorcolor);
                        toastrMessage('error',"Contact number has already been taken","Error");
                    }
                    else if(parseFloat(found)>0){
                        $('#ContactNumber'+cid).val("");
                        $('#ContactNumber'+cid).css("background", errorcolor);
                        toastrMessage('error',"Contact number has already been taken","Error");
                    }
                }
            });
        }

        function refreshBankDataFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }

        function accvalfn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#AccountNumber${cid}`).css("background", "white");
        }

        function branchvalfn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#Branch${cid}`).css("background", "white");
        }

        function statusvalfn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#select2-Status${cid}-container`).parent().css({"background":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        }

        function openbalfn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#OpeningBalance${cid}`).css("background", "white");
        }

        function contnumfn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#ContactNumber${cid}`).css("background", "white");
        }

        function dynamicDescriptionFn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#Description${cid}`).css("background", "white");
        }

        function bankNameFn() {
            $('#name-error').html('');
        }
        function descriptionfn() {
            $('#description-error').html('');
        }
        function statusFn() {
            $('#status-error').html('');
        }
    </script>
@endsection