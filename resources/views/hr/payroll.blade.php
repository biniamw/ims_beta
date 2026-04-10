@extends('layout.app1')

@section('title')
@endsection

@section('content')

    @can('Payroll-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Payroll</h3>
                            
                        </div>
                        <div class="card-datatable">
                            <div style="width:99%; margin-left:0.5%;">
                                <div style="display: none;" id="payrollDiv">
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width:3%;">#</th>
                                                <th style="width:15%;">ID</th>
                                                <th style="width:15%;">Type</th>
                                                <th style="width:22%;">Branch</th>
                                                <th style="width:21%;">Pay Range</th>
                                                <th style="width:20%;">Status</th>
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
    </div>
    @endcan

    <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="overtimelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle">Add Payroll Addition</h4>
                    <div class="row">
                        <div style="text-align: right;" class="errordatalabel" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                <div class="divider">
                                    <div class="divider-text">Employee Selection</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="tree-container">
                                            <div class="search-container">
                                                <input type="text" class="search-box" placeholder="Search...">
                                                <span style="color: #ea5455" class="clear-search">&times;</span>
                                            </div>
                                            <div class="master-checkbox">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="text-align: left;">
                                                    <input type="checkbox" id="masterCheckbox">
                                                    <label for="masterCheckbox"><b>Select All</b></label></br>
                                                    <span class="text-danger">
                                                        <strong id="employeelist-error" class="errordatalabel"></strong>
                                                        <strong id="employee-error" class="errordatalabel"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="text-align: right;">
                                                    <label style="font-size: 14px;" id="selectedEmployee"></label>
                                                </div>
                                            </div>
                                            <div class="scrdivhor scrollhor" style="margin-left: -20px;overflow-y: scroll;height:15rem">
                                                <div class="loading_employee_tree">Loading employee data...</div>
                                                <div class="no-results">No matching results found</div>
                                                <ul class="tree" id="treeRoot"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12" style="display: none;">
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control mainforminp" name="SearchEmployee" id="SearchEmployee" placeholder="Search Employee here..." aria-label="Search Employee here..." aria-describedby="button-addon">
                                            <button class="btn btn-outline-danger waves-effect btn-sm" type="button" id="button-addon"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button>
                                        </div>
                                        
                                        <div id="selectalldiv">
                                            <label style="font-size:14px;font-weight:bold;"><input class="hummingbird-end-node" style="width:16px;height:16px;" id="selectalldep" class="selectalldep" type="checkbox"/>  Select All</label>
                                        </div>
                                        <div id="orgtree" class="hummingbird-treeview scrollhor" style="overflow-y: scroll;height:15rem;"></div>
                                    </div>
                                    <div style="display: none;">
                                        <div class="col-xl-4 col-md-4 col-sm-12 mb-1">
                                            <label style="font-size: 14px;">Branch</label><label style="color: red; font-size:16px;">*</label>
                                            <select class="select2 form-control" name="Branch[]" id="Branch" multiple>
                                                @foreach ($branchlist as $branchlist)
                                                <option value="{{$branchlist->branches_id}}">{{$branchlist->BranchName}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="branch-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-sm-12 mb-1">
                                            <label style="font-size: 14px;">Department</label><label style="color: red; font-size:16px;">*</label>
                                            <select class="select2 form-control" name="Department" id="Department" onchange="departmentFn()"></select>
                                            <span class="text-danger">
                                                <strong id="department-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-sm-12 mb-1">
                                            <label style="font-size: 14px;">Position</label><label style="color: red; font-size:16px;">*</label>
                                            <select class="select2 form-control" name="Position" id="Position" onchange="positionFn()"></select>
                                            <span class="text-danger">
                                                <strong id="position-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                            <label style="font-size: 14px;">Employee</label><label style="color: red; font-size:16px;">*</label>
                                            <select class="select2 form-control" multiple name="Employee[]" id="Employee"></select>
                                            <input type="checkbox" id="selectAll"> <label id="selectAllLbl" for="selectAll" style="font-size:14px;font-weight:bold;">Select All</label></br>
                                            <span class="text-danger">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                <div class="divider">
                                    <div class="divider-text">Payment Period</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                                <label style="font-size: 14px;">Pay Range</label><label style="color: red; font-size:16px;">*</label>
                                                <div>
                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td style="width: 49%">
                                                                <select class="select2 form-control fromdatecls" name="FromMonthRange" id="FromMonthRange" onchange="fromMonthRangeFn()">
                                                                    <option value=""></option>
                                                                    @foreach ($fromMonthData as $fromMonthData)
                                                                        <option value="{{$fromMonthData->month_year}}">{{$fromMonthData->month_yearfullformat}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td style="width: 2%">
                                                                <label style="font-size: 14px;font-weight:bold;">to</label>
                                                            </td>
                                                            <td style="width: 49%">
                                                                <select class="select2 form-control todatecls" name="ToMonthRange" id="ToMonthRange" onchange="toMonthRangeFn()"></select>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="monthrange-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                                <label style="font-size: 14px;">Remark</label>
                                                <div>
                                                    <textarea type="text" placeholder="Write Remark here..." class="form-control mainforminp" rows="2" name="Remark" id="Remark" onkeyup="remarkFn()"></textarea>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="remark-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                        <label style="font-size: 14px;"></label>
                                        <div>
                                            <table class="rtable" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2" style="text-align: center">Pay Range Information</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="display: none;">
                                                        <td colspan="2" style="text-align: center">Gregorian Calendar</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 23%">
                                                            <label style="font-size: 14px;">Start Date</label>
                                                        </td>
                                                        <td style="width: 77%">
                                                            <label id="grgStartDate" style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label style="font-size: 14px;">End Date</label>
                                                        </td>
                                                        <td>
                                                            <label id="grgEndDate" style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none;">
                                                        <td colspan="2" style="text-align: center">Ethiopian Calendar</td>
                                                    </tr>
                                                    <tr style="display: none;">
                                                        <td>
                                                            <label style="font-size: 14px;">Start Date</label>
                                                        </td>
                                                        <td>
                                                            <label id="ethStartDate" style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none;">
                                                        <td>
                                                            <label style="font-size: 14px;">End Date</label>
                                                        </td>
                                                        <td>
                                                            <label id="ethEndDate" style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="m-1"/>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 table-responsive scroll scrdiv" id="dynamicTableDiv">
                                <table id="dynamicPayrollTable" class="mb-0 rtable dynamicColumnTable" style="text-align:center;width: 100%;">
                                    <thead id="payroll-header" class="dynamicHeader" style="font-size: 11px"></thead>
                                    <tbody id="payrollBody" class="dynamicBody scrdivhor scrollhor" style="font-size: 10px;font-weight:bold;overflow-y: scroll;max-height:5rem"></tbody>
                                    <tfoot id="payrollFooter" class="dynamicFooter" style="font-size: 14px; font-weight: bold;"></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="DepartmentHidd" id="DepartmentHidd">
                                @foreach ($deplist as $deplist)
                                <option title="{{$deplist->branches_id}}" value="{{$deplist->departments_id}}">{{$deplist->DepartmentName}}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="PositionHidd" id="PositionHidd">
                                @foreach ($positionlist as $positionlist)
                                <option title="{{$positionlist->departments_id}}" value="{{$positionlist->positions_id}}">{{$positionlist->PositionName}}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="EmployeeHidd" id="EmployeeHidd">
                                @foreach ($emplist as $emplist)
                                <option label="{{$emplist->branches_id}}" title="{{$emplist->positions_id}}" value="{{$emplist->id}}">{{$emplist->name}}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="ToMonthRangeHidd" id="ToMonthRangeHidd">
                                @foreach ($toMonthData as $toMonthData)
                                <option value="{{$toMonthData->month_year}}">{{$toMonthData->month_yearfullformat}}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="SalaryTypeHidd" id="SalaryTypeHidd">
                                <option title="Earnings" selected value="0"></option>
                                <option title="Deductions" selected value="0"></option>
                                @foreach ($salarytypes as $salarytypes)
                                <option data-is_shown_on_payroll="{{$salarytypes->show_on_payroll}}" title="{{$salarytypes->SalaryType}}" value="{{$salarytypes->id}}">{{$salarytypes->SalaryTypeName}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" class="form-control recordidcls" name="recId" id="recId" readonly="true" value=""/>     
                            <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                            <input type="hidden" class="form-control" name="startDateVal" id="startDateVal" readonly="true"/>
                            <input type="hidden" class="form-control" name="endDateVal" id="endDateVal" readonly="true"/>
                        </div>
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
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
                    <h4 class="modal-title">Payroll Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <section id="collapsible">
                                <div class="card collapse-icon">
                                    <div class="collapse-default">
                                        <div class="card">
                                            <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                <span class="lead collapse-title">Payroll Basic & Action Information</span>
                                                <div id="statustitlesA"></div>
                                            </div>
                                            <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Basic Information</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table style="width: 100%;">
                                                                        <tr style="display: none">
                                                                            <td style="width: 22%"><label style="font-size: 14px;">ID</label></td>
                                                                            <td style="width: 78%"><label id="payrollIdInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 20%"><label style="font-size: 14px;">Type</label></td>
                                                                            <td style="width: 80%"><label id="typeInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Branch</label></td>
                                                                            <td><label id="branchInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Pay Range</label></td>
                                                                            <td><label id="payrangeInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Remark</label></td>
                                                                            <td><label id="remarkInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Action Information</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:13rem">
                                                                            <ul id="actiondiv" class="timeline mb-0 mt-0"></ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <hr class="m-0"/>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="infoPayrollTable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%;">
                                            <thead id="infoPayroll-header" class="dynamicHeader table table-sm" style="font-size: 11px;"></thead>
                                            <tbody id="infoPayrollBody" class="table table-sm" style="text-align: left"></tbody>
                                            <tfoot id="infoPayrollFooter" class="dynamicFooter"></tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="company_name_val" id="company_name_val" readonly="true"/> 
                        <input type="hidden" class="form-control" name="pay_period" id="pay_period" readonly="true"/> 
                        <input type="hidden" class="form-control" name="current_date_time" id="current_date_time" readonly="true"/> 
                        <input type="hidden" class="form-control recordidcls" name="recInfoId" id="recInfoId" readonly="true"/> 
                        <input type="hidden" class="form-control fromdatecls" name="fromdateinfo" id="fromdateinfo" readonly="true"/> 
                        <input type="hidden" class="form-control todatecls" name="todateinfo" id="todateinfo" readonly="true"/> 
                        <input type="hidden" class="form-control" name="from_date_fullformat" id="from_date_fullformat" readonly="true"/>
                        <input type="hidden" class="form-control" name="to_date_fullformat" id="to_date_fullformat" readonly="true"/>
                        <input type="hidden" class="form-control" name="currentStatus" id="currentStatus" readonly="true">
                        @can('Payroll-ChangeToPending')
                        <button id="changetopending" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Change to Pending</button>
                        <button id="backtodraft" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Draft</button>
                        @endcan
                        @can('Payroll-Verify')
                        <button id="verifybtn" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Verify Payroll</button>
                        <button id="backtopending" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Pending</button>
                        @endcan
                        @can('Payroll-Approve')
                        <button id="approvebtn" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Approve Payroll</button>
                        <button id="backtoverify" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Verify</button>
                        <button id="rejectbtn" type="button" class="btn btn-info backwardbtn actionpropbtn">Reject</button>
                        @endcan

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
                        <label strong style="font-size: 13px;font-weight:bold;color:white;">Do you really want to delete this overtime level?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="delRecId" id="delRecId" readonly="true">
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

    <!--Start forward action modal -->
    <div class="modal fade text-left" id="forwardActionModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="forwardActionForm">
                    @csrf
                    <div class="modal-body" id="modalBodyId">
                        <label style="font-size: 16px;font-weight:bold;" id="forwardActionLabel"></label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="forwardReqId" id="forwardReqId" readonly="true">
                            <input type="hidden" class="form-control" name="newForwardStatusValue" id="newForwardStatusValue" readonly="true">
                            <input type="hidden" class="form-control" name="forwarkBtnTextValue" id="forwarkBtnTextValue" readonly="true">
                            <input type="hidden" class="form-control" name="forwardActionValue" id="forwardActionValue" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="forwardActionBtn" type="button" class="btn btn-info"></button>
                        <button id="closebuttonforwardAction" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End forward action modal -->

    <!--Start backward action modal -->
    <div class="modal fade text-left" id="backwardActionModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="backwardActionForm">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 14px;" id="backwardActionLabel"></label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Comment/Reason here..." class="form-control" rows="3" name="CommentOrReason" id="CommentOrReason" onkeyup="commentValFn()"></textarea>
                            <span class="text-danger">
                                <strong id="commentres-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="backwardReqId" id="backwardReqId" readonly="true">
                        <input type="hidden" class="form-control" name="newBackwardStatusValue" id="newBackwardStatusValue" readonly="true">
                        <input type="hidden" class="form-control" name="backwardBtnTextValue" id="backwardBtnTextValue" readonly="true">
                        <input type="hidden" class="form-control" name="backwardActionValue" id="backwardActionValue" readonly="true">
                        <button id="backwardActionBtn" type="button" class="btn btn-info"></button>
                        <button id="closebuttonbackwardAction" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End backward action modal -->

    <!--Start Payroll modal -->
    <div class="modal fade text-left" id="detailPayrollModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="width: 75% !important;margin-left: auto !important;margin-right: auto !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Payroll Detail Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="detailmodalform">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mt-0">
                                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto mt-2">
                                        <img id="payrollemployeepic" src="../../../storage/uploads/HrEmployee/dummypic.jpg" alt="-" class="d-block h-auto ms-0 ms-sm-2 rounded" width="100" height="100">
                                    </div>
                                    <div class="flex-grow-0 mt-0 mt-sm-0" style="margin-left: -20px;">
                                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                            <div class="user-profile-info" style="text-align: left;margin-top: -15px;">
                                                <h3 id="employeepdfullname" title="Employee Full Name"></h3>
                                                <h6 id="employeepdid" title="Employee ID"></h6>
                                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="branchlbl" title="Branch"></label>
                                                    </li>
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="departmentlbl" title="Department"></label>
                                                    </li>
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="positionlbl" title="Position"></label>
                                                    </li>
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="payrangelbl" title="Pay Range"></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="m-1"/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <table id="earininginfotbl" class="mb-0 rtable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th colspan="5" style="text-align: center;">Earnings</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 3%;">#</th>
                                            <th style="width: 40%;">Salary Component Name</th>
                                            <th style="width: 19%;">Taxable</th>
                                            <th style="width: 19%;">Non-Taxable</th>
                                            <th style="width: 19%;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" style="text-align: right">Total</th>
                                            <th id="totaltaxable" style="text-align: center;font-weight:bold;"></th>
                                            <th id="nontotaltaxable" style="text-align: center;font-weight:bold;"></th>
                                            <th id="totalinfoearaning" style="text-align: center;font-weight:bold;"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <table id="deductioninfotbl" class="mb-0 rtable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="text-align: center;">Deductions</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 3%;">#</th>
                                            <th style="width: 50%;">Salary Component Name</th>
                                            <th style="width: 47%;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" style="text-align: right;">Total</th>
                                            <th id="totalinfodeduction" style="text-align: center;font-weight:bold;"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mt-1"></div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mt-1">
                                <table id="infoSummaryTable" class="rtable" style="width:100%;text-align: center">
                                    <thead>
                                        <tr>
                                            <th colspan="2" style="text-align: center">Summary</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px;">
                                        <tr>
                                            <td style="width: 50%;font-weight:bold;">Basic Salary</td>
                                            <td style="width: 50%">
                                                <div class="input-group">
                                                    <label id="basicsalaryinfolbl" class="summfig" style="font-size: 14px;font-weight:bold;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></label>
                                                    <i id="basicsalaryicon" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%); display:none;"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="companypensionlbl">Company Pension</td>
                                            <td id="infocompensiondiv">
                                                <div class="input-group">
                                                    <label id="companypensionval" class="summfig" style="font-size: 14px;font-weight:bold;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></label>
                                                    <i id="companypensioninfo" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center">-</td>
                                        </tr>
                                        <tr>
                                            <td>Taxable Earning</td>
                                            <td>
                                                <label id="taxablearningval" class="summfig" style="font-size: 14px;font-weight:bold"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Non-Taxable Earning</td>
                                            <td>
                                                <label id="nontaxablearningval" class="summfig" style="font-size: 14px;font-weight:bold"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Earning</td>
                                            <td>
                                                <label id="totalearningval" class="summfig" style="font-size: 14px;font-weight:bold"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Deduction</td>
                                            <td>
                                                <label id="totaldeductionval" class="summfig" style="font-size: 14px;font-weight:bold"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Net Pay</td>
                                            <td id="infonetpaydiv">
                                                <div class="input-group">
                                                    <label id="netpayval" class="summfig" style="font-size: 14px;font-weight:bold;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></label>
                                                    <i id="infonetpayinfo" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mt-1"></div>
                        </div>
                        <div class="row" style="display: none;">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <table id="payslip_table" style="width: 100%;color:#000000;">
                                    <tr>
                                        <td colspan="2" style="text-align: center;font-size:30px;font-weight:bold;" id="company_name"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;font-size:20px;font-weight:bold;" id="payslip_title"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr class="m-1"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table style="width: 100%">
                                                <tr>
                                                    <td style="width: 15%">Employee ID</td>
                                                    <td style="width: 33%;font-weight:bold" id="payslip_employeeid"></td>
                                                    <td style="width: 4%"></td>
                                                    <td style="width: 18%">Hired Date</td>
                                                    <td style="width: 30%;font-weight:bold" id="payslip_hireddate"></td>
                                                </tr>
                                                <tr>
                                                    <td>Employee Name</td>
                                                    <td id="payslip_employeename" style="font-weight:bold"></td>
                                                    <td></td>
                                                    <td>Working Day</td>
                                                    <td id="payslip_workingday" style="font-weight:bold"></td>
                                                </tr>
                                                <tr>
                                                    <td>Branch</td>
                                                    <td id="payslip_branch" style="font-weight:bold"></td>
                                                    <td></td>
                                                    <td>Bank Name</td>
                                                    <td id="payslip_bankname" style="font-weight:bold"></td>
                                                </tr>
                                                <tr>
                                                    <td>Department</td>
                                                    <td id="payslip_department" style="font-weight:bold"></td>
                                                    <td></td>
                                                    <td>Bank Account</td>
                                                    <td id="payslip_bankaccount" style="font-weight:bold"></td>
                                                </tr>
                                                <tr>
                                                    <td>Position</td>
                                                    <td id="payslip_position" style="font-weight:bold"></td>
                                                    <td></td>
                                                    <td>Pension Number</td>
                                                    <td id="payslip_pensionnumber" style="font-weight:bold"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr class="m-1"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7">
                                                    <table id="payslip_earning" class="mb-0 report_table" style="width: 100%;border-color: #000000;">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="5" style="text-align: center;">Earnings</th>
                                                            </tr>
                                                            <tr style="font-size: 12px">
                                                                <th style="width: 3%;">#</th>
                                                                <th style="width: 40%;">Salary Component Name</th>
                                                                <th style="width: 19%;">Taxable</th>
                                                                <th style="width: 19%;">Non-Taxable</th>
                                                                <th style="width: 19%;">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="2" style="text-align: right">Total</th>
                                                                <th id="payslip_totaltaxable" style="text-align: center;font-weight:bold;"></th>
                                                                <th id="payslip_nontotaltaxable" style="text-align: center;font-weight:bold;"></th>
                                                                <th id="payslip_totalinfoearaning" style="text-align: center;font-weight:bold;"></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5">
                                                    <table id="payslip_deduction" class="mb-0 report_table" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="3" style="text-align: center;">Deductions</th>
                                                            </tr>
                                                            <tr style="font-size: 12px">
                                                                <th style="width: 3%;">#</th>
                                                                <th style="width: 55%;">Salary Component Name</th>
                                                                <th style="width: 42%;">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="2" style="text-align: right;">Total</th>
                                                                <th id="payslip_totalinfodeduction" style="text-align: center;font-weight:bold;"></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;width: 100%;"></td>
                                    </tr>
                                    <tr class="report_table">
                                        <th colspan="2" style="text-align: center;width: 100%;" id="payslip_netpay"></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;width: 100%;height:3rem;"></td>
                                    </tr>
                                    <tr>
                                        <td style="50%">____________________________</br>Employer's Signature</td>
                                        <td style="50%;text-align:right">____________________________</br>Employee's Signature</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="text-align: left;">
                                    <div style="display:none;" id="payslip_btn">
                                        <button id="payslip_printtable" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm printattlog" title="Print" style="color: #4B5563"><i class="fa-solid fa-print fa-lg" aria-hidden="true"></i></button>
                                        <button id="payslip_exporttoexcel" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm exportattlogtoexcel" title="Export to Excel" style="color: #15803D"><i class="fa-solid fa-file-excel fa-lg" aria-hidden="true"></i></button>
                                        <button id="payslip_exportpdf" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm exportattlogtopdf" title="Export to PDF" style="color: #B91C1C"><i class="fa-solid fa-file-pdf fa-lg" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="text-align: right">
                                    <input type="hidden" class="form-control" name="name" id="payslip_status" readonly="true"/>  
                                    <input type="hidden" class="form-control" name="name" id="payslip_period" readonly="true"/>  
                                    <input type="hidden" class="form-control" name="name" id="fromdatepayroll" readonly="true"/>  
                                    <input type="hidden" class="form-control" name="name" id="todatepayroll" readonly="true"/>
                                    <input type="hidden" class="form-control" name="name" id="perhoursalaryval" readonly="true"/>  
                                    <button id="closebuttonl" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Payroll modal -->

    <!--Start Payroll Information Modal -->
    <div class="modal modal-slide-in event-sidebar fade" id="paddinformationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="PayrollInformationForm">
        {{ csrf_field() }}
            <div class="modal-dialog modal-xl" role="document" style="width: 80%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title">Payroll Addition / Deduction Information</h4>
                        <div style="text-align: center;padding-right:30px;" id="paddstatustitles"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-0">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 mt-1">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse2" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl2" aria-expanded="false" aria-controls="collapse2">
                                                        <span class="lead collapse-title">Payroll Addition / Deduction Basic & Action Information</span>
                                                        <div id="statustitlesA"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse infoscl2">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%;">
                                                                                <tr style="display: none;">
                                                                                    <td style="width: 22%"><label style="font-size: 14px;">ID</label></td>
                                                                                    <td style="width: 78%"><label id="payrollIdInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Type</label></td>
                                                                                    <td><label id="paddtypeInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Branch</label></td>
                                                                                    <td><label id="paddbranchInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Department</label></td>
                                                                                    <td><label id="padddepartmentInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Position</label></td>
                                                                                    <td><label id="paddpositionInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Pay Range</label></td>
                                                                                    <td><label id="paddpayrangeInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Remark</label></td>
                                                                                    <td><label id="paddremarkInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Action Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:13rem">
                                                                                    <ul id="paddactiondiv" class="timeline mb-0 mt-0"></ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                    <div class="divider">
                                        <div class="divider-text">Selected Employee's</div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <table id="employeetablelist" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:20%;">Employee ID</th>
                                                        <th style="width:57%;">Employee Name</th>
                                                        <th style="width:20%;">Employee Phone</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table table-sm"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-12 col-lg-12 col-sm-12">
                                    <div class="divider">
                                        <div class="divider-text">Selected Salary Component for each Employee's</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                            <table id="salarycomponentlist" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th id="infotitlename" colspan="4" style="text-align:center;"></th>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:42%;">Salary Component</th>
                                                        <th style="width:25%;">Amount</th>
                                                        <th style="width:30%;">Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table table-sm"></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2" style="text-align: right;">
                                                            <label style="font-size: 10px;font-weight:bold;" id="infototalamountlbl"></label>
                                                        </td>
                                                        <td colspan="2">
                                                            <label id="infototalamountval" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttonpadd" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End Payroll Information Modal -->

    <!--Start Overtime Modal -->
    <div class="modal modal-slide-in event-sidebar fade" id="overtimedetailmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="OvertimeInformationForm">
        {{ csrf_field() }}
            <div class="modal-dialog modal-xl" role="document" style="width: 45%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title">Overtime Detail Information</h4>
                        <div style="text-align: center;padding-right:30px;" id="otstatustitles"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-0">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-1">
                                <table id="otdetailtable" class="mb-0 rtable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th colspan="6" style="text-align: center;">Overtime</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 3%;">#</th>
                                            <th style="width: 20%;">Level Name</th>
                                            <th style="width: 19%;">Rate</th>
                                            <th style="width: 19%;">Per hour Salary</th>
                                            <th style="width: 19%;">Hour</th>
                                            <th style="width: 20%;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" style="text-align: right">Total</th>
                                            <th id="totalothour" style="text-align: center;font-weight:bold;"></th>
                                            <th id="totalotamount" style="text-align: center;font-weight:bold;"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttonot" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End Overtime Modal -->

    <div id="pdfLoading" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:#00000080;color:white;z-index:9999;text-align:center;padding-top:20%;">
        <div style="font-size:20px;font-weight:bold;">Preparing Report...</div>
    </div>

    <script type="text/javascript">
        var errorcolor="#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });

        var j=0;
        var i=0;
        var m=0;
        var globalFlg = 0;
        var payrollColumns = {}; // Store columns globally
        var employeeIdList = [];
        var selectedEmployees = [];
        var lateabsent = {};
        var footersKey = [];
        var taxRanges = [];

        var statusTransitions = {
            'Draft': {
                forward: {
                    status: 'Pending',
                    text: 'Change to Pending',
                    action: 'Change to Pending',
                    message: 'Do you really want to change payroll to pending?',
                    forecolor: '#6e6b7b',
                    backcolor: '#f6c23e'
                }
            },
            'Pending': {
                forward: {
                    status: 'Verified',
                    text: 'Verify',
                    action: 'Verified',
                    message: 'Do you really want to verify payroll?',
                    forecolor: '#6e6b7b',
                    backcolor: '#f6c23e'
                },
                backward: {
                    status: 'Draft',
                    text: 'Back to Draft',
                    action: 'Back to Draft',
                    message: 'Comment'
                }
            },
            'Verified': {
                forward: {
                    status: 'Approved',
                    text: 'Approve',
                    action: 'Approved',
                    message: 'Do you really want to approve payroll?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                },
                backward: {
                    status: 'Pending',
                    text: 'Back to Pending',
                    action: 'Back to Pending',
                    message: 'Comment'
                },
                reject: {
                    status: 'Rejected',
                    text: 'Reject',
                    action: 'Rejected',
                    message: 'Reason'
                }
            },
            'Approved': {
                backward: {
                    status: 'Verified',
                    text: 'Back to Verify',
                    action: 'Back to Verify',
                    message: 'Comment'
                },
                reject: {
                    status: 'Rejected',
                    text: 'Reject',
                    action: 'Rejected',
                    message: 'Reason'
                }
            },
            'Rejected': {
                forward: {
                    status: 'Approved',
                    text: 'Approve',
                    action: 'Approved',
                    message: 'Do you really want to approve payroll?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                }
            },
        };

        function getRangeData(){
            $.ajax({ 
                url: '/getTaxRange',
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    $.each(data.taxrangelist, function(index, value) {
                        taxRanges.push({
                            min: parseFloat(value.MinAmount),
                            max: isNaN(parseFloat(value.MaxAmount)) ? Infinity : parseFloat(value.MaxAmount),
                            tax: parseFloat(value.TaxRate),
                            deduction: parseFloat(value.Deduction),
                        });
                    });
                }
            });
        }
        
        $(document).ready(function() {
            
            var ctable=$('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 0, "desc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-7 left-dom'><'col-sm-12 col-md-3 custom-buttons2'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                scrollY:'60vh',
                scrollX: true,
                scrollCollapse: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/payrollList',
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
                    { data: 'DocumentNumber', name: 'DocumentNumber',width:"15%"},
                    { data: 'Ptype', name: 'Ptype',width:"15%"},
                    { data: 'Branch', name: 'Branch',width:"22%"},
                    { data: 'PayRange', name: 'PayRange',width:"21%"},
                    { data: 'Status', name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return `<span class="badge bg-secondary bg-glow">${data}</span>`;
                            }
                            else if(data == "Pending"){
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                            else if(data == "Verified"){
                                return '<span class="badge bg-primary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Approved"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Verified)" || data == "Void(Approved)"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                        },width:"20%"},
                    { data: 'action', name: 'action',width:"4%"}
                ],
                "initComplete": function () {
                    $('.custom-buttons2').html(`
                        @can('Payroll-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addpayrollreg" id="addpayrollreg" data-toggle="modal">Add</button>
                        @endcan
                    `);
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
                    $('#payrollDiv').show();
                },
            });

            getPayrollColumns();
            getRangeData();

            function buildHierarchy(data) {
                const tree = [];
                const branchesMap = {};
                const departmentsMap = {};
                const positionsMap = {};
                
                // First pass: organize by branches
                data.forEach(employee => {
                    if (!branchesMap[employee.branches_id]) {
                        branchesMap[employee.branches_id] = {
                            id: employee.branches_id,
                            label: employee.BranchName,
                            children: []
                        };
                        tree.push(branchesMap[employee.branches_id]);
                    }

                    var departmentid = `${employee.branches_id}${employee.departments_id}`;
                    
                    // Second level: departments
                    if (departmentid && !departmentsMap[departmentid]) {
                        departmentsMap[departmentid] = {
                            id: departmentid,
                            label: employee.DepartmentName,
                            children: []
                        };
                        branchesMap[employee.branches_id].children.push(departmentsMap[departmentid]);
                    }
                    
                    var positionid = `${employee.branches_id}${employee.departments_id}${employee.positions_id}`;

                    // Third level: positions
                    if (positionid && !positionsMap[positionid]) {
                        positionsMap[positionid] = {
                            id: positionid,
                            label: employee.PositionName,
                            children: []
                        };
                        departmentsMap[departmentid].children.push(positionsMap[positionid]);
                    }
                    
                    // Fourth level: employees
                    if (employee.employees_id) {
                        positionsMap[positionid].children.push({
                            id: employee.employees_id,
                            label: employee.employees_name
                        });
                    }
                });
                
                return tree;
            }

            // Load data via AJAX
            function getEmployeeTreeData(){
                $.ajax({ 
                    url: '/getEmployeeTree',
                    type: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        $('.loading_employee_tree').hide();

                        if (!Array.isArray(data.employeetree)) {
                            $('.loading_employee_tree').text('Error: Invalid data format').css('color', 'red');
                            return;
                        }
                        if (data.employeetree.length === 0) {
                            $('.loading_employee_tree').text('No employee data found').css('color', '#650');
                            return;
                        }
                        const treeData = buildHierarchy(data.employeetree);
                        buildTree(treeData, $('#treeRoot'));
                    },
                    error: function(xhr, status, error) {
                        $('.loading_employee_tree').text('Error loading data: ' + error).css('color', 'red');
                    }
                });
            }

            // Build the tree UI
            function buildTree(data, parent, level = 1) {
                data.forEach(item => {
                    const li = $('<li>').addClass('level-' + level + ' collapsed');
                    
                    const nodeContent = $('<div>').addClass('node-content');
                    
                    // Add toggle button for expandable items
                    if (item.children && item.children.length > 0) {
                        nodeContent.append(
                            $('<div>').addClass('toggle').html('<i class="fas"></i>')
                        );
                    } else {
                        nodeContent.append(
                            $('<div>').addClass('toggle').html('&nbsp;')
                        );
                    }
                    
                    // Add checkbox (now before icon)
                    const checkbox = $('<input>')
                        .addClass(`checkbox  ${level == 4 ? "employeecls" : ""}`)
                        .attr('type', 'checkbox')
                        .attr('id', item.id)
                        .attr('name', level == 4 ? "pemployee[]" : "empheader")
                        .attr('value', item.id)
                        .data('item', item);
                    nodeContent.append(checkbox);
                    
                    // Add appropriate icon based on level
                    //const icon = $('<div>').addClass('icon');
                    const icon = $('<div>')
                    .addClass('icon')
                    .click(function() {
                        checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                    });

                    if (level <= 3) {
                        icon.html('<i class="fas fa-folder"></i>');
                    } else {
                        icon.html('<i class="fas fa-user"></i>');
                    }
                    nodeContent.append(icon);
                    
                    // Add label
                    const label = $('<span>')
                        .addClass('label')
                        .text(item.label)
                        .attr('for', item.id)
                        .click(function() {
                            checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                        });
                    nodeContent.append(label);
                    
                    li.append(nodeContent);

                    // Process children if they exist
                    if (item.children && item.children.length > 0) {
                        const childrenUl = $('<ul>').addClass('children');
                        buildTree(item.children, childrenUl, level + 1);
                        li.append(childrenUl);
                    }

                    parent.append(li);
                });
            }

            // Initialize the tree
            getEmployeeTreeData();

            // Toggle expand/collapse
            $(document).on('click', '.toggle', function(e) {
                e.stopPropagation();
                const li = $(this).closest('li');
                li.toggleClass('expanded');
                li.toggleClass('collapsed');
            });

            // Checkbox change handler
            $(document).on('change', '.checkbox', function() {
                const checkbox = $(this);
                const isChecked = checkbox.prop('checked');
                
                // Update children
                checkbox.closest('li').find('.checkbox').prop('checked', isChecked);
                
                // Update parents
                updateParentCheckboxes(checkbox);
                
                // Update master checkbox
                updateMasterCheckbox();
                updateCheckedCount();
                getEmpSalaryList();
                $('#employee-error').html("");
            });

            // Update parent checkboxes based on child states
            function updateParentCheckboxes(checkbox) {
                const parentLi = checkbox.closest('li').parent().closest('li');
                if (parentLi.length) {
                    const parentCheckbox = parentLi.find('> .node-content .checkbox');
                    const childCheckboxes = parentLi.find('ul .checkbox');
                    
                    const checkedCount = childCheckboxes.filter(':checked').length;
                    const indeterminateCount = childCheckboxes.filter(function() {
                        return $(this).prop('indeterminate');
                    }).length;
                    
                    if (checkedCount === 0 && indeterminateCount === 0) {
                        parentCheckbox.prop('checked', false);
                        parentCheckbox.prop('indeterminate', false);
                    } else if (checkedCount === childCheckboxes.length) {
                        parentCheckbox.prop('checked', true);
                        parentCheckbox.prop('indeterminate', false);
                    } else {
                        parentCheckbox.prop('indeterminate', true);
                        parentCheckbox.prop('checked', false);
                    }
                    
                    // Propagate up the tree
                    updateParentCheckboxes(parentCheckbox);
                }
            }

            // Update master checkbox based on all checkboxes
            function updateMasterCheckbox() {
                const allCheckboxes = $('.checkbox:not(#masterCheckbox)');
                const checkedCount = allCheckboxes.filter(':checked').length;
                const indeterminateCount = allCheckboxes.filter(function() {
                    return $(this).prop('indeterminate');
                }).length;
                
                if (checkedCount === 0 && indeterminateCount === 0) {
                    $('#masterCheckbox').prop('checked', false);
                    $('#masterCheckbox').prop('indeterminate', false);
                } else if (checkedCount === allCheckboxes.length) {
                    $('#masterCheckbox').prop('checked', true);
                    $('#masterCheckbox').prop('indeterminate', false);
                } else {
                    $('#masterCheckbox').prop('indeterminate', true);
                    $('#masterCheckbox').prop('checked', false);
                }
            }

            // Master checkbox handler
            $('#masterCheckbox').change(function() {
                const isChecked = $(this).prop('checked');
                $('.checkbox').prop('checked', isChecked).prop('indeterminate', false);
                updateCheckedCount();
                getEmpSalaryList();
                $('#employee-error').html("");
            });

            // Search functionality
            $('.search-box').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                let hasMatches = false;
                
                if (searchTerm === '') {
                    $('.label').each(function() {
                        $(this).html($(this).text());
                    });
                    $('.tree li').show();
                    $('.no-results').hide();
                    $('.clear-search').hide();
                    return;
                }
                
                $('.clear-search').show();
                
                // First hide all items
                $('.tree li').hide();
                
                $('.label').each(function() {
                    const labelText = $(this).text();
                    const index = labelText.toLowerCase().indexOf(searchTerm);
                    
                    if (index >= 0) {
                        hasMatches = true;
                        const highlightedText = 
                            labelText.substring(0, index) +
                            '<span class="highlight">' + 
                            labelText.substring(index, index + searchTerm.length) + 
                            '</span>' +
                            labelText.substring(index + searchTerm.length);
                        
                        $(this).html(highlightedText);
                        
                        // Show this item and all its parents
                        $(this).closest('li').show()
                            .parents('li').show()
                            .addClass('expanded').removeClass('collapsed');
                    } else {
                        $(this).html(labelText);
                    }
                });
                
                if (hasMatches) {
                    $('.no-results').hide();
                } else {
                    $('.no-results').show();
                }
            });

            // Clear search button
            $('.clear-search').click(function() {
                $('.search-box').val('').trigger('input');
                $(this).hide();
            });

            // Show/hide clear button based on input
            $('.search-box').on('input', function() {
                $('.clear-search').toggle($(this).val().length > 0);
            });

            updateCheckedCount();
        });

        function updateCheckedCount() {
            const count = $('.tree .employeecls:checked').not('#masterCheckbox').length;
            $('#selectedEmployee').html(`<b>${count}</b> Employee(s) selected`);
        }

        function getPayrollColumns(){
            $.ajax({
                url: '/getPayrollColumns',
                method: 'POST',
                success: function (response) {
                    let table = $('.dynamicColumnTable');
                    let header1 = $('<tr></tr>');
                    let header2 = $('<tr></tr>');
                    let header3 = $('<tr></tr>');
                    let countStatic = 0;

                    // Render static headers
                    response.firstStaticColumns.forEach(function (col) {
                        ++countStatic;
                        let colwidth = 0;
                        if(parseInt(countStatic) == 1){
                            colwidth = 2;
                        }
                        else if(parseInt(countStatic) == 2){
                            colwidth = 4;
                        }
                        else{
                            colwidth = 4;
                        }
                        header1.append(`<th style="width:${colwidth}%" rowspan="3">${col}</th>`);
                    });

                    let earningsColspan = response.hasOvertime ? response.earnings.length + response.overtimes.length + response.additionalearnings.length : response.earnings.length + response.additionalearnings.length;
                    header1.append(`<th style="width:29%" colspan="${earningsColspan}">Earnings</th>`);

                    // Deductions section
                    let dedColspan = response.deductions.length + response.staticDeduction.length;
                    header1.append(`<th style="width:27%" colspan="${dedColspan}">Deductions</th>`);

                    response.lastStaticColumns.forEach(function (col) {
                        header1.append(`<th style="width:6%" rowspan="3">${col}</th>`);
                    });

                    // 2nd row
                    if (response.hasOvertime) {
                        response.earnings.forEach(col => {
                            header2.append(`<th rowspan="2">${col.label}</th>`);
                        });

                        header2.append(`<th colspan="${response.overtimes.length}">Overtime</th>`);
                        response.additionalearnings.forEach(col => {
                            header2.append(`<th rowspan="2">${col.label}</th>`);
                        });
                        response.overtimes.forEach(ot => {
                            header3.append(`<th>${ot.label}</th>`);
                        });
                    } else {
                        response.earnings.forEach(col => {
                            header2.append(`<th rowspan="2">${col.label}</th>`);
                        });
                        response.additionalearnings.forEach(col => {
                            header2.append(`<th rowspan="2">${col.label}</th>`);
                        });
                    }

                    let groupedDeductions = {};
                    response.deductions.forEach(col => {
                        if (col.parent) {
                            if (!groupedDeductions[col.parent]) {
                                groupedDeductions[col.parent] = [];
                            }
                            groupedDeductions[col.parent].push(col);
                        } else {
                            groupedDeductions[col.label] = [col];
                        }
                    });

                    for (const [group, cols] of Object.entries(groupedDeductions)) {
                        if (cols.length > 1) {
                            header2.append(`<th colspan="${cols.length}">${group}</th>`);
                            cols.forEach(col => {
                                header3.append(`<th>${col.label}</th>`);
                            });
                        } else {
                            header2.append(`<th rowspan="2">${cols[0].label}</th>`);
                        }
                    }

                    $('.dynamicHeader').html('').append(header1, header2, header3);
                }
            });
        }

        function getEmpSalaryList(){
            var recId = $('#recId').val();
            const count = $('.tree .employeecls:checked').not('#masterCheckbox').length;
            var toMonthRange = $('#ToMonthRange').val();
            if(parseInt(count) == 0 || toMonthRange == null || toMonthRange == ""){
                $('#dynamicPayrollTable > tbody').empty();
                calculateFooter();
                return;
            }

            lateabsent = [];
            $('#dynamicPayrollTable > tbody > tr').each(function(index) {
                var empid = $(this).data('key');    
                var lateabsenthr = parseFloat($(`#lateabs_emp_${empid}`).val() || 0);
                lateabsent.push({id: empid, lateabs: lateabsenthr});
            });

            $('#dynamicPayrollTable > tbody').empty();
            calculateFooter();
            
            var emplist = "";
            var month = "";
            var checkedValues = [];
            var nonFoundIds = [];
            $('.employeecls:checked').each(function() {
                checkedValues.push($(this).val());
            });

            $.ajax({
                url: '/getPayrollColumns',
                method: 'POST',
                success: function (columns) {
                    payrollColumns = columns;
                }
            });

            $.ajax({ 
                url: '/getEmployeeSalaryList',
                type: 'POST',
                data:{
                    emplist: checkedValues,
                    month: $('#ToMonthRange').val(),
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
                    
                    data.forEach((employee, index) => {
                        var tbody = '';
                        tbody += `<tr data-key="${employee.id}" id="${employee.id}">`;

                        // Static columns (e.g. Numbering, Name, 5 extra)
                        tbody += `<td>${index + 1}</td>`;
                        tbody += `<td>${employee.name}</br>(${employee.EmployeeID})</td>`;
                        tbody += `<td>${employee.BranchName}</td>`;
                        tbody += `<td>${employee.DepartmentName}</td>`;
                        tbody += `<td>${employee.PositionName}</td>`;

                        tbody += `
                            <td id="staticTd_${i}_emp_${employee.id}">
                                <label style="font-size:10px;" id="staticLbl_${i}_emp_${employee.id}" for="static_${i}_emp_${employee.id}">${employee.WorkingDay}</label>
                                <input type="text" id="staticInp_${i}_emp_${employee.id}" name="working_day_emp_${employee.id}" value="${employee.WorkingDay}" hidden>
                            </td>
                            <td id="staticTd_${i}_emp_${employee.id}">
                                <label style="font-size:10px;" id="staticLbl_${i}_emp_${employee.id}" for="static_${i}_emp_${employee.id}">${employee.perHourSalary}</label>
                                <input type="text" id="perHourSalary_emp_${employee.id}" name="perhrsalary_emp_${employee.id}" value="${employee.perHourSalary}" hidden>
                            </td>
                            <td id="staticTd_${i}_emp_${employee.id}" style="padding: 0;">
                                <label style="font-size:10px;" id="staticLbl_${i}_emp_${employee.id}" for="static_${i}_emp_${employee.id}" hidden></label>
                                <input type="text" id="lateabshidd_emp_${employee.id}" name="static_${i}_emp_${employee.id}" value="${employee.lateabsenthr}" hidden>
                                <textarea type="number" step="any" rows="1" id="lateabs_emp_${employee.id}" name="lateabs_emp_${employee.id}" class="form-control" style="display: block; height: 100%;width: 100%;border-radius: 0;box-sizing: border-box;" onkeyup="lateabsFn(${employee.id})" onkeypress="return ValidateNum(event);" readonly @can('Payroll-Amend-LateAbsent-Hour') ondblclick="editLateAbsentValFn(${employee.id});" @endcan>${employee.lateabsenthr}</textarea>
                            </td>`;
                        
                        // Earnings
                        payrollColumns.earnings.forEach(col => {
                            var value = 0;
                            const salaryTypeId = parseInt(col.key.replace('salarytype_', ''));
                            value += employee.salaries[salaryTypeId] ?? '0';
                            
                            tbody += `
                                <td id="td_emp_${employee.id}_${col.key}">
                                    <label style="font-size:10px;" for="emp_${employee.id}_${col.key}">${parseFloat(value) > 0 ? numformat(parseFloat(value).toFixed(2)) : ''}</label>
                                    <input class="inp_${col.key}" type="text" id="emp_${employee.id}_${col.key}" name="emp_${employee.id}_${col.key}" value="${parseFloat(value).toFixed(2)}" hidden>
                                </td>`;
                        });

                        // Overtimes
                        payrollColumns.overtimes.forEach(col => {
                            var wordsToRemove = ["overtime_"];
                            var regex = new RegExp(wordsToRemove.join("|"), "g");

                            const salaryTypeId = col.key.replace(regex, '');
                            
                            const value = employee.otData[salaryTypeId] ?? '0';

                            tbody += `
                                <td id="td_emp_${employee.id}_${col.key}">
                                    <label style="font-size:10px;" for="emp_${employee.id}_${col.key}">${parseFloat(value) > 0 ? numformat(parseFloat(value).toFixed(2)) : ''}</label>
                                    <input class="inp_${col.key}" type="text" id="emp_${employee.id}_${col.key}" name="emp_${employee.id}_${col.key}" value="${parseFloat(value).toFixed(2)}" hidden>
                                </td>`;
                        });

                        // Additional Earning
                        payrollColumns.additionalearnings.forEach(col => {
                            var wordsToMatch  = ["TO1","TA1", "NT1", "DN1", "OE1"];
                            var regex = new RegExp("\\b(" + wordsToMatch.join("|") + ")\\b", "g");

                            const salaryTypeId = col.key.replace(regex, `${employee.id}$1`);
                            const value = employee.addsalaries[salaryTypeId] ?? '0';
                            tbody += `
                                <td id="td_emp_${employee.id}_${col.key}">
                                    <label style="font-size:10px;" for="emp_${employee.id}_${col.key}">${parseFloat(value) > 0 ? numformat(parseFloat(value).toFixed(2)) : ''}</label>
                                    <input class="inp_${col.key}" type="text" id="emp_${employee.id}_${col.key}" name="emp_${employee.id}_${col.key}" value="${parseFloat(value).toFixed(2)}" hidden>
                                </td>`;
                        });

                        // Deductions
                        payrollColumns.deductions.forEach(col => {
                            var othershidd = 0;
                            var wordsToRemove = ["pension_","salarytype_","other_deduction_","total_deduction_"];
                            var regex = new RegExp(wordsToRemove.join("|"), "g");

                            const salaryTypeId = col.key.replace(regex, '');
                            
                            const value = employee.deductionData[salaryTypeId] ?? '0';

                            if(salaryTypeId == 0 || salaryTypeId == 6 || salaryTypeId == "ab"){
                                othershidd = value;
                            }
                            else{
                                othershidd = 0;
                            }
                            
                            tbody += `
                                <td id="td_emp_${employee.id}_${col.key}">
                                    <input type="text" id="emp_${employee.id}_${col.key}_oth" name="other_deduction_main_${employee.id}" value="${othershidd}" hidden>
                                    <label style="font-size:10px;" id="emp_lbl_${employee.id}_${col.key}" for="emp_${employee.id}_${col.key}">${parseFloat(value) > 0 ? numformat(parseFloat(value).toFixed(2)) : ''}</label>
                                    <input class="inp_${col.key}" type="text" id="emp_${employee.id}_${col.key}" name="emp_${employee.id}_${col.key}" value="${parseFloat(value).toFixed(2)}" hidden>
                                </td>`;
                        });

                        // Static Deduction
                        payrollColumns.staticDeduction.forEach(col => {
                            var wordsToMatch  = ["OD1"];
                            var regex = new RegExp("\\b(" + wordsToMatch.join("|") + ")\\b", "g");

                            const salaryTypeId = col.key.replace(regex, `${employee.id}$1`);
                            const value = employee.addsalaries[salaryTypeId] ?? '0';
                            tbody += `
                                <td id="td_emp_${employee.id}_${col.key}">
                                    <label style="font-size:10px;" for="emp_${employee.id}_${col.key}">${parseFloat(value) > 0 ? numformat(parseFloat(value).toFixed(2)) : ''}</label>
                                    <input type="text" id="emp_${employee.id}_${col.key}" name="emp_${employee.id}_${col.key}" value="${parseFloat(value).toFixed(2)}" hidden>
                                </td>`;
                        });

                        // Net Pay
                        payrollColumns.lastStaticColumns.forEach(col => {
                            var wordsToMatch  = ["NP1"];
                            var regex = new RegExp("\\b(" + wordsToMatch.join("|") + ")\\b", "g");
                            var keyword = "NP1";
                            const salaryTypeId = keyword.replace(regex, `${employee.id}$1`);
                            const value = employee.netPayData[salaryTypeId] ?? '0';
                            var penaltyVisible = $(`#SalaryTypeHidd option[value=6]`).attr('data-is_shown_on_payroll');

                            tbody += `
                                <td id="td_emp_${employee.id}_NP">
                                    <a style="text-decoration:underline;color:blue;font-size:10px;" id="emp_lbl_${employee.id}_NP" onclick=netPayFn(${employee.id}) for="emp_${employee.id}_NP">${parseFloat(value) > 0 ? numformat(parseFloat(value).toFixed(2)) : ''}</a>
                                    <input type="text" id="emp_${employee.id}_NP_oth" name="emp_${employee.id}_NP" value="${parseFloat(value).toFixed(2)}" hidden>
                                    <input class="inp_NP" type="text" id="emp_${employee.id}_NP" name="emp_${employee.id}_NP" value="${parseFloat(value).toFixed(2)}" hidden>
                                </td>
                                <td style="display:none;">
                                    <input type="text" id="penaltyFlag_${employee.id}" value="${penaltyVisible}">
                                    <input type="text" id="lateabsent_penalty_${employee.id}" value="${employee.lateabsentpenalty}">
                                    <input type="text" id="unpaid_leave_${employee.id}" value="${employee.unpaidleave}">
                                    <input type="text" id="supposetowork_emp_${employee.id}" name="supposetoworkhr_emp_${employee.id}" value="${employee.WorkHour}" hidden>
                                    <input type="text" id="actualwork_${i}_emp_${employee.id}" name="actualworkhr_emp_${employee.id}" value="${employee.ActualWorkHour}" hidden>
                                    <input type="text" id="absent_emp_${employee.id}" name="absent_emp_${employee.id}" value="${employee.absent_hour}" hidden>
                                </td>`;
                        });

                        tbody += `</tr>`;

                        $('#payrollBody').append(tbody);
                    });

                    $.each(lateabsent, function(index, values) {
                        var lateabsenthr = parseFloat(values.lateabs || 0);
                        $(`#lateabs_emp_${values.id}`).val(parseFloat(values.lateabs || 0));
                        calculatePenalty(values.id);
                    });

                    populateFooter();
                    calculateFooter();

                    if(recId != null && globalFlg == 1){
                        getLateAbsentFn(recId);
                    }

                    $("#dynamicTableDiv").show();
                },
                error: function(xhr, status, error) {
                    console.log("Error");
                }
            });
        }

        function populateFooter() {
            let footer = `<tr>`;
            footersKey = [];
            // Merge static columns (2 fixed + 5 extra = colspan 7)
            footer += `<td colspan="8" class="text-right fw-bold">Total</td>`;

            // Earnings
            payrollColumns.earnings.forEach(col => {
                footer += `
                    <td id="footer_${col.key}">
                        <label style="font-size:11px;" class="footer_lbl_${col.key}" for="footer_${col.key}"></label>
                        <input class="footer_inp_${col.key}" type="text" id="footer_input_${col.key}" name="footer_input_${col.key}" hidden>
                    </td>`;
                
                footersKey.push(col.key);
            });

            // Overtimes
            payrollColumns.overtimes.forEach(col => {
                footer += `
                    <td id="footer_${col.key}">
                        <label style="font-size:11px;" class="footer_lbl_${col.key}" for="footer_${col.key}"></label>
                        <input class="footer_inp_${col.key}" type="text" id="footer_input_${col.key}" name="footer_input_${col.key}" hidden>
                    </td>`;

                footersKey.push(col.key);
            });

            //Additional Earnings
            payrollColumns.additionalearnings.forEach(col => {
                footer += `
                    <td id="footer_${col.key}">
                        <label style="font-size:11px;" class="footer_lbl_${col.key}" for="footer_${col.key}"></label>
                        <input class="footer_inp_${col.key}" type="text" id="footer_input_${col.key}" name="footer_input_${col.key}" hidden>
                    </td>`;
                
                footersKey.push(col.key);
            });

            // Deductions
            payrollColumns.deductions.forEach(col => {
                footer += `
                    <td id="footer_${col.key}">
                        <label style="font-size:11px;" class="footer_lbl_${col.key}" for="footer_${col.key}"></label>
                        <input class="footer_inp_${col.key}" type="text" id="footer_input_${col.key}" name="footer_input_${col.key}" hidden>
                    </td>`;
                
                footersKey.push(col.key);
            });

            // Deductions
            payrollColumns.lastStaticColumns.forEach(col => {
                footer += `
                    <td id="footer_NP">
                        <label style="font-size:11px;" class="footer_lbl_NP" for="footer_NP"></label>
                        <input class="footer_inp_NP" type="text" id="footer_input_NP" name="footer_input_NP" hidden>
                    </td>`;
                
                footersKey.push("NP");
            });

            footer += `</tr>`;

            $('.dynamicFooter').html(footer);
        }

        function lateabsFn(empid){
            var perhoursalary = $(`#perHourSalary_emp_${empid}`).val();
            var lateabshr = $(`#lateabshidd_emp_${empid}`).val();
            var lateabshractual = $(`#lateabs_emp_${empid}`).val();

            lateabshr = lateabshr == '' ? 0 : lateabshr;
            lateabshractual = lateabshractual == '' ? 0 : lateabshractual;

            $(`#lateabs_emp_${empid}`).css("background", "#FFFFFF");

            if(parseFloat(lateabshractual) > parseFloat(lateabshr)){
                $(`#lateabs_emp_${empid}`).val(lateabshr);
                //$(`#lateabs_emp_${empid}`).css("background", errorcolor);
                toastrMessage('error',`Late + Absent Minute can not be greater than <b>${lateabshr}</b>`,"Error");
            }
            calculatePenalty(empid);
            calculateFooter();
        }

        function calculatePenalty(empid){
            var perhoursalary = $(`#perHourSalary_emp_${empid}`).val();
            var lateabshr = $(`#lateabshidd_emp_${empid}`).val();
            var lateabshractual = $(`#lateabs_emp_${empid}`).val();
            var penaltyFlg = $(`#penaltyFlag_${empid}`).val();

            perhoursalary = perhoursalary == '' ? 0 : perhoursalary;
            lateabshr = lateabshr == '' ? 0 : lateabshr;
            lateabshractual = lateabshractual == '' ? 0 : lateabshractual;
            var minute_salary = parseFloat(perhoursalary / 60).toFixed(2);

            var defaultpenalty = parseFloat(minute_salary) * parseFloat(lateabshr);
            var penalty = parseFloat(minute_salary) * parseFloat(lateabshractual);
            
            if(parseInt(penaltyFlg) == 0){
                var allothers = $(`#emp_${empid}_other_deduction_0_oth`).val();
                penalty = penalty == '' ? 0 : penalty;
                defaultpenalty = defaultpenalty == '' ? 0 : defaultpenalty;
                allothers = allothers == '' ? 0 : allothers;
                var otherswopenalty = parseFloat(allothers) - parseFloat(defaultpenalty);
                var netpenalty = parseFloat(otherswopenalty) + parseFloat(penalty);
                $(`#emp_${empid}_other_deduction_0`).val(netpenalty);
                $(`#emp_lbl_${empid}_other_deduction_0`).html(parseFloat(netpenalty) > 0 ? numformat(parseFloat(netpenalty).toFixed(2)) : '0');
            }
            else if(parseInt(penaltyFlg) == 1){
                var allpenalty = $(`#emp_${empid}_salarytype_6_oth`).val();
                penalty = penalty == '' ? 0 : penalty;
                defaultpenalty = defaultpenalty == '' ? 0 : defaultpenalty;
                allpenalty = allpenalty == '' ? 0 : allpenalty;
                var otherswolateabs = parseFloat(allpenalty) - parseFloat(defaultpenalty);

                var netpenalty = parseFloat(otherswolateabs) + parseFloat(penalty);
                $(`#emp_${empid}_salarytype_6`).val(netpenalty);
                $(`#emp_lbl_${empid}_salarytype_6`).html(parseFloat(netpenalty) > 0 ? numformat(parseFloat(netpenalty).toFixed(2)) : '0');
            }

            $(`#lateabsent_penalty_${empid}`).val(penalty);
            var totaldeduction = $(`#emp_${empid}_total_deduction_ab_oth`).val();
            totaldeduction = totaldeduction == '' ? 0 : totaldeduction;
            var penaltyvar = parseFloat(defaultpenalty) - parseFloat(penalty);
            var totaldeductionupd = parseFloat(totaldeduction) - parseFloat(penaltyvar);
            $(`#emp_${empid}_total_deduction_ab`).val(totaldeductionupd);
            $(`#emp_lbl_${empid}_total_deduction_ab`).html(parseFloat(totaldeductionupd) > 0 ? numformat(parseFloat(totaldeductionupd).toFixed(2)) : '0');
        
            var taxable = $(`#emp_${empid}_TA1`).val();
            var nonTaxable = $(`#emp_${empid}_NT1`).val();

            totaldeductionupd = totaldeductionupd == '' || totaldeductionupd == undefined ? 0 : totaldeductionupd;
            taxable = taxable == '' || taxable == undefined ? 0 : taxable;
            nonTaxable = nonTaxable == '' || nonTaxable == undefined ? 0 : nonTaxable;

            var netpay = (parseFloat(taxable) - parseFloat(totaldeductionupd)) + parseFloat(nonTaxable);

            $(`#emp_${empid}_NP`).val(parseFloat(netpay).toFixed(2) > 0 ? parseFloat(netpay).toFixed(2) : '0');
            $(`#emp_lbl_${empid}_NP`).html(parseFloat(netpay) > 0 ? numformat(parseFloat(netpay).toFixed(2)) : '0');

            calculateFooter();
        }

        function calculateFooter(){
            $.each(footersKey, function(index, value) {
                var total = 0;
                $.each($('#dynamicPayrollTable').find(`.inp_${value}`), function() {
                    if (($(this).val() != '' || !isNaN($(this).val())) && $(this).val() > 0) {
                        total += parseFloat($(this).val());
                    }
                });

                $(`.footer_inp_${value}`).val(parseFloat(total).toFixed(2));
                $(`.footer_lbl_${value}`).html(parseFloat(total) > 0 ? numformat(parseFloat(total).toFixed(2)) : '');
            });
        }

        $('body').on('click', '#addpayrollreg', function() {
            $('.mainforminp').val("");
            $('.errordatalabel').html('');
            $('#selectalldiv').show();

            $('#recId').val("");
            $('.search-box').val('').trigger('input');
            $('#operationtypes').val("1");

            $('#dynamicPayrollTable > tbody').empty();
            calculateFooter();

            $('#FromMonthRange').val(null).select2({
                placeholder:"Select from pay range"
            });
            $('#ToMonthRange').val(null).select2({
                placeholder:"Select to pay range"
            });
            $('#dynamicTable > tbody').empty();
            $('#selectAll').prop('checked',false); 
            $('#Remark').val(""); 
            $('#grgStartDate').html(""); 
            $('#grgEndDate').html(""); 
            
            $('li').each(function(index, element) {
                const level = $(element).parents('ul').length;
                //if (level >= 3) {
                    $(element).addClass('collapsed').removeClass('expanded');
                //}
            });
            $('.checkbox').prop('checked', false).prop('indeterminate', false);
            updateCheckedCount();
            //$('#dynamicTableDiv').css({'height': '0rem','overflow-y':'auto','padding':'0','overflow-x':'auto'});
            $('#selectalldep').prop('checked',false);
            $('#selectalldep').prop('indeterminate',false);
            $("#modaltitle").html("Add Payroll");
            $('#totalnumemployee').html("");
            $('#statusdisplay').html("");
            $('#totalamountlbl').html("Total amount of addition for each employees");
            $('#totalamountTbl').hide();
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $('#masterCheckbox').prop('indeterminate', false);
            $('#masterCheckbox').prop('checked', false);
            $("#dynamicTableDiv").show();
            $("#inlineForm").modal('show');
        });

        function getAllEmployee(){
            $("#orgtree").empty();
            var treevals="";
            $.get("/payrolldep" , function(data) {
                treevals='<ul id="treeview" class="hummingbird-base mt-0" style="padding:0px 0px 0px 0px;">';
                $.each(data.emplist, function(key, empvalue) {
                    treevals+='<li data-id="'+empvalue.id+'" class="attremployee"><label style="font-size:12px;"><input class="hummingbird-end-node emptree attdepartment_'+empvalue.departments_id+'" id="'+empvalue.id+'-'+empvalue.departments_id+'" data-id="custom-'+empvalue.departments_id+'-'+empvalue.id+'" name="employees[]" value="'+empvalue.id+'" type="checkbox"/>    '+empvalue.name+'</label></li>';
                });
                treevals+='</ul>';
                $("#orgtree").append(treevals);
            });
            $("#orgtree").hummingbird();
        }

        function calculatePayroll() {
            var employee=$('.emptree').val();
            var numberOfChecked = $('.emptree:checked').length;
            var fromMonthRange=$('#FromMonthRange').val();
            var toMonthRange=$('#ToMonthRange').val();
            $('#dynamicTable > tbody').empty();
            $('#totalbasicsalary').html("");
            $('#totalgrossincome').html("");
            $('#totalotherearning').html("");
            $('#totalincometax').html("");
            $('#totalpension').html("");
            $('#totaltaxableincome').html("");
            $('#totalcompension').html("");
            $('#totalotherdeduction').html("");
            $('#totaldeductionamount').html("");
            $('#totalnetpay').html("");
            $('#totalnumemployee').html("");
            $('#dynamicTableDiv').css({'height': '0rem','overflow-y':'auto','padding':'0','overflow-x':'auto'});
            j=0;
            if(parseInt(numberOfChecked)>0 && fromMonthRange!=null && fromMonthRange.trim() !== '' && toMonthRange!=null && toMonthRange.trim() !== ''){
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $.ajax({
                    url: '/calcPayroll',
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
                        $.each(data.payrollcalc, function(key, value) {
                            ++i;
                            ++m;
                            j += 1;
                            $("#dynamicTable > tbody").append('<tr><td style="font-weight:bold;text-align:center;width:3%">'+j+'</td>'+
                                '<td style="width:6%;text-align:center;font-size:12px;">'+value.EmployeeID+'</td>'+
                                '<td style="width:14%;text-align:center;">'+value.name+'</td>'+
                                '<td style="width:6%;text-align:center;">'+value.WorkDay+'</td>'+
                                '<td style="width:6%;text-align:center;" id="basicsalary'+m+'"></td>'+
                                '<td style="width:8%;text-align:center;" id="otherearning'+m+'"></td>'+
                                '<td style="width:8%;text-align:center;" id="grossincome'+m+'"></td>'+
                                '<td style="width:8%;text-align:center;" id="taxableincome'+m+'"></td>'+
                                '<td style="width:6%;text-align:center;" id="incometax'+m+'"></td>'+
                                '<td style="width:5%;text-align:center;" id="pension'+m+'"></td>'+
                                '<td style="width:6%;text-align:center;" id="compension'+m+'"></td>'+
                                '<td style="width:8%;text-align:center;" id="otherdeduction'+m+'"></td>'+
                                '<td style="width:8%;text-align:center;" id="totaldeduction'+m+'"></td>'+
                                '<td style="width:8%;text-align:center;"><a id="netpay'+m+'" style="text-decoration:underline;color:blue;" onclick=netPayFn("'+value.EmpId+'")></a></td>'+
                                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="row['+m+'][employeeId]" id="employeeId'+m+'" class="employeeId form-control" readonly="true" style="font-weight:bold;" value="'+value.EmpId+'"/></td></tr>'
                            );
                        });

                        $('#dynamicTable > tbody  > tr').each(function(index, tr) { 
                            let idIndx = $(this).find('td:eq(14)').find('input').val()||0;
                            let empId = $(this).find('td:eq(15)').find('input').val()||0;
                            $.each(data.payrolldata, function(key, value) {
                                if(parseInt(value.EmployeeIdVal)==parseInt(empId)){
                                    $('#basicsalary'+idIndx).html(value.BasicSalary);
                                    $('#otherearning'+idIndx).html(value.OtherEarning);
                                    $('#grossincome'+idIndx).html(value.GrossIncome);
                                    $('#taxableincome'+idIndx).html(value.TaxableIncome);
                                    $('#incometax'+idIndx).html(value.IncomeTax);
                                    $('#pension'+idIndx).html(value.Pension);
                                    $('#compension'+idIndx).html(value.CompPension);
                                    $('#otherdeduction'+idIndx).html(value.OtherDeduction);
                                    $('#totaldeduction'+idIndx).html(value.TotalDeduction);
                                    $('#netpay'+idIndx).html(value.NetPay);
                                }
                            });
                        });

                        $.each(data.totalpayrolldata, function(key, value) {
                            $('#totalbasicsalary').html(value.AggBasicSalary);
                            $('#totalgrossincome').html(value.AggGrossIncome);
                            $('#totalotherearning').html(value.AggOtherEarning);
                            $('#totalincometax').html(value.AggIncomeTax);
                            $('#totalpension').html(value.AggPension);
                            $('#totalcompension').html(value.AggComPension);
                            $('#totaltaxableincome').html(value.AggTaxableIncome);
                            $('#totalotherdeduction').html(value.AggOtherDeduction);
                            $('#totaldeductionamount').html(value.AggTotalDeduction);
                            $('#totalnetpay').html(value.AggNetPay);
                        });
                        $('#totalnumemployee').html("Total Employee: "+numberOfChecked);

                        var tbodyHeight = $("#dynamicTable > tbody").height();
                        var tbodyHeightRem =0;

                        if(parseFloat(tbodyHeightRem)<=20){
                            tbodyHeightRem = tbodyHeight / parseFloat($("body").css("font-size"));
                        }
                        if(parseFloat(tbodyHeightRem)>20){
                            tbodyHeightRem=20;
                        }

                        $('#dynamicTableDiv').css({'height': tbodyHeightRem+'rem','overflow-y':'auto','padding':'0','overflow-x':'auto'});
                    }
                });
            }
        }

        function netPayFn(empId){
            var employeeid=null;
            var frompaymonth=null;
            var topaymonth=null;
            var a=0;
            var b=0;
            var netpay=0;
            var totaltaxable = 0;
            var totalnontaxable = 0;
            var totalearning = 0;
            var totaldeduction = 0;
            var taxrate = 0;
            var deductionamount = 0;
            var incometax = 0;
            var pensionval = 0;
            var basicsalary = 0;
            var penaltylbl = "";
            var unpaidleavelbl = 0;
            var companypension = 0;
            var taxpercent = 0;
            var deductionamnt = 0;
            var incometaxamount = 0;
            var pensionpercent = 0;
            var pensionamount = 0;
            var companypensionpercent = 0;
            var companypensionamount = 0;

            var frdate = "";
            var tdate = "";
            var rec = "";
            
            var fromdate = "";
            var todate = "";
            var recordId = $('#recInfoId').val();
            var precId = $('#recId').val();
            var status = $('#currentStatus').val();

            frdate = $('#FromMonthRange').val();
            tdate = $('#ToMonthRange').val();
            rec = "";
            fromdate = $('#grgStartDate').html();
            todate = $('#grgEndDate').html();
            $('#payslip_status').val(status);
            
            if(!isNaN(parseInt(precId))){
                frdate = $('#FromMonthRange').val();
                tdate = $('#ToMonthRange').val();
                rec = "";
                fromdate = $('#grgStartDate').html();
                todate = $('#grgEndDate').html();
            }
            if(!isNaN(parseInt(recordId))){
                frdate = $('#fromdateinfo').val();
                tdate = $('#todateinfo').val();
                rec = $('#recInfoId').val();
                fromdate = $('#from_date_fullformat').val();
                todate = $('#to_date_fullformat').val();
            }

            $("#earininginfotbl > tbody").empty();
            $("#deductioninfotbl > tbody").empty();

            $("#payslip_earning > tbody").empty();
            $("#payslip_deduction > tbody").empty();
            
            $('#payslip_btn').hide();

            var npay = $(`#emp_${empId}_NP_oth`).val();
            if(parseFloat(Math.abs(npay)) <= 0){
                toastrMessage('error',"Detail data unavailable","Error");
                return;
            }
            $.ajax({
                url: '/payrollDetail',
                type: 'POST',
                data:{
                    employeeid:empId,
                    frompaymonth:frdate,
                    topaymonth:tdate,
                    recId:rec,
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
                    $('#perhoursalaryval').val(data.perhoursalary);
                    $.each(data.empdata, function(key,value) {
                        $('#employeepdfullname').html(value.name);
                        $('#employeepdid').html(value.EmployeeID);
                        $('#branchlbl').html(`<i class="fas fa-code-branch"></i>   ${value.BranchName}`);
                        $('#departmentlbl').html(`<i class="fa-solid fa-landmark"></i>   ${value.DepartmentName}`);
                        $('#positionlbl').html(`<i class="fa-solid fa-up-down-left-right"></i>   ${value.PositionName}`);
                        $('#payrangelbl').html(`<i class="fas fa-calendar"></i>   ${fromdate} to ${todate}`);

                        $('#company_name').html(data.company_name);
                        $('#payslip_title').html(`Payslip for the period of ${data.formatted_month}`);
                        $('#payslip_period').val(data.formatted_month);
                        $('#payslip_employeeid').html(value.EmployeeID);
                        $('#payslip_hireddate').html(value.HiredDate);
                        $('#payslip_employeename').html(value.name);
                        $('#payslip_workingday').html(`${data.working_days} of ${data.daysInMonth}`);
                        $('#payslip_branch').html(value.BranchName);
                        $('#payslip_bankname').html(value.BankName);
                        $('#payslip_department').html(value.DepartmentName);
                        $('#payslip_bankaccount').html(value.BankAccountNumber);
                        $('#payslip_position').html(value.PositionName);
                        $('#payslip_pensionnumber').html(value.PensionNumber);
                        
                        if(value.ActualPicture != null || value.BiometricPicture != null){
                            $('#payrollemployeepic').attr("src",value.ActualPicture != null ? `../../../storage/uploads/HrEmployee/${value.ActualPicture}` :  `../../../storage/uploads/BioEmployee/${value.BiometricPicture}`);
                        }
                        if(value.ActualPicture == null && value.BiometricPicture == null){
                            $('#payrollemployeepic').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
                        }
                    });

                    $('#fromdatepayroll').val(fromdate);
                    $('#todatepayroll').val(todate);

                    if(isNaN(parseInt(recordId))){
                        $.each(data.salarydetdata, function(key,value) {
                            
                            if(value.SalaryType == "Earnings"){
                                ++a;
                                var salary_name = "";
                                var amount = "";
                                if(parseFloat(value.salarytypes_id) == 1){
                                    basicsalary = value.Amount;
                                    salary_name = "Actual Salary";
                                    amount = $(`#emp_${empId}_salarytype_1`).val() || 0;
                                }
                                else{
                                    salary_name = value.SalaryTypeName;
                                    amount = value.Amount;
                                }
                                $("#earininginfotbl > tbody").append(`<tr>
                                    <td style="font-weight:bold;text-align:center;width:3%">${a}</td>'+
                                    <td style="text-align:center;width: 40%;">${salary_name}</td>
                                    <td style="text-align:center;width: 19%;">${numformat(parseFloat(amount).toFixed(2))}</td>
                                    <td style="text-align:center;width: 19%;">${parseFloat(value.NonTaxable) > 0 ? numformat(parseFloat(value.NonTaxable).toFixed(2)) : ""}</td>
                                    <td style="text-align:center;width: 19%;">${parseFloat(amount + value.NonTaxable) > 0 ? numformat(parseFloat(amount + value.NonTaxable).toFixed(2)) : ""}</td>
                                </tr>`);

                                totaltaxable += parseFloat(amount);
                                totalnontaxable += parseFloat(value.NonTaxable);
                            }
                            if(value.SalaryType == "Deductions"){
                                ++b;
                                if(parseFloat(value.salarytypes_id) == 2){
                                    incometax = $(`#emp_${empId}_salarytype_2`).val() || 0;
                                    $("#deductioninfotbl > tbody").append(`<tr>
                                        <td style="font-weight:bold;text-align:center;width:3%">${b}</td>'+
                                        <td style="text-align:center;width: 50%;" id="incometaxlbl"></td>
                                        <td style="text-align:center;width: 47%;">
                                            <div class="input-group">
                                                <label style="font-size:1rem;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">${numformat(parseFloat(incometax).toFixed(2))}</label>
                                                <i id="incometaxinfoicon" class="fas fa-info-circle" style="width:1%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                            </div>
                                        </td>
                                    </tr>`);

                                    totaldeduction += parseFloat(incometax);
                                }
                                if(parseFloat(value.salarytypes_id) == 3){
                                    pensionval = $(`#emp_${empId}_pension_3`).val() || 0;
                                    $("#deductioninfotbl > tbody").append(`<tr>
                                        <td style="font-weight:bold;text-align:center;width:3%">${b}</td>'+
                                        <td style="text-align:center;width: 50%;">Pension (${data.pension}%)</td>
                                        <td style="text-align:center;width: 47%;">
                                            <div class="input-group">
                                                <label style="font-size:1rem;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">${numformat(parseFloat(pensionval).toFixed(2))}</label>
                                                <i id="pensioninfoicon" class="fas fa-info-circle" style="width:1%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                            </div>
                                        </td>
                                    </tr>`);

                                    totaldeduction += parseFloat(pensionval);
                                }
                                if(parseFloat(value.salarytypes_id) > 5){
                                    $("#deductioninfotbl > tbody").append(`<tr>
                                        <td style="font-weight:bold;text-align:center;width:3%">${b}</td>'+
                                        <td style="text-align:center;width: 50%;">${value.SalaryTypeName}</td>
                                        <td style="text-align:center;width: 47%;">
                                            ${numformat(parseFloat(value.Amount).toFixed(2))}
                                        </td>
                                    </tr>`);

                                    totaldeduction += parseFloat(value.Amount);
                                }
                            }
                        });

                        if(parseFloat(data.otamount) > 0){
                            ++a;
                            var ot_amount = $(`#emp_${empId}_total_overtime`).val() || 0;
                            $("#earininginfotbl > tbody").append(`<tr>
                                <td style="font-weight:bold;text-align:center;width:3%">${a}</td>'+
                                <td style="text-align:center;width: 40%;"><a style="text-decoration:underline;color:blue;" onclick=otDetailFn(${empId})>Overtime</a></td>
                                <td style="text-align:center;width: 19%;">${numformat(parseFloat(ot_amount).toFixed(2))}</td>
                                <td style="text-align:center;width: 19%;"></td>
                                <td style="text-align:center;width: 19%;">${numformat(parseFloat(ot_amount).toFixed(2))}</td>
                            </tr>`);

                            totaltaxable += parseFloat(ot_amount);
                        }

                        $.each(data.payrolladditionded, function(key,value) {
                            if(value.type == 1){
                                ++a;
                                $("#earininginfotbl > tbody").append(`<tr>
                                    <td style="font-weight:bold;text-align:center;width:3%">${a}</td>'+
                                    <td style="text-align:center;width: 40%;">${value.SalaryTypeName} <a style="text-decoration:underline;color:blue;" onclick=payrollAddDedInfoFn(${value.id})><i>(${value.DocumentNumber})</i></a></td>
                                    <td style="text-align:center;width: 19%;">${numformat(parseFloat(value.Amount).toFixed(2))}</td>
                                    <td style="text-align:center;width: 19%;"></td>
                                    <td style="text-align:center;width: 19%;">${numformat(parseFloat(value.Amount).toFixed(2))}</td>
                                </tr>`);

                                totaltaxable += parseFloat(value.Amount);
                            }
                            if(value.type == 2){
                                ++b;
                                $("#deductioninfotbl > tbody").append(`<tr>
                                    <td style="font-weight:bold;text-align:center;width:3%">${b}</td>'+
                                    <td style="text-align:center;width: 50%;">${value.SalaryTypeName} <a style="text-decoration:underline;color:blue;" onclick=payrollAddDedInfoFn(${value.id})><i>(${value.DocumentNumber})</i></a></td>
                                    <td style="text-align:center;width: 47%;">
                                        ${numformat(parseFloat(value.Amount).toFixed(2))}
                                    </td>
                                </tr>`);

                                totaldeduction += parseFloat(value.Amount);
                            }
                        });

                        var lateabsentpen = $(`#lateabsent_penalty_${empId}`).val() || 0;

                        if(parseFloat(lateabsentpen) > 0){
                            ++b;
                            $("#deductioninfotbl > tbody").append(`<tr>
                                <td style="font-weight:bold;text-align:center;width:3%">${b}</td>'+
                                <td style="text-align:center;width: 50%;">Late Minute</td>
                                <td style="text-align:center;width: 47%;">
                                    ${numformat(parseFloat(lateabsentpen).toFixed(2))}
                                </td>
                            </tr>`);

                            totaldeduction += parseFloat(lateabsentpen);
                        }

                        var unpaidleave = $(`#unpaid_leave_${empId}`).val() || 0;

                        if(parseFloat(unpaidleave) > 0){
                            ++b;
                            $("#deductioninfotbl > tbody").append(`<tr>
                                <td style="font-weight:bold;text-align:center;width:3%">${b}</td>'+
                                <td style="text-align:center;width: 50%;">Unpaid Leave</td>
                                <td style="text-align:center;width: 47%;">
                                    ${numformat(parseFloat(unpaidleave).toFixed(2))}
                                </td>
                            </tr>`);

                            totaldeduction += parseFloat(unpaidleave);
                        }

                        if (!isNaN(totaltaxable)) {
                            $.each(taxRanges, function(i, range) {
                                if (parseFloat(totaltaxable) >= parseFloat(range.min) && parseFloat(totaltaxable) <= parseFloat(range.max)) {
                                    taxrate = range.tax;
                                    deductionamount = range.deduction;
                                    return false; // break loop
                                }
                            });
                        }
                        var taxpercent = parseFloat(taxrate / 100).toFixed(2);
                        $('#incometaxlbl').html(`Income Tax (${taxrate}%)`);
                        $('#incometaxinfoicon').attr('title', `Taxable Earning: ${numformat(parseFloat(totaltaxable).toFixed(2))}\nTax Percent: ${taxrate}% \nDeduction: ${numformat(parseFloat(deductionamount).toFixed(2))}\n----------------------------------------\n(Taxable Earning * Tax Percent) - Deduction = Income Tax\n(${numformat(parseFloat(totaltaxable).toFixed(2))} * ${taxpercent}%) - ${numformat(parseFloat(deductionamount).toFixed(2))} = ${numformat(parseFloat(incometax).toFixed(2))}`);
                        $('#pensioninfoicon').attr('title', `Pension Percent: ${data.pension}% \nBasic Salary: ${numformat(parseFloat(basicsalary).toFixed(2))}\n----------------------------------------\nBasic Salary * Pension Percent = Pension\n${numformat(parseFloat(basicsalary).toFixed(2))} * ${parseFloat(data.pension / 100).toFixed(2)} = ${numformat(parseFloat(pensionval).toFixed(2))}`);
                        totalearning = parseFloat(totaltaxable) + parseFloat(totalnontaxable);
                        $('#companypensionlbl').html(`Company Pension (${data.companyPension}%)`);

                        $('#totaltaxable').html(numformat(parseFloat(totaltaxable).toFixed(2)));
                        $('#nontotaltaxable').html(numformat(parseFloat(totalnontaxable).toFixed(2)));
                        $('#totalinfoearaning').html(numformat(parseFloat(totalearning).toFixed(2)));
                        $('#totalinfodeduction').html(numformat(parseFloat(totaldeduction).toFixed(2)));

                        companypension = $(`#emp_${empId}_pension_4`).val() || 0;
                        var netpay = (parseFloat(totaltaxable) - parseFloat(totaldeduction)) + parseFloat(totalnontaxable);
                        $('#basicsalaryinfolbl').html(numformat(parseFloat(basicsalary).toFixed(2)));
                        $('#companypensionval').html(numformat(parseFloat(companypension).toFixed(2)));
                        $('#taxablearningval').html(numformat(parseFloat(totaltaxable).toFixed(2)));
                        $('#nontaxablearningval').html(numformat(parseFloat(totalnontaxable).toFixed(2)));
                        $('#totalearningval').html(numformat(parseFloat(totalearning).toFixed(2)));
                        $('#totaldeductionval').html(numformat(parseFloat(totaldeduction).toFixed(2)));
                        $('#netpayval').html(numformat(parseFloat(netpay).toFixed(2)));

                        $('#companypensioninfo').attr('title', `Pension Percent: ${data.companyPension}% \nBasic Salary: ${numformat(parseFloat(basicsalary).toFixed(2))}\n----------------------------------------\nBasic Salary * Pension Percent = Company Pension\n${numformat(parseFloat(basicsalary).toFixed(2))} * ${parseFloat(data.companyPension / 100).toFixed(2)} = ${numformat(parseFloat(companypension).toFixed(2))}`);
                        $('#infonetpayinfo').attr('title', `(Taxable Earning - Total Deduction) + Total Non-Taxable = Net Pay\n(${numformat(parseFloat(totaltaxable).toFixed(2))} - ${numformat(parseFloat(totaldeduction).toFixed(2))}) + ${numformat(parseFloat(totalnontaxable).toFixed(2))} = ${numformat(parseFloat(netpay).toFixed(2))}`);
                    }
                    
                    if(!isNaN(parseInt(recordId))){
                        $.each(data.payrollsalarydata, function(key,value) { 
                            if(parseFloat(value.earning_amount) > 0 || parseFloat(value.earning_amount) > 0){
                                ++a;
                                var salary_name = "";
                                var salary_name_export = "";
                                var earning_amount = 0;
                                if(parseInt(value.payrolladditions_id) > 0){
                                    salary_name = `${value.SalaryTypeName} <a style="text-decoration:underline;color:blue;" onclick=payrollAddDedInfoFn(${value.payrolladditions_id})><i>(${value.DocumentNumber})</i></a>`;
                                    salary_name_export = `${value.SalaryTypeName} (${value.DocumentNumber})`;
                                }
                                else if(value.salarytypes_id == 1){
                                    basicsalary = value.earning_amount;
                                    salary_name = "Actual Salary";
                                    salary_name_export = "Actual Salary";
                                    earning_amount = value.earning_amount;
                                }
                                else if(value.salarytypes_id == 5){
                                    salary_name = `<a style="text-decoration:underline;color:blue;" onclick=otDetailFn(${value.employees_id})>Overtime</a>`;
                                    salary_name_export = value.SalaryTypeName;
                                    earning_amount = value.earning_amount;
                                }
                                else{
                                    salary_name = value.SalaryTypeName;
                                    salary_name_export = value.SalaryTypeName;
                                }
                                $("#earininginfotbl > tbody").append(`<tr>
                                    <td style="font-weight:bold;text-align:center;width:3%">${a}</td>'+
                                    <td style="text-align:center;width: 40%;">${salary_name}</td>
                                    <td style="text-align:center;width: 19%;">${numformat(parseFloat(value.earning_amount).toFixed(2))}</td>
                                    <td style="text-align:center;width: 19%;">${parseFloat(value.non_taxable) > 0 ? numformat(parseFloat(value.non_taxable).toFixed(2)) : ""}</td>
                                    <td style="text-align:center;width: 19%;">${parseFloat(value.earning_amount + value.non_taxable) > 0 ? numformat(parseFloat(value.earning_amount + value.non_taxable).toFixed(2)) : ""}</td>
                                </tr>`);

                                $("#payslip_earning > tbody").append(`<tr>
                                    <td style="text-align:center;width:3%">${a}</td>'+
                                    <td style="text-align:center;width: 40%;">${salary_name_export}</td>
                                    <td style="text-align:center;width: 19%;">${numformat(parseFloat(value.earning_amount).toFixed(2))}</td>
                                    <td style="text-align:center;width: 19%;">${parseFloat(value.non_taxable) > 0 ? numformat(parseFloat(value.non_taxable).toFixed(2)) : ""}</td>
                                    <td style="text-align:center;width: 19%;">${parseFloat(value.earning_amount + value.non_taxable) > 0 ? numformat(parseFloat(value.earning_amount + value.non_taxable).toFixed(2)) : ""}</td>
                                </tr>`);

                                totaltaxable += parseFloat(value.earning_amount);
                                totalnontaxable += parseFloat(value.non_taxable);
                                totalearning = parseFloat(totaltaxable) + parseFloat(totalnontaxable);
                            }

                            if(parseFloat(value.deduction_amount) > 0 && parseInt(value.salarytypes_id) != 4){
                                ++b;
                                var salary_name = "";
                                var salary_name_export = "";
                                var deduction_amount = "";
                                if(parseInt(value.payrolladditions_id) > 0){
                                    salary_name = `${value.SalaryTypeName} <a style="text-decoration:underline;color:blue;" onclick=payrollAddDedInfoFn(${value.payrolladditions_id})><i>(${value.DocumentNumber})</i></a>`;
                                    salary_name_export = `${value.SalaryTypeName} (${value.DocumentNumber})`;
                                    deduction_amount = numformat(parseFloat(value.deduction_amount).toFixed(2));
                                }
                                else if(parseInt(value.salarytypes_id) == 2){
                                    taxpercent = value.percent;
                                    deductionamnt = value.tax_deduction;
                                    incometaxamount = value.deduction_amount;
                                    salary_name = `${value.SalaryTypeName} (${value.percent}%)`;
                                    salary_name_export = `${value.SalaryTypeName} (${value.percent}%)`;

                                    deduction_amount = `
                                        <div class="input-group">
                                            <label style="font-size:1rem;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">${numformat(parseFloat(value.deduction_amount).toFixed(2))}</label>
                                            <i id="incometaxinfoicon" class="fas fa-info-circle" style="width:1%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                        </div>`;
                                    
                                }
                                else if(parseInt(value.salarytypes_id) == 3){
                                    salary_name = `${value.SalaryTypeName} (${value.percent}%)`;
                                    salary_name_export = `${value.SalaryTypeName} (${value.percent}%)`;
                                    pensionpercent = value.percent;
                                    pensionamount = value.deduction_amount;
                                    deduction_amount = `
                                        <div class="input-group">
                                            <label style="font-size:1rem;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">${numformat(parseFloat(value.deduction_amount).toFixed(2))}</label>
                                            <i id="pensioninfoicon" class="fas fa-info-circle" style="width:1%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                        </div>`;
                                }
                                else{
                                    salary_name = value.SalaryTypeName;
                                    salary_name_export = value.SalaryTypeName;
                                    deduction_amount = numformat(parseFloat(value.deduction_amount).toFixed(2));
                                }

                                $("#deductioninfotbl > tbody").append(`<tr>
                                    <td style="font-weight:bold;text-align:center;width:3%">${b}</td>'+
                                    <td style="text-align:center;width: 50%;">${salary_name}</td>
                                    <td style="text-align:center;width: 47%;">
                                        ${deduction_amount}
                                    </td>
                                </tr>`);

                                $("#payslip_deduction > tbody").append(`<tr>
                                    <td style="text-align:center;width:3%">${b}</td>'+
                                    <td style="text-align:center;width: 50%;">${salary_name_export}</td>
                                    <td style="text-align:center;width: 47%;">${numformat(parseFloat(value.deduction_amount).toFixed(2))}</td>
                                </tr>`);

                                totaldeduction += parseFloat(value.deduction_amount);
                            }
                            
                            if(parseInt(value.salarytypes_id) == 4){
                                $('#companypensionlbl').html(`Company Pension (${value.percent}%)`);
                                $('#companypensionval').html(numformat(parseFloat(value.deduction_amount).toFixed(2)));
                                companypensionpercent = value.percent;
                                companypensionamount = value.deduction_amount;
                            }
                        });

                        $('#totaltaxable').html(numformat(parseFloat(totaltaxable).toFixed(2)));
                        $('#nontotaltaxable').html(numformat(parseFloat(totalnontaxable).toFixed(2)));
                        $('#totalinfoearaning').html(numformat(parseFloat(totalearning).toFixed(2)));
                        $('#totalinfodeduction').html(numformat(parseFloat(totaldeduction).toFixed(2)));

                        $('#payslip_totaltaxable').html(numformat(parseFloat(totaltaxable).toFixed(2)));
                        $('#payslip_nontotaltaxable').html(numformat(parseFloat(totalnontaxable).toFixed(2)));
                        $('#payslip_totalinfoearaning').html(numformat(parseFloat(totalearning).toFixed(2)));
                        $('#payslip_totalinfodeduction').html(numformat(parseFloat(totaldeduction).toFixed(2)));

                        var netpay = (parseFloat(totaltaxable) - parseFloat(totaldeduction)) + parseFloat(totalnontaxable);
                        $('#taxablearningval').html(numformat(parseFloat(totaltaxable).toFixed(2)));
                        $('#nontaxablearningval').html(numformat(parseFloat(totalnontaxable).toFixed(2)));
                        $('#totalearningval').html(numformat(parseFloat(totalearning).toFixed(2)));
                        $('#totaldeductionval').html(numformat(parseFloat(totaldeduction).toFixed(2)));
                        $('#netpayval').html(numformat(parseFloat(netpay).toFixed(2)));

                        $('#payslip_netpay').html(`Net Pay: ${numformat(parseFloat(netpay).toFixed(2))} (${data.amount_in_word})`);
                        $('#basicsalaryinfolbl').html(numformat(parseFloat(data.basic_salary).toFixed(2)));
                        $('#incometaxinfoicon').attr('title', `Taxable Earning: ${numformat(parseFloat(totaltaxable).toFixed(2))}\nTax Percent: ${taxpercent}% \nDeduction: ${numformat(parseFloat(deductionamnt).toFixed(2))}\n----------------------------------------\n(Taxable Earning * Tax Percent) - Deduction = Income Tax\n(${numformat(parseFloat(totaltaxable).toFixed(2))} * ${taxpercent}%) - ${numformat(parseFloat(deductionamnt).toFixed(2))} = ${numformat(parseFloat(incometaxamount).toFixed(2))}`);
                        $('#pensioninfoicon').attr('title', `Pension Percent: ${pensionpercent}% \nBasic Salary: ${numformat(parseFloat(basicsalary).toFixed(2))}\n----------------------------------------\nBasic Salary * Pension Percent = Pension\n${numformat(parseFloat(basicsalary).toFixed(2))} * ${parseFloat(pensionpercent)}% = ${numformat(parseFloat(pensionamount).toFixed(2))}`);
                        $('#companypensioninfo').attr('title', `Pension Percent: ${companypensionpercent}% \nBasic Salary: ${numformat(parseFloat(basicsalary).toFixed(2))}\n----------------------------------------\nBasic Salary * Pension Percent = Company Pension\n${numformat(parseFloat(basicsalary).toFixed(2))} * ${parseFloat(companypensionpercent)}% = ${numformat(parseFloat(companypensionamount).toFixed(2))}`);
                        $('#infonetpayinfo').attr('title', `(Taxable Earning - Total Deduction) + Total Non-Taxable = Net Pay\n(${numformat(parseFloat(totaltaxable).toFixed(2))} - ${numformat(parseFloat(totaldeduction).toFixed(2))}) + ${numformat(parseFloat(totalnontaxable).toFixed(2))} = ${numformat(parseFloat(netpay).toFixed(2))}`);
                        $('#payslip_btn').show();
                    }
                }
            })
            .done(function (response) {})
            .then(function () {
                cardSection.block({
                    message: '',
                    timeout: 1,
                    css: {
                        backgroundColor: '',
                        color: '',
                        border: ''
                    }
                });
            });

            $("#detailPayrollModal").modal('show');
        }

        $('#payslip_exportpdf').on('click', function () {
            const element = document.getElementById('payslip_table');
            let empname = $('#payslip_employeename').html();
            let period = $('#payslip_period').val();
            let status = $('#payslip_status').val();
            let color = "";
            
            if(status == "Void"){
                color = "#ea5455";
            }
            else{
                color = "#D3D3D3";
            }
            $('#pdfLoading').show();
            setTimeout(() => {
                html2pdf().set({
                    margin: 2,
                    filename: `Payslip_for_${empname}_${period}.pdf`,
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: { 
                        scale: 4, 
                        useCORS: true,
                    },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
                })
                .from(element)
                .toPdf()
                .get('pdf')
                .then(function (pdf) {
                    const totalPages = pdf.internal.getNumberOfPages();

                    for (let i = 1; i <= totalPages; i++) {
                        pdf.setPage(i);

                        pdf.saveGraphicsState(); 
                        pdf.setGState(new pdf.GState({ opacity: 0.4 })); 

                        //pdf.setTextColor(200);
                        pdf.setTextColor(color); 
                        pdf.setFontSize(100);
                        pdf.setFont('helvetica', 'bold');

                        pdf.text("", 
                            pdf.internal.pageSize.getWidth() / 2,
                            pdf.internal.pageSize.getHeight() / 1.5, {
                                angle: 45,
                                align: 'center'
                            }
                        );

                        pdf.restoreGraphicsState(); 
                    }
                })
                .save();
                $('#pdfLoading').hide();
            }, 2000);
        });

        $('#payslip_printtable').on('click', function () {
            const element = document.getElementById('payslip_table');
            let empname = $('#payslip_employeename').html();
            let period = $('#payslip_period').val();
            let status = $('#payslip_status').val();
            let color = "";

            if(status == "Void"){
                color = "#ea5455";
            }
            else{
                color = "#D3D3D3";
            }
            $('#pdfLoading').show();
            setTimeout(() => {
                html2pdf().set({
                    margin: 2,
                    filename: `payslip_for_${empname}_${period}.pdf`,
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: { 
                        scale: 4, 
                        useCORS: true, 
                    },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
                })
                .from(element)
                .toPdf()
                .get('pdf')
                .then(function (pdf) {
                    const totalPages = pdf.internal.getNumberOfPages();

                    for (let i = 1; i <= totalPages; i++) {
                        pdf.setPage(i);

                        pdf.saveGraphicsState(); 
                        pdf.setGState(new pdf.GState({ opacity: 0.4 })); 

                        pdf.setTextColor(color); 
                        pdf.setFontSize(100);
                        pdf.setFont('helvetica', 'bold');

                        pdf.text("", 
                            pdf.internal.pageSize.getWidth() / 2,
                            pdf.internal.pageSize.getHeight() / 1.5, {
                                angle: 45,
                                align: 'center'
                            }
                        );

                        pdf.restoreGraphicsState(); 
                    }

                    const pdfBlob = pdf.output('blob');
                    const blobUrl = URL.createObjectURL(pdfBlob);
                    const popup = window.open('', `Payslip_for_${empname}_${period}`, 'width=1400,height=800');
                    if (popup) {
                        popup.document.write(`
                            <html>
                                <head><title>Print</title></head>
                                <body style="margin:0">
                                    <embed width="100%" height="100%" src="${blobUrl}" type="application/pdf" />
                                </body>
                            </html>
                        `);
                        popup.document.close();

                        // Wait a bit before autoPrint
                        setTimeout(() => popup.print(), 500);
                    } else {
                        toastrMessage('error', "Popup blocked. Please allow popups for this site.", "Error");
                        $('#pdfLoading').hide();
                    }
                });
                $('#pdfLoading').hide();
            }, 2000);
        });

        document.getElementById('payslip_exporttoexcel').addEventListener('click', function () {
            let empname = $('#payslip_employeename').html();
            let period = $('#payslip_period').val();
            const workbook = new ExcelJS.Workbook();
            const sheet = workbook.addWorksheet(period);

            let row = 1;
            var numofearning = 3;
            var earning_cnt = 0;
            var deduction_cnt = 0;

            // Title rows
            sheet.mergeCells(`A${row}:I${row}`);
            sheet.getCell(`A${row}`).value = $('#company_name').html();
            sheet.getCell(`A${row}`).alignment = { vertical: 'middle', horizontal: 'center' };
            sheet.getCell(`A${row}`).font = { size: 22, bold: true };
            sheet.getCell(`A${row}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };
            sheet.getColumn(1).width  = 5;
            sheet.getColumn(2).width  = 30;
            sheet.getColumn(3).width  = 15;
            sheet.getColumn(4).width  = 20;
            sheet.getColumn(5).width  = 20;
            sheet.getColumn(8).width  = 30;
            sheet.getColumn(9).width  = 20;
            row++;

            sheet.mergeCells(`A${row}:I${row}`);
            sheet.getCell(`A${row}`).value = $('#payslip_title').html();
            sheet.getCell(`A${row}`).alignment = { vertical: 'middle', horizontal: 'center' };
            sheet.getCell(`A${row}`).font = { size: 16, bold: true };
            sheet.getCell(`A${row}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };
            row++;

        
            sheet.mergeCells(`A${row}:I${row}`);
            sheet.getCell(`A${row}`).border = {
                top: { style: 'thin' },
                bottom: { style: 'thin' },
            };
            row++; // empty row for line

            // Employee Info Table
            sheet.mergeCells(`A${row}:B${row}`);
            sheet.getCell(`A${row}`).value = "Employee ID";
            sheet.mergeCells(`C${row}:D${row}`);
            sheet.getCell(`C${row}`).value = $('#payslip_employeeid').html();
            sheet.mergeCells(`F${row}:G${row}`);
            sheet.getCell(`F${row}`).value = "Hired Date";
            sheet.mergeCells(`H${row}:I${row}`);
            sheet.getCell(`H${row}`).value = $('#payslip_hireddate').html();
            row++;

            sheet.mergeCells(`A${row}:B${row}`);
            sheet.getCell(`A${row}`).value = "Employee Name";
            sheet.mergeCells(`C${row}:D${row}`);
            sheet.getCell(`C${row}`).value = $('#payslip_employeename').html();
            sheet.mergeCells(`F${row}:G${row}`);
            sheet.getCell(`F${row}`).value = "Working Day";
            sheet.mergeCells(`H${row}:I${row}`);
            sheet.getCell(`H${row}`).value = $('#payslip_workingday').html();
            row++;

            sheet.mergeCells(`A${row}:B${row}`);
            sheet.getCell(`A${row}`).value = "Branch";
            sheet.mergeCells(`C${row}:D${row}`);
            sheet.getCell(`C${row}`).value = $('#payslip_branch').html();
            sheet.mergeCells(`F${row}:G${row}`);
            sheet.getCell(`F${row}`).value = "Bank Name";
            sheet.mergeCells(`H${row}:I${row}`);
            sheet.getCell(`H${row}`).value = $('#payslip_bankname').html();
            row++;

            sheet.mergeCells(`A${row}:B${row}`);
            sheet.getCell(`A${row}`).value = "Department";
            sheet.mergeCells(`C${row}:D${row}`);
            sheet.getCell(`C${row}`).value = $('#payslip_department').html();
            sheet.mergeCells(`F${row}:G${row}`);
            sheet.getCell(`F${row}`).value = "Bank Account";
            sheet.mergeCells(`H${row}:I${row}`);
            sheet.getCell(`H${row}`).value = $('#payslip_bankaccount').html();
            row++;

            sheet.mergeCells(`A${row}:B${row}`);
            sheet.getCell(`A${row}`).value = "Position";
            sheet.mergeCells(`C${row}:D${row}`);
            sheet.getCell(`C${row}`).value = $('#payslip_position').html();
            sheet.mergeCells(`F${row}:G${row}`);
            sheet.getCell(`F${row}`).value = "Pension Number";
            sheet.mergeCells(`H${row}:I${row}`);
            sheet.getCell(`H${row}`).value = $('#payslip_pensionnumber').html();
            row++;
            
            sheet.mergeCells(`A${row}:I${row}`);
            sheet.getCell(`A${row}`).border = {
                top: { style: 'thin' },
                bottom: { style: 'thin' },
            };
            row++;
            
            for (let i = 4; i <= 8; i++) { 
                sheet.getCell(`A${i}`).border = {
                    left: { style: 'thin' },
                };
                sheet.getCell(`F${i}`).border = {
                    left: { style: 'thin' },
                };
                sheet.getCell(`I${i}`).border = {
                    right: { style: 'thin' },
                };
            }
            // Earnings Table
            sheet.mergeCells(`A${row}:E${row}`);
            sheet.getCell(`A${row}`).value = "Earnings";
            sheet.getCell(`A${row}`).alignment = { vertical: 'middle', horizontal: 'center' };
            sheet.getCell(`A${row}`).font = { size: 13, bold: true };
            sheet.getCell(`A${row}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };
            row++;

            sheet.getRow(row).values = ["#", "Salary Component Name", "Taxable", "Non-Taxable", "Total"];
            for (let i = 65; i <= 69; i++) { 
                let letter = String.fromCharCode(i);
                sheet.getCell(`${letter}${row}`).border = {
                    top: { style: 'thin' },
                    left: { style: 'thin' },
                    bottom: { style: 'thin' },
                    right: { style: 'thin' },
                };
                sheet.getCell(`${letter}${row}`).font = {size: 12, bold: true };
            }
            row++;

            $('#payslip_earning tbody tr').each(function(index) {
                ++numofearning;
                ++earning_cnt;
                sheet.getRow(row).values = [$(this).find('td:eq(0)').html(), $(this).find('td:eq(1)').html(), $(this).find('td:eq(2)').html(), $(this).find('td:eq(3)').html(), $(this).find('td:eq(4)').html()];
                for (let i = 65; i <= 69; i++) { 
                    let letter = String.fromCharCode(i);
                    sheet.getCell(`${letter}${row}`).border = {
                        top: { style: 'thin' },
                        left: { style: 'thin' },
                        bottom: { style: 'thin' },
                        right: { style: 'thin' },
                    };
                }
                row++;
            });

            sheet.mergeCells(`A${row}:B${row}`);
            sheet.getCell(`A${row}`).value = "Total";
            sheet.getCell(`A${row}`).alignment = { vertical: 'middle', horizontal: 'right' };
            sheet.getCell(`A${row}`).font = { size: 12, bold: true };
            sheet.getCell(`A${row}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };
            sheet.getCell(`C${row}`).value = $('#payslip_totaltaxable').html();
            sheet.getCell(`D${row}`).value = $('#payslip_nontotaltaxable').html();
            sheet.getCell(`E${row}`).value = $('#payslip_totalinfoearaning').html();
            sheet.getCell(`C${row}`).font = { size: 12, bold: true };
            sheet.getCell(`C${row}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };
            sheet.getCell(`D${row}`).font = { size: 12, bold: true };
            sheet.getCell(`D${row}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };
            sheet.getCell(`E${row}`).font = { size: 12, bold: true };
            sheet.getCell(`E${row}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };
            row++;

            // Deductions Table
            sheet.mergeCells(`G${row - numofearning}:I${row - numofearning}`);
            sheet.getCell(`G${row - numofearning}`).value = "Deductions";
            sheet.getCell(`G${row - numofearning}`).alignment = { vertical: 'middle', horizontal: 'center' };
            sheet.getCell(`G${row - numofearning}`).font = { size: 13, bold: true };
            sheet.getCell(`G${row - numofearning}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };
            row++;

            sheet.getRow(row - numofearning).getCell(7).value = "#";
            sheet.getRow(row - numofearning).getCell(8).value = "Salary Component Name";
            sheet.getRow(row - numofearning).getCell(9).value = "Amount";
            for (let i = 71; i <= 73; i++) { 
                let letter = String.fromCharCode(i);
                sheet.getCell(`${letter}${row - numofearning}`).border = {
                    top: { style: 'thin' },
                    left: { style: 'thin' },
                    bottom: { style: 'thin' },
                    right: { style: 'thin' },
                };
                sheet.getCell(`${letter}${row - numofearning}`).font = { size: 12, bold: true };
            }
            row++;

            $('#payslip_deduction tbody tr').each(function(index) {
                ++deduction_cnt;
                sheet.getRow(row - numofearning).getCell(7).value = $(this).find('td:eq(0)').html();
                sheet.getRow(row - numofearning).getCell(8).value = $(this).find('td:eq(1)').html();
                sheet.getRow(row - numofearning).getCell(9).value = $(this).find('td:eq(2)').html();
                for (let i = 71; i <= 73; i++) { 
                    let letter = String.fromCharCode(i);
                    sheet.getCell(`${letter}${row - numofearning}`).border = {
                        top: { style: 'thin' },
                        left: { style: 'thin' },
                        bottom: { style: 'thin' },
                        right: { style: 'thin' },
                    };
                }
                row++;
            });

            sheet.mergeCells(`G${row - numofearning}:H${row - numofearning}`);
            sheet.getCell(`G${row - numofearning}`).value = "Total";
            sheet.getCell(`G${row - numofearning}`).alignment = { vertical: 'middle', horizontal: 'right' };
            sheet.getCell(`G${row - numofearning}`).font = { size: 12, bold: true };
            sheet.getCell(`G${row - numofearning}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };
            sheet.getCell(`I${row - numofearning}`).value = $('#payslip_totalinfodeduction').html();
            sheet.getCell(`I${row - numofearning}`).font = { size: 12, bold: true };
            sheet.getCell(`I${row - numofearning}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };

            let max_row = earning_cnt > deduction_cnt ? earning_cnt : deduction_cnt;
            let row_gap = parseInt(max_row) + 13;
            sheet.mergeCells(`A${row_gap}:I${row_gap}`);
            row_gap++;
            sheet.mergeCells(`A${row_gap}:I${row_gap}`);
            sheet.getCell(`A${row_gap}`).value = $('#payslip_netpay').html();
            sheet.getCell(`A${row_gap}`).alignment = { vertical: 'middle', horizontal: 'center' };
            sheet.getCell(`A${row_gap}`).font = { size: 13, bold: true };
            sheet.getCell(`A${row_gap}`).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' },
            };

            row_gap += 3
            sheet.mergeCells(`A${row_gap}:B${row_gap}`);
            sheet.getCell(`A${row_gap}`).value = "____________________________\nEmployer's Signature";
            sheet.getCell(`A${row_gap}`).alignment = { vertical: 'bottom', horizontal: 'left',wrapText: true };
            sheet.mergeCells(`H${row_gap}:I${row_gap}`);
            sheet.getCell(`H${row_gap}`).value = "____________________________\nEmployee's Signature";
            sheet.getCell(`H${row_gap}`).alignment = { vertical: 'bottom', horizontal: 'right',wrapText: true };
            sheet.getRow(row_gap).height = 50;

            // Save file
            workbook.xlsx.writeBuffer().then(function (buffer) {
                const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = `Payslip_for_${empname}_${period}.xlsx`;
                link.click();
            });
        });

        $(document).on('click', '#payroll_exporttoexcel', function () {
            let company_name = $('#company_name_val').val();
            let period = $('#pay_period').val();
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet(period);

            const table = document.getElementById('infoPayrollTable');
            const thead = table.querySelector('thead');
            const tbody = table.querySelector('tbody');
            const tfoot = table.querySelector('tfoot');

            const colTracker = [];
            const columnWidths = [];

            // Step 1: Add Title & Subtitle at Row 1 and 2
            const subtitle = `Generated on ${new Date().toLocaleDateString()}`;

            // Determine total column count from last <thead> row
            let totalCols = 0;
            $('#infoPayrollTable thead tr:first th').each(function () {
                const colspan = parseInt($(this).attr('colspan')) || 1;
                totalCols += colspan;
            });

            worksheet.mergeCells(1, 1, 1, totalCols);
            worksheet.getCell(1, 1).value = company_name;
            worksheet.getCell(1, 1).font = { size: 18, bold: true };
            worksheet.getCell(1, 1).alignment = {vertical: 'middle', horizontal: 'center' };
            worksheet.getCell(1, 1).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' }
            };

            worksheet.mergeCells(2, 1, 2, totalCols);
            worksheet.getCell(2, 1).value = `Payroll for the period of ${period}`;
            worksheet.getCell(2, 1).font = { size: 14, bold: true };
            worksheet.getCell(2, 1).alignment = {vertical: 'middle', horizontal: 'center' };
            worksheet.getCell(2, 1).border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' }
            };

            let currentRow = 3;

            // Step 2: Process THEAD with bigger font
            Array.from(thead.rows).forEach((tr, rowIndex) => {
                let colIndex = 1;

                tr.querySelectorAll('th').forEach(th => {
                    while (colTracker[rowIndex]?.includes(colIndex)) colIndex++;

                    const cell = worksheet.getCell(currentRow + rowIndex, colIndex);
                    const value = th.textContent.trim();
                    cell.value = value;
                    cell.alignment = { vertical: 'middle', horizontal: 'center', wrapText: true };
                    cell.font = { bold: true, size: 12 };
                    cell.border = {
                        top: { style: 'thin' },
                        left: { style: 'thin' },
                        bottom: { style: 'thin' },
                        right: { style: 'thin' }
                    };
                    cell.fill = {
                        type: 'pattern',
                        pattern: 'solid',
                        fgColor: { argb: 'D3D3D3' }
                    };
                    columnWidths[colIndex - 1] = Math.max(columnWidths[colIndex - 1] || 10, value.length + 2);

                    const rowspan = parseInt(th.getAttribute('rowspan') || 1);
                    const colspan = parseInt(th.getAttribute('colspan') || 1);

                    for (let i = 0; i < rowspan; i++) {
                        if (!colTracker[rowIndex + i]) colTracker[rowIndex + i] = [];
                        for (let j = 0; j < colspan; j++) {
                            colTracker[rowIndex + i].push(colIndex + j);
                        }
                    }

                    if (rowspan > 1 || colspan > 1) {
                        worksheet.mergeCells(currentRow + rowIndex, colIndex, currentRow + rowIndex + rowspan - 1, colIndex + colspan - 1);
                    }

                    colIndex += colspan;
                });
            });

            const headerRowCount = thead.rows.length;

            // Step 3: Process TBODY
            Array.from(tbody.rows).forEach((tr, rowOffset) => {
                Array.from(tr.cells).forEach((td, colIndex) => {
                    const value = td.textContent.trim();
                    const cell = worksheet.getCell(currentRow + headerRowCount + rowOffset, colIndex + 1);
                    cell.value = value;
                    cell.border = {
                        top: { style: 'thin' },
                        left: { style: 'thin' },
                        bottom: { style: 'thin' },
                        right: { style: 'thin' }
                    };
                    columnWidths[colIndex] = Math.max(columnWidths[colIndex] || 10, value.length + 2);
                });
            });

            // Step 4: Process TFOOT
            if (tfoot) {
                const footerRow = Array.from(tfoot.rows)[0];
                const rowOffset = currentRow + headerRowCount + tbody.rows.length;
                let excelCol = 1;

                Array.from(footerRow.cells).forEach((td) => {
                    const value = td.textContent.trim();
                    const colspan = parseInt(td.getAttribute('colspan') || 1);
                    const cell = worksheet.getCell(rowOffset, excelCol);
                    cell.value = value;
                    cell.font = { bold: true };
                    cell.border = {
                        top: { style: 'thin' },
                        left: { style: 'thin' },
                        bottom: { style: 'thin' },
                        right: { style: 'thin' }
                    };

                    // Alignment: if colspan > 1, align right (usually label), else left (usually value)
                    cell.alignment = { horizontal: colspan > 1 ? 'right' : 'left' };

                    columnWidths[excelCol - 1] = Math.max(columnWidths[excelCol - 1] || 10, value.length + 2);

                    if (colspan > 1) {
                        worksheet.mergeCells(rowOffset, excelCol, rowOffset, excelCol + colspan - 1);
                        excelCol += colspan;
                    } else {
                        excelCol++;
                    }
                });
            }

            // Estimate number of columns
            const totalColumns = columnWidths.length;
            const maxTotalWidth = 83;
            const widthPerColumn = Math.floor(maxTotalWidth / totalColumns);

            worksheet.columns.forEach((col, i) => {
                col.width = widthPerColumn > 10 ? widthPerColumn : 10; // minimum 10 for readability
            });


            // Step 6: Freeze Top 3 Header Rows
            worksheet.views = [
                { state: 'frozen', xSplit: 0, ySplit: currentRow + headerRowCount - 1 }
            ];

            // Step 7: Add Filter to the Last Header Row
            worksheet.autoFilter = {
                from: {
                    row: currentRow + headerRowCount - 1,
                    column: 1
                },
                to: {
                    row: currentRow + headerRowCount - 1,
                    column: columnWidths.length
                }
            };

            worksheet.pageSetup = {
                paperSize: 9, // A4
                orientation: 'landscape',
                fitToPage: true,
                fitToWidth: 1,
                fitToHeight: 0
            };

            // Save
            workbook.xlsx.writeBuffer().then(function (buffer) {
                const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = `Payroll_for_period_of_${period}.xlsx`;
                link.click();
            });
        });
        
        $(document).on('click', '#payroll_exportpdf', function () {
            let company_name = $('#company_name_val').val();
            let period = $('#pay_period').val();
            let current_date_time = $('#current_date_time').val();
           

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });
            const totalPagesExp = "{total_pages_count_string}";

            let headers = [];
            let bodyData = [];
            let mergeCells = [];
            const maxCols = [];

            // First: Parse headers manually
            $("#infoPayrollTable thead tr").each(function (rowIndex) {
                let rowData = [];
                let colPosition = 0;

                // Initialize a row for tracking colspan fills
                if (!maxCols[rowIndex]) maxCols[rowIndex] = [];

                $(this).children("th").each(function () {
                    const cell = $(this);
                    const content = cell.text().trim();
                    const colspan = parseInt(cell.attr("colspan")) || 1;
                    const rowspan = parseInt(cell.attr("rowspan")) || 1;

                    // Find the next available colPosition (skip previously filled cells)
                    while (maxCols[rowIndex][colPosition]) {
                        colPosition++;
                    }

                    // Add the current cell to the row data
                    rowData.push({
                        content: content,
                        colSpan: colspan,
                        rowSpan: rowspan
                    });

                    // Mark the occupied positions in maxCols
                    for (let r = 0; r < rowspan; r++) {
                        for (let c = 0; c < colspan; c++) {
                            if (!maxCols[rowIndex + r]) maxCols[rowIndex + r] = [];
                            maxCols[rowIndex + r][colPosition + c] = true;
                        }
                    }

                    colPosition += colspan;
                });

                headers.push(rowData);
            });

            // Get body data (handling colspan)
            $("#infoPayrollTable tbody tr").each(function (rowIndex) {
                let rowData = [];
                let colIndexOffset = 0;

                $(this).find("td").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push(text);

                    if (colspan > 1) {
                        mergeCells.push({
                            row: bodyData.length, // Corrected row index
                            col: colIndex + colIndexOffset,
                            colspan: colspan,
                        });

                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }

                        colIndexOffset += colspan - 1;
                    }
                });

                bodyData.push(rowData);
            });

            $("#infoPayrollTable tfoot tr").each(function (rowIndex) {
                let rowData = [];
                let colIndexOffset = 0;

                $(this).find("th").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push(text);

                    if (colspan > 1) {
                        mergeCells.push({
                            row: bodyData.length, // Corrected row index
                            col: colIndex + colIndexOffset,
                            colspan: colspan,
                        });

                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }

                        colIndexOffset += colspan - 1;
                    }
                });

                bodyData.push(rowData);
            });   

            doc.setFontSize(20);  // Title font size
            doc.setFont("helvetica", "bold");
            doc.setTextColor(0, 0, 0);  
            
            const pageWidth = doc.internal.pageSize.width;
            const titleText = company_name;
            const textWidth = doc.getStringUnitWidth(titleText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
            const xCoordinate = (pageWidth - textWidth) / 2;  // Centering the text
            const xCoordinateSub = (pageWidth - textWidth) / 2.5;
            const startY = 17;

            doc.text(titleText, xCoordinate, 10);  
            doc.setFontSize(14); 
            doc.text(`Payroll for the period of ${period}`, xCoordinateSub, startY);

            doc.autoTable({
                head: headers,  // Correctly formatted headers
                body: bodyData,
                theme: "grid",
                styles: {
                    fontSize: 6,
                    cellPadding: 0.3,
                    textColor: [0, 0, 0], 
                    overflow: "linebreak",
                    valign: "middle",
                    halign: "center",
                },
                headStyles: {
                    fillColor: "#D3D3D3", 
                    textColor: [0, 0, 0], 
                    lineWidth: 0.1, // Border thickness
                    lineColor: [0, 0, 0], // White border
                    fontStyle: "bold",
                },
                
                margin: { top: 20, left: 1, right: 1 },
                didParseCell: function (data) {
                    if (data.row.section === "body"){
                        mergeCells.forEach(function (merge) {
                            if (data.row.index === merge.row && data.column.index === merge.col) {
                                data.cell.colSpan = merge.colspan;
                                data.cell.styles.fontStyle = 'bold';
                            }
                            if(parseInt(data.cell.colSpan) == 8){
                                data.cell.styles.halign = "right";
                                data.cell.styles.fontStyle = 'bold';
                            }
                        });
                        data.cell.styles.lineWidth = 0.1;  // Thickness of the border
                        data.cell.styles.lineColor = [0, 0, 0];  // Black border color
                    }
                    const lastRowIndex = data.table.body.length - 1;
                    if (data.row.index === lastRowIndex && data.section === 'body') {
                        data.cell.styles.fontStyle = 'bold'; 
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

                    doc.text(`Exported on: ${current_date_time}`, 5, pageHeight - 3);

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

            doc.save(`Payroll_for_period_of_${period}.pdf`);
        });

        $(document).on('click', '#payroll_printtable', function () {
            let company_name = $('#company_name_val').val();
            let period = $('#pay_period').val();
            let current_date_time = $('#current_date_time').val();
           

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });
            const totalPagesExp = "{total_pages_count_string}";

            let headers = [];
            let bodyData = [];
            let footData = [];
            let mergeCells = [];
            const maxCols = [];

            // First: Parse headers manually
            $("#infoPayrollTable thead tr").each(function (rowIndex) {
                let rowData = [];
                let colPosition = 0;

                // Initialize a row for tracking colspan fills
                if (!maxCols[rowIndex]) maxCols[rowIndex] = [];

                $(this).children("th").each(function () {
                    const cell = $(this);
                    const content = cell.text().trim();
                    const colspan = parseInt(cell.attr("colspan")) || 1;
                    const rowspan = parseInt(cell.attr("rowspan")) || 1;

                    // Find the next available colPosition (skip previously filled cells)
                    while (maxCols[rowIndex][colPosition]) {
                        colPosition++;
                    }

                    // Add the current cell to the row data
                    rowData.push({
                        content: content,
                        colSpan: colspan,
                        rowSpan: rowspan
                    });

                    // Mark the occupied positions in maxCols
                    for (let r = 0; r < rowspan; r++) {
                        for (let c = 0; c < colspan; c++) {
                            if (!maxCols[rowIndex + r]) maxCols[rowIndex + r] = [];
                            maxCols[rowIndex + r][colPosition + c] = true;
                        }
                    }

                    colPosition += colspan;
                });

                headers.push(rowData);
            });

            // Get body data (handling colspan)
            $("#infoPayrollTable tbody tr").each(function (rowIndex) {
                let rowData = [];
                let colIndexOffset = 0;

                $(this).find("td").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push(text);

                    if (colspan > 1) {
                        mergeCells.push({
                            row: bodyData.length, // Corrected row index
                            col: colIndex + colIndexOffset,
                            colspan: colspan,
                        });

                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }

                        colIndexOffset += colspan - 1;
                    }
                });

                bodyData.push(rowData);
            });

            $("#infoPayrollTable tfoot tr").each(function (rowIndex) {
                let rowData = [];
                let colIndexOffset = 0;

                $(this).find("th").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push(text);

                    if (colspan > 1) {
                        mergeCells.push({
                            row: bodyData.length, // Corrected row index
                            col: colIndex + colIndexOffset,
                            colspan: colspan,
                        });

                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }

                        colIndexOffset += colspan - 1;
                    }
                });

                bodyData.push(rowData);
            });   

            doc.setFontSize(20);  // Title font size
            doc.setFont("helvetica", "bold");
            doc.setTextColor(0, 0, 0);  
            
            const pageWidth = doc.internal.pageSize.width;
            const titleText = company_name;
            const textWidth = doc.getStringUnitWidth(titleText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
            const xCoordinate = (pageWidth - textWidth) / 2;  // Centering the text
            const xCoordinateSub = (pageWidth - textWidth) / 2.5;
            const startY = 17;

            doc.text(titleText, xCoordinate, 10);  
            doc.setFontSize(14); 
            doc.text(`Payroll for the period of ${period}`, xCoordinateSub, startY);

            doc.autoTable({
                head: headers,  // Correctly formatted headers
                body: bodyData,
                theme: "grid",
                styles: {
                    fontSize: 5,
                    cellPadding: 0.3,
                    textColor: [0, 0, 0], 
                    overflow: "linebreak",
                    valign: "middle",
                    halign: "center",
                },
                headStyles: {
                    fillColor: "#D3D3D3", 
                    textColor: [0, 0, 0], 
                    lineWidth: 0.1, // Border thickness
                    lineColor: [0, 0, 0], // White border
                    fontStyle: "bold",
                },
                margin: { top: 20, left: 1, right: 1 },
                didParseCell: function (data) {
                    if (data.row.section === "body"){
                        mergeCells.forEach(function (merge) {
                            if (data.row.index === merge.row && data.column.index === merge.col) {
                                data.cell.colSpan = merge.colspan;
                                data.cell.styles.fontStyle = 'bold';
                            }
                            if(parseInt(data.cell.colSpan) == 8){
                                data.cell.styles.halign = "right";
                                data.cell.styles.fontStyle = 'bold';
                            }
                        });
                        data.cell.styles.lineWidth = 0.1;  // Thickness of the border
                        data.cell.styles.lineColor = [0, 0, 0];  // Black border color
                    }
                    const lastRowIndex = data.table.body.length - 1;
                    if (data.row.index === lastRowIndex && data.section === 'body') {
                        data.cell.styles.fontStyle = 'bold'; 
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

                    doc.text(`Printed on: ${current_date_time}`, 5, pageHeight - 3);

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

            const blob = doc.output("bloburl");
            const printWindow = window.open(blob, `_blank`, 'width=1400,height=800,top=100,left=100');

            if (printWindow) {
                printWindow.focus();
                // printWindow.onload = function () {
                //     printWindow.print();
                // };
            } else {
                toastrMessage('error', "Popup blocked. Please allow popups for this site.", "Error");
            }
        });

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
            $('#orgtree').hummingbird('expandAll');

            if(text!=null && text!=""){
                $('#selectalldiv').hide();
            }
            else if(text=="" || text===""){
                $('#selectalldiv').show();
                $('#orgtree').hummingbird('collapseAll');
            }
        });
       
        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/savePayroll',
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
                        if (data.errors.pemployee) {
                            $('#employee-error').html("Atleast one employee(s) should be selected");
                        }
                        if (data.errors.ToMonthRange) {
                            $('#monthrange-error').html(data.errors.ToMonthRange[0]);
                        }
                        if (data.errors.FromMonthRange) {
                            $('#monthrange-error').html(data.errors.FromMonthRange[0]);
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
                    else if(data.emperror)
                    {
                        var employeelist="";
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }

                        $.each(data.emplists, function(key, value) {
                            ++key;
                            employeelist+="<b>"+key+".</b> "+value.EmployeeID+",   "+value.name+"</br>"
                        });

                        toastrMessage('error',"The payroll has been processed for the selected pay range for the following employees. </br>------------</br>"+employeelist,"Error");
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
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        $('#voidbtn').click(function() {
            var registerForm = $("#voidform");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/voidPayroll',
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
                    $('#voidbtn').text('Voiding...');
                    $('#voidbtn').prop("disabled", true);
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
                            $('#void-error').html(data.errors.Reason[0]);
                        }
                        $('#voidbtn').text('Void');
                        $('#voidbtn').prop("disabled", false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#voidbtn').text('Void');
                        $('#voidbtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#voidmodal").modal('hide');
                        $("#informationmodal").modal('hide');
                    }
                }
            });
        });

        $('#undovoidbtn').click(function() {
            var registerForm = $("#undovoidform");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/undovoidPayroll',
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
                    $('#undovoidbtn').text('Changing...');
                    $('#undovoidbtn').prop("disabled", true);
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
                        $('#undovoidbtn').text('Undo Void');
                        $('#undovoidbtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    
                    else if(data.success){
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#undovoidmodal").modal('hide');
                        $("#informationmodal").modal('hide');
                    }
                }
            });
        });

        function updateParentCheckboxEdit(checkbox) {
            const parentLi = checkbox.closest('li').parent().closest('li');
            if (parentLi.length) {
                const parentCheckbox = parentLi.find('> .node-content .checkbox');
                const childCheckboxes = parentLi.find('ul .checkbox');
                
                const checkedCount = childCheckboxes.filter(':checked').length;
                const indeterminateCount = childCheckboxes.filter(function() {
                    return $(this).prop('indeterminate');
                }).length;
                
                if (checkedCount === 0 && indeterminateCount === 0) {
                    parentCheckbox.prop('checked', false);
                    parentCheckbox.prop('indeterminate', false);
                } else if (checkedCount === childCheckboxes.length) {
                    parentCheckbox.prop('checked', true);
                    parentCheckbox.prop('indeterminate', false);
                } else {
                    parentCheckbox.prop('indeterminate', true);
                    parentCheckbox.prop('checked', false);
                }
                
                // Propagate up the tree
                updateParentCheckboxEdit(parentCheckbox);
            }
        }

        function payrollEditFn(recordId) { 
            $('.select2').select2();
            $("#operationtypes").val("2");
            $("#recId").val(recordId);
            $('#recInfoId').val("");
            var employeeData=[];
            var checkedValues=[];
            var numberOfChecked=0;
            var numberOfCheckbox=0;
            var lateabsentedit = [];
            j=0;
            globalFlg = 1;
            $("#dynamicTableDiv").hide();
            $("#dynamicPayrollTable > tbody").empty();
            $.ajax({
                url: '/showPayrollData'+'/'+recordId,
                type: 'GET',
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
                    $('#masterCheckbox').prop('checked',false); 
                    $('#masterCheckbox').prop('indeterminate',false);
                    $('.checkbox').prop('checked',false); 
                    checkedValues=[];
                    $.each(data.payrolldata, function(key, value) {
                        $('#FromMonthRange').val(value.PayRangeFrom).trigger('change').select2();
                        $('#ToMonthRange').val(value.PayRangeTo).select2();
                        $('#Remark').val(value.Remark);

                        if(value.Status == "Draft"){
                            forecolor = "#82868b";
                        }
                        else if(value.Status == "Pending"){
                            forecolor = "#ff9f43";
                        }
                        else if(value.Status == "Verified"){
                            forecolor = "#7367f0";
                        }
                        else if(value.Status == "Approved"){
                            forecolor = "#28c76f";
                        }
                        $("#statusdisplay").html(`<span style='color:${forecolor};font-weight:bold;font-size:16px;text-align:right;'>${value.DocumentNumber}, ${value.Status}</span>`);
                    });

                    $.each(data.empdata, function(key, value) {
                        checkedValues.push(value.employees_id);
                        //lateabsentedit.push({id: value.employees_id, lateabs: value.lateabsent_hr});
                    });

                    $('.employeecls').each(function(index, element){
                        var checkboxValue = parseInt($(this).val());
                        if (checkedValues.includes(checkboxValue)) {
                            $(this).prop('checked', true);
                            const checkbox = $(this);
                            const isChecked = checkbox.prop('checked');
                            
                            // Update children
                            checkbox.closest('li').find('.checkbox').prop('checked', isChecked);
                            
                            // Update parents
                            
                            updateParentCheckboxEdit(checkbox);
                            updateCheckedCount();
                        }
                    });

                    numberOfChecked = $('.employeecls:checked').length;
                    numberOfCheckbox = $('.employeecls').length;

                    if(parseInt(numberOfChecked)==parseInt(numberOfCheckbox)){
                        $('#masterCheckbox').prop('checked',true); 
                    }
                    else if(parseInt(numberOfChecked)!=parseInt(numberOfCheckbox)){
                        $('#masterCheckbox').prop('indeterminate',true);
                    }
                }
            });

            $("#modaltitle").html("Edit Payroll");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').hide();
            $("#inlineForm").modal('show'); 
        }

        function getLateAbsentFn(recordId){
            $.ajax({
                url: '/showPayrollData'+'/'+recordId,
                type: 'GET',
                success: function(data) {
                    $.each(data.empdata, function(key, detvalue) {
                        $(`#lateabs_emp_${detvalue.employees_id}`).val(parseFloat(detvalue.lateabsent_hr || 0));
                        calculatePenalty(detvalue.employees_id);
                    });
                }
            });
            globalFlg = 0;
            calculateFooter();
            $("#dynamicTableDiv").show();
        }

        function payrollInfoFn(recordId) { 
            $("#recInfoId").val(recordId);
            var forecolor = "";
            var employeeids = [];
            var monthval = "";
            var month = "";
            var emplist = "";
            var recId = "";
            var lidata = "";
            $(".actionpropbtn").hide();
            $.ajax({
                url: '/showPayrollData'+'/'+recordId,
                type: 'GET',
                async: false, 
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
                    $.each(data.payrolldata, function(key, value) {
                        $('#payrollIdInfoLbl').html(value.DocumentNumber);
                        $('#typeInfoLbl').html(value.PType);
                        $('#branchInfoLbl').html(value.Branch);
                        $('#payrangeInfoLbl').html(value.PayRange+"  <i>("+value.FirstDayofMonth+"   to   "+value.LastDayofMonth+")</i>");
                        $('#remarkInfoLbl').html(value.Remark);
                        $('#currentStatus').val(value.Status);
                        $('#fromdateinfo').val(value.PayRangeFrom);
                        $('#todateinfo').val(value.PayRangeTo);
                        $('#from_date_fullformat').val(value.FirstDayofMonth);
                        $('#to_date_fullformat').val(value.LastDayofMonth);
                        $('#company_name_val').val(data.company_name);
                        $('#pay_period').val(data.formatted_month);
                        $('#current_date_time').val(data.currentdatetimeAA);
                        
                        if(value.Status == "Draft"){
                            $("#changetopending").show();
                            forecolor = "#82868b";
                        }
                        else if(value.Status == "Pending"){
                            $("#backtodraft").show();
                            $("#verifybtn").show();
                            forecolor = "#ff9f43";
                        }
                        else if(value.Status == "Verified"){
                            $("#approvebtn").show();
                            $("#backtopending").show();
                            $("#rejectbtn").show();
                            forecolor = "#7367f0";
                        }
                        else if(value.Status == "Approved"){
                            $("#backtoverify").show();
                            forecolor = "#28c76f";
                        }
                        else if(value.Status == "Rejected"){
                            $("#approvebtn").show();
                            forecolor = "#ea5455";
                        }
                        else if(value.Status == "Void" || value.Status == "Void(Draft)" || value.Status == "Void(Pending)" || value.Status == "Void(Verified)" || value.Status == "Void(Approved)"){
                            $(".actionpropbtn").hide();
                            forecolor = "#ea5455";
                        }
                        else{
                            $(".actionpropbtn").hide();
                            forecolor = "#ea5455";
                        }
                        $("#statustitles").html(`<span style='color:${forecolor};font-weight:bold;font-size:16px;text-align:right;'>${value.DocumentNumber}, ${value.Status}</span>`);
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited" || value.action == "Change to Pending"){
                            classes="warning";
                        }
                        else if(value.action == "Verified"){
                            classes="primary";
                        }
                        else if(value.action == "Created" || value.action == "Back to Draft" || value.action == "Back to Pending" || value.action == "Back to Verify" || value.action == "Undo Void"){
                            classes="secondary";
                        }
                        else if(value.action == "Approved"){
                            classes="success";
                        }
                        else if(value.action == "Void" || value.action=="Void(Draft)" || value.action=="Void(Pending)" || value.action=="Void(Verified)" || value.action=="Void(Approved)" || value.action=="Rejected"){
                            classes="danger";
                        }

                        if(value.reason!=null && value.reason!=""){
                            reasonbody='</br><span class="text-muted"><b>Reason:</b> '+value.reason+'</span>';
                        }
                        else{
                            reasonbody="";
                        }
                        lidata+=`<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span>${reasonbody}</br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $("#actiondiv").empty();
                    $('#actiondiv').append(lidata);
                }
            });

            getPayrollColumns();

            // $.ajax({
            //     url: '/getPayrollColumns',
            //     method: 'POST',
            //     success: function (columns) {
            //         payrollColumns = columns;
            //     }
            // });

            $.ajax({ 
                url: '/getEmployeeSalaryListInfo',
                type: 'POST',
                data:{
                    recId: recordId,
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
                success: function(response) {
                    let rawData = response.data;
                    let columns = [];

                    if (rawData.length > 0) {
                        let firstRow = rawData[0];

                        // Basic columns
                        columns.push({ data: null,
                            render: function (data, type, row, meta) {
                                return meta.row + 1; // index starts from 1
                            },
                            orderable: false,
                            searchable: false
                        });
                        columns.push({ data: 'name',
                            render: function (data, type, row, meta) {
                                return `${data}</br>(${row.EmployeeID})`;
                            },
                        });
                        columns.push({ data: 'BranchName'});
                        columns.push({ data: 'DepartmentName'});
                        columns.push({ data: 'PositionName'});
                        columns.push({ data: 'PresentDay',
                            render: function (data, type, row, meta) {
                                return `${data} of ${row.daysInMonth}`;
                            },
                        });
                        columns.push({ data: 'perHourSalary'});
                        columns.push({ data: 'lateabsenthr'});

                        let footerHtml = '<tr><th colspan="8" style="text-align:right;font-size:13px">Total</th>';

                        const parentKeys = ['salaries', 'otData', 'addsalaries','deductionData','netPayData'];
                        parentKeys.forEach(parent => {
                            let sampleData = rawData.find(row => row[parent] && Object.keys(row[parent]).length > 0);
                            let keys = sampleData ? Object.keys(sampleData[parent]) : [];

                            keys.forEach(key => {
                                columns.push({
                                    data: `${parent}.${key}`,
                                        render: function(data,type,row,meta) {
                                            if(key == "NP1"){
                                                return `<a style="text-decoration:underline;color:blue;" onclick=netPayFn(${row.employee_id})>${parseFloat(data) > 0 ? numformat(parseFloat(data).toFixed(2)) : ''}</a>`;
                                            }
                                            else{
                                                return parseFloat(data) > 0 ? numformat(parseFloat(data).toFixed(2)) : "";
                                            }
                                        }
                                });
                                footerHtml += '<th></th>'; // One <th> per column
                            });
                        });

                        footerHtml += '</tr>';
                        $('#infoPayrollFooter').html(footerHtml);
                    }
                    $('#infoPayrollTable').DataTable({
                        destroy: true,
                        responsive: true,        
                        paging: true,             
                        searching: true,           
                        ordering: true,           
                        info: true,       
                        searchHighlight: true, 
                        "order": [[ 1, "asc" ]],       
                        "pagingType": "simple",
                        "lengthMenu": [50,100],
                        language: {
                            search: '',
                            searchPlaceholder: "Search here"
                        },          
                        "dom": "<'row'<'col-sm-12 col-md-4'f><'col-sm-12 col-md-6'><'col-sm-12 col-md-2 custom-buttons'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-5'><'col-sm-12 col-md-3'p>>",
                        data: rawData,
                        columns: columns,

                        columnDefs: [{
                            targets: '_all',
                            className: 'text-style'
                        }],

                        footerCallback: function (row, data, start, end, display) {
                            const api = this.api();
                            const startIndex = 8; 

                            $(api.table().footer())
                            .find('th') 
                            .slice(0, 1) 
                            .removeClass('text-style') 
                            .css({
                                'font-weight': 'bold',
                                'text-align': 'right'
                            });

                            api.columns().every(function (colIdx) {
                                if (colIdx < startIndex) return; // Skip non-numeric columns

                                let total = 0;

                                try {
                                    const dataArr = api
                                        .column(colIdx, { page: 'current' })
                                        .data()
                                        .toArray();

                                    // Only sum values > 0
                                    total = dataArr.reduce((sum, val) => {
                                        const num = parseFloat(val);
                                        return num > 0 ? sum + num : sum;
                                    }, 0);
                                } catch (e) {
                                    total = '';
                                }

                                $(api.column(colIdx).footer()).html(
                                total ? numformat(parseFloat(total).toFixed(2)) : ''
                                );
                            });
                        },
                        "initComplete": function () {
                            $('.custom-buttons').html(`
                                <button id="payroll_printtable" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm printattlog" title="Print" style="color: #4B5563"><i class="fa-solid fa-print fa-lg" aria-hidden="true"></i></button>
                                <button id="payroll_exporttoexcel" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm exportattlogtoexcel" title="Export to Excel" style="color: #15803D"><i class="fa-solid fa-file-excel fa-lg" aria-hidden="true"></i></button>
                                <button id="payroll_exportpdf" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm exportattlogtopdf" title="Export to PDF" style="color: #B91C1C"><i class="fa-solid fa-file-pdf fa-lg" aria-hidden="true"></i></button>
                            `);
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
                        },
                    });
                },

                error: function(xhr, status, error) {
                    console.log("Error");
                }
            });

            $(".infoscl").collapse('show');
            $("#informationmodal").modal('show');
        }

        function forwardActionFn() {
            const requestId = $('#recInfoId').val();
            const currentStatus = $('#currentStatus').val();
            const transition = statusTransitions[currentStatus].forward;

            $('#forwardReqId').val(requestId);
            $('#newForwardStatusValue').val(transition.status);
            $('#forwardActionLabel').html(transition.message);
            $('#forwarkBtnTextValue').val(transition.text);
            $('#forwardActionBtn').text(transition.text);
            $('#forwardActionValue').val(transition.action);
            $("#modalBodyId").css({"background-color":transition.backcolor});
            $("#forwardActionLabel").css({'color':transition.forecolor});
            $('#forwardActionModal').modal('show');
        }

        $('#forwardActionBtn').click(function() {
            var forwardForm = $("#forwardActionForm");
            var formData = forwardForm.serialize();
            var btntxt = $('#forwarkBtnTextValue').val();
            $.ajax({
                url: '/payrollForwardAction',
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
                    $('#forwardActionBtn').text('Changing...');
                    $('#forwardActionBtn').prop("disabled", true);
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
                    $('#forwardActionBtn').text(btntxt);
                    $('#forwardActionBtn').prop("disabled",false);
                },
                success: function(data) {
                    if (data.dberrors) {
                        $('#forwardActionBtn').text(btntxt);
                        $('#forwardActionBtn').prop("disabled",false);
                        $("#forwardActionModal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#forwardActionModal").modal('hide');
                        $("#informationmodal").modal('hide');
                    }
                }
            });
        });

        $('.backwardbtn').click(function(){
            const requestId = $('#recInfoId').val();
            const currentStatus = $('#currentStatus').val();

            const transition = $(this).attr('id') == "rejectbtn" ? statusTransitions[currentStatus].reject : statusTransitions[currentStatus].backward;

            $('#backwardReqId').val(requestId);
            $('#newBackwardStatusValue').val(transition.status);
            $('#backwardActionLabel').html(transition.message);
            $('#backwardBtnTextValue').val(transition.text);
            $('#backwardActionBtn').text(transition.text);
            $('#backwardActionValue').val(transition.action);
            $('#CommentOrReason').val("");
            $('#commentres-error').html("");
            $('#backwardActionModal').modal('show');
        });

        $("#backwardActionBtn").click(function() {
            var registerForm = $("#backwardActionForm");
            var formData = registerForm.serialize();
            var btntxt = $('#backwardBtnTextValue').val();

            $.ajax({
                url: '/payrollBackwardAction',
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

                    $('#backwardActionBtn').text('Changing...');
                    $('#backwardActionBtn').prop("disabled", true);
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
                    $('#backwardActionBtn').text(btntxt);
                    $('#backwardActionBtn').prop("disabled", false);
                },

                success: function(data) {
                    if (data.errors) {
                        if (data.errors.CommentOrReason) {
                            $('#commentres-error').html(data.errors.CommentOrReason[0]);
                        }
                        $('#backwardActionBtn').text(btntxt);
                        $('#backwardActionBtn').prop("disabled",false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backwardActionBtn').text(btntxt);
                        $('#backwardActionBtn').prop("disabled",false);
                        $('#backwardActionModal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $('#backwardActionModal').modal('hide');
                        $('#informationmodal').modal('hide');
                    }
                }
            });
        });

        function payrolladdVoidFn(recordId) { 
            $("#voidId").val(recordId);
            $('#Reason').val("");
            $('#void-error').html("");
            $('#voidmodal').modal('show');
            $('#voidbtn').text("Void");
            $('#voidbtn').prop("disabled", false );
        }

        function payrollundovoidFn(recordId) { 
            $("#undovoidid").val(recordId);
            $('#undovoidmodal').modal('show');
            $('#undovoidbtn').text("Undo Void");
            $('#undovoidbtn').prop("disabled", false );
        }

        function payrollAddDedInfoFn(recordId) { 
            $("#recInfoId").val(recordId);
            var forecolor = "";
            var lidata = "";
            var empname = $("#employeepdfullname").html();
            $.ajax({
                url: '/showPayrollAdd'+'/'+recordId,
                type: 'GET',
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
                    $.each(data.payrolladd, function(key, value) {
                        $('#paddpayrollIdInfoLbl').html(value.DocumentNumber);
                        $('#paddtypeInfoLbl').html(value.PType);
                        $('#paddbranchInfoLbl').html(value.BranchName);
                        $('#padddepartmentInfoLbl').html(value.DepartmentName);
                        $('#paddpositionInfoLbl').html(value.PositionName);
                        $('#paddpayrangeInfoLbl').html(value.PayRange+"  <i>("+value.FirstDayofMonth+"   to   "+value.LastDayofMonth+")</i>");
                        $('#paddremarkInfoLbl').html(value.Remark);

                        if(value.Status == "Draft"){
                            forecolor = "#82868b";
                        }
                        else if(value.Status == "Pending"){
                            forecolor = "#ff9f43";
                        }
                        else if(value.Status == "Verified"){
                            forecolor = "#7367f0";
                        }
                        else if(value.Status == "Approved"){
                            forecolor = "#28c76f";
                        }
                        else if(value.Status == "Rejected"){
                            forecolor = "#ea5455";
                        }
                        else if(value.Status == "Void" || value.Status == "Void(Draft)" || value.Status == "Void(Pending)" || value.Status == "Void(Verified)" || value.Status == "Void(Approved)"){
                            forecolor = "#ea5455";
                        }
                        else{
                            forecolor = "#ea5455";
                        }
                        $("#paddstatustitles").html(`<span style='color:${forecolor};font-weight:bold;font-size:16px;text-align:right;'>${value.DocumentNumber}, ${value.Status}</span>`);

                        if(value.type==1){
                            $('#infotitlename').html("Addition");
                            $('#infototalamountlbl').html("Total amount of addition for each employees");
                        }
                        else if(value.type==2){
                            $('#infotitlename').html("Deduction");
                            $('#infototalamountlbl').html("Total amount of deduction for each employees");
                        }
                    });
                    $('#infototalamountval').html(data.totalsalaryamount);

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited" || value.action == "Change to Pending"){
                            classes="warning";
                        }
                        else if(value.action == "Verified"){
                            classes="primary";
                        }
                        else if(value.action == "Created" || value.action == "Back to Draft" || value.action == "Back to Pending" || value.action == "Back to Verify" || value.action == "Undo Void"){
                            classes="secondary";
                        }
                        else if(value.action == "Approved"){
                            classes="success";
                        }
                        else if(value.action == "Void" || value.action=="Void(Draft)" || value.action=="Void(Pending)" || value.action=="Void(Verified)" || value.action=="Void(Approved)" || value.action=="Rejected"){
                            classes="danger";
                        }

                        if(value.reason!=null && value.reason!=""){
                            reasonbody='</br><span class="text-muted"><b>Reason:</b> '+value.reason+'</span>';
                        }
                        else{
                            reasonbody="";
                        }
                        lidata+=`<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span>${reasonbody}</br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $("#paddactiondiv").empty();
                    $('#paddactiondiv').append(lidata);
                }
            });

            var emptable = $('#employeetablelist').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                "order": [
                    [2, "asc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showEmployeeLists/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'EmployeeID',
                        name: 'EmployeeID',
                        width:"20%"
                    },
                    {
                        data: 'name',
                        name: 'name',
                        width:"57%"
                    },
                    {
                        data: 'EmployeePhone',
                        name: 'EmployeePhone',
                        width:"20%"
                    }
                ],
            });

            $('#salarycomponentlist').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                "order": [
                    [2, "asc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showSalaryCompLists/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'SalaryTypeName',
                        name: 'SalaryTypeName',
                        width:"42%"
                    },
                    {
                        data: 'Amount',
                        name: 'Amount',
                        width:"25%"
                    },
                    {
                        data: 'PdetailRemark',
                        name: 'PdetailRemark',
                        width:"30%"
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
                },
            });

            //emptable.column(2).search(empname).draw();
            //$('.dataTables_filter input').val(empname);
            emptable.on('draw', function () {
                //var keyword = $('.dataTables_filter input').val();
                var body = $(emptable.table().body());

                body.unhighlight();
                if (empname) {
                    body.highlight(empname);
                }
            });

            $(".infoscl2").collapse('show');
            $("#paddinformationmodal").modal('show');
        }

        function otDetailFn(emid){
            var empid = 0;
            var fromdate = "";
            var todate = "";
            var perhrsalary = 0;
            var totalhour = 0;
            var totalamount = 0;
            var perhrdynamic = $(`#perHourSalary_emp_${emid}`).val();
            var perhrsaved = $('#perhoursalaryval').val();
            var perhrsal = perhrdynamic == null ? perhrsaved : perhrdynamic;
            $("#otdetailtable > tbody").empty();
            $('#totalothour').html("");
            $('#totalotamount').html("");
            $.ajax({
                url: '/getOtDetailData',
                type: 'POST',
                data:{
                    empid: emid,
                    fromdate:$('#fromdatepayroll').val()||0,
                    todate:$('#todatepayroll').val()||0,
                    perhrsalary:perhrsal,
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
                    $.each(data.payrollot, function(key, value) {
                        ++key;
                        $("#otdetailtable > tbody").append(`<tr>
                            <td style="font-weight:bold;text-align:center;width:3%">${key}</td>'+
                            <td style="text-align:center;width: 20%;">${value.OvertimeLevelName}</td>
                            <td style="text-align:center;width: 19%;">${numformat(parseFloat(value.Rate).toFixed(2))}</td>
                            <td style="text-align:center;width: 19%;">${numformat(parseFloat(value.per_hour_salary).toFixed(2))}</td>
                            <td style="text-align:center;width: 19%;">${numformat(parseFloat(value.OTHour).toFixed(2))}</td>
                            <td style="text-align:center;width: 20%;">
                                <div class="input-group">
                                    <label style="font-size:1rem;width:88%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">${numformat(parseFloat(value.Amount).toFixed(2))}</label>
                                    <i id="otinfoicon" class="fas fa-info-circle" style="width:12%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);" title="Rate * Per hour Salary * Hour = Amount\n-----------------------------\n${numformat(parseFloat(value.Rate).toFixed(2))} * ${numformat(parseFloat(value.per_hour_salary).toFixed(2))} * ${numformat(parseFloat(value.OTHour).toFixed(2))} = ${numformat(parseFloat(value.Amount).toFixed(2))}"></i>
                                </div>
                            </td>
                        </tr>`);

                        totalhour += parseFloat(value.OTHour);
                        totalamount += parseFloat(value.Amount);
                    });
                    $('#totalothour').html(numformat(parseFloat(totalhour).toFixed(2)));
                    $('#totalotamount').html(numformat(parseFloat(totalamount).toFixed(2)));
                }
            }).done(function (response) {
                
            })
            .then(function () {
                cardSection.block({
                    message: '',
                    timeout: 1,
                    css: {
                        backgroundColor: '',
                        color: '',
                        border: ''
                    }
                });
            });
            $("#overtimedetailmodal").modal('show');
        }

        $('#deleterecbtn').click(function() {
            var delform = $("#deleteForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteotlevel',
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

        function closeRegisterModal() {
            $('#Branch').val(0).trigger('change').select2({
                placeholder:"Select branch here"
            });
            $('#Department').empty();
            $('#Position').empty();
            $('#Employee').empty();
            $('#Department').select2({
                placeholder:"Select branch first"
            });
            $('#Position').select2({
                placeholder:"Select department first"
            });
            $('#Employee').select2({
                placeholder:"Select position first"
            });
            $('.errordatalabel').html('');
            $('#totalbasicsalary').html("");
            $('#totalgrossincome').html("");
            $('#totalotherearning').html("");
            $('#totalincometax').html("");
            $('#totalpension').html("");
            $('#totaltaxableincome').html("");
            $('#totalcompension').html("");
            $('#totalotherdeduction').html("");
            $('#totaldeductionamount').html("");
            $('#totalnetpay').html("");
        }

        function remarkFn() {
            $('#remark-error').html('');
        }

        function commentValFn() {
            $('#commentres-error').html("");
        }

        $('#Employee').on('change', function(e) {
            $('#employee-error').html('');
        });

        $('#selectAll').change(function() {
            var selectAllChecked = $(this).prop('checked');
            var selectedValues = [];
            if(selectAllChecked==true){
                $('#Employee option').each(function() {
                    if($(this).val()>1){
                        selectedValues.push("<option selected value='" + $(this).val() + "'>" + $(this).text() + "</option>");
                    }
                });
            }
            else if(selectAllChecked==false){
                $('#Employee option').each(function() {
                    if($(this).val()>1){
                        selectedValues.push("<option value='" + $(this).val() + "'>" + $(this).text() + "</option>");
                    }
                });
            }
            $('#Employee').empty();
            $("#Employee").append(selectedValues);
            $('#employee-error').html('');
        });

        function fromMonthRangeFn() {
            var fromMonthRangeId=$('#FromMonthRange').val();
            var fromMonRange=null;
            $('#dynamicPayrollTable > tbody').empty();
            $.ajax({
                url: '/getPayrollFromMonthRange',
                type: 'POST',
                data:{
                    fromMonRange:$('#FromMonthRange').val(),
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
                    $('#grgStartDate').html(data.fday);
                    var defOption='<option selected value='+data.edayvalue+'>'+data.edayname+'</option>';
                    $('#ToMonthRange').empty();
                    $('#ToMonthRange').append(defOption).select2({minimumResultsForSearch:-1});
                    $('#grgEndDate').html(data.eday);
                    $('#startDateVal').val(data.startDate);
                    $('#endDateVal').val(data.endDate);
                    getEmpSalaryList();
                }
            });
            
            $('#monthrange-error').html('');
        }

        function toMonthRangeFn() {
            var toMonthRangeId=$('#ToMonthRange').val();
            var toMonRange=null;
            $('#dynamicPayrollTable > tbody').empty();
            $.ajax({
                url: '/getPayrollToMonthRange',
                type: 'POST',
                data:{
                    toMonRange:$('#ToMonthRange').val(),
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
                    $('#grgEndDate').html(data.eday);
                    $('#startDateVal').val(data.startDate);
                    $('#endDateVal').val(data.endDate);
                }
            });
            $('#monthrange-error').html('');
        }

        function editLateAbsentValFn(empid){
            $(`#lateabs_emp_${empid}`).prop("readonly", false); 
        }

        function voidReason()
        {
            $('#void-error').html("");
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }
    </script>
@endsection
