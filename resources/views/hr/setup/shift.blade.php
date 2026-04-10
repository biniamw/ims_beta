@extends('layout.app1')

@section('title')
@endsection

@section('content')
    @can('Shift-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom fit-content mb-0 pb-0">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                            <h3 class="card-title form_title">Shift</h3>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshShiftDataFn()"><i class="fas fa-sync-alt"></i></button>
                                            @if (auth()->user()->can('Shift-Add'))
                                            <button type="button" class="btn btn-gradient-info btn-sm addshift header-prop" id="addshift"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                            @endcan 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-datatable">
                                <div style="width:99%; margin-left:0.5%;display:none;" id="main-datatable" class="fit-content">
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width:3%;">#</th>
                                                <th style="width:24%;">Shift Name</th>
                                                <th style="width:23%;">Cycle Number</th>
                                                <th style="width:23%;">Cycle Unit</th>
                                                <th style="width:23%;">Status</th>
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

    <div class="modal fade text-left fit-content" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="periodtitleinfolbl" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Shift Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statuslbl1"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="informationform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoshift" aria-expanded="true">
                                            <h5 class="mb-0 form_title shift_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                            <div class="d-flex align-items-center header-tab">
                                                <span class="text-uppercase font-weight-bold mr-50 toggle-text-label tab-text">Collapse</span>
                                                <div class="collapse-icon">
                                                    <i class="fas text-secondary fa-minus-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse show infoshift shadow pl-1 pr-1">
                                            <div class="row mb-1">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 mb-1">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Shift Name</label></td>
                                                                    <td><label class="info_lbl" id="shiftnamelbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Cycle Number</label></td>
                                                                    <td><label class="info_lbl" id="cyclenumberlbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Cycle Unit</label></td>
                                                                    <td><label class="info_lbl" id="cycleunitlbl" style="font-weight: bold;"></label></td>
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 infoAccDiv table-responsive scroll scrdiv" id="timetableDiv" style="overflow-y:auto;max-height:50vh;">
                                    <table id="timetableinfotbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">#</th>
                                                <th style="width:25%;">Days</th>
                                                <th style="width:70%;">Timetable(s)</th>
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
                                        <ul class="dropdown-menu" id="shift_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="delId" id="delId" readonly="true">
                                    <button id="closebuttoninfo" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="modaltitle">Add Shift</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Shift Name<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" placeholder="Shift Name" class="form-control reg_form" name="ShiftName" id="ShiftName" onkeyup="shiftnamefn()"/>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="name-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Cycle Number<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control" name="CycleNumber" id="CycleNumber" onchange="cycleNumFn()">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="cyclenum-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Cycle Unit<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control" name="CycleUnit" id="CycleUnit" onchange="cycleUnitFn()">
                                    <option value="1">Day</option>
                                    <option value="2">Month</option>
                                    <option value="3">Week</option>
                                </select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="cycleunit-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Description</label>
                                <textarea type="text" placeholder="Write Description here..." class="form-control reg_form" rows="1" name="Description" id="Description" onkeyup="descriptionfn()"></textarea>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="description-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Status<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control" name="status" id="status" onchange="statusfn()">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="status-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: right;">
                                <button id="assigntime" type="button" class="btn btn-gradient-success btn-sm assigntime"><i class="fa fa-plus" aria-hidden="true"></i>  Assign Time</button></br>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="assignbtn-error"></strong>
                                </span>
                            </div>
                        </div>
                        <hr class="my-30">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 scrdivhor scrollhor" style="width: 100%;overflow-y:auto;max-height:50vh;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                <div class="table-responsive" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                    <span class="text-danger">
                                        <strong id="blanktable-error"></strong>
                                    </span></br>
                                    <table id="timetableassign" class="mb-0 rtable fit-content" style="width: 100%;min-width: 600px;">
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">#</th>
                                                <th style="width:20%;">Days</th>
                                                <th style="width:75%">Timetable(s)</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

                                    <table id="schtimetable" class="mb-0 rtable" style="width:100%;display:none;">  
                                        <thead>
                                            <tr>
                                                <th rowspan="3" style="width:3%;">#</th>
                                                <th rowspan="3" style="width:7%;">Days</th>
                                                <th colspan="288" style="width:90%;">Times</th>
                                            </tr>
                                            <tr>
                                                <th colspan="144" style="width:45%;">AM</th>
                                                <th colspan="144" style="width:45%;">PM</th>
                                            </tr>
                                            <tr>
                                                <th colspan="12" style="text-align: center;width:3.75%;">00</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">01</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">02</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">03</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">04</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">05</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">06</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">07</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">08</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">09</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">10</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">11</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">12</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">13</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">14</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">15</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">16</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">17</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">18</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">19</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">20</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">21</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">22</th>
                                                <th colspan="12" style="text-align: center;width:3.75%;">23</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1" style="display: none;">
                                <label style="font-size: 14px;">Begininng Date<b style="color:red;">*</b></label>
                                <input type="text" id="BegininngDate" name="BegininngDate" class="form-control reg_form" placeholder="YYYY-MM-DD" onchange="begDateFn()"/>
                                <span class="text-danger">
                                    <strong id="beginningdate-error"></strong>
                                </span>
                            </div>
                            <select class="select2 form-control" name="TimetableDefault" id="TimetableDefault">
                                <option selected disabled></option>
                                @foreach ($timetblist as $timetbl)
                                <option data-color="{{$timetbl->TimetableColor}}" title="{{$timetbl->NameWithTime}}" value="{{$timetbl->id}}">{{$timetbl->NameWithTime}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" class="form-control reg_form" name="selectedLength" id="selectedLength" readonly="true" value="0"/>
                            <input type="hidden" class="form-control reg_form" name="ShiftEditFlag" id="ShiftEditFlag" readonly="true" value="0"/>  
                            <input type="hidden" class="form-control reg_form" name="checkFlag" id="checkFlag" readonly="true" value=""/>   
                            <input type="hidden" class="form-control reg_form" name="recId" id="recId" readonly="true" value=""/>     
                            <input type="hidden" class="form-control reg_form" name="operationtypes" id="operationtypes" readonly="true"/>
                        </div>
                        @can('Shift-Add')
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        @endcan
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Start Time assignment Modal -->
    <div class="modal fade text-left fit-content" id="timeassmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Time Assignment</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="AssignmentForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                <div class="divider">
                                    <div class="divider-text">Timetables</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <span class="text-danger">
                                            <strong id="timetable-error"></strong>
                                        </span>
                                        @foreach ($timetblist as $data)
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input timetable" id="timetable{{ $data->id }}" name="timetable[]" value="{{ $data->id }}"/>
                                            <label class="custom-control-label" for="timetable{{ $data->id }}">{{ $data->TimetableName }} ({{ $data->BeginningIn }}-{{ $data->EndingOut }}     |     {{ $data->OnDutyTime }}-{{ $data->OffDutyTime }})</label>                                                
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="divider">
                                    <div class="divider-text">Shift Detail</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <span class="text-danger">
                                            <strong id="shiftdetail-error"></strong>
                                        </span>
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input selectallcbx" id="selectallcbx" name="selectallcbx[]"/>
                                            <label class="custom-control-label" for="selectallcbx" style="font-weight: bold;">Select All</label>                                                
                                        </div>
                                        <div id="shiftdetaildivs" class="scrollhor" style="width: 100%;overflow-y: scroll;height:30rem;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="assigntoshiftandnew" type="button" class="btn btn-info form_btn assignbtn">Assign & New</button>
                        <button id="assigntoshiftandclose" type="button" class="btn btn-info form_btn assignbtn">Assign & Close</button>
                        <button id="closebuttonj" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Time assignment Modal -->

    @include('layout.universal-component')

    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var endtimeval = "23:59";
        var minuteinc = 30;
        var flagdata = 0;
        var oldcyclenum = 0;
        var totalvaiance = 0;
        var days = [];
        var startdatearr = [];
        var enddatearr = [];
        var rowinfodata = {};
        var rowallinfodata = {};
        var rowrepoinfodata = {};
        var timetableobj = {};
        var timetablealldata = {};
        var saveobjectdata = {};
        var cycleChangeFlg = 0;
        var timetableoverlap = [];
        var inptime = {0:{name:'.',stime:'00:00',etime:'00:00',duration:'0',color:'#000000'}};
        rowinfodata = {startime:'00:00',endtimes:'00:00'};
        //rowallinfodata[0]={rowinfodata};
        var copiedval = {};
        var colorMap = {};
        $(function () {
            cardSection = $('#page-block');
        });
        var globalIndex = -1;

        var j = 0;
        var i = 0;
        var m = 0;
        
        $('body').on('click', '#addshift', function() {
            resetShiftFormFn();
            $("#inlineForm").modal('show');
        });

        $(document).ready(function () {
            $('#BegininngDate').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('#BegininngDate').val("");
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
                    url: '/shiftlist',
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
                    { data: 'id', name: 'id','visible':false},
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'ShiftName', name: 'ShiftName',width:"24%"},
                    { data: 'CycleNumber', name: 'CycleNumber',width:"23%"},
                    { data: 'CycleUnitName', name: 'CycleUnitName',width:"23%"},
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
                        width:"23%"
                    },
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="shiftInfo" href="javascript:void(0)" onclick="shiftInfoFn(${row.id})" data-id="shift_id${row.id}" id="shift_id${row.id}" title="Open shift information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });

            $.get("/timetablelists" , function(data) {
                $.each(data.timetbl, function(key, value) {
                    timetableobj[value.id]={
                        name:value.TimetableName,
                        stime:value.BeginningIn,
                        etime:value.EndingOut,
                        dstime:value.OnDutyTime,
                        detime:value.OffDutyTime,
                        duration:value.WorkTime,
                        color:value.TimetableColor,
                        breakstime:value.BreakStartTimes,
                        breaketime:value.BreakEndTimes,
                        breakhr:value.BreakHours
                    };

                    let timetabledata={
                        id: value.id,
                        name:value.TimetableName,
                        OnDuty:value.OnDutyTime,
                        OffDuty:value.OffDutyTime,
                    };
                    timetableoverlap.push(timetabledata);
                });   
            });

            $.get("/timetablealllists" , function(data) {
                $.each(data.timetbl, function(key, value) {
                    timetablealldata[value.id]={
                        name:value.TimetableName,
                        stime:value.OnDutyTime,
                        etime:value.OffDutyTime,
                        duration:value.WorkTime,
                        color:value.TimetableColor,
                        keyid:value.id,
                        collname:value.TimetableName+" ("+value.OnDutyTime+"-"+value.OffDutyTime+")",
                    };
                });   
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

        $('#selectallcbx').change(function() {
            if($(this).is(":checked")) {
                $('.shiftdetails').prop('checked', true); 
                $(".flagvalue").val(1);
            }
            else{
                $('.shiftdetails').prop('checked', false);
                $(".flagvalue").val(0);
            }
            $('#shiftdetail-error').html("");
        });
        
        $('.timetable').click(function(){  
            if($(this).is(":checked")) {
                let selectedIds=[];

                $('.timetable:checked').each(function() {
                    selectedIds.push(Number($(this).val()));
                });

                let selectedNumIds = selectedIds.map(str => parseInt(str));

                let result = checkTimetableOverlaps(timetableoverlap,selectedNumIds,0);

                if(result == "Duplicate" || result == "Overlap"){
                    $(`#timetable${$(this).val()}`).prop('checked', false); 
                }
            }
            $('#timetable-error').html("");
        });

        function appendTimetable(flg){
            m=0;
            if(parseInt(flg)==1){
                if(parseInt(totalvaiance)==0){
                    $("#timetableassign > tbody").empty();
                    var rowdata="<tr>";
                    $.each(days, function(m,day) {
                        ++m;
                        if(parseInt(m)<=9){
                            m="0"+m;
                        }
                        rowdata+=`<td style='text-align:center;font-weight:bold;width:3%;'>${m}</td>
                            <td style='display:none;'><input type='hidden' id='flagvalue${m}' class='flagvalue form-control' readonly='true' value='0'/></td>
                            <td style='display:none;'><label id='rowobjectval${m}'></label></td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td id='days_${m}' style='text-align:center;font-weight:bold;width:7%;'>${day}</td>`;
                        rowdata+=`<td style='width:80;' id="${m}">
                                <select class="select2 form-control timetablecls" id="timetables${m}" name="timetables${m}[]" onchange="timeTableFn(this)"></select>
                            </td>`;
                        rowdata+="</tr>";
                    });
                    $("#timetableassign > tbody").append(rowdata);
                }
                else if(parseInt(totalvaiance)<0){
                    totalvaiance=parseInt(totalvaiance)*parseInt(-1);
                    var lastrow=$('#timetableassign > tbody > tr:last td:eq(0)').text(); 
                    var numofrow=parseInt(lastrow)-parseInt(totalvaiance);
                    
                    for(var rem=lastrow;rem>numofrow;rem--){
                        $('#timetableassign > tbody > tr:last').remove(); 
                    }
                }
                else if(parseInt(totalvaiance)>0){
                    totalvaiance=parseInt(totalvaiance)*parseInt(1);
                    var lastrow=$('#timetableassign > tbody > tr:last td:eq(0)').text(); 
                    var numofrow=parseInt(lastrow)-parseInt(totalvaiance);
                    
                    var rowdata="<tr>";
                    $.each(days, function(m,day) {
                        ++m;
                        if(parseInt(m)>parseInt(lastrow)){
                            if(parseInt(m)<=9){
                                m="0"+m;
                            }
                            rowdata+=`<td style='text-align:center;font-weight:bold;width:3%;'>${m}</td>
                                <td style='display:none;'><input type='hidden' id='flagvalue${m}' class='flagvalue form-control' readonly='true' value='0'/></td>
                                <td style='display:none;'><label id='rowobjectval${m}'></label></td>
                                <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                                <td id='days_${m}' style='text-align:center;font-weight:bold;width:7%;'>${day}</td>`;
                            rowdata+=`<td style='width:80;' id="${m}">
                                    <select class="select2 form-control timetablecls" id="timetables${m}" name="timetables${m}[]" onchange="timeTableFn(this)"></select>
                                </td>`;
                            rowdata+="</tr>";
                        }
                    });
                    $("#timetableassign > tbody").append(rowdata);
                }
            }

            else if(parseInt(flg)==2){
                $("#timetableassign > tbody").empty();
                var rowdata="<tr>";
                $.each(days, function(m,day) {
                    
                    ++m;
                    if(parseInt(m)<=9){
                        m="0"+m;
                    }
                    rowdata+=`<td style='text-align:center;font-weight:bold;width:3%;'>${m}</td>
                        <td style='display:none;'><input type='hidden' id='flagvalue${m}' class='flagvalue form-control' readonly='true' value='0'/></td>
                        <td style='display:none;'><label id='rowobjectval${m}'></label></td>
                        <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                        <td id='days_${m}' style='text-align:center;font-weight:bold;width:7%;'>${day}</td>`;
                    rowdata+=`<td style='width:80;' id="${m}">
                            <select class="select2 form-control timetablecls" id="timetables${m}" name="timetables${m}[]" onchange="timeTableFn(this)"></select>
                        </td>`;
                    rowdata+="</tr>";
                });
                $("#timetableassign > tbody").append(rowdata);
            }
        }

        $('.assigntime').click(function(){
            var cycleunit=$('#CycleUnit').val()||0;
            var cyclenumber=$('#CycleNumber').val()||0;
            if(parseInt(cycleunit)==0 || parseInt(cyclenumber)==0){
                if(parseInt(cycleunit)==0){
                    $('#cycleunit-error').html("The cycle unit field is required.");
                }
                if(parseInt(cyclenumber)==0){
                    $('#cyclenum-error').html("The cycle number field is required.");
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else if(parseInt(cycleunit)>0 && parseInt(cyclenumber)>0){
                $("#shiftdetaildivs").empty();
                $('.timetable').prop('checked', false); // Unchecks it
                $('#selectallcbx').prop('indeterminate', false); 
                $('#selectallcbx').prop('checked', false); // Unchecks it
                $(".flagvalue").val(0);
                $.each(days, function(m,day) {
                    ++m;
                    if(parseInt(m)<=9){
                        m="0"+m;
                    }
                    $("#shiftdetaildivs").append('<div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input shiftdetails" id="shiftdetails'+m+'" name="shiftdetails[]" value="'+m+'"/><label class="custom-control-label" for="shiftdetails'+m+'">'+m+'-'+day+'</label></div>');
                });
                inptime={};
                inptime={0:{name:'.',stime:'00:00',etime:'00:00',duration:'0',color:'#000000'}};
                $("#timeassmodal").modal('show');
            }
        });

        $('.assignbtn').click(function(){
            var errorflags=0;
            var timetablenamearr=[];
            var rowindexarr=[];
            var dayindexarr=[];
            var shiftdetaillen=$('.shiftdetails:checked').length;
            var timetablelen=$('.timetable:checked').length;
            if(parseInt(shiftdetaillen)==0 || parseInt(timetablelen)==0){
                if(parseInt(timetablelen)==0){
                    $('#timetable-error').html("at-least one timetable is required.");
                }
                if(parseInt(shiftdetaillen)==0){
                    $('#shiftdetail-error').html("at-least one shift is required.");
                }
                toastrMessage('error',"Please check required boxes","Error");
            }
            else if(parseInt(shiftdetaillen)>0 && parseInt(timetablelen)>0){
                if(parseInt(cycleChangeFlg) == 1){
                    cycleUnitOrdering(1);
                }
                
                $('.shiftdetails:checked').each(function() {
                    let x = $(this).val();

                    $('#timetableassign > tbody > tr').each(function(index, tr) { 
                        var ind = ++index;
                        ind = parseInt(ind) <= 9 ? `0${ind}` : ind;
                       
                         
                        if(parseInt(x) == parseInt(ind)){
                            let selectedIds=[];

                            $(`#timetables${ind} option:selected`).each(function() {
                                selectedIds.push($(this).val() || 0); // Push selected values into array
                            });
                            $('.timetable:checked').each(function() {
                                selectedIds.push(Number($(this).val()));
                            });
                            let selectedNumIds = selectedIds.map(str => parseInt(str));
                            let result = checkTimetableOverlaps(timetableoverlap, selectedNumIds,ind);

                            if(result === "Not-Overlap"){
                                let timetbleid = $(`#timetables${ind}`).val();
                                $(`#timetables${ind}`).select2({multiple: true})
                                let timetableData = $("#TimetableDefault > option").clone();
                                if(timetbleid != null){
                                    $(`#timetables${ind}`).empty();
                                    $(`#timetables${ind}`).append(timetableData);
                                    $(`#timetables${ind}`).val(selectedIds);
                                    $(`#timetables${ind}`).select2({
                                        allowClear:false,
                                        tags: true,
                                        templateResult: formatOption,
                                        templateSelection: formatSelectedOpt
                                    });
                                }
                                else if(timetbleid == null){
                                    $(`#timetables${ind}`).empty();
                                    $(`#timetables${ind}`).append(timetableData);
                                    $(`#timetables${ind}`).val(selectedIds);
                                    $(`#timetables${ind}`).select2({
                                        allowClear:false,
                                        tags: true,
                                        templateResult: formatOption,
                                        templateSelection: formatSelectedOpt
                                    });
                                }
                            }
                        }
                    });
                });

                rowallinfodata=$.extend(true, {}, rowrepoinfodata);
                flagdata=1;
                cycleChangeFlg=0;
                $("#checkFlag").val('1');
                $("#assignbtn-error").html("");
                $("#blanktable-error").html("");
                if(parseInt(errorflags)>=1){
                    toastrMessage('error',timetablenamearr,"Error");
                }
                if($(this).attr('id') == "assigntoshiftandclose"){
                    $("#timeassmodal").modal('hide');
                }
                else if($(this).attr('id') == "assigntoshiftandnew"){
                    $("#shiftdetaildivs").empty();
                    $('.timetable').prop('checked', false); // Unchecks it
                    $('#selectallcbx').prop('indeterminate', false); 
                    $('#selectallcbx').prop('checked', false); // Unchecks it
                    $(".flagvalue").val(0);
                    $.each(days, function(m,day) {
                        ++m;
                        if(parseInt(m)<=9){
                            m="0"+m;
                        }
                        $("#shiftdetaildivs").append('<div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input shiftdetails" id="shiftdetails'+m+'" name="shiftdetails[]" value="'+m+'"/><label class="custom-control-label" for="shiftdetails'+m+'">'+day+'</label></div>');
                    });
                    inptime={};
                    inptime={0:{name:'.',stime:'00:00',etime:'00:00',duration:'0',color:'#000000'}};
                }     
            }       
        });

        function formatOption(option,container) {
            if (!option.id) return option.text; // Default text

            return $(`<span style="color:${$(option.element).data('color')};font-weight:bold;">${option.text}</span>`);
        }

        function formatSelectedOpt(option,container) {
            if (!option.id) return option.text; // Default text

            $(container).attr('style', function(i, style) {
                return (style || '') +
                    `background-color: ${$(option.element).data('color')} !important;
                    color: #FFFFFF !important; 
                    border-color: ${$(option.element).data('color')} !important;
                    font-weight: bold !important;`
            });
            return option.text;  
        }

        function checkTimetableOverlaps(timetables, selectedIds,rowInd) {
            let selectedTimetables = [];
            let idCount = {};
            let duplicateDetails = [];

            selectedIds.forEach(id => {
                let timetable = timetables.find(t => t.id === id);
                if (timetable) {
                    selectedTimetables.push(timetable);
                    idCount[id] = (idCount[id] || 0) + 1;

                    if (idCount[id] === 2) {
                        duplicateDetails.push(timetable.name);
                    }
                }
            });

            let duplicateIds = Object.keys(idCount).filter(id => idCount[id] > 1);
            if (duplicateIds.length > 0) {
                toastrMessage('error',`Duplicate timetable found:<b> ${duplicateDetails.join(", ")}</b>`,"Error");
                return "Duplicate";
            }

            // Check for overlap in the selected timetables
            for (let i = 0; i < selectedTimetables.length; i++) {
                for (let j = i + 1; j < selectedTimetables.length; j++) {
                    
                    let t1 = selectedTimetables[i];
                    let t2 = selectedTimetables[j];
                    // Check if OnDuty-OffDuty of one overlaps with another
                    if ((t1.OnDuty < t2.OffDuty && t1.OffDuty > t2.OnDuty) ||
                        (t2.OnDuty < t1.OffDuty && t2.OffDuty > t1.OnDuty)) {
                        toastrMessage('error',`Timetable <b>${t1.name}</b> & <b>${t2.name}</b> overlaped at row <b>${rowInd}</b>`,"Error");
                        return "Overlap";
                    }
                }
            }
            return "Not-Overlap";
        }

        // Function to dynamically change the background color
        function timeTableFn(ele){
            var rownum = $(ele).closest('tr').find('.vals').val();
            let selectedId=[];
            var previousValues = [];
            $(`#timetables${rownum} option:selected`).each(function() {
                selectedId.push($(this).val() || 0); // Push selected values into array
            });

            let numberArray = selectedId.map(str => parseInt(str));

            let result = checkTimetableOverlaps(timetableoverlap,numberArray,rownum);

            $(`#timetables${rownum}`).off('select2:select');

            if(result == "Duplicate" || result == "Overlap"){
                $(`#timetables${rownum}`).on('select2:select', function (e) {
                    var selectedValue = e.params.data.id;  // Get the clicked value
                    removeSelectedOption(selectedValue,rownum);
                });     
            }
            $("#blanktable-error").html("");
        }

        function removeSelectedOption(value,ind) {
            var selectElement = $(`#timetables${ind}`);
            var selectedValues = selectElement.val();

            // Remove the specific value from the array of selected values
            selectedValues = selectedValues.filter(function(val) {
                return val !== value;
            });
            
            // Update the selected values
            selectElement.val(selectedValues).trigger('change');
        }

        $(document).on('click', '.shiftdetails', function(){
            var currentind=null;
            if($(this).is(":checked")) {
                currentind=$(this).val();
                var allclass=$('.shiftdetails').length;
                var checkedclass=$('.shiftdetails:checked').length;
                if(parseInt(allclass)==parseInt(checkedclass)){
                    $('#selectallcbx').prop('indeterminate', false); 
                    $('#selectallcbx').prop('checked', true); 
                }
                else if(parseInt(allclass)!=parseInt(checkedclass)){
                    $('#selectallcbx').prop('indeterminate', true); 
                }
                $('#flagvalue'+currentind).val(1);
            }
            else{
                currentind=$(this).val();
                var allclass=$('.shiftdetails').length;
                var uncheckedclass=$('.shiftdetails:not(:checked)').length;
                if(parseInt(allclass)==parseInt(uncheckedclass)){
                    $('#selectallcbx').prop('indeterminate', false); 
                    $('#selectallcbx').prop('checked', false); 
                }
                else if(parseInt(allclass)!=parseInt(uncheckedclass)){
                    $('#selectallcbx').prop('indeterminate', true); 
                }
                $('#flagvalue'+currentind).val(0);
            }
            $('#shiftdetail-error').html("");
        });

        function cycleNumbering(){
            $('#CycleNumber').empty();
            for(var y=1;y<=52;y++){
                $('#CycleNumber').append('<option value='+y+'>'+y+'</option>');
            }
        }

        function cycleUnitOrdering(flg){
            var cycleunit=$('#CycleUnit').val()||0;
            var cyclenumber=$('#CycleNumber').val()||0;
            var variance=parseInt(cyclenumber)-parseInt(oldcyclenum);
            if(parseInt(cycleunit)>0 && parseInt(cyclenumber)>0){
                days=[];
                for(var cu=1;cu<=cyclenumber;cu++){
                    if(parseInt(cycleunit)==1){
                        days.push("Day-"+cu);
                    }
                    if(parseInt(cycleunit)==2){
                        for(var months=1;months<=31;months++){
                            days.push("Day-"+months);
                        }
                    }
                    if(parseInt(cycleunit)==3){
                        var daysname=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                        $.each(daysname, function(index,daysname) {
                            days.push(daysname);
                        });
                    }
                }
                if(parseInt(flg)==1){
                    if(parseInt(cycleunit)==1 && parseInt(variance)!=0 && !isNaN(parseInt(variance))){
                        if(parseInt(variance)<0){
                            days = days.slice(variance);
                            totalvaiance=parseInt(variance)*parseInt(1);
                        }
                        if(parseInt(variance)>0){
                            totalvaiance=parseInt(variance)*parseInt(1);
                        }
                    }
                    if(parseInt(cycleunit)==2 && parseInt(variance)!=0 && !isNaN(parseInt(variance))){
                        if(parseInt(variance)<0){
                            days = days.slice(parseInt(variance)*parseInt(31));
                            totalvaiance=parseInt(variance)*parseInt(31);
                        }
                        if(parseInt(variance)>0){
                            totalvaiance=parseInt(variance)*parseInt(31);
                        }
                    }
                    if(parseInt(cycleunit)==3 && parseInt(variance)!=0 && !isNaN(parseInt(variance))){
                        if(parseInt(variance)<0){
                            days = days.slice(parseInt(variance)*parseInt(7));
                            totalvaiance=parseInt(variance)*parseInt(7);
                        }
                        if(parseInt(variance)>0){
                            totalvaiance=parseInt(variance)*parseInt(7);
                        }
                    }
                    appendTimetable(flg);
                }
                else if(parseInt(flg)==2){
                    appendTimetable(flg);
                }
            }
        }

        function shiftEditFn(recordId) {
            $('#modaltitle').html('Edit Shift');
            $('#operationtypes').val("2");
            $('#CycleNumber').empty();
            $('#CycleUnit').empty();
            $("#checkFlag").val('1');
            var shiftflag=0;
            flagdata=1;
            days=[];
            var daytype="";
            var i=0;
            var dayname="";
            $.ajax({
                type: "get",
                url: "{{url('showshift')}}"+'/'+recordId,
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
                    shiftflag=data.shiftcnt;
                    $.each(data.shiftdata, function(key, value) {
                        if(parseInt(shiftflag)==0){
                            for(var y=1;y<=52;y++){
                                $('#CycleNumber').append('<option value='+y+'>'+y+'</option>');
                            }
                            $('#CycleUnit').append("<option value='1'>Day</option><option value='2'>Month</option><option value='3'>Week</option>");
                            $('#ShiftEditFlag').val("0");
                            $('#assigntime').show();
                        }
                        else if(parseInt(shiftflag)>0){
                            $('#ShiftEditFlag').val("1");
                            $('#assigntime').show();
                        }
                        $('#recId').val(value.id);
                        $('#ShiftName').val(value.ShiftName);
                        $('#BegininngDate').val(value.BegininngDate);
                        $("#CycleNumber option[value='"+value.CycleNumber+"']").remove();  
                        $('#CycleNumber').select2('destroy');
                        $('#CycleNumber').append('<option selected value='+value.CycleNumber+'>'+value.CycleNumber+'</option>').select2();
                        $("#CycleUnit option[value='"+value.CycleUnit+"']").remove();  
                        if(parseInt(value.CycleUnit)==1){
                            dayname="Day";
                        }
                        else if(parseInt(value.CycleUnit)==2){
                            dayname="Month";
                        }
                        else if(parseInt(value.CycleUnit)==3){
                            dayname="Week";
                        }
                        $('#CycleUnit').append('<option selected value='+value.CycleUnit+'>'+dayname+'</option>').select2({minimumResultsForSearch: -1});
                        $('#Description').val(value.Description);
                        $('#status').select2('destroy');
                        $('#status').val(value.Status).trigger('change').select2({minimumResultsForSearch: -1});

                        for(var cu=1;cu<=value.CycleNumber;cu++){
                            if(parseInt(value.CycleUnit)==1){
                                days.push("Day-"+cu);
                            }
                            if(parseInt(value.CycleUnit)==2){
                                for(var months=1;months<=31;months++){
                                    days.push("Day-"+months);
                                }
                            }
                            if(parseInt(value.CycleUnit)==3){
                                var daysname=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                                $.each(daysname, function(index,daysname) {
                                    days.push(daysname);
                                });
                            }
                        }
                    });
                    appendTimetable(2);

                    $('#timetableassign > tbody  > tr').each(function(index, tr) {
                        var ind= ++index;
                        var keyvaldata=0;
                        var n=0;
                        ind = parseInt(ind) <= 9 ? `0${ind}` : ind; 
                        
                        var flag=$('#flagvalue'+ind).val()||0;
                        let selectedIds=[];
                        $(`#timetables${ind}`).empty();
                        $(`#timetables${ind}`).select2({multiple: true});
                        let timetableData = $("#TimetableDefault > option").clone();
                        $(`#timetables${ind}`).append(timetableData);
                        
                        $.each(data.shiftdaytime, function(i,val) {
                            if(parseInt(ind) == parseInt(val.daynum)){
                                selectedIds.push(Number(val.timetables_id));
                                $(`#timetables${ind}`).val(selectedIds);
                                $(`#timetables${ind}`).select2({
                                    allowClear:false,
                                    templateResult: formatOption,
                                    templateSelection: formatSelectedOpt
                                });
                            } 
                        });
                    });

                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled",false);
                    $("#inlineForm").modal('show');
                },
            }); 
        }

        function shiftInfoFn(recordId) {
            createShiftInfoFn(recordId);
            $("#informationmodal").modal('show');
        }

        function createShiftInfoFn(recordId) {
            days = [];
            var action_log = "";
            var lidata = "";
            var action_links = "";
            $('#timetableDiv').hide();
            $.ajax({
                type: "get",
                url: "{{url('showshift')}}"+'/'+recordId,
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
                    fetchTimetableData(recordId);   
                },
                success: function (data) {
                    $.each(data.shiftdata, function(key, value) {
                        $('#shiftnamelbl').html(value.ShiftName);
                        $('#beginningdatelbl').html(value.BegininngDate);
                        $('#cyclenumberlbl').html(value.CycleNumber);
                        $('#cycleunitlbl').html(value.CycleUnits);
                        $('#descriptionlbl').html(value.Description);
                        $("#statuslbl").html(value.Status == "Active" ? 
                            `<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:12px;'>${value.Status}</span>` :
                            `<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:12px;'>${value.Status}</span>`
                        );
                    });

                    $.each(data.timetabledata, function(key, value) {
                        colorMap[value.TimetableName] = value.TimetableColor;
                    });     

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        if(value.action == "Edited"){
                            classes="warning";
                        }
                        else if(value.action == "Created"){
                            classes="success";
                        }
                        lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $("#universal-action-log-canvas").empty().append(lidata);

                    action_links = `
                        <li>
                            <a class="dropdown-item viewShiftAction" onclick="viewShiftFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Shift-Edit")
                        <li>
                            <a class="dropdown-item shiftEdit" onclick="shiftEditFn(${recordId})" data-id="editlinkbtn${recordId}" id="editlinkbtn${recordId}" title="Open shift edit form">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Shift-Delete")
                        <li>
                            <a class="dropdown-item shiftDelete" onclick="shiftDeleteFn(${recordId})" data-id="deletelinkbtn${recordId}" id="deletelinkbtn${recordId}" title="Open shift delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan`;

                    $("#shift_action_ul").empty().append(action_links);
                },
            }); 

            $(".infoshift").collapse('show');
        }

        function fetchTimetableData(recordId){
            var recid = "";
            $('#timetableDiv').hide();
            $('#timetableinfotbl').DataTable({
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
                    url: "{{url('showShiftData')}}",
                    type: 'POST',
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
                    data:{
                        recid: recordId,
                    },
                    dataType: "json",
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"5%"
                    },
                    {
                        data: 'Dates',
                        name: 'Dates',
                        width:"25%"
                    },
                    {
                        data: 'SelectedTimetable',
                        name: 'SelectedTimetable',
                        width:"70%"
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
                    $('#timetableDiv').show();
                },
                "rowCallback": function (row, data, index) {
                    let cell = $('td:eq(2)', row); // Change index based on your column
                    let content = cell.text();

                    // Replace text dynamically with colors
                    $.each(colorMap, function (phrase, color) {
                        content = content.replace(phrase, `<span class="badge bg-glow" style="color:white;background-color: ${color};font-weight:bold;font-size:14px;">${phrase}</span>`);
                    });
                    cell.html(content);
                }
            });
        }

        function viewShiftFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.shift_header_info');
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
                const shift_name = container.find('#shiftnamelbl').text().trim();
                const shift_status = container.find('#statuslbl').text().trim();
                const summaryShift = `
                    Shift Name: <b>${shift_name}</b>,
                    Status: <b style="color: ${shift_status == "Active" ? "#28c76f" : "#ea5455"}">${shift_status}</b>`;

                infoTarget.html(summaryShift);
            }
        });

        function shiftDeleteFn(recordId) {
            $.ajax({
                type: "get",
                url: "{{url('showshift')}}"+'/'+recordId,
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
                    if(parseInt(data.shiftcnt)==0){
                        $("#delId").val(recordId);
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
                                deleteShiftFn(recordId);
                            }
                            else if (result.dismiss === Swal.DismissReason.cancel) {}
                        });
                    }
                    else if(parseInt(data.shiftcnt)>0){
                        toastrMessage('error',"You cannot delete the shift because schedules are created based on it","Error");
                    }
                },
            });
        }

        $('#savebutton').click(function(){
            let selectedLen = 0;
            $(".timetablecls").each(function () {
                let selectedOptions = $(this).val(); // Get selected values
                if (selectedOptions) {
                    selectedLen += selectedOptions.length;
                }
            });
            
            $("#selectedLength").val(selectedLen);
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var optype = $("#operationtypes").val();
            var numberoftd=0;
            var numberofeachtd=0;
            var numofvals=0;
            saveobjectdata={};
            var con=0;
            
            var objdata=null;
            var ShiftName=null;
            var BegininngDate=null;
            var CycleNumber=null;
            var CycleUnit=null;
            var Description=null;
            var status=null;
            var recId=null;
            var checkFlag=null;
            $.ajax({
                url:'/saveShift',
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
                        $('#savebutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
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
                        if(data.errors.ShiftName){
                            $('#name-error').html( data.errors.ShiftName[0]);
                        }
                        if(data.errors.BegininngDate){
                            $('#beginningdate-error').html( data.errors.BegininngDate[0]);
                        }
                        if(data.errors.CycleNumber){
                            $('#cyclenum-error').html( data.errors.CycleNumber[0]);
                        }
                        if(data.errors.CycleUnit){
                            $('#cycleunit-error').html( data.errors.CycleUnit[0]);
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
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.checkerr) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        $('#assignbtn-error').html("Please assign Time here");
                        toastrMessage('error',"Please click Assign Time button and assign Time for the days","Error");
                    }
                    else if (data.blanktable) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        $('#blanktable-error').html("Please assign Time for the listed days");
                        toastrMessage('error',"Please click Assign Time button and assign Timetable for the days","Error");
                    }
                    else if(data.success) {
                        if(parseFloat(optype)==2){
                            createShiftInfoFn(data.rec_id);                            
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                },
            });
        });

        function deleteShiftFn(recordId){
            var delform = $("#informationform");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteshift',
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
                    if (data.dberrors) {
                        toastrMessage('error',"Error found</br>This record cannot be deleted because it exists with other records.","Error");
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
     
        function shiftnamefn() {
            $('#name-error').html("");
        }

        function begDateFn() {
            $('#beginningdate-error').html("");
        }

        function cycleNumFn() {
            var cycleunit=$('#CycleUnit').val()||0;
            var cyclenumber=$('#CycleNumber').val()||0;
            if(parseInt(cycleunit)>0 && parseInt(cyclenumber)>0){
                cycleUnitOrdering(1);
            }
            else{
                $('#CycleUnit').empty();
                $('#CycleUnit').append("<option value='1'>Day</option><option value='2'>Month</option><option value='3'>Week</option>");
                $('#CycleUnit').val(null).select2();
                $('#CycleUnit').select2({
                    minimumResultsForSearch: -1,
                    placeholder:"Select cycle unit here"
                });
            }
            oldcyclenum=cyclenumber;
            $('#cyclenum-error').html("");
        }

        function cycleUnitFn() {
            cycleUnitOrdering(2);
            $('#cycleunit-error').html("");
        }

        function descriptionfn() {
            $('#description-error').html("");
        }

        function statusfn() {
            $('#status-error').html("");
        }

        function refreshShiftDataFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }

        function resetShiftFormFn(){
            $('.reg_form').val("");
            $('.errordatalabel').html("");
            cycleNumbering();
            $('#CycleUnit').empty().select2({placeholder:"Select cycle unit here"});
            $('#CycleNumber').val(null).select2({placeholder:"Select cycle number here"});
            $('#status').val("Active").select2({minimumResultsForSearch: -1});

            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);

            $("#schtimetable > tbody").empty();
            $('#timetableassign > tbody').empty();
            $("#checkFlag").val("");
            $('#ShiftEditFlag').val(0);
            oldcyclenum = 0;

            $('#operationtypes').val(1);
            $("#modaltitle").html("Add Shift");
        }
    </script>
@endsection
