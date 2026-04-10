@extends('layout.app1')

@section('title')
@endsection

@section('content')

    @can('Department-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Department</h3>
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
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshDepartmentDataFn()"><i class="fas fa-sync-alt"></i></button>
                                        @can('Department-Add')
                                            <button type="button" class="btn btn-gradient-info btn-sm adddepartment header-prop" id="adddepartment"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                        @endcan 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable">
                            <div class="tab-content">
                                <div class="tab-pane active fit-content" id="tableview" aria-labelledby="tableview" role="tabpanel">
                                    <div style="width:99%; margin-left:0.5%;display:none;" id="main-datatable">
                                        <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="display: none;"></th>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:31%;">Parent Department</th>
                                                    <th style="width:31;">Department Name</th>
                                                    <th style="width:31%;">Status</th>
                                                    <th style="width:4%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table table-sm"></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="hierarchyview" aria-labelledby="hierarchyview" role="tabpanel">
                                    <div class="row" id="hierarchyviewdiv">
                                        <div class="col-xl-3 col-md-3 col-sm-3 mt-1"></div>
                                        <div class="col-xl-6 col-md-6 col-sm-6"></div>
                                        <div class="col-xl-3 col-md-3 col-sm-3 mt-1" style="text-align: right;">
                                            <button type="button" onclick="downloadPDF()" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Export the entire tree to pdf"><i class="fa-solid fa-file-pdf fa-lg" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1" id="pdfExport" style="width: 100%;">
                                            <h2 style="font-weight:bold;text-align: center; color: #82868b;">
                                                <i class="fas fa-sitemap"></i> Department Structure
                                            </h2>
                                            <div id="dep_tree" class="strclass" style="width: 100%;"></div>
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

    <!--Start Information Modal -->
    <div class="modal fade text-left fit-content" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Department Information</h4>
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
                                        <td><label class="info_lbl">Parent Department</label></td>
                                        <td><label class="info_lbl" id="parentdepartmentlbl" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Department Name</label></td>
                                        <td><label class="info_lbl" id="departmentnamelbl" style="font-weight:bold;"></label></td>
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
                                        <ul class="dropdown-menu" id="department_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="departmentInfoId" id="departmentInfoId" readonly="true" value=""/> 
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
                    <h4 class="modal-title form_title" id="departmenttitle">Add Department</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Parent Department<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control" name="ParentDepartment" id="ParentDepartment" onchange="parentdepFn()"></select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="parentdep-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Department Name<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" placeholder="Department Name" class="form-control reg_form" name="DepartmentName" id="DepartmentName" onkeyup="departmentNameFn()"/>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="name-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Description</label>
                                <textarea type="text" placeholder="Write Description here..." class="form-control reg_form" rows="1" name="Description" id="Description" onkeyup="descriptionfn()"></textarea>
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
                        <input type="hidden" class="form-control reg_form" name="departmentId" id="departmentId" readonly="true" value=""/>     
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
                    url: '/departmentlist',
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
                    { data: 'id', name: 'id', 'visible': false},
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'ParentDepartmentName', name: 'ParentDepartmentName',width:"31%"},
                    { data: 'DepartmentName', name: 'DepartmentName',width:"31%"},
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
                        width:"31%"
                    },
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="departmentInfo" href="javascript:void(0)" onclick="departmentInfoFn(${row.id})" data-id="department_id${row.id}" id="department_id${row.id}" title="Open department information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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
                    $("#main-datatable").show();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });

            hierarchyFn();
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

        function hierarchyFn(){
            var alldepdata=[];
            var alldep=[];
            var alldepd=[];
            var singledata="";
            var departmentname="";
            var pids="";
            var myObject="";
            var depId="";
            $.get("/showdepartmenthier", function(data) {
                singledata="";
                google.charts.load('current', {packages:["orgchart"]});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var chdata = new google.visualization.DataTable();
                    chdata.addColumn('string', 'Name');
                    chdata.addColumn('string', 'Manager');
                    chdata.addColumn('string', 'ToolTip');

                    $.each(data.deplist, function(key, value) {
                        
                        departmentname = value.id ==1 ? "Root" : value.DepartmentName;
                        pids = value.departments_id==1 ? '' : String(value.departments_id);
                        depId = String(value.id); // Ensure it's a string

                        var rowdata = `<div ondblclick="departmentInfoFn(${value.id})" style="
                                        width: auto !important;
                                        height: 50px;
                                        font-family: 'Montserrat', sans-serif;
                                        text-align: center;
                                        padding: 10px 25px 10px 10px; 
                                        border-radius: 10px;
                                        background: #fcfcff; 
                                        border: 2px solid #00cfe8;
                                        color: #333;
                                        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                                        display: inline-flex;
                                        flex-direction: column;
                                        justify-content: center; 
                                        align-items: center;
                                        position: relative;
                                        box-sizing: border-box;">
                                        <div title="Action" style="
                                            position: absolute;
                                            top: 15px; 
                                            right: 0px;
                                            transform: translateY(-50%); 
                                            background: transparent;
                                            border: none;
                                            font-size: 16px;
                                            color: #00cfe8;
                                            cursor: pointer;
                                            z-index: 1;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;">
                                                <a class="parentDepartment" href="javascript:void(0)" onclick="openDepartmentFormFn(${value.id},'${value.Status}')" data-id="parent_department${value.id}" id="parent_department${value.id}" title="Create child department under ${departmentname} department"><i class="fa-sharp fa-regular fa-circle-plus fa-lg" style="color: #00cfe8;"></i></a>
                                        </div>
                                        </br>
                                        <strong style="font-size:12px; white-space: nowrap;color:${value.Status == "Inactive" ? "#ea5455" : "#000000"}">${departmentname}</strong>
                                    </div>`;

                        chdata.addRow([
                            {v: depId, f: rowdata},pids,''
                        ]);
                    });

                    var chart = new google.visualization.OrgChart(document.getElementById('dep_tree'));
                    chart.draw(chdata, {allowHtml:true});
                }   
            });  
        }

        async function downloadPDF() {
            const chartElement = document.getElementById('pdfExport');
            const canvas = await html2canvas(chartElement, {
                backgroundColor: null,
                scale: 2
            });
            const imageData = canvas.toDataURL('image/png');
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF({
                orientation: 'landscape',
                unit: 'px',
                format: [canvas.width, canvas.height]
            });
            pdf.addImage(imageData, 'PNG', 0, 0, canvas.width, canvas.height);
            pdf.save('department_structure.pdf');
        }

        $("#adddepartment").on("click", function () {
            resetDepartmentFormFn();
            fetchParentDepartmentFn();
            $("#createFlag").val(1);
            $("#inlineForm").modal('show');
        });

        function openDepartmentFormFn(department_id,status){
            if(status == "Active"){
                resetDepartmentFormFn();
                $('#ParentDepartment').empty();
                fetchDefaultDepartmentFn(department_id);
                $("#createFlag").val(2);
                $("#inlineForm").modal('show');
            }
            else{
                toastrMessage('error',"You cannot add child unders this department, because it is Inactive","Error");
            }
        }

        $('.record-save').on('click', function(e) {
            e.preventDefault();
            var optype = $("#operationtypes").val();
            var recordId = $("#departmentId").val();
            var createFlag = $("#createFlag").val();
            var formData = $("#Register").serialize();

            var button = $(this);
            var action = button.data('action'); 

            $.ajax({
                url: '/saveDepartment',
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
                        if (data.errors.DepartmentName) {
                            $('#name-error').html(data.errors.DepartmentName[0]);
                        }
                        if (data.errors.ParentDepartment) {
                            $('#parentdep-error').html(data.errors.ParentDepartment[0]);
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
                    else if(data.errflag){
                        resetButton(button, action, optype);
                        toastrMessage('error',"Parent department and Department can't be the same","Error");
                    }
                    else if (data.dberrors) {
                        resetButton(button, action, optype);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        resetButton(button, action, optype);
                        if(parseInt(createFlag) == 1 && parseInt(optype) == 1 && $('#status').val() == "Active"){
                            appendLastRecordFn(data.rec_id);
                        }
                        if(parseInt(optype) == 2){
                            createDepartmentInfoFn(recordId);
                        }
                        if(action == "close"){
                            $("#inlineForm").modal('hide');
                        }
                        if(action == "new"){
                            if(parseInt(createFlag) != 2){
                                fetchParentDepartmentFn();
                            }
                            resetDepartmentFormFn();
                        }
                        hierarchyFn();
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $('#laravel-datatable-crud').DataTable().columns.adjust();
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function appendLastRecordFn(rec_id){
            var department_name = $('#DepartmentName').val();
            var parent_options = `<option value="${rec_id}">${department_name}</option>`;
            $('#ParentDepartment').append(parent_options);
        }

        function resetButton(button, action, optype) {
            button.prop('disabled', false);
            
            if(action === 'new') {
                button.text('Save & New');
            } 
            if(action === 'close') {
                button.text('Save & Close');
            }

            if(optype === 2){
                button.text('Update');
            }
        }

        function fetchParentDepartmentFn() {
            var department_option_data = `<option selected disabled value=""></option>`;
            $.ajax({
                url: '/showdepartmenthier',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data.all_department, function(key, value) {
                        department_option_data += `<option value="${value.id}">${value.DepartmentName}</option>`;
                    }); 

                    $('#ParentDepartment').empty().append(department_option_data).select2
                    ({
                        placeholder: "Select parent department here...",
                    });
                }
            });
        }

        function fetchDefaultDepartmentFn(recordId){
            $.ajax({
                type: "get",
                url: "{{url('showdepartment')}}"+'/'+recordId,
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
                    $.each(data.departmentlist, function(key, value) {
                        $('#ParentDepartment').append(`<option selected value="${recordId}">${value.DepartmentName}</option>`).select2({minimumResultsForSearch: -1});
                    });
                }
            });
        }

        function departmentEditFn(recordId) { 
            $("#createFlag").val("");
            resetDepartmentFormFn();
            fetchParentDepartmentFn();
            $.ajax({
                type: "get",
                url: "{{url('showdepartment')}}"+'/'+recordId,
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
                    $.each(data.departmentlist, function(key, value) {
                        $("#departmentId").val(recordId);
                        $('#DepartmentName').val(value.DepartmentName);
                        $(`#ParentDepartment option[value=${recordId}]`).remove(); 
                        $(`#ParentDepartment option[value=${value.departments_id}]`).remove(); 
                        $('#ParentDepartment').append(`<option selected value="${value.departments_id}">${value.ParentDepartment}</option>`).select2();
                        $("#Description").val(value.Description);
                        $('#status').val(value.Status).select2({minimumResultsForSearch: -1});
                    });
                }
            });
            $("#departmenttitle").html("Edit Department");
            $("#operationtypes").val(2);
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').hide();
            $("#inlineForm").modal('show'); 
        }

        function departmentInfoFn(recordId) { 
            createDepartmentInfoFn(recordId);
            $("#informationmodal").modal('show');
        }

        function createDepartmentInfoFn(recordId) { 
            var action_log = "";
            var action_links = "";
            var lidata = "";
            $.ajax({
                type: "get",
                url: "{{url('showdepartment')}}"+'/'+recordId,
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
                    $.each(data.departmentlist, function(key, value) {
                        $('#parentdepartmentlbl').html(value.ParentDepartment);
                        $('#departmentnamelbl').html(value.DepartmentName);
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
                            <a class="dropdown-item viewDepartmentAction" onclick="viewDepartmentFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Department-Edit")
                        <li>
                            <a class="dropdown-item departmentEdit" onclick="departmentEditFn(${recordId})" data-id="editlinkbtn${recordId}" id="editlinkbtn${recordId}" title="Open department edit page">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Department-Delete")
                        <li>
                            <a class="dropdown-item departmentDelete" onclick="departmentDeleteFn(${recordId})" data-id="deletelinkbtn${recordId}" id="deletelinkbtn${recordId}" title="Open department delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan
                    `;

                    $("#department_action_ul").empty().append(action_links);
                }
            });
        }

        function viewDepartmentFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function departmentDeleteFn(recordId) { 
            $("#departmentInfoId").val(recordId);
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
                    deleteDepartmentFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function deleteDepartmentFn(recordId){
            var delform = $("#InformationForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deletedep',
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
                        hierarchyFn();
                        $('#laravel-datatable-crud').DataTable().columns.adjust();
                    }
                }
            });
        }

        function resetDepartmentFormFn(){
            var createFlag = $('#createFlag').val();
            
            if(createFlag == 1){
                $('#ParentDepartment').empty().select2
                ({
                    placeholder: "Select parent department here",
                });
            }
            else if(createFlag == 2){
                var parent_id = $('#ParentDepartment').val();
                var selected_parent = $('#ParentDepartment option:selected').text();
                var options = `<option selected value="${parent_id}">${selected_parent}</option>`;

                $('#ParentDepartment').empty().append(options).select2({minimumResultsForSearch: -1});
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
            $('#operationtypes').val(1);
            
            $('#departmenttitle').html("Add Department");
        }

        function refreshDepartmentDataFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
            hierarchyFn();
        }

        function hierarchyviewFn() {
            $('#hierarchyviewdiv').show();
        }

        function departmentNameFn() {
            $('#name-error').html('');
        }
        function parentdepFn() {
            $('#parentdep-error').html('');
        }
        
        function descriptionfn() {
            $('#description-error').html('');
        }
        
        function statusFn() {
            $('#status-error').html('');
        }
    </script>
@endsection
