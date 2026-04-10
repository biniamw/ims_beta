@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Brand-View')
        <div class="app-content content ">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom fit-content mb-0 pb-0">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                            <h3 class="card-title form_title">Brand & Model</h3>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshBrandDataFn()"><i class="fas fa-sync-alt"></i></button>
                                            @if (auth()->user()->can('Brand-Add'))
                                            <button type="button" class="btn btn-gradient-info btn-sm addbrand header-prop" id="addbrand"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                            @endcan 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-datatable fit-content">
                                <div style="width:99%; margin-left:0.5%;display:none;" id="main-datatable">
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width: 3%;">#</th>
                                                <th style="width: 50%;">Brand Name</th>
                                                <th style="width: 43%;">Status</th>
                                                <th style="width: 4%;">Action</th>
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

    <div class="modal fade text-left fit-content" id="brandinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel356" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Brand & Model Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="brandmodelinfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title brand_header_info"><i class="far fa-info-circle"></i> Brand Information</h5>
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
                                                                    <td><label class="info_lbl">Brand Name</label></td>
                                                                    <td><label class="info_lbl" id="brandnameinfl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Description</label></td>
                                                                    <td><label class="info_lbl" id="infoDescription" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Status</label></td>
                                                                    <td><label class="info_lbl" id="statusinfo" style="font-weight: bold;"></label></td>
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 infoModelDiv table-responsive scroll scrdiv" id="model_div">
                                    <table id="modelinfotbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width: 5%">#</th>
                                                <th style="width: 35%">Model Name</th>
                                                <th style="width: 40%">Description</th>
                                                <th style="width: 20%">Status</th>
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
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn form_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-down fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="brand_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <button id="closebuttonmodel" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Registration Modal -->
    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="brandformtitle"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Brand Name<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" id="Name" placeholder="Brand Name" class="form-control reg_form" name="Name" onkeypress="brandFn()"/>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="name-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Description</label>
                                <textarea type="text" placeholder="Write Description here..." class="form-control reg_form" rows="1" name="description" id="description" onkeyup="descriptionFn()"></textarea>
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
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                    <table id="dynamicTable" class="mb-0 rtable form_dynamic_table" style="width:100%;min-width: 400px;">
                                        <thead>
                                            <tr>
                                                <th class="form_lbl" style="width:5%;">#</th>
                                                <th class="form_lbl" style="width:30%">Model Name<b style="color: red; font-size:16px;">*</b></th>
                                                <th class="form_lbl" style="width:40%">Description</th>
                                                <th class="form_lbl" style="width:20%">Status<b style="color: red; font-size:16px;">*</b></th>
                                                <th class="form_lbl" style="width:5%"></th>
                                            </tr>
                                        <thead>
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
                        <input type="hidden" class="form-control reg_form" name="recordId" id="recordId">
                        <input type="hidden" class="form-control reg_form" name="operationType" id="operationType">
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    @include('layout.universal-component')
@endsection

@section('scripts')
    <script  type="text/javascript">
        var errorcolor = "#ffcccc";
        var globalIndex = -1;
        $(function () {
            cardSection = $('#page-block');
        });

        var j = 0;
        var i = 0;
        var m = 0;

        //Datatable read property starts
        $(document).ready( function () {
            $("#main-datatable").hide();
            $('#laravel-datatable-crud').DataTable({
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
                    url: '/branddata',
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
                    { data:'DT_RowIndex',width:"3%"},
                    { data: 'Name', name: 'Name',width:"50%"},
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
                        width:"43%"
                    },  
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="brandInfo" href="javascript:void(0)" onclick="brandInfoFn(${row.id})" data-id="brand_id${row.id}" id="brand_id${row.id}" title="Open brand information page"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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
        //Datatable read property ends

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            globalIndex = $(this).index();
        });

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[globalIndex]).addClass('selected');
        }

        $("#addbrand").click(function() {
            resetBrandFormFn();
            $("#brandformtitle").html("Add Brand & Model");
            $("#inlineForm").modal('show');
        });

        //Save Records to database start
        $('#savebutton').click(function(){
            var optype = $("#operationType").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url:'/savebrand',
                type:'POST',
                data:formData,
                beforeSend:function(){
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
                success:function(data) {
                    if(data.errors) {
                        if(data.errors.Name){
                            $('#name-error').html(data.errors.Name[0]);
                        }
                        if(data.errors.status){
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
                    else if (data.errorv2){
                        var error_html = '';
                        var selecteditemsvar = '';
                        $.each(data.errorv2, function(field, messages) {
                            var match = messages.match(/row\.(\d+)\./);
                            
                            if(messages.includes("has already been taken") || messages.includes("has a duplicate value")){
                                var indx = match ? match[1] : null;
                                $(`#ModelName${indx}`).css("background", errorcolor);
                            }
                        });

                        $('#dynamicTable > tbody > tr').each(function (index) {
                            let k = $(this).find('.vals').val();
                            var modelname = ($(`#ModelName${k}`)).val();
                            if(($(`#ModelName${k}`).val()) != undefined && modelname == ""){
                                $(`#ModelName${k}`).css("background", errorcolor);
                            }
                            if($(`#Status${k}`).val() != undefined && $(`#ModelName${k}`).val() == null){
                                $(`#select2-Status${k}-container`).parent().css('background-color',errorcolor);
                            }
                        });

                        if(parseInt(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseInt(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"The highlighted field is either empty or already exists. Please check and try again.","Error");
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
                        if(parseInt(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseInt(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please add atleast one item","Error");
                    }
                    else if(data.success) {
                        if(parseInt(optype) == 2){
                            createBrandInfoFn(data.rec_id);
                        }
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                },
            });
        });
        //Save records and close modal end

        function brandInfoFn(recordId){
            createBrandInfoFn(recordId);
            $('#brandinfomodal').modal('show');
        }

        function createBrandInfoFn(recordId){
            var action_log = "";
            var lidata = "";
            var action_links = "";
            $(".infoModelDiv").hide();
            $.ajax({
                type: "get",
                url: "{{url('getbrandmodel')}}"+'/'+recordId,
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
                    fetchModelDataFn(recordId);   
                },
                success: function (data) {
                    $.each(data.brandinfo, function(key, value) {
                        $('#brandnameinfl').html(value.Name);
                        $('#infoDescription').html(value.description);
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
                    $("#universal-action-log-canvas").empty().append(lidata);

                    action_links = `
                        <li>
                            <a class="dropdown-item viewCatAction" onclick="viewBrandFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Brand-Edit")
                        <li>
                            <a class="dropdown-item brandEdit" onclick="brandEditFn(${recordId})" data-id="editlinkbtn${recordId}" id="editlinkbtn${recordId}" title="Open brand edit page">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Brand-Delete")
                        <li>
                            <a class="dropdown-item brandDelete" onclick="brandDeleteFn(${recordId})" data-id="deletelinkbtn${recordId}" id="deletelinkbtn${recordId}" title="Open brand delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan`;

                    $("#brand_action_ul").empty().append(action_links);
                },
            });  
            $(".infoscl").collapse('show');
        }

        function viewBrandFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function fetchModelDataFn(recordId){
            $('.infoModelDiv').hide();
            var ctable = $('#modelinfotbl').DataTable({
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
                    url: '/showmodel'+'/'+recordId,
                    type: 'GET',
                },
                columns: [{
                    data: 'id',
                        name: 'id',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false
                    },
                    { data:'DT_RowIndex',width:"5%"},
                    { data: 'Name', name: 'Name',width:"35%"},
                    { data: 'description', name: 'description',width:"40%"},
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
                        width:"20%"
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
                    $('#model_div').show();
                },
            });
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.brand_header_info');
            const collapseId = collapse.attr('id');
            const trigger = $(`[data-target="#${collapseId}"], [data-bs-target="#${collapseId}"]`);

            const isOpening = e.type === 'show';

            $('.toggle-text-label').html(isOpening ? 'Collapse' : 'Expand');
            $('.collapse-icon').html(isOpening ? '<i class="fas text-secondary fa-minus-circle"></i>' : '<i class="fas text-secondary fa-plus-circle"></i>');

            if (isOpening) {
                const originalHeader = `<i class="far fa-info-circle"></i> Brand Information`;
                infoTarget.html(originalHeader);
            } 
            else {
                // Section is COLLAPSING: Show the data summary
                const brand_name = container.find('#brandnameinfl').text().trim();
                const brand_status = container.find('#statusinfo').text().trim();
                const summaryBrand = `
                    Brand Name: <b>${brand_name}</b>,
                    Status: <b style="color: ${brand_status == "Active" ? "#28c76f" : "#ea5455"}">${brand_status}</b>`;

                infoTarget.html(summaryBrand);
            }
        });

        function brandEditFn(recordId){
            resetBrandFormFn(); 
            j = 0;
            $.ajax({
                type: "get",
                url: "{{url('getbrandmodel')}}"+'/'+recordId,
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
                    $.each(data.brandinfo, function(key, value) {
                    $('#Name').val(value.Name);
                    $('#description').val(value.description);
                    $('#status').val(value.ActiveStatus).select2({minimumResultsForSearch: -1});
                    $('#recordId').val(value.id);
                    });

                    $.each(data.modeldata, function(key, value) {
                        ++i;
                        ++m;
                        ++j;
                        $("#dynamicTable > tbody").append(`<tr id="rowind${m}">
                            <td style="font-weight:bold;width:5%;text-align:center;">${j}</td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td style="width:30%;"><input type="text" name="row[${m}][ModelName]" placeholder="Write model name here..." id="ModelName${m}" class="ModelName form-control" onkeyup="modelNameFn(this)" value="${value.Name}"/></td>
                            <td style="width:40%;"><input type="text" name="row[${m}][Description]" placeholder="Write description here..." id="Description${m}" class="Description form-control" onkeyup="dynamicDescriptionFn(this)" value="${value.description != null ? value.description : ""}"/></td>
                            <td style="width:20%;"><select id="Status${m}" class="select2 form-control Status" name="row[${m}][Status]" onchange="dynamicStatusFn(this)"></select></td>
                            <td style="width:5%;text-align:center;"><button type="button" id="removebtn${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                        </tr>`);

                        var default_status = `<option selected value="${value.ActiveStatus}">${value.ActiveStatus}</option>`;
                        var statusopt = '<option value="Active">Active</option><option value="Inactive">Inactive</option>';
                        $(`#Status${m}`).append(statusopt);
                        $(`#Status${m} option[value='${value.ActiveStatus}']`).remove(); 
                        $(`#Status${m}`).append(default_status).select2
                        ({
                            minimumResultsForSearch: -1
                        });
                    });
                    renumberRows();
                },
            });  

            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#savebutton').show();

            $('#operationType').val(2);
            $('#brandformtitle').html("Edit Brand & Model");
            $('#inlineForm').modal('show');
        }

        $("#adds").click(function() {
            ++i;
            ++m;
            ++j;
            var lastrowcount = $('#dynamicTable > tbody > tr:last').find('td').eq(1).find('input').val();
            var modelname = $(`#ModelName${lastrowcount}`).val();
        
            if(modelname !== undefined && modelname == ""){
                $(`#ModelName${lastrowcount}`).css('background-color',errorcolor);
                toastrMessage('error',"Please insert valid data on highlighted field","Error");
            }
            else{
                $("#dynamicTable > tbody").append(`<tr id="rowind${m}">
                    <td style="font-weight:bold;width:5%;text-align:center;">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:30%;"><input type="text" name="row[${m}][ModelName]" placeholder="Write model name here..." id="ModelName${m}" class="ModelName form-control" onkeyup="modelNameFn(this)"/></td>
                    <td style="width:40%;"><input type="text" name="row[${m}][Description]" placeholder="Write description here..." id="Description${m}" class="Description form-control" onkeyup="dynamicDescriptionFn(this)"/></td>
                    <td style="width:20%;"><select id="Status${m}" class="select2 form-control Status" name="row[${m}][Status]" onchange="dynamicStatusFn(this)"></select></td>
                    <td style="width:5%;text-align:center;"><button type="button" id="removebtn${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                </tr>`);

                var statusopt = '<option value="Active">Active</option><option value="Inactive">Inactive</option>';
                $(`#Status${m}`).append(statusopt);
                $(`#Status${m}`).select2
                ({
                    placeholder: "Select status here",
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
            $('#dynamicTable > tbody tr').each(function(index,el) {
                $(this).children('td').first().text(index+=1);
            });
        }

        function refreshBrandDataFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }

        function brandFn() {
            $('#name-error').html("");
        }

        function descriptionFn() {
            $('#description-error').html("");
        }

        function statusFn(){
            $('#status-error').html("");
        }

        function modelNameFn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#ModelName${cid}`).css("background", "white");
        }

        function dynamicDescriptionFn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#Description${cid}`).css("background", "white");
        }

        function dynamicStatusFn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#select2-Status${cid}-container`).parent().css({"background":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        }

        function brandDeleteFn(recordId){
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
                    deleteBrandFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function deleteBrandFn(recordId){
            var formData = $("#brandmodelinfoform").serialize();
            $.ajax({
                url: '/deletebrand/'+recordId,
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
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#brandinfomodal").modal('hide');
                    }
                }
            });
        }

        function resetBrandFormFn(){
            $('#status').val("Active").select2
            ({
                placeholder: "Select status here",
                minimumResultsForSearch: -1
            });

            $(".reg_form").val("");
            $(".errordatalabel").html("");

            $("#dynamicTable > tbody").empty();

            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $('#savebutton').show();

            $('#operationType').val(1);
        }
    </script>   
@endsection
  