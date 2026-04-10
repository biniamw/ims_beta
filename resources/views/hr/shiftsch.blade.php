@extends('layout.app1')

@section('title')
@endsection
@section('content')
    @can('Shift-Schedule-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Schedule Assignment</h3>
                            <div class="row" style="position: absolute;left: 270px;top: 80px;width:50%;z-index: 10;display:none" id="filter_div">
                                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                                    <select class="selectpicker form-control dropdownclass" id="BranchFilter" name="BranchFilter" title="Select Branch here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true">
                                        @foreach ($branchfilter as $branchfilter)
                                            <option selected value="{{$branchfilter->BranchName}}">{{$branchfilter->BranchName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                                    <select class="selectpicker form-control dropdownclass" id="DepartmentFilter" name="DepartmentFilter" title="Select Department here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true">
                                        @foreach ($departmentfilter as $departmentfilter)
                                            <option selected value="{{$departmentfilter->DepartmentName}}">{{$departmentfilter->DepartmentName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div style="width:99%; margin-left:0.5%;">
                                <div id="main-datatable" style="display:none;">
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display:none;"></th>
                                                <th style="width:3%;">#</th>
                                                <th style="width:5%;">Photo</th>
                                                <th style="width:8%;">Employee ID</th>
                                                <th style="width:15%;">Full Name</th>
                                                <th style="width:6%;">Gender</th>
                                                <th style="width:8%;">Branch</th>
                                                <th style="width:9%;">Department</th>
                                                <th style="width:9%;">Position</th>
                                                <th style="width:9%;">Shifts</th>
                                                <th style="width:9%;">Employment Type</th>
                                                <th style="width:9%;">Assignment Type</th>
                                                <th style="width:6%;">Status</th>
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
            </div>
        </section>
        <input type="hidden" class="form-control" id="currentdayval" name="currentdayval" readonly="readonly" value="{{$currentdate}}"/>
    </div>
    @endcan

    <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle">Manage Schedule Assignment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                    
                    </div>
                    <div class="modal-footer">
                        
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
    <!--Start Information Modal -->
    <div class="modal fade" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Schedule Assignment Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="employeetopname"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-6 col-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Employee & Other Information</span>
                                                        <div id="employeetopnameA" style="font-weight: bold;font-size:15px;"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                        <div class="row ml-1 mb-1">
                                                            <div class="col-lg-9 col-md-8 col-xl-9 col-sm-8">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-lg-7 col-md-6 col-xl-7 col-sm-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                                <table style="width: 100%;">
                                                                                    <tr>
                                                                                        <th colspan="3" style="text-align: left">
                                                                                            <label id="employeeeinfotitle" style="font-size: 16px;font-weight:bold;">Employee Information</label>
                                                                                        </th>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td rowspan="8">
                                                                                            <div class="avatar-upload" style="padding:0px;margin:2px;">
                                                                                                <div class="avatar-edit">
                                                                                                </div>
                                                                                                <div class="avatar-preview" style="width: 150px;height:150px;">
                                                                                                    <img id="infoActualImage" src="../../../storage/uploads/HrEmployee/dummypic.jpg">
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 22%"><label style="font-size: 14px;">Employee ID</label></td>
                                                                                        <td style="width: 48%"><label id="employeeidlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Employee Name</label></td>
                                                                                        <td><label id="employeenamelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Department</label></td>
                                                                                        <td><label id="departmentLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Position</label></td>
                                                                                        <td><label id="positionLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Branch</label></td>
                                                                                        <td><label id="brancnLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Gender</label></td>
                                                                                        <td><label id="genderLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Employment Type</label></td>
                                                                                        <td><label id="employementTypeLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <div class="col-lg-5 col-md-6 col-xl-5 col-sm-6">
                                                                                <table style="width: 100%;">
                                                                                    <tr>
                                                                                        <th colspan="2" style="text-align: left">
                                                                                            <label id="shiftandsch" style="font-size: 16px;font-weight:bold;">Date Information</label>
                                                                                        </th>
                                                                                    </tr>
                                                                                   
                                                                                    <tr>
                                                                                        <td style="width: 30%"><label style="font-size: 14px;">Valid Date</label></td>
                                                                                        <td style="width: 70%"><label id="validdatelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-4 col-xl-3 col-sm-4">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <hr class="mb-0"/>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" id="detScheduleDiv">
                                    <table id="shiftscheduledetailtbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width:3%;">#</th>
                                                <th style="width:11%;">Assignment Type</th>
                                                <th style="width:10%;">Schedule Type</th>
                                                <th style="width:11%;">Shift Name</th>
                                                <th style="width:12%;">Valid Date</th>
                                                <th style="width:10%;">Check-In Required</th>
                                                <th style="width:10%;">Check-Out Required</th>
                                                <th style="width:10%;">Scheduled on Holidays</th>
                                                <th style="width:10%;">Effective Overtime</th>
                                                <th style="width:9%;">Status</th>
                                                <th style="width:4%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12" style="display: none;">
                                    <table id="shiftdetailtbl" class="mb-0 rtable" style="width:100%;">  
                                        <thead style="font-size: 13px;">
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
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Information Modal -->

    <!--Start delete modal -->
    <div class="modal fade text-left" id="deletemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm">
                    @csrf
                    <div class="modal-body" style="background-color:#e74a3b">
                        <label style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this holiday?</label>
                        <div class="form-group">
                            <input type="hidden"  class="form-control" name="delRecId" id="delRecId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deleterecbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End delete modal -->

    <!--Start timetable delete modal -->
    <div class="modal fade text-left" id="timetableremovemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletetimeform">
                    @csrf
                    <div class="modal-body" style="background-color:#e74a3b">
                        <label id="timetableremlbl" style="font-size: 16px;color:white;"></label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="timeTblId" id="timeTblId" readonly="true">
                            <input type="hidden" class="form-control" name="timeRowId" id="timeRowId" readonly="true">
                            <input type="hidden" class="form-control" name="timeTdIndex" id="timeTdIndex" readonly="true">
                            <input type="hidden" class="form-control" name="timeColspanVal" id="timeColspanVal" readonly="true">
                            <input type="hidden" class="form-control" name="timeNameVal" id="timeNameVal" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="timetablerembtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonp" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End timetable delete modal -->

    <!-- start shift schedule detail info modal-->
    <div class="modal modal-slide-in event-sidebar fade" id="shiftdetailinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <form id="ShiftScheduleDetailForm">    
            <div class="modal-dialog sidebar-xl" style="width: 60%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeScheduleDetailFn()" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h4 class="modal-title">Schedule Assignment Detail Information</h4>
                        <div style="text-align: center;padding-right:30px;" id="scheduleDetStatus"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                       <div class="row">
                            <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12">
                                <section id="collapsible">
                                    <div class="card collapse-icon">
                                        <div class="collapse-default">
                                            <div class="card">
                                                <div id="headingCollapse2" class="card-header" data-toggle="collapse" role="button" data-target=".infoschdet" aria-expanded="false" aria-controls="collapse1">
                                                    <span class="lead collapse-title">Shift, Schedule & Action Information</span>
                                                    <div id="shiftScheduleTitle" style="font-weight: bold;font-size:15px;"></div>
                                                </div>
                                                <div id="collapse2" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse infoschdet">
                                                    <div class="row ml-1 mb-1">
                                                        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6">
                                                            <table style="width: 100%;">
                                                                <tr>
                                                                    <th colspan="2" style="text-align: left">
                                                                        <label id="shiftandschlbl" style="font-size: 15px;font-weight:bold;">Shift & Schedule Information</label>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 14px;">Assignment Type</label></td>
                                                                    <td><label id="assignmentTypeLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 14px;">Schedule Type</label></td>
                                                                    <td><label id="scheduleTypeLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 45%"><label style="font-size: 14px;">Shift Name</label></td>
                                                                    <td style="width: 55%"><label id="shiftnamelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 14px;">Valid Date</label></td>
                                                                    <td><label id="validdatelbldet" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 14px;">Check-In not Required</label></td>
                                                                    <td><label id="checkinnotreqlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 14px;">Check-In not Required</label></td>
                                                                    <td><label id="checkoutnotreqlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 14px;">Scheduled on Holidays</label></td>
                                                                    <td><label id="schholidaylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 14px;">Effective Overtime</label></td>
                                                                    <td><label id="effectiveotlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <table style="width: 100%;" id="indInfoTbl">
                                                                <tr>
                                                                    <th colspan="2" style="text-align: left">
                                                                        <label id="indvassignmentlbl" style="font-size: 15px;font-weight:bold;"></label>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 45%"><label style="font-size: 14px;">Cycle Number</label></td>
                                                                    <td style="width: 45%"><label id="indCycleNumberLbl" class="indinfolbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 14px;">Cycle Unit</label></td>
                                                                    <td><label id="indCycleUnitLbl" class="indinfolbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 14px;">Description</label></td>
                                                                    <td><label id="indDescriptionLbl" class="indinfolbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                                            <label id="actioninformationtitle" style="font-size: 15px;font-weight:bold;">Action Information</label>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:13rem">
                                                                <ul id="actiondiv" class="timeline mb-0 mt-0"></ul>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <hr class="m-1"/>
                        <div class="row mb-1">
                            <div class="col-lg-2 col-md-2 col-xl-2 col-sm-2"></div>
                            <div class="col-lg-8 col-md-8 col-xl-8 col-sm-8">
                                <div class="form-group">
                                    <label style="font-size: 12px;font-weight:bold;">Month(s)</label>
                                    <div>
                                        <select class="select2 form-control" name="Month[]" id="Month" multiple onchange="fetchTimetableData()"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xl-2 col-sm-2"></div>
                            <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12 scrdivhor scrollhor" id="timetableDiv" style="overflow-y: scroll;height:30rem">
                                <div class="table-responsive">
                                    <table id="timetableinfotbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width:4%;">#</th>
                                                <th style="width:21%;">Days</th>
                                                <th style="width:75%;">Timetable(s)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
            
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="currentDateVal" id="currentDateVal" readonly="true"/>
                        <input type="hidden" class="form-control" name="employeeIdShiftDet" id="employeeIdShiftDet" readonly="true"/>
                        <input type="hidden" class="form-control" name="validStartDate" id="validStartDate" readonly="true"/>
                        <input type="hidden" class="form-control" name="validEndDate" id="validEndDate" readonly="true"/>
                        <input type="hidden" class="form-control" name="shiftDetailIdVal" id="shiftDetailIdVal" readonly="true"/>
                        <button id="closebuttonsdet" type="button" class="btn btn-danger" onclick="closeScheduleDetailFn()" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end shift schedule detail info modal-->

    <!-- start assignment form modal-->
    <div class="modal fade text-left" id="indinlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="assignmentTitle"></h4>
                    <div class="row">
                        <div style="text-align: right" id="scstatusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeAssignmentFn()"> <span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="IndRegister">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-md-6 col-lg-4 col-sm-12">
                                <label style="font-size: 14px;">Assignment Type</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control AssignmentType" name="AssignmentType" id="AssignmentType">
                                    <option value="2">Individual Assignment</option>
                                    <option value="1">Group Assignment</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="assignmenttype-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-md-6 col-lg-4 col-sm-12">
                                <label style="font-size: 14px;">Schedule Type</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control ScheduleType" name="ScheduleType" id="ScheduleType">
                                    <option value="1">Permanent</option>
                                    <option value="2">Temporary</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="scheduletype-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                        </div>

                        <hr class="m-1">
                        <div class="row assprop indclass">
                            <div class="col-xl-4 col-md-6 col-lg-4 col-sm-12">
                                <label style="font-size: 14px;">Employee Name</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control EmployeeName" name="EmployeeName[]" id="EmployeeName" multiple onchange="employeeNameFn()"></select>
                                <span class="text-danger">
                                    <strong id="indemployeelist-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-md-6 col-lg-4 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <label style="font-size: 14px;">Valid Date</label><label style="color: red; font-size:16px;">*</label>
                                        <div>
                                            <input type="text" class="form-control" id="dateRange" name="dateRange" placeholder="YYYY-MM-DD to YYYY-MM-DD" readonly="readonly" onchange="dateRangeFn()" style="background-color:#FFFFFF" value=""/>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="inddate-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="row assignprop">
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input shiftrule" id="indcheckinnotreq" name="indcheckinnotreq" value="1">
                                            <label class="custom-control-label" for="indcheckinnotreq">  Check-In not Required</label>                                                
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input shiftrule" id="indcheckoutnotreq" name="indcheckoutnotreq" value="1">
                                            <label class="custom-control-label" for="indcheckoutnotreq">  Check-Out not Required</label>                                                
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input shiftrule" id="indscheduledholiday" name="indscheduledholiday" value="1">
                                            <label class="custom-control-label" for="indscheduledholiday">  Scheduled on Holidays</label>                                                
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input shiftrule" id="indeffectiveot" name="indeffectiveot" value="1">
                                            <label class="custom-control-label" for="indeffectiveot">  Effective Overtime</label>                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-lg-4 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1">
                                        <label style="font-size: 14px;">Cycle Number</label><label style="color: red; font-size:16px;">*</label>
                                        <select class="select2 form-control" name="CycleNumber" id="CycleNumber" onchange="cycleNumFn()">
                                            
                                        </select>
                                        <span class="text-danger">
                                            <strong id="cyclenum-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1">
                                        <label style="font-size: 14px;">Cycle Unit</label><label style="color: red; font-size:16px;">*</label>
                                        <select class="select2 form-control" name="CycleUnit" id="CycleUnit" onchange="cycleUnitFn()">
                                            <option value="1">Day</option>
                                            <option value="2">Month</option>
                                            <option value="3">Week</option>
                                        </select>
                                        <span class="text-danger">
                                            <strong id="cycleunit-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <label style="font-size: 14px;">Description</label>
                                        <textarea type="text" placeholder="Write Description here..." class="form-control" rows="2" name="Description" id="Description" onkeyup="descriptionfn()"></textarea>
                                        <span class="text-danger">
                                            <strong id="description-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" style="display: none;">
                                        <label style="font-size: 14px;">Status</label><label style="color: red; font-size:16px;">*</label>
                                        <select class="select2 form-control" name="status" id="status" onchange="statusfn()">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                        <span class="text-danger">
                                            <strong id="status-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            
                            <div class="col-xl-10 col-md-6 col-12"></div>
                            <div class="col-xl-2 col-md-6 col-12 mt-2" style="text-align: right;">
                                <button id="assigntime" type="button" class="btn btn-gradient-success btn-sm assigntime"><i class="fa fa-plus" aria-hidden="true"></i>  Assign Time</button></br>
                                <span class="text-danger">
                                    <strong id="assignbtn-error"></strong>
                                </span>
                            </div>
                        </div>
                        <hr class="m-1 assprop indclass">
                        <div class="row assprop indclass">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive">
                                    <span class="text-danger">
                                        <strong id="blanktable-error"></strong>
                                    </span></br>
                                    <table id="timetableassign" class="mb-0 rtable" style="width: 100%;">
                                        <thead style="font-size: 13px;">
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:17%;">Days</th>
                                                <th style="width:80%">Timetable(s)</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    
                                    <table id="dynamicTable" class="mb-0 rtable" style="width:100%;display:none;">  
                                        <thead style="font-size: 13px;">
                                            <tr>
                                                <th rowspan="2" style="width:3%;">#</th>
                                                <th rowspan="2">Days</th>
                                                <th colspan="6">Shift Times</th>
                                                <th colspan="3">Break Times</i></th>
                                                <th rowspan="2">Remark</th>
                                                <th rowspan="2">Status</th>
                                            </tr>
                                            <tr>
                                                <th>Early Start Time</th>
                                                <th>Start Time</th>
                                                <th>Late Start Time</th>
                                                <th>Early End Time</th>
                                                <th>End Time</th>
                                                <th>Late End Time</th>
                                                <th>Break Start Time</th>
                                                <th>Break End Time</th>
                                                <th>Break Hour</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row assprop grdclass">
                            <div class="col-xl-6 col-md-6 col-sm-12 mb-1" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                <label style="font-size: 14px;">Employee Name</label><label style="color: red; font-size:16px;">*</label>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <span class="text-danger">
                                            <strong id="employeelist-error" class="errordatalabel"></strong>
                                        </span>
                                        <div class="ml-1" id="selectallempdiv">
                                            <label style="font-size:14px;font-weight:bold;"><input class="hummingbird-end-node" style="width:17px;height:17px;accent-color:#7367f0;" id="selectalldep" class="selectalldep" type="checkbox"/>  Select All</label>
                                        </div>
                                        <div id="orgtree" class="hummingbird-treeview scrollhor" style="overflow-y: scroll;height:30rem;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 mb-1">
                                <div class="row assignprop">
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <label style="font-size: 14px;">Shift Name</label><label style="color: red; font-size:16px;">*</label>
                                        <select class="select2 form-control ShiftName" name="ShiftName[]" id="ShiftName" multiple onchange="shiftnamefn()">
                                            @foreach ($shift as $shift)
                                            <option value="{{$shift->id}}">{{$shift->ShiftName}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            <strong id="shiftname-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <label style="font-size: 14px;">Valid Date</label><label style="color: red; font-size:16px;">*</label>
                                        <div>
                                            <input type="text" class="form-control" id="datetimes" name="datetimes" placeholder="YYYY-MM-DD to YYYY-MM-DD" readonly="readonly" onchange="datetimefn()" style="background-color:#FFFFFF" value=""/>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="date-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="row assignprop">
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input shiftrule" id="checkinnotreq" name="checkinnotreq" value="1">
                                            <label class="custom-control-label" for="checkinnotreq">  Check-In not Required</label>                                                
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input shiftrule" id="checkoutnotreq" name="checkoutnotreq" value="1">
                                            <label class="custom-control-label" for="checkoutnotreq">  Check-Out not Required</label>                                                
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input shiftrule" id="scheduledholiday" name="scheduledholiday" value="1">
                                            <label class="custom-control-label" for="scheduledholiday">  Scheduled on Holidays</label>                                                
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input shiftrule" id="effectiveot" name="effectiveot" value="1">
                                            <label class="custom-control-label" for="effectiveot">  Effective Overtime</label>                                                
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control EmployeeNameDefault" name="EmployeeNameDefault[]" id="EmployeeNameDefault" multiple>
                                @foreach ($emplist as $emplist)
                                <option value="{{$emplist->id}}">{{$emplist->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" class="form-control" name="shiftScheduleDetail" id="shiftScheduleDetail" readonly="true"/>
                        <input type="hidden" class="form-control" name="selectedLength" id="selectedLength" readonly="true" value="0"/>
                        <input type="hidden" class="form-control" name="ShiftId" id="ShiftId" readonly="true" value="0"/>
                        <input type="hidden" class="form-control" name="ShiftEditFlag" id="ShiftEditFlag" readonly="true" value="0"/>
                        <input type="hidden" class="form-control" name="ShiftNameDefault" id="ShiftNameDefault" readonly="true" value="-"/>  
                        <input type="hidden" class="form-control" name="BegininngDate" id="BegininngDate" readonly="true" value=""/>    
                        <input type="hidden" class="form-control" name="checkFlag" id="checkFlag" readonly="true" value=""/>   
                        <input type="hidden" class="form-control" name="manageshift" id="manageshift" readonly="true" value="1"/>         
                        <input type="hidden" class="form-control" name="shiftoperationtypes" id="shiftoperationtypes" readonly="true"/>
                        <input type="hidden" class="form-control" name="recId" id="recId" readonly="true" value=""/>     
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        <button id="savebutton" type="button" class="btn btn-info assprop grdclass">Save</button>
                        <button id="savebuttonInd" type="button" class="btn btn-info assprop indclass">Save</button>
                        <button id="closebuttonAssignment" type="button" class="btn btn-danger" onclick="closeAssignmentFn()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--/ end assignment form modal-->

    <!--Start Time assignment Modal -->
    <div class="modal fade" id="timeassmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Time Assignment</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="AssignmentForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                <div class="divider">
                                    <div class="divider-text">Timetables</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
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
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="divider">
                                    <div class="divider-text">Shift Detail</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
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
                        <div style="display: none;">
                            <select class="select2 form-control" name="TimetableDefault" id="TimetableDefault">
                                <option selected disabled></option>
                                @foreach ($timetblist as $timetblist)
                                <option data-color="{{$timetblist->TimetableColor}}" title="{{$timetblist->NameWithTime}}" value="{{$timetblist->id}}">{{$timetblist->NameWithTime}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button id="assigntoshiftandnew" type="button" class="btn btn-info assignbtn">Assign & New</button>
                        <button id="assigntoshiftandclose" type="button" class="btn btn-info assignbtn">Assign & Close</button>
                        <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Time assignment Modal -->

    <!--Start Void Modal -->
    <div class="modal fade text-left" id="voidschedulemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="voidshiftscheduleform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label style="font-size: 16px;font-weight:bold;">Do you really want to void schedule?</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Reason</div>
                        </div>
                        <label style="font-size: 16px;"></label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                        <span class="text-danger">
                            <strong id="voidsch-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="voidschid" id="voidschid" readonly="true">
                        <button id="schedulevoidbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttonshvoid" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Modal -->

    <!--Start undo void modal -->
    <div class="modal fade text-left" id="undovoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="undovoidform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to undo void schedule?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="scheduleundovoidbtn" type="button" class="btn btn-info">Undo Void</button>
                        <button id="closebuttonshundovoid" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End undo void modal -->

    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var endtimeval = "23:59";
        var minuteinc = "30";
        var ctable = "";
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
        var timetableoverlap = [];
        var timetablealldata = {};
        var saveobjectdata = {};
        var inptime = {0:{name:'.',stime:'00:00',etime:'00:00',duration:'0',color:'#000000'}};
        rowinfodata = {startime:'00:00',endtimes:'00:00'};
        //rowallinfodata[0]={rowinfodata};
        var copiedval = {};
        var cycleChangeFlg = 0;
        $(function () {
            cardSection = $('#page-block');
        });

        var j = 0;
        var i = 0;
        var m = 0;
        var colorMap = {};
        var timeTableName = {};
        var regexPattern = '';
        
        $(document).ready( function () { 
            $("#main-datatable").hide();
            $('#filter_div').hide();
            ctable = $('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 1, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-7 left-dom'><'col-sm-12 col-md-3 custom-buttons'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                scrollY:'60vh',
                scrollX: true,
                scrollCollapse: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/empshiftlist',
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
                },
                columns: [
                    { data: 'id', name: 'id', 'visible': false},
                    { data:'DT_RowIndex',width:"3%"},
                    {
                        data: 'ActualPicture',
                        "render": function( data, type, row, meta) {
                            if(data != null || row.BiometricPicture != null){
                                return data != null ? '<div style="text-align:left;margin-left:-2%;width:70px;height:82px;"><img src="../../../storage/uploads/HrEmployee/'+data+'" alt="-" width="80px" height="80px"></div>'
                                : '<div style="text-align:left;margin-left:-2%;width:70px;height:82px;"><img src="../../../storage/uploads/BioEmployee/'+row.BiometricPicture+'" alt="-" width="80px" height="80px"></div>';
                            } 
                            if(data == null && row.BiometricPicture == null){
                                if(row.Gender=="Male"){
                                    return '<div style="text-align:left;margin-left:-2%;width:70px;height:82px;"><img src="../../../storage/uploads/HrEmployee/dummypic.jpg" alt="-" width="80px" height="80px"></div>';
                                }
                                if(row.Gender=="Female"){
                                    return '<div style="text-align:left;margin-left:-2%;width:70px;height:82px;"><img src="../../../storage/uploads/HrEmployee/dummypic.jpg" alt="-" width="80px" height="80px"></div>';
                                }   
                            }
                            
                        },
                        width:"5%"
                    },
                    { data: 'EmployeeID', name: 'EmployeeID',width:"8%"},
                    { data: 'name', name: 'name',width:"15%"},
                    { data: 'Gender', name: 'Gender', width:'6%'},
                    { data: 'BranchName', name: 'BranchName',width:"8%"},
                    { data: 'DepartmentName', name: 'DepartmentName',width:"9%"},
                    { data: 'PositionName', name: 'PositionName',width:"9%"},
                    { data: 'Shifts', name: 'Shifts',width:"9%"},
                    { data: 'EmploymentTypeName', name: 'EmploymentTypeName',width:"9%"},
                    { data: 'AssignmentType', name: 'AssignmentType',width:"9%"},
                    { data: 'Status', name: 'Status', 
                        "render": function ( data, type, row, meta ) {
                            if(data == "Active"){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else if(data == "Inactive"){
                                return '<span class="badge bg-danger bg-glow">'+data+'</span>';
                            }
                            else{
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                        },
                        width:"6%"
                    },
                    { data: 'action', name: 'action',width:"4%"}
                ],
                "initComplete": function () {
                    $('.custom-buttons').html(`
                        @can('Shift-Schedule-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addAssignment" id="addAssignment">Add</button>
                        @endcan
                    `);
                },
                columnDefs: [  
                    {
                        targets: 13,
                        createdCell: function(td) {
                            $(td).css("text-align", "center");
                        }
                    }
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
                    $("#main-datatable").show();
                    $('#filter_div').show();
                },
            });
        });

        $(document).ready(function () {
            // $('#BegininngDate').daterangepicker({ 
            //     singleDatePicker: true,
            //     showDropdowns: true,
            //     autoApply:true,
            //     locale: {
            //         format: 'YYYY-MM-DD'
            //     }
            // });
            // $('#BegininngDate').val("");


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

        $('#BranchFilter').change(function(){
            var selected = $('#BranchFilter option:selected');
            var search = [];

            // Collect selected option values
            $.each(selected, function() {
                search.push($(this).val());
            });

            if (search.length === 0) {
                // No option selected: force DataTable to return no data
                ctable.column(6).search('^$', true, false).draw(); // Match an impossible pattern
            } else {
                // Options selected: build regex for filtering
                var searchRegex = search.join('|'); // OR-separated values for regex
                ctable.column(6).search(searchRegex, true, false).draw();
            }
        });

        $('#DepartmentFilter').change(function(){
            var selected = $('#DepartmentFilter option:selected');
            var search = [];

            // Collect selected option values
            $.each(selected, function() {
                search.push($(this).val());
            });

            if (search.length === 0) {
                // No option selected: force DataTable to return no data
                ctable.column(7).search('^$', true, false).draw(); // Match an impossible pattern
            } else {
                // Options selected: build regex for filtering
                var searchRegex = search.join('|'); // OR-separated values for regex
                ctable.column(7).search(searchRegex, true, false).draw();
            }
        });

        $('#selectalldep').change(function() {
            if($(this).is(":checked")) {
                $('.depheader').prop('checked', true);
                $('.emptree').prop('checked', true); 
            }
            else{
                $('.depheader').prop('checked', false);
                $('.emptree').prop('checked', false);
            }
            $('#employeelist-error').html("");
        });

        $('#selectallemp').change(function() {
            if($(this).is(":checked")) {
                $('.depheader').prop('checked', true);
                $('.emptree').prop('checked', true); 
            }
            else{
                $('.depheader').prop('checked', false);
                $('.emptree').prop('checked', false);
            }
            $('#indemployeelist-error').html("");
        });

        $(document).on('click', '.depheader', function(){
            var currentind=$(this).attr('id');
            var depnameid = currentind.split("_");
            var idval=depnameid[1];
            if($(this).is(":checked")) {
                $('.department_'+idval).prop('checked', true); 

                var allemp=$('.emptree').length;
                var checkedemp=$('.emptree:checked').length;

                var alldep=$('.depheader').length;
                var checkeddep=$('.depheader:checked').length;

                if(parseInt(allemp)==parseInt(checkedemp) && parseInt(alldep)==parseInt(checkeddep)){
                    $('#selectalldep').prop('indeterminate', false); 
                    $('#selectalldep').prop('checked', true); 

                    $('#selectallemp').prop('indeterminate', false); 
                    $('#selectallemp').prop('checked', true); 
                }
                else if(parseInt(allemp)!=parseInt(checkedemp) || parseInt(alldep)!=parseInt(checkeddep)){
                    $('#selectalldep').prop('indeterminate', true); 
                    $('#selectallemp').prop('indeterminate', true); 
                }

            }
            else{
                $('.department_'+idval).prop('checked', false);

                var allemp=$('.emptree').length;
                var uncheckedemp=$('.emptree:not(:checked)').length;

                var alldep=$('.depheader').length;
                var uncheckeddep=$('.depheader:not(:checked)').length;

                if(parseInt(allemp)==parseInt(uncheckedemp) && parseInt(alldep)==parseInt(uncheckeddep)){
                    $('#selectalldep').prop('indeterminate', false); 
                    $('#selectalldep').prop('checked', false); 

                    $('#selectallemp').prop('indeterminate', false); 
                    $('#selectallemp').prop('checked', false); 
                }
                else if(parseInt(allemp)!=parseInt(checkedemp) || parseInt(alldep)!=parseInt(checkeddep)){
                    $('#selectalldep').prop('indeterminate', true); 
                    $('#selectallemp').prop('indeterminate', true); 
                }
            }
            $('#employeelist-error').html("");
        });

        $(document).on('click', '.emptree', function(){
            var currentind=$(this).attr('id');
            var idandclass = currentind.split("-");
            var idval=idandclass[0];
            var classval=idandclass[1];
            if($(this).is(":checked")) {
                var allclass=$('.department_'+classval).length;
                var checkedclass=$('.department_'+classval+':checked').length;

                var allemp=$('.emptree').length;
                var checkedemp=$('.emptree:checked').length;

                var alldep=$('.depheader').length;
                var checkeddep=$('.depheader:checked').length;

                if(parseInt(allclass)==parseInt(checkedclass)){
                    $('#dep_'+classval).prop('indeterminate', false); 
                    $('#dep_'+classval).prop('checked', true); 
                }
                else if(parseInt(allclass)!=parseInt(checkedclass)){
                    $('#dep_'+classval).prop('indeterminate', true); 
                }

                if(parseInt(allemp)==parseInt(checkedemp) && parseInt(alldep)==parseInt(checkeddep)){
                    $('#selectalldep').prop('indeterminate', false); 
                    $('#selectalldep').prop('checked', true); 

                    $('#selectallemp').prop('indeterminate', false); 
                    $('#selectallemp').prop('checked', true); 
                }
                else if(parseInt(allemp)!=parseInt(checkedemp) || parseInt(alldep)!=parseInt(checkeddep)){
                    $('#selectalldep').prop('indeterminate', true); 
                    $('#selectallemp').prop('indeterminate', true); 
                }
            }
            else{
                var allclass=$('.department_'+classval).length;
                var uncheckedclass=$('.department_'+classval+':not(:checked)').length;

                var allemp=$('.emptree').length;
                var uncheckedemp=$('.emptree:not(:checked)').length;

                var alldep=$('.depheader').length;
                var uncheckeddep=$('.depheader:not(:checked)').length;

                if(parseInt(allclass)==parseInt(uncheckedclass)){
                    $('#dep_'+classval).prop('indeterminate', false); 
                    $('#dep_'+classval).prop('checked', false); 
                }
                else if(parseInt(allclass)!=parseInt(uncheckedclass)){
                    $('#dep_'+classval).prop('indeterminate', true); 
                }

                if(parseInt(allemp)==parseInt(uncheckedemp) && parseInt(alldep)==parseInt(uncheckeddep)){
                    $('#selectalldep').prop('indeterminate', false); 
                    $('#selectalldep').prop('checked', false); 

                    $('#selectallemp').prop('indeterminate', false); 
                    $('#selectallemp').prop('checked', false); 
                }
                else if(parseInt(allemp)!=parseInt(checkedemp) || parseInt(alldep)!=parseInt(checkeddep)){
                    $('#selectalldep').prop('indeterminate', true); 
                    $('#selectallemp').prop('indeterminate', true); 
                }
            }
            $('#employeelist-error').html("");
        });

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

        function timeTableFn(ele){
            var rownum = $(ele).closest('tr').find('.vals').val();
            let selectedId= $(`#timetables${rownum}`).val() || 0;
            
            let numberArray = selectedId.map(str => parseInt(str));
            
            let result = checkTimetableOverlaps(timetableoverlap, numberArray,rownum);

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

        function cycleNumbering(){
            $('#CycleNumber').empty();
            for(var y=1;y<=52;y++){
                $('#CycleNumber').append(`<option value="${y}">${y}</option>`);
            }
        }
       
        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#IndRegister");
            var formData = registerForm.serialize();
            var depmame = "";
            var lastdep = "";
            var ovdataa = [];
            var ovdatab = [];
            var totaloverlapped="";
            $.ajax({
                url: '/saveShiftSchedule',
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

                success: function(data) {
                    if (data.errors) {
                        if (data.errors.ShiftName) {
                            var text=data.errors.ShiftName[0];
                            text = text.replace("manageshift is 1", "Assign is selected");
                            $('#shiftname-error').html(text);
                        }
                        if (data.errors.datetimes) {
                            var text=data.errors.datetimes[0];
                            text = text.replace("manageshift is 1", "Assign is selected");
                            $('#date-error').html(text);
                        }
                        if (data.errors.employees) {
                            $('#employeelist-error').html("at-least one employee should be selected");
                        }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }  
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if(data.overlappederror){
                        var overlappeddataa="";
                        var overlappeddatab="";
                        $.each(data.getoverlappeda, function(index, value) {
                            overlappeddataa+="<b>"+value.ShiftName+"</b>    with   </br>";
                            ovdataa.push(value.ShiftName);
                        });
                        $.each(data.getoverlappedb, function(index, value) {
                            overlappeddatab+="<b>"+value.ShiftName+"</b></br>";
                            ovdatab.push(value.ShiftName);
                        });

                        for(var g=0;g<=ovdataa.length-1;g++){
                            totaloverlapped+= "<b>"+ovdataa[g]+"</b> <i>with</i> <b>"+ovdatab[g]+"</b></br>";
                        }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"There is a overlapped time in the following shifts</br>---------------------</br>"+totaloverlapped,"Error");
                    }
                    else if(data.datesterror){
                        var shiftnames="";
                        $.each(data.getshiftname, function(index, value) {
                            shiftnames+="<b>"+value.ShiftName+"</b></br>";
                        });
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"The following shift start date should be on monday</br>---------------------</br>"+shiftnames,"Error");
                    }
                    else if(data.payrollmadeerror){
                        var empnames="";
                        $.each(data.payrollmadename, function(index, value) {
                            empnames+="<b>"+value.name+"</br>"+value.Date+"</b></br>";
                        });
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"The payroll has been processed for the following employee and date</br>---------------------</br>"+empnames,"Error");
                    }
                    else if(data.existanceerr){
                        var existancedata=data.existancename;
                        
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"The following Employee and shift are overlapped with the corresponding date</br>---------------------</br>"+existancedata,"Error");
                    }
                    else if(data.mondayflagerr){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"Date range should begin with MONDAY if cycle unit is Week","Error");
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
                    else if(data.success){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('success',"Successful","Success");
                        closeRegisterModal();
                        $('#detScheduleDiv').hide();
                        $('#main-datatable').hide();
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        var iTable = $('#shiftscheduledetailtbl').dataTable();
                        iTable.fnDraw(false);
                        $("#indinlineForm").modal('hide');
                    }
                }
            });
        });

        $('#savebuttonInd').click(function(){
            let selectedLen = 0;
            $(".timetablecls").each(function () {
                let selectedOptions = $(this).val(); // Get selected values
                if (selectedOptions) {
                    selectedLen += selectedOptions.length;
                }
            });
            $("#selectedLength").val(selectedLen);
            var registerForm = $("#IndRegister");
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
            var dateRange=null;
            var EmployeeName=null;
            var status=null;
            var recId=null;
            var checkFlag=null;
            var AssignmentType=null;
            var ShiftId=null;
            
            $.ajax({
                url:'/saveIndShift',
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
                        $('#savebuttonInd').text('Saving...');
                        $('#savebuttonInd').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebuttonInd').text('Updating...');
                        $('#savebuttonInd').prop("disabled", false);
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
                        if(data.errors.dateRange){
                            $('#inddate-error').html( data.errors.dateRange[0]);
                        }
                        if(data.errors.EmployeeName){
                            $('#indemployeelist-error').html( data.errors.EmployeeName[0]);
                        }

                        if(parseFloat(optype)==1){
                            $('#savebuttonInd').text('Save');
                            $('#savebuttonInd').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonInd').text('Update');
                            $('#savebuttonInd').prop("disabled", false);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebuttonInd').text('Save');
                            $('#savebuttonInd').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonInd').text('Update');
                            $('#savebuttonInd').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.checkerr) {
                        if(parseFloat(optype)==1){
                            $('#savebuttonInd').text('Save');
                            $('#savebuttonInd').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonInd').text('Update');
                            $('#savebuttonInd').prop("disabled",false);
                        }
                        $('#assignbtn-error').html("Please assign Time here");
                        toastrMessage('error',"Please click Assign Time button and assign Time for the days","Error");
                    }
                    else if (data.blanktable) {
                        if(parseFloat(optype)==1){
                            $('#savebuttonInd').text('Save');
                            $('#savebuttonInd').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonInd').text('Update');
                            $('#savebuttonInd').prop("disabled",false);
                        }
                        $('#blanktable-error').html("Please assign Time for the listed days");
                        toastrMessage('error',"Please click Assign Time button and assign Timetable for the days","Error");
                    }
                    else if(data.existanceerr){
                        var existancedata=data.existancename;
                        
                        if(parseFloat(optype)==1){
                            $('#savebuttonInd').text('Save');
                            $('#savebuttonInd').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonInd').text('Update');
                            $('#savebuttonInd').prop("disabled",false);
                        }
                        toastrMessage('error',"The following Employee are overlapped with the corresponding date</br>---------------------</br>"+existancedata,"Error");
                    }
                    else if(data.mondayflagerr){
                        if(parseFloat(optype)==1){
                            $('#savebuttonInd').text('Save');
                            $('#savebuttonInd').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonInd').text('Update');
                            $('#savebuttonInd').prop("disabled",false);
                        }
                        toastrMessage('error',"Date range should begin with MONDAY if cycle unit is Week","Error");
                    }
                    else if(data.success) {
                        if(parseFloat(optype)==1){
                            $('#savebuttonInd').text('Save');
                            $('#savebuttonInd').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonInd').text('Update');
                            $('#savebuttonInd').prop("disabled", false);
                        }
                        toastrMessage('success',"Successful","Success");
                        closeperiodfn();
                        $('#detScheduleDiv').hide();
                        $('#main-datatable').hide();
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        var iTable = $('#shiftscheduledetailtbl').dataTable();
                        iTable.fnDraw(false);
                        $("#indinlineForm").modal('hide');
                    }
                },
            });
        });

        function assignFn(){
            $('#ShiftName').val(null).select2({
                allowClear:true,
                placeholder: 'Please select shift here',
            });
            $('.shiftrule').prop('checked', false); 
            $('#datetimes').val(""); 
            $('#shiftname-error').html('');
            $('#date-error').html('');
            $('.assignprop').show();
        }

        function dismissFn(){
            $('#ShiftName').val(null).select2({
                allowClear:true,
                placeholder: 'Please select shift here',
                
            });
            $('.shiftrule').prop('checked', false); 
            $('#datetimes').val(""); 
            $('#shiftname-error').html('');
            $('#date-error').html('');
            $('.assignprop').hide();
        }

        function shiftschFn(recordId) { 
            var shiftname="";
            var m=0;
            var backcolor="";
            var forecolor="";
            var lidata="";
            var shiftDetId="";
            $("#shiftdetailtbl > tbody").empty();
            var rowdata="<tr>";
            var currdate=$('#currentdayval').val();
            $('#detScheduleDiv').hide();
            $.ajax({
                type: "get",
                url: "{{url('showshiftsch')}}"+'/'+recordId,
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
                
                success: function (data) {
                    $.each(data.shiftschdata, function(key, value) {
                        $("#employeeidlbl").html(value.EmployeeID);
                        $("#employeenamelbl").html(value.name);
                        $("#departmentLbl").html(value.DepartmentName);
                        $("#positionLbl").html(value.PositionName);
                        $("#brancnLbl").html(value.BranchName);
                        $("#genderLbl").html(value.Gender);
                        $("#employementTypeLbl").html(value.EmploymentTypeName);
                        $("#validdatelbl").html(value.Date);
                        
                            if(value.ActualPicture!=null || value.BiometricPicture!=null){
                                $('#infoActualImage').attr("src",value.ActualPicture!=null ? "../../../storage/uploads/HrEmployee/"+value.ActualPicture : "../../../storage/uploads/BioEmployee/"+value.BiometricPicture);
                                $('#infoActualImage').show();
                            }
                            if(value.ActualPicture===null && value.BiometricPicture===null){
                                $('#infoActualImage').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
                                $("#infoActualImage").show(); 
                            }

                            if(value.Status=="Active"){
                                $(".avatar-preview").css({
                                    "border": "4px solid #28c76f"
                                });
                            }
                            else if(value.Status=="Inactive"){
                                $(".avatar-preview").css({
                                    "border": "4px solid #ea5455"
                                });
                            }
                            else{
                                $(".avatar-preview").css({
                                    "border": "4px solid #ff9f43"
                                });
                            }
                    });
                },
            });

            $('#shiftscheduledetailtbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                info: true,
                searchHighlight: true,
                "order": [[ 0, "desc" ]],
                "lengthMenu": [[50, 100], [50, 100]],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-7 left-dom'><'col-sm-12 col-md-3'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('showShiftScheduleDetail')}}",
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
                        shiftDetId: recordId,
                    },
                    dataType: "json",
                },
                columns: [
                    { data: 'id', name: 'id', 'visible': false},
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'AssignmentType',
                        name: 'AssignmentType',
                        width:"11%"
                    },
                    {
                        data: 'ScheduleTypeLabel',
                        name: 'ScheduleTypeLabel',
                        width:"10%"
                    },
                    {
                        data: 'ShiftName',
                        name: 'ShiftName',
                        width:"11%"
                    },
                    {
                        data: 'ValidDate',
                        name: 'ValidDate',
                        width:"12%"
                    },
                    {
                        data: 'CheckInRequire',
                        name: 'CheckInRequire',
                        width:"10%"
                    },
                    {
                        data: 'CheckOutRequire',
                        name: 'CheckOutRequire',
                        width:"10%"
                    },
                    {
                        data: 'ScheduleOnHoliday',
                        name: 'ScheduleOnHoliday',
                        width:"10%"
                    },
                    {
                        data: 'AllowOt',
                        name: 'AllowOt',
                        width:"10%"
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Active"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "To-be-Active"){
                                return `<span class="badge bg-info bg-glow">${data}</span>`;
                            }
                            else if(data == "Expired"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else if(data == "Void"){
                                return `<span class="badge bg-danger bg-glow">${data} (${row.OldStatus})</span>`;
                            }
                            else{
                                return `<span class="badge bg-dark bg-glow">${data}</span>`;
                            }
                        },
                        width:"9%"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width:"4%"
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
                    $('#detScheduleDiv').show();
                },
            });
            $(".infoscl").collapse('show');
            $("#informationmodal").modal('show');
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
            cycleChangeFlg=1;
        }

        function cycleUnitFn() {
            cycleUnitOrdering(2);
            $('#cycleunit-error').html("");
            cycleChangeFlg=1;
        }

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

        $('.timetable').click(function(){  
            if($(this).is(":checked")) {
                let selectedIds=[];

                $('.timetable:checked').each(function() {
                    selectedIds.push(Number($(this).val()));
                });

                let selectedNumIds = selectedIds.map(str => parseInt(str));

                let result = checkTimetableOverlaps(timetableoverlap, selectedNumIds,0);

                if(result == "Duplicate" || result == "Overlap"){
                    $(`#timetable${$(this).val()}`).prop('checked', false); 
                }
            }
           
            $('#timetable-error').html("");
        });

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

        function removeTime(idvala,idvalb){
            var shiftflag=$("#ShiftEditFlag").val()||0;

            if(parseInt(shiftflag)==0){
                if(parseInt(idvala)<=9){
                    idvala="0"+idvala;
                }
                var colspanval= $("#"+idvala+"_"+idvalb).attr('colspan');
                if(colspanval!=undefined){
                    var textname= $("#"+idvala+"_"+idvalb).text();
                    var dayname= $("#days_"+idvala).text();
                    var lbldata="Would you really like to delete <b>"+textname+"</b> for the <b>"+dayname+"</b> on row <b>"+idvala+"</b>";
                    $("#timetableremlbl").html(lbldata);
                    $("#timeTblId").val(idvala+"_"+idvalb);
                    $("#timeRowId").val(idvala);
                    $("#timeColspanVal").val(colspanval);
                    $("#timeTdIndex").val(idvalb);
                    $("#timeNameVal").val(textname);
                    $("#timetableremovemodal").modal('show');
                }
            }
            else if(parseInt(shiftflag)==1){
                toastrMessage('error',"You cannot delete the timetable because schedules are created based on it","Error");
            }
        }

        $('#timetablerembtn').click(function(){
            var keyids=null;
            var timeid=$('#timeTblId').val();
            var timerow=$('#timeRowId').val();
            var timecolspan=$('#timeColspanVal').val();
            var timetdindex=$('#timeTdIndex').val();
            var timenamedata=$('#timeNameVal').val();
            var lastindx=(parseInt(timetdindex)+parseInt(timecolspan))-parseInt(1);
            var lasttd="<td style='width:0.3125%;' id="+timerow+"_"+timetdindex+" ondblclick='removeTime("+timerow+","+timetdindex+")'></td>";
            $("#"+timerow+"_"+timetdindex).attr('colspan',0);
            $("#"+timerow+"_"+timetdindex).css({"background-color":"white","border-color":"#d9d7ce"});
            $("#"+timerow+"_"+timetdindex).text('');
            
            for(var tdindx=timetdindex;tdindx<lastindx;tdindx++){
                var tdnxt=tdindx;
                if(parseInt(tdindx)<=9){
                    tdindx="0"+tdindx;
                }
                $("#"+timerow+"_"+tdindx).after("<td style='width:0.3125%;' id="+timerow+"_"+(parseInt(tdindx)+parseInt(1))+" ondblclick='removeTime("+timerow+","+(parseInt(tdindx)+parseInt(1))+")'></td>");
            }
            $.each(timetablealldata, function(keya,timedata) {
                if(timedata.collname==timenamedata){
                    keyids=timedata.keyid;
                }
            });
            $.each(rowallinfodata, function(keya,valuea) {
                if(parseInt(timerow)==parseInt(keya)){
                    $.each(valuea.rowinfodata, function(keyb,valueb) {
                       delete valuea.rowinfodata[keyids];
                    });
                }
            });
            $("#timetableremovemodal").modal('hide');
        });

        function shiftnamefn() {
            $('#shiftname-error').html('');
        }

        function datetimefn(){
            $('#date-error').html('');
        }

        function employeeNameFn(){
            $('#indemployeelist-error').html('');
        }

        function employeeTreeFn(){
            $("#orgtree").empty();
            var treevals="";
            $.get("/deplist" , function(data) {
                treevals='<ul id="treeview" class="hummingbird-base mt-0" style="padding:0px 0px 0px 0px;">';
                $.each(data.deplist, function(key, value) {
                    treevals+='<li data-id="'+key+'" id="'+value.departments_id+'" class="departmentListClass"><i class="fa fa-plus fa-lg"></i><label style="font-size:14px;"><input class="hummingbird-end-node depheader" style="width:17px;height:17px;accent-color:#7367f0;" id="dep_'+value.departments_id+'" data-id="custom-'+value.departments_id+'" name="depatments[]" value="'+value.departments_id+'" type="checkbox"/>  '+value.DepartmentName+'</label><ul>';
                    $.each(data.emplist, function(key, empvalue) {
                        if(parseInt(value.departments_id)==parseInt(empvalue.departments_id)){
                            treevals+='<li data-id="'+value.departments_id+'" id="'+empvalue.id+'" class="employeeListClass"><label style="font-size:12px;"><input class="hummingbird-end-node emptree department_'+value.departments_id+'" id="'+empvalue.id+'-'+value.departments_id+'" data-id="custom-'+value.departments_id+'-'+empvalue.id+'" style="width:17px;height:17px;accent-color:#7367f0;" name="employees[]" value="'+empvalue.id+'" type="checkbox"/>  '+empvalue.name+'</label></li>';
                        }
                    });
                    treevals+='</ul></li>';
                }); 
                treevals+='</ul>';
                $("#orgtree").append(treevals);
            });
            $("#orgtree").hummingbird();
        }

        $('#AssignmentType').on('change', function() {
            $('.assprop').hide();
            if(parseInt($(this).val())==1){
                grpAssignmentFn();
                $('.grdclass').show();
            }
            else if(parseInt($(this).val())==2){
                indAssignmentFn();
                $('.indclass').show();
            }
            $('#assignmenttype-error').html('');
        });

        $('#ScheduleType').on('change', function() {
            $('#scheduletype-error').html('');
        });

        function grpAssignmentFn(){
            $('.mainforminp').val("");
            $('.errordatalabel').html('');
            $('#ShiftName').val(null).select2({
                allowClear:true,
                placeholder: 'Please select shift here',
            });
            $('#recId').val("");
            var start=$('#currentdayval').val();
            $('#operationtypes').val("1");
            $("#modaltitle").html("Manage Schedule Assignment");
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $('#selectalldep').prop('indeterminate', false); 
            $('#selectalldep').prop('checked', false); 
            $('.shiftrule').prop('checked', false); 
            $('#datetimes').daterangepicker({ 
                showDropdowns: true,
                autoApply:false,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('#datetimes').val(""); 
        }

        function indAssignmentFn(){
            $('#shiftoperationtypes').val("1");
            $('#recId').val("");
            $('#status').val("Active").select2();
            $('#status').select2({
                minimumResultsForSearch: -1
            });
            cycleNumbering();
            $('#CycleUnit').empty();
            $('#CycleUnit').select2({
                placeholder:"Select cycle unit here"
            });
            $('#CycleNumber').val(null).select2();
            $('#CycleNumber').select2({
                placeholder:"Select cycle number here"
            });
            $('#modaltitle').html('Add Shift');
            $('#savebuttonInd').text('Save');
            $('#savebuttonInd').prop("disabled",false);
            $('#dynamicTable tbody').empty();
            $("#schtimetable > tbody").empty();
            $("#checkFlag").val('');
            $('#ShiftEditFlag').val("0");
            $('.errordatalabel').html("");

            oldcyclenum=0;

            $('#dateRange').daterangepicker({ 
                showDropdowns: true,
                autoApply:false,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('#dateRange').val(""); 
        }

        $('body').on('click', '#addAssignment', function() {
            $('#AssignmentType').val(2).select2({minimumResultsForSearch: -1}).trigger('change');
            $('#ScheduleType').val(1).select2({minimumResultsForSearch: -1}).trigger('change');
            $('.assprop').hide();
            $('.indclass').show();
            $('#assignmentTitle').html("Add Schedule Assignment");
            $('#scstatusdisplay').html("");
            $("#operationtypes").val(1);
            $('#ShiftId').val("");
            $('#shiftScheduleDetail').val("");
            $('#timetableassign > tbody').empty();
            $('.shiftrule').prop('checked', false); 
            employeeTreeFn();
            let employeedata = $("#EmployeeNameDefault > option").clone();
            $('#EmployeeName').empty();
            $('#EmployeeName').append(employeedata).select2({
                placeholder:"Select Employee here"
            });
            $('#selectallempdiv').show();
            $("#indinlineForm").modal('show');
        });

        function editShiftSchFn(recordId){
            var employeetree="";
            var shiftids=[];
            var shiftflag=0;
            var dayname="";
            var schdetailid="";
            days=[];
            $('#assignmentTitle').html("Edit Schedule Assignment");
            $("#recId").val(recordId);
            $("#operationtypes").val(2); 
            $("#checkFlag").val('1');
            $('.assprop').hide();
            $('#selectallempdiv').hide();
            $("#orgtree").empty();
            $('#CycleUnit').empty();
            $('#CycleNumber').empty();
            $('#timetableassign > tbody').empty();
            $('#shiftScheduleDetail').val(recordId);
            $.ajax({
                url: '/getScheduleDetail',
                type: 'POST',
                data:{
                    schdetailid:recordId,
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
                success: function(data) {
                    shiftflag=data.shiftcnt;
                    $.each(data.shiftDetails, function(key, value) {
                        $('#AssignmentType').val(value.ShiftFlag).select2({minimumResultsForSearch: -1});
                        $('#ScheduleType').val(value.ScheduleType).select2({minimumResultsForSearch: -1});
                        employeetree='<ul id="treeview" class="hummingbird-base mt-0" style="padding:0px 0px 0px 20px;">';
                        employeetree+='<li data-id="'+value.departments_id+'" id="'+value.employees_id+'" class="employeeListClass"><label style="font-size:12px;"><input style="width:17px;height:17px;accent-color:#7367f0;" class="hummingbird-end-node emptree department_'+value.departments_id+'" id="'+value.employees_id+'-'+value.departments_id+'" data-id="custom-'+value.departments_id+'-'+value.employees_id+'" name="employees[]" value="'+value.employees_id+'" type="checkbox" checked/>  '+value.name+'</label></li></ul>';
                        $("#orgtree").append(employeetree);
                        $("#orgtree").hummingbird();
                        $('#selectalldep').prop('checked',true);

                        $('#EmployeeName').empty();
                        $('#EmployeeName').append(`<option selected value=${value.employees_id}>${value.name}</option>`).select2();
                        if(parseInt(value.ShiftFlag)==1){
                            $.each(data.shiftdata, function(key, shvalue) {
                                shiftids.push(shvalue.id);
                            }); 
                            $('#ShiftName').val(shiftids).select2();

                            $('#datetimes').daterangepicker({ 
                                showDropdowns: true,
                                autoApply:false,
                                locale: {
                                    format: 'YYYY-MM-DD'
                                }
                            });
                            let daterange=value.ValidDate;
                            let spliteddate = daterange.split(' to ');
                            $('#datetimes').data('daterangepicker').setStartDate(spliteddate[0]);
                            $('#datetimes').data('daterangepicker').setEndDate(spliteddate[1]);

                            $('#checkinnotreq').prop('checked',value.CheckInNotReq == 1);
                            $('#checkoutnotreq').prop('checked',value.CheckOutNotReq == 1);
                            $('#scheduledholiday').prop('checked',value.ScheduleOnHoliday == 1);
                            $('#effectiveot').prop('checked',value.EffectiveOt == 1);

                            $('.grdclass').show();
                            $('#savebutton').text("Update");
                        }
                        if(parseInt(value.ShiftFlag)==2){
                            
                            $.each(data.shiftdata, function(key, shvalue) {
                                $('#ShiftId').val(shvalue.id);
                            }); 

                            $('#dateRange').daterangepicker({ 
                                showDropdowns: true,
                                autoApply:false,
                                locale: {
                                    format: 'YYYY-MM-DD'
                                }
                            });
                            let daterange=value.ValidDate;
                            let spliteddate = daterange.split(' to ');
                            $('#dateRange').data('daterangepicker').setStartDate(spliteddate[0]);
                            $('#dateRange').data('daterangepicker').setEndDate(spliteddate[1]);

                            $('#indcheckinnotreq').prop('checked',value.CheckInNotReq == 1);
                            $('#indcheckoutnotreq').prop('checked',value.CheckOutNotReq == 1);
                            $('#indscheduledholiday').prop('checked',value.ScheduleOnHoliday == 1);
                            $('#indeffectiveot').prop('checked',value.EffectiveOt == 1);

                            $.each(data.shiftdata, function(key, value) {
                                for(var y=1;y<=52;y++){
                                    $('#CycleNumber').append('<option value='+y+'>'+y+'</option>');
                                }
                                $('#CycleUnit').append("<option value='1'>Day</option><option value='2'>Month</option><option value='3'>Week</option>");
                                $('#ShiftEditFlag').val("0");
                                $('#assigntime').show();
                                $('#ShiftName').val(value.ShiftName);
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
                            $('.indclass').show();
                            $('#savebuttonInd').text("Update");
                        }

                        if(value.Status=="Active"){
                            $("#scstatusdisplay").html(`<span style='color:#28c76f;font-weight:bold;text-shadow;1px 1px 10px #28c76f;font-size:16px;'>${value.Status}</span>`);
                        }
                        else if(value.Status=="To-be-Active"){
                            $("#scstatusdisplay").html(`<span style='color:#00cfe8;font-weight:bold;text-shadow;1px 1px 10px #00cfe8;font-size:16px;'>${value.Status}</span>`);
                        }
                        else if(value.Status=="Expired"){
                            $("#scstatusdisplay").html(`<span style='color:#ea5455;font-weight:bold;text-shadow;1px 1px 10px #ea5455;font-size:16px;'>${value.Status}</span>`);
                        }
                    });
                },
            });
            $("#indinlineForm").modal('show');
        }

        function scheduleDetInfoFn(recordId){
            var schdetailid="";
            var lidata="";
            var monthoptions = "";
            var dates="";
            $('#Month').empty();
            $('#timetableDiv').hide();
            $('#scstatusdisplay').html("");
            $('#scheduleDetStatus').html("");
            $("#indInfoTbl").hide();
            $.ajax({
                url: '/getScheduleDetail',
                type: 'POST',
                data:{
                    schdetailid:recordId,
                },
                success: function(data) {
                    $("#currentDateVal").val(data.currentdate);
                    $(".indinfolbl").html("");
                    $.each(data.shiftDetails, function(key, value) {
                        $("#assignmentTypeLbl").html(value.AssignmentType);
                        $("#scheduleTypeLbl").html(value.ScheduleTypeLabel);
                        $("#shiftnamelbl").html(value.ShiftName);
                        $("#validdatelbldet").html(value.ValidDate);
                        $("#checkinnotreqlbl").html(value.CheckInRequire);
                        $("#checkoutnotreqlbl").html(value.CheckOutRequire);
                        $("#schholidaylbl").html(value.ScheduleOnHolidayText);
                        $("#effectiveotlbl").html(value.AllowOt);
                        $("#employeeIdShiftDet").val(value.employees_id);
                        $("#shiftDetailIdVal").val(recordId);
                        dates = value.ValidDate.split(' to ');
                        $("#validStartDate").val(dates[0].trim());
                        $("#validEndDate").val(dates[1].trim());

                        if(parseInt(value.ShiftFlag) == 2){
                            $("#indInfoTbl").show();
                            $("#indCycleNumberLbl").html(value.CycleNumber);
                            $("#indCycleUnitLbl").html(parseInt(value.CycleUnit) == 1 ? "Day" : (parseInt(value.CycleUnit) == 2 ? "Month" : "Week"));
                            $("#indDescriptionLbl").html(value.ShiftDescription != null ? value.ShiftDescription : "");
                        }
                        
                        if(value.Status=="Active"){
                            $("#scheduleDetStatus").html(`<span style='color:#28c76f;font-weight:bold;text-shadow;1px 1px 10px #28c76f;font-size:16px;'>${value.Status}</span>`);
                        }
                        else if(value.Status=="To-be-Active"){
                            $("#scheduleDetStatus").html(`<span style='color:#00cfe8;font-weight:bold;text-shadow;1px 1px 10px #00cfe8;font-size:16px;'>${value.Status}</span>`);
                        }
                        else if(value.Status=="Expired"){
                            $("#scheduleDetStatus").html(`<span style='color:#ea5455;font-weight:bold;text-shadow;1px 1px 10px #ea5455;font-size:16px;'>${value.Status}</span>`);
                        }
                        else if(value.Status=="Void"){
                            $("#scheduleDetStatus").html(`<span style='color:#ea5455;font-weight:bold;text-shadow;1px 1px 10px #ea5455;font-size:16px;'>${value.Status} (${value.OldStatus})</span>`);
                        }
                    });

                    $.each(data.monthlist, function(key, value) {
                        monthoptions += `<option value="${value.numeric}">${value.full}</option>`;
                    });
                    $('#Month').append(monthoptions);
                    var firstOption = $('#Month option').first().val();
                    $('#Month').val(firstOption).select2({
                        allowClear:true,
                        placeholder: 'Select month(s) here',
                    });          

                    $.each(data.timetabledata, function(key, value) {
                        colorMap[value.TimetableName] = value.TimetableColor;
                        timeTableName[value.TimetableName] = value.TimetableName;
                    });     
               
                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited"){
                            classes="warning";
                        }
                        else if(value.action == "Created"){
                            classes="success";
                        }
                        else if(value.action == "Void"){
                            classes="danger";
                        }
                        else if(value.action == "Undo-Void"){
                            classes="secondary";
                        }

                        if(value.reason!=null && value.reason!=""){
                            reasonbody='</br><span class="text-muted"><b>Reason:</b> '+value.reason+'</span>';
                        }
                        else{
                            reasonbody="";
                        }
                        lidata+='<li class="timeline-item"><span class="timeline-point timeline-point-'+classes+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i> '+value.FullName+'</span>'+reasonbody+'</br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span></div></li>';
                    });
                    $("#actiondiv").empty();
                    $('#actiondiv').append(lidata);
                    fetchTimetableData();
                }
            });
            
            $(".infoschdet").collapse('show');
            
        }
        
        function fetchTimetableData(){
            var selectedmonth="";
            var employeeid="";
            var startdate="";
            var enddate="";
            var shiftdetailid="";
            
            $('#timetableDiv').hide();
            $('#timetableinfotbl').DataTable({
                destroy: true,
                processing: false,
                serverSide: true,
                searching: true,
                info: true,
                fixedHeader: true,
                paging: true,
                searchHighlight: true,
                responsive:true,
                deferRender: true,
                "order": [[ 1, "asc" ]],
                "lengthMenu": [[50, 100], [50, 100]],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-7 left-dom'><'col-sm-12 col-md-3'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('showTimetableData')}}",
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
                        selectedmonth: $('#Month').val(),
                        employeeid: $('#employeeIdShiftDet').val(),
                        startdate: $('#validStartDate').val(),
                        enddate: $('#validEndDate').val(),
                        shiftdetailid: $('#shiftDetailIdVal').val(),
                    },
                    dataType: "json",
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"4%"
                    },
                    {
                        data: 'Date',
                        name: 'Date',
                        width:"21%"
                    },
                    {
                        data: 'SelectedTimetable',
                        name: 'SelectedTimetable',
                        width:"75%"
                    },
                ],
                createdRow: function (row, data, dataIndex) {
                    var currentdate=$("#currentDateVal").val();
                    var dateCell = $('td:eq(1)', row);
                    
                    if (dateCell.text().trim().includes(currentdate)) { // Check if the cell contains the current date
                        dateCell.css({
                            'background-color':'#28c76f',
                            'color':'#FFFFFF',
                            'font-weight':'bold'
                        }); 
                    }
                },
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
                    $("#shiftdetailinfomodal").modal('show');
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

        function voidShiftSchFn(schId){
            $('#Reason').val("");
            $('#voidsch-error').html('');
            $('#schedulevoidbtn').text('Void');
            $('#schedulevoidbtn').prop("disabled", false);
            $('#voidschid').val(schId);
            $("#voidschedulemodal").modal('show');
        }

        //Void schedule starts
        $('#schedulevoidbtn').click(function() {
            var deleteForm = $("#voidshiftscheduleform");
            var formData = deleteForm.serialize();
            $.ajax({
                url: '/voidSchedule',
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
                    $('#schedulevoidbtn').text('Voiding...');
                    $('#schedulevoidbtn').prop("disabled", true);
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
                        if (data.errors.Reason) {
                            $('#voidsch-error').html(data.errors.Reason[0]);
                        }
                        $('#schedulevoidbtn').text('Void');
                        $('#schedulevoidbtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    else if (data.dberrors) {
                        $('#schedulevoidbtn').text('Void');
                        $('#schedulevoidbtn').prop("disabled",false);
                        $("#voidschedulemodal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        $('#schedulevoidbtn').text('Void');
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#shiftscheduledetailtbl').dataTable();
                        oTable.fnDraw(false);
                        $("#voidschedulemodal").modal('hide');
                        $('#schedulevoidbtn').prop("disabled", false);
                    }
                }
            });
        });
        //Void schedule ends

        function voidReason() {
            $('#voidsch-error').html("");
        }

        function undovoidShiftSchFn(recordId){
            $('#undovoidid').val(recordId);
            $('#scheduleundovoidbtn').prop("disabled", false);
            $('#scheduleundovoidbtn').text("Undo Void");
            $("#undovoidmodal").modal('show');
        }

        //Undo void schedule starts
        $('#scheduleundovoidbtn').click(function() {
            var deleteForm = $("#undovoidform");
            var formData = deleteForm.serialize();
            $.ajax({
                url: '/undoVoidSchedule',
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
                    $('#scheduleundovoidbtn').text('Changing...');
                    $('#scheduleundovoidbtn').prop("disabled", true);
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
                        $('#scheduleundovoidbtn').text('Undo Void');
                        $('#scheduleundovoidbtn').prop("disabled",false);
                        $("#undovoidmodal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        $('#scheduleundovoidbtn').text('Undo Void');
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#shiftscheduledetailtbl').dataTable();
                        oTable.fnDraw(false);
                        $("#undovoidmodal").modal('hide');
                        $('#scheduleundovoidbtn').prop("disabled", false);
                    }
                }
            });
        });
        //Undo void schedule ends

        function closeRegisterModal() {
            $('.mainforminp').val("");
            $('#status').val("Active");
            $('.errordatalabel').html('');
            $('#recId').val("");
            $('#operationtypes').val("1");
            $('#status').select2({
                minimumResultsForSearch: -1
            });
			$('#status').val("Active");
        }

        function closeperiodfn() {
            $('#shiftoperationtypes').val("1");
            $('#recId').val("");
            $('#ShiftName').val("");
            $('#Description').val("");
            $('#status').val(null).select2();
            $('#CycleNumber').val(null).select2();
            $('#CycleUnit').val(null).select2();
            $('#BegininngDate').val("");
            $('#savebuttonInd').text('Save');
            $('#savebuttonInd').prop("disabled",false);
            $('#dynamicTable tbody').empty();
            $("#checkFlag").val('');
            flatpickr('#BreakStartTime', {clickOpens:false});
            flatpickr('#BreakEndTime', {clickOpens:false});
            $("#schtimetable > tbody").empty();
            $("#shiftdetailtbl > tbody").empty();
            $('#ShiftEditFlag').val("0");
            $('.errordatalabel').html("");
        }

        function closeAssignmentFn(){
            closeperiodfn();
            closeRegisterModal();
        }

        function dateRangeFn(){
            $('#inddate-error').html('');
        }

        function holidayDateFn() {
            $('#holidaydate-error').html('');
        }

        function descriptionfn() {
            $('#description-error').html('');
        }

        function statusFn() {
            $('#status-error').html('');
        }

        function statusfn() {
            $('#status-error').html("");
        }

        function closeScheduleDetailFn() {
            $('#scheduleDetStatus').html("");
        }
    </script>
@endsection
