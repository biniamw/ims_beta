@extends('layout.app1')

@section('title')
@endsection

@section('content')
    @can('Period-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom fit-content mb-0 pb-0">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                            <h3 class="card-title form_title">Period</h3>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshPeriodDataFn()"><i class="fas fa-sync-alt"></i></button>
                                            @if (auth()->user()->can('Period-Add'))
                                            <button type="button" class="btn btn-gradient-info btn-sm addperbutton header-prop" id="addperbutton"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
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
                                                <th style="width: 50%">Period Name</th>
                                                <th style="width: 43%">Status</th>
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

    <div class="modal fade text-left fit-content" id="periodinformationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="periodtitleinfolbl" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="periodtitleinfolbl">Period Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="periodinformationform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title period_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
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
                                                                    <td><label class="info_lbl">Period Name</label></td>
                                                                    <td><label class="info_lbl" id="periodnamelbl" style="font-weight: bold;"></label></td>
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 infoPeriodDiv table-responsive scroll scrdiv" id="period_div">
                                    <table id="perioddetaltbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="width:3%;">#</th>
                                                <th rowspan="2" style="width:15%">Days</th>
                                                <th colspan="2" style="width:26%;text-align:center;">First Half Day <i>(00:00-11:59)</i></th>
                                                <th colspan="2" style="width:26%;text-align:center;">Second Half Day <i>(12:00-23:59)</i></th>
                                                <th rowspan="2" style="width:20%">Remark</th>
                                                <th rowspan="2" style="width:10%">Status</th>
                                            </tr>
                                            <tr>
                                                <th style="width:13%">From</th>
                                                <th style="width:13%">To</th>
                                                <th style="width:13%">From</th>
                                                <th style="width:13%">To</th>
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
                                        <ul class="dropdown-menu" id="period_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="periodDelId" id="periodDelId" readonly="true">
                                    <button id="closebuttonperiod" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="periodtitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="periodtitlelbl">Add Period</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Period Name<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" placeholder="Period Name" class="form-control reg_form" name="PeriodName" id="PeriodName" onkeyup="periodnamefn()"/>
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
                                <select class="select2 form-control" name="status" id="status" onchange="paymenttermstatusfn()">
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
                                                <th class="form_lbl" rowspan="2" style="width:3%;">#</th>
                                                <th class="form_lbl" rowspan="2">Days</th>
                                                <th class="form_lbl" colspan="2">First Half Day <i>(00:00-11:59)</i></th>
                                                <th class="form_lbl" colspan="2">Second Half Day <i>(12:00-23:59)</i></th>
                                                <th class="form_lbl" rowspan="2">Remark</th>
                                                <th class="form_lbl" rowspan="2">Status</th>
                                            </tr>
                                            <tr>
                                                <th class="form_lbl">From</th>
                                                <th class="form_lbl">To</th>
                                                <th class="form_lbl">From</th>
                                                <th class="form_lbl">To</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control reg_form" name="periodId" id="periodId" readonly="true" value=""/>     
                        <input type="hidden" class="form-control reg_form" name="operationtypes" id="operationtypes" readonly="true"/>
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layout.universal-component')

    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var globalIndex = -1;
        $(function () {
            cardSection = $('#page-block');
        });

        var j = 0;
        var i = 0;
        var m = 0;
        
        $("#addperbutton").click(function() {
            resetPeriodFormFn();
            resetDaysTableFn();
            $("#inlineForm").modal('show');
        });

        function resetDaysTableFn(){
            var days = [];
            days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            $.each(days, function(m,day) {
                ++m;
                $("#dynamicTable > tbody").append(`<tr id="rowind${m}">
                    <td style="font-weight:bold;width:3%;text-align:center;">${m}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][Days]" id="Days${m}" class="Days form-control" readonly="true" style="font-weight:bold;" value="'+day+'"/></td>
                    <td style="width:12%;text-align:center;">${day}</td>
                    <td style="width:14%;"><input type="text" class="FirstHalfFrom form-control" placeholder="HH:MM" name="row[${m}][FirstHalfFrom]" id="fromfir${m}" onkeyup="firstfromfn(${m})"></td>
                    <td style="width:14%;"><input type="text" class="FirstHalfTo form-control" placeholder="HH:MM" name="row[${m}][FirstHalfTo]" id="tofir${m}" onkeyup="firsttofn(${m})"></td>
                    <td style="width:14%;"><input type="text" class="SecondHalfFrom form-control" placeholder="HH:MM" name="row[${m}][SecondHalfFrom]" id="fromsec${m}" onkeyup="secondfromfn(${m})"></td>
                    <td style="width:14%;"><input type="text" class="SecondHalfTo form-control" placeholder="HH:MM" name="row[${m}][SecondHalfTo]" id="tosec${m}" onkeyup="secondtofn(${m})"></td>
                    <td style="width:19%;"><input type="text" name="row[${m}][Remark]" id="Remark${m}" class="Remark form-control" placeholder="Remark..."/></td>
                    <td style="width:13%;"><select id="Status${m}" class="select2 form-control form-control Statusdet" name="row[${m}][Statusval]" onchange="statusch(this)"><option value="Active">Active</option><option value="Inactive">Inactive</option></select></td>
                </tr>`);

                $(`#fromfir${m}`).timepicker({
                    timeFormat: 'HH:mm',
                    interval: 30,
                    minTime: '00:00',
                    maxTime: '12:59',
                    scrollbar: true,
                    disableTimeRanges:['13:00','23:59'],
                    zindex: 9999999,
                    change: function() {
                        var indx=$(`#vals${m}`).val();
                        firstfromfn(indx);
                    }
                });
                $(`#tofir${m}`).timepicker({
                    timeFormat: 'HH:mm',
                    interval: 30,
                    minTime: '00:00',
                    maxTime: '12:59',
                    scrollbar: true,
                    disableTimeRanges:  ['13:00', '23:59'],
                    zindex: 9999999,
                    change: function() {
                        var indx=$(`#vals${m}`).val();
                        firsttofn(indx);
                    }
                });
                $(`#fromsec${m}`).timepicker({
                    timeFormat: 'HH:mm',
                    interval: 30,
                    minTime: '13:00',
                    maxTime: '23:59',
                    scrollbar: true,
                    disableTimeRanges:  ['01:00', '12:59'],
                    zindex: 9999999,
                    change: function() {
                        var indx=$(`#vals${m}`).val();
                        secondfromfn(indx);
                    }
                });
                $(`#tosec${m}`).timepicker({
                    timeFormat: 'HH:mm',
                    interval: 30,
                    minTime: '13:00',
                    maxTime: '23:59',
                    scrollbar: true,
                    disableTimeRanges:  ['01:00', '12:59'],
                    zindex: 9999999,
                    change: function() {
                        var indx=$(`#vals${m}`).val();
                        secondtofn(indx);
                    }
                });
            });
            $('.Statusdet').select2({
                minimumResultsForSearch: -1
            });
        }

        $(document).ready(function () {
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
                    url: '/periodlist',
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
                    { data: 'PeriodName', name: 'PeriodName',width:"50%"},
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
                            return `<div class="text-center"><a class="periodInfo" href="javascript:void(0)" onclick="periodInfoFn(${row.id})" data-id="period_id${row.id}" id="period_id${row.id}" title="Open period information page"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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

        function editPeriodFn(recordId) {
            resetPeriodFormFn();
            $.ajax({
                type: "get",
                url: "{{url('showperiod')}}"+'/'+recordId,
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
                    $.each(data.periodlist, function(key, value) {
                        $('#periodId').val(value.id);
                        $('#PeriodName').val(value.PeriodName);
                        $('#Description').val(value.Description);
                        $('#status').val(value.Status).select2({minimumResultsForSearch: -1});
                    });
                    m = 0;
                    var i = 0;
                    $.each(data.detdata, function(key, value) {
                        ++m;
                        ++i;
                        var days = value.Days;
                        $("#dynamicTable > tbody").append(`<tr id="rowind${m}">
                            <td style="font-weight:bold;width:3%;border: 1px solid #d8d6de;text-align:center;">${m}</td>
                            <td style="display:none;border: 1px solid #d8d6de;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td style="display:none;border: 1px solid #d8d6de;"><input type="hidden" name="row[${m}][Days]" id="Days${m}" class="Days form-control" readonly="true" style="font-weight:bold;" value="${value.Days}"/></td>
                            <td style="width:12%;border: 1px solid #d8d6de;text-align:center;">${value.Days}</td>
                            <td style="width:14%;border: 1px solid #d8d6de;"><input type="text" class="FirstHalfFrom form-control" placeholder="HH:MM" name="row[${m}][FirstHalfFrom]" id="fromfir${m}" onkeyup="firstfromfn(${m})" value="${value.FirstHalfFrom}"></td>
                            <td style="width:14%;border: 1px solid #d8d6de;"><input type="text" class="FirstHalfTo form-control" placeholder="HH:MM" name="row[${m}][FirstHalfTo]" id="tofir${m}" onkeyup="firsttofn(${m})" value="${value.FirstHalfTo}"></td>
                            <td style="width:14%;border: 1px solid #d8d6de;"><input type="text" class="SecondHalfFrom form-control" placeholder="HH:MM" name="row[${m}][SecondHalfFrom]" id="fromsec${m}" onkeyup="secondfromfn(${m})" value="${value.SecondHalfFrom}"></td>
                            <td style="width:14%;border: 1px solid #d8d6de;"><input type="text" class="SecondHalfTo form-control" placeholder="HH:MM" name="row[${m}][SecondHalfTo]" id="tosec${m}" onkeyup="secondtofn(${m})" value="${value.SecondHalfTo}"></td>
                            <td style="width:19%;border: 1px solid #d8d6de;"><input type="text" name="row[${m}][Remark]" id="Remark${m}" class="Remark form-control" placeholder="Remark..." value="${value.Remark}"/></td>
                            <td style="width:13%;border: 1px solid #d8d6de;"><select id="Status${m}" class="select2 form-control form-control Statusdet" name="row[${m}][Statusval]" onchange="statusch(this)"></select></td>
                        </tr>`);
                        var indx = $(`#vals${m}`).val();

                        var fromfr = $(`#fromfir${m}`).val();

                        $(`#fromfir${m}`).timepicker({
                            timeFormat: 'HH:mm',
                            interval: 30,
                            minTime: '00:00',
                            maxTime: '11:59',
                            scrollbar: true,
                            disableTimeRanges:['12:00','23:59'],
                            zindex: 9999999,
                            change: function() {
                                var indx = $(`#vals${m}`).val();
                                firstfromfn(indx);
                            }
                        });
                        $(`#tofir${m}`).timepicker({
                            timeFormat: 'HH:mm',
                            interval: 30,
                            minTime: '00:00',
                            maxTime: '12:59',
                            scrollbar: true,
                            disableTimeRanges:  ['13:00', '23:59'],
                            zindex: 9999999,
                            change: function() {
                                var indx = $(`#vals${m}`).val();
                                firsttofn(indx);
                            }
                        });
                        $(`#fromsec${m}`).timepicker({
                            timeFormat: 'HH:mm',
                            interval: 30,
                            minTime: '13:00',
                            maxTime: '23:59',
                            scrollbar: true,
                            disableTimeRanges:  ['01:00', '12:59'],
                            zindex: 9999999,
                            change: function() {
                                var indx = $(`#vals${m}`).val();
                                secondfromfn(indx);
                            }
                        });
                        $(`#tosec${m}`).timepicker({
                            timeFormat: 'HH:mm',
                            interval: 30,
                            minTime: '13:00',
                            maxTime: '23:59',
                            scrollbar: true,
                            disableTimeRanges:  ['01:00', '12:59'],
                            zindex: 9999999,
                            change: function() {
                                var indx = $(`#vals${m}`).val();
                                secondtofn(indx);
                            }
                        });
                        var statusdefopt = `<option selected value="${value.Status}">${value.Status}</option>`;
                        var statusopt = '<option value="Active">Active</option><option value="Inactive">Inactive</option>';
                        $(`#Status${m}`).append(statusopt);
                        $(`#Status${m} option[value="${value.Status}"]`).remove(); 
                        $(`#Status${m}`).append(statusdefopt).select2({minimumResultsForSearch: -1});
                    });

                    $('#status').select2({minimumResultsForSearch: -1});
                    $('#operationtypes').val(2);
                    $('#periodtitlelbl').html('Edit Period');
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled",false);
                    $("#inlineForm").modal('show');
                },
            }); 
        }

        function periodInfoFn(recordId){
            createPeriodInfoFn(recordId);
            $("#periodinformationmodal").modal('show');
        }

        function createPeriodInfoFn(recordId){
            var action_log = "";
            var lidata = "";
            var action_links = "";
            $(".infoPeriodDiv").hide();
            $.ajax({
                type: "get",
                url: "{{url('showperiod')}}"+'/'+recordId,
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
                    fetchPeriodDataFn(recordId);   
                },
                success: function (data) {
                    $.each(data.periodlist, function(key, value) {
                        $('#periodnamelbl').html(value.PeriodName);
                        $('#descriptionlbl').html(value.Description);
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
                            <a class="dropdown-item viewPeriodAction" onclick="viewPeriodFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Period-Edit")
                        <li>
                            <a class="dropdown-item periodEdit" onclick="editPeriodFn(${recordId})" data-id="editlinkbtn${recordId}" id="editlinkbtn${recordId}" title="Open period edit form">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Period-Delete")
                        <li>
                            <a class="dropdown-item periodDelete" onclick="deletePeriodFn(${recordId})" data-id="deletelinkbtn${recordId}" id="deletelinkbtn${recordId}" title="Open period delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan`;

                    $("#period_action_ul").empty().append(action_links);
                },
            }); 

            $(".infoscl").collapse('show'); 
        }

        function viewPeriodFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function fetchPeriodDataFn(recordId){
            $(".infoPeriodDiv").hide();
            $('#perioddetaltbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                info: false,
                paging: false,
                autoWidth: false,
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
                    url: '/perioddetaillist/'+recordId,
                    type: 'DELETE',
                    dataType: "json",
                },
                columns: [
                    { data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'Days',
                        name: 'Days',
                        width:"15%"
                    },
                    {
                        data: 'FirstHalfFrom',
                        name: 'FirstHalfFrom',
                        width:"13%"
                    },
                    {
                        data: 'FirstHalfTo',
                        name: 'FirstHalfTo',
                        width:"13%"
                    },
                    {
                        data: 'SecondHalfFrom',
                        name: 'SecondHalfFrom',
                        width:"13%"
                    },
                    {
                        data: 'SecondHalfTo',
                        name: 'SecondHalfTo',
                        width:"13%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
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
                    $('#period_div').show();
                },
            });
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.period_header_info');
            const collapseId = collapse.attr('id');
            const trigger = $(`[data-target="#${collapseId}"], [data-bs-target="#${collapseId}"]`);

            const isOpening = e.type === 'show';

            $('.toggle-text-label').html(isOpening ? 'Collapse' : 'Expand');
            $('.collapse-icon').html(isOpening ? '<i class="fas text-secondary fa-minus-circle"></i>' : '<i class="fas text-secondary fa-plus-circle"></i>');

            if (isOpening) {
                const originalHeader = `<i class="far fa-info-circle"></i> Basic Information`;
                infoTarget.html(originalHeader);
            } 
            else {
                // Section is COLLAPSING: Show the data summary
                const period_name = container.find('#periodnamelbl').text().trim();
                const period_status = container.find('#statuslbl').text().trim();
                const summaryPeriod = `
                    Period Name: <b>${period_name}</b>,
                    Status: <b style="color: ${period_status == "Active" ? "#28c76f" : "#ea5455"}">${period_status}</b>`;

                infoTarget.html(summaryPeriod);
            }
        });

        $('#savebutton').click(function(){
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var optype = $("#operationtypes").val();
            $.ajax({
                url:'/saveperiod',
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
                    if(parseFloat(optype) == 1){
                        $('#savebutton').text('Saving...');
                        $('#savebutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype) == 2){
                        $('#savebutton').text('Updating...');
                        $('#savebutton').prop("disabled", false);
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
                        if(data.errors.PeriodName){
                            $('#name-error').html( data.errors.PeriodName[0]);
                        }
                        if(data.errors.Description){
                            $('#description-error').html( data.errors.Description[0]);
                        }
                        if(data.errors.status){
                            $('#status-error').html( data.errors.status[0]);
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
                    else if (data.errorv2 || data.activeerror) {
                        for(var k = 1;k <= 8;k++){
                            var fromfirst = $(`#fromfir${k}`).val();
                            var tofirst = $(`#tofir${k}`).val();
                            var fromsecond = $(`#fromsec${k}`).val();
                            var tosecond = $(`#tosec${k}`).val();
                            var status = $(`#Status${k}`).val();
                            
                            if(($(`#fromfir${k}`).val()) != undefined){
                                if((fromfirst == "" || fromfirst == null) && status == "Active"){
                                    $(`#fromfir${k}`).css("background", errorcolor);
                                }
                                if(fromfirst > tofirst){
                                    $(`#fromfir${k}`).css("background", errorcolor);
                                }
                            }
                            if(($(`#tofir${k}`).val()) != undefined){
                                if((tofirst == "" || tofirst == null) && status == "Active"){
                                    $(`#tofir${k}`).css("background", errorcolor);
                                }
                                if(tofirst < fromfirst){
                                    $(`#tofir${k}`).css("background", errorcolor);
                                }
                            }
                            if(($(`#fromsec${k}`).val()) != undefined){
                                if((fromsecond == "" || fromsecond == null) && status == "Active"){
                                    $(`#fromsec${k}`).css("background", errorcolor);
                                }
                                if(fromsecond > tosecond){
                                    $(`#fromsec${k}`).css("background", errorcolor);
                                }
                            }
                            if(($(`#tosec${k}`).val()) != undefined){
                                if((tosecond == "" || tosecond == null) && status == "Active"){
                                    $(`#tosec${k}`).css("background", errorcolor);
                                }
                                if(tosecond < fromsecond){
                                    $(`#tosec${k}`).css("background", errorcolor);
                                }
                            }
                        }
                        if(parseFloat(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
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
                    else if(data.success) {
                        if(parseFloat(optype) == 2){
                            createPeriodInfoFn(data.rec_id);
                        }
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                },
            });
        });

        function deletePeriodFn(recordId){
            var period_cnt = null;
            $.ajax({
                type: "get",
                url: "{{url('showperiod')}}"+'/'+recordId,
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
                    period_cnt = data.periodcnt;
                    if(parseInt(period_cnt) > 0){
                        toastrMessage('error',"This record cannot be deleted because it is currently linked to other entries.","Error");
                    }
                    else{
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
                                $("#periodDelId").val(recordId);
                                periodDeleteFn(recordId);
                            }
                            else if (result.dismiss === Swal.DismissReason.cancel) {}
                        });
                    }
                }
            });
        }

        function periodDeleteFn(recordId){
            var delform = $("#periodinformationform");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteperiod',
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
                        message:'',
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
                        toastrMessage('error',"Unable to delete period, service is saved with this payment term","Error");
                    }
                    else if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                        $("#periodinformationmodal").modal('hide');
                    }
                }
            });
        }

        function statusch(ele) {
            var rowid = $(ele).closest('tr').find('.vals').val();
            $('#fromfir'+rowid).css("background", "#FFFFFF");
            $('#tofir'+rowid).css("background", "#FFFFFF");
            $('#fromsec'+rowid).css("background", "#FFFFFF");
            $('#tosec'+rowid).css("background", "#FFFFFF");
        }

        function firstfromfn(indx) {
            var fromfirst=($('#fromfir'+indx)).val();
            var tofirst=($('#tofir'+indx)).val();
            var fromsecond=($('#fromsec'+indx)).val();
            var tosecond=($('#tosec'+indx)).val();
            if((fromfirst>=tofirst) && fromfirst!="" && tofirst!=""){
                $('#fromfir'+indx).val("");
                $('#fromfir'+indx).css("background", errorcolor);
                toastrMessage('error',"From field is greater than or equal To field","Error");
            }
            if(fromfirst<tofirst){
                $('#fromfir'+indx).css("background", "#FFFFFF");
                if(fromsecond=="" && tosecond==""){
                    $('#fromsec'+indx).css("background", "#FFFFFF");
                    $('#tosec'+indx).css("background", "#FFFFFF");
                }
            }
            if(tofirst==""){
                $('#fromfir'+indx).css("background", "#FFFFFF");
            }
        }

        function firsttofn(indx) {
            var fromfirst=($('#fromfir'+indx)).val();
            var tofirst=($('#tofir'+indx)).val();
            var fromsecond=($('#fromsec'+indx)).val();
            var tosecond=($('#tosec'+indx)).val();
            if((fromfirst>=tofirst) && fromfirst!="" && tofirst!=""){
                $('#tofir'+indx).val("");
                $('#tofir'+indx).css("background", errorcolor);
                toastrMessage('error',"To field is less than or equal From field","Error");
            } 
            if(fromfirst<tofirst){
                $('#tofir'+indx).css("background", "#FFFFFF");
                if(fromsecond=="" && tosecond==""){
                    $('#fromsec'+indx).css("background", "#FFFFFF");
                    $('#tosec'+indx).css("background", "#FFFFFF");
                }
            }
            if(fromfirst==""){
                $('#tofir'+indx).css("background", "#FFFFFF");
            }  
        }

        function secondfromfn(indx) {
            var fromfirst=($('#fromfir'+indx)).val();
            var tofirst=($('#tofir'+indx)).val();
            var fromsecond=($('#fromsec'+indx)).val();
            var tosecond=($('#tosec'+indx)).val();
            if((fromsecond>=tosecond) && fromsecond!="" && tosecond!=""){
                $('#fromsec'+indx).val("");
                $('#fromsec'+indx).css("background", errorcolor);
                toastrMessage('error',"From field is greater than or equal To field","Error");
            }
            if(fromsecond<tosecond){
                $('#fromsec'+indx).css("background", "#FFFFFF");
                if(fromfirst=="" && tofirst==""){
                    $('#fromfir'+indx).css("background", "#FFFFFF");
                    $('#tofir'+indx).css("background", "#FFFFFF");
                }
            }
            if(tosecond==""){
                $('#fromsec'+indx).css("background", "#FFFFFF");
            }
        }

        function secondtofn(indx) {
            var fromfirst=($('#fromfir'+indx)).val();
            var tofirst=($('#tofir'+indx)).val();
            var fromsecond=($('#fromsec'+indx)).val();
            var tosecond=($('#tosec'+indx)).val();
            if((fromsecond>=tosecond) && fromsecond!="" && tosecond!=""){
                $('#tosec'+indx).val("");
                $('#tosec'+indx).css("background", errorcolor);
                toastrMessage('error',"To field is less than or equal From field","Error");
            } 
            if(fromsecond<tosecond){
                $('#tosec'+indx).css("background", "#FFFFFF");
                if(fromfirst=="" && tofirst==""){
                    $('#fromfir'+indx).css("background", "#FFFFFF");
                    $('#tofir'+indx).css("background", "#FFFFFF");
                }
            }
            if(fromsecond==""){
                $('#tosec'+indx).css("background", "#FFFFFF");
            } 
        }

        function resetPeriodFormFn(){
            var i = 0;
            $('.reg_form').val("");
            $('#status').val("Active").select2({
                dropdownParent: $('#inlineForm'),
                minimumResultsForSearch: -1
            });
            $('#operationtypes').val(1);
            $('#dynamicTable > tbody').empty();
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $('.errordatalabel').html('');
            $("#periodtitlelbl").html("Add Period");
        }

        function periodnamefn() {
            $('#name-error').html("");
        }

        function descriptionfn() {
            $('#description-error').html("");
        }

        function paymenttermstatusfn() {
            $('#status-error').html("");
        }

        function refreshPeriodDataFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }

    </script>
@endsection
