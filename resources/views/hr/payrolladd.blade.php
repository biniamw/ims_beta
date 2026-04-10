@extends('layout.app1')

@section('title')

@endsection

@section('content')

    @can('Payroll-Addition-Deduction-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Payroll Addition / Deduction</h3>
                            <div class="row" style="position: absolute;left: 270px;top: 80px;width:50%;z-index: 10;display:none" id="filter_div">
                                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                                    <select class="selectpicker form-control dropdownclass" id="BranchFilter" name="BranchFilter" title="Select Branch here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true">
                                        @foreach ($branchfilter as $branchfilter)
                                            <option selected value="{{$branchfilter->BranchName}}">{{$branchfilter->BranchName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div style="width:99%; margin-left:0.5%;">
                                <div id="payrollAddDedDiv" style="display: none;">
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width:3%;">#</th>
                                                <th style="width:17%;">ID</th>
                                                <th style="width:17%;">Type</th>
                                                <th style="width:17%;">Branch</th>
                                                <th style="width:27%;">Pay Range</th>
                                                <th style="width:15%;">Status</th>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-2 col-md-6 col-sm-6">
                                <label style="font-size: 14px;">Type</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control" name="Type" id="Type" onchange="typeFn()">
                                    <option value="1">Addition</option>
                                    <option value="2">Deduction</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="type-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-12 col-sm-12 mb-1" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                <div class="divider">
                                    <div class="divider-text">Employee Selection</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-md-4 col-sm-12 mb-1">
                                        <label style="font-size: 14px;">Branch</label><label style="color: red; font-size:16px;">*</label>
                                        <select class="select2 form-control" name="Branch" id="Branch" onchange="branchFn()">
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
                                            <strong id="employee-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>

                                    {{-- <div class="col-lg-12 col-md-12 col-12">
                                        <span class="text-danger">
                                            <strong id="employeelist-error" class="errordatalabel"></strong>
                                        </span>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control mainforminp" name="SearchEmployee" id="SearchEmployee" placeholder="Search Employee here..." aria-label="Search Employee here..." aria-describedby="button-addon">
                                            <button class="btn btn-outline-danger waves-effect btn-sm" type="button" id="button-addon"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="ml-1" id="selectalldiv">
                                            <label style="font-size:14px;font-weight:bold;"><input class="hummingbird-end-node" style="width:16px;height:16px;" id="selectalldep" class="selectalldep" type="checkbox"/>  Select All</label>
                                        </div>
                                        <div id="orgtree" class="hummingbird-treeview scrollhor" style="overflow-y: scroll;height:30rem;"></div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-12 mb-1">
                                <div class="divider">
                                    <div class="divider-text">Payment Period & Addition or Deduction</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-sm-12 mb-1">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                                <label style="font-size: 14px;">Pay Range</label><label style="color: red; font-size:16px;">*</label>
                                                <div>
                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td style="width: 49%">
                                                                <select class="select2 form-control" name="FromMonthRange" id="FromMonthRange" onchange="fromMonthRangeFn()">
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
                                                                <select class="select2 form-control" name="ToMonthRange" id="ToMonthRange" onchange="toMonthRangeFn()"></select>
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
                                    <div class="col-xl-6 col-md-6 col-sm-12 mb-1">
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
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                        <table id="dynamicTable" class="mb-0 rtable" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th colspan="5" style="text-align:center" id="titlename">Earning</th>
                                                </tr>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:40%">Salary Component</th>
                                                    <th style="width:24%">Amount</th>
                                                    <th style="width:30%">Remark</th>
                                                    <th style="width:3%"></th>
                                                </tr>
                                            <thead>
                                            <tbody></tbody>
                                            <tfoot id="totalamountTbl">
                                                <tr>
                                                    <th style="text-align:right" colspan="2">
                                                        <label style="font-size: 14px;" id="totalamountlbl">Total amount of addition for each employees</label>
                                                    </th>
                                                    <th style="text-align:left">
                                                        <label id="totalamountval" style="font-size: 14px; font-weight: bold;"></label>
                                                    </th>
                                                    <th colspan="2"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <table class="mb-0">
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
                                <option title="{{$salarytypes->SalaryType}}" value="{{$salarytypes->id}}">{{$salarytypes->SalaryTypeName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" placeholder="" class="form-control" name="recId" id="recId" readonly="true" value=""/>     
                        <input type="hidden" placeholder="" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
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
                    <h4 class="modal-title">Payroll Addition / Deduction Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Payroll Addition / Deduction Basic & Action Information</span>
                                                        <div id="statustitlesA"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-5 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="width: 22%"><label style="font-size: 14px;">ID</label></td>
                                                                                    <td style="width: 78%"><label id="payrollIdInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Type</label></td>
                                                                                    <td><label id="typeInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Branch</label></td>
                                                                                    <td><label id="branchInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Department</label></td>
                                                                                    <td><label id="departmentInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Position</label></td>
                                                                                    <td><label id="positionInfoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
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
                                                                <div class="col-lg-7 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Action Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:13rem">
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-md-12 col-lg-12">
                                    <div class="divider">
                                        <div class="divider-text">Selected Employee's</div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12">
                                            <table id="employeetablelist" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:32%;">Employee ID</th>
                                                        <th style="width:33%;">Employee Name</th>
                                                        <th style="width:32%;">Employee Phone</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table table-sm"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-12 col-lg-12">
                                    <div class="divider">
                                        <div class="divider-text">Selected Salary Component for each Employee's</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12">
                                            <table id="salarycomponentlist" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th id="infotitlename" colspan="4" style="text-align:center;"></th>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:32%;">Salary Component</th>
                                                        <th style="width:25%;">Amount</th>
                                                        <th style="width:40%;">Remark</th>
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
                        <input type="hidden" placeholder="" class="form-control" name="recInfoId" id="recInfoId" readonly="true" value=""/> 
                        <input type="hidden" placeholder="" class="form-control" name="currentStatus" id="currentStatus" readonly="true" value=""/> 
                        
                        @can('Leave-Request-ChangeToPending')
                        <button id="changetopending" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Change to Pending</button>
                        <button id="backtodraft" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Draft</button>
                        @endcan
                        @can('Leave-Request-Verify')
                        <button id="verifybtn" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Verify</button>
                        <button id="backtopending" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Pending</button>
                        @endcan

                        @can('Payroll-Addition-Deduction-Approve')    
                        <button id="approvebtn" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Approve</button>
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

    <!--Start Approve modal -->
    <div class="modal fade text-left" id="approvemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="approveform">
                    @csrf
                    <div class="modal-body" style="background-color:#5cb85c">
                        <label strong style="font-size: 14px; color:white;font-weight:bold;">Do you really want to approve payroll addition/ deduction?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="appId" id="appId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="approvepaybtn" type="button" class="btn btn-info">Approve</button>
                        <button id="closebuttonm" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Approve modal -->

    <!--Start void modal -->
    <div class="modal fade text-left" id="voidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="voidform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label strong style="font-size: 14px;font-weight:bold;">Do you really want to void payroll addition / deduction?</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Reason</div>
                        </div>
                        <label strong style="font-size: 16px;"></label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                        <span class="text-danger">
                            <strong id="void-error"></strong>
                        </span>
                        <div class="form-group">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" placeholder="" class="form-control" name="voidId" id="voidId" readonly="true">
                        <button id="voidbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttond" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End void modal -->

    <!--Start undo void modal -->
    <div class="modal fade text-left" id="undovoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-hidden="true">
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
                        <label strong style="font-size: 14px;font-weight:bold;">Do you really want to undo void payroll addition / deduction?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="undovoidbtn" type="button" class="btn btn-info">Undo Void</button>
                        <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End undo void modal -->

    <!--Start Reject modal -->
    <div class="modal fade text-left" id="rejectmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectform">
                    @csrf
                    <div class="modal-body" style="background-color:#d9534f">
                        <label strong style="font-size: 14px; color:white;font-weight:bold;">Do you really want to reject payroll addition / deduction?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="rejectId" id="rejectId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="rejectpaybtn" type="button" class="btn btn-info">Reject</button>
                        <button id="closebuttonq" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Reject modal -->

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

    <script type="text/javascript">
        var errorcolor="#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });

        var j=0;
        var i=0;
        var m=0;
        var ctable="";

        var statusTransitions = {
            'Draft': {
                forward: {
                    status: 'Pending',
                    text: 'Change to Pending',
                    action: 'Change to Pending',
                    message: 'Do you really want to pending?',
                    forecolor: '#6e6b7b',
                    backcolor: '#f6c23e'
                }
            },
            'Pending': {
                forward: {
                    status: 'Verified',
                    text: 'Verify',
                    action: 'Verified',
                    message: 'Do you really want to verify?',
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
                    message: 'Do you really want to approve?',
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
                    message: 'Do you really want to approve?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                }
            },
        };

        $(document).ready( function () {
            $('#payrollAddDedDiv').hide();
            $('#filter_div').hide();
            ctable=$('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[0,"desc"]],
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
                    url: '/payrolladdlist',
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
                    { data: 'DocumentNumber', name: 'DocumentNumber',width:"17%"},
                    { data: 'Ptype', name: 'Ptype',width:"17%"},
                    { data: 'BranchName', name: 'BranchName',width:"17%"},
                    { data: 'PayRange', name: 'PayRange',width:"27%"},
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
                        },
                    width:"15%"},
                    { data: 'action', name: 'action',width:"4%"}
                ],
                "initComplete": function () {
                    $('.custom-buttons').html(`
                        @can('Payroll-Addition-Deduction-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addpayrolladd_ded" id="addpayrolladd_ded" data-toggle="modal">Add</button>
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
                    $('#payrollAddDedDiv').show();
                    $('#filter_div').hide();
                },
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
                ctable.column(4).search('^$', true, false).draw(); // Match an impossible pattern
            } else {
                // Options selected: build regex for filtering
                var searchRegex = search.join('|'); // OR-separated values for regex
                ctable.column(4).search(searchRegex, true, false).draw();
            }
        });

        $('body').on('click', '#addpayrolladd_ded', function() {
            $('.mainforminp').val("");
            $('.errordatalabel').html('');
            // $("#orgtree").empty();
            // var treevals="";
            // $.get("/payrolladdep" , function(data) {
            //     treevals='<ul id="treeview" class="hummingbird-base mt-0" style="padding:0px 0px 0px 0px;">';
            //     $.each(data.branchlist, function(brkey, brvalue) {
            //         treevals+='<li data-id="'+brkey+'" class="emparent"><i class="fa fa-plus fa-1x"></i><label style="font-size:14px;"><input class="hummingbird-end-node depheader" id="bra_'+brvalue.branches_id+'" data-id="custom-'+brvalue.branches_id+'" name="branches[]" value="'+brvalue.branches_id+'" type="checkbox"/>  '+brvalue.BranchName+'</label><ul>';
            //         $.each(data.deplist, function(key, value) {
            //             if(parseInt(value.branches_id)==parseInt(brvalue.branches_id)){
            //                 treevals+='<li data-id="'+key+'" class="emparent"><i class="fa fa-plus fa-1x"></i><label style="font-size:14px;"><input class="hummingbird-end-node depheader" id="dep_'+value.departments_id+'" data-id="custom-'+value.departments_id+'" name="depatments[]" value="'+value.departments_id+'" type="checkbox"/>  '+value.DepartmentName+'</label><ul>';
            //                 $.each(data.positionlist, function(pokey,povalue) {
            //                     if(parseInt(value.positions_id)==parseInt(povalue.positions_id) && parseInt(value.departments_id)==parseInt(povalue.departments_id)){
            //                         treevals+='<li data-id="'+pokey+'" class="emparent"><i class="fa fa-plus fa-1x"></i><label style="font-size:14px;"><input class="hummingbird-end-node depheader" id="pos_'+povalue.positions_id+'" data-id="custom-'+povalue.positions_id+'" name="positions[]" value="'+povalue.positions_id+'" type="checkbox"/>  '+povalue.PositionName+'</label><ul>';
            //                         $.each(data.emplist, function(key, empvalue) {
            //                             if(parseInt(value.branches_id)==parseInt(empvalue.branches_id) && parseInt(povalue.positions_id)==parseInt(empvalue.positions_id) && parseInt(value.departments_id)==parseInt(empvalue.departments_id)){
            //                                 treevals+='<li data-id="'+value.departments_id+'" class="attremployee"><label style="font-size:12px;"><input class="hummingbird-end-node emptree department_'+value.departments_id+'" id="'+empvalue.id+'-'+value.departments_id+'" data-id="custom-'+value.departments_id+'-'+empvalue.id+'" name="employees[]" value="'+empvalue.id+'" type="checkbox"/>  '+empvalue.name+'</label></li>';
            //                             }
            //                         });
            //                         treevals+='</ul></li>';
            //                     }
            //                 });
            //                 treevals+='</ul></li>';
            //             }
            //         }); 
            //         treevals+='</ul></li>';
            //     });
            //     treevals+='</ul>';
            //     $("#orgtree").append(treevals);
            // });
            // $("#orgtree").hummingbird();
            // $('#selectalldiv').show();
            $('#recId').val("");
            $('#operationtypes').val("1");

            $('#Type').val(1).select2({
                minimumResultsForSearch: -1
            });
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
            var select2Width = $('#FromMonthRange').outerWidth();
            $('#FromMonthRange').on('select2:opening', function() {
                var longestOptionWidth = 0;
                $(this).find('option').each(function() {
                var optionWidth = $(this).text().length * 10; // Adjust multiplier as needed
                longestOptionWidth = Math.max(longestOptionWidth, optionWidth);
                });

                var finalWidth = Math.max(select2Width, longestOptionWidth);
                $(this).siblings('.select2').css('width', finalWidth + 'px');
            });
            $("#modaltitle").html("Add Payroll Addition / Deduction");
            $('#titlename').html("Addition");
            $('#totalamountlbl').html("Total amount of addition for each employees");
            $('#totalamountTbl').hide();
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        });

        $("#adds").click(function() {
            var type=$('#Type').val();
            var lastrowcount=$('#dynamicTable tr:last').find('td').eq(4).find('input').val();
            var salaryCompoonentId=$('#salarycomp'+lastrowcount).val();
            if(salaryCompoonentId!==undefined && isNaN(parseFloat(salaryCompoonentId))){
                $('#select2-salarycomp'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select salary component from highlighted field","Error");
            }
            else{
                ++i;
                ++m;
                j += 1;
                $("#dynamicTable > tbody").append('<tr><td style="font-weight:bold;text-align:center;width:3%">' +j+'</td>'+
                    '<td style="width:40%"><select id="salarycomp'+m+'" class="select2 form-control salarycomp" onchange="salarycompFn(this)" name="row['+m+'][SalaryComponent]"></select></td>'+
                    '<td style="width:24%"><input type="text" name="row['+m+'][amount]" placeholder="Amount" id="amount'+m+'" class="amount form-control numeral-mask" onkeyup="amountFn(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>'+
                    '<td style="width:30%;"><input type="text" name="row['+m+'][Description]" id="Description'+m+'" class="Description form-control" placeholder="Remark..."/></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td></tr>'
                );
                var defaultOption = '<option selected value=""></option><option value=""></option>';
                var salaryType = $("#SalaryTypeHidd > option").clone();
                $('#salarycomp'+m).append(salaryType);
                if(type==1){
                    $("#salarycomp"+m+" option[title!='Earnings']").remove(); 
                }
                else if(type==2){
                    $("#salarycomp"+m+" option[title!='Deductions']").remove(); 
                }
                for(var k=1;k<=m;k++){
                    if(($('#salarycomp'+k).val())!=undefined){
                        var selectedval=$('#salarycomp'+k).val();
                        $("#salarycomp"+m+" option[value='"+selectedval+"']").remove();   
                    }
                }
                $('#salarycomp'+m).append(defaultOption);
                $('#salarycomp'+m).select2
                ({
                    placeholder: "Select salary component here",
                });
                $('#select2-salarycomp'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                renumberRows();
                CalculateTotalAmount();
            }
        });

        function salarycompFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#select2-salarycomp'+idval+'-container').parent().css('background-color',"white");
        }

        function amountFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#amount'+idval).css("background","white");
            CalculateTotalAmount();
        }

        function CalculateTotalAmount(){
            var amount =0;
            $.each($('#dynamicTable').find('.amount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    amount += parseFloat($(this).val());
                }
            });
            $('#totalamountval').html(numformat(amount.toFixed(2)));
        }

        $('#employeedata').on('change', function() {
            $('.select2-checkbox').each(function() {
                var option = $(this).closest('span').next();
                var isChecked = $(this).prop('checked');
                $('#employeedata').find('option[value="' + option.val() + '"]').prop('selected', isChecked);
            });
            $('#employeedata').trigger('change');
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            CalculateTotalAmount();
            renumberRows();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody tr').each(function(index,el) {
                $(this).children('td').first().text(index+=1);
                ind = index;
            });
            if (ind == 0) {
                $('#totalamountTbl').hide();
            }
            else{
                $('#totalamountTbl').show();
            }
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
            $('#orgtree').hummingbird('expandAll');

            if(text!=null && text!=""){
                $('#selectalldiv').hide();
            }
            else if(text=="" || text===""){
                $('#selectalldiv').show();
                $('#orgtree').hummingbird('collapseAll');
            }
        });

        $('#button-addon').click(function(){
            $('#SearchEmployee').val("");
            $('#selectalldiv').show();
            $('.attremployee').show();
            $('#orgtree').hummingbird('collapseAll');
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
       
        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/savePayrollAdd',
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
                        if (data.errors.Type) {
                            $('#type-error').html(data.errors.Type[0]);
                        }
                        if (data.errors.Branch) {
                            $('#branch-error').html(data.errors.Branch[0]);
                        }
                        if (data.errors.Department) {
                            $('#department-error').html(data.errors.Department[0]);
                        }
                        if (data.errors.Position) {
                            $('#position-error').html(data.errors.Position[0]);
                        }
                        if (data.errors.Employee) {
                            $('#employee-error').html(data.errors.Employee[0]);
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
                    else if (data.errorv2) {
                        for(var k=1;k<=m;k++){
                            var amount=($('#amount'+k)).val();
                            var salarycomp=($('#salarycomp'+k)).val();

                            if(($('#salarycomp'+k).val())!=undefined){
                                if(salarycomp==""||salarycomp==null){
                                    $('#select2-salarycomp'+k+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#amount'+k).val())!=undefined){
                                if(amount==""||amount==null){
                                    $('#amount'+k).css("background", errorcolor);
                                }
                            }
                        }
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }
                    else if(data.emptyerror)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"You should add atleast one salary component","Error");
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

        $('#approvepaybtn').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#approveform");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/approvePayrollAddDed',
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
                    $('#approvepaybtn').text('Approving...');
                    $('#approvepaybtn').prop("disabled", true);
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
                        $('#approvepaybtn').text('Approve');
                        $('#approvepaybtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    
                    else if(data.success){
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#approvemodal").modal('hide');
                        $("#informationmodal").modal('hide');
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
                url: '/voidPayrollAddDed',
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
                url: '/undovoidPayrollAddDed',
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

        $('#rejectpaybtn').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#rejectform");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/rejectPayrollAddDed',
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
                    $('#rejectpaybtn').text('Rejecting...');
                    $('#rejectpaybtn').prop("disabled", true);
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
                        $('#rejectpaybtn').text('Reject');
                        $('#rejectpaybtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#rejectmodal").modal('hide');
                        $("#informationmodal").modal('hide');
                    }
                }
            });
        });

        function payrolladdeditFn(recordId) { 
            $('.select2').select2();
            $("#operationtypes").val("2");
            $("#recId").val(recordId);
            var employeeData=[];
            j=0;
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
                    $('#Department').empty();
                    $('#Position').empty();
                    $('#Employee').empty();
                    $('#selectAll').prop('checked',false); 
                    employeeData=[];
                    $.each(data.payrolladd, function(key, value) {
                        $('#Type').val(value.type).trigger('change').select2({
                                minimumResultsForSearch: -1
                            }
                        );
                        $('#Branch').val(value.branches_id).select2();
                        
                        var departmentOption = $("#DepartmentHidd > option").clone();
                        $('#Department').append(departmentOption);
                        $("#Department option[title!='"+value.branches_id+"']").remove();
                        $("#Department option[value='"+value.departments_id+"']").remove();
                        $('#Department').append('<option selected value='+value.departments_id+'>'+value.DepartmentName+'</option>');
                    
                        var positionOption = $("#PositionHidd > option").clone();
                        $('#Position').append(positionOption);
                        $("#Position option[title!='"+value.departments_id+"']").remove();
                        $("#Position option[value='"+value.positions_id+"']").remove();
                        $('#Position').append('<option selected value='+value.positions_id+'>'+value.PositionName+'</option>');

                        var employeeOption = $("#EmployeeHidd > option").clone();
                        $('#Employee').append(employeeOption);
                        $("#Employee option[title!='"+value.positions_id+"']").remove();
                        $("#Employee option[label!='"+value.branches_id+"']").remove();

                        $('#FromMonthRange').val(value.PayRangeFrom).trigger('change').select2();
                        $('#ToMonthRange').val(value.PayRangeTo).trigger('change').select2();
                        $('#Remark').val(value.Remark);
                    });

                    $.each(data.empdata, function(key, value) {
                        $("#Employee option[value='"+value.employees_id+"']").remove();
                        employeeData.push('<option selected value='+value.employees_id+'>'+value.name+'</option>');
                    });
                    $('#Employee').append(employeeData);

                    $.each(data.saldata, function(key, value) {
                        ++i;
                        ++m;
                        j += 1;
                        $("#dynamicTable > tbody").append('<tr><td style="font-weight:bold;text-align:center;width:3%">' +j+'</td>'+
                            '<td style="width:40%"><select id="salarycomp'+m+'" class="select2 form-control salarycomp" onchange="salarycompFn(this)" name="row['+m+'][SalaryComponent]"></select></td>'+
                            '<td style="width:24%"><input type="text" name="row['+m+'][amount]" placeholder="Amount" id="amount'+m+'" class="amount form-control numeral-mask" onkeyup="amountFn(this)" value="'+value.Amount+'" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>'+
                            '<td style="width:30%;"><input type="text" name="row['+m+'][Description]" id="Description'+m+'" class="Description form-control" value="'+value.PdetailRemark+'" placeholder="Remark..."/></td>'+
                            '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td></tr>'
                        );
                        var defaultOption = '<option selected value='+value.salarytypes_id+'>'+value.SalaryTypeName+'</option>';
                        var salaryType = $("#SalaryTypeHidd > option").clone();
                        $('#salarycomp'+m).append(salaryType);
                        $("#salarycomp"+m+" option[value='"+value.salarytypes_id+"']").remove();
                        if(value.type==1){
                            $("#salarycomp"+m+" option[title!='Earnings']").remove(); 
                        }
                        else if(value.type==2){
                            $("#salarycomp"+m+" option[title!='Deductions']").remove(); 
                        }
                        for(var k=1;k<=m;k++){
                            if(($('#salarycomp'+k).val())!=undefined){
                                var selectedval=$('#salarycomp'+k).val();
                                $("#salarycomp"+m+" option[value='"+selectedval+"']").remove();   
                            }
                        }
                        $('#salarycomp'+m).append(defaultOption);
                        $('#salarycomp'+m).select2
                        ({
                            placeholder: "Select salary component here",
                        });
                        $('#select2-salarycomp'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    });
                    renumberRows();
                    CalculateTotalAmount();
                }
            });

            $("#modaltitle").html("Edit Payroll Addition / Deduction");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').hide();
            $("#inlineForm").modal('show'); 
        }

        function payrollAddDedInfoFn(recordId) { 
            $("#recInfoId").val(recordId);
            var forecolor = "";
            var lidata = "";
            $(".actionpropbtn").hide();
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
                        $('#payrollIdInfoLbl').html(value.DocumentNumber);
                        $('#typeInfoLbl').html(value.PType);
                        $('#branchInfoLbl').html(value.BranchName);
                        $('#departmentInfoLbl').html(value.DepartmentName);
                        $('#positionInfoLbl').html(value.PositionName);
                        $('#payrangeInfoLbl').html(value.PayRange+"  <i>("+value.FirstDayofMonth+"   to   "+value.LastDayofMonth+")</i>");
                        $('#remarkInfoLbl').html(value.Remark);

                        $('#currentStatus').val(value.Status);

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
                    $("#actiondiv").empty();
                    $('#actiondiv').append(lidata);
                }
            });

            $('#employeetablelist').DataTable({
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
                        width:"32%"
                    },
                    {
                        data: 'name',
                        name: 'name',
                        width:"33%"
                    },
                    {
                        data: 'EmployeePhone',
                        name: 'EmployeePhone',
                        width:"32%"
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
                        width:"32%"
                    },
                    {
                        data: 'Amount',
                        name: 'Amount',
                        width:"25%"
                    },
                    {
                        data: 'PdetailRemark',
                        name: 'PdetailRemark',
                        width:"40%"
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
                url: '/payrollAddDedForwardAction',
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
                url: '/payrollAddDedBackwardAction',
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

        function getApproveInfo()
        {
            var rid=$('#recInfoId').val();
            $('#appId').val(rid);
            $('#approvemodal').modal('show');
            $('#approvepaybtn').text("Approve");
            $('#approvepaybtn').prop("disabled", false );
        }

        function getRejectInfo()
        {
            var rid=$('#recInfoId').val();
            $('#rejectId').val(rid);
            $('#rejectmodal').modal('show');
            $('#rejectpaybtn').text("Reject");
            $('#rejectpaybtn').prop( "disabled", false );
        }

        function overtimeDeleteFn(recordId) { 
            var overtimeval=0;
            $("#delRecId").val(recordId);
            $.get("/showOvertime"+'/'+recordId , function(data) {
                overtimeval=data.countdata;
                if(parseInt(overtimeval)>=1){
                    toastrMessage('error',"Unable to delete overtime level, because other record has been made based on this overtime level","Error");
                }
                else if(parseInt(overtimeval)==0){
                    $('#deleterecbtn').text('Delete');
                    $('#deleterecbtn').prop("disabled", false);
                    $("#deletemodal").modal('show');
                }
            });
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
        }

        function remarkFn() {
            $('#remark-error').html('');
        }

        function typeFn() {
            var type=$('#Type').val();
            if(type==1){
                $('#titlename').html("Addition");
                $('#totalamountlbl').html("Total amount of addition for each employees");
            }
            else if(type==2){
                $('#titlename').html("Deduction");
                $('#totalamountlbl').html("Total amount of deduction for each employees");
                
            }
            $('#dynamicTable > tbody').empty();
            $('#totalamountval').html('');
            $('#totalamountTbl').hide();
            j=0;
            $('#type-error').html('');
        }

        function branchFn() {
            var branchId=$('#Branch').val();
            var defOption='<option selected disabled value=""></option>';
            var departmentOption = $("#DepartmentHidd > option").clone();
            $('#Department').empty();
            $('#Department').append(departmentOption);
            $("#Department option[title!='"+branchId+"']").remove();
            $('#Department').append(defOption);
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
            $('#branch-error').html('');
        }

        function departmentFn() {
            var departmentId=$('#Department').val();
            var defOption='<option selected disabled value=""></option>';
            var positionOption = $("#PositionHidd > option").clone();
            $('#Position').empty();
            $('#Position').append(positionOption);
            $("#Position option[title!='"+departmentId+"']").remove();
            $('#Position').append(defOption);
            $('#Position').select2({
                placeholder:"Select position here"
            });
            $('#Employee').empty();
            $('#Employee').select2({
                placeholder:"Select position first"
            });
            $('#department-error').html('');
        }

        function positionFn() {
            var positionId=$('#Position').val();
            var branchId=$('#Branch').val();
            var defOption='<option selected disabled value=""></option>';
            var employeeOption = $("#EmployeeHidd > option").clone();

            $('#Employee').empty();
            $('#Employee').append(employeeOption);
            $("#Employee option[title!='"+positionId+"']").remove();
            $("#Employee option[label!='"+branchId+"']").remove();
            $('#Employee').append(defOption);
            $('#Employee').select2({
                placeholder:"Select employee here"
            });
            $('#position-error').html('');
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
            $.ajax({
                url: '/getFromMonthRange',
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
                    $('#grgEndDate').html("");
                }
            });

            var defOption='<option selected disabled value=""></option>';
            var toMonthRangeOption = $("#ToMonthRangeHidd > option").clone();

            $('#ToMonthRange').empty();
            $('#ToMonthRange').append(toMonthRangeOption);

            $('#ToMonthRange option').each(function() {
                if ($(this).val() < fromMonthRangeId) {
                    $(this).remove();
                }
            });

            $('#ToMonthRange').append(defOption);
            $('#ToMonthRange').select2({
                placeholder:"Select to pay range"
            });
            $('#monthrange-error').html('');
        }

        function toMonthRangeFn() {
            var toMonthRangeId=$('#ToMonthRange').val();
            var toMonRange=null;
            $.ajax({
                url: '/getToMonthRange',
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
                }
            });
            $('#monthrange-error').html('');
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
