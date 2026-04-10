@extends('layout.app1')

@section('title')
@endsection

@section('content')
    @can('Timetable-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Timetable</h3>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshTimetableDataFn()"><i class="fas fa-sync-alt"></i></button>
                                        @if (auth()->user()->can('Timetable-Add'))
                                        <button type="button" class="btn btn-gradient-info btn-sm addtimetable header-prop" id="addtimetable"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                        @endcan 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable">
                            <div style="width:99%; margin-left:0.5%;display: none;" id="main-datatable" class="fit-content">
                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width:3%;">#</th>
                                            <th style="width:23%;">Timetable Name</th>
                                            <th style="width:15%;">Punching Method</th>
                                            <th style="width:15%;">On Duty Time</th>
                                            <th style="width:15%;">Off Duty Time</th>
                                            <th style="width:15%;">Color</th>
                                            <th style="width:10%;">Status</th>
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
                    <h4 class="modal-title form_title">Timetable Information</h4>
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
                                <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                    <ul class="nav nav-tabs info-note" role="tablist">
                                        <li class="nav-item genformnavcon">
                                            <a class="nav-link genformnav disabled" id="general-tab" data-toggle="tab" href="#infogeneralview" aria-controls="general-tab" role="tab" aria-selected="false" title="General Information"><i class="fas fa-database"></i>&nbsp General Information</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content genformtabcon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                        <div class="tab-pane genformtab active" id="infogeneralview" aria-labelledby="infogeneralview" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                        <tr>
                                                            <td><label class="info_lbl">Timetable Name</label></td>
                                                            <td><label class="info_lbl" id="timetablenamelbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Punching Method</label></td>
                                                            <td><label class="info_lbl" id="punchingmethodlbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Color</label></td>
                                                            <td id="progressbarinfo"></td>
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
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                    <ul class="nav nav-tabs info-note" role="tablist">
                                        <li class="nav-item genformnavcon">
                                            <a class="nav-link genformnav disabled" id="attendance-tab" data-toggle="tab" href="#infoattendanceview" aria-controls="attendance-tab" role="tab" aria-selected="false" title="Attendance Information"><i class="fas fa-calendar-check"></i>&nbsp Attendance Information</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content genformtabcon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                        <div class="tab-pane genformtab active" id="infoattendanceview" aria-labelledby="infoattendanceview" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <p class="mt-0 mb-0" style="text-align: left;"><label style="font-size: 20px;font-weight:bold;" class="form_lbl">Punch In</label></p>
                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                        <tr>
                                                            <td><label class="info_lbl">Beginning In</label></td>
                                                            <td><label class="info_lbl" id="beginninginlbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">On Duty Time</label></td>
                                                            <td style="background-color:#000000"><label class="info_lbl" id="ondutytimelbl" style="font-weight:bold;color:#FFFFFF"></label></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td><label class="info_lbl">Ending In</label></td>
                                                            <td><label class="info_lbl" id="endinginlbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Late Time</label></td>
                                                            <td><label class="info_lbl" id="latetimelbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <p class="mt-0 mb-0" style="text-align: left;"><label style="font-size: 20px;font-weight:bold;" class="form_lbl">Punch Out</label></p>
                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                        <tr>
                                                            <td><label class="info_lbl">Beginning Out</label></td>
                                                            <td><label class="info_lbl" id="beginningoutlbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Off Duty Time</label></td>
                                                            <td style="background-color:#000000"><label class="info_lbl" id="offdutytimelbl" style="font-weight:bold;color:#FFFFFF"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Work Time Duration</label></td>
                                                            <td><label class="info_lbl" id="workhourdurationlbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Ending Out</label></td>
                                                            <td><label class="info_lbl" id="endingoutlbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Leave Early Time</label></td>
                                                            <td><label class="info_lbl" id="leavearlytimelbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Is Night Shift</label></td>
                                                            <td><label class="info_lbl" id="isnightshiftlbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <p class="mt-0 mb-0" style="text-align: left;"><label style="font-size: 20px;font-weight:bold;" class="form_lbl">Break Time</label></p>
                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                        <tr>
                                                            <td><label class="info_lbl">Break Hour Type</label></td>
                                                            <td><label class="info_lbl" id="breakhourtypelbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Break Start Time</label></td>
                                                            <td><label class="info_lbl" id="breakstartimelbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Leave Early Time Break</label></td>
                                                            <td><label class="info_lbl" id="leaveearlytimebreak" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Break End Time</label></td>
                                                            <td><label class="info_lbl" id="breakendtimelbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Late Time Break</label></td>
                                                            <td><label class="info_lbl" id="latetimebreaklbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Break Time Duration</label></td>
                                                            <td><label class="info_lbl" id="breakhourdurationlbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Break Time as Work Time</label></td>
                                                            <td><label class="info_lbl" id="breaktimeworktimelbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Break Time as Overtime</label></td>
                                                            <td><label class="info_lbl" id="breaktimeovertimelbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                    <ul class="nav nav-tabs info-note" role="tablist">
                                        <li class="nav-item genformnavcon">
                                            <a class="nav-link genformnav disabled" id="absence-tab" data-toggle="tab" href="#infoabsenceview" aria-controls="absence-tab" role="tab" aria-selected="false" title="Absence Information"><i class="fas fa-ellipsis-h"></i>&nbsp Absence Information</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content genformtabcon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                        <div class="tab-pane genformtab active" id="infoabsenceview" aria-labelledby="infoabsenceview" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                        <tr>
                                                            <td><label class="info_lbl">Punch In Late for</label></td>
                                                            <td><label class="info_lbl" id="checkinlatelbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Punch Out Early for</label></td>
                                                            <td><label class="info_lbl" id="checkoutearlylbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">No Punch-In Mark as</label></td>
                                                            <td><label class="info_lbl" id="nocheckinmarklbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">No Punch-Out Mark as</label></td>
                                                            <td><label class="info_lbl" id="nocheckoutmarklbl" style="font-weight:bold;"></label></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                        <ul class="dropdown-menu" id="timetable_action_ul"></ul>
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
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="modaltitle"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <ul class="nav nav-tabs note" role="tablist">
                                    <li class="nav-item genformnavcon">
                                        <a class="nav-link genformnav disabled" id="General-tab" data-toggle="tab" href="#generalinformationview" aria-controls="generalinformationview" role="tab" aria-selected="false" style="color: #6e6b7b;text-align:left;"><i class="fas fa-database"></i>&nbsp General Data</a>
                                    </li>
                               </ul>
                               <div class="tab-content genformtabcon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane genformtab active" id="generalinformationview" aria-labelledby="generalinformationview" role="tabpanel">
                                        <div class="row ml-1 mr-1">
                                            <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Timetable Name<b style="color: red; font-size:16px;">*</b></label>
                                                <input type="text" placeholder="Timetable Name" class="form-control mainforminp reg_form" name="TimetableName" id="TimetableName" onkeyup="timeTableFn()"/>
                                                <span class="text-danger">
                                                    <strong id="name-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Punching Method<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control" name="PunchingMethod" id="PunchingMethod" onchange="punchingMethodFn()">
                                                    <option value=""></option>
                                                    <option value="2">2X</option>
                                                    <option value="4">4X</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="punchingmethod-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-12 col-lg-4 col-md-12 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Color</label>
                                                <input type="color" class="form-control form-control-color" name="TimetableColor" id="TimetableColor" value="#563d7c" title="Choose your color">
                                                <span class="text-danger">
                                                    <strong id="clolor-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-12 col-lg-4 col-md-12 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Description</label>
                                                <textarea type="text" placeholder="Write Description here..." class="form-control mainforminp reg_form" rows="1" name="Description" id="Description" onkeyup="descriptionfn()"></textarea>
                                                <span class="text-danger">
                                                    <strong id="description-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-12 col-lg-4 col-md-12 col-sm-12 col-12 mb-1">
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
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <ul class="nav nav-tabs note" role="tablist">
                                    <li class="nav-item attendance">
                                        <a class="nav-link attendancenav disabled" id="Attendance-tab" data-toggle="tab" href="#attendanceinformationview" aria-controls="attendanceinformationview" role="tab" aria-selected="false" style="color: #6e6b7b;text-align:left;"><i class="fas fa-calendar-check"></i>&nbsp Attendance Data</a>
                                    </li>
                               </ul>
                               <div class="tab-content attendancecon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane attendancetab active" id="attendanceinformationview" aria-labelledby="attendanceinformationview" role="tabpanel">
                                        <div class="divider">
                                            <div class="divider-text">Work Time</div>
                                        </div>
                                        <div class="row ml-1 mr-1">
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-1">
                                                <label class="form_lbl">Beginning In<b style="color: red; font-size:16px;">*</b></label>
                                                <input type="text" placeholder="Beginning In" class="form-control mainforminp reg_form" name="BeginningIn" id="BeginningIn" onchange="beginningInFn()"/><br>
                                                <span class="text-danger">
                                                    <strong id="beginnngin-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-1">
                                                <label class="form_lbl">On Duty Time<b style="color: red; font-size:16px;">*</b></label>
                                                <input type="text" placeholder="On Duty Time" class="form-control mainforminp distime reg_form" style="font-weight: bold;font-size: 17px;" name="OnDutyTime" id="OnDutyTime" onchange="ondutyTimeFn()"/>
                                                <span class="text-danger">
                                                    <strong id="ondutytime-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-1">
                                                <label class="form_lbl">Ending In<b style="color: red; font-size:16px;">*</b></label>
                                                <input type="text" placeholder="Ending In" class="form-control mainforminp distime reg_form" name="EndingIn" id="EndingIn" onchange="endingInFn()"/><br>
                                                <span class="text-danger">
                                                    <strong id="endingin-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-1">
                                                <label class="form_lbl">Late Time (Min)<b style="color: red; font-size:16px;">*</b></label>
                                                <input type="text" name="LateTime" id="LateTime" class="form-control mainforminp reg_form" placeholder="Late time in minute" onkeypress="return ValidateOnlyNum(event);" onkeyup="lateTimeFn()"/>
                                                <span class="text-danger">
                                                    <strong id="latetime-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-1">
                                                <label class="form_lbl">Beginning Out<b style="color: red; font-size:16px;">*</b></label>
                                                <input type="text" placeholder="Beginning Out" class="form-control mainforminp distime reg_form" name="BeginningOut" id="BeginningOut" onchange="beginningOutFn()"/>
                                                <span class="text-danger">
                                                    <strong id="beginnngout-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-1">
                                                <label class="form_lbl">Off Duty Time<b style="color: red; font-size:16px;">*</b></label>
                                                <input type="text" placeholder="Off Duty Time" class="form-control mainforminp distime reg_form" style="font-weight: bold;font-size: 17px;" name="OffDutyTime" id="OffDutyTime" onchange="offdutyTimeFn()"/>
                                                <span class="text-secondary">
                                                    <strong id="workhourduration" class="errordatalabel"></strong>
                                                </span></br>
                                                <span class="text-danger">
                                                    <strong id="offdutytime-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-1">
                                                <label class="form_lbl">Ending Out<b style="color: red; font-size:16px;">*</b></label>
                                                <input type="text" placeholder="Ending Out" class="form-control mainforminp distime reg_form" name="EndingOut" id="EndingOut" onchange="endingOutFn()"/>
                                                <span class="text-danger">
                                                    <strong id="endingout-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-1">
                                                <label class="form_lbl">Leave Early Time (Min)<b style="color: red; font-size:16px;">*</b></label>
                                                <input type="text" name="LeaveEarlyTime" id="LeaveEarlyTime" class="form-control mainforminp reg_form" placeholder="Late time in minute" onkeypress="return ValidateOnlyNum(event);" onkeyup="leaveEarlyFn()"/>
                                                <span class="text-danger">
                                                    <strong id="leavearlytime-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="custom-control custom-control-primary custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input shiftrule" id="isnightshift" name="isnightshift">
                                                    <label class="custom-control-label form_lbl" for="isnightshift">  Is Night Shift</label>                                                
                                                </div>
                                            </div>

                                        </div>
                                        <div class="divider">
                                            <div class="divider-text">Overtime Time</div>
                                        </div>
                                        <div class="row ml-1 mr-1">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <label class="form_lbl">Early Punch-In Overtime<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control" name="EarlyCheckInOvertime" id="EarlyCheckInOvertime" onchange="earlyCheckInCalcFn()">
                                                    <option value=""></option>
                                                    <option value="1">Enable</option>
                                                    <option value="0">Disable</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="earlycheckin-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <label class="form_lbl">Overtime Start</label>
                                                <input type="text" placeholder="OT Start Time" class="form-control mainforminp distime reg_form" name="OvertimeStart" id="OvertimeStart" onchange="overtimeStFn()" ondblclick="clearOtTime()"/>
                                                <span class="text-danger">
                                                    <strong id="overtimestart-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="divider">
                                            <div class="divider-text">Break Time</div>
                                        </div>
                                        <div class="row ml-1 mr-1">

                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-1" id="breakHourTypeDiv">
                                                <label class="form_lbl">Break Hour Type<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control" name="BreakHourType" id="BreakHourType" onchange="breakHourTypeFn()">
                                                    <option value=""></option>
                                                    <option value="0">Fixed</option>
                                                    <option value="1">Flexible</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="breakhourtype-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 breaktimeprop breaktypehourcls">
                                                        <label class="form_lbl">Break Start Time<b style="color: red; font-size:16px;">*</b></label>
                                                        <input type="text" placeholder="Break Start Time" class="form-control mainforminp distime breaktimevals reg_form" name="BreakStartTime" id="BreakStartTime" onchange="breakStartTimeFn()" ondblclick="clearBrStartTimeFn()"/>
                                                        <span class="text-danger">
                                                            <strong id="breakstarttime-error" class="errordatalabel breaktimeerr"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 breaktimeprop breaktypehourcls">
                                                        <label class="form_lbl">Leave Early Time Break (Min)<b style="color: red; font-size:16px;">*</b></label>
                                                        <input type="text" name="LeaveEarlyTimeBreak" id="LeaveEarlyTimeBreak" class="form-control mainforminp breaktimevals reg_form" placeholder="Late time for break in minute" onkeypress="return ValidateOnlyNum(event);" onkeyup="breakleaveEarlyFn()"/>
                                                        <span class="text-danger">
                                                            <strong id="breakleavearlytime-error" class="errordatalabel"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 breaktimeprop breaktypehourcls">
                                                        <label class="form_lbl">Break End Time</label>
                                                        <input type="text" placeholder="Break End Time" class="form-control mainforminp distime breaktimevals reg_form" name="BreakEndTime" id="BreakEndTime" onchange="breakEndTimeFn()" ondblclick="clearBrEndTimeFn()"/>
                                                        <span class="text-danger">
                                                            <strong id="breakendtime-error" class="errordatalabel breaktimeerr"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 breaktimeprop breaktypehourcls">
                                                        <label class="form_lbl">Late Time Break (Min)</label>
                                                        <input type="text" name="LateTimeBreak" id="LateTimeBreak" class="form-control mainforminp breaktimevals reg_form" placeholder="Late time for break in minute" onkeypress="return ValidateOnlyNum(event);" onkeyup="breaklateTimeFn()"/>
                                                        <span class="text-danger">
                                                            <strong id="breaklatetime-error" class="errordatalabel"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-1" id="breakDurationDiv">
                                                        <label class="form_lbl" title="Break Duration (Minute)">Break Duration (Min)<b style="color: red; font-size:16px;">*</b></label>
                                                        <input type="text" placeholder="Break Hour Duration" class="form-control mainforminp breaktimevals reg_form" name="BreakHour" id="BreakHour" readonly style="font-weight:bold;" onkeypress="return ValidateOnlyNum(event);" onkeyup="breakHourDurFn()"/>
                                                        <span class="text-danger">
                                                            <strong id="breakhour-error" class="errordatalabel breaktimeerr"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-1">
                                                        <label class="form_lbl">Break Time as Work Time<b style="color: red; font-size:16px;">*</b></label>
                                                        <select class="select2 form-control" name="BreakTimeAsWorkTime" id="BreakTimeAsWorkTime" onchange="breakTimeWtimeFn()">
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="breaktimecalc-error" class="errordatalabel"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-1">
                                                        <label class="form_lbl">Break Time as Overtime<b style="color: red; font-size:16px;">*</b></label>
                                                        <select class="select2 form-control" name="BreakTimeAsOvertime" id="BreakTimeAsOvertime" onchange="breakTimeOtimeFn()">
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="breaktimeot-error" class="errordatalabel"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <ul class="nav nav-tabs note" role="tablist">
                                    <li class="nav-item attendance">
                                        <a class="nav-link abscsencenav disabled" id="Absence-tab" data-toggle="tab" href="#abscenceinformationview" aria-controls="abscenceinformationview" role="tab" aria-selected="false" style="color: #6e6b7b;text-align:left;"><i class="fas fa-ellipsis-h"></i>&nbsp Absence Data</a>
                                    </li>
                               </ul>
                               <div class="tab-content abscencecon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane abscencetab active" id="abscenceinformationview" aria-labelledby="abscenceinformationview" role="tabpanel">
                                        <div class="row ml-1 mr-1">
                                            <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Punch In Late for</label>
                                                <div class="input-group">
                                                    <input type="text" name="CheckInLateMinute" id="CheckInLateMinute" class="form-control mainforminp" placeholder="Enter minute here" onkeypress="return ValidateOnlyNum(event);" onkeyup="checkinLateFn()"/>
                                                    <label style="font-size: 10px;margin-top:10px;">min Count as Absent</label>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="checkinlate-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Punch Out Early for</label>
                                                <div class="input-group">
                                                    <input type="text" name="CheckOutEarlyMinute" id="CheckOutEarlyMinute" class="form-control mainforminp" placeholder="Enter minute here" onkeypress="return ValidateOnlyNum(event);" onkeyup="checkOutEarlyFn()"/>
                                                    <label style="font-size: 10px;margin-top:10px;">min Count as Absent</label>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="checkoutearly-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">No Punch-In Mark as</label>
                                                <div class="input-group">
                                                    <select class="select2 form-control" name="NoCheckInMark" id="NoCheckInMark" onchange="noCheckInMarkFn()">
                                                        <option value="1">Absent</option>
                                                        <option value="2">Late</option>
                                                    </select>
                                                    <input type="text" name="NoCheckInMinute" id="NoCheckInMinute" class="form-control mainforminp lateprop latearlyprop" placeholder="Enter minute here" onkeypress="return ValidateOnlyNum(event);" onkeyup="noCheckInFn()"/>
                                                    <label class="lateprop latearlyprop" style="font-size: 10px;margin-top:10px;">min</label>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="nocheckin-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">No Punch-Out Mark as</label>
                                                <div class="input-group">
                                                    <select class="select2 form-control" name="NoCheckOutMark" id="NoCheckOutMark" onchange="noCheckOutMarkFn()">
                                                        <option value="1">Absent</option>
                                                        <option value="3">Early</option>
                                                    </select>
                                                    <input type="text" name="NoCheckOutMinute" id="NoCheckOutMinute" class="form-control mainforminp earlyprop latearlyprop" placeholder="Enter minute here" onkeypress="return ValidateOnlyNum(event);" onkeyup="noCheckOutFn()"/>
                                                    <label class="earlyprop latearlyprop" style="font-size: 10px;margin-top:10px;">min</label>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="nocheckout-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-1" style="display: none;">
                            <label style="font-size: 14px;" title="Work Hour Duration">Work Hour Duration</label>
                            <input type="text" placeholder="Work Hour Duration" class="form-control mainforminp" name="WorkingHour" id="WorkingHour" readonly style="font-weight:bold;"/>
                            <span class="text-danger">
                                <strong id="workhour-error" class="errordatalabel breaktimeerr"></strong>
                            </span>
                        </div>
                        <input type="hidden" class="form-control reg_form" name="TimeEditFlag" id="TimeEditFlag" readonly="true" value="0"/>     
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
        var endtimeval = "23:59";
        var errorcolor = "#ffcccc";
        var colors = [];
        $(function () {
            cardSection = $('#page-block');
        });
        var globalIndex = -1;

        var j = 0;
        var i = 0;
        var m = 0;

        $(document).ready( function () {
            colors = [
                "#007bff", "#28a745", "#ffc107", "#dc3545", "#6f42c1",
                "#56CCF2", "#F4A261", "#E76F51", "#2A9D8F", "#8E44AD",
                "#00c6ff", "#0072ff", "#ff758c", "#ff7eb3", "#00b09b",
                "#96c93d", "#8e2de2", "#4a00e0", "#b0bec5", "#ff5733",
                "#17a2b8", "#ff6b81", "#20c997", "#ff9f43", "#6c757d"
            ];
            $('#main-datatable').hide();

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
                    url: '/timetablelist',
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
                    { data:'DT_RowIndex',width:"3%"},
                    { data: 'TimetableName', name: 'TimetableName',width:"23%"},
                    { data: 'PunchingMethods', name: 'PunchingMethods',width:"15%"},
                    { data: 'OnDutyTime', name: 'OnDutyTime',width:"15%"},
                    { data: 'OffDutyTime', name: 'OffDutyTime',width:"15%"},
                    { data: 'TimetableColor',
                        "render": function( data, type, row, meta) {
                           return '<div class="container" style="width:200px;margin-left:-15px;"><div class="progress" style="height:13px;width:100%;"><div class="progress-bar" role="progressbar" style="width:100%; background-color:'+data+' !important;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div>';
                        },
                        width:"15%"
                    },
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
                        width:"10%"
                    },
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="timetableInfo" href="javascript:void(0)" onclick="timetableInfoFn(${row.id})" data-id="timetable_id${row.id}" id="timetable_id${row.id}" title="Open position information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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
                    $('#main-datatable').show();
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
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

        $("#addtimetable").on("click", function () {
            resetTimetableFormFn();
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
                url: '/saveTimetable',
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
                        if (data.errors.TimetableName) {
                            $('#name-error').html(data.errors.TimetableName[0]);
                        }
                        if (data.errors.PunchingMethod) {
                            $('#punchingmethod-error').html(data.errors.PunchingMethod[0]);
                        }
                        if (data.errors.BreakTimeAsWorkTime) {
                            $('#breaktimecalc-error').html(data.errors.BreakTimeAsWorkTime[0]);
                        }
                        if (data.errors.BreakTimeAsOvertime) {
                            $('#breaktimeot-error').html(data.errors.BreakTimeAsOvertime[0]);
                        }
                        if (data.errors.EarlyCheckInOvertime) {
                            $('#earlycheckin-error').html(data.errors.EarlyCheckInOvertime[0]);
                        }
                        if (data.errors.OnDutyTime) {
                            $('#ondutytime-error').html(data.errors.OnDutyTime[0]);
                        }
                        if (data.errors.OffDutyTime) {
                            $('#offdutytime-error').html(data.errors.OffDutyTime[0]);
                        }
                        if (data.errors.WorkingHour) {
                            $('#workhour-error').html(data.errors.WorkingHour[0]);
                        }
                        if (data.errors.LateTime) {
                            $('#latetime-error').html(data.errors.LateTime[0]);
                        }
                        if (data.errors.LeaveEarlyTime) {
                            $('#leavearlytime-error').html(data.errors.LeaveEarlyTime[0]);
                        }
                        if (data.errors.BeginningIn) {
                            $('#beginnngin-error').html(data.errors.BeginningIn[0]);
                        }
                        if (data.errors.EndingIn) {
                            $('#endingin-error').html(data.errors.EndingIn[0]);
                        }
                        if (data.errors.BeginningOut) {
                            $('#beginnngout-error').html(data.errors.BeginningOut[0]);
                        }
                        if (data.errors.EndingOut) {
                            $('#endingout-error').html(data.errors.EndingOut[0]);
                        }
                        if (data.errors.BreakHourType) {
                            $('#breakhourtype-error').html(data.errors.BreakHourType[0]);
                        }
                        if (data.errors.BreakStartTime) {
                            var text=data.errors.BreakStartTime[0];
                            text = text.replace("0", "fixed");
                            text = text.replace("1", "flexible");
                            $('#breakstarttime-error').html(text);
                        }
                        if (data.errors.BreakEndTime) {
                            var text=data.errors.BreakEndTime[0];
                            text = text.replace("0", "fixed");
                            text = text.replace("1", "flexible");
                            $('#breakendtime-error').html(text);
                        }
                        if (data.errors.BreakHour) {
                            var text=data.errors.BreakHour[0];
                            text = text.replace("4", "4X");
                            $('#breakhour-error').html(text);
                        }
                        if (data.errors.LateTimeBreak) {
                            var text=data.errors.LateTimeBreak[0];
                            text = text.replace("0", "fixed");
                            text = text.replace("1", "flexible");
                            $('#breaklatetime-error').html(text);
                        }
                        if (data.errors.LeaveEarlyTimeBreak) {
                            var text=data.errors.LeaveEarlyTimeBreak[0];
                            text = text.replace("0", "fixed");
                            text = text.replace("1", "flexible");
                            $('#breakleavearlytime-error').html(text);
                        }

                        if (data.errors.CheckInLateMinute) {
                            var text=data.errors.CheckInLateMinute[0];
                            text = text.replace("check", "punch");
                            $('#checkinlate-error').html(text);
                        }
                        if (data.errors.CheckOutEarlyMinute) {
                            var text=data.errors.CheckOutEarlyMinute[0];
                            text = text.replace("check", "punch");
                            $('#checkoutearly-error').html(text);
                        }
                        if (data.errors.NoCheckInMark) {
                            var text=data.errors.NoCheckInMark[0];
                            text = text.replace("check", "punch");
                            $('#nocheckin-error').html(text);
                        }
                        if (data.errors.NoCheckInMinute) {
                            var text=data.errors.NoCheckInMinute[0];
                            text = text.replace("2", "late");
                            text = text.replace("check", "punch");
                            $('#nocheckin-error').html(text);
                        }
                        if (data.errors.NoCheckOutMark) {
                            var text=data.errors.NoCheckOutMark[0];
                            text = text.replace("check", "punch");
                            $('#nocheckout-error').html(text);
                        }
                        if (data.errors.NoCheckOutMinute) {
                            var text=data.errors.NoCheckOutMinute[0];
                            text = text.replace("3", "early");
                            text = text.replace("check", "punch");
                            $('#nocheckout-error').html(text);
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
                    else if (data.overlapcnt) {
                        resetButton(button, action, optype);
                        toastrMessage('error',`The following shift or schedule assignment overlaps with an existing timetable. Please review and adjust the time range.</br>-------------------------</br>${data.overlapdata}`,"Error");
                    }
                    else if(data.success){
                        resetButton(button, action, optype);
                        if(parseInt(optype) == 2){
                            createTimetableInfoFn(data.rec_id);
                        }
                        if(action == "close"){
                            $("#inlineForm").modal('hide');
                        }
                        if(action == "new"){
                            resetTimetableFormFn();
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

        function timetableEditFn(recordId) { 
            resetTimetableFormFn();
            var scheduletimetable = 0;
            var attendancetimetable = 0;
            $.ajax({
                type: "get",
                url: "{{url('showtimetable')}}"+'/'+recordId,
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
                    scheduletimetable = data.cnt;
                    attendancetimetable = data.attcnt;

                    $.each(data.timetablelist, function(key, value) {
                        $("#recId").val(recordId);
                        $('#TimetableName').val(value.TimetableName);
                        $('#PunchingMethod').val(value.PunchingMethod).select2({minimumResultsForSearch: -1});
                        $('#BreakTimeAsWorkTime').val(value.BreakTimeAsWorkTime).select2({minimumResultsForSearch: -1});
                        $('#BreakTimeAsOvertime').val(value.BreakTimeAsOvertime).select2({minimumResultsForSearch: -1});
                        $('#EarlyCheckInOvertime').val(value.EarlyCheckInOvertime).select2({minimumResultsForSearch: -1});

                        flatpickr('#BeginningIn', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:"00:00",static:true});
                        flatpickr('#EndingOut', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:value.OffDutyTime,maxTime:endtimeval,static:true});
                        flatpickr('#OnDutyTime', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:"00:00",maxTime:endtimeval,static:true});
                        flatpickr('#OffDutyTime', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:value.OnDutyTime,maxTime:endtimeval,static:true});
                        
                        $("#OnDutyTime").val(value.OnDutyTime);
                        $("#OffDutyTime").val(value.OffDutyTime);
                        $("#WorkingHour").val(value.WorkTime);
                        $("#workhourduration").html(`Work Duration: ${value.WorkTime} Min`);
                        $("#LateTime").val(value.LateTime);
                        $("#LeaveEarlyTime").val(value.LeaveEarlyTime);
                        $("#BeginningIn").val(value.BeginningIn);
                        $("#EndingIn").val(value.EndingIn);
                        $("#BeginningOut").val(value.BeginningOut);
                        $("#EndingOut").val(value.EndingOut);
                        $('#isnightshift').prop('checked',value.is_night_shift == 1);
                        $("#OvertimeStart").val(value.OvertimeStart);
                        $('#BreakHourType').val(value.BreakHourFlag).select2({minimumResultsForSearch: -1});
                        $("#BreakStartTime").val(value.BreakStartTime);
                        $("#BreakEndTime").val(value.BreakEndTime);
                        $("#BreakHour").val(value.BreakHour);
                        $("#LateTimeBreak").val(value.LateTimeBreak);
                        $("#LeaveEarlyTimeBreak").val(value.LeaveEarlyTimeBreak);
                        $("#CheckInLateMinute").val(value.CheckInLateMinute);
                        $("#CheckOutEarlyMinute").val(value.CheckOutEarlyMinute)
                        $('#NoCheckInMark').val(value.NoCheckInFlag).select2({minimumResultsForSearch: -1});
                        $('#NoCheckOutMark').val(value.NoCheckOutFlag).select2({minimumResultsForSearch: -1});
                        $("#NoCheckInMinute").val(value.NoCheckInMinute);
                        $("#NoCheckOutMinute").val(value.NoCheckOutMinute);
                        $("#TimetableColor").val(value.TimetableColor);
                        $("#Description").val(value.Description);
                        $('#status').val(value.Status).select2({minimumResultsForSearch: -1});

                        $('#TimeEditFlag').val("0");

                        if(parseInt(value.PunchingMethod)==2){
                            $('.breaktimesection').hide();
                            $('#breakDurationDiv').show();
                            $('#breakHourTypeDiv').hide();
                            $('#BreakHour').prop("readonly",false);
                            $('#BreakHour').css("background","white");
                        }

                        else if(parseInt(value.PunchingMethod)==4){
                            $('.breaktimesection').show();
                            $('#breakDurationDiv').show();
                            $('#breakHourTypeDiv').show();

                            if(parseInt(value.BreakHourFlag) == 0){
                                $('.breaktypehourcls').show();
                                $('#BreakHour').prop("readonly",true);
                                $('#BreakHour').css("background","#efefef");
                            }
                            else if(parseInt(value.BreakHourFlag) == 1){
                                $('.breaktypehourcls').hide();
                                $('#BreakHour').prop("readonly",false);
                                $('#BreakHour').css("background","#ffffff");
                            }
                        }
                
                        flatpickr('#EndingIn', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:value.OnDutyTime,maxTime:value.OffDutyTime,defaultDate:value.EndingIn,static:true});
                        flatpickr('#BeginningOut', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:value.EndingIn,maxTime:value.OffDutyTime,defaultDate:value.BeginningOut,static:true});
                        flatpickr('#OvertimeStart', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:value.OffDutyTime,maxTime:endtimeval,defaultDate:value.OvertimeStart,static:true});
                        flatpickr('#BreakStartTime', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:value.OnDutyTime,maxTime:value.OffDutyTime,defaultDate:value.BreakStartTime,static:true});
                        flatpickr('#BreakEndTime', {clickOpens:true,enableTime:true,clickOpens:true,noCalendar:true,time_24hr: true,dateFormat:'H:i',minTime:value.BreakStartTime,maxTime:value.OffDutyTime,defaultDate:value.BreakEndTime,static:true});
                    });
                },
            });

            $("#modaltitle").html("Edit Timetable");
            $("#operationtypes").val(2);
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').hide();
            $("#inlineForm").modal('show'); 
        }

        function timetableInfoFn(recordId){
            createTimetableInfoFn(recordId);
            $("#informationmodal").modal('show');
        }

        function createTimetableInfoFn(recordId){ 
            var action_log = "";
            var action_links = "";
            var lidata = "";

            $.ajax({
                type: "get",
                url: "{{url('showtimetable')}}"+'/'+recordId,
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
                    $.each(data.timetablelist, function(key, value) {
                        $("#timetablenamelbl").html(value.TimetableName);
                        $("#punchingmethodlbl").html(value.PunchingMethods);
                        $("#breaktimeworktimelbl").html(value.BreakTimeAsWorkTime == 1 ? "Enabled" : "Disabled");
                        $("#breaktimeovertimelbl").html(value.BreakTimeAsOvertime == 1 ? "Enabled" : "Disabled");
                        $("#earlycheckinlbl").html(value.EarlyCheckInOvertimes == 1 ? "Enabled" : "Disabled");
                        $("#progressbarinfo").empty();
                        $("#progressbarinfo").append('<div class="container" style="margin-left:-15px;"><div class="progress" style="height:20px;"><div class="progress-bar" role="progressbar" style="width:100%; background-color:'+value.TimetableColor+' !important;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div>');
                        
                        $("#ondutytimelbl").html(value.OnDutyTime);
                        $("#offdutytimelbl").html(value.OffDutyTime);
                        $("#workhourdurationlbl").html(value.WorkTime+" Minute");
                        $("#latetimelbl").html(value.LateTime+" Minute");
                        $("#leavearlytimelbl").html(value.LeaveEarlyTime+" Minute");
                        $("#beginninginlbl").html(value.BeginningIn);
                        $("#endinginlbl").html(value.EndingIn);
                        $("#beginningoutlbl").html(value.BeginningOut);
                        $("#endingoutlbl").html(value.EndingOut);
                        $("#isnightshiftlbl").html(value.is_night_shift == 1 ? "Yes" : "No");
                        $("#overtimestartlbl").html(value.OvertimeStart);
                        $("#breakstartimelbl").html(value.BreakStartTime);
                        $("#breakendtimelbl").html(value.BreakEndTime);

                        $("#breakhourtypelbl").html(value.BreakHourType);
                        $("#latetimebreaklbl").html(parseInt(value.LateTimeBreak)>0 ? value.LateTimeBreak+" Minute" : "");
                        $("#leaveearlytimebreak").html(parseInt(value.LeaveEarlyTimeBreak)>0 ? value.LeaveEarlyTimeBreak+" Minute" : "");

                        let brtime = value.BreakStartTime;
                        let hhmm = brtime != null ? "<i>Hour:Minute</i>":"";
                        $("#breakhourdurationlbl").html(parseInt(value.BreakHour)>0 ? value.BreakHour+" Minute" : "");

                        $("#checkinlatelbl").html((value.CheckInLateMinute == null || value.CheckInLateMinute === null) ? "" : value.CheckInLateMinute+" Minute Count as Absent");
                        $("#checkoutearlylbl").html((value.CheckOutEarlyMinute == null || value.CheckOutEarlyMinute === null) ? "" : value.CheckOutEarlyMinute+" Minute Count as Absent");

                        let nocheckinmin = value.NoCheckInFlag==2 ? value.NoCheckInMinute+" Minute" :"";
                        $("#nocheckinmarklbl").html(value.NoCheckInFlags+" "+nocheckinmin);

                        let nocheckoutmin = value.NoCheckOutFlag==3 ? value.NoCheckOutMinute+" Minute" :"";
                        $("#nocheckoutmarklbl").html(value.NoCheckOutFlags+" "+nocheckoutmin);

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
                            <a class="dropdown-item viewTimetableAction" onclick="viewTimetableFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Timetable-Edit")
                        <li>
                            <a class="dropdown-item timetableEdit" onclick="timetableEditFn(${recordId})" data-id="editlinkbtn${recordId}" id="editlinkbtn${recordId}" title="Open timetable edit form">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Timetable-Delete")
                        <li>
                            <a class="dropdown-item timetableDelete" onclick="timetableDeleteFn(${recordId})" data-id="deletelinkbtn${recordId}" id="deletelinkbtn${recordId}" title="Open timetable delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan
                    `;

                    $("#timetable_action_ul").empty().append(action_links);
                }
            });  
        }

        function viewTimetableFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function timetableDeleteFn(recordId) {  
            $.ajax({
                type: "get",
                url: "{{url('showtimetable')}}"+'/'+recordId,
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
                    if(parseInt(data.cnt) == 0 && parseInt(data.attcnt) == 0 && parseInt(data.shiftcnt) == 0){
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
                                deleteTimetableFn(recordId);
                            }
                            else if (result.dismiss === Swal.DismissReason.cancel) {}
                        });
                    }
                    else if(parseInt(data.cnt) > 0 || parseInt(data.attcnt) > 0 || parseInt(data.shiftcnt) > 0){
                        toastrMessage('error',"You cannot delete the timetable because schedules are created based on it","Error");
                    }
                },
            });
        }

        function deleteTimetableFn(recordId){
            var delform = $("#InformationForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deletetimetable',
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

        function timeTableFn() {
            $('#name-error').html("");
        }

        function punchingMethodFn() {
            var punchmethod=$("#PunchingMethod").val();
            var onduty=$("#OnDutyTime").val();
            var offduty=$('#OffDutyTime').val();

            if(parseInt(punchmethod)==2){
                $('.breaktimesection').show();
                $('.breaktimeprop').hide();
                $('#breakDurationDiv').show();
                $('#breakHourTypeDiv').hide();

                $('#BreakHour').prop("readonly",false);
                $('#BreakHour').val("");
                $('#BreakHour').css("background","white");

            }
            else if(parseInt(punchmethod)==4){
                $('.breaktimeprop').show();
                $('.breaktimesection').show();
                $('#breakHourTypeDiv').show();
                $('#BreakHour').prop("readonly",true);
                $('#BreakHour').css("background","#efefef");
                $('.breaktimevals').val('');
            }
            $('.breaktimeerr').html("");
            
            $('#WorkingHour').val((getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) <= 0 ? 0 : (getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)));
            $('#workhourduration').html((getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) <= 0 ? "" : "Work Duration: "+(getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) + " Min");
            $('#punchingmethod-error').html("");
        }

        function breakHourTypeFn() {
            var breakhr=$("#BreakHourType").val();
            $('.breaktimeerr').html("");
            $('.breaktimevals').val('');
            $('#breakDurationDiv').show();
            if(parseInt(breakhr) == 0){
                $('.breaktypehourcls').show();
                $('#BreakHour').prop("readonly",true);
                $('#BreakHour').css("background","#efefef");
            }
            else if(parseInt(breakhr) == 1){
                $('.breaktypehourcls').hide();
                $('#BreakHour').prop("readonly",false);
                $('#BreakHour').css("background","#ffffff");
            }
            $('#breakhourtype-error').html("");
        }

        function breakTimeWtimeFn() {
            $('#breaktimecalc-error').html("");
            checkBreakTimeValidation(1);
        }

        function breakTimeOtimeFn() {
            $('#breaktimeot-error').html("");
            checkBreakTimeValidation(2);
        }

        function checkBreakTimeValidation(flg){
            var breakaswt = $('#BreakTimeAsWorkTime').val();
            var breakasot = $('#BreakTimeAsOvertime').val();

            if(breakaswt == 1 && breakasot == 1){
                if(flg == 1){
                    $('#breaktimecalc-error').html("Can not be Enable with Break Time as Overtime");
                    $('#BreakTimeAsWorkTime').val(null).select2({
                        placeholder:"Select value here",
                        minimumResultsForSearch: -1
                    });
                }
                if(flg == 2){
                    $('#breaktimeot-error').html("Can not be Enable with Break Time as Work Time");
                    $('#BreakTimeAsOvertime').val(null).select2({
                        placeholder:"Select value here",
                        minimumResultsForSearch: -1
                    });
                }
                toastrMessage('error',"<b>Break Time as Work Time</b> AND <b>Break Time as Overtime</b> can not be set to <b>Enable</b> at the same time","Error");
            }
        }

        function earlyCheckInCalcFn() {
            $('#earlycheckin-error').html("");
        }

        function ondutyTimeFn() {
            var onduty=$("#OnDutyTime").val();
            var timeditflg=$("#TimeEditFlag").val()||0;

            flatpickr('#EndingIn', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:onduty,static:true});
            $('#EndingIn').prop("disabled",false);

            $('#ondutytime-error').html("");
        }

        function offdutyTimeFn() {
            var onduty=$("#OnDutyTime").val();
            var offduty=$("#OffDutyTime").val();
            var timeditflg=$("#TimeEditFlag").val()||0;
            var breakhr=$("#BreakHour").val()||0;
            var endingin=$("#EndingIn").val();

            if(parseInt(timeditflg)==0){
                flatpickr('#EndingOut', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:offduty,maxTime:endtimeval,static:true});
                $('#EndingOut').prop("disabled",false);
            }

            flatpickr('#OvertimeStart', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:offduty,maxTime:endtimeval,static:true});
            $('#OvertimeStart').prop("disabled",false);
            
            $('#WorkingHour').val((getTimeDifference(onduty,offduty) - parseFloat(breakhr)) <= 0 ? 0 : (getTimeDifference(onduty,offduty) - parseFloat(breakhr)));
            $('#workhourduration').html((getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) <= 0 ? "" : "Work Duration: "+(getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) + " Min");
            $('#offdutytime-error').html("");
        }

        function lateTimeFn() {
            $('#latetime-error').html("");
        }

        function leaveEarlyFn() {
            $('#leavearlytime-error').html("");
        }

        function beginningInFn() {
            var onduty=$("#OnDutyTime").val();
            var offduty=$("#OffDutyTime").val();
            var beginningin=$("#BeginningIn").val();
            flatpickr('#OnDutyTime', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:beginningin,static:true});
            $('#OnDutyTime').prop("disabled",false);
            $('#beginnngin-error').html("");
        }

        function endingInFn() {
            var endingin=$("#EndingIn").val();
            var offduty=$("#OffDutyTime").val();
            var onduty=$("#OnDutyTime").val();
            var beginningOut=$("#BeginningOut").val();

            flatpickr('#BeginningOut', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:endingin,static:true});
            $('#BeginningOut').prop("disabled",false);

            flatpickr('#BreakStartTime', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:endingin,maxTime:beginningOut,static:true});
            $('#BreakStartTime').prop("disabled",false);

            $('#endingin-error').html("");
        }

        function beginningOutFn() {
            var beginningOut=$("#BeginningOut").val();

            flatpickr('#OffDutyTime', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:beginningOut,static:true});
            $('#OffDutyTime').prop("disabled",false);
            $('#beginnngout-error').html("");
        }

        function endingOutFn() {
            $('#endingout-error').html("");
        }

        function overtimeStFn() {
            $('#overtimestart-error').html("");
        }

        function clearOtTime() {
            var offduty=$("#OffDutyTime").val();
            flatpickr('#OvertimeStart', {clickOpens:true,enableTime:true,clickOpens:true,noCalendar:true,time_24hr: true,dateFormat:'H:i',minTime:offduty,maxTime:endtimeval,defaultHour:""});
            $('#OvertimeStart').val("");
        }

        function breakStartTimeFn(){
            var onduty=$("#OnDutyTime").val();
            var offduty=$('#OffDutyTime').val();
            var breakstime=$('#BreakStartTime').val();
            var bentime=$('#BreakEndTime').val();
            var beginningOut=$("#BeginningOut").val();

            flatpickr('#BreakEndTime', {clickOpens:true,enableTime:true,clickOpens:true,noCalendar:true,time_24hr: true,dateFormat:'H:i',minTime:breakstime,maxTime:beginningOut});
            $('#BreakEndTime').prop("disabled",false);
            
            $('#BreakHour').val(getTimeDifference(eastime,bentime) <= 0 ? 0 : getTimeDifference(eastime,bentime));
            $('#WorkingHour').val((getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) <= 0 ? 0 : (getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)));
            $('#workhourduration').html((getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) <= 0 ? "" : "Work Duration: "+(getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) + " Min");
            $('#breakstarttime-error').html("");
        }

        function breakEndTimeFn(){
            var onduty=$("#OnDutyTime").val();
            var offduty=$('#OffDutyTime').val();
            var eastime=$('#BreakStartTime').val();
            var bentime=$('#BreakEndTime').val();
           
            $('#BreakHour').val(getTimeDifference(eastime,bentime) <= 0 ? 0 : getTimeDifference(eastime,bentime));
            $('#WorkingHour').val((getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) <= 0 ? 0 : (getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)));
            $('#workhourduration').html((getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) <= 0 ? "" : "Work Duration: "+(getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) + " Min");
            $('#breakendtime-error').html("");
        }

        function clearBrStartTimeFn() {
            var onduty=$("#OnDutyTime").val();
            var offduty=$("#OffDutyTime").val();
            flatpickr('#BreakStartTime', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:onduty,maxTime:offduty,static:true});
            $("#BreakStartTime").val("");
            $('#BreakHour').val("");
        }

        function clearBrEndTimeFn() {
            var offduty=$('#OffDutyTime').val();
            var breakstime=$('#BreakStartTime').val();

            flatpickr('#BreakEndTime', {clickOpens:true,enableTime:true,clickOpens:true,noCalendar:true,time_24hr: true,dateFormat:'H:i',minTime:breakstime,maxTime:offduty});
            $("#BreakEndTime").val("");
            $('#BreakHour').val("");
        }

        function checkinLateFn() {
            $('#checkinlate-error').html("");
        }

        function checkOutEarlyFn() {
            $('#checkoutearly-error').html("");
        }

        function noCheckInMarkFn() {
            var nocheckinval=$('#NoCheckInMark').val();
            if(parseInt(nocheckinval)==1){
                $('.lateprop').hide();
            }
            else if(parseInt(nocheckinval)==2){
                $('.lateprop').show();
            }
            $('#nocheckin-error').html("");
        }

        function noCheckInFn() {
            $('#nocheckin-error').html("");
        }

        function breakHourDurFn() {
            var onduty = $("#OnDutyTime").val();
            var offduty = $('#OffDutyTime').val();
            $('#WorkingHour').val((getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) <= 0 ? 0 : (getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)));
            $('#workhourduration').html((getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) <= 0 ? "" : "Work Duration: "+(getTimeDifference(onduty,offduty) - parseFloat($('#BreakHour').val()||0)) + " Min");
            $('#breakhour-error').html("");
        }

        function breaklateTimeFn() {
            $('#breaklatetime-error').html("");
        }

        function breakleaveEarlyFn() {
            $('#breakleavearlytime-error').html("");
        }

        function noCheckOutMarkFn() {
            var nochekout=$('#NoCheckOutMark').val();
            if(parseInt(nochekout)==1){
                $('.earlyprop').hide();
            }
            else if(parseInt(nochekout)==3){
                $('.earlyprop').show();
            }
            $('#nocheckout-error').html("");
        }

        function noCheckOutFn() {
            $('#nocheckout-error').html("");
        }

        function descriptionfn() {
            $('#description-error').html("");
        }

        function statusFn() {
            $('#status-error').html("");
        }

        function resetTimetableFormFn(){
            $('.mainforminp').val("");
            $('.reg_form').val("");
            $('.errordatalabel').html("");
            $('#status').val("Active").select2({minimumResultsForSearch: -1});
            $('#PunchingMethod').val(null).select2({
                placeholder:"Select punching mode here",
                minimumResultsForSearch: -1
            });
            $('#BreakHourType').val(null).select2({
                placeholder:"Select break hour type here",
                minimumResultsForSearch: -1
            });
            $('#BreakTimeAsWorkTime').val(null).select2({
                placeholder:"Select value here",
                minimumResultsForSearch: -1
            });
            $('#BreakTimeAsOvertime').val(null).select2({
                placeholder:"Select value here",
                minimumResultsForSearch: -1
            });
            $('#EarlyCheckInOvertime').val(null).select2({
                placeholder:"Select value here",
                minimumResultsForSearch: -1
            });
            $('#NoCheckInMark').val(1).select2({minimumResultsForSearch: -1});
            $('#NoCheckOutMark').val(1).select2({minimumResultsForSearch: -1});

            flatpickr('#BeginningIn', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:"00:00",maxTime:endtimeval,defaultDate:"00:00", defaultMinute: 0,static:true});
            var randomColor = colors[Math.floor(Math.random() * colors.length)];
            $('#TimetableColor').val(randomColor);
            flatpickr('.distime', {clickOpens:false});

            $('.latearlyprop').hide();
            $('.breaktypehourcls').hide();

            $('#BreakHour').prop("readonly",false);
            $('#isnightshift').prop('checked',false);
            $('#BreakHour').css("background","#ffffff");

            $('#savebutton').text('Save & Close');
            $('#savebutton').prop("disabled",false);
            $('#savebutton').show();

            $('#savenewbutton').text('Save & New');
            $('#savenewbutton').prop("disabled",false);
            $('#savenewbutton').show();

            $('#operationtypes').val(1);
            $('#TimeEditFlag').val(0);

            $('.breaktimesection').show();
            $('.breaktimeprop').hide();
            $('#breakDurationDiv').show();
            $('#breakHourTypeDiv').hide();

            $("#modaltitle").html("Add Timetable");
        }

        function getTimeDifference(startTime, endTime) {
            let start = new Date("1970-01-01 " + startTime); // Set a base date
            let end = new Date("1970-01-01 " + endTime);

            let difference = (end - start) / (1000 * 60); // Convert milliseconds to minutes
            return difference;
        }

        function refreshTimetableDataFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }
    </script>
@endsection
