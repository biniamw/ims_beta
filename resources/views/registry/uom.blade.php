@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @if (auth()->user()->can('UOM-s-View') || auth()->user()->can('Conversion-s-view'))
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">UOM (Unit of Measurement)</h3>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: center !important;">
                                        <ul class="nav nav-tabs justify-content-center" role="tablist">
                                            @can('UOM-View')
                                            <li class="nav-item">
                                                <a class="nav-link active header-tab" id="uom-tab" data-toggle="tab" href="#uom-content" aria-controls="uom-content" role="tab" aria-selected="false" title="UOM View"><i class="fas fa-ruler-triangle"></i><span class="tab-text">UOM</span></a>
                                            </li>
                                            @endcan
                                            @can('Conversion-view')
                                            <li class="nav-item">
                                                <a class="nav-link header-tab" id="conversion-tab" data-toggle="tab" href="#conversion-content" aria-controls="conversion-content" role="tab" aria-selected="true" title="Conversion View"><i class="fas fa-exchange"></i><span class="tab-text">Conversion</span></a>                                
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshUomConvFn()"><i class="fas fa-sync-alt"></i></button>
                                        @if (auth()->user()->can('UOM-View') || auth()->user()->can('Conversion-view'))
                                            <button type="button" class="btn btn-gradient-info btn-sm add_uom_conv header-prop" id="add_uom_conv"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                        @endif 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable">
                            <div class="tab-content">
                                @can('UOM-View')
                                <div class="tab-pane active fit-content" id="uom-content" aria-labelledby="home-tab" role="tabpanel">
                                    <div style="width:99%; margin-left:0.5%;" id="uom-data" style="display: none;">
                                        <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="display:none;"></th>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:50%;">UOM Name</th>
                                                    <th style="width:43%;">Status</th>
                                                    <th style="width:4%;">Action</th>
                                                </tr>
                                            </thead>  
                                            <tbody class="table table-sm"></tbody>
                                        </table>
                                    </div>
                                </div>
                                @endcan
                                @can('Conversion-view')
                                <div class="tab-pane fit-content" id="conversion-content" aria-labelledby="conversion-content" role="tabpanel">
                                    <div style="width:99%; margin-left:0.5%;" id="conversion-data" style="display: none;">
                                        <table id="laravel-datatable-conversion" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="display: none;"></th>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:25%;">From</th>
                                                    <th style="width:25%;">To</th>
                                                    <th style="width:23%;">Amount</th>
                                                    <th style="width:20%;">Status</th>
                                                    <th style="width:4%;">Action</th>
                                                </tr>
                                            </thead>    
                                            <tbody class="table table-sm"></tbody>
                                        </table>
                                    </div>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endif

    <div class="modal fade text-left" id="uominfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="uom_conversion_info_title">UOM Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="uominfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <table class="infotbl" style="width: 100%;font-size:12px">
                                    <tr>
                                        <td><label class="info_lbl">UOM Name</label></td>
                                        <td><label class="info_lbl" id="uomnameinfo" style="font-weight:bold;"></label></td>
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
                                        <ul class="dropdown-menu" id="uom_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <button id="closebuttonuom" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Registration Modal -->
    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="uom_form_title">Add UOM</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetUomFormFn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">UOM Name<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" placeholder="UOM(Unit of Measurement) Name" class="form-control reg_form" name="Name" id="Name" onkeyup="uomNameFn()"/>
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
                                <select class="select2 form-control" name="status" id="status" onchange="uomStatusFn()">
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
                        <button id="closebutton" type="button" class="btn btn-danger form_btn" onclick="resetUomFormFn()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <div class="modal fade text-left" id="conversioninfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="conversioninfomodalaria" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="conversioninfomodalaria">Conversion Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="conversioninfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <table class="infotbl" style="width: 100%;font-size:12px">
                                    <tr>
                                        <td><label class="info_lbl">From UOM</label></td>
                                        <td><label class="info_lbl" id="fromuominfolbl" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">To UOM</label></td>
                                        <td><label class="info_lbl" id="touominfolbl" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Amount</label></td>
                                        <td><label class="info_lbl" id="amountinfolbl" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Description</label></td>
                                        <td><label class="info_lbl" id="convDescinfolbl" style="font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl">Status</label></td>
                                        <td><label class="info_lbl" id="convstatusinfo" style="font-weight:bold;"></label></td>
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
                                        <ul class="dropdown-menu" id="conv_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <button id="closebuttonconv" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- conversion modal-body --}}
    <div class="modal fade text-left fit-content" id="CoversionForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="conv_form_title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetConversionFormFn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Registerconversion">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">From<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control uomfrom" name="from" id="from" onchange="fromConvFn()"></select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="from-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">To<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control uomto" name="to" id="to" onchange="toConvFn()"></select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="to-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Amount<b style="color: red; font-size:16px;">*</b></label>
                                <input type="number" placeholder="Amount" class="form-control reg_form" name="amount" id="amount" onkeyup="amountConvFn()"/>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="amount-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Description</label>
                                <textarea type="text" placeholder="Write Description here..." class="form-control reg_form" rows="1" name="convDescription" id="convDescription" onkeyup="convDescriptionFn()"></textarea>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="convdesc-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Status<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control" name="cstatus" id="cstatus" onchange="statusConvFn()">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="cs-error"></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="uom_list" id="uom_list">
                                <option selected disabled value=""></option> 
                                @foreach ($uomlist as $uomlist)
                                    <option value="{{ $uomlist->id }}">{{ $uomlist->Name }}</option>
                                @endforeach 
                            </select>
                            <input type="hidden" class="form-control" name="convCreateFlag" id="convCreateFlag">
                            <input type="hidden" class="form-control reg_form" name="convRecordId" id="convRecordId">
                            <input type="hidden" class="form-control reg_form" name="convOperationType" id="convOperationType">
                        </div>
                        <button id="savenewbuttonconvnew" type="button" class="btn btn-info form_btn conv-record-save" data-action="new">Save & New</button>
                        <button id="savebuttonconvclose" type="button" class="btn btn-info form_btn conv-record-save" data-action="close">Save & Close</button>
                        <button id="closebutton" type="button" class="btn btn-danger form_btn" onclick="resetConversionFormFn()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of conversion modal --}}

    @include('layout.universal-component')

    <script type="text/javascript">

        //--------------COMMON SECTION STARTS--------
        $(function () {
            cardSection = $('#page-block');
        });

        var globalIndex = -1;
        var convGlobalIndex = -1;

        $(document).ready( function () {
            $('#uom-data').hide();
            $('#conversion-data').hide();

            fetchUomDataFn();
            fetchConversionDataFn();
        });

        $("#add_uom_conv").on("click", function () {
            var tab_id = $('.tab-pane.active').attr('id');

            if(tab_id == "uom-content"){
                uomFn();
            }
            else if(tab_id == "conversion-content"){
                conversionFn();
            }
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });
        //--------------COMMON SECTION ENDS-------

        //--------------UOM SECTION STARTS--------
        function fetchUomDataFn(){
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
                    url: '/uomdata',
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
                            return `<div class="text-center"><a class="uomInfo" href="javascript:void(0)" onclick="uomInfoFn(${row.id})" data-id="uom_id${row.id}" id="uom_id${row.id}" title="Open UOM form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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
                    $("#uom-data").show();
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
        }

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[globalIndex]).addClass('selected');
        }

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            globalIndex = $(this).index();
        });

        function uomFn(){
            resetUomFormFn();
            $('#inlineForm').modal('show');
        }

        function resetUomFormFn(){
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
            
            $('#uom_form_title').html("Add UOM");
        }

        function uomNameFn(){
            $('#name-error' ).html("");
        }

        function descriptionFn(){
            $('#description-error' ).html("");
        }

        function uomStatusFn(){
            $('#status-error' ).html("");
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
                url: '/saveuom',
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
                            createUOMInfoFn(recordId);
                        }
                        if(action == "close"){
                            $("#inlineForm").modal('hide');
                        }
                        if(action == "new"){
                            resetUomFormFn();
                        }
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        });

        function createUOMInfoFn(recordId){
            var action_links = "";
            var lidata = "";
            $.ajax({
                type: "get",
                url: "{{url('oumedit')}}"+'/'+recordId,
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
                    $.each(data.uomprp, function(key, value) {
                        $('#uomnameinfo').html(value.Name);
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
                            classes = "danger";
                        }
                        lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $("#universal-action-log-canvas").empty().append(lidata);

                    action_links = `
                        <li>
                            <a class="dropdown-item viewUOMAction" onclick="viewUOMFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("UOM-Edit")
                        <li>
                            <a class="dropdown-item uomEdit" onclick="uomEditFn(${recordId})" data-id="editlinkbtn${recordId}" id="editlinkbtn${recordId}" title="Open UOM edit form">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("UOM-Delete")
                        <li>
                            <a class="dropdown-item uomDelete" onclick="uomDeleteFn(${recordId})" data-id="deletelinkbtn${recordId}" id="deletelinkbtn${recordId}" title="Open UOM delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan
                    `;
                    $("#uom_action_ul").empty().append(action_links);
                },
            });
        }

        function uomInfoFn(recordId){
            createUOMInfoFn(recordId);
            $('#uominfomodal').modal('show');
        }

        function viewUOMFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function uomEditFn(recordId) {
            $("#createFlag").val("");
            resetUomFormFn();
            $.ajax({
                type: "get",
                url: "{{url('oumedit')}}"+'/'+recordId,
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
                    $.each(data.uomprp, function(key, value) {
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
            $('#form_title_lbl').html("Edit UOM");
            $('#inlineForm').modal('show');
        }

        function uomDeleteFn(recordId){
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
                    deleteUOMFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function deleteUOMFn(recordId){
            var formData = $("#uominfoform").serialize();
            $.ajax({
                url: '/deleteuom/'+recordId,
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
                        $("#uominfomodal").modal('hide');
                    }
                }
            });
        }
        //--------------UOM SECTION ENDS--------

        //--------------CONVERSION SECTION STARTS--------
        function fetchConversionDataFn(){
            $('#laravel-datatable-conversion').DataTable({
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
                    url: '/conversiondata',
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
                        setConvFocus('#laravel-datatable-conversion');
                        $('#laravel-datatable-conversion').DataTable().columns.adjust();
                    },
                },
                columns: [
                    { data: 'id', name: 'id', 'visible': false },
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'fromunit', name: 'fromunit',width:"25%"},
                    { data: 'tounit', name: 'tounit',width:"25%"},
                    { data: 'Amount', name: 'Amount',width:"23%"},
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
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="conversionInfo" href="javascript:void(0)" onclick="conversionInfoFn(${row.id})" data-id="conv_id${row.id}" id="conv_id${row.id}" title="Open conversion form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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
                    $("#conversion-data").show();
                    $('#laravel-datatable-conversion').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
        }

        function setConvFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[convGlobalIndex]).addClass('selected');
        }

        $('#laravel-datatable-conversion tbody').on('click', 'tr', function () {
            $('#laravel-datatable-conversion tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            convGlobalIndex = $(this).index();
        });
        
        function conversionFn(){
            resetConversionFormFn();
            $('#CoversionForm').modal('show');
        }

        function resetConversionFormFn(){
            var default_opt = '<option selected disabled value=""></option>';
            var uom_options = $("#uom_list > option").clone();

            $('#from').empty().append(uom_options);
            $('#from').append(default_opt).select2
            ({
                placeholder: "Select UOM here",
            });

            $('#to').empty().select2
            ({
                placeholder: "Select From UOM first",
            });

            $('#cstatus').val("Active").select2
            ({
                placeholder: "Select status here",
                minimumResultsForSearch: -1
            });

            $(".reg_form").val("");
            $(".errordatalabel").html("");

            $('#savebuttonconvclose').text('Save & Close');
            $('#savebuttonconvclose').prop("disabled",false);
            $('#savebuttonconvclose').show();

            $('#savenewbuttonconvnew').text('Save & New');
            $('#savenewbuttonconvnew').prop("disabled",false);
            $('#savenewbuttonconvnew').show();
            $('#convOperationType').val(1);
            
            $('#conv_form_title').html("Add Converstion");
        }

        function fromConvFn(){
            var from_id = $("#from").val();
            var default_opt = '<option selected disabled value=""></option>';
            var uom_options = $("#uom_list > option").clone();
            $('#to').empty().append(uom_options);
            $(`#to option[value="${from_id}"]`).remove();
            $('#to').append(default_opt).select2
            ({
                placeholder: "Select UOM here",
            });

            $('#from-error' ).html("");
        }

        function toConvFn(){
            $('#to-error' ).html("");
        }

        function amountConvFn() {
            $('#amount-error' ).html("");
        }

        function convDescriptionFn(){
            $('#convdesc-error' ).html("");
        }

        function statusConvFn(){
            $('#cs-error' ).html("");
        }

        $('.conv-record-save').on('click', function(e) {
            e.preventDefault();
            var optype = $("#convOperationType").val();
            var recordId = $("#convRecordId").val();
            var createFlag = $("#convCreateFlag").val();
            var formData = $("#Registerconversion").serialize();

            var button = $(this);
            var action = button.data('action'); 

            $.ajax({
                url:'/saveconversion',
                type:'POST',
                data:formData,
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
                success:function(data) {
                    if(data.errors) {
                        if(data.errors.from){
                            $( '#from-error' ).html( data.errors.from[0] );
                        }
                        if(data.errors.to){
                            $( '#to-error' ).html( data.errors.to[0] );
                        }
                        if(data.errors.amount){
                            $( '#amount-error' ).html( data.errors.amount[0] );
                        }
                        if(data.errors.cstatus){
                            $( '#cs-error' ).html( data.errors.cstatus[0] );
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
                            createConvInfoFn(recordId);
                        }
                        if(action == "close"){
                            $("#CoversionForm").modal('hide');
                        }
                        if(action == "new"){
                            resetConversionFormFn();
                        }
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-conversion').dataTable();
                        oTable.fnDraw(false);
                    }
                },
            });
        });

        function conversionInfoFn(recordId){
            createConvInfoFn(recordId);
            $('#conversioninfomodal').modal('show');
        }

        function createConvInfoFn(recordId){
            var action_links = "";
            var lidata = "";
            $.ajax({
                type: "get",
                url: "{{url('getConversionVal')}}"+'/'+recordId,
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
                    $.each(data.convprp, function(key, value) {
                        $('#fromuominfolbl').html(value.fromunit);
                        $('#touominfolbl').html(value.tounit);
                        $('#amountinfolbl').html(value.Amount);
                        $('#convDescinfolbl').html(value.description);
                        $("#convstatusinfo").html(value.ActiveStatus == "Active" ? 
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
                            classes = "danger";
                        }
                        lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $("#universal-action-log-canvas").empty().append(lidata);

                    action_links = `
                        <li>
                            <a class="dropdown-item viewConversionAction" onclick="viewConversionFn(${recordId})" data-id="view_conversion_btn${recordId}" id="view_conversion_btn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Conversion-edit")
                        <li>
                            <a class="dropdown-item editConversion" onclick="editConversionFn(${recordId})" data-id="edit_conv_link_btn${recordId}" id="edit_conv_link_btn${recordId}" title="Open Conversion edit form">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Conversion-delete")
                        <li>
                            <a class="dropdown-item deleteConversion" onclick="conversionDeleteFn(${recordId})" data-id="delete_conv_link_btn${recordId}" id="delete_conv_link_btn${recordId}" title="Open Conversion delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan
                    `;
                    $("#conv_action_ul").empty().append(action_links);
                },
            });
        }

        function viewConversionFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function editConversionFn(recordId) {
            $("#convCreateFlag").val("");
            resetConversionFormFn();
            var uom_options = $("#uom_list > option").clone();
            $.ajax({
                type: "get",
                url: "{{url('getConversionVal')}}"+'/'+recordId,
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
                    $.each(data.convprp, function(key, value) {
                        $(`#from option[value="${value.FromUomID}"]`).remove();
                        $('#from').append(`<option selected value="${value.FromUomID}">${value.fromunit}</option>`).select2();
                        $('#to').empty().append(uom_options);
                        $(`#to option[value="${value.FromUomID}"]`).remove();
                        $(`#to option[value="${value.ToUomID}"]`).remove();
                        $('#to').append(`<option selected value="${value.ToUomID}">${value.tounit}</option>`).select2();
                        $('#amount').val(value.Amount);
                        $('#convDescription').val(value.description);
                        $('#cstatus').val(value.ActiveStatus).select2({ minimumResultsForSearch: -1});
                        $('#convRecordId').val(value.id);
                    });
                },
            });

            $('#savebuttonconvclose').text('Update');
            $('#savebuttonconvclose').prop("disabled",false);
            $('#savebuttonconvclose').show();

            $('#savenewbuttonconvnew').text('Update');
            $('#savenewbuttonconvnew').prop("disabled",false);
            $('#savenewbuttonconvnew').hide();

            $('#operationType').val(2);
            $('#conv_form_title').html("Edit Conversion");
            $('#CoversionForm').modal('show');
        }

        function conversionDeleteFn(recordId){
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
                    deleteConversionFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function deleteConversionFn(recordId){
            var formData = $("#conversioninfoform").serialize();
            $.ajax({
                url: '/deleteconversion/'+recordId,
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
                    if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-conversion').dataTable();
                        oTable.fnDraw(false);
                        $("#conversioninfomodal").modal('hide');
                    }
                }
            });
        }
        //--------------CONVERSION SECTION ENDS--------

        //--------------COMMON SECTION STARTS--------
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

        function refreshUomConvFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);

            var cTable = $('#laravel-datatable-conversion').dataTable();
            cTable.fnDraw(false);
        }
        //--------------COMMON SECTION ENDS--------

    </script>
@endsection

