@extends('layout.app1')

@section('title')
@endsection

@section('content')
    @can('Category-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Category</h3>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: center !important;">
                                        <ul class="nav nav-tabs justify-content-center" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active header-tab" id="TableView-tab" data-toggle="tab" href="#tableview" aria-controls="tableview" role="tab" aria-selected="false" title="Table View"><i class="fas fa-table"></i><span class="tab-text">Table View</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link header-tab" id="HierarchyView-tab" data-toggle="tab" href="#hierarchyview" aria-controls="hierarchyview" role="tab" aria-selected="true" title="Tree View"><i class="fas fa-sitemap"></i><span class="tab-text">Tree View</span></a>                                
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshDataFn()"><i class="fas fa-sync-alt"></i></button>
                                        @can('Category-Add')
                                            <button type="button" class="btn btn-gradient-info btn-sm addcategories header-prop" id="addcategories"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                        @endcan 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div class="tab-content">
                                <div class="tab-pane active fit-content" id="tableview" aria-labelledby="tableview" role="tabpanel">
                                    <div style="width:99%; margin-left:0.5%;" id="main_datatable" style="display: none">
                                        <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="display: none;"></th>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:33%;">Parent Category</th>
                                                    <th style="width:30%;">Category Name</th>
                                                    <th style="width:30%;">Status</th>
                                                    <th style="width:4%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table table-sm"></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="hierarchyview" aria-labelledby="hierarchyview" role="tabpanel">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-7 ml-1 mt-1">
                                            <div class="search-container">
                                                <input type="text" class="search-box" id="search-box" placeholder="Search...">
                                                <span style="color: #ea5455" class="clear-search">&times;</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 scrdivhor scrollhor" style="overflow-y: scroll;max-height:40rem">
                                            <div class="no-record ml-1" style="display: none;"><i>No matching results found!</i></div>
                                            <div class="loading_category_tree"></div>
                                            <div class="record_tree" id="category_tree"></div>
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

    <div class="modal fade text-left fit-content" id="categoryinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Category Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="categoryinfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <table class="infotbl" style="width: 100%;font-size:12px">
                                    <tr>
                                        <td><label class="info_lbl">Parent Category</label></td>
                                        <td><label class="info_lbl" id="parentcategoryinfo" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Category Name</label></td>
                                        <td><label class="info_lbl" id="categorynameinfo" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Description</label></td>
                                        <td><label class="info_lbl" id="descriptioninfo" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Status</label></td>
                                        <td><label class="info_lbl" id="statusinfo" style="font-weight:bold;"></label></td>
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
                                        <ul class="dropdown-menu" id="category_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <button id="closebutton" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="form_title_lbl">Add Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Parent Category<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control" name="parent_category" id="parent_category" onchange="parentCategoryFn()"></select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="parent-category-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Category Name<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" placeholder="Category Name" class="form-control reg_form" name="Name" id="Name" onkeyup="categoryFn()"/>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="name-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Description</label>
                                <textarea type="text" placeholder="Write Description here..." class="form-control reg_form" rows="1" name="description" id="description" onkeyup="descriptionFn()"></textarea>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="description-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
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
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="createFlag" id="createFlag">
                        <input type="hidden" class="form-control reg_form" name="recordId" id="recordId">
                        <input type="hidden" class="form-control reg_form" name="operationType" id="operationType">
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
        $(function () {
            cardSection = $('#page-block');
        });
        var globalIndex = -1;

        $(document).ready( function () {
            $("#main_datatable").hide();
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
                    url: '/categorydata',
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
                        $('#laravel-datatable-crud').DataTable().columns.adjust();
                    },
                },
                columns: [
                    { data: 'id', name: 'id', 'visible': false },
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'parent_category', name: 'parent_category',width:"33%"},
                    { data: 'Name', name: 'Name',width:"30%"},
                    { data: 'ActiveStatus', name: 'ActiveStatus',
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
                        width:"30%"
                    },
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="categoryInfo" href="javascript:void(0)" onclick="categoryInfoFn(${row.id})" data-id="category_id${row.id}" id="category_id${row.id}" title="Open category information page"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                    $("#main_datatable").show();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
            getTreeDataFn();
        });

        $('#TableView-tab').on('shown.bs.tab', function () {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            globalIndex = $(this).index();
        });

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[globalIndex]).addClass('selected');
        }

        $("#addcategories").on("click", function () {
            resetForm();
            fetchParentCategoryFn();
            $("#createFlag").val(1);
            $("#inlineForm").modal('show');
        });

        function openCreateFormFn(category_id,status){
            if(status == "Active"){
                resetForm();
                fetchDefaultCategoryFn(category_id);
                $("#createFlag").val(2);
                $("#inlineForm").modal('show');
            }
            else{
                toastrMessage('error',"You cannot add child unders this category, because it is Inactive","Error");
            }
        }

        $('.record-save').on('click', function(e) {
            e.preventDefault();
            var optype = $("#operationType").val();
            var recordId = $("#recordId").val();
            var createFlag = $("#createFlag").val();
            var formData = $("#Register").serialize();

            var button = $(this);
            var action = button.data('action'); 

            $.ajax({
                url: '/savecategory',
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
                        if (data.errors.parent_category) {
                            $('#parent-category-error').html(data.errors.parent_category[0]);
                        }
                        if (data.errors.Name) {
                            $('#name-error').html(data.errors.Name[0]);
                        }
                        if (data.errors.description) {
                            $('#description-error').html(data.errors.description[0]);
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
                            createCategoryInfoFn(recordId);
                        }
                        if(action == "close"){
                            $("#inlineForm").modal('hide');
                        }
                        if(action == "new"){
                            if(parseInt(createFlag) != 2){
                                fetchParentCategoryFn();
                            }
                            resetForm();
                        }
                        getTreeDataFn();
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

            if(optype === 2){
                button.text('Update');
            }
        }

        function fetchParentCategoryFn() {
            var category_option_data = `<option selected disabled value=""></option>`;
            $.ajax({
                url: '/fetchParentCategory',
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    $.each(data.category_data, function(key, value) {
                        category_option_data += `<option value="${value.id}">${value.Name}</option>`;
                    }); 

                    $('#parent_category').empty().append(category_option_data).select2
                    ({
                        placeholder: "Select parent category here...",
                    });
                }
            });
        }

        function fetchDefaultCategoryFn(recordId){
            var category_option_data = `<option selected disabled value=""></option>`;
            $.ajax({
                type: "get",
                url: "{{url('catedit')}}"+'/'+recordId,
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
                    $.each(data.cat, function(key, value) {
                        $('#parent_category').empty().append(`<option selected value="${recordId}">${value.Name}</option>`).select2
                        ({
                            minimumResultsForSearch: -1
                        });
                    });
                },
            });
        }

        function categoryEditFn(recordId) {
            $("#createFlag").val("");
            resetForm();
            fetchParentCategoryFn();
            $.ajax({
                type: "get",
                url: "{{url('catedit')}}"+'/'+recordId,
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
                    $.each(data.cat, function(key, value) {
                        $(`#parent_category option[value=${recordId}]`).remove(); 
                        $(`#parent_category option[value=${value.categories_id}]`).remove(); 
                        $('#parent_category').append(`<option selected value="${value.categories_id}">${value.parent_category}</option>`).select2();
                        $('#Name').val(value.Name);
                        $('#description').val(value.description);
                        $('#status').val(value.ActiveStatus).select2({ minimumResultsForSearch: -1});
                        $('#recordId').val(value.id);
                    });
                },
            });

            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#savebutton').show();

            $('#savenewbutton').text('Update');
            $('#savenewbutton').prop("disabled",false);
            $('#savenewbutton').hide();

            $('#operationType').val(2);
            $('#form_title_lbl').html("Edit Category");
            $('#inlineForm').modal('show');
        }

        function categoryInfoFn(recordId) {
            createCategoryInfoFn(recordId);
            $('#categoryinfomodal').modal('show');
        }

        function createCategoryInfoFn(recordId) {
            var action_log = "";
            var action_links = "";
            var lidata = "";
            $.ajax({
                type: "get",
                url: "{{url('catedit')}}"+'/'+recordId,
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
                    $.each(data.cat, function(key, value) {
                        $('#parentcategoryinfo').html(value.parent_category);
                        $('#categorynameinfo').html(value.Name);
                        $('#descriptioninfo').html(value.description);
                        $("#statusinfo").html(value.ActiveStatus == "Active" ? 
                            `<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:12px;'>${value.ActiveStatus}</span>` :
                            `<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:12px;'>${value.ActiveStatus}</span>`
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

                    //$("#actiondiv").empty().append(lidata);
                    $("#universal-action-log-canvas").empty().append(lidata);

                    action_links = `
                        <li>
                            <a class="dropdown-item viewCatAction" onclick="viewCategoryFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Category-Edit")
                        <li>
                            <a class="dropdown-item categoryEdit" onclick="categoryEditFn(${recordId})" data-id="editlinkbtn${recordId}" id="editlinkbtn${recordId}" title="Open category edit page">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Category-Delete")
                        <li>
                            <a class="dropdown-item categoryDelete" onclick="categoryDeleteFn(${recordId})" data-id="deletelinkbtn${recordId}" id="deletelinkbtn${recordId}" title="Open category delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan
                    `;

                    $("#category_action_ul").empty().append(action_links);
                },
            });
        }

        function viewCategoryFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function categoryDeleteFn(recordId){
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
                    deleteCategoryFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function deleteCategoryFn(recordId){
            var formData = $("#categoryinfoform").serialize();
            $.ajax({
                url: '/delete/'+recordId,
                type: 'DELETE',
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
                    if(data.errors){
                        toastrMessage('error',"This record cannot be deleted because it is currently linked to other entries.","Error");
                    }
                    else if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        getTreeDataFn();
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#categoryinfomodal").modal('hide');
                    }
                }
            });
        }

        function getTreeDataFn(){
            $.ajax({ 
                url: '/fetchParentCategory',
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    $('.loading_category_tree').hide();

                    if (!Array.isArray(data.all_category_data)) {
                        $('.loading_category_tree').text('Error: Invalid data format').css('color', 'red');
                        return;
                    }
                    if (data.all_category_data.length === 0) {
                        $('.loading_category_tree').text('No category data found').css('color', '#650');
                        return;
                    }
                    
                    const map = {};
                    data.all_category_data.forEach(category => {
                        map[category.id] = { ...category, children: [] };
                    });

                    const tree = [];
                    data.all_category_data.forEach(category => {
                        if (category.categories_id) {
                            map[category.categories_id]?.children.push(map[category.id]);
                        } else {
                            tree.push(map[category.id]);
                        }
                    });

                    $("#category_tree").empty();

                    buildTree(tree, $("#category_tree"));

                    $(".record_tree ul").hide();
                    $(".record_tree > ul").show();

                    $(".toggle")
                        .removeClass("fa-chevron-down")
                        .addClass("fa-chevron-right");
                },
                error: function(xhr, status, error) {
                    $('.loading_category_tree').text('Error loading data: ' + error).css('color', 'red');
                }
            });
        }

        function buildTree(nodes, container) {
            const ul = $("<ul style='padding-left:12px'>").appendTo(container).show();

            nodes.forEach(node => {
                const li = $("<li style='padding-left:15px'>");

                const hasChild = node.children.length > 0;

                const toggle = $("<i>")
                    .addClass("fa fa-chevron-right toggle")
                    .toggle(hasChild);

                const icon = $("<i>")
                    .addClass("fa " + (hasChild ? "fa-folder" : "fa-file")); // rule #5

                const label = $("<span>")
                    .addClass("label")
                    .html(" "+node.Name)
                    .css({'color' : node.ActiveStatus == "Active" ? "#6e6b7b" : "#ea5455"})
                    .on('dblclick', function(e) {
                        categoryInfoFn(node.id);
                    });

                const addBtn = $(`<button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="openCreateFormFn(${node.id},'${node.ActiveStatus}')" title="Add category inside ${node.Name}"><i class="fas fa-plus fa-xs"></i></button>`);
                    
                li.append(toggle, icon, label, addBtn);
                ul.append(li);

                if (hasChild) {
                    buildTree(node.children, li);
                }
            });
        }

        $(document).on("click", ".toggle", function (e) {
            e.stopPropagation();
            const icon = $(this);
            const ul = icon.closest("li").children("ul");

            ul.toggle();
            icon.toggleClass("fa-chevron-right fa-chevron-down");
        });

        $("#search-box").on("keyup", function () {
            const keyword = $(this).val().trim().toLowerCase();
            $(".clear-search").toggle(keyword.length > 0);

            // RESET LABELS
            $(".label").each(function () {
                $(this).html($(this).text());
            });

            $(".no-record").hide();

            // COLLAPSE EVERYTHING
            $(".record_tree li").hide();
            $(".record_tree ul").hide();
            $(".record_tree > ul").show(); // root only

            $(".toggle")
                .removeClass("fa-chevron-down")
                .addClass("fa-chevron-right");

            if (!keyword) {
                // Restore labels
                $(".label").each(function () {
                    $(this).html($(this).text());
                });

                // Show full tree
                $(".record_tree li").show();
                $(".record_tree ul").hide();
                $(".record_tree > ul").show(); // root visible

                // Reset chevrons
                $(".toggle")
                    .removeClass("fa-chevron-down")
                    .addClass("fa-chevron-right");

                $(".no-record").hide();
                return;
            }

            let found = false;

            $(".label").each(function () {
                const originalText = $(this).text();
                const lowerText = originalText.toLowerCase();

                if (lowerText.includes(keyword)) {
                    found = true;

                    const regex = new RegExp(`(${keyword})`, "ig");
                    $(this).html(originalText.replace(regex, "<mark style='background-color:yellow'>$1</mark>"));

                    const li = $(this).closest("li");

                    li.show();

                    li.parents("li").each(function () {
                        $(this).show();
                        $(this).children("ul").show();
                        $(this).children(".toggle")
                            .removeClass("fa-chevron-right")
                            .addClass("fa-chevron-down");
                    });
                }
            });

            if (!found) {
                $(".record_tree > ul").hide();
                $(".no-record").show();
            }
        });

        $(".clear-search").on("click", function () {
            $("#search-box").val("").trigger("keyup");
            $(this).hide();
        });

        function resetForm(){
            var createFlag = $('#createFlag').val();
            if(createFlag != 2){
                $('#parent_category').val(null).select2
                ({
                    placeholder: "Select parent category here...",
                });
            }
            $('#status').val("Active").select2
            ({
                placeholder: "Select status here",
                minimumResultsForSearch: -1
            });

            $(".reg_form").val("");
            $(".errordatalabel").html("");

            $('#savebutton').text('Save & Close');
            $('#savebutton').prop("disabled",false);
            $('#savebutton').show();

            $('#savenewbutton').text('Save & New');
            $('#savenewbutton').prop("disabled",false);
            $('#savenewbutton').show();
            $('#operationType').val(1);
            
            $('#form_title_lbl').html("Add Category");
        }

        function refreshDataFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
            getTreeDataFn();
        }

        function parentCategoryFn(){
            $("#parent-category-error").html("");
        }

        function categoryFn(){
            $('#name-error').html('');
        }

        function descriptionFn(){
            $("#description-error").html("");
        }

        function statusFn(){
            $("#status-error").html("");
        }
    </script>
@endsection
