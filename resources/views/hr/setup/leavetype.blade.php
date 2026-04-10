@extends('layout.app1')

@section('title')
@endsection

@section('content')

    @can('Leave-Type-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Leave Type</h3>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshLeaveTypeDataFn()"><i class="fas fa-sync-alt"></i></button>
                                        @if (auth()->user()->can('Leave-Type-Add'))
                                        <button type="button" class="btn btn-gradient-info btn-sm addleavetype header-prop" id="addleavetype"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                        @endcan 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable fit-content">
                            <div style="width:99%; margin-left:0.5%;" id="main-datatable">
                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width:3%;">#</th>
                                            <th style="width:30%;">Leave Type</th>
                                            <th style="width:21%;">Requires Balance</th>
                                            <th style="width:21%;">Leave Payment Type</th>
                                            <th style="width:21%;">Status</th>
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Leave Type Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <table class="infotbl" style="width: 100%;font-size:12px">
                                    <tr>
                                        <td><label class="info_lbl">Leave Type</label></td>
                                        <td><label class="info_lbl" id="leavetypelbl" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Requires Balance</label></td>
                                        <td><label class="info_lbl" id="requirebalancelbl" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Leave Payment Type</label></td>
                                        <td><label class="info_lbl" id="leavepaymenttypelbl" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Description</label></td>
                                        <td><label class="info_lbl" id="descriptionlbl" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Status</label></td>
                                        <td><label class="info_lbl" id="statuslbl" style="font-weight:bold;"></label></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:left">
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn form_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-down fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="leavetype_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="delRecId" id="delRecId" readonly="true">
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="modaltitle">Add Leave Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Leave Type<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" placeholder="Leave Type" class="form-control mainforminp reg_form" name="LeaveType" id="LeaveType" onkeyup="leaveTypeFn()"/>
                                <span class="text-danger">
                                    <strong id="name-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Requires Balance<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control select2cus" name="RequiresBalance" id="RequiresBalance" onchange="reqBalanceFn()">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="reqbalance-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Leave Payment Type<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control select2cus" name="LeavePaymentType" id="LeavePaymentType" onchange="leavePaymentFn()">
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Paid-or-Unpaid">Paid-or-Unpaid</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="leavepayment-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Description</label>
                                <textarea type="text" placeholder="Write Description here..." class="form-control mainforminp reg_form" rows="1" name="Description" id="Description" onkeyup="descriptionfn()"></textarea>
                                <span class="text-danger">
                                    <strong id="description-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Status<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control" name="status" id="status" onchange="statusFn()">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="status-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control reg_form" name="recId" id="recId" readonly="true" value=""/>     
                        <input type="hidden" class="form-control reg_form" name="operationtypes" id="operationtypes" readonly="true"/>
                        <button id="savenewbutton" type="button" class="btn btn-info form_btn record-save" data-action="new">Save & New</button>
                        <button id="savebutton" type="button" class="btn btn-info form_btn record-save" data-action="close">Save & Close</button>
                        <button id="closebutton" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layout.universal-component')

    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });
        var globalIndex = -1;

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
                    url: '/leavetypelist',
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
                    { data: 'id', name: 'id', 'visible': false},
                    { data:'DT_RowIndex',width:"3%"},
                    { data: 'LeaveType', name: 'LeaveType',width:"30%"},
                    { data: 'RequiresBalance', name: 'RequiresBalance',width:"21%"},
                    { data: 'LeavePaymentType', name: 'LeavePaymentType',width:"21%"},
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
                        width:"21%"
                    },
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="leaveTypeInfo" href="javascript:void(0)" onclick="leaveTypeInfoFn(${row.id})" data-id="leavetype_id${row.id}" id="leavetype_id${row.id}" title="Open leave type information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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

        $("#addleavetype").on("click", function () {
            resetLeaveTypeFn();
            $("#inlineForm").modal('show');
        });

        $('.record-save').on('click', function(e) {
            e.preventDefault();
            var optype = $("#operationtypes").val();
            var recordId = $("#recId").val();
            var formData = $("#Register").serialize();

            var button = $(this);
            var action = button.data('action'); 

            $.ajax({
                url: '/saveLeaveType',
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
                    if(parseFloat(optype) == 1){
                        button.prop('disabled', true);
                        button.text('Saving...');
                    }
                    else if(parseFloat(optype) == 2){
                        button.prop('disabled', true);
                        button.text('Updating...');
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
                    if(data.errors) {
                        if (data.errors.LeaveType) {
                            $('#name-error').html(data.errors.LeaveType[0]);
                        }
                        if (data.errors.RequiresBalance) {
                            $('#reqbalance-error').html(data.errors.RequiresBalance[0]);
                        }
                        if (data.errors.LeavePaymentType) {
                            $('#leavepayment-error').html(data.errors.LeavePaymentType[0]);
                        }
                        if (data.errors.Description) {
                            $('#description-error').html(data.errors.Description[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                        }

                        resetButton(button, action, optype);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    else if (data.dberrors) {
                        resetButton(button, action, optype);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        resetButton(button, action, optype);
                        if(parseInt(optype) == 2){
                            createLeaveTypeInfoFn(recordId);
                        }
                        if(action == "close"){
                            $("#inlineForm").modal('hide');
                        }
                        if(action == "new"){
                            resetLeaveTypeFn();
                        }
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        });

        function resetButton(button, action, optype) {
            button.prop('disabled', false);
            
            if (action === 'new') {
                button.text('Save & New');
            } 
            if (action === 'close') {
                button.text('Save & Close');
            }

            if(optype == 2){
                button.text('Update');
            }
        }
       
        function leaveTypeEditFn(recordId) { 
            resetLeaveTypeFn();
            $.ajax({
                type: "get",
                url: "{{url('showleavetype')}}"+'/'+recordId,
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
                    $.each(data.leavetypedata, function(key, value) {
                        $("#recId").val(recordId);
                        $('#LeaveType').val(value.LeaveType);
                        $('#RequiresBalance').val(value.RequiresBalance).select2({minimumResultsForSearch: -1});
                        $('#LeavePaymentType').val(value.LeavePaymentType).trigger('change').select2({minimumResultsForSearch: -1});
                        $("#Description").val(value.Description);
                        $('#status').val(value.Status).trigger('change').select2({minimumResultsForSearch: -1});

                        if(parseInt(recordId) <= 2){
                            $('#LeaveType').prop("readonly", true);
                        }
                        else{
                            $('#LeaveType').prop("readonly", false);
                        }
                    });
                }
            });

            $("#modaltitle").html("Edit Leave Type");
            $("#operationtypes").val(2);
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').hide();
            $("#inlineForm").modal('show'); 
        }

        function leaveTypeInfoFn(recordId){
            createLeaveTypeInfoFn(recordId);
            $("#informationmodal").modal('show');
        }

        function createLeaveTypeInfoFn(recordId) { 
            var action_log = "";
            var action_links = "";
            var lidata = "";

            $.ajax({
                type: "get",
                url: "{{url('showleavetype')}}"+'/'+recordId,
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
                    $.each(data.leavetypedata, function(key, value) {
                        $("#leavetypelbl").html(value.LeaveType);
                        $("#requirebalancelbl").html(value.RequiresBalance);
                        $("#leavepaymenttypelbl").html(value.LeavePaymentType);
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
                        lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $("#universal-action-log-canvas").empty().append(lidata);

                    action_links = `
                        <li>
                            <a class="dropdown-item viewLeaveTypeAction" onclick="viewLeaveTypeFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Leave-Type-Edit")
                        <li>
                            <a class="dropdown-item leaveTypeEdit" onclick="leaveTypeEditFn(${recordId})" data-id="editlinkbtn${recordId}" id="editlinkbtn${recordId}" title="Open leave type edit form">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Leave-Type-Delete")
                        <li>
                            <a class="dropdown-item leaveTypeDelete" onclick="leaveTypeDeleteFn(${recordId})" data-id="deletelinkbtn${recordId}" id="deletelinkbtn${recordId}" title="Open leave type delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan
                    `;

                    $("#leavetype_action_ul").empty().append(action_links);
                }
            });
        }

        function viewLeaveTypeFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function leaveTypeDeleteFn(recordId) { 
            if(parseInt(recordId) <= 2){
                toastrMessage('error',"Unable to delete system leave type.","Error");
            }
            else{
                $("#delRecId").val(recordId);
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
                        deleteLeaveTypeFn(recordId);
                    }
                    else if (result.dismiss === Swal.DismissReason.cancel) {}
                });
            }
        }

        function deleteLeaveTypeFn(recordId){
            var delform = $("#InformationForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteleavetype',
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

        function leaveTypeFn() {
            $('#name-error').html('');
        }

        function reqBalanceFn() {
            $('#reqbalance-error').html('');
        }

        function leavePaymentFn() {
            $('#leavepayment-error').html('');
        }

        function descriptionfn() {
            $('#description-error').html('');
        }

        function statusFn() {
            $('#status-error').html('');
        }

        function refreshLeaveTypeDataFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }

        function resetLeaveTypeFn(){
            $('.reg_form').val("");
            $('.errordatalabel').html("");
            $('#LeavePaymentType').val(null).select2
            ({
                placeholder: "Select leave payment type here",
                minimumResultsForSearch: -1
            });
            $('#RequiresBalance').val(null).select2
            ({
                placeholder: "Select require balance here",
                minimumResultsForSearch: -1
            });
            $('#status').val("Active").select2({minimumResultsForSearch: -1});

            $('#savebutton').text('Save & Close');
            $('#savebutton').prop("disabled",false);
            $('#savebutton').show();

            $('#savenewbutton').text('Save & New');
            $('#savenewbutton').prop("disabled",false);
            $('#savenewbutton').show();

            $('#operationtypes').val(1);
            $("#modaltitle").html("Add Leave Type");
        }
    </script>
@endsection
