@extends('layout.app1')

@section('title')
@endsection

@section('content')

    @can('Attendance-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div style="width:50%;">
                                <h3 class="card-title">Attendance</h3>
                                <div class="row" style="position: absolute;left: 270px;top: 80px;width:50%;z-index: 10;display:none" id="filter_div">
                                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                                        <select class="select2 form-control" id="Month" name="Month[]" onchange="getAllData()">
                                            @foreach ($monthlist as $monthlist)
                                                <option value="{{$monthlist->Months}}">{{$monthlist->FullMonthFormat}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                                        <select class="selectpicker form-control dropdownclass" id="Branch" name="Branch" title="Select Branch here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true"></select>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                                        <select class="selectpicker form-control dropdownclass" id="Department" name="Department" title="Select Department here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div style="width:99%; margin-left:0.5%;">
                                <div id="dataTableDiv">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div style="display: none;">
            <select class="select2 form-control" name="BranchDefault" id="BranchDefault">
                @foreach ($branchlist as $branchlist)
                <option data-month="{{$branchlist->Month}}" value="{{$branchlist->id}}">{{$branchlist->BranchName}}</option>
                @endforeach
            </select>
            <select class="select2 form-control" name="DepartmentDefault" id="DepartmentDefault">
                @foreach ($departmentlist as $departmentlist)
                <option data-month="{{$departmentlist->Month}}" value="{{$departmentlist->id}}">{{$departmentlist->DepartmentName}}</option>
                @endforeach
            </select>
            <input type="hidden" class="form-control" id="currentdayval" name="currentdayval" readonly="readonly" value="{{$currentdate}}"/>
            <input type="hidden" class="form-control" id="currentdatefullfm" name="currentdatefullfm" readonly="readonly" value="{{$currentdatefullformat}}"/>
        </div>
    </div>
    @endcan

    <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle">Add Manual Attendance</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-xl-6 col-md-6 col-sm-12 mb-1" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12">
                                        <span class="text-danger">
                                            <strong id="employee-error" class="errordatalabel"></strong>
                                        </span>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control mainforminp" name="SearchEmployee" id="SearchEmployee" placeholder="Search Employee here..." aria-label="Search Employee here..." aria-describedby="button-addon">
                                            <button class="btn btn-outline-danger waves-effect btn-sm" type="button" id="button-addon"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mt-1">
                                        <span class="text-danger">
                                            <strong id="employeelist-error" class="errordatalabel"></strong>
                                        </span>
                                        <div id="selectalldiv">
                                            <label style="font-size:14px;font-weight:bold;"><input class="hummingbird-end-node" style="width:17px;height:17px;accent-color:#7367f0;" id="selectalldep" class="selectalldep" type="checkbox"/>  Select All</label>
                                        </div>
                                        <div id="orgtree" class="hummingbird-treeview scrollhor" style="overflow-y: scroll;height:30rem;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-sm-12 mb-1">
                                <div class="divider">
                                    <div class="divider-text">Date Range & Time Selection</div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12">
                                        <label style="font-size: 14px;">Attendance Date Range</label><label style="color: red; font-size:16px;">*</label>
                                        <div>
                                            <input type="text" class="form-control" id="AttendanceDateRange" name="AttendanceDateRange" placeholder="YYYY-MM-DD to YYYY-MM-DD" readonly="readonly" onchange="datetimefn()" style="background-color:#FFFFFF" value=""/>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="date-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-sm-12 mt-1">
                                        <label style="font-size: 14px;" for="Time">Time</label><label style="color: red; font-size:16px;">*</label><br>
                                        <input type="text" placeholder="Time" class="form-control mainforminp" name="Time" id="Time" onchange="timeFn()"/>
                                        <span class="text-danger">
                                            <strong id="time-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mt-1">
                                        <label style="font-size: 14px;">Punch Type</label><label style="color: red; font-size:16px;">*</label>
                                        <select class="select2 form-control" name="PunchType" id="PunchType" onchange="punchTypeFn()">
                                            <option selected disabled value=""></option>
                                            <option value="1">Punch In</option>
                                            <option value="2">Punch Out</option>
                                        </select>
                                        <span class="text-danger">
                                            <strong id="punchtype-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mt-1" style="text-align: center;" id="durationdiv">
                                        <label id="durationlbl" style="font-size: 14px;font-weight:bold"></label>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mt-1">
                                        <label style="font-size: 14px;">Remark</label>
                                        <textarea type="text" placeholder="Write Remark here..." class="form-control mainforminp" rows="2" name="Remark" id="Remark" onkeyup="remarkFn()"></textarea>
                                        <span class="text-danger">
                                            <strong id="remark-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" placeholder="Work Hour Duration" class="form-control mainforminp" name="WorkingHour" id="WorkingHour" readonly style="font-weight:bold;"/>
                        <input type="hidden" placeholder="" class="form-control" name="recId" id="recId" readonly="true" value=""/>     
                        <input type="hidden" placeholder="" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        <button id="savenewbutton" type="button" class="btn btn-info">Save & New</button>
                        <button id="savebutton" type="button" class="btn btn-info">Save & Close</button>
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Start Information Modal -->
    <div class="modal fade" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Holiday Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td colspan="2">
                                                <label id="basictitle" style="font-size: 16px;font-weight:bold;">Basic Information</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 55%"><label style="font-size: 14px;">Holiday Name</label></td>
                                            <td style="width: 45%"><label id="holidaynamelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Holiday Date</label></td>
                                            <td><label id="holidaydatelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Description</label></td>
                                            <td><label id="descriptionlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Status</label></td>
                                            <td><label id="statuslbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td colspan="2">
                                                <label id="actiontitle" style="font-size: 16px;font-weight:bold;">Action Information</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%"><label style="font-size: 14px;">Created By</label></td>
                                            <td style="width: 60%"><label id="createdbylbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Created Date</label></td>
                                            <td><label id="createddatelbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Last Edited By</label></td>
                                            <td><label id="lasteditedbylbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Last Edited Date</label></td>
                                            <td><label id="lastediteddatelbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
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

    <div class="modal fade text-left" id="dailyInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" style="width: 100% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="dailyinfomodaltitle">Daily Attendance Information</h4>
                    <div class="row">
                        <h4 style="text-align: right" id="attstatusdisplay"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeDailyInfoFn()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="DailyRegisterForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-9 col-md-6 col-sm-6 mt-1" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                <div class="row">

                                    <div class="col-xl-12 col-md-12 col-sm-12">
                                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mt-0">
                                            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto mt-1">
                                                <img id="employeepic" src="../../../storage/uploads/HrEmployee/dummypic.jpg" alt="-" class="d-block h-auto ms-0 ms-sm-2 rounded" width="100" height="100">
                                            </div>
                                            <div class="mt-n2" style="margin-left: -25px;">
                                                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                                    <div class="user-profile-info" style="text-align: left;">
                                                        <h4 id="empname"></h4>
                                                        <ul style="padding-left:0px">
                                                            <li class="list-inline-item d-flex gap-1">
                                                                <i class="fa-solid fa-landmark"></i><label id="dailydepartmentlbl" title="Department"></label>
                                                            </li>
                                                            <li class="list-inline-item d-flex gap-1">
                                                                <i class="fa-solid fa-up-down-left-right"></i><label id="dailypositionlbl" title="Position"></label>
                                                            </li>
                                                            <li class="list-inline-item d-flex gap-1">
                                                                <i class="fa-solid fa-calendar-days"></i><label id="dayandtimelbl"></label>
                                                            </li>
                                                            <li class="list-inline-item d-flex gap-1">
                                                                <label id="holidayLbl"></label>
                                                            </li>
                                                            {{-- <li class="list-inline-item d-flex gap-1"><i class="ti ti-map-pin"></i> Vatican City</li>
                                                            <li class="list-inline-item d-flex gap-1">
                                                                <i class="ti ti-calendar"></i> Joined April 2021
                                                            </li> --}}
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mt-1">
                                        <label style="font-size: 14px;font-weight:bold;">Assigned Shift & Timetable</label>
                                        <div id="assignedtimediv"></div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mt-1">
                                        <div class="border rounded p-1 mt-2">
                                            <div class="row gap-4 gap-sm-0" style="text-align: center;">
                                                <div class="col-12 col-sm-4 mb-1" style="text-align: center;">
                                                    <h6 class="my-0.5" id="prductionhr"></h6>
                                                </div>
                                                <div class="col-12 col-sm-4 mb-1" style="text-align: center;">
                                                    <h6 class="my-0.5" id="breakhr"></h6>
                                                </div>
                                                <div class="col-12 col-sm-4 mb-1" style="text-align: center;">
                                                    <h6 class="my-0.5" id="overtimehr"></h6>
                                                </div>
                                                <div class="col-12 col-sm-3" style="text-align: center;">
                                                    <h6 class="my-0.5" id="earlycheckinhr"></h6>
                                                </div>
                                                <div class="col-12 col-sm-3" style="text-align: center;">
                                                    <h6 class="my-0.5" id="dailylatecheckinhr"></h6>
                                                </div>
                                                <div class="col-12 col-sm-3" style="text-align: center;">
                                                    <h6 class="my-0.5" id="latecheckouthr"></h6>
                                                </div>
                                                
                                                <div class="col-12 col-sm-3" style="text-align: center;">
                                                    <h6 class="my-0.5" id="dailyearlycheckouthr"></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-4 col-sm-4 mt-1">

                                    </div>
                                    <div class="col-xl-4 col-md-4 col-sm-4 mt-1">

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-sm-6">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" style="text-align:left;">
                                        <label style="font-size: 18px;font-weight:bold;">Activity</label>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" style="text-align:right;">
                                        <label style="font-size:12px;text-align:right;"><input class="hummingbird-end-node dailyshowallpunchistory" style="width:13px;height:13px;accent-color:#7367f0;" id="dailyshowall" name="dailyshowall" type="checkbox"/>	Show all</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 scrollhor" style="overflow-y: scroll;height:22rem">
                                        <ul id="activityul" class="timeline mb-0 mt-1"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="print-container">

                        </div>
                        <div class="row" style="display: none;">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <table id="dailyReport" class="display table-bordered defaultdatatable nowrap" style="width: 100%">
                                    <thead> 
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Shift</th>
                                            <th>Timetable</th>
                                            <th>Time</th>
                                            <th>Type</th>
                                            <th>Work Hour Usual</th>
                                            <th>Work Hour Pending/ Reject</th>
                                            <th>Break Hour Usual</th>
                                            <th>Break Hour Pending/ Reject</th>
                                            <th>Overtime Usual</th>
                                            <th>Overtime Pending/ Reject</th>
                                            <th>Early Punch In</th>
                                            <th>Late Punch In</th>
                                            <th>Late Punch Out</th>
                                            <th>Early Punch Out</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="text-align: left">
                                    <button id="dailyprinttable" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm printattlog" title="Print" style="color: #4B5563"><i class="fa-solid fa-print fa-lg" aria-hidden="true"></i></button>
                                    <button id="dailyexporttoexcel" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm exportattlogtoexcel" title="Export to Excel" style="color: #15803D"><i class="fa-solid fa-file-excel fa-lg" aria-hidden="true"></i></button>
                                    <button id="dailyexportpdf" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm exportattlogtopdf" title="Export to PDF" style="color: #B91C1C"><i class="fa-solid fa-file-pdf fa-lg" aria-hidden="true"></i></button>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="text-align: right">
                                    <input type="hidden" class="form-control" name="hiddenCurrentTimeDaily" id="hiddenCurrentTimeDaily" readonly="true"/>
                                    <input type="hidden" class="form-control" name="hiddenBranch" id="hiddenBranch" readonly="true"/>
                                    <input type="hidden" class="form-control" name="hiddenEmployeeId" id="hiddenEmployeeId" readonly="true"/>
                                    <button id="closebuttondinfo" type="button" class="btn btn-danger" onclick="closeDailyInfoFn()" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="monthlyInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="monthlyinfomodaltitle">Monthly Attendance Information</h4>
                    <div class="row">
                        <h4 style="text-align: right;" id="infomonthdisplay"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeDailyInfoFn()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="MonthlyRegisterForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-2 col-md-6 col-sm-6 mt-1">
                                <div class="nav-vertical nav-horizontal scrollhor" style="overflow-y: scroll;height:50rem">
                                    <ul class="nav nav-tabs nav-left flex-column" role="tablist" id="verticaltab"></ul> 
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-6 mt-1" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                <div class="tab-content" id="verticaltabbody">
                                    
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12 col-sm-12 mt-3">
                                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mt-0 mb-2">
                                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto mt-2">
                                        <img id="monthemployeepic" src="../../../storage/uploads/HrEmployee/dummypic.jpg" alt="-" class="d-block h-auto ms-0 ms-sm-2 rounded" width="120" height="120">
                                    </div>
                                    <div class="flex-grow-0 mt-0 mt-sm-0" style="margin-left: -25px;">
                                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                            <div class="user-profile-info" style="text-align: left;">
                                                <h3 id="monthempname" title="Employee Full Name"></h3>
                                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="departmentlbl" title="Department"></label>
                                                    </li>
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="positionlbl" title="Position"></label>
                                                    </li>
                                                    {{-- <li class="list-inline-item d-flex gap-1">
                                                        <i class="ti ti-calendar"></i> Joined April 2021
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider">
                                    <div class="divider-text">Summary Data</div>
                                </div>
                                <div class="border rounded p-1">
                                    <div class="row gap-4 gap-sm-0" style="text-align: center;">
                                        <div class="col-12 col-sm-4 mb-1" style="text-align: center;">
                                            <h6 class="my-0.5" id="prductionhrmon"></h6>
                                        </div>
                                        <div class="col-12 col-sm-4 mb-1" style="text-align: center;">
                                            <h6 class="my-0.5" id="breakhrmon"></h6>
                                        </div>
                                        <div class="col-12 col-sm-4 mb-1" style="text-align: center;">
                                            <h6 class="my-0.5" id="overtimehrmon"></h6>
                                        </div>
                                        <div class="col-12 col-sm-3" style="text-align: center;">
                                            <h6 class="my-0.5" id="earlycheckinmon"></h6>
                                        </div>
                                        <div class="col-12 col-sm-3" style="text-align: center;">
                                            <h6 class="my-0.5" id="latecheckinhourlbl"></h6>
                                        </div>
                                        <div class="col-12 col-sm-3" style="text-align: center;">
                                            <h6 class="my-0.5" id="latecheckoutmon"></h6>
                                        </div>
                                        <div class="col-12 col-sm-3" style="text-align: center;">
                                            <h6 class="my-0.5" id="earlycheckouthourlbl"></h6>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12 mt-1" style="padding:0px 0px 0px 0px">
                                    <table id="statusSummaryTbl" style="width: 100%;">
                                        <thead style="display: none;">
                                            <tr>
                                                <th>#</th>
                                                <th>Status</th>
                                                <th>Number of Day(s)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="display: none;">1</td>
                                                <td style="width: 55%"><label style="font-size: 14px;">Present</label></td>
                                                <td style="width: 45%"><label id="presentlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">2</td>
                                                <td><label style="font-size: 14px;">Partially Present</label></td>
                                                <td><label id="partiallypresentlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">3</td>
                                                <td><label style="font-size: 14px;">Absent</label></td>
                                                <td><label id="absentlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">4</td>
                                                <td><label style="font-size: 14px;">Late PunchIn</label></td>
                                                <td><label id="latecheckinlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">5</td>
                                                <td><label style="font-size: 14px;">Early PunchOut</label></td>
                                                <td><label id="earlycheckoutlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">6</td>
                                                <td><label style="font-size: 14px;">Late PunchIn & Early PunchOut</label></td>
                                                <td><label id="latecheckinandoutlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">7</td>
                                                <td><label style="font-size: 14px;">Incomplete Punch</label></td>
                                                <td><label id="incompletepunchlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">8</td>
                                                <td><label style="font-size: 14px;">Day Off</label></td>
                                                <td><label id="dayofflbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">9</td>
                                                <td><label style="font-size: 14px;">Holiday</label></td>
                                                <td><label id="holidaylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">10</td>
                                                <td><label style="font-size: 14px;">On Leave</label></td>
                                                <td><label id="onleavelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">11</td>
                                                <td><label style="font-size: 14px;">Unscheduled Work Presence Pending</label></td>
                                                <td><label id="offshiftlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">12</td>
                                                <td><label style="font-size: 14px;">Unscheduled Work Presence Approved</label></td>
                                                <td><label id="offshiftapp" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;">13</td>
                                                <td><label style="font-size: 14px;">Unscheduled Work Presence Rejected</label></td>
                                                <td><label id="offshiftrej" style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display: none;">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <table id="monthlyReport" class="display table-bordered defaultdatatable nowrap" style="width: 100%">
                                    <thead> 
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Shift</th>
                                            <th>Timetable</th>
                                            <th>Time</th>
                                            <th>Type</th>
                                            <th>Work Hour Usual</th>
                                            <th>Work Hour Pending/ Reject</th>
                                            <th>Break Hour Usual</th>
                                            <th>Break Hour Pending/ Reject</th>
                                            <th>Overtime Usual</th>
                                            <th>Overtime Pending/ Reject</th>
                                            <th>Early Punch In</th>
                                            <th>Late Punch In</th>
                                            <th>Late Punch Out</th>
                                            <th>Early Punch Out</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="footerclstotal" colspan="6" style="text-align: right;">Total</td>
                                            <td class="monthlyworkhour"></td>
                                            <td class="monthlyworkhourpen"></td>
                                            <td class="monthlybreakhour"></td>
                                            <td class="monthlybreakhourpen"></td>
                                            <td class="monthlyovertime"></td>
                                            <td class="monthlyovertimepen"></td>
                                            <td class="monthlyearlypunchin"></td>
                                            <td class="monthlylatepunchin"></td>
                                            <td class="monthlylatepunchout"></td>
                                            <td class="monthlyearlypunchout"></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <table id="hourSummaryData" class="display table-bordered defaultdatatable nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Session</th>
                                            <th>Total Hour</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Work Hour Usual</td>
                                            <td class="monthlyworkhour"></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Work Hour Pending/ Rejected</td>
                                            <td class="monthlyworkhourpen"></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Break Hour Usual</td>
                                            <td class="monthlybreakhour"></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Break Hour Pending/ Rejected</td>
                                            <td class="monthlybreakhourpen"></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Overtime Usual</td>
                                            <td class="monthlyovertime"></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Overtime Pending/ Rejected</td>
                                            <td class="monthlyovertimepen"></td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Early Punch In</td>
                                            <td class="monthlyearlypunchin"></td>
                                        </tr>

                                        <tr>
                                            <td>8</td>
                                            <td>Late Punch In</td>
                                            <td class="monthlylatepunchin"></td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>Late Punch Out</td>
                                            <td class="monthlylatepunchout"></td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>Early Punch Out</td>
                                            <td class="monthlyearlypunchout"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <table>
                                 <tr style="display: none;">
                                    <td><label style="font-size: 14px;">Works On-Holiday</label></td>
                                    <td><label id="worksonholidaylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                </tr>
                                <tr style="display: none;">
                                    <td><label style="font-size: 14px;">Works On-Leave</label></td>
                                    <td><label id="worksonleavelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                </tr>
                                <tr style="display: none">
                                    <td><label style="font-size: 14px;">Others</label></td>
                                    <td><label id="otherslbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="text-align: left">
                                    <button id="monthlyprinttable" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm printattlog" title="Print" style="color: #4B5563"><i class="fa-solid fa-print fa-lg" aria-hidden="true"></i></button>
                                    <button id="monthlyexporttoexcel" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm exportattlogtoexcel" title="Export to Excel" style="color: #15803D"><i class="fa-solid fa-file-excel fa-lg" aria-hidden="true"></i></button>
                                    <button id="monthlyexportpdf" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm exportattlogtopdf" title="Export to PDF" style="color: #B91C1C"><i class="fa-solid fa-file-pdf fa-lg" aria-hidden="true"></i></button>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="text-align: right">
                                    <input type="hidden" class="form-control" name="hiddenBranchMonthly" id="hiddenBranchMonthly" readonly="true">
                                    <input type="hidden" class="form-control" name="hiddenEmployeeIdMonthly" id="hiddenEmployeeIdMonthly" readonly="true">
                                    <input type="hidden" class="form-control" name="hiddenCurrentTimeMonthly" id="hiddenCurrentTimeMonthly" readonly="true"/>
                                    <input type="hidden" class="form-control" name="hiddenyearmonth" id="hiddenyearmonth" readonly="true"/>
                                    <input type="hidden" class="form-control" name="hiddenemployeeid" id="hiddenemployeeid" readonly="true"/>
                                    <input type="hidden" class="form-control" name="monthlyposition" id="monthlyposition" readonly="true"/>
                                    <input type="hidden" class="form-control" name="monthlydepartment" id="monthlydepartment" readonly="true"/>
                                    <button id="approverejectbtn" type="button" class="btn btn-info">Approve / Reject Unscheduled Work Presence</button>
                                    <button id="closebuttondmonthlyinfo" type="button" class="btn btn-danger" onclick="closeDailyInfoFn()" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="monthlyUpdateModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="monthlyupdateform">Edit Attendance</h4>
                    <div class="row">
                        <h4 style="text-align: right" id="editmonthdisplay"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeDailyInfoFn()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="MonthlyUpdateForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-5 col-md-12 col-sm-12 mt-1"></div>
                            <div class="col-xl-7 col-md-12 col-sm-12 mt-1">
                                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mt-1" style="text-align: center;">
                                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto mt-2">
                                        <img id="edmonthemployeepic" src="../../../storage/uploads/HrEmployee/dummypic.jpg" alt="-" class="d-block h-auto ms-0 ms-sm-2 rounded" width="60" height="60">
                                    </div>
                                    <div class="flex-grow-0 mt-0 mt-sm-0" style="margin-left: -25px;">
                                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                            <div class="user-profile-info" style="text-align: left;margin-top:-20px;">
                                                <h3 id="edmonthempname" title="Employee Full Name"></h3>
                                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="eddepartmentlbl" title="Department"></label>
                                                    </li>
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="edpositionlbl" title="Position"></label>
                                                    </li>
                                                    {{-- <li class="list-inline-item d-flex gap-1">
                                                        <i class="ti ti-calendar"></i> Joined April 2021
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-1"/>
                        
                        <div class="row">
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="nav-vertical nav-horizontal scrollhor" style="overflow-y: scroll;height:40rem">
                                    <ul class="nav nav-tabs nav-left flex-column" role="tablist" id="verticaledittab"></ul> 
                                </div>
                            </div>
                            <div class="col-xl-10 col-md-6 col-sm-6 mt-1">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-sm-6 mt-1">
                                        <h3 id="dateupdatedom"></h3>
                                    </div>
                                    <div class="col-xl-6 col-md-8 col-sm-6 mt-1" style="text-align: right;">
                                        <h3 id="editstatusdom"></h3>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mt-1">
                                        <label style="font-size: 14px;font-weight:bold;">Assigned Shift & Timetable</label>
                                        <div id="assignedshiftandtime"></div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 mt-2">
                                        <table id="attdynamictable" class="mb-0 rtable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width:12%">Time</th>
                                                    <th style="width:22%">Punch Type</th>
                                                    <th style="width:40%">Remark</th>
                                                    <th style="width:15%">Record Type</th>
                                                    <th style="width:4%"></th>                                             
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <table class="mt-0 mb-0">
                                            <tr>
                                                <td>
                                                    <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                <td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="fulldayformatval" id="fulldayformatval" readonly="true">
                        <input type="hidden" class="form-control" name="employeeidval" id="employeeidval" readonly="true">
                        <button id="updatebutton" type="button" class="btn btn-info">Update</button>
                        <button id="closeupdatemodal" type="button" class="btn btn-danger" onclick="closeDailyInfoFn()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                        <label strong style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this holiday?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="delRecId" id="delRecId" readonly="true">
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

    <!--Start Device Attendance Log Modal -->
    <div class="modal fade" id="attendancelogmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import Attendance Log from Device</h4>
                    <div class="row">
                        <div style="text-align: right" id="attendancestatus"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="attendanceImportLogForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row mt-1 mb-1">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <label style="font-size: 14px;">Device Type</label><label style="color: red; font-size:16px;">*</label>
                                    <select class="select2 form-control" name="DeviceType" id="DeviceType" onchange="deviceTypeFn()">
                                        <option value="1">Generic Device</option>
                                        <option value="2">ZKT</option>
                                    </select>
                                    <span class="text-danger">
                                        <strong id="devicetype-error" class="errordatalabel"></strong>
                                    </span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <label style="font-size: 14px;">Devices</label><label style="color: red; font-size:16px;">*</label>
                                    <select class="select2 form-control" name="Devices" id="Devices" onchange="devicesFn()">
                                        <option selected disabled></option>
                                        @foreach ($devices as $devices)
                                        <option value="{{$devices->id}}">{{$devices->DeviceName}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        <strong id="devices-error" class="errordatalabel"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row mt-1 mb-1" style="display: none;">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <label style="font-size: 14px;">Import Date Range</label><label style="color: red; font-size:16px;">*</label>
                                    <div>
                                        <input type="text" class="form-control" id="ImportMachineDateRange" name="ImportMachineDateRange" placeholder="YYYY-MM-DD HH:MM to YYYY-MM-DD HH:MM" readonly="readonly" onchange="importDateRangeFn()" style="background-color:#FFFFFF" value=""/>
                                    </div>
                                    <span class="text-danger">
                                        <strong id="importdaterange-error" class="errordatalabel"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="importbutton" type="button" class="btn btn-info">Import</button>
                        <button id="closebuttonl" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Device Attendance Log Modal -->

    <!--Start Excel Attendance Log Modal -->
    <div class="modal fade" id="attendanceexcellogmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import Attendance Log from Excel</h4>
                    <div class="row">
                        <div style="text-align: right" id="attendanceexcelstatus"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="attImportExcelLogForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row mt-1">
                                <div class="col-lg-3 col-md-4 col-4">
                                    <label style="font-size: 14px;">Device Type</label><label style="color: red; font-size:16px;">*</label>
                                    <select class="select2 form-control" name="DeviceTypeExcelLog" id="DeviceTypeExcelLog" onchange="deviceLogExcelFn()">
                                        <option value="1">Generic Device</option>
                                        <option value="2">ZKT</option>
                                    </select>
                                    <span class="text-danger">
                                        <strong id="devicetypeexcel-error" class="errordatalabel"></strong>
                                    </span>
                                </div>
                                <div class="col-lg-3 col-md-2 col-2">
                                    <label style="font-size: 14px;">Devices</label><label style="color: red; font-size:16px;">*</label>
                                    <select class="select2 form-control" name="DevicesExcel" id="DevicesExcel" onchange="devicesExcelFn()">
                                        <option selected disabled></option>
                                        @foreach ($devicesexcel as $devicesexcel)
                                        <option value="{{$devicesexcel->id}}">{{$devicesexcel->DeviceName}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        <strong id="devicesexcel-error" class="errordatalabel"></strong>
                                    </span>
                                </div>
                                <div class="col-lg-3 col-md-4 col-4">
                                    <label style="font-size: 14px;">Browse File</label><label style="color: red; font-size:16px;">*</label>
                                    <input class="form-control fileuploads" type="file" id="BrowseFile" name="BrowseFile" accept=".xlsx" onchange="browseFileFn()">
                                    <span class="text-danger">
                                        <strong id="browsefile-error" class="errordatalabel"></strong>
                                    </span>
                                </div>
                                <div class="col-lg-3 col-md-2 col-2" style="text-align: right;">
                                    </br><label id="recordnum" style="font-size: 14px;"></label>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">-</div>
                            </div>                            
                            <div class="row mt-1 mb-1 scrollhor" style="overflow-y: scroll;height:30rem;">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div id="excel_data"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" id="totallogrecord" name="totallogrecord" readonly="readonly" value=""/>
                        <button id="importexcelbutton" type="submit" class="btn btn-info">Import</button>
                        <button id="closebuttonl" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Excel Attendance Log Modal -->

    <!--Start approve or reject modal -->
    <div class="modal fade" id="approveoffshiftmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document" style="max-width: 70%; margin-left: 15%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Approve / Reject Unscheduled Work Presence</h4>
                    <div class="row">
                        <div style="text-align: right" id="attendancestatus"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="approverejectform">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row mt-1 mb-1">
                            <div class="col-lg-12 col-md-12 col-12">
                                <h3 id="approvemployeename" title="Employee Full Name"></h3>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-lg-12 col-md-12 col-12" style="text-align: right;">
                                <span class="text-danger">
                                    <strong id="attendancerecords-error"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-12 col-md-12 col-12">
                                <table id="dynamicTable" class="mb-0 rtable" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th style="width:3%;">#</th>
                                            <th style="width:32%">Date</th>
                                            <th style="width:32%">Attendance Status</th>
                                            <th style="width:30%">Approve / Reject Status</th>
                                            <th style="width:3%"><input class="hummingbird-end-node attendanceall" style="width:15px;height:15px;accent-color:#7367f0;" id="attendanceall" name="attendancesall" type="checkbox"/></th>
                                        </tr>
                                    <thead>
                                    <tbody id="dynamicTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="changetopendingbtn" type="button" class="btn btn-info offshiftconbtn">Change to Pending</button>
                        <button id="approveoffshiftbtn" type="button" class="btn btn-info offshiftconbtn">Approve</button>
                        <button id="rejectoffshiftbtn" type="button" class="btn btn-info offshiftconbtn">Reject</button>
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End approve or reject modal -->

    <!--Start confirmation modal -->
    <div class="modal fade text-left" id="confirmationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="confirmationForm">
                    @csrf
                    <div class="modal-body" id="modalbodycontent">
                        <label id="confirmationlbl" style="font-size: 16px;font-weight:bold;"></label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="selectedRecordsArr" id="selectedRecordsArr" readonly="true">
                            <input type="hidden" class="form-control" name="conType" id="conType" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="confirmationbtn" type="button" class="btn btn-info"></button>
                        <button id="closebuttonq" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End confirmation modal -->

    <!-- start activity detail info modal-->
    <div class="modal modal-slide-in event-sidebar fade" id="activitydetailmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <form id="ActivityDetailForm">    
            <div class="modal-dialog sidebar-xl" style="width: 25%;height:25%;border:1px solid black">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeScheduleDetailFn()" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title">Activity Detail Information</h4>
                        <div style="text-align: center;padding-right:30px;" id="activityDetStatus"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-0" id="activityDetailBody">
                       <div class="row">
                            <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12 mt-1">
                                <table style="width:100%">
                                    <tr>
                                        <td style="width:30%;">Punch Type</td>
                                        <td style="width:70%;"><label id="punchtypeactivitylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td>Time</td>
                                        <td><label id="timeactivitylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td>Record Type</td>
                                        <td><label id="recordtypeactivitylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td>Remark</td>
                                        <td><label id="remarkactivitylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end activity detail info modal-->

    <!-- start shift info modal-->
    <div class="modal modal-slide-in event-sidebar fade" id="shiftinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <form id="shiftInformationForm">    
            <div class="modal-dialog sidebar-xl" style="width: 30%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title">Shift Information</h4>
                        <div style="text-align: center;padding-right:30px;" id="shiftstatuslbl"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-0">
                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-1">
                            <section id="collapsible">
                                <div class="card collapse-icon">
                                    <div class="collapse-default">
                                        <div class="card">
                                            <div id="headingCollapse2" class="card-header" data-toggle="collapse" role="button" data-target=".infoshift" aria-expanded="false" aria-controls="collapse1">
                                                <span class="lead collapse-title">Shift & Action Information</span>
                                                <div id="shiftstatuslblA" style="font-weight: bold;font-size:15px;"></div>
                                            </div>
                                            <div id="collapse2" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse infoshift">
                                                <div class="row ml-1 mb-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td colspan="2">
                                                                    <label id="basictitle" style="font-size: 16px;font-weight:bold;">Basic Information</label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 25%"><label style="font-size: 14px;">Shift Name</label></td>
                                                                <td style="width: 75%"><label id="shiftnamelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr style="display: none;">
                                                                <td><label style="font-size: 14px;">Begininng Date</label></td>
                                                                <td><label id="beginningdatelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Cycle Number</label></td>
                                                                <td><label id="cyclenumberlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Cycle Unit</label></td>
                                                                <td><label id="cycleunitlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr style="border-bottom-style: solid;border-bottom-color:rgba(34, 41, 47, 0.2);border-bottom-width: 1px;">
                                                                <td><label style="font-size: 14px;">Description</label></td>
                                                                <td><label id="descriptionlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <section id="collapsible">
                                                            <div class="card collapse-icon">
                                                                <div class="collapse-default">
                                                                    <div class="card" style="background-color: #F2F3F4;">
                                                                        <div id="headingCollapse4" class="card-header" data-toggle="collapse" role="button" data-target=".infoactionshift" aria-expanded="false" aria-controls="collapse4">
                                                                            <span class="lead collapse-title"><b>Action Information</b></span>
                                                                        </div>
                                                                        <div id="collapse4" role="tabpanel" aria-labelledby="headingCollapse4" class="collapse infoactionshift">
                                                                            <div class="row ml-1 mb-1">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:15rem">
                                                                                    <ul id="shiftactiondiv" class="timeline mb-0 mt-0"></ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <hr class="m-1">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive scroll scrdiv" id="timetableDiv">
                                        <table id="timetableinfotbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%;">#</th>
                                                    <th style="width:20%;">Days</th>
                                                    <th style="width:75%;">Timetable(s)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table table-sm"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttonshift" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end shift info modal-->

    <!-- start timetable info modal-->
    <div class="modal modal-slide-in event-sidebar fade" id="timetableinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <form id="shiftInformationForm">    
            <div class="modal-dialog sidebar-xl" style="width: 30%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeScheduleDetailFn()" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title">Timetable Information</h4>
                        <div style="text-align: center;padding-right:30px;" id="timetableStatus"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-0">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-1" style="border-bottom-style: solid;border-bottom-color:rgba(34, 41, 47, 0.2);border-bottom-width: 1px;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td colspan="2">
                                            <label id="basictitle" style="font-size: 16px;font-weight:bold;">General Information</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%"><label style="font-size: 14px;">Timetable Name</label></td>
                                        <td style="width: 50%"><label id="timetablenamelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Punching Method</label></td>
                                        <td><label id="punchingmethodlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><label style="font-size: 14px;">Color</label></td>
                                        <td id="progressbarinfo"></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Description</label></td>
                                        <td><label id="descriptionlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Status</label></td>
                                        <td><label id="timetblstatuslbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-1" style="border-bottom-style: solid;border-bottom-color:rgba(34, 41, 47, 0.2);border-bottom-width: 1px;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td colspan="2">
                                            <label id="attendanceinfo" style="font-size: 16px;font-weight:bold;">Attendance Information</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align:center;font-weight:bold;font-size:12px">
                                            <u>Punch In</u>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Beginning In</label></td>
                                        <td><label id="beginninginlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%"><label style="font-size: 14px;">On Duty Time</label></td>
                                        <td style="width: 50%;background-color:#000000"><label id="ondutytimelbl" style="font-size: 15px;font-weight:bold;color:#FFFFFF"></label></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><label style="font-size: 14px;">Ending In</label></td>
                                        <td><label id="endinginlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Late Time</label></td>
                                        <td><label id="latetimelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align:center;font-weight:bold;font-size:12px">
                                            <u>Punch Out</u>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Beginning Out</label></td>
                                        <td><label id="beginningoutlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Off Duty Time</label></td>
                                        <td style="background-color:#000000"><label id="offdutytimelbl" style="font-size: 15px;font-weight:bold;color:#FFFFFF"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Work Time Duration</label></td>
                                        <td><label id="workhourdurationlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><label style="font-size: 14px;">Ending Out</label></td>
                                        <td><label id="endingoutlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Leave Early Time</label></td>
                                        <td><label id="leavearlytimelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Is Night Shift</label></td>
                                        <td><label id="isnightshiftlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align:center;font-weight:bold;font-size:12px" class="mb-1">
                                            <u>Overtime</u>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Early Punch-In Overtime</label></td>
                                        <td><label id="earlycheckinlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Overtime Start</label></td>
                                        <td><label id="overtimestartlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align:center;font-weight:bold;font-size:12px">
                                            <u>Break Time</u>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Break Hour Type</label></td>
                                        <td><label id="breakhourtypelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Break Start Time</label></td>
                                        <td><label id="breakstartimelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Leave Early Time Break</label></td>
                                        <td><label id="leaveearlytimebreak" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Break End Time</label></td>
                                        <td><label id="breakendtimelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><label style="font-size: 14px;">Late Time Break</label></td>
                                        <td><label id="latetimebreaklbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Break Time Duration</label></td>
                                        <td><label id="breakhourdurationlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Break Time as Work Time</label></td>
                                        <td><label id="breaktimeworktimelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Break Time as Overtime</label></td>
                                        <td><label id="breaktimeovertimelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-1" style="border-bottom-style: solid;border-bottom-color:rgba(34, 41, 47, 0.2);border-bottom-width: 1px;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td colspan="2">
                                            <label id="absentinformation" style="font-size: 16px;font-weight:bold;">Absence Information</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%"><label style="font-size: 14px;">Punch In Late for</label></td>
                                        <td style="width: 50%"><label id="checkinlatelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Punch Out Early for</label></td>
                                        <td><label id="checkoutearlylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">No Punch-In Mark as</label></td>
                                        <td><label id="nocheckinmarklbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">No Punch-Out Mark as</label></td>
                                        <td><label id="nocheckoutmarklbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <section id="collapsible">
                                    <div class="card collapse-icon">
                                        <div class="collapse-default">
                                            <div class="card">
                                                <div id="headingCollapse3" class="card-header" data-toggle="collapse" role="button" data-target=".infoactiontimetbl" aria-expanded="false" aria-controls="collapse3">
                                                    <span class="lead collapse-title">Action Information</span>
                                                </div>
                                                <div id="collapse3" role="tabpanel" aria-labelledby="headingCollapse3" class="collapse infoactiontimetbl">
                                                    <div class="row ml-1 mb-1">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:26rem">
                                                            <ul id="timetblactiondiv" class="timeline mb-0 mt-0"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttontimetable" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end timetable info modal-->

    <div id="pdfLoading" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:#00000080;color:white;z-index:9999;text-align:center;padding-top:20%;">
        <div style="font-size:20px;font-weight:bold;">Preparing Report...</div>
    </div>

    <script type="text/javascript">
        var endtimeval="23:59";
        var errorcolor="#ffcccc";
        var currentdateval=$('#currentdatefullfm').val();
        var objecteditdata="";
        var logRecordInterval="";
        var colorMap={};

        var presenticon='<i class="fa-regular fa-circle-check fa-lg" style="color: #4caf50;"></i>';
        var lateorearlyicon='<i class="fa-sharp fa-solid fa-timer fa-lg" style="color: #f6c23e;"></i>';
        var lateic='<i class="fa-regular fa-clock fa-lg" style="color: #f6c23e;"></i>';
        var latecheckout='<i class="fa-regular fa-clock fa-lg" style="color: #ea5455;"></i>';
        var holiday='<i class="fas fa-star fa-lg" style="color: #4e73df;"></i>';
        var absenticon='<i class="fa-regular fa-circle-xmark fa-lg" style="color: #ea5455;"></i>';
        var incompleteicon='<i class="far fa-exclamation-circle fa-lg" style="color: #ea5455;"></i>';
        var checkinoptionalicon='<i class="fa-solid fa-star-sharp fa-lg" style="color: #4e73df;"></i>';
        var offshifticon='<i class="fa-solid fa-diamond fa-lg" style="color: #4caf50;"></i>';
        var offshiftpenicon='<i class="fa-solid fa-diamond fa-lg" style="color: #f6c23e;"></i>';
        var offshiftrejicon='<i class="fa-solid fa-diamond fa-lg" style="color: #ea5455;"></i>';
        var partiallypresenticon='<i class="fa-regular fa-circle-half-stroke fa-lg" style="color: #4caf50;"></i>';
        var onleaveicon='<i class="fa-solid fa-umbrella-beach fa-lg" style="color: #4e73df;"></i>';
        var onleavehalficon='<i class="fa-solid fa-umbrella-beach fa-lg" style="color: #000000;"></i>';
        var worksonleaveicon='<i class="fa-solid fa-umbrella-beach fa-lg" style="color: #f6c23e;"></i>';
        var worksonleaveiconrej='<i class="fa-solid fa-umbrella-beach fa-lg" style="color: #ea5455;"></i>';
        var worksonleaveiconapp='<i class="fa-solid fa-umbrella-beach fa-lg" style="color: #4caf50;"></i>';
        var dayofficon='<i class="fa-duotone fa-shield fa-lg" style="color: #00cfe8;"></i>';
        var worksonholiday='<i class="fas fa-star fa-lg" style="color: #f6c23e;"></i>';
        var worksonholidayrej='<i class="fas fa-star fa-lg" style="color: #ea5455;"></i>';
        var worksonholidayapp='<i class="fas fa-star fa-lg" style="color: #4caf50;"></i>';
        var problmeondayicon='';

        $(function () {
            cardSection = $('#page-block');
        });

        var j = 0;
        var i = 0;
        var m = 0;
        var att_table = "";

        $(document).ready( function () {
            getAllData();
        });

        function getAllData(){
            $('#filter_div').hide();
            var months = $('#Month').val();
            //var months = "2025-06";
            $('#dataTableDiv').empty();
            var tableId = `table_${months}`; // Unique dynamic ID
            var tableHtml = 
                `<table id=${tableId} class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="table-layout:fixed;text-align:left;width: 100%;">
                    <thead></thead>
                    <tbody class="table table-sm"></tbody>
                </table>`;
            $('#dataTableDiv').append(tableHtml);
            var ind=0;
            var diff=0;
            let columnval=[];
            let hiddvals=[];
            var datas="";
            var backcolor="";
            var forecolor="";
            var month="";
            var currdatevalue="";
            //$("#theadval").empty();
            var currdate=$('#currentdayval').val();
            $.ajax({
                url: '/getalldays',
                type: 'POST',
                data:{
                    month:months,
                },
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
                success: function(data) {
                    let days = data.days;
                    let year = data.year;
                    let currentyear = data.currentyear;
                    let columns = [
                        { data: 'branches_id', 'visible': false},
                        { data: 'departments_id', 'visible': false},
                        { data: null, 
                            render: function (data, type, row, meta) {
                                return meta.row + 1; // 0-based index, add 1 for display
                            },
                            orderable: false,
                            searchable: false,
                            width:"3%"
                        },
                        { data: 'EmployeeName',
                            render: function(data,type,row,meta) {
                                if(row.ActualPicture != null || row.BiometricPicture != null){
                                    return row.ActualPicture != null ? `<div class="row"><div class="col-xl-3 col-lg-3"><span class="avatar" style="padding: 0px 0px 0px 0px;"><img class="round" src="../../../storage/uploads/HrEmployee/${row.ActualPicture}" alt="" height="65" width="60"></span></div><div class="col-xl-9 col-lg-9" style="font-size:10px;"><b>${data},</br><i class="fas fa-id-badge"></i> ${row.EmpCode}</b></br><i style="font-size:10px;"><i class="fas fa-code-branch"></i> ${row.Branch}</br><i class="fas fa-building"></i> ${row.Department}</br><i class="fas fa-arrows-alt"></i> ${row.Position}</i></div></div>`
                                    : `<div class="row"><div class="col-xl-3 col-lg-3"><span class="avatar" style="padding: 0px 0px 0px 0px;"><img class="round" src="../../../storage/uploads/BioEmployee/${row.BiometricPicture}" alt="" height="65" width="60"></span></div><div class="col-xl-9 col-lg-9" style="font-size:10px;"><b>${data},</br><i class="fas fa-id-badge"></i> ${row.EmpCode}</b></br><i style="font-size:10px;"><i class="fas fa-code-branch"></i> ${row.Branch}</br><i class="fas fa-building"></i> ${row.Department}</br><i class="fas fa-arrows-alt"></i> ${row.Position}</i></div></div>`;
                                }
                                if(row.ActualPicture == null && row.BiometricPicture == null){
                                    return `<div class="row"><div class="col-xl-3 col-lg-3"><span class="avatar" style="padding: 0px 0px 0px 0px;"><img class="round" src="../../../storage/uploads/HrEmployee/dummypic.jpg" alt="" height="65" width="60"></span></div><div class="col-xl-9 col-lg-9" style="font-size:10px;"><b>${data},</br><i class="fas fa-id-badge"></i> ${row.EmpCode}</b></br><i style="font-size:10px;"><i class="fas fa-code-branch"></i> ${row.Branch}</br><i class="fas fa-building"></i> ${row.Department}</br><i class="fas fa-arrows-alt"></i> ${row.Position}</i></div></div>`;
                                }
                            },
                            width:"13%"
                        },
                    ];

                    for (let i = 1; i <= days; i++) {
                        columns.push(
                            {   data: "day_" + i,
                                render: function(data,type,row,meta) {
                                    if(data == 1){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Absent">${absenticon}</a></div>`;
                                    }
                                    else if(data == 2){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Present">${presenticon}</a></div>`;
                                    }
                                    else if(data == 3){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Partially-Present">${partiallypresenticon}</a></div>`;
                                    }
                                    else if(data == 4){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Late-Punch-In">${lateic}</a></div>`;
                                    }
                                    else if(data == 5){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Early-Punch-In">${presenticon}</a></div>`;
                                    }
                                    else if(data == 6){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Early-Punch-Out">${lateic}</a></div>`;
                                    }
                                    else if(data == 7){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Late-Punch-Out">${presenticon}</a></div>`;
                                    }
                                    else if(data == 8){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Incomplete Punch">${incompleteicon}</a></div>`;
                                    }
                                    else if(data == 9){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Day-Off">${dayofficon}</a></div>`;
                                    }
                                    else if(data == 10){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Holiday">${holiday}</a></div>`;
                                    }
                                    else if(data == 110){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="On-Leave">${onleaveicon}</a></div>`;
                                    }
                                    else if(data == 111){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="On-Leave (Half Day)">${onleavehalficon}</a></div>`;
                                    }
                                    else if(data == 121){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Works-On-Leave">${worksonleaveiconapp}</a></div>`;  
                                    }
                                    else if(data == 122){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Works-On-Leave">${worksonleaveiconrej}</a></div>`;
                                    }
                                    else if(data == 120 || data == 12){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Works-On-Leave">${worksonleaveicon}</a></div>`;
                                    }
                                    else if(data == 131){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Off-Schedule-Punch">${offshifticon}</a></div>`;  
                                    }
                                    else if(data == 132){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Off-Schedule-Punch">${offshiftrejicon}</a></div>`;
                                    }
                                    else if(data == 130 || data == 13){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Off-Schedule-Punch">${offshiftpenicon}</a></div>`;
                                    }
                                    else if(data == 14){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Late-Punch-In & Early-Punch-Out">${latecheckout}</a></div>`;
                                    }
                                    else if(data == 151){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Works-On-Holiday">${worksonholidayapp}</a></div>`;
                                    }
                                    else if(data == 152){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Works-On-Holiday">${worksonholidayrej}</a></div>`;
                                    }
                                    else if(data == 150 || data == 15){
                                        return `<div style="text-align:center;"><a onclick=openDailyInfo(${i},${row.EmpId},${data}) title="Works-On-Holiday">${worksonholiday}</a></div>`;
                                    }
                                    else{
                                        return '';
                                    }
                                },
                            }
                        );
                    }
                    columns.push({ data: 'Action',width: "4%"});

                    let headercontent='<tr><th style="display:none;"></th><th style="display:none;"></th><th style="text-align:left;width:3%;">#</th><th style="text-align:left;width:13%;">Employee Name, Employee ID </br> Branch | Department | Position</th>';
                    $.each(data.dates, function(key, value) {
                        ind= ++key;
                        if(parseInt(ind)<=9){
                            ind="0"+ind;
                        }
                        currdatevalue = value.replace(/\s/g, '');
                        let currdateref = currdate+"-"+currentyear;
                        let currdatevalueref = currdatevalue+"-"+year;
                        
                        if(currdateref == currdatevalueref){
                            backcolor="#4CAF50";
                            forecolor="#FFFFFF";
                        }
                        else if(currdateref != currdatevalueref){
                            backcolor="#FFFFFF";
                            //backcolor="#F3F4F6";
                            forecolor="#5E5873";
                        }
                        let wrappeddate = value.split("-"); // Split by "-"
                        headercontent+='<th style="text-align:left;background-color:'+backcolor+';color:'+forecolor+';">'+value+'</th>';
                    }); 

                    headercontent += '<th style="text-align:left;width:4%;">Action</th></tr>';
                    $("#"+tableId+" thead").html(headercontent);
                    
                    if ($.fn.DataTable.isDataTable("#"+tableId)) {
                        $("#"+tableId).DataTable().destroy();
                    }
                    
                    att_table = $("#"+tableId).DataTable({
                        destroy: true,
                        processing: true,
                        responsive: true,
                        searchHighlight: true,
                        "order": [[3, "asc"]],
                        "pagingType": "simple",
                        "lengthMenu": [50,100],
                        language: {
                            search: '',
                            searchPlaceholder: "Search here"
                        },
                        scrollY:'55vh',
                        scrollX: true,
                        scrollCollapse: true,
                        "dom": "<'row'<'col-sm-12 col-md-3'f><'col-sm-12 col-md-6 mb-3 left-dom'><'col-sm-12 col-md-3 custom-buttons'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                        data: data.data,
                        columns: columns,
                        "initComplete": function () {
                            $('.custom-buttons').html(`
                                <div class="btn-group">
                                    @can('Attendance-Manual-Add')
                                    <button type="button" class="btn btn-gradient-info btn-sm addattendance" id="addattendance" data-toggle="modal">Add</button>
                                    @endcan
                                    @if (auth()->user()->can('Attendance-Import-Device-Log') || auth()->user()->can('Attendance-Import-Excel-Log'))
                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split waves-effect waves-float waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-105px, 29px, 0px);" x-placement="bottom-end">
                                        @can('Attendance-Import-Device-Log')
                                        <a class="dropdown-item ImportDeviceLog" id="ImportDeviceLog" title="Import Attendance Log from Device">Import Attendance Log from Device</a>
                                        @endcan
                                        @can('Attendance-Import-Excel-Log')
                                        <a class="dropdown-item ImportExcelLog" id="ImportExcelLog" title="Import Attendance Log from Excel">Import Attendance Log from Excel</a>
                                        @endcan
                                    </div>
                                    @endif
                                </div>
                            `);
                            $('.left-dom').html(``);
                        },
                        drawCallback: function () { 
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
                            $('#filter_div').show();    
                        },
                    });

                    att_table.on('order.dt search.dt draw.dt', function () {
                        att_table.column(2, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    });

                    $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
                }
            });

            fetchBranchDepartment();
            $('#Month').selectpicker('refresh');
        }

        function fetchBranchDepartment(){
            var month = $('#Month').val();
            $('#Branch').empty(); 
            $('#Department').empty(); 

            var branchoption = $("#BranchDefault > option").clone();
            var departmentoption = $("#DepartmentDefault > option").clone();

            $('#Branch').append(branchoption);
            $('#Department').append(departmentoption);

            $('#Branch option').each(function () {
                var data_month = $(this).attr('data-month'); 
                if(month != data_month){
                    $(this).remove(); 
                }
            });

            $('#Department option').each(function () {
                var data_month = $(this).attr('data-month'); 
                if(month != data_month){
                    $(this).remove(); 
                }
            });

            $('#Branch').find('option').prop('selected', true);
            $('#Department').find('option').prop('selected', true);

            $('.dropdownclass').selectpicker('refresh');
        }

        $('#Branch').change(function(){
            var month = $('#Month').val();
            var selected = $('#Branch option:selected');
            var search = [];

            // Collect selected option values
            $.each(selected, function() {
                search.push($(this).val());
            });

            if (search.length === 0) {
                // No option selected: force DataTable to return no data
                att_table.column(0).search('^$', true, false).draw(); // Match an impossible pattern
            } else {
                // Options selected: build regex for filtering
                var searchRegex = search.join('|'); // OR-separated values for regex
                att_table.column(0).search(searchRegex, true, false).draw();
            }
        });

        $('#Department').change(function() {
            var selected = $('#Department option:selected');
            var search = [];

            // Collect selected option values
            $.each(selected, function() {
                search.push($(this).val());
            });

            if (search.length === 0) {
                // No option selected: force DataTable to return no data
                att_table.column(1).search('^$', true, false).draw(); // Match an impossible pattern
            } else {
                // Options selected: build regex for filtering
                var searchRegex = search.join('|'); // OR-separated values for regex
                att_table.column(1).search(searchRegex, true, false).draw();
            }
        });

        $(document).on('click', '#addattendance', function () {
            getAllEmployee();
            $('.mainforminp').val("");
            $('.errordatalabel').html('');
            flatpickr('#Time', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:"00:00",maxTime:endtimeval,defaultHour:"",static:true});
            $('#recId').val("");
            $('#operationtypes').val("1");
            $("#modaltitle").html("Add Manual Attendance");
            $('#savebutton').text('Save & Close');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').text('Save & New');
            $('#savenewbutton').prop("disabled",false);
            $('#savebutton').show();
            $('#savenewbutton').show();
            $('#durationdiv').hide();
            $('#selectalldep').prop('checked', false); 
            $('#AttendanceDateRange').daterangepicker({ 
                showDropdowns: true,
                autoApply:false,
                maxDate:currentdateval,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('#PunchType').select2({
                placeholder: "Select punch type here",
                minimumResultsForSearch: -1
            });
            $('#AttendanceDateRange').val(""); 
            $('#selectalldiv').show();
            $("#inlineForm").modal('show');
        });

        $(document).on('click', '#ImportDeviceLog', function () {
            $('.errordatalabel').html('');
            $('#DeviceType').val("1");
            $('#DeviceType').select2({
                minimumResultsForSearch: -1
            });

            $('#Devices').val(null).select2({
                placeholder:"Select device here"
            });

            $('#ImportMachineDateRange').daterangepicker({ 
                timePicker: true,
                timePicker24Hour:true,
                showDropdowns: true,
                autoApply:false,
                maxDate:currentdateval+" 23:59:59",
                locale: {
                    format: 'YYYY-MM-DD HH:mm'
                }
            });
            $('#ImportMachineDateRange').val(""); 
            $('#importbutton').text('Import');
            $('#importbutton').prop("disabled",false);
            $("#attendancelogmodal").modal('show');
        });

        $(document).on('click', '#ImportExcelLog', function () {
            $('.errordatalabel').html("");
            $('#DeviceTypeExcelLog').val("1");
            $('#DeviceTypeExcelLog').select2({
                minimumResultsForSearch: -1
            });

            $('#DevicesExcel').val(null).select2({
                placeholder:"Select device here"
            });
            $('#BrowseFile').val(null);
            $('#recordnum').html("");
            $('#excel_data').hide();
            $("#attendanceexcellogmodal").modal('show');
        });
       
        $('#savebutton').click(function() { 
            var datatableid = "table_"+$("#Month").val();
            
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/saveAttendance',
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
                        if (data.errors.AttendanceDateRange) {
                            $('#date-error').html(data.errors.AttendanceDateRange[0]);
                        }
                        if (data.errors.Time) {
                            $('#time-error').html(data.errors.Time[0]);
                        }
                        if (data.errors.PunchType) {
                            $('#punchtype-error').html(data.errors.PunchType[0]);
                        }
                        if (data.errors.employees) {
                            $('#employeelist-error').html("at-least one employee should be selected");                       }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save & Close');
                            $('#savebutton').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }  
                        toastrMessage('error',"Please check your input","Error");
                    }
                    
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save & Close');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.perror) {
                        var employeename="";
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save & Close');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        
                        $.each(data.getempnames, function(index, value) {
                            employeename+=value.name+"  "+value.Date+"</br>";
                        });
                        toastrMessage('error',"Payroll is made for the following Employee and Date </br>-------------- </br>"+employeename,"Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save & Close');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('success',"Successful","Success");
                        closeRegisterModal();
                        getAllData();
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        $('#savenewbutton').click(function() {
            var datatableid = "table_"+$("#Month").val();
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/saveAttendance',
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

                    $('#savenewbutton').text('Saving...');
                    $('#savenewbutton').prop("disabled", true);
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
                        if (data.errors.AttendanceDateRange) {
                            $('#date-error').html(data.errors.AttendanceDateRange[0]);
                        }
                        if (data.errors.Time) {
                            $('#time-error').html(data.errors.Time[0]);
                        }
                        if (data.errors.PunchType) {
                            $('#punchtype-error').html(data.errors.PunchType[0]);
                        }
                        if (data.errors.employees) {
                            $('#employeelist-error').html("at-least one employee should be selected");
                        }

                        if(parseFloat(optype)==1){
                            $('#savenewbutton').text('Save & New');
                            $('#savenewbutton').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savenewbutton').text('Update');
                            $('#savenewbutton').prop("disabled", false);
                        }  
                        toastrMessage('error',"Please check your input","Error");
                    }
                    
                    else if (data.dberrors) {
                        $('#savenewbutton').text('Save & New');
                        $('#savenewbutton').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.perror) {
                        var employeename="";
                        $('#savenewbutton').text('Save & New');
                        $('#savenewbutton').prop("disabled", false);
                        
                        $.each(data.getempnames, function(index, value) {
                            employeename+=value.name+"  "+value.Date+"</br>";
                        });
                        toastrMessage('error',"Payroll is made for the following Employee and Date </br>-------------- </br>"+employeename,"Error");
                    }
                    else if(data.success){
                        $('#savenewbutton').text('Save & New');
                        $('#savenewbutton').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        getAllData();
                        closeRegisterModal();
                    }
                }
            });
        });

        $('#updatebutton').click(function() {
            var registerForm = $("#MonthlyUpdateForm");
            var formData = registerForm.serialize();
            var employeeid=$("#employeeidval").val();
            var fulldateformat=$("#fulldayformatval").val();

            $.ajax({
                url: '/updateAttendance',
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
                    $('#updatebutton').text('Updating...');
                    $('#updatebutton').prop("disabled", true);
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
                    if(data.errorv2){
                        for(var k=1;k<=m;k++){
                            var punchtype=($('#PunchType'+k)).val();

                            if(($('#EditTime'+k).val())!=undefined){
                                var edittime=($('#EditTime'+k)).val();
                                if(edittime=="" || edittime==null){
                                    $('#EditTime'+k).css("background", errorcolor);
                                }
                            }
                            if(isNaN(parseInt(punchtype))||parseInt(punchtype)==0){
                                $('#select2-PunchType'+k+'-container').parent().css('background-color',errorcolor);
                            }
                        }
                        $('#updatebutton').text('Update');
                        $('#updatebutton').prop("disabled", false);
                        toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                    }
                    else if (data.dynamictblerror) {
                        $('#updatebutton').text('Update');
                        $('#updatebutton').prop("disabled", false);
                        toastrMessage('error',"You should add atleast one record","Error");
                    }
                    else if (data.dberrors) {
                        $('#updatebutton').text('Update');
                        $('#updatebutton').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        $('#updatebutton').text('Update');
                        $('#updatebutton').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        getAllData();
                        $("#monthlyUpdateModal").modal('hide');
                    }
                },
            });
        });

        $('#importbutton').click(function() {
            var registerForm = $("#attendanceImportLogForm");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/importAttendance',
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

                    $('#importbutton').text('Importing...');
                    $('#importbutton').prop("disabled", true);
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
                        if (data.errors.DeviceType) {
                            $('#devicetype-error').html(data.errors.DeviceType[0]);
                        }
                        if (data.errors.Devices) {
                            $('#devices-error').html(data.errors.Devices[0]);
                        }
                        if (data.errors.ImportMachineDateRange) {
                            $('#importdaterange-error').html(data.errors.ImportMachineDateRange[0]);
                        }
                        $('#importbutton').text('Import');
                        $('#importbutton').prop("disabled", false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#importbutton').text('Import');
                        $('#importbutton').prop("disabled", false);
                        toastrMessage('error',data.dberrors,"Error");
                    }
                    else if(data.success){
                        $('#importbutton').text('Import');
                        $('#importbutton').prop("disabled", false);
                        if(parseInt(data.logrecord)==0){
                            toastrMessage('info',"Log not found","Info");
                        }
                        else if(parseInt(data.logrecord)>0){
                            toastrMessage('success',data.logrecord+" log has been imported","Success");
                        }
                        getAllData();
                        $("#attendancelogmodal").modal('hide');
                    }
                },
            });
        });

        $('#attImportExcelLogForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '/importExcelAtt',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
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

                    $('#importexcelbutton').text('Importing...');
                    $('#importexcelbutton').prop("disabled", true);
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
                        if (data.errors.DeviceTypeExcelLog) {
                            var text=data.errors.DeviceTypeExcelLog[0];
                            text = text.replace("device type excel log", "device type");
                            $('#devicetypeexcel-error').html(text);
                        }
                        if (data.errors.DevicesExcel) {
                            var text=data.errors.DevicesExcel[0];
                            text = text.replace("devices excel", "device");
                            $('#devicesexcel-error').html(text);
                        }
                        if (data.errors.BrowseFile) {
                            $('#browsefile-error').html(data.errors.BrowseFile[0]);
                        }
                        $('#importexcelbutton').text('Import');
                        $('#importexcelbutton').prop("disabled", false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#importexcelbutton').text('Import');
                        $('#importexcelbutton').prop("disabled", false);
                        toastrMessage('error',data.dberrors,"Error");
                    }
                    else if(data.success){
                        $('#importexcelbutton').text('Import');
                        $('#importexcelbutton').prop("disabled", false);
                        if(parseInt(data.lognum)==0){
                            toastrMessage('info',"Log not found","Info");
                        }
                        else if(parseInt(data.lognum)>0){
                            toastrMessage('success',data.lognum+" log has been imported","Success");
                        }
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        //$("#attendanceexcellogmodal").modal('hide');
                    }
                },
            });
        });

        $('#approverejectbtn').click(function() {
            var employeeid=$("#hiddenemployeeid").val();
            var dateval=$("#hiddenyearmonth").val();
            $("#dynamicTable > tbody").empty();
            $('#attendanceall').prop('indeterminate', false); 
            $('#attendanceall').prop('checked', false); 
            $('#attendancerecords-error').html("");
            var month="";
            var employeeid="";
            j=0;

            $.ajax({
                url: '/getOffShift',
                type: 'POST',
                data:{
                    month:$('#hiddenyearmonth').val(),
                    employeeid:$('#hiddenemployeeid').val(),
                },
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
                    $.each(data.empdata, function(key,value) {
                        $('#approvemployeename').html(value.name);
                    });

                    $.each(data.attendances, function(key,value) {
                        if(parseInt(value.IsPayrollMade)!=1){
                            ++i;
                            ++m;
                            j += 1;
                            $("#dynamicTable > tbody").append(`
                                <tr><td style="font-weight:bold;text-align:center;width:3%">${j}</td>+
                                    <td style="width:32%"><input type="text" name="row[${m}][DateWithName]" placeholder="Date With Name" id="DateWithName${m}" class="Date form-control" value="${value.DateWithName}" readonly style="font-weight:bold;"/></td>
                                    <td style="width:32%"><input type="text" name="row[${m}][AttendanceStatus]" placeholder="Status" id="AttendanceStatus${m}" class="AttendanceStatus form-control" value="${value.StatusValue}" readonly style="font-weight:bold;"/></td>
                                    <td style="width:30%"><input type="text" name="row[${m}][Status]" placeholder="Status" id="Status${m}" class="Status form-control" readonly/></td>
                                    <td style="width:3%;text-align:center"><input class="hummingbird-end-node attendancecls attendances_${value.id}" style="width:15px;height:15px;accent-color:#7367f0;" id="attendanceval${value.id}" name="attendances[]" value=${value.id} type="checkbox"/> </td>
                                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value=${m}/></td>
                                    <td style="display:none;"><input type="text" name="row[${m}][Date]" placeholder="Date" id="Date${m}" class="Date form-control" value="${value.Date}" readonly/></td>
                                </tr>`);

                            if(parseInt(value.OffShiftStatus||0)==1){
                                $(`#Status${m}`).val("Approved");
                                $(`#Status${m}`).css({"color":"#28c76f","font-weight":"bold"});
                            }
                            else if(parseInt(value.OffShiftStatus||0)==2){
                                $(`#Status${m}`).val("Rejected");
                                $(`#Status${m}`).css({"color":"#ea5455","font-weight":"bold"});
                            }
                            else{
                                $(`#Status${m}`).val("Pending");
                                $(`#Status${m}`).css({"color":"#ff9f43","font-weight":"bold"});
                            }
                        }
                    });
                },
            });
            $("#approveoffshiftmodal").modal('show');
        });

        $('.offshiftconbtn').click(function() {
            var selectedrec=[];
            var checkedCheckboxes = $('#dynamicTableBody input[type="checkbox"]:checked');
            if(parseInt(checkedCheckboxes.length)==0){
                $('#attendancerecords-error').html("at-least one record should be selected");
                toastrMessage('error',"Please select at-lease one record","Error");
            }
            else if(parseInt(checkedCheckboxes.length)>0){
                
                checkedCheckboxes.each(function() {
                    selectedrec.push($(this).val());
                });

                var buttonId = $(this).attr('id');
                $('#selectedRecordsArr').val(selectedrec); 
                if(buttonId=="changetopendingbtn"){
                    $('#conType').val("0"); 
                    $('#modalbodycontent').css({"background-color": "#f6c23e"});
                    $('#confirmationlbl').css({"color": "#FFFFFF"});
                    $('#confirmationlbl').html("Are you sure about changing to pending for the selected records?");
                    $('#confirmationbtn').text("Change to Pending");
                }
                else if(buttonId=="approveoffshiftbtn"){
                    $('#conType').val("1"); 
                    $('#modalbodycontent').css({"background-color": "#1cc88a"});
                    $('#confirmationlbl').css({"color": "#FFFFFF"});
                    $('#confirmationlbl').html("Do you really want to approve selected records?");
                    $('#confirmationbtn').text("Approve");
                }
                else if(buttonId=="rejectoffshiftbtn"){
                    $('#conType').val("2"); 
                    $('#modalbodycontent').css({"background-color": "#e74a3b"});
                    $('#confirmationlbl').css({"color": "#FFFFFF"});
                    $('#confirmationlbl').html("Do you really want to reject selected records?");
                    $('#confirmationbtn').text("Reject");
                }   
                $('#confirmationbtn').prop("disabled",false);
                $("#confirmationmodal").modal('show');
            }
        });

        $('#confirmationbtn').click(function() {
            var selectedrec=null;
            var contype=null;
            var optype=$('#conType').val();
            $.ajax({
                url: '/offShiftConfirmation',
                type: 'POST',
                data:{
                    selectedrec:$('#selectedRecordsArr').val(),
                    contype:$('#conType').val(),
                },
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

                    if(parseFloat(optype)==0){
                        $('#confirmationbtn').text('Changing...');
                        $('#confirmationbtn').prop("disabled",true);
                    }
                    else if(parseFloat(optype)==1){
                        $('#confirmationbtn').text('Approving...');
                        $('#confirmationbtn').prop("disabled",true);
                    }
                    else if(parseFloat(optype)==2){
                        $('#confirmationbtn').text('Rejecting...');
                        $('#confirmationbtn').prop("disabled",true);
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
                    if (data.dberrors) {
                        if(parseFloat(optype)==0){
                            $('#confirmationbtn').text('Change to Pending');
                            $('#confirmationbtn').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==1){
                            $('#confirmationbtn').text('Approve');
                            $('#confirmationbtn').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#confirmationbtn').text('Reject');
                            $('#confirmationbtn').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    
                    else if(data.success){
                        if(parseFloat(optype)==0){
                            $('#confirmationbtn').text('Change to Pending');
                            $('#confirmationbtn').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==1){
                            $('#confirmationbtn').text('Approve');
                            $('#confirmationbtn').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#confirmationbtn').text('Reject');
                            $('#confirmationbtn').prop("disabled",false);
                        }
                        toastrMessage('success',"Successful","Success");
                        getAllData();
                        $("#confirmationmodal").modal('hide');
                        $("#approveoffshiftmodal").modal('hide');
                        $("#monthlyInfoModal").modal('hide');
                    }
                }
            });
        });

        function attendanceEditFn(recordId){
            var fday=$('#attedit'+recordId).attr('data-fday');
            var month="";
            var liopt="";
            var bodytab="";
            var ind=0;
            var indx=0;
            var classval="";
            var classes="";
            var punchtype="";
            var empid="";
            var lidata="";
            var shiftdataedit="";
            var shiftdatas="";
            var numofact=0;
            var numofshift=0;
            var productiontime=0;
            var breaktime=0;
            var earlyot=0;
            var lateot=0;
            var totalot=0;

            var productiontimemon=0;
            var breaktimemon=0;
            var earlyotmon=0;
            var lateotmon=0;
            var totalotmon=0;

            var presentcnt=0;
            var latecheckincnt=0;
            var absentcnt=0;
            var optcheckincnt=0;
            var offshiftcnt=0;
            var partiallypresentcnt=0;
            var onleavecnt=0;
            var dayoffcnt=0;
            var otherscnt=0;
            var punchtypename="";
            var attendancetype="";
            var firstdayofmonth="";
            var payrollupdateflag=0;

            $('#employeeidval').val(recordId);
            
            $('#verticaledittab').empty();
            $('#verticaledittabbody').empty();

            var currdate=$('#currentdayval').val();
            var currentdate=$('#currentdatefullfm').val();
            var cusday=(moment(currentdate).format("YYYY-MM"))+"-01";

            $.ajax({
                url: '/getAttInfo',
                type: 'POST',
                data:{
                    month:$('#Month').val(),
                    empid:recordId,
                },
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
                    $('#editmonthdisplay').html(data.formatteddate);
                    $.each(data.fulldayformat, function(key,value) {
                        ind= ++key;
                        var datedate=moment(value.FullDateFormat).format("YYYY-MM-DD");
                        var years=moment(value.FullDateFormat).format("YYYY");
                        var months=moment(value.FullDateFormat).format("MM");

                        var holidayname = `<i class="fas fa-star"></i> ${value.HolidayName}`;
                        
                        if(parseInt(months)<=9){
                            months="0"+months;
                        }
                        if(parseInt(ind)<=9){
                            ind="0"+ind;
                        }
                        if(parseInt(ind)==1){
                            classval="active";
                            $('#dateupdatedom').html(`<b><i class="fa-solid fa-calendar-days"></i>  ${value.FullDateFormat} <i>(${value.DayName})</i></b></br><h6>${value.HolidayName != "" ? holidayname : ""}</h6>`);                 
                            $('#fulldayformatval').val(datedate);    
                            firstdayofmonth=datedate;  
                        }
                        if(parseInt(ind)>1){
                            classval="";
                        }
                        if(datedate>currentdate){
                            classval="disabled";
                        }
                        
                        liopt+=`<li class="nav-item"><a class="nav-link tabdaycls ${classval}" id="tabday${ind}" onclick="editDateFn(${years},${months},${ind})" data-title="${value.FullDateFormat}" data-holiday="${value.HolidayName}">${value.FullDateFormat}</a></li>`;
                        bodytab+=`<div class="tab-pane ${classval}" id="tabodyday${ind}" aria-labelledby="tabodyday${ind}" role="tabpanel"><div class="row"><div class="col-lg-9 col-md-8 col-sm-8" style="text-align:left;"><h3><b><i class="fa-solid fa-calendar-days"></i> ${value}</b></h3></div><div class="col-lg-3 col-md-4 col-sm-4" id="attstatusdisplay${ind}" style="text-align:right;"> </div><div class="col-lg-9 col-md-8 col-sm-8 mt-1"><div class="row"><div class="col-xl-12 col-md-12 col-sm-12"><label style="font-size: 14px;font-weight:bold;">Assigned Shift & Timetable</label><div id="assignedtimediv${ind}"></div><div class="col-xl-12 col-md-12 col-sm-12 mt-1" style="padding:0px 0px 0px 0px;"><div class="border rounded p-1 mt-2"><div class="row gap-4 gap-sm-0" style="text-align: center;"><div class="col-12 col-sm-4" style="text-align: center;"><h4 class="my-0.5" id="prductionhr${ind}"></h4><h6 class="mb-0">Work Hour</h6></div><div class="col-12 col-sm-4" style="text-align: center;"><h4 class="my-0.5" id="breakhr${ind}"></h4><h6 class="mb-0">Break</h6></div><div class="col-12 col-sm-4" style="text-align: center;"><h4 class="my-0.5" id="overtimehr${ind}"></h4><h6 class="mb-0">Overtime</h6></div></div></div> </div></div></div></div><div class="col-lg-3 col-md-4 col-sm-4 mt-1"><label style="font-size: 18px;font-weight:bold;">Activity</label><ul id="activityul${ind}" class="timeline mb-0 mt-1 activitycls"></ul></div></div></div>`;
                    });

                    $('#verticaledittab').append(liopt);

                    $("#attdynamictable > tbody").empty();
                    $.each(data.attendanceslog, function(keys,value) {
                        ++i;
                        ++m;
                        j += 1;
                        $("#attdynamictable > tbody").append(`
                            <tr class="allday day${value.Date}">
                                <td style="width:12%"><input type="text" placeholder="Time" class="form-control edittimecls" name="row[${m}][EditTime]" id="EditTime${m}" onchange="timeErrorFn(this)" value="${value.Time}"/></td> 
                                <td style="width:22%"><select id="PunchType${m}" class="select2 form-control punchtypecls" name="row[${m}][PunchType]" onchange="ptypeFn(this)"></select></td>
                                <td style="width:48%"><input type="text" placeholder="Remark" class="form-control remarkcls" name="row[${m}][Remark]" id="Remark${m}" value="${value.Remark}"/></td> 
                                <td style="width:15%"><input type="text" placeholder="Attendance Type" class="form-control attypecls" name="row[${m}][AttType]" id="AttType${m}" readonly/></td>
                                <td style="width:4%;text-align:center;"><button type="button" id="removebtn${m}" class="btn btn-light btn-sm removeatt-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>   
                                <td style="width:0%;display:none;"><input type="text" class="form-control idcls" name="row[${m}][id]" id="id${m}" value="${value.id}"/></td>
                                <td style="width:0%;display:none;"><input type="text" class="form-control timetablecls" name="row[${m}][Timetable]" id="Timetable${m}" value="${value.timetables_id}"/></td> 
                                <td style="width:0%;display:none;"><input type="text" class="form-control datevalcls" name="row[${m}][Date]" id="Date${m}" value="${value.Date}"/></td>
                                <td style="width:0%;display:none;"><input type="text" class="form-control AttendanceType" name="row[${m}][AttendanceType]" id="AttendanceType${m}" value="${value.AttType}"/></td>
                                <td style="width:0%;display:none;"><input type="text" class="form-control vals" name="row[${m}][vals]" id="vals${m}" value="${m}"/></td>
                            </tr>`);

                        if(parseInt(value.IsPayrollMade)==0 || isNaN(parseInt(value.IsPayrollMade))){
                            flatpickr(`#EditTime${m}`, {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:"00:00",maxTime:endtimeval,defaultHour:value.Time,static:true});
                            if(parseInt(value.PunchType)==1){
                                punchtypename="Punch In";
                            }
                            else if(parseInt(value.PunchType)==2){
                                punchtypename="Punch Out";
                            }
                            var punchtypeopt = `<option value="1">Punch In</option><option value="2">Punch Out</option>`;
                            var punchtypedef=`<option selected value=${value.PunchType}>${punchtypename}</option>`;
                            $(`#PunchType${m}`).append(punchtypeopt);
                            $(`#PunchType${m} option[value=${value.PunchType}]`).remove(); 
                            $(`#PunchType${m}`).append(punchtypedef);
                            $(`#PunchType${m}`).select2({
                                minimumResultsForSearch: -1
                            });
                            $(`#select2-PunchType${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            
                            if(parseInt(value.AttType)==1){
                                attendancetype="Manual";
                                $(`#removebtn${m}`).show();
                            }
                            else if(parseInt(value.AttType)==2 || parseInt(value.AttType)==3){
                                attendancetype = parseInt(value.AttType) == 2 ? "Automated" : "Auto-Generate";
                                flatpickr(`#EditTime${m}`, {clickOpens:false,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:"00:00",maxTime:endtimeval,defaultHour:value.Time,static:true});
                                $(`#EditTime${m}`).val(value.Time);
                                if(parseInt(value.PunchType)==1){
                                    punchtypename="Punch In";
                                }
                                else if(parseInt(value.PunchType)==2){
                                    punchtypename="Punch Out";
                                }
                                $(`#PunchType${m}`).empty();
                                var punchtypedef=`<option selected value="${value.PunchType}">${punchtypename}</option>`;
                                $(`#PunchType${m}`).append(punchtypedef);
                                $(`#PunchType${m}`).select2({
                                    minimumResultsForSearch: -1
                                });
                                $(`#select2-PunchType${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                                
                                $(`#removebtn${m}`).hide();
                            }
                            $(`#AttType${m}`).val(attendancetype);
                            
                        }
                        else{
                            flatpickr(`#EditTime${m}`, {clickOpens:false,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:"00:00",maxTime:endtimeval,defaultHour:value.Time,static:true});
                            if(parseInt(value.PunchType)==1){
                                punchtypename="Punch In";
                            }
                            else if(parseInt(value.PunchType)==2){
                                punchtypename="Punch Out";
                            }
                            var punchtypedef=`<option selected value="${value.PunchType}">${punchtypename}</option>`;
                            $(`#PunchType${m}`).append(punchtypedef);
                            $(`#PunchType${m}`).select2({
                                minimumResultsForSearch: -1
                            });
                            $(`#select2-PunchType${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            
                            if(parseInt(value.AttType)==1){
                                attendancetype="Manual";
                            }
                            else if(parseInt(value.AttType)==2){
                                attendancetype="Automated";
                            }
                            $(`#AttType${m}`).val(attendancetype);
                            $(`#removebtn${m}`).hide();
                        }
                    });

                    $('#attdynamictable > tbody  > tr').each(function(index, tr) {
                        var ind= ++index;
                        var tabledates=$(this).find('.datevalcls').val();
                        
                        if(cusday==tabledates){
                            var payrollupd=$(this).find('.payrollclosed').val();
                            if(parseInt(payrollupd)==1){
                                payrollupdateflag+=1;
                            }
                        }
                    }); 

                    if(parseInt(payrollupdateflag)==0){
                        $('#adds').show();
                        $('#updatebutton').show();
                    }
                    else if(parseInt(payrollupdateflag)>0){
                        $('#adds').hide();
                        $('#updatebutton').hide();
                    }

                    $.each(data.empdata, function(key,value) {
                        $('#edmonthempname').html(value.name);
                        $('#eddepartmentlbl').html('<i class="fa-solid fa-landmark"></i>   '+value.DepartmentName);
                        $('#edpositionlbl').html('<i class="fa-solid fa-up-down-left-right"></i>   '+value.PositionName);
                        
                        if(value.ActualPicture!=null || value.BiometricPicture!=null){
                            $('#edmonthemployeepic').attr("src",value.ActualPicture!=null ? `../../../storage/uploads/HrEmployee/${value.ActualPicture}` : `../../../storage/uploads/BioEmployee/${value.BiometricPicture}`);
                        }
                        if(value.ActualPicture==null && value.BiometricPicture===null){
                            $('#edmonthemployeepic').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
                        }
                    });

                    $.each(data.dates, function(keys,values) {
                        lidata="";
                        shiftdatas="";
                        numofact=0;
                        numofshift=0;
                        productiontime=0;
                        breaktime=0;
                        earlyot=0;
                        lateot=0;
                        totalot=0;
                        shiftdataedit="";
                        $('#assignedshiftandtime').empty();
                        indx= ++keys;
                        if(parseInt(indx)<=9){
                            indx="0"+indx;
                        }

                        $.each(data.shiftandtimetbl, function(key,value) {
                            let defaultValue = `Shift Name: <a style="text-decoration:underline;color:blue;" onclick=showShiftDetailFn(${value.shifts_id})>${value.ShiftNameLabel}</a> | Timetable: <a style="text-decoration:underline;color:blue;" onclick=showTimetableFn(${value.timetables_id})>${value.TimetabelLabel}</a> ${value.have_priority == 1 ? " <i style='color:#28c76f'>("+value.ScheduleTypeLabel+")</i>" : " <i>("+value.ScheduleTypeLabel+")</i>"}<br>`;
                            shiftdataedit+=`<li class='shiftlist ${value.Date}'>${ parseInt(value.timetables_id) > 1 ? defaultValue : "<b><i>No Shift Assigned!</i>"}</li></b>`;
                            if(values==value.Date){
                                ++numofshift;
                                //shiftdatas+=value.ShiftName+"</br>";
                                shiftdatas+=`Shift Name: <a style="text-decoration:underline;color:blue;" onclick=showShiftDetailFn(${value.shifts_id})>${value.ShiftNameLabel}</a> | Timetable: <a style="text-decoration:underline;color:blue;" onclick=showTimetableFn(${value.timetables_id})>${value.TimetabelLabel}</a> ${value.have_priority == 1 ? " <i style='color:#28c76f'>("+value.ScheduleTypeLabel+")</i>" : " <i>("+value.ScheduleTypeLabel+")</i>"}<br>`;
                            }
                        });
                        $('#assignedshiftandtime').html(shiftdataedit);

                        $.each(data.attworkhr, function(key,value) {
                            if(values==value.Date){
                                if(parseFloat(value.WorkHour||0)>0){
                                    productiontime+=parseFloat(value.WorkHour||0);
                                    productiontimemon+=parseFloat(value.WorkHour||0);
                                }
                                if(parseFloat(value.BreakHour||0)>0){
                                    breaktime+=parseFloat(value.BreakHour||0);
                                    breaktimemon+=parseFloat(value.BreakHour||0);
                                }
                                if(parseFloat(value.EarlyOvertime||0)>0 && parseInt(value.IsEarlyOvertimeCalc)==1){
                                    earlyot+=parseFloat(value.EarlyOvertime||0);
                                    earlyotmon+=parseFloat(value.EarlyOvertime||0);
                                }
                                if(parseFloat(value.LateOvertime||0)>0 && parseInt(value.IsLateOvertimeCalc)==1){
                                    lateot+=parseFloat(value.LateOvertime||0);
                                    lateotmon+=parseFloat(value.LateOvertime||0);
                                }
                                totalot=parseFloat(earlyot||0)+parseFloat(lateot||0);
                                totalotmon=parseFloat(earlyotmon||0)+parseFloat(lateotmon||0);
                                productiontime=parseFloat(productiontime||0)-parseFloat(totalot||0);
                                productiontimemon=parseFloat(productiontimemon||0)-parseFloat(totalotmon||0);
                            }
                        });

                        if(parseInt(fday)==1){
                            $("#editstatusdom").html("<span style='color:#4caf50;font-weight:bold;font-size:16px;'>Present</span>");
                        }
                        else if(parseInt(fday)==2){
                            $("#editstatusdom").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>Late PunchIn or Early PunchOut</span>");
                        }
                        else if(parseInt(fday)==3 || parseInt(fday)==10){
                            $("#editstatusdom").html("<span style='color:#ea5455;font-weight:bold;font-size:16px;'>Absent</span>");
                        }
                        else if(parseInt(fday)==4){
                            $("#editstatusdom").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>Punch In or Punch Out is Optional</span>");
                        }
                        else if(parseInt(fday)==5){
                            $("#editstatusdom").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>Off Shift Pending</span>");
                        }
                        else if(parseInt(fday)==51){
                            $("#editstatusdom").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;'>Off Shift Approved</span>");
                        }
                        else if(parseInt(fday)==52){
                            $("#editstatusdom").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;'>Off Shift Rejected</span>");
                        }
                        else if(parseInt(fday)==6){
                            $("#editstatusdom").html("<span style='color:#4caf50;font-weight:bold;font-size:16px;'>Partially Present</span>");
                        }
                        else if(parseInt(fday)==11){
                            $("#editstatusdom").html("<span style='color:#4e73df;font-weight:bold;font-size:16px;'>On Leave</span>");
                        }
                        else if(parseInt(fday)==12){
                            $("#editstatusdom").html("<span style='color:#00cfe8;font-weight:bold;font-size:16px;'>Day Off</span>");
                        }
                        else if(parseInt(fday)==14){
                            $("#editstatusdom").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'></span>");
                        }
                        else if(parseInt(fday)==13){
                            $("#editstatusdom").html("");
                        }
                        else{
                            $("#editstatusdom").html("");
                        }
                        
                        if(parseInt(numofshift)>0){
                            $('#assignedtimediv'+indx).append(shiftdatas);
                        }
                        else if(parseInt(numofshift)==0){
                            $('#assignedtimediv'+indx).html("<b><i>No shift assigned!</i></b>");
                        }
                    });

                    $('.allday').hide();
                    $('.day'+firstdayofmonth).show();

                    $('.shiftlist').hide();
                    $('.'+firstdayofmonth).show();
                }
            });
            $('#updatebutton').text('Update');
            $('#updatebutton').prop("disabled",false);
            $("#monthlyUpdateModal").modal('show'); 
        }

        $("#adds").click(function() {
            ++i;
            ++m;
            j += 1;
            var errorflag=0;
            var currenttabday=$('#fulldayformatval').val();

            $('#attdynamictable > tbody  > tr').each(function(index, tr) {
                var ind= ++index;
                var dateval=$(this).find('.datevalcls').val();
                
                if(currenttabday==dateval){
                    var ispayrollclosed=$(this).find('.payrollclosed').val()||0;
                    if(parseInt(ispayrollclosed)==1){
                        errorflag+=1;
                    }
                }
            }); 

            if(parseInt(errorflag)==0){
                $("#attdynamictable > tbody").append('<tr class="allday day'+currenttabday+'">'+
                    '<td style="width:12%"><input type="text" placeholder="Time" class="form-control edittimecls" name="row['+m+'][EditTime]" id="EditTime'+m+'" onchange="timeErrorFn(this)"/></td>'+ 
                    '<td style="width:22%"><select id="PunchType'+m+'" class="select2 form-control punchtypecls" name="row['+m+'][PunchType]" onchange="ptypeFn(this)"></select></td>'+ 
                    '<td style="width:48%"><input type="text" placeholder="Remark" class="form-control remarkcls" name="row['+m+'][Remark]" id="Remark'+m+'"/></td>'+ 
                    '<td style="width:15%"><input type="text" placeholder="Attendance Type" class="form-control attypecls" name="row['+m+'][AttType]" id="AttType'+m+'" readonly value="Manual"/></td>'+ 
                    '<td style="width:4%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm removeatt-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+     
                    '<td style="width:0%;display:none;"><input type="text" class="form-control idcls" name="row['+m+'][id]" id="id'+m+'" value="1"/></td>'+
                    '<td style="width:0%;display:none;"><input type="text" class="form-control timetablecls" name="row['+m+'][Timetable]" id="Timetable'+m+'" value="1"/></td>'+ 
                    '<td style="width:0%;display:none;"><input type="text" class="form-control datevalcls" name="row['+m+'][Date]" id="Date'+m+'" value="'+currenttabday+'"/></td>'+ 
                    '<td style="width:0%;display:none;"><input type="text" class="form-control payrollclosed" name="row['+m+'][payrollclosed]" id="payrollclosed'+m+'" value="0"/></td>'+ 
                    '<td style="width:0%;display:none;"><input type="text" class="form-control AttendanceType" name="row['+m+'][AttendanceType]" id="AttendanceType'+m+'" value="1"/></td>'+ 
                    '<td style="width:0%;display:none;"><input type="text" class="form-control vals" name="row['+m+'][vals]" id="vals'+m+'" value="'+m+'"/></td>'+ 
                '</tr>');

                flatpickr('#EditTime'+m, {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:"00:00",maxTime:endtimeval,defaultHour:"",static:true});
                var punchtypeopt = '<option selected disabled value=""></option><option value="1">Punch In</option><option value="2">Punch Out</option>';
                $('#PunchType'+m).append(punchtypeopt);
                $('#PunchType'+m).select2({
                    placeholder:"Select punch type here...",
                    minimumResultsForSearch: -1
                });
                $('#select2-PunchType'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#Date'+m).val(currenttabday);
            }

            else if(parseInt(errorflag)!=0){
                toastrMessage('error',"Payroll has been made on current date","Error");                
            }
        });

        $(document).on('click', '.removeatt-tr', function() {
            $(this).parents('tr').remove();
            --i;
        });

        function editDateFn(yrs,mnt,rowid) { 
            if(parseInt(rowid)<=9){
                rowid="0"+rowid;
            }
            if(parseInt(mnt)<=9){
                mnt="0"+mnt;
            }
            var dateupd = $("#tabday"+rowid).attr("data-title");
            var holiday = $("#tabday"+rowid).attr("data-holiday");
            var holidayname = `<i class="fas fa-star"></i> ${$("#tabday"+rowid).attr("data-holiday")}`;
    
            var datedata=yrs+"-"+mnt+"-"+rowid;               
            var olddate=$('#fulldayformatval').val();
            var errorflag=0;
            $('#attdynamictable > tbody  > tr').each(function(index, tr) {
                var ind= ++index;
                var dateval=$(this).find('.datevalcls').val();
                
                if(olddate==dateval){
                    var times=$(this).find('.edittimecls').val();
                    var ptype=$(this).find('.punchtypecls').val();
                    if(times==null || times=="" || ptype==null || ptype==""){
                        errorflag+=1;
                    }
                }
            }); 

            if(parseInt(errorflag)==0){
                var payrollupdateflag=0;
                $('.allday').hide();
                $('.day'+datedata).show();
                $(".tabdaycls").removeClass("active");
                $("#tabday"+rowid).addClass("active");
                

                $('#attdynamictable > tbody  > tr').each(function(index, tr) {
                    var ind= ++index;
                    var tabledates=$(this).find('.datevalcls').val();
                    
                    if(datedata==tabledates){
                        var payrollupd=$(this).find('.payrollclosed').val();
                        if(parseInt(payrollupd)==1){
                            payrollupdateflag+=1;
                        }
                    }
                }); 

                if(parseInt(payrollupdateflag)==0){
                    $('#adds').show();
                    $('#updatebutton').show();
                }
                else if(parseInt(payrollupdateflag)>0){
                    $('#adds').hide();
                    $('#updatebutton').hide();
                }

                $('#fulldayformatval').val(datedata);
                $('#dateupdatedom').html(`<b><i class="fa-solid fa-calendar-days"></i>  ${(moment(datedata).format("DD-MMMM-YYYY"))} <i>(${(moment(datedata).format("dddd"))})</i></b></br><h6>${holiday != "" ? holidayname : ""}</h6>`);

                $('.shiftlist').hide();
                $('.'+datedata).show();
            }
            else if(parseInt(errorflag)>0){
                var datenum=moment(olddate).format("DD");
                $(".tabdaycls").removeClass("active");
                $("#tabday"+datenum).addClass("active");

                $('#attdynamictable > tbody  > tr').each(function(index, tr) {
                    var ind= ++index;
                    var dateval=$(this).find('.datevalcls').val();

                    if(olddate==dateval){
                        var times=$(this).find('.edittimecls').val();
                        var ptype=$(this).find('.punchtypecls').val();
                        if(times==null || times=="" || ptype==null || ptype==""){
                            var idval=$(this).find('.vals').val();

                            if(times==null || times==""){
                                $('#EditTime'+idval).css("background", errorcolor);
                            }
                            if(ptype==null || ptype==""){
                                $('#select2-PunchType'+idval+'-container').parent().css('background-color',errorcolor);
                            }
                        }
                    }
                }); 
                toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
            }
        }

        function attendanceInfo(recordId) { 
            var month="";
            var liopt="";
            var bodytab="";
            var ind=0;
            var indx=0;
            var classval="";
            var classes="";
            var outofrange="";
            var punchtype="";
            var empid="";
            var lidata="";
            var alllidata="";
            var shiftdatas="";
            var numofact=0;
            var numofalldata=0;
            var numofshift=0;
            var productiontime=0;
            var breaktime=0;
            var earlyot=0;
            var lateot=0;
            var totalot=0;

            var productiontimemon=0;
            var breaktimemon=0;
            var earlyotmon=0;
            var lateotmon=0;
            var totalotmon=0;

            var absentcnt=0;
            var presentcnt=0;
            var partiallypresentcnt=0;
            var latecheckincnt=0;
            var earlycheckoutcnt=0;
            var latechecheckinoutcnt=0;
            var incompletepunch=0;
            var offshiftpending=0;
            var offshiftapproved=0;
            var offshiftrejected=0;
            var holidaycnt=0;
            var onleavecnt=0;
            var worksonleave=0;
            var dayoffcnt=0;
            var worksonholidaycnt=0;
            var statusColor="";

            var onleavecnt=0;
            var otherscnt=0;
            var indx = 0;
            var halfdaystatus = "";   

            $('#verticaltab').empty();
            $('#verticaltabbody').empty();
            $('.activitycls').empty();
            $("#monthlyReport > tbody").empty();
            
            var currdate=$('#currentdayval').val();
            $('#hiddenyearmonth').val($('#Month').val());
            $('#hiddenemployeeid').val(recordId);
            $.ajax({
                url: '/getAttInfo',
                type: 'POST',
                data:{
                    month:$('#Month').val(),
                    empid:recordId,
                },
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
                    $('#infomonthdisplay').html(data.formatteddate);
                    $('#hiddenCurrentTimeMonthly').val(data.currentdatetimeAA);
                    $.each(data.fulldayformat, function(key,value) {
                        ind= ++key;
                        if(parseInt(ind)<=9){
                            ind="0"+ind;
                        }
                        if(parseInt(ind)==1){
                            classval="active";
                        }
                        if(parseInt(ind)>1){
                            classval="";
                        }
                        var holidayname = `<i class="fas fa-star"></i> ${value.HolidayName}`;

                        liopt+=`<li class="nav-item"><a class="nav-link ${classval}" id="tabday${ind}" data-toggle="tab" href="#tabodyday${ind}" aria-controls="tabday${ind}" role="tab" aria-selected="true">${value.FullDateFormat}</a></li>`;
                        bodytab+=`<div class="tab-pane ${classval}" id="tabodyday${ind}" aria-labelledby="tabodyday${ind}" role="tabpanel"><div class="row"><div class="col-xl-7 col-lg-7 col-md-6 col-sm-6" style="text-align:left;"><h3><b><i class="fa-solid fa-calendar-days"></i> ${value.FullDateFormat} <i>(${value.DayName})</i></b></h3>${value.HolidayName != "" ? holidayname : ""}</div><div class="col-xl-5 col-lg-5 col-md-6 col-sm-6" id="attstatusdisplay${value.FullDateFormat}" style="text-align:right;"></div><div class="col-lg-9 col-md-8 col-sm-8 mt-1"><div class="row"><div class="col-xl-12 col-md-12 col-sm-12"><label style="font-size: 14px;font-weight:bold;">Assigned Shift & Timetable</label><div id="assignedtimediv${ind}"></div><div class="col-xl-12 col-md-12 col-sm-12 mt-1" style="padding:0px 0px 0px 0px;"><div class="border rounded p-1 mt-2"><div class="row gap-4 gap-sm-0" style="text-align: center;"><div class="col-12 col-sm-4 mb-1" style="text-align: center;"><h6 class="my-0.5" id="prductionhr${value.FullDateFormat}"></h6></div><div class="col-12 col-sm-4 mb-1" style="text-align: center;"><h6 class="my-0.5" id="breakhr${value.FullDateFormat}"></h6></div><div class="col-12 col-sm-4 mb-1" style="text-align: center;"><h6 class="my-0.5" id="overtimehr${value.FullDateFormat}"></h6></div>  <div class="col-12 col-sm-3" style="text-align: center;"><h6 class="my-0.5" id="earlycheckinhr${value.FullDateFormat}"></h6></div><div class="col-12 col-sm-3" style="text-align: center;"><h6 class="my-0.5" id="latecheckinhr${value.FullDateFormat}"></h6></div> <div class="col-12 col-sm-3" style="text-align: center;"><h6 class="my-0.5" id="latecheckouthr${value.FullDateFormat}"></h6></div> <div class="col-12 col-sm-3" style="text-align: center;"><h6 class="my-0.5" id="earlycheckouthr${value.FullDateFormat}"></h6></div> </div></div> </div></div></div></div><div class="col-lg-3 col-md-4 col-sm-4 mt-1"><div class="row"><div class="col-lg-6 col-md-6 col-sm-6 mt-1"> <label style="font-size: 18px;font-weight:bold;">Activity</label></div> <div class="col-lg-6 col-md-6 col-sm-6 mt-2" style="text-align:right;"><label style="font-size:13px;text-align:right;"><input class="hummingbird-end-node showallpunchistory" style="width:13px;height:13px;accent-color:#7367f0;" id="showall${ind}" name="showall" type="checkbox" value="${ind}"/>	Show all</label></div> <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:43rem"> <ul id="activityul${ind}" class="timeline mb-0 mt-0 activitycls"></ul> <ul id="activityulall${ind}" class="timeline mb-0 mt-0 activityclsall" style="display:none;"></ul> </div></div></div></div></div>`;
                    });

                    $('#verticaltab').append(liopt);
                    $('#verticaltabbody').append(bodytab);

                    $.each(data.attworkhr, function(key,value) {         
                        halfdaystatus = "";   
                        if(parseInt(value.Status)==1){
                            absentcnt+=1;
                            statusColor="#ea5455";
                        }
                        if(parseInt(value.Status)==2 || parseInt(value.Status)==5 || parseInt(value.Status)==7){
                            presentcnt+=1;
                            statusColor="#28c76f";
                        }
                        if(parseInt(value.Status)==3){
                            partiallypresentcnt+=1;
                            statusColor="#4caf50";
                        }
                        if(parseInt(value.Status)==4){
                            latecheckincnt+=1;
                            statusColor="#f6c23e";
                        }
                        if(parseInt(value.Status)==6){
                            earlycheckoutcnt+=1;
                            statusColor="#f6c23e";
                        }
                        if(parseInt(value.Status)==8){
                            incompletepunch+=1;
                            statusColor="#ea5455";
                        }
                        if(parseInt(value.Status)==9){
                            dayoffcnt+=1;
                            statusColor="#00cfe8";
                        }
                        if(parseInt(value.Status)==10){
                            holidaycnt+=1;
                            statusColor="#4e73df";
                        }
                        if(parseInt(value.Status)==11){
                            onleavecnt+=1;
                            statusColor="#4e73df";
                            if(parseInt(value.is_leave_half_day)==1){
                                halfdaystatus = "(Half Day)";
                                statusColor="#000000";
                            }
                        }
                        if(parseInt(value.Status)==12 || parseInt(value.Status)==13 || parseInt(value.Status)==15){
                            if(parseInt(value.OffShiftStatus)==0 || isNaN(parseInt(value.OffShiftStatus))){
                                offshiftpending+=1;
                                statusColor="#ff9f43";
                            }
                            if(parseInt(value.OffShiftStatus)==1){
                                offshiftapproved+=1;
                                statusColor="#28c76f";
                            }
                            if(parseInt(value.OffShiftStatus)==2){
                                offshiftrejected+=1;
                                statusColor="#ea5455";
                            }
                        } 
                        if(parseInt(value.Status)==14){
                            latechecheckinoutcnt+=1;
                            statusColor="#ea5455";
                        }
                        else{
                            otherscnt+=1;
                        }

                        //$(`#prductionhr${value.FullDateFormat}`).html(value.FormattedWorkHour);
                        $(`#prductionhr${value.FullDateFormat}`).html(`<table style="width:100%"><tr><td style="width:45%">${value.FormattedWorkHour}</td><td style="width:10%;text-align:center;">|</td><td style="width:45%">${value.FormattedWorkHourPen}</td></tr><tr style="font-size:8px;"><td style="color:#28c76f"></td><td></td><td style="color:#ff9f43">Pending/ Reject</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Work Hour</td></tr></table>`);
                        $(`#breakhr${value.FullDateFormat}`).html(`<table style="width:100%"><tr><td style="width:45%">${value.FormattedBreakHour}</td><td style="width:10%;text-align:center;">|</td><td style="width:45%">${value.FormattedBreakHourPen}</td></tr><tr style="font-size:8px;"><td style="color:#28c76f"></td><td></td><td style="color:#ff9f43">Pending/ Reject</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Break Hour</td></tr></table>`);
                        $(`#overtimehr${value.FullDateFormat}`).html(`<table style="width:100%"><tr><td style="width:45%">${value.FormattedOvertimeHour}</td><td style="width:10%;text-align:center;">|</td><td style="width:45%">${value.FormattedOvertimeHourPen}</td></tr><tr style="font-size:8px;"><td style="color:#28c76f"></td><td></td><td style="color:#ff9f43">Pending/ Reject</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Overtime</td></tr></table>`);
                        $(`#latecheckinhr${value.FullDateFormat}`).html(`<table style="width:100%"><tr><td style="width:100%">${value.FormattedLateCheckInTimeAmount}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Late Punch In</td></tr></table>`);
                        $(`#earlycheckouthr${value.FullDateFormat}`).html(`<table style="width:100%"><tr><td style="width:100%">${value.FormattedEarlyCheckOutTimeAmount}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Early Punch Out</td></tr></table>`);
                        
                        $(`#earlycheckinhr${value.FullDateFormat}`).html(`<table style="width:100%"><tr><td style="width:100%">${value.FormattedBeforeOnDutyTimeAmount}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Early Punch In</td></tr></table>`);
                        $(`#latecheckouthr${value.FullDateFormat}`).html(`<table style="width:100%"><tr><td style="width:100%">${value.FormattedAfterOffDutyTimeAmount}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Late Punch Out</td></tr></table>`);

                        $(`#attstatusdisplay${value.FullDateFormat}`).html(`<span style='color:${statusColor};font-weight:bold;font-size:16px;'>${value.StatusValue} <i>${halfdaystatus}</i></span>`);
                    });

                    $.each(data.consattendances, function(key,value) {
                        $('#prductionhrmon').html(`<table style="width:100%"><tr><td style="width:45%">${value.TotalFormattedWorkHour == null ? "00H 00M" : value.TotalFormattedWorkHour}</td><td style="width:10%;text-align:center;">|</td><td style="width:45%">${value.TotalFormattedWorkHourPen == null ? "00H 00M" : value.TotalFormattedWorkHourPen}</td></tr><tr style="font-size:8px;"><td style="color:#28c76f"></td><td></td><td style="color:#ff9f43">Pending/ Reject</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Work Hour</td></tr></table>`);
                        $('#breakhrmon').html(`<table style="width:100%"><tr><td style="width:45%">${value.TotalFormattedBreakHour == null ? "00H 00M" : value.TotalFormattedBreakHour}</td><td style="width:10%;text-align:center;">|</td><td style="width:45%">${value.TotalFormattedBreakHourPen == null  ? "00H 00M" : value.TotalFormattedBreakHourPen}</td></tr><tr style="font-size:8px;"><td style="color:#28c76f"></td><td></td><td style="color:#ff9f43">Pending/ Reject</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Break Hour</td></tr></table>`);
                        //$('#breakhrmon').html(value.TotalFormattedBreakHour);
                        $('#overtimehrmon').html(`<table style="width:100%"><tr><td style="width:45%">${value.TotalFormattedOvertimeHour == null ? "00H 00M" : value.TotalFormattedOvertimeHour}</td><td style="width:10%;text-align:center;">|</td><td style="width:45%">${value.TotalFormattedOvertimeHourPen == null ? "00H 00M" : value.TotalFormattedOvertimeHourPen}</td></tr><tr style="font-size:8px;"><td style="color:#28c76f"></td><td></td><td style="color:#ff9f43">Pending/ Reject</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Overtime</td></tr></table>`);
                        $('#latecheckinhourlbl').html(`<table style="width:100%"><tr><td style="width:100%">${value.TotalLateCheckInHour == null ? "00H 00M" : value.TotalLateCheckInHour}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Late Punch In</td></tr></table>`);
                        $('#earlycheckouthourlbl').html(`<table style="width:100%"><tr><td style="width:100%">${value.TotalEarlyCheckOutHour == null ? "00H 00M" : value.TotalEarlyCheckOutHour}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Early Punch Out</td></tr></table>`);
                        $(`#earlycheckinmon`).html(`<table style="width:100%"><tr><td style="width:100%">${value.TotalBeforeOnDutyTimeAmount == null  ? "00H 00M" : value.TotalBeforeOnDutyTimeAmount}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Early Punch In</td></tr></table>`);
                        $(`#latecheckoutmon`).html(`<table style="width:100%"><tr><td style="width:100%">${value.TotalAfterOffDutyTimeAmount == null ? "00H 00M" : value.TotalAfterOffDutyTimeAmount}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Late Punch Out</td></tr></table>`);
                    
                        $(`.monthlyworkhour`).html(value.TotalFormattedWorkHour == null ? "" : value.TotalFormattedWorkHour);
                        $(`.monthlyworkhourpen`).html(value.TotalFormattedWorkHourPen == null ? "" : value.TotalFormattedWorkHourPen);
                        $(`.monthlybreakhour`).html(value.TotalFormattedBreakHour == null ? "" : value.TotalFormattedBreakHour);
                        $(`.monthlybreakhourpen`).html(value.TotalFormattedBreakHourPen == null ? "" : value.TotalFormattedBreakHourPen);
                        $(`.monthlyovertime`).html(value.TotalFormattedOvertimeHour == null ? "" : value.TotalFormattedOvertimeHour);
                        $(`.monthlyovertimepen`).html(value.TotalFormattedOvertimeHourPen == null ? "" : value.TotalFormattedOvertimeHourPen);
                        $(`.monthlyearlypunchin`).html(value.TotalBeforeOnDutyTimeAmount == null ? "" : value.TotalBeforeOnDutyTimeAmount);
                        $(`.monthlylatepunchin`).html(value.TotalLateCheckInHour == null ? "" : value.TotalLateCheckInHour);
                        $(`.monthlylatepunchout`).html(value.TotalAfterOffDutyTimeAmount == null ? "" : value.TotalAfterOffDutyTimeAmount);
                        $(`.monthlyearlypunchout`).html(value.TotalEarlyCheckOutHour == null ? "" : value.TotalEarlyCheckOutHour);
                    
                    });

                    $.each(data.dates, function(keys,values) {
                        lidata="";
                        alllidata="";
                        shiftdatas="";
                        numofact=0;
                        numofalldata=0;
                        numofshift=0;
                        productiontime=0;
                        breaktime=0;
                        earlyot=0;
                        lateot=0;
                        totalot=0;
                        indx= ++keys;
                        if(parseInt(indx)<=9){
                            indx="0"+indx;
                        }

                        $.each(data.shiftandtimetbl, function(key,value) {
                            if(values==value.Date && value.timetables_id>1){
                                ++numofshift;
                                shiftdatas+=`Shift Name: <a style="text-decoration:underline;color:blue;" onclick=showShiftDetailFn(${value.shifts_id})>${value.ShiftNameLabel}</a> | Timetable: <a style="text-decoration:underline;color:blue;" onclick=showTimetableFn(${value.timetables_id})>${value.TimetabelLabel}</a> ${value.have_priority == 1 ? " <i style='color:#28c76f'>("+value.ScheduleTypeLabel+")</i>" : " <i>("+value.ScheduleTypeLabel+")</i>"}<br>`;
                                
                            }
                        });

                        $.each(data.empdata, function(key,value) {
                            $('#monthempname').html(value.name);
                            $('#departmentlbl').html('<i class="fa-solid fa-landmark"></i>   '+value.DepartmentName);
                            $('#positionlbl').html('<i class="fa-solid fa-up-down-left-right"></i>   '+value.PositionName);
                            $('#monthlyposition').val(value.PositionName);
                            $('#monthlydepartment').val(value.DepartmentName);
                            $('#hiddenBranchMonthly').val(value.BranchName);
                            $('#hiddenEmployeeIdMonthly').val(value.EmployeeID);
                            
                            if(value.ActualPicture!=null || value.BiometricPicture!=null){
                                $('#monthemployeepic').attr("src",value.ActualPicture!=null ? `../../../storage/uploads/HrEmployee/${value.ActualPicture}` : `../../../storage/uploads/BioEmployee/${value.BiometricPicture}`);
                            }
                            if(value.ActualPicture==null && value.BiometricPicture===null){
                                $('#monthemployeepic').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
                            }
                        });

                        $.each(data.attend, function(key,value) {
                            if(values==value.Date){
                                ++numofact;
                                if(parseInt(value.PunchType)==1){
                                    punchtype="Punch In";
                                    classes="success";
                                }
                                else if(parseInt(value.PunchType)==2){
                                    punchtype="Punch Out";
                                    classes="primary";
                                }
                                lidata+='<li class="timeline-item"><span class="timeline-point timeline-point-'+classes+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">'+punchtype+'</h6><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.PunchTime+'</span></div></li>';
                            }
                        });

                        $.each(data.attlog, function(key,value) {
                            if(values == value.Date){
                                ++numofalldata
                               
                                if(parseInt(value.PunchType)==1 && parseInt(value.is_in_range)==1){
                                    punchtype="Punch In";
                                    classes="success";
                                    outofrange="show";
                                }
                                else if(parseInt(value.PunchType)==2 && parseInt(value.is_in_range)==1){
                                    punchtype="Punch Out";
                                    classes="primary";
                                    outofrange="show";
                                }
                                else if(parseInt(value.is_in_range)==0){
                                    punchtype="Punch";
                                    classes="secondary";
                                    outofrange="hide";
                                }

                                alllidata+=`<li class="punchhistory-${outofrange} punchhistorydate-${indx}-${outofrange} timeline-item" onclick="openActivityDetailFn(${value.id})"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${punchtype}</h6><span class="text-muted" style="font-size:11px"><i class="fa-regular fa-clock"></i> ${value.Time} | ${value.TimeFormatted}</span></div></li>`;
                            }
                        });

                        if(parseInt(numofshift)>0){
                            $('#assignedtimediv'+indx).append(shiftdatas);
                        }
                        else if(parseInt(numofshift)==0){
                            $('#assignedtimediv'+indx).html("<b><i>No shift assigned!</i></b>");
                        }

                        if(parseInt(numofalldata)>0){
                            $('#activityul'+indx).append(alllidata);
                        }
                        else if(parseInt(numofalldata)==0){
                            $('#activityul'+indx).html("<b><i>No activity yet!</i></b>");
                        }

                        if(parseInt(numofalldata)>0){
                            $('#activityulall'+indx).append(alllidata);
                        }
                        else if(parseInt(numofalldata)==0){
                            $('#activityulall'+indx).html("<b><i>No activity yet!</i></b>");
                        }
                        $('.punchhistory-hide').hide();
                    });

                    $.each(data.monthlyattendance, function(repkey,repvalue) {
                        $("#monthlyReport > tbody").append(`<tr>
                            <td>${++repkey}</td>
                            <td>${repvalue.Date}</td>
                            <td>${repvalue.Shift}</td>
                            <td>${repvalue.TimetableName}</td>
                            <td>${repvalue.Time}</td>
                            <td>${repvalue.Type}</td>
                            <td>${repvalue.WorkingHour}</td>
                            <td>${repvalue.WorkingHourPending}</td>
                            <td>${repvalue.BreakHour}</td>
                            <td>${repvalue.BreakHourPending}</td>
                            <td>${repvalue.Overtime}</td>
                            <td>${repvalue.OvertimePending}</td>
                            <td>${repvalue.EarlyPunchIn}</td>
                            <td>${repvalue.LatePunchIn}</td>
                            <td>${repvalue.LatePunchOut}</td>
                            <td>${repvalue.EarlyPunchOut}</td>
                            <td>${repvalue.AttendanceStatus}</td>
                        </tr>`);
                    });

                    $('#presentlbl').html(presentcnt);  
                    $('#partiallypresentlbl').html(partiallypresentcnt);
                    $('#absentlbl').html(absentcnt);
                    $('#latecheckinlbl').html(latecheckincnt);
                    $('#earlycheckoutlbl').html(earlycheckoutcnt);
                    $('#latecheckinandoutlbl').html(latechecheckinoutcnt);
                    $('#incompletepunchlbl').html(incompletepunch);
                    $('#offshiftlbl').html(offshiftpending);
                    $('#offshiftapp').html(offshiftapproved);
                    $('#offshiftrej').html(offshiftrejected);
        
                    $('#holidaylbl').html(holidaycnt);
                    $('#worksonholidaylbl').html(worksonholidaycnt);
                    $('#onleavelbl').html(onleavecnt);
                    $('#worksonleavelbl').html(worksonleave);
                    $('#dayofflbl').html(dayoffcnt);
                    $('#otherslbl').html(otherscnt);
                }
            });
            $("#monthlyInfoModal").modal('show'); 
        }

        function openDailyInfo(daynum,empid,status){
            var month=$('#Month').val();
            var daynumber="";
            var employeeid="";
            var lidata="";
            var shiftdata="";
            var punchtype="";
            var classes="";
            var numofact=0;
            var numofshift=0;
            var puncintime=[];
            var puncouttime=[];
            var totalpunchin=0;
            var totalpunchout=0;
            var productiontime=0;
            var otherscnt=0;
            var prdhour="";
            var prdmin="";
            var assignedtime="";
            var breaktime=0;
            var earlyot=0;
            var lateot=0;
            var totalot=0;
            var statusColor="";
            var halfdayflag="";
            var dailyrepdata="";
            var outofrange;
            var holidayname = "";
            $("#attstatusdisplay").html("");
            $("#dailyReport > tbody").empty();

            $.ajax({
                url: '/getActivity',
                type: 'POST',
                data:{
                    month:$('#Month').val(),
                    daynumber:daynum,
                    employeeid:empid,
                },
                success: function(data) {
                    holidayname = `<i class="fas fa-star"></i> ${data.holidayname}`;
                    $('#activityul').empty();
                    $('#assignedtimediv').empty();
                    $('#dayandtimelbl').html(`  ${data.datename} <i>(${data.dayname})</i>`);
                    $('#holidayLbl').html(`${data.holidayname != "" ? holidayname : ""}`);
                    $('#holidayLbl').attr('title',"Holiday");
                    $('#dailyshowall').val(daynum);
                    $('#hiddenCurrentTimeDaily').val(data.currentdatetimeAA);
                    
                    $.each(data.attlog, function(key,value) {
                        ++numofact;
                        if(parseInt(value.PunchType)==1 && parseInt(value.is_in_range)==1){
                            punchtype="Punch In";
                            classes="success";
                            outofrange="show";
                            ++totalpunchin;
                        }
                        else if(parseInt(value.PunchType)==2 && parseInt(value.is_in_range)==1){
                            punchtype="Punch Out";
                            classes="primary";
                            outofrange="show";
                            ++totalpunchout;
                        }
                        else if(parseInt(value.is_in_range)==0){
                            punchtype="Punch";
                            classes="secondary";
                            outofrange="hide";
                        }

                        lidata+=`<li class="dailypunchhistory-${outofrange} dailypunchhistorydate-${daynum}-${outofrange} timeline-item" onclick="openActivityDetailFn(${value.id})"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${punchtype}</h6><span class="text-muted" style="font-size:11px;"><i class="fa-regular fa-clock"></i> ${value.Time} | ${value.TimeFormatted}</span></div></li>`;
                    });

                    $.each(data.attworkhr, function(key,value) {
                        if(parseInt(value.Status)==1){
                            statusColor="#ea5455";
                        }
                        if(parseInt(value.Status)==2 || parseInt(value.Status)==5 || parseInt(value.Status)==7){
                            statusColor="#28c76f";
                        }
                        if(parseInt(value.Status)==3){
                            statusColor="#4caf50";
                        }
                        if(parseInt(value.Status)==4){
                            statusColor="#f6c23e";
                        }
                        if(parseInt(value.Status)==6){
                            statusColor="#f6c23e";
                        }
                        if(parseInt(value.Status)==8){
                            statusColor="#ea5455";
                        }
                        if(parseInt(value.Status)==9){
                            statusColor="#00cfe8";
                        }
                        if(parseInt(value.Status)==10){
                            statusColor="#4e73df";
                        }
                        if(parseInt(value.Status)==11){
                            statusColor="#4e73df";
                            if(parseInt(value.is_leave_half_day)==1){
                                halfdayflag = "(Half Day)";
                                statusColor="#000000";
                            }
                        }
                        if(parseInt(value.Status)==12 || parseInt(value.Status)==13 || parseInt(value.Status)==15){
                            if(parseInt(value.OffShiftStatus)==0 || isNaN(parseInt(value.OffShiftStatus))){
                                statusColor="#ff9f43";
                            }
                            if(parseInt(value.OffShiftStatus)==1){
                                statusColor="#28c76f";
                            }
                            if(parseInt(value.OffShiftStatus)==2){
                                statusColor="#ea5455";
                            }
                        }
                        
                        if(parseInt(value.Status)==14){
                            statusColor="#ea5455";
                        }
                        
                        else{
                            otherscnt+=1;
                        }
                        
                        $(`#prductionhr`).html(`<table style="width:100%"><tr><td style="width:45%">${value.FormattedWorkHour}</td><td style="width:10%;text-align:center;">|</td><td style="width:45%">${value.FormattedWorkHourPen}</td></tr><tr style="font-size:8px;"><td style="color:#28c76f"></td><td></td><td style="color:#ff9f43">Pending/ Reject</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Work Hour</td></tr></table>`);
                        $(`#breakhr`).html(`<table style="width:100%"><tr><td style="width:45%">${value.FormattedBreakHour}</td><td style="width:10%;text-align:center;">|</td><td style="width:45%">${value.FormattedBreakHourPen}</td></tr><tr style="font-size:8px;"><td style="color:#28c76f"></td><td></td><td style="color:#ff9f43">Pending/ Reject</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Break Hour</td></tr></table>`);
                        $(`#overtimehr`).html(`<table style="width:100%"><tr><td style="width:45%">${value.FormattedOvertimeHour}</td><td style="width:10%;text-align:center;">|</td><td style="width:45%">${value.FormattedOvertimeHourPen}</td></tr><tr style="font-size:8px;"><td style="color:#28c76f"></td><td></td><td style="color:#ff9f43">Pending/ Reject</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Overtime</td></tr></table>`);
                        $(`#dailylatecheckinhr`).html(`<table style="width:100%"><tr><td style="width:100%">${value.FormattedLateCheckInTimeAmount}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Late Punch In</td></tr></table>`);
                        $(`#dailyearlycheckouthr`).html(`<table style="width:100%"><tr><td style="width:100%">${value.FormattedEarlyCheckOutTimeAmount}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Early Punch Out</td></tr></table>`);

                        $(`#earlycheckinhr`).html(`<table style="width:100%"><tr><td style="width:100%">${value.FormattedBeforeOnDutyTimeAmount}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Early Punch In</td></tr></table>`);
                        $(`#latecheckouthr`).html(`<table style="width:100%"><tr><td style="width:100%">${value.FormattedAfterOffDutyTimeAmount}</td></tr><tr><td colspan="3" style="text-align:center;font-weight:bold;font-size:12px;">Late Punch Out</td></tr></table>`);

                        $("#attstatusdisplay").html(`<span style='color:${statusColor};font-weight:bold;font-size:16px;'>${value.StatusValue} <i>${halfdayflag}</i></span>`);
                    });
                    
                    $.each(data.empdata, function(key,value) {
                        $('#empname').html(value.name);
                        $('#dailydepartmentlbl').html(`  ${value.DepartmentName}`);
                        $('#dailypositionlbl').html(`  ${value.PositionName}`);
                        $('#hiddenBranch').val(value.BranchName);
                        $('#hiddenEmployeeId').val(value.EmployeeID);
                        if(value.ActualPicture!=null || value.BiometricPicture!=null){
                            $('#employeepic').attr("src",value.ActualPicture!=null ? `../../../storage/uploads/HrEmployee/${value.ActualPicture}` : `../../../storage/uploads/BioEmployee/${value.BiometricPicture}`);
                        }
                        if(value.ActualPicture==null && value.BiometricPicture===null){
                            $('#employeepic').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
                        }
                    });

                    $.each(data.shiftandtimetbl, function(key,value) {
                        ++numofshift;
                        shiftdata+=`Shift Name: <a style="text-decoration:underline;color:blue;" onclick=showShiftDetailFn(${value.shifts_id})>${value.ShiftNameLabel}</a> | Timetable: <a style="text-decoration:underline;color:blue;" onclick=showTimetableFn(${value.timetables_id})>${value.TimetabelLabel}</a> ${value.have_priority == 1 ? " <i style='color:#28c76f'>("+value.ScheduleTypeLabel+")</i>" : " <i>("+value.ScheduleTypeLabel+")</i>"}<br>`;
                    });

                    if(parseInt(numofshift)>0){
                        $('#assignedtimediv').append(shiftdata);
                    }
                    else if(parseInt(numofshift)==0){
                        $('#assignedtimediv').append("<b><i>No shift assigned!</i></b>");
                    }

                    if(parseInt(numofact)>0){
                        $('#activityul').append(lidata);
                    }
                    else if(parseInt(numofact)==0){
                        $('#activityul').html("<b><i>No activity yet!</i></b>");
                    }
                    $(`.dailypunchhistory-hide`).hide();

                    $.each(data.dailyattendance, function(repkey,repvalue) {
                        $("#dailyReport > tbody").append(`<tr>
                            <td>${++repkey}</td>
                            <td>${repvalue.Date}</td>
                            <td>${repvalue.Shift}</td>
                            <td>${repvalue.TimetableName}</td>
                            <td>${repvalue.Time}</td>
                            <td>${repvalue.Type}</td>
                            <td>${repvalue.WorkingHour}</td>
                            <td>${repvalue.WorkingHourPending}</td>
                            <td>${repvalue.BreakHour}</td>
                            <td>${repvalue.BreakHourPending}</td>
                            <td>${repvalue.Overtime}</td>
                            <td>${repvalue.OvertimePending}</td>
                            <td>${repvalue.EarlyPunchIn}</td>
                            <td>${repvalue.LatePunchIn}</td>
                            <td>${repvalue.LatePunchOut}</td>
                            <td>${repvalue.EarlyPunchOut}</td>
                            <td>${repvalue.AttendanceStatus}</td>
                        </tr>`);
                    });
                }
            });
            $('#dailyshowall').prop('checked',false); 
            $("#dailyInfoModal").modal('show');
        }

        function openActivityDetailFn(atlogid){
            var recordId=null;
            $.ajax({
                url: '/getActivityDetail',
                type: 'POST',
                data:{
                    recordId:atlogid, 
                },
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
                    $.each(data.attendacelog, function(key,value) {
                        $('#punchtypeactivitylbl').html(parseInt(value.is_in_range) == 1 ? (parseInt(value.PunchType) == 1 ? "Punch In" : "Punch Out") : "Punch");
                        $('#timeactivitylbl').html(value.Time+" | "+value.TimeFormatted);
                        $('#recordtypeactivitylbl').html(value.AttType == 1 ? "Manual" : (value.AttType == 2 ? "Automated" : (value.AttType == 3 ? "Auto-Generate" : "Excel-Import")));
                        $('#remarkactivitylbl').html(value.Remark!=null ? value.Remark : "");
                        $('#activityDetailBody').css('background-color', parseInt(value.is_in_range) == 1 ? (parseInt(value.PunchType) == 1 ? "#72e2a4" : "#c8c3f9") : "#d0d1d4");
                    });
                }
            });
            $("#activitydetailmodal").modal('show'); 
        }

        function showShiftDetailFn(recordId){
            days=[];
            $('#timetableDiv').hide();
            var lidata="";
            $.ajax({
                type: "get",
                url: "{{url('showshift')}}"+'/'+recordId,
                dataType: "json",
                success: function (data) {
                    $.each(data.shiftdata, function(key, value) {
                        $('#shiftnamelbl').html(value.ShiftName);
                        $('#beginningdatelbl').html(value.BegininngDate);
                        $('#cyclenumberlbl').html(value.CycleNumber);
                        $('#cycleunitlbl').html(value.CycleUnits);
                        $('#descriptionlbl').html(value.Description);
                        $("#shiftstatuslbl").html(value.Status == "Active" ? "<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:14px;'>"+value.Status+"</span>" : "<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:14px;'>"+value.Status+"</span>");
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
                        lidata+='<li class="timeline-item"><span class="timeline-point timeline-point-'+classes+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i> '+value.FullName+'</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span></div></li>';
                    });
                    $("#shiftactiondiv").empty();
                    $('#shiftactiondiv').append(lidata);

                    fetchTimetableData(recordId);
                    $(".infoshift").collapse('show');
                    $(".infoactionshift").collapse('hide');
                    $("#shiftinfomodal").modal('show');
                },
            }); 
        }

        function fetchTimetableData(recordId){
            var recid="";
            
            $('#timetableDiv').hide();
            $('#timetableinfotbl').DataTable({
                destroy: true,
                processing: false,
                serverSide: true,
                searching: true,
                info: false,
                fixedHeader: true,
                paging: true,
                searchHighlight: true,
                responsive:true,
                deferRender: true,
                
                "lengthMenu": [50, 100,500,1000],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-1'i><'col-sm-12 col-md-5'p>>",
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
                        width:"3%"
                    },
                    {
                        data: 'Dates',
                        name: 'Dates',
                        width:"20%"
                    },
                    {
                        data: 'SelectedTimetable',
                        name: 'SelectedTimetable',
                        width:"77%"
                    },
                ],
                columnDefs: [
                    { width: "3%", targets: 0 },  // Set width for the first column
                    { width: "20%", targets: 1 },  // Set width for the second column
                    { width: "77%", targets: 2 }  // Set width for the last column
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

        function showTimetableFn(recordId){
            var lidata="";
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

                        let brtime=value.BreakStartTime;
                        let hhmm=brtime!=null ? "<i>Hour:Minute</i>":"";
                        $("#breakhourdurationlbl").html(parseInt(value.BreakHour)>0 ? value.BreakHour+" Minute" : "");

                        $("#latetimebreaklbl").html(parseInt(value.LateTimeBreak)>0 ? value.LateTimeBreak+" Minute" : "");
                        $("#leaveearlytimebreak").html(parseInt(value.LeaveEarlyTimeBreak)>0 ? value.LeaveEarlyTimeBreak+" Minute" : "");

                        $("#checkinlatelbl").html((value.CheckInLateMinute == null || value.CheckInLateMinute === null) ? "" : value.CheckInLateMinute+" Minute Count as Absent");
                        $("#checkoutearlylbl").html((value.CheckOutEarlyMinute == null || value.CheckOutEarlyMinute === null) ? "" : value.CheckOutEarlyMinute+" Minute Count as Absent");

                        let nocheckinmin=value.NoCheckInFlag==2 ? value.NoCheckInMinute+" Minute" :"";
                        $("#nocheckinmarklbl").html(value.NoCheckInFlags+" "+nocheckinmin);

                        let nocheckoutmin=value.NoCheckOutFlag==3 ? value.NoCheckOutMinute+" Minute" :"";
                        $("#nocheckoutmarklbl").html(value.NoCheckOutFlags+" "+nocheckoutmin);

                        $("#descriptionlbl").html(value.Description);
                        $("#timetblstatuslbl").html(value.Status == "Active" ? "<b style='color:#1cc88a'>"+value.Status+"</b>" : "<b style='color:#e74a3b'>"+value.Status+"</b>");
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        if(value.action == "Edited"){
                            classes="warning";
                        }
                        else if(value.action == "Created"){
                            classes="success";
                        }
                        lidata+='<li class="timeline-item"><span class="timeline-point timeline-point-'+classes+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i> '+value.FullName+'</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span></div></li>';
                    });
                    $("#timetblactiondiv").empty();
                    $('#timetblactiondiv').append(lidata);
                }
            });

            $(".infoactiontimetbl").collapse('hide');
            $("#timetableinfomodal").modal('show');
        }

        function convhr(hrnum){
            var prdhour="";
            var prdmin="";
            prdhour = parseInt(hrnum/60);
            prdmin = hrnum %60;
            if(prdmin<10){
                prdmin = "0" + prdmin;
            }
            return prdhour + "." + prdmin+" hr";
        }

        function closeDailyInfoFn(){
            $('#activityul').empty();
            $('#assignedtimediv').empty();
        }

        $('#deleterecbtn').click(function() {
            var delform = $("#deleteForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteholiday',
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
                    $('#deleterecbtn').text('Deleting...');
                    $('#deleterecbtn').prop("disabled", true);
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
                        $('#deleterecbtn').text('Delete');
                        $('#deleterecbtn').prop("disabled", false);
                        toastrMessage('error',"Error found</br>This record cannot be deleted because it exists with other records.","Error");
                    }
                    else if(data.success){
                        $('#deleterecbtn').text('Delete');
                        $('#deleterecbtn').prop("disabled", false);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                        $("#deletemodal").modal('hide');
                    }
                }
            });
        });

        function getAllEmployee(){
            $("#orgtree").empty();
            var treevals="";
            $.get("/employeelists" , function(data) {
                treevals='<ul id="treeview" class="hummingbird-base mt-0" style="padding:0px 0px 0px 0px;">';
                $.each(data.emplist, function(key, empvalue) {
                    treevals+='<li data-id="'+empvalue.id+'" class="attremployee"><label style="font-size:12px;"><input style="width:17px;height:17px;accent-color:#7367f0;" class="hummingbird-end-node attemptree attdepartment_'+empvalue.departments_id+'" id="'+empvalue.id+'-'+empvalue.departments_id+'" data-id="custom-'+empvalue.departments_id+'-'+empvalue.id+'" name="employees[]" value="'+empvalue.id+'" type="checkbox"/>    '+empvalue.name+'</label></li>';
                });
                treevals+='</ul>';
                $("#orgtree").append(treevals);
            });
            $("#orgtree").hummingbird();
        }

        $('#SearchEmployee').keyup(function(){
 
            // Search text
            var text = $(this).val();

            jQuery.expr[':'].contains = function(a, i, m) {
                return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
            };
            // Hide all content class element
            $('.attremployee').hide();

            // Search and show
            $('.attremployee:contains("'+text+'")').show(); 
            if(text!=null && text!=""){
                $('#selectalldiv').hide();
            }
            else if(text=="" || text===""){
                $('#selectalldiv').show();
            }
        });

        $('#button-addon').click(function(){
            $('#SearchEmployee').val("");
            $('#selectalldiv').show();
            $('.attremployee').show();
        });

        $('#selectalldep').change(function() {
            if($(this).is(":checked")) {
                $('.attemptree').prop('checked', true); 
            }
            else{
                $('.attemptree').prop('checked', false);
            }
            $('#employeelist-error').html("");
        });

        $('#attendanceall').change(function() {
            if($(this).is(":checked")) {
                $('.attendancecls').prop('checked', true); 
            }
            else{
                $('.attendancecls').prop('checked', false);
            }
            $('#attendancerecords-error').html("");
        });

        $(document).on('click', '.attemptree', function(){
            var currentind=$(this).attr('id');
            var idandclass = currentind.split("-");
            var idval=idandclass[0];
            var classval=idandclass[1];
            if($(this).is(":checked")) {

                var allemp=$('.attemptree').length;
                var checkedemp=$('.attemptree:checked').length;

                if(parseInt(allemp)==parseInt(checkedemp)){
                    $('#selectalldep').prop('indeterminate', false); 
                    $('#selectalldep').prop('checked', true); 
                }
                else if(parseInt(allemp)!=parseInt(checkedemp)){
                    $('#selectalldep').prop('indeterminate', true); 
                }
            }
            else{

                var allemp=$('.attemptree').length;
                var uncheckedemp=$('.attemptree:not(:checked)').length;

                if(parseInt(allemp)==parseInt(uncheckedemp)){
                    $('#selectalldep').prop('indeterminate', false); 
                    $('#selectalldep').prop('checked', false); 
                }
                else if(parseInt(allemp)!=parseInt(checkedemp)){
                    $('#selectalldep').prop('indeterminate', true); 
                }
            }
            $('#employeelist-error').html("");
        });

        $(document).on('click', '.attendancecls', function(){
            var currentind=$(this).attr('id');
            var idandclass = currentind.split("-");
            var idval=idandclass[0];
            var classval=idandclass[1];
            if($(this).is(":checked")) {

                var allemp=$('.attendancecls').length;
                var checkedemp=$('.attendancecls:checked').length;

                if(parseInt(allemp)==parseInt(checkedemp)){
                    $('#attendanceall').prop('indeterminate', false); 
                    $('#attendanceall').prop('checked', true); 
                }
                else if(parseInt(allemp)!=parseInt(checkedemp)){
                    $('#attendanceall').prop('indeterminate', true); 
                }
            }
            else{

                var allemp=$('.attendancecls').length;
                var uncheckedemp=$('.attendancecls:not(:checked)').length;

                if(parseInt(allemp)==parseInt(uncheckedemp)){
                    $('#attendanceall').prop('indeterminate', false); 
                    $('#attendanceall').prop('checked', false); 
                }
                else if(parseInt(allemp)!=parseInt(checkedemp)){
                    $('#attendanceall').prop('indeterminate', true); 
                }
            }
            $('#attendancerecords-error').html("");
        });

        $(document).on('click', '.showallpunchistory', function(){
            var currval=$(this).attr('value');
            $(`.punchhistorydate-${currval}-hide`).hide();
            if($(this).is(":checked")) {
                $(`.punchhistorydate-${currval}-hide`).show();
            }
            // else{
            //     $('#activityul'+currval).show();
            //     $('#activityulall'+currval).hide();
            // }
        });

        $(document).on('click', '.dailyshowallpunchistory', function(){
            var daynum=$(this).attr('value');
            $(`.dailypunchhistory-hide`).hide();
            if($(this).is(":checked")) {
                $(`.dailypunchhistory-hide`).show();
            }
        });

        function legendval() {
            $('#legends').popover({
                trigger: "hover",
                title: 'Legend',
                width:'1000px',
                container: "body",
                html: true,
                content: function () {
                    $("#legendcontent").html(presenticon+"  Present</br>"+lateorearlyicon+" Late PunchIn or Early PunchOut");
                    return $("#legenddiv").html(); 
                }
            });
        } 

        function timeFn() {
            $('#time-error').html('');
        }

        function timeErrorFn(ele) {
            var cid=$(ele).closest('tr').find('.vals').val();
            $('#EditTime'+cid).css("background","white");
        }

        function ptypeFn(ele) {
            var cid=$(ele).closest('tr').find('.vals').val();
            $('#select2-PunchType'+cid+'-container').parent().css('background-color',"white");
        }

        function offdutyTimeFn() {
            var onduty=$("#OnDutyTime").val();
            var offduty=$("#OffDutyTime").val();

            var diff = (new Date("1970-1-1 " + offduty) - new Date("1970-1-1 " + onduty) ) /1000/60;
            var hour = parseInt(diff/60);
            var min = diff%60;
            if(min<10){
                min = "0" + min;
            }
            $('#durationlbl').html("Duration "+hour + ":" + min);
            $('#WorkingHour').val(hour + ":" + min);
            $('#durationdiv').show();
            $('#offdutytime-error').html('');
        }

        var excel_file = document.getElementById('BrowseFile');
        $('#excel_data').empty();
        var arraya = [];
        var attdatarow=0;
        
        excel_file.addEventListener('change', (event) => {
            if(!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(event.target.files[0].type))
            {
                document.getElementById('excel_data').innerHTML = '<div class="alert alert-danger">Only .xlsx or .xls file format are allowed</div>';
                excel_file.value = '';
                return false;
            }
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
            var reader = new FileReader();
            reader.readAsArrayBuffer(event.target.files[0]);

            reader.onload = function(event){
                var data = new Uint8Array(reader.result);
                var work_book = XLSX.read(data, {type:'array'});
                var sheet_name = work_book.SheetNames;
                var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1});
                if(sheet_data.length > 0)
                {
                    arraya=[];
                    attdatarow=0;
                    
                    var table_output = '<table class="table table-striped table-bordered table-sm">';
                    for(var row = 0; row < sheet_data.length; row++)
                    {
                        if(row!=0){
                            arraya.push(sheet_data[row][0]);
                            if(getOccurrence(arraya,sheet_data[row][0])>1){
                                attdatarow=row;
                            }
                        }
                        
                        table_output += '<tr>';
                        for(var cell = 0; cell < sheet_data[row].length; cell++)
                        {
                            if(row == 0)
                            {
                                table_output += '<th>'+sheet_data[row][cell]+'</th>';
                            }
                            else
                            {
                                if(row==attdatarow && cell==0){
                                    if(row==attdatarow && cell==0){
                                        table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][0]+'</td>';
                                    }
                                }
                                else{
                                    table_output += '<td>'+sheet_data[row][cell]+'</td>';
                                }
                                
                                $('#totallogrecord').val(parseInt(row)-parseInt(2));
                                $('#recordnum').html("<h3>Total Log: <b>"+numformat(parseInt(row)-parseInt(2))+"</b></h3>");
                            }
                        }
                        table_output += '</tr>';
                        attdatarow=0;
                    }
                    table_output += '</table>';
                    document.getElementById('excel_data').innerHTML = table_output;
                    $('#excel_data').show();
                    
                }
            }
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
        });

        function getOccurrence(array, value) {
            var count = 0;
            array.forEach((v) => (v === value && count++));
            return count;
        }


        function closeRegisterModal() {
            $('.mainforminp').val("");
            $('.errordatalabel').html('');
            $('#selectalldep').prop('indeterminate', false); 
            $('#selectalldep').prop('checked', false); 
            $('.attemptree').prop('checked', false);
            $('#AttendanceDateRange').val(""); 
            $('#recId').val("");
            $('#operationtypes').val("1");
            $('.attemptree').prop('checked', false);
            $('#PunchType').val(null).select2({
                minimumResultsForSearch: -1
            });
            $('#selectalldiv').show();
            $('.attremployee').show();
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }

        $(".exportattlogtoexcel").click(function () {
            var tableid = "";
            var rowCount = 0;
            var employeeName = "";
            var empName = "";
            var date = "";
            var department = "";
            var position = "";
            var titletext = "";
            var filename = "";
            var dateormonth = "";
            var sheetname = "";
            var branch = "";
            var employeeid = "";
            if($(this).attr('id') == "dailyexporttoexcel"){
                tableid = "dailyReport";
                rowCount = $(`#${tableid} > tbody > tr`).length;
                employeeName = $('#empname').html();
                empName = $('#empname').html();
                date = $('#dayandtimelbl').text();
                department = $('#dailydepartmentlbl').html();
                position = $('#dailypositionlbl').html();
                titletext = `Daily Attendance Report`;
                filename = `Daily_Attendance_of_`;
                dateormonth = "Date";
                sheetname = `Daily_Report_`;
                branch = $('#hiddenBranch').val();
                employeeid = $('#hiddenEmployeeId').val();
            }
            if($(this).attr('id') == "monthlyexporttoexcel"){
                tableid = "monthlyReport";
                rowCount = $(`#${tableid} > tbody > tr`).length;
                employeeName = $('#monthempname').html();
                empName = $('#monthempname').html();
                date = $('#infomonthdisplay').html();
                department = $('#monthlydepartment').val();
                position = $('#monthlyposition').val();
                titletext = `Monthly Attendance Report`;
                filename = `Monthly_Attendance_of_`;
                dateormonth = "Month";
                sheetname = `Detail_of_`;
                branch = $('#hiddenBranchMonthly').val();
                employeeid = $('#hiddenEmployeeIdMonthly').val();
            }

            if(parseInt(rowCount) == 0){
                toastrMessage('error',"Attendance Log not found!","Error");
            }
            else if(parseInt(rowCount) > 0){
                empName = empName.replace(" ", "_");
                empName = empName.replace(" ", "_");
                date = date.replace("<i>", "");
                date = date.replace("</i>", "");
                date = date.replace("  ", "");
                department = department.replace(" ", "");
                position = position.replace(" ", "");
                $('#pdfLoading').show();
                setTimeout(() => {
                    const table = document.getElementById(tableid);
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet(`${sheetname}${date}`);

                    //Title Row
                    const title = titletext;
                    const titleRow = worksheet.addRow([title]);
                    titleRow.font = { bold: true, size: 15 };
                    titleRow.alignment = { horizontal: 'center', vertical: 'middle' };
                    worksheet.mergeCells(1, 1, 1, table.rows[0].cells.length);
                    //worksheet.addRow([]); // Spacer row

                    const emptitle = `Employee ID: ${employeeid}  |   Employee Name: ${employeeName}  |   ${dateormonth}: ${date}`;
                    const emptitleRow = worksheet.addRow([emptitle]);
                    emptitleRow.font = { bold: false, size: 11 };
                    emptitleRow.alignment = { horizontal: 'center', vertical: 'middle' };
                    worksheet.mergeCells(2, 1, 2, table.rows[0].cells.length);

                    const subtitle = `Branch: ${branch}  |   Department: ${department}  |   Position: ${position}`;
                    const subtitleRow = worksheet.addRow([subtitle]);
                    subtitleRow.font = { bold: false, size: 11 };
                    subtitleRow.alignment = { horizontal: 'center', vertical: 'middle' };
                    worksheet.mergeCells(3, 1, 3, table.rows[0].cells.length);
                    worksheet.addRow([]); // Spacer row
                    worksheet.mergeCells(4, 1, 4, table.rows[0].cells.length);

                    // Header Rows
                    let headerRowCount = 0;

                    const headerStartRow = worksheet.rowCount - headerRowCount + 1; // the row index where header started
                    const headerEndRow = 5; // the last header row
                    const totalColumns = table.rows[0].cells.length;
                    
                    $(`#${tableid} thead tr`).each(function () {
                        const row = [];
                        $(this).find("th").each(function () {
                            row.push($(this).text().trim());
                        });
                        const addedRow = worksheet.addRow(row);
                        headerRowCount++;

                        // Apply header styling immediately
                        addedRow.eachCell((cell) => {
                            cell.font = { bold: true };
                            cell.fill = {
                                type: 'pattern',
                                pattern: 'solid',
                                fgColor: { argb: 'D3D3D3' }
                            };
                            cell.alignment = { horizontal: 'center', vertical: 'middle' };
                            cell.border = {
                                top: { style: 'thin' },
                                left: { style: 'thin' },
                                bottom: { style: 'thin' },
                                right: { style: 'thin' }
                            };
                        });
                    });

                    worksheet.autoFilter = {
                        from: {
                            row: headerEndRow,
                            column: 1
                        },
                        to: {
                            row: headerEndRow,
                            column: totalColumns
                        }
                    };

                    worksheet.views = [
                    {
                        state: 'frozen',
                        ySplit: headerEndRow, // Freezes rows above the last header
                        xSplit: 0
                    }
                    ];

                    // Data Rows
                    const data = [];
                    $(`#${tableid} tbody tr`).each(function () {
                        const row = [];
                        $(this).find("td").each(function () {
                            row.push($(this).text().trim());
                        });
                        data.push(row);
                    });

                    const startRow = worksheet.rowCount + 1;
                    data.forEach(row => worksheet.addRow(row));

                    worksheet.eachRow(function (row, rowNumber) {
                        row.eachCell(function (cell, colNumber) {
                            // Save existing font properties
                            const existingFont = cell.font;
                            cell.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
                            cell.border = {
                                top: { style: 'thin' },
                                left: { style: 'thin' },
                                bottom: { style: 'thin' },
                                right: { style: 'thin' }
                            };
                            cell.font = { 
                                ...existingFont, 
                                name: 'Montserrat'
                            };
                        });
                    });

                    $(`#${tableid} tfoot tr`).each(function () {
                        const cells = [];
                        const colspans = [];
                        $(this).find("td").each(function () {
                            cells.push($(this).text().trim());
                            colspans.push(parseInt($(this).attr("colspan")) || 1);
                        });

                        // Create row with empty cells to ensure ExcelJS knows how many to place
                        const totalColumns = colspans.reduce((a, b) => a + b, 0);
                        const newRow = worksheet.addRow(new Array(totalColumns).fill(""));

                        let colIndex = 1;
                        for (let i = 0; i < cells.length; i++) {
                            const colspan = colspans[i];
                            const text = cells[i];

                            if (colspan > 1) {
                                worksheet.mergeCells(newRow.number, colIndex, newRow.number, colIndex + colspan - 1);
                            }
                            const cell = worksheet.getCell(newRow.number, colIndex);
                            cell.value = text;
                            cell.alignment = colspan > 1 ? { horizontal: 'right', vertical: 'middle' } : { horizontal: 'center', vertical: 'middle' };
                            cell.border = {
                                top: { style: 'thin' },
                                left: { style: 'thin' },
                                bottom: { style: 'thin' },
                                right: { style: 'thin' }
                            };
                            cell.font = { 
                                bold: true,
                                size: 11,
                                name: 'Montserrat'
                            };
                            colIndex += colspan;
                        }
                    });

                    // Set auto width with max cap
                    worksheet.columns.forEach((column) => {
                        let maxLength = 10;
                        column.eachCell({ includeEmpty: true }, (cell) => {
                            let cellValue = cell.value ? cell.value.toString() : '';
                            if (cellValue.length > maxLength) {
                                maxLength = cellValue.length;
                            }
                        });
                        column.width = Math.min(maxLength + 2, 15); // +2 padding, max 30
                    });
                    worksheet.getColumn(1).width = 5; 
                    worksheet.getColumn(3).width = 18; 
                    worksheet.getColumn(4).width = 25; 
                    worksheet.getColumn(5).width = 21; 
                    worksheet.getColumn(6).width = 32; 
                    worksheet.getColumn(17).width = 20; 

                    // === Hierarchical Merge Function ===
                    function mergeByColumnsHierarchically(data, startRow, worksheet) {
                        const totalRows = data.length || 0;
                        const totalCols = data[0].length || 0;
                        const col1Merges = []; // Store row ranges for column index 1 merges

                        // Step 1: Merge column index 1 (second column) hierarchically and record merges
                        let mergeStart = 0;
                        for (let row = 1; row < totalRows; row++) {
                            const current = data[row][1];
                            const previous = data[row - 1][1];

                            if (current !== previous) {
                                if (row - 1 > mergeStart) {
                                    const fromRow = startRow + mergeStart;
                                    const toRow = startRow + row - 1;
                                    worksheet.mergeCells(fromRow, 2, toRow, 2); // colIndex 1 => column 2
                                    col1Merges.push([mergeStart, row - 1]);
                                }
                                mergeStart = row;
                            }
                        }

                        if (totalRows - 1 > mergeStart) {
                            const fromRow = startRow + mergeStart;
                            const toRow = startRow + totalRows - 1;
                            worksheet.mergeCells(fromRow, 2, toRow, 2);
                            col1Merges.push([mergeStart, totalRows - 1]);
                        }

                        // Step 2: Merge columns 2 and 3 (index 2 and 3) using parent-child logic
                        for (let colIndex = 2; colIndex <= 3; colIndex++) {
                            for (const [parentStart, parentEnd] of col1Merges) {
                                let childMergeStart = parentStart;
                                for (let row = parentStart + 1; row <= parentEnd; row++) {
                                    const current = data[row][colIndex];
                                    const previous = data[row - 1][colIndex];
                                    const parentMatch = data[row][colIndex - 1] === data[row - 1][colIndex - 1];

                                    if (current !== previous || !parentMatch) {
                                        if (row - 1 > childMergeStart) {
                                            const fromRow = startRow + childMergeStart;
                                            const toRow = startRow + row - 1;
                                            worksheet.mergeCells(fromRow, colIndex + 1, toRow, colIndex + 1);
                                        }
                                        childMergeStart = row;
                                    }
                                }

                                if (parentEnd > childMergeStart) {
                                    const fromRow = startRow + childMergeStart;
                                    const toRow = startRow + parentEnd;
                                    worksheet.mergeCells(fromRow, colIndex + 1, toRow, colIndex + 1);
                                }
                            }
                        }

                        // Step 3: Copy same row spans from column 1 to columns > 5
                        for (let colIndex = 6; colIndex < totalCols; colIndex++) {
                            const colNumber = colIndex + 1;
                            for (const [rowStart, rowEnd] of col1Merges) {
                                if (rowEnd > rowStart) {
                                    const fromRow = startRow + rowStart;
                                    const toRow = startRow + rowEnd;
                                    try {
                                        worksheet.mergeCells(fromRow, colNumber, toRow, colNumber);
                                    } catch (e) {
                                        // Skip if already merged
                                    }
                                }
                            }
                        }
                    }
                    mergeByColumnsHierarchically(data, startRow, worksheet);

                    if($(this).attr('id') == "monthlyexporttoexcel"){
                        const colspanval = 7;
                        const summtable = document.getElementById(statusSummaryTbl);
                        const worksheetB = workbook.addWorksheet(`Summary_of_${date}`);
                        const titleB = `Summary of ${date}`;
                        const titleRowB = worksheetB.addRow([titleB]);
                        titleRowB.font = { bold: true, size: 15 };
                        titleRowB.alignment = { horizontal: 'center', vertical: 'middle' };
                        worksheetB.mergeCells(1, 1, 1,colspanval);

                        const emptitleB = `Employee Name: ${employeeName}  |   ${dateormonth}: ${date}`;
                        const emptitleRowB = worksheetB.addRow([emptitleB]);
                        emptitleRowB.font = { bold: false, size: 11 };
                        emptitleRowB.alignment = { horizontal: 'center', vertical: 'middle' };
                        worksheetB.mergeCells(2, 1, 2, colspanval);

                        const subtitleB = `Department: ${department}  |   Position: ${position}`;
                        const subtitleRowB = worksheetB.addRow([subtitleB]);
                        subtitleRowB.font = { bold: false, size: 11 };
                        subtitleRowB.alignment = { horizontal: 'center', vertical: 'middle' };
                        worksheetB.mergeCells(3, 1, 3, colspanval);
                        worksheetB.addRow([]); // Spacer row
                        worksheetB.mergeCells(4, 1, 4, colspanval);

                        var subtitleC = "Attendance Summary";
                        var subtitleD = "Work Time Statistics";
                        const subtitleRowC = worksheetB.addRow([]);
                        subtitleRowC.font = { bold: true, size: 12};

                        subtitleRowC.alignment = { horizontal: 'center', vertical: 'middle' };
                        worksheetB.mergeCells(5, 1, 5, 3);
                        worksheetB.mergeCells(5, 5, 5, 7);
                        worksheetB.getCell(5, 1).value = subtitleC;
                        worksheetB.getCell(5, 5).value = subtitleD;
                        worksheetB.getCell(5, 1).fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'D3D3D3' }};
                        worksheetB.getCell(5, 5).fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'D3D3D3' }};

                        var headerRowCountB = 0;
                        $(`#statusSummaryTbl thead tr`).each(function () {
                            const row = [];
                            $(this).find("th").each(function () {
                                row.push($(this).text().trim());
                            });
                            const addedRow = worksheetB.addRow(row);
                            headerRowCountB++;

                            // Apply header styling immediately
                            addedRow.eachCell((cell) => {
                                cell.font = { bold: true };
                                cell.fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: { argb: 'D3D3D3' }
                                };
                                cell.alignment = { horizontal: 'center', vertical: 'middle' };
                                cell.border = {
                                    top: { style: 'thin' },
                                    left: { style: 'thin' },
                                    bottom: { style: 'thin' },
                                    right: { style: 'thin' }
                                };
                            });
                        });

                        const dataB = [];
                        $(`#statusSummaryTbl tbody tr`).each(function () {
                            const row = [];
                            $(this).find("td").each(function () {
                                row.push($(this).text().trim());
                            });
                            dataB.push(row);
                        });

                        const startRowB = worksheetB.rowCount + 1;
                        dataB.forEach(row => worksheetB.addRow(row));

                        const summaryStartRow = 6;

                        $(`#hourSummaryData thead tr`).each(function (theadRowIndex) {
                            $(this).find("th").each(function (colIndex) {
                                const cell = worksheetB.getCell(summaryStartRow, colIndex + 5); // D = 4
                                cell.value = $(this).text().trim();
                                cell.font = { bold: true };
                                cell.fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: { argb: 'D3D3D3' }
                                };
                                cell.alignment = { horizontal: 'center', vertical: 'middle' };
                                cell.border = {
                                    top: { style: 'thin' },
                                    left: { style: 'thin' },
                                    bottom: { style: 'thin' },
                                    right: { style: 'thin' }
                                };
                            });
                        });

                        // Write data rows
                        $(`#hourSummaryData tbody tr`).each(function (rowIndex) {
                            $(this).find("td").each(function (colIndex) {
                                const cell = worksheetB.getCell(summaryStartRow + rowIndex + 1, colIndex + 5); // Start from row 6
                                cell.value = $(this).text().trim();
                                cell.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
                                cell.border = {
                                    top: { style: 'thin' },
                                    left: { style: 'thin' },
                                    bottom: { style: 'thin' },
                                    right: { style: 'thin' }
                                };
                                cell.font = {
                                    name: 'Montserrat'
                                };
                            });
                        });

                        worksheetB.eachRow(function (row, rowNumber) {
                            row.eachCell(function (cell, colNumber) {
                                // Save existing font properties
                                const existingFontB = cell.font;
                                cell.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
                                cell.border = {
                                    top: { style: 'thin' },
                                    left: { style: 'thin' },
                                    bottom: { style: 'thin' },
                                    right: { style: 'thin' }
                                };
                                cell.font = { 
                                    ...existingFontB, 
                                    name: 'Montserrat'
                                };
                            });
                        });
                        worksheetB.getColumn(1).width = 5; 
                        worksheetB.getColumn(2).width = 50; 
                        worksheetB.getColumn(3).width = 25; 
                        worksheetB.getColumn(5).width = 5; 
                        worksheetB.getColumn(6).width = 50; 
                        worksheetB.getColumn(7).width = 25; 
                    }
                    // Save File
                    workbook.xlsx.writeBuffer().then(data => {
                        const blob = new Blob([data], {
                            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        });
                        saveAs(blob, `${filename}${empName}_${date}.xlsx`);
                        $('#pdfLoading').hide();
                    });
                }, 100); // slight delay to allow loading UI to show
            }
        });

        function mergeTableHierarchically(tableId, ignoreCols = []) { 
            const table = document.getElementById(tableId);
            const rows = Array.from(table.querySelectorAll("tbody tr"));

            function mergeColumn(colIndex, rowStart, rowEnd) {
                let currentText = null;
                let spanStart = rowStart;
                for (let i = rowStart; i <= rowEnd + 1; i++) {
                    const cellText = i <= rowEnd ? rows[i].children[colIndex].textContent.trim() : null;
                    if (i === rowStart) {
                        currentText = cellText;
                    } else if (cellText !== currentText) {
                        if (i - spanStart > 1) {
                            const rowspan = i - spanStart;
                            rows[spanStart].children[colIndex].rowSpan = rowspan;
                            for (let j = spanStart + 1; j < i; j++) {
                                rows[j].children[colIndex].style.display = "none";
                            }
                        }
                        spanStart = i;
                        currentText = cellText;
                    }
                }
            }

            function recursiveMerge(cols, startRow, endRow, level = 0) {
                if (level >= cols.length) return;
                let col = cols[level];
                let blockStart = startRow;

                for (let i = startRow; i <= endRow + 1; i++) {
                    const current = i <= endRow ? rows[i].children[col].textContent.trim() : null;
                    const prev = i > startRow ? rows[i - 1].children[col].textContent.trim() : null;

                    if (i === startRow || current === prev) {
                        continue;
                    } else {
                        mergeColumn(col, blockStart, i - 1);
                        recursiveMerge(cols, blockStart, i - 1, level + 1);
                        blockStart = i;
                    }
                }

                if (blockStart <= endRow) {
                    mergeColumn(col, blockStart, endRow);
                    recursiveMerge(cols, blockStart, endRow, level + 1);
                }
            }

            // Determine which columns to merge hierarchically
            const colCount = rows[0].children.length;
            const mergeCols = Array.from({ length: colCount }, (_, i) => i).filter(i => !ignoreCols.includes(i));

            recursiveMerge(mergeCols, 0, rows.length - 1);

            // Sync rowspan for columns > 5 to match column 1
            const departmentColIndex = 1;
            const syncStartCol = 6;

            for (let i = 0; i < rows.length; i++) {
                const deptCell = rows[i].children[departmentColIndex];
                if (deptCell && deptCell.rowSpan > 1) {
                    const rowspan = deptCell.rowSpan;
                    for (let col = syncStartCol; col < colCount; col++) {
                        const targetCell = rows[i].children[col];
                        if (targetCell) {
                            targetCell.rowSpan = rowspan;
                            for (let k = 1; k < rowspan; k++) {
                                if (rows[i + k]?.children[col]) {
                                    rows[i + k].children[col].style.display = "none";
                                }
                            }
                        }
                    }
                }
            }
        }

        $('.printattlog').click(function () {
            var tableid = "";
            var rowCount = 0;
            var employeeName = "";
            var empName = "";
            var date = "";
            var department = "";
            var position = "";
            var titletext = "";
            var filename = "";
            var dateormonth = "";
            var branch = "";
            var employeeid = "";
            var currentdateandtime = "";
            if($(this).attr('id') == "dailyprinttable"){
                tableid = "dailyReport";
                rowCount = $(`#${tableid} > tbody > tr`).length;
                employeeName = $('#empname').html();
                empName = $('#empname').html();
                date = $('#dayandtimelbl').html();
                department = $('#dailydepartmentlbl').html();
                position = $('#dailypositionlbl').html();
                titletext = `Daily Attendance Report`;
                filename = `Daily_Attendance_of_`;
                dateormonth = `Date`;
                branch = $('#hiddenBranch').val();
                employeeid = $('#hiddenEmployeeId').val();
                currentdateandtime = $('#hiddenCurrentTimeDaily').val();
            }
            if($(this).attr('id') == "monthlyprinttable"){
                tableid = "monthlyReport";
                rowCount = $(`#${tableid} > tbody > tr`).length;
                employeeName = $('#monthempname').html();
                empName = $('#monthempname').html();
                date = $('#infomonthdisplay').html();
                department = $('#monthlydepartment').val();
                position = $('#monthlyposition').val();
                titletext = `Monthly Attendance Report`;
                filename = `Monthly_Attendance_of_`;
                dateormonth = `Month`;
                branch = $('#hiddenBranchMonthly').val();
                employeeid = $('#hiddenEmployeeIdMonthly').val();
                currentdateandtime = $('#hiddenCurrentTimeMonthly').val();
            }
            if (parseInt(rowCount) === 0) {
                toastrMessage('error', "Attendance Log not found!", "Error");
                return;
            }

            empName = empName.replace(" ", "_");
            empName = empName.replace(" ", "_");
            date = date.replace("<i>", "");
            date = date.replace("</i>", "");
            date = date.replace("  ", "");

            $('#pdfLoading').show();
            setTimeout(() => {
                const clonedTable = $(`#${tableid}`).clone();
                clonedTable.attr("id", "clonedReport");
                clonedTable.css({
                    'border-collapse': 'collapse',
                    'width': '100%',
                    'font-family': "'Montserrat', sans-serif",
                    'color': 'black',
                    position: 'absolute',
                    left: '-9999px',
                    top: '-9999px',
                });
                clonedTable.find('th, td').css({
                    'border': '0.5px solid black',
                    'padding': '2px 3px',
                    'text-align': 'center',
                    'box-shadow': 'none'
                });
                clonedTable.find('thead th').css({
                    'background-color': '#D3D3D3',
                    'font-weight': 'bold'
                });
                // Append hidden cloned table
                $('body').append(clonedTable);
                mergeTableHierarchically("clonedReport", [0, 4, 5]);

                // Now export PDF using cloned table
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4'
                });
                const totalPagesExp = "{total_pages_count_string}";

                doc.setFontSize(20);  // Title font size
                doc.setFont("helvetica", "bold");
                doc.setTextColor(0, 0, 0);  

                const marginTop = 25; // Enough for title + header lines
                const pageWidth = doc.internal.pageSize.width;
                
                const titleText = titletext;
                const textWidth = doc.getStringUnitWidth(titleText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
                const xCoordinate = (pageWidth - textWidth) / 2;  // Centering the text

                doc.text(titleText, xCoordinate, 10); 

                const marginX = 15;
                const startY = 16;
                const rowHeight = 6;
                const colPadding = 0;

                // Column widths
                const col1Width = 30;
                const col2Width = 40;
                const colSpacer = 2;
                const col3Width = 30;
                const col4Width = 70;
                const col5Width = 15;
                const col6Width = 45;

                // Total width to center
                const totalWidth = col1Width + col2Width + colSpacer + col3Width + col4Width + col5Width + col6Width;
                const startX = (pageWidth - totalWidth) / 2;
                // Row 1
                doc.setFontSize(10);

                // Labels normal, values bold
                doc.setFont("helvetica", "normal");
                doc.text("Employee ID:", startX, startY);
                doc.setFont("helvetica", "bold");
                doc.text(employeeid, startX + col1Width + colPadding, startY);

                doc.setFont("helvetica", "normal");
                doc.text("Employee Name:", startX + col1Width + col2Width + colPadding, startY);
                doc.setFont("helvetica", "bold");
                doc.text(employeeName, startX + col1Width + col2Width + col3Width + colPadding + colSpacer, startY);

                doc.setFont("helvetica", "normal");
                doc.text(`${dateormonth}:`,startX + col1Width + col2Width + col3Width + col4Width, startY);
                doc.setFont("helvetica", "bold");
                doc.text(date, startX + col1Width + col2Width + col3Width + col4Width + col5Width, startY);

                // Row 2
                const secondRowY = startY + rowHeight;

                doc.setFont("helvetica", "normal");
                doc.text("Branch:", startX, secondRowY);
                doc.setFont("helvetica", "bold");
                doc.text(branch,startX + col1Width + colPadding, secondRowY);

                doc.setFont("helvetica", "normal");
                doc.text("Department:",startX + col1Width + col2Width + colPadding, secondRowY);
                doc.setFont("helvetica", "bold");
                doc.text(department, startX + col1Width + col2Width + col3Width + colPadding + colSpacer, secondRowY);

                doc.setFont("helvetica", "normal");
                doc.text("Position:", startX + col1Width + col2Width + col3Width + col4Width, secondRowY);
                doc.setFont("helvetica", "bold");
                doc.text(position, startX + col1Width + col2Width + col3Width + col4Width + col5Width, secondRowY);

                doc.autoTable({
                    html: '#clonedReport',
                    useCss: true, // Important: reads actual CSS from your HTML table
                    theme: "grid",
                    startY: marginTop, // Ensures first table starts below the header
                    //showHead: 'firstPage', // only on first page
                    showFoot: 'lastPage', // only on last page
                    styles: {
                        fontSize: 8,
                        cellPadding: 0.5,
                        overflow: "linebreak",
                        valign: "middle",
                        halign: "center",
                        lineWidth: 0.1,
                        lineColor: [0, 0, 0],
                        textColor: [0, 0, 0],
                    },
                    headStyles: {
                        fontSize: 9,
                        fillColor: [211, 211, 211],
                        textColor: [0, 0, 0],
                        fontStyle: "bold",
                    },
                    footStyles: {
                        fontSize: 9,
                        fillColor: [255, 255, 255],  // A bit darker gray than head
                        textColor: [0, 0, 0],
                        halign: 'center', // default center alignment in footer
                    },
                    margin: { top: 1, left: 1, right: 1 },
                    didParseCell: function (data) {
                        if (data.section === 'foot' && data.column.index === 0) {
                            data.cell.styles.halign = 'right';
                        }
                    },
                    didDrawPage: function (data) {
                        const pageCount = doc.internal.getNumberOfPages();
                        const pageWidth = doc.internal.pageSize.getWidth();
                        const pageHeight = doc.internal.pageSize.getHeight();

                        doc.setFontSize(8);
                        doc.setFont("helvetica", "normal");
                        doc.text(`Page ${data.pageNumber} of ${totalPagesExp}`, pageWidth + 25, pageHeight - 3, {
                            align: "right"
                        });

                        doc.text(`Printed on: ${currentdateandtime}`, 5, pageHeight - 3);

                        // Thin separator line (just above the bottom margin)
                        doc.setDrawColor(0); // Black
                        doc.setLineWidth(0.1); // Thin line
                        doc.line(1, pageHeight - 7, pageWidth - 1, pageHeight - 7); // From (x1, y1) to (x2, y2)
                    }
                });

                if (typeof doc.putTotalPages === 'function') {
                    doc.putTotalPages(totalPagesExp);
                }

                const blob = doc.output("bloburl");
                const printWindow = window.open(blob, `_blank`, 'width=1400,height=800,top=100,left=100');

                if (printWindow) {
                    printWindow.focus();
                    // printWindow.onload = function () {
                    //     printWindow.print();
                    // };
                } else {
                    toastrMessage('error', "Popup blocked. Please allow popups for this site.", "Error");
                    $('#pdfLoading').hide();
                }

                // Clean up
                $('#pdfLoading').hide();
                clonedTable.remove();
            }, 100);
        });

        $('.exportattlogtopdf').click(function () {
            var tableid = "";
            var rowCount = 0;
            var employeeName = "";
            var empName = "";
            var date = "";
            var department = "";
            var position = "";
            var titletext = "";
            var filename = "";
            var dateormonth = "";
            var branch = "";
            var employeeid = "";
            var currentdateandtime = "";
            if($(this).attr('id') == "dailyexportpdf"){
                tableid = "dailyReport";
                rowCount = $(`#${tableid} > tbody > tr`).length;
                employeeName = $('#empname').html();
                empName = $('#empname').html();
                date = $('#dayandtimelbl').html();
                department = $('#dailydepartmentlbl').html();
                position = $('#dailypositionlbl').html();
                titletext = `Daily Attendance Report`;
                filename = `Daily_Attendance_of_`;
                branch = $('#hiddenBranch').val();
                employeeid = $('#hiddenEmployeeId').val();
                dateormonth = `Date`;
                currentdateandtime = $('#hiddenCurrentTimeDaily').val();
            }
            if($(this).attr('id') == "monthlyexportpdf"){
                tableid = "monthlyReport";
                rowCount = $(`#${tableid} > tbody > tr`).length;
                employeeName = $('#monthempname').html();
                empName = $('#monthempname').html();
                date = $('#infomonthdisplay').html();
                department = $('#monthlydepartment').val();
                position = $('#monthlyposition').val();
                titletext = `Monthly Attendance Report`;
                filename = `Monthly_Attendance_of_`;
                branch = $('#hiddenBranchMonthly').val();
                employeeid = $('#hiddenEmployeeIdMonthly').val();
                dateormonth = `Month`;
                currentdateandtime = $('#hiddenCurrentTimeMonthly').val();
            }
            if (parseInt(rowCount) === 0) {
                toastrMessage('error', "Attendance Log not found!", "Error");
                return;
            }

            empName = empName.replace(" ", "_");
            empName = empName.replace(" ", "_");
            date = date.replace("<i>", "");
            date = date.replace("</i>", "");
            date = date.replace("  ", "");
            //department = department.replace(" ", "");
            //position = position.replace("", "");

            $('#pdfLoading').show();
            setTimeout(() => {
                const clonedTable = $(`#${tableid}`).clone();
                clonedTable.attr("id", "clonedReport");
                clonedTable.css({
                    'border-collapse': 'collapse',
                    'width': '100%',
                    'font-family': "'Montserrat', sans-serif",
                    'color': 'black',
                    position: 'absolute',
                    left: '-9999px',
                    top: '-9999px',
                });
                clonedTable.find('th, td').css({
                    'border': '0.5px solid black',
                    'padding': '2px 3px',
                    'text-align': 'center',
                    'box-shadow': 'none'
                });
                clonedTable.find('thead th').css({
                    'background-color': '#D3D3D3',
                    'font-weight': 'bold'
                });
                // Append hidden cloned table
                $('body').append(clonedTable);
                mergeTableHierarchically("clonedReport", [0, 4, 5]);

                // Now export PDF using cloned table
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4'
                });
                const totalPagesExp = "{total_pages_count_string}";

                doc.setFontSize(20);  // Title font size
                doc.setFont("helvetica", "bold");
                doc.setTextColor(0, 0, 0);  

                const marginTop = 25; // Enough for title + header lines
                const pageWidth = doc.internal.pageSize.width;
                const titleText = titletext;
                const textWidth = doc.getStringUnitWidth(titleText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
                const xCoordinate = (pageWidth - textWidth) / 2;  // Centering the text

                doc.text(titleText, xCoordinate, 10); 

                const marginX = 15;
                const startY = 16;
                const rowHeight = 6;
                const colPadding = 0;

                // Column widths
                const col1Width = 30;
                const col2Width = 40;
                const colSpacer = 2;
                const col3Width = 30;
                const col4Width = 70;
                const col5Width = 15;
                const col6Width = 45;

                // Total width to center
                const totalWidth = col1Width + col2Width + colSpacer + col3Width + col4Width + col5Width + col6Width;
                const startX = (pageWidth - totalWidth) / 2;
                // Row 1
                doc.setFontSize(10);

                // Labels normal, values bold
                doc.setFont("helvetica", "normal");
                doc.text("Employee ID:", startX, startY);
                doc.setFont("helvetica", "bold");
                doc.text(employeeid, startX + col1Width + colPadding, startY);

                doc.setFont("helvetica", "normal");
                doc.text("Employee Name:", startX + col1Width + col2Width + colPadding, startY);
                doc.setFont("helvetica", "bold");
                doc.text(employeeName, startX + col1Width + col2Width + col3Width + colPadding + colSpacer, startY);

                doc.setFont("helvetica", "normal");
                doc.text(`${dateormonth}:`,startX + col1Width + col2Width + col3Width + col4Width, startY);
                doc.setFont("helvetica", "bold");
                doc.text(date, startX + col1Width + col2Width + col3Width + col4Width + col5Width, startY);

                // Row 2
                const secondRowY = startY + rowHeight;

                doc.setFont("helvetica", "normal");
                doc.text("Branch:", startX, secondRowY);
                doc.setFont("helvetica", "bold");
                doc.text(branch,startX + col1Width + colPadding, secondRowY);

                doc.setFont("helvetica", "normal");
                doc.text("Department:",startX + col1Width + col2Width + colPadding, secondRowY);
                doc.setFont("helvetica", "bold");
                doc.text(department, startX + col1Width + col2Width + col3Width + colPadding + colSpacer, secondRowY);

                doc.setFont("helvetica", "normal");
                doc.text("Position:", startX + col1Width + col2Width + col3Width + col4Width, secondRowY);
                doc.setFont("helvetica", "bold");
                doc.text(position, startX + col1Width + col2Width + col3Width + col4Width + col5Width, secondRowY);
                
                doc.autoTable({
                    html: '#clonedReport',
                    useCss: true, // Important: reads actual CSS from your HTML table
                    theme: "grid",
                    startY: marginTop, // Ensures first table starts below the header
                    //showHead: 'firstPage', // only on first page
                    showFoot: 'lastPage', // only on last page
                    styles: {
                        fontSize: 8,
                        cellPadding: 0.5,
                        overflow: "linebreak",
                        valign: "middle",
                        halign: "center",
                        lineWidth: 0.1,
                        lineColor: [0, 0, 0],
                        textColor: [0, 0, 0],
                    },
                    headStyles: {
                        fontSize: 9,
                        fillColor: [211, 211, 211],
                        textColor: [0, 0, 0],
                        fontStyle: "bold",
                    },
                    footStyles: {
                        fontSize: 9,
                        fillColor: [255, 255, 255],  // A bit darker gray than head
                        textColor: [0, 0, 0],
                        halign: 'center', // default center alignment in footer
                    },
                    margin: { top: 1, left: 1, right: 1 },
                    didParseCell: function (data) {
                        if (data.section === 'foot' && data.column.index === 0) {
                            data.cell.styles.halign = 'right';
                        }
                    },
                    didDrawPage: function (data) {
                        const pageCount = doc.internal.getNumberOfPages();
                        const pageWidth = doc.internal.pageSize.getWidth();
                        const pageHeight = doc.internal.pageSize.getHeight();

                        doc.setFontSize(8);
                        doc.setFont("helvetica", "normal");
                        doc.text(`Page ${data.pageNumber} of ${totalPagesExp}`, pageWidth + 25, pageHeight - 3, {
                            align: "right"
                        });

                        doc.text(`Exported on: ${currentdateandtime}`, 5, pageHeight - 3);

                        // Thin separator line (just above the bottom margin)
                        doc.setDrawColor(0); // Black
                        doc.setLineWidth(0.1); // Thin line
                        doc.line(1, pageHeight - 7, pageWidth - 1, pageHeight - 7); // From (x1, y1) to (x2, y2)

                        // Thin separator line (just above the bottom margin)
                        doc.setDrawColor(0); // Black
                        doc.setLineWidth(0.1); // Thin line
                        doc.line(1, pageHeight - 7, pageWidth - 1, pageHeight - 7); // From (x1, y1) to (x2, y2)
                    
                        if (data.pageNumber > 1) {
                            doc.autoTable.previous.finalY = 60;
                        }
                    }
                });

                if (typeof doc.putTotalPages === 'function') {
                    doc.putTotalPages(totalPagesExp);
                }

                doc.save(`${filename}${empName}_${date}.pdf`);

                // Clean up
                $('#pdfLoading').hide();
                clonedTable.remove();
            }, 100);
        });

        function punchTypeFn(){
            $('#punchtype-error').html('');
        }

        function datetimefn(){
            $('#date-error').html('');
        }

        function remarkFn() {
            $('#remark-error').html('');
        }

        function deviceTypeFn() {
            $('#devicetype-error').html('');
        }

        function devicesFn() {
            $('#devices-error').html('');
        }

        function importDateRangeFn() {
            $('#importdaterange-error').html('');
        }

        function deviceLogExcelFn() {
            $('#devicetypeexcel-error').html('');
        }

        function devicesExcelFn() {
            $('#devicesexcel-error').html('');
        }

        function browseFileFn() {
            $('#browsefile-error').html('');
        }
    </script>
@endsection
